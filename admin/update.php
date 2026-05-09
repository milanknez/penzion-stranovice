<?php
require_once 'config.php';

// Security check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('HTTP/1.1 403 Forbidden');
    exit('Unauthorized');
}

$action = $_GET['action'] ?? 'check';
$response = ['status' => 'success', 'message' => ''];

// Parse REPO_URL to get GitHub URLs
$repoUrl = REPO_URL;
$repoClean = str_replace('.git', '', $repoUrl);
$repoParts = explode('github.com/', $repoClean);

if (count($repoParts) < 2) {
    $response = ['status' => 'error', 'message' => 'Invalid REPO_URL in config.php. Must be a GitHub URL.'];
    echo json_encode($response);
    exit;
}

$repoPath = $repoParts[1]; // e.g. "milanknez/penzion-stranovice"
$branch = 'main';

$githubVersionUrl = "https://raw.githubusercontent.com/$repoPath/$branch/admin/version.php?t=" . time();
$githubZipUrl = "https://github.com/$repoPath/archive/refs/heads/$branch.zip";

if ($action === 'check') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $githubVersionUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, 'FidaCMS-UpdateChecker');
    $remoteVersionFile = curl_exec($ch);
    curl_close($ch);

    if ($remoteVersionFile && preg_match("/define\('APP_VERSION', '(.*?)'\)/", $remoteVersionFile, $matches)) {
        $remoteVersion = $matches[1];
        if (version_compare($remoteVersion, APP_VERSION, '>')) {
            $response['updates_available'] = true;
            $response['message'] = "Nová verze $remoteVersion je k dispozici!";
            $response['version'] = $remoteVersion;
        } else {
            $response['updates_available'] = false;
            $response['message'] = 'Máte aktuální verzi.';
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Nepodařilo se ověřit verzi na GitHubu.'];
    }
} elseif ($action === 'pull') {
    // Download ZIP
    $zipFile = 'update_temp.zip';
    
    // Set up context for file_get_contents to handle potential redirects and timeouts
    $ctx = stream_context_create([
        'http' => ['timeout' => 30, 'follow_location' => 1]
    ]);
    
    $content = @file_get_contents($githubZipUrl, false, $ctx);
    
    if (!$content) {
        $response = ['status' => 'error', 'message' => 'Nepodařilo se stáhnout aktualizační balíček z ' . $githubZipUrl];
    } else {
        file_put_contents($zipFile, $content);
        
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            $tempFolder = 'update_extract_temp/';
            if (!is_dir($tempFolder)) mkdir($tempFolder, 0755, true);
            $zip->extractTo($tempFolder);
            $zip->close();
            
            // GitHub ZIPs contain a root folder like "penzion-stranovice-main"
            // We need to find this folder name
            $extractedDirs = array_filter(glob($tempFolder . '*'), 'is_dir');
            $sourceDir = reset($extractedDirs);
            
            if ($sourceDir && is_dir($sourceDir)) {
                // Recursive function to copy files
                if (!function_exists('copyRecursive')) {
                    function copyRecursive($src, $dst, $exclude = []) {
                        $dir = opendir($src);
                        @mkdir($dst);
                        while(false !== ( $file = readdir($dir)) ) {
                            if (( $file != '.' ) && ( $file != '..' )) {
                                $srcFile = $src . '/' . $file;
                                $dstFile = $dst . '/' . $file;
                                
                                // Check exclusion
                                $isExcluded = false;
                                foreach ($exclude as $ex) {
                                    if (strpos($dstFile, $ex) !== false) {
                                        $isExcluded = true;
                                        break;
                                    }
                                }
                                if ($isExcluded) continue;

                                if ( is_dir($srcFile) ) {
                                    copyRecursive($srcFile, $dstFile, $exclude);
                                } else {
                                    copy($srcFile, $dstFile);
                                }
                            }
                        }
                        closedir($dir);
                    }
                }

                // Exclude local config to prevent overwriting settings
                $exclude = [
                    'admin/config.php',
                    '.git'
                ];
                
                $rootDir = realpath(__DIR__ . '/../');
                copyRecursive($sourceDir, $rootDir, $exclude);
                
                // Cleanup
                if (!function_exists('rrmdir')) {
                    function rrmdir($dir) {
                        if (is_dir($dir)) {
                            $objects = scandir($dir);
                            foreach ($objects as $object) {
                                if ($object != "." && $object != "..") {
                                    if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                                        rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                                    else
                                        unlink($dir. DIRECTORY_SEPARATOR .$object);
                                }
                            }
                            rmdir($dir);
                        }
                    }
                }
                rrmdir($tempFolder);
                unlink($zipFile);

                
                $response['message'] = 'Aktualizace proběhla úspěšně! Všechny soubory byly aktualizovány kromě admin/config.php.';
            } else {
                $response = ['status' => 'error', 'message' => 'V archivu nebyla nalezena zdrojová složka.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Nepodařilo se otevřít ZIP archiv (chybí rozšíření ZipArchive?).'];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;


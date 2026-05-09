<?php
/**
 * Emergency Update v2 - with permission fix
 * DELETE THIS FILE AFTER USE!
 */
set_time_limit(120);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$repo = 'milanknez/penzion-stranovice';
$branch = 'main';
$zipUrl = "https://github.com/$repo/archive/refs/heads/$branch.zip";
$zipFile = __DIR__ . '/update_temp.zip';
$tempFolder = __DIR__ . '/update_extract_temp/';

echo "<pre>";
echo "=== EMERGENCY UPDATE v2 ===\n\n";

// 1. Download ZIP
echo "1. Downloading ZIP from GitHub...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $zipUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_USERAGENT, 'FidaCMS-EmergencyUpdate');
$content = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if (!$content || $httpCode !== 200) {
    die("FAILED: HTTP $httpCode\n");
}
file_put_contents($zipFile, $content);
echo "   Downloaded " . strlen($content) . " bytes\n";

// 2. Extract
echo "2. Extracting...\n";
$zip = new ZipArchive;
if ($zip->open($zipFile) !== TRUE) die("FAILED: Cannot open ZIP\n");
if (!is_dir($tempFolder)) mkdir($tempFolder, 0755, true);
$zip->extractTo($tempFolder);
$zip->close();

$extractedDirs = array_filter(glob($tempFolder . '*'), 'is_dir');
$sourceDir = reset($extractedDirs);
if (!$sourceDir) die("FAILED: No source dir\n");

// 3. Copy with permission fix
echo "3. Copying files...\n";
$copied = 0;
$failed = 0;
$failedFiles = [];

function smartCopy($src, $dst) {
    // Try chmod first
    if (file_exists($dst)) {
        @chmod($dst, 0666);
    }
    
    // Try copy
    if (@copy($src, $dst)) return true;
    
    // Fallback: read content and write
    $content = file_get_contents($src);
    if ($content !== false) {
        // Try to delete and recreate
        @unlink($dst);
        if (@file_put_contents($dst, $content) !== false) {
            @chmod($dst, 0644);
            return true;
        }
    }
    return false;
}

function copyRecursive($src, $dst, &$copied, &$failed, &$failedFiles) {
    $dir = opendir($src);
    if (!is_dir($dst)) @mkdir($dst, 0755, true);
    while (false !== ($file = readdir($dir))) {
        if ($file === '.' || $file === '..') continue;
        $srcFile = $src . '/' . $file;
        $dstFile = $dst . '/' . $file;
        $rel = str_replace('\\', '/', $dstFile);
        if (strpos($rel, 'admin/config.php') !== false || strpos($rel, '.git') !== false) continue;

        if (is_dir($srcFile)) {
            copyRecursive($srcFile, $dstFile, $copied, $failed, $failedFiles);
        } else {
            if (smartCopy($srcFile, $dstFile)) {
                $copied++;
            } else {
                $failed++;
                $failedFiles[] = $dstFile;
            }
        }
    }
    closedir($dir);
}

$rootDir = __DIR__;
copyRecursive($sourceDir, $rootDir, $copied, $failed, $failedFiles);
echo "   Copied: $copied, Failed: $failed\n";
if ($failed > 0) {
    echo "   Failed files:\n";
    foreach ($failedFiles as $f) echo "   - $f\n";
}

// 4. Cleanup
echo "4. Cleaning up...\n";
function rrmdir($dir) {
    if (is_dir($dir)) {
        foreach (scandir($dir) as $obj) {
            if ($obj !== '.' && $obj !== '..') {
                $path = $dir . DIRECTORY_SEPARATOR . $obj;
                is_dir($path) ? rrmdir($path) : unlink($path);
            }
        }
        rmdir($dir);
    }
}
rrmdir($tempFolder);
if (file_exists($zipFile)) unlink($zipFile);

if (file_exists(__DIR__ . '/admin/version.php')) {
    include __DIR__ . '/admin/version.php';
    echo "\nNEW VERSION: " . APP_VERSION . "\n";
}
echo "\n=== DONE ===\nDELETE THIS FILE NOW!\n</pre>";

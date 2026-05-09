<?php
/**
 * Emergency Update Script - upload this file directly to the server root via FTP
 * Navigate to: http://fidamedia.cz/w1/emergency_update.php
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
echo "=== EMERGENCY UPDATE ===\n\n";

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
$error = curl_error($ch);
curl_close($ch);

if (!$content || $httpCode !== 200) {
    die("FAILED: HTTP $httpCode, Error: $error\n");
}

file_put_contents($zipFile, $content);
echo "   Downloaded " . strlen($content) . " bytes (HTTP $httpCode)\n";

// 2. Extract
echo "2. Extracting ZIP...\n";
if (!class_exists('ZipArchive')) {
    die("FAILED: ZipArchive extension is not available!\n");
}

$zip = new ZipArchive;
if ($zip->open($zipFile) !== TRUE) {
    die("FAILED: Cannot open ZIP file\n");
}

if (!is_dir($tempFolder)) mkdir($tempFolder, 0755, true);
$zip->extractTo($tempFolder);
$zip->close();
echo "   Extracted successfully\n";

// 3. Find source directory
$extractedDirs = array_filter(glob($tempFolder . '*'), 'is_dir');
$sourceDir = reset($extractedDirs);

if (!$sourceDir || !is_dir($sourceDir)) {
    die("FAILED: No source directory found in ZIP\n");
}
echo "   Source: $sourceDir\n";

// 4. Copy files (exclude config.php)
echo "3. Copying files...\n";
$copied = 0;
$skipped = 0;

function copyRecursive($src, $dst, &$copied, &$skipped) {
    $dir = opendir($src);
    if (!is_dir($dst)) @mkdir($dst, 0755, true);
    while (false !== ($file = readdir($dir))) {
        if ($file === '.' || $file === '..') continue;
        $srcFile = $src . '/' . $file;
        $dstFile = $dst . '/' . $file;

        // Skip config.php and .git
        $rel = str_replace('\\', '/', $dstFile);
        if (strpos($rel, 'admin/config.php') !== false || strpos($rel, '.git') !== false) {
            $skipped++;
            continue;
        }

        if (is_dir($srcFile)) {
            copyRecursive($srcFile, $dstFile, $copied, $skipped);
        } else {
            copy($srcFile, $dstFile);
            $copied++;
        }
    }
    closedir($dir);
}

$rootDir = __DIR__;
copyRecursive($sourceDir, $rootDir, $copied, $skipped);
echo "   Copied: $copied files, Skipped: $skipped\n";

// 5. Cleanup
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
echo "   Done!\n\n";

// 6. Check new version
if (file_exists(__DIR__ . '/admin/version.php')) {
    include __DIR__ . '/admin/version.php';
    echo "NEW VERSION: " . APP_VERSION . "\n";
}

echo "\n=== UPDATE COMPLETE ===\n";
echo "DELETE THIS FILE NOW: emergency_update.php\n";
echo "</pre>";

<?php
/**
 * Nginx config helper - adds try_files rule for /w1/
 * DELETE THIS FILE AFTER USE!
 */
set_time_limit(30);
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>";
echo "=== NGINX CONFIG HELPER ===\n\n";

// Find nginx config
$possibleConfigs = [
    '/etc/nginx/sites-available/fidamedia.cz',
    '/etc/nginx/sites-available/fidamedia',
    '/etc/nginx/sites-available/default',
    '/etc/nginx/conf.d/fidamedia.cz.conf',
    '/etc/nginx/conf.d/default.conf',
];

echo "1. Looking for nginx config...\n";

// Also scan directories
$found = [];
foreach (['/etc/nginx/sites-enabled/', '/etc/nginx/sites-available/', '/etc/nginx/conf.d/'] as $dir) {
    if (is_dir($dir)) {
        foreach (scandir($dir) as $f) {
            if ($f !== '.' && $f !== '..') {
                $found[] = $dir . $f;
            }
        }
    }
}

echo "   Found configs:\n";
foreach ($found as $f) {
    $isLink = is_link($f);
    $target = $isLink ? ' -> ' . readlink($f) : '';
    echo "   - $f$target\n";
}

// Try to read each
echo "\n2. Reading config contents...\n";
foreach ($found as $f) {
    $realFile = is_link($f) ? readlink($f) : $f;
    $content = @file_get_contents($realFile);
    if ($content && strpos($content, 'fidamedia') !== false) {
        echo "   Config file: $realFile\n";
        echo "   ---\n";
        echo $content;
        echo "\n   ---\n";
        
        // Check if try_files already exists for /w1/
        if (strpos($content, 'location /w1/') !== false) {
            echo "\n   /w1/ location block ALREADY EXISTS.\n";
        } else {
            echo "\n   /w1/ location block NOT FOUND - needs to be added.\n";
            echo "   Attempting to add it...\n";
            
            // Find the last } in the server block and insert before it
            // Add the location block before the last closing brace
            $rule = "\n    location /w1/ {\n        try_files \$uri \$uri/ /w1/router.php?\$query_string;\n    }\n";
            
            // Insert before the last }
            $lastBrace = strrpos($content, '}');
            if ($lastBrace !== false) {
                $newContent = substr($content, 0, $lastBrace) . $rule . substr($content, $lastBrace);
                
                if (@file_put_contents($realFile, $newContent)) {
                    echo "   SUCCESS: Rule added!\n";
                    echo "   Testing nginx config...\n";
                    $testOutput = shell_exec('sudo nginx -t 2>&1');
                    echo "   $testOutput\n";
                    if (strpos($testOutput, 'successful') !== false) {
                        shell_exec('sudo systemctl reload nginx 2>&1');
                        echo "   Nginx reloaded!\n";
                    } else {
                        // Revert
                        file_put_contents($realFile, $content);
                        echo "   REVERTED: Config was invalid, restored original.\n";
                    }
                } else {
                    echo "   FAILED: Cannot write to config file (permission denied).\n";
                    echo "   You need to run this command manually via SSH:\n\n";
                    echo "   sudo bash -c 'cat >> $realFile << EOF\n$rule\nEOF'\n";
                    echo "   sudo nginx -t && sudo systemctl reload nginx\n";
                }
            }
        }
        break;
    }
}

echo "\n=== DONE ===\nDELETE THIS FILE!\n</pre>";

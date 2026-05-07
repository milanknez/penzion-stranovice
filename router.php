<?php
require_once 'includes/CMS.php';

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$slug = trim($path, '/');

// Support PHP built-in server: serve existing files directly
if (php_sapi_name() === 'cli-server') {
    $fullPath = __DIR__ . $path;
    if (file_exists($fullPath)) {
        if (is_file($fullPath)) return false;
        if (is_dir($fullPath) && file_exists($fullPath . '/index.php')) {
            require $fullPath . '/index.php';
            return true;
        }
    }
}


$pages = CMS::getPagesConfig();
$found = false;

foreach ($pages as $file => $config) {
    if (isset($config['slug']) && $config['slug'] === $slug && $slug !== '') {
        require $file;
        $found = true;
        break;
    }
}

if (!$found) {
    if (empty($slug)) {
        require 'index.php';
    } else if (file_exists($slug . '.php')) {
        require $slug . '.php';
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "404 - Stránka nenalezena";
    }
}

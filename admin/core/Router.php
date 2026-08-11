<?php
/**
 * Core CMSRouter Engine
 */
require_once __DIR__ . '/Bootstrap.php';
require_once __DIR__ . '/../includes/CMS.php';

class CMSRouter {
    public static function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri = rawurldecode($uri);
        
        // Static assets fallback
        if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg|woff2?|ttf|eot)$/i', $uri)) {
            $filePath = CMS_ROOT . $uri;
            if (file_exists($filePath)) {
                $mimeTypes = [
                    'css'  => 'text/css',
                    'js'   => 'application/javascript',
                    'png'  => 'image/png',
                    'jpg'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'gif'  => 'image/gif',
                    'svg'  => 'image/svg+xml',
                    'ico'  => 'image/x-icon',
                    'woff' => 'font/woff',
                    'woff2'=> 'font/woff2'
                ];
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                header('Content-Type: ' . ($mimeTypes[$ext] ?? mime_content_type($filePath)));
                readfile($filePath);
                exit;
            }
        }

        $rawSlug = ltrim($uri, '/');
        if (empty($rawSlug)) {
            $rawSlug = 'index.php';
        }

        // Clean slug without extension
        $cleanSlug = str_replace('.php', '', $rawSlug);

        // Check mapping in config/pages.json
        $pagesConfig = CMS::getPagesConfig();
        $targetFile = null;

        foreach ($pagesConfig as $file => $info) {
            $pageSlug = $info['slug'] ?? '';
            $fileNoExt = str_replace('.php', '', $file);
            if ($cleanSlug === $pageSlug || $cleanSlug === $fileNoExt || $rawSlug === $file) {
                $targetFile = $file;
                break;
            }
        }

        if (!$targetFile) {
            $targetFile = $cleanSlug . '.php';
        }

        // Locations to look for template
        $locations = [
            CMS_ROOT . '/pages/' . $targetFile,
            CMS_ROOT . '/' . $targetFile,
            CMS_ROOT . '/pages/' . $rawSlug,
            CMS_ROOT . '/' . $rawSlug
        ];

        foreach ($locations as $file) {
            if (file_exists($file) && is_file($file)) {
                require $file;
                exit;
            }
        }

        // Fallback to 404
        http_response_code(404);
        if (file_exists(CMS_ROOT . '/pages/404.php')) {
            require CMS_ROOT . '/pages/404.php';
        } else {
            echo "<h1>404 Stránka nenalezena</h1>";
        }
        exit;
    }
}

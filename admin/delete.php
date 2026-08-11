<?php
@ini_set('display_errors', '0');
error_reporting(0);

require_once 'config.php';

// Security check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $page = $data['page'] ?? null;

    if (!$page || $page === 'index.php') {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['status' => 'error', 'message' => 'Invalid page']);
        exit;
    }

    $targetFile = ROOT_DIR . ltrim($page, '/');
    $filePath = realpath($targetFile) ?: $targetFile;
    $basePath = realpath(ROOT_DIR) ?: ROOT_DIR;

    if (!file_exists($filePath)) {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['status' => 'error', 'message' => 'Soubor neexistuje.']);
        exit;
    }

    // Adjust write/delete permissions if needed
    @chmod(dirname($filePath), 0777);
    @chmod($filePath, 0777);

    // Empty out file contents first in case unlink is blocked
    @file_put_contents($filePath, '');

    $deleted = @unlink($filePath);
    if (!$deleted && file_exists($filePath)) {
        // Fallback: system command
        @exec('rm -f ' . escapeshellarg($filePath));
        $deleted = !file_exists($filePath);
    }

    if ($deleted) {
        $pagesPath = ROOT_DIR . 'config/pages.json';
        if (file_exists($pagesPath)) {
            $pages = json_decode(file_get_contents($pagesPath), true);
            if (isset($pages[$page])) {
                unset($pages[$page]);
                file_put_contents($pagesPath, json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }

        require_once __DIR__ . '/includes/CMS.php';
        CMS::gitCommit("Delete page: $page");
        
        echo json_encode(['status' => 'success', 'message' => "Stránka $page byla odstraněna."]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['status' => 'error', 'message' => 'Chyba při mazání souboru (nedostatečná oprávnění).']);
    }
    exit;
}

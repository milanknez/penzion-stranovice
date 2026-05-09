<?php
require_once 'config.php';

// Security check
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('HTTP/1.1 403 Forbidden');
    exit('Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $page = $data['page'] ?? null;

    if (!$page || $page === 'index.php') {
        header('HTTP/1.1 400 Bad Request');
        exit('Invalid page');
    }

    $filePath = realpath(ROOT_DIR . $page);
    $basePath = realpath(ROOT_DIR);

    // Safety: Ensure we stay within root and don't delete system files
    if (strpos($filePath, $basePath) !== 0 || !file_exists($filePath)) {
        header('HTTP/1.1 403 Forbidden');
        exit('Invalid path');
    }

    // 1. Delete the file
    if (unlink($filePath)) {
        // 2. Remove from pages.json
        $pagesPath = ROOT_DIR . 'config/pages.json';
        if (file_exists($pagesPath)) {
            $pages = json_decode(file_get_contents($pagesPath), true);
            if (isset($pages[$page])) {
                unset($pages[$page]);
                file_put_contents($pagesPath, json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }

        // 3. Auto-commit
        require_once ROOT_DIR . 'includes/CMS.php';
        CMS::gitCommit("Delete page: $page");
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => "Stránka $page byla odstraněna."]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['status' => 'error', 'message' => 'Chyba při mazání souboru.']);
    }
    exit;
}
?>

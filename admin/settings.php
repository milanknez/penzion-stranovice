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

    if (!$data) {
        header('HTTP/1.1 400 Bad Request');
        exit('Invalid data');
    }

    $sitePath = ROOT_DIR . 'config/site.json';
    $site = [];
    if (file_exists($sitePath)) {
        $site = json_decode(file_get_contents($sitePath), true);
    }

    // Update global settings
    if (isset($data['site_name'])) $site['site_name'] = $data['site_name'];
    if (isset($data['error_page_404'])) $site['error_page_404'] = $data['error_page_404'];
    
    // Auto-commit if enabled
    if (file_put_contents($sitePath, json_encode($site, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        require_once ROOT_DIR . 'includes/CMS.php';
        CMS::gitCommit("Update global site settings");
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Globální nastavení bylo uloženo.']);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['status' => 'error', 'message' => 'Chyba při zápisu do site.json.']);
    }
    exit;
}
?>

<?php
header('Content-Type: application/json');

function getBasePath() {
    $base = str_replace(['/includes/CMS.php', '/admin/save.php', '/admin/index.php', '/router.php', '/index.php', '/debug_url.php'], '', $_SERVER['SCRIPT_NAME'] ?? '');
    return rtrim($base, '/');
}

echo json_encode([
    'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? 'N/A',
    'getBasePath_manual' => getBasePath(),
    'test_url' => getBasePath() . '/ustajeni-koni',
], JSON_PRETTY_PRINT);

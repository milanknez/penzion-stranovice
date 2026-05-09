<?php
header('Content-Type: application/json');
require_once 'includes/CMS.php';
echo json_encode([
    'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? 'N/A',
    'getBasePath_detected' => CMS::getBasePath(),
    'url_ustajeni_test' => CMS::url('ustajeni.php'),
], JSON_PRETTY_PRINT);

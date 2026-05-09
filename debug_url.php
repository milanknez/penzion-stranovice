<?php
header('Content-Type: application/json');
require_once 'includes/CMS.php';
echo json_encode([
    'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'],
    'REQUEST_URI' => $_SERVER['REQUEST_URI'],
    'getBasePath' => CMS::getBasePath(),
    'url_index' => CMS::url('index.php'),
    'url_ustajeni' => CMS::url('ustajeni.php'),
    'APP_VERSION' => APP_VERSION
], JSON_PRETTY_PRINT);

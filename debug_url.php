<?php
header('Content-Type: application/json');
echo json_encode([
    'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? 'N/A',
    'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
    'PHP_SELF' => $_SERVER['PHP_SELF'] ?? 'N/A',
    'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
    'SCRIPT_FILENAME' => $_SERVER['SCRIPT_FILENAME'] ?? 'N/A',
], JSON_PRETTY_PRINT);

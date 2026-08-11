<?php
$file = $_GET['file'] ?? '';
if (empty($file)) {
    http_response_code(400);
    exit('Missing file parameter');
}

$fileBasename = basename($file);
$candidates = [
    '/tmp/downloaded_assets/' . $fileBasename,
    __DIR__ . '/js/' . $fileBasename,
    __DIR__ . '/css/' . $fileBasename,
    __DIR__ . '/fonts/' . $fileBasename,
];

$target = null;
foreach ($candidates as $candidate) {
    if (file_exists($candidate) && filesize($candidate) > 0) {
        $target = $candidate;
        break;
    }
}

$cdnUrls = [
    'tailwindcss.min.js' => 'https://cdn.tailwindcss.com',
    'grapes.min.js' => 'https://unpkg.com/grapesjs',
    'lucide.min.js' => 'https://unpkg.com/lucide@latest'
];

if ($target !== null) {
    if (filesize($target) < 100 && isset($cdnUrls[$fileBasename])) {
        header('Location: ' . $cdnUrls[$fileBasename]);
        exit;
    }
    $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'svg' => 'image/svg+xml',
        'otf' => 'font/otf'
    ];
    header('Content-Type: ' . ($mimeTypes[$ext] ?? 'application/octet-stream'));
    header('Content-Length: ' . filesize($target));
    header('Cache-Control: public, max-age=86400');
    readfile($target);
    exit;
}

http_response_code(404);
echo "Asset not found";

<?php
if (!defined('ROOT_DIR') && !defined('APP_VERSION')) {
    require_once __DIR__ . '/../../admin/includes/CMS.php';
}
$meta = CMS::getPageMeta();
$siteConfig = CMS::getSiteConfig();
$siteName = $siteConfig['site_name'] ?? 'Statek Straňovice';
?>
<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta['title'] ?? $siteName) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta['description'] ?? '') ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between">
    <header class="bg-slate-900 border-b border-white/10 px-6 py-4 flex items-center justify-between">
        <a href="index.php" class="text-lg font-bold text-white"><?= htmlspecialchars($siteName) ?></a>
        <a href="admin/" class="text-xs bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-4 py-2 rounded-xl">Admin CMS</a>
    </header>
    <main class="flex-1">

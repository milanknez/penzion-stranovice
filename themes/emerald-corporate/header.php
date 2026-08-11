<?php
if (!defined('ROOT_DIR') && !defined('APP_VERSION')) {
    require_once __DIR__ . '/../../admin/includes/CMS.php';
}
$meta = CMS::getPageMeta();
$siteConfig = CMS::getSiteConfig();
$siteName = $siteConfig['site_name'] ?? 'Můj Nový Web';
$email = $siteConfig['email'] ?? 'info@mujweb.cz';
$phone = $siteConfig['phone_nonstop'] ?? '+420 123 456 789';
?>
<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta['title'] ?? $siteName) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta['description'] ?? '') ?>">
    <link rel="icon" type="image/svg+xml" href="<?= htmlspecialchars($siteConfig['favicon'] ?? 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2225%22 fill=%22%234f46e5%22/><path d=%22M55 35a2.121 2.121 0 0 1 3 3L37 62l-7 2 2-7 21-22z%22 fill=%22none%22 stroke=%22white%22 stroke-width=%225%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22/></svg>') ?>">
    <script>(function(){var w=console.warn;console.warn=function(){if(arguments[0]&&typeof arguments[0]==='string'&&arguments[0].indexOf('cdn.tailwindcss.com')!==-1)return;w.apply(console,arguments);};})();</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-[#070b12] text-slate-100 min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white">

    <!-- Top Info Bar -->
    <div class="bg-indigo-500/10 border-b border-indigo-500/20 py-2 px-6 text-xs font-medium text-indigo-400">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Vítejte na našem novém webu spravovaném přes <strong>Fida CMS</strong></span>
            </div>
            <div class="flex items-center gap-4">
                <?php if (!empty($phone)): ?>
                <a href="tel:<?= urlencode($phone) ?>" class="hover:underline flex items-center gap-1 font-bold text-indigo-300">
                    <i class="fa fa-phone"></i> <?= htmlspecialchars($phone) ?>
                </a>
                <?php endif; ?>
                <?php if (!empty($email)): ?>
                <span class="hidden sm:inline text-slate-600">|</span>
                <a href="mailto:<?= htmlspecialchars($email) ?>" class="hidden sm:inline text-slate-400 hover:text-white">
                    <i class="fa fa-envelope text-indigo-400 mr-1"></i> <?= htmlspecialchars($email) ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="bg-[#0b101d]/95 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50 shadow-xl shadow-black/40">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-3 font-extrabold text-xl text-white tracking-tight group">
                <div class="w-10 h-10 bg-gradient-to-tr from-indigo-600 to-indigo-400 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-600/25 group-hover:scale-105 transition-transform">
                    <i class="fa fa-flash text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-white font-extrabold text-lg leading-tight"><?= htmlspecialchars($siteName) ?></span>
                    <span class="text-indigo-400 font-semibold text-[10px] tracking-widest uppercase">Oficiální Prezentace</span>
                </div>
            </a>
            
            <nav class="hidden md:flex items-center gap-7 text-sm font-semibold">
                <a href="index.php" class="hover:text-indigo-400 transition-colors py-1 text-slate-200">Domů</a>
                <a href="admin/" class="hover:text-indigo-400 transition-colors py-1 text-slate-300">Administrace CMS</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="admin/" class="bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white text-xs font-extrabold px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                    <i class="fa fa-cog text-sm"></i>
                    <span>Administrace</span>
                </a>
            </div>
        </div>
    </header>
    <main class="flex-1">

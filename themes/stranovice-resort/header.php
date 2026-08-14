<?php
if (!defined('ROOT_DIR') && !defined('APP_VERSION')) {
    require_once __DIR__ . '/../../admin/includes/CMS.php';
}
if (file_exists(__DIR__ . '/../../plugins/booking-sync/booking-sync.php')) {
    require_once __DIR__ . '/../../plugins/booking-sync/booking-sync.php';
}

$meta = CMS::getPageMeta();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($meta['title'] ?? 'Statek Straňovice'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta['description'] ?? ''); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta['keywords'] ?? ''); ?>">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Montserrat:wght@300;400;600&family=Pinyon+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= file_exists(__DIR__ . '/../../assets/css/style.css') ? filemtime(__DIR__ . '/../../assets/css/style.css') : '1.0' ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="logo">
            <a href="<?= CMS::url('index.php') ?>" class="logo-link">
                <div class="logo-badge">
                    <img src="assets/img/logo_final.png" alt="Statek Straňovice logo" class="logo-img">
                </div>
                <div class="logo-text-group">
                    <span class="logo-text">Statek</span>
                    <span class="logo-text">Straňovice</span>
                </div>
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="<?= CMS::url('index.php') ?>">Domů</a></li>
            <li>
                <a href="<?= CMS::url('index.php') ?>#rooms" class="has-dropdown">Ubytování</a>
                <ul class="dropdown">
                    <li><a href="<?= CMS::url('index.php') ?>#rooms">Apartmány</a></li>
                    <li><a href="<?= CMS::url('dovolena-s-vlastnim-konem.php') ?>">Dovolená s vlastním koněm</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="has-dropdown">Statek</a>
                <ul class="dropdown">
                    <li><a href="<?= CMS::url('ustajeni.php') ?>">Ustájení koní</a></li>
                    <li><a href="<?= CMS::url('zemedelstvi.php') ?>">Služby v zemědělství</a></li>
                    <li><a href="<?= CMS::url('chov.php') ?>">Chov zvířat</a></li>
                    <li><a href="<?= CMS::url('prodej.php') ?>">Prodej ze dvora</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="has-dropdown">Aktivity</a>
                <ul class="dropdown">
                    <li><a href="<?= CMS::url('akce.php') ?>">Svatby a akce</a></li>
                    <li><a href="<?= CMS::url('vyuka.php') ?>">Výukové programy</a></li>
                    <li><a href="<?= CMS::url('vylety.php') ?>">Tipy na výlety</a></li>
                    <li><a href="<?= CMS::url('kam-na-jidlo.php') ?>">Kam na jídlo</a></li>
                </ul>
            </li>
            <li><a href="<?= CMS::url('galerie.php') ?>">Fotogalerie</a></li>
        </ul>
        <div class="nav-cta">
            <a href="<?= CMS::url('index.php') ?>#contact" class="btn btn-primary">Rezervace</a>
        </div>
        <button class="mobile-menu-toggle" id="mobile-toggle">
            <i data-lucide="menu"></i>
        </button>
    </div>
</nav>

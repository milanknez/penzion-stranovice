<?php require_once 'CMS.php'; ?>
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
            <li><a href="<?= CMS::url('index.php') ?>#rooms">Ubytování</a></li>
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

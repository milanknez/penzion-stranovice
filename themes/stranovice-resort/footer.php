<?php
if (!defined('ROOT_DIR') && !defined('APP_VERSION')) {
    require_once __DIR__ . '/../../admin/includes/CMS.php';
}
if (file_exists(__DIR__ . '/../../plugins/booking-sync/booking-sync.php')) {
    require_once __DIR__ . '/../../plugins/booking-sync/booking-sync.php';
}
?>
<footer class="footer" id="main-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <a href="<?= CMS::url('index.php') ?>" class="logo-link" style="display: inline-flex; align-items: center; gap: 0.8rem; text-decoration: none; margin-bottom: 1.2rem;">
                <div class="logo-badge" style="width: 50px; height: 50px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border: 2px solid var(--accent, #c99e66);">
                    <img src="assets/img/logo_final.png" alt="Statek Straňovice logo" class="logo-img" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="logo-text-group" style="display: flex; flex-direction: column;">
                    <span class="logo-text" style="font-family: 'Libre Baskerville', serif; font-weight: 700; font-size: 1.3rem; color: #ffffff; line-height: 1.1;">Statek</span>
                    <span class="logo-text" style="font-family: 'Libre Baskerville', serif; font-weight: 700; font-size: 1.3rem; color: var(--accent, #c99e66); line-height: 1.1;">Straňovice</span>
                </div>
            </a>
            <p>U Malenic. Místo, kde kvetou sny a voní sláma.</p>
            <div class="social-links">
                <a href="#"><i data-lucide="facebook"></i></a>
                <a href="#"><i data-lucide="instagram"></i></a>
            </div>
        </div>
        <div class="footer-links">
            <h4>Odkazy</h4>
            <ul>
                <li><a href="index.php#about">O nás</a></li>
                <li><a href="index.php#rooms">Pokoje</a></li>
                <li><a href="#" id="open-timeline">Obsazenost pokojů</a></li>
                <li><a href="index.php#activities">Okolí</a></li>
                <li><a href="index.php#contact">Kontakt</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h4>Kontakt</h4>
            <p>Straňovice 1, 387 01 Malenice</p>
            <p>Tel: +420 737 887 985</p>
            <p>info@statekstranovice.cz</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Statek Straňovice. Všechna práva vyhrazena.</p>
    </div>
</footer>

<!-- Shared Modals -->
<div id="shared-modals">
    <?php 
    $modalsPath = __DIR__ . '/modals.php';
    if (file_exists($modalsPath)) {
        include $modalsPath;
    }
    ?>
</div>

<script>
    window.occupancyData = <?php echo class_exists('SyncBookingPlugin') ? json_encode(SyncBookingPlugin::getOccupancy()) : (class_exists('SyncBooking') ? json_encode(SyncBooking::getOccupancy()) : '{}'); ?>;
</script>
<!-- Flatpickr (beautiful date picker) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/cs.js"></script>
<script src="assets/js/app.js?v=<?= file_exists(__DIR__ . '/../../assets/js/app.js') ? filemtime(__DIR__ . '/../../assets/js/app.js') : '1.0' ?>"></script>
<script>
    // Re-init icons for Lucide if needed
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
</body>
</html>

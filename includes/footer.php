<footer class="footer" id="main-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <span class="logo-text">Statek Straňovice</span>
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
    <?php include 'modals.php'; ?>
</div>

<script>
    window.occupancyData = <?php echo json_encode(SyncBooking::getOccupancy()); ?>;
</script>
<!-- Flatpickr (beautiful date picker) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/cs.js"></script>
<script src="assets/js/app.js?v=<?= filemtime(__DIR__ . '/../assets/js/app.js') ?>"></script>
<script>
    // Re-init icons for Lucide if needed
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>

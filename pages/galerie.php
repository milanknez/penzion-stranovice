<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .gallery-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        height: 250px;
        cursor: pointer;
        border: 5px solid white;
        box-shadow: var(--shadow);
        background: #eee;
    }
    .gallery-item:hover {
        transform: scale(1.02);
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        display: block;
    }
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(139, 94, 60, 0.4);
        opacity: 0;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    @media (max-width: 576px) {
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.8rem;
        }
        .gallery-item {
            height: 160px;
            border-width: 3px;
        }
    }
</style>

    <!-- Hero Section -->
    <section class="hero" id="home" style="height: 50vh; min-height: 320px;">
        <div class="hero-bg" style="background-image: url('/assets/img/fotografie/galerie-statek-stranovice-03.jpg');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Naše momenty</h2>
            <h1 class="hero-title fadeInDelay">Fotogalerie</h1>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="gallery-grid" id="gallery-grid">
                <?php
                $galleryDir = __DIR__ . '/../assets/img/fotografie';
                $images = [];
                if (is_dir($galleryDir)) {
                    $files = scandir($galleryDir);
                    foreach ($files as $file) {
                        if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
                            $images[] = $file;
                        }
                    }
                    sort($images);
                }
                foreach ($images as $img):
                ?>
                <div class="gallery-item">
                    <img src="assets/img/fotografie/<?= htmlspecialchars($img) ?>" alt="Statek Straňovice – Fotografie" loading="lazy">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php
CMS::getFooter();
?>
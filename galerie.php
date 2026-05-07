<?php
/**
 * Stránka: Fotogalerie
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Fotogalerie | Penzion Statek Straňovice</title>
    <meta name="description" content="Prohlédněte si fotografie našeho statku, penzionu a zvířat. Nahlédněte do atmosféry Straňovic v jižních Čechách.">
    <?php include 'includes/head.php'; ?>
    <style>
        .gallery-filter { display: flex; justify-content: center; gap: 1rem; margin-bottom: 3rem; flex-wrap: wrap; }
        .filter-btn { padding: 0.6rem 1.5rem; border: 1px solid var(--border); background: white; border-radius: 100px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: var(--transition); }
        .filter-btn:hover, .filter-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
        
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .gallery-item { position: relative; border-radius: 8px; overflow: hidden; height: 250px; cursor: pointer; border: 5px solid white; box-shadow: var(--shadow); transition: var(--transition); }
        .gallery-item:hover { transform: scale(1.02); }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .gallery-item:hover img { transform: scale(1.1); }
        
        .gallery-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(139, 94, 60, 0.4); opacity: 0; transition: 0.3s; display: flex; align-items: center; justify-content: center; color: white; }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        
        /* Lightbox - central styles are in style.css, but I'll ensure accessibility here */
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 50vh; min-height: 300px;">
        <div class="hero-bg" style="background-image: url('assets/img/hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Naše momenty</h2>
            <h1 class="hero-title fadeInDelay">Fotogalerie</h1>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section-padding">
        <div class="container">
            <!-- Filter Buttons -->
            <div class="gallery-filter">
                <button class="filter-btn active" data-filter="all">Vše</button>
                <button class="filter-btn" data-filter="penzion">Ubytování</button>
                <button class="filter-btn" data-filter="statek">Statek & Technika</button>
                <button class="filter-btn" data-filter="zvirata">Zvířata</button>
                <button class="filter-btn" data-filter="akce">Svatby & Akce</button>
            </div>

            <!-- Grid -->
            <div class="gallery-grid" id="gallery-grid">
                <!-- Penzion -->
                <div class="gallery-item" data-category="penzion">
                    <img src="assets/img/kocici_1.jpg" alt="Penzion Straňovice">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="penzion">
                    <img src="assets/img/kvetinovy_1.jpg" alt="Apartmán">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="penzion">
                    <img src="assets/img/breakfast.png" alt="Snídaně">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>

                <!-- Statek -->
                <div class="gallery-item" data-category="statek">
                    <img src="assets/img/tractor_hero.png" alt="Zemědělská technika">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="statek">
                    <img src="assets/img/hay_bales.png" alt="Sklizeň">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="statek">
                    <img src="assets/img/prodej_hero.png" alt="Prodej ze dvora">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>

                <!-- Zvířata -->
                <div class="gallery-item" data-category="zvirata">
                    <img src="assets/img/horse_hero.png" alt="Koně na statku">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="zvirata">
                    <img src="assets/img/horse_pasture.png" alt="Pastviny">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="zvirata">
                    <img src="assets/img/horse_stable.png" alt="Stáje">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>

                <!-- Akce -->
                <div class="gallery-item" data-category="akce">
                    <img src="assets/img/wedding.png" alt="Svatba na statku">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="akce">
                    <img src="assets/img/event.png" alt="Firemní akce">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
                <div class="gallery-item" data-category="akce">
                    <img src="assets/img/room.png" alt="Společenské prostory">
                    <div class="gallery-overlay"><i data-lucide="zoom-in"></i></div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/modals.php'; ?>
    
    <script src="assets/js/app.js"></script>
    <script>
        // Simple Gallery Filter Logic
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active state
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const filter = btn.getAttribute('data-filter');
                const items = document.querySelectorAll('.gallery-item');
                
                items.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>

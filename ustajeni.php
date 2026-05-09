<?php
/**
 * Stránka: Ustájení koní
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    
    <meta name="description" content="Nabízíme profesionální ustájení koní v rodinném prostředí našeho statku v Malenicích. Prostorné boxy, pastviny a individuální péče.">
    <?php include 'includes/head.php'; ?>
    <style>
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 3rem; }
        .feature-card { background: white; padding: 2.5rem; border-radius: 8px; box-shadow: 2px 2px 0px rgba(139, 94, 60, 0.1); border-bottom: 4px solid transparent; transition: var(--transition); }
        .feature-card:hover { transform: translateY(-5px); border-color: var(--primary); }
        .feature-icon { color: var(--primary); font-size: 2.5rem; margin-bottom: 1.5rem; }
        .feature-title { font-size: 1.5rem; margin-bottom: 1rem; color: var(--text-dark); }
        
        .horse-gallery { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 2rem; }
        .horse-gallery img { width: 100%; height: 250px; object-fit: cover; border-radius: 4px; }
        @media (max-width: 768px) { .horse-gallery { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 400px;">
        <div class="hero-bg" style="background-image: url('assets/img/horse_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Profesionální péče</h2>
            <h1 class="hero-title fadeInDelay">Ustájení koní</h1>
        </div>
    </section>

    <!-- Main Description -->
    <section class="section-padding">
        <div class="container">
            <div class="about-grid" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 4rem; align-items: center;">
                <div class="reveal">
                    <span class="section-tag">Pro Vaše miláčky</span>
                    <h2 class="section-title">Rodinné prostředí s tradicí</h2>
                    <p class="section-description">
                        Na našem statku v Malenicích nabízíme profesionální ustájení pro Vaše koně. Naším cílem je vytvořit pro koně co nejpřirozenější prostředí s důrazem na jejich pohodu a zdraví. 
                    </p>
                    <p>
                        Klademe důraz na individuální přístup ke každému koni. K dispozici jsou prostorné a vzdušné boxy, které jsou denně kydány a zastýlány kvalitní slámou. Koně mají k dispozici celodenní pobyt na rozlehlých pastvinách v bezpečných stádech.
                    </p>
                    <div class="horse-gallery">
                        <img src="assets/img/horse_pasture.png" alt="Koně na pastvě">
                        <img src="assets/img/horse_stable.png" alt="Vnitřní boxy">
                    </div>
                </div>
                <div class="reveal" style="position: relative;">
                    <div style="border: 10px solid white; box-shadow: 15px 15px 0 var(--border); border-radius: 4px; overflow: hidden;">
                        <img src="assets/img/horse_hero.png" alt="Náš statek a koně" style="width: 100%; display: block;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center" style="max-width: 700px; margin-inline: auto; margin-bottom: 4rem;">
                <span class="section-tag">Co nabízíme</span>
                <h2 class="section-title">Kompletní servis pro koně i jezdce</h2>
            </div>
            
            <div class="feature-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon"><i data-lucide="home"></i></div>
                    <h3 class="feature-title">Boxové ustájení</h3>
                    <p>Prostorné a světlé boxy s pravidelným místováním. Krmení senem 2x denně a jádrem dle individuálních potřeb.</p>
                </div>
                <div class="feature-card reveal-up">
                    <div class="feature-icon"><i data-lucide="leaf"></i></div>
                    <h3 class="feature-title">Celodenní pastva</h3>
                    <p>Rozlehlé pastviny s bezpečným ohrazením. Koně tráví většinu dne venku v přirozeném stádě.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon"><i data-lucide="shield-check"></i></div>
                    <h3 class="feature-title">Individuální péče</h3>
                    <p>Dohled nad koňmi 24/7. Možnost dekování, podávání léků či asistence u kováře a veterináře.</p>
                </div>
                <div class="feature-card reveal-up">
                    <div class="feature-icon"><i data-lucide="map"></i></div>
                    <h3 class="feature-title">Zázemí statku</h3>
                    <p>Uzamykatelná sedlovna, šatna pro jezdce a venkovní písková jízdárna k dispozici.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding" style="background-color: var(--text-dark); color: white;">
        <div class="container text-center">
            <h2 class="section-title" style="color: white;">Máte zájem o ustájení?</h2>
            <p style="font-size: 1.2rem; opacity: 0.8; margin-bottom: 2rem; max-width: 600px; margin-inline: auto;">
                Aktuálně máme volné kapacity. Přijeďte se k nám nezávazně podívat a prohlédnout si naše zázemí.
            </p>
            <a href="index.php#contact" class="btn btn-primary btn-lg">Kontaktujte nás</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/modals.php'; ?>
    
    <script src="assets/js/app.js"></script>
</body>
</html>




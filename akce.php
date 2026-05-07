<?php
/**
 * Stránka: Svatby a akce
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Svatby a akce na statku | Penzion Statek Straňovice</title>
    <meta name="description" content="Uspořádejte svou pohádkovou svatbu, firemní teambuilding nebo rodinnou oslavu v autentickém prostředí jihočeského statku v Malenicích.">
    <?php include 'includes/head.php'; ?>
    <style>
        .event-type-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow); margin-bottom: 4rem; display: grid; grid-template-columns: 1fr 1fr; align-items: center; }
        .event-type-card:nth-child(even) { grid-template-columns: 1fr 1fr; }
        .event-type-card:nth-child(even) .event-type-img { order: 2; }
        .event-type-card:nth-child(even) .event-type-content { order: 1; }
        
        .event-type-img { width: 100%; height: 100%; min-height: 400px; object-fit: cover; }
        .event-type-content { padding: 4rem; }
        
        .amenities-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem; }
        .amenity-item { text-align: center; padding: 2rem; background: var(--bg-light); border-radius: 8px; border: 1px solid var(--border); }
        .amenity-icon { color: var(--primary); margin-bottom: 1rem; font-size: 1.5rem; }
        
        @media (max-width: 992px) {
            .event-type-card { grid-template-columns: 1fr !important; }
            .event-type-img { height: 300px; min-height: auto; }
            .event-type-content { padding: 2rem; }
            .event-type-card:nth-child(even) .event-type-img { order: 1; }
            .event-type-card:nth-child(even) .event-type-content { order: 2; }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 70vh; min-height: 500px;">
        <div class="hero-bg" style="background-image: url('assets/img/wedding.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Nezapomenutelné okamžiky</h2>
            <h1 class="hero-title fadeInDelay">Svatby & Akce</h1>
        </div>
    </section>

    <!-- Intro -->
    <section class="section-padding">
        <div class="container text-center" style="max-width: 800px; margin-inline: auto;">
            <span class="section-tag">Váš den u nás</span>
            <h2 class="section-title">Místo, kde příběhy začínají</h2>
            <p class="section-description">
                Hledáte netradiční a autentické místo pro Vaši životní událost nebo firemní setkání? Náš statek nabízí unikátní kombinaci jihočeské venkovské architektury, klidné přírody a moderního zázemí. 
            </p>
        </div>
    </section>

    <!-- Event Types -->
    <section class="section-padding bg-light" style="padding-bottom: 0;">
        <div class="container">
            <!-- Weddings -->
            <div class="event-type-card reveal">
                <img src="assets/img/wedding.png" class="event-type-img" alt="Svatba na statku">
                <div class="event-type-content">
                    <span class="section-tag" style="font-size: 2rem;">Pohádková</span>
                    <h2 style="margin-bottom: 1.5rem;">Svatba na statku</h2>
                    <p>Užijte si svůj svatební den bez stresu a v naprostém soukromí. Nabízíme možnost obřadu přímo v našem areálu, hostinu ve stylově upravených prostorách a ubytování pro novomanžele i hosty.</p>
                    <p style="margin-top: 1rem;">Kapacita pro hostinu: až 60 osob.</p>
                </div>
            </div>

            <!-- Corporate -->
            <div class="event-type-card reveal-up">
                <img src="assets/img/event.png" class="event-type-img" alt="Firemní akce">
                <div class="event-type-content">
                    <span class="section-tag" style="font-size: 2rem;">Profesionální</span>
                    <h2 style="margin-bottom: 1.5rem;">Firemní akce & Teambuilding</h2>
                    <p>Vyměňte sterilní kanceláře za inspirativní prostředí venkova. Náš statek je ideální pro menší konference, školení nebo neformální teambuildingy s možností doprovodných aktivit na farmě.</p>
                    <p style="margin-top: 1rem;">K dispozici: Wi-Fi, projekce, catering na míru.</p>
                </div>
            </div>

            <!-- Private -->
            <div class="event-type-card reveal">
                <img src="assets/img/hero.jpg" class="event-type-img" alt="Soukromé oslavy">
                <div class="event-type-content">
                    <span class="section-tag" style="font-size: 2rem;">Osobní</span>
                    <h2 style="margin-bottom: 1.5rem;">Soukromé oslavy & Výročí</h2>
                    <p>Narozeniny, rodinné srazy nebo setkání přátel. U nás najdete klid a prostor pro nerušenou zábavu. Zajistíme pro Vás rauty z našich domácích surovin i grilování na dvoře.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Amenities Grid -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center" style="margin-bottom: 4rem;">
                <span class="section-tag">Co u nás najdete</span>
                <h2 class="section-title">Kompletní zázemí</h2>
            </div>
            <div class="amenities-grid">
                <div class="amenity-item reveal">
                    <div class="amenity-icon"><i data-lucide="utensils"></i></div>
                    <h4>Catering</h4>
                    <p>Domácí kuchyně z vlastních surovin</p>
                </div>
                <div class="amenity-item reveal-up">
                    <div class="amenity-icon"><i data-lucide="home"></i></div>
                    <h4>Ubytování</h4>
                    <p>Pohodlné apartmány pro Vaše hosty</p>
                </div>
                <div class="amenity-item reveal">
                    <div class="amenity-icon"><i data-lucide="parking-circle"></i></div>
                    <h4>Parkování</h4>
                    <p>Bezplatné parkování přímo v areálu</p>
                </div>
                <div class="amenity-item reveal-up">
                    <div class="amenity-icon"><i data-lucide="wifi"></i></div>
                    <h4>Konektivita</h4>
                    <p>Wi-Fi v celém areálu zdarma</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section-padding bg-light text-center">
        <div class="container">
            <h2 class="section-title">Plánujete akci?</h2>
            <p style="max-width: 600px; margin-inline: auto; margin-bottom: 2rem;">
                Rádi Vám pomůžeme s organizací a připravíme nabídku přesně podle Vašich představ.
            </p>
            <a href="index.php#contact" class="btn btn-primary btn-lg">Poptat termín</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/app.js"></script>
</body>
</html>

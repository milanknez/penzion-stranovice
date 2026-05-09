<?php 
require_once 'includes/CMS.php';
$meta = CMS::getPageMeta();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <?php include 'includes/head.php'; ?>
    <style>
        .event-type-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow); margin-bottom: 4rem; display: grid; grid-template-columns: 1fr 1fr; align-items: center; }
        .event-type-card:nth-child(2n) .event-type-img { order: 2; }
        .event-type-card:nth-child(2n) .event-type-content { order: 1; }
        .event-type-img { width: 100%; height: 100%; min-height: 400px; object-fit: cover; }
        .event-type-content { padding: 4rem; }
        .amenities-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem; }
        .amenity-item { text-align: center; padding: 2rem; border-radius: 8px; }
        .amenity-icon { color: var(--primary); margin-bottom: 1rem; font-size: 1.5rem; }
        #hero-events { height: 70vh; min-height: 500px; }
        #hero-bg-events { background-image: url("assets/img/wedding.png"); }
        @media (max-width: 992px) {
            .event-type-card { grid-template-columns: 1fr !important; }
            .event-type-img { height: 300px; min-height: auto; }
            .event-type-content { padding: 2rem; }
            .event-type-card:nth-child(2n) .event-type-img { order: 1; }
            .event-type-card:nth-child(2n) .event-type-content { order: 2; }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section id="hero-events" class="hero">
        <div id="hero-bg-events" class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Nezapomenutelné okamžiky</h2>
            <h1 class="hero-title fadeInDelay">Svatby & Akce</h1>
        </div>
    </section>

    <section class="section-padding">
        <div class="container text-center" style="max-width: 800px;">
            <span class="section-tag">Váš den u nás</span>
            <h2 class="section-title">Místo, kde příběhy začínají</h2>
            <p class="section-description">
                Hledáte netradiční a autentické místo pro Vaši životní událost nebo firemní setkání? Náš statek nabízí unikátní kombinaci jihočeské venkovské architektury, klidné přírody a moderního zázemí. 
            </p>
        </div>
    </section>

    <section class="section-padding bg-light">
        <div class="container">
            <div class="event-type-card reveal">
                <img src="assets/img/wedding.png" alt="Svatba na statku" class="event-type-img">
                <div class="event-type-content">
                    <span class="section-tag">Pohádková</span>
                    <h2>Svatba na statku</h2>
                    <p>Užijte si svůj svatební den bez stresu a v naprostém soukromí. Nabízíme možnost obřadu přímo v našem areálu, hostinu ve stylově upravených prostorách a ubytování pro novomanžele i hosty.</p>
                    <p style="margin-top: 1rem;">Kapacita pro hostinu: až 60 osob.</p>
                </div>
            </div>

            <div class="event-type-card reveal-up">
                <img src="assets/img/event.png" alt="Firemní akce" class="event-type-img">
                <div class="event-type-content">
                    <span class="section-tag">Profesionální</span>
                    <h2>Firemní akce & Teambuilding</h2>
                    <p>Vyměňte sterilní kanceláře za inspirativní prostředí venkova. Náš statek je ideální pro menší konference, školení nebo neformální teambuildingy s možností doprovodných aktivit na farmě.</p>
                    <p style="margin-top: 1rem;">K dispozici: Wi-Fi, projekce, catering na míru.</p>
                </div>
            </div>

            <div class="event-type-card reveal">
                <img src="assets/img/hero.jpg" alt="Soukromé oslavy" class="event-type-img">
                <div class="event-type-content">
                    <span class="section-tag">Osobní</span>
                    <h2>Soukromé oslavy & Výročí</h2>
                    <p>Narozeniny, rodinné srazy nebo setkání přátel. U nás najdete klid a prostor pro nerušenou zábavu. Zajistíme pro Vás rauty z našich domácích surovin i grilování na dvoře.</p>
                </div>
            </div>
        </div>
    </section>

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
                    <div class="amenity-icon"><i data-lucide="circle-parking"></i></div>
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

    <section class="section-padding bg-light text-center">
        <div class="container">
            <h2 class="section-title">Plánujete akci?</h2>
            <p style="max-width: 600px; margin: 0 auto 2rem;">
                Rádi Vám pomůžeme s organizací a připravíme nabídku přesně podle Vašich představ.
            </p>
            <a href="index.php#contact" class="btn btn-primary btn-lg">Poptat termín</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script>if (typeof lucide !== 'undefined') lucide.createIcons();</script>
</body>
</html>

<?php
/**
 * Stránka: Chov zvířat
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    
    <meta name="description" content="Poznejte naše zvířecí obyvatele. Chováme koně, ovce, kozy a drůbež s láskou a respektem k tradicím.">
    <?php include 'includes/head.php'; ?>
    <style>
        .animal-showcase { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 4rem; }
        .animal-card { position: relative; border-radius: 15px; overflow: hidden; height: 400px; box-shadow: var(--shadow); }
        .animal-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
        .animal-card:hover img { transform: scale(1.1); }
        .animal-overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 2.5rem; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; }
        .animal-name { font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem; }
        .animal-tag { display: inline-block; padding: 0.3rem 0.8rem; background: var(--primary); border-radius: 4px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.8rem; }
        
        .farm-life { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 5rem; align-items: center; }
        @media (max-width: 992px) {
            .farm-life { grid-template-columns: 1fr; gap: 3rem; }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 450px;">
        <div class="hero-bg" style="background-image: url('assets/img/chov_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Život v souladu s přírodou</h2>
            <h1 class="hero-title fadeInDelay">Chov zvířat</h1>
        </div>
    </section>

    <!-- Intro -->
    <section class="section-padding">
        <div class="container">
            <div class="farm-life">
                <div class="reveal">
                    <span class="section-tag">Naše srdce</span>
                    <h2 class="section-title">Zvířata jsou naše rodina</h2>
                    <p class="section-description">
                        Hospodaření na statku Straňovice není jen práce, je to životní styl. Naše zvířata mají dostatek volnosti na pastvinách a dostávají tu nejlepší péči. Věříme, že spokojené zvíře je základem kvalitních produktů a radosti, kterou naše farma přináší návštěvníkům.
                    </p>
                    <p>
                        Zaměřujeme se na tradiční plemena, která do jihočeské krajiny historicky patří. Naši hosté mají možnost se se zvířaty seznámit zblízka, pod dohledem si vyzkoušet péči o ně nebo se jen tak kochat pohledem na pasoucí se stáda.
                    </p>
                </div>
                <div class="reveal-up">
                    <img src="assets/img/horse_stable.png" alt="Naše stáj" style="border-radius: 20px; box-shadow: var(--shadow-lg); width: 100%;">
                </div>
            </div>

            <div class="animal-showcase">
                <!-- Animal 1 -->
                <div class="animal-card reveal">
                    <img src="assets/img/horse_hero.png" alt="Koně">
                    <div class="animal-overlay">
                        <span class="animal-tag">Chov & Ustájení</span>
                        <h3 class="animal-name">Ušlechtilí koně</h3>
                        <p>Naše pýcha. Nabízíme profesionální ustájení i prostor pro trénink.</p>
                    </div>
                </div>
                <!-- Animal 2 -->
                <div class="animal-card reveal-up" style="animation-delay: 0.1s;">
                    <img src="assets/img/horse_pasture.png" alt="Ovce a kozy">
                    <div class="animal-overlay">
                        <span class="animal-tag">Pasení</span>
                        <h3 class="animal-name">Ovce a kozy</h3>
                        <p>Přirození údržbáři našich luk a zdroj výborného mléka.</p>
                    </div>
                </div>
                <!-- Animal 3 -->
                <div class="animal-card reveal" style="animation-delay: 0.2s;">
                    <img src="assets/img/eggs.png" alt="Drůbež">
                    <div class="animal-overlay">
                        <span class="animal-tag">Vlastní vejce</span>
                        <h3 class="animal-name">Domácí drůbež</h3>
                        <p>Slepice, kachny a husy, které se volně pohybují po celém dvoře.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products CTA -->
    <section class="section-padding bg-light text-center">
        <div class="container">
            <h2 class="section-title">Chcete ochutnat výsledky naší práce?</h2>
            <p style="max-width: 600px; margin-inline: auto; margin-bottom: 2rem;">
                Mnoho produktů z našeho chovu si můžete zakoupit přímo u nás "ze dvora" nebo ochutnat v rámci našich bohatých snídaní.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="prodej.php" class="btn btn-primary">Prodej ze dvora</a>
                <a href="galerie.php" class="btn btn-outline">Prohlédnout fotogalerii</a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/app.js"></script>
</body>
</html>




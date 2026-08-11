<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();

?>
<style>
    .animal-showcase { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
        gap: 2rem; 
        margin-top: 3rem; 
    }
    .animal-card { 
        background: white; 
        border-radius: 12px; 
        overflow: hidden; 
        box-shadow: var(--shadow); 
        border: 1px solid var(--border); 
        transition: var(--transition); 
        display: flex; 
        flex-direction: column; 
        height: 100%; 
    }
    .animal-card:hover { 
        transform: translateY(-5px); 
        border-color: var(--primary); 
    }
    .animal-img-wrapper { 
        height: 220px; 
        width: 100%; 
        overflow: hidden; 
        position: relative; 
    }
    .animal-img-wrapper img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        transition: transform 0.6s ease; 
    }
    .animal-card:hover .animal-img-wrapper img { 
        transform: scale(1.08); 
    }
    .animal-body { 
        padding: 1.5rem; 
        display: flex; 
        flex-direction: column; 
        flex-grow: 1; 
        background: white; 
    }
    .animal-name { 
        font-family: 'Libre Baskerville', serif; 
        font-size: 1.25rem; 
        color: var(--primary); 
        margin-bottom: 0.8rem; 
        font-weight: 700; 
    }
    .animal-desc { 
        color: var(--text-muted); 
        font-size: 0.9rem; 
        line-height: 1.5; 
        margin: 0; 
    }
    
    .farm-life { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 5rem; align-items: center; }
    @media (max-width: 992px) {
        .farm-life { grid-template-columns: 1fr; gap: 3rem; }
    }
</style>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 450px;">
        <div class="hero-bg" style="background-image: url(/assets/img/chov_hero.png);"></div>
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
                        Věnujeme se chovu hospodářských zvířat – krav, koní, ovcí, koz, drůbeže, včel a drobného zvířectva. Naši hosté mají možnost se se zvířaty seznámit zblízka, pod dohledem si vyzkoušet péči o ně nebo se jen tak kochat pohledem na pasoucí se stáda.
                    </p>
                </div>
                <div class="reveal-up">
                    <img src="/assets/img/horse_stable.png" alt="Naše stáj" style="border-radius: 20px; box-shadow: var(--shadow-lg); width: 100%;">
                </div>
            </div>

            <div class="animal-showcase">
                <!-- Animal 1 -->
                <div class="animal-card reveal">
                    <div class="animal-img-wrapper">
                        <img src="/assets/img/horse_hero.png" alt="Koně">
                    </div>
                    <div class="animal-body">
                        <h3 class="animal-name">Koně</h3>
                        <p class="animal-desc">Nabízíme možnost ustájení i pohodový relax s koňmi v čisté pošumavské přírodě.</p>
                    </div>
                </div>
                <!-- Animal 2 -->
                <div class="animal-card reveal-up" style="animation-delay: 0.1s;">
                    <div class="animal-img-wrapper">
                        <img src="/assets/img/sheep_goats.png" alt="Ovce a kozy">
                    </div>
                    <div class="animal-body">
                        <h3 class="animal-name">Ovce a kozy</h3>
                        <p class="animal-desc">Přirození údržbáři našich luk a pastvin, kteří dělají radost všem návštěvníkům.</p>
                    </div>
                </div>
                <!-- Animal 3 -->
                <div class="animal-card reveal" style="animation-delay: 0.2s;">
                    <div class="animal-img-wrapper">
                        <img src="/assets/img/poultry.png" alt="Slepice a křepelky">
                    </div>
                    <div class="animal-body">
                        <h3 class="animal-name">Slepice a křepelky</h3>
                        <p class="animal-desc">Slepice, křepelky, kachny a husy, které se volně pohybují po celém dvoře.</p>
                    </div>
                </div>
                <!-- Animal 4 -->
                <div class="animal-card reveal-up" style="animation-delay: 0.3s;">
                    <div class="animal-img-wrapper">
                        <img src="/assets/img/cows.png" alt="Chov krav">
                    </div>
                    <div class="animal-body">
                        <h3 class="animal-name">Chov krav</h3>
                        <p class="animal-desc">Tradiční chov skotu pasoucího se na okolních šťavnatých lukách.</p>
                    </div>
                </div>
                <!-- Animal 5 -->
                <div class="animal-card reveal" style="animation-delay: 0.4s;">
                    <div class="animal-img-wrapper">
                        <img src="/assets/img/bees.png" alt="Včely a včelařství">
                    </div>
                    <div class="animal-body">
                        <h3 class="animal-name">Včely a včelařství</h3>
                        <p class="animal-desc">Naše včelstva pečují o opylování okolní přírody a doplňují život na statku o poctivý domácí med.</p>
                    </div>
                </div>
                <!-- Animal 6 -->
                <div class="animal-card reveal-up" style="animation-delay: 0.5s;">
                    <div class="animal-img-wrapper">
                        <img src="/assets/img/small_animals.png" alt="Drobné zvířectvo a mazlíčkové">
                    </div>
                    <div class="animal-body">
                        <h3 class="animal-name">Drobné zvířectvo a mazlíčkové</h3>
                        <p class="animal-desc">Kočky, králíci a morčata pro radost dětí i dospělých návštěvníků statku.</p>
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
                <a href="galerie.php" class="btn btn-outline-primary">Prohlédnout fotogalerii</a>
            </div>
        </div>
    </section>

    <?php CMS::getFooter(); ?>




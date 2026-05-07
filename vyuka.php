<?php
/**
 * Stránka: Výukové programy
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Výukové programy a ekovýchova | Penzion Statek Straňovice</title>
    <meta name="description" content="Edukační programy pro školy i rodiny. Poznejte život na statku, péči o zvířata a tradiční řemesla v srdci přírody.">
    <?php include 'includes/head.php'; ?>
    <style>
        .program-section { margin-bottom: 6rem; }
        .program-row { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-bottom: 4rem; }
        .program-row:nth-child(even) .program-image { order: 2; }
        .program-row:nth-child(even) .program-content { order: 1; }
        
        .program-image { position: relative; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-lg); height: 450px; }
        .program-image img { width: 100%; height: 100%; object-fit: cover; }
        
        .program-content h3 { font-size: 2rem; margin-bottom: 1.5rem; color: var(--text-dark); }
        .program-features { list-style: none; padding: 0; margin: 2rem 0; }
        .program-features li { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem; color: var(--text-muted); }
        .program-features i { color: var(--primary); margin-top: 0.2rem; }
        
        .stats-banner { background: var(--primary); color: white; padding: 4rem 0; margin: 4rem 0; border-radius: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center; }
        .stat-item h2 { font-size: 3.5rem; color: white; margin-bottom: 0.5rem; }
        .stat-item p { font-weight: 500; opacity: 0.9; }

        @media (max-width: 992px) {
            .program-row { grid-template-columns: 1fr !important; gap: 2rem; }
            .program-image { height: 300px; }
            .program-row:nth-child(even) .program-image { order: 1; }
            .program-row:nth-child(even) .program-content { order: 2; }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 450px;">
        <div class="hero-bg" style="background-image: url('assets/img/vyuka_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Učení prožitkem</h2>
            <h1 class="hero-title fadeInDelay">Výukové programy</h1>
        </div>
    </section>

    <!-- Intro -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center" style="max-width: 800px; margin-inline: auto; margin-bottom: 5rem;">
                <span class="section-tag">Ekovýchova</span>
                <h2 class="section-title">Kde se škola stává dobrodružstvím</h2>
                <p class="section-description">
                    Věříme, že nejlépe se člověk učí tím, co si sám vyzkouší. Naše programy jsou navrženy tak, aby dětem i dospělým přiblížily život na venkově, koloběh přírody a důležitost udržitelného hospodaření.
                </p>
            </div>

            <div class="program-section">
                <!-- Program 1 -->
                <div class="program-row reveal">
                    <div class="program-image">
                        <img src="assets/img/horse_pasture.png" alt="Malý farmář">
                    </div>
                    <div class="program-content">
                        <span class="section-tag">Pro MŠ a 1. stupeň ZŠ</span>
                        <h3>Den malého farmáře</h3>
                        <p>Zážitkový program zaměřený na první kontakt se zvířaty. Děti si vyzkouší krmení, dozví se, co které zvířátko potřebuje, a prozkoumají naši bylinkovou zahrádku.</p>
                        <ul class="program-features">
                            <li><i data-lucide="check-circle"></i> Krmení králíků, ovcí a koz</li>
                            <li><i data-lucide="check-circle"></i> Ukázka starých zemědělských nástrojů</li>
                            <li><i data-lucide="check-circle"></i> Výroba jednoduchého suvenýru z přírodnin</li>
                        </ul>
                        <a href="index.php#contact" class="btn btn-outline">Mám zájem o program</a>
                    </div>
                </div>

                <!-- Program 2 -->
                <div class="program-row reveal-up">
                    <div class="program-image">
                        <img src="assets/img/eggs.png" alt="Cesta za jídlem">
                    </div>
                    <div class="program-content">
                        <span class="section-tag">Pro 2. stupeň ZŠ a SŠ</span>
                        <h3>Cesta za jídlem</h3>
                        <p>Kde se bere mléko, jak se peče chleba a proč je důležitá lokální produkce? Program zaměřený na environmentální souvislosti a praktické dovednosti v kuchyni i na poli.</p>
                        <ul class="program-features">
                            <li><i data-lucide="check-circle"></i> Od zrna k bochníku – mletí mouky</li>
                            <li><i data-lucide="check-circle"></i> Základy permakultury a ekologického zemědělství</li>
                            <li><i data-lucide="check-circle"></i> Ochutnávka farmářských produktů</li>
                        </ul>
                        <a href="index.php#contact" class="btn btn-outline">Mám zájem o program</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Banner -->
    <div class="container">
        <section class="stats-banner reveal">
            <div class="stats-grid">
                <div class="stat-item">
                    <h2>500+</h2>
                    <p>Spokojených dětí ročně</p>
                </div>
                <div class="stat-item">
                    <h2>10+</h2>
                    <p>Let zkušeností v oboru</p>
                </div>
                <div class="stat-item">
                    <h2>15</h2>
                    <p>Druhů hospodářských zvířat</p>
                </div>
                <div class="stat-item">
                    <h2>100%</h2>
                    <p>Láska k přírodě</p>
                </div>
            </div>
        </section>
    </div>

    <!-- Booking CTA -->
    <section class="section-padding text-center">
        <div class="container">
            <h2 class="section-title">Programy na míru</h2>
            <p style="max-width: 700px; margin-inline: auto; margin-bottom: 3rem;">
                Jste skupina přátel, tábor nebo nezisková organizace? Rádi pro Vás sestavíme individuální program podle Vašeho zaměření a časových možností.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="tel:+420123456789" class="btn btn-primary"><i data-lucide="phone" style="margin-right: 0.5rem;"></i> Zavolejte nám</a>
                <a href="index.php#contact" class="btn btn-outline">Napište nám</a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/app.js"></script>
</body>
</html>

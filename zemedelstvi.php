<?php
/**
 * Stránka: Služby v zemědělství
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Služby v zemědělství | Penzion Statek Straňovice</title>
    <meta name="description" content="Nabízíme profesionální zemědělské služby moderní technikou. Orba, sečení, lisování sena a doprava v okolí Malenic.">
    <?php include 'includes/head.php'; ?>
    <style>
        .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem; margin-top: 3rem; }
        .service-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition); border: 1px solid var(--border); }
        .service-card:hover { transform: translateY(-10px); }
        .service-img { width: 100%; height: 200px; object-fit: cover; }
        .service-content { padding: 2rem; }
        .service-icon { color: var(--primary); margin-bottom: 1rem; }
        
        .machinery-section { background: var(--text-dark); color: white; border-radius: 12px; padding: 4rem; margin: 4rem 0; position: relative; overflow: hidden; }
        .machinery-section::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('assets/img/tractor_hero.png') center/cover; opacity: 0.1; }
        .machinery-content { position: relative; z-index: 1; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 400px;">
        <div class="hero-bg" style="background-image: url('assets/img/tractor_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Moderní technika & tradice</h2>
            <h1 class="hero-title fadeInDelay">Služby v zemědělství</h1>
        </div>
    </section>

    <!-- Intro Section -->
    <section class="section-padding">
        <div class="container">
            <div class="about-grid" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 4rem; align-items: center;">
                <div class="reveal" style="position: relative;">
                    <div style="border: 10px solid white; box-shadow: 15px 15px 0 var(--border); border-radius: 4px; overflow: hidden;">
                        <img src="assets/img/hay_bales.png" alt="Sklizeň sena" style="width: 100%; display: block;">
                    </div>
                </div>
                <div class="reveal">
                    <span class="section-tag">Pomoc na poli</span>
                    <h2 class="section-title">Spolehlivý partner pro Vaše hospodaření</h2>
                    <p class="section-description">
                        Kromě ubytování a chovu zvířat se aktivně věnujeme obhospodařování vlastních i pronajatých pozemků. Naši moderní techniku a letité zkušenosti nabízíme i Vám. 
                    </p>
                    <p>
                        Zajišťujeme kompletní cyklus prací – od jarní přípravy půdy přes ošetřování porostů až po finální sklizeň a odvoz komodit. Naše stroje jsou pravidelně servisovány a obsluhovány zkušenými pracovníky, což zaručuje kvalitu a rychlost odvedené práce.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Services -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center" style="max-width: 700px; margin-inline: auto; margin-bottom: 4rem;">
                <span class="section-tag">Naše portfolio</span>
                <h2 class="section-title">Nabízené agroslužby</h2>
            </div>
            
            <div class="service-grid">
                <!-- Service 1 -->
                <div class="service-card reveal">
                    <img src="assets/img/tractor_hero.png" class="service-img" alt="Orba a příprava">
                    <div class="service-content">
                        <div class="service-icon"><i data-lucide="layers"></i></div>
                        <h3>Příprava půdy</h3>
                        <p>Provádíme kvalitní orbu, podmítku a předseťovou přípravu půdy moderními pluhy a kypřiči.</p>
                    </div>
                </div>
                <!-- Service 2 -->
                <div class="service-card reveal-up">
                    <img src="assets/img/hay_bales.png" class="service-img" alt="Sklizeň sena">
                    <div class="service-content">
                        <div class="service-icon"><i data-lucide="scissors"></i></div>
                        <h3>Sečení a sklizeň</h3>
                        <p>Kompletní sklizeň pícnin – sečení, obracení, shrnování a následný odvoz z pole.</p>
                    </div>
                </div>
                <!-- Service 3 -->
                <div class="service-card reveal">
                    <img src="assets/img/hay_bales.png" class="service-img" alt="Lisování">
                    <div class="service-content">
                        <div class="service-icon"><i data-lucide="circle-dot"></i></div>
                        <h3>Lisování balíků</h3>
                        <p>Lisování sena a slámy do pevných kulatých balíků s variabilní komorou a vázáním do sítě.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Machinery Note -->
    <section class="container">
        <div class="machinery-section reveal">
            <div class="machinery-content text-center">
                <h2 style="color: white; margin-bottom: 1.5rem;">Moderní strojový park</h2>
                <p style="font-size: 1.1rem; opacity: 0.9; max-width: 800px; margin-inline: auto;">
                    Disponujeme technikou značek John Deere, Zetor a Pöttinger, která nám umožňuje pracovat efektivně i v náročných podmínkách. Zvládneme vše od drobných prací pro zahrádkáře až po velké výměry.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="section-padding text-center">
        <div class="container">
            <span class="section-tag">Zeptejte se nás</span>
            <h2 class="section-title">Nezávazná poptávka služeb</h2>
            <p style="margin-bottom: 2.5rem; max-width: 600px; margin-inline: auto;">
                Potřebujete pomoci se sklizní nebo přípravou pole? Ozvěte se nám, rádi Vám připravíme individuální cenovou nabídku.
            </p>
            <a href="index.php#contact" class="btn btn-primary btn-lg">Poptat služby</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/app.js"></script>
</body>
</html>

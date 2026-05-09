<?php
/**
 * Stránka: Tipy na výlety
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    
    <meta name="description" content="Objevte krásy okolí Malenic a Šumavy. Tipy na pěší výlety, cyklotrasy a historické památky v dosahu našeho statku.">
    <?php include 'includes/head.php'; ?>
    <style>
        .trip-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 3rem; margin-top: 3rem; }
        .trip-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: var(--shadow); transition: var(--transition); border: 1px solid var(--border); display: flex; flex-direction: column; }
        .trip-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-lg); }
        .trip-img-wrapper { position: relative; height: 250px; overflow: hidden; }
        .trip-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .trip-card:hover .trip-img { transform: scale(1.1); }
        .trip-badge { position: absolute; top: 1rem; right: 1rem; background: var(--primary); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; }
        .trip-content { padding: 2rem; flex-grow: 1; display: flex; flex-direction: column; }
        .trip-meta { display: flex; gap: 1.5rem; margin-bottom: 1rem; color: var(--text-light); font-size: 0.9rem; }
        .trip-meta span { display: flex; align-items: center; gap: 0.5rem; }
        .trip-title { margin-bottom: 1rem; font-size: 1.5rem; color: var(--text-dark); }
        .trip-description { color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem; }
        .trip-footer { margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--border); }
        
        .distance-section { background: var(--bg-light); border-radius: 20px; padding: 4rem; margin: 4rem 0; }
        .distance-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem; }
        .distance-item { background: white; padding: 2rem; border-radius: 12px; text-align: center; box-shadow: var(--shadow-sm); }
        .distance-val { display: block; font-size: 2.5rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; }
        .distance-label { font-weight: 600; color: var(--text-dark); }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 450px;">
        <div class="hero-bg" style="background-image: url('assets/img/vylety_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Objevujte krásy jižních Čech</h2>
            <h1 class="hero-title fadeInDelay">Tipy na výlety</h1>
        </div>
    </section>

    <!-- Intro -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center" style="max-width: 800px; margin-inline: auto;">
                <span class="section-tag">Kam vyrazit</span>
                <h2 class="section-title">Okolí, které Vás okouzlí</h2>
                <p class="section-description">
                    Náš statek ve Straňovicích je ideálním výchozím bodem pro toulky přírodou i za historií. Ať už preferujete náročnou turistiku, pohodovou cyklistiku nebo návštěvu památek, u nás si přijdete na své.
                </p>
            </div>

            <div class="trip-grid">
                <!-- Trip 1: Malenice -->
                <div class="trip-card reveal">
                    <div class="trip-img-wrapper">
                        <img src="assets/img/hero.png" class="trip-img" alt="Malenice">
                        <span class="trip-badge">Pěšky</span>
                    </div>
                    <div class="trip-content">
                        <div class="trip-meta">
                            <span><i data-lucide="map-pin"></i> 2 km</span>
                            <span><i data-lucide="clock"></i> 30 min</span>
                        </div>
                        <h3 class="trip-title">Malenice a okolí</h3>
                        <p class="trip-description">Procházka do malebné vesnice s barokním kostelem sv. Jakuba a unikátním hřbitovem, kde odpočívají významné osobnosti jako režisér Zdeněk Podskalský.</p>
                        <div class="trip-footer">
                            <button class="btn btn-link open-route-modal" data-route="malenice">Zobrazit trasu <i data-lucide="map"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Trip 2: Hrad Kašperk -->
                <div class="trip-card reveal-up">
                    <div class="trip-img-wrapper">
                        <img src="assets/img/wedding.png" class="trip-img" alt="Hrad Kašperk">
                        <span class="trip-badge">Autem</span>
                    </div>
                    <div class="trip-content">
                        <div class="trip-meta">
                            <span><i data-lucide="map-pin"></i> 25 km</span>
                            <span><i data-lucide="car"></i> 35 min</span>
                        </div>
                        <h3 class="trip-title">Hrad Kašperk</h3>
                        <p class="trip-description">Nejvýše položený královský hrad v Čechách, založený Karlem IV. Nabízí úchvatné výhledy na Šumavu a bohatý doprovodný program pro děti.</p>
                        <div class="trip-footer">
                            <button class="btn btn-link open-route-modal" data-route="kasperk">Zobrazit trasu <i data-lucide="map"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Trip 3: Boubínský prales -->
                <div class="trip-card reveal">
                    <div class="trip-img-wrapper">
                        <img src="assets/img/vylety_hero.png" class="trip-img" alt="Boubín">
                        <span class="trip-badge">Pěšky/Kolo</span>
                    </div>
                    <div class="trip-content">
                        <div class="trip-meta">
                            <span><i data-lucide="map-pin"></i> 18 km</span>
                            <span><i data-lucide="clock"></i> Celodenní</span>
                        </div>
                        <h3 class="trip-title">Boubínský prales</h3>
                        <p class="trip-description">Unikátní přírodní rezervace s rozhlednou na vrcholu. Cesta vede kolem Boubínského jezírka skrze nedotčenou šumavskou divočinu.</p>
                        <div class="trip-footer">
                            <button class="btn btn-link open-route-modal" data-route="boubin">Zobrazit trasu <i data-lucide="map"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Distances Section -->
    <section class="container">
        <div class="distance-section reveal">
            <div class="text-center">
                <span class="section-tag">Dostupnost</span>
                <h2 class="section-title">Vše podstatné nadosah</h2>
            </div>
            <div class="distance-grid">
                <div class="distance-item">
                    <span class="distance-val">12 km</span>
                    <span class="distance-label">Vimperk</span>
                </div>
                <div class="distance-item">
                    <span class="distance-val">15 km</span>
                    <span class="distance-label">Volyně</span>
                </div>
                <div class="distance-item">
                    <span class="distance-val">22 km</span>
                    <span class="distance-label">Strakonice</span>
                </div>
                <div class="distance-item">
                    <span class="distance-val">30 km</span>
                    <span class="distance-label">NP Šumava</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Map CTA -->
    <section class="section-padding text-center">
        <div class="container">
            <div class="cta-box reveal-up" style="background: var(--text-dark); color: white; padding: 4rem; border-radius: 20px;">
                <h2 style="color: white; margin-bottom: 1.5rem;">Potřebujete mapu nebo radu?</h2>
                <p style="margin-bottom: 2.5rem; opacity: 0.8; max-width: 600px; margin-inline: auto;">
                    Na recepci Vám rádi zapůjčíme tištěné mapy, poradíme s aktuálním stavem tras nebo doporučíme ty nejlepší lokální hospůdky.
                </p>
                <a href="index.php#contact" class="btn btn-primary">Kontaktujte nás</a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/app.js"></script>
</body>
</html>




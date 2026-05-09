<?php
/**
 * Stránka: Prodej ze dvora
 * Projekt: Statek Straňovice v2
 */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    
    <meta name="description" content="Kupte si čerstvé farmářské produkty přímo z našeho statku. Bio hovězí maso, domácí vajíčka, brambory a další poctivé potraviny.">
    <?php include 'includes/head.php'; ?>
    <style>
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 3rem; }
        .product-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow); border: 1px solid var(--border); transition: var(--transition); display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-5px); border-color: var(--primary); }
        .product-img { width: 100%; height: 220px; object-fit: cover; }
        .product-info { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
        .product-tag { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--secondary); font-weight: 700; margin-bottom: 0.5rem; }
        .product-title { font-size: 1.25rem; margin-bottom: 0.8rem; color: var(--text-dark); }
        .product-desc { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.5; }
        .product-price { font-weight: 700; color: var(--primary); font-size: 1.1rem; margin-top: auto; padding-top: 1rem; border-top: 1px dashed var(--border); }
        
        .availability-badge { display: inline-block; padding: 4px 12px; border-radius: 100px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; margin-bottom: 1rem; }
        .badge-available { background: #EAF0E0; color: var(--secondary); }
        .badge-seasonal { background: #FFF4E5; color: #D48806; }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 400px;">
        <div class="hero-bg" style="background-image: url('assets/img/prodej_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Čerstvé & Poctivé</h2>
            <h1 class="hero-title fadeInDelay">Prodej ze dvora</h1>
        </div>
    </section>

    <!-- Intro -->
    <section class="section-padding">
        <div class="container text-center" style="max-width: 800px; margin-inline: auto;">
            <span class="section-tag">Z naší farmy přímo k Vám</span>
            <h2 class="section-title">Kvalita, kterou poznáte podle chuti</h2>
            <p class="section-description">
                Věříme v udržitelné hospodaření a úctu k přírodě. Proto Vám nabízíme produkty, které vznikají přímo u nás na statku Straňovice – bez zbytečné chemie, s láskou a trpělivostí.
            </p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="product-grid">
                <!-- Product 1: Beef -->
                <div class="product-card reveal">
                    <img src="assets/img/prodej_hero.png" class="product-img" alt="Bio hovězí maso">
                    <div class="product-info">
                        <span class="availability-badge badge-available">Na objednávku</span>
                        <span class="product-tag">Maso</span>
                        <h3 class="product-title">Bio hovězí maso</h3>
                        <p class="product-desc">Vyzrálé hovězí maso z našeho vlastního chovu. Prodáváme v rodinných balíčcích (5–10 kg).</p>
                        <div class="product-price">Dle aktuálního ceníku</div>
                    </div>
                </div>
                <!-- Product 2: Eggs -->
                <div class="product-card reveal-up">
                    <img src="assets/img/eggs.png" class="product-img" alt="Domácí vejce">
                    <div class="product-info">
                        <span class="availability-badge badge-available">Skladem</span>
                        <span class="product-tag">Vejce</span>
                        <h3 class="product-title">Domácí vejce</h3>
                        <p class="product-desc">Čerstvá vejce od slepic z volného výběhu. Bohatý žloutek a skvělá chuť.</p>
                        <div class="product-price">60 Kč / 10 ks</div>
                    </div>
                </div>
                <!-- Product 3: Quail Eggs -->
                <div class="product-card reveal">
                    <img src="assets/img/eggs.png" class="product-img" alt="Křepelčí vejce">
                    <div class="product-info">
                        <span class="availability-badge badge-available">Skladem</span>
                        <span class="product-tag">Specialita</span>
                        <h3 class="product-title">Křepelčí vejce</h3>
                        <p class="product-desc">Zdravá a chutná křepelčí vajíčka, plná vitamínů. Ideální pro děti i gurmány.</p>
                        <div class="product-price">50 Kč / 12 ks</div>
                    </div>
                </div>
                <!-- Product 4: Potatoes/Veggies -->
                <div class="product-card reveal-up">
                    <img src="assets/img/prodej_hero.png" class="product-img" alt="Brambory a plodiny">
                    <div class="product-info">
                        <span class="availability-badge badge-seasonal">Sezónní</span>
                        <span class="product-tag">Zahrada</span>
                        <h3 class="product-title">Brambory & Obilí</h3>
                        <p class="product-desc">Ručně tříděné brambory na uskladnění, pšenice a oves pro Vaše zvířata.</p>
                        <div class="product-price">Od 15 Kč / kg</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to buy -->
    <section class="section-padding">
        <div class="container">
            <div class="about-grid" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 4rem; align-items: center;">
                <div class="reveal">
                    <span class="section-tag">Jak nakoupit?</span>
                    <h2 class="section-title">Stavte se u nás nebo zavolejte</h2>
                    <p>
                        Prodej probíhá přímo u nás na statku v Malenicích. Doporučujeme nás předem kontaktovat telefonicky nebo e-mailem, abychom pro Vás měli vše čerstvě připravené.
                    </p>
                    <ul style="list-style: none; padding: 0; margin-top: 2rem;">
                        <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem;">
                            <i data-lucide="phone-call" style="color: var(--primary);"></i>
                            <strong>+420 123 456 789</strong>
                        </li>
                        <li style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem;">
                            <i data-lucide="mail" style="color: var(--primary);"></i>
                            <strong>info@statekstranovice.cz</strong>
                        </li>
                    </ul>
                </div>
                <div class="reveal">
                    <div style="background: var(--bg-light); padding: 3rem; border-radius: 8px; border: 1px solid var(--border);">
                        <h3>Odběrná místa</h3>
                        <p style="margin: 1.5rem 0;">Pravidelně zavážíme naše produkty také do vybraných farmářských prodejen v okolí.</p>
                        <a href="index.php#contact" class="btn btn-primary">Chci objednat</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/modals.php'; ?>
    
    <script src="assets/js/app.js"></script>
</body>
</html>




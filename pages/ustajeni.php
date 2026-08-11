<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>
<style>
    .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 3rem; }
    .feature-card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border: 1px solid var(--border, #e5e7eb); transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .feature-card:hover { transform: translateY(-5px); border-color: var(--primary, #8b5e3c); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .feature-icon { color: var(--primary, #8b5e3c); font-size: 2.5rem; margin-bottom: 1.5rem; }
    .feature-title { font-size: 1.4rem; margin-bottom: 1rem; color: var(--text-dark, #2b2b2b); }
    
    .horse-gallery { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 2rem; }
    .horse-gallery img { width: 100%; height: 250px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    @media (max-width: 768px) { .horse-gallery { grid-template-columns: 1fr; } }
    
    .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem; max-width: 1150px; margin-inline: auto; }
    .pricing-card { background: white; border-radius: 16px; padding: 2.5rem 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 2px solid var(--border, #e5e7eb); text-align: center; position: relative; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; }
    .pricing-card:hover { transform: translateY(-5px); border-color: var(--primary, #8b5e3c); box-shadow: 0 8px 30px rgba(139, 94, 60, 0.15); }
    .pricing-card.featured { border-color: var(--primary, #8b5e3c); background: linear-gradient(to bottom, #ffffff, #faf6f0); }
    .pricing-badge { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: var(--primary, #8b5e3c); color: white; padding: 4px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .pricing-header h3 { font-size: 1.6rem; color: var(--text-dark, #2b2b2b); margin-bottom: 0.5rem; }
    .pricing-price { font-size: 2.5rem; font-weight: 700; color: var(--primary, #8b5e3c); margin: 1.5rem 0 0.5rem; }
    .pricing-price span { font-size: 1rem; color: #666; font-weight: 400; }
    .pricing-features { list-style: none; padding: 0; margin: 1.5rem 0 2rem; text-align: left; }
    .pricing-features li { padding: 0.6rem 0; border-bottom: 1px dashed var(--border, #e5e7eb); display: flex; align-items: center; gap: 0.75rem; color: var(--text-dark, #2b2b2b); }
    .pricing-features li:last-child { border-bottom: none; }
    .pricing-features i { color: var(--primary, #8b5e3c); width: 18px; height: 18px; flex-shrink: 0; }
    
    .btn-outline { background-color: transparent; color: var(--primary, #8b5e3c); border: 2px solid var(--primary, #8b5e3c); font-weight: 600; padding: 0.8rem 1.8rem; border-radius: 6px; text-decoration: none; display: inline-block; text-align: center; transition: all 0.3s ease; }
    .btn-outline:hover { background-color: var(--primary, #8b5e3c); color: white; border-color: var(--primary, #8b5e3c); }
</style>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 400px;">
        <div class="hero-bg" style="background-image: url('assets/img/horse_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Pastevní péče</h2>
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
                        Na našem statku na Straňovicích nabízíme pastevní ustájení pro Vaše koně. Naším cílem je vytvořit pro koně co nejpřirozenější prostředí s důrazem na jejich pohodu a zdraví. 
                    </p>
                    <p>
                        Klademe důraz na individuální přístup ke každému koni. K dispozici jsou členité pastviny. Koně mají k dispozici celodenní pobyt venku v bezpečných stádech.
                    </p>
                    <div class="horse-gallery">
                        <img src="assets/img/horse_pasture.png" alt="Pastviny pro koně">
                        <img src="assets/img/hay_bales.png" alt="Pastviny a louky">
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
                <div class="feature-card reveal-up">
                    <div class="feature-icon"><i data-lucide="leaf"></i></div>
                    <h3 class="feature-title">Celodenní pastva</h3>
                    <p>Členité pastviny s bezpečným ohrazením. Koně tráví většinu dne venku v přirozeném stádě.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon"><i data-lucide="shield-check"></i></div>
                    <h3 class="feature-title">Individuální péče</h3>
                    <p>Dohled nad koňmi 24/7. Možnost dekování, podávání léků či asistence u kováře a veterináře.</p>
                </div>
                <div class="feature-card reveal-up">
                    <div class="feature-icon"><i data-lucide="map"></i></div>
                    <h3 class="feature-title">Zázemí statku</h3>
                    <p>Uzamykatelná sedlovna a zázemí pro jezdce k dispozici.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center" style="max-width: 700px; margin-inline: auto; margin-bottom: 3rem;">
                <span class="section-tag">Transparentní ceny</span>
                <h2 class="section-title">Ceník ustájení</h2>
                <p style="color: #666;">Vyberte si variantu ustájení podle Vašich potřeb.</p>
            </div>

            <div class="pricing-grid">
                <!-- Krátkodobé ustájení -->
                <div class="pricing-card reveal-up">
                    <div class="pricing-header">
                        <h3>Krátkodobé ustájení</h3>
                        <p style="color: #666; font-size: 0.95rem;">Pro dovolené nebo krátkodobé pobyty</p>
                        <div class="pricing-price">500 Kč <span>/ den</span></div>
                    </div>
                    <ul class="pricing-features">
                        <li><i data-lucide="check"></i> Celodenní pobyt na členitých pastvinách</li>
                        <li><i data-lucide="check"></i> Přístup k čerstvé vodě a senu</li>
                        <li><i data-lucide="check"></i> Dohled nad koněm 24/7</li>
                        <li><i data-lucide="check"></i> Využití sedlovny a zázemí statku</li>
                    </ul>
                    <a href="index.php#contact" class="btn btn-outline" style="width: 100%;">Nezávazně poptat</a>
                </div>

                <!-- Dlouhodobé ustájení -->
                <div class="pricing-card featured reveal-up">
                    <div class="pricing-badge">Nejoblíbenější</div>
                    <div class="pricing-header">
                        <h3>Dlouhodobé ustájení</h3>
                        <p style="color: #666; font-size: 0.95rem;">Kompletní celoroční pastevní péče</p>
                        <div class="pricing-price">5 000 Kč <span>/ měsíc</span></div>
                    </div>
                    <ul class="pricing-features">
                        <li><i data-lucide="check"></i> Celoroční pastevní ustájení</li>
                        <li><i data-lucide="check"></i> Členité pastviny a stabilní stádo</li>
                        <li><i data-lucide="check"></i> Seno a čerstvá voda neomezeně</li>
                        <li><i data-lucide="check"></i> Individuální péče a dekování dle dohody</li>
                        <li><i data-lucide="check"></i> Plné využití sedlovny a zázemí statku</li>
                    </ul>
                    <a href="index.php#contact" class="btn btn-primary" style="width: 100%;">Rezervovat ustájení</a>
                </div>

                <!-- Dovolená s vlastním koněm -->
                <div class="pricing-card reveal-up">
                    <div class="pricing-header">
                        <h3>Dovolená s koněm</h3>
                        <p style="color: #666; font-size: 0.95rem;">Ubytování pro vás i vašeho koně</p>
                        <div class="pricing-price" style="font-size: 1.8rem;">Dle nabídky</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i data-lucide="check"></i> Pobyt v rodinných apartmánech</li>
                        <li><i data-lucide="check"></i> Výběh s přístřeškem a dřevěná ohrada</li>
                        <li><i data-lucide="check"></i> Objemové krmení a pitná voda</li>
                        <li><i data-lucide="check"></i> Pestré terény v blízkosti NP Šumava</li>
                    </ul>
                    <a href="<?= CMS::url('dovolena-s-vlastnim-konem.php') ?>" class="btn btn-outline" style="width: 100%;">Více informací</a>
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

    <?php CMS::getFooter(); ?>




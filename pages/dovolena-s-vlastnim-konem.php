<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>
    <style>
        .about-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 4rem; align-items: center; }
        @media (max-width: 992px) { .about-grid { grid-template-columns: 1fr; gap: 2.5rem; } }

        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; }
        @media (max-width: 992px) { .feature-grid { grid-template-columns: 1fr; } }

        .feature-card { 
            background: #ffffff; 
            padding: 2.8rem 2rem; 
            border-radius: 16px; 
            box-shadow: 0 8px 30px rgba(139, 94, 60, 0.07); 
            border: 1px solid rgba(139, 94, 60, 0.15); 
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1); 
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #d4a373);
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        .feature-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 15px 35px rgba(139, 94, 60, 0.15); 
            border-color: var(--primary); 
        }
        .feature-icon { 
            color: var(--primary); 
            font-size: 2rem; 
            margin-bottom: 1.5rem; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            width: 70px; 
            height: 70px; 
            background: linear-gradient(135deg, #faf6f0 0%, #f4ece1 100%); 
            border-radius: 20px; 
            box-shadow: inset 0 0 0 1px rgba(139, 94, 60, 0.15);
            transition: transform 0.3s ease, background 0.3s ease, color 0.3s ease;
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.08) rotate(3deg);
            background: var(--primary);
            color: #ffffff;
        }
        .feature-title { font-size: 1.4rem; margin-bottom: 0.85rem; color: var(--text-dark); font-weight: 700; }
        .feature-card p { color: #5a544f; font-size: 1.02rem; line-height: 1.6; margin-bottom: 0; }

        .horse-gallery { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 2rem; }
        .horse-gallery img { width: 100%; height: 220px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        @media (max-width: 576px) { .horse-gallery { grid-template-columns: 1fr; } }
        
        .highlight-box { background: #faf6f0; border-left: 4px solid var(--primary); padding: 2rem; border-radius: 0 12px 12px 0; margin: 2rem 0; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
        .highlight-box h3 { margin-top: 0; color: var(--primary); font-size: 1.3rem; display: flex; align-items: center; gap: 0.5rem; }

        .btn-outline { background-color: transparent; color: var(--primary); border: 2px solid var(--primary); font-weight: 600; padding: 0.8rem 1.8rem; border-radius: 6px; text-decoration: none; display: inline-block; text-align: center; transition: all 0.3s ease; }
        .btn-outline:hover { background-color: var(--primary); color: white; border-color: var(--primary); }
    </style>


    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 400px;">
        <div class="hero-bg" style="background-image: url('assets/img/horse_hero.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content text-center">
            <h2 class="hero-subtitle fadeIn">Dovolená v Pošumaví s koněm</h2>
            <h1 class="hero-title fadeInDelay">Dovolená s vlastním koněm</h1>
        </div>
    </section>

    <!-- Main Description -->
    <section class="section-padding">
        <div class="container">
            <div class="about-grid">
                <div class="reveal">
                    <span class="section-tag">Unikátní zážitek</span>
                    <h2 class="section-title">Vezměte svého koně na dovolenou</h2>
                    <p class="section-description">
                        Máte jedinečnou možnost vyjet si na dovolenou i s vlastním koněm. Společně si prozkoumat novou nádhernou krajinu v blízkosti NP Šumava s vynikajícími terény – lesy, louky, lesní a polní cesty s nespočetnými možnostmi vyjížděk po okolní přírodě.
                    </p>
                    <p>
                        Zatímco vy si užijete pohodlí v našich rodinných apartmánech, pro vašeho koňského parťáka je připraveno kompletní zázemí s výběhem a přístřeškem.
                    </p>
                    
                    <div class="highlight-box">
                        <h3><i data-lucide="shield-check"></i> Vybavení pro koně v ceně</h3>
                        <p style="margin-bottom: 0;">Pro koně je k dispozici dřevěná ohrada, výběh s přístřeškem, kvalitní objemové krmení a neomezená čerstvá voda.</p>
                    </div>

                    <div class="horse-gallery">
                        <img src="assets/img/horse_pasture.png" alt="Výběh pro koně na dovolené">
                        <img src="assets/img/hay_bales.png" alt="Krajina Pošumaví v okolí statku">
                    </div>
                </div>
                <div class="reveal" style="position: relative;">
                    <div style="border: 10px solid white; box-shadow: 15px 15px 0 var(--border); border-radius: 12px; overflow: hidden;">
                        <img src="assets/img/horse_hero.png" alt="Dovolená s vlastním koněm" style="width: 100%; display: block; height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features & Equipment Grid -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="text-center" style="max-width: 750px; margin-inline: auto; margin-bottom: 3.5rem;">
                <span class="section-tag">Zázemí a terény</span>
                <h2 class="section-title">Co u nás na dovolené zažijete</h2>
                <p style="color: #666; font-size: 1.05rem;">Dokonalá kombinace odpočinku pro jezdce a přírodního vyžití pro koně.</p>
            </div>
            
            <div class="feature-grid">
                <div class="feature-card reveal-up">
                    <div class="feature-icon"><i data-lucide="home"></i></div>
                    <h3 class="feature-title">Výběh s přístřeškem</h3>
                    <p>K dispozici je dřevěná ohrada a prostorný výběh s přístřeškem pro bezpečný pobyt koně.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon"><i data-lucide="wheat"></i></div>
                    <h3 class="feature-title">Krmení a voda</h3>
                    <p>Pro vašeho koně je zajištěno kvalitní objemové krmení a neustálý přístup k pitné vodě.</p>
                </div>
                <div class="feature-card reveal-up">
                    <div class="feature-icon"><i data-lucide="trees"></i></div>
                    <h3 class="feature-title">Pestré terény a Šumava</h3>
                    <p>Nádherné vyjížďky po lesních i polních cestách, rozlehlých loukách v blízkosti NP Šumava.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="section-padding" style="background-color: #faf6f0; border-top: 1px solid var(--border);">
        <div class="container text-center" style="max-width: 800px;">
            <span class="section-tag">Rezervace a poptávka</span>
            <h2 class="section-title" style="margin-top: 0.5rem;">Naplánujte si pobyt i s Vaším koněm</h2>
            <p style="font-size: 1.15rem; color: #555; margin-bottom: 2.5rem;">
                Máte dotazy k ubytování koně nebo chcete prověřit dostupné termíny a kalkulaci? Neváhejte nás kontaktovat, rádi Vám připravíme pobyt na míru!
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?= CMS::url('index.php') ?>#contact" class="btn btn-primary btn-lg">Nezávazně poptat pobyt</a>
                <a href="<?= CMS::url('ustajeni.php') ?>" class="btn-outline">Více o ustájení koní</a>
            </div>
        </div>
    </section>

    <?php CMS::getFooter(); ?>

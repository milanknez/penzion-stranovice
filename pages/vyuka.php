<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>
<style>
    .program-section { margin-bottom: 6rem; }
    .program-row { 
        display: grid; 
        grid-template-columns: 1fr 1.1fr; 
        gap: 3.5rem; 
        align-items: stretch; 
        margin-bottom: 3.5rem; 
        background: #ffffff; 
        padding: 2.5rem; 
        border-radius: 24px; 
        box-shadow: 0 10px 35px rgba(139, 94, 60, 0.07); 
        border: 1px solid rgba(139, 94, 60, 0.12); 
    }
    .program-row.reverse {
        grid-template-columns: 1.1fr 1fr;
    }
    .program-row.reverse .program-image { order: 2; }
    .program-row.reverse .program-content { order: 1; }
    
    .program-image { 
        position: relative; 
        border-radius: 18px; 
        overflow: hidden; 
        box-shadow: var(--shadow-md); 
        min-height: 360px; 
        height: 100%; 
    }
    .program-image img { width: 100%; height: 100%; object-fit: cover; display: block; }
    
    .program-content { display: flex; flex-direction: column; justify-content: center; }
    .program-content h3 { font-size: 2rem; margin-top: 0.5rem; margin-bottom: 1rem; color: var(--text-dark); }
    .program-content p { color: var(--text-muted); line-height: 1.6; margin-bottom: 1.2rem; }
    
    .program-features { list-style: none; padding: 0; margin: 1.2rem 0; display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.8rem 1.2rem; }
    .program-features li { display: flex; align-items: center; gap: 0.6rem; color: var(--text-dark); font-size: 0.95rem; font-weight: 500; }
    .program-features i { color: var(--primary); flex-shrink: 0; width: 18px; height: 18px; }
    
    .program-info { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.5rem; margin-top: 0.5rem; }
    .info-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(139, 94, 60, 0.08); color: var(--text-dark); padding: 0.45rem 0.95rem; border-radius: 20px; font-size: 0.88rem; font-weight: 600; border: 1px solid rgba(139, 94, 60, 0.15); }
    .info-badge.price-badge { background: var(--primary); color: #ffffff; border: none; }
    .info-badge.price-badge i { color: #ffffff; }
    .info-badge i { color: var(--primary); width: 16px; height: 16px; }

    .program-divider { display: flex; align-items: center; justify-content: center; gap: 1.5rem; margin: 3.5rem 0; }
    .program-divider .divider-line { flex: 1; height: 1px; background: linear-gradient(90deg, transparent, rgba(139, 94, 60, 0.25), transparent); }
    .program-divider .divider-icon { width: 42px; height: 42px; border-radius: 50%; background: #ffffff; border: 1px solid rgba(139, 94, 60, 0.2); display: flex; align-items: center; justify-content: center; color: var(--primary); box-shadow: 0 4px 12px rgba(139,94,60,0.1); }

    .program-note-box { background: #faf6f0; border-left: 4px solid var(--primary); padding: 0.85rem 1.1rem; border-radius: 4px 10px 10px 4px; margin-bottom: 1.5rem; font-size: 0.88rem; color: var(--text-dark); line-height: 1.55; }
    .program-note-box strong { color: var(--primary); }

    .btn-outline { border: 2px solid var(--primary); color: var(--primary); background: transparent; font-weight: 600; }
    .btn-outline:hover { background: var(--primary); color: white; }

    @media (max-width: 992px) {
        .program-row, .program-row.reverse { grid-template-columns: 1fr !important; gap: 2rem; padding: 1.5rem; }
        .program-image { height: 280px; min-height: 280px; }
        .program-row.reverse .program-image { order: 1; }
        .program-row.reverse .program-content { order: 2; }
        .program-features { grid-template-columns: 1fr; }
    }
</style>

    <!-- Hero Section -->
    <section class="hero" style="height: 60vh; min-height: 450px;">
        <div class="hero-bg" style="background-image: url('/assets/img/vyuka_hero.png');"></div>
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
                    Věříme, že nejlépe se člověk učí tím, co si sám vyzkouší. Naše programy jsou navrženy tak, aby dětem i dospělým přiblížily život na venkově a důležitost udržitelného hospodaření.
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
                        <p>Zážitkový program zaměřený na první kontakt se zvířaty. Děti si vyzkouší zemědělské stroje a seznámí se s pěstováním rostlin.</p>
                        <ul class="program-features">
                            <li><i data-lucide="check-circle"></i> Krmení zvířat</li>
                            <li><i data-lucide="check-circle"></i> Ukázka zemědělských strojů</li>
                            <li><i data-lucide="check-circle"></i> Praktické dovednosti</li>
                            <li><i data-lucide="check-circle"></i> Tvořivá dílna</li>
                            <li><i data-lucide="check-circle"></i> Jízda na koni</li>
                        </ul>
                        <div class="program-info">
                            <span class="info-badge price-badge"><i data-lucide="tag"></i> <strong>Cena:</strong> 100 Kč / osoba</span>
                            <span class="info-badge"><i data-lucide="users"></i> <strong>Minimální počet osob:</strong> 5</span>
                        </div>
                        <a href="/?program=Den+malého+farmáře#contact" class="btn btn-primary">Mám zájem o program</a>
                    </div>
                </div>

                <!-- Oddělovač -->
                <div class="program-divider">
                    <div class="divider-line"></div>
                    <div class="divider-icon"><i data-lucide="sprout"></i></div>
                    <div class="divider-line"></div>
                </div>

                <!-- Program 2 -->
                <div class="program-row reverse reveal-up">
                    <div class="program-image">
                        <img src="assets/img/eggs.png" alt="Farmářem na zkoušku">
                    </div>
                    <div class="program-content">
                        <span class="section-tag">Zážitkový program pro dospělé i rodiny</span>
                        <h3>Farmářem na zkoušku</h3>
                        <p>Toužíte na chvíli utéct z města a zažít opravdový život na farmě? Přijďte si vyzkoušet, jak vypadá den farmáře. Nečeká vás žádná atrakce, ale skutečná práce se zvířaty a každodenní chod hospodářství.</p>
                        
                        <ul class="program-features">
                            <li><i data-lucide="check-circle"></i> Seznámení s farmou a zvířaty</li>
                            <li><i data-lucide="check-circle"></i> Krmení krav, telat a hospodářství</li>
                            <li><i data-lucide="check-circle"></i> Pomoc při farmářských pracích</li>
                            <li><i data-lucide="check-circle"></i> Jízda traktorem (dle možností)</li>
                            <li><i data-lucide="check-circle"></i> Povídání o chovu masného skotu</li>
                            <li><i data-lucide="check-circle"></i> Kontakt a foto se zvířaty</li>
                        </ul>

                        <div class="program-info">
                            <span class="info-badge price-badge"><i data-lucide="tag"></i> <strong>Cena:</strong> cca 1 900 Kč</span>
                            <span class="info-badge"><i data-lucide="clock"></i> <strong>Délka:</strong> 3–5 hodin</span>
                            <span class="info-badge"><i data-lucide="users"></i> <strong>Vhodné pro:</strong> rodiny, páry i jednotlivce</span>
                        </div>

                        <div class="program-note-box">
                            <strong>Doporučujeme:</strong> Pevnou uzavřenou obuv a pracovní oblečení, které se může ušpinit. Každá návštěva je jiná – program se přizpůsobuje počasí i aktuálním pracím na farmě (sklizeň sena, péče o telata, krmení).
                        </div>

                        <a href="/?program=Farmářem+na+zkoušku#contact" class="btn btn-primary">Mám zájem o program</a>
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
                <a href="tel:+420123456789" class="btn btn-primary"><i data-lucide="phone"></i> Zavolejte nám</a>
                <a href="/?program=Program+na+míru#contact" class="btn btn-outline">Napište nám</a>
            </div>
        </div>
    </section>

    <?php CMS::getFooter(); ?>




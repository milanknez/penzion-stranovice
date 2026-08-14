<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>

<style>
    .food-filters-wrapper {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 2.5rem;
        margin-bottom: 2rem;
    }
    .filter-btn {
        background: #ffffff;
        color: #2C241E;
        border: 2px solid var(--border, #E6D7C3);
        padding: 0.75rem 1.4rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .filter-btn i,
    .filter-btn svg {
        color: inherit;
        stroke: currentColor;
    }
    .filter-btn:hover {
        background: var(--primary, #8B5E3C) !important;
        border-color: var(--primary, #8B5E3C) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
    }
    .filter-btn:hover *,
    .filter-btn:hover .filter-count,
    .filter-btn:hover i,
    .filter-btn:hover svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }
    .filter-btn:hover .filter-count {
        background: rgba(255,255,255,0.25) !important;
    }
    .filter-btn.active {
        background: var(--primary, #8B5E3C) !important;
        color: #ffffff !important;
        border-color: var(--primary, #8B5E3C) !important;
        box-shadow: 0 4px 12px rgba(139, 94, 60, 0.35);
    }
    .filter-btn.active *,
    .filter-btn.active .filter-count,
    .filter-btn.active i,
    .filter-btn.active svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }
    .filter-btn.active .filter-count {
        background: rgba(255,255,255,0.25) !important;
    }
    .filter-count {
        background: rgba(0,0,0,0.08);
        color: inherit;
        font-size: 0.8rem;
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-weight: 700;
        transition: all 0.25s ease;
    }

    .category-note-box {
        background: #f0f7ef;
        border-left: 4px solid var(--primary, #2d5a27);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin: 1.5rem auto 2.5rem;
        max-width: 750px;
        color: var(--text-dark, #2d3748);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-align: left;
    }
    .category-note-box i {
        color: var(--primary, #2d5a27);
        flex-shrink: 0;
    }

    .food-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    .food-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow, 0 4px 20px rgba(0,0,0,0.07));
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid var(--border, #e2e8f0);
        display: flex;
        flex-direction: column;
        width: 100%;
        position: relative;
    }
    .food-card.is-hidden {
        display: none !important;
    }
    .food-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 14px 32px rgba(0,0,0,0.12);
        border-color: rgba(45, 90, 39, 0.3);
    }
    
    .food-card-header {
        position: relative;
        background: linear-gradient(135deg, #2d5a27 0%, #1e3d1a 100%);
        padding: 1.5rem 1.75rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #ffffff;
    }
    .food-card-icon-pill {
        width: 44px;
        height: 44px;
        min-width: 44px;
        min-height: 44px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.25);
        cursor: pointer;
        box-sizing: border-box;
    }
    .food-card-icon-pill svg,
    .food-card-icon-pill i,
    .food-card-icon-pill .lucide {
        width: 22px !important;
        height: 22px !important;
        min-width: 22px !important;
        min-height: 22px !important;
        max-width: 22px !important;
        max-height: 22px !important;
        stroke-width: 2.2px;
        display: block;
        pointer-events: none;
    }
    .food-badge {
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary, #2d5a27);
        padding: 0.4rem 0.9rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .food-content {
        padding: 1.75rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .food-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        color: var(--text-light, #718096);
        font-size: 0.88rem;
        font-weight: 500;
    }
    .food-type-pill {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .food-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .food-title {
        margin-bottom: 0.75rem;
        font-size: 1.25rem;
        color: var(--text-dark, #1a202c);
        line-height: 1.35;
        font-weight: 700;
    }
    .food-description {
        color: var(--text-muted, #4a5568);
        line-height: 1.6;
        margin-bottom: 1.25rem;
        font-size: 0.95rem;
    }
    .food-highlights {
        margin-bottom: 1.5rem;
        padding-left: 0;
        list-style: none;
        color: var(--text-muted, #4a5568);
        font-size: 0.88rem;
        line-height: 1.6;
    }
    .food-highlights li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.4rem;
    }
    .food-highlights li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--primary, #2d5a27);
        font-weight: bold;
    }
    .food-footer {
        margin-top: auto;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border, #edf2f7);
    }
    .btn-gmaps {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        background: var(--primary, #2d5a27);
        color: #ffffff;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(45, 90, 39, 0.2);
        width: 100%;
        border: none;
        cursor: pointer;
    }
    .btn-gmaps:hover {
        background: #1e3d1a;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(45, 90, 39, 0.3);
    }

    .distance-section {
        background: var(--bg-light, #f8fafc);
        border-radius: 24px;
        padding: 4rem 2rem;
        margin: 4rem 0;
        border: 1px solid var(--border, #e2e8f0);
    }
    .distance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 1.25rem;
        margin-top: 2.5rem;
    }
    .distance-item {
        background: #ffffff;
        padding: 2rem 1rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid var(--border, #e2e8f0);
        transition: transform 0.3s ease;
    }
    .distance-item:hover {
        transform: translateY(-4px);
    }
    .distance-val {
        display: block;
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--primary, #2d5a27);
        margin-bottom: 0.4rem;
        line-height: 1.1;
    }
    .distance-sub {
        display: block;
        font-size: 0.85rem;
        color: var(--text-light, #718096);
        margin-bottom: 0.4rem;
        font-weight: 500;
    }
    .distance-label {
        font-weight: 600;
        color: var(--text-dark, #2d3748);
        font-size: 0.95rem;
    }
</style>

<!-- Hero Section -->
<section class="hero" style="height: 55vh; min-height: 420px;">
    <div class="hero-bg" style="background-image: url(/assets/img/breakfast.png);"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h2 class="hero-subtitle fadeIn">Kam se dobře najíst, dát si kávu nebo posedět</h2>
        <h1 class="hero-title fadeInDelay">Kam na jídlo</h1>
    </div>
</section>

<!-- Main Content -->
<section class="section-padding">
    <div class="container">
        <div class="text-center" style="max-width: 850px; margin-inline: auto;">
            <span class="section-tag">Gastronomie v okolí</span>
            <h2 class="section-title">Kam se dobře najíst, dát si kávu nebo posedět</h2>
            <p class="section-description">
                V okolí našeho penzionu najdete řadu míst, kde si můžete dát dobré jídlo, posedět u kávy nebo si po výletě odpočinout. Vybrali jsme pro vás podniky v příjemné dojezdové vzdálenosti, které mohou zpříjemnit váš pobyt v krásném prostředí Pošumaví.
            </p>

            <!-- Filter Buttons -->
            <div class="food-filters-wrapper">
                <button class="filter-btn active" data-filter="all">
                    <i data-lucide="grid"></i> Všechny podniky <span class="filter-count">30</span>
                </button>
                <button class="filter-btn" data-filter="malenice">
                    <i data-lucide="map-pin"></i> Malenice <span class="filter-count">3</span>
                </button>
                <button class="filter-btn" data-filter="volyne">
                    <i data-lucide="map-pin"></i> Volyně <span class="filter-count">6</span>
                </button>
                <button class="filter-btn" data-filter="ckyne">
                    <i data-lucide="map-pin"></i> Čkyně <span class="filter-count">3</span>
                </button>
                <button class="filter-btn" data-filter="husinec">
                    <i data-lucide="map-pin"></i> Husinec <span class="filter-count">1</span>
                </button>
                <button class="filter-btn" data-filter="vimperk">
                    <i data-lucide="map-pin"></i> Vimperk <span class="filter-count">5</span>
                </button>
                <button class="filter-btn" data-filter="prachatice">
                    <i data-lucide="map-pin"></i> Prachatice <span class="filter-count">4</span>
                </button>
                <button class="filter-btn" data-filter="strakonice">
                    <i data-lucide="map-pin"></i> Strakonice <span class="filter-count">8</span>
                </button>
            </div>

            <!-- Dynamic Category Note -->
            <div id="categoryNoteBox" class="category-note-box" style="display: none;">
                <i data-lucide="info"></i>
                <span id="categoryNoteText"></span>
            </div>
        </div>

        <!-- Food Grid -->
        <div class="food-grid" id="foodGrid">

            <!-- 1. MALENICE: Hospůdka pod Věncem -->
            <div class="food-card" data-category="malenice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="beer"></i>
                    </div>
                    <span class="food-badge">Malenice a okolí • 5 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Letní kiosek &amp; Občerstvení</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 3,5 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 5 min</span>
                    </div>
                    <h3 class="food-title">Hospůdka pod Věncem („kiosek“) – Lčovice</h3>
                    <p class="food-description">Oblíbené letní posezení s pohodovou atmosférou. Ideální zastávka po výletě nebo při cyklovýletu.</p>
                    <ul class="food-highlights">
                        <li>Oblíbené letní posezení v přírodě</li>
                        <li>Ideální zastávka po výletě či při cyklovýletu</li>
                        <li>Pohodová atmosféra pod vrchem Věnec</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Hosp%C5%AFdka+pod+V%C4%9Bncem+L%C4%8Dovice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. MALENICE: Malenická hospůdka -->
            <div class="food-card" data-category="malenice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="beer"></i>
                    </div>
                    <span class="food-badge">Malenice a okolí • 5 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Místní hospůdka</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 2 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 4 min</span>
                    </div>
                    <h3 class="food-title">Malenická hospůdka – Malenice</h3>
                    <p class="food-description">Menší místní hospůdka vhodná na večerní posezení.</p>
                    <ul class="food-highlights">
                        <li>Menší místní hospůdka</li>
                        <li>Vhodná na klidné večerní posezení</li>
                        <li>V centru malebné obce Malenice</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Malenick%C3%A1+hosp%C5%AFdka+Malenice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. MALENICE: Hospoda Na Zámostí -->
            <div class="food-card" data-category="malenice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="beer"></i>
                    </div>
                    <span class="food-badge">Malenice a okolí • 5 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Tradiční hospoda</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 2 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 4 min</span>
                    </div>
                    <h3 class="food-title">Hospoda Na Zámostí – Malenice</h3>
                    <p class="food-description">Klasická vesnická hospoda s příjemnou atmosférou.</p>
                    <ul class="food-highlights">
                        <li>Klasická vesnická hospoda</li>
                        <li>Příjemná atmosféra</li>
                        <li>Posezení u piva kousek od statku</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Hospoda+Na+Z%C3%A1most%C3%AD+Malenice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 4. VOLYNĚ: Restaurace U Radnice -->
            <div class="food-card" data-category="volyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Volyně • 10 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Restaurace v centru</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 8 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 8–10 min</span>
                    </div>
                    <h3 class="food-title">Restaurace U Radnice</h3>
                    <p class="food-description">Příjemná restaurace v centru Volyně vhodná na oběd i večerní posezení.</p>
                    <ul class="food-highlights">
                        <li>Příjemná restaurace v centru Volyně</li>
                        <li>Vhodná na oběd i večerní posezení</li>
                        <li>Přímo na historickém náměstí</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+U+Radnice+Volyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 5. VOLYNĚ: Restaurace Na Nové -->
            <div class="food-card" data-category="volyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Volyně • 10 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Tradiční česká kuchyně</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 8 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 8–10 min</span>
                    </div>
                    <h3 class="food-title">Restaurace Na Nové</h3>
                    <p class="food-description">Tradiční restaurace s nabídkou české kuchyně.</p>
                    <ul class="food-highlights">
                        <li>Tradiční česká kuchyně</li>
                        <li>Poctivá nabídka jídel a denní menu</li>
                        <li>Příjemné posezení ve Volyni</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+Na+Nov%C3%A9+Volyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 6. VOLYNĚ: Bufet Volyňka -->
            <div class="food-card" data-category="volyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Volyně • 10 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Rychlé občerstvení &amp; Bufet</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 8 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 8–10 min</span>
                    </div>
                    <h3 class="food-title">Bufet Volyňka</h3>
                    <p class="food-description">Praktická zastávka na rychlý oběd, svačinu nebo občerstvení během výletů.</p>
                    <ul class="food-highlights">
                        <li>Praktická zastávka na rychlý oběd</li>
                        <li>Svačiny a občerstvení během výletů</li>
                        <li>Rychlé a pohodové jídlo</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Bufet+Voly%C5%88ka+Volyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 7. VOLYNĚ: Kebab / pizza – Volyně -->
            <div class="food-card" data-category="volyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="pizza"></i>
                    </div>
                    <span class="food-badge">Volyně • 10 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Bistro &amp; Rychlé občerstvení</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 8 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 8–10 min</span>
                    </div>
                    <h3 class="food-title">Kebab / pizza – Volyně</h3>
                    <p class="food-description">Možnost rychlého občerstvení, když hledáte něco jednoduchého na cestu.</p>
                    <ul class="food-highlights">
                        <li>Rychlé občerstvení na cestu</li>
                        <li>Pizza i kebab</li>
                        <li>Jednoduchá a rychlá volba</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Kebab+pizza+Volyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 8. VOLYNĚ: Pekařství U Hrocha -->
            <div class="food-card" data-category="volyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="coffee"></i>
                    </div>
                    <span class="food-badge">Volyně • 10 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Pekařství &amp; Káva</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 8 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 8–10 min</span>
                    </div>
                    <h3 class="food-title">Pekařství U Hrocha</h3>
                    <p class="food-description">Výborná zastávka pro čerstvé pečivo, sladké dobroty nebo kávu. Ideální před výletem – koupit si něco dobrého s sebou na cestu.</p>
                    <ul class="food-highlights">
                        <li>Čerstvé křupavé pečivo</li>
                        <li>Sladké dobroty a zákusky</li>
                        <li>Výborná káva s sebou na výlet</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Peka%C5%99stv%C3%AD+U+Hrocha+Volyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 9. VOLYNĚ: Italská cukrárna a zmrzlina -->
            <div class="food-card" data-category="volyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="ice-cream"></i>
                    </div>
                    <span class="food-badge">Volyně • 10 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Cukrárna &amp; Zmrzlina</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 8 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 8–10 min</span>
                    </div>
                    <h3 class="food-title">Italská cukrárna a zmrzlina</h3>
                    <p class="food-description">Příjemné místo pro zastávku na kávu, zmrzlinu nebo něco sladkého.</p>
                    <ul class="food-highlights">
                        <li>Poctivá zmrzlina v letních dnech</li>
                        <li>Příjemné posezení u kávy</li>
                        <li>Sladké dobroty a dezerty</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Italsk%C3%A1+cukr%C3%A1rna+Volyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 10. ČKYNĚ: Restaurace Ve Votáčce -->
            <div class="food-card" data-category="ckyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Čkyně • 8 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Tradiční restaurace</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 5 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 6–8 min</span>
                    </div>
                    <h3 class="food-title">Restaurace Ve Votáčce</h3>
                    <p class="food-description">Tradiční restaurace vhodná pro posezení u jídla.</p>
                    <ul class="food-highlights">
                        <li>Tradiční restaurace</li>
                        <li>Vhodná pro posezení u jídla</li>
                        <li>Česká poctivá kuchyně ve Čkyni</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+Ve+Vot%C3%A1%C4%8Dce+%C4%8Ckyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 11. ČKYNĚ: Bufet Čkyně -->
            <div class="food-card" data-category="ckyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Čkyně • 8 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Rychlé občerstvení &amp; Oběd</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 5 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 6–8 min</span>
                    </div>
                    <h3 class="food-title">Bufet Čkyně</h3>
                    <p class="food-description">Oblíbená možnost pro rychlé občerstvení nebo oběd.</p>
                    <ul class="food-highlights">
                        <li>Oblíbená možnost rychlého občerstvení</li>
                        <li>Rychlý oběd na cestách</li>
                        <li>Dostupná poloha ve Čkyni</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Bufet+%C4%8Ckyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 12. ČKYNĚ: Kavárna a cukrárna Lucie -->
            <div class="food-card" data-category="ckyne">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="coffee"></i>
                    </div>
                    <span class="food-badge">Čkyně • 8 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Kavárna &amp; Cukrárna</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 5 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 6–8 min</span>
                    </div>
                    <h3 class="food-title">Kavárna a cukrárna Lucie</h3>
                    <p class="food-description">Ověřené místo pro milovníky dobré kávy a sladkého. Doporučujeme především domácí zákusky a příjemné posezení.</p>
                    <ul class="food-highlights">
                        <li>Ověřené místo pro milovníky kávy a sladkého</li>
                        <li>Především doporučujeme domácí zákusky</li>
                        <li>Příjemné a klidné posezení</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Kav%C3%A1rna+Lucie+%C4%8Ckyn%C4%9B" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 13. HUSINEC: Pizzerie u Blanice -->
            <div class="food-card" data-category="husinec">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="pizza"></i>
                    </div>
                    <span class="food-badge">Husinec • 15 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Pizzerie &amp; Steaky</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 16 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 15 min</span>
                    </div>
                    <h3 class="food-title">Pizzerie u Blanice</h3>
                    <p class="food-description">Dobrá volba pro milovníky pizzy a steaků a neformálního posezení.</p>
                    <ul class="food-highlights">
                        <li>Vypečená pizza a šťavnaté steaky</li>
                        <li>Neformální a příjemné posezení</li>
                        <li>Oblíbená zastávka v Husinci</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Pizzerie+u+Blanice+Husinec" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 14. VIMPERK: Restaurace Vodník -->
            <div class="food-card" data-category="vimperk">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Vimperk • 15–20 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Restaurace v přírodním areálu</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 14 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 18 min</span>
                    </div>
                    <h3 class="food-title">Restaurace Vodník</h3>
                    <p class="food-description">Příjemné místo pro oběd nebo večeři při návštěvě Vimperka.</p>
                    <ul class="food-highlights">
                        <li>Příjemné místo pro oběd nebo večeři</li>
                        <li>Přírodní areál u rybníka Vodník</li>
                        <li>Krásné prostředí na procházku</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+Vodn%C3%ADk+Vimperk" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 15. VIMPERK: Hotel a restaurace Terasa -->
            <div class="food-card" data-category="vimperk">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Vimperk • 15–20 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Tradiční restaurace</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 13 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 15 min</span>
                    </div>
                    <h3 class="food-title">Hotel a restaurace Terasa</h3>
                    <p class="food-description">Restaurace s tradiční kuchyní a možností příjemného posezení.</p>
                    <ul class="food-highlights">
                        <li>Tradiční poctivá kuchyně</li>
                        <li>Možnost příjemného posezení</li>
                        <li>Kvalitní zázemí ve Vimperku</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Hotel+a+restaurace+Terasa+Vimperk" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 16. VIMPERK: HD Burgers -->
            <div class="food-card" data-category="vimperk">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Vimperk • 15–20 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Burger bistro</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 13 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 15 min</span>
                    </div>
                    <h3 class="food-title">HD Burgers</h3>
                    <p class="food-description">Tip pro milovníky kvalitních burgerů a neformálního posezení.</p>
                    <ul class="food-highlights">
                        <li>Kvalitní a poctivé burgery</li>
                        <li>Hranolky a originální omáčky</li>
                        <li>Neformální moderní atmosféra</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=HD+Burgers+Vimperk" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 17. VIMPERK: Pizzerie Marco -->
            <div class="food-card" data-category="vimperk">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="pizza"></i>
                    </div>
                    <span class="food-badge">Vimperk • 15–20 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Pizzerie &amp; Italská kuchyně</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 13 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 15 min</span>
                    </div>
                    <h3 class="food-title">Pizzerie Marco</h3>
                    <p class="food-description">Oblíbená volba pro milovníky pizzy a italské kuchyně.</p>
                    <ul class="food-highlights">
                        <li>Oblíbená volba pro milovníky pizzy</li>
                        <li>Italská kuchyně a těstoviny</li>
                        <li>Příjemné prostředí ve Vimperku</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Pizzerie+Marco+Vimperk" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 18. VIMPERK: Cukrárna Pod Zámkem -->
            <div class="food-card" data-category="vimperk">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="coffee"></i>
                    </div>
                    <span class="food-badge">Vimperk • 15–20 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Cukrárna &amp; Káva</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 13 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 15 min</span>
                    </div>
                    <h3 class="food-title">Cukrárna Pod Zámkem</h3>
                    <p class="food-description">Příjemné místo pro milovníky kávy, zákusků a zmrzliny. Ideální zastávka při procházce historickým centrem Vimperka.</p>
                    <ul class="food-highlights">
                        <li>Výborná káva, domácí zákusky a zmrzlina</li>
                        <li>Ideální zastávka pod zámkem Vimperk</li>
                        <li>Procházka historickým centrem</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Cukr%C3%A1rna+Pod+Z%C3%A1mkem+Vimperk" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 19. PRACHATICE: Pivovar Prachatice -->
            <div class="food-card" data-category="prachatice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="beer"></i>
                    </div>
                    <span class="food-badge">Prachatice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Pivovar &amp; Restaurace</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 23 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Pivovar Prachatice</h3>
                    <p class="food-description">Jedno z míst, které stojí za návštěvu. Krásné prostředí historického pivovaru, vlastní pivo a kuchyně vhodná pro příjemný oběd nebo večeři.</p>
                    <ul class="food-highlights">
                        <li>Krásné prostředí historického pivovaru</li>
                        <li>Vlastní řemeslné pivo</li>
                        <li>Skvělá kuchyně pro příjemný oběd i večeři</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Pivovar+Prachatice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 20. PRACHATICE: Almara Pub & Restaurant -->
            <div class="food-card" data-category="prachatice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Prachatice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Moderní restaurace &amp; Pub</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 23 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Almara Pub &amp; Restaurant</h3>
                    <p class="food-description">Modernější podnik přímo v centru města.</p>
                    <ul class="food-highlights">
                        <li>Moderní podnik v centru Prachatic</li>
                        <li>Zajímavý jídelní lístek a nápoje</li>
                        <li>Příjemná večerní atmosféra</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Almara+Pub+Restaurant+Prachatice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 21. PRACHATICE: Pizza bistro In Bocca -->
            <div class="food-card" data-category="prachatice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="pizza"></i>
                    </div>
                    <span class="food-badge">Prachatice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Pizza bistro</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 23 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Pizza bistro In Bocca</h3>
                    <p class="food-description">Tip pro milovníky pizzy.</p>
                    <ul class="food-highlights">
                        <li>Autentická a křupavá pizza</li>
                        <li>Kvalitní italské ingredience</li>
                        <li>Rychlé a chutné posezení</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Pizza+bistro+In+Bocca+Prachatice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 22. PRACHATICE: Cafe Madona -->
            <div class="food-card" data-category="prachatice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="coffee"></i>
                    </div>
                    <span class="food-badge">Prachatice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Kavárna v historickém centru</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 23 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Cafe Madona</h3>
                    <p class="food-description">Příjemná kavárna v historickém centru, ideální na kávu a zákusek při procházce Prachaticemi.</p>
                    <ul class="food-highlights">
                        <li>Příjemná kavárna v historickém jádru města</li>
                        <li>Vynikající káva a dezerty</li>
                        <li>Ideální odpočinek při procházce</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Cafe+Madona+Prachatice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 23. STRAKONICE: Lovecká bašta -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Zážitková restaurace</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 19 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 22 min</span>
                    </div>
                    <h3 class="food-title">Lovecká bašta</h3>
                    <p class="food-description">Jedno z míst, které bychom určitě doporučili. Příjemné prostředí a zajímavá nabídka jídel – vhodná volba pro slavnostnější oběd nebo večeři.</p>
                    <ul class="food-highlights">
                        <li>Jedno z míst, které určitě doporučujeme</li>
                        <li>Zajímavá nabídka jídel a příjemné prostředí</li>
                        <li>Vhodná volba pro slavnostnější oběd i večeři</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Loveck%C3%A1+ba%C5%A1ta+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 24. STRAKONICE: Restaurace U Dudáka -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="beer"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Tradiční pivovarská restaurace</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 20 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Restaurace U Dudáka</h3>
                    <p class="food-description">Tradiční restaurace spojená se strakonickým pivem, vhodná pro klasickou kuchyni a příjemné posezení.</p>
                    <ul class="food-highlights">
                        <li>Spojení se strakonickým pivem Dudák</li>
                        <li>Klasická poctivá kuchyně</li>
                        <li>Tradiční příjemné posezení</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+U+Dud%C3%A1ka+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 25. STRAKONICE: Restaurace Sokolovna -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Česká kuchyně</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 20 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Restaurace Sokolovna</h3>
                    <p class="food-description">Příjemná restaurace s českou kuchyní.</p>
                    <ul class="food-highlights">
                        <li>Poctivá česká jídla a denní menu</li>
                        <li>Příjemné a prostorné posezení</li>
                        <li>Tradiční strakonický podnik</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+Sokolovna+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 26. STRAKONICE: Hangár Plzeňka -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="beer"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Pivnice &amp; Restaurace</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 20 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Hangár Plzeňka</h3>
                    <p class="food-description">Tradiční restaurace pro milovníky české kuchyně a piva.</p>
                    <ul class="food-highlights">
                        <li>Výborně ošetřené točené pivo</li>
                        <li>Tradiční česká kuchyně</li>
                        <li>Oblíbené místo pro posezení s přáteli</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Hang%C3%A1r+Plze%C5%88ka+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 27. STRAKONICE: Restaurace U města Prahy -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Klasická restaurace v centru</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 20 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Restaurace U města Prahy</h3>
                    <p class="food-description">Klasická restaurace v centru Strakonic.</p>
                    <ul class="food-highlights">
                        <li>Přímo v centru města Strakonice</li>
                        <li>Klasická jídla a točené pivo</li>
                        <li>Příjemná a dostupná poloha</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+U+m%C4%9Bsta+Prahy+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 28. STRAKONICE: Restaurace U Papeže -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Tradiční posezení</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 20 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Restaurace U Papeže</h3>
                    <p class="food-description">Další možnost příjemného posezení při návštěvě města.</p>
                    <ul class="food-highlights">
                        <li>Příjemné posezení při návštěvě Strakonic</li>
                        <li>Dobrá kuchyně a nápoje</li>
                        <li>Klidná atmosféra</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+U+Pape%C5%BEe+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 29. STRAKONICE: Restaurace Na Splávku -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="utensils"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Restaurace u řeky</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 20 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Restaurace Na Splávku</h3>
                    <p class="food-description">Příjemné posezení při návštěvě Strakonic.</p>
                    <ul class="food-highlights">
                        <li>Příjemné posezení nedaleko řeky Otavy</li>
                        <li>Letní terasa a čerstvý vzduch</li>
                        <li>Minutky a točené nápoje</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Restaurace+Na+Spl%C3%A1vku+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

            <!-- 30. STRAKONICE: Cukrárna Hvězda -->
            <div class="food-card" data-category="strakonice">
                <div class="food-card-header">
                    <div class="food-card-icon-pill">
                        <i data-lucide="coffee"></i>
                    </div>
                    <span class="food-badge">Strakonice • 25 min</span>
                </div>
                <div class="food-content">
                    <div class="food-meta">
                        <span class="food-type-pill">Cukrárna &amp; Káva</span>
                        <span class="food-meta-item"><i data-lucide="map-pin"></i> 20 km</span>
                        <span class="food-meta-item"><i data-lucide="clock"></i> 25 min</span>
                    </div>
                    <h3 class="food-title">Cukrárna Hvězda</h3>
                    <p class="food-description">Zákusek nebo něco sladkého při návštěvě města.</p>
                    <ul class="food-highlights">
                        <li>Čerstvé dortíky, zákusky a chlebíčky</li>
                        <li>Káva s sebou i na posezení</li>
                        <li>Sladké zakončení návštěvy Strakonic</li>
                    </ul>
                    <div class="food-footer">
                        <a href="https://www.google.com/maps/search/?api=1&query=Cukr%C3%A1rna+Hv%C4%9Bzda+Strakonice" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="navigation"></i> Otevřít v mapách
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Distances Section -->
<section class="container">
    <div class="distance-section">
        <div class="text-center">
            <span class="section-tag">Dojezdové vzdálenosti</span>
            <h2 class="section-title">Všechny oblíbené podniky v pohodlném dosahu</h2>
            <p class="section-description" style="max-width: 600px; margin-inline: auto;">
                Ze Statku Straňovice jste autem, na kole nebo pěšky za chvilku u skvělého jídla, voňavé kávy i oroseného piva.
            </p>
        </div>
        <div class="distance-grid">
            <div class="distance-item">
                <span class="distance-val">5 min</span>
                <span class="distance-sub">2 – 3,5 km</span>
                <span class="distance-label">Malenice a Lčovice</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">8 min</span>
                <span class="distance-sub">5 km</span>
                <span class="distance-label">Čkyně</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">10 min</span>
                <span class="distance-sub">8 km</span>
                <span class="distance-label">Volyně</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">15 min</span>
                <span class="distance-sub">16 km</span>
                <span class="distance-label">Husinec</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">15–20 min</span>
                <span class="distance-sub">13 – 14 km</span>
                <span class="distance-label">Vimperk</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">25 min</span>
                <span class="distance-sub">23 km</span>
                <span class="distance-label">Prachatice</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">25 min</span>
                <span class="distance-sub">19 – 20 km</span>
                <span class="distance-label">Strakonice</span>
            </div>
        </div>
    </div>
</section>

<!-- Bottom CTA Box -->
<section class="section-padding text-center" style="padding-top: 0;">
    <div class="container">
        <div class="cta-box" style="background: var(--text-dark, #1a202c); color: white; padding: 4rem 2rem; border-radius: 24px;">
            <h2 style="color: white; margin-bottom: 1.5rem;">Hledáte tip na dnešní večeři nebo rodinnou oslavu?</h2>
            <p style="margin-bottom: 2.5rem; opacity: 0.85; max-width: 650px; margin-inline: auto; font-size: 1.1rem; line-height: 1.6;">
                Rádi vám přímo na místě doporučíme aktuálně otevřené podniky, denní speciality nebo zajistíme tip na nejlepší domácí kuchyni a cukrárnu v okolí.
            </p>
            <a href="<?= CMS::url('index.php') ?>#contact" class="btn btn-primary">Kontaktujte nás</a>
        </div>
    </div>
</section>

<!-- JS Filtering Script -->
<script>
(function() {
    const categoryNotes = {
        'malenice': 'Malenice a okolí (5 minut): spíše příjemné posezení než klasická restaurace.',
        'strakonice': 'Strakonice (25 minut): Pokud budete mít cestu do Strakonic, můžete návštěvu města spojit s příjemným obědem, večeří nebo kávou.',
        'volyne': 'Volyně (10 minut): Restaurace, kavárny, cukrárny a rychlé občerstvení v historickém městečku u řeky Volyňky.',
        'ckyne': 'Čkyně (8 minut): Oblíbené zastávky na jídlo, rychlé občerstvení i vyhlášenou kávu se zákuskem.',
        'husinec': 'Husinec (15 minut): Skvělá pizza, steaky a neformální posezení.',
        'vimperk': 'Vimperk (15–20 minut): Restaurace u rybníka, kvalitní burgery, italská pizza i cukrárna pod zámkem.',
        'prachatice': 'Prachatice (25 minut): Historický řemeslný pivovar s výbornou kuchyní, moderní puby i útulné kavárny.'
    };

    function initFoodFilters() {
        const filterBtns = document.querySelectorAll('.food-filters-wrapper .filter-btn');
        const foodCards = document.querySelectorAll('#foodGrid .food-card');
        const noteBox = document.getElementById('categoryNoteBox');
        const noteText = document.getElementById('categoryNoteText');
        if (!filterBtns.length || !foodCards.length) return;

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                if (filterValue !== 'all' && categoryNotes[filterValue]) {
                    noteText.textContent = categoryNotes[filterValue];
                    noteBox.style.display = 'flex';
                } else {
                    noteBox.style.display = 'none';
                }

                foodCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');
                    if (filterValue === 'all' || cardCategory === filterValue) {
                        card.classList.remove('is-hidden');
                        card.style.display = 'flex';
                        card.style.opacity = '1';
                    } else {
                        card.classList.add('is-hidden');
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFoodFilters);
    } else {
        initFoodFilters();
    }
})();
</script>

<?php CMS::getFooter(); ?>

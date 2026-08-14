<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg" style="background-image: url('/assets/img/hero_statek.jpg');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Vítejte v náruči přírody</h2>
            <h1 class="hero-title fadeInDelay">Statek Straňovice</h1>
            <p class="hero-description fadeInExtra">Penzion u Malenic. Autentická atmosféra, kde se čas zastavil. Objevte klid venkova v moderním hávu.</p>
            <div class="hero-btns fadeInExtra">
                <a href="#rooms" class="btn btn-primary">Prohlédnout pokoje</a>
                <a href="#about" class="btn btn-outline">Náš příběh</a>
            </div>
        </div>
        <a href="fotogalerie" class="scroll-indicator">
            <span class="mouse">
                <span class="wheel"></span>
            </span>
            <p>Skočit do přírody</p>
        </a>
    </section>

    <!-- About Section -->
    <section class="about section-padding" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-image reveal">
                    <img src="/assets/img/breakfast.png" alt="Naše snídaně na statku" class="main-img">
                    <div class="img-badge">
                        <span class="years">15+</span>
                        <span class="badge-text">let tradice</span>
                    </div>
                </div>
                <div class="about-content reveal">
                    <span class="section-tag">Náš příběh</span>
                    <h2 class="section-title">Tam, kde se tradice snoubí s komfortem</h2>
                    <p>Náš statek není jen místo k přespání. Je to místo, kde se probouzíte za zvuku kokrhání a vůně čerstvě upečeného chleba. Před patnácti lety jsme se rozhodli vdechnout nový život starému rodinnému sídlu a vytvořit oázu pro všechny, kteří hledají únik z městského shonu.</p>
                    <p>Nabízíme vám kousíček našeho ráje, domácí produkty z naší farmy a pohostinnost, kterou jinde nenajdete.</p>
                    <ul class="features-list">
                        <li><i data-lucide="check"></i> Regionální suroviny z vlastní farmy</li>
                        <li><i data-lucide="check"></i> Zázemí pro rodiny s dětmi, firmy, oslavy</li>
                        <li><i data-lucide="check"></i> Venkovní posezení, ohniště, gril, bazén</li>
                        <li><i data-lucide="check"></i> Klidná lokalita uprostřed luk a lesů</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section class="rooms section-padding" id="rooms">
        <div class="container text-center">
            <span class="section-tag">Ubytování</span>
            <h2 class="section-title">Naše útulné apartmány</h2>
            <div style="margin-top: -1rem; margin-bottom: 3rem;">
                <a href="#" id="open-timeline" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: white;">
                    <i data-lucide="calendar" style="width: 18px; height: 18px;"></i>
                    Zobrazit kalendář obsazenosti
                </a>
            </div>

            <div class="rooms-grid">
                <div class="room-card reveal-up">
                    <a href="kocici-apartman" class="room-link">
                        <div class="room-img" style="background-image: url('/assets/img/kocici/kocici-apartman233334.jpeg');">
                            <div class="room-price">od 2 000 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="kocici-apartman"><h3>Kočičí apartmán</h3></a>
                        <p>Prostorný apartmán se dvěma ložnicemi pro 5 osob a vlastní kuchyní.</p>
                        <a href="kocici-apartman" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.1s;">
                    <a href="konsky-apartman" class="room-link">
                        <div class="room-img" style="background-image: url('/assets/img/konsky_1.jpg');">
                            <div class="room-price">od 2 000 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="konsky-apartman"><h3>Koňský apartmán</h3></a>
                        <p>Prostorný apartmán pro 5 osob s plně vybavenou kuchyní a dvěma ložnicemi.</p>
                        <a href="konsky-apartman" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.2s;">
                    <a href="kvetinovy-apartman" class="room-link">
                        <div class="room-img" style="background-image: url('/assets/img/kvetinovy/kvetinovy-apartman233610.jpeg');">
                            <div class="room-price">1 500 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="kvetinovy-apartman"><h3>Květinový apartmán</h3></a>
                        <p>Prostorný apartmán pro 3 osoby s ložnicí, velkou koupelnou se sprchou i vanou a malou lednicí.</p>
                        <a href="kvetinovy-apartman" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.3s;">
                    <a href="babiccin-apartman" class="room-link">
                        <div class="room-img" style="background-image: url('/assets/img/babiccin/babiccin-apartman-222753.jpg');">
                            <div class="room-price">1 500 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="babiccin-apartman"><h3>Babiččin apartmán</h3></a>
                        <p>Prostorný apartmán pro 4 osoby s plně vybavenou kuchyní a koupelnou se sprchou.</p>
                        <a href="babiccin-apartman" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.4s;">
                    <a href="medovy-apartman" class="room-link">
                        <div class="room-img" style="background-image: url('/assets/img/medovy/medovy-obyvaci-pokoj-01.jpeg');">
                            <div class="room-price">2 000 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="medovy-apartman"><h3>Medový apartmán</h3></a>
                        <p>Ideální volba pro větší skupiny přátel. Prostorný apartmán pro 9 osob se třemi ložnicemi.</p>
                        <a href="medovy-apartman" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities & Surrounding Explorer Section (Option 1) -->
    <section class="activities section-padding bg-light" id="activities">
        <div class="container text-center">
            <span class="section-tag">Zážitky a okolí</span>
            <h2 class="section-title">Objevte krásy kolem Statku Straňovice</h2>
            <p style="max-width: 700px; margin: 0 auto 2.5rem; color: var(--text-muted); font-size: 1.05rem;">
                Vyberte si kategorii a prozkoumejte nejkrásnější výlety, památky, koupání i skvělé restaurace v našem bezprostředním okolí i na Šumavě.
            </p>

            <!-- Map Filter Category Buttons -->
            <div class="map-category-filters reveal-up">
                <button type="button" class="map-filter-btn active" data-cat="all">
                    <i data-lucide="map-pin"></i> Všechna místa
                </button>
                <button type="button" class="map-filter-btn" data-cat="vylety">
                    <i data-lucide="footprints"></i> Pěší výlety a památky
                </button>
                <button type="button" class="map-filter-btn" data-cat="cyklo">
                    <i data-lucide="bike"></i> Cyklotrasy a Šumava
                </button>
                <button type="button" class="map-filter-btn" data-cat="koupaliste">
                    <i data-lucide="waves"></i> Koupání a relax
                </button>
                <button type="button" class="map-filter-btn" data-cat="jidlo">
                    <i data-lucide="utensils"></i> Kam na jídlo
                </button>
            </div>

            <!-- Big Interactive Map Frame -->
            <div class="map-wrapper reveal-up">
                <div class="map-frame" style="position: relative;">
                    <div id="map" style="width: 100%; height: 560px; z-index: 1;"></div>
                    
                    <!-- Floating Quick Stats Bar -->
                    <div class="map-floating-legend">
                        <span class="legend-item"><span class="legend-dot dot-statek"></span> Statek Straňovice (Start)</span>
                        <span class="legend-item"><span class="legend-dot dot-vylety"></span> Výlety & Památky</span>
                        <span class="legend-item"><span class="legend-dot dot-cyklo"></span> Šumava & Rozhledny</span>
                        <span class="legend-item"><span class="legend-dot dot-koupani"></span> Koupání</span>
                        <span class="legend-item"><span class="legend-dot dot-jidlo"></span> Restaurace</span>
                    </div>
                </div>
            </div>

            <!-- 4 Quick Highlight Cards Below Map -->
            <div class="map-highlights-grid reveal-up">
                <div class="map-highlight-card" onclick="window.location.href='vylety.php?cat=okoli'">
                    <div class="highlight-icon"><i data-lucide="footprints"></i></div>
                    <div class="highlight-info">
                        <h4>Pěší výlety v Malenicích</h4>
                        <p>Fara s kavárnou, rybník u Volyňky a památná místa.</p>
                        <span class="highlight-action">Prohlédnout tipy &rarr;</span>
                    </div>
                </div>
                <div class="map-highlight-card" onclick="window.location.href='vylety.php?cat=sumava'">
                    <div class="highlight-icon"><i data-lucide="mountain"></i></div>
                    <div class="highlight-info">
                        <h4>Šumava a rozhledny</h4>
                        <p>Hrad Helfenburk, Boubínský prales a Javorník.</p>
                        <span class="highlight-action">Prohlédnout tipy &rarr;</span>
                    </div>
                </div>
                <div class="map-highlight-card" onclick="window.location.href='dovolena-s-vlastnim-konem.php'">
                    <div class="highlight-icon"><i data-lucide="sparkles"></i></div>
                    <div class="highlight-info">
                        <h4>Dovolená s koněm</h4>
                        <p>Vyjížďky do přírody a bezpečné ustájení na statku.</p>
                        <span class="highlight-action">Více o ustájení &rarr;</span>
                    </div>
                </div>
                <div class="map-highlight-card" onclick="window.location.href='kam-na-jidlo.php'">
                    <div class="highlight-icon"><i data-lucide="utensils"></i></div>
                    <div class="highlight-info">
                        <h4>Kam na dobré jídlo</h4>
                        <p>Vyzkoušené restaurace, pivovary a kavárny v okolí.</p>
                        <span class="highlight-action">Vybrat restauraci &rarr;</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact section-padding bg-light" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info reveal">
                    <span class="section-tag">Kontakt</span>
                    <h2 class="section-title">Kudy k nám?</h2>
                    <p class="section-description" style="margin-bottom: 2rem;">Rádi vám zodpovíme jakékoliv dotazy nebo pomůžeme s plánováním vašeho pobytu na statku.</p>
                    
                    <div class="info-item">
                        <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary); flex-shrink: 0; margin-top: 3px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <div>
                            <h4>Adresa</h4>
                            <p>Straňovice 1, 387 01 Malenice</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary); flex-shrink: 0; margin-top: 3px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <div>
                            <h4>Telefon</h4>
                            <p><a href="tel:+420737887985" style="color: inherit; text-decoration: none;">+420 737 887 985</a></p>
                        </div>
                    </div>

                    <div class="info-item">
                        <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary); flex-shrink: 0; margin-top: 3px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <div>
                            <h4>E-mail</h4>
                            <p><a href="mailto:info@statekstranovice.cz" style="color: inherit; text-decoration: none;">info@statekstranovice.cz</a></p>
                        </div>
                    </div>
                </div>
                <div class="contact-form-wrapper reveal-up">
                    <form class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Jméno a příjmení</label>
                                <input type="text" name="jmeno" placeholder="Jan Novák" required>
                            </div>
                            <div class="form-group">
                                <label>Váš E-mail</label>
                                <input type="email" name="email" placeholder="jan.novak@email.cz" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Vaše zpráva</label>
                            <textarea name="zprava" rows="5" placeholder="Napište nám, s čím vám můžeme pomoci..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">Odeslat zprávu</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php CMS::getFooter(); ?>

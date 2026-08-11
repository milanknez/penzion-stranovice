<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg" style="background-image: url('assets/img/hero_statek.jpg');"></div>
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
                    <img src="assets/img/breakfast.png" alt="Naše snídaně na statku" class="main-img">
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
                    <a href="<?= CMS::url('kocici.php') ?>" class="room-link">
                        <div class="room-img" style="background-image: url('assets/img/kocici_1.jpg');">
                            <div class="room-price">od 2 000 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="<?= CMS::url('kocici.php') ?>"><h3>Kočičí apartmán</h3></a>
                        <p>Prostorný apartmán se dvěma ložnicemi pro 5 osob a vlastní kuchyní.</p>
                        <a href="<?= CMS::url('kocici.php') ?>" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.1s;">
                    <a href="<?= CMS::url('konsky.php') ?>" class="room-link">
                        <div class="room-img" style="background-image: url('assets/img/konsky_1.jpg');">
                            <div class="room-price">od 2 000 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="<?= CMS::url('konsky.php') ?>"><h3>Koňský apartmán</h3></a>
                        <p>Prostorný apartmán pro 5 osob s plně vybavenou kuchyní a dvěma ložnicemi.</p>
                        <a href="<?= CMS::url('konsky.php') ?>" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.2s;">
                    <a href="<?= CMS::url('kvetinovy.php') ?>" class="room-link">
                        <div class="room-img" style="background-image: url('assets/img/kvetinovy/kvetinovy-apartman233610.jpeg');">
                            <div class="room-price">1 500 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="<?= CMS::url('kvetinovy.php') ?>"><h3>Květinový apartmán</h3></a>
                        <p>Prostorný apartmán pro 3 osoby s ložnicí, velkou koupelnou se sprchou i vanou a malou lednicí.</p>
                        <a href="<?= CMS::url('kvetinovy.php') ?>" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.3s;">
                    <a href="<?= CMS::url('babiccin.php') ?>" class="room-link">
                        <div class="room-img" style="background-image: url('assets/img/babiccin/babiccin-apartman-222753.jpg');">
                            <div class="room-price">1 500 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="<?= CMS::url('babiccin.php') ?>"><h3>Babiččin apartmán</h3></a>
                        <p>Prostorný apartmán pro 4 osoby s plně vybavenou kuchyní a koupelnou se sprchou.</p>
                        <a href="<?= CMS::url('babiccin.php') ?>" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
                <div class="room-card reveal-up" style="animation-delay: 0.4s;">
                    <a href="<?= CMS::url('medovy.php') ?>" class="room-link">
                        <div class="room-img" style="background-image: url('assets/img/medovy_1.jpg');">
                            <div class="room-price">2 000 Kč / noc</div>
                        </div>
                    </a>
                    <div class="room-info">
                        <a href="<?= CMS::url('medovy.php') ?>"><h3>Medový apartmán</h3></a>
                        <p>Ideální volba pro větší skupiny přátel. Prostorný apartmán pro 9 osob se třemi ložnicemi.</p>
                        <a href="<?= CMS::url('medovy.php') ?>" class="btn btn-link">Více o pokoji <i data-lucide="arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section class="activities section-padding bg-light" id="activities">
        <div class="container text-center">
            <span class="section-tag">Zážitky u nás</span>
            <h2 class="section-title">Co u nás zažijete?</h2>
            <div class="activities-grid">
                <div class="activity-card reveal-up">
                    <div class="activity-icon">
                        <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M4 16v-2.38C4 11.5 7.5 10 9.5 10S15 11.5 15 13.62V16"></path><path d="M20 20v-2.38c0-2.12-3.5-3.62-5.5-3.62S9 15.5 9 17.62V20"></path><circle cx="9" cy="6" r="2"></circle><circle cx="15" cy="9" r="2"></circle></svg>
                    </div>
                    <h3>Pěší výlety</h3>
                    <p>Prozkoumejte okolí Malenic po značených turistických trasách.</p>
                </div>
                <div class="activity-card reveal-up" style="animation-delay: 0.1s;">
                    <div class="activity-icon">
                        <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="17.5" r="3.5"></circle><circle cx="18.5" cy="17.5" r="3.5"></circle><line x1="15" y1="6" x2="18.5" y2="17.5"></line><polyline points="12 17.5 15 6 10 6"></polyline><path d="M12 17.5l-4-9 3-2.5"></path></svg>
                    </div>
                    <h3>Cyklovýlety</h3>
                    <p>Od rovinatých tras podél řeky až po náročné výjezdy po Šumavě.</p>
                </div>
                <div class="activity-card reveal-up" style="animation-delay: 0.2s;">
                    <div class="activity-icon">
                        <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9.5C2 7 4 5 6.5 5H9c1.5 0 3 .5 4.5 1.5L16 8l3-1 2 2-2 3 3 2v3z"></path><circle cx="8" cy="10" r="1"></circle><path d="M6 19v2"></path><path d="M18 19v2"></path></svg>
                    </div>
                    <h3>Vyjížďky na koních</h3>
                    <p>Zprostředkujeme vyjížďky na koních z nedaleké stáje.</p>
                </div>
            </div>

            <div class="map-wrapper reveal-up">
                <div class="map-frame">
                    <div id="map" style="width: 100%; height: 500px;"></div>
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

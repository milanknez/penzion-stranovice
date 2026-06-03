<!DOCTYPE html>
<html lang="cs">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg" style="background-image: url('assets/img/hero_statek.jpg');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Vítejte v náruči přírody</h2>
            <h1 class="hero-title fadeInDelay">Statek Straňovice</h1>
            <p class="hero-description fadeInExtra">Penzion u Malenic. Autentická atmosféra, kde se čas zastavil.
                Objevte klid venkova v moderním hávu.</p>
            <div class="hero-btns fadeInExtra">
                <a href="#rooms" class="btn btn-primary">Prohlédnout pokoje</a>
                <a href="#about" class="btn btn-outline">Náš příběh</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <span class="mouse">
                <span class="wheel"></span>
            </span>
            <p>Skočit do přírody</p>
        </div>
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
                    <p>Náš statek není jen místo k přespání. Je to místo, kde se probouzíte za zvuku kokrhání a vůně
                        čerstvě upečeného chleba. Před patnácti lety jsme se rozhodli vdechnout nový život starému
                        rodinnému sídlu a vytvořit oázu pro všechny, kteří hledají únik z městského shonu.</p>
                    <p>Nabízíme vám kousíček našeho ráje, domácí produkty z naší farmy a pohostinnost, kterou jinde
                        nenajdete.</p>
                    <ul class="features-list">
                        <li><i data-lucide="check"></i> Regionální suroviny z vlastní farmy</li>
                        <li><i data-lucide="check"></i> Ručně vyráběný nábytek na pokojích</li>
                        <li><i data-lucide="check"></i> Klidná lokalita uprostřed luk a lesů</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

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
                        <div class="room-img" style="background-image: url('assets/img/babiccin/babiccin-apartman-222749.jpg');">
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
                    <div class="activity-icon"><i data-lucide="footprints"></i></div>
                    <h3>Pěší výlety</h3>
                    <p>Prozkoumejte okolí Malenic po značených turistických trasách.</p>
                </div>
                <div class="activity-card reveal-up" style="animation-delay: 0.1s;">
                    <div class="activity-icon"><i data-lucide="bike"></i></div>
                    <h3>Cyklovýlety</h3>
                    <p>Od rovinatých tras podél řeky až po náročné výjezdy po Šumavě.</p>
                </div>
                <div class="activity-card reveal-up" style="animation-delay: 0.2s;">
                    <div class="activity-icon"><i data-lucide="horse"></i></div>
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
    <section class="contact section-padding" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info reveal">
                    <span class="section-tag">Kontakt</span>
                    <h2 class="section-title">Kudy k nám?</h2>
                    <p>Straňovice 1, 387 01 Malenice</p>
                    <p>Tel: +420 737 887 985</p>
                    <p>Email: info@statekstranovice.cz</p>
                </div>
                <div class="contact-form-wrapper reveal-up">
                    <form class="contact-form">
                        <div class="form-row">
                            <div class="form-group"><input type="text" placeholder="Jméno" required></div>
                            <div class="form-group"><input type="email" placeholder="Email" required></div>
                        </div>
                        <div class="form-group"><textarea rows="5" placeholder="Vaše zpráva"></textarea></div>
                        <button type="submit" class="btn btn-primary w-full">Odeslat</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>




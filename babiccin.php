<!DOCTYPE html>
<html lang="cs">
<head>
    <?php include 'includes/head.php'; ?>
    <style>
        .about-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 3rem; align-items: flex-start; }
        @media (max-width: 992px) { .about-grid { grid-template-columns: 1fr; gap: 2rem; } }
        .room-gallery { width: 100%; min-width: 0; }
        .room-description { width: 100%; min-width: 0; }
        .room-gallery-main { border-radius: 4px; overflow: hidden; border: 8px solid white; box-shadow: 10px 10px 0px var(--border); margin-bottom: 2rem; cursor: zoom-in; aspect-ratio: 4 / 3; max-height: 450px; position: relative; z-index: 100; width: 100%; }
        .room-gallery-main img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s ease; }
        .thumb-slider-container { position: relative; display: flex; align-items: center; margin-top: 1rem; gap: 10px; width: 100%; overflow: hidden; }
        .thumb-scroll { display: flex; gap: 10px; overflow-x: hidden; scroll-behavior: smooth; flex-grow: 1; padding: 5px 0; }
        .thumb-scroll img { flex: 0 0 100px; width: 100px; height: 75px; object-fit: cover; border-radius: 4px; border: 2px solid white; cursor: pointer; opacity: 0.7; flex-shrink: 0; }
        .thumb-scroll img.active { opacity: 1; border-color: var(--primary) !important; }
        .slider-nav { background: white; border: 1px solid var(--border); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; z-index: 200; box-shadow: 0 4px 10px rgba(0,0,0,0.2); color: var(--primary); }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="hero" style="height: 50vh; min-height: 300px;">
        <div class="hero-bg" style="background-image: url('assets/img/babiccin_1.jpg'); transform: scale(1);"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Ubytování</h2>
            <h1 class="hero-title fadeInDelay">Babiččin apartmán</h1>
        </div>
    </section>

    <section class="room-detail section-padding">
        <div class="container">
            <div class="about-grid">
                <div class="room-gallery">
                    <div class="room-gallery-main" id="main-gallery-trigger">
                        <img src="assets/img/babiccin_1.jpg" alt="Babiččin apartmán" id="main-gallery-img">
                    </div>
                    <div class="thumb-slider-container">
                        <div class="slider-nav" id="prev-thumb"><i data-lucide="chevron-left"></i></div>
                        <div class="thumb-scroll" id="thumb-scroll">
                            <img src="assets/img/babiccin_1.jpg" class="active">
                            <img src="assets/img/babiccin_2.jpg">
                            <img src="assets/img/babiccin_3.jpg">
                        </div>
                        <div class="slider-nav" id="next-thumb"><i data-lucide="chevron-right"></i></div>
                    </div>
                </div>
                <div class="room-description reveal">
                    <span class="section-tag">Tradiční styl</span>
                    <h2 class="section-title">Útulné ubytování s atmosférou</h2>
                    <p>Babiččin apartmán je ideální volbou pro ty, kteří hledají klid a tradiční venkovskou atmosféru s moderním komfortem.</p>
                    <ul class="features-list">
                        <li><i data-lucide="users"></i> Kapacita: 4 osoby</li>
                        <li><i data-lucide="bed"></i> 1x velká manželská postel, 2x jednolůžko</li>
                        <li><i data-lucide="wifi"></i> WiFi zdarma</li>
                    </ul>

                    <div style="margin-top: 3rem;">
                        <div style="font-family: 'Libre Baskerville'; font-size: 1.8rem; color: var(--primary); margin-bottom: 1rem;">
                            od 850 Kč / noc
                        </div>
                        <a href="index.php#contact" class="btn btn-primary">Rezervovat Babiččin apartmán</a>
                    </div>
                </div>
            </div>

            <!-- More Details -->
            <div class="room-feature-list reveal-up">
                <div class="room-feature-item">
                    <div class="room-feature-icon"><i data-lucide="utensils"></i></div>
                    <h4>Vlastní kuchyně</h4>
                    <p>Plně vybavené zázemí pro vaše rodinné vaření.</p>
                </div>
                <div class="room-feature-item">
                    <div class="room-feature-icon"><i data-lucide="palmtree"></i></div>
                    <h4>Venkovní klid</h4>
                    <p>Užijte si ticho a pohodu jihočeského venkova.</p>
                </div>
                <div class="room-feature-item">
                    <div class="room-feature-icon"><i data-lucide="wifi"></i></div>
                    <h4>Wi-Fi zdarma</h4>
                    <p>Zůstaňte ve spojení se světem i během odpočinku.</p>
                </div>
                <div class="room-feature-item">
                    <div class="room-feature-icon"><i data-lucide="map-pin"></i></div>
                    <h4>Krásy Šumavy</h4>
                    <p>Penzion se nachází v ideální lokalitě pro výlety.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reservation Section -->
    <section class="contact section-padding bg-white" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info reveal">
                    <span class="section-tag">Rezervace</span>
                    <h2 class="section-title">Poptat termín</h2>
                    <p>Zaujal vás náš Babiččin apartmán? Pošlete nám nezávaznou poptávku a my se vám ozveme s nejlepší cenou.</p>
                    <div class="info-item" style="margin-top: 2rem;">
                        <i data-lucide="mail"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@statekstranovice.cz</p>
                        </div>
                    </div>
                    <div class="info-item" style="margin-top: 1rem;">
                        <i data-lucide="phone"></i>
                        <div>
                            <h4>Telefon</h4>
                            <p>+420 737 887 985</p>
                        </div>
                    </div>
                </div>
                <div class="contact-form-wrapper reveal-up">
                    <form class="contact-form">
                        <input type="hidden" name="room" value="Babiččin apartmán">
                        <div class="form-row">
                            <div class="form-group"><label>Příjezd</label><input type="date" required></div>
                            <div class="form-group"><label>Odjezd</label><input type="date" required></div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Počet hostů</label>
                                <select>
                                    <option>1 osoba</option>
                                    <option>2 osoby</option>
                                    <option>3 osoby</option>
                                    <option>4 osoby</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Vaše jméno</label><input type="text" placeholder="Jan Novák" required></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">Odeslat poptávku</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>




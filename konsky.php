<!DOCTYPE html>
<html lang="cs">
<head>
    <?php include 'includes/head.php'; ?>
    <style>
        /* Specific tweaks for Room Detail Page */
        .room-feature-list { list-style: none; padding: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem; }
        .room-feature-item { background: white; padding: 2rem; border-radius: 8px; box-shadow: 2px 2px 0px rgba(139, 94, 60, 0.1); text-align: center; transition: var(--transition); }
        .about-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 3rem; align-items: flex-start; }
        @media (max-width: 992px) { .about-grid { grid-template-columns: 1fr; gap: 2rem; } }
        .room-gallery { width: 100%; min-width: 0; }
        .room-description { width: 100%; min-width: 0; }
        .room-gallery-main { border-radius: 4px; overflow: hidden; border: 8px solid white; box-shadow: 10px 10px 0px var(--border); margin-bottom: 2rem; cursor: zoom-in; aspect-ratio: 4 / 3; position: relative; max-height: 450px; z-index: 100; width: 100%; }
        .room-gallery-main img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s ease; }
        .thumb-slider-container { position: relative; display: flex; align-items: center; margin-top: 1rem; gap: 10px; width: 100%; overflow: hidden; }
        .thumb-scroll { display: flex; gap: 10px; overflow-x: hidden; scroll-behavior: smooth; flex-grow: 1; padding: 5px 0; }
        .thumb-scroll img { flex: 0 0 100px; width: 100px; height: 75px; object-fit: cover; border-radius: 4px; border: 2px solid white; cursor: pointer; opacity: 0.7; transition: 0.2s; flex-shrink: 0; }
        .thumb-scroll img.active { opacity: 1; border-color: var(--primary) !important; }
        .slider-nav { background: white; border: 1px solid var(--border); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 200; box-shadow: 0 4px 10px rgba(0,0,0,0.2); color: var(--primary); flex-shrink: 0; }
        

    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home" style="height: 60vh; min-height: 400px;">
        <div class="hero-bg" style="background-image: url('assets/img/room.png');"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h2 class="hero-subtitle fadeIn">Venkovský luxus</h2>
            <h1 class="hero-title fadeInDelay">Koňský apartmán</h1>
            <p class="hero-description fadeInExtra">Pension Na Statku - Malenice</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="about-grid">
                <div class="reveal">
                    <div class="room-gallery-main" id="main-gallery-trigger">
                        <img src="assets/img/konsky_1.jpg" alt="Koňský apartmán - Interiér" id="main-gallery-img">
                    </div>
                    <div class="thumb-slider-container">
                        <button class="slider-nav" id="prev-thumb"><i data-lucide="chevron-left"></i></button>
                        <div class="thumb-scroll" id="thumb-scroll">
                            <img src="assets/img/konsky_1.jpg" class="active">
                            <img src="assets/img/konsky_2.jpg">
                            <img src="assets/img/konsky_3.jpg">
                            <img src="assets/img/konsky_4.jpg">
                            <img src="assets/img/konsky_5.jpg">
                        </div>
                        <button class="slider-nav" id="next-thumb"><i data-lucide="chevron-right"></i></button>
                    </div>
                </div>
                <div class="reveal">
                    <span class="section-tag">Útulný apartmán</span>
                    <h2 class="section-title">Klid a výhled do zahrady</h2>
                    <p>Pension Na Statku - Koňský apartmán se nachází v Malenicích a nabízí bezplatné Wi-Fi a krásný výhled do zahrady. Tento útulný apartmán disponuje 2 ložnicemi, plně vybavenou kuchyní a TV s plochou obrazovkou. Je ideální volbou pro páry, které hledají klidné zázemí uprostřed šumavské přírody.</p>
                    
                    <ul class="features-list" style="margin-top: 2rem;">
                        <li><i data-lucide="users"></i> Kapacita: 2 osoby</li>
                        <li><i data-lucide="bed"></i> 2x ložnice</li>
                        <li><i data-lucide="chef-hat"></i> Plně vybavená kuchyně</li>
                        <li><i data-lucide="wifi"></i> Wi-Fi zdarma</li>
                        <li><i data-lucide="parking-circle"></i> Parkování u objektu zdarma</li>
                    </ul>

                    <div style="margin-top: 3rem;">
                        <div style="font-family: 'Libre Baskerville'; font-size: 1.8rem; color: var(--primary); margin-bottom: 1rem;">
                            od 750 Kč / noc
                        </div>
                        <a href="#contact" class="btn btn-primary">Rezervovat Koňský apartmán</a>
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
                    <div class="room-feature-icon"><i data-lucide="sun"></i></div>
                    <h4>Terasa a zahrada</h4>
                    <p>Užijte si klidné snídaně venku na čerstvém vzduchu.</p>
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
                    <p>Zaujal vás náš Koňský apartmán? Pošlete nám nezávaznou poptávku a my se vám ozveme s nejlepší cenou.</p>
                    <div class="info-item" style="margin-top: 2rem;">
                        <i data-lucide="mail"></i>
                        <div>
                            <h4>Email</h4>
                            <p>info@statek-penzon.cz</p>
                        </div>
                    </div>
                </div>
                <div class="contact-form-wrapper reveal-up">
                    <form class="contact-form">
                        <input type="hidden" name="room" value="Koňský apartmán">
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

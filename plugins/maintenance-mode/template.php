<?php
/**
 * Maintenance Mode Public Template
 * Statek Straňovice - Premium Maintenance Experience
 * 
 * @var array $config Configuration array passed from MaintenanceModePlugin
 */

$pageTitle = htmlspecialchars($config['page_title'] ?? 'Statek Straňovice – Plánovaná údržba webu');
$badgeText = htmlspecialchars($config['badge_text'] ?? 'Plánovaná technická údržba');
$heading = htmlspecialchars($config['heading'] ?? 'Vylepšujeme pro vás Statek Straňovice');
$description = nl2br(htmlspecialchars($config['description'] ?? 'Právě provádíme plánované technické úpravy. Již brzy budeme zpět!'));
$showCountdown = !empty($config['show_countdown']) && !empty($config['target_datetime']);
$targetDatetime = $config['target_datetime'] ?? '';
$showPhone = !empty($config['show_phone']) && !empty($config['phone']);
$phone = htmlspecialchars($config['phone'] ?? '');
$phoneClean = preg_replace('/[^\d+]/', '', $phone);
$showEmail = !empty($config['show_email']) && !empty($config['email']);
$email = htmlspecialchars($config['email'] ?? '');
$showAddress = !empty($config['show_address']) && !empty($config['address']);
$address = htmlspecialchars($config['address'] ?? '');
$customCss = $config['custom_css'] ?? '';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title><?= $pageTitle ?></title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --accent-gold: #eab308;
            --accent-emerald: #10b981;
            --bg-dark: #0a0e17;
            --surface-glass: rgba(15, 23, 42, 0.78);
            --surface-border: rgba(255, 255, 255, 0.12);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Ambient Background */
        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background-image: url('/assets/img/hero_statek.jpg');
            background-size: cover;
            background-position: center;
            filter: brightness(0.25) saturate(1.2);
            transform: scale(1.05);
            animation: slowZoom 25s infinite alternate ease-in-out;
        }

        @keyframes slowZoom {
            0% { transform: scale(1.02); }
            100% { transform: scale(1.12); }
        }

        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            background: radial-gradient(circle at center, rgba(15, 23, 42, 0.6) 0%, rgba(10, 14, 23, 0.95) 100%),
                        linear-gradient(180deg, rgba(10, 14, 23, 0.7) 0%, rgba(10, 14, 23, 0.98) 100%);
        }

        /* Kontejner a karta */
        .page-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 860px;
            padding: 40px 24px;
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .brand-logo-wrapper {
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo {
            max-height: 76px;
            max-width: 240px;
            object-fit: contain;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.4));
        }

        .brand-fallback {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        .card {
            background: var(--surface-glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--surface-border);
            border-radius: 28px;
            padding: 48px 40px;
            width: 100%;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 0 40px rgba(79, 70, 229, 0.1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10%;
            right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(234, 179, 8, 0.12);
            border: 1px solid rgba(234, 179, 8, 0.3);
            color: #fde047;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #eab308;
            box-shadow: 0 0 10px #eab308;
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(234, 179, 8, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
        }

        /* Typography */
        h1.title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(28px, 4.5vw, 42px);
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
            margin-bottom: 18px;
            letter-spacing: -0.5px;
        }

        p.description {
            font-size: clamp(15px, 2vw, 17px);
            color: var(--text-muted);
            max-width: 640px;
            margin: 0 auto 36px auto;
            line-height: 1.7;
        }

        /* Countdown Timer */
        .countdown-container {
            margin: 32px 0 40px 0;
        }

        .countdown-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--primary-light);
            margin-bottom: 16px;
        }

        .countdown-grid {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .countdown-box {
            background: rgba(10, 15, 29, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 16px 14px;
            min-width: 82px;
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.04), 0 8px 16px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .countdown-box:hover {
            transform: translateY(-2px);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .countdown-num {
            font-family: 'Plus Jakarta Sans', monospace;
            font-size: clamp(26px, 4vw, 36px);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
        }

        .countdown-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Contact Cards */
        .contacts-section {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 32px;
            margin-top: 10px;
        }

        .contacts-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #cbd5e1;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .contacts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        .contact-pill {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 14px 16px;
            text-decoration: none;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: left;
            transition: all 0.25s ease;
        }

        .contact-pill:hover {
            background: rgba(79, 70, 229, 0.15);
            border-color: rgba(99, 102, 241, 0.4);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .contact-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            shrink-0: 0;
        }

        .contact-pill:hover .contact-icon {
            background: var(--primary);
            color: #ffffff;
        }

        .contact-text-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }

        .contact-text-val {
            font-size: 13px;
            font-weight: 600;
            color: #f1f5f9;
            word-break: break-word;
        }

        /* Footer */
        footer.page-footer {
            position: relative;
            z-index: 10;
            padding: 20px;
            width: 100%;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
            font-size: 11px;
            color: #64748b;
        }

        footer.page-footer a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        footer.page-footer a:hover {
            color: #cbd5e1;
        }

        .admin-link {
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .admin-link:hover {
            opacity: 1;
        }

        /* Mobile Adjustments */
        @media (max-width: 640px) {
            .card {
                padding: 32px 20px;
                border-radius: 22px;
            }

            .countdown-grid {
                gap: 8px;
            }

            .countdown-box {
                min-width: 68px;
                padding: 12px 8px;
            }

            .contacts-grid {
                grid-template-columns: 1fr;
            }
        }

        <?= $customCss ?>
    </style>
</head>
<body>
    <div class="bg-layer"></div>
    <div class="bg-overlay"></div>

    <main class="page-container">
        <!-- Logo -->
        <div class="brand-logo-wrapper">
            <?php if (file_exists(CMS_ROOT . '/assets/img/logo_transparent.png')): ?>
                <img src="/assets/img/logo_transparent.png" alt="Statek Straňovice" class="brand-logo">
            <?php else: ?>
                <div class="brand-fallback">Statek Straňovice</div>
            <?php endif; ?>
        </div>

        <!-- Main Card -->
        <div class="card">
            <!-- Badge -->
            <div class="status-badge">
                <span class="pulse-dot"></span>
                <span><?= $badgeText ?></span>
            </div>

            <!-- Titulek a popis -->
            <h1 class="title"><?= $heading ?></h1>
            <p class="description"><?= $description ?></p>

            <!-- Countdown Timer -->
            <?php if ($showCountdown): ?>
            <div class="countdown-container" id="countdown-section">
                <div class="countdown-title">
                    <i class="fa fa-clock-o"></i> Předpokládané spuštění za:
                </div>
                <div class="countdown-grid">
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-days">00</span>
                        <span class="countdown-label">Dní</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-hours">00</span>
                        <span class="countdown-label">Hodin</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-minutes">00</span>
                        <span class="countdown-label">Minut</span>
                    </div>
                    <div class="countdown-box">
                        <span class="countdown-num" id="cd-seconds">00</span>
                        <span class="countdown-label">Sekund</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Kontakty a nouzové upozornění -->
            <?php if ($showPhone || $showEmail || $showAddress): ?>
            <div class="contacts-section">
                <div class="contacts-title">
                    <i class="fa fa-phone"></i> Pro rezervace a dotazy jsme vám k dispozici:
                </div>
                <div class="contacts-grid">
                    <?php if ($showPhone): ?>
                    <a href="tel:<?= $phoneClean ?>" class="contact-pill">
                        <div class="contact-icon"><i class="fa fa-phone"></i></div>
                        <div>
                            <div class="contact-text-label">Telefon</div>
                            <div class="contact-text-val"><?= $phone ?></div>
                        </div>
                    </a>
                    <?php endif; ?>

                    <?php if ($showEmail): ?>
                    <a href="mailto:<?= $email ?>" class="contact-pill">
                        <div class="contact-icon"><i class="fa fa-envelope-o"></i></div>
                        <div>
                            <div class="contact-text-label">E-mail</div>
                            <div class="contact-text-val"><?= $email ?></div>
                        </div>
                    </a>
                    <?php endif; ?>

                    <?php if ($showAddress): ?>
                    <div class="contact-pill" style="cursor: default;">
                        <div class="contact-icon"><i class="fa fa-map-marker"></i></div>
                        <div>
                            <div class="contact-text-label">Kde nás najdete</div>
                            <div class="contact-text-val"><?= $address ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="page-footer">
        <div>&copy; <?= date('Y') ?> Statek Straňovice &bull; Všechna práva vyhrazena.</div>
        <div>&bull;</div>
        <a href="/admin/" class="admin-link" title="Přihlášení do správy webu">
            <i class="fa fa-lock"></i> Správa webu
        </a>
    </footer>

    <?php if ($showCountdown): ?>
    <script>
        (function() {
            const targetIso = <?= json_encode($targetDatetime) ?>;
            if (!targetIso) return;

            const targetDate = new Date(targetIso).getTime();
            if (isNaN(targetDate)) return;

            const elDays = document.getElementById('cd-days');
            const elHours = document.getElementById('cd-hours');
            const elMins = document.getElementById('cd-minutes');
            const elSecs = document.getElementById('cd-seconds');
            const section = document.getElementById('countdown-section');

            function updateCountdown() {
                const now = Date.now();
                const diff = targetDate - now;

                if (diff <= 0) {
                    if (elDays) elDays.innerText = '00';
                    if (elHours) elHours.innerText = '00';
                    if (elMins) elMins.innerText = '00';
                    if (elSecs) elSecs.innerText = '00';
                    return;
                }

                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                if (elDays) elDays.innerText = String(d).padStart(2, '0');
                if (elHours) elHours.innerText = String(h).padStart(2, '0');
                if (elMins) elMins.innerText = String(m).padStart(2, '0');
                if (elSecs) elSecs.innerText = String(s).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        })();
    </script>
    <?php endif; ?>
</body>
</html>

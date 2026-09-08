<?php
/**
 * Plugin Name: Režim Údržby (Maintenance Mode)
 * Version: 1.0.0
 * Description: Umožňuje dočasně uzavřít web pro veřejnost s elegantní informační stránkou, odpočtem, kontakty a výjimkami pro administrátory a vybrané IP adresy.
 * Author: Statek Straňovice
 * Settings Modal: openMaintenanceModal()
 * Settings Button: Režim údržby
 */

if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', rtrim(realpath(__DIR__ . '/../../') ?: __DIR__ . '/../..', '/'));
}

if (!class_exists('MaintenanceModePlugin')) {
    class MaintenanceModePlugin {
        private static string $configFile = __DIR__ . '/data/config.json';
        private static bool $interceptChecked = false;

        /**
         * Retrieve plugin configuration.
         */
        public static function getConfig(): array {
            $defaults = [
                'is_enabled' => false,
                'http_status' => 503,
                'badge_text' => 'Plánovaná technická údržba',
                'page_title' => 'Statek Straňovice – Plánovaná údržba webu',
                'heading' => 'Vylepšujeme pro vás Statek Straňovice',
                'description' => 'Právě provádíme plánované technické úpravy a přípravu nových funkcí rezervačního systému. Již velmi brzy budeme zpět. Děkujeme za vaši trpělivost!',
                'show_countdown' => true,
                'target_datetime' => '',
                'auto_disable' => false,
                'whitelist_ips' => [],
                'bypass_token' => 'stranovice_preview',
                'show_phone' => true,
                'phone' => '+420 737 887 985',
                'show_email' => true,
                'email' => 'info@statekstranovice.cz',
                'show_address' => true,
                'address' => 'Straňovice 1, 387 01 Malenice',
                'custom_css' => ''
            ];

            if (file_exists(self::$configFile)) {
                $json = @json_decode(@file_get_contents(self::$configFile), true);
                if (is_array($json)) {
                    return array_merge($defaults, $json);
                }
            }

            // Populate defaults from site.json if available
            $siteConfigPath = CMS_ROOT . '/config/site.json';
            if (file_exists($siteConfigPath)) {
                $siteJson = @json_decode(@file_get_contents($siteConfigPath), true);
                if (is_array($siteJson)) {
                    if (!empty($siteJson['phone_nonstop'])) $defaults['phone'] = $siteJson['phone_nonstop'];
                    if (!empty($siteJson['email'])) $defaults['email'] = $siteJson['email'];
                    if (!empty($siteJson['address_headquarters'])) $defaults['address'] = $siteJson['address_headquarters'];
                }
            }

            return $defaults;
        }

        /**
         * Save configuration array to config.json.
         */
        public static function saveConfig(array $data): bool {
            $dir = dirname(self::$configFile);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            @chmod($dir, 0777);

            if (file_exists(self::$configFile)) {
                @chmod(self::$configFile, 0666);
            }

            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $res = @file_put_contents(self::$configFile, $json);
            if ($res === false) {
                @chmod(self::$configFile, 0777);
                @unlink(self::$configFile);
                $res = @file_put_contents(self::$configFile, $json);
            }

            if ($res !== false) {
                @chmod(self::$configFile, 0666);
                return true;
            }

            return false;
        }

        /**
         * Detect client IP address accurately.
         */
        public static function getClientIp(): string {
            $headers = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
            foreach ($headers as $h) {
                if (!empty($_SERVER[$h])) {
                    $ipList = explode(',', $_SERVER[$h]);
                    $ip = trim($ipList[0]);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
            return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }

        /**
         * Check if maintenance mode is active (accounting for auto-disable schedule).
         */
        public static function isMaintenanceActive(): bool {
            $config = self::getConfig();
            if (empty($config['is_enabled'])) {
                return false;
            }

            // Check auto-disable schedule
            if (!empty($config['auto_disable']) && !empty($config['target_datetime'])) {
                $targetTimestamp = strtotime($config['target_datetime']);
                if ($targetTimestamp && time() >= $targetTimestamp) {
                    // Time expired: auto-disable
                    $config['is_enabled'] = false;
                    self::saveConfig($config);
                    return false;
                }
            }

            return true;
        }

        /**
         * Main request interceptor.
         */
        public static function checkAndIntercept(): void {
            if (self::$interceptChecked) return;
            self::$interceptChecked = true;

            // 1. CLI execution check
            if (php_sapi_name() === 'cli') {
                return;
            }

            $uri = $_SERVER['REQUEST_URI'] ?? '';
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

            // 2. Administrace a vyloučení API - nikdy neblokovat administrátory
            if (
                defined('ADMIN_PATH') ||
                strpos($uri, '/admin') !== false ||
                strpos($scriptName, '/admin') !== false ||
                strpos($uri, 'plugins.php') !== false ||
                strpos($uri, 'login.php') !== false ||
                strpos($uri, '/api/') !== false
            ) {
                return;
            }

            // 3. Static asset exclusion
            if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg|woff2?|ttf|eot)$/i', parse_url($uri, PHP_URL_PATH))) {
                return;
            }

            // Session check for admin login
            if (session_status() === PHP_SESSION_NONE) {
                @session_start();
            }
            $isAdmin = !empty($_SESSION['logged_in']);

            $config = self::getConfig();

            // 4. Live preview for administrators
            if (isset($_GET['preview_maintenance']) && $_GET['preview_maintenance'] == '1' && $isAdmin) {
                self::renderMaintenancePage($config, 200);
                exit;
            }

            // If maintenance mode is not active, do nothing
            if (!self::isMaintenanceActive()) {
                return;
            }

            // 5. Bypass for authenticated administrators
            if ($isAdmin) {
                self::attachAdminStickyBanner();
                return;
            }

            // 6. Whitelist IP verification
            $clientIp = self::getClientIp();
            $whitelist = $config['whitelist_ips'] ?? [];
            if (is_array($whitelist) && in_array($clientIp, $whitelist, true)) {
                return;
            }

            // 7. Secret Bypass Token verification
            $bypassToken = $config['bypass_token'] ?? '';
            if (!empty($bypassToken)) {
                // Token passed in URL parameter: set cookie and redirect to clean URL
                if (isset($_GET['bypass_maintenance']) && $_GET['bypass_maintenance'] === $bypassToken) {
                    setcookie('cms_maintenance_bypass', $bypassToken, time() + (7 * 86400), '/');
                    $cleanUrl = strtok($_SERVER['REQUEST_URI'], '?');
                    $query = $_GET;
                    unset($query['bypass_maintenance']);
                    if (!empty($query)) {
                        $cleanUrl .= '?' . http_build_query($query);
                    }
                    header('Location: ' . $cleanUrl, true, 302);
                    exit;
                }

                // Token stored in cookie
                if (isset($_COOKIE['cms_maintenance_bypass']) && $_COOKIE['cms_maintenance_bypass'] === $bypassToken) {
                    return;
                }
            }

            // 8. Intercept and render Maintenance Page
            $httpStatus = (int)($config['http_status'] ?? 503);
            self::renderMaintenancePage($config, $httpStatus);
            exit;
        }

        /**
         * Render public maintenance page template.
         */
        private static function renderMaintenancePage(array $config, int $httpStatus = 503): void {
            if (!headers_sent()) {
                http_response_code($httpStatus);
                if ($httpStatus === 503) {
                    header('Retry-After: 3600');
                }
                header('Content-Type: text/html; charset=utf-8');
            }

            $templatePath = __DIR__ . '/template.php';
            if (file_exists($templatePath)) {
                require $templatePath;
            } else {
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Údržba webu</title></head><body style="font-family:sans-serif;text-align:center;padding:50px;"><h1>Probíhá údržba webu</h1><p>Právě provádíme plánovanou technickou údržbu. Již brzy budeme zpět.</p></body></html>';
            }
        }

        /**
         * Inject a stylish floating top bar for logged-in admins to indicate maintenance is active.
         * Ensures no elements or text overlap the website navigation.
         */
        private static function attachAdminStickyBanner(): void {
            ob_start(function($buffer) {
                if (stripos($buffer, '<body') === false) {
                    return $buffer;
                }

                $bannerHtml = '
                <!-- Maintenance Mode Admin Sticky Bar & Dock -->
                <div id="cms-maintenance-admin-wrapper">
                    <!-- Expanded Top Bar -->
                    <aside id="cms-maintenance-admin-bar" aria-label="Režim údržby" style="position:fixed;top:0;left:0;right:0;z-index:999999;background:linear-gradient(90deg,#78350f,#92400e);border-bottom:2px solid #f59e0b;color:#fef3c7;font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,sans-serif;font-size:12px;font-weight:600;padding:7px 16px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 15px rgba(0,0,0,0.5);transition:transform 0.25s ease, opacity 0.25s ease;">
                        <div style="display:flex;align-items:center;gap:10px;min-width:0;flex:1;margin-right:12px;">
                            <span style="display:inline-block;width:9px;height:9px;border-radius:50%;background:#f59e0b;box-shadow:0 0 8px #f59e0b;animation:mmPulse 1.5s infinite;flex-shrink:0;"></span>
                            <strong style="color:#ffffff;white-space:nowrap;letter-spacing:0.3px;">REŽIM ÚDRŽBY JE ZAPNUTÝ</strong>
                            <span class="mm-hide-mobile" style="opacity:0.85;font-weight:400;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">— Běžní návštěvníci vidí odstávkovou stránku. Vy web vidíte jako přihlášený administrátor.</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                            <a href="/admin/" style="background:rgba(0,0,0,0.35);color:#ffffff;text-decoration:none;padding:5px 12px;border-radius:6px;border:1px solid rgba(255,255,255,0.2);font-size:11px;font-weight:600;transition:all 0.2s;white-space:nowrap;">
                                Správa CMS
                            </a>
                            <button type="button" onclick="disableMaintenanceFromBar()" style="background:#dc2626;color:#ffffff;border:none;padding:5px 12px;border-radius:6px;cursor:pointer;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;box-shadow:0 2px 5px rgba(0,0,0,0.3);transition:background 0.2s;white-space:nowrap;">
                                Vypnout údržbu
                            </button>
                            <button type="button" onclick="toggleMmAdminBar(true)" title="Minimalizovat lištu (aby nepřekrývala web)" style="background:rgba(255,255,255,0.1);color:#fef3c7;border:1px solid rgba(255,255,255,0.15);width:26px;height:26px;border-radius:6px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:13px;padding:0;transition:all 0.2s;margin-left:4px;">
                                &#10005;
                            </button>
                        </div>
                    </aside>

                    <!-- Minimized Floating Pill (bottom-right) -->
                    <div id="cms-maintenance-mini-pill" style="display:none;position:fixed;bottom:16px;right:16px;z-index:999999;background:#78350f;border:1.5px solid #f59e0b;color:#fef3c7;border-radius:9999px;padding:6px 14px;font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,sans-serif;font-size:11px;font-weight:700;box-shadow:0 8px 24px rgba(0,0,0,0.6);align-items:center;gap:10px;backdrop-filter:blur(8px);">
                        <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#f59e0b;box-shadow:0 0 8px #f59e0b;animation:mmPulse 1.5s infinite;"></span>
                        <span style="color:#ffffff;">Údržba: ZAPNUTO</span>
                        <div style="display:flex;align-items:center;gap:6px;margin-left:4px;">
                            <a href="/admin/" style="background:rgba(0,0,0,0.3);color:#fef3c7;text-decoration:none;padding:3px 8px;border-radius:9999px;font-size:10px;">CMS</a>
                            <button type="button" onclick="toggleMmAdminBar(false)" title="Rozbalit lištu údržby" style="background:rgba(255,255,255,0.15);color:#fff;border:none;border-radius:9999px;padding:3px 8px;cursor:pointer;font-size:10px;font-weight:700;">
                                Rozbalit &#9650;
                            </button>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes mmPulse { 0% { opacity: 0.4; } 50% { opacity: 1; } 100% { opacity: 0.4; } }
                    
                    /* Dynamic offset for website elements */
                    :root {
                        --cms-mm-bar-height: 40px;
                    }

                    body.has-mm-admin-bar {
                        padding-top: var(--cms-mm-bar-height) !important;
                    }
                    
                    /* Offset fixed and sticky navigation headers so they are never covered */
                    body.has-mm-admin-bar .navbar,
                    body.has-mm-admin-bar #navbar,
                    body.has-mm-admin-bar nav.navbar,
                    body.has-mm-admin-bar header.navbar,
                    body.has-mm-admin-bar header.sticky,
                    body.has-mm-admin-bar header.fixed,
                    body.has-mm-admin-bar nav.fixed {
                        top: var(--cms-mm-bar-height) !important;
                    }

                    /* Offset decorative frame if present */
                    body.has-mm-admin-bar::before {
                        top: calc(20px + var(--cms-mm-bar-height)) !important;
                    }

                    @media (max-width: 900px) {
                        .mm-hide-mobile { display: none !important; }
                    }
                </style>

                <script>
                    function syncMmBarHeight() {
                        const bar = document.getElementById("cms-maintenance-admin-bar");
                        if (!bar || bar.style.display === "none") {
                            document.documentElement.style.setProperty("--cms-mm-bar-height", "0px");
                            document.body.classList.remove("has-mm-admin-bar");
                            return;
                        }
                        const h = bar.offsetHeight || 40;
                        document.documentElement.style.setProperty("--cms-mm-bar-height", h + "px");
                        document.body.classList.add("has-mm-admin-bar");
                    }

                    function toggleMmAdminBar(minimize) {
                        const bar = document.getElementById("cms-maintenance-admin-bar");
                        const pill = document.getElementById("cms-maintenance-mini-pill");
                        if (!bar || !pill) return;

                        if (minimize) {
                            bar.style.display = "none";
                            pill.style.display = "flex";
                            document.body.classList.remove("has-mm-admin-bar");
                            document.documentElement.style.setProperty("--cms-mm-bar-height", "0px");
                            try { sessionStorage.setItem("cms_mm_bar_minimized", "1"); } catch(e) {}
                        } else {
                            pill.style.display = "none";
                            bar.style.display = "flex";
                            syncMmBarHeight();
                            try { sessionStorage.removeItem("cms_mm_bar_minimized"); } catch(e) {}
                        }
                    }

                    function disableMaintenanceFromBar() {
                        if (!confirm("Opravdu chcete okamžitě vypnout režim údržby a zpřístupnit web veřejnosti?")) return;
                        fetch("/admin/plugins.php?action=toggle_maintenance_mode", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ is_enabled: false })
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.status === "success") {
                                window.location.reload();
                            } else {
                                alert(data.message || "Chyba při vypínání údržby.");
                            }
                        });
                    }

                    // Init state on load & resize
                    (function() {
                        const isMinimized = sessionStorage.getItem("cms_mm_bar_minimized") === "1";
                        if (isMinimized) {
                            toggleMmAdminBar(true);
                        } else {
                            syncMmBarHeight();
                            window.addEventListener("resize", syncMmBarHeight);
                            if (document.readyState === "loading") {
                                document.addEventListener("DOMContentLoaded", syncMmBarHeight);
                            }
                        }
                    })();
                </script>';

                return preg_replace('/<body([^>]*)>/i', '<body$1>' . $bannerHtml, $buffer, 1);
            });
        }

        /**
         * Universal AJAX Request Handler for PluginManager.
         */
        public static function handleRequest(string $action): ?array {
            switch ($action) {
                case 'get_maintenance_config':
                    return [
                        'status' => 'success',
                        'config' => self::getConfig(),
                        'client_ip' => self::getClientIp()
                    ];

                case 'save_maintenance_config':
                    $raw = file_get_contents('php://input');
                    $data = json_decode($raw, true);
                    if (!is_array($data)) {
                        return ['status' => 'error', 'message' => 'Neplatná data konfigurace.'];
                    }

                    // Sanitize and structure data
                    $current = self::getConfig();
                    $updated = [
                        'is_enabled' => !empty($data['is_enabled']),
                        'http_status' => in_array((int)($data['http_status'] ?? 503), [200, 503], true) ? (int)$data['http_status'] : 503,
                        'badge_text' => trim($data['badge_text'] ?? $current['badge_text']),
                        'page_title' => trim($data['page_title'] ?? $current['page_title']),
                        'heading' => trim($data['heading'] ?? $current['heading']),
                        'description' => trim($data['description'] ?? $current['description']),
                        'show_countdown' => !empty($data['show_countdown']),
                        'target_datetime' => trim($data['target_datetime'] ?? ''),
                        'auto_disable' => !empty($data['auto_disable']),
                        'whitelist_ips' => is_array($data['whitelist_ips'] ?? null) ? array_values(array_unique(array_filter($data['whitelist_ips']))) : [],
                        'bypass_token' => trim($data['bypass_token'] ?? $current['bypass_token']),
                        'show_phone' => !empty($data['show_phone']),
                        'phone' => trim($data['phone'] ?? $current['phone']),
                        'show_email' => !empty($data['show_email']),
                        'email' => trim($data['email'] ?? $current['email']),
                        'show_address' => !empty($data['show_address']),
                        'address' => trim($data['address'] ?? $current['address']),
                        'custom_css' => $data['custom_css'] ?? ''
                    ];

                    if (self::saveConfig($updated)) {
                        if (class_exists('CMS') && method_exists('CMS', 'gitCommit')) {
                            CMS::gitCommit("Update maintenance mode configuration");
                        }
                        return [
                            'status' => 'success',
                            'message' => 'Nastavení režimu údržby bylo úspěšně uloženo.',
                            'config' => $updated
                        ];
                    }
                    return ['status' => 'error', 'message' => 'Nepodařilo se uložit konfigurační soubor.'];

                case 'toggle_maintenance_mode':
                    $raw = file_get_contents('php://input');
                    $data = json_decode($raw, true);
                    $config = self::getConfig();
                    $newState = isset($data['is_enabled']) ? (bool)$data['is_enabled'] : !$config['is_enabled'];
                    $config['is_enabled'] = $newState;

                    if (self::saveConfig($config)) {
                        if (class_exists('CMS') && method_exists('CMS', 'gitCommit')) {
                            CMS::gitCommit("Toggle maintenance mode: " . ($newState ? "ENABLED" : "DISABLED"));
                        }
                        return [
                            'status' => 'success',
                            'message' => $newState ? 'Režim údržby byl zapnut.' : 'Režim údržby byl vypnut.',
                            'is_enabled' => $newState
                        ];
                    }
                    return ['status' => 'error', 'message' => 'Nepodařilo se změnit stav údržby.'];

                case 'generate_bypass_token':
                    $newToken = 'stranovice_' . bin2hex(random_bytes(6));
                    return [
                        'status' => 'success',
                        'token' => $newToken
                    ];
            }

            return null;
        }
    }

    // Automatically check and intercept when loaded into request pipeline
    MaintenanceModePlugin::checkAndIntercept();
}

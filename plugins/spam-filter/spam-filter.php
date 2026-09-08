<?php
/**
 * Plugin Name: Spam filter
 * Version: 1.0.0
 * Description: Pokročilá ochrana formulářů proti spamu a robotům. Automaticky se integruje do všech kontaktních a rezervačních formulářů po aktivaci (interaktivní ověření, honeypot, časový filtr, Turnstile & reCAPTCHA).
 * Author: Statek Straňovice
 * Settings Modal: openSpamFilterModal()
 * Settings Button: Spam Filter
 */

if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', rtrim(realpath(__DIR__ . '/../../') ?: __DIR__ . '/../..', '/'));
}

if (!class_exists('SpamFilterPlugin')) {
    class SpamFilterPlugin {
        private static string $configFile = __DIR__ . '/data/config.json';
        private static string $logFile = __DIR__ . '/data/spam_log.json';
        private static string $statsFile = __DIR__ . '/data/stats.json';
        private static bool $initialized = false;

        /**
         * Get plugin configuration with sensible defaults.
         */
        public static function getConfig(): array {
            $defaults = [
                'is_enabled' => true,
                'protection_mode' => 'internal', // 'internal', 'turnstile', 'recaptcha_v2', 'recaptcha_v3', 'honeypot_only'
                'internal_type' => 'checkbox',   // 'checkbox' (Nejsem robot), 'math' (příklad), 'question' (otázka)
                'honeypot_enabled' => true,
                'time_check_enabled' => true,
                'min_submit_time' => 2, // minimum seconds to fill form
                'max_submit_time' => 7200, // 2 hours expiry
                'turnstile_site_key' => '',
                'turnstile_secret_key' => '',
                'recaptcha_site_key' => '',
                'recaptcha_secret_key' => '',
                'block_disposable_emails' => true,
                'blocked_words' => [
                    'crypto', 'bitcoin', 'forex', 'casino', 'viagra', 'cialis',
                    'seo ranking', 'backlinks', 'guest post', 'loan offer', 'investment opportunity'
                ],
                'custom_question' => 'Kolik je pět plus dvě? (napište číslicí)',
                'custom_answer' => '7',
                'secret_salt' => ''
            ];

            if (file_exists(self::$configFile)) {
                $json = @json_decode(@file_get_contents(self::$configFile), true);
                if (is_array($json)) {
                    $defaults = array_merge($defaults, $json);
                }
            }

            if (empty($defaults['secret_salt'])) {
                $defaults['secret_salt'] = bin2hex(random_bytes(16));
                self::saveConfig($defaults);
            }

            return $defaults;
        }

        /**
         * Save plugin configuration.
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
            if ($res !== false) {
                @chmod(self::$configFile, 0666);
                return true;
            }
            return false;
        }

        /**
         * Initialize plugin hooks on frontend pages.
         */
        public static function init(): void {
            if (self::$initialized) return;
            self::$initialized = true;

            if (php_sapi_name() === 'cli' && !defined('TESTING_CLI_SPAM_FILTER')) return;

            // Do not intercept inside admin area
            $uri = $_SERVER['REQUEST_URI'] ?? '';
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
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

            // Exclude static assets
            if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg|woff2?|ttf|eot)$/i', parse_url($uri, PHP_URL_PATH))) {
                return;
            }

            $config = self::getConfig();
            if (empty($config['is_enabled'])) {
                return;
            }

            // Register output buffer to auto-inject Captcha into forms
            ob_start([__CLASS__, 'filterHtmlBuffer']);
        }

        /**
         * Process page HTML and inject Captcha elements into contact/reservation forms.
         */
        public static function filterHtmlBuffer(string $buffer): string {
            // Only process valid HTML pages containing forms
            if (stripos($buffer, '<form') === false || stripos($buffer, '</body>') === false) {
                return $buffer;
            }

            $config = self::getConfig();
            if (empty($config['is_enabled'])) {
                return $buffer;
            }

            $tokenData = self::generateTokens($config);
            $captchaHtml = self::renderCaptchaWidget($config, $tokenData);
            $assetsHtml = self::renderClientAssets($config, $tokenData);

            // Pattern to match contact-form or reservation forms
            $buffer = preg_replace_callback(
                '/(<form[^>]*class=["\'][^"\']*(?:contact-form|reservation-form|booking-form)[^"\']*["\'][^>]*>)(.*?)(<\/form>)/is',
                function($matches) use ($captchaHtml) {
                    $formOpen = $matches[1];
                    $formInner = $matches[2];
                    $formClose = $matches[3];

                    // Check if already injected
                    if (strpos($formInner, 'sf-captcha-container') !== false) {
                        return $matches[0];
                    }

                    // Ensure form targets send.php via POST
                    if (stripos($formOpen, 'action=') === false) {
                        $formOpen = preg_replace('/>$/', ' action="send.php" method="POST">', $formOpen);
                    }

                    // Insert captcha right before submit button
                    if (preg_match('/(<button[^>]*type=["\']submit["\'][^>]*>|<input[^>]*type=["\']submit["\'][^>]*>)/i', $formInner, $btnMatch, PREG_OFFSET_CAPTURE)) {
                        $btnOffset = $btnMatch[0][1];
                        $newInner = substr($formInner, 0, $btnOffset) . $captchaHtml . "\n" . substr($formInner, $btnOffset);
                        return $formOpen . $newInner . $formClose;
                    }

                    // Fallback: append before closing form
                    return $formOpen . $formInner . "\n" . $captchaHtml . "\n" . $formClose;
                },
                $buffer
            );

            // Inject assets right before </body>
            $buffer = str_ireplace('</body>', $assetsHtml . "\n</body>", $buffer);

            return $buffer;
        }

        /**
         * Generate dynamic anti-bot cryptographic tokens.
         */
        public static function generateTokens(array $config): array {
            $salt = $config['secret_salt'] ?? 'stranovice_salt';
            $time = time();
            $ip = self::getClientIp();
            $nonce = bin2hex(random_bytes(8));

            // Math numbers if math mode
            $num1 = rand(2, 9);
            $num2 = rand(1, 9);
            $mathAns = $num1 + $num2;
            $mathHash = hash_hmac('sha256', "math_{$mathAns}_{$nonce}", $salt);

            // Cryptographic signature of timestamp and nonce
            $sig = hash_hmac('sha256', "sf_{$time}_{$nonce}", $salt);

            return [
                'time' => $time,
                'nonce' => $nonce,
                'sig' => $sig,
                'math_num1' => $num1,
                'math_num2' => $num2,
                'math_hash' => $mathHash
            ];
        }

        /**
         * Render Captcha HTML markup for insertion into the form.
         */
        private static function renderCaptchaWidget(array $config, array $tokens): string {
            $mode = $config['protection_mode'] ?? 'internal';
            $internalType = $config['internal_type'] ?? 'checkbox';

            // Honeypot fields (totally invisible to humans, irresistible to dumb bots)
            $hpField1 = 'sf_hp_company_' . substr($tokens['nonce'], 0, 4);
            $hpField2 = 'sf_hp_url';

            $html = '
            <!-- Spam Filter Protected Widget -->
            <div class="sf-captcha-container" style="margin: 1.25rem 0 1rem 0; font-family: inherit;">
                <!-- Invisible Honeypots -->
                <div style="opacity: 0; position: absolute; top: 0; left: -9999px; height: 0; width: 0; z-index: -1; overflow: hidden;" aria-hidden="true">
                    <label for="' . $hpField1 . '">Prosím nevyplňujte toto pole (ochrana proti spamu):</label>
                    <input type="text" name="' . $hpField1 . '" id="' . $hpField1 . '" tabindex="-1" autocomplete="off" value="">
                    <input type="url" name="' . $hpField2 . '" id="' . $hpField2 . '" tabindex="-1" autocomplete="off" value="">
                    <input type="hidden" name="sf_render_time" value="' . $tokens['time'] . '">
                    <input type="hidden" name="sf_nonce" value="' . $tokens['nonce'] . '">
                    <input type="hidden" name="sf_sig" value="' . $tokens['sig'] . '">
                    <input type="hidden" name="sf_hp_field" value="' . $hpField1 . '">
                </div>';

            if ($mode === 'turnstile') {
                $siteKey = htmlspecialchars($config['turnstile_site_key'] ?? '');
                $html .= '
                <div class="sf-turnstile-wrapper" style="min-height: 65px;">
                    <div class="cf-turnstile" data-sitekey="' . $siteKey . '" data-theme="auto"></div>
                </div>';
            } elseif ($mode === 'recaptcha_v2') {
                $siteKey = htmlspecialchars($config['recaptcha_site_key'] ?? '');
                $html .= '
                <div class="sf-recaptcha-wrapper" style="min-height: 78px;">
                    <div class="g-recaptcha" data-sitekey="' . $siteKey . '"></div>
                </div>';
            } elseif ($mode === 'recaptcha_v3') {
                $siteKey = htmlspecialchars($config['recaptcha_site_key'] ?? '');
                $html .= '
                <input type="hidden" name="g-recaptcha-response" id="sf-recaptcha-v3-token" value="">
                <div class="sf-v3-notice" style="font-size: 11px; color: #888; display: flex; align-items: center; gap: 6px; padding: 4px 0;">
                    <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#c99e66;"></span>
                    <span>Tento formulář je chráněn technologií reCAPTCHA v3 proti spamu.</span>
                </div>';
            } elseif ($mode === 'honeypot_only') {
                $html .= '
                <div class="sf-badge-subtle" style="font-size: 11px; color: #888; display: flex; align-items: center; gap: 6px; padding: 2px 0;">
                    <span style="color:#c99e66; font-size:12px;">🛡️</span>
                    <span>Zabezpečeno inteligentním filtrem spamu.</span>
                </div>';
            } else {
                // INTERNAL SMART MODES
                if ($internalType === 'math') {
                    $html .= '
                    <input type="hidden" name="sf_math_hash" value="' . $tokens['math_hash'] . '">
                    <div class="sf-box sf-box-math" style="background: rgba(255,255,255,0.04); border: 1.5px solid rgba(201,158,102,0.3); border-radius: 12px; padding: 12px 16px; display: flex; flex-direction: column; gap: 8px;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <label style="font-size: 13px; font-weight: 600; color: #f3f4f6; display: flex; align-items: center; gap: 8px;">
                                <span style="display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; border-radius:6px; background:#c99e66; color:#1a1a1a; font-size:12px; font-weight:700;">🛡️</span>
                                <span>Kontrolní otázka: Kolik je <strong>' . $tokens['math_num1'] . ' + ' . $tokens['math_num2'] . '</strong>?</span>
                            </label>
                            <span style="font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">Antispam</span>
                        </div>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="number" name="sf_math_answer" placeholder="Zadejte výsledek..." required style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 8px 12px; color: #fff; font-size: 13px; width: 140px; outline: none; transition: border-color 0.2s;">
                            <span style="font-size: 11px; color: #9ca3af;">Ochrana proti automatickým robotům</span>
                        </div>
                    </div>';
                } elseif ($internalType === 'question') {
                    $qText = htmlspecialchars($config['custom_question'] ?? 'Kolik nohou má kůň?');
                    $html .= '
                    <div class="sf-box sf-box-question" style="background: rgba(255,255,255,0.04); border: 1.5px solid rgba(201,158,102,0.3); border-radius: 12px; padding: 12px 16px; display: flex; flex-direction: column; gap: 8px;">
                        <label style="font-size: 13px; font-weight: 600; color: #f3f4f6; display: flex; align-items: center; gap: 8px;">
                            <span style="color:#c99e66; font-size:14px;">🛡️</span>
                            <span>' . $qText . '</span>
                        </label>
                        <input type="text" name="sf_custom_answer" placeholder="Vaše odpověď..." required style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 8px 12px; color: #fff; font-size: 13px; width: 100%; max-width: 280px; outline: none;">
                    </div>';
                } else {
                    // Default: Interactive "Nejsem robot" Checkbox
                    $html .= '
                    <div class="sf-box sf-box-interactive" id="sf-interactive-box" style="background: rgba(20,24,33,0.7); border: 1.5px solid rgba(201,158,102,0.35); border-radius: 12px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.15); transition: border-color 0.25s, box-shadow 0.25s; cursor: pointer; user-select: none;">
                        <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; margin: 0; width: 100%;">
                            <div class="sf-check-circle" style="width: 26px; height: 26px; border-radius: 6px; border: 2px solid rgba(201,158,102,0.6); background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; transition: all 0.25s ease; flex-shrink: 0; position: relative;">
                                <input type="checkbox" name="sf_human_check" value="1" id="sf-human-checkbox" required style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer;">
                                <svg class="sf-checkmark" style="display: none; width: 16px; height: 16px; stroke: #c99e66; stroke-width: 3; fill: none; stroke-linecap: round; stroke-linejoin: round;" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <div class="sf-spinner" style="display: none; width: 14px; height: 14px; border: 2px solid rgba(201,158,102,0.2); border-top-color: #c99e66; border-radius: 50%; animation: sfSpin 0.7s linear infinite;"></div>
                            </div>
                            <span class="sf-label-text" style="font-size: 13px; font-weight: 600; color: #f3f4f6; letter-spacing: 0.2px;">Nejsem robot</span>
                        </label>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; justify-content: center; padding-left: 12px; border-left: 1px solid rgba(255,255,200,0.08); flex-shrink: 0;">
                            <div style="display: flex; align-items: center; gap: 4px;">
                                <span style="font-size: 14px;">🛡️</span>
                                <span style="font-size: 10px; font-weight: 700; color: #c99e66; letter-spacing: 0.4px;">SPAM FILTER</span>
                            </div>
                            <span style="font-size: 9px; color: #9ca3af;">Statek Straňovice</span>
                        </div>
                    </div>
                    <input type="hidden" name="sf_interact_token" id="sf-interact-token" value="">';
                }
            }

            $html .= "\n            </div><!-- /sf-captcha-container -->";
            return $html;
        }

        /**
         * Render client assets (JS/CSS) required for Captcha.
         */
        private static function renderClientAssets(array $config, array $tokens): string {
            $mode = $config['protection_mode'] ?? 'internal';
            $internalType = $config['internal_type'] ?? 'checkbox';
            $out = '';

            // CSS styles for interactive widget
            $out .= '
            <style>
                @keyframes sfSpin {
                    to { transform: rotate(360deg); }
                }
                .sf-box-interactive:hover {
                    border-color: rgba(201,158,102,0.7) !important;
                    box-shadow: 0 6px 20px rgba(201,158,102,0.15) !important;
                }
                .sf-box-interactive.sf-verified {
                    border-color: #10b981 !important;
                    background: rgba(16,185,129,0.08) !important;
                }
                .sf-box-interactive.sf-verified .sf-check-circle {
                    border-color: #10b981 !important;
                    background: rgba(16,185,129,0.2) !important;
                }
                .sf-box-interactive.sf-verified .sf-checkmark {
                    display: block !important;
                    stroke: #10b981 !important;
                }
                .sf-box-interactive.sf-verified .sf-label-text {
                    color: #10b981 !important;
                }
            </style>';

            // Cloudflare Turnstile Script
            if ($mode === 'turnstile') {
                $out .= '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>';
            }

            // Google reCAPTCHA v2 Script
            if ($mode === 'recaptcha_v2') {
                $out .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
            }

            // Google reCAPTCHA v3 Script
            if ($mode === 'recaptcha_v3') {
                $siteKey = htmlspecialchars($config['recaptcha_site_key'] ?? '');
                $out .= '<script src="https://www.google.com/recaptcha/api.js?render=' . $siteKey . '"></script>';
                $out .= '
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        if (typeof grecaptcha !== "undefined") {
                            grecaptcha.ready(function() {
                                grecaptcha.execute("' . $siteKey . '", {action: "submit"}).then(function(token) {
                                    var el = document.getElementById("sf-recaptcha-v3-token");
                                    if (el) el.value = token;
                                });
                            });
                        }
                    });
                </script>';
            }

            // Interactive "Nejsem robot" script
            if ($mode === 'internal' && $internalType === 'checkbox') {
                $salt = $config['secret_salt'] ?? 'stranovice_salt';
                $clientKey = hash_hmac('sha256', $tokens['nonce'] . '_client', $salt);

                $out .= '
                <script>
                (function() {
                    function initSpamFilterWidget() {
                        var box = document.getElementById("sf-interactive-box");
                        var cb = document.getElementById("sf-human-checkbox");
                        var tokenInput = document.getElementById("sf-interact-token");
                        if (!box || !cb || box.dataset.sfInit) return;
                        box.dataset.sfInit = "1";

                        var spinner = box.querySelector(".sf-spinner");
                        var checkmark = box.querySelector(".sf-checkmark");

                        function triggerVerify() {
                            if (box.classList.contains("sf-verified")) return;
                            if (spinner) spinner.style.display = "block";
                            if (checkmark) checkmark.style.display = "none";

                            // Human delay simulation
                            setTimeout(function() {
                                if (spinner) spinner.style.display = "none";
                                box.classList.add("sf-verified");
                                cb.checked = true;
                                if (tokenInput) {
                                    tokenInput.value = "' . $clientKey . '";
                                }
                            }, 450);
                        }

                        box.addEventListener("click", function(e) {
                            if (e.target !== cb) {
                                e.preventDefault();
                            }
                            triggerVerify();
                        });

                        cb.addEventListener("change", function() {
                            if (this.checked) triggerVerify();
                        });
                    }

                    if (document.readyState === "loading") {
                        document.addEventListener("DOMContentLoaded", initSpamFilterWidget);
                    } else {
                        initSpamFilterWidget();
                    }
                })();
                </script>';
            }

            return $out;
        }

        /**
         * Main submission verifier.
         * Call this from send.php before processing an email.
         *
         * @param array $post Submitted $_POST data
         * @return array ['success' => bool, 'message' => string]
         */
        public static function verifySubmission(array $post): array {
            $config = self::getConfig();

            // If plugin disabled in settings, allow everything
            if (empty($config['is_enabled'])) {
                return ['success' => true, 'message' => 'Ochrana je vypnuta.'];
            }

            $ip = self::getClientIp();
            $clientEmail = trim($post['email'] ?? '');

            // 1. Honeypot check
            if (!empty($config['honeypot_enabled'])) {
                $hpField = $post['sf_hp_field'] ?? '';
                if (!empty($hpField) && !empty($post[$hpField])) {
                    self::logSpam('Honeypot past: robot vyplnil skryté pole ' . htmlspecialchars($hpField), $post);
                    return ['success' => false, 'message' => 'Bezpečnostní kontrola selhala (detekován spam bot).'];
                }
                if (!empty($post['sf_hp_url'])) {
                    self::logSpam('Honeypot past: vyplněno skryté pole sf_hp_url', $post);
                    return ['success' => false, 'message' => 'Bezpečnostní kontrola selhala (detekován spam bot).'];
                }
            }

            // 2. Time check
            if (!empty($config['time_check_enabled'])) {
                $renderTime = (int)($post['sf_render_time'] ?? 0);
                $minTime = (int)($config['min_submit_time'] ?? 2);
                $maxTime = (int)($config['max_submit_time'] ?? 7200);

                if ($renderTime <= 0) {
                    self::logSpam('Chybí časové razítko vykreslení formuláře', $post);
                    return ['success' => false, 'message' => 'Formulář byl odeslán bez bezpečnostního časového razítka. Obnovte prosím stránku.'];
                }

                $elapsed = time() - $renderTime;
                if ($elapsed < $minTime) {
                    self::logSpam("Formulář odeslán podezřele rychle ({$elapsed}s < {$minTime}s)", $post);
                    return ['success' => false, 'message' => 'Formulář byl odeslán příliš rychle. Prosím počkejte chvíli a zkuste to znovu.'];
                }

                if ($elapsed > $maxTime) {
                    self::logSpam("Platnost formuláře vypršela ({$elapsed}s > {$maxTime}s)", $post);
                    return ['success' => false, 'message' => 'Platnost formuláře vypršela. Obnovte prosím stránku a odešlete zprávu znovu.'];
                }
            }

            // 3. Cryptographic Signature check
            $salt = $config['secret_salt'] ?? 'stranovice_salt';
            $renderTime = (int)($post['sf_render_time'] ?? 0);
            $nonce = $post['sf_nonce'] ?? '';
            $sig = $post['sf_sig'] ?? '';
            $expectedSig1 = hash_hmac('sha256', "sf_{$renderTime}_{$nonce}", $salt);
            $expectedSig2 = hash_hmac('sha256', "sf_{$renderTime}_{$ip}_{$nonce}", $salt);

            if (!hash_equals($expectedSig1, $sig) && !hash_equals($expectedSig2, $sig)) {
                self::logSpam('Neplatný kryptografický podpis formuláře (možný útok přehráním)', $post);
                return ['success' => false, 'message' => 'Bezpečnostní podpis formuláře je neplatný. Obnovte prosím stránku.'];
            }

            // 4. Mode-specific verification
            $mode = $config['protection_mode'] ?? 'internal';

            if ($mode === 'turnstile') {
                $token = $post['cf-turnstile-response'] ?? '';
                if (empty($token)) {
                    self::logSpam('Chybí ověření Cloudflare Turnstile', $post);
                    return ['success' => false, 'message' => 'Prosím potvrďte ověření Cloudflare Turnstile.'];
                }

                $res = self::verifyCloudflareTurnstile($token, $config['turnstile_secret_key'] ?? '', $ip);
                if (!$res['success']) {
                    self::logSpam('Ověření Cloudflare Turnstile selhalo: ' . ($res['message'] ?? ''), $post);
                    return ['success' => false, 'message' => 'Ověření Cloudflare Turnstile nebylo úspěšné.'];
                }
            } elseif ($mode === 'recaptcha_v2' || $mode === 'recaptcha_v3') {
                $token = $post['g-recaptcha-response'] ?? '';
                if (empty($token)) {
                    self::logSpam('Chybí ověření Google reCAPTCHA', $post);
                    return ['success' => false, 'message' => 'Prosím zaškrtněte ověření Google reCAPTCHA.'];
                }

                $res = self::verifyGoogleRecaptcha($token, $config['recaptcha_secret_key'] ?? '', $ip);
                if (!$res['success']) {
                    self::logSpam('Ověření Google reCAPTCHA selhalo: ' . ($res['message'] ?? ''), $post);
                    return ['success' => false, 'message' => 'Ověření Google reCAPTCHA nebylo úspěšné.'];
                }
            } elseif ($mode === 'internal') {
                $internalType = $config['internal_type'] ?? 'checkbox';

                if ($internalType === 'math') {
                    $userAnswer = trim($post['sf_math_answer'] ?? '');
                    $mathHash = $post['sf_math_hash'] ?? '';
                    $expectedHash = hash_hmac('sha256', "math_{$userAnswer}_{$nonce}", $salt);

                    if (empty($userAnswer) || !hash_equals($expectedHash, $mathHash)) {
                        self::logSpam("Nesprávný výsledek matematického příkladu (zadáno: '{$userAnswer}')", $post);
                        return ['success' => false, 'message' => 'Chybný výsledek kontrolního matematického příkladu. Zkuste to prosím znovu.'];
                    }
                } elseif ($internalType === 'question') {
                    $userAns = mb_strtolower(trim($post['sf_custom_answer'] ?? ''));
                    $expectedAns = mb_strtolower(trim($config['custom_answer'] ?? '7'));

                    if ($userAns === '' || $userAns !== $expectedAns) {
                        self::logSpam("Nesprávná odpověď na kontrolní otázku (zadáno: '{$userAns}', očekáváno: '{$expectedAns}')", $post);
                        return ['success' => false, 'message' => 'Chybná odpověď na kontrolní otázku.'];
                    }
                } else {
                    // Checkbox "Nejsem robot"
                    $interactToken = $post['sf_interact_token'] ?? '';
                    $expectedClientKey = hash_hmac('sha256', $nonce . '_client', $salt);

                    if (empty($post['sf_human_check']) || !hash_equals($expectedClientKey, $interactToken)) {
                        self::logSpam('Nebylo zaškrtnuto ověření "Nejsem robot"', $post);
                        return ['success' => false, 'message' => 'Prosím potvrďte zaškrtávací pole "Nejsem robot".'];
                    }
                }
            }

            // 5. Disposable Email Check
            if (!empty($config['block_disposable_emails']) && !empty($clientEmail)) {
                if (self::isDisposableEmail($clientEmail)) {
                    self::logSpam("Pokus o odeslání z dočasné e-mailové schránky ({$clientEmail})", $post);
                    return ['success' => false, 'message' => 'Z bezpečnostních důvodů nepřijímáme zprávy z dočasných a anonymních e-mailových schránek.'];
                }
            }

            // 6. Blocked Keywords Check
            $blockedWords = $config['blocked_words'] ?? [];
            if (is_array($blockedWords) && !empty($blockedWords)) {
                $allText = mb_strtolower(implode(' ', array_values($post)));
                foreach ($blockedWords as $badWord) {
                    $badWord = trim(mb_strtolower($badWord));
                    if (!empty($badWord) && mb_strpos($allText, $badWord) !== false) {
                        self::logSpam("Zpráva obsahuje zakázané spamové klíčové slovo: '{$badWord}'", $post);
                        return ['success' => false, 'message' => 'Zpráva obsahuje nepovolená klíčová slova nebo nevyžádanou reklamu.'];
                    }
                }
            }

            // Passed all checks!
            self::incrementStats('passed');
            return ['success' => true, 'message' => 'Ověření proběhlo v pořádku.'];
        }

        /**
         * Verify Cloudflare Turnstile token via API.
         */
        private static function verifyCloudflareTurnstile(string $token, string $secretKey, string $ip): array {
            if (empty($secretKey)) {
                return ['success' => false, 'message' => 'Turnstile Secret Key není nastaven v administraci.'];
            }

            $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
            $data = [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $ip
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                    'timeout' => 5
                ]
            ];

            $context  = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            if ($result === false) {
                return ['success' => false, 'message' => 'Chyba spojení s Cloudflare servery.'];
            }

            $json = json_decode($result, true);
            return [
                'success' => !empty($json['success']),
                'message' => !empty($json['error-codes']) ? implode(', ', $json['error-codes']) : ''
            ];
        }

        /**
         * Verify Google reCAPTCHA token via API.
         */
        private static function verifyGoogleRecaptcha(string $token, string $secretKey, string $ip): array {
            if (empty($secretKey)) {
                return ['success' => false, 'message' => 'Google reCAPTCHA Secret Key není nastaven v administraci.'];
            }

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $ip
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                    'timeout' => 5
                ]
            ];

            $context  = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            if ($result === false) {
                return ['success' => false, 'message' => 'Chyba spojení s Google servery.'];
            }

            $json = json_decode($result, true);
            return [
                'success' => !empty($json['success']),
                'message' => !empty($json['error-codes']) ? implode(', ', $json['error-codes']) : ''
            ];
        }

        /**
         * Check if email domain is a known disposable email provider.
         */
        private static function isDisposableEmail(string $email): bool {
            $parts = explode('@', $email);
            if (count($parts) !== 2) return false;
            $domain = strtolower(trim($parts[1]));

            $disposables = [
                'mailinator.com', 'guerrillamail.com', '10minutemail.com', 'tempmail.com',
                'temp-mail.org', 'yopmail.com', 'dispostable.com', 'getairmail.com',
                'sharklasers.com', 'trashmail.com', 'fakeinbox.com', 'throwawaymail.com'
            ];

            return in_array($domain, $disposables, true);
        }

        /**
         * Log blocked spam attempt.
         */
        private static function logSpam(string $reason, array $post): void {
            self::incrementStats('blocked');

            $dir = dirname(self::$logFile);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }

            $entries = [];
            if (file_exists(self::$logFile)) {
                $entries = @json_decode(@file_get_contents(self::$logFile), true) ?: [];
            }

            $entry = [
                'id' => uniqid('spam_', true),
                'datetime' => date('d.m.Y H:i:s'),
                'timestamp' => time(),
                'ip' => self::getClientIp(),
                'reason' => $reason,
                'name' => htmlspecialchars(substr($post['jmeno'] ?? $post['name'] ?? '—', 0, 80)),
                'email' => htmlspecialchars(substr($post['email'] ?? '—', 0, 80)),
                'phone' => htmlspecialchars(substr($post['telefon'] ?? $post['phone'] ?? '—', 0, 40)),
                'preview' => htmlspecialchars(substr($post['zprava'] ?? $post['message'] ?? '', 0, 150))
            ];

            array_unshift($entries, $entry);
            // Keep last 150 entries
            $entries = array_slice($entries, 0, 150);

            @file_put_contents(self::$logFile, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            @chmod(self::$logFile, 0666);
        }

        /**
         * Increment spam statistics.
         */
        private static function incrementStats(string $type): void {
            $dir = dirname(self::$statsFile);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }

            $stats = ['passed' => 0, 'blocked' => 0, 'last_activity' => 0];
            if (file_exists(self::$statsFile)) {
                $stats = @json_decode(@file_get_contents(self::$statsFile), true) ?: $stats;
            }

            if (isset($stats[$type])) {
                $stats[$type]++;
            }
            $stats['last_activity'] = time();

            @file_put_contents(self::$statsFile, json_encode($stats, JSON_PRETTY_PRINT));
            @chmod(self::$statsFile, 0666);
        }

        /**
         * Get client IP address.
         */
        public static function getClientIp(): string {
            $headers = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
            foreach ($headers as $h) {
                if (!empty($_SERVER[$h])) {
                    $list = explode(',', $_SERVER[$h]);
                    $ip = trim($list[0]);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
            return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }

        /**
         * Dynamic Plugin Action Handler for PluginManager in admin/index.php.
         */
        public static function handleRequest(string $action): ?array {
            switch ($action) {
                case 'get_spam_filter_config':
                    $config = self::getConfig();
                    $stats = ['passed' => 0, 'blocked' => 0, 'last_activity' => 0];
                    if (file_exists(self::$statsFile)) {
                        $stats = @json_decode(@file_get_contents(self::$statsFile), true) ?: $stats;
                    }
                    $log = [];
                    if (file_exists(self::$logFile)) {
                        $log = @json_decode(@file_get_contents(self::$logFile), true) ?: [];
                    }

                    return [
                        'status' => 'success',
                        'config' => $config,
                        'stats' => $stats,
                        'log' => $log
                    ];

                case 'save_spam_filter_config':
                    $raw = file_get_contents('php://input');
                    $data = json_decode($raw, true);
                    if (!is_array($data)) {
                        $data = $_POST;
                    }

                    $current = self::getConfig();
                    $updated = array_merge($current, [
                        'is_enabled' => !empty($data['is_enabled']),
                        'protection_mode' => $data['protection_mode'] ?? 'internal',
                        'internal_type' => $data['internal_type'] ?? 'checkbox',
                        'honeypot_enabled' => !empty($data['honeypot_enabled']),
                        'time_check_enabled' => !empty($data['time_check_enabled']),
                        'min_submit_time' => max(1, (int)($data['min_submit_time'] ?? 2)),
                        'turnstile_site_key' => trim($data['turnstile_site_key'] ?? ''),
                        'turnstile_secret_key' => trim($data['turnstile_secret_key'] ?? ''),
                        'recaptcha_site_key' => trim($data['recaptcha_site_key'] ?? ''),
                        'recaptcha_secret_key' => trim($data['recaptcha_secret_key'] ?? ''),
                        'block_disposable_emails' => !empty($data['block_disposable_emails']),
                        'custom_question' => trim($data['custom_question'] ?? 'Kolik je pět plus dvě? (napište číslicí)'),
                        'custom_answer' => trim($data['custom_answer'] ?? '7')
                    ]);

                    if (isset($data['blocked_words'])) {
                        if (is_string($data['blocked_words'])) {
                            $lines = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $data['blocked_words'])));
                            $updated['blocked_words'] = array_values($lines);
                        } elseif (is_array($data['blocked_words'])) {
                            $updated['blocked_words'] = array_values($data['blocked_words']);
                        }
                    }

                    if (self::saveConfig($updated)) {
                        if (class_exists('CMS')) {
                            CMS::gitCommit("Spam filter settings update");
                        }
                        return ['status' => 'success', 'message' => 'Nastavení Spam filtru bylo úspěšně uloženo.', 'config' => $updated];
                    }
                    return ['status' => 'error', 'message' => 'Chyba při ukládání nastavení do souboru data/config.json.'];

                case 'clear_spam_log':
                    @file_put_contents(self::$logFile, json_encode([], JSON_PRETTY_PRINT));
                    return ['status' => 'success', 'message' => 'Log zachyceného spamu byl úspěšně promazán.'];

                case 'reset_spam_stats':
                    $reset = ['passed' => 0, 'blocked' => 0, 'last_activity' => time()];
                    @file_put_contents(self::$statsFile, json_encode($reset, JSON_PRETTY_PRINT));
                    return ['status' => 'success', 'message' => 'Statistiky byly vynulovány.'];

                default:
                    return null;
            }
        }
    }
}

// Auto-boot hook when plugin is loaded into CMS runtime
SpamFilterPlugin::init();

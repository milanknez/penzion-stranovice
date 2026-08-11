<?php
/**
 * Plugin Name: SMTP Mailer & Override
 * Description: Odesílá e-maily spolehlivě přes váš vlastní SMTP server (Seznam, Gmail, Webglobe atd.) místo nefunkční nativní mail() funkce.
 * Version: 1.0.0
 * Author: Fida Software
 * Settings Modal: openSMTPModal()
 * Settings Button: Nastavení SMTP
 */

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', rtrim(realpath(__DIR__ . '/../../') ?: __DIR__ . '/../..', '/'));
}

class FidaSMTPMailer {
    public static function getSMTPConfig() {
        $localFile = __DIR__ . '/config.php';
        if (file_exists($localFile)) {
            $config = @include $localFile;
            if (is_array($config)) {
                return $config;
            }
        }

        // Migration check from global config dir
        $globalPhp = __DIR__ . '/../../config/smtp.php';
        if (file_exists($globalPhp)) {
            $config = @include $globalPhp;
            if (is_array($config)) {
                self::saveSMTPConfig($config);
                @unlink($globalPhp);
                return $config;
            }
        }

        $globalJson = __DIR__ . '/../../config/smtp.json';
        if (file_exists($globalJson)) {
            $json = @json_decode(@file_get_contents($globalJson), true);
            if (is_array($json)) {
                self::saveSMTPConfig($json);
                @unlink($globalJson);
                return $json;
            }
        }

        return [
            'host' => '',
            'port' => 587,
            'encryption' => 'tls',
            'username' => '',
            'password' => '',
            'from_email' => '',
            'from_name' => 'Penzion Stranovice'
        ];
    }

    public static function saveSMTPConfig(array $data) {
        $localFile = __DIR__ . '/config.php';
        $export = var_export($data, true);
        $content = "<?php\n// Protected configuration file for SMTP Mailer plugin\nif (!defined('ROOT_DIR') && !defined('ADMIN_PATH')) { exit('Access Denied'); }\nreturn {$export};\n";
        @file_put_contents($localFile, $content, LOCK_EX);
        @chmod($localFile, 0666);

        // Cleanup global legacy config files
        $globalPhp = __DIR__ . '/../../config/smtp.php';
        if (file_exists($globalPhp)) { @unlink($globalPhp); }
        $globalJson = __DIR__ . '/../../config/smtp.json';
        if (file_exists($globalJson)) { @unlink($globalJson); }
    }

    public static function log(string $message, string $level = 'INFO'): void {
        $logFile = __DIR__ . '/smtp.log';
        $entry = sprintf("[%s] [%s] %s\n", date('Y-m-d H:i:s'), strtoupper($level), $message);
        @file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
        @chmod($logFile, 0666);
    }

    public static function getLogs(int $maxLines = 50): string {
        $logFile = __DIR__ . '/smtp.log';
        if (!file_exists($logFile)) {
            return "Zatím žádné záznamy v logu.";
        }
        $lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$lines) return "Log je prázdný.";
        $slice = array_slice($lines, -$maxLines);
        return implode("\n", $slice);
    }

    public static function sendMail($to, $subject, $body, $headers = '') {
        $config = self::getSMTPConfig();
        if (empty($config['host'])) {
            self::log("SMTP Host není nastaven, používá se nativní mail()", "WARNING");
            return @mail($to, $subject, $body, $headers);
        }

        $host = trim($config['host']);
        $port = intval($config['port'] ?? 587);
        $encryption = strtolower($config['encryption'] ?? 'tls');
        $username = trim($config['username'] ?? '');
        $password = trim($config['password'] ?? '');
        $fromEmail = !empty($config['from_email']) ? trim($config['from_email']) : $username;
        $defaultName = (class_exists('CMS') && method_exists('CMS', 'getSiteConfig')) ? (CMS::getSiteConfig()['name'] ?? 'Můj Web') : 'Můj Web';
        $fromName = !empty($config['from_name']) ? trim($config['from_name']) : $defaultName;

        $socketHost = ($encryption === 'ssl' ? 'ssl://' : '') . $host;
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);

        $socket = @stream_socket_client($socketHost . ':' . $port, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $context);
        if (!$socket) {
            self::log("Spojení k {$socketHost}:{$port} selhalo: {$errstr} ({$errno})", "ERROR");
            return false;
        }

        $read = function() use ($socket) {
            $response = '';
            while ($str = @fgets($socket, 515)) {
                $response .= $str;
                if (substr($str, 3, 1) == ' ') break;
            }
            return $response;
        };

        $read();
        @fwrite($socket, "EHLO " . gethostname() . "\r\n");
        $read();

        if ($encryption === 'tls') {
            @fwrite($socket, "STARTTLS\r\n");
            $read();
            @stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            @fwrite($socket, "EHLO " . gethostname() . "\r\n");
            $read();
        }

        if (!empty($username) && !empty($password)) {
            @fwrite($socket, "AUTH LOGIN\r\n");
            $read();
            @fwrite($socket, base64_encode($username) . "\r\n");
            $read();
            @fwrite($socket, base64_encode($password) . "\r\n");
            $authResp = $read();
            if (substr($authResp, 0, 3) != '235') {
                @fclose($socket);
                self::log("Autentizace pro uživatele {$username} selhala: " . trim($authResp), "ERROR");
                return false;
            }
        }

        @fwrite($socket, "MAIL FROM: <{$fromEmail}>\r\n");
        $read();
        @fwrite($socket, "RCPT TO: <{$to}>\r\n");
        $read();
        @fwrite($socket, "DATA\r\n");
        $read();

        $headersStr = "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
        $headersStr .= "To: <{$to}>\r\n";
        $headersStr .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headersStr .= "MIME-Version: 1.0\r\n";
        $headersStr .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headersStr .= "Date: " . date('r') . "\r\n";
        if (!empty($headers)) {
            $headersStr .= trim($headers) . "\r\n";
        }

        @fwrite($socket, $headersStr . "\r\n" . $body . "\r\n.\r\n");
        $res = $read();
        @fwrite($socket, "QUIT\r\n");
        @fclose($socket);

        $success = (substr($res, 0, 3) == '250');
        if ($success) {
            self::log("E-mail úspešně odeslán na <{$to}> (Předmět: {$subject})", "SUCCESS");
        } else {
            self::log("Odeslání e-mailu na <{$to}> selhalo. Odpověď serveru: " . trim($res), "ERROR");
        }

        return $success;
    }

    public static function hasSettings(): bool {
        return true;
    }

    public static function renderSettings(): string {
        $cfg = self::getSMTPConfig();
        $siteConfig = class_exists('CMS') && method_exists('CMS', 'getSiteConfig') ? CMS::getSiteConfig() : [];
        $siteName = htmlspecialchars($siteConfig['name'] ?? 'Můj Web');
        $siteEmail = htmlspecialchars($siteConfig['email'] ?? 'info@domain.cz');

        $host = htmlspecialchars($cfg['host'] ?? '');
        $port = htmlspecialchars($cfg['port'] ?? 587);
        $encryption = strtolower($cfg['encryption'] ?? 'tls');
        $username = htmlspecialchars($cfg['username'] ?? '');
        $password = htmlspecialchars($cfg['password'] ?? '');
        $fromEmail = htmlspecialchars($cfg['from_email'] ?? '');
        $fromName = htmlspecialchars($cfg['from_name'] ?? '');

        $tlsSel = ($encryption === 'tls') ? 'selected' : '';
        $sslSel = ($encryption === 'ssl') ? 'selected' : '';
        $noneSel = ($encryption === 'none') ? 'selected' : '';

        return '
        <div class="space-y-4 text-xs">
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <label class="block font-bold text-slate-300 uppercase mb-1.5">SMTP Host / Server *</label>
                    <input type="text" id="smtp-host" value="' . $host . '" placeholder="např. smtp.seznam.cz" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1.5">Port *</label>
                    <input type="number" id="smtp-port" value="' . $port . '" placeholder="587 / 465" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1.5">Šifrování</label>
                    <select id="smtp-encryption" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500">
                        <option value="tls" ' . $tlsSel . '>TLS (port 587)</option>
                        <option value="ssl" ' . $sslSel . '>SSL (port 465)</option>
                        <option value="none" ' . $noneSel . '>Žádné (port 25)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1.5">E-mail odesílatele</label>
                    <input type="email" id="smtp-from-email" value="' . $fromEmail . '" placeholder="' . $siteEmail . '" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1.5">SMTP Uživatel (Přihlášení)</label>
                    <input type="text" id="smtp-username" value="' . $username . '" placeholder="vaše jméno nebo e-mail" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1.5">SMTP Heslo</label>
                    <input type="password" id="smtp-password" value="' . $password . '" placeholder="••••••••••••" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-300 uppercase mb-1.5">Jméno Odesílatele</label>
                <input type="text" id="smtp-from-name" value="' . $fromName . '" placeholder="' . $siteName . '" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500">
            </div>

            <div class="pt-2 border-t border-white/5 flex items-center justify-between gap-3">
                <span class="text-[11px] text-slate-400">Před uložením můžete spojení otestovat:</span>
                <button type="button" onclick="testSMTPConnection()" id="btn-test-smtp" class="bg-slate-800 hover:bg-slate-700 text-indigo-300 font-bold px-4 py-2.5 rounded-xl border border-indigo-500/30 transition-all text-xs flex items-center gap-1.5">
                    <i class="fa fa-paper-plane"></i> Otestovat spojení
                </button>
            </div>

            <div class="pt-3 border-t border-white/10">
                <div class="flex items-center justify-between mb-1.5">
                    <label class="font-bold text-slate-300 uppercase">
                        <i class="fa fa-list-alt text-indigo-400"></i> Souborový Log Pluginu (smtp.log)
                    </label>
                    <span class="text-[10px] text-slate-400 font-mono">plugins/smtp-mailer/smtp.log</span>
                </div>
                <textarea readonly class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-slate-300 font-mono text-[11px] h-32 leading-relaxed outline-none overflow-y-auto select-all">' . htmlspecialchars(self::getLogs(30)) . '</textarea>
            </div>
        </div>';
    }

    public static function renderHelp(): string {
        return '
        <div class="space-y-4">
            <div class="bg-indigo-950/40 border border-indigo-500/30 rounded-xl p-4">
                <h4 class="text-sm font-bold text-indigo-300 mb-1 flex items-center gap-2">
                    <i class="fa fa-rocket"></i> 1. Odesílání e-mailů přes CMS::sendMail
                </h4>
                <p class="text-slate-300 mb-2">V jakémkoliv PHP skriptu webu (např. ve formuláři <code class="text-indigo-300 font-mono">send.php</code>) jednoduše zavolejte statickou metodu CMS:</p>
                <pre class="bg-slate-950 p-3 rounded-lg border border-white/10 font-mono text-[11px] text-emerald-400 overflow-x-auto">CMS::sendMail($to, $subject, $body, $headers);</pre>
                <p class="text-[11px] text-slate-400 mt-2">Pokud je plugin SMTP Mailer <strong>aktivní</strong>, e-mail proběhne přes nastavený SMTP server. Není třeba načítat PHPMailer ani nastavovat přihlašovací údaje přímo v kódu formuláře.</p>
            </div>

            <div class="bg-slate-950 border border-white/10 rounded-xl p-4 space-y-2">
                <h4 class="text-sm font-bold text-white flex items-center gap-2">
                    <i class="fa fa-cogs text-indigo-400"></i> 2. Konfigurace v Administraci
                </h4>
                <ul class="list-disc list-inside space-y-1.5 text-slate-300 text-xs">
                    <li>Klikněte na tlačítko <strong class="text-indigo-300"><i class="fa fa-cog"></i> Nastavení</strong> u pluginu.</li>
                    <li>Zadejte údaje vašeho poštovního serveru (např. Seznam: <code class="text-slate-400">smtp.seznam.cz</code>, port <code class="text-slate-400">587</code>, šifrování <code class="text-slate-400">TLS</code>).</li>
                    <li>Vložte uživatelské jméno a heslo k vaší e-mailové schránce.</li>
                    <li>Pro ověření stiskněte tlačítko <strong class="text-indigo-300">Otestovat spojení</strong>.</li>
                </ul>
            </div>
        </div>';
    }

    /**
     * Dynamic Plugin Action Handler for PluginManager
     */
    public static function handleRequest(string $action): ?array {
        switch ($action) {
            case 'get_plugin_settings_html':
                return ['status' => 'success', 'html' => self::renderSettings()];

            case 'get_plugin_help_html':
                return ['status' => 'success', 'html' => self::renderHelp()];

            case 'get_smtp_config':
                return ['status' => 'success', 'config' => self::getSMTPConfig()];

            case 'save_smtp_config':
                $raw = file_get_contents('php://input');
                $data = json_decode($raw, true);
                if (!$data || !is_array($data)) {
                    return ['status' => 'error', 'message' => 'Neplatná data.'];
                }
                self::saveSMTPConfig($data);
                if (class_exists('CMS') && method_exists('CMS', 'gitCommit')) {
                    CMS::gitCommit("Update SMTP configuration");
                }
                return ['status' => 'success', 'message' => 'Nastavení SMTP bylo úspěšně uloženo.'];

            case 'test_smtp':
                $raw = file_get_contents('php://input');
                $data = json_decode($raw, true);
                $testEmail = $data['test_email'] ?? '';
                if (empty($testEmail) && class_exists('CMS') && method_exists('CMS', 'getSiteConfig')) {
                    $siteConfig = CMS::getSiteConfig();
                    $testEmail = $siteConfig['email'] ?? 'test@example.com';
                }
                if (empty($testEmail)) {
                    $testEmail = 'test@example.com';
                }

                $subject = "Testovací e-mail SMTP | " . date('d.m.Y H:i:s');
                $body = "Dobrý den,\n\ntoto je testovací e-mail pro ověření funkčnosti vašeho SMTP serveru ve Fida CMS.\n\nSpojení přes SMTP proběhlo úspěšně!\n\nDatum: " . date('d.m.Y H:i:s');
                $sent = self::sendMail($testEmail, $subject, $body);

                if ($sent) {
                    return ['status' => 'success', 'message' => "Testovací e-mail byl úspěšně odeslán na adresu $testEmail."];
                }
                return ['status' => 'error', 'message' => "Nepodařilo se odeslat testovací e-mail přes SMTP. Zkontrolujte přihlašovací údaje, port a šifrování."];
        }

        return null;
    }
}

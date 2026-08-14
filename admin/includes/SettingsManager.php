<?php

class SettingsManager {
    private string $rootDir;
    private string $siteJsonFile;

    public function __construct(?string $rootDir = null) {
        if ($rootDir) {
            $this->rootDir = rtrim(realpath($rootDir) ?: $rootDir, '/');
        } else {
            $this->rootDir = rtrim(realpath(__DIR__ . '/../../') ?: realpath(__DIR__ . '/../') ?: __DIR__ . '/..', '/');
        }

        $this->siteJsonFile = $this->rootDir . '/config/site.json';
    }

    /**
     * Get global site settings.
     */
    public function getSettings(): array {
        if (file_exists($this->siteJsonFile)) {
            $json = @json_decode(@file_get_contents($this->siteJsonFile), true);
            if (is_array($json)) {
                return $json;
            }
        }
        return [];
    }

    /**
     * Update global site settings.
     */
    public function updateSettings(array $data): array {
        $site = $this->getSettings();

        if (isset($data['site_name'])) $site['site_name'] = $data['site_name'];
        if (isset($data['phone_nonstop'])) $site['phone_nonstop'] = $data['phone_nonstop'];
        if (isset($data['phone_landline'])) $site['phone_landline'] = $data['phone_landline'];
        if (isset($data['email'])) $site['email'] = $data['email'];
        if (isset($data['address_headquarters'])) $site['address_headquarters'] = $data['address_headquarters'];
        if (isset($data['address_dispatch'])) $site['address_dispatch'] = $data['address_dispatch'];
        if (isset($data['ga_id'])) $site['ga_id'] = $data['ga_id'];
        if (isset($data['favicon'])) $site['favicon'] = $data['favicon'];
        if (isset($data['contact_form_recipient'])) $site['contact_form_recipient'] = $data['contact_form_recipient'];
        if (isset($data['error_page_404'])) $site['error_page_404'] = $data['error_page_404'];
        if (isset($data['force_https'])) $site['force_https'] = !empty($data['force_https']) ? true : false;
        if (isset($data['redirect_www'])) $site['redirect_www'] = in_array($data['redirect_www'], ['none', 'www_to_non_www', 'non_www_to_www']) ? $data['redirect_www'] : 'none';
        $site['enable_cache'] = !empty($data['enable_cache']) ? true : false;

        $configDir = dirname($this->siteJsonFile);
        if (!file_exists($configDir)) {
            @mkdir($configDir, 0777, true);
        }
        @chmod($configDir, 0777);
        if (file_exists($this->siteJsonFile)) {
            @chmod($this->siteJsonFile, 0666);
        }

        $json = json_encode($site, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $res = @file_put_contents($this->siteJsonFile, $json);
        if ($res === false) {
            $tmpFile = $configDir . '/site.tmp.' . time() . '.json';
            if (@file_put_contents($tmpFile, $json) !== false) {
                @unlink($this->siteJsonFile);
                @rename($tmpFile, $this->siteJsonFile);
                $res = file_exists($this->siteJsonFile);
            }
        }

        if ($res !== false) {
            @chmod($this->siteJsonFile, 0666);

            CMS::generateCache();
            CMS::gitCommit("Update global site settings");

            return ['status' => 'success', 'message' => 'Globální nastavení bylo uloženo a cache aktualizována.'];
        }

        return ['status' => 'error', 'message' => 'Chyba při zápisu do config/site.json.'];
    }

    /**
     * Upload custom favicon file.
     */
    public function uploadFavicon(array $fileInfo): array {
        if (!isset($fileInfo['tmp_name']) || $fileInfo['error'] !== UPLOAD_ERR_OK) {
            return ['status' => 'error', 'message' => 'Chyba při nahrávání souboru ikonky.'];
        }

        $ext = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
        $allowed = ['ico', 'png', 'svg', 'jpg', 'jpeg', 'webp', 'gif'];
        if (!in_array($ext, $allowed)) {
            return ['status' => 'error', 'message' => 'Neplatný formát souboru. Povolené formáty: ' . implode(', ', $allowed)];
        }

        $assetsDir = $this->rootDir . '/assets';
        if (!file_exists($assetsDir)) {
            @mkdir($assetsDir, 0777, true);
        }

        $filename = 'favicon.' . $ext;
        $targetPath = $assetsDir . '/' . $filename;

        if (move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
            @chmod($targetPath, 0666);
            $relativePath = 'assets/' . $filename;

            // Update site.json
            $site = $this->getSettings();
            $site['favicon'] = $relativePath;
            @file_put_contents($this->siteJsonFile, json_encode($site, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            CMS::generateCache();
            CMS::gitCommit("Upload custom favicon: $filename");

            return [
                'status' => 'success',
                'message' => 'Favicon byl úspěšně nahran.',
                'favicon' => $relativePath
            ];
        }

        return ['status' => 'error', 'message' => 'Nepodařilo se uložit soubor do složky assets/.'];
    }

    /**
     * Rebuild cache manually.
     */
    public function rebuildCache(): array {
        CMS::generateCache();
        CMS::gitCommit("Manual cache regeneration");

        return ['status' => 'success', 'message' => 'Cache byla úspěšně přegenerována.'];
    }

    /**
     * Fix permissions for project files.
     */
    public function fixPermissions(): array {
        $count = 0;
        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->rootDir, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {
                $path = $item->getPathname();
                if (strpos($path, '/.git') !== false) {
                    continue;
                }
                if ($item->isDir()) {
                    @chmod($path, 0777);
                } else {
                    @chmod($path, 0666);
                }
                $count++;
            }
        } catch (\Throwable $e) {
            // Fallback for simple glob if recursive fails
            $files = glob($this->rootDir . '/*');
            foreach ($files as $f) {
                if (is_dir($f)) @chmod($f, 0777);
                else @chmod($f, 0666);
                $count++;
            }
        }

        return [
            'status' => 'success',
            'message' => "Oprávnění souborů a složek byla úspěšně opravena ($count položek)."
        ];
    }

    /**
     * Change admin master password in admin/config.php.
     */
    public function changePassword(string $oldPassword, string $newPassword): array {
        if (empty($newPassword)) {
            return ['status' => 'error', 'message' => 'Nové heslo nemůže být prázdné.'];
        }
        if (strlen($newPassword) < 4) {
            return ['status' => 'error', 'message' => 'Nové heslo musí mít alespoň 4 znaky.'];
        }

        if (defined('ADMIN_PASSWORD') && $oldPassword !== ADMIN_PASSWORD) {
            return ['status' => 'error', 'message' => 'Stávající heslo není správné.'];
        }

        $configFile = __DIR__ . '/../config.php';
        if (!file_exists($configFile)) {
            return ['status' => 'error', 'message' => 'Soubor admin/config.php nebyl nalezen.'];
        }

        $content = file_get_contents($configFile);
        $escapedNewPass = addcslashes($newPassword, "'\\");
        $pattern = "/define\(\s*['\"]ADMIN_PASSWORD['\"]\s*,\s*['\"].*?['\"]\s*\);/";
        $replacement = "define('ADMIN_PASSWORD', '" . $escapedNewPass . "');";

        if (preg_match($pattern, $content)) {
            $newContent = preg_replace($pattern, $replacement, $content);
        } else {
            return ['status' => 'error', 'message' => 'Definice ADMIN_PASSWORD nebyla v config.php nalezena.'];
        }

        @chmod(dirname($configFile), 0777);
        @chmod($configFile, 0666);
        $res = @file_put_contents($configFile, $newContent);
        if ($res === false) {
            @chmod($configFile, 0777);
            $res = @file_put_contents($configFile, $newContent);
        }
        if ($res === false) {
            $tmpFile = dirname($configFile) . '/config.tmp.php';
            if (@file_put_contents($tmpFile, $newContent) !== false) {
                @copy($tmpFile, $configFile);
                @unlink($tmpFile);
                $res = true;
            }
        }

        if ($res !== false) {
            @chmod($configFile, 0666);
            return ['status' => 'success', 'message' => 'Heslo pro administraci bylo úspěšně změněno.'];
        }

        return ['status' => 'error', 'message' => 'Chyba při zápisu do admin/config.php. Zkontrolujte oprávnění souboru.'];
    }
}


<?php

class CMS {
    private static $siteConfig = null;
    private static $pagesConfig = null;

    public static function getSiteConfig() {
        if (self::$siteConfig === null) {
            $path = __DIR__ . '/../config/site.json';
            if (file_exists($path)) {
                self::$siteConfig = json_decode(file_get_contents($path), true);
            } else {
                self::$siteConfig = [];
            }
        }
        return self::$siteConfig;
    }

    public static function getPagesConfig() {
        if (self::$pagesConfig === null) {
            $path = __DIR__ . '/../config/pages.json';
            if (file_exists($path)) {
                self::$pagesConfig = json_decode(file_get_contents($path), true);
            } else {
                self::$pagesConfig = [];
            }
        }
        return self::$pagesConfig;
    }

    public static function getPageMeta($pageName = null) {
        if ($pageName === null) {
            $pageName = basename($_SERVER['PHP_SELF']);
        }
        
        $pages = self::getPagesConfig();
        return $pages[$pageName] ?? [
            'slug' => str_replace('.php', '', $pageName),
            'title' => self::getSiteConfig()['site_name'] ?? 'Web',
            'description' => '',
            'keywords' => ''
        ];
    }

    public static function url($file) {
        $pages = self::getPagesConfig();
        if (isset($pages[$file]) && !empty($pages[$file]['slug'])) {
            return '/' . $pages[$file]['slug'];
        }
        return '/' . str_replace('.php', '', $file);
    }

    public static function isUpdateAvailable() {
        $rootDir = realpath(__DIR__ . '/../');
        if (!file_exists($rootDir . '/admin/config.php')) return false;
        require_once $rootDir . '/admin/config.php';
        
        if (!defined('REPO_URL') || !defined('APP_VERSION')) return false;
        
        $repoClean = str_replace('.git', '', REPO_URL);
        $repoParts = explode('github.com/', $repoClean);
        if (count($repoParts) < 2) return false;
        
        $repoPath = $repoParts[1];
        $branch = 'main';
        $githubVersionUrl = "https://raw.githubusercontent.com/$repoPath/$branch/admin/version.php";
        
        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $remoteVersionFile = @file_get_contents($githubVersionUrl, false, $ctx);
        
        if ($remoteVersionFile && preg_match("/define\('APP_VERSION', '(.*?)'\)/", $remoteVersionFile, $matches)) {
            $remoteVersion = $matches[1];
            return version_compare($remoteVersion, APP_VERSION, '>');
        }
        return false;
    }

    public static function gitCommit($message) {
        $rootDir = realpath(__DIR__ . '/../');
        require_once $rootDir . '/admin/config.php';
        
        if (self::isUpdateAvailable()) {
            return "ERROR: Byla nalezena novější verze na GitHubu. Prosím, proveďte nejprve aktualizaci systému.";
        }

        $repoClean = str_replace('.git', '', REPO_URL);
        $repoParts = explode('github.com/', $repoClean);
        $repoPath = $repoParts[1];
        $branch = 'main';
        $token = GITHUB_TOKEN;

        // Files to push
        $filesToPush = [];

        // 1. Increment and prepare version.php
        $versionFile = $rootDir . '/admin/version.php';
        if (file_exists($versionFile)) {
            $content = file_get_contents($versionFile);
            if (preg_match("/define\('APP_VERSION', '(.*?)'\)/", $content, $matches)) {
                $oldVersion = $matches[1];
                $parts = explode('.', $oldVersion);
                if (count($parts) === 3) {
                    $parts[2]++; 
                    $newVersion = implode('.', $parts);
                    $newContent = preg_replace("/define\('APP_VERSION', '(.*?)'\)/", "define('APP_VERSION', '$newVersion')", $content);
                    file_put_contents($versionFile, $newContent);
                    $filesToPush['admin/version.php'] = $newContent;
                }
            }
        }

        // 2. Identify current page and config that might have changed
        // We look at the session to see what was just saved
        if (isset($_SESSION['current_page'])) {
            $page = $_SESSION['current_page'];
            $pagePath = $rootDir . '/' . $page;
            if (file_exists($pagePath)) {
                $filesToPush[$page] = file_get_contents($pagePath);
            }
        }
        
        $pagesJson = $rootDir . '/config/pages.json';
        if (file_exists($pagesJson)) {
            $filesToPush['config/pages.json'] = file_get_contents($pagesJson);
        }

        $results = [];
        foreach ($filesToPush as $path => $content) {
            $results[] = self::pushToGitHubAPI($repoPath, $path, $content, $message, $branch, $token);
        }

        return implode("\n", $results);
    }

    private static function pushToGitHubAPI($repo, $path, $content, $message, $branch, $token) {
        $url = "https://api.github.com/repos/$repo/contents/$path?ref=$branch";
        $ch = curl_init($url);
        
        $headers = [
            'Authorization: token ' . $token,
            'User-Agent: FidaCMS-Editor',
            'Accept: application/vnd.github.v3+json'
        ];

        // 1. Get the current file SHA from GitHub (required for update)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $data = json_decode($response, true);
        $sha = isset($data['sha']) ? $data['sha'] : null;

        // 2. Prepare the PUT request
        $putData = [
            'message' => $message,
            'content' => base64_encode($content),
            'branch' => $branch
        ];
        if ($sha) $putData['sha'] = $sha;

        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/$repo/contents/$path");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($putData));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return "OK: $path aktualizován na GitHubu.";
        } else {
            $err = json_decode($response, true);
            return "ERROR: Nepodařilo se nahrát $path: " . ($err['message'] ?? 'Neznámá chyba');
        }
    }



}

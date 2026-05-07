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

    public static function gitCommit($message) {
        $rootDir = realpath(__DIR__ . '/../');
        require_once $rootDir . '/admin/config.php';
        
        $repoUrl = REPO_URL;
        if (defined('GITHUB_TOKEN') && GITHUB_TOKEN !== '') {
            $repoUrl = str_replace('https://', 'https://' . GITHUB_TOKEN . '@', $repoUrl);
        }

        // Check if git is initialized
        if (!file_exists($rootDir . '/.git')) {
            shell_exec("cd " . escapeshellarg($rootDir) . " && git init");
            shell_exec("cd " . escapeshellarg($rootDir) . " && git remote add origin " . escapeshellarg($repoUrl));
        } else {
            // Update remote URL in case token changed
            shell_exec("cd " . escapeshellarg($rootDir) . " && git remote set-url origin " . escapeshellarg($repoUrl));
        }

        // Git commands
        $commands = [
            "git add .",
            "git commit -m " . escapeshellarg($message),
            "git push origin main"
        ];

        $output = [];
        foreach ($commands as $cmd) {
            $output[] = shell_exec("cd " . escapeshellarg($rootDir) . " && $cmd 2>&1");
        }
        return implode("\n", $output);
    }
}

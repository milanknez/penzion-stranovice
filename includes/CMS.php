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
        $pages = self::getPagesConfig();
        $siteConfig = self::getSiteConfig();
        $siteName = $siteConfig['site_name'] ?? 'Statek Straňovice';

        if ($pageName === null) {
            // Priority 1: Constant set by router
            if (defined('CURRENT_PAGE')) {
                $pageName = CURRENT_PAGE;
            } 
            // Priority 2: Direct script name
            else {
                $scriptName = basename($_SERVER['SCRIPT_NAME']);
                
                if (isset($pages[$scriptName])) {
                    $pageName = $scriptName;
                } 
                // Priority 3: Detect by URL slug
                else {
                    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
                    $path = parse_url($requestUri, PHP_URL_PATH);
                    $slug = trim($path, '/');
                    
                    if (empty($slug) || $slug === 'index' || $slug === 'index.php') {
                        $pageName = 'index.php';
                    } else {
                        foreach ($pages as $file => $config) {
                            if (isset($config['slug']) && $config['slug'] === $slug) {
                                $pageName = $file;
                                break;
                            }
                        }
                        
                        if ($pageName === null) {
                            $potentialFile = $slug . '.php';
                            if (file_exists($potentialFile)) {
                                $pageName = $potentialFile;
                            } else {
                                $pageName = 'index.php';
                            }
                        }
                    }
                }
            }
        }
        
        $meta = $pages[$pageName] ?? [
            'slug' => str_replace('.php', '', $pageName),
            'title' => $siteName,
            'description' => '',
            'keywords' => ''
        ];

        if (empty($meta['title'])) {
            $meta['title'] = $siteName;
        }

        return $meta;
    }

    public static function getBasePath() {
        // Detect base path (e.g. /w1) from script name
        $base = str_replace(['/includes/CMS.php', '/admin/save.php', '/admin/index.php', '/router.php'], '', $_SERVER['SCRIPT_NAME']);
        return rtrim($base, '/');
    }

    public static function url($file) {
        $base = self::getBasePath();
        
        if ($file === 'index.php') return $base . '/';
        
        $pages = self::getPagesConfig();
        if (isset($pages[$file]) && !empty($pages[$file]['slug'])) {
            return $base . '/' . $pages[$file]['slug'];
        }
        return $base . '/' . str_replace('.php', '', $file);
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
        $githubVersionUrl = "https://raw.githubusercontent.com/$repoPath/$branch/admin/version.php?nocache=" . uniqid();
        
        // Use cURL instead of file_get_contents for better compatibility
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $githubVersionUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FidaCMS-UpdateChecker-' . uniqid());
        $remoteVersionFile = curl_exec($ch);
        curl_close($ch);
        
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

        // 1. Increment version.php
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
                    $message .= " (v$newVersion)";
                }
            }
        }

        // 2. Identify current page
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

        if (empty($filesToPush)) return "Žádné změny k nahrání.";

        // 3. Include all uploaded images
        $uploadDir = $rootDir . '/assets/img/uploads/';
        if (file_exists($uploadDir)) {
            $files = scandir($uploadDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filesToPush['assets/img/uploads/' . $file] = file_get_contents($uploadDir . $file);
                }
            }
        }

        return self::pushMultipleToGitHubAPI($repoPath, $filesToPush, $message, $branch, $token);
    }

    private static function pushMultipleToGitHubAPI($repo, $files, $message, $branch, $token) {
        $headers = [
            'Authorization: token ' . $token,
            'User-Agent: FidaCMS-Editor',
            'Accept: application/vnd.github.v3+json',
            'Content-Type: application/json'
        ];

        // 1. Get latest commit SHA
        $res = self::githubRequest("GET", "https://api.github.com/repos/$repo/git/refs/heads/$branch", null, $headers);
        $lastCommitSha = $res['object']['sha'] ?? null;
        if (!$lastCommitSha) return "ERROR: Nepodařilo se získat SHA poslední revize.";

        // 2. Create Tree
        $treeData = ['base_tree' => $lastCommitSha, 'tree' => []];
        $binaryExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico', 'pdf'];

        foreach ($files as $path => $content) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $treeEntry = [
                'path' => $path,
                'mode' => '100644',
                'type' => 'blob'
            ];

            if (in_array($ext, $binaryExtensions)) {
                // Create blob for binary file
                $blobData = [
                    'content' => base64_encode($content),
                    'encoding' => 'base64'
                ];
                $blobRes = self::githubRequest("POST", "https://api.github.com/repos/$repo/git/blobs", $blobData, $headers);
                if (isset($blobRes['sha'])) {
                    $treeEntry['sha'] = $blobRes['sha'];
                } else {
                    return "ERROR: Nepodařilo se vytvořit blob pro $path: " . ($blobRes['message'] ?? 'Neznámá chyba');
                }
            } else {
                $treeEntry['content'] = $content;
            }

            $treeData['tree'][] = $treeEntry;
        }
        $res = self::githubRequest("POST", "https://api.github.com/repos/$repo/git/trees", $treeData, $headers);
        $newTreeSha = $res['sha'] ?? null;
        if (!$newTreeSha) return "ERROR: Nepodařilo se vytvořit strom (tree).";

        // 3. Create Commit
        $commitData = [
            'message' => $message,
            'tree' => $newTreeSha,
            'parents' => [$lastCommitSha]
        ];
        $res = self::githubRequest("POST", "https://api.github.com/repos/$repo/git/commits", $commitData, $headers);
        $newCommitSha = $res['sha'] ?? null;
        if (!$newCommitSha) return "ERROR: Nepodařilo se vytvořit commit.";

        // 4. Update Reference
        $refData = ['sha' => $newCommitSha];
        $res = self::githubRequest("PATCH", "https://api.github.com/repos/$repo/git/refs/heads/$branch", $refData, $headers);
        
        if (isset($res['object']['sha'])) {
            return "OK: Změny byly nahrány v jednom commitu na GitHub.";
        } else {
            return "ERROR: Nepodařilo se aktualizovat větev (branch).";
        }
    }

    private static function githubRequest($method, $url, $data, $headers) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }




}

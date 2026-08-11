<?php
namespace CMS\Models;

class PageModel {
    private string $pagesConfigPath;
    private string $pagesDir;

    public function __construct() {
        $this->pagesConfigPath = CMS_ROOT . '/config/pages.json';
        $this->pagesDir = CMS_ROOT . '/pages';
        if (!file_exists($this->pagesDir)) {
            @mkdir($this->pagesDir, 0777, true);
        }
    }

    public function getAllPages(): array {
        if (file_exists($this->pagesConfigPath)) {
            $data = json_decode(file_get_contents($this->pagesConfigPath), true);
            return is_array($data) ? $data : [];
        }
        return [];
    }

    public function createPage(string $title, string $slug): array {
        $slug = preg_replace('/[^a-z0-9_-]/i', '-', strtolower(trim($slug)));
        $filename = $slug . '.php';
        $targetPath = $this->pagesDir . '/' . $filename;

        if (file_exists($targetPath)) {
            return ['status' => 'error', 'message' => 'Stránka s tímto názvem již existuje.'];
        }

        $template = "<?php\nrequire_once __DIR__ . '/../admin/includes/CMS.php';\nCMS::getHeader();\n?>\n<section class=\"section-padding\">\n    <div class=\"container\">\n        <h1>" . htmlspecialchars($title) . "</h1>\n    </div>\n</section>\n<?php\nCMS::getFooter();\n?>\n";

        if (file_put_contents($targetPath, $template) !== false) {
            $pages = $this->getAllPages();
            $pages[$filename] = [
                'slug' => $slug,
                'title' => $title,
                'description' => '',
                'keywords' => ''
            ];
            file_put_contents($this->pagesConfigPath, json_encode($pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return ['status' => 'success', 'message' => 'Stránka vytvořena', 'filename' => $filename, 'slug' => $slug];
        }

        return ['status' => 'error', 'message' => 'Chyba při zápisu souboru.'];
    }
}

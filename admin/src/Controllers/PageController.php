<?php
namespace CMS\Controllers;

use CMS\Models\PageModel;

class PageController {
    private PageModel $model;

    public function __construct() {
        $this->model = new PageModel();
    }

    public function index(): array {
        return ['status' => 'success', 'data' => $this->model->getAllPages()];
    }

    public function create(string $title, string $slug): array {
        if (empty($title)) {
            return ['status' => 'error', 'message' => 'Název nesmí být prázdný.'];
        }
        return $this->model->createPage($title, $slug);
    }
}

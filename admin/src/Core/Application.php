<?php
namespace CMS\Core;

class Application {
    private static ?Application $instance = null;

    private function __construct() {
        if (!defined('CMS_ROOT')) {
            define('CMS_ROOT', rtrim(realpath(__DIR__ . '/../../../') ?: __DIR__ . '/../../../', '/'));
        }
        if (!defined('CMS_ADMIN_DIR')) {
            define('CMS_ADMIN_DIR', CMS_ROOT . '/admin');
        }
        if (!defined('CMS_BASE_URL')) {
            define('CMS_BASE_URL', '');
        }

        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
    }

    public static function getInstance(): Application {
        if (self::$instance === null) {
            self::$instance = new Application();
        }
        return self::$instance;
    }
}

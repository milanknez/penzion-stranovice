<?php
/**
 * Core Application Bootstrap
 */
require_once __DIR__ . '/../Autoloader.php';

// Register PSR-4 Autoloader
\CMS\Autoloader::register();

// Initialize Application Core Singleton
\CMS\Core\Application::getInstance();

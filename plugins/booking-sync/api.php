<?php
// API endpoint for booking-sync plugin
header('Content-Type: application/json');

if (file_exists(__DIR__ . '/booking-sync.php')) {
    require_once __DIR__ . '/booking-sync.php';
    if (class_exists('SyncBookingPlugin')) {
        if (isset($_GET['action']) && $_GET['action'] === 'sync') {
            SyncBookingPlugin::sync();
        }
        echo json_encode(SyncBookingPlugin::getOccupancy());
        exit;
    }
}

echo json_encode(['error' => 'Plugin not initialized']);

<?php
// Safe wrapper for booking-sync plugin
if (!class_exists('SyncBooking') && file_exists(__DIR__ . '/../plugins/booking-sync/booking-sync.php')) {
    require_once __DIR__ . '/../plugins/booking-sync/booking-sync.php';
}

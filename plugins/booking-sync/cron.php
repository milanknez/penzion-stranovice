<?php
/**
 * Cron runner for booking-sync plugin.
 * Executes synchronization from Booking.com & MegaUbytko.cz.
 * 
 * Auto-interval: 30 minutes (1800 seconds).
 * If called before 30 minutes have elapsed, it silently exits (no-op) to keep web page requests fast.
 * If called with ?force=1 or via CLI, it forces execution regardless of interval.
 */

@ini_set('display_errors', '0');
error_reporting(0);
if (!ini_get('date.timezone')) {
    date_default_timezone_set('Europe/Prague');
}

$pluginDir = __DIR__;
$lockFile  = $pluginDir . '/data/cron.last';
$interval  = 1800; // 30 minutes in seconds

$isCli = (php_sapi_name() === 'cli');
$isForced = $isCli || (isset($_GET['force']) && $_GET['force'] === '1');

// Check interval if not forced
if (!$isForced && file_exists($lockFile)) {
    $lastRun = (int)@file_get_contents($lockFile);
    if ($lastRun > 0 && (time() - $lastRun) < $interval) {
        // Less than 30 minutes since last run - skip execution
        if (isset($_GET['action']) && $_GET['action'] === 'cron_status') {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'skipped',
                'message' => 'Interval 30 minut ještě nevypršel.',
                'last_run' => date('Y-m-d H:i:s', $lastRun),
                'next_run_in_seconds' => $interval - (time() - $lastRun)
            ]);
        }
        return; // Safe return for inclusion in CMS flow
    }
}

// Ensure plugin class is loaded
require_once $pluginDir . '/booking-sync.php';

if (!class_exists('SyncBookingPlugin')) {
    return;
}

$startTime = microtime(true);
$success = SyncBookingPlugin::sync();
$duration = round(microtime(true) - $startTime, 3);
$now = time();

// Update timestamp
@file_put_contents($lockFile, (string)$now);

// If called directly via web or CLI, produce output
if ($isCli) {
    $dateStr = date('Y-m-d H:i:s', $now);
    echo "[$dateStr] Booking Sync Cron: " . ($success ? "SUCCESS ({$duration}s)" : "FAILED") . "\n";
} elseif (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'cron.php') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => $success ? 'success' : 'error',
        'timestamp' => date('Y-m-d H:i:s', $now),
        'duration_seconds' => $duration,
        'message' => $success ? 'Synchronizace úspěšně dokončena.' : 'Chyba při synchronizaci.'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

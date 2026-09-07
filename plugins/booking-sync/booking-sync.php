<?php
/*
Plugin Name: Synchronizace Obsazenosti (Booking & MegaUbytko)
Version: 1.0.0
Description: Automatická synchronizace kalendářů obsazenosti s Booking.com a MegaUbytko.cz.
Author: Statek Straňovice
Settings Modal: openBookingSyncModal()
Settings Button: Synchronizace rezervací
*/

if (!class_exists('SyncBookingPlugin')) {
    class SyncBookingPlugin {
        private static $configPath = __DIR__ . '/data/rooms.json';
        private static $outputPath = __DIR__ . '/data/occupancy.json';

        private static function getRoomsConfigPath() {
            return self::$configPath;
        }

        private static function getOccupancyPath() {
            return self::$outputPath;
        }

        public static function init() {
            // Non-blocking sync init
        }

        public static function sync() {
            $configPath = self::getRoomsConfigPath();
            $outputPath = self::getOccupancyPath();

            if (!file_exists($configPath)) return false;
            
            $rooms = json_decode(@file_get_contents($configPath), true);
            if (!is_array($rooms)) return false;

            $occupancy = [];

            foreach ($rooms as $id => $room) {
                $roomDates = [];
                $urls = [];

                if (!empty($room['ical_url'])) {
                    $urls[] = $room['ical_url'];
                }
                if (!empty($room['megaubytko_ical_url'])) {
                    $urls[] = $room['megaubytko_ical_url'];
                }

                foreach ($urls as $url) {
                    $icalContent = self::fetchUrl($url);
                    if ($icalContent) {
                        $parsed = self::parseIcal($icalContent);
                        if (!empty($parsed)) {
                            $roomDates = array_merge($roomDates, $parsed);
                        }
                    }
                }

                $occupancy[$id] = array_values(array_unique($roomDates));
            }

            $dir = dirname($outputPath);
            if (!file_exists($dir)) {
                @mkdir($dir, 0777, true);
                @chmod($dir, 0777);
            }

            $json = json_encode($occupancy, JSON_PRETTY_PRINT);
            @file_put_contents($outputPath, $json);
            @chmod($outputPath, 0666);

            $totalDays = 0;
            foreach ($occupancy as $dates) {
                $totalDays += count($dates);
            }

            $now = time();
            $dt = new DateTime('now', new DateTimeZone('Europe/Prague'));
            $statusData = [
                'timestamp' => $now,
                'last_sync' => $dt->format('d.m.Y H:i:s'),
                'total_days' => $totalDays,
                'status' => 'success'
            ];
            $statusFile = $dir . '/sync_status.json';
            $lockFile = $dir . '/cron.last';
            @file_put_contents($statusFile, json_encode($statusData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            @chmod($statusFile, 0666);
            @file_put_contents($lockFile, (string)$now);
            @chmod($lockFile, 0666);
            @touch($outputPath, $now);
            clearstatcache(true, $outputPath);
            clearstatcache(true, $statusFile);
            clearstatcache(true, $lockFile);

            return true;
        }

        private static function fetchUrl($url) {
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 8);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                $result = curl_exec($ch);
                curl_close($ch);
                if ($result !== false && !empty($result)) {
                    return $result;
                }
            }
            $context = stream_context_create(['http' => ['timeout' => 8]]);
            return @file_get_contents($url, false, $context);
        }

        private static function parseIcal($content) {
            $dates = [];
            preg_match_all('/BEGIN:VEVENT.*?END:VEVENT/s', $content, $events);

            if (!empty($events[0])) {
                foreach ($events[0] as $event) {
                    preg_match('/DTSTART[^:\r\n]*:(\d{8})/', $event, $startMatch);
                    preg_match('/DTEND[^:\r\n]*:(\d{8})/', $event, $endMatch);

                    if (isset($startMatch[1]) && isset($endMatch[1])) {
                        $start = DateTime::createFromFormat('Ymd', substr($startMatch[1], 0, 8));
                        $end = DateTime::createFromFormat('Ymd', substr($endMatch[1], 0, 8));

                        if ($start && $end) {
                            $interval = new DateInterval('P1D');
                            $period = new DatePeriod($start, $interval, $end);

                            foreach ($period as $date) {
                                $dates[] = $date->format('Y-m-d');
                            }
                        }
                    }
                }
            }
            return array_unique($dates);
        }

        public static function getOccupancy() {
            $outputPath = self::getOccupancyPath();
            if (file_exists($outputPath)) {
                $data = json_decode(@file_get_contents($outputPath), true);
                if (is_array($data) && !empty($data)) {
                    return $data;
                }
            }
            return [];
        }

        public static function shouldSync() {
            $outputPath = self::getOccupancyPath();
            if (!file_exists($outputPath)) return true;
            $data = @file_get_contents($outputPath);
            if (empty($data) || $data === '{}' || strlen(trim($data)) < 10) return true;
            return (time() - filemtime($outputPath)) > 1800;
        }

        public static function getStatusInfo() {
            $outputPath = self::getOccupancyPath();
            $configPath = self::getRoomsConfigPath();
            $rooms = file_exists($configPath) ? json_decode(@file_get_contents($configPath), true) : [];
            $occupancy = file_exists($outputPath) ? json_decode(@file_get_contents($outputPath), true) : [];
            
            $totalDays = 0;
            if (is_array($occupancy)) {
                foreach ($occupancy as $dates) {
                    $totalDays += count($dates);
                }
            }

            $statusFile = dirname($outputPath) . '/sync_status.json';
            $lastSync = 0;
            $lastSyncStr = 'Zatím neproběhla';

            if (file_exists($statusFile)) {
                $statusJson = @json_decode(@file_get_contents($statusFile), true);
                if (!empty($statusJson['last_sync'])) {
                    $lastSyncStr = $statusJson['last_sync'];
                    $lastSync = $statusJson['timestamp'] ?? 0;
                    if (isset($statusJson['total_days'])) {
                        $totalDays = (int)$statusJson['total_days'];
                    }
                }
            }

            if ($lastSync === 0 && file_exists($outputPath)) {
                clearstatcache(true, $outputPath);
                $lastSync = filemtime($outputPath);
                if ($lastSync > 0) {
                    try {
                        $dt = new DateTime('@' . $lastSync);
                        $dt->setTimezone(new DateTimeZone('Europe/Prague'));
                        $lastSyncStr = $dt->format('d.m.Y H:i:s');
                    } catch (\Throwable $e) {
                        $lastSyncStr = date('d.m.Y H:i:s', $lastSync);
                    }
                }
            }
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'statekstranovice.cz';

            return [
                'status' => 'success',
                'last_sync' => $lastSyncStr,
                'last_sync_timestamp' => $lastSync,
                'rooms' => is_array($rooms) ? $rooms : [],
                'rooms_count' => is_array($rooms) ? count($rooms) : 0,
                'total_days' => $totalDays,
                'cron_url' => $scheme . '://' . $host . '/plugins/booking-sync/cron.php',
                'cron_cli' => 'php ' . realpath(__DIR__ . '/cron.php')
            ];
        }

        public static function handleAjax($action) {
            switch ($action) {
                case 'booking_sync_get_info':
                    return self::getStatusInfo();

                case 'booking_sync_trigger':
                    $start = microtime(true);
                    $success = self::sync();
                    $duration = round(microtime(true) - $start, 2);
                    $info = self::getStatusInfo();
                    $info['message'] = $success 
                        ? "Synchronizace dokončena ({$duration}s). Obsazených termínů: {$info['total_days']}."
                        : "Chyba při synchronizaci kalendářů.";
                    $info['sync_status'] = $success ? 'success' : 'error';
                    return $info;

                case 'booking_sync_save_rooms':
                    $raw = file_get_contents('php://input');
                    $data = json_decode($raw, true);
                    if (isset($data['rooms']) && is_array($data['rooms'])) {
                        @file_put_contents(self::getRoomsConfigPath(), json_encode($data['rooms'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                        self::sync();
                        return ['status' => 'success', 'message' => 'Nastavení apartmánů bylo uloženo a synchronizováno.'];
                    }
                    return ['status' => 'error', 'message' => 'Neplatná data.'];
            }
            return null;
        }
    }

    if (!class_exists('SyncBooking')) {
        class_alias('SyncBookingPlugin', 'SyncBooking');
    }
}

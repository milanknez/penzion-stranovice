<?php
/*
Plugin Name: Synchronizace Obsazenosti (Booking & MegaUbytko)
Version: 1.0.0
Description: Automatická synchronizace kalendářů obsazenosti s Booking.com a MegaUbytko.cz.
Author: Statek Straňovice
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
            }

            $json = json_encode($occupancy, JSON_PRETTY_PRINT);
            @file_put_contents($outputPath, $json);
            return true;
        }

        private static function fetchUrl($url) {
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                $result = curl_exec($ch);
                curl_close($ch);
                if ($result !== false && !empty($result)) {
                    return $result;
                }
            }
            $context = stream_context_create(['http' => ['timeout' => 3]]);
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
    }

    if (!class_exists('SyncBooking')) {
        class_alias('SyncBookingPlugin', 'SyncBooking');
    }
}

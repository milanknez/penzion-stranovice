<?php

class SyncBooking {
    private static $configPath = __DIR__ . '/../config/rooms.json';
    private static $outputPath = __DIR__ . '/../config/occupancy.json';

    public static function sync() {
        if (!file_exists(self::$configPath)) return false;
        
        $rooms = json_decode(file_get_contents(self::$configPath), true);
        $occupancy = [];

        foreach ($rooms as $id => $room) {
            if (empty($room['ical_url'])) {
                $occupancy[$id] = [];
                continue;
            }

            $icalContent = @file_get_contents($room['ical_url']);
            if ($icalContent) {
                $occupancy[$id] = self::parseIcal($icalContent);
            } else {
                $occupancy[$id] = [];
            }
        }

        file_put_contents(self::$outputPath, json_encode($occupancy));
        return true;
    }

    private static function parseIcal($content) {
        $dates = [];
        // Regex to find events
        preg_match_all('/BEGIN:VEVENT.*?END:VEVENT/s', $content, $events);

        foreach ($events[0] as $event) {
            preg_match('/DTSTART;?(?:VALUE=DATE)?:(\d{8})/', $event, $startMatch);
            preg_match('/DTEND;?(?:VALUE=DATE)?:(\d{8})/', $event, $endMatch);

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
        return array_unique($dates);
    }

    public static function getOccupancy() {
        if (!file_exists(self::$outputPath)) {
            self::sync();
        }
        return json_decode(file_get_contents(self::$outputPath), true);
    }

    public static function shouldSync() {
        if (!file_exists(self::$outputPath)) return true;
        
        // Sync every 30 minutes
        return (time() - filemtime(self::$outputPath)) > 1800;
    }
}

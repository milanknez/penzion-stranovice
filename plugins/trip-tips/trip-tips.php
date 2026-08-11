<?php
/*
Plugin Name: Tipy na Výlety a Interaktivní Mapy
Version: 1.0.0
Description: Správa výletních cílů, doporučených tras, kategorií a interaktivních map OpenStreetMap / Mapy.cz přímo z Fida CMS.
Author: Statek Straňovice
Settings Modal: openTripTipsModal()
Settings Button: Správa Výletů a Map
*/

if (!class_exists('TripTipsPlugin')) {
    class TripTipsPlugin {
        private static string $configFile = __DIR__ . '/data/config.json';
        private static string $tripsFile = __DIR__ . '/data/trips.json';

        public static function getConfig(): array {
            if (file_exists(self::$configFile)) {
                $json = @json_decode(@file_get_contents(self::$configFile), true);
                if (is_array($json)) return $json;
            }
            return [
                'pension_name' => 'Penzion a Statek Straňovice',
                'pension_address' => 'Straňovice 1, 387 01 Malenice',
                'start_coords' => [49.12386, 13.89667],
                'default_zoom' => 11
            ];
        }

        public static function saveConfig(array $data): bool {
            $dir = dirname(self::$configFile);
            if (!is_dir($dir)) @mkdir($dir, 0777, true);
            @chmod($dir, 0777);
            if (file_exists(self::$configFile)) @chmod(self::$configFile, 0666);
            $res = @file_put_contents(self::$configFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            if ($res === false) {
                @chmod(self::$configFile, 0777);
                @unlink(self::$configFile);
                $res = @file_put_contents(self::$configFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
            return $res !== false;
        }

        public static function getTrips(bool $onlyActive = false): array {
            if (file_exists(self::$tripsFile)) {
                $json = @json_decode(@file_get_contents(self::$tripsFile), true);
                if (is_array($json)) {
                    if ($onlyActive) {
                        return array_values(array_filter($json, fn($item) => !isset($item['active']) || $item['active'] === true));
                    }
                    return $json;
                }
            }
            return [];
        }

        public static function saveTrips(array $trips): bool {
            $dir = dirname(self::$tripsFile);
            if (!is_dir($dir)) @mkdir($dir, 0777, true);
            @chmod($dir, 0777);
            if (file_exists(self::$tripsFile)) @chmod(self::$tripsFile, 0666);
            $res = @file_put_contents(self::$tripsFile, json_encode($trips, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            if ($res === false) {
                @chmod(self::$tripsFile, 0777);
                @unlink(self::$tripsFile);
                $res = @file_put_contents(self::$tripsFile, json_encode($trips, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
            return $res !== false;
        }

        public static function handleRequest($action): ?array {
            return self::handleAjax($action);
        }

        public static function handleAjax($action): ?array {
            switch ($action) {
                case 'get_trip_tips':
                    return [
                        'status' => 'success',
                        'config' => self::getConfig(),
                        'trips' => self::getTrips(false)
                    ];

                case 'save_trip_tips_config':
                    $raw = file_get_contents('php://input');
                    $data = json_decode($raw, true);
                    if ($data && is_array($data)) {
                        self::saveConfig($data);
                        return ['status' => 'success', 'message' => 'Nastavení výchozího bodu bylo úspěšně uloženo.'];
                    }
                    return ['status' => 'error', 'message' => 'Neplatná data pro nastavení.'];

                case 'save_trip_tip_item':
                    $raw = file_get_contents('php://input');
                    $item = json_decode($raw, true);
                    if (!$item || empty($item['title'])) {
                        return ['status' => 'error', 'message' => 'Zadejte prosím název výletu.'];
                    }

                    $trips = self::getTrips(false);
                    if (empty($item['id'])) {
                        $item['id'] = 'trip_' . time() . '_' . rand(100, 999);
                        $trips[] = $item;
                    } else {
                        $found = false;
                        foreach ($trips as $k => $t) {
                            if ($t['id'] === $item['id']) {
                                $merged = array_merge($t, $item);
                                // If image is empty string in new data, keep the existing image
                                if (isset($item['image']) && $item['image'] === '' && !empty($t['image'])) {
                                    $merged['image'] = $t['image'];
                                }
                                // If image is empty, remove the key entirely to avoid empty strings
                                if (isset($merged['image']) && $merged['image'] === '') {
                                    unset($merged['image']);
                                }
                                $trips[$k] = $merged;
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) $trips[] = $item;
                    }

                    $saved = self::saveTrips($trips);
                    if (!$saved) {
                        return ['status' => 'error', 'message' => 'Nepodařilo se uložit výlet – chybí oprávnění k zápisu do trips.json.'];
                    }
                    return ['status' => 'success', 'message' => 'Výlet byl úspěšně uložen.', 'trips' => $trips];

                case 'upload_trip_image':
                    if (!empty($_FILES['image_file']['tmp_name'])) {
                        $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
                        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                            return ['status' => 'error', 'message' => 'Podporovány jsou pouze obrázky (JPG, PNG, WEBP, GIF).'];
                        }

                        $filename = 'trip_' . time() . '_' . rand(100, 999) . '.' . $ext;

                        // Target 1: assets/img/
                        $assetsDir = __DIR__ . '/../../assets/img/';
                        if (!is_dir($assetsDir)) @mkdir($assetsDir, 0777, true);
                        $targetPath1 = $assetsDir . $filename;

                        $saved = @move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath1);
                        if (!$saved) {
                            $saved = @copy($_FILES['image_file']['tmp_name'], $targetPath1);
                        }
                        if ($saved) {
                            return [
                                'status' => 'success',
                                'message' => 'Obrázek byl úspěšně nahrán.',
                                'image_url' => 'assets/img/' . $filename
                            ];
                        }

                        // Target 2: plugins/trip-tips/uploads/
                        $pluginDir = __DIR__ . '/uploads/';
                        if (!is_dir($pluginDir)) @mkdir($pluginDir, 0777, true);
                        $targetPath2 = $pluginDir . $filename;

                        $saved2 = @copy($_FILES['image_file']['tmp_name'], $targetPath2);
                        if (!$saved2) {
                            $saved2 = @file_put_contents($targetPath2, @file_get_contents($_FILES['image_file']['tmp_name'])) !== false;
                        }
                        if ($saved2) {
                            return [
                                'status' => 'success',
                                'message' => 'Obrázek byl úspěšně nahrán do složky pluginu.',
                                'image_url' => 'plugins/trip-tips/uploads/' . $filename
                            ];
                        }

                        // Target 3: Data URL (Base64) fallback when web server user lacks filesystem write permissions
                        $rawContent = @file_get_contents($_FILES['image_file']['tmp_name']);
                        if ($rawContent) {
                            $mime = ($ext === 'jpg' || $ext === 'jpeg') ? 'image/jpeg' : ('image/' . $ext);
                            $dataUrl = 'data:' . $mime . ';base64,' . base64_encode($rawContent);
                            return [
                                'status' => 'success',
                                'message' => 'Obrázek byl úspěšně zpracován.',
                                'image_url' => $dataUrl
                            ];
                        }

                        $err = error_get_last();
                        return ['status' => 'error', 'message' => 'Chyba při ukládání souboru: ' . ($err['message'] ?? 'Permission denied')];
                    }
                    return ['status' => 'error', 'message' => 'Nebyl nahrán žádný obrázek.'];
            }

            return null;
        }
    }
}

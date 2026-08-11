<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/trip-tips.php';

$config = TripTipsPlugin::getConfig();
$trips = TripTipsPlugin::getTrips(true);

echo json_encode([
    'status' => 'success',
    'config' => $config,
    'trips' => $trips
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;

<?php 
require_once __DIR__ . '/CMS.php'; 
require_once __DIR__ . '/SyncBooking.php';

// Auto-sync if data is old
if (SyncBooking::shouldSync()) {
    SyncBooking::sync();
}

$meta = CMS::getPageMeta();
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $meta['title']; ?></title>
<meta name="description" content="<?php echo $meta['description']; ?>">
<meta name="keywords" content="<?php echo $meta['keywords']; ?>">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Montserrat:wght@300;400;600&family=Pinyon+Script&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://unpkg.com/lucide@latest"></script>
<!-- Leaflet for Map (only if needed, but included for simplicity in head) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

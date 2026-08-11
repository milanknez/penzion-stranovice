<?php
$content = file_get_contents('/home/milan/Projects/fida-cms/admin/index.php');
if ($content) {
    file_put_contents(__DIR__ . '/index.php', $content);
    echo "SYNC_SUCCESS:" . strlen($content);
} else {
    echo "SYNC_FAILED";
}

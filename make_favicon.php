<?php
$source = 'assets/img/logo_final.png';
$dest = 'favicon.ico';

if (!file_exists($source)) {
    die("Chyba: Zdrojové logo nebylo nalezeno v $source\n");
}

$img = imagecreatefrompng($source);
if (!$img) {
    die("Chyba: Nepodařilo se načíst PNG logo.\n");
}

$size = 32;
$favicon = imagecreatetruecolor($size, $size);

// Zachování průhlednosti
imagealphablending($favicon, false);
imagesavealpha($favicon, true);
$transparent = imagecolorallocatealpha($favicon, 255, 255, 255, 127);
imagefilledrectangle($favicon, 0, 0, $size, $size, $transparent);

// Změna velikosti
$origW = imagesx($img);
$origH = imagesy($img);
imagecopyresampled($favicon, $img, 0, 0, 0, 0, $size, $size, $origW, $origH);

// Uložení jako PNG, ale s příponou .ico (prohlížeče to takto berou nejlépe)
if (imagepng($favicon, $dest)) {
    echo "OK: Favicon byla úspěšně vytvořena jako $dest\n";
} else {
    echo "Chyba při ukládání souboru.\n";
}

imagedestroy($img);
imagedestroy($favicon);




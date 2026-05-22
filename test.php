<?php 
require_once 'includes/CMS.php';
$meta = CMS::getPageMeta();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <section class="section-padding">
            <div class="container">
                <h1>Nová stránka: test</h1>
                <p>Zde začněte tvořit svůj obsah...</p>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script>if (typeof lucide !== 'undefined') lucide.createIcons();</script>
</body>
</html>
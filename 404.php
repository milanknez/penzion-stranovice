<?php 
require_once 'includes/CMS.php';
$meta = CMS::getPageMeta();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <?php include 'includes/head.php'; ?>
    <style>* { box-sizing: border-box; } body {margin: 0;}</style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <body><!--?php include 'includes/header.php'; ?--><main><section class="section-padding"><div class="container text-center"><div class="mb-8"><h1 class="text-6xl font-serif text-[var(--primary)] mb-4">404</h1><h2 class="section-title">Stránka nenalezena</h2></div><p class="text-xl mb-10 opacity-80">
                    Jejda, tady nic není 👀<br/>
                    Stránka mohla být přesunuta nebo smazána.
                </p><div class="flex justify-center gap-4"><a href="index.php" class="btn btn-primary">Zpět na úvod</a></div></div></section></main><!--?php include 'includes/footer.php'; ?--></body>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script>if (typeof lucide !== 'undefined') lucide.createIcons();</script>
</body>
</html>
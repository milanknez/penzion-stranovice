<?php 
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();
?>
    <main>
        <section class="section-padding">
            <div class="container text-center">
                <div class="mb-8">
                    <h1 class="text-6xl font-serif text-[var(--primary)] mb-4" style="font-size: 5rem; color: var(--primary);">404</h1>
                    <h2 class="section-title">Stránka nenalezena</h2>
                </div>
                <p class="text-xl mb-10 opacity-80" style="margin: 2rem 0; font-size: 1.2rem;">
                    Jejda, tady nic není 👀<br/>
                    Stránka mohla být přesunuta nebo smazána.<br/>
                    Zkuste se vrátit zpět nebo přejít na úvod.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="<?= CMS::url('index.php') ?>" class="btn btn-primary px-8">ZPĚT NA ÚVOD</a>
                </div>
            </div>
        </section>
    </main>

<?php CMS::getFooter(); ?>
<?php
$siteConfig = CMS::getSiteConfig();
$siteName = $siteConfig['site_name'] ?? 'Můj Nový Web';
$email = $siteConfig['email'] ?? 'info@mujweb.cz';
$phone = $siteConfig['phone_nonstop'] ?? '+420 123 456 789';
?>
    </main>
    <!-- Footer -->
    <footer class="bg-[#080c16] border-t border-slate-800 text-slate-400 py-12 px-6 mt-16">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
                        <i class="fa fa-flash"></i>
                    </div>
                    <span class="text-white font-extrabold text-base tracking-tight"><?= htmlspecialchars($siteName) ?></span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed mb-4">
                    Moderní prezentace vytvořená na redakčním systému Fida CMS. Snadná úprava obsahu a bleskové načítání stránek.
                </p>
            </div>

            <div>
                <h4 class="text-indigo-400 font-bold text-xs uppercase tracking-wider mb-4">Navigace</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="index.php" class="hover:text-indigo-300 transition-colors">Domů</a></li>
                    <li><a href="admin/" class="hover:text-indigo-300 transition-colors">Administrace</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-indigo-400 font-bold text-xs uppercase tracking-wider mb-4">Kontakt</h4>
                <div class="space-y-3 text-sm">
                    <?php if (!empty($phone)): ?>
                    <p class="font-bold text-indigo-400"><i class="fa fa-phone mr-2"></i> <?= htmlspecialchars($phone) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($email)): ?>
                    <p class="text-xs text-slate-400"><i class="fa fa-envelope text-slate-500 mr-2"></i> <?= htmlspecialchars($email) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto border-t border-slate-800/80 pt-6 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($siteName) ?>. Všechna práva vyhrazena.</p>
            <p class="text-slate-600">Poháněno systémem <a href="admin/" class="text-indigo-400 hover:underline">Fida CMS</a></p>
        </div>
    </footer>
</body>
</html>

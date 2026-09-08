<!-- Maintenance Mode Modal (Plugin: maintenance-mode) -->
<div id="maintenance-modal" onclick="if (event.target === this) closeMaintenanceModal();" class="hidden fixed inset-0 bg-black/75 z-[110] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-slate-900 w-full max-w-3xl rounded-2xl shadow-2xl border border-white/10 overflow-hidden text-slate-200 flex flex-col max-h-[92vh]">
        <!-- Modal Header -->
        <div class="p-6 border-b border-white/10 flex justify-between items-center bg-slate-950">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-lg border border-amber-500/30">
                    <i class="fa fa-wrench"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-white font-extrabold text-base tracking-tight">Režim údržby (Maintenance Mode)</h2>
                        <span id="mm-status-pill" class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border">Načítám...</span>
                    </div>
                    <p class="text-xs text-slate-400">Dočasné uzavření webu pro veřejnost s elegantní informační stránkou a odpočtem.</p>
                </div>
            </div>
            <button onclick="closeMaintenanceModal()" class="text-slate-400 hover:text-white p-2 rounded-lg hover:bg-white/5 transition-colors">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Quick Status Banner -->
        <div id="mm-quick-banner" class="px-6 py-3 bg-slate-950/60 border-b border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-2.5 text-xs">
                <span class="text-slate-400">Rychlé ovládání:</span>
                <span id="mm-banner-text" class="font-bold text-white">Režim údržby je vypnutý</span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="toggleMaintenanceQuick()" id="btn-mm-quick-toggle" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                    <i class="fa fa-power-off"></i> <span>Přepnout</span>
                </button>
                <a href="/?preview_maintenance=1" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-800 hover:bg-slate-700 text-indigo-300 hover:text-white transition-all flex items-center gap-1.5 border border-indigo-500/20">
                    <i class="fa fa-external-link"></i> Náhled stránky
                </a>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex border-b border-white/10 bg-slate-950/30 px-6 gap-2 text-xs font-bold">
            <button type="button" onclick="switchMmTab('general')" id="mm-tab-btn-general" class="py-3 px-3 border-b-2 border-indigo-500 text-white flex items-center gap-2 transition-colors">
                <i class="fa fa-sliders text-indigo-400"></i> Základní a texty
            </button>
            <button type="button" onclick="switchMmTab('schedule')" id="mm-tab-btn-schedule" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors">
                <i class="fa fa-clock-o text-indigo-400"></i> Plánovač a odpočet
            </button>
            <button type="button" onclick="switchMmTab('access')" id="mm-tab-btn-access" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors">
                <i class="fa fa-shield text-indigo-400"></i> Výjimky a přístup
            </button>
            <button type="button" onclick="switchMmTab('contact')" id="mm-tab-btn-contact" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors">
                <i class="fa fa-phone text-indigo-400"></i> Kontakty na stránce
            </button>
        </div>

        <!-- Modal Body Content -->
        <div class="p-6 overflow-y-auto space-y-5 flex-1 text-xs">
            <!-- TAB 1: General Settings -->
            <div id="mm-tab-general" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase">
                            <i class="fa fa-power-off text-indigo-400"></i> Stav režimu údržby
                        </label>
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="mm-is-enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                            </label>
                            <span id="mm-is-enabled-label" class="text-xs font-semibold text-slate-300">Vypnuto</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Pokud je zapnuto, všichni běžní návštěvníci uvidí stránku údržby.</p>
                    </div>

                    <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase">
                            <i class="fa fa-exchange text-indigo-400"></i> HTTP Status Kód
                        </label>
                        <select id="mm-http-status" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                            <option value="503">503 Service Unavailable (Doporučeno pro SEO / vyhledávače)</option>
                            <option value="200">200 OK (Běžná úspěšná odpověď)</option>
                        </select>
                        <p class="text-[11px] text-slate-400">Kód 503 informuje vyhledávače Google a Seznam, že jde o dočasnou údržbu a nemají stránky mazat z indexu.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Štítek / Odznak na stránce</label>
                        <input type="text" id="mm-badge-text" placeholder="např. Plánovaná technická údržba" class="w-full bg-slate-950 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Titulek okna prohlížeče (&lt;title&gt;)</label>
                        <input type="text" id="mm-page-title" placeholder="např. Statek Straňovice – Plánovaná údržba" class="w-full bg-slate-950 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1">Hlavní nadpis (H1)</label>
                    <input type="text" id="mm-heading" placeholder="Vylepšujeme pro vás Statek Straňovice" class="w-full bg-slate-950 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500 text-sm font-semibold">
                </div>

                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1">Text zprávy pro návštěvníky</label>
                    <textarea id="mm-description" rows="3" placeholder="Popište důvod odstávky a ujistěte hosty..." class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 leading-relaxed"></textarea>
                </div>
            </div>

            <!-- TAB 2: Plánovač a odpočet -->
            <div id="mm-tab-schedule" class="hidden space-y-4">
                <div class="bg-indigo-950/30 border border-indigo-500/20 rounded-xl p-4 text-xs space-y-2">
                    <h4 class="font-bold text-indigo-300 flex items-center gap-1.5">
                        <i class="fa fa-info-circle"></i> Živý odpočet a automatické ukončení
                    </h4>
                    <p class="text-slate-300 leading-relaxed">
                        Můžete nastavit předpokládaný termín dokončení. Na stránce údržby se zobrazí atraktivní odpočítávací hodiny (dny, hodiny, minuty, sekundy).
                    </p>
                </div>

                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white block">Zobrazit odpočet na stránce</span>
                            <span class="text-[11px] text-slate-400">Vykreslí animované karty s odpočítáváním.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="mm-show-countdown" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1">Cílové datum a čas ukončení</label>
                        <input type="datetime-local" id="mm-target-datetime" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500 font-mono">
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-white/5">
                        <div>
                            <span class="font-bold text-white block">Automaticky vypnout údržbu po vypršení</span>
                            <span class="text-[11px] text-slate-400">Jakmile nastane zadaný čas, web se pro návštěvníky automaticky zpřístupní.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="mm-auto-disable" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Výjimky a přístup -->
            <div id="mm-tab-access" class="hidden space-y-4">
                <!-- Admin Bypass Notice -->
                <div class="bg-emerald-950/30 border border-emerald-500/20 rounded-xl p-4 flex items-start gap-3">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 font-bold mt-0.5">
                        <i class="fa fa-user-secret"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-emerald-300 mb-0.5">Administrátoři mají vždy plný přístup</h4>
                        <p class="text-[11px] text-slate-300 leading-relaxed">
                            Jste-li přihlášeni v této administraci, uvidíte běžný web bez omezení. Na veřejném webu se vám navíc zobrazí horní informační lišta s rychlým tlačítkem pro vypnutí údržby.
                        </p>
                    </div>
                </div>

                <!-- Secret Bypass URL -->
                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-slate-300 uppercase flex items-center gap-1.5">
                            <i class="fa fa-key text-indigo-400"></i> Tajný odkaz pro náhled (Bypass odkaz)
                        </label>
                        <button type="button" onclick="generateMmBypassToken()" class="text-[11px] text-indigo-400 hover:text-indigo-300 font-bold flex items-center gap-1">
                            <i class="fa fa-refresh"></i> Vygenerovat nový token
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-400">Tento odkaz můžete poslat klientovi nebo externímu testerovi. Po otevření se nastaví dočasné cookie na 7 dní a dotyčný uvidí web i během údržby.</p>
                    
                    <div class="flex items-center gap-2">
                        <input type="text" id="mm-bypass-url" readonly class="w-full bg-slate-900 border border-white/10 rounded-xl px-3 py-2 text-xs font-mono text-indigo-300 select-all">
                        <button type="button" onclick="copyMmBypassUrl()" class="bg-slate-800 hover:bg-slate-700 text-white px-3 py-2 rounded-xl text-xs font-bold transition-colors shrink-0 flex items-center gap-1.5">
                            <i class="fa fa-copy"></i> Kopírovat
                        </button>
                    </div>
                    <input type="hidden" id="mm-bypass-token">
                </div>

                <!-- IP Whitelist -->
                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="font-bold text-slate-300 uppercase flex items-center gap-1.5">
                                <i class="fa fa-list text-indigo-400"></i> Seznam povolených IP adres (Whitelist)
                            </label>
                            <span class="text-[11px] text-slate-400">Zadejte jednu IP adresu na řádek.</span>
                        </div>
                        <button type="button" onclick="addMyIpToWhitelist()" class="bg-indigo-600/20 hover:bg-indigo-600 border border-indigo-500/40 text-indigo-300 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
                            <i class="fa fa-plus-circle"></i> Přidat moji IP (<span id="mm-detected-ip">...</span>)
                        </button>
                    </div>
                    <textarea id="mm-whitelist-ips" rows="3" placeholder="např. 192.168.1.1&#10;89.102.15.42" class="w-full bg-slate-900 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono text-xs"></textarea>
                </div>
            </div>

            <!-- TAB 4: Contacts on page -->
            <div id="mm-tab-contact" class="hidden space-y-4">
                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-white flex items-center gap-2">
                            <i class="fa fa-phone text-indigo-400"></i> Telefonní kontakt pro rezervace
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="mm-show-phone" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <input type="text" id="mm-phone" placeholder="+420 737 887 985" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                </div>

                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-white flex items-center gap-2">
                            <i class="fa fa-envelope-o text-indigo-400"></i> Kontaktní E-mail
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="mm-show-email" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <input type="email" id="mm-email" placeholder="info@statekstranovice.cz" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                </div>

                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="font-bold text-white flex items-center gap-2">
                            <i class="fa fa-map-marker text-indigo-400"></i> Adresa penzionu
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="mm-show-address" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    <input type="text" id="mm-address" placeholder="Straňovice 1, 387 01 Malenice" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-4 bg-slate-950 border-t border-white/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="/?preview_maintenance=1" target="_blank" class="bg-slate-800 hover:bg-slate-700 text-indigo-300 hover:text-white font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition-all">
                    <i class="fa fa-eye"></i> Náhled stránky
                </a>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="closeMaintenanceModal()" class="px-4 py-2 text-slate-400 hover:text-white font-bold text-xs uppercase transition-colors">
                    Zavřít
                </button>
                <button type="button" onclick="saveMaintenanceConfig()" id="btn-mm-save" class="bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold px-5 py-2 rounded-xl text-xs uppercase shadow-lg shadow-indigo-600/20 flex items-center gap-1.5 transition-all">
                    <i class="fa fa-check"></i> Uložit nastavení
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let mmCurrentConfig = {};
    let mmClientIp = '';

    function openMaintenanceModal() {
        const modal = document.getElementById('maintenance-modal');
        if (!modal) return;
        modal.classList.remove('hidden');
        switchMmTab('general');
        loadMaintenanceConfig();
    }

    function closeMaintenanceModal() {
        document.getElementById('maintenance-modal')?.classList.add('hidden');
    }

    function switchMmTab(tabId) {
        ['general', 'schedule', 'access', 'contact'].forEach(t => {
            const btn = document.getElementById('mm-tab-btn-' + t);
            const content = document.getElementById('mm-tab-' + t);
            if (btn && content) {
                if (t === tabId) {
                    btn.className = "py-3 px-3 border-b-2 border-indigo-500 text-white flex items-center gap-2 transition-colors";
                    content.classList.remove('hidden');
                } else {
                    btn.className = "py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors";
                    content.classList.add('hidden');
                }
            }
        });
    }

    function updateMaintenanceStatusUI(isEnabled) {
        const pill = document.getElementById('mm-status-pill');
        const bannerText = document.getElementById('mm-banner-text');
        const quickBtn = document.getElementById('btn-mm-quick-toggle');
        const toggleCheck = document.getElementById('mm-is-enabled');
        const toggleLabel = document.getElementById('mm-is-enabled-label');

        if (toggleCheck) toggleCheck.checked = !!isEnabled;
        if (toggleLabel) toggleLabel.innerText = isEnabled ? 'Zapnuto' : 'Vypnuto';

        if (isEnabled) {
            if (pill) {
                pill.className = "text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider bg-amber-500/20 text-amber-300 border border-amber-500/40 animate-pulse";
                pill.innerHTML = '<i class="fa fa-circle text-[8px] mr-1"></i> AKTIVNÍ (BLOKOVÁNO)';
            }
            if (bannerText) {
                bannerText.innerHTML = '<span class="text-amber-400 font-bold">Režim údržby je AKTIVNÍ</span> – veřejnost vidí odstávkovou stránku.';
            }
            if (quickBtn) {
                quickBtn.className = "px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-all flex items-center gap-1.5 border border-white/10";
                quickBtn.innerHTML = '<i class="fa fa-power-off text-amber-400"></i> Vypnout údržbu';
            }
        } else {
            if (pill) {
                pill.className = "text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20";
                pill.innerHTML = '<i class="fa fa-check text-[8px] mr-1"></i> NEAKTIVNÍ (WEB JE DOSTUPNÝ)';
            }
            if (bannerText) {
                bannerText.innerHTML = '<span class="text-emerald-400 font-bold">Režim údržby je VYPNUTÝ</span> – web funguje normálně.';
            }
            if (quickBtn) {
                quickBtn.className = "px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-600 hover:bg-amber-500 text-white transition-all flex items-center gap-1.5 shadow-md shadow-amber-600/20";
                quickBtn.innerHTML = '<i class="fa fa-power-off"></i> Zapnout údržbu';
            }
        }
    }

    function loadMaintenanceConfig() {
        fetch('plugins.php?action=get_maintenance_config&_t=' + Date.now())
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    const cfg = data.config || {};
                    mmCurrentConfig = cfg;
                    mmClientIp = data.client_ip || '';

                    updateMaintenanceStatusUI(cfg.is_enabled);

                    // Form bindings
                    const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val !== undefined ? val : ''; };
                    const setCheck = (id, val) => { const el = document.getElementById(id); if (el) el.checked = !!val; };

                    setVal('mm-http-status', cfg.http_status || 503);
                    setVal('mm-badge-text', cfg.badge_text || 'Plánovaná technická údržba');
                    setVal('mm-page-title', cfg.page_title || 'Statek Straňovice – Plánovaná údržba webu');
                    setVal('mm-heading', cfg.heading || 'Vylepšujeme pro vás Statek Straňovice');
                    setVal('mm-description', cfg.description || '');

                    setCheck('mm-show-countdown', cfg.show_countdown);
                    setVal('mm-target-datetime', cfg.target_datetime || '');
                    setCheck('mm-auto-disable', cfg.auto_disable);

                    // Whitelist IPs
                    const ips = Array.isArray(cfg.whitelist_ips) ? cfg.whitelist_ips.join('\n') : '';
                    setVal('mm-whitelist-ips', ips);

                    // Detected IP
                    const ipEl = document.getElementById('mm-detected-ip');
                    if (ipEl) ipEl.innerText = mmClientIp || 'Neznámá';

                    // Bypass token a URL
                    setVal('mm-bypass-token', cfg.bypass_token || '');
                    updateBypassUrlDisplay(cfg.bypass_token);

                    // Contacts
                    setCheck('mm-show-phone', cfg.show_phone);
                    setVal('mm-phone', cfg.phone || '');
                    setCheck('mm-show-email', cfg.show_email);
                    setVal('mm-email', cfg.email || '');
                    setCheck('mm-show-address', cfg.show_address);
                    setVal('mm-address', cfg.address || '');

                } else {
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Chyba při načítání konfigurace', 'error');
                    }
                }
            })
            .catch(err => {
                console.error(err);
            });
    }

    function updateBypassUrlDisplay(token) {
        const urlInput = document.getElementById('mm-bypass-url');
        if (!urlInput) return;
        const origin = window.location.origin;
        if (token) {
            urlInput.value = origin + '/?bypass_maintenance=' + encodeURIComponent(token);
        } else {
            urlInput.value = origin;
        }
    }

    function generateMmBypassToken() {
        fetch('plugins.php?action=generate_bypass_token&_t=' + Date.now())
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success' && data.token) {
                    document.getElementById('mm-bypass-token').value = data.token;
                    updateBypassUrlDisplay(data.token);
                    if (typeof showToast === 'function') {
                        showToast('Byl vygenerován nový tajný klíč.', 'info');
                    }
                }
            });
    }

    function copyMmBypassUrl() {
        const input = document.getElementById('mm-bypass-url');
        if (!input || !input.value) return;
        navigator.clipboard.writeText(input.value).then(() => {
            if (typeof showToast === 'function') {
                showToast('Tajný odkaz byl zkopírován do schránky!', 'success');
            } else {
                alert('Odkaz byl zkopírován do schránky.');
            }
        });
    }

    function addMyIpToWhitelist() {
        if (!mmClientIp) return;
        const textarea = document.getElementById('mm-whitelist-ips');
        if (!textarea) return;
        const currentLines = textarea.value.split('\n').map(l => l.trim()).filter(l => l.length > 0);
        if (!currentLines.includes(mmClientIp)) {
            currentLines.push(mmClientIp);
            textarea.value = currentLines.join('\n');
            if (typeof showToast === 'function') {
                showToast('Vaše IP adresa ' + mmClientIp + ' byla přidána do seznamu.', 'success');
            }
        } else {
            if (typeof showToast === 'function') {
                showToast('Vaše IP adresa ' + mmClientIp + ' již v seznamu je.', 'info');
            }
        }
    }

    function toggleMaintenanceQuick() {
        const newState = !mmCurrentConfig.is_enabled;
        fetch('plugins.php?action=toggle_maintenance_mode', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ is_enabled: newState })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                mmCurrentConfig.is_enabled = newState;
                updateMaintenanceStatusUI(newState);
                if (typeof showToast === 'function') {
                    showToast(data.message || (newState ? 'Režim údržby byl zapnut.' : 'Režim údržby byl vypnut.'), newState ? 'warning' : 'success');
                }
            } else {
                alert(data.message || 'Nepodařilo se změnit stav.');
            }
        });
    }

    // Toggle checkbox change listener
    document.getElementById('mm-is-enabled')?.addEventListener('change', function(e) {
        document.getElementById('mm-is-enabled-label').innerText = e.target.checked ? 'Zapnuto' : 'Vypnuto';
    });

    function saveMaintenanceConfig() {
        const getVal = (id) => { const el = document.getElementById(id); return el ? el.value.trim() : ''; };
        const getCheck = (id) => { const el = document.getElementById(id); return el ? el.checked : false; };

        const ipsRaw = getVal('mm-whitelist-ips');
        const whitelistIps = ipsRaw.split('\n').map(l => l.trim()).filter(l => l.length > 0);

        const data = {
            is_enabled: getCheck('mm-is-enabled'),
            http_status: parseInt(getVal('mm-http-status'), 10) || 503,
            badge_text: getVal('mm-badge-text'),
            page_title: getVal('mm-page-title'),
            heading: getVal('mm-heading'),
            description: document.getElementById('mm-description')?.value || '',
            show_countdown: getCheck('mm-show-countdown'),
            target_datetime: getVal('mm-target-datetime'),
            auto_disable: getCheck('mm-auto-disable'),
            whitelist_ips: whitelistIps,
            bypass_token: getVal('mm-bypass-token') || 'stranovice_preview',
            show_phone: getCheck('mm-show-phone'),
            phone: getVal('mm-phone'),
            show_email: getCheck('mm-show-email'),
            email: getVal('mm-email'),
            show_address: getCheck('mm-show-address'),
            address: getVal('mm-address')
        };

        const btn = document.getElementById('btn-mm-save');
        const oldHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> UKLÁDÁM...';
        btn.disabled = true;

        fetch('plugins.php?action=save_maintenance_config', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            btn.innerHTML = oldHtml;
            btn.disabled = false;
            if (res.status === 'success') {
                mmCurrentConfig = data;
                updateMaintenanceStatusUI(data.is_enabled);
                if (typeof showToast === 'function') {
                    showToast(res.message || 'Nastavení údržby bylo úspěšně uloženo.', 'success');
                } else {
                    alert(res.message);
                }
            } else {
                alert(res.message || 'Chyba při ukládání.');
            }
        })
        .catch(err => {
            btn.innerHTML = oldHtml;
            btn.disabled = false;
            console.error(err);
            alert('Nastala chyba při komunikaci se serverem.');
        });
    }
</script>

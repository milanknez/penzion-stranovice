<!-- Spam Filter Modal (Plugin: spam-filter) -->
<div id="spam-filter-modal" onclick="if (event.target === this) closeSpamFilterModal();" class="hidden fixed inset-0 bg-black/75 z-[110] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-slate-900 w-full max-w-4xl rounded-2xl shadow-2xl border border-white/10 overflow-hidden text-slate-200 flex flex-col max-h-[92vh]">
        
        <!-- Modal Header -->
        <div class="p-6 border-b border-white/10 flex justify-between items-center bg-slate-950">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-lg border border-amber-500/30 shadow-inner">
                    <i class="fa fa-shield"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-white font-extrabold text-base tracking-tight">Spam filter</h2>
                        <span id="sf-status-pill" class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border">Načítám...</span>
                    </div>
                    <p class="text-xs text-slate-400">Automatická ochrana kontaktních a rezervačních formulářů proti spamu a robotům.</p>
                </div>
            </div>
            <button type="button" onclick="closeSpamFilterModal()" class="text-slate-400 hover:text-white p-2 rounded-lg hover:bg-white/5 transition-colors">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Quick Summary Bar -->
        <div class="px-6 py-3 bg-slate-950/70 border-b border-white/5 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-6 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400/50"></span>
                    <span class="text-slate-400">Prověřeno:</span>
                    <strong id="sf-stat-passed" class="text-white font-mono">0</strong>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></span>
                    <span class="text-slate-400">Zablokovaný spam:</span>
                    <strong id="sf-stat-blocked" class="text-rose-400 font-mono">0</strong>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-500">Aktivní režim:</span>
                    <span id="sf-active-mode-badge" class="px-2 py-0.5 rounded bg-indigo-500/20 text-indigo-300 font-semibold text-[11px] border border-indigo-500/30">Interní ověření</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="resetSpamStats()" class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-all border border-white/10">
                    <i class="fa fa-refresh"></i> Vynulovat statistiky
                </button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex border-b border-white/10 bg-slate-950/40 px-6 gap-2 text-xs font-bold overflow-x-auto">
            <button type="button" onclick="switchSfTab('overview')" id="sf-tab-btn-overview" class="py-3 px-3 border-b-2 border-indigo-500 text-white flex items-center gap-2 transition-colors whitespace-nowrap">
                <i class="fa fa-dashboard text-indigo-400"></i> Přehled a stav
            </button>
            <button type="button" onclick="switchSfTab('modes')" id="sf-tab-btn-modes" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors whitespace-nowrap">
                <i class="fa fa-check-square-o text-indigo-400"></i> Typ Captchy a ověření
            </button>
            <button type="button" onclick="switchSfTab('rules')" id="sf-tab-btn-rules" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors whitespace-nowrap">
                <i class="fa fa-filter text-indigo-400"></i> Filtry a časové limity
            </button>
            <button type="button" onclick="switchSfTab('log')" id="sf-tab-btn-log" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors whitespace-nowrap">
                <i class="fa fa-list-alt text-indigo-400"></i> Log zachyceného spamu (<span id="sf-log-count">0</span>)
            </button>
        </div>

        <!-- Modal Body Content -->
        <div class="p-6 overflow-y-auto space-y-6 flex-1 text-xs">
            
            <!-- TAB 1: OVERVIEW -->
            <div id="sf-tab-overview" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Master Switch -->
                    <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase">
                            <i class="fa fa-power-off text-indigo-400"></i> Hlavní vypínač ochrany
                        </label>
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="sf-is-enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                            <span id="sf-is-enabled-label" class="text-xs font-semibold text-slate-300">Aktivní</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Pokud je zapnuto, plugin se automaticky vloží do každého formuláře na webu a ověřuje příchozí odeslání.</p>
                    </div>

                    <!-- Auto Injection Info -->
                    <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase">
                            <i class="fa fa-magic text-amber-400"></i> Automatická integrace
                        </label>
                        <div class="flex items-center gap-2 text-emerald-400 font-semibold">
                            <i class="fa fa-check-circle"></i> Všechny formuláře jsou chráněny
                        </div>
                        <p class="text-[11px] text-slate-400">Nemusíte do šablon vkládat žádný kód. Captcha a honeypot se automaticky vykreslují nad tlačítkem <strong>Odeslat</strong> na hlavní stránce i u všech apartmánů.</p>
                    </div>
                </div>

                <!-- Feature Highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <div class="bg-slate-950/40 border border-white/5 rounded-xl p-3.5 space-y-1">
                        <div class="font-bold text-white flex items-center gap-2">
                            <i class="fa fa-eye-slash text-indigo-400"></i> Neviditelný Honeypot
                        </div>
                        <p class="text-[11px] text-slate-400">Skrytá pole na stránce, která lidé nevidí, ale roboti je vyplní a jsou okamžitě zahozeni.</p>
                    </div>
                    <div class="bg-slate-950/40 border border-white/5 rounded-xl p-3.5 space-y-1">
                        <div class="font-bold text-white flex items-center gap-2">
                            <i class="fa fa-hourglass-start text-amber-400"></i> Časový zámek
                        </div>
                        <p class="text-[11px] text-slate-400">Blokuje odeslání formuláře roboty během zlomku vteřiny (pod nastavený limit).</p>
                    </div>
                    <div class="bg-slate-950/40 border border-white/5 rounded-xl p-3.5 space-y-1">
                        <div class="font-bold text-white flex items-center gap-2">
                            <i class="fa fa-lock text-emerald-400"></i> HMAC Podpis
                        </div>
                        <p class="text-[11px] text-slate-400">Kryptografický jednorázový token brání útokům přehráním a padělání požadavků.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 2: CAPTCHA MODES -->
            <div id="sf-tab-modes" class="hidden space-y-5">
                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-2">Zvolte metodu ověření pro návštěvníky</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        
                        <!-- Mode: Internal -->
                        <label class="relative flex p-4 rounded-xl border border-white/10 bg-slate-950/60 cursor-pointer hover:border-indigo-500/50 transition-all sf-mode-card" data-mode="internal">
                            <div class="flex items-start gap-3 w-full">
                                <input type="radio" name="sf_protection_mode" value="internal" class="mt-1 accent-indigo-500" onchange="toggleModeFields()">
                                <div class="space-y-1 flex-1">
                                    <div class="flex items-center gap-2">
                                        <strong class="text-white text-xs">Chytré interní ověření</strong>
                                        <span class="text-[9px] bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2 py-0.2 rounded font-bold uppercase">Doporučeno</span>
                                    </div>
                                    <p class="text-[11px] text-slate-400">Funguje ihned <strong>bez nutnosti registrovat jakékoliv API klíče</strong>. Přirozeně ladí s designem Statku Straňovice.</p>
                                </div>
                            </div>
                        </label>

                        <!-- Mode: Cloudflare Turnstile -->
                        <label class="relative flex p-4 rounded-xl border border-white/10 bg-slate-950/60 cursor-pointer hover:border-indigo-500/50 transition-all sf-mode-card" data-mode="turnstile">
                            <div class="flex items-start gap-3 w-full">
                                <input type="radio" name="sf_protection_mode" value="turnstile" class="mt-1 accent-indigo-500" onchange="toggleModeFields()">
                                <div class="space-y-1 flex-1">
                                    <div class="flex items-center gap-2">
                                        <strong class="text-white text-xs">Cloudflare Turnstile</strong>
                                        <span class="text-[9px] bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 px-2 py-0.2 rounded font-bold uppercase">Moderní</span>
                                    </div>
                                    <p class="text-[11px] text-slate-400">Bezplatná a rychlá alternativa od Cloudflare. Návštěvníci nemusí luštit obrázky.</p>
                                </div>
                            </div>
                        </label>

                        <!-- Mode: Google reCAPTCHA v2 -->
                        <label class="relative flex p-4 rounded-xl border border-white/10 bg-slate-950/60 cursor-pointer hover:border-indigo-500/50 transition-all sf-mode-card" data-mode="recaptcha_v2">
                            <div class="flex items-start gap-3 w-full">
                                <input type="radio" name="sf_protection_mode" value="recaptcha_v2" class="mt-1 accent-indigo-500" onchange="toggleModeFields()">
                                <div class="space-y-1 flex-1">
                                    <strong class="text-white text-xs">Google reCAPTCHA v2</strong>
                                    <p class="text-[11px] text-slate-400">Klasický zaškrtávací rámeček "Nejsem robot" od společnosti Google.</p>
                                </div>
                            </div>
                        </label>

                        <!-- Mode: Honeypot Only -->
                        <label class="relative flex p-4 rounded-xl border border-white/10 bg-slate-950/60 cursor-pointer hover:border-indigo-500/50 transition-all sf-mode-card" data-mode="honeypot_only">
                            <div class="flex items-start gap-3 w-full">
                                <input type="radio" name="sf_protection_mode" value="honeypot_only" class="mt-1 accent-indigo-500" onchange="toggleModeFields()">
                                <div class="space-y-1 flex-1">
                                    <strong class="text-white text-xs">Zcela neviditelný režim</strong>
                                    <p class="text-[11px] text-slate-400">Žádné zaškrtávátko ani otázka. Ochrana funguje čistě na pozadí pomocí pastí na roboty a časování.</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- SUB-OPTIONS: Internal Type -->
                <div id="sf-suboptions-internal" class="bg-slate-950/70 p-4 rounded-xl border border-white/10 space-y-3">
                    <label class="block font-bold text-slate-300 uppercase">Varianta interního ověření:</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="flex items-center gap-2.5 p-3 rounded-lg bg-slate-900 border border-white/5 cursor-pointer hover:border-indigo-500/40">
                            <input type="radio" name="sf_internal_type" value="checkbox" class="accent-indigo-500">
                            <div>
                                <strong class="text-white text-xs block">Zaškrtávátko "Nejsem robot"</strong>
                                <span class="text-[10px] text-slate-400">Interaktivní animovaný box</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2.5 p-3 rounded-lg bg-slate-900 border border-white/5 cursor-pointer hover:border-indigo-500/40">
                            <input type="radio" name="sf_internal_type" value="math" class="accent-indigo-500">
                            <div>
                                <strong class="text-white text-xs block">Matematický příklad</strong>
                                <span class="text-[10px] text-slate-400">Např. 4 + 5 = 9</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2.5 p-3 rounded-lg bg-slate-900 border border-white/5 cursor-pointer hover:border-indigo-500/40">
                            <input type="radio" name="sf_internal_type" value="question" class="accent-indigo-500">
                            <div>
                                <strong class="text-white text-xs block">Kontrolní otázka</strong>
                                <span class="text-[10px] text-slate-400">Vlastní otázka a odpověď</span>
                            </div>
                        </label>
                    </div>

                    <div id="sf-custom-question-fields" class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1 text-[11px]">Otázka pro návštěvníka:</label>
                            <input type="text" id="sf-custom-question" placeholder="např. Kolik nohou má kůň?" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1 text-[11px]">Správná odpověď:</label>
                            <input type="text" id="sf-custom-answer" placeholder="např. 4" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white outline-none focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- SUB-OPTIONS: Turnstile API Keys -->
                <div id="sf-suboptions-turnstile" class="bg-slate-950/70 p-4 rounded-xl border border-white/10 space-y-3 hidden">
                    <div class="flex items-center justify-between">
                        <strong class="text-white text-xs"><i class="fa fa-key text-amber-400"></i> Klíče pro Cloudflare Turnstile</strong>
                        <a href="https://dash.cloudflare.com/?to=/:account/turnstile" target="_blank" class="text-[11px] text-indigo-400 hover:text-indigo-300">Získat bezplatné klíče &rarr;</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1 text-[11px]">Site Key (Veřejný klíč):</label>
                            <input type="text" id="sf-turnstile-site-key" placeholder="0x4AAAAAA..." class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white font-mono text-xs outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1 text-[11px]">Secret Key (Tajný klíč):</label>
                            <input type="password" id="sf-turnstile-secret-key" placeholder="0x4AAAAAA..." class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white font-mono text-xs outline-none focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- SUB-OPTIONS: Google reCAPTCHA Keys -->
                <div id="sf-suboptions-recaptcha" class="bg-slate-950/70 p-4 rounded-xl border border-white/10 space-y-3 hidden">
                    <div class="flex items-center justify-between">
                        <strong class="text-white text-xs"><i class="fa fa-key text-amber-400"></i> Klíče pro Google reCAPTCHA</strong>
                        <a href="https://www.google.com/recaptcha/admin" target="_blank" class="text-[11px] text-indigo-400 hover:text-indigo-300">Konzole reCAPTCHA &rarr;</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1 text-[11px]">Site Key (Veřejný klíč):</label>
                            <input type="text" id="sf-recaptcha-site-key" placeholder="6Lc..." class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white font-mono text-xs outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1 text-[11px]">Secret Key (Tajný klíč):</label>
                            <input type="password" id="sf-recaptcha-secret-key" placeholder="6Lc..." class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white font-mono text-xs outline-none focus:border-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: RULES & FILTERS -->
            <div id="sf-tab-rules" class="hidden space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Honeypot toggle -->
                    <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase">
                            <i class="fa fa-eye-slash text-indigo-400"></i> Honeypot past na roboty
                        </label>
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="sf-honeypot-enabled" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                            <span class="text-xs text-slate-300">Aktivní skrytá pole</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Vloží do formuláře neviditelné vstupní pole, které vyplňují pouze automatizované roboty.</p>
                    </div>

                    <!-- Time trap -->
                    <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                        <label class="block text-[11px] font-bold text-slate-300 uppercase">
                            <i class="fa fa-clock-o text-indigo-400"></i> Časový limit vyplnění
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="number" id="sf-min-submit-time" min="1" max="30" value="2" class="w-20 bg-slate-900 border border-white/10 rounded-xl p-2 text-white font-mono text-center outline-none focus:border-indigo-500">
                            <span class="text-xs text-slate-300 font-semibold">sekund (minimální doba)</span>
                        </div>
                        <p class="text-[11px] text-slate-400">Člověk obvykle formulář nevyplní za 1 vteřinu. Rychlejší odeslání je označeno za spam.</p>
                    </div>
                </div>

                <!-- Disposable emails -->
                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                    <label class="block text-[11px] font-bold text-slate-300 uppercase">
                        <i class="fa fa-ban text-rose-400"></i> Blokovat anonymní / dočasné e-maily
                    </label>
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="sf-block-disposable" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                        <span class="text-xs text-slate-300">Blokovat domény typu Mailinator, GuerrillaMail, 10MinuteMail</span>
                    </div>
                </div>

                <!-- Blacklist keywords -->
                <div class="bg-slate-950/70 p-4 rounded-xl border border-white/5 space-y-2">
                    <label class="block text-[11px] font-bold text-slate-300 uppercase">
                        <i class="fa fa-list text-amber-400"></i> Zakázaná spamová slova a fráze
                    </label>
                    <p class="text-[11px] text-slate-400">Pokud zpráva obsahuje některé z těchto slov, formulář bude okamžitě zablokován. (Jedno slovo na řádek nebo oddělené čárkami):</p>
                    <textarea id="sf-blocked-words" rows="4" class="w-full bg-slate-900 border border-white/10 rounded-xl p-2.5 text-white font-mono text-xs outline-none focus:border-indigo-500" placeholder="crypto, casino, seo ranking, viagra..."></textarea>
                </div>
            </div>

            <!-- TAB 4: SPAM LOG -->
            <div id="sf-tab-log" class="hidden space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-white">Historie zablokovaného spamu</h3>
                        <p class="text-[11px] text-slate-400">Přehled podezřelých odeslání, která byla zachycena a nepředána dál.</p>
                    </div>
                    <button type="button" onclick="clearSpamLog()" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-950/40 hover:bg-rose-600 border border-rose-500/30 text-rose-300 hover:text-white transition-all flex items-center gap-1.5">
                        <i class="fa fa-trash"></i> Promazat log
                    </button>
                </div>

                <div class="overflow-x-auto bg-slate-950/60 rounded-xl border border-white/5 max-h-[360px] overflow-y-auto">
                    <table class="w-full text-left text-[11px] border-collapse">
                        <thead class="bg-slate-950 sticky top-0 border-b border-white/10 text-slate-400 uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="p-3">Čas & Datum</th>
                                <th class="p-3">IP Adresa</th>
                                <th class="p-3">Důvod zachycení</th>
                                <th class="p-3">Zadané jméno / E-mail</th>
                                <th class="p-3">Náhled textu</th>
                            </tr>
                        </thead>
                        <tbody id="sf-log-tbody" class="divide-y divide-white/5 font-mono">
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-500">Zatím žádný zachycený spam. Formuláře jsou čisté.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-4 border-t border-white/10 bg-slate-950 flex justify-between items-center">
            <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                <i class="fa fa-info-circle text-indigo-400"></i> Změny nastavení se okamžitě projeví na všech formulářích.
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="closeSpamFilterModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-300 hover:text-white hover:bg-white/5 transition-all">
                    Zavřít
                </button>
                <button type="button" onclick="saveSpamFilterConfig()" id="btn-sf-save" class="px-5 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2">
                    <i class="fa fa-save"></i> Uložit nastavení
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let sfCurrentConfig = {};

    function openSpamFilterModal() {
        const modal = document.getElementById('spam-filter-modal');
        if (!modal) return;
        modal.classList.remove('hidden');
        loadSpamFilterData();
    }

    function closeSpamFilterModal() {
        const modal = document.getElementById('spam-filter-modal');
        if (modal) modal.classList.add('hidden');
    }

    function switchSfTab(tabId) {
        ['overview', 'modes', 'rules', 'log'].forEach(t => {
            const btn = document.getElementById('sf-tab-btn-' + t);
            const content = document.getElementById('sf-tab-' + t);
            if (btn) {
                if (t === tabId) {
                    btn.classList.add('border-indigo-500', 'text-white');
                    btn.classList.remove('border-transparent', 'text-slate-400');
                } else {
                    btn.classList.remove('border-indigo-500', 'text-white');
                    btn.classList.add('border-transparent', 'text-slate-400');
                }
            }
            if (content) {
                if (t === tabId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            }
        });
    }

    function toggleModeFields() {
        const selectedMode = document.querySelector('input[name="sf_protection_mode"]:checked')?.value || 'internal';
        
        // Highlight active mode card
        document.querySelectorAll('.sf-mode-card').forEach(card => {
            if (card.dataset.mode === selectedMode) {
                card.classList.add('border-indigo-500', 'bg-indigo-950/20');
            } else {
                card.classList.remove('border-indigo-500', 'bg-indigo-950/20');
            }
        });

        // Toggle suboption sections
        const intSub = document.getElementById('sf-suboptions-internal');
        const turnSub = document.getElementById('sf-suboptions-turnstile');
        const recSub = document.getElementById('sf-suboptions-recaptcha');

        if (intSub) intSub.classList.toggle('hidden', selectedMode !== 'internal');
        if (turnSub) turnSub.classList.toggle('hidden', selectedMode !== 'turnstile');
        if (recSub) recSub.classList.toggle('hidden', selectedMode !== 'recaptcha_v2');

        const intType = document.querySelector('input[name="sf_internal_type"]:checked')?.value;
        const qFields = document.getElementById('sf-custom-question-fields');
        if (qFields) {
            qFields.classList.toggle('hidden', selectedMode !== 'internal' || intType !== 'question');
        }
    }

    document.querySelectorAll('input[name="sf_internal_type"]').forEach(r => {
        r.addEventListener('change', toggleModeFields);
    });

    async function loadSpamFilterData() {
        try {
            const res = await fetch('plugins.php?action=get_spam_filter_config');
            const data = await res.json();
            if (data.status !== 'success') return;

            sfCurrentConfig = data.config || {};
            const stats = data.stats || { passed: 0, blocked: 0 };
            const log = data.log || [];

            // Stats
            document.getElementById('sf-stat-passed').innerText = stats.passed || 0;
            document.getElementById('sf-stat-blocked').innerText = stats.blocked || 0;
            document.getElementById('sf-log-count').innerText = log.length;

            // Status pill
            const statusPill = document.getElementById('sf-status-pill');
            const isEnabled = !!sfCurrentConfig.is_enabled;
            if (statusPill) {
                if (isEnabled) {
                    statusPill.className = 'text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border bg-emerald-500/20 text-emerald-300 border-emerald-500/30';
                    statusPill.innerText = 'Aktivní ochrana';
                } else {
                    statusPill.className = 'text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border bg-slate-800 text-slate-400 border-white/10';
                    statusPill.innerText = 'Vypnuto';
                }
            }

            // Mode badge in top bar
            const modeBadge = document.getElementById('sf-active-mode-badge');
            if (modeBadge) {
                const modeNames = {
                    'internal': 'Interní chytré ověření',
                    'turnstile': 'Cloudflare Turnstile',
                    'recaptcha_v2': 'Google reCAPTCHA v2',
                    'honeypot_only': 'Neviditelný režim'
                };
                modeBadge.innerText = modeNames[sfCurrentConfig.protection_mode] || 'Interní ověření';
            }

            // Populate form controls
            const isEnabledCb = document.getElementById('sf-is-enabled');
            if (isEnabledCb) {
                isEnabledCb.checked = isEnabled;
                document.getElementById('sf-is-enabled-label').innerText = isEnabled ? 'Zapnuto' : 'Vypnuto';
            }

            // Mode radio
            const modeRadio = document.querySelector(`input[name="sf_protection_mode"][value="${sfCurrentConfig.protection_mode || 'internal'}"]`);
            if (modeRadio) modeRadio.checked = true;

            // Internal type radio
            const intTypeRadio = document.querySelector(`input[name="sf_internal_type"][value="${sfCurrentConfig.internal_type || 'checkbox'}"]`);
            if (intTypeRadio) intTypeRadio.checked = true;

            document.getElementById('sf-custom-question').value = sfCurrentConfig.custom_question || 'Kolik nohou má kůň?';
            document.getElementById('sf-custom-answer').value = sfCurrentConfig.custom_answer || '4';

            document.getElementById('sf-turnstile-site-key').value = sfCurrentConfig.turnstile_site_key || '';
            document.getElementById('sf-turnstile-secret-key').value = sfCurrentConfig.turnstile_secret_key || '';

            document.getElementById('sf-recaptcha-site-key').value = sfCurrentConfig.recaptcha_site_key || '';
            document.getElementById('sf-recaptcha-secret-key').value = sfCurrentConfig.recaptcha_secret_key || '';

            document.getElementById('sf-honeypot-enabled').checked = !!sfCurrentConfig.honeypot_enabled;
            document.getElementById('sf-min-submit-time').value = sfCurrentConfig.min_submit_time || 2;
            document.getElementById('sf-block-disposable').checked = !!sfCurrentConfig.block_disposable_emails;

            const words = sfCurrentConfig.blocked_words || [];
            document.getElementById('sf-blocked-words').value = Array.isArray(words) ? words.join('\n') : '';

            toggleModeFields();
            renderSpamLog(log);

        } catch (e) {
            console.error('Error loading Spam Filter config:', e);
        }
    }

    document.getElementById('sf-is-enabled')?.addEventListener('change', function() {
        document.getElementById('sf-is-enabled-label').innerText = this.checked ? 'Zapnuto' : 'Vypnuto';
    });

    function renderSpamLog(log) {
        const tbody = document.getElementById('sf-log-tbody');
        if (!tbody) return;

        if (!log || log.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="p-6 text-center text-slate-500 font-sans">Zatím žádný zachycený spam. Formuláře jsou v bezpečí.</td></tr>';
            return;
        }

        let html = '';
        log.forEach(entry => {
            html += `
            <tr class="hover:bg-white/5 transition-colors">
                <td class="p-3 text-slate-400 whitespace-nowrap">${entry.datetime || '—'}</td>
                <td class="p-3 text-indigo-300 whitespace-nowrap">${entry.ip || '—'}</td>
                <td class="p-3 text-rose-400 font-semibold">${entry.reason || '—'}</td>
                <td class="p-3 text-slate-300">
                    <div>${entry.name || '—'}</div>
                    <div class="text-[10px] text-slate-500">${entry.email || ''} ${entry.phone ? ' | ' + entry.phone : ''}</div>
                </td>
                <td class="p-3 text-slate-400 max-w-xs truncate" title="${entry.preview || ''}">${entry.preview || '—'}</td>
            </tr>`;
        });

        tbody.innerHTML = html;
    }

    async function saveSpamFilterConfig() {
        const btn = document.getElementById('btn-sf-save');
        const origText = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Ukládám...';
        btn.disabled = true;

        const payload = {
            is_enabled: document.getElementById('sf-is-enabled')?.checked,
            protection_mode: document.querySelector('input[name="sf_protection_mode"]:checked')?.value || 'internal',
            internal_type: document.querySelector('input[name="sf_internal_type"]:checked')?.value || 'checkbox',
            custom_question: document.getElementById('sf-custom-question')?.value,
            custom_answer: document.getElementById('sf-custom-answer')?.value,
            turnstile_site_key: document.getElementById('sf-turnstile-site-key')?.value,
            turnstile_secret_key: document.getElementById('sf-turnstile-secret-key')?.value,
            recaptcha_site_key: document.getElementById('sf-recaptcha-site-key')?.value,
            recaptcha_secret_key: document.getElementById('sf-recaptcha-secret-key')?.value,
            honeypot_enabled: document.getElementById('sf-honeypot-enabled')?.checked,
            min_submit_time: document.getElementById('sf-min-submit-time')?.value,
            block_disposable_emails: document.getElementById('sf-block-disposable')?.checked,
            blocked_words: document.getElementById('sf-blocked-words')?.value
        };

        try {
            const res = await fetch('plugins.php?action=save_spam_filter_config', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (data.status === 'success') {
                showToast(data.message || 'Nastavení bylo úspěšně uloženo.', 'success');
                loadSpamFilterData();
            } else {
                showToast(data.message || 'Chyba při ukládání.', 'error');
            }
        } catch (err) {
            showToast('Chyba komunikace se serverem.', 'error');
        } finally {
            btn.innerHTML = origText;
            btn.disabled = false;
        }
    }

    async function clearSpamLog() {
        if (!confirm('Opravdu chcete promazat veškerý zaznamenaný log spamu?')) return;
        try {
            const res = await fetch('plugins.php?action=clear_spam_log');
            const data = await res.json();
            if (data.status === 'success') {
                showToast('Log spamu byl promazán.', 'success');
                loadSpamFilterData();
            }
        } catch (e) {
            showToast('Chyba při mazání logu.', 'error');
        }
    }

    async function resetSpamStats() {
        if (!confirm('Vynulovat počítadlo zachyceného spamu a prověřených formulářů?')) return;
        try {
            const res = await fetch('plugins.php?action=reset_spam_stats');
            const data = await res.json();
            if (data.status === 'success') {
                showToast('Statistiky byly vynulovány.', 'success');
                loadSpamFilterData();
            }
        } catch (e) {
            showToast('Chyba při vynulování statistik.', 'error');
        }
    }
</script>

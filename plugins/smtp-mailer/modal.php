<!-- SMTP Mailer Modal (Plugin: smtp-mailer) -->
<div id="smtp-modal" onclick="if (event.target === this) closeSMTPModal();" class="hidden fixed inset-0 bg-black/75 z-[110] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-slate-900 w-full max-w-3xl rounded-2xl shadow-2xl border border-white/10 overflow-hidden text-slate-200 flex flex-col max-h-[92vh]">
        <!-- Modal Header -->
        <div class="p-6 border-b border-white/10 flex justify-between items-center bg-slate-950">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center font-bold text-lg border border-indigo-500/30">
                    <i class="fa fa-envelope"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-white font-extrabold text-base tracking-tight">Nastavení SMTP Maileru</h2>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border border-emerald-500/30 bg-emerald-500/20 text-emerald-300">Modulární plugin</span>
                    </div>
                    <p class="text-xs text-slate-400">Spolehlivé odesílání e-mailů přes zabezpečený SMTP server s historií odeslaných zpráv.</p>
                </div>
            </div>
            <button onclick="closeSMTPModal()" class="text-slate-400 hover:text-white p-2 rounded-lg hover:bg-white/5 transition-colors">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex border-b border-white/10 bg-slate-950/30 px-6 gap-2 text-xs font-bold">
            <button type="button" onclick="switchSmtpTab('settings')" id="smtp-tab-btn-settings" class="py-3 px-3 border-b-2 border-indigo-500 text-white flex items-center gap-2 transition-colors">
                <i class="fa fa-sliders text-indigo-400"></i> Konfigurace serveru
            </button>
            <button type="button" onclick="switchSmtpTab('history')" id="smtp-tab-btn-history" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors">
                <i class="fa fa-history text-indigo-400"></i> Poslední e-maily a log
                <span id="smtp-history-badge" class="hidden text-[10px] px-1.5 py-0.2 rounded-full font-mono bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">0</span>
            </button>
            <button type="button" onclick="switchSmtpTab('guide')" id="smtp-tab-btn-guide" class="py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors">
                <i class="fa fa-book text-indigo-400"></i> Návod a integrace
            </button>
        </div>

        <!-- Modal Body Content -->
        <div class="p-6 overflow-y-auto space-y-4 flex-1 text-xs">
            <!-- TAB 1: Server Configuration -->
            <div id="smtp-tab-settings" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-300 uppercase mb-1.5">SMTP Host / Server *</label>
                        <input type="text" id="smtp-host" placeholder="např. smtp.seznam.cz nebo mail.vasadomena.cz" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1.5">Port *</label>
                        <input type="number" id="smtp-port" placeholder="587 / 465" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1.5">Zabezpečení / Šifrování</label>
                        <select id="smtp-encryption" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500">
                            <option value="tls">TLS (Doporučeno, obvykle port 587)</option>
                            <option value="ssl">SSL (Port 465)</option>
                            <option value="none">Žádné šifrování (Port 25)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1.5">E-mail odesílatele (From)</label>
                        <input type="email" id="smtp-from-email" placeholder="např. info@statekstranovice.cz" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1.5">SMTP Uživatel (Přihlašovací jméno)</label>
                        <input type="text" id="smtp-username" placeholder="vaše celá e-mailová adresa" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 uppercase mb-1.5">SMTP Heslo / Heslo aplikace</label>
                        <input type="password" id="smtp-password" placeholder="••••••••••••" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500 font-mono">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-300 uppercase mb-1.5">Jméno odesílatele</label>
                    <input type="text" id="smtp-from-name" placeholder="např. Statek Straňovice" class="w-full bg-slate-950 border border-white/10 rounded-xl p-3 text-white outline-none focus:border-indigo-500">
                </div>

                <!-- Test Connection Panel -->
                <div class="p-4 bg-slate-950/70 border border-white/5 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-2">
                    <div>
                        <div class="font-bold text-slate-200">Ověření nastavení</div>
                        <div class="text-[11px] text-slate-400">Odešle zkušební zprávu a ověří handshake a autentizaci serveru.</div>
                    </div>
                    <button type="button" onclick="testSMTPConnection()" id="btn-test-smtp" class="bg-slate-800 hover:bg-slate-700 text-indigo-300 font-bold px-4 py-2.5 rounded-xl border border-indigo-500/30 transition-all text-xs flex items-center justify-center gap-2 shrink-0">
                        <i class="fa fa-paper-plane"></i> Otestovat spojení
                    </button>
                </div>
            </div>

            <!-- TAB 2: Recent Emails & Log -->
            <div id="smtp-tab-history" class="hidden space-y-4">
                <!-- Status Metrics Header -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-slate-950/70 border border-white/5 rounded-xl p-3 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-bold block">Celkem zpráv</span>
                            <span id="stat-smtp-total" class="text-base font-extrabold text-white">0</span>
                        </div>
                        <i class="fa fa-envelope text-slate-600 text-lg"></i>
                    </div>
                    <div class="bg-slate-950/70 border border-emerald-500/20 rounded-xl p-3 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-emerald-400 uppercase font-bold block">Úspěšně</span>
                            <span id="stat-smtp-success" class="text-base font-extrabold text-emerald-400">0</span>
                        </div>
                        <i class="fa fa-check-circle text-emerald-500/30 text-lg"></i>
                    </div>
                    <div class="bg-slate-950/70 border border-rose-500/20 rounded-xl p-3 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-rose-400 uppercase font-bold block">Chyby</span>
                            <span id="stat-smtp-error" class="text-base font-extrabold text-rose-400">0</span>
                        </div>
                        <i class="fa fa-exclamation-circle text-rose-500/30 text-lg"></i>
                    </div>
                </div>

                <!-- Controls Bar -->
                <div class="flex items-center justify-between pt-1">
                    <span class="font-bold text-slate-300 uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                        <i class="fa fa-history text-indigo-400"></i> Poslední odeslané e-maily
                    </span>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="loadSmtpHistory()" class="text-indigo-300 hover:text-white px-2.5 py-1 rounded-lg bg-slate-950 border border-white/5 hover:border-white/10 transition-colors flex items-center gap-1 text-[11px]">
                            <i class="fa fa-refresh"></i> Obnovit
                        </button>
                        <button type="button" onclick="clearSmtpLogHistory()" class="text-rose-400 hover:text-rose-300 px-2.5 py-1 rounded-lg bg-slate-950 border border-rose-500/20 hover:bg-rose-950/30 transition-colors flex items-center gap-1 text-[11px]">
                            <i class="fa fa-trash"></i> Vymazat log
                        </button>
                    </div>
                </div>

                <!-- Emails Table Container -->
                <div class="border border-white/10 rounded-xl overflow-hidden bg-slate-950/50">
                    <div class="overflow-x-auto max-h-72">
                        <table class="w-full text-left border-collapse text-[11px]">
                            <thead>
                                <tr class="bg-slate-950 border-b border-white/10 text-slate-400 font-bold uppercase text-[10px]">
                                    <th class="p-3">Datum a čas</th>
                                    <th class="p-3">Příjemce</th>
                                    <th class="p-3">Předmět</th>
                                    <th class="p-3">Stav</th>
                                    <th class="p-3">Odpověď serveru</th>
                                </tr>
                            </thead>
                            <tbody id="smtp-history-tbody" class="divide-y divide-white/5 text-slate-300">
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-slate-500">
                                        <i class="fa fa-spinner fa-spin mr-1"></i> Načítám historii e-mailů...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Raw Technical Log Accordion -->
                <details class="bg-slate-950 border border-white/10 rounded-xl overflow-hidden group">
                    <summary class="p-3 text-xs font-bold text-slate-400 hover:text-slate-200 cursor-pointer select-none flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <i class="fa fa-terminal text-slate-500"></i> Zobrazit surový technický soubor logu (smtp.log)
                        </span>
                        <span class="text-[10px] text-indigo-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-3 border-t border-white/5 space-y-2">
                        <div class="flex items-center justify-between text-[10px] text-slate-500 font-mono">
                            <span>Umístění: plugins/smtp-mailer/smtp.log</span>
                            <button type="button" onclick="refreshRawSmtpLog()" class="text-indigo-400 hover:text-indigo-300">Načíst raw log</button>
                        </div>
                        <textarea id="smtp-log-viewer" readonly class="w-full bg-slate-900 border border-white/5 rounded-lg p-2.5 text-slate-300 font-mono text-[10px] h-40 leading-relaxed outline-none overflow-y-auto select-all" placeholder="Klikněte pro načtení raw logu..."></textarea>
                    </div>
                </details>
            </div>

            <!-- TAB 3: Guide & Integration -->
            <div id="smtp-tab-guide" class="hidden space-y-4">
                <div class="bg-indigo-950/40 border border-indigo-500/30 rounded-xl p-4 space-y-2">
                    <h4 class="text-sm font-bold text-indigo-300 flex items-center gap-2">
                        <i class="fa fa-rocket"></i> 1. Jednotné odesílání přes CMS::sendMail()
                    </h4>
                    <p class="text-slate-300 leading-relaxed">
                        Ve všech skriptech webu (např. kontaktní formulář, odeslání poptávky, potvrzení rezervace) volejte namísto nativní funkce <code class="text-rose-300 font-mono">mail()</code> statickou metodu CMS nebo zkrácenou funkci:
                    </p>
                    <pre class="bg-slate-950 p-3 rounded-lg border border-white/10 font-mono text-[11px] text-emerald-400 overflow-x-auto">CMS::sendMail($to, $subject, $body, $headers);
// Nebo zkráceně:
sendMail($to, $subject, $body, $headers);</pre>
                    <p class="text-[11px] text-slate-400">
                        Pokud je plugin SMTP Mailer <strong>aktivní</strong>, e-mail odejde přes zabezpečený SMTP server s platnou autentizací. Pokud plugin není aktivní, automaticky se použije standardní nativní funkce <code class="text-slate-300 font-mono">mail()</code>.
                    </p>
                </div>

                <div class="bg-slate-950 border border-white/10 rounded-xl p-4 space-y-2">
                    <h4 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa fa-code text-indigo-400"></i> 2. Kompletní ukázka ve formuláři
                    </h4>
                    <pre class="bg-slate-900 p-3 rounded-lg border border-white/5 font-mono text-[11px] text-indigo-200 overflow-x-auto leading-relaxed">&lt;?php
require_once __DIR__ . '/admin/includes/CMS.php';

$recipient = "info@statekstranovice.cz";
$subject = "Nová poptávka ubytování";
$body = "Jméno: Jan Novák\nE-mail: jan@example.cz\nZpráva: Poptávám termín...";
$headers = "Reply-To: jan@example.cz\r\n";

// Automaticky využije SMTP konfiguraci z administrace a zapíše výsledek do logu
$success = CMS::sendMail($recipient, $subject, $body, $headers);

if ($success) {
    echo json_encode(["status" => "success", "message" => "Zpráva byla úspěšně odeslána."]);
} else {
    echo json_encode(["status" => "error", "message" => "Chyba při odesílání e-mailu."]);
}</pre>
                </div>

                <div class="bg-slate-950 border border-white/10 rounded-xl p-4 space-y-2">
                    <h4 class="text-sm font-bold text-white flex items-center gap-2">
                        <i class="fa fa-info-circle text-amber-400"></i> 3. Doporučené hodnoty známých poskytovatelů
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-[11px] text-slate-300">
                        <div class="p-3 bg-slate-900 rounded-lg border border-white/5">
                            <strong class="text-amber-300 block mb-1">Seznam.cz / Email profi</strong>
                            Host: <code class="text-slate-400 font-mono">smtp.seznam.cz</code><br>
                            Port: <code class="text-slate-400 font-mono">587 (TLS)</code> nebo <code class="text-slate-400 font-mono">465 (SSL)</code>
                        </div>
                        <div class="p-3 bg-slate-900 rounded-lg border border-white/5">
                            <strong class="text-amber-300 block mb-1">Webglobe / Forpsi / Wedos</strong>
                            Host: dle poskytovatele (např. <code class="text-slate-400 font-mono">mail.webglobe.cz</code>)<br>
                            Port: <code class="text-slate-400 font-mono">587 (TLS)</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 bg-slate-950 border-t border-white/10 flex justify-between items-center">
            <button type="button" onclick="closeSMTPModal()" class="px-5 py-2.5 text-slate-400 hover:text-white font-bold text-xs uppercase tracking-wider transition-colors">
                Zavřít
            </button>
            <div class="flex items-center gap-3">
                <button type="button" onclick="saveSMTPConfig()" id="btn-save-smtp" class="bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold px-6 py-2.5 rounded-xl shadow-lg transition-all text-xs uppercase tracking-wider flex items-center gap-2">
                    <i class="fa fa-check"></i> Uložit nastavení SMTP
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Self-contained JavaScript for SMTP Mailer Modal -->
<script>
function switchSmtpTab(tabId) {
    const tabs = ['settings', 'history', 'guide'];
    tabs.forEach(t => {
        const pane = document.getElementById('smtp-tab-' + t);
        const btn = document.getElementById('smtp-tab-btn-' + t);
        if (pane) pane.classList.toggle('hidden', t !== tabId);
        if (btn) {
            if (t === tabId) {
                btn.className = 'py-3 px-3 border-b-2 border-indigo-500 text-white flex items-center gap-2 transition-colors';
            } else {
                btn.className = 'py-3 px-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 flex items-center gap-2 transition-colors';
            }
        }
    });

    if (tabId === 'history') {
        loadSmtpHistory();
        refreshRawSmtpLog();
    }
}

function openSMTPModal(initialTab = 'settings') {
    switchSmtpTab(initialTab);

    // Fetch live config
    fetch('plugins.php?action=get_smtp_config&_t=' + Date.now())
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const cfg = data.config || {};
                const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val || ''; };
                setVal('smtp-host', cfg.host);
                setVal('smtp-port', cfg.port || 587);
                setVal('smtp-encryption', cfg.encryption || 'tls');
                setVal('smtp-username', cfg.username);
                setVal('smtp-password', cfg.password);
                setVal('smtp-from-email', cfg.from_email);
                setVal('smtp-from-name', cfg.from_name || '');

                const modal = document.getElementById('smtp-modal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            } else {
                alert(data.message || 'Nepodařilo se načíst konfiguraci SMTP.');
            }
        })
        .catch(() => {
            alert('Chyba při komunikaci se serverem.');
        });

    // Also preload history badge count
    fetch('plugins.php?action=get_email_history&_t=' + Date.now())
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.total > 0) {
                const badge = document.getElementById('smtp-history-badge');
                if (badge) {
                    badge.innerText = data.total;
                    badge.classList.remove('hidden');
                }
            }
        })
        .catch(() => {});
}

function closeSMTPModal() {
    const modal = document.getElementById('smtp-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

function loadSmtpHistory() {
    const tbody = document.getElementById('smtp-history-tbody');
    if (!tbody) return;

    fetch('plugins.php?action=get_email_history&_t=' + Date.now())
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const emails = data.emails || [];
                const statTotal = document.getElementById('stat-smtp-total');
                const statSuccess = document.getElementById('stat-smtp-success');
                const statError = document.getElementById('stat-smtp-error');
                const badge = document.getElementById('smtp-history-badge');

                if (statTotal) statTotal.innerText = data.total || 0;
                if (statSuccess) statSuccess.innerText = data.success_count || 0;
                if (statError) statError.innerText = data.error_count || 0;
                if (badge) {
                    badge.innerText = data.total || 0;
                    badge.classList.toggle('hidden', (data.total || 0) === 0);
                }

                if (emails.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                <i class="fa fa-inbox text-3xl mb-2 text-slate-600 block"></i>
                                Zatím nebyly odeslány žádné e-maily přes tento plugin.
                            </td>
                        </tr>`;
                    return;
                }

                let html = '';
                emails.forEach(item => {
                    let statusBadge = '';
                    if (item.status === 'success') {
                        statusBadge = '<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30"><i class="fa fa-check"></i> Odesláno</span>';
                    } else if (item.status === 'native') {
                        statusBadge = '<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30"><i class="fa fa-paper-plane"></i> Nativní mail()</span>';
                    } else {
                        statusBadge = '<span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30"><i class="fa fa-times"></i> Chyba</span>';
                    }

                    const escapeHtml = (str) => {
                        const div = document.createElement('div');
                        div.innerText = str || '';
                        return div.innerHTML;
                    };

                    html += `
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="p-3 text-slate-400 font-mono whitespace-nowrap">${escapeHtml(item.datetime)}</td>
                            <td class="p-3 font-semibold text-white">${escapeHtml(item.to)}</td>
                            <td class="p-3 text-slate-200">${escapeHtml(item.subject)}</td>
                            <td class="p-3 whitespace-nowrap">${statusBadge}</td>
                            <td class="p-3 text-slate-400 font-mono text-[10px] max-w-xs truncate" title="${escapeHtml(item.message)}">${escapeHtml(item.message)}</td>
                        </tr>`;
                });

                tbody.innerHTML = html;
            } else {
                tbody.innerHTML = `<tr><td colspan="5" class="p-4 text-center text-rose-400">Chyba při načítání: ${data.message || 'Neznámá chyba'}</td></tr>`;
            }
        })
        .catch(() => {
            tbody.innerHTML = '<tr><td colspan="5" class="p-4 text-center text-rose-400">Chyba při komunikaci se serverem.</td></tr>';
        });
}

function refreshRawSmtpLog() {
    const logViewer = document.getElementById('smtp-log-viewer');
    if (!logViewer) return;

    fetch('plugins.php?action=get_smtp_log&_t=' + Date.now())
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                logViewer.value = data.log || 'Zatím žádné záznamy v logu.';
                logViewer.scrollTop = logViewer.scrollHeight;
            } else {
                logViewer.value = 'Nepodařilo se načíst log.';
            }
        })
        .catch(() => {
            logViewer.value = 'Chyba při stahování logu.';
        });
}

function clearSmtpLogHistory() {
    if (!confirm('Opravdu chcete vymazat historii odeslaných e-mailů i souborový log?')) return;

    fetch('plugins.php?action=clear_smtp_log', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || 'Log byl promazán.');
        loadSmtpHistory();
        refreshRawSmtpLog();
    })
    .catch(() => {
        alert('Chyba při mazání logu.');
    });
}

function saveSMTPConfig() {
    const getVal = (id) => { const el = document.getElementById(id); return el ? el.value.trim() : ''; };
    const data = {
        host: getVal('smtp-host'),
        port: getVal('smtp-port'),
        encryption: getVal('smtp-encryption'),
        username: getVal('smtp-username'),
        password: getVal('smtp-password'),
        from_email: getVal('smtp-from-email'),
        from_name: getVal('smtp-from-name')
    };

    const btn = document.getElementById('btn-save-smtp');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Ukládám...';
    btn.disabled = true;

    fetch('plugins.php?action=save_smtp_config', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(resData => {
        alert(resData.message || 'Nastavení bylo uloženo.');
        if (resData.status === 'success') {
            closeSMTPModal();
        }
    })
    .catch(() => {
        alert('Chyba při ukládání nastavení SMTP.');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function testSMTPConnection() {
    const fromEmail = document.getElementById('smtp-from-email')?.value?.trim() || '';
    const testEmail = prompt('Zadejte cílovou e-mailovou adresu pro zaslání testovací zprávy:', fromEmail || 'info@statekstranovice.cz');
    if (!testEmail) return;

    const btn = document.getElementById('btn-test-smtp');
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Odesílám...';
    btn.disabled = true;

    fetch('plugins.php?action=test_smtp', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ test_email: testEmail })
    })
    .then(res => res.json())
    .then(resData => {
        alert(resData.message);
        // Refresh history if active
        loadSmtpHistory();
        refreshRawSmtpLog();
    })
    .catch(() => {
        alert('Chyba při komunikaci se serverem.');
    })
    .finally(() => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}
</script>

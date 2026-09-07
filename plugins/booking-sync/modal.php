<!-- Booking Sync Modal (Plugin: booking-sync) -->
<div id="booking-sync-modal" onclick="if (event.target === this) closeBookingSyncModal();" class="hidden fixed inset-0 bg-black/75 z-[110] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-slate-900 w-full max-w-3xl rounded-2xl shadow-2xl border border-white/10 overflow-hidden text-slate-200 flex flex-col max-h-[90vh]">
        <div class="p-6 border-b border-white/10 flex justify-between items-center bg-slate-950">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center font-bold">
                    <i class="fa fa-calendar-check-o"></i>
                </div>
                <div>
                    <h2 class="text-white font-extrabold text-base tracking-tight">Nastavení synchronizace rezervací</h2>
                    <p class="text-xs text-slate-400">Kalendáře obsazenosti (Booking.com &amp; MegaUbytko.cz)</p>
                </div>
            </div>
            <button onclick="closeBookingSyncModal()" class="text-slate-400 hover:text-white"><i class="fa fa-times text-lg"></i></button>
        </div>

        <div class="p-6 overflow-y-auto space-y-6">
            <!-- Status Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="bg-slate-950/70 p-3.5 rounded-xl border border-white/5">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Poslední synchronizace</div>
                    <div id="bs-last-sync" class="text-base font-extrabold text-white mt-1">Načítám...</div>
                </div>
                <div class="bg-slate-950/70 p-3.5 rounded-xl border border-white/5">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Apartmány</div>
                    <div id="bs-rooms-count" class="text-base font-extrabold text-indigo-400 mt-1">5</div>
                </div>
                <div class="bg-slate-950/70 p-3.5 rounded-xl border border-white/5">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Obsazených termínů</div>
                    <div id="bs-total-days" class="text-base font-extrabold text-emerald-400 mt-1">Načítám...</div>
                </div>
            </div>

            <div id="bs-sync-feedback" class="hidden p-3 rounded-xl text-xs font-semibold border"></div>

            <!-- CRON info & URLs -->
            <div class="bg-slate-950/50 border border-white/5 rounded-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa fa-clock-o text-indigo-400"></i> Informace o CRONu (Interval 30 minut)
                    </h3>
                    <span class="text-[10px] bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 px-2 py-0.5 rounded font-mono">Auto-běh na pozadí webu aktivní</span>
                </div>
                <p class="text-[11px] text-slate-400 leading-relaxed">
                    Web automaticky spustí synchronizaci při návštěvě stránky, pokud od posledního běhu uběhlo více než 30 minut. Pro garantovanou nezávislou synchronizaci můžete navíc zadat tuto URL do hostingu (Wedos/Forpsi):
                </p>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Webová CRON URL:</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="bs-cron-url" readonly class="w-full bg-slate-950 border border-white/10 rounded-lg px-3 py-2 text-xs font-mono text-indigo-200 select-all">
                        <button onclick="copyBsCronUrl()" class="bg-slate-800 hover:bg-slate-700 text-white px-3 py-2 rounded-lg text-xs font-bold transition-colors shrink-0 flex items-center gap-1">
                            <i class="fa fa-copy"></i> Kopírovat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Room URLs edit list -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa fa-bed text-indigo-400"></i> Nastavení iCal kalendářů pro apartmány
                    </h3>
                </div>
                <div id="bs-rooms-container" class="space-y-3">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </div>

        <div class="p-4 bg-slate-950 border-t border-white/10 flex justify-between items-center">
            <button onclick="triggerBsSyncManual()" id="btn-bs-sync" class="bg-slate-800 hover:bg-slate-700 text-white font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 transition-all">
                <i class="fa fa-refresh"></i> Synchronizovat nyní
            </button>
            <div class="flex gap-2">
                <button onclick="closeBookingSyncModal()" class="px-4 py-2 text-slate-400 hover:text-white font-bold text-xs uppercase">Zavřít</button>
                <button onclick="saveBsRooms()" id="btn-bs-save" class="bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold px-5 py-2 rounded-xl text-xs uppercase shadow-lg shadow-indigo-600/20 transition-all">Uložit URL adresy</button>
            </div>
        </div>
    </div>
</div>

<script>
    let bsRoomsState = {};

    function openBookingSyncModal() {
        const modal = document.getElementById('booking-sync-modal');
        if (!modal) return;
        modal.classList.remove('hidden');
        loadBookingSyncData();
    }

    function closeBookingSyncModal() {
        document.getElementById('booking-sync-modal')?.classList.add('hidden');
    }

    function loadBookingSyncData() {
        fetch('plugins.php?action=booking_sync_get_info&_t=' + Date.now())
            .then(r => r.json())
            .then(data => {
                if (data && data.status === 'success') {
                    document.getElementById('bs-last-sync').innerText = data.last_sync || 'Zatím neproběhla';
                    document.getElementById('bs-rooms-count').innerText = data.rooms_count || 5;
                    document.getElementById('bs-total-days').innerText = (data.total_days || 0) + ' dnů';
                    document.getElementById('bs-cron-url').value = data.cron_url || (window.location.origin + '/plugins/booking-sync/cron.php');
                    
                    bsRoomsState = data.rooms || {};
                    renderBsRoomsList(bsRoomsState);
                }
            })
            .catch(err => console.error('Chyba při načítání stavu Booking Sync:', err));
    }

    function renderBsRoomsList(rooms) {
        const container = document.getElementById('bs-rooms-container');
        if (!container) return;
        let html = '';
        for (const [id, room] of Object.entries(rooms)) {
            html += `
                <div class="bg-slate-950/80 border border-white/5 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-white flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-400"></span> ${room.name || id}
                        </span>
                        <span class="text-[10px] font-mono text-slate-500 uppercase">${id}</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Booking.com iCal URL:</label>
                            <input type="text" data-room-id="${id}" data-field="ical_url" value="${room.ical_url || ''}" class="bs-room-input w-full bg-slate-900 border border-white/10 rounded-lg px-3 py-2 text-xs font-mono text-slate-300 outline-none focus:border-indigo-500 transition-all placeholder-slate-700" placeholder="https://ical.booking.com/v1/export?t=...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">MegaUbytko.cz iCal URL:</label>
                            <input type="text" data-room-id="${id}" data-field="megaubytko_ical_url" value="${room.megaubytko_ical_url || ''}" class="bs-room-input w-full bg-slate-900 border border-white/10 rounded-lg px-3 py-2 text-xs font-mono text-slate-300 outline-none focus:border-indigo-500 transition-all placeholder-slate-700" placeholder="https://www.megaubytko.cz/ical-export/...">
                        </div>
                    </div>
                </div>
            `;
        }
        container.innerHTML = html;
    }

    function triggerBsSyncManual() {
        const btn = document.getElementById('btn-bs-sync');
        const feedback = document.getElementById('bs-sync-feedback');
        const origHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-refresh fa-spin"></i> Synchronizuji...';
        btn.disabled = true;

        fetch('plugins.php?action=booking_sync_trigger&_t=' + Date.now())
            .then(r => r.json())
            .then(data => {
                if (feedback) {
                    feedback.classList.remove('hidden', 'bg-emerald-950/40', 'border-emerald-500/30', 'text-emerald-300', 'bg-rose-950/40', 'border-rose-500/30', 'text-rose-300');
                    if (data.sync_status === 'success') {
                        feedback.classList.add('bg-emerald-950/40', 'border-emerald-500/30', 'text-emerald-300');
                    } else {
                        feedback.classList.add('bg-rose-950/40', 'border-rose-500/30', 'text-rose-300');
                    }
                    feedback.innerHTML = data.message || 'Synchronizace dokončena.';
                }
                if (data && data.status === 'success') {
                    if (data.last_sync) {
                        document.getElementById('bs-last-sync').innerText = data.last_sync;
                    }
                    if (data.total_days !== undefined) {
                        document.getElementById('bs-total-days').innerText = (data.total_days || 0) + ' dnů';
                    }
                    if (data.rooms_count !== undefined) {
                        document.getElementById('bs-rooms-count').innerText = data.rooms_count;
                    }
                }
                loadBookingSyncData();
            })
            .catch(err => {
                alert('Chyba při spuštění synchronizace.');
            })
            .finally(() => {
                btn.innerHTML = origHtml;
                btn.disabled = false;
            });
    }

    function saveBsRooms() {
        const inputs = document.querySelectorAll('.bs-room-input');
        const updated = JSON.parse(JSON.stringify(bsRoomsState));

        inputs.forEach(input => {
            const roomId = input.getAttribute('data-room-id');
            const field = input.getAttribute('data-field');
            if (updated[roomId]) {
                updated[roomId][field] = input.value.trim();
            }
        });

        const btn = document.getElementById('btn-bs-save');
        const orig = btn.innerText;
        btn.innerText = 'UKLÁDÁM...';
        btn.disabled = true;

        fetch('plugins.php?action=booking_sync_save_rooms', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ rooms: updated })
        })
        .then(r => r.json())
        .then(data => {
            alert(data.message || 'Nastavení uloženo.');
            loadBookingSyncData();
        })
        .catch(() => alert('Chyba při ukládání.'))
        .finally(() => {
            btn.innerText = orig;
            btn.disabled = false;
        });
    }

    function copyBsCronUrl() {
        const el = document.getElementById('bs-cron-url');
        if (el) {
            el.select();
            navigator.clipboard.writeText(el.value).then(() => {
                alert('CRON URL zkopírována do schránky.');
            });
        }
    }

    // Escape listener for booking-sync modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            const bsModal = document.getElementById('booking-sync-modal');
            if (bsModal && !bsModal.classList.contains('hidden')) {
                closeBookingSyncModal();
            }
        }
    });
</script>

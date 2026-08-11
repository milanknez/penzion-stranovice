/*
    Room Calendar Modal – date selection + transfer to contact form
    Statek Straňovice / assets/js/room-calendar.js
    Separated from app.js for clarity and maintainability.
*/

document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('room-calendar-modal');
    if (!modal) return;

    const titleEl           = document.getElementById('room-calendar-title');
    const prevBtn           = document.getElementById('cal-prev-month');
    const nextBtn           = document.getElementById('cal-next-month');
    const monthSelect       = document.getElementById('cal-month-select');
    const yearSelect        = document.getElementById('cal-year-select');
    const daysGrid          = document.getElementById('calendar-days-grid');
    const closeBtn          = modal.querySelector('.close-modal');
    const reserveActionBtn  = document.getElementById('cal-reserve-action-btn');
    const selectionInfo     = document.getElementById('cal-selection-info');
    const selectedRangeText = document.getElementById('cal-selected-range-text');

    const monthNames = [
        'Leden','Únor','Březen','Duben','Květen','Červen',
        'Červenec','Srpen','Září','Říjen','Listopad','Prosinec'
    ];

    let activeRoomId   = '';
    let activeRoomName = '';
    let viewYear  = new Date().getFullYear();
    let viewMonth = new Date().getMonth();
    let selectedArrival   = null;   // YYYY-MM-DD
    let selectedDeparture = null;   // YYYY-MM-DD

    // ── Helpers ───────────────────────────────────────────────────────────────

    const formatCzechDate = (iso) => {
        if (!iso) return '';
        const [y, m, d] = iso.split('-');
        return `${parseInt(d, 10)}. ${parseInt(m, 10)}. ${y}`;
    };

    const updateSelectionUI = () => {
        if (!selectionInfo) return;
        if (selectedArrival && selectedDeparture) {
            selectionInfo.style.display = 'block';
            if (selectedRangeText)
                selectedRangeText.innerText =
                    `${formatCzechDate(selectedArrival)} – ${formatCzechDate(selectedDeparture)}`;
        } else if (selectedArrival) {
            selectionInfo.style.display = 'block';
            if (selectedRangeText)
                selectedRangeText.innerText =
                    `${formatCzechDate(selectedArrival)} (vyberte odjezd)`;
        } else {
            selectionInfo.style.display = 'none';
            if (selectedRangeText) selectedRangeText.innerText = '';
        }
    };

    const populateSelects = () => {
        if (!monthSelect || !yearSelect) return;
        monthSelect.innerHTML = monthNames
            .map((m, i) => `<option value="${i}">${m}</option>`)
            .join('');
        const yr = new Date().getFullYear();
        yearSelect.innerHTML = [yr - 1, yr, yr + 1, yr + 2]
            .map(y => `<option value="${y}">${y}</option>`)
            .join('');
    };

    // ── Calendar render ───────────────────────────────────────────────────────

    const renderCalendar = () => {
        if (!daysGrid) return;
        monthSelect.value = viewMonth;
        yearSelect.value  = viewYear;

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const occupancy = (window.occupancyData && activeRoomId)
            ? (window.occupancyData[activeRoomId] || [])
            : [];

        // Czech week starts on Monday
        const firstDayRaw    = new Date(viewYear, viewMonth, 1).getDay();
        const startDayOffset = firstDayRaw === 0 ? 6 : firstDayRaw - 1;
        const daysInMonth    = new Date(viewYear, viewMonth + 1, 0).getDate();

        let html = '';
        for (let i = 0; i < startDayOffset; i++) {
            html += `<div class="cal-day-cell empty"></div>`;
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const dateObj = new Date(viewYear, viewMonth, d);
            dateObj.setHours(0, 0, 0, 0);

            const mm  = String(viewMonth + 1).padStart(2, '0');
            const dd  = String(d).padStart(2, '0');
            const iso = `${viewYear}-${mm}-${dd}`;

            const isOcc  = occupancy.includes(iso);
            const isPast = dateObj < today;
            const isTod  = dateObj.getTime() === today.getTime();

            const cls = ['cal-day-cell'];
            if (isPast) cls.push('past');
            if (isTod)  cls.push('today');
            cls.push(isOcc ? 'occupied' : 'free');

            if (iso === selectedArrival)
                cls.push('selected-start');
            else if (iso === selectedDeparture)
                cls.push('selected-end');
            else if (
                selectedArrival && selectedDeparture &&
                iso > selectedArrival && iso < selectedDeparture
            )
                cls.push('in-range');

            html += `<div class="${cls.join(' ')}" data-date="${iso}">
                <span class="cal-day-number">${d}</span>
                <span class="cal-day-status">${isOcc ? 'Obsazeno' : 'Volno'}</span>
            </div>`;
        }

        daysGrid.innerHTML = html;

        // Attach click events – only on free, non-past days
        daysGrid.querySelectorAll('.cal-day-cell.free:not(.past)').forEach(cell => {
            cell.addEventListener('click', () => {
                const clicked = cell.getAttribute('data-date');
                if (!clicked) return;

                if (!selectedArrival || (selectedArrival && selectedDeparture)) {
                    // First click or re-start: set arrival
                    selectedArrival   = clicked;
                    selectedDeparture = null;
                } else if (clicked > selectedArrival) {
                    // Check for occupied days in range
                    const occ = (window.occupancyData && activeRoomId)
                        ? (window.occupancyData[activeRoomId] || [])
                        : [];
                    const conflict = occ.some(od => od >= selectedArrival && od <= clicked);
                    if (conflict) {
                        selectedArrival   = clicked;
                        selectedDeparture = null;
                    } else {
                        selectedDeparture = clicked;
                    }
                } else {
                    // Earlier date clicked – reset arrival
                    selectedArrival   = clicked;
                    selectedDeparture = null;
                }

                updateSelectionUI();
                renderCalendar();
            });
        });
    };

    // ── Modal open / close ────────────────────────────────────────────────────

    const openModal = (roomId, roomName) => {
        activeRoomId   = roomId;
        activeRoomName = roomName || 'Apartmán';
        if (titleEl) titleEl.innerText = `Obsazenost – ${activeRoomName}`;

        selectedArrival   = null;
        selectedDeparture = null;
        updateSelectionUI();

        viewYear  = new Date().getFullYear();
        viewMonth = new Date().getMonth();

        if (!window.occupancyData || Object.keys(window.occupancyData).length === 0) {
            fetch('plugins/booking-sync/api.php')
                .then(r => r.json())
                .then(data => { window.occupancyData = data; renderCalendar(); })
                .catch(err => console.error('Chyba při načítání obsazenosti:', err));
        }

        renderCalendar();
        modal.style.display = 'flex';
        if (typeof lucide !== 'undefined') lucide.createIcons();
    };

    const closeModal = () => { modal.style.display = 'none'; };

    // ── Reserve button ────────────────────────────────────────────────────────

    if (reserveActionBtn) {
        reserveActionBtn.addEventListener('click', (e) => {
            e.preventDefault();

            // Save before closing (closeModal doesn't clear these, but just to be safe)
            const savedArrival   = selectedArrival;
            const savedDeparture = selectedDeparture;
            closeModal();

            setTimeout(() => {
                const form = document.querySelector('.contact-form');
                if (form) {
                    const arrInput = form.querySelectorAll('input[type="date"]')[0];
                    const depInput = form.querySelectorAll('input[type="date"]')[1];

                    if (arrInput && savedArrival) {
                        if (arrInput._flatpickr) {
                            arrInput._flatpickr.setDate(savedArrival, true);
                        } else {
                            arrInput.value = savedArrival;
                            arrInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }
                    if (depInput && savedDeparture) {
                        if (depInput._flatpickr) {
                            depInput._flatpickr.setDate(savedDeparture, true);
                        } else {
                            depInput.value = savedDeparture;
                            depInput.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }

                    // Scroll to reservation section / form
                    const target = document.getElementById('poptat-termin') || form;
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });

                } else if (activeRoomId) {
                    // Form is on a different page – navigate with query params
                    const slugs = {
                        babiccin:  'babiccin.php',
                        kocici:    'kocici.php',
                        konsky:    'konsky.php',
                        kvetinovy: 'kvetinovy.php',
                        medovy:    'medovy.php',
                    };
                    const params = new URLSearchParams();
                    if (savedArrival)   params.set('arrival',   savedArrival);
                    if (savedDeparture) params.set('departure', savedDeparture);
                    const qs = params.toString() ? `?${params.toString()}` : '';
                    window.location.href =
                        `${slugs[activeRoomId] || activeRoomId + '.php'}#poptat-termin${qs}`;
                }
            }, 200);
        });
    }

    // ── Wire up controls ──────────────────────────────────────────────────────

    populateSelects();

    document.querySelectorAll('.open-room-calendar').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(
                btn.getAttribute('data-room'),
                btn.getAttribute('data-room-name')
            );
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    if (prevBtn) prevBtn.addEventListener('click', () => {
        viewMonth === 0 ? (viewMonth = 11, viewYear--) : viewMonth--;
        renderCalendar();
    });
    if (nextBtn) nextBtn.addEventListener('click', () => {
        viewMonth === 11 ? (viewMonth = 0, viewYear++) : viewMonth++;
        renderCalendar();
    });
    if (monthSelect) monthSelect.addEventListener('change', e => {
        viewMonth = parseInt(e.target.value, 10);
        renderCalendar();
    });
    if (yearSelect) yearSelect.addEventListener('change', e => {
        viewYear = parseInt(e.target.value, 10);
        renderCalendar();
    });

    window.addEventListener('click', e => {
        if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.style.display === 'flex') closeModal();
    });
});

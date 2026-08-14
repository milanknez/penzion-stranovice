/* 
    Statek Penzón v2 (PHP) - Interactions 
*/

document.addEventListener('DOMContentLoaded', () => {
    console.log("Script v2 loaded");
    // alert("JS V2 ACTIVE"); // Uncomment if still nothing happens

    // Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Auto-fill contact form message from URL parameter ?program=...
    const urlParams = new URLSearchParams(window.location.search);
    const programParam = urlParams.get('program');
    if (programParam) {
        const messageTextarea = document.querySelector('.contact-form textarea[name="zprava"], textarea[name="zprava"]');
        if (messageTextarea) {
            messageTextarea.value = `Dobrý den,\nmám zájem o program: ${programParam}.\nProsím o více informací a volné termíny.`;
        }
    }

    // Hero Background Slider
    const heroSlider = document.getElementById('hero-bg-slider');
    if (heroSlider) {
        const slides = heroSlider.querySelectorAll('.hero-bg-slide');
        if (slides.length > 1) {
            let currentSlide = 0;
            setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }, 6000);
        }
    }

    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });

    // Reveal animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal, .reveal-up').forEach(el => observer.observe(el));

    // Interactive Surroundings Explorer Map (Option 1)
    const mapElement = document.getElementById('map');
    if (mapElement && typeof L !== 'undefined') {
        const homeCoords = [49.1227511, 13.9021071];
        const map = L.map('map', { scrollWheelZoom: false }).setView(homeCoords, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Statek Main Pin
        const statekIcon = L.divIcon({
            className: 'custom-home-pin statek-pin',
            html: `<div style="background:#8B5E3C; color:white; width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:22px; border:3px solid white; box-shadow:0 6px 16px rgba(139,94,60,0.5); z-index:1000;">🏡</div>`,
            iconSize: [44, 44],
            iconAnchor: [22, 22]
        });

        const statekMarker = L.marker(homeCoords, { icon: statekIcon, zIndexOffset: 1000 }).addTo(map)
            .bindPopup(`
                <div style="text-align:center; padding:6px 4px; min-width:170px;">
                    <div style="font-size:0.75rem; font-weight:700; color:#8B5E3C; text-transform:uppercase; letter-spacing:1px; margin-bottom:2px;">Váš pobyt</div>
                    <strong style="font-size:1.05rem; font-family:'Libre Baskerville',serif; color:#2c2c2c; display:block; margin-bottom:4px;">Statek Straňovice</strong>
                    <p style="margin:0 0 8px 0; font-size:0.85rem; color:#666;">Výchozí bod pro všechny výlety, koupání i cyklotrasy.</p>
                    <a href="#rooms" style="display:inline-block; background:#8B5E3C; color:white; padding:4px 10px; border-radius:4px; font-size:0.78rem; text-decoration:none; font-weight:600;">Prohlédnout pokoje</a>
                </div>
            `);

        // Surroundings POI dataset (Verified GPS)
        const places = [
            // Pěší výlety a památky
            {
                id: 'rybnik',
                name: 'Straňovický rybník',
                category: 'vylety',
                coords: [49.1228, 13.8965],
                icon: '🌊',
                color: '#D97706',
                dist: '200 m od statku',
                desc: 'Klidný rybník a odpočinková zóna u řeky Volyňky kousek od statku.'
            },
            {
                id: 'fara',
                name: 'Opravená Fara v Malenicích a kavárna',
                category: 'vylety',
                coords: [49.1242, 13.8820],
                icon: '☕',
                color: '#D97706',
                dist: '1.8 km (20 min pěšky)',
                desc: 'Zrekonstruovaná historická fara s letní kavárnou, dětským hřištěm a infocentrem.'
            },
            {
                id: 'hrbitov',
                name: 'Památný hřbitov & Kostel sv. Jakuba v Malenicích',
                category: 'vylety',
                coords: [49.1238, 13.8825],
                icon: '🏛️',
                color: '#D97706',
                dist: '1.8 km (20 min pěšky)',
                desc: 'Jihočeský Slavín – místo odpočinku Zdeňka Podskalského, Jiřiny Jiráskové a Josefa Zítka.'
            },
            {
                id: 'helfenburk',
                name: 'Zřícenina hradu Helfenburk',
                category: 'vylety',
                coords: [49.1359, 14.0067],
                icon: '🏰',
                color: '#D97706',
                dist: '14 km',
                desc: 'Jedna z nejrozsáhlejších a nejromantičtějších hradních zřícenin v jižních Čechách.'
            },
            {
                id: 'vimperk',
                name: 'Zámek Vimperk a Muzeum Šumavy',
                category: 'vylety',
                coords: [49.0553, 13.7735],
                icon: '🏰',
                color: '#D97706',
                dist: '18 km',
                desc: 'Nově zrekonstruovaný renesanční zámek na skále nad městem Vimperk.'
            },

            // Cyklotrasy a Šumava
            {
                id: 'boubin',
                name: 'Rozhledna a prales Boubín',
                category: 'cyklo',
                coords: [48.9912, 13.8174],
                icon: '🌲',
                color: '#059669',
                dist: '26 km',
                desc: 'Dřevěná rozhledna na vrcholu Boubína (1 362 m) a národní přírodní rezervace pralesa.'
            },
            {
                id: 'javornik',
                name: 'Rozhledna Javorník (1 066 m)',
                category: 'cyklo',
                coords: [49.1387, 13.6639],
                icon: '🔭',
                color: '#059669',
                dist: '21 km',
                desc: 'Krásná kamenná rozhledna Klostermannova s panoramatickým výhledem na celou Šumavu.'
            },
            {
                id: 'kubovahuť',
                name: 'Kubova Huť – nejvýše položená stanice v ČR',
                category: 'cyklo',
                coords: [48.9832, 13.7718],
                icon: '🚴',
                color: '#059669',
                dist: '25 km',
                desc: 'Oblíbené výchozí místo cyklistických a běžkařských tras Šumavy (995 m n. m.).'
            },

            // Koupání a relax
            {
                id: 'bazen_statek',
                name: 'Venkovní bazén Statku Straňovice',
                category: 'koupaliste',
                coords: [49.1225444, 13.9020714],
                icon: '🏊',
                color: '#0284C7',
                dist: 'Přímo na dvoře',
                desc: 'Osvěžující venkovní bazén a pohodlná lehátka exkluzivně pro ubytované hosty.'
            },
            {
                id: 'koupaliste_volyne',
                name: 'Prvorepublikové koupaliště Volyně',
                category: 'koupaliste',
                coords: [49.1645, 13.8955],
                icon: '🏊‍♂️',
                color: '#0284C7',
                dist: '5 km',
                desc: 'Unikátní dochovaná prvorepubliková plovárna s dřevěnými kabinkami z roku 1941.'
            },
            {
                id: 'koupaliste_rohanov',
                name: 'Přírodní koupaliště Rohanov',
                category: 'koupaliste',
                coords: [49.1384, 13.7044],
                icon: '🌲',
                color: '#0284C7',
                dist: '16 km',
                desc: 'Přírodní koupaliště s čistou šumavskou vodou uprostřed voňavých jehličnatých lesů.'
            },
            {
                id: 'koupaliste_vimperk',
                name: 'Letní koupaliště Vimperk',
                category: 'koupaliste',
                coords: [49.0585, 13.7795],
                icon: '💦',
                color: '#0284C7',
                dist: '18 km',
                desc: 'Moderní plavecký a dětský bazén s tobogánem a travnatými plochami.'
            },

            // Kam na jídlo
            {
                id: 'malenicka_hospudka',
                name: 'Malenická hospůdka (KD Malenice)',
                category: 'jidlo',
                coords: [49.1255, 13.8820],
                icon: '🍽️',
                color: '#E11D48',
                dist: '1.8 km',
                desc: 'Místní hospůdka v Malenicích v budově kulturního domu.'
            },
            {
                id: 'hospudka_lcovice',
                name: 'Hospůdka pod Věncem (Lčovice)',
                category: 'jidlo',
                coords: [49.1100158, 13.8618244],
                icon: '🍺',
                color: '#E11D48',
                dist: '3.5 km',
                desc: 'Oblíbený kiosek a letní posezení pod vrchem Věnec (Lčovice 95).'
            },
            {
                id: 'zamecky_pivovar',
                name: 'Pivovar a restaurace Vimperk',
                category: 'jidlo',
                coords: [49.0523, 13.7732],
                icon: '🍺',
                color: '#E11D48',
                dist: '18 km',
                desc: 'Řemeslná šumavská piva a výtečná jihočeská gastronomie v historických prostorách.'
            },
            {
                id: 'kavarna_volyne',
                name: 'Kavárna a bistro na náměstí ve Volyni',
                category: 'jidlo',
                coords: [49.1658, 13.8859],
                icon: '☕',
                color: '#E11D48',
                dist: '5 km',
                desc: 'Výběrová káva, domácí dezerty a čerstvé snídaně v centru malebné Volyně.'
            }
        ];

        let markersLayer = L.layerGroup().addTo(map);

        function renderMapMarkers(filterCat = 'all') {
            markersLayer.clearLayers();

            const bounds = L.latLngBounds([homeCoords]);

            places.forEach(p => {
                if (filterCat !== 'all' && p.category !== filterCat) return;

                bounds.extend(p.coords);

                const icon = L.divIcon({
                    className: 'custom-home-poi-pin',
                    html: `<div style="background:${p.color}; color:white; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:16px; border:2px solid white; box-shadow:0 3px 10px rgba(0,0,0,0.25); cursor:pointer; transition:transform 0.2s;">${p.icon}</div>`,
                    iconSize: [34, 34],
                    iconAnchor: [17, 17]
                });

                const marker = L.marker(p.coords, { icon: icon }).addTo(markersLayer);
                
                marker.bindPopup(`
                    <div style="padding:4px 2px; min-width:180px;">
                        <span style="display:inline-block; font-size:0.72rem; padding:2px 6px; background:#f0f0f0; border-radius:10px; font-weight:600; color:#555; margin-bottom:4px;">${p.dist}</span>
                        <strong style="display:block; font-family:'Libre Baskerville',serif; font-size:0.95rem; color:#2c2c2c; margin-bottom:4px;">${p.name}</strong>
                        <p style="margin:0; font-size:0.82rem; color:#666; line-height:1.4;">${p.desc}</p>
                    </div>
                `);
            });

            // Adjust view smoothly
            if (bounds.isValid()) {
                map.fitBounds(bounds, { padding: [50, 50], maxZoom: 12 });
            }
        }

        // Initial render
        renderMapMarkers('all');

        // Filter buttons click handler
        const filterBtns = document.querySelectorAll('.map-filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const cat = btn.dataset.cat || 'all';
                renderMapMarkers(cat);
            });
        });
    }

    // Mobile Menu & Dropdowns
    const mobileToggle = document.getElementById('mobile-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (mobileToggle && navLinks) {
        mobileToggle.onclick = (e) => {
            e.stopPropagation();
            navLinks.classList.toggle('active');
        };

        navLinks.querySelectorAll('a:not(.has-dropdown)').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });

        document.addEventListener('click', (e) => {
            if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && e.target !== mobileToggle) {
                navLinks.classList.remove('active');
            }
        });
    }

    // Mobile Dropdown toggles
    document.querySelectorAll('.has-dropdown').forEach(dropdown => {
        dropdown.onclick = (e) => {
            if (window.innerWidth <= 1150) {
                e.preventDefault();
                e.stopPropagation();
                dropdown.parentElement.classList.toggle('active');
            }
        };
    });

    // Smooth scroll for hash links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href || href === '#' || this.classList.contains('has-dropdown') || this.classList.contains('open-room-calendar')) return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Timeline Modal (homepage open-timeline buttons only)
    const timelineModal = document.getElementById('timeline-modal');
    const openTimelineBtns = document.querySelectorAll('#open-timeline, .open-timeline');
    if (timelineModal && openTimelineBtns.length > 0) {
        const closeBtn = timelineModal.querySelector('.close-modal');
        openTimelineBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                timelineModal.style.display = "block";
                renderTimeline();
                fetch('plugins/booking-sync/api.php?action=sync')
                    .then(res => res.json())
                    .then(data => {
                        if (data && typeof data === 'object' && !data.error) {
                            window.occupancyData = data;
                            renderTimeline();
                        }
                    })
                    .catch(() => { });
            });
        });
        if (closeBtn) {
            closeBtn.addEventListener('click', () => { timelineModal.style.display = "none"; });
        }
        window.addEventListener('click', (e) => {
            if (e.target == timelineModal) timelineModal.style.display = "none";
        });
    }

    // ── Availability Calendar Modal (.open-room-calendar) ───────────────────
    (function () {
        const overlay = document.getElementById('avail-modal');
        if (!overlay) return;

        const closeBtn = document.getElementById('avail-modal-close');
        const title = document.getElementById('avail-modal-title');
        const grid = document.getElementById('avail-cal-grid');
        const monthLabel = document.getElementById('avail-month-label');
        const confirmBtn = document.getElementById('avail-confirm-btn');
        const selArrival = document.getElementById('avail-sel-arrival');
        const selDepart = document.getElementById('avail-sel-departure');

        const MONTHS_CS = ['Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen',
            'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'];

        let currentRoom = '';
        let bookedDates = new Set();
        let viewYear, viewMonth;
        let selStart = null, selEnd = null;  // YYYY-MM-DD strings

        // Helper: YYYY-MM-DD string from viewYear/viewMonth/day number
        function toYMD(y, m, d) {
            return y + '-' + String(m + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
        }
        // Format YYYY-MM-DD to Czech readable
        function fmtCZ(ymd) {
            const p = ymd.split('-');
            return parseInt(p[2]) + '. ' + parseInt(p[1]) + '. ' + p[0];
        }
        // Today as YYYY-MM-DD (local)
        function todayYMD() {
            const t = new Date();
            return toYMD(t.getFullYear(), t.getMonth(), t.getDate());
        }

        function renderCalendar() {
            // Remove old day cells (keep day-name headers = first 7 children)
            const headers = Array.from(grid.querySelectorAll('.avail-day-name'));
            grid.innerHTML = '';
            headers.forEach(h => grid.appendChild(h));

            monthLabel.textContent = MONTHS_CS[viewMonth] + ' ' + viewYear;

            const today = todayYMD();
            const firstDay = new Date(viewYear, viewMonth, 1);
            // Monday=0 offset
            let offset = (firstDay.getDay() + 6) % 7;
            for (let i = 0; i < offset; i++) {
                const blank = document.createElement('div');
                blank.className = 'avail-day empty';
                grid.appendChild(blank);
            }

            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
            for (let d = 1; d <= daysInMonth; d++) {
                const ymd = toYMD(viewYear, viewMonth, d);
                const cell = document.createElement('div');
                cell.className = 'avail-day';
                cell.textContent = d;
                cell.dataset.date = ymd;

                if (ymd < today) {
                    cell.classList.add('past');
                } else if (bookedDates.has(ymd)) {
                    cell.classList.add('booked');
                } else {
                    cell.classList.add('free');
                }

                if (ymd === today) cell.classList.add('today');

                // Highlight selected range (string comparison works for YYYY-MM-DD)
                if (selStart && selEnd) {
                    if (ymd === selStart) cell.classList.add('arrival');
                    else if (ymd === selEnd) cell.classList.add('departure');
                    else if (ymd > selStart && ymd < selEnd) cell.classList.add('in-range');
                } else if (selStart && ymd === selStart) {
                    cell.classList.add('arrival');
                }

                if (!cell.classList.contains('past') && !cell.classList.contains('booked')) {
                    cell.addEventListener('click', onDayClick);
                }
                grid.appendChild(cell);
            }
        }

        function onDayClick(e) {
            const ymd = e.currentTarget.dataset.date;
            if (!selStart || (selStart && selEnd)) {
                selStart = ymd; selEnd = null;
            } else {
                if (ymd <= selStart) { selStart = ymd; selEnd = null; }
                else {
                    // Check no booked dates inside range
                    let ok = true;
                    // Iterate day-by-day using Date only for iteration
                    const parts = selStart.split('-');
                    let cur = new Date(+parts[0], +parts[1] - 1, +parts[2] + 1);
                    const endParts = ymd.split('-');
                    const endDate = new Date(+endParts[0], +endParts[1] - 1, +endParts[2]);
                    while (cur < endDate) {
                        const cy = cur.getFullYear(), cm = cur.getMonth(), cd = cur.getDate();
                        const cymd = toYMD(cy, cm, cd);
                        if (bookedDates.has(cymd)) { ok = false; break; }
                        cur.setDate(cur.getDate() + 1);
                    }
                    if (ok) selEnd = ymd;
                    else { selStart = ymd; selEnd = null; }
                }
            }
            updateSelectionInfo();
            renderCalendar();
        }

        function updateSelectionInfo() {
            selArrival.textContent = selStart ? 'Příjezd: ' + fmtCZ(selStart) : 'Příjezd: —';
            selDepart.textContent = selEnd ? 'Odjezd: ' + fmtCZ(selEnd) : 'Odjezd: —';
            confirmBtn.disabled = !(selStart && selEnd);
        }


        function openModal(roomId, roomName) {
            currentRoom = roomId;
            selStart = null; selEnd = null;
            if (title) title.textContent = 'Obsazenost – ' + (roomName || 'apartmán');
            updateSelectionInfo();

            const now = new Date();
            viewYear = now.getFullYear();
            viewMonth = now.getMonth();

            // Load occupancy data
            bookedDates = new Set();
            fetch('plugins/booking-sync/api.php')
                .then(r => r.json())
                .then(data => {
                    if (data && data[roomId] && Array.isArray(data[roomId])) {
                        bookedDates = new Set(data[roomId]);
                    }
                    renderCalendar();
                })
                .catch(() => renderCalendar());

            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }

        // Nav buttons
        document.getElementById('avail-prev-month').addEventListener('click', () => {
            viewMonth--; if (viewMonth < 0) { viewMonth = 11; viewYear--; } renderCalendar();
        });
        document.getElementById('avail-next-month').addEventListener('click', () => {
            viewMonth++; if (viewMonth > 11) { viewMonth = 0; viewYear++; } renderCalendar();
        });
        document.getElementById('avail-prev-year').addEventListener('click', () => {
            viewYear--; renderCalendar();
        });
        document.getElementById('avail-next-year').addEventListener('click', () => {
            viewYear++; renderCalendar();
        });

        // Confirm — pre-fill form and scroll
        confirmBtn.addEventListener('click', () => {
            if (!selStart || !selEnd) return;
            const arrival = selStart, departure = selEnd;
            closeModal();

            // Pre-fill date inputs (selStart/selEnd are YYYY-MM-DD strings)
            const arrInput = document.querySelector('input[name="prijezd"]');
            const depInput = document.querySelector('input[name="odjezd"]');

            if (arrInput) {
                if (arrInput._flatpickr) {
                    arrInput._flatpickr.setDate(arrival, true);
                } else {
                    arrInput.value = arrival;
                    arrInput.dispatchEvent(new Event('input', { bubbles: true }));
                    arrInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
                const targetVisual = arrInput._flatpickr ? arrInput._flatpickr.altInput : arrInput;
                if (targetVisual) {
                    targetVisual.style.outline = '3px solid var(--primary, #8b5e3c)';
                    targetVisual.style.transition = 'outline 0.3s';
                    setTimeout(() => { targetVisual.style.outline = ''; }, 2500);
                }
            }

            if (depInput) {
                if (depInput._flatpickr) {
                    depInput._flatpickr.setDate(departure, true);
                } else {
                    depInput.value = departure;
                    depInput.dispatchEvent(new Event('input', { bubbles: true }));
                    depInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
                const targetVisual = depInput._flatpickr ? depInput._flatpickr.altInput : depInput;
                if (targetVisual) {
                    targetVisual.style.outline = '3px solid var(--primary, #8b5e3c)';
                    targetVisual.style.transition = 'outline 0.3s';
                    setTimeout(() => { targetVisual.style.outline = ''; }, 2500);
                }
            }

            // Scroll to reservation form
            const form = document.querySelector('#poptat-termin') ||
                document.querySelector('.contact-form') ||
                (arrInput ? arrInput.closest('section, form') : null);
            if (form) setTimeout(() => form.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
        });

        // Close handlers
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

        // Attach to all .open-room-calendar buttons
        document.querySelectorAll('.open-room-calendar').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(btn.dataset.room || '', btn.dataset.roomName || '');
            });
        });
    })();


    // --- GALLERY LOGIC ---
    const mainImg = document.getElementById('main-gallery-img');
    const thumbScroll = document.getElementById('thumb-scroll');

    if (mainImg && thumbScroll) {
        const thumbs = thumbScroll.querySelectorAll('img');
        const prevBtn = document.getElementById('prev-thumb');
        const nextBtn = document.getElementById('next-thumb');

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', (e) => {
                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
                const path = thumb.getAttribute('data-full') || thumb.src;
                mainImg.src = path;
            });
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                thumbScroll.scrollBy({ left: -250, behavior: 'smooth' });
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                thumbScroll.scrollBy({ left: 250, behavior: 'smooth' });
            });
        }

        const trigger = document.getElementById('main-gallery-trigger');
        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const allImgs = Array.from(thumbs).map(t => t.getAttribute('data-full') || t.src);
                openLightbox(mainImg.src, allImgs);
            });
        }
    }

    // --- LIGHTBOX & GALLERY NAVIGATION ---
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const prevBtn = document.getElementById('lightbox-prev');
    const nextBtn = document.getElementById('lightbox-next');
    const lightboxThumbs = document.getElementById('lightbox-thumbs');
    let currentGalleryImages = [];
    let currentIndex = 0;

    const updateLightbox = () => {
        if (currentGalleryImages[currentIndex]) {
            lightboxImg.src = currentGalleryImages[currentIndex];
            if (lightboxThumbs) {
                lightboxThumbs.querySelectorAll('img').forEach((thumb, idx) => {
                    if (idx === currentIndex) {
                        thumb.classList.add('active');
                        thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    } else {
                        thumb.classList.remove('active');
                    }
                });
            }
        }
    };

    const openLightbox = (src, group = []) => {
        if (!lightbox || !lightboxImg) return;

        if (group.length > 0) {
            currentGalleryImages = group;
            currentIndex = group.indexOf(src);
            if (currentIndex === -1) currentIndex = 0;
        } else {
            currentGalleryImages = [src];
            currentIndex = 0;
        }

        lightboxImg.src = currentGalleryImages[currentIndex];
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';

        if (lightboxThumbs) {
            lightboxThumbs.innerHTML = '';
            if (currentGalleryImages.length > 1) {
                currentGalleryImages.forEach((imgSrc, idx) => {
                    const thumb = document.createElement('img');
                    thumb.src = imgSrc;
                    if (idx === currentIndex) thumb.classList.add('active');
                    thumb.addEventListener('click', (e) => {
                        e.stopPropagation();
                        currentIndex = idx;
                        updateLightbox();
                    });
                    lightboxThumbs.appendChild(thumb);
                });
            }
        }

        if (currentGalleryImages.length > 1) {
            if (prevBtn) prevBtn.style.display = 'flex';
            if (nextBtn) nextBtn.style.display = 'flex';
        } else {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
        }
    };

    // Gallery Filter Logic
    const filterBtns = document.querySelectorAll('.gallery-filter .filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-grid .gallery-item');

    if (filterBtns.length > 0 && galleryItems.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // Global click listener for gallery items
    document.addEventListener('click', (e) => {
        const galleryImg = e.target.closest('.gallery-item img');
        const overlay = e.target.closest('.gallery-overlay');

        let targetImg = null;
        if (galleryImg) {
            targetImg = galleryImg;
        } else if (overlay) {
            targetImg = overlay.parentElement.querySelector('img');
        }

        if (targetImg) {
            e.preventDefault();
            const container = targetImg.closest('.gallery-grid') || targetImg.closest('.room-gallery') || targetImg.closest('.about-grid') || targetImg.closest('.horse-gallery');
            const imgs = container ? Array.from(container.querySelectorAll('img')).filter(img => {
                const parentItem = img.closest('.gallery-item');
                return !parentItem || (parentItem.style.display !== 'none' && getComputedStyle(parentItem).display !== 'none');
            }).map(img => img.src) : [targetImg.src];
            openLightbox(targetImg.src, imgs);
        }
    });

    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (currentGalleryImages.length > 1) {
                currentIndex = (currentIndex - 1 + currentGalleryImages.length) % currentGalleryImages.length;
                updateLightbox();
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (currentGalleryImages.length > 1) {
                currentIndex = (currentIndex + 1) % currentGalleryImages.length;
                updateLightbox();
            }
        });
    }

    if (lightbox) {
        const closeL = () => {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        };

        const closeBtn = lightbox.querySelector('.lightbox-close');
        if (closeBtn) closeBtn.addEventListener('click', (e) => { e.stopPropagation(); closeL(); });

        lightbox.addEventListener('click', (e) => { if (e.target === lightbox) closeL(); });

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === "Escape") closeL();
            if (e.key === "ArrowLeft" && currentGalleryImages.length > 1) {
                currentIndex = (currentIndex - 1 + currentGalleryImages.length) % currentGalleryImages.length;
                updateLightbox();
            }
            if (e.key === "ArrowRight" && currentGalleryImages.length > 1) {
                currentIndex = (currentIndex + 1) % currentGalleryImages.length;
                updateLightbox();
            }
        });
    }

    // Route Modal Logic with Dynamic Leaflet Map
    const routeModal = document.getElementById('route-modal');
    const stranoviceStart = [49.12386, 13.89667];
    let modalMap = null;

    const routeData = {
        'stranovice': {
            title: 'Straňovice a okolní rybník',
            description: 'Pohodová procházka v okolí našeho statku ve Straňovicích (Straňovice 1, Malenice). Trasa vede po vyhlídkových pastvinách k odpočinkové zóně u Straňovického rybníka.',
            highlights: ['Rybářská odpočinková zóna', 'Pohodová procházka v přírodě', '15 minut chůze od penzionu'],
            destCoords: [49.1255, 13.8860]
        },
        'malenice': {
            title: 'Procházka do Malenic & Památky',
            description: 'Příjemná trasa ze Straňovic 1 do centra obcí Malenice. Navštívit můžete opravenou faru se sezónními výstavami a barokní kostel sv. Jakuba.',
            highlights: ['Barokní kostel sv. Jakuba', 'Hřbitov (Z. Podskalský, J. Jirásková)', 'Opravená fara a letní kavárnička'],
            destCoords: [49.1292, 13.8828]
        },
        'mechorost': {
            title: 'Naučná stezka Skalka - Mechorost',
            description: 'Trasa ze Straňovic 1 směrem na Zlešice okolo kapličky sv. Václava na Hůrce. Nádherná lesní stezka s panoramatickým výhledem na údolí řeky Volyňky.',
            highlights: ['Kaplička sv. Václava na Hůrce', 'Výhledy na údolí řeky Volyňky', 'Naučné tabule o fauně a flóře'],
            destCoords: [49.1350, 13.8920]
        },
        'volyne_koupaliste': {
            title: 'Koupaliště Volyně',
            description: 'Trasa ze Straňovic 1 do Volyně na historické prvorepublikové koupaliště z roku 1939 s čistou průtokovou vodou.',
            highlights: ['Nejstarší přírodní koupaliště v ČR', 'Stylové dřevěné kabinky', 'Občerstvení a plavecký bazén'],
            destCoords: [49.1642, 13.8872]
        },
        'rohanov': {
            title: 'Přírodní koupaliště Rohanov',
            description: 'Cesta ze Straňovic 1 do Lhoty nad Rohanovem k průzračnému přírodnímu koupališti přímo pod šumavskými hřebeny.',
            highlights: ['Průzračná přírodní voda', 'Šumavské lesy v okolí', 'Dětské brouzdaliště a hřiště'],
            destCoords: [49.1415, 13.6820]
        },
        'wellness': {
            title: 'Sauny & Wellness centrum',
            description: 'Trasa ze Straňovic 1 do saunového světa v Prachaticích a plaveckého areálu ve Strakonicích s celoročním provozem.',
            highlights: ['Finská a parní sauna', 'Celoroční plavecký bazén', 'Relaxační zóny pro rodiny'],
            destCoords: [49.0125, 13.9980]
        },
        'zadov': {
            title: 'Ski areál Zadov',
            description: 'Pohodlná trasa autem ze Straňovic 1 do srdce zimních sportů na Zadově. Sjezdovky, lanovky, večerní lyžování a rozhledna.',
            highlights: ['Vyhřívaná rozhledna na můstku', 'Sjezdovky s večerním osvětlením', 'Půjčovny a lyžařská škola'],
            destCoords: [49.0667, 13.6333]
        },
        'kubovahut': {
            title: 'Kubova Huť & Sjezdovky',
            description: 'Trasa ze Straňovic 1 do nejvýše položené železniční stanice v ČR (995 m n. m.). Rodinný ski areál s tratěmi pod Boubínem.',
            highlights: ['Nejvyšší vlaková stanice v ČR', 'Sjezdovky pro rodiny s dětmi', 'Výchozí bod na Boubín'],
            destCoords: [48.9833, 13.7833]
        },
        'kvilda': {
            title: 'Kvilda & Běžecká stopa',
            description: 'Výpravná trasa ze Straňovic 1 na Kvildu. Nástupní místo na desítky kilometrů upravovaných běžeckých okruhů Bílé stopy v NP Šumava.',
            highlights: ['Bílá stopa Šumava', 'Informační středisko s jelením výběhem', 'Půjčovny běžek i kávárny'],
            destCoords: [49.0185, 13.5802]
        },
        'kasperk': {
            title: 'Cesta na Hrad Kašperk',
            description: 'Trasa ze Straňovic 1 pod hrad Kašperk. Z parkoviště pod hradem vede příjemná cesta lesem. Nejvyšší královský hrad v Čechách.',
            highlights: ['Výhled z hradních věží', 'Pustý hrádek', 'Interaktivní expozice pro děti'],
            destCoords: [49.1561, 13.5647]
        },
        'boubin': {
            title: 'Výšlap na Boubínský prales',
            description: 'Trasa ze Straňovic 1 k Idině Pile a Boubínskému jezírku. Výšlap na vrchol k rozhledně s výhledem až na Alpy.',
            highlights: ['Boubínské jezírko', 'Rozhledna s kruhovým výhledem', 'Zážitková stezka Idina Pila'],
            destCoords: [48.9772, 13.8117]
        },
        'mestecka': {
            title: 'Městečka a hrady (Volyně, Strakonice)',
            description: 'Výletní trasa ze Straňovic 1 po okruhu památek: Židovská synagoga Čkyně, Volyňská tvrz, zámek Vimperk a Strakonický hrad.',
            highlights: ['Židovská synagoga Čkyně', 'Strakonický hrad s věží Rumpál', 'Zámek a pivovar Vimperk'],
            destCoords: [49.2614, 13.9022]
        },
        'gastro': {
            title: 'Potraviny 24/7 & Hospůdky',
            description: 'Gastro doporučení ze Straňovic 1. Obchod COOP Jednota 24/7 v Malenicích, Malenická hospůdka Na Zámostí a kiosky Pod Věncem.',
            highlights: ['COOP Malenice 24/7 (nákup i v noci)', 'Malenická hospůdka Na Zámostí', 'Kiosky Pod Věncem v Lčovicích'],
            destCoords: [49.1290, 13.8830]
        }
    };

    document.querySelectorAll('.open-route-modal').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const routeKey = btn.getAttribute('data-route');
            let data = routeData[routeKey];
            if (window._tripTipsPluginData && Array.isArray(window._tripTipsPluginData)) {
                const found = window._tripTipsPluginData.find(t => t.id === routeKey);
                if (found) {
                    data = {
                        title: found.title,
                        description: found.description,
                        highlights: found.highlights || [found.badge, 'Vzdálenost: ' + found.distance, 'Doba: ' + found.time],
                        destCoords: found.coords
                    };
                }
            }

            const currentStart = (window._tripTipsPluginConfig && window._tripTipsPluginConfig.start_coords) ? window._tripTipsPluginConfig.start_coords : stranoviceStart;

            if (data && routeModal) {
                document.getElementById('route-title').textContent = data.title;
                document.getElementById('route-description').textContent = data.description;

                const mapyLink = document.getElementById('route-mapy-cz-link');
                if (mapyLink && data.destCoords) {
                    mapyLink.href = `https://mapy.cz/trasa?start=${currentStart[1]},${currentStart[0]}&end=${data.destCoords[1]},${data.destCoords[0]}`;
                }

                const highlightsList = document.getElementById('route-highlights');
                if (highlightsList) {
                    highlightsList.innerHTML = '';
                    data.highlights.forEach(h => {
                        const li = document.createElement('li');
                        li.style.display = 'flex';
                        li.style.alignItems = 'center';
                        li.style.gap = '6px';
                        li.style.fontSize = '0.9rem';
                        li.style.color = '#444';
                        li.innerHTML = `<i data-lucide="check-circle-2" style="width: 16px; height: 16px; color: var(--primary); flex-shrink:0;"></i> ${h}`;
                        highlightsList.appendChild(li);
                    });
                }

                if (typeof lucide !== 'undefined') lucide.createIcons();

                routeModal.style.display = "block";
                document.body.style.overflow = "hidden";

                // Initialize Leaflet Map inside Modal
                setTimeout(() => {
                    const mapContainer = document.getElementById('modal-map-container');
                    if (mapContainer && typeof L !== 'undefined') {
                        if (modalMap) {
                            modalMap.remove();
                        }

                        modalMap = L.map('modal-map-container').setView(currentStart, 11);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap'
                        }).addTo(modalMap);

                        // Pension Pin
                        const pIcon = L.divIcon({
                            className: 'custom-modal-pin',
                            html: `<div style="background:#2d5a27; color:white; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:15px; border:2px solid white; box-shadow:0 3px 6px rgba(0,0,0,0.3);">🏡</div>`,
                            iconSize: [32, 32],
                            iconAnchor: [16, 16]
                        });
                        const startAddressLabel = (window._tripTipsPluginConfig && window._tripTipsPluginConfig.pension_address) ? window._tripTipsPluginConfig.pension_address : 'Start: Straňovice 1';
                        L.marker(currentStart, { icon: pIcon }).addTo(modalMap).bindPopup(`<b>${startAddressLabel}</b>`);

                        // Destination Pin & Polyline
                        if (data.destCoords) {
                            const dIcon = L.divIcon({
                                className: 'custom-modal-pin',
                                html: `<div style="background:#6b8e23; color:white; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:15px; border:2px solid white; box-shadow:0 3px 6px rgba(0,0,0,0.3);">📍</div>`,
                                iconSize: [32, 32],
                                iconAnchor: [16, 16]
                            });
                            L.marker(data.destCoords, { icon: dIcon }).addTo(modalMap).bindPopup(`<b>Cíl: ${data.title}</b>`);

                            const routePolyline = L.polyline([currentStart, data.destCoords], {
                                color: '#2d5a27',
                                weight: 4,
                                opacity: 0.8,
                                dashArray: '6, 10'
                            }).addTo(modalMap);

                            modalMap.fitBounds(routePolyline.getBounds(), { padding: [40, 40] });
                        }
                    }
                }, 150);
            }
        });
    });

    if (routeModal) {
        const closeBtn = routeModal.querySelector('.close-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                routeModal.style.display = "none";
                document.body.style.overflow = "";
            });
        }
        window.addEventListener('click', (e) => {
            if (e.target == routeModal) {
                routeModal.style.display = "none";
                document.body.style.overflow = "";
            }
        });
    }


    let timelineYear = new Date().getFullYear();
    let timelineMonth = new Date().getMonth();
    let timelineNavInitialized = false;

    function initTimelineNav() {
        if (timelineNavInitialized) return;
        const prevYear = document.getElementById('timeline-prev-year');
        const prevMonth = document.getElementById('timeline-prev-month');
        const nextMonth = document.getElementById('timeline-next-month');
        const nextYear = document.getElementById('timeline-next-year');

        if (prevYear) {
            prevYear.addEventListener('click', () => {
                timelineYear--;
                renderTimeline();
            });
        }
        if (prevMonth) {
            prevMonth.addEventListener('click', () => {
                timelineMonth--;
                if (timelineMonth < 0) {
                    timelineMonth = 11;
                    timelineYear--;
                }
                renderTimeline();
            });
        }
        if (nextMonth) {
            nextMonth.addEventListener('click', () => {
                timelineMonth++;
                if (timelineMonth > 11) {
                    timelineMonth = 0;
                    timelineYear++;
                }
                renderTimeline();
            });
        }
        if (nextYear) {
            nextYear.addEventListener('click', () => {
                timelineYear++;
                renderTimeline();
            });
        }

        timelineNavInitialized = true;
    }

    function renderTimeline() {
        const container = document.getElementById('timeline-app');
        if (!container) return;

        initTimelineNav();

        const monthLabel = document.getElementById('timeline-month-label');
        const MONTHS_CS = ['Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'];
        const DAYS_SHORT_CS = ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'];

        if (monthLabel) {
            monthLabel.textContent = `${MONTHS_CS[timelineMonth]} ${timelineYear}`;
        }

        const rooms = [
            { id: "kocici", name: "Kočičí" },
            { id: "konsky", name: "Koňský" },
            { id: "kvetinovy", name: "Květinový" },
            { id: "babiccin", name: "Babiččin" },
            { id: "medovy", name: "Medový" }
        ];

        const daysInMonth = new Date(timelineYear, timelineMonth + 1, 0).getDate();
        const dates = [];
        for (let d = 1; d <= daysInMonth; d++) {
            dates.push(new Date(timelineYear, timelineMonth, d));
        }

        const now = new Date();
        const todayStr = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
        const occupancy = window.occupancyData || {};

        let html = '<table class="timeline-table"><thead><tr><th>Pokoj</th>';
        dates.forEach(d => {
            const dayNum = d.getDate();
            const dayOfWeek = DAYS_SHORT_CS[d.getDay()];
            const isWeekend = (d.getDay() === 0 || d.getDay() === 6);
            const weekendStyle = isWeekend ? ' style="background:#f3e8cf; color:var(--primary-dark);"' : '';
            html += `<th${weekendStyle} title="${dayNum}. ${MONTHS_CS[timelineMonth]} (${dayOfWeek})"><span style="font-size:0.7rem; opacity:0.8; display:block;">${dayOfWeek}</span>${dayNum}.</th>`;
        });
        html += '</tr></thead><tbody>';

        rooms.forEach(room => {
            html += `<tr><td>${room.name}</td>`;
            const roomOccupancy = occupancy[room.id] || [];
            dates.forEach(d => {
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                const dateStr = `${year}-${month}-${day}`;
                const isOccupied = roomOccupancy.includes(dateStr);
                const isToday = (dateStr === todayStr);

                let classes = isOccupied ? 'status-occupied' : 'status-free';
                if (isToday) classes += ' is-today';

                const titleText = `${room.name} – ${d.getDate()}. ${MONTHS_CS[timelineMonth]} ${year}: ${isOccupied ? 'Obsazeno' : 'Volno'}`;
                html += `<td class="${classes}" title="${titleText}"></td>`;
            });
            html += '</tr>';
        });
        html += '</tbody></table>';
        container.innerHTML = html;
    }

    const initContactFormValidation = () => {
        const form = document.querySelector('.contact-form');
        if (!form) return;

        const arrivalInput = form.querySelector('input[type="date"]:nth-of-type(1)') || form.querySelectorAll('input[type="date"]')[0];
        const departureInput = form.querySelector('input[type="date"]:nth-of-type(2)') || form.querySelectorAll('input[type="date"]')[1];
        const submitBtn = form.querySelector('button[type="submit"]');
        const roomInput = form.querySelector('input[name="room"]');

        if (!arrivalInput || !departureInput || !submitBtn) return;

        const warningDiv = document.createElement('div');
        warningDiv.className = 'booking-warning';
        warningDiv.style.display = 'none';

        const dateRow = arrivalInput.closest('.form-row');
        if (dateRow) {
            dateRow.after(warningDiv);
        }

        const roomMapping = {
            "Květinový apartmán": "kvetinovy",
            "Koňský apartmán": "konsky",
            "Kočičí apartmán": "kocici",
            "Babiččin apartmán": "babiccin",
            "Medový apartmán": "medovy"
        };

        const roomName = roomInput ? roomInput.value : '';
        const roomId = roomMapping[roomName];
        const occupiedDates = (window.occupancyData && roomId) ? (window.occupancyData[roomId] || []) : [];

        let fpArrival = null;
        let fpDeparture = null;

        const checkOccupancy = () => {
            const arrivalVal = arrivalInput.value;
            const departureVal = departureInput.value;

            arrivalInput.style.borderColor = '';
            departureInput.style.borderColor = '';
            warningDiv.style.display = 'none';
            warningDiv.innerHTML = '';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '';

            if (!arrivalVal || !departureVal) return;

            const arrivalDate = new Date(arrivalVal);
            const departureDate = new Date(departureVal);

            if (arrivalDate >= departureDate) {
                warningDiv.innerHTML = '⚠️ Datum odjezdu musí být po datu příjezdu.';
                warningDiv.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
                return;
            }

            const datesToCheck = [];
            let current = new Date(arrivalDate);
            while (current < departureDate) {
                const year = current.getFullYear();
                const month = String(current.getMonth() + 1).padStart(2, '0');
                const day = String(current.getDate()).padStart(2, '0');
                datesToCheck.push(`${year}-${month}-${day}`);
                current.setDate(current.getDate() + 1);
            }

            const overlaps = datesToCheck.filter(d => occupiedDates.includes(d));

            if (overlaps.length > 0) {
                const formattedOverlaps = overlaps.map(d => {
                    const parts = d.split('-');
                    return `${parseInt(parts[2])}.${parseInt(parts[1])}.`;
                }).join(', ');

                warningDiv.innerHTML = `⚠️ Vybraný termín koliduje s jinou rezervací. Apartmán je již obsazen v tyto dny: <strong>${formattedOverlaps}</strong>.`;
                warningDiv.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
            }
        };

        if (typeof flatpickr !== 'undefined') {
            flatpickr.localize(flatpickr.l10ns.cs);

            fpArrival = flatpickr(arrivalInput, {
                locale: "cs",
                minDate: "today",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j. n. Y",
                disable: occupiedDates,
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    const d = dayElem.dateObj;
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    const localDateStr = `${year}-${month}-${day}`;
                    if (occupiedDates.includes(localDateStr)) {
                        dayElem.classList.add("occupied-day");
                    }
                },
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        fpDeparture.set("minDate", nextDay);

                        const arrivalMs = selectedDates[0].getTime();
                        let nextOccupied = null;
                        occupiedDates.forEach(d => {
                            const occMs = new Date(d).getTime();
                            if (occMs >= arrivalMs) {
                                if (!nextOccupied || occMs < nextOccupied.getTime()) {
                                    nextOccupied = new Date(occMs);
                                }
                            }
                        });

                        if (nextOccupied) {
                            fpDeparture.set("maxDate", nextOccupied);
                        } else {
                            fpDeparture.set("maxDate", null);
                        }

                        setTimeout(() => fpDeparture.open(), 50);
                    }
                    checkOccupancy();
                }
            });

            fpDeparture = flatpickr(departureInput, {
                locale: "cs",
                minDate: "today",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j. n. Y",
                disable: occupiedDates,
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    const d = dayElem.dateObj;
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    const localDateStr = `${year}-${month}-${day}`;
                    if (occupiedDates.includes(localDateStr)) {
                        dayElem.classList.add("occupied-day");
                    }
                },
                onChange: function (selectedDates, dateStr, instance) {
                    checkOccupancy();
                }
            });
        } else {
            const todayStr = new Date().toISOString().split('T')[0];
            arrivalInput.min = todayStr;

            arrivalInput.addEventListener('change', () => {
                if (arrivalInput.value) {
                    departureInput.min = arrivalInput.value;
                }
                checkOccupancy();
            });
            departureInput.addEventListener('change', checkOccupancy);
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const originalText = submitBtn.innerText;
            submitBtn.innerText = 'Odesílám...';
            submitBtn.disabled = true;

            const formData = new FormData(form);

            fetch('send.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        submitBtn.innerText = 'Děkujeme! Ozveme se vám.';
                        submitBtn.style.backgroundColor = '#4A5D23';
                        form.reset();
                        if (fpArrival) fpArrival.clear();
                        if (fpDeparture) fpDeparture.clear();
                    } else {
                        alert(data.message || 'Chyba při odesílání formuláře.');
                        submitBtn.innerText = originalText;
                    }
                })
                .catch(err => {
                    alert('Chyba při komunikaci se serverem. Zkontrolujte prosím připojení.');
                    submitBtn.innerText = originalText;
                })
                .finally(() => {
                    setTimeout(() => {
                        submitBtn.innerText = originalText;
                        submitBtn.disabled = false;
                        submitBtn.style.backgroundColor = '';
                        checkOccupancy();
                    }, 4000);
                });
        });
    };

    // Initialize Validation
    initContactFormValidation();

    // --- ROOM CALENDAR MODAL LOGIC ---
    const initRoomCalendarModal = () => {
        const modal = document.getElementById('room-calendar-modal');
        if (!modal) return;

        const titleEl = document.getElementById('room-calendar-title');
        const prevBtn = document.getElementById('cal-prev-month');
        const nextBtn = document.getElementById('cal-next-month');
        const monthSelect = document.getElementById('cal-month-select');
        const yearSelect = document.getElementById('cal-year-select');
        const daysGrid = document.getElementById('calendar-days-grid');
        const closeBtn = modal.querySelector('.close-modal');
        const reserveActionBtn = document.getElementById('cal-reserve-action-btn');
        const selectionInfo = document.getElementById('cal-selection-info');
        const selectedRangeText = document.getElementById('cal-selected-range-text');

        const monthNames = [
            'Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen',
            'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'
        ];

        let activeRoomId = '';
        let activeRoomName = '';
        let viewYear = new Date().getFullYear();
        let viewMonth = new Date().getMonth();
        let selectedArrival = null;  // YYYY-MM-DD
        let selectedDeparture = null;  // YYYY-MM-DD

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
                    selectedRangeText.innerText = `${formatCzechDate(selectedArrival)} – ${formatCzechDate(selectedDeparture)}`;
            } else if (selectedArrival) {
                selectionInfo.style.display = 'block';
                if (selectedRangeText)
                    selectedRangeText.innerText = `${formatCzechDate(selectedArrival)} (vyberte odjezd)`;
            } else {
                selectionInfo.style.display = 'none';
                if (selectedRangeText) selectedRangeText.innerText = '';
            }
        };

        const populateSelects = () => {
            if (!monthSelect || !yearSelect) return;
            monthSelect.innerHTML = monthNames.map((m, i) => `<option value="${i}">${m}</option>`).join('');
            const yr = new Date().getFullYear();
            yearSelect.innerHTML = [yr - 1, yr, yr + 1, yr + 2].map(y => `<option value="${y}">${y}</option>`).join('');
        };

        const renderCalendar = () => {
            if (!daysGrid) return;
            monthSelect.value = viewMonth;
            yearSelect.value = viewYear;

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const occupancy = (window.occupancyData && activeRoomId)
                ? (window.occupancyData[activeRoomId] || []) : [];

            const firstDayRaw = new Date(viewYear, viewMonth, 1).getDay();
            const startDayOffset = firstDayRaw === 0 ? 6 : firstDayRaw - 1;
            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

            let html = '';
            for (let i = 0; i < startDayOffset; i++) html += `<div class="cal-day-cell empty"></div>`;

            for (let d = 1; d <= daysInMonth; d++) {
                const dateObj = new Date(viewYear, viewMonth, d);
                dateObj.setHours(0, 0, 0, 0);
                const mm = String(viewMonth + 1).padStart(2, '0');
                const dd = String(d).padStart(2, '0');
                const iso = `${viewYear}-${mm}-${dd}`;

                const isOcc = occupancy.includes(iso);
                const isPast = dateObj < today;
                const isTod = dateObj.getTime() === today.getTime();

                const cls = ['cal-day-cell'];
                if (isPast) cls.push('past');
                if (isTod) cls.push('today');
                cls.push(isOcc ? 'occupied' : 'free');

                if (iso === selectedArrival) cls.push('selected-start');
                else if (iso === selectedDeparture) cls.push('selected-end');
                else if (selectedArrival && selectedDeparture && iso > selectedArrival && iso < selectedDeparture)
                    cls.push('in-range');

                html += `<div class="${cls.join(' ')}" data-date="${iso}">
                    <span class="cal-day-number">${d}</span>
                    <span class="cal-day-status">${isOcc ? 'Obsazeno' : 'Volno'}</span>
                </div>`;
            }
            daysGrid.innerHTML = html;

            // Klik pouze na volné, budoucí dny
            daysGrid.querySelectorAll('.cal-day-cell.free:not(.past)').forEach(cell => {
                cell.addEventListener('click', () => {
                    const clicked = cell.getAttribute('data-date');
                    if (!clicked) return;

                    if (!selectedArrival || (selectedArrival && selectedDeparture)) {
                        selectedArrival = clicked; selectedDeparture = null;
                    } else if (clicked > selectedArrival) {
                        const occ = (window.occupancyData && activeRoomId)
                            ? (window.occupancyData[activeRoomId] || []) : [];
                        const conflict = occ.some(od => od >= selectedArrival && od <= clicked);
                        if (conflict) { selectedArrival = clicked; selectedDeparture = null; }
                        else { selectedDeparture = clicked; }
                    } else {
                        selectedArrival = clicked; selectedDeparture = null;
                    }
                    updateSelectionUI();
                    renderCalendar();
                });
            });
        };

        const openModal = (roomId, roomName) => {
            activeRoomId = roomId;
            activeRoomName = roomName || 'Apartmán';
            if (titleEl) titleEl.innerText = `Obsazenost – ${activeRoomName}`;
            selectedArrival = null; selectedDeparture = null;
            updateSelectionUI();
            viewYear = new Date().getFullYear(); viewMonth = new Date().getMonth();
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

        // Tlačítko Rezervovat – přenese data do formuláře a scrolluje k němu
        if (reserveActionBtn) {
            reserveActionBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const savedArrival = selectedArrival;
                const savedDeparture = selectedDeparture;
                closeModal();

                setTimeout(() => {
                    const form = document.querySelector('.contact-form');
                    if (form) {
                        // Flatpickr mění type date inputu – hledáme podle _flatpickr instance
                        const fpInputs = Array.from(form.querySelectorAll('input')).filter(i => i._flatpickr);
                        const arrInput = fpInputs[0];
                        const depInput = fpInputs[1];

                        if (arrInput && savedArrival) {
                            arrInput._flatpickr.setDate(savedArrival, true);
                        }
                        if (depInput && savedDeparture) {
                            depInput._flatpickr.setDate(savedDeparture, true);
                        }

                        const target = document.getElementById('poptat-termin') || form;
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else if (activeRoomId) {
                        const slugs = {
                            babiccin: 'babiccin.php', kocici: 'kocici.php',
                            konsky: 'konsky.php', kvetinovy: 'kvetinovy.php', medovy: 'medovy.php'
                        };
                        const params = new URLSearchParams();
                        if (savedArrival) params.set('arrival', savedArrival);
                        if (savedDeparture) params.set('departure', savedDeparture);
                        const qs = params.toString() ? `?${params.toString()}` : '';
                        window.location.href = `${slugs[activeRoomId] || activeRoomId + '.php'}#poptat-termin${qs}`;
                    }
                }, 200);
            });
        }

        populateSelects();

        document.querySelectorAll('.open-room-calendar').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                openModal(btn.getAttribute('data-room'), btn.getAttribute('data-room-name'));
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (prevBtn) prevBtn.addEventListener('click', () => { viewMonth === 0 ? (viewMonth = 11, viewYear--) : viewMonth--; renderCalendar(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { viewMonth === 11 ? (viewMonth = 0, viewYear++) : viewMonth++; renderCalendar(); });
        if (monthSelect) monthSelect.addEventListener('change', e => { viewMonth = parseInt(e.target.value, 10); renderCalendar(); });
        if (yearSelect) yearSelect.addEventListener('change', e => { viewYear = parseInt(e.target.value, 10); renderCalendar(); });
        window.addEventListener('click', e => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape' && modal.style.display === 'flex') closeModal(); });
    };

    initRoomCalendarModal();
});

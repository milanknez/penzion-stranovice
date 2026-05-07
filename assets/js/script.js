/* 
    Statek Penzón - Interactions 
*/

document.addEventListener('DOMContentLoaded', () => {
    // Lucide Icons (Base)
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
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

    // Simple Intersection Observer (Reveal animations)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal, .reveal-up').forEach(el => {
        observer.observe(el);
    });

    // Integrated Map (Leaflet)
    // Guarded check for L and map element
    if (document.getElementById('map') && typeof L !== 'undefined') {
        const map = L.map('map', { scrollWheelZoom: false }).setView([49.1227511, 13.9021071], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const points = [
            { pos: [49.1227511, 13.9021071], title: "Statek Straňovice", desc: "Váš výchozí bod pro objevování." },
            { pos: [49.128, 13.918], title: "Malenická kaplička", desc: "Historické místo s krásným výhledem." },
            { pos: [49.120, 13.910], title: "Jezdecký areál", desc: "Vyjížďky na koních pro dospělé i děti." },
            { pos: [49.115, 13.905], title: "Vlaková zastávka", desc: "Spojení s okolními městy." }
        ];

        points.forEach(p => {
            L.marker(p.pos).addTo(map).bindPopup(`<strong>${p.title}</strong><br>${p.desc}`);
        });
    }

    // Form Submission
    const form = document.querySelector('.contact-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = form.querySelector('button');
            const originalText = btn.innerText;
            btn.innerText = 'Odesílám...';
            btn.disabled = true;
            setTimeout(() => {
                btn.innerText = 'Děkujeme! Ozveme se vám.';
                btn.style.backgroundColor = '#4A5D23';
                form.reset();
                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                    btn.style.backgroundColor = '';
                }, 3000);
            }, 1500);
        });
    }

    // --- SHARED COMPONENTS INTERACTION ---
    const initSharedComponents = () => {
        // Mobile Menu Toggle
        const mobileToggle = document.getElementById('mobile-toggle');
        const navLinks = document.querySelector('.nav-links');
        if (mobileToggle && navLinks) {
            mobileToggle.onclick = () => navLinks.classList.toggle('active');
        }

        // Shared Timeline Modal Trigger
        const timelineModal = document.getElementById('timeline-modal');
        const openTimelineBtn = document.getElementById('open-timeline');
        if (timelineModal && openTimelineBtn) {
            const closeTimelineBtn = timelineModal.querySelector('.close-modal');
            openTimelineBtn.addEventListener('click', (e) => {
                e.preventDefault();
                timelineModal.style.display = "block";
                renderSharedTimeline();
            });
            if (closeTimelineBtn) closeTimelineBtn.onclick = () => { timelineModal.style.display = "none"; };
            window.addEventListener('click', (e) => { if (e.target == timelineModal) timelineModal.style.display = "none"; });
        }

        // Shared Lightbox Close
        const lightbox = document.getElementById('lightbox');
        if (lightbox) {
            const closeL = () => { lightbox.classList.remove('active'); document.body.style.overflow = ''; };
            const lightboxClose = lightbox.querySelector('.lightbox-close');
            if (lightboxClose) lightboxClose.addEventListener('click', closeL);
            lightbox.addEventListener('click', (e) => { if (e.target === lightbox) closeL(); });
        }

        // Final icon check for newly injected elements
        if (window.lucide) window.lucide.createIcons();
    };

    // Robust listener for shared components
    if (window.componentsLoaded) {
        initSharedComponents();
    } else {
        document.addEventListener('componentsLoaded', initSharedComponents);
    }

    // --- SHARED ROOM GALLERY LOGIC ---
    const mainImg = document.getElementById('main-gallery-img');
    const thumbScroll = document.getElementById('thumb-scroll');
    if (mainImg && thumbScroll) {
        const thumbs = thumbScroll.querySelectorAll('img');
        const prevBtn = document.getElementById('prev-thumb');
        const nextBtn = document.getElementById('next-thumb');
        const trigger = document.getElementById('main-gallery-trigger');

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
                mainImg.src = thumb.src;
            });
        });

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => thumbScroll.scrollBy({ left: -200, behavior: 'smooth' }));
            nextBtn.addEventListener('click', () => thumbScroll.scrollBy({ left: 200, behavior: 'smooth' }));
        }

        if (trigger) {
            trigger.addEventListener('click', () => {
                const lightbox = document.getElementById('lightbox');
                const lightboxImg = document.getElementById('lightbox-img');
                if (lightbox && lightboxImg) {
                    lightboxImg.src = mainImg.src;
                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        }
    }

    function renderSharedTimeline() {
        const container = document.getElementById('timeline-app');
        if (!container) return;
        const rooms = ["Kočičí apartmán", "Koňský apartmán", "Květinový apartmán"];
        const days = [];
        const now = new Date();
        for(let i=0; i<14; i++) {
            const d = new Date();
            d.setDate(now.getDate() + i);
            days.push({ day: d.getDate(), month: d.getMonth() + 1, isToday: i === 0 });
        }
        const occupancy = {
            "Kočičí apartmán": [0,0,1,1,1,0,0,0,1,1,0,0,0,0],
            "Koňský apartmán": [1,1,0,0,0,1,1,1,0,0,0,0,1,1],
            "Květinový apartmán": [0,0,0,0,0,0,1,1,0,0,0,1,1,0]
        };
        let html = '<table class="timeline-table"><thead><tr><th class="timeline-room-name">Pokoj</th>';
        days.forEach(d => { html += `<th class="${d.isToday ? 'status-today' : ''}">${d.day}.<br>${d.month}.</th>`; });
        html += '</tr></thead><tbody>';
        rooms.forEach(room => {
            html += `<tr><td class="timeline-room-name">${room}</td>`;
            const data = occupancy[room] || Array(14).fill(0);
            data.forEach((isOccupied, idx) => {
                html += `<td class="${isOccupied ? 'status-occupied' : 'status-free'} ${days[idx].isToday ? 'status-today' : ''}"></td>`;
            });
            html += '</tr>';
        });
        html += '</tbody></table>';
        container.innerHTML = html;
    }
});

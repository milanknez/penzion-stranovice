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

    // Map (Leaflet)
    if (document.getElementById('map') && typeof L !== 'undefined') {
        const mapElement = document.getElementById('map');
        if (mapElement) {
            const map = L.map('map', { scrollWheelZoom: false }).setView([49.1227511, 13.9021071], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            L.marker([49.1227511, 13.9021071]).addTo(map).bindPopup('<strong>Statek Straňovice</strong>');
        }
    }

    // Mobile Menu & Dropdowns
    const mobileToggle = document.getElementById('mobile-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileToggle && navLinks) {
        // Toggle menu on click
        mobileToggle.onclick = (e) => {
            e.stopPropagation();
            navLinks.classList.toggle('active');
            // Toggle icon if needed (optional)
        };

        // Close menu when clicking a link (but NOT a dropdown toggle)
        navLinks.querySelectorAll('a:not(.has-dropdown)').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && e.target !== mobileToggle) {
                navLinks.classList.remove('active');
            }
        });
    }

    // Mobile Dropdown toggles
    document.querySelectorAll('.has-dropdown').forEach(dropdown => {
        dropdown.onclick = (e) => {
            if (window.innerWidth <= 1150) { // Changed from 992 to match burger menu breakpoint
                e.preventDefault();
                e.stopPropagation();
                dropdown.parentElement.classList.toggle('active');
            }
        };
    });

    // Timeline Modal
    const timelineModal = document.getElementById('timeline-modal');
    const openTimelineBtns = document.querySelectorAll('#open-timeline, .open-timeline');
    if (timelineModal && openTimelineBtns.length > 0) {
        const closeBtn = timelineModal.querySelector('.close-modal');
        openTimelineBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                timelineModal.style.display = "block";
                renderTimeline();
            });
        });
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                timelineModal.style.display = "none";
            });
        }
        window.addEventListener('click', (e) => {
            if (e.target == timelineModal) timelineModal.style.display = "none";
        });
    }

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
                
                // Get image path
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
            // Okamžitá změna src bez blikání (bez opacity 0)
            lightboxImg.src = currentGalleryImages[currentIndex];
            
            // Aktualizace aktivní miniatury v lightboxu
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

        // Vygenerování miniatur do spodního panelu
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
            const imgs = container ? Array.from(container.querySelectorAll('img')).map(img => img.src) : [targetImg.src];
            
            console.log("Opening lightbox for:", targetImg.src);
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

    // Route Modal Logic
    const routeModal = document.getElementById('route-modal');
    const routeData = {
        'malenice': {
            title: 'Procházka Malenicemi',
            description: 'Pohodová procházka z našeho statku do centra obce. Trasa vede po málo frekventované asfaltové cestě, vhodná i pro kočárky.',
            highlights: ['Barokní kostel sv. Jakuba', 'Hřbitov s hrobem Z. Podskalského', 'Místní mlýn'],
            mapImg: 'assets/img/map_malenice.png'
        },
        'kasperk': {
            title: 'Cesta na Hrad Kašperk',
            description: 'Z parkoviště pod hradem vede příjemná cesta lesem. Samotný hrad nabízí unikátní prohlídkové okruhy zaměřené na stavbu hradu i život v podhradí.',
            highlights: ['Výhled z hradních věží', 'Pustý hrádek', 'Interaktivní expozice pro děti'],
            mapImg: 'assets/img/map_kasperk.png'
        },
        'boubin': {
            title: 'Výšlap na Boubín',
            description: 'Trasa z Kaplice k jezírku a dále na vrchol k rozhledně. Cesta vede srdcem pralesa po dřevěných chodníčcích a lesních pěšinách.',
            highlights: ['Boubínské jezírko', 'Rozhledna s kruhovým výhledem', 'Zážitková stezka Idina Pila'],
            mapImg: 'assets/img/map_boubin.png'
        }
    };

    document.querySelectorAll('.open-route-modal').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const routeKey = btn.getAttribute('data-route');
            const data = routeData[routeKey];
            
            if (data && routeModal) {
                document.getElementById('route-title').textContent = data.title;
                document.getElementById('route-description').textContent = data.description;
                
                // Update Map
                const mapPlaceholder = document.querySelector('.route-map-placeholder');
                if (mapPlaceholder && data.mapImg) {
                    mapPlaceholder.innerHTML = `<img src="${data.mapImg}" alt="${data.title}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 12px;">`;
                    mapPlaceholder.style.background = 'white';
                }

                const highlightsList = document.getElementById('route-highlights');
                highlightsList.innerHTML = '';
                data.highlights.forEach(h => {
                    const li = document.createElement('li');
                    li.innerHTML = `<i data-lucide="check" style="width: 16px; height: 16px; color: var(--primary); margin-right: 8px; vertical-align: middle;"></i> ${h}`;
                    highlightsList.appendChild(li);
                });
                
                if (typeof lucide !== 'undefined') lucide.createIcons();
                
                routeModal.style.display = "block";
                document.body.style.overflow = "hidden";
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

    function renderTimeline() {
        const container = document.getElementById('timeline-app');
        if (!container) return;
        const rooms = [
            { id: "kocici", name: "Kočičí apartmán" },
            { id: "konsky", name: "Koňský apartmán" },
            { id: "kvetinovy", name: "Květinový apartmán" },
            { id: "babiccin", name: "Babiččin apartmán" },
            { id: "medovy", name: "Medový apartmán" }
        ];
        const now = new Date();
        const dates = [];
        for(let i=0; i<14; i++) {
            const d = new Date();
            d.setDate(now.getDate() + i);
            dates.push(d);
        }
        
        const occupancy = window.occupancyData || {};
        
        let html = '<table class="timeline-table"><thead><tr><th>Pokoj</th>';
        dates.forEach(d => {
            html += `<th>${d.getDate()}.${d.getMonth()+1}.</th>`;
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
                const statusClass = isOccupied ? 'status-occupied' : 'status-free';
                html += `<td class="${statusClass}"></td>`;
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

        // Create a warning message container below the date fields
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

        const roomName = roomInput.value;
        const roomId = roomMapping[roomName];
        const occupiedDates = (window.occupancyData && roomId) ? (window.occupancyData[roomId] || []) : [];

        let fpArrival = null;
        let fpDeparture = null;

        // Validation / Check occupancy logic (for warnings & fallback)
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
            // Localize to Czech
            flatpickr.localize(flatpickr.l10ns.cs);

            fpArrival = flatpickr(arrivalInput, {
                locale: "cs",
                minDate: "today",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j. n. Y",
                disable: occupiedDates,
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const d = dayElem.dateObj;
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    const localDateStr = `${year}-${month}-${day}`;
                    if (occupiedDates.includes(localDateStr)) {
                        dayElem.classList.add("occupied-day");
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        
                        // Set minimum date of departure to arrival + 1 day
                        fpDeparture.set("minDate", nextDay);

                        // Find the next occupied date after selected arrival
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

                        // Limit departure maxDate so they cannot select a range containing occupied nights
                        if (nextOccupied) {
                            fpDeparture.set("maxDate", nextOccupied);
                        } else {
                            fpDeparture.set("maxDate", null);
                        }

                        // Auto-open departure calendar
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
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const d = dayElem.dateObj;
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    const localDateStr = `${year}-${month}-${day}`;
                    if (occupiedDates.includes(localDateStr)) {
                        dayElem.classList.add("occupied-day");
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    checkOccupancy();
                }
            });
        } else {
            // Fallback for native inputs
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

        // Form Submit Simulation
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const originalText = submitBtn.innerText;
            submitBtn.innerText = 'Odesílám...';
            submitBtn.disabled = true;
            setTimeout(() => {
                submitBtn.innerText = 'Děkujeme! Ozveme se vám.';
                submitBtn.style.backgroundColor = '#4A5D23';
                form.reset();
                if (fpArrival) fpArrival.clear();
                if (fpDeparture) fpDeparture.clear();
                setTimeout(() => {
                    submitBtn.innerText = originalText;
                    submitBtn.disabled = false;
                    submitBtn.style.backgroundColor = '';
                    checkOccupancy();
                }, 3000);
            }, 1500);
        });
    };

    // Initialize Validation
    initContactFormValidation();
});

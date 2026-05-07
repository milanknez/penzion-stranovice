<!-- Lightbox Modal -->
<div class="lightbox" id="lightbox">
    <span class="lightbox-close">&times;</span>
    <button class="lightbox-nav lightbox-prev" id="lightbox-prev"><i data-lucide="chevron-left"></i></button>
    <div class="lightbox-content">
        <img src="" alt="Zvětšený náhled" id="lightbox-img">
    </div>
    <button class="lightbox-nav lightbox-next" id="lightbox-next"><i data-lucide="chevron-right"></i></button>
</div>

<!-- Timeline Modal -->
<div class="modal" id="timeline-modal">
    <div class="modal-content" style="max-width: 1100px;">
        <span class="close-modal">&times;</span>
        <h2 class="section-title">Timeline obsazenosti</h2>
        <p class="text-center" style="margin-bottom: 2rem;">Aktuální přehled volných termínů v našem penzionu.</p>
        
        <div class="timeline-container" id="timeline-app">
            <p style="text-align: center; padding: 2rem;">Načítám data o obsazenosti...</p>
        </div>

        <div class="text-center mt-2">
            <p style="font-size: 0.8rem; color: var(--text-muted);">Legenda: <span style="display: inline-block; width: 15px; height: 15px; background: #eaf0e0; vertical-align: middle;"></span> Volno | <span style="display: inline-block; width: 15px; height: 15px; background: #fee; vertical-align: middle;"></span> Obsazeno</p>
        </div>
    </div>
</div>

<!-- Route Modal -->
<div class="modal" id="route-modal">
    <div class="modal-content" style="max-width: 900px;">
        <span class="close-modal">&times;</span>
        <div id="route-details">
            <h2 class="section-title" id="route-title">Detail trasy</h2>
            <div class="route-map-placeholder" style="background: var(--bg-light); border-radius: 12px; height: 400px; display: flex; align-items: center; justify-content: center; margin-bottom: 2rem; border: 1px solid var(--border);">
                <div class="text-center">
                    <i data-lucide="map-pin" style="width: 48px; height: 48px; color: var(--primary); margin-bottom: 1rem;"></i>
                    <p>Mapa trasy se připravuje...</p>
                </div>
            </div>
            <div class="route-info-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h4>Popis cesty</h4>
                    <p id="route-description">Detailní popis trasy bude doplněn.</p>
                </div>
                <div>
                    <h4>Zajímavosti na cestě</h4>
                    <ul id="route-highlights" style="list-style: none; padding: 0;">
                        <!-- Highlights will be injected here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

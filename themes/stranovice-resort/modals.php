<!-- Shared Modals Component -->
<div id="timeline-modal" class="modal">
    <div class="modal-content" style="max-width: 1050px; width: 95vw;">
        <span class="close-modal">&times;</span>
        <h2 style="margin-top: 0; color: var(--primary);">Harmonogram obsazenosti pokojů</h2>
        <p style="color: #666; margin-bottom: 1.2rem;">Přehled volných a obsazených termínů pro vybraný měsíc a rok.</p>
        
        <div class="timeline-nav-wrapper">
            <div class="timeline-nav-group">
                <button type="button" class="timeline-nav-btn" id="timeline-prev-year" title="Předchozí rok">&laquo; Rok</button>
                <button type="button" class="timeline-nav-btn" id="timeline-prev-month" title="Předchozí měsíc">&lsaquo; Měsíc</button>
            </div>
            
            <div class="timeline-month-label" id="timeline-month-label">
                <!-- Javascript will inject e.g. Srpen 2026 -->
            </div>
            
            <div class="timeline-nav-group">
                <button type="button" class="timeline-nav-btn" id="timeline-next-month" title="Další měsíc">Měsíc &rsaquo;</button>
                <button type="button" class="timeline-nav-btn" id="timeline-next-year" title="Další rok">Rok &raquo;</button>
            </div>
        </div>

        <div class="timeline-container" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border: 1px solid var(--border); border-radius: 8px; max-height: 60vh;">
            <div id="timeline-app"></div>
        </div>

        <div style="margin-top: 1.2rem; display: flex; gap: 1.5rem; font-size: 0.9rem; flex-wrap: wrap; align-items: center;">
            <span style="display: flex; align-items: center; gap: 0.5rem;"><span style="width: 14px; height: 14px; background: #EAF0E0; border: 1px solid #4caf50; border-radius: 3px; display: inline-block;"></span> Volno</span>
            <span style="display: flex; align-items: center; gap: 0.5rem;"><span style="width: 14px; height: 14px; background: #FEEEEE; border: 1px solid #f44336; border-radius: 3px; display: inline-block;"></span> Obsazeno</span>
            <span style="display: flex; align-items: center; gap: 0.5rem;"><span style="width: 14px; height: 14px; background: #FAF3E3; border: 1px solid #dcd1ba; border-radius: 3px; display: inline-block;"></span> Dnes</span>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="lightbox">
    <!-- Navigační tlačítka — absolutně vůči .lightbox (full-screen overlay) -->
    <button id="lightbox-prev" class="lightbox-nav lightbox-prev">&lsaquo;</button>
    <button id="lightbox-next" class="lightbox-nav lightbox-next">&rsaquo;</button>
    <span class="lightbox-close">&times;</span>
    <!-- Obsah — centrovaný obal -->
    <div class="lightbox-wrapper">
        <img id="lightbox-img" src="" alt="Zvětšený náhled">
        <div id="lightbox-thumbs" class="lightbox-thumbs"></div>
    </div>
</div>

<!-- Availability Calendar Modal -->
<div id="avail-modal" class="avail-modal-overlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="avail-modal-title">
    <div class="avail-modal-box">
        <button class="avail-modal-close" id="avail-modal-close" aria-label="Zavřít">&times;</button>
        <div class="avail-modal-header">
            <h2 id="avail-modal-title" class="avail-modal-room-name">Obsazenost</h2>
            <p class="avail-modal-hint">Klikněte na <strong>příjezdový den</strong>, pak na <strong>odjezdový den</strong>.<br>Červeně = obsazeno, zeleně = volno.</p>
        </div>
        <div class="avail-cal-nav">
            <button class="avail-nav-btn" id="avail-prev-year" title="Předchozí rok">&#x00AB;</button>
            <button class="avail-nav-btn" id="avail-prev-month" title="Předchozí měsíc">&#x2039;</button>
            <span class="avail-month-label" id="avail-month-label"></span>
            <button class="avail-nav-btn" id="avail-next-month" title="Další měsíc">&#x203A;</button>
            <button class="avail-nav-btn" id="avail-next-year" title="Další rok">&#x00BB;</button>
        </div>
        <div class="avail-cal-grid" id="avail-cal-grid">
            <div class="avail-day-name">Po</div>
            <div class="avail-day-name">Út</div>
            <div class="avail-day-name">St</div>
            <div class="avail-day-name">Čt</div>
            <div class="avail-day-name">Pá</div>
            <div class="avail-day-name">So</div>
            <div class="avail-day-name">Ne</div>
        </div>
        <div class="avail-selection-info" id="avail-selection-info">
            <span id="avail-sel-arrival">Příjezd: —</span>
            <span class="avail-sel-arrow">→</span>
            <span id="avail-sel-departure">Odjezd: —</span>
        </div>
        <div class="avail-legend">
            <span class="avail-legend-item"><span class="avail-dot free"></span> Volno</span>
            <span class="avail-legend-item"><span class="avail-dot booked"></span> Obsazeno</span>
            <span class="avail-legend-item"><span class="avail-dot selected"></span> Vybraný termín</span>
        </div>
        <button class="avail-confirm-btn" id="avail-confirm-btn" disabled>
            Potvrdit termín a přejít na rezervaci
        </button>
    </div>
</div>


<!-- Route Modal -->
<div id="route-modal" class="modal" style="display:none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); overflow-y: auto;">
    <div class="modal-content" style="max-width: 800px; margin: 3rem auto; background: white; border-radius: 20px; padding: 2.5rem; position: relative; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
        <span class="close-modal" style="position: absolute; top: 1.2rem; right: 1.5rem; font-size: 2rem; font-weight: bold; cursor: pointer; color: #888;">&times;</span>
        
        <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--primary); font-weight: 600; font-size: 0.9rem; margin-bottom: 0.5rem;">
            <i data-lucide="navigation"></i> Trasa ze Straňovic (Straňovice 1, 387 01 Malenice)
        </div>
        
        <h2 id="route-title" style="margin-top: 0; color: var(--text-dark); font-size: 1.8rem; margin-bottom: 1rem;">Detail trasy</h2>
        
        <p id="route-description" style="color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem; font-size: 1rem;"></p>
        
        <div style="background: var(--bg-light); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid var(--border);">
            <h4 style="margin: 0 0 0.75rem 0; color: var(--text-dark); font-size: 1.05rem;">Co na trase uvidíte & highlights:</h4>
            <ul id="route-highlights" style="margin: 0; padding-left: 0; list-style: none; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.6rem;"></ul>
        </div>
        
        <div class="route-map-placeholder" style="width: 100%; height: 320px; border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem; border: 1px solid var(--border); position: relative; background: #f0f0f0;">
            <div id="modal-map-container" style="width: 100%; height: 100%;"></div>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <span style="font-size: 0.85rem; color: #777;">
                📍 Start: <strong>Penzion Straňovice 1</strong>
            </span>
            <div style="display: flex; gap: 0.75rem;">
                <a id="route-mapy-cz-link" href="#" target="_blank" class="btn btn-primary" style="font-size: 0.9rem; padding: 0.6rem 1.2rem;">
                    Otevřít navigaci na Mapy.cz <i data-lucide="external-link"></i>
                </a>
            </div>
        </div>
    </div>
</div>


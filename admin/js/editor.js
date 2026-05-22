/**
 * Fida editor Configuration
 */

const editor = grapesjs.init({
    container: '#gjs',
    fromElement: false,
    height: '100%',
    width: 'auto',
    storageManager: false,
    
    assetManager: {
        upload: 'upload.php',
        uploadName: 'files',
        autoAdd: true,
        uploadText: window.UI_LANG === 'en' ? 'Drop files here or click to upload' : 'Sem přetáhněte soubory nebo klikněte pro nahrání',
        addUsedAssets: true,
        assets: []
    },
    
    // I18N Handling
    i18n: {
        locale: window.UI_LANG || 'cs',
        detectLocale: false,
        messages: {
            cs: {
                blockManager: {
                    labels: { 'Sekce': 'Sekce a Rozvržení', 'Obsah': 'Základní prvky' },
                    categories: { 'Sekce': 'Sekce', 'Prvky': 'Základní prvky' }
                },
                styleManager: {
                    sectors: {
                        'general': 'Obecné',
                        'layout': 'Rozvržení',
                        'typography': 'Typografie',
                        'decorations': 'Vzhled',
                        'extra': 'Ostatní',
                        'flex': 'Uspořádání (Flex)',
                        'dimension': 'Rozměry'
                    },
                    properties: {
                        'float': 'Obtékání',
                        'display': 'Zobrazení',
                        'position': 'Pozice',
                        'top': 'Shora',
                        'right': 'Zprava',
                        'left': 'Zleva',
                        'bottom': 'Zespoda',
                        'width': 'Šířka',
                        'height': 'Výška',
                        'max-width': 'Max. šířka',
                        'min-height': 'Min. výška',
                        'margin': 'Vnější okraj',
                        'padding': 'Vnitřní okraj',
                        'font-family': 'Písmo',
                        'font-size': 'Velikost',
                        'font-weight': 'Tloušťka',
                        'letter-spacing': 'Rozestup',
                        'color': 'Barva textu',
                        'line-height': 'Výška řádku',
                        'text-align': 'Zarovnání',
                        'background-color': 'Barva pozadí',
                        'border-radius': 'Zaoblení',
                        'border': 'Okraj',
                        'opacity': 'Průhlednost'
                    }
                },
                traitManager: {
                    traits: {
                        labels: {
                            'id': 'ID pr.',
                            'title': 'Titulek',
                            'href': 'Odkaz (URL)',
                            'target': 'Cíl',
                            'src': 'Zdroj obr.',
                            'alt': 'Popis (Alt)'
                        }
                    }
                }
            }
        }
    },

    styleManager: { appendTo: '#styles-container' },
    traitManager: { appendTo: '#traits-container' },
    layerManager: { appendTo: '#layers-container' },
    
    blockManager: { 
        appendTo: '#blocks-container',
        blocks: [
            {
                id: 'section-hero',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 3H3C1.9 3 1 3.9 1 5V19C1 20.1 1.9 21 3 21H21C22.1 21 23 20.1 23 19V5C23 3.9 22.1 3 21 3ZM21 19H3V5H21V19ZM8 17H16V15H8V17ZM5 13H19V11H5V13ZM8 9H16V7H8V9Z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Hlavní Hero</div>`,
                category: 'Sekce',
                content: `
                <section class="relative h-[80vh] flex items-center justify-center bg-gray-800 text-white overflow-hidden">
                    <div class="absolute inset-0 bg-black/40"></div>
                    <div class="absolute inset-0 bg-cover bg-center opacity-60" style="background-image: url('assets/img/hero.png')"></div>
                    <div class="relative z-10 text-center px-4">
                        <h2 class="text-amber-400 font-serif italic text-3xl mb-4">Vítejte u nás</h2>
                        <h1 class="text-5xl md:text-8xl font-serif font-bold mb-6 text-white">Statek Penzón</h1>
                        <p class="text-xl max-w-2xl mx-auto opacity-90 mb-8 font-light italic">"Místo pro váš klid."</p>
                        <a href="#" class="btn btn-primary px-10">Více o nás</a>
                    </div>
                </section>`
            },
            {
                id: 'section-title',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 4V7H10.5V19H13.5V7H19V4H5Z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Nadpis sekce</div>`,
                category: 'Prvky',
                content: `
                <div class="text-center mb-12">
                    <span class="section-tag">Náš příběh</span>
                    <h2 class="section-title">Vítejte na Statku</h2>
                </div>`
            },
            {
                id: 'room-card',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7h-7L10.5 2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 11H4V4h5.66l2.5 5H20v9z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Pokoj (Karta)</div>`,
                category: 'Sekce',
                content: `
                <div class="room-card">
                    <div class="room-img" style="background-image: url('assets/img/room.png')">
                        <div class="room-price">od 1 200 Kč / noc</div>
                    </div>
                    <div class="room-info">
                        <h3>Apartmán U Lesa</h3>
                        <p>Útulný pokoj s výhledem do zahrady a soukromým vchodem.</p>
                        <div class="room-amenities">
                            <span>2 osoby</span>
                            <span>WiFi</span>
                        </div>
                        <a href="#" class="btn btn-primary">Rezervovat</a>
                    </div>
                </div>`
            },
            {
                id: 'activity-card',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Aktivita</div>`,
                category: 'Prvky',
                content: `
                <div class="activity-card">
                    <div class="activity-icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                    </div>
                    <h3>Domácí snídaně</h3>
                    <p>Každé ráno pečeme čerstvý chleba z naší pece.</p>
                </div>`
            },
            {
                id: 'price-list',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16V4H4v2zm0 5h16V9H4v2zm0 5h16v-2H4v2zm0 4h16v-2H4v2z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Ceník</div>`,
                category: 'Sekce',
                content: `
                <div class="bg-white p-8 rounded shadow-lg border border-[#E8DCC0]">
                    <h3 class="text-2xl font-serif mb-6 text-center">Ceník ubytování</h3>
                    <ul class="room-inventory">
                        <li>
                            <span class="room-name">Dvoulůžkový pokoj</span>
                            <span class="font-bold">1 200 Kč</span>
                        </li>
                        <li>
                            <span class="room-name">Rodinný apartmán</span>
                            <span class="font-bold">2 400 Kč</span>
                        </li>
                        <li>
                            <span class="room-name">Přistýlka</span>
                            <span class="font-bold">400 Kč</span>
                        </li>
                    </ul>
                </div>`
            },
            { 
                id: 'section-plain', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Sekce (kontejner)</div>`, 
                category: 'Sekce', 
                content: '<section class="section-padding"><div class="container">Sem přetáhněte obsah...</div></section>' 
            },
            { 
                id: 'grid-2', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 11h8V4H4v7zm0 9h8v-7H4v7zM13 4v7h8V4h-8zm0 16h8v-7h-8v7z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">2 Sloupce</div>`, 
                category: 'Prvky', 
                content: '<div class="grid md:grid-cols-2 gap-8 my-8"><div class="p-4 bg-black/5 rounded">Sloupec 1</div><div class="p-4 bg-black/5 rounded">Sloupec 2</div></div>' 
            },
            { 
                id: 'grid-3', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 11h5V4H4v7zm0 9h5v-7H4v7zM10 4v7h5V4h-5zm0 16h5v-7h-5v7zM16 4v7h5V4h-5zm0 16h5v-7h-5v7z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">3 Sloupce</div>`, 
                category: 'Prvky', 
                content: '<div class="grid md:grid-cols-3 gap-6 my-8"><div>Sloupec 1</div><div>Sloupec 2</div><div>Sloupec 3</div></div>' 
            },
            { 
                id: 'container', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2.5" fill="none"/>
                        <rect x="7" y="7" width="10" height="10" rx="1" fill="currentColor" opacity="0.3"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Kontejner</div>`, 
                category: 'Prvky', 
                content: '<div class="p-6 border border-dashed border-gray-300 rounded min-h-[60px] w-full">Sem přetáhněte obsah...</div>' 
            },
            { 
                id: 'link-plain', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Odkaz</div>`, 
                category: 'Prvky', 
                content: '<a href="#" class="text-[var(--primary)] hover:underline">Text odkazu</a>' 
            },
            { 
                id: 'link-arrow', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.01 11H4v2h12.01v3L20 12l-3.99-4v3z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Odkaz s šipkou</div>`, 
                category: 'Prvky', 
                content: '<a href="#" class="btn-link">Přečíst si více <i data-lucide="arrow-right"></i></a>' 
            },
            {
                id: 'button-primary',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2zm0 2v8h16V8H4z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Tlačítko</div>`,
                category: 'Prvky',
                content: '<a href="#" class="btn btn-primary my-4">Akční tlačítko</a>'
            },
            { 
                id: 'icon-box', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Ikona</div>`, 
                category: 'Prvky', 
                content: '<div class="text-[var(--primary)] mb-4 w-12 h-12"><i data-lucide="star" style="width:100%; height:100%;"></i></div>' 
            },
            { 
                id: 'divider', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13H5v-2h14v2z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Oddělovač</div>`, 
                category: 'Prvky', 
                content: '<hr class="my-10 border-0 h-px bg-[var(--border)]">' 
            },
            { 
                id: 'video', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 15l5.19-3L10 9v6m11.56-7.83c.13.47.22 1.1.28 1.9.07.8.1 1.49.1 2.09s-.03 1.29-.1 2.09c-.06.8-.15 1.43-.28 1.9-.13.47-.36.94-.7 1.41-.34.47-.79.84-1.34 1.1-.55.26-1.18.42-1.89.5-.71.08-1.58.12-2.62.12s-1.91-.04-2.62-.12c-.71-.08-1.34-.24-1.89-.5-.55-.26-1-.63-1.34-1.1-.34-.47-.57-.94-.7-1.41-.13-.47-.22-1.1-.28-1.9-.07-.8-.1-1.49-.1-2.09s.03-1.29.1-2.09c.06-.8.15-1.43.28-1.9.13-.47.36-.94.7-1.41.34-.47.79-.84 1.34-1.1.55-.26 1.18-.42 1.89-.5.71-.08 1.58-.12 2.62-.12s1.91.04 2.62.12c.71.08 1.34.24 1.89.5.55.26 1 .63 1.34 1.1.34.47.57.94.7 1.41z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Video</div>`, 
                category: 'Prvky', 
                content: '<div class="aspect-video bg-gray-200 flex items-center justify-center rounded">Zde vložte YouTube embed URL</div>' 
            },
            {
                id: 'heading-h3',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 4v16h3v-6h6v6h3V4h-3v7H9V4H6z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Nadpis H3</div>`,
                category: 'Prvky',
                content: '<h3 class="text-xl md:text-2xl font-serif font-bold text-[var(--primary)] mb-4">Podnadpis sekce</h3>'
            },
            { 
                id: 'paragraph', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 9h16v2H4V9zm0 4h10v2H4v-2zm0 4h14v2H4v-2zM4 5h16v2H4V5z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Odstavec</div>`, 
                category: 'Prvky', 
                content: '<p class="mb-4">Tohle je odstavec textu. Poklepáním jej můžete upravit a začít psát...</p>' 
            },
            {
                id: 'bullet-list',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 10.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM8 8h14v2H8V8zm0 5.5h14v2H8v-2zm0 5.5h14v2H8v-2z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Seznam</div>`,
                category: 'Prvky',
                content: `
                <ul class="space-y-2 my-4 list-disc list-inside text-gray-700">
                    <li>První položka seznamu</li>
                    <li>Druhá položka seznamu</li>
                    <li>Třetí položka seznamu</li>
                </ul>`
            },
            {
                id: 'blockquote',
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Citace</div>`,
                category: 'Prvky',
                content: `
                <blockquote class="border-l-4 border-[var(--primary)] pl-4 italic my-6 text-[var(--text-muted)]">
                    "Tento pobyt předčil naše očekávání. Krásné prostředí statku a skvělí hostitelé."
                    <cite class="block font-bold not-italic mt-2 text-xs text-[var(--text-dark)]">— Rodina Novákova, Praha</cite>
                </blockquote>`
            },
            { 
                id: 'table-plain', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 5H5V5h14v3zm-7 5H5V9h7v4zm7 0h-6V9h6v4zm-7 6H5v-4h7v4zm7 0h-6v-4h6v4z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Tabulka</div>`, 
                category: 'Prvky', 
                content: `
                <table class="w-full border-collapse border border-[#E8DCC0] my-6 text-left">
                    <thead>
                        <tr class="bg-[#F9F4EB] text-gray-800">
                            <th class="border border-[#E8DCC0] p-3 font-serif font-bold text-sm">Hlavička 1</th>
                            <th class="border border-[#E8DCC0] p-3 font-serif font-bold text-sm">Hlavička 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-[#E8DCC0] p-3 text-sm">Hodnota 1</td>
                            <td class="border border-[#E8DCC0] p-3 text-sm">Hodnota 2</td>
                        </tr>
                        <tr>
                            <td class="border border-[#E8DCC0] p-3 text-sm">Hodnota 3</td>
                            <td class="border border-[#E8DCC0] p-3 text-sm">Hodnota 4</td>
                        </tr>
                    </tbody>
                </table>`
            },
            { 
                id: 'image', 
                label: `
                    <svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 23 20.1 23 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z"/>
                    </svg>
                    <div class="gjs-block-label text-xs mt-1">Obrázek</div>`, 
                category: 'Prvky', 
                content: { type: 'image' } 
            }
        ]
    },

    // UI Panels for Icons
    panels: {
        defaults: [
            {
                id: 'actions',
                el: '#panel-actions',
                buttons: [
                    { id: 'sw-visibility', className: 'fa fa-eye', command: 'sw-visibility', active: true, attributes: { title: 'Zobrazit vodítka' } },
                    { id: 'undo', className: 'fa fa-undo', command: 'undo', attributes: { title: 'Zpět' } },
                    { id: 'redo', className: 'fa fa-repeat', command: 'redo', attributes: { title: 'Vpřed' } },
                    { id: 'canvas-clear', className: 'fa fa-trash', command: 'canvas-clear', attributes: { title: 'Vyčistit' } }
                ]
            }
        ]
    },

    canvas: {
        scripts: [
            'https://cdn.tailwindcss.com',
            'https://unpkg.com/lucide@latest',
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'
        ],
        styles: [
            'https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Montserrat:wght@300;400;600&family=Pinyon+Script&display=swap',
            'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
            '../assets/css/style.css',
            'css/editor-fix.css' 
        ]
    }
});

// Load the initial content
if (window.INITIAL_CONTENT) {
    editor.on('load', () => {
        // Set base path for the canvas to correctly resolve images and assets
        const body = editor.Canvas.getBody();
        if (body) {
            let base = body.querySelector('base');
            if (!base) {
                base = document.createElement('base');
                body.prepend(base);
            }
            base.href = '../';
        }
        
        // Now set the components
        editor.setComponents(window.INITIAL_CONTENT);

        // Helper to render Lucide icons without replacing the GrapesJS <i> component elements
        const runLucide = () => {
            const canvasWindow = editor.Canvas.getWindow();
            if (!canvasWindow || !canvasWindow.lucide) return;
            
            const icons = canvasWindow.document.querySelectorAll('i[data-lucide]');
            const tasks = [];
            
            icons.forEach(icon => {
                // If it already has an SVG icon inside, we don't need to do anything
                if (icon.querySelector('svg')) return;
                
                const iconName = icon.getAttribute('data-lucide');
                if (!iconName) return;
                
                // Temporarily remove data-lucide so lucide.createIcons doesn't replace the <i> element itself
                icon.removeAttribute('data-lucide');
                icon.setAttribute('data-temp-lucide', iconName);
                
                // Create a temporary placeholder span inside the <i> tag
                const span = canvasWindow.document.createElement('span');
                span.setAttribute('data-lucide', iconName);
                icon.appendChild(span);
                
                tasks.push(icon);
            });
            
            if (tasks.length > 0) {
                // Run Lucide createIcons inside the canvas iframe context
                canvasWindow.lucide.createIcons();
                
                // Restore the data-lucide attributes and style the SVGs
                tasks.forEach(icon => {
                    const iconName = icon.getAttribute('data-temp-lucide');
                    icon.setAttribute('data-lucide', iconName);
                    icon.removeAttribute('data-temp-lucide');
                    
                    const svg = icon.querySelector('svg');
                    if (svg) {
                        svg.style.width = '100%';
                        svg.style.height = '100%';
                        svg.style.display = 'inline-block';
                        svg.style.verticalAlign = 'middle';
                    }
                });
            }
        };

        // Run Lucide after initialization
        setTimeout(runLucide, 200);

        // Run Lucide when components are added dynamically (e.g. dragged from block manager)
        editor.on('component:add', () => {
            setTimeout(runLucide, 50);
        });

        // Expand 'Nastavení prvku' (Properties) panel when a component is selected
        editor.on('component:selected', () => {
            const propsSection = document.querySelector('.sidebar-section.section-props');
            if (propsSection && propsSection.classList.contains('collapsed')) {
                propsSection.classList.remove('collapsed');
            }
        });

        // Context Menu on Right Click inside Editor Canvas
        const iframe = editor.Canvas.getIframe();
        if (iframe) {
            // Create the context menu element dynamically in the main window
            const contextMenu = document.createElement('div');
            contextMenu.className = 'fixed hidden bg-slate-900 border border-slate-700/60 text-slate-200 text-xs rounded-lg shadow-2xl py-1 z-[99999] w-48 backdrop-blur-md bg-opacity-95 font-sans';
            document.body.appendChild(contextMenu);

            // Track copied styles
            let copiedStyle = null;

            // Function to hide context menu
            const hideContextMenu = () => {
                contextMenu.classList.add('hidden');
            };

            // Hide when clicking anywhere in main window
            document.addEventListener('click', hideContextMenu);
            
            // Also hide on ESC key press
            const escHandler = (e) => { if (e.key === 'Escape') hideContextMenu(); };
            window.addEventListener('keydown', escHandler);

            const onContextMenu = (e) => {
                let targetComp = null;
                
                // 1. Get selected component
                targetComp = editor.getSelected();

                // 2. If nothing selected, try to find component from target element
                if (!targetComp && e.target) {
                    targetComp = editor.Components.getWrapper().find(e.target)[0];
                    if (targetComp) {
                        editor.select(targetComp);
                    }
                }

                if (!targetComp || targetComp.get('type') === 'wrapper') {
                    // Do not show menu on root wrapper
                    return;
                }

                e.preventDefault();

                // Calculate screen position relative to the main viewport using the iframe element
                const rect = iframe.getBoundingClientRect();
                let x, y;
                
                // e.view refers to the window object where event occurred
                if (e.view === window) {
                    // Main window coordinates (e.g. clicking GrapesJS overlays)
                    x = e.clientX;
                    y = e.clientY;
                } else {
                    // Iframe window coordinates (e.g. clicking inside page body)
                    x = rect.left + e.clientX;
                    y = rect.top + e.clientY;
                }

                // Clear previous menu items
                contextMenu.innerHTML = '';

                // Duplicate Component
                const optDuplicate = document.createElement('button');
                optDuplicate.className = 'w-full text-left px-4 py-2 hover:bg-indigo-600 hover:text-white flex items-center gap-3 transition-colors';
                optDuplicate.innerHTML = '<i class="fa fa-clone w-4 text-center"></i> ' + (window.UI_LANG === 'en' ? 'Duplicate' : 'Duplikovat');
                optDuplicate.onclick = () => {
                    editor.runCommand('core:component-clone');
                    hideContextMenu();
                };

                // Delete Component
                const optDelete = document.createElement('button');
                optDelete.className = 'w-full text-left px-4 py-2 hover:bg-red-600 hover:text-white flex items-center gap-3 transition-colors text-red-400';
                optDelete.innerHTML = '<i class="fa fa-trash w-4 text-center"></i> ' + (window.UI_LANG === 'en' ? 'Delete' : 'Smazat');
                optDelete.onclick = () => {
                    editor.runCommand('core:component-delete');
                    hideContextMenu();
                };

                // Divider 1
                const divider1 = document.createElement('div');
                divider1.className = 'border-t border-slate-800 my-1';

                // Copy Style
                const optCopyStyle = document.createElement('button');
                optCopyStyle.className = 'w-full text-left px-4 py-2 hover:bg-indigo-600 hover:text-white flex items-center gap-3 transition-colors';
                optCopyStyle.innerHTML = '<i class="fa fa-copy w-4 text-center"></i> ' + (window.UI_LANG === 'en' ? 'Copy Style' : 'Kopírovat styl');
                optCopyStyle.onclick = () => {
                    copiedStyle = { ...targetComp.getStyle() };
                    hideContextMenu();
                };

                // Paste Style
                const optPasteStyle = document.createElement('button');
                optPasteStyle.className = 'w-full text-left px-4 py-2 flex items-center gap-3 transition-colors ' + 
                    (copiedStyle ? 'hover:bg-indigo-600 hover:text-white text-slate-200' : 'text-slate-500 cursor-not-allowed');
                optPasteStyle.innerHTML = '<i class="fa fa-paste w-4 text-center"></i> ' + (window.UI_LANG === 'en' ? 'Paste Style' : 'Vložit styl');
                optPasteStyle.disabled = !copiedStyle;
                if (copiedStyle) {
                    optPasteStyle.onclick = () => {
                        targetComp.setStyle(copiedStyle);
                        hideContextMenu();
                    };
                }

                // Divider 2
                const divider2 = document.createElement('div');
                divider2.className = 'border-t border-slate-800 my-1';

                // Move Up
                const optMoveUp = document.createElement('button');
                optMoveUp.className = 'w-full text-left px-4 py-2 hover:bg-indigo-600 hover:text-white flex items-center gap-3 transition-colors';
                optMoveUp.innerHTML = '<i class="fa fa-arrow-up w-4 text-center"></i> ' + (window.UI_LANG === 'en' ? 'Move Up' : 'Posunout nahoru');
                optMoveUp.onclick = () => {
                    const parent = targetComp.parent();
                    if (parent) {
                        const collection = parent.components();
                        const index = collection.indexOf(targetComp);
                        if (index > 0) {
                            collection.add(targetComp, { at: index - 1 });
                        }
                    }
                    hideContextMenu();
                };

                // Move Down
                const optMoveDown = document.createElement('button');
                optMoveDown.className = 'w-full text-left px-4 py-2 hover:bg-indigo-600 hover:text-white flex items-center gap-3 transition-colors';
                optMoveDown.innerHTML = '<i class="fa fa-arrow-down w-4 text-center"></i> ' + (window.UI_LANG === 'en' ? 'Move Down' : 'Posunout dolů');
                optMoveDown.onclick = () => {
                    const parent = targetComp.parent();
                    if (parent) {
                        const collection = parent.components();
                        const index = collection.indexOf(targetComp);
                        if (index < collection.length - 1) {
                            collection.add(targetComp, { at: index + 2 });
                        }
                    }
                    hideContextMenu();
                };

                contextMenu.appendChild(optDuplicate);
                contextMenu.appendChild(optDelete);
                contextMenu.appendChild(divider1);
                contextMenu.appendChild(optCopyStyle);
                contextMenu.appendChild(optPasteStyle);
                contextMenu.appendChild(divider2);
                contextMenu.appendChild(optMoveUp);
                contextMenu.appendChild(optMoveDown);

                // Open & Position
                contextMenu.style.left = `${x}px`;
                contextMenu.style.top = `${y}px`;
                contextMenu.classList.remove('hidden');
            };

            const bindContextMenu = () => {
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (iframeDoc) {
                    iframeDoc.removeEventListener('contextmenu', onContextMenu);
                    iframeDoc.addEventListener('contextmenu', onContextMenu);
                    
                    iframeDoc.removeEventListener('click', hideContextMenu);
                    iframeDoc.addEventListener('click', hideContextMenu);
                    
                    iframeDoc.removeEventListener('keydown', escHandler);
                    iframeDoc.addEventListener('keydown', escHandler);
                }
            };

            // Bind to main window canvas wrapper (#gjs)
            const canvasEl = document.getElementById('gjs');
            if (canvasEl) {
                canvasEl.removeEventListener('contextmenu', onContextMenu);
                canvasEl.addEventListener('contextmenu', onContextMenu);
                
                canvasEl.removeEventListener('click', hideContextMenu);
                canvasEl.addEventListener('click', hideContextMenu);
            }

            // Bind to iframe document
            bindContextMenu();

            // Bind when iframe loads or reloads
            iframe.addEventListener('load', bindContextMenu);

            // Bind when components change or pages switch
            editor.on('component:selected', bindContextMenu);
        }
    });
}

// Page Settings Modal Logic
function openPageSettings() {
    document.getElementById('meta-slug').value = window.PAGE_META.slug || '';
    document.getElementById('meta-title').value = window.PAGE_META.title || '';
    document.getElementById('meta-description').value = window.PAGE_META.description || '';
    document.getElementById('meta-keywords').value = window.PAGE_META.keywords || '';
    document.getElementById('settings-modal').classList.remove('hidden');
}

function closePageSettings() {
    document.getElementById('settings-modal').classList.add('hidden');
}

function savePageSettings() {
    window.PAGE_META.slug = document.getElementById('meta-slug').value;
    window.PAGE_META.title = document.getElementById('meta-title').value;
    window.PAGE_META.description = document.getElementById('meta-description').value;
    window.PAGE_META.keywords = document.getElementById('meta-keywords').value;
    closePageSettings();
    // Highlight save button to remind user to save
    document.getElementById('save-btn').classList.add('ring-4', 'ring-sky-400');
    setTimeout(() => document.getElementById('save-btn').classList.remove('ring-4'), 2000);
}

// Handle Save Button
document.getElementById('save-btn').addEventListener('click', function() {
    const btn = this;
    const originalText = btn.innerText;
    
    // Loading state
    btn.innerText = window.UI_LANG === 'en' ? 'SAVING...' : 'UKLÁDÁM...';
    btn.disabled = true;
    btn.style.opacity = '0.7';

    const html = editor.getHtml();
    const css = editor.getCss();
    const finalHtml = `<?php 
require_once 'includes/CMS.php';
$meta = CMS::getPageMeta();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <?php include 'includes/head.php'; ?>
    <style>${css}</style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        ${html.replace(/<base[^>]*>/g, '')}
    </main>

    <?php include 'includes/footer.php'; ?>
    <script>if (typeof lucide !== 'undefined') lucide.createIcons();</script>
</body>
</html>`;

    fetch('save.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            html: finalHtml,
            metadata: window.PAGE_META
        })
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('status-msg');
        if (data.status === 'success') {
            msg.innerText = window.UI_LANG === 'en' ? 'Saved & Committed!' : 'Uloženo a commitnuto!';
            msg.classList.remove('text-amber-500');
            msg.classList.add('text-sky-400');
            msg.style.opacity = '1';
            setTimeout(() => msg.style.opacity = '0', 3000);
            console.log('Git Output:', data.git_output);
        } else if (data.status === 'warning') {
            alert('VAROVÁNÍ: ' + data.message);
            msg.innerText = window.UI_LANG === 'en' ? 'Not pushed!' : 'Neodesláno!';
            msg.classList.remove('text-sky-400');
            msg.classList.add('text-amber-500');
            msg.style.opacity = '1';
            
            // Force show update banner if the error is about a new version
            if (data.git_output && data.git_output.includes('novější verze')) {
                document.getElementById('update-banner').classList.remove('hidden');
                alert(window.UI_LANG === 'en' ? 'A new version of CMS is available! Please update first using the yellow button.' : 'Je k dispozici nová verze CMS! Prosím, nejdříve proveďte aktualizaci pomocí žlutého tlačítka nahoře.');
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => alert('Error saving.'))
    .finally(() => {
        btn.innerText = originalText;
        btn.disabled = false;
        btn.style.opacity = '1';
    });
});


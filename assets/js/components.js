/**
 * Penzion Statek Straňovice - Shared Components (Dynamic Loader)
 * Fetches HTML partials from external files to allow editing in Admin Panel.
 */

async function loadComponent(url) {
    try {
        // Add cache-busting timestamp to see changes immediately after Admin save
        const response = await fetch(`${url}?v=${new Date().getTime()}`);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return await response.text();
    } catch (e) {
        console.error(`Could not load component from ${url}:`, e);
        return '';
    }
}

async function injectComponents() {
    const headerEl = document.getElementById('navbar');
    const footerEl = document.getElementById('main-footer');
    const modalsEl = document.getElementById('shared-modals');

    // Load components in parallel
    const [headerHtml, footerHtml, modalsHtml] = await Promise.all([
        headerEl ? loadComponent('_header.html') : Promise.resolve(''),
        footerEl ? loadComponent('_footer.html') : Promise.resolve(''),
        modalsEl ? loadComponent('_modals.html') : Promise.resolve('')
    ]);

    if (headerEl && headerHtml) headerEl.innerHTML = headerHtml;
    if (footerEl && footerHtml) footerEl.innerHTML = footerHtml;
    if (modalsEl && modalsHtml) modalsEl.innerHTML = modalsHtml;

    // Initialize Lucide icons for injected content
    if (window.lucide) {
        window.lucide.createIcons();
    }

    // Set flag and dispatch event for script.js to bind interactions
    window.componentsLoaded = true;
    document.dispatchEvent(new CustomEvent('componentsLoaded'));
}

// Auto-run on load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', injectComponents);
} else {
    injectComponents();
}

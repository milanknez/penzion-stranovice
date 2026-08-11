/**
 * Fida CMS Core UI & Navigation Manager
 */

(function() {
    window.switchView = function switchView(view) {
        const editorBtn = document.getElementById('menu-btn-editor');
        const settingsBtn = document.getElementById('menu-btn-settings');
        const filesBtn = document.getElementById('menu-btn-files');
        const pluginsBtn = document.getElementById('menu-btn-plugins');
        const themesBtn = document.getElementById('menu-btn-themes');
        const contractsBtn = document.getElementById('menu-btn-contracts');
        const contractsPage = document.getElementById('contracts-page-wrapper');
        const gjsContainer = document.querySelector('.editor-canvas');
        const rightPanel = document.querySelector('.panel-right');
        const settingsPage = document.getElementById('settings-page-wrapper');
        const filesPage = document.getElementById('files-page-wrapper');
        const pluginsPage = document.getElementById('plugins-page-wrapper');
        const themesPage = document.getElementById('themes-page-wrapper');
        const headerPageControls = document.querySelector('header .flex.items-center.gap-4');
        const headerPageSettingsBtn = document.querySelector('header button[onclick="openPageSettings()"]');
        const headerSaveBtn = document.getElementById('save-btn');
        const headerStatusMsg = document.getElementById('status-msg');
        
        const pagesBtn = document.getElementById('menu-btn-pages');
        const pagesPage = document.getElementById('pages-page-wrapper');
        
        [pagesBtn, editorBtn, settingsBtn, filesBtn, pluginsBtn, contractsBtn, themesBtn].forEach(btn => {
            if (!btn) return;
            btn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs text-slate-300 hover:bg-white/5 hover:text-white rounded-lg transition-colors text-left";
            const icon = btn.querySelector('i');
            let iconClass = "fa-files-o";
            if (btn === settingsBtn) iconClass = "fa-globe";
            if (btn === filesBtn) iconClass = "fa-folder-open";
            if (btn === pluginsBtn) iconClass = "fa-plug";
            if (btn === contractsBtn) iconClass = "fa-file-text-o";
            if (btn === themesBtn) iconClass = "fa-paint-brush";
            if (icon) icon.className = "fa " + iconClass + " w-4 text-center text-indigo-400";
        });

        if (view === 'pages') {
            if (pagesBtn) {
                pagesBtn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg transition-colors text-left shadow-md shadow-indigo-600/10";
                const i = pagesBtn.querySelector('i');
                if (i) i.className = "fa fa-files-o w-4 text-center text-white";
            }
            
            if (gjsContainer) gjsContainer.classList.add('hidden');
            if (rightPanel) rightPanel.classList.add('hidden');
            if (settingsPage) settingsPage.classList.add('hidden');
            if (filesPage) filesPage.classList.add('hidden');
            if (pluginsPage) pluginsPage.classList.add('hidden');
            if (themesPage) themesPage.classList.add('hidden');
            if (contractsPage) contractsPage.classList.add('hidden');
            if (pagesPage) pagesPage.classList.remove('hidden');
            
            if (headerPageControls) headerPageControls.classList.add('invisible');
            if (headerPageSettingsBtn) headerPageSettingsBtn.classList.add('hidden');
            if (headerSaveBtn) headerSaveBtn.classList.add('hidden');
            if (headerStatusMsg) headerStatusMsg.style.opacity = '0';
        } else if (view === 'editor') {
            if (window.EDIT_MODE !== 'theme_header' && window.EDIT_MODE !== 'theme_footer') {
                window.EDIT_MODE = 'page';
            }
            if (editorBtn) {
                editorBtn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg transition-colors text-left shadow-md shadow-indigo-600/10";
                const i = editorBtn.querySelector('i');
                if (i) i.className = "fa fa-files-o w-4 text-center text-white";
            }
            
            if (gjsContainer) gjsContainer.classList.remove('hidden');
            if (rightPanel) rightPanel.classList.remove('hidden');
            if (pagesPage) pagesPage.classList.add('hidden');
            if (settingsPage) settingsPage.classList.add('hidden');
            if (filesPage) filesPage.classList.add('hidden');
            if (pluginsPage) pluginsPage.classList.add('hidden');
            if (themesPage) themesPage.classList.add('hidden');
            if (contractsPage) contractsPage.classList.add('hidden');
            
            if (headerPageControls) headerPageControls.classList.remove('invisible');
            if (headerPageSettingsBtn) headerPageSettingsBtn.classList.remove('hidden');
            if (headerSaveBtn) headerSaveBtn.classList.remove('hidden');
            
            if (window.editor && typeof window.editor.refresh === 'function') {
                setTimeout(function() {
                    window.editor.refresh();
                }, 50);
            }
        } else if (view === 'settings') {
            if (settingsBtn) {
                settingsBtn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg transition-colors text-left shadow-md shadow-indigo-600/10";
                const i = settingsBtn.querySelector('i');
                if (i) i.className = "fa fa-globe w-4 text-center text-white";
            }
            
            if (gjsContainer) gjsContainer.classList.add('hidden');
            if (rightPanel) rightPanel.classList.add('hidden');
            if (pagesPage) pagesPage.classList.add('hidden');
            if (settingsPage) settingsPage.classList.remove('hidden');
            if (filesPage) filesPage.classList.add('hidden');
            if (pluginsPage) pluginsPage.classList.add('hidden');
            if (themesPage) themesPage.classList.add('hidden');
            if (contractsPage) contractsPage.classList.add('hidden');
            
            if (headerPageControls) headerPageControls.classList.add('invisible');
            if (headerPageSettingsBtn) headerPageSettingsBtn.classList.add('hidden');
            if (headerSaveBtn) headerSaveBtn.classList.add('hidden');
            if (headerStatusMsg) headerStatusMsg.style.opacity = '0';
            
            const cfg = window.SITE_CONFIG || {};
            const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val || ''; };
            setVal('site-name', cfg.site_name);
            const faviconVal = cfg.favicon || '';
            const faviconInput = document.getElementById('site-favicon');
            const faviconPreview = document.getElementById('site-favicon-preview');
            if (faviconInput) faviconInput.value = faviconVal;
            if (faviconPreview) {
                if (faviconVal) {
                    faviconPreview.src = (faviconVal.startsWith('http') || faviconVal.startsWith('data:')) ? faviconVal : '../' + faviconVal;
                    faviconPreview.style.display = 'block';
                } else {
                    faviconPreview.style.display = 'none';
                }
            }
            setVal('site-phone-nonstop', cfg.phone_nonstop);
            setVal('site-phone-landline', cfg.phone_landline);
            setVal('site-email', cfg.email);
            setVal('site-address-headquarters', cfg.address_headquarters);
            setVal('site-address-dispatch', cfg.address_dispatch);
            setVal('site-ga-id', cfg.ga_id);
            setVal('site-contact-form-recipient', cfg.contact_form_recipient);
            setVal('site-404', cfg.error_page_404);
            const forceHttpsEl = document.getElementById('site-force-https');
            if (forceHttpsEl) forceHttpsEl.checked = cfg.force_https || false;
            setVal('site-redirect-www', cfg.redirect_www || 'none');
            const siteCacheEl = document.getElementById('site-enable-cache');
            if (siteCacheEl) siteCacheEl.checked = cfg.enable_cache || false;
            
            if (typeof window.switchSettingsTab === 'function') {
                window.switchSettingsTab('general');
            }
        } else if (view === 'files') {
            if (filesBtn) {
                filesBtn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg transition-colors text-left shadow-md shadow-indigo-600/10";
                const i = filesBtn.querySelector('i');
                if (i) i.className = "fa fa-folder-open w-4 text-center text-white";
            }
            
            if (gjsContainer) gjsContainer.classList.add('hidden');
            if (rightPanel) rightPanel.classList.add('hidden');
            if (pagesPage) pagesPage.classList.add('hidden');
            if (settingsPage) settingsPage.classList.add('hidden');
            if (filesPage) filesPage.classList.remove('hidden');
            if (pluginsPage) pluginsPage.classList.add('hidden');
            if (themesPage) themesPage.classList.add('hidden');
            if (contractsPage) contractsPage.classList.add('hidden');
            
            if (headerPageControls) headerPageControls.classList.add('invisible');
            if (headerPageSettingsBtn) headerPageSettingsBtn.classList.add('hidden');
            if (headerSaveBtn) headerSaveBtn.classList.add('hidden');
            if (headerStatusMsg) headerStatusMsg.style.opacity = '0';
            
            if (typeof window.loadFileManagerFiles === 'function') window.loadFileManagerFiles();
        } else if (view === 'plugins') {
            if (pluginsBtn) {
                pluginsBtn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg transition-colors text-left shadow-md shadow-indigo-600/10";
                const i = pluginsBtn.querySelector('i');
                if (i) i.className = "fa fa-plug w-4 text-center text-white";
            }
            
            if (gjsContainer) gjsContainer.classList.add('hidden');
            if (rightPanel) rightPanel.classList.add('hidden');
            if (pagesPage) pagesPage.classList.add('hidden');
            if (settingsPage) settingsPage.classList.add('hidden');
            if (filesPage) filesPage.classList.add('hidden');
            if (pluginsPage) pluginsPage.classList.remove('hidden');
            if (themesPage) themesPage.classList.add('hidden');
            if (contractsPage) contractsPage.classList.add('hidden');
            
            if (headerPageControls) headerPageControls.classList.add('invisible');
            if (headerPageSettingsBtn) headerPageSettingsBtn.classList.add('hidden');
            if (headerSaveBtn) headerSaveBtn.classList.add('hidden');
            if (headerStatusMsg) headerStatusMsg.style.opacity = '0';
            
            if (typeof window.loadPlugins === 'function') window.loadPlugins();
        } else if (view === 'contracts') {
            if (contractsBtn) {
                contractsBtn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg transition-colors text-left shadow-md shadow-indigo-600/10";
                const i = contractsBtn.querySelector('i');
                if (i) i.className = "fa fa-file-text-o w-4 text-center text-white";
            }
            
            if (gjsContainer) gjsContainer.classList.add('hidden');
            if (rightPanel) rightPanel.classList.add('hidden');
            if (pagesPage) pagesPage.classList.add('hidden');
            if (settingsPage) settingsPage.classList.add('hidden');
            if (filesPage) filesPage.classList.add('hidden');
            if (pluginsPage) pluginsPage.classList.add('hidden');
            if (themesPage) themesPage.classList.add('hidden');
            if (contractsPage) contractsPage.classList.remove('hidden');
            
            if (headerPageControls) headerPageControls.classList.add('invisible');
            if (headerPageSettingsBtn) headerPageSettingsBtn.classList.add('hidden');
            if (headerSaveBtn) headerSaveBtn.classList.add('hidden');
            if (headerStatusMsg) headerStatusMsg.style.opacity = '0';
            
            if (typeof window.loadContracts === 'function') window.loadContracts();
        } else if (view === 'themes') {
            if (themesBtn) {
                themesBtn.className = "w-full flex items-center gap-3 px-3 py-2.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg transition-colors text-left shadow-md shadow-indigo-600/10";
                const i = themesBtn.querySelector('i');
                if (i) i.className = "fa fa-paint-brush w-4 text-center text-white";
            }
            
            if (gjsContainer) gjsContainer.classList.add('hidden');
            if (rightPanel) rightPanel.classList.add('hidden');
            if (pagesPage) pagesPage.classList.add('hidden');
            if (settingsPage) settingsPage.classList.add('hidden');
            if (filesPage) filesPage.classList.add('hidden');
            if (pluginsPage) pluginsPage.classList.add('hidden');
            if (themesPage) themesPage.classList.remove('hidden');
            if (contractsPage) contractsPage.classList.add('hidden');
            
            if (headerPageControls) headerPageControls.classList.add('invisible');
            if (headerPageSettingsBtn) headerPageSettingsBtn.classList.add('hidden');
            if (headerSaveBtn) headerSaveBtn.classList.add('hidden');
            if (headerStatusMsg) headerStatusMsg.style.opacity = '0';
            
            if (typeof window.loadThemes === 'function') window.loadThemes();
        }
    };

    window.switchSettingsTab = function switchSettingsTab(tabId) {
        ['general', 'contacts', 'addresses', 'domain', 'cache', 'security', 'updates'].forEach(id => {
            const el = document.getElementById('content-tab-' + id);
            if (el) el.classList.add('hidden');
        });
        
        const targetTab = document.getElementById('content-tab-' + tabId);
        if (targetTab) targetTab.classList.remove('hidden');
        
        const tabButtons = document.querySelectorAll('.settings-tab-btn');
        tabButtons.forEach(btn => {
            btn.classList.remove('border-indigo-500', 'text-white');
            btn.classList.add('border-transparent', 'text-slate-400');
        });
        
        const activeBtn = document.getElementById('btn-tab-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-slate-400');
            activeBtn.classList.add('border-indigo-500', 'text-white');
        }
    };

    window.openPageSettings = function openPageSettings() {
        const modal = document.getElementById('settings-modal');
        if (modal) {
            const meta = window.PAGE_META || {};
            const slugInput = document.getElementById('meta-slug');
            const titleInput = document.getElementById('meta-title');
            const descInput = document.getElementById('meta-description');
            const kwInput = document.getElementById('meta-keywords');

            if (slugInput) slugInput.value = meta.slug || '';
            if (titleInput) titleInput.value = meta.title || '';
            if (descInput) descInput.value = meta.description || '';
            if (kwInput) kwInput.value = meta.keywords || '';

            modal.classList.remove('hidden');
        }
    };

    window.closePageSettings = function closePageSettings() {
        const modal = document.getElementById('settings-modal');
        if (modal) modal.classList.add('hidden');
    };

    window.toggleSidebar = function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const icon = document.getElementById('sidebar-toggle-icon');
        if (!sidebar) return;
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-16');
        document.querySelectorAll('.sidebar-text, .sidebar-label').forEach(el => el.classList.toggle('hidden'));
        if (icon) {
            icon.classList.toggle('fa-angle-double-left');
            icon.classList.toggle('fa-angle-double-right');
        }
    };
})();

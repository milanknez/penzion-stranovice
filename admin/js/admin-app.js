/**
 * Fida CMS Main Application Logic
 */

(function() {
    // Load dynamic data from JSON tag
    let cmsData = {};
    try {
        const dataEl = document.getElementById('cms-data');
        if (dataEl) {
            cmsData = JSON.parse(dataEl.textContent);
        }
    } catch (e) {
        console.error("Failed to parse CMS initialization data:", e);
    }

    window.INITIAL_CONTENT = cmsData.initialContent || '';
    window.INITIAL_BODY_CLASS = cmsData.initialBodyClass || '';
    window.UI_LANG = cmsData.uiLang || 'cs';
    window.PAGE_META = cmsData.pageMeta || {};
    window.SITE_CONFIG = cmsData.siteConfig || {};
    window.ORIGINAL_TOP_PHP = cmsData.originalTopPhp || '';

    window.switchRightTab = function(tabName) {
        const tabs = ['styles', 'traits', 'layers', 'blocks'];
        for (let i = 0; i < tabs.length; i++) {
            const t = tabs[i];
            const btn = document.getElementById('tab-btn-' + t);
            const content = document.getElementById('tab-content-' + t);
            if (btn) btn.classList.toggle('active', t === tabName);
            if (content) content.classList.toggle('active', t === tabName);
        }
    };

    window.showToast = function(message, type) {
        type = type || 'success';
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl text-xs font-semibold text-white border transition-all duration-300 transform translate-y-2 opacity-0';

        let icon = 'fa-check-circle';
        if (type === 'success') {
            toast.classList.add('bg-emerald-950/90', 'border-emerald-500/40', 'text-emerald-200');
            icon = 'fa-check-circle';
        } else if (type === 'error') {
            toast.classList.add('bg-red-950/90', 'border-red-500/40', 'text-red-200');
            icon = 'fa-exclamation-circle';
        } else if (type === 'warning') {
            toast.classList.add('bg-amber-950/90', 'border-amber-500/40', 'text-amber-200');
            icon = 'fa-exclamation-triangle';
        } else {
            toast.classList.add('bg-slate-900/90', 'border-indigo-500/40', 'text-indigo-200');
            icon = 'fa-info-circle';
        }

        toast.innerHTML = '<i class="fa ' + icon + ' text-sm shrink-0"></i><span>' + message + '</span>';
        container.appendChild(toast);

        setTimeout(function() {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);

        setTimeout(function() {
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(function() {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 300);
        }, 3500);
    };

    window.showConfirmModal = function(opts) {
        opts = opts || {};
        const title = opts.title || 'Potvrdit akci';
        const message = opts.message || 'Opravdu chcete tuto akci provést?';
        const confirmText = opts.confirmText || 'Potvrdit';
        const isDanger = opts.isDanger !== false;
        const icon = opts.icon || 'fa-exclamation-triangle';
        const onConfirm = opts.onConfirm;

        const modal = document.getElementById('confirm-modal');
        if (!modal) return;

        document.getElementById('confirm-title').innerText = title;
        document.getElementById('confirm-message').innerText = message;

        const iconBox = document.getElementById('confirm-icon-box');
        const iconEl = document.getElementById('confirm-icon');
        const actionBtn = document.getElementById('confirm-action-btn');

        if (iconEl) iconEl.className = 'fa ' + icon;

        if (isDanger) {
            if (iconBox) iconBox.className = 'w-14 h-14 rounded-2xl bg-red-500/20 text-red-400 border border-red-500/30 flex items-center justify-center mx-auto text-2xl shadow-lg';
            if (actionBtn) actionBtn.className = 'bg-red-600 hover:bg-red-500 text-white font-black px-6 py-2.5 rounded-xl shadow-lg shadow-red-600/20 active:transform active:scale-[0.98] transition-all text-xs uppercase';
        } else {
            if (iconBox) iconBox.className = 'w-14 h-14 rounded-2xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center mx-auto text-2xl shadow-lg';
            if (actionBtn) actionBtn.className = 'bg-indigo-600 hover:bg-indigo-500 text-white font-black px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 active:transform active:scale-[0.98] transition-all text-xs uppercase';
        }

        if (actionBtn) {
            actionBtn.innerText = confirmText;
            actionBtn.onclick = function() {
                window.closeConfirmModal();
                if (typeof onConfirm === 'function') onConfirm();
            };
        }

        modal.classList.remove('hidden');
    };

    window.closeConfirmModal = function() {
        const modal = document.getElementById('confirm-modal');
        if (modal) modal.classList.add('hidden');
    };

    window.openPageSettings = function() {
        const modal = document.getElementById('page-settings-modal');
        if (!modal) return;
        
        const titleInput = document.getElementById('setting-page-title');
        const slugInput = document.getElementById('setting-page-slug');
        const descInput = document.getElementById('setting-page-description');
        const kwInput = document.getElementById('setting-page-keywords');

        if (titleInput) titleInput.value = window.PAGE_META.title || '';
        if (slugInput) slugInput.value = window.PAGE_META.slug || '';
        if (descInput) descInput.value = window.PAGE_META.description || '';
        if (kwInput) kwInput.value = window.PAGE_META.keywords || '';

        modal.classList.remove('hidden');
    };

    window.closePageSettings = function() {
        const modal = document.getElementById('page-settings-modal');
        if (modal) modal.classList.add('hidden');
    };

    window.savePageSettings = function() {
        const titleInput = document.getElementById('setting-page-title');
        const slugInput = document.getElementById('setting-page-slug');
        const descInput = document.getElementById('setting-page-description');
        const kwInput = document.getElementById('setting-page-keywords');

        window.PAGE_META.title = titleInput ? titleInput.value : '';
        window.PAGE_META.slug = slugInput ? slugInput.value : '';
        window.PAGE_META.description = descInput ? descInput.value : '';
        window.PAGE_META.keywords = kwInput ? kwInput.value : '';

        window.closePageSettings();
        window.showToast('Metadata stránky byla uložena v editoru. Nezapomeňte uložit stránku.', 'warning');
    };

    window.saveCmsRepoSettings = function() {
        const urlInput = document.getElementById('cms-repo-url-input');
        const repoUrl = urlInput ? urlInput.value.trim() : '';

        fetch('settings.php?action=save_cms_repo', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ repo_url: repoUrl })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                window.showToast(data.message, 'success');
            } else {
                window.showToast('Chyba: ' + data.message, 'error');
            }
        })
        .catch(function() {
            window.showToast('Chyba při ukládání repositáře CMS.', 'error');
        });
    };

    window.saveProjectRepoSettings = function() {
        const toggle = document.getElementById('enable-project-git-toggle');
        const urlInput = document.getElementById('project-repo-url-input');
        const tokenInput = document.getElementById('github-token-input');

        const enabled = toggle ? toggle.checked : true;
        const repoUrl = urlInput ? urlInput.value.trim() : '';
        const token = tokenInput ? tokenInput.value.trim() : '';

        fetch('settings.php?action=save_project_repo', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                enable_project_git: enabled,
                project_repo_url: repoUrl,
                github_token: token
            })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                window.showToast(data.message, 'success');
            } else {
                window.showToast('Chyba: ' + data.message, 'error');
            }
        })
        .catch(function() {
            window.showToast('Chyba při ukládání nastavení Git.', 'error');
        });
    };

    window.runUpdate = function() {
        window.showConfirmModal({
            title: 'Aktualizace systému',
            message: 'Opravdu chcete aktualizovat systém Fida CMS z GitHubu?',
            confirmText: 'Aktualizovat nyní',
            isDanger: false,
            icon: 'fa-refresh',
            onConfirm: function() {
                window.showToast('Probíhá aktualizace CMS...', 'warning');
                fetch('update.php', { method: 'POST' })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.status === 'success') {
                        window.showToast(data.message, 'success');
                        setTimeout(function() { window.location.reload(); }, 1500);
                    } else {
                        window.showToast('Chyba aktualizace: ' + data.message, 'error');
                    }
                })
                .catch(function() {
                    window.showToast('Chyba při komunikaci se serverem.', 'error');
                });
            }
        });
    };

    window.createNewPage = function() {
        const filename = prompt("Zadejte název nové stránky (např. sluzby):");
        if (!filename) return;

        fetch('create_page.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ filename: filename })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                window.showToast(data.message, 'success');
                setTimeout(function() {
                    window.location.href = 'index.php?lang=' + window.UI_LANG + '&page=' + encodeURIComponent(data.filename) + '&view=editor';
                }, 1000);
            } else {
                window.showToast('Chyba: ' + data.message, 'error');
            }
        })
        .catch(function() {
            window.showToast('Chyba při vytváření stránky.', 'error');
        });
    };

    window.deleteCurrentPage = function() {
        window.showConfirmModal({
            title: 'Smazat stránku',
            message: 'Opravdu chcete nenávratně smazat aktuální stránku? Tato akce nelze vrátit.',
            confirmText: 'Smazat stránku',
            isDanger: true,
            icon: 'fa-trash',
            onConfirm: function() {
                fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ page: cmsData.currentPage || 'index.php' })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    window.showToast(data.message, data.status === 'success' ? 'success' : 'error');
                    if (data.status === 'success') {
                        setTimeout(function() { window.location.href = 'index.php'; }, 1200);
                    }
                });
            }
        });
    };

    window.deletePage = function(filename) {
        window.showConfirmModal({
            title: 'Smazat stránku',
            message: 'Opravdu chcete nenávratně smazat stránku "' + filename + '"? Tato akce nelze vrátit.',
            confirmText: 'Smazat stránku',
            isDanger: true,
            icon: 'fa-trash',
            onConfirm: function() {
                fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ page: filename })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    window.showToast(data.message, data.status === 'success' ? 'success' : 'error');
                    if (data.status === 'success') {
                        setTimeout(function() { window.location.href = 'index.php?lang=' + window.UI_LANG + '&view=pages'; }, 1000);
                    }
                });
            }
        });
    };

    window.toggleSidebar = function() {
        const sidebar = document.getElementById('sidebar-left');
        const icon = document.getElementById('sidebar-toggle-icon');
        const toggleText = document.querySelector('#sidebar-toggle-btn .sidebar-text');
        
        if (!sidebar) return;
        sidebar.classList.toggle('collapsed');
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('fida_cms_sidebar_collapsed', isCollapsed ? 'true' : 'false');
        
        if (isCollapsed) {
            if (icon) icon.className = 'fa fa-angle-double-right';
            if (toggleText) toggleText.innerText = '';
        } else {
            if (icon) icon.className = 'fa fa-angle-double-left';
            if (toggleText) toggleText.innerText = 'Zmenšit panel';
        }
    };

    window.filterPagesList = function() {
        const el = document.getElementById('pages-search-input');
        const q = (el ? el.value : '').toLowerCase();
        const cards = document.querySelectorAll('#pages-grid .page-card');
        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            const name = card.getAttribute('data-page-name') || '';
            if (!q || name.indexOf(q) !== -1) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        }
    };

    window.submitChangePassword = function() {
        const passOldEl = document.getElementById('pass-old');
        const passNewEl = document.getElementById('pass-new');
        const passConfirmEl = document.getElementById('pass-confirm');
        const oldPass = passOldEl ? passOldEl.value : '';
        const newPass = passNewEl ? passNewEl.value : '';
        const confirmPass = passConfirmEl ? passConfirmEl.value : '';

        if (!oldPass) {
            window.showToast('Zadejte stávající heslo.', 'error');
            return;
        }
        if (!newPass || newPass.length < 4) {
            window.showToast('Nové heslo musí mít alespoň 4 znaky.', 'error');
            return;
        }
        if (newPass !== confirmPass) {
            window.showToast('Nová hesla se neshodují.', 'error');
            return;
        }

        fetch('settings.php?action=change_password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ old_password: oldPass, new_password: newPass })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                window.showToast(data.message, 'success');
                if (passOldEl) passOldEl.value = '';
                if (passNewEl) passNewEl.value = '';
                if (passConfirmEl) passConfirmEl.value = '';
            } else {
                window.showToast('Chyba: ' + data.message, 'error');
            }
        })
        .catch(function() {
            window.showToast('Chyba při změně hesla.', 'error');
        });
    };

    // Plugins & FileManager & Theme functions
    let pluginList = [];
    let fmFiles = [];
    let themeList = [];

    window.loadPlugins = function() {
        const container = document.getElementById('plugins-container');
        if (container) container.innerHTML = '<div class="col-span-full text-center py-12 text-slate-500"><i class="fa fa-circle-o-notch fa-spin text-2xl mb-3"></i><p class="text-xs">Načítám pluginy...</p></div>';

        fetch('plugins.php?action=list')
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                pluginList = data.plugins || [];
                window.renderPlugins();
            } else {
                if (container) container.innerHTML = '<div class="col-span-full text-center py-12 text-red-400"><i class="fa fa-exclamation-circle text-2xl mb-2"></i><p class="text-xs">Chyba při načítání pluginů.</p></div>';
            }
        })
        .catch(function() {
            if (container) container.innerHTML = '<div class="col-span-full text-center py-12 text-red-400"><i class="fa fa-exclamation-circle text-2xl mb-2"></i><p class="text-xs">Chyba komunikace se serverem.</p></div>';
        });
    };

    window.renderPlugins = function() {
        const container = document.getElementById('plugins-container');
        if (!container) return;

        if (!pluginList || pluginList.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center py-12 text-slate-500"><i class="fa fa-puzzle-piece text-3xl mb-3 opacity-40 block"></i><p class="text-sm font-semibold">Žádné pluginy nebyly nalezeny</p><p class="text-xs text-slate-600 mt-1">Nahrajte plugin přes tlačítko výše.</p></div>';
            return;
        }

        let html = '';
        for (let i = 0; i < pluginList.length; i++) {
            const plugin = pluginList[i];
            const isInstalled = plugin.is_installed;
            const isActive = plugin.is_active;

            html += '<div class="bg-slate-900 border border-white/5 hover:border-indigo-500/30 rounded-2xl p-6 flex flex-col justify-between transition-all hover:shadow-xl group">';
            html += '<div>';
            html += '<div class="flex items-start justify-between mb-4">';
            html += '<div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-xl font-bold group-hover:scale-105 transition-transform"><i class="fa ' + (plugin.icon || 'fa-puzzle-piece') + '"></i></div>';
            html += '<div class="flex items-center gap-2">';
            if (isInstalled) {
                html += '<span class="px-2.5 py-1 rounded-full text-[10px] font-bold ' + (isActive ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-slate-800 text-slate-400 border border-white/5') + '">' + (isActive ? 'Aktivní' : 'Neaktivní') + '</span>';
            }
            html += '</div></div>';
            html += '<h3 class="text-base font-bold text-white mb-1 group-hover:text-indigo-300 transition-colors">' + (plugin.name || plugin.id) + ' <span class="text-xs font-mono text-slate-500 font-normal">v' + (plugin.version || '1.0') + '</span></h3>';
            html += '<p class="text-xs text-slate-400 mb-4 line-clamp-2">' + (plugin.description || 'Bez popisu.') + '</p>';
            html += '</div>';
            html += '<div class="pt-4 border-t border-white/5 flex items-center justify-between gap-2">';
            if (isInstalled) {
                if (isActive) {
                    html += '<button onclick="window.togglePluginState(\'' + plugin.id + '\', false)" class="flex-1 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white py-2 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5"><i class="fa fa-power-off"></i> Deaktivovat</button>';
                } else {
                    html += '<button onclick="window.togglePluginState(\'' + plugin.id + '\', true)" class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white py-2 px-3 rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-600/20 flex items-center justify-center gap-1.5"><i class="fa fa-power-off"></i> Aktivovat</button>';
                }
                html += '<button onclick="window.deletePlugin(\'' + plugin.id + '\')" class="bg-red-950/40 hover:bg-red-600 text-red-300 hover:text-white p-2 rounded-xl text-xs transition-all border border-red-500/20" title="Smazat plugin"><i class="fa fa-trash"></i></button>';
            } else {
                html += '<button onclick="window.installPlugin(\'' + plugin.id + '\')" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-2 px-3 rounded-xl text-xs font-bold transition-all shadow-md shadow-emerald-600/20 flex items-center justify-center gap-1.5"><i class="fa fa-download"></i> Instalovat</button>';
            }
            html += '</div></div>';
        }
        container.innerHTML = html;
    };

    window.togglePluginState = function(pluginId, enable) {
        const action = enable ? 'enable' : 'disable';
        fetch('plugins.php?action=' + action, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ plugin_id: pluginId })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                window.showToast(data.message, 'success');
                window.loadPlugins();
                setTimeout(function() { window.location.reload(); }, 800);
            } else {
                window.showToast('Chyba: ' + data.message, 'error');
            }
        })
        .catch(function() {
            window.showToast('Chyba při změně stavu pluginu.', 'error');
        });
    };

    window.installPlugin = function(pluginId) {
        fetch('plugins.php?action=install', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ plugin_id: pluginId })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                window.showToast(data.message, 'success');
                window.loadPlugins();
            } else {
                window.showToast('Chyba: ' + data.message, 'error');
            }
        })
        .catch(function() {
            window.showToast('Chyba při instalaci pluginu.', 'error');
        });
    };

    window.deletePlugin = function(pluginId) {
        window.showConfirmModal({
            title: 'Smazat plugin',
            message: 'Opravdu chcete smazat plugin "' + pluginId + '"?',
            confirmText: 'Smazat plugin',
            isDanger: true,
            icon: 'fa-puzzle-piece',
            onConfirm: function() {
                fetch('plugins.php?action=delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ plugin_id: pluginId })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.status === 'success') {
                        window.showToast('Plugin byl úspěšně smazán.', 'success');
                        window.loadPlugins();
                    } else {
                        window.showToast('Chyba: ' + data.message, 'error');
                    }
                })
                .catch(function() {
                    window.showToast('Chyba při mazání pluginu.', 'error');
                });
            }
        });
    };

    window.loadFileManagerFiles = function() {
        const container = document.getElementById('fm-files-container');
        if (container) container.innerHTML = '<div class="text-center py-12 text-slate-500"><i class="fa fa-circle-o-notch fa-spin text-2xl mb-3"></i><p class="text-xs">Načítám seznam souborů...</p></div>';

        fetch('files.php?action=list')
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                fmFiles = data.files || [];
                window.renderFileManagerFiles();
            } else {
                if (container) container.innerHTML = '<div class="text-center py-12 text-red-400"><i class="fa fa-exclamation-circle text-2xl mb-2"></i><p class="text-xs">Chyba při načítání souborů.</p></div>';
            }
        })
        .catch(function() {
            if (container) container.innerHTML = '<div class="text-center py-12 text-red-400"><i class="fa fa-exclamation-circle text-2xl mb-2"></i><p class="text-xs">Chyba komunikace se serverem.</p></div>';
        });
    };

    window.renderFileManagerFiles = function() {
        const container = document.getElementById('fm-files-container');
        if (!container) return;

        if (!fmFiles || fmFiles.length === 0) {
            container.innerHTML = '<div class="text-center py-12 text-slate-500"><i class="fa fa-folder-open text-3xl mb-3 opacity-40 block"></i><p class="text-sm font-semibold">Žádné soubory nenalezeny</p></div>';
            return;
        }

        let html = '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">';
        for (let i = 0; i < fmFiles.length; i++) {
            const file = fmFiles[i];
            const fileUrl = (file.url.indexOf('/') === 0 || file.url.indexOf('http') === 0) ? file.url : ('/' + file.url);
            let thumbHtml = '';
            if (file.type === 'image') {
                thumbHtml = '<img src="' + fileUrl + '" alt="' + file.name + '" class="w-full h-full object-cover rounded-xl transition-transform duration-300 group-hover:scale-105" loading="lazy">';
            } else {
                let iconClass = 'fa-file-o';
                if (file.ext === 'pdf') iconClass = 'fa-file-pdf-o text-red-400';
                else if (file.ext === 'doc' || file.ext === 'docx') iconClass = 'fa-file-word-o text-blue-400';
                else if (file.ext === 'xls' || file.ext === 'xlsx' || file.ext === 'csv') iconClass = 'fa-file-excel-o text-emerald-400';
                else if (file.ext === 'zip' || file.ext === 'rar') iconClass = 'fa-file-archive-o text-amber-400';
                else if (file.ext === 'mp4' || file.ext === 'avi' || file.ext === 'mov') iconClass = 'fa-file-video-o text-purple-400';
                else if (file.ext === 'mp3' || file.ext === 'wav') iconClass = 'fa-file-audio-o text-pink-400';

                thumbHtml = '<div class="w-full h-full flex flex-col items-center justify-center text-slate-400 gap-1 bg-slate-900 rounded-xl"><i class="fa ' + iconClass + ' text-3xl"></i><span class="text-[10px] font-mono uppercase text-slate-500">' + file.ext + '</span></div>';
            }

            html += '<div class="bg-slate-900 border border-white/5 hover:border-indigo-500/40 rounded-2xl p-3 flex flex-col justify-between transition-all hover:shadow-xl group relative overflow-hidden">';
            html += '<div class="h-32 w-full mb-2 overflow-hidden rounded-xl bg-slate-950 relative cursor-pointer" onclick="window.openFmPreviewModal(\'' + file.name + '\')">';
            html += thumbHtml;
            html += '<div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2"><button title="Náhled" class="w-8 h-8 rounded-lg bg-slate-900/90 text-white hover:bg-indigo-600 flex items-center justify-center text-xs transition-colors"><i class="fa fa-eye"></i></button></div>';
            html += '</div>';
            html += '<div><div class="text-xs font-bold text-slate-200 truncate" title="' + file.name + '">' + file.name + '</div>';
            html += '<div class="flex items-center justify-between text-[10px] text-slate-500 mt-1 font-mono"><span>' + (file.size_formatted || '') + '</span><span>' + (file.dimensions || (file.ext ? file.ext.toUpperCase() : '')) + '</span></div></div>';
            html += '<div class="flex items-center gap-1.5 mt-3 pt-2 border-t border-white/5">';
            html += '<button onclick="window.copyFmUrl(\'' + fileUrl + '\', this)" class="flex-1 bg-slate-800 hover:bg-indigo-600 text-slate-300 hover:text-white py-1.5 px-2 rounded-lg text-[10px] font-bold transition-all flex items-center justify-center gap-1" title="Kopírovat cestu"><i class="fa fa-copy"></i> Kopírovat</button>';
            html += '<button onclick="window.deleteFmFile(\'' + file.name + '\')" class="bg-red-950/40 hover:bg-red-600 text-red-300 hover:text-white p-1.5 rounded-lg text-[10px] transition-all" title="Smazat soubor"><i class="fa fa-trash"></i></button>';
            html += '</div></div>';
        }
        html += '</div>';
        container.innerHTML = html;
    };

    window.copyFmUrl = function(url, btn) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(function() {
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fa fa-check text-emerald-400"></i> Zkopírováno!';
                setTimeout(function() { btn.innerHTML = originalText; }, 2000);
            }).catch(function() {
                prompt("Cesta k souboru (CTRL+C pro zkopírování):", url);
            });
        } else {
            prompt("Cesta k souboru (CTRL+C pro zkopírování):", url);
        }
    };

    window.deleteFmFile = function(filename) {
        window.showConfirmModal({
            title: 'Smazat soubor',
            message: 'Opravdu chcete smazat soubor "' + filename + '"?',
            confirmText: 'Smazat soubor',
            isDanger: true,
            icon: 'fa-trash',
            onConfirm: function() {
                fetch('files.php?action=delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ filename: filename })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.status === 'success') {
                        window.showToast('Soubor byl smazán.', 'success');
                        window.loadFileManagerFiles();
                    } else {
                        window.showToast('Chyba: ' + data.message, 'error');
                    }
                })
                .catch(function() {
                    window.showToast('Chyba při mazání souboru.', 'error');
                });
            }
        });
    };

    window.openFmPreviewModal = function(filename) {
        window.open('/uploads/' + filename, '_blank');
    };

    // Initialization on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.switchView === 'function' && cmsData.initialView) {
            window.switchView(cmsData.initialView);
        }

        const isCollapsed = localStorage.getItem('fida_cms_sidebar_collapsed') === 'true';
        if (isCollapsed && typeof window.toggleSidebar === 'function') {
            const sidebar = document.getElementById('sidebar-left');
            if (sidebar && !sidebar.classList.contains('collapsed')) {
                window.toggleSidebar();
            }
        }
    });

})();

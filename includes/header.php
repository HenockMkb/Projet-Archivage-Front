<?php
// Configuration du header (peut être personnalisée par chaque page)
$page_title = $page_title ?? 'Tableau de bord';
$user_name = $user_name ?? 'Benaja Bope';
$user_role = $user_role ?? 'Archiviste';
$user_initials = $user_initials ?? 'JD';
$notifications_count = $notifications_count ?? 3;
$show_search = $show_search ?? true;
?>

<!-- Header responsive amélioré -->
<header class="sticky top-0 z-30 bg-white/95 backdrop-blur-sm">
    <div class="header-content flex items-center justify-between h-14 pt-2 px-3 sm:px-4 lg:px-6 max-w-full overflow-hidden">
        <div class="flex items-center min-w-0 flex-1 mr-2">
            <!-- Toggle sidebar mobile -->
            <button id="sidebar-toggle" class="lg:hidden mr-2 sm:mr-3 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all duration-200 flex-shrink-0">
                <i class="fas fa-bars text-sm sm:text-lg"></i>
            </button>
            
            <!-- Titre et breadcrumb -->
            <div class="flex items-center space-x-1 sm:space-x-2 min-w-0 flex-1 overflow-hidden">
                <h2 class="text-base sm:text-lg lg:text-xl xl:text-2xl font-bold text-gray-900 truncate"><?= htmlspecialchars($page_title) ?></h2>
                
                <?php if (isset($breadcrumb) && !empty($breadcrumb)): ?>
                <nav class="hidden lg:flex items-center space-x-1 text-xs xl:text-sm text-gray-500 overflow-hidden">
                    <i class="fas fa-chevron-right text-xs flex-shrink-0"></i>
                    <?php foreach ($breadcrumb as $index => $item): ?>
                        <?php if ($index > 0): ?>
                            <i class="fas fa-chevron-right text-xs flex-shrink-0"></i>
                        <?php endif; ?>
                        <?php if (isset($item['url'])): ?>
                            <a href="<?= htmlspecialchars($item['url']) ?>" class="hover:text-gray-700 transition-colors duration-200 truncate max-w-32">
                                <?= htmlspecialchars($item['label']) ?>
                            </a>
                        <?php else: ?>
                            <span class="text-gray-900 font-medium truncate max-w-32"><?= htmlspecialchars($item['label']) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="flex items-center space-x-1 sm:space-x-2 flex-shrink-0">
            <!-- Bouton recherche mobile -->
            <?php if ($show_search): ?>
            <button id="mobile-search-btn" class="md:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all duration-200 flex-shrink-0">
                <i class="fas fa-search text-sm"></i>
            </button>
            <?php endif; ?>
            
            <!-- Barre de recherche desktop -->
            <?php if ($show_search): ?>
            <div class="relative hidden md:block flex-shrink-0">
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Rechercher..." 
                        class="w-48 lg:w-64 xl:w-80 pl-8 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 text-sm"
                        id="global-search"
                    >
                    <i class="fas fa-search absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        <i class="fas fa-sliders-h text-xs"></i>
                    </button>
                </div>
                
                <!-- Résultats de recherche rapide -->
                <div id="search-results" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-200 py-2 hidden max-h-80 overflow-y-auto z-50">
                    <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Résultats récents
                    </div>
                    <!-- Les résultats seront ajoutés dynamiquement -->
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Actions rapides - Masquées sur écrans très petits -->
            <div class="hidden xl:flex items-center space-x-1 flex-shrink-0">
                <button id="quick-add-btn" class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 group flex-shrink-0" title="Nouvelle tâche">
                    <i class="fas fa-plus text-sm group-hover:scale-110 transition-transform duration-200"></i>
                </button>
                <button id="quick-upload-btn" class="p-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-xl transition-all duration-200 group flex-shrink-0" title="Importer">
                    <i class="fas fa-upload text-sm group-hover:scale-110 transition-transform duration-200"></i>
                </button>
            </div>
            
            <!-- Notifications -->
            <div class="relative flex-shrink-0">
                <button 
                    id="notifications-btn" 
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all duration-200 group flex-shrink-0"
                    title="Notifications"
                >
                    <i class="fas fa-bell text-sm group-hover:scale-110 transition-transform duration-200"></i>
                    <?php if ($notifications_count > 0): ?>
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                        <?= $notifications_count > 9 ? '9+' : $notifications_count ?>
                    </span>
                    <?php endif; ?>
                </button>
                
                <!-- Panneau des notifications responsive -->
                <div id="notifications-panel" class="absolute right-0 mt-2 w-72 sm:w-80 lg:w-96 bg-white rounded-xl shadow-xl border border-gray-200 py-2 hidden z-50 max-w-[calc(100vw-1rem)]" style="right: 0;">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900 text-sm">Notifications</h3>
                            <button id="mark-all-read-btn" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                Tout marquer
                            </button>
                        </div>
                    </div>
                    
                    <div class="max-h-80 overflow-y-auto">
                        <!-- Exemple de notifications -->
                        <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50 cursor-pointer" onclick="goToNotification('document-1')">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-alt text-blue-600 text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate">Nouveau document</div>
                                    <div class="text-xs text-gray-500 mt-1 truncate">Rapport mensuel</div>
                                    <div class="text-xs text-gray-400 mt-1">Il y a 5 min</div>
                                </div>
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1"></div>
                            </div>
                        </div>
                        
                        <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50 cursor-pointer" onclick="goToNotification('validation-1')">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-yellow-600 text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate">En attente</div>
                                    <div class="text-xs text-gray-500 mt-1 truncate">Validation requise</div>
                                    <div class="text-xs text-gray-400 mt-1">Il y a 1h</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 py-3 border-t border-gray-100">
                        <a href="notifications" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                            Voir tout
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Profil utilisateur responsive -->
            <div class="relative flex-shrink-0">
                <button 
                    id="profile-btn" 
                    class="flex items-center space-x-1 sm:space-x-2 p-1.5 sm:p-2 hover:bg-gray-100 rounded-xl transition-all duration-200 group"
                >
                    <div class="relative flex-shrink-0">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-sm">
                            <span class="text-white font-semibold text-xs"><?= htmlspecialchars($user_initials) ?></span>
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="hidden sm:block text-left min-w-0 max-w-24 lg:max-w-32">
                        <div class="text-xs sm:text-sm font-semibold text-gray-900 truncate"><?= htmlspecialchars($user_name) ?></div>
                        <div class="text-xs text-gray-500 truncate hidden lg:block"><?= htmlspecialchars($user_role) ?></div>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs group-hover:text-gray-600 transition-colors duration-200 hidden sm:block flex-shrink-0"></i>
                </button>
                
                <!-- Menu déroulant responsive -->
                <div id="profile-menu" class="absolute right-0 mt-2 w-48 sm:w-56 lg:w-64 bg-white rounded-xl shadow-xl border border-gray-200 py-2 hidden z-50">
                    <!-- Info utilisateur -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-semibold text-xs"><?= htmlspecialchars($user_initials) ?></span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-semibold text-gray-900 truncate text-sm"><?= htmlspecialchars($user_name) ?></div>
                                <div class="text-xs text-gray-500 truncate"><?= htmlspecialchars($user_role) ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu items -->
                    <div class="py-2">
                        <a href="profile" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-user w-4 mr-3 text-gray-400 flex-shrink-0"></i>
                            <span class="truncate">Mon profil</span>
                        </a>
                        <a href="settings" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-cog w-4 mr-3 text-gray-400 flex-shrink-0"></i>
                            <span class="truncate">Paramètres</span>
                        </a>
                        <a href="help" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-question-circle w-4 mr-3 text-gray-400 flex-shrink-0"></i>
                            <span class="truncate">Aide</span>
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-100 py-2">
                        <button 
                            id="logout-btn" 
                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200"
                        >
                            <i class="fas fa-sign-out-alt w-4 mr-3 flex-shrink-0"></i>
                            <span class="truncate">Déconnexion</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recherche mobile en plein écran -->
    <?php if ($show_search): ?>
    <div id="mobile-search-overlay" class="md:hidden fixed inset-0 bg-white z-50 hidden">
        <div class="flex items-center p-4 border-b border-gray-200">
            <button id="mobile-search-close" class="mr-3 p-2 text-gray-600 hover:text-gray-900 flex-shrink-0">
                <i class="fas fa-arrow-left text-lg"></i>
            </button>
            <div class="flex-1 relative min-w-0">
                <input 
                    type="text" 
                    placeholder="Rechercher..." 
                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base"
                    id="mobile-global-search"
                    autofocus
                >
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        
        <!-- Résultats de recherche mobile -->
        <div id="mobile-search-results" class="flex-1 overflow-y-auto p-4">
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-search text-3xl mb-4"></i>
                <p>Tapez pour rechercher des documents...</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</header>

<script>
// Gestion des interactions du header responsive
document.addEventListener('DOMContentLoaded', function() {
    console.log('Header JavaScript chargé'); // Debug
    
    // Boutons d'actions rapides
    const quickAddBtn = document.getElementById('quick-add-btn');
    const quickUploadBtn = document.getElementById('quick-upload-btn');
    
    if (quickAddBtn) {
        quickAddBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Bouton nouvelle tâche cliqué'); // Debug
            // Rediriger vers la page de création de tâche ou ouvrir un modal
            if (typeof createNewTask === 'function') {
                createNewTask();
            } else {
                showToast('Fonctionnalité à venir - Nouvelle tâche', 'info');
            }
        });
    }
    
    if (quickUploadBtn) {
        quickUploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Bouton upload cliqué'); // Debug
            window.location.href = 'upload';
        });
    }
    
    // Toggle notifications
    const notificationsBtn = document.getElementById('notifications-btn');
    const notificationsPanel = document.getElementById('notifications-panel');
    
    if (notificationsBtn && notificationsPanel) {
        console.log('Notifications trouvées'); // Debug
        notificationsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Bouton notifications cliqué'); // Debug
            
            const isHidden = notificationsPanel.classList.contains('hidden');
            notificationsPanel.classList.toggle('hidden');
            
            // Fermer le menu profil s'il est ouvert
            const profileMenu = document.getElementById('profile-menu');
            if (profileMenu && !profileMenu.classList.contains('hidden')) {
                profileMenu.classList.add('hidden');
            }
            
            console.log('Panel notifications:', isHidden ? 'ouvert' : 'fermé'); // Debug
        });
    } else {
        console.log('Notifications non trouvées'); // Debug
    }
    
    // Bouton marquer tout comme lu
    const markAllReadBtn = document.getElementById('mark-all-read-btn');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            // Simuler le marquage comme lu
            document.querySelectorAll('#notifications-panel .w-2.h-2.bg-blue-500').forEach(dot => {
                dot.remove();
            });
            showToast('Toutes les notifications marquées comme lues', 'success');
        });
    }
    
    // Toggle profile menu
    const profileBtn = document.getElementById('profile-btn');
    const profileMenu = document.getElementById('profile-menu');
    
    if (profileBtn && profileMenu) {
        console.log('Profile trouvé'); // Debug
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Bouton profile cliqué'); // Debug
            
            const isHidden = profileMenu.classList.contains('hidden');
            profileMenu.classList.toggle('hidden');
            
            // Fermer les notifications si ouvertes
            if (notificationsPanel && !notificationsPanel.classList.contains('hidden')) {
                notificationsPanel.classList.add('hidden');
            }
            
            console.log('Menu profile:', isHidden ? 'ouvert' : 'fermé'); // Debug
        });
    } else {
        console.log('Profile non trouvé'); // Debug
    }
    
    // Recherche mobile
    const mobileSearchBtn = document.getElementById('mobile-search-btn');
    const mobileSearchOverlay = document.getElementById('mobile-search-overlay');
    const mobileSearchClose = document.getElementById('mobile-search-close');
    const mobileGlobalSearch = document.getElementById('mobile-global-search');
    
    if (mobileSearchBtn && mobileSearchOverlay) {
        mobileSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Recherche mobile ouverte'); // Debug
            mobileSearchOverlay.classList.remove('hidden');
            setTimeout(() => {
                if (mobileGlobalSearch) mobileGlobalSearch.focus();
            }, 100);
        });
    }
    
    if (mobileSearchClose && mobileSearchOverlay) {
        mobileSearchClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            mobileSearchOverlay.classList.add('hidden');
        });
    }
    
    // Recherche globale desktop
    const globalSearch = document.getElementById('global-search');
    const searchResults = document.getElementById('search-results');
    
    if (globalSearch && searchResults) {
        globalSearch.addEventListener('input', function() {
            if (this.value.length > 2) {
                searchResults.classList.remove('hidden');
                performSearch(this.value);
            } else {
                searchResults.classList.add('hidden');
            }
        });
        
        globalSearch.addEventListener('focus', function() {
            if (this.value.length > 2) {
                searchResults.classList.remove('hidden');
            }
        });
        
        // Redirection vers la page de recherche avec Enter
        globalSearch.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                if (query) {
                    window.location.href = `search?q=${encodeURIComponent(query)}`;
                }
            }
        });
    }
    
    // Recherche mobile avec redirection
    if (mobileGlobalSearch) {
        mobileGlobalSearch.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                if (query) {
                    window.location.href = `search?q=${encodeURIComponent(query)}`;
                }
            }
        });
        
        mobileGlobalSearch.addEventListener('input', function() {
            const mobileSearchResults = document.getElementById('mobile-search-results');
            if (this.value.length > 0) {
                if (mobileSearchResults) {
                    mobileSearchResults.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-spinner fa-spin text-2xl mb-4"></i>
                            <p>Tapez Entrée pour rechercher...</p>
                        </div>
                    `;
                }
            } else {
                if (mobileSearchResults) {
                    mobileSearchResults.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-search text-3xl mb-4"></i>
                            <p>Tapez pour rechercher des documents...</p>
                        </div>
                    `;
                }
            }
        });
    }
    
    // Gestion du logout
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                // Simuler la déconnexion
                showToast('Déconnexion en cours...', 'info');
                setTimeout(() => {
                    window.location.href = 'login';
                }, 1000);
            }
        });
    }
    
    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (mobileSearchOverlay && !mobileSearchOverlay.classList.contains('hidden')) {
                mobileSearchOverlay.classList.add('hidden');
            }
            if (notificationsPanel && !notificationsPanel.classList.contains('hidden')) {
                notificationsPanel.classList.add('hidden');
            }
            if (profileMenu && !profileMenu.classList.contains('hidden')) {
                profileMenu.classList.add('hidden');
            }
        }
    });
    
    // Fermer les menus en cliquant ailleurs
    document.addEventListener('click', function(e) {
        // Fermer notifications
        if (notificationsPanel && 
            !e.closest('#notifications-btn') && 
            !e.closest('#notifications-panel')) {
            notificationsPanel.classList.add('hidden');
        }
        
        // Fermer profile menu
        if (profileMenu && 
            !e.closest('#profile-btn') && 
            !e.closest('#profile-menu')) {
            profileMenu.classList.add('hidden');
        }
        
        // Fermer résultats de recherche
        if (searchResults && 
            !e.closest('#global-search') && 
            !e.closest('#search-results')) {
            searchResults.classList.add('hidden');
        }
    });
});

// Fonction de recherche simulée
function performSearch(query) {
    const searchResults = document.getElementById('search-results');
    if (searchResults) {
        searchResults.innerHTML = `
            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Résultats pour "${query}"
            </div>
            <div class="px-4 py-2 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='documents'">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-file-alt text-blue-500"></i>
                    <span class="text-sm">Document contenant "${query}"</span>
                </div>
            </div>
            <div class="px-4 py-2 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='collections'">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-folder text-yellow-500"></i>
                    <span class="text-sm">Collection liée à "${query}"</span>
                </div>
            </div>
            <div class="px-4 py-2 border-t border-gray-100">
                <button onclick="window.location.href='search?q=${encodeURIComponent(query)}'" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                    Voir tous les résultats
                </button>
            </div>
        `;
    }
}

// Fonction pour aller à une notification spécifique
function goToNotification(notificationId) {
    console.log('Navigation vers notification:', notificationId);
    showToast('Navigation vers la notification', 'info');
    // Ici vous pouvez ajouter la logique pour naviguer vers la notification
}

// Fonction toast globale pour le header
function showToast(message, type = 'info') {
    // Créer le toast s'il n'existe pas
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(toastContainer);
    }
    
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    const icons = {
        success: 'fa-check',
        error: 'fa-times',
        warning: 'fa-exclamation',
        info: 'fa-info'
    };
    
    const toast = document.createElement('div');
    toast.className = `${colors[type]} text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 transform translate-x-full transition-transform duration-300`;
    toast.innerHTML = `
        <i class="fas ${icons[type]} text-sm"></i>
        <span class="text-sm">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
            <i class="fas fa-times text-xs"></i>
        </button>
    `;
    
    toastContainer.appendChild(toast);
    
    // Animer l'entrée
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto-suppression après 3 secondes
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, 3000);
}
</script> 
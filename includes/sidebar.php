<?php
// Configuration de la navigation (peut être personnalisée)
$current_page = $current_page ?? 'index';

// Déterminer le chemin de base selon le répertoire courant
$base_path = '';
$current_script = $_SERVER['PHP_SELF'];

// Si on est dans un sous-répertoire (admin/, reports/, etc.)
if (strpos($current_script, '/admin/') !== false) {
    $base_path = '../';
} elseif (substr_count($current_script, '/') > 1) {
    // Pour d'autres sous-répertoires potentiels
    $depth = substr_count(dirname($current_script), '/');
    if ($depth > 0) {
        $base_path = str_repeat('../', $depth);
    }
}

// Menu principal
$main_menu = [
    [
        'id' => 'dashboard',
        'label' => 'Tableau de bord',
        'icon' => 'fa-chart-line',
        'url' => $base_path . 'index.php',
        'badge' => null
    ],
    [
        'id' => 'upload',
        'label' => 'Importer',
        'icon' => 'fa-cloud-upload-alt',
        'url' => $base_path . 'upload.php',
        'badge' => null
    ],
    [
        'id' => 'inbox',
        'label' => 'File d\'attente',
        'icon' => 'fa-inbox',
        'url' => $base_path . 'inbox.php',
        'badge' => 23,
        'badge_type' => 'warning'
    ],
    [
        'id' => 'documents',
        'label' => 'Documents',
        'icon' => 'fa-file-alt',
        'url' => $base_path . 'documents.php',
        'badge' => null
    ],
    [
        'id' => 'collections',
        'label' => 'Collections',
        'icon' => 'fa-folder-open',
        'url' => $base_path . 'collections.php',
        'badge' => null
    ],
    [
        'id' => 'search',
        'label' => 'Recherche',
        'icon' => 'fa-search',
        'url' => $base_path . 'search.php',
        'badge' => null
    ],
    [
        'id' => 'workflows',
        'label' => 'Workflows',
        'icon' => 'fa-project-diagram',
        'url' => $base_path . 'workflows.php',
        'badge' => 5,
        'badge_type' => 'info'
    ],
    [
        'id' => 'reports',
        'label' => 'Rapports',
        'icon' => 'fa-chart-bar',
        'url' => $base_path . 'reports.php',
        'badge' => null
    ],
    [
        'id' => 'settings',
        'label' => 'Paramètres',
        'icon' => 'fa-cog',
        'url' => $base_path . 'settings.php',
        'badge' => null
    ]
];

// Menu administration
$admin_menu = [
    [
        'id' => 'users',
        'label' => 'Utilisateurs',
        'icon' => 'fa-users',
        'url' => $base_path . 'admin/users.php',
        'badge' => null
    ],
    [
        'id' => 'roles',
        'label' => 'Rôles',
        'icon' => 'fa-user-shield',
        'url' => $base_path . 'admin/roles.php',
        'badge' => null
    ]
    
];

function isActivePage($menuId, $currentPage) {
    return $menuId === $currentPage || 
           ($menuId === 'dashboard' && $currentPage === 'index') ||
           (strpos($currentPage, $menuId) === 0);
}

function getBadgeClasses($type) {
    switch ($type) {
        case 'warning':
            return 'bg-yellow-100 text-yellow-800';
        case 'error':
            return 'bg-red-100 text-red-800';
        case 'success':
            return 'bg-green-100 text-green-800';
        case 'info':
            return 'bg-blue-100 text-blue-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}
?>

<!-- Sidebar améliorée -->
<aside id="sidebar" class="sidebar group">
    <!-- En-tête du sidebar -->
    <div class="sidebar-header">
        <div class="flex items-center">
            <div class="relative">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-archive text-white text-lg"></i>
                </div>
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full animate-pulse"></div>
            </div>
            <div class="ml-3 sidebar-title opacity-100 transition-opacity duration-200">
                <h1 class="text-xl font-bold text-gray-900">e-Archive</h1>
                <p class="text-xs text-gray-500 font-medium">SGITP v1.0</p>
            </div>
        </div>
        
        <!-- Boutons de contrôle -->
        <div class="flex items-center space-x-2">
            <!-- Close button (mobile only) -->
            <button 
                id="sidebar-close" 
                class="lg:hidden w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all duration-200"
            >
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
    
    <!-- Navigation principale -->
    <nav class="sidebar-nav">
        <div class="nav-menu-section">
            <?php foreach ($main_menu as $item): ?>
            <a 
                href="<?= htmlspecialchars($item['url']) ?>" 
                class="nav-link <?= isActivePage($item['id'], $current_page) ? 'active' : '' ?>"
                title="<?= htmlspecialchars($item['label']) ?>"
                style="display: flex !important; align-items: center !important; gap: 0.5rem !important; padding: 0.5rem 1rem !important; margin-bottom: 0.25rem !important; text-decoration: none !important; border-radius: 0.75rem !important; transition: all 0.2s !important;"
            >
                <div class="nav-link-icon" style="display: flex !important; align-items: center !important; justify-content: center !important; width: 1.25rem !important; height: 1.25rem !important; flex-shrink: 0 !important;">
                    <i class="fas <?= htmlspecialchars($item['icon']) ?>"></i>
                </div>
                <span class="nav-link-text" style="flex: 1 !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;"><?= htmlspecialchars($item['label']) ?></span>
                
                <?php if ($item['badge']): ?>
                <span class="nav-badge <?= getBadgeClasses($item['badge_type'] ?? 'default') ?>" style="margin-left: auto !important; flex-shrink: 0 !important; min-width: 1.5rem !important; text-align: center !important; padding: 0.25rem 0.5rem !important;">
                    <?= $item['badge'] > 99 ? '99+' : $item['badge'] ?>
                </span>
                <?php endif; ?>
                
                <!-- Indicateur de page active -->
                <?php if (isActivePage($item['id'], $current_page)): ?>
                <div class="nav-indicator"></div>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
        
        <!-- Section Administration collapsible -->
        <div class="nav-section">
            <button 
                class="nav-section-toggle" 
                onclick="toggleAdminSection()"
                style="display: flex !important; align-items: center !important; width: 100% !important; padding: 0.5rem 1rem !important; background: none !important; border: none !important; cursor: pointer !important; color: #6b7280 !important; font-size: 0.75rem !important; font-weight: 600 !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; border-radius: 0.5rem !important; transition: all 0.2s !important;"
            >
                <i id="admin-toggle-icon" class="fas fa-chevron-right mr-2 transition-transform duration-200" style="width: 0.75rem !important; height: 0.75rem !important; margin-right: 0.5rem !important;"></i>
                <span>Administration</span>
            </button>
            
            <!-- Menu administration -->
            <div id="admin-menu" class="admin-menu-content nav-menu-section" style="display: none; margin-top: 0.25rem; padding-left: 1.5rem;">
                <?php foreach ($admin_menu as $item): ?>
                <a 
                    href="<?= htmlspecialchars($item['url']) ?>" 
                    class="nav-link <?= isActivePage($item['id'], $current_page) ? 'active' : '' ?>"
                    title="<?= htmlspecialchars($item['label']) ?>"
                    style="display: flex !important; align-items: center !important; gap: 0.5rem !important; padding: 0.5rem 1rem !important; margin-bottom: 0.25rem !important; text-decoration: none !important; border-radius: 0.75rem !important; transition: all 0.2s !important;"
                >
                    <div class="nav-link-icon" style="display: flex !important; align-items: center !important; justify-content: center !important; width: 1.25rem !important; height: 1.25rem !important; flex-shrink: 0 !important;">
                        <i class="fas <?= htmlspecialchars($item['icon']) ?>"></i>
                    </div>
                    <span class="nav-link-text" style="flex: 1 !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;"><?= htmlspecialchars($item['label']) ?></span>
                    
                    <?php if ($item['badge']): ?>
                    <span class="nav-badge <?= getBadgeClasses($item['badge_type'] ?? 'default') ?>" style="margin-left: auto !important; flex-shrink: 0 !important; min-width: 1.5rem !important; text-align: center !important; padding: 0.25rem 0.5rem !important;">
                        <?= $item['badge'] > 99 ? '99+' : $item['badge'] ?>
                    </span>
                    <?php endif; ?>
                    
                    <!-- Indicateur de page active -->
                    <?php if (isActivePage($item['id'], $current_page)): ?>
                    <div class="nav-indicator"></div>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>
    
</aside>



<style>
/* Styles CSS pour la sidebar améliorée */
.sidebar {
    @apply fixed left-0 top-0 z-50 h-full w-72 bg-white border-r border-gray-200 shadow-lg flex flex-col transition-all duration-300 ease-in-out;
    overflow: hidden !important;
}

/* Force flex layout pour les liens de navigation */
.sidebar .nav-link {
    display: flex !important;
    align-items: center !important;
    flex-direction: row !important;
    gap: 0.5rem !important;
    padding: 0.5rem 1rem !important;
}

.sidebar .nav-link > * {
    display: inline-flex !important;
    align-items: center !important;
}



.sidebar-header {
    @apply flex items-center justify-between border-b border-gray-100;
    padding: 1rem 1rem !important;
    gap: 1rem !important;
    flex-shrink: 0 !important;
    background: white !important;
    position: relative !important;
    z-index: 10 !important;
}

.sidebar-nav {
    flex: 1 1 0% !important;
    padding: 1rem 0.75rem !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    scrollbar-width: thin !important;
    scrollbar-color: #cbd5e1 #f1f5f9 !important;
    max-height: calc(100vh - 100px) !important;
}

/* Custom scrollbar pour webkit browsers */
.sidebar-nav::-webkit-scrollbar {
    width: 6px !important;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: #f1f5f9 !important;
    border-radius: 3px !important;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: #cbd5e1 !important;
    border-radius: 3px !important;
    transition: background 0.2s ease !important;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: #94a3b8 !important;
}

/* Pour éviter que le contenu touche les bords lors du scroll */
.sidebar-nav {
    padding-right: 0.5rem !important;
    scroll-behavior: smooth !important;
}

/* Indicateur de scroll en haut et en bas */
.sidebar-nav::before,
.sidebar-nav::after {
    content: '';
    position: sticky !important;
    left: 0 !important;
    right: 0 !important;
    height: 8px !important;
    background: linear-gradient(to bottom, rgba(255,255,255,0.8), transparent) !important;
    pointer-events: none !important;
    z-index: 5 !important;
}

.sidebar-nav::before {
    top: 0 !important;
    margin-bottom: -8px !important;
}

.sidebar-nav::after {
    bottom: 0 !important;
    margin-top: -8px !important;
    background: linear-gradient(to top, rgba(255,255,255,0.8), transparent) !important;
}

.nav-link {
    @apply relative flex items-center text-gray-700 rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-blue-700 hover:shadow-sm group/link;
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    padding: 0.5rem 1rem !important;
    margin-bottom: 0.25rem !important;
    transform: translateX(0) !important;
}

.nav-link:hover {
    transform: translateX(4px) !important;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%) !important;
    border-left: 3px solid #3b82f6 !important;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15) !important;
}

.nav-link.active {
    @apply bg-blue-50 text-blue-700 font-medium shadow-sm;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%) !important;
    border-left: 3px solid #3b82f6 !important;
    transform: translateX(4px) !important;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2) !important;
}

.nav-link-icon {
    @apply w-5 h-5 flex items-center justify-center text-current opacity-75 group-hover/link:opacity-100 transition-all duration-200 flex-shrink-0;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
    min-width: 1.25rem !important;
    min-height: 1.25rem !important;
}

.nav-link:hover .nav-link-icon {
    color: #2563eb !important;
    transform: scale(1.1) !important;
    opacity: 1 !important;
}

.nav-link-text {
    @apply font-medium truncate transition-all duration-200 flex-1;
    flex: 1 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

.nav-link:hover .nav-link-text {
    color: #2563eb !important;
    font-weight: 600 !important;
}

.nav-badge {
    @apply px-2 py-1 text-xs font-semibold rounded-full flex-shrink-0 transition-all duration-200;
    margin-left: auto !important;
    flex-shrink: 0 !important;
    min-width: 1.5rem !important;
    text-align: center !important;
}

.nav-link:hover .nav-badge {
    transform: scale(1.05) !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

.nav-indicator {
    @apply absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-6 bg-blue-600 rounded-r-full;
}

.nav-section {
    margin-bottom: 1rem !important;
}

.nav-menu-section {
    display: block !important;
    margin-bottom: 1rem !important;
}

.nav-menu-section:last-child {
    margin-bottom: 0 !important;
}

.nav-section-toggle {
    transition: all 0.2s ease-in-out !important;
}

.nav-section-toggle:hover {
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%) !important;
    color: #2563eb !important;
    transform: translateX(2px) !important;
    border-radius: 0.75rem !important;
    box-shadow: 0 1px 4px rgba(59, 130, 246, 0.1) !important;
}

.admin-menu-content {
    overflow: hidden !important;
    transition: all 0.3s ease-in-out !important;
}

.admin-menu-content.show {
    display: block !important;
}



.sidebar-footer {
    @apply border-t border-gray-100;
    padding: 1rem !important;
    gap: 1rem !important;
    display: flex !important;
    flex-direction: column !important;
    flex-shrink: 0 !important;
    background: white !important;
}

.status-card {
    @apply bg-gray-50 rounded-xl;
    padding: 0.5rem !important;
    gap: 0.5rem !important;
}

.storage-info {
    @apply bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl;
    padding: 0.5rem !important;
    gap: 0.5rem !important;
    display: flex !important;
    flex-direction: column !important;
}

.help-card {
    @apply rounded-xl overflow-hidden;
}



/* Responsive */
@media (max-width: 1023px) {
    .sidebar {
        @apply transform -translate-x-full;
    }
    
    .sidebar.mobile-open {
        @apply translate-x-0;
    }
}
</style>

<script>
// Fonction pour toggle la section Administration
function toggleAdminSection() {
    const adminMenu = document.getElementById('admin-menu');
    const toggleIcon = document.getElementById('admin-toggle-icon');
    
    if (adminMenu.style.display === 'none' || adminMenu.style.display === '') {
        // Ouvrir le menu
        adminMenu.style.display = 'block';
        adminMenu.classList.add('show');
        toggleIcon.style.transform = 'rotate(90deg)';
        
        // Sauvegarder l'état dans localStorage
        localStorage.setItem('admin-section-open', 'true');
    } else {
        // Fermer le menu
        adminMenu.style.display = 'none';
        adminMenu.classList.remove('show');
        toggleIcon.style.transform = 'rotate(0deg)';
        
        // Sauvegarder l'état dans localStorage
        localStorage.setItem('admin-section-open', 'false');
    }
}

// Restaurer l'état au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const isAdminOpen = localStorage.getItem('admin-section-open');
    const adminMenu = document.getElementById('admin-menu');
    const toggleIcon = document.getElementById('admin-toggle-icon');
    
    if (isAdminOpen === 'true') {
        adminMenu.style.display = 'block';
        adminMenu.classList.add('show');
        toggleIcon.style.transform = 'rotate(90deg)';
    }
    
    // Si on est sur une page admin, ouvrir automatiquement la section
    const currentPage = window.location.pathname;
    if (currentPage.includes('/admin/') || currentPage.includes('admin')) {
        adminMenu.style.display = 'block';
        adminMenu.classList.add('show');
        toggleIcon.style.transform = 'rotate(90deg)';
        localStorage.setItem('admin-section-open', 'true');
    }
    
    // Améliorer l'expérience de scroll de la sidebar
    const sidebarNav = document.querySelector('.sidebar-nav');
    if (sidebarNav) {
        // Scroll automatique vers l'élément actif au chargement
        const activeLink = sidebarNav.querySelector('.nav-link.active');
        if (activeLink) {
            setTimeout(() => {
                activeLink.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 100);
        }
        
        // Ajouter des ombres de scroll dynamiques
        function updateScrollShadows() {
            const scrollTop = sidebarNav.scrollTop;
            const scrollHeight = sidebarNav.scrollHeight;
            const clientHeight = sidebarNav.clientHeight;
            const isAtTop = scrollTop === 0;
            const isAtBottom = scrollTop + clientHeight >= scrollHeight - 1;
            
            // Gérer les ombres en haut et en bas
            sidebarNav.style.setProperty('--scroll-shadow-top', isAtTop ? '0' : '1');
            sidebarNav.style.setProperty('--scroll-shadow-bottom', isAtBottom ? '0' : '1');
        }
        
        sidebarNav.addEventListener('scroll', updateScrollShadows);
        updateScrollShadows(); // Appel initial
    }
});
</script>

 
<?php
/**
 * Layout principal de l'application e-Archive
 * Inclut la sidebar et le header
 */

// Configuration par défaut du layout
$page_title = $page_title ?? 'e-Archive';
$current_page = $current_page ?? basename($_SERVER['PHP_SELF'], '.php');
$show_search = $show_search ?? true;
$breadcrumb = $breadcrumb ?? null;
$user_name = $user_name ?? 'Utilisateur';
$user_role = $user_role ?? 'Membre';
$user_initials = $user_initials ?? strtoupper(substr($user_name, 0, 2));
$notifications_count = $notifications_count ?? 0;

// Déterminer le chemin vers les includes selon le répertoire courant
$layout_base_path = isset($assets_path) ? $assets_path : '';
$includes_path = $layout_base_path . 'includes/';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> - e-Archive | SGITP</title>
    <meta name="description" content="<?= htmlspecialchars($page_description ?? 'Plateforme d\'archivage électronique du SGITP') ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= isset($assets_path) ? $assets_path : '' ?>assets/images/favicon.png">
    <link rel="shortcut icon" type="image/png" href="<?= isset($assets_path) ? $assets_path : '' ?>assets/images/favicon.png">
    <link rel="apple-touch-icon" href="<?= isset($assets_path) ? $assets_path : '' ?>assets/images/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="<?= isset($assets_path) ? $assets_path : '' ?>assets/css/main.css">
    
    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS personnalisé pour cette page -->
    <?php if (isset($custom_css)): ?>
        <?php foreach ($custom_css as $css): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <style>
        /* Configuration Tailwind personnalisée */
        :root {
            --sidebar-width: 18rem;
            --sidebar-collapsed-width: 4rem;
            --header-height: 4rem;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        
        /* Layout principal */
        .main-layout {
            display: flex;
            min-height: 100vh;
        }
        
        .layout-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease-in-out;
        }
        

        
        .layout-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            z-index: 50;
        }
        
        .layout-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e5e7eb;
            height: var(--header-height);
            position: sticky;
            top: 0;
            z-index: 30;
            padding: 0 1.5rem;
        }
        
        .layout-main {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }
        
        /* Mobile responsive */
        @media (max-width: 1023px) {
            .layout-content {
                margin-left: 0;
            }
            
            .layout-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .layout-sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .layout-main {
                padding: 1rem;
            }
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <!-- Layout principal -->
    <div id="main-layout" class="main-layout">
        <!-- Sidebar -->
        <div class="layout-sidebar">
            <?php include $includes_path . 'sidebar.php'; ?>
        </div>
        
        <!-- Overlay pour mobile -->
        <div 
            id="sidebar-overlay" 
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity duration-300"
        ></div>
        
        <!-- Contenu principal (header + main) -->
        <div class="layout-content">
            <!-- Header -->
            <div class="layout-header">
                <?php include $includes_path . 'header.php'; ?>
            </div>
            
            <!-- Contenu principal -->
            <main class="layout-main custom-scrollbar bg-gray-50">
                <?php if (isset($content)): ?>
                    <?= $content ?>
                <?php else: ?>
                    <!-- Le contenu sera inclus par la page qui utilise ce layout -->
                <?php endif; ?>
            </main>
        </div>
    </div>
    
    <!-- Notifications Toast -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">
        <!-- Les notifications seront ajoutées dynamiquement -->
    </div>
    
    <!-- Modal container -->
    <div id="modal-container" class="hidden">
        <!-- Les modales seront ajoutées dynamiquement -->
    </div>
    
    <!-- Loading overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-xl p-6 shadow-xl">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <span class="text-gray-900 font-medium">Chargement...</span>
            </div>
        </div>
    </div>
    
    <!-- JavaScript principal -->
    <script src="<?= isset($assets_path) ? $assets_path : '' ?>assets/js/app.js"></script>
    
    <!-- Scripts personnalisés pour cette page -->
    <?php if (isset($custom_js)): ?>
        <?php foreach ($custom_js as $js): ?>
            <script src="<?= htmlspecialchars($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <script>
        // Configuration globale de l'application
        window.eArchiveConfig = {
            apiUrl: '<?= isset($api_url) ? $api_url : '/api' ?>',
            currentPage: '<?= htmlspecialchars($current_page) ?>',
            currentUser: {
                name: '<?= htmlspecialchars($user_name) ?>',
                role: '<?= htmlspecialchars($user_role) ?>',
                initials: '<?= htmlspecialchars($user_initials) ?>'
            },
            features: {
                search: <?= $show_search ? 'true' : 'false' ?>,
                notifications: <?= $notifications_count > 0 ? 'true' : 'false' ?>
            }
        };
        
        // Initialisation de l'application
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser le layout responsive
            initResponsiveLayout();
            
            // Initialiser les notifications
            initToastSystem();
            
            // Initialiser les raccourcis clavier
            initKeyboardShortcuts();
            
            // Mettre à jour l'heure en temps réel
            updateTime();
            setInterval(updateTime, 60000); // Toutes les minutes
        });
        
        function initResponsiveLayout() {
            const sidebar = document.querySelector('.layout-sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            // Toggle sidebar mobile
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('mobile-open');
                    if (sidebarOverlay) sidebarOverlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            // Close sidebar mobile
            function closeSidebar() {
                sidebar.classList.remove('mobile-open');
                if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
            
            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }
            
            // Gérer le responsive
            function handleResize() {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            }
            
            window.addEventListener('resize', handleResize);
            handleResize(); // Appel initial
        }
        
        function initToastSystem() {
            // Système de notifications toast
            window.showToast = function(message, type = 'info', duration = 5000) {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                
                const typeClasses = {
                    success: 'bg-green-500 text-white',
                    error: 'bg-red-500 text-white',
                    warning: 'bg-yellow-500 text-white',
                    info: 'bg-blue-500 text-white'
                };
                
                const typeIcons = {
                    success: 'fa-check-circle',
                    error: 'fa-exclamation-circle',
                    warning: 'fa-exclamation-triangle',
                    info: 'fa-info-circle'
                };
                
                toast.className = `flex items-center p-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${typeClasses[type] || typeClasses.info}`;
                toast.innerHTML = `
                    <i class="fas ${typeIcons[type] || typeIcons.info} mr-3"></i>
                    <span class="flex-1">${message}</span>
                    <button onclick="this.parentElement.remove()" class="ml-3 hover:bg-black hover:bg-opacity-20 rounded p-1">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                container.appendChild(toast);
                
                // Animation d'entrée
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);
                
                // Suppression automatique
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (toast.parentElement) {
                            toast.remove();
                        }
                    }, 300);
                }, duration);
            };
        }
        
        function initKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + K pour la recherche
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.getElementById('global-search');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
                
                // Escape pour fermer les modales
                if (e.key === 'Escape') {
                    // Fermer les menus ouverts
                    const openMenus = document.querySelectorAll('.dropdown-menu:not(.hidden)');
                    openMenus.forEach(menu => menu.classList.add('hidden'));
                    
                    // Fermer les modales
                    const openModals = document.querySelectorAll('.modal:not(.hidden)');
                    openModals.forEach(modal => modal.classList.add('hidden'));
                }
            });
        }
        
        function updateTime() {
            const timeElements = document.querySelectorAll('[data-time="current"]');
            const now = new Date();
            const timeString = now.toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });
            
            timeElements.forEach(element => {
                element.textContent = timeString;
            });
        }
        
        // Fonction utilitaire pour afficher le loading
        window.showLoading = function() {
            document.getElementById('loading-overlay').classList.remove('hidden');
            document.getElementById('loading-overlay').classList.add('flex');
        };
        
        window.hideLoading = function() {
            document.getElementById('loading-overlay').classList.add('hidden');
            document.getElementById('loading-overlay').classList.remove('flex');
        };
    </script>
    
    <!-- Scripts inline de la page -->
    <?php if (isset($inline_js)): ?>
        <script><?= $inline_js ?></script>
    <?php endif; ?>
</body>
</html> 
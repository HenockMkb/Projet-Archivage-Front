<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Tableau de bord';
$current_page = 'dashboard';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour le dashboard
$kpis = DataLoader::getKPIs();
$recentDocuments = DataLoader::getDocuments(3, null);
$topCollections = DataLoader::getTopCollections(3);
$alerts = DataLoader::getAlerts();

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

        <!-- Contenu principal de la page -->
        <div class="space-y-8">
            <!-- Hero Section avec gradient -->
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50 rounded-2xl border border-blue-100 p-8 lg:p-12">
                <!-- Fond décoratif -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-blue-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
                
                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-6 lg:mb-0">
                        <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-4">
                            <i class="fas fa-sparkles mr-2"></i>
                            Tableau de bord
                    </div>
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                            Bienvenue sur <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">e-Archive</span>
                        </h1>
                        <p class="text-xl text-gray-600 max-w-2xl">
                            Plateforme moderne d'archivage électronique du <strong>SGITP</strong>. 
                            Gérez vos documents en toute sécurité.
                        </p>
                        <div class="flex items-center mt-6 text-sm text-gray-500">
                            <div class="flex items-center mr-6">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                Système opérationnel
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                Dernière synchronisation : <?= date('H:i') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="upload.php" class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <div class="relative z-10 flex items-center">
                                <i class="fas fa-cloud-upload-alt mr-3 text-lg"></i>
                                <span>Importer un document</span>
                    </div>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-blue-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="search.php" class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-search mr-3 text-blue-600"></i>
                            <span>Rechercher</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- KPI Cards Améliorées -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Documents archivés -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-file-alt text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300" id="total-documents"><?= number_format($kpis['documents']['total'] ?? 0) ?></div>
                                <div class="text-sm font-medium text-gray-600">Documents</div>
                            </div>
                        </div>
                    <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-700">Archivés</div>
                            <div class="flex items-center text-sm text-green-600 font-medium">
                                <i class="fas fa-arrow-<?= ($kpis['documents']['growth_direction'] ?? 'up') === 'up' ? 'up' : 'down' ?> mr-1"></i>
                                <span>+<?= $kpis['documents']['growth_percentage'] ?? 0 ?>%</span>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <!-- En attente de validation -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors duration-300" id="pending-validation"><?= $kpis['documents']['pending'] ?? 0 ?></div>
                                <div class="text-sm font-medium text-gray-600">En attente</div>
                            </div>
                        </div>
                    <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-700">Validation</div>
                            <div class="flex items-center text-sm text-red-600 font-medium">
                                <i class="fas fa-arrow-down mr-1"></i>
                                <span>-5%</span>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2 rounded-full" style="width: <?= min(100, max(10, ($kpis['documents']['pending'] ?? 0) / ($kpis['documents']['total'] ?? 1) * 100)) ?>%"></div>
                        </div>
                    </div>
                </div>

                <!-- Archivés aujourd'hui -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300" id="archived-today"><?= $kpis['documents']['archived_today'] ?? 0 ?></div>
                                <div class="text-sm font-medium text-gray-600">Aujourd'hui</div>
                            </div>
                        </div>
                    <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-700">Archivés</div>
                            <div class="flex items-center text-sm text-green-600 font-medium">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>+<?= $kpis['documents']['archived_this_week'] ?? 0 ?></span>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" style="width: <?= min(100, max(10, ($kpis['documents']['archived_today'] ?? 0) * 10)) ?>%"></div>
                        </div>
                    </div>
                </div>

                <!-- Espace utilisé -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-hdd text-white text-xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300" id="storage-used"><?= $kpis['storage']['used_gb'] ?? 0 ?> GB</div>
                                <div class="text-sm font-medium text-gray-600">Stockage</div>
                            </div>
                        </div>
                    <div class="flex items-center justify-between">
                            <div class="text-sm font-medium text-gray-700"><?= $kpis['storage']['used_percentage'] ?? 0 ?>% utilisé</div>
                            <div class="flex items-center text-sm text-gray-600 font-medium">
                                <i class="fas fa-database mr-1"></i>
                                <span><?= $kpis['storage']['total_gb'] ?? 0 ?> GB</span>
                            </div>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: <?= $kpis['storage']['used_percentage'] ?? 0 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sections principales -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Activité récente améliorée -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-history text-blue-600"></i>
                    </div>
                                    Activité récente
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Derniers documents ajoutés</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                <i class="fas fa-clock mr-1"></i>
                                Temps réel
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Document 1 -->
                            <div class="group flex items-center space-x-4 p-4 bg-gradient-to-r from-blue-50/50 to-transparent rounded-xl border border-blue-100/50 hover:shadow-md transition-all duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-file-pdf text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">Rapport annuel 2023</div>
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        Jean Dupont • 
                                        <i class="fas fa-clock ml-2 mr-1"></i>
                                        Il y a 2 heures
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Archivé
                                    </span>
                                </div>
                        </div>
                        
                            <!-- Document 2 -->
                            <div class="group flex items-center space-x-4 p-4 bg-gradient-to-r from-yellow-50/50 to-transparent rounded-xl border border-yellow-100/50 hover:shadow-md transition-all duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-file-word text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 group-hover:text-yellow-700 transition-colors duration-200">Contrat de construction</div>
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        Marie Martin • 
                                        <i class="fas fa-clock ml-2 mr-1"></i>
                                        Il y a 4 heures
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        En attente
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Document 3 -->
                            <div class="group flex items-center space-x-4 p-4 bg-gradient-to-r from-purple-50/50 to-transparent rounded-xl border border-purple-100/50 hover:shadow-md transition-all duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-file-image text-white"></i>
                            </div>
                            <div class="flex-1">
                                    <div class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors duration-200">Plan d'urbanisme</div>
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        Pierre Durand • 
                                        <i class="fas fa-clock ml-2 mr-1"></i>
                                        Il y a 6 heures
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Validé
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer avec action -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="documents.php" class="group inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">
                                <span>Voir tous les documents</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Collections populaires améliorées -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-folder-open text-green-600"></i>
                                    </div>
                                    Collections populaires
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Les dossiers les plus utilisés</p>
                            </div>
                            <div class="text-sm text-gray-500">
                                <i class="fas fa-chart-line mr-1"></i>
                                Top 3
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Collection 1 -->
                            <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-blue-50/50 to-transparent rounded-xl border border-blue-100/50 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-folder text-white"></i>
                                </div>
                                <div>
                                        <div class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">Infrastructures</div>
                                        <div class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-file-alt mr-1"></i>
                                            150 documents
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-eye mr-1"></i>
                                            845 vues
                                        </div>
                                    </div>
                                </div>
                                <a href="collection.php?id=1" class="group-hover:text-blue-700 text-blue-600 hover:bg-blue-100 p-2 rounded-lg transition-all duration-200">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                        
                            <!-- Collection 2 -->
                            <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-green-50/50 to-transparent rounded-xl border border-green-100/50 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-folder text-white"></i>
                                </div>
                                <div>
                                        <div class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors duration-200">Urbanisme</div>
                                        <div class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-file-alt mr-1"></i>
                                            89 documents
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-eye mr-1"></i>
                                            623 vues
                                        </div>
                                    </div>
                                </div>
                                <a href="collection.php?id=2" class="group-hover:text-green-700 text-green-600 hover:bg-green-100 p-2 rounded-lg transition-all duration-200">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                        
                            <!-- Collection 3 -->
                            <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-purple-50/50 to-transparent rounded-xl border border-purple-100/50 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-folder text-white"></i>
                                </div>
                                <div>
                                        <div class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors duration-200">Administratif</div>
                                        <div class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-file-alt mr-1"></i>
                                            234 documents
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-eye mr-1"></i>
                                            1.2k vues
                                        </div>
                                    </div>
                                </div>
                                <a href="collection.php?id=3" class="group-hover:text-purple-700 text-purple-600 hover:bg-purple-100 p-2 rounded-lg transition-all duration-200">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Footer avec action -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="collections.php" class="group inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">
                                <span>Voir toutes les collections</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section finale avec actions et alertes -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Actions rapides modernisées -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-rocket text-purple-600"></i>
                            </div>
                            Actions rapides
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Upload -->
                            <a href="upload.php" class="group flex items-center p-4 bg-gradient-to-r from-blue-50/50 to-transparent rounded-xl border border-blue-100/50 hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-cloud-upload-alt text-white"></i>
                            </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 transition-colors duration-200">Importer un document</div>
                                <div class="text-sm text-gray-500">Ajouter un nouveau fichier</div>
                            </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-200"></i>
                            </a>
                            
                            <!-- Search -->
                            <a href="search.php" class="group flex items-center p-4 bg-gradient-to-r from-green-50/50 to-transparent rounded-xl border border-green-100/50 hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-search text-white"></i>
                            </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors duration-200">Rechercher</div>
                                <div class="text-sm text-gray-500">Trouver des documents</div>
                            </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all duration-200"></i>
                            </a>
                            
                            <!-- Inbox -->
                            <a href="inbox.php" class="group flex items-center p-4 bg-gradient-to-r from-yellow-50/50 to-transparent rounded-xl border border-yellow-100/50 hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-inbox text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 group-hover:text-yellow-700 transition-colors duration-200">File d'attente</div>
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">23</span>
                                        <span class="ml-2">documents en attente</span>
                            </div>
                            </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-600 group-hover:translate-x-1 transition-all duration-200"></i>
                            </a>
                            
                            <!-- Reports -->
                            <a href="reports.php" class="group flex items-center p-4 bg-gradient-to-r from-purple-50/50 to-transparent rounded-xl border border-purple-100/50 hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-chart-bar text-white"></i>
                            </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors duration-200">Rapports</div>
                                <div class="text-sm text-gray-500">Voir les statistiques</div>
                            </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all duration-200"></i>
                        </a>
                        </div>
                    </div>
                </div>

                <!-- Alertes et notifications modernisées -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-bell text-red-600"></i>
                                </div>
                                Alertes et notifications
                            </h3>
                            <div class="flex items-center text-sm text-gray-500">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                                3 nouvelles
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="space-y-4">
                            <!-- Alerte critique -->
                            <div class="group flex items-start space-x-4 p-5 bg-gradient-to-r from-yellow-50 to-yellow-50/50 border-l-4 border-yellow-400 rounded-r-xl hover:shadow-md transition-all duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="font-bold text-yellow-800">Documents en attente de validation</div>
                                        <div class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Critique</div>
                                    </div>
                                    <div class="text-sm text-yellow-700 mb-3">23 documents nécessitent votre attention dans la file d'attente.</div>
                                    <a href="inbox.php" class="group/link inline-flex items-center text-yellow-800 hover:text-yellow-900 font-semibold text-sm transition-colors duration-200">
                                        <span>Voir la file d'attente</span>
                                        <i class="fas fa-arrow-right ml-2 group-hover/link:translate-x-1 transition-transform duration-200"></i>
                                </a>
                            </div>
                        </div>
                        
                            <!-- Info maintenance -->
                            <div class="group flex items-start space-x-4 p-5 bg-gradient-to-r from-blue-50 to-blue-50/50 border-l-4 border-blue-400 rounded-r-xl hover:shadow-md transition-all duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="font-bold text-blue-800">Maintenance prévue</div>
                                        <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Info</div>
                                    </div>
                                    <div class="text-sm text-blue-700">Une maintenance est prévue le 15 janvier 2024 de 22h00 à 02h00.</div>
                                    <div class="text-xs text-blue-600 mt-2 flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        Dans 3 jours
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Succès sauvegarde -->
                            <div class="group flex items-start space-x-4 p-5 bg-gradient-to-r from-green-50 to-green-50/50 border-l-4 border-green-400 rounded-r-xl hover:shadow-md transition-all duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    <i class="fas fa-check-circle text-white"></i>
                            </div>
                            <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="font-bold text-green-800">Sauvegarde réussie</div>
                                        <div class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Succès</div>
                                    </div>
                                    <div class="text-sm text-green-700">La sauvegarde automatique de la base de données s'est terminée avec succès.</div>
                                    <div class="text-xs text-green-600 mt-2 flex items-center">
                                        <i class="fas fa-check mr-1"></i>
                                        Terminé il y a 15 minutes
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer avec action globale -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <a href="notifications.php" class="group inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">
                                    <span>Voir toutes les notifications</span>
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                                </a>
                                <button class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors duration-200">
                                    Marquer tout comme lu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<?php
$content = ob_get_clean(); // Capturer le contenu

// JavaScript personnalisé pour cette page
$inline_js = '
// Code JavaScript spécifique au dashboard
document.addEventListener("DOMContentLoaded", function() {
    // Mise à jour des KPI en temps réel
    updateKPIs();
    setInterval(updateKPIs, 30000); // Toutes les 30 secondes
    
    // Initialiser les graphiques si nécessaire
    if (typeof Chart !== "undefined") {
        initDashboardCharts();
    }
});

function updateKPIs() {
    // Simulation de mise à jour des KPI
    // En production, cela ferait un appel AJAX
    console.log("Mise à jour des KPI...");
}

function initDashboardCharts() {
    // Initialisation des graphiques du dashboard
    console.log("Initialisation des graphiques...");
}
';

// Inclure le layout
include 'includes/layout.php';
?> 
<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Collections';
$current_page = 'collections';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour la page collections
$collections = DataLoader::getCollections();
$collectionsCount = count($collections);

// Calculer les statistiques
$totalDocuments = array_sum(array_column($collections, 'documents_count'));
$totalSize = array_sum(array_column($collections, 'total_size'));
$recentCollections = array_slice($collections, 0, 3);

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index.php'],
    ['label' => 'Collections']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-purple-50 via-white to-indigo-50 rounded-2xl border border-purple-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-purple-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-folder-open mr-2"></i>
                    Gestion des collections
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Collections <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">documentaires</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Organisez et explorez vos documents par collections thématiques dans la plateforme d'archivage du SGITP.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></div>
                        <?= number_format($collectionsCount) ?> collections actives
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Dernière mise à jour : <?= date('H:i') ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="createNewCollection()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-plus mr-3 text-lg"></i>
                        <span>Nouvelle collection</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-purple-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 transform hover:-translate-y-1" onclick="toggleView()">
                    <i class="fas fa-th-large mr-3 text-purple-600" id="view-icon"></i>
                    <span id="view-text">Vignettes</span>
                        </button>
                    </div>
                </div>
            </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total collections -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-folder text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300"><?= number_format($collectionsCount) ?></div>
                        <div class="text-sm font-medium text-gray-600">Collections</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Collections actives</div>
            </div>
                        </div>

        <!-- Total documents -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300"><?= number_format($totalDocuments) ?></div>
                        <div class="text-sm font-medium text-gray-600">Documents</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Total documents</div>
            </div>
                        </div>

        <!-- Espace utilisé -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hdd text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300"><?= DataLoader::formatBytes($totalSize) ?></div>
                        <div class="text-sm font-medium text-gray-600">Stockage</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Espace utilisé</div>
            </div>
                        </div>

        <!-- Moyenne par collection -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-orange-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300"><?= number_format($collectionsCount > 0 ? $totalDocuments / $collectionsCount : 0) ?></div>
                        <div class="text-sm font-medium text-gray-600">Moyenne</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Docs par collection</div>
                    </div>
                </div>
            </div>

    <!-- Filtres et actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-search mr-2 text-gray-400"></i>
                            Rechercher :
                        </label>
                        <input type="text" id="search-input" class="form-input w-64" placeholder="Nom de collection...">
                    </div>
                    
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-sort mr-2 text-gray-400"></i>
                            Trier par :
                        </label>
                        <select class="form-select w-40" id="sort-filter">
                            <option value="name">Nom</option>
                            <option value="documents">Nb documents</option>
                            <option value="size">Taille</option>
                            <option value="date">Date création</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-shield-alt mr-2 text-gray-400"></i>
                            Accès :
                        </label>
                        <select class="form-select w-32" id="access-filter">
                            <option value="">Tous</option>
                            <option value="public">Public</option>
                            <option value="internal">Interne</option>
                            <option value="confidential">Confidentiel</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                    <button class="group inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" onclick="refreshCollections()">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        <span>Actualiser</span>
                        </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" onclick="exportCollections()">
                        <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Exporter</span>
                        </button>
                </div>
            </div>
                                        </div>
                                    </div>

    <!-- Vue tableau moderne -->
    <div id="table-view" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-table text-purple-600"></i>
                                        </div>
                    Liste des collections
                </h3>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-folder mr-1"></i>
                    <?= number_format($collectionsCount) ?> collections
                </div>
                            </div>
                        </div>
                        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="w-4 px-6 py-4">
                            <input type="checkbox" id="select-all-collections" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="name">
                            <div class="flex items-center">
                                Collection
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="documents">
                            <div class="flex items-center">
                                Documents
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="size">
                            <div class="flex items-center">
                                Taille
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Accès</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="date">
                            <div class="flex items-center">
                                Créée le
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($collections as $collection): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="collection-checkbox rounded border-gray-300 text-purple-600 focus:ring-purple-500" data-id="<?= $collection['id'] ?>">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <?php
                                // Debug - afficher les valeurs
                                echo "<!-- DEBUG: Icon: " . ($collection['icon'] ?? 'VIDE') . ", Color: " . ($collection['color'] ?? 'VIDE') . " -->";
                                
                                // Définir les couleurs d'arrière-plan selon la couleur de la collection
                                $bgColors = [
                                    'blue' => 'bg-blue-500',
                                    'green' => 'bg-green-500',
                                    'purple' => 'bg-purple-500',
                                    'yellow' => 'bg-yellow-500',
                                    'red' => 'bg-red-500',
                                    'indigo' => 'bg-indigo-500',
                                    'pink' => 'bg-pink-500',
                                    'orange' => 'bg-orange-500'
                                ];
                                $bgClass = $bgColors[$collection['color']] ?? 'bg-gray-500';
                                $iconClass = $collection['icon'] ?? 'fas fa-folder';
                                ?>
                                <div class="w-12 h-12 <?= $bgClass ?> rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas <?= $iconClass ?> text-white text-lg"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 hover:text-purple-600 transition-colors duration-200 cursor-pointer" onclick="viewCollection(<?= $collection['id'] ?>)">
                                        <?= htmlspecialchars($collection['name']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Mise à jour : <?= DataLoader::timeAgo($collection['last_updated']) ?>
                        </div>
                    </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs">
                                <?= htmlspecialchars($collection['description']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-gray-900"><?= number_format($collection['documents_count']) ?></span>
                                <span class="text-sm text-gray-500 ml-2">docs</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900"><?= DataLoader::formatBytes($collection['total_size']) ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <?php
                            $accessColors = [
                                'public' => 'bg-green-100 text-green-800',
                                'internal' => 'bg-blue-100 text-blue-800',
                                'confidential' => 'bg-red-100 text-red-800'
                            ];
                            $accessIcons = [
                                'public' => 'fa-globe',
                                'internal' => 'fa-building',
                                'confidential' => 'fa-lock'
                            ];
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $accessColors[$collection['access_level']] ?? 'bg-gray-100 text-gray-800' ?>">
                                <i class="fas <?= $accessIcons[$collection['access_level']] ?? 'fa-question' ?> mr-1"></i>
                                <?= ucfirst($collection['access_level']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?= date('d/m/Y', strtotime($collection['created_at'])) ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?= DataLoader::timeAgo($collection['created_at']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200" onclick="viewCollection(<?= $collection['id'] ?>)" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-2 text-green-600 hover:text-green-700 hover:bg-green-100 rounded-lg transition-all duration-200" onclick="editCollection(<?= $collection['id'] ?>)" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 text-purple-600 hover:text-purple-700 hover:bg-purple-100 rounded-lg transition-all duration-200" onclick="manageAccess(<?= $collection['id'] ?>)" title="Gérer l'accès">
                                    <i class="fas fa-users"></i>
                                </button>
                                <button class="p-2 text-red-600 hover:text-red-700 hover:bg-red-100 rounded-lg transition-all duration-200" onclick="deleteCollection(<?= $collection['id'] ?>)" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                        </div>
                        
        <!-- Pagination moderne -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?= min(10, $collectionsCount) ?></span> sur <span class="font-medium"><?= number_format($collectionsCount) ?></span> résultats
                        </div>
                            <div class="flex items-center space-x-2">
                    <button class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200 disabled:opacity-50" disabled>
                        <i class="fas fa-chevron-left mr-1"></i>
                        Précédent
                                </button>
                    <div class="flex items-center space-x-1">
                        <button class="px-3 py-2 text-sm bg-purple-600 text-white rounded-lg shadow-sm">1</button>
                        <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">2</button>
                    </div>
                    <button class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                        Suivant
                        <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vue vignettes moderne (cachée par défaut) -->
    <div id="grid-view" class="hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($collections as $collection): ?>
            <!-- Carte collection -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <?php
                        // Utiliser les mêmes couleurs pour la vue vignettes
                        $bgColors = [
                            'blue' => 'bg-blue-500',
                            'green' => 'bg-green-500',
                            'purple' => 'bg-purple-500',
                            'yellow' => 'bg-yellow-500',
                            'red' => 'bg-red-500',
                            'indigo' => 'bg-indigo-500',
                            'pink' => 'bg-pink-500',
                            'orange' => 'bg-orange-500'
                        ];
                        $bgClass = $bgColors[$collection['color']] ?? 'bg-gray-500';
                        $iconClass = $collection['icon'] ?? 'fas fa-folder';
                        ?>
                        <div class="w-14 h-14 <?= $bgClass ?> rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas <?= $iconClass ?> text-white text-2xl"></i>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $accessColors[$collection['access_level']] ?? 'bg-gray-100 text-gray-800' ?>">
                                <i class="fas <?= $accessIcons[$collection['access_level']] ?? 'fa-question' ?> mr-1"></i>
                                <?= ucfirst($collection['access_level']) ?>
                            </span>
            </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors duration-200 cursor-pointer" onclick="viewCollection(<?= $collection['id'] ?>)">
                        <?= htmlspecialchars($collection['name']) ?>
                    </h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        <?= htmlspecialchars($collection['description']) ?>
                    </p>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-file-alt mr-2"></i>
                                Documents :
                            </span>
                            <span class="text-lg font-bold text-gray-900"><?= number_format($collection['documents_count']) ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-hdd mr-2"></i>
                                Taille :
                            </span>
                            <span class="text-sm font-medium text-gray-900"><?= DataLoader::formatBytes($collection['total_size']) ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                Créée :
                            </span>
                            <span class="text-sm text-gray-900"><?= date('d/m/Y', strtotime($collection['created_at'])) ?></span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="text-xs text-gray-500">
                            Mis à jour <?= DataLoader::timeAgo($collection['last_updated']) ?>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200" onclick="viewCollection(<?= $collection['id'] ?>)" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="p-2 text-green-600 hover:text-green-700 hover:bg-green-100 rounded-lg transition-all duration-200" onclick="editCollection(<?= $collection['id'] ?>)" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="p-2 text-purple-600 hover:text-purple-700 hover:bg-purple-100 rounded-lg transition-all duration-200" onclick="manageAccess(<?= $collection['id'] ?>)" title="Gérer l'accès">
                                <i class="fas fa-users"></i>
                            </button>
                        </div>
                    </div>
            </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capturer le contenu

// JavaScript personnalisé pour cette page
$inline_js = '
// Variables globales
let currentView = "table";

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initFilters();
    initTableSorting();
    initBulkActions();
    initSearch();
});

function initFilters() {
    const filters = ["sort-filter", "access-filter"];
    filters.forEach(filterId => {
        document.getElementById(filterId).addEventListener("change", applyFilters);
    });
}

function initTableSorting() {
    const sortableHeaders = document.querySelectorAll("[data-sort]");
    sortableHeaders.forEach(header => {
        header.addEventListener("click", function() {
            const column = this.dataset.sort;
            sortTable(column);
        });
    });
}

function initBulkActions() {
    // Sélection globale
    document.getElementById("select-all-collections").addEventListener("change", function() {
        const checkboxes = document.querySelectorAll(".collection-checkbox");
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsVisibility();
    });

    // Sélection individuelle
    document.querySelectorAll(".collection-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", updateBulkActionsVisibility);
    });
}

function initSearch() {
    const searchInput = document.getElementById("search-input");
    searchInput.addEventListener("input", function() {
        searchCollections(this.value);
    });
}

function updateBulkActionsVisibility() {
    const checkedBoxes = document.querySelectorAll(".collection-checkbox:checked");
    // Logique pour afficher/masquer les actions groupées
}

function applyFilters() {
    const sortFilter = document.getElementById("sort-filter").value;
    const accessFilter = document.getElementById("access-filter").value;
    
    console.log("Filtres appliqués:", { sortFilter, accessFilter });
    showToast("Filtres appliqués", "info");
}

function sortTable(column) {
    console.log("Tri par:", column);
    showToast("Tableau trié par " + column, "info");
}

function searchCollections(query) {
    if (query.length > 2) {
        console.log("Recherche:", query);
        showToast("Recherche en cours...", "info");
    }
        }

        function viewCollection(id) {
    window.location.href = `collection.php?id=${id}`;
        }

        function editCollection(id) {
    showToast("Modification de la collection - Fonctionnalité à venir", "info");
        }

function manageAccess(id) {
    showToast("Gestion des accès - Fonctionnalité à venir", "info");
        }

        function deleteCollection(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette collection ? Cette action est irréversible.")) {
        showToast("Collection supprimée avec succès !", "success");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

function createNewCollection() {
    showToast("Création de nouvelle collection - Fonctionnalité à venir", "info");
        }

        function exportCollections() {
    const checkedBoxes = document.querySelectorAll(".collection-checkbox:checked");
            if (checkedBoxes.length === 0) {
        showToast("Veuillez sélectionner au moins une collection", "warning");
                return;
            }
            
    showToast(`Export de ${checkedBoxes.length} collection(s) en cours...`, "success");
        }

        function toggleView() {
    const tableView = document.getElementById("table-view");
    const gridView = document.getElementById("grid-view");
    const viewIcon = document.getElementById("view-icon");
    const viewText = document.getElementById("view-text");
    
    if (currentView === "table") {
        // Passer à la vue grille
        tableView.classList.add("hidden");
        gridView.classList.remove("hidden");
        viewIcon.className = "fas fa-list mr-3 text-purple-600";
        viewText.textContent = "Tableau";
        currentView = "grid";
        showToast("Vue vignettes activée", "info");
            } else {
        // Passer à la vue tableau
        tableView.classList.remove("hidden");
        gridView.classList.add("hidden");
        viewIcon.className = "fas fa-th-large mr-3 text-purple-600";
        viewText.textContent = "Vignettes";
        currentView = "table";
        showToast("Vue tableau activée", "info");
    }
}

function refreshCollections() {
    showToast("Actualisation en cours...", "info");
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}
';

// Inclure le layout
include 'includes/layout.php';
?> 
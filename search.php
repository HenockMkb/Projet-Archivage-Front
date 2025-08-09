<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Recherche avancée';
$current_page = 'search';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = false; // Pas besoin de la barre de recherche dans le header

// Charger les données pour la page de recherche
$collections = DataLoader::getCollections();
$documents = DataLoader::getDocuments();
$recentSearches = [
    'rapport annuel 2023',
    'contrat infrastructure',
    'plan urbanisme',
    'budget SGITP',
    'procès-verbal réunion'
];

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index.php'],
    ['label' => 'Recherche avancée']
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
                    <i class="fas fa-search mr-2"></i>
                    Recherche avancée
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Trouvez vos <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">documents</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Utilisez notre moteur de recherche avancé pour trouver rapidement les documents dont vous avez besoin avec des filtres précis.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        <?= count($documents) ?> documents disponibles
                    </div>
            <div class="flex items-center">
                        <i class="fas fa-filter mr-2 text-gray-400"></i>
                        Filtres avancés disponibles
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="showSearchTips()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-lightbulb mr-3 text-lg"></i>
                        <span>Astuces</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-purple-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </button>
                <a href="documents.php" class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-list mr-3 text-purple-600"></i>
                    <span>Tous les documents</span>
                </a>
            </div>
        </div>
                </div>
                
    <!-- Barre de recherche principale -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="p-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Champ de recherche principal -->
                <div class="flex-1">
                    <label for="main-search" class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-search mr-2 text-purple-600"></i>
                        Rechercher dans les documents
                    </label>
                    <div class="relative">
                        <input type="text" id="main-search" placeholder="Tapez votre recherche : titre, contenu, auteur, mots-clés..." class="w-full px-6 py-4 text-lg border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 pr-16">
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 p-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg" onclick="performSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="text-sm text-gray-500">Recherches récentes :</span>
                        <?php foreach (array_slice($recentSearches, 0, 3) as $search): ?>
                        <button class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm hover:bg-purple-200 transition-colors duration-200 capitalize" onclick="fillSearch('<?= htmlspecialchars($search) ?>')">
                            <i class="fas fa-history mr-1"></i>
                            <?= htmlspecialchars($search) ?>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col gap-3">
                    <button type="button" class="group inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" onclick="toggleAdvancedFilters()">
                        <i class="fas fa-sliders-h mr-2"></i>
                        <span>Filtres avancés</span>
                    </button>
                    <button type="button" class="group inline-flex items-center justify-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300" onclick="clearSearch()">
                        <i class="fas fa-eraser mr-2 text-blue-600"></i>
                        <span>Effacer</span>
                    </button>
                </div>
            </div>
                </div>
            </div>

    <!-- Filtres avancés (masqués par défaut) -->
    <div id="advanced-filters" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-filter text-blue-600"></i>
                </div>
                Filtres avancés
            </h3>
                        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Collection -->
                        <div class="form-group">
                    <label for="filter-collection" class="form-label flex items-center">
                        <i class="fas fa-folder mr-2 text-blue-600"></i>
                        Collection
                    </label>
                    <select id="filter-collection" class="form-select">
                                <option value="">Toutes les collections</option>
                        <?php foreach ($collections as $collection): ?>
                        <option value="<?= $collection['id'] ?>"><?= htmlspecialchars($collection['name']) ?></option>
                        <?php endforeach; ?>
                            </select>
                        </div>

                <!-- Type de fichier -->
                        <div class="form-group">
                    <label for="filter-type" class="form-label flex items-center">
                        <i class="fas fa-file mr-2 text-green-600"></i>
                        Type de fichier
                    </label>
                    <select id="filter-type" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="pdf">PDF</option>
                        <option value="doc">Document Word</option>
                        <option value="xls">Excel</option>
                        <option value="ppt">PowerPoint</option>
                        <option value="image">Image</option>
                        <option value="other">Autre</option>
                            </select>
                        </div>

                <!-- Confidentialité -->
                        <div class="form-group">
                    <label for="filter-confidentiality" class="form-label flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-orange-600"></i>
                        Confidentialité
                    </label>
                    <select id="filter-confidentiality" class="form-select">
                        <option value="">Tous les niveaux</option>
                        <option value="public">🟢 Public</option>
                        <option value="internal">🔵 Interne</option>
                        <option value="restricted">🟠 Restreint</option>
                        <option value="confidential">🔴 Confidentiel</option>
                    </select>
                        </div>

                        <!-- Statut -->
                        <div class="form-group">
                    <label for="filter-status" class="form-label flex items-center">
                        <i class="fas fa-check-circle mr-2 text-purple-600"></i>
                        Statut
                    </label>
                    <select id="filter-status" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="archived">Archivé</option>
                        <option value="pending">En attente</option>
                                <option value="validated">Validé</option>
                        <option value="rejected">Rejeté</option>
                            </select>
                        </div>

                <!-- Date de création -->
                        <div class="form-group">
                    <label for="filter-date-from" class="form-label flex items-center">
                        <i class="fas fa-calendar mr-2 text-red-600"></i>
                        Date de création
                    </label>
                    <div class="flex space-x-2">
                        <input type="date" id="filter-date-from" class="form-input text-sm" placeholder="Du">
                        <input type="date" id="filter-date-to" class="form-input text-sm" placeholder="Au">
                    </div>
                        </div>

                <!-- Taille de fichier -->
                        <div class="form-group">
                    <label for="filter-size" class="form-label flex items-center">
                        <i class="fas fa-weight-hanging mr-2 text-indigo-600"></i>
                        Taille
                    </label>
                    <select id="filter-size" class="form-select">
                                <option value="">Toutes les tailles</option>
                        <option value="small">< 1 MB</option>
                        <option value="medium">1-10 MB</option>
                        <option value="large">10-50 MB</option>
                        <option value="xlarge">> 50 MB</option>
                            </select>
                        </div>

                <!-- Auteur -->
                        <div class="form-group">
                    <label for="filter-author" class="form-label flex items-center">
                        <i class="fas fa-user mr-2 text-pink-600"></i>
                        Auteur
                    </label>
                    <input type="text" id="filter-author" class="form-input" placeholder="Nom de l'auteur">
                    </div>

                <!-- Mots-clés -->
                <div class="form-group">
                    <label for="filter-keywords" class="form-label flex items-center">
                        <i class="fas fa-hashtag mr-2 text-teal-600"></i>
                        Mots-clés
                            </label>
                    <input type="text" id="filter-keywords" class="form-input" placeholder="Séparés par des virgules">
                        </div>
                    </div>

            <div class="mt-6 flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center space-x-3">
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200" onclick="applyAdvancedFilters()">
                        <i class="fas fa-search mr-2"></i>
                        Appliquer les filtres
                            </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200" onclick="clearAdvancedFilters()">
                        <i class="fas fa-eraser mr-2"></i>
                        Réinitialiser
                            </button>
                        </div>
                <div class="text-sm text-gray-500">
                    <span id="filter-count">0</span> filtre(s) actif(s)
                </div>
            </div>
        </div>
    </div>

    <!-- Résultats de recherche -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Facettes (sidebar) -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Facettes par collection -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-4 border-b border-gray-200">
                        <h4 class="font-bold text-gray-900 flex items-center">
                            <i class="fas fa-folder-open mr-2 text-blue-600"></i>
                            Collections
                        </h4>
                    </div>
                    <div class="p-4 space-y-3">
                        <?php 
                        // Couleurs statiques pour les icônes
                        $iconColors = [
                            'blue' => 'text-blue-600',
                            'green' => 'text-green-600',
                            'purple' => 'text-purple-600',
                            'yellow' => 'text-yellow-600',
                            'red' => 'text-red-600',
                            'indigo' => 'text-indigo-600',
                            'pink' => 'text-pink-600',
                            'orange' => 'text-orange-600'
                        ];
                        
                        foreach (array_slice($collections, 0, 5) as $collection): 
                            $iconClass = $collection['icon'] ?? 'fas fa-folder';
                            $colorClass = $iconColors[$collection['color']] ?? 'text-gray-600';
                        ?>
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors duration-200 cursor-pointer" onclick="filterByCollection(<?= $collection['id'] ?>)">
                        <div class="flex items-center space-x-3">
                                <i class="fas <?= $iconClass ?> <?= $colorClass ?>"></i>
                                <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($collection['name']) ?></span>
                            </div>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full"><?= $collection['documents_count'] ?></span>
                        </div>
                        <?php endforeach; ?>
                        <a href="collections.php" class="w-full text-left text-sm text-blue-600 hover:text-blue-700 font-medium p-2">
                            Voir toutes les collections →
                        </a>
                    </div>
            </div>

                <!-- Facettes par type -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-4 border-b border-gray-200">
                        <h4 class="font-bold text-gray-900 flex items-center">
                            <i class="fas fa-file mr-2 text-green-600"></i>
                            Types de fichiers
                        </h4>
                            </div>
                    <div class="p-4 space-y-3">
                        <?php 
                        $fileTypes = [
                            ['type' => 'pdf', 'icon' => 'fas fa-file-pdf', 'color' => 'red', 'count' => 45],
                            ['type' => 'doc', 'icon' => 'fas fa-file-word', 'color' => 'blue', 'count' => 32],
                            ['type' => 'xls', 'icon' => 'fas fa-file-excel', 'color' => 'green', 'count' => 18],
                            ['type' => 'image', 'icon' => 'fas fa-file-image', 'color' => 'purple', 'count' => 23]
                        ];
                        foreach ($fileTypes as $fileType): ?>
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors duration-200 cursor-pointer" onclick="filterByType('<?= $fileType['type'] ?>')">
                            <div class="flex items-center space-x-3">
                                <i class="<?= $fileType['icon'] ?> text-<?= $fileType['color'] ?>-600"></i>
                                <span class="text-sm font-medium text-gray-900"><?= strtoupper($fileType['type']) ?></span>
                            </div>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full"><?= $fileType['count'] ?></span>
                        </div>
                        <?php endforeach; ?>
                        </div>
                    </div>

                <!-- Recherches sauvegardées -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-4 border-b border-gray-200">
                        <h4 class="font-bold text-gray-900 flex items-center">
                            <i class="fas fa-bookmark mr-2 text-yellow-600"></i>
                            Recherches sauvegardées
                        </h4>
                    </div>
                    <div class="p-4 space-y-3">
                        <?php foreach (array_slice($recentSearches, 0, 4) as $search): ?>
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors duration-200 cursor-pointer" onclick="fillSearch('<?= htmlspecialchars($search) ?>')">
                            <span class="text-sm text-gray-900 capitalize"><?= htmlspecialchars($search) ?></span>
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                        </div>
                        <?php endforeach; ?>
                        <button class="w-full text-left text-sm text-blue-600 hover:text-blue-700 font-medium p-2">
                            Gérer les recherches →
                        </button>
                    </div>
                </div>
            </div>
                    </div>

        <!-- Résultats principaux -->
        <div class="lg:col-span-3">
            <!-- En-tête des résultats -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-search-plus text-purple-600"></i>
                                </div>
                                Résultats de recherche
                            </h3>
                            <p class="text-sm text-gray-600 mt-1" id="results-summary">Tapez votre recherche pour commencer</p>
                            </div>
                        <div class="flex items-center space-x-3">
                            <select id="sort-results" class="form-select text-sm">
                                <option value="relevance">Pertinence</option>
                                <option value="date_desc">Plus récent</option>
                                <option value="date_asc">Plus ancien</option>
                                <option value="title">Titre A-Z</option>
                                <option value="size_desc">Taille décroissante</option>
                            </select>
                            <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-white rounded transition-all duration-200" onclick="setViewMode('list')" id="list-view-btn">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-white rounded transition-all duration-200" onclick="setViewMode('grid')" id="grid-view-btn">
                                    <i class="fas fa-th"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone de résultats -->
            <div id="search-results" class="space-y-6">
                <!-- État initial : pas de recherche -->
                <div id="no-search-state" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-purple-600 text-3xl"></i>
                </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Commencez votre recherche</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Utilisez la barre de recherche ci-dessus pour trouver des documents par titre, contenu, auteur ou mots-clés.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-lg mx-auto">
                        <button class="p-4 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-colors duration-200" onclick="fillSearch('rapport')">
                            <i class="fas fa-file-alt mb-2"></i>
                            <div class="text-sm font-medium">Rapports</div>
                        </button>
                        <button class="p-4 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition-colors duration-200" onclick="fillSearch('contrat')">
                            <i class="fas fa-handshake mb-2"></i>
                            <div class="text-sm font-medium">Contrats</div>
                            </button>
                        <button class="p-4 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-100 transition-colors duration-200" onclick="fillSearch('plan')">
                            <i class="fas fa-drafting-compass mb-2"></i>
                            <div class="text-sm font-medium">Plans</div>
                            </button>
                        </div>
                    </div>
                    
                <!-- Résultats en liste (masqué par défaut) -->
                <div id="list-results" class="hidden space-y-4">
                    <!-- Les résultats seront affichés ici dynamiquement -->
                </div>

                <!-- Résultats en grille (masqué par défaut) -->
                <div id="grid-results" class="hidden grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Les résultats seront affichés ici dynamiquement -->
                            </div>

                <!-- État : aucun résultat trouvé (masqué par défaut) -->
                <div id="no-results-state" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search-minus text-gray-500 text-3xl"></i>
                        </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Aucun résultat trouvé</h3>
                    <p class="text-gray-600 mb-6">
                        Essayez de modifier votre recherche ou d'utiliser des mots-clés différents.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <button class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200" onclick="clearSearch()">
                            <i class="fas fa-eraser mr-2"></i>
                            Nouvelle recherche
                            </button>
                        <button class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200" onclick="toggleAdvancedFilters()">
                            <i class="fas fa-filter mr-2"></i>
                            Filtres avancés
                            </button>
                    </div>
                        </div>
                    </div>
                    
            <!-- Pagination (masquée par défaut) -->
            <div id="pagination" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 mt-6">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Affichage de <span class="font-medium" id="pagination-start">1</span> à <span class="font-medium" id="pagination-end">10</span> sur <span class="font-medium" id="pagination-total">0</span> résultats
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 disabled:opacity-50" id="prev-page" disabled>
                                <i class="fas fa-chevron-left mr-1"></i>
                                Précédent
                            </button>
                            <div class="flex items-center space-x-1" id="pagination-numbers">
                                <!-- Les numéros de page seront générés dynamiquement -->
                            </div>
                            <button class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200" id="next-page">
                                Suivant
                                <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
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
// Variables globales
let currentViewMode = "list";
let currentPage = 1;
let searchResults = [];
let allDocuments = ' . json_encode($documents) . ';
let isAdvancedFiltersVisible = false;

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initSearch();
    initFilters();
    initViewToggle();
});

function initSearch() {
    const searchInput = document.getElementById("main-search");
    
    // Recherche en temps réel avec debounce
    let searchTimeout;
    searchInput.addEventListener("input", function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.trim().length >= 2) {
                performSearch();
            } else {
                showNoSearchState();
            }
        }, 300);
    });
    
    // Recherche sur Enter
    searchInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            performSearch();
        }
    });
}

function initFilters() {
    // Écouteurs pour les filtres avancés
    const filterInputs = document.querySelectorAll("#advanced-filters select, #advanced-filters input");
    filterInputs.forEach(input => {
        input.addEventListener("change", updateFilterCount);
    });
    
    // Tri des résultats
    document.getElementById("sort-results").addEventListener("change", function() {
        if (searchResults.length > 0) {
            sortResults(this.value);
            displayResults();
        }
    });
}

function initViewToggle() {
    setViewMode("list"); // Vue liste par défaut
        }

        function performSearch() {
    const query = document.getElementById("main-search").value.trim();
    
    if (!query) {
        showNoSearchState();
                return;
            }

    // Simulation de recherche (filtrage des documents)
    searchResults = allDocuments.filter(doc => {
        return doc.title.toLowerCase().includes(query.toLowerCase()) ||
               (doc.description && doc.description.toLowerCase().includes(query.toLowerCase())) ||
               (doc.tags && doc.tags.some(tag => tag.toLowerCase().includes(query.toLowerCase()))) ||
               (doc.author && doc.author.toLowerCase().includes(query.toLowerCase()));
    });
    
    // Appliquer les filtres avancés si actifs
    if (isAdvancedFiltersVisible) {
        applyAdvancedFiltersToResults();
    }
    
    updateResultsSummary(query);
    
    if (searchResults.length > 0) {
        sortResults(document.getElementById("sort-results").value);
        displayResults();
        showPagination();
    } else {
        showNoResultsState();
    }
}

function applyAdvancedFiltersToResults() {
    const collection = document.getElementById("filter-collection").value;
    const type = document.getElementById("filter-type").value;
    const confidentiality = document.getElementById("filter-confidentiality").value;
    const status = document.getElementById("filter-status").value;
    const author = document.getElementById("filter-author").value.toLowerCase();
    const keywords = document.getElementById("filter-keywords").value.toLowerCase();
    
    searchResults = searchResults.filter(doc => {
        if (collection && doc.collection_id != collection) return false;
        if (type && doc.file_type !== type) return false;
        if (confidentiality && doc.confidentiality !== confidentiality) return false;
        if (status && doc.status !== status) return false;
        if (author && !doc.author.toLowerCase().includes(author)) return false;
        if (keywords && (!doc.tags || !doc.tags.some(tag => tag.toLowerCase().includes(keywords)))) return false;
        return true;
    });
}

function sortResults(sortBy) {
    switch (sortBy) {
        case "date_desc":
            searchResults.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            break;
        case "date_asc":
            searchResults.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
            break;
        case "title":
            searchResults.sort((a, b) => a.title.localeCompare(b.title));
            break;
        case "size_desc":
            searchResults.sort((a, b) => b.file_size - a.file_size);
            break;
        default: // relevance
            // Garder lordre naturel de pertinence
            break;
    }
}

function displayResults() {
    if (currentViewMode === "list") {
        displayListResults();
    } else {
        displayGridResults();
    }
}

function displayListResults() {
    const container = document.getElementById("list-results");
    
    container.innerHTML = searchResults.map(doc => `
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-${getFileIcon(doc.file_type)} text-white"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="text-lg font-bold text-gray-900 hover:text-blue-600 transition-colors duration-200 cursor-pointer" onclick="openDocument(${doc.id})">
                            ${escapeHtml(doc.title)}
                        </h4>
                        <div class="flex items-center space-x-2 ml-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-${getStatusColor(doc.status)}-100 text-${getStatusColor(doc.status)}-800">
                                ${doc.status}
                            </span>
                            <span class="text-xs text-gray-500">${formatFileSize(doc.file_size)}</span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        ${escapeHtml(doc.description || "Aucune description disponible")}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center">
                                <i class="fas fa-folder mr-1"></i>
                                ${escapeHtml(doc.collection_name || "Non classé")}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                ${escapeHtml(doc.author || "Inconnu")}
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                ${formatDate(doc.created_at)}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200" onclick="previewDocument(${doc.id})" title="Prévisualiser">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors duration-200" onclick="downloadDocument(${doc.id})" title="Télécharger">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `).join("");
    
    // Afficher la vue liste
    document.getElementById("no-search-state").classList.add("hidden");
    document.getElementById("no-results-state").classList.add("hidden");
    document.getElementById("list-results").classList.remove("hidden");
    document.getElementById("grid-results").classList.add("hidden");
}

function displayGridResults() {
    const container = document.getElementById("grid-results");
    
    container.innerHTML = searchResults.map(doc => `
        <div class="group bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-${getFileIcon(doc.file_type)} text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 cursor-pointer truncate" onclick="openDocument(${doc.id})">
                            ${escapeHtml(doc.title)}
                        </h4>
                        <p class="text-xs text-gray-500">${formatFileSize(doc.file_size)}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                    ${escapeHtml(doc.description || "Aucune description disponible")}
                </p>
                <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                    <span class="flex items-center">
                        <i class="fas fa-folder mr-1"></i>
                        ${escapeHtml(doc.collection_name || "Non classé")}
                    </span>
                    <span>${formatDate(doc.created_at)}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-${getStatusColor(doc.status)}-100 text-${getStatusColor(doc.status)}-800">
                        ${doc.status}
                    </span>
                    <div class="flex items-center space-x-1">
                        <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200" onclick="previewDocument(${doc.id})" title="Prévisualiser">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                        <button class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors duration-200" onclick="downloadDocument(${doc.id})" title="Télécharger">
                            <i class="fas fa-download text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `).join("");
    
    // Afficher la vue grille
    document.getElementById("no-search-state").classList.add("hidden");
    document.getElementById("no-results-state").classList.add("hidden");
    document.getElementById("list-results").classList.add("hidden");
    document.getElementById("grid-results").classList.remove("hidden");
}

function showNoSearchState() {
    document.getElementById("no-search-state").classList.remove("hidden");
    document.getElementById("no-results-state").classList.add("hidden");
    document.getElementById("list-results").classList.add("hidden");
    document.getElementById("grid-results").classList.add("hidden");
    document.getElementById("pagination").classList.add("hidden");
    updateResultsSummary("");
}

function showNoResultsState() {
    document.getElementById("no-search-state").classList.add("hidden");
    document.getElementById("no-results-state").classList.remove("hidden");
    document.getElementById("list-results").classList.add("hidden");
    document.getElementById("grid-results").classList.add("hidden");
    document.getElementById("pagination").classList.add("hidden");
}

function showPagination() {
    document.getElementById("pagination").classList.remove("hidden");
    // Mise à jour des informations de pagination
    document.getElementById("pagination-total").textContent = searchResults.length;
    document.getElementById("pagination-start").textContent = "1";
    document.getElementById("pagination-end").textContent = Math.min(10, searchResults.length);
}

function updateResultsSummary(query) {
    const summary = document.getElementById("results-summary");
    if (!query) {
        summary.textContent = "Tapez votre recherche pour commencer";
    } else if (searchResults.length === 0) {
        summary.textContent = `Aucun résultat pour "${query}"`;
    } else {
        summary.textContent = `${searchResults.length} résultat(s) trouvé(s) pour "${query}"`;
    }
}

function setViewMode(mode) {
    currentViewMode = mode;
    
    // Mettre à jour les boutons
    document.getElementById("list-view-btn").classList.toggle("bg-white", mode === "list");
    document.getElementById("list-view-btn").classList.toggle("text-gray-900", mode === "list");
    document.getElementById("grid-view-btn").classList.toggle("bg-white", mode === "grid");
    document.getElementById("grid-view-btn").classList.toggle("text-gray-900", mode === "grid");
    
    // Afficher les résultats dans le bon format
    if (searchResults.length > 0) {
        displayResults();
    }
}

function toggleAdvancedFilters() {
    const filtersDiv = document.getElementById("advanced-filters");
    isAdvancedFiltersVisible = !isAdvancedFiltersVisible;
    
    if (isAdvancedFiltersVisible) {
        filtersDiv.classList.remove("hidden");
    } else {
        filtersDiv.classList.add("hidden");
    }
}

function applyAdvancedFilters() {
    updateFilterCount();
    if (document.getElementById("main-search").value.trim()) {
        performSearch();
    }
    showToast("Filtres appliqués", "success");
}

function clearAdvancedFilters() {
    const filterInputs = document.querySelectorAll("#advanced-filters select, #advanced-filters input");
    filterInputs.forEach(input => {
        input.value = "";
    });
    updateFilterCount();
    
    if (document.getElementById("main-search").value.trim()) {
        performSearch();
    }
    showToast("Filtres réinitialisés", "info");
}

function updateFilterCount() {
    const filterInputs = document.querySelectorAll("#advanced-filters select, #advanced-filters input");
    let activeCount = 0;
    
    filterInputs.forEach(input => {
        if (input.value.trim()) {
            activeCount++;
        }
    });
    
    document.getElementById("filter-count").textContent = activeCount;
}

function clearSearch() {
    document.getElementById("main-search").value = "";
    clearAdvancedFilters();
    showNoSearchState();
}

function fillSearch(query) {
    document.getElementById("main-search").value = query;
                    performSearch();
                }

// Fonctions de filtrage par facettes
function filterByCollection(collectionId) {
    document.getElementById("filter-collection").value = collectionId;
    applyAdvancedFilters();
}

function filterByType(type) {
    document.getElementById("filter-type").value = type;
    applyAdvancedFilters();
}

// Fonctions utilitaires
function getFileIcon(fileType) {
    const icons = {
        pdf: "pdf",
        doc: "word", 
        docx: "word",
        xls: "excel",
        xlsx: "excel", 
        ppt: "powerpoint",
        pptx: "powerpoint",
        jpg: "image",
        jpeg: "image",
        png: "image",
        gif: "image"
    };
    return icons[fileType] || "alt";
}

function getStatusColor(status) {
    const colors = {
        archived: "green",
        pending: "yellow",
        validated: "blue",
        rejected: "red"
    };
    return colors[status] || "gray";
}

function formatFileSize(bytes) {
    if (bytes === 0) return "0 B";
    const k = 1024;
    const sizes = ["B", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString("fr-FR");
}

function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}

// Actions sur les documents
function openDocument(id) {
    window.location.href = `document.php?id=${id}`;
}

function previewDocument(id) {
    showToast("Ouverture de la prévisualisation...", "info");
    // Logique de prévisualisation
}

function downloadDocument(id) {
    showToast("Téléchargement en cours...", "success");
    // Logique de téléchargement
}

function showSearchTips() {
    showToast("Astuces : Utilisez des guillemets pour une recherche exacte, * pour les caractères jokers", "info");
}
';

// Inclure le layout
include 'includes/layout.php';
?> 
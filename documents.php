<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Documents';
$current_page = 'documents';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour la page documents
$documents = DataLoader::getDocuments();
$collections = DataLoader::getCollections();
$documentsCount = count($documents);

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index.php'],
    ['label' => 'Documents']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-purple-50 rounded-2xl border border-blue-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-blue-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-purple-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-file-alt mr-2"></i>
                    Gestion des documents
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Documents <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">archivés</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Gérez et consultez tous vos documents dans la plateforme d'archivage électronique du SGITP.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></div>
                        <?= number_format($documentsCount) ?> documents archivés
                    </div>
            <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Dernière mise à jour : <?= date('H:i') ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="upload.php" class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-plus mr-3 text-lg"></i>
                        <span>Nouveau document</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-blue-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1" onclick="toggleView()">
                    <i class="fas fa-th-large mr-3 text-blue-600" id="view-icon"></i>
                    <span id="view-text">Vignettes</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total documents -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300"><?= number_format($documentsCount) ?></div>
                        <div class="text-sm font-medium text-gray-600">Total</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Documents archivés</div>
            </div>
                </div>
                
        <!-- Par type -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-pdf text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300"><?= count(array_filter($documents, fn($doc) => $doc['file_type'] === 'pdf')) ?></div>
                        <div class="text-sm font-medium text-gray-600">PDF</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Documents PDF</div>
            </div>
                    </div>
                    
        <!-- Collections -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-folder text-white text-xl"></i>
                            </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300"><?= count($collections) ?></div>
                        <div class="text-sm font-medium text-gray-600">Collections</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Dossiers actifs</div>
            </div>
        </div>

        <!-- Taille totale -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-orange-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hdd text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300"><?= DataLoader::formatBytes(array_sum(array_column($documents, 'file_size'))) ?></div>
                        <div class="text-sm font-medium text-gray-600">Stockage</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Espace utilisé</div>
                    </div>
                </div>
            </div>

    <!-- Filtres et actions modernisés -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-folder mr-2 text-gray-400"></i>
                            Collection :
                        </label>
                        <select class="form-select w-44" id="collection-filter">
                            <option value="">Toutes les collections</option>
                            <?php foreach ($collections as $collection): ?>
                            <option value="<?= $collection['id'] ?>"><?= htmlspecialchars($collection['name']) ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-file mr-2 text-gray-400"></i>
                            Type :
                        </label>
                        <select class="form-select w-32" id="type-filter">
                                <option value="">Tous</option>
                                <option value="pdf">PDF</option>
                            <option value="docx">DOCX</option>
                            <option value="xlsx">XLSX</option>
                            <option value="dwg">DWG</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-shield-alt mr-2 text-gray-400"></i>
                            Statut :
                        </label>
                        <select class="form-select w-32" id="status-filter">
                                <option value="">Tous</option>
                                <option value="archived">Archivé</option>
                                <option value="validated">Validé</option>
                            <option value="draft">Brouillon</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-calendar mr-2 text-gray-400"></i>
                            Date :
                        </label>
                        <select class="form-select w-36" id="date-filter">
                            <option value="">Toutes les dates</option>
                                <option value="today">Aujourd'hui</option>
                                <option value="week">Cette semaine</option>
                                <option value="month">Ce mois</option>
                                <option value="year">Cette année</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                    <button class="group inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" onclick="refreshDocuments()">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        <span>Actualiser</span>
                    </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" onclick="exportDocuments()">
                        <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Exporter</span>
                        </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-200" onclick="showAdvancedFilters()">
                        <i class="fas fa-filter mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Filtres avancés</span>
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
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-table text-blue-600"></i>
                    </div>
                    Liste des documents
                </h3>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-file-alt mr-1"></i>
                    <?= number_format($documentsCount) ?> documents
                    </div>
                </div>
            </div>

                <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                        <th class="w-4 px-6 py-4">
                                    <input type="checkbox" id="select-all-docs" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="title">
                            <div class="flex items-center">
                                Document
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Collection</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="date">
                            <div class="flex items-center">
                                Date d'archivage
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taille</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($documents as $document): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="doc-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" data-id="<?= $document['id'] ?>">
                                </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                        <div>
                                    <div class="font-semibold text-gray-900 hover:text-blue-600 transition-colors duration-200 cursor-pointer" onclick="viewDocument(<?= $document['id'] ?>)">
                                        <?= htmlspecialchars($document['title']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <?= htmlspecialchars($document['description'] ?? 'Aucune description') ?>
                                    </div>
                                        </div>
                                    </div>
                                </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?= strtoupper($document['file_type']) ?>
                            </span>
                                </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($document['collection_name'] ?? 'Non définie') ?></span>
                                </td>
                        <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                               <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($document['created_by_name'] ?? 'Inconnu') ?></span>
                                    </div>
                                </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?= date('d/m/Y', strtotime($document['created_at'])) ?>
                                        </div>
                            <div class="text-xs text-gray-500">
                                <?= DataLoader::timeAgo($document['created_at']) ?>
                                    </div>
                                </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900"><?= DataLoader::formatBytes($document['file_size']) ?></span>
                                </td>
                        <td class="px-6 py-4">
                            <span class="<?= DataLoader::getBadgeClasses($document['status']) ?>">
                                <?= ucfirst($document['status']) ?>
                            </span>
                                </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200" onclick="viewDocument(<?= $document['id'] ?>)" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                <button class="p-2 text-green-600 hover:text-green-700 hover:bg-green-100 rounded-lg transition-all duration-200" onclick="downloadDocument(<?= $document['id'] ?>)" title="Télécharger">
                                            <i class="fas fa-download"></i>
                                        </button>
                                <button class="p-2 text-purple-600 hover:text-purple-700 hover:bg-purple-100 rounded-lg transition-all duration-200" onclick="editDocument(<?= $document['id'] ?>)" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                <button class="p-2 text-red-600 hover:text-red-700 hover:bg-red-100 rounded-lg transition-all duration-200" onclick="deleteDocument(<?= $document['id'] ?>)" title="Supprimer">
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
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?= min(10, $documentsCount) ?></span> sur <span class="font-medium"><?= number_format($documentsCount) ?></span> résultats
                        </div>
                        <div class="flex items-center space-x-2">
                    <button class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200 disabled:opacity-50" disabled>
                        <i class="fas fa-chevron-left mr-1"></i>
                        Précédent
                            </button>
                    <div class="flex items-center space-x-1">
                        <button class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg shadow-sm">1</button>
                        <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">2</button>
                        <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">3</button>
                            <span class="px-2 text-sm text-gray-500">...</span>
                        <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200"><?= ceil($documentsCount / 10) ?></button>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($documents as $document): ?>
            <!-- Carte document -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 <?= DataLoader::getFileIcon($document['file_type'])['bg'] ?> rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
                            <i class="<?= DataLoader::getFileIcon($document['file_type'])['icon'] ?> <?= DataLoader::getFileIcon($document['file_type'])['color'] ?> text-xl"></i>
                            </div>
                            <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-600 p-1 hover:bg-gray-100 rounded transition-colors duration-200">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                        
                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200 cursor-pointer" onclick="viewDocument(<?= $document['id'] ?>)">
                        <?= htmlspecialchars($document['title']) ?>
                    </h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        <?= htmlspecialchars($document['description'] ?? 'Aucune description disponible') ?>
                    </p>
                    
                    <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-sm">
                            <span class="text-gray-500 flex items-center">
                                <i class="fas fa-folder mr-1"></i>
                                Collection :
                            </span>
                            <span class="text-gray-900 font-medium"><?= htmlspecialchars($document['collection_name'] ?? 'Non définie') ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 flex items-center">
                                <i class="fas fa-weight-hanging mr-1"></i>
                                Taille :
                            </span>
                            <span class="text-gray-900 font-medium"><?= DataLoader::formatBytes($document['file_size']) ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 flex items-center">
                                <i class="fas fa-calendar mr-1"></i>
                                Date :
                            </span>
                            <span class="text-gray-900 font-medium"><?= date('d/m/Y', strtotime($document['created_at'])) ?></span>
                        </div>
                            <div class="flex justify-between text-sm">
                            <span class="text-gray-500 flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                Auteur :
                            </span>
                            <span class="text-gray-900 font-medium"><?= htmlspecialchars($document['created_by_name'] ?? 'Inconnu') ?></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <span class="<?= DataLoader::getBadgeClasses($document['status']) ?>">
                            <?= ucfirst($document['status']) ?>
                        </span>
                            <div class="flex items-center space-x-2">
                            <button class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200" onclick="viewDocument(<?= $document['id'] ?>)" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                            <button class="p-2 text-green-600 hover:text-green-700 hover:bg-green-100 rounded-lg transition-all duration-200" onclick="downloadDocument(<?= $document['id'] ?>)" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </button>
                            <button class="p-2 text-purple-600 hover:text-purple-700 hover:bg-purple-100 rounded-lg transition-all duration-200" onclick="editDocument(<?= $document['id'] ?>)" title="Modifier">
                                <i class="fas fa-edit"></i>
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
});

function initFilters() {
    const filters = ["collection-filter", "type-filter", "status-filter", "date-filter"];
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
    document.getElementById("select-all-docs").addEventListener("change", function() {
        const checkboxes = document.querySelectorAll(".doc-checkbox");
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsVisibility();
    });

    // Sélection individuelle
    document.querySelectorAll(".doc-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", updateBulkActionsVisibility);
    });
}

function updateBulkActionsVisibility() {
    const checkedBoxes = document.querySelectorAll(".doc-checkbox:checked");
    // Logique pour afficher/masquer les actions groupées
}

function applyFilters() {
    const collectionFilter = document.getElementById("collection-filter").value;
    const typeFilter = document.getElementById("type-filter").value;
    const statusFilter = document.getElementById("status-filter").value;
    const dateFilter = document.getElementById("date-filter").value;
    
    // Simulation du filtrage
    console.log("Filtres appliqués:", { collectionFilter, typeFilter, statusFilter, dateFilter });
    showToast("Filtres appliqués", "info");
}

function sortTable(column) {
    // Simulation du tri
    console.log("Tri par:", column);
    showToast("Tableau trié par " + column, "info");
}

        function viewDocument(id) {
    window.location.href = `document.php?id=${id}`;
        }

        function downloadDocument(id) {
    showToast("Téléchargement en cours...", "info");
            // Simulation de téléchargement
            setTimeout(() => {
        showToast("Document téléchargé avec succès !", "success");
            }, 2000);
        }

        function editDocument(id) {
    window.location.href = `edit-document.php?id=${id}`;
        }

        function deleteDocument(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce document ? Cette action est irréversible.")) {
        showToast("Document supprimé avec succès !", "success");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

        function exportDocuments() {
    const checkedBoxes = document.querySelectorAll(".doc-checkbox:checked");
            if (checkedBoxes.length === 0) {
        showToast("Veuillez sélectionner au moins un document", "warning");
                return;
            }
            
    showToast(`Export de ${checkedBoxes.length} document(s) en cours...`, "success");
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
        viewIcon.className = "fas fa-list mr-3 text-blue-600";
        viewText.textContent = "Tableau";
        currentView = "grid";
        showToast("Vue vignettes activée", "info");
            } else {
        // Passer à la vue tableau
        tableView.classList.remove("hidden");
        gridView.classList.add("hidden");
        viewIcon.className = "fas fa-th-large mr-3 text-blue-600";
        viewText.textContent = "Vignettes";
        currentView = "table";
        showToast("Vue tableau activée", "info");
            }
        }

        function refreshDocuments() {
    showToast("Actualisation en cours...", "info");
    setTimeout(() => {
            window.location.reload();
    }, 1000);
        }

        function showAdvancedFilters() {
    showToast("Filtres avancés - Fonctionnalité à venir", "info");
}
';

// Inclure le layout
include 'includes/layout.php';
?> 
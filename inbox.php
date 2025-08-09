<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'File d\'attente';
$current_page = 'inbox';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour la file d'attente
$pendingDocuments = DataLoader::getDocuments(null, 'pending');
$pendingCount = count($pendingDocuments);

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index.php'],
    ['label' => 'File d\'attente']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>
    
<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-yellow-50 via-white to-orange-50 rounded-2xl border border-yellow-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-yellow-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-orange-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-inbox mr-2"></i>
                    File d'attente
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Documents en <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-600 to-orange-600">attente</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Gérez et validez les documents en attente de traitement dans votre file d'attente d'archivage.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                        <?= $pendingCount ?> documents en attente
                    </div>
            <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Dernière mise à jour : <?= date('H:i') ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="validateAll()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-check-double mr-3 text-lg"></i>
                        <span>Valider tout</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-green-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </button>
                <a href="upload.php" class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-3 text-yellow-600"></i>
                    <span>Nouveau document</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total en attente -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors duration-300"><?= $pendingCount ?></div>
                        <div class="text-sm font-medium text-gray-600">En attente</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Documents à traiter</div>
            </div>
                </div>
                
        <!-- Aujourd'hui -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-day text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300"><?= count(array_filter($pendingDocuments, fn($doc) => date('Y-m-d', strtotime($doc['created_at'])) === date('Y-m-d'))) ?></div>
                        <div class="text-sm font-medium text-gray-600">Aujourd'hui</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Déposés aujourd'hui</div>
            </div>
                    </div>
                    
        <!-- Urgents -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-red-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                            </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-red-600 transition-colors duration-300"><?= count(array_filter($pendingDocuments, fn($doc) => $doc['confidentiality'] === 'confidentiel' || $doc['file_size'] > 10000000)) ?></div>
                        <div class="text-sm font-medium text-gray-600">Urgents</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Traitement prioritaire</div>
            </div>
        </div>

        <!-- Temps moyen -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-stopwatch text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300">2.5h</div>
                        <div class="text-sm font-medium text-gray-600">Temps moyen</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Traitement moyen</div>
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
                            <i class="fas fa-filter mr-2 text-gray-400"></i>
                            Statut :
                        </label>
                        <select class="form-select w-36" id="status-filter">
                                <option value="">Tous</option>
                                <option value="pending">En attente</option>
                                <option value="reviewing">En cours</option>
                                <option value="rejected">Rejetés</option>
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
                                <option value="doc">DOC</option>
                                <option value="image">Image</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-calendar mr-2 text-gray-400"></i>
                            Date :
                        </label>
                        <select class="form-select w-36" id="date-filter">
                                <option value="">Toutes</option>
                                <option value="today">Aujourd'hui</option>
                                <option value="week">Cette semaine</option>
                                <option value="month">Ce mois</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                    <button class="group inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" onclick="refreshInbox()">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        <span>Actualiser</span>
                        </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" onclick="exportInbox()">
                        <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Exporter</span>
                        </button>
                    </div>
                </div>
            </div>
    </div>

    <!-- Tableau des documents moderne -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-list text-yellow-600"></i>
                    </div>
                    Documents en attente
                </h3>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-file-alt mr-1"></i>
                    <?= $pendingCount ?> documents
                    </div>
                </div>
            </div>

                <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                        <th class="w-4 px-6 py-4">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="title">
                            <div class="flex items-center">
                                Document
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Collection</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Déposé par</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="date">
                            <div class="flex items-center">
                                Date de dépôt
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taille</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($pendingDocuments as $index => $document): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="document-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" data-id="<?= $document['id'] ?>">
                                </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                             
                                        <div>
                                    <div class="font-semibold text-gray-900 hover:text-blue-600 transition-colors duration-200 cursor-pointer" onclick="previewDocument(<?= $document['id'] ?>)">
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
                                <i class="fas fa-clock mr-1"></i>
                                <?= ucfirst($document['status']) ?>
                            </span>
                                </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200" onclick="previewDocument(<?= $document['id'] ?>)" title="Prévisualiser">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                <button class="p-2 text-green-600 hover:text-green-700 hover:bg-green-100 rounded-lg transition-all duration-200" onclick="validateDocument(<?= $document['id'] ?>)" title="Valider">
                                            <i class="fas fa-check"></i>
                                        </button>
                                <button class="p-2 text-red-600 hover:text-red-700 hover:bg-red-100 rounded-lg transition-all duration-200" onclick="rejectDocument(<?= $document['id'] ?>)" title="Rejeter">
                                            <i class="fas fa-times"></i>
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
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?= min(10, $pendingCount) ?></span> sur <span class="font-medium"><?= $pendingCount ?></span> résultats
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
                    </div>
                    <button class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                        Suivant
                        <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<!-- Modal de prévisualisation moderne -->
<div id="preview-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-eye text-blue-600"></i>
                    </div>
                    Prévisualisation du document
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-8">
            <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl p-12 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-pdf text-white text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Aperçu du document</h4>
                <p class="text-gray-600 mb-6">Le contenu du document sera affiché ici</p>
                <div class="text-sm text-gray-500">
                    Fonctionnalité de prévisualisation en cours de développement
                </div>
            </div>
            </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3">
            <button onclick="closeModal()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Fermer
            </button>
            <button onclick="validateDocumentFromModal()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-check mr-2"></i>
                Valider
            </button>
            <button onclick="rejectDocumentFromModal()" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                <i class="fas fa-times mr-2"></i>
                Rejeter
            </button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capturer le contenu

// JavaScript personnalisé pour cette page
$inline_js = '
// Variables globales
let currentDocumentId = null;

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initFilters();
    initTableSorting();
    initBulkActions();
});

function initFilters() {
    const filters = ["status-filter", "type-filter", "date-filter"];
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
    document.getElementById("select-all").addEventListener("change", function() {
        const checkboxes = document.querySelectorAll(".document-checkbox");
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsVisibility();
    });

    // Sélection individuelle
    document.querySelectorAll(".document-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", updateBulkActionsVisibility);
    });
}

function updateBulkActionsVisibility() {
    const checkedBoxes = document.querySelectorAll(".document-checkbox:checked");
    // Logique pour afficher/masquer les actions groupées
}

function applyFilters() {
    const statusFilter = document.getElementById("status-filter").value;
    const typeFilter = document.getElementById("type-filter").value;
    const dateFilter = document.getElementById("date-filter").value;
    
    // Simulation du filtrage
    console.log("Filtres appliqués:", { statusFilter, typeFilter, dateFilter });
    showToast("Filtres appliqués", "info");
}

function sortTable(column) {
    // Simulation du tri
    console.log("Tri par:", column);
    showToast("Tableau trié par " + column, "info");
}

        function validateDocument(id) {
    if (confirm("Êtes-vous sûr de vouloir valider ce document ?")) {
                // Simulation de validation
        showToast("Document validé avec succès !", "success");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

        function rejectDocument(id) {
    const reason = prompt("Raison du rejet :");
    if (reason && reason.trim()) {
                // Simulation de rejet
        showToast("Document rejeté : " + reason, "warning");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

        function previewDocument(id) {
    currentDocumentId = id;
    document.getElementById("preview-modal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("preview-modal").classList.add("hidden");
    currentDocumentId = null;
}

function validateDocumentFromModal() {
    if (currentDocumentId) {
        validateDocument(currentDocumentId);
        closeModal();
    }
}

function rejectDocumentFromModal() {
    if (currentDocumentId) {
        rejectDocument(currentDocumentId);
        closeModal();
    }
        }

        function validateAll() {
    const checkedBoxes = document.querySelectorAll(".document-checkbox:checked");
            if (checkedBoxes.length === 0) {
        showToast("Veuillez sélectionner au moins un document", "warning");
                return;
            }
            
            if (confirm(`Êtes-vous sûr de vouloir valider ${checkedBoxes.length} document(s) ?`)) {
        showToast(`${checkedBoxes.length} document(s) validé(s) avec succès !`, "success");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

        function rejectAll() {
    const checkedBoxes = document.querySelectorAll(".document-checkbox:checked");
            if (checkedBoxes.length === 0) {
        showToast("Veuillez sélectionner au moins un document", "warning");
                return;
            }
            
    const reason = prompt("Raison du rejet :");
    if (reason && reason.trim()) {
        showToast(`${checkedBoxes.length} document(s) rejeté(s) : ${reason}`, "warning");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

        function refreshInbox() {
    showToast("Actualisation en cours...", "info");
    setTimeout(() => {
            window.location.reload();
    }, 1000);
        }

        function exportInbox() {
    showToast("Export en cours...", "success");
    // Simulation de l\'export
}

// Fermer le modal en cliquant en dehors
document.getElementById("preview-modal").addEventListener("click", function(e) {
    if (e.target === this) {
        closeModal();
    }
});
';

// Inclure le layout
include 'includes/layout.php';
?> 
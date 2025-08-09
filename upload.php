<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Importer un document';
$current_page = 'upload';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour la page upload
$collections = DataLoader::getCollections();
$config = DataLoader::getConfig('storage');

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index.php'],
    ['label' => 'Importer']
];

// CSS personnalisé pour cette page
$custom_css = [];

// JavaScript personnalisé pour cette page
$custom_js = [];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-green-50 via-white to-blue-50 rounded-2xl border border-green-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-green-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-blue-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-cloud-upload-alt mr-2"></i>
                    Import de documents
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Importer un <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600">document</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Ajoutez facilement vos documents à la plateforme d'archivage électronique avec notre système de drag & drop moderne.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        Formats supportés : <?= count($config['allowed_extensions'] ?? []) ?> types
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-gray-400"></i>
                        Taille max : <?= $config['max_file_size_mb'] ?? 50 ?> MB
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="showImportHistory()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-history mr-3 text-lg"></i>
                        <span>Historique</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-green-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </button>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-300 transform hover:-translate-y-1" onclick="showBulkImport()">
                    <i class="fas fa-layer-group mr-3 text-green-600"></i>
                    <span>Import en lot</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Zone de drag & drop moderne -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Zone d'upload principale -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-file-import text-green-600"></i>
                                </div>
                                Sélectionner les fichiers
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Glissez-déposez vos documents ou cliquez pour sélectionner</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Multi-sélection
                    </div>
                </div>
            </div>

                <div class="p-8">
                    <!-- Zone de drag & drop moderne -->
                    <div id="dropzone" class="group relative border-2 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:border-green-400 hover:bg-green-50/50 transition-all duration-300 cursor-pointer">
                        <div class="dropzone-content">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-cloud-upload-alt text-green-600 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Déposez vos fichiers ici</h3>
                            <p class="text-gray-600 mb-6 text-lg">ou cliquez pour parcourir votre ordinateur</p>
                            <button type="button" class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                                <div class="relative z-10 flex items-center">
                                    <i class="fas fa-folder-open mr-3"></i>
                                    <span>Parcourir les fichiers</span>
                                    </div>
                                <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-green-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </button>
                            <input type="file" id="file-input" multiple class="hidden" accept="<?= '.' . implode(',.', $config['allowed_extensions'] ?? ['pdf']) ?>">
                                </div>
                                
                        <!-- État de glissement -->
                        <div class="dropzone-overlay absolute inset-0 bg-gradient-to-br from-green-500 to-blue-500 rounded-2xl flex items-center justify-center hidden">
                            <div class="flex flex-col items-center text-white">
                                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mb-6 animate-bounce">
                                    <i class="fas fa-download text-white text-3xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-3">Relâchez pour importer</h3>
                                <p class="text-green-100 text-lg">Vos fichiers seront ajoutés à la file d'upload</p>
                                    </div>
                                </div>
                            </div>
                            
                    <!-- Formats acceptés -->
                    <div class="mt-6 p-4 bg-gradient-to-r from-gray-50 to-gray-100/50 rounded-xl">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-sm font-medium text-gray-700">Formats acceptés :</span>
                            <?php foreach ($config['allowed_extensions'] ?? [] as $ext): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <?= strtoupper($ext) ?>
                            </span>
                            <?php endforeach; ?>
                        </div>

                        <!-- Limites dynamiques -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-weight-hanging mr-2 text-green-600"></i>
                                <span>Max : <strong><?= $config['max_file_size_mb'] ?? 50 ?> MB</strong> par fichier</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-layer-group mr-2 text-blue-600"></i>
                                <span>Jusqu'à <strong>10 fichiers</strong> par import</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-shield-check mr-2 text-purple-600"></i>
                                <span>Validation <strong>automatique</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
                                </div>

            <!-- Liste des fichiers sélectionnés moderne -->
            <div id="files-list" class="hidden mt-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-list text-blue-600"></i>
                                </div>
                                Fichiers sélectionnés
                            </h3>
                            <button class="group inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200" onclick="clearFilesList()">
                                <i class="fas fa-trash mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                <span>Vider</span>
                            </button>
                                </div>
                                </div>

                    <div id="files-container" class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                        <!-- Les fichiers seront ajoutés dynamiquement -->
                                </div>
                                </div>
                                </div>
                                </div>

        <!-- Panneau de métadonnées moderne -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-tags text-purple-600"></i>
                                </div>
                            Métadonnées
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Informations communes pour tous les fichiers</p>
                                </div>

                    <div class="p-6">
                        <form id="metadata-form" class="space-y-5">
                                <div class="form-group">
                                <label for="collection" class="form-label required flex items-center">
                                    <i class="fas fa-folder mr-2 text-blue-600"></i>
                                    Collection
                                </label>
                                <select id="collection" name="collection" class="form-select w-full py-2" required>
                                    <option value="">Sélectionner une collection</option>
                                    <?php foreach ($collections as $collection): ?>
                                    <option value="<?= $collection['id'] ?>"><?= htmlspecialchars($collection['name']) ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                <label for="category" class="form-label required flex items-center">
                                    <i class="fas fa-bookmark mr-2 text-green-600"></i>
                                    Catégorie
                                </label>
                                <select id="category" name="category" class="form-select w-full py-2" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    <option value="contrat">Contrat</option>
                                    <option value="rapport">Rapport</option>
                                    <option value="plan">Plan/Schéma</option>
                                    <option value="facture">Facture</option>
                                    <option value="correspondance">Correspondance</option>
                                    <option value="procedure">Procédure</option>
                                    </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="confidentiality" class="form-label required flex items-center">
                                    <i class="fas fa-shield-alt mr-2 text-orange-600"></i>
                                    Confidentialité
                                </label>
                                <select id="confidentiality" name="confidentiality" class="form-select w-full py-2" required>
                                    <option value="">Niveau de confidentialité</option>
                                    <option value="public">🟢 Public</option>
                                    <option value="internal">🔵 Interne</option>
                                    <option value="restricted">🟠 Restreint</option>
                                    <option value="confidential">🔴 Confidentiel</option>
                                </select>
                    </div>

                            <div class="form-group">
                                <label for="author" class="form-label flex items-center">
                                    <i class="fas fa-user mr-2 text-purple-600"></i>
                                    Auteur
                                </label>
                                <input type="text" id="author" name="author" class="form-input w-full py-2" placeholder="Nom de l'auteur" value="<?= htmlspecialchars($user_name) ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject" class="form-label flex items-center">
                                    <i class="fas fa-heading mr-2 text-indigo-600"></i>
                                    Sujet
                                </label>
                                <input type="text" id="subject" name="subject" class="form-input w-full py-2" placeholder="Sujet du document">
                        </div>

                            <div class="form-group">
                                <label for="keywords" class="form-label flex items-center">
                                    <i class="fas fa-hashtag mr-2 text-pink-600"></i>
                                    Mots-clés
                                </label>
                                <input type="text" id="keywords" name="keywords" class="form-input w-full py-2" placeholder="infrastructure, sgitp, archivage">
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Utilisez des virgules pour séparer les mots-clés
                                </p>
                            </div>
                            
                            <div class="form-group">
                                <label for="description" class="form-label flex items-center">
                                    <i class="fas fa-align-left mr-2 text-teal-600"></i>
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="3" class="form-textarea w-full py-2" placeholder="Description détaillée du document..."></textarea>
                        </div>

                            <div class="form-group">
                                <label for="retention-period" class="form-label flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-red-600"></i>
                                    Durée de conservation
                                </label>
                                <select id="retention-period" name="retentionPeriod" class="form-select">
                                    <option value="">Sélectionner la durée</option>
                                    <option value="5">5 ans</option>
                                    <option value="10">10 ans (recommandé)</option>
                                    <option value="15">15 ans</option>
                                    <option value="25">25 ans</option>
                                    <option value="permanent">Permanent</option>
                                </select>
                            </div>
                            
                            <!-- Actions -->
                            <div class="pt-6 border-t border-gray-200">
                                <button type="button" class="group relative w-full inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="startUpload()" disabled id="upload-btn">
                                    <div class="relative z-10 flex items-center">
                                        <i class="fas fa-cloud-upload-alt mr-3"></i>
                                        <span>Commencer l'import</span>
                                </div>
                                    <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-green-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </button>
                                
                                <div class="mt-4 text-center">
                                    <p class="text-xs text-gray-500 flex items-center justify-center">
                                        <i class="fas fa-shield-check mr-1 text-green-500"></i>
                                        Les documents seront ajoutés à la file de validation
                                    </p>
                                </div>
                            </div>
                        </form>
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
let selectedFiles = [];
let isUploading = false;

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initDropzone();
    initFileInput();
    initMetadataForm();
});

function initDropzone() {
    const dropzone = document.getElementById("dropzone");
    const overlay = dropzone.querySelector(".dropzone-overlay");
    
    // Événements de drag & drop
    dropzone.addEventListener("dragover", function(e) {
        e.preventDefault();
        dropzone.classList.add("dragover");
        overlay.classList.remove("hidden");
    });
    
    dropzone.addEventListener("dragleave", function(e) {
        e.preventDefault();
        if (!dropzone.contains(e.relatedTarget)) {
            dropzone.classList.remove("dragover");
            overlay.classList.add("hidden");
        }
    });
    
    dropzone.addEventListener("drop", function(e) {
        e.preventDefault();
        dropzone.classList.remove("dragover");
        overlay.classList.add("hidden");
        
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });
    
    // Clic sur la zone
    dropzone.addEventListener("click", function() {
        document.getElementById("file-input").click();
    });
}

function initFileInput() {
    const fileInput = document.getElementById("file-input");
    
    fileInput.addEventListener("change", function() {
        const files = Array.from(this.files);
        handleFiles(files);
    });
}

function initMetadataForm() {
    const form = document.getElementById("metadata-form");
    const inputs = form.querySelectorAll("input[required], select[required]");
    
    inputs.forEach(input => {
        input.addEventListener("change", validateForm);
    });
}

function handleFiles(files) {
    // Validation
    const validFiles = files.filter(file => {
        if (file.size > 50 * 1024 * 1024) { // 50MB
            showToast(`Fichier trop volumineux: ${file.name}`, "error");
            return false;
        }
        return true;
    });
    
    if (validFiles.length === 0) return;
    
    // Ajouter à la liste
    selectedFiles = [...selectedFiles, ...validFiles];
    displayFilesList();
    validateForm();
    
    showToast(`${validFiles.length} fichier(s) ajouté(s)`, "success");
}

function displayFilesList() {
    const container = document.getElementById("files-container");
    const listDiv = document.getElementById("files-list");
    
    if (selectedFiles.length === 0) {
        listDiv.classList.add("hidden");
        return;
    }
    
    listDiv.classList.remove("hidden");
    
    container.innerHTML = selectedFiles.map((file, index) => `
        <div class="p-4 flex items-center space-x-4">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-blue-600"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900 truncate">${file.name}</div>
                <div class="text-sm text-gray-500">${formatFileSize(file.size)}</div>
            </div>
            <button onclick="removeFile(${index})" class="text-red-600 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join("");
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    displayFilesList();
    validateForm();
}

function clearFilesList() {
    selectedFiles = [];
    displayFilesList();
    validateForm();
}

function validateForm() {
    const form = document.getElementById("metadata-form");
    const uploadBtn = document.getElementById("upload-btn");
    const requiredInputs = form.querySelectorAll("input[required], select[required]");
    
    let isValid = selectedFiles.length > 0;
    
    requiredInputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
        }
    });
    
    uploadBtn.disabled = !isValid;
}

function startUpload() {
    if (isUploading || selectedFiles.length === 0) return;
    
    isUploading = true;
    const uploadBtn = document.getElementById("upload-btn");
    
    uploadBtn.innerHTML = `
        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
        Import en cours...
    `;
    uploadBtn.disabled = true;
    
    // Simulation d\'upload
    setTimeout(() => {
        isUploading = false;
        uploadBtn.innerHTML = `<i class="fas fa-upload mr-2"></i> Commencer l\'import`;
        
        showToast(`${selectedFiles.length} document(s) importé(s) avec succès`, "success");
        
        // Redirection vers la file d\'attente
        setTimeout(() => {
            window.location.href = "inbox.php";
        }, 2000);
    }, 3000);
}

function formatFileSize(bytes) {
    if (bytes === 0) return "0 B";
    const k = 1024;
    const sizes = ["B", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
}

function showImportHistory() {
    showToast("Historique d\'import - Fonctionnalité à venir", "info");
}

function showBulkImport() {
    showToast("Import en lot - Fonctionnalité à venir", "info");
}
';

// Inclure le layout
include 'includes/layout.php';
?>
 
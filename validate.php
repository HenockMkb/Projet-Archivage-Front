<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation - e-Archive | SGITP</title>
    <meta name="description" content="Validation de documents par les archivistes">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="assets/css/main.css">
    
    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-archive text-white text-sm"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-900">e-Archive</h1>
            </div>
            <button id="sidebar-close" class="lg:hidden text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <a href="index.html" class="nav-link">
                <i class="fas fa-tachometer-alt nav-link-icon"></i>
                Tableau de bord
            </a>
            <a href="upload.html" class="nav-link">
                <i class="fas fa-upload nav-link-icon"></i>
                Importer
            </a>
            <a href="inbox.html" class="nav-link">
                <i class="fas fa-inbox nav-link-icon"></i>
                File d'attente
            </a>
            <a href="documents.html" class="nav-link">
                <i class="fas fa-file-alt nav-link-icon"></i>
                Documents
            </a>
            <a href="collections.html" class="nav-link">
                <i class="fas fa-folder nav-link-icon"></i>
                Collections
            </a>
            <a href="search.html" class="nav-link">
                <i class="fas fa-search nav-link-icon"></i>
                Recherche
            </a>
            <a href="workflows.html" class="nav-link">
                <i class="fas fa-tasks nav-link-icon"></i>
                Workflows
            </a>
            <a href="reports.html" class="nav-link">
                <i class="fas fa-chart-bar nav-link-icon"></i>
                Rapports
            </a>
            
            <div class="pt-6 mt-6 border-t border-gray-200">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    Administration
                </h3>
                <a href="admin/users.html" class="nav-link">
                    <i class="fas fa-users nav-link-icon"></i>
                    Utilisateurs
                </a>
                <a href="admin/roles.html" class="nav-link">
                    <i class="fas fa-user-shield nav-link-icon"></i>
                    Rôles
                </a>
                <a href="settings.html" class="nav-link">
                    <i class="fas fa-cog nav-link-icon"></i>
                    Paramètres
                </a>
            </div>
        </nav>
    </aside>

    <!-- Overlay pour mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <!-- Contenu principal -->
    <div class="lg:ml-64 min-h-screen">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="lg:hidden mr-4 text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-2xl font-bold text-gray-900">Validation de documents</h2>
                    <span class="ml-3 px-2 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full">Document en cours</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <!-- Profil utilisateur -->
                    <div class="relative">
                        <button class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-sm user-name">JD</span>
                            </div>
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-medium text-gray-900 user-name">Jean Dupont</div>
                                <div class="text-xs text-gray-500 user-role">Archiviste</div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="p-6">
            <!-- En-tête -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Validation de document</h1>
                        <p class="text-gray-600">Examinez et validez le document en cours</p>
                    </div>
                    <div class="mt-4 lg:mt-0 flex flex-wrap gap-3">
                        <button class="btn-success" onclick="validateDocument()">
                            <i class="fas fa-check mr-2"></i> Valider
                        </button>
                        <button class="btn-warning" onclick="requestRevision()">
                            <i class="fas fa-edit mr-2"></i> Demander révision
                        </button>
                        <button class="btn-danger" onclick="rejectDocument()">
                            <i class="fas fa-times mr-2"></i> Rejeter
                        </button>
                        <a href="inbox.html" class="btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i> Retour à la file
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations du document -->
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="card-title">Informations du document</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Rapport annuel 2023</div>
                            <div class="text-sm text-gray-500">PDF • 2.3 MB</div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Déposé par :</span>
                            <span class="text-gray-900">Marie Dubois</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Date de dépôt :</span>
                            <span class="text-gray-900">15/12/2023 à 14:30</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Collection :</span>
                            <span class="text-gray-900">Administratif</span>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Statut :</span>
                            <span class="badge badge-warning">En attente</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Priorité :</span>
                            <span class="text-gray-900">Normale</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Temps d'attente :</span>
                            <span class="text-gray-900">2h 15min</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone principale de validation -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- Viewer du document -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aperçu du document</h3>
                        <div class="flex items-center space-x-2">
                            <button class="btn-secondary" onclick="zoomIn()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button class="btn-secondary" onclick="zoomOut()">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button class="btn-secondary" onclick="downloadOriginal()">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-gray-100 rounded-lg p-8 text-center min-h-96 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-file-pdf text-6xl text-gray-400 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Rapport annuel 2023</h4>
                            <p class="text-gray-600 mb-4">Aperçu du document PDF</p>
                            <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                                <span><i class="fas fa-file mr-1"></i> 15 pages</span>
                                <span><i class="fas fa-calendar mr-1"></i> 2023</span>
                                <span><i class="fas fa-user mr-1"></i> Marie Dubois</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation des pages -->
                    <div class="mt-4 flex items-center justify-between">
                        <button class="btn-secondary" disabled>
                            <i class="fas fa-chevron-left mr-2"></i> Précédente
                        </button>
                        <span class="text-sm text-gray-600">Page 1 sur 15</span>
                        <button class="btn-secondary">
                            Suivante <i class="fas fa-chevron-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Formulaire de validation -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Validation et métadonnées</h3>
                    </div>
                    
                    <form id="validation-form" class="space-y-6">
                        <!-- Métadonnées existantes -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Métadonnées du document</h4>
                            
                            <div class="form-group">
                                <label for="title" class="form-label">Titre *</label>
                                <input type="text" id="title" name="title" required class="form-input" value="Rapport annuel 2023">
                            </div>
                            
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" rows="3" class="form-textarea">Rapport financier et opérationnel du SGITP pour l'année 2023</textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="document-type" class="form-label">Type de document *</label>
                                    <select id="document-type" name="documentType" required class="form-select">
                                        <option value="rapport" selected>Rapport</option>
                                        <option value="contrat">Contrat</option>
                                        <option value="plan">Plan</option>
                                        <option value="correspondance">Correspondance</option>
                                        <option value="facture">Facture</option>
                                        <option value="arrete">Arrêté</option>
                                        <option value="decret">Décret</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="collection" class="form-label">Collection *</label>
                                    <select id="collection" name="collection" required class="form-select">
                                        <option value="administratif" selected>Administratif</option>
                                        <option value="infrastructures">Infrastructures</option>
                                        <option value="urbanisme">Urbanisme</option>
                                        <option value="financier">Financier</option>
                                        <option value="ressources-humaines">Ressources Humaines</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="author" class="form-label">Auteur</label>
                                    <input type="text" id="author" name="author" class="form-input" value="Marie Dubois">
                                </div>
                                
                                <div class="form-group">
                                    <label for="creation-date" class="form-label">Date de création</label>
                                    <input type="date" id="creation-date" name="creationDate" class="form-input" value="2023-12-01">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="reference" class="form-label">Numéro de référence</label>
                                    <input type="text" id="reference" name="reference" class="form-input" placeholder="Réf. interne">
                                </div>
                                
                                <div class="form-group">
                                    <label for="language" class="form-label">Langue</label>
                                    <select id="language" name="language" class="form-select">
                                        <option value="fr" selected>Français</option>
                                        <option value="en">Anglais</option>
                                        <option value="ln">Lingala</option>
                                        <option value="sw">Swahili</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="keywords" class="form-label">Mots-clés</label>
                                <input type="text" id="keywords" name="keywords" class="form-input" placeholder="Séparés par des virgules" value="rapport, annuel, 2023, financier, opérationnel">
                            </div>
                        </div>

                        <!-- Décision de validation -->
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="font-medium text-gray-900 mb-4">Décision de validation</h4>
                            
                            <div class="space-y-4">
                                <div class="form-group">
                                    <label for="validation-status" class="form-label">Statut *</label>
                                    <select id="validation-status" name="validationStatus" required class="form-select">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="validated">Validé</option>
                                        <option value="revision">Révision demandée</option>
                                        <option value="rejected">Rejeté</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="validation-comments" class="form-label">Commentaires</label>
                                    <textarea id="validation-comments" name="validationComments" rows="4" class="form-textarea" placeholder="Commentaires sur la validation..."></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confidentiality" class="form-label">Niveau de confidentialité</label>
                                    <select id="confidentiality" name="confidentiality" class="form-select">
                                        <option value="public">Public</option>
                                        <option value="interne" selected>Interne</option>
                                        <option value="confidentiel">Confidentiel</option>
                                        <option value="secret">Secret</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="retention-period" class="form-label">Période de conservation</label>
                                    <select id="retention-period" name="retentionPeriod" class="form-select">
                                        <option value="5">5 ans</option>
                                        <option value="10" selected>10 ans</option>
                                        <option value="25">25 ans</option>
                                        <option value="permanent">Permanent</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                                <div class="flex items-center space-x-3">
                                    <button type="submit" class="btn-success">
                                        <i class="fas fa-check mr-2"></i> Valider et archiver
                                    </button>
                                    <button type="button" class="btn-warning" onclick="saveDraft()">
                                        <i class="fas fa-save mr-2"></i> Sauvegarder brouillon
                                    </button>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <button type="button" class="btn-secondary" onclick="resetForm()">
                                        <i class="fas fa-undo mr-2"></i> Réinitialiser
                                    </button>
                                    <button type="button" class="btn-danger" onclick="rejectDocument()">
                                        <i class="fas fa-times mr-2"></i> Rejeter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Historique des validations -->
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="card-title">Historique des validations</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-upload text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">Document déposé</div>
                            <div class="text-sm text-gray-500">Par Marie Dubois • 15/12/2023 à 14:30</div>
                        </div>
                        <span class="badge badge-info">Déposé</span>
                    </div>
                    
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">En attente de validation</div>
                            <div class="text-sm text-gray-500">Assigné à Jean Dupont • 15/12/2023 à 14:35</div>
                        </div>
                        <span class="badge badge-warning">En attente</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de confirmation -->
    <div id="confirm-modal" class="modal-overlay hidden">
        <div class="modal-content max-w-md">
            <div class="modal-header">
                <h3 class="text-lg font-semibold text-gray-900" id="confirm-title">Confirmation</h3>
                <button data-modal-close class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirm-message">Êtes-vous sûr de vouloir continuer ?</p>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" data-modal-close>Annuler</button>
                <button class="btn-primary" id="confirm-action">Confirmer</button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/app.js"></script>
    <script>
        // Fonctions pour la validation
        function validateDocument() {
            const status = document.getElementById('validation-status').value;
            if (!status) {
                window.eArchiveApp.showWarning('Veuillez sélectionner un statut de validation');
                return;
            }
            
            showConfirmModal(
                'Valider le document',
                'Êtes-vous sûr de vouloir valider ce document ? Il sera archivé définitivement.',
                () => {
                    window.eArchiveApp.showSuccess('Document validé avec succès !');
                    setTimeout(() => {
                        window.location.href = 'inbox.html';
                    }, 1500);
                }
            );
        }

        function requestRevision() {
            const comments = document.getElementById('validation-comments').value;
            if (!comments.trim()) {
                window.eArchiveApp.showWarning('Veuillez ajouter des commentaires pour la révision');
                return;
            }
            
            showConfirmModal(
                'Demander une révision',
                'Êtes-vous sûr de vouloir demander une révision de ce document ?',
                () => {
                    window.eArchiveApp.showSuccess('Demande de révision envoyée !');
                    setTimeout(() => {
                        window.location.href = 'inbox.html';
                    }, 1500);
                }
            );
        }

        function rejectDocument() {
            const comments = document.getElementById('validation-comments').value;
            if (!comments.trim()) {
                window.eArchiveApp.showWarning('Veuillez ajouter des commentaires pour le rejet');
                return;
            }
            
            showConfirmModal(
                'Rejeter le document',
                'Êtes-vous sûr de vouloir rejeter ce document ? Cette action est irréversible.',
                () => {
                    window.eArchiveApp.showSuccess('Document rejeté !');
                    setTimeout(() => {
                        window.location.href = 'inbox.html';
                    }, 1500);
                }
            );
        }

        function saveDraft() {
            window.eArchiveApp.showSuccess('Brouillon sauvegardé !');
        }

        function resetForm() {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ?')) {
                document.getElementById('validation-form').reset();
                window.eArchiveApp.showInfo('Formulaire réinitialisé');
            }
        }

        function showConfirmModal(title, message, action) {
            document.getElementById('confirm-title').textContent = title;
            document.getElementById('confirm-message').textContent = message;
            document.getElementById('confirm-action').onclick = action;
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        // Fonctions du viewer
        function zoomIn() {
            window.eArchiveApp.showInfo('Zoom avant');
        }

        function zoomOut() {
            window.eArchiveApp.showInfo('Zoom arrière');
        }

        function downloadOriginal() {
            window.eArchiveApp.showSuccess('Téléchargement en cours...');
        }

        // Gestion du formulaire
        document.getElementById('validation-form').addEventListener('submit', function(e) {
            e.preventDefault();
            validateDocument();
        });
    </script>
</body>
</html> 
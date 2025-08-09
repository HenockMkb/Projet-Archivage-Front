<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Paramètres système';
$current_page = 'settings';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = false;

// Définir le chemin des assets (racine)
$assets_path = '';

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index.php'],
    ['label' => 'Paramètres système']
];

// Données simulées pour les paramètres
$systemInfo = [
    'version' => '1.2.1',
    'last_update' => '20/12/2023',
    'status' => 'operational',
    'maintenance_mode' => false
];

$storageInfo = [
    'used' => 2.3,
    'total' => 5.0,
    'documents' => 1.8,
    'metadata' => 0.15,
    'logs' => 0.35
];

$backupHistory = [
    ['type' => 'Automatique', 'date' => '20/12/2023 à 02:00', 'status' => 'success'],
    ['type' => 'Automatique', 'date' => '19/12/2023 à 02:00', 'status' => 'success'],
    ['type' => 'Manuelle', 'date' => '18/12/2023 à 15:30', 'status' => 'success'],
    ['type' => 'Automatique', 'date' => '17/12/2023 à 02:00', 'status' => 'failed']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50 rounded-2xl border border-blue-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-blue-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-cogs mr-2"></i>
                    Configuration
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Paramètres <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">système</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Configurez et personnalisez les paramètres de votre plateforme d'archivage électronique.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        Système opérationnel
                            </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Version <?= $systemInfo['version'] ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="saveAllSettings()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-save mr-3 text-lg"></i>
                        <span>Enregistrer tout</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-blue-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </button>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1" onclick="exportConfig()">
                    <i class="fas fa-download mr-3 text-blue-600"></i>
                    <span>Exporter config</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation des paramètres -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-sliders-h text-blue-600"></i>
                </div>
                Configuration
            </h3>
            </div>

        <div class="p-6">
            <nav class="flex flex-wrap space-x-2 sm:space-x-8 border-b border-gray-200 pb-4">
                    <button class="param-tab active" data-tab="general">
                    <i class="fas fa-cog mr-2"></i> 
                    <span>Général</span>
                    </button>
                    <button class="param-tab" data-tab="security">
                    <i class="fas fa-shield-alt mr-2"></i> 
                    <span>Sécurité</span>
                    </button>
                    <button class="param-tab" data-tab="storage">
                    <i class="fas fa-hdd mr-2"></i> 
                    <span>Stockage</span>
                    </button>
                    <button class="param-tab" data-tab="notifications">
                    <i class="fas fa-bell mr-2"></i> 
                    <span>Notifications</span>
                    </button>
                    <button class="param-tab" data-tab="backup">
                    <i class="fas fa-database mr-2"></i> 
                    <span>Sauvegarde</span>
                    </button>
                    <button class="param-tab" data-tab="advanced">
                    <i class="fas fa-tools mr-2"></i> 
                    <span>Avancé</span>
                    </button>
                </nav>
        </div>
            </div>

            <!-- Onglet Général -->
            <div id="general-tab" class="param-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Informations système -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-green-600 text-sm"></i>
                        </div>
                        Informations système
                    </h3>
                        </div>
                        
                        <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-600">Version de l'application</span>
                        <span class="text-sm font-bold text-gray-900 bg-blue-100 text-blue-800 px-2 py-1 rounded"><?= $systemInfo['version'] ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-600">Dernière mise à jour</span>
                        <span class="text-sm font-semibold text-gray-900"><?= $systemInfo['last_update'] ?></span>
                            </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-600">Statut du système</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-circle mr-1 text-xs"></i>
                            Opérationnel
                        </span>
                            </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Mode maintenance</span>
                            <p class="text-xs text-gray-500">Désactive l'accès pour les utilisateurs</p>
                            </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" <?= $systemInfo['maintenance_mode'] ? 'checked' : '' ?>>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Paramètres généraux -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cog text-blue-600 text-sm"></i>
                        </div>
                        Paramètres généraux
                    </h3>
                        </div>
                        
                        <form class="space-y-4">
                            <div class="form-group">
                        <label for="site-name" class="form-label required">Nom du site</label>
                                <input type="text" id="site-name" name="siteName" class="form-input" value="e-Archive SGITP">
                            </div>
                            
                            <div class="form-group">
                                <label for="site-description" class="form-label">Description</label>
                        <textarea id="site-description" name="siteDescription" rows="3" class="form-input">Plateforme d'archivage électronique du SGITP - Direction des Archives et des Nouvelles Technologies de l'Information et de la Communication</textarea>
                            </div>
                            
                            <div class="form-group">
                        <label for="timezone" class="form-label required">Fuseau horaire</label>
                                <select id="timezone" name="timezone" class="form-select">
                                    <option value="Africa/Kinshasa" selected>Afrique/Kinshasa (GMT+1)</option>
                                    <option value="UTC">UTC (GMT+0)</option>
                                    <option value="Europe/Paris">Europe/Paris (GMT+1/+2)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                        <label for="language" class="form-label required">Langue par défaut</label>
                                <select id="language" name="language" class="form-select">
                                    <option value="fr" selected>Français</option>
                                    <option value="en">English</option>
                                    <option value="ln">Lingala</option>
                            <option value="sw">Swahili</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Onglet Sécurité -->
            <div id="security-tab" class="param-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Authentification -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-lock text-red-600 text-sm"></i>
                        </div>
                        Authentification
                    </h3>
                        </div>
                        
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Authentification à deux facteurs</h4>
                                    <p class="text-sm text-gray-600">Sécurisez les connexions avec 2FA</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Session unique</h4>
                                    <p class="text-sm text-gray-600">Une seule session active par utilisateur</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="session-timeout" class="form-label">Délai d'expiration de session (minutes)</label>
                                <input type="number" id="session-timeout" name="sessionTimeout" class="form-input" value="30" min="5" max="480">
                            </div>
                            
                            <div class="form-group">
                                <label for="password-policy" class="form-label">Politique de mots de passe</label>
                                <select id="password-policy" name="passwordPolicy" class="form-select">
                            <option value="strong" selected>Fort (8+ caractères, maj/min/chiffres/symboles)</option>
                            <option value="medium">Moyen (6+ caractères, maj/min/chiffres)</option>
                                    <option value="weak">Faible (4+ caractères)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Audit et logs -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-file-alt text-orange-600 text-sm"></i>
                        </div>
                        Audit et logs
                    </h3>
                        </div>
                        
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Logs d'audit</h4>
                            <p class="text-sm text-gray-600">Enregistrer toutes les actions utilisateurs</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="log-retention" class="form-label">Rétention des logs (jours)</label>
                                <input type="number" id="log-retention" name="logRetention" class="form-input" value="365" min="30" max="2555">
                            </div>
                            
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Chiffrement des données</h4>
                            <p class="text-sm text-gray-600">Chiffrer automatiquement les documents sensibles</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                    
                    <button class="btn-secondary w-full" onclick="downloadLogs()">
                        <i class="fas fa-download mr-2"></i>
                        Télécharger les logs d'audit
                    </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Stockage -->
            <div id="storage-tab" class="param-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Espace de stockage -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-hdd text-purple-600 text-sm"></i>
                        </div>
                        Espace de stockage
                    </h3>
                        </div>
                        
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100/50 rounded-lg p-6">
                        <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-medium text-gray-900">Utilisation du stockage</span>
                            <span class="text-sm font-bold text-purple-700"><?= $storageInfo['used'] ?> GB / <?= $storageInfo['total'] ?> GB</span>
                                </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <?php $percentage = ($storageInfo['used'] / $storageInfo['total']) * 100; ?>
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full transition-all duration-300" style="width: <?= $percentage ?>%"></div>
                                </div>
                        <p class="text-xs text-gray-600 mt-2"><?= round($percentage) ?>% utilisé</p>
                            </div>
                            
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-600 flex items-center">
                                <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                Documents :
                            </span>
                            <span class="text-sm font-bold text-gray-900"><?= $storageInfo['documents'] ?> GB</span>
                                </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-600 flex items-center">
                                <i class="fas fa-tags mr-2 text-green-500"></i>
                                Métadonnées :
                            </span>
                            <span class="text-sm font-bold text-gray-900"><?= number_format($storageInfo['metadata'], 2) ?> GB</span>
                                </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-600 flex items-center">
                                <i class="fas fa-list-alt mr-2 text-orange-500"></i>
                                Logs :
                            </span>
                            <span class="text-sm font-bold text-gray-900"><?= number_format($storageInfo['logs'], 2) ?> GB</span>
                                </div>
                            </div>
                            
                            <button class="btn-secondary w-full" onclick="cleanupStorage()">
                        <i class="fas fa-broom mr-2"></i> 
                        Nettoyer l'espace de stockage
                            </button>
                        </div>
                    </div>

                    <!-- Paramètres de stockage -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cogs text-blue-600 text-sm"></i>
                        </div>
                        Paramètres de stockage
                    </h3>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="form-group">
                                <label for="max-file-size" class="form-label">Taille maximale par fichier (MB)</label>
                                <input type="number" id="max-file-size" name="maxFileSize" class="form-input" value="50" min="1" max="500">
                            </div>
                            
                            <div class="form-group">
                                <label for="allowed-formats" class="form-label">Formats autorisés</label>
                        <textarea id="allowed-formats" name="allowedFormats" class="form-input" rows="3">pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,tiff,dwg,dxf,zip,rar</textarea>
                                <p class="text-xs text-gray-500 mt-1">Séparés par des virgules</p>
                            </div>
                            
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Compression automatique</h4>
                            <p class="text-sm text-gray-600">Compresser automatiquement les images volumineuses</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Sauvegarde cloud</h4>
                            <p class="text-sm text-gray-600">Synchroniser avec un stockage cloud externe</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Notifications -->
            <div id="notifications-tab" class="param-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Notifications par email -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-green-600 text-sm"></i>
                        </div>
                        Notifications par email
                    </h3>
                        </div>
                        
                        <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Nouveaux documents</h4>
                            <p class="text-sm text-gray-600">Notification pour chaque nouveau document importé</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Tâches en attente</h4>
                            <p class="text-sm text-gray-600">Rappels pour les validations en attente</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Rapports automatiques</h4>
                            <p class="text-sm text-gray-600">Rapports d'activité hebdomadaires</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="email-frequency" class="form-label">Fréquence des notifications</label>
                                <select id="email-frequency" name="emailFrequency" class="form-select">
                                    <option value="immediate">Immédiat</option>
                                    <option value="hourly">Toutes les heures</option>
                                    <option value="daily" selected>Quotidien</option>
                                    <option value="weekly">Hebdomadaire</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications système -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-bell text-yellow-600 text-sm"></i>
                        </div>
                        Notifications système
                    </h3>
                        </div>
                        
                        <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Notifications push</h4>
                            <p class="text-sm text-gray-600">Notifications temps réel dans le navigateur</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Sons de notification</h4>
                            <p class="text-sm text-gray-600">Jouer un son pour les notifications importantes</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Notifications de sécurité</h4>
                            <p class="text-sm text-gray-600">Alertes de connexions suspectes</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    <button class="btn-secondary w-full" onclick="testNotifications()">
                        <i class="fas fa-bell mr-2"></i>
                        Tester les notifications
                    </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Sauvegarde -->
            <div id="backup-tab" class="param-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Configuration de sauvegarde -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-database text-indigo-600 text-sm"></i>
                        </div>
                        Configuration de sauvegarde
                    </h3>
                        </div>
                        
                        <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Sauvegarde automatique</h4>
                            <p class="text-sm text-gray-600">Planifier des sauvegardes automatiques</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="backup-frequency" class="form-label">Fréquence de sauvegarde</label>
                                <select id="backup-frequency" name="backupFrequency" class="form-select">
                                    <option value="daily" selected>Quotidienne</option>
                                    <option value="weekly">Hebdomadaire</option>
                                    <option value="monthly">Mensuelle</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="backup-time" class="form-label">Heure de sauvegarde</label>
                        <input type="time" id="backup-time" name="backupTime" class="form-input" value="02:00">
                    </div>
                    
                    <div class="form-group">
                        <label for="backup-retention" class="form-label">Nombre de sauvegardes à conserver</label>
                        <input type="number" id="backup-retention" name="backupRetention" class="form-input" value="30" min="1" max="365">
                            </div>
                            
                            <button class="btn-primary w-full" onclick="createBackup()">
                        <i class="fas fa-download mr-2"></i> 
                        Créer une sauvegarde maintenant
                            </button>
                        </div>
                    </div>

                    <!-- Historique des sauvegardes -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-history text-purple-600 text-sm"></i>
                        </div>
                        Historique des sauvegardes
                    </h3>
                            </div>
                            
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    <?php foreach ($backupHistory as $backup): ?>
                    <div class="flex items-center justify-between p-4 <?= $backup['status'] === 'success' ? 'bg-green-50' : 'bg-red-50' ?> rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 <?= $backup['status'] === 'success' ? 'bg-green-100' : 'bg-red-100' ?> rounded-lg flex items-center justify-center">
                                <i class="fas <?= $backup['status'] === 'success' ? 'fa-check text-green-600' : 'fa-times text-red-600' ?> text-sm"></i>
                            </div>
                                <div>
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($backup['type']) ?></div>
                                <div class="text-sm text-gray-500"><?= htmlspecialchars($backup['date']) ?></div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $backup['status'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= $backup['status'] === 'success' ? 'Réussie' : 'Échouée' ?>
                            </span>
                            <?php if ($backup['status'] === 'success'): ?>
                            <button class="p-1 text-blue-600 hover:text-blue-700" onclick="downloadBackup('<?= $backup['date'] ?>')" title="Télécharger">
                                <i class="fas fa-download text-sm"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button class="btn-secondary w-full" onclick="cleanupBackups()">
                        <i class="fas fa-trash mr-2"></i>
                        Nettoyer les anciennes sauvegardes
                    </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Avancé -->
            <div id="advanced-tab" class="param-content hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Paramètres avancés -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-tools text-gray-600 text-sm"></i>
                        </div>
                        Paramètres avancés
                    </h3>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="form-group">
                                <label for="cache-timeout" class="form-label">Délai de cache (secondes)</label>
                                <input type="number" id="cache-timeout" name="cacheTimeout" class="form-input" value="300" min="60" max="3600">
                            </div>
                            
                            <div class="form-group">
                        <label for="max-upload-size" class="form-label">Taille maximale d'upload simultané (MB)</label>
                                <input type="number" id="max-upload-size" name="maxUploadSize" class="form-input" value="100" min="10" max="1000">
                            </div>
                            
                    <div class="form-group">
                        <label for="api-rate-limit" class="form-label">Limite de requêtes API (par minute)</label>
                        <input type="number" id="api-rate-limit" name="apiRateLimit" class="form-input" value="60" min="10" max="1000">
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Mode debug</h4>
                            <p class="text-sm text-gray-600">Afficher les informations de débogage détaillées</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions système -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                        </div>
                        Actions système
                    </h3>
                        </div>
                        
                <div class="space-y-3">
                            <button class="btn-secondary w-full" onclick="clearCache()">
                        <i class="fas fa-broom mr-2"></i> 
                        Vider le cache système
                            </button>
                            
                            <button class="btn-secondary w-full" onclick="optimizeDatabase()">
                        <i class="fas fa-database mr-2"></i> 
                        Optimiser la base de données
                    </button>
                    
                    <button class="btn-secondary w-full" onclick="reindexDocuments()">
                        <i class="fas fa-search mr-2"></i> 
                        Réindexer les documents
                            </button>
                            
                    <button class="px-4 py-3 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition-colors duration-200 w-full font-medium" onclick="resetSettings()">
                        <i class="fas fa-undo mr-2"></i> 
                        Réinitialiser les paramètres
                            </button>
                            
                    <button class="px-4 py-3 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 transition-colors duration-200 w-full font-medium" onclick="exportSettings()">
                        <i class="fas fa-download mr-2"></i> 
                        Exporter la configuration
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- CSS pour les onglets -->
    <style>
        .param-tab {
    @apply px-3 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 transition-colors duration-200 rounded-t-lg flex items-center;
        }
        
        .param-tab.active {
    @apply text-blue-600 border-blue-600 bg-blue-50;
        }
        
        .param-content {
            @apply block;
        }
        
        .param-content.hidden {
            @apply hidden;
        }

.form-label.required::after {
    content: ' *';
    @apply text-red-500;
        }
    </style>

<?php
$content = ob_get_clean(); // Capturer le contenu

// JavaScript personnalisé pour cette page
$inline_js = '
// Variables globales
let currentTab = "general";

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initTabs();
});

function initTabs() {
        // Gestion des onglets
    document.querySelectorAll(".param-tab").forEach(tab => {
        tab.addEventListener("click", function() {
            const targetTab = this.getAttribute("data-tab");
            switchTab(targetTab);
        });
    });
}

function switchTab(targetTab) {
                // Masquer tous les contenus
    document.querySelectorAll(".param-content").forEach(content => {
        content.classList.add("hidden");
                });
                
                // Désactiver tous les onglets
    document.querySelectorAll(".param-tab").forEach(t => {
        t.classList.remove("active");
                });
                
                // Afficher le contenu cible
    const targetContent = document.getElementById(targetTab + "-tab");
    if (targetContent) {
        targetContent.classList.remove("hidden");
    }
    
    // Activer l\'onglet
    const activeTab = document.querySelector(`[data-tab="${targetTab}"]`);
    if (activeTab) {
        activeTab.classList.add("active");
    }
    
    currentTab = targetTab;
}

        // Fonctions pour les paramètres
function saveAllSettings() {
    showToast("Enregistrement de tous les paramètres...", "info");
    
    // Simulation de sauvegarde
    setTimeout(() => {
        showToast("Tous les paramètres ont été enregistrés avec succès !", "success");
    }, 1500);
}

function exportConfig() {
    showToast("Export de la configuration en cours...", "info");
    
    // Simulation d\'export
                setTimeout(() => {
        showToast("Configuration exportée avec succès !", "success");
        
        // Créer un lien de téléchargement simulé
        const blob = new Blob([JSON.stringify({
            version: "1.2.1",
            exportDate: new Date().toISOString(),
            settings: {
                general: {},
                security: {},
                storage: {},
                notifications: {},
                backup: {},
                advanced: {}
            }
        }, null, 2)], { type: "application/json" });
        
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "e-archive-config-" + new Date().toISOString().split("T")[0] + ".json";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 2000);
        }

        function cleanupStorage() {
    if (confirm("Êtes-vous sûr de vouloir nettoyer l\'espace de stockage ? Cette action supprimera les fichiers temporaires et les anciens logs.")) {
        showToast("Nettoyage de l\'espace de stockage en cours...", "info");
            setTimeout(() => {
            showToast("Nettoyage terminé ! 350 MB libérés.", "success");
        }, 3000);
    }
        }

        function createBackup() {
    showToast("Création de sauvegarde en cours...", "info");
    setTimeout(() => {
        showToast("Sauvegarde créée avec succès !", "success");
    }, 4000);
}

function downloadBackup(date) {
    showToast(`Téléchargement de la sauvegarde du ${date}...`, "info");
}

function cleanupBackups() {
    if (confirm("Supprimer les sauvegardes de plus de 90 jours ?")) {
        showToast("Nettoyage des anciennes sauvegardes...", "info");
            setTimeout(() => {
            showToast("5 anciennes sauvegardes supprimées", "success");
        }, 2000);
    }
        }

        function clearCache() {
    showToast("Vidage du cache en cours...", "info");
    setTimeout(() => {
        showToast("Cache système vidé avec succès !", "success");
    }, 1500);
        }

        function optimizeDatabase() {
    showToast("Optimisation de la base de données en cours...", "info");
    setTimeout(() => {
        showToast("Base de données optimisée ! Performance améliorée.", "success");
    }, 3000);
}

function reindexDocuments() {
    showToast("Réindexation des documents en cours...", "info");
    setTimeout(() => {
        showToast("Réindexation terminée ! 1,247 documents traités.", "success");
    }, 5000);
}

function resetSettings() {
    if (confirm("Êtes-vous sûr de vouloir réinitialiser tous les paramètres ? Cette action est irréversible.")) {
        showToast("Réinitialisation des paramètres...", "warning");
        setTimeout(() => {
            showToast("Paramètres réinitialisés ! Rechargement...", "success");
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            }, 2000);
            }
        }

        function exportSettings() {
    showToast("Export des paramètres en cours...", "info");
    setTimeout(() => {
        showToast("Paramètres exportés avec succès !", "success");
    }, 1500);
}

function downloadLogs() {
    showToast("Préparation du téléchargement des logs...", "info");
    setTimeout(() => {
        showToast("Logs d\'audit téléchargés !", "success");
    }, 2000);
}

function testNotifications() {
    showToast("Test des notifications...", "info");
    
    setTimeout(() => {
        showToast("Notification de test envoyée !", "success");
    }, 1000);
    
    // Tester notification push
    if ("Notification" in window) {
        if (Notification.permission === "granted") {
            new Notification("e-Archive SGITP", {
                body: "Test de notification push réussi !",
                icon: "assets/images/favicon.png"
            });
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    new Notification("e-Archive SGITP", {
                        body: "Notifications push activées !",
                        icon: "assets/images/favicon.png"
                    });
                }
            });
        }
    }
}
';

// Inclure le layout principal
include 'includes/layout.php';
?> 
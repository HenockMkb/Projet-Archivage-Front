<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Rapports et Statistiques';
$current_page = 'reports';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour les rapports
$documents = DataLoader::getDocuments();
$collections = DataLoader::getCollections();
$kpis = DataLoader::getKPIs();

// Calculer les statistiques avancées
$totalDocuments = count($documents);
$archivedDocuments = count(array_filter($documents, fn($doc) => $doc['status'] === 'archived'));
$pendingDocuments = count(array_filter($documents, fn($doc) => $doc['status'] === 'pending'));
$totalStorage = array_sum(array_column($documents, 'file_size'));

// Statistiques par collection
$collectionStats = [];
foreach ($collections as $collection) {
    $collectionDocs = array_filter($documents, fn($doc) => $doc['collection_id'] === $collection['id']);
    $collectionStats[] = [
        'name' => $collection['name'],
        'documents' => count($collectionDocs),
        'size' => array_sum(array_column($collectionDocs, 'file_size')),
        'growth' => rand(5, 25) // Simulation de croissance
    ];
}

// Statistiques par type de fichier
$fileTypeStats = [];
$fileTypes = array_count_values(array_column($documents, 'file_type'));
foreach ($fileTypes as $type => $count) {
    $docs = array_filter($documents, fn($doc) => $doc['file_type'] === $type);
    $fileTypeStats[] = [
        'type' => strtoupper($type),
        'count' => $count,
        'size' => array_sum(array_column($docs, 'file_size')),
        'percentage' => round(($count / $totalDocuments) * 100, 1)
    ];
}

// Activité des 12 derniers mois (simulation)
$monthlyActivity = [];
for ($i = 11; $i >= 0; $i--) {
    $date = date('Y-m', strtotime("-$i months"));
    $monthlyActivity[] = [
        'month' => $date,
        'documents' => rand(15, 45),
        'size' => rand(500000000, 2000000000), // 500MB à 2GB
        'users' => rand(8, 15)
    ];
}

// Top utilisateurs (simulation)
$topUsers = [
    ['name' => 'Benaja Bope', 'documents' => 45, 'size' => 1234567890, 'last_activity' => '2024-01-12 15:30:00'],
    ['name' => 'Marie Dubois', 'documents' => 38, 'size' => 987654321, 'last_activity' => '2024-01-12 14:20:00'],
    ['name' => 'Jean Malonga', 'documents' => 32, 'size' => 765432109, 'last_activity' => '2024-01-12 11:45:00'],
    ['name' => 'Sophie Kanza', 'documents' => 28, 'size' => 654321098, 'last_activity' => '2024-01-12 09:15:00'],
    ['name' => 'Pierre Durand', 'documents' => 24, 'size' => 543210987, 'last_activity' => '2024-01-11 16:30:00']
];

// Statistiques de validation
$validationStats = [
    'total_pending' => $pendingDocuments,
    'avg_validation_time' => '2.5h',
    'validation_rate' => round(($archivedDocuments / $totalDocuments) * 100, 1),
    'rejected_rate' => 3.2
];

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index.php'],
    ['label' => 'Rapports']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-teal-50 rounded-2xl border border-emerald-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-teal-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Analyse et reporting
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Rapports et <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">statistiques</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Analysez les performances et suivez l'évolution de votre système d'archivage avec des rapports détaillés et des visualisations interactives.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></div>
                        Données en temps réel
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Dernière mise à jour : <?= date('H:i') ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="exportReport()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-download mr-3 text-lg"></i>
                        <span>Exporter PDF</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-emerald-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition-all duration-300 transform hover:-translate-y-1" onclick="scheduleReport()">
                    <i class="fas fa-calendar-alt mr-3 text-emerald-600"></i>
                    <span>Planifier</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filtres de période -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-calendar mr-2 text-gray-400"></i>
                            Période :
                        </label>
                        <select class="form-select w-36" id="period-filter">
                            <option value="week">Cette semaine</option>
                            <option value="month" selected>Ce mois</option>
                            <option value="quarter">Ce trimestre</option>
                            <option value="year">Cette année</option>
                            <option value="custom">Personnalisée</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-chart-line mr-2 text-gray-400"></i>
                            Rapport :
                        </label>
                        <select class="form-select w-44" id="report-type">
                            <option value="overview">Vue d'ensemble</option>
                            <option value="collections">Par collections</option>
                            <option value="users">Par utilisateurs</option>
                            <option value="performance">Performance</option>
                            <option value="storage">Stockage</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-filter mr-2 text-gray-400"></i>
                            Collection :
                        </label>
                        <select class="form-select w-40" id="collection-filter">
                            <option value="">Toutes</option>
                            <?php foreach ($collections as $collection): ?>
                            <option value="<?= $collection['id'] ?>"><?= htmlspecialchars($collection['name']) ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                    <button class="group inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" onclick="refreshReports()">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        <span>Actualiser</span>
                        </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" onclick="saveView()">
                        <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Sauvegarder</span>
                        </button>
                </div>
            </div>
                            </div>
                        </div>

    <!-- KPI Cards avancées -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Documents traités -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-emerald-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-check text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors duration-300"><?= number_format($archivedDocuments) ?></div>
                        <div class="text-sm font-medium text-gray-600">Traités</div>
                    </div>
                </div>
                    <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Documents archivés</div>
                    <div class="flex items-center text-sm text-green-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+12%</span>
                    </div>
                </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-2 rounded-full" style="width: <?= round(($archivedDocuments / $totalDocuments) * 100) ?>%"></div>
                </div>
                            </div>
                        </div>

        <!-- Taux de validation -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-percentage text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300"><?= $validationStats['validation_rate'] ?>%</div>
                        <div class="text-sm font-medium text-gray-600">Validation</div>
                    </div>
                </div>
                    <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Taux de réussite</div>
                    <div class="flex items-center text-sm text-green-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+2.1%</span>
                            </div>
                        </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: <?= $validationStats['validation_rate'] ?>%"></div>
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
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300"><?= DataLoader::formatBytes($totalStorage) ?></div>
                        <div class="text-sm font-medium text-gray-600">Stockage</div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Espace total utilisé</div>
                    <div class="flex items-center text-sm text-green-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+8.3GB</span>
                    </div>
                </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: 68%"></div>
                    </div>
                </div>
            </div>

        <!-- Temps moyen de traitement -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-orange-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-stopwatch text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300"><?= $validationStats['avg_validation_time'] ?></div>
                        <div class="text-sm font-medium text-gray-600">Moyenne</div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Temps de validation</div>
                    <div class="flex items-center text-sm text-red-600 font-medium">
                        <i class="fas fa-arrow-down mr-1"></i>
                        <span>-0.3h</span>
                    </div>
                </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-2 rounded-full" style="width: 45%"></div>
                </div>
            </div>
                    </div>
                                            </div>

    <!-- Graphiques et analyses -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Évolution mensuelle -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-chart-line text-emerald-600"></i>
                                        </div>
                        Évolution mensuelle
                    </h3>
                    <div class="flex items-center space-x-2">
                        <button class="text-sm text-gray-500 hover:text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-100 transition-colors duration-200" onclick="toggleChartType('line')">Ligne</button>
                        <button class="text-sm text-gray-500 hover:text-gray-700 px-3 py-1 rounded-lg hover:bg-gray-100 transition-colors duration-200" onclick="toggleChartType('bar')">Barres</button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="h-80" id="monthly-chart">
                    <!-- Graphique simulé -->
                    <div class="h-full flex items-end justify-between space-x-2 pb-4">
                        <?php foreach (array_slice($monthlyActivity, -6) as $index => $month): ?>
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full bg-gradient-to-t from-emerald-500 to-emerald-400 rounded-t-lg relative group hover:from-emerald-600 hover:to-emerald-500 transition-colors duration-200" 
                                 style="height: <?= rand(40, 90) ?>%"
                                 title="<?= $month['documents'] ?> documents">
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <?= $month['documents'] ?>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 mt-2 text-center">
                                <?= date('M', strtotime($month['month'] . '-01')) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>Documents archivés par mois</span>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-emerald-500 rounded mr-2"></div>
                                    <span>2024</span>
                                        </div>
                                            </div>
                                        </div>
                    </div>
                </div>
            </div>
                </div>
                
        <!-- Répartition par type -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-pie text-blue-600"></i>
                    </div>
                    Répartition par type
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php foreach ($fileTypeStats as $index => $stat): ?>
                    <?php
                    $colors = ['emerald', 'blue', 'purple', 'orange', 'red', 'indigo'];
                    $color = $colors[$index % count($colors)];
                    ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-<?= $color ?>-500 to-<?= $color ?>-600 rounded-xl flex items-center justify-center text-white font-bold">
                                <?= substr($stat['type'], 0, 3) ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900"><?= $stat['type'] ?></div>
                                <div class="text-sm text-gray-600"><?= DataLoader::formatBytes($stat['size']) ?></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900"><?= $stat['count'] ?></div>
                            <div class="text-sm text-gray-600"><?= $stat['percentage'] ?>%</div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
                    </div>

    <!-- Tableaux détaillés -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top collections -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-folder text-purple-600"></i>
                    </div>
                    Collections les plus actives
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php foreach (array_slice($collectionStats, 0, 5) as $index => $collection): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                <?= $index + 1 ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors duration-200"><?= htmlspecialchars($collection['name']) ?></div>
                                <div class="text-sm text-gray-600"><?= DataLoader::formatBytes($collection['size']) ?></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900"><?= $collection['documents'] ?></div>
                            <div class="text-sm text-green-600 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <?= $collection['growth'] ?>%
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
                    </div>

        <!-- Top utilisateurs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-users text-orange-600"></i>
                    </div>
                    Utilisateurs les plus actifs
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php foreach ($topUsers as $index => $user): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold">
                                <?= substr($user['name'], 0, 1) . substr(explode(' ', $user['name'])[1], 0, 1) ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 group-hover:text-orange-700 transition-colors duration-200"><?= htmlspecialchars($user['name']) ?></div>
                                <div class="text-sm text-gray-600"><?= DataLoader::timeAgo($user['last_activity']) ?></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900"><?= $user['documents'] ?></div>
                            <div class="text-sm text-gray-600"><?= DataLoader::formatBytes($user['size']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance et métriques avancées -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-tachometer-alt text-indigo-600"></i>
                    </div>
                    Métriques de performance
                </h3>
                <button class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors duration-200" onclick="expandMetrics()">
                    <i class="fas fa-expand-alt mr-1"></i>
                    Développer
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Temps de réponse -->
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl border border-blue-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-white text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-blue-900 mb-2">1.2s</div>
                    <div class="text-sm font-medium text-blue-800">Temps de réponse moyen</div>
                    <div class="text-xs text-blue-600 mt-2">-0.3s vs mois dernier</div>
                </div>

                <!-- Disponibilité -->
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl border border-green-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-green-900 mb-2">99.8%</div>
                    <div class="text-sm font-medium text-green-800">Disponibilité système</div>
                    <div class="text-xs text-green-600 mt-2">+0.2% vs mois dernier</div>
                </div>

                <!-- Satisfaction -->
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl border border-purple-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-white text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-purple-900 mb-2">4.7/5</div>
                    <div class="text-sm font-medium text-purple-800">Satisfaction utilisateur</div>
                    <div class="text-xs text-purple-600 mt-2">+0.1 vs mois dernier</div>
                </div>
            </div>

            <!-- Métriques détaillées -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-600 mb-1">Recherches/jour</div>
                    <div class="text-2xl font-bold text-gray-900">1,247</div>
                    <div class="text-xs text-green-600">+8.3%</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-600 mb-1">Téléchargements/jour</div>
                    <div class="text-2xl font-bold text-gray-900">567</div>
                    <div class="text-xs text-green-600">+12.1%</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-600 mb-1">Erreurs système</div>
                    <div class="text-2xl font-bold text-gray-900">23</div>
                    <div class="text-xs text-red-600">+2</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-600 mb-1">Connexions actives</div>
                    <div class="text-2xl font-bold text-gray-900">34</div>
                    <div class="text-xs text-blue-600">En temps réel</div>
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
let currentReportType = "overview";
let currentPeriod = "month";

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initFilters();
            initCharts();
    updateReportData();
});

function initFilters() {
    const filters = ["period-filter", "report-type", "collection-filter"];
    filters.forEach(filterId => {
        const element = document.getElementById(filterId);
        if (element) {
            element.addEventListener("change", function() {
                currentPeriod = document.getElementById("period-filter").value;
                currentReportType = document.getElementById("report-type").value;
                updateReportData();
            });
        }
    });
}

function initCharts() {
    // Initialiser les graphiques si Chart.js est disponible
    if (typeof Chart !== "undefined") {
        createMonthlyChart();
        createTypeDistributionChart();
    }
    
    // Ajouter des interactions aux barres du graphique simulé
    document.querySelectorAll("#monthly-chart [title]").forEach(bar => {
        bar.addEventListener("click", function() {
            const month = this.getAttribute("title");
            showToast(`Détails pour ${month}`, "info");
        });
    });
}

function createMonthlyChart() {
    // Simulation de création de graphique Chart.js
    console.log("Création du graphique mensuel...");
}

function createTypeDistributionChart() {
    // Simulation de création de graphique de répartition
    console.log("Création du graphique de répartition...");
}

function updateReportData() {
    showToast(`Rapport mis à jour : ${currentReportType} pour ${currentPeriod}`, "info");
    
    // Simulation du rechargement des données
            setTimeout(() => {
        console.log("Données mises à jour", { type: currentReportType, period: currentPeriod });
    }, 1000);
}

function toggleChartType(type) {
    showToast(`Graphique changé en mode ${type}`, "info");
    // Logique pour changer le type de graphique
}

function exportReport() {
    showToast("Génération du rapport PDF en cours...", "info");
    
    // Simulation de génération PDF
    setTimeout(() => {
        showToast("Rapport PDF généré avec succès !", "success");
        // Ici, on déclencherait le téléchargement du PDF
    }, 3000);
        }

        function scheduleReport() {
    showToast("Planification de rapport - Fonctionnalité à venir", "info");
        }

        function refreshReports() {
    showToast("Actualisation des rapports...", "info");
    setTimeout(() => {
            window.location.reload();
    }, 1000);
}

function saveView() {
    const config = {
        reportType: currentReportType,
        period: currentPeriod,
        timestamp: new Date().toISOString()
    };
    
    localStorage.setItem("reportViewConfig", JSON.stringify(config));
    showToast("Configuration de vue sauvegardée !", "success");
}

function expandMetrics() {
    showToast("Mode métrics étendues - Fonctionnalité à venir", "info");
}

// Fonctions pour les interactions spécifiques
function viewCollectionDetails(collectionId) {
    window.location.href = `collection.php?id=${collectionId}`;
}

function viewUserActivity(userId) {
    showToast("Détails activité utilisateur - Fonctionnalité à venir", "info");
}

function drillDownData(category, value) {
    showToast(`Exploration détaillée : ${category} = ${value}`, "info");
}

// Auto-refresh des métriques en temps réel
setInterval(() => {
    // Simulation de mise à jour des métriques temps réel
    const activeConnections = document.querySelector("[data-metric=\"active-connections\"]");
    if (activeConnections) {
        const currentValue = parseInt(activeConnections.textContent);
        const newValue = currentValue + Math.floor(Math.random() * 5) - 2;
        activeConnections.textContent = Math.max(0, newValue);
    }
}, 5000);

// Restaurer la configuration sauvegardée
document.addEventListener("DOMContentLoaded", function() {
    const savedConfig = localStorage.getItem("reportViewConfig");
    if (savedConfig) {
        try {
            const config = JSON.parse(savedConfig);
            if (config.reportType) {
                const reportSelect = document.getElementById("report-type");
                if (reportSelect) reportSelect.value = config.reportType;
            }
            if (config.period) {
                const periodSelect = document.getElementById("period-filter");
                if (periodSelect) periodSelect.value = config.period;
            }
        } catch (e) {
            console.error("Erreur lors de la restauration de la configuration:", e);
        }
    }
});
';

// Inclure le layout
include 'includes/layout.php';
?> 
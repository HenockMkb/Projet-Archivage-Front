<?php
// Charger les données
require_once '../datas/data_loader.php';

// Configuration de la page
$page_title = 'Gestion des utilisateurs';
$current_page = 'admin/users';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour la gestion des utilisateurs
$users = DataLoader::getUsers();
$roles = DataLoader::getRoles();
$totalUsers = count($users);
$activeUsers = count(array_filter($users, fn($user) => $user['status'] === 'online' || $user['status'] === 'away'));
$adminUsers = count(array_filter($users, fn($user) => strpos(strtolower($user['role']), 'admin') !== false));
$archivistUsers = count(array_filter($users, fn($user) => strpos(strtolower($user['role']), 'archiviste') !== false));
$contributorUsers = count(array_filter($users, fn($user) => strpos(strtolower($user['role']), 'contributeur') !== false));

// Définir le chemin des assets par rapport au répertoire admin
$assets_path = '../';

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => '../index.php'],
    ['label' => 'Administration', 'url' => 'users.php'],
    ['label' => 'Utilisateurs']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50 rounded-2xl border border-indigo-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-indigo-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-purple-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-users-cog mr-2"></i>
                    Administration
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Gestion des <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">utilisateurs</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Administrez les comptes utilisateurs, gérez les rôles et permissions de la plateforme e-Archive.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full mr-2 animate-pulse"></div>
                        <?= $totalUsers ?> utilisateurs dans le système
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Dernière mise à jour : <?= date('H:i') ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="createUser()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-plus mr-3 text-lg"></i>
                        <span>Nouvel utilisateur</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-indigo-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 transform hover:-translate-y-1" onclick="importUsers()">
                    <i class="fas fa-upload mr-3 text-indigo-600"></i>
                    <span>Importer</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistiques des utilisateurs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Utilisateurs actifs -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300"><?= $activeUsers ?></div>
                        <div class="text-sm font-medium text-gray-600">Actifs</div>
                    </div>
                </div>
                    <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Utilisateurs actifs</div>
                    <div class="flex items-center text-sm text-green-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+3</span>
                    </div>
                </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-2 rounded-full" style="width: <?= round(($activeUsers / $totalUsers) * 100) ?>%"></div>
                </div>
            </div>
                        </div>

        <!-- Administrateurs -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-red-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-shield text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-red-600 transition-colors duration-300"><?= $adminUsers ?></div>
                        <div class="text-sm font-medium text-gray-600">Admins</div>
                    </div>
                </div>
                    <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Administrateurs</div>
                    <div class="flex items-center text-sm text-gray-600 font-medium">
                        <i class="fas fa-minus mr-1"></i>
                        <span>Stable</span>
                    </div>
                </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 h-2 rounded-full" style="width: <?= round(($adminUsers / $totalUsers) * 100) ?>%"></div>
                </div>
            </div>
                        </div>

        <!-- Archivistes -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-check text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300"><?= $archivistUsers ?></div>
                        <div class="text-sm font-medium text-gray-600">Archivistes</div>
                    </div>
                </div>
                    <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Rôle archiviste</div>
                    <div class="flex items-center text-sm text-green-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+1</span>
                    </div>
                </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" style="width: <?= round(($archivistUsers / $totalUsers) * 100) ?>%"></div>
                </div>
            </div>
                        </div>

        <!-- Contributeurs -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300"><?= $contributorUsers ?></div>
                        <div class="text-sm font-medium text-gray-600">Contributeurs</div>
                    </div>
                </div>
                    <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-700">Rôle contributeur</div>
                    <div class="flex items-center text-sm text-purple-600 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+2</span>
                    </div>
                        </div>
                <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: <?= round(($contributorUsers / $totalUsers) * 100) ?>%"></div>
                        </div>
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
                            <i class="fas fa-user-tag mr-2 text-gray-400"></i>
                            Rôle :
                        </label>
                        <select class="form-select w-40" id="role-filter">
                            <option value="">Tous les rôles</option>
                                <option value="admin">Administrateur</option>
                                <option value="archivist">Archiviste</option>
                                <option value="contributor">Contributeur</option>
                                <option value="reader">Lecteur</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-circle mr-2 text-gray-400"></i>
                            Statut :
                        </label>
                        <select class="form-select w-32" id="status-filter">
                                <option value="">Tous</option>
                            <option value="online">En ligne</option>
                            <option value="away">Absent</option>
                            <option value="offline">Hors ligne</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-building mr-2 text-gray-400"></i>
                            Service :
                        </label>
                        <select class="form-select w-40" id="department-filter">
                                <option value="">Tous les services</option>
                            <option value="DANTIC">DANTIC</option>
                            <option value="Infrastructure">Infrastructure</option>
                            <option value="Urbanisme">Urbanisme</option>
                            <option value="Direction Générale">Direction Générale</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                    <button class="group inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" onclick="refreshUsers()">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        <span>Actualiser</span>
                        </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" onclick="exportUsers()">
                        <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Exporter</span>
                        </button>
                    </div>
                </div>
            </div>
    </div>

    <!-- Tableau des utilisateurs moderne -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-users text-indigo-600"></i>
                    </div>
                    Liste des utilisateurs
                </h3>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-user mr-1"></i>
                    <?= $totalUsers ?> utilisateurs
                    </div>
                </div>
            </div>

                <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                        <th class="w-4 px-6 py-4">
                            <input type="checkbox" id="select-all-users" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="name">
                            <div class="flex items-center">
                                Utilisateur
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="last-login">
                            <div class="flex items-center">
                                Dernière connexion
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                                </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activité</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $index => $user): ?>
                    <?php
                    // Déterminer la couleur du statut
                    $statusColors = [
                        'online' => 'bg-green-100 text-green-800',
                        'away' => 'bg-yellow-100 text-yellow-800',
                        'offline' => 'bg-gray-100 text-gray-800'
                    ];
                    $statusColor = $statusColors[$user['status']] ?? 'bg-gray-100 text-gray-800';
                    
                    // Déterminer la couleur du rôle
                    $roleColors = [
                        'Administrateur' => 'bg-red-100 text-red-800',
                        'Archiviste Principal' => 'bg-blue-100 text-blue-800',
                        'Archiviste' => 'bg-green-100 text-green-800',
                        'Contributeur' => 'bg-purple-100 text-purple-800',
                        'Lecteur' => 'bg-gray-100 text-gray-800'
                    ];
                    $roleColor = $roleColors[$user['role']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="user-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" data-id="<?= $user['id'] ?>">
                                </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium text-sm"><?= htmlspecialchars($user['initials']) ?></span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white
                                        <?= $user['status'] === 'online' ? 'bg-green-500' : ($user['status'] === 'away' ? 'bg-yellow-500' : 'bg-gray-400') ?>">
                                    </div>
                                        </div>
                                        <div>
                                    <div class="font-semibold text-gray-900 hover:text-indigo-600 transition-colors duration-200 cursor-pointer" onclick="viewUser(<?= $user['id'] ?>)">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($user['email']) ?>
                                    </div>
                                        </div>
                                    </div>
                                </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $roleColor ?>">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                                </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900"><?= htmlspecialchars($user['department']) ?></span>
                                </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $statusColor ?>">
                                <i class="fas fa-circle mr-1 text-xs"></i>
                                <?= ucfirst($user['status']) ?>
                            </span>
                                </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?= date('d/m/Y H:i', strtotime($user['last_login'])) ?>
                            </div>
                            <div class="text-xs text-gray-500">
                                <?= DataLoader::timeAgo($user['last_login']) ?>
                            </div>
                                </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900"><?= $user['documents_count'] ?> docs</div>
                            <div class="text-xs text-gray-500"><?= $user['validated_count'] ?> validés</div>
                                </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200" onclick="viewUser(<?= $user['id'] ?>)" title="Voir le profil">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                <button class="p-2 text-purple-600 hover:text-purple-700 hover:bg-purple-100 rounded-lg transition-all duration-200" onclick="editUser(<?= $user['id'] ?>)" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                <button class="p-2 text-yellow-600 hover:text-yellow-700 hover:bg-yellow-100 rounded-lg transition-all duration-200" onclick="resetPassword(<?= $user['id'] ?>)" title="Réinitialiser mot de passe">
                                            <i class="fas fa-key"></i>
                                        </button>
                                <?php if ($user['id'] !== 1): // Ne pas permettre la suppression de l'admin principal ?>
                                <button class="p-2 text-red-600 hover:text-red-700 hover:bg-red-100 rounded-lg transition-all duration-200" onclick="deleteUser(<?= $user['id'] ?>)" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                <?php endif; ?>
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
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?= min(10, $totalUsers) ?></span> sur <span class="font-medium"><?= $totalUsers ?></span> utilisateurs
                        </div>
                        <div class="flex items-center space-x-2">
                    <button class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-white rounded-lg transition-colors duration-200 disabled:opacity-50" disabled>
                        <i class="fas fa-chevron-left mr-1"></i>
                        Précédent
                            </button>
                    <div class="flex items-center space-x-1">
                        <button class="px-3 py-2 text-sm bg-indigo-600 text-white rounded-lg shadow-sm">1</button>
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
    </div>

<!-- Modal de création/édition d'utilisateur moderne -->
<div id="user-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center" id="user-modal-title">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-plus text-indigo-600"></i>
                    </div>
                    Nouvel utilisateur
                </h3>
                <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
                        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <form id="user-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                        <label for="user-name" class="form-label required">Nom complet</label>
                        <input type="text" id="user-name" name="name" required class="form-input" placeholder="Jean Dupont">
                    </div>
                    
                    <div class="form-group">
                        <label for="user-email" class="form-label required">Adresse email</label>
                        <input type="email" id="user-email" name="email" required class="form-input" placeholder="jean.dupont@sgitp.cd">
                    </div>
                    </div>
                    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                        <label for="user-role" class="form-label required">Rôle</label>
                            <select id="user-role" name="role" required class="form-select">
                                <option value="">Sélectionner un rôle</option>
                            <?php foreach ($roles as $role): ?>
                            <option value="<?= htmlspecialchars($role['slug']) ?>"><?= htmlspecialchars($role['name']) ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                        <label for="user-department" class="form-label">Service</label>
                        <select id="user-department" name="department" class="form-select">
                                <option value="">Sélectionner un service</option>
                            <option value="DANTIC">DANTIC</option>
                            <option value="Infrastructure">Infrastructure</option>
                            <option value="Urbanisme">Urbanisme</option>
                            <option value="Direction Générale">Direction Générale</option>
                            </select>
                        </div>
                    </div>
                    
                        <div class="form-group">
                    <label for="user-permissions" class="form-label">Permissions</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="read" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                            <span class="text-sm text-gray-700">Lecture</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="write" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                            <span class="text-sm text-gray-700">Écriture</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="validate" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                            <span class="text-sm text-gray-700">Validation</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="manage" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                            <span class="text-sm text-gray-700">Gestion</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="admin" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                            <span class="text-sm text-gray-700">Administration</span>
                        </label>
                        </div>
                    </div>
                    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="user-password" class="form-label required">Mot de passe</label>
                        <input type="password" id="user-password" name="password" required class="form-input" placeholder="••••••••">
                        <p class="text-sm text-gray-500 mt-1">Minimum 8 caractères avec majuscules, minuscules et chiffres</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="user-confirm-password" class="form-label required">Confirmer le mot de passe</label>
                        <input type="password" id="user-confirm-password" name="confirmPassword" required class="form-input" placeholder="••••••••">
                    </div>
                    </div>
                </form>
            </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3">
            <button onclick="closeUserModal()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Annuler
            </button>
            <button onclick="saveUser()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i>
                Enregistrer
            </button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capturer le contenu

// JavaScript personnalisé pour cette page
$inline_js = '
// Variables globales
let currentUserId = null;
let isEditMode = false;

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initFilters();
    initTableSorting();
    initBulkActions();
});

function initFilters() {
    const filters = ["role-filter", "status-filter", "department-filter"];
    filters.forEach(filterId => {
        const element = document.getElementById(filterId);
        if (element) {
            element.addEventListener("change", applyFilters);
        }
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
    const selectAllCheckbox = document.getElementById("select-all-users");
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener("change", function() {
            const checkboxes = document.querySelectorAll(".user-checkbox");
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsVisibility();
        });
    }

    // Sélection individuelle
    document.querySelectorAll(".user-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", updateBulkActionsVisibility);
    });
}

function updateBulkActionsVisibility() {
    const checkedBoxes = document.querySelectorAll(".user-checkbox:checked");
    // Logique pour afficher/masquer les actions groupées
}

function applyFilters() {
    const roleFilter = document.getElementById("role-filter").value;
    const statusFilter = document.getElementById("status-filter").value;
    const departmentFilter = document.getElementById("department-filter").value;
    
    // Simulation du filtrage
    console.log("Filtres appliqués:", { roleFilter, statusFilter, departmentFilter });
    showToast("Filtres appliqués", "info");
}

function sortTable(column) {
    // Simulation du tri
    console.log("Tri par:", column);
    showToast("Tableau trié par " + column, "info");
}

        function createUser() {
    isEditMode = false;
    currentUserId = null;
    document.getElementById("user-modal-title").innerHTML = `
        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-user-plus text-indigo-600"></i>
        </div>
        Nouvel utilisateur
    `;
    document.getElementById("user-form").reset();
    document.getElementById("user-modal").classList.remove("hidden");
        }

        function editUser(id) {
    isEditMode = true;
    currentUserId = id;
    document.getElementById("user-modal-title").innerHTML = `
        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-user-edit text-purple-600"></i>
        </div>
        Modifier l\'utilisateur
    `;
    
    // Ici, on chargerait les données de l\'utilisateur
    // Pour la démo, on simule le remplissage du formulaire
    document.getElementById("user-name").value = "Utilisateur " + id;
    document.getElementById("user-email").value = "user" + id + "@sgitp.cd";
    
    document.getElementById("user-modal").classList.remove("hidden");
        }

        function viewUser(id) {
    showToast("Affichage du profil utilisateur " + id, "info");
    // En production, rediriger vers la page de profil
        }

        function saveUser() {
    const form = document.getElementById("user-form");
            const formData = new FormData(form);
            
    // Validation basique
    if (!formData.get("name") || !formData.get("email") || !formData.get("role")) {
        showToast("Veuillez remplir tous les champs obligatoires", "warning");
                return;
            }
            
    if (!isEditMode && formData.get("password") !== formData.get("confirmPassword")) {
        showToast("Les mots de passe ne correspondent pas", "warning");
                return;
            }
            
    const action = isEditMode ? "modifié" : "créé";
    showToast(`Utilisateur ${action} avec succès !`, "success");
    closeUserModal();
            
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }

function closeUserModal() {
    document.getElementById("user-modal").classList.add("hidden");
    currentUserId = null;
    isEditMode = false;
        }

        function deleteUser(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.")) {
        showToast("Utilisateur supprimé avec succès !", "success");
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        }

        function resetPassword(id) {
    if (confirm("Êtes-vous sûr de vouloir réinitialiser le mot de passe de cet utilisateur ?")) {
        showToast("Mot de passe réinitialisé ! Un email a été envoyé à l\'utilisateur.", "success");
            }
        }

        function importUsers() {
    showToast("Import d\'utilisateurs - Fonctionnalité à venir", "info");
        }

        function exportUsers() {
    const checkedBoxes = document.querySelectorAll(".user-checkbox:checked");
            if (checkedBoxes.length === 0) {
        showToast("Aucun utilisateur sélectionné pour l\'export", "info");
                return;
            }
            
    showToast(`Export de ${checkedBoxes.length} utilisateur(s) en cours...`, "success");
        }

        function refreshUsers() {
    showToast("Actualisation en cours...", "info");
    setTimeout(() => {
            window.location.reload();
    }, 1000);
}

// Fermer le modal en cliquant en dehors
document.getElementById("user-modal").addEventListener("click", function(e) {
    if (e.target === this) {
        closeUserModal();
    }
});

// Gestion des permissions par rôle
document.getElementById("user-role").addEventListener("change", function() {
    const role = this.value;
    const permissions = document.querySelectorAll("input[name=\"permissions[]\"]");
    
    // Réinitialiser toutes les permissions
    permissions.forEach(perm => perm.checked = false);
    
    // Définir les permissions par défaut selon le rôle
    const rolePermissions = {
        "admin": ["read", "write", "validate", "manage", "admin"],
        "archivist_lead": ["read", "write", "validate", "manage"],
        "archivist": ["read", "write", "validate"],
        "contributor": ["read", "write"],
        "reader": ["read"]
    };
    
    if (rolePermissions[role]) {
        rolePermissions[role].forEach(permission => {
            const checkbox = document.querySelector(`input[value="${permission}"]`);
            if (checkbox) checkbox.checked = true;
            });
    }
});
';

// Inclure le layout principal
include '../includes/layout.php'; 
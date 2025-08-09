<?php
// Charger les données
require_once '../datas/data_loader.php';

// Configuration de la page
$page_title = 'Gestion des rôles et permissions';
$current_page = 'admin/roles';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour la gestion des rôles
$roles = DataLoader::getRoles();
$permissions = DataLoader::getPermissions();
$totalRoles = count($roles);
$systemRoles = count(array_filter($roles, fn($role) => $role['is_system'] === true));
$customRoles = count(array_filter($roles, fn($role) => $role['is_system'] === false));
$usersPerRole = DataLoader::getUserCountByRole();

// Définir le chemin des assets par rapport au répertoire admin
$assets_path = '../';

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => '../index.php'],
    ['label' => 'Administration', 'url' => 'roles.php'],
    ['label' => 'Rôles et permissions']
];

// Inclure le layout principal
ob_start(); // Commencer la capture du contenu
?>

<!-- Contenu principal de la page -->
<div class="space-y-8">
    <!-- Hero Section moderne -->
    <div class="relative overflow-hidden bg-gradient-to-br from-purple-50 via-white to-blue-50 rounded-2xl border border-purple-100 p-8 lg:p-12">
        <!-- Fond décoratif -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-purple-100/50 to-transparent rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-blue-100/50 to-transparent rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <div class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-user-shield mr-2"></i>
                    Administration
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Rôles et <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">permissions</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Gérez les rôles, permissions et droits d'accès des utilisateurs de la plateforme e-Archive.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></div>
                        <?= $totalRoles ?> rôles configurés
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Dernière mise à jour : <?= date('H:i') ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="createRole()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-plus mr-3 text-lg"></i>
                        <span>Nouveau rôle</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-purple-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 transform hover:-translate-y-1" onclick="managePermissions()">
                    <i class="fas fa-cogs mr-3 text-purple-600"></i>
                    <span>Gérer permissions</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistiques des rôles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total rôles -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-shield text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300"><?= $totalRoles ?></div>
                        <div class="text-sm font-medium text-gray-600">Total</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Rôles configurés</div>
            </div>
                        </div>

        <!-- Rôles système -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300"><?= $systemRoles ?></div>
                        <div class="text-sm font-medium text-gray-600">Système</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Rôles par défaut</div>
                        </div>
                        </div>

        <!-- Rôles personnalisés -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-cog text-white text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300"><?= $customRoles ?></div>
                        <div class="text-sm font-medium text-gray-600">Personnalisés</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Rôles sur mesure</div>
            </div>
                                </div>

        <!-- Permissions actives -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-orange-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-key text-white text-xl"></i>
                                </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300"><?= count($permissions) ?></div>
                        <div class="text-sm font-medium text-gray-600">Permissions</div>
                    </div>
                                </div>
                <div class="text-sm font-medium text-gray-700">Droits disponibles</div>
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
                            Type :
                        </label>
                        <select class="form-select w-36" id="type-filter">
                            <option value="">Tous les types</option>
                            <option value="system">Système</option>
                            <option value="custom">Personnalisé</option>
                        </select>
                </div>

                            <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-shield-alt mr-2 text-gray-400"></i>
                            Niveau :
                        </label>
                        <select class="form-select w-32" id="level-filter">
                            <option value="">Tous</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="user">Utilisateur</option>
                        </select>
                    </div>
                    
                                <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-users mr-2 text-gray-400"></i>
                            Statut :
                        </label>
                        <select class="form-select w-32" id="status-filter">
                            <option value="">Tous</option>
                            <option value="active">Actif</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </div>
                </div>

                            <div class="flex items-center space-x-3">
                    <button class="group inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" onclick="refreshRoles()">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        <span>Actualiser</span>
                                </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" onclick="exportRoles()">
                        <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Exporter</span>
                                </button>
                </div>
                            </div>
                        </div>
                    </div>
                    
    <!-- Tableau des rôles moderne -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-shield text-purple-600"></i>
                                </div>
                    Liste des rôles
                </h3>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    <?= $totalRoles ?> rôles
                                </div>
                            </div>
                        </div>
                        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="w-4 px-6 py-4">
                            <input type="checkbox" id="select-all-roles" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700" data-sort="name">
                            <div class="flex items-center">
                                Rôle
                                <i class="fas fa-sort ml-1"></i>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Niveau</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateurs</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($roles as $role): ?>
                    <?php
                    // Déterminer la couleur du type
                    $typeColors = [
                        'system' => 'bg-blue-100 text-blue-800',
                        'custom' => 'bg-green-100 text-green-800'
                    ];
                    $typeColor = $typeColors[$role['type']] ?? 'bg-gray-100 text-gray-800';
                    
                    // Déterminer la couleur du niveau
                    $levelColors = [
                        'admin' => 'bg-red-100 text-red-800',
                        'manager' => 'bg-orange-100 text-orange-800',
                        'user' => 'bg-purple-100 text-purple-800'
                    ];
                    $levelColor = $levelColors[$role['level']] ?? 'bg-gray-100 text-gray-800';
                    
                    // Compter les utilisateurs
                    $userCount = $usersPerRole[$role['id']] ?? 0;
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="role-checkbox rounded border-gray-300 text-purple-600 focus:ring-purple-500" data-id="<?= $role['id'] ?>" <?= $role['is_system'] ? 'disabled' : '' ?>>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <div class="w-10 h-10 bg-gradient-to-br <?= $role['is_system'] ? 'from-blue-500 to-blue-600' : 'from-purple-500 to-purple-600' ?> rounded-xl flex items-center justify-center">
                                        <i class="<?= htmlspecialchars($role['icon']) ?> text-white text-sm"></i>
                            </div>
                                    <?php if ($role['is_system']): ?>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-blue-600 rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-white text-xs"></i>
                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 hover:text-purple-600 transition-colors duration-200 cursor-pointer" onclick="viewRole(<?= $role['id'] ?>)">
                                        <?= htmlspecialchars($role['name']) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($role['description'] ?? 'Aucune description') ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $typeColor ?>">
                                <?= $role['is_system'] ? 'Système' : 'Personnalisé' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $levelColor ?>">
                                <?= ucfirst(htmlspecialchars($role['level'])) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-900"><?= $userCount ?></span>
                                <span class="text-xs text-gray-500">utilisateur<?= $userCount > 1 ? 's' : '' ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col space-y-1">
                                <?php 
                                $rolePermissions = explode(',', $role['permissions']);
                                $displayCount = min(3, count($rolePermissions));
                                for ($i = 0; $i < $displayCount; $i++): 
                                    $permission = trim($rolePermissions[$i]);
                                ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 w-fit">
                                    <?= htmlspecialchars($permission) ?>
                                </span>
                                <?php endfor; ?>
                                <?php if (count($rolePermissions) > 3): ?>
                                <span class="text-xs text-gray-500 italic">+<?= count($rolePermissions) - 3 ?> autres...</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $role['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <i class="fas fa-circle mr-1 text-xs"></i>
                                <?= $role['is_active'] ? 'Actif' : 'Inactif' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-100 rounded-lg transition-all duration-200" onclick="viewRole(<?= $role['id'] ?>)" title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-2 text-purple-600 hover:text-purple-700 hover:bg-purple-100 rounded-lg transition-all duration-200" onclick="editRole(<?= $role['id'] ?>)" title="Modifier" <?= $role['is_system'] ? 'disabled' : '' ?>>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 text-green-600 hover:text-green-700 hover:bg-green-100 rounded-lg transition-all duration-200" onclick="duplicateRole(<?= $role['id'] ?>)" title="Dupliquer">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <?php if (!$role['is_system']): ?>
                                <button class="p-2 text-red-600 hover:text-red-700 hover:bg-red-100 rounded-lg transition-all duration-200" onclick="deleteRole(<?= $role['id'] ?>)" title="Supprimer">
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
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium"><?= min(10, $totalRoles) ?></span> sur <span class="font-medium"><?= $totalRoles ?></span> rôles
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
            </div>

<!-- Modal de création/édition de rôle moderne -->
<div id="role-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center" id="role-modal-title">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-shield text-purple-600"></i>
                </div>
                    Nouveau rôle
                </h3>
                <button onclick="closeRoleModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <form id="role-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                        <label for="role-name" class="form-label required">Nom du rôle</label>
                        <input type="text" id="role-name" name="name" required class="form-input" placeholder="Manager Projets">
                    </div>
                    
                    <div class="form-group">
                        <label for="role-level" class="form-label required">Niveau d'autorisation</label>
                        <select id="role-level" name="level" required class="form-select">
                            <option value="">Sélectionner un niveau</option>
                            <option value="admin">Administrateur</option>
                            <option value="manager">Manager</option>
                            <option value="user">Utilisateur</option>
                        </select>
                                </div>
                            </div>
                            
                <div class="form-group">
                    <label for="role-description" class="form-label">Description</label>
                    <textarea id="role-description" name="description" rows="3" class="form-input" placeholder="Décrivez le rôle et ses responsabilités..."></textarea>
                            </div>
                            
                <div class="form-group">
                    <label for="role-icon" class="form-label">Icône</label>
                    <div class="grid grid-cols-6 gap-3 mt-2">
                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                            <input type="radio" name="icon" value="fas fa-user" class="sr-only">
                            <i class="fas fa-user text-lg text-gray-600"></i>
                        </label>
                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                            <input type="radio" name="icon" value="fas fa-user-tie" class="sr-only">
                            <i class="fas fa-user-tie text-lg text-gray-600"></i>
                        </label>
                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                            <input type="radio" name="icon" value="fas fa-user-cog" class="sr-only">
                            <i class="fas fa-user-cog text-lg text-gray-600"></i>
                        </label>
                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                            <input type="radio" name="icon" value="fas fa-crown" class="sr-only">
                            <i class="fas fa-crown text-lg text-gray-600"></i>
                                    </label>
                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                            <input type="radio" name="icon" value="fas fa-star" class="sr-only">
                            <i class="fas fa-star text-lg text-gray-600"></i>
                                    </label>
                        <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                            <input type="radio" name="icon" value="fas fa-shield-alt" class="sr-only">
                            <i class="fas fa-shield-alt text-lg text-gray-600"></i>
                                    </label>
                                </div>
                            </div>
                            
                <div class="form-group">
                    <label class="form-label">Permissions</label>
                    <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                        <?php
                        $permissionCategories = [
                            'Documents' => ['read_documents', 'create_documents', 'edit_documents', 'delete_documents', 'validate_documents'],
                            'Collections' => ['read_collections', 'create_collections', 'edit_collections', 'delete_collections'],
                            'Utilisateurs' => ['read_users', 'create_users', 'edit_users', 'delete_users'],
                            'Administration' => ['manage_roles', 'manage_settings', 'view_reports', 'manage_system']
                        ];
                        ?>
                        <?php foreach ($permissionCategories as $category => $perms): ?>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-folder mr-2 text-gray-500"></i>
                                <?= $category ?>
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <?php foreach ($perms as $perm): ?>
                                    <label class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="<?= $perm ?>" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-2">
                                    <span class="text-sm text-gray-700"><?= ucfirst(str_replace('_', ' ', $perm)) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </form>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3">
            <button onclick="closeRoleModal()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Annuler
            </button>
            <button onclick="saveRole()" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                <i class="fas fa-save mr-2"></i>
                Enregistrer
            </button>
        </div>
    </div>
</div>

<!-- Modal de gestion des permissions -->
<div id="permissions-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-cogs text-orange-600"></i>
                    </div>
                    Gestion des permissions
                </h3>
                <button onclick="closePermissionsModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <div class="bg-gradient-to-br from-orange-100 to-orange-200/50 rounded-2xl p-8 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-cogs text-white text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Matrice des permissions</h4>
                <p class="text-gray-600 mb-6">Interface avancée de gestion des droits par rôle</p>
                <div class="text-sm text-gray-500">
                    Fonctionnalité en cours de développement
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3">
            <button onclick="closePermissionsModal()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Fermer
            </button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capturer le contenu

// JavaScript personnalisé pour cette page
$inline_js = '
// Variables globales
let currentRoleId = null;
let isEditMode = false;

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initFilters();
    initTableSorting();
    initBulkActions();
    initIconSelection();
});

function initFilters() {
    const filters = ["type-filter", "level-filter", "status-filter"];
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
    const selectAllCheckbox = document.getElementById("select-all-roles");
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener("change", function() {
            const checkboxes = document.querySelectorAll(".role-checkbox:not(:disabled)");
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsVisibility();
        });
    }

    // Sélection individuelle
    document.querySelectorAll(".role-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", updateBulkActionsVisibility);
    });
}

function initIconSelection() {
    document.querySelectorAll("input[name=\"icon\"]").forEach(radio => {
        radio.addEventListener("change", function() {
            // Retirer la sélection précédente
            document.querySelectorAll("input[name=\"icon\"]").forEach(r => {
                r.closest("label").classList.remove("bg-purple-100", "border-purple-500");
            });
            
            // Ajouter la sélection actuelle
            if (this.checked) {
                this.closest("label").classList.add("bg-purple-100", "border-purple-500");
            }
        });
    });
}

function updateBulkActionsVisibility() {
    const checkedBoxes = document.querySelectorAll(".role-checkbox:checked");
    // Logique pour afficher/masquer les actions groupées
}

function applyFilters() {
    const typeFilter = document.getElementById("type-filter").value;
    const levelFilter = document.getElementById("level-filter").value;
    const statusFilter = document.getElementById("status-filter").value;
    
    // Simulation du filtrage
    console.log("Filtres appliqués:", { typeFilter, levelFilter, statusFilter });
    showToast("Filtres appliqués", "info");
}

function sortTable(column) {
    // Simulation du tri
    console.log("Tri par:", column);
    showToast("Tableau trié par " + column, "info");
}

function createRole() {
    isEditMode = false;
    currentRoleId = null;
    document.getElementById("role-modal-title").innerHTML = `
        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-user-shield text-purple-600"></i>
        </div>
        Nouveau rôle
    `;
    document.getElementById("role-form").reset();
    
    // Réinitialiser la sélection des icônes
    document.querySelectorAll("input[name=\"icon\"]").forEach(radio => {
        radio.closest("label").classList.remove("bg-purple-100", "border-purple-500");
    });
    
    document.getElementById("role-modal").classList.remove("hidden");
}

function editRole(id) {
    isEditMode = true;
    currentRoleId = id;
    document.getElementById("role-modal-title").innerHTML = `
        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-edit text-orange-600"></i>
        </div>
        Modifier le rôle
    `;
    
    // Ici, on chargerait les données du rôle
    // Pour la démo, on simule le remplissage du formulaire
    document.getElementById("role-name").value = "Rôle " + id;
    document.getElementById("role-level").value = "manager";
    document.getElementById("role-description").value = "Description du rôle " + id;
    
    document.getElementById("role-modal").classList.remove("hidden");
}

function viewRole(id) {
    showToast("Affichage des détails du rôle " + id, "info");
    // En production, ouvrir un modal de détails ou rediriger
}

function duplicateRole(id) {
    if (confirm("Êtes-vous sûr de vouloir dupliquer ce rôle ?")) {
        showToast("Rôle dupliqué avec succès !", "success");
        setTimeout(() => {
            window.location.reload();
        }, 1500);
            }
        }

        function saveRole() {
    const form = document.getElementById("role-form");
            const formData = new FormData(form);
            
    // Validation basique
    if (!formData.get("name") || !formData.get("level")) {
        showToast("Veuillez remplir tous les champs obligatoires", "warning");
                return;
            }
            
    const action = isEditMode ? "modifié" : "créé";
    showToast(`Rôle ${action} avec succès !`, "success");
    closeRoleModal();
            
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }

function closeRoleModal() {
    document.getElementById("role-modal").classList.add("hidden");
    currentRoleId = null;
    isEditMode = false;
}

function deleteRole(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce rôle ? Cette action est irréversible.")) {
        showToast("Rôle supprimé avec succès !", "success");
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    }
}

function managePermissions() {
    document.getElementById("permissions-modal").classList.remove("hidden");
}

function closePermissionsModal() {
    document.getElementById("permissions-modal").classList.add("hidden");
        }

        function exportRoles() {
    const checkedBoxes = document.querySelectorAll(".role-checkbox:checked");
    if (checkedBoxes.length === 0) {
        showToast("Aucun rôle sélectionné pour l\'export", "info");
        return;
    }
    
    showToast(`Export de ${checkedBoxes.length} rôle(s) en cours...`, "success");
}

function refreshRoles() {
    showToast("Actualisation en cours...", "info");
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

// Fermer les modaux en cliquant en dehors
document.getElementById("role-modal").addEventListener("click", function(e) {
    if (e.target === this) {
        closeRoleModal();
    }
});

document.getElementById("permissions-modal").addEventListener("click", function(e) {
    if (e.target === this) {
        closePermissionsModal();
    }
});

// Gestion des permissions par niveau
document.getElementById("role-level").addEventListener("change", function() {
    const level = this.value;
    const permissions = document.querySelectorAll("input[name=\"permissions[]\"]");
    
    // Réinitialiser toutes les permissions
    permissions.forEach(perm => perm.checked = false);
    
    // Définir les permissions par défaut selon le niveau
    const levelPermissions = {
        "admin": ["read_documents", "create_documents", "edit_documents", "delete_documents", "validate_documents", 
                 "read_collections", "create_collections", "edit_collections", "delete_collections",
                 "read_users", "create_users", "edit_users", "delete_users",
                 "manage_roles", "manage_settings", "view_reports", "manage_system"],
        "manager": ["read_documents", "create_documents", "edit_documents", "validate_documents",
                   "read_collections", "create_collections", "edit_collections",
                   "read_users", "view_reports"],
        "user": ["read_documents", "create_documents", "read_collections"]
    };
    
    if (levelPermissions[level]) {
        levelPermissions[level].forEach(permission => {
            const checkbox = document.querySelector(`input[value="${permission}"]`);
            if (checkbox) checkbox.checked = true;
        });
    }
});
';

// Inclure le layout principal
include '../includes/layout.php';
?> 
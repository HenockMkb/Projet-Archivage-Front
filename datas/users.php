<?php
/**
 * Données des utilisateurs de l'application e-Archive
 * Simuler une base de données d'utilisateurs
 */

return [
    'users' => [
        [
            'id' => 1,
            'name' => 'Benaja Bope',
            'email' => 'benaja.bope@sgitp.cd',
            'role' => 'Archiviste Principal',
            'role_id' => 2,
            'department' => 'DANTIC',
            'initials' => 'BB',
            'avatar' => null,
            'status' => 'online',
            'permissions' => ['read', 'write', 'validate', 'manage'],
            'last_login' => '2024-01-12 14:30:00',
            'created_at' => '2023-06-15 09:00:00',
            'documents_count' => 156,
            'validated_count' => 89
        ],
        [
            'id' => 2,
            'name' => 'Marie Dubois',
            'email' => 'marie.dubois@sgitp.cd',
            'role' => 'Archiviste',
            'role_id' => 3,
            'department' => 'Infrastructure',
            'initials' => 'MD',
            'avatar' => null,
            'status' => 'online',
            'permissions' => ['read', 'write', 'validate'],
            'last_login' => '2024-01-12 11:15:00',
            'created_at' => '2023-08-22 10:30:00',
            'documents_count' => 234,
            'validated_count' => 145
        ],
        [
            'id' => 3,
            'name' => 'Pierre Durand',
            'email' => 'pierre.durand@sgitp.cd',
            'role' => 'Contributeur',
            'role_id' => 4,
            'department' => 'Urbanisme',
            'initials' => 'PD',
            'avatar' => null,
            'status' => 'away',
            'permissions' => ['read', 'write'],
            'last_login' => '2024-01-12 09:45:00',
            'created_at' => '2023-09-10 14:20:00',
            'documents_count' => 67,
            'validated_count' => 0
        ],
        [
            'id' => 4,
            'name' => 'Sophie Martin',
            'email' => 'sophie.martin@sgitp.cd',
            'role' => 'Administrateur',
            'role_id' => 1,
            'department' => 'DANTIC',
            'initials' => 'SM',
            'avatar' => null,
            'status' => 'online',
            'permissions' => ['read', 'write', 'validate', 'manage', 'admin'],
            'last_login' => '2024-01-12 13:20:00',
            'created_at' => '2023-05-01 08:00:00',
            'documents_count' => 45,
            'validated_count' => 320
        ],
        [
            'id' => 5,
            'name' => 'Jean Kasongo',
            'email' => 'jean.kasongo@sgitp.cd',
            'role' => 'Lecteur',
            'role_id' => 5,
            'department' => 'Direction Générale',
            'initials' => 'JK',
            'avatar' => null,
            'status' => 'offline',
            'permissions' => ['read'],
            'last_login' => '2024-01-11 16:30:00',
            'created_at' => '2023-11-05 11:15:00',
            'documents_count' => 0,
            'validated_count' => 0
        ]
    ],
    
    'roles' => [
        [
            'id' => 1,
            'name' => 'Administrateur',
            'slug' => 'admin',
            'description' => 'Accès complet au système avec droits de gestion',
            'permissions' => 'read_documents,create_documents,edit_documents,delete_documents,validate_documents,read_collections,create_collections,edit_collections,delete_collections,read_users,create_users,edit_users,delete_users,manage_roles,manage_settings,view_reports,manage_system',
            'color' => 'red',
            'icon' => 'fas fa-crown',
            'level' => 'admin',
            'type' => 'system',
            'is_system' => true,
            'is_active' => true,
            'users_count' => 1
        ],
        [
            'id' => 2,
            'name' => 'Archiviste Principal',
            'slug' => 'archivist_lead',
            'description' => 'Validation et gestion des documents, supervision',
            'permissions' => 'read_documents,create_documents,edit_documents,validate_documents,read_collections,create_collections,edit_collections,read_users,view_reports',
            'color' => 'blue',
            'icon' => 'fas fa-user-shield',
            'level' => 'manager',
            'type' => 'system',
            'is_system' => true,
            'is_active' => true,
            'users_count' => 1
        ],
        [
            'id' => 3,
            'name' => 'Archiviste',
            'slug' => 'archivist',
            'description' => 'Archivage et validation des documents',
            'permissions' => 'read_documents,create_documents,edit_documents,validate_documents,read_collections',
            'color' => 'green',
            'icon' => 'fas fa-user-check',
            'level' => 'user',
            'type' => 'system',
            'is_system' => true,
            'is_active' => true,
            'users_count' => 1
        ],
        [
            'id' => 4,
            'name' => 'Contributeur',
            'slug' => 'contributor',
            'description' => 'Ajout et modification de documents',
            'permissions' => 'read_documents,create_documents,edit_documents,read_collections',
            'color' => 'yellow',
            'icon' => 'fas fa-user-plus',
            'level' => 'user',
            'type' => 'system',
            'is_system' => true,
            'is_active' => true,
            'users_count' => 1
        ],
        [
            'id' => 5,
            'name' => 'Lecteur',
            'slug' => 'reader',
            'description' => 'Consultation des documents uniquement',
            'permissions' => 'read_documents,read_collections',
            'color' => 'gray',
            'icon' => 'fas fa-user',
            'level' => 'user',
            'type' => 'system',
            'is_system' => true,
            'is_active' => true,
            'users_count' => 1
        ],
        [
            'id' => 6,
            'name' => 'Manager Projets',
            'slug' => 'project_manager',
            'description' => 'Gestion des projets et supervision équipe',
            'permissions' => 'read_documents,create_documents,edit_documents,validate_documents,read_collections,create_collections,edit_collections,read_users',
            'color' => 'purple',
            'icon' => 'fas fa-user-tie',
            'level' => 'manager',
            'type' => 'custom',
            'is_system' => false,
            'is_active' => true,
            'users_count' => 0
        ]
    ],
    
    'permissions' => [
        [
            'id' => 1,
            'name' => 'read_documents',
            'label' => 'Lire les documents',
            'description' => 'Permet de consulter les documents archivés',
            'category' => 'Documents'
        ],
        [
            'id' => 2,
            'name' => 'create_documents',
            'label' => 'Créer des documents',
            'description' => 'Permet d\'ajouter de nouveaux documents',
            'category' => 'Documents'
        ],
        [
            'id' => 3,
            'name' => 'edit_documents',
            'label' => 'Modifier les documents',
            'description' => 'Permet de modifier les métadonnées des documents',
            'category' => 'Documents'
        ],
        [
            'id' => 4,
            'name' => 'delete_documents',
            'label' => 'Supprimer les documents',
            'description' => 'Permet de supprimer définitivement des documents',
            'category' => 'Documents'
        ],
        [
            'id' => 5,
            'name' => 'validate_documents',
            'label' => 'Valider les documents',
            'description' => 'Permet de valider les documents en attente',
            'category' => 'Documents'
        ],
        [
            'id' => 6,
            'name' => 'read_collections',
            'label' => 'Lire les collections',
            'description' => 'Permet de consulter les collections',
            'category' => 'Collections'
        ],
        [
            'id' => 7,
            'name' => 'create_collections',
            'label' => 'Créer des collections',
            'description' => 'Permet de créer de nouvelles collections',
            'category' => 'Collections'
        ],
        [
            'id' => 8,
            'name' => 'edit_collections',
            'label' => 'Modifier les collections',
            'description' => 'Permet de modifier les collections existantes',
            'category' => 'Collections'
        ],
        [
            'id' => 9,
            'name' => 'delete_collections',
            'label' => 'Supprimer les collections',
            'description' => 'Permet de supprimer des collections',
            'category' => 'Collections'
        ],
        [
            'id' => 10,
            'name' => 'read_users',
            'label' => 'Lire les utilisateurs',
            'description' => 'Permet de consulter la liste des utilisateurs',
            'category' => 'Utilisateurs'
        ],
        [
            'id' => 11,
            'name' => 'create_users',
            'label' => 'Créer des utilisateurs',
            'description' => 'Permet de créer de nouveaux comptes utilisateurs',
            'category' => 'Utilisateurs'
        ],
        [
            'id' => 12,
            'name' => 'edit_users',
            'label' => 'Modifier les utilisateurs',
            'description' => 'Permet de modifier les informations des utilisateurs',
            'category' => 'Utilisateurs'
        ],
        [
            'id' => 13,
            'name' => 'delete_users',
            'label' => 'Supprimer les utilisateurs',
            'description' => 'Permet de supprimer des comptes utilisateurs',
            'category' => 'Utilisateurs'
        ],
        [
            'id' => 14,
            'name' => 'manage_roles',
            'label' => 'Gérer les rôles',
            'description' => 'Permet de créer et modifier les rôles',
            'category' => 'Administration'
        ],
        [
            'id' => 15,
            'name' => 'manage_settings',
            'label' => 'Gérer les paramètres',
            'description' => 'Permet de modifier les paramètres système',
            'category' => 'Administration'
        ],
        [
            'id' => 16,
            'name' => 'view_reports',
            'label' => 'Voir les rapports',
            'description' => 'Permet de consulter les rapports et statistiques',
            'category' => 'Administration'
        ],
        [
            'id' => 17,
            'name' => 'manage_system',
            'label' => 'Administrer le système',
            'description' => 'Accès complet à l\'administration système',
            'category' => 'Administration'
        ]
    ]
]; 
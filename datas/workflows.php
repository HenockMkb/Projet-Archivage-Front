<?php
/**
 * Données des workflows et tâches
 * Système de gestion d'archivage électronique - SGITP
 */

// Définition des colonnes Kanban
$kanbanColumns = [
    'todo' => ['title' => 'À faire', 'color' => 'blue', 'icon' => 'fa-clipboard-list'],
    'in_progress' => ['title' => 'En cours', 'color' => 'yellow', 'icon' => 'fa-clock'],
    'review' => ['title' => 'En révision', 'color' => 'purple', 'icon' => 'fa-eye'],
    'done' => ['title' => 'Terminé', 'color' => 'green', 'icon' => 'fa-check-circle']
];

// Catégories de workflows
$workflowCategories = [
    'validation' => ['label' => 'Validation', 'color' => 'blue', 'icon' => 'fa-check-circle'],
    'indexation' => ['label' => 'Indexation', 'color' => 'green', 'icon' => 'fa-tags'],
    'classification' => ['label' => 'Classification', 'color' => 'purple', 'icon' => 'fa-folder'],
    'audit' => ['label' => 'Audit', 'color' => 'orange', 'icon' => 'fa-search'],
    'archivage' => ['label' => 'Archivage', 'color' => 'indigo', 'icon' => 'fa-archive'],
    'migration' => ['label' => 'Migration', 'color' => 'yellow', 'icon' => 'fa-exchange-alt'],
    'administration' => ['label' => 'Administration', 'color' => 'gray', 'icon' => 'fa-cog'],
    'controle' => ['label' => 'Contrôle', 'color' => 'red', 'icon' => 'fa-shield-alt']
];

// Niveaux de priorité
$priorityLevels = [
    'high' => ['label' => 'Haute', 'color' => 'red', 'icon' => 'fa-arrow-up', 'emoji' => '🔴'],
    'medium' => ['label' => 'Moyenne', 'color' => 'yellow', 'icon' => 'fa-minus', 'emoji' => '🟡'],
    'low' => ['label' => 'Basse', 'color' => 'green', 'icon' => 'fa-arrow-down', 'emoji' => '🟢']
];

// Données des workflows
$workflows = [
    // À faire
    [
        'id' => 1,
        'title' => 'Validation rapport annuel 2023',
        'description' => 'Vérifier et valider le rapport annuel avant archivage définitif',
        'status' => 'todo',
        'priority' => 'high',
        'assignee' => 'Benaja Bope',
        'assignee_initials' => 'BB',
        'assignee_id' => 1,
        'document_id' => 1,
        'document_title' => 'Rapport annuel SGITP 2023',
        'due_date' => '2024-01-20',
        'created_at' => '2024-01-10 09:00:00',
        'category' => 'validation',
        'estimated_time' => '2h',
        'tags' => ['rapport', 'annuel', 'validation'],
        'dependencies' => [],
        'checklist' => [
            'Vérifier les données financières',
            'Contrôler la conformité réglementaire',
            'Valider les statistiques',
            'Approuver pour archivage'
        ]
    ],
    [
        'id' => 2,
        'title' => 'Classification documents urbanisme',
        'description' => 'Classer les nouveaux documents d\'urbanisme dans les bonnes collections',
        'status' => 'todo',
        'priority' => 'medium',
        'assignee' => 'Marie Durand',
        'assignee_initials' => 'MD',
        'assignee_id' => 2,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-01-22',
        'created_at' => '2024-01-12 14:30:00',
        'category' => 'classification',
        'estimated_time' => '1h30',
        'tags' => ['urbanisme', 'classification', 'documents'],
        'dependencies' => [],
        'checklist' => [
            'Analyser le type de document',
            'Déterminer la collection appropriée',
            'Ajouter les métadonnées',
            'Valider la classification'
        ]
    ],
    [
        'id' => 3,
        'title' => 'Révision politique de conservation',
        'description' => 'Mettre à jour les règles de conservation pour les contrats',
        'status' => 'todo',
        'priority' => 'low',
        'assignee' => 'Jean Martin',
        'assignee_initials' => 'JM',
        'assignee_id' => 3,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-01-25',
        'created_at' => '2024-01-08 16:15:00',
        'category' => 'administration',
        'estimated_time' => '3h',
        'tags' => ['politique', 'conservation', 'contrats'],
        'dependencies' => [],
        'checklist' => [
            'Examiner les règles actuelles',
            'Consulter la réglementation',
            'Proposer les modifications',
            'Documenter les changements'
        ]
    ],
    
    // En cours
    [
        'id' => 4,
        'title' => 'Indexation contrats infrastructure',
        'description' => 'Ajouter les métadonnées manquantes aux contrats d\'infrastructure',
        'status' => 'in_progress',
        'priority' => 'high',
        'assignee' => 'Benaja Bope',
        'assignee_initials' => 'BB',
        'assignee_id' => 1,
        'document_id' => 2,
        'document_title' => 'Contrat construction Route A1',
        'due_date' => '2024-01-18',
        'created_at' => '2024-01-05 11:20:00',
        'category' => 'indexation',
        'estimated_time' => '1h',
        'progress' => 65,
        'started_at' => '2024-01-15 08:30:00',
        'tags' => ['contrats', 'infrastructure', 'métadonnées'],
        'dependencies' => [],
        'checklist' => [
            'Identifier les métadonnées manquantes',
            'Rechercher les informations',
            'Saisir les métadonnées',
            'Vérifier la cohérence'
        ],
        'time_spent' => '1h15',
        'notes' => 'Métadonnées de base complétées, reste les informations techniques.'
    ],
    [
        'id' => 5,
        'title' => 'Audit qualité archives 2023',
        'description' => 'Effectuer l\'audit qualité trimestriel des archives numériques',
        'status' => 'in_progress',
        'priority' => 'medium',
        'assignee' => 'Sophie Laurent',
        'assignee_initials' => 'SL',
        'assignee_id' => 4,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-01-24',
        'created_at' => '2024-01-03 10:00:00',
        'category' => 'audit',
        'estimated_time' => '4h',
        'progress' => 40,
        'started_at' => '2024-01-14 13:00:00',
        'tags' => ['audit', 'qualité', 'archives'],
        'dependencies' => [],
        'checklist' => [
            'Vérifier l\'intégrité des fichiers',
            'Contrôler les métadonnées',
            'Tester l\'accessibilité',
            'Générer le rapport d\'audit'
        ],
        'time_spent' => '1h45',
        'notes' => 'Audit de l\'intégrité en cours, quelques fichiers corrompus détectés.'
    ],
    
    // En révision
    [
        'id' => 6,
        'title' => 'Validation plan urbanisme secteur 7',
        'description' => 'Révision finale du plan d\'urbanisme avant publication',
        'status' => 'review',
        'priority' => 'high',
        'assignee' => 'Pierre Dubois',
        'assignee_initials' => 'PD',
        'assignee_id' => 5,
        'document_id' => 3,
        'document_title' => 'Plan urbanisme secteur 7',
        'due_date' => '2024-01-19',
        'created_at' => '2024-01-02 09:45:00',
        'category' => 'validation',
        'estimated_time' => '2h30',
        'progress' => 90,
        'started_at' => '2024-01-12 10:15:00',
        'reviewer' => 'Benaja Bope',
        'reviewer_id' => 1,
        'tags' => ['urbanisme', 'plan', 'validation'],
        'dependencies' => [],
        'checklist' => [
            'Vérifier la conformité technique',
            'Contrôler les normes',
            'Valider les calculs',
            'Approuver pour publication'
        ],
        'time_spent' => '2h15',
        'notes' => 'Révision technique terminée, en attente de validation finale.'
    ],
    [
        'id' => 7,
        'title' => 'Contrôle conformité factures',
        'description' => 'Vérifier la conformité des factures avant archivage',
        'status' => 'review',
        'priority' => 'medium',
        'assignee' => 'Marie Durand',
        'assignee_initials' => 'MD',
        'assignee_id' => 2,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-01-21',
        'created_at' => '2024-01-06 15:20:00',
        'category' => 'controle',
        'estimated_time' => '1h15',
        'progress' => 85,
        'started_at' => '2024-01-13 09:00:00',
        'reviewer' => 'Sophie Laurent',
        'reviewer_id' => 4,
        'tags' => ['factures', 'conformité', 'contrôle'],
        'dependencies' => [],
        'checklist' => [
            'Vérifier les mentions obligatoires',
            'Contrôler les montants',
            'Valider les signatures',
            'Approuver l\'archivage'
        ],
        'time_spent' => '1h05',
        'notes' => 'Contrôle formel terminé, quelques corrections mineures à apporter.'
    ],
    
    // Terminé
    [
        'id' => 8,
        'title' => 'Archivage procès-verbaux Q4 2023',
        'description' => 'Finaliser l\'archivage des PV du dernier trimestre 2023',
        'status' => 'done',
        'priority' => 'medium',
        'assignee' => 'Jean Martin',
        'assignee_initials' => 'JM',
        'assignee_id' => 3,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-01-15',
        'created_at' => '2023-12-20 14:00:00',
        'category' => 'archivage',
        'estimated_time' => '2h',
        'progress' => 100,
        'started_at' => '2024-01-10 08:00:00',
        'completed_at' => '2024-01-14 16:30:00',
        'tags' => ['pv', 'procès-verbaux', 'archivage'],
        'dependencies' => [],
        'checklist' => [
            'Collecter tous les PV Q4',
            'Vérifier la complétude',
            'Numériser les documents',
            'Archiver dans le système'
        ],
        'time_spent' => '1h50',
        'notes' => 'Archivage terminé avec succès, 24 PV traités.'
    ],
    [
        'id' => 9,
        'title' => 'Migration base données legacy',
        'description' => 'Migrer les anciens documents vers le nouveau système',
        'status' => 'done',
        'priority' => 'high',
        'assignee' => 'Benaja Bope',
        'assignee_initials' => 'BB',
        'assignee_id' => 1,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-01-12',
        'created_at' => '2023-12-15 09:30:00',
        'category' => 'migration',
        'estimated_time' => '6h',
        'progress' => 100,
        'started_at' => '2024-01-08 08:00:00',
        'completed_at' => '2024-01-11 17:45:00',
        'tags' => ['migration', 'legacy', 'base-données'],
        'dependencies' => [],
        'checklist' => [
            'Analyser la structure legacy',
            'Préparer les scripts de migration',
            'Effectuer les tests',
            'Migrer les données production'
        ],
        'time_spent' => '5h30',
        'notes' => 'Migration réussie, 1,247 documents migrés sans erreur.'
    ],
    
    // Tâches supplémentaires pour enrichir les données
    [
        'id' => 10,
        'title' => 'Mise à jour politique sécurité',
        'description' => 'Réviser et mettre à jour la politique de sécurité des archives',
        'status' => 'todo',
        'priority' => 'medium',
        'assignee' => 'Sophie Laurent',
        'assignee_initials' => 'SL',
        'assignee_id' => 4,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-01-30',
        'created_at' => '2024-01-13 11:00:00',
        'category' => 'administration',
        'estimated_time' => '4h',
        'tags' => ['sécurité', 'politique', 'archives'],
        'dependencies' => [9], // Dépend de la migration
        'checklist' => [
            'Analyser les risques actuels',
            'Réviser les procédures',
            'Mettre à jour la documentation',
            'Former les utilisateurs'
        ]
    ],
    [
        'id' => 11,
        'title' => 'Formation équipe nouveaux outils',
        'description' => 'Organiser la formation sur les nouveaux outils d\'archivage',
        'status' => 'in_progress',
        'priority' => 'low',
        'assignee' => 'Pierre Dubois',
        'assignee_initials' => 'PD',
        'assignee_id' => 5,
        'document_id' => null,
        'document_title' => null,
        'due_date' => '2024-02-05',
        'created_at' => '2024-01-11 09:30:00',
        'category' => 'administration',
        'estimated_time' => '8h',
        'progress' => 25,
        'started_at' => '2024-01-16 14:00:00',
        'tags' => ['formation', 'équipe', 'outils'],
        'dependencies' => [9], // Dépend de la migration
        'checklist' => [
            'Préparer le matériel de formation',
            'Planifier les sessions',
            'Former les formateurs',
            'Organiser les sessions'
        ],
        'time_spent' => '2h00',
        'notes' => 'Préparation du matériel en cours, planning établi.'
    ]
];

// Modèles de workflows (templates)
$workflowTemplates = [
    'document_validation' => [
        'title' => 'Validation de document',
        'category' => 'validation',
        'estimated_time' => '1h',
        'checklist' => [
            'Vérifier le format du document',
            'Contrôler les métadonnées',
            'Valider le contenu',
            'Approuver pour archivage'
        ]
    ],
    'audit_quality' => [
        'title' => 'Audit qualité',
        'category' => 'audit',
        'estimated_time' => '3h',
        'checklist' => [
            'Vérifier l\'intégrité des fichiers',
            'Contrôler les métadonnées',
            'Tester l\'accessibilité',
            'Générer le rapport'
        ]
    ],
    'document_classification' => [
        'title' => 'Classification de document',
        'category' => 'classification',
        'estimated_time' => '30min',
        'checklist' => [
            'Analyser le type de document',
            'Déterminer la collection',
            'Ajouter les métadonnées',
            'Valider la classification'
        ]
    ]
];

return [
    'workflows' => $workflows,
    'kanban_columns' => $kanbanColumns,
    'categories' => $workflowCategories,
    'priorities' => $priorityLevels,
    'templates' => $workflowTemplates
]; 
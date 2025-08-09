<?php
/**
 * Données des notifications de l'application e-Archive
 * Simuler un système de notifications en temps réel
 */

return [
    'notifications' => [
        [
            'id' => 1,
            'title' => 'Nouveau document ajouté',
            'message' => 'Rapport mensuel par Marie Dubois',
            'description' => 'Un nouveau rapport mensuel a été ajouté et nécessite votre validation.',
            'type' => 'document_added',
            'priority' => 'medium',
            'category' => 'document',
            'icon' => 'fa-file-alt',
            'color' => 'blue',
            'user_id' => 1, // destinataire
            'from_user_id' => 2, // expéditeur
            'from_user_name' => 'Marie Dubois',
            'document_id' => 1,
            'document_title' => 'Rapport mensuel janvier 2024',
            'read' => false,
            'read_at' => null,
            'created_at' => '2024-01-12 14:55:00',
            'action_url' => 'document.php?id=1',
            'action_label' => 'Voir le document'
        ],
        [
            'id' => 2,
            'title' => 'Document en attente de validation',
            'message' => 'Contrat nécessite validation',
            'description' => 'Le contrat de construction du pont de Kinshasa attend votre validation depuis 4 heures.',
            'type' => 'validation_pending',
            'priority' => 'high',
            'category' => 'validation',
            'icon' => 'fa-clock',
            'color' => 'yellow',
            'user_id' => 1,
            'from_user_id' => 3,
            'from_user_name' => 'Pierre Durand',
            'document_id' => 2,
            'document_title' => 'Contrat de construction - Pont de Kinshasa',
            'read' => false,
            'read_at' => null,
            'created_at' => '2024-01-12 12:45:00',
            'action_url' => 'validate.php?id=2',
            'action_label' => 'Valider maintenant'
        ],
        [
            'id' => 3,
            'title' => 'Sauvegarde terminée',
            'message' => 'Sauvegarde automatique réussie',
            'description' => 'La sauvegarde automatique quotidienne s\'est terminée avec succès.',
            'type' => 'system_backup',
            'priority' => 'low',
            'category' => 'system',
            'icon' => 'fa-check-circle',
            'color' => 'green',
            'user_id' => 1,
            'from_user_id' => null,
            'from_user_name' => 'Système',
            'document_id' => null,
            'document_title' => null,
            'read' => true,
            'read_at' => '2024-01-12 13:20:00',
            'created_at' => '2024-01-12 03:00:00',
            'action_url' => 'reports.php?section=backup',
            'action_label' => 'Voir rapport'
        ],
        [
            'id' => 4,
            'title' => 'Quota de stockage',
            'message' => 'Espace de stockage à 85%',
            'description' => 'L\'espace de stockage atteint 85% de sa capacité. Envisagez un nettoyage ou une extension.',
            'type' => 'storage_warning',
            'priority' => 'medium',
            'category' => 'system',
            'icon' => 'fa-hdd',
            'color' => 'orange',
            'user_id' => 4, // admin
            'from_user_id' => null,
            'from_user_name' => 'Système',
            'document_id' => null,
            'document_title' => null,
            'read' => false,
            'read_at' => null,
            'created_at' => '2024-01-12 10:30:00',
            'action_url' => 'admin/storage.php',
            'action_label' => 'Gérer le stockage'
        ],
        [
            'id' => 5,
            'title' => 'Nouveau commentaire',
            'message' => 'Commentaire sur le plan d\'urbanisme',
            'description' => 'Sophie Martin a ajouté un commentaire sur le plan d\'urbanisme Zone Nord.',
            'type' => 'comment_added',
            'priority' => 'low',
            'category' => 'collaboration',
            'icon' => 'fa-comment',
            'color' => 'purple',
            'user_id' => 3,
            'from_user_id' => 4,
            'from_user_name' => 'Sophie Martin',
            'document_id' => 3,
            'document_title' => 'Plan d\'urbanisme - Zone Nord',
            'read' => false,
            'read_at' => null,
            'created_at' => '2024-01-12 09:15:00',
            'action_url' => 'document.php?id=3#comments',
            'action_label' => 'Voir commentaire'
        ]
    ],
    
    'alerts' => [
        [
            'id' => 1,
            'title' => 'Documents en attente de validation',
            'message' => '23 documents nécessitent votre attention dans la file d\'attente.',
            'type' => 'validation_queue',
            'priority' => 'high',
            'category' => 'workflow',
            'icon' => 'fa-exclamation-triangle',
            'color' => 'yellow',
            'count' => 23,
            'dismissible' => false,
            'persistent' => true,
            'created_at' => '2024-01-12 08:00:00',
            'action_url' => 'inbox.php',
            'action_label' => 'Voir la file d\'attente'
        ],
        [
            'id' => 2,
            'title' => 'Maintenance prévue',
            'message' => 'Une maintenance est prévue le 15 janvier 2024 de 22h00 à 02h00.',
            'type' => 'maintenance_scheduled',
            'priority' => 'medium',
            'category' => 'system',
            'icon' => 'fa-info-circle',
            'color' => 'blue',
            'count' => null,
            'dismissible' => true,
            'persistent' => true,
            'scheduled_date' => '2024-01-15 22:00:00',
            'estimated_duration' => '4 heures',
            'created_at' => '2024-01-10 09:00:00',
            'action_url' => null,
            'action_label' => null
        ],
        [
            'id' => 3,
            'title' => 'Sauvegarde réussie',
            'message' => 'La sauvegarde automatique de la base de données s\'est terminée avec succès.',
            'type' => 'backup_success',
            'priority' => 'low',
            'category' => 'system',
            'icon' => 'fa-check-circle',
            'color' => 'green',
            'count' => null,
            'dismissible' => true,
            'persistent' => false,
            'backup_size' => '2.3 GB',
            'backup_duration' => '15 minutes',
            'created_at' => '2024-01-12 03:15:00',
            'action_url' => 'admin/backups.php',
            'action_label' => 'Voir les sauvegardes'
        ]
    ],
    
    'activity_feed' => [
        [
            'id' => 1,
            'type' => 'document_uploaded',
            'user_id' => 2,
            'user_name' => 'Marie Dubois',
            'action' => 'a ajouté',
            'target' => 'Rapport mensuel janvier 2024',
            'target_type' => 'document',
            'target_id' => 1,
            'icon' => 'fa-upload',
            'color' => 'blue',
            'created_at' => '2024-01-12 14:30:00'
        ],
        [
            'id' => 2,
            'type' => 'document_validated',
            'user_id' => 1,
            'user_name' => 'Benaja Bope',
            'action' => 'a validé',
            'target' => 'Plan d\'urbanisme - Zone Nord',
            'target_type' => 'document',
            'target_id' => 3,
            'icon' => 'fa-check',
            'color' => 'green',
            'created_at' => '2024-01-12 09:10:00'
        ],
        [
            'id' => 3,
            'type' => 'collection_created',
            'user_id' => 4,
            'user_name' => 'Sophie Martin',
            'action' => 'a créé la collection',
            'target' => 'Projets 2024',
            'target_type' => 'collection',
            'target_id' => 6,
            'icon' => 'fa-folder-plus',
            'color' => 'purple',
            'created_at' => '2024-01-12 08:45:00'
        ],
        [
            'id' => 4,
            'type' => 'user_login',
            'user_id' => 3,
            'user_name' => 'Pierre Durand',
            'action' => 's\'est connecté',
            'target' => null,
            'target_type' => null,
            'target_id' => null,
            'icon' => 'fa-sign-in-alt',
            'color' => 'gray',
            'created_at' => '2024-01-12 08:15:00'
        ]
    ],
    
    'notification_types' => [
        'document_added' => [
            'label' => 'Document ajouté',
            'description' => 'Un nouveau document a été ajouté',
            'icon' => 'fa-file-plus',
            'color' => 'blue'
        ],
        'validation_pending' => [
            'label' => 'Validation en attente',
            'description' => 'Un document attend votre validation',
            'icon' => 'fa-clock',
            'color' => 'yellow'
        ],
        'document_validated' => [
            'label' => 'Document validé',
            'description' => 'Un document a été validé',
            'icon' => 'fa-check-circle',
            'color' => 'green'
        ],
        'comment_added' => [
            'label' => 'Nouveau commentaire',
            'description' => 'Un commentaire a été ajouté',
            'icon' => 'fa-comment',
            'color' => 'purple'
        ],
        'system_backup' => [
            'label' => 'Sauvegarde système',
            'description' => 'Information sur la sauvegarde',
            'icon' => 'fa-database',
            'color' => 'gray'
        ],
        'storage_warning' => [
            'label' => 'Alerte stockage',
            'description' => 'Avertissement sur l\'espace de stockage',
            'icon' => 'fa-exclamation-triangle',
            'color' => 'orange'
        ]
    ],
    
    'priority_levels' => [
        'low' => ['label' => 'Faible', 'color' => 'gray'],
        'medium' => ['label' => 'Moyenne', 'color' => 'blue'],
        'high' => ['label' => 'Élevée', 'color' => 'orange'],
        'critical' => ['label' => 'Critique', 'color' => 'red']
    ]
]; 
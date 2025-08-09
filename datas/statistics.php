<?php
/**
 * Données des statistiques de l'application e-Archive
 * Simuler des métriques et KPI pour le tableau de bord
 */

return [
    'kpi' => [
        'documents' => [
            'total' => 1250,
            'validated' => 1089,
            'pending' => 23,
            'draft' => 138,
            'archived_today' => 5,
            'archived_this_week' => 34,
            'archived_this_month' => 156,
            'growth_percentage' => 12.5,
            'growth_direction' => 'up'
        ],
        'users' => [
            'total' => 45,
            'active' => 38,
            'online' => 12,
            'inactive' => 7,
            'new_this_month' => 3,
            'growth_percentage' => 8.2,
            'growth_direction' => 'up'
        ],
        'storage' => [
            'used_gb' => 2.3,
            'total_gb' => 5.0,
            'used_percentage' => 46,
            'available_gb' => 2.7,
            'growth_mb_per_day' => 125,
            'estimated_full_date' => '2024-08-15'
        ],
        'activity' => [
            'uploads_today' => 12,
            'uploads_this_week' => 78,
            'validations_today' => 8,
            'validations_this_week' => 45,
            'downloads_today' => 156,
            'downloads_this_week' => 892
        ]
    ],
    
    'charts' => [
        'documents_per_month' => [
            'labels' => ['Août', 'Sept', 'Oct', 'Nov', 'Déc', 'Jan'],
            'data' => [89, 112, 134, 156, 178, 195],
            'type' => 'line',
            'color' => 'blue'
        ],
        'documents_by_category' => [
            'labels' => ['Rapports', 'Contrats', 'Plans', 'Procédures', 'Budgets', 'Autres'],
            'data' => [285, 198, 156, 123, 89, 67],
            'type' => 'pie',
            'colors' => ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#6B7280']
        ],
        'validation_timeline' => [
            'labels' => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            'validated' => [12, 15, 8, 18, 22, 5, 3],
            'pending' => [3, 5, 7, 4, 2, 8, 12],
            'type' => 'bar',
            'colors' => ['#10B981', '#F59E0B']
        ],
        'storage_evolution' => [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
            'data' => [1.2, 1.4, 1.7, 1.9, 2.1, 2.3],
            'type' => 'area',
            'color' => 'purple'
        ]
    ],
    
    'recent_activity' => [
        [
            'id' => 1,
            'type' => 'document_upload',
            'title' => 'Rapport mensuel janvier 2024',
            'user' => 'Marie Dubois',
            'department' => 'Infrastructure',
            'time' => '2024-01-12 14:30:00',
            'time_ago' => 'Il y a 2 heures',
            'status' => 'pending',
            'file_type' => 'PDF',
            'file_size' => '2.4 MB'
        ],
        [
            'id' => 2,
            'type' => 'document_validation',
            'title' => 'Plan d\'urbanisme - Zone Nord',
            'user' => 'Benaja Bope',
            'department' => 'DANTIC',
            'time' => '2024-01-12 09:10:00',
            'time_ago' => 'Il y a 7 heures',
            'status' => 'validated',
            'file_type' => 'DWG',
            'file_size' => '15.2 MB'
        ],
        [
            'id' => 3,
            'type' => 'collection_creation',
            'title' => 'Projets 2024',
            'user' => 'Sophie Martin',
            'department' => 'DANTIC',
            'time' => '2024-01-12 08:45:00',
            'time_ago' => 'Il y a 8 heures',
            'status' => 'created',
            'file_type' => null,
            'file_size' => null
        ]
    ],
    
    'top_collections' => [
        [
            'id' => 1,
            'name' => 'Infrastructure',
            'documents_count' => 150,
            'views_count' => 2456,
            'size_mb' => 234.5,
            'last_updated' => '2024-01-12 14:15:00',
            'growth_percentage' => 15.3,
            'icon' => 'fa-road',
            'color' => 'blue'
        ],
        [
            'id' => 2,
            'name' => 'Urbanisme',
            'documents_count' => 89,
            'views_count' => 1879,
            'size_mb' => 156.8,
            'last_updated' => '2024-01-12 09:10:00',
            'growth_percentage' => 8.7,
            'icon' => 'fa-city',
            'color' => 'green'
        ],
        [
            'id' => 3,
            'name' => 'Administratif',
            'documents_count' => 234,
            'views_count' => 1234,
            'size_mb' => 89.2,
            'last_updated' => '2024-01-11 16:30:00',
            'growth_percentage' => -2.1,
            'icon' => 'fa-file-alt',
            'color' => 'purple'
        ]
    ],
    
    'user_activity' => [
        [
            'user_id' => 1,
            'name' => 'Benaja Bope',
            'role' => 'Archiviste Principal',
            'documents_uploaded' => 12,
            'documents_validated' => 89,
            'last_activity' => '2024-01-12 14:30:00',
            'status' => 'online',
            'productivity_score' => 95
        ],
        [
            'user_id' => 2,
            'name' => 'Marie Dubois',
            'role' => 'Archiviste',
            'documents_uploaded' => 45,
            'documents_validated' => 67,
            'last_activity' => '2024-01-12 13:15:00',
            'status' => 'online',
            'productivity_score' => 88
        ],
        [
            'user_id' => 3,
            'name' => 'Pierre Durand',
            'role' => 'Contributeur',
            'documents_uploaded' => 23,
            'documents_validated' => 0,
            'last_activity' => '2024-01-12 10:45:00',
            'status' => 'away',
            'productivity_score' => 72
        ]
    ],
    
    'system_health' => [
        'server_status' => 'online',
        'database_status' => 'healthy',
        'storage_status' => 'warning', // en raison du 85% d'utilisation
        'backup_status' => 'success',
        'last_backup' => '2024-01-12 03:00:00',
        'next_backup' => '2024-01-13 03:00:00',
        'uptime_days' => 127,
        'response_time_ms' => 245,
        'error_rate_percentage' => 0.12
    ],
    
    'monthly_trends' => [
        'january_2024' => [
            'documents_added' => 195,
            'documents_validated' => 178,
            'new_users' => 3,
            'storage_used_gb' => 0.4,
            'page_views' => 12567,
            'search_queries' => 3456
        ],
        'december_2023' => [
            'documents_added' => 178,
            'documents_validated' => 165,
            'new_users' => 2,
            'storage_used_gb' => 0.35,
            'page_views' => 11234,
            'search_queries' => 2987
        ],
        'november_2023' => [
            'documents_added' => 156,
            'documents_validated' => 142,
            'new_users' => 4,
            'storage_used_gb' => 0.31,
            'page_views' => 10567,
            'search_queries' => 2654
        ]
    ],
    
    'performance_metrics' => [
        'average_upload_time' => 3.2, // secondes
        'average_validation_time' => 2.5, // heures
        'user_satisfaction' => 4.6, // sur 5
        'system_availability' => 99.8, // pourcentage
        'search_accuracy' => 94.2, // pourcentage
        'document_findability' => 91.7 // pourcentage
    ]
]; 
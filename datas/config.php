<?php
/**
 * Configuration générale de l'application e-Archive
 * Paramètres globaux et configuration système
 */

return [
    'app' => [
        'name' => 'e-Archive',
        'version' => '1.0.0',
        'description' => 'Plateforme d\'archivage électronique du SGITP',
        'organization' => 'SGITP - République Démocratique du Congo',
        'department' => 'DANTIC',
        'timezone' => 'Africa/Kinshasa',
        'locale' => 'fr_CD',
        'currency' => 'CDF'
    ],
    
    'ui' => [
        'theme' => 'default',
        'sidebar_width' => '18rem',
        'primary_color' => '#1e40af',
        'secondary_color' => '#64748b',
        'success_color' => '#10b981',
        'warning_color' => '#f59e0b',
        'error_color' => '#ef4444',
        'items_per_page' => 25,
        'max_recent_items' => 10
    ],
    
    'storage' => [
        'max_file_size_mb' => 50,
        'allowed_extensions' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'dwg', 'zip'],
        'quarantine_days' => 30,
        'backup_retention_days' => 90,
        'auto_cleanup_enabled' => true
    ],
    
    'security' => [
        'session_timeout_minutes' => 120,
        'max_login_attempts' => 5,
        'password_min_length' => 8,
        'require_2fa' => false,
        'audit_log_retention_days' => 365,
        'encryption_enabled' => true
    ],
    
    'notifications' => [
        'email_enabled' => true,
        'sms_enabled' => false,
        'push_enabled' => true,
        'digest_frequency' => 'daily',
        'max_notifications_per_user' => 100
    ],
    
    'workflow' => [
        'auto_validation_enabled' => false,
        'validation_timeout_hours' => 72,
        'archive_after_validation' => true,
        'require_validation_comment' => true,
        'escalation_enabled' => true,
        'escalation_delay_hours' => 48
    ],
    
    'search' => [
        'fulltext_enabled' => true,
        'max_search_results' => 100,
        'search_suggestions_enabled' => true,
        'index_file_content' => true,
        'search_history_days' => 30
    ],
    
    'backup' => [
        'auto_backup_enabled' => true,
        'backup_frequency' => 'daily',
        'backup_time' => '03:00',
        'keep_backups_count' => 30,
        'compress_backups' => true
    ],
    
    'maintenance' => [
        'maintenance_mode' => false,
        'maintenance_message' => 'Maintenance en cours. Retour prévu dans quelques heures.',
        'allowed_ips' => ['127.0.0.1', '192.168.1.0/24'],
        'auto_maintenance_window' => '02:00-05:00'
    ],
    
    'features' => [
        'document_versioning' => true,
        'collaborative_editing' => false,
        'digital_signature' => false,
        'ocr_processing' => true,
        'watermarking' => true,
        'retention_policies' => true
    ],
    
    'integrations' => [
        'ldap_enabled' => false,
        'api_enabled' => true,
        'webhook_enabled' => false,
        'export_formats' => ['csv', 'excel', 'pdf'],
        'external_storage' => false
    ]
]; 
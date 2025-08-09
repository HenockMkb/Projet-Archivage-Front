<?php
/**
 * Utilitaire de chargement des données pour l'application e-Archive
 * Fournit des fonctions pour accéder facilement aux données
 */

class DataLoader {
    private static $cache = [];
    
    /**
     * Charge un fichier de données
     */
    public static function load($filename) {
        if (!isset(self::$cache[$filename])) {
            $path = __DIR__ . '/' . $filename . '.php';
            if (file_exists($path)) {
                self::$cache[$filename] = require $path;
            } else {
                self::$cache[$filename] = [];
            }
        }
        return self::$cache[$filename];
    }
    
    /**
     * Obtient les données des utilisateurs
     */
    public static function getUsers() {
        $data = self::load('users');
        return $data['users'] ?? [];
    }
    
    /**
     * Obtient un utilisateur par ID
     */
    public static function getUser($id) {
        $users = self::getUsers();
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }
    
    /**
     * Obtient les rôles
     */
    public static function getRoles() {
        $data = self::load('users');
        return $data['roles'] ?? [];
    }
    
    /**
     * Obtient les permissions disponibles
     */
    public static function getPermissions() {
        $data = self::load('users');
        return $data['permissions'] ?? [];
    }
    
    /**
     * Obtient le nombre d'utilisateurs par rôle
     */
    public static function getUserCountByRole() {
        $users = self::getUsers();
        $roles = self::getRoles();
        $userCount = [];
        
        // Initialiser le compteur pour chaque rôle
        foreach ($roles as $role) {
            $userCount[$role['id']] = 0;
        }
        
        // Compter les utilisateurs par rôle
        foreach ($users as $user) {
            if (isset($userCount[$user['role_id']])) {
                $userCount[$user['role_id']]++;
            }
        }
        
        return $userCount;
    }
    
    /**
     * Obtient les documents
     */
    public static function getDocuments($limit = null, $status = null) {
        $data = self::load('documents');
        $documents = $data['documents'] ?? [];
        
        // Filtrer par statut si spécifié
        if ($status) {
            $documents = array_filter($documents, function($doc) use ($status) {
                return $doc['status'] === $status;
            });
        }
        
        // Trier par date de création (plus récent en premier)
        usort($documents, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        // Limiter le nombre de résultats
        if ($limit) {
            $documents = array_slice($documents, 0, $limit);
        }
        
        return $documents;
    }
    
    /**
     * Obtient un document par ID
     */
    public static function getDocument($id) {
        $documents = self::getDocuments();
        foreach ($documents as $document) {
            if ($document['id'] == $id) {
                return $document;
            }
        }
        return null;
    }
    
    /**
     * Obtient les collections
     */
    public static function getCollections($limit = null) {
        $data = self::load('documents');
        $collections = $data['collections'] ?? [];
        
        // Trier par nombre de documents (plus populaire en premier)
        usort($collections, function($a, $b) {
            return $b['documents_count'] - $a['documents_count'];
        });
        
        if ($limit) {
            $collections = array_slice($collections, 0, $limit);
        }
        
        return $collections;
    }
    
    /**
     * Obtient les notifications pour un utilisateur
     */
    public static function getNotifications($userId = null, $unreadOnly = false) {
        $data = self::load('notifications');
        $notifications = $data['notifications'] ?? [];
        
        // Filtrer par utilisateur
        if ($userId) {
            $notifications = array_filter($notifications, function($notif) use ($userId) {
                return $notif['user_id'] == $userId;
            });
        }
        
        // Filtrer les non lues uniquement
        if ($unreadOnly) {
            $notifications = array_filter($notifications, function($notif) {
                return !$notif['read'];
            });
        }
        
        // Trier par date (plus récent en premier)
        usort($notifications, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return $notifications;
    }
    
    /**
     * Compte les notifications non lues pour un utilisateur
     */
    public static function getUnreadNotificationsCount($userId) {
        return count(self::getNotifications($userId, true));
    }
    
    /**
     * Obtient les alertes
     */
    public static function getAlerts() {
        $data = self::load('notifications');
        return $data['alerts'] ?? [];
    }
    
    /**
     * Obtient les statistiques KPI
     */
    public static function getKPIs() {
        $data = self::load('statistics');
        return $data['kpi'] ?? [];
    }
    
    /**
     * Obtient les activités récentes
     */
    public static function getRecentActivity($limit = 10) {
        $data = self::load('statistics');
        $activities = $data['recent_activity'] ?? [];
        
        return array_slice($activities, 0, $limit);
    }
    
    /**
     * Obtient les collections populaires
     */
    public static function getTopCollections($limit = 3) {
        $data = self::load('statistics');
        $collections = $data['top_collections'] ?? [];
        
        return array_slice($collections, 0, $limit);
    }
    
    /**
     * Obtient la configuration de l'application
     */
    public static function getConfig($section = null) {
        $data = self::load('config');
        
        if ($section) {
            return $data[$section] ?? [];
        }
        
        return $data;
    }
    
    /**
     * Formate la taille d'un fichier
     */
    public static function formatFileSize($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    /**
     * Alias pour formatFileSize (pour compatibilité)
     */
    public static function formatBytes($bytes) {
        return self::formatFileSize($bytes);
    }
    
    /**
     * Formate une date relative (il y a X temps)
     */
    public static function timeAgo($datetime) {
        $time = time() - strtotime($datetime);
        
        if ($time < 60) return 'À l\'instant';
        if ($time < 3600) return floor($time/60) . ' min';
        if ($time < 86400) return floor($time/3600) . ' h';
        if ($time < 2592000) return floor($time/86400) . ' j';
        if ($time < 31536000) return floor($time/2592000) . ' mois';
        
        return floor($time/31536000) . ' an' . (floor($time/31536000) > 1 ? 's' : '');
    }
    
    /**
     * Obtient la couleur d'un badge selon le statut
     */
    public static function getStatusBadgeClass($status) {
        $classes = [
            'draft' => 'bg-gray-100 text-gray-800',
            'pending_validation' => 'bg-yellow-100 text-yellow-800',
            'validated' => 'bg-green-100 text-green-800',
            'archived' => 'bg-blue-100 text-blue-800',
            'rejected' => 'bg-red-100 text-red-800'
        ];
        
        return $classes[$status] ?? 'bg-gray-100 text-gray-800';
    }
    
    /**
     * Obtient l'icône d'un type de fichier
     */
    public static function getFileTypeIcon($fileType) {
        $icons = [
            'pdf' => 'fa-file-pdf text-red-600',
            'doc' => 'fa-file-word text-blue-600',
            'docx' => 'fa-file-word text-blue-600',
            'xls' => 'fa-file-excel text-green-600',
            'xlsx' => 'fa-file-excel text-green-600',
            'ppt' => 'fa-file-powerpoint text-orange-600',
            'pptx' => 'fa-file-powerpoint text-orange-600',
            'dwg' => 'fa-file-image text-purple-600',
            'jpg' => 'fa-file-image text-blue-600',
            'jpeg' => 'fa-file-image text-blue-600',
            'png' => 'fa-file-image text-blue-600',
            'tiff' => 'fa-file-image text-blue-600'
        ];
        
        return $icons[$fileType] ?? 'fa-file text-gray-600';
    }
    
    /**
     * Obtient les classes CSS d'un badge selon le statut
     */
    public static function getBadgeClasses($status) {
        $classes = [
            'draft' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800',
            'pending' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800',
            'pending_validation' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800',
            'validated' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800',
            'archived' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800',
            'rejected' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800'
        ];
        
        return $classes[$status] ?? 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
    }
    
    /**
     * Obtient l'icône et les styles d'un type de fichier pour l'UI
     */
    public static function getFileIcon($fileType) {
        $icons = [
            'pdf' => [
                'icon' => 'fas fa-file-pdf',
                'color' => 'text-red-600',
                'bg' => 'bg-red-100'
            ],
            'doc' => [
                'icon' => 'fas fa-file-word',
                'color' => 'text-blue-600',
                'bg' => 'bg-blue-100'
            ],
            'docx' => [
                'icon' => 'fas fa-file-word',
                'color' => 'text-blue-600',
                'bg' => 'bg-blue-100'
            ],
            'xls' => [
                'icon' => 'fas fa-file-excel',
                'color' => 'text-green-600',
                'bg' => 'bg-green-100'
            ],
            'xlsx' => [
                'icon' => 'fas fa-file-excel',
                'color' => 'text-green-600',
                'bg' => 'bg-green-100'
            ],
            'ppt' => [
                'icon' => 'fas fa-file-powerpoint',
                'color' => 'text-orange-600',
                'bg' => 'bg-orange-100'
            ],
            'pptx' => [
                'icon' => 'fas fa-file-powerpoint',
                'color' => 'text-orange-600',
                'bg' => 'bg-orange-100'
            ],
            'dwg' => [
                'icon' => 'fas fa-file-image',
                'color' => 'text-purple-600',
                'bg' => 'bg-purple-100'
            ],
            'jpg' => [
                'icon' => 'fas fa-file-image',
                'color' => 'text-indigo-600',
                'bg' => 'bg-indigo-100'
            ],
            'jpeg' => [
                'icon' => 'fas fa-file-image',
                'color' => 'text-indigo-600',
                'bg' => 'bg-indigo-100'
            ],
            'png' => [
                'icon' => 'fas fa-file-image',
                'color' => 'text-indigo-600',
                'bg' => 'bg-indigo-100'
            ],
            'tiff' => [
                'icon' => 'fas fa-file-image',
                'color' => 'text-indigo-600',
                'bg' => 'bg-indigo-100'
            ]
        ];
        
        return $icons[$fileType] ?? [
            'icon' => 'fas fa-file',
            'color' => 'text-gray-600',
            'bg' => 'bg-gray-100'
        ];
    }

    /**
     * Récupérer toutes les données de workflows
     */
    public static function getWorkflows() {
        $data = include __DIR__ . '/workflows.php';
        return $data['workflows'];
    }

    /**
     * Récupérer les colonnes Kanban
     */
    public static function getKanbanColumns() {
        $data = include __DIR__ . '/workflows.php';
        return $data['kanban_columns'];
    }

    /**
     * Récupérer les catégories de workflows
     */
    public static function getWorkflowCategories() {
        $data = include __DIR__ . '/workflows.php';
        return $data['categories'];
    }

    /**
     * Récupérer les niveaux de priorité
     */
    public static function getPriorityLevels() {
        $data = include __DIR__ . '/workflows.php';
        return $data['priorities'];
    }

    /**
     * Récupérer les modèles de workflows
     */
    public static function getWorkflowTemplates() {
        $data = include __DIR__ . '/workflows.php';
        return $data['templates'];
    }

    /**
     * Récupérer un workflow par ID
     */
    public static function getWorkflowById($id) {
        $workflows = self::getWorkflows();
        foreach ($workflows as $workflow) {
            if ($workflow['id'] == $id) {
                return $workflow;
            }
        }
        return null;
    }

    /**
     * Récupérer les workflows par statut
     */
    public static function getWorkflowsByStatus($status) {
        $workflows = self::getWorkflows();
        return array_filter($workflows, fn($workflow) => $workflow['status'] === $status);
    }

    /**
     * Récupérer les workflows assignés à un utilisateur
     */
    public static function getWorkflowsByAssignee($assigneeId) {
        $workflows = self::getWorkflows();
        return array_filter($workflows, fn($workflow) => $workflow['assignee_id'] == $assigneeId);
    }

    /**
     * Récupérer les workflows par priorité
     */
    public static function getWorkflowsByPriority($priority) {
        $workflows = self::getWorkflows();
        return array_filter($workflows, fn($workflow) => $workflow['priority'] === $priority);
    }

    /**
     * Récupérer les workflows par catégorie
     */
    public static function getWorkflowsByCategory($category) {
        $workflows = self::getWorkflows();
        return array_filter($workflows, fn($workflow) => $workflow['category'] === $category);
    }

    /**
     * Récupérer les workflows en retard
     */
    public static function getOverdueWorkflows() {
        $workflows = self::getWorkflows();
        $now = time();
        return array_filter($workflows, function($workflow) use ($now) {
            return $workflow['status'] !== 'done' && strtotime($workflow['due_date']) < $now;
        });
    }

    /**
     * Récupérer les statistiques des workflows
     */
    public static function getWorkflowStats() {
        $workflows = self::getWorkflows();
        $stats = [
            'total' => count($workflows),
            'todo' => 0,
            'in_progress' => 0,
            'review' => 0,
            'done' => 0,
            'overdue' => 0,
            'by_priority' => ['high' => 0, 'medium' => 0, 'low' => 0],
            'by_category' => []
        ];

        foreach ($workflows as $workflow) {
            // Compter par statut
            if (isset($stats[$workflow['status']])) {
                $stats[$workflow['status']]++;
            }
            
            // Compter par priorité
            if (isset($stats['by_priority'][$workflow['priority']])) {
                $stats['by_priority'][$workflow['priority']]++;
            }
            
            // Compter par catégorie
            if (!isset($stats['by_category'][$workflow['category']])) {
                $stats['by_category'][$workflow['category']] = 0;
            }
            $stats['by_category'][$workflow['category']]++;
            
            // Compter les retards
            if ($workflow['status'] !== 'done' && strtotime($workflow['due_date']) < time()) {
                $stats['overdue']++;
            }
        }

        return $stats;
    }

    /**
     * Organiser les workflows par statut pour le Kanban
     */
    public static function getWorkflowsGroupedByStatus() {
        $workflows = self::getWorkflows();
        $columns = self::getKanbanColumns();
        $grouped = [];

        foreach ($columns as $status => $column) {
            $grouped[$status] = array_filter($workflows, fn($w) => $w['status'] === $status);
        }

        return $grouped;
    }
} 
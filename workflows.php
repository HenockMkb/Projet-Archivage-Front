<?php
// Charger les données
require_once 'datas/data_loader.php';

// Configuration de la page
$page_title = 'Workflows et Tâches';
$current_page = 'workflows';
$user_name = 'Benaja Bope';
$user_role = 'Archiviste Principal';
$user_initials = 'BB';
$notifications_count = DataLoader::getUnreadNotificationsCount(1);
$show_search = true;

// Charger les données pour la page workflows
$documents = DataLoader::getDocuments();
$collections = DataLoader::getCollections();

// Charger les données de workflows depuis le dossier datas
$workflows = DataLoader::getWorkflows();
$kanbanColumns = DataLoader::getKanbanColumns();
$workflowsByStatus = DataLoader::getWorkflowsGroupedByStatus();
$workflowStats = DataLoader::getWorkflowStats();

// Statistiques
$totalTasks = $workflowStats['total'];
$todoTasks = $workflowStats['todo'];
$inProgressTasks = $workflowStats['in_progress'];
$overdueTasks = $workflowStats['overdue'];

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'url' => 'index'],
    ['label' => 'Workflows']
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
                    <i class="fas fa-project-diagram mr-2"></i>
                    Gestion des workflows
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    Workflows et <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">tâches</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl">
                    Organisez et suivez vos tâches d'archivage avec notre système de workflow Kanban intuitif et collaboratif.
                </p>
                <div class="flex items-center mt-6 text-sm text-gray-500">
                    <div class="flex items-center mr-6">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full mr-2 animate-pulse"></div>
                        <?= $totalTasks ?> tâches actives
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        Dernière mise à jour : <?= date('H:i') ?>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" onclick="createNewTask()">
                    <div class="relative z-10 flex items-center">
                        <i class="fas fa-plus mr-3 text-lg"></i>
                        <span>Nouvelle tâche</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-indigo-800 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                <button class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 transform hover:-translate-y-1" onclick="showWorkflowSettings()">
                    <i class="fas fa-cog mr-3 text-indigo-600"></i>
                    <span>Paramètres</span>
                        </button>
                    </div>
                </div>
            </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total tâches -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-tasks text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300"><?= $totalTasks ?></div>
                        <div class="text-sm font-medium text-gray-600">Total</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Tâches actives</div>
            </div>
                        </div>

        <!-- À faire -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300"><?= $todoTasks ?></div>
                        <div class="text-sm font-medium text-gray-600">À faire</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Tâches planifiées</div>
            </div>
                        </div>

        <!-- En cours -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors duration-300"><?= $inProgressTasks ?></div>
                        <div class="text-sm font-medium text-gray-600">En cours</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Tâches actives</div>
            </div>
                        </div>

        <!-- En retard -->
        <div class="group relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-red-50/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900 group-hover:text-red-600 transition-colors duration-300"><?= $overdueTasks ?></div>
                        <div class="text-sm font-medium text-gray-600">En retard</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-700">Tâches urgentes</div>
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
                            Assigné à :
                        </label>
                        <select class="form-select w-40" id="assignee-filter">
                            <option value="">Tous</option>
                            <option value="Benaja Bope">Benaja Bope</option>
                            <option value="Marie Durand">Marie Durand</option>
                            <option value="Jean Martin">Jean Martin</option>
                            <option value="Sophie Laurent">Sophie Laurent</option>
                            <option value="Pierre Dubois">Pierre Dubois</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-flag mr-2 text-gray-400"></i>
                            Priorité :
                        </label>
                        <select class="form-select w-32" id="priority-filter">
                            <option value="">Toutes</option>
                            <option value="high">🔴 Haute</option>
                            <option value="medium">🟡 Moyenne</option>
                            <option value="low">🟢 Basse</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-tag mr-2 text-gray-400"></i>
                            Catégorie :
                        </label>
                        <select class="form-select w-36" id="category-filter">
                            <option value="">Toutes</option>
                                <option value="validation">Validation</option>
                            <option value="indexation">Indexation</option>
                            <option value="classification">Classification</option>
                            <option value="audit">Audit</option>
                            <option value="archivage">Archivage</option>
                            <option value="migration">Migration</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                    <button class="group inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" onclick="refreshWorkflows()">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        <span>Actualiser</span>
                    </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" onclick="exportWorkflows()">
                        <i class="fas fa-download mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Exporter</span>
                        </button>
                    <button class="group inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-200" onclick="showReports()">
                        <i class="fas fa-chart-bar mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Rapports</span>
                        </button>
                </div>
            </div>
                </div>
            </div>

    <!-- Tableau Kanban -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-project-diagram text-indigo-600"></i>
                    </div>
                    Tableau de workflow
                </h3>
                <div class="flex items-center space-x-3">
                    <button class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors duration-200" onclick="compactView()">
                        <i class="fas fa-compress-alt mr-1"></i>
                        Vue compacte
                    </button>
                    <button class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors duration-200" onclick="fullscreenMode()">
                        <i class="fas fa-expand mr-1"></i>
                        Plein écran
                    </button>
                                </div>
                            </div>
                        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6" id="kanban-board">
                <?php foreach ($kanbanColumns as $status => $column): ?>
                <div class="bg-gray-50 rounded-xl border border-gray-200" data-status="<?= $status ?>">
                    <!-- En-tête de colonne -->
                    <div class="bg-<?= $column['color'] ?>-100 px-4 py-3 border-b border-<?= $column['color'] ?>-200 rounded-t-xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-<?= $column['color'] ?>-500 rounded-lg flex items-center justify-center">
                                    <i class="fas <?= $column['icon'] ?> text-white text-sm"></i>
                            </div>
                                <div>
                                    <h4 class="font-bold text-<?= $column['color'] ?>-800"><?= $column['title'] ?></h4>
                                    <span class="text-xs text-<?= $column['color'] ?>-600"><?= count($workflowsByStatus[$status]) ?> tâche(s)</span>
                                </div>
                            </div>
                            <button class="text-<?= $column['color'] ?>-600 hover:text-<?= $column['color'] ?>-700 p-1 hover:bg-<?= $column['color'] ?>-200 rounded transition-colors duration-200" onclick="addTaskToColumn('<?= $status ?>')">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Liste des tâches -->
                    <div class="p-4 space-y-4 min-h-[600px]" id="column-<?= $status ?>" data-column="<?= $status ?>">
                        <?php foreach ($workflowsByStatus[$status] as $task): ?>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-all duration-300 cursor-move task-card" data-task-id="<?= $task['id'] ?>" onclick="openTaskDetails(<?= $task['id'] ?>)">
                            <!-- En-tête de tâche -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 mb-1 leading-tight"><?= htmlspecialchars($task['title']) ?></h5>
                                    <p class="text-sm text-gray-600 line-clamp-2"><?= htmlspecialchars($task['description']) ?></p>
                </div>
                                <div class="ml-3 flex-shrink-0">
                                    <?php
                                    $priorityColors = [
                                        'high' => 'bg-red-100 text-red-700',
                                        'medium' => 'bg-yellow-100 text-yellow-700',
                                        'low' => 'bg-green-100 text-green-700'
                                    ];
                                    $priorityIcons = [
                                        'high' => 'fa-arrow-up',
                                        'medium' => 'fa-minus',
                                        'low' => 'fa-arrow-down'
                                    ];
                                    ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $priorityColors[$task['priority']] ?>">
                                        <i class="fas <?= $priorityIcons[$task['priority']] ?> mr-1"></i>
                                        <?= ucfirst($task['priority']) ?>
                                    </span>
                    </div>
                            </div>

                            <!-- Document lié (si applicable) -->
                            <?php if ($task['document_id']): ?>
                            <div class="mb-3 p-2 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-file-alt text-blue-600 text-sm"></i>
                                    <span class="text-sm text-blue-800 font-medium truncate"><?= htmlspecialchars($task['document_title']) ?></span>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Barre de progression (pour les tâches en cours/révision) -->
                            <?php if (isset($task['progress']) && $task['progress'] > 0): ?>
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-600">Progression</span>
                                    <span class="text-xs font-medium text-gray-900"><?= $task['progress'] ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-<?= $column['color'] ?>-500 h-2 rounded-full transition-all duration-300" style="width: <?= $task['progress'] ?>%"></div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Métadonnées de tâche -->
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-calendar"></i>
                                        <span><?= date('d/m', strtotime($task['due_date'])) ?></span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-clock"></i>
                                        <span><?= $task['estimated_time'] ?></span>
                                    </div>
                                    <?php if ($task['status'] !== 'todo'): ?>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-play text-green-600"></i>
                                        <span>Démarrée</span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <div class="w-6 h-6 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        <?= $task['assignee_initials'] ?>
                            </div>
                                </div>
                    </div>
                    
                            <!-- Indicateur de retard -->
                            <?php if ($task['status'] !== 'done' && strtotime($task['due_date']) < time()): ?>
                            <div class="mt-2 flex items-center space-x-1 text-red-600">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                                <span class="text-xs font-medium">En retard</span>
                            </div>
                            <?php endif; ?>

                            <!-- Actions rapides -->
                            <div class="mt-3 flex items-center justify-between pt-2 border-t border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <?php if ($task['status'] === 'todo'): ?>
                                    <button class="text-green-600 hover:text-green-700 text-xs" onclick="event.stopPropagation(); startTask(<?= $task['id'] ?>)">
                                        <i class="fas fa-play mr-1"></i>Commencer
                                    </button>
                                    <?php elseif ($task['status'] === 'in_progress'): ?>
                                    <button class="text-purple-600 hover:text-purple-700 text-xs" onclick="event.stopPropagation(); reviewTask(<?= $task['id'] ?>)">
                                        <i class="fas fa-eye mr-1"></i>Révision
                                    </button>
                                    <?php elseif ($task['status'] === 'review'): ?>
                                    <button class="text-green-600 hover:text-green-700 text-xs" onclick="event.stopPropagation(); completeTask(<?= $task['id'] ?>)">
                                        <i class="fas fa-check mr-1"></i>Terminer
                                    </button>
                                    <?php endif; ?>
                                    </div>
                                <div class="flex items-center space-x-1">
                                    <button class="text-gray-400 hover:text-gray-600 p-1 hover:bg-gray-100 rounded transition-colors duration-200" onclick="event.stopPropagation(); editTask(<?= $task['id'] ?>)">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button class="text-gray-400 hover:text-red-600 p-1 hover:bg-red-100 rounded transition-colors duration-200" onclick="event.stopPropagation(); deleteTask(<?= $task['id'] ?>)">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Zone de drop pour les nouvelles tâches -->
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center text-gray-500 hover:border-<?= $column['color'] ?>-400 hover:text-<?= $column['color'] ?>-600 transition-colors duration-200 cursor-pointer drop-zone" onclick="addTaskToColumn('<?= $status ?>')">
                            <i class="fas fa-plus text-2xl mb-2"></i>
                            <p class="text-sm font-medium">Ajouter une tâche</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Modal de détails de tâche -->
<div id="task-details-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-tasks text-indigo-600"></i>
                    </div>
                    Détails de la tâche
                </h3>
                <button onclick="closeTaskModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
                            </div>
                                    </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
            <div id="task-details-content">
                <!-- Le contenu sera injecté dynamiquement -->
                                </div>
                            </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3">
            <button onclick="closeTaskModal()" class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Fermer
            </button>
            <button onclick="editCurrentTask()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Modifier
            </button>
                                </div>
                            </div>
                        </div>

<?php
$content = ob_get_clean(); // Capturer le contenu

// JavaScript personnalisé pour cette page
$inline_js = '
// Variables globales
let currentTaskId = null;
let workflows = ' . json_encode($workflows) . ';
let draggedElement = null;

// Initialisation
document.addEventListener("DOMContentLoaded", function() {
    initFilters();
    initDragAndDrop();
    initWorkflowBoard();
});

function initFilters() {
    const filters = ["assignee-filter", "priority-filter", "category-filter"];
    filters.forEach(filterId => {
        document.getElementById(filterId).addEventListener("change", applyFilters);
    });
}

function initDragAndDrop() {
    // Rendre les cartes de tâches déplaçables
    document.querySelectorAll(".task-card").forEach(card => {
        card.draggable = true;
        
        card.addEventListener("dragstart", function(e) {
            draggedElement = this;
            e.dataTransfer.effectAllowed = "move";
            e.dataTransfer.setData("text/html", this.outerHTML);
            this.style.opacity = "0.5";
        });
        
        card.addEventListener("dragend", function(e) {
            this.style.opacity = "1";
            draggedElement = null;
        });
    });
    
    // Configurer les zones de drop
    document.querySelectorAll("[data-column]").forEach(column => {
        column.addEventListener("dragover", function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = "move";
            this.classList.add("bg-blue-50", "border-blue-300");
        });
        
        column.addEventListener("dragleave", function(e) {
            this.classList.remove("bg-blue-50", "border-blue-300");
        });
        
        column.addEventListener("drop", function(e) {
            e.preventDefault();
            this.classList.remove("bg-blue-50", "border-blue-300");
            
            if (draggedElement) {
                const taskId = draggedElement.getAttribute("data-task-id");
                const newStatus = this.getAttribute("data-column");
                moveTask(taskId, newStatus);
            }
        });
    });
}

function initWorkflowBoard() {
    // Initialiser les fonctionnalités du board
    updateColumnCounts();
}

function applyFilters() {
    const assigneeFilter = document.getElementById("assignee-filter").value;
    const priorityFilter = document.getElementById("priority-filter").value;
    const categoryFilter = document.getElementById("category-filter").value;
    
    document.querySelectorAll(".task-card").forEach(card => {
        let show = true;
        const taskId = card.getAttribute("data-task-id");
        const task = workflows.find(w => w.id == taskId);
        
        if (assigneeFilter && task.assignee !== assigneeFilter) show = false;
        if (priorityFilter && task.priority !== priorityFilter) show = false;
        if (categoryFilter && task.category !== categoryFilter) show = false;
        
        card.style.display = show ? "block" : "none";
    });
    
    showToast("Filtres appliqués", "info");
}

function moveTask(taskId, newStatus) {
    // Mettre à jour le statut de la tâche
    const task = workflows.find(w => w.id == taskId);
    if (task) {
        const oldStatus = task.status;
        task.status = newStatus;
        
        // Déplacer visuellement la carte
        const card = document.querySelector(`[data-task-id="${taskId}"]`);
        const newColumn = document.getElementById(`column-${newStatus}`);
        
        if (card && newColumn) {
            // Retirer de la colonne actuelle
            card.remove();
            
            // Ajouter à la nouvelle colonne (avant la zone de drop)
            const dropZone = newColumn.querySelector(".drop-zone");
            newColumn.insertBefore(card, dropZone);
            
            // Mettre à jour les compteurs
            updateColumnCounts();
            
            showToast(`Tâche déplacée vers "${getColumnTitle(newStatus)}"`, "success");
        }
    }
}

function getColumnTitle(status) {
    const titles = {
        "todo": "À faire",
        "in_progress": "En cours",
        "review": "En révision",
        "done": "Terminé"
    };
    return titles[status] || status;
}

function updateColumnCounts() {
    document.querySelectorAll("[data-status]").forEach(column => {
        const status = column.getAttribute("data-status");
        const count = column.querySelectorAll(".task-card:not([style*=\"display: none\"])").length;
        const countElement = column.querySelector("span");
        if (countElement) {
            countElement.textContent = `${count} tâche(s)`;
        }
    });
}

function openTaskDetails(taskId) {
    const task = workflows.find(w => w.id == taskId);
    if (!task) return;
    
    currentTaskId = taskId;
    
    const priorityLabels = {
        "high": "🔴 Haute",
        "medium": "🟡 Moyenne", 
        "low": "🟢 Basse"
    };
    
    const statusLabels = {
        "todo": "À faire",
        "in_progress": "En cours",
        "review": "En révision",
        "done": "Terminé"
    };
    
    const content = `
        <div class="space-y-6">
            <div>
                <h4 class="text-lg font-bold text-gray-900 mb-2">${escapeHtml(task.title)}</h4>
                <p class="text-gray-600">${escapeHtml(task.description)}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Statut</label>
                    <p class="text-gray-900">${statusLabels[task.status]}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Priorité</label>
                    <p class="text-gray-900">${priorityLabels[task.priority]}</p>
                            </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Assigné à</label>
                    <p class="text-gray-900">${escapeHtml(task.assignee)}</p>
                                    </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Catégorie</label>
                    <p class="text-gray-900 capitalize">${escapeHtml(task.category)}</p>
                                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Date d\'échéance</label>
                    <p class="text-gray-900">${formatDate(task.due_date)}</p>
                            </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Temps estimé</label>
                    <p class="text-gray-900">${task.estimated_time}</p>
                                </div>
                            </div>

            ${task.document_id ? `
                <div>
                    <label class="text-sm font-medium text-gray-700">Document lié</label>
                    <div class="mt-1 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-alt text-blue-600"></i>
                            <span class="text-blue-800 font-medium">${escapeHtml(task.document_title)}</span>
                        </div>
                    </div>
                </div>
            ` : ""}
            
            ${task.progress ? `
                                        <div>
                <label class="text-sm font-medium text-gray-700">Progression</label>
                <div class="mt-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600">Avancement</span>
                        <span class="text-sm font-medium text-gray-900">${task.progress}%</span>
                                        </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: ${task.progress}%"></div>
                    </div>
                </div>
            </div>
            ` : ""}
            
            <div>
                <label class="text-sm font-medium text-gray-700">Historique</label>
                <div class="mt-2 space-y-2">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-plus text-green-600 mr-2"></i>
                        Créée le ${formatDateTime(task.created_at)}
                    </div>
                    ${task.started_at ? `
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-play text-blue-600 mr-2"></i>
                        Démarrée le ${formatDateTime(task.started_at)}
                    </div>
                    ` : ""}
                    ${task.completed_at ? `
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Terminée le ${formatDateTime(task.completed_at)}
                    </div>
                    ` : ""}
            </div>
            </div>
        </div>
    `;
    
    document.getElementById("task-details-content").innerHTML = content;
    document.getElementById("task-details-modal").classList.remove("hidden");
}

function closeTaskModal() {
    document.getElementById("task-details-modal").classList.add("hidden");
    currentTaskId = null;
}

function startTask(taskId) {
    moveTask(taskId, "in_progress");
    showToast("Tâche démarrée", "success");
}

function reviewTask(taskId) {
    moveTask(taskId, "review");
    showToast("Tâche envoyée en révision", "info");
}

function completeTask(taskId) {
    moveTask(taskId, "done");
    showToast("Tâche terminée", "success");
}

function editTask(taskId) {
    showToast("Modification de tâche - Fonctionnalité à venir", "info");
}

function deleteTask(taskId) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette tâche ?")) {
        const card = document.querySelector(`[data-task-id="${taskId}"]`);
        if (card) {
            card.remove();
            workflows = workflows.filter(w => w.id != taskId);
            updateColumnCounts();
            showToast("Tâche supprimée", "success");
        }
    }
}

function editCurrentTask() {
    if (currentTaskId) {
        editTask(currentTaskId);
        closeTaskModal();
    }
}

function addTaskToColumn(status) {
    showToast(`Nouvelle tâche pour "${getColumnTitle(status)}" - Fonctionnalité à venir`, "info");
}

function createNewTask() {
    showToast("Création de nouvelle tâche - Fonctionnalité à venir", "info");
}

function refreshWorkflows() {
    showToast("Actualisation en cours...", "info");
            setTimeout(() => {
                window.location.reload();
    }, 1000);
        }

        function exportWorkflows() {
    showToast("Export en cours...", "success");
}

function showReports() {
    showToast("Rapports de workflow - Fonctionnalité à venir", "info");
}

function showWorkflowSettings() {
    showToast("Paramètres de workflow - Fonctionnalité à venir", "info");
}

function compactView() {
    showToast("Vue compacte activée", "info");
}

function fullscreenMode() {
    showToast("Mode plein écran - Fonctionnalité à venir", "info");
}

// Fonctions utilitaires
function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString("fr-FR");
}

function formatDateTime(dateString) {
    return new Date(dateString).toLocaleString("fr-FR");
}

// Fermer le modal en cliquant en dehors
document.getElementById("task-details-modal").addEventListener("click", function(e) {
    if (e.target === this) {
        closeTaskModal();
    }
});
';

// Inclure le layout
include 'includes/layout.php';
?> 
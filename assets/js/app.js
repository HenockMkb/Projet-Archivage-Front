// Application e-Archive - JavaScript principal
class EArchiveApp {
    constructor() {
        this.currentUser = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadUserData();
        this.setupSidebar();
        this.setupModals();
        this.setupForms();
        this.setupTables();
        this.setupSearch();
    }

    // Gestion des événements globaux
    setupEventListeners() {
        // Toggle sidebar mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.toggle('hidden');
                }
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.add('hidden');
            });
        }

        // Fermer les modals avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });

        // Logout
        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.logout();
            });
        }
    }

    // Gestion de la sidebar
    setupSidebar() {
        const navLinks = document.querySelectorAll('.nav-link');
        const currentPath = window.location.pathname;

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && currentPath.includes(href)) {
                link.classList.add('active');
            }

            link.addEventListener('click', (e) => {
                navLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            });
        });
    }

    // Gestion des modals
    setupModals() {
        // Ouvrir modals
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-modal-target]')) {
                const modalId = e.target.getAttribute('data-modal-target');
                this.openModal(modalId);
            }
        });

        // Fermer modals
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-modal-close]') || e.target.classList.contains('modal-overlay')) {
                this.closeModal(e.target.closest('.modal-overlay'));
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modal) {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    closeAllModals() {
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => this.closeModal(modal));
    }

    // Gestion des formulaires
    setupForms() {
        const forms = document.querySelectorAll('form[data-form]');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleFormSubmit(form);
            });
        });

        // Validation en temps réel
        const inputs = document.querySelectorAll('.form-input, .form-select, .form-textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    handleFormSubmit(form) {
        const formType = form.getAttribute('data-form');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        // Validation
        if (!this.validateForm(form)) {
            return;
        }

        // Simulation d'envoi
        this.showLoading(form);
        
        setTimeout(() => {
            this.hideLoading(form);
            this.showSuccess('Formulaire envoyé avec succès !');
            
            // Redirection selon le type de formulaire
            switch (formType) {
                case 'login':
                    window.location.href = 'index.html';
                    break;
                case 'upload':
                    window.location.href = 'inbox.html';
                    break;
                case 'validate':
                    window.location.href = 'workflows.html';
                    break;
            }
        }, 1500);
    }

    validateForm(form) {
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const type = field.type;
        const pattern = field.pattern;

        // Réinitialiser l'erreur
        this.clearFieldError(field);

        // Validation required
        if (isRequired && !value) {
            this.showFieldError(field, 'Ce champ est requis');
            return false;
        }

        // Validation email
        if (type === 'email' && value && !this.isValidEmail(value)) {
            this.showFieldError(field, 'Format d\'email invalide');
            return false;
        }

        // Validation pattern
        if (pattern && value && !new RegExp(pattern).test(value)) {
            this.showFieldError(field, field.getAttribute('data-error') || 'Format invalide');
            return false;
        }

        return true;
    }

    showFieldError(field, message) {
        field.classList.add('border-red-500');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-500 text-sm mt-1';
        errorDiv.textContent = message;
        errorDiv.id = `error-${field.id || field.name}`;
        field.parentNode.appendChild(errorDiv);
    }

    clearFieldError(field) {
        field.classList.remove('border-red-500');
        const errorDiv = field.parentNode.querySelector(`#error-${field.id || field.name}`);
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Gestion des tableaux
    setupTables() {
        const tables = document.querySelectorAll('.table');
        tables.forEach(table => {
            this.setupTableSorting(table);
            this.setupTableFiltering(table);
            this.setupTablePagination(table);
        });
    }

    setupTableSorting(table) {
        const headers = table.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const column = header.getAttribute('data-sort');
                const direction = header.getAttribute('data-direction') === 'asc' ? 'desc' : 'asc';
                
                // Mettre à jour les directions
                headers.forEach(h => h.setAttribute('data-direction', ''));
                header.setAttribute('data-direction', direction);
                
                this.sortTable(table, column, direction);
            });
        });
    }

    sortTable(table, column, direction) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.querySelector(`[data-${column}]`).getAttribute(`data-${column}`);
            const bValue = b.querySelector(`[data-${column}]`).getAttribute(`data-${column}`);
            
            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });
        
        rows.forEach(row => tbody.appendChild(row));
    }

    setupTableFiltering(table) {
        const filterInput = table.parentNode.querySelector('.table-filter');
        if (filterInput) {
            filterInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }
    }

    setupTablePagination(table) {
        const pagination = table.parentNode.querySelector('.pagination');
        if (pagination) {
            const pageButtons = pagination.querySelectorAll('[data-page]');
            pageButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const page = button.getAttribute('data-page');
                    this.goToPage(table, page);
                });
            });
        }
    }

    goToPage(table, page) {
        // Logique de pagination
        console.log(`Aller à la page ${page} pour le tableau ${table.id}`);
    }

    // Gestion de la recherche
    setupSearch() {
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            let searchTimeout;
            
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.performSearch(e.target.value);
                }, 300);
            });
        }
    }

    performSearch(query) {
        if (query.length < 2) return;
        
        // Simulation de recherche
        console.log(`Recherche pour: ${query}`);
        this.showLoading(document.querySelector('.search-results'));
        
        setTimeout(() => {
            this.hideLoading(document.querySelector('.search-results'));
            // Afficher les résultats
        }, 1000);
    }

    // Gestion des fichiers (upload)
    setupFileUpload() {
        const dropzones = document.querySelectorAll('.dropzone');
        dropzones.forEach(dropzone => {
            const input = dropzone.querySelector('input[type="file"]');
            
            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('active');
            });
            
            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('active');
            });
            
            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('active');
                const files = e.dataTransfer.files;
                this.handleFiles(files, input);
            });
            
            if (input) {
                input.addEventListener('change', (e) => {
                    this.handleFiles(e.target.files, input);
                });
            }
        });
    }

    handleFiles(files, input) {
        const fileList = input.parentNode.querySelector('.file-list');
        if (fileList) {
            fileList.innerHTML = '';
            
            Array.from(files).forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg mb-2';
                fileItem.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm text-gray-700">${file.name}</span>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentNode.remove()">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                fileList.appendChild(fileItem);
            });
        }
    }

    // Utilitaires
    showLoading(element) {
        if (element) {
            element.classList.add('opacity-50');
            element.style.pointerEvents = 'none';
        }
    }

    hideLoading(element) {
        if (element) {
            element.classList.remove('opacity-50');
            element.style.pointerEvents = 'auto';
        }
    }

    showSuccess(message) {
        this.showNotification(message, 'success');
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    showWarning(message) {
        this.showNotification(message, 'warning');
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
        
        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };
        
        notification.classList.add(...colors[type].split(' '));
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="flex-1">${message}</span>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentNode.parentNode.remove()">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto-remove après 5 secondes
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Gestion des données utilisateur
    loadUserData() {
        // Simulation de chargement des données utilisateur
        this.currentUser = {
            id: 1,
            name: 'Jean Dupont',
            email: 'jean.dupont@sgitp.cd',
            role: 'archiviste',
            avatar: null
        };
        
        this.updateUserInterface();
    }

    updateUserInterface() {
        const userNameElements = document.querySelectorAll('.user-name');
        const userEmailElements = document.querySelectorAll('.user-email');
        const userRoleElements = document.querySelectorAll('.user-role');
        
        userNameElements.forEach(el => el.textContent = this.currentUser.name);
        userEmailElements.forEach(el => el.textContent = this.currentUser.email);
        userRoleElements.forEach(el => el.textContent = this.currentUser.role);
    }

    logout() {
        if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
            // Simulation de déconnexion
            this.currentUser = null;
            window.location.href = 'login.html';
        }
    }

    // Gestion des données (simulation)
    async fetchData(endpoint) {
        // Simulation d'appel API
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(this.getMockData(endpoint));
            }, 500);
        });
    }

    getMockData(endpoint) {
        const mockData = {
            '/api/documents': [
                { id: 1, title: 'Rapport annuel 2023', type: 'PDF', status: 'archivé', date: '2023-12-15' },
                { id: 2, title: 'Contrat de construction', type: 'PDF', status: 'en attente', date: '2023-12-14' },
                { id: 3, title: 'Plan d\'urbanisme', type: 'DWG', status: 'validé', date: '2023-12-13' }
            ],
            '/api/collections': [
                { id: 1, name: 'Infrastructures', count: 150, description: 'Documents relatifs aux infrastructures' },
                { id: 2, name: 'Urbanisme', count: 89, description: 'Plans et études d\'urbanisme' },
                { id: 3, name: 'Administratif', count: 234, description: 'Documents administratifs' }
            ],
            '/api/stats': {
                totalDocuments: 1250,
                pendingValidation: 23,
                archivedToday: 5,
                storageUsed: '2.3 GB'
            }
        };
        
        return mockData[endpoint] || [];
    }
}

// Initialisation de l'application
document.addEventListener('DOMContentLoaded', () => {
    window.eArchiveApp = new EArchiveApp();
    
    // Initialiser les composants spécifiques
    if (window.eArchiveApp.setupFileUpload) {
        window.eArchiveApp.setupFileUpload();
    }
});

// Fonctions utilitaires globales
window.utils = {
    formatDate: (dateString) => {
        return new Date(dateString).toLocaleDateString('fr-FR');
    },
    
    formatFileSize: (bytes) => {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    
    truncateText: (text, maxLength = 50) => {
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    }
}; 
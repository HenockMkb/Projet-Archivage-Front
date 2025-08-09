<?php
// Démarrer la session
session_start();

// Si l'utilisateur est déjà connecté, le rediriger
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Configuration de la page
$page_title = 'Connexion';
$login_error = '';
$login_success = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validation basique
    if (empty($email) || empty($password)) {
        $login_error = 'Veuillez saisir votre email et mot de passe.';
    } else {
        // Simulation de la vérification des identifiants
        // En production, vérifier contre la base de données
        if ($email === 'admin@sgitp.cd' && $password === 'admin123') {
            // Connexion réussie
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Benaja Bope';
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'Archiviste Principal';
            $_SESSION['user_initials'] = 'BB';
            $_SESSION['login_time'] = time();
            
            // Si "Se souvenir de moi" est coché
            if ($remember) {
                setcookie('remember_user', base64_encode($email), time() + (86400 * 30), '/'); // 30 jours
            }
            
            // Redirection vers le dashboard
            header('Location: index.php');
            exit;
        } else {
            $login_error = 'Email ou mot de passe incorrect.';
        }
    }
}

// Vérifier si un cookie "remember me" existe
$remembered_email = '';
if (isset($_COOKIE['remember_user'])) {
    $remembered_email = base64_decode($_COOKIE['remember_user']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> - e-Archive | SGITP</title>
    <meta name="description" content="Connexion à la plateforme d'archivage électronique du SGITP">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
    <link rel="apple-touch-icon" href="assets/images/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="assets/css/main.css">
    
    <!-- Icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Variables CSS globales -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .login-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Particles d'arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute top-40 right-32 w-24 h-24 bg-blue-300/20 rounded-full blur-lg animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-purple-300/15 rounded-full blur-2xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 right-20 w-28 h-28 bg-indigo-300/20 rounded-full blur-xl animate-pulse" style="animation-delay: 0.5s;"></div>
    </div>

    <div class="w-full max-w-xl relative z-10 animate-fade-in">
        <!-- Messages d'erreur/succès -->
        <?php if ($login_error): ?>
        <div class="mb-4 p-3 bg-red-100 border border-red-300 rounded-xl">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                <span class="text-red-800 text-sm"><?= htmlspecialchars($login_error) ?></span>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($login_success): ?>
        <div class="mb-4 p-3 bg-green-100 border border-green-300 rounded-xl">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span class="text-green-800 text-sm"><?= htmlspecialchars($login_success) ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <div class="login-card rounded-3xl shadow-2xl border border-white/20 p-6">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl mb-4 shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-archive text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Connexion</h2>
                <p class="text-gray-600">Connectez-vous à e-Archive</p>
            </div>

            <form method="POST" class="space-y-5">
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <div class="flex items-center">
                            <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-blue-600 text-sm"></i>
                            </div>
                            Adresse email
                        </div>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        value="<?= htmlspecialchars($remembered_email) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white" 
                        placeholder="votre.email@sgitp.cd"
                        autocomplete="email"
                    >
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <div class="flex items-center">
                            <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-lock text-green-600 text-sm"></i>
                            </div>
                            Mot de passe
                        </div>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white" 
                            placeholder="Votre mot de passe"
                            autocomplete="current-password"
                        >
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                            onclick="togglePassword()"
                        >
                            <i class="fas fa-eye" id="password-toggle"></i>
                        </button>
                    </div>
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between py-1">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" <?= $remembered_email ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors duration-200">Se souvenir de moi</span>
                    </label>
                    <a href="forgot-password.php" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Informations de démonstration -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-3">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                            <i class="fas fa-info-circle text-blue-600 text-xs"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800 mb-1">Compte de démonstration</h4>
                            <div class="p-2 text-xs space-y-1">
                                <div><strong>Email :</strong> admin@sgitp.cd</div>
                                <div><strong>Mot de passe :</strong> admin123</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        <span>Se connecter</span>
                    </div>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4">
            <p class="text-xs text-blue-100 drop-shadow">
                © <?= date('Y') ?> SGITP - DANTIC
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/app.js"></script>
    <script>
        // Fonction pour basculer la visibilité du mot de passe
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        }

        // Animation du formulaire
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des éléments au chargement
            const elements = document.querySelectorAll('.form-group, .btn-primary');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Effet de particules au survol
            document.addEventListener('mousemove', function(e) {
                const particles = document.querySelectorAll('.absolute > div');
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                particles.forEach((particle, index) => {
                    const speed = (index + 1) * 0.5;
                    const xPos = x * speed * 10;
                    const yPos = y * speed * 10;
                    particle.style.transform = `translate(${xPos}px, ${yPos}px)`;
                });
            });

            // Focus automatique sur le champ email s'il est vide
            const emailInput = document.getElementById('email');
            if (!emailInput.value) {
                emailInput.focus();
            } else {
                document.getElementById('password').focus();
            }
        });

        // Validation côté client
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                showToast('Veuillez saisir votre email et mot de passe.', 'error');
                return;
            }
            
            if (!email.includes('@')) {
                e.preventDefault();
                showToast('Veuillez saisir une adresse email valide.', 'error');
                return;
            }
        });

        // Fonction toast simplifiée pour les erreurs
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 transform translate-x-full transition-transform duration-300 ${
                type === 'error' ? 'bg-red-500' : 
                type === 'success' ? 'bg-green-500' : 
                'bg-blue-500'
            }`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(() => toast.style.transform = 'translateX(0)', 100);
            setTimeout(() => {
                toast.style.transform = 'translateX(full)';
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }

        // Gestion des erreurs réseau
        window.addEventListener('online', function() {
            showToast('Connexion rétablie', 'success');
        });

        window.addEventListener('offline', function() {
            showToast('Connexion perdue', 'error');
        });
    </script>
</body>
</html> 
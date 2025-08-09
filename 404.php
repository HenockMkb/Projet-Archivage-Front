<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - e-Archive | SGITP</title>
    <meta name="description" content="Page non trouvée - e-Archive">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
    <link rel="apple-touch-icon" href="assets/images/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="assets/css/main.css">
    
    <!-- Variables CSS globales -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <!-- Particules d'arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-2 h-2 bg-blue-400 rounded-full animate-pulse-slow"></div>
        <div class="absolute top-32 right-20 w-1 h-1 bg-indigo-400 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 left-1/4 w-3 h-3 bg-purple-400 rounded-full animate-pulse-slow"></div>
        <div class="absolute bottom-32 right-1/3 w-1 h-1 bg-blue-300 rounded-full animate-pulse"></div>
    </div>

    <div class="max-w-2xl w-full text-center relative z-10">
        <!-- En-tête simplifié -->
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">e-Archive</h1>
            <p class="text-lg text-gray-600 font-medium">SGITP - DANTIC</p>
        </div>

        <!-- Message d'erreur principal -->
        <div class="bg-white rounded-3xl border border-gray-200 p-12 mb-10 relative overflow-hidden">
            <!-- Effet de brillance -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
            
            <div class="mb-10">
                <h2 class="text-7xl font-bold bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent mb-6">404</h2>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Page non trouvée</h3>
                <p class="text-xl text-gray-600 leading-relaxed max-w-xl mx-auto">
                    Désolé, la page que vous recherchez n'existe pas ou a été déplacée. Veuillez vérifier l'URL ou utiliser les liens ci-dessous pour naviguer.
                </p>
            </div>
            
            <div class="space-y-6">
                <a href="index.php" class="group inline-flex items-center justify-center w-full px-10 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 text-lg">

                    Retour au Dashboard
                </a>
                <a href="search.php" class="group inline-flex items-center justify-center w-full px-10 py-5 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1 text-lg">
                    Rechercher dans l'archive
                </a>
            </div>
        </div>

        <!-- Liens utiles -->
        <div class="bg-white rounded-3xl border border-gray-200 p-8">
            <p class="text-lg font-semibold text-gray-700 mb-6 flex items-center justify-center">
                <span class="mr-3 text-xl">🧭</span>
                Navigation rapide
            </p>
            <div class="grid grid-cols-2 gap-4 text-base">
                <a href="documents.php" class="flex items-center px-6 py-4 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium border border-gray-100">
                    <span class="mr-3 text-xl">📄</span>
                    Documents
                </a>
                <a href="collections.php" class="flex items-center px-6 py-4 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium border border-gray-100">
                    <span class="mr-3 text-xl">📂</span>
                    Collections
                </a>
                <a href="workflows.php" class="flex items-center px-6 py-4 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium border border-gray-100">
                    <span class="mr-3 text-xl">📋</span>
                    Workflows
                </a>
                <a href="settings.php" class="flex items-center px-6 py-4 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium border border-gray-100">
                    <span class="mr-3 text-xl">⚙️</span>
                    Paramètres
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-10 text-center">
            <p class="text-sm text-gray-500 flex items-center justify-center">
                <span class="mr-2">🛡️</span>
                Plateforme sécurisée • Version 1.2.1
            </p>
        </div>
    </div>

    <!-- JavaScript pour les effets interactifs -->
    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('[class*="animate-"]');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Effet de parallaxe simple
        document.addEventListener('mousemove', function(e) {
            const particles = document.querySelectorAll('[class*="bg-blue-"], [class*="bg-indigo-"], [class*="bg-purple-"]');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            particles.forEach((particle, index) => {
                const speed = (index + 1) * 0.5;
                const xPos = x * speed;
                const yPos = y * speed;
                particle.style.transform = `translate(${xPos}px, ${yPos}px)`;
            });
        });

        // Retour automatique après 30 secondes (optionnel)
        setTimeout(() => {
            const autoReturn = confirm("Souhaitez-vous retourner automatiquement au Dashboard ?");
            if (autoReturn) {
                window.location.href = "index.php";
            }
        }, 30000);
    </script>
</body>
</html> 
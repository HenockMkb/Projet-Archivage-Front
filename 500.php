<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur serveur - e-Archive | SGITP</title>
    <meta name="description" content="Erreur serveur - e-Archive">
    
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
        
        .animate-glitch {
            animation: glitch 2s infinite;
        }
        
        @keyframes glitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(-2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(2px, -2px); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 min-h-screen flex items-center justify-center p-4">
    <!-- Particules d'arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-2 h-2 bg-red-400 rounded-full animate-pulse-slow"></div>
        <div class="absolute top-32 right-20 w-1 h-1 bg-orange-400 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 left-1/4 w-3 h-3 bg-yellow-400 rounded-full animate-pulse-slow"></div>
        <div class="absolute bottom-32 right-1/3 w-1 h-1 bg-red-300 rounded-full animate-pulse"></div>
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
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>
            
            <div class="mb-10">
                <h2 class="text-7xl font-bold bg-gradient-to-r from-red-600 to-orange-700 bg-clip-text text-transparent mb-6">500</h2>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Erreur serveur</h3>
                <p class="text-xl text-gray-600 leading-relaxed max-w-xl mx-auto">
                    Une erreur interne s'est produite sur le serveur. Nos équipes techniques ont été automatiquement notifiées et travaillent à résoudre le problème.
                </p>
            </div>
            
            <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-6 mb-8">
                <p class="text-base text-gray-700 flex items-center justify-center">
                    <span class="mr-3 text-xl">🔧</span>
                    <span><strong>Code d'erreur :</strong> <?= isset($_GET['code']) ? htmlspecialchars($_GET['code']) : 'INTERNAL_SERVER_ERROR' ?></span>
                </p>
            </div>
            
            <div class="space-y-6">
                <button onclick="window.location.reload()" class="group inline-flex items-center justify-center w-full px-10 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 text-lg">

                    Réessayer
                </button>
                <a href="index.php" class="group inline-flex items-center justify-center w-full px-10 py-5 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1 text-lg">
                    Retour au Dashboard
                </a>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="bg-white rounded-3xl border border-gray-200 p-8">
            <p class="text-lg font-semibold text-gray-700 mb-6 flex items-center justify-center">
                <span class="mr-3 text-xl">🆘</span>
                Besoin d'aide ?
            </p>
            <div class="grid grid-cols-1 gap-4 text-base">
                <div class="flex items-center justify-center px-6 py-4 text-gray-600 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="mr-3 text-xl">📞</span>
                    <span>Support technique : <strong>+243 XX XXX XXXX</strong></span>
                </div>
                <div class="flex items-center justify-center px-6 py-4 text-gray-600 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="mr-3 text-xl">📧</span>
                    <span>Email : <strong>support@sgitp.cd</strong></span>
                </div>
                <div class="flex items-center justify-center px-6 py-4 text-gray-600 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="mr-3 text-xl">🕐</span>
                    <span>Horaires : <strong>8h - 17h (GMT+1)</strong></span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-10 text-center">
            <p class="text-sm text-gray-500 flex items-center justify-center">
                <span class="mr-2">🔒</span>
                Incident référence : <strong><?= date('YmdHis') . '-' . substr(md5(uniqid()), 0, 8) ?></strong>
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
            const particles = document.querySelectorAll('[class*="bg-red-"], [class*="bg-orange-"], [class*="bg-yellow-"]');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            particles.forEach((particle, index) => {
                const speed = (index + 1) * 0.3;
                const xPos = x * speed;
                const yPos = y * speed;
                particle.style.transform = `translate(${xPos}px, ${yPos}px)`;
            });
        });

        // Auto-refresh après 60 secondes
        let countdown = 60;
        const countdownTimer = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                clearInterval(countdownTimer);
                if (confirm("Le serveur semble à nouveau disponible. Souhaitez-vous recharger la page ?")) {
                    window.location.reload();
                }
            }
        }, 1000);

        // Log de l'erreur côté client (pour debugging)
        console.error('Erreur serveur 500 détectée:', {
            timestamp: new Date().toISOString(),
            userAgent: navigator.userAgent,
            url: window.location.href,
            referrer: document.referrer
        });
    </script>
</body>
</html> 
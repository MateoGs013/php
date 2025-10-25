<?php
    require_once "clases/Secciones.php";

    $secciones_validas = Secciones::secciones_validas();
    $secciones_menu = Secciones::secciones_menu();

    $seccion = isset($_GET['seccion']) ? $_GET['seccion'] : 'inicio';
    if(!in_array($seccion, $secciones_validas)){
        $vista = '404';
    }else{
        $vista = $seccion;
    }
    $secciones = Secciones::cargarSeccionesDesdeJSON();
    $title_seccion = "";
    foreach ($secciones as $value) {
        if($value->getVinculo() == $vista){
            $title_seccion = $value->getTitulo();
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mystic Arcade Shop - Tu tienda retro de duendes mágicos con estética arcade. Descubre criaturas místicas con poderes únicos.">
    <meta name="keywords" content="duendes, magia, arcade, retro, místicos, tienda online">
    <meta name="author" content="Mystic Arcade Shop">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= $title_seccion ? $title_seccion . ' | ' : '' ?>Mystic Arcade Shop">
    <meta property="og:description" content="Descubre duendes mágicos con estética retro-arcade. Cada criatura viene con poderes únicos y garantía mística.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    
    <title><?= $title_seccion ? $title_seccion . ' | ' : '' ?>Mystic Arcade Shop - Duendes Mágicos Retro</title>
    
    <!-- Favicon -->
    <link rel="icon" href="data:text/plain;base64,8J+HjQ==" type="image/x-icon">
    
    <!-- Preload de fuentes críticas -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- CSS Framework -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="assets/styles/styles.css">
    
    <!-- Meta para tema de color -->
    <meta name="theme-color" content="#00f5ff">
    
    <!-- Prevención de FOUC (Flash of Unstyled Content) -->
    <style>
        /* Loading screen mientras carga la página */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #000000, #1a1a1a);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }
        
        .loading-screen.hidden {
            opacity: 0;
            pointer-events: none;
        }
        
        .retro-loader {
            width: 60px;
            height: 60px;
            border: 4px solid #00f5ff;
            border-top: 4px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(0, 245, 255, 0.5);
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading-text {
            font-family: 'Press Start 2P', monospace;
            font-size: 12px;
            color: #00f5ff;
            text-shadow: 0 0 10px rgba(0, 245, 255, 0.8);
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.5; }
        }
    </style>
</head>
<body class="pixel-font bg-dark-bg overflow-x-hidden">
    
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="retro-loader"></div>
        <div class="loading-text">CARGANDO MAGIA...</div>
        <div class="pixel-font text-neon-cyan text-xs mt-4">◄◄◄ INICIALIZANDO RETROWAVE ►►►</div>
    </div>
    
    <!-- Contenido Principal -->
    <div class="page-wrapper" style="opacity: 0; transition: opacity 0.5s ease-in;">
        
        <!-- Header -->
        <?php require_once "shared/header.php"; ?>
        
        <!-- Main Content -->
        <main class="main-content">
            <?php require_once "seccions/$vista.php"; ?>
        </main>
        
        <!-- Footer -->
        <?php require_once "shared/footer.php"; ?>
        
    </div>
    
    <!-- Efectos de partículas de fondo -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden" id="particles">
        <!-- Las partículas se generarán con JavaScript -->
    </div>
    
    <!-- Scripts -->
    <script>
        // Sistema de carga y efectos
        document.addEventListener('DOMContentLoaded', function() {
            // Detectar si hay errores PHP que impiden la carga
            const hasContent = document.querySelector('main .productos-container, main .hero-retrowave, main .form-retrowave, main .section-retrowave');
            
            // Si no hay contenido principal, mostrar error y reducir tiempo de carga
            const loadingTime = hasContent ? 1500 : 800;
            
            // Simular tiempo de carga
            setTimeout(function() {
                const loadingScreen = document.getElementById('loadingScreen');
                const pageWrapper = document.querySelector('.page-wrapper');
                
                // Ocultar loading
                if (loadingScreen) {
                    loadingScreen.classList.add('hidden');
                }
                
                // Mostrar contenido
                if (pageWrapper) {
                    pageWrapper.style.opacity = '1';
                }
                
                // Inicializar efectos solo si el contenido se cargó correctamente
                if (hasContent) {
                    initializeEffects();
                } else {
                    console.warn('Contenido no cargado completamente - Efectos limitados');
                }
                
            }, loadingTime);
        });
        
        // Fallback de seguridad - forzar mostrar contenido después de 3 segundos
        setTimeout(function() {
            const loadingScreen = document.getElementById('loadingScreen');
            const pageWrapper = document.querySelector('.page-wrapper');
            
            if (loadingScreen && !loadingScreen.classList.contains('hidden')) {
                console.log('Fallback: Forzando carga de página');
                loadingScreen.classList.add('hidden');
                if (pageWrapper) {
                    pageWrapper.style.opacity = '1';
                }
            }
        }, 3000);
        
        function initializeEffects() {
            // Crear partículas de fondo
            createParticles();
            
            // Efectos de scroll
            initializeScrollEffects();
            
            // Sonidos arcade (simulados)
            initializeArcadeSounds();
        }
        
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const colors = ['#ff006e', '#00f5ff', '#39ff14', '#ffff00'];
            
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: absolute;
                    width: 4px;
                    height: 4px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    border-radius: 50%;
                    opacity: 0.3;
                    animation: float ${5 + Math.random() * 10}s ease-in-out infinite;
                    left: ${Math.random() * 100}%;
                    top: ${Math.random() * 100}%;
                    box-shadow: 0 0 10px currentColor;
                `;
                particlesContainer.appendChild(particle);
            }
            
            // CSS para animación de partículas
            const style = document.createElement('style');
            style.textContent = `
                @keyframes float {
                    0%, 100% { transform: translateY(0px) translateX(0px); }
                    25% { transform: translateY(-20px) translateX(10px); }
                    50% { transform: translateY(-10px) translateX(-10px); }
                    75% { transform: translateY(-30px) translateX(5px); }
                }
            `;
            document.head.appendChild(style);
        }
        
        function initializeScrollEffects() {
            // Efecto parallax suave en elementos decorativos
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.parallax-element');
                
                parallaxElements.forEach(element => {
                    const speed = element.dataset.speed || 0.5;
                    element.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });
        }
        
        function initializeArcadeSounds() {
            // Simulación de sonidos arcade
            const buttons = document.querySelectorAll('.retro-btn');
            
            // Activar sonidos en botones retrowave
            const retroButtons = document.querySelectorAll('.retro-btn');
            retroButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    console.log('♪ Hover beep (retrowave)');
                });
                button.addEventListener('click', function() {
                    console.log('♪ Click sound (retrowave)');
                });
            });
        }
        
        // Manejo de errores globales
        window.addEventListener('error', function(e) {
            console.warn('Error capturado:', e.message);
        });
        
        // Performance observer
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.entryType === 'navigation') {
                        console.log('Tiempo de carga:', entry.loadEventEnd - entry.loadEventStart, 'ms');
                    }
                }
            });
            observer.observe({entryTypes: ['navigation']});
        }
    </script>
    
    <!-- Service Worker para PWA (opcional) -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                // navigator.registerServiceWorker('/sw.js');
                console.log('Service Worker ready (disabled)');
            });
        }
    </script>
    
</body>
</html>
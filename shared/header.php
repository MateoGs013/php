<?php
    require_once "clases/Secciones.php";
    $secciones = Secciones::secciones_menu();   
?>
<header class="nav-retrowave sticky top-0 z-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between relative z-10">
            <!-- Brand Arcade -->
            <a href="/" class="flex items-center gap-4 group" aria-label="Ir al inicio">
                <div class="relative">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-r from-purple-500 to-pink-500 border-3 border-black shadow-[4px_4px_0_#000] group-hover:shadow-[6px_6px_0_#000] transition-all duration-300">
                        <!-- Pixel art logo -->
                        <div class="pixel-font text-white text-lg">🧙</div>
                    </span>
                    <!-- Glow effect -->
                    <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-purple-500 to-pink-500 opacity-20 blur-md group-hover:opacity-40 transition-opacity duration-300"></div>
                </div>
                <div class="leading-tight">
                    <div class="nav-brand retro-font pixel-lg text-glow">
                        PIXEL GNOMES
                    </div>
                    <div class="pixel-font pixel-xs text-retro-gradient">
                        ◄ RETROWAVE 80s ►
                    </div>
                </div>
            </a>

            <!-- Desktop Navigation Arcade -->
            <nav class="hidden md:flex items-center gap-3">
                <?php foreach ($secciones as $seccion): ?>
                    <a href="?seccion=<?= $seccion; ?>"
                       class="nav-link pixel-font pixel-xs">
                        <?= strtoupper($seccion); ?>
                    </a>
                <?php endforeach; ?>
                
                <!-- Special Cart Button -->
                <a href="?seccion=carrito" class="retro-btn btn-purchase pixel-font pixel-xs ml-4 relative">
                    🛒 CARRITO
                    <span class="absolute -top-2 -right-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold border-2 border-black shadow-[2px_2px_0_#000]">
                        3
                    </span>
                </a>
            </nav>

            <!-- Mobile menu button -->
        <button type="button" 
            class="md:hidden retro-btn btn-preview pixel-font pixel-xs" 
                    aria-controls="mobile-menu" 
                    aria-expanded="false" 
                    onclick="toggleMobileMenu()">
                ☰ MENU
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-gradient-to-b from-transparent to-black/40 rounded-lg mt-2 backdrop-blur">
                <?php foreach ($secciones as $seccion): ?>
                    <a href="?seccion=<?= $seccion; ?>"
                       class="nav-link pixel-font pixel-xs block w-full text-center py-3 border-b border-transparent hover:border-pink-300">
                        <?= strtoupper($seccion); ?>
                    </a>
                <?php endforeach; ?>
                <a href="?seccion=carrito" class="retro-btn btn-purchase pixel-font pixel-xs w-full mt-4 text-center block">
                    🛒 CARRITO (3)
                </a>
            </div>
        </div>
    </div>

    <!-- Decorative scanlines -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="h-full w-full" style="background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,245,255,0.1) 2px, rgba(0,245,255,0.1) 4px);"></div>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
    
    // Add arcade effect
    if (!menu.classList.contains('hidden')) {
        menu.style.animation = 'slideDown 0.3s ease-out';
    }
}

// Add CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
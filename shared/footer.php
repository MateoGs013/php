<footer class="footer-arcade relative overflow-hidden">
	<!-- Animated background grid -->
	<div class="absolute inset-0 opacity-20">
		<div class="h-full w-full" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(57,255,20,0.1) 10px, rgba(57,255,20,0.1) 20px);"></div>
	</div>
	
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 relative z-10">
		<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
			
			<!-- Logo Section -->
			<div class="md:col-span-1">
				<div class="flex items-center gap-3 mb-4">
					<div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-r from-purple-500 to-pink-500 border-3 border-black shadow-[4px_4px_0_#000]">
						<div class="pixel-font text-white">🧙</div>
					</div>
					<div class="pixel-font pixel-md text-neon-green text-glow">
						MYSTIC ARCADE
					</div>
				</div>
				<p class="pixel-font pixel-xs text-white mb-4">
					TU TIENDA DE DUENDES MÁGICOS CON PODER ARCADE
				</p>
				<div class="pixel-font pixel-xs text-neon-yellow">
					◄ LEVEL UP YOUR LIFE ►
				</div>
			</div>

			<!-- Navigation Links -->
			<div class="footer-section">
				<h4 class="pixel-font pixel-sm text-neon-green mb-4">NAVEGACIÓN</h4>
				<ul class="space-y-2">
					<li><a href="?seccion=inicio" class="footer-link pixel-font pixel-xs">INICIO</a></li>
					<li><a href="?seccion=productos" class="footer-link pixel-font pixel-xs">PRODUCTOS</a></li>
					<li><a href="?seccion=catalogo" class="footer-link pixel-font pixel-xs">CATÁLOGO</a></li>
					<li><a href="?seccion=blog" class="footer-link pixel-font pixel-xs">BLOG</a></li>
					<li><a href="?seccion=nosotros" class="footer-link pixel-font pixel-xs">NOSOTROS</a></li>
					<li><a href="?seccion=contacto" class="footer-link pixel-font pixel-xs">CONTACTO</a></li>
				</ul>
			</div>

			<!-- Services -->
			<div class="footer-section">
				<h4 class="pixel-font pixel-sm text-neon-green mb-4">SERVICIOS</h4>
				<ul class="space-y-2">
					<li><a href="?seccion=carrito" class="footer-link pixel-font pixel-xs">CARRITO</a></li>
					<li><a href="?seccion=cuenta" class="footer-link pixel-font pixel-xs">MI CUENTA</a></li>
					<li><a href="?seccion=checkout" class="footer-link pixel-font pixel-xs">CHECKOUT</a></li>
					<li><span class="pixel-font pixel-xs text-neon-cyan">📞 SOPORTE 24/7</span></li>
					<li><span class="pixel-font pixel-xs text-neon-cyan">🚚 ENVÍO GRATIS</span></li>
					<li><span class="pixel-font pixel-xs text-neon-cyan">✨ GARANTÍA MÁGICA</span></li>
				</ul>
			</div>

			<!-- Social & Contact -->
			<div class="footer-section">
				<h4 class="pixel-font pixel-sm text-neon-green mb-4">CONECTA</h4>
				<div class="space-y-3 mb-6">
					<a href="#" class="btn-arc secondary pixel-font pixel-xs block text-center">
						📸 INSTAGRAM
					</a>
					<a href="#" class="btn-arc secondary pixel-font pixel-xs block text-center">
						🐦 TWITTER
					</a>
					<a href="#" class="btn-arc secondary pixel-font pixel-xs block text-center">
						📺 YOUTUBE
					</a>
				</div>
				<div class="pixel-font pixel-xs text-neon-yellow">
					<div class="mb-2">📧 INFO@MYSTICARE.COM</div>
					<div class="mb-2">📱 +54 11 MAGIC-00</div>
					<div>🏰 DUBLIN, IRELAND</div>
				</div>
			</div>
		</div>

		<!-- Bottom Section -->
		<div class="border-t-2 border-neon-green pt-6">
			<div class="flex flex-col md:flex-row items-center justify-between gap-4">
				<div class="pixel-font pixel-xs text-neon-cyan text-center md:text-left">
					© 2025 MYSTIC ARCADE SHOP - POWERED BY PHP & RETRO MAGIC
				</div>
				<div class="flex items-center gap-2">
					<span class="chip pixel-font pixel-xs">SECURE</span>
					<span class="badge pixel-font pixel-xs">VERIFIED</span>
					<span class="chip pixel-font pixel-xs">MAGICAL</span>
				</div>
			</div>
		</div>

		<!-- Decorative Elements -->
		<div class="absolute top-4 right-4 text-neon-pink text-2xl animate-pulse">
			★
		</div>
		<div class="absolute bottom-4 left-4 text-neon-yellow text-lg blink-decoration">
			◆
		</div>
		<div class="absolute top-1/2 left-1/4 text-neon-cyan text-xs opacity-50">
			▲
		</div>
		<div class="absolute top-1/3 right-1/3 text-neon-green text-xs opacity-50">
			●
		</div>
	</div>

	<!-- Scanline effect -->
	<div class="absolute inset-0 opacity-5 pointer-events-none">
		<div class="h-full w-full" style="background: repeating-linear-gradient(0deg, transparent, transparent 1px, rgba(0,245,255,0.2) 1px, rgba(0,245,255,0.2) 2px);"></div>
	</div>
</footer>

<style>
/* Additional footer animations */
@keyframes footerGlow {
    0%, 100% { text-shadow: 0 0 5px currentColor; }
    50% { text-shadow: 0 0 20px currentColor, 0 0 30px currentColor; }
}

.footer-arcade h4 {
    animation: footerGlow 3s ease-in-out infinite;
}

.footer-arcade .decorative-star {
    animation: spin 10s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

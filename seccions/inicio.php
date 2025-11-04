<?php
	// Hero principal usando el título de la sección definido en index.php
	$hero_titulo = isset($title_seccion) ? $title_seccion : 'INICIO';
	
	// Cargar algunos duendes destacados para mostrar
	require_once 'clases/Duendes.php';
	$duendes = Duendes::todosDuendes();
	$duendesDestacados = array_slice($duendes, 0, 3); // Primeros 3 duendes
?>

<div class="page-container retro-bg retro-grid">
	<!-- Hero Section Arcade -->
	<section class="hero-arcade">
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
			<div class="text-center">
				<!-- Título principal con efectos -->
				<h1 class="hero-title pixel-font text-glow mb-6">
					MYSTIC ARCADE SHOP
				</h1>
				
				<!-- Subtítulo -->
				<p class="hero-subtitle pixel-font max-w-3xl mx-auto mb-8">
					◄◄◄ DESCUBRE DUENDES MÁGICOS CON PODER RETRO ►►►
				</p>
				
				<!-- Call to action buttons -->
				<div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
					<a href="?seccion=productos" class="btn-arc primary pixel-font pixel-md px-8 py-4">
						🎮 EXPLORAR TIENDA
					</a>
					<a href="?seccion=catalogo" class="btn-arc secondary pixel-font pixel-md px-8 py-4">
						📚 VER CATÁLOGO
					</a>
				</div>

				<!-- Stats arcade -->
				<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
					<div class="form-arcade text-center">
						<div class="pixel-font pixel-xl text-neon-pink text-glow mb-2">20+</div>
						<div class="pixel-font pixel-sm text-neon-cyan">DUENDES ÚNICOS</div>
					</div>
					<div class="form-arcade text-center">
						<div class="pixel-font pixel-xl text-neon-green text-glow mb-2">100%</div>
						<div class="pixel-font pixel-sm text-neon-yellow">MAGIA GARANTIZADA</div>
					</div>
					<div class="form-arcade text-center">
						<div class="pixel-font pixel-xl text-neon-cyan text-glow mb-2">24/7</div>
						<div class="pixel-font pixel-sm text-neon-pink">SOPORTE MÍSTICO</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Floating decorative elements -->
		<div class="absolute top-20 left-10 text-4xl text-neon-pink opacity-70 animate-pulse">★</div>
		<div class="absolute bottom-20 right-10 text-3xl text-neon-green opacity-70 blink-decoration">◆</div>
		<div class="absolute top-1/3 right-20 text-2xl text-neon-yellow opacity-50">▲</div>
		<div class="absolute bottom-1/3 left-20 text-2xl text-neon-cyan opacity-50">●</div>
	</section>

	<!-- Featured Products Section -->
	<section class="section-arcade">
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="text-center mb-12">
				<h2 class="section-title pixel-font pixel-lg">
					DUENDES DESTACADOS
				</h2>
				<p class="pixel-font pixel-sm text-neon-yellow mt-4">
					◄ LOS MÁS POPULARES DE LA ARCADE ►
				</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<?php foreach ($duendesDestacados as $duende): ?>
					<div class="card">
						<div class="card__content">
							<div class="flex items-center justify-between gap-2 mb-3">
								<span class="badge pixel-font pixel-xs"><?= strtoupper($duende->getRareza()) ?></span>
								<span class="chip pixel-font pixel-xs">⭐ TOP</span>
							</div>
							
							<div class="mb-4">
								<img src="<?= $duende->getImagenUrl() ?>" 
									 alt="<?= $duende->getNombre() ?>" 
									 class="duende-img w-full h-32 object-contain" />
							</div>
							
							<h3 class="pixel-font pixel-md text-neon-cyan text-glow mb-3 text-center">
								<?= strtoupper($duende->getNombre()) ?>
							</h3>
							
							<div class="text-center mb-4">
								<p class="pixel-font pixel-lg precio-oro">
									<?= $duende->getPrecioEnOro() ?> ORO
								</p>
							</div>
							
							<div class="flex gap-2 justify-center">
								<a href="?seccion=detalle_producto&id=<?= $duende->getId() ?>" 
								   class="btn-arc primary pixel-font pixel-xs">
									👁️ VER
								</a>
								<button class="btn-arc secondary pixel-font pixel-xs">
									+ AGREGAR
								</button>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			
			<div class="text-center mt-12">
				<a href="?seccion=productos" class="btn-arc primary pixel-font pixel-md px-8 py-4">
					🎯 VER TODOS LOS DUENDES
				</a>
			</div>
		</div>
	</section>

	<!-- Features Section -->
	<section class="section-arcade bg-dark-arcade">
		<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="text-center mb-12">
				<h2 class="section-title pixel-font pixel-lg">
					¿POR QUÉ MYSTIC ARCADE?
				</h2>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
				<div class="form-arcade text-center h-full">
					<div class="text-4xl mb-4">🎮</div>
					<h3 class="pixel-font pixel-md text-neon-cyan mb-3">ESTÉTICA RETRO</h3>
					<p class="pixel-font pixel-xs text-white">
						DISEÑO INSPIRADO EN LOS CLÁSICOS ARCADE DE LOS 80S
					</p>
				</div>
				
				<div class="form-arcade text-center h-full">
					<div class="text-4xl mb-4">✨</div>
					<h3 class="pixel-font pixel-md text-neon-green mb-3">MAGIA REAL</h3>
					<p class="pixel-font pixel-xs text-white">
						CADA DUENDE VIENE CON PODERES GENUINOS Y CERTIFICADOS
					</p>
				</div>
				
				<div class="form-arcade text-center h-full">
					<div class="text-4xl mb-4">🚚</div>
					<h3 class="pixel-font pixel-md text-neon-yellow mb-3">ENVÍO MÁGICO</h3>
					<p class="pixel-font pixel-xs text-white">
						TELETRANSPORTE INSTANTÁNEO A CUALQUIER DIMENSIÓN
					</p>
				</div>
				
				<div class="form-arcade text-center h-full">
					<div class="text-4xl mb-4">🛡️</div>
					<h3 class="pixel-font pixel-md text-neon-pink mb-3">GARANTÍA TOTAL</h3>
					<p class="pixel-font pixel-xs text-white">
						30 DÍAS PARA DEVOLVER SI NO TE TRAE SUERTE
					</p>
				</div>
			</div>
		</div>
	</section>

	<!-- Newsletter Section -->
	<section class="section-arcade">
		<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
			<div class="form-arcade text-center">
				<h2 class="pixel-font pixel-lg text-neon-cyan text-glow mb-4">
					ÚNETE AL ARCADE CLUB
				</h2>
				<p class="pixel-font pixel-sm text-white mb-6">
					RECIBE NOTIFICACIONES SOBRE NUEVOS DUENDES Y OFERTAS ESPECIALES
				</p>
				
				<div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
					<input type="email" 
						   placeholder="TU EMAIL MÁGICO..." 
						   class="input-arcade flex-1">
					<button class="btn-arc primary pixel-font pixel-sm px-6">
						🔔 SUSCRIBIR
					</button>
				</div>
				
				<div class="pixel-font pixel-xs text-neon-yellow mt-4">
					◄ ¡OBTÉN 10% DE DESCUENTO EN TU PRIMERA COMPRA! ►
				</div>
			</div>
		</div>
	</section>
</div>

<script>
// Efectos adicionales para la página de inicio
document.addEventListener('DOMContentLoaded', function() {
	// Agregar efecto de escritura al título principal
	const heroTitle = document.querySelector('.hero-title');
	if (heroTitle) {
		heroTitle.style.borderRight = '3px solid var(--neon-cyan)';
		heroTitle.style.animation = 'typing 3s steps(20) 1s both, blink 1s infinite';
	}
	
	// Floating animation para elementos decorativos
	const floatingElements = document.querySelectorAll('.hero-arcade .absolute');
	floatingElements.forEach((el, index) => {
		el.style.animation = `float 3s ease-in-out infinite ${index * 0.5}s`;
	});
});

// CSS adicional para efectos
const additionalStyles = document.createElement('style');
additionalStyles.textContent = `
	@keyframes typing {
		from { width: 0; }
		to { width: 100%; }
	}
	
	@keyframes float {
		0%, 100% { transform: translateY(0px); }
		50% { transform: translateY(-10px); }
	}
	
	.hero-title {
		white-space: nowrap;
		overflow: hidden;
	}
`;
document.head.appendChild(additionalStyles);
</script>

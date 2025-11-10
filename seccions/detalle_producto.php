<?php
	require_once 'clases/Duendes.php';
	$duendes = Duendes::todosDuendes();
	$id = isset($_GET['id']) ? intval($_GET['id']) : null;
	$duende = null;
	foreach ($duendes as $d) {
		// Convertir id del objeto a entero antes de comparar. PDO suele devolver columnas como strings,
		// así que la comparación estricta (===) puede fallar aunque los valores sean iguales.
		if ($d->getId() == $id) { $duende = $d; break; }
	}
	// Duendes relacionados (misma rareza o tipo)
	$duendesRelacionados = [];
	if ($duende) {
		$duendesRelacionados = array_filter($duendes, function($d) use ($duende) {
			return $d->getId() !== $duende->getId() && 
				   ($d->getRareza() === $duende->getRareza() || $d->getTipo() === $duende->getTipo());
		});
		$duendesRelacionados = array_slice($duendesRelacionados, 0, 3);
	}
	
?>

<div class="page-container retro-bg retro-grid">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
		
		<!-- Breadcrumb -->
		<div class="breadcrumb-arcade pixel-font pixel-xs mb-8">
			<a href="?seccion=inicio">INICIO</a>
			<span class="breadcrumb-separator">▶</span>
			<a href="?seccion=catalogo">CATÁLOGO</a>
			<span class="breadcrumb-separator">▶</span>
			<span class="text-neon-cyan">
				<?= $duende ? strtoupper($duende->getNombre()) : 'PRODUCTO NO ENCONTRADO' ?>
			</span>
		</div>

		<?php if ($duende): ?>
			<!-- Producto Principal -->
			<div class="grid lg:grid-cols-2 gap-12 mb-16">
				
				<!-- Galería de Imagen -->
				<div class="space-y-6">
					<div class="form-arcade aspect-square">
						<img src="<?= htmlspecialchars($duende->getImagenUrl()); ?>" 
							 alt="<?= htmlspecialchars($duende->getNombre()); ?>" 
							 class="w-full h-full object-contain border-4 border-neon-cyan rounded-lg duende-img" 
							 id="mainImage"/>
					</div>
					
					<!-- Mini galería (simulada) -->
					<div class="flex gap-4 justify-center">
						<div class="w-20 h-20 border-3 border-neon-cyan rounded-lg overflow-hidden cursor-pointer opacity-60 hover:opacity-100 transition-opacity">
							<img src="<?= htmlspecialchars($duende->getImagenUrl()); ?>" 
								 alt="Vista 1" 
								 class="w-full h-full object-contain"/>
						</div>
						<div class="w-20 h-20 border-3 border-neon-green rounded-lg bg-dark-arcade flex items-center justify-center opacity-60 hover:opacity-100 transition-opacity cursor-pointer">
							<span class="pixel-font pixel-xs text-neon-green">360°</span>
						</div>
						<div class="w-20 h-20 border-3 border-neon-pink rounded-lg bg-dark-arcade flex items-center justify-center opacity-60 hover:opacity-100 transition-opacity cursor-pointer">
							<span class="pixel-font pixel-xs text-neon-pink">AR</span>
						</div>
					</div>
				</div>

				<!-- Información del Producto -->
				<div class="space-y-6">
					
					<!-- Header con título y badges -->
					<div>
						<div class="flex items-center gap-3 mb-4">
							<span class="badge pixel-font pixel-sm"><?= strtoupper($duende->getRareza()) ?></span>
							<?php if ($duende->isDisponible()): ?>
								<span class="chip pixel-font pixel-sm">✅ DISPONIBLE</span>
							<?php else: ?>
								<span class="alert-arcade alert-error pixel-font pixel-sm inline-block">❌ AGOTADO</span>
							<?php endif; ?>
						</div>
						
						<h1 class="pixel-font pixel-xl text-neon-cyan text-glow mb-4">
							<?= strtoupper(htmlspecialchars($duende->getNombre())) ?>
						</h1>
						
						<div class="pixel-font pixel-md text-neon-green mb-2">
							🧙 <?= strtoupper(htmlspecialchars($duende->getTipo())) ?>
						</div>
						
						<div class="text-center bg-dark-arcade border-3 border-coin-gold rounded-lg p-6 mb-6">
							<div class="pixel-font text-4xl precio-oro text-glow">
								<?= number_format($duende->getPrecioEnOro(), 1) ?> ORO
							</div>
							<div class="pixel-font pixel-xs text-neon-yellow mt-2">
								◄ PRECIO ESPECIAL ARCADE ►
							</div>
						</div>
					</div>

					<!-- Descripción -->
					<div class="form-arcade">
						<h3 class="pixel-font pixel-md text-neon-green mb-4">📜 DESCRIPCIÓN</h3>
						<p class="pixel-font pixel-sm text-white leading-relaxed">
							<?= nl2br(htmlspecialchars($duende->getDescripcion())) ?>
						</p>
					</div>

					<!-- Estadísticas -->
					<div class="form-arcade">
						<h3 class="pixel-font pixel-md text-neon-green mb-4">⚡ ESTADÍSTICAS</h3>
						<div class="grid grid-cols-2 gap-4">
							<div class="bg-dark-arcade border-2 border-neon-cyan rounded p-3">
								<div class="pixel-font pixel-xs text-neon-cyan mb-1">ALTURA</div>
								<div class="pixel-font pixel-md text-white"><?= $duende->getAlturaCm() ?> CM</div>
							</div>
							<div class="bg-dark-arcade border-2 border-neon-green rounded p-3">
								<div class="pixel-font pixel-xs text-neon-green mb-1">SUERTE</div>
								<div class="pixel-font pixel-md text-white"><?= $duende->getNivelDeSuerte() ?>/10</div>
							</div>
							<div class="bg-dark-arcade border-2 border-neon-pink rounded p-3">
								<div class="pixel-font pixel-xs text-neon-pink mb-1">MALDAD</div>
								<div class="pixel-font pixel-md text-white"><?= $duende->getNivelDeMaldad() ?>/10</div>
							</div>
							<div class="bg-dark-arcade border-2 border-neon-yellow rounded p-3">
								<div class="pixel-font pixel-xs text-neon-yellow mb-1">POPULARIDAD</div>
								<div class="pixel-font pixel-md text-white"><?= $duende->getPopularidad() ?>%</div>
							</div>
						</div>
					</div>

					<!-- Información detallada -->
					<div class="form-arcade">
						<h3 class="pixel-font pixel-md text-neon-green mb-4">🔮 INFORMACIÓN MÁGICA</h3>
						<div class="space-y-3">
							<div class="flex justify-between">
								<span class="pixel-font pixel-xs text-neon-cyan">ELEMENTO:</span>
								<span class="pixel-font pixel-xs text-white"><?= strtoupper($duende->getAfinidadElemental()) ?></span>
							</div>
							<div class="flex justify-between">
								<span class="pixel-font pixel-xs text-neon-cyan">ORIGEN:</span>
								<span class="pixel-font pixel-xs text-white"><?= strtoupper($duende->getOrigenMitologico()) ?></span>
							</div>
							<div class="flex justify-between">
								<span class="pixel-font pixel-xs text-neon-cyan">MATERIAL:</span>
								<span class="pixel-font pixel-xs text-white"><?= strtoupper($duende->getMaterialPrincipal()) ?></span>
							</div>
							<div class="flex justify-between">
								<span class="pixel-font pixel-xs text-neon-cyan">RECOMENDADO PARA:</span>
								<span class="pixel-font pixel-xs text-white"><?= strtoupper($duende->getRecomendadoPara()) ?></span>
							</div>
						</div>
					</div>

					<!-- Efectos mágicos -->
					<div class="form-arcade">
						<h3 class="pixel-font pixel-md text-neon-green mb-4">✨ EFECTO MÁGICO</h3>
						<div class="bg-dark-arcade border-2 border-neon-purple rounded-lg p-4">
							<p class="pixel-font pixel-sm text-neon-purple text-glow text-center">
								<?= strtoupper(htmlspecialchars($duende->getEfectoMagico())) ?>
							</p>
						</div>
					</div>

					<!-- Advertencias -->
					<?php if ($duende->getAdvertencias()): ?>
						<div class="alert-arcade alert-warning">
							<div class="pixel-font pixel-xs">
								⚠️ ADVERTENCIA: <?= strtoupper(htmlspecialchars($duende->getAdvertencias())) ?>
							</div>
						</div>
					<?php endif; ?>

					<!-- Botones de acción -->
					<div class="space-y-4">
						<?php if ($duende->isDisponible()): ?>
							<form method="post" action="?seccion=carrito" class="space-y-4">
								<input type="hidden" name="id" value="<?= htmlspecialchars($duende->getId()); ?>"/>
								<input type="hidden" name="accion" value="agregar"/>
								
								<div class="flex gap-3">
									<button type="submit" class="btn-arc primary pixel-font pixel-md flex-1 py-4">
										🛒 ADOPTAR DUENDE
									</button>
									<button type="button" class="btn-arc secondary pixel-font pixel-md px-6 py-4">
										❤️ FAVORITO
									</button>
								</div>
							</form>
						<?php else: ?>
							<div class="alert-arcade alert-error text-center">
								<div class="pixel-font pixel-md">
									😔 DUENDE NO DISPONIBLE
								</div>
							</div>
						<?php endif; ?>
						
						<div class="flex gap-3">
							<button class="btn-arc secondary pixel-font pixel-sm flex-1">
								📤 COMPARTIR
							</button>
							<button class="btn-arc secondary pixel-font pixel-sm flex-1">
								📋 COMPARAR
							</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Duendes Relacionados -->
			<?php if (count($duendesRelacionados) > 0): ?>
				<div class="section-arcade">
					<h2 class="section-title pixel-font pixel-lg mb-8">
						DUENDES RELACIONADOS
					</h2>
					
					<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
						<?php foreach ($duendesRelacionados as $relacionado): ?>
							<div class="card">
								<div class="card__content">
									<div class="flex items-center justify-between gap-2 mb-3">
										<span class="badge pixel-font pixel-xs"><?= strtoupper($relacionado->getRareza()) ?></span>
									</div>
									
									<div class="mb-4">
										<img src="<?= $relacionado->getImagenUrl() ?>" 
											 alt="<?= $relacionado->getNombre() ?>" 
											 class="duende-img w-full h-24 object-contain" />
									</div>
									
									<h3 class="pixel-font pixel-sm text-neon-cyan text-glow mb-2 text-center">
										<?= strtoupper($relacionado->getNombre()) ?>
									</h3>
									
									<div class="text-center mb-3">
										<p class="pixel-font pixel-md precio-oro">
											<?= $relacionado->getPrecioEnOro() ?> ORO
										</p>
									</div>
									
									<div class="flex gap-2 justify-center">
										<a href="?seccion=detalle_producto&id=<?= $relacionado->getId() ?>" 
										   class="btn-arc primary pixel-font pixel-xs">
											👁️ VER
										</a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		<?php else: ?>
			<!-- Producto no encontrado -->
			<div class="text-center py-20">
				<div class="form-arcade max-w-md mx-auto">
					<div class="text-8xl mb-6">😵</div>
					<h1 class="pixel-font pixel-xl text-neon-cyan text-glow mb-4">
						DUENDE NO ENCONTRADO
					</h1>
					<p class="pixel-font pixel-md text-white mb-8">
						EL DUENDE QUE BUSCAS SE HA DESVANECIDO EN LA NIEBLA...
					</p>
					<a href="?seccion=catalogo" class="btn-arc primary pixel-font pixel-md">
						🔍 EXPLORAR CATÁLOGO
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<script>
// Efectos interactivos para la página de detalle
document.addEventListener('DOMContentLoaded', function() {
	// Efecto hover en imagen principal
	const mainImage = document.getElementById('mainImage');
	if (mainImage) {
		mainImage.addEventListener('mouseenter', function() {
			this.style.transform = 'scale(1.05)';
			this.style.transition = 'transform 0.3s ease';
		});
		
		mainImage.addEventListener('mouseleave', function() {
			this.style.transform = 'scale(1)';
		});
	}
	
	// Animación de estadísticas al scroll
	const stats = document.querySelectorAll('.form-arcade .grid > div');
	const observer = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				entry.target.style.animation = 'statsPulse 0.6s ease-out';
			}
		});
	});
	
	stats.forEach(stat => {
		observer.observe(stat);
	});
	
	// CSS para animaciones
	const style = document.createElement('style');
	style.textContent = `
		@keyframes statsPulse {
			0% { transform: scale(0.9); opacity: 0; }
			50% { transform: scale(1.05); }
			100% { transform: scale(1); opacity: 1; }
		}
	`;
	document.head.appendChild(style);
});
</script>

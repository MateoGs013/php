<?php
require_once 'clases/Duendes.php';
$duendes = Duendes::cargarDuendesDesdeJSON();
?>

<div class="productos-container retro-bg retro-grid">
	<div class="productos-content">
		<!-- Título arcade principal -->
		<div class="text-center mb-16">
			<h1 class="arcade-title pixel-font pixel-2xl text-glow inline-block">
				DUENDES ARCADE
			</h1>
			<div class="pixel-font pixel-sm text-neon-cyan text-center mt-4">
				◄◄◄ SELECCIONA TU COMPAÑERO MÁGICO ►►►
			</div>
		</div>

		<!-- Grid de productos -->
		<div class="cards">
			<?php foreach ($duendes as $d): ?>
				<div class="card" aria-labelledby="duende-<?= $d->getId() ?>-title" aria-describedby="duende-<?= $d->getId() ?>-desc">
					<div class="card__content">
						<!-- Header con badges -->
						<div class="flex items-center justify-between gap-2 mb-3">
							<span class="badge pixel-font pixel-xs"><?= strtoupper($d->getRareza()) ?></span>
							<span class="chip pixel-font pixel-xs blink-decoration">★ POPULAR</span>
						</div>

						<!-- Imagen del duende -->
						<div class="mb-4">
							<img src="<?= $d->getImagenUrl() ?>"
								alt="<?= $d->getNombre() ?>"
								class="duende-img w-full h-32 object-contain" />
						</div>

						<!-- Nombre del duende -->
						<h3 id="duende-<?= $d->getId() ?>-title" class="pixel-font pixel-md text-neon-cyan text-glow mb-3 text-center">
							<?= strtoupper($d->getNombre()) ?>
						</h3>

						<!-- Precio -->
						<div class="text-center mb-4">
							<p class="pixel-font pixel-lg precio-oro">
								<?= $d->getPrecioEnOro() ?> ORO
							</p>
						</div>

						<!-- Información del duende -->
						<div id="duende-<?= $d->getId() ?>-desc" class="duende-info pixel-font pixel-xs text-center mb-4 space-y-1">
							<div class="text-neon-green">
								⚡ <?= $d->getAlturaCm() ?>CM
							</div>
							<div class="text-neon-yellow">
								🎯 <?= strtoupper($d->getRecomendadoPara()) ?>
							</div>
							<div class="text-neon-pink">
								🏛️ <?= strtoupper($d->getOrigenMitologico()) ?>
							</div>
						</div>

						<!-- Botones de acción -->
						<div class="flex gap-2 justify-center">
							<button class="btn-arc secondary pixel-font pixel-xs"
								onclick="agregarAlCarrito(<?= $d->getId() ?>)">
								+ AGREGAR
							</button>
							<button class="btn-arc primary pixel-font pixel-xs"
								onclick="verDetalles(<?= $d->getId() ?>)">
								👁️ VER
							</button>
						</div>

						<!-- Efecto disponibilidad -->
						<?php if (!$d->isDisponible()): ?>
							<div class="soldout-mini">
								<div class="label pixel-font pixel-xs">
									AGOTADO
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Footer decorativo -->
		<div class="text-center mt-16">
			<div class="pixel-font pixel-sm text-neon-cyan text-glow">
				◄◄◄ GAME OVER... O GAME START? ►►►
			</div>
		</div>
	</div>
</div>

<script>
	// Funciones JavaScript para interactividad
	function agregarAlCarrito(duendeId) {
		// Aquí iría la lógica para agregar al carrito
		console.log('Agregando duende ID:', duendeId, 'al carrito');

		// Efecto visual
		const button = event.target;
		const originalText = button.textContent;
		button.textContent = '✓ AGREGADO';
		button.style.background = 'linear-gradient(45deg, var(--neon-green), #22c55e)';

		setTimeout(() => {
			button.textContent = originalText;
			button.style.background = '';
		}, 2000);
	}

	function verDetalles(duendeId) {
		// Aquí iría la lógica para mostrar detalles
		console.log('Viendo detalles del duende ID:', duendeId);

		// Efecto visual
		const button = event.target;
		button.style.transform = 'scale(0.95)';
		setTimeout(() => {
			button.style.transform = '';
		}, 150);
	}

	// Efectos de sonido simulados (opcional)
	document.addEventListener('DOMContentLoaded', function() {
		// Agregar sonidos de hover a las cartas
		const cards = document.querySelectorAll('.card');
		cards.forEach(card => {
			card.addEventListener('mouseenter', function() {
				// Aquí se podría agregar un sonido de hover
				console.log('♪ Hover sound effect');
			});
		});
	});
</script>
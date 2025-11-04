<?php
	if (session_status() === PHP_SESSION_NONE) { session_start(); }
	require_once 'clases/Duendes.php';
	$duendes = Duendes::todosDuendes();

	// Index duendes by id for quick lookup
	$byId = [];
	foreach ($duendes as $d) { 
		$id = $d->getId();
		if ($id !== null) {
			$byId[$id] = $d; 
		}
	}

	// Handle cart actions
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$accion = $_POST['accion'] ?? '';
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		if ($accion === 'agregar' && isset($byId[$id])) {
			$_SESSION['cart'] = $_SESSION['cart'] ?? [];
			$_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
		}
		if ($accion === 'eliminar') {
			if (isset($_SESSION['cart'][$id])) { unset($_SESSION['cart'][$id]); }
		}
		if ($accion === 'actualizar_cantidad') {
			$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
			if ($cantidad > 0 && isset($_SESSION['cart'][$id])) {
				$_SESSION['cart'][$id] = $cantidad;
			}
		}
		if ($accion === 'vaciar') {
			$_SESSION['cart'] = [];
		}
	}

	$cart = $_SESSION['cart'] ?? [];
	$total = 0;
	$totalItems = 0;
?>

<div class="page-container retro-bg retro-grid">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
		
		<!-- Título Arcade -->
		<div class="text-center mb-12">
			<h1 class="arcade-title pixel-font pixel-2xl text-glow inline-block">
				🛒 CARRITO ARCADE
			</h1>
			<div class="pixel-font pixel-sm text-neon-cyan text-center mt-4">
				◄◄◄ TUS DUENDES SELECCIONADOS ►►►
			</div>
		</div>

		<div class="grid lg:grid-cols-3 gap-8">
			
			<!-- Lista de productos en el carrito -->
			<div class="lg:col-span-2">
				<div class="form-arcade">
					<div class="flex items-center justify-between mb-6">
						<h2 class="pixel-font pixel-lg text-neon-green">
							📦 PRODUCTOS EN CARRITO
						</h2>
						<?php if (!empty($cart)): ?>
							<form method="post" action="?seccion=carrito" class="inline">
								<input type="hidden" name="accion" value="vaciar"/>
								<button type="submit" class="btn-arc secondary pixel-font pixel-xs" 
										onclick="return confirm('¿Estás seguro de vaciar el carrito?')">
									🗑️ VACIAR TODO
								</button>
							</form>
						<?php endif; ?>
					</div>

					<?php if (!empty($cart)): ?>
						<div class="space-y-4">
							<?php foreach ($cart as $id => $qty): ?>
								<?php if (!isset($byId[$id])) continue; 
								$item = $byId[$id]; 
								$line = $item->getPrecioEnOro() * $qty; 
								$total += $line;
								$totalItems += $qty; ?>
								
								<div class="table-arcade overflow-hidden">
									<div class="p-4">
										<div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
											
											<!-- Imagen y detalles del producto -->
											<div class="md:col-span-2 flex items-center gap-4">
												<div class="w-20 h-20 border-3 border-neon-cyan rounded-lg overflow-hidden flex-shrink-0">
													<img src="<?= htmlspecialchars($item->getImagenUrl()); ?>" 
														 alt="<?= htmlspecialchars($item->getNombre()); ?>" 
														 class="w-full h-full object-contain"/>
												</div>
												<div class="flex-1 min-w-0">
													<h3 class="pixel-font pixel-md text-neon-cyan text-glow mb-2">
														<?= strtoupper(htmlspecialchars($item->getNombre())) ?>
													</h3>
													<div class="pixel-font pixel-xs text-neon-green mb-1">
														🧙 <?= strtoupper(htmlspecialchars($item->getTipo())) ?>
													</div>
													<div class="pixel-font pixel-xs text-neon-yellow">
														⭐ <?= strtoupper(htmlspecialchars($item->getRareza())) ?>
													</div>
													<div class="pixel-font pixel-sm text-coin-gold mt-2">
														<?= number_format($item->getPrecioEnOro(), 1) ?> ORO c/u
													</div>
												</div>
											</div>
											
											<!-- Cantidad -->
											<div class="text-center">
												<div class="pixel-font pixel-xs text-neon-cyan mb-2">CANTIDAD</div>
												<form method="post" action="?seccion=carrito" class="flex items-center justify-center gap-2">
													<input type="hidden" name="id" value="<?= intval($id) ?>"/>
													<input type="hidden" name="accion" value="actualizar_cantidad"/>
													<input type="number" 
														   name="cantidad" 
														   value="<?= intval($qty) ?>" 
														   min="1" 
														   max="10"
														   class="input-arcade w-20 text-center" 
														   onchange="this.form.submit()"/>
												</form>
											</div>
											
											<!-- Subtotal y acciones -->
											<div class="text-center">
												<div class="pixel-font pixel-md precio-oro text-glow mb-3">
													<?= number_format($line, 1) ?> ORO
												</div>
												<form method="post" action="?seccion=carrito" class="inline">
													<input type="hidden" name="id" value="<?= intval($id) ?>"/>
													<input type="hidden" name="accion" value="eliminar"/>
													<button type="submit" class="btn-arc secondary pixel-font pixel-xs">
														❌ ELIMINAR
													</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						
						<!-- Continuar comprando -->
						<div class="text-center mt-8">
							<a href="?seccion=catalogo" class="btn-arc secondary pixel-font pixel-md">
								🔍 SEGUIR COMPRANDO
							</a>
						</div>
						
					<?php else: ?>
						<!-- Carrito vacío -->
						<div class="text-center py-12">
							<div class="text-8xl mb-6">🛒</div>
							<h3 class="pixel-font pixel-lg text-neon-cyan text-glow mb-4">
								CARRITO VACÍO
							</h3>
							<p class="pixel-font pixel-md text-white mb-8">
								¡NO HAS SELECCIONADO NINGÚN DUENDE AÚN!
							</p>
							<a href="?seccion=catalogo" class="btn-arc primary pixel-font pixel-md">
								🎮 EXPLORAR DUENDES
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Resumen del pedido -->
			<div class="lg:col-span-1">
				<div class="form-arcade sticky top-24">
					<h2 class="pixel-font pixel-lg text-neon-green text-glow mb-6 text-center">
						💰 RESUMEN ARCADE
					</h2>
					
					<!-- Estadísticas del carrito -->
					<div class="space-y-4 mb-6">
						<div class="flex justify-between items-center py-2 border-b border-neon-cyan border-opacity-30">
							<span class="pixel-font pixel-sm text-neon-cyan">ITEMS:</span>
							<span class="pixel-font pixel-sm text-white"><?= $totalItems ?></span>
						</div>
						<div class="flex justify-between items-center py-2 border-b border-neon-cyan border-opacity-30">
							<span class="pixel-font pixel-sm text-neon-cyan">SUBTOTAL:</span>
							<span class="pixel-font pixel-sm precio-oro"><?= number_format($total, 1) ?> ORO</span>
						</div>
						<div class="flex justify-between items-center py-2 border-b border-neon-cyan border-opacity-30">
							<span class="pixel-font pixel-sm text-neon-cyan">ENVÍO MÁGICO:</span>
							<span class="pixel-font pixel-sm text-neon-green">GRATIS ✨</span>
						</div>
						<div class="flex justify-between items-center py-2 border-b border-neon-cyan border-opacity-30">
							<span class="pixel-font pixel-sm text-neon-cyan">DESCUENTO ARCADE:</span>
							<span class="pixel-font pixel-sm text-neon-green">-5% 🎮</span>
						</div>
					</div>
					
					<!-- Total final -->
					<div class="bg-dark-arcade border-3 border-coin-gold rounded-lg p-4 mb-6">
						<div class="text-center">
							<div class="pixel-font pixel-xs text-neon-yellow mb-2">TOTAL FINAL</div>
							<div class="pixel-font text-3xl precio-oro text-glow">
								<?= number_format($total * 0.95, 1) ?> ORO
							</div>
							<div class="pixel-font pixel-xs text-neon-green mt-2">
								(INCLUYE DESCUENTO ARCADE)
							</div>
						</div>
					</div>
					
					<!-- Cupón de descuento -->
					<div class="mb-6">
						<label class="label-arcade pixel-font pixel-xs mb-2">
							🎫 CÓDIGO PROMOCIONAL
						</label>
						<div class="flex gap-2">
							<input type="text" 
								   placeholder="CÓDIGO..." 
								   class="input-arcade flex-1"/>
							<button class="btn-arc secondary pixel-font pixel-xs">
								✓
							</button>
						</div>
					</div>
					
					<!-- Botón de checkout -->
					<?php if (!empty($cart)): ?>
						<a href="?seccion=checkout" class="btn-arc primary pixel-font pixel-md w-full text-center block py-4 mb-4">
							🚀 FINALIZAR COMPRA
						</a>
						
						<!-- Métodos de pago aceptados -->
						<div class="text-center">
							<div class="pixel-font pixel-xs text-neon-cyan mb-2">MÉTODOS DE PAGO</div>
							<div class="flex justify-center gap-2">
								<span class="chip pixel-font pixel-xs">💳 VISA</span>
								<span class="chip pixel-font pixel-xs">🪙 CRYPTO</span>
								<span class="chip pixel-font pixel-xs">✨ MAGIA</span>
							</div>
						</div>
					<?php else: ?>
						<div class="alert-arcade alert-warning text-center">
							<div class="pixel-font pixel-sm">
								AGREGA DUENDES PARA CONTINUAR
							</div>
						</div>
					<?php endif; ?>
					
					<!-- Garantías -->
					<div class="mt-6 space-y-2">
						<div class="flex items-center gap-2">
							<span class="text-neon-green">✓</span>
							<span class="pixel-font pixel-xs text-white">ENVÍO INSTANTÁNEO</span>
						</div>
						<div class="flex items-center gap-2">
							<span class="text-neon-green">✓</span>
							<span class="pixel-font pixel-xs text-white">GARANTÍA 30 DÍAS</span>
						</div>
						<div class="flex items-center gap-2">
							<span class="text-neon-green">✓</span>
							<span class="pixel-font pixel-xs text-white">SOPORTE 24/7</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
// Efectos interactivos para el carrito
document.addEventListener('DOMContentLoaded', function() {
	// Animación al eliminar items
	const eliminarButtons = document.querySelectorAll('button[name="accion"][value="eliminar"]');
	eliminarButtons.forEach(button => {
		button.addEventListener('click', function(e) {
			const card = this.closest('.table-arcade');
			if (card) {
				card.style.animation = 'fadeOutLeft 0.5s ease-out';
			}
		});
	});
	
	// Efecto de actualización de cantidad
	const cantidadInputs = document.querySelectorAll('input[name="cantidad"]');
	cantidadInputs.forEach(input => {
		input.addEventListener('change', function() {
			this.style.borderColor = 'var(--neon-green)';
			this.style.boxShadow = '0 0 15px rgba(57, 255, 20, 0.4)';
			
			setTimeout(() => {
				this.style.borderColor = '';
				this.style.boxShadow = '';
			}, 1000);
		});
	});
	
	// CSS para animaciones
	const style = document.createElement('style');
	style.textContent = `
		@keyframes fadeOutLeft {
			0% { opacity: 1; transform: translateX(0); }
			100% { opacity: 0; transform: translateX(-100%); }
		}
	`;
	document.head.appendChild(style);
});
</script>

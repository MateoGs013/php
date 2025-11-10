<?php
	if (session_status() === PHP_SESSION_NONE) { session_start(); }
	require_once 'clases/Duendes.php';
	$duendes = Duendes::todosDuendes();
	$byId = [];
	foreach ($duendes as $d) { $byId[$d->getId()] = $d; }
	$cart = $_SESSION['cart'] ?? [];
	$total = 0;
	foreach ($cart as $id => $qty) { if (isset($byId[$id])) { $total += $byId[$id]->getPrecioEnOro() * $qty; } }
?>
<section class="mt-8">
	<h2 class="text-2xl md:text-3xl font-bold uppercase tracking-wide text-black mb-6">Finalizar Compra</h2>
	<div class="bg-[#FFF7ED] border-4 border-black rounded-lg shadow-[4px_4px_0_#000] p-6">
		<div class="mb-6">
			<h3 class="font-bold uppercase tracking-wide mb-2">Resumen</h3>
			<ul class="space-y-1">
				<?php if (!empty($cart)): ?>
					<?php foreach ($cart as $id => $qty): if (!isset($byId[$id])) continue; $item = $byId[$id]; ?>
						<li class="flex justify-between border-b border-black/20 py-1">
							<span><?= htmlspecialchars($item->getNombre()); ?> x <?= intval($qty); ?></span>
							<span><?= number_format($item->getPrecioEnOro() * $qty, 2); ?> oro</span>
						</li>
					<?php endforeach; ?>
					<li class="flex justify-between font-bold pt-2">
						<span>Total</span>
						<span><?= number_format($total, 2); ?> oro</span>
					</li>
				<?php else: ?>
					<li class="text-black/70">No hay items en el carrito.</li>
				<?php endif; ?>
			</ul>
		</div>
		<form class="grid grid-cols-1 md:grid-cols-2 gap-4" method="post" action="#">
			<input type="text" name="nombre" class="border-4 border-black rounded-md px-3 py-2" placeholder="Nombre" required />
			<input type="text" name="direccion" class="border-4 border-black rounded-md px-3 py-2" placeholder="Dirección" required />
			<input type="email" name="email" class="border-4 border-black rounded-md px-3 py-2 md:col-span-2" placeholder="Email" required />
			<button type="submit" class="md:col-span-2 mt-2 bg-orange-500 text-white font-bold uppercase tracking-wide border-4 border-black rounded-md px-6 py-3 shadow-[3px_3px_0_#000] hover:bg-orange-600 active:translate-y-0.5">Confirmar</button>
		</form>
	</div>
</section>

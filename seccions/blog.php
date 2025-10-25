<?php
	require_once 'clases/Blogs.php';
	$blogs = Blogs::cargarBlogsDesdeJSON();
?>
<section class="mt-8">
	<h2 class="text-2xl md:text-3xl font-bold uppercase tracking-wide text-black mb-6">Crónicas del Bosque</h2>
	<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
		<?php foreach ($blogs as $b): ?>
			<article class="bg-[#FFF7ED] border-4 border-black rounded-lg shadow-[4px_4px_0_#000] p-4 flex flex-col">
				<a href="?seccion=detalle_blog&slug=<?= htmlspecialchars($b->getSlug()); ?>" class="block">
					<div class="aspect-video border-4 border-black rounded-md overflow-hidden bg-orange-100 grid place-items-center">
						<img src="<?= htmlspecialchars($b->getImagenPortada()); ?>" alt="<?= htmlspecialchars($b->getTitulo()); ?>" class="h-full w-full object-cover"/>
					</div>
				</a>
				<h3 class="mt-3 font-bold uppercase tracking-wide text-black text-lg"><?= htmlspecialchars($b->getTitulo()); ?></h3>
				<p class="text-black/80 flex-1"><?= htmlspecialchars($b->getDescripcionCorta()); ?></p>
				<a href="?seccion=detalle_blog&slug=<?= htmlspecialchars($b->getSlug()); ?>" class="inline-flex mt-3 bg-orange-500 text-white font-bold uppercase tracking-wide border-4 border-black rounded-md px-4 py-2 shadow-[3px_3px_0_#000] hover:bg-orange-600 active:translate-y-0.5">Leer</a>
			</article>
		<?php endforeach; ?>
	</div>
</section>

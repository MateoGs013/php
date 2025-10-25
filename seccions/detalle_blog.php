<?php
	require_once 'clases/Blogs.php';
	$blogs = Blogs::cargarBlogsDesdeJSON();
	$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
	$post = null;
	foreach ($blogs as $b) { if ($b->getSlug() === $slug) { $post = $b; break; } }
?>
<article class="mt-8 section-retrowave">
	<header class="mb-6">
		<h1 class="text-3xl md:text-4xl font-extrabold uppercase tracking-wide text-black"><?= $post ? htmlspecialchars($post->getTitulo()) : 'Artículo no encontrado'; ?></h1>
		<?php if ($post): ?>
			<div class="text-black/70">Por <?= htmlspecialchars($post->getAutor()); ?> — <?= htmlspecialchars($post->getFechaPublicacion()); ?></div>
		<?php endif; ?>
	</header>
	<div class="bg-[#FFF7ED] border-4 border-black rounded-lg shadow-[6px_6px_0_#000] p-6 prose max-w-none">
		<?php if ($post): ?>
			<?= $post->getContenido(); ?>
		<?php else: ?>
			<p>El artículo solicitado no fue encontrado.</p>
		<?php endif; ?>
	</div>
</article>

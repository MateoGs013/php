<?php
require_once 'clases/Duendes.php';
$duendes = Duendes::todosDuendes();

// Filtros disponibles
$rarezas = array_unique(array_map(function($d) { return $d->getRareza(); }, $duendes));
$tipos = array_unique(array_map(function($d) { return $d->getTipo(); }, $duendes));
$elementos = array_unique(array_map(function($d) { return $d->getAfinidadElemental(); }, $duendes));

// Aplicar filtros si existen
$duendesFiltrados = $duendes;
$filtroActivo = false;

if (isset($_GET['rareza']) && !empty($_GET['rareza'])) {
    $duendesFiltrados = array_filter($duendesFiltrados, function($d) {
        return $d->getRareza() === $_GET['rareza'];
    });
    $filtroActivo = true;
}

if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
    $duendesFiltrados = array_filter($duendesFiltrados, function($d) {
        return $d->getTipo() === $_GET['tipo'];
    });
    $filtroActivo = true;
}

if (isset($_GET['elemento']) && !empty($_GET['elemento'])) {
    $duendesFiltrados = array_filter($duendesFiltrados, function($d) {
        return $d->getAfinidadElemental() === $_GET['elemento'];
    });
    $filtroActivo = true;
}
?>

<div class="productos-container retro-bg retro-grid">
    <div class="productos-content">
        <!-- Título arcade principal -->
        <div class="text-center mb-12">
            <h1 class="arcade-title pixel-font pixel-2xl text-glow inline-block">
                CATÁLOGO ARCADE
            </h1>
            <div class="pixel-font pixel-sm text-neon-cyan text-center mt-4">
                ◄◄◄ EXPLORA TODA NUESTRA COLECCIÓN ►►►
            </div>
        </div>

        <!-- Panel de Filtros Arcade -->
        <div class="mb-8">
            <div class="form-arcade max-w-6xl mx-auto">
                <h2 class="pixel-font pixel-md text-neon-green text-glow mb-6 text-center">
                    🎛️ PANEL DE CONTROL
                </h2>
                
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <input type="hidden" name="seccion" value="catalogo">
                    
                    <!-- Filtro por Rareza -->
                    <div>
                        <label class="label-arcade pixel-font pixel-xs">
                            ⭐ RAREZA
                        </label>
                        <select name="rareza" class="input-arcade">
                            <option value="">TODAS</option>
                            <?php foreach ($rarezas as $rareza): ?>
                                <option value="<?= htmlspecialchars($rareza) ?>" 
                                        <?= (isset($_GET['rareza']) && $_GET['rareza'] === $rareza) ? 'selected' : '' ?>>
                                    <?= strtoupper(htmlspecialchars($rareza)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Filtro por Tipo -->
                    <div>
                        <label class="label-arcade pixel-font pixel-xs">
                            🧙 TIPO
                        </label>
                        <select name="tipo" class="input-arcade">
                            <option value="">TODOS</option>
                            <?php foreach ($tipos as $tipo): ?>
                                <option value="<?= htmlspecialchars($tipo) ?>" 
                                        <?= (isset($_GET['tipo']) && $_GET['tipo'] === $tipo) ? 'selected' : '' ?>>
                                    <?= strtoupper(htmlspecialchars($tipo)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Filtro por Elemento -->
                    <div>
                        <label class="label-arcade pixel-font pixel-xs">
                            🔥 ELEMENTO
                        </label>
                        <select name="elemento" class="input-arcade">
                            <option value="">TODOS</option>
                            <?php foreach ($elementos as $elemento): ?>
                                <option value="<?= htmlspecialchars($elemento) ?>" 
                                        <?= (isset($_GET['elemento']) && $_GET['elemento'] === $elemento) ? 'selected' : '' ?>>
                                    <?= strtoupper(htmlspecialchars($elemento)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="flex gap-2">
                        <button type="submit" class="btn-arc primary pixel-font pixel-xs flex-1">
                            🔍 FILTRAR
                        </button>
                        <a href="?seccion=catalogo" class="btn-arc secondary pixel-font pixel-xs px-4">
                            🔄 RESET
                        </a>
                    </div>
                </form>
                
                <!-- Información de filtros activos -->
                <?php if ($filtroActivo): ?>
                    <div class="mt-4 text-center">
                        <div class="alert-arcade alert-success pixel-font pixel-xs inline-block">
                            🎯 FILTROS ACTIVOS: <?= count($duendesFiltrados) ?> DUENDES ENCONTRADOS
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 max-w-4xl mx-auto">
            <div class="form-arcade text-center py-4">
                <div class="pixel-font pixel-lg text-neon-pink text-glow"><?= count($duendesFiltrados) ?></div>
                <div class="pixel-font pixel-xs text-neon-cyan">DUENDES</div>
            </div>
            <div class="form-arcade text-center py-4">
                <div class="pixel-font pixel-lg text-neon-green text-glow"><?= count($rarezas) ?></div>
                <div class="pixel-font pixel-xs text-neon-yellow">RAREZAS</div>
            </div>
            <div class="form-arcade text-center py-4">
                <div class="pixel-font pixel-lg text-neon-yellow text-glow"><?= count($tipos) ?></div>
                <div class="pixel-font pixel-xs text-neon-pink">TIPOS</div>
            </div>
            <div class="form-arcade text-center py-4">
                <div class="pixel-font pixel-lg text-neon-cyan text-glow"><?= count($elementos) ?></div>
                <div class="pixel-font pixel-xs text-neon-green">ELEMENTOS</div>
            </div>
        </div>

        <!-- Grid de productos -->
        <?php if (count($duendesFiltrados) > 0): ?>
            <div class="cards">
                <?php foreach ($duendesFiltrados as $d): ?>
                    <div class="card" aria-labelledby="duende-<?= $d->getId() ?>-title" aria-describedby="duende-<?= $d->getId() ?>-desc">
                        <div class="card__content">
                            <!-- Header con badges -->
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="badge pixel-font pixel-xs"><?= strtoupper($d->getRareza()) ?></span>
                                <?php if ($d->getPopularidad() >= 90): ?>
                                    <span class="chip pixel-font pixel-xs blink-decoration">★ HOT</span>
                                <?php else: ?>
                                    <span class="chip pixel-font pixel-xs">⚡ <?= $d->getPopularidad() ?>%</span>
                                <?php endif; ?>
                            </div>

                            <!-- Imagen del duende -->
                            <div class="mb-4 relative">
                                <img src="<?= $d->getImagenUrl() ?>" 
                                     alt="<?= $d->getNombre() ?>" 
                                     class="duende-img w-full h-32 object-contain" />
                                
                                <!-- Indicador de elemento -->
                                <div class="absolute top-2 right-2 bg-black bg-opacity-80 border-2 border-neon-cyan rounded px-2 py-1">
                                    <span class="pixel-font pixel-xs text-neon-cyan">
                                        <?= strtoupper(substr($d->getAfinidadElemental(), 0, 3)) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Nombre del duende -->
                            <h3 id="duende-<?= $d->getId() ?>-title" class="pixel-font pixel-md text-neon-cyan text-glow mb-3 text-center">
                                <?= strtoupper($d->getNombre()) ?>
                            </h3>

                            <!-- Tipo y precio -->
                            <div class="text-center mb-4">
                                <div class="pixel-font pixel-xs text-neon-green mb-2">
                                    🧙 <?= strtoupper($d->getTipo()) ?>
                                </div>
                                <p class="pixel-font pixel-lg precio-oro">
                                    <?= $d->getPrecioEnOro() ?> ORO
                                </p>
                            </div>

                            <!-- Información del duende -->
                            <div id="duende-<?= $d->getId() ?>-desc" class="duende-info pixel-font pixel-xs text-center mb-4 space-y-1">
                                <div class="text-neon-green">
                                    ⚡ <?= $d->getAlturaCm() ?>CM • LVL <?= $d->getNivelDeSuerte() ?>
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
                                <a href="?seccion=detalle_producto&id=<?= $d->getId() ?>" 
                                   class="btn-arc primary pixel-font pixel-xs">
                                    👁️ VER
                                </a>
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
        <?php else: ?>
            <!-- Mensaje cuando no hay resultados -->
            <div class="text-center">
                <div class="form-arcade max-w-md mx-auto py-12">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="pixel-font pixel-md text-neon-cyan text-glow mb-4">
                        NO ENCONTRADO
                    </h3>
                    <p class="pixel-font pixel-sm text-white mb-6">
                        NO HAY DUENDES QUE COINCIDAN CON TUS FILTROS
                    </p>
                    <a href="?seccion=catalogo" class="btn-arc primary pixel-font pixel-sm">
                        🔄 VER TODOS
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Footer decorativo -->
        <div class="text-center mt-16">
            <div class="pixel-font pixel-sm text-neon-cyan text-glow">
                ◄◄◄ ENCUENTRA TU DUENDE PERFECTO ►►►
            </div>
        </div>
    </div>
</div>

<script>
// Funciones JavaScript para interactividad del catálogo
function agregarAlCarrito(duendeId) {
    console.log('Agregando duende ID:', duendeId, 'al carrito');
    
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = '✓ AGREGADO';
    button.style.background = 'linear-gradient(45deg, var(--neon-green), #22c55e)';
    
    setTimeout(() => {
        button.textContent = originalText;
        button.style.background = '';
    }, 2000);
}

// Efectos de hover para las cartas
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            // Efecto de sonido simulado
            console.log('♪ Card hover effect');
            
            // Pequeño efecto de vibración
            this.style.animation = 'cardPulse 0.3s ease-out';
        });
        
        card.addEventListener('animationend', function() {
            this.style.animation = '';
        });
    });
    
    // Añadir animación CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes cardPulse {
            0% { transform: scale(1) skewY(-8deg); }
            50% { transform: scale(1.02) skewY(-8deg); }
            100% { transform: scale(1) skewY(-8deg); }
        }
    `;
    document.head.appendChild(style);
});
</script>

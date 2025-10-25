<?php
require_once 'clases/Duendes.php';
$duendes = Duendes::cargarDuendesDesdeJSON();
?>

<!-- PIXEL GNOMES ARCADE - Pantalla Principal -->
<div class="arcade-universe">
    <!-- Partículas flotantes de fondo -->
    <div class="floating-particles">
        <div class="particle pixel-1"></div>
        <div class="particle pixel-2"></div>
        <div class="particle pixel-3"></div>
        <div class="particle pixel-4"></div>
        <div class="particle pixel-5"></div>
    </div>

    <!-- Header con perspectiva 3D -->
    <div class="arcade-header">
        <div class="header-3d-container">
            <h1 class="mega-title pixel-font">
                <span class="title-layer-1">PIXEL</span>
                <span class="title-layer-2">GNOMES</span>
                <span class="title-layer-3">ARCADE</span>
            </h1>
            <div class="subtitle-container">
                <div class="pixel-font subtitle-text">
                    ⚡ SELECCIONA TU COMPAÑERO DIGITAL ⚡
                </div>
                <div class="scan-line"></div>
            </div>
        </div>
    </div>

    <!-- Filtros y controles -->
    <div class="arcade-controls">
        <div class="control-panel">
            <button class="filter-btn active pixel-font" data-filter="all">
                📱 TODOS
            </button>
            <button class="filter-btn pixel-font" data-filter="legendary">
                👑 LEGENDARIOS
            </button>
            <button class="filter-btn pixel-font" data-filter="rare">
                💎 RAROS
            </button>
            <button class="filter-btn pixel-font" data-filter="common">
                🔮 COMUNES
            </button>
        </div>
        <div class="score-display pixel-font">
            DUENDES DISPONIBLES: <span id="gnome-count"><?= count($duendes) ?></span>
        </div>
    </div>

    <!-- Grid de productos con perspectiva isométrica -->
    <div class="isometric-showcase">
        <?php foreach ($duendes as $index => $d): ?>
            <div class="gnome-capsule" 
                 data-rarity="<?= strtolower($d->getRareza()) ?>"
                 style="--delay: <?= $index * 0.1 ?>s">
                
                <!-- Marco 3D de la cápsula -->
                <div class="capsule-frame">
                    <!-- Indicadores de estado -->
                    <div class="status-indicators">
                        <div class="rarity-badge rarity-<?= strtolower($d->getRareza()) ?>">
                            <?= strtoupper($d->getRareza()) ?>
                        </div>
                        <div class="power-level">
                            LVL <?= rand(1, 50) ?>
                        </div>
                    </div>

                    <!-- Display principal del duende -->
                    <div class="gnome-display">
                        <div class="hologram-effect">
                            <img src="<?= $d->getImagenUrl() ?>" 
                                 alt="<?= $d->getNombre() ?>"
                                 class="gnome-sprite" 
                                 loading="lazy" />
                            <div class="scan-overlay"></div>
                        </div>
                        
                        <!-- Información del personaje -->
                        <div class="character-info">
                            <h3 class="character-name pixel-font">
                                <?= strtoupper($d->getNombre()) ?>
                            </h3>
                            
                            <!-- Stats del duende -->
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <span class="stat-icon">⚡</span>
                                    <span class="stat-value"><?= $d->getAlturaCm() ?>CM</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-icon">🎯</span>
                                    <span class="stat-value"><?= substr($d->getRecomendadoPara(), 0, 8) ?></span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-icon">🏛️</span>
                                    <span class="stat-value"><?= substr($d->getOrigenMitologico(), 0, 8) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel de precio -->
                    <div class="price-panel">
                        <div class="currency-display">
                            <span class="coin-icon">🪙</span>
                            <span class="price-amount pixel-font"><?= $d->getPrecioEnOro() ?></span>
                            <span class="currency-label pixel-font">GOLD</span>
                        </div>
                    </div>

                    <!-- Botones de acción con efectos -->
                    <div class="action-buttons">
                        <button class="arcade-btn btn-preview" 
                                onclick="previewGnome(<?= $d->getId() ?>)"
                                data-tooltip="Vista previa">
                            <span class="btn-icon">👁️</span>
                            <span class="btn-text pixel-font">PREVIEW</span>
                        </button>
                        
                        <button class="arcade-btn btn-purchase <?= !$d->isDisponible() ? 'disabled' : '' ?>" 
                                onclick="<?= $d->isDisponible() ? 'purchaseGnome(' . $d->getId() . ')' : 'showSoldOut()' ?>"
                                data-tooltip="<?= $d->isDisponible() ? 'Agregar al carrito' : 'Agotado' ?>">
                            <span class="btn-icon"><?= $d->isDisponible() ? '🛒' : '❌' ?></span>
                            <span class="btn-text pixel-font"><?= $d->isDisponible() ? 'BUY' : 'SOLD' ?></span>
                        </button>
                    </div>

                    <!-- Efectos visuales de disponibilidad -->
                    <?php if (!$d->isDisponible()): ?>
                        <div class="sold-out-overlay">
                            <div class="glitch-text pixel-font">SOLD OUT</div>
                        </div>
                    <?php endif; ?>

                    <!-- Efectos de partículas por rareza -->
                    <div class="rarity-particles rarity-<?= strtolower($d->getRareza()) ?>">
                        <div class="particle-1"></div>
                        <div class="particle-2"></div>
                        <div class="particle-3"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Panel de información expandida (modal) -->
    <div id="gnome-modal" class="modal-overlay">
        <div class="modal-capsule">
            <div class="modal-header">
                <h2 class="modal-title pixel-font">ANÁLISIS COMPLETO</h2>
                <button class="modal-close" onclick="closeModal()">❌</button>
            </div>
            <div class="modal-content" id="modal-content">
                <!-- Contenido dinámico del modal -->
            </div>
        </div>
    </div>

    <!-- Footer arcade -->
    <div class="arcade-footer">
        <div class="footer-display pixel-font">
            <div class="footer-line">
                ◄◄◄ PRESS START TO CONTINUE ►►►
            </div>
            <div class="footer-line">
                🎮 PIXEL GNOMES ARCADE © 2025 🎮
            </div>
        </div>
    </div>
</div>

<script>
// ===== ARCADE GNOMES INTERACTIVE SYSTEM =====

class ArcadeGnomes {
    constructor() {
        this.gnomes = <?= json_encode($duendes) ?>;
        this.filteredGnomes = [...this.gnomes];
        this.currentFilter = 'all';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateGnomeCount();
        this.initializeArcadeEffects();
    }

    setupEventListeners() {
        // Filtros
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleFilter(e));
        });

        // Modal
        document.addEventListener('click', (e) => {
            if (e.target.matches('.modal-overlay')) {
                this.closeModal();
            }
        });

        // Efectos de sonido simulados
        document.querySelectorAll('.gnome-capsule').forEach(capsule => {
            capsule.addEventListener('mouseenter', () => this.playHoverSound());
            capsule.addEventListener('click', () => this.playClickSound());
        });

        // Teclas de navegación
        document.addEventListener('keydown', (e) => this.handleKeyboard(e));
    }

    handleFilter(e) {
        const filterValue = e.target.dataset.filter;
        
        // Actualizar botón activo
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        e.target.classList.add('active');

        // Aplicar filtro
        this.applyFilter(filterValue);
        
        // Efecto visual del filtro
        this.animateFilterChange();
    }

    applyFilter(filter) {
        const capsules = document.querySelectorAll('.gnome-capsule');
        
        capsules.forEach((capsule, index) => {
            const rarity = capsule.dataset.rarity;
            let shouldShow = false;

            switch(filter) {
                case 'all':
                    shouldShow = true;
                    break;
                case 'legendary':
                    shouldShow = rarity === 'legendario';
                    break;
                case 'rare':
                    shouldShow = rarity === 'raro';
                    break;
                case 'common':
                    shouldShow = rarity === 'comun';
                    break;
            }

            if (shouldShow) {
                capsule.style.display = 'block';
                capsule.style.animation = `appearAnimation 0.6s ease-out ${index * 0.1}s both`;
            } else {
                capsule.style.animation = 'none';
                setTimeout(() => {
                    capsule.style.display = 'none';
                }, 300);
            }
        });

        this.updateGnomeCount();
    }

    updateGnomeCount() {
        const visibleCapsules = document.querySelectorAll('.gnome-capsule[style*="display: block"], .gnome-capsule:not([style*="display: none"])').length;
        const countElement = document.getElementById('gnome-count');
        if (countElement) {
            countElement.textContent = visibleCapsules;
            countElement.style.animation = 'glowPulse 0.5s ease-in-out';
        }
    }

    animateFilterChange() {
        const showcase = document.querySelector('.isometric-showcase');
        showcase.style.transform = 'perspective(1200px) rotateX(25deg) scale(0.95)';
        
        setTimeout(() => {
            showcase.style.transform = 'perspective(1200px) rotateX(0deg) scale(1)';
        }, 300);
    }

    initializeArcadeEffects() {
        // Efecto de escaneo aleatorio
        setInterval(() => {
            this.randomScanEffect();
        }, 5000);

        // Partículas flotantes dinámicas
        this.createFloatingParticles();

        // Glitch ocasional en el título
        setInterval(() => {
            this.titleGlitchEffect();
        }, 15000);
    }

    randomScanEffect() {
        const capsules = document.querySelectorAll('.gnome-capsule:not([style*="display: none"])');
        if (capsules.length > 0) {
            const randomCapsule = capsules[Math.floor(Math.random() * capsules.length)];
            const scanOverlay = randomCapsule.querySelector('.scan-overlay');
            if (scanOverlay) {
                scanOverlay.style.animation = 'none';
                setTimeout(() => {
                    scanOverlay.style.animation = 'scanSweep 1s ease-out';
                }, 100);
            }
        }
    }

    createFloatingParticles() {
        const particles = document.querySelectorAll('.floating-particles .particle');
        particles.forEach((particle, index) => {
            setInterval(() => {
                const colors = ['var(--neon-cyan)', 'var(--neon-pink)', 'var(--neon-green)', 'var(--neon-yellow)', 'var(--neon-purple)'];
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
            }, 3000 + index * 1000);
        });
    }

    titleGlitchEffect() {
        const titleLayers = document.querySelectorAll('.title-layer-1, .title-layer-2, .title-layer-3');
        titleLayers.forEach(layer => {
            layer.style.animation = 'glitchEffect 0.5s ease-in-out';
            setTimeout(() => {
                layer.style.animation = '';
            }, 500);
        });
    }

    playHoverSound() {
        // Simulación de sonido hover
        console.log('🔊 Hover Sound: *beep*');
        
        // Efecto visual de hover
        event.currentTarget.style.filter = 'brightness(1.1)';
        setTimeout(() => {
            event.currentTarget.style.filter = '';
        }, 200);
    }

    playClickSound() {
        // Simulación de sonido click
        console.log('🔊 Click Sound: *boop*');
    }

    handleKeyboard(e) {
        switch(e.key) {
            case 'Escape':
                this.closeModal();
                break;
            case '1':
                this.simulateFilterClick('all');
                break;
            case '2':
                this.simulateFilterClick('legendary');
                break;
            case '3':
                this.simulateFilterClick('rare');
                break;
            case '4':
                this.simulateFilterClick('common');
                break;
        }
    }

    simulateFilterClick(filter) {
        const btn = document.querySelector(`.filter-btn[data-filter="${filter}"]`);
        if (btn) {
            btn.click();
        }
    }

    // Funciones para los botones de las cápsulas
    previewGnome(gnomeId) {
        const gnome = this.gnomes.find(g => g.id == gnomeId);
        if (!gnome) return;

        const modalContent = document.getElementById('modal-content');
        modalContent.innerHTML = `
            <div class="modal-gnome-detail">
                <div class="modal-gnome-image">
                    <img src="${gnome.imagen_url}" alt="${gnome.nombre}" class="gnome-sprite-large" />
                </div>
                <div class="modal-gnome-info">
                    <h3 class="pixel-font" style="color: var(--neon-cyan); font-size: 16px; margin-bottom: 20px;">
                        ${gnome.nombre.toUpperCase()}
                    </h3>
                    
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label pixel-font">ALTURA:</span>
                            <span class="detail-value">${gnome.altura_cm} CM</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label pixel-font">RAREZA:</span>
                            <span class="detail-value rarity-${gnome.rareza.toLowerCase()}">${gnome.rareza.toUpperCase()}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label pixel-font">ORIGEN:</span>
                            <span class="detail-value">${gnome.origen_mitologico}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label pixel-font">RECOMENDADO PARA:</span>
                            <span class="detail-value">${gnome.recomendado_para}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label pixel-font">PRECIO:</span>
                            <span class="detail-value" style="color: var(--coin-gold);">🪙 ${gnome.precio_en_oro} GOLD</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label pixel-font">ESTADO:</span>
                            <span class="detail-value ${gnome.disponible ? 'text-green' : 'text-red'}">
                                ${gnome.disponible ? '✅ DISPONIBLE' : '❌ AGOTADO'}
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-actions" style="margin-top: 30px; text-align: center;">
                        <button class="arcade-btn btn-purchase" 
                                onclick="arcadeGnomes.purchaseGnome(${gnome.id})"
                                ${!gnome.disponible ? 'disabled' : ''}>
                            <span class="btn-icon">🛒</span>
                            <span class="btn-text pixel-font">${gnome.disponible ? 'COMPRAR AHORA' : 'AGOTADO'}</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        this.showModal();
    }

    purchaseGnome(gnomeId) {
        const gnome = this.gnomes.find(g => g.id == gnomeId);
        if (!gnome || !gnome.disponible) {
            this.showSoldOut();
            return;
        }

        // Simulación de compra
        console.log(`🛒 Comprando duende: ${gnome.nombre} por ${gnome.precio_en_oro} oro`);
        
        // Efecto visual de compra
        this.showPurchaseEffect(gnomeId);
        
        // Aquí iría la lógica real de agregar al carrito
        this.addToCart(gnome);
    }

    addToCart(gnome) {
        // Simulación de agregar al carrito
        console.log('Duende agregado al carrito:', gnome);
        
        // Mostrar notificación
        this.showNotification(`✅ ${gnome.nombre.toUpperCase()} AGREGADO AL CARRITO!`, 'success');
        
        // Cerrar modal si está abierto
        this.closeModal();
    }

    showPurchaseEffect(gnomeId) {
        const capsule = document.querySelector(`.gnome-capsule:has([onclick*="${gnomeId}"])`);
        if (capsule) {
            capsule.style.animation = 'purchaseEffect 1s ease-out';
            
            // Crear partículas de compra
            this.createPurchaseParticles(capsule);
        }
    }

    createPurchaseParticles(element) {
        const rect = element.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        for (let i = 0; i < 8; i++) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: fixed;
                width: 8px;
                height: 8px;
                background: var(--coin-gold);
                border-radius: 50%;
                left: ${centerX}px;
                top: ${centerY}px;
                pointer-events: none;
                z-index: 1000;
                box-shadow: 0 0 10px var(--coin-gold);
            `;
            
            document.body.appendChild(particle);
            
            const angle = (i / 8) * Math.PI * 2;
            const distance = 100;
            const endX = centerX + Math.cos(angle) * distance;
            const endY = centerY + Math.sin(angle) * distance;
            
            particle.animate([
                { transform: 'translate(0, 0) scale(1)', opacity: 1 },
                { transform: `translate(${endX - centerX}px, ${endY - centerY}px) scale(0)`, opacity: 0 }
            ], {
                duration: 1000,
                easing: 'ease-out'
            }).onfinish = () => particle.remove();
        }
    }

    showSoldOut() {
        this.showNotification('❌ ESTE DUENDE ESTÁ AGOTADO', 'error');
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `arcade-notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content pixel-font">
                ${message}
            </div>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.95), rgba(26, 26, 26, 0.95));
            border: 3px solid var(--neon-${type === 'success' ? 'green' : type === 'error' ? 'red' : 'cyan'});
            border-radius: 12px;
            padding: 15px 20px;
            color: var(--neon-${type === 'success' ? 'green' : type === 'error' ? 'red' : 'cyan'});
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.8);
            z-index: 2000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            font-size: 10px;
            max-width: 300px;
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto-remover
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    showModal() {
        const modal = document.getElementById('gnome-modal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    closeModal() {
        const modal = document.getElementById('gnome-modal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Inicializar el sistema arcade
const arcadeGnomes = new ArcadeGnomes();

// Funciones globales para compatibilidad
function previewGnome(gnomeId) {
    arcadeGnomes.previewGnome(gnomeId);
}

function purchaseGnome(gnomeId) {
    arcadeGnomes.purchaseGnome(gnomeId);
}

function showSoldOut() {
    arcadeGnomes.showSoldOut();
}

function closeModal() {
    arcadeGnomes.closeModal();
}

// CSS adicional para efectos dinámicos
const additionalStyles = `
    .modal-gnome-detail {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
        align-items: start;
    }
    
    .gnome-sprite-large {
        width: 150px;
        height: 150px;
        object-fit: contain;
        border: 3px solid var(--neon-cyan);
        border-radius: 15px;
        background: linear-gradient(45deg, rgba(0, 0, 0, 0.8), rgba(26, 26, 26, 0.8));
        padding: 20px;
        filter: drop-shadow(0 0 20px var(--neon-cyan));
    }
    
    .detail-grid {
        display: grid;
        gap: 15px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 8px;
        border: 2px solid rgba(0, 245, 255, 0.3);
    }
    
    .detail-label {
        color: var(--neon-yellow);
        font-size: 10px;
    }
    
    .detail-value {
        color: #fff;
        font-size: 10px;
        text-align: right;
    }
    
    .text-green { color: var(--neon-green) !important; }
    .text-red { color: var(--arcade-red) !important; }
    
    @keyframes purchaseEffect {
        0% { transform: perspective(1200px) rotateX(15deg) rotateY(-15deg) scale(1); }
        50% { transform: perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1.1); }
        100% { transform: perspective(1200px) rotateX(15deg) rotateY(-15deg) scale(1); }
    }
    
    @media (max-width: 768px) {
        .modal-gnome-detail {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .detail-item {
            flex-direction: column;
            gap: 5px;
            text-align: center;
        }
    }
`;

// Insertar estilos adicionales
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalStyles;
document.head.appendChild(styleSheet);

// Efecto de carga inicial
document.addEventListener('DOMContentLoaded', () => {
    const capsules = document.querySelectorAll('.gnome-capsule');
    capsules.forEach((capsule, index) => {
        capsule.style.opacity = '0';
        capsule.style.transform = 'perspective(1200px) rotateX(90deg) rotateY(45deg) translateY(100px)';
        
        setTimeout(() => {
            capsule.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            capsule.style.opacity = '1';
            capsule.style.transform = 'perspective(1200px) rotateX(15deg) rotateY(-15deg)';
        }, index * 100);
    });
    
    // Mensaje de bienvenida
    setTimeout(() => {
        arcadeGnomes.showNotification('🎮 BIENVENIDO AL PIXEL GNOMES ARCADE! 🎮', 'success');
    }, 1000);
});

console.log('🎮 PIXEL GNOMES ARCADE SYSTEM INITIALIZED 🎮');
</script>
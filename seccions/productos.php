<?php
require_once 'clases/Duendes.php';
$duendes = Duendes::cargarDuendesDesdeJSON();
?>

<!-- RETROWAVE 80s GNOMES - Pantalla Principal -->
<div class="retrowave-universe">
    <!-- Partículas flotantes de fondo -->
    <div class="floating-particles">
        <div class="particle pixel-1"></div>
        <div class="particle pixel-2"></div>
        <div class="particle pixel-3"></div>
        <div class="particle pixel-4"></div>
        <div class="particle pixel-5"></div>
    </div>

    <!-- Header con perspectiva 3D -->
    <div class="retrowave-header">
        <div class="header-3d-container">
            <h1 class="retro-title pixel-font">
                <span class="title-layer-1">RETRO</span>
                <span class="title-layer-2">GNOMES</span>
                <span class="title-layer-3">80s</span>
            </h1>
            <div class="subtitle-container">
                <div class="pixel-font subtitle-text">
                    ⚡ SELECCIONA TU COMPAÑERO VINTAGE ⚡
                </div>
                <div class="scan-line"></div>
            </div>
        </div>
    </div>

    <!-- Filtros y controles -->
    <div class="retrowave-controls">
        <div class="control-panel">
            <button class="filter-btn active pixel-font" data-filter="all">
                🌈 TODOS
            </button>
            <button class="filter-btn pixel-font" data-filter="legendary">
                👑 LEGENDARIOS
            </button>
            <button class="filter-btn pixel-font" data-filter="rare">
                💎 RAROS
            </button>
            <button class="filter-btn pixel-font" data-filter="common">
                🌟 COMUNES
            </button>
        </div>
        <div class="score-display pixel-font">
            DUENDES DISPONIBLES: <span id="gnome-count"><?= count($duendes) ?></span>
        </div>
    </div>

    <!-- Grid de productos con perspectiva isométrica -->
    <div class="retrowave-showcase">
        <?php foreach ($duendes as $index => $d): ?>
            <div class="retro-capsule" 
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
                            <h3 class="character-name retro-font">
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
                        <button class="retro-btn btn-preview" 
                                onclick="previewGnome(<?= $d->getId() ?>)"
                                data-tooltip="Vista previa">
                            <span class="btn-icon">👁️</span>
                            <span class="btn-text pixel-font">PREVIEW</span>
                        </button>
                        
                        <button class="retro-btn btn-purchase <?= !$d->isDisponible() ? 'disabled' : '' ?>" 
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

    <!-- Footer retrowave -->
    <div class="retrowave-footer">
        <div class="footer-display">
            <div class="footer-line pixel-font">
                ◄◄◄ PRESS START TO CONTINUE ►►►
            </div>
            <div class="footer-line retro-font">
                🎮 RETRO GNOMES 80s © 2025 🎮
            </div>
        </div>
    </div>
</div>

<script>
// ===== RETROWAVE 80s GNOMES INTERACTIVE SYSTEM =====

class RetrowaveGnomes {
    constructor() {
        this.gnomes = <?= json_encode($duendes) ?>;
        this.filteredGnomes = [...this.gnomes];
        this.currentFilter = 'all';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateGnomeCount();
        this.initializeRetrowaveEffects();
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
        document.querySelectorAll('.retro-capsule').forEach(capsule => {
            capsule.addEventListener('mouseenter', () => this.playRetroHoverSound());
            capsule.addEventListener('click', () => this.playRetroClickSound());
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
        const capsules = document.querySelectorAll('.retro-capsule');
        
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
                capsule.style.animation = `retroAppear 0.8s ease-out ${index * 0.1}s both`;
            } else {
                capsule.style.animation = 'none';
                setTimeout(() => {
                    capsule.style.display = 'none';
                }, 400);
            }
        });

        this.updateGnomeCount();
    }

    updateGnomeCount() {
        const visibleCapsules = document.querySelectorAll('.retro-capsule[style*="display: block"], .retro-capsule:not([style*="display: none"])').length;
        const countElement = document.getElementById('gnome-count');
        if (countElement) {
            countElement.textContent = visibleCapsules;
            countElement.style.animation = 'retroPulse 0.6s ease-in-out';
        }
    }

    animateFilterChange() {
        const showcase = document.querySelector('.retrowave-showcase');
        showcase.style.transform = 'perspective(1200px) rotateX(30deg) scale(0.92)';
        showcase.style.filter = 'brightness(1.2) saturate(1.3)';
        
        setTimeout(() => {
            showcase.style.transform = 'perspective(1200px) rotateX(0deg) scale(1)';
            showcase.style.filter = 'brightness(1) saturate(1)';
        }, 400);
    }

    initializeRetrowaveEffects() {
        // Efecto de escaneo aleatorio
        setInterval(() => {
            this.randomRetroScanEffect();
        }, 6000);

        // Partículas flotantes dinámicas
        this.createRetrowaveParticles();

        // Glitch ocasional en el título
        setInterval(() => {
            this.titleRetroGlitchEffect();
        }, 18000);

        // Efecto de colores cambiantes en partículas
        this.startColorCycling();
    }

    randomRetroScanEffect() {
        const capsules = document.querySelectorAll('.retro-capsule:not([style*="display: none"])');
        if (capsules.length > 0) {
            const randomCapsule = capsules[Math.floor(Math.random() * capsules.length)];
            const scanOverlay = randomCapsule.querySelector('.scan-overlay');
            if (scanOverlay) {
                scanOverlay.style.animation = 'none';
                setTimeout(() => {
                    scanOverlay.style.animation = 'retroScanSweep 1.5s ease-out';
                }, 100);
            }
        }
    }

    createRetrowaveParticles() {
        const particles = document.querySelectorAll('.floating-particles .particle');
        particles.forEach((particle, index) => {
            setInterval(() => {
                const colors = [
                    'var(--pastel-pink)', 
                    'var(--pastel-cyan)', 
                    'var(--pastel-purple)', 
                    'var(--pastel-yellow)', 
                    'var(--pastel-mint)',
                    'var(--pastel-orange)',
                    'var(--pastel-blue)'
                ];
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
            }, 4000 + index * 1200);
        });
    }

    startColorCycling() {
        // Efecto de ciclo de colores en los bordes de las cápsulas
        setInterval(() => {
            const capsules = document.querySelectorAll('.retro-capsule .capsule-frame');
            capsules.forEach(capsule => {
                capsule.style.filter = `hue-rotate(${Math.random() * 360}deg) brightness(1.1)`;
                setTimeout(() => {
                    capsule.style.filter = '';
                }, 2000);
            });
        }, 10000);
    }

    titleRetroGlitchEffect() {
        const titleLayers = document.querySelectorAll('.title-layer-1, .title-layer-2, .title-layer-3');
        titleLayers.forEach((layer, index) => {
            setTimeout(() => {
                layer.style.animation = 'retro80sGlitch 0.8s ease-in-out';
                setTimeout(() => {
                    layer.style.animation = '';
                }, 800);
            }, index * 200);
        });
    }

    playRetroHoverSound() {
        // Simulación de sonido hover retro
        console.log('🔊 Retro Hover Sound: *synth-beep*');
        
        // Efecto visual de hover
        if (event && event.currentTarget) {
            event.currentTarget.style.filter = 'brightness(1.2) saturate(1.3)';
            setTimeout(() => {
                event.currentTarget.style.filter = '';
            }, 300);
        }
    }

    playRetroClickSound() {
        // Simulación de sonido click retro
        console.log('🔊 Retro Click Sound: *synthwave-boop*');
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
                    <h3 class="retro-font" style="color: var(--bg-primary); font-size: 20px; margin-bottom: 25px; text-shadow: 2px 2px 0 rgba(255, 255, 255, 0.3);">
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
                            <span class="detail-value" style="color: var(--retro-gold); font-weight: 900;">🪙 ${gnome.precio_en_oro} GOLD</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label pixel-font">ESTADO:</span>
                            <span class="detail-value ${gnome.disponible ? 'text-green' : 'text-red'}">
                                ${gnome.disponible ? '✅ DISPONIBLE' : '❌ AGOTADO'}
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-actions" style="margin-top: 35px; text-align: center;">
                        <button class="retro-btn btn-purchase" 
                                onclick="retrowaveGnomes.purchaseGnome(${gnome.id})"
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
        console.log(`🛒 Comprando duende retro: ${gnome.nombre} por ${gnome.precio_en_oro} oro`);
        
        // Efecto visual de compra
        this.showRetroPurchaseEffect(gnomeId);
        
        // Aquí iría la lógica real de agregar al carrito
        this.addToCart(gnome);
    }

    addToCart(gnome) {
        // Simulación de agregar al carrito
        console.log('Duende retro agregado al carrito:', gnome);
        
        // Mostrar notificación
        this.showRetroNotification(`✅ ${gnome.nombre.toUpperCase()} AGREGADO AL CARRITO!`, 'success');
        
        // Cerrar modal si está abierto
        this.closeModal();
    }

    showRetroPurchaseEffect(gnomeId) {
        const capsule = document.querySelector(`.retro-capsule:has([onclick*="${gnomeId}"])`);
        if (capsule) {
            capsule.style.animation = 'retroPurchaseEffect 1.2s ease-out';
            
            // Crear partículas de compra retro
            this.createRetroPurchaseParticles(capsule);
        }
    }

    createRetroPurchaseParticles(element) {
        const rect = element.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        for (let i = 0; i < 12; i++) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: fixed;
                width: 10px;
                height: 10px;
                background: var(--retro-gold);
                border-radius: 50%;
                left: ${centerX}px;
                top: ${centerY}px;
                pointer-events: none;
                z-index: 1000;
                box-shadow: 0 0 15px var(--retro-gold);
                border: 2px solid var(--pastel-yellow);
            `;
            
            document.body.appendChild(particle);
            
            const angle = (i / 12) * Math.PI * 2;
            const distance = 120;
            const endX = centerX + Math.cos(angle) * distance;
            const endY = centerY + Math.sin(angle) * distance;
            
            particle.animate([
                { 
                    transform: 'translate(0, 0) scale(1) rotate(0deg)', 
                    opacity: 1,
                    filter: 'brightness(1)'
                },
                { 
                    transform: `translate(${endX - centerX}px, ${endY - centerY}px) scale(0) rotate(360deg)`, 
                    opacity: 0,
                    filter: 'brightness(2)'
                }
            ], {
                duration: 1200,
                easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
            }).onfinish = () => particle.remove();
        }
    }

    showSoldOut() {
        this.showRetroNotification('❌ ESTE DUENDE RETRO ESTÁ AGOTADO', 'error');
    }

    showRetroNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `retro-notification ${type}`;
        
        const colors = {
            success: 'var(--pastel-green)',
            error: '#dc2626',
            info: 'var(--pastel-cyan)'
        };
        
        notification.innerHTML = `
            <div class="notification-content pixel-font">
                ${message}
            </div>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 25px;
            right: 25px;
            background: linear-gradient(45deg, rgba(255, 159, 178, 0.95), rgba(196, 156, 232, 0.95));
            border: 4px solid ${colors[type]};
            border-radius: 15px;
            padding: 20px 25px;
            color: var(--bg-primary);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.8);
            z-index: 2000;
            transform: translateX(110%);
            transition: transform 0.4s ease;
            font-size: 11px;
            max-width: 350px;
            backdrop-filter: blur(10px);
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3);
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto-remover
        setTimeout(() => {
            notification.style.transform = 'translateX(110%)';
            setTimeout(() => notification.remove(), 400);
        }, 3500);
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

// Inicializar el sistema retrowave
const retrowaveGnomes = new RetrowaveGnomes();

// Funciones globales para compatibilidad
function previewGnome(gnomeId) {
    retrowaveGnomes.previewGnome(gnomeId);
}

function purchaseGnome(gnomeId) {
    retrowaveGnomes.purchaseGnome(gnomeId);
}

function showSoldOut() {
    retrowaveGnomes.showSoldOut();
}

function closeModal() {
    retrowaveGnomes.closeModal();
}

// CSS adicional para efectos dinámicos retrowave
const retrowaveStyles = `
    .modal-gnome-detail {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 35px;
        align-items: start;
    }
    
    .gnome-sprite-large {
        width: 170px;
        height: 170px;
        object-fit: contain;
        border: 4px solid var(--pastel-cyan);
        border-radius: 20px;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1));
        padding: 25px;
        filter: drop-shadow(0 0 25px var(--pastel-cyan)) contrast(1.1) saturate(1.2);
        backdrop-filter: blur(5px);
    }
    
    .detail-grid {
        display: grid;
        gap: 18px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
    }
    
    .detail-label {
        font-size: 10px;
        font-weight: 900;
    }
    
    .detail-value {
        color: var(--bg-primary);
        font-size: 11px;
        text-align: right;
        font-weight: 900;
        text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.4);
    }
    
    .text-green { 
        color: var(--pastel-green) !important; 
        text-shadow: 0 0 5px var(--pastel-green);
    }
    .text-red { 
        color: #dc2626 !important; 
        text-shadow: 0 0 5px #dc2626;
    }
    
    @keyframes retroPurchaseEffect {
        0% { 
            transform: perspective(1200px) rotateX(12deg) rotateY(-12deg) scale(1); 
            filter: brightness(1) saturate(1);
        }
        50% { 
            transform: perspective(1200px) rotateX(0deg) rotateY(0deg) scale(1.15); 
            filter: brightness(1.3) saturate(1.5);
        }
        100% { 
            transform: perspective(1200px) rotateX(12deg) rotateY(-12deg) scale(1); 
            filter: brightness(1) saturate(1);
        }
    }
    
    @media (max-width: 768px) {
        .modal-gnome-detail {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .detail-item {
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }
        
        .gnome-sprite-large {
            width: 140px;
            height: 140px;
        }
    }
`;

// Insertar estilos adicionales
const styleSheet = document.createElement('style');
styleSheet.textContent = retrowaveStyles;
document.head.appendChild(styleSheet);

// Efecto de carga inicial retrowave
document.addEventListener('DOMContentLoaded', () => {
    const capsules = document.querySelectorAll('.retro-capsule');
    capsules.forEach((capsule, index) => {
        capsule.style.opacity = '0';
        capsule.style.transform = 'perspective(1200px) rotateX(90deg) rotateY(60deg) translateY(200px) scale(0.3)';
        capsule.style.filter = 'brightness(0) saturate(0)';
        
        setTimeout(() => {
            capsule.style.transition = 'all 1s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            capsule.style.opacity = '1';
            capsule.style.transform = 'perspective(1200px) rotateX(12deg) rotateY(-12deg) scale(1)';
            capsule.style.filter = 'brightness(1) saturate(1)';
        }, index * 150);
    });
    
    // Mensaje de bienvenida retrowave
    setTimeout(() => {
        retrowaveGnomes.showRetroNotification('� BIENVENIDO A RETRO GNOMES 80s! �', 'success');
    }, 1200);
});

console.log('� RETROWAVE 80s GNOMES SYSTEM INITIALIZED �');
</script>
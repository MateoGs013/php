<?php
/**
 * Verificar sesión de administrador
 * Este archivo debe incluirse en todas las páginas del admin que requieran autenticación
 */

// Cargar configuración si no está cargada
if (!isset($auth)) {
    require_once dirname(__DIR__) . '/config.php';
}

// Verificar si el usuario está logueado
if (!$auth->estaLogueado()) {
    // No está logueado - redirigir al login
    $_SESSION['mensaje_error'] = 'Debes iniciar sesión para acceder al panel de administración';
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Guardar URL para redirigir después del login
    redirigir(ADMIN_URL . 'login.php');
}

// Verificar timeout de sesión (opcional)
if (!$auth->verificarTimeout(SESSION_TIMEOUT)) {
    $_SESSION['mensaje_error'] = 'Tu sesión ha expirado por inactividad';
    redirigir(ADMIN_URL . 'login.php');
}

// Si llegó hasta aquí, el usuario está autenticado
// Obtener datos del usuario actual para usar en las páginas
$usuarioActual = $auth->getUsuarioActual();
?>

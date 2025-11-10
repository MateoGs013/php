<?php
/**
 * Configuración del panel de administración
 */

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuración de zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Configuración de errores (desactivar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Rutas base
define('ADMIN_PATH', __DIR__);
define('ROOT_PATH', dirname(ADMIN_PATH));
define('CLASES_PATH', ADMIN_PATH . '/clases');
define('INCLUDES_PATH', ADMIN_PATH . '/includes');
define('SECCIONES_PATH', ADMIN_PATH . '/seccions');

// URLs base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

define('BASE_URL', $protocol . $host . rtrim($scriptName, '/') . '/');
define('ADMIN_URL', BASE_URL . 'admin/');

// Configuración de seguridad
define('SESSION_TIMEOUT', 7200); // 2 horas en segundos

// Cargar clases necesarias
require_once ROOT_PATH . '/clases/Conexion.php';
require_once CLASES_PATH . '/Auth.php';
require_once CLASES_PATH . '/Validador.php';

// Crear instancia de conexión
$conexion = new Conexion();

// Crear instancia de autenticación
$auth = new Auth($conexion);

// Función helper para redireccionar
function redirigir($url) {
    header("Location: " . $url);
    exit;
}

// Función helper para mostrar alertas
function mostrarAlerta($tipo, $mensaje) {
    $iconos = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ'
    ];
    
    $colores = [
        'success' => '#10b981',
        'error' => '#ef4444',
        'warning' => '#f59e0b',
        'info' => '#3b82f6'
    ];
    
    $icono = $iconos[$tipo] ?? 'ℹ';
    $color = $colores[$tipo] ?? '#6b7280';
    
    return "<div style='padding: 12px 20px; margin: 15px 0; background: {$color}20; border-left: 4px solid {$color}; color: {$color}; border-radius: 4px; font-family: system-ui, -apple-system, sans-serif;'>
        <strong style='margin-right: 8px;'>{$icono}</strong> {$mensaje}
    </div>";
}
?>

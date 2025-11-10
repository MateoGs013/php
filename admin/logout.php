<?php
/**
 * Cerrar sesión de administrador
 */
require_once 'config.php';

// Cerrar sesión
$auth->logout();

// Redirigir al login con mensaje
session_start();
$_SESSION['mensaje_logout'] = 'Sesión cerrada exitosamente';

redirigir('login.php');
?>

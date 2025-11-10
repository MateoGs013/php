<?php
/**
 * Panel de administración principal
 * Dashboard del sistema
 */
require_once 'includes/verificar_sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Tienda Mística</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3a28 0%, #0f1b13 100%);
            min-height: 100vh;
        }
        
        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            color: #2d5f3f;
            font-size: 24px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-name {
            color: #2d5f3f;
            font-weight: 600;
        }
        
        .btn-logout {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-logout:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        
        .welcome-card h2 {
            color: #2d5f3f;
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: #666;
            font-size: 16px;
        }
        
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .admin-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        
        .admin-card-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .admin-card h3 {
            color: #2d5f3f;
            font-size: 22px;
            margin-bottom: 10px;
        }
        
        .admin-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>🍀 Panel de Administración - Tienda Mística</h1>
        <div class="user-info">
            <span class="user-name">
                👤 <?= htmlspecialchars($usuarioActual['nombre'] . ' ' . $usuarioActual['apellido']) ?>
            </span>
            <a href="logout.php" class="btn-logout">🚪 Cerrar Sesión</a>
        </div>
    </header>
    
    <div class="container">
        <div class="welcome-card">
            <h2>¡Bienvenido/a, <?= htmlspecialchars($usuarioActual['nombre']) ?>!</h2>
            <p>Gestiona tu tienda de duendes irlandeses desde este panel</p>
            <p style="margin-top: 10px; font-size: 14px; color: #999;">
                Último acceso: <?= date('d/m/Y H:i:s') ?>
            </p>
        </div>
        
        <div class="admin-grid">
            <a href="seccions/dashboard.php" class="admin-card">
                <div class="admin-card-icon">📊</div>
                <h3>Dashboard</h3>
                <p>Estadísticas generales, ventas y reportes del sitio</p>
            </a>
            
            <a href="seccions/duendes_listar.php" class="admin-card">
                <div class="admin-card-icon">🧙</div>
                <h3>Duendes</h3>
                <p>Gestionar catálogo de duendes, crear, editar y eliminar</p>
            </a>
            
            <a href="seccions/pedidos_listar.php" class="admin-card">
                <div class="admin-card-icon">📦</div>
                <h3>Pedidos</h3>
                <p>Ver y administrar pedidos de clientes</p>
            </a>
            
            <a href="seccions/usuarios_listar.php" class="admin-card">
                <div class="admin-card-icon">👥</div>
                <h3>Usuarios</h3>
                <p>Gestionar usuarios y administradores del sistema</p>
            </a>
            
            <a href="seccions/blogs_listar.php" class="admin-card">
                <div class="admin-card-icon">📝</div>
                <h3>Blog</h3>
                <p>Crear y editar artículos del blog</p>
            </a>
            
            <a href="seccions/categorias.php" class="admin-card">
                <div class="admin-card-icon">🏷️</div>
                <h3>Categorías</h3>
                <p>Gestionar categorías, elementos y rarezas</p>
            </a>
            
            <a href="seccions/reportes.php" class="admin-card">
                <div class="admin-card-icon">📈</div>
                <h3>Reportes</h3>
                <p>Reportes de ventas, productos más vendidos</p>
            </a>
            
            <a href="seccions/configuracion.php" class="admin-card">
                <div class="admin-card-icon">⚙️</div>
                <h3>Configuración</h3>
                <p>Ajustes generales del sitio y preferencias</p>
            </a>
        </div>
    </div>
</body>
</html>

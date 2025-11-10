<?php
/**
 * Script para crear el primer usuario administrador
 * 
 * IMPORTANTE: 
 * - Ejecutar SOLO UNA VEZ para crear el primer admin
 * - Luego ELIMINAR o RENOMBRAR este archivo por seguridad
 * - Puedes cambiar los datos del usuario más abajo
 */

require_once 'config.php';

// ===== CONFIGURAR TUS DATOS AQUÍ =====
$datosAdmin = [
    'nombre' => 'Admin',
    'apellido' => 'Principal',
    'email' => 'admin@tiendamistica.com',
    'password' => 'admin123',  // CAMBIAR ESTO por una contraseña segura
    'rol' => 'admin'
];
// ======================================

// Validar datos
$validacion = Validador::validarRegistro($datosAdmin);

if (!$validacion['valido']) {
    echo "<h2 style='color: red;'>❌ Errores de validación:</h2>";
    echo "<ul>";
    foreach ($validacion['errores'] as $campo => $error) {
        echo "<li><strong>{$campo}:</strong> {$error}</li>";
    }
    echo "</ul>";
    exit;
}

// Registrar usuario
$resultado = $auth->registrar(
    $datosAdmin['nombre'],
    $datosAdmin['apellido'],
    $datosAdmin['email'],
    $datosAdmin['password'],
    $datosAdmin['rol']
);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario Admin</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        
        .success {
            background: #d4edda;
            border: 2px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .error {
            background: #f8d7da;
            border: 2px solid #f5c6cb;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .icon {
            font-size: 60px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #2d5f3f;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .info-box {
            background: #e7f3ff;
            border: 2px solid #b3d7ff;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .info-box h3 {
            color: #004085;
            margin-bottom: 10px;
        }
        
        .info-box p {
            margin: 8px 0;
            line-height: 1.6;
        }
        
        .warning-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .warning-box h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #2d5f3f;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            margin-top: 20px;
        }
        
        .btn:hover {
            background: #1e3a28;
        }
        
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <?= $resultado['success'] ? '✅' : '❌' ?>
        </div>
        
        <h1><?= $resultado['success'] ? '¡Usuario Creado!' : 'Error al Crear Usuario' ?></h1>
        
        <div class="<?= $resultado['success'] ? 'success' : 'error' ?>">
            <p><?= $resultado['mensaje'] ?></p>
        </div>
        
        <?php if ($resultado['success']): ?>
            <div class="info-box">
                <h3>📋 Datos de Acceso</h3>
                <p><strong>Email:</strong> <code><?= htmlspecialchars($datosAdmin['email']) ?></code></p>
                <p><strong>Contraseña:</strong> <code><?= htmlspecialchars($datosAdmin['password']) ?></code></p>
                <p><strong>Rol:</strong> <code><?= htmlspecialchars($datosAdmin['rol']) ?></code></p>
            </div>
            
            <div class="warning-box">
                <h3>⚠️ IMPORTANTE - Seguridad</h3>
                <p><strong>1.</strong> Ahora podés iniciar sesión con estos datos</p>
                <p><strong>2.</strong> Por favor, <strong>ELIMINAR o RENOMBRAR</strong> este archivo:</p>
                <p><code>admin/crear_usuario_admin.php</code></p>
                <p><strong>3.</strong> Cambiar la contraseña desde el panel cuando ingreses</p>
            </div>
            
            <a href="login.php" class="btn">🔐 Ir al Login</a>
        <?php else: ?>
            <div class="info-box">
                <h3>💡 Posibles soluciones:</h3>
                <p>• Verificar que la base de datos esté conectada</p>
                <p>• Verificar que la tabla <code>usuarios</code> exista</p>
                <p>• Si el email ya existe, usar otro email</p>
                <p>• Verificar que los datos cumplan las validaciones</p>
            </div>
            
            <a href="crear_usuario_admin.php" class="btn">🔄 Reintentar</a>
        <?php endif; ?>
    </div>
</body>
</html>

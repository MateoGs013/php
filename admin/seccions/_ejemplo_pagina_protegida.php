<!-- 
    EJEMPLO DE PÁGINA PROTEGIDA DEL ADMIN
    
    Este es un ejemplo de cómo debe verse cualquier página
    del panel de administración que requiera autenticación.
-->

<?php
// 1. SIEMPRE incluir verificar_sesion.php al inicio
require_once '../includes/verificar_sesion.php';

// 2. Ahora ya tenés acceso a estas variables:
// - $auth: Objeto de autenticación
// - $usuarioActual: Array con datos del admin logueado
//   ['id', 'nombre', 'apellido', 'email', 'rol']
// - $conexion: Objeto de conexión a la BD

// 3. Tu lógica de negocio aquí
$titulo = "Ejemplo de Página Protegida";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> - Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .success-box {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2d5f3f;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 5px;
        }
        
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $titulo ?></h1>
        <div>
            <span>👤 <?= htmlspecialchars($usuarioActual['nombre']) ?></span>
            <a href="../logout.php" class="btn">Cerrar Sesión</a>
        </div>
    </div>
    
    <div class="content">
        <h2>✅ Esta página está protegida</h2>
        
        <div class="success-box">
            <strong>¡Perfecto!</strong> El sistema de autenticación está funcionando.
            Solo los usuarios logueados pueden ver esta página.
        </div>
        
        <div class="info-box">
            <h3>📊 Información del Usuario Logueado:</h3>
            <ul>
                <li><strong>ID:</strong> <?= $usuarioActual['id'] ?></li>
                <li><strong>Nombre:</strong> <?= htmlspecialchars($usuarioActual['nombre']) ?></li>
                <li><strong>Apellido:</strong> <?= htmlspecialchars($usuarioActual['apellido']) ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($usuarioActual['email']) ?></li>
                <li><strong>Rol:</strong> <?= htmlspecialchars($usuarioActual['rol']) ?></li>
            </ul>
        </div>
        
        <h3>💡 Cómo usar este sistema:</h3>
        
        <h4>1. Proteger una página:</h4>
        <pre><code>&lt;?php
require_once 'includes/verificar_sesion.php';
// El resto de tu código aquí
?&gt;</code></pre>
        
        <h4>2. Acceder a datos del usuario:</h4>
        <pre><code>&lt;?php
echo $usuarioActual['nombre'];  // Nombre
echo $usuarioActual['email'];   // Email
echo $usuarioActual['id'];      // ID
?&gt;</code></pre>
        
        <h4>3. Verificar si está logueado:</h4>
        <pre><code>&lt;?php
if ($auth->estaLogueado()) {
    echo "Usuario autenticado";
}
?&gt;</code></pre>
        
        <h4>4. Registrar nuevo admin (desde código):</h4>
        <pre><code>&lt;?php
$resultado = $auth->registrar(
    'Juan',           // nombre
    'Pérez',          // apellido
    'juan@mail.com',  // email
    'password123',    // password
    'admin'           // rol
);

if ($resultado['success']) {
    echo "Usuario creado!";
}
?&gt;</code></pre>
        
        <h4>5. Validar formularios:</h4>
        <pre><code>&lt;?php
// Validar login
$validacion = Validador::validarLogin($_POST);

// Validar registro completo
$validacion = Validador::validarRegistro($_POST);

if (!$validacion['valido']) {
    print_r($validacion['errores']);
}
?&gt;</code></pre>
        
        <div style="margin-top: 30px;">
            <a href="../index.php" class="btn">🏠 Volver al Panel</a>
            <a href="../logout.php" class="btn" style="background: #dc3545;">🚪 Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>

<?php
/**
 * Página de inicio de sesión del administrador
 */
require_once 'config.php';

// Si ya está logueado, redirigir al panel
if ($auth->estaLogueado()) {
    redirigir('index.php');
}

$mensaje = '';
$tipoMensaje = '';

// Procesar formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar datos del formulario
    $validacion = Validador::validarLogin($_POST);
    
    if (!$validacion['valido']) {
        $mensaje = implode('<br>', $validacion['errores']);
        $tipoMensaje = 'error';
    } else {
        // Intentar login
        $email = Validador::sanitizarEmail($_POST['email']);
        $password = $_POST['password'];
        
        $resultado = $auth->login($email, $password);
        
        if ($resultado['success']) {
            // Login exitoso - redirigir al panel
            redirigir('index.php');
        } else {
            $mensaje = $resultado['mensaje'];
            $tipoMensaje = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Tienda Mística</title>
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
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
        }
        
        .login-header {
            background: linear-gradient(135deg, #2d5f3f 0%, #1e3a28 100%);
            color: #ffd700;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .login-header::before {
            content: "🍀";
            font-size: 60px;
            display: block;
            margin-bottom: 10px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .login-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .login-header p {
            color: #b8dabe;
            font-size: 14px;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d5f3f;
            font-weight: 600;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f9f9f9;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #2d5f3f;
            background: white;
            box-shadow: 0 0 0 4px rgba(45, 95, 63, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #2d5f3f 0%, #1e3a28 100%);
            color: #ffd700;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 95, 63, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alerta {
            padding: 14px 18px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .alerta-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }
        
        .alerta-success {
            background: #efe;
            border: 1px solid #cfc;
            color: #3c3;
        }
        
        .login-footer {
            text-align: center;
            padding: 20px 30px;
            background: #f5f5f5;
            color: #666;
            font-size: 13px;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle input {
            padding-right: 45px;
        }
        
        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #666;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Panel de Administración</h1>
            <p>Tienda Mística - Duendes Irlandeses</p>
        </div>
        
        <div class="login-body">
            <?php if ($mensaje): ?>
                <div class="alerta alerta-<?= $tipoMensaje ?>">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="admin@tiendamistica.com"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        required
                        autocomplete="email"
                    >
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-toggle">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                            👁️
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">
                    🔐 Iniciar Sesión
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            © <?= date('Y') ?> Tienda Mística - Sistema protegido
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const btn = document.querySelector('.password-toggle-btn');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                btn.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                btn.textContent = '👁️';
            }
        }
    </script>
</body>
</html>

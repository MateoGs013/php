<?php
/**
 * Clase Auth - Gestión de autenticación de administradores
 * Maneja login, registro, sesiones y validación de usuarios
 */
class Auth {
    private $conexion;
    private $db;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this->db = $conexion->getConexion();
        
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Registrar un nuevo usuario administrador
     * @param string $nombre
     * @param string $apellido
     * @param string $email
     * @param string $password
     * @param string $rol - 'admin' o 'usuario'
     * @return array ['success' => bool, 'mensaje' => string]
     */
    public function registrar($nombre, $apellido, $email, $password, $rol = 'admin') {
        try {
            // Verificar si el email ya existe
            if ($this->emailExiste($email)) {
                return [
                    'success' => false,
                    'mensaje' => 'El email ya está registrado'
                ];
            }
            
            // Hash seguro de la contraseña
            $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            
            // Insertar usuario
            $query = "INSERT INTO usuarios (nombre, apellido, email, password_hash, rol, activo) 
                      VALUES (:nombre, :apellido, :email, :password_hash, :rol, 1)";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':nombre' => trim($nombre),
                ':apellido' => trim($apellido),
                ':email' => strtolower(trim($email)),
                ':password_hash' => $passwordHash,
                ':rol' => $rol
            ]);
            
            return [
                'success' => true,
                'mensaje' => 'Usuario registrado exitosamente',
                'id_usuario' => $this->db->lastInsertId()
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'mensaje' => 'Error al registrar usuario: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Iniciar sesión de administrador
     * @param string $email
     * @param string $password
     * @return array ['success' => bool, 'mensaje' => string]
     */
    public function login($email, $password) {
        try {
            // Buscar usuario por email
            $query = "SELECT id_usuario, nombre, apellido, email, password_hash, rol, activo 
                      FROM usuarios 
                      WHERE email = :email AND rol = 'admin'";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([':email' => strtolower(trim($email))]);
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar si el usuario existe
            if (!$usuario) {
                return [
                    'success' => false,
                    'mensaje' => 'Email o contraseña incorrectos'
                ];
            }
            
            // Verificar si está activo
            if ($usuario['activo'] != 1) {
                return [
                    'success' => false,
                    'mensaje' => 'Usuario desactivado. Contacta al administrador.'
                ];
            }
            
            // Verificar contraseña
            if (!password_verify($password, $usuario['password_hash'])) {
                return [
                    'success' => false,
                    'mensaje' => 'Email o contraseña incorrectos'
                ];
            }
            
            // Crear sesión
            $_SESSION['admin_logueado'] = true;
            $_SESSION['admin_id'] = $usuario['id_usuario'];
            $_SESSION['admin_nombre'] = $usuario['nombre'];
            $_SESSION['admin_apellido'] = $usuario['apellido'];
            $_SESSION['admin_email'] = $usuario['email'];
            $_SESSION['admin_rol'] = $usuario['rol'];
            $_SESSION['admin_login_time'] = time();
            
            // Regenerar ID de sesión por seguridad
            session_regenerate_id(true);
            
            return [
                'success' => true,
                'mensaje' => 'Login exitoso',
                'usuario' => [
                    'id' => $usuario['id_usuario'],
                    'nombre' => $usuario['nombre'],
                    'email' => $usuario['email']
                ]
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'mensaje' => 'Error en el sistema: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Cerrar sesión
     */
    public function logout() {
        // Limpiar todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la cookie de sesión si existe
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        // Destruir la sesión
        session_destroy();
    }
    
    /**
     * Verificar si hay una sesión activa de administrador
     * @return bool
     */
    public function estaLogueado() {
        return isset($_SESSION['admin_logueado']) && $_SESSION['admin_logueado'] === true;
    }
    
    /**
     * Obtener datos del administrador logueado
     * @return array|null
     */
    public function getUsuarioActual() {
        if (!$this->estaLogueado()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['admin_id'] ?? null,
            'nombre' => $_SESSION['admin_nombre'] ?? '',
            'apellido' => $_SESSION['admin_apellido'] ?? '',
            'email' => $_SESSION['admin_email'] ?? '',
            'rol' => $_SESSION['admin_rol'] ?? ''
        ];
    }
    
    /**
     * Verificar si un email ya está registrado
     * @param string $email
     * @return bool
     */
    private function emailExiste($email) {
        $query = "SELECT COUNT(*) as total FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':email' => strtolower(trim($email))]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] > 0;
    }
    
    /**
     * Verificar timeout de sesión (opcional, 2 horas)
     * @param int $tiempo_maximo Tiempo en segundos (default 7200 = 2 horas)
     * @return bool
     */
    public function verificarTimeout($tiempo_maximo = 7200) {
        if (!$this->estaLogueado()) {
            return false;
        }
        
        $tiempo_transcurrido = time() - ($_SESSION['admin_login_time'] ?? 0);
        
        if ($tiempo_transcurrido > $tiempo_maximo) {
            $this->logout();
            return false;
        }
        
        // Actualizar tiempo de actividad
        $_SESSION['admin_login_time'] = time();
        return true;
    }
}
?>

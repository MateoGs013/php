<?php
/**
 * Clase Validador - Validación y sanitización de datos
 */
class Validador {
    
    /**
     * Validar email
     * @param string $email
     * @return array ['valido' => bool, 'mensaje' => string]
     */
    public static function validarEmail($email) {
        $email = trim($email);
        
        if (empty($email)) {
            return ['valido' => false, 'mensaje' => 'El email es obligatorio'];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['valido' => false, 'mensaje' => 'El formato del email no es válido'];
        }
        
        return ['valido' => true, 'mensaje' => ''];
    }
    
    /**
     * Validar contraseña
     * @param string $password
     * @param int $longitudMinima
     * @return array ['valido' => bool, 'mensaje' => string]
     */
    public static function validarPassword($password, $longitudMinima = 6) {
        if (empty($password)) {
            return ['valido' => false, 'mensaje' => 'La contraseña es obligatoria'];
        }
        
        if (strlen($password) < $longitudMinima) {
            return [
                'valido' => false, 
                'mensaje' => "La contraseña debe tener al menos {$longitudMinima} caracteres"
            ];
        }
        
        // Validar que tenga al menos una letra y un número (seguridad media)
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return [
                'valido' => false, 
                'mensaje' => 'La contraseña debe contener letras y números'
            ];
        }
        
        return ['valido' => true, 'mensaje' => ''];
    }
    
    /**
     * Validar nombre o apellido
     * @param string $nombre
     * @param string $campo Nombre del campo para el mensaje
     * @return array ['valido' => bool, 'mensaje' => string]
     */
    public static function validarNombre($nombre, $campo = 'Nombre') {
        $nombre = trim($nombre);
        
        if (empty($nombre)) {
            return ['valido' => false, 'mensaje' => "El {$campo} es obligatorio"];
        }
        
        if (strlen($nombre) < 2) {
            return ['valido' => false, 'mensaje' => "El {$campo} debe tener al menos 2 caracteres"];
        }
        
        if (strlen($nombre) > 100) {
            return ['valido' => false, 'mensaje' => "El {$campo} no puede exceder 100 caracteres"];
        }
        
        // Solo letras, espacios, guiones y acentos
        if (!preg_match('/^[a-záéíóúñüA-ZÁÉÍÓÚÑÜ\s\-]+$/u', $nombre)) {
            return [
                'valido' => false, 
                'mensaje' => "El {$campo} solo puede contener letras, espacios y guiones"
            ];
        }
        
        return ['valido' => true, 'mensaje' => ''];
    }
    
    /**
     * Sanitizar texto general (prevenir XSS)
     * @param string $texto
     * @return string
     */
    public static function sanitizarTexto($texto) {
        return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Sanitizar email
     * @param string $email
     * @return string
     */
    public static function sanitizarEmail($email) {
        return filter_var(strtolower(trim($email)), FILTER_SANITIZE_EMAIL);
    }
    
    /**
     * Validar que dos contraseñas coincidan
     * @param string $password1
     * @param string $password2
     * @return array ['valido' => bool, 'mensaje' => string]
     */
    public static function validarPasswordsCoinciden($password1, $password2) {
        if ($password1 !== $password2) {
            return ['valido' => false, 'mensaje' => 'Las contraseñas no coinciden'];
        }
        
        return ['valido' => true, 'mensaje' => ''];
    }
    
    /**
     * Validar formulario completo de registro
     * @param array $datos ['nombre', 'apellido', 'email', 'password', 'password_confirm']
     * @return array ['valido' => bool, 'errores' => array]
     */
    public static function validarRegistro($datos) {
        $errores = [];
        
        // Validar nombre
        $validacionNombre = self::validarNombre($datos['nombre'] ?? '', 'nombre');
        if (!$validacionNombre['valido']) {
            $errores['nombre'] = $validacionNombre['mensaje'];
        }
        
        // Validar apellido
        $validacionApellido = self::validarNombre($datos['apellido'] ?? '', 'apellido');
        if (!$validacionApellido['valido']) {
            $errores['apellido'] = $validacionApellido['mensaje'];
        }
        
        // Validar email
        $validacionEmail = self::validarEmail($datos['email'] ?? '');
        if (!$validacionEmail['valido']) {
            $errores['email'] = $validacionEmail['mensaje'];
        }
        
        // Validar password
        $validacionPassword = self::validarPassword($datos['password'] ?? '');
        if (!$validacionPassword['valido']) {
            $errores['password'] = $validacionPassword['mensaje'];
        }
        
        // Validar que coincidan las contraseñas
        if (isset($datos['password_confirm'])) {
            $validacionCoinciden = self::validarPasswordsCoinciden(
                $datos['password'] ?? '', 
                $datos['password_confirm']
            );
            if (!$validacionCoinciden['valido']) {
                $errores['password_confirm'] = $validacionCoinciden['mensaje'];
            }
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
    
    /**
     * Validar formulario de login
     * @param array $datos ['email', 'password']
     * @return array ['valido' => bool, 'errores' => array]
     */
    public static function validarLogin($datos) {
        $errores = [];
        
        // Validar email
        $validacionEmail = self::validarEmail($datos['email'] ?? '');
        if (!$validacionEmail['valido']) {
            $errores['email'] = $validacionEmail['mensaje'];
        }
        
        // Validar que la contraseña no esté vacía
        if (empty($datos['password'] ?? '')) {
            $errores['password'] = 'La contraseña es obligatoria';
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
}
?>

# 🔐 Sistema de Login/Register - Panel Admin
## Guía Completa de Implementación

---

## 📁 Archivos Creados

### **Clases** (`admin/clases/`)
1. ✅ **Auth.php** - Sistema completo de autenticación
   - `registrar()` - Crear nuevos usuarios admin
   - `login()` - Iniciar sesión
   - `logout()` - Cerrar sesión
   - `estaLogueado()` - Verificar si hay sesión activa
   - `getUsuarioActual()` - Obtener datos del usuario logueado
   - `verificarTimeout()` - Control de tiempo de sesión (2 horas)

2. ✅ **Validador.php** - Validación de datos
   - `validarEmail()` - Validar formato de email
   - `validarPassword()` - Validar contraseña (mínimo 6 caracteres, letras y números)
   - `validarNombre()` - Validar nombres y apellidos
   - `validarLogin()` - Validar formulario de login
   - `validarRegistro()` - Validar formulario de registro completo

### **Configuración**
3. ✅ **config.php** - Configuración del panel admin
   - Inicio de sesiones
   - Zona horaria Argentina
   - Constantes de rutas y URLs
   - Carga automática de clases
   - Funciones helper (redirigir, mostrarAlerta)

### **Páginas**
4. ✅ **login.php** - Página de inicio de sesión
   - Diseño temático místico con animaciones
   - Validación en servidor
   - Mensajes de error/éxito
   - Toggle de visualización de contraseña
   - Protección contra acceso si ya está logueado

5. ✅ **logout.php** - Cerrar sesión
   - Destruye la sesión
   - Limpia cookies
   - Redirige al login

### **Seguridad**
6. ✅ **verificar_sesion.php** (`admin/includes/`)
   - Protege páginas del admin
   - Verifica sesión activa
   - Control de timeout
   - Redirige a login si no está autenticado

### **Instalador**
7. ✅ **crear_usuario_admin.php** - Script de instalación
   - Crear el primer usuario administrador
   - Interfaz visual amigable
   - Instrucciones de seguridad

---

## 🚀 PASO A PASO - Cómo Usar el Sistema

### **PASO 1: Verificar Base de Datos** ✓
La tabla `usuarios` ya existe en tu base de datos `tienda_mistica` con estos campos:
```sql
- id_usuario (INT, AUTO_INCREMENT)
- nombre (VARCHAR 100)
- apellido (VARCHAR 100)
- email (VARCHAR 150, UNIQUE)
- password_hash (VARCHAR 255)
- rol (ENUM: 'usuario', 'admin')
- fecha_alta (DATETIME)
- activo (TINYINT)
```

### **PASO 2: Crear el Primer Usuario Admin** 🔑

1. **Abrir XAMPP** y asegurarte que Apache y MySQL estén corriendo

2. **Ir al navegador** y abrir:
   ```
   http://localhost/php/admin/crear_usuario_admin.php
   ```

3. **El script creará automáticamente** un usuario con estos datos:
   - **Email:** `admin@tiendamistica.com`
   - **Contraseña:** `admin123`
   - **Rol:** `admin`

4. **Opcional:** Antes de ejecutarlo, podés editar el archivo y cambiar estos datos:
   ```php
   // Líneas 16-22 en crear_usuario_admin.php
   $datosAdmin = [
       'nombre' => 'Admin',
       'apellido' => 'Principal',
       'email' => 'admin@tiendamistica.com',
       'password' => 'admin123',  // ← Cambiar esto
       'rol' => 'admin'
   ];
   ```

5. **Después de crear el usuario:**
   - ⚠️ **ELIMINAR o RENOMBRAR** el archivo `crear_usuario_admin.php` por seguridad
   - Ejemplo: cambiarle el nombre a `_crear_usuario_admin.php` (con guión bajo)

### **PASO 3: Iniciar Sesión** 🔐

1. **Ir a la página de login:**
   ```
   http://localhost/php/admin/login.php
   ```

2. **Ingresar credenciales:**
   - Email: `admin@tiendamistica.com`
   - Contraseña: `admin123`

3. **Si el login es exitoso**, te redirige al panel: `admin/index.php`

### **PASO 4: Proteger Páginas del Admin** 🛡️

Para proteger cualquier página del panel admin, solo agregá al inicio:

```php
<?php
require_once 'includes/verificar_sesion.php';
?>
```

**Ejemplo en `admin/index.php`:**
```php
<?php
require_once 'includes/verificar_sesion.php';

// Aquí ya tenés acceso a $usuarioActual con los datos del admin
echo "Bienvenido, " . $usuarioActual['nombre'];
?>
```

### **PASO 5: Cerrar Sesión** 🚪

Crear un botón o enlace que apunte a:
```html
<a href="logout.php">Cerrar Sesión</a>
```

---

## 🔧 Funciones Disponibles

### **En cualquier página protegida:**

```php
// Obtener usuario actual
$usuario = $auth->getUsuarioActual();
echo $usuario['nombre'];    // Nombre del admin
echo $usuario['email'];     // Email del admin
echo $usuario['id'];        // ID del usuario

// Verificar si está logueado
if ($auth->estaLogueado()) {
    echo "Usuario autenticado";
}

// Crear nuevo admin (desde el panel)
$resultado = $auth->registrar(
    'Juan',
    'Pérez', 
    'juan@tiendamistica.com',
    'password123',
    'admin'
);
```

### **Validaciones:**

```php
// Validar email
$validacion = Validador::validarEmail('correo@ejemplo.com');
if (!$validacion['valido']) {
    echo $validacion['mensaje']; // Error
}

// Validar password
$validacion = Validador::validarPassword('mipassword123');

// Validar formulario completo
$validacion = Validador::validarRegistro($_POST);
if (!$validacion['valido']) {
    foreach ($validacion['errores'] as $campo => $error) {
        echo "$campo: $error<br>";
    }
}
```

---

## 🔐 Seguridad Implementada

✅ **Hash de contraseñas** con `password_hash()` (BCrypt, cost 12)
✅ **Validación de entrada** (XSS protection, sanitización)
✅ **Sesiones seguras** con regeneración de ID
✅ **Timeout de sesión** (2 horas de inactividad)
✅ **Protección CSRF** (preparado para implementar tokens)
✅ **Verificación de rol** (solo admins pueden acceder)
✅ **Passwords verificados** con `password_verify()`

---

## 📝 Estructura de la Sesión

Cuando un admin inicia sesión, se guardan estos datos:

```php
$_SESSION = [
    'admin_logueado' => true,
    'admin_id' => 1,
    'admin_nombre' => 'Admin',
    'admin_apellido' => 'Principal',
    'admin_email' => 'admin@tiendamistica.com',
    'admin_rol' => 'admin',
    'admin_login_time' => 1699999999
];
```

---

## ⚠️ IMPORTANTE - Checklist de Seguridad

Antes de subir a producción:

- [ ] Eliminar `crear_usuario_admin.php`
- [ ] Cambiar la contraseña del admin desde el panel
- [ ] Configurar `display_errors = 0` en `config.php`
- [ ] Usar HTTPS en producción
- [ ] Cambiar credenciales de base de datos
- [ ] Implementar rate limiting en login
- [ ] Agregar logs de intentos fallidos
- [ ] Implementar recuperación de contraseña

---

## 🐛 Solución de Problemas

### **"Error de conexión a BD"**
- Verificar que XAMPP esté corriendo
- Verificar que la base de datos `tienda_mistica` exista
- Verificar credenciales en `clases/Conexion.php`

### **"Email o contraseña incorrectos"**
- Verificar que el usuario exista en la tabla `usuarios`
- Verificar que el rol sea 'admin'
- Verificar que el campo `activo` sea 1

### **"Sesión expirada"**
- La sesión expira después de 2 horas de inactividad
- Volver a iniciar sesión

### **No redirige después del login**
- Verificar que `admin/index.php` exista
- Revisar la URL base en `config.php`

---

## 📦 Próximos Pasos Sugeridos

1. **Implementar el panel principal** (`admin/index.php`)
   - Dashboard con estadísticas
   - Menú de navegación
   - Links a secciones

2. **Crear gestión de usuarios**
   - Listar usuarios
   - Editar usuarios
   - Cambiar contraseñas
   - Desactivar usuarios

3. **Agregar recuperación de contraseña**
   - Envío de email
   - Token de recuperación
   - Reseteo seguro

4. **Implementar permisos granulares**
   - Roles adicionales (editor, moderador)
   - Permisos por sección

---

## 💡 Ejemplo de Uso en index.php

```php
<?php
require_once 'includes/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin - Tienda Mística</title>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($usuarioActual['nombre']) ?></h1>
    
    <nav>
        <a href="seccions/dashboard.php">Dashboard</a>
        <a href="seccions/duendes_listar.php">Duendes</a>
        <a href="seccions/pedidos_listar.php">Pedidos</a>
        <a href="logout.php">Cerrar Sesión</a>
    </nav>
    
    <p>Email: <?= htmlspecialchars($usuarioActual['email']) ?></p>
    <p>Último acceso: <?= date('d/m/Y H:i') ?></p>
</body>
</html>
```

---

## ✨ ¡Listo!

Tu sistema de autenticación está completamente funcional. Seguí estos pasos y tendrás tu panel admin protegido y funcionando.

**¿Dudas?** Revisá los comentarios en el código, todo está documentado.

🍀 **¡Buena suerte con tu Tienda Mística!** 🍀

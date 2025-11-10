# Panel de Administración - Tienda Mística

## Estructura del proyecto

### Archivos principales
- `index.php` - Punto de entrada principal del admin
- `login.php` - Página de inicio de sesión
- `logout.php` - Cerrar sesión
- `config.php` - Configuración del panel

### Carpetas

#### `/seccions/` - Páginas de gestión
- **Dashboard**: `dashboard.php`
- **Duendes**: `duendes_listar.php`, `duendes_crear.php`, `duendes_editar.php`, `duendes_eliminar.php`
- **Blogs**: `blogs_listar.php`, `blogs_crear.php`, `blogs_editar.php`, `blogs_eliminar.php`
- **Pedidos**: `pedidos_listar.php`, `pedidos_detalle.php`
- **Usuarios**: `usuarios_listar.php`, `usuarios_crear.php`, `usuarios_editar.php`
- **Otros**: `categorias.php`, `configuracion.php`, `reportes.php`

#### `/clases/` - Clases PHP
- `Auth.php` - Autenticación
- `Admin.php` - Gestión de administradores
- `Validador.php` - Validación de datos
- `Pedidos.php` - Gestión de pedidos
- `Estadisticas.php` - Reportes y estadísticas
- `Upload.php` - Subida de imágenes

#### `/includes/` - Componentes compartidos
- `header.php` - Encabezado
- `footer.php` - Pie de página
- `sidebar.php` - Menú lateral
- `navbar.php` - Barra superior
- `verificar_sesion.php` - Verificación de autenticación

#### `/assets/` - Recursos estáticos
- `/css/admin.css` - Estilos del admin
- `/js/admin.js` - JavaScript del admin

## Próximos pasos
1. Implementar sistema de autenticación
2. Crear CRUD completo para duendes
3. Crear CRUD para blogs
4. Dashboard con estadísticas
5. Gestión de pedidos

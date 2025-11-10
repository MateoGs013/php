<?php
/**
 * Script de prueba para verificar que la clase Secciones funciona con la BD
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'clases/Secciones.php';

echo "<h1>🧪 Test de Clase Secciones con Base de Datos</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .error { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .info { background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; margin: 10px 0; border-radius: 5px; }
    table { border-collapse: collapse; width: 100%; background: white; margin: 10px 0; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #2d5f3f; color: white; }
    tr:nth-child(even) { background: #f9f9f9; }
    code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
</style>";

// Test 1: Cargar todas las secciones
echo "<h2>Test 1: Cargar todas las secciones (cargarSeccionesDesdeDB)</h2>";
try {
    $secciones = Secciones::cargarSeccionesDesdeDB();
    
    if (empty($secciones)) {
        echo "<div class='error'>❌ No se encontraron secciones en la base de datos</div>";
    } else {
        echo "<div class='success'>✅ Se cargaron " . count($secciones) . " secciones correctamente</div>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Vínculo</th><th>Título</th><th>Descripción</th><th>En Menú</th></tr>";
        foreach ($secciones as $seccion) {
            echo "<tr>";
            echo "<td>" . $seccion->getIdSeccion() . "</td>";
            echo "<td><code>" . htmlspecialchars($seccion->getVinculo()) . "</code></td>";
            echo "<td>" . htmlspecialchars($seccion->getTitulo()) . "</td>";
            echo "<td>" . htmlspecialchars(substr($seccion->getDescripcion(), 0, 50)) . "...</td>";
            echo "<td>" . ($seccion->getMenu() ? '✓ Sí' : '✗ No') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Test 2: Secciones válidas
echo "<h2>Test 2: Obtener vínculos válidos (secciones_validas)</h2>";
try {
    $validas = Secciones::secciones_validas();
    
    if (empty($validas)) {
        echo "<div class='error'>❌ No se encontraron vínculos válidos</div>";
    } else {
        echo "<div class='success'>✅ Se encontraron " . count($validas) . " vínculos válidos</div>";
        echo "<div class='info'>";
        echo "<strong>Vínculos:</strong> " . implode(', ', array_map(function($v) {
            return "<code>$v</code>";
        }, $validas));
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Test 3: Secciones del menú
echo "<h2>Test 3: Secciones del menú (secciones_menu)</h2>";
try {
    $menu = Secciones::secciones_menu();
    
    if (empty($menu)) {
        echo "<div class='error'>❌ No se encontraron secciones para el menú</div>";
    } else {
        echo "<div class='success'>✅ Se encontraron " . count($menu) . " secciones para el menú</div>";
        echo "<div class='info'>";
        echo "<strong>En menú:</strong> " . implode(', ', array_map(function($v) {
            return "<code>$v</code>";
        }, $menu));
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Test 4: Buscar sección por vínculo
echo "<h2>Test 4: Buscar sección por vínculo (obtenerPorVinculo)</h2>";
try {
    $seccion = Secciones::obtenerPorVinculo('catalogo');
    
    if ($seccion) {
        echo "<div class='success'>✅ Sección 'catalogo' encontrada</div>";
        echo "<table>";
        echo "<tr><th>Campo</th><th>Valor</th></tr>";
        echo "<tr><td>ID</td><td>" . $seccion->getIdSeccion() . "</td></tr>";
        echo "<tr><td>Vínculo</td><td><code>" . htmlspecialchars($seccion->getVinculo()) . "</code></td></tr>";
        echo "<tr><td>Título</td><td>" . htmlspecialchars($seccion->getTitulo()) . "</td></tr>";
        echo "<tr><td>Descripción</td><td>" . htmlspecialchars($seccion->getDescripcion()) . "</td></tr>";
        echo "<tr><td>En Menú</td><td>" . ($seccion->getMenu() ? '✓ Sí' : '✗ No') . "</td></tr>";
        echo "</table>";
    } else {
        echo "<div class='error'>❌ Sección 'catalogo' no encontrada</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Test 5: Obtener todas como array
echo "<h2>Test 5: Obtener todas las secciones como array (obtenerTodas)</h2>";
try {
    $todas = Secciones::obtenerTodas();
    
    if (empty($todas)) {
        echo "<div class='error'>❌ No se encontraron secciones</div>";
    } else {
        echo "<div class='success'>✅ Se obtuvieron " . count($todas) . " secciones como array asociativo</div>";
        echo "<pre style='background: white; padding: 15px; border-radius: 5px; overflow: auto;'>";
        print_r($todas);
        echo "</pre>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Test 6: Compatibilidad con código antiguo
echo "<h2>Test 6: Compatibilidad (cargarSeccionesDesdeJSON)</h2>";
try {
    $secciones_json = Secciones::cargarSeccionesDesdeJSON();
    
    if (empty($secciones_json)) {
        echo "<div class='error'>❌ El método de compatibilidad no funciona</div>";
    } else {
        echo "<div class='success'>✅ El método cargarSeccionesDesdeJSON() funciona correctamente (redirige a DB)</div>";
        echo "<div class='info'>Se cargaron " . count($secciones_json) . " secciones usando el método antiguo</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "<hr>";
echo "<h2>✅ Tests completados</h2>";
echo "<p><a href='index.php'>← Volver al sitio</a></p>";
?>

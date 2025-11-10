<?php
/**
 * Clase Secciones - Gestión de secciones del sitio web
 * Trabaja con la tabla 'secciones' de la base de datos
 */
require_once 'Conexion.php';

class Secciones {
    private $id_seccion;
    private $vinculo;
    private $titulo;
    private $descripcion;
    private $menu;
    
    private static $conexion = null;

    /**
     * Obtener instancia de conexión a la BD
     */
    private static function getConexion() {
        if (self::$conexion === null) {
            $conn = new Conexion();
            self::$conexion = $conn->getConexion();
        }
        return self::$conexion;
    }

    // Getters
    public function getIdSeccion() {
        return $this->id_seccion;
    }
    
    public function getVinculo() {
        return $this->vinculo;
    }
    
    public function getTitulo() {
        return $this->titulo;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function getMenu() {
        return $this->menu;
    }

    /**
     * Cargar todas las secciones desde la base de datos
     * @return array Array de objetos Secciones
     */
    public static function cargarSeccionesDesdeDB() {
        try {
            $db = self::getConexion();
            if (!$db) {
                return [];
            }
            
            $query = "SELECT id_seccion, vinculo, titulo, descripcion, menu 
                      FROM secciones 
                      ORDER BY id_seccion ASC";
            
            $stmt = $db->prepare($query);
            $stmt->execute();
            
            $secciones = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $seccion = new self();
                $seccion->id_seccion = $row['id_seccion'];
                $seccion->vinculo = $row['vinculo'];
                $seccion->titulo = $row['titulo'];
                $seccion->descripcion = $row['descripcion'];
                $seccion->menu = (bool)$row['menu'];
                $secciones[] = $seccion;
            }
            
            return $secciones;
            
        } catch (PDOException $e) {
            error_log("Error en cargarSeccionesDesdeDB: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Alias para mantener compatibilidad con código existente
     * @return array Array de objetos Secciones
     */
    public static function cargarSeccionesDesdeJSON() {
        return self::cargarSeccionesDesdeDB();
    }

    /**
     * Obtener array de vínculos válidos
     * @return array Array de strings con los vínculos
     */
    public static function secciones_validas(): array {
        try {
            $db = self::getConexion();
            if (!$db) {
                return [];
            }
            
            $query = "SELECT vinculo FROM secciones ORDER BY id_seccion ASC";
            $stmt = $db->prepare($query);
            $stmt->execute();
            
            $secciones_validas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $secciones_validas[] = $row['vinculo'];
            }
            
            return $secciones_validas;
            
        } catch (PDOException $e) {
            error_log("Error en secciones_validas: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener vínculos de secciones que deben aparecer en el menú
     * @return array Array de strings con los vínculos
     */
    public static function secciones_menu(): array {
        try {
            $db = self::getConexion();
            if (!$db) {
                return [];
            }
            
            $query = "SELECT vinculo FROM secciones WHERE menu = 1 ORDER BY id_seccion ASC";
            $stmt = $db->prepare($query);
            $stmt->execute();
            
            $secciones_menu = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $secciones_menu[] = $row['vinculo'];
            }
            
            return $secciones_menu;
            
        } catch (PDOException $e) {
            error_log("Error en secciones_menu: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener una sección por su vínculo
     * @param string $vinculo
     * @return Secciones|null
     */
    public static function obtenerPorVinculo($vinculo) {
        try {
            $db = self::getConexion();
            if (!$db) {
                return null;
            }
            
            $query = "SELECT id_seccion, vinculo, titulo, descripcion, menu 
                      FROM secciones 
                      WHERE vinculo = :vinculo";
            
            $stmt = $db->prepare($query);
            $stmt->execute([':vinculo' => $vinculo]);
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $seccion = new self();
                $seccion->id_seccion = $row['id_seccion'];
                $seccion->vinculo = $row['vinculo'];
                $seccion->titulo = $row['titulo'];
                $seccion->descripcion = $row['descripcion'];
                $seccion->menu = (bool)$row['menu'];
                return $seccion;
            }
            
            return null;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerPorVinculo: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtener todas las secciones como array asociativo
     * @return array
     */
    public static function obtenerTodas() {
        try {
            $db = self::getConexion();
            if (!$db) {
                return [];
            }
            
            $query = "SELECT id_seccion, vinculo, titulo, descripcion, menu 
                      FROM secciones 
                      ORDER BY id_seccion ASC";
            
            $stmt = $db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en obtenerTodas: " . $e->getMessage());
            return [];
        }
    }
}
?>
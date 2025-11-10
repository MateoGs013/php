<?php
class Accesorios
{
    private $id;
    private $nombre;

    public static function todosAccesorios(): array
    {
        require_once "Conexion.php";
        try {
            $conexion = new Conexion();
            $db = $conexion->getConexion();
            if ($db === null) {
                return [];
            }
            $stmt = $db->query("SELECT * FROM accesorios");
            $stmt->setFetchMode(PDO::FETCH_CLASS, Accesorios::class);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo '<script>console.error("Error al cargar duendes: ' . addslashes($e->getMessage()) . '");</script>';
            return [];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }
}

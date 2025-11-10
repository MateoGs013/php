<?php
class Conexion
{
    private const DB_SERVER = "localhost";
    private const DB_USER = "root";
    private const DB_PASS = "";
    private const DB_NAME = "tienda_mistica";
    private const DB_CHARSET = "utf8mb4";

    private const DB_DSN = "mysql:host=" . self::DB_SERVER . ";dbname=" . self::DB_NAME . ";charset=" . self::DB_CHARSET;
    
    private ?PDO $db;

    public function __construct()
    {
        try
        {
            $this->db = new PDO(self::DB_DSN, self::DB_USER, self::DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e)
        {
            // Mostrar error con estilo pero permitir que el JS se ejecute
            echo '<script>console.error("Error de BD: ' . addslashes($e->getMessage()) . '");</script>';
            echo '<div style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);z-index:10000;background:#000;color:#ff006e;padding:30px;border:3px solid #ff006e;font-family:monospace;max-width:600px;">';
            echo '<h2 style="color:#ff006e;">⚠️ ERROR DE CONEXIÓN A BD</h2>';
            echo '<p>No se pudo conectar a MySQL. Verifica:</p>';
            echo '<ul><li>XAMPP MySQL esté corriendo</li>';
            echo '<li>Base de datos ' . self::DB_NAME . ' exista</li>';
            echo '<li>Usuario: root, Password: vacío</li></ul>';
            echo '<p style="font-size:11px;color:#666;margin-top:20px;">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
            // No usar die() para que el JS pueda ejecutarse
            $this->db = null;
        }
    }

    public function getConexion():?PDO
    {
        return $this->db;
    }

}
?>
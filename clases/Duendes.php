<?php
class Duendes {
    private $id;
    private $nombre;
    private $tipo;
    private $color_principal;
    private $altura_cm;
    private $personalidad;
    private $rareza;
    private $precio_en_oro;
    private $efecto_mágico;
    private $afinidad_elemental;
    private $nivel_de_maldad;
    private $nivel_de_suerte;
    private $origen_mitológico;
    private $accesorios;
    private $material_principal;
    private $disponible;
    private $fecha_creación;
    private $popularidad;
    private $recomendado_para;
    private $advertencias;
    private $imagen_url;
    private $descripcion;

    /* public static function todosDuendes() {
        $jsonData = file_get_contents('data/duendes.json');
        $dataArray = json_decode($jsonData); // stdClass array
        $duendes = [];
        foreach ($dataArray as $data) {
            $duende = new self();
            $duende->id = $data->id;
            $duende->nombre = $data->nombre;
            $duende->tipo = $data->tipo;
            $duende->color_principal = $data->color_principal;
            $duende->altura_cm = $data->altura_cm;
            $duende->personalidad = $data->personalidad;
            $duende->rareza = $data->rareza;
            $duende->precio_en_oro = $data->precio_en_oro;
            $duende->efecto_mágico = $data->efecto_mágico;
            $duende->afinidad_elemental = $data->afinidad_elemental;
            $duende->nivel_de_maldad = $data->nivel_de_maldad;
            $duende->nivel_de_suerte = $data->nivel_de_suerte;
            $duende->origen_mitológico = $data->origen_mitológico;
            $duende->accesorios = $data->accesorios;
            $duende->material_principal = $data->material_principal;
            $duende->disponible = $data->disponible;
            $duende->fecha_creación = $data->fecha_creación;
            $duende->popularidad = $data->popularidad;
            $duende->recomendado_para = $data->recomendado_para;
            $duende->advertencias = $data->advertencias;
            $duende->imagen_url = $data->imagen_url;
            $duende->descripcion = $data->descripcion;
            $duendes[] = $duende;
        }
        return $duendes;
    } */

    public static function todosDuendes(): array{
        require_once 'clases/Conexion.php';
        try {
            $conexion = new Conexion();
            $db = $conexion->getConexion();
            
            if ($db === null) {
                return []; // Retornar array vacío si no hay conexión
            }

            // Usar alias y JOINs para que coincidan con las propiedades de la clase
            $stmt = $db->query("
                SELECT 
                    d.id_duende as id,
                    d.nombre,
                    d.tipo,
                    d.color_principal,
                    d.altura_cm,
                    d.personalidad,
                    r.nombre as rareza,
                    d.precio_en_oro,
                    d.efecto_magico as efecto_mágico,
                    e.nombre as afinidad_elemental,
                    d.nivel_maldad as nivel_de_maldad,
                    d.nivel_suerte as nivel_de_suerte,
                    d.origen_mitologico as origen_mitológico,
                    '' as accesorios,
                    m.nombre as material_principal,
                    d.disponible,
                    d.fecha_creacion as fecha_creación,
                    d.popularidad,
                    d.recomendado_para,
                    d.advertencias,
                    d.imagen_url,
                    d.descripcion
                FROM duendes d
                LEFT JOIN rareza r ON d.id_rareza = r.id_rareza
                LEFT JOIN elementos e ON d.id_elemento = e.id_elemento
                LEFT JOIN materiales m ON d.id_material = m.id_material
            ");
            $stmt->setFetchMode(PDO::FETCH_CLASS, Duendes::class);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo '<script>console.error("Error al cargar duendes: ' . addslashes($e->getMessage()) . '");</script>';
            return [];
        }
    }
    // Métodos para acceder a los atributos
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getColorPrincipal() {
        return $this->color_principal;
    }

    public function getAlturaCm() {
        return $this->altura_cm;
    }

    public function getPersonalidad() {
        return $this->personalidad;
    }

    public function getRareza() {
        return $this->rareza;
    }

    public function getPrecioEnOro() {
        return $this->precio_en_oro;
    }

    public function getEfectoMagico() {
        return $this->efecto_mágico;
    }

    public function getAfinidadElemental() {
        return $this->afinidad_elemental;
    }

    public function getNivelDeMaldad() {
        return $this->nivel_de_maldad;
    }

    public function getNivelDeSuerte() {
        return $this->nivel_de_suerte;
    }

    public function getOrigenMitologico() {
        return $this->origen_mitológico;
    }

    public function getAccesorios() {
        return $this->accesorios;
    }

    public function getMaterialPrincipal() {
        return $this->material_principal;
    }

    public function isDisponible() {
        return $this->disponible;
    }

    public function getFechaCreacion() {
        return $this->fecha_creación;
    }

    public function getPopularidad() {
        return $this->popularidad;
    }

    public function getRecomendadoPara() {
        return $this->recomendado_para;
    }

    public function getAdvertencias() {
        return $this->advertencias;
    }

    public function getImagenUrl() {
        return $this->imagen_url;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }
}
?>
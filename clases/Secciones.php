<?php
class Secciones {
    private $vinculo;
    private $titulo;
    private $descripcion;
    private $menu;

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

    public static function cargarSeccionesDesdeJSON() {
        $jsonData = file_get_contents('data/secciones.json');
        $dataArray = json_decode($jsonData);
        $secciones = [];
        foreach ($dataArray as $data ) {
            $seccion = new self();
            $seccion -> vinculo = $data -> vinculo;
            $seccion -> titulo = $data -> titulo;
            $seccion -> descripcion = $data -> descripcion;
            $seccion -> menu = $data -> menu;
            $secciones[] = $seccion;
        }
        return $secciones;
    }

    public static function secciones_validas(): array {
        $secciones_validas = [];
        $jsonData = file_get_contents('data/secciones.json');
        $dataArray = json_decode($jsonData, true);
        foreach ($dataArray as $data) {
            $secciones_validas[] = $data['vinculo'];
        }
        return $secciones_validas;
    }

    public static function secciones_menu(): array {
        $secciones_menu = [];
        $jsonData = file_get_contents('data/secciones.json');
        $dataArray = json_decode($jsonData, true);
        foreach ($dataArray as $data) {
            if ($data['menu']) {
                $secciones_menu[] = $data['vinculo'];
            }
        }
        return $secciones_menu;
    }
}
?>
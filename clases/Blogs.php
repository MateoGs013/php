<?php
class Blogs {
    private $id;
    private $titulo;
    private $slug;
    private $autor;
    private $fecha_publicacion;
    private $categoria;
    private $etiquetas;
    private $imagen_portada;
    private $descripcion_corta;
    private $contenido;
    private $lecturas_recomendadas;
    private $popularidad;

    public static function cargarBlogsDesdeJSON() {
    $jsonData = file_get_contents('data/blogs.json');
    $root = json_decode($jsonData) ?: (object)[]; // { blogs: [...] }
    $items = isset($root->blogs) ? $root->blogs : [];
        $blogs = [];
        foreach ($items as $data) {
            $blog = new self();
            $blog->id = $data->id;
            $blog->titulo = $data->titulo;
            $blog->slug = $data->slug;
            $blog->autor = $data->autor;
            $blog->fecha_publicacion = $data->fecha_publicacion;
            $blog->categoria = $data->categoria;
            $blog->etiquetas = $data->etiquetas;
            $blog->imagen_portada = $data->imagen_portada;
            $blog->descripcion_corta = $data->descripcion_corta;
            $blog->contenido = $data->contenido;
            $blog->lecturas_recomendadas = $data->lecturas_recomendadas;
            $blog->popularidad = $data->popularidad;
            $blogs[] = $blog;
        }
        return $blogs;
    }
    // Métodos para acceder a los atributos
    public function getId() {
        return $this->id;
    }
    public function getTitulo() {
        return $this->titulo;
    }
    public function getSlug() {
        return $this->slug;
    }
    public function getAutor() {
        return $this->autor;
    }
    public function getFechaPublicacion() {
        return $this->fecha_publicacion;
    }
    public function getCategoria() {
        return $this->categoria;
    }
    public function getEtiquetas() {
        return $this->etiquetas;
    }
    public function getImagenPortada() {
        return $this->imagen_portada;
    }
    public function getDescripcionCorta() {
        return $this->descripcion_corta;
    }
    public function getContenido() {
        return $this->contenido;
    }
    public function getLecturasRecomendadas() {
        return $this->lecturas_recomendadas;
    }
    public function getPopularidad() {
        return $this->popularidad;
    }
    
}
?>
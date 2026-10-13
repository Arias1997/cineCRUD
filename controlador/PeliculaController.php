<?php

require_once "modelo/Pelicula.php";
require_once "modelo/PeliculaDao.php";

class PeliculaController{
    private $dao;
    private $carpetaUploads;

    public function __construct(){
        $this->dao = new PeliculaDao();
        $this->carpetaUploads = "public/uploads/";
    }

    // Mostrar el listado de películas (con búsqueda opcional)
    public function index(){
        $busqueda = trim($_GET['buscar'] ?? '');

        if ($busqueda !== '') {
            $peliculas = $this->dao->buscar($busqueda);
        } else {
            $peliculas = $this->dao->listar();
        }

        require "vista/peliculas/index.php";
    }

    // Mostrar el formulario vacío para agregar
    public function crear(){
        $pelicula = new Pelicula();
        $errores = [];
        require "vista/peliculas/formulario.php";
    }

    // Guardar una película nueva
    public function guardar(){ 
        $pelicula = new Pelicula(
            null, 
            trim($_POST['nombre'] ?? ''), 
            trim($_POST['genero'] ?? ''), 
            $_POST['duracion'] ?? 0);
        $errores = $this->validar($pelicula);

        // La imagen es obligatoria al crear
        if (empty($_FILES['imagenportada']['name'])) {
            $errores[] = "La imagen de portada es obligatoria.";
        }

        if (empty($errores)) {
            $nombreImagen = $this->subirImagen($_FILES['imagenportada'], $errores);
            if ($nombreImagen) {
                $pelicula->setImagenportada($nombreImagen);
            }
        }

        if (!empty($errores)) {
            require "vista/peliculas/formulario.php";
            return;
        }

        $this->dao->insertar($pelicula);
        header("Location: index.php?accion=index");
        exit;
    }

    // Mostrar el formulario con los datos para editar
    public function editar()
    {
        $id = $_GET['id'] ?? 0;
        $pelicula = $this->dao->obtenerPorId($id);

        if (!$pelicula) {
            header("Location: index.php?accion=index");
            exit;
        }

        $errores = [];
        require "vista/peliculas/formulario.php";
    }

    // Guardar los cambios de una película existente
    public function actualizar()
    {
        $id = $_POST['id'] ?? 0;
        $actual = $this->dao->obtenerPorId($id);

        if (!$actual) {
            header("Location: index.php?accion=index");
            exit;
        }

        $pelicula = new Pelicula(
            $id,
            trim($_POST['nombre'] ?? ''),
            trim($_POST['genero'] ?? ''),
            $_POST['duracion'] ?? 0,
            $actual->getImagenportada() // por defecto conserva la imagen actual
        );

        $errores = $this->validar($pelicula);

        // Si se subió una nueva imagen, reemplaza la anterior
        if (empty($errores) && !empty($_FILES['imagenportada']['name'])) {
            $nombreImagen = $this->subirImagen($_FILES['imagenportada'], $errores);
            if ($nombreImagen) {
                $this->borrarImagen($actual->getImagenportada());
                $pelicula->setImagenportada($nombreImagen);
            }
        }

        if (!empty($errores)) {
            require "vista/peliculas/formulario.php";
            return;
        }

        $this->dao->actualizar($pelicula);
        header("Location: index.php?accion=index");
        exit;
    }

    // Eliminar una película y su imagen
    public function eliminar()
    {
        $id = $_GET['id'] ?? 0;
        $pelicula = $this->dao->obtenerPorId($id);

        if ($pelicula) {
            $this->borrarImagen($pelicula->getImagenportada());
            $this->dao->eliminar($id);
        }

        header("Location: index.php?accion=index");
        exit;
    }

    // Validar los campos de texto y numéricos
    private function validar(Pelicula $pelicula)
    {
        $errores = [];

        if ($pelicula->getNombre() === '') {
            $errores[] = "El nombre es obligatorio.";
        } elseif (mb_strlen($pelicula->getNombre()) > 100) {
            $errores[] = "El nombre no puede superar los 100 caracteres.";
        }

        if ($pelicula->getGenero() === '') {
            $errores[] = "El género es obligatorio.";
        } elseif (mb_strlen($pelicula->getGenero()) > 100) {
            $errores[] = "El género no puede superar los 100 caracteres.";
        }

        $duracion = $pelicula->getDuracion();
        if (!filter_var($duracion, FILTER_VALIDATE_INT) || $duracion <= 0) {
            $errores[] = "La duración debe ser un número entero mayor a 0 (en minutos).";
        }

        return $errores;
    }

    // Subir la imagen y devolver el nombre guardado (o null si hay error)
    private function subirImagen($archivo, &$errores){
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $errores[] = "Error al subir la imagen.";
            return null;
        }

        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $extensionesPermitidas)) {
            $errores[] = "Formato de imagen no permitido (usa jpg, jpeg, png, gif o webp).";
            return null;
        }

        if ($archivo['size'] > 2 * 1024 * 1024) {
            $errores[] = "La imagen no puede superar los 2 MB.";
            return null;
        }

        if (!is_dir($this->carpetaUploads)) {
            mkdir($this->carpetaUploads, 0777, true);
        }

        // Nombre único para evitar que se sobrescriban imágenes
        $nombreFinal = uniqid('portada_', true) . '.' . $extension;

        if (!move_uploaded_file($archivo['tmp_name'], $this->carpetaUploads . $nombreFinal)) {
            $errores[] = "No se pudo guardar la imagen en el servidor.";
            return null;
        }

        return $nombreFinal;
    }

    // Borrar una imagen del disco
    private function borrarImagen($nombreImagen)
    {
        if ($nombreImagen) {
            $ruta = $this->carpetaUploads . $nombreImagen;
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
    }
}
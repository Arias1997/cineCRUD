<?php

require_once "config/database.php";
require_once "modelo/Pelicula.php";

class PeliculaDao
{
    private $conexion;

    public function __construct()
    {
        $database = new Database();
        $this->conexion = $database->getConexion();
    }

    // CREATE: insertar una película
    public function insertar(Pelicula $pelicula){
        $sql = "INSERT INTO pelicula (nombre, genero, duracion, imagenportada)
                VALUES (:nombre, :genero, :duracion, :imagenportada)";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre'        => $pelicula->getNombre(),
            ':genero'        => $pelicula->getGenero(),
            ':duracion'      => $pelicula->getDuracion(),
            ':imagenportada' => $pelicula->getImagenportada()
        ]);
    }

    // READ: listar todas las películas
    public function listar(){
        $sql = "SELECT id, nombre, genero, duracion, imagenportada FROM pelicula ORDER BY id DESC";
        $stmt = $this->conexion->query($sql);

        $peliculas = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $peliculas[] = new Pelicula(
                $fila['id'],
                $fila['nombre'],
                $fila['genero'],
                $fila['duracion'],
                $fila['imagenportada']
            );
        }

        return $peliculas;
    }

    // READ: buscar películas por nombre o género
    public function buscar($termino){
        $sql = "SELECT id, nombre, genero, duracion, imagenportada
                FROM pelicula
                WHERE nombre LIKE :nombre OR genero LIKE :genero
                ORDER BY id DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => '%' . $termino . '%',
            ':genero' => '%' . $termino . '%'
        ]);

        $peliculas = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $peliculas[] = new Pelicula(
                $fila['id'],
                $fila['nombre'],
                $fila['genero'],
                $fila['duracion'],
                $fila['imagenportada']
            );
        }

        return $peliculas;
    }

    // READ: obtener una película por id
    public function obtenerPorId($id){
        $sql = "SELECT id, nombre, genero, duracion, imagenportada FROM pelicula WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null;
        }

        return new Pelicula(
            $fila['id'],
            $fila['nombre'],
            $fila['genero'],
            $fila['duracion'],
            $fila['imagenportada']
        );
    }

    // UPDATE: actualizar o editar una película
    public function actualizar(Pelicula $pelicula){
        $sql = "UPDATE pelicula
                SET nombre = :nombre,
                    genero = :genero,
                    duracion = :duracion,
                    imagenportada = :imagenportada
                WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre'        => $pelicula->getNombre(),
            ':genero'        => $pelicula->getGenero(),
            ':duracion'      => $pelicula->getDuracion(),
            ':imagenportada' => $pelicula->getImagenportada(),
            ':id'            => $pelicula->getId()
        ]);
    }

    // DELETE: eliminar una película
    public function eliminar($id){
        $sql = "DELETE FROM pelicula WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
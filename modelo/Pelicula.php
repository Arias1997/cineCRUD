<?php

class Pelicula
{
    private $id;
    private $nombre;
    private $genero;
    private $duracion;
    private $imagenportada;

    public function __construct($id = null, $nombre = "", $genero = "", $duracion = 0, $imagenportada = ""){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->genero = $genero;
        $this->duracion = $duracion;
        $this->imagenportada = $imagenportada;
    }

    // Getters
    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getGenero(){
        return $this->genero;
    }

    public function getDuracion(){
        return $this->duracion;
    }

    public function getImagenportada(){
        return $this->imagenportada;
    }

    // Setters
    public function setId($id){
        $this->id = $id;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setGenero($genero){
        $this->genero = $genero;
    }

    public function setDuracion($duracion){
        $this->duracion = $duracion;
    }

    public function setImagenportada($imagenportada){
        $this->imagenportada = $imagenportada;
    }
}
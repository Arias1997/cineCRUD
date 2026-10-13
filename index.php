<?php

require_once "controlador/PeliculaController.php";

$controlador = new PeliculaController();

$accion = $_GET['accion'] ?? 'index';

switch ($accion) {
    case 'index':
        $controlador->index();
        break;

    case 'crear':
        $controlador->crear();
        break;

    case 'guardar':
        $controlador->guardar();
        break;

    case 'editar':
        $controlador->editar();
        break;

    case 'actualizar':
        $controlador->actualizar();
        break;

    case 'eliminar':
        $controlador->eliminar();
        break;

    default:
        $controlador->index();
        break;
}
<?php

$controladorNombre = $_GET['controlador'] ?? "controladorAsignatura";
$metodoNombre = $_GET['metodo'] ?? "mostrarTabla";
require "controladores/".$controladorNombre.".php";
$controlador = new $controladorNombre();
$datos=$controlador->$metodoNombre();
include "vistas/".$controlador->vista;

?>
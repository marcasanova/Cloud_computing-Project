<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$base_de_datos = "cloud_computing";

$conexion = new mysqli($host, $usuario, $clave, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

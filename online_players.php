<?php
include('db.php'); // Asegúrate de que este archivo contiene la conexión a tu base de datos.

$query = "SELECT username FROM login WHERE is_online = 1";
$resultado = mysqli_query($conexion, $query);

$jugadoresEnLinea = array();
while ($row = mysqli_fetch_assoc($resultado)) {
    $jugadoresEnLinea[] = $row['username'];
}

echo json_encode($jugadoresEnLinea);
?>

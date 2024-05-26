<?php
session_start();
include 'db.php'; // Asegúrate de incluir tu conexión a la base de datos aquí

echo $_SESSION['usuario'];


if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if (isset($_POST['ganador'])) {
    echo "Ganador: " . $_POST['ganador']; // Ver qué se está recibiendo
} else { 
    echo "No se recibió el ganador";
}

if (isset($_POST['ganador']) && isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    if ($_POST['ganador'] === 'jugador') {
        $query = "UPDATE login SET wins = wins + 1 WHERE username = ?";
    } elseif ($_POST['ganador'] === 'IA') {
        $query = "UPDATE login SET losses = losses + 1 WHERE username = ?";
    }

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("s", $usuario);
        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
    
    echo json_encode(['success' => 'Marcador actualizado']);
}
?>

<?php
session_start();
include 'db.php'; // Incluye la conexión a la base de datos aquí

// Verifica si la sesión está activa y si la variable de usuario está definida
if (!isset($_SESSION['usuario'])) {
    // Redirige a la página de inicio de sesión si la sesión no está activa
    header("Location: index.php");
    exit();
}

// Consulta para obtener los usuarios y sus victorias y derrotas
$query = "SELECT username, wins, losses FROM login ORDER BY wins DESC, losses";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scores - Tic Tac Toe</title>
    <link rel="stylesheet" href="css/record.css">
</head>
<body>
    <div class="container">
        <h1>Scores</h1>
        <h2>Tick Tack Toe</h2>
        <table>
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Victories</th>
                    <th>Losses</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . htmlspecialchars($row['username']) . "</td><td>" . $row['wins'] . "</td><td>" . $row['losses'] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay datos para mostrar</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button class="return-button" onclick="window.location.href='home.php'">Return</button>
    </div>
</body>
</html>

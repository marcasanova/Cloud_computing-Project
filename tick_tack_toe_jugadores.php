<?php
session_start();

// Verifica si la sesión está activa y si la variable de usuario está definida
if (!isset($_SESSION['usuario'])) {
    // Redirige a la página de inicio de sesión si la sesión no está activa
    header("Location: index.php");
    exit();
}

// Asigna el valor de la variable de sesión a la variable $usuario
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <link rel="stylesheet" href="css/tick_tack_toe.css">
</head>
<body>
    <div class="container">
    <h1>Tick Tack Toe</h1>
        <div class="game-container">
            <table id="tablero">
                <tr>
                    <td class="casilla"></td>
                    <td class="casilla"></td>
                    <td class="casilla"></td>
                </tr>
                <tr>
                    <td class="casilla"></td>
                    <td class="casilla"></td>
                    <td class="casilla"></td>
                </tr>
                <tr>
                    <td class="casilla"></td>
                    <td class="casilla"></td>
                    <td class="casilla"></td>
                </tr>
            </table>
            
            <div class="online-players">
                <h2>Online Players</h2>
                <ul id="online-players-list">
                    <!-- Los jugadores en línea se cargarán aquí dinámicamente -->
                </ul>
            </div>

        </div>
    </div>
    <script src="js/tick_tack_toe_jugadores.js"></script>
</body>
</html>

<?php
session_start();
include('db.php'); // Asume que este es tu script de conexión

// Verifica si la sesión está activa y si la variable de usuario está definida
if (isset($_SESSION['usuario'])) {
    $usuario = mysqli_real_escape_string($conexion, $_SESSION['usuario']);
    
    // Actualizar el estado is_online a false
    $actualizar_online = "UPDATE login SET is_online = 0 WHERE username = ?";
    $stmt = mysqli_prepare($conexion, $actualizar_online);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    
    // Cerrar sesión
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
    
    // Redirigir al usuario a la página de inicio de sesión o a la principal
    header("Location: index.php");
    exit();
} else {
    // Si no hay sesión activa, redirige directamente a la página de inicio
    header("Location: index.php");
    exit();
}
?>

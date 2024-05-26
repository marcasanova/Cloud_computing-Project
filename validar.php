<?php
include('db.php');

$usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
$password = mysqli_real_escape_string($conexion, $_POST['password']);

// Es importante utilizar declaraciones preparadas para evitar inyecciones SQL
$consulta = "SELECT * FROM login WHERE username=? AND password=?";
$stmt = mysqli_prepare($conexion, $consulta);

// "ss" indica que ambos parámetros son cadenas (strings)
mysqli_stmt_bind_param($stmt, "ss", $usuario, $password);

mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

$filas = mysqli_num_rows($resultado);

if ($filas > 0) {
    session_start();
    $_SESSION['usuario'] = $usuario;  // Establece la variable de sesión 'usuario'
    
    // Actualizar el estado is_online a true
    $actualizar_online = "UPDATE login SET is_online = 1 WHERE username = ?";
    $stmt2 = mysqli_prepare($conexion, $actualizar_online);
    mysqli_stmt_bind_param($stmt2, "s", $usuario);
    mysqli_stmt_execute($stmt2);
    
    header("location: home.php");
} else {
    echo "Error de autenticación";
}

mysqli_free_result($resultado);
mysqli_close($conexion);
?>

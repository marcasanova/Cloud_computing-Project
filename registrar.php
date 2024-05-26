<?php
include('db.php');

$nuevo_usuario = $_POST['nuevo_usuario'];
$nueva_password = $_POST['nueva_password'];

// Preparar la consulta para evitar inyecciones SQL
$stmt = $conexion->prepare("SELECT * FROM login WHERE username = ?");
$stmt->bind_param("s", $nuevo_usuario);
$stmt->execute();
$resultado_existencia = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
if ($resultado_existencia->num_rows > 0) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: '¡Usuario existente!',
                text: 'Ya existe un usuario con ese nombre. Por favor, elige otro nombre.',
                confirmButtonColor: '#FF4500',
                confirmButtonText: 'Intentar de nuevo'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'index.php';
                }
            });
        </script>";
} else {
    $stmt = $conexion->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $nuevo_usuario, $nueva_password);
    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro exitoso!',
                    text: '¡Tu cuenta ha sido creada exitosamente!',
                    confirmButtonColor: '#4CAF50',
                    confirmButtonText: 'Iniciar sesión'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'index.php';
                    }
                });
            </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error al registrar',
                    text: 'Error al registrar: " . mysqli_error($conexion) . "',
                    confirmButtonColor: '#FF4500',
                    confirmButtonText: 'Intentar de nuevo'
                });
            </script>";
    }
}

$stmt->close();
mysqli_close($conexion);
?>

</body>
</html>

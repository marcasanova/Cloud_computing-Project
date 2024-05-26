<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica si la sesión está activa y si la variable de usuario está definida
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Asigna el valor de la variable de sesión a la variable $usuario
$usuario = $_SESSION['usuario'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cloud_computing";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recuperar la información del usuario
$stmt = $conn->prepare("SELECT profile_image, background_image FROM login WHERE username = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($profile_image, $background_image);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido, <?php echo htmlspecialchars($usuario); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <style>
        body {
            background-image: url('<?php echo $background_image; ?>');
            background-size: cover;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-image: url('<?php echo $profile_image; ?>');
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2><?php echo htmlspecialchars($usuario); ?></h2>
            <div id="profile-section">
                <img id="profile-image" src="<?php echo $profile_image; ?>" alt="Imagen de perfil">
                <form action="home.php" method="post" enctype="multipart/form-data">
                    <button type="button" onclick="document.getElementById('fileInput').click();">Change image</button>
                    <input type="file" name="profile_image" id="fileInput" style="display:none;" accept="image/*" onchange="this.form.submit()">
                </form>
            </div>
            <div id="online-players-section">
                <h3>players</h3>
                <ul id="online-players-list"></ul>
            </div>
            <form action="logout.php" method="post">
                <button type="submit">Close Session</button>
            </form>
        </div>
        <div class="content">
            <div class="welcome-banner">
                <h2>Welcome, <?php echo htmlspecialchars($usuario); ?></h2>
                <button onclick="window.location.href='record.php'">Records</button>
            </div>
            <div class="change-background">
                <form action="home.php" method="post" enctype="multipart/form-data">
                    <button type="button" id="change-background-btn" onclick="document.getElementById('backgroundInput').click();">Change Background</button>
                    <input type="file" name="background_image" id="backgroundInput" style="display:none;" accept="image/*" onchange="this.form.submit()">
                </form>
            </div>
            <div class="games-table">
                <div class="game">
                    <a href="seleccionador.php">
                        <img src="img/tictac.webp" alt="Tick-tack-toe Cover">
                        <h3>Tick-tack-toe</h3>
                    </a>
                </div>
                
            </div>
        </div>       
    </div>
    <script src="js/home.js"></script>
</body>
</html>

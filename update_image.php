<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No user logged in']);
    exit();
}

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

$uploadDir = 'img/';
$response = ['success' => false, 'message' => ''];

// Procesar la imagen de perfil
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
    $profileImage = $uploadDir . basename($_FILES['profileImage']['name']);
    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $profileImage)) {
        $stmt = $conn->prepare("UPDATE login SET profile_image = ? WHERE username = ?");
        $stmt->bind_param("ss", $profileImage, $usuario);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['url'] = $profileImage;
        } else {
            $response['message'] = 'Database error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Failed to move uploaded file.';
    }
}

// Procesar la imagen de fondo
if (isset($_FILES['backgroundImage']) && $_FILES['backgroundImage']['error'] == UPLOAD_ERR_OK) {
    $backgroundImage = $uploadDir . basename($_FILES['backgroundImage']['name']);
    if (move_uploaded_file($_FILES['backgroundImage']['tmp_name'], $backgroundImage)) {
        $stmt = $conn->prepare("UPDATE login SET background_image = ? WHERE username = ?");
        $stmt->bind_param("ss", $backgroundImage, $usuario);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['url'] = $backgroundImage;
        } else {
            $response['message'] = 'Database error: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Failed to move uploaded file.';
    }
}

$conn->close();
echo json_encode($response);
?>

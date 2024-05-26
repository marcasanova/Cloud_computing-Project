<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <title>Login y Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="validar.php" method="post">
                <label for="usuario">User:</label>
                <input type="text" id="usuario" name="usuario" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <input type="submit" value="Login">
            </form>
        </div>
    
        <div class="register-box">
            <h2>Register</h2>
            <form action="registrar.php" method="post">
                <label for="nuevo_usuario">New User:</label>
                <input type="text" id="nuevo_usuario" name="nuevo_usuario" required>
                <br>
                <label for="nueva_password">New Password:</label>
                <input type="password" id="nueva_password" name="nueva_password" required>
                <br>
                <input type="submit" value="Register">
            </form>
        </div>
    </div>


</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select game mode</title>
    <link rel="stylesheet" href="css/seleccionador.css">
</head>
<body>
    <div class="container">
        <h1>Select the Game Mode</h1>
        <div class="options">
            <div class="option">
                <a href="tick_tack_toe.php">Play against The Machine</a>
            </div>
            <div class="option">
                <a href="tick_tack_toe_jugadores.php">Play against Other Player</a>
            </div>
        </div>
        <div class="rules">
            <h2>Rules of the game</h2>
            <ul>
            <li>The game is played on a 3x3 board.</li>
            <li>Players take turns placing their piece in an empty square.</li>
            <li>The player who manages to place three of their pieces in a straight line, either horizontally, vertically, or diagonally, wins.</li>
            <li>If the board fills up without any player winning, it is considered a draw.</li>
            </ul>
        </div>
        <div class="start-button">
            <button onclick="window.location.href = 'home.php';">Go Back</button>
        </div>
    </div>
</body>
</html>

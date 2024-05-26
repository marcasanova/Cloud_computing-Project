// Variables globales
let turnoX = true; // Indica si es el turno de X
let tablero = ['', '', '', '', '', '', '', '', '']; // Representa el estado del tablero
const casillas = document.querySelectorAll('.casilla'); // Selecciona todas las casillas del tablero
let marcador = { jugador: 0, IA: 0 }; // Inicializa los contadores de victorias


function mostrarResultado(mensaje) {
    document.getElementById('mensajeResultado').textContent = mensaje;
    document.getElementById('resultadoJuego').classList.replace('resultado-oculto', 'resultado-visible');
    let botonReinicio = document.getElementById('botonReinicio');
    botonReinicio.style.display = 'block'; // Mostrar el botón al finalizar el juego
}

function manejarClicCasilla(index) {
    if (tablero[index] === '' && turnoX) {
        realizarJugada(index, 'X');
        verificarEstadoDelJuego();
    }
}

function verificarEstadoDelJuego() {
    let ganador = verificarGanador();
    if (ganador || tableroCompleto()) {
        let resultadoMensaje = ganador === 'X' ? 'Jugador Gana!' : (ganador === 'O' ? 'Máquina Gana!' : 'Empate!');
        mostrarResultado(resultadoMensaje);

        // Actualizar el marcador basado en el ganador
        if (ganador === 'X') {
            marcador.jugador += 1;
            actualizarMarcadorServidor('jugador');
        } else if (ganador === 'O') {
            marcador.IA += 1;
            actualizarMarcadorServidor('IA');
        } else {
            // No es necesario actualizar el marcador en caso de empate si solo cuentas victorias
        }
        mostrarMarcador(); // Mostrar el marcador actualizado

        return; // Detiene la ejecución adicional si el juego ha terminado
    }
    turnoX = !turnoX;
    if (!turnoX) {
        jugarMaquina();
    }
}

function jugarMaquina() {
    setTimeout(() => {
        let mejorMov = mejorMovimiento();
        if (mejorMov !== null) {
            realizarJugada(mejorMov, 'O');
            verificarEstadoDelJuego();
        }
    }, 500); // Retardo para simular tiempo de "pensamiento" de la máquina
}

function realizarJugada(index, jugador) {
    tablero[index] = jugador;
    casillas[index].textContent = jugador;
    casillas[index].classList.add(jugador === 'X' ? 'jugador' : 'maquina');
}

function mejorMovimiento() {
    let mejorPuntuacion = -Infinity;
    let movimiento = null;
    for (let i = 0; i < tablero.length; i++) {
        if (tablero[i] === '') {
            tablero[i] = 'O';
            let puntuacion = minimax(tablero, 0, false);
            tablero[i] = '';
            if (puntuacion > mejorPuntuacion) {
                mejorPuntuacion = puntuacion;
                movimiento = i;
            }
        }
    }
    return movimiento;
}

function minimax(tablero, profundidad, esMaximizando) {
    let resultado = verificarGanador();
    if (resultado !== null) {
        return scores[resultado];
    }

    if (esMaximizando) {
        let mejorPuntuacion = -Infinity;
        for (let i = 0; i < tablero.length; i++) {
            if (tablero[i] === '') {
                tablero[i] = 'O';
                let puntuacion = minimax(tablero, profundidad + 1, false);
                tablero[i] = '';
                mejorPuntuacion = Math.max(puntuacion, mejorPuntuacion);
            }
        }
        return mejorPuntuacion;
    } else {
        let mejorPuntuacion = Infinity;
        for (let i = 0; i < tablero.length; i++) {
            if (tablero[i] === '') {
                tablero[i] = 'X';
                let puntuacion = minimax(tablero, profundidad + 1, true);
                tablero[i] = '';
                mejorPuntuacion = Math.min(puntuacion, mejorPuntuacion);
            }
        }
        return mejorPuntuacion;
    }
}

const scores = {
    'X': -10, // Puntuación cuando el jugador gana
    'O': 10,  // Puntuación cuando la IA gana
    'Empate': 0
};

function verificarGanador() {
    const lineasGanadoras = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],
        [0, 3, 6], [1, 4, 7], [2, 5, 8],
        [0, 4, 8], [2, 4, 6]
    ];
    for (let i = 0; i < lineasGanadoras.length; i++) {
        const [a, b, c] = lineasGanadoras[i];
        if (tablero[a] && tablero[a] === tablero[b] && tablero[a] === tablero[c]) {
            return tablero[a]; // Retorna 'X' o 'O'
        }
    }
    if (tableroCompleto()) {
        return 'Empate'; // Retorna 'Empate' si el tablero está completo y no hay ganador
    }
    return null; // No hay ganador aún
}

function tableroCompleto() {
    return tablero.every(casilla => casilla !== ''); // Verifica si todas las casillas están llenas
}

function reiniciarJuego() {
    tablero = ['', '', '', '', '', '', '', '', ''];
    casillas.forEach(casilla => {
        casilla.textContent = '';
        casilla.classList.remove('jugador', 'maquina');
    });
    turnoX = true;
    document.getElementById('resultadoJuego').classList.replace('resultado-visible', 'resultado-oculto');
}

casillas.forEach((casilla, index) => {
    casilla.addEventListener('click', () => manejarClicCasilla(index));
});

// Mostrar el marcador
function mostrarMarcador() {
    document.getElementById('marcadorJugador').textContent = `Jugador: ${marcador.jugador}`;
    document.getElementById('marcadorIA').textContent = `IA: ${marcador.IA}`;
}

// Actualiza el marcador en la sesión del servidor mediante una petición AJAX
function actualizarMarcadorServidor(ganador) {
    fetch('marcador.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `ganador=${ganador}`
    })
    
}


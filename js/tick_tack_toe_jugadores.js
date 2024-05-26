// Función para obtener y mostrar los jugadores en línea
function fetchOnlinePlayers() {
    fetch('online_players.php')
    .then(response => response.json())
    .then(data => {
        const onlinePlayersList = document.getElementById('online-players-list');
        onlinePlayersList.innerHTML = ''; // Limpiar la lista actual
        data.forEach(player => {
            if (player !== "<?php echo $_SESSION['usuario']; ?>") {
                const li = document.createElement('li');
                li.textContent = player;
                
                // Crear botón de invitación
                const inviteButton = document.createElement('button');
                inviteButton.textContent = 'Invitar';
                inviteButton.classList.add('invite-button');
                inviteButton.setAttribute('data-player', player); // Añade el atributo para identificar al jugador
                inviteButton.addEventListener('click', () => enviarInvitacion(player)); // Usa arrow function para mantener el contexto
                
                // Agregar el botón al elemento de lista
                li.appendChild(inviteButton);
                onlinePlayersList.appendChild(li);
            }
        });
    })
    .catch(error => console.error('Error:', error));
}

// Función para enviar invitaciones
function enviarInvitacion(player) {
    const inviteButton = document.querySelector(`button[data-player='${player}']`);
    inviteButton.textContent = 'Invitando...';
    inviteButton.disabled = true;

    fetch('multi/create_game.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `invited_player=${encodeURIComponent(player)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Juego creado:', data.game_id);
            inviteButton.textContent = 'Invitación Enviada';
        } else {
            console.error('Error al crear juego:', data.error);
            inviteButton.textContent = 'Invitar';
            inviteButton.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error al enviar la invitación:', error);
        inviteButton.textContent = 'Invitar';
        inviteButton.disabled = false;
    });
}

// Llamar a fetchOnlinePlayers() al cargar la página y cada 5 segundos
document.addEventListener('DOMContentLoaded', fetchOnlinePlayers);
setInterval(fetchOnlinePlayers, 5000);

// Función para aceptar invitaciones
function aceptarInvitacion(gameId) {
    fetch('multi/accept_invite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `game_id=${gameId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Invitación aceptada:', data.game_id);
            // Aquí puedes añadir lógica para redirigir al usuario al juego o actualizar la interfaz
        } else {
            console.error('Error al aceptar la invitación:', data.error);
        }
    })
    .catch(error => console.error('Error al enviar la aceptación:', error));
}

// Obtener el estado del juego
function fetchGameState(gameId) {
    fetch('multi/game_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=get_status&game_id=${gameId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.game_state) {
            updateGameUI(data.game_state); // Función ficticia para actualizar la UI del juego
        }
    });
}

// Enviar un nuevo estado del juego
function updateGameState(gameId, newState) {
    fetch('multi/game_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=update_status&game_id=${gameId}&game_state=${JSON.stringify(newState)}`
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    });
}

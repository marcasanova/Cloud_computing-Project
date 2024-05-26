// Función para mostrar la imagen seleccionada como fondo de pantalla
document.getElementById('backgroundInput').addEventListener('change', function (event) {
    var fileInput = event.target;
    var file = fileInput.files[0];
    
    if (file) {
        var formData = new FormData();
        formData.append('backgroundImage', file);
        
        fetch('update_image.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la imagen de fondo inmediatamente
                document.body.style.backgroundImage = 'url(' + data.url + ')';
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

// Función para mostrar la imagen seleccionada como imagen de perfil
document.getElementById('fileInput').addEventListener('change', function (event) {
    var fileInput = event.target;
    var file = fileInput.files[0];
    var img = document.getElementById('profile-image');
    
    if (file) {
        var formData = new FormData();
        formData.append('profileImage', file);
        
        fetch('update_image.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la imagen de perfil inmediatamente
                img.src = data.url;
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

// Función para obtener y mostrar los jugadores en línea
function fetchOnlinePlayers() {
    fetch('online_players.php')
    .then(response => response.json())
    .then(data => {
        const onlinePlayersList = document.getElementById('online-players-list');
        onlinePlayersList.innerHTML = ''; // Limpiar la lista actual
        data.forEach(player => {
            const li = document.createElement('li');
            li.textContent = player; // Asumiendo que 'player' es el nombre de usuario
            onlinePlayersList.appendChild(li);
        });
    })
    .catch(error => console.error('Error:', error));
}

// Llamar a fetchOnlinePlayers() cada 5 segundos para actualizar la lista
setInterval(fetchOnlinePlayers, 5000); // 5000 milisegundos = 5 segundos

// Asegúrate de llamar a fetchOnlinePlayers() al cargar la página
document.addEventListener('DOMContentLoaded', fetchOnlinePlayers);

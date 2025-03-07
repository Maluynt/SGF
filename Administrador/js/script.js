function enviarIdServicio(idServicio, element) {
    const url = element.getAttribute('data-url');
    
    fetch('/metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_servicio=' + encodeURIComponent(idServicio)
    })
    .then(response => {
        if (response.ok) {
            window.location.href = url;
        } else {
            console.error('Error:', response.statusText);
            alert('Error al procesar: ' + response.statusText);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión: ' + error.message);
    });
}
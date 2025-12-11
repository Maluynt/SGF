// Función para cerrar la sesión cuando el usuario cierra la página
function cerrarSesionAlSalir() {
    // Hacer una solicitud al servidor para cerrar la sesión
    fetch('/metro/SGF/logout/controlador_logout.php', {
        method: 'GET',
        credentials: 'same-origin' // Incluir cookies en la solicitud
    }).then(response => {
        console.log('Sesión cerrada correctamente');
    }).catch(error => {
        console.error('Error al cerrar la sesión:', error);
    });
}

// Detectar el evento beforeunload (cierre de la página)
window.addEventListener('beforeunload', cerrarSesionAlSalir);
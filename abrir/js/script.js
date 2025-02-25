// hora en pantalla del sistema
function updateTime() {
    const now = new Date();
    const options = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    };
    document.getElementById('time').textContent = now.toLocaleString('es-ES', options);
}
setInterval(updateTime, 1000);
updateTime();

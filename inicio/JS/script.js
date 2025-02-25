document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const menuBtn = document.querySelector('.menu-btn');
    const dropdowns = document.querySelectorAll('.menu-item');

    // Toggle sidebar
    menuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('active');
        menuBtn.classList.toggle('active');
    });

    // Manejar dropdowns
    dropdowns.forEach(item => {
        item.addEventListener('click', function(e) {
            // Verifica si el clic fue en un enlace de redirección
            const link = e.target.closest('a'); // Detecta si el clic fue en un enlace
            if (link && link.classList.contains('submenu-item')) {
                // Permitir la redirección si es un enlace del submenú
                return;
            }

            // Comportamiento para menús desplegables (como "Usuario" y "Registros")
            if (this.classList.contains('user-info') || this.classList.contains('registry-menu')) {
                e.preventDefault(); // Evita la redirección para elementos desplegables
                const submenu = this.querySelector('.submenu, .user-details');
                if (submenu) {
                    submenu.classList.toggle('show'); // Alterna visibilidad del submenú

                    // Cierra otros submenús abiertos
                    dropdowns.forEach(otherItem => {
                        if (otherItem !== item) {
                            const otherSubmenu = otherItem.querySelector('.submenu, .user-details');
                            if (otherSubmenu) {
                                otherSubmenu.classList.remove('show');
                            }
                        }
                    });
                }
            }
        });
    });

    // Cerrar al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
            sidebar.classList.remove('active');
            menuBtn.classList.remove('active');

            // Cierra todos los submenús abiertos
            dropdowns.forEach(item => {
                const submenu = item.querySelector('.submenu, .user-details');
                if (submenu) submenu.classList.remove('show');
            });
        }
    });
});

// Función para actualizar el tiempo
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

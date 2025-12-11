document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const estadoSelect = document.getElementById('estadoSelect');
    const justificacion = document.getElementById('justificacion');
    const simboloRequerido = document.querySelector('.requerido-justificacion');
    const errorJustificacion = document.getElementById('error-justificacion');

    // Nombres de estados que requieren justificación
    const estadosRequierenJustificacion = ['Cerrada', 'Anulada', 'En espera'];

    const actualizarValidacion = () => {
        const selectedOption = estadoSelect.options[estadoSelect.selectedIndex];
        const estadoNombre = selectedOption.dataset.nombre;
        const requiereJustificacion = estadosRequierenJustificacion.includes(estadoNombre);

        // Actualizar UI
        simboloRequerido.style.display = requiereJustificacion ? 'inline' : 'none';
        justificacion.required = requiereJustificacion;

        // Reiniciar validaciones
        justificacion.classList.remove('is-invalid');
        errorJustificacion.textContent = '';
    };

    // Validar al cambiar estado
    estadoSelect.addEventListener('change', actualizarValidacion);

    // Validar al enviar
    form.addEventListener('submit', (e) => {
        const selectedOption = estadoSelect.options[estadoSelect.selectedIndex];
        const estadoNombre = selectedOption.dataset.nombre;
        const justificacionValor = justificacion.value.trim();
        let esValido = true;

        if (estadosRequierenJustificacion.includes(estadoNombre)) {
            if (!justificacionValor) {
                justificacion.classList.add('is-invalid');
                errorJustificacion.textContent = 'Debe proporcionar una justificación para el estado: ' + estadoNombre;
                esValido = false;
            } else if (justificacionValor.length < 20) {
                justificacion.classList.add('is-invalid');
                errorJustificacion.textContent = 'La justificación debe tener al menos 20 caracteres para el estado: ' + estadoNombre;
                esValido = false;
            }
        }

        if (!esValido) {
            e.preventDefault();
            justificacion.focus();
            window.scrollTo({
                top: justificacion.offsetTop - 100,
                behavior: 'smooth'
            });
        }
    });

    // Validación inicial
    actualizarValidacion();
});
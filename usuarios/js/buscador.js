
// buscador.js - Versión corregida y optimizada
document.addEventListener('DOMContentLoaded', () => {
    // Elementos requeridos
    const input = document.getElementById('id_personal_buscador');
    const sugerencias = document.getElementById('sugerencias');
    
    // Si no están los elementos en la página, salir
    if (!input || !sugerencias) return;

    // Variables de estado
    let timeout;
    let currentRequest = null;

    // Función para limpiar sugerencias
    const limpiarSugerencias = () => {
        sugerencias.innerHTML = '';
    };

    // Función para mostrar resultados (mejorada con sanitización)
    const mostrarResultados = (items) => {
        try {
            // Validación estricta
            if (!Array.isArray(items)) {
                throw new Error('Formato de datos inválido');
            }

            limpiarSugerencias();

            if (items.length === 0) {
                sugerencias.innerHTML = `
                    <div class="list-group-item text-muted">
                        No se encontraron resultados
                    </div>`;
                return;
            }

            // Crear elementos de forma segura
            const fragment = document.createDocumentFragment();
            
            items.forEach(item => {
                const div = document.createElement('div');
                div.className = 'list-group-item list-group-item-action';
                div.dataset.id = item.id_personal;
                div.innerHTML = `
                    ${escapeHTML(item.nombre_personal)} 
                    <small class="text-muted">(${escapeHTML(item.carnet)})</small>
                `;
                
                fragment.appendChild(div);
            });

            sugerencias.appendChild(fragment);

        } catch (error) {
            console.error('Error al mostrar resultados:', error);
            sugerencias.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar resultados
                </div>`;
        }
    };

    // Función de escape HTML básica
    const escapeHTML = (str) => {
        return str.replace(/[&<>"']/g, match => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[match]));
    };

    // Función de búsqueda con abort controller
    const buscar = async (query) => {
        try {
            // Cancelar petición anterior
            if (currentRequest) {
                currentRequest.abort();
            }
            
            const controller = new AbortController();
            currentRequest = controller;
            
            const response = await fetch(
                `/metro/SGF/usuarios/controlador/controlador_registrar_usuario.php?action=buscar_personal&query=${encodeURIComponent(query)}`,
                { signal: controller.signal }
            );
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.error || 'Error en la búsqueda');
            }

            mostrarResultados(data.data);
            
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Error en la búsqueda:', error);
                sugerencias.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ${escapeHTML(error.message)}
                    </div>`;
            }
        } finally {
            currentRequest = null;
        }
    };

    // Eventos
    input.addEventListener('input', (e) => {
        const query = e.target.value.trim();
        clearTimeout(timeout);
        limpiarSugerencias();
        
        if (query.length < 2) return;
        
        timeout = setTimeout(() => buscar(query), 300);
    });

    // Evento delegado para clicks en sugerencias
    sugerencias.addEventListener('click', (e) => {
        const item = e.target.closest('.list-group-item');
        if (!item) return;
        
        const idPersonal = item.dataset.id;
        const nombre = item.textContent.split('(')[0].trim();
        
        // Actualizar campos relacionados
        document.getElementById('id_personal').value = idPersonal;
        input.value = nombre;
        limpiarSugerencias();
    });

    // Limpiar al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!sugerencias.contains(e.target) && e.target !== input) {
            limpiarSugerencias();
        }
    });
});
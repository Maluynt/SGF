import { servicios } from '../modelo/modelo.js'; // Asegúrate de que la ruta sea correcta

export function crearTarjetas() {
    const container = document.getElementById('servicesContainer');
    
    servicios.forEach(servicio => {
        const tarjeta = `
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <a href="${servicio.url}" class="text-decoration-none">
                    <div class="service-card" data-color="${servicio.color}">
                        <div class="card-content">
                            <h3>${servicio.nombre}</h3>
                        </div>
                    </div>
                </a>
            </div>
        `;
        container.innerHTML += tarjeta;
    });
}

// Inicialización
window.onload = crearTarjetas;

async function cambiarServicio(idServicio) {
    try {
        const response = await fetch('/metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Cambiado a JSON
            },
            body: JSON.stringify({ id_servicio: idServicio }) // Enviando como JSON
        });
        
        // Verifica si la respuesta fue exitosa
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }

        const data = await response.json();
        
        if (!data.success) throw new Error(data.message);
        
        window.location.href = data.url;

    } catch (error) {
        alert(`Error: ${error.message}`);
        console.error('Error:', error);
    }
}
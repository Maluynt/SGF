
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

document.addEventListener('DOMContentLoaded', () => {
    // Configuración de colores corporativos
    const coloresEmpresa = {
        principal: '#2c3e50',
        secundario: '#5c6d7e',
        oscuro: '#17212c',
        claro: '#ecf0f1'
    };

    // Elementos del DOM
    const elementos = {
        toggleBtn: document.getElementById('toggleEstadisticas'),
        seccion: document.getElementById('seccionEstadisticas'),
        chartData: JSON.parse(document.getElementById('chartData').textContent),
        statsServicio: document.getElementById('estadisticasServicio'),
        statsSubsistema: document.getElementById('estadisticasSubsistema'),
        statsEquipo: document.getElementById('estadisticasEquipo')
    };

    // Variables de gráficos
    let servicioChart, subsistemaChart, equipoChart;

    // Funciones de gráficos
    const crearGrafico = (id, tipo, config) => {
        const ctx = document.getElementById(id).getContext('2d');
        return new Chart(ctx, {
            type: tipo,
            ...config
        });
    };

    const destruirGraficos = () => {
        [servicioChart, subsistemaChart, equipoChart].forEach(chart => {
            if (chart) chart.destroy();
        });
    };

    const generarEstadisticas = (datos, titulo, contenedorId) => {
        const total = datos.data.reduce((a, b) => a + b, 0);
        let html = `<div class="estadisticas-detalladas" style="margin-top: 20px; padding: 15px; background: ${coloresEmpresa.claro}; border-radius: 8px;">
            <h4 style="color: ${coloresEmpresa.oscuro}; margin-bottom: 15px;">${titulo}</h4>
            <ul style="list-style: none; padding: 0;">`;

        datos.labels.forEach((label, index) => {
            const porcentaje = ((datos.data[index] / total) * 100).toFixed(1);
            html += `
                <li style="margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; padding: 8px; background: white; border-radius: 4px;">
                    <span style="color: ${coloresEmpresa.oscuro};">${label}</span>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span style="color: ${coloresEmpresa.principal}; font-weight: bold;">${datos.data[index]}</span>
                        <span style="color: ${coloresEmpresa.secundario};">${porcentaje}%</span>
                    </div>
                </li>`;
        });

        html += `</ul></div>`;
        document.getElementById(contenedorId).innerHTML = html;
    };

    const inicializarGraficos = () => {
        // Destruir gráficos existentes
        destruirGraficos();

        // Gráfico y estadísticas de Servicio
        servicioChart = crearGrafico('servicioChart', 'doughnut', {
            data: {
                labels: elementos.chartData.servicio.labels,
                datasets: [{
                    data: elementos.chartData.servicio.data,
                    backgroundColor: [coloresEmpresa.principal, coloresEmpresa.secundario, coloresEmpresa.oscuro],
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: coloresEmpresa.oscuro,
                            font: { size: 14 }
                        }
                    }
                }
            }
        });
        generarEstadisticas(elementos.chartData.servicio, 'Estadísticas de Servicios', 'estadisticasServicio');

        // Gráfico y estadísticas de Subsistema
        subsistemaChart = crearGrafico('subsistemaChart', 'bar', {
            data: {
                labels: elementos.chartData.subsistema.labels,
                datasets: [{
                    data: elementos.chartData.subsistema.data,
                    backgroundColor: coloresEmpresa.secundario,
                    borderColor: coloresEmpresa.oscuro,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: coloresEmpresa.oscuro, font: { size: 12 } } },
                    y: { ticks: { color: coloresEmpresa.oscuro, font: { size: 12 } } }
                }
            }
        });
        generarEstadisticas(elementos.chartData.subsistema, 'Estadísticas de Subsistemas', 'estadisticasSubsistema');

        // Gráfico y estadísticas de Equipo
        equipoChart = crearGrafico('equipoChart', 'bar', {
            data: {
                labels: elementos.chartData.equipo.labels,
                datasets: [{
                    label: 'Fallas por Equipo',
                    data: elementos.chartData.equipo.data,
                    backgroundColor: coloresEmpresa.principal,
                    borderColor: coloresEmpresa.oscuro,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: coloresEmpresa.oscuro, font: { size: 12 } } },
                    y: { 
                        beginAtZero: true,
                        ticks: { color: coloresEmpresa.oscuro, font: { size: 12 } }
                    }
                }
            }
        });
        generarEstadisticas(elementos.chartData.equipo, 'Estadísticas de Equipos', 'estadisticasEquipo');
    };

    // Event Listeners
    elementos.toggleBtn.addEventListener('click', () => {
        const isVisible = elementos.seccion.style.display === 'block';
        elementos.seccion.style.display = isVisible ? 'none' : 'block';
        if (!isVisible) {
            inicializarGraficos();
        } else {
            destruirGraficos();
        }
    });

    document.querySelectorAll('.filter-select, #searchInput').forEach(element => {
        element.addEventListener('change', () => {
            if (elementos.seccion.style.display === 'block') {
                destruirGraficos();
                inicializarGraficos();
            }
        });
    });

    // Este bloque asegura que los gráficos solo inicialicen cuando se requiere
});
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const filterSelects = document.querySelectorAll('.filter-select');
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    let currentPage = 1;
    const itemsPerPage = 15;

    // Mapa de columnas usando data-column
    const columnMap = {};
    document.querySelectorAll('th').forEach((th, index) => {
        if(index !== 0) {
            const columnKey = th.getAttribute('data-column');
            columnMap[columnKey] = index - 1; 
        }
    });

    function applyFilters() {
        const activeFilters = {};
        
        // 1. Filtros de selects
        filterSelects.forEach(select => {
            const column = select.dataset.column;
            if(select.value) activeFilters[column] = select.value.toLowerCase().trim();
        });

        // 2. Obtener fechas
        const startDate = fechaInicio.value;
        const endDate = fechaFin.value;

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let isVisible = true;

            // A. Filtros por columna
            for(const [column, filterValue] of Object.entries(activeFilters)) {
                const columnIndex = columnMap[column];
                if(columnIndex === undefined) continue;
                
                const cell = cells[columnIndex + 1]; // +1 por columna de acciones
                const cellValue = cell.textContent.toLowerCase().trim();
                if(cellValue !== filterValue) {
                    isVisible = false;
                    break;
                }
            }

            // B. Búsqueda global
            if(isVisible && searchInput.value.trim()) {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const rowText = Array.from(cells)
                    .slice(1) // Excluir columna de acciones
                    .map(cell => cell.textContent.toLowerCase().trim())
                    .join(' ');
                
                isVisible = rowText.includes(searchTerm);
            }

            // C. Filtro de fechas (¡Corrección clave aquí!)
            if(isVisible && (startDate || endDate)) {
                try {
                    // Usar el alias correcto de la columna formateada
                    const fechaCell = cells[columnMap['fecha_hora_reporte'] + 1]; 
                    
                    if (!fechaCell) {
                        console.error('Celda de fecha no encontrada');
                        isVisible = false;
                        return;
                    }
                    
                    // El texto ya está en formato YYYY-MM-DD
                    const fechaTexto = fechaCell.textContent.trim(); 
                    
                    // Comparación directa
                    if(startDate && endDate) {
                        isVisible = fechaTexto >= startDate && fechaTexto <= endDate;
                    } else if(startDate) {
                        isVisible = fechaTexto >= startDate;
                    } else if(endDate) {
                        isVisible = fechaTexto <= endDate;
                    }
                    
                } catch(e) {
                    console.error('Error en fecha:', e);
                    isVisible = false;
                }
            }

            row.style.display = isVisible ? '' : 'none';
        });

        currentPage = 1;
        updatePagination();
    }

    function updatePagination() {
        const visibleRows = rows.filter(row => row.style.display !== 'none');
        const totalPages = Math.ceil(visibleRows.length / itemsPerPage) || 1;
        
        document.getElementById('pageInfo').textContent = 
            `Página ${currentPage} de ${totalPages}`;

        visibleRows.forEach((row, index) => {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });
    }

    // Event listeners
    filterSelects.forEach(select => {
        select.addEventListener('change', applyFilters);
    });

    searchInput.addEventListener('input', applyFilters);
    fechaInicio.addEventListener('change', applyFilters);
    fechaFin.addEventListener('change', applyFilters);

    document.getElementById('prevPage').addEventListener('click', () => {
        if(currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const visibleRows = rows.filter(row => row.style.display !== 'none');
        if(currentPage < Math.ceil(visibleRows.length / itemsPerPage)) {
            currentPage++;
            updatePagination();
        }
    });

    // Botón de recarga
    document.getElementById('reloadPage').addEventListener('click', function() {
        // Limpiar controles
        searchInput.value = '';
        fechaInicio.value = '';
        fechaFin.value = '';
        filterSelects.forEach(select => select.value = '');
        // Recargar página
        window.location.reload(true);
    });

    // Inicialización
    applyFilters();
});
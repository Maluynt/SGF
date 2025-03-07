document.addEventListener('DOMContentLoaded', function() {
    // Configuración modificada para trabajar con columnas por nombre
    const filterSelects = document.querySelectorAll('.filter-select');
    
    // Función de filtrado actualizada
    function filterData() {
        const searchTerm = searchInput.value.toLowerCase();
        
        filteredData = rows.filter(row => {
            const cells = row.querySelectorAll('td');
            let matchesSearch = true;
            let matchesFilters = true;

            if(searchTerm) {
                const rowText = Array.from(cells).map(cell => 
                    cell.innerText.toLowerCase()
                ).join(' ');
                matchesSearch = rowText.includes(searchTerm);
            }

            // Filtrado por columnas específicas
            filterSelects.forEach(select => {
                const columnName = select.dataset.column;
                const filterValue = select.value.toLowerCase();
                
                if(filterValue) {
                    const columnIndex = Array.from(document.querySelectorAll('th')).findIndex(
                        th => th.getAttribute('data-column') === columnName
                    );
                    
                    if(columnIndex > -1) {
                        const cellText = cells[columnIndex].innerText.toLowerCase();
                        if(cellText !== filterValue) matchesFilters = false;
                    }
                }
            });

            return matchesSearch && matchesFilters;
        });

        currentPage = 1;
        updatePagination();
        updateTable();
    }
// Actualizar tabla
function updateTable() {
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedData = filteredData.slice(start, end);

        rows.forEach(row => row.style.display = 'none');
        paginatedData.forEach(row => row.style.display = '');

        // Actualizar indicadores de prioridad
        document.querySelectorAll('.priority-indicator').forEach(indicator => {
            const priority = indicator.parentElement.innerText.trim();
            indicator.style.backgroundColor = getPriorityColor(priority);
        });
    }

    // Colores para prioridades (personalizar según necesidades)
    function getPriorityColor(priority) {
        const colors = {
            'A': '#ff4444',
            'B': '#ffbb33',
            'C': '#00C851'
        };
        return colors[priority] || '#cccccc';
    }

    // Paginación
    function updatePagination() {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        document.getElementById('pageInfo').textContent =
            `Página ${currentPage} de ${totalPages}`;

        document.getElementById('prevPage').disabled = currentPage === 1;
        document.getElementById('nextPage').disabled =
            currentPage === totalPages || totalPages === 0;
    }

    // Event Listeners
    searchInput.addEventListener('input', debounce(filterData, 300));

    filterSelects.forEach(select => {
        select.addEventListener('change', filterData);
    });

    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        if (currentPage * itemsPerPage < filteredData.length) {
            currentPage++;
            updateTable();
        }
    });

    // Función debounce para mejor rendimiento en búsqueda
    function debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, args);
            }, timeout);
        };
    }

    // Inicialización
    filterData();

    // Resto del JavaScript mantiene igual...
});
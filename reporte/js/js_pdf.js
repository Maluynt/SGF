// En tu script.js
document.getElementById('generatePdf').addEventListener('click', function() {
    const filters = {
        fechaInicio: document.getElementById('fechaInicio').value,
        fechaFin: document.getElementById('fechaFin').value,
        searchTerm: document.getElementById('searchInput').value
    };
    
    document.querySelectorAll('.filter-select').forEach(select => {
        filters[select.dataset.column] = select.value;
    });

    // Convertir filtros a URL codificada
    const params = new URLSearchParams(filters);
    
    // Enviar por GET o POST
    window.open(`/metro/SGF/consulta/controlador/generar_pdf.php?${params}`, '_blank');
});
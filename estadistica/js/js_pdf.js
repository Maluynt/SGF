document.addEventListener('DOMContentLoaded', () => {
    const elementosPDF = {
        btnGenerar: document.getElementById('btn_generar_pdf'),
        formFiltros: document.getElementById('form_filtros_pdf'),
        fechaInicio: document.getElementById('fechaInicio'),
        fechaFin: document.getElementById('fechaFin')
    };

    if (!elementosPDF.btnGenerar || !elementosPDF.formFiltros) return;

    const validarFechas = () => {
        if (!elementosPDF.fechaInicio.value || !elementosPDF.fechaFin.value) {
            alert('Seleccione ambas fechas');
            return false;
        }
        return true;
    };

    const generarPDF = async (e) => {
        e.preventDefault();
        if (!validarFechas()) return;

        // Mostrar carga
        elementosPDF.btnGenerar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
        elementosPDF.btnGenerar.disabled = true;

        // Enviar formulario directamente a DOMPDF
        elementosPDF.formFiltros.action = '/metro/SGF/estadistica/controlador/generar_pdf_estadistica.php';
        elementosPDF.formFiltros.method = 'POST';
        elementosPDF.formFiltros.submit();

        // Restaurar botón después de 2 segundos
        setTimeout(() => {
            elementosPDF.btnGenerar.innerHTML = 'Generar PDF';
            elementosPDF.btnGenerar.disabled = false;
        }, 2000);
    };

    elementosPDF.btnGenerar.addEventListener('click', generarPDF);
    elementosPDF.formFiltros.addEventListener('submit', generarPDF);
});
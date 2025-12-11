<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
verificarAutenticacion();


if (!isset($_SESSION['id_servicio'])) {
    die('Acceso no autorizado. Debe iniciar sesión.');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/reporte/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/estadistica/modelo/modelo_consulta.php';

use Dompdf\Dompdf;
use Dompdf\Options;

try {
    $fechaInicio = $_POST['fechaInicio'] . ' 00:00:00';
$fechaFin = $_POST['fechaFin'] . ' 23:59:59';

// Usar en consulta SQL
$sql = "SELECT * FROM tabla WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
    // Validar parámetros
    
    if (!$fechaInicio || !$fechaFin) {
        throw new Exception('Debe seleccionar ambas fechas');
    }

    // Obtener datos
    $modelo = new FallaModel($pdo);
    $filtros = [
        'fechaInicio' => $fechaInicio,
        'fechaFin' => $fechaFin
    ];
    
    $estadisticas = $modelo->generarEstadisticasFiltradas($filtros);
    $fallas = $modelo->obtenerFallasFiltradas($filtros); // Asegúrate de tener este método en el modelo

    // Configurar DOMPDF
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'Arial');
    
    $dompdf = new Dompdf($options);
    $dompdf->setPaper('A4', 'landscape');

    // Incluir el template HTML
    ob_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/estadistica/vista/pdf_estadisticas_templates.php';
    $html = ob_get_clean();

    // Generar PDF
    $dompdf->loadHtml($html);
    $dompdf->render();
    
    // Salida del PDF
    $dompdf->stream("reporte_estadisticas.pdf", [
        "Attachment" => 0,
        "compress" => 1
    ]);
   
} catch (Exception $e) {
    die('Error generando reporte: ' . $e->getMessage());
}
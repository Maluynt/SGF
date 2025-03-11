<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die('Acceso denegado');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/vendor/autoload.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/reporte/modelo/modelo_consulta.php';

use Dompdf\Dompdf;

$model = new FallaModel($pdo);
$filtros = $_GET;

// Obtener datos filtrados desde el modelo
$fallas = $model->obtenerFallasFiltradas($filtros);

// Configurar campos permitidos (igual que en la vista)
$allowedFields = [
    'ID' => 'id_falla',
    'Descripción' => 'descripcion_falla',
    'Prioridad' => 'nombre_prioridad',
    'Estado' => 'nombre_estado',
    'Equipo' => 'nombre_equipo',
    'Subsistema' => 'nombre_subsistema',
    'Servicio' => 'nombre_servicio',
    'Ambiente' => 'nombre_ambiente',
    'Ubicación' => 'nombre_ubicacion',
    'Fecha Reporte' => 'fecha_hora_reporte',
    'Reportada por' => 'nombre_reportada_por',
    'Responsable del Area' => 'nombre_responsable_area',
    'Días Abierta' => 'dias_falla',
    'Fecha Cierre' => 'fecha_hora_cierre',
    'N.Intervencion' => 'n_intervencion',
    'Solucion' => 'solucion',
    'Metodo de reporte' => 'nombre_metodo_reporte',
    'Acompañamiento' => 'acompañamiento',
    
];

// Generar HTML para PDF
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/vista/pdf_template.php';
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("reporte_fallas_".date('Ymd').".pdf");
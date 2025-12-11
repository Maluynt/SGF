<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/reporte/vendor/autoload.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/reporte/modelo/modelo_consulta.php';
// Incluir el archivo de conexión primero
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php'; // Ajusta la ruta según tu estructura
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
include $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/reporte/vista/pdf_templates.php';
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();



// Cambiar el stream para abrir en navegador
$dompdf->stream("reporte_fallas_".date('Ymd').".pdf", array("Attachment" => 0));



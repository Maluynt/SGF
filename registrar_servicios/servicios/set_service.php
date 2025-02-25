<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion_bd.php';
require_once __DIR__ . '/../subsistema/modelo/modelo_subsistema.php';

$response = ['success' => false, 'message' => ''];

try {
    if (!isset($_POST['id_servicio'])) {
        throw new Exception("No se recibió el servicio");
    }

    $id_servicio = (int)$_POST['id_servicio'];
    
    $modelo = new SubsistemaModel($pdo);
    $modelo->establecerServicio($id_servicio);
    
    $response['success'] = true;
    $response['url'] = obtenerUrlServicio($id_servicio);

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);

function obtenerUrlServicio($id_servicio) {
    $servicios = [
        1 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        2 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        3 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        4 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        5 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        6 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        7 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        8 => '/metro/SGF/inicio/controlador/controlador_inicio.php',
        // ... agregar todos los servicios
    ];
    return $servicios[$id_servicio] ?? '/';
}
?>
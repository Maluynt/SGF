<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/controlador_usuario.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/registrar_servicios/subsistema/modelo/modelo_subsistema.php';

// Obtener id_servicio de POST, GET o sesión
if (isset($_POST['id_servicio'])) {
    $id_servicio = $_POST['id_servicio'];
    $_SESSION['id_servicio'] = $id_servicio;
} elseif (isset($_GET['id_servicio'])) {
    $id_servicio = $_GET['id_servicio'];
    $_SESSION['id_servicio'] = $id_servicio;
} elseif (isset($_SESSION['id_servicio'])) {
    $id_servicio = $_SESSION['id_servicio'];
} else {
    // Si no se recibe id_servicio, mantén el valor de la sesión
    if (!isset($_SESSION['id_servicio'])) {
        $_SESSION['error'] = "ID de servicio no recibido.";
        header("Location: /metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php"); // Ajusta la ubicación correcta
        exit();
    } else {
        $id_servicio = $_SESSION['id_servicio'];
    }
}
// Crear instancia del modelo
$modelo = new SubsistemaModel($pdo);

// Obtener ambientes
try {
    $ambientes = $modelo->obtenerAmbientes();
} catch (Exception $e) {
    $_SESSION['error'] = "Error al obtener ambientes: " . $e->getMessage();
    header("Location: /metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php");
    exit();
}

// Procesar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ambiente = $_POST['id_ambiente'] ?? null;
    $nombre = $_POST['nombre_subsistema'] ?? null;

    try {
        if (!$id_ambiente) {
            throw new Exception("Debe seleccionar un ambiente.");
        }
        if (empty($nombre)) {
            throw new Exception("El nombre del subsistema es obligatorio.");
        }

        // Registrar el subsistema
        $modelo->registrar($id_servicio, $id_ambiente, $nombre);

        $_SESSION['exito'] = "Subsistema registrado exitosamente.";
        header("Location: /metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: /metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php");
        exit();
    }
}

// Mostrar vista (solicitudes GET)
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/registrar_servicios/subsistema/vista/vista_subsistema.php';
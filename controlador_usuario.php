<?php
// controlador_usuario.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/conexion/conexion_bd.php';
require_once __DIR__ . '/inicio/modelo/modelo_usuario.php';

// Verificar autenticación
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /login/index.php');
    exit();
}

try {
    $modelo = new ModeloUsuario($pdo);
    $datosUsuario = $modelo->obtenerInformacionUsuario($_SESSION['id_usuario']);
    
    // Guardar en sesión para reutilizar
    $_SESSION['usuario'] = [
        'nombre' => $datosUsuario->nombre_personal,
        'perfil' => $datosUsuario->nombre_perfil,
        'id_usuario' => $datosUsuario->id_usuario,
        'carnet' => $datosUsuario->carnet,
        'servicio' => $datosUsuario->nombre_servicio
    ];
    
} catch (PDOException $e) {
    error_log("Error en controlador_usuario: " . $e->getMessage());
    header('Location: /error.php');
    exit();
}
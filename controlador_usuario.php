<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// controlador_inicio.php
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

// Obtener conexión y modelo

$modelo = new ModeloUsuario($pdo);

// Obtener y procesar datos
$datosUsuario = $modelo->obtenerInformacionUsuario($_SESSION['id_usuario']);

// Mapear datos para la vista
$informacionUsuario = [
    'nombre' => $datosUsuario->nombre_personal,
    'perfil' => $datosUsuario->nombre_perfil,
    'usuario' => $datosUsuario->usuario,
    'carnet' => $datosUsuario->carnet,
    'servicio' => $datosUsuario->nombre_servicio
];

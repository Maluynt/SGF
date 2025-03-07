<?php
require_once '../conexion/conexion_bd.php';
require_once 'vista/abrir_falla.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/controlador_usuario.php'; 

$modelo = new ModeloUsuario($pdo);

// Obtener y procesar datos
$datosUsuario = $modelo->obtenerInformacionUsuario($_SESSION['id_usuario']);
?>
<?php
// controlador_login.php
session_start();
require_once __DIR__ . '/../../conexion/conexion_bd.php';
require_once __DIR__ . '/../modelo/modelo.php';

$usuarioModel = new Usuario($pdo);

try {
    // Validación CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        throw new Exception('Token de seguridad inválido');
    }

    // Validar campos vacíos
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        throw new Exception('Complete todos los campos');
    }

    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['password']);

    // Autenticación mejorada
    $datosUsuario = $usuarioModel->verificarCredenciales($usuario, $clave);
    
    if (!$datosUsuario) {
        $usuarioModel->registrarAccion(null, $usuario, 'Intento fallido de acceso');
        throw new Exception('Credenciales incorrectas');
    }

    // Verificar estructura de datos obtenida
    if (!property_exists($datosUsuario, 'nombre_perfil')) {
        error_log("Error crítico: El perfil no está definido para el usuario $usuario");
        throw new Exception('Error en la configuración del usuario');
    }

    // Configurar sesión con validación
  $_SESSION = [
    "id_usuario" => $datosUsuario->id_usuario,
    "usuario" => $datosUsuario->usuario,
    "nombre_perfil" => mb_strtoupper($datosUsuario->nombre_perfil, 'UTF-8'),
    "nombre_personal" => $datosUsuario->nombre_personal ?? 'Usuario no identificado',
    "carnet" => $datosUsuario->carnet ?? 'Sin carnet', // Nuevo campo añadido
    "nombre_servicio" => $datosUsuario->nombre_servicio ?? 'Servicio no asignado',
    "id_servicio" => $datosUsuario->id_servicio ?? 0,
    "tiempo_actividad" => time(),
    "csrf_token" => bin2hex(random_bytes(32))
];
    // Registrar acceso exitoso
    $usuarioModel->registrarAccion(
        $_SESSION['id_usuario'],
        $_SESSION['nombre_personal'],
        'Acceso concedido al sistema'
    );

    // Redirección segura
    header("Location: /metro/SGF/" . obtenerRutaSegunPerfil($_SESSION['nombre_perfil']));
    exit();

} catch (Exception $e) {
    error_log("Error en controlador_login: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    header("Location: /metro/SGF/login/index.php");
    exit();
}

function obtenerRutaSegunPerfil(string $perfil): string {
    $rutasValidas = [
        'ADMINISTRADOR' => 'Administrador/controlador/controlador.php',
        'INSPECTOR' => 'Administrador/controlador/controlador.php',
        'COORDINADOR' => 'Administrador/controlador/controlador.php',
        'CONTROLADOR' => 'Administrador/controlador/controlador.php'
    ];

    $perfil = mb_strtoupper(trim($perfil), 'UTF-8');
    return $rutasValidas[$perfil] ?? 'inicio/controlador/controlador_inicio.php';
}
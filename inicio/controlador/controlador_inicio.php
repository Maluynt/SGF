<?php
// controlador_inicio.php
declare(strict_types=1);

// 1. Configuración inicial
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$esVistaSegura = true; // Define la bandera de seguridad
// 2. Autenticación
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
verificarAutenticacion();


try {
    // 3. Conexión a BD
    require_once __DIR__ . '/../../conexion/conexion_bd.php';
    
    // 4. Modelo
    require_once __DIR__ . '/../modelo/modelo_usuario.php';
    $modeloUsuario = new ModeloUsuario($pdo);

    // 5. Datos del usuario
    if (!isset($_SESSION['id_usuario'])) {
        throw new Exception("Sesión no válida");
    }
    
    $datosUsuario = $modeloUsuario->obtenerInformacionUsuario((int)$_SESSION['id_usuario']);

    if (!$datosUsuario) {
        throw new Exception("Usuario no encontrado");
    }

    // 6. Cargar vista
   // Línea 38 (versión corregida)
$informacionUsuario = [
    'nombre' => htmlspecialchars((string) $datosUsuario->nombre_personal),
    'nombre_perfil' => htmlspecialchars((string) $datosUsuario->nombre_perfil),
    'id_perfil' => (int) $datosUsuario->id_perfil, // No necesita htmlspecialchars
    'usuario' => htmlspecialchars((string) $datosUsuario->usuario),
    'carnet' => htmlspecialchars((string) $datosUsuario->carnet),
    'servicio' => htmlspecialchars((string) $datosUsuario->nombre_servicio)
];

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/controlador/controlador_consulta.php';
    include __DIR__ . '/../vista/vista_inicio.php';

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}







<?php

declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/login/modelo/modelo.php';

// ======================================================================
// Configuración de Seguridad Avanzada
// ======================================================================
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/errores_secundarios.log');

// Configuración de Cookies Seguras
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', '1');
ini_set('session.gc_maxlifetime', '1800');
ini_set('session.gc_probability', '1');
ini_set('session.gc_divisor', '100');

// Inicialización Segura de Sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    session_regenerate_id(true);
}

$usuarioModel = new Usuario($pdo);

// ======================================================================
// Funciones de Seguridad
// ======================================================================

/**
 * Verificación completa de la sesión activa
 */
function verificarAutenticacion(): void
{
    $camposRequeridos = [
        'id_usuario' => 'Identificación de usuario',
        'nombre_perfil' => 'Perfil de acceso',
        'tiempo_actividad' => 'Tiempo de sesión',
        'nombre_personal' => 'Nombre del usuario'
    ];

    foreach ($camposRequeridos as $campo => $descripcion) {
        if (empty($_SESSION[$campo])) {
            registrarErrorSeguridad("Campo requerido faltante: $descripcion");
            destruirSesion();
            redirigirLogin('error=sesion');
        }
    }

    // Verificar inactividad de 30 minutos
    if ((time() - $_SESSION['tiempo_actividad']) > 1800) {
        registrarErrorSeguridad("Sesión expirada por inactividad");
        destruirSesion();
        redirigirLogin('timeout=1');
    }

    // Actualizar actividad
    $_SESSION['tiempo_actividad'] = time();
}

/**
 * Control de acceso por roles
 */
function verificarPermisos(array $perfilesPermitidos): void
{
    $perfilUsuario = mb_strtoupper($_SESSION['nombre_perfil'] ?? '', 'UTF-8');
    $perfilesPermitidos = array_map('mb_strtoupper', $perfilesPermitidos);

    if (!in_array($perfilUsuario, $perfilesPermitidos, true)) {
        registrarErrorSeguridad("Intento de acceso no autorizado: $perfilUsuario");
        destruirSesion();
        redirigirLogin('error=permisos');
    }
}

// ======================================================================
// Funciones de Registro y Auditoría
// ======================================================================

/**
 * Registro detallado de acciones
 */


function registrarAccionBitacora(): void
{
    global $usuarioModel;

    if (!isset($_SESSION['id_usuario'], $_SESSION['nombre_personal'])) return;

    $ruta = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $rutaLowerCase = strtolower($ruta); // Para hacer coincidencias insensibles a mayúsculas

    $accion = match ($ruta) {
        '/metro/SGF/Administrador/controlador/controlador.php' => 'Gestion de Servicios',
        '/metro/SGF/inicio/controlador/controlador_inicio.php' => 'Inicio',
        '/metro/SGF/abrir/controlador/Controlador.php' => 'Apertura de Falla',
        '/metro/SGF/consulta/controlador/controlador_consulta.php' => 'Consulta de Fallas',
        '/metro/SGF/reporte/controlador/controlador_consulta.php' => 'Generación de Reporte',
        '/metro/SGF/estadistica/controlador/controlador_consulta.php' => 'Visualización de Estadísticas',
        '/metro/SGF/usuarios/controlador/controlador_registrar_usuario.php' => 'Registro de Usuario',
       '/metro/SGF/consulta/controlador/controlador_editar.php' => 'Edición de registro', // Nueva acción
        '/metro/SGF/estadistica/controlador/controlador_editar.php' => 'Edición de Falla', // Nueva acción
        '/metro/SGF/reporte/controlador/controlador_editar.php' => 'Edición de Falla', // Nueva acción
         '/metro/SGF/logout/controlador_logout.php' => 'Cierre de sesión',


         '/metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php'=>'Gestion de Servicios',


        default => 'Acción no categorizada: ' . $ruta
    };

    try {
        $usuarioModel->registrarAccion(
            $_SESSION['id_usuario'],
            $_SESSION['nombre_personal'],
            "[{$_SESSION['nombre_perfil']}] $accion",
            obtenerIdFalla()
        );
    } catch (PDOException $e) {
        error_log("Error crítico en bitácora: " . $e->getMessage());
    }
}

// ======================================================================
// Funciones de Soporte
// ======================================================================

function obtenerIdFalla(): ?int
{
    return filter_input(INPUT_POST, 'id_falla', FILTER_VALIDATE_INT)
        ?? $_SESSION['ultimo_id_falla']
        ?? null;
}

function destruirSesion(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function redirigirLogin(string $params = ''): void
{
    $url = "/metro/SGF/login/index.php" . ($params ? "?$params" : "");
    header("Location: $url");
    exit;
}

function generarTokenCSRF(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validarTokenCSRF(string $token): void
{
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        registrarErrorSeguridad("Intento de ataque CSRF bloqueado");
        destruirSesion();
        redirigirLogin('error=csrf');
    }
}

function registrarErrorSeguridad(string $mensaje): void
{
    $detalles = [
        'IP' => $_SERVER['REMOTE_ADDR'],
        'User-Agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        'Ruta' => $_SERVER['REQUEST_URI']
    ];
    error_log("ALERTA DE SEGURIDAD: $mensaje | " . json_encode($detalles));
}

// ======================================================================
// Ejecución Principal
// ======================================================================
try {
    verificarAutenticacion();
    generarTokenCSRF();
    registrarAccionBitacora();
} catch (Throwable $e) {
    error_log("Falla crítica en sistema de autenticación: " . $e->getMessage());
    destruirSesion();
    redirigirLogin('error=critico');
}

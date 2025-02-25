<nav class="sidebar bg-dark">
    <div class="sidebar-header">
        <h4 class="text-white mb-0">Menú Principal</h4>
    </div>

    <div class="sidebar-menu">
        <div class="menu-section">
            <div class="menu-item user-info">
                <div class="user-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="user-icon">👤</span>
                        <h5 class="m-0">Usuario</h5>
                    </div>
                    <i class="dropdown-icon"></i>
                </div>
                <div class="user-details">
                    <p class="m-1">Nombre: <?= isset($informacionUsuario['nombre']) ? $this->$informacionUsuario['nombre'] : 'No disponible' ?></p>
                    <p class="m-1">Perfil: <?= isset($informacionUsuario['perfil']) ? $this->obtenerNombrePerfil($informacionUsuario['perfil']) : 'No disponible' ?></p>
                    <p class="m-1">Carnet: <?= isset($informacionUsuario['carnet']) ? $informacionUsuario['carnet'] : 'No disponible' ?></p>
                    <p class="m-1">Servicio: <?= isset($informacionUsuario['servicio']) ? $this->obtenerNombreServicio($informacionUsuario['servicio']) : 'No disponible' ?></p>
                </div>
            </div>
        </div>

        <div class="menu-section">
            <div class="menu-item registry-menu">
                <div class="menu-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="menu-icon">📝</span>
                        <h5 class="m-0">Registros</h5>
                    </div>
                    <i class="dropdown-icon"></i>
                </div>
                <div class="submenu">
                    <a href="#" class="submenu-item">Servicios</a>
                    <a href="#" class="submenu-item">Subsistemas</a>
                    <a href="#" class="submenu-item">Equipos</a>
                </div>
            </div>
        </div>

        <a href="#" class="menu-item">Descargas</a>
        <a href="#" class="menu-item">Historial</a>
        <a href="#" class="menu-item">Ayuda</a>
        <a href="<?= BASE_URL ?>login/controlador_cerrar_sesion.php" class="menu-item logout-btn">Salir</a>
    </div>
</nav> este es el siderbar.php
<?php 
// Definir constante BASE_URL
define('BASE_URL', 'http://localhost/metro/SGF/inicio/vista/vista_inicio.php');http:


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include ("../modelo/modelo_usuario.php");

// Asegúrate de que $informacionUsuario esté definido
if (isset($informacionUsuario)) {
    $nombre = $informacionUsuario['nombre'];
    $perfil = $informacionUsuario['perfil'];
    $usuario = $informacionUsuario['usuario'];
    $carnet = $informacionUsuario['carnet'];
} else {
    // Maneja el caso en que no hay información del usuario
    // Por ejemplo, redirigir a una página de error o mostrar un mensaje
}
?>


<?php include '../partials/header.php'; ?>

<?php include '../partials/siderbar.php'; ?>

<main class="main-content">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 content-area">
                <h2 class="text-primary">Bienvenido al Sistema</h2>
                <div class="card mt-3">
                    <div class="card-body">
                        <p class="card-text">Contenido principal de la aplicación</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../partials/footer.php'; ?> esta es la vista_inicio.php, por que no me muestra la informacion del usuario
<?php
session_start();
require_once '../../conexion/conexion_bd.php';
require_once __DIR__ . '/../modelo/modelo_usuario.php';



// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../../login/index.php');
    exit();
}

// Obtener datos del usuario

$datosUsuario = $modelo->obtenerInformacionUsuario($_SESSION['id_usuario']);

// Mapear datos para la vista
$informacionUsuario = [
    'nombre' => $datosUsuario->nombre_personal,
    'perfil' => $datosUsuario->id_perfil,
    'usuario' => $datosUsuario->usuario,
    'carnet' => $datosUsuario->carnet,
    'servicio' => $datosUsuario->id_servicio
];

// Definir constante BASE_URL
define('BASE_URL', 'http://localhost/metro/SGF/inicio/controlador/controlador_inicio.php');

// Cargar la vista
include __DIR__ . '../vista/vista_inicio.php';
?>este es el controlador_inicio.php
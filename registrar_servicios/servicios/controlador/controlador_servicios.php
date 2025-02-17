<?php
// controlador_servicios.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../../../conexion/conexion_bd.php");
include("../modelo/modelo_servicios.php");

include("../../../login/modelo/modelo.php"); // Asegúrate de que esta línea apunte al archivo correcto

// Instancia de la clase Usuario
$usuarioModel = new Usuario($pdo);

// Verifica si el usuario está logueado
if (empty($_SESSION["id_usuario"])) {
    header("Location:../login/vista_login.php");
    exit();
}

// Obtener información del usuario
$informacionUsuario = $usuarioModel->verificarCredenciales($_SESSION["usuario"], ''); // Puedes obtener el usuario de la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
    if (empty($_POST["servicio"])) {
        echo "<script>alert('Algunos Campos Están Vacíos'); window.location.href = 'electrificacion.php';</script>";
        exit();
    }

    $servicio = trim($_POST["servicio"]);

    // Validación mejorada
    if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ\s\-\.,]{2,}$/u", $servicio)) {
        echo "<script>alert('El servicio debe comenzar con mayúscula y tener al menos 3 caracteres.'); window.location.href = 'electrificacion.php';</script>";
        exit();
    }

    $modeloServicio = new ModeloServicio($pdo);
    
    try {
        if ($modeloServicio->registrarServicio($servicio)) {
            echo "<script>alert('Datos Registrados Correctamente'); window.location.href = '../vista/vista_servicios.php';</script>";
        }
    } catch (PDOException $e) {
        $error = htmlspecialchars($e->getMessage(), ENT_QUOTES);
        echo "<script>alert('Error al registrar: $error'); window.location.href = '../vista/vista_servicios.php';</script>";
    }
}
?>

<?php
session_start();
include("../conexion/conexion_bd.php");
require 'Modelo.php';

$usuarioModel = new Usuario($mysqli);

if (isset($_SESSION['usuario'])) {
    header("Location: #"); // Redirigir si ya está autenticado
    exit();
}

// Establecer encabezados para evitar el almacenamiento en caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!empty($_POST["btningresar"])) {
    // Verificar si los campos están vacíos
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        echo "<script type='text/javascript'>
                alert('Algunos campos están vacíos');
                window.location.href = '../login/logins.php'; 
              </script>";
        exit();
    }

    $usuario = $_POST["usuario"];
    $clave = $_POST["password"];
    
    $datosUsuario = $usuarioModel->verificarCredenciales($usuario, $clave);

    if ($datosUsuario) {
        // Guardar datos del usuario en la sesión
        $_SESSION["id_usuario"] = $datosUsuario->id_usuario;
        $_SESSION["nombre_usuario"] = $datosUsuario->nombre_usuario;
        $_SESSION["usuario"] = $datosUsuario->usuario;
        $_SESSION["apellido_usuario"] = $datosUsuario->apellido_usuario;

        // Registrar el inicio de sesión
        $usuarioModel->registrarLogin($datosUsuario->nombre_usuario, $datosUsuario->apellido_usuario, 'Inicio');

        // Redirigir a la página de inicio según el perfil del usuario
        switch ($datosUsuario->id_perfil) {
            case 1:
                header("Location: ../coordinador/inicio/inicio.php");
                break;
            case 2:
                header("Location: ../inspector/inicio/inicio.php");
                break;
            case 3:
                header("Location: ../controlador/inicio/inicio.php");
                break;
            case 4:
                header("Location: ../consulta/inicio/inicio.php");
                break;
            default:
                echo "<script type='text/javascript'>
                        alert('Perfil no válido');
                        window.location.href = '../login/logins.php'; 
                      </script>";
                break;
        }
        exit();
    } else {
        echo "<script type='text/javascript'>
                alert('Acceso denegado');
                window.location.href = '../login/logins.php'; 
              </script>";
    }
}
?>
controlador_login

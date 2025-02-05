<?php
// Inicia una nueva sesión o reanuda una existente basada en la cookie de sesión del usuario.
session_start();

// Incluye el archivo que contiene la conexión a la base de datos.
include("../conexion_bd/conexion_bd.php");

// Incluye el archivo que contiene la definición de la clase Modelo.
require 'Modelo.php';

// Crea una instancia de la clase Usuario, pasando la conexión a la base de datos.
$usuarioModel = new Usuario($mysqli);

// Verifica si ya existe una sesión de usuario activa.
if (isset($_SESSION['usuario'])) {
    // Si ya hay una sesión, redirige al usuario a una página específica.
    header("Location: #"); // Debes cambiar "#" por la URL a la que deseas redirigir.
    exit(); // Detiene la ejecución del script para asegurar la redirección.
}

// Establece encabezados para evitar que la página se guarde en caché.
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verifica si se ha enviado el formulario de inicio de sesión.
if (!empty($_POST["btningresar"])) {
    // Verifica si los campos de usuario y contraseña están vacíos.
    if (empty($_POST["usuario"]) || empty($_POST["password"])) {
        // Muestra una alerta si los campos están vacíos.
        echo "<script type='text/javascript'>
                alert('Algunos campos están vacíos');
                window.location.href = '../login/logins.php'; 
              </script>";
        exit(); // Detiene la ejecución del script.
    }

    // Obtiene el usuario y la contraseña del formulario.
    $usuario = $_POST["usuario"];
    $clave = $_POST["password"];
    
    // Llama al método verificarCredenciales del modelo de usuario para validar las credenciales.
    $datosUsuario = $usuarioModel->verificarCredenciales($usuario, $clave);

    // Verifica si las credenciales son correctas.
    if ($datosUsuario) {
        // Guarda los datos del usuario en la sesión.
        $_SESSION["id_usuario"] = $datosUsuario->id_usuario;
        $_SESSION["nombre_usuario"] = $datosUsuario->nombre_usuario;
        $_SESSION["usuario"] = $datosUsuario->usuario;
        $_SESSION["apellido_usuario"] = $datosUsuario->apellido_usuario;

        // Registra el inicio de sesión en la base de datos.
        $usuarioModel->registrarLogin($datosUsuario->nombre_usuario, $datosUsuario->apellido_usuario, 'Inicio');

        // Redirige al usuario a la página de inicio correspondiente a su perfil.
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
                // Muestra una alerta si el perfil no es válido.
                echo "<script type='text/javascript'>
                        alert('Perfil no válido');
                        window.location.href = '../login/logins.php'; 
                      </script>";
                break;
        }
        exit(); // Detiene la ejecución del script.
    } else {
        // Muestra una alerta si las credenciales son incorrectas.
        echo "<script type='text/javascript'>
                alert('Acceso denegado');
                window.location.href = '../login/vista_login.php'; 
              </script>";
    }
}
?>
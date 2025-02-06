<?php
include("../conexion_bd/conexion_bd.php");
include("modelo/modelorecuperarcontraseña.php");

$modelo = new ModeloRecuperarContrasena($pdo);

if (isset($_POST['btningresar'])) {
    $errores = [];
    $carnet_usuario = $_POST['carnet_usuario'];
    $pregunta_secreta = $_POST['pregunta_secreta'];
    $respuesta_secreta = $_POST['respuesta_secreta'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validaciones
    if (empty($carnet_usuario)) {
        $errores[] = "El campo carnet de usuario está vacío.";
    }
    if (empty($pregunta_secreta)) {
        $errores[] = "El campo pregunta secreta está vacío.";
    }
    if (empty($respuesta_secreta)) {
        $errores[] = "El campo respuesta secreta está vacío.";
    }
    if (empty($nueva_contrasena)) {
        $errores[] = "El campo nueva contraseña está vacío.";
    }
    if (empty($confirmar_contrasena)) {
        $errores[] = "El campo confirmar contraseña está vacío.";
    }
    if ($nueva_contrasena !== $confirmar_contrasena) {
        $errores[] = "Las contraseñas no coinciden.";
    }
    if (strlen($nueva_contrasena) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    }
    if (!preg_match('/[A-z]/', $nueva_contrasena) || !preg_match('/[0-9]/', $nueva_contrasena)) {
        $errores[] = "La contraseña debe contener al menos una letra y un número.";
    }

    // Si hay errores, mostrar mensajes
    if (!empty($errores)) {
        echo '<script type="text/javascript">';
        echo 'alert("' . addslashes(implode("\\n", $errores)) . '");';
        echo '</script>';
    } else {
        // Verificar si el usuario existe en la base de datos
        $usuario = $modelo->verificarUsuario($carnet_usuario);

        if ($usuario) {
            // Verificar pregunta y respuesta secreta
            if ($usuario['pregunta_secreta'] === $pregunta_secreta && $usuario['respuesta_secreta'] === $respuesta_secreta) {
                // Actualizar contraseña
                if ($modelo->actualizarContrasena($carnet_usuario, $nueva_contrasena)) {
                    echo '<script type="text/javascript">';
                    echo 'alert("Contraseña actualizada correctamente.");';
                    echo 'window.location.href = "../login/index.php";';
                    echo '</script>';
                } else {
                    echo '<script type="text/javascript">';
                    echo 'alert("Error al actualizar la contraseña.");';
                    echo '</script>';
                }
            } else {
                $mensaje = '';
                if ($usuario['pregunta_secreta'] !== $pregunta_secreta) {
                    $mensaje .= "Pregunta secreta incorrecta.\\n";
                }
                if ($usuario['respuesta_secreta'] !== $respuesta_secreta) {
                    $mensaje .= "Respuesta secreta incorrecta.\\n";
                }
                echo '<script type="text/javascript">';
                echo 'alert("' . addslashes(trim($mensaje)) . '");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("El carnet de usuario no existe.");';
            echo '</script>';
        }
    }
}
?>

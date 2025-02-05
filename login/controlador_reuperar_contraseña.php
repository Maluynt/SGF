<?php
include("../conexion_bd/conexion_bd.php");

if (isset($_POST['btningresar'])) {
    $errores = [];
    $carnet_usuario = $_POST['carnet_usuario'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validaciones
    if (empty($carnet_usuario)) {
        $errores[] = "El campo carnet de usuario está vacío.";
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
        $sql = $mysqli->prepare("SELECT * FROM usuario WHERE usuario=?");
        $sql->bind_param("s", $carnet_usuario);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows > 0) {
            $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $update_sql = $mysqli->prepare("UPDATE usuario SET contraseña=? WHERE usuario=?");
            $update_sql->bind_param("ss", $hashed_password, $carnet_usuario);

            if ($update_sql->execute()) {
                echo '<script type="text/javascript">';
                echo 'alert("Contraseña actualizada correctamente.");';
                echo 'window.location.href = "../login/logins.php";';
                echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Error al actualizar la contraseña.");';
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

<?php
include ('../../conexion/conexion_bd.php');

if (!empty($_POST['btnregistrar'])) {
    if (empty($_POST['nombre_ubicacion'])) {
        echo "<script>alert('Algunos Campos Están Vacíos'); window.location.href='../registro/ubicacion.php';</script>";
    } else {
        $ubicacion = $_POST['nombre_ubicacion'];

        // Validaciones
        if (!preg_match("/^[A-Z][a-zA-Z\s\W]{2,}$/", $ubicacion)) {
            echo "<script>alert('La ubicación debe comenzar con una letra mayúscula, tener al menos 3 caracteres y acepta caracteres especiales.'); window.location.href='../registro/ubicacion.php';</script>";
        } else {
            $sql = $mysqli->query("INSERT INTO ubicacion(ubicacion) VALUES('$ubicacion')");

            if ($sql) {
                echo "<script>alert('Datos Registrados Correctamente'); window.location.href='../inicio/inicio.php';</script>";
            } else {
                echo "<script>alert('Error al registrar los datos'); window.location.href='../registro/ubicacion.php';</script>";
            }
        }
    }
}
?>

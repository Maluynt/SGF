<?php
include ('../../conexion/conexion_bd.php');

if (!empty($_POST['btnregistrar'])) {
    if (empty($_POST["equipo"]) || empty($_POST["id_equipo_subsistema"])) {
        echo "<script>alert('Algunos Campos Están Vacíos'); window.location.href='../registro/equipo.php';</script>";
    } else {
        $equipo = $_POST["equipo"]; /* aquí se recibe datos de equipo */
        $id_equipo_subsistema = $_POST["id_equipo_subsistema"];

        // Validación para el campo equipo
        if (!preg_match("/^[A-Z][a-zA-Z\s\W]{2,}$/", $equipo)) {
            echo "<script>alert('El equipo debe comenzar con una letra mayúscula, tener al menos 3 caracteres y acepta caracteres especiales.'); window.location.href='../registro/equipo.php';</script>";
        } 
        // Validación para el campo id_equipo_subsistema
        elseif (!preg_match("/^[0-9\s\W]{1,}$/", $id_equipo_subsistema)) {
            echo "<script>alert('El Código del subsistema debe ser un número con al menos 1 carácter y aceptar caracteres especiales.'); window.location.href='../registro/equipo.php';</script>";
        } else {
            $sql = $mysqli->query("INSERT INTO equipo (id_subsistema, nombre_equipo) VALUES ('$id_equipo_subsistema', '$equipo')");

            if ($sql) {
                echo "<script>alert('Datos Registrados Correctamente'); window.location.href='../inicio/inicio.php';</script>";
            } else {
                echo "<script>alert('Error al registrar los datos'); window.location.href='../registro/equipo.php';</script>";
            }
        }
    }
}
?>

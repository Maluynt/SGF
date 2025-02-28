<?php
// controlador_servicios.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/controlador_usuario.php'; 

include("../../../conexion/conexion_bd.php");
include("../modelo/modelo_servicios.php");


try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
        if (empty($_POST["servicio"])) {
            $_SESSION['error'] = 'Algunos Campos Están Vacíos';
            header("Location: /metro/SGF/registrar_servicios/servicios/controlador/controlador_servicios.php");
            exit();
        }

        $servicio = trim($_POST["servicio"]);

        // Validación mejorada
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ\s\-\.,]{2,}$/u", $servicio)) {
            $_SESSION['error'] = 'El servicio debe comenzar con mayúscula y tener al menos 3 caracteres.';
            header("Location: /metro/SGF/registrar_servicios/servicios/controlador/controlador_servicios.php");
            exit();
        }

        $modeloServicio = new ModeloServicio($pdo);
        $_SESSION['exito'] = "Subsistema registrado exitosamente.";
        header("Location: /metro/SGF/registrar_servicios/servicios/controlador/controlador_servicios.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /metro/SGF/registrar_servicios/servicios/controlador/controlador_servicios.php");
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/registrar_servicios/servicios/vista/vista_servicios.php';

?>
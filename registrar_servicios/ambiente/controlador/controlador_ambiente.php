<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/controlador_usuario.php'; 
require_once __DIR__ . '/../../../conexion/conexion_bd.php';
require_once __DIR__ . '/../modelo/modelo_ambiente.php';


// Remover el exit(); que estaba aquí

try {
    $modeloambiente = new AmbienteModel($pdo);

    // Obtener ubicaciones para el select
    $ubicaciones = $modeloambiente->obtenerUbicacion();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
        // Validar campos
        if (empty($_POST['ambiente']) || empty($_POST['id_ubicacion'])) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $nombre = trim($_POST['ambiente']);
        $id_ubicacion = (int)$_POST['id_ubicacion'];

        // Validar formato del nombre
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][\wáéíóúñ\s\-\.,!@#$%^&*()]{2,}$/u", $nombre)) {
            throw new Exception("El nombre debe comenzar con mayúscula y tener mínimo 3 caracteres");
        }

        // Registrar ambiente
        if ($modeloambiente->registrar($id_ubicacion, $nombre)) {
            $_SESSION['exito'] = "Ambiente registrado exitosamente!";
        } else {
            throw new Exception("Error al guardar en la base de datos");
        }

        header("Location: /metro/SGF/registrar_servicios/ambiente/vista/vista_ambiente.php");
        exit();
    }

} catch (PDOException $e) {
    $errorMsg = match ($e->getCode()) {
        '23503' => "Error: La ubicación seleccionada no es válida",
        '23505' => "El ambiente ya existe en esta ubicación",
        default => "Error de base de datos: " . $e->getMessage()
    };
    $_SESSION['error'] = $errorMsg;
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}



// Incluir la vista al final del script
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/registrar_servicios/ambiente/vista/vista_ambiente.php';

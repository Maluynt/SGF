<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
verificarAutenticacion();

require_once __DIR__ . '/../../../conexion/conexion_bd.php';
require_once __DIR__ . '/../modelo/modelo_ambiente.php';

try {
    $modeloambiente = new AmbienteModel($pdo);
    $ubicaciones = $modeloambiente->obtenerUbicacion();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
        if (empty($_POST['ambiente']) || empty($_POST['id_ubicacion'])) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $nombre = trim($_POST['ambiente']);
        $id_ubicacion = (int)$_POST['id_ubicacion'];

        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][\wáéíóúñ\s\-\.,!@#$%^&*()]{2,}$/u", $nombre)) {
            throw new Exception("El nombre debe comenzar con mayúscula y tener mínimo 3 caracteres");
        }

        if ($modeloambiente->registrar($id_ubicacion, $nombre)) {
            $_SESSION['exito'] = "Ambiente registrado exitosamente!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            throw new Exception("Error al guardar en la base de datos");
        }
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

// Incluir la vista una sola vez al final
$esVistaSegura = true;
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/registrar_servicios/ambiente/vista/vista_ambiente.php';
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
verificarAutenticacion();

require_once __DIR__ . '../../../../conexion/conexion_bd.php';
require_once __DIR__ . '/../modelo/modelo_ubicacion.php';

try {
    $modelo = new UbicacionModel($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
        // Validaciones
        if (empty($_POST['ubicacion'])) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $nombre = trim($_POST['ubicacion']);

        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][\wáéíóúñ\s\-\.,!@#$%^&*()]{2,}$/u", $nombre)) {
            throw new Exception("El nombre debe comenzar con mayúscula y tener mínimo 3 caracteres (se permiten números y símbolos)");
        }

        // Registro
        if ($modelo->registrar($nombre)) {
            $_SESSION['exito'] = "Registro exitoso!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            throw new Exception("Error al guardar en la base de datos");
        }
    }

} catch (PDOException $e) {
    $_SESSION['error'] = match ($e->getCode()) {
        '23000' => "Error: Ambiente o servicio no válido",
        default => "Error de base de datos: " . $e->getMessage()
    };
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

// Incluir la vista una sola vez al final
$esVistaSegura = true;
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/registrar_servicios/ubicacion/vista/vista_ubicacion.php';
?>
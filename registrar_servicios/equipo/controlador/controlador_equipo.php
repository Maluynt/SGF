<?php
session_start();
require_once __DIR__ . '/../../../conexion/conexion_bd.php';
require_once __DIR__ . '/../modelo/modelo_equipo.php';

try {
    $modeloEquipo = new EquipoModel($pdo);

    // Obtener subsistemas para el select
    $subsistemas = $modeloEquipo->obtenerSubsistemas();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
        // Validar campos
        if (empty($_POST['equipo']) || empty($_POST['subsistema'])) {
            throw new Exception("Todos los campos son obligatorios");
        }

        $nombre = trim($_POST['equipo']);
        $id_subsistema = (int)$_POST['subsistema']; // Capturar ID del subsistema

        // Validar formato del nombre
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][\wáéíóúñ\s\-\.,!@#$%^&*()]{2,}$/u", $nombre)) {
            throw new Exception("El nombre debe comenzar con mayúscula y tener mínimo 3 caracteres");
        }

        // Registrar equipo con el subsistema
        if ($modeloEquipo->registrar($id_subsistema, $nombre)) {
            $_SESSION['exito'] = "Equipo registrado exitosamente!";
        } else {
            throw new Exception("Error al guardar en la base de datos");
        }

        header("Location: ../vista/vista_equipo.php");
        exit();
    }

} catch (PDOException $e) {
    $errorMsg = match ($e->getCode()) {
        '23503' => "Error: El subsistema seleccionado no es válido",
        '23505' => "El equipo ya existe en este subsistema",
        default => "Error de base de datos: " . $e->getMessage()
    };
    
    $_SESSION['error'] = $errorMsg;

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

// Pasar variables a la vista
require '../vista/vista_equipo.php';
exit();
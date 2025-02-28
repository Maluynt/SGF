<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/controlador_usuario.php'; 
require_once __DIR__ . '../../../../conexion/conexion_bd.php';
require_once __DIR__ . '/../modelo/modelo_ubicacion.php'; // Subir un nivel para acceder a la carpeta 'modelo'

$modelo = new UbicacionModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
    try {
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
        } else {
            throw new Exception("Error al guardar en la base de datos");
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getCode() === '23000' 
            ? "Error: Ambiente o servicio no válido" 
            : "Error de base de datos: " . $e->getMessage();
            
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    
    header("Location: /metro/SGF/registrar_servicios/ubicacion/vista/vista_ubicacion.php");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/registrar_servicios/ubicacion/vista/vista_ubicacion.php';


?>
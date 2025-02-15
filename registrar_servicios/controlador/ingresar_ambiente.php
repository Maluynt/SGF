<?php

error_reporting(E_ALL); // Habilitar todos los errores
ini_set('display_errors', 1); // Mostrarlos en pantalla
session_start(); // Asegurar que session_start() esté presente
include('../conexion/conexion_bd.php');
// ... resto del código

if (!empty($_POST['btnregistrar'])) {
    // Validar campos
    if (empty($_POST["ambiente"]) || empty($_POST["ubicacion"])) {
        echo "<script>
                alert('Todos los campos son obligatorios');
                window.location.href='ambiente.php';
              </script>";
        exit();
    }

    // Sanitizar entradas
    $ambiente = trim($_POST["ambiente"]);
    $id_ubicacion = (int)$_POST["ubicacion"];

    // Validar formato del ubicacion
    if (!preg_match("/^[\p{Lu}][\p{Ll}\p{L}\s\-\.,\d]{2,}$/u", $ambiente)) {
        mostrarAlerta('El ambiente debe comenzar con mayúscula y tener al menos 3 caracteres válidos.');
    }
    try {
        // Insertar usando consultas preparadas
        $sql = $pdo->prepare("INSERT INTO ambiente (id_ubicacion, ambiente) VALUES (?, ?)");
        
        // Enlazar los parámetros con tipos
        $sql->bindValue(1, $id_ubicacion, PDO::PARAM_INT); // id_servicio como entero
        $sql->bindValue(2, $ambiente, PDO::PARAM_STR); // nombre_ubicacion como string
        
        // Ejecutar la consulta
        $sql->execute();
        
        echo "<script>
                alert('El ambiente registrado correctamente');
                window.location.href='ambiente.php';
              </script>";
    
    } catch (PDOException $e) {
        // Manejar error de clave foránea (si el id_ambiente no existe)
        if ($e->getCode() == '23000') {
            echo "<script>
                    alert('Error: El ambiente seleccionado no existe');
                    window.location.href='ambiente.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al registrar: " . addslashes($e->getMessage()) . "');
                    window.location.href='ambiente.php';
                  </script>";
        }
    }
}    


?>
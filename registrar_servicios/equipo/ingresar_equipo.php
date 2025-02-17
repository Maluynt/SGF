<?php

error_reporting(E_ALL); // Habilitar todos los errores
ini_set('display_errors', 1); // Mostrarlos en pantalla
session_start(); // Asegurar que session_start() esté presente
include('../conexion/conexion_bd.php');
// ... resto del código

if (!empty($_POST['btnregistrar'])) {
    // Validar campos
    if (empty($_POST["equipo"]) || empty($_POST["subsistema"])) {
        echo "<script>
                alert('Todos los campos son obligatorios');
                window.location.href='equipo.php';
              </script>";
        exit();
    }

    // Sanitizar entradas
    $equipo = trim($_POST["equipo"]);
    $id_subsistema = (int)$_POST["subsistema"];

    // Validar formato del subsistema
    if (!preg_match("/^[\p{Lu}][\p{Ll}\p{L}\s\-\.,\d]{2,}$/u", $equipo)) {
        mostrarAlerta('El equipo debe comenzar con mayúscula y tener al menos 3 caracteres válidos.');
    }
    try {
        // Insertar usando consultas preparadas
        $sql = $pdo->prepare("INSERT INTO equipo (id_subsistema, nombre_equipo) VALUES (?, ?)");
        
        // Enlazar los parámetros con tipos
        $sql->bindValue(1, $id_subsistema, PDO::PARAM_INT); // id_servicio como entero
        $sql->bindValue(2, $equipo, PDO::PARAM_STR); // nombre_subsistema como string
        
        // Ejecutar la consulta
        $sql->execute();
        
        echo "<script>
                alert('El equipo registrado correctamente');
                window.location.href='equipo.php';
              </script>";
    
    } catch (PDOException $e) {
        // Manejar error de clave foránea (si el id_ambiente no existe)
        if ($e->getCode() == '23000') {
            echo "<script>
                    alert('Error: El equipo seleccionado no existe');
                    window.location.href='equipo.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al registrar: " . addslashes($e->getMessage()) . "');
                    window.location.href='equipo.php';
                  </script>";
        }
    }
}    


?>
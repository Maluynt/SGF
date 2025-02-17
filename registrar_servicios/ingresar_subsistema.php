<?php

error_reporting(E_ALL); // Habilitar todos los errores
ini_set('display_errors', 1); // Mostrarlos en pantalla
session_start(); // Asegurar que session_start() esté presente
include('../conexion/conexion_bd.php');
// ... resto del código

if (!empty($_POST['btnregistrar'])) {
    // Validar campos
    if (empty($_POST["sub_sistema"]) || empty($_POST["id_ambiente"])) {
        echo "<script>
                alert('Todos los campos son obligatorios');
                window.location.href='subsistema.php';
              </script>";
        exit();
    }

    // Sanitizar entradas
    $sub_sistema = trim($_POST["sub_sistema"]);
    $id_ambiente = (int)$_POST["id_ambiente"];
    $id_servicio =1;

    // Validar formato del subsistema
    if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ\s\-.,]{2,}$/u", $sub_sistema)) {
        echo "<script>
                alert('El nombre debe empezar con mayúscula y tener al menos 3 caracteres');
                window.location.href='subsistema.php';
              </script>";
        exit();
    }
    try {
        // Insertar usando consultas preparadas
        $sql = $pdo->prepare("INSERT INTO sub_sistema (id_servicio, id_ambiente, nombre_subsistema) VALUES (?, ?, ?)");
        
        // Enlazar los parámetros con tipos
        $sql->bindValue(1, $id_servicio, PDO::PARAM_INT); // id_servicio como entero
        $sql->bindValue(2, $id_ambiente, PDO::PARAM_INT); // id_ambiente como entero
        $sql->bindValue(3, $sub_sistema, PDO::PARAM_STR); // nombre_subsistema como string
        
        // Ejecutar la consulta
        $sql->execute();
        
        echo "<script>
                alert('Subsistema registrado correctamente');
                window.location.href='subsistema.php';
              </script>";
    
    } catch (PDOException $e) {
        // Manejar error de clave foránea (si el id_ambiente no existe)
        if ($e->getCode() == '23000') {
            echo "<script>
                    alert('Error: El servicio seleccionado no existe');
                    window.location.href='subsistema.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al registrar: " . addslashes($e->getMessage()) . "');
                    window.location.href='subsistema.php';
                  </script>";
        }
    }
}    


?>
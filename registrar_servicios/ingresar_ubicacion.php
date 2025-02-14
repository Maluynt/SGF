<?php
include('../conexion_bd/conexion_bd.php');

if (!empty($_POST['btnregistrar'])) {
    if (empty($_POST["ubicacion"])) {
        mostrarAlerta('Algunos Campos Están Vacíos');
    }

    $ubicacion = trim($_POST["ubicacion"]);

    // Validación mejorada con soporte para caracteres internacionales
    if (!preg_match("/^[\p{Lu}][\p{Ll}\p{L}\s\-\.,\d]{2,}$/u", $ubicacion)) {
        mostrarAlerta('La ubicación debe comenzar con mayúscula y tener al menos 3 caracteres válidos.');
    }

    try {
        // Verificar duplicados
        $sqlVerificar = $pdo->prepare("SELECT COUNT(*) FROM ubicacion WHERE ubicacion = :ubicacion");
        $sqlVerificar->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);
        $sqlVerificar->execute();
        
        if ($sqlVerificar->fetchColumn() > 0) {
            mostrarAlerta('Esta ubicación ya existe en el sistema.');
        }

        // Insertar nuevo registro
        $sqlInsert = $pdo->prepare("INSERT INTO ubicacion (ubicacion) VALUES (:ubicacion)");
        $sqlInsert->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);
        
        if ($sqlInsert->execute()) {
            mostrarAlerta('Datos Registrados Correctamente', true);
        } else {
            mostrarAlerta('Error al registrar los datos');
        }

    } catch (PDOException $e) {
        $error = htmlspecialchars($e->getMessage(), ENT_QUOTES);
        mostrarAlerta("Error de base de datos: $error");
    }
}

function mostrarAlerta($mensaje, $exito = false) {
    echo "<script>
            alert('".addslashes($mensaje)."');
            window.location.href = 'ubicacion.php';
          </script>";
    exit();
}
?>
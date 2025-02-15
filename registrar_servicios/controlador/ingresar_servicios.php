<?php
include('../conexion/conexion_bd.php');

if (!empty($_POST['btnregistrar'])) {
    if (empty($_POST["servicio"])) {
        echo "<script>
                alert('Algunos Campos Están Vacíos'); 
                window.location.href = 'electrificacion.php';
              </script>";
        exit();
    }

    $servicio = trim($_POST["servicio"]);

    // Validación mejorada
    if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ\s\-\.,]{2,}$/u", $servicio)) {
        echo "<script>
                alert('El servicio debe comenzar con mayúscula y tener al menos 3 caracteres.'); 
                window.location.href = 'electrificacion.php';
              </script>";
        exit();
    }

    try {
        // Consulta preparada con marcadores de posición
        $sql = $pdo->prepare("INSERT INTO servicio (nombre_servicio) VALUES (:servicio)");
        $sql->bindParam(':servicio', $servicio, PDO::PARAM_STR);
        $sql->execute();

        echo "<script>
                alert('Datos Registrados Correctamente'); 
                window.location.href = 'servicios.php';
              </script>";

    } catch (PDOException $e) {
        // Mensaje de error seguro para JavaScript
        $error = htmlspecialchars($e->getMessage(), ENT_QUOTES);
        echo "<script>
                alert('Error al registrar: $error'); 
                window.location.href = 'servicios.php';
              </script>";
    }
}
?>
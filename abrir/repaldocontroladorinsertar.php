<?php
include ('../../conexion/conexion_bd.php');

if (isset($_POST['btnguardar'])) {

    // Validar que los campos no estén vacíos (excepto descripcion_falla y detalle_ubicacion)
    if (empty ($_POST['metodo_reporte']) || empty($_POST['recibida_ccf']) || empty($_POST['reportada_por']) || empty($_POST['servicio']) || empty($_POST['sub_sistema']) || empty($_POST['equipo']) || empty($_POST['ubicacion']) || empty($_POST['responsable']) || empty($_POST['prioridad']) || empty($_POST['estado']) || empty($_POST['reportada_a'])) {
        echo "<script>alert('ALGUNOS CAMPOS ESTAN VACIOS'); window.location='../abrir/abrir.php';</script>";
        exit();
    } else { 

        $idfalla = $_POST['id_falla'];
        $hora_fecha = $_POST['hora_fecha'];
        $metodo_reporte = $_POST['metodo_reporte'];
        $recibida_ccf = $_POST['recibida_ccf'];
        $reportada_por = $_POST['reportada_por'];
        $servicio = $_POST['servicio'];
        $sub_sistema = $_POST['sub_sistema'];
        $equipo = $_POST['equipo'];
        $ubicacion = trim($_POST['ubicacion']); // No convertir a mayúsculas
        $detalleubicacion = trim($_POST['detalles_ubicacion']); // No convertir a mayúsculas
        $descripcion_falla = trim($_POST['descripcion_falla']); // No convertir a mayúsculas
        $responsable = $_POST['responsable'];
        $prioridad = $_POST['prioridad'];
        $estado = $_POST['estado'];
        $reportada_a = $_POST['reportada_a'];
        $justificacion = $_POST['justificacion'];
        $tecnico = $_POST['tecnico'];
        $acompañamiento = $_POST['acompañamiento'];
        $cerrada_por = $_POST['cerrada_por'];
        $cerrada_ccf = $_POST['cerrada_ccf'];
        $fecha_hora_cierre = $_POST['fecha_hora_cierre'];
        $diasfalla = $_POST['dias_falla'];

        // Validar que el campo detalles_ubicacion comience con mayúscula
        if (!empty($detalleubicacion) && !preg_match('/^[A-Z].*/', $detalleubicacion)) {
            echo "<script>alert('El campo Detalles de Ubicación debe comenzar con una letra mayúscula si se proporciona.'); window.location='../abrir/abrir.php';</script>";
            exit();
        }

        // Validar que el campo descripcion_falla comience con mayúscula
        if (!empty($descripcion_falla) && !preg_match('/^[A-Z].*/', $descripcion_falla)) {
            echo "<script>alert('El campo Descripción de Falla debe comenzar con una letra mayúscula si se proporciona.'); window.location='../abrir/abrir.php';</script>";
            exit();
        }

        // Validar longitud máxima de los campos
        if (strlen($detalleubicacion) > 250) {
            echo "<script>alert('La longitud máxima para Detalles de Ubicación es de 250 caracteres.'); window.location='../abrir/abrir.php';</script>";
            exit();
        }

        if (strlen($descripcion_falla) > 250) {
            echo "<script>alert('La longitud máxima para Descripción de Falla es de 250 caracteres.'); window.location='../abrir/abrir.php';</script>";
            exit();
        }

        // Consulta para insertar datos en la tabla 'falla'
        $sql_falla = "INSERT INTO falla(id_falla, fecha_hora_reporte, metodo_reporte, servicio, sub_sistema, equipo, ubicacion, detalle_ubicacion, descripcion_falla, prioridad, estado, justificacion, acompañamiento, fecha_hora_cierre, dias_falla) VALUES ('$idfalla', '$hora_fecha', '$metodo_reporte', '$servicio', '$sub_sistema', '$equipo', '$ubicacion', '$detalleubicacion', '$descripcion_falla', '$prioridad', '$estado', '$justificacion', '$acompañamiento', '$fecha_hora_cierre', '$diasfalla')";

        if (mysqli_query($mysqli, $sql_falla)) {  
            // Consulta para insertar datos en la tabla 'detalles_falla'
            $sql_detalles = "INSERT INTO detalles_falla(falla, recibida_ccf, reportada_por, responsable_area, reportada_a, tecnico, cerrada_por, cerrada_ccf) VALUES ('$idfalla', '$recibida_ccf', '$reportada_por', '$responsable', '$reportada_a', '$tecnico', '$cerrada_por', '$cerrada_ccf')";

            if (mysqli_query($mysqli, $sql_detalles)) {
                echo "<script>alert('Datos Ingresados Correctamente'); window.location='../inicio/inicio.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error al insertar los datos en detalles_falla: " . mysqli_error($mysqli) . "'); window.location='../abrir/abrir.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Error al insertar los datos en falla: " . mysqli_error($mysqli) . "'); window.location='../abrir/abrir.php';</script>";
            exit();
        }
    }
}
?>

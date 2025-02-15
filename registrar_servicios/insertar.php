<?php
 include ('../conexion/conexion_bd.php');

 if (isset($_POST['btnguardar'])) {

if (empty ($_POST['metodo_reporte']) or empty($_POST['recibida_ccf']) or empty($_POST['reportada_por']) or empty($_POST['servicio']) or empty($_POST['sub_sistema']) or empty($_POST['equipo']) or empty($_POST['ubicacion']) or empty($_POST['detalles_ubicacion']) or empty($_POST['descripcion_falla']) or empty($_POST['responsable']) or empty($_POST['prioridad']) or empty($_POST['estado']) or empty($_POST['reportada_a']) ) {
   echo "<script>alert('ALGUNOS CAMPOS ESTAN VACIOS');</script>";
   
 }
else{ 
    
 $idfalla=$_POST['id_falla'];
 $hora_fecha=$_POST['hora_fecha'];
 $metodo_reporte=$_POST['metodo_reporte'];
 $recibida_ccf=$_POST['recibida_ccf'];
 $reportada_por=$_POST['reportada_por'];
 $servicio=$_POST['servicio'];
 $sub_sistema=$_POST['sub_sistema'];
 $equipo=$_POST['equipo'];
 $ubicacion=$_POST['ubicacion'];
 $detalleubicacion=$_POST['detalles_ubicacion'];
 $descripcion_falla=$_POST['descripcion_falla'];
 $responsable=$_POST['responsable'];
 $prioridad=$_POST['prioridad'];
 $estado=$_POST['estado'];
 $reportada_a=$_POST['reportada_a'];
 $justificacion=$_POST['justificacion'];
 $tecnico=$_POST['tecnico'];
 $acompañamiento=$_POST['acompañamiento'];
 $cerrada_por=$_POST['cerrada_por'];
 $cerrada_ccf=$_POST['cerrada_ccf'];
 $fecha_hora_cierre=$_POST['fecha_hora_cierre'];
 $diasfalla=$_POST['dias_falla'];

 
 $sql_falla="INSERT INTO falla(id_falla,fecha_hora_reporte,metodo_reporte,servicio,sub_sistema,equipo,ubicacion,detalle_ubicacion,descripcion_falla,prioridad,estado,justificacion,acompañamiento,fecha_hora_cierre,dias_falla) VALUES ('$idfalla','$hora_fecha','$metodo_reporte','$servicio', '$sub_sistema', '$equipo', '$ubicacion','$detalleubicacion','$descripcion_falla','$prioridad','$estado','$justificacion','$acompañamiento','$fecha_hora_cierre','$diasfalla')";
if (mysqli_query($mysqli, $sql_falla)) { 
  

    $sql_detalles="INSERT INTO detalles_falla(falla,recibida_ccf,reportada_por,responsable_area,reportada_a,tecnico,cerrada_por,cerrada_ccf) VALUES ('$idfalla','$recibida_ccf', '$reportada_por','$responsable','$reportada_a','$tecnico','$cerrada_por', '$cerrada_ccf')";

         if (mysqli_query($mysqli, $sql_detalles)) {
        echo "<script>alert('Datos Ingresados Correctamente'); window.location='../inicio/inicio.php';</script>";
        exit();
        }
        else {
        echo "<script>alert('Error al insertar los datos en detalles_falla: " . mysqli_error($mysqli) . "');</script>";
        }
 
    }
        else {
             echo "<script>alert('Error al insertar los datos en falla: " . mysqli_error($mysqli) . "');</script>";
            }

}

 }
 

?>
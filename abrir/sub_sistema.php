<?php
/*este es un archivo de consulta, para la funcion del siclo anidado de selects entre servicio, sub_sistema */

require '../../conexion/conexion_bd.php';

$id_servicio = $mysqli->real_escape_string( $_POST['id_servicio']);

$sql = "SELECT * FROM sub_sistema WHERE id_servicio = $id_servicio ORDER BY nombre_subsistema ASC";
$resultado = $mysqli->query($sql);

$respuesta = "<option value=''>seleccionar</option>";

while($row = $resultado->fetch_assoc()){

    $respuesta .= "<option value='" .$row['id_subsistema'] . " '>" .$row['nombre_subsistema'] . "</option>";

}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>
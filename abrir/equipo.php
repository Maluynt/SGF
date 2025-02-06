<?php
/*este es un archivo de consulta, para la funcion del siclo anidado de selects entre sub_sistema y equipo */

require '../../conexion/conexion_bd.php';

$id_subsistema = $mysqli->real_escape_string( $_POST['id_subsistema']);

$sql = "SELECT * FROM equipo WHERE id_subsistema = $id_subsistema ORDER BY nombre_equipo ASC";
$resultado = $mysqli->query($sql);

$respuesta = "<option value=''>seleccionar</option>";

while($row = $resultado->fetch_assoc()){

    $respuesta .= "<option value=' " .$row['id_equipo'] . " '>" .$row['nombre_equipo'] . "</option>";

}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>
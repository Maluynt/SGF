<?php
/*conexion a la base de datos*/
$mysqli= new mysqli("localhost","root","ferchojavi","metro");/*direccion del servidor, nombre de usuario,clave,nombre de la base de datos*/
$mysqli->set_charset('utf8'); /*para que reconosca los caracteres especiales*/

if ($mysqli->connect_error) {
    echo "error en la conexion" . $mysqli->connect_error;
    exit;
}

?>
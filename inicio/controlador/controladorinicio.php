<?php
session_start();
include("../conexion_bd/conexion_bd.php");
include("../modelo/ModeloUsuario.php");

class ControladorInicio {
    public function index() {
        if (empty($_SESSION["id_usuario"])) {
            header("Location:vista/vista_inicio.php");
            exit();
      }

        include("vista/vista_inicio.php");
   }
}

$controlador = new ControladorInicio();
$controlador->index();
?>

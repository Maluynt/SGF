<?php
session_start();
include("../conexion_bd/conexion_bd.php");
include("ModeloUsuario.php");

class ControladorInicio {
    public function index() {
        if (empty($_SESSION["id_usuario"])) {
            header("Location:../inicio/vista_inicio.php");
            exit();
      }

        include("vista_inicio.php");
   }
}

$controlador = new ControladorInicio();
$controlador->index();
?>

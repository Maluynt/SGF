<?php
session_start();
include("../conexion/conexion_bd.php");
include("ModeloUsuario.php");

class ControladorInicio {
    public function index() {
        if (empty($_SESSION["id_usuario"])) {
            header("Location:../abrir/vista_inicio.php");
            exit();
      }

       // Obtiene la información del usuario
       $informacionUsuario = ModeloUsuario::obtenerInformacionUsuario();

       
        include("vista_inicio.php");
   }
}

$controlador = new ControladorInicio();
$controlador->index();
?>

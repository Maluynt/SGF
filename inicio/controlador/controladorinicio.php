<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/../../conexion_bd/conexion_bd.php");
require_once __DIR__ . '/../modelo/modelousuario.php';

class ControladorInicio {
    public function index() {
        if (!$this->isUserLoggedIn()) {
            $this->redirectToLogin();
        }
        $this->loadView();
    }

    private function isUserLoggedIn() {
        return !empty($_SESSION["id_usuario"]);
    }

    private function redirectToLogin() {
        header("Location: /metro/SGF/login/index.php"); // Ruta absoluta recomendada
        exit();
    }

    private function loadView() {
        require __DIR__ . '/../vista/vista_inicio.php';
    }
}

$controlador = new ControladorInicio();
$controlador->index();
?>
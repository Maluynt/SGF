<?php
include "../../conexion/conexion_bd.php";
include "../modelo/Modelo.php";

class AjaxControlador {
    private $modelo;

    public function __construct($pdo) {
        $this->modelo = new Modelo($pdo);
    }

    public function obtenerAmbientes() {
        if (isset ($_POST['id_ubicacion'])) {
            $ambientes = $this->modelo->obtenerAmbientes($_POST['id_ubicacion']);
            echo json_encode($ambientes);
        }
    }

    public function obtenerSubSistemas() {
        if (isset($_POST['id_ambiente']) && isset($_POST['id_servicio'])) {
            $sub_sistemas = $this->modelo->obtenerSubSistemas($_POST['id_ambiente'], $_POST['id_servicio']);
            echo json_encode($sub_sistemas);
        }
    }

    public function obtenerEquipos() {
        if (isset($_POST['id_subsistema'])) {
            $equipos = $this->modelo->obtenerEquipos($_POST['id_subsistema']);
            echo json_encode($equipos);
        }
    }
}

// Llama a las funciones según la acción deseada
$ajaxControlador = new AjaxControlador($pdo);
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'obtenerAmbientes':
            $ajaxControlador->obtenerAmbientes();
            break;
        case 'obtenerSubSistemas':
            $ajaxControlador->obtenerSubSistemas();
            break;
        case 'obtenerEquipos':
            $ajaxControlador->obtenerEquipos();
            break;
    }
}
?>

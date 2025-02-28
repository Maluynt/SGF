<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión primero
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/modelo/modelo_consulta.php';

class FallaControl {
    private $model;

    public function __construct($pdo) {
        try {
            $this->model = new FallaModel($pdo);
        } catch(Exception $e) {
            error_log("Error al crear modelo: " . $e->getMessage());
            die("Error interno. Contacte al administrador.");
        }
    }

    public function mostrarFallas() {
        try {
            $fallas = $this->model->obtenerFallas();
            $error = null;
        } catch(Exception $e) {
            error_log("Error al obtener fallas: " . $e->getMessage());
            $fallas = [];
            $error = "Error al cargar datos.";
        }

        // Incluir la vista
        require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/vista/vista_consulta.php';
    }
}

try {
    if (!isset($pdo)) {
        throw new Exception("No se pudo establecer conexión.");
    }
    $controlador = new FallaControl($pdo);
    $controlador->mostrarFallas();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

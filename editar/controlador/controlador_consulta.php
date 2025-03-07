<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        $fallas = [];
        $error = null;
    
        try {
            // Obtener datos generales
            $fallasGenerales = $this->model->obtenerFallasCompletas();
            
            // Obtener datos con relaciones
         
            
            // Combinar resultados (alternativa: usar solo uno)
            $fallas = array_merge($fallasGenerales);
    
            // Si prefieres mostrar ambos por separado en la vista:
            // $mostrar = [
            //     'generales' => $fallasGenerales,
            //     'relaciones' => $fallasRelaciones
            // ];
    
        } catch(PDOException $e) {
            error_log("Error de base de datos: " . $e->getMessage());
            $error = "Error técnico al obtener datos";
        } catch(Exception $e) {
            error_log("Error general: " . $e->getMessage());
            $error = "Error al procesar la solicitud";
        }
    
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
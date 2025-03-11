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
            $this->mostrarError("Error interno. Contacte al administrador.");
        }
    }

    public function mostrarFallas() {
        try {
            $fallas = $this->model->obtenerFallasCompletas();
            
            // Verificar resultados
            if (empty($fallas)) {
                $_SESSION['info'] = "No hay fallas registradas actualmente";
            }
            
            // Configurar parámetros para la vista
            $this->cargarVista($fallas);

        } catch(PDOException $e) {
            error_log("Error de base de datos: " . $e->getMessage());
            $this->mostrarError("Error técnico al obtener datos. Código: DB-001");
        } catch(Exception $e) {
            error_log("Error general: " . $e->getMessage());
            $this->mostrarError($e->getMessage());
        }
    }

    private function cargarVista($fallas) {
        // Configurar campos y filtros
        $allowedFields = [
            'ID' => 'id_falla',
            'Descripción' => 'descripcion_falla',
            'Prioridad' => 'nombre_prioridad',
            'Estado' => 'nombre_estado',
            'Días Abierta' => 'dias_falla',  // Campo calculado
            // ... resto de campos
        ];

        $activeFilters = [
            'Equipo' => 'nombre_equipo',
            'Subsistema' => 'nombre_subsistema',
            // ... resto de filtros
        ];

        // Preparar filtros
        $filterOptions = [];
        foreach ($activeFilters as $displayName => $fieldName) {
            $filterOptions[$fieldName] = array_unique(array_column($fallas, $fieldName));
        }

        // Incluir vista con todos los parámetros necesarios
        require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/vista/vista_consulta.php';
    }

    private function mostrarError($mensaje) {
        $_SESSION['error'] = $mensaje;
        header("Location: /metro/SGF/consulta/vista/vista_consulta.php");
        exit();
    }
}

// Ejecución
try {
    $controlador = new FallaControl($pdo);
    $controlador->mostrarFallas();
} catch (Exception $e) {
    die("Error crítico: " . htmlspecialchars($e->getMessage()));
}
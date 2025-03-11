<?php
// Iniciar sesión al principio del script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/modelo/modelo_consulta.php';

class ControladorEditar {
    private $modelo;
    
    public function __construct($pdo) {
        $this->modelo = new FallaModel($pdo);
    }

    public function mostrarFormularioEdicion($id_falla) {
        try {
            if(!is_numeric($id_falla)) {
                throw new Exception("ID inválido");
            }
    
            $falla = $this->modelo->obtenerFallaPorId($id_falla);
            
            if(!$falla) {
                throw new Exception("Registro no encontrado");
            }
    
            $datos_vista = [
                'falla' => $falla,
                'opciones' => [
                    'prioridades' => $this->modelo->obtenerPrioridades(),
                    'estados' => $this->modelo->obtenerEstados(),
                    'acompañamientos' => $this->modelo->obtenerAcompañamiento()
                ]
            ];
    
            $this->cargarVista('editar_falla', $datos_vista);
    
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            header("Location: /metro/SGF/consulta/controlador/controlador_consulta.php");
            exit();
        }
    }
    
    private function cargarVista($nombreVista, $datos = []) {
        $rutaVista = $_SERVER['DOCUMENT_ROOT'] . "/metro/SGF/consulta/vista/{$nombreVista}.php";
        
        if(file_exists($rutaVista)) {
            $datos = array_map('htmlspecialchars', $datos);
            extract($datos);
            include $rutaVista;
        } else {
            throw new Exception("Vista {$nombreVista} no encontrada");
        }
    }
    
    public function actualizarFalla($datos) {
        try {
            $this->modelo->actualizarFalla($datos);
            $_SESSION['exito'] = "Actualización exitosa";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['datos_formulario'] = $datos;
        }
        header("Location: /metro/SGF/consulta/controlador/controlador_consulta.php");
        exit();
    }

    public function manejarRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['incrementar_intervencion'])) {
                $this->manejarIncrementoIntervencion();
            } else {
                $this->actualizarFalla($_POST);
            }
        } elseif (isset($_GET['id'])) {
            $this->mostrarFormularioEdicion($_GET['id']);
        } else {
            $_SESSION['error'] = "Acceso inválido";
            header("Location: /metro/SGF/consulta/controlador/controlador_consulta.php");
            exit();
        }
    }

    private function manejarIncrementoIntervencion() {
        try {
            $id_falla = (int)$_POST['id_falla'];
            if ($this->modelo->incrementarIntervencion($id_falla)) {
                $_SESSION['exito'] = "¡Intervención incrementada!";
            } else {
                $_SESSION['error'] = "Error al incrementar intervención";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

// Uso del controlador
try {
    $controlador = new ControladorEditar($pdo);
    $controlador->manejarRequest();
} catch (Exception $e) {
    error_log("Error general: " . $e->getMessage());
    $_SESSION['error'] = "Error inesperado del sistema";
    header("Location: /metro/SGF/consulta/controlador/controlador_consulta.php");
    exit();
}
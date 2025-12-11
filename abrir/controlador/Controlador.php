<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/abrir/modelo/Modelo.php';

class FallaController {
    private $modelo;
    private $id_servicio;

    public function __construct($pdo) {
        $this->modelo = new Modelo($pdo);
        $this->id_servicio = $_SESSION['id_servicio'] ?? null;
    }

    public function handleRequest() {
        try {
            // Verificaciones de seguridad primero
            verificarAutenticacion();
            verificarPermisos(['ADMINISTRADOR', 'Controlador', 'Inspector']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->procesarFormulario();
            }
            
            $this->mostrarVista();
            
        } catch (Exception $e) {
            error_log("Error crítico: " . $e->getMessage());
            $this->manejarError("Ocurrió un error inesperado. Por favor intente más tarde.");
        }
    }

    private function procesarFormulario() {
        try {
            if (!isset($_POST['btnguardar'])) return;
            
            validarTokenCSRF($_POST['csrf_token'] ?? '');
            
            $errores = $this->validarCampos($_POST);
            if (!empty($errores)) {
                throw new Exception(implode('<br>', $errores));
            }
            
            $datos = $this->sanitizarDatos($_POST);
            $this->guardarFalla($datos);
            
            $_SESSION['exito'] = "Falla registrada exitosamente!";
            $this->redirigir();
            
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['datos_formulario'] = $_POST;
            $this->redirigir();
        }
    }

    private function validarCampos($post) {
        $camposRequeridos = [
            'hora_fecha', 'recibida_ccf', 'reportada_por',
            'responsable_area', 'metodo_reporte', 'ambiente',
            'equipo', 'prioridad', 'estado', 'descripcion_falla'
        ];
        
        $errores = [];
        foreach ($camposRequeridos as $campo) {
            if (empty($post[$campo])) {
                $errores[] = "El campo " . ucfirst(str_replace('_', ' ', $campo)) . " es requerido.";
            }
        }
        
        if (!empty($post['descripcion_falla'])) {
            $descripcion = trim($post['descripcion_falla']);
            if (strlen($descripcion) < 2) {
                $errores[] = "La descripción debe tener al menos 2 caracteres.";
            }
            if (!ctype_upper($descripcion[0])) {
                $errores[] = "La descripción debe comenzar con mayúscula.";
            }
        }
        
        return $errores;
    }

    private function sanitizarDatos($post) {
        return [
            'fecha_hora' => date('Y-m-d H:i:s', strtotime($post['hora_fecha'])),
            'recibida_ccf' => (int)$post['recibida_ccf'],
            'reportada_por' => (int)$post['reportada_por'],
            'responsable_area' => (int)$post['responsable_area'],
            'metodo_reporte' => (int)$post['metodo_reporte'],
            'ambiente' => (int)$post['ambiente'],
            'equipo' => (int)$post['equipo'],
            'prioridad' => (int)$post['prioridad'],
            'estado' => (int)$post['estado'],
            'descripcion_falla' => htmlspecialchars($post['descripcion_falla'], ENT_QUOTES, 'UTF-8')
        ];
    }

    private function guardarFalla($datos) {
        try {
            $this->modelo->beginTransaction();
            
            $id_falla = $this->modelo->generarIdFalla();
            
            // Insertar falla principal
            $this->modelo->insertarFalla(
                $id_falla,
                $datos['prioridad'],
                $datos['estado'],
                $datos['equipo'],
                $datos['recibida_ccf'],
                $datos['fecha_hora'],
                $datos['ambiente'],
                $datos['descripcion_falla'],
                $datos['metodo_reporte']
            );
            
            // Insertar relaciones
            $this->modelo->insertar_reportada_por(
                $id_falla,
                $datos['reportada_por'],
                $datos['fecha_hora']
            );
            
            $this->modelo->insertar_responsable_area(
                $id_falla,
                $datos['responsable_area'],
                $datos['fecha_hora']
            );
            
            $this->modelo->commit();
            
        } catch (Exception $e) {
            $this->modelo->rollBack();
            throw new Exception("Error al guardar en la base de datos: " . $e->getMessage());
        }
    }
    private function obtenerInfoUsuario() {
        return [
            'nombre' => $_SESSION['nombre_personal'] ?? 'Usuario no identificado',
            'perfil' => $_SESSION['nombre_perfil'] ?? 'Sin perfil',
            'usuario' => $_SESSION['usuario'] ?? 'N/A',
            'id_usuario' => $_SESSION['id_usuario'] ?? 0,
            'carnet' => $_SESSION['carnet'] ?? 'N/A',
            'servicio' => $_SESSION['nombre_servicio'] ?? 'No asignado',
            'id_servicio' => $_SESSION['id_servicio'] ?? 0
        ];
        
    }
private function mostrarVista() {
    // Generar ID de falla para mostrar en el formulario
    $id_falla = $this->modelo->generarIdFalla();

    $datosVista = [
        'id_falla' => $id_falla,
        'reportada_por' => $this->modelo->obtenerPersonal(),
        'metodo_reporte' => $this->modelo->obtenerMetodoReporte(),
        'ubicacion' => $this->modelo->obtenerUbicacion(),
        'responsable_area' => $this->modelo->obtenerResponsableArea(),
        'prioridad' => $this->modelo->obtenerPrioridad(),
        'servicio' => $this->modelo->obtenerServicio($this->id_servicio) ?: [],
        'informacionUsuario' => $this->obtenerInfoUsuario(),
        'datosFormulario' => $_SESSION['datos_formulario'] ?? []
    ];
    $esVistaSegura = true;
    unset($_SESSION['datos_formulario']);
    extract($datosVista);
    
    // Usar constante para seguridad
    define('VISTA_SEGURA', true);
    include $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/abrir/vista/abrir_falla.php';
}
   

    private function redirigir() {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    private function manejarError($mensaje) {
        $_SESSION['error'] = $mensaje;
        $this->redirigir();
    }
}

// Ejecución del controlador
try {
    $controller = new FallaController($pdo);
    $controller->handleRequest();
} catch (Exception $e) {
    error_log("Error inicial: " . $e->getMessage());
    die("Error crítico. Por favor contacte al administrador.");
}
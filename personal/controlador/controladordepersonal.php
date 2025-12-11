<?php
// Configuración inicial y seguridad
error_reporting(E_ALL);
ini_set('display_errors', 1);



// Verificar autenticación primero
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
verificarAutenticacion();

// Incluir modelo
include(__DIR__ . '/../modelo/Modelodepersonal.php');

class ControladorPersonal {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new PersonalModelo();
    }

    public function manejarSolicitud() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
                $this->procesarRegistro();
            }
            
            $this->mostrarVista();
        } catch (Exception $e) {
            error_log('Error fatal: ' . $e->getMessage());
            $_SESSION['error'] = 'Error crítico en el sistema';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    private function procesarRegistro() {
        try {
            $this->validarCampos();
            $this->modelo->registrar($_POST);
            $_SESSION['exito'] = "Personal registrado exitosamente!";
        } catch (PDOException $e) {
            $_SESSION['error'] = $this->traducirErrorBD($e);
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    private function validarCampos() {
        $camposRequeridos = ['N-Carnet', 'nombre_apellido', 'contacto'];
        
        foreach ($camposRequeridos as $campo) {
            if (empty($_POST[$campo])) {
                throw new Exception("El campo $campo es obligatorio");
            }
        }

        // Validar formato del carnet
        if (!preg_match('/^[A-Z0-9]{6,10}$/', $_POST['N-Carnet'])) {
            throw new Exception("Formato de carnet inválido (Ej: ABC123)");
        }

        // Validar formato del nombre
        if (!preg_match('/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ\s]{2,}$/u', $_POST['nombre_apellido'])) {
            throw new Exception("El nombre debe comenzar con mayúscula y tener mínimo 3 caracteres");
        }
    }

    private function traducirErrorBD(PDOException $e) {
        error_log('Error BD: ' . $e->getMessage());
        return match ($e->getCode()) {
            '23000' => 'El personal ya existe en el sistema',
            '22001' => 'Datos demasiado largos para algún campo',
            default => 'Error en la base de datos'
        };
    }

    private function mostrarVista() {
        // Obtener mensajes de sesión
        $exito = $_SESSION['exito'] ?? null;
        $error = $_SESSION['error'] ?? null;
        
        // Limpiar mensajes después de obtenerlos
        unset($_SESSION['exito'], $_SESSION['error']);

        // Bufferizar salida
        ob_start();
        $esVistaSegura = true;
        include __DIR__ . '/../vista/personal.php';
        $contenido = ob_get_clean();
        
        // Incluir layout principal
        if (file_exists(__DIR__ . '/../vista/layout.php')) {
            include __DIR__ . '/../vista/layout.php';
        } else {
            echo $contenido;
        }
    }
}

// Ejecutar aplicación
try {
    $controlador = new ControladorPersonal();
    $controlador->manejarSolicitud();
} catch (Throwable $e) {
    error_log('Error crítico: ' . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    exit('Ocurrió un error inesperado. Por favor intente más tarde.');
}
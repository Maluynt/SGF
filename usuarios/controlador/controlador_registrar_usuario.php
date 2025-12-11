<?php
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/usuarios/modelo/modelo_usuario.php';

class ControladorUsuario {
    private $modelo;
    private $pdo;
     private const PERFILES_PERMITIDOS = ['ADMINISTRADOR', 'Inspector', 'Controlador']; // Perfiles autorizados

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->modelo = new Usuarios($this->pdo);
        
        // Verificar permisos al instanciar el controlador
        $this->validarPermisos();
        
        if (!$this->pdo) {
            throw new Exception("Error de conexión a la base de datos");
        }
    }

    private function validarPermisos(): void {
        verificarAutenticacion();
        
        if (!isset($_SESSION['nombre_perfil']) || 
            !in_array($_SESSION['nombre_perfil'], self::PERFILES_PERMITIDOS, true)) {
            
            error_log("Intento de acceso no autorizado. Usuario: {$_SESSION['id_usuario']}, Perfil: {$_SESSION['nombre_perfil']}");
            throw new Exception("Acceso reservado a administradores");
        }
    }
    public function manejarSolicitud(): void {
        try {
            // Verificar autenticación
            verificarAutenticacion();

            // Manejar acciones GET o POST
            if (isset($_GET['action'])) {
                $this->manejarAcciones();
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->procesarRegistro();
            }

            // Mostrar la vista por defecto
            $this->mostrarVista();

        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->manejarError($e->getMessage());
        }
    }

    private function mostrarVista(): void {
        // Variables para la vista
        $variables = [
            'perfiles' => $this->modelo->obtenerPerfiles(),
            'servicios' => $this->modelo->obtenerServicios(),
            'formData' => $_SESSION['form_data'] ?? [],
            'mensaje' => $_SESSION['mensaje'] ?? null,
            'mensaje_tipo' => $_SESSION['mensaje_tipo'] ?? null,
            'esVistaSegura' => true,
            'cargarBuscadorJS' => true,
        ];

        // Verificar si los headers ya fueron enviados
        if (headers_sent()) {
            throw new Exception("Headers ya enviados, no se puede mostrar vista");
        }
  
          $esVistaSegura = true; 
        $rutaVista = $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/usuarios/vista/registrar_usuario.php';
        if (!file_exists($rutaVista)) {
            throw new Exception("Vista no encontrada: $rutaVista");
        }

        // Incluir la vista
        include $rutaVista;
    }

    private function procesarRegistro(): void {
        try {
            // Validar campos del formulario
            $this->validarCampos();
            
            // Preparar datos del usuario
            $usuario = [
                'id_perfil' => (int)$_POST['id_perfil'],
                'id_personal' => (int)$_POST['id_personal'],
                'id_servicio' => (int)$_POST['id_servicio'],
                'usuario' => trim($_POST['usuario']),
                'contrasena' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'pregunta_secreta' => trim($_POST['pregunta']),
                'respuesta_secreta' => trim($_POST['respuesta'])
            ];
            
            // Validar formato del nombre de usuario
            if (!preg_match('/^[a-zA-Z0-9\-]+$/', $usuario['usuario'])) {
                throw new Exception('Solo se permiten letras, números y guiones en el nombre de usuario');
            }
            
            // Registrar el usuario
            if ($this->modelo->registrar($usuario)) {
                $_SESSION['mensaje'] = 'Usuario registrado correctamente';
                $_SESSION['mensaje_tipo'] = 'success';
            }
            
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            $mensaje = $this->traducirErrorBD($e->getCode());
            $_SESSION['mensaje'] = $mensaje;
            $_SESSION['mensaje_tipo'] = 'danger';
            $_SESSION['form_data'] = $_POST;
        } catch (Exception $e) {
            // Manejar otros errores
            $_SESSION['mensaje'] = $e->getMessage();
            $_SESSION['mensaje_tipo'] = 'danger';
            $_SESSION['form_data'] = $_POST;
        }

        // Redirigir para evitar reenvío del formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    private function validarCampos(): void {
        // Campos requeridos
        $camposRequeridos = [
            'id_perfil' => 'Perfil',
            'id_personal' => 'Personal',
            'id_servicio' => 'Servicio',
            'usuario' => 'Usuario',
            'password' => 'Contraseña',
            'pregunta' => 'Pregunta secreta',
            'respuesta' => 'Respuesta secreta'
        ];

        // Verificar que todos los campos estén presentes
        foreach ($camposRequeridos as $campo => $nombre) {
            if (empty($_POST[$campo])) {
                throw new Exception("El campo $nombre es obligatorio");
            }
        }

        // Verificar si el personal ya tiene un usuario registrado
        if ($this->modelo->existeUsuario($_POST['id_personal'])) {
            throw new Exception('Este personal ya tiene un usuario registrado');
        }
    }

    private function traducirErrorBD(int $codigo): string {
        // Traducir códigos de error de la base de datos
        return match ($codigo) {
            23000 => 'El usuario ya existe en el sistema',
            22001 => 'Datos demasiado largos para algún campo',
            default => 'Error en la base de datos'
        };
    }

    private function manejarAcciones(): void {
        // Manejar acciones específicas (por ejemplo, búsqueda de personal)
        if ($_GET['action'] === 'buscar_personal') {
            $this->buscarPersonal();
        }
    }

    private function buscarPersonal(): void {
        try {
            // Validar término de búsqueda
            if (empty($_GET['query'])) {
                throw new Exception('Ingrese un término de búsqueda');
            }

            // Buscar personal
            $resultados = $this->modelo->buscarPersonal($_GET['query']);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $resultados]);
            exit();
        } catch (Exception $e) {
            // Manejar errores en la búsqueda
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit();
        }
    }

    private function manejarError(string $mensaje): void {
        // Manejar errores críticos
        error_log('Error en controlador: ' . $mensaje);
        $_SESSION['mensaje'] = 'Error crítico: ' . $mensaje;
        $_SESSION['mensaje_tipo'] = 'danger';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Ejecutar el controlador
try {
    (new ControladorUsuario())->manejarSolicitud();
} catch (Exception $e) {
    die("Error crítico: " . $e->getMessage());
}
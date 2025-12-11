<?php
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/modelo/modelo_consulta.php';


class ControladorEditar {
    private $modelo;
    private const ESTADOS_REQUIEREN_JUSTIFICACION = ['Cerrada', 'Anulada', 'En espera'];
    private const PERFILES_PERMITIDOS = ['ADMINISTRADOR', 'Inspector', 'Controlador'];

    public function __construct(PDO $pdo) {
        verificarAutenticacion();
        $this->validarPermisos();

        $this->modelo = new FallaModel($pdo);
        $this->generarTokenCSRF();
    }

    public function manejarRequest(): void {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->validarTokenCSRF();
                $this->manejarPost();
            } elseif (isset($_GET['id'])) {
                $this->mostrarFormularioEdicion((int)$_GET['id']);
            } else {
                throw new Exception("Parámetros inválidos");
            }
        } catch (Exception $e) {
            $this->manejarError($e);
        }
    }

    private function validarPermisos(): void {
        if (!in_array($_SESSION['nombre_perfil'], self::PERFILES_PERMITIDOS, true)) {
            error_log("Intento de acceso no autorizado. Usuario: {$_SESSION['id_usuario']}, Perfil: {$_SESSION['nombre_perfil']}");
            throw new Exception("Acceso reservado a personal autorizado");
        }
    }

    private function manejarPost(): void {
        if (isset($_POST['incrementar_intervencion'])) {
            $this->incrementarIntervencion();
        } else {
            $this->procesarActualizacion();
        }
    }
    

    private function redirigirSegunPerfil(): void {
        $perfil = $_SESSION['nombre_perfil'] ?? 'Invitado';
        
        $rutas = [
            'Administrador' => '/metro/SGF/consulta/controlador/controlador_consulta.php',
            'Inspector' => '/metro/SGF/consulta/controlador/controlador_consulta.php',
            'Controlador' => '/metro/SGF/consulta/controlador/controlador_consulta.php',
            'default' => '/metro/SGF/login/index.php'
        ];

        $ruta = $rutas[$perfil] ?? $rutas['default'];
        header("Location: $ruta");
        exit;
    }

    private function procesarActualizacion(): void {
        $datos = [
            'id_falla' => $this->validarId($_POST['id_falla'] ?? ''),
            'prioridad' => $this->validarPrioridad($_POST['prioridad'] ?? ''),
            'estado' => $this->validarEstado($_POST['estado'] ?? ''),
            'solucion' => $this->sanitizarTexto($_POST['solucion'] ?? ''),
            'id_acompanamiento' => $this->validarAcompañamiento($_POST['id_acompañamiento'] ?? ''),
            'justificacion' => $this->validarJustificacion(
                $_POST['estado'] ?? '',
                $_POST['justificacion'] ?? ''
            )
        ];

        $this->modelo->actualizarFalla($datos);
        $_SESSION['exito'] = "Falla #{$datos['id_falla']} actualizada correctamente";
        $this->redirigirConsulta();
    }

    private function validarId(string $id): int {
        if (!ctype_digit($id) || $id <= 0) {
            throw new Exception("ID de falla inválido");
        }
        return (int)$id;
    }

    private function validarEstado(string $idEstado): int {
        $estados = array_column($this->modelo->obtenerEstados(), 'id_estado');
        $idEstadoInt = (int)$idEstado; // Conversión explícita
        
        if (!in_array($idEstadoInt, $estados, true)) { // Comparación estricta
            throw new Exception("Estado no válido");
        }
        return $idEstadoInt;
    }

    private function validarPrioridad(string $idPrioridad): int {
        $prioridades = array_column($this->modelo->obtenerPrioridades(), 'id_prioridad');
        if (!in_array((int)$idPrioridad, $prioridades, true)) {
            throw new Exception("Prioridad no válida");
        }
        return (int)$idPrioridad;
    }

    private function validarAcompañamiento(?string $id): int {
        if ($id === null || $id === '') return 0;
        $acompañamientos = array_column($this->modelo->obtenerAcompañamiento(), 'id_acompañamiento');
        if (!in_array((int)$id, $acompañamientos, true)) {
            throw new Exception("Acompañamiento no válido");
        }
        return (int)$id;
    }

    private function validarJustificacion(?string $idEstado, string $justificacion): string {
        if (empty($idEstado)) return '';
        
        $idEstadoInt = (int)$idEstado;
        $estados = array_column($this->modelo->obtenerEstados(), 'estado', 'id_estado');
        $nombreEstado = $estados[$idEstadoInt] ?? '';
        
        if (in_array($nombreEstado, self::ESTADOS_REQUIEREN_JUSTIFICACION, true)) {
            $justificacion = trim($justificacion);
            if (mb_strlen($justificacion) < 20) {
                throw new Exception("Justificación requerida (20+ caracteres) para: $nombreEstado");
            }
        }
        return $justificacion;
    }

    private function sanitizarTexto(string $texto): string {
        return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
    }
    
    private function mostrarFormularioEdicion(int $id): void {
        try {
            $idValidado = $this->validarId((string)$id);
            $falla = $this->modelo->obtenerFallaPorId($idValidado);
            
            if (!$falla) {
                throw new Exception("Registro no encontrado");
            }
    
            $this->cargarVista('editar_falla', [
                'falla' => $falla,
                'prioridades' => $this->modelo->obtenerPrioridades(),
                'estados' => $this->modelo->obtenerEstados(),
                'acompañamientos' => $this->modelo->obtenerAcompañamiento(),
                'csrf_token' => $_SESSION['csrf_token'],
                'esVistaSegura' => true // Variable crítica para seguridad
            ]);
            
        } catch (Exception $e) {
            $this->manejarError($e);
        }
    }

    private function cargarVista(string $vista, array $datos): void {
        $ruta = $_SERVER['DOCUMENT_ROOT'] . "/metro/SGF/estadistica/vista/{$vista}.php";
        
        if (!file_exists($ruta)) {
            throw new Exception("Vista no encontrada: " . basename($ruta));
        }

        // Sanitización que preserva tipos de datos
        $sanitizar = function($item) use (&$sanitizar) {
            if (is_array($item)) {
                return array_map($sanitizar, $item);
            }
            return is_string($item) ? htmlspecialchars($item, ENT_QUOTES, 'UTF-8') : $item;
        };

        extract(array_map($sanitizar, $datos));
        
        include $ruta;
        exit;
    }
    private function incrementarIntervencion(): void {
        $id = $this->validarId($_POST['id_falla'] ?? '');
        
        if (!$this->modelo->incrementarIntervencion($id)) {
            throw new Exception("Error al actualizar intervención");
        }
        
        session_regenerate_id(true);
        
        // Redirigir al controlador en lugar de a la vista directamente
        header("Location: /metro/SGF/estadistica/controlador/controlador_editar.php?id=" . $id . "&actualizado=1");
        exit;
    }
    private function generarTokenCSRF(): void {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    private function validarTokenCSRF(): void {
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            throw new Exception("Token CSRF inválido");
        }
    }

    private function redirigirConsulta(): void {
        header("Location: /metro/SGF/estadistica/controlador/controlador_consulta.php");
        exit;
    }
   
    // Manejo de errores corregido
private function manejarError(Exception $e): void {
    error_log("Error en ControladorEditar: " . $e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
    $this->redirigirSegunPerfil();
}

// Obtención segura del nombre del estado

}

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $controlador = new ControladorEditar($pdo);
    $controlador->manejarRequest();
} catch (Throwable $e) {
    error_log("Error crítico: " . $e->getMessage());
    header("Location: /metro/SGF/estadistica/controlador/controlador_consulta.php?error=" . urlencode($e->getMessage()));
    exit;
}
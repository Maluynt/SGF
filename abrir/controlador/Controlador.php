
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/controlador_usuario.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/abrir/modelo/Modelo.php'; 

$informacionUsuario = [
    'servicio' => $_SESSION['nombre_servicio'] ?? 'No asignado',
    'id_servicio' => $_SESSION['id_servicio'] ?? ''
];
$informacionUsuario = [
    'nombre' => $datosUsuario->nombre_personal, // Asegúrate que esta propiedad existe
    'perfil' => $datosUsuario->nombre_perfil,
    'usuario' => $datosUsuario->usuario,
    'id_usuario' => $datosUsuario->id_usuario,
    'carnet' => $datosUsuario->carnet,
    'servicio' => $datosUsuario->nombre_servicio
   
];
class Controlador {
    private $modelo;

    public function __construct($pdo) {
        $this->modelo = new Modelo($pdo);
     
    }

    public function obtenerDatosFormulario() {
        // Obtener el id_servicio de la sesión
        $id_servicio = $_SESSION['id_servicio'] ?? null;
    
        return [
            'reportada_por' => $this->modelo->obtenerPersonal(),
            'metodo_reporte' => $this->modelo->obtenerMetodoReporte(),
            'ubicacion' => $this->modelo->obtenerUbicacion(),
            'responsable_area' => $this->modelo->obtenerResponsableArea(),
            'prioridad' => $this->modelo->obtenerPrioridad(),
            'id_falla' => $this->modelo->generarIdFalla(),
            'servicio' => $this->modelo->obtenerServicio($id_servicio) ?: [],
        ];
    }

    // Método para guardar los datos del formulario
    public function guardarDatos() {
        if (isset($_POST['btnguardar'])) {
            // Recoger los datos del formulario
            error_log("ID Recibida CCF: " . $_POST['recibida_ccf']);
            $id_falla = $_POST['id_falla'];
            $fecha_hora = $_POST['hora_fecha'];
            $recibida_ccf = $_POST['recibida_ccf'];
            $reportada_por = $_POST['reportada_por'];
            $responsable_area = $_POST['responsable_area'];
            $metodo_reporte = $_POST['metodo_reporte'];
            $ambiente = $_POST['ambiente'];
            $equipo = $_POST['equipo'];
            $prioridad = $_POST['prioridad'];
            $estado = $_POST['estado'];
            $descripcion_falla = $_POST['descripcion_falla'];

            // Validaciones
            $errores = [];
            
            // Validar que la descripción empiece con mayúscula
            if (strlen($descripcion_falla) < 2) {
                $errores[] = "La descripción de la falla debe tener un mínimo de 2 caracteres.";
            } elseif (!ctype_upper($descripcion_falla[0])) {
                $errores[] = "La descripción de la falla debe iniciar con letra mayúscula.";
            }

            // Si hay errores, mostrar mensajes
            if (!empty($errores)) {
                foreach ($errores as $error) {
                    echo "<script>alert('$error');</script>";
                }
            } else {
                // Intentar insertar en la tabla falla
                try {
                    $this->modelo->insertarFalla($id_falla, $prioridad, $estado, $equipo, $recibida_ccf, $fecha_hora,$ambiente, $descripcion_falla, $metodo_reporte);

                    // Insertar en detalles_falla
                    $this->modelo->insertar_reportada_por($id_falla, $reportada_por, $fecha_hora);
                    $this->modelo->insertar_responsable_area($id_falla, $responsable_area, $fecha_hora);

                    // Mensaje de éxito
                    echo "<script>alert('Datos registrados exitosamente.');</script>";
                } catch (Exception $e) {
                    // Mensaje de error
                    echo "<script>alert('Error al registrar los datos: " . $e->getMessage() . "');</script>";
                }
            }
            
           
        }
         // Redirigir a vista_abrir.php
        
    }
 
}
// Asegúrate de salir después de la redirección

// Instancia del controlador
$controlador = new Controlador($pdo);
$datos = $controlador->obtenerDatosFormulario();
$controlador->guardarDatos(); // Llama al método para guardar datos
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/abrir/vista/abrir_falla.php'; 
exit(); 
?>




<?php

session_start(); // Inicia la sesión
include("../conexion/conexion_bd.php"); // Incluye la conexión a la base de datos
//include("ModeloUsuario.php"); // Incluye el modelo del usuario

class controladorinicio {
    // Método principal para mostrar la vista de apertura de falla
    public function index() {
        global $pdo; 
        // Verifica si el usuario está autenticado
        if (empty($_SESSION["id_usuario"])) {
            // Redirige a la página de inicio si no está autenticado
            header("Location:vista_inicio.php");
            exit();
        }

        // Obtiene la información del usuario
        //$informacionUsuario = ModeloUsuario::obtenerInformacionUsuario();

        // Incluye la vista de apertura de falla
        include("vista_inicio.php");
    }

    // Método para insertar una nueva falla
    public function insertarFalla($datos) {
        global $pdo; // Usar la conexión PDO global
        $sql = "INSERT INTO falla (id_falla, hora_fecha, fecha_hora_cierre, dias_falla, metodo_reporte, recibida_ccf, reportada_por, servicio, sub_sistema) 
                VALUES (:id_falla, :hora_fecha, :fecha_hora_cierre, :dias_falla, :metodo_reporte, :recibida_ccf, :reportada_por, :servicio, :sub_sistema)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_falla' => $datos['id_falla'],
            ':hora_fecha' => $datos['hora_fecha'],
            ':fecha_hora_cierre' => $datos['fecha_hora_cierre'],
            ':dias_falla' => $datos['dias_falla'],
            ':metodo_reporte' => $datos['metodo_reporte'],
            ':recibida_ccf' => $datos['recibida_ccf'],
            ':reportada_por' => $datos['reportada_por'],
            ':servicio' => $datos['servicio'],
            ':sub_sistema' => $datos['sub_sistema']
        ]);
    }
}

// Crea una instancia del controlador y llama al método index
$controlador = new Controladorinicio();
$controlador->index();

// Si se envía el formulario, insertar la nueva falla
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnguardar'])) {
    $controlador->insertarFalla($_POST);
}
?>

<?php
// Definición de la clase Usuario
class Usuario {
    // Variable privada para almacenar la conexión a la base de datos
    private $conexion;

    // Constructor de la clase Usuario
    public function __construct($conexion) {
        // Inicializa la variable de conexión con la conexión proporcionada
        $this->conexion = $conexion;
    }

// En el método verificarCredenciales, modificar la consulta:
    public function verificarCredenciales($usuario, $password) {
        // Incluir id_servicio en la selección
        $stmt = $this->conexion->prepare("SELECT id_usuario, id_perfil, contrasena, id_servicio FROM usuario WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $datos = $stmt->fetch(PDO::FETCH_OBJ);
    
        if ($datos && password_verify($password, $datos->contrasena)) {
            return $datos; // Ahora incluye id_servicio
        }
        return null;
    }

    public function obtenerInformacionUsuario($id_usuario)
    {
        $stmt = $this->conexion->prepare("
            SELECT u.id_usuario, u.usuario, u.id_perfil, u.id_servicio, p.nombre_personal, p.carnet 
            FROM usuario u
            INNER JOIN personal p ON u.id_personal = p.id_personal
            WHERE u.id_usuario = :id_usuario
        ");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    // Método para registrar la acción de inicio de sesión en la tabla de bitácora
    public function registrarLogin($nombre_personal, $accion) {
        // Obtiene la fecha y hora actual
        $fecha_hora = date('Y-m-d H:i:s');
        // Consulta SQL para insertar el registro en la bitácora
        $log_sql = "INSERT INTO bitacora (nombre_personal, fecha_hora, accion) VALUES (:nombre_personal, :fecha_hora, :accion)";

        // Prepara la consulta SQL
        $log_stmt = $this->conexion->prepare($log_sql);
        
        // Vincula los parámetros a la consulta preparada
        $log_stmt->bindParam(':nombre_personal', $nombre_personal);
        $log_stmt->bindParam(':fecha_hora', $fecha_hora);
        $log_stmt->bindParam(':accion', $accion);
        
        // Ejecuta la consulta preparada
        $log_stmt->execute();
    }
}
?>

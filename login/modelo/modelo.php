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

    // Método para verificar las credenciales del usuario
    public function verificarCredenciales($usuario, $password) {
        // Consulta preparada para obtener los datos del usuario
        $stmt = $this->conexion->prepare ("SELECT id_usuario, id_perfil, contrasena FROM usuario WHERE usuario = :usuario");
        // Vincula el parámetro de usuario a la consulta preparada
        $stmt->bindParam(':usuario', $usuario);
        // Ejecuta la consulta preparada
        $stmt->execute();
        // Obtiene el resultado de la consulta
        $datos = $stmt->fetch(PDO::FETCH_OBJ);

        // Verifica si se encontraron datos de usuario
        if ($datos) {
            // Verifica si la contraseña proporcionada coincide con la contraseña almacenada (hasheada)
            if (password_verify($password, $datos->contrasena)) {
                // Retorna los datos del usuario si las credenciales son válidas
                return $datos;
            }
        }
        // Retorna null si las credenciales son inválidas
        return null;
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

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
        $sql = $this->conexion->prepare("SELECT id_usuario, nombre_usuario, apellido_usuario, id_perfil, contrasena FROM usuario WHERE usuario = ?");
        // Vincula el parámetro de usuario a la consulta preparada
        $sql->bind_param("s", $usuario);
        // Ejecuta la consulta preparada
        $sql->execute();
        // Obtiene el resultado de la consulta
        $resultado = $sql->get_result();

        // Verifica si se encontraron datos de usuario
        if ($datos = $resultado->fetch_object()) {
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
    public function registrarLogin($nombre_personal, $apellido_personal, $accion) {
        // Obtiene la fecha y hora actual
        $fecha_hora = date('Y-m-d H:i:s');
        // Consulta SQL para insertar el registro en la bitácora
        $log_sql = "INSERT INTO bitacora (nombre_personal, apellido_personal, fecha_hora, accion) VALUES (?, ?, ?, ?)";

        // Prepara la consulta SQL
        if ($log_stmt = $this->conexion->prepare($log_sql)) {
            // Vincula los parámetros a la consulta preparada
            $log_stmt->bind_param("ssss", $nombre_personal, $apellido_personal, $fecha_hora, $accion);
            // Ejecuta la consulta preparada
            $log_stmt->execute();
            // Cierra la consulta preparada
            $log_stmt->close();
        } else {
            // Registra un error en el registro de errores del servidor si falla la preparación de la consulta
            error_log("Error en la preparación de la consulta de bitácora: " . $this->conexion->error);
        }
    }
}
?>
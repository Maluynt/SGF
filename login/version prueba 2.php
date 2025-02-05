modelo.php
<?php
class Usuario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function verificarCredenciales($usuario, $password) {
        // Consulta para obtener los datos del usuario
        $sql = $this->conexion->prepare("SELECT id_usuario, id_personal, nombre_usuario, apellido_usuario, usuario, perfil.id_perfil, perfil.Perfil AS perfil, contraseña FROM usuario INNER JOIN perfil ON usuario.id_perfil=perfil.id_perfil WHERE usuario = ?");
        $sql->bind_param("s", $usuario);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($datos = $resultado->fetch_object()) {
            if (password_verify($password, $datos->contraseña)) {
                return $datos; // Retorna los datos del usuario si las credenciales son válidas
            }
        }
        return null; // Retorna null si las credenciales son inválidas
    }

    public function registrarLogin($nombre_personal, $apellido_personal, $accion) {
        // Registrar acción de inicio de sesión en la tabla de bitácora
        $fecha_hora = date('Y-m-d H:i:s');
        $log_sql = "INSERT INTO bitacora (nombre_personal, apellido_personal, fecha_hora, accion) VALUES (?, ?, ?, ?)";

        if ($log_stmt = $this->conexion->prepare($log_sql)) {
            $log_stmt->bind_param("ssss", $nombre_personal, $apellido_personal, $fecha_hora, $accion);
            $log_stmt->execute();
            $log_stmt->close();
        } else {
            error_log("Error en la preparación de la consulta de bitácora: " . $this->conexion->error);
        }
    }

    public function actualizarIntentosFallidos($usuario, $intentos) {
        $stmt = $this->conexion->prepare("UPDATE usuario SET intentos = ?, ultimo_intento = NOW() WHERE usuario = ?");
        $stmt->bind_param("is", $intentos, $usuario);
        $stmt->execute();
    }
}
?>

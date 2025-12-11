<?php
class Usuario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    public function verificarCredenciales(string $usuario, string $password): ?object {
        try {
            $stmt = $this->conexion->prepare("
                SELECT 
                    u.id_usuario,
                    u.usuario,
                    u.contrasena,
                    p.perfil AS nombre_perfil,
                    s.id_servicio,
                    s.nombre_servicio,
                    perso.carnet AS carnet,
                    perso.nombre_personal
                FROM usuario u
                LEFT JOIN perfil p ON u.id_perfil = p.id_perfil
                LEFT JOIN servicio s ON u.id_servicio = s.id_servicio
                LEFT JOIN personal perso ON u.id_personal = perso.id_personal
                WHERE u.usuario = :usuario
            ");
    
            $stmt->execute([':usuario' => $usuario]);
            $datosUsuario = $stmt->fetch(PDO::FETCH_OBJ);
    
            // Depuración
            error_log("Consulta SQL: " . $stmt->queryString);
            error_log("Resultado de la consulta: " . print_r($datosUsuario, true));
    
            if (!$datosUsuario) {
                error_log("Usuario no encontrado: $usuario");
                return null;
            }
    
            error_log("Hash almacenado: " . $datosUsuario->contrasena);
            if (!password_verify($password, $datosUsuario->contrasena)) {
                error_log("Contraseña incorrecta para: $usuario");
                return null;
            }
    
            return $datosUsuario;
        } catch (PDOException $e) {
            error_log("Error en la base de datos: " . $e->getMessage());
            return null;
        }
    }

    public function registrarAccion($id_usuario, $nombre_personal, $accion, $id_detalles_falla = null) {
        $fecha_hora = date('Y-m-d H:i:s');
        
        // Validar y truncar datos si superan 50 caracteres
        $nombre_personal = substr($nombre_personal, 0, 50);
        $accion = substr($accion, 0, 50);
        
        try {
            $log_sql = "INSERT INTO bitacora 
                        (id_usuario, nombre_personal, fecha_hora, accion, id_detalles_falla) 
                        VALUES 
                        (:id_usuario, :nombre_personal, :fecha_hora, :accion, :id_detalles_falla)";
            
            $log_stmt = $this->conexion->prepare($log_sql);
            $log_stmt->bindParam(':id_usuario', $id_usuario);
            $log_stmt->bindParam(':nombre_personal', $nombre_personal);
            $log_stmt->bindParam(':fecha_hora', $fecha_hora);
            $log_stmt->bindParam(':accion', $accion);
            $log_stmt->bindParam(':id_detalles_falla', $id_detalles_falla);
            $log_stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error al registrar en bitácora: " . $e->getMessage());
            throw new Exception("Error interno al guardar el registro");
        }
    }
}
?>
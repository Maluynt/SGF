<?php
class ModeloRecuperarContrasena {
    private $conexion;

    public function __construct($pdo) {
        $this->conexion = $pdo;
    }

    public function verificarUsuario($carnet_usuario) {
        $stmt = $this->conexion->prepare("SELECT * FROM usuario WHERE usuario = ?");
        $stmt->execute([$carnet_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarContrasena($carnet_usuario, $nueva_contrasena) {
        $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $stmt = $this->conexion->prepare("UPDATE usuario SET contrasena = ? WHERE usuario = ?");
        return $stmt->execute([$hashed_password, $carnet_usuario]);
    }
}
?>

<?php
// modelo_usuario.php
class ModeloUsuario {
    private $conexion;

    public function __construct($pdo) {
        $this->conexion = $pdo;
    }

    public function obtenerInformacionUsuario($id_usuario) {
        $stmt = $this->conexion->prepare("
            SELECT 
                u.id_usuario, 
                u.usuario, 
                p.nombre_personal, 
                p.carnet,
                pr.perfil AS nombre_perfil,
                s.nombre_servicio AS nombre_servicio
            FROM usuario u
            INNER JOIN personal p ON u.id_personal = p.id_personal
            INNER JOIN perfil pr ON u.id_perfil = pr.id_perfil
            INNER JOIN servicio s ON u.id_servicio = s.id_servicio
            WHERE u.id_usuario = :id_usuario
        ");
        
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
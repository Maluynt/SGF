<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion/conexion_bd.php");

class Usuario {
    private $pdo;

    public function __construct($conexion) {
        $this->pdo = $conexion;
    }

    // Método para registrar un nuevo usuario
    public function registrar($datos) {
        $sql = "INSERT INTO usuario (id_perfil, id_personal, id_servicio, usuario, contrasena,  respuesta_secreta, pregunta_secreta) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $datos['id_perfil'],
            $datos['id_personal'],
            $datos['id_servicio'],
            $datos['usuario'],
            $datos['contrasena'],
            $datos['respuesta_secreta'],
            $datos['pregunta_secreta']
        ]);
    }

    // Método para obtener perfiles
    public function obtenerPerfiles() {
        $sql = "SELECT * FROM perfil";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener servicios
    public function obtenerServicios() {
        $sql = "SELECT * FROM servicio"; 
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPersonal($termino) {
        $sql = "SELECT id_personal, nombre_personal FROM personal WHERE nombre_personal LIKE :termino OR id_personal::text LIKE :termino"; // Asegúrate de que id_personal sea tratado como texto
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['termino' => "%$termino%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function verificarIdPersonal($id_personal) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuario WHERE id_personal = :id_personal");
        $stmt->execute(['id_personal' => $id_personal]);
        return $stmt->fetchColumn() > 0; // Retorna true si existe, false si no
    }
    
}
?>

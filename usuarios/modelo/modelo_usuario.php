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
}
?>

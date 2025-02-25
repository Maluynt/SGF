<?php
class SubsistemaModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtiene todos los ambientes desde la base de datos
    public function obtenerAmbientes() {
        $sql = "SELECT id_ambiente, ambiente FROM ambiente";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registra un nuevo subsistema en la base de datos
    
    public function registrar($id_servicio, $id_ambiente, $nombre) {
        if (!is_numeric($id_servicio) || !is_numeric($id_ambiente)) {
            throw new Exception("ID de servicio o ambiente inválido.");
        }

        if (empty($nombre)) {
            throw new Exception("El nombre del subsistema no puede estar vacío.");
        }

        $sql = $this->pdo->prepare("INSERT INTO sub_sistema (id_servicio, id_ambiente, nombre_subsistema) VALUES (?, ?, ?)");
        if (!$sql->execute([$id_servicio, $id_ambiente, $nombre])) {
            throw new Exception("Error al registrar el subsistema.");
        }

        return true; // Retorna verdadero si se registró correctamente
    }

    // Método adicional para obtener todos los subsistemas
    public function obtenerSubsistemas() {
        return $this->pdo->query("SELECT * FROM sub_sistema")->fetchAll();
    }
}

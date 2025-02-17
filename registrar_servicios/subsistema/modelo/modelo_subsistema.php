<?php
class SubsistemaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerAmbientes() {
        return $this->pdo->query("SELECT id_ambiente, ambiente FROM ambiente")->fetchAll();
    }

    public function registrar($id_ambiente, $nombre) {
        // Obtener id_servicio de la sesión directamente en el modelo
        $id_servicio = $_SESSION['id_servicio'] ?? null;
        
        if (!$id_servicio) {
            throw new Exception("Usuario no tiene servicio asignado");
        }
    
        $sql = $this->pdo->prepare("INSERT INTO sub_sistema (id_servicio, id_ambiente, nombre_subsistema) VALUES (?, ?, ?)");
        return $sql->execute([$id_servicio, $id_ambiente, $nombre]);
    }
}
?>


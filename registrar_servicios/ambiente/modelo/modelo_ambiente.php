
<?php
class AmbienteModel {
    private $pdo;
   
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
       
   

    public function registrar($id_ubicacion,$nombre) {
        $sql = $this->pdo->prepare("
            INSERT INTO ambiente (id_ubicacion, ambiente)
            VALUES (:id_ubicacion, :nombre)
        ");
        
        return $sql->execute([':id_ubicacion' => $id_ubicacion,
            ':nombre' => $nombre]);
    }
    
    public function obtenerUbicacion() {
        // Obtener ubicacions del servicio del usuario
        $sql = $this->pdo->prepare("
            SELECT id_ubicacion, ubicacion 
            FROM ubicacion
        ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>


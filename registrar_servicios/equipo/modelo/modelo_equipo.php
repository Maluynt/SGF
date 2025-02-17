
<?php
class EquipoModel {
    private $pdo;
    private $id_servicio;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->id_servicio = $_SESSION['id_servicio'] ?? null;

        if (!$this->id_servicio) {
            throw new Exception("Usuario no tiene servicio asignado");
        }
    }

   

    public function registrar($id_subsistema, $nombre_equipo) {
        $sql = $this->pdo->prepare("
            INSERT INTO equipo (id_subsistema, nombre_equipo)
            VALUES (:id_subsistema, :nombre)
        ");
        
        return $sql->execute([
            ':id_subsistema' => $id_subsistema,
            ':nombre' => $nombre_equipo
        ]);
    }
    
    public function obtenerSubsistemas() {
        // Obtener subsistemas del servicio del usuario
        $sql = $this->pdo->prepare("
            SELECT id_subsistema, nombre_subsistema 
            FROM sub_sistema 
            WHERE id_servicio = :id_servicio
        ");
        $sql->bindParam(':id_servicio', $_SESSION['id_servicio'], PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>


<?php
class Ubicacionmodel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrar($nombre) {
        // Obtener id_servicio de la sesión directamente en el modelo
      
       
        $sql = $this->pdo->prepare("INSERT INTO ubicacion (ubicacion) VALUES (?)");
        return $sql->execute([$nombre]);
    }
}
?>


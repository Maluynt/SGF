<?php 

class ModeloServicio {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrarServicio($nombreServicio) {
        $sql = $this->pdo->prepare("INSERT INTO servicio (nombre_servicio) VALUES (:servicio)");
        $sql->bindParam(':servicio', $nombreServicio, PDO::PARAM_STR);
        return $sql->execute();
    }
}
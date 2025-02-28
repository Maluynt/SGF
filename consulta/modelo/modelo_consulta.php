<?php

class FallaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtenerFallas() {
        try {
            $query = "SELECT * FROM falla"; // Consulta básica para pruebas
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en SQL: " . $e->getMessage()); // Ver error real
            throw new Exception("Error al obtener datos");
        }
    }
}
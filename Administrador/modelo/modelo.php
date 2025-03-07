<?php

class ServicioModel {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getServiciosBD() {
        $stmt = $this->pdo->query("SELECT LOWER(TRIM(nombre_servicio)) AS nombre_normalizado, id_servicio FROM servicio");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function getServiciosEstaticos() {
        return [
            ['id' => 23, 'nombre' => 'Administrador', 'color' => '1', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
            ['id' => 34, 'nombre' => 'Obras civiles', 'color' => '2', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
            ['id' => 43, 'nombre' => 'Electrificación', 'color' => '3', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
            ['id' => 12, 'nombre' => 'Control de Trenes', 'color' => '4', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
            ['id' => 35, 'nombre' => 'Señalizacion', 'color' => '5', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
            ['id' => 67, 'nombre' => 'Material Rodante', 'color' => '6', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
            ['id' => 67, 'nombre' => 'Tecnología', 'color' => '7', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
            ['id' => 78, 'nombre' => 'Electromecánica', 'color' => '8', 'url' => '/metro/SGF/inicio/controlador/controlador_inicio.php'],
        ];
    }
}
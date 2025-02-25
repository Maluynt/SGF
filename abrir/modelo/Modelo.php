<?php
class Modelo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPersonal() {
        $query = $this->pdo->prepare("SELECT * FROM personal ORDER BY nombre_personal ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMetodoReporte() {
        $query = $this->pdo->prepare("SELECT * FROM metodo_reporte ORDER BY metodo_reporte ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUbicacion() {
        $query = $this->pdo->prepare("SELECT * FROM ubicacion ORDER BY ubicacion ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerServicio() {
        $query = $this->pdo->prepare("SELECT * FROM servicio ORDER BY nombre_servicio ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerResponsableArea() {
        $query = $this->pdo->prepare("SELECT * FROM personal ORDER BY nombre_personal ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPrioridad() {
        $query = $this->pdo->prepare("SELECT * FROM prioridad ORDER BY prioridad ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generarIdFalla() {
        date_default_timezone_set("America/Caracas");
        $año = date('Y');
        $mes = date('m');
        $contador = 1;

        $stmt = $this->pdo->prepare("SELECT id_falla FROM falla WHERE id_falla::text LIKE :id_falla");
        $stmt->execute(['id_falla' => "$año$mes%"]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contador++;
        }

        return "$año$mes" . str_pad($contador, 3, '0', STR_PAD_LEFT);
    }

    public function obtenerAmbientes($id_ubicacion) {
        $query = $this->pdo->prepare("SELECT * FROM ambiente WHERE id_ubicacion = :id_ubicacion");
        $query->execute(['id_ubicacion' => $id_ubicacion]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerSubSistemas($id_ambiente, $id_servicio) {
        $query = $this->pdo->prepare("SELECT * FROM sub_sistema WHERE id_ambiente = :id_ambiente AND id_servicio = :id_servicio");
        $query->execute(['id_ambiente' => $id_ambiente, 'id_servicio' => $id_servicio]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEquipos($id_subsistema) {
        $query = $this->pdo->prepare("SELECT * FROM equipo WHERE id_subsistema = :id_subsistema");
        $query->execute(['id_subsistema' => $id_subsistema]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para insertar un nuevo registro en la tabla falla
    public function insertarFalla($id_falla, $prioridad, $estado, $equipo, $recibida_ccf, $fecha_hora, $ubicacion, $ambiente, $descripcion_falla, $metodo_reporte) {
        $query = $this->pdo->prepare("INSERT INTO falla (id_falla, id_prioridad, id_estado, id_equipo, id_usuario, fecha_hora_reporte, detalles_ubicacion, descripcion_falla, id_reporte) VALUES (:id_falla, :prioridad, :estado, :equipo,:recibida_ccf, :fecha_hora,:detalles_ubicacion, :descripcion_falla, :metodo_reporte)");
        $query->execute([
            'id_falla' => $id_falla,
            'fecha_hora' => $fecha_hora,
            'recibida_ccf' => $recibida_ccf,
            'metodo_reporte' => $metodo_reporte,
            'detalles_ubicacion' => "$ubicacion, $ambiente", // Guardar ubicación y ambiente juntos
            'equipo' => $equipo,
            'prioridad' => $prioridad,
            'estado' => $estado,
            'descripcion_falla' => $descripcion_falla
        ]);
    }

    // Función para insertar un nuevo registro en la tabla detalles_falla
    public function insertarDetallesFalla($id_falla, $id_personal, $accion, $fecha_hora) {
        $query = $this->pdo->prepare("INSERT INTO detalles_falla (id_falla, id_personal, accion, fecha_de_accion) VALUES (:id_falla, :id_personal, :accion, :fecha_de_accion)");
        $query->execute([
            'id_falla' => $id_falla,
            'id_personal' => $id_personal,
            'accion' => $accion,
            'fecha_de_accion' => $fecha_hora
        ]);
    }
}
?>

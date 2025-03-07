<?php
class Modelo
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerPersonal()
    {
        $query = $this->pdo->prepare("SELECT * FROM personal ORDER BY nombre_personal ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMetodoReporte()
    {
        $query = $this->pdo->prepare("SELECT * FROM metodo_reporte ORDER BY metodo_reporte ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUbicacion()
    {
        $query = $this->pdo->prepare("SELECT * FROM ubicacion ORDER BY ubicacion ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

  
    public function obtenerServicio($id_servicio = null) {
        try {
            if ($id_servicio) {
                // Primero obtener el nombre del servicio usando el ID
                $stmt = $this->pdo->prepare("SELECT nombre_servicio FROM servicio WHERE id_servicio = :id_servicio");
                $stmt->execute(['id_servicio' => $id_servicio]);
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Si el nombre es "Administrador", obtener todos los servicios
                if ($resultado && $resultado['nombre_servicio'] === 'Administrador') {
                    $query = $this->pdo->prepare("SELECT * FROM servicio");
                    $query->execute();
                } else {
                    // Si no, obtener solo el servicio del ID proporcionado
                    $query = $this->pdo->prepare("SELECT * FROM servicio WHERE id_servicio = :id_servicio");
                    $query->execute(['id_servicio' => $id_servicio]);
                }
            } else {
                // Si no hay ID, obtener todos los servicios
                $query = $this->pdo->prepare("SELECT * FROM servicio");
                $query->execute();
            }
            return $query->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Error al obtener servicios: " . $e->getMessage());
            return [];
        }
    }






    public function obtenerResponsableArea()
    {
        $query = $this->pdo->prepare("SELECT * FROM personal ORDER BY nombre_personal ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPrioridad()
    {
        $query = $this->pdo->prepare("SELECT * FROM prioridad ORDER BY prioridad ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generarIdFalla()
    {
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

    public function obtenerAmbientes($id_ubicacion)
    {
        $query = $this->pdo->prepare("SELECT * FROM ambiente WHERE id_ubicacion = :id_ubicacion");
        $query->execute(['id_ubicacion' => $id_ubicacion]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerSubSistemas($id_ambiente, $id_servicio)
    {
        $query = $this->pdo->prepare("SELECT * FROM sub_sistema WHERE id_ambiente = :id_ambiente AND id_servicio = :id_servicio");
        $query->execute(['id_ambiente' => $id_ambiente, 'id_servicio' => $id_servicio]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEquipos($id_subsistema)
    {
        $query = $this->pdo->prepare("SELECT * FROM equipo WHERE id_subsistema = :id_subsistema");
        $query->execute(['id_subsistema' => $id_subsistema]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para insertar un nuevo registro en la tabla falla
    public function insertarFalla($id_falla, $prioridad, $estado, $equipo, $recibida_ccf, $fecha_hora, $ambiente, $descripcion_falla, $metodo_reporte) {
        $query = $this->pdo->prepare("
            INSERT INTO falla (
                id_falla, 
                id_prioridad, 
                id_estado, 
                id_equipo, 
                id_usuario, 
                fecha_hora_reporte, 
                id_ambiente, 
                descripcion_falla, 
                id_reporte,
                fecha_apertura 
            ) VALUES (
                :id_falla, 
                :prioridad, 
                :estado, 
                :equipo,
                :recibida_ccf, 
                :fecha_hora, 
                :id_ambiente, 
                :descripcion_falla, 
                :metodo_reporte,
                CURRENT_TIMESTAMP 
            )
        ");
        
        $query->execute([
            'id_falla' => $id_falla,
            'prioridad' => $prioridad,
            'estado' => $estado,
            'equipo' => $equipo,
            'recibida_ccf' => $recibida_ccf,
            'fecha_hora' => $fecha_hora,
            'id_ambiente' => $ambiente,
            'descripcion_falla' => $descripcion_falla,
            'metodo_reporte' => $metodo_reporte
        ]);
    }
    // Función para insertar un nuevo registro en la tabla detalles_falla
    public function insertar_reportada_por($id_falla, $id_personal,$fecha_hora)
    {
        $query = $this->pdo->prepare("INSERT INTO reportada_por (id_falla, id_personal, fecha_reporte) VALUES (:id_falla, :id_personal, :fecha_reporte)");
        $query->execute([
            'id_falla' => $id_falla,
            'id_personal' => $id_personal,
            'fecha_reporte' => $fecha_hora
        ]);
    }


    public function insertar_responsable_area($id_falla, $id_personal, $fecha_hora)
    {
        $query = $this->pdo->prepare("INSERT INTO responsable_area (id_falla, id_personal, fecha_reporte) VALUES (:id_falla, :id_personal, :fecha_reporte)");
        $query->execute([
            'id_falla' => $id_falla,
            'id_personal' => $id_personal,
            'fecha_reporte' => $fecha_hora
        ]);
    }
}



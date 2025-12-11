<?php
class FallaModel
{
    private $pdo;
    private $id_servicio;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if (!isset($_SESSION['id_servicio'])) {
            throw new Exception("ID de servicio no está definido en la sesión");
        }
        $this->id_servicio = $_SESSION['id_servicio'];
    }

    public function obtenerFallasCompletas() {
        try {
            // Verificar si el servicio actual es Administrador
            $queryServicio = "SELECT nombre_servicio FROM servicio WHERE id_servicio = :id_servicio";
            $stmtServicio = $this->pdo->prepare($queryServicio);
            $stmtServicio->execute(['id_servicio' => $this->id_servicio]);
            $resultado = $stmtServicio->fetch(PDO::FETCH_ASSOC);
            
            $esAdministrador = ($resultado['nombre_servicio'] ?? '') === 'Administrador';
    
            // Construir consulta base
            $query = "
                SELECT 
                    f.*,
                    EXTRACT(DAY FROM (COALESCE(f.fecha_hora_cierre, NOW()) - f.fecha_apertura))::INTEGER AS dias_falla,
                    TO_CHAR(f.fecha_hora_reporte, 'YYYY-MM-DD') AS fecha_hora_reporte, 
                    eq.nombre_equipo AS nombre_equipo,
                    s.nombre_subsistema AS nombre_subsistema,
                    ser.nombre_servicio AS nombre_servicio,
                    p.prioridad AS nombre_prioridad,
                    e.estado AS nombre_estado,
                    acom.acompañamiento AS acompañamiento,
                    COALESCE(rp.nombre_personal, 'No asignado') AS nombre_reportada_por,
                    COALESCE(ra.nombre_personal, 'No asignado') AS nombre_responsable_area,
                    am.ambiente AS nombre_ambiente,
                    ubic.ubicacion AS nombre_ubicacion,
                    met.metodo_reporte AS nombre_metodo_reporte
                FROM falla f
                INNER JOIN equipo eq ON f.id_equipo = eq.id_equipo
                INNER JOIN sub_sistema s ON eq.id_subsistema = s.id_subsistema
                INNER JOIN servicio ser ON s.id_servicio = ser.id_servicio
                LEFT JOIN prioridad p ON f.id_prioridad = p.id_prioridad
                LEFT JOIN estado e ON f.id_estado = e.id_estado
                LEFT JOIN acompañamiento acom ON f.id_acompanamiento = acom.id_acompañamiento
                LEFT JOIN reportada_por re ON f.id_falla = re.id_falla
                LEFT JOIN personal rp ON re.id_personal = rp.id_personal
                LEFT JOIN responsable_area res ON f.id_falla = res.id_falla
                LEFT JOIN personal ra ON res.id_personal = ra.id_personal
                LEFT JOIN ambiente am ON am.id_ambiente = f.id_ambiente
                LEFT JOIN ubicacion ubic ON ubic.id_ubicacion = am.id_ubicacion
                LEFT JOIN metodo_reporte met ON f.id_reporte = met.id_reporte
            ";
    
            // Agregar condición WHERE solo si no es Administrador
            if (!$esAdministrador) {
                $query .= " WHERE ser.id_servicio = :id_servicio";
            }
    
            $query .= " ORDER BY f.fecha_hora_reporte DESC";
    
            $stmt = $this->pdo->prepare($query);
            
            // Bind parámetro solo si no es Administrador
            $params = [];
            if (!$esAdministrador) {
                $params['id_servicio'] = $this->id_servicio;
            }
    
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            error_log("Error en SQL: " . $e->getMessage());
            throw new Exception("Error al obtener fallas: " . $e->getMessage());
        }
    }
 
    public function obtenerFallaPorId($id_falla) {
        $query = $this->pdo->prepare("
            SELECT 
                *,
                EXTRACT(DAY FROM (COALESCE(fecha_hora_cierre, NOW()) - fecha_apertura))::INTEGER AS dias_falla 
            FROM falla 
            WHERE id_falla = :id_falla
        ");
        $query->execute(['id_falla' => $id_falla]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarFalla($datos) {
        try {
            $query = $this->pdo->prepare("
                UPDATE falla SET
                    id_prioridad = :id_prioridad,
                    id_estado = :id_estado,
                    solucion = :solucion,
                    id_acompanamiento = :id_acompanamiento,
                    fecha_hora_cierre = CASE 
                        WHEN :id_estado = (SELECT id_estado FROM estado WHERE estado = 'Cerrada') 
                            THEN NOW() 
                            ELSE fecha_hora_cierre 
                    END
                WHERE id_falla = :id_falla
            ");
    
            // Bind de parámetros con tipos explícitos
            $query->bindValue(':id_prioridad', (int)$datos['prioridad'], PDO::PARAM_INT);
            $query->bindValue(':id_estado', (int)$datos['estado'], PDO::PARAM_INT);
            $query->bindValue(':id_acompanamiento', (int)$datos['id_acompanamiento'], PDO::PARAM_INT);
            $query->bindValue(':id_falla', (int)$datos['id_falla'], PDO::PARAM_INT);
            $query->bindValue(':solucion', $datos['solucion'], PDO::PARAM_STR);
    
            $query->execute();
            return true;
    
        } catch (PDOException $e) {
            error_log("Error SQL: " . $e->getMessage());
            throw new Exception("Error al actualizar: " . $e->getMessage());
        }
    }
    public function obtenerPrioridades() {
        $query = $this->pdo->query("SELECT * FROM prioridad");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstados() {
        $query = $this->pdo->query("SELECT * FROM estado");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEquipos() {
        $query = $this->pdo->query("SELECT * FROM equipo");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerAcompañamiento() {
        $query = $this->pdo->query("SELECT * FROM acompañamiento");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function incrementarIntervencion($id_falla) {
        try {
            $query = $this->pdo->prepare("
                UPDATE falla 
                SET n_intervencion = COALESCE(n_intervencion, 0) + 1
                WHERE id_falla = :id_falla
            ");
            $success = $query->execute(['id_falla' => $id_falla]);
            return $success && $query->rowCount() > 0; 
        } catch (PDOException $e) {
            error_log("PDO Error: " . $e->getMessage()); 
            return false;
        }
    }

// En FallasModel.php
public function obtenerFallasFiltradas($filtros) {
    try {
        $esAdmin = $this->esServicioAdministrador();
        // Mapeo de filtros a columnas/expresiones reales
        $columnMap = [
            'id_falla' => 'f.id_falla',
            'nombre_equipo' => 'eq.nombre_equipo',
            'nombre_subsistema' => 's.nombre_subsistema',
            'nombre_servicio' => 'ser.nombre_servicio',
            'nombre_ambiente' => 'am.ambiente',
            'fecha_hora_reporte' => 'f.fecha_hora_reporte',
            'dias_falla' => 'EXTRACT(DAY FROM NOW() - f.fecha_apertura)::INTEGER',
            'nombre_estado' => 'e.estado'
        ];

        // Consulta base sin WHERE inicial
        $sql = "
            SELECT 
                f.*,
                EXTRACT(DAY FROM NOW() - f.fecha_apertura)::INTEGER AS dias_falla,
                TO_CHAR(f.fecha_hora_reporte, 'YYYY-MM-DD') AS fecha_hora_reporte, 
                eq.nombre_equipo AS nombre_equipo,
                s.nombre_subsistema AS nombre_subsistema,
                ser.nombre_servicio AS nombre_servicio,
                p.prioridad AS nombre_prioridad,
                e.estado AS nombre_estado,
                acom.acompañamiento AS acompañamiento,
                COALESCE(rp.nombre_personal, 'No asignado') AS nombre_reportada_por,
                COALESCE(ra.nombre_personal, 'No asignado') AS nombre_responsable_area,
                am.ambiente AS nombre_ambiente,
                ubic.ubicacion AS nombre_ubicacion,
                met.metodo_reporte AS nombre_metodo_reporte
            FROM falla f
            INNER JOIN equipo eq ON f.id_equipo = eq.id_equipo
            INNER JOIN sub_sistema s ON eq.id_subsistema = s.id_subsistema
            INNER JOIN servicio ser ON s.id_servicio = ser.id_servicio
            LEFT JOIN prioridad p ON f.id_prioridad = p.id_prioridad
            LEFT JOIN estado e ON f.id_estado = e.id_estado
            LEFT JOIN acompañamiento acom ON f.id_acompanamiento = acom.id_acompañamiento
            LEFT JOIN reportada_por re ON f.id_falla = re.id_falla
            LEFT JOIN personal rp ON re.id_personal = rp.id_personal
            LEFT JOIN responsable_area res ON f.id_falla = res.id_falla
            LEFT JOIN personal ra ON res.id_personal = ra.id_personal
            LEFT JOIN ambiente am ON am.id_ambiente = f.id_ambiente
            LEFT JOIN ubicacion ubic ON ubic.id_ubicacion = am.id_ubicacion
            LEFT JOIN metodo_reporte met ON f.id_reporte = met.id_reporte
        ";

        $conditions = [];
        $params = [];

        // Filtro de servicio solo si no es Administrador
        if (!$esAdmin) {
            $conditions[] = "ser.id_servicio = :id_servicio";
            $params[':id_servicio'] = $this->id_servicio;
        }

        // Filtro de fechas
        if (!empty($filtros['fechaInicio']) && !empty($filtros['fechaFin'])) {
            $fechaInicio = date('Y-m-d', strtotime($filtros['fechaInicio']));
            $fechaFin = date('Y-m-d', strtotime($filtros['fechaFin'] . ' +1 day'));
            
            $conditions[] = "f.fecha_hora_reporte >= :fechaInicio AND f.fecha_hora_reporte < :fechaFin";
            $params[':fechaInicio'] = $fechaInicio;
            $params[':fechaFin'] = $fechaFin;
        }

        // Otros filtros (estado, equipo, etc.)
        foreach ($filtros as $key => $value) {
            if (!empty($value) && array_key_exists($key, $columnMap)) {
                $conditions[] = "{$columnMap[$key]} = :{$key}";
                $params[":{$key}"] = $value;
            }
        }

        // Combinar condiciones en WHERE si hay alguna
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY f.fecha_hora_reporte DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Error en SQL: " . $e->getMessage());
        throw new Exception("Error al obtener fallas: " . $e->getMessage());
    }
}
private function esServicioAdministrador() {
    $query = "SELECT nombre_servicio FROM servicio WHERE id_servicio = ?";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([$this->id_servicio]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return ($resultado['nombre_servicio'] ?? '') === 'Administrador';
}



}

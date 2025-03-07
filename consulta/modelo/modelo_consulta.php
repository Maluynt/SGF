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
            $query = "
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
                LEFT JOIN acompañamiento acom ON f.id_acompañamiento = acom.id_acompañamiento
                LEFT JOIN reportada_por re ON f.id_falla = re.id_falla
                LEFT JOIN personal rp ON re.id_personal = rp.id_personal
                LEFT JOIN responsable_area res ON f.id_falla = res.id_falla
                LEFT JOIN personal ra ON res.id_personal = ra.id_personal
                LEFT JOIN ambiente am ON am.id_ambiente = f.id_ambiente
                LEFT JOIN ubicacion ubic ON ubic.id_ubicacion = am.id_ubicacion
                LEFT JOIN metodo_reporte met ON f.id_reporte = met.id_reporte
                WHERE ser.id_servicio = :id_servicio
                ORDER BY f.fecha_hora_reporte DESC
            ";
    
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id_servicio' => $this->id_servicio]);
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
                EXTRACT(DAY FROM NOW() - fecha_apertura)::INTEGER AS dias_falla 
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
                    \"id_acompañamiento\" = :id_acompanamiento
                WHERE id_falla = :id_falla
            ");
            
            $resultado = $query->execute([
                'id_falla' => $datos['id_falla'],
                'id_prioridad' => $datos['prioridad'],
                'id_estado' => $datos['estado'],
                'solucion' => $datos['solucion'],
                'id_acompanamiento' => $datos['id_acompañamiento']
            ]);
    
            error_log("Filas actualizadas: " . $query->rowCount());
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error al actualizar falla: " . $e->getMessage());
            return false;
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
            
            return $query->execute(['id_falla' => $id_falla]);
        } catch (PDOException $e) {
            error_log("Error al incrementar intervención: " . $e->getMessage());
            return false;
        }
    }
}

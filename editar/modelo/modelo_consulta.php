<?php
class FallaModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Método unificado para obtener todas las fallas con relaciones
    public function obtenerFallasCompletas()
    {
        try {
            $query = "
               SELECT 
    f.*,
    eq.nombre_equipo AS nombre_equipo,
    s.nombre_subsistema AS nombre_subsistema,
    ser.nombre_servicio AS nombre_servicio,
    p.prioridad AS nombre_prioridad,
    e.estado AS nombre_estado,
    COALESCE(rp.nombre_personal, 'No asignado') AS nombre_reportada_por,
    COALESCE(ra.nombre_personal, 'No asignado') AS nombre_responsable_area,
    am.ambiente AS nombre_ambiente,
    ubic.ubicacion AS nombre_ubicacion,
    met.metodo_reporte AS nombre_metodo_reporte
    FROM 
        falla f
    INNER JOIN equipo eq 
        ON f.id_equipo = eq.id_equipo
    LEFT JOIN sub_sistema s 
        ON eq.id_subsistema = s.id_subsistema
    LEFT JOIN servicio ser 
        ON s.id_servicio = ser.id_servicio
    INNER JOIN prioridad p 
        ON f.id_prioridad = p.id_prioridad
    INNER JOIN estado e 
        ON f.id_estado = e.id_estado
    LEFT JOIN reportada_por re 
        ON f.id_falla = re.id_falla
    LEFT JOIN personal rp 
        ON re.id_personal = rp.id_personal
    LEFT JOIN responsable_area res 
        ON f.id_falla = res.id_falla
    LEFT JOIN personal ra 
        ON res.id_personal = ra.id_personal
    LEFT JOIN ambiente am
        ON am.id_ambiente = f.id_ambiente   
    LEFT JOIN ubicacion ubic
        ON ubic.id_ubicacion = am.id_ubicacion     
    LEFT JOIN metodo_reporte met
        ON f.id_reporte = met.id_reporte      

            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en SQL: " . $e->getMessage());
            throw new Exception("Error al obtener datos completos de fallas");
        }
    }

    // Método obsoleto (se mantiene solo si es necesario para compatibilidad)
    public function obtenerFallasGenerales()
    {
        return $this->obtenerFallasCompletas();
    }
}

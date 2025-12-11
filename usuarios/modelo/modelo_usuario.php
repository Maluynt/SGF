<?php
// Incluir el archivo de conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';

class Usuarios {
    private $pdo;


    public function __construct($conexion) {
        $this->pdo = $conexion;
    }

    // Método para registrar un nuevo usuario
    public function registrar($datos) {
        // Validar si el usuario ya existe
        if ($this->existeUsuarioPorNombre($datos['usuario'])) {
            throw new Exception('El nombre de usuario ya está registrado');
        }
        $sql = "INSERT INTO usuario (id_perfil, id_personal, id_servicio, usuario, contrasena,  respuesta_secreta, pregunta_secreta) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $datos['id_perfil'],
            $datos['id_personal'],
            $datos['id_servicio'],
            $datos['usuario'],
            $datos['contrasena'],
            $datos['respuesta_secreta'],
            $datos['pregunta_secreta']
        ]);
    }
   // Nuevo método para verificar usuario único
   public function existeUsuarioPorNombre($usuario) {
    $stmt = $this->pdo->prepare("SELECT usuario FROM usuario WHERE usuario = ?");
    $stmt->execute([$usuario]);
    return $stmt->fetch() !== false;
}

    // Método para obtener perfiles
    public function obtenerPerfiles() {
        $sql = "SELECT * FROM perfil";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener servicios
    public function obtenerServicios() {
        $sql = "SELECT * FROM servicio"; 
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPersonal($query) {
        try {
            $busqueda = '%' . str_replace(' ', '%', trim($query)) . '%';  // Búsqueda parcial con espacios
            
            $sql = "SELECT id_personal, nombre_personal, carnet 
                    FROM personal 
                    WHERE 
                        nombre_personal ILIKE :busqueda OR 
                        carnet::TEXT LIKE :busqueda 
                    ORDER BY nombre_personal ASC 
                    LIMIT 10";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':busqueda', $busqueda, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Error en buscarPersonal: " . $e->getMessage());
        return [];
    }
}

// En modelo_usuario.php
public function existePersonal($id_personal) {
    // Cambiar 'personal' por 'tbl_personal'
    $stmt = $this->pdo->prepare("SELECT id_personal FROM personal WHERE id_personal = ?");
    $stmt->execute([$id_personal]);
    return $stmt->fetch() !== false;
}


public function existeUsuario($id_personal) {
    $stmt = $this->pdo->prepare("SELECT id_personal FROM usuario WHERE id_personal = ?");
    $stmt->execute([$id_personal]);
    return $stmt->fetch() !== false;
}
    public function verificarIdPersonal($id_personal) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuario WHERE id_personal = :id_personal");
        $stmt->execute(['id_personal' => $id_personal]);
        return $stmt->fetchColumn() > 0; // Retorna true si existe, false si no
    }
    
}
?>

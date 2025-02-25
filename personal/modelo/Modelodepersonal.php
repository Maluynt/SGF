<?php
include(__DIR__ . '/../../conexion/conexion_bd.php');

class PersonalModelo {
    private $db;

    public function __construct() {
        global $pdo; // Asegúrate de que $pdo esté definido en tu archivo de conexión
        $this->db = $pdo;
    }

    public function registrar($data) {
        //echo "Método registrar llamado."; // Mensaje de depuración
    
        $nombre = $data["nombre_apellido"];
        $NCarnet = $data["N-Carnet"];
        $contacto = $data["contacto"];
    
        // Validaciones
        if (empty($nombre) || empty($NCarnet) || empty($contacto)) {
            echo "<script>alert('Algunos campos están vacíos');</script>";
            return;
        }

        // Validación del campo NCarnet
        if (strlen($NCarnet) < 6 || !preg_match('/[-]/', $NCarnet)) {
            echo "<script>alert('El campo de carnet debe tener un mínimo de 6 caracteres incluyendo el carácter especial \"-\"'); window.location.href='../vista/personal.php';</script>";
            return;
        }

        // Validación del campo nombre (debe iniciar cada palabra con mayúscula)
        if (!preg_match('/^([A-Z][a-z]+( [A-Z][a-z]+)*)$/', $nombre)) {
            echo "<script>alert('El nombre y apellido deben iniciar con mayúscula. Ejemplo: \"Adres Bello\"'); window.location.href='../vista/personal.php';</script>";
            return;
        }

        // Validación del campo contacto (mínimo 11 caracteres)
        if (strlen($contacto) < 11) {
            echo "<script>alert('El campo de contacto debe tener un mínimo de 11 caracteres.'); window.location.href='../vista/personal.php'; </script>";
            return;
        }

        // Verificar si el carnet ya existe
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM personal WHERE carnet = ?");
        $stmt->execute([$NCarnet]);
        $carnetExists = $stmt->fetchColumn();

        if ($carnetExists > 0) {
            echo "<script>alert('El carnet ya existe en la base de datos.'); window.location.href='../vista/personal.php';</script>";
            return;
        }

        // Inserción en la base de datos
        $stmt = $this->db->prepare("INSERT INTO personal (nombre_personal, contacto, carnet) VALUES (?, ?, ?)");
        if ($stmt->execute([$nombre, $contacto, $NCarnet])) {
            echo "<script>alert('Datos registrados correctamente'); window.location.href='../vista/personal.php';</script>";
        } else {
            echo "<script>alert('Error al ingresar los datos');</script>";
        }
    }
}
?>
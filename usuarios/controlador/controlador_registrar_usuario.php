<?php
// Incluir el modelo de usuario
include("../modelo/modelo_usuario.php");
include("../../conexion/conexion_bd.php"); 

$usuarioModelo = new Usuario($pdo); 
// Verificar si se ha enviado el formulario para registrar un nuevo usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inicializar un array para almacenar mensajes de error
    $errores = [];

    // Validaciones de campos vacíos
    $campos = ['id_perfil', 'id_personal', 'id_servicio', 'usuario', 'password', 'respuesta', 'pregunta'];
    foreach ($campos as $campo) {
        if (empty($_POST[$campo])) {
            $errores[] = "El campo $campo está vacío.";
        }
    }

    // Si hay errores, mostrar mensajes
    if (!empty($errores)) {
        echo '<script>alert("' . implode("\\n", $errores) . '"); window.location.href = "../vista/vista_usuario.php";</script>';
    } else {
        // Verificar si el id_personal ya está registrado
        if ($usuarioModelo->verificarIdPersonal($_POST['id_personal'])) {
            echo '<script>alert("El carnet de personal ya pertenece a un usuario y no se puede volver a registrar."); window.location.href = "../vista/vista_usuario.php";</script>';
        } else {
            // Preparar datos para la inserción
            $datos = [
                'id_perfil' => $_POST['id_perfil'],
                'id_personal' => $_POST['id_personal'],
                'id_servicio' => $_POST['id_servicio'],
                'usuario' => $_POST['usuario'],
                'contrasena' => password_hash($_POST["password"], PASSWORD_DEFAULT),
                'respuesta_secreta' => $_POST['respuesta'],
                'pregunta_secreta' => $_POST['pregunta']
            ];

            // Registrar usuario
            if ($usuarioModelo->registrar($datos)) {
                echo '<script>alert("Usuario registrado correctamente"); window.location.href = "../inicio/inicio.php";</script>';
            } else {
                echo '<script>alert("Error al registrar el usuario."); window.location.href = "../vista/registro.php";</script>';
            }
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['termino'])) {
    // Obtener el término de búsqueda
    $termino = $_GET['termino'];

    // Buscar personal
    $resultados = $usuarioModelo->buscarPersonal($termino);

    // Devolver los resultados en formato JSON
    header('Content-Type: application/json');
    echo json_encode($resultados);
}
?>

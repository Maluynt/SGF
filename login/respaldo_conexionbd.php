<?php
/* Conexión a la base de datos PostgreSQL usando PDO */

// Definir los parámetros de conexión
$host = "localhost"; // Dirección del servidor donde está alojada la base de datos
$port = "5432"; // Puerto predeterminado de PostgreSQL
$user = "postgres"; // Nombre de usuario de PostgreSQL
$password = "25901"; // Contraseña correspondiente al usuario
$dbname = "SGF"; // Nombre de la base de datos a la que deseas conectarte

try {
    // Crear una cadena de conexión utilizando el driver de PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

    // Crear una nueva instancia de PDO para conectarse a la base de datos
    $pdo = new PDO($dsn);

    // Establecer el modo de error de PDO para que lance excepciones en caso de errores
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mensaje de éxito en la conexión
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    // Captura cualquier excepción de conexión y muestra un mensaje de error
    echo "Error en la conexión: " . $e->getMessage();
}
?>
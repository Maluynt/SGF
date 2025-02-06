<?php
// Definición de la clase ModeloUsuario
class ModeloUsuario {
    // Definición del método estático obtenerInformacionUsuario
    public static function obtenerInformacionUsuario() {
        // Retorna un array asociativo con la información del usuario
        return [
            // Asocia la clave 'perfil' con el valor de la variable de sesión $_SESSION["Perfil"]
            'perfil' => $_SESSION["Perfil"],
            // Asocia la clave 'usuario' con el valor de la variable de sesión $_SESSION["usuario"]
            'usuario' => $_SESSION["usuario"],
            // Asocia la clave 'nombre' con el valor de la variable de sesión $_SESSION["nombre"]
            'nombre' => $_SESSION["nombre"]
        ];
    }
}
?>

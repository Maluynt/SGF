<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include(__DIR__ . '/../modelo/Modelodepersonal.php');

class controladordepersonal {
    public function showForm() {
        include("vista/personal.php");
    }

    public function register() {
        if (!empty($_POST['btnregistrar'])) {
            $model = new PersonalModelo();
            $model->registrar($_POST);
        } 
    }
    
    
}

// Manejar la acción de registro
$controller = new controladordepersonal();
$controller->register();
?>

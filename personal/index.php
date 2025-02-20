<?php
session_start();
include("controlador/controladordepersonal.php");

$controller = new controladordepersonal();
$controller->showForm();
?>

<?php
// En la primera línea de header.php
if (!defined('INCLUIDO_SEGURO')) {
    die('Acceso directo no permitido');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Control de Fallas</title>
    



    <!-- CSS Local -->
    <link rel="stylesheet" href="/metro/SGF/assets/vendor/components/font-awesome/css/all.min.css">
<link rel="stylesheet" href="/metro/SGF/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="/metro/SGF/assets/css/all.min.css">
<link rel="stylesheet" href="/metro/SGF/assets/select2-4.0.13/dist/css/select2.min.css">
<link rel="stylesheet" href="/metro/SGF/inicio/css/estilo.css">
  
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <img src="/metro/SGF/img/logo_mlte.png" alt="logo del metro" class="img-fluid" style="max-width: 100px;">
                <h1 class="text-center m-0">Centro de Control de Fallas</h1>
            </div>
            <div class="time" id="time"></div>
        </div>
    </header>
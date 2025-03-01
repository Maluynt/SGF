<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<?php include('controlador/controlador_recuperar_contraseña.php'); ?>
    <div class="container">
        <img class="avatar" src="../img/logo_mlte.png" alt="logo de usuario">
        
        <form method="post" action="recuperar_contraseña.php">
            <div class="input-div">
                <input class="input" type="text" placeholder="Carnet de Usuario" name="carnet_usuario" required>
            </div>
            <div class="input-div">
                <input class="input" type="text" placeholder="Escriba su Pregunta Secreta" name="pregunta_secreta" required>
            </div>
            <div class="input-div">
                <input class="input" type="text" placeholder="Escriba su Respuesta Secreta" name="respuesta_secreta" required>
            </div>
            <div class="input-div">
                <input class="input" type="password" placeholder="Nueva Contraseña" name="nueva_contrasena" required>
            </div>
            <div class="input-div">
                <input class="input" type="password" placeholder="Confirmar Contraseña" name="confirmar_contrasena" required>
            </div>
            <div class="form__group">
                <button type="submit" name="btningresar">INGRESAR</button>
            </div>
            <div class="botones">
                <button type="button" class="segundo" onclick="window.location.href='../login/index.php'">REGRESAR</button>
            </div>
        </form>
    </div>
</body>
</html>

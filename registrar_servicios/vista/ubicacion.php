<!--?php
session_start();
include("../conexion/conexion_bd.php");
include("../modelo/ModeloUsuario.php");

if (empty($_SESSION["id_usuario"])) {
    header("Location:../login/vista_login.php");
    exit();
}

// Obtener información del usuario
$informacionUsuario = ModeloUsuario::obtenerInformacionUsuario();
?-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Control de Fallas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body data-theme="TEC">
    <header class="bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="../img/logo_mlte.png" alt="logo del metro" class="img-fluid" style="max-width: 100px;">
                <h1 class="text-center mx-3">Centro de Control de Fallas</h1>
            </div>
            <div class="time" id="time"></div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <?php
            include('../../siderbar/siderbar.php');

            ?>

            <main class="col-md-9 content-area">
                <div class="container mt-5">
                    <h2 class="text-center">Registrar ubicacion</h2>
                    <form method="post" action="ingresar_ubicacion.php"> <!-- Formulario para enviar datos -->
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id_ubicacion">Nombre:</label>
                                    <input type="text" class="form-control" id="id_ubicacion" name="ubicacion" required> <!-- Campo de entrada para sub-sistema -->
                                </div>

                                <div class="text-center">
                                    <button name="btnregistrar" class="btn btn-primary" type="submit" value="REGISTRAR">REGISTRAR</button> <!-- Botón para enviar el formulario -->
                                    <a href="../inicio/inicio.php" class="btn btn-secondary">REGRESAR</a> <!-- Botón para regresar -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3">
        <p>Redes Sociales:
            <a href="#" class="text-danger">Facebook</a> |
            <a href="#" class="text-danger">Twitter</a> |
            <a href="#" class="text-danger">Instagram</a>
        </p>
        <p>C.A. Metro Los Teques</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../JS/script.js"></script>

</body>

</html>
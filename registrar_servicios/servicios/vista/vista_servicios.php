<!-- vista.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Control de Fallas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/estilo.css">
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
            <aside class="col-md-3 sidebar bg-dark text-white">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item dropdown">
                        <a href="#" class="menu-item dropdown-toggle" data-toggle="dropdown">Información de usuario</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Perfil: <span><?php echo $informacionUsuario['perfil']; ?></span></a></li>
                            <li><a class="dropdown-item" href="#">Carnet: <span><?php echo $informacionUsuario['usuario']; ?></span></a></li>
                            <li><a class="dropdown-item" href="#">Nombre: <span><?php echo $informacionUsuario['nombre']; ?></span></a></li>
                        </ul>
                    </li>
                    <!-- Otros elementos del menú -->
                </ul>
            </aside>

            <main class="col-md-9 content-area">
                <div class="container mt-5">
                    <h2 class="text-center">Registrar Servicios</h2>
                    <form method="post" action="../controlador/controlador_servicios.php"> <!-- El formulario apunta al mismo controlador -->
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id_servicio">Nombre:</label>
                                    <input type="text" class="form-control" id="id_servicio" name="servicio" required>
                                </div>

                                <div class="text-center">
                                    <button name="btnregistrar" class="btn btn-primary" type="submit" value="REGISTRAR">REGISTRAR</button>
                                    <a href="../../../Administrador/vistas/index.php" class="btn btn-secondary">REGRESAR</a>
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
    <script src="../JS/script.js"></script>

</body>

</html>

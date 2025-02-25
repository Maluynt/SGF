
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Personal</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <header class="bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-center">Centro de Control de Fallas</h1>
            <div class="time" id="time"></div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-3 sidebar bg-dark text-white">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item dropdown">
                        <a href="#" class="menu-item dropdown-toggle" data-toggle="dropdown">Información de usuario</a>
                    </li>
                    <li class="list-group-item"><a href="#" class="menu-item">Registrar Usuario</a></li>
                    <li class="list-group-item"><a href="#" class="menu-item">Gestionar Registro</a></li>
                    <li class="list-group-item"><a href="../../login/controlador_cerrar_sesion.php" class="menu-item">Salir</a></li>
                </ul>
            </aside>

            <main class="col-md-9 content-area">
                <div class="container mt-5">
                    <h3 class="text-center">Registrar Personal</h3>
                    <form method="post" action="../controlador/controladordepersonal.php" class="mx-auto" style="max-width: 500px;">
                        <div class="form-group">
                            <label for="N-Carnet">Nº Carnet:</label>
                            <input type="text" id="N-Carnet" name="N-Carnet" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="nombre_apellido">Nombre:</label>
                            <input type="text" id="nombre_apellido" name="nombre_apellido" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="contacto">Contacto:</label>
                            <input type="text" id="contacto" name="contacto" class="form-control" required>
                        </div>

                        <div class="button-group text-center">
                            <button name="btnregistrar" type="submit" class="btn btn-danger" value="Registrar">Registrar</button>
                            <a href="#" class="btn btn-secondary">Regresar</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3">
        <p>C.A Metro Los Teques</p>
    </footer>

    <script src="../js/script.js"></script>
</body>

</html>

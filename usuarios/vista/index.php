<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Control de Fallas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <header class="bg-dark text-white p-3 header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="menu-icon" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </span>
                <img src="../../img/logo_mlte.png" alt="logo del metro" class="img-fluid" style="max-width: 100px;">
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
                    </li>
                    <li class="list-group-item"><a href="#" class="menu-item">Descargas</a></li>
                    <li class="list-group-item"><a href="#" class="menu-item">Historial</a></li>
                    <li class="list-group-item"><a href="#" class="menu-item">Ayuda</a></li>
                    <li class="list-group-item"><a href="../../login/controlador_cerrar_sesion.php" class="menu-item">Salir</a></li>
                </ul>
            </aside>
            <main class="col-md-9 content-area">
                <div class="container mt-5">
                    <h3 class="text-center">Registro de Nuevo Usuario</h3>
                    <form action="../controlador/controlador_registrar_usuario.php" method="post" class="mx-auto" style="max-width: 500px;">
                        <div class="form-group">
                            <label for="id_personal">Carnet de Personal</label>
                            <input type="text" id="id_personal" class="form-control" placeholder="Buscar personal..." autocomplete="off">
                            <input type="hidden" name="id_personal" id="id_personal_hidden">
                            <div id="sugerencias-personal" class="list-group" style="position: absolute; z-index: 1000;"></div>
                        </div>

                        <div class="form-group">
                            <label for="id_perfil">Perfil</label>
                            <select class="form-control" name="id_perfil" required>
                                <?php
                                    include("../../conexion/conexion_bd.php");
                                    include("../modelo/modelo_usuario.php");
                                    $usuarioModelo = new Usuario($pdo);
                                    $perfiles = $usuarioModelo->obtenerPerfiles();
                                    foreach ($perfiles as $perfil) {
                                        echo "<option value=\"{$perfil['id_perfil']}\">{$perfil['perfil']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_servicio">Servicio</label>
                            <select class="form-control" name="id_servicio" required>
                                <?php
                                    $servicios = $usuarioModelo->obtenerServicios();
                                    foreach ($servicios as $servicio) {
                                        echo "<option value=\"{$servicio['id_servicio']}\">{$servicio['nombre_servicio']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="pregunta">Pregunta secreta</label>
                            <input type="text" class="form-control" name="pregunta" placeholder="Pregunta secreta" required>
                        </div>
                        <div class="form-group">
                            <label for="respuesta">Respuesta secreta</label>
                            <input type="text" class="form-control" name="respuesta" placeholder="Respuesta secreta" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="submit" class="btn btn-danger">Registrar</button>
                            <a href="../inicio/inicio.php" class="btn btn-secondary">Regresar</a>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const contentArea = document.querySelector('.content-area');
            sidebar.classList.toggle('active');
            contentArea.classList.toggle('active');
        }
    </script>
</body>

</html>

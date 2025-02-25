<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Control de Fallas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
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
                <img src="<?= BASE_URL ?>../../../../img/logo_mlte.png" alt="logo del metro" class="img-fluid" style="max-width: 100px;">
                <h1 class="text-center m-0">Centro de Control de Fallas</h1>
            </div>
            <div class="time" id="time"></div>
        </div>
    </header>
    <nav class="sidebar bg-dark">
        <div class="sidebar-header">
            <h4 class="text-white mb-0">Menú Principal</h4>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-item user-info">
                    <div class="user-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="user-icon">👤</span>
                            <h5 class="m-0">Usuario</h5>
                        </div>
                        <i class="dropdown-icon"></i>
                    </div>
                    <nav class="sidebar bg-dark">
                        <!-- ... resto del código ... -->
                        <div class="user-details">
                            <!-- sidebar.php (versión corregida) -->

                            <p class="m-1">Nombre: <?= $informacionUsuario['nombre'] ?? 'No disponible' ?></p>
                            <p class="m-1">Perfil: <?= $informacionUsuario['perfil'] ?? 'No disponible' ?></p>
                            <p class="m-1">Carnet: <?= $informacionUsuario['carnet'] ?? 'No disponible' ?></p>
                            <p class="m-1">Servicio: <?= $informacionUsuario['servicio'] ?? 'No disponible' ?></p>
                        </div>
                        <!-- ... resto del código ... -->
                </div>
            </div>

            <div class="menu-section">
                <div class="menu-item registry-menu">
                    <div class="menu-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="menu-icon">📝</span>
                            <h5 class="m-0">Registros</h5>
                        </div>
                        <i class="dropdown-icon"></i>
                    </div>
                    <div class="submenu">
                        <a href="#" class="submenu-item">Servicios</a>
                        <a href="#" class="submenu-item">Subsistemas</a>
                        <a href="#" class="submenu-item">Equipos</a>
                    </div>
                </div>
            </div>

            <a href="#" class="menu-item">Descargas</a>
            <a href="#" class="menu-item">Historial</a>
            <a href="#" class="menu-item">Ayuda</a>
            <a href="<?= BASE_URL ?>login/controlador_cerrar_sesion.php" class="menu-item logout-btn">Salir</a>
        </div>
    </nav>
    <footer class="bg-dark text-white text-center p-3 mt-auto">
        <div class="container">
            <p class="mb-1">Redes Sociales:
                <a href="#" class="text-danger">Facebook</a> |
                <a href="#" class="text-danger">Twitter</a> |
                <a href="#" class="text-danger">Instagram</a>
            </p>
            <p class="mb-0">C.A. Metro Los Teques</p>
        </div>
    </footer>

    <script src="../../JS/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
<nav class="sidebar bg-dark">
    <div class="sidebar-header">
        <h4 class="text-white mb-0"><strong>Menú Principal</strong></h4>
    </div>

    <div class="sidebar-menu">
        <div class="menu-section">
            <div class="menu-item user-info">
                <div class="user-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="user-icon">👤</span>
                        <h5 class="m-0"><strong>Usuario</strong></h5>
                    </div>
                    <i class="dropdown-icon"></i>
                </div>
                <div class="user-details">
                    <p class="m-1"><strong>Nombre:</strong> <?= $informacionUsuario ['nombre'] ?? 'No disponible' ?></p>
                    <p class="m-1"><strong>Perfil:</strong> <?= $informacionUsuario['perfil'] ?? 'No disponible' ?></p>
                    <p class="m-1"><strong>Carnet:</strong> <?= $informacionUsuario['carnet'] ?? 'No disponible' ?></p>
                    <p class="m-1"><strong>Servicio:</strong> <?= $informacionUsuario['servicio'] ?? 'No disponible' ?></p>
                </div>
            </div>
        </div>

        <div class="menu-section">
            <div class="menu-item registry-menu">
                <div class="menu-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="menu-icon">📝</span>
                        <h5 class="m-0"><strong>Registros</strong></h5>
                    </div>
                    <i class="dropdown-icon"></i>
                </div>
                <div class="submenu">
                    <a href="/metro/SGF/registrar_servicios/servicios/controlador/controlador_servicios.php" class="submenu-item"><strong>Servicios</strong></a>
                    <a href="/metro/SGF/registrar_servicios/subsistema/controlador/controlador_subsistema.php" class="submenu-item"><strong>Subsistemas</strong></a>
                    <a href="/metro/SGF/registrar_servicios/equipo/controlador/controlador_equipo.php" class="submenu-item"><strong>Equipos</strong></a>
                    <a href="/metro/SGF/registrar_servicios/ubicacion/controlador/controlador_ubicacion.php" class="submenu-item"><strong>ubicacion</strong></a>
                    <a href="/metro/SGF/registrar_servicios/ambiente/controlador/controlador_ambiente.php" class="submenu-item"><strong>Ambiente</strong></a>

                </div>
            </div>
        </div>

        <a href="#" class="menu-item"><strong>Descargas</strong></a>
        <a href="#" class="menu-item"><strong>Historial</strong></a>
        <a href="#" class="menu-item"><strong>Ayuda</strong></a>
        <a href="../../login/index.php" class="menu-item logout-btn"><strong>Salir</strong></a>
    </div>
</nav>

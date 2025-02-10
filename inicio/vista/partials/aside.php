<aside class="col-md-3 sidebar bg-dark text-white">
    <ul class="list-group list-group-flush">
        <li class="list-group-item dropdown">
            <a href="#" class="menu-item dropdown-toggle" data-toggle="dropdown">Información de usuario</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Perfil: <span><?= htmlspecialchars($informacionUsuario['perfil']) ?></span></a></li>
                <li><a class="dropdown-item" href="#">Carnet: <span><?= htmlspecialchars($informacionUsuario['usuario']) ?></span></a></li>
                <li><a class="dropdown-item" href="#">Nombre: <span><?= htmlspecialchars($informacionUsuario['nombre']) ?></span></a></li>
            </ul>
        </li>
        <li class="list-group-item dropdown">
            <a href="#" class="menu-item dropdown-toggle" data-toggle="dropdown">Gestionar</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Falla</a></li>
                <li><a class="dropdown-item" href="#">Registros</a></li>
            </ul>
        </li>
        <li class="list-group-item"><a href="#" class="menu-item">Descargas</a></li>
        <li class="list-group-item"><a href="#" class="menu-item">Historial</a></li>
        <li class="list-group-item"><a href="#" class="menu-item">Ayuda</a></li>
        <li class="list-group-item"><a href="../../login/controlador_cerrar_sesion.php" class="menu-item">Salir</a></li>
    </ul>
</aside>
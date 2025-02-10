
<?php
session_start();
include("../../conexion/conexion_bd.php");

if (empty($_SESSION["id_usuario"])) {

    header("Location:../../login/logins.php");

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipo</title>
    <link rel="stylesheet" href="registros.css">
</head>
<body>
<header>
        <section class="avatar">
            <img src="../../imagen/fondo1.jpg" alt="logo del metro"> <!-- Logo del proyecto -->
        </section>
        <h1 class="menu_logo">Centro de Control de Fallas</h1> <!-- Nombre del proyecto -->
        <div class="time" id="time"></div> <!-- Sección para mostrar la hora -->
    </header>

    <main>
    <section class="asideleft">
            <ul class="list">
                <li class="menu_item">
                    <a href="#" class="menu_link">Usuario</a>
                    <ul class="menu_nesting">
                    <li><label>Perfil: <span style="margin-left: 5px;"><?php echo $_SESSION["Perfil"] ?></span></label></li>
                        <li><label>Carnet: <span style="margin-left: 5px;"><?php echo $_SESSION["usuario"]; ?></span></label></li>
                        <li><label>Nombre: <span style="margin-left: 5px;"><?php echo $_SESSION["nombre_usuario"]; ?></span></label></li>
                        <li><label>Apellido: <span style="margin-left: 5px;"><?php echo $_SESSION["apellido_usuario"]; ?></span></label></li>
                    </ul>
                </li>

                <li class="menu_item">
                    <a href="#" class="menu_link">Gestionar Falla</a>
                    <ul class="menu_nesting">
                        <a href="#" class="menu_link" onclick="logActionAndRedirect('Abrir Falla', '../abrir/abrir.php?accion=Abrir Falla')">Abrir</a>
                        <a href="#" class="menu_link" onclick="logActionAndRedirect('Editar Falla', '../editar/editar.php?accion=Editar Falla')">Editar</a>
                        <li class="submenu">
                            <a href="#" class="menu_link">Consultar</a>
                            <ul class="menu_nesting2">
                                <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Consultar Falla', '../consultar/consulta.php?accion=Consultar Falla')">Consultar Falla</a></li>
                                <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Consultar Data', '../consultar/data.php?accion=Consultar Data')">Consultar Data</a></li>
                                <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Historial', '../historial/historial.php?accion=Estadísticas')">Historial</a></li>

                            </ul>
                        </li>
                    </ul>
                </li>

                
                <li class="menu_item">
                    <a href="#" class="menu_link">Gestionar registro</a> <!-- Enlace principal -->
                    <ul class="menu_nesting"> <!-- Submenú de "Gestionar registro" -->
                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Registrar Personal', '../registro/personal.php?accion=Registrar Personal')">Registrar Personal</a></li>

                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Registrar Servicio', '../registro/servicios.php?accion=Registrar Servicio')">Registrar Servicio</a></li>

                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Registrar Sub-Sistema', '../registro/subsistema.php?accion=Registrar Sub-Sistema')">Registrar Sub-Sistema</a></li>

                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Registrar Equipo', '../registro/equipo.php?accion=Registrar Equipo')">Registrar Equipo</a></li>

                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Registrar ubicacion', '../registro/ubicacion.php?accion=Registrar Ubicación')">Registrar Ubicación</a></li>

                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Registrar Acompañamiento', '../registro/acompañamiento.php?accion=Registrar Acompañamiento')">Registrar Acompañamiento</a></li>
                               
                    
                        
                    
                    </ul>
                </li>
                <li class="menu_item">
                    <a href="#" class="menu_link">Descargas</a> <!-- Enlace principal -->
                    <ul class="menu_nesting"> <!-- Submenú de "descargas" -->

                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Reportes', '../reporte/reporte.php?accion=Reportes')">Reportes</a></li>

                    <li><a href="#" class="menu_link" onclick="logActionAndRedirect('Estadísticas', '../estadistica/estadistica.php?accion=Estadísticas')">Estadísticas</a></li>

                  
                    </ul>
                </li>
                
                <li class="menu_item">
              <a href="#" class="menu_link" onclick="logActionAndRedirect('Ayuda', '../ayuda/ayuda.php?accion=Ayuda')">Ayuda</a>
                </li>


                <li class="menu_item">
                <a href="../../login/controlador_cerrar_sesion.php" class="menu_link">Salir</a> 
                </li>
            </ul>
        </section>

        <section class="article">
            <article>

            <?php 

include("../../conexion/conexion_bd.php");
include("ingresar_equipo.php");

?>
                <form method="post" action="ingresar_equipo.php"> <!-- Formulario para enviar datos -->
                    <div class="caja">

                        <div class="grupo">
                            <h3 class="etiqueta">Equipo</h3>
                            <label for="equipo">Nombre:</label>
                            <input type="text" class="input" id="equipo" name="equipo" required> <!-- Campo de entrada para equipo -->

                            <label for="id_equipo_subsistema">Código Subsistema:</label>
                            <input type="text" class="input" id="id_equipo_subsistema" name="id_equipo_subsistema" required> <!-- Campo de entrada para código de sub-sistema -->
                        </div>

                        <br>
                        <div class="botones">

                            <button name="btnregistrar" class="primero" type="submit" value="REGISTRAR">REGISTRAR</button><!-- Botón para enviar el formulario -->

                            <a href="../inicio/inicio.php"class="segundo">REGRESAR</a></button>
                        </div>
                        </div>
                    </form>
            </article>
        </section>
    </main>

    <script>
    function logActionAndRedirect(accion, url) {
    // Send AJAX request to log the action
    const xhr = new XMLHttpRequest();
    
    // Get the user's profile from PHP session
    const perfil = encodeURIComponent('<?php echo $_SESSION["Perfil"]; ?>'); // Asegúrate de que 'Perfil' esté en la sesión

    xhr.open('GET', `../historial/log_action.php?accion=${encodeURIComponent(accion)}&nombre_personal=${encodeURIComponent('<?php echo $_SESSION["nombre_usuario"]; ?>')}&apellido_personal=${encodeURIComponent('<?php echo $_SESSION["apellido_usuario"]; ?>')}&perfil=${perfil}`, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                // Redirect to the URL after logging
                window.location.href = url;
            } else {
                alert('Error al registrar la acción: ' + response.message);
            }
        } else {
            alert('Error en la solicitud: ' + xhr.statusText);
        }
    };

    xhr.onerror = function() {
        alert('Error de conexión.');
    };

    xhr.send();
}

        // Script para mostrar la hora actual
        function updateTime() {
            const now = new Date(); // Obtiene la fecha y hora actual
            const options = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }; // Formato de la hora y fecha
            document.getElementById('time').textContent = now.toLocaleString('es-ES', options); // Muestra la hora y fecha en el formato especificado
        }
        setInterval(updateTime, 1000); // Actualiza la hora cada segundo
        updateTime(); // Llama a la función inmediatamente para mostrar la hora al cargar la página
</script>
</body>
</html>
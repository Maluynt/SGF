<!--?php
session_start();
include("conexion_bd.php");
include("ModeloUsuario.php");

if (empty($_SESSION["id_usuario"])) {
    header("Location:../abrir/vista_inicio.php");
    exit();
}

// Obtener información del usuario
$informacionUsuario = ModeloUsuario::obtenerInformacionUsuario();
?-->
<?php

//include ('../../login/validar_sesion.php');

// Incluye el archivo de conexión a la base de datos
include('conexion_bd.php');
// Incluye el archivo para insertar datos (si es necesario)
include('insertar.php');

// Realiza una consulta para obtener todos los registros de personal
$reportada_por = $mysqli->query("SELECT * FROM personal WHERE responsabilidad='operativo' OR responsabilidad='operativo_ccf'");
if (!$reportada_por) {
    echo "Error en la consulta: " . $mysqli->error;
}

// Consulta para obtener personal con responsabilidad 'operativo_ccf'
$recibida_ccf = $mysqli->query("SELECT * FROM personal WHERE responsabilidad='operativo_ccf'");
$servicio = $mysqli->query("SELECT * FROM servicio");
$reportada_a = $mysqli->query("SELECT * FROM personal WHERE responsabilidad='operativo' OR responsabilidad='operativo_ccf'");
if (!$reportada_a) {
    echo "Error en la consulta: " . $mysqli->error;
}

// Consulta para obtener personal con responsabilidad 'tecnico'
$tecnico = $mysqli->query("SELECT * FROM personal WHERE responsabilidad='tecnico'");
$acompañamiento = $mysqli->query("SELECT * FROM acompañamiento");
$cerrada_por = $mysqli->query("SELECT * FROM personal WHERE responsabilidad='operativo' OR responsabilidad='operativo_ccf'");
if (!$cerrada_por) {
    echo "Error en la consulta: " . $mysqli->error;
}

// Consulta para obtener personal 'operativo_ccf'
$cerrada_ccf = $mysqli->query("SELECT * FROM personal WHERE responsabilidad='operativo_ccf'");
$ubicacion = $mysqli->query("SELECT * FROM ubicacion");
$responsable = $mysqli->query("SELECT * FROM personal WHERE responsabilidad='operativo' OR responsabilidad='operativo_ccf'");
if (!$responsable) {
    echo "Error en la consulta: " . $mysqli->error;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Control de Fallas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="abrir.css">
</head>

<body>
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

            <main class="col-md-9 content-area">
    <div class="container">
        <h2 class="mt-4">Abrir Falla</h2>
        <form method="post" action="">
            <?php
            // Generar ID de falla
            date_default_timezone_set("America/Caracas");
            $año = date('Y');
            $mes = date('m');

            // Contador para IDs en el mes actual
            $contador = 1;
            $resultado = $mysqli->query("SELECT id_falla FROM falla WHERE id_falla LIKE '$año$mes%'");
            while ($row = $resultado->fetch_assoc()) {
                $contador++;
            }

            // Generar el nuevo ID
            $id_falla = "$año$mes" . str_pad($contador, 3, '0', STR_PAD_LEFT);
            ?>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <br>
                    <p>Última falla registrada: <strong><?php echo substr($id_falla - 1, -10); ?></strong></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="id_falla" title="Código único de la falla.">Código de falla</label>
                    <input type="text" class="form-control" name="id_falla" value="<?= $id_falla ?>" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="hora_fecha" title="Fecha y hora en que se abre la falla.">Fecha y Hora de Apertura</label>
                    <input type="datetime-local" class="form-control" name="hora_fecha" value="<?= date('Y-m-d\TH:i') ?>" readonly>
                    <input type="hidden" id="fecha_apertura" value="<?= date('Y-m-d H:i:s') ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="fecha_hora_cierre">Hora y Fecha de Cierre</label>
                    <input type="text" class="form-control" name="fecha_hora_cierre" placeholder="fecha de cierre" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dias_falla">Días de Falla</label>
                    <input type="text" class="form-control" name="dias_falla" placeholder="Días de Falla" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="metodo_reporte">Método de Reporte</label>
                    <select class="form-control" name="metodo_reporte" id="metodo_reporte" required>
                        <option value="">Seleccionar</option>
                        <option value="Email">Email</option>
                        <option value="Llamada">Llamada</option>
                        <option value="Telegram">Telegram</option>
                        <option value="WhatsApp">WhatsApp</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="recibida_ccf">Recibida CCF</label>
                    <select class="form-control" name="recibida_ccf" id="recibida_ccf" required>
                        <option value="">Seleccionar</option>
                        <?php while ($row = $recibida_ccf->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="reportada_por">Reportada Por</label>
                    <select class="form-control" name="reportada_por" id="reportada_por" required>
                        <option value="">Seleccionar</option>
                        <?php while ($row = $reportada_por->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="servicio">Servicio</label>
                    <select class="form-control" name="servicio" id="servicio" required>
                        <option value="">Seleccionar</option>
                        <?php while ($row = $servicio->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_servicio']; ?>"><?php echo $row['nombre_servicio']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="sub_sistema">Sub Sistema</label>
                    <select class="form-control" name="sub_sistema" id="sub_sistema" required>
                        <option value="">Seleccionar</option>
                    </select>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-primary" type="submit" name="btnguardar" value="GUARDAR">GUARDAR</button>
                <a href="../inicio/inicio.php" class="btn btn-secondary">CANCELAR</a>
                <br>
                <br>
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
    
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
include "controlador/Controlador.php";

$controlador = new Controlador($pdo);
$datos = $controlador->obtenerDatosFormulario();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Centro de Control de Fallas</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/estilo.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
      <aside class="col-md-3 sidebar text-white">
          <ul class="list-group list-group-flush">
              <li class="list-group-item dropdown">
                  <a href="#" class="menu-item dropdown-toggle" data-toggle="dropdown">Información de usuario</a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Perfil: <span>Usuario</span></a></li>
                      <li><a class="dropdown-item" href="#">Carnet: <span>123456</span></a></li>
                      <li><a class="dropdown-item" href="#">Nombre: <span>Juan Pérez</span></a></li>
                  </ul>
              </li>
              <li class="list-group-item"><a href="#" class="menu-item">Salir</a></li>
          </ul>
      </aside>

      <main class="col-md-9 content-area">
          <div class="container">
              <h2 class="mt-4">Abrir Falla</h2>
              <form method="post" action="">
                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="ultimo_codigo">Última falla registrada</label>
                          <input type="text" class="form-control" id="ultimo_codigo" value="<?php echo substr($datos['id_falla'] - 1, -10); ?>" readonly>
                      </div> 
                      <div class="form-group col-md-6">
                          <label for="id_falla">Código de falla</label>
                          <input type="text" class="form-control" name="id_falla" id="id_falla" value="<?= $datos['id_falla'] ?>" readonly>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="hora_fecha">Fecha y Hora de Apertura</label>
                          <input type="datetime-local" class="form-control" name="hora_fecha" id="hora_fecha" value="<?= date('Y-m-d\TH:i') ?>" readonly>
                          <input type="hidden" id="fecha_apertura" value="<?= date('Y-m-d H:i:s') ?>"> 
                      </div>
                      <div class="form-group col-md-6">
                          <label for="recibida_ccf">Recibida CCF</label>
                          <input type="text" class="form-control" name="recibida_ccf" id="recibida_ccf" value="">
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="reportada_por">Reportada Por</label>
                          <select class="form-control" name="reportada_por" id="reportada_por" required>
                              <option value="">Seleccionar</option>
                              <?php foreach ($datos['reportada_por'] as $option): ?>
                                  <option value="<?= $option['id_personal'] ?>"> <?= $option['carnet'] . ' - ' . $option['nombre_personal'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="metodo_reporte">Método de Reporte</label>
                          <select class="form-control" name="metodo_reporte" id="metodo_reporte" required>
                              <option value="">Seleccionar</option>
                              <?php foreach ($datos['metodo_reporte'] as $option): ?>
                                  <option value="<?= $option['id_reporte'] ?>"> <?= $option['metodo_reporte'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="ubicacion">Ubicación</label>
                          <select class="form-control" name="ubicacion" id="ubicacion" required>
                              <option value="">Seleccionar</option>
                              <?php foreach ($datos['ubicacion'] as $option): ?>
                                  <option value="<?= $option['id_ubicacion'] ?>"> <?= $option['ubicacion'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="ambiente">Ambiente</label>
                          <select class="form-control" name="ambiente" id="ambiente" required>
                              <option value="">Seleccionar</option>
                          </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="servicio">Servicio</label>
                          <select class="form-control" name="servicio" id="servicio" required>
                              <option value="">Seleccionar</option>
                              <?php foreach ($datos['servicio'] as $option): ?>
                                  <option value="<?= $option['id_servicio'] ?>"> <?= $option['nombre_servicio'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="sub_sistema">Sub Sistema</label>
                          <select class="form-control" name="sub_sistema" id="sub_sistema" required>
                              <option value="">Seleccionar</option>
                          </select>
                      </div> 
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="equipo">Equipo</label>
                          <select class="form-control" name="equipo" id="equipo" required>
                              <option value="">Seleccionar</option>
                          </select>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="responsable_area">Responsable de Área</label>
                          <select class="form-control" name="responsable_area" id="responsable_area" required>
                              <option value="">Seleccionar</option>
                              <?php foreach ($datos['responsable_area'] as $option): ?>
                                  <option value="<?= $option['id_personal'] ?>"><?= $option['carnet'] . ' - ' . $option['nombre_personal'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="prioridad">Prioridad</label>
                          <select class="form-control" name="prioridad" id="prioridad" required>
                              <option value="">Seleccionar</option>
                              <?php foreach ($datos['prioridad'] as $option): ?>
                                  <option value="<?= $option['id_prioridad'] ?>"> <?= $option['prioridad'] ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="estado">Estado</label>
                          <select class="form-control" name="estado" id="estado" required readonly>
                              <option value="3" selected>Abierta</option>
                          </select>
                      </div>
                  </div>

                  <div class="form-row">
                      <div class="form-group col-md-12">
                          <label for="descripcion_falla">Descripción de la Falla</label>
                          <input type="text" class="form-control" name="descripcion_falla" id="descripcion_falla" required>
                      </div>
                  </div>

                  <div class="text-center">
                      <button class="btn btn-primary" type="submit" name="btnguardar" value="GUARDAR">GUARDAR</button>
                      <a href="../inicio/inicio.php" class="btn btn-secondary">CANCELAR</a>
                      <br><br>
                  </div>
              </form>
          </div>
      </main>
  </div>
</div>

<footer class="bg-dark text-white text-center p-3">
  <p>C.A. Metro Los Teques</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
<script src="js/peticiones.js"></script>
</body>
</html>

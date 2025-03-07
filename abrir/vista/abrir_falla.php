<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php'; ?>





<main class="main-content">
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
                    <input type="text" class="form-control"
                        value="<?= htmlspecialchars($informacionUsuario['nombre'] ?? 'Usuario no identificado') ?>"
                        readonly>
                    <input type="hidden" name="recibida_ccf"
                        value="<?= $_SESSION['id_usuario'] ?? '' ?>">
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
                <!-- Campo de servicio (debe ser no editable) -->
                <div class="form-group col-md-6">
    <label for="servicio">Servicio</label>
    <!-- Input visible (solo lectura) -->
    <input type="text" 
           class="form-control"
           value="<?= htmlspecialchars($datos['servicio'][0]['nombre_servicio'] ?? 'No asignado') ?>" 
           readonly> <!-- Solo aquí aplica readonly -->
    
    <!-- Campos ocultos (no necesitan readonly) -->
    <input type="hidden" name="servicio" value="<?= $_SESSION['id_servicio'] ?? '' ?>">
    <input type="hidden" id="id_servicio" name="id_servicio" value="<?= $_SESSION['id_servicio'] ?? '' ?>">
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




<script src="/metro/SGF/abrir/js/peticiones.js"></script>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
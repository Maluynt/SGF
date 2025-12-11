<?php
// Verificación de seguridad mejorada
if (!defined('VISTA_SEGURA') || VISTA_SEGURA !== true) {
    die('Acceso prohibido - El Metro de Los Teques');
}
define('INCLUIDO_SEGURO', true);
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php';
?>

<main class="main-content">
    <div class="container">
        <h2 class="mt-4">Abrir Falla</h2>
        
        <!-- Sección de mensajes -->
        <div class="mensajes-container">
            <?php if (isset($_SESSION['exito'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['exito']) ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['exito']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>

        <form method="post" action="" class="needs-validation" novalidate>
            <input type="hidden" name="csrf_token" value="<?= generarTokenCSRF() ?>">
            
            <!-- Sección de códigos -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ultimo_codigo"><i class="fas fa-barcode"></i> Última falla registrada</label>
                    <input type="text" class="form-control bg-light" id="ultimo_codigo" 
                           value="<?= isset($id_falla) ? substr($id_falla - 1, -10) : 'N/A' ?>" 
                           readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="id_falla"><i class="fas fa-qrcode"></i> Código de falla</label>
                    <input type="text" class="form-control bg-light" id="id_falla" 
                           value="<?= htmlspecialchars($id_falla ?? 'Generando...') ?>" 
                           readonly>
                </div>
            </div>

            <!-- Sección de fecha y responsable -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="hora_fecha"><i class="fas fa-calendar-alt"></i> Fecha y Hora de Apertura</label>
                    <input type="datetime-local" class="form-control" 
                           name="hora_fecha" 
                           value="<?= date('Y-m-d\TH:i') ?>" 
                           readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="recibida_ccf"><i class="fas fa-user-shield"></i> Recibida CCF</label>
                    <input type="text" class="form-control bg-light"
                           value="<?= htmlspecialchars($informacionUsuario['nombre']) ?>" 
                           readonly>
                    <input type="hidden" name="recibida_ccf"
                           value="<?= $informacionUsuario['id_usuario'] ?>">
                </div>
            </div>

            <!-- Sección de reporte -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="reportada_por"><i class="fas fa-user-edit"></i> Reportada Por</label>
                    <select class="form-control select2" name="reportada_por" id="reportada_por" required>
                        <option value="">Seleccionar personal...</option>
                        <?php foreach ($reportada_por as $option): ?>
                            <option value="<?= $option['id_personal'] ?>"
                                <?= ($datosFormulario['reportada_por'] ?? '') == $option['id_personal'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($option['carnet'] . ' - ' . $option['nombre_personal']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione quien reporta la falla</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="metodo_reporte"><i class="fas fa-comment-dots"></i> Método de Reporte</label>
                    <select class="form-control select2" name="metodo_reporte" id="metodo_reporte" required>
                        <option value="">Seleccionar método...</option>
                        <?php foreach ($metodo_reporte as $option): ?>
                            <option value="<?= $option['id_reporte'] ?>"
                                <?= ($datosFormulario['metodo_reporte'] ?? '') == $option['id_reporte'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($option['metodo_reporte']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione el método de reporte</div>
                </div>
            </div>

            <!-- Sección de ubicación -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</label>
                    <select class="form-control select2" name="ubicacion" id="ubicacion" required>
                        <option value="">Seleccionar ubicación...</option>
                        <?php foreach ($ubicacion as $option): ?>
                            <option value="<?= $option['id_ubicacion'] ?>"
                                <?= ($datosFormulario['ubicacion'] ?? '') == $option['id_ubicacion'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($option['ubicacion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione la ubicación</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="ambiente"><i class="fas fa-building"></i> Ambiente</label>
                    <select class="form-control select2" name="ambiente" id="ambiente" required>
                        <option value="">Primero seleccione una ubicación</option>
                    </select>
                    <div class="invalid-feedback">Seleccione el ambiente</div>
                </div>
            </div>

            <!-- Sección de sistema -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="servicio"><i class="fas fa-cogs"></i> Servicio</label>
                    <?php if (count($servicio) > 1): ?>
                        <select class="form-control select2" name="servicio" id="servicio" required>
                            <?php foreach ($servicio as $serv): ?>
                                <option value="<?= $serv['id_servicio'] ?>"
                                    <?= ($datosFormulario['servicio'] ?? '') == $serv['id_servicio'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($serv['nombre_servicio']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="text" class="form-control bg-light"
                               value="<?= htmlspecialchars($servicio[0]['nombre_servicio'] ?? 'No asignado') ?>"
                               readonly>
                        <input type="hidden" name="servicio" 
                               value="<?= $servicio[0]['id_servicio'] ?? '' ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="sub_sistema"><i class="fas fa-network-wired"></i> Sub Sistema</label>
                    <select class="form-control select2" name="sub_sistema" id="sub_sistema" required>
                        <option value="">Primero seleccione servicio y ambiente</option>
                    </select>
                    <div class="invalid-feedback">Seleccione el subsistema</div>
                </div>
            </div>

            <!-- Sección de equipo y responsable -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="equipo"><i class="fas fa-toolbox"></i> Equipo</label>
                    <select class="form-control select2" name="equipo" id="equipo" required>
                        <option value="">Primero seleccione un subsistema</option>
                    </select>
                    <div class="invalid-feedback">Seleccione el equipo</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="responsable_area"><i class="fas fa-user-tie"></i> Responsable de Área</label>
                    <select class="form-control select2" name="responsable_area" id="responsable_area" required>
                        <option value="">Seleccionar responsable...</option>
                        <?php foreach ($responsable_area as $option): ?>
                            <option value="<?= $option['id_personal'] ?>"
                                <?= ($datosFormulario['responsable_area'] ?? '') == $option['id_personal'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($option['carnet'] . ' - ' . $option['nombre_personal']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione el responsable</div>
                </div>
            </div>

            <!-- Sección de prioridad y estado -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="prioridad"><i class="fas fa-exclamation-triangle"></i> Prioridad</label>
                    <select class="form-control select2" name="prioridad" id="prioridad" required>
                        <option value="">Seleccionar prioridad...</option>
                        <?php foreach ($prioridad as $option): ?>
                            <option value="<?= $option['id_prioridad'] ?>"
                                <?= ($datosFormulario['prioridad'] ?? '') == $option['id_prioridad'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($option['prioridad']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione la prioridad</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="estado"><i class="fas fa-power-off"></i> Estado</label>
                    <select class="form-control bg-light" name="estado" id="estado" readonly>
                        <option value="3" selected>Abierta</option>
                    </select>
                </div>
            </div>

            <!-- Descripción de la falla -->
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="descripcion_falla"><i class="fas fa-file-alt"></i> Descripción de la Falla</label>
                    <textarea class="form-control" name="descripcion_falla" id="descripcion_falla" 
                              rows="3" required
                              placeholder="Describa la falla en detalle (mínimo 10 caracteres)..."><?= htmlspecialchars($datosFormulario['descripcion_falla'] ?? '') ?></textarea>
                    <div class="invalid-feedback">La descripción debe tener al menos 10 caracteres</div>
                    <small class="form-text text-muted">
                        Ejemplo: "El equipo presenta fallas intermitentes en el sistema de enfriamiento"
                    </small>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="form-group text-center mt-5">
                <button type="submit" class="btn btn-primary btn-lg" name="btnguardar">
                    <i class="fas fa-save"></i> Guardar Reporte
                </button>
               
                            <a href="/metro/SGF/inicio/controlador/controlador_inicio.php" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</main>

<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; 
?>
<?php


if (!isset($esVistaSegura) || $esVistaSegura !== true) {
    die('Acceso prohibido - Sistema de Gestión de Fallas');
}
define('INCLUIDO_SEGURO', true);
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php';
?>

<main class="main-content">
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header card-header-custom">
                <h3 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Editar Falla #<?= htmlspecialchars((string)($falla['id_falla'] ?? 'N/A')) ?>
                </h3>
            </div>

            <div class="card-body">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['exito'])): ?>
    <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
    <?php unset($_SESSION['exito']); ?>
<?php endif; ?>

                <form method="POST" action="/metro/SGF/reporte/controlador/controlador_editar.php" class="needs-validation" novalidate>
                    <input type="hidden" name="id_falla" value="<?= htmlspecialchars($falla['id_falla']) ?>">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="row g-3">
                        <!-- Intervenciones -->
                        <div class="col-md-12">
                            <div class="intervenciones-container">
                                <div class="input-group intervenciones">
                                    <span class="input-group-text">Intervenciones</span>
                                    <input type="number"
                                        class="form-control input-intervencion"
                                        value="<?= htmlspecialchars($falla['n_intervencion'] ?? 1) ?>"
                                        readonly>
                                    <button type="button"
                                        class="btn btn-success btn-intervencion"
                                        onclick="incrementarIntervencion(<?= $falla['id_falla'] ?>)">
                                        <i class="fas fa-plus"></i> +
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Justificación -->
                        <div class="col-md-12">
                            <label class="form-label">Justificación
                                <span class="text-danger requerido-justificacion" style="display: none;">*</span>
                            </label>
                            <textarea class="form-control" name="justificacion" id="justificacion" rows="3"><?= 
                                htmlspecialchars(trim($falla['justificacion'] ?? '')) 
                            ?></textarea>
                            <div class="invalid-feedback" id="error-justificacion"></div>
                        </div>

                        <!-- Solución -->
                        <div class="col-md-12">
                            <label class="form-label">Solución</label>
                            <textarea class="form-control" name="solucion" rows="3" required><?= 
                                htmlspecialchars(trim($falla['solucion'] ?? '')) 
                            ?></textarea>
                        </div>

                        <!-- Selectores en una sola fila -->
                        <div class="row g-3">
                            <!-- Prioridad -->
                            <div class="col-md-4">
                                <label class="form-label">Prioridad</label>
                                <select class="form-select" name="prioridad" required>
                                    <?php foreach ($prioridades as $p): ?>
                                        <option value="<?= htmlspecialchars((string)$p['id_prioridad']) ?>"
                                            <?= ((int)$p['id_prioridad'] === (int)($falla['id_prioridad'] ?? 0)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['prioridad']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="estado" id="estadoSelect" required>
                                    <?php foreach ($estados as $e): ?>
                                        <option value="<?= htmlspecialchars($e['id_estado']) ?>"
                                            data-nombre="<?= htmlspecialchars($e['estado']) ?>"
                                            <?= ((int)$e['id_estado'] === (int)($falla['id_estado'] ?? 0)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($e['estado']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Acompañamiento -->
                            <div class="col-md-4">
                                <label class="form-label">Acompañamiento</label>
                                <select class="form-select" name="id_acompañamiento" required>
                                    <?php foreach ($acompañamientos as $eq): ?>
                                        <option value="<?= htmlspecialchars($eq['id_acompañamiento']) ?>"
                                            <?= ((int)$eq['id_acompañamiento'] === (int)($falla['id_acompañamiento'] ?? 0)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($eq['acompañamiento']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                                        
                        <!-- Botones de acción -->
                        <div class="mt-4 d-flex justify-content-between">

                            <a href="/metro/SGF/reporte/controlador/controlador_consulta.php"
                                class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <tab></tab>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </div>
                    <script src="/metro/SGF/consulta/js/script_val.js">
                    </script>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
  function incrementarIntervencion(idFalla) {
    fetch('/metro/SGF/reporte/controlador/controlador_editar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id_falla=${idFalla}&incrementar_intervencion=1&csrf_token=<?= $csrf_token ?>`
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url; // Forzar recarga completa
        } else {
            response.text().then(text => {
                if (!response.ok) throw new Error(text);
                location.reload(); // Recarga si no hubo redirección
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
}
</script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php';
?>
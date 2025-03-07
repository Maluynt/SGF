<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/modelo/modelo_consulta.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php';

// Validación del ID
if (!isset($_GET['id']) || empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    $_SESSION['error'] = "ID inválido";
    header("Location: vista_consulta.php");
    exit();
}

if (!isset($pdo)) {
    die("Error de conexión a la base de datos");
}

$modelo = new FallaModel($pdo);
$falla = $modelo->obtenerFallaPorId((int)$_GET['id']);

if (!$falla) {
    $_SESSION['error'] = "Falla no encontrada";
    header("Location: lista_fallas.php");
    exit();
}

$opciones = [
    'prioridades' => $modelo->obtenerPrioridades(),
    'estados' => $modelo->obtenerEstados(),
    'acompañamientos' => $modelo->obtenerAcompañamiento()
];
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

                <form method="POST" action="/metro/SGF/consulta/controlador/controlador_editar.php" class="needs-validation" novalidate>
                    <input type="hidden" name="id_falla" value="<?= htmlspecialchars($falla['id_falla']) ?>">

                    <div class="row g-3">

                        <!-- Dentro del div class="row g-3" -->
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
                                        <i class="fas fa-plus"></i>
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <!-- Campos de texto -->
                        <div class="col-md-12">
                            <label class="form-label">Justificación</label>
                            <textarea class="form-control" name="justificacion" rows="3" required><?=
                                                                                                    htmlspecialchars(trim($falla['justificacion'] ?? '')) ?></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Solución</label>
                            <textarea class="form-control" name="solucion" rows="3" required><?=
                                                                                                htmlspecialchars(trim($falla['solucion'] ?? '')) ?></textarea>
                        </div>

                        <!-- Selectores -->
                        <div class="col-md-4">
                            <label class="form-label">Prioridad</label>
                            <select class="form-select" name="prioridad" required>
                                <?php foreach ($opciones['prioridades'] as $p): ?>
                                    <option value="<?= htmlspecialchars((string)$p['id_prioridad']) ?>"
                                        <?= ((int)$p['id_prioridad'] === (int)($falla['id_prioridad'] ?? 0)) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['prioridad']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado" required>
                                <?php foreach ($opciones['estados'] as $e): ?>
                                    <option value="<?= htmlspecialchars($e['id_estado']) ?>"
                                        <?= ((int)$e['id_estado'] === (int)($falla['id_estado'] ?? 0)) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($e['estado']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Acompañamiento</label>
                            <select class="form-select" name="id_acompañamiento" required>
                                <?php foreach ($opciones['acompañamientos'] as $eq): ?>
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
                        <a href="/metro/SGF/consulta/controlador/controlador_consulta.php"
                            class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    function incrementarIntervencion(idFalla) {
        fetch('/metro/SGF/consulta/controlador/controlador_editar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_falla=${idFalla}&incrementar_intervencion=1`
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error al actualizar las intervenciones');
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php';
?>
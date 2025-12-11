
<?php
// seguridad_vista.php
if (!isset($esVistaSegura) || $esVistaSegura !== true) {
    die('Acceso prohibido - El Metro de Los Teques');
}


?>
<?php define('INCLUIDO_SEGURO', true);
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; 

include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php'; ?>

<main class="main-content">
    <div class="container mt-5">
        <h2 class="text-center">Registrar Sub-sistema</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['exito']) ?></div>
            <?php unset($_SESSION['exito']); ?>
        <?php endif; ?>

        <form method="post" action="../controlador/controlador_subsistema.php">
            <div class="form-group">
                <label for="ambientes">Ambiente Padre:</label>
                <select class="form-control" name="id_ambiente" id="ambientes" required>
                    <option value="">Seleccione un ambiente</option>
                    <?php if (!empty($ambientes)): ?>
                        <?php foreach ($ambientes as $ambiente): ?>
                            <option value="<?= htmlspecialchars($ambiente['id_ambiente']) ?>">
                                <?= htmlspecialchars($ambiente['ambiente']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay ambientes disponibles</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Nombre del Subsistema:</label>
                <input type="text" class="form-control" name="nombre_subsistema" required>
            </div>

            <div class="text-center">
                <button name="btnregistrar" class="btn btn-primary" type="submit" value="REGISTRAR">REGISTRAR</button>
                <a href="/metro/SGF/inicio/controlador/controlador_inicio.php"
                                class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
            </div>
        </form>
    </div>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
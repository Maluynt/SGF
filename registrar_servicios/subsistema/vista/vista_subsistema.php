<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/siderbar.php'; ?>


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
                <a href="../inicio/inicio.php" class="btn btn-secondary">REGRESAR</a>
            </div>
        </form>
    </div>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
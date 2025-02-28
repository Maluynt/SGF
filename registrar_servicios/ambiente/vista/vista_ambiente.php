<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>




<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/siderbar.php'; ?>


<main class="main-content">

    <div class="container mt-5">

        <h2 class="text-center">Registrar Ambiente</h2>


        

            
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['exito'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
                    <?php unset($_SESSION['exito']); ?>
                <?php endif; ?>

                <form method="post" action="../controlador/controlador_ambiente.php">
                    <div class="form-group">
                        <label>Ubicación Padre:</label>
                        <select class="form-control" name="id_ubicacion" required>
                            <option value="">Seleccione ubicación</option>
                            <?php foreach ($ubicaciones as $ubicacion): ?>
                                <option value="<?= $ubicacion['id_ubicacion'] ?>">
                                    <?= htmlspecialchars($ubicacion['ubicacion']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>jg
                    </div>

                    <div class="form-group">
                        <label>Nombre del Ambiente:</label>
                        <input type="text" class="form-control" name="ambiente" required>
                    </div>

                    <div class="text-center mt-4">
                        <button name="btnregistrar" class="btn btn-primary" type="submit">
                            REGISTRAR
                        </button>
                        <a href="../inicio/inicio.php" class="btn btn-secondary">REGRESAR</a>
                    </div>
                </form>
            
      

    </div>

    </div>
</main>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
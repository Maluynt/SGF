
<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php'; ?>

            <main class="main-content">
            <div class="container mt-5">
            <h2 class="text-center">Registrar Ubicación</h2>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['exito'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
                    <?php unset($_SESSION['exito']); ?>
                <?php endif; ?>

                <form method="post" action="../controlador/controlador_ubicacion.php">
                  
                    <div class="form-group">
                        <label for="id_ubicacion">Nombre del ubicacion:</label>
                        <input type="text" class="form-control" name="ubicacion" required>
                    </div>

                    <div class="text-center">
                                <button name="btnregistrar" class="btn btn-primary" type="submit" value="REGISTRAR">REGISTRAR</button> <!-- Botón para enviar el formulario -->
                                    <a href="../inicio/inicio.php" class="btn btn-secondary">REGRESAR</a>
                                </div>
                </form>
            </div>
            </main>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>

     

<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/siderbar.php'; ?>

            <main class="main-content">
                <div class="container mt-5">
                    <h2 class="text-center">Registrar Servicios</h2>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['exito'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
                        <?php unset($_SESSION['exito']); ?>
                    <?php endif; ?>
                    <form method="post" action="../controlador/controlador_servicios.php"> <!-- El formulario apunta al mismo controlador -->
                        
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="id_servicio">Nombre:</label>
                                    <input type="text" class="form-control" id="id_servicio" name="servicio" required>
                                </div>

                                <div class="text-center">
                                    <button name="btnregistrar" class="btn btn-primary" type="submit" value="REGISTRAR">REGISTRAR</button>
                                    <a href="../../../Administrador/vistas/index.php" class="btn btn-secondary">REGRESAR</a>
                                </div>
                            </div>
                       
                    </form>
                </div>
            </main>
        
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>

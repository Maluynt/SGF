<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/siderbar.php'; ?>

<main class="main-content">
                <div class="container mt-5">
                    <h3 class="text-center">Registrar Personal</h3>
                    <form method="post" action="/metro/SGF/personal/controlador/controladordepersonal.php" class="mx-auto" style="max-width: 500px;">
                        <div class="form-group">
                            <label for="N-Carnet">Nº Carnet:</label>
                            <input type="text" id="N-Carnet" name="N-Carnet" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="nombre_apellido">Nombre:</label>
                            <input type="text" id="nombre_apellido" name="nombre_apellido" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="contacto">Contacto:</label>
                            <input type="text" id="contacto" name="contacto" class="form-control" required>
                        </div>

                        <div class="button-group text-center">
                            <button name="btnregistrar" type="submit" class="btn btn-danger" value="Registrar">Registrar</button>
                            <a href="#" class="btn btn-secondary">Regresar</a>
                        </div>
                    </form>
                </div>
            </main>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
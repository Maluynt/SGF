
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
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nombre del Ambiente:</label>
                        <input type="text" class="form-control" name="ambiente" required>
                    </div>

                    <div class="text-center mt-4">
                        <button name="btnregistrar" class="btn btn-primary" type="submit">
                            REGISTRAR
                        </button>
                        <a href="/metro/SGF/inicio/controlador/controlador_inicio.php"
                                class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                    </div>
                </form>
            
      

    </div>

    </div>
</main>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
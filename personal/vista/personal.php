
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
    <!-- Sección de mensajes -->
    <?php if (isset($exito)): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
        <?= htmlspecialchars($exito) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3 mx-3" role="alert">
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
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
                            <a href="/metro/SGF/inicio/controlador/controlador_inicio.php"
                                class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </main>
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
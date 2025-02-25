<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/siderbar.php'; ?>

<main class="main-content">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 content-area">
                <h2 class="text-primary">Bienvenido al Sistema</h2>
                <div class="card mt-3">
                    <div class="card-body">
                        <p class="card-text">Contenido principal de la aplicación</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
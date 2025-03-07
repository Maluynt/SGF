<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php'; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/consulta/controlador/controlador_consulta.php'; ?>


<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
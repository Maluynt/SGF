<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/siderbar.php'; ?>

<main class="main-content">
    <div class="container mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif (empty($fallas)): ?>
            <div class="alert alert-warning">No hay registros de fallas.</div>
        <?php else: ?>
            <div class="scrollable">

                <table class="table table-bordered">
                    <thead class="header-table">
                        <div class="header-table">
                            <h4 class=" height: 100vh;">Registro de Fallas Técnicas</h4>

                            <tr>
                                <th>ID</th>
                                <th>Justificación</th>
                                <th>Descripción</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>equipo</th>
                                <th>Personal Aten</th>
                                <th>Descripción</th>
                                <th>Fecha de reporte</th>
                                <th>Detalles de Ubicacion</th>
                                <th>Descripcion de falla</th>
                                <th>Fecha de Cierre</th>
                                <th>Días Abierta</th>

                            </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($fallas as $f):
                            if ($f === null) {
                                echo 'Ninguna';
                            } ?>
                            <tr>
                                <td><?= $f['id_falla'] !== null ? htmlspecialchars($f['id_falla']) : 'Ninguna' ?></td>
                                <td><?= $f['id_justificacion'] !== null ? htmlspecialchars($f['id_justificacion']) : 'Ninguna' ?></td>
                                <td><?= $f['id_prioridad'] !== null ? htmlspecialchars($f['id_prioridad']) : 'Ninguna' ?></td>
                                <td><?= $f['id_estado'] !== null ? htmlspecialchars($f['id_estado']) : 'Ninguna' ?></td>
                                <td><?= $f['id_equipo'] !== null ? htmlspecialchars($f['id_equipo']) : 'Ninguna' ?></td>
                                <td><?= $f['id_usuario'] !== null ? htmlspecialchars($f['id_usuario']) : 'Ninguna' ?></td>
                                <td><?= $f['fecha_hora_reporte'] !== null ? htmlspecialchars($f['fecha_hora_reporte']) : 'Ninguna' ?></td>
                                <td><?= $f['detalles_ubicacion'] !== null ? htmlspecialchars($f['detalles_ubicacion']) : 'Ninguna' ?></td>
                                <td><?= $f['descripcion_falla'] !== null ? htmlspecialchars($f['descripcion_falla']) : 'Ninguna' ?></td>
                                <td><?= $f['fecha_hora_cierre'] !== null ? htmlspecialchars($f['fecha_hora_cierre']) : 'Ninguna' ?></td>
                                <td><?= $f['dias_falla'] !== null ? htmlspecialchars($f['dias_falla']) : 'Ninguna' ?></td>



                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
        <?php endif; ?>

        <?php
        function all_elements_are_null($array)
        {
            foreach ($array as $element) {
                if ($element !== null) {
                    return false;
                }
            }
            return true;
        }
        ?>
    </div>

</main>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
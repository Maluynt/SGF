<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/siderbar.php'; 

// Configuración de campos visibles
$allowedFields = [
    'ID' => 'id_falla',
    'Descripción' => 'descripcion_falla',
    'Prioridad' => 'nombre_prioridad',
    'Estado' => 'nombre_estado',
    'Equipo' => 'nombre_equipo',
    'Subsistema' => 'nombre_subsistema',
    'Servicio' => 'nombre_servicio',
    'Ambiente' => 'nombre_ambiente',
    'Ubicación' => 'nombre_ubicacion',
    'Fecha Reporte' => 'fecha_hora_reporte',
    'Reportada por' => 'nombre_reportada_por',
    'Responsable del Area' => 'nombre_responsable_area',
    'Días Abierta' => 'dias_falla',
    'Fecha Cierre' => 'fecha_hora_cierre',
    'N.Intervension' => 'n_intervension',
    'Solucion' => 'solucion',
    'Metodo de reporte' => 'nombre_metodo_reporte',
];

// FILTROS ACTIVOS (Modifica este array para agregar/quitar filtros)
$activeFilters = [
    'Equipo' => 'nombre_equipo',
    'Subsistema' => 'nombre_subsistema',
    'Servicio' => 'nombre_servicio',
    'Ambiente' => 'nombre_ambiente',
    'Fecha Reporte' => 'fecha_hora_reporte',
    'ID' => 'id_falla',
    'Días Abierta' => 'dias_falla'
];

// Preparación de filtros
$filterOptions = [];
foreach ($activeFilters as $displayName => $fieldName) {
    $filterOptions[$fieldName] = array_unique(array_column($fallas, $fieldName));
}
?>

<main class="main-content">
    <div class="container mt-4">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php else: ?>
            <!-- SECCIÓN DE BUSQUEDA Y FILTROS -->
            <div class="filter-container">
                <div class="search-container mb-3">
                    <input type="text" id="searchInput" 
                        placeholder="Buscar en todos los campos..."
                        class="form-control">
                </div>

                <div class="filter-grid">
                    <?php foreach ($activeFilters as $displayName => $fieldName): ?>
                        <div class="filter-group">
                            <select class="filter-select" data-column="<?= $fieldName ?>">
                                <option value=""><?= $displayName ?></option>
                                <?php foreach ($filterOptions[$fieldName] as $value): ?>
                                    <option value="<?= htmlspecialchars($value) ?>">
                                        <?= htmlspecialchars($value) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <br>

            <!-- TABLA COMPLETA -->
            <div class="table-responsive-lg">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <?php foreach ($allowedFields as $displayName => $fieldName): ?>
                                <th class="align-middle sticky-header"><?= $displayName ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php foreach ($fallas as $falla): ?>
                            <tr>
                                <?php foreach ($allowedFields as $displayName => $fieldName): ?>
                                    <td class="align-middle">
                                        <?php
                                        $value = $falla[$fieldName] ?? null;
                                        echo $value !== null ? htmlspecialchars($value) : 'N/A';
                                        
                                        if($fieldName === 'nombre_prioridad' && isset($falla['color_prioridad'])) {
                                            echo '<div class="priority-indicator" 
                                                  style="background-color: '.$falla['color_prioridad'].'"></div>';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- PAGINACIÓN (mantenido igual) -->
            <div class="pagination-container mt-3 d-flex justify-content-center">
                <button class="btn btn-outline-primary mx-2" id="prevPage">Anterior</button>
                <span id="pageInfo" class="align-self-center mx-2">Página 1 de 5</span>
                <button class="btn btn-outline-primary mx-2" id="nextPage">Siguiente</button>
            </div>
        <?php endif; ?>
    </div>

    <script src="/metro/SGF/consulta/js/script.js">
    </script>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>



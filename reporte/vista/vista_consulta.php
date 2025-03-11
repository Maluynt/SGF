<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php';

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
    'N.Intervencion' => 'n_intervencion',
    'Solucion' => 'solucion',
    'Metodo de reporte' => 'nombre_metodo_reporte',
    'Acompañamiento' => 'acompañamiento',
];

// FILTROS ACTIVOS
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
        <?php if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['exito']); ?>
                <?php unset($_SESSION['exito']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!isset($error) || !$error): ?>
            <!-- SECCIÓN DE BUSQUEDA Y FILTROS -->
            <div class="filter-container">
                <div class="search-container mb-3">
                    <div class="row g-3 align-items-center">
                        <!-- Campo de búsqueda -->
                        <div class="col-12 col-md-4">
                            <input type="text" id="searchInput" 
                                   placeholder="Buscar en todos los campos..."
                                   class="form-control">
                        </div>
                        
                        <!-- Botones -->
                        <div class="col-12 col-md-auto">
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-outline-secondary" id="reloadPage"
                                        title="Recargar tabla completa" type="button">
                                    <i class="fas fa-sync-alt"></i> Restablecer
                                </button>
                                <button class="btn btn-danger" id="generatePdf">
                                    <i class="fas fa-file-pdf"></i> Generar PDF
                                </button>
                            </div>
                        </div>
                        
                        <!-- Fechas -->
                        <div class="col-12 col-md-4">
                            <div class="input-group">
                                <input type="date" id="fechaInicio" class="form-control">
                                <span class="input-group-text">a</span>
                                <input type="date" id="fechaFin" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros desplegables -->
                <div class="filter-grid row g-2 mb-3">
                    <?php foreach ($activeFilters as $displayName => $fieldName): ?>
                        <div class="filter-group col-6 col-md-4 col-lg-3">
                            <select class="form-select" data-column="<?= $fieldName ?>">
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

            <!-- TABLA -->
            <div class="table-responsive-lg">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="align-middle sticky-header">Acciones</th>
                            <?php foreach ($allowedFields as $displayName => $fieldName): ?>
                                <th class="align-middle sticky-header" data-column="<?= $fieldName ?>">
                                    <?= $displayName ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php foreach ($fallas as $falla): ?>
                            <tr>
                                <td class="align-middle">
                                    <a href="/metro/SGF/consulta/vista/editar_falla.php?id=<?= $falla['id_falla'] ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <?php foreach ($allowedFields as $displayName => $fieldName): ?>
                                    <td class="align-middle">
                                        <?php
                                        $value = $falla[$fieldName] ?? null;
                                        echo $value !== null ? htmlspecialchars($value) : 'N/A';

                                        if ($fieldName === 'nombre_prioridad' && isset($falla['color_prioridad'])) {
                                            echo '<div class="priority-indicator" 
                                                  style="background-color: ' . $falla['color_prioridad'] . '"></div>';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- PAGINACIÓN -->
            <div class="pagination-container mt-3 d-flex justify-content-center">
                <button class="btn btn-outline-primary mx-2" id="prevPage">Anterior</button>
                <span id="pageInfo" class="align-self-center mx-2">Página 1 de 5</span>
                <button class="btn btn-outline-primary mx-2" id="nextPage">Siguiente</button>
            </div>
        <?php endif; ?>
    </div>

    <script src="/metro/SGF/consulta/js/script.js"></script>
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
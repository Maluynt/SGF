<?php
// seguridad_vista.php
if (!isset($esVistaSegura) || $esVistaSegura !== true) {
    die('Acceso prohibido - El Metro de Los Teques');
}

// Inicialización segura de variables
$fallas = $fallas ?? [];
$allowedFields = $allowedFields ?? [];
$activeFilters = $activeFilters ?? [];
$filterOptions = $filterOptions ?? [];

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
    'Estado' => 'nombre_estado'
];

// Generar opciones de filtro de manera segura
$filterOptions = [];
if (is_array($fallas) && !empty($fallas)) {
    foreach ($activeFilters as $displayName => $fieldName) {
        $values = array_column($fallas, $fieldName);
        $filterOptions[$fieldName] = array_unique(array_filter($values));
    }
}

// Inicializar opciones vacías para cada filtro
foreach ($activeFilters as $fieldName => $value) {
    if (!isset($filterOptions[$fieldName])) {
        $filterOptions[$fieldName] = [];
    }
}

$cargarConsultaJS = true;

// --- Depuración segura ---
// error_log("Fallas obtenidas: " . print_r($fallas, true)); // Descomentar solo para debug
?>
<?php
define('INCLUIDO_SEGURO', true);
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php';
?>

<main class="main-content">
    <div class="container mt-4">
        <?php if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['exito'], ENT_QUOTES, 'UTF-8'); ?>
                <?php unset($_SESSION['exito']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!isset($error) || !$error): ?>
            <!-- SECCIÓN DE BUSQUEDA Y FILTROS -->
            <div class="filter-container">
                <div class="search-container mb-3 d-flex align-items-center gap-2">
                    <input type="text" id="searchInput"
                        placeholder="Buscar en todos los campos..."
                        class="form-control flex-grow-1">
                    <button class="btn btn-outline-secondary" id="reloadPage"
                        title="Recargar tabla completa" type="button">
                        <i class="fas fa-sync-alt"></i> Restablecer
                    </button>

                    <div class="col-md-4">
                        <input type="date" id="fechaInicio" class="form-control"
                            placeholder="Fecha inicio">
                    </div>
                    <div class="col-md-4">
                        <input type="date" id="fechaFin" class="form-control"
                            placeholder="Fecha fin">
                    </div>
                </div>

                <div class="filter-grid">
                    <?php foreach ($activeFilters as $displayName => $fieldName): ?>
                        <div class="filter-group">
                            <select class="filter-select form-control"
                                data-column="<?= htmlspecialchars($fieldName, ENT_QUOTES, 'UTF-8') ?>">
                                <option value=""><?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?></option>
                                <?php foreach (($filterOptions[$fieldName] ?? []) as $value): ?>
                                    <option value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"
                                        <?= ($fieldName === 'nombre_estado' && $value === 'Abierta') ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- TABLA -->
                <div class="table-responsive-lg">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="align-middle sticky-header">Acciones</th>
                                <?php foreach ($allowedFields as $displayName => $fieldName): ?>
                                    <th class="align-middle sticky-header"
                                        data-column="<?= htmlspecialchars($fieldName, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php foreach ($fallas as $falla): ?>
                                <tr>

                                    <td class="align-middle">
                                    <a href="/metro/SGF/consulta/controlador/controlador_editar.php?id=<?= htmlspecialchars($falla['id_falla']) ?>" 
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                    </a></td>
                                    <?php foreach ($allowedFields as $displayName => $fieldName): ?>
                                        <td class="align-middle">
                                            <?php
                                            $value = $falla[$fieldName] ?? 'N/A';
                                            echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

                                            if ($fieldName === 'nombre_prioridad' && isset($falla['color_prioridad'])) {
                                                echo '<div class="priority-indicator" 
                                                      style="background-color: ' . htmlspecialchars($falla['color_prioridad'], ENT_QUOTES, 'UTF-8') . '"></div>';
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
</main>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
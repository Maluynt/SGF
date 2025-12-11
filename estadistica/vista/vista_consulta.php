<?php
 define('INCLUIDO_SEGURO', true);

include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php';
$cargarConsultaJS = true; 

// --- Nuevo: Cargar datos de fallas ---
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/estadistica/modelo/modelo_consulta.php';



// Configuración de campos visibles
$allowedFields = [
    // ... (tus campos actuales se mantienen igual)
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
    // ... (tus filtros actuales se mantienen igual)
    'Equipo' => 'nombre_equipo',
    'Subsistema' => 'nombre_subsistema',
    'Servicio' => 'nombre_servicio',
    'Ambiente' => 'nombre_ambiente',
    'Fecha Reporte' => 'fecha_hora_reporte',
    'ID' => 'id_falla',
    'Estado' => 'nombre_estado'
];

// Generar estadísticas
$estadisticas = [
    'Servicio' => [],
    'Subsistema' => [],
    'Equipo' => []
];

if (!empty($fallas)) {
    $estadisticas['Servicio'] = array_count_values(array_column($fallas, 'nombre_servicio'));
    $estadisticas['Subsistema'] = array_count_values(array_column($fallas, 'nombre_subsistema'));
    $estadisticas['Equipo'] = array_count_values(array_column($fallas, 'nombre_equipo'));
}

// Datos para JS
$chartData = [
    'servicio' => [
        'labels' => array_keys($estadisticas['Servicio']),
        'data' => array_values($estadisticas['Servicio'])
    ],
    'subsistema' => [
        'labels' => array_keys($estadisticas['Subsistema']),
        'data' => array_values($estadisticas['Subsistema'])
    ],
    'equipo' => [
        'labels' => array_keys($estadisticas['Equipo']),
        'data' => array_values($estadisticas['Equipo'])
    ]
];

// --- Modificación: Validación de $fallas ---
$filterOptions = [];
if (!empty($fallas)) {
    foreach ($activeFilters as $displayName => $fieldName) {
        $values = array_column($fallas, $fieldName);
        $filterOptions[$fieldName] = array_unique(array_filter($values));
    }
}
?>
</main>

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
            <div class="row mb-4">
                <div class="col-6">
                    <button class="btn btn-primary btn-lg" id="toggleEstadisticas">
                        <i class="fas fa-chart-bar me-2"></i> Ver Estadísticas
                    </button>
                </div>

            </div>

            <div class="filter-container">

                <!-- Ejemplo del HTML -->
                <form id="form_filtros_pdf">
                    <div class="row mb-4">
                        <div class="col-12 text-end">
                            <button class="btn btn-danger btn-lg" type="submit" id="btn_generar_pdf">
                                <i class="fas fa-file-pdf me-2"></i> Generar Reporte PDF
                            </button>
                        </div>
                    </div>
                   








                    <!-- Botón PDF separado -->

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
                        <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" placeholder="Fecha inicio">
                    </div>

                    <div class="col-md-4">
                        <input type="date" id="fechaFin" name="fechaFin" class="form-control" placeholder="Fecha fin">
                    </div>






                        </div>
                    </div>
                </form>

                        <div class="filter-grid">
                            <?php foreach ($activeFilters as $displayName => $fieldName): ?>
                                <div class="filter-group">
                                    <select class="filter-select form-control" data-column="<?= $fieldName ?>">
                                        <option value=""><?= $displayName ?></option>
                                        <?php foreach ($filterOptions[$fieldName] as $value): ?>
                                            <option value="<?= htmlspecialchars($value) ?>"
                                                <?= ($fieldName === 'nombre_estado' && $value === 'Abierta') ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($value) ?>
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
                                    <a href="/metro/SGF/estadistica/controlador/controlador_editar.php?id=<?= htmlspecialchars($falla['id_falla']) ?>" 
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                    </a></td>
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


                    </div>

                    <!-- Modificar la sección de estadísticas -->
                    <div id="seccionEstadisticas" style="display: none;">
                        <div class="row mb-4">
                            <!-- Servicio -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header" style="background-color: #2c3e50; color: white;">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-chart-pie me-2"></i>Fallos por Servicio
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="servicioChart"></canvas>
                                        <div id="estadisticasServicio" class="mt-4"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Subsistema -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header" style="background-color: #5c6d7e; color: white;">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-chart-bar me-2"></i>Fallos por Subsistema
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="subsistemaChart"></canvas>
                                        <div id="estadisticasSubsistema" class="mt-4"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipo -->
                            <div class="col-md-12 mb-4">
                                <div class="card shadow">
                                    <div class="card-header" style="background-color: #17212c; color: white;">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-chart-bar me-2"></i>Fallos por Equipo
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="equipoChart"></canvas>
                                        <div id="estadisticasEquipo" class="mt-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script id="chartData" type="application/json">
                            <?= json_encode($chartData) ?>
                        </script>
                    </div>
                    <!-- Resto de tu código existente (tabla, etc) -->

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
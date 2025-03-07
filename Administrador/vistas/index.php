<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios Responsivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/metro/SGF/Administrador/css/estilo.css">
    <style>
        .alert-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem;
            border-radius: 10px;
        }
        .warning-alert {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }
        .error-alert {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body class="bg-light">
    <header class="bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="/metro/SGF/img/logo_mlte.png" alt="logo del metro" class="img-fluid" style="max-width: 100px;">
                <h1 class="text-center mx-3">Centro de Control de Fallas</h1>
            </div>
            <div class="time" id="time"></div>
        </div>
    </header>

    <div class="container py-5">
        <?php if(isset($errorMessage)): ?>
            <div class="alert-container error-alert">
                <h2 class="mb-4">⚠️ Validación de Servicios</h2>
                <div class="alert alert-danger">
                    <?= $errorMessage ?>
                </div>
                <p class="mt-3">Nota: Los servicios se muestran usando los IDs reales de la base de datos</p>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($advertencias)): ?>
            <div class="alert-container warning-alert mb-4">
                <h4>📢 Avisos:</h4>
                <?= implode("<br>", array_map('htmlspecialchars', $advertencias)) ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($serviciosValidos)): ?>
            <h1 class="text-center mb-5">Nuestros Servicios</h1>
            <div class="row g-4" id="servicesContainer">
                <?php foreach ($serviciosValidos as $servicio): ?>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="service-card" 
                             data-color="<?= htmlspecialchars($servicio['color']) ?>" 
                             data-url="<?= htmlspecialchars($servicio['url']) ?>"
                             style="cursor:pointer;" 
                             onclick="enviarIdServicio(<?= htmlspecialchars($servicio['id']) ?>, this)">
                            <div class="card-content">
                                <h3><?= htmlspecialchars($servicio['nombre']) ?></h3>
                                <small class="text-muted">ID: <?= htmlspecialchars($servicio['id']) ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert-container error-alert">
                <h2>No hay servicios válidos para mostrar</h2>
                <p>Todos los servicios presentan conflictos con la base de datos</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="/metro/SGF/Administrador/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="bg-dark text-white text-center p-3">
        <p>Redes Sociales:
            <a href="#" class="text-danger">Facebook</a> |
            <a href="#" class="text-danger">Twitter</a> |
            <a href="#" class="text-danger">Instagram</a>
        </p>
        <p>C.A. Metro Los Teques</p>
    </footer>

</body>
</html>
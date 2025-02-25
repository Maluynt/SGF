<?php

include('../modelo/modelo.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios Responsivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilo.css">
    
</head>
<body class="bg-light">
    <header class="bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="../../img/logo_mlte.png" alt="logo del metro" class="img-fluid" style="max-width: 100px;">
                <h1 class="text-center mx-3">Centro de Control de Fallas</h1>
            </div>
            <div class="time" id="time"></div>
        </div>
    </header>
    <div class="container py-5">
    <h1 class="text-center mb-5">Nuestros Servicios</h1>
    <div class="row g-4" id="servicesContainer">
        <?php if (!empty($servicios)): ?>
            <?php foreach ($servicios as $servicio): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="service-card" data-color="<?php echo htmlspecialchars($servicio['color']); ?>" style="cursor:pointer;" onclick="enviarIdServicio(<?php echo htmlspecialchars($servicio['id']); ?>)">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($servicio['nombre']); ?></h3>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay servicios disponibles en este momento.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function enviarIdServicio(idServicio) {
        fetch('../../registrar_servicios/subsistema/controlador/controlador_subsistema.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id_servicio=' + encodeURIComponent(idServicio)
        })
        .then(response => {
            if (response.ok) {
                // Redirigir a otra página después de que se envíe el id_servicio
                window.location.href = '/metro/SGF/inicio/controlador/controlador_inicio.php'; // Cambia esto a la dirección deseada
            } else {
                console.error('Error al enviar el ID del servicio');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

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

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
<header class="bg-dark text-white p-3">
      <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
              <img src="../../img/logo_mlte.png" alt="logo del metro" class="img-fluid" style="max-width: 100px;">
              <h1 class="text-center mx-3">Centro de Control de Fallas</h1>
          </div>
          <div class="time" id="time"></div>
      </div>
  </header>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-5">Nuestros Servicios</h1>
        <div class="row g-4" id="servicesContainer"></div>
    </div>

    <!-- Scripts -->
    <script type="module" src="../controlador/controlador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="bg-dark text-white text-center p-3">
      <p>Redes Sociales: 
          <a href="#" class="text-danger">Facebook</a> | 
          <a href="#" class="text-danger">Twitter</a> | 
          <a href="#" class="text-danger">Instagram</a>
      </p>
      <p>C.A. Metro Los Teques</p>
  </footer>
</html>

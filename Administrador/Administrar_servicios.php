<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios Responsivos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .service-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            color: white;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        }
        
        /* Colores personalizados */
        [data-color="1"] { background: #6C63FF; }
        [data-color="2"] { background: #FF6584; }
        [data-color="3"] { background: #00BFA6; }
        [data-color="4"] { background: #FFA62B; }
        [data-color="5"] { background: #3D5AFE; }
        [data-color="6"] { background: #4CAF50; }
        [data-color="7"] { background: #7C4DFF; }
        [data-color="8"] { background: #FF4081; }

        .card-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-5">Nuestros Servicios</h1>
    
    <div class="row g-4">
        <!-- Administrar -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="1">
                    <div class="card-content">
                        <h3>Administrar</h3>
                        <p class="mb-0">Gestión integral de proyectos</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Tecnología -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="2">
                    <div class="card-content">
                        <h3>Tecnología</h3>
                        <p class="mb-0">Soluciones innovadoras</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Electrificación -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="3">
                    <div class="card-content">
                        <h3>Electrificación</h3>
                        <p class="mb-0">Sistemas de potencia</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Obra Civil -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="4">
                    <div class="card-content">
                        <h3>Obra Civil</h3>
                        <p class="mb-0">Infraestructura de calidad</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Via Ferrea -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="5">
                    <div class="card-content">
                        <h3>Vía Férrea</h3>
                        <p class="mb-0">Diseño y mantenimiento</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Señalización -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="6">
                    <div class="card-content">
                        <h3>Señalización</h3>
                        <p class="mb-0">Sistemas de seguridad</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Material Rodante -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="7">
                    <div class="card-content">
                        <h3>Material Rodante</h3>
                        <p class="mb-0">Equipamiento especializado</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Electromecánica -->
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="#" class="text-decoration-none">
                <div class="service-card" data-color="8">
                    <div class="card-content">
                        <h3>Electromecánica</h3>
                        <p class="mb-0">Sistemas integrados</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
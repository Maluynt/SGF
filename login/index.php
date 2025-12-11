<?php
session_start(); // ✅ ¡Sesión iniciada primero!

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    
    <!-- Librerías locales -->
    <link rel="stylesheet" href="/metro/SGF/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/metro/SGF/assets/vendor/components/font-awesome/css/all.min.css">
    
    <style>
        :root {
            --color-primario: #2c3e50;
            --color-secundario: #dc3545;
            --sombra: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .login-container {
            max-width: 400px;
            margin: 5vh auto;
            padding: 2rem;
            border-radius: 10px;
            background: #f8f9fa;
            box-shadow: var(--sombra);
        }
        
        .login-logo {
            width: 180px;
            margin: 0 auto 2rem;
            display: block;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-primario);
        }
        
        .btn-metro {
            background: var(--color-secundario);
            border: none;
            padding: 12px 0;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-metro:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body class="bg-light">

<div class="login-container">
    <img src="/metro/SGF/img/logo_mlte.png" alt="Logo Metro" class="login-logo">
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error'] ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="/metro/SGF/login/controlador/controlador_login.php">
    <input type="hidden" 
           name="csrf_token" 
           value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="form-group position-relative mb-4">
            <i class="fas fa-user input-icon"></i>
            <input type="text" 
                   class="form-control pl-5" 
                   name="usuario" 
                   placeholder="Usuario"
                   required
                   autofocus>
        </div>

        <div class="form-group position-relative mb-4">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" 
                   class="form-control pl-5" 
                   name="password" 
                   placeholder="Contraseña" 
                   required
                   id="password">
            <i class="fas fa-eye input-icon" 
               style="right: 15px; left: auto; cursor: pointer;" 
               id="togglePassword"></i>
        </div>

        <button type="submit" 
                name="btningresar" 
                class="btn btn-metro btn-block text-white">
            INGRESAR
        </button>
        <a class="enlace" href="recuperar_contraseña.php">¿Olvidó su contraseña?</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    if(toggle && password) {
        toggle.addEventListener('click', () => {
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            toggle.classList.toggle('fa-eye-slash');
        });
    }
});
</script>

<!-- Scripts locales -->
<script src="/metro/SGF/assets/js/jquery-3.6.0.min.js"></script>
<script src="/metro/SGF/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
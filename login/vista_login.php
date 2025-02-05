<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="login.css">
    <script>
        // Evitar que el usuario use el botón "Atrás" del navegador
        window.history.pushState(null, '', window.location.href);
        window.onpopstate = function() {
            alert("No puedes volver a la página anterior.");
            window.history.pushState(null, '', window.location.href);
        };

        function vista() {
            var passwordInput = document.querySelector('input[name="password"]');
            var verPasswordIcon = document.getElementById('verPassword');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                verPasswordIcon.classList.remove('fa-eye');
                verPasswordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                verPasswordIcon.classList.remove('fa-eye-slash');
                verPasswordIcon.classList.add('fa-eye');
            }
        }
    </script>
</head>
<body>
<div class="container">
    <img class="avatar" src="#" alt="logo de usuario"><br>
    <form method="post" action="controlador_login.php">
        <div class="input-div">
            <div class="i">
                <i class="fas fa-user"></i>
            </div>
            <input type="text" class="input" name="usuario" placeholder="Usuario" required>
        </div>
        <div class="input-div">
            <div class="i">
                <i class="fas fa-lock"></i>
            </div>
            <input type="password" class="input" name="password" placeholder="Contraseña" required>
            <div class="view">
                <i class="fas fa-eye" onclick="vista()" id="verPassword"></i>
            </div>
        </div>
        <button name="btningresar" type="submit" value="INICIAR SECION">ENTRAR</button>
        <a class="enlace" href="olvidocontraseña.php">¿Olvidó su contraseña?</a>
    </form>
</div>
</body>
</html>
<?php
// Verificación de seguridad al principio
if (!isset($esVistaSegura) || $esVistaSegura !== true) {
    die('Acceso prohibido - El Metro de Los Teques');
}

define('INCLUIDO_SEGURO', true);

// Extraer variables pasadas desde el controlador
extract($variables);

// Incluir layout principal que contiene header y footer
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/sidebar.php';
?>

<main class="main-content">
    <div class="container mt-5">
        <h3 class="text-center mb-4">Registro de Nuevo Usuario</h3>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?= $mensaje_tipo ?> alert-dismissible fade show">
                <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <form method="POST" action="/metro/SGF/usuarios/controlador/controlador_registrar_usuario.php" class="mx-auto" style="max-width: 500px;">
            <!-- Campo de búsqueda de personal con JavaScript -->
            <div class="form-group position-relative">
                <label for="id_personal_buscador">Buscar Personal</label>
                <input type="text"
                    id="id_personal_buscador"
                    class="form-control"
                    placeholder="Ej: Juan Pérez o 123456"
                    autocomplete="off">
                <input type="hidden"
                    name="id_personal"
                    id="id_personal"
                    required>
                <div id="sugerencias" class="list-group sugerencias-autocomplete"></div>
            </div>

            <!-- Selector de Perfil -->
            <div class="form-group">
                <label for="id_perfil">Perfil</label>
                <select class="form-control" id="id_perfil" name="id_perfil" required>
                    <option value="">Seleccione un perfil</option>
                    <?php foreach ($perfiles as $perfil): ?>
                        <option value="<?= $perfil['id_perfil'] ?>"
                            <?= ($formData['id_perfil'] ?? '') == $perfil['id_perfil'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($perfil['perfil']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Selector de Servicio -->
            <div class="form-group">
                <label for="id_servicio">Servicio</label>
                <select class="form-control" id="id_servicio" name="id_servicio" required>
                    <option value="">Seleccione un servicio</option>
                    <?php foreach ($servicios as $servicio): ?>
                        <option value="<?= $servicio['id_servicio'] ?>"
                            <?= ($formData['id_servicio'] ?? '') == $servicio['id_servicio'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($servicio['nombre_servicio']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Campos de formulario -->
            <div class="form-group">
                <label for="usuario">Nombre de Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario"
                    value="<?= htmlspecialchars($formData['usuario'] ?? '') ?>"
                    placeholder="Mínimo 4 caracteres" required minlength="4">
            </div>

            <div class="form-group">
                <label for="pregunta">Pregunta Secreta</label>
                <input type="text" class="form-control" id="pregunta" name="pregunta"
                    value="<?= htmlspecialchars($formData['pregunta'] ?? '') ?>"
                    placeholder="Ej: ¿Cuál es tu color favorito?" required>
            </div>

            <div class="form-group">
                <label for="respuesta">Respuesta Secreta</label>
                <input type="text" class="form-control" id="respuesta" name="respuesta"
                    value="<?= htmlspecialchars($formData['respuesta'] ?? '') ?>"
                    placeholder="Respuesta para recuperación" required>
            </div>

            <!-- Contraseña con botón de "ojo" -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Mínimo 8 caracteres" required minlength="8">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group button-group mt-4">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-save mr-2"></i>Registrar Usuario
                </button>
                <a href="../inicio/inicio.php" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left mr-2"></i>Regresar
                </a>
            </div>
        </form>
    </div>
</main>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // Cambia el tipo del input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // Cambia el icono del ojo
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/inicio/partials/footer.php'; ?>
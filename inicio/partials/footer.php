</main>
<?php
// En la primera línea de header.php
if (!defined('INCLUIDO_SEGURO')) {
    die('Acceso directo no permitido');
}
?>
<footer class="bg-dark text-white pt-4 mt-5 border-top border-danger">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4 text-center text-md-start">
                <h5 class="text-uppercase mb-3">Conéctate con nosotros</h5>
                <div class="social-links">
                    <a href="https://facebook.com/metrolosteques" 
                       class="text-white me-3"
                       target="_blank"
                       rel="noopener noreferrer">
                        <i class="fab fa-facebook-f fa-lg"></i>
                    </a>
                    <a href="https://twitter.com/metrolosteques" 
                       class="text-white me-3"
                       target="_blank"
                       rel="noopener noreferrer">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="https://instagram.com/metrolosteques" 
                       class="text-white"
                       target="_blank"
                       rel="noopener noreferrer">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6 mb-4 text-center text-md-end">
                <h5 class="text-uppercase mb-3">Contacto</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-phone me-2"></i>+58 212-555-0100</li>
                    <li><i class="fas fa-envelope me-2"></i>contacto@metrolosteques.com</li>
                </ul>
            </div>
        </div>

        <div class="row border-top border-danger pt-3">
            <div class="col-12 text-center">
                <p class="mb-1">
                    <img src="/metro/SGF/img/logo_mlte.png" 
                         alt="Logo Metro Los Teques" 
                         style="height: 30px;" 
                         class="me-2">
                    C.A. Metro Los Teques
                </p>
                <p class="small mb-0">
                    © 2023 Todos los derechos reservados | 
                    <a href="/politica-privacidad" class="text-white">Política de Privacidad</a> | 
                    <a href="/terminos-servicio" class="text-white">Términos de Servicio</a>
                </p>
            </div>
        </div>
    </div>
</footer>




<!-- Dependencias principales Locales -->
<script src="/metro/SGF/assets/js/chart.min.js"></script>
<script src="/metro/SGF/assets/js/jquery-3.6.0.min.js"></script>
<script src="/metro/SGF/assets/js/popper.min.js"></script>
<script src="/metro/SGF/assets/js/bootstrap.min.js"></script>
<script src="/metro/SGF/assets/js/jspdf.umd.min.js"></script>
<script src="/metro/SGF/assets/js/jspdf.plugin.autotable.min.js"></script>


<!-- FontAwesome (si desea colocarlo) -->

<!-- Scripts propios con carga condicional -->
<?php if(isset($cargarBuscadorJS) && $cargarBuscadorJS): ?>
    <script src="/metro/SGF/usuarios/js/buscador.js" defer></script>
<?php endif; ?>

<?php if(isset($cargarConsultaJS) && $cargarConsultaJS): ?>
    <script src="/metro/SGF/consulta/js/script.js" defer></script>
<?php endif; ?>

<!-- Scripts comunes -->
<script src="/metro/SGF/estadistica/js/js_estadistica.js" defer></script>
<script src="/metro/SGF/estadistica/js/js_pdf.js" defer></script>
<script src="/metro/SGF/abrir/js/peticiones.js" defer></script>
<script src="/metro/SGF/inicio/JS/script.js" defer></script>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<footer class="footer-section">
    <!-- WhatsApp flotante -->
    <a href="https://wa.me/593995901732" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>

    <div class="container-fluid bg-dark-gray text-white py-4 px-3 px-md-5">
        <div class="row">

            <!-- LOGO -->
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="#" class="navbar-brand mb-3 d-block">
                    <img src="<?= URL_BASE ?>img/logoSuperarse.png" alt="Logo"
                         class="img-fluid footer-logo"
                         style="max-height:80px; filter:brightness(0) invert(1);">
                </a>
                <p class="footer-text">
                    Formación técnica y tecnológica con excelencia académica.
                </p>
                <div class="d-flex justify-content-start mt-3 social-icons-container">
                    <a class="btn btn-outline-primary rounded-circle mr-2" href="https://twitter.com/superarse1"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-primary rounded-circle mr-2" href="https://www.facebook.com/superarse1/"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-primary rounded-circle mr-2" href="https://ec.linkedin.com/company/superarse1"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-primary rounded-circle mr-2" href="https://www.instagram.com/superarse1"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- CONTACTO -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h3 class="text-primary mb-3 font-weight-bold footer-title">Póngase en contacto</h3>

                <div class="d-flex mb-2">
                    <i class="fa fa-map-marker-alt text-primary mt-1 mr-2"></i>
                    <p class="mb-0">
                        <a href="https://maps.app.goo.gl/naNp34vgjjMzkHA2A"
                           target="_blank"
                           class="text-white-50">
                            Av. Alpallana E8-86 y Av. 6 de Diciembre, Quito
                        </a>
                    </p>
                </div>

                <div class="d-flex mb-2">
                    <i class="fa fa-envelope text-primary mt-1 mr-2"></i>
                    <p class="mb-0 text-white-50">matriculas@superarse.edu.ec</p>
                </div>

                <div class="d-flex">
                    <i class="fa fa-phone-alt text-primary mt-1 mr-2"></i>
                    <p class="mb-0 text-white-50">(02) 393-0980</p>
                </div>
            </div>

            <!-- ENLACES -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h3 class="text-primary mb-3 font-weight-bold footer-title">Enlaces rápidos</h3>
                <a class="text-white-50 d-block mb-2" href="https://agrovet.superarse.ec/">Agrovet</a>
                <a class="text-white-50 d-block mb-2" href="https://superarse.edu.ec/">Instituto Superarse</a>
                <a class="text-white-50 d-block mb-2" href="https://superarse.ec/">Superarse Conectados</a>
                <a class="text-white-50 d-block mb-2" href="https://becasuperarse.ec/">Because he is Nice</a>
                <a class="text-white-50 d-block mb-2" href="https://2ctm2025.superarse.ec/">II CTM 2025</a>
            </div>

            <!-- FORMULARIO -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h3 class="text-primary mb-3 font-weight-bold footer-title">Admisiones</h3>

                <iframe name="iframeRespuesta" style="display:none;"></iframe>

                <form action="../../../enviar-correo.php"
                      method="POST"
                      target="iframeRespuesta"
                      class="footer-form">

                    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombres Completos" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Correo personal" required>
                    <input type="tel" name="celular" class="form-control mb-2" placeholder="WhatsApp" required>
                    <textarea name="description" class="form-control mb-2" rows="2"
                              placeholder="Describe tu requerimiento..." required></textarea>

                    <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                        ENVIAR
                    </button>
                </form>

                <!-- MENSAJE -->
                <div id="mensajeFormulario"
                     class="mt-3 text-center font-weight-bold"
                     style="display:none;"></div>
            </div>

        </div>

        <div class="text-center pt-3 mt-3" style="border-top:1px solid rgba(255,255,255,.1)">
            <p class="mb-0 text-white-50">
                &copy; Superarse.edu.ec — Todos los derechos reservados
            </p>
        </div>
    </div>
</footer>

<!-- SCRIPT MENSAJE -->
<script>
const iframe = document.querySelector('iframe[name="iframeRespuesta"]');
const mensaje = document.getElementById('mensajeFormulario');
const form = document.querySelector('.footer-form');

iframe.addEventListener('load', () => {
    try {
        const respuesta = iframe.contentDocument.body.textContent.trim();

        if (respuesta !== "") {
            mensaje.style.display = "block";
            mensaje.innerText = respuesta;

            if (respuesta.toLowerCase().includes("éxito")) {
                mensaje.className = "mt-3 text-center text-success font-weight-bold";
                form.reset();
            } else {
                mensaje.className = "mt-3 text-center text-danger font-weight-bold";
            }
        }
    } catch {
        mensaje.style.display = "block";
        mensaje.className = "mt-3 text-center text-danger font-weight-bold";
        mensaje.innerText = "Error al enviar la solicitud.";
    }
});
</script>

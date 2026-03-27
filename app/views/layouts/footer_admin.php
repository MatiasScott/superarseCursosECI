<footer class="footer-admin mt-auto py-3">
    <div class="container text-center">
        <div class="footer-admin-content">
            <span class="text-muted">© <?= date('Y'); ?> <strong>Superarse</strong> - Panel de Administración</span>
            <div class="footer-admin-links mt-2">
                <small class="text-muted">Versión 1.0. | Soporte Técnico: soporte@superarse.edu.ec</small>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php if (isset($js_especifico)): ?>
    <script src="<?= URL_BASE; ?>js/<?= $js_especifico ?>.js"></script>
<?php endif; ?>
</body>

</html>
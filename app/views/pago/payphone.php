<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de pagos - Educación Continua</title>
    <link rel="icon" type="image/png" href="<?= defined('URL_BASE') ? URL_BASE : ''; ?>img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js" type="module"></script>
    <link href="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #333333;
            --accent-color: #FFD700;
        }

        body {
            background: #F2EFE0;
            min-height: 100vh;
        }

        .header-custom {
            background: #000000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            padding: 1.5rem 0;
        }

        .header-custom h2 {
            color: #FFD700 !important;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .payment-container {
            background: #FDFBF7;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 2.5rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .payment-header h1 {
            color: #FFD700;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .payment-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .payment-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }

        .payment-info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .payment-info-label {
            color: #FFD700;
            font-weight: 600;
        }

        .payment-info-value {
            color: #212529;
            font-weight: 600;
        }

        .payment-total {
            font-size: 1.25rem;
            color: #FFD700 !important;
            font-weight: 700 !important;
        }

        #pp-button {
            margin-top: 2rem;
            min-height: 60px;
        }

        .footer-custom {
            background: #000000;
            color: #FFD700;
            padding: 1.5rem 0;
            margin-top: 3rem;
        }

        .loading-indicator {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #FFD700;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <header class="header-custom text-white text-center">
        <div class="container">
            <h2 class="mb-0">Plataforma de Pagos - Educación Continua</h2>
        </div>
    </header>

    <main class="container py-5">
        <div class="payment-container">
            <div class="payment-header">
                <h1>Procesando tu inscripción</h1>
                <p class="text-muted">Completa tu pago de forma segura</p>
            </div>

            <div class="payment-info">
                <div class="payment-info-item">
                    <span class="payment-info-label">Curso:</span>
                    <span class="payment-info-value"><?= htmlspecialchars($curso); ?></span>
                </div>
                <div class="payment-info-item">
                    <span class="payment-info-label">Referencia:</span>
                    <span class="payment-info-value"><?= htmlspecialchars($referencia); ?></span>
                </div>
                <div class="payment-info-item">
                    <span class="payment-info-label">Subtotal:</span>
                    <span class="payment-info-value">$<?= number_format($amountWithoutTax / 100, 2); ?></span>
                </div>
                <?php if ($tax > 0): ?>
                <div class="payment-info-item">
                    <span class="payment-info-label">IVA:</span>
                    <span class="payment-info-value">$<?= number_format($tax / 100, 2); ?></span>
                </div>
                <?php endif; ?>
                <div class="payment-info-item">
                    <span class="payment-info-label">Total a pagar:</span>
                    <span class="payment-info-value payment-total">$<?= number_format($amount / 100, 2); ?></span>
                </div>
            </div>

            <div id="pp-button">
                <div class="loading-indicator">
                    <div class="spinner"></div>
                    <p>Cargando pasarela de pagos...</p>
                </div>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-lock"></i> Pago seguro procesado por Payphone
                </small>
            </div>
        </div>
    </main>

    <script type="module">
    window.addEventListener('DOMContentLoaded', () => {
        try {
            const ppb = new PPaymentButtonBox({
                token: '<?= defined('PAYPHONE_TOKEN') ? PAYPHONE_TOKEN : ''; ?>',
                clientTransactionId: '<?= $clientTransactionId ?>',
                amount: <?= $amount ?>,
                amountWithoutTax: <?= $amountWithoutTax ?>,
                tax: <?= $tax ?>,
                currency: "USD",
                storeId: "<?= defined('PAYPHONE_STORE_ID') ? PAYPHONE_STORE_ID : ''; ?>",
                reference: '<?= htmlspecialchars($referencia) ?>',
                successUrl: '<?= defined('URL_BASE') ? URL_BASE : ''; ?>pago/payphone?status=success',
                failureUrl: '<?= defined('URL_BASE') ? URL_BASE : ''; ?>pago/payphone?status=failure'
            }).render('pp-button');
        } catch (error) {
            console.error('Error al cargar Payphone:', error);
            document.getElementById('pp-button').innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> No se pudo cargar la pasarela de pagos. 
                    Por favor, recarga la página o contacta al soporte.
                </div>
            `;
        }
    });
    </script>

    <footer class="footer-custom text-center">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y'); ?> Educación Continua. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>

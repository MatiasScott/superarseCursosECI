<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tipo === 'success' ? 'Pago Exitoso' : 'Pago Fallido'; ?> - Educación Continua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #F2EFE0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .result-container {
            background: #FDFBF7;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 3rem;
            max-width: 500px;
            text-align: center;
        }

        .icon-container {
            margin-bottom: 2rem;
        }

        .icon-success {
            color: #FFD700;
            font-size: 5rem;
            animation: scaleIn 0.5s ease-in-out;
        }

        .icon-error {
            color: #000000;
            font-size: 5rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes scaleIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        h1 {
            color: #FFD700;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .message {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .btn-custom {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-success-custom {
            background: #000000;
            color: #FFD700;
            border: 2px solid #FFD700;
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 215, 0, 0.4);
            background: #FFD700;
            color: #000000;
        }

        .btn-danger-custom {
            background: #000000;
            color: #FFD700;
            border: 2px solid #FFD700;
        }

        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 215, 0, 0.4);
            background: #FFD700;
            color: #000000;
        }

        .additional-info {
            background: #F2EFE0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .additional-info p {
            margin: 0.5rem 0;
            color: #333;
            font-weight: 500;
        }
        
        .text-success {
            color: #FFD700 !important;
        }
        
        .text-primary {
            color: #FFD700 !important;
        }
        
        .text-info {
            color: #FFD700 !important;
        }
        
        .text-warning {
            color: #FFD700 !important;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <div class="icon-container">
            <?php if ($tipo === 'success'): ?>
                <i class="fas fa-check-circle icon-success"></i>
            <?php else: ?>
                <i class="fas fa-times-circle icon-error"></i>
            <?php endif; ?>
        </div>

        <h1><?= $tipo === 'success' ? '¡Pago Exitoso!' : 'Pago No Procesado'; ?></h1>
        <p class="message"><?= htmlspecialchars($mensaje); ?></p>

        <?php if ($tipo === 'success'): ?>
            <div class="additional-info">
                <p><i class="fas fa-check text-success"></i> Tu inscripción ha sido confirmada</p>
                <p><i class="fas fa-envelope text-primary"></i> Recibirás un correo con los detalles</p>
            </div>
            <a href="<?= URL_BASE; ?>estudiante/mis_cursos" class="btn btn-success-custom">
                <i class="fas fa-graduation-cap"></i> Ver Mis Cursos
            </a>
        <?php else: ?>
            <div class="additional-info">
                <p><i class="fas fa-info-circle text-info"></i> No se realizó ningún cargo a tu cuenta</p>
                <p><i class="fas fa-redo text-warning"></i> Puedes intentar nuevamente</p>
            </div>
            <a href="<?= URL_BASE; ?>curso/index" class="btn btn-danger-custom">
                <i class="fas fa-arrow-left"></i> Volver al Catálogo
            </a>
        <?php endif; ?>
    </div>
</body>
</html>

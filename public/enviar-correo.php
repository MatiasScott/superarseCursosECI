<?php
// ================== DEBUG (solo pruebas) ==================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ==========================================================

header("Content-Type: text/html; charset=UTF-8");
header("X-Content-Type-Options: nosniff");

// ==== CARGA PHPMailer ====
// Usa UNA de las dos opciones según tu servidor

// OPCIÓN A: si usas Composer
require __DIR__ . '/vendor/autoload.php';

/*
// OPCIÓN B: si NO usas Composer
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ================= CONFIGURACIÓN SMTP =================
$smtp_host = 'mail.superarse.ec';
$smtp_port = 587;
$smtp_username = 'alexander.quinga@superarse.ec';
$smtp_password = 'Patoboris123'; // ⚠️ mover a variable de entorno en producción
$from_email = 'alexander.quinga@superarse.ec';
$from_name = 'Formulario de Admisión Educación Continua e Inglés ';
// =====================================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ========= SANITIZACIÓN (PHP 8+) =========
    $nombre      = htmlspecialchars(trim($_POST["nombre"] ?? ''), ENT_QUOTES, 'UTF-8');
    $email       = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $celular     = htmlspecialchars(trim($_POST["celular"] ?? ''), ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars(trim($_POST["description"] ?? ''), ENT_QUOTES, 'UTF-8');

    // Correos internos
    $admin_recipients = [
        "superarseadmisiones@gmail.com"
    ];

    // Validaciones
    if (
        empty($nombre) ||
        empty($celular) ||
        empty($descripcion) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        http_response_code(400);
        echo "Por favor, completa correctamente el formulario.";
        exit;
    }

    if (
        strlen($nombre) > 100 ||
        strlen($email) > 100 ||
        strlen($celular) > 20 ||
        strlen($descripcion) > 1000
    ) {
        http_response_code(400);
        echo "Los datos exceden el límite permitido.";
        exit;
    }

    // ========= WHATSAPP =========
    $celular_limpio = preg_replace('/[^0-9]/', '', $celular);
    if (substr($celular_limpio, 0, 1) === '0') {
        $celular_limpio = '593' . substr($celular_limpio, 1);
    }
    $whatsapp_link = "https://wa.me/" . $celular_limpio;

    // ========= CORREO =========
    $subject = "Nuevo requerimiento de admisión Educación Continua e Inglés - $nombre";

    $email_content = "
    <html>
    <body>
        <h2>Nuevo requerimiento de admisión</h2>
        <p><strong>Nombre:</strong> {$nombre}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>WhatsApp:</strong>
            <a href='{$whatsapp_link}' target='_blank'>{$celular}</a>
        </p>
        <h3>Mensaje:</h3>
        <p>" . nl2br($descripcion) . "</p>
    </body>
    </html>
    ";

    // ========= ENVÍO =========
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp_port;
        $mail->CharSet    = 'UTF-8';

        // Remitente
        $mail->setFrom($from_email, $from_name);

        // DESTINATARIO PRINCIPAL (ADMISIONES)
        foreach ($admin_recipients as $admin_email) {
            $mail->addAddress($admin_email, "Admisiones Superarse");
        }

        // Reply al usuario
        $mail->addReplyTo($email, $nombre);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $email_content;
        $mail->AltBody = "Nombre: $nombre\nEmail: $email\nWhatsApp: $whatsapp_link\n\n$descripcion";

        $mail->send();

        echo "¡Éxito! Su solicitud ha sido enviada correctamente.";

    } catch (Exception $e) {
        http_response_code(500);
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        echo "Error al enviar el mensaje. Intente más tarde.";
    }

} else {
    http_response_code(403);
    echo "Acceso denegado.";
}

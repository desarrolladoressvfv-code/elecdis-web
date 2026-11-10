<?php
/**
 * ELECDIS – Endpoint del formulario de contacto
 * Requiere PHP 7.4+ y la función mail() o PHPMailer activos en el hosting.
 */

declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

// Solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

// Configuración
require_once __DIR__ . '/smtp-config.php';

// ── Honeypot antispam ──────────────────────────────────────────────────────────
if (!empty($_POST['website'])) {
    // Bot detectado: responde 200 para no revelar el filtro
    echo json_encode(['success' => true]);
    exit;
}

// ── Sanitización ───────────────────────────────────────────────────────────────
function clean(string $val): string {
    return htmlspecialchars(trim(strip_tags($val)), ENT_QUOTES, 'UTF-8');
}

$nombre  = clean($_POST['nombre']  ?? '');
$cargo   = clean($_POST['cargo']   ?? '');
$empresa = clean($_POST['empresa'] ?? '');
$correo  = filter_var(trim($_POST['correo'] ?? ''), FILTER_SANITIZE_EMAIL);
$telefono= clean($_POST['telefono'] ?? '');
$sector  = clean($_POST['sector']  ?? '');
$plazo   = clean($_POST['plazo']   ?? '');
$mensaje = clean($_POST['mensaje'] ?? '');

// ── Validación básica ─────────────────────────────────────────────────────────
$errors = [];
if (empty($nombre))                           $errors[] = 'El nombre es obligatorio.';
if (empty($correo))                           $errors[] = 'El correo es obligatorio.';
elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errors[] = 'El correo no es válido.';
if (empty($mensaje))                          $errors[] = 'El mensaje es obligatorio.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Construcción del correo ───────────────────────────────────────────────────
$body = "Nueva consulta desde el sitio web de ELECDIS\n";
$body .= str_repeat('─', 50) . "\n\n";
$body .= "Nombre:   $nombre\n";
$body .= "Cargo:    $cargo\n";
$body .= "Empresa:  $empresa\n";
$body .= "Correo:   $correo\n";
$body .= "Teléfono: $telefono\n";
$body .= "Sector:   $sector\n";
$body .= "Plazo:    $plazo\n\n";
$body .= "Mensaje:\n$mensaje\n";

$headers  = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM . ">\r\n";
$headers .= "Reply-To: $nombre <$correo>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// ── Envío ─────────────────────────────────────────────────────────────────────
$sent = mail(MAIL_TO, MAIL_SUBJECT, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Mensaje enviado correctamente.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje. Por favor contáctanos directamente por WhatsApp.']);
}

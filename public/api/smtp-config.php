<?php
/**
 * ELECDIS – Configuración SMTP
 * Reemplaza estos valores con los datos reales del hosting antes de publicar.
 * NO subas este archivo a un repositorio público.
 */

define('SMTP_HOST',     'mail.tuhosting.cl');   // Servidor SMTP
define('SMTP_PORT',      587);                   // Puerto (587 TLS / 465 SSL)
define('SMTP_USER',     'contacto@elecdis.cl'); // Usuario SMTP
define('SMTP_PASS',     'TU_CONTRASEÑA_SMTP');  // Contraseña SMTP
define('SMTP_FROM',     'contacto@elecdis.cl'); // Remitente
define('SMTP_FROM_NAME','ELECDIS Web');          // Nombre remitente
define('MAIL_TO',       'elecdis.spa@gmail.com');// Destinatario de los mensajes
define('MAIL_SUBJECT',  '[ELECDIS] Nueva consulta desde el sitio web');

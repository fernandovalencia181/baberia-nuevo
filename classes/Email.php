<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    private function getHost(): string {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
        return $protocol . "://{$_SERVER['HTTP_HOST']}";
    }

    private function configurarMailer(): PHPMailer {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = $_ENV["SMTP_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["SMTP_PORT"];
        $mail->Username = $_ENV["SMTP_USER"];
        $mail->Password = $_ENV["SMTP_PASS"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom($_ENV["SMTP_FROM"], $_ENV["SMTP_FROM_NAME"]);
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        return $mail;
    }

    public function enviarConfirmacion(): bool {
        $host = $this->getHost();
        $mail = $this->configurarMailer();
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = "Confirma tu cuenta en Camacho Barber";

        $mail->Body = <<<HTML
<html>
<body style="font-family: Arial, sans-serif; background-color: #111; color: #f8f8f8; padding: 20px;">
    <div style="max-width:600px; margin:auto; background:rgba(0,0,0,0.6); border-radius:12px; padding:25px; border:1px solid rgba(218,165,32,0.4); box-shadow:0 0 10px rgba(218,165,32,0.3);">
        <h2 style="color:#DAA520; text-align:center;">Bienvenido a Camacho Barber 💈</h2>
        <p style="font-size:1.1rem;">Hola <strong>{$this->nombre}</strong>,</p>
        <p>Gracias por registrarte en <strong>Camacho Barber</strong>. Para activar tu cuenta, haz clic en el siguiente botón:</p>
        <p style="text-align:center; margin:30px 0;">
            <a href="{$host}/confirmar-cuenta?token={$this->token}" 
               style="background-color:#DAA520; color:#fff; padding:12px 24px; text-decoration:none; border-radius:8px; font-weight:bold;">
               Confirmar Cuenta
            </a>
        </p>
        <p style="color:#ccc; font-size:0.9rem;">Si no solicitaste esta cuenta, puedes ignorar este mensaje.</p>
        <hr style="border:none; border-top:1px solid rgba(218,165,32,0.2); margin:20px 0;">
        <p style="text-align:center; color:#DAA520; font-weight:bold;">¡Nos vemos pronto en Camacho Barber!</p>
    </div>
</body>
</html>
HTML;

        $mail->AltBody = "Hola {$this->nombre}, confirma tu cuenta en Camacho Barber visitando este enlace: {$host}/confirmar-cuenta?token={$this->token}";

        try {
            return $mail->send();
        } catch (Exception $e) {
            error_log("Error enviando correo de confirmación: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function enviarInstrucciones(): bool {
        $host = $this->getHost();
        $mail = $this->configurarMailer();
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = "Restablece tu contraseña en Camacho Barber";

        $mail->Body = <<<HTML
<html>
<body style="font-family: Arial, sans-serif; background-color: #111; color: #f8f8f8; padding: 20px;">
    <div style="max-width:600px; margin:auto; background:rgba(0,0,0,0.6); border-radius:12px; padding:25px; border:1px solid rgba(218,165,32,0.4); box-shadow:0 0 10px rgba(218,165,32,0.3);">
        <h2 style="color:#DAA520; text-align:center;">Recupera tu acceso 🔑</h2>
        <p style="font-size:1.1rem;">Hola <strong>{$this->nombre}</strong>,</p>
        <p>Recibimos una solicitud para restablecer tu contraseña en <strong>Camacho Barber</strong>.</p>
        <p style="text-align:center; margin:30px 0;">
            <a href="{$host}/recuperar?token={$this->token}" 
               style="background-color:#DAA520; color:#fff; padding:12px 24px; text-decoration:none; border-radius:8px; font-weight:bold;">
               Restablecer Contraseña
            </a>
        </p>
        <p style="color:#ccc; font-size:0.9rem;">Si no solicitaste este cambio, simplemente ignora este mensaje.</p>
        <hr style="border:none; border-top:1px solid rgba(218,165,32,0.2); margin:20px 0;">
        <p style="text-align:center; color:#DAA520; font-weight:bold;">Equipo Camacho Barber ✂️</p>
    </div>
</body>
</html>
HTML;

        $mail->AltBody = "Hola {$this->nombre}, para restablecer tu contraseña visita: {$host}/recuperar?token={$this->token}";

        try {
            return $mail->send();
        } catch (Exception $e) {
            error_log("Error enviando correo de recuperación: " . $mail->ErrorInfo);
            return false;
        }
    }
}

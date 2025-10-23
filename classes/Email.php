<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

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

    public function enviarConfirmacion() {
        $host = $this->getHost();

        $mail = new PHPMailer();
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
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = "Confirma tu cuenta en Camacho Barber";

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        // Construimos el contenido de manera limpia
        $contenido = <<<HTML
<html>
    <body>
        <p><strong>Hola {$this->nombre}</strong>,</p>
        <p>¡Gracias por crear tu cuenta en <strong>Camacho Barber</strong>! Solo debes confirmar tu correo presionando el siguiente enlace:</p>
        <p><a href="{$host}/confirmar-cuenta?token={$this->token}">Confirmar Cuenta</a></p>
        <p>Si no solicitaste esta cuenta, puedes ignorar este mensaje.</p>
        <p>¡Nos vemos pronto en Camacho Barber!</p>
    </body>
</html>
HTML;

        $mail->Body = $contenido;

        if (!$mail->send()) {
            echo "Error enviando correo: " . $mail->ErrorInfo;
            return false;
        }

        return true;
    }

    public function enviarInstrucciones() {
        $host = $this->getHost();

        $mail = new PHPMailer();
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
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = "Restablece tu contraseña en Camacho Barber";

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = <<<HTML
<html>
    <body>
        <p><strong>Hola {$this->nombre}</strong>,</p>
        <p>Has solicitado restablecer tu contraseña en <strong>Camacho Barber</strong>. Haz clic en el siguiente enlace para hacerlo:</p>
        <p><a href="{$host}/recuperar?token={$this->token}">Restablecer contraseña</a></p>
        <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
        <p>¡Saludos de parte del equipo de Camacho Barber!</p>
    </body>
</html>
HTML;

        $mail->Body = $contenido;

        if (!$mail->send()) {
            echo "Error enviando correo: " . $mail->ErrorInfo;
            return false;
        }

        return true;
    }
}

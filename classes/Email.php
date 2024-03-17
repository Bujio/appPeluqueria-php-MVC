<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
  public $email;
  public $nombre;
  public $token;

  public function __construct($email, $nombre, $token)
  {
    $this->email = $email;
    $this->nombre = $nombre;
    $this->token = trim($token);
  }
  public function enviarConfirmacion()
  {


    //Crear el objeto del email
    $email = new PHPMailer();
    $email->isSMTP();
    $email->Host = $_ENV['MAILER_HOST'];
    $email->SMTPAuth = true;
    $email->Port = 2525;
    $email->Username = $_ENV['MAILER_USER'];
    $email->Password = $_ENV['MAILER_PASS'];

    $email->setFrom('admin@bienesraices.com');
    $email->addAddress('admin@bienesraices.com', 'AppPeluqueria.com');
    $email->Subject = 'Confirma tu cuenta';

    //Set HTML
    $email->isHTML(TRUE);
    $email-> CharSet = 'UTF-8';

    $contenido = "<html>";
    $contenido .= "<p><strong>Hola " . $this->nombre . " </strong>. Has creado tu cuenta en App Peluquería, solo debes confirmarla presionando el siguiente enlace</p>";
    $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'> Confirmar Cuenta </a></p>";
    $contenido .= "<p>Si no solicitaste  esta cuenta, puedes ignorar este mensaje.</p>";
    $contenido .= "</html>";
    
    $email->Body = $contenido;

    //ENVIAR EL EMAIL
    $email->send();
  }
}

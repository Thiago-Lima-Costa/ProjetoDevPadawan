<?php

namespace app\support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailSender {

    protected $mailer;
    protected $config;

    public function __construct() {
        $this->mailer = new PHPMailer();
        $this->config = require('emailConfig.php'); 
    }

    public function sendEmail($to, $subject, $htmlContent, $textContent, $attachments = '') {
       
        try {
            // Configurações do servidor SMTP
            $this->mailer->SMTPDebug = 2; //Enable verbose debug output
            $this->mailer->isSMTP(); //Send using SMTP
            $this->mailer->Host = $this->config['smtpHost']; //Set the SMTP server to send through
            $this->mailer->SMTPAuth = true; //Enable SMTP authentication
            $this->mailer->Username = $this->config['smtpUsername']; //SMTP username
            $this->mailer->Password = $this->config['smtpPassword']; //SMTP password
            $this->mailer->SMTPSecure = $this->config['smtpSecure']; //Enable implicit TLS encryption
            $this->mailer->Port = $this->config['smtpPort']; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Configurações do remetente
            $this->mailer->setFrom($this->config['fromEmail'], $this->config['fromName']);

            //Informa o(s) destinatario(s)
            if (is_array($to)) {
                foreach ($to as $receiver) { //Name is optional
                    $this->mailer->addAddress($receiver);
                }
            } else {
                $this->mailer->addAddress($to);
            }

            //Attachments
            if ($attachments != '') {
                $this->mailer->addAttachment($attachments);  //Optional name
            }
            

            // Configurações do email
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $htmlContent;
            $this->mailer->AltBody = $textContent;

            // Envia o email
            $this->mailer->send();

            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}


?>
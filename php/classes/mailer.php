<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require './../config.php';


class Mailer
{

    public $mail;
    private $fromEmail;
    private $fromName;

    public function __construct()
    {
  
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = SMTP_DEBUG;                               
            $mail->isSMTP();       
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );              
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;                           
            $mail->Username = SMTP_USER;                 
            $mail->Password = SMTP_PASSWORD;                           
            $mail->SMTPSecure = SMTP_SECURE;                           
            $mail->Port = SMTP_PORT;  
            $mail->setLanguage(SMTP_LANGUAGE);                                 

            $this->mail = $mail;
            $this->fromEmail = FROM_EMAIL;
            $this->fromName = FROM_NAME;
            
        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }            
    }

    public function sendMail($toAdress,$toName,$subject,$body,$plainTextBody)
    {

        $this->mail->From = $this->fromEmail;
        $this->mail->FromName = $this->fromName;

        $this->mail->addAddress($toAdress, $toName);

        $this->mail->isHTML(true);

        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->AltBody = $plainTextBody;

        $this->mail->send();
    }

    
}

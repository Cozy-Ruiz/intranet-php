<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
//require('phpmailer/PHPMailerAutoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set 
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'backlog@escalante.com.mx';                     //SMTP username
    $mail->Password   = 'B4ckl0g1234';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS

    //Recipients
    $mail->setFrom('backlog@escalante.com.mx', 'Mailer');
    //$mail->addAddress('rgarcia@escalante.com.mx', 'Rick');     //Add a recipient
    $mail->addAddress('zhernandez@intercomm.com.mx');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('lguadarrama@escalante.com.mx');
    //$mail->addBCC('bcc@example.com');

    /*//Attachments
    $mail->addAttachment('../tmp/D-20220202-0004090.pdf');         //Add attachments
    $mail->addAttachment('../logoexcel.png', 'new.jpg');    //Optional name*/

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
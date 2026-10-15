<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García Robles
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../Librerias/RpubMail/vendor/autoload.php';
//require_once '../../radar/Librerias/PHPMailer/class.phpmailer.php';

class MailAltaQueja{
	
	function MailAltaQueja($nombreUsuario, $titulo, $descripcion, $codigoQueja){
		
		try{
			
			$mail = new phpmailer(true);
			//$mail->IsSMTP(); // telling the class to use SMTP
			/*$mail->Mailer   = "smtp";
			$mail->Host     = "mail.escalante.com.mx";
			$mail->Username = "calidad@escalante.com.mx";
			$mail->Password = "C4l1d4d1234";
			$mail->SMTPAuth = true;
			
			$mail->CharSet = "UTF-8";
			$mail->SMTPDebug  = 1;
			$mail->IsHTML(true);*/
			
			$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
			$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set 
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'calidad@escalante.com.mx ';                     //SMTP username
			$mail->Password   = 'nvkyxyfmrknpnbxy';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
	
			$mail->CharSet = "UTF-8";
			$mail->IsHTML(true);
			
			$mail->SetFrom("calidad@escalante.com.mx", "Calidad Grupo Escalante");
			//$mail->AddAddress('sdelap@escalante.com.mx', 'Salvador de la Peña');

			$mail->AddAddress('ogarcia@escalante.com.mx', 'Octavio Garcia');
			$mail->AddAddress('gsistemas@escalante.com.mx', 'Gerente de Sistemas	');
			
			$mail->Subject = "Alta de Queja $codigoQueja";
			// HTML body 
			$body  = "El usuario <b>$nombreUsuario</b> dio de alta la queja <b>$codigoQueja</b>.
					  <br /><br />
					  Titulo:<br />$titulo
					  <br /><br />
					  Descripcion:<br />$descripcion<br /><br />";
			
			$mail->Body = $body;
			$mail->Send();
			
		} catch (phpmailerException $e) {
			
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
			
		} catch (Exception $e) {
			
			echo $e->getMessage(); //Boring error messages from anything else!
			
		}
		
		return true;
		
	}
	
}

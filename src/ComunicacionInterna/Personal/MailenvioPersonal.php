<?php error_reporting(0); ?>
 <?php
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../Librerias/RpubMail/vendor/autoload.php';
	//require_once '../../Librerias/PHPMailer/class.phpmailer.php';
	
	class MailenvioPersonal{
	function MailenvioPersonal($nombrePDF,$nombreUsuario){
		
		
		
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
			$mail->Username   = 'calidad@escalante.com.mx';                     //SMTP username
			$mail->Password   = 'nvkyxyfmrknpnbxy';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
	
			$mail->CharSet = "UTF-8";
			$mail->IsHTML(true);
			
			$mail->SetFrom("calidad@escalante.com.mx", "Calidad Grupo Escalante");
				//lista de distribucion
				$mail->AddAddress('amartinez@escalante.com.mx', 'Alberto Martinez');
				//$mail->AddAddress('ehernandez@escalante.com.mx', 'Elena Hernández');
				//$mail->AddAddress('pmoyotl@escalante.com.mx', 'Pedro Moyotl');
				
				$mail->Subject = "Ficha Personal";
				$body  = "Adjunto archivo de acceso a Sistemas Grupo Escalante del personal $nombreUsuario.<br><br>
						  Saludos.";
				$mail->Body = $body;
				$mail->AddAttachment($nombrePDF);
				$mail->Send();
				
			} catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
			}
			
			return true;
		}
	}
	
?>

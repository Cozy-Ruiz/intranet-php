<?php error_reporting(0); ?>
<?php
	//require_once '../Librerias/PHPMailer/class.phpmailer.php';
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../Librerias/RpubMail/vendor/autoload.php';
	class MailAcuerdoEvaluar{
		
		function MailAcuerdoEvaluar($codigoSolicitud, $correoPDR, $nombrePDR, $evaluacion, $descripcionMail){
			
			try{
				
				$mail = new phpmailer(true);
				//$mail->IsSMTP(); // telling the class to use SMTP
				/*$mail->Mailer   = "smtp";
				$mail->Host     = "smtp.office365.com";
				$mail->Port     = "587";
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
				//$mail->AddAddress('sdelap@escalante.com.mx', 'Salvador de la Peña');
				$mail->AddAddress($correoPDR, $nombrePDR);
				//$mail->AddCC('ogarcia@escalante.com.mx', 'Octavio García');
				if($evaluacion == 'RECHAZADO'){
					$titulo = "$codigoSolicitud Rechazada";
					$body 	= "Saludos $nombrePDR<br><br>
							   La revisión del acuerdo <b>$codigoSolicitud</b> ha sido rechazado.<br><br><br>
							   
							   Asunto: Estatus - Rechazado<br><br>
							   Detalles: $descripcionMail<br>
							   ";
				}else if($evaluacion == 'TERMINADO'){
					$titulo = "$codigoSolicitud Terminado";
					$body 	= "Saludos $nombrePDR<br><br>
							   La revisión del acuerdo <b>$codigoSolicitud</b> ha sido terminado.<br><br><br>
							   
							   Asunto: Estatus - Terminado<br><br>
							   Detalles: $descripcionMail<br>
							   ";
				}
				
				$mail->Subject 	= $titulo;
				$mail->Body 	= $body;
				
				$mail->Send();
				
			} catch (phpmailerException $e) {
				
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				
			} catch (Exception $e) {
				
				echo $e->getMessage(); //Boring error messages from anything else!
				
			}
			
			return true;
		}
	}

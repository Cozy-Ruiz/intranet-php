<?php error_reporting(0); ?>
<?php

//require_once '../INTRANET_GEA/Librerias/PHPMailer/class.phpmailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../Librerias/RpubMail/vendor/autoload.php';

		$usuario       = "Alberto_Martinez" ;
		$nombreUsuario = "Alberto Martinez Martinez";
		$categoria     = "Administrador";
		$correo        = "amartinez@escalante.com.mx" ;
		$contraseña    = "Alberto080790" ;
	
	//class MailAltaUsuario{
		
		
		//function MailAltaUsuario($usuario, $nombreUsuario, $categoria, $correo, $contraseña){
			
			try{
				
				$mail = new phpmailer(true);
				//$mail->IsSMTP(); // telling the class to use SMTP
				/*$mail->Mailer   = "smtp";
				$mail->Host     = "smtp.office365.com.mx";
				$mail->Port     = "587";
				$mail->Username = "calidad@escalante.com.mx";
				$mail->Password = "C4l1d4d1234";
				$mail->SMTPAuth = true;
				
				$mail->CharSet = "UTF-8";
				$mail->SMTPDebug  = 1;
				$mail->IsHTML(true);*/
				
				$mail->SetFrom("calidad@escalante.com.mx", "Grupo Escalante");
				$mail->AddAddress($correo, $nombreUsuario);
				//$mail->AddCC('sdelap@escalante.com.mx', 'Salvador de la Peña');
				//$mail->AddCC('rromo@escalante.com.mx', 'Rodrigo Romo');
				//$mail->AddCC('amartinez@escalante.com.mx', 'Alberto Martinez');
				
				
				$mail->Subject = "Acceso Sistemas Grupo Escalante";
				
				// HTML body 
				
				$body  = "Saludos, $nombreUsuario:<br><br><br>

						Tu usuario ha sido dado de alta para el acceso a Sistemas Grupo Escalante.<br><br><br>

						Los datos para que puedas entrar son los siguientes:<br><br>
						URL: https://escalante.com.mx/Sistemas/<br>
						Usuario: $usuario<br>
						Contraseña: $contraseña<br><br>";
					
				
				$mail->Body = $body;
				
				$mail->Send();
				
			} catch(phpmailerException $e){
				
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				
			} catch (Exception $e){
				
				echo $e->getMessage(); //Boring error messages from anything else!
				
			}
			
			return true;
		//}
	//}
?>
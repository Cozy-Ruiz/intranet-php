<?php error_reporting(0); ?>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../Librerias/RpubMail/vendor/autoload.php';
//require_once '../../Librerias/PHPMailer/class.phpmailer.php';

class MailAltaUsuario{
	
	function MailAltaUsuario($tipoSolicitud, $usuario, $sistemaSolicitud,$nombreCompleto,$correo,$puesto){
		
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
			
			if($sistemaSolicitud != 'SCIA' && $sistemaSolicitud != 'AXAPTA'){
				
			$mail->AddAddress('altasistemas@escalante.com.mx', 'Sistemas');
			
			if($tipoSolicitud == 'ACTIVO'){
				
			$mail->Subject = "ALTA a $nombreCompleto en $sistemaSolicitud";
			
			}else if($tipoSolicitud == 'INACTIVO'){// HTML body 
			
			$mail->Subject = "BAJA a $nombreCompleto en $sistemaSolicitud";
			
			}
			
			
			if($tipoSolicitud == 'ACTIVO'){
			$body  = "Crear un usuario en <b>$sistemaSolicitud</b> a $nombreCompleto en Sistemas Grupo Escalante.<br><br>Correo Electronico: $correo<br><br><br>Gracias.";

			}else if($tipoSolicitud == 'INACTIVO'){// HTML body 
			
			$body  = "Solicitud para dar de baja en <b>$sistemaSolicitud</b> a $nombreCompleto en Sistemas Grupo Escalante.<br><br>
					  Saludos<br><br><br>Gracias";
			
			}
			//Para el sistema SCIA
			}if($sistemaSolicitud == 'SCIA'){
				
			$mail->AddAddress('scia@escalante.com.mx', 'SCIA');
			
			if($tipoSolicitud == 'ACTIVO'){
				
			$mail->Subject = "ALTA a $nombreCompleto en $sistemaSolicitud";
			
			}else if($tipoSolicitud == 'INACTIVO'){// HTML body 
			
			$mail->Subject = "BAJA a $nombreCompleto en $sistemaSolicitud";
			
			}
			if($tipoSolicitud == 'ACTIVO'){
			$body  = "Saludos, Cuauhtemoc Ugalde.<br><br>
					  Por favor crear un usuario en <b>$sistemaSolicitud</b> a $nombreCompleto, Grupo Escalante.<br><br>Correo Electronico: $correo<br>Puesto: $puesto<br><br>
					  Gracias.";

			}else if($tipoSolicitud == 'INACTIVO'){// HTML body 
			
			$body  = "Saludos, Cuauhtemoc Ugalde.<br><br>
					  Solicitud para dar de baja en <b>$sistemaSolicitud</b> a $nombreCompleto, Grupo Escalante. <br><br><br> 
					  Gracias";
			
			}//Para el sistema AXAPTA
			}if($sistemaSolicitud == 'AXAPTA'){
				
			$mail->AddAddress('axapta@escalante.com.mx', 'Axapta');
			//$mail->AddAddress('amartinez@escalante.com.mx', 'Alberto Martinez');
			
			if($tipoSolicitud == 'ACTIVO'){
				
			$mail->Subject = "Alta a $nombreCompleto en $sistemaSolicitud";
			
			}else if($tipoSolicitud == 'INACTIVO'){// HTML body 
			
			$mail->Subject = "Baja a $nombreCompleto en $sistemaSolicitud";
			
			}
			if($tipoSolicitud == 'ACTIVO'){
			$body  = "Saludos, Emmanuel Crisanto.<br><br>
					  Por favor crear un usuario en <b>$sistemaSolicitud</b> a $nombreCompleto, Grupo Escalante.<br><br>Correo Electronico: $correo<br>Puesto: $puesto<br><br>Gracias.";

			}else if($tipoSolicitud == 'INACTIVO'){// HTML body 
			
			$body  = "Saludos Emmanuel Crisanto.<br><br>
					  Solicitud para dar de Baja en <b>$sistemaSolicitud</b> a $nombreCompleto, Grupo Escalante.<br><br><br>Gracias.";
			
			}
		}
			
			
			
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

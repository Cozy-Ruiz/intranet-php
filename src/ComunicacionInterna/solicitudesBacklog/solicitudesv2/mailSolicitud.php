<?php error_reporting(0); ?>
<?php

//script que envia correo a la paersona encargada de validar la solicitud y/o asignar PDR
require_once("ConexionDBT.php");
//require_once('../Librerias/PHPMailer/class.phpmailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../../Librerias/RpubMail/vendor/autoload.php';

//funcion para enviar correo de aviso de solicitud
class MailSolicitudAsignar{
	
	function MailSolicitudAsignar($codigoSolicitud, $tituloMail, $descripcionM, $tipoS){
	
		if($tipoS == "MT"){
			
			$tipoSol = "MANTENIMIENTO SISTEMAS";
		}
	//defino parametros para el mail
	
	try{
		//PDR
		$mail = new phpmailer(true);
		//$mail->IsSMTP(); // telling the class to use SMTP
		/*$mail->Mailer   = "smtp";
		$mail->Host     = "mail.escalante.com.mx";
		$mail->Username = "calidad@escalante.com.mx";
		$mail->Password = "C4l1d4d1234";
		$mail->SMTPAuth = true;
		
		$mail->CharSet = "UTF-8";
		$mail->SMTPDebug  = 1;
		$mail->Port      = 587;
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
		$mail->AddAddress('gsistemas@escalante.com.mx', 'Gerente de Sistemas');
		
		
		$titulo = "Atención de solicitud";
		$body 	= "Saludos Gerente de Sistemas,<br><br>
				   La solicitud con número de codigo: <b>$codigoSolicitud</b> de tipo <b>$tipoSol</b> requiere aprobación.<br><br>
				   <b>Asunto:</b> $tituloMail<br>
				   <b>Descripción del problema:</b> $descripcionM <br><br> 
				   Gracias.";
				   
		$mail->Subject 	= $titulo;
		$mail->Body 	= $body;
		
		$mail->Send();
			
	
	} catch (phpmailerException $e) {
		echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		echo $e->getMessage(); //Boring error messages from anything else!
	}
			
	return true;
		
	}//fin de la funcion
		
		
}//fin de la clase


//llamo a la funcion para mandar correo de aviso

//$clase = new MailSolicitudAsignar($codigoSolicitudID, $titulo, $descripcion, $tipoSolicitud);



?>

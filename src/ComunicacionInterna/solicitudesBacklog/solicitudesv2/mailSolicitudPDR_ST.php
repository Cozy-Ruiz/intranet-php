<?php //error_reporting(0); ?>
<?php
echo "entro 1";
//script que envia correo a la paersona encargada de validar la solicitud y/o asignar PDR
	require_once("../../../ConexionDBT.php");
	//require_once('../../../Librerias/PHPMailer/class.phpmailer.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	//Load Composer's autoloader
	require '../../../Librerias/RpubMail/vendor/autoload.php';

//funcion para enviar correo de aviso de solicitud
class MailSolicitudAsignar{

	 function MailSolicitudAsignar($codS, $correoPDR, $nombrePDR, $tipoS, $tituloMail, $descripcionM, $correoSolicitante, $nombreSolicitante){
		echo " entro2";
	
		if($tipoS == "ST"){
			echo " vamos bien";
			$tipoSol = "SOPORTE TECNICO";
		}
	//defino parametros para el mail
	echo $descripcionM;
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
		
				$mail->AddAddress($correoPDR, $nombrePDR);
				//$mail->AddAddress('zhernandez@intercomm.com.mx', 'Zurith Hernandez Nava');
				
		$titulo = "Atención de solicitud";
		$body 	= "Saludos, $nombrePDR<br><br>
				   La solicitud con número de codigo: <b>$codS</b> de tipo <b>$tipoSol</b> ha sido asignado para tu atención.<br><br>	
				   Asunto: $tituloMail<br><br>
				   Detalles: $descripcionM<br>
				   ";
				   
		$mail->Subject 	= $titulo;
		$mail->Body 	= $body;
		
		$mail->Send();
		
		//Solicitante
		if($correoSolicitante != ""){
			$mail = new phpmailer(true);
			//$mail->IsSMTP(); // telling the class to use SMTP
			/*$mail->Mailer   = "smtp";
			$mail->Host     = "mail.escalante.com.mx";
			$mail->Username = "backlog@escalante.com.mx";
			$mail->Password = "B4ckl0g1234";
			$mail->SMTPAuth = true;
			
			$mail->CharSet = "UTF-8";
			$mail->SMTPDebug  = 1;
			$mail->IsHTML(true);*/
			
		$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set 
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'backlog@escalante.com.mx';                     //SMTP username
		$mail->Password   = 'B4ckl0g1234';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS

		$mail->CharSet = "UTF-8";
		$mail->IsHTML(true);
		
			$mail->SetFrom("backlog@escalante.com.mx", "Backlog");
			$mail->AddAddress($correoSolicitante, $nombreSolicitante);
			//$mail->AddAddress('zhernandez@intercomm.com.mx', 'Zurith Hernandez Nava');
			
			$titulo = "Atención de solicitud";
							
				$body 	= "Saludos, $nombreSolicitante<br><br>
					   <b>$nombrePDR</b> va atender tu solicitud <b>$codS</b> .<br><br><br>
					   Asunto: $tituloMail<br>
					   Detalles: $descripcionM
					   ";
			
			$mail->Subject 	= $titulo;
			$mail->Body 	= $body;
			
			$mail->Send();
			
		}

		if($correoPDR == 'zhernandez@escalante.com.mx' || $correoPDR == 'jhuerta@escalante.com.mx' || $correoPDR == 'jjeronimo@escalante.com.mx'){

			$mail = new phpmailer(true);
				
				$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
				$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set 
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'backlog@escalante.com.mx';                     //SMTP username
				$mail->Password   = 'B4ckl0g1234';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
		
				$mail->CharSet = "UTF-8";
				$mail->IsHTML(true);

				$mail->SetFrom("backlog@escalante.com.mx", "Backlog");
				$mail->AddAddress('noc@intercomm.mx', 'nocIntercomm');
				
				$titulo = "Solicitudes en atención";
									
					$body 	= "Saludos, Equipo Intercomm<br><br>
						   La solicitud <b>$codS</b> ha sido asignada para $nombrePDR.<br><br><br>
						   Asunto: $tituloMail<br><br>
						   Detalles: $descripcionM<br>
						   ";
				
				$mail->Subject 	= $titulo;
				$mail->Body 	= $body;
				
				$mail->Send();
		}
	
	 } catch (phpmailerException $e) {
	 	echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		echo $e->getMessage(); //Boring error messages from anything else!
	}
			
	// return true;
		
	 }//fin de la funcion
		
		
}//fin de la clase


//llamo a la funcion para mandar correo de aviso

//$clase = new MailSolicitudAsignar($codigoSolicitudID, $titulo, $descripcion, $tipoSolicitud);



?>

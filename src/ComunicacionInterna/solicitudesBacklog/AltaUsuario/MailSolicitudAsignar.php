<?php error_reporting(0); ?>
<?php
	/*
	 *@version 1.0
	 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
	 */
	require_once("../../../ConexionDBT.php");
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../../Librerias/RpubMail/vendor/autoload.php';
	//require_once '../../../Librerias/PHPMailer/class.phpmailer.php';
	
	class MailSolicitudAsignar{
		
		function MailSolicitudAsignar($codigoSolicitud, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $codigoEntregable, $prioridad, $posicion){

			//obtengo codigo de entregable
			//echo $codigoEntregable = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.ENTREGABLES WHERE xt_solicitud = '$codigoSolicitud'");
			//$codigoEntregable = "123";
			try{
				//PDR
				if($correoPDR != ""){
					
					if($prioridad == "Urgente"){
						
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
						$mail->AddAddress($correoPDR, $nombrePDR);
						
						$titulo = "Atención de solicitud";
						
						if($codigoEntregable != ''){
							
							$body 	= "Saludos, $nombrePDR<br><br>
								   El entregable <b>$codigoEntregable</b> ha sido asignado para tu atención.<br><br><br>
								   Codigo de solicitud: $codigoSolicitud<br>
								   Prioridad: $prioridad<br>
								   Asunto: $tituloMail<br><br>
								   Detalles: $descripcionMail<br>
								   ";
							
						}else{
							
							$body 	= "Saludos, $nombrePDR<br><br>
								   La solicitud <b>$codigoSolicitud</b> ha sido asignada para tu atención.<br><br><br>
								   Asunto: $tituloMail<br><br>
								   Detalles: $descripcionMail<br>
								   ";
						}
						
						
						$mail->Subject 	= $titulo;
						$mail->Body 	= $body;
						
						$mail->Send();
					
					}//fin de verificacion de prioridad
				}
				
				
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
					
					$titulo = "Atención de solicitud";
					
					if($codigoEntregable != ''){
						
						$body 	= "Saludos, $nombreSolicitante<br><br>
							   <b>$nombrePDR</b> va atender tu solicitud <b>$codigoSolicitud</b> .<br><br><br>
							   codigo de Entregable: $codigoEntregable <br>
							   Asunto: $tituloMail<br>
							   Detalles: $descripcionMail<br>
							   Posicion de entregable: $posicion
							   ";
						
					}else{
						
						$body 	= "Saludos, $nombreSolicitante<br><br>
							   <b>$nombrePDR</b> va atender tu solicitud <b>$codigoSolicitud</b> .<br><br><br>
							   
							   Asunto: $tituloMail<br><br>
							   Detalles: $descripcionMail<br>
							   ";
					}
					
					
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
				}
				
			} catch (phpmailerException $e) {
				
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				
			} catch (Exception $e) {
				
				echo $e->getMessage(); //Boring error messages from anything else!
				
			}
			
			return true;
		}
	}
?>

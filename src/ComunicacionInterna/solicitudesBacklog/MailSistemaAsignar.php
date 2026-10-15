<?php error_reporting(0); ?>
﻿<?php
	//require_once '../../Librerias/PHPMailer/class.phpmailer.php';
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../Librerias/RpubMail/vendor/autoload.php';
	class MailSistemaAsignar{
		
		function MailSistemaAsignar($codigoE, $codigoSolicitud, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tipo, $tituloMail, $descripcionMail, $sistema,$INTRANET){

			try{
				
				if($correoPDR != ''){
					//PDR
					$mail = new phpmailer(true);
					//$mail->IsSMTP(); // telling the class to use SMTP
					/*$mail->Mailer   = "smtp";
					$mail->Host     = "mail.escalante.com.mx";
					$mail->Username = "backlog@escalante.com.mx";
					$mail->Password = "B4ckl0g1234";
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
					$mail->Username   = 'backlog@escalante.com.mx';                     //SMTP username
					$mail->Password   = 'B4ckl0g1234';                               //SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
			
					$mail->CharSet = "UTF-8";
					$mail->IsHTML(true);

					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoPDR, $nombrePDR);
					
					$titulo = "Atención de solicitud";
					$body 	= "Saludos, $nombrePDR,<br><br>
							   El entregable <b>$codigoE</b> ha sido asignado para tu atención.<br><br><br>
							   
							   Asunto: $tituloMail<br><br>
							   Sistema: $sistema<br><br>
							   Tipo: $tipo<br><br>
							   Detalles: $descripcionMail<br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					//$mail->AddAttachment($ruta);
					$mail->Send();
				}
				
				if($correoSolicitante != ''){
					//PDR
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
					$body 	= "Saludos, $nombreSolicitante,<br><br>
							   <b>$nombrePDR</b> va atender tu solicitud <b>$codigoSolicitud</b> .<br><br><br>
							   codigo de Entregable: $codigoE <br>
							   
							   Asunto: $tituloMail<br><br>
							   Sistema: $sistema<br><br>
							   Tipo: $tipo<br><br>
							   Detalles: $descripcionMail<br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					//$mail->AddAttachment($ruta);
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

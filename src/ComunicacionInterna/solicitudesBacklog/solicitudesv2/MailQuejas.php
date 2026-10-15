<?php error_reporting(0); ?>
<?php
	/*
	 *@author Richard Ruiz Avendaño
	 *@version 1.0
	 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
	 */
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../../Librerias/RpubMail/vendor/autoload.php';
	//require_once '../../../Librerias/PHPMailer/class.phpmailer.php';
	
	class MailQuejas{
		function mailQuejasEnv($codigoSolicitud, $correoSolicitante, $nombreSolicitante, $correoPDR, $nombrePDR, $correoDirectivos, $nombreDirectivos, $tipo){
			
			if($tipo == "NuevaQueja"){	
				try{
					//GERENTE DE CALIDAD
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
							
					$mail->SetFrom("calidad@escalante.com.mx", "Calidad Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Atención de Queja";
					$body 	= "Saludos, $nombreSolicitante. <br><br>
							   La queja <b>$codigoSolicitud</b> esta en proceso de atención.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->AddAttachment("D:/INTRANET/documentosQuejas/".$codigoSolicitud."/".$codigoSolicitud."_AcusedeRecibodeQueja.pdf",$codigoSolicitud."_AcusedeRecibodeQueja.pdf");
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}else if($tipo == "QuejaPdr"){	
				try{
					//GERENTE DE CALIDAD
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
							
					$mail->SetFrom("calidad@escalante.com.mx", "Calidad Escalante");
					$mail->AddAddress($correoPDR, $nombrePDR);
					
					$titulo = "Atención de Queja";
					$body 	= "Saludos, $nombrePDR. <br><br>
							   La queja <b>$codigoSolicitud</b> fue asignada para tu atención.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					//$mail->AddAttachment("D:/INTRANET/documentosQuejas/".$codigoSolicitud."/".$codigoSolicitud."_AcusedeRecibodeQueja.pdf",$codigoSolicitud."_AcusedeRecibodeQueja.pdf");
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
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
							   La solicitud <b>$codigoSolicitud</b> ha sido asignada para $nombrePDR.<br><br><br>
							   Asunto: $tituloMail<br><br>
							   Detalles: $descripcionMail<br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
			}
			
		}
	}
?>

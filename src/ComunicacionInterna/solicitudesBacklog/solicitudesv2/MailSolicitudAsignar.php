<?php
	/*
	 *@version 1.0
	 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
	 */

	//require_once("../../../ConexionDBT.php");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	//Load Composer's autoloader
	require 'RpubMail/vendor/autoload.php';
	//require "../../../ConexionIntranet2.php";
	//require_once('../../../Librerias/PHPMailer/class.phpmailer.php');

	class MailSolicitudAsignar{
		
		public function mailSolicitudAsignar($codigoSolicitud, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $codigoEntregable, $prioridad, $posicion){
		
		//echo "SELECT xt_tipo FROM sgi_backlog_solicitud_sistemas_temporal WHERE xt_codigoEntregable = '$codigoEntregable'";
					/*echo $tipo = $INTRANET->Execute("SELECT xt_tipo FROM sgi_backlog_solicitud_sistemas_temporal WHERE xt_codigoEntregable = '$codigoEntregable'");
					
					echo $sistema = $INTRANET->getOne("SELECT xt_sistema FROM sgi_backlog_solicitud_sistemas_temporal WHERE xt_codigoEntregable = '$codigoEntregable'");*/
					
			try{
				//echo $codigoSolicitud." - ".$correoPDR;
				//PDR
				if($correoPDR != ""){
						

				$mail = new PHPMailer(true);
				//$mail->IsSMTP(); // telling the class to use SMTP
				/*$mail->Mailer   = "smtp";
				$mail->Host     = "mail.escalante.com.mx";
				$mail->Username = "backlog@escalante.com.mx";
				$mail->Password = "Qazwsx12";
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

				$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante")or die("no paso");
				
						$mail->AddAddress($correoPDR, $nombrePDR);
						//$mail->AddAddress('lguadarrama@escalante.com.mx', 'lizzz7u7r');
						//$mail->AddAddress('zhernandez@intercomm.com.mx', 'YopYop7u7r');
						$titulo = "Atención de solicitud";
						
						if($codigoEntregable != ''){
							if($nombrePDR == 'Elionay Aldana MuÃ±oz'){
								$body 	= "Saludos, $nombrePDR<br><br>
								   El entregable <b>$codigoEntregable</b> ha sido asignado para tu atención.<br><br><br>
								   Codigo de solicitud: $codigoSolicitud<br>
								   Prioridad: $prioridad<br>
								   Asunto: $tituloMail - PROPROFS<br><br>
								   Detalles: $descripcionMail<br>
								   ";
							}else{
							$body 	= "Saludos, $nombrePDR<br><br>
								   El entregable <b>$codigoEntregable</b> ha sido asignado para tu atención.<br><br><br>
								   Codigo de solicitud: $codigoSolicitud<br>
								   Prioridad: $prioridad<br>
								   Asunto: $tituloMail<br><br>
								   Detalles: $descripcionMail<br>
								   ";
							}
						}else{
							
							$body = "Saludos, $nombrePDR<br><br>
								   La solicitud <b>$codigoSolicitud</b> ha sido asignada para tu atención.<br><br><br>
								   Asunto: $tituloMail<br><br>
								   Detalles: $descripcionMail<br>
								   ";
						}

						//echo "<br>";
						//echo $body;
						
						$mail->Subject 	= $titulo;
						$mail->Body 	= $body;
						
						$mail->Send()or die("nel, no se pudo");
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
						//$mail->AddAddress('zhernandez@escalante.com.mx', 'nocIntercomm');
						
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

				//Solicitante
				if($correoSolicitante != ""){
					$mail = new PHPMailer(true);

					//$mail->IsSMTP(); // telling the class to use SMTP
					/*$mail->Mailer   = "smtp";
					$mail->Host     = "mail.escalante.com.mx";
					$mail->Username = "backlog@escalante.com.mx";
					$mail->Password = "Qazwsx12";
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
					//$mail->AddAddress('lguadarrama@escalante.com.mx', 'lizzz7u7r');
						//$mail->AddAddress('zhernandez@intercomm.com.mx', 'YopYop7u7r');
					
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
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
			
			return true;
		}
	}

	
	//$mailSolicitudEnviar = new MailSolicitudAsignar;
	//$mailSolicitudEnviar->mailSolicitudAsignar('GE-B-CUN-25-00005', 'gsistemas@escalante.com.mx', 'Gerente de Sistemas', 'cruiz@escalante.com.mx', 'cozy', 'Pruba mail solicitud', 'Saludos', null, null, null);
?>

<?php error_reporting(0); ?>
<?php
	
	//require_once '../../../Librerias/PHPMailer/class.phpmailer.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	//Load Composer's autoloader
	require '../../../Librerias/RpubMail/vendor/autoload.php';
	
	class MailNuevaFuncionalidad{
		function MailNuevaFuncionalidad($codigoSolicitud, $correoSolicitante, $nombreSolicitante, $correoPDR, $nombrePDR, $correoDirectivos, $nombreDirectivos, $tipo){
			
			if($tipo == "ValidacionTecnica"){	
				try{
					//GERENTE DE SISTEMAS
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
					$body 	= "Saludos, $nombrePDR. <br><br>
							   La solicitud <b>$codigoSolicitud</b> necesita validación técnica.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}else if($tipo == "ValidacionTecnicaProcede"){
				try{
					
					//SOLICITANTE
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Validación Técnica de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombreSolicitante. <br><br>
							   La validación técnica de la solicitud <b>$codigoSolicitud</b> fue aprobada. <br><br> 
							   La solicitud procede a validación de Negocio.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
					
					
					//DIRECTIVOS
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoDirectivos, $nombreDirectivos);
					
					$titulo = "Validación técnica de la solicitud $codigoSolicitud";
					$body 	= "Saludos. <br><br>
							   El requerimiento de la solicitud <b>$codigoSolicitud</b> requiere validación de Negocio. La validación técnica fue positiva. <br><br>
							   Favor de ir a la ficha correspondiente para mas detalles.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}else if($tipo == "ValidacionNegocioProcede"){
				try{
					
					//SOLICITANTE
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Validación de negocio de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombreSolicitante. <br><br>
							   El requerimiento de la solicitud <b>$codigoSolicitud</b> fue aprobado. <br><br> 
							   La solicitud procede a validación final de requerimientos.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
					
					//GERENTE DE SISTEMAS
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoPDR, $nombrePDR);
					
					$titulo = "Validación de negocio de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombrePDR. <br><br>
							   El requerimiento de la solicitud <b>$codigoSolicitud</b> fue aprobado. <br><br>
							   La solicitud procede a validación final de requerimientos.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}if($tipo == "ValidacionFinalProcede"){
				try{
					
					//SOLICITANTE
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Validación final de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombreSolicitante. <br><br>
							   La validación final de la solicitud <b>$codigoSolicitud</b> fue aprobada y el requerimiento procede a su ejecución.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
					
					
					//DIRECTIVOS
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoDirectivos, $nombreDirectivos);
					
					$titulo = "Validación final de la Solicitud $codigoSolicitud";
					$body 	= "Saludos. <br><br>
							   La validación final de la solicitud <b>$codigoSolicitud</b> fue aprobada y el requerimiento procede a su ejecución.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}else if($tipo == "ValidacionTecnicaNoProcede"){
				try{
					
					//SOLICITANTE
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Validación Técnica de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombreSolicitante. <br><br>
							   La validación técnica de la solicitud <b>$codigoSolicitud</b> fue rechazada.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}else if($tipo == "ValidacionNegocioNoProcede"){
				try{
					
					//SOLICITANTE
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Validación de negocio de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombreSolicitante. <br><br>
							   El requerimiento de la solicitud <b>$codigoSolicitud</b> fue rechazado.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
					
					//GERENTE DE SISTEMAS
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoPDR, $nombrePDR);
					
					$titulo = "Validación de negocio de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombrePDR. <br><br>
							   El requerimiento de la solicitud <b>$codigoSolicitud</b> fue rechazado.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}if($tipo == "ValidacionFinalNoProcede"){
				try{
					
					//SOLICITANTE
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Validación final de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombreSolicitante<br><br>
							   La validación final de la solicitud <b>$codigoSolicitud</b> fue rechazada.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
					
					
					//DIRECTIVOS
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoDirectivos, $nombreDirectivos);
					
					$titulo = "Validación final de la Solicitud $codigoSolicitud";
					$body 	= "Saludos.<br><br>
							   La validación final de la solicitud <b>$codigoSolicitud</b> fue rechazada.<br><br><br>
							   ";
					
					$mail->Subject 	= $titulo;
					$mail->Body 	= $body;
					
					$mail->Send();
									
				} catch (phpmailerException $e) {
					
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
					
				} catch (Exception $e) {
					
					echo $e->getMessage(); //Boring error messages from anything else!
					
				}
				
				return true;
				
			}else if($tipo == "LiberacionProcede"){
				try{
					
					//SOLICITANTE
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
					
					$mail->SetFrom("backlog@escalante.com.mx", "Backlog Grupo Escalante");
					$mail->AddAddress($correoSolicitante, $nombreSolicitante);
					
					$titulo = "Liberación de la Solicitud $codigoSolicitud";
					$body 	= "Saludos, $nombreSolicitante. <br><br>
							   El requerimiento de la solicitud <b>$codigoSolicitud</b> está listo para pruebas.<br><br><br>
							   ";
					
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
	}
?>

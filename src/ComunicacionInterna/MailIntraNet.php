<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
	//Created by Cosijopi Richard Ruiz Avendaño
	//Ing. Sistemas Computacionales
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../Librerias/RpubMail/vendor/autoload.php';
	//require_once '../../radar/Librerias/PHPMailer/class.phpmailer.php';
	
	class MailIntraNet{
		function MailIntraNet($usuarioId, $ciudad, $titulo, $descripcion, $id, $tipo){
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
				$mail->Username   = 'calidad@escalante.com.mx ';                     //SMTP username
				$mail->Password   = 'nvkyxyfmrknpnbxy';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
				
				$mail->CharSet = "UTF-8";
				$mail->IsHTML(true);
			
				
				$mail->SetFrom("calidad@escalante.com.mx", "Calidad Grupo Escalante");
				//$mail->AddAddress('sdelap@escalante.com.mx', 'Salvador de la Peña');
				$mail->AddCC('cruiz@escalante.com.mx', 'Richard Ruiz');
				
				
				
				if($tipo == "solicitud"){
					$mail->Subject = $titulo;
					// HTML body 
					$body  = "El usuario <b>$usuarioId</b> de <b>$ciudad</b> dio de alta la $tipo <b>$id.</b> <br><br> $titulo <br><br> $descripcion";
				}else if($tipo == "asignada"){
					$mail->AddCC($usuarioId, $usuarioId);	
					$mail->AddCC($ciudad, $ciudad);
					$mail->Subject = $id;
					$body = "$titulo <br><br> $descripcion";
				}
				
				$mail->Body = $body;
				/*
				for($a=0; $a<count($local_file); $a++){
					$mail->AddAttachment($local_file[$a], $nombreArchivo[$a]);
				}*/
		
				$mail->Send();
				
				/*
				for($a=0; $a<count($local_file); $a++){
					unlink($local_file[$a]);
				}*/
				
			} catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
			}
			
			return true;
		}
	}
?>
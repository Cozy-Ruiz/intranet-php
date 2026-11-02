<?php error_reporting(0); ?>
<?php
	/*
	 *@author Octavio F. García Robles
	 *@version 1.0
	 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
	 */
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'Librerias/RpubMail/vendor/autoload.php';
	//require_once 'Librerias/PHPMailer/class.phpmailer.php';
	
	class MailRecuperaPass{
		
		function MailRecuperaPass($userIntranet, $INTRANET){
			
			$s = $INTRANET->Execute("SELECT xt_correo, xt_password, xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$userIntranet' ");
			
			while($r = $s->fetchRow()){
				
				$correoUser 	= $r[0];
				$passRecuperada	= $r[1];
				$nombre			= $r[2];
				
			} unset($r); unset($s);
			
			
			try{
				
				$mail = new phpmailer(true);
				//$mail->IsSMTP(); // telling the class to use SMTP
				/*$mail->Mailer   = "smtp";
				$mail->Host     = "smtp.office365.com";
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
				$mail->Password   = 'vvjgbgnkdpndqcjd';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
		
				$mail->CharSet = "UTF-8";
				$mail->IsHTML(true);
				$mail->SetFrom("calidad@escalante.com.mx", "Calidad Grupo Escalante");
				$mail->AddAddress($correoUser, $nombre);
				$mail->AddCC('ogarcia@escalante.com.mx', 'Octavio García');
				$mail->AddCC('rromo@escalante.com.mx', 'Rodrigo Romo');
				
				$titulo = "Acceso Intranet";
				$body 	= "Saludos, $nombre<br><br>
						   Estos son los datos para que puedas entrar a la Intranet de Grupo Escalante:<br><br>
						   URL: https://escalante.com.mx/INTRANET_GEA/Login.php <br>
						   Usuario: $userIntranet <br>
						   Contraseña: $passRecuperada <br><br><br>";
				
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

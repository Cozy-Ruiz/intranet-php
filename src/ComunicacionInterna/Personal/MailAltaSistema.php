<?php error_reporting(0); ?>
 <?php
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../Librerias/RpubMail/vendor/autoload.php';
	//require_once '../../Librerias/PHPMailer/class.phpmailer.php';
	
	class MailAltaSistema{
	function MailAltaSistema($fecha,$usuario1, $sistema1, $estatus1, $ruta, $archivo, $INTRANET){
		
		$s = $INTRANET->Execute("SELECT xt_nombre FROM PERFILES.USUARIOS WHERE xt_usuario = '$usuario1'  ");
			
			while($r = $s->fetchRow()){
				
				$nombre 	= $r[0];
				
			} unset($r); unset($s);
			
		
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
				//lista de distribucion
				if($estatus1 == 'ALTA'){
				$mail->AddAddress('amartinez@escalante.com.mx', 'Alberto Martinez');
				$mail->AddAddress('gsistemas@escalante.com.mx', 'Gerente de Sistemas');
				}else if($estatus1 == 'BAJA'){
				$mail->AddAddress('amartinez@escalante.com.mx', 'Alberto Martinez');
				$mail->AddAddress('gsistemas@escalante.com.mx', 'Gerente de Sistemas');
				}
				
				$mail->Subject = "$estatus1 a Sistemas Grupo Escalante";
				$body  = "$estatus1 en $sistema1 a $nombre, Sistemas Grupo Escalante $fecha.<br><br>
						Saludos.";
				$mail->Body = $body;
				if($archivo != ''){
					$mail->AddAttachment($ruta."/".$archivo, $archivo);
				}
				$mail->Send();
				
			} catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
			}
			
			return true;
		}
	}
	
?>
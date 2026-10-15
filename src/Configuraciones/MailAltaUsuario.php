<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

require_once("../conexionMasterDB.php");
require_once('../compruebaUsuario.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../Librerias/RpubMail/vendor/autoload.php';
//require_once('../Librerias/PHPMailer/class.phpmailer.php');

class MailAltaUsuario{
	
	function MailAltaUsuario($usuario, $nombreUsuario, $categoria, $correo, $INTRANET){
		
		///Obtener los datos de la PO mediante su id
		$contraseña = $INTRANET->getOne("SELECT xt_password FROM PERFILES.USUARIOS WHERE xt_usuario = '$usuario' AND xt_nombre = '$nombreUsuario' AND xt_categoria = '$categoria' ");	
	
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
			$mail->Username   = 'archivos@escalante.com.mx';                     //SMTP username
			$mail->Password   = 'Esc4l4nt3123';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
	
			$mail->CharSet = "UTF-8";
			$mail->IsHTML(true);
			
			$mail->SetFrom("archivos@escalante.com.mx", "Archivos Grupo Escalante");
			$mail->AddAddress($correo, $nombreUsuario);
			$mail->AddCC('sdelap@escalante.com.mx', 'Salvador de la Peña');
			$mail->AddCC('rromo@escalante.com.mx', 'Rodrigo Romo');
			$mail->AddCC('cruiz@escalante.com.mx', 'Richard Ruiz');
			$mail->AddCC('amartinez@escalante.com.mx', 'Alberto Martinez');
			
			$mail->Subject = "Acceso Intranet";
			
			// HTML body 
			
			$body  = "Saludos, $nombreUsuario:<br><br><br>

					Tu usuario ha sido dado de alta para el acceso a Sistemas de Grupo Escalante.<br><br><br>

					Los datos para que puedas entrar son los siguientes:<br><br>
					URL: https://escalante.com.mx/Sistemas/<br>
					Usuario: $usuario<br>
					Contraseña: $contraseña<br><br>";
				
			
			$mail->Body = $body;
			
			$mail->Send();
			
		} catch(phpmailerException $e){
			
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
			
		} catch (Exception $e){
			
			echo $e->getMessage(); //Boring error messages from anything else!
			
		}
		
		return true;
	}
}
?>

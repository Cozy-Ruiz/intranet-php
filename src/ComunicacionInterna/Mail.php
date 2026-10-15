<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
	//Created by Cosijopi Richard Ruiz Avendaño
	//Ing. Sistemas Computacionales
	
	//require_once '../Librerias/PHPMailer/class.phpmailer.php';
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../Librerias/RpubMail/vendor/autoload.php';

	class MailAgregaBoletin{
		function MailAgregaBoletin($codigo,$titulo, $descripcion,$ciudad, $ruta, $archivo){
			//echo $codigo."-".$titulo."-".$descripcion."-".$ciudad."-".$ruta."-".$archivo."<br>";
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

				$address = "calidad@escalante.com.mx";
				//echo "<br>";
				$mail->SetFrom($address, "Calidad Grupo Escalante");
				if($ciudad == "NLR" || $ciudad == "LAR" ){
					$addressLR = "laredo@escalante.com.mx";
					$mail->AddAddress($addressLR, 'Nuevo Laredo');
				}else if ($ciudad == "DF" ){
					$addresMX = "aeropuerto@escalante.com.mx";
					$mail->AddAddress($addresMX	, 'Aeropuerto');
				}else if($ciudad == "CUN"){
					$addresCUN = "cancun@escalante.com.mx";
					$mail->AddAddress($addresCUN, 'Cancún');
				}else if($ciudad == "TOL"){
					$addresTOL = "toluca@escalante.com.mx";
					$mail->AddAddress($addresTOL, 'Toluca');
				}else if($ciudad == "VER"){
					$addresVER = "veracruz@escalante.com.mx";
					$mail->AddAddress($addresVER, 'Veracruz');
				}
				$mail->AddAddress('gsistemas@escalante.com.mx', 'Gerente de Sistemas');
				//$mail->AddCC('rgarcia@escalante.com.mx', 'Ricardo Garcia');
				
				$mail->Subject = $titulo;
				$body  = "<b>$codigo</br> <b>$descripcion<br>";
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
	
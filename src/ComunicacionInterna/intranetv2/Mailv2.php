<?php

	//require_once '../../Librerias/PHPMailer/class.phpmailer.php';
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../Librerias/RpubMail/vendor/autoload.php';

	class MailAgregaBoletin{
		
		function mailAgregaBoletinIntra($codigo,$titulo, $descripcion,$ciudad, $ruta, $archivo){
			//echo $codigo."-".$titulo."-".$descripcion."-".$ciudad."-".$ruta."-".$archivo."<br>";
			try{
				$mail = new phpmailer(true);
				//$mail->IsSMTP(); // telling the class to use SMTP
			
			//    $mail->Mailer    = "smtp";
			//    $mail->Host      = "mail.escalante.com.mx";
			//    //$mail->Host      = "mail2.intercommservicios.com.mx";
			//    $mail->Username = "calidad@escalante.com.mx";
			//    $mail->Password = "hapoquif";
			//    $mail->SMTPAuth  = true;
			//    $mail->CharSet   = "UTF-8";
			//    $mail->Port      = 587;
			//    $mail->SMTPDebug = 1;
			//    $mail->IsHTML(true);

				/*$mail->Mailer   = "smtp";
				$mail->Host     = "mail.escalante.com.mx";
				$mail->Username = "calidad@escalante.com.mx";
				$mail->Password = "C4l1d4d1234";
				$mail->SMTPAuth = true;
				$mail->CharSet = "UTF-8";
				$mail->SMTPDebug  = 1;
				$mail->IsHTML(true);*/
				
				/*
				$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'smtp.office365.com';//'smtp-legacy.office365.com';                     //Set the SMTP server to send through
				$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set 
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'calidad@escalante.com.mx';              //SMTP username
				$mail->Password   = 'pHB6chH8Pj';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
				$mail->CharSet = "UTF-8";
				$mail->IsHTML(true);

				$address = "calidad@escalante.com.mx";
				$mail->SetFrom($address, "Calidad Grupo Escalante");
				*/

				$mail->SMTPDebug = 0;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
				$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set 
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'calidad@escalante.com.mx';              //SMTP username
				$mail->Password   = 'nvkyxyfmrknpnbxy';                               //SMTP password
				//$mail->Username   = 'operaciones@escalante.com.mx';                     //SMTP username
				//$mail->Password   = '$xpT*bG6N^xBu&';                               //SMTP password
				//$mail->Username   = 'archivos@escalante.com.mx';              //SMTP username
				//$mail->Password   = 'Esc4l4nt3123';                               //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS
				$mail->CharSet = "UTF-8";
				$mail->IsHTML(true);
				
				$mail->SetFrom("calidad@escalante.com.mx", "Calidad Grupo Escalante");
				//$mail->SetFrom("operaciones@escalante.com.mx", "Operaciones Grupo Escalante");
				//$mail->SetFrom("archivos@escalante.com.mx", "Archivos Grupo Escalante");
				
				if(($ciudad == "NLR") || ($ciudad == "LRD")){
					$addressLR = "laredo@escalante.com.mx";
					//$addressLR = "lguadarrama@escalante.com.mx";
					
					$mail->AddAddress($addressLR, 'Nuevo Laredo');
					
				}else if ($ciudad == "DF" || $ciudad == "CMX" || $ciudad == "CDMX"){
					$addresMX = "aeropuerto@escalante.com.mx";
					//$addresMX = "lguadarrama@escalante.com.mx";
					
					$mail->AddAddress($addresMX	, 'Aeropuerto');
				}else if($ciudad == "CUN"){
					$addresCUN = "cancun@escalante.com.mx";
					//$addresCUN = "lguadarrama@escalante.com.mx";
					
					$mail->AddAddress($addresCUN, 'Cancún');
					
				}else if($ciudad == "TOL"){
					$addresTOL = "toluca@escalante.com.mx";
					//$addresTOL =  "lguadarrama@escalante.com.mx";
					
					$mail->AddAddress($addresTOL, 'Toluca');
					
				}else if($ciudad == "VER"){
					$addresVER = "veracruz@escalante.com.mx";
					//$addresVER = "lguadarrama@escalante.com.mx";
					$mail->AddAddress($addresVER, 'Veracruz');

				}else if($ciudad == "GRL"){
					$addresGRL = " distribuciongeneral@escalante.com.mx";
					//$addresGRL = "ccruz@escalante.com.mx";

					$mail->AddAddress($addresGRL, 'General');
				}else if($ciudad == "GEA"){
					$mail->AddAddress("aeropuerto@escalante.com.mx", 'Grupo Escalante');
					$mail->AddAddress("cancun@escalante.com.mx", 'Grupo Escalante');
					$mail->AddAddress("laredo@escalante.com.mx", 'Grupo Escalante');
				}
				
				$mail->Subject = $titulo;
				$body  = "<b>$codigo</br> <b>$descripcion<br>";
				$mail->Body = $body;
				if($archivo != ''){
					$mail->AddAttachment($ruta."/".$archivo, $archivo);
				}
				$mail->Send();
				
			} catch (phpmailerException $e) {
				echo $e->errorMessage(); //Pretty error messages from PHPMailer
				return false;
			} catch (Exception $e) {
				echo $e->getMessage(); //Boring error messages from anything else!
				return false;
			}
			
			return true;
		}
	}
	
	//$mail = new MailAgregaBoletin;
	//$mail->mailAgregaBoletinIntra('Prueba2', 'Prueba2', 'Hacer caso omiso', 'GRL', '', ''); 
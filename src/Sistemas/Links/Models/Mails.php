<?php
//require_once("../Librerias/PHPMailer/class.phpmailer.php"); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../Librerias/RpubMail/vendor/autoload.php';

class EnvioMails{

	function Envio($asunto, $listaDistribucion,$nombreLista, $mensaje, $archivosAdjuntos, $factura,$tipo){
		try{

			$mail = new phpmailer(true);

			/*$mail->Mailer = "smtp";
			$mail->Host = "smtp.office365.com";
			$mail->Username = "operaciones@escalante.com.mx";
			$mail->Password = '$xpT*bG6N^xBu&';
			$mail->SMTPAuth = true;
			$mail->CharSet = "UTF-8";
			$mail->Port = 587;
			$mail->SMTPDebug  = 1;
			$mail->IsHTML(true);*/

				$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    			$mail->isSMTP();                                            //Send using SMTP
    			$mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
    			$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set 
    			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    			$mail->Username   = 'operaciones@escalante.com.mx';                     //SMTP username
    			$mail->Password   = '$xpT*bG6N^xBu&';                               //SMTP password
    			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS

				$mail->CharSet = "UTF-8";
				$mail->IsHTML(true);

			$mail->SetFrom("operaciones@escalante.com.mx", "Operaciones Grupo Escalante");
			$mail->AddAddress($listaDistribucion, $nombreLista);
			$mail->Subject = $asunto;
			if($tipo == 'Para crear archivo XML'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio informamos que la factura $factura esta lista para generar el archivo XML del CFDI-CCE.";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Muchas gracias, envio un cordial saludo.";
			}else if($tipo == 'Para aprobación de GEA'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio comunicamos que el CFDI-CCE de la factura $factura está listo para aprobación de GEA.";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Muchas gracias, envio un cordial saludo.";
			}else if($tipo == 'Para aprobación del cliente'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio comunicamos que el CFDI-CCE de la factura $factura está listo para aprobación del Cliente.";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Muchas gracias, envio un cordial saludo.";
			}else if($tipo == 'XML validado'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio comunicamos que el CFDI-CCE correspondiente a la factura $mensaje, con el folio $factura, ya está lista para que el Gerente de Exportación actualice la información en los sistemas.";
				$mail->Body .= "<br><br><br>";
				$mail->Body .= "Muchas gracias.";	
			}else if($tipo == 'XML con errores 1'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio comunicamos que el CFDI-CCE de la factura $factura contiene errores y no fue aprobado por GEA.";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Muchas gracias, envio un cordial saludo.";
			}else if($tipo == 'XML con errores 2'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio comunicamos que el CFDI-CCE de la factura $factura contiene errores y no fue autorizado por el cliente.";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Muchas gracias, envio un cordial saludo.";
			}else if($tipo == 'XML con errores 3'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio comunicamos que el CFDI-CCE de la factura $factura no se valido con exito por el proveedor de servicios.";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Muchas gracias, envio un cordial saludo.";
			}else if($tipo == 'Sistemas actualizados'){
				$mail->Body .= "Buenos días:";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Por este medio informamos que la factura $mensaje ha quedado actualizada en el sistema con el folio $factura.";
				$mail->Body .= "<br><br>";
				$mail->Body .= "Muchas gracias.";
			}
						
			if($archivosAdjuntos != ""){
				$mail->AddAttachment("../tmp/CFDI/".$mensaje."_CFDI.xml", $factura."_CFDI.xml");	
				$mail->AddAttachment("../tmp/CFDI/".$mensaje."_CFDI.pdf", $factura."_CFDI.pdf");
			}
			
			$mail->Send();
		}catch(phpmailerException $e){
			echo $e->errorMessage();
		}catch(Exception $e){
			echo $e->getMessage();
		}

		return true;
	}
}
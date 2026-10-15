<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");
//require_once '../../Librerias/PHPMailer/class.phpmailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../Librerias/RpubMail/vendor/autoload.php';

$codigoSolicitudID = $_GET['codigo'];
$descripcion = $_GET['descripcion'];
$usuarioValidacion = $_GET['usuarioV'];

//obtengo los datos del solicitante
//primero obtengo el usuario de solicitante a partir de la solicitud
$usuarioSolicitante = $INTRANET->getOne("SELECT kf_usuarioId FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoSolicitudID'");
$j = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioSolicitante'");

while($listDatos = $j->fetchRow()){
	
	$nombreSolicitante = $listDatos[0];
	$correoSolicitante = $listDatos[1];
}
?>

<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset='utf-8'>
</head>
<body>
 <?php

 	class MailValidacionEnviar{

 		function MailValidacionEnviar($codigoSolicitud, $descripcion, $nombreUsuario, $correoUsuario, $usuarioValidacion){

 			try{
 				
 				$mail = new phpmailer(true);
 				/*$mail->Mailer = "smtp";
 				$mail->Host = "mailescaante.com.mx";
 				$mail->Username = "calidad@escalante.com.mx";
 				$mail->Password = "C4l1d4d1234";
 				$mail->SMTPAuth = true;

 				$mail->CharSet = "UTF-8";
 				$mail->SMTPDebug = 1;
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
		 
 				$mail->setFrom("calidad@escalante.com.mx","Calidad Grupo Escalante");
 				$mail->AddAddress($correoUsuario, $nombreUsuario);

 				$titulo = 'Atención de solicitud';
 				$body = "Saludos $nombreUsuario, <br><br>";
 				$body .= "Tu  solicitud <strong> $codigoSolicitud</strong> no fue autorizda por: <strong>$usuarioValidacion</strong>";
 				$body .= "<br><br>";
 				$body .= "Descripción:<br>";
 				$body .= "$descripcion";
 				$body .= "<br><br>";

 				$mail->Subject = "Rechazo solicitud";
 				$mail->Body = $body;

 				$mail->Send();

 			}catch (phpmailerException $e){
 				echo $e->errorMessage();
 			}catch (Exception $e){
 				echo $e->getMessage();
 			}

 			return true;
 		}
 	}

 	$clase = new MailValidacionEnviar($codigoSolicitudID, $descripcion, $nombreSolicitante, $correoSolicitante, $usuarioValidacion);
	
	
 ?>	
</body>
</html>
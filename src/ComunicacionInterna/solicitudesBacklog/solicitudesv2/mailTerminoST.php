<?php error_reporting(0); ?>
<?php
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
//require_once '../../../Librerias/PHPMailer/class.phpmailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../../Librerias/RpubMail/vendor/autoload.php';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<?php
 $codigoSolicitudID = $_GET['codigo'];

//obtengo el correo de usuario solicitante
 $nombreS = $INTRANETV2->getOne("Select kf_usuarioId from SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoSolicitudID'");
 $correoS = $INTRANETV2->getOne("Select xt_correo from PERFILES.USUARIOS where xt_usuario = '$nombreS'");

//funcion para enviar correo de aviso de solicitud
class MailSolicitudTerminar{
	
	function MailSolicitudTerminar($codigoSolicitud, $correo){
		
	//defino parametros para el mail
	
	try{
		//PDR
		$mail = new phpmailer(true);
		//$mail->IsSMTP(); // telling the class to use SMTP
		/*$mail->Mailer   = "smtp";
		$mail->Host     = "mail.escalante.com.mx";
		$mail->Username = "calidad@escalante.com.mx";
		$mail->Password = "C4l1d4d1234";
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
		$mail->Username   = 'calidad@escalante.com.mx';                     //SMTP username
		$mail->Password   = 'nvkyxyfmrknpnbxy';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`   PHPMailer::ENCRYPTION_SMTPS

		$mail->CharSet = "UTF-8";
		$mail->IsHTML(true);
							
		$mail->SetFrom("calidad@escalante.com.mx", "Calidad Grupo Escalante");
		//$mail->AddAddress('lguadarrama@escalante.com.mx', 'Solicitud Soporte Tecnico');
		echo $mail->AddAddress($correo, 'Solicitud Atendida');
		
		
		$titulo = "Solicitud Atendida";
		$body 	= "Buen día,<br><br>
				   La solicitud con número de codigo: <b>$codigoSolicitud</b> ha sido atendida.<br>
				   Saludos.";
				   
				  		
		$mail->Subject 	= $titulo;
		$mail->Body 	= $body;
		
		$mail->Send();
			
			
	} catch (phpmailerException $e) {
		echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		echo $e->getMessage(); //Boring error messages from anything else!
	}
			
	return true;
		
	}//fin de la funcion
		
		
}//fin de la clase


//llamo a la funcion para mandar correo de aviso

$clase = new MailSolicitudTerminar($codigoSolicitudID, $correoS);

//mando a la ficha de la solicitud

	echo '<script>window.opener.top.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSoporteTecnico.php?codigo='.$codigoSolicitudID.'";</script>';
	echo "<script>this.close();</script>"; 

?>
</body>
</html>
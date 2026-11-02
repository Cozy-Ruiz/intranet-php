<?php error_reporting(0); ?>
<?php
	/*
	 *@author Octavio García Robles
	 *@version 1.0
	 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
	 */
	
	require_once '../Librerias/PHPMailer/class.phpmailer.php';
	
	class MailAltaUsuario{
		
		function mailAltaUsuarioIntra($usuario, $nombreUsuario, $categoria, $correo, $INTRANET){
			
			///Obtener los datos de la PO mediante su id
			$contraseña = $INTRANET->getOne("SELECT xt_password FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuario' AND xt_nombre = '$nombreUsuario' AND kf_categoria = '$categoria' ");	
		
			try{
				
				$mail = new phpmailer(true);
				//$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Mailer   = "smtp";
				$mail->Host     = "mail.escalante.com.mx";
				$mail->Username = "calidad@escalante.com.mx";
				$mail->Password = "nvkyxyfmrknpnbxy";
				$mail->SMTPAuth = true;
				
				$mail->CharSet = "UTF-8";
				$mail->SMTPDebug  = 1;
				$mail->Port      = 587;
				$mail->IsHTML(true);
				
				$mail->SetFrom("calidad@escalante.com.mx", "Grupo Escalante");
				$mail->AddAddress($correo, $nombreUsuario);
				//$mail->AddCC('sdelap@escalante.com.mx', 'Salvador de la Peña');
				//$mail->AddCC('rromo@escalante.com.mx', 'Rodrigo Romo');
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

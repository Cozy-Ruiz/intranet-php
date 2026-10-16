<?php error_reporting(0); ?>
<?php
//$nombrephp="modificaPassword.php";
require_once("../conexionMasterDB.php");
require_once('../compruebaUsuario.php');

$breadcrumb = "<a href='../home.php' id='breadcrumbs'>Home / </a><a href='configuraciones.php' id='breadcrumbs'>Configuraciones</a>";

$passA1 = $_POST['actual'];
$error 	= $_GET['wrong'];


function validar_clave($clave){

	$error_clave = "";

	if (strlen($clave) < 8) {

		$error_clave = "La contraseña debe tener al menos 8 caracteres";
		return $error_clave;
	}

	if (strlen($clave) > 16) {

		$error_clave = "La contraseña no puede tener más de 16 caracteres";
		return $error_clave;
	}

	if (!preg_match('`[a-z]`', $clave)) {

		$error_clave = "La contraseña debe tener al menos una letra minúscula";
		return $error_clave;
	}

	if (!preg_match('`[A-Z]`', $clave)) {

		$error_clave = "La contraseña debe tener al menos una letra mayúscula";
		return $error_clave;
	}

	if (!preg_match('`[0-9]`', $clave)) {

		$error_clave = "La contraseña debe tener al menos un caracter numérico";
		return $error_clave;
	}

	/*
	if (!preg_match('`[^a-zA-Z0-9]`', $clave)) {

		$error_clave = "La contraseña debe tener al menos un caracter especial";
		return $error_clave;
	}
	*/

	$claveNoValida1 = "escalante";
	$claveNoValida2 = "Escalante123";
	$claveNoValida3 = "Dko27A&E";

	$clavemin = strtolower($clave);

	$primerComp = strrpos($clavemin, $claveNoValida1);
	$segundaComp = strrpos($clavemin, strtolower($claveNoValida2));
	$terceraComp = strrpos($clave, $claveNoValida3);

	if (($primerComp !== FALSE) || ($segundaComp !== FALSE)) {

		$error_clave = "La contraseña no debe incluir la palabra 'escalante' ";
		return $error_clave;
	}

	if ($terceraComp !== FALSE) {

		$error_clave = "La contraseña no debe usar la contraseña de ejemplo.";
		return $error_clave;
	}

	return $error_clave;
}

if (@$sesionEstilo == 1) {
	$estilo = "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
} else if (@$sesionEstilo == 2) {
	$estilo = "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
}

$modificaPassword= "
	<!DOCTYPE html PUBLIC>
	<html xmlns='http://www.w3.org/1999/xhtml'>

		<head>
			<meta charset='utf-8'>
			<link rel='shortcut icon' type='image/x-icon' href='../Imagenes/ICN_PestanaWebGE.png'>
			<title>Modificar Contraseña</title>
			".$estilo."
		</head>

		<body>

			<div id='wrapper' align='center'>
			<table border='0' align='center' width='1160px' style='margin-top:-110px;'>
			<tr height='40px'><td></td></tr>
			<tr>
			<td id='breadcrumbs' width='1160px' align='left'>Usuario: " . $sesionUsuario . "</td>
			</tr>
			<tr height='20px'><td></td></tr>
			</table>

			<table border='0' align='center' name='Encabezado'>
			<tr>
			<td align='center' id='titulo1'>
			Modifica Contraseña
			</td>
			</tr>


			</table>


			<table border='0' align='center'>
			<tr height='70'><td></td></tr>
			</table>

			<form action='modificaPassword.php' method='post'>
			<table border='0' align='center'>
			<tr> 
			<td align='center' width='480px' id='fichaRef'>   <input type='hidden' name='username' autocomplete='username' value=''>
			Cada 90 días recibirás un recordatorio para cambiar tu contraseña
			</td>
			</tr>

			<tr height='20px'><td></td></tr>

			<tr>
			<td align='center' id='fichaRef'>
			<b>Contraseña actual:</b>
			</td>
			</tr>

			<tr>
			<td align='center'>
			<input type='password' name='actual' placeholder='Contraseña' autocomplete='off'>
			</td>
			</tr>

			<tr height='20px'><td></td></tr>

			<tr>
			<td id='iconosTexto3'>
			La contraseña deberá tener:<br>
			<p>
			 	-Entre 8 y 16 caracteres.<br>
			 	-Al menos una letra mayúscula.<br>
			 	-Al menos una letra minúscula.<br>
			 	-Al menos un número.<br>
			</p>
			Por ejemplo: Dko27A&E<br><br>
			Nota:<br> 
			<p>
				-<i>No usar la contraseña de ejemplo o alguna variación.</i><br>
				-<i>No usar la palabra " . '"Escalante"' . " o alguna variación.</i><br>
				-<i>Las contraseñas no deben compartirse entre usuarios o cuentas.</i><br>
				-<i>La nueva contraseña no puede ser igual a una de las últimas 10 contraseñas utilizadas.</i>
			</p>
			</td>
			</tr>

			<tr height='20px'><td></td></tr>

			<tr>
			<td align='center' id='fichaRef'>
			<b>Nueva Contraseña:</b>
			</td>
			</tr>

			<tr>
			<td align='center'>
			<input type='password' name='passM1'  autocomplete='new-password' placeholder='Nueva contraseña'>
			</td>
			</tr>

			<tr height='20px'><td></td></tr>

			<tr>
			<td align='center' id='fichaRef'>
			<b>Repetir Contraseña:</b>
			</td>
			</tr>

			<tr>
			<td align='center'>
			<input type='password' name='passM2' autocomplete='new-password' placeholder='Repetir contraseña'>
			</td>
			</tr>

			<tr height='80px'>
			<td align='center'>
			<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
			</td>
			</tr>
			</table>
			</form>
			</div>
		</body>

	</html>	
";

if (($passA1 == "") && ($error == "")) {

	echo $modificaPassword;

} else if (($passA1 != "") && ($error == "")) {

	$passwordBase = $MASTER_GE->getOne("SELECT xt_password FROM PERFILES.USUARIOS WHERE xt_usuario = '$sesionUsuario' ");

	if ($passA1 == $passwordBase) {
		
		$passModificado1 = $_POST['passM1'];
		$passModificado2 = $_POST['passM2'];

		if ($passModificado1 == $passModificado2) {
			
			$mensajeError = validar_clave($passModificado1);

			$historialPasswordsUsuario = $MASTER_GE->getArray("SELECT xt_password, xd_fecha FROM perfiles.historial_passwords WHERE xt_usuario = '".$sesionUsuario."' ORDER BY xd_fecha DESC LIMIT 10 ");
			foreach ($historialPasswordsUsuario as $registro) {
				if ($passModificado1 === $registro['xt_password']) {
					$mensajeError = "La nueva contraseña no puede ser igual a una de las últimas 10 contraseñas utilizadas.";
				}
			}

			if ($mensajeError == "") {

				$horaActual = date('Y-m-d H:i:s', time());
				@$ip = getenv(REMOTE_ADDR);

				if ($MASTER_GE->Execute("UPDATE PERFILES.USUARIOS SET xt_password = '$passModificado2', xd_fechaActualizacionPerfil = '$horaActual', 
									xt_ipActualizacionPerfil = '$ip', xd_fechaCambioPassword = '$horaActual' WHERE xt_usuario = '$sesionUsuario' ")) {

					$MASTER_GE->Execute("INSERT INTO PERFILES.historial_passwords (xt_usuario, xt_password, xd_fecha) VALUES ('$sesionUsuario', '$passA1', '$horaActual') ");

					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
							<meta charset="utf-8">
							<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
							<title>Modificar Contraseña</title>
							<?php
							echo $estilo;
							?>
						</head>

						<body>
							<div id='wrapperPopUp'>
								<table align='center' border='0'>
									<tr height='50px'> </tr>

									<tr>
										<td align='center'><b id='tituloBigAzul'>Contraseña modificada éxitosamente.</b></td>
									</tr>

									<tr height='100px'> </tr>

									<tr>
										<td align='center' id='titulo12'>
											<a href='https://escalante.com.mx/Sistemas/seleccionaSistema.php'>
												<input type='image' src='../Imagenes/ICN_BotonOk.png' width='80' height='29'>
											</a>
										</td>
									</tr>

								</table>
							</div>
						</body>
					</html>
					<?php
				
				} else {

					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">

						<head>
							<meta charset="utf-8">
							<title>Modificar Contraseña</title>
							<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
							<?php
							echo $estilo;
							?>
						</head>

						<body>
							<div id='wrapperPopUp'>
								<table align='center' border='0'>
									<tr height='50px'> </tr>

									<tr>
										<td align='center'><b id='tituloBigAzul'>Error de actualizacion.</b></td>
									</tr>

									<tr height='100px'> </tr>

									<tr>
										<td align='center' id='titulo12'>
											<a href='../home.php'>
												<input type='image' src='../Imagenes/ICN_BotonOk.png' width='80' height='29'>
											</a>
										</td>
									</tr>

								</table>
							</div>
						</body>
					</html>
					<?php

				}
				
			} else {
				echo '<script>alert("'.$mensajeError.'");</script>';
				echo $modificaPassword;
			}
		
		} else {
			echo '<script>alert("Contraseñas nuevas no coinciden");</script>';
			echo $modificaPassword;
		}
		
	} else{
		echo '<script>alert("Contraseña actual erronea");</script>';
		echo $modificaPassword;	
	}
}
		
?>
				 

<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Modifica llave usuario</title>

</head>
<body>
<?php


if( isset($_POST['inputNumeroLlave'], $_POST['inputMotivoModificacion']) ){
	
	$INTRANETV2->Execute("UPDATE sgi_control_llaves SET xt_numeroLlave = '".$_POST['inputNumeroLlave']."', xt_usuario = '".$_POST['selectAsignadaA']."', xt_lugarUso = '".$_POST['inputLugarUso']."', xt_observaciones = '".$_POST['inputObservaciones']."' WHERE xt_numeroLlave = '".$_REQUEST['numeroLlave']."' AND xt_usuario = '".$_REQUEST['usuario']."' AND xt_oficina = '".$_REQUEST['oficina']."'   ");
	$INTRANETV2->Execute("INSERT INTO sgi_control_cambios_llaves (xt_descripcion, xt_usuario, xt_oficina, xt_numerollave) VALUES ('".$_POST['inputMotivoModificacion']."', '".$usuarioId."', '".$_REQUEST['oficina']."', '".$_POST['inputNumeroLlave']."')  ");
  	?>
	<script type="text/javascript">
		window.opener.top.location.reload(true);
		window.close();
	</script>
	<?php
	
}else if(isset($_REQUEST['numeroLlave'], $_REQUEST['usuario'], $_REQUEST['oficina'])){

	$usuarios = $INTRANETV2->getArray("SELECT distinct kp_usuario, xt_nombre FROM intranetgea_usuarios WHERE xt_ciudad in ('DF', 'CMX') ORDER BY xt_nombre ");
	$llave = $INTRANETV2->getRow("SELECT *, (SELECT xt_nombre FROM intranetgea_usuarios WHERE kp_usuario = xt_usuario) as xt_nombreUsuario FROM sgi_control_llaves WHERE xt_numeroLlave = '".$_REQUEST['numeroLlave']."' AND xt_usuario = '".$_REQUEST['usuario']."' AND xt_oficina = '".$_REQUEST['oficina']."' ");
	//var_dump($llave);
	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoRol' method='post' action='modificaLlaveUsuario.php?numeroLlave=".$_REQUEST['numeroLlave']."&usuario=".$_REQUEST['usuario']."&oficina=".$_REQUEST['oficina']."'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Modifica llave usuario</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Número de llave<br>
						  <input type='text' name='inputNumeroLlave' value='".$llave['xt_numeroLlave']."'>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Lugar Uso <br>
							<input type='text' name='inputLugarUso'  value='".$llave['xt_lugarUso']."'>";
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Asignada a<br>";
						echo "<select name='selectAsignadaA'>";
							echo "<option value='".$llave['xt_usuario']."'>".$llave['xt_nombreUsuario']."</option>";
						foreach($usuarios as $usuario){
							echo "<option value='".$usuario['kp_usuario']."'>".$usuario['xt_nombre']."</option>";
						}

						echo "</select>";	

					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Observaciones<br>
							<input type='text' name='inputObservaciones' value='".$llave['xt_observaciones']."'>";
					echo "</td>";
				echo "</tr>";

				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Motivo de modificación<br>
							<input type='text' name='inputMotivoModificacion'>";
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";
				
			
				echo"<tr height='15'></tr>";
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";
						
}

?>


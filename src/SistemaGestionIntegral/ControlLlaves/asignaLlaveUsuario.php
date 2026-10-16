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
<title>Asigna llave usuario</title>

</head>
<body>
<?php


$oficina = $INTRANET->getOne("SELECT xt_ciudad FROM perfiles.usuarios WHERE xt_usuario = '".$_SESSION['sesionUsuario']."' ");

$usuarios = $INTRANETV2->getArray("
	SELECT
		u.xt_usuario,
		u.xt_nombre
	FROM
		intranetgea.SGI_Empleados e,
		perfiles.usuarios u,
		perfiles.sistemas s
	WHERE
		e.xt_tipo = 'E' 
		AND e.xt_Estatus = 1 
		AND u.xt_ciudad IN ('".$oficina."') 
		AND u.xt_usuario = e.kf_usuario
		AND s.xt_usuario = u.xt_usuario
		AND s.xt_sistema = 'INTRANET'
		AND s.xt_estatus = 'ACTIVO'
	ORDER BY
		e.xt_Nombre,
		e.xt_ApellidoPaterno,
		e.xt_apellidoMaterno
 ");

if($_POST['inputNumeroLlave'] == ''){	

	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoRol' method='post' action='asignaLlaveUsuario.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Asigna llave usuario</font>";
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
						  <input type='text' name='inputNumeroLlave'>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Lugar Uso <br>
							<input type='text' name='inputLugarUso'>";
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Asignada a<br>";
						echo "<select name='selectAsignadaA'>";
						 	echo "<option value=''>selecciona usuario</option>";
						foreach($usuarios as $usuario){
							echo "<option value='".$usuario['xt_usuario']."'>".$usuario['xt_nombre']."</option>";
						}

						echo "</select>";	

					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Observaciones<br>
							<input type='text' name='inputObservaciones'>";
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

}else if($_POST['inputNumeroLlave'] != ''){

	if($oficina == "CMX', 'DF"){
		$oficina = 'CMX';
	}

	//echo "INSERT INTO sgi_control_llaves (xt_numeroLlave, xt_usuario, xt_oficina, xt_lugarUso, xt_observaciones) VALUES ('".$_POST['inputNumeroLlave']."', '".$_POST['selectAsignadaA']."', '".$oficina."', '".$_POST['inputLugarUso']."', '".$_POST['inputObservaciones']."') ";
	$INTRANETV2->Execute("INSERT INTO sgi_control_llaves (xt_numeroLlave, xt_usuario, xt_oficina, xt_lugarUso, xt_observaciones) VALUES ('".$_POST['inputNumeroLlave']."', '".$_POST['selectAsignadaA']."', '".$oficina."', '".$_POST['inputLugarUso']."', '".$_POST['inputObservaciones']."') ");
	
  	?>
	<script type="text/javascript">
		window.opener.top.location.reload(true);
		window.close();
	</script>
	<?php
	
}
?>


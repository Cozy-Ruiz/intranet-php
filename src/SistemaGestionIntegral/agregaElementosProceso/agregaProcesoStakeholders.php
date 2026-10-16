<?php error_reporting(0); ?>
<?php

$nombrephp='agregaProcesoStakeholder.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

$proceso = $_GET['proceso'];

if($_POST['contenido'] != ""){
	

	$codigoProceso  = $_POST['proceso'];	
	$elementos = explode("\r\n", $_POST['contenido']);
				
	for($i = 0; $i < count($elementos); $i++){
		$dato = $elementos[$i];
		
		$INTRANET->Execute("INSERT INTO SGI_K_Stakeholders (xt_CodigoProceso, xt_Stakeholder, xd_usuario) VALUES ('$codigoProceso','$dato','$usuarioId')");
	
	}
		
	echo "<script>window.opener.location.reload('http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaProceso.php?proceso=$codigoProceso');self.close();</script>";

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<title>Agregar Elemento Proceso</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<script>
function show(){
	var option = document.getElementById("seleccion").value;
	if(option == "Archivo"){
		document.getElementById("archivos").style.display="block";
		document.getElementById("contenido").style.display="none";
	} else{
		document.getElementById("archivos").style.display="none";
		document.getElementById("contenido").style.display="block";
	}
}
</script>
</head>
<body>
<?php

echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='agregaProcesoStakeholders.php'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar Stakeholders</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='450'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Descripción:</td>";
		echo "</tr>";
		
		echo "<tr align='left' height='15'>";
			echo "<td id='notaDiscreta' align='left'>*Puede ingresar varios separados por renglón</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<textarea name='contenido' style='width: 450px; height: 100px;'></textarea>";
				echo"<input type='hidden' value='$proceso' name='proceso'/>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";



?>
</body>
</html>
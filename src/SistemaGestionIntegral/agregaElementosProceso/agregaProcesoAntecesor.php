<?php error_reporting(0); ?>
<?php

$nombrephp='agregaProcesoAntecesor.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");


$proceso = $_GET['proceso'];

if($_POST['procesoAntecesor'] != ""){
	
	$procesoAntecesor = $_POST['procesoAntecesor'];
	$codigoProceso    = $_POST['proceso'];
	
	$INTRANET->Execute("INSERT INTO SGI_K_Procesos_Antecesores (xt_CodigoProceso, xt_CodigoProcesoAntecesor, xd_usuario) VALUES ('$codigoProceso','$procesoAntecesor','$usuarioId')");
	
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


///NUMERO DEL MAPA = 0, FORMULARIO PARA AGREGAR DESCRIPCION
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='agregaProcesoAntecesor.php'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Proceso antecesor</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='450'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Contenido:</td>";
		echo "</tr>";
	
		 echo "<tr align='left' height='20' >";
           
			echo "<td id='iconosTexto2' align='left' width='300px'>";
				echo "<select name='procesoAntecesor'>";
					echo "<option value='' selected='selected'></option>";
						$t = $INTRANET->Execute("SELECT
													SKP.kp_CodigoCorto,
													SKP.xt_Nombre
												FROM
													SGI_K_Procesos SKP
												WHERE
													SKP.kp_CodigoCorto NOT IN (
														SELECT
															SKPA.xt_CodigoProcesoAntecesor
														FROM
															SGI_K_Procesos_Antecesores SKPA
														WHERE
															SKPA.xt_CodigoProceso = '$proceso'
													)");
						while($p = $t->fetchRow()){
							$codigoCorto     = $p[0];
							$nombreProceso   = $p[1];

							echo"<option value='".$codigoCorto."'>".$nombreProceso."</option>";                                                    
						}
				echo "</select>";
				echo"<input type='hidden' value='$proceso' name='proceso'/>";
			echo "</td>";
		echo "</tr>";
		
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
<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'AuditoriaActualizar.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

error_reporting(E_PARSE);

if($_POST['id'] != ""){
	
	$id = $_POST['id'];
	
} else if($_GET['id'] != ""){
	
	$id = $_GET['id'];
}

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroAuditorias.php' id='breadcrumbs'> Auditorías </a>";
$bandera = 0;

$codigo = $INTRANET->getOne("SELECT xt_claveAuditoria FROM SGI_Auditorias WHERE kp_auditoriaID = $id AND xt_status = 1 ");

if($codigo != ""){

	if($_POST["programa"] != NULL){
		
		$item = $_POST["programa"];
		
		$actual = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
		
		if($actual != ("" || NULL)){
			
			if($item != $actual){
				$INTRANET->Execute("UPDATE SGI_Auditorias_Archivos SET xt_descripcion = '$item' WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
			}
			
		} else{
			
			//$INTRANET->Execute("INSERT INTO SGI_Auditorias_Archivos(kf_auditoriaID, xt_tipo, xt_descripcion) VALUES ($id, 'PROGRAMA', '$item') ");
			$INTRANET->Execute("UPDATE SGI_Auditorias_Archivos SET xt_descripcion = '$item' WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
		}
	}
	
	if($_POST["informe"] != NULL){
		
		 $item = $_POST["informe"];
		
		$actual = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");
		
		if($actual != ("" || NULL)){
			
			if($item != $actual){
				$INTRANET->Execute("UPDATE SGI_Auditorias_Archivos SET xt_descripcion = '$item' WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");
			}
			
		} else{
			
			$INTRANET->Execute("INSERT INTO SGI_Auditorias_Archivos(kf_auditoriaID, xt_tipo, xt_descripcion) VALUES ($id, 'INFORME', '$item') ");
		}
	}
	
	if($_POST['existeH'] ==  'si'){
		
		$INTRANET->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'Si' WHERE kp_auditoriaID = $id");
		
	}else if($_POST['existeH'] ==  'no'){
	
		$INTRANET->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'No' WHERE kp_auditoriaID = $id");
	}
	
	$rutaP 		= $INTRANET->getOne("SELECT xt_ruta FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
	
	$programa	= $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
	
	$rutaI 		= $INTRANET->getOne("SELECT xt_ruta FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
				<title>Auditoría Proceso</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
				?> 
			</head>
			<body>
	<?php

	echo "<div id='wrapperFicha' align='center'>";
		echo "<form method='post' action='AuditoriaActualizar.php'>";	
		echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
				
			echo "<tr height='80px'><td></td></tr>";
		///Titulo 
			echo "<tr>";
				echo "<td align='center' id='titulo1' width='700px'>";
					echo $codigo;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>"; 
				echo "<td align='center'>";
					echo $breadcrumb;
				echo "</td>";
			echo "</tr>";
					
			echo "<tr height='50'><td></td></tr>";		
		echo "</table>";
			
		echo"<table border='0' align='center' width='700px'>";	
			echo"<tr height='50px'><td colspan='4'></td></tr>";
	
			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b>Plan de auditoría</b></td>";
				echo "<td>";
					
					if(($rutaP == "") || ($rutaP == NULL)){
						
						echo "<a href='AgregaElementos/AgregarArchivoAuditoriaPopUp.php?id=".$id."&tipo=PROGRAMA' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
							echo "<img src='../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
						echo "</a>";
						
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo"<tr height='10px'><td colspan='4'></td></tr>";
	
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td colspan='2' id='textIntro'>";
				
					if($rutaP != ""){
						
						echo "<i>".$rutaP."</i> <a href='downloadAuditoria.php?file=".$rutaP."'><img src='../Imagenes/ICN_Archivo.png'></a>";
					
					}
					
				echo "</td>";
			echo "</tr>";
	
			echo "<tr height='10px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				 
				echo "<td width='645px'>";
					echo "<textarea  name='programa' style='width: 645px; height:200px;'>".$programa."</textarea><input type='hidden' name='id' value='".$id."'>";
				echo "</td>";
				
				echo "<td width='15px' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='10' height='10'>";
				echo "</td>";
			echo "</tr>";
			
			
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
		echo"</table>";
		
	//Informe de la auditoria
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b>Informe de la auditoría</b></td>";
				echo "<td>";
				
					if($rutaI == ("" || NULL)){
					
						echo "<a href='AgregaElementos/AgregarArchivoAuditoriaPopUp.php?id=".$id."&tipo=INFORME' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
							echo "<img src='../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
						echo "</a>";
					
					}
				
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td colspan='2' id='textIntro'>";
				
					if($rutaI != ""){
						echo "<i>".$rutaI."</i> <a href='downloadAuditoria.php?file=".$rutaI."' ><img src='../Imagenes/ICN_Archivo.png'></a>";
					}
				
				echo "</td>";
			echo "</tr>";

			echo "<tr height='10px'><td colspan='4'></td></tr>";
			
			$informe = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				
				echo "<td width='645px'>";
					echo "<textarea name='informe' style='width: 645px; height:200px;'>".$informe."</textarea>";
					echo "<input type='hidden' name='id' value='".$id."'>";
				echo "</td>";
				
				echo "<td width='15px' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='10' height='10'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";
		
		echo"<table border='0' align='center' width='700px'>";	
			echo"<tr height='30px'><td colspan='4'></td></tr>";
	
			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b>Hallazgos</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				 
				
				
				$existeCheck = $INTRANET->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE kp_auditoriaID = '$id'");
				
				if($existeCheck != ''){
					
					echo "<tr>";
					echo "<td>";
						echo"¿Existen Hallazgos?";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>";
				if($existeCheck == 'Si'){
					echo "<input type='radio' name='existeH' value='si' checked>SI<br>";
					echo "<input type='radio' name='existeH' value='no'>NO<br>";
				}
				if($existeCheck == 'No'){
					echo "<input type='radio' name='existeH' value='si' >SI<br>";
					echo "<input type='radio' name='existeH' value='no' checked>NO<br>";
				}
				echo "<input type='hidden' name='id' value='".$id."'>";
					//echo "<textarea  name='programa' style='width: 645px; height:200px;'>".$programa."</textarea><input type='hidden' name='id' value='".$id."'>";
				echo "</td>";
				
				echo "<td width='15px' align='right' >";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='10' height='10'>";
				echo "</td>";
				
				echo "</tr>";
					
				}else{
				
				echo "<tr>";
					echo "<td>";
						echo"¿Existen Hallazgos?";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>";
				echo "<input type='radio' name='existeH' value='si'>SI<br>";
				echo "<input type='radio' name='existeH' value='no'>NO<br>";
				
				echo "<input type='hidden' name='id' value='".$id."'>";
					//echo "<textarea  name='programa' style='width: 645px; height:200px;'>".$programa."</textarea><input type='hidden' name='id' value='".$id."'>";
				echo "</td>";
				
				echo "<td width='15px' align='right' >";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='10' height='10'>";
				echo "</td>";
				
				echo "</tr>";
				
				}
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
		echo "</table>";
		
	//FINALIZAR
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td align='right'>";
					echo "<a href='FichaAuditoria.php?id=".$id."&end=1'>";
						echo "<img src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</a>";
				echo "</td>";	
			echo "</tr>";
			
			echo "<tr height='50'px><td></td></tr>";
		echo "</table>";
		echo "</form>";
	echo "</div>";
} else{
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
				<title>Auditoría Proceso</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
				?> 
			</head>
			<body>
	<?php

	echo "<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center'>";		
			echo "<tr height='150px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "Error!!!";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
}

?>
    	</body>
    </html>
<?php

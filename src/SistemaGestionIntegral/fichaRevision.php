<?php error_reporting(0); ?>
<?php

$nombrephp='fichaRevision.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Revisión</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
</head>

<body>
<?PHP
$revisionID = $_GET['revisionID'];
$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a><a href='tableroReuniones.php' id='breadcrumbs'> Reuniones /</a><a href='tableroAcuerdos.php' id='breadcrumbs'> Acuerdos</a> ";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Revisión</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='70'> </tr>";
	echo "</table>";
		
	//CUERPO FICHA
		$s = $INTRANET->Execute("SELECT ra.kf_acuerdoID, ra.xd_fecha, ra.xt_titulo,ra.xt_descripcion,ra.xt_ruta, a.xt_claveAcuerdo,a.kp_acuerdoID FROM SGI_Revisiones_Acuerdo ra, SGI_Acuerdos a
								WHERE ra.kf_acuerdoID= a.kp_acuerdoID AND kp_revisionID= $revisionID");
		while($r = $s->fetchRow()){
			$titulo = $r[2];
			$fecha = date('Y-m-d', strtotime($r[1]));
			$descripcion = nl2br ($r[3]);
			$ruta = $r[4];
			$clave = $r[5];
			$acuerdoID = $r[6];
			
		} unset($r); unset($s);
	
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2'><b><a href='fichaAcuerdo.php?acuerdo=$acuerdoID' id='titulo2' style='text-decoration:none;'> $clave </a></b></td>";
			echo "<td id='iconosTexto2' align='right'><b>$fecha</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>$titulo</b></td>";
			if ($ruta != NULL){
				echo"<td id='iconosTexto' width='50' align='right'><a href='downloadRevision.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a> </td>";
			}else {
				echo"<td id='iconosTexto' width='50' align='right'></td>";
			}
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='20'> </td>";
			echo "<td width='20'> </td>";
			echo "<td width='610' align='justify' id='fileItem'>$descripcion</td><td></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='4'></td>";
		echo "</tr>";
		
	echo "</table>";


?>
</body>
</html>
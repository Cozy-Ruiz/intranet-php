<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php

$nombrephp='fichaRevisionQuejaSolicitud.php';
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
$tipo = $_GET['tipo'];
$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a> <a href='comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna</a> ";

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
	if($tipo == 'C'){
		$s = $INTRANET->Execute("SELECT rq.xt_titulo,rq.xd_fecha,rq.xt_descripcion, rq.xt_ruta,rq.kf_quejaID, qs.xt_claveQuejaSolicitud FROM SGI_Revisiones_Quejas rq, SGI_Quejas_Solicitudes qs
								WHERE rq.kf_quejaID= qs.kp_quejaSolicitudID AND rq.kp_revisionID= $revisionID");
		while($r = $s->fetchRow()){
			$titulo = $r[0];
			$fecha = date('Y-m-d', strtotime($r[1]));
			$descripcion = nl2br ($r[2]);
			$ruta = $r[3];
			$IDqueja= $r[4];
			$clave = $r[5];
			
		} unset($r); unset($s);
	}else if ($tipo == 'B'){
		$s = $INTRANET->Execute("SELECT rq.xt_titulo,rq.xd_fecha,rq.xt_descripcion, rq.xt_ruta,rq.kf_solicitudID, qs.xt_claveQuejaSolicitud FROM SGI_Revisiones_Solicitudes rq,
		 	                     SGI_Quejas_Solicitudes qs WHERE rq.kf_solicitudID= qs.kp_quejaSolicitudID AND rq.kp_revisionID= $revisionID");
		while($r = $s->fetchRow()){
			$titulo = $r[0];
			$fecha = date('Y-m-d', strtotime($r[1]));
			$descripcion = nl2br ($r[2]);
			$ruta = $r[3];
			$IDsolicitud= $r[4];
			$clave = $r[5];
			
		} unset($r); unset($s);
	}
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			if ($tipo =='C'){
				echo"<td align='left' id='titulo2'><b><a href='fichaQueja.php?id=$IDqueja' id='titulo2' style='text-decoration:none;'> $clave </a></b></td>";
			}else if ($tipo == 'B'){
				echo"<td align='left' id='titulo2'><b><a href='fichaSolicitud.php?id=$IDsolicitud' id='titulo2' style='text-decoration:none;'> $clave </a></b></td>";
			}
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
				echo"<td id='iconosTexto' width='50' align='right'><a href='downloadRevisionSolicitudesQuejas.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a> </td>";
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
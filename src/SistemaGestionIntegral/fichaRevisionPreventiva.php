<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio García Robles
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'fichaRevisionPreventiva.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$revisionID = $_GET['revisionID'];

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='tableroPreventivasCorrectivas.php' id='breadcrumbs'> Acciones Preventivas </a>";
			   
$s = $INTRANET->Execute("SELECT rp.kf_preventivasID, rp.xd_fecha, rp.xt_titulo, rp.xt_descripcion, rp.xt_ruta, apc.xt_claveAccion 
						 FROM SGI_Revisiones_Preventivas rp, SGI_Acciones_Preventivas_Correctivas apc 
						 WHERE rp.kf_preventivasID = apc.kp_accionesID AND kp_revisionID = $revisionID ");

while($r = $s->fetchRow()){
	
	$titulo 		= $r[2];
	$fecha 			= date('Y-m-d', strtotime($r[1]));
	$descripcion 	= nl2br ($r[3]);
	$ruta 			= $r[4];
	$clave 			= $r[5];
	$preventivaID 	= $r[0];
	
} unset($r); unset($s);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
<?php

echo "<div id='wrapper'>";
	echo "<table border='0' align='center'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "Revisión<";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr>"; 
			echo"<td align='center'>";
				echo $breadcrumb;
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='70px'><td></td></tr>";
	echo "</table>";
		
	//CUERPO FICHA
	echo "<table border='0' align='center' width='700px'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2'>";
				echo "<b><a href='fichaPreventiva.php?id=".$preventivaID."' id='titulo2' style='text-decoration:none;'>".$clave."</a></b>";
			echo "</td>";
			
			echo "<td id='iconosTexto2' align='right'><b>".$fecha."</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'><td colspan='2'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>".$titulo."</b></td>";
			
			echo"<td id='iconosTexto' width='50' align='right'>";
			
				if ($ruta != NULL){
					echo"<a href='downloadRevision.php?file=".$ruta."'><img src='../Imagenes/ICN_Archivo.png'></a>";
				}
			
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10px'><td colspan='4'></td></tr>";
		
		echo "<tr>";
			echo "<td width='20px'></td>";
			echo "<td width='20px'></td>";
			echo "<td width='610px' align='justify' id='fileItem'>".$descripcion."</td>";
			echo "<td></td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td colspan='4'></td></tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='4'></td>";
		echo "</tr>";
	echo "</table>";
echo"</div>";

?>
		</body>
	</html>
<?php

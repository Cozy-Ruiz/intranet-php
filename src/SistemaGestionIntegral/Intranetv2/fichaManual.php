<?php

$nombrephp='Documento.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once('../../ConexionIntranet2.php');


$Documento = explode('-', $_GET['codManual']);
$manual = $_GET['codManual'];

$grupo = trim($Documento[0]);
$area = trim($Documento[1]);

//echo"SELECT xt_nombre FROM SGI_Manuales WHERE SUBSTRING_INDEX(xt_codigo,'-',-1) = '$area'";
$a = $INTRANETV2->Execute("SELECT xt_nombre FROM SGI_Catalogo_Manuales WHERE SUBSTRING_INDEX(xt_codigoManual,'-',-1) = '$area' ");	
		while($t = $a->fetchRow()){
			
			$nombreArea = $t[0];
		
	}/*

if($area == 'MC'){
	$nombreArea = "Manual de Gestión Integral";
} else if($area == 'CDR'){
	$nombreArea = "Manual de Control de Documentos y Registros";
} else if($area == 'AI'){
	$nombreArea = "Manual de Auditorías Internas";
} else if($area == 'CC'){
	$nombreArea = "Manual del Comité de Calidad";
} else if($area == 'DG'){
	$nombreArea = "Manual de Dirección General";
} else if($area == 'ADM'){
	$nombreArea = "Manual de Administración";
} else if($area == 'RH'){
	$nombreArea = "Manual de Recursos Humanos";
} else if($area == 'TI'){
	$nombreArea = "Manual de Tecnologías de Información";
} else if($area == 'OPE'){
	$nombreArea = "Manual de Operaciones";
} /*else if($area == 'SE'){
	$nombreArea = "Manual de Seguridad";
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            <script>
				function showBanana(valor){
					if(valor == 1){
						document.getElementById("banana1").style.display="inline-block";
						document.getElementById("banana0").style.display="none";
						document.getElementById("mapaIntranet").style.display="inline-block";
					} else if (valor == 0){
						document.getElementById("banana1").style.display="none";
						document.getElementById("banana0").style.display="inline-block";
						document.getElementById("mapaIntranet").style.display="none";
					}
				}
			</script>
            
 			<?php
				echo "<title>".$nombreArea."</title>";
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
			?>
</head>

<body>
<?php
$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home /</a><a href='../homeSGI.php' id='breadcrumbs'>Sistema de Gestión Integral /</a> 
			<a href='manualesv2.php' id='breadcrumbs'> Manuales</a>";


echo"<div id='wrapper' align='center'>";
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr height='80px'><td></td></tr>";
		
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>$nombreArea</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>$manual</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		//echo"<tr height='100'> </tr>";
	echo "</table>";
	
	
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../../navegacion_banana.php");
				echo "</table>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	
	$indice 				= 1;
	$ciudadesDisponibles 	= NULL;
	
	$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");
	
	while($r = $s->fetchRow()){
		
		$ciudadesDisponibles[$indice] = $r[0];
		
		$indice++;
		
	} unset($r); unset($s); unset($indice);
	
	$queryCiudades = "";
	
	for($o = 1; $o <= count($ciudadesDisponibles); $o++){
		
		$queryCiudades = "'".$ciudadesDisponibles[$o]."', ";
		
	} unset($o);
	
	$queryCiudades = substr($queryCiudades, 0, -2);
	
	///CAPITULOS
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'C' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	

	echo"SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
							AND I.xt_tipoDocumento = 'C'
							AND (CASE I.xt_ciudad WHEN 'DF' OR 'CMX' THEN 'DF' ELSE I.xt_ciudad END IN(
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = '')
							ORDER BY
							 I.xt_tipoDocumento,
							 I.xn_orden";
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
							AND I.xt_tipoDocumento = 'C'
							AND (CASE I.xt_ciudad WHEN 'DF' OR 'CMX' THEN 'DF' ELSE I.xt_ciudad END IN(
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = '')
							ORDER BY
							 I.xt_tipoDocumento,
							 I.xn_orden");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Capítulos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[0]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///LINEAMIENTOS
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'L' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
							AND I.xt_tipoDocumento = 'L'
							AND (CASE I.xt_ciudad WHEN 'DF' OR 'CMX' THEN 'DF' ELSE I.xt_ciudad END IN(
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = '')
							ORDER BY
							 I.xt_tipoDocumento,
							 I.xn_orden");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Lineamientos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[0]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///PROCEDIMIENTO
	$bandera = 0;
	
	/*$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'P' 
							 ORDER BY xt_tipo, xn_consecutivo");*/
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
							AND I.xt_tipoDocumento = 'P'
							AND (CASE I.xt_ciudad WHEN 'DF' OR 'CMX' THEN 'DF' ELSE I.xt_ciudad END IN(
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = '')
							ORDER BY
							 I.xt_tipoDocumento,
							 I.xn_orden");
	

	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Procedimientos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[0]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///INSTRUCTIVO
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'I' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
							AND I.xt_tipoDocumento = 'I'
							AND (CASE I.xt_ciudad WHEN 'DF' OR 'CMX' THEN 'DF' ELSE I.xt_ciudad END IN(
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = '')
							ORDER BY
							 I.xt_tipoDocumento,
							 I.xn_orden");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Instructivos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[0]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///FORMATO
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'F' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
							AND I.xt_tipoDocumento = 'F'
							AND (CASE I.xt_ciudad WHEN 'DF' OR 'CMX' THEN 'DF' ELSE I.xt_ciudad END IN(
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = '')
							ORDER BY
							 I.xt_tipoDocumento,
							 I.xn_orden");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Formatos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[0]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///Documento Externo
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'DE' 
							 ORDER BY xt_tipo, xn_consecutivo");*/
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
							AND I.xt_tipoDocumento = 'DE'
							AND (CASE I.xt_ciudad WHEN 'DF' OR 'CMX' THEN 'DF' ELSE I.xt_ciudad END IN(
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = '')
							ORDER BY
							 I.xt_tipoDocumento,
							 I.xn_orden");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Documentos Externos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[0]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumento.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	

	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	echo "<table border='0' align='center'>";
		echo"<tr height='70'><td></td></tr>";
	echo "</table>";
	
echo"</div>";

?>


</body>
</html>
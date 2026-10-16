<?php

$nombrephp='Documento.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once('../../ConexionIntranet2.php');


$manual = $_GET['codManual'];
echo $manual;
$a = $INTRANETV2->Execute("SELECT xt_nombre FROM INTRANET2.SGI_Catalogo_Manuales WHERE xt_codigoManual = '$manual' ");	
		while($t = $a->fetchRow()){
			
			$nombreArea = $t[0];
		
	}
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
			<a href='manualesv3C1.php' id='breadcrumbs'> Manuales</a>";


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
	
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre,
							 I.xt_codigoCompleto
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							 I.xt_codigoManual = '".$manual."'
							AND I.xt_tipoDocumento = 'C'

							AND (CASE I.xt_ciudad
							WHEN 'CMX' THEN
							 'DF'
							WHEN 'GRL' THEN
							 'ALL'
							WHEN 'NLD' THEN
							 'NLR'
							 WHEN 'LRD' THEN
							 'LR'
							 WHEN 'LRD' THEN
							 'LAR'
							ELSE
							 I.xt_ciudad
							END IN (
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = 'GRL')
							ORDER BY
							 I.xt_tipoDocumento");
	
					
	
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
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	//************************LINEAMIENTOS ****************

	$bandera = 0;

	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre,
							 I.xt_codigoCompleto
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							 I.xt_codigoManual = '".$manual."'
							AND I.xt_tipoDocumento = 'L'

							AND (CASE I.xt_ciudad
							WHEN 'CMX' THEN
							 'DF'
							WHEN 'GRL' THEN
							 'ALL'
							WHEN 'NLD' THEN
							 'NLR'
							WHEN 'LRD' THEN
							 'LR'
							 WHEN 'LRD' THEN
							 'LAR'
							ELSE
							 I.xt_ciudad
							END IN (
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = 'GRL')
							ORDER BY
							 I.xt_tipoDocumento");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Lineamientos </td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top' >";
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[2]. "</a>";		 	
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";

			echo "<td><input type='checkbox' if (checked == true) onclick= false /></td>";


		echo "</tr>";		
		echo"<tr height='10'><td colspan='3'></td></tr>";


			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	



	//****************PROCESOS***********************
	$bandera = 0;
	
	
	$s = $INTRANET->Execute("SELECT
	P.xt_codigoCorto,
	P.xt_nombre,
	P.xt_codigoProceso
FROM
	INTRANET2.SGI_Procesos P
WHERE
	P.xt_codigoManual = '".$manual."'
AND (
	CASE P.xt_ciudad
	WHEN 'CMX' THEN
		'DF'
	WHEN 'GRL' THEN
		'ALL'
	WHEN 'NLD' THEN
		'NLR'
	WHEN 'LRD' THEN
	 'LR'
	 WHEN 'LRD' THEN
	 'LAR'
	ELSE
		P.xt_ciudad
	END IN (
		SELECT
			O.xt_codigoCiudad
		FROM
			IntranetGEA.IntranetGEA_Usuarios_Oficina O
		WHERE
			O.kf_usuarioId = '".$usuarioId."'
	)
	OR P.xt_ciudad IS NULL
	OR P.xt_ciudad = 'GRL'
)ORDER BY P.xt_codigoCorto");
	

	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Procesos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProceso.php?proceso=K0000
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProcesov2.php?proceso=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProcesov2.php?proceso=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";

		//	echo "<td><input type='checkbox' if (checked == true) onclick= false /></td>";
			
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	
	
	//****************************PROCEDIMIENTO****************************
	$bandera = 0;
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre,
							 I.xt_codigoCompleto
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							 I.xt_codigoManual = '".$manual."'
							AND I.xt_tipoDocumento = 'P'

							AND (CASE I.xt_ciudad
							WHEN 'CMX' THEN
							 'DF'
							WHEN 'GRL' THEN
							 'ALL'
							WHEN 'NLD' THEN
							 'NLR'
							WHEN 'LRD' THEN
							 'LR'
							 WHEN 'LRD' THEN
							 'LAR'
							ELSE
							 I.xt_ciudad
							END IN (
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = 'GRL')
							ORDER BY
							 I.xt_tipoDocumento");
	

	
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
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";

			echo "<td><input type='checkbox' /></td>";
			
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	
	
	
	//***************************INSTRUCTIVO
	$bandera = 0;

	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre,
							 I.xt_codigoCompleto
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							 I.xt_codigoManual = '".$manual."'
							AND I.xt_tipoDocumento = 'I'

							AND (CASE I.xt_ciudad
							WHEN 'CMX' THEN
							 'DF'
							WHEN 'GRL' THEN
							 'ALL'
							WHEN 'NLD' THEN
							 'NLR'
							WHEN 'LRD' THEN
							 'LR'
							 WHEN 'LRD' THEN
							 'LAR'
							ELSE
							 I.xt_ciudad
							END IN (
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = 'GRL')
							ORDER BY
							 I.xt_tipoDocumento");
	
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
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";

			echo "<td><input type='checkbox'  /></td>";
			
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	//********************************FORMATO*******************************
	$bandera = 0;
	
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre,
							 I.xt_codigoCompleto
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							 I.xt_codigoManual = '".$manual."'
							AND I.xt_tipoDocumento = 'F'

							AND (CASE I.xt_ciudad
							WHEN 'CMX' THEN
							 'DF'
							WHEN 'GRL' THEN
							 'ALL'
							WHEN 'NLD' THEN
							 'NLR'
							WHEN 'LRD' THEN
							 'LR'
							 WHEN 'LRD' THEN
							 'LAR'
							ELSE
							 I.xt_ciudad
							END IN (
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = 'GRL')
							ORDER BY
							 I.xt_tipoDocumento");
	
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
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";

			//echo "<td><input type='checkbox'  /></td>";
			
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	//*******************************Documento Externo
	$bandera = 0;
	
	$s = $INTRANET->Execute("SELECT
							 I.xt_codigoDocumento,
							 I.xt_nombre,
							 I.xt_codigoCompleto
							FROM
							 INTRANET2.SGI_Manuales_Documentos I
							WHERE
							 I.xt_codigoManual = '".$manual."'
							AND I.xt_tipoDocumento = 'X'

							AND (CASE I.xt_ciudad
							WHEN 'CMX' THEN
							 'DF'
							WHEN 'GRL' THEN
							 'ALL'
							WHEN 'NLD' THEN
							 'NLR'
							WHEN 'LRD' THEN
							 'LR'
							 WHEN 'LRD' THEN
							 'LAR'
							ELSE
							 I.xt_ciudad
							END IN (
							 SELECT
							  O.xt_codigoCiudad
							 FROM
							  IntranetGEA.IntranetGEA_Usuarios_Oficina O
							 WHERE
							  O.kf_usuarioId = '".$usuarioId."'
							)
							OR I.xt_ciudad IS NULL
							OR I.xt_ciudad = 'GRL')
							ORDER BY
							 I.xt_tipoDocumento");
	
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
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='fichaDocumentov3C1.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";

			//echo "<td><input type='checkbox' checked='false ' /></td>";
			
			
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
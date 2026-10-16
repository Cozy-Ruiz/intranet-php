<?php error_reporting(0); ?>
<?php

$nombrephp = 'tableroProcesos.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require_once("../ConexionIntranet2.php");

error_reporting(E_PARSE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
			<title>Tablero de Inventario de Procesos</title>
			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            
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

        </head>
        <body>
<?php

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='Procesos.php' id='breadcrumbs'> Inventario de procesos </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Inventario de Procesos</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		//echo"<tr height='70'> </tr>";
	echo "</table>";
				
				//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
			include("../navegacion_banana.php");
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	///MANUAL DE CALIDAD
	$consecutivos 	= NULL;
	$indice 		= 0;
	
	/*//echo"SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'MC' AND xt_tipo = 'K' ORDER BY xn_consecutivo";
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'MC' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
									RIGHT (xt_codigoCorto, 2),
									xt_nombre,
									xt_codigoProceso,
									xt_codigoCorto
								FROM
									SGI_Procesos
								WHERE
									
								 xt_codigoProceso LIKE '%MC%'
								ORDER BY
									RIGHT (xt_codigoCorto, 2)");
	
	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual de Calidad</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	} unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///Manual de Control de Documentos y Registros
	$consecutivos 	= NULL;
	$indice 		= 0;
	
			/*
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'CDR' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
							 xt_codigoProceso LIKE '%CD%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");
	
	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual de Control de Documentos y Registros</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///Manual de Auditorías Internas
	$consecutivos 	= NULL;
	$indice 		= 0;
	
			/*
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'AI' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
							 xt_codigoProceso LIKE '%AA%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");
	
	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual de Auditorías Internas</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///Manual del Comité de Calidad
	$consecutivos 	= NULL;
	$indice 		= 0;
	
	/*
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'CC' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
							 xt_codigoProceso LIKE '%CC%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");
	
	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual del Comité de Calidad</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///Manual de Dirección General
	$consecutivos 	= NULL;
	$indice 		= 0;
	
			/*
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'DG' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
							 xt_codigoProceso LIKE '%DG%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");
	
	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual de Dirección General</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///Manual de Administración
	$consecutivos 	= NULL;
	$indice 		= 0;
	
			/*
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'ADM' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
							 xt_codigoProceso LIKE '%AD%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");
	
	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual de Administración</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///	Manual de Recursos Humanos
	$consecutivos 	= NULL;
	$indice 		= 0;
	
	/*$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'RH' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
							 xt_codigoProceso LIKE '%RH%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");

	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>	Manual de Recursos Humanos</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///	Manual de Tecnologias de la Información
	$consecutivos 	= NULL;
	$indice 		= 0;
	/*
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'TI' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
							 xt_codigoProceso LIKE '%TI%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");
	
	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual de Tecnologías de la Información</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
					
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	///Manual de Operaciones
	$consecutivos 	= NULL;
	$indice 		= 0;
	/*
	$s = $INTRANET->Execute("SELECT xn_consecutivo, xt_nombre, xt_codigo, kp_itemID FROM SGI_Item WHERE xt_grupo = 'GE' AND xt_area = 'OPE' AND xt_tipo = 'K' ORDER BY xn_consecutivo");*/
	
	$s = $INTRANETV2->Execute("SELECT
								RIGHT (xt_codigoCorto, 2),
								xt_nombre,
								xt_codigoProceso,
								xt_codigoCorto
							FROM
								SGI_Procesos
							WHERE
								xt_codigoProceso LIKE '%OP%'
							ORDER BY
								RIGHT (xt_codigoCorto, 2)");

	while($r = $s->fetchRow()){
		$indice++;
		
		$consecutivos[$indice] 	= $r[0];
		$titulos[$indice] 		= $r[1];
		$codigo[$indice]		= $r[2];
		$idItem[$indice]		= $r[3];
		
	} unset($r);
	
	if($consecutivos != NULL){
		echo "<table border='0' align='center' name='Cuerpo'>";
			echo"<tr height='30px'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titulo2'>Manual de Operaciones</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='20px'> </tr>";
			
			for($i = 0; $i <= count($idItem); $i++){
				echo "<tr id='titulo2Blanco'>";
					echo "<td width='30px'> </td>";
				
					echo "<td align='left' width='250px' valign='top'>";
						//echo "<a href='FichaItem.php?id=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
						echo "<a href='Intranetv2/fichaProceso.php?proceso=".$idItem[$i]."' id='manualVinculo'>".$codigo[$i]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='550px' valign='top'>";
						echo "$titulos[$i]";
					echo "</td>";
				
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
			
			}
					
		echo "</table>";
		
	}  unset($consecutivos); unset($codigo); unset($titulos); unset($indice); unset($i);
	
	
	echo "<table border='0' align='center'>";	
		echo "<tr height='50px'>";
			echo "<td> </td>";
		echo "</tr>";
	echo"</table>";

echo "</div>";
?>

</body>
</html>
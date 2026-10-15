<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'UpdateRiesgo.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$idRiesgo = $_POST['id'];

	$fechaUpdate = date('Y-m-d', strtotime($_POST['fecha']));
	$tituloUpdate = $_POST['titulo'];
	$descripcionUpdate = $_POST['descripcion'];
	
	$tipoUpdate = $_POST['tipoR'];
	$categoriaUpdateI = $_POST['categoriaI'];
	$categoriaUpdateE = $_POST['categoriaE'];
	$categoriaUpdate = "";
	
	$probabilidadUpdate = $_POST['probabilidad'];
	$estrategiaUpdate = $_POST['estrategia'];
	$proteccionUpdate = $_POST['proteccion'];
	$amenazaUpdate = $_POST['amenaza'];
	$vulnerabilidadUpdate = $_POST['vulnerabilidad'];
	$impactoUpdate = $_POST['impacto'];
	$descripcionEstUpdate = $_POST['descripcionEst'];
	$descripcionUpdateEmer = $_POST['descripcionEmergencias'];
	$descripcionUpdatePreven = $_POST['descripcionPrevencion'];
	
		
	if($categoriaUpdateI != ""){
		$categoriaUpdate = $categoriaUpdateI;
	}else if($categoriaUpdateE !=""){
		$categoriaUpdate = $categoriaUpdateE;
	}

	$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_tituloRiesgo='$tituloUpdate',xt_descripcion='$descripcionUpdate', xt_categoriaOpcion = '$tipoUpdate', xn_categoria = $categoriaUpdate WHERE kp_riesgoId = $idRiesgo");
	
		if($probabilidadUpdate != ""){
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xn_probabilidad=$probabilidadUpdate WHERE kp_riesgoId = $idRiesgo ");
		}
		
		if($descripcionEstUpdate != ""){
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_descripcionEstrategia='$descripcionEstUpdate' WHERE kp_riesgoId = $idRiesgo ");
		}
		
		if($impactoUpdate != ""){
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xn_impacto=$impactoUpdate WHERE kp_riesgoId = $idRiesgo ");
		}
		
		
		if($probabilidadUpdate && $impactoUpdate != ""){
			
			$amenazaUpdate = $INTRANET->getOne("SELECT xt_nivelRiesgo FROM SGI_Niveles_Riesgos WHERE xn_coordenadaY= $probabilidadUpdate AND xn_coordenadaX = $impactoUpdate AND xt_impactoNombre = 'Amenaza'");
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_amenaza = '$amenazaUpdate' WHERE kp_riesgoId = $idRiesgo");
		}
		
		if($estrategiaUpdate != ""){
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_estrategia='$estrategiaUpdate' WHERE kp_riesgoId = $idRiesgo ");
			
		}
	    
		if($proteccionUpdate != "" ){
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xn_proteccion = $proteccionUpdate WHERE kp_riesgoId = $idRiesgo ");
		}
		
		if($descripcionUpdatePreven != ""){
	
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_descripcionPreventiva = '$descripcionUpdatePreven' WHERE kp_riesgoId = $idRiesgo ");
	
		}
		
		if($descripcionUpdateEmer != ""){
	
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_descripcionEmergencia = '$descripcionUpdateEmer' WHERE kp_riesgoId = $idRiesgo");
	
		}

	
		if($amenazaUpdate != ""){
			if($amenazaUpdate == 'Nula'){
				$namenaza = 0;
			}else if($amenazaUpdate == 'Muy Baja'){
				$namenaza = 1;
			}else if($amenazaUpdate == 'Baja'){
				$namenaza = 2;
			}else if($amenazaUpdate == 'Media'){
				$namenaza = 3;
			}else if($amenazaUpdate == 'Alta'){
				$namenaza = 4;
			}else if($amenazaUpdate == 'Muy Alta'){
				$namenaza = 5;
			}
		}
		
		if($proteccionUpdate!= "" && $namenaza != ""){
			//echo "SELECT xt_nivelRiesgo FROM SGI_Niveles_Riesgos WHERE xn_coordenadaY = $namenaza AND xn_coordenadaX = $proteccionUpdate AND xt_impactoNombre = 'vulnerabilidad'";
			$vulnerabilidadUpdate = $INTRANET->getOne("SELECT xt_nivelRiesgo FROM SGI_Niveles_Riesgos WHERE xn_coordenadaY = $namenaza AND xn_coordenadaX = $proteccionUpdate AND xt_impactoNombre = 'vulnerabilidad'");
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_vulnerabilidad = '$vulnerabilidadUpdate' WHERE kp_riesgoId = $idRiesgo");	
		
		}
		
			$modifica = 0;

			if($_POST['modifica'] != (NULL || '')){
				$modifica = 1;
			}
			//echo "$modifica<br>";
			
			if(($modifica == 0) || ($_POST['descripcion'] == "") ){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Control de Cambios</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
</head>

<body>	
<?PHP
				echo "<div id='wrapperPopUp'>";
				  echo "<form name='fichaSubir' method='POST' action='UpdateRiesgo.php'>";	
					echo "<table border='0' align='center' name='Encabezado'>";
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Control de Cambios</font>";
							echo"</td>";
						echo"</tr>";
						echo"<tr>"; 
							echo"<td align='center'>";
								//echo "<font>$breadcrumb</font>";
							echo"</td>";
						echo"</tr>";
						echo"<tr height='70'> </tr>";
					echo "</table>";
					
					echo "<table border='0' align='center'>";
					//TITULO ITEM
						echo "<tr align='left' height='20' >";
							echo "<td id='iconosTexto2' align='left'>Descripción</td>";
						echo "</tr>";
					//INPUT TITULO
						echo"<tr align='left'>";
							echo "<td  align='left' width='450px'>";
								echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
								echo "<input type='hidden' value='$idRiesgo' name='id'><input type='hidden' value='1' name='modifica'>";
							echo"</td>";
						echo "</tr>";
						echo"<tr height='10'> </tr>";
					echo "</table>";
					
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' width='450px'></td>";
						echo "</tr>";
						
						echo "<tr height='10'> </tr>";
						
						echo"<tr height='40'>";
							echo"<td valign='bottom' align='right'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='10'> </tr>";
					echo "</table>";
					
					echo "</form>";
				echo "</div>";
					
			} else if(($modifica == 1) && ($_POST['descripcion'] != "")){
				
				$idRiesgo = $_POST['id'];
				$descripcion = $_POST['descripcion'];
				
				$maximo = 0;
				
				$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Control_Cambios_Riesgos WHERE kf_riesgoId = $idRiesgo");
				
				while($r = $s->fetchRow()){
					$maximo = $r[0];
				}
				
				$maximo++;
				
				if($INTRANET->Execute("INSERT INTO SGI_Control_Cambios_Riesgos (kf_riesgoId, xn_numero, xd_fechaCambio, xt_descripcion, kf_actorID) 
										VALUES ($idRiesgo, $maximo, CURRENT_TIMESTAMP(), '$descripcion', '$usuarioId') ")){
			
					header("Location: fichaRiesgo.php?id=$idRiesgo");
				}
				
			}		
					
		
?>
</body>
</html>
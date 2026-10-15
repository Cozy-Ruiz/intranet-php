<?php

$nombrephp = 'UpdateRiesgo.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);


$idRiesgo = $_POST['id'];

	 $fechaUpdate = date('Y-m-d', strtotime($_REQUEST['fecha']));
	 $tituloUpdate = $_REQUEST['titulo'];
	 $descripcionUpdate = $_REQUEST['descripcion'];
	
	 $tipoUpdate = $_REQUEST['tipoR'];
	 $categoriaUpdateI = $_REQUEST['categoriaI'];
	 $categoriaUpdateE = $_REQUEST['categoriaE'];
	 $categoriaUpdate = "";
	
	 echo $probabilidadUpdate = $_REQUEST['probabilidad'];
	 $estrategiaUpdate = $_REQUEST['estrategia'];
	 $proteccionUpdate = $_REQUEST['proteccion'];
	 $amenazaUpdate = $_REQUEST['amenaza'];
	 $vulnerabilidadUpdate = $_REQUEST['vulnerabilidad'];
	 echo $impactoUpdate = $_POST['impacto'];
	 $descripcionEstUpdate = $_REQUEST['descripcionEst'];
	 $descripcionUpdateEmer = $_REQUEST['descripcionEmergencias'];
	 $descripcionUpdatePreven = $_REQUEST['descripcionPrevencion'];
	 ///Nuevo radio butons
	 $tiempoUpdate = $_REQUEST['tiempo'];
	 $economicoUpdate = $_REQUEST['economico'];
	 $imagenUpdate = $_REQUEST['imagen'];
	 $informacionUpdate = $_REQUEST['informacion'];
	 $humanoUpdate = $_REQUEST['humano'];
	 $operacionalUpdate = $_REQUEST['operacional'];




	
		
	if(!empty($categoriaUpdateI)){
		$categoriaUpdate = $categoriaUpdateI;
	}else if(!empty($categoriaUpdateE)){
		$categoriaUpdate = $categoriaUpdateE;
	}

	
	$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_tituloRiesgo='$tituloUpdate',xt_descripcion='$descripcionUpdate', xt_categoriaOpcion = '$tipoUpdate', xn_categoria = $categoriaUpdate WHERE xt_codigoRiesgo = '$idRiesgo'");
	
		if($probabilidadUpdate != ""){

			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xn_probabilidad=$probabilidadUpdate WHERE xt_codigoRiesgo = '$idRiesgo'");
		}
		
		if($descripcionEstUpdate != ""){

			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_descripcionEstrategia='$descripcionEstUpdate' WHERE xt_codigoRiesgo = '$idRiesgo'");
		}
		
		if($impactoUpdate != ""){

			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xn_impacto=$impactoUpdate WHERE xt_codigoRiesgo = '$idRiesgo'");
		}
		
		
		if(($probabilidadUpdate != "") && ($impactoUpdate != "")){
			
			
			$amenazaUpdate = $INTRANETV2->getOne("SELECT xt_nivelRiesgo FROM SGI_Matriz_Niveles_Riesgos WHERE xn_coordenadaY= $probabilidadUpdate AND xn_coordenadaX = $impactoUpdate AND xt_impactoNombre = 'Amenaza'");
			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_amenaza = '$amenazaUpdate' WHERE xt_codigoRiesgo = '$idRiesgo'");
		}
		
		if($estrategiaUpdate != ""){
			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_estrategia='$estrategiaUpdate' WHERE xt_codigoRiesgo = '$idRiesgo'");
			
		}
	    
		if($proteccionUpdate != ""){
			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xn_proteccion = $proteccionUpdate WHERE xt_codigoRiesgo = '$idRiesgo'");
		}
		
		if($descripcionUpdatePreven != ""){
	
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_descripcionPreventiva = '$descripcionUpdatePreven' WHERE xt_codigoRiesgo = '$idRiesgo'");
	
		}
		
		if($descripcionUpdateEmer != ""){
	
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_descripcionEmergencia = '$descripcionUpdateEmer' WHERE xt_codigoRiesgo = '$idRiesgo'");
	
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
		
		if(($proteccionUpdate != "")&& ($namenaza != "")){
			
			//echo "SELECT xt_nivelRiesgo FROM SGI_Niveles_Riesgos WHERE xn_coordenadaY = $namenaza AND xn_coordenadaX = $proteccionUpdate AND xt_impactoNombre = 'vulnerabilidad'";
			
			
			$vulnerabilidadUpdate = $INTRANETV2->getOne("SELECT xt_nivelRiesgo FROM SGI_Matriz_Niveles_Riesgos WHERE xn_coordenadaY = $namenaza AND xn_coordenadaX = $proteccionUpdate AND xt_impactoNombre = 'vulnerabilidad'");
			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_vulnerabilidad = '$vulnerabilidadUpdate' WHERE xt_codigoRiesgo = '$idRiesgo'");	

			//$query="UPDATE SGI_Riesgos_Consecuencias  SET 
			//xn_riesgo_tiempo		=  '$tiempoUpdate',
			//xn_riesgo_economico		=  '$economicoUpdate',
			//xn_riesgo_humano		=  '$humanoUpdate',
			//xn_riesgo_operacional	=  '$operacionalUpdate',
			//xn_riesgo_imagen		=  '$imagenUpdate',
			//xn_riesgo_información	=  '$informacionUpdate'
			//WHERE xt_codigoRiesgo = '$idRiesgo'";
		 $INTRANETV2->Execute("UPDATE SGI_Riesgos_Consecuencias 
			SET xn_riesgo_tiempo = '$tiempoUpdate' , xn_riesgo_economico = '$economicoUpdate' , xn_riesgo_economico='$economicoUpdate',xn_riesgo_humano = '$humanoUpdate' , xn_riesgo_operacional='$operacionalUpdate', xn_riesgo_imagen= '$imagenUpdate', xn_riesgo_informacion ='$informacionUpdate'
			WHERE xt_codigoRiesgo = '$idRiesgo'"); 
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
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
</head>

<body>	
<?PHP
				echo "<div id='wrapperPopUp'>";
				  echo "<form name='fichaSubir' method='POST' action='UpdateRiesgov2.php'>";	
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
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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
				
				//ME QUEDE AQUI AQUI AQUI AQUI
				
				$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Riesgos_Control_Cambios WHERE xt_codigoRiesgo = '$idRiesgo'");
				
				while($r = $s->fetchRow()){
					$maximo = $r[0];
				}
				
				 $maximo++;
				
				
				if($INTRANETV2->Execute("INSERT INTO SGI_Riesgos_Control_Cambios (xt_codigoRiesgo, xn_numero, xd_fechaCambio, xt_descripcion, xt_usuario) 
										VALUES ('$idRiesgo', $maximo, CURRENT_TIMESTAMP(), '$descripcion', '$usuarioId') ")){
			
					 
				}

			header("Location: fichaRiesgov2.php?id=$idRiesgo");
 
				
			}		
					
		
?>
</body>
</html>
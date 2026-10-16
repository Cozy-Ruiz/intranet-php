<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García Robles 
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp="procesaBusquedaSolicitudesQuejas.php";
require_once("ConexionDBT.php");
require_once("D05_conexionBD.php");
//require_once("compruebaUsuario.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resultados de Búsqueda</title>
<link type="text/css" rel="stylesheet" href="css/styleHomePage.css"/>
</head>
<body>
</head>
<?php
$campoBusqueda = $_POST["campoBusqueda"];
$op = ($_POST["condicionBusqueda"] == 2) ? "OR" : "AND";

switch($campoBusqueda){ 
	//REUNIÓN
	case 1:{
		$numOpciones = 6; 
		$nombreBusqueda = "Reunión"; 
		$ligaFicha = "SistemaGestionIntegral/fichaReunion.php?id=";		
		break;
	
	}case 2:{
		$numOpciones = 5; 
		$nombreBusqueda = "Proyecto"; 
		$ligaFicha = "AdministracionProyectos/_PPM/D05_fichaProyecto.php?idProyecto=";		
		break;
	
	}
}


//REUNIÓN
if($campoBusqueda == 1){
	
	$indice=1;
	
	for($i = 1; $i <= ($numOpciones*2); $i += 2){
		$variablePostBusqueda = "campo".$i;
		$valorSelectBusqueda = $_POST[$variablePostBusqueda];
				
		$variablePostResultado = "campo".($i+1);
		$valorSelectResultado = $_POST[$variablePostResultado];
		//echo "VPR: $variablePostResultado, VSR: $valorSelectResultado<br>";
		if($valorSelectBusqueda != 0){
			//CÓDIGO
			if($valorSelectBusqueda == 1){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
			//FECHA
			if($valorSelectBusqueda == 2){
				if(isset($valorSelectResultado) && $valorSelectResultado != 0){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
			//ESTATUS
			if($valorSelectBusqueda == 3){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
			//ASISTENTES
			if($valorSelectBusqueda == 4){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					//echo "$arrayCampoResultado[$indice]<br>";
					$indice++;
				}
			}
			//ACUERDOS
			if($valorSelectBusqueda == 5){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
		}
	}
	
	$numCampos = count($arrayCampoBusqueda);
	
	$queryBusqueda = "";
	
	if(!empty($arrayCampoBusqueda)){
		
		foreach($arrayCampoBusqueda as $ind => $valor){
			switch($valor){
				//REUNIÓN CÓDIGO
				case 1: $queryBusqueda.=" xt_claveReunion LIKE '%".$arrayCampoResultado[$ind]."%' "; 
						$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						break;
				//REUNIÓN FECHA
				case 2: $fechas = explode(":::", $arrayCampoResultado[$ind]);
						if(count($fechas) >= 2){
							$queryBusqueda.=" xd_fecha BETWEEN '$fechas[0]' AND '$fechas[1]' "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						} else{
							$queryBusqueda.=" xd_fecha = '$arrayCampoResultado[$ind]' "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						}
						break;
				//REUNION ESTATUS
				case 3: $queryBusqueda.=" xt_status = ".$arrayCampoResultado[$ind]." "; 
						$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						break;
				//REUNION ASISTENTES
				case 4: $asistentes = $arrayCampoResultado[$ind];
						//echo "$asistentes";
						$asistentesID = "";
						//for($i = 0; $i <= count($asistentes); $i++)
						foreach($asistentes as $valor){
							$asistentesID = $asistentesID.$valor.", ";
						}
						
						$asistentesID = substr($asistentesID, 0, -2);
						unset($asistentes);
						
						$reuniones = "";
						//echo "SELECT DISTINCT(kf_reunionID) FROM SGI_Reunion_Asistentes WHERE kf_personalID IN ( $asistentesID )";
						$s = $INTRANET->Execute("SELECT DISTINCT(kf_reunionID) FROM SGI_Reunion_Asistentes WHERE kf_personalID IN ( $asistentesID ) ");
						while($r = $s->fetchRow()){
							$reuniones = $reuniones.$r[0].", ";
						} unset($r); unset($s); unset($asistentesID);
						
						if($reuniones != ""){
							$reuniones = substr($reuniones, 0, -2);
							$queryBusqueda.=" kp_reunionID IN ( ".$reuniones." ) "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						}
						break;
				//REUNIÓN ACUERDO
				case 5: $acuerdo = trim($arrayCampoResultado[$ind]);
						$reuniones = "";
						$s = $INTRANET->Execute("SELECT DISTINCT(SRE.kp_reunionID) FROM SGI_Acuerdos SAC, SGI_Reuniones SRE WHERE SAC.kf_reunionID = SRE.kp_reunionID AND SAC.xt_claveAcuerdo LIKE '%$acuerdo%' ");
						while($r = $s->fetchRow()){
							$reuniones = $reuniones.$r[0].", ";
						} unset($r); unset($s); unset($acuerdo);
						
						if($reuniones != ""){
							$reuniones = substr($reuniones, 0, -2);
							$queryBusqueda.=" kp_reunionID IN ( ".$reuniones." ) "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						}
						break;
				
			}
			
		}
	}
	
	//echo "select kp_proyectoId, xt_codigoProyecto, xt_nombreProyecto from portafolio_proyecto where $queryBusqueda";
	if($queryBusqueda != ""){
		$indiceArray = 0;
		//echo "SELECT kp_reunionID, xt_claveReunion, xt_status, xd_fecha FROM SGI_Reuniones WHERE $queryBusqueda <br>";
		$s = $INTRANET->Execute("SELECT kp_reunionID, xt_claveReunion, xt_status, xd_fecha FROM SGI_Reuniones WHERE $queryBusqueda "); 
		
		while($r = $s->fetchRow()){
			$arrayResultados[$indiceArray][1] = $r[0];
			$arrayResultados[$indiceArray][2] = $r[1];
			
			if($r[2] == 1){
				$arrayResultados[$indiceArray][3] = "Programada";
			} else if($r[2] == 2){
				$arrayResultados[$indiceArray][3] = "Realizada";
			} else if($r[2] == 3){
				$arrayResultados[$indiceArray][3] = "Pospuesta";
			}
			
			$arrayResultados[$indiceArray][4] = $r[3];
			$indiceArray++;					
		}
	}
}

//PROYECTO
if($campoBusqueda == 2){
	
	$indice=1;
	
	for($i = 1; $i <= ($numOpciones*2); $i += 2){
		$variablePostBusqueda = "campo".$i;
		$valorSelectBusqueda = $_POST[$variablePostBusqueda];
				
		$variablePostResultado = "campo".($i+1);
		$valorSelectResultado = $_POST[$variablePostResultado];
		//echo "VPR: $variablePostResultado, VSR: $valorSelectResultado,$valorSelectBusqueda<br>";
		if($valorSelectBusqueda != 0){
			//FECHA
			if($valorSelectBusqueda == 1){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
			//CODIGO
			if($valorSelectBusqueda == 2){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
			//ETAPAS
			if($valorSelectBusqueda == 3){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
			//DESCRIPCION
			if($valorSelectBusqueda == 4){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					//echo "$arrayCampoResultado[$indice]<br>";
					$indice++;
				}
			}
			//RESPONSABLES
			if($valorSelectBusqueda == 5){
				if(isset($valorSelectResultado) && $valorSelectResultado != ""){
					$arrayCampoBusqueda[$indice] = $valorSelectBusqueda;
					$arrayCampoResultado[$indice] = $valorSelectResultado;
					$indice++;
				}
			}
		}
	}
	
	$numCampos = count($arrayCampoBusqueda);
	
	$queryBusqueda = "";
	//echo"acv:$arrayCampoBusqueda<br>";
	if(!empty($arrayCampoBusqueda)){
		
		foreach($arrayCampoBusqueda as $ind => $valor){
			switch($valor){
				
				//PROYECTO FECHA
				case 1: $fechas = explode(":::", $arrayCampoResultado[$ind]);
						if(count($fechas) >= 2){
							$queryBusqueda.=" xd_fechaRegistro BETWEEN '$fechas[0]' AND '$fechas[1]' "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						} else{
							$queryBusqueda.=" xd_fechaRegistro = '$arrayCampoResultado[$ind]' "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						}
						break;
				//PROYECTO CÓDIGO
				case 2: $queryBusqueda.=" xt_codigoProyecto LIKE '%".$arrayCampoResultado[$ind]."%' "; 
						$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						break;
				/*//PROYECTO ETAPAS
				case 3: $queryBusqueda.=" xt_status = ".$arrayCampoResultado[$ind]." "; 
						$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						break;
				//PROYECTO RESPONSABLE
				case 5: $asistentes = $arrayCampoResultado[$ind];
						//echo "$asistentes";
						$asistentesID = "";
						//for($i = 0; $i <= count($asistentes); $i++)
						foreach($asistentes as $valor){
							$asistentesID = $asistentesID.$valor.", ";
						}
						
						$asistentesID = substr($asistentesID, 0, -2);
						unset($asistentes);
						
						$reuniones = "";
						//echo "SELECT DISTINCT(kf_reunionID) FROM SGI_Reunion_Asistentes WHERE kf_personalID IN ( $asistentesID )";
						$s = $PORTAFOLIO->Execute("SELECT DISTINCT(kp_proyectoId) FROM portafolio_proyecto WHERE kf_personalID IN ( $asistentesID ) ");
						while($r = $s->fetchRow()){
							$reuniones = $reuniones.$r[0].", ";
						} unset($r); unset($s); unset($asistentesID);
						
						if($reuniones != ""){
							$reuniones = substr($reuniones, 0, -2);
							$queryBusqueda.=" kp_reunionID IN ( ".$reuniones." ) "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						}
						break;
				//REUNIÓN ACUERDO
				case 5: $acuerdo = trim($arrayCampoResultado[$ind]);
						$reuniones = "";
						$s = $INTRANET->Execute("SELECT DISTINCT(SRE.kp_reunionID) FROM SGI_Acuerdos SAC, SGI_Reuniones SRE WHERE SAC.kf_reunionID = SRE.kp_reunionID AND SAC.xt_claveAcuerdo LIKE '%$acuerdo%' ");
						while($r = $s->fetchRow()){
							$reuniones = $reuniones.$r[0].", ";
						} unset($r); unset($s); unset($acuerdo);
						
						if($reuniones != ""){
							$reuniones = substr($reuniones, 0, -2);
							$queryBusqueda.=" kp_reunionID IN ( ".$reuniones." ) "; 
							$queryBusqueda.=($ind != $numCampos) ? " $op " : "";
						}
						break;
				*/
			}
			
		}
	}
	
	//echo "SELECT kp_proyectoId, xt_codigoProyecto, xd_fechaRegistro FROM portafolio_proyecto WHERE $queryBusqueda <br>";
	if($queryBusqueda != ""){
		$indiceArray = 0;
		//echo "SELECT kp_proyectoId, xt_codigoProyecto, xd_fechaRegistro FROM portafolio_proyecto WHERE $queryBusqueda <br>";
		$s = $PORTAFOLIO->Execute("SELECT kp_proyectoId, xt_codigoProyecto, xd_fechaRegistro FROM portafolio_proyecto WHERE $queryBusqueda "); 
		
		while($r = $s->fetchRow()){
			$arrayResultados[$indiceArray][1] = $r[0];
			$arrayResultados[$indiceArray][2] = $r[1];
			/* Se quito el Status
			if($r[2] == 1){
				$arrayResultados[$indiceArray][3] = "Programada";
			} else if($r[2] == 2){
				$arrayResultados[$indiceArray][3] = "Realizada";
			} else if($r[2] == 3){
				$arrayResultados[$indiceArray][3] = "Pospuesta";
			}
			*/
			$arrayResultados[$indiceArray][3] = $r[2];
			$indiceArray++;					
		}
	}
}
$breadcrumb="<a href='Home.php' id='breadcrumbs'> Home </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>Resultados de la Búsqueda</td>";
		echo"</tr>";
		
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='70'> </tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='4'><i>Resultados para $nombreBusqueda</i></td>";
		echo "</tr>";	
		
		echo "<tr height='15'> </tr>";		
	
		if(isset($arrayResultados)){
			foreach($arrayResultados as $clave => $arrayEnVector){
			   echo "<tr id='iconosTexto'>";
			   		echo "<td width='20px'> </td>";				
					echo "<td width='180px' align='left' >";
						echo "<a href='".$ligaFicha."$arrayEnVector[1]' id='iconosTexto'>$arrayEnVector[2]</font>";
					echo "</td>";
					
					echo "<td width='200px' align='left'>";
						echo "$arrayEnVector[3]";
					echo "</td>";
					
					echo "<td width='200px' align='left'>";
						echo "$arrayEnVector[4]";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='5'> </tr>";	
			}
			
		} else{
			
			echo "<tr>";				
				echo "<td align='center'colspan='4' width='600px'><i>No hay resultados.</i></td>";
			echo "</tr>";
		}
		
		echo "<tr height='15'> </tr>";
	
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='4'></td>";
		echo "</tr>";
		
		echo "<tr height='50'> </tr>";		
	
	echo "</table>";
echo "</div>";
?>
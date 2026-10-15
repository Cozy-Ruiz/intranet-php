<?php
require_once("../../ConexionIntranet2.php");

if($_REQUEST['evento'] == "actualizaManual"){
		
		$proceso = $_POST['proceso'];
		$manual  = $_POST['manual'];
		$codigo  = explode("-",trim($_POST['codigo']));
		$grupo   = $codigo[0];
		$ciudad  = $codigo[2];
		$consecutivo  = $codigo[4];
	
		$codigoNuevo = $grupo."-".$manual."-".$ciudad."-".'K-'.$consecutivo;
	
		//echo"UPDATE SGI_Procesos SET xt_codigoManual = '$manual', xt_codigoProceso = '$codigoNuevo'  WHERE xt_codigoCorto = '$proceso'";
		if($INTRANETV2->Execute("UPDATE SGI_Procesos SET xt_codigoManual = '$manual', xt_codigoProceso = '$codigoNuevo'  WHERE xt_codigoCorto = '$proceso'")){
		
			echo true;
		}else{
			echo "Hubo un error al actualizar ciudad";
		}
}
if($_REQUEST['evento'] == "actualizaGrupo"){
		
		$proceso = $_POST['proceso'];
		$grupo   = $_POST['grupo'];
		$codigo  = explode("-",trim($_POST['codigo']));
		$manual  = $codigo[1];
		$ciudad  = $codigo[2];
		$consecutivo  = $codigo[4];
	
		$codigoNuevo = $grupo."-".$manual."-".$ciudad."-".'K-'.$consecutivo;
		
		//echo"UPDATE SGI_Procesos SET xt_grupo = '$grupo', xt_codigoProceso = '$codigoNuevo' WHERE xt_codigoCorto = '$proceso'";
		if($INTRANETV2->Execute("UPDATE SGI_Procesos SET xt_grupo = '$grupo', xt_codigoProceso = '$codigoNuevo' WHERE xt_codigoCorto = '$proceso' ")){
			
			echo true;
		}else{
			echo "Hubo un error al actualizar Grupo";
		}
				
}
if($_REQUEST['evento'] == "actualizaCiudad"){
		
		$proceso = $_POST['proceso'];
		$ciudad  = $_POST['ciudad'];
		$codigo  = explode("-",trim($_POST['codigo']));
		$grupo   = $codigo[0];
		$manual  = $codigo[1];
		$consecutivo  = $codigo[4];
		
		if($grupo == 'GEA' || $grupo == 'CRP'|| $grupo == 'NYE' || $grupo == 'OTF'){

			if($ciudad == 'TOL' || $ciudad == 'VER'){

				$codigoNuevo = 'NYE'."-".$manual."-".$ciudad."-".'K-'.$consecutivo;

			}else if($ciudad == 'CMX' || $ciudad == 'CUN' || $ciudad == 'NLR' || $ciudad == 'QRO'){

				$codigoNuevo = 'GEA'."-".$manual."-".$ciudad."-".'K-'.$consecutivo;

			}else if($ciudad == 'LRD'){

				$codigoNuevo = 'OTF'."-".$manual."-".$ciudad."-".'K-'.$consecutivo;

			}else if($ciudad == 'GRL'){

				$codigoNuevo = 'CRP'."-".$manual."-".$ciudad."-".'K-'.$consecutivo;

			}
		}else{
			 
			$codigoNuevo = $grupo."-".$manual."-".$ciudad."-".'K-'.$consecutivo;
		}
		
		//echo "UPDATE SGI_Procesos SET xt_ciudad = '$ciudad', xt_codigoProceso = '$codigoNuevo' WHERE xt_codigoCorto = '$proceso'";
		if($INTRANETV2->Execute("UPDATE SGI_Procesos SET xt_ciudad = '$ciudad', xt_codigoProceso = '$codigoNuevo' WHERE xt_codigoCorto = '$proceso' ")){
			
			echo true;
		}else{
			echo "Hubo un error al actualizar ciudad";
		}
				
}

?>

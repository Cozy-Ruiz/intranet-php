<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García Robles 
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = "generarBusquedaSolicitudesQuejas.php";
require_once("../ConexionDBT.php");
require_once("../D05_conexionBD.php");

// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects[] = array();

$listadoSelects["campo1"] = "campo1";
$listadoSelects["campo2"] = "campo2";
$listadoSelects["campo3"] = "campo3";
$listadoSelects["campo4"] = "campo4";
$listadoSelects["campo5"] = "campo5";
$listadoSelects["campo6"] = "campo6";
$listadoSelects["campo7"] = "campo7";
$listadoSelects["campo8"] = "campo8";
$listadoSelects["campo9"] = "campo9";
$listadoSelects["campo10"] = "campo10";
$listadoSelects["campo11"] = "campo11";
$listadoSelects["campo12"] = "campo12";
$listadoSelects["campo13"] = "campo13";
$listadoSelects["campo14"] = "campo14";
$listadoSelects["campo15"] = "campo15";
$listadoSelects["campo16"] = "campo16";
$listadoSelects["campo17"] = "campo17";
$listadoSelects["campo18"] = "campo18";

function validaSelect($selectDestino){
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada){
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

function validaCampoBusqueda($campoBusqueda){
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($campoBusqueda)) return true;
	else return false;
}

$selectDestino		= $_GET["select"]; 
$opcionSeleccionada	= $_GET["opcion"];
//$campoBusqueda 		= $_GET["campoBusqueda"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada)/* && validaCampoBusqueda($campoBusqueda)*/){
	//if($campoBusqueda == 1){
	//CIUDAD
	if($opcionSeleccionada == 1){
		$ciudades[1] = "Distrito Federal";
		$ciudades[2] = "Nuevo Laredo";
		$ciudades[3] = "Cancún";
		$ciudades[4] = "Veracruz";
		$ciudades[5] = "Toluca";
		$ciudades[6] = "Laredo";
		
		$cdValor[1] = "DF";
		$cdValor[2] = "NLR";
		$cdValor[3] = "CUN";
		$cdValor[4] = "VER";
		$cdValor[5] = "TOL";
		$cdValor[6] = "LAR";
		
		echo "<select name='".$selectDestino."[]' id='".$selectDestino."' multiple style='min-width: 200px; max-width: 200px; border:0;'>";
			echo "<option value=0>Elige</option>";
			for($i = 1; $i <= 6; $i++){
				echo "<option value=".$cdValor[$i].">".$ciudades[$i]."</option>";
			}
		echo "</select>";
	}
	//FECHA
	if($opcionSeleccionada == 2){
		echo "<input type='text' class='DatP' name='".$selectDestino."' id='".$selectDestino."' style='min-width: 197px; max-width: 197px; border:0;'>";
	}
	//ESTATUS SOLICITUD
	if($opcionSeleccionada == 3){
		echo "<select name='".$selectDestino."' id='".$selectDestino."' style='min-width: 200px; max-width: 200px; border:0;'>";
			echo "<option value=0>Elige</option>";
			echo "<option value=1>Sin asignar</option>";
			echo "<option value=2>Asignada</option>";
			echo "<option value=3>Para revisión</option>";
			echo "<option value=4>Rechazada</option>";
			echo "<option value=5>Terminada</option>";
		echo "</select>";
	}
	//ESTATUS QUEJA
	if($opcionSeleccionada == 4){
		echo "<select name='".$selectDestino."' id='".$selectDestino."' style='min-width: 200px; max-width: 200px; border:0;'>";
			echo "<option value=0>Elige</option>";
			echo "<option value=1>Sin asignar</option>";
			echo "<option value=2>Asignada</option>";
			echo "<option value=3>Evaluación Inicial</option>";
			echo "<option value=4>Investigación</option>";
			echo "<option value=5>Respuesta</option>";
			echo "<option value=6>Comunicación</option>";
			echo "<option value=7>Cierre</option>";
		echo "</select>";
	}
	//PDR
	if($opcionSeleccionada == 5){
		echo "<select name='".$selectDestino."[]' id='".$selectDestino."' multiple style='min-width: 200px; max-width: 200px; border:0;'>";
			echo "<option value=0>Elige</option>";
			
			$s = $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno 
									FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP 
									WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad = 'PDR' ");
									
			while($r = $s->fetchRow()){
				echo "<option value=".$r[0].">".$r[1]." ".$r[2]."</option>";
				
			}unset($r); unset($s);
			
		echo "</select>";
	}
	//}
}

?>
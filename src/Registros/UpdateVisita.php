<?PHP
$nombrephp="UpdateVisita.php";
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");


$ciudad = $_POST['cd'];
$IDvisita= $_POST['Id'];
$gafete = $_POST['gafete'];
$fecha = $_POST['fecha'];
$Entrada = $_POST['horaEntrada'];
$salida = $_POST['horaSalida'];
$nombre = $_POST['nombre'];
$apellidoP = $_POST['apaterno'];
$apellidoM = $_POST['amaterno'];
$empresa = $_POST['empresa'];
$responsable = $_POST['personaVisita'];
$identificacion =$_POST['identificacion'];
$computo = $_POST['ecomputo'];
$placa = $_POST['placa'];

if($ciudad !=""){
	$consultaCiudad="UPDATE SGI_Visitas" ;
	if($ciudad != 'CMX' && $ciudad != 'DF' && $ciudad != 'CDMX'){
		$consultaCiudad=$consultaCiudad."_".$ciudad;
	}
	$consultaCiudad=$consultaCiudad." SET 
xd_fecha= '$fecha',xt_nombre='$nombre',xt_apellidoPaterno='$apellidoP',xt_apellidoMaterno='$apellidoM',xt_empresaRepresenta='$empresa',kf_personalEncargadoId=$responsable,
xt_horaEntrada='$Entrada',xt_identificacion='$identificacion',xt_equipoComputo='$computo',xn_credencial='$gafete',xt_placaVehicular='$placa' WHERE kp_visitaID=$IDvisita ";
	$INTRANET->Execute($consultaCiudad);
}

/*$INTRANET->Execute("UPDATE SGI_Visitas SET 
xd_fecha= '$fecha',xt_nombre='$nombre',xt_apellidoPaterno='$apellidoP',xt_apellidoMaterno='$apellidoM',xt_empresaRepresenta='$empresa',kf_personalEncargadoId=$responsable,
xt_horaEntrada='$Entrada',xt_identificacion='$identificacion',xt_equipoComputo='$computo',xn_credencial='$gafete',xt_placaVehicular='$placa' WHERE kp_visitaID=$IDvisita ");*/

if($salida != (""||NULL)){
	
	if($ciudad !=""){
		$consultaCiudad="UPDATE SGI_Visitas" ;
		if($ciudad != 'DF'){
			$consultaCiudad=$consultaCiudad."_".$ciudad;
		}
		$consultaCiudad=$consultaCiudad." SET xt_horaSalida='$salida' WHERE kp_visitaID=$IDvisita ";
		$INTRANET->Execute($consultaCiudad);
	}
	
	//$INTRANET->Execute("UPDATE SGI_Visitas SET xt_horaSalida='$salida' WHERE kp_visitaID=$IDvisita ");
}
	header("Location: fichaVisita.php?id=$IDvisita&cd=$ciudad");

?>
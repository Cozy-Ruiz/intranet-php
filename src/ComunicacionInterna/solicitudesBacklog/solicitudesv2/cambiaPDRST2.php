<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<?php


require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("mailSolicitudPDR_ST.php");

 $_POST['codigo'];
 $_POST['pdr'];
 $_POST['tipoS'];
 $_POST['titulo'];
 $_POST['nombreSolicitante'];
 $_POST['correoSolicitante'];

if(isset($_POST['codigo']) && isset($_POST['pdr'])){
	
	//defino variables
	$pdr = $_POST['pdr'];
			//codigo del entregable
		$codS = $_POST['codigo'];
		
		$tipoS = $_POST['tipoS'];
		$tituloMail = $_POST['titulo'];
		$nombreSolicitante = $_POST['nombreSolicitante'];
		$correoSolicitante = $_POST['correoSolicitante'];
		
		
		//obtengo el pdr asignado anteriormente 
			if($INTRANETV2 -> Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_pdr = '$pdr' WHERE xt_quejaSolicitud = '$codS'")){

				//Actualizo registro de pdr en la tabla de SGI_quejas_Solicitudes_Estatusv2
				$INTRANETV2 -> Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET kf_usuario = '$pdr' WHERE xt_quejaSolicitud = '$codS'");


				echo $descripcionM = $INTRANETV2->GetOne("SELECT xt_descripcion FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codS'");

				$r = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM PERFILES.USUARIOS WHERE xt_usuario = '$pdr'");

				while($listDatosPDR = $r->fetchRow()){
	
					$nombrePDR = $listDatosPDR[0];
					$correoPDR = $listDatosPDR[1];
				}
				//echo "paso";
				//echo $nombrePDR;
			//mando llamar a script de envio de correo de asignacion de PDR
				$enviaCorreo = new MailSolicitudAsignar($codS, $correoPDR, $nombrePDR, $tipoS, $tituloMail, $descripcionM, $correoSolicitante, $nombreSolicitante);		
		}	//fin del if al cambio de PDR
		//if($descripcionM != ''){
			
			?>
			<script>
				//alert("Pasó");
				window.location.reload();
			</script>
			<?php
		//}
}//fin del if de verificacion de existencia de codigoS y tipoSolicitud
?>
</body>
</html>
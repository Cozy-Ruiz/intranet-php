<?php
$nombrephp='cambiaStatusProceso.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");


	$codigo  = $_GET['codigo'];
	$status  = $_GET['status'];

$INTRANETV2->Execute("UPDATE SGI_Procesos SET xn_modificando = $status WHERE xt_codigoCorto = '$codigo'");
if($status==0){
			?>
			<script language="javascript" type="text/javascript">
				var codigo = "<?php echo $codigo;?>";
				window.open( "controlCambiosv3.php?codDoc=" + codigo, "cCambios", "width=550,height=450, top=85,left=50");
				window.close();
				</script><?php	
}else{
header ("Location: fichaProceso.php?proceso=$codigo");
}
?>
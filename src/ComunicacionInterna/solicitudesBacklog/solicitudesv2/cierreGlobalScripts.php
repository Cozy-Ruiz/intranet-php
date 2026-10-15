<?php error_reporting(0); ?>
﻿<?php


$nombrephp = 'tableroSolicitudesyQuejas.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("../../../compruebaUsuario.php");


 
 $Consulta = $_REQUEST['Consulta'];

 $codigo = $_REQUEST['codigo'];
 
 

if($Consulta==1 )
{
	$w= $INTRANETV2->Execute("UPDATE INTRANET2.SGI_Quejas_Solicitudesv2 SET xt_status = 'TERMINADA' WHERE xt_quejaSolicitud = '$codigo'" );
	$query = "INSERT INTO INTRANET2.SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, kf_usuario,xd_fecha) VALUES ('$codigo', 3, 'TERMINADA', 'Cerrado por Gerente de Sistemas, por tiempo transcurrido', 'Gerente_Sistemas',CURDATE())";
	//echo "$query";
	$w= $INTRANETV2->Execute($query );

}
else if($Consulta==2 )
{
	$w= $INTRANETV2->Execute("SELECT DISTINCT YEAR(xd_fecha) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) > 2017" );
}
 

      
        

//$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
	
	
  //LINKS PARA BUSQUEDAS
   
			//$w= $INTRANETV2->Execute("SELECT DISTINCT YEAR(xd_fecha) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) > 2017" );
		//	while($p= $w->fetchRow()){
		//		echo"<input type='checkbox' name='anio[]' value='".$p[0]."'>$p[0]<br>";
		//	}
	  
?>

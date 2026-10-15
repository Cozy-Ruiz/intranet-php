<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio F. García Robles
 *@version 3.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'tableroSolicitudesyQuejas.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna </a>";

$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";
$ciudades[7] = "Todas";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN";
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
$cdValor[7]	= "ALL";

$mesNombre[1] 	= "Enero";
$mesNombre[2] 	= "Febrero";
$mesNombre[3] 	= "Marzo";
$mesNombre[4] 	= "Abril";
$mesNombre[5] 	= "Mayo";
$mesNombre[6] 	= "Junio";
$mesNombre[7] 	= "Julio";
$mesNombre[8] 	= "Agosto";
$mesNombre[9] 	= "Septiembre";
$mesNombre[10] 	= "Octubre";
$mesNombre[11] 	= "Noviembre";
$mesNombre[12] 	= "Diciembre";
$mesNombre[13]  = "Todos";

$estatusSol[1]	= "Sin asignar";
$estatusSol[2]	= "Asignada";
$estatusSol[3]	= "Para revisión";
$estatusSol[4]	= "Rechazada";
$estatusSol[5]	= "Terminada";
$estatusSol[6]	= "Todos";

$statusSolicitud[1] = "ABIERTA";
$statusSolicitud[2] = "REVISION";
$statusSolicitud[3] = "RECHAZADA";
$statusSolicitud[4] = "TERMINADA";

$estatusQue[0]	= "Sin asignar";
$estatusQue[1]	= "Asignada";
$estatusQue[2]	= "Evaluación Inicial";
$estatusQue[3]	= "Investigación";
$estatusQue[4]	= "Respuesta";
$estatusQue[5]	= "Comunicación";
$estatusQue[6]	= "Cierre";
$estatusQue[7]	= "Todos";

$statusQueja[1] = "Asignada";
$statusQueja[2] = "Evaluación Inicial";
$statusQueja[3] = "Investigación";
$statusQueja[4] = "Respuesta";
$statusQueja[5] = "Comunicación";
$statusQueja[6] = "Cierre";

$indice 				= 1;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadElegida 		= "";
$anio 				= 0;
$mes 				= 0;
$querySolicitudes 	= "";
$solSinAsignar 		= 0;
$queryPDR 			= "";
$queryQuejas		= "";

if($categoriaUsr == "Administrador"){
				
	$currentYear  = date('Y');
	$currentMonth = date('m');
	
	if($_POST['ciudad'] != ""){
		
		$ciudadElegida = $_POST['ciudad'];
		
	} else{
		
		$ciudadElegida = "ALL";
		//$ciudadElegida = $ciudadDefault;
		
	}
	
	if($_POST['anio'] != ""){
		
		$anio = $_POST['anio'];
		
	} else{
		
		$anio = $currentYear;
		
	}
	
	if($_POST['mes'] != ""){
		
		$mes = $_POST['mes'];
		
	} else{
		
		$mes = 13;
		
	}
	
	$estSolElegida 		= NULL;
	$querySolicitudes	= "";
	$solSinAsignar 		= 0;
	
	if($_POST['estSol'] != ""){
		
		$contador = 0;
		
		foreach($_POST['estSol'] as $statusSolicitudTmp){
			
			$estSolElegida[$contador] = $statusSolicitudTmp;
			
			if(	  	  $statusSolicitudTmp == "Sin asignar"){
				
				$solSinAsignar = 1;
			
			} else if($statusSolicitudTmp == "Asignada"){
				
				$aux = "ABIERTA";
				
			} else if($statusSolicitudTmp == "Para revisión"){
				
				$aux = "REVISION";
				
			} else if($statusSolicitudTmp == "Rechazada"){
				
				$aux = "RECHAZADA";
				
			} else if($statusSolicitudTmp == "Terminada"){
				
				$aux = "TERMINADA";
				
			}
			
			$querySolicitudes = $querySolicitudes."'".$aux."', ";
			$contador++;
			
		}
		
		$querySolicitudes = substr($querySolicitudes, 0, -2);
		
	} else{
		
		$estSolElegida[0] 	= "Sin asignar";
		$estSolElegida[1] 	= "Asignada";
		$estSolElegida[2] 	= "Rechazada";
		$estSolElegida[3] 	= "Para revisión";
		
		$solSinAsignar 		= 1;
		
		$querySolicitudes 	= "'ABIERTA', 'REVISION', 'RECHAZADA' ";
		//$querySolicitudes	= "Todos";
		
	}
	
	$estQueElegida 	= NULL;
	$queryQuejas 	= "";
	$queSinAsignar 	= 0;
	
	if($_POST['estQue'] != ""){
		
		$contador = 0;
		
		foreach($_POST['estQue'] as $statusQuejaTmp){
			
			$estQueElegida[$contador] 	= $statusQuejaTmp;
			$aux 						= "";
			
			if(		  $statusQuejaTmp == "Sin asignar"){
				
				$queSinAsignar = 1;
				
			} else if($statusQuejaTmp == "Asignada"){
				
				$aux = 1;
				
			} else if($statusQuejaTmp == "Evaluación Inicial"){
				
				$aux = 2;
				
			} else if($statusQuejaTmp == "Investigación"){
				
				$aux = 3;
				
			} else if($statusQuejaTmp == "Respuesta"){
				
				$aux = 4;
				
			} else if($statusQuejaTmp == "Comunicación"){
				
				$aux = 5;
				
			} else if($statusQuejaTmp == "Cierre"){
				
				$aux = 6;
				
			}
			
			if($aux != ""){
				
				$queryQuejas = $queryQuejas.$aux.", ";
				
			}
			
			$contador++;
		}
		
		$queryQuejas = substr($queryQuejas, 0, -2);
		
	} else{
		
		$estQueElegida[0] 	= "Sin asignar";
		$estQueElegida[1] 	= "Asignada";
		$estQueElegida[2] 	= "Evaluación Inicial";
		$estQueElegida[3] 	= "Investigación";
		$estQueElegida[4] 	= "Respuesta";
		$estQueElegida[5] 	= "Comunicación";
		
		$queSinAsignar 		= 1;
		
		$queryQuejas 	= "1, 2, 3, 4, 5";
		
	}
	
	$pdrFiltro 	= NULL;
	$queryPDR	= "";
	
	if($_POST['pdr'] != ""){
		
		$contador = 0;
		
		foreach($_POST['pdr'] as $pdrFiltroTmp){
			$pdrFiltro[$contador] 	= $pdrFiltroTmp;
			$queryPDR 				= $queryPDR.$pdrFiltroTmp.", ";
			$contador++;
		} unset($i); unset($contador);
		
		$queryPDR = substr($queryPDR, 0, -2);
		
	} else{
		
		$pdrFiltro[0] 	= "Todos";
		$queryPDR 		= "Todos";
		
	}
	
}



function noSolicitudes(){
	
	?>
    <table border="0" align="center">
        <tr height="10px"><td></td></tr>
    </table>
    
    <table border="0" align="center"  width="1200px">
        <tr id="titulo2">
            <td width="30px"></td>
            <td width="150px" align="center">Código</td>
            <td width="350px" align="left">Título</td>
            <td width="10px"></td>
            <td width="100px" align="center">Fecha</td>
            <td width="10px"></td>
            <td width="120px" align="left">Status</td>
            <td width="200px" align="left">Solicitante</td>
            <td width="10px"></td>
            <td width="200px" align="left">PDR</td>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="9" id="titleBlueLineTop"></td>
        </tr>
        
        <tr height="20px"><td colspan="10"></td></tr>
        
        <tr>
			<td align="center" id="titulo12" colspan="10"><i>No hay Solicitudes que mostrar.</i></td>
        </tr>
        
        <tr height="20px"><td colspan="10"></td></tr>
    </table>
	<?php
	
}

function imprimeSolEncabezado(){
	
	?>
    <table border="0" align="center">
        <tr height="10px"><td></td></tr>
    </table>
    
    <table border="0" align="center"  width="1200px">
        <tr id="titulo2">
            <td width="30px"></td>
            <td width="150px" align="center">Código</td>
            <td width="350px" align="left">Título</td>
            <td width="10px"></td>
            <td width="100px" align="center">Fecha</td>
            <td width="10px"></td>
            <td width="120px" align="left">Status</td>
            <td width="200px" align="left">Solicitante</td>
            <td width="10px"></td>
            <td width="200px" align="left">PDR</td>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="9" id="titleBlueLineTop"></td>
        </tr>
        
        <tr height="10px"><td colspan="10"></td></tr>
    </table>
    <?php
	
}

function imprimeSolicitudes($solicitudID, $claveSolicitud, $tituloSolicitud, $fechaSolicitud, $status, $solicitanteUsr, $pdr){
	
	?>
	<table border="0" align="center"  width="1200px">
		<tr height="25px" id="fileItem">
			<td width="30px"></td>
			
			<td width="150px" align="center" valign="top">
				<a href="fichaSolicitud.php?id=<?php echo $solicitudID; ?>" id="fileItem" style="text-decoration:none;"><?php echo $claveSolicitud; ?></a>
			</td>
			
			<td width="350px" align="left" valign="top"><?php echo $tituloSolicitud; ?></td>
			
			<td width="10px"></td>
			
			<td width="100px" align="center" valign="top"><?php echo $fechaSolicitud; ?></td>
			
			<td width="10px"></td>
			
			<td width="120px" align="left" valign="top"><?php echo $status; ?></td>
			
			<td width="200px" align="left" valign="top"><?php echo $solicitanteUsr; ?></td>
			
			<td width="10px"></td>
			
			<td width="200px" align="left" valign="top"><?php echo $pdr; ?></td>
		</tr>
	</table>
	<?php
	
}


function inhouseSolicitudes(){
	
	global $cdValor, $ciudadesDisponibles, $usuarioId, $INTRANET;
	
	$bandera 			= 0;
	$i 					= 1;
	$solicitudID 		= NULL;
	$claveSolicitud 	= NULL;
	$tituloSolicitud 	= NULL;
	$fechaSolicitud 	= NULL;
	$solicitanteUsr		= NULL;
	$status 			= NULL;
	$pdr				= NULL;
	$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
	
	/*
	echo "SELECT kp_quejaSolicitudID, xt_claveQuejaSolicitud, xt_titulo, xd_fecha, kf_usuarioId, xt_status, kf_pdrId 
							FROM SGI_Quejas_Solicitudes WHERE xt_tipo = 'B' AND kf_usuarioId = '$usuarioId' AND xt_ciudad = '$ciudadDefault'
							
							UNION 
							
							SELECT kp_quejaSolicitudID, xt_claveQuejaSolicitud, xt_titulo, xd_fecha, kf_usuarioId, xt_status, kf_pdrId 
							FROM SGI_Quejas_Solicitudes WHERE xt_tipo = 'Q' AND kf_usuarioId = '$usuarioId' AND xt_ciudad = '$ciudadDefault'
							ORDER BY xt_claveQuejaSolicitud DESC <br><br>"; */
							
	///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
	$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
							FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM WHERE SQS.xt_tipo = 'B' 
							AND SQS.kf_usuarioId = '$usuarioId' AND SQS.kf_usuarioId = SEM.kf_usuario 
							
							UNION 
							
							SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
							FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM, SGI_Seguimientos SSE WHERE  SQS.xt_tipo = 'B' AND SSE.xt_tipoOrigen = 'B' 
							AND SQS.kp_quejaSolicitudID = SSE.kf_itemOrigenID AND SSE.kf_pdrID = SEM.kp_personalId AND SEM.kf_usuario = '$usuarioId' 
							ORDER BY  xd_fecha DESC ");
							
	while($r = $s->fetchRow($s)){
		
		$solicitudID 		= $r[0];
		$claveSolicitud 	= $r[1];
		$tituloSolicitud 	= $r[2];
		$fechaSolicitud 	= date('Y-m-d', strtotime($r[3]));
		
		if($r[4] != ""){
			
			$solicitanteUsr = $INTRANET->getOne("SELECT CONCAT(xt_Nombre, ' ', xt_ApellidoPaterno) FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
			
		} else{
			
			$solicitanteUsr = "";
			
		}
		
		$status 			= "";
		$pdr				= "";
		
		if($r[5] != ""){
			
			if(		  $r[5] == "ABIERTA"){
				
				$status = "Asignada";
				
			} else if($r[5] == "REVISION"){
				
				$status = "Para Revisión";
				
			} else if($r[5] == "RECHAZADA"){
				
				$status = "Rechazada";
				
			} else if($r[5] == "TERMINADA"){
				
				$status = "Terminada";
				
			}
			
			$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $r[0] AND xt_tipoOrigen = 'B' ");
			
			$fechaSolicitud = $INTRANET->getOne("SELECT xd_fecha FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $seguimientoID 
													 AND xn_numero = (
														SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus  WHERE kf_seguimientoID = $seguimientoID 
													 ) ");
			
			$pdr = $INTRANET->getOne("SELECT CONCAT(xt_nombre,' ' ,xt_ApellidoPaterno) FROM SGI_Empleados WHERE kp_personalId = $r[6] ");
		
			
		} else{
			
			$status	= "Sin asignar";
			$pdr	= "";
			
		}
		
		if($i == 1){
			
			imprimeSolEncabezado();
			
		}
		
		$i++;
		$bandera++;
		
		imprimeSolicitudes($solicitudID, $claveSolicitud, $tituloSolicitud, $fechaSolicitud, $status, $solicitanteUsr, $pdr);
		
	///FIN DEL WHILE INFO BASICA SOLICITUDES
	}
	
	return $bandera;
	
}


function adminSolicitudes(){
	
	global $ciudadElegida, $cdValor, $ciudades, $anio, $mes, $estSolElegida, $querySolicitudes, $solSinAsignar, $pdrFiltro, $queryPDR, $INTRANET;
	
	///SI CIUDAD ELEGIDA DIFERENTE QUE TODOS
	if($ciudadElegida != "ALL"){
		
		$i 					= 1;
		$solicitudID 		= NULL;
		$claveSolicitud 	= NULL;
		$tituloSolicitud 	= NULL;
		$fechaSolicitud 	= NULL;
		$solicitanteUsr		= NULL;
		$status 			= NULL;
		$pdr				= NULL;
		
		$query = "SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
			 	  FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_tipo = 'B' ";
		
		$query = $query." AND SQS.xt_ciudad = '$ciudadElegida' ";
		
		///SI MES ELEGIDO DIFERENTE DE TODOS
		if($mes != 13){
			
			$query = $query." AND YEAR(SQS.xd_fecha) = $anio AND MONTH(SQS.xd_fecha) = $mes ";
		
		///SI MES ELEGIDO IGUAL QUE TODOS
		} else{
			
			$query = $query." AND YEAR(SQS.xd_fecha) = $anio ";
			
		}
		
		///SI EL ESTATUS DE SOLICITUDES INCLUYE LA OPCION TODOS
		if(in_array("Todos", $estSolElegida)){
			
			//echo "1 ";
			
		///SI EL ESTATUS DE SOLICITUDES SOLO ES SIN ASIGNAR
		} else if((count($estSolElegida) == 1) && ($estSolElegida[0] == "Sin asignar")){
			
			//echo "2";
			
			$query = $query." AND SQS.xt_status IS NULL ";
		
		///SI EL ESTATUS DE SOLICITUDES NO CONTIENE TODOS	
		} else if(!in_array("Todos", $estSolElegida)){
			
			///SI STATUS ELEGIDO NO CONTIENE SIN ASIGNAR
			if($solSinAsignar == 0){
				
				//echo "3";
								 
				$query = $query." AND SQS.xt_status IN ($querySolicitudes) ";
			
			///SI STATUS ELEGIDO CONTIENE SIN ASIGNAR	
			} else{
				
				//echo "4";
				
				$query = $query." AND (SQS.xt_status IN ($querySolicitudes) OR SQS.xt_status IS NULL) ";
			
			}
			
		}
		
		if($queryPDR != "Todos"){
			
			$query = $query." AND SQS.kf_pdrId IN ($queryPDR) ";
			
		}
		
		//echo "<br><br>ID|CLAVE|TITULO|FECHA|SOLICITANTE|STATUS<br>";
		
		$query = $query." ORDER BY xt_claveQuejaSolicitud DESC ";
		
		//echo "<br />".$query;
		
		///INICIO DEL WHILE PARA OBTENER LA INFORMACION BASICA DE SOLICITUDES
		$s = $INTRANET->Execute($query);
			
		while($r = $s->fetchRow()){
			
			$solicitudID		= $r[0];
			$claveSolicitud		= $r[1];
			$tituloSolicitud	= $r[2];
			$fechaSolicitud 	= date('Y-m-d', strtotime($r[3]));
			
			if($r[4] != ""){
				
				$solicitanteUsr = $INTRANET->getOne("SELECT CONCAT(xt_Nombre, ' ', xt_ApellidoPaterno) FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
				
			} else{
				
				$solicitanteUsr = "";
				
			}
			
			if($r[5] != ""){
				
				if(		  $r[5] == "ABIERTA"){
					
					$status = "Asignada";
					
				} else if($r[5] == "REVISION"){
					
					$status = "Para Revisión";
					
				} else if($r[5] == "RECHAZADA"){
					
					$status = "Rechazada";
					
				} else if($r[5] == "TERMINADA"){
					
					$status = "Terminada";
					
				}
				
				$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $r[0] AND xt_tipoOrigen = 'B' ");
				
				$fechaSolicitud = $INTRANET->getOne("SELECT xd_fecha FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $seguimientoID 
														 AND xn_numero = (
															SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus  WHERE kf_seguimientoID = $seguimientoID 
														 ) ");
				
				$pdr = $INTRANET->getOne("SELECT CONCAT(xt_nombre,' ' ,xt_ApellidoPaterno) FROM SGI_Empleados WHERE kp_personalId = $r[6] ");
			
				
			} else{
				
				$status	= "Sin asignar";
				$pdr 	= "";
				
			}
			
			if($i == 1){
					
				imprimeSolEncabezado();
				
			}
			
			imprimeSolicitudes($solicitudID, $claveSolicitud, $tituloSolicitud, $fechaSolicitud, $status, $solicitanteUsr, $pdr);
			
			$i++;
			
		///FIN DEL WHILE PARA OBTENER LA INFORMACION BASICA DE SOLICITUDES	
		}
		
		$bandera = $i-1;
		//echo "<br>".$bandera."<br>";
		return $bandera;
		
	///FIN SI CIUDAD ELEGIDA DIFERENTE QUE TODOS
	
	///SI CIUDAD ELEGIDA IGUAL QUE TODOS
	} else{
		
		$bandera = 0;
		
		for($allCiudades = 1; $allCiudades <= 6; $allCiudades++){
			
			$i 					= 1;
			$solicitudID 		= NULL;
			$claveSolicitud 	= NULL;
			$tituloSolicitud 	= NULL;
			$fechaSolicitud 	= NULL;
			$solicitanteUsr		= NULL;
			$status 			= NULL;
			$pdr				= NULL;
			
			$query = "SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
					  FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_tipo = 'B' ";
		
			$query = $query." AND SQS.xt_ciudad = '$cdValor[$allCiudades]' ";
			
			///SI MES ELEGIDO DIFERENTE DE TODOS
			if($mes != 13){
				
				$query = $query." AND YEAR(SQS.xd_fecha) = $anio AND MONTH(SQS.xd_fecha) = $mes ";
			
			///SI MES ELEGIDO IGUAL QUE TODOS
			} else{
				
				$query = $query." AND YEAR(SQS.xd_fecha) = $anio ";
				
			}
			
			///SI EL ESTATUS DE SOLICITUDES INCLUYE LA OPCION TODOS
			if(in_array("Todos", $estSolElegida)){
				
				//echo "1 ";
				
			///SI EL ESTATUS DE SOLICITUDES SOLO ES SIN ASIGNAR
			} else if((count($estSolElegida) == 1) && ($estSolElegida[0] == "Sin asignar")){
				
				//echo "2";
				
				$query = $query." AND SQS.xt_status IS NULL ";
			
			///SI EL ESTATUS DE SOLICITUDES NO CONTIENE TODOS	
			} else if(!in_array("Todos", $estSolElegida)){
				
				///SI STATUS ELEGIDO NO CONTIENE SIN ASIGNAR
				if($solSinAsignar == 0){
					
					//echo "3";
									 
					$query = $query." AND SQS.xt_status IN ($querySolicitudes) ";
				
				///SI STATUS ELEGIDO CONTIENE SIN ASIGNAR	
				} else{
					
					//echo "4";
					
					$query = $query." AND (SQS.xt_status IN ($querySolicitudes) OR SQS.xt_status IS NULL) ";
				
				}
				
			}
			
			if($queryPDR != "Todos"){
				
				$query = $query." AND SQS.kf_pdrId IN ($queryPDR) ";
				
			}
			
			//echo "<br><br>ID|CLAVE|TITULO|FECHA|SOLICITANTE|STATUS<br>";
			
			$query = $query." ORDER BY xt_claveQuejaSolicitud DESC ";
			
			//echo "<br />".$query;
			
			///INICIO DEL WHILE PARA OBTENER LA INFORMACION BASICA DE SOLICITUDES
			$s = $INTRANET->Execute($query);
				
			while($r = $s->fetchRow()){
				
				$solicitudID		= $r[0];
				$claveSolicitud		= $r[1];
				$tituloSolicitud	= $r[2];
				$fechaSolicitud 	= date('Y-m-d', strtotime($r[3]));
				
				if($r[4] != ""){
					
					$solicitanteUsr = $INTRANET->getOne("SELECT CONCAT(xt_Nombre, ' ', xt_ApellidoPaterno) FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
					
				} else{
					
					$solicitanteUsr = "";
					
				}
				
				if($r[5] != ""){
					
					if(		  $r[5] == "ABIERTA"){
						
						$status = "Asignada";
						
					} else if($r[5] == "REVISION"){
						
						$status = "Para Revisión";
						
					} else if($r[5] == "RECHAZADA"){
						
						$status = "Rechazada";
						
					} else if($r[5] == "TERMINADA"){
						
						$status = "Terminada";
						
					}
					
					$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $r[0] AND xt_tipoOrigen = 'B' ");
					
					$fechaSolicitud = $INTRANET->getOne("SELECT xd_fecha FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $seguimientoID 
															 AND xn_numero = (
																SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus  WHERE kf_seguimientoID = $seguimientoID 
															 ) ");
					
					$pdr = $INTRANET->getOne("SELECT CONCAT(xt_nombre,' ' ,xt_ApellidoPaterno) FROM SGI_Empleados WHERE kp_personalId = $r[6] ");
				
					
				} else{
					
					$status	= "Sin asignar";
					$pdr	= "";
					
				}
				
				if($i == 1){
					
					?>
                    <table border='0' align='center' width='1200px'>
                        <tr height='30px'><td></td></tr>
                        
                        <tr>
                            <td id='titulo2Blanco' align='left' width='1080px'><?php echo $ciudades[$allCiudades]; ?></td>
                        </tr>
                    </table>
                    <?php
					
					imprimeSolEncabezado();
					
				}
				
				imprimeSolicitudes($solicitudID, $claveSolicitud, $tituloSolicitud, $fechaSolicitud, $status, $solicitanteUsr, $pdr);
				
				$i++;
				
				$bandera++;
			///FIN DEL WHILE PARA OBTENER LA INFORMACION BASICA DE SOLICITUDES	
			}
			
			
		}
		
		return $bandera;
		
	///FIN SI CIUDAD ELEGIDA IGUAL QUE TODOS	
	}
	
}


function noQuejas(){
	
	?>
    <table border="0" align="center">
        <tr height="10px"><td></td></tr>
    </table>
    
    <table border="0" align="center"  width="1200px">
        <tr id="titulo2">
            <td width="30px"></td>
            <td width="150px" align="center">Código</td>
            <td width="350px" align="left">Título</td>
            <td width="10px"></td>
            <td width="100px" align="center">Fecha</td>
            <td width="10px"></td>
            <td width="120px" align="left">Status</td>
            <td width="200px" align="left">Solicitante</td>
            <td width="10px"></td>
            <td width="200px" align="left">PDR</td>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="9" id="titleBlueLineTop"></td>
        </tr>
        
        <tr height="20px"><td colspan="10"></td></tr>
        
        <tr>
			<td align="center" id="titulo12" colspan="10"><i>No hay Quejas que mostrar.</i></td>
        </tr>
        
        <tr height="20px"><td colspan="10"></td></tr>
    </table>
	<?php
	
}

function imprimeQueEncabezado(){
	
	?>
    <table border="0" align="center">
        <tr height="10px"><td></td></tr>
    </table>
    
    <table border="0" align="center"  width="1200px">
        <tr id="titulo2">
            <td width="30px"></td>
            <td width="150px" align="center">Código</td>
            <td width="350px" align="left">Título</td>
            <td width="10px"></td>
            <td width="100px" align="center">Fecha</td>
            <td width="10px"></td>
            <td width="120px" align="left">Status</td>
            <td width="200px" align="left">Solicitante</td>
            <td width="10px"></td>
            <td width="200px" align="left">PDR</td>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="9" id="titleBlueLineTop"></td>
        </tr>
        
        <tr height="10px"><td colspan="10"></td></tr>
    </table>
    <?php
	
}

function imprimeQuejas($quejaID, $claveQueja, $tituloQueja, $fechaQueja, $status, $quejosoUsr, $pdr){
	
	?>
	<table border="0" align="center"  width="1200px">
		<tr height="25px" id="fileItem">
			<td width="30px"></td>
			
			<td width="150px" align="center" valign="top">
				<a href="fichaQueja.php?id=<?php echo $quejaID; ?>" id="fileItem" style="text-decoration:none;"><?php echo $claveQueja; ?></a>
			</td>
			
			<td width="350px" align="left" valign="top"><?php echo $tituloQueja; ?></td>
			
			<td width="10px"></td>
			
			<td width="100px" align="center" valign="top"><?php echo $fechaQueja; ?></td>
			
			<td width="10px"></td>
			
			<td width="120px" align="left" valign="top"><?php echo $status; ?></td>
			
			<td width="200px" align="left" valign="top"><?php echo $quejosoUsr; ?></td>
			
			<td width="10px"></td>
			
			<td width="200px" align="left" valign="top"><?php echo $pdr; ?></td>
		</tr>
	</table>
	<?php
	
}


function inhouseQuejas(){
	
	global $cdValor, $ciudadesDisponibles, $usuarioId, $INTRANET, $statusQueja;
	
	$bandera 		= 0;
	$i 				= 1;
	$quejaID 		= NULL;
	$claveQueja 	= NULL;
	$tituloQueja 	= NULL;
	$fechaQueja 	= NULL;
	$quejosoUsr		= NULL;
	$status 		= NULL;
	$pdr			= NULL;
	
	///OBTENER TODA LA INFORMACION QUE SE VA A DESPLEGAR SI EL USR ES SOLICITANTE O SI ES EL PDR
	$s = $INTRANET->Execute("SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
							FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM WHERE SQS.xt_tipo = 'C' AND SQS.kf_usuarioId = '$usuarioId' 
							AND SQS.kf_usuarioId = SEM.kf_usuario 
							
							UNION 
							
							SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
							FROM SGI_Quejas_Solicitudes SQS, SGI_Empleados SEM, SGI_Seguimientos SSE WHERE SQS.xt_tipo = 'Q' AND SSE.xt_tipoOrigen = 'C' 
							AND SQS.kp_quejaSolicitudID = SSE.kf_itemOrigenID AND SSE.kf_pdrID = SEM.kp_personalId AND SEM.kf_usuario = '$usuarioId' 
							ORDER BY xt_claveQuejaSolicitud DESC  ");
							
	while($r = $s->fetchRow($s)){
		
		$quejaID 		= $r[0];
		$claveQueja 	= $r[1];
		$tituloQueja 	= $r[2];
		$fechaQueja 	= date('Y-m-d', strtotime($r[3]));
		
		if($r[4] != ""){
			
			$quejosoUsr = $INTRANET->getOne("SELECT CONCAT(xt_Nombre, ' ', xt_ApellidoPaterno) FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
			
		} else{
			
			$quejosoUsr = "";
			
		}
		
		$status 			= "";
		$pdr				= "";
		
		if($r[5] != ""){
			
			$status = $r[5];
			
			$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $r[0] AND xt_tipoOrigen = 'C' ");
					
			$fechaSolicitud = $INTRANET->getOne("SELECT xd_fecha FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID
												 AND xn_etapa = $status ");
			
			$pdr = $INTRANET->getOne("SELECT CONCAT(xt_nombre,' ' ,xt_ApellidoPaterno) FROM SGI_Empleados WHERE kp_personalId = $r[6] ");
			
			$status = $statusQueja[$r[5]];
			
		///FIN DEL IF ETAPAS QUEJAS	
		} else{
			
			$status = "Sin asignar";
			$pdr	= "";
			
		}
		
		if($i == 1){
			
			imprimeQueEncabezado();
			
		}
		
		imprimeQuejas($quejaID, $claveQueja, $tituloQueja, $fechaQueja, $status, $quejosoUsr, $pdr);
		
		$i++;
		$bandera++;
		
		
	///FIN DEL WHILE INFORMACION BASICA QUEJAS
	}
	
	return $bandera;
	
}

function adminQuejas(){
	
	global $ciudadElegida, $cdValor, $ciudades, $anio, $mes, $estQueElegida, $queryQuejas, $queSinAsignar, $pdrFiltro, $queryPDR, $INTRANET, $statusQueja;
	
	///SI CIUDAD ELEGIDA DIFERENTE QUE TODOS
	if($ciudadElegida != "ALL"){
		
		$i 				= 1;
		$quejaID 		= NULL;
		$claveQueja 	= NULL;
		$tituloQueja 	= NULL;
		$fechaQueja 	= NULL;
		$quejosoUsr		= NULL;
		$status 		= NULL;
		$pdr			= NULL;
		
		$query = "SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
			 	  FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_tipo = 'C' ";
		
		$query = $query." AND SQS.xt_ciudad = '$ciudadElegida' ";
		
		///SI MES ELEGIDO DIFERENTE DE TODOS
		if($mes != 13){
			
			$query = $query." AND YEAR(SQS.xd_fecha) = $anio AND MONTH(SQS.xd_fecha) = $mes ";
		
		///SI MES ELEGIDO IGUAL QUE TODOS
		} else{
			
			$query = $query." AND YEAR(SQS.xd_fecha) = $anio ";
			
		}
		
		///SI EL ESTATUS DE QUEJAS INCLUYE LA OPCION TODOS
		if(in_array("Todos", $estQueElegida)){
			
			//echo "1 ";
			
		///SI EL ESTATUS DE QUEJAS SOLO ES SIN ASIGNAR
		} else if((count($estQueElegida) == 1) && ($estQueElegida[0] == "Sin asignar")){
			
			//echo "2";
			
			$query = $query." AND SQS.xt_status IS NULL ";
		
		///SI EL ESTATUS DE QUEJAS NO CONTIENE TODOS	
		} else if(!in_array("Todos", $estQueElegida)){
			
			///SI STATUS ELEGIDO NO CONTIENE SIN ASIGNAR
			if($queSinAsignar == 0){
				
				//echo "3";
								 
				$query = $query." AND SQS.xt_status IN ($queryQuejas) ";
			
			///SI STATUS ELEGIDO CONTIENE SIN ASIGNAR	
			} else{
				
				//echo "4";
				
				$query = $query." AND (SQS.xt_status IN ($queryQuejas) OR SQS.xt_status IS NULL) ";
			
			}
			
		}
		
		if($queryPDR != "Todos"){
			
			$query = $query." AND SQS.kf_pdrId IN ($queryPDR) ";
			
		}
		
		//echo "<br><br>ID|CLAVE|TITULO|FECHA|SOLICITANTE|STATUS<br>";
		
		$query = $query." ORDER BY xt_claveQuejaSolicitud DESC ";
		
		//echo "<br />".$query;
		
		///INICIO DEL WHILE PARA OBTENER LA INFORMACION BASICA DE QUEJAS
		$s = $INTRANET->Execute($query);
			
		while($r = $s->fetchRow()){
			
			$quejaID		= $r[0];
			$claveQueja		= $r[1];
			$tituloQueja	= $r[2];
			$fechaQueja 	= date('Y-m-d', strtotime($r[3]));
			
			if($r[4] != ""){
				
				$quejosoUsr = $INTRANET->getOne("SELECT CONCAT(xt_Nombre, ' ', xt_ApellidoPaterno) FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
				
			} else{
				
				$quejosoUsr = "";
				
			}
			
			if($r[5] != ""){
				
				$status = $statusQueja[$r[5]];
				
				$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $r[0] AND xt_tipoOrigen = 'C' ");
				
				$fechaQueja = $INTRANET->getOne("SELECT xd_fecha FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $seguimientoID 
												  AND xn_numero = (
												  		SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus  WHERE kf_seguimientoID = $seguimientoID 
												  ) ");
				
				$pdr = $INTRANET->getOne("SELECT CONCAT(xt_nombre,' ' ,xt_ApellidoPaterno) FROM SGI_Empleados WHERE kp_personalId = $r[6] ");
			
				
			} else{
				
				$status	= "Sin asignar";
				$pdr 	= "";
				
			}
			
			if($i == 1){
					
				imprimeQueEncabezado();
				
			}
			
			imprimeQuejas($quejaID, $claveQueja, $tituloQueja, $fechaQueja, $status, $quejosoUsr, $pdr);
			
			$i++;
			
		///FIN DEL WHILE PARA OBTENER LA INFORMACION BASICA DE QUEJAS	
		}
		
		$bandera = $i-1;
		//echo "<br>".$bandera."<br>";
		return $bandera;
		
	///FIN SI CIUDAD ELEGIDA DIFERENTE QUE TODOS
	
	///SI CIUDAD ELEGIDA IGUAL QUE TODOS
	} else{
		
		$bandera = 0;
		
		for($allCiudades = 1; $allCiudades <= 6; $allCiudades++){
			
			$i 					= 1;
			$quejaID 		= NULL;
			$claveQueja 	= NULL;
			$tituloQueja 	= NULL;
			$fechaQueja 	= NULL;
			$quejosoUsr		= NULL;
			$status 		= NULL;
			$pdr			= NULL;
			
			$query = "SELECT SQS.kp_quejaSolicitudID, SQS.xt_claveQuejaSolicitud, SQS.xt_titulo, SQS.xd_fecha, SQS.kf_usuarioId, SQS.xt_status, SQS.kf_pdrId 
					  FROM SGI_Quejas_Solicitudes SQS WHERE SQS.xt_tipo = 'C' ";
		
			$query = $query." AND SQS.xt_ciudad = '$cdValor[$allCiudades]' ";
			
			///SI MES ELEGIDO DIFERENTE DE TODOS
			if($mes != 13){
				
				$query = $query." AND YEAR(SQS.xd_fecha) = $anio AND MONTH(SQS.xd_fecha) = $mes ";
			
			///SI MES ELEGIDO IGUAL QUE TODOS
			} else{
				
				$query = $query." AND YEAR(SQS.xd_fecha) = $anio ";
				
			}
			
			///SI EL ESTATUS DE QUEJAS INCLUYE LA OPCION TODOS
			if(in_array("Todos", $estQueElegida)){
				
				//echo "1 ";
				
			///SI EL ESTATUS DE QUEJAS SOLO ES SIN ASIGNAR
			} else if((count($estQueElegida) == 1) && ($estQueElegida[0] == "Sin asignar")){
				
				//echo "2";
				
				$query = $query." AND SQS.xt_status IS NULL ";
			
			///SI EL ESTATUS DE QUEJAS NO CONTIENE TODOS	
			} else if(!in_array("Todos", $estQueElegida)){
				
				///SI STATUS ELEGIDO NO CONTIENE SIN ASIGNAR
				if($queSinAsignar == 0){
					
					//echo "3";
									 
					$query = $query." AND SQS.xt_status IN ($queryQuejas) ";
				
				///SI STATUS ELEGIDO CONTIENE SIN ASIGNAR	
				} else{
					
					//echo "4";
					
					$query = $query." AND (SQS.xt_status IN ($queryQuejas) OR SQS.xt_status IS NULL) ";
				
				}
				
			}
			
			if($queryPDR != "Todos"){
				
				$query = $query." AND SQS.kf_pdrId IN ($queryPDR) ";
				
			}
			
			//echo "<br><br>ID|CLAVE|TITULO|FECHA|SOLICITANTE|STATUS<br>";
			
			$query = $query." ORDER BY xt_claveQuejaSolicitud DESC ";
			
			//echo "<br />".$query;
			
			///INICIO DEL WHILE PARA OBTENER LA INFORMACION BASICA DE SOLICITUDES
			$s = $INTRANET->Execute($query);
				
			while($r = $s->fetchRow()){
				
				$quejaID		= $r[0];
				$claveQueja		= $r[1];
				$tituloQueja	= $r[2];
				$fechaQueja 	= date('Y-m-d', strtotime($r[3]));
				
				if($r[4] != ""){
					
					$quejosoUsr = $INTRANET->getOne("SELECT CONCAT(xt_Nombre, ' ', xt_ApellidoPaterno) FROM SGI_Empleados WHERE kf_usuario = '$r[4]' ");
					
				} else{
					
					$quejosoUsr = "";
					
				}
				
				if($r[5] != ""){
					
					$status = $statusQueja[$r[5]];
					
					$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $r[0] AND xt_tipoOrigen = 'C' ");
					
					$fechaQueja = $INTRANET->getOne("SELECT xd_fecha FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $seguimientoID 
													 AND xn_numero = (
															SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus  WHERE kf_seguimientoID = $seguimientoID 
													 ) ");
					
					$pdr = $INTRANET->getOne("SELECT CONCAT(xt_nombre,' ' ,xt_ApellidoPaterno) FROM SGI_Empleados WHERE kp_personalId = $r[6] ");
				
					
				} else{
					
					$status	= "Sin asignar";
					$pdr	= "";
					
				}
				
				if($i == 1){
					
					?>
                    <table border='0' align='center' width='1200px'>
                        <tr height='30px'><td></td></tr>
                        
                        <tr>
                            <td id='titulo2Blanco' align='left' width='1080px'><?php echo $ciudades[$allCiudades]; ?></td>
                        </tr>
                    </table>
                    <?php
					
					imprimeQueEncabezado();
					
				}
				
				imprimeQuejas($quejaID, $claveQueja, $tituloQueja, $fechaQueja, $status, $quejosoUsr, $pdr);
				
				$i++;
				
				$bandera++;
			///FIN DEL WHILE PARA OBTENER LA INFORMACION BASICA DE SOLICITUDES	
			}
			
			
		}
		
		return $bandera;
		
	///FIN SI CIUDAD ELEGIDA IGUAL QUE TODOS	
	}
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Tablero de Solicitudes y Quejas</title>
        
        <?php
        if($estiloUsuario == 1){
			
            ?>
            <link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>
            <?php
			
        }else if($estiloUsuario == 2){
            ?>
            <link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>
            <?php
        }
        ?>
        
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
        
        <script>
            function show(valor){
                if(valor == 1){
                    document.getElementById("mostrar").style.display="block";
                    document.getElementById("ocultar").style.display="none";
                } else if (valor == 0){
                    document.getElementById("mostrar").style.display="none";
                    document.getElementById("ocultar").style.display="block";
                }
            }
        </script>
    </head>
        
    <body>
        <div id="wrapperSolicitudes" align="center">
			<table border="0" align="center" width="800px">
                <tr>
                    <td align="left" id="breadcrumbs">Usuario: <?php echo $usuarioId; ?></td>
                </tr>
                
                <tr height="80px"><td></td></tr>
                
                <tr>
                    <td align="center" id="titulo1">Solicitudes y Quejas</td>
                </tr>
                
                <tr>
                    <td align="center" valign="top" height="20px">
                        <table border="0" align="center">
                            <tr height="20px">
                                <td valign="middle">
                                    <img src="../Imagenes/ICN_PointMeTo.png" id="banana1" style="display:none;" onClick="showBanana(0);">
                                    <img src="../Imagenes/ICN_PointMeTo.png" id="banana0" style="display:inline-block;" onClick="showBanana(1);">
                                </td>
                                
                                <td valign="middle">
                                    <font style="display:inline-block;"><?php echo $breadcrumb; ?></font>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr height="70"><td></td></tr>
                
                <tr>
                    <td align="center">
                        <a href="altaSolicitudQuejaPopUp.php">
                            <img src="../Imagenes/ICN_BotonAgregar.png" width="90" height="29">
                        </a>
                    </td>
                </tr>
                
                <tr height="30"><td></td></tr>
			</table>
             
			<table border="0" align="center" id="mapaIntranet" style="display:none;">
				<tr>
                    <td align="center">
                        <table border="0" align="center" id="breadcrumbs" style="border:1px solid #007cbd;">
                            <tr>
                                <td valign="top">
                                    <a href="../ComunicacionInterna/comunicacionInterna.php" id="breadcrumbs">
                                        Comunicación Interna
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../ComunicacionInterna/TableroBoletines.php" id="breadcrumbs">
                                                Boletines
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../ComunicacionInterna/listaQueHacer.php" id="breadcrumbs">
                                                Qué hacer
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../ComunicacionInterna/tableroSolicitudesyQuejas.php" id="breadcrumbs">
                                                Solicitudes y Quejas
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../ComunicacionInterna/busquedaPersonal.php" id="breadcrumbs">
                                                Acceso Autorizado
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../SistemaGestionIntegral/homeSGI.php" id="breadcrumbs">
                                        Gestión Integral
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../SistemaGestionIntegral/Normas.php" id="breadcrumbs">
                                                Normas
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../SistemaGestionIntegral/CapituloNorma.php?norma=ISO" id="breadcrumbs">
                                                        ISO
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/CapituloNorma.php?norma=NMX" id="breadcrumbs">
                                                        NMX
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC" id="breadcrumbs">
                                                        NEEC
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li>
                                            <a href="../SistemaGestionIntegral/manuales.php" id="breadcrumbs">
                                                Manuales
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-MC" id="breadcrumbs">
                                                        Manual de Gestión Integral
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-CDR" id="breadcrumbs">
                                                        Manual de Control de Documentos y Registros
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-AI" id="breadcrumbs">
                                                        Manual de Auditorías Internas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-CC" id="breadcrumbs">
                                                        Manual del Comité de Calidad
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-DG" id="breadcrumbs">
                                                        Manual de Dirección General
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-ADM" id="breadcrumbs">
                                                        Manual de Administración
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-RH" id="breadcrumbs">
                                                        Manual de Recursos Humanos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-TI" id="breadcrumbs">
                                                        Manual de Tecnologias de la Información
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Documento.php?manual=GE-OPE" id="breadcrumbs">
                                                        Manual de Operaciones
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li>
                                            <a href="../SistemaGestionIntegral/Modulos.php" id="breadcrumbs">
                                                Módulos del SGI
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Riesgos.php" id="breadcrumbs">
                                                        Administración de Riesgos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/ReunionesyAcuerdos.php" id="breadcrumbs">
                                                        Reuniones y Acuerdos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/tableroPreventivasCorrectivas.php" id="breadcrumbs">
                                                        Acciones Preventivas y Correctivas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../SistemaGestionIntegral/tableroAuditorias.php" id="breadcrumbs">
                                                        Auditorías
                                                    </a>
                                                </li>
                                               
                                                <li>
                                                    <a href="../SistemaGestionIntegral/Procesos.php" id="breadcrumbs">
                                                        Inventario de Procesos
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../Aplicaciones/aplicaciones.php" id="breadcrumbs">
                                        Aplicaciones
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../Aplicaciones/operaciones.php" id="breadcrumbs">
                                                Operaciones
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../AdministracionProyectos/admonPro.php" id="breadcrumbs">
                                                Administración de Proyectos
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../Registros/Registros.php" id="breadcrumbs">
                                        Registros
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../Registros/TableroVisitas2.php" id="breadcrumbs">
                                                Visitas
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../Registros/tableroRegistros.php" id="breadcrumbs">
                                                Registros
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../Configuraciones/configuraciones.php" id="breadcrumbs">
                                        Configuraciones
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../Configuraciones/ModificaPassword.php" id="breadcrumbs">
                                                Contraseñas
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
			</table>
             
			<table border="0" align="center">
				<tr height="20"><td></td></tr>
			</table>
            
			<?php
			
			if($categoriaUsr == "Administrador"){
				
			?>
				<form method="post" action="tableroSolicitudesyQuejas.php">
                	<!--TABLA QUE OCULTA LAS OPCIONES DE LOS FILTROS, SE ACTIVA CON EL ONCLICK-->
                	<table border="0" align="center" width="900px" id="ocultar" style="display:block;">
                    	<tr>
                        	<td align="left" id="iconosTexto2" onClick="show(1);" width="900px">Filtrar</td>
                        </tr>
                        
                        <tr height="30px"><td colspan="6"></td></tr>
                    </table>
                    
                    <!--TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK-->
                    <table border="0" align="center" width="900px" id="mostrar" style="display:none;">
                    	<tr>
                        	<td colspan="6" align="left" id="iconosTexto2" onClick="show(0);">Filtrar</td>
                        </tr>
                        
                        <tr height="10px"><td colspan="6"></td></tr>
                        
                        <tr id="fileItem">
                        	<td align="center" width="150px">Ciudad</td>
                            <td align="center" width="90px">Año</td>
                            <td align="center" width="130px">Mes</td>
                            <td align="center" width="150px">Solicitud</td>
                            <td align="center" width="180px">Quejas</td>
                            <td align="center" width="200px" >PDR</td>
                        </tr>
                        
                        <tr height="10px"><td colspan="6"></td></tr>
                        
                        <tr>
                        	<td align="center" valign="top">
                            	<select name="ciudad">
                                	<?php
									///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
									for($a = 1; $a <= 6; $a++){
										
										if(in_array($cdValor[$a], $ciudadesDisponibles)){
									
											if($cdValor[$a] != $ciudadElegida){
												
												?>
                                                <option value="<?php echo $cdValor[$a]; ?>"><?php echo $ciudades[$a]; ?></option>
                                                <?php
												
											} else{
												
												?>
                                                <option value="<?php echo $cdValor[$a]; ?>" selected="selected"><?php echo $ciudades[$a]; ?></option>
                                                <?php
												
											}
											
										}
										
									} unset($a);
									
									if($ciudadElegida == "ALL"){
										
										?>
										<option value="<?php echo $cdValor[7]; ?>" selected="selected"><?php echo $ciudades[7]; ?></option>
                                        <?php 
										
									} else{
										
										?>
                                        <option value="<?php echo $cdValor[7]; ?>"><?php echo $ciudades[7]; ?></option>
                                        <?php
										
									}
									?>
                                </select>
                            </td>
                            
                            <td align="center" valign="top">
                            	<select name="anio">
                                	<?php
									///Muestra solo 5 años, del actual y los cuatro anteriores consecutivos
									for($o = $currentYear; $o >= ($currentYear-4); $o--){
										
										if($anio != $o){
											
											?>
                                            <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                                            <?php
											
										} else{
											
											?>
                                            <option value="<?php echo $o; ?>" selected="selected"><?php echo $o; ?></option>
                                            <?php
											
										}
										
									} unset($o);
									?>
                                </select>
                            </td>
                            
                            <td align="center" valign="top">
                            	<select name="mes">
                                	<?php
									///Muestra los meses consecutivamente
									for($o = 1; $o <= 13; $o++){
										
										if($mes != $o){
											
											?>
											<option value="<?php echo $o; ?>"><?php echo $mesNombre[$o]; ?></option>
                                            <?php
											
										} else{
											
											?>
                                            <option value="<?php echo $o; ?>" selected="selected"><?php echo $mesNombre[$o]; ?></option>
                                            <?php
											
										}
										
									} unset($o);
									?>
                                </select>
                            </td>
                            
                            <td align="center" valign="top">
                            	<select name="estSol[]" multiple="multiple">
                                	<?php
									///OPCIONES PARA SOLICITUDES
									for($a = 1; $a <= 6; $a++){
								
										if(in_array($estatusSol[$a], $estSolElegida)){
											
											?>
											<option value="<?php echo $estatusSol[$a]; ?>" selected="selected"><?php echo $estatusSol[$a]; ?></option>
											<?php
											
										} else{
											
											?>
                                            <option value="<?php echo $estatusSol[$a]; ?>"><?php echo $estatusSol[$a]; ?></option>
                                            <?php
											
										}
										
									} unset($a);
									?>
                                </select>
                            </td>
                            
                            <td align="center" valign="top">
                            	<select name="estQue[]" multiple="multiple">
                            	<?php
                                ///OPCIONES PARA QUEJAS
								for($a = 0; $a <= 7; $a++){
								
									if(in_array($estatusQue[$a], $estQueElegida)){
										
										?>
                                        <option value="<?php echo $estatusQue[$a]; ?>" selected="selected"><?php echo $estatusQue[$a]; ?></option>
                                        <?php
										
									} else{
										
										?>
                                        <option value="<?php echo $estatusQue[$a]; ?>"><?php echo $estatusQue[$a]; ?></option>
                                        <?php
										
									}
									
								} unset($a);
								?>
                            	</select>
                            </td>
                            
                            <td align="center" valign="top">
                            	<select name="pdr[]" multiple="multiple">
                                	<?php
									$s = $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno 
															 FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP 
															 WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad = 'PDR' 
															 ORDER BY EMP.xt_Nombre, EMP.xt_ApellidoPaterno ");
								
									while($r = $s ->fetchRow()){
										
										if(in_array($r[0], $pdrFiltro)){
											
											?>
                                            <option value="<?php echo $r[0]; ?>" selected="selected"><?php echo $r[1]." ".$r[2]; ?></option>
                                            <?php
											
										} else{
											
											?>
                                            <option value="<?php echo $r[0]; ?>"><?php echo $r[1]." ".$r[2]; ?></option>
                                            <?php
											
										}
										
									} unset($r); unset ($s);
									
									if(in_array("Todos", $pdrFiltro)){
										
										?>
                                        <option value="Todos" selected="selected">Todos</option>
                                        <?php
										
									} else{
										
										?>
                                        <option value="Todos">Todos</option>
                                        <?php
										
									}
									?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr height="20px"><td colspan="6"></td></tr>
                        
                        <tr>
                        	<td align="center" colspan="6">
                            	<input type="image" onClick="SubmitForm(this.form);" src="../Imagenes/ICN_BotonEnviar.png" width="90" height="25" />
                            </td>
                        </tr>
                        
                        <tr height="30px"><td colspan="6"></td></tr>
                    </table>
				</form>
            <?php
			}
			?>
            
			<table border="0" align="center">
                <tr>
                    <td align="center" id="titulo2">Solicitudes</td>
                </tr>
            </table>
                
			<?php
                if($categoriaUsr == "Inhouse"){
                    
                    $bandera = inhouseSolicitudes();
                    
                    if($bandera == 0){
                        
                        noSolicitudes();
                        
                    }
                    
                } else if($categoriaUsr == "Administrador"){
					
					$bandera = adminSolicitudes();
					
					if($bandera == 0){
						
						noSolicitudes();
						
					}
					
				}
            ?>
            
            <table border="0" align="center">
                <tr height="70px"><td></td></tr>
                
                <tr>
                    <td align="center" id="titulo2">Quejas</td>
                </tr>
            </table>
            
            <?php
                if($categoriaUsr == "Inhouse"){
					
                    $bandera = inhouseQuejas();
                    
                    if($bandera == 0){
                        
                        noQuejas();
                        
                    }
					
                } else if($categoriaUsr == "Administrador"){
					
					$bandera = adminQuejas();
                    
                    if($bandera == 0){
                        
                        noQuejas();
                        
                    }
					
				}
            ?>
			
            <table border="0" align="center">
                <tr height="50px"><td></td></tr>
            </table>
        </div>
	</body>
</html>
<?php

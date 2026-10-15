<?php error_reporting(0); ?>
﻿<?php
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once('../../../compruebaUsuario.php');
require_once('MailSolicitudAsignar.php');

$gerenteSistemas = 'Gerente_Sistemas';
error_reporting(E_PARSE);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	if($estiloUsuario == 1){
		echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
		echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>";
	}
?>
<link rel="shortcut icon" type="image/x-icon" href="../../../Imagenes/ICN_PestanaWebGE.png">
<title></title>
</head>
<body>
<?php

$CodigoE = $_GET['codigoE'];
$solicitudId = $_GET['codigoS'];

$tipoS = $INTRANETV2->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudId'");

if ($tipoS == 'PY') {	
	echo "<div id='wrapperPopUp'>";
	echo "<form name='nuevaActividad' method='post' action='backlogAsignaPdrPopUp.php?codigoE=$CodigoE&codigoS=$solicitudId'>";
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
				echo "<font>Asignar PDR</font>";
				echo"</td>";
			echo"</tr>";
		
			echo"<tr></tr>";	
		
			echo"<tr height='25px'> </tr>";
		echo "</table>";
		
		
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td>PDR</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		
			echo"<tr height='10'></tr>";

			echo "<tr>";
				echo "<td style='padding:0px 15px 0px 30px'>";
					echo "<select style='width: 250px;' name='pdr'>";
						echo "<option value=''>Elegir...</option>";
							$s= $INTRANET->Execute("SELECT xt_nombre, xt_usuario FROM BACKLOG.PROGRAMADORES WHERE XT_ESTATUS = 'ACTIVO' ORDER BY XT_NOMBRE");
							while($r= $s -> fetchRow()){
								echo"<option value='".$r[1]."'>".$r[0]."</option>";
							} unset($r); unset ($s);
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr>";
				echo "<td>Stakeholder</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			echo"<tr height='10'></tr>";
			echo "<tr id='stakeholder2'>";
			
				echo "<td style='padding:0px 15px 0px 30px'>";
					echo "<input type='text' name='stakeholder' style='width:35%;height:15px;' value='$gerenteSistemas' readonly>";
					echo "<input type='hidden' name='tipoS' value='$tipoS'>";
				echo "</td>";
			echo "</tr>";
			echo"<tr height='10'></tr>";
			echo "<tr>";
				echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
	
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonAsignar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";	
		
		echo "</table>";				
	echo "</form>";		
echo "</div>";
	
} else {

echo "<div id='wrapperPopUp'>";
	echo "<form name='nuevaActividad' method='post' action='backlogAsignaPdrPopUp.php?codigoE=$CodigoE&codigoS=$solicitudId'>";
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
				echo "<font>Asignar PDR</font>";
				echo"</td>";
			echo"</tr>";
		
			echo"<tr></tr>";	
		
			echo"<tr height='25px'> </tr>";
		echo "</table>";
		
		
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td>PDR</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		
			echo"<tr height='10'></tr>";

			echo "<tr>";
				echo "<td style='padding:0px 15px 0px 30px'>";
					echo "<select style='width: 250px;' name='pdr'>";
						echo "<option value=''>Elegir...</option>";
							$s= $INTRANET->Execute("SELECT xt_nombre, xt_usuario FROM BACKLOG.PROGRAMADORES");
							while($r= $s -> fetchRow()){
								echo"<option value='".$r[1]."'>".$r[0]."</option>";
							} unset($r); unset ($s);
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr>";
				echo "<td>Stakeholder</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			echo"<tr height='10'></tr>";
			echo "<tr id='stakeholder2'>";
				echo "<td style='padding:0px 15px 0px 30px'>";
					echo "<input type='text' name='stakeholder' style='width:35%;height:15px;' value='$gerenteSistemas' readonly>";
				echo "<input type='hidden' name='tipoS' value='$tipoS'>";
				echo "</td>";
			echo "</tr>";
			echo"<tr height='10'></tr>";
			echo "<tr>";
				echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
	
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonAsignar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";	
		
		echo "</table>";				
	echo "</form>";		
echo "</div>";

}

//ASIGNO PDR A ENTREGABLE

if ( isset($_POST['pdr'], $_POST['stakeholder']) ) {
	
	$pdrAsignado = $_POST['pdr'];
	$tipoSol = $_POST['tipoS'];
	
	//obtengo nombre y correo del solicitante
	$usuSol = $INTRANETV2->getOne("SELECT kf_usuarioId  FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudId'");
	$t = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuSol'"); 	
	while($listDatSol = $t->fetchRow()){
				
		 $nombreSolicitante = $listDatSol[0];
		 $correoSolicitante = $listDatSol[1];
	}
	
	//obtengo tiutlo y descripcion
	
	$j = $INTRANET->Execute("SELECT xt_titulo, xt_descripcion FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$CodigoE'");
	
	while($lisTitDes = $j->fetchRow()){
		
		 $tituloMail = $lisTitDes[0];
		 $descripcionMail = $lisTitDes[1];
		
	}
	
	//verificar si existe asignado un programador asiganado al entregable
	$exisPro = $INTRANET->getOne("SELECT xt_programador FROM BACKLOG.PDR where xt_codigoEntregable = '$CodigoE'");
	
	//ENTREGABLE NUEVO
	if ($exisPro == '') {
		$fecha = date("Y-m-d H:i:s");
		//Asigno el stakeholder al entregable
		 $catalogo = $_POST['stakeholder'];
		$r = $INTRANET->Execute("SELECT  xt_usuario, xt_nombre, xt_correoElectronico FROM BACKLOG.CATALOGO_STAKEHOLDERS WHERE xt_usuario = '$catalogo'");
		while($s = $r->fetchRow()) {
			
			
			//echo "INSERT INTO STAKEHOLDERS VALUES('$s[0]','$codigoE,'$s[1]','$s[2]','$fecha')";
			$query = $INTRANET->Execute("INSERT INTO BACKLOG.STAKEHOLDERS VALUES('$s[0]','$CodigoE','$s[1]','$s[2]','$fecha')");
		}
		
		//obtengo la prioridad de la solicitud la ultima proridad asignada
		 $prioridadS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$CodigoE' ");
		
		//Prioridad NORMAL
		if ($prioridadS == 'Normal') {
		
			//ahora inserto en la tabla de PDR
			//obtengo el número de posicion para determinar el siguiente.
	
			$pos = 0;
	
			$pos = $INTRANET->getOne("SELECT COUNT(p.xn_posicion) FROM BACKLOG.PDR p , BACKLOG.ENTREGABLES e WHERE xt_programador = '$pdrAsignado' AND e.xn_progreso <= 95 AND p.xt_codigoEntregable = e.xt_codigoEntregable");
	
			if($pos == 0){
				$pos = 1;
				$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

				$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while ($resultado = $listaPosiciones->FetchRow()) 
				{
					$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
					$registraHistorial = $INTRANET->Execute($query);
				}
				
				//Envio Correo
				$s = $INTRANET->Execute("SELECT
								(select xt_nombre FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador), 
								(select xt_correo FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador) 
								FROM BACKLOG.PDR PDR
								where PDR.xt_codigoEntregable = '$CodigoE'");
				while($r = $s->FetchRow()){
					$nombrePDR = $r[0];
					$correoPDR = $r[1];
				}
				if($tipoSol != 'PY') {
				
				$enviarMailAsignaSol = new MailSolicitudAsignar($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
					
					//$enviarMailAsignaSol->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
				}
				//echo "Entro a normal";
			}else{
				$pos+= 1;				

				$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

				$entregablesTerminados = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND e.xn_progreso = 100 AND p.xt_codigoEntregable = e.xt_codigoEntregable");

				while($fila = $entregablesTerminados->FetchRow()) 
				{ 
					$query = "UPDATE  BACKLOG.PDR SET xn_posicion=xn_posicion+1 WHERE xt_codigoEntregable = '".$fila['codigoEntregable']."' ";
					$ordena = $INTRANET->Execute($query);
				}

				$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while ($resultado = $listaPosiciones->FetchRow()) 
				{
					$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
					$registraHistorial = $INTRANET->Execute($query);
				}
				
				//Envio Correo
				$s = $INTRANET->Execute("SELECT
								(select xt_nombre FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador), 
								(select xt_correo FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador) 
								FROM BACKLOG.PDR PDR
								where PDR.xt_codigoEntregable = '$CodigoE'");
				while($r = $s->FetchRow()){
					$nombrePDR = $r[0];
					$correoPDR = $r[1];
				}
				if($tipoSol != 'PY') {
				
				$enviarMailAsignaSol = new MailSolicitudAsignar($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
					
					//$enviarMailAsignaSol->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
				}
				//echo "Entro a normal";

			}

			
			
		}//fin del if de verificacion de prioridad NORMAL
	
	
		//Prioridad URGENTE
		if ($prioridadS == 'Urgente') {

			$pos = 0;

			$pos = $INTRANET->getOne("SELECT COUNT(p.xn_posicion) FROM BACKLOG.PDR p , BACKLOG.ENTREGABLES e WHERE xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable AND e.xn_progreso <= 95");

			if($pos  == 0){
				$pos = 1;				

				// Inserto el entregable en la posición asignada
				$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
				('$CodigoE','$pdrAsignado', $pos)");	

				$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while ($resultado = $listaPosiciones->FetchRow()) 
				{
					$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
					$registraHistorial = $INTRANET->Execute($query);
				}

			} elseif ($pos > 1) {	

				$maxPosicion = $INTRANET->getOne("SELECT COUNT(p.xn_posicion) FROM BACKLOG.PDR p , BACKLOG.ENTREGABLES e WHERE xt_programador = '$pdrAsignado' AND e.xn_progreso <= 95 AND p.xt_codigoEntregable = e.xt_codigoEntregable AND e.xt_prioridad = 'Urgente' ");

				if ($maxPosicion == 0) {
					$pos = 2;


					$entregablesRestantes = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xn_posicion >= '$pos' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while($fila = $entregablesRestantes->FetchRow()) 
					{ 
						$query = "UPDATE  BACKLOG.PDR SET xn_posicion=xn_posicion+1 WHERE xt_codigoEntregable = '".$fila['codigoEntregable']."' ";
						$ordena = $INTRANET->Execute($query);
					}


					$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

					$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while ($resultado = $listaPosiciones->FetchRow()) 
					{
						$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
						$registraHistorial = $INTRANET->Execute($query);
					}

				} else {
					$pos = $maxPosicion+1;

					$entregablesRestantes = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xn_posicion > '$maxPosicion' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while($fila = $entregablesRestantes->FetchRow()) 
					{ 
						$query = "UPDATE  BACKLOG.PDR SET xn_posicion=xn_posicion+1 WHERE xt_codigoEntregable = '".$fila['codigoEntregable']."' ";
						$ordena = $INTRANET->Execute($query);
					}

					$pos+=1;
					$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

					$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while ($resultado = $listaPosiciones->FetchRow()) 
					{
						$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
						$registraHistorial = $INTRANET->Execute($query);
					}
				}
			} elseif ($pos == 1){
				$pos = 2;

				$entregablesRestantes = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xn_posicion >= '$pos' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while($fila = $entregablesRestantes->FetchRow()) 
				{ 
					$query = "UPDATE  BACKLOG.PDR SET xn_posicion=xn_posicion+1 WHERE xt_codigoEntregable = '".$fila['codigoEntregable']."' ";
					$ordena = $INTRANET->Execute($query);
				}


				$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

				$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while ($resultado = $listaPosiciones->FetchRow()) 
				{
					$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
					$registraHistorial = $INTRANET->Execute($query);
				}
			} 
				
			//Envio Correo
			$s = $INTRANET->Execute("SELECT
						(select xt_nombre FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador), 
						(select xt_correo FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador) 
						FROM BACKLOG.PDR PDR
						where PDR.xt_codigoEntregable = '$CodigoE'");
			while($r = $s->FetchRow()){
				$nombrePDR = $r[0];
				$correoPDR = $r[1];
			}
			
			if($tipoSol != 'PY'){
			$enviaMailPY = new MailSolicitudAsignar($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
				
				//$enviaMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
			}
				
		} //fin del if de verificacion de prioridad URGENTE
		
		
		//Prioridad EMERGENCIA
		if ($prioridadS == 'Emergencia') {

			$pos = 0;

			$pos = $INTRANET->getOne("SELECT COUNT(p.xn_posicion) FROM BACKLOG.PDR p , BACKLOG.ENTREGABLES e WHERE xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable AND e.xn_progreso <= 95");

			if($pos  == 0){
				$pos = 1;				

				// Inserto el entregable en la posición asignada
				$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
				('$CodigoE','$pdrAsignado', $pos)");	

				$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while ($resultado = $listaPosiciones->FetchRow()) 
				{
					$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
					$registraHistorial = $INTRANET->Execute($query);
				}

			} elseif ($pos > 1) {	

				$maxPosicion = $INTRANET->getOne("SELECT COUNT(p.xn_posicion) FROM BACKLOG.PDR p , BACKLOG.ENTREGABLES e WHERE xt_programador = '$pdrAsignado' AND e.xn_progreso <= 95 AND p.xt_codigoEntregable = e.xt_codigoEntregable AND e.xt_prioridad = 'Emergencia' ");

				if ($maxPosicion == 0) {
					$pos = 2;


					$entregablesRestantes = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xn_posicion >= '$pos' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while($fila = $entregablesRestantes->FetchRow()) 
					{ 
						$query = "UPDATE  BACKLOG.PDR SET xn_posicion=xn_posicion+1 WHERE xt_codigoEntregable = '".$fila['codigoEntregable']."' ";
						$ordena = $INTRANET->Execute($query);
					}


					$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

					$listaPosiciones = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while ($resultado = $listaPosiciones->FetchRow()) 
					{
						$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
						$registraHistorial = $INTRANET->Execute($query);
					}

				} else {
					$pos = $maxPosicion+1;

					$entregablesRestantes = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xn_posicion > '$maxPosicion' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while($fila = $entregablesRestantes->FetchRow()) 
					{ 
						$query = "UPDATE  BACKLOG.PDR SET xn_posicion=xn_posicion+1 WHERE xt_codigoEntregable = '".$fila['codigoEntregable']."' ";
						$ordena = $INTRANET->Execute($query);
					}

					$pos+=1;
					$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

					$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

					while ($resultado = $listaPosiciones->FetchRow()) 
					{
						$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
						$registraHistorial = $INTRANET->Execute($query);
					}
				}
			} elseif ($pos == 1){
				$pos = 2;

				$entregablesRestantes = $INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xn_posicion >= '$pos' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while($fila = $entregablesRestantes->FetchRow()) 
				{ 
					$query = "UPDATE  BACKLOG.PDR SET xn_posicion=xn_posicion+1 WHERE xt_codigoEntregable = '".$fila['codigoEntregable']."' ";
					$ordena = $INTRANET->Execute($query);
				}


				$insertaPdrNuevo = $INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES('$CodigoE','$pdrAsignado',$pos)");

				$listaPosiciones =$INTRANET->Execute("SELECT p.xt_codigoEntregable as codigoEntregable, p.xt_programador as programador, p.xn_posicion as posicion FROM BACKLOG.PDR p, BACKLOG.ENTREGABLES e WHERE p.xt_programador = '$pdrAsignado' AND p.xt_codigoEntregable = e.xt_codigoEntregable ORDER BY p.xn_posicion ASC");

				while ($resultado = $listaPosiciones->FetchRow()) 
				{
					$query = "INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE(xt_codigoEntregable, xt_programador, xn_posicion, xd_fecha) VALUES('".$resultado['codigoEntregable']."', '".$resultado['programador']."', '".$resultado['posicion']."', NOW())";
					$registraHistorial = $INTRANET->Execute($query);
				}
			} 
				
			//Envio Correo
			$s = $INTRANET->Execute("SELECT
						(select xt_nombre FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador), 
						(select xt_correo FROM IntranetGEA_USUARIOS where kp_usuario = PDR.xt_programador) 
						FROM BACKLOG.PDR PDR
						where PDR.xt_codigoEntregable = '$CodigoE'");
			while($r = $s->FetchRow()){
				$nombrePDR = $r[0];
				$correoPDR = $r[1];
			}
			
			if($tipoSol != 'PY'){
			$enviaMailPY = new MailSolicitudAsignar($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
				
				//$enviaMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
			}
				
		} //fin del if de verificacion de prioridad EMERGENCIA

	} //fin del if de verificacion de entreable sea NUEVO
	
	//recargo la pagina
	if($tipoS == 'DS'){
	echo"<script>
			window.opener.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/casoUsoBacklog.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	if($tipoS == 'MT'){
	echo"<script>
			window.opener.location = 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	
	if($tipoS == 'EA'){
	echo"<script>
			window.opener.location = 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaEnvioArchivos.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	
	if($tipoS == 'PY'){
	echo"<script>
			window.opener.location = 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	
	
}
?>



<?php
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once('MailSolicitudAsignar.php');

error_reporting(E_PARSE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	if($estiloUsuario == 1){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<title></title>

</head>
<body>
<?php

$CodigoE = $_GET['codigoE'];
$solicitudId = $_GET['codigoS'];
$tipoS = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudId'");

if($tipoS == 'PY'){
	
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
					echo "<input type='text' name='stakeholder' style='width:35%;height:15px;' value='Rodrigo_Romo' readonly>";
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
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonAsignar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";	
		
		echo "</table>";				
	echo "</form>";		
echo "</div>";
	
}else{

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
					echo "<input type='text' name='stakeholder' style='width:35%;height:15px;' value='Rodrigo_Romo' readonly>";
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
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonAsignar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";	
		
		echo "</table>";				
	echo "</form>";		
echo "</div>";

}

//ASIGNO PDR A ENTREGABLE

if($_POST['pdr'] != '' && $_POST['stakeholder'] != '') {
	
	 $pdrAsignado = $_POST['pdr'];
	 $tipoSol = $_POST['tipoS'];
	
	//obtengo nombre y correo del solicitante
	$usuSol = $INTRANET->getOne("SELECT kf_usuarioId  FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudId'");
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
	if($exisPro == ''){
		$fecha = date("Y-m-d H:i:s");
		//Asigno el stakeholder al entregable
		 $catalogo = $_POST['stakeholder'];
		$r = $INTRANET->Execute("SELECT  xt_usuario, xt_nombre, xt_correoElectronico FROM BACKLOG.CATALOGO_STAKEHOLDERS WHERE xt_usuario = '$catalogo'");
		while($s = $r->fetchRow()){
			
			
			//echo "INSERT INTO STAKEHOLDERS VALUES('$s[0]','$codigoE,'$s[1]','$s[2]','$fecha')";
			$query = $INTRANET->Execute("INSERT INTO BACKLOG.STAKEHOLDERS VALUES('$s[0]','$CodigoE','$s[1]','$s[2]','$fecha')");
		}
		
		//obtengo la prioridad de la solicitud la ultima proridad asignada
		 $prioridadS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$CodigoE' ");
		
		//Prioridad NORMAL
		if($prioridadS == 'Normal'){
		
			//ahora inserto en la tabla de PDR
			//obtengo el número de posicion para determinar el siguiente.
	
			$pos = 0;
	
			$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdrAsignado'");
	
			if($pos == ''){
				$pos = 1;
			}else{
				$pos+= 1;	
			}
	

			$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$CodigoE','$pdrAsignado',						
			$pos)");
		
			//Inserto en la tala de Historial_entregable
			$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
			('$CodigoE', '$pdrAsignado', $pos)");
			
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
	
			$enviarMailAsignaSol = new MailSolicitudAsignar();
				
				$enviarMailAsignaSol->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
			}
			//echo "Entro a normal";
			
		}//fin del if de verificacion de prioridad NORMAL
	
	
		//Prioridad URGENTE
		if($prioridadS == 'Urgente'){
			
			//ahora inserto en la tabla de PDR
			//obtengo el número de posicion para determinar el siguiente.
	
			$pos = 0;
	
			$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$pdrAsignado'");
	
			if($pos == ''){
		
				$pos = 1;
				
				//inserto registro
						
				$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
				('$CodigoE','$pdrAsignado', $pos)");
		
				//Inserto en la tala de Historial_entregable
				$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 			
				VALUES ('$CodigoE', '$pdrAsignado', $pos)");
				
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
				$enviaMailPY = new MailSolicitudAsignar();
					
					$enviaMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
				}
				//limpio variable pos para que no pase a los demas if
				unset($pos);	
			}
			
			if($pos == 1){
				
				//inserto entregable urgente en segunda posicion
				$pos+= 1;
					
				$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
				('$CodigoE','$pdrAsignado', $pos)");
		
				//Inserto en la tala de Historial_entregable
				$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
				('$CodigoE', '$pdrAsignado', $pos)");
				
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
					$enviaSolPY = new MailSolicitudAsignar();
					
					$enviaSolPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
				}
				//limpio variable pos para que no pase a los demas if
				unset($pos);
			}
			
			if($pos > 1){
				
				$entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE xt_programador = '$pdrAsignado' ORDER BY xn_posicion ASC");
				
				$banderaCambio = 0;
				$posModificado = 0;
				
				while($r = $entPos->fetchRow()){
					
					$listCodE = $r[0];
					$listPos = $r[1];
					
					//$codS = $INTRANET->getOne("Select xt_solicitud FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
					$prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
					
					if($listPos > 1){
						if($listPos <= $pos && $prioridadCodS == "Normal"){
							$banderaCambio = 1;
						 	$posModificado = $listPos;
						
							break;
						}
					}//fin del if de verificacion de pos menor a 1, menor a pos e igual a urgente
					
					//limpio variables
					unset($codS);
					unset($prioridadCodS);
					unset($listPos);
					
				}//fin del while 
				
				//verifico si existe anderaCambio = 1, para modificar posiciones
				
				if($banderaCambio == 1){
					
					//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
					for($recorre = $pos; $recorre >= $posModificado; $recorre --){
						
						$posOriginal = $recorre;
						$nuevasPos = $recorre + 1;
						
						//actualizo las posiciones
						//echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdr' AND xn_posicion = 	
						//$posOriginal";
						
						$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdrAsignado' AND 	
						xn_posicion = $posOriginal");
						
						//actualizo posicion del entregable
						$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE xt_programador = '$pdrAsignado' AND 	
						xn_posicion = $posOriginal");
						
						//Inserto en la tala de Historial_entregable
						$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) 			
						VALUES ('$codH', '$pdrAsignado', $nuevasPos)");
						
					}//fin del for de actualización de posiciones
					
					//inserto el entregable en la posicion asignada
					
					
					
					$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 	
					('$CodigoE','$pdrAsignado', $posModificado)");
		
					//Inserto en la tala de Historial_entregable
					$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					('$CodigoE', '$pdrAsignado', $posModificado)");
					
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
						$enviaMailPY = new MailSolicitudAsignar();
						
						$enviaMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $posModificado);
					}
					
				}else{
					
					//echo "entro else no bndera";
					$pos+= 1;
					
					$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					('$CodigoE','$pdrAsignado', $pos)");
		
					//Inserto en la tala de Historial_entregable
					$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					('$CodigoE', '$pdrAsignado', $pos)");
					
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
						$enviarMailPY = new MailSolicitudAsignar();
						
						$enviarMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
						
						
					}
					
				}//fin del else de verificacion de bandera cambio
				
			}// fin del if de verificacion donde pos sea mayor a 1

		}//fin del if de verificacion de prioridad URGENTE
		
		
		//PRIORIDAD EMERGENCIA		
		if($prioridadS == "Emergencia"){
			
			//obtengo el numero total de posiciones de entregables en el pdr
			$pos = 0;
	
			$pos = $INTRANET->getOne("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = 		
			'$pdrAsignado'");
	
			if($pos == ''){
		
				$pos = 1;
				
				//inserto registro
						
				$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
						('$CodigoE','$pdrAsignado', $pos)");
		
				//Inserto en la tala de Historial_entregable
				$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, 	
						xn_posicion) VALUES ('$CodigoE', '$pdrAsignado', $pos)");
				
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
					$enviarMailPY = new MailSolicitudAsignar();
					
					$enviarMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
				}
				//limpio variable pos para que no pase a los demas if
				unset($pos);
				
			}//fin del if donde pos es igual a vacio
			
			if($pos >= 1){
				
				
				$entPos = $INTRANET->execute("SELECT xt_codigoEntregable, xn_posicion FROM BACKLOG.PDR WHERE 
				xt_programador = '$pdrAsignado' ORDER BY xn_posicion ASC");
				
				$banderaCambio = 0;
				$posModificado = 0;
				$prioridadPosS = '';
				
				while($r = $entPos->fetchRow()){
					
					echo $listCodE = $r[0];
					echo $listPos = $r[1];
						
					// $codS = $INTRANET->getOne("Select xt_solicitud FROM BACKLOG.ENTREGABLES WHERE 	
					//xt_codigoEntregable = '$listCodE'");
					 
					//echo $prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM SGI_Backlog_Prioridad WHERE 
					//xt_quejaSolicitud = '$codS' ORDER BY xd_fecha DESC");
					 
					$prioridadCodS = $INTRANET->getOne("Select xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$listCodE'");
			
					if($listPos >= 1){
				
						//echo "listPos es mayor igual a uno <br>";
						
						//aqui defino si la prioridad es normal o urgente
						if($listPos <= $pos && ($prioridadCodS == "Normal" || $prioridadCodS == "Urgente")){
				
							//echo "entro a normal-urgente";
							$banderaCambio = 1;
							echo  $posModificado = $listPos;
							echo $prioridadPosS = $prioridadCodS;
				
							break;
						}
				
					}//fin del if de verificacion de pos mayor a 1, menor a pos e igual a urgente
			
					//limpio variables
					unset($codS);
					unset($prioridadCodS);
					unset($listPos);
			
				}//fin del while 
				
				//verifico si existe anderaCambio = 1, para modificar posiciones
				if($banderaCambio == 1){
			
					//echo "entro bandera cambio 1";
					//verifico la prioridad
					if($prioridadPosS == "Urgente"){
			
						//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las actualizaciones de las posiciones  						en el for.
						for($recorre = $pos; $recorre >= $posModificado; $recorre --){
				
							$posOriginal = $recorre;
							$nuevasPos = $recorre + 1;
				
							//actualizo las posiciones
						
				
							//obtengo el codigo del entregable para insertar en tabla historial
							$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
							xt_programador = '$pdrAsignado' AND xn_posicion = $posOriginal");
				
							//actualizo posicion del entregable
							$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
							xt_programador = '$pdrAsignado' AND xn_posicion = $posOriginal");
				
							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
							xt_programador, xn_posicion) VALUES ('$codH', '$pdrAsignado', $nuevasPos)");
				
				
						}//fin del for de actualización de posiciones
						
						
						//inserto el entregable en la posicion asignada
						
						$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
						xn_posicion) VALUES ('$CodigoE','$pdrAsignado', $posModificado)");

						//Inserto en la tala de Historial_entregable
						$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
						xt_programador, xn_posicion) VALUES ('$CodigoE', '$pdrAsignado', 	
						$posModificado)");
						
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
							$enviarMailPY = new MailSolicitudAsignar();
							
							$enviarMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $posModificado);
						}
					}//fin del if de verificacion cuando la prioridad del entregable donde se tomara su lugar sea URGENTE
					
					if($prioridadPosS == "Normal"){
						
						//echo "el entregable es normal";
						
						//verifico si las prioridades de los entregables que le siguen son urgentes y la pondre 	
						//despues del ultimo urgente, pero si todas son normales entonces solo bajare sus posiciones
						
						//verifico si es el unico entregale en la lista
						if($posModificado == $pos){
							
							//solo incremente posiciones
							
							//modificar en lugar de incrementar sera decrementar para que no haya conflicto con las 		
							//actualizaciones de las posiciones en el for.
							for($recorre = $pos; $recorre >= $posModificado; $recorre --){
				
								$posOriginal = $recorre;
								$nuevasPos = $recorre + 1;
				
								//actualizo las posiciones
						
				
								//obtengo el codigo del entregable para insertar en tabla historial
								$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 		
								xt_programador = '$pdrAsignado' AND xn_posicion = $posOriginal");
				
								//actualizo posicion del entregable
								$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPos WHERE 	
								xt_programador = '$pdrAsignado' AND xn_posicion = $posOriginal");
				
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 				
								xt_programador, xn_posicion) VALUES ('$codH', '$pdrAsignado', $nuevasPos)");
				
				
							}//fin del for de actualización de posiciones
						
							//inserto el entregable en la posicion asignada
						
							$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
							xn_posicion) VALUES ('$CodigoE','$pdrAsignado', $posModificado)");

							//Inserto en la tala de Historial_entregable
							$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
							xt_programador, xn_posicion) VALUES ('$CodigoE', '$pdrAsignado', 	
							$posModificado)");
							
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
								$enviarMailPY = new MailSolicitudAsignar();
								
								$enviarMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $posModificado);
							}
							
						}else{//fin del if de verificacion donde posModificado se aigual a pos e inicio del else
						
							//echo "no es el unico entregable";
							$banderaCambioP = 0;
							$posModificadoP = 0;
				
							//obtengo los codigos de los entregables deacuerdo a su posicion
							
							 $posSig = $posModificado + 1;
							
							for($recorrePos = $posSig; $recorrePos <= $pos; $recorrePos ++){
			
								//obtengo el codigo del entregable deacuedo a su posicion
								$codEP = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE 
								xn_posicion = $recorrePos AND xt_programador = '$pdrAsignado'");
								
								//obtengo su prioridad
								$prioriCodEP = $INTRANET->getOne("SELECT xt_prioridad FROM BACKLOG.ENTREGABLES 
								WHERE xt_codigoEntregable = '$codEP'");
			
								if($prioriCodEP == 'Urgente'){
									
									
									$posModificadoP = $recorrePos;
									$banderaCambioP = 1;
									
								}
						
							}//fin del for
							
							//verifico la banderacanbioP
							if($banderaCambioP == 1){
								//echo "entro bandera en urgente <br>";
								//pondre el entregable en la posicion inmediata del ultimo entregable con prioridad 											de emergencia
						
								$posInserta = $posModificadoP + 1;
								
								//verifico si existe cupado dicho lugar por algun entregable
								$existeLugar = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.PDR 	
								WHERE xt_programador = '$pdrAsignado' AND xn_posicion = $posInserta");
								
								if($existeLugar != ''){
									
									//echo "el lugar esta ocupado";
									//incremento posiciones
									
									//actualizaciones de las posiciones en el for.
									for($recorreU = $pos; $recorreU >= $posInserta; $recorreU --){
				
										 $posOriginalU = $recorreU;
										 $nuevasPosU = $recorreU + 1;
				
										//actualizo las posiciones
						
				
										//obtengo el codigo del entregable para insertar en tabla historial
										$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
										WHERE xt_programador = '$pdrAsignado' AND xn_posicion = 	
										$posOriginalU");
				
										//actualizo posicion del entregable
										$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosU WHERE 	
										xt_programador = '$pdrAsignado' AND xn_posicion = $posOriginalU");
				
										//Inserto en la tala de Historial_entregable
										$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 	
										(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 
										'$pdrAsignado', $nuevasPosU)");
				
				
									}//fin del for de actualización de posiciones
									
									//obtengo el codigo del entregable para insertar en tabla historial
									$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
									WHERE xt_programador = '$pdrAsignado' AND xn_posicion = $posModificado");
									
									$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	
									xt_programador = '$pdrAsignado' AND xn_posicion = $posModificado");
				
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 		
									(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 	
									'$pdrAsignado', $posInserta)");
									
									
								}else{//fin del if donde existe lugar es diferente de vacio e inicio del else 
								
									//solo actualizo a la posicion
									
									//obtengo el codigo del entregable para insertar en tabla historial
									$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR 		
									WHERE xt_programador = '$pdrAsignado' AND xn_posicion = $posModificado");
									
									$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $posInserta WHERE 	
									xt_programador = '$pdrAsignado' AND xn_posicion = $posModificado");
				
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE 		
									(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', 	
									'$pdrAsignado', $posInserta)");
									
									
									
								}//fin del else donde solo actualizo 
								
								
								//reasigno el entregable eliminado en el lugar 1
								
								//inserto el entregable en la posicion asignada
						
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, 	
								xn_posicion) VALUES ('$CodigoE','$pdrAsignado', $posModificado)");

								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, 	
								xt_programador, xn_posicion) VALUES ('$CodigoE', '$pdrAsignado', 	
								$posModificado)");
								
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
									$enviarMailPY = new MailSolicitudAsignar();
									$enviarMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $posModificado);
								}
							
							}else{
											
								//todos los entregables son normales
								
								//incrementamos los lugares de los entregables
								
								//actualizaciones de las posiciones en el for.
								for($recorreN = $pos; $recorreN >= 1; $recorreN --){
				
									$posOriginalN = $recorreN;
									$nuevasPosN = $recorreN + 1;
				
									//actualizo las posiciones
				
									//obtengo el codigo del entregable para insertar en tabla historial
										
									$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$pdrAsignado' AND xn_posicion = $posOriginalN");
										
									//echo "UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosN WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $posOriginalN";
									//actualizo posicion del entregable
									$INTRANET->Execute("UPDATE BACKLOG.PDR SET xn_posicion = $nuevasPosN WHERE xt_programador = '$pdrAsignado' AND xn_posicion = $posOriginalN");
				
									//Inserto en la tala de Historial_entregable
									$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$codH', '$pdrAsignado', $nuevasPosN)");
				
				
								}//fin del for de actualización de posiciones
									
									
								//obtengo el codigo del entregable para insertar en tabla historial
								//$codH = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.PDR WHERE xt_programador = '$arrProgramador[$a]' AND xn_posicion = $arrEntregableP[$a]");
								//echo "INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$arrEntregableP[$a]','$arrProgramador[$a]', 1)";
								$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$CodigoE','$pdrAsignado', 1)");
									
								//Inserto en la tala de Historial_entregable
								$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES ('$CodigoE', '$pdrAsignado', 1)");
									
													
							}//fin del else donde bandera cambio no es 1
							
						
						}//fin del else donde la posicion del entregable no esta en ultimo lugar
						//obtengo 
						
					}// fin del if donde verifico la prioridad a NORMAL
			
				}else{
				
					
					
					$pos+= 1;
				
					$INTRANET->Execute("INSERT INTO BACKLOG.PDR(xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					('$CodigoE','$pdrAsignado', $pos)");
		
					//Inserto en la tala de Historial_entregable
					$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable, xt_programador, xn_posicion) VALUES 
					('$CodigoE', '$pdrAsignado', $pos)");
					
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
						$enviarMailPY = new MailSolicitudAsignar();
						
						$enviarMailPY->mailSolicitudAsignarBacklog($solicitudId, $correoPDR, $nombrePDR, $correoSolicitante, $nombreSolicitante, $tituloMail, $descripcionMail, $CodigoE, $prioridadS, $pos);
					}
				}//fin del else
		
			}//fin del if pos >= 1
		
		}//fin del if donde prioridad es EMERGENCIA
		
	}//fin del if de verificacion de entreable sea NUEVO
	
	//recargo la pagina
	if($tipoS == 'DS'){
	echo"<script>
			window.opener.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	if($tipoS == 'MT'){
	echo"<script>
			window.opener.location = 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaMantenimiento_Sistema.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	
	if($tipoS == 'EA'){
	echo"<script>
			window.opener.location = 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaEnvioArchivos.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	
	if($tipoS == 'PY'){
	echo"<script>
			window.opener.location = 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaProyectoFuncionalidad.php?codigo=$solicitudId';
			window.close();
		</script>";
	}
	
	
}
?>



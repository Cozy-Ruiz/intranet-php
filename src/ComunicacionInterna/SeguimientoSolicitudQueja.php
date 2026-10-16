<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'SeguimientoSolicitudQueja.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Seguimiento</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
</head>
<body>
<?php

$origen = $_GET['origen'];
$ID = $_GET['ID'];

$s = $INTRANET->Execute("
SELECT SGU.kp_seguimientoID, SGU.xd_fechaRegistro, SGU.xt_codigoSeguimiento, EMP.xt_nombreCorto, SGU.kf_pdrID 
FROM SGI_Seguimientos SGU, SGI_Empleados EMP WHERE xt_tipoOrigen = '$origen' AND kf_itemOrigenID = $ID AND SGU.kf_asignadorID = EMP.kp_personalId ");

while($r = $s->fetchRow()){
	$seguimientoID = $r[0];
	$fechaReg = date('Y-m-d', strtotime($r[1]));
	$codigo = $r[2];
	$asignador = $r[3];
	$pdrID = $r[4];
	$pdr = $INTRANET->getOne("SELECT xt_nombreCorto FROM SGI_Empleados WHERE kp_personalId = $pdrID ");
} unset($r); unset($s);


$s= $INTRANET->Execute("SELECT MAX(xn_etapa),MAX(xd_fecha) FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID=$seguimientoID ORDER BY xd_fecha DESC");

while($r = $s->fetchRow()){
	$etapaStatus = $r[0];
	$fechaStatus = date('Y-m-d', strtotime($r[1]));
	
} unset($r); unset($s);


if($origen == "A"){
	$tipoItem = "Acuerdo";
	if($etapaStatus == 1){
		$etapaStatus = 'Asignado';
	}else if($etapaStatus == 2){
		$etapaStatus = 'En Proceso';
	}else if($etapaStatus == 3){
		$etapaStatus = 'En Revisión';
	}else if($etapaStatus == 4){
		$etapaStatus = 'Cierre';
	}
	$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a>
			<a href='tableroReuniones.php' id='breadcrumbs'> Reuniones / </a><a href='tableroAcuerdos.php' id='breadcrumbs'> Acuerdos </a><br><br>
			<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/tableroSeguimientos.php' id='breadcrumbs'>Tablero de Seguimientos </a>";
			
} else if($origen == "B"){
	$tipoItem = "Solicitud";
	if($etapaStatus == 1){
		$etapaStatus = 'Asignado';
	}else if($etapaStatus == 2){
		$etapaStatus = 'En Proceso';
	}else if($etapaStatus == 3){
		$etapaStatus = 'En Revisión';
	}else if($etapaStatus == 4){
		$etapaStatus = 'Cierre';
	}
	$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
			Comunicación Interna / </a>
			<a href='https://escalante.com.mx/INTRANET_GEA/ComunicacionInterna/tableroSolicitudesyQuejas.php' id='breadcrumbs'> Solicitudes y Quejas</a><br><br>
			<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/tableroSeguimientos.php' id='breadcrumbs'>Tablero de Seguimientos </a>";
} else if($origen == "C"){
	$tipoItem = "Queja";
	if($etapaStatus == 1){
		$etapaStatus = 'Asignada';
	}else if($etapaStatus == 2){
		$etapaStatus = 'Evaluación Inicial';
	}else if($etapaStatus == 3){
		$etapaStatus = 'Investigación';
	}else if($etapaStatus == 4){
		$etapaStatus = 'Respuesta';
	}else if($etapaStatus == 5){
		$etapaStatus = 'Comunicación';
	}else if($etapaStatus == 6){
		$etapaStatus = 'Cierre';
	}
	$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
			Comunicación Interna / </a>
			<a href='https://escalante.com.mx/INTRANET_GEA/ComunicacionInterna/tableroSolicitudesyQuejas.php' id='breadcrumbs'> Solicitudes y Quejas</a><br><br>
			<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/tableroSeguimientos.php' id='breadcrumbs'>Tablero de Seguimientos </a>";
} else if($origen == "D"){
	$tipoItem = "Acción Preventiva";
	
	if($etapaStatus == 1){
		$etapaStatus = 'Asignada';
	}else if($etapaStatus == 2){
		$etapaStatus = 'Definición de la no conformidad potencial';
	}else if($etapaStatus == 3){
		$etapaStatus = 'Evaluación';
	}else if($etapaStatus == 4){
		$etapaStatus = 'Plan de acción';
	}else if($etapaStatus == 5){
		$etapaStatus = 'Registro de las acciones';
	}else if($etapaStatus == 6){
		$etapaStatus = 'Evaluación de la eficacia';
	}else if($etapaStatus == 7){
		$etapaStatus = 'Cierre';
	}
	$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> 
		Sistema de Gestión Integral / </a>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/AccionesPreventivasyCorrectivas.php' id='breadcrumbs'> Acciones Preventivas y Correctivas / </a>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'> Tablero de Acciones Preventivas</a><br><br>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/tableroSeguimientos.php' id='breadcrumbs'>Tablero de Seguimientos </a>";
	
} else if($origen == "E"){
	$tipoItem = "Acción Correctiva";
	
	if($etapaStatus == 1){
		$etapaStatus = 'Asignada';
	}else if($etapaStatus == 2){
		$etapaStatus = 'Análisis de la causa raíz';
	}else if($etapaStatus == 3){
		$etapaStatus = 'Plan de acción';
	}else if($etapaStatus == 4){
		$etapaStatus = 'Registro de las acciones';
	}else if($etapaStatus == 5){
		$etapaStatus = 'Evaluación de la eficacia';
	}else if($etapaStatus == 6){
		$etapaStatus = 'Cierre';
	}
	
	$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> 
		Sistema de Gestión Integral / </a>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/AccionesPreventivasyCorrectivas.php' id='breadcrumbs'> Acciones Preventivas y Correctivas / </a>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'> Tablero de Acciones Preventivas</a><br><br>
		<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/tableroSeguimientos.php' id='breadcrumbs'>Tablero de Seguimientos </a>";	
}

echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
	///SI NO ES NECESARIO NO USAR
		echo "<tr>";
			echo "<td align='left' id='iconosTexto2'></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'></td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";
	///Titulo Ficha
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='700px'>Seguimiento</td>";
		echo"</tr>";
		
		echo"<tr height='10px'> </tr>";
	///Bread Crumb
		echo"<tr>"; 
			echo"<td align='center' id='breadcrumbs'>";
				echo "$breadcrumb";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
	///CODIGO y STATUS
		echo "<tr id='titulo2'>";
			echo "<td align='left' width='300px'><b>$codigo</b></td>";
			echo "<td align='right' width='400px'><b>$etapaStatus</b></td>";
		echo "</tr>";
	///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
	echo "</table>";


	if($origen == "A"){
		
		$s = $INTRANET->Execute("SELECT xt_titulo, xt_descripcion, xt_claveAcuerdo FROM SGI_Acuerdos WHERE kp_acuerdoID = $ID ");
	
		while($r = $s->fetchRow()){
			$titulo = $r[0];
			$descripcion = nl2br($r[1]);
			$claveAcuerdo = $r[2];
		} unset($r); unset($s);
	
		
		echo "<table border='0' align='center'>";
		///Titulo
			echo "<tr>";
				echo "<td> </td>";
				echo "<td align='left' id='iconosTexto' colspan='2'><b>$titulo</b></td>";
			echo "</tr>";
			echo "<tr height='10px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
		///Descripcion
				echo "<td width='640' id='fileItem' align='justify'>$descripcion</td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "B"){
		
		$s = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo, xt_descripcion, xt_ruta FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $ID AND xt_tipo = 'B' ");
	
		while($r = $s->fetchRow()){
			$claveSolicitud = $r[0];
			$titulo = $r[1];
			$descripcion = nl2br($r[2]);
			$rutaSolicitud = $r[3];
		} unset($r); unset($s);
	
		
		echo "<table border='0' align='center'>";
		///Titulo
			echo "<tr>";
				echo "<td> </td>";
				echo "<td align='left' id='iconosTexto' colspan='2'><b>$titulo</b></td>";
				if($rutaSolicitud != ""){
					echo "<td><a href='downloadQuejaSolicitud.php?file=$rutaSolicitud'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
				} else{
					echo "<td> </td>";
				}
			echo "</tr>";
			echo "<tr height='10px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
		///Descripcion
				echo "<td width='590px' id='fileItem' align='justify'>$descripcion</td>";
				echo "<td width='50px'></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "C"){
		
		$s = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo, xt_descripcion, xt_ruta FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $ID AND xt_tipo = 'C' ");
	
		while($r = $s->fetchRow()){
			$claveQueja = $r[0];
			$titulo = $r[1];
			$descripcion = nl2br($r[2]);
			$rutaQueja = $r[3];
		} unset($r); unset($s);
	
		
		echo "<table border='0' align='center'>";
		///Titulo
			echo "<tr>";
				echo "<td> </td>";
				echo "<td align='left' id='iconosTexto' colspan='2'><b>$titulo</b></td>";
				if($rutaQueja != ""){
					echo "<td><a href='downloadQuejaSolicitud.php?file=$rutaQueja'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
				} else{
					echo "<td> </td>";
				}
			echo "</tr>";
			echo "<tr height='10px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
		///Descripcion
				echo "<td width='590px' id='fileItem' align='justify'>$descripcion</td>";
				echo "<td width='50px'></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "D"){
		
		$s = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo, xt_descripcion, xt_ruta FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $ID AND xt_tipo = 'D' ");
	
		while($r = $s->fetchRow()){
			$clavePreventiva = $r[0];
			$titulo = $r[1];
			$descripcion = nl2br($r[2]);
			$rutaPreventiva = $r[3];
		} unset($r); unset($s);
	
		
		echo "<table border='0' align='center'>";
		///Titulo
			echo "<tr>";
				echo "<td> </td>";
				echo "<td align='left' id='iconosTexto' colspan='2'><b>$titulo</b></td>";
				if($rutaPreventiva != ""){
					echo "<td><a href='downloadPreventivasCorrectivas.php?file=$rutaPreventiva'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
				} else{
					echo "<td> </td>";
				}
			echo "</tr>";
			echo "<tr height='10px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
		///Descripcion
				echo "<td width='590px' id='fileItem' align='justify'>$descripcion</td>";
				echo "<td width='50px'></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "E"){
		
		$s = $INTRANET->Execute("SELECT xt_claveAccion, xt_titulo, xt_descripcion, xt_ruta FROM SGI_Acciones_Preventivas_Correctivas WHERE kp_accionesID = $ID AND xt_tipo = 'E' ");
	
		while($r = $s->fetchRow()){
			$claveCorrectiva = $r[0];
			$titulo = $r[1];
			$descripcion = nl2br($r[2]);
			$rutaCorrectiva = $r[3];
		} unset($r); unset($s);
	
		
		echo "<table border='0' align='center'>";
		///Titulo
			echo "<tr>";
				echo "<td> </td>";
				echo "<td align='left' id='iconosTexto' colspan='2'><b>$titulo</b></td>";
				if($rutaCorrectiva != ""){
					echo "<td><a href='downloadPreventivasCorrectivas.php?file=$rutaCorrectiva'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
				} else{
					echo "<td> </td>";
				}
			echo "</tr>";
			echo "<tr height='10px'> </tr>";
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
		///Descripcion
				echo "<td width='590px' id='fileItem' align='justify'>$descripcion</td>";
				echo "<td width='50px'></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	}
	
	
	echo "<table border='0' align='center' width='700'>";
	///Persona directamente responsable			
		echo"<tr>";
			echo"<td align='left'  id='titulo2'><b>PDR (Persona directamente responsable)</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='700'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
	///Nombre
		echo "<tr>";
			echo "<td width='30px'> </td>";
			echo "<td align='left' width='670px' id='iconosTexto'><b>$pdr</b></td>";
		echo "</tr>";
		echo "<tr height='20px'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
	///TIPO ITEM		
		echo"<tr>";
			echo"<td align='left'  id='titulo2'><b>$tipoItem</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='700'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	if($origen == 'A'){
		echo "<table border='0' align='center' width='700'>";
		///Item relacionado
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='670px' id='fileItem'><a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/fichaAcuerdo.php?acuerdo=$ID' id='fileItem' style='text-decoration:none;'>$claveAcuerdo</a></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == 'B'){
		echo "<table border='0' align='center' width='700'>";
		///Item relacionado
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='670px' id='fileItem'><a href='https://escalante.com.mx/INTRANET_GEA/ComunicacionInterna/fichaSolicitud.php?id=$ID' id='fileItem' style='text-decoration:none;'>$claveSolicitud</a></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == 'C'){
		echo "<table border='0' align='center' width='700'>";
		///Item relacionado
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='670px' id='fileItem'><a href='https://escalante.com.mx/INTRANET_GEA/ComunicacionInterna/fichaQueja.php?id=$ID' id='fileItem' style='text-decoration:none;'>$claveQueja</a></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == 'D'){
		echo "<table border='0' align='center' width='700'>";
		///Item relacionado
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='670px' id='fileItem'><a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/fichaPreventiva.php?id=$ID' id='fileItem' style='text-decoration:none;'>$clavePreventiva</a></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == 'E'){
		echo "<table border='0' align='center' width='700'>";
		///Item relacionado
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' width='670px' id='fileItem'><a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/fichaCorrectiva.php?id=$ID' id='fileItem' style='text-decoration:none;'>$claveCorrectiva</a></td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	}
	
	echo "<table border='0' align='center' width='700'>";
	///ETAPAS		
		echo"<tr>";
			echo"<td align='left'  id='titulo2'><b>Etapas</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='700'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	if($origen == "A"){
		echo "<table border='0' align='center'>";
		
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='450px'> </td>";
				echo "<td width='100px'> </td>";
				echo "<td width='50px'> </td>";
			echo "</tr>";
		///ASIGNADO
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 1 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				
			}unset($r); unset($s);
			
			
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Asignado</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					
						echo "<td id='fileItem'></td>";
					
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
			
			echo "<tr height='20px'> </tr>";
		///EN PROCESO
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 2 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Proceso</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Proceso</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=2&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";			
		///EN REVISION
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 3 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Revisión</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Revisión</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=3&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///CIERRE
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 4 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=4&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
		
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "B"){
		echo "<table border='0' align='center'>";
		
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='450px'> </td>";
				echo "<td width='100px'> </td>";
				echo "<td width='50px'> </td>";
			echo "</tr>";
		///ASIGNADO
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 1 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				
			}unset($r); unset($s);
			
			
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Asignado</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					
						echo "<td id='fileItem'></td>";
					
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
			
			echo "<tr height='20px'> </tr>";
		///EN PROCESO
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 2 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Proceso</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Proceso</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=2&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";			
		///EN REVISION
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 3 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Revisión</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>En Revisión</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=3&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///CIERRE
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 4 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=4&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
		
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "C"){
		echo "<table border='0' align='center'>";
		
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='450px'> </td>";
				echo "<td width='100px'> </td>";
				echo "<td width='50px'> </td>";
			echo "</tr>";
		///ASIGNADA 
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 1 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				
			}unset($r); unset($s);
			
			
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Asignada</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					
						echo "<td id='fileItem'></td>";
					
				echo "</tr>";
			
			echo "<tr height='20px'> </tr>";
			
		///EVALUACIÓN INICIAL 
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 2 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
						
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación Inicial</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación Inicial</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=2&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///INVESTIGACIÓN
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 3 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Investigación</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Investigación</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=3&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";			
		///RESPUESTA
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 4 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Respuesta</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Respuesta</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=4&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///COMUNICACIÓN
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 5 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Comunicación</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Comunicación</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=5&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///CIERRE
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 6 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				/*
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				*/
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='3'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=6&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
		
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "D"){
		echo "<table border='0' align='center'>";
		
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='450px'> </td>";
				echo "<td width='100px'> </td>";
				echo "<td width='50px'> </td>";
			echo "</tr>";
		
		///ASIGNADA
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 1 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				
			}unset($r); unset($s);
			
			
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Asignada</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					
						echo "<td id='fileItem'></td>";
					
				echo "</tr>";
			
			echo "<tr height='20px'> </tr>";
			
		///DEFINICION
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 2 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Definición de la no conformidad potencial</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Definición de la no conformidad potencial</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=2&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///EVALUACION
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 3 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=3&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";			
		///PLAN DE ACCION
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 4 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Plan de acción</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Plan de acción</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=4&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///REGISTRO DE LAS ACCIONES
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 5 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Registro de las acciones</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Registro de las acciones</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=5&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///EVALUACION DE LA EFICACIA
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 6 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación de la eficacia</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación de la eficacia</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=6&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///CIERRE
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 7 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=7&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
		
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	} else if($origen == "E"){
		echo "<table border='0' align='center'>";
		
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='30px'> </td>";
				echo "<td width='450px'> </td>";
				echo "<td width='100px'> </td>";
				echo "<td width='50px'> </td>";
			echo "</tr>";
			
		///Asignada
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 1 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				
			}unset($r); unset($s);
			
			
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Asignada</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					
						echo "<td id='fileItem'></td>";
					
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
			
			echo "<tr height='20px'> </tr>";
		///ANALISIS DE LA CAUSA RAIZ
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 2 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Análisis de la causa raíz</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Análisis de la causa raíz</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=2&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
								
		///PLAN DE ACCION
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 3 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Plan de acción</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Plan de acción</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=3&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///REGISTRO DE LAS ACCIONES
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 4 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Registro de las acciones</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Registro de las acciones</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=4&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///EVALUACION DE LA EFICACIA
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 5 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación de la eficacia</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";

					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Evaluación de la eficacia</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=5&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
			echo "<tr height='20px'> </tr>";
		///CIERRE
			$fecha = "";
			$tituloEtapa = "";
			$contenido = "";
			$ruta = "";
			
			$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta  FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $seguimientoID AND xn_etapa = 6 ");
			
			while($r = $s->fetchRow()){
				$fecha = date('Y-m-d', strtotime($r[0]));
				$tituloEtapa = $r[1];
				$contenido = $r[2];
				$ruta = $r[3];
				
			}unset($r); unset($s);
			
			if($fecha != ""){	
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem'>$fecha</td>";
				///Archivo
					if($ruta != ""){
						echo "<td id='fileItem'><a href='downloadSeguimientoSolicitudQueja.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td id='fileItem'></td>";
					}
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
				///Titulo
					echo "<td id='fileItem' align='justify' colspan='4'>$tituloEtapa</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td align='left'> </td>";
					echo "<td align='left'> </td>";
				///Contenido
					echo "<td id='fileItem' align='justify' colspan='2'>$contenido</td>";
					echo "<td align='left'> </td>";
				echo "</tr>";
			} else{
				echo "<tr>";
					echo "<td> </td>";
				///Etapa
					echo "<td align='left' id='iconosTexto' colspan='3'><b>Cierre</b></td>";
				///Fecha
					echo "<td id='fileItem' colspan='2'><a href='AgregarEtapaSeguimientoSolicitudQueja.php?etapa=6&seguimiento=$seguimientoID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a></td>";
				echo "</tr>";
				
			}
		
			echo "<tr height='20px'> </tr>";
		echo "</table>";
	}
	
	
	
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='700px'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'> </tr>";
		
		echo "<tr>";
			/*echo "<td align='right'>";
				echo "<a href='SeguimientoModificacion.php?seguimiento=$seguimientoID' >
					  <img src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";*/
		echo "</tr>";
		
		echo"<tr height='10px'> </tr>";
		
		/*echo "<tr>";
			echo "<td align='center' id='nota_al_pie'>";
			///Titulo
				echo "Creado: $fechaCreacion, Salvador de la Peña";
			echo "</td>";
		echo "</tr>";
		*/
		echo"<tr height='40px'> </tr>";
		
	echo "</table>";
	
echo"</div>";

?>
</body>
</html>
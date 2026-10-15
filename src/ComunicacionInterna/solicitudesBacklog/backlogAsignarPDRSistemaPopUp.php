<?php error_reporting(0); ?>
<?php
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once('MailSolicitudAsignar.php');

 error_reporting(E_PARSE);

$sistema     = $_GET['sistema'];
$solicitudId = $_GET['codigo'];
$ciudadSolicitud = $_GET['ciudad'];
$tipoSolicitud = $_GET['tipoS'];
$prioridad = $_GET['prioridad'];

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

$tipoS = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudId'");

echo "<div id='wrapperPopUp'>";
	echo "<form name='nuevaActividad' method='post' action='backlogAsignarPDRSistemaPopUp.php'>";
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
					echo "<input type='hidden' name='solicitud' value='$solicitudId'>";
					echo "<input type='hidden' name='ciudad' value='$ciudadSolicitud'>";
					echo "<input type='hidden' name='tipoS' value='$tipoSolicitud'>";
					echo "<input type='hidden' name='sistema' value='$sistema'>";
					echo "<input type='hidden' name='prioridad' value='$prioridad'>";
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


if($_POST['pdr'] != '' && $_POST['stakeholder']) {
		
		$pdrAsignado = $_POST['pdr'];
		$catalogo = $_POST['stakeholder'];
		$sistema     = $_POST['sistema'];
		$solicitudId = $_POST['solicitud'];
		$ciudadSolicitud = $_POST['ciudad'];
		$tipoSolicitud = $_POST['tipoS'];
		$prioridad = $_POST['prioridad'];
		
		$s = $INTRANET->Execute("SELECT xt_titulo, xt_descripcion FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudId' AND xt_tipo = 'B' ");
			while($r = $s->fetchRow()){
				$titulo 			= $r[0];
				$descripcion 		= nl2br ($r[1]);
			}
		
		//obtengo el ultimo codigo de entregable insertado para definir el sig codigo
		$maximo = 0;
		$maximo = $INTRANET->getOne("SELECT MAX(xn_consecutivo) FROM BACKLOG.ENTREGABLES");
		if($maximo == ''){
			
			 $maximo = 1;
		}else{
		 $maximo+= 1;
		}
		
	if($maximo<10){ $clave = "0000".$maximo; }else if($maximo <100){$clave = "000".$maximo;}else if($maximo < 1000){$clave = "00".$maximo;}
	else if($maximo<10000){$clave = "0".$maximo;}else if($maximo<100000){$clave = $maximo;}
		
		//inserto en la tabla de entregables los datos correspondientes
		//defino el codigo de entregable
	    $codigoEntregable = $ciudadSolicitud.'-'.$tipoSolicitud.'-'.$clave;
		
		//echo"INSERT INTO BACKLOG.ENTREGABLES (xt_codigoEntregable, xt_titulo, xt_descripcion, xt_solicitud, xt_tipo, xt_prioridad, xn_consecutivo, xn_progreso) VALUES ('$codigoEntregable', '$titulo', '$descripcion', '$solicitudId', '', '$prioridad', $maximo, 0)";
		if($INTRANET->Execute("INSERT INTO BACKLOG.ENTREGABLES (xt_codigoEntregable, xt_titulo, xt_descripcion, xt_solicitud, xt_tipo, xt_prioridad, xn_consecutivo, xn_progreso) VALUES ('$codigoEntregable', '$titulo', '', '$solicitudId', '', '$prioridad', $maximo, 0)")){
		
			 $INTRANET->Execute("UPDATE SGI_Backlog_Solicitud_Sistemas_Temporal SET xt_codigoEntregable = '$codigoEntregable' WHERE xt_quejaSolicitud = '$solicitudId' and xt_sistema = '$sistema' ");
			 
		}//fin del if de insercion en tabla entregables
		
		
	
		echo"<script>
			window.opener.location = 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/backlogAsignaPdrAltaBaja.php?codigoE=".$codigoEntregable."&codigoS=".$solicitudId."&pdr=".$pdrAsignado."&stakeholder=".$catalogo."';
			window.close();
		</script>";
		
	}//fin del if de verificacion de datos del formulario
	
	
?>
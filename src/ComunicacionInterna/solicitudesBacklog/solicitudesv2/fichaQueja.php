<?php error_reporting(0); ?>
<?php

//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'fichaQueja.php';
require_once("../../../ConexionDBT.php");
require_once('../../../compruebaUsuario.php');
require_once("../../../ConexionIntranet2.php");

require_once('MailQuejas.php');

//obtengo parametros

$solicitudID = $_GET['codigo'];

 error_reporting(E_PARSE);

//parametros de conexion ftp

$ftp_server = "71.144.19.155";
$ftp_user = "Imagenes";
$ftp_pass = "Img2012Server";
$ubicacionPDF = "/INTRANET/documentosQuejas/".$solicitudID."/evaluacion.pdf";
           
           ?><script>
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
			</script><?php

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

//obtengo titulo, fecha de solicitud, descripcion, solicitante, solicitante original
$s = $INTRANETV2->Execute("SELECT
							xt_titulo,
							xt_descripcion,
							xd_fecha,
							kf_usuarioId,
							xt_status,
							xt_solicitanteOriginal,
							xd_fechaLimite,
							xt_pdr,
							xt_tipoSolicitud,
							xt_ciudad,
							xt_ruta,
							xt_pdr,
							(select xt_nombre from IntranetGEA.IntranetGEA_USUARIOS where kp_usuario = kf_usuarioId),
							(select xt_correo from IntranetGEA.IntranetGEA_USUARIOS where kp_usuario = kf_usuarioId)	
						FROM
							SGI_Quejas_Solicitudesv2 
						WHERE
							xt_quejaSolicitud = '$solicitudID' ");
		
while($j = $s->fetchRow()){
	$tituloSolicitud = $j[0];
	$descripcionSolicitud= $j[1];
	$fechaSolicitud = $j[2];
	$usuarioSolicitud = $j[3];
	$statusSolicitud = $j[4];
	$solicitanteOriginal = $j[5];
	$fechaLimite = $j[6];
	$pdrAsignado = $j[7];
	$tipoSolicitud = $j[8];
	$ciudadSolicitud = $j[9];
	$doctoSolicitud = $j[10];
	$pdrNombre = $j[11];			
}

$s= $INTRANETV2->Execute("SELECT
			AC.xt_claveAccion
		FROM
			SGI_Quejas_Acciones_Correctivas SAC,
			SGI_Acciones_Preventivas_Correctivas AC
		WHERE
			SAC.xt_quejaSolicitud = '$solicitudID'
		AND SAC.xt_tipo = 'ACCION'
		AND AC.xt_claveAccion = SAC.xt_claveAccion
	");
	while($r= $s -> fetchRow()){
		$claveCorrectiva = $r[0];
	}

	$p= $INTRANETV2->Execute("SELECT
			COUNT(AC.xt_claveAccion)
		FROM
			SGI_Quejas_Acciones_Correctivas SAC,
			SGI_Acciones_Preventivas_Correctivas AC
		WHERE
			SAC.xt_quejaSolicitud = '$solicitudID'
		AND SAC.xt_tipo = 'ACCION'
		AND AC.xt_claveAccion = SAC.xt_claveAccion
	");
	while($h= $p -> fetchRow()){
		$NoclaveCorrectiva = $h[0];
	}

for($a = 0; $a <= count($claveCorrectiva); $a++){
			
	$s = $INTRANETV2->Execute("
			SELECT
				xt_titulo
			FROM
				SGI_Acciones_Preventivas_Correctivas_Etapas
			WHERE
				xt_codigoAccion = '$claveCorrectiva' 

				AND xt_titulo = 'EVALUACION'
		");
	while($t = $s->fetchRow()){
		$cierre        = $t[0];
	}			
	
	if($cierre != ''){			
			$conteo++;
	}
		
} unset($a);

if($NoclaveCorrectiva == $conteo){
	$INTRANETV2->Execute("
			UPDATE
				SGI_Quejas_Solicitudesv2 							
			SET
				xt_status = 'TERMINADA'
			WHERE
				xt_quejaSolicitud = '$solicitudID' 
		");

}

if(($_POST['status'] == 'ACCION') && ($_POST['fechaSolicitud'] != "") && ($_POST['codigoAccion'] != "")){
		
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaSolicitud']));
		
		$codigoAccion = trim($_POST['codigoAccion']);
		
		$INTRANETV2->Execute("INSERT INTO SGI_Quejas_Acciones_Correctivas(xt_quejaSolicitud, xt_claveAccion, xt_tipo, xt_descripcion, xt_usuario, xd_fecha) VALUES ('$solicitudID', '$codigoAccion', 'ACCION', '', '$usuarioId','$fechaSolicitud') ");
		header("Location: fichaQueja.php?codigo=$solicitudID");
	}

if(($_POST['status'] == 'EVALUACION') && ($_POST['fechaEvaluacion'] != "") || ($_POST['descripcionEvaluacion'] != "")){
		
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaEvaluacion']));
		
		$descripcionEva = trim($_POST['descripcionEvaluacion']);
		echo"INSERT INTO SGI_Quejas_Acciones_Correctivas(xt_quejaSolicitud, xt_claveAccion, xt_tipo, xt_descripcion, xt_usuario, xd_fecha) VALUES ('$solicitudID', '', 'EVALUACION','$descripcionEva','$usuarioId','$fechaInsert')";
		/*$INTRANET->Execute("INSERT INTO SGI_Quejas_Acciones_Correctivas(xt_quejaSolicitud, xt_claveAccion, xt_tipo, xt_descripcion, xt_usuario, xd_fecha) VALUES ('$solicitudID', '', 'EVALUACION','$descripcionEva','$usuarioId','$fechaInsert') ");
		header("Location: fichaQueja.php?codigo=$solicitudID");*/
	}
if(($_POST['status'] == 'RESPUESTA') && ($_POST['fechaRespuesta'] != "") || ($_POST['descripcionRespuesta'] != "")){
		
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaRespuesta']));
		
		$descripcionRes = trim($_POST['descripcionRespuesta']);
		
		echo "INSERT INTO SGI_Quejas_Acciones_Correctivas(xt_quejaSolicitud, xt_claveAccion, xt_tipo, xt_descripcion, xt_usuario, xd_fecha) VALUES ('$solicitudID', '', 'RESPUESTA','$descripcionRes','$usuarioId','$fechaInsert')";
		/*$INTRANET->Execute("INSERT INTO SGI_Quejas_Acciones_Correctivas(xt_quejaSolicitud, xt_claveAccion, xt_tipo, xt_descripcion, xt_usuario, xd_fecha) VALUES ('$solicitudID', '', 'RESPUESTA','$descripcionRes','$usuarioId','$fechaInsert') ");
		header("Location: fichaQueja.php?codigo=$solicitudID");*/
	}
if($_POST['pdr']!= "" && $_POST['status']!= ""){
	if($_POST['status'] == "ASIGNAR"){
		
		//actualizo registro en SGI_Quejas_Solicitudesv2 asignando el pdr 
  		if($INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_pdr ='".$_POST['pdr']."', xt_status = 'ASIGNADA' WHERE xt_quejaSolicitud = '$solicitudID'")){
  			
  			$INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_titulo, xt_contenido, xd_fecha, xt_ruta, kf_usuario) VALUES ('$solicitudID', 1, 'ASIGNADA', '', '', '".date("Y-m-d")."', '', '$usuarioId')");
  		
	  		$s = $INTRANET->Execute("SELECT
								xt_pdr,
								(select xt_nombre from IntranetGEA_USUARIOS where kp_usuario = xt_pdr),
								(select xt_correo from IntranetGEA_USUARIOS where kp_usuario = xt_pdr),
								xt_status	
							FROM
								SGI_Quejas_Solicitudesv2 
							WHERE
								xt_quejaSolicitud = '$solicitudID' ");
			
			while($j = $s->fetchRow()){
				$pdrNombre = $j[0];
				$pdrNombreCompleto = $j[1];
				$pdrCorreo = $j[2];	
				$statusSolicitud = $j[3];		
			}
			
			$enviaMail = new MailQuejas;
	  		$enviaMail->mailQuejasEnv($solicitudID, "", "", $pdrCorreo, $pdrNombreCompleto, "", "", "QuejaPdr");
			
			if($enviaMail == true){
			
			header("Location: https://escalanterca.com.mx/INTRANET_GEA/Backlog/solicitudesv2/enviaAcuseRecibo.php?codigoQ=$solicitudID&usuario=$usuarioId");
			}
	  	}
	}	
}
//echo "http://71.144.19.155/INTRANET_GEA/Backlog/enviaAcuseRecibo.php?codigoQ=$solicitudID&usuario=$usuarioId";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="../../../Imagenes/ICN_PestanaWebGE.png">
    <link type="text/css" href="../../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
	<script type="text/javascript" src="../../../JS/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="../../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript">;
	  $(function(){
		  $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
		   monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
		   dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
		  
		   });
	  });
    </script>
	<script>
		function show(valor){
			if(valor == 1){
				document.getElementById("causaRaiz1").style.display="none";
				document.getElementById("causaRaiz0").style.display="block";
				document.getElementById("causaRaizPdf").style.display="block";
			} else if (valor == 0){
				document.getElementById("causaRaiz1").style.display="block";
				document.getElementById("causaRaiz0").style.display="none";
				document.getElementById("causaRaizPdf").style.display="none";
			}
		}
	</script>
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
		
		function showADDPLAN(valor){
			if(valor == 1){
				document.getElementById("masControl1").style.display="none";
				document.getElementById("masControl2").style.display="block";
				document.getElementById("formSolicitud").style.display="block";
			} else if (valor == 0){
				document.getElementById("masControl1").style.display="block";
				document.getElementById("masControl2").style.display="none";
				document.getElementById("formSolicitud").style.display="none";
			}
		}
		
	</script> 
    
    
    <script>
		function muestraPDF(cual){
			
			if(cual == 1){
				
				document.getElementById("visualizaPDF").style.display="block";
				
			}
			
		}
	
	</script>
            
    <?php
	if($estiloUsuario == 1){
	  echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
	  echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>";
	}
	?>
	   
	<title>Queja</title>
</head>
<body>

<?php

$breadcrumb="<a href='../../../Home.php' id='breadcrumbs'>Home / </a><a href='../../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a> 
			<a href='tableroQuejas.php' id='breadcrumbs'> Quejas </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
echo"<div id='wrapperFicha' align='center'>";
	//codigo de menu navegable
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Queja</font>";
			echo"</td>";
		echo"</tr>";
			echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";

	echo "</table>";
				//banana de navegacion
		
		echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'><tr ><tdwidth='100%'>";
				  include("../../../navegacion_banana.php");
			  echo "</tr></td></table>
</div>";

		
	$perfil = array();
	//OBTENER LOS PERFILES DEL USUARIO CON LA SESION INICIADA
	$indexPerfil = 0;
	$r = $INTRANETV2->Execute("SELECT xt_perfil FROM SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");
	while($s = $r->fetchRow()){
		$perfil[$indexPerfil] = $s[0];
		$indexPerfil++;
	}
		
	echo "<table border='0' align='center'>";
		echo"<tr height='80px'><td></td></tr>";
	echo "</table>"; 
	
	
	///CUERPO CORRECTIVA
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td align='left' id='titulo2' width='250px'><b>".$solicitudID."</b></td>";
				echo "<td align='right' id='iconosTexto2' width='450px'>";
				$estatusQueja = $INTRANETV2->getOne("SELECT CONCAT(UCASE(LEFT(xt_status, 1)),LCASE(SUBSTRING(xt_status, 2))) FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");
					if($estatusQueja != ""){
						echo "Estatus: <b>".$estatusQueja."</b>";
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='2'></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td></td>";
				
				echo "<td id='iconosTexto' colspan='2' align='left'><b>".$tituloSolicitud."</b></td>";
				
				echo "<td id='iconosTexto' width='50px' align='right'>";
					if ($doctoSolicitud != NULL){
						echo "<a href='https://escalanterca.com.mx/INTRANET_GEA/Backlog/solicitudesv2/extraccionDoctos.php?codigo=$solicitudID&ruta=$doctoSolicitud'><img src='../../../Imagenes/ICN_Archivo.png'></a>";
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				echo "<td width='610px' align='justify' id='fileItem'>".nl2br($descripcionSolicitud)."</td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='4'></td></tr>";
		echo "</table>";
		
		//seccion de fecha de solicitud
		echo "<table border='0' align='center' width='700px'>";	
			  echo "<tr>";
				  echo "<td align='left' id='titulo2' colspan='2'>";
					  echo "<b>Fecha de solicitud</b>";
				  echo "</td>";
			  echo "</tr>";
			  
			  echo "<tr>";
				  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			  echo "</tr>";
			  
			  echo "<tr height='30px'><td colspan='2'></td></tr>";
			  
			  echo "<tr>";
				  echo "<td width='20px'></td>";
				  echo "<td align='left' width='680px' id='iconosTexto'>";
					  echo "<b>".$fechaSolicitud."</b>";
				  echo "</td>";
			  echo "</tr>";
			  
			  echo "<tr height='30px'><td colspan='2'></td></tr>";
		 echo "</table>";
		  
		 //seccion de solicitante
		echo "<table border='0' align='center' width='700px'>";	
			  echo "<tr>";
				  echo "<td align='left' id='titulo2' colspan='2'>";
					  echo "<b>Solicitante</b>";
				  echo "</td>";
			  echo "</tr>";
			  
			  echo "<tr>";
				  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			  echo "</tr>";
			  
			  echo "<tr height='30px'><td colspan='2'></td></tr>";
			  
			  echo "<tr>";
				  echo "<td width='20px'></td>";
				  echo "<td align='left' width='680px' id='iconosTexto'>";
					  echo "<b>".$nombreUsuarioSol = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioSolicitud'")."</b>";
				  echo "</td>";
			  echo "</tr>";
			  
			  echo "<tr height='30px'><td colspan='2'></td></tr>";
		  echo "</table>";
	
		 //seccion de solicitante
		echo "<table border='0' align='center' width='700px'>";	
			  echo "<tr>";
				  echo "<td align='left' id='titulo2' colspan='2'>";
					  echo "<b>Solicitante Original</b>";
				  echo "</td>";
			  echo "</tr>";
			  
			  echo "<tr>";
				  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			  echo "</tr>";
			  
			  echo "<tr height='30px'><td colspan='2'></td></tr>";
			  
			  echo "<tr>";
				  echo "<td width='20px'></td>";
				  echo "<td align='left' width='680px' id='iconosTexto'>";
					  echo "<b>".$solicitanteOriginal."</b>";
				  echo "</td>";
			  echo "</tr>";
			  
			  echo "<tr height='30px'><td colspan='2'></td></tr>";
		echo "</table>";
			
		///PDR
		if($pdrNombre != ""){
			echo "<table border='0' align='center' width='700px' cellspacing='0'>";
				echo "<tr>";
					echo "<td align='left' id='titulo2' colspan='2'><b>PDR (Persona Directamente Responsable)</b></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo "<tr>";
					echo "<td width='20px'></td>";
					echo "<td align='left' width='680px' id='iconosTexto'><b>".$nombrePDR = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdrNombre'")."</b></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
			echo "</table>";
		}else if(($pdrNombre == "") && $categoriaUsr == "Administrador"){
			echo "<table border='0' align='center' width='700px' cellspacing='0'>";	
				echo "<tr>";
					echo "<td align='left' id='titulo2' colspan='2'><b>PDR (Persona Directamente Responsable)</b></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo "<form name='agregarSeguimiento' method='POST' action='fichaQueja.php?codigo=$solicitudID' enctype='multipart/form-data'>";
					
					echo "<table border='0' align='center' width='700'>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Asignar PDR (Persona Directamente Responsable)</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
						echo "</tr>";
						
						echo"<tr height='15'> </tr>";
						
						echo "<tr align='left' height='20' >";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left' ><b>PDR</b></td>";	
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo "<tr align='left' height='20' >";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left' >";
								echo "<select name='pdr' size='1' >";
									echo "<option value=''>Elegir</option>";
									
									$s= $INTRANET->Execute("SELECT EMP.kf_usuario, EMP.xt_Nombre, EMP.xt_ApellidoPaterno 
															FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP 
															WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad='PDR' 
															ORDER BY EMP.xt_Nombre  ");
										
									while($r= $s -> fetchRow()){
								
										echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
								
									}unset($r); unset ($s);
								echo"</select>";		
								echo "<input type='hidden' name='status' value='ASIGNAR'>";
							echo "</td>";
			
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr height='20'><td colspan='5'></td> </tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
						echo "</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo"<tr height='40'>";
							echo "<td width='30'> </td>";
							echo"<td valign='bottom' align='right' colspan='4'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo "<tr height='30'>";
							echo "<td align='right' colspan='5'> </td>";
						echo "</tr>";
								
					echo "</table>";
				echo "</form>";
				
			echo "</table>";
		}
	if($pdrNombre != ''){
		///TRATAMIENTO
		echo "<table border='0' align='center' width='700'>";	
			echo"<tr>";
				echo"<td align='left' id='titulo2' data-title='Tratamiento'><b>Tratamiento</b></td>";
				echo"<td align='right' id='iconosTexto2'></td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
		echo "</table>";
		

		$p = $INTRANETV2->Execute("SELECT xt_descripcion, xd_fecha, xt_nombreArchivo, xt_ruta FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'ACUSE_RECIBO'");
		//echo "SELECT xt_descripcion, xd_fecha, xt_nombreArchivo, xt_ruta FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'ACUSE_RECIBO'";
					while($l = $p->fetchRow()){
						$fechaAcuse  = $l[1];
						$nombreAcuse = $l[2];
						$rutaAcuse = $l[3];
					}
		
		if($rutaAcuse != ''){
		echo "<table border='0' align='center' width='700px'>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td id='iconosTexto' colspan='2' align='left'>$fechaAcuse <b>Acuse de Recibo</b></td>";
							echo "<td id='iconosTexto' align='right'>";
							echo "</td>";
							
							echo "<td width='20px' id='iconosTexto' align='right'>";
								echo "<a href='https://escalanterca.com.mx/INTRANET_GEA/Backlog/solicitudesv2/extraccionDoctos.php?codigo=$solicitudID&ruta=$rutaAcuse'><img src='../../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a>";
						
								echo "</a>";
							echo "</td>";
					
						echo "</tr>";
				
						echo"<tr height='10px'> </tr>";
						
						echo "<tr height='20px'>";
							echo "<td width='20px'></td>";
							echo "<td width='20px'></td>";
							echo "<td width='610px' id = 'fileItem'>$descripcionRes</td>";
							echo "<td width='50px'></td>";
						echo "</tr>";
						
						echo"<tr height='25'> </tr>";
				echo "</table>";
		}
		
		$acuseRecibo = $INTRANETV2->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'ACUSE_RECIBO'");
		//$existeEvaluacion = $INTRANET->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'EVALUACION'");
		/*
		if($existeEvaluacion != ''){
		
		$p = $INTRANET->Execute("SELECT xt_descripcion, xt_usuario, xd_fecha, xt_nombreArchivo, xt_ruta FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'EVALUACION'");
			while($l = $p->fetchRow()){
				$descripcionEvalua = $l[0];
				$usuarioEvalua     = $l[1];
				$fechaEvalua       = $l[2];
				$nombreArchivo = $l[3];
				$rutaArchivo = $l[4];
			}
		//Seccion para plan de accion
		echo "<table border='0' align='center' width='700px'>";
				echo "<tr>";
					echo "<td></td>";
					echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEvalua <b>Evaluación Inicial</b></td>";
					echo "<td id='iconosTexto' align='right'>";
					echo "</td>";
					
					if($rutaArchivo != ''){
						echo "<td width='20px' id='iconosTexto' align='right' onclick='muestraPDF(1);'>";
							echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctos.php?codigo=$solicitudID&ruta=$rutaArchivo'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a>";
							//echo "<a href='downloadSeguimiento.php?file=".$rutaArchivo."'>";
								//echo "<img src='../../Imagenes/ICN_Archivo.png'>";
							echo "</a>";
						echo "</td>";
					}else{
						echo "<td width='20px' id='iconosTexto' align='right'>";
						echo "</td>";
					}
								
				echo "</tr>";
				
				echo "<tr height='20px'>";
					echo "<td width='20px'></td>";
					echo "<td width='20px'></td>";
					echo "<td width='610px'><font color='#848484'>Evalúo: $usuarioEvalua</td>";
					echo "<td width='50px'></td>";
				echo "</tr>";
				
				echo"<tr height='10px'> </tr>";
				
				echo "<tr height='20px'>";
					echo "<td width='20px'></td>";
					echo "<td width='20px'></td>";
					echo "<td width='610px' id = 'fileItem'>$descripcionEvalua</td>";
					echo "<td width='50px'></td>";
				echo "</tr>";
				
				echo"<tr height='25'> </tr>";
		echo "</table>";
		
		
		//seccion donde se muestra el pdf
		
		
		echo "<table border='0' id= 'visualizaPDF' align='center' width='750px' style='display:none;'>";
			echo "<tr>";
				echo "<td align='center' width='950px'>";
				
				
					if(substr($rutaArchivo, -4) == ".pdf"){
						
						
						//mostramos archivo pdf
						
						$conexion = ftp_connect($ftp_server, 21) or ("No se pudo conectar a $ftp_server <br><br>");
						// intentar iniciar sesión
						if (ftp_login($conexion, $ftp_user, $ftp_pass)) {
							//echo "Conectado como $ftp_user $ftp_server <br><br>";
						} else {
							echo "No se pudo conectar como $ftp_user <br><br>";
						}
						
						
						echo '<embed src="ftp://Imagenes:Img2012Server@71.144.19.155/'.$ubicacionPDF.'" width="600" height="550" type="application/pdf">';
					 
						
						
						
					}
				
				echo "</td>";
			echo "</tr>";
		echo "</table>";
						
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='10px'>";
				echo "<td></td>";
			echo "</tr>";
		echo "</table>";
		
		//fin de seccion donde se muestra el pdf
		
		
		
		
		}else{
			echo "<table border='0' height='50px' style='width: 700px' cellspacing='0'>";
				echo "<tr>";
					echo "<td>";
						//echo "<div id='divFile'>";
							echo "<iframe src='http://71.144.19.155/INTRANET_GEA/Backlog/uploadArchivosQuejasLaredo.php?codigoSolicitud=$solicitudID&tipoArchivo=EVALUACION&usuario=$usuarioId&nombrephp=$nombrephp' frameborder='0' width='800px' height='340px'></iframe><br>";
						//echo "</div>";
					echo"</td>";
				echo "</tr>";
			echo "</table>";
			
			
			
			/*echo "<form method='post' action='fichaQueja.php?codigo=$solicitudID' enctype='multipart/form-data'>";
						echo "<table border='0' align='center' width='700px'>";
							echo "<tr>";
								echo "<td></td>";
								echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>	Evaluación inicial</b></td>";
							echo "</tr>";
							
							echo "<tr>";
								echo "<td></td>";
								echo "<td colspan='4' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
							echo "<tr height='15px'>";
								echo "<td colspan='5'></td>";
							echo "</tr>";
							
							echo "<tr align='left' height='20px'>";
								echo "<td width='30px'></td>";
								echo "<td width='20px'></td>";
								echo "<td width='100px' id='iconosTexto2' align='left'>Fecha</td>";
								//echo "<td width='530px' id='iconosTexto2' align='left'>Archivo</td>";
								echo "<td width='20px'></td>";
							echo "</tr>";
							
							echo "<tr height='10px'>";
								echo "<td colspan='5'></td>";
							echo "</tr>";
							
							echo "<tr align='left'>";
								echo "<td></td>";
								echo "<td></td>";
						
								echo "<td  align='left'>";
									echo "<input type='text' class='DatP' size='10' maxlength='10' name='fechaEvaluacion'>";
									echo "<input type='hidden' name='status' value='EVALUACION'>";
								echo "</td>";
								
							echo"<tr height='20'> ";
								echo "<td width='30'> </td>";
								echo "<td width='20'> </td>";
								echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
									echo"Descripción";
								echo"</td>";
								echo "<td width='20'> </td>";
							echo"</tr>";
							
							echo"<tr> ";
								echo "<td width='30'> </td>";
								echo "<td width='20'> </td>";
								echo"<td valign='bottom' align='left' colspan='2'>";
									echo"<textarea name='descripcionEvaluacion' style='width: 600px; height: 100px;'></textarea>";
								echo"</td>";
								echo "<td width='20'> </td>";
							echo"</tr>";
							
							echo "<tr height='15px'>";
								echo "<td colspan='5'></td>";
							echo "</tr>";
							
							echo "<tr>";
								echo "<td></td>";
								echo "<td colspan='4' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
							echo "<tr height='10px'>";
								echo "<td colspan='5'></td>";
							echo "</tr>";
							
							echo "<tr height='40px'>";
								echo "<td></td>";
								echo "<td valign='bottom' align='right' colspan='4'>";
									echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='30px'>";
								echo "<td align='right' colspan='5'></td>";
							echo "</tr>";
									
						echo "</table>";
						
						echo "</form>";*/
	//	}
	
		$fechaPlanAccion = $INTRANETV2->getOne("SELECT MIN(xd_fecha) FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'ACCION'");
		 
		if($acuseRecibo != '' || $fechaPlanAccion != ''){
		
		//Seccion para plan de accion
		echo "<table border='0' align='center' width='700px'>";
				echo "<tr>";
					echo "<td></td>";
					//$fechaPlanAccion = $INTRANET->getOne("SELECT MIN(xd_fecha) FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'ACCION'");
		
					echo "<td id='iconosTexto' colspan='2' align='left'>".$fechaPlanAccion." <b>Plan de acción</b></td>";
					echo "<td id='iconosTexto' align='right'>";
				///CONDICION USER BOTON AGREGAR
						//if($usuarioId == 'Alberto_Martinez'){
								
							echo "<img src='../../../Imagenes/ICN_BotonMas.png' height='15px' width='15' onclick='showADDPLAN(1);' id='masControl1' style='display:block;'>";
							echo "<img src='../../../Imagenes/ICN_BotonMas.png' height='15px' width='15' onclick='showADDPLAN(0);' id='masControl2' style='display:none;'>";
						//}
					
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'>";
					echo "<td width='20px'></td>";
					echo "<td width='20px'></td>";
					echo "<td width='610px'></td>";
					echo "<td width='50px'></td>";
				echo "</tr>";
				
				echo"<tr height='10px'> </tr>";
	
		echo "</table>";
		
		
		///CONDICION DE TERMINO AGREGAR SOLICITUDES USER AGREGAR SOLICITUD		
					echo "<form method='post' action='fichaQueja.php?codigo=$solicitudID' id='formSolicitud' style='display:none;'>";
						echo "<table border='0' align='center' width='700px'>";
							echo "<tr>";
								echo "<td></td>";
								echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Agregar Acción Correctiva</b></td>";
							echo "</tr>";
							
							echo "<tr>";
								echo "<td></td>";
								echo "<td colspan='4' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
							echo "<tr height='20px'>";
								echo "<td colspan='5'></td>";
							echo "</tr>";
							
							echo "<tr align='left' height='20px'>";
								echo "<td width='30px'></td>";
								echo "<td width='20px'></td>";
								echo "<td width='100px' align='left' id='iconosTexto2'>Fecha</td>";
								echo "<td width='530px' align='left' id='iconosTexto2'>Código</td>";
								echo "<td width='20px'></td>";
							echo "</tr>";
							
							echo "<tr align='left'>";
								echo "<td></td>";
								echo "<td></td>";
								
								echo "<td align='left'>";
									echo "<input type='text' class='DatP' size='10' maxlength='10' name='fechaSolicitud'>";
									echo "<input type='hidden' name='status' value='ACCION'>";
								echo "</td>";
								
								echo "<td align='left'>";
									echo "<input type='text' size=20 maxlength=100 name='codigoAccion'>";
								echo "</td>";
								
								echo "<td></td>";
							echo "</tr>";
							
							echo "<tr height='20px'>";
								echo "<td colspan='5'></td>";
							echo "</tr>";
							
							echo "<tr>";
								echo "<td></td>";
								echo "<td colspan='4' id='titleBlueLineBottom'></td>";
							echo "</tr>";
							
							echo "<tr height='10px'><td colspan='5'></td></tr>";
							
							echo "<tr height='40px'>";
								echo "<td></td>";
								echo "<td valign='bottom' align='right' colspan='4'>";
									echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='30px'>";
								echo "<td align='right' colspan='5'></td>";
							echo "</tr>";
						echo "</table>";
					echo "</form>";
					
			///FIN CONDICION FORM AGREGAR SOLICITUD
			//	}
	
		//Seccion para Plan de accion
		echo "<table border='0' align='center' width='700px'  id='planes'>";
			echo "<tr height='5px'>";
				echo "<td width='20px'></td>";
				echo "<td width='50px'></td>";
				echo "<td width='250px'></td>";
				echo "<td width='130px'></td>";
				echo "<td width='150px'></td>";
				echo "<td width='100px'></td>";
			echo "</tr>";
			
			echo "<tr height='5px'>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td align='left' id='tituloAzul14B'>Actividad</td>";
				echo "<td align='center' id='tituloAzul14B'>Acción Correctiva</td>";
				echo "<td align='center' id='tituloAzul14B'>Responsable</td>";
				echo "<td align='center' id='tituloAzul14B'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td colspan='4' id='titleBlueLineTop'></td>";
			echo "</tr>";
			
			echo "<tr height='5px'>";
				echo "<td colspan='6'></td>";
			echo "</tr>";
		echo "</table>";
		
		//Seccion para Plan de accion
		$s= $INTRANETV2->Execute("SELECT
								AC.xt_claveAccion,
								AC.xt_titulo,
								(SELECT E.xt_nombreCorto FROM IntranetGEA.SGI_Empleados E WHERE E.kf_usuario = AC.xt_pdr LIMIT 1),
								SAC.xd_fecha
							FROM
								SGI_Quejas_Acciones_Correctivas SAC,
								INTRANET2.SGI_Acciones_Preventivas_Correctivas AC
							WHERE
								SAC.xt_quejaSolicitud = '$solicitudID'
							AND SAC.xt_tipo = 'ACCION'
							AND AC.xt_claveAccion = SAC.xt_claveAccion");
						while($r= $s -> fetchRow()){
							$claveCorrectiva = $r[0];
							$tituloAccion    = $r[1];
							$pdrAccion       = $r[2];
							$fechaAccion     = $r[3];
							//$idAccionCorrectiva = $r[4];
				
				echo "<table border='0' align='center' width='700px'>";
					echo "<tr height='5px'>";
						echo "<td width='50px'></td>";
						echo "<td width='200px'></td>";
						echo "<td width='100px'></td>";
						echo "<td width='100px'></td>";
						echo "<td width='50px'></td>";
					echo "</tr>";
					
					$fichaCorrectiva	= "<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaCorrectivav2.php?id=".$claveCorrectiva."' style='text-decoration:none;' >".$claveCorrectiva."</a>";
	
					
					echo "<tr height='5px'>";
						echo "<td width='50px'></td>";		
						echo "<td width='200px' valign='top' align='left' id='iconosTexto3'>$tituloAccion</td>";
						echo "<td width='100px' valign='top' align='left' id='iconosTexto3'>$fichaCorrectiva</td>";
						echo "<td width='100px' valign='top' align='left' id='iconosTexto3'>".$pdrAccion."</td>";
						echo "<td width='50px' valign='top' align='left' id='iconosTexto3'>$fechaAccion</td>";
								
					echo "</tr>";
					
					echo "<tr height='5px'>";
						echo "<td colspan='6'></td>";
					echo "</tr>";
				echo "</table>";
				}
		
		
		
		echo "<table boder='0' align='center' width='300px'>";
			  echo "<tr height='15px'><td></td></tr>";
		  echo "</table>";
	
		  echo "<table border='0' align='center' width='700px'>";
				  echo "<tr>";
					  echo "<td width='70px'></td>";
					  echo "<td width='630px'colspan='4' id='titleBlueLineTop'></td>";
				  echo "</tr>";	 
			  echo "</table>";	
			  
		  echo "<table boder='0' align='center' width='300px'>";
			  echo "<tr height='40px'><td></td></tr>";
		  echo "</table>";
		
	}	
	   $existeRespuesta = $INTRANETV2->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'ACCION'");
		
		if($existeRespuesta != ''){
			$existeRes = $INTRANETV2->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'RESPUESTA'");
			if($existeRes != ''){
		
				$p = $INTRANETV2->Execute("SELECT xt_descripcion, xt_usuario, xd_fecha, xt_nombreArchivo, xt_ruta FROM SGI_Quejas_Acciones_Correctivas WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'RESPUESTA'");
					while($l = $p->fetchRow()){
						$descripcionRes    = $l[0];
						$usuarioRes        = $l[1];
						$fechaRes          = $l[2];
						$nombreARes = $l[3];
						$rutaRes = $l[4];
					}
					
				echo "<table border='0' align='center' width='700'>";	
					echo"<tr>";
						echo"<td align='left' id='titulo2'><b>Respuesta y Comunicación de la decisión</b></td>";
						echo"<td align='right' id='iconosTexto2'></td>";
					echo"</tr>";
					
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='2'></td>";
					echo "</tr>";
					
					echo"<tr height='15'> </tr>";
				echo "</table>";
				//Seccion para plan de accion
				echo "<table border='0' align='center' width='700px'>";
						echo "<tr>";
							echo "<td></td>";
							echo "<td id='iconosTexto' colspan='2' align='left'>$fechaRes <b>Respuesta y Comunicación de la decisión</b></td>";
							echo "<td id='iconosTexto' align='right'>";
							echo "</td>";
							
							if($rutaRes != ''){
								echo "<td width='20px' id='iconosTexto' align='right'>";
									echo "<a href='https://escalanterca.com.mx/INTRANET_GEA/Backlog/solicitudesv2/extraccionDoctos.php?codigo=$solicitudID&ruta=$rutaRes'><img src='../../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a>";
							
									echo "</a>";
								echo "</td>";
							}else{
								echo "<td width='20px' id='iconosTexto' align='right'>";
								echo "</td>";
							}
					
						echo "</tr>";
						
						echo "<tr height='20px'>";
							echo "<td width='20px'></td>";
							echo "<td width='20px'></td>";
							echo "<td width='610px'><font color='#848484'>Respuesta de: $usuarioRes</td>";
							echo "<td width='50px'></td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
						
						echo "<tr height='20px'>";
							echo "<td width='20px'></td>";
							echo "<td width='20px'></td>";
							echo "<td width='610px' id = 'fileItem'>".nl2br($descripcionRes)."</td>";
							echo "<td width='50px'></td>";
						echo "</tr>";
						
						echo"<tr height='25'> </tr>";
				echo "</table>";
			}else{
				
				echo "<table border='0' align='center' height='50px' style='width: 850px' cellspacing='0'>";
					echo "<tr>";
						echo "<td>";
							//echo "<div id='divFile'>";
								echo "<iframe src='https://escalanterca.com.mx/INTRANET_GEA/Backlog/solicitudesv2/uploadArchivosQuejasLaredo.php?codigoSolicitud=$solicitudID&tipoArchivo=RESPUESTA&usuario=$usuarioId&nombrephp=$nombrephp' frameborder='0' width='800px' height='340px'></iframe><br>";
							//echo "</div>";
						echo"</td>";
					echo "</tr>";
				echo "</table>";
	
				
		}
		}
			$s = $INTRANETV2->execute("SELECT
											xt_titulo,
											xd_fecha,
											xt_usuario,
											xt_contenido
										FROM
											SGI_Acciones_Preventivas_Correctivas_Etapas
										WHERE
											xt_codigoAccion in (SELECT
																AC.xt_claveAccion
																FROM
																SGI_Quejas_Acciones_Correctivas SAC,
																SGI_Acciones_Preventivas_Correctivas AC
																WHERE
																SAC.xt_quejaSolicitud = '$solicitudID'
																AND SAC.xt_tipo = 'ACCION'
																AND AC.xt_claveAccion = SAC.xt_claveAccion
																)
											AND xt_titulo = 'EVALUACION' and xt_contenido != ''
									");
								while($t = $s->fetchRow()){
									$cierre        = $t[0];
									$fechaCierre   = $t[1];
									$usuarioCierre = $t[2];
									$descripcionCierre = $t[3];
								}
					if($cierre != ''){				
					echo "<table border='0' align='center' width='700'>";	
								echo"<tr>";
									echo"<td align='left' id='titulo2'><b>Cierre de la queja</b></td>";
									echo"<td align='right' id='iconosTexto2'></td>";
								echo"</tr>";
								
								echo "<tr>";
									echo "<td id='titleBlueLineBottom' colspan='2'></td>";
								echo "</tr>";
								
								echo"<tr height='15'> </tr>";
							echo "</table>";
							//Seccion para plan de accion
							echo "<table border='0' align='center' width='700px'>";
									echo "<tr>";
										echo "<td></td>";
										echo "<td id='iconosTexto' colspan='2' align='left'>$fechaCierre <b>Cerrado</b></td>";
										echo "<td id='iconosTexto' align='right'>";
										echo "</td>";
										echo "<td width='20px' id='iconosTexto' align='right'>";
										echo "</td>";
			
									echo "</tr>";
									
									echo "<tr height='20px'>";
										echo "<td width='20px'></td>";
										echo "<td width='20px'></td>";
										echo "<td width='610px'><font color='#848484'>Cerrado por: $usuarioCierre</td>";
										echo "<td width='50px'></td>";
									echo "</tr>";
									
									echo"<tr height='10px'> </tr>";
									
									echo "<tr height='20px'>";
										echo "<td width='20px'></td>";
										echo "<td width='20px'></td>";
										echo "<td width='610px' id = 'fileItem'>$descripcionCierre</td>";
										echo "<td width='50px'></td>";
									echo "</tr>";
									
									echo"<tr height='25'> </tr>";
							echo "</table>";
					}
		}
	
	//cierre de la interfaz
	echo "<table boder='0' align='center' width='700px'>";
		echo "<tr height='15px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td width='630px'colspan='4' id='titleBlueLineTop'></td>";
			echo "</tr>";	 
	echo "</table>";	
	
	
	echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td align='center' style='color:#636262;'>Created by: Grupo Escalante Agencias Aduanales</td>";
			echo "</tr>";	 
	
		echo "<tr height='45px'></tr>";
	
	echo "</table>";
echo "</div>";
	
?>
</body>
</html>



<?php
$nombrephp='fichaSolicitudv2.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("../../../compruebaUsuario.php");
require_once("MailSolicitudAsignarAdm.php");
require_once("MailSolicitudRevisar.php");
require_once("MailSolicitudRechazar.php");
error_reporting(E_PARSE);

$solicitudID = $_GET["codigo"];

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");


// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

function limpiar_caracter_especial($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );


    return $string;
}

///DATOS DE LA SOLICITUD
$clave 				= "";
$titulo 			= "";
$descripcion 		= "";
$ruta 				= "";
$solicitanteID 		= "";
$fechaSolicitud 	= "";
$nombreSolicitante	= "";
$apllPaSolicitante 	= "";
$apllMaSolicitante 	= "";
$fechaCreacion 		= "";

$s = $INTRANETV2->Execute("SELECT xt_quejaSolicitud, xt_titulo, xt_descripcion, xt_ruta, kf_usuarioId, xd_fecha, xt_ciudad FROM SGI_Quejas_Solicitudesv2 
						WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'B' ");

while($r = $s->fetchRow()){
	
	$clave 				= $r[0];
	$titulo 			= $r[1];
	$descripcion 		= nl2br ($r[2]);
	$ruta 				= $r[3];
	$solicitanteID 		= $r[4];
	
	if($solicitanteID != ""){
				
		$u = $INTRANET->Execute("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$solicitanteID'");
		
		while($t = $u->fetchRow()){
			$nombreSolicitante = $t[0];
			
		} unset($t); unset($u);
		
	}
	
	$fechaSolicitud 	= date('Y-m-d', strtotime($r[5]));
	$fechaCreacion		= $fechaSolicitud;
	
	$ciudad = $r[6];
	
} unset($r); unset($s);

unset($temp);


///PDR
$pdrNombre = "";
$pdrApPate = "";
$pdrApMate = "";
$pdrUserId = "";					
						
$s = $INTRANETV2->Execute("SELECT IU.xt_nombre, SQS.xt_pdr FROM SGI_Quejas_Solicitudesv2 SQS, IntranetGEA.IntranetGEA_USUARIOS IU 
						WHERE SQS.xt_tipo = 'B' AND SQS.xt_quejaSolicitud = '$solicitudID' AND SQS.xt_pdr = IU.kp_usuario ");


while($r = $s->fetchRow()){
	$pdrNombre = $r[0];
	$pdrUserId = $r[1];
	//$pdrApPate = $r[1];
	//$pdrApMate = $r[2];
	
	
} unset($r); unset($s);


///AUDITORIA ISSUE
$auditoriaID 		= "";
$auditoriaCodigo 	= "";
$issueID 			= "";
$issueCodigo 		= "";

$s = $INTRANET->Execute("SELECT A.kp_auditoriaID, A.xt_claveAuditoria, AI.kp_issueID, AI.xt_claveIssue FROM SGI_Auditorias_Issues AI, SGI_Auditorias A 
						WHERE A.xt_claveAuditoria = '$clave' AND AI.kf_auditoriaID = A.kp_auditoriaID ");
						
while($r = $s->fetchRow()){
	$auditoriaID 		= $r[0];
	$auditoriaCodigo 	= $r[1];
	$issueID 			= $r[2];
	$issueCodigo 		= $r[3];
	
} unset($r); unset($s);

///SEGUIMIENTO
$codigo = "";
$id 	= "";

	////los estatus siguientes que seran mandados a AgregarSeguimientoSolicitud.php
	$estatusMax = 0;
	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' ");
	
	while($r = $s->fetchRow()){
		
		$estatusMax = $r[0];
		
	} unset($r); unset($s);
	
	$estatusMax++;
	
	if($estatusMax == 1){
		
		$estatus = "ASIGNAR";
	
	} else if(($estatusMax == 2) || ($estatusMax%2 == 0)){
		
		$estatus = "REVISION";
		
	} else if($estatusMax%2 == 1){
		
		$estatus = "EVALUACION";
		
	}else{
	
	$estatus = "ASIGNAR";
}

$solcitudEstatus 	= "";
$show 				= "";
$numeroEtapa		= NULL;
$estatusEtapa		= NULL;
$contenidoEtapa		= NULL;
$fechaEtapa 		= NULL;
$rutaEtapa 			= NULL;

$s = $INTRANETV2->Execute("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' ");

while($r = $s->fetchRow()){
	
	$solcitudEstatus = $r[0];
	
} unset($r); unset($s);

$i 		= 1;
					
$s = $INTRANETV2->Execute("SELECT xn_numero, xt_estatus, xt_contenido, xd_fecha, xt_ruta FROM SGI_Quejas_Solicitudes_Estatusv2 
						WHERE xt_quejaSolicitud = '$solicitudID' ORDER BY xn_numero ");
		
while($r = $s->fetchRow()){
	
	$numeroEtapa[$i]	= $r[0];
	$estatusEtapa[$i]	= $r[1];
	$contenidoEtapa[$i]	= $r[2];
	$fechaEtapa[$i] 	= date('Y-m-d', strtotime($r[3]));
	$rutaEtapa[$i] 		= $r[4];
	
	if($estatusEtapa[$i] == "SIN ASIGNAR"){
		$show = "Sin Asignar";
		
	}else if($estatusEtapa[$i] == "ASIGNADA"){
		$show = "Asignada";
		
	} else if($estatusEtapa[$i] == "REVISION"){
		$show = "Para Revisión";
		
	} else if($estatusEtapa[$i] == "RECHAZADA"){
		$show = "Rechazada";
		
	} else if($estatusEtapa[$i] == "TERMINADA"){
		$show = "Terminada";
		
	}
	
	$i++;
	
}unset($r); unset($s); unset($i);


$stats = @$_POST['status'];

if((@$stats == "ASIGNAR") && (@$_POST['pdr'] != "") && (@$_POST['fechaAsignar'] != "")){
				
	$pdrInsert 		= $_POST['pdr'];
	$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaAsignar']));
	
	$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_pdr = '$pdrInsert' WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipo = 'B' ");
	
	
		if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) 
																VALUES('$solicitudID', 2, 'ASIGNADA', '$fechaInsert', '$usuarioId') ")){
																	
		$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'ASIGNADA' WHERE xt_quejaSolicitud = '$solicitudID' ");
																
		$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrInsert' ");
		$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrInsert' ");
	
		$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$solicitanteID."' ");
		$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$solicitanteID."' ");
		
		if(($correoPDRMail != "") && ($nombrePDRMail != "")){
	
			$enviarMailAsigna = new MailSolicitudAsignarAdm();
			$enviarMailAsigna->mailSolicitudAsignarAdmIntra($clave, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion);
			
		}	
	}															 
															 
	echo"<script language='javascript'>window.location='fichaSolicitudv2.php?codigo=".urlencode($solicitudID)."'</script>;";	
															
	
}else if((@$stats == "REVISION") && (@$_POST['fechaRevision'] != "") && (@$_POST['descripcionRevision'] != "")){
	
		$fechaInsert		= date('Y-m-d', strtotime($_POST['fechaRevision']));
		$descripcionInsert 	= nl2br($_POST['descripcionRevision']);
		
		$estatusMax 	= 0;
		
		$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' ");
		
		while($r = $s->fetchRow()){
			
			$estatusMax = $r[0];
			
		} unset($r);
		
	
		$estatusMax++;
	
		if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) 
																VALUES('$solicitudID', '$estatusMax' , 'REVISION', '$descripcionInsert', '$fechaInsert', '$usuarioId') ")){
																	
			$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'REVISION' WHERE xt_quejaSolicitud = '$solicitudID' ");
			
			$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$solicitanteID' ");
			$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$solicitanteID' ");
			
			$enviarMailRev = new MailSolicitudRevisar();
			
			$enviarMailRev->mailSolicitudRevisarIntra($clave, $correoSolicitante, $nombreSolicitante, $descripcionInsert);
			
			echo"<script language='javascript'>window.location='fichaSolicitudv2.php?codigo=".urlencode($solicitudID)."'</script>;";
		}
		
		$archivo = $_FILES['archivoRevision']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			$destino = "../../SeguimientoEtapas/$archivo";
			
			if (move_uploaded_file($_FILES['archivoRevision']['tmp_name'], $destino)){
				
				$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$archivo' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = $estatusMax  ");
				
			}
		}
		echo"<script language='javascript'>window.location='fichaSolicitudv2.php?codigo=".urlencode($solicitudID)."'</script>;";

		/*$extension = pathinfo($_FILES['archivoRevision']['name'], PATHINFO_EXTENSION);  
		 
		if($extension != ''){
				
			$ruta = "D:/INTRANET/documentosSolicitudes/";
			$directorioCompleto = $ruta.$solicitudID;
			# si exsite la carpeta o se ha creado
			if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
				
				$nombreNuevo = "Revision_".($estatusMax-1).$solicitudID.".".$extension;
				$nombreArchivo = $directorioCompleto."/".$nombreNuevo;
				
				if (@move_uploaded_file($_FILES['archivoRevision']['tmp_name'], $nombreArchivo)){
		
					$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$nombreArchivo' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = $estatusMax ");
					
				}
			}
				echo"<script language='javascript'>window.location='fichaSolicitudv2.php?codigo=".urlencode($solicitudID)."'</script>;";		
		}
	*/
	
}else if((@$stats == "EVALUACION") && (@$_POST['fechaEvaluacion'] != "") && (@$_POST['evaluacion'] != "")){
	
		$fechaInsert		= date('Y-m-d', strtotime($_POST['fechaEvaluacion']));
		$descripcionInsert 	= nl2br($_POST['descripcionEvaluacion']);
		$evaluacion 		= $_POST['evaluacion'];		
		
		$estatusMax 	= 0;
		
		$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' ");
		
		while($r = $s->fetchRow()){
			
			$estatusMax = $r[0];
			
		} unset($r);
		
		$estatusMax++;
		
																
		if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) 
																VALUES('$solicitudID', '$estatusMax' , '$evaluacion', '$descripcionInsert', '$fechaInsert', '$usuarioId') ")){
																	
			$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$evaluacion' WHERE xt_quejaSolicitud = '$solicitudID' ");
			
			if($evaluacion == "RECHAZADA"){
				
				$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
				$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
			
				$enviaMailRechaza = new MailSolicitudRechazar();
				$enviaMailRechaza->mailSolicitudRechazarIntra($clave, $correoPDRMail, $nombrePDRMail, $descripcionInsert);
				
			}
		}
		
		$archivo = $_FILES['archivoEvaluacion']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			$destino = "../../SeguimientoEtapas/$archivo";
			
			if (move_uploaded_file($_FILES['archivoEvaluacion']['tmp_name'], $destino)){
				
				$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$archivo' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = $estatusMax  ");
	
				//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatus SET xt_ruta = '$archivo' WHERE kp_estatusID = $estatusMax ");
				
			}
		}
		
		echo"<script language='javascript'>window.location='fichaSolicitudv2.php?codigo=".urlencode($solicitudID)."'</script>;";
		//header("Location: fichaSolicitud.php?id=$solicitudID");
	/*
	 $extension = pathinfo($_FILES['archivoEvaluacion']['name'], PATHINFO_EXTENSION);  
	 if($extension != ''){
			
		$ruta = "D:/INTRANET/documentosSolicitudes/";
		$directorioCompleto = $ruta.$solicitudID;
		# si exsite la carpeta o se ha creado
		if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
			
			//cambio nombre de archivo
			if($evaluacion == 'TERMINADA'){
			   $nombreNuevo = "Evaluacion_".$solicitudID.".".$extension;
			}else if($evaluacion == 'RECHAZADA'){
				$nombreNuevo = "Rechazada_".$solicitudID.".".$extension;
			}
					
			$nombreArchivo = $directorioCompleto."/".$nombreNuevo;
			
			
			if (@move_uploaded_file($_FILES['archivoEvaluacion']['tmp_name'], $nombreArchivo)){

				$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$nombreArchivo' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = $estatusMax ");
			
			}
		}
	 }
	echo"<script language='javascript'>window.location='fichaSolicitudv2.php?codigo=".urlencode($solicitudID)."'</script>;";	*/
}

?>
<?php
$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='../../comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes</a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
        <title><?php echo $clave; ?></title>
		<?php
		if($estiloUsuario == 1){
			?>
			<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>
            <?php
		}else if($estiloUsuario == 2){
			?>
			<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>
            <?php
		}
		?>
        
        <link rel="shortcut icon" type="image/x-icon" href="../../../Imagenes/ICN_PestanaWebGE.png">
        <link type="text/css" href="../../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
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
        
        <script type="text/javascript">
            function reCargarPadre(){
                opener.location.reload();
                window.close();
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
    </head>
    <body>
<?php

echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Fecha de última actualización: ";
					if($fechaEtapa != NULL){
						$num = count($fechaEtapa);
						echo "$fechaEtapa[$num]";
					}else{
						echo "$fechaSolicitud";
					}
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";

		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Solicitud</font>";
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
	

	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../../navegacion_banana.php");
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

		
	//CUERPO SOLICITUD
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2' width='550'><b>$clave</b></td>";
			echo"<td align='right' id='iconosTexto2' width='150'>";
				if($show != ""){
					echo "<b>Status: $show</b>";
				}
			echo"</td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>$titulo</b></td>";
				if($ruta != NULL){
					echo"<td id='iconosTexto' width='50' align='right'><a href='../../downloadQuejaSolicitud.php?file=$ruta'><img src='../../../Imagenes/ICN_Archivo.png'></a> </td>";
				}else {
				echo"<td id='iconosTexto' width='50' align='right'></td>";
				}
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='20'> </td>";
			echo "<td width='20'> </td>";
			echo "<td width='610' align='justify' id='fileItem'>$descripcion</td><td></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	///SOLICITANTE
	if($solicitanteID != ""){
		echo "<table border='0' align='center' width='700'>";	
			echo "<tr>";
				echo "<td align='left' id='titulo2' colspan='2'><b>Solicitante</b></td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td align='left' width='680px' id='iconosTexto'><b>$nombreSolicitante</b></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
		echo "</table>";
	}
	
	///PDR
	if($pdrNombre != ""){
		echo "<table border='0' align='center' width='700'>";	
			echo "<tr>";
				echo "<td align='left' id='titulo2' colspan='2'><b>PDR (Persona Directamente Responsable)</b></td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td align='left' width='680px' id='iconosTexto'><b>$pdrNombre</b></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
		echo "</table>";
	}
	//AUDITORIA E ISSUE
	if($auditoriaID != ""){
		echo "<table border='0' align='center' width='700'>";			
			echo"<tr>";
				echo"<td align='left'  id='titulo2'><b>Auditoría relacionada</b></td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' width='700'></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='700'>";
			
			echo "<tr>";
				echo "<td width='40'> </td>";
				echo "<td id='fichaRef' width='660'><b><a href='../../../SistemaGestionIntegral/FichaAuditoria.php?id=$auditoriaID' id='fichaRef'>$auditoriaCodigo</a>, 
							Issue <a href='../../../SistemaGestionIntegral/fichaIssue.php?id=$issueID' id='fichaRef'>$issueCodigo</a></b></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
		echo "</table>";
	
	}
	
	///SEGUIMIENTO
	echo "<table border='0' align='center' width='700'>";	
		echo"<tr>";
			echo"<td align='left' id='titulo2'><b>Seguimiento</b></td>";
			echo"<td align='right' id='iconosTexto2'><b>$codigo</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='15'> </tr>";
	echo "</table>";
		
	if(count($numeroEtapa) >= 1){
			
		  for($a = 1; $a <= count($numeroEtapa); $a++){
			  
			  $show = "";
			  
			  if($estatusEtapa[$a] == "SIN ASIGNAR"){
				  $show = "Sin Asignar";
				  
			  } else if($estatusEtapa[$a] == "ASIGNADA"){
				  $show = "Asignada";
				  
			  } else if($estatusEtapa[$a] == "REVISION"){
				  $show = "Para Revisión";
				  
			  } else if($estatusEtapa[$a] == "RECHAZADA"){
				  $show = "Rechazada";
				  
			  } else if($estatusEtapa[$a] == "TERMINADA"){
				  $show = "Terminada";
				  
			  }
			
			  echo "<table border='0' align='center' width='700'>";
				  echo "<tr>";
					  echo "<td> </td>";
					  echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa[$a] <b>$show</b></td>";
					 	
						 if ($rutaEtapa[$a] != NULL){
						  
						  echo "<td id='iconosTexto' width='50' align='right'>";
							  echo "<a href='../../downloadSeguimientoSolicitudQueja.php?file=$rutaEtapa[$a]'>";
								  echo "<img src='../../../Imagenes/ICN_Archivo.png'>";
							  echo "</a>";
						  echo "</td>";
						  
					  }else {
						  
						  echo "<td id='iconosTexto' width='50' align='right'></td>";
						  
					  }
				  echo "</tr>";
				  
				  echo"<tr height='10'> </tr>";
				  
				  if($estatusEtapa[$a] == "SIN ASIGNAR" || $estatusEtapa[$a] == "ASIGNADA"){
					  
					  echo "<tr>";
						  echo "<td width='20'> </td>";
						  echo "<td width='20'> </td>";
						  echo "<td width='610' align='justify' id='fileItem'></td><td></td>";
					  echo "</tr>";

				  } else{
					  
					  echo "<tr>";
						  echo "<td width='20'> </td>";
						  echo "<td width='20'> </td>";
						  echo "<td width='610' align='justify' id='fileItem'>$contenidoEtapa[$a]</td><td></td>";
					  echo "</tr>";
					  
				  }
				  
				  echo"<tr height='10'> </tr>";
			  echo "</table>";
		  }
	}
	
	if(($estatusEtapa[count($numeroEtapa)] != "TERMINADA")){
		
		if($numeroEtapa != NULL){
			$bandera = 0;
			//MODIFICADO
			$s = $INTRANETV2->Execute("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' AND xt_estatus = 'REVISION' ");
			
			while($r = $s->fetchRow()){
				 $bandera = 1;
			} unset($r); unset($s);
		
		}
		////ASIGNAR
	
	//AGREGADO RECIENTEMENTE------------------------------------------------------------------
	if($pdrNombre == ''){
		if($estatusEtapa != NULL){
		///ASIGNAR FORMULARIO
			if((($_POST['pdr'] == "" ) || ($_POST['fechaAsignar'] == "")) && (($usuarioId == "sdelap")|| ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Ricardo_Garcia")
				 || ($usuarioId == "cozy")|| ($usuarioId == "Christian_Martinez") || ($usuarioId == "Alberto_Martinez")|| ($usuarioId == "Daniel_Guadarrama")|| ($usuarioId == "Miguel_Patiño") || ($usuarioId == "gabriel") || ($usuarioId == "Lizbeth_Guadarrama") )){
				
				
				echo "<form name='agregarSeguimiento' method='POST' action='fichaSolicitudv2.php?codigo=$solicitudID'  enctype='multipart/form-data'>";
					
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
							echo "<td id='iconosTexto2' align='left' ><b>Fecha</b></td>";	
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
							
							echo "<td  align='left'>";
								echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaAsignar'>";
							echo"</td>";
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
		///ASIGNAR INSERCION
			}
				}
		}
		///REVISION
		//obtengo el ultimo status asignado para verificar si se mostrara o no el formulario
		$ultimoStatus = $INTRANETV2->getOne("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' ORDER BY xd_fechaCreacion DESC");
		
		if($usuarioId == $pdrUserId){
			
			///REVISION FORM
			if((@$_POST['fechaRevision'] == "") || (@$_POST['descripcionRevision'] == "")){
				
				echo "<form name='agregarSeguimiento' method='POST' action='fichaSolicitudv2.php?codigo=$solicitudID'  enctype='multipart/form-data'>";
					
					echo "<table border='0' align='center' width='700'>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Para Revisión</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
						echo "</tr>";
						
						echo "<tr height='15'>";
							echo "<td colspan='5'> </td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20' >";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left' colspan='2'>Fecha</td>";
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr align='left'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td  align='left' colspan='2'>";
								echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaRevision'>";
								
								echo "<input type='hidden' name='status' value='REVISION'>";
								
							echo"</td>";
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr height='10'> </tr>";
						
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
								echo"<textarea name='descripcionRevision' style='width: 600px; height: 100px;'></textarea>";
							echo"</td>";
							echo "<td width='20'> </td>";
						echo"</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo "<tr align='left' height='20'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td colspan='3'>";
								echo "<input type='file' name='archivoRevision'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='15'>";
							echo "<td colspan='5'> </td>";
						echo "</tr>";
						
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
							echo "<td align='right' colspan='5'></td>";
						echo "</tr>";
								
					echo "</table>";
					
					echo "</form>";
		///REVISION INSERTAR			
			}	
	
		} 
	////EVALUACION
		//echo "USR:$usuarioId, PDR:$pdrUserId, SOL:$solicitanteID";
		if(((@$solicitanteID == $usuarioId) || ($usuarioId == "sdelap") || ($usuarioId == "Christian_Martinez") || ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Daniel_Guadarrama") || ($usuarioId == "Alberto_Martinez") ||  ($usuarioId == "Miguel_Patiño") || ($usuarioId == "gabriel")|| ($usuarioId == "Lizbeth_Guadarrama")) 
			&& (@$bandera == 1)){
			
		////EVALUACION FORM
			if((@$_POST['fechaEvaluacion'] == "") || (@$_POST['descripcionEvaluacion'] == "") || (@$_POST['evaluacion'] == "")){
				
				echo "<form name='agregarSeguimiento' method='POST' action='fichaSolicitudv2.php?codigo=$solicitudID'  enctype='multipart/form-data'>";
					
					echo "<table border='0' align='center' width='700'>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Evaluar</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
						echo "</tr>";
						
						echo "<tr height='15'>";
							echo "<td colspan='5'> </td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20' >";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left'>Fecha</td>";
							echo "<td id='iconosTexto2' align='left'>Evaluación</td>";
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr align='left'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td  align='left'>";
								echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaEvaluacion'>";
							echo"</td>";
							echo "<td align='left'>";
								echo "<select name='evaluacion'>";
									echo "<option value=''>Elegir...</option>";
									echo "<option value='RECHAZADA'>Rechazada</option>";
									echo "<option value='TERMINADA'>Terminada</option>";
								echo "</select>";
								
								echo "<input type='hidden' name='status' value='EVALUACION'>";
								
							echo "</td>";
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo"<tr height='20'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
								echo"Descripción";
							echo"</td>";
							echo "<td width='20'> </td>";
						echo"</tr>";
						
						echo"<tr>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo"<textarea name='descripcionEvaluacion' style='width: 600px; height: 60px;'></textarea>";
							echo"</td>";
							echo "<td width='20'> </td>";
						echo"</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo "<tr align='left' height='20'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td colspan='3'>";
								echo "<input type='file' name='archivoEvaluacion'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='15'>";
							echo "<td colspan='5'> </td>";
						echo "</tr>";
						
						
						echo "<tr>";
							echo "<td width='20'> </td>";
							echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
						echo "</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo"<tr height='40'>";
							echo "<td width='20'> </td>";
							echo"<td valign='bottom' align='right' colspan='4'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo "<tr height='30'>";
							echo "<td align='right' colspan='5'></td>";
						echo "</tr>";
								
					echo "</table>";
					
				echo "</form>";
		////EVALUACION INSERCION	
			}
		}
	}
	
	echo "<table border='0' align='center' width='700'>";	
		///LINEA FINAL
		echo "<tr height='30px'> </tr>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'> </tr>";
		
		echo "<tr>";
			echo "<td align='right'>";
				if(($solicitanteID == $usuarioId) || ($categoriaUsr == "Administrador")){
				echo "<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudModificar.php?id=$solicitudID' >
					  	<img src='../../../Imagenes/ICN_BotonModificar.png' width='90' height='29'>
					  </a>";
				}
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='nota_al_pie'>";
			///Titulo
				echo "Creado: ".$fechaCreacion.", ".$nombreSolicitante." ".$apllPaSolicitante." ".$apllMaSolicitante;
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='40px'> </tr>";
	echo "</table>";

echo "</div>";
?>
</body>
</html>
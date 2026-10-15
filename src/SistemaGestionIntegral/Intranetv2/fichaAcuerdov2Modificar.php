<?php
$nombrephp='fichaAcuerdo.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
//require_once("MailAcuerdoAsignar.php");
//require_once("MailAcuerdoRevisar.php");
//require_once("MailAcuerdoEvaluar.php");
error_reporting(E_PARSE);

//$acuerdoID = $_GET["acuerdo"];
$codigoAcuerdo = $_GET["acuerdo"];


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

$s = $INTRANETV2->Execute("SELECT xt_codigoAcuerdo, xt_titulo, xt_descripcion, xt_ruta, xt_usuario, DATE(xd_fecha), xt_ciudad, xt_pdr, xt_status FROM SGI_Acuerdos 
						WHERE xt_codigoAcuerdo = '$codigoAcuerdo'  ");

while($r = $s->fetchRow()){
	
	$clave 				= $r[0];
	$titulo 			= $r[1];
	$descripcion 		= nl2br ($r[2]);
	$ruta 				= $r[3];
	$solicitanteID 		= $r[4];
	$pdr                = $r[7];
	$estatuss           = $r[8];	
	$fechaSolicitud 	= date('Y-m-d', strtotime($r[5]));
	$fechaCreacion		= $fechaSolicitud;
	
	$ciudad = $r[6];
	
	//echo"$solicitanteID";
	
	if($solicitanteID != ""){
		
		$u = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, kp_personalId FROM SGI_Empleados WHERE kf_usuario = '$solicitanteID' ");
		
		while($t = $u->fetchRow()){
			$nombreSolicitante = $t[0];
			$apllPaSolicitante = $t[1];
			$apllMaSolicitante = $t[2];
			$solEmpId		   = $t[3];
			
		} unset($t); unset($u);
		
	}
	
	if($pdr != ""){
		
		$s = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, kf_usuario FROM SGI_Empleados WHERE kf_usuario = '$pdr' ");
		
		while($r = $s->fetchRow()){
			$pdrNombre = $r[0];
			$pdrApPate = $r[1];
			$pdrApMate = $r[2];
			$pdrUserId = $r[3];
			
		} unset($t); unset($u);
		
	}
	
	
} unset($r); unset($s);

unset($temp);


///AUDITORIA ISSUE
$auditoriaID 		= "";
$auditoriaCodigo 	= "";
$issueID 			= "";
$issueCodigo 		= "";


if($id != ""){
	////los estatus siguientes que seran mandados a AgregarSeguimientoSolicitud.php
	$estatusMax = 0;
	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Acuerdos_Estatus WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
	
	while($r = $s->fetchRow()){
		
		$estatusMax = $r[0];
		
	} unset($r); unset($s);
	
	$estatusMax++;
	
}
$solcitudEstatus 	= "";
$show 				= "";
$numeroEtapa		= NULL;
$estatusEtapa		= NULL;
$contenidoEtapa		= NULL;
$fechaEtapa 		= NULL;
$rutaEtapa 			= NULL;
		
if($codigoAcuerdo != ""){

	$s = $INTRANETV2->Execute("SELECT xt_estatus FROM SGI_Acuerdos_Estatus WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
	
	while($r = $s->fetchRow()){
		
		$solcitudEstatus = $r[0];
		
	} unset($r); unset($s);
	
	
	$index 		= 0;
	
	$s = $INTRANETV2->Execute("SELECT xn_numero, xt_estatus, xt_contenido, xd_fecha, xt_ruta FROM SGI_Acuerdos_Estatus 
							WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ORDER BY xn_numero ");
			
	while($r = $s->fetchRow()){
		
		$numeroEtapa[$index]	= $r[0];
		$estatusEtapa[$index]	= $r[1];
		$contenidoEtapa[$index]	= $r[2];
		$fechaEtapa[$index] 	= date('Y-m-d', strtotime($r[3]));
		$rutaEtapa[$index] 		= $r[4];
		
		if($estatusEtapa[$index] == "ABIERTO"){
			$show = "Asignado";
			
		} else if($estatusEtapa[$index] == "REVISION"){
			$show = "Para Revisión";
			
		} else if($estatusEtapa[$index] == "RECHAZADO"){
			$show = "Rechazado";
			
		} else if($estatusEtapa[$index] == "CERRADA"){
			$show = "Cerrada";
			
		}
		
		$index++;
		
	}unset($r); unset($s); unset($index);

}

$stats = $_POST['status'];

if($stats != ""){
	if(($stats == "ASIGNAR") && ($_POST['pdr'] != "") && ($_POST['fechaAsignar'] != "")){
					
		$pdrInsert 		= $_POST['pdr'];
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fechaAsignar']));
		
		
		$INTRANETV2->Execute("UPDATE SGI_Acuerdos SET xt_pdr = '$pdrInsert' WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");

		
		if($INTRANETV2->Execute("INSERT INTO SGI_Acuerdos_Estatus (xt_codigoAcuerdo, xn_numero, xt_estatus, xd_fecha, xt_usuario) 
																    VALUES('$codigoAcuerdo', 1, 'ABIERTO', '$fechaInsert', '$usuarioId') ")){
			
			$INTRANETV2->Execute("UPDATE SGI_Acuerdos SET xt_status = 'ABIERTO' WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
																		
			$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS, SGI_Empleados SEM WHERE SEM.kf_usuario = '$pdrInsert' AND SEM.kf_usuario = IUS.kp_usuario ");
			$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS, SGI_Empleados SEM WHERE SEM.kf_usuario = '$pdrInsert' AND SEM.kf_usuario = IUS.kp_usuario ");
			
			$correoAsignador = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
			$nombreAsignador = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
			
			$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$solicitanteID."' ");
			$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$solicitanteID."' ");
			
			if(($correoPDRMail != "") && ($nombrePDRMail != "")){
				
			//	echo $clave."-".$correoPDRMail."-".$nombrePDRMail."-".$correoAsignador."-".$nombreAsignador."-".$correoSolicitante."-".$nombreSolicitante."-".$titulo."-".$descripcion;
				
				//new MailAcuerdoAsignar($clave, $correoPDRMail, $nombrePDRMail, $correoAsignador, $nombreAsignador, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion);
				
			}
			
		}
					
		header("Location: fichaAcuerdov2.php?acuerdo=$codigoAcuerdo");											 
	//echo"<script language='javascript'>window.location='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaAcuerdov2.php?acuerdo=$codigoAcuerdo'</script>;";	
																
		
	}  else if(($stats == "REVISION") && ($_POST['fechaRevision'] != "") && ($_POST['descripcionRevision'] != "")){
		
		$fechaInsert		= date('Y-m-d', strtotime($_POST['fechaRevision']));
		$descripcionInsert 	= nl2br($_POST['descripcionRevision']);
		
		$estatusMax 	= 0;
		
		$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Acuerdos_Estatus WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
		
		while($r = $s->fetchRow()){
			
			$estatusMax = $r[0];
			
		} unset($r);
		
		$estatusMax++;
		
		if($INTRANETV2->Execute("INSERT INTO SGI_Acuerdos_Estatus(xt_codigoAcuerdo, xn_numero, xt_estatus, xt_contenido, xd_fecha) 
																VALUES('$codigoAcuerdo', $estatusMax , 'REVISION', '$descripcionInsert', '$fechaInsert') ")){
																	
			$INTRANETV2->Execute("UPDATE SGI_Acuerdos SET xt_status = 'REVISION' WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
			
			$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$solicitanteID' ");
			$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$solicitanteID' ");
			
			//new MailAcuerdoRevisar($clave, $correoSolicitante, $nombreSolicitante, $descripcionInsert);
		}

		
		$extension = pathinfo($_FILES['archivoRevision']['name'], PATHINFO_EXTENSION);  
		 if($extension != ''){
			
			$contArchivo = $INTRANETV2->getOne("SELECT count(AE.xt_ruta) FROM SGI_Acuerdos_Estatus AE WHERE AE.xt_codigoAcuerdo = '$codigoAcuerdo' AND AE.xt_estatus = 'REVISION' ");
			
			$ruta = "../SeguimientoEtapas/";
			
			//$directorioCompleto = $ruta;
			
			$nombreNuevo = "Revision".$contArchivo."_".$clave.".".$extension;
			$nombreArchivo = $ruta.$nombreNuevo;
				
			if (move_uploaded_file($_FILES['archivoRevision']['tmp_name'], $nombreArchivo)){
			//if (move_uploaded_file($_FILES['archivoRevision']['tmp_name'], $destino)){
				
				$INTRANETV2->Execute("UPDATE SGI_Acuerdos_Estatus SET xt_ruta = '$nombreArchivo' WHERE xt_codigoAcuerdo = '$codigoAcuerdo' AND xt_estatus = 'REVISION' AND xn_numero = $estatusMax");
				
			}
		}
		
		header("Location: fichaAcuerdov2.php?acuerdo=$codigoAcuerdo");
		
	} else if(($stats == "EVALUACION") && ($_POST['fechaEvaluacion'] != "") && ($_POST['descripcionEvaluacion'] != "") && ($_POST['evaluacion'] != "")){
		
		$fechaInsert		= date('Y-m-d', strtotime($_POST['fechaEvaluacion']));
		$descripcionInsert 	= nl2br($_POST['descripcionEvaluacion']);
		$evaluacion 		= $_POST['evaluacion'];

		
		$estatusMax 	= 0;
		$idEstatusMax 	= 0;
		
		$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Acuerdos_Estatus WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
		
		while($r = $s->fetchRow()){
			
			$estatusMax = $r[0];
			
		} unset($r);
		
		$estatusMax++;
		
		
		if($INTRANETV2->Execute("INSERT INTO SGI_Acuerdos_Estatus(xt_codigoAcuerdo, xn_numero, xt_estatus, xt_contenido, xd_fecha) 
																VALUES('$codigoAcuerdo', $estatusMax , '$evaluacion', '$descripcionInsert', '$fechaInsert') ")){
																	
			$INTRANETV2->Execute("UPDATE SGI_Acuerdos SET xt_status = '$evaluacion' WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
			
			//if($evaluacion == "RECHAZADO"){
				
				$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
				$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
			
				//new MailAcuerdoEvaluar($clave, $correoPDRMail, $nombrePDRMail, $evaluacion, $descripcionInsert);
				
			//}
		}
		$extension = pathinfo($_FILES['archivoEvaluacion']['name'], PATHINFO_EXTENSION);  
		 if($extension != ''){
			
			$contArchivo = $INTRANETV2->getOne("SELECT count(AE.xt_ruta) FROM SGI_Acuerdos_Estatus AE WHERE AE.xt_codigoAcuerdo = '$codigoAcuerdo' AND AE.xt_estatus = 'REVISION' ");
			 
			$contArchivo = $INTRANETV2->getOne("SELECT count(AE.xt_ruta) FROM SGI_Acuerdos_Estatus AE WHERE AE.xt_codigoAcuerdo = '$codigoAcuerdo' AND AE.xt_estatus = '$evaluacion' ");
			
			
			$ruta = "../SeguimientoEtapas/";
			
			//$directorioCompleto = $ruta;
			
			$nombreNuevo = $evaluacion.$contArchivo."_".$clave.".".$extension;
			$nombreArchivo = $ruta.$nombreNuevo;
				
			if (move_uploaded_file($_FILES['archivoEvaluacion']['tmp_name'], $nombreArchivo)){
			//if (move_uploaded_file($_FILES['archivoRevision']['tmp_name'], $destino)){
				
				$INTRANETV2->Execute("UPDATE SGI_Acuerdos_Estatus SET xt_ruta = '$nombreArchivo' WHERE xt_codigoAcuerdo = '$codigoAcuerdo' ");
				
			}
		}
	
		header("Location: fichaAcuerdov2.php?acuerdo=$codigoAcuerdo");
	}
}
$indice = 0;
$codigoAc 	= NULL;
$tituloAc 	= NULL;
$fechaAc 	= NULL;
$acuerdoID 	= NULL;


$s = $INTRANETV2->Execute("SELECT
							R.xt_codigoReunion,
							R.xt_tipo,
							date(R.xd_fecha),
							CASE R.xn_status WHEN 1 THEN 'Programada' WHEN 2 THEN 'Realizada' WHEN 2 THEN 'Pospuesta' END
						FROM
							SGI_Acuerdos_Reunion A,
							SGI_Reuniones R
						WHERE
							A.xt_codigoAcuerdo = '$codigoAcuerdo'
						AND A.xt_codigoReunion = R.xt_codigoReunion ");

while($r = $s->fetchRow()){
	
	$codigoAc[$indice] 	= $r[0];
	$tituloAc[$indice] 	= $r[1];
	$fechaAc[$indice] 	= $r[2];
	$estatus[$indice] = $r[3];

	
	$indice++;
	
} unset($r); unset($s);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
        <title><?php echo $clave; ?></title>
		<?php
		if($estiloUsuario == 1){
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>
            <?php
		}else if($estiloUsuario == 2){
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>
            <?php
		}
		?>
        
        <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
        <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet"/>
        <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
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
            function showpdredit()
            {
            	 document.getElementById("pdredit").style.display="inline-block";
            }


function showSeguimiento(valor){
	if(valor == 1){
		document.getElementById("seguimiento1").style.display="none";
		document.getElementById("seguimiento0").style.display="block";
		document.getElementById("formSeguimiento").style.display="block";
					} 
	else if (valor == 0){
		document.getElementById("seguimiento1").style.display="block";
		document.getElementById("seguimiento0").style.display="none";
		document.getElementById("formSeguimiento").style.display="none";
					}
				}

function agregarseguimiento(acuerdo) { 
	var codigo =  $("#codigoTratamiento").val();
	var tipo = $("#atributotrat").val();  
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				location.reload();
			}else{
				alert("Hubo un error al actualizar el campo tipo.");
			}
		}
	};

	if( tipo!= 0 && codigo !="" )
	{
	xhttp.open("POST", "agregaCampoSeguimiento.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("acuerdo="+acuerdo+"&tipo="+tipo+"&codigo="+codigo);
}
}
        </script>
    </head>
    <body>
<?php
$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='../ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos / </a>
			   <a href='tableroAcuerdosv2.php' id='breadcrumbs'> Tablero de Acuerdos </a> ";

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
				} else{
					echo "$fechaSolicitud";
				}
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";

		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Acuerdo</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		//echo"<tr height='70'> </tr>";
	echo "</table>";
				//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
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
			if ($ruta != NULL){
				echo"<td id='iconosTexto' width='50' align='right'><a href='../downloadAcuerdoElemento.php?file=$ruta'><img src='../../Imagenes/ICN_Archivo.png'></a> </td>";
			}else {
				echo"<td id='iconosTexto' width='50' align='right'></td>";
			}
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='20'> </td>";
			echo "<td width='20'> </td>";
			echo "<td width='610' align='justify' id='fileItem'><input type='text' value= '$descripcion'> </td><td></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
//Reunion Relacionada

echo "<table border='0' align='center' width='700'>";	
			echo "<tr>";
				echo "<td align='left' id='titulo2' colspan='2'><b>Reuniones</b></td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
		echo "</table>";
		
if(count($codigoAc) >= 1){	

echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='right' width='15px'></td>";
				echo "<td align='left'  id='iconosTexto2'>Código</td>";
				echo "<td align='left' id='iconosTexto2'>Titulo</td>";
				echo "<td align='left' id='iconosTexto2'>Estatus</td>";
				echo "<td align='center' id='iconosTexto2'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspna='3'></td></tr>";
				
			for($a = 0; $a <= count($codigoAc); $a++){
				
				echo "<tr>";
					echo "<td align='right' width='15px'></td>";
					echo "<td width='200px' align='left' valign='top'>";
						echo "<a href='fichaReunionv2.php?id=".$codigoAc[$a]."' id='fileItem' style='text-decoration:none;'>".$codigoAc[$a]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='210px' id='fileItem' valign='top'>".$tituloAc[$a]."</td>";
					echo "<td align='left' width='120px' id='fileItem' valign='top'>".$estatus[$a]."</td>";
					echo "<td align='center' width='120px' id='fileItem' valign='top'>".$fechaAc[$a]."</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
					
			} unset($a);
		
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
				echo "<td align='left' width='680px' id='iconosTexto'><b><a style='cursor:  pointer;' onClick='showpdredit()'> $pdrNombre $pdrApPate $pdrApMate</a></b></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
		echo "</table>";
	}

	////ASIGNAR
 
		if($estatusEtapa != NULL || $estatusEtapa[0] =="ABIERTO" || $estatusEtapa[0] =="" ){
		///ASIGNAR FORMULARIO
			if((($_POST['pdr'] == "" ) || ($_POST['fechaAsignar'] == "")) && (($usuarioId == "Cecilia_Flores")|| ($usuarioId == "sdelap")|| ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Ricardo_Garcia") || ($usuarioId == "Alberto_Martinez")|| ($usuarioId == "Eibar_Ponce")|| ($usuarioId == "Christian_Martinez")|| ($usuarioId == "Daniel_Guadarrama")|| ($usuarioId == "Miguel_Patiño") || ($usuarioId == "gabriel") )){
				
				echo "<form name='agregarSeguimiento' method='POST' action='fichaAcuerdov2.php?acuerdo=$codigoAcuerdo'  enctype='multipart/form-data'>";
					
					echo "<table border='0' id='pdredit' align='center' width='700'";
					if(  $estatusEtapa[0] =="ABIERTO" ){
						echo "style='display: none;'";
					}
					echo ">";
						
						echo "<tr>";
							echo "<td width='30'></td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Asignar PDR (Persona Directamente Responsable)</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'></td>";
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
															AND EMP.kf_usuario != ''
															ORDER BY EMP.xt_Nombre ");
										
									while($r= $s -> fetchRow()){
										
										echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
										
									} unset($r); unset ($s);
									
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
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo "<tr height='30'>";
							echo "<td align='right' colspan='5'> </td>";
						echo "</tr>";
								
					echo "</table>";
					
				echo "</form>";
		///ASIGNAR INSERCION
			}
			
			//header("Location: fichaAcuerdov2.php?acuerdo=$codigoAcuerdo");
	
		} 
	
///SEGUIMIENTO
	echo "<table border='0' align='center' width='700'>";	
		echo "<td id='titulo2' colspan='4'><b>  Seguimiento</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>
				  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'  id='seguimiento1' style='display:block;' onclick='showSeguimiento(1);'>
				  <img src='../../Imagenes/ICN_BotonMenos.png' height='15' width='15'  id='seguimiento0' style='display:none;' onclick='showSeguimiento(0);'>   </td>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";

echo "<table border='0' align='center' width='600px' id='formSeguimiento' style='display:none;' >";	
 
	echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Agregar tratamiento</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'>";
				echo "<td colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td width='20px'></td>";
				echo "<td width='30px'></td>";
				echo "<td width='150px' align='left' id='iconosTexto2'>Código</td>";
				echo "<td width='400px' align='left' id='iconosTexto2'> Tipo </td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
				echo "<td></td>";
				echo "<td></td>";
				
				echo "<td align='left'>";
					echo "<input type='text' size=20 maxlength=100 id='codigoTratamiento'>";
				echo "</td>";
				
				echo "<td align='left'>";
					echo "<select id='atributotrat' name='atributotrat'>";
						echo "<option value='0' selected=''>Elegir...</option>";					
						echo "<option value='Solicitud'>Solicitud</option>";
						echo "<option value='Acción Preventiva'>Acción Preventiva</option>";
						echo "<option value='Acción Correctiva'>Acción Correctiva</option>";
						echo "<option value='Otro Simulacro'>Otro Simulacro</option>";
					echo "</select>";
				echo "</td>";
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
					echo "<a style='cursor:pointer; valign:top; align:right;' onClick='agregarseguimiento(\"$codigoAcuerdo\")'><font color='#007cbd'>&nbsp; Agregar</font></a> ";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='30px'>";
				echo "<td align='right' colspan='5'></td>";
			echo "</tr>";
		echo "</table> ";


	///Tratamientos

	$contador=0;
$cs = $INTRANETV2->Execute("
			SELECT xt_claveSeguimiento ,xt_tipoSeguimiento,xd_fecha FROM SGI_Acuerdos_Seguimientos
			where xt_claveAcuerdo = '$codigoAcuerdo' 
		");			
 
	
	while($seg = $cs->fetchRow()){
		 
			$claveSeguimiento[$contador]  = $seg[0];
			$tipoSeguimiento[$contador]   = $seg[1];
			$xd_fecha[$contador]          = $seg[2];	

			if($tipoSeguimiento[$contador]=="Solicitud")
			{
				$tipoSolicitud = $INTRANETV2->getOne("
												SELECT
													xt_tipoSolicitud
												FROM
													SGI_Quejas_Solicitudesv2
												WHERE
													xt_quejaSolicitud = '$claveSeguimiento[$contador]'
											");

				$estatusSol[$contador] = $INTRANETV2->getOne("
												SELECT
													xt_status
												FROM
													SGI_Quejas_Solicitudesv2
												WHERE
													xt_quejaSolicitud = '$claveSeguimiento[$contador]'
											");
										if($tipoSolicitud == 'MT'){
											$pagina = "https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?";
										} else if ($tipoSolicitud == 'PY'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?";
										} else if ($tipoSolicitud == 'AV'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'AB'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'ST'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'DS'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'EA'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										}

										if ($tipoSolicitud!=""){
										$claveSeguimiento[$contador]=  "<a href='".$pagina."codigo=".$claveSeguimiento[$contador]."'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a>";
									}
									else {
										$claveSeguimiento[$contador]=  "<a codigo='$tipoSolicitud'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a>";
									}

			}

			else if($tipoSeguimiento[$contador]=="Acción Preventiva")
			{
				$claveSeguimiento[$contador]= "<a href='fichaPreventivav2.php?codigo=".$claveSeguimiento[$contador]."'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a><br>";

			}
			else if($tipoSeguimiento[$contador]=="Acción Correctiva")
			{
				$claveSeguimiento[$contador]= "<a href='fichaCorrectivav2.php?codigo=".$claveSeguimiento[$contador]."'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a><br>";
				
			}

			else if($tipoSeguimiento[$contador]=="Otro Simulacro")
			{
				$claveSeguimiento[$contador]= "<a href='simulacroElementoActualizar.php?simulacro=".$claveSeguimiento[$contador]."'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a><br>";
				
			}


			$contador++;
		}
		 
		if($contador>0)
		{	
	echo "<table border='0' align='center' width='500px'  >";	
 
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Tratamientos</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'>";
				echo "<td colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td width='20px'></td>"; 
				echo "<td width='200px' align='left' id='iconosTexto2'>Clave</td>";
				echo "<td width='100px' align='left' id='iconosTexto2'> Tipo </td>";
				echo "<td width='100px' align='left' id='iconosTexto2'> Estatus </td>";
				echo "<td width='200px' align='left' id='iconosTexto2'> Fecha </td>";
			echo "</tr>";

			for ($i=0; $i <= $contador; $i++) { 
				echo "<tr><td></td>
				<td>$claveSeguimiento[$i]</td>
				<td>$tipoSeguimiento[$i]</td>
				<td>$estatusSol[$i]  </td>
				<td>$xd_fecha[$i]</td>

				</tr>";
			}
			
			 
			 
			
			echo "<tr height='30px'>";
				echo "<td align='right' colspan='5'></td>";
			echo "</tr>";
		echo "</table> ";

	}



///CODIGO MOSTRAR SEGUIMIENTO
	//if($codigo != ""){
		
		if(count($numeroEtapa) >= 1){
			
			for($a = 0; $a <count($numeroEtapa); $a++){
				
				$show = "";
				
				if($estatusEtapa[$a] == "ABIERTO"){
					$show = "Asignado";
					
				} else if($estatusEtapa[$a] == "REVISION"){
					$show = "Para Revisión";
					
				} else if($estatusEtapa[$a] == "RECHAZADO"){
					$show = "Rechazado";
					
				} else if($estatusEtapa[$a] == "CERRADA"){
					$show = "Cerrada";
					
				}
			
				echo "<table border='0' align='center' width='700'>";
					echo "<tr>";
						echo "<td> </td>";
						echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa[$a] <b>$show</b></td>";
						
						if ($rutaEtapa[$a] != NULL){
							
							echo "<td id='iconosTexto' width='50' align='right'>";
								echo "<a href='../downloadSeguimiento.php?file=$rutaEtapa[$a]'>";
									echo "<img src='../../Imagenes/ICN_Archivo.png'>";
								echo "</a>";
							echo "</td>";
							
						}else {
							
							echo "<td id='iconosTexto' width='50' align='right'></td>";
							
						}
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
					
					if($estatusEtapa[$a] == "ABIERTO"){
						
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
					
					echo"<tr height='30'> </tr>";
				echo "</table>";
				
			}
			
		}
		
	//}
	
	
	if(($estatusEtapa[count($numeroEtapa)] != "CERRADA")){
		
		if($numeroEtapa != NULL){
			$bandera = 0;
			
			$s = $INTRANETV2->Execute("SELECT xt_estatus FROM SGI_Acuerdos_Estatus WHERE xt_codigoAcuerdo = '$codigoAcuerdo' AND xt_estatus = 'REVISION' ");
			
			while($r = $s->fetchRow()){
				$bandera = 1;
			} unset($r); unset($s);
		
		}

	///REVISION
		//echo "USR:$usuarioId, PDR:$pdrUserId";
		if($usuarioId == $pdrUserId){
			
		if($estatuss != "CERRADA"){
		///REVISION FORM
			if(($_POST['fechaRevision'] == "") || ($_POST['descripcionRevision'] == "")){
				
				echo "<form name='agregarSeguimiento' method='POST' action='fichaAcuerdov2.php?acuerdo=$codigoAcuerdo'  enctype='multipart/form-data'>";
					
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
								echo"<textarea name='descripcionRevision' style='width: 600px; height: 60px;'></textarea>";
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
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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
			
	
		} 
	////EVALUACION
		
		if($estatuss != "CERRADA"){
			//echo "USR:$usuarioId, PDR:$pdrUserId, SOL:$solicitanteID";
			if((($solicitanteID == $usuarioId) || ($usuarioId == "Cecilia_Flores") || ($usuarioId == "sdelap") || ($usuarioId == "Christian_Martinez") || ($usuarioId == "Rodrigo_Romo") || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "cozy")|| ($usuarioId == "Daniel_Guadarrama")|| ($usuarioId == "Miguel_Patiño") || ($usuarioId == "gabriel") || ($usuarioId == "Elena_Hernandez")) 
				&& ($bandera == 1)){

			////EVALUACION FORM
				if(($_POST['fechaEvaluacion'] == "") || ($_POST['descripcionEvaluacion'] == "") || ($_POST['evaluacion'] == "")){

					echo "<form name='agregarSeguimiento' method='POST' action='fichaAcuerdov2.php?acuerdo=$codigoAcuerdo'  enctype='multipart/form-data'>";

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
										echo "<option value='CERRADA'>Cerrada</option>";
										echo "<option value='RECHAZADO'>Rechazada</option>";
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
									echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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
				if(($solicitanteID == $usuarioId) || ($usuarioId == "Christian_Martinez") || ($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'sdelap')  || ($usuarioId == "Eibar_Ponce") || ($usuarioId == "Daniel_Guadarrama")|| ($usuarioId == "Miguel_Patiño") || ($usuarioId == "gabriel")){
				echo "<a href='fichaSolicitudModificar.php?id=$codigoAcuerdo' >
					  	<img src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'>
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
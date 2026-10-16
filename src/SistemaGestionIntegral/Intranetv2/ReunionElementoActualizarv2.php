<?php
$nombrephp = 'ReunionElementoActualizar.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

 error_reporting(E_PARSE);

if($_POST['id'] != ""){
	
	$codigoReunion = $_POST['id'];
	
} else if($_GET['id'] != ""){
	
	$codigoReunion = $_GET['id'];
	
}

$index = 0;
$b = $INTRANETV2->Execute("SELECT xt_reunion, xt_nombre FROM SGI_Catalogo_Reuniones ORDER BY xt_reunion");
while($n = $b->fetchRow()){
	$reunion[$index]       = $n[0];
	$nombreReunion[$index] = $n[1];
	$index++;
}unset($n);unset($b);unset($index);

$sql = $INTRANETV2->Execute("SELECT xn_temaId, xt_tema FROM SGI_Catalogo_Temas_Reuniones");

$iR=0;
while ($re = $sql->fetchRow()) {
	$temaId[$iR]= $re[0];
	$temasReunion2[$iR] = $re[1];
	$iR++;
}
?>
<script type="text/javascript">
	function muestra_ocultaDiv(divMostrar, divOcultar){
		if (divMostrar!='') {
		var mostrar = document.getElementById(divMostrar);
			if(mostrar.style.display == 'block'){
				mostrar.style.display = 'none';
			}else{
				mostrar.style.display = 'block';
			}
		}

		if (divOcultar!='') {
		var ocultar = document.getElementById(divOcultar);
			if(ocultar.style.display == 'block'){
				ocultar.style.display = 'none';
			}else{
				ocultar.style.display = 'block';
			}
		}

		cambiaTextoBoton();
	}

	function cambiaTextoBoton(){
		var texto = document.getElementById("botonAsistentes").value;

		if (texto == 'Agregar') {
			document.getElementById("botonAsistentes").value = 'Ocultar';
		}else{
			document.getElementById("botonAsistentes").value = 'Agregar';
		}
	}
</script>
<?php
/*$temasReunion2[1] 	= "Resultado de las auditorías";
$temasReunion2[2] 	= "Retroalimentación de las partes interesadas pertinentes: Quejas";
$temasReunion2[3] 	= "Retroalimentación del cliente: Cuestionario de satisfacción del cliente";
$temasReunion2[4] 	= "No conformidades y acciones correctivas";
$temasReunion2[5] 	= "Estado de las acciones de las revisiones por la dirección previas";
$temasReunion2[6] 	= "Cambios que podrían afectar al SGI";
$temasReunion2[7] 	= "Oportunidades de mejora";
$temasReunion2[8] 	= "Necesidad o adecuación de los recursos";
$temasReunion2[9] 	= "Política Integral";
$temasReunion2[10] 	= "Objetivos de calidad";
$temasReunion2[11] 	= "Desempeño de los procesos y conformidad de los productos y servicios";
$temasReunion2[12] 	= "Planeación Estratégica";
$temasReunion2[13] 	= "Seguridad";
$temasReunion2[14] 	= "Desempeño de los proveedores externos";
$temasReunion2[15] 	= "Sanciones";
$temasReunion2[16] 	= "Proyecto";
$temasReunion2[17] 	= "Comunicaciones";
$temasReunion2[18] 	= "Hardware";
$temasReunion2[19] 	= "Software";
$temasReunion2[20] 	= "Bases de Datos";
$temasReunion2[21] 	= "Sistemas";	
$temasReunion2[22] 	= "Ronda de Sugerencias";
$temasReunion2[23] 	= "Cambios en las cuestiones externas e internas que sean pertinentes al sistema de 						gestión de la calidad";
$temasReunion2[24] 	= "Eficacia de las acciones tomadas para abordar los riesgos y las oportunidades";
$temasReunion2[25] 	= "Resultados de seguimiento y medición";
$temasReunion2[26] 	= "Otros";*/

$bandera = 0;

$s = $INTRANETV2->Execute("SELECT xt_codigoReunion, CASE xn_status WHEN 1 THEN 'Programada' WHEN 2 THEN 'Realizada' WHEN 2 THEN 'Pospuesta' END, xd_fecha, xt_tipo, xt_ciudad, xt_grupo FROM SGI_Reuniones WHERE xt_codigoReunion = '$codigoReunion'");

while($r = $s->fetchRow()){
	
	$codigo 		= $r[0];
	$status 		= $r[1];
	$fecha 			= date('Y-m-d', strtotime($r[2]));
	$tipoReunion	= $r[3];
	$status         = $r[4];
	
	for($o = 0; $o <count($reunion); $o++){
	
		if($reunion[$o] == $tipoReunion){
			
			$tipoReunion = $nombreReunion[$o];
			
		}
		
	} unset($o);
	
	$ciudadReunion = $r[4];
	
	if($ciudadReunion == ""){
		
		$ciudadReunion = "GRAL";
		
	}
	
	$grupoReunion = $r[5];
} unset($s); unset($r);

//Cancela la reunion
if($_REQUEST['evento'] == "cancelarReunion"){
	if(isset($_REQUEST['reunion'])){
		
		$reunionCancelar = $_POST['reunion'];
		$descripCancelar = $_POST['descripcion'];
		
		$INTRANETV2->Execute("UPDATE SGI_Reuniones SET xn_status = 3, xt_descripcion = '$descripCancelar'  WHERE xt_codigoReunion = '$reunionCancelar' ");
		
	}
}

if($codigo != ""){
	
	if($_POST["asistencia"] != ""){
		foreach($_POST['asistencia'] as $checkbox){
			
			if(!$INTRANETV2->getOne("SELECT xt_usuario FROM SGI_Reunion_Asistentes WHERE xt_codigoReunion = '$codigoReunion' AND xt_usuario = '$checkbox'")){
				
				if($INTRANETV2->Execute("INSERT INTO SGI_Reunion_Asistentes(xt_codigoReunion, xt_usuario) VALUES ('$codigoReunion', '$checkbox') ")){
					$bandera = 1;
					header("Location: ReunionElementoActualizarv2.php?id=$codigoReunion");
				}
			}
					
		}
	}
	///RECORRER TODOS LOS PUNTOS DE LOS TEMAS
//var_dump($temasReunion2);
	for($o = 0; $o < count($temasReunion2); $o++){

		$id = $temaId[$o];
		if($_POST["tema,$id"] != ""){
			 
			$item = $_POST["tema,$id"];
			//echo "SELECT xn_numeroTema FROM SGI_Reunion_Temas WHERE xn_numeroTema = $id LIMIT 1";
			$existe = $INTRANETV2->GetOne("SELECT xn_numeroTema FROM SGI_Reunion_Temas WHERE xn_numeroTema = $id LIMIT 1");


			if (!empty($existe)) {
				if($INTRANETV2->Execute("UPDATE SGI_Reunion_Temas SET xt_texto = '$item' WHERE xt_codigoReunion = '$codigoReunion' AND xn_numeroTema = $id")){
					$bandera = 1;
					//echo "UPDATE SGI_Reunion_Temas SET xt_texto = '$item' WHERE xt_codigoReunion = '$codigoReunion' AND xn_numeroTema = $id";
					header("Location: ReunionElementoActualizarv2.php?id=$codigoReunion");
				}
			}
		}
	} unset($o);
	
	//GUARDA LA REVISION DE LA REVISION
	if($_POST["revisionReunion"] != ""){
		
		$item = $_POST["revisionReunion"];
		
		$actual = $INTRANETV2->getOne("SELECT xt_texto FROM SGI_Reunion_Revisiones WHERE xt_codigoReunion = '$codigoReunion' ");
		
		if($actual != ""){
			
			if($item != $actual){
				
				if($INTRANETV2->Execute("UPDATE SGI_Reunion_Revisiones SET xt_texto = '$item' WHERE xt_codigoReunion = '$codigoReunion' ")){
					$bandera = 1;
					header("Location: ReunionElementoActualizarv2.php?id=$codigoReunion");
				}
			}
		} else{
			
			if($INTRANETV2->Execute("INSERT INTO SGI_Reunion_Revisiones (xt_codigoReunion, xt_texto) VALUES ('$codigoReunion', '$item') ")){
				$bandera = 1;
				header("Location: ReunionElementoActualizarv2.php?id=$codigoReunion");
			}
		}
	}
	
	if($_POST["terminar"] != ""){
		
		$terminar = $_POST["terminar"];
		
		if($terminar == "Close"){
			
			$INTRANETV2->Execute("UPDATE SGI_Reuniones SET xn_status = 2 WHERE xt_codigoReunion = '$codigoReunion'");
			header("Location: fichaReunionv2.php?id=$codigoReunion");
		}
	}
	//Crea acuerdo y guarda la relacion acuerdo-reunion
	if(($_POST['fechaAcuerdo'] != "") && ($_POST['tituloAcuerdo'] != "")){
	
		$fechaAcuerdo       		= date('Y-m-d', strtotime($_POST['fechaAcuerdo']));
		$horaActual                 = date ("H:i:s");
		$tituloAcuerdoInsert 		= $_POST['tituloAcuerdo'];
		$descripcionAcuerdoInsert 	= $_POST['descripcionAcuerdo'];
		$fechaAcuerdoInsert         = $fechaAcuerdo." ".$horaActual;
		
		$anio = date('Y', strtotime($_POST['fechaAcuerdo']));
		
		
		$s = $INTRANETV2->Execute("SELECT
									CASE
									WHEN LPAD(SUBSTRING_INDEX(MAX(xt_codigoAcuerdo),'-',-1), 3, '0') IS NULL THEN
										'001'
									ELSE
										LPAD(SUBSTRING_INDEX(MAX(xt_codigoAcuerdo),'-',-1) + 1, 3, '0')
									END

									FROM
										SGI_Acuerdos
									WHERE
										YEAR (xd_fecha) = $anio
									AND xt_ciudad = '$ciudadReunion'
									AND xt_grupo = '$grupoReunion' ");
		
		while($r = $s->fetchRow()){
			
			$maximo = $r[0];
			
		} unset($r); unset($s);
		
		
		$anio = date('y', strtotime($_POST['fechaAcuerdo']));
			
		$codigo = $grupoReunion."-A-".$ciudadReunion."-".$anio."-".$maximo;
			
		
		if($INTRANETV2->Execute("INSERT INTO SGI_Acuerdos (xt_codigoAcuerdo, xt_titulo, xt_descripcion, xd_fecha, xt_usuario, xt_ciudad, xt_grupo) 
								VALUES ('$codigo', '$tituloAcuerdoInsert', '$descripcionAcuerdoInsert','$fechaAcuerdoInsert', '$usuarioId', '$ciudadReunion', '$grupoReunion') ")){
			
			$INTRANETV2->Execute("INSERT INTO SGI_Acuerdos_Reunion (xt_codigoAcuerdo, xt_codigoReunion) VALUES ('$codigo','$codigoReunion')");
			
		}
		
		header("Location: ReunionElementoActualizarv2.php?id=$codigoReunion");
		
	}
	

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'> Home / </a>
			 <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			 <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a>
			 <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos / </a>
			 <a href='tableroReunionesv2.php' id='breadcrumbs'> Tablero de Reuniones </a>";


$indice = 0;
$codigoAc 	= NULL;
$tituloAc 	= NULL;
$fechaAc 	= NULL;
//$acuerdoID	= NULL;

$s = $INTRANETV2->Execute("SELECT
							A.xt_codigoAcuerdo,
							A.xt_titulo,
							DATE(A.xd_fecha),
							xt_pdr,
							xt_status
						FROM
							SGI_Acuerdos A,
							SGI_Acuerdos_Reunion R
						WHERE R.xt_codigoReunion = '$codigoReunion'
						AND R.xt_codigoAcuerdo = A.xt_codigoAcuerdo");

while($r = $s->fetchRow()){
	
	$codigoAc[$indice] 	= $r[0];
	$tituloAc[$indice] 	= $r[1];
	$fechaAc[$indice] 	= $r[2];
	$pdr[$indice] 		= $r[3];
	$statusd[$indice] 	= $r[4];
	
	$indice++;
	
} unset($r); unset($s);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Reunión en Proceso</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
						document.getElementById("formularioAcuerdo").style.display="block";
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
						
					} else if (valor == 0){
						document.getElementById("formularioAcuerdo").style.display="none";
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					}
				}
				function cancelarReunion(reunion) {
					
					var confirmar = confirm('Estas seguro que quieres cancelar la reunion'+' '+reunion);
					var descripcion = document.getElementsByName("descripcion")[0].value;
					
					if (confirmar == true) {
						
						var xhttp = new XMLHttpRequest();
						
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								actualizaActualizaReunion(reunion);
							}
						};

						xhttp.open("POST", "ReunionElementoActualizarv2.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=cancelarReunion&reunion="+ reunion + "&descripcion="+ descripcion);
						
					}
				}
				function actualizaActualizaReunion(reunion) {
					window.location.href = 'fichaReunionv2.php?id=' + reunion;
				}
				function activaTextoCancelar() {
					div     = document.getElementById('divCancelar');
					mostrar = document.getElementById('mostrarTextoCancelar');
					mostrar2 = document.getElementById('mostrarTextoCancelar2');
					mostrar.style.display = 'none';
					mostrar2.style.display = '';
					div.style.display = '';
				}
				
				function cancelarTexto() {
					div     = document.getElementById('divCancelar');
					mostrar = document.getElementById('mostrarTextoCancelar');
					mostrar2 = document.getElementById('mostrarTextoCancelar2');
					mostrar.style.display = '';
					mostrar2.style.display = 'none';
					div.style.display = 'none';
				}

				
			</script>
            <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
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
        </head>
        <body>
<?php

echo "<div id='wrapperFicha' align='center'>";
	echo "<form method='post' action='ReunionElementoActualizarv2.php'>";
		///POST DEL ID
		echo "<input type='hidden' name='id' value='".$codigoReunion."'>";
		
		echo "<table border='0' align='center' name='Encabezado'>";	
			echo "<tr>";
				echo "<td id='breadcrumbs' align='left'>Usuario: ".$usuarioId."</td>";
			echo "</tr>";
			
			echo "<tr height='80px'>";
				echo "<td id='breadcrumbs'>Fecha: ".$fecha."</td>";
			echo "</tr>";
		///Titulo 
			echo "<tr>";
				echo "<td align='center' id='titulo1' width='700px'>";
					echo "Reunión<br>";
					echo $codigo;
				echo "</td>";
			echo "</tr>";
			
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
			
		//echo "<tr height='50'><td></td></tr>";
		echo "</table>";
		
	
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../../navegacion_banana.php");
			echo "</table>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
		echo "<table border='0' align='center' width='700'>";
			echo "<tr id='titulo2'>";
				echo "<td width='20px'></td>";
				echo "<td width='300px' align='left'>Tipo</td>";
				echo "<td width='300px' align='center'>Status</td>";
				echo "<td width='50px' align='left'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr id='iconosTexto'>";
				echo "<td width='20px'> </td>";
				echo "<td width='300px'align='left'>".$tipoReunion."</td>";
				echo "<td width='300px' align='center'>Programada</td>";
				echo '<td width="50px" align="right" id="mostrarTextoCancelar"><p style="cursor:pointer;" title="Cancelar Reunion" onclick="activaTextoCancelar()"><font color="#007CBD" size="2" face="arial">cancelar  reunion</font></p></td>';
				echo '<td width="50px" align="right" id="mostrarTextoCancelar2" style="display:none;"><p style="cursor:pointer;" title="Cancelar Reunion" onclick="cancelarTexto()"><font color="#007CBD" size="2" face="arial">Ocultar</font></p></td>';
			echo "</tr>";
			
			echo "<tr height='50'><td colspan='3'></td></tr>";		
		echo "</table>";
	
		
		echo "<div id='divCancelar'  style='display:none;'>";
			echo "<table border='0' align='center' width='700px' cellspacing='0'>";
				echo "<tr>";	
					echo "<td padding:0px 0px 0px 25px;'>";
						echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" /></textarea>';
							echo' <div id="close"><a style="float:right;cursor:pointer;" href="javascript:cancelarReunion(\''.$codigoReunion.'\');"><font  size="2" color="#007CBD" face="arial">Guardar</font></a></div>';
					echo "</td>";
				echo "</tr>";
			echo"</table>";
	   echo "</div>";
			
	//1. ASISTENCIA INTERNA
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='700px'>1. Asistencia</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";		
		echo "</table>";
		
		echo "<table name='externa'>";
			echo "<tr>";
				echo "<td>";
					echo "<table border='0' align='center' width='660' name='interna'>";
						echo "<tr height='20px'><a name='listaAsistencia'></a></tr>";
					
						$indice = 1;
						
						$s = $INTRANETV2->Execute("
SELECT
 EMP.kf_usuario,
 CONCAT(EMP.xt_Nombre,' ',EMP.xt_ApellidoPaterno)
FROM
 SGI_Empleados EMP
INNER JOIN SGI_EmpleadosActividad EAC ON  (EMP.kp_personalId=EAC.kf_personalID)
WHERE
 (EAC.xt_actividad='REUNION') AND 
 (EMP.xt_Estatus=1) AND
 CASE xt_ciudad
 WHEN 'DF' THEN 'CMX'
 ELSE EMP.xt_ciudad
 END = '$ciudadReunion'
 ORDER BY EMP.xt_Nombre");
						
						while($r = $s->fetchRow()){
							
							$usuarioPersonal[$indice] 	= $r[0];
							$nombreCorto[$indice]	= trim($r[1]);
							//$tipo1[$indice] 	= $r[0];
							$indice++;
							$c = $indice;
						} unset($r); unset($s); unset($indice);

//arreglo de asistentes externos
						$sql = $INTRANETV2->Execute("
SELECT
 EMP.kf_usuario,
 CONCAT(EMP.xt_Nombre,' ',EMP.xt_ApellidoPaterno)
FROM
 SGI_Empleados EMP
INNER JOIN SGI_EmpleadosActividad EAC ON  (EMP.kp_personalId=EAC.kf_personalID)
WHERE
 (EAC.xt_actividad='REUNION') AND
 (EMP.xt_Estatus=1) AND
 CASE xt_ciudad
 WHEN 'DF' THEN 'CMX'
 ELSE EMP.xt_ciudad
 END != '$ciudadReunion'
 ORDER BY EMP.xt_Nombre");
						$c++;
						$usuarioPersonal[$c] 	= "2";
						$nombreCorto[$c]	= "2";
						$c++;
						$indice2=$c;
						while($rsql = $sql->fetchRow()){
							
							$usuarioPersonal[$indice2] 	= $rsql[0];
							$nombreCorto[$indice2]	= trim($rsql[1]);
							//$tipo2[$indice2] 	= $rsql[0];
							$indice2++;
							
						} unset($rsql); unset($sql); unset($indice2);
//fin de asistentes externos

						/*$usuarioPersonal = array_merge($usuarioPersonal1,$usuarioPersonal2);
						$nombreCorto = array_merge($nombreCorto1,$nombreCorto2);
						$tipo = array_merge($tipo1,$tipo2);*/

						$cuenta = count($usuarioPersonal);
						
						$filas = ceil($cuenta/4);
						$celdas = 0;
					
						if(		  (($cuenta%4)/4) == 0.25){
							$celdas = 1;
							
						} else if((($cuenta%4)/4) == 0.5){
							$celdas = 2;
							
						} else if((($cuenta%4)/4) == 0.75){
							$celdas = 3;
							
						} else if(($cuenta%4)     == 0){
							$celdas = 4;
							
						}
						
						$i = 1;
						
						for($a = 1; $a <= $filas; $a++){
							echo "<tr>";
							for($e = 1; $e <= 4; $e++){
							
									if ($usuarioPersonal[$i] == "2") {
										echo "</tr>";
										echo "<tr height='10px'></tr>";
										echo "<tr id='titulo2'>";
											echo "<td align='left' colspan='4'>Asistentes externos</td>";
										echo "</tr>";
										
										echo "<tr>";
											echo "<td id='titleBlueLineBottom' colspan='4'></td>";
										echo "</tr>
										<tr><td align='left' colspan='4' width='660'><input type='button' id='botonAsistentes' onclick=\"muestra_ocultaDiv('asistentesExternos','')\" value='Agregar'></input></td></tr>
										<table id='asistentesExternos' align='center' style='display:none'>";
										echo "<tr>";
										
									}else{

										if($INTRANETV2->getOne("SELECT xt_usuario FROM SGI_Reunion_Asistentes WHERE xt_codigoReunion = '$codigoReunion' AND xt_usuario = '$usuarioPersonal[$i]' ")){
											
											echo "<td width='165px' id='fileItem'>";
												echo "<input type='checkbox' name='asistencia[]' value='".$usuarioPersonal[$i]."' checked>".$nombreCorto[$i];
											echo "</td>";
											
										} else{
											
											echo "<td width='165px' id='fileItem'>";
												echo "<input type='checkbox' name='asistencia[]' value='".$usuarioPersonal[$i]."'>".$nombreCorto[$i];
											echo "</td>";
										}
									}
								
								$i++;
								
								if($i > $cuenta){
									break;
								}
								
							}
							
							if(($filas == $a) && ($celdas == $e)){
								
								if($celdas == 1){
									echo "<td width='165px'></td>";
									echo "<td width='165px'></td>";
									echo "<td width='165px'></td>";
									
								} else if($celdas == 2){
									echo "<td width='165px'></td>";
									echo "<td width='165px'></td>";
									
								} else if($celdas == 3){
									echo "<td width='165px'></td>";
								}
								
								break;
							}
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
				
				echo "<td width='15px' align='center'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
				echo "</td>";
			echo "</tr>";
		echo "</table></table>";
	
	//Temas a tratar de la revision
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 2. Temas a tratar</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
			
			$s = $INTRANETV2->Execute("SELECT xn_numeroTema, xt_texto, xt_ruta FROM SGI_Reunion_Temas WHERE xt_codigoReunion = '$codigoReunion' ORDER BY xn_numeroTema");		
			
			while($r = $s->fetchRow()){
				
				$subElemento 		= $r[0];
				$textoSubElemento 	= $r[1];
				$rutaTema           = $r[2];

				$arregloExiste[$i]=$subElemento;

				$tema = $INTRANETV2->getOne("SELECT xt_tema FROM SGI_Catalogo_Temas_Reuniones WHERE xn_temaId = $subElemento");
				echo "<tr>";
					echo "<td></td>";
					
					echo "<td id='iconosTexto' colspan='2'>";
						echo "<a name='2_".$subElemento."' id='iconosTexto'>";
							echo $tema;
						echo "</a>";
					echo "</td>";
					
				if($rutaTema == ''){
						echo "<td>";
							echo "<a href='AgregarArchivoReunionPopUp.php?reunionID=".$codigoReunion."&elemento=tema&sub=".$subElemento."' target='popup' 
								 onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\">";
								echo "<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
							echo "</a>";
						echo "</td>";

					echo "</tr>";
				}else{	
					echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td colspan='2' id='textIntro'>";
							echo "<i>".$rutaTema."</i> <a href='../downloadReunion.php?file=".$rutaTema."' ><img src='../../Imagenes/ICN_Archivo.png'></a>";
						echo "</td>";
					echo "</tr>";
				}
					
				
				echo "<tr height='10px'><td colspan='4'></td></tr>";
				
				echo "<tr>";
					echo "<td width='20px'></td>";
					
					echo "<td width='20px'></td>";
					
					echo "<td width='645px'>";
						echo "<textarea  name='tema,".$subElemento."' style='width: 645px; height:200px;'>".$textoSubElemento."</textarea>";
					echo "</td>";
					
					echo "<td width='15px' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td colspan='4'></td></tr>";
				
			} unset($u); unset($r); unset($s);

		echo "</table>";
		
	//3 Resultados de la revision
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b>3. Resultados de la revisión</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				
				echo "<td id='iconosTexto' colspan='2'>";
					echo "<a name='3_1' id='iconosTexto'>Resultados</a>";
				echo "</td>";
				
				echo "<td>";
					echo "<a href='AgregarArchivoReunionPopUp.php?reunionID=".$codigoReunion."&elemento=revision' target='popup' 
						  onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\"> ";
						echo "<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
					echo "</a>";
				echo "</td>";
				
			echo "</tr>";
			
			// Muestra la seccion de la revision de la revision
			$s = $INTRANETV2->Execute("SELECT xt_texto, xt_ruta FROM SGI_Reunion_Revisiones WHERE xt_codigoReunion = '$codigoReunion' ");
			
			while($r = $s->fetchRow()){
				$textoRevision = $r[0];
				$rutaRevision  = $r[1];
				
				if($rutaRevision != ''){
					echo "<tr>";
						echo "<td width='20px'></td>";

						echo "<td width='20px'></td>";

						echo "<td colspan='2' id='textIntro'>";
							echo "<i>".$rutaRevision."</i> <a href='../downloadReunion.php?file=".$rutaRevision."' >";
								echo "<img src='../../Imagenes/ICN_Archivo.png'>";
							echo "</a>";
						echo "</td>";

					echo "</tr>";

					echo "<tr height='10px'><td colspan='4'></td></tr>";
				}
		
				
			} unset($r); unset($s);
			
			echo "<tr>";
				echo "<td width='20px'></td>";

				echo "<td width='20px'></td>";

				echo "<td width='645px'>";
					echo "<textarea name='revisionReunion' style='width: 645px; height:200px;'>".$textoRevision."</textarea>";
				echo "</td>";

				echo "<td width='15px' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>";
				echo "</td>";

			echo "</tr>";
			
			echo "<tr height='50px'><td colspan='4'></td></tr>";
		echo "</table>";
		
	//ACUERDOS
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>Acuerdos</b></td>";
				
				echo "<td align='right'>";
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Eibar_Ponce')|| ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'sdelap')|| ($usuarioId == 'Christian_Martinez')|| ($usuarioId == 'gabriel')|| ($usuarioId == 'Miguel_Patiño') || ($usuarioId == 'Gerardo_Nunez')|| ($usuarioId == 'Jorge_Doring')|| ($usuarioId == 'Dalia_Mosqueda')|| ($usuarioId == 'Miguel_Patiño') || ($usuarioId == 'Adlemy_Tah')){
						
						echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block;'>";
						echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(0);' id='ocultar' style='display:none;'>";
						
					}
				echo "</td>";	
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
					
			echo "<tr height='20'><td colspan='2'></td></tr>";
	
		echo "</table>";
		
		if(count($codigoAc) >= 1){
				
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' id='iconosTexto2'>Código</td>";
					echo "<td align='left' id='iconosTexto2'>Titulo</td>";
					echo "<td align='left' id='iconosTexto2'>Estatus</td>";
					echo "<td align='left' id='iconosTexto2'>PDR</td>";
					echo "<td align='center' id='iconosTexto2'>Fecha</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='3'></td></tr>";
					
				for($a = 0; $a <= count($codigoAc); $a++){
					
					echo "<tr>";
						echo "<td width='150px' align='center'>";
							echo "<a href='fichaAcuerdov2.php?acuerdo=".$codigoAc[$a]."' id='fileItem' style='text-decoration:none;'>";
								echo $codigoAc[$a];
							echo "</a>";
						echo "</td>";
						
						echo "<td align='left' width='210px' id='fileItem'>".$tituloAc[$a]."</td>";
						echo "<td align='left' width='110px' id='fileItem'>".$statusd[$a]."</td>";
						echo "<td align='left' width='110px' id='fileItem'>".$pdr[$a]."</td>";
						
						echo "<td align='center' width='90px' id='fileItem'>".$fechaAc[$a]."</td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='3'></td></tr>";
					
				} unset($a);
			
			echo "</table>";
			
		}
		
		echo "<form method='POST' action='ReunionElementoActualizarv2.php?id=".$codigoReunion."' enctype='multipart/form-data'>";
			echo "<table border='0' align='center' width='500px' id='formularioAcuerdo' style='display:none;'>";
			
				echo "<tr><td id='titleBlueLineBottom' width='500px'></td></tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left'>Fecha</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='left'><input type='text' class='DatP' name='fechaAcuerdo' size='10'></td>";
				echo "</tr>";
		
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left'>Título</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='left'>";
						echo "<input type='text' name='tituloAcuerdo' size='68'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left'>Descripción</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='left'>";
						echo "<textarea name='descripcionAcuerdo' style='width:447px; height:100px;'></textarea>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td></td></tr>";
			echo "</table>";
		
	//FINALIZAR
		echo "<table border='0' align='center' width='700px'>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td align='right' width='700px'>";
					echo "<input type='hidden' name='terminar' value=''/>";
					echo "<input type='image' onClick=\"this.form.terminar.value='Close';this.form.submit();\" src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo "</td>";	
			echo "</tr>";
			
			echo "<tr height='50px'><td></td></tr>";
	
		echo "</table>";
	
	echo "</form>";
echo "</div>";

}

?>
		</body>
	</html>
<?php
	

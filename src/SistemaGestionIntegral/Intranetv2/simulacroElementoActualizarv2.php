<?php
$nombrephp = 'ReunionElementoActualizar.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);
if(!empty($_POST['simulacro'])){
	
	$codigo = $_POST['simulacro'];
	
} else if($_GET['simulacro'] != ""){
	
	$codigo = $_GET['simulacro'];
	
}
$INTRANETV2->Execute("set names 'utf8'");
$registro = $INTRANETV2->getRow("
		SELECT
			xt_nombreSimulacro,
			xt_descripcionSimulacro,
			xd_fechaInicio,
			xd_fechaFinalizacion,
			xt_pdrSimulacro,
			xt_statusSimulacro,
			xt_ciudad,
			CASE xt_ciudad
			WHEN 'CMX' THEN
				'DF'
			ELSE
				xt_ciudad
			END,
			xd_fechaProgramada,
			xt_tipoSimulacro,
			xt_alcanceSimulacro,
            CASE xt_statusSimulacro 
            WHEN 1 THEN 
                'Sin asignar' 
            WHEN 2 THEN 
                'Asignado' 
            WHEN 3 THEN 
                'En proceso' 
            WHEN 4 THEN 
                'Por evaluar'
            WHEN 5 THEN 
                'Terminado'                                                          
            END 
		FROM
			SGI_Simulacros
		WHERE
			xt_codigoSimulacro = '".$codigo."'
	");
$titulo         	    = $registro[0];
$descripcion    	    = $registro[1];
if(empty($registro[8])){
	$fechaProgramada 	= "";
} else {
	$fechaProgramada	= date_create($registro[8]);
	$fechaProgramada	= date_format($fechaProgramada, 'Y-m-d');	
}

// $fechaHoraProgramada    = new DateTime($registro[8]);
// $fechaHoraProgramada    = $fechaHoraProgramada->format('d-m-Y H:i:s');
// $fechaHoraProgramada    = date('Y-m-d H:i:s',strtotime($registro[8]));

if(empty($registro[2])){
	$fechaHoraInicio    = "";
}else {
	$fechaInicio		= date_create($registro[2]);
	$fechaInicio		= date_format($fechaInicio, 'Y-m-d');
}
// $fechaHoraInicio	    = new DateTime($registro[2]);
// $fechaHoraInicio    	= $fechaHoraInicio->format('d-m-Y H:i:s');
// $fechaHoraInicio		= date('Y-m-d H:i:s',strtotime($registro[2]));
if(empty($registro[3])){
	$fechaHoraFinalizacion = "";
} else {
	$fechaFinalizacion	= date_create($registro[3]);
	$fechaFinalizacion	= date_format($fechaFinalizacion, 'Y-m-d');
}
// $fechaHoraFinalizacion	= new DateTime($registro[3]);
// $fechaHoraFinalizacion  = $fechaHoraFinalizacion->format('d-m-Y H:i:s');
// $fechaHoraFinalizacion  = date('Y-m-d H:i:s',strtotime($registro[3]));
$pdr			   	    = $registro[4];
$ciudadSimulacro    	= $registro[6];
$ciudadSimulacroPDR 	= $registro[7];
$tipoSimulacro			= $registro[9];
$alcanceSimulacro		= $registro[10];
$status					= $registro[11];

if((!empty($registro[2]))&&(!empty($registro[4]))){
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("
			UPDATE
				SGI_Simulacros
			SET
				xt_statusSimulacro = '3'
			WHERE
				xt_codigoSimulacro = '".$codigo."'
		");
} elseif ((!empty($registro[2]))||(empty($registro[4]))){
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("
			UPDATE
				SGI_Simulacros
			SET
				xt_statusSimulacro = '1'
			WHERE
				xt_codigoSimulacro = '".$codigo."'
		");
} elseif ((empty($registro[2]))||(!empty($registro[4]))){
	$INTRANETV2->Execute("set names 'utf8'");
	$INTRANETV2->Execute("
			UPDATE
				SGI_Simulacros
			SET
				xt_statusSimulacro = '2'
			WHERE
				xt_codigoSimulacro = '".$codigo."'
		");
}
$INTRANETV2->Execute("set names 'utf8'");
$status = $INTRANETV2->getOne("
		SELECT
            CASE xt_statusSimulacro 
            WHEN 1 THEN 
                'Sin asignar' 
            WHEN 2 THEN 
                'Asignado' 
            WHEN 3 THEN 
                'En proceso' 
            WHEN 4 THEN 
                'Por evaluar'
            WHEN 5 THEN 
                'Terminado'                                                          
            END 
		FROM
			SGI_Simulacros
		WHERE
			xt_codigoSimulacro = '".$codigo."'
	");
if ($ciudadSimulacroPDR == 'GRL'){
	$contador = 0;
	$INTRANET2->Execute("set names 'utf8'");
	$conjuntoRegistroEmpleados = $INTRANET->Execute("
			SELECT DISTINCT
					SE.kf_usuario, IUO.xt_codigoCiudad, SE.xt_Nombre, SE.xt_ApellidoPaterno
			FROM
				SGI_Empleados SE
			INNER JOIN 
				IntranetGEA_Usuarios_Oficina IUO
			ON 
				SE.kf_usuario = IUO.kf_usuarioId
		");			
	while($registroEmpleados = $conjuntoRegistroEmpleados->fetchRow()){
		if ($registroEmpleados[0] != null){
			$pdrSelect[$contador]      	  = $registroEmpleados[0];
			$pdrNombreSelect[$contador]   = $registroEmpleados[2];
			$pdrApellidoSelect[$contador] = $registroEmpleados[3];
			$contador++;
		}					
	} unset($registroEmpleados); unset($conjuntoRegistroEmpleados);	
} else {
	$contador = 0;
	$INTRANET->Execute("set names 'utf8'");
	$conjuntoRegistroEmpleados = $INTRANET->Execute("
			SELECT DISTINCT
					SE.kf_usuario, IUO.xt_codigoCiudad, SE.xt_Nombre, SE.xt_ApellidoPaterno
			FROM
				SGI_Empleados SE
			INNER JOIN 
				IntranetGEA_Usuarios_Oficina IUO
			ON 
				SE.kf_usuario = IUO.kf_usuarioId
			WHERE
				xt_codigoCiudad = '".$ciudadSimulacro."'
		");			

	while($registroEmpleados = $conjuntoRegistroEmpleados->fetchRow()){
		if ($registroEmpleados[0] != null){
			$pdrSelect[$contador] 		  = $registroEmpleados[0];
			$pdrNombreSelect[$contador]   = $registroEmpleados[2];
			$pdrApellidoSelect[$contador] = $registroEmpleados[3];			
			$contador++;
		}					
	} unset($registroEmpleados); unset($conjuntoRegistroEmpleados);		
}

$tipoRiesgos[1] = "Seguridad";
$tipoRiesgos[2] = "Calidad";
$tipoRiesgos[3] = "Proceso";

$valorTipoRiesgo[1] = "SEGURIDAD";
$valorTipoRiesgo[2] = "CALIDAD";
$valorTipoRiesgo[3] = "PROCESO";

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'> Home / </a>
			 <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			 <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a>
			 <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/tableroSimulacros.php' id='breadcrumbs'> Tablero simulacros </a>";


header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Simulacro</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
				function mostrarCamposGenerales(){
					var camposGenerales = document.getElementsByClassName("modificaCamposGenerales");
					var etiquetasGenerales = document.getElementsByClassName("etiquetasGenerales");
					var botonModificar   = document.getElementById('botonModificarGenerales');
					var indice;
					for (indice = 0; indice < camposGenerales.length; indice++) {
					    camposGenerales[indice].style.display  ='block';
					}
					for (indice = 0; indice < etiquetasGenerales.length; indice++) {
					    etiquetasGenerales[indice].style.display  ='none';
					}					
					botonModificar.style.display   ='none';
				}
				function actualizarCamposGenerales(simulacro) { 
					var campoNombre = document.forms.formulario.titulo;
    				var nombre = campoNombre.value;
    				var campoDescripcion = document.forms.formulario.descripcion;
    				var descripcion = campoDescripcion.value;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizarFicha(simulacro);
							}else{
								alert("Hubo un error al actualizar los campos generales.");
							}
						}
					};
					xhttp.open("POST", "agregaCamposGenerales.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizarCamposGenerales&simulacro="+simulacro+"&nombre="+nombre+"&descripcion="+descripcion);
				}				
				function mostrarCampoPDR(){
					var camposPDR = document.getElementsByClassName("modificaCampoPDR");
					var etiquetasPDR = document.getElementsByClassName("etiquetaPDR");
					var botonModificarPDR   = document.getElementById('botonModificarPDR');

					for (indice = 0; indice < camposPDR.length; indice++) {
					    camposPDR[indice].style.display  ='block';
					}
					for (indice = 0; indice < etiquetasPDR.length; indice++) {
					    etiquetasPDR[indice].style.display  ='none';
					}							
					botonModificarPDR.style.display ='none';
				}
				function actualizarCampoPDR(simulacro) { 
					var campoPDR = document.forms.formulario.pdr;
    				var nombre = campoPDR.value;
    				if (nombre.length == 0){
    					nombre = 'null';
    				}
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizarFicha(simulacro);
							}else{
								alert("Hubo un error al actualizar el campo del PDR.");
							}
						}
					};
					xhttp.open("POST", "agregaCampoPDR.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("simulacro="+simulacro+"&pdr="+nombre);
				}		
				function mostrarCamposFechas(){
					var camposFechas = document.getElementsByClassName("modificaCamposFechas");
					var etiquetasFechas = document.getElementsByClassName("etiquetasFechas");
					var botonModificarFechas   = document.getElementById('botonModificarFechas');

					for (indice = 0; indice < camposFechas.length; indice++) {
					    camposFechas[indice].style.display  ='table-row';
					}
					for (indice = 0; indice < etiquetasFechas.length; indice++) {
					    etiquetasFechas[indice].style.display  ='none';
					}							
					botonModificarFechas.style.display ='none';
				}
				function actualizarCamposFechas(simulacro) { 
					var campoFechaProgramada = document.forms.formulario.fechaProgramada;
					var campoFechaInicio = document.forms.formulario.fechaInicio;
					var campoFechaFinalizacion = document.forms.formulario.fechaFinalizacion;
    				var fechaProgramada = campoFechaProgramada.value;
    				var fechaInicio = campoFechaInicio.value;
    				var fechaFinalizacion = campoFechaFinalizacion.value;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizarFicha(simulacro);
							}else{
								alert("Hubo un error al actualizar los campos de las fechas.");
							}
						}
					};
					xhttp.open("POST", "agregaCamposFechas.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("simulacro="+simulacro+"&fechaProgramada="+fechaProgramada+"&fechaInicio="+fechaInicio+"&fechaFinalizacion="+fechaFinalizacion);
				}
				function mostrarCampoTipo(){
					var camposTipo = document.getElementsByClassName("modificaCampoTipo");
					var etiquetasTipo = document.getElementsByClassName("etiquetasTipo");
					var botonModificarTipo = document.getElementById('botonModificarTipo');

					for (indice = 0; indice < camposTipo.length; indice++) {
					    camposTipo[indice].style.display  ='table-row';
					}
					for (indice = 0; indice < etiquetasTipo.length; indice++) {
					    etiquetasTipo[indice].style.display  ='none';
					}							
					botonModificarTipo.style.display ='none';
				}
				function actualizarCampoTipo(simulacro) { 
					var campoTipo = document.forms.formulario.tipo;
    				var tipo = campoTipo.value;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizarFicha(simulacro);
							}else{
								alert("Hubo un error al actualizar el campo tipo.");
							}
						}
					};
					xhttp.open("POST", "agregaCampoTipo.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("simulacro="+simulacro+"&tipo="+tipo);
				}
				function mostrarCampoAlcance(){
					var campoAlcance = document.getElementsByClassName("modificaCampoAlcance");
					var etiquetaAlcance = document.getElementsByClassName("etiquetaAlcance");
					var botonModificarAlcance = document.getElementById('botonModificarAlcance');
					var botonGuardar = document.getElementsByClassName("botonGuardar");

					for (indice = 0; indice < campoAlcance.length; indice++) {
					    campoAlcance[indice].style.display  ='table-row';
					}
					for (indice = 0; indice < etiquetaAlcance.length; indice++) {
					    etiquetaAlcance[indice].style.display  ='none';
					}				
					botonModificarAlcance.style.display ='none';
				}
				function actualizarCampoAlcance(simulacro) { 
					var campoAlcance = document.forms.formulario.alcance;
    				var alcance = campoAlcance.value;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizarFicha(simulacro);
							}else{
								alert("Hubo un error al actualizar el campo tipo.");
							}
						}
					};
					xhttp.open("POST", "agregaCampoAlcance.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("simulacro="+simulacro+"&alcance="+alcance);
				}				
				function actualizarFicha(simulacro){
					window.location = 'simulacroElementoActualizarv2.php?simulacro=' + simulacro;
				}
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
				$(function(){
					$("#fechaProgramada").datepicker({ dateFormat: 'yy-mm-dd',
					 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
					 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']						
					 });					
					$("#fechaInicio").datepicker({ dateFormat: 'yy-mm-dd',
					 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
					 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']						
					 });
					$("#fechaFinalizacion").datepicker({ dateFormat: 'yy-mm-dd',
					 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
					 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']						
					 });						
				});
			</script>      
        </head>
        <body>
<?php

echo "<div id='wrapperFicha' align='center'>";
	echo "<form id='formulario' method='post' action='simulacroElementoActualizarv2.php?simulacro=".$codigo."'>";
		///POST DEL ID
		echo "<input type='hidden' name='simulacro' value='".$codigo."'>";
		
		echo "<table border='0' align='center' name='Encabezado'>";	
			echo "<tr>";
				echo "<td id='breadcrumbs' align='left'>Usuario: ".$usuarioId."</td>";
			echo "</tr>";
			echo "<tr height='80px'>";
				echo "<td id='breadcrumbs'>Fecha: ".$fechaProgramada."</td>";
			echo "</tr>";
			///Titulo 
			echo "<tr>";
				echo "<td align='center' id='titulo1' width='700px'>";
					echo "Simulacro<br>";
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
		echo "</table>";

		//banana de navegacion intranet
		echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
			include("../../navegacion_banana.php");
		echo "</table>";
			
		echo "<table border='0' align='center'>";
			echo"<tr height='100'><td></td></tr>";
		echo "</table>"; 	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='6'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b> 1. Generales</b></td>";
				echo"<td align='right' colspan='2' id='iconosTexto2' style='width:20%'>";						
					if($status != ''){
						echo "<b>Status: ".ucwords(strtolower($status))."</b>";
					}		
				echo"</td>";			
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='20px'><td colspan='5'></td></tr>";
			echo "<tr class='etiquetasGenerales'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$titulo."</span>";
				echo "</td>";
				echo "<td class='modificaCamposGenerales' align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarGenerales' onClick='mostrarCamposGenerales()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr height='10'></td></tr>";		
			echo "<tr class='etiquetasGenerales'>";
				echo "<td style='width:20px;'>";
				echo "</td>";
				echo "<td class='iconosTexto' style='margin: 0 0 0 10%; width:80%; padding-right:5%;'>";
					echo "<span style='font-size: 90%;'>".$descripcion."</span>";
				echo "</td>";
			echo "</tr>";
			echo "<tr class='modificaCamposGenerales' style='display:none;'>";
				echo "<td class='iconosTexto' style='width:10%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Título:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>";
				echo "</td>";
				echo "<td>";
					echo "<input style='margin:0 10px 0 10px' type='text' name='titulo' size='52' value='".$titulo."'>";
				echo "</td>";
				echo "<td align='right'>";
					echo "<a style='cursor:pointer'  onClick='actualizarCamposGenerales(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCamposGenerales' style='display:none;'>";
				echo "<td class='iconosTexto' valign='top' style='width:10%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Descripción:</b>";
				echo "</td>";
				echo "<td>";
					echo "<textarea name='descripcion' style='width: 400px; height: 150px; margin:0 10px 0 10px'>";
					echo $descripcion;
					echo "</textarea>";
				echo "</td>";
				echo "<td style='width:10%'> </td>";
			echo "</tr>";		
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='6'></td></tr>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b> 2. Riegos a tratar</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a href='modificarRiesgosPopUpv2.php?simulacro=$codigo' target='popup' onclick=\"window.open(this.href,this.target,'width=450,height=550');\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a></td>";					
			echo "</tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";			
			echo"<tr height='20px'><td colspan='5'></td></tr>";
			$contador = 0;
			$INTRANETV2->Execute("set names 'utf8'");
			$conjuntoRegistrosRiesgo = $INTRANETV2->Execute("
				SELECT
					SR.xt_codigoRiesgo,
					SR.xt_tituloRiesgo
				FROM
					SGI_Riesgos_Simulacros SRS,
					SGI_Riesgos SR
				WHERE
					SRS.xt_codigoSimulacro = '".$codigo."'
				AND 
					SR.xt_codigoRiesgo = SRS.xt_codigoRiesgo
			");
			while($registroRiesgo = $conjuntoRegistrosRiesgo->fetchRow()){
				$codigoRiesgo[$contador] = $registroRiesgo[0];
				$tituloRiesgo[$contador]  = $registroRiesgo[1];
				$contador++;
			}unset($conjuntoRegistrosRiesgo);unset($registroRiesgo);unset($contador);
			if (!empty($codigoRiesgo)){
				echo "<tr>";
					echo "<td style='width:20px;'>";
					echo "</td>";
					echo "<td>";
						echo "<b>Código</b>";
					echo "</td>";
					echo "<td>";
						echo "<b>Riesgo</b>";
					echo "</td>";			
				echo "</tr>";
				for($o = 0; $o <= count($codigoRiesgo) - 1; $o++){
					echo "<tr>";
						echo "<td width='20px'></td>";
						echo "<td id='iconosTexto3' style='margin-left:1em'>";
							echo $codigoRiesgo[$o];
						echo "</td>";
						echo "<td id='iconosTexto3' style='margin-left:1em'>";
							echo $tituloRiesgo[$o];
						echo "</td>";					
					echo "</tr>";
				}
			}
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 3. Tipo</b></td>";
			echo "</tr>";	
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			echo"<tr height='20px'><td colspan='4'></td></tr>";		
			echo "<tr class='etiquetasTipo'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$tipoSimulacro."</span>";
				echo "</td>";
				echo "<td class='modificaCampoTipo' align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarTipo' onClick='mostrarCampoTipo()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCampoTipo' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' style='width:10%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Tipo</b>";
				echo "</td>";
				echo "<td>";
					echo "<select name='tipo'>";
						echo "<option value=''>Elegir...</option>";
						
						for($o = 1; $o <= 3; $o++){
							
							echo "<option value='".$valorTipoRiesgo[$o]."'>".$tipoRiesgos[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";		
			echo "</tr>";
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 4. PRD (Persona Directamente Responsable)</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='20px'><td colspan='5'></td></tr>";
			echo "<tr class='etiquetaPDR'>";
			echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='margin-left: 10px; width:80%; padding-right:5%;'>";
					echo "<span>".$pdr."</span>";
				echo "</td>";
				echo "<td align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarPDR' onClick='mostrarCampoPDR()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCampoPDR' style='display:none;'>";
				echo "<td class='iconosTexto' style='width:10%;'>";
					echo "<b style='margin:0 10px 0 10px;'>PDR:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>";
				echo "</td>";
				echo "<td>";
					echo "<select name='pdr' width='100%'>";
						echo "<option value=''>Elegir...</option>";						
						for($indice = 0; $indice <count($pdrSelect); $indice++){
							echo "<option value='".$pdrSelect[$indice]."'>".$pdrNombreSelect[$indice]. " ".$pdrApellidoSelect[$indice]. "</option>";					
						}unset($indice);						
					echo "</select>";
				echo "</td>";
				echo "<td align='right'>";
					echo "<a style='cursor:pointer'  onClick='actualizarCampoPDR(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 5. Fechas</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";

			echo"<tr height='20px'><td colspan='5'></td></tr>";

			echo "<tr class='etiquetasFechas'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' style='width:40%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Fecha programada:</b>";
				echo "</td>";
				echo "<td class='iconosTexto' colspan='2' style='margin-left: 10px; width:80%; padding-right:5%;'>";
					echo "<span>".$fechaProgramada."</span>";
				echo "</td>";
				echo "<td align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarFechas' onClick='mostrarCamposFechas()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";
			echo "<tr class='etiquetasFechas'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' style='width:40%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Fecha de inicio:</b>";
				echo "</td>";
				echo "<td class='iconosTexto' colspan='2' style='margin-left: 10px; width:80%; padding-right:5%;'>";
					echo "<span>".$fechaInicio."</span>";
				echo "</td>";						
			echo "</tr>";
			echo "<tr class='etiquetasFechas'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' style='width:40%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Fecha de finalización:</b>";
				echo "</td>";
				echo "<td class='iconosTexto' colspan='2' style='margin-left: 10px; width:80%; padding-right:5%;'>";
					echo "<span>".$fechaFinalizacion."</span>";
				echo "</td>";						
			echo "</tr>";
			echo "<tr class='modificaCamposFechas' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' style='width:40%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Fecha programada:</b>";
				echo "</td>";
				echo "<td style='width:20%;'>";
					echo "<input type='text' name='fechaProgramada' id='fechaProgramada' value='".$fechaProgramada."' size='11'/>";
				echo '</td>';
				echo "<td align='right'>";
					echo "<a style='cursor:pointer'  onClick='actualizarCamposFechas(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";			
			echo "<tr class='modificaCamposFechas' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' style='width:40%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Fecha inicio:</b>";
				echo "</td>";
				echo "<td style='width:20%;'>";
					echo "<input type='text' name='fechaInicio' id='fechaInicio' value='".$fechaInicio."' size='11'/>";
				echo '</td>';	
			echo "</tr>";
			echo "<tr class='modificaCamposFechas' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' style='width:40%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Fecha finalización:</b>";
				echo "</td>";
				echo "<td style='width:20%;'>";
					echo "<input type='text' name='fechaFinalizacion' id='fechaFinalizacion' value='".$fechaFinalizacion."' size='11'/>";
				echo '</td>';
			echo "</tr>";		
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";		

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 6. Alcance</b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='20px'><td colspan='5'></td></tr>";
			echo "<tr class='etiquetaAlcance'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$alcanceSimulacro."</span>";
				echo "</td>";
				echo "<td class='modificaCampoAlcance' align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarAlcance' onClick='mostrarCampoAlcance()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCampoAlcance' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td>";
					echo "<textarea name='alcance' style='width: 400px; height: 150px; margin:0 10px 0 10px'>";
					echo $alcanceSimulacro;
					echo "</textarea>";
				echo "</td>";
				echo "<td class='botonGuardar' align='right' valign='top' style='width:30%;'>";
					echo "<a style='cursor:pointer; valign:top; align:right;'  onClick='actualizarCampoAlcance(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";				
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 7. Participantes</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a href='modificarParticipantesPopUpv2.php?simulacro=$codigo&ciudad=$ciudadSimulacro' target='popup' onclick=\"window.open(this.href,this.target,'width=450,height=550');\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='20px'><td colspan='5'></td></tr>";
				$indice = 0;
				//LISTA DE PARTCIPANTES EXISTENTES
				$INTRANETV2->Execute("set names 'utf8'");
				$conjuntoRegistroParticipantesSimulacro = $INTRANETV2->Execute("
					SELECT DISTINCT
						xt_codigoParticipante
					FROM
						SGI_Simulacros_Participantes
					WHERE
						xt_codigoSimulacro = '".$codigo."'
					");
				while($registroParticipanteSimulacro = $conjuntoRegistroParticipantesSimulacro->fetchRow()){
					$codigoParticipanteSimulacro[$indice]   = $registroParticipanteSimulacro[0];
					$indice++;	
				}
				$index = 0;
				//LISTA DE PARTCIPANTES EXISTENTES
				$INTRANET->Execute("set names 'utf8'");
				$conjuntoRegistroParticipantes = $INTRANET->Execute("
					SELECT DISTINCT
						SE.kf_usuario, SE.xt_Nombre, SE.xt_ApellidoPaterno
					FROM
						SGI_Empleados SE
					INNER JOIN 
						IntranetGEA_Usuarios_Oficina IUO
					ON 
						SE.kf_usuario = IUO.kf_usuarioId
					WHERE
						SE.kf_usuario IN ('".implode('\',\'', $codigoParticipanteSimulacro)."')
					");
				while($registroParticipante = $conjuntoRegistroParticipantes->fetchRow()){
					$codigoParticipante[$index]   = $registroParticipante[0];
					$nombreParticipante[$index]   = $registroParticipante[1];
					$apellidoParticipante[$index] = $registroParticipante[2];
					$index++;	
				}
				if (!empty($codigoParticipante)){
					for($o = 0; $o <= count($codigoParticipante) - 1; $o++){
						echo "<tr>";
							echo "<td style='width:20px'></td>";
							echo "<td id='iconosTexto3' style='margin-left:1em'>";
								echo $nombreParticipante[$o]." ".$apellidoParticipante[$o];
							echo "</td>";					
						echo "</tr>";
					}
				}
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";			

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 8. Avisos</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a href='modificarAvisosPopUp.php?simulacro=$codigo' target='popup' onclick=\"window.open(this.href,this.target,'width=450,height=550');\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='20px'><td colspan='5'></td></tr>";		
			$indice = 0;
			//LISTA DE PARTCIPANTES EXISTENTES
			$INTRANETV2->Execute("set names 'utf8'");
			$conjuntoRegistroAvisosSimulacro = $INTRANETV2->Execute("
				SELECT DISTINCT
					xt_codigoAviso
				FROM
					SGI_Simulacros_Avisos
				WHERE
					xt_codigoSimulacro = '".$codigo."'
				");
			while($registroAvisoSimulacro = $conjuntoRegistroAvisosSimulacro->fetchRow()){
				$codigoAvisoSimulacro[$indice]   = $registroAvisoSimulacro[0];
				$indice++;	
			}
			$index = 0;
			//LISTA DE PARTCIPANTES EXISTENTES
			$INTRANET->Execute("set names 'utf8'");
			$conjuntoRegistroAvisos = $INTRANETV2->Execute("
				SELECT
					xt_codigoAviso, xt_nombreAviso
				FROM
					SGI_Catalogo_Aviso
				WHERE
					xt_codigoAviso IN ('".implode('\',\'', $codigoAvisoSimulacro)."')			
				");
			while($registroAviso = $conjuntoRegistroAvisos->fetchRow()){
				$codigoAvisoCatalogo[$index] = $registroAviso[0];
				$nombreAvisoCatalogo[$index]  = $registroAviso[1];
				$index++;
			}unset($conjuntoRegistroAvisos);unset($registroAviso);	
			if (!empty($codigoParticipante)){
				for($o = 0; $o <= count($codigoParticipante) - 1; $o++){
					echo "<tr>";
						echo "<td style='width:20px'></td>";
						echo "<td id='iconosTexto3' style='margin-left:1em'>";
							echo $nombreAvisoCatalogo[$o];
						echo "</td>";					
					echo "</tr>";
				}
			}			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 9. Desarrollo</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a onClick=''><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";			

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 10. Evidencia</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a onClick=''><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 11. Recursos utilizados</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a onClick=''><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 12. Resultados</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a onClick=''><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";		

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 13. Evaluación</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a onClick=''><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 14. Seguimiento</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a onClick=''><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
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
echo "</div>";
?>
		</body>
	</html>
<?php
	
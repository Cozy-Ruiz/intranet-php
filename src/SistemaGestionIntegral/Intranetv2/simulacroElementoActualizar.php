<script type="text/javascript">
	
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
</script>
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
$registro = $INTRANETV2->getRow("
		SELECT
			xt_nombreSimulacro,
			xt_descripcionSimulacro,
			xd_fechaInicio,
			xd_fechaFinalizacion,
            CONCAT(
            (
                    SELECT
                        SE.xt_Nombre
                    FROM
                        IntranetGEA.SGI_Empleados SE
                    WHERE
                        SE.kf_usuario = xt_pdrSimulacro
            ),SPACE(1),
            (
                    SELECT
                        SE.xt_ApellidoPaterno
                    FROM
                        IntranetGEA.SGI_Empleados SE
                    WHERE
                        SE.kf_usuario = xt_pdrSimulacro
            )) as nombreCompleto,
			xt_statusSimulacro,
			xt_ciudad,
			xt_ciudad,
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
            END,
            xt_recursosSimulacro,
            xt_desarrolloSimulacro,
            xt_rutaDesarrollo,
            SUBSTRING_INDEX(xt_rutaDesarrollo,'/',-1),
            xt_resultadoSimulacro,
            CASE xt_evaluacionSimulacro 
            WHEN 1 THEN 
                'Eficaz'
            WHEN 2 THEN 
                'No eficaz'
            WHEN 3 THEN 
                'Parcial'                                                         
            END,
            xt_descripcionEvaluacionSimulacro   
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
$pdr			   	     		= $registro[4];
$ciudadSimulacro    	 		= $registro[6];
$ciudadSimulacroPDR 	 		= $registro[7];
$tipoSimulacro		 	 		= $registro[9];
$alcanceSimulacro		 		= $registro[10];
$status					 		= $registro[11];
$recursosSimulacro		 		= $registro[12];
$desarrolloSimulacro	 		= $registro[13];
$rutaDesarrollo 		 		= $registro[14];
$nombreArchivoDesarrollo 		= $registro[15];
$resultadoSimulacro		 		= $registro[16];
$evaluacionSimulacro	 		= $registro[17];
$descripcionEvaluacionSimulacro	= $registro[18];

if((!empty($registro[2]))&&(!empty($registro[4]))){
	$INTRANETV2->Execute("
			UPDATE
				SGI_Simulacros
			SET
				xt_statusSimulacro = '3'
			WHERE
				xt_codigoSimulacro = '".$codigo."'
		");
} else if ((!empty($registro[2]))||(empty($registro[4]))){
	$INTRANETV2->Execute("
			UPDATE
				SGI_Simulacros
			SET
				xt_statusSimulacro = '1'
			WHERE
				xt_codigoSimulacro = '".$codigo."'
		");
} else if ((empty($registro[2]))&&(!empty($registro[4]))){
	$INTRANETV2->Execute("
			UPDATE
				SGI_Simulacros
			SET
				xt_statusSimulacro = '2'
			WHERE
				xt_codigoSimulacro = '".$codigo."'
		");
}
if (!empty($registro[17])){
	$INTRANETV2->Execute("
			UPDATE
				SGI_Simulacros
			SET
				xt_statusSimulacro = '5'
			WHERE
				xt_codigoSimulacro = '".$codigo."'
		");	
}
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
	$conjuntoRegistroEmpleados = $INTRANET->Execute("
			SELECT DISTINCT
				SE.kf_usuario, SE.xt_Nombre, SE.xt_ApellidoPaterno
			FROM
				SGI_Empleados SE
			INNER JOIN 
				IntranetGEA_Usuarios_Oficina IUO
			ON 
				SE.kf_usuario = IUO.kf_usuarioId
			WHERE
				SE.xt_Estatus = 1
		");			
	while($registroEmpleados = $conjuntoRegistroEmpleados->fetchRow()){
		if ($registroEmpleados[0] != null){
			$pdrSelect[$contador]      	  = $registroEmpleados[0];
			$pdrNombreSelect[$contador]   = $registroEmpleados[1];
			$pdrApellidoSelect[$contador] = $registroEmpleados[2];
			$contador++;
		}					
	} unset($registroEmpleados); unset($conjuntoRegistroEmpleados);	
} else {
	$contador = 0;
	$conjuntoRegistroEmpleados = $INTRANET->Execute("
			SELECT
				SE.kf_usuario,
				CASE WHEN IUO.xt_codigoCiudad = 'DF' THEN 'CMX' ELSE IUO.xt_codigoCiudad  END  as Ciudad,
				SE.xt_Nombre,
				SE.xt_ApellidoPaterno	
			FROM
				SGI_Empleados SE,
				IntranetGEA.IntranetGEA_Usuarios_Oficina IUO,
				IntranetGEA.SGI_EmpleadosActividad A
			WHERE
				CASE WHEN IUO.xt_codigoCiudad = 'DF' THEN 'CMX' ELSE IUO.xt_codigoCiudad  END = '".$ciudadSimulacro."'
				AND SE.kf_usuario = IUO.kf_usuarioId
				AND SE.kp_personalId = A.kf_personalID
				AND A.xt_actividad = 'PDR'
				AND SE.xt_Estatus = 1
				ORDER BY SE.xt_Nombre
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
			<link type='text/css' rel='stylesheet' href='css/maquetacionSimulacro.css'/>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
           
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
            <script type="text/javascript" src="js/comportamientoSimulacro.js"></script>   
            <script type="text/javascript">;
		        $(document).ready(function(){
		            $("#slider").easySlider({
		                auto: false,
		                continuous: true
		            });
		        });         
                $(function(){
                    $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                     monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                     dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                    
                     });
                });
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
		    <script type="text/javascript" src="js/easySlider1.7.js"></script>
        </head>
        <body>
<?php

echo "<div id='wrapperFicha' align='center'>";
	echo "<form id='formulario' method='post' action='simulacroElementoActualizar.php?simulacro=".$codigo."'>";
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
			echo "<tr height='50px'><td colspan='4'></td></tr>";

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
			echo"<tr height='30px'><td colspan='5'></td></tr>";
			echo "<tr class='etiquetasGenerales'>";
				echo "<td style='width:4%;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$titulo."</span>";
				echo "</td>";
				echo "<td class='modificaCamposGenerales' align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarGenerales' onClick='mostrarCamposGenerales()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";	
			echo "<tr class='etiquetasGenerales'>";
				echo "<td style='width:4%;'>";
				echo "</td>";
				echo "<td class='iconosTexto' style='margin: 0 0 0 10%; width:80%; padding-right:5%;'>";
					echo "<span style='font-size: 90%;'>".$descripcion."</span>";
				echo "</td>";
			echo "</tr>";
			echo "<tr class='modificaCamposGenerales' style='display:none;'>";
				echo "<td style='width:4%;'>";
				echo "</td>";
				echo "<td class='iconosTexto' style='width:10%;'>";
					echo "<b style='margin:0 10px 0 10px;'>Título:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>";
				echo "</td>";
				echo "<td>";
					echo "<input style='margin:0 10px 0 10px' type='text' name='titulo' size='52' value='".$titulo."'>";
				echo "</td>";
				echo "<td align='right' valign='top'>";
					echo "<a style='cursor:pointer' onClick='actualizarCamposGenerales(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCamposGenerales' style='display:none;'>";
				echo "<td style='width:4%;'>";
				echo "</td>";			
				echo "<td class='iconosTexto' valign='top' style='width:10%;'>";
					echo "<b>Descripción:</b>";
				echo "</td>";
				echo "<td>";
					echo "<textarea name='descripcion' style='width: 400px; height: 150px; margin:0 10px 0 20px'>";
					echo $descripcion;
					echo "</textarea>";
				echo "</td>";
				echo "<td style='width:10%'> </td>";
			echo "</tr>";		
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b> 2. Riesgos a tratar</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a href='modificarRiesgosPopUp.php?simulacro=$codigo' target='popup' onclick=\"window.open(this.href,this.target,'width=670,height=550');\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a></td>";					
			echo "</tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";			
			echo"<tr height='30px'><td colspan='5'></td></tr>";
			$contador = 0;
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
							
						echo "<td id='iconosTexto3' style='margin-left:1em'><a id='iconosTexto' href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaRiesgov2.php?id=".$codigoRiesgo[$o]."'>".$codigoRiesgo[$o]."</a></td>";
						
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
				echo "<td align='right'>";
					echo "<a style='cursor:pointer'  onClick='actualizarCampoTipo(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";					
			echo "</tr>";
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 4. PDR (Persona Directamente Responsable)</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='30px'><td colspan='5'></td></tr>";
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

			echo"<tr height='30px'><td colspan='5'></td></tr>";

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
			echo"<tr height='30px'><td colspan='5'></td></tr>";
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
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a href='modificarParticipantesPopUp.php?simulacro=$codigo&ciudad=$ciudadSimulacro' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=800');\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='30px'><td colspan='5'></td></tr>";
				if ($ciudadSimulacroPDR == 'GRL'){			
					$indice = 0;
					//LISTA DE PARTCIPANTES EXISTENTES
					$conjuntoRegistroParticipantesSimulacro = $INTRANETV2->Execute("
						SELECT DISTINCT
							xn_consecutivoParticipante
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
					$conjuntoRegistroParticipantes = $INTRANETV2->Execute("
						SELECT DISTINCT
							SP.xn_consecutivoParticipante, SP.xt_nombreParticipante, SP.xt_apellidoParticipante
						FROM
							SGI_Participantes SP
						INNER JOIN 
							SGI_Participantes_Ciudades SPC
						ON 
							SP.xn_consecutivoParticipante = SPC.xn_consecutivoParticipante
						WHERE
							SP.xn_consecutivoParticipante IN ('".implode('\',\'', $codigoParticipanteSimulacro)."')
						");
					while($registroParticipante = $conjuntoRegistroParticipantes->fetchRow()){
						$codigoParticipante[$index]   = $registroParticipante[0];
						$nombreParticipante[$index]   = $registroParticipante[1];
						$apellidoParticipante[$index] = $registroParticipante[2];
						$index++;	
					}
				} else {
					$indice = 0;
					//LISTA DE PARTCIPANTES EXISTENTES
					$conjuntoRegistroParticipantesSimulacro = $INTRANETV2->Execute("
						SELECT DISTINCT
							xn_consecutivoParticipante
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
					$conjuntoRegistroParticipantes = $INTRANETV2->Execute("
						SELECT DISTINCT
							SP.xn_consecutivoParticipante, SP.xt_nombreParticipante, SP.xt_apellidoParticipante
						FROM
							SGI_Participantes SP
						INNER JOIN 
							SGI_Participantes_Ciudades SPC
						ON 
							SP.xn_consecutivoParticipante = SPC.xn_consecutivoParticipante
						WHERE
							SP.xn_consecutivoParticipante IN ('".implode('\',\'', $codigoParticipanteSimulacro)."')
						AND CASE WHEN SPC.xt_ciudadParticipante = 'DF' THEN
							'CMX' ELSE SPC.xt_ciudadParticipante
							END  = '".$ciudadSimulacro."'
						");
					while($registroParticipante = $conjuntoRegistroParticipantes->fetchRow()){
						$codigoParticipante[$index]   = $registroParticipante[0];
						$nombreParticipante[$index]   = $registroParticipante[1];
						$apellidoParticipante[$index] = $registroParticipante[2];
						$index++;	
					}					
				}
				if (!empty($codigoParticipante)){
					for($o = 0; $o <= count($codigoParticipante) - 1; $o++){
						echo "<tr>";
							echo "<td style='width:20px'></td>";
							echo "<td id='iconosTexto3' style='margin-left:1em'>";
								echo $nombreParticipante[$o]." ".$apellidoParticipante[$o];
							echo "</td>";
							echo "<td align='right'><a href='eliminaParticipanteSimulacro.php?simulacro=".$codigo."&participante=".$codigoParticipante[$o]."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13' style='margin-right:10px;'/></a></td>";					
						echo "</tr>";
					}
				}
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";			

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 8. Avisos</b></td>";			
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a href='modificarAvisosPopUp.php?simulacro=$codigo' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=550');\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='30px'><td colspan='5'></td></tr>";			
			$indice = 0;
			//LISTA DE PARTCIPANTES EXISTENTES
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
			$conjuntoRegistroAvisos = $INTRANETV2->Execute("
					SELECT
						SCA.xt_codigoAviso,
						SCA.xt_nombreAviso,
						SSA.xt_rutaAvisoSimulacro,
            			SUBSTRING_INDEX(SSA.xt_rutaAvisoSimulacro,'/',-1),						
						SSA.xd_fechaCarga
					FROM
						SGI_Catalogo_Aviso SCA
					INNER JOIN
						SGI_Simulacros_Avisos SSA
					ON
						SCA.xt_codigoAviso = SSA.xt_codigoAviso
					WHERE
						SCA.xt_codigoAviso IN ('".implode('\',\'', $codigoAvisoSimulacro)."')
					AND
						xt_codigoSimulacro = '".$codigo."'
				");
			while($registroAviso = $conjuntoRegistroAvisos->fetchRow()){
				$codigoAvisoCatalogo[$index] = $registroAviso[0];
				$nombreAvisoCatalogo[$index] = $registroAviso[1];
				$rutaAviso[$index]			 = $registroAviso[2];
				$nombreArchivoAviso[$index]	 = $registroAviso[3];
				$fechaAviso[$index]			 = $registroAviso[4];
				$index++;
			}unset($conjuntoRegistroAvisos);unset($registroAviso);	
			if (!empty($codigoAvisoCatalogo)){
				for($o = 0; $o <= count($codigoAvisoCatalogo) - 1; $o++){
					echo"<tr height='10px'><td colspan='5'></td></tr>";					
					echo "<tr>";
						echo "<td style='width:4%'></td>";
						echo "<td id='iconosTexto3' style='margin-left:1em'>";
							echo $nombreAvisoCatalogo[$o];
						echo "</td>";
						if(($rutaAviso[$o] == "") || ($rutaAviso[$o] == NULL)){
							echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px;'>";	
								echo "<a href='AgregarArchivoAvisoSimulacroPopUp.php?simulacro=".$codigo."&aviso=".$codigoAvisoCatalogo[$o]."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
									echo "<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
								echo "</a>";	
							echo "</td>";													
						}											
					echo "</tr>";					
					if($rutaAviso[$o] != ""){

						if(substr($rutaAviso[$o], -4) == ".pdf"){
									echo"<tr height='30px'><td colspan='5'></td></tr>";	
									echo "<tr><td colspan='5'> ";
									echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents("../SeguimientoEtapas/".$rutaAviso[$o]))."'\" type='application/pdf' width='700px' height='700px'>";
										echo "<p>
													Si este mensaje aparece su navegador no soporta el plugin para el PDF.
													No obstante puede descargar el archivo en este</object>";
									echo "<br><br></td></tr>";
									
								}

								
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='5' style='width:600px;'> </td>";
						echo "</tr>";						
						echo"<tr height='10px'><td colspan='5'></td></tr>";
						echo "<tr>";
							echo "<td style='width:4%;'></td>";
							echo "<td id='textIntro'><i style='margin-left:5%;'>".$nombreArchivoAviso[$o]."</i></td>";
							echo "<td align='right'><a href='eliminaDocumentoAvisoSimulacro.php?simulacro=".$codigo."&aviso=".$codigoAvisoCatalogo[$o]."&ruta=".$rutaAviso[$o]."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13' style='margin-right:10px;'/></a></td>";
							echo "<td align='right' style='width:1%;'><a href='downloadAvisoSimulacro.php?file=".$rutaAviso[$o]."' ><img src='../../Imagenes/ICN_Archivo.png'></a></td>";
						echo "</tr>";
                        echo "<tr>";
							echo "<td style='width:4%;'></td>";
                            echo "<td style='color:#636262; padding:0px 0px 0px 30px'><i><font size=2>".$fechaAviso[$o]."</font></i></td>";
                        echo "</tr>";						
					}
					echo "<tr height='10'><td colspan='4'></td></tr>";				
				}
			}			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 9. Desarrollo</b></td>";
					if(($rutaDesarrollo == "") || ($rutaDesarrollo == NULL)){


						echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px;'>";	
							echo "<a href='AgregarArchivoSimulacroPopUp.php?simulacro=".$codigo."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">";
								echo "<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>";
							echo "</a>";	
						echo "</td>";													
					}
			echo "</tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			if($rutaDesarrollo != ""){
				echo "<tr><td>
				</td></tr>";
				if(substr($rutaDesarrollo, -4) == ".pdf"){
									echo"<tr height='30px'><td colspan='5'></td></tr>";	
									echo "<tr><td colspan='5'> ";
									echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents("../SeguimientoEtapas/".$rutaDesarrollo)."'\" type='application/pdf' width='700px' height='700px'>";
										echo "<p>
													Si este mensaje aparece su navegador no soporta el plugin para el PDF.
													No obstante puede descargar el archivo en este <a href='SeguimientoEtapas/".$rutaDesarrollo."'>enlance</a>
											  </p>";
									echo "</object>";
									echo "<br><br></td></tr>";
									
								}

								echo"<tr height='30px'><td colspan='5'></td></tr>";	
				echo "<tr>";
					echo "<td style='width:4%;'></td>";
					echo "<td id='textIntro'><i>".$nombreArchivoDesarrollo."</i></td>";		
					echo "<td align='right'><a href='eliminaDocumentoSimulacro.php?simulacro=".$codigo."&ruta=".$rutaDesarrollo."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
					echo "<td align='right' style='width:1%;'><a href='downloadSimulacro.php?file=".$rutaDesarrollo."' ><img src='../../Imagenes/ICN_Archivo.png'></a></td>";
				echo "</tr>";
			}
			echo"<tr height='10px'><td colspan='5'></td></tr>";				
			echo "<tr class='etiquetaDesarrollo'>";
				echo "<td style='width:4%;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$desarrolloSimulacro."</span>";
				echo "</td>";
				echo "<td class='modificaCampoDesarrollo' align='right' valign='top' style='width:30%;' colspan='3'>";
					echo "<a style='cursor:pointer' id='botonModificarDesarrollo' onClick='mostrarCampoDesarrollo()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCampoDesarrollo' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td>";
					echo "<textarea name='desarrollo' style='width: 400px; height: 150px; margin:0 10px 0 10px'>";
					echo $desarrolloSimulacro;
					echo "</textarea>";
				echo "</td>";
				echo "<td class='botonGuardar' align='right' valign='top' style='width:30%;' colspan='3'>";
					echo "<a style='cursor:pointer; valign:top; align:right;'  onClick='actualizarCampoDesarrollo(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";
									
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 10. Evidencia</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'><a href='AgregarEvidenciaPopUp.php?simulacro=$codigo&estiloUsuario=$estiloUsuario' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=550');\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a></td>";				
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='30px'><td colspan='5'></td></tr>";			
			$indice = 0;
			$contadorImagenes = 0;
			//LISTA DE PARTCIPANTES EXISTENTES
			$conjuntoRegistroAvisos = $INTRANETV2->Execute("
					SELECT
						SCA.xt_codigoAviso,
						SCA.xt_nombreAviso,
						SSA.xt_rutaAvisoSimulacro,
            			SUBSTRING_INDEX(SSA.xt_rutaAvisoSimulacro,'/',-1),						
						SSA.xd_fechaCarga
					FROM
						SGI_Catalogo_Aviso SCA
					INNER JOIN
						SGI_Simulacros_Avisos SSA
					ON
						SCA.xt_codigoAviso = SSA.xt_codigoAviso
					WHERE
						SCA.xt_codigoAviso IN ('".implode('\',\'', $codigoAvisoSimulacro)."')		
				");
			while($registroAviso = $conjuntoRegistroAvisos->fetchRow()){
				$codigoAvisoCatalogo[$index] = $registroAviso[0];
				$nombreAvisoCatalogo[$index] = $registroAviso[1];
				$rutaAviso[$index]			 = $registroAviso[2];
				$nombreArchivoAviso[$index]	 = $registroAviso[3];
				$fechaAviso[$index]			 = $registroAviso[4];
				$index++;
			}unset($conjuntoRegistroAvisos);unset($registroAviso);
			$conjuntoRegistroEvidenciasSimulacro = $INTRANETV2->Execute("
					SELECT
						SE.xn_codigoEvidencia,
						SE.xt_tipo,
						SE.xt_ruta,
						SE.xt_contenido,
						SE.xd_fecha,
						SUBSTRING_INDEX(SE.xt_ruta,'/',-1)
					FROM
						SGI_Simulacros_Evidencia SSE
					INNER JOIN SGI_Evidencia SE ON SSE.xn_codigoEvidencia = SE.xn_codigoEvidencia
					WHERE
						SSE.xt_codigoSimulacro = SE.xt_codigoSimulacro
					AND
						SE.xt_codigoSimulacro = '".$codigo."'
					ORDER BY
						SE.xt_tipo,SE.xn_codigoEvidencia ASC
				");
			while($registroEvidenciaSimulacro = $conjuntoRegistroEvidenciasSimulacro->fetchRow()){
				$codigoEvidenciaSimulacro[$indice]		= $registroEvidenciaSimulacro[0];
				$tipoEvidenciaSimulacro[$indice]		= $registroEvidenciaSimulacro[1];
				$rutaEvidenciaSimulacro[$indice]		= $registroEvidenciaSimulacro[2];
				$contenidoEvidenciaSimulacro[$indice]   = $registroEvidenciaSimulacro[3];
				$fechaEvidenciaSimulacro[$indice]		= $registroEvidenciaSimulacro[4];
				$nombreEvidenciaSimulacro[$indice]		= $registroEvidenciaSimulacro[5];
				if ($tipoEvidenciaSimulacro[$indice] == 'I' ){
					$contadorImagenes++;
				}
				$indice++;
			}
			if (!empty($codigoEvidenciaSimulacro)){
				if ($contadorImagenes>0){
					echo "<tr id='contenedorFotos'>";
						echo "<td id='iconosTexto3'>";
							echo "<b style='margin-left:5%;'>Galeria de Imágenes</b>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td align='center'>";
							echo '<div id="slider" align="center">';
								echo "<ul>";
									$list = count($codigoEvidenciaSimulacro);
								  	for ($o = 0; $o <  $list; $o++){				  		
										if ($tipoEvidenciaSimulacro[$o] == 'I'){
											// Loading the image and getting the original dimensions
											/*$image = imagecreatefrompng($rutaEvidenciaSimulacro[$o]);
											$orig_width = imagesx($image);
											$orig_height = imagesy($image);

											if($orig_width > $orig_height){
												$width = 800;

												// Calc the new height
												$height = (($orig_height * $width) / $orig_width);

												// Create new image to display
												$new_image = imagecreatetruecolor($width, $height);

												// Create new image with changed dimensions
												imagecopyresized($new_image, $image,
													0, 0, 0, 0,
													$width, $height,
													$orig_width, $orig_height);

												echo "<li style='width:$width; height:$height;'><img style='display: block; margin: auto; width: $width;' src='prueba1.png' alt='' /></li>";
											} else {
												$height = 600;

												$width = (($orig_width * $height) / $orig_height);

												// Create new image to display
												$new_image = imagecreatetruecolor($width, $height);

												// Create new image with changed dimensions
												imagecopyresized($new_image, $image,
													0, 0, 0, 0,
													$width, $height,
													$orig_width, $orig_height);
												// Print image
												imagepng($new_image,"prueba1.png");
												$directorio = $rutaEvidenciaSimulacro[$o]."1";								
												echo "<li style='width:$width; height:$height;'><img style='display: block; margin: auto; width: $width;' src='prueba1.png' alt='' /></li>";
											}*/
											echo "<li><img src='".$rutaEvidenciaSimulacro[$o]."' style='width:100%;height:100%;'></li>";
										}
									  }
								echo '</ul>';
							echo '</div>';
						echo "</td>";
					echo "</tr>";	
				}		
				for($o = 0; $o <= count($codigoEvidenciaSimulacro) - 1; $o++){
					// echo $rutaEvidenciaSimulacro[$o]."<br>";
					echo"<tr height='10px'><td colspan='5'></td></tr>";									
					if ($tipoEvidenciaSimulacro[$o] == 'T'){			
						echo "<tr>";
							echo "<td id='iconosTexto3'>";
								echo "<b style='margin-left:5%;'>Texto</b>";
							echo "</td>";
						echo "</tr>";	
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='5' style='width:600px;'> </td>";
						echo "</tr>";						
						echo"<tr height='10px'><td colspan='5'></td></tr>";							
						echo "<tr>";
							echo "<td>";											
								echo "<i style='margin-left:10%;'>".$contenidoEvidenciaSimulacro[$o]."</i>";
							echo "</td>";
							echo "<td align='right'><a href='eliminaEvidenciaTextoSimulacro.php?evidencia=".$codigoEvidenciaSimulacro[$o]."&simulacro=".$codigo."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
						echo "</tr>";					
						echo "<tr><td style='color:#636262;''>";			
							echo "<i style='margin-left:10%;'><font size=2>".$fechaEvidenciaSimulacro[$o]."</font></i>";
						echo "</td></tr>";	
					} else if ($tipoEvidenciaSimulacro[$o] == 'A'){

						



						echo "<tr>";
							echo "<td id='iconosTexto3'>";
								echo "<b style='margin-left:5%;'>Archivo</b>";
							echo "</td>";
						echo "</tr>";	
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='5' style='width:600px;'> </td>";
						echo "</tr>";						
						echo"<tr height='10px'><td colspan='5'></td></tr>";		
						if(substr($rutaDesarrollo, -4) == ".pdf"){
									echo"<tr height='30px'><td colspan='5'></td></tr>";	
									echo "<tr><td colspan='5'> ";
									echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents("../SeguimientoEtapas/".$rutaEvidenciaSimulacro[$o]))."'\" type='application/pdf' width='700px' height='700px'>";
										echo "<p>
													Si este mensaje aparece su navegador no soporta el plugin para el PDF.
													No obstante puede descargar el archivo en este <a href='SeguimientoEtapas/".$rutaEvidenciaSimulacro[$o]."'>enlance</a>
											  </p>";
									echo "</object>";
									echo "<br><br></td></tr>";
									
								}



						echo "<tr>";
							echo "<td>";	
							echo "<i style='margin-left:10%;'>".$nombreEvidenciaSimulacro[$o]."</i>";
							echo "</td>";
							echo "<td align='right'><a href='eliminaEvidenciaArchivoSimulacro.php?evidencia=".$codigoEvidenciaSimulacro[$o]."&simulacro=".$codigo."&ruta=".$rutaEvidenciaSimulacro[$o]."'><img src='../../Imagenes/ICN_NoOK.png' style='margin-right:10px;' height='13' width='13'/></a></td>";
							echo "<td align='right' style='width:1%;'><a href='downloadEvidenciaArchivoSimulacro.php?file=".$nombreEvidenciaSimulacro[$o]."' ><img src='../../Imagenes/ICN_Archivo.png'></a></td>";
						echo "</tr>";
						echo "<tr><td style='color:#636262;''>";					
							echo "<i style='margin-left:10%;'><font size=2>".$fechaEvidenciaSimulacro[$o]."</font></i>";
						echo "</td></tr>";					
					} else if ($tipoEvidenciaSimulacro[$o] == 'I'){	
						echo "<tr>";
							echo "<td id='iconosTexto3'>";
								echo "<b style='margin-left:5%;'>Imagen:</b>";
							echo "</td>";
						echo "</tr>";	
						echo "<tr>";
							echo "<td id='titleBlueLineBottom' colspan='5' style='width:600px;'> </td>";
						echo "</tr>";						
						echo"<tr height='10px'><td colspan='5'></td></tr>";						
						echo "<tr>";
							echo "<td>";	
							echo "<i style='margin-left:10%;'>".$nombreEvidenciaSimulacro[$o]."</i>";
							echo "</td>";
							echo "<td align='right'><a href='eliminaEvidenciaArchivoSimulacro.php?evidencia=".$codigoEvidenciaSimulacro[$o]."&simulacro=".$codigo."&ruta=".$rutaEvidenciaSimulacro[$o]."'><img src='../../Imagenes/ICN_NoOK.png' style='margin-right:10px;' height='13' width='13'/></a></td>";
							echo "<td align='right' style='width:1%;'><a href='downloadEvidenciaImagenSimulacro.php?file=".$nombreEvidenciaSimulacro[$o]."' ><img src='../../Imagenes/ICN_Archivo.png' ></a></td>";
						echo "</tr>";					
						echo "<tr><td style='color:#636262;''>";					
							echo "<i style='margin-left:10%;'><font size=2>".$fechaEvidenciaSimulacro[$o]."</font></i>";
						echo "</td></tr>";
					}
					echo "<tr height='10'><td colspan='4'></td></tr>";				
				}
			}				
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 11. Recursos utilizados</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='30px'><td colspan='5'></td></tr>";	
			echo "<tr class='etiquetaRecursos'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$recursosSimulacro."</span>";
				echo "</td>";
				echo "<td class='modificaCampoRecursos' align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarRecursos' onClick='mostrarCampoRecursos()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCampoRecursos' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td>";
					echo "<textarea name='recursos' style='width: 400px; height: 150px; margin:0 10px 0 10px'>";
					echo $recursosSimulacro;
					echo "</textarea>";
				echo "</td>";
				echo "<td class='botonGuardar' align='right' valign='top' style='width:30%;'>";
					echo "<a style='cursor:pointer; valign:top; align:right;'  onClick='actualizarCampoRecursos(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";						
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";	

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 12. Resultados</b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='30px'><td colspan='5'></td></tr>";
			echo "<tr class='etiquetaResultado'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$resultadoSimulacro."</span>";
				echo "</td>";
				echo "<td class='modificaCampoResultado' align='right'>";
					echo "<a style='cursor:pointer' id='botonModificarResultado' onClick='mostrarCampoResultado()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr class='modificaCampoResultado' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td>";
					echo "<textarea name='resultado' style='width: 400px; height: 150px; margin:0 10px 0 10px'>";
					echo $resultadoSimulacro;
					echo "</textarea>";
				echo "</td>";
				echo "<td class='botonGuardar' align='right' valign='top' style='width:30%;'>";
					echo "<a style='cursor:pointer; valign:top; align:right;'  onClick='actualizarCampoResultado(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";		

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 13. Evaluación</b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";
			echo"<tr height='30px'><td colspan='5'></td></tr>";			
			echo "<tr class='etiquetasEvaluacion'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$evaluacionSimulacro."</span>";
				echo "</td>";
				echo "<td class='modificaCamposEvaluacion' align='right' colspan='3'>";
					echo "<a style='cursor:pointer' id='botonModificarEvaluacion' onClick='mostrarCamposEvaluacion()'>";
						echo "<font color='#007cbd'>&nbsp; Modificar</font>";
					echo "</a>";
				echo "</td>";			
			echo "</tr>";
			echo "<tr height='10'><td colspan='4'></td></tr>";				
			echo "<tr class='etiquetasEvaluacion'>";
				echo "<td style='width:20px;'></td>";
				echo "<td class='iconosTexto' colspan='2' style='width:80%; padding-right:5%;'>";
					echo "<span>".$descripcionEvaluacionSimulacro."</span>";
				echo "</td>";
			echo "</tr>";
			echo "<tr class='modificaCamposEvaluacion' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td>";
				echo "<input type='radio' name='evaluacion' value='1'>Eficaz<br>";
				echo "</td>";	
				echo "<td class='botonGuardar' align='right' valign='top' style='width:30%;' colspan='3'>";
					echo "<a style='cursor:pointer; valign:top; align:right;'  onClick='actualizarCamposEvaluacion(\"$codigo\")'>";
						echo "<font color='#007cbd'>&nbsp; Guardar</font>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";
			echo "<tr class='modificaCamposEvaluacion' style='display:none;'>";
				echo "<td style='width:20px;'></td>";			
				echo "<td>";	
					echo "<input type='radio' name='evaluacion' value='2'>No eficaz<br>";
				echo "</td>";
			echo "<tr class='modificaCamposEvaluacion' style='display:none;'>";
				echo "<td style='width:20px;'></td>";	
				echo "<td>";			
					echo "<input type='radio' name='evaluacion' value='3'>Parcial<br>";
				echo "</td>";
			echo "</tr>";
			echo "<tr height='10'><td colspan='4'></td></tr>";			
			echo "<tr class='modificaCamposEvaluacion' style='display:none;'>";
				echo "<td style='width:20px;'></td>";
				echo "<td>";
					echo "<textarea name='descripcionEvaluacion' style='width: 400px; height: 150px; margin:0 10px 0 10px'>";
					echo $descripcionEvaluacionSimulacro;
					echo "</textarea>";
				echo "</td>";
			echo "</tr>";				

			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";

		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b> 14. Seguimiento</b></td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>
				  <img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'  id='seguimiento1' style='display:block;' onclick='showSeguimiento(1);'>
				  <img src='../../Imagenes/ICN_BotonMenos.png' height='15' width='15'  id='seguimiento0' style='display:none;' onclick='showSeguimiento(0);'>   </td>";
			echo "</tr>";

			//////

			//////
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";



			echo "<tr> <td colspan='2'>";
			 
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
					echo "<input type='text' size=20 maxlength=100 name='codigoTratamiento'>";
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
					echo "<a style='cursor:pointer; valign:top; align:right;' onClick='agregarseguimiento(\"$codigo\")'><font color='#007cbd'>&nbsp; Agregar</font></a> ";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='30px'>";
				echo "<td align='right' colspan='5'></td>";
			echo "</tr>";
		echo "</table> ";
	 
echo "</td> </tr>";

	$contador=0;
$cs = $INTRANETV2->Execute("
			SELECT xt_claveSeguimiento ,xt_tipoSeguimiento,xd_fecha FROM SGI_Simulacros_Seguimientos
			where xt_claveSimulacro = '$codigo' 
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
										$claveSeguimiento[$contador]=  "<a href='".$pagina."codigo=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a>";
									}
									else {
										$claveSeguimiento[$contador]=  "<a codigo='Sincodigo'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a>";
									}

			}

			else if($tipoSeguimiento[$contador]=="Acción Preventiva")
			{
				$claveSeguimiento[$contador]= "<a href='fichaPreventivav2.php?codigo=".$claveSeguimiento[$contador]."'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a><br>";

			}
			else if($tipoSeguimiento[$contador]=="Acción Correctiva")
			{
				$claveSeguimiento[$contador]= "<a href='fichaCorrectivav2.php?id=".$claveSeguimiento[$contador]."'  id='fileItem' style='text-decoration:none;'>".$claveSeguimiento[$contador]."</a><br>";
				
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
				echo "<td width='300px' align='left' id='iconosTexto2'> Tipo </td>";
				echo "<td width='200px' align='left' id='iconosTexto2'> Fecha </td>";
			echo "</tr>";

			for ($i=0; $i <= $contador; $i++) { 
				echo "<tr><td></td>
				<td>$claveSeguimiento[$i]</td>
				<td>$tipoSeguimiento[$i]</td>
				<td>$xd_fecha[$i]</td>

				</tr>";
			}
			
			 
			 
			
			echo "<tr height='30px'>";
				echo "<td align='right' colspan='5'></td>";
			echo "</tr>";
		echo "</table> ";
}
			
			
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
		
		echo "</table></form>";

echo "</div>";
?>
		</body>
	</html>
   
	
<?php

$nombrephp='altaReunion.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

require_once("../../Consultas/ConsutasGlobales.php");
error_reporting(E_PARSE);

$contador = 0;
$t = $INTRANET->Execute("SELECT
	CASE O.xt_codigoCiudad
WHEN 'DF' THEN
	'CMX'
ELSE
	O.xt_codigoCiudad
END,
 (
	SELECT
		CASE CO.xt_descripcion
	WHEN 'Mexico DF' THEN
		'Ciudad de México'
	ELSE
		CO.xt_descripcion
	END
	FROM
		IntranetGEA_CATALOGO_OFICINA CO
	WHERE
		CO.xt_oficina = O.xt_codigoCiudad
)
FROM
	IntranetGEA_Usuarios_Oficina O
WHERE
	O.kf_usuarioId = '$usuarioId'
");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);
/*
$reunionTipoShow[1] = "Revisión por la Dirección";
$reunionTipoShow[2] = "Revisión del Comité de Calidad";
$reunionTipoShow[3] = "Revisión de Planeación Estratégica";
$reunionTipoShow[4] = "Revisión del Portafolio de Proyecto";
//$reunionTipoShow[5] = "Revisión de Proyecto";
$reunionTipoShow[5] = "Revisión de TI";
$reunionTipoShow[6] = "Extraordinaria";

$reunionTipoValor[1] = "DIRECCION";
$reunionTipoValor[2] = "COMITE DE CALIDAD";
$reunionTipoValor[3] = "PLANEACION ESTRATEGICA";
$reunionTipoValor[4] = "PORTAFOLIO DE PROYECTO";
//$reunionTipoValor[5] = "PROYECTO";
$reunionTipoValor[5] = "TI";
$reunionTipoValor[6] = "EXTRAORDINARIA";

$temasReunion2[1] 	= "Resultado de las auditorías";
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
$temasReunion2[26] 	= "Seguimiento de requisitos de las partes interesadas";
$temasReunion2[27] 	= "Otros";


//inserciones a tabla temas_reuniones Reunion por la direccion (DIRECCION)
/*$direccion[0]="Estado de las acciones de las revisiones por la dirección previas";
$direccion[1]="Cambios en las cuestiones externas e internas que sean pertinentes al sistema de gestión de la calidad";
$direccion[2]="Satisfacción del cliente y la retroalimentación de las partes interesadas pertinentes";
$direccion[3]="Grado en que se han logrado los objetivos de la calidad";
$direccion[4]="Desempeño de los procesos y conformidad de los productos y servicios";
$direccion[5]="Estado y efectividad de las no conformidades, acciones preventivas y/o correctivas";
$direccion[6]="Resultados de seguimiento y medición";
$direccion[7]="Resultados de las auditorías internas y externas";
$direccion[8]="Desempeño de los proveedores externos";
$direccion[9]="Adecuación de los recursos";
$direccion[10]="Eficacia de las acciones tomadas para abordar los riesgos y las oportunidades";
$direccion[11]="Oportunidades de mejora";
$direccion[12]="Quejas y sanciones";
$direccion[13]="Política Integral";
$direccion[14]="Ronda de sugerencias";
$direccion[15]="Otros";

$direccion[0]="Cambios en las cuestiones externas e internas que sean pertinentes al sistema de gestión de la calidad";
$direccion[1]="Satisfacción del cliente y la retroalimentación de las partes interesadas pertinentes";
$direccion[2]="Grado en que se han logrado los objetivos de la calidad";
$direccion[3]="Desempeño de los procesos y conformidad de los productos y servicios";
$direccion[4]="Estado y efectividad de las no conformidades, acciones preventivas y/o correctivas";
$direccion[5]="Resultados de las auditorías internas y externas";
$direccion[6]="Adecuación de los recursos";
$direccion[7]="Oportunidades de mejora";
$direccion[8]="Quejas y sanciones";
$direccion[9]="Medición del servicio";
$direccion[10]="Política integral";
$direccion[11]="Seguridad";
$direccion[12]="Análisis de riesgos";
$direccion[13]="Eficacia de las acciones tomadas para abordar los riesgos y las oportunidades";
$direccion[14]="Ronda de sugerencias";
$direccion[15]="Otros";

$direccion[0]="Filosofía de la empresa (Misión, visión y valores)";
$direccion[1]="Fortalezas, oportunidades, debilidades y amenazas (FODA)";
$direccion[2]="Objetivos, estrategias y tácticas";
$direccion[3]="Compromisos adquiridos con las partes interesadas";
$direccion[4]="Política integral";
$direccion[5]="Ronda de sugerencias";
$direccion[6]="Otros";

$direccion[0]="Comunicaciones";
$direccion[1]="Hardware";
$direccion[2]="Software";
$direccion[3]="Bases de datos";
$direccion[4]="Sistemas";
$direccion[5]="Ronda de sugerencias";
$direccion[6]="Otros";

$direccion[0]="Proyecto";
$direccion[1]="Ronda de sugerencias";
$direccion[2]="Otros";

$direccion[0]="Modificación de marco normativo";
$direccion[1]="Ronda de sugerencias";
$direccion[2]="Otros";


for ($i=0; $i < count($direccion); $i++) { 
$INTRANETV2->Execute("INSERT INTO SGI_Catalogo_Temas_Reuniones(xt_tema,xt_tipoReunion) VALUES ('$direccion[$i]', 'EXTRAORDINARIA')");
	echo "Insertado: $direccion[$i]<br><br>";
}
*/
//fin
?><script>
function mostrarTemas() {

	var e =	 document.getElementById("tipo");
	var reunion = e.options[e.selectedIndex].value;

					document.getElementById('COMITE DE CALIDAD').style.display='none';
					document.getElementById('DIRECCION').style.display='none';
					document.getElementById('EXTRAORDINARIA').style.display='none';
					document.getElementById('PLANEACION ESTRATEGICA').style.display='none';
					document.getElementById('PORTAFOLIO DE PROYECTO').style.display='none';

					document.getElementById('TI').style.display='none';
					div = document.getElementById(reunion);
					if(reunion != ''){
						div.style.display='block';
					}
					else {
						
					}
				}
</script><?php

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='../ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos / </a>
			   <a href='tableroReunionesv2.php' id='breadcrumbs'> Tablero de Reuniones </a>";

if(($_POST['fecha'] == "") || ($_POST['ciudad'] == "") || ($_POST['tipo'] == "") || ($_POST['temas'] == "") || ($_POST['grupo'] == "")){
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Agregar Reunión</title>
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
				</script>
				
				<script type="text/javascript">
					function reCargarPadre(){
						opener.location.reload();
						window.close();
					}
				</script>
			</head>
			<body>
	<?php
	
	echo "<div id='wrapper'>";
	  	echo "<form method='post' action='altaReunionv2.php'>";	
		echo "<table border='0' align='center'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Agregar Reunión";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>"; 
				echo"<td align='center'>";
					echo $breadcrumb;
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='70px'><td></td></tr>";
		echo "</table>";
		//CUERPO FICHA ALTA
	
		echo "<table border='0' align='center' width='600px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
	
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='titulo2' colspan='3'>Tipo</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='3'>";
					echo "<select name='tipo' id='tipo' onChange='mostrarTemas()'>";
						echo "<option value=''>Elegir...</option>";
						$o=0;
						$sql = $INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Reuniones");
						while($r=$sql->fetchRow()){
							$reunionTipoValor[$o]=$r[0];
							$reunionTipoShow[$o]=$r[1];
							echo '<option   value="'.$reunionTipoValor[$o].'">'.$reunionTipoShow[$o].'</option>';
							$o++;
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td>
			<td width='50px'></td>
			</tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='titulo2'>Fecha</td>";
				echo "<td id='titulo2'>Grupo</td>";
				echo "<td id='titulo2'>Ciudad</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td><input type='text' class='DatP' name='fecha'></td>";
				
				echo "<td>";
					echo "<select name='grupo'>";
						echo "<option value=''>Elegir...</option>";
						echo "<option value='GEA'>GEA</option>";
						echo "<option value='NYE'>NYE</option>";
						echo "<option value='OTF'>OTF</option>";
					echo "</select>";
				echo "</td>";
				
				echo "<td>";
					  opcionesCiudadesAlta("mostrarTemas()");
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='titulo2' colspan='3'>Temas a tratar</td>";
			echo "</tr>";
				
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='3' id='iconosTexto3'>";

					//revision por la direccion
					echo "<div id='COMITE DE CALIDAD' style='display:none;'>
					<p><b>Revisión del comité de Calidad</b><br></p>";
					$sqlTemas = $INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Temas_Reuniones WHERE xt_tipoReunion = 'COMITE DE CALIDAD'");
					while ($tema = $sqlTemas->fetchRow()) {
						echo "<input type='checkbox' name='temas[]' value='".$tema[0]."'>".$tema[1]."<br>";
					}
					echo "</div>";
					//revision por comite de calidad
					echo "<div id='DIRECCION' style='display:none;'>
					<p><b>Revisión por la Dirección</b><br></p>";
					$sqlTemas = $INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Temas_Reuniones WHERE xt_tipoReunion = 'DIRECCION'");
					while ($tema = $sqlTemas->fetchRow()) {
						echo "<input type='checkbox' name='temas[]' value='".$tema[0]."'>".$tema[1]."<br>";
					}
					echo "</div>";
					//reunion EXTRAORDINARIA
					echo "<div id='EXTRAORDINARIA' style='display:none;'>
					<p><b>Extraordinaria</b><br></p>";
					$sqlTemas = $INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Temas_Reuniones WHERE xt_tipoReunion = 'EXTRAORDINARIA'");
					while ($tema = $sqlTemas->fetchRow()) {
						echo "<input type='checkbox' name='temas[]' value='".$tema[0]."'>".$tema[1]."<br>";
					}
					echo "</div>";
					//revision PLANEACION ESTRATEGICA
					echo "<div id='PLANEACION ESTRATEGICA' style='display:none;'>
					<p><b>Revisión de Planeación Estratégica</b><br></p>";
					$sqlTemas = $INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Temas_Reuniones WHERE xt_tipoReunion = 'PLANEACION ESTRATEGICA'");
					while ($tema = $sqlTemas->fetchRow()) {
						echo "<input type='checkbox' name='temas[]' value='".$tema[0]."'>".$tema[1]."<br>";
					}
					echo "</div>";
					//revision PORTAFOLIO DE PROYECTO
					echo "<div id='PORTAFOLIO DE PROYECTO' style='display:none;'>
					<p><b>Revisión del Portafolio de Proyecto</b><br></p>";
					$sqlTemas = $INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Temas_Reuniones WHERE xt_tipoReunion = 'PORTAFOLIO DE PROYECTO'");
					while ($tema = $sqlTemas->fetchRow()) {
						echo "<input type='checkbox' name='temas[]' value='".$tema[0]."'>".$tema[1]."<br>";
					}
					echo "</div>";
					//revision TI
					echo "<div id='TI' style='display:none;'>
					<p><b>Revisión de TI</b><br></p>";
					$sqlTemas = $INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Temas_Reuniones WHERE xt_tipoReunion = 'TI'");
					while ($tema = $sqlTemas->fetchRow()) {
						echo "<input type='checkbox' name='temas[]' value='".$tema[0]."'>".$tema[1]."<br>";
					}
					echo "</div>";
					
			
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='30px'><td colspan='4'></td></tr>";
			
			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='4'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo"<tr height='50px'><td colspan='4'></td></tr>";
					
		echo "</table>";
		echo "</form>";
	echo "</div>";
	
} else if(($_POST['fecha'] != "") && ($_POST['ciudad'] != "") && ($_POST['tipo'] != "") && ($_POST['temas'] != "") && ($_POST['grupo'] != "")){
	
	$fechaInsert	= date('Y-m-d', strtotime($_POST['fecha']));
	$ciudadInsert	= $_POST['ciudad'];
	$tipoInsert		= $_POST['tipo'];
	$grupoInsert	= $_POST['grupo'];
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$s = $INTRANETV2->Execute("SELECT
						CASE
						WHEN LPAD(SUBSTRING_INDEX(MAX(xt_codigoReunion),'-',-1), 3, '0') IS NULL THEN
							'001'
						ELSE
							LPAD(SUBSTRING_INDEX(MAX(xt_codigoReunion),'-',-1) + 1, 3, '0')
						END
						
						FROM
							SGI_Reuniones
						WHERE
							YEAR (xd_fecha) = $anio
						AND xt_ciudad = '$ciudadInsert'
						AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r);
	
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	
	$codigo = $grupoInsert."-R-".$ciudadInsert."-".$anio."-".$maximo;
	

	if($INTRANETV2->Execute("INSERT INTO SGI_Reuniones (xt_codigoReunion, xt_ciudad, xn_status, xt_tipo, xd_fecha, xt_grupo) 
											  VALUES ('$codigo', '$ciudadInsert', 1, '$tipoInsert', '$fechaInsert', '$grupoInsert') ")){
		
		foreach($_POST['temas'] as $checkbox){
			
			$INTRANETV2->getOne("INSERT INTO SGI_Reunion_Temas(xt_codigoReunion, xn_numeroTema) VALUES ('$codigo', $checkbox) ");
					
		}
		
		header("Location: tableroReunionesv2.php");
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Agregar Reunión</title>
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
                </head>
                <body>
        <?php
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Reunión No Agregada";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>"; 
					echo"<td align='center'>";
						echo $breadcrumb;
					echo"</td>";
				echo"</tr>";
			
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
					
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineBottom'></td>";
				echo "</tr>";
		
				echo "<tr height='15px'><td colspan='2'></td></tr>";
				
				echo "<tr align='left' height='20px'>";
					echo "<td id='iconosTexto2' align='center' colspan='2'>Error</td>";
				echo "</tr>";
				
				echo "<tr align='left'>";
					echo "<td align='center' colspan='2'>No se pudo agregar la reunión.</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='tableroReunionesv2.php';\">";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";
						
			echo "</table>";
		echo "</div>";
		
	}
}

?>
    </body>
</html>
<?php

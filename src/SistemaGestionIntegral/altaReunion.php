<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio F. García Robles
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp='altaReunion.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

/*
$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN";
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
*/
$contador = 0;
$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);

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
$temasReunion2[2] 	= "Retroalimentación del cliente: Quejas";
$temasReunion2[3] 	= "Retroalimentación del cliente: Cuestionario de satisfacción del cliente";
$temasReunion2[4] 	= "Estado de acciones preventivas y correctivas";
$temasReunion2[5] 	= "Acciones de seguimiento de revisiones por la dirección previas";
$temasReunion2[6] 	= "Cambios que podrían afectar al SGI";
$temasReunion2[7] 	= "Recomendaciones para la mejora";
$temasReunion2[8] 	= "Necesidades de recursos";
$temasReunion2[9] 	= "Política Integral";
$temasReunion2[10] 	= "Objetivos de calidad";
$temasReunion2[11] 	= "Desempeño de los procesos y la conformidad del producto";
$temasReunion2[12] 	= "Planeación Estratégica";
$temasReunion2[13] 	= "Seguridad";
$temasReunion2[14] 	= "Evaluación de Proveedores";
$temasReunion2[15] 	= "Sanciones";
$temasReunion2[16] 	= "Proyecto";
$temasReunion2[17] 	= "Comunicaciones";
$temasReunion2[18] 	= "Hardware";
$temasReunion2[19] 	= "Software";
$temasReunion2[20] 	= "Bases de Datos";
$temasReunion2[21] 	= "Sistemas";
$temasReunion2[22] 	= "Ronda de Sugerencias";
$temasReunion2[23] 	= "Otros";

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos / </a>
			   <a href='tableroReuniones.php' id='breadcrumbs'> Tablero de Reuniones </a>";

if(($_POST['fecha'] == "") || ($_POST['ciudad'] == "") || ($_POST['tipo'] == "") || ($_POST['temas'] == "") || ($_POST['grupo'] == "")){
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Agregar Reunión</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
				?>
				<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
				<link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
				
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
	  	echo "<form method='post' action='altaReunion.php'>";	
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
	
		echo "<table border='0' align='center' width='500px'>";
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
					echo "<select name='tipo'>";
						echo "<option value=''>Elegir...</option>";
						
						for($o = 1; $o <= 7; $o++){
							
							echo "<option value='".$reunionTipoValor[$o]."'>".$reunionTipoShow[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
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
						echo "<option value='GE'>GE</option>";
						echo "<option value='OT'>OT</option>";
					echo "</select>";
				echo "</td>";
				
				echo "<td>";
					echo "<select name='ciudad'>";
						echo "<option value=''>Elegir...</option>";
						
						for($o = 0; $o <count($cdValor); $o++){
							echo "<option value='".$cdValor[$o]."'>".$ciudades[$o]."</option>";
						} //unset($o);
						
					echo "</select>";
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
					for($o = 1; $o <= 23; $o++){
						echo "<input type='checkbox' name='temas[]' value='".$o."'>".$temasReunion2[$o]."<br>";
					}
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='30px'><td colspan='4'></td></tr>";
			
			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='4'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Reuniones WHERE YEAR(xd_fecha) = $anio 
							 AND xt_ciudad = '$ciudadInsert' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r);
	
	$maximo++;
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $grupoInsert."-R-".$ciudadInsert."-".$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $grupoInsert."-R-".$ciudadInsert."-".$anio."-0".$maximo;
		
	} else if(strlen($maximo) <= 3){
		
		$codigo = $grupoInsert."-R-".$ciudadInsert."-".$anio."-".$maximo;
		
	}
	//echo "INSERT INTO IntranetGEA_Reuniones (xt_claveReunion, xt_status, xd_fecha, xt_agenda) VALUES ('$codigo', 'Asignada', $fechaInsert, '$agendaInsert')<br>";
	if($INTRANET->Execute("INSERT INTO SGI_Reuniones (xt_claveReunion, xt_ciudad, xt_status, xt_tipo, xd_fecha, xn_numero, xt_grupo) 
											  VALUES ('$codigo', '$ciudadInsert', 1, '$tipoInsert', '$fechaInsert', $maximo, '$grupoInsert') ")){
												  
		$idReunion = mysql_insert_id();
		
		$query = "SELECT MAX(kp_reunionID) FROM SGI_Reuniones";
			$idReunion = $INTRANET->getOne($query);
		
		foreach($_POST['temas'] as $checkbox){
			
			//echo"INSERT INTO SGI_Elemento_Reunion(kf_reunionID, xn_numElemento, xt_subElemento) VALUES ($idReunion, 2, $checkbox)";
			$INTRANET->getOne("INSERT INTO SGI_Elemento_Reunion(kf_reunionID, xn_numElemento, xt_subElemento) VALUES ($idReunion, 2, $checkbox) ");
					
		}
		
		header("Location: tableroReuniones.php");
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Agregar Reunión</title>
                    <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
					}
					?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
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
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='tableroReuniones.php';\">";
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

<?php
/*
 *@author Octavio García Robles
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'tableroAcuerdos.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
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
AND CASE O.xt_codigoCiudad
WHEN 'DF' THEN
	'CMX'
ELSE
	O.xt_codigoCiudad
END IN (
	SELECT
		A.xt_ciudad
	FROM
		INTRANET2.SGI_Acuerdos A
)");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);

$todas = $INTRANET->getOne("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' AND xt_codigoCiudad = 'ALL'");

$mesNombre[1] 	= "Enero";
$mesNombre[2] 	= "Febrero";
$mesNombre[3] 	= "Marzo";
$mesNombre[4] 	= "Abril";
$mesNombre[5] 	= "Mayo";
$mesNombre[6] 	= "Junio";
$mesNombre[7] 	= "Julio";
$mesNombre[8] 	= "Agosto";
$mesNombre[9] 	= "Septiembre";
$mesNombre[10] 	= "Octubre";
$mesNombre[11] 	= "Noviembre";
$mesNombre[12] 	= "Diciembre";
$mesNombre[13]  = "Todos";

$index = 0;
$tt = $INTRANETV2->Execute("SELECT
							DISTINCT
							CONCAT(
								LEFT (xt_status, 1),
								SUBSTRING(xt_status FROM 2)
							)
						FROM
							SGI_Acuerdos
						ORDER BY
							xt_status");
while($kk = $tt->fetchRow()){
	$statusAcuerdoVal[$index] = $kk[0];
	$index++;	
}unset($kk);unset($tt);unset($index);

$indice 				= 0;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT
CASE xt_codigoCiudad
WHEN 'DF' THEN
	'CMX'
ELSE
	xt_codigoCiudad
END
FROM
	IntranetGEA_Usuarios_Oficina
WHERE
	kf_usuarioId = '$usuarioId'
ORDER BY
	xt_codigoCiudad");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT CASE xt_ciudad WHEN 'DF' THEN 'CMX' ELSE xt_ciudad END FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Acuerdos</title>
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
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					} else if (valor == 0){
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
					}
				}
			</script>
        </head>
        <body>
<?php

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			 <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='../ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos </a>";

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>Acuerdos</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
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
		
		//echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
		//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
/////////////////////////
///////INHOUSE/////////// 
/////////////////////////
	if($categoriaUsr == "Inhouse"){
		
		echo "<table border='0' align='center'  width='900px'>";
			///CABECERA		
				echo "<tr id='titulo2'>";
					echo "<td width='150px' align='center'>Código</td>";
					echo "<td width='420px' align='left'>Título</td>";
					echo "<td width='80px' align='center'>Fecha</td>";
					echo "<td width='120px' align='left'>PDR</td>";
					echo "<td width='10px'></td>";
					echo "<td width='70px' align='left'>Status</td>";
					echo "<td width='5px' align='right'></td>";	
				echo "</tr>";

				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'></td></tr>";
			echo "</table>";
	
		$banderaInicio = 0;

		$s = $INTRANET->Execute("SELECT
									A.xt_codigoAcuerdo,
									A.xt_titulo,
									A.xd_fecha,
									CONCAT(
										LEFT (A.xt_status, 1),
										SUBSTRING(xt_status FROM 2)
									),
									(SELECT E.xt_nombreCorto FROM IntranetGEA.SGI_Empleados E WHERE E.kf_usuario = A.xt_pdr) as nombre
								FROM
									INTRANET2.SGI_Acuerdos A
								WHERE
									A.xt_ciudad = '$ciudadDefault'
								AND (
									A.xt_pdr = '$usuarioId'
									OR xt_usuario = '$usuarioId'
								)

								ORDER BY
									A.xt_codigoAcuerdo DESC");
								
		while($r = $s->fetchRow()){
			
			$claveAcuerdo 	= $r[0];
			$tituloAcuerdo 	= $r[1];
			$fechaAcuerdo	= date('Y-m-d', strtotime($r[2]));
			$status 		= $r[3];
			$pdrA           = $r[4];

			if($banderaInicio == 0){
				
				echo "<table align='center' border='0' width='900px'>";
				
			}
				echo "<tr id='fileItem'>";	
				///CLAVE Y VINCULO AL ACUERDO	
					echo "<td width='150px' align='center'>"; 
						echo "<a href='fichaAcuerdov2.php?acuerdo=".$claveAcuerdo."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo."</a>";
					echo "</td>";
				///TITULO ACUERDO
					echo "<td width='420px' align='left'>".$tituloAcuerdo."</td>";
				///FECHA
					echo "<td width='80px' align='center'>".$fechaAcuerdo."</td>";
			
					echo "<td width='120px' align='left'>".$pdrA."</td>";

					echo "<td width='10px'></td>";
				///STATUS EN BASE A LAS ETAPAS
					echo "<td width='70px' align='center'>".$status."</td>";

					echo "<td width='5px' align='center'></td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'></td></tr>";

			$banderaInicio++;
			
		} unset($r);
		
		if($banderaInicio >= 1){
			
				echo"<tr height='10px'><td colspan='6'></td></tr>";
			echo"</table>";
			
		} else{
		///NO HUBO REGISTROS
			echo "<table align='center' border='0' width='700px'>";
							echo"<tr height='30px'><td></td></tr>";
							
							echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";
							
							echo"<tr height='30px'><td></td></tr>";
						echo"</table>";
			
		}
		
/////////////////////////
//////ADMINISTRADOR////// 
/////////////////////////		
	} else if($categoriaUsr == "Administrador"){
		
		$currentYear  = date('Y');
		$currentMonth = date('m');
		
		if($_POST['ciudad'] != ""){
			
			$ciudadElegida = $_POST['ciudad'];
			
		} else{
			
			$ciudadElegida = $ciudadDefault;
			
		}
		//echo $ciudadElegida."<br>";
		
		if($_POST['anio'] != ""){
			
			$anio = $_POST['anio'];
			
		} else{
			
			$anio = $currentYear;
			
		}
		
		if($_POST['mes'] != ""){
			
			$mes = $_POST['mes'];
			
		} else{
			
			$mes = $currentMonth;
			
		}
		
		$estatusAcuerdoElegido 	= "";
		
		if($_POST['estAcuerdo'] != ""){
			
			 $estatusAcuerdoElegido = $_POST['estAcuerdo'];
			
		} else{
			
			$estatusAcuerdoElegido 	= "Abierto";
			
		}
		
		echo "<form method='POST' action='tableroAcuerdosv2.php'>";
	///TABLA QUE OCULTA LAS OPCIONES DE LOS FILTROS, SE ACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='750px' id='ocultar' style='display:block;'>";
			echo "<tr>";
				echo "<td align='left' id='iconosTexto2' onClick='show(1);' width='750px'>Filtrar</td>";
			echo "</tr>";
		echo "</table>";
	///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='750px' id='mostrar' style='display:none;'>";
			echo "<tr>";
				echo "<td colspan='6' align='left' id='iconosTexto2' onClick='show(0);'>Filtrar</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
		///CATEGORIAS DE LOS FILTROS
			echo "<tr id='fileItem'>";
				echo "<td align='center' width='150px'>Ciudad</td>";
				echo "<td align='center' width='90px'>Año</td>";
				echo "<td align='center' width='130px'>Mes</td>";
				echo "<td align='center' width='150px'>Estatus</td>";
				echo "<td align='center' width='130px'></td>";
				echo "<td align='center' width='100px'></td>";
		///INPUT QUE INDICA QUE EL FILTRO HA SIDO ACTIVADO
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
				
			echo "<tr>";
				echo "<td align='center' valign='top'>";
			///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					  opcionesCiudades();
				echo"</td>";
			///OPCIONES PARA AÑOS
				echo "<td align='center' valign='top'>";
					echo "<select name='anio'>";
						///Muestra solo 5 años, del actual y los cuatro anteriores consecutivos
						for($o = $currentYear; $o >= ($currentYear-4); $o--){
							
							if($anio != $o){
								
								echo "<option value='".$o."'>".$o."</option>";
								
							} else{
								
								echo "<option value='".$o."' selected='selected'>".$o."</option>";
								
							}
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			///OPCIONES PARA MESES
				echo "<td align='center' valign='top'>";
					echo "<select name='mes'>";
						///Muestra los meses consecutivamente
						for($o = 1; $o <= 13; $o++){
							
							if($mes != $o){
								
								echo "<option value='".$o."'>".$mesNombre[$o]."</option>";
								
							} else{
								
								echo "<option value='".$o."' selected='selected'>".$mesNombre[$o]."</option>";
								
							}
							
						} unset($o);
						
					echo "</select>";
				echo"</td>";
			///ESTATUS ACUERDOS
				echo "<td align='center' valign='top'>";
					echo "<select name='estAcuerdo'>";
					
					
						for($o = 0; $o<count($statusAcuerdoVal); $o++){
							
							if($estatusAcuerdoElegido == $statusAcuerdoVal[$o]){
									
								echo "<option value='".$statusAcuerdoVal[$o]."' selected='selected'>".$statusAcuerdoVal[$o]."</option>";
								
							} else{
								
								echo "<option value='".$statusAcuerdoVal[$o]."'>".$statusAcuerdoVal[$o]."</option>";
								
							}
							
						} unset($o);
					
						
					//	if($todas != ''){
							echo "<option value='ALL' selected='selected'>Todos</option>";
						//}
						
					echo "</select>";
				echo"</td>";
			///CAMPO VACIO
				echo "<td align='center' valign='top'>";
				
				echo"</td>";
			///CAMPO VACIO
				echo "<td align='center' valign='top'>";
					
				echo"</td>";
	
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='6'></td></tr>";
			
			echo"<tr>";
				echo"<td align='center' colspan='6'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='25'></td>";
			echo"</tr>";
		echo"</table>";
		
		echo "</form>";
		
		echo "<table align='center' border='0'>";
			echo "<tr height='30px'><td></td></tr>";
		echo "</table>";
		
		$banderaInicio = 0;
		$numeroScripts = 1;
	///CIUDAD ESPECIFICA
		if($ciudadElegida != '' && $anio != '' && $mes != '' && $estatusAcuerdoElegido != '') {
			
			if($ciudadElegida == 'Todas'){
				$ciudadQuery = '';
			}else{
				$ciudadQuery = "A.xt_ciudad = '$ciudadElegida':";
			}
			if($anio == 'ALL'){
				$anioQuery = '';
			}else{
				$anioQuery = "YEAR(A.xd_fecha) = $anio:";
			}
			if($mes == '13'){
				$mesQuery = "";
			}else{
				$mesQuery = "MONTH(A.xd_fecha) = $mes:";
			}
			if($estatusAcuerdoElegido == 'ALL'){
				$estatusAcuerdoElegidoQuery = "";
			}else{
				 $estatusAcuerdoElegidoQuery = "CONCAT(
										LEFT (A.xt_status, 1),
										SUBSTRING(A.xt_status FROM 2)
									) = '$estatusAcuerdoElegido':";
			}
			$concatenarFiltro = $ciudadQuery.$anioQuery.$mesQuery.$estatusAcuerdoElegidoQuery;
			//echo "Consulta: $concatenarFiltro";
			$filtroRemplaza = str_replace(":"," AND ",$concatenarFiltro);
			 $filtroRemplazaAnd = substr($filtroRemplaza,0,-4);
			//echo "<br><br>Consulta: $filtroRemplazaAnd";
			$contaAcuerdo = 0;
			
			
			
			
			$s = $INTRANETV2->Execute("SELECT
										A.xt_codigoAcuerdo,
										A.xt_titulo,
										A.xd_fecha,
										CONCAT(
										LEFT (A.xt_status, 1),
										SUBSTRING(A.xt_status FROM 2)
										),
										(SELECT E.xt_nombreCorto FROM IntranetGEA.SGI_Empleados E WHERE E.kf_usuario = A.xt_pdr LIMIT 1) as nombre
									FROM
										SGI_Acuerdos A
									WHERE
										$filtroRemplazaAnd
									ORDER BY
										A.xt_codigoAcuerdo DESC ");

			while($r = $s->fetchRow()){

				$claveAcuerdo[$contaAcuerdo] 	= $r[0];
				$tituloAcuerdo[$contaAcuerdo] 	= $r[1];
				$fechaAcuerdo[$contaAcuerdo]	= date('Y-m-d', strtotime($r[2]));
				$statusAcuerdo[$contaAcuerdo]   = $r[3];
				$pdrA[$contaAcuerdo]            = $r[4];
				
				$contaAcuerdo++;
				
			}
			
			if($contaAcuerdo >= 1){
			echo "<table border='0' align='center'  width='900px'>";
			///CABECERA		
				echo "<tr id='titulo2'>";
					echo "<td width='150px' align='center'>Código</td>";
					echo "<td width='420px' align='left'>Título</td>";
					echo "<td width='80px' align='center'>Fecha</td>";
					echo "<td width='120px' align='left'>PDR</td>";
					echo "<td width='10px'></td>";
					echo "<td width='70px' align='left'>Status</td>";
					echo "<td width='5px' align='right'></td>";	
				echo "</tr>";

				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'></td></tr>";
			echo "</table>";
			}
		///MES ESPECIFICO
			
		for($d=0; $d<count($claveAcuerdo); $d++){
			echo "<table align='center' border='0' width='900px'>";
				echo "<tr id='fileItem'>";	
				///CLAVE Y VINCULO AL ACUERDO	
					echo "<td width='150px' align='center'>"; 
						echo "<a href='fichaAcuerdov2.php?acuerdo=".$claveAcuerdo[$d]."' id='fileItem' style='text-decoration:none;'>".$claveAcuerdo[$d]."</a>";
					echo "</td>";
				///TITULO ACUERDO
					echo "<td width='420px' align='left'>".$tituloAcuerdo[$d]."</td>";
				///FECHA
					echo "<td width='80px' align='center'>".$fechaAcuerdo[$d]."</td>";
			
					echo "<td width='120px' align='left'>".$pdrA[$d]."</td>";

					echo "<td width='10px'></td>";
				///STATUS EN BASE A LAS ETAPAS
					echo "<td width='70px' align='center'>".$statusAcuerdo[$d]."</td>";

					echo "<td width='5px' align='center'></td>";
				echo "</tr>";

				echo "<tr height='10px'><td colspan='6'></td></tr>";

			echo"</table>";

		}
		if($contaAcuerdo >= 1){
			if(end($claveAcuerdo) == true){
				echo "<table border='0' align='center'  width='700px'>";

					echo "<tr>";
						echo "<td colspan='6' id='titleBlueLineTop'></td>";
					echo "</tr>";

					echo "<tr height='10px'><td colspan='6'></td></tr>";
				echo "</table>";
			}
		}
			
		}
		if($contaAcuerdo == 0){
			echo "<table align='center' border='0' width='700px'>";
				echo"<tr height='30px'><td id='titleBlueLineTop' width='100%'></td></tr>";

				echo"<t><td align='center' id='titulo12'><i>No se encontraron resultados.</i></td></tr>";

				echo"<tr height='30px'><td id='titleBlueLineBottom'></td></tr>";
			echo"</table>";
		}

	}
	
	///LINEA
	echo "<table border='0' align='center'>";
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
		 
echo "</div>";
?>
		</body>
	</html>
<?php

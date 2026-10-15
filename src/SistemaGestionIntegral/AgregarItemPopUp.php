<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio Francisco García Robles 
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='AgregarItemPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");


$pasado = $_GET['proceso'];

if((($_POST['titulo'] == ('' || NULL)) || ($_POST['grupo'] == ('' || NULL)) || ($_POST['tipo'] == ('' || NULL)) /*|| ($_POST['elementos'] == ('' || NULL))*/ || 
   ($_POST['area'] == ('' || NULL))) && ($pasado == '')){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Item</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<script>
	function show(){
		var option = document.getElementById("seleccion").value;
		if(option == "K"){
			document.getElementById("subproceso1").style.display="block";
			document.getElementById("subproceso2").style.display="block";
		} else{
			document.getElementById("subproceso1").style.display="none";
			document.getElementById("subproceso2").style.display="none";
		}
	}
</script>

<style>
	.requerido{
		color: #FFFFFF;
		background-color: #007cbd;
	}
</style>
</head>
<body>
<?php
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarItemPopUp.php'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Agregar Item</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				//echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='70'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		echo"<tr height='15'> </tr>";
	//TITULO ITEM
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Título</td>";
		echo "</tr>";
	//INPUT TITULO
		echo"<tr align='left'>";
			echo "<td  align='left' width='450px'>";
				echo "<input type='text' size='71' maxlength='250' name='titulo'>";
			echo"</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
		
	echo "<table border='0' align='center'>";
	//CERTIFICACIONES ITEM
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>ISO</td>";
		echo "</tr>";
	//INPUT CERTIFICACIONES
		echo "<tr align='left' height='20' >";
			echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='iso'></td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>NMX</td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='nmx'></td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>NEEC</td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='neec'></td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
	//REFERENCIAS ITEM
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' width='450px'>Referencias</td>";
		echo "</tr>";
	//INPUT REFERENCIAS
		echo "<tr align='left' height='20' >";
			echo "<td  align='left'>";
				echo "<input type='text' size='71' maxlength='300' name='referencias'>";
			echo"</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";	
		echo "<tr align='left' height='20' >";
	//GRUPO ITEM
			echo "<td id='iconosTexto2' align='left'>Grupo</td>";
	//MANUAL ITEM
			echo "<td id='iconosTexto2' align='left'>Manual</td>";
		echo "</tr>";
	
		echo "<tr align='left' height='20' >";
	//INPUT GRUPO
			echo "<td id='iconosTexto2' align='left' width='150px'>";
				echo "<select name='grupo'>";
					echo "<option value='' selected=''></option>";
					echo "<option value='GE'>GE</option>";
					echo "<option value='OT'>OT</option>";
				echo "</select>";
			echo "</td>";
	//INPUT MANUAL
			echo "<td id='iconosTexto2' align='left' width='300px'>";
				echo "<select name='area'>";
					echo "<option value='' selected=''></option>";
					$b = $INTRANET->Execute("SELECT SUBSTRING_INDEX(xt_codigo,'-',-1), xt_nombre FROM SGI_Manuales order by xt_codigo");
						while($o = $b->fetchRow()){
							$codigoM = $o[0];
							$nombre  = $o[1];
							
							echo "<option value='".$codigoM."'>".$nombre."</option>";
						}
					/*echo "<option value='' selected=''></option>";
					echo "<option value='MC'>Calidad</option>";
					echo "<option value='CDR'>Control de Documentos y Registros</option>";
					echo "<option value='AI'>Auditorías Internas</option>";
					echo "<option value='CC'>Comité de Calidad</option>";
					echo "<option value='DG'>Dirección General</option>";
					echo "<option value='ADM'>Administración</option>";
					echo "<option value='RH'>Recursos Humanos</option>";
					echo "<option value='TI'>Tecnologías de la Información</option>";
					echo "<option value='OPE'>Operaciones</option>";
					//echo "<option value='SE'>Seguridad</option>";*/
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo "<tr align='left' height='20' >";
	//TIPO ITEM
			echo "<td id='iconosTexto2' align='left'>Tipo</td>";
	//CIUDAD ITEM
			echo "<td id='iconosTexto2' align='left'>Ciudad</td>";	
		echo "</tr>";
		
		echo "<tr align='left' height='20' >";
	//INPUT TIPO
			echo "<td id='iconosTexto2' align='left' width='150px' onchange='show()'>";
				echo "<select name='tipo' id='seleccion'>";
					echo "<option value='' selected=''></option>";
					echo "<option value='C'>Capítulo</option>";
					echo "<option value='L'>Lineamiento</option>";
					echo "<option value='P'>Procedimiento</option>";
					echo "<option value='I'>Instructivo</option>";
					echo "<option value='F'>Formato</option>";
					echo "<option value='DE'>Documento Externo</option>";
					echo "<option value='K'>Proceso</option>";
					echo "<option value='M'>Protocolo</option>";
					
				echo "</select>";
			echo "</td>";
	//INPUT CIUDAD
			echo "<td id='iconosTexto2' align='left' width='300px'>";
				echo "<select name='ciudad'>";
					/*echo "<option value='' selected=''></option>";
					echo "<option value='NLR'>Nuevo Laredo</option>";
					echo "<option value='LAR'>Laredo Texas</option>";
					echo "<option value='CUN'>Cancun</option>";
					echo "<option value='DF'>Distrito Federal</option>";
					echo "<option value='VER'>Veracruz</option>";
					echo "<option value='TOL'>Toluca</option>";
					echo "<option value='QRO'>Queretaro</option>";*/
					echo "<option value='' selected='selected'></option>";
						$t = $INTRANET->Execute("SELECT xt_oficina, xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA");
								while($p = $t->fetchRow()){
									$ciudades = $p[1];
									$cdValor  = $p[0];
															  
										echo"<option value='".$cdValor."'>".$ciudades."</option>";
											
								}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
	
		echo"<tr height='20'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
	//Proceso y Subproceso
		echo "<tr align='left' height='30' style='display:none;' id='subproceso1'>";
			echo "<td id='iconosTexto2' align='left' width='450px'>Subconsecutivo</td>";
		echo "</tr>";
		
		echo "<tr align='left' height='30' style='display:none;' id='subproceso2'>";
			echo "<td align='left' width='450px'><input type='text' size='71' maxlength='250' name='subConsecutivo'></td>";
			echo "<input type='hidden' name='itera' value='ok'>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
	//ELEMENTOS ITEM
		/*echo"<tr height='20'> ";
			echo"<td valign='bottom' align='left' id='iconosTexto2'>";
				echo"Elementos";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr> ";
	//INPUT ELEMENTOS
			echo"<td valign='bottom' align='left'>";
				echo"<textarea name='elementos' style='width: 450px; height: 60px;'></textarea></td>";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";*/
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='450px'></td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "</form>";
echo "</div>";

} else if((($_POST['titulo'] == ('' || NULL)) || ($_POST['grupo'] == ('' || NULL)) || ($_POST['tipo'] == ('' || NULL)) /*|| ($_POST['elementos'] == ('' || NULL))*/ || 
   ($_POST['area'] == ('' || NULL))) && ($pasado == 'K')){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Item</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<script>
	function show(){
		var option = document.getElementById("seleccion").value;
		if(option == "K"){
			document.getElementById("subproceso1").style.display="block";
			document.getElementById("subproceso2").style.display="block";
		} else{
			document.getElementById("subproceso1").style.display="none";
			document.getElementById("subproceso2").style.display="none";
		}
	}
</script>

<style>
	.requerido{
		color: #FFFFFF;
		background-color: #007cbd;
	}
</style>
</head>
<body>
<?php	   
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarItemPopUp.php?proceso=K'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Agregar Item</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				//echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='70'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		echo"<tr height='15'> </tr>";
	//TITULO ITEM
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Título</td>";
		echo "</tr>";
	//INPUT TITULO
		echo"<tr align='left'>";
			echo "<td  align='left' width='450px'>";
				echo "<input type='text' size='71' maxlength='250' name='titulo'>";
			echo"</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
		
	echo "<table border='0' align='center'>";
	//CERTIFICACIONES ITEM
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>ISO</td>";
		echo "</tr>";
	//INPUT CERTIFICACIONES
		echo "<tr align='left' height='20' >";
			echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='iso'></td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>NMX</td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='nmx'></td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>NEEC</td>";
		echo "</tr>";
		echo "<tr align='left' height='20' >";
			echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='neec'></td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
	//REFERENCIAS ITEM
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left' width='450px'>Referencias</td>";
		echo "</tr>";
	//INPUT REFERENCIAS
		echo "<tr align='left' height='20' >";
			echo "<td  align='left'>";
				echo "<input type='text' size='71' maxlength='300' name='referencias'>";
			echo"</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";	
		echo "<tr align='left' height='20' >";
	//GRUPO ITEM
			echo "<td id='iconosTexto2' align='left'>Grupo</td>";
	//MANUAL ITEM
			echo "<td id='iconosTexto2' align='left'>Manual</td>";
		echo "</tr>";
	
		echo "<tr align='left' height='20' >";
	//INPUT GRUPO
			echo "<td id='iconosTexto2' align='left' width='150px'>";
				echo "<select name='grupo'>";
					echo "<option value='' selected=''></option>";
					echo "<option value='GE'>GE</option>";
					echo "<option value='OT'>OT</option>";
				echo "</select>";
			echo "</td>";
	//INPUT MANUAL
			echo "<td id='iconosTexto2' align='left' width='300px'>";
				echo "<select name='area'>";
					echo "<option value='' selected=''></option>";
					$b = $INTRANET->Execute("SELECT SUBSTRING_INDEX(xt_codigo,'-',-1), xt_nombre FROM SGI_Manuales order by xt_codigo");
						while($o = $b->fetchRow()){
							$codigoM = $o[0];
							$nombre  = $o[1];
							
							echo "<option value='".$codigoM."'>".$nombre."</option>";
						}
					/*echo "<option value='' selected=''></option>";
					echo "<option value='MC'>Calidad</option>";
					echo "<option value='CDR'>Control de Documentos y Registros</option>";
					echo "<option value='AI'>Auditorías Internas</option>";
					echo "<option value='CC'>Comité de Calidad</option>";
					echo "<option value='DG'>Dirección General</option>";
					echo "<option value='ADM'>Administración</option>";
					echo "<option value='RH'>Recursos Humanos</option>";
					echo "<option value='TI'>Tecnologías de la Información</option>";
					echo "<option value='OPE'>Operaciones</option>";
					//echo "<option value='SE'>Seguridad</option>";*/
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo "<tr align='left' height='20' >";
	//TIPO ITEM
			echo "<td id='iconosTexto2' align='left'>Tipo</td>";
	//CIUDAD ITEM
			echo "<td id='iconosTexto2' align='left'>Ciudad</td>";	
		echo "</tr>";
		
		echo "<tr align='left' height='20' >";
	//INPUT TIPO
			echo "<td id='iconosTexto2' align='left' width='150px' onchange='show()'>";
				echo "<select name='tipo' id='seleccion'>";
					echo "<option value='K' selected>Proceso</option>";
					echo "<option value='C'>Capítulo</option>";
					echo "<option value='L'>Lineamiento</option>";
					echo "<option value='P'>Procedimiento</option>";
					echo "<option value='I'>Instructivo</option>";
					echo "<option value='F'>Formato</option>";
					echo "<option value='DE'>Documento Externo</option>";
					echo "<option value='M'>Protocolo</option>";
				echo "</select>";
			echo "</td>";
	//INPUT CIUDAD
			echo "<td id='iconosTexto2' align='left' width='300px'>";
				echo "<select name='ciudad'>";
					echo "<option value='' selected=''></option>";
					$t = $INTRANET->Execute("SELECT xt_oficina, xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA");
									while($p = $t->fetchRow()){
										$ciudades = $p[1];
										$cdValor  = $p[0];
																  
											echo"<option value='".$cdValor."'>".$ciudades."</option>";
												
									}
					/*echo "<option value='' selected=''></option>";
					echo "<option value='NLR'>Nuevo Laredo</option>";
					echo "<option value='LAR'>Laredo Texas</option>";
					echo "<option value='CUN'>Cancun</option>";
					echo "<option value='DF'>Distrito Federal</option>";
					echo "<option value='VER'>Veracruz</option>";
					echo "<option value='TOL'>Toluca</option>";
					echo "<option value='QRO'>Queretaro</option>";
					/*echo "<option value='NLR'>Nuevo Laredo</option>";
					echo "<option value='LAR'>Laredo Texas</option>";
					echo "<option value='CUN'>Manzanillo</option>";
					echo "<option value='DF'>Distrito Federal</option>";*/
				echo "</select>";
			echo "</td>";
		echo "</tr>";
	
		echo"<tr height='20'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
	//Proceso y Subproceso
		echo "<tr align='left' height='30'>";
			echo "<td id='iconosTexto2' align='left' width='450px'>Subconsecutivo</td>";
		echo "</tr>";
		
		echo "<tr align='left' height='30'>";
			echo "<td align='left' width='450px'><input type='text' size='71' maxlength='250' name='subConsecutivo'></td>";
			echo "<input type='hidden' name='itera' value='ok'>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='450px'></td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "</form>";
echo "</div>";

} else if(($_POST['titulo'] != ('' && NULL)) && ($_POST['grupo'] != ('' && NULL)) && ($_POST['tipo'] != ('' && NULL)) /*&& ($_POST['elementos'] != ('' && NULL))*/ && 
   ($_POST['area'] != ('' && NULL))){
	
	$tituloInsert = $_POST['titulo'];
	$grupoInsert = $_POST['grupo'];
	$tipoInsert = $_POST['tipo'];
	//$elementoInsert = $_POST['elementos'];
	$areaInsert = $_POST['area'];
	$ciudad = trim($_POST['ciudad']);
	
	$maximo = 0;
	
	$codigo = $grupoInsert."-".$areaInsert;
	
	if(($ciudad != "") && ($ciudad != NULL)){
		
		$codigo = $codigo."-".$ciudad;
		
		//echo"SELECT MAX(xn_consecutivo) FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo = '$tipoInsert' ";
		$s = $INTRANET->Execute("SELECT MAX(xn_consecutivo) FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo = '$tipoInsert'");
	
		while($r = $s->fetchRow()){
			$maximo = $r[0];
			
		} unset($r);
	
	} else{
		
		//echo"SELECT MAX(xn_consecutivo) FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo = '$tipoInsert' ";
		$s = $INTRANET->Execute("SELECT MAX(xn_consecutivo) FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo = '$tipoInsert' ");
	
		while($r = $s->fetchRow()){
			$maximo = $r[0];
			
		} unset($r);
	
	}
	
	$maximo++;
	
	$codigo = $codigo."-".$tipoInsert;
	
			if(strlen($maximo) == 1){
		
		$codigo = $codigo."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo."-0".$maximo;
		
	} else if(strlen($maximo) >= 3){
		
		$codigo = $codigo."-".$maximo;
	}
	
	if($tipoInsert == 'K'){
		
		$subConsecutivo = $_POST['subConsecutivo'];
		
		if($subConsecutivo != ""){
			
			if(is_numeric($subConsecutivo)){
				
				$codigo = $codigo."-".$subConsecutivo;
			}
		}
		//echo"----------------------";
		//echo"SELECT xt_codigo FROM SGI_Item WHERE xt_codigo = '$codigo'";
		$query = "SELECT xt_codigo FROM SGI_Item WHERE xt_codigo = '$codigo' ";
		
	   $result = $INTRANET->Execute($query);
	
		if($result->recordCount() == 0){
			///Insercion exitosa
			/*echo"INSERT INTO SGI_Item (xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_nombre, xt_codigo)
			VALUES ('$grupoInsert', '$areaInsert', '$tipoInsert', $maximo, '$tituloInsert', '$codigo')<br><br>";*/
			$INTRANET->Execute("
			INSERT INTO SGI_Item (xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_ciudad, xt_nombre, xt_codigo)
			VALUES ('$grupoInsert', '$areaInsert', '$tipoInsert', $maximo, '$ciudad','$tituloInsert', '$codigo') ");
			$array = explode("-",$codigo);
			$codigoCorto = $array[3].$array[4];
			$numero = (int)$array[4];
			$INTRANET->Execute("INSERT INTO SGI_Procesos (kp_codigo,xt_codigoCorto,xt_nombre,xn_consecutivo,xt_signatura) 
				VALUES('$codigo','$codigoCorto','$tituloInsert',$maximo,'')");
			$idItem = mysql_insert_id();
			
			//echo"SELECT kp_itemID FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo  = '$tipoInsert' AND xn_consecutivo = $maximo  AND xt_ciudad = '$ciudad'<br><br>";
			$itemID = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo  = '$tipoInsert' AND xn_consecutivo = $maximo AND xt_codigo = '$codigo'");
			
			//echo"UPDATE SGI_Item SET xt_ciudad = '$ciudad' WHERE kp_itemID = $itemID<br><br>";
			
			//echo"UPDATE SGI_Item SET xt_ciudad = '$ciudad' WHERE kp_itemID = $itemID<br><br>";
			if($ciudad != ("UPDATE SGI_Item SET xt_ciudad = '$ciudad' WHERE kp_itemID = $itemID" || NULL)){
				
				//echo"UPDATE SGI_Item SET xt_ciudad = '$ciudad' WHERE kp_itemID = $itemID<br><br>";
				$INTRANET->Execute("UPDATE SGI_Item SET xt_ciudad = '$ciudad' WHERE kp_itemID = $itemID");
			}
			
			if($_POST['iso'] != ("" || NULL)){
				$iso = explode(',', $_POST['iso']);
				
				for($i = 0; $i < count($iso); $i++){
					$dato = trim($iso[$i]);
					/*echo"INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
					VALUES ($itemID, 'ISO', '$dato')<br><br>";*/
					$s = $INTRANET->Execute("
					INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
					VALUES ($itemID, 'ISO', '$dato')");
				}
				unset($i);
			}
					
			if($_POST['nmx'] != ("" || NULL)){
				$nmx = explode(',', $_POST['nmx']);
				
				for($i = 0; $i < count($nmx); $i++){
					$dato = trim($nmx[$i]);
					/*echo"INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
					VALUES ($itemID, 'NMX', '$dato')<br><br>";*/
					$s = $INTRANET->Execute("
					INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
					VALUES ($itemID, 'NMX', '$dato')");
				}
				unset($i);
			}
					
			if($_POST['neec'] != ("" || NULL)){
				$neec = explode(',', $_POST['neec']);
				
				for($i = 0; $i < count($neec); $i++){
					$dato = trim($neec[$i]);
					/*echo"INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
					VALUES ($itemID, 'NEEC', '$dato' )<br><br>";*/
					$s = $INTRANET->Execute("
					INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
					VALUES ($itemID, 'NEEC', '$dato' )");
				}
				unset($i);
			}
			
			if($_POST['referencias'] != ("" || NULL)){
				$referencias = explode(',', $_POST['referencias']);
				
				for($i = 0; $i < count($referencias); $i++){
					$dato = trim($referencias[$i]);
					//echo"SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$dato' <br><br>";
					$idDoc = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$dato' "); 
					
					/*echo"INSERT INTO SGI_Item_Referencia(kf_itemID, xt_docCodigo)
					VALUES ($itemID, '$idDoc')<br><br>";*/
					$s = $INTRANET->Execute("
					INSERT INTO SGI_Item_Referencia(kf_itemID, xt_docCodigo)
					VALUES ($itemID, '$idDoc') ");
				}
			}
			
			header("Location: https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/FichaItem.php?id=$itemID");
			
			
		} else{
		///error codigo existente en la base de datos
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Agregar Item</title>
         <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <script>
            function show(){
                var option = document.getElementById("seleccion").value;
                if(option == "K"){
                    document.getElementById("subproceso1").style.display="block";
                    document.getElementById("subproceso2").style.display="block";
                } else{
                    document.getElementById("subproceso1").style.display="none";
                    document.getElementById("subproceso2").style.display="none";
                }
            }
        </script>
        
        <style>
            .requerido{
                color: #FFFFFF;
                background-color: #007cbd;
            }
        </style>
        </head>
        <body>
        <?php
			echo "<div id='wrapperPopUp'>";
			  echo "<form name='fichaSubir' method='POST' action='AgregarItemPopUp.php'>";	
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Agregar Item</font>";
						echo"</td>";
					echo"</tr>";
					echo"<tr>"; 
						echo"<td align='center'>";
							//echo "<font>$breadcrumb</font>";
						echo"</td>";
					echo"</tr>";
					echo"<tr height='70'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center'>";
					echo "<tr>";
						echo "<td id='titleBlueLineTop'></td>";
					echo "</tr>";
					echo"<tr height='15'> </tr>";
				//TITULO ITEM
					echo "<tr align='left' height='20' >";
						echo "<td id='iconosTexto2' align='left'>Título</td>";
					echo "</tr>";
				//INPUT TITULO
					echo"<tr align='left'>";
						echo "<td  align='left' width='450px'>";
							echo "<input type='text' size='71' maxlength='250' name='titulo' value='$tituloInsert'>";
						echo"</td>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
				echo "</table>";
					
				echo "<table border='0' align='center'>";
				//CERTIFICACIONES ITEM
					echo "<tr align='left' height='20' >";
						echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>ISO</td>";
					echo "</tr>";
				//INPUT CERTIFICACIONES
					echo "<tr align='left' height='20' >";
						$iso = $_POST['iso'];
						echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='iso' value='$iso'></td>";
					echo "</tr>";
					echo "<tr align='left' height='20' >";
						echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>NMX</td>";
					echo "</tr>";
					echo "<tr align='left' height='20' >";
						$nmx = $_POST['nmx'];
						echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='nmx' value='$nmx'></td>";
					echo "</tr>";
					echo "<tr align='left' height='20' >";
						echo "<td id='iconosTexto2' align='left' colspan='2' width='450px'>NEEC</td>";
					echo "</tr>";
					echo "<tr align='left' height='20' >";
						$neec = $_POST['neec'];
						echo "<td align='left' colspan='2' width='450px'><input type='text' size='71' maxlength='250' name='neec' value='$neec'></td>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center'>";
				//REFERENCIAS ITEM
					echo "<tr align='left' height='20' >";
						echo "<td id='iconosTexto2' align='left' width='450px'>Referencias</td>";
					echo "</tr>";
				//INPUT REFERENCIAS
					echo "<tr align='left' height='20' >";
						echo "<td  align='left'>";
							$referencias = $_POST['referencias'];
							echo "<input type='text' size='71' maxlength='300' name='referencias' value='$referencias'>";
						echo"</td>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center'>";	
					echo "<tr align='left' height='20' >";
				//GRUPO ITEM
						echo "<td id='iconosTexto2' align='left'>Grupo</td>";
				//MANUAL ITEM
						echo "<td id='iconosTexto2' align='left'>Manual</td>";
					echo "</tr>";
				
					echo "<tr align='left' height='20' >";
				//INPUT GRUPO
						echo "<td id='iconosTexto2' align='left' width='150px'>";
							echo "<select name='grupo'>";
								if($grupoInsert == 'OT'){
									echo "<option value='$grupoInsert' selected=''>OT</option>";
									echo "<option value='GE'>GE</option>";
								} else if($grupoInsert == 'GE'){
									echo "<option value='$grupoInsert' selected=''>GE</option>";
									echo "<option value='OT'>OT</option>";
								}
							echo "</select>";
						echo "</td>";
				//INPUT MANUAL
						echo "<td id='iconosTexto2' align='left' width='300px'>";
							echo "<select name='area'>";
								if($areaInsert == 'MC'){
									echo "<option value='$areaInsert' selected=''>Calidad</option>";
								} else if($areaInsert == 'CDR'){
									echo "<option value='$areaInsert' selected=''>Control de Documentos y Registros</option>";
								} else if($areaInsert == 'AI'){
									echo "<option value='$areaInsert' selected=''>Auditorías Internas</option>";
								} else if($areaInsert == 'CC'){
									echo "<option value='$areaInsert' selected=''>Comité de Calidad</option>";
								} else if($areaInsert == 'DG'){
									echo "<option value='$areaInsert' selected=''>Dirección General</option>";
								} else if($areaInsert == 'ADM'){
									echo "<option value='$areaInsert' selected=''>Administración</option>";
								} else if($areaInsert == 'RH'){
									echo "<option value='$areaInsert' selected=''>Recursos Humanos</option>";
								} else if($areaInsert == 'TI'){
									echo "<option value='$areaInsert' selected=''>Tecnologías de la Información</option>";
								} else if($areaInsert == 'OPE'){
									echo "<option value='$areaInsert' selected=''>Operaciones</option>";
								}else if($areaInsert == 'SE'){
									echo "<option value='$areaInsert' selected=''>Seguridad</option>";
								}

								echo "<option value='MC'>Calidad</option>";
								echo "<option value='CDR'>Control de Documentos y Registros</option>";
								echo "<option value='AI'>Auditorías Internas</option>";
								echo "<option value='CC'>Comité de Calidad</option>";
								echo "<option value='DG'>Dirección General</option>";
								echo "<option value='ADM'>Administración</option>";
								echo "<option value='RH'>Recursos Humanos</option>";
								echo "<option value='TI'>Tecnologías de la Información</option>";
								echo "<option value='OPE'>Operaciones</option>";
								echo "<option value='SE'>Seguridad</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo"<tr height='10'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center'>";
					echo "<tr align='left' height='20' >";
				//TIPO ITEM
						echo "<td id='iconosTexto2' align='left'>Tipo</td>";
				//CIUDAD ITEM
						echo "<td id='iconosTexto2' align='left'>Ciudad</td>";	
					echo "</tr>";
					
					echo "<tr align='left' height='20' >";
				//INPUT TIPO
						echo "<td id='iconosTexto2' align='left' width='150px' onchange='show()'>";
							echo "<select name='tipo' id='seleccion'>";
								if($tipoInsert == 'C'){
									echo "<option value='$tipoInsert' selected=''>Capítulo</option>";
								} else if($tipoInsert == 'L'){
									echo "<option value='$tipoInsert' selected=''>Lineamiento</option>";
								} else if($tipoInsert == 'P'){
									echo "<option value='$tipoInsert' selected=''>Procedimiento</option>";
								} else if($tipoInsert == 'I'){
									echo "<option value='$tipoInsert' selected=''>Instructivo</option>";
								} else if($tipoInsert == 'F'){
									echo "<option value='$tipoInsert' selected=''>Formato</option>";
								} else if($tipoInsert == 'DE'){
									echo "<option value='$tipoInsert' selected=''>Documento Externo</option>";
								} else if($tipoInsert == 'K'){
									echo "<option value='$tipoInsert' selected=''>Proceso</option>";
								}else if($tipoInsert == 'M'){
									echo "<option value='$tipoInsert' selected=''>Protocolo</option>";
								}
																		
								echo "<option value='C'>Capítulo</option>";
								echo "<option value='L'>Lineamiento</option>";
								echo "<option value='P'>Procedimiento</option>";
								echo "<option value='I'>Instructivo</option>";
								echo "<option value='F'>Formato</option>";
								echo "<option value='DE'>Documento Externo</option>";
								echo "<option value='K'>Proceso</option>";
								echo "<option value='M'>Protocolo</option>";
							echo "</select>";
						echo "</td>";
				//INPUT CIUDAD
						echo "<td id='iconosTexto2' align='left' width='300px'>";
							echo "<select name='ciudad'>";
							
								$t = $INTRANET->Execute("SELECT xt_oficina, xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA");
														while($p = $t->fetchRow()){
															$ciudades = $p[1];
															$cdValor  = $p[0];
																					  
																echo"<option value='".$cdValor."'>".$ciudades."</option>";
												
									}
								/*if($ciudad == 'NLR'){
									echo "<option value='$ciudad' selected=''>Nuevo Laredo</option>";
								} else if($ciudad == 'LAR'){
									echo "<option value='$ciudad' selected=''>Laredo Texas</option>";
								} else if($ciudad == 'CUN'){
									echo "<option value='$ciudad' selected=''>Manzanillo</option>";
								} else if($ciudad == 'DF'){
									echo "<option value='$ciudad' selected=''>Distrito Federal</option>";
								} else if($ciudad == 'QRO'){
									echo "<option value='$ciudad' selected=''>Queretaro</option>";
								} else if($ciudad == 'VER'){
									echo "<option value='$ciudad' selected=''>Veracruz</option>";
								}	else if($ciudad == 'TOL'){
									echo "<option value='$ciudad' selected=''>Toluca</option>";
								}*/
								/*echo "<option value='NLR'>Nuevo Laredo</option>";
								echo "<option value='LAR'>Laredo Texas</option>";
								echo "<option value='CUN'>Manzanillo</option>";
								echo "<option value='DF'>Distrito Federal</option>";*/
								/*echo "<option value='' selected=''></option>";*/
								//echo "<option value='' selected=''></option>";
									/*	$t = $INTRANET->Execute("SELECT xt_oficina, xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA");
														while($p = $t->fetchRow()){
															$ciudades = $p[1];
															$cdValor  = $p[0];
																					  
																echo"<option value='".$cdValor."'>".$ciudades."</option>";
												
									}*/
								/*echo "<option value='NLR'>Nuevo Laredo</option>";
								echo "<option value='LAR'>Laredo Texas</option>";
								echo "<option value='CUN'>Cancun</option>";
								echo "<option value='DF'>Distrito Federal</option>";
								echo "<option value='VER'>Veracruz</option>";
								echo "<option value='TOL'>Toluca</option>";
								echo "<option value='QRO'>Queretaro</option>";*/
							echo "</select>";
						echo "</td>";
					echo "</tr>";
				
					echo"<tr height='20'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center'>";
				//Proceso y Subproceso
					echo "<tr align='left' height='30'>";
						echo "<td id='iconosTexto2' align='left' width='450px'>*Subconsecutivo</td>";
					echo "</tr>";
					echo "<tr align='left' height='30'>";
						echo "<td id='fileItem' align='left' width='450px'>Error, el código ya existe en la base de datos</td>";
					echo "</tr>";
					
					echo "<tr align='left' height='30'>";
						echo "<td align='left' width='450px'><input type='text' size='71' maxlength='250' name='subConsecutivo' class='requerido'></td>";
						echo "<input type='hidden' name='itera' value='ok'>";
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
				echo "</table>";
				
				echo "<table border='0' align='center'>";
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' width='450px'></td>";
					echo "</tr>";
					
					echo "<tr height='10'> </tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right'>";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='10'> </tr>";
				echo "</table>";
				
				echo "</form>";
			echo "</div>";
			///error no es numerico
		}
		
	///No es un proceso
	} else{
		
		/*echo"INSERT INTO SGI_Item (xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_nombre, xt_codigo)
		VALUES ('$grupoInsert', '$areaInsert', '$tipoInsert', $maximo, '$tituloInsert', '$codigo')<br><br>";*/
		$INTRANET->Execute("
		INSERT INTO SGI_Item (xt_grupo, xt_area, xt_tipo, xn_consecutivo, xt_nombre, xt_codigo, xt_ciudad)
		VALUES ('$grupoInsert', '$areaInsert', '$tipoInsert', $maximo, '$tituloInsert', '$codigo', '$ciudad') ");

		//guardar informacion a SGI_Procesos
		//echo"INSERT INTO SGI_Procesos(kp_codigo,xt_nombre) VALUES('$codigo','$tituloInsert')<br><br>";
		$INTRANET->Execute("INSERT INTO SGI_Procesos(kp_codigo,xt_nombre) VALUES('$codigo','$tituloInsert')");
		
		//echo"SELECT kp_itemID FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo  = '$tipoInsert' AND xn_consecutivo = $maximo AND xt_ciudad = '$ciudad'<br><br>";
		$itemID = $INTRANET->getOne("
		SELECT kp_itemID FROM SGI_Item WHERE xt_grupo = '$grupoInsert' AND xt_area = '$areaInsert' AND xt_tipo  = '$tipoInsert' AND xn_consecutivo = $maximo AND xt_codigo = '$codigo'");
		
		$idItem = mysql_insert_id();
		
		if($ciudad != ("" || NULL)){
			
			//echo"UPDATE SGI_Item SET xt_ciudad = '$ciudad' WHERE kp_itemID = $itemID<br><br>";
			$INTRANET->Execute("UPDATE SGI_Item SET xt_ciudad = '$ciudad' WHERE kp_itemID = $itemID");
		}
		
		if($_POST['iso'] != ("" || NULL)){
			$iso = explode(',', $_POST['iso']);
			
			for($i = 0; $i < count($iso); $i++){
				$dato = trim($iso[$i]);
				
				/*echo"INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
				VALUES ($itemID, 'ISO', '$dato')<br><br>";*/
				$s = $INTRANET->Execute("
				INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
				VALUES ($itemID, 'ISO', '$dato')");
			}
			unset($i);
		}
		
		if($_POST['nmx'] != ("" || NULL)){
			$nmx = explode(',', $_POST['nmx']);
			
			for($i = 0; $i < count($nmx); $i++){
				$dato = trim($nmx[$i]);
				/*echo"INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
				VALUES ($itemID, 'NMX', '$dato')<br><br>";*/
				$s = $INTRANET->Execute("
				INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
				VALUES ($itemID, 'NMX', '$dato')");
			}
			unset($i);
		}
		
		if($_POST['neec'] != ("" || NULL)){
			$neec = explode(',', $_POST['neec']);
			
			for($i = 0; $i < count($neec); $i++){
				$dato = trim($neec[$i]);
				/*echo"INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
				VALUES ($itemID, 'NEEC', '$dato' )<br><br>";*/
				$s = $INTRANET->Execute("
				INSERT INTO SGI_Item_Certificaciones(kf_itemID, xt_norma, kf_codigoID) 
				VALUES ($itemID, 'NEEC', '$dato' )");
			}
			unset($i);
		}
		
		if($_POST['referencias'] != ("" || NULL)){
			$referencias = explode(',', $_POST['referencias']);
			
			for($i = 0; $i < count($referencias); $i++){
				$dato = trim($referencias[$i]);
				//echo"SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$dato'<br><br>";
				$idDoc = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$dato' ");
				
				/*echo"INSERT INTO SGI_Item_Referencia(kf_itemID, xt_docCodigo)
				VALUES ($itemID, '$idDoc') <br><br>";*/
				$s = $INTRANET->Execute("
				INSERT INTO SGI_Item_Referencia(kf_itemID, xt_docCodigo)
				VALUES ($itemID, '$idDoc') ");
			}
		}
		
		header("Location: https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/FichaItem.php?id=$itemID");
		
	
	} 
	
}
?>
</body>
</html>
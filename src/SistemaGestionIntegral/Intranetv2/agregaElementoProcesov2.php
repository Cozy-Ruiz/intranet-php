<?php
$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);

//obtengo parametros
$idProceso = $_GET['proceso'];
$seccion = $_GET['seccion'];
$modifica = 0;

if($_POST['modifica'] == 1){
	
	$modifica = 1;
	
}

//FUNCIONES
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<title>Agregar Elemento Proceso</title>
 <?php
	if($estiloUsuario == 1){
    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>
<script type="text/javascript">
	function recargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<script>
function show(){
	var option = document.getElementById("seleccion").value;
	if(option == "Archivo"){
		document.getElementById("archivos").style.display="block";
		document.getElementById("contenido").style.display="none";
	} else{
		document.getElementById("archivos").style.display="none";
		document.getElementById("contenido").style.display="block";
	}
}
</script>
</head>
<body>

<?php
//INTERFACES DE CAPTURA DE DATOS

if($modifica == 0) {

	//DESCRIPCION
	if($seccion == 0){
	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Descripción</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Contenido:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<textarea name='contenido' style='width: 450px; height: 150px;'></textarea>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='0' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

		echo "</form>";
	echo "</div>";
	
	}
	
	if($seccion == 1){
		
	}
	
	if($seccion == 2){
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso' enctype='multipart/form-data'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Diagrama de Flujo</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Seleccione archivo:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='file' name='archivo'>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='2' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

		
		
	}
	
	//PROCESOS ANTECESORES
	if($seccion == 5){
		
		echo "<div id='wrapperPopUp'>";
		 echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Proceso antecesor</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Contenido:</td>";
				echo "</tr>";

				 echo "<tr align='left' height='20' >";

					echo "<td id='iconosTexto2' align='left' width='300px'>";
						echo "<select name='procesoAntecesor'>";
							echo "<option value='' selected='selected'></option>";
								$t = $INTRANETV2->Execute("
									SELECT
										Sxt.xt_CodigoCorto,
										Sxt.xt_Nombre
									FROM
										SGI_Procesos Sxt
									WHERE
										Sxt.xt_CodigoCorto NOT IN (
											SELECT
												SxtA.xt_CodigoProcesoAntecesor
											FROM
												SGI_Procesos_Antecesores SxtA
											WHERE
												SxtA.xt_CodigoProceso = '$idProceso'
										)");
								while($p = $t->fetchRow()){
									$codigoCorto     = $p[0];
									$nombreProceso   = $p[1];

									echo"<option value='".$codigoCorto."'>".$nombreProceso."</option>";                                                    
								}
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='5' name='seccion'>";
						
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

		
	}
	
	//PROCESOS DE APOYO
	if($seccion == 6){
		
		echo "<div id='wrapperPopUp'>";
		 echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Proceso de apoyo</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Contenido:</td>";
				echo "</tr>";

				 echo "<tr align='left' height='20' >";

					echo "<td id='iconosTexto2' align='left' width='300px'>";
						echo "<select name='procesoApoyo'>";
							echo "<option value='' selected='selected'></option>";
								$t = $INTRANETV2->Execute("SELECT
															Sxt.xt_CodigoCorto,
															Sxt.xt_Nombre
														FROM
															SGI_Procesos Sxt
														WHERE
															Sxt.xt_CodigoCorto NOT IN (
																SELECT
																	SxtA.xt_CodigoProcesoAntecesor
																FROM
																	SGI_Procesos_Antecesores SxtA
																WHERE
																	SxtA.xt_CodigoProceso = '$idProceso'
															)");
								while($p = $t->fetchRow()){
									$codigoCorto     = $p[0];
									$nombreProceso   = $p[1];

									echo"<option value='".$codigoCorto."'>".$nombreProceso."</option>";                                                    
								}
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='6' name='seccion'>";
						
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

		
	}
	
	//PROCESOS SUCESOR
	if($seccion == 7){
		
		echo "<div id='wrapperPopUp'>";
		 echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Proceso sucesor</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Contenido:</td>";
				echo "</tr>";

				 echo "<tr align='left' height='20' >";

					echo "<td id='iconosTexto2' align='left' width='300px'>";
						echo "<select name='procesoSucesor'>";
							echo "<option value='' selected='selected'></option>";
								$t = $INTRANETV2->Execute("SELECT
															Sxt.xt_CodigoCorto,
															Sxt.xt_Nombre
														FROM
															SGI_Procesos Sxt
														WHERE
															Sxt.xt_CodigoCorto NOT IN (
																SELECT
																	SxtA.xt_CodigoProcesoAntecesor
																FROM
																	SGI_Procesos_Antecesores SxtA
																WHERE
																	SxtA.xt_CodigoProceso = '$idProceso'
															)");
								while($p = $t->fetchRow()){
									$codigoCorto     = $p[0];
									$nombreProceso   = $p[1];

									echo"<option value='".$codigoCorto."'>".$nombreProceso."</option>";                                                    
								}
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='7' name='seccion'>";
						
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

	}
	
	//ENTRADA
	
	if($seccion == 8){
		
		echo "<div id='wrapperPopUp'>";
		 echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Proceso Entradas</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Título:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='titulo' size='70'>";
						
					echo "</td>";
				echo"</tr>";

				echo"<tr height='15'></tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='8' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

		
	}

	//SALIDAS
	if($seccion == 9){
		
		echo "<div id='wrapperPopUp'>";
		 echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Proceso Salida</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Título:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='titulo' size='70'>";
						
					echo "</td>";
				echo"</tr>";

				echo"<tr height='15'></tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='9' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

		
	}
	
	//INSUMOS
	
	if($seccion == 10){
		
		echo "<div id='wrapperPopUp'>";
		   echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Equipo/Insumos</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Descripción:</td>";
				echo "</tr>";

				echo "<tr align='left' height='15'>";
					echo "<td id='notaDiscreta' align='left'>*Puede ingresar varios separados por renglón</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<textarea name='contenido' style='width: 450px; height: 150px;'></textarea>";
						
					echo "</td>";
				echo"</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='10' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";
		
	}

		
	if($seccion == 11){
		echo "<div id='wrapperPopUp'>";
		 echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Compliance</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Descripción:</td>";
				echo "</tr>";

				echo "<tr align='left' height='15'>";
					echo "<td id='notaDiscreta' align='left'>*Puede ingresar varios separados por renglón</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<textarea name='titulo' style='width: 450px; height: 150px;'></textarea>";
						
					echo "</td>";
				echo"</tr>";

				echo"<tr height='30'> </tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='11' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

	}

	
	if($seccion == 12){
		
		echo "<div id='wrapperPopUp'>";
		 echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Documento controlado</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Documento:</td>";
				echo "</tr>";

				 echo "<tr align='left' height='20' >";

					echo "<td id='iconosTexto2' align='left' width='300px'>";
						echo "<select name='documentoControlado'>";
							echo "<option value='' selected='selected'></option>";
		
								$t = $INTRANETV2->Execute("SELECT
															MD.xt_codigoDocumento,
															MD.xt_nombre
														FROM
															SGI_Manuales_Documentos MD
														WHERE
															MD.xt_codigoDocumento NOT IN (
																SELECT
																	DC.xt_codigoDocumento
																FROM
																	SGI_Documentos_Controlados DC
																WHERE
																	DC.xt_codigoProceso = '$idProceso'
															) ");
		
								while($p = $t->fetchRow()){
									$codigoDoc     = $p[0];
									$nombreDoc   = $p[1];

									echo"<option value='".$codigoDoc."'>".$codigoDoc."--".substr($nombreDoc, 0, 50)."...</option>";                                                    
								}
						echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='12' name='seccion'>";
						
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";
		
	}
	
	//STAKEHOLDERS
	
	if($seccion == 13){
		
		
		echo "<div id='wrapperPopUp'>";
		   echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";	
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Stakeholders</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Descripción:</td>";
				echo "</tr>";

				echo "<tr align='left' height='15'>";
					echo "<td id='notaDiscreta' align='left'>*Puede ingresar varios separados por renglón</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<textarea name='contenido' style='width: 450px; height: 100px;'></textarea>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='13' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

	}
	
	//RIESGOS
	
	if($seccion == 14){
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";		
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Riesgo</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Título:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='titulo' size='70'>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='15'></tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='14' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";
		
	}
	
	
	//INDICADORES
	if($seccion == 15){
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";		
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Indicador</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Nombre:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='nombre' size='72'>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Formula:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<textarea name='formula' style='width: 486px; height: 90px;'></textarea>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Valor:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='valor' size='72'>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Periodicidad:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='periodicidad' size='72'>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='15' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";

		
	}
	
	//NOTAS
	if($seccion == 16){
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar Nota</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Título:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='titulo' size='66'>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='10'> </tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Descripción:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<textarea name='contenido' style='width: 446px; height: 90px;'></textarea>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='30'> </tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='16' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";
		
		
	}
	
	//AREAS DE OPORTUNIDAD
	//NOTAS
	if($seccion == 17){
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='fichaSubir' method='POST' action='agregaElementoProcesov2.php?proceso=$idProceso'>";
			echo "<table border='0' align='center' width='450'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='450'>Agregar area de oportunidad</td>";
				echo"</tr>";
				echo"<tr height='50'> </tr>";
			echo "</table>";

			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450'></td>";
				echo "</tr>";

				echo"<tr height='15'></tr>";

				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left'>Área de oportunidad:</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

				echo"<tr> ";
					echo"<td valign='bottom' align='left'>";
						echo"<input type='text' name='titulo' size='66'>";
					echo "</td>";
				echo"</tr>";

				echo"<tr height='10'> </tr>";


				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";

				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "<input type='hidden' value='1' name='modifica'>";
						echo "<input type='hidden' value='17' name='seccion'>";
					echo"</td>";
				echo"</tr>";

			echo "</table>";

			echo "</form>";
		echo "</div>";
		
		
	}
	
	
	
	
//MODIFICACIONES ****************************************************************************************************************************************
}else if($modifica == 1){

	//DESCRIPCION
	if($_REQUEST['seccion'] == 0){
			$contenido = $_REQUEST['contenido'];
		
			//echo "UPDATE SGI_Procesos SET xt_descripcion = '$contenido' WHERE xt_codigoCorto = '$idProceso'";
			if($INTRANETV2->Execute("UPDATE SGI_Procesos SET xt_descripcion = '$contenido' WHERE xt_codigoCorto = '$idProceso'")){
				
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '".$idProceso."'
					AND 
						SL.xt_tipo = 'Proceso'
					");
				
				while($r = $s->fetchRow()){
					
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];
					
				} unset($r);
				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					echo "
						<script type='text/javascript'>
							window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
							window.close();
						</script>
					";
				} else {
					echo "
						<script type='text/javascript'>
							window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
							window.close();
						</script>	
					";
				}

			}
	
	}	
	
	//RESPONSABLE
	
	if($_REQUEST['seccion'] == 1){
		
	}
	
	//DIAGRAMA
	
	if($_REQUEST['seccion'] == 2){
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		
		if ($archivo != ""){
			$destino = "../ProcesoArchivos/$archivo";
			//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){

				if($INTRANETV2->Execute("UPDATE SGI_Procesos SET xt_archivo = '$destino' WHERE xt_codigoCorto = '$idProceso'")){

					$s = $INTRANETV2->Execute("
						SELECT
							(
								SELECT
									CONCAT(
										U.xt_Nombre,
										' ',
										U.xt_ApellidoPaterno,
										' ',
										U.xt_ApellidoMaterno
									)
								FROM
									IntranetGEA.SGI_Empleados U
								WHERE
									U.kf_usuario = SL.xt_usuario
							),
							SL.xd_fecha
						FROM
							INTRANET2.SGI_Libera_Inventarios SL
						WHERE
							SL.xt_codigo = '".$idProceso."'
						AND 
							SL.xt_tipo = 'Proceso'
						");
					
					while($r = $s->fetchRow()){
						
						$usuarioLibera = $r[0];
						$fechaLibera   = $r[1];
						
					} unset($r);
					if ($usuarioLibera != NULL && $usuarioLibera != ''){
						echo "
							<script type='text/javascript'>
								window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
								window.close();
							</script>
						";
					} else {
						echo "
							<script type='text/javascript'>
								window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
								window.close();
							</script>	
						";
					}

				} else{
					echo "<div id='wrapperPopUp'>";
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Error: No se insertó el diagrama de flujo</font>";
								echo"</td>";
							echo"</tr>";

							echo"<tr height='40'>";
								echo"<td valign='bottom' align='right' colspan='2'>";
									echo "<input type='image' onclick='recargarPadre()' src='../../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
								echo"</td>";
							echo"</tr>";

							echo"<tr height='70'> </tr>";
						echo "</table>";

					echo "</div>";
				}

			} else{
				echo "<div id='wrapperPopUp'>";
					echo "<table border='0' align='center' name='Encabezado'>";
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Error: No se insertó el diagrama de flujo</font>";
							echo"</td>";
						echo"</tr>";

						echo"<tr height='40'>";
							echo"<td valign='bottom' align='right' colspan='2'>";
								echo "<input type='image' onclick='recargarPadre()' src='../../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";

						echo"<tr height='70'> </tr>";
					echo "</table>";

				echo "</div>";
			}
		}
	}
	
	//PROCESOS ANTECESORES
	if($_REQUEST['seccion'] == 5){
		
		if($_POST['procesoAntecesor'] != ""){
			
			$procesoAntecesor = $_POST['procesoAntecesor'];
			
			if($INTRANETV2->Execute("INSERT INTO SGI_Procesos_Antecesores (xt_codigoProceso, xt_codigoProcesoAntecesor, xt_usuario) VALUES ('$idProceso','$procesoAntecesor','$usuarioId')")){
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '".$idProceso."'
					AND 
						SL.xt_tipo = 'Proceso'
					");
				
				while($r = $s->fetchRow()){
					
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];
					
				} unset($r);
				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					echo "
						<script type='text/javascript'>
							window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
							window.close();
						</script>
					";
				} else {
					echo "
						<script type='text/javascript'>
							window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
							window.close();
						</script>	
					";
				}

			}else{
				echo "Error al agregar proceso antecesor correctamente";
				echo "<script>window.opener.location.reload('fichaProcesov2.php?proceso=$idProceso');self.close();</script>";				
			}

		}
		
	}
	
	
	//PROCESOS DE APOYO
	if($_REQUEST['seccion'] == 6){
		
		if($_POST['procesoApoyo'] != ""){
			
			$procesoApoyo = $_POST['procesoApoyo'];
			
			if($INTRANETV2->Execute("INSERT INTO SGI_Procesos_Apoyo (xt_codigoProceso, xt_codigoProcesoAntecesor, xt_usuario) VALUES ('$idProceso','$procesoApoyo','$usuarioId')")){
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '".$idProceso."'
					AND 
						SL.xt_tipo = 'Proceso'
					");
				
				while($r = $s->fetchRow()){
					
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];
					
				} unset($r);
				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					echo "
						<script type='text/javascript'>
							window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
							window.close();
						</script>
					";
				} else {
					echo "
						<script type='text/javascript'>
							window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
							window.close();
						</script>	
					";
				}
			}else{
				echo "Error al agregar proceso antecesor correctamente";
				echo "<script>window.opener.location.reload('fichaProceso.php?proceso=$idProceso');self.close();</script>";
			}

		}
		
	}
	
	
	//PROCESOS SUCESORES
	if($_REQUEST['seccion'] == 7){
		
		if($_POST['procesoSucesor'] != ""){
			
			$procesoSucesor = $_POST['procesoSucesor'];
			
			if($INTRANETV2->Execute("INSERT INTO SGI_Procesos_Sucesores (xt_codigoProceso, xt_codigoProcesoAntecesor, xt_usuario) VALUES ('$idProceso','$procesoSucesor','$usuarioId')")){
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '".$idProceso."'
					AND 
						SL.xt_tipo = 'Proceso'
					");
				
				while($r = $s->fetchRow()){
					
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];
					
				} unset($r);
				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					echo "
						<script type='text/javascript'>
							window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
							window.close();
						</script>
					";
				} else {
					echo "
						<script type='text/javascript'>
							window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
							window.close();
						</script>	
					";
				}
			}else{
				
				echo "Error al agregar proceso sucesor";
				echo "<script>window.opener.location.reload('fichaProceso.php?proceso=$idProceso');self.close();</script>";
			}

		}
		
	}
	
	//PROCESO ENTRADAS
	
	if($_REQUEST['seccion'] == 8){
		
		if($_REQUEST['titulo'] != ""){
	
			$titulo         = $_POST['titulo'];

			//echo"INSERT INTO SGI_Entradas (xt_CodigoProceso, xt_Entradas, xd_usuario) VALUES ('$codigoProceso','$titulo','$usuarioId')";
			if($INTRANETV2->Execute("INSERT INTO SGI_Entradas (xt_codigoProceso, xt_entradas, xt_usuario) VALUES ('$idProceso','$titulo','$usuarioId')")){
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '".$idProceso."'
					AND 
						SL.xt_tipo = 'Proceso'
					");
				
				while($r = $s->fetchRow()){
					
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];
					
				} unset($r);
				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					echo "
						<script type='text/javascript'>
							window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
							window.close();
						</script>
					";
				} else {
					echo "
						<script type='text/javascript'>
							window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
							window.close();
						</script>	
					";
				}
			}else{
				
				echo "Error al agregar entrada";
				echo "<script>window.opener.location.reload('fichaProceso.php?proceso=$idProceso');self.close();</script>";
			}
		}
		
	}
	
	//PROCESO SALIDAS
	
	if($_REQUEST['seccion'] == 9){
		
		if($_REQUEST['titulo'] != ""){
	
			$titulo         = $_POST['titulo'];

			//echo"INSERT INTO SGI_Entradas (xt_CodigoProceso, xt_Entradas, xd_usuario) VALUES ('$codigoProceso','$titulo','$usuarioId')";
			if($INTRANETV2->Execute("INSERT INTO SGI_Salidas (xt_codigoProceso, xt_salidas, xt_usuario) VALUES ('$idProceso','$titulo','$usuarioId')")){
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '".$idProceso."'
					AND 
						SL.xt_tipo = 'Proceso'
					");
				
				while($r = $s->fetchRow()){
					
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];
					
				} unset($r);
				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					echo "
						<script type='text/javascript'>
							window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
							window.close();
						</script>
					";
				} else {
					echo "
						<script type='text/javascript'>
							window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
							window.close();
						</script>	
					";
				}
			}else{
				
				echo "Error al agregar entrada";
				echo "<script>window.opener.location.reload('fichaProceso.php?proceso=$idProceso');self.close();</script>";
			}
		}
		
	}
	
	
	//INSUMOS
	if($_REQUEST['seccion'] == 10){
		
		if($_POST['contenido'] != ""){

			$elementos = explode("\r\n", $_POST['contenido']);

			for($i = 0; $i < count($elementos); $i++){
				$dato = $elementos[$i];

				$INTRANETV2->Execute("INSERT INTO SGI_Insumos (xt_codigoProceso, xt_insumos, xt_usuario) VALUES ('$idProceso','$dato','$usuarioId')");

			}

			$s = $INTRANETV2->Execute("
				SELECT
					(
						SELECT
							CONCAT(
								U.xt_Nombre,
								' ',
								U.xt_ApellidoPaterno,
								' ',
								U.xt_ApellidoMaterno
							)
						FROM
							IntranetGEA.SGI_Empleados U
						WHERE
							U.kf_usuario = SL.xt_usuario
					),
					SL.xd_fecha
				FROM
					INTRANET2.SGI_Libera_Inventarios SL
				WHERE
					SL.xt_codigo = '".$idProceso."'
				AND 
					SL.xt_tipo = 'Proceso'
				");
			
			while($r = $s->fetchRow()){
				
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];
				
			} unset($r);
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				echo "
					<script type='text/javascript'>
						window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
						window.close();
					</script>
				";
			} else {
				echo "
					<script type='text/javascript'>
						window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
						window.close();
					</script>	
				";
			}
		}
	}
	
	//COMPLIANCE
	if($_REQUEST['seccion'] == 11){
		if($_POST['titulo'] != ""){
			$tituloElementos = explode("\r\n", $_POST['titulo']);
			for($i = 0; $i < count($tituloElementos); $i++){
				$dato = $tituloElementos[$i];
				//echo"INSERT INTO SGI_Salidas (xt_CodigoProceso, xt_Salidas, xd_usuario) VALUES ('$codigoProceso','$titulo','$usuarioId')";
				$INTRANETV2->Execute("INSERT INTO SGI_Compliance (xt_codigoProceso, xt_compliance, xt_usuario) VALUES ('$idProceso','$dato','$usuarioId')");
			}
			$s = $INTRANETV2->Execute("
				SELECT
					(
						SELECT
							CONCAT(
								U.xt_Nombre,
								' ',
								U.xt_ApellidoPaterno,
								' ',
								U.xt_ApellidoMaterno
							)
						FROM
							IntranetGEA.SGI_Empleados U
						WHERE
							U.kf_usuario = SL.xt_usuario
					),
					SL.xd_fecha
				FROM
					INTRANET2.SGI_Libera_Inventarios SL
				WHERE
					SL.xt_codigo = '".$idProceso."'
				AND 
					SL.xt_tipo = 'Proceso'
				");
			
			while($r = $s->fetchRow()){
				
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];
				
			} unset($r);
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				echo "
					<script type='text/javascript'>
						window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
						window.close();
					</script>
				";
			} else {
				echo "
					<script type='text/javascript'>
						window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
						window.close();
					</script>	
				";
			}
		}else{
			echo "Error al agregar compliance";
			echo "<script>window.opener.location.reload('fichaProcesov2.php?proceso=$idProceso');self.close();</script>";
		}
	}
	
	
	if($_REQUEST['seccion'] == 12){
		
		if($_POST['documentoControlado'] != ""){
			
			$docControlado = $_POST['documentoControlado'];
			
			if($INTRANETV2->Execute("INSERT INTO SGI_Documentos_Controlados (xt_codigoProceso, xt_codigoDocumento, xt_usuario) VALUES ('$idProceso','$docControlado','$usuarioId')")){
				$s = $INTRANETV2->Execute("
					SELECT
						(
							SELECT
								CONCAT(
									U.xt_Nombre,
									' ',
									U.xt_ApellidoPaterno,
									' ',
									U.xt_ApellidoMaterno
								)
							FROM
								IntranetGEA.SGI_Empleados U
							WHERE
								U.kf_usuario = SL.xt_usuario
						),
						SL.xd_fecha
					FROM
						INTRANET2.SGI_Libera_Inventarios SL
					WHERE
						SL.xt_codigo = '".$idProceso."'
					AND 
						SL.xt_tipo = 'Proceso'
					");
				
				while($r = $s->fetchRow()){
					
					$usuarioLibera = $r[0];
					$fechaLibera   = $r[1];
					
				} unset($r);
				if ($usuarioLibera != NULL && $usuarioLibera != ''){
					echo "
						<script type='text/javascript'>
							window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
							window.close();
						</script>
					";
				} else {
					echo "
						<script type='text/javascript'>
							window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
							window.close();
						</script>	
					";
				}
			}else{
				
				echo "Error al agregar proceso sucesor";
				echo "<script>window.opener.location.reload('fichaProceso.php?proceso=$idProceso');self.close();</script>";
			}

		}
		
	}
	
	//STAKEHOLDERS
	if($_REQUEST['seccion'] == 13){
		
		if($_POST['contenido'] != ""){
	
			$elementos = explode("\r\n", $_POST['contenido']);

			for($i = 0; $i < count($elementos); $i++){
				$dato = $elementos[$i];

				$INTRANETV2->Execute("INSERT INTO SGI_Stakeholders (xt_codigoProceso, xt_stakeholder, xt_usuario) VALUES ('$idProceso','$dato','$usuarioId')");

			}

			$s = $INTRANETV2->Execute("
				SELECT
					(
						SELECT
							CONCAT(
								U.xt_Nombre,
								' ',
								U.xt_ApellidoPaterno,
								' ',
								U.xt_ApellidoMaterno
							)
						FROM
							IntranetGEA.SGI_Empleados U
						WHERE
							U.kf_usuario = SL.xt_usuario
					),
					SL.xd_fecha
				FROM
					INTRANET2.SGI_Libera_Inventarios SL
				WHERE
					SL.xt_codigo = '".$idProceso."'
				AND 
					SL.xt_tipo = 'Proceso'
				");
			
			while($r = $s->fetchRow()){
				
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];
				
			} unset($r);
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				echo "
					<script type='text/javascript'>
						window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
						window.close();
					</script>
				";
			} else {
				echo "
					<script type='text/javascript'>
						window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
						window.close();
					</script>	
				";
			}

		}
	}
	
	//RIESGOS
	
	if($_REQUEST['seccion'] == 14){
		
		if($_POST['titulo'] != ""){
	
			$titulo         = $_POST['titulo'];

			//echo"INSERT INTO SGI_Salidas (xt_CodigoProceso, xt_Salidas, xd_usuario) VALUES ('$codigoProceso','$titulo','$usuarioId')";
			$INTRANETV2->Execute("INSERT INTO SGI_Procesos_Riesgos (xt_codigoProceso, xt_riesgo, xt_usuario) VALUES ('$idProceso','$titulo','$usuarioId')");

			$s = $INTRANETV2->Execute("
				SELECT
					(
						SELECT
							CONCAT(
								U.xt_Nombre,
								' ',
								U.xt_ApellidoPaterno,
								' ',
								U.xt_ApellidoMaterno
							)
						FROM
							IntranetGEA.SGI_Empleados U
						WHERE
							U.kf_usuario = SL.xt_usuario
					),
					SL.xd_fecha
				FROM
					INTRANET2.SGI_Libera_Inventarios SL
				WHERE
					SL.xt_codigo = '".$idProceso."'
				AND 
					SL.xt_tipo = 'Proceso'
				");
			
			while($r = $s->fetchRow()){
				
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];
				
			} unset($r);
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				echo "
					<script type='text/javascript'>
						window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
						window.close();
					</script>
				";
			} else {
				echo "
					<script type='text/javascript'>
						window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
						window.close();
					</script>	
				";
			}

		}
		
	}
	
	//INDICADORES
	
	if($_REQUEST['seccion'] == 15){
		
		if($_POST['nombre'] != ""){
	
			$nombreIndicador   = $_POST['nombre'];
			$formula        = $_POST['formula'];
			$valor          = $_POST['valor'];
			$periodicidad   = $_POST['periodicidad'];
			
			
			$INTRANETV2->Execute("INSERT INTO SGI_Indicadores (xt_codigoProceso, xt_indicador, xt_formula, xt_valor, xt_periodicidad, xt_usuario) VALUES ('$idProceso','$nombreIndicador','$formula','$valor','$periodicidad','$usuarioId')");

			$s = $INTRANETV2->Execute("
				SELECT
					(
						SELECT
							CONCAT(
								U.xt_Nombre,
								' ',
								U.xt_ApellidoPaterno,
								' ',
								U.xt_ApellidoMaterno
							)
						FROM
							IntranetGEA.SGI_Empleados U
						WHERE
							U.kf_usuario = SL.xt_usuario
					),
					SL.xd_fecha
				FROM
					INTRANET2.SGI_Libera_Inventarios SL
				WHERE
					SL.xt_codigo = '".$idProceso."'
				AND 
					SL.xt_tipo = 'Proceso'
				");
			
			while($r = $s->fetchRow()){
				
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];
				
			} unset($r);
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				echo "
					<script type='text/javascript'>
						window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
						window.close();
					</script>
				";
			} else {
				echo "
					<script type='text/javascript'>
						window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
						window.close();
					</script>	
				";
			}

		}
		
	}
	
	
	//NOTAS
	if($_REQUEST['seccion'] == 16){
		
		if($_POST['titulo'] != ""){
	
			$titulo   = $_POST['titulo'];
			$contenido   = $_POST['contenido'];
			
			
			$INTRANETV2->Execute("INSERT INTO SGI_Notas (xt_codigoProceso, xt_tituloNota, xt_descripcion) VALUES ('$idProceso','$titulo','$contenido')");

			$s = $INTRANETV2->Execute("
				SELECT
					(
						SELECT
							CONCAT(
								U.xt_Nombre,
								' ',
								U.xt_ApellidoPaterno,
								' ',
								U.xt_ApellidoMaterno
							)
						FROM
							IntranetGEA.SGI_Empleados U
						WHERE
							U.kf_usuario = SL.xt_usuario
					),
					SL.xd_fecha
				FROM
					INTRANET2.SGI_Libera_Inventarios SL
				WHERE
					SL.xt_codigo = '".$idProceso."'
				AND 
					SL.xt_tipo = 'Proceso'
				");
			
			while($r = $s->fetchRow()){
				
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];
				
			} unset($r);
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				echo "
					<script type='text/javascript'>
						window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
						window.close();
					</script>
				";
			} else {
				echo "
					<script type='text/javascript'>
						window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
						window.close();
					</script>	
				";
			}

		}
		
	}
	
	//AREAS DE OPORTUNIDAD
	
	if($_REQUEST['seccion'] == 17){
		
		if($_POST['titulo'] != ""){
	
			$titulo   = $_POST['titulo'];
			
			
			$INTRANETV2->Execute("INSERT INTO SGI_Areas_Oportunidad (xt_codigoProceso, xt_area_oportunidad, xt_usuario) VALUES ('$idProceso','$titulo', '$usuarioId')");

			$s = $INTRANETV2->Execute("
				SELECT
					(
						SELECT
							CONCAT(
								U.xt_Nombre,
								' ',
								U.xt_ApellidoPaterno,
								' ',
								U.xt_ApellidoMaterno
							)
						FROM
							IntranetGEA.SGI_Empleados U
						WHERE
							U.kf_usuario = SL.xt_usuario
					),
					SL.xd_fecha
				FROM
					INTRANET2.SGI_Libera_Inventarios SL
				WHERE
					SL.xt_codigo = '".$idProceso."'
				AND 
					SL.xt_tipo = 'Proceso'
				");
			
			while($r = $s->fetchRow()){
				
				$usuarioLibera = $r[0];
				$fechaLibera   = $r[1];
				
			} unset($r);
			if ($usuarioLibera != NULL && $usuarioLibera != ''){
				echo "
					<script type='text/javascript'>
						window.opener.top.location='controlCambiosv4.php?proceso=".$idProceso."';
						window.close();
					</script>
				";
			} else {
				echo "
					<script type='text/javascript'>
						window.opener.top.location='fichaProcesov2.php?proceso=".$idProceso."';
						window.close();
					</script>	
				";
			}

		}
		
	}
	
	
	
}//Fin del if de modificaciones



?>
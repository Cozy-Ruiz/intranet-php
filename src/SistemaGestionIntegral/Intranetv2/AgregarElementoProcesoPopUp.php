<?php

$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");


$itemID 	= $_GET['itemID'];
$numeroMapa = $_GET['nmapa'];

if($_POST['modifica'] == 1 && $_POST['descripcion'] != ""){
				
	$itemID = $_POST['itemID'];
	$descripcion = $_POST['descripcion'];
	
	$grupo = "";
	$area = "";
	$tipo = "";
	$consecutivo = 0;
	
	$s = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo FROM SGI_Item WHERE kp_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$grupo = $r[0];
		$area = $r[1];
		$tipo = $r[2];
		$consecutivo = $r[3];
		
	} unset($r);
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Control_Cambios WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
	}
	
	$maximo++;
	
	$usuario = $INTRANET->getOne("SELECT kp_personalId FROM SGI_Empleados WHERE kf_usuario = '$usuarioId' ");
	
	if($INTRANET->Execute("INSERT INTO SGI_Control_Cambios (kf_itemID, xn_numero, xd_fecha, xt_descripcion, kf_actorID) 
							VALUES ($itemID, $maximo, CURRENT_TIMESTAMP(), '$descripcion', $usuario) ")){

	
		
	}
	echo "<script>window.opener.location.reload('FichaItem.php?id=$itemID');self.close();</script>";

}
// save old value
$saved = getenv("LD_LIBRARY_PATH");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("LD_LIBRARY_PATH=$newld");
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Agregar Elemento Proceso</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
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

$mapa[0] 	= "Descripción";
$mapa[1] 	= "Proceso antecesor";
$mapa[2] 	= "Proceso de apoyo";
$mapa[3] 	= "Proceso sucesor";
$mapa[4] 	= "Entrada";
$mapa[5] 	= "Salida";
$mapa[6] 	= "Equipo/Insumo";
$mapa[7] 	= "Compliance";
$mapa[8] 	= "Documento";
$mapa[9] 	= "Stakeholder";
$mapa[10] 	= "Riesgo";
$mapa[11] 	= "Indicador";
$mapa[12]	= "Nota";
$mapa[13]	= "Área de Oportunidad";

///NUMERO DEL MAPA = 0, FORMULARIO PARA AGREGAR DESCRIPCION
if((($numeroMapa == 0) && ($numeroMapa != 'd') && ($numeroMapa != 'r')) && ($_POST['contenido'] == "")){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar $mapa[$numeroMapa]</td>";
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
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 0, AGREGAR DESCRIPCION
} else if((($numeroMapa == 0) && ($numeroMapa != 'd') && ($numeroMapa != 'r')) && ($_POST['contenido'] != "")){
	
	$contenido = $_POST['contenido'];
	
	///SE AGREGO CORRECTAMENTE LA DESCRIPCION
	if($INTRANET->Execute("
		INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_descripcion) VALUES ('$itemID', 0, 1, '$contenido') ")){
			
		$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
		$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
		
		if($inventarioLiberado != ''){
			
					echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}
			
		
		/*echo "<script type='text/javascript'>reCargarPadre()</script>";*/
	///NO SE AGREGO CORRECTAMENTE LA DESCRIPCION
	} else{
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó la descripción</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
}

///NUMERO DEL MAPA = d, FORMULARIO PARA AGREGAR DIAGRAMA DE FLUJO
$archivo = $_FILES['archivo']['name'];
$archivo = limpiar_caracter_especial($archivo);

if(($numeroMapa == 'd') && $archivo == (NULL || "")){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa' enctype='multipart/form-data'>";	
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
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 0 AGREGAR DIAGRAMA DE FLUJO
} else if(($numeroMapa == 'd') && ($archivo != "")){
		
	if ($archivo != ""){
		$destino = "ProcesoArchivos/$archivo";
		//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
			
			
			if($INTRANET->Execute("INSERT INTO SGI_K_Procesos_Elementos (kp_codigo, xn_numeroMapa, xn_numeroElemento, xt_descripcion) VALUES ('$itemID', 0, 2, '$destino')")){
				
				echo "<script type='text/javascript'>reCargarPadre()</script>";
						
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
								echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
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
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
				
			echo "</div>";
		}
	}
	
}

///NUMERO DEL MAPA = r, FORMULARIO PARA AGREGAR RESPONSABLE

if($numeroMapa == 'r' && $_POST['responsable'] == ""){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar Responsable</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='450'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='center'>Seleccione persona responsable:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='center'>";
				echo "<select name='responsable'>";
					echo "<option value='' selected='selected'></option>";
					
					$s = $INTRANET->Execute("
					SELECT kp_personalId, xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados 
					WHERE xt_tipo = 'E' AND kp_personalId <> 168 ORDER BY xt_Nombre, xt_ApellidoPaterno ");
					
					while($r = $s->fetchRow()){
						echo "<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
					} unset($r); unset($s);
				echo "</select>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 0 AGREGAR Responsable
} else if($numeroMapa == 'r' && $_POST['responsable'] != ""){
	
	$idResponsable = $_POST['responsable'];

	if($INTRANET->Execute("
		INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_descripcion) VALUES ('$itemID', 0, 3, '$idResponsable')") ){
		
		$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
		$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
		
		if($inventarioLiberado != ''){
			
					echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}	
		
	} else{
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó el responsable</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
	
}

///NUMERO DEL MAPA = 1, 2, 3, 4, 5, 8 FORMULARIO PARA AGREGAR PROCESOS ANTECESORES, PROCESO DE APOYO, PROCESO SUCESOR, ENTRADA, SALIDA, DOCUMENTO, STAKEHOLDERS

if((($numeroMapa == 1) || ($numeroMapa == 2) || ($numeroMapa == 3) || ($numeroMapa == 4) || ($numeroMapa == 5) || ($numeroMapa == 8) || ($numeroMapa == 9)) && 
   (($_POST['codigo'] == "") && ($_POST['titulo'] ==  ""))){
	   
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar $mapa[$numeroMapa]</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='450'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Código:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<input type='text' name='codigo' size='70'>";
			echo "</td>";
		echo"</tr>";
		
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
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Descripción:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<textarea name='contenido' style='width: 473px; height: 150px;'></textarea>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 1,2,3 AGREGAR PROCESOS ANTECESORES, DE APOYO O SUCESOR, ENTRADAS, SALIDAS, DOCUMENTOS, STAKEHOLDERS
} else if((($numeroMapa == 1) || ($numeroMapa == 2) || ($numeroMapa == 3) || ($numeroMapa == 4) || ($numeroMapa == 5) || ($numeroMapa == 8) || ($numeroMapa == 9)) && 
   		  (($_POST['codigo'] != "") || ($_POST['titulo'] !=  ""))){
			  
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = $numeroMapa ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//SI SE INTRODUJO CÓDIGO LO DEMAS NO LO TOMA EN CUENTA
	if($_POST['codigo'] != ""){
		$codigo = trim($_POST['codigo']);
		
		$idItem = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigo' ");
		
		$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
		$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
		
		if($INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
														   VALUES ('$itemID', $numeroMapa, $maximo, '$idItem', 'ITEM') ")){
		
				/*echo "<script type='text/javascript'>reCargarPadre()</script>";*/
			if($inventarioLiberado != ''){
				
				echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}

		///NO SE AGREGO CORRECTAMENTE LA DESCRIPCION
		} else{
			
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right' colspan='2'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
				
			echo "</div>";
		}
		
	//SI SE INTRODUJO TITULO SOLO SERÁ TEMPORAL
	} else if($_POST['titulo'] != ""){
		
		$titulo = $_POST['titulo'];
		
		$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
		$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
		
		//echo"INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) VALUES ('$itemID', $numeroMapa, $maximo, '$titulo')";
		if($INTRANET->Execute("
			INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) VALUES ('$itemID', $numeroMapa, $maximo, '$titulo') ")){
			
			if($_POST['contenido'] != ""){
				$contenido = trim($_POST['contenido']);
				
				$INTRANET->Execute("
				UPDATE SGI_Procesos_Elementos xt_descripcion = '$contenido' WHERE kf_itemID = '$itemID' AND xn_numeroMapa = $numeroMapa AND xn_numeroElemento = $maximo ");
				
				
			}
			
			if($inventarioLiberado != ''){
			
					echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}
			
		/*	echo "<script type='text/javascript'>reCargarPadre()</script>";*/
		///NO SE AGREGO CORRECTAMENTE LA DESCRIPCION
		} else{
			
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right' colspan='2'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
				
			echo "</div>";
		}
		
	}
	
}

///NUMERO DEL MAPA = 7 FORMULARIO PARA AGREGAR COMPLIANCE
if(($numeroMapa == 7)  && (($_POST['iso'] == "") && ($_POST['nmx'] == "") && ($_POST['neec'] == "") && ($_POST['otros'] == ""))){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar $mapa[$numeroMapa]</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='450'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>ISO:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<input type='text' name='iso' size='70'>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>NMX:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<input type='text' name='nmx' size='70'>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>NEEC:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<input type='text' name='neec' size='70'>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Otros:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<input type='text' name='otros' size='70'>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 7 AGREGAR COMPLIANCE
} else if(($numeroMapa == 7) && (($_POST['iso'] != "") || ($_POST['nmx'] != "") || ($_POST['neec'] != "") || ($_POST['otros'] != ""))){
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = $numeroMapa ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	$bandera = 0;
	
	///ISO
	if($_POST['iso'] != ""){
		
		$iso = explode(',', $_POST['iso']);
				
		for($i = 0; $i < count($iso); $i++){
			
			$dato = trim($iso[$i]);
			
			$INTRANET->Execute("
			INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_titulo, xt_tipo) VALUES ('$itemID', $numeroMapa, $maximo, '$dato', 'ISO', 'NORMA')");
			
			$maximo++;
			$bandera++;
		}
		
		unset($i);
	}
	
	///NMX
	if($_POST['nmx'] != ""){
		
		$nmx = explode(',', $_POST['nmx']);
				
		for($i = 0; $i < count($nmx); $i++){
			
			$dato = trim($nmx[$i]);
			
			$INTRANET->Execute("
			INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_titulo, xt_tipo) VALUES ('$itemID', $numeroMapa, $maximo, '$dato', 'NMX', 'NORMA')");
			
			$maximo++;
			$bandera++;
		}
		
		unset($i);
	}
	
	///NEEC
	if($_POST['neec'] != ""){
		
		$neec = explode(',', $_POST['neec']);
				
		for($i = 0; $i < count($neec); $i++){
			
			$dato = trim($neec[$i]);
			
			$INTRANET->Execute("
			INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_titulo, xt_tipo) VALUES ('$itemID', $numeroMapa, $maximo, '$dato', 'NEEC', 'NORMA')");
			
			$maximo++;
			$bandera++;
		}
		
		unset($i);
	}
	
	///OTROS
	if($_POST['otros'] != ""){
		
		$otrosCert = explode(',', $_POST['otros']);
				
		for($i = 0; $i < count($otrosCert); $i++){
			
			$dato = $otrosCert[$i];
			
			$INTRANET->Execute("
			INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) VALUES ('$itemID', $numeroMapa, $maximo, '$dato')");
			
			$maximo++;
			$bandera++;
		}
		
		unset($i);
	}
	
	if($bandera >= 1){
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
	///NO SE AGREGO CORRECTAMENTE LA DESCRIPCION
	} else{
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
}

///NUMERO DEL MAPA = 6 EQUIPOS/INSUMOS
if((($numeroMapa == 6) /*|| ($numeroMapa == 5) || ($numeroMapa == 6)*/) && ($_POST['contenido'] == "")){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar $mapa[$numeroMapa]</td>";
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
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 6 AGREGAR
} else if((($numeroMapa == 6)/* || ($numeroMapa == 5) || ($numeroMapa == 6)*/) && ($_POST['contenido'] != "")){
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = $numeroMapa ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	$bandera = 0;
	
	$elementos = explode("\r\n", $_POST['contenido']);
				
	for($i = 0; $i < count($elementos); $i++){
		$dato = $elementos[$i];
		$INTRANET->Execute("
		INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_descripcion) VALUES ('$itemID', $numeroMapa, $maximo, '$dato') ");
		
		$maximo++;
		$bandera++;
	}
	
	if($bandera >= 1){
		
		$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
		$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
		
		if($inventarioLiberado != ''){
			
					echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}

		/*echo "<script type='text/javascript'>reCargarPadre()</script>";*/
	///NO SE AGREGO CORRECTAMENTE LA DESCRIPCION
	} else{
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
}

///NUMERO DEL MAPA = 10 RIESGOS
if((($numeroMapa == 10)) && ($_POST['titulo'] == "")){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar $mapa[$numeroMapa]</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' width='450'></td>";
		echo "</tr>";

		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Código/Título:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<input type='text' name='titulo' size='73'>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='15'></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Descripción:</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
					
		echo"<tr> ";
			echo"<td valign='bottom' align='left'>";
				echo"<textarea name='contenido' style='width: 492px; height: 150px;'></textarea>";
			echo "</td>";
		echo"</tr>";
		
		echo"<tr height='30'> </tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 10 RIESGOS
} else if((($numeroMapa == 10)) && ($_POST['titulo'] != "")){
	
	$titulo 	= $_POST['titulo'];
	
	$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
	$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = $numeroMapa ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	if(substr(trim($titulo),0,4) == 'GE-J'){
		
		$codigoRiesgo = trim($titulo);
		
		$idRiesgo = $INTRANET->getOne("SELECT kp_riesgoId FROM SGI_Riesgos WHERE xt_codigoRiesgo = '$codigoRiesgo' ");
		
		if($INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_docCodigo, xt_tipo) 
													   VALUES ($itemID, $numeroMapa, $maximo, '$idRiesgo', 'RIESGO') ")){
		
		if($inventarioLiberado != ''){
			
					echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}

			
		} else{
		
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
						echo"</td>"; 	
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right' colspan='2'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
				
			echo "</div>";
		}
		
	} else{
		
		if($INTRANET->Execute("INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) 
													   VALUES ($itemID, $numeroMapa, $maximo, '$titulo') ")){
			
			if($_POST['contenido'] != ""){
				$contenido 	= $_POST['contenido'];
				$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$contenido' WHERE kf_itemID = $itemID AND xn_numeroMapa = $numeroMapa 
									AND xn_numeroElemento = $maximo ");
		
			}
			if($inventarioLiberado != ''){
			
					echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}
			
		} else{
		
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
						echo"</td>"; 	
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right' colspan='2'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
				
			echo "</div>";
		}
		
	}
	
	///SE AGREGO CORRECTAMENTE LA DESCRIPCION Y CODIGO
	
	
}

///NUMERO DEL MAPA = 11 INDICADORES
if((($numeroMapa == 11)) && ($_POST['nombre'] == "")){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar $mapa[$numeroMapa]</td>";
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
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 11 AGREGAR INDICADORES
} else if((($numeroMapa == 11)) && ($_POST['nombre'] != "")){
	
	$nombre 		= $_POST['nombre'];
	
	$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
	$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Procesos_Indicadores WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
		
	
	///SE AGREGO CORRECTAMENTE LA DESCRIPCION Y CODIGO
	if($INTRANET->Execute("
	INSERT INTO SGI_Procesos_Indicadores(kf_itemID, xn_numero, xt_nombre) VALUES ($itemID, $maximo, '$nombre') ")){
		
		if($_POST['formula'] != ""){
			$formula 		= $_POST['formula'];
			$INTRANET->Execute("UPDATE SGI_Procesos_Indicadores SET xt_formula = '$formula' WHERE kf_itemID = $itemID AND xn_numero = '$maximo' ");
		}
		
		if($_POST['valor'] != ""){
			$valor			= $_POST['valor'];
			$INTRANET->Execute("UPDATE SGI_Procesos_Indicadores SET xt_valor = '$valor' WHERE kf_itemID = $itemID AND xn_numero = '$maximo' ");
		}
		
		if($_POST['periodicidad'] != ""){
			$periodicidad	= $_POST['periodicidad'];
			$INTRANET->Execute("UPDATE SGI_Procesos_Indicadores SET xt_periodicidad = '$periodicidad' WHERE kf_itemID = $itemID AND xn_numero = '$maximo' ");
		}
		
		if($inventarioLiberado != ''){
				
				echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}		
		/*echo "<script type='text/javascript'>reCargarPadre()</script>";*/
		
	} else{
	
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
}


///NUMERO DEL MAPA = 12, 13 FORMULARIO PARA AGREGAR NOTAS, AREA DE OPORTUNIDAD
if((($numeroMapa == 12) || ($numeroMapa == 13)) && ($_POST['titulo'] == "")){
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
	echo "<table border='0' align='center' width='450'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='450'>Agregar $mapa[$numeroMapa]</td>";
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
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
	echo "</table>";
	
	echo "</form>";
echo "</div>";

///NUMERO DEL MAPA = 12, 13 AGREGAR NOTAS, AREAS DE OPORTUNIDAD
} else if((($numeroMapa == 12) || ($numeroMapa == 13)) && ($_POST['titulo'] != "")){
	$titulo 	= $_POST['titulo'];
	$contenido 	= $_POST['contenido'];
	
	$codigoProceso = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $itemID ");
		
	$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numeroElemento) FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = $numeroMapa ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	///SE AGREGO CORRECTAMENTE LA DESCRIPCION
	if($INTRANET->Execute("
		INSERT INTO SGI_Procesos_Elementos (kf_itemID, xn_numeroMapa, xn_numeroElemento, xt_titulo) VALUES ('$itemID', $numeroMapa, $maximo, '$titulo') ")){
			
		if($contenido != ""){
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_descripcion = '$contenido' 
			WHERE kf_itemID = '$itemID' AND xn_numeroMapa = $numeroMapa AND xn_numeroElemento = $maximo ");
			
		}
		
		if($inventarioLiberado != ''){
				
				echo "<div id='wrapperPopUp'>";
					 echo "<form name='fichaSubir' method='POST' action='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=$numeroMapa'>";	
						echo "<table border='0' align='center' name='Encabezado'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Control de Cambios</font>";
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
						//TITULO ITEM
							echo "<tr align='left' height='20' >";
								echo "<td id='iconosTexto2' align='left'>Descripción</td>";
							echo "</tr>";
						//INPUT TITULO
							echo"<tr align='left'>";
								echo "<td  align='left' width='450px'>";
									echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
									echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
								echo"</td>";
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
				
			}else{
				echo "<script type='text/javascript'>reCargarPadre()</script>";
			}		
	///NO SE AGREGO CORRECTAMENTE LA DESCRIPCION
	} else{
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se insertó $mapa[$numeroMapa].</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
}
?>
</body>
</html>
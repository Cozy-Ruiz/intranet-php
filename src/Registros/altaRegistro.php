<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'altaRegistro.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

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

$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='Registros.php' id='breadcrumbs'> Registros/</a><a href='tableroRegistros.php' id='breadcrumbs'> Tablero Registro</a> ";

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

$indice 				= 1;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($indice);

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

date_default_timezone_set('America/Mexico_City');

$fechaHoy = date("Y-m-d");
////APLICA SOLO CUANDO PROVIENE DE UN PROCESO	
$procesoId = "";

if($_GET['procesoId'] != ""){
	
	$procesoId = $_GET['procesoId'];
	
} else if($_POST['procesoId'] != ""){
	
	$procesoId = $_POST['procesoId'];
	
}

//CUERPO FICHA ALTA
if(($_POST['ciudad'] == "") || ($_POST['titulo'] == "") || ($_POST['fecha'] == "") || ($_POST['grupo'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Alta Registro</title>
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
		echo "<form method='post' action='altaRegistro.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Agregar Registro";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>"; 
				echo "<td align='center'>";
					echo $breadcrumb;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='70'><td></td></tr>";
		echo "</table>";
	
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop' colspan='3'></td>";
			echo "</tr>";
	
			echo "<tr height='15px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2'>Fecha</td>";
				echo "<td id='iconosTexto2'>Grupo</td>";
				echo "<td id='iconosTexto2'>Ciudad</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "<input type='text' class='DatP' name='fecha' size='10'>";
				echo "</td>";
				
				echo "<td>";
					echo "<select name='grupo'>";
						echo "<option value='' selected='selected'>Elegir...</option>";
						echo "<option value='GE'>GE</option>";
						echo "<option value='OT'>OT</option>";
					echo "</select>";
				echo "</td>";
				
				echo "<td>";
					echo "<select name='ciudad'>";
						echo "<option value='' selected='selected'>Elegir...</option>";
						/*for($a = 1; $a <= 6; $a++){
							
							if(in_array($cdValor[$a], $ciudadesDisponibles)){
								
								echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
								
							}
						}*/
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudadess = $p[1];
									$cdValors  = $p[0];

										echo"<option value='".$cdValors."'>".$ciudadess."</option>";
										
								}
						echo"</select>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
	
			echo"<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><input type='text' name='titulo' size='86px'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
						
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><textarea name='descripcion' style='width:738px; height:100px;'></textarea></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
			echo "</tr>";
				
			echo "<tr>";
				echo "<td colspan='3'>";
					echo "<input type='file' name='archivo'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
		///FORMATO RELACIONADO
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Formato</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'>";
					echo"<input type='text' name='formato'>";
				echo "</td>";
			echo "</tr>";
	
			echo"<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right' colspan='3'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			
			echo "<tr height='50px'><td colspan='3'></td></tr>";
		echo "</table>";
		echo "</form>";
	echo "</div>";
	
}else if(($_POST['ciudad'] != "") && ($_POST['titulo'] != "") && ($_POST['fecha'] != "") && ($_POST['grupo'] != "")){

	$fechaInsert 		= $_POST['fecha'];
	$ciudadInsert 		= $_POST['ciudad'];
	$grupoInsert		= $_POST['grupo'];
	$tituloInsert 		= $_POST['titulo'];
	$descripcionInsert 	= $_POST['descripcion'];
	$formatoInsert		= $_POST['formato']; 
	
	//echo"$formatoInsert <br> SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$formatoInsert'";
	$formatoIDInsert	= $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$formatoInsert'");
	//$consecuenciaInsert	= $_POST['impacto'];
	
	
	$maximo = 0;
	
	$anio = date('Y', strtotime($_POST['fecha']));
	//echo"SELECT MAX(xn_numero) FROM SGI_Registro WHERE  YEAR(xd_fecha) = '$anio' AND xt_ciudad = '$ciudadInsert' AND xt_grupo = '$grupoInsert' ";
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Registros WHERE  YEAR(xd_fecha) = '$anio' AND xt_ciudad = '$ciudadInsert' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r);
	
	$maximo++;
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $grupoInsert."-T-".$ciudadInsert."-".$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $grupoInsert."-T-".$ciudadInsert."-".$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $grupoInsert."-T-".$ciudadInsert."-".$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Registros(xd_fecha, xt_ciudad, xt_tituloRegistro, xn_numero, xt_codigoRegistro, xt_grupo, xt_categoria, kf_itemID) VALUES ('$fechaInsert', '$ciudadInsert', '$tituloInsert', $maximo, '$codigo', '$grupoInsert', '$formatoInsert',$formatoIDInsert) ")){
		
		$idRegistro = $INTRANET->getOne("SELECT MAX(kp_registroID) FROM SGI_Registros");
		
		if($descripcionInsert != "" ){
			
			$INTRANET->Execute("UPDATE SGI_Registros SET xt_descripcion = '$descripcionInsert' WHERE kp_registroID = $idRegistro ");
			
		}
		
		if($formatoInsert != ""){
			
			$fechaCaptura = date('Y-m-d');
			
			$INTRANET->Execute("INSERT INTO SGI_Registros_Formatos(kf_registroID, kf_itemID, xd_fecha) VALUES ($idRegistro, $formatoIDInsert, '$fechaCaptura') ");
			
		}
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if($archivo != ""){
			
			$destino = "../Registros/Registros/".$archivo;
			
			//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANET->Execute("UPDATE SGI_Registros SET xt_ruta = '$archivo' WHERE kp_registroID = $idRegistro ") ){
					
				
                             header("Location: fichaRegistro.php?id=$idRegistro");
                                            
                                   
				} else{
					
                                ?>
                   	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Alta Registro</title>
                                <?php
								if($estiloUsuario == 1){
									echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
								}else if($estiloUsuario == 2){
									echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
								}
								echo "<script type='text/javascript'>reCargarPadre()</script>";
                                                                
					echo "<div id='wrapperPopUp'>";
						echo "<table border='0' align='center'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='40px'>";
								echo"<td valign='bottom' align='right'>";
									echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
								echo"</td>";
							echo"</tr>";
						echo "</table>";
					echo "</div>";
					
				}
				
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Alta Registro</title>
                            <?php
							if($estiloUsuario == 1){
								echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
							}else if($estiloUsuario == 2){
								echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
							}
							
                                                        echo "<script type='text/javascript'>reCargarPadre()</script>";
                echo "<div id='wrapperPopUp'>";
                    echo "<table border='0' align='center' name='Encabezado'>";
                        echo"<tr>";
                            echo"<td align='center' id='titulo1'>";
                                echo "Error en la carga";
                            echo"</td>";
                        echo"</tr>";
                        
                        echo"<tr height='40px'>";
                            echo"<td valign='bottom' align='right'>";
                                echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
                            echo"</td>";
                        echo"</tr>";
                    echo "</table>";
                echo "</div>";
                
			}
		}
		
		
		//header("Location: fichaRegistro.php?id=$idRegistro");
		echo "<script type='text/javascript'>reCargarPadre()</script>";
                
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Alta Registro</title>
                    <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
					}
					echo "<script type='text/javascript'>reCargarPadre()</script>";
        
        echo "<div id='wrapperPopUp'>";
            echo "<table border='0' align='center'>";
                echo"<tr>";
                    echo"<td align='center' id='titulo1'>";
                        echo "Registro No Agregado";
                    echo"</td>";
                echo"</tr>";
                
                echo"<tr height='40px'>";
                    echo"<td valign='bottom' align='right'>";
                        echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
                    echo"</td>";
                echo"</tr>";
            echo "</table>";
        echo "</div>";
        
       
	}

}

 ?>
        </body>
    </html>
<?php

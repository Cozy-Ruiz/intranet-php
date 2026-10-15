<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp='AgregaActividad.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
//require_once("Mail.php");

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

$gruposItem[1] = "GE";
$gruposItem[2] = "OT";

$codigoItem = $_GET['codigo'];
$idItem  = $_GET['idItem'];



//echo "Titulo: ".$_POST['titulo'].", Fecha: ".$_POST['fecha'].", Descripcion: ".$_POST['descripcion'].", Ciudad: ".$_POST['ciudad']."<br><br>";

if(($_POST['titulo'] == "") || ($_POST['fecha'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Agregar Boletín</title>
                
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
            </head>
            <body>
    <?php
	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='agregaBoletin' method='POST' action='AgregaActividad.php'  enctype='multipart/form-data'>";	
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Actividad";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td></td></tr>";
			echo "</table>";
		
			echo "<table border='0' align='center' width='450px'>";
				echo "<tr>";
					echo "<td colspan='3' id='titleBlueLineBottom'></td>";
				echo "</tr>";
	
				echo "<tr height='25px'><td ></td></tr>";
				
				echo "<tr height='20px'>";
					echo "<td id='iconosTexto2' align='left'>Fecha</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='left'>";
						echo "<input type='text' class='DatP' size=15 maxlength=10 name='fecha'><input type='hidden' name='idItem' value='$idItem'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td ></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left'>Título</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='left'>";
						echo "<input type='text' size='71' maxlength='100' name='titulo'><input type='hidden' name='codigoItem' value='$codigoItem'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='40px'><td ></td></tr>";
				
				echo "<tr>";
					echo "<td align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td></td>";
				echo "</tr>";
						
			echo "</table>";
		
		echo "</form>";
	echo "</div>";
	
} 

else if(($_POST['fecha'] != "") && ($_POST['titulo'] != "")){
	
	$fechaInsert 		= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 		= $_POST['titulo'];
	$idItemInsert		= $_POST['idItem'];
	$codigoItemInsert	= $_POST['codigoItem'];
	
	$maximo = 0;
	
	//$anio = date('Y', strtotime($_POST['fecha']));
	//echo"CODIGO $codigoItemInsert";
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Procesos_Actividades WHERE kf_itemID = $idItemInsert");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-H-DF-14-001/001

	
	if(strlen($maximo) == 1){
		
		$codigo = $codigoItemInsert."/00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigoItemInsert."/0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigoItemInsert."/".$maximo;
		
	}
	
	//echo"INSERT INTO SGI_Procesos_Actividades(kf_ItemID,xt_nombre,xd_fecha,xt_codigoActividad,xn_numero)VALUES($idItemInsert, '$tituloInsert','$fechaInsert', '$codigo', $maximo)";
						
	if($INTRANET->Execute("INSERT INTO SGI_Procesos_Actividades(kf_ItemID,xt_nombre,xd_fecha,xt_codigoActividad,xn_numero) 
						VALUES($idItemInsert, '$tituloInsert','$fechaInsert', '$codigo', $maximo) ")){
												  
		$idActividad = mysql_insert_id();

		header("Location: FichaItem.php?id=$idItemInsert");
	
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Agregar Boletín</title>
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
                </head>
                <body>
        <?php
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Actividad no agregada</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40px'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick=\"location.href='FichaItem.php?id=$idItemInsert';\" src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
		echo "</div>";
	}
	
}
		
?>
    	</body>
    </html>
<?php

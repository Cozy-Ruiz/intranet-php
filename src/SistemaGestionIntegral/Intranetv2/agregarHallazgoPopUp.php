<?php
/*
 *@author Octavio Francisco García Robles 
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'AgregaIssue.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);

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

$clave = $_GET['clave'];

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


if(($_POST['titulo'] == "") || ($_POST['fecha'] == "") || ($_POST['descripcion'] == "")){
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8" />
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                <title>Agregar Hallazgo</title>
                <?php
                if($estiloUsuario == 1){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
                }else if($estiloUsuario == 2){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
                }
                ?>
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
	
	echo "<div id='wrapperPopUp'>";
	  echo "<form method='post' action='agregarHallazgoPopUp.php?clave=$clave'  enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Agregar Hallazgo";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='70px'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450px'>";
			echo "<tr>";
				echo "<td colspan='2' id='titleBlueLineTop'>";
				echo "</td>";
			echo "</tr>";
	
			echo "<tr height='15px'><td colspan='2'></td></tr>";
			
			echo "<tr height='20px'>";
				echo "<td id='iconosTexto2' align='left'>Titulo</td>";
				echo "<td id='iconosTexto2' align='right'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='left'>";
					echo "<input type='text' size=50 maxlength=100 name='titulo'>";
				echo "</td>";
				
				echo "<td  align='right'>";
					echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='2'></td></tr>";
			
			echo "<tr height='20px'>";
				echo "<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
					echo "Descripción";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10'><td colspan='2'></td></tr>";
			
			echo "<tr>";
				echo "<td valign='bottom' align='left' colspan='2'>";
					echo "<textarea name='descripcion' style='width: 450px; height: 60px;'></textarea>";
					echo "<input type='hidden' value='".$clave."' name='auditoriaID'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='15px'><td colspan='2'></td></tr>";
			
			echo "<tr>";
				echo "<td colspan='2' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='2'></td></tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='30px'>";
				echo "<td align='right' colspan='2'></td>";
			echo "</tr>";
					
		echo "</table>";
		echo "</form>";
	echo "</div>";

} else if(($_POST['fecha'] != "") && ($_POST['titulo'] != "") && ($_POST['descripcion'] != "")){

	$auditoriaID 		= $_POST['auditoriaID'];
	$fechaInsert 		= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 		= $_POST['titulo'];
	$descripcionInsert 	= $_POST['descripcion'];
	
	$ciudadInsert	= $INTRANETV2->getOne("SELECT xt_ciudad FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$auditoriaID."' ");
	 echo $grupoInsert	= $INTRANETV2->getOne("SELECT xt_grupo FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$auditoriaID."' ");
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;

	/*$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Auditorias_Hallazgos WHERE YEAR(xd_fecha) = $anio AND xt_grupo = '".$grupoInsert."'
							 AND xt_ciudad = '".$ciudadInsert."' ");*/
	
	$s = $INTRANETV2->Execute("SELECT COUNT(xt_grupo) FROM SGI_Auditorias_Hallazgos WHERE xt_ciudad = '"
		.$ciudadInsert."' AND xt_grupo = '".$grupoInsert."' AND YEAR(xd_fecha) = '".$anio."'");

	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	

	//GENERACION DEL CODIGO
	//GE-G-DF-14-001
	if(($ciudadInsert != "") && ($ciudadInsert != "GEN")){
		
		$codigo = $grupoInsert."-G-".$ciudadInsert."-";
		
	} else{
		
		$codigo = $grupoInsert."-G-";
		
	}
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
    
	if($INTRANETV2->Execute("INSERT INTO SGI_Auditorias_Hallazgos (xt_claveHallazgo, xt_claveAuditoria, xd_fecha, xt_titulo, xt_descripcion, xt_grupo, xt_ciudad, xt_status) VALUES ('".$codigo."', '".$auditoriaID."', '".$fechaInsert."', '".$tituloInsert."', '".$descripcionInsert."', '".$grupoInsert."', '".$ciudadInsert."','0')"))
	{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8" />
                    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                    <title>Agregar Issue</title>
                    <?php
                    if($estiloUsuario == 1){
                        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
                    }else if($estiloUsuario == 2){
                        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
                    }
                    ?>
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
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8" />
                    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                    <title>Agregar Issue</title>
                    <?php
                    if($estiloUsuario == 1){
                        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
                    }else if($estiloUsuario == 2){
                        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
                    }
                    ?>
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
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Issue No Agregado</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40px'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70px'><td></td></tr>";
			echo "</table>";
		echo "</div>";
	}
}
		
?>
    	</body>
    </html>
<?php

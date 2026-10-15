<?php error_reporting(0); ?>
<?PHP
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'AgregaPrevencionRiesgo.php';
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

$idRiesgo = $_GET['id'];

$tipo = "";

if($_POST["tipo"] != ""){
	$tipo = $_POST["tipo"];
}else if($_GET["tipo"] != ""){
	$tipo = $_GET["tipo"];
}
$accion="";
if($_GET["accion"] != ""){
	$accion = $_GET["accion"];
}

if(($tipo == "") && ($accion == "")){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acciones</title>
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
<?PHP
echo "<div id='wrapperPopUp'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Prevención</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>";
			echo"<td align='center' id='breadcrumbs'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr></tr>";
		
		echo"<tr height='100'> </tr>";
	echo "</table>";
	//CUERPO FICHA ALTA

	echo "<table border='0' align='center' width='450'>";
			
		echo "<tr>";
			echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
		echo "</tr>";

		echo"<tr height='40px'> </tr>";
		
		echo"<tr>";
			echo"<td valign='bottom' align='center' >";
				echo "<input type='image' onclick=\"location.href='AgregaPrevencionRiesgo.php?tipo=PREVENTIVAS&id=$idRiesgo';\" src='../Imagenes/ICN_BotonAPreventiva.png' width='120' height='39'>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='40'> </tr>";
		
		echo"<tr>";
			echo"<td valign='bottom' align='center' >";
				echo "<input type='image' onclick=\"location.href='AgregaPrevencionRiesgo.php?tipo=DOCUMENTOS&id=$idRiesgo';\" src='../Imagenes/ICN_BotonDocumento.png' width='120' height='39'>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='40'> </tr>";
		
		echo"<tr>";
			echo"<td valign='bottom' align='center' >";
				echo "<input type='image' onclick=\"location.href='AgregaPrevencionRiesgo.php?tipo=SIMULACRO&id=$idRiesgo';\" src='../Imagenes/ICN_Simulacro.png' width='120' height='39'>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='40'> </tr>";
		
		echo "<tr>";
			echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
		echo "</tr>";
		
		echo "<tr height='30'></tr>";
	echo "</table>";
echo "</div>";
//TIPO ELEGIDO DIFERENTE DE PPREVENTIVA
}else if((($tipo == "SIMULACRO")) && ( ($_POST['fecha'] == ("" || NULL)) || ($_POST['titulo'] == ("" || NULL)) || ($_POST['descripcion'] == ("" || NULL)) ) ){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acciones</title>
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
<?PHP
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregaPrevencionRiesgo.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Simulacro </font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
	
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left' >Título</td>";
				echo "<td id='iconosTexto2' align='right' >Fecha</td>";
			echo "</tr>";
			
			echo"<tr align='left'>";
				echo "<td  align='left'>";
					echo "<input type='text' size=50 maxlength=100 name='titulo'><input type='hidden' name='id' value=$idRiesgo><input type='hidden' name='tipo' value='$tipo'>";
				echo"</td>";
				echo "<td  align='right'>";
					echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha'>";
				echo"</td>";
			echo "</tr>";
			
			echo"<tr height='20'> ";
				echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'> Descripción </td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr> ";
				echo"<td valign='bottom' align='left' colspan='2'>";
				echo"<textarea name='descripcion' style='width: 450px; height: 60px;'></textarea></td>";
			echo"</tr>";
						
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
			echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'> Archivo </td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr> ";
				echo"<td valign='bottom' align='left' colspan='2'> <input type='file' name='archivo'></input> </td>";
			echo"</tr>";
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right' colspan='2'></td>";
			echo "</tr>";
					
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
//TIPO ELEGIDO DIFERENTE DE PREVENTIVA
}else if((($tipo == "SIMULACRO")) && ( ($_POST['fecha'] != ("" || NULL)) || ($_POST['titulo'] != ("" || NULL)) || ($_POST['descripcion'] != ("" || NULL)) ) ){
	$idRiesgoInsert = $_POST['id'];
	$tituloInsert = $_POST['titulo'];
	$fechaInsert = date('Y-m-d', strtotime($_POST['fecha']));
	$tipoInsert = $_POST['tipo'];
	$descripcionInsert = $_POST['descripcion'];
	
	$anio = date('Y');
	$maximo = 0;
	
	$s= $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Simulacros");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	if($INTRANET->Execute("INSERT INTO SGI_Simulacros (kf_riesgoId,xn_numero,xd_fecha,xt_titulo) VALUES ($idRiesgoInsert,$maximo,'$fechaInsert','$tituloInsert')")){
		$simulacroId = mysql_insert_id();
		
		if($descripcionInsert != ""){
			  
			  $INTRANET->Execute("UPDATE SGI_Simulacros SET xt_descripcion='$descripcionInsert' WHERE kp_simulacroId = $simulacroId ");
			  
		  }
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
				
			$destino = "Simulacros/$archivo";
			//echo"$destino<br>";
				
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				//echo"UPDATE SGI_Simulacros SET xt_ruta = '$destino' WHERE kp_sumulacroId = $simulacroId ";
				if($INTRANET->Execute("UPDATE SGI_Simulacros SET xt_ruta = '$destino' WHERE kp_simulacroId = $simulacroId ") ){
					
					echo "<script type='text/javascript'>reCargarPadre()</script>";
					
				} else{
					?>
                    <!doctype html>
                    <html>
                    <head>
                    <meta charset="utf-8">
                    <title>Acciones</title>
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
                    <?PHP
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center' name='Encabezado'>";
							
							echo"<tr>"; 
								echo"<td align='center'>";
									echo "<font>$breadcrumb</font>";
								echo"</td>";
								
							echo"</tr>";
							echo"<tr height='70'> </tr>";
							
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Error en la carga</font>";
								echo"</td>";
							echo"</tr>";
							
							echo"<tr>";
								echo"<td align='center'>";
									echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
								echo"</td>";
							echo"</tr>";
							
						echo "</table>";
					echo "</div>";
				}		
			}
			
		}
		 echo "<script type='text/javascript'>reCargarPadre()</script>";
	}else{
		?>
		<!doctype html>
		<html>
		<head>
		<meta charset="utf-8">
		<title>Acciones</title>
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
		<?PHP
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				
				echo"<tr>"; 
					echo"<td align='center'>";
						echo "<font>$breadcrumb</font>";
					echo"</td>";
					
				echo"</tr>";
				echo"<tr height='70'> </tr>";
				
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error en la carga</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>";
					echo"<td align='center'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
		echo "</div>";
	}
//TIPO ELEGIDO IGUAL A PREVENTIVAS
}else if(($tipo == "PREVENTIVAS")&& ($accion == "")){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acciones</title>
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
<?PHP
	echo "<div id='wrapperPopUp'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Acción </font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
	
			echo"<tr height='40px'> </tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<a href='AgregaPrevencionRiesgo.php?tipo=PREVENTIVAS&id=$idRiesgo&accion=GENERAR'><img src='../Imagenes/ICN_BotonGenerar.png' width='120' height='39'></a>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='40'> </tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<a href='AgregaPrevencionRiesgo.php?tipo=PREVENTIVAS&id=$idRiesgo&accion=VINCULAR'><img src='../Imagenes/ICN_BotonVincular.png' width='120' height='39'></a>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='40'> </tr>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo "<tr height='30'></tr>";
		echo "</table>";
		
	echo "</div>";

	//ACCION ELEGIDO IGUAL A VINCULAR CAPTURAR CODIGO
}else if(($tipo == "PREVENTIVAS") && ($accion == "VINCULAR") && ($_POST['codigo']== "")){
	?>
    <!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Acciones</title>
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
    <?PHP
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregaPrevencionRiesgo.php?tipo=PREVENTIVAS&id=$idRiesgo&accion=VINCULAR'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Vincular </font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Se tratará con el siguiente item: <input type='hidden' name='titulo' value='Se tratará con el siguiente item'></td>";
			echo "</tr>";
	
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Código</td>";
			echo "</tr>";
			
			echo"<tr align='left'>";
				echo "<td  align='left'>";
					echo "<input type='text' size=20 maxlength=100 name='codigo'><input type='hidden' name='id' value=$idRiesgo><input type='hidden' name='tipo' value='$tipo'>";
				echo"</td>";
			echo "</tr>";
			
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right'></td>";
			echo "</tr>";
					
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
	//ACCION ELEGIDO IGUAL A VINCULAR CAPTURAR CODIGO
 } else if(($tipo == "PREVENTIVAS") && ($accion == "VINCULAR") && ($_POST['codigo']!= "") ){
		
	$codigoInsert = $_POST['codigo'];
	$idInsert = $_POST['id'];
	$tituloInsert = $_POST['titulo'];
	$fechaInsert = date("Y-m-d");
	
	$tipoCanalizacion = substr($codigoInsert,0,1);

		
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acciones_Riesgos WHERE kf_riesgoId = $idInsert");

	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	if($INTRANET->Execute("INSERT INTO SGI_Acciones_Riesgos (kf_riesgoId,xn_numero,xd_fecha,xt_titulo,xt_tipoTratamiento,xt_tipo) 
	VALUES ($idInsert,$maximo,'$fechaInsert','$tituloInsert','$codigoInsert','$tipoCanalizacion') ")){
	
		echo "<script type='text/javascript'>reCargarPadre()</script>";

	} else{
		?>
        <!doctype html>
        <html>
        <head>
        <meta charset="utf-8">
        <title>Acciones</title>
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
        <?PHP
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				
				echo"<tr>"; 
					echo"<td align='center'>";
						echo "<font>$breadcrumb</font>";
					echo"</td>";
					
				echo"</tr>";
				echo"<tr height='70'> </tr>";
				
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: no se vinculo la Acción Preventiva</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>";
					echo"<td align='center'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
		echo "</div>";
		
		
	}
//ACCION ELEGIDO IGUAL A PREVENTIVA
} else if(($tipo == "PREVENTIVAS") && ($accion == "GENERAR")){
	
	header("Location: altaPreventivaCorrectivaPopUp.php?tipo=preventiva&idRiesgo=$idRiesgo");

	
}else if(($tipo == "DOCUMENTOS") && ($accion == "")){
	?>
    <!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Acciones</title>
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
    <?PHP
	
	echo "<div id='wrapperPopUp'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Acción </font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
	
			echo"<tr height='40px'> </tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<a href='AgregaPrevencionRiesgo.php?tipo=DOCUMENTOS&id=$idRiesgo&accion=GENERAR'><img src='../Imagenes/ICN_BotonGenerar.png' width='120' height='39'></a>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='40'> </tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<a href='AgregaPrevencionRiesgo.php?tipo=DOCUMENTOS&id=$idRiesgo&accion=VINCULAR'><img src='../Imagenes/ICN_BotonVincular.png' width='120' height='39'></a>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='40'> </tr>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo "<tr height='30'></tr>";
		echo "</table>";
		
	echo "</div>";

	
}else if(($tipo == "DOCUMENTOS") && ($accion == "GENERAR")){
	
	header("Location: AgregarItemPopUp.php");

	
}else if(($tipo == "DOCUMENTOS") && ($accion == "VINCULAR") && ($_POST['codigo']== "")){
	?>
    <!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Acciones</title>
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
    <?PHP
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregaPrevencionRiesgo.php?tipo=DOCUMENTOS&id=$idRiesgo&accion=VINCULAR'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Vincular </font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Se tratará con el siguiente item: <input type='hidden' name='titulo' value='Se tratará con el siguiente item'></td>";
			echo "</tr>";
	
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Código</td>";
			echo "</tr>";
			
			echo"<tr align='left'>";
				echo "<td  align='left'>";
					echo "<input type='text' size=20 maxlength=100 name='codigo'><input type='hidden' name='id' value=$idRiesgo><input type='hidden' name='tipo' value='$tipo'>";
				echo"</td>";
			echo "</tr>";
			
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right'></td>";
			echo "</tr>";
					
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
	
}else if(($tipo == "DOCUMENTOS") && ($accion == "VINCULAR") && ($_POST['codigo']!= "") ){
		
	$codigoInsert = $_POST['codigo'];
	$idInsert = $_POST['id'];
	$tituloInsert = $_POST['titulo'];
	$fechaInsert = date("Y-m-d");
	
	$tipoCanalizacion = substr($codigoInsert,0,1);

		
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acciones_Riesgos WHERE kf_riesgoId = $idInsert");

	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	if($INTRANET->Execute("INSERT INTO SGI_Acciones_Riesgos (kf_riesgoId,xn_numero,xd_fecha,xt_titulo,xt_tipoTratamiento,xt_tipo) 
	VALUES ($idInsert,$maximo,'$fechaInsert','$tituloInsert','$codigoInsert','$tipoCanalizacion') ")){
	
		echo "<script type='text/javascript'>reCargarPadre()</script>";

	} else{
		?>
        <!doctype html>
        <html>
        <head>
        <meta charset="utf-8">
        <title>Acciones</title>
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
        <?PHP
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				
				echo"<tr>"; 
					echo"<td align='center'>";
						echo "<font>$breadcrumb</font>";
					echo"</td>";
					
				echo"</tr>";
				echo"<tr height='70'> </tr>";
				
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: no se vinculo la Acción Preventiva</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>";
					echo"<td align='center'>";
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
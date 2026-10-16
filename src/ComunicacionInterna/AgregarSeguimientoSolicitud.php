<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio F. García Robles
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='AgregarSeguimientoSolicitud.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
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

$origen 			= "";
$ID					= "";
$solicitudEstatus 	= "";

if($_GET['origen'] != ""){
	$origen	= $_GET['origen'];
	
} else if($_POST['origen'] != ""){
	$origen	= $_POST['origen'];
	
}

if($_GET['ID'] != ""){
	$ID 	= $_GET['ID'];
	
} else if($_POST['ID'] != ""){
	$ID 	= $_POST['ID'];
	
}

if($_GET['estatus'] != ""){
	$solicitudEstatus = $_GET['estatus'];
	
} else if($_POST['estatus'] != ""){
	$solicitudEstatus = $_POST['estatus'];
	
}
///ASIGNAR
if($solicitudEstatus == "ASIGNAR"){

	if(($_POST['pdr'] == "" ) || ($_POST['fecha'] == "")){
		
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Seguimiento Solicitud</title>
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
	
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='agregarSeguimiento' method='POST' action='AgregarSeguimientoSolicitud.php'  enctype='multipart/form-data'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Asignar PDR";
					echo"</td>";
				echo"</tr>";
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450'>";
					
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo"<tr height='15'> </tr>";
				
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left' >PDR</td>";	
				echo "</tr>";
				
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left' >";
						echo "<select name='pdr' size='1' >";
							echo "<option value=''>Elegir</option>";
								
							$s= $INTRANET->Execute("SELECT empa.kf_personalID, emp.xt_nombreCorto FROM SGI_EmpleadosActividad empa, SGI_Empleados emp 
							WHERE emp.kp_personalId= empa.kf_personalID AND xt_actividad='PDR' ");
								
							while($r= $s -> fetchRow()){
								
								echo"<option value='$r[0]'>$r[1]</option>";
								
							} unset($r); unset ($s);
							
						echo"</select>
						</td>";	
				echo "</tr>";
				
				echo"<tr height='15'> </tr>";
				
				echo"<tr align='left'>";
						echo "<td id='iconosTexto2' align='left' >Fecha</td>";	
				echo "</tr>";
				
				echo"<tr height='20'> ";
					echo "<td  align='left'>";
						echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha'>";
						echo "<input type='hidden' name='origen' value='$origen'>";
						echo "<input type='hidden' name='ID' value='$ID'>";
						echo "<input type='hidden' name='estatus' value='$solicitudEstatus'>";
					echo"</td>";
				echo"</tr>";
	
				echo"<tr height='15'> </tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineBottom'> </td>";
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
		
		?>
        </body>
        </html>
		<?php		
		
	} else if(($_POST['pdr'] != "") && ($_POST['fecha'] != "")){
		
		$pdrInsert 		= $_POST['pdr'];
		$fechaInsert 	= date('Y-m-d', strtotime($_POST['fecha']));
		$origenInsert 	= $_POST['origen'];
		$IDInsert 		= $_POST['ID'];
		
		$maximo=0;
		
		$anio = date('Y',strtotime($_POST['fecha']));
		
		$s= $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Seguimientos WHERE  YEAR(xd_fechaRegistro) = '$anio' ");
		
		while($r = $s->fetchRow()){
			$maximo = $r[0];
			
		}
		
		$maximo++;
		unset($r); unset($s);
		
		$anio = date('y',strtotime($_POST['fecha']));
		
		if(strlen($maximo) == 1){
			$codigo = "S-".$anio."-00".$maximo;
			
		} else if(strlen($maximo) == 2){
			$codigo = "S-".$anio."-0".$maximo;
			
		} else if(strlen($maximo) == 3){
			$codigo = "S-".$anio."-".$maximo;
			
		}
		
		if($INTRANET->Execute("INSERT INTO SGI_Seguimientos (xt_tipoOrigen,kf_itemOrigenID,xn_numero,xd_fechaRegistro,xt_codigoSeguimiento,kf_asignadorID,kf_pdrID) 
							VALUES ('$origenInsert', $IDInsert, $maximo, '$fechaInsert', '$codigo', 97, $pdrInsert)  ")){
								
			$seguimientoInsert = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE xt_codigoSeguimiento = '$codigo' ");
			
			
			
			$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatus (kf_seguimientoID, xn_numero, xt_estatus, xd_fecha) 
																	VALUES($seguimientoInsert, 1, 'ABIERTA', '$fechaInsert') ");
																	
			?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Seguimiento Solicitud</title>
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
			
			echo "<script type='text/javascript'>reCargarPadre()</script>";
			
			?>
            </body>
            </html>
            <?php
		
		} else{
			
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Seguimiento Solicitud</title>
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
			
			echo "<div id='wrapperPopUp'>";
				echo "<form name='fichaSubir' method='post' action='AgregaRevision.php'>";	
					echo "<table border='0' align='center' name='Encabezado'>";
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>PDR no asignado</font>";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='40'>";
							echo"<td valign='bottom' align='right' colspan='2'>";
								echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='70'> </tr>";
					echo "</table>";
				echo "</form>";
			echo "</div>";
		
			?>
			</body>
			</html>
			<?php
			
		}
	}
	
} else if($solicitudEstatus == "REVISION"){
	
	$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $ID AND xt_tipoOrigen = '$origen' ");
	
	$estatusMax 	= 0;
	$idEstatusMax 	= 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $seguimientoID ");
	
	while($r = $s->fetchRow()){
		
		$estatusMax = $r[0];
		
	} unset($r);
	
	$s = $INTRANET->Execute("SELECT MAX(kp_estatusID) FROM SGI_Quejas_Solicitudes_Estatus ");
	
	while($r = $s->fetchRow()){
		
		$idEstatusMax = $r[0];
		
	} unset($r); unset($s);
	
	$estatusMax++;
	$idEstatusMax++;
	
	if(/*($_POST['titulo'] == "") || */($_POST['fecha'] == "") || ($_POST['descripcion'] == "")){
	
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Seguimiento Solicitud</title>
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
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='agregarSeguimiento' method='POST' action='AgregarSeguimientoSolicitud.php'  enctype='multipart/form-data'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Para Revisión";
					echo"</td>";
				echo"</tr>";
				echo"<tr height='40'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450'>";
					
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo"<tr height='15'> </tr>";
			
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left' colspan='2'>Fecha</td>";
				echo "</tr>";
				
				echo"<tr align='left'>";
					echo "<td  align='left' colspan='2'>";
						echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha'>";
					echo"</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr height='20'> ";
					echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
						echo"Descripción";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr> ";
					echo"<td valign='bottom' align='left' colspan='2'>";
						echo"<textarea name='descripcion' style='width: 450px; height: 60px;'></textarea>";
						echo "<input type='hidden' name='origen' value='$origen'>";
						echo "<input type='hidden' name='ID' value='$ID'>";
						echo "<input type='hidden' name='estatus' value='$solicitudEstatus'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left' colspan='2'>Seleccione un archivo:</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='2'>";
						echo "<input type='file' name='archivo'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineBottom'> </td>";
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
		
		?>
		</body>
		</html>
		<?php
		
	} else if(/*($_POST['titulo'] != "") && */($_POST['fecha'] != "") && ($_POST['descripcion'] != "")){
		
		//$tituloInsert = $_POST['titulo'];
		$fechaInsert		= date('Y-m-d', strtotime($_POST['fecha']));
		$descripcionInsert 	= nl2br($_POST['descripcion']);
		
		if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatus(kp_estatusID, kf_seguimientoID, xn_numero, xt_estatus, xt_contenido, xd_fecha) 
																   VALUES($idEstatusMax, $seguimientoID, $estatusMax , 'REVISION', '$descripcionInsert', '$fechaInsert') ")){
			
			$archivo = $_FILES['archivo']['name'];
			$archivo = limpiar_caracter_especial($archivo);
			
			if ($archivo != ""){
				$destino = "SeguimientoEtapas/$archivo";
				
				if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
					
					if($INTRANET->Execute("
						UPDATE SGI_Quejas_Solicitudes_Estatus SET xt_ruta = '$archivo' WHERE kf_seguimientoID = $seguimientoInsert AND xn_numero = $etapa ") ){
							
						?>
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Seguimiento Solicitud</title>
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
						
						echo "<script type='text/javascript'>reCargarPadre()</script>";
						
						?>
						</body>
						</html>
						<?php
								
					} else{
						
						?>
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Seguimiento Solicitud</title>
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
						
						echo "<div id='wrapperPopUp'>";
							echo "<table border='0' align='center' name='Encabezado'>";
							
								echo"<tr>";
									echo"<td align='center' id='titulo1'>";
										echo "<font>Error en la carga del archivo</font>";
									echo"</td>";
								echo"</tr>";
								
							echo "</table>";
						echo "</div>";
						
						?>
						</body>
						</html>
						<?php
					}
					
				} else{
					
					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Seguimiento Solicitud</title>
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
					
					echo "<div id='wrapperPopUp'>";
						echo "<table border='0' align='center' name='Encabezado'>";
						
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Error en la carga del archivo.</font>";
								echo"</td>";
							echo"</tr>";
							
						echo "</table>";
					echo "</div>";
					
					?>
					</body>
					</html>
					<?php
					
				}
			}
			
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Seguimiento Solicitud</title>
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
			
			echo "<script type='text/javascript'>reCargarPadre()</script>";
			
			?>
			</body>
			</html>
			<?php
		
		} else{
			
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Seguimiento Solicitud</title>
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
			
			echo "<div id='wrapperPopUp'>";
				echo "<form name='fichaSubir' method='post' action='AgregaRevision.php'>";	
					echo "<table border='0' align='center' name='Encabezado'>";
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Etapa No Agregada</font>";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='40'>";
							echo"<td valign='bottom' align='right' colspan='2'>";
								echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='70'> </tr>";
					echo "</table>";
				echo "</form>";
			echo "</div>";
			
			?>
			</body>
			</html>
			<?php
			
		}
			
	}
///EVALUAR
} else if($solicitudEstatus == "EVALUACION"){
	
	$seguimientoID = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $ID AND xt_tipoOrigen = '$origen' ");
	
	$estatusMax 	= 0;
	$idEstatusMax 	= 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatus WHERE kf_seguimientoID = $seguimientoID ");
	
	while($r = $s->fetchRow()){
		
		$estatusMax = $r[0];
		
	} unset($r);
	
	$s = $INTRANET->Execute("SELECT MAX(kp_estatusID) FROM SGI_Quejas_Solicitudes_Estatus ");
	
	while($r = $s->fetchRow()){
		
		$idEstatusMax = $r[0];
		
	} unset($r); unset($s);
	
	$estatusMax++;
	$idEstatusMax++;
		
	if(/*($_POST['titulo'] == "") || */($_POST['fecha'] == "") || ($_POST['descripcion'] == "") || ($_POST['evaluacion'] == "")){
	
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Seguimiento Solicitud</title>
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
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='agregarSeguimiento' method='POST' action='AgregarSeguimientoSolicitud.php'  enctype='multipart/form-data'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Evaluar";
					echo"</td>";
				echo"</tr>";
				echo"<tr height='40'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450'>";
					
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo"<tr height='15'> </tr>";
			
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Fecha</td>";
					echo "<td id='iconosTexto2' align='left'>Evaluación</td>";
				echo "</tr>";
				
				echo"<tr align='left'>";
					echo "<td  align='left'>";
						echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha'>";
					echo"</td>";
					echo "<td align='left'>";
						echo "<select name='evaluacion'>";
							echo "<option value=''>Elegir...</option>";
							echo "<option value='RECHAZADA'>Rechazada</option>";
							echo "<option value='TERMINADA'>Terminada</option>";
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr height='20'> ";
					echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
						echo"Descripción";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr> ";
					echo"<td valign='bottom' align='left' colspan='2'>";
						echo"<textarea name='descripcion' style='width: 450px; height: 60px;'></textarea>";
						echo "<input type='hidden' name='origen' value='$origen'>";
						echo "<input type='hidden' name='ID' value='$ID'>";
						echo "<input type='hidden' name='estatus' value='$solicitudEstatus'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo "<tr align='left' height='20'>";
					echo "<td id='iconosTexto2' align='left' colspan='2'>Seleccione un archivo:</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='2'>";
						echo "<input type='file' name='archivo'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineBottom'> </td>";
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
		
		?>
		</body>
		</html>
		<?php
		
	} else if(/*($_POST['titulo'] != "") && */($_POST['fecha'] != "") && ($_POST['descripcion'] != "") && ($_POST['evaluacion'] != "")){
		
		//$tituloInsert = $_POST['titulo'];
		$fechaInsert		= date('Y-m-d', strtotime($_POST['fecha']));
		$descripcionInsert 	= nl2br($_POST['descripcion']);
		
		$evaluacion =  $_POST['evaluacion'];
		
		if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatus(kp_estatusID, kf_seguimientoID, xn_numero, xt_estatus, xt_contenido, xd_fecha) 
																   VALUES($idEstatusMax, $seguimientoID, $estatusMax , '$evaluacion', '$descripcionInsert', '$fechaInsert') ")){
			
			$archivo = $_FILES['archivo']['name'];
			$archivo = limpiar_caracter_especial($archivo);
			
			if ($archivo != ""){
				$destino = "SeguimientoEtapas/$archivo";
				
				if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
					
					if($INTRANET->Execute("
						UPDATE SGI_Quejas_Solicitudes_Estatus SET xt_ruta = '$archivo' WHERE kf_seguimientoID = $seguimientoInsert AND xn_numero = $etapa ") ){
							
						?>
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Seguimiento Solicitud</title>
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
						
						echo "<script type='text/javascript'>reCargarPadre()</script>";
						
						?>
						</body>
						</html>
						<?php
								
					} else{
						
						?>
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Seguimiento Solicitud</title>
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
						
						echo "<div id='wrapperPopUp'>";
							echo "<table border='0' align='center' name='Encabezado'>";
							
								echo"<tr>";
									echo"<td align='center' id='titulo1'>";
										echo "<font>Error en la carga del archivo</font>";
									echo"</td>";
								echo"</tr>";
								
							echo "</table>";
						echo "</div>";
						
						?>
						</body>
						</html>
						<?php
					}
					
				} else{
					
					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Seguimiento Solicitud</title>
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
					
					echo "<div id='wrapperPopUp'>";
						echo "<table border='0' align='center' name='Encabezado'>";
						
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "<font>Error en la carga del archivo.</font>";
								echo"</td>";
							echo"</tr>";
							
						echo "</table>";
					echo "</div>";
					
					?>
					</body>
					</html>
					<?php
					
				}
			}
			
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Seguimiento Solicitud</title>
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
			
			echo "<script type='text/javascript'>reCargarPadre()</script>";
			
			?>
			</body>
			</html>
			<?php
		
		} else{
			
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Seguimiento Solicitud</title>
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
			
			echo "<div id='wrapperPopUp'>";
				echo "<form name='fichaSubir' method='post' action='AgregaRevision.php'>";	
					echo "<table border='0' align='center' name='Encabezado'>";
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Etapa No Agregada</font>";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='40'>";
							echo"<td valign='bottom' align='right' colspan='2'>";
								echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo"<tr height='70'> </tr>";
					echo "</table>";
				echo "</form>";
			echo "</div>";
			
			?>
			</body>
			</html>
			<?php
			
		}
		
		
	}
	
}
?>
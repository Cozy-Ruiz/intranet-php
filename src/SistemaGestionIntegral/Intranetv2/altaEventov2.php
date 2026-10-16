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

<?php
$nombrephp = 'altaEvento.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

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

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			 <a href='../Modulos.php' id='breadcrumbs'> Módulos /</a><a href='../Riesgos.php' id='breadcrumbs'> Riesgos / </a>
			 <a href='tableroEventosv2.php' id='breadcrumbs'> Tablero de Eventos </a>";
			 

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

$impactoEventoShow[0] = "Nula";
$impactoEventoShow[1] = "Muy Baja";
$impactoEventoShow[2] = "Baja";
$impactoEventoShow[3] = "Media";
$impactoEventoShow[4] = "Alta";
$impactoEventoShow[5] = "Muy Alta";

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
                <title>Alta Evento</title>
                 <?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
				?>
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
            </head>
            <body>
    <?php

	echo "<div id='wrapper'>";
		echo "<form method='post' action='altaEventov2.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Agregar Evento";
				echo "</td>";
			echo "</tr>";
			
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

					echo "<tr height='40px'><td></td></tr>";
		
		//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../../navegacion_banana.php");
			echo "</table>";
				echo "</table>";


			echo"</td>";
		echo"</tr>";
			
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
						$t = $INTRANETV2->Execute("SELECT xt_codigo, xt_nombre FROM SGI_Grupos ORDER BY xt_nombre");
								while($p = $t->fetchRow()){
									$codigoGrupo = $p[0];
									$nombreGrupo = $p[1];

										echo"<option value='".$codigoGrupo."'>".$nombreGrupo."</option>";
			
								}
					echo "</select>";
				echo "</td>";
				
				echo "<td>";
					echo "<select name='ciudad'>";
						echo "<option value='' selected='selected'>Elegir...</option>";
						$t = $INTRANETV2->Execute("SELECT DISTINCT
													CASE U.xt_codigoCiudad WHEN 'DF' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
													CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de Mexico' ELSE O.xt_descripcion END as codigo
												FROM
													IntranetGEA.IntranetGEA_Usuarios_Oficina U,
													IntranetGEA.IntranetGEA_CATALOGO_OFICINA O
												WHERE
													O.xt_oficina = U.xt_codigoCiudad
												AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudadess = $p[1];
									$cdValors  = $p[0];

										echo"<option value='".$cdValors."'>".$ciudadess."</option>";
			
								}
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
		///RIESGO RELACIONADO
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Riesgo Relacionado</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'>";
					echo "<select name='riesgo'>";
						echo "<option value=''>Elegir...</option>";
						
						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo FROM SGI_Riesgos ORDER BY xt_codigoRiesgo ");
						
						while($r = $s->fetchRow()){
							
							echo "<option value='".$r[0]."'>".$r[0]." ".$r[1]."</option>";
							
						} unset($r);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
		///CONSECUENCIA
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Consecuencia</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'>";
					echo "<table border='0' align='left'>";
					
					$s = $INTRANETV2->Execute("SELECT xn_impactoRiesgo, xt_descripcionImpactoRiesgo FROM SGI_Descripcion_Riesgos ");
					
					while($r = $s->fetchRow ()){
						
						echo "<tr>";
							echo "<td align='left' id='iconosTexto3' width='710px'>".$r[1]."</td>";
							echo "<td align='right' width='30px'><input type='radio' name='impacto' value='".$r[0]."'></td>";
						echo "</tr>";
						
						echo "<tr height='5px'><td colspan='2'></td></tr>";
						
					} unset($r);
					
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='15px'><td colspan='3'></td></tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right' colspan='3'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
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
	$riesgoIDInsert		= $_POST['riesgo']; 
	$consecuenciaInsert	= $_POST['impacto'];
	
	//$maximo = 0;
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$s = $INTRANETV2->Execute("SELECT CASE WHEN LPAD(MAX(xn_numero),3,'0') IS NULL THEN '001' ELSE LPAD(MAX(xn_numero)+1,3,'0') END FROM SGI_Eventos WHERE  YEAR(xd_fecha) = '$anio' AND xt_ciudad = '$ciudadInsert' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r);
	
//	$maximo++;
	
	$anio = date('y', strtotime($_POST['fecha']));
		
 	$codigo = $grupoInsert."-N-".$ciudadInsert."-".$anio."-".$maximo;

	
	if($INTRANETV2->Execute("INSERT INTO SGI_Eventos(xd_fecha, xt_ciudad, xt_titulo, xn_numero, xt_codigoEvento, xt_grupo) 
										   VALUES ('$fechaInsert', '$ciudadInsert', '$tituloInsert', $maximo, '$codigo', '$grupoInsert') ")){
		
		
		//$idEvento = $INTRANET->getOne("SELECT MAX(kp_eventoID) FROM SGI_Eventos");
		//$idEvento = mysql_insert_id();
		
		if($descripcionInsert != "" ){
			
			$INTRANETV2->Execute("UPDATE SGI_Eventos SET xt_descripcion = '$descripcionInsert' WHERE xt_codigoEvento = '$codigo' ");
			
		}
		
		if($riesgoIDInsert != ""){
			
			$fechaCaptura = date('Y-m-d');
			
			$INTRANETV2->Execute("INSERT INTO SGI_Riesgos_Eventos(xt_codigoEvento, xt_codigoRiesgo, xd_fecha) 
														VALUES ('$codigo', '$riesgoIDInsert', '$fechaCaptura') ");
			
		}
		
		if($consecuenciaInsert != ""){
			
			$INTRANETV2->Execute("UPDATE SGI_Eventos SET xn_impacto = $consecuenciaInsert WHERE xt_codigoEvento = '$codigo' ");
			
		}
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if($archivo != ""){
			
			$destino = "../Eventos/".$archivo;
			
			//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANETV2->Execute("UPDATE SGI_Eventos SET xt_ruta = '$archivo' WHERE xt_codigoEvento = '$codigo' ") ){
					
					header("Location: fichaEventov2.php?evento=$codigo");
					
				} else{
					
					?>
                   	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Alta Evento</title>
                                <?php
								if($estiloUsuario == 1){
									echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
								}else if($estiloUsuario == 2){
									echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
								}
								?>
                                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
						echo "<table border='0' align='center'>";
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='40px'>";
								echo"<td valign='bottom' align='right'>";
									echo "<input type='image' onclick='reCargarPadre()' src='../../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
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
                            <title>Alta Evento</title>
                            <?php
							if($estiloUsuario == 1){
								echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
							}else if($estiloUsuario == 2){
								echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
							}
							?>
                            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
		
		
		header("Location: fichaEventov2.php?evento=$codigo");
		
	
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Alta Evento</title>
                    <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
					}
					?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
            echo "<table border='0' align='center'>";
                echo"<tr>";
                    echo"<td align='center' id='titulo1'>";
                        echo "Evento No Agregado";
                    echo"</td>";
                echo"</tr>";
                
                echo"<tr height='40px'>";
                    echo"<td valign='bottom' align='right'>";
                        echo "<input type='image' onclick='reCargarPadre()' src='../../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
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

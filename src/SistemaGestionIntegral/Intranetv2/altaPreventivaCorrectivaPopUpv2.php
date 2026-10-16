<?php

$nombrephp='altaPreventivaCorrectivaPopUp.php';
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

$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral /</a>
			<a href='tableroPreventivasCorrectivasv2.php' id='breadcrumbs'> Tablero Acciones Preventivas y Correctivas</a>";

$contadorCiudad = 0;
$t = $INTRANETV2->Execute("SELECT xt_nombre, xt_sucursal FROM SGI_Catalogo_Sucursales");
while($p = $t->fetchRow()){
	if($p[1] !="LRD"){ 
		$ciudades[$contadorCiudad] = $p[0];
		
		$cdValor[$contadorCiudad]  = $p[1]; $contadorCiudad++;}
}unset($p);unset($t);unset($contadorCiudad);

//$todas = $INTRANET->getOne("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' AND xt_codigoCiudad = 'ALL'");

///MATRIZ GRUPOS

$contadorGrupo = 0;
$t = $INTRANETV2->Execute("SELECT xt_nombre, xt_codigo FROM SGI_Grupos");
while($p = $t->fetchRow()){
	$gruposNombre[$contadorGrupo] = $p[0];
	$gruposItem[$contadorGrupo]  = $p[1];
	$contadorGrupo++;	
}unset($p);unset($t);unset($contadorGrupo);


//$gruposItem[1] = "GE";
//$gruposItem[2] = "OT";
///OBTENER TODAS LAS CIUDADES QUE EL USUARIO TIENEN DISPONIBLES
/*$ciudadesDisponibles = NULL;
$indice = 1;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);*/
///OBTENER LA CATEGORIA DEL USUARIO

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");


$tipo = "";

if($_POST["tipo"] != ""){
	$tipo = $_POST["tipo"];
	
}else if($_GET["tipo"] != ""){
	$tipo = $_GET["tipo"];
	
}

if($tipo == ""){
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Acciones Preventivas y Correctivas </title>
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
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Acciones Preventivas y Correctivas";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='center' id='breadcrumbs'>";
					echo $breadcrumb;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr><td></td></tr>";
			
			echo "<tr height='100px'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop'></td>";
			echo "</tr>";
	
			echo "<tr height='40px'><td></td></tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center'>";
					echo "<input type='image' onclick=\"location.href='altaPreventivaCorrectivaPopUpv2.php?tipo=preventiva';\" src='../../Imagenes/ICN_BotonAPreventiva.png' width='120' height='39'>";
				echo"</td>";
			echo "</tr>";
			
			echo"<tr height='40px'><td></td></tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<input type='image' onclick=\"location.href='altaPreventivaCorrectivaPopUpv2.php?tipo=correctiva';\" src='../../Imagenes/ICN_BotonACorrectivas.png' width='120' height='39'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='40px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td></td></tr>";
		echo "</table>";
	echo "</div>";
}

//ACCION PREVENTIVA
if(($tipo == "preventiva") && (($_POST['fecha'] == "") || ($_POST['titulo'] == "") || ($_POST['grupo'] == "") || ($_POST['ciudad'] == "")) ){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Acciones Preventivas y Correctivas </title>
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
                <script type="text/javascript">
                    function reCargarPadre(){
                        opener.location.reload();
                        window.close();
                    }
                </script>
                
            </head>
            <body>
    <?php
	
	$idRiesgo = "";
	///PROVIENE DE UN RIESGO
	if($_GET['idRiesgo'] !=""){
		
		$idRiesgo = $_GET['idRiesgo'];
		
		echo "<div id='wrapperPopUp'>";
			echo "<form method='post' action='altaPreventivaCorrectivaPopUpv2.php?idRiesgo=".$idRiesgo."' enctype='multipart/form-data'>";
			
	}else{
		
		echo "<div id='wrapper'>";
  			echo "<form method='post' action='altaPreventivaCorrectivaPopUpv2.php' enctype='multipart/form-data'>";	
		
	}
	
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Agregar Acción Preventiva";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs'>";
				echo $breadcrumb;
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td></td></tr>";
		
		echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='450px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='3'></td>";
		echo "</tr>";

		echo "<tr height='15px'><td colspan='3'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2'>Fecha</td>";
			
			echo "<td id='iconosTexto2'>";

				if($categoriaUsr == "Administrador"){
					
					echo "Grupo";
					
				}
			echo "</td>";
			
			echo "<td id='iconosTexto2'>";
				if($categoriaUsr == "Administrador"){
					
					echo "Ciudad";
					
				}
			echo "</td>";
		echo "</tr>";
			
		echo "<tr height='5px'><td colspan='3'></td></tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<input type='text' class='DatP' name='fecha' size='10'>";
				echo "<input type='hidden'  name='tipo' value= 'preventiva'>";
			echo "</td>";
			
			echo "<td>";
				if($categoriaUsr == "Administrador"){
					
					echo "<select name='grupo'>";
						echo "<option value='' selected='selected'>Elegir...</option>";
						
						for($a = 0; $a < count($gruposItem); $a++){
							
							echo "<option value='".$gruposItem[$a]."'>".$gruposNombre[$a]."</option>";
							
						} unset($a);
						
					echo "</select>";
					
				} else if($categoriaUsr == "Inhouse"){
					
					echo "<input type='hidden' name='grupo' value='GEA'>";
					
				}
			echo "</td>";
			
			echo "<td>";
				if($categoriaUsr == "Administrador"){
					
					echo "<select name='ciudad'>";
						echo "<option value='' selected='selected'>Elegir...</option>";	
						
						for($a = 0; $a <count($cdValor); $a++){
							
								echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
							
						}
						
					echo "</select>";
					
				}else if($categoriaUsr == "Inhouse"){
					$ciudadU = $INTRANETV2->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' LIMIT 1");
					echo "<input type='hidden' name='ciudad' value='".$ciudadU."'>";
					
				}
			echo "</td>";
		echo "</tr>";

		echo"<tr height='20px'><td colspan='3'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='3'>Título</td>";
		echo "</tr>";
			
		echo"<tr height='5px'><td colspan='3'></td></tr>";
		
		echo "<tr>";
			echo "<td colspan='3'><input type='text'  name='titulo' size='60'></td>";
		echo "</tr>";
		
		echo"<tr height='20px'><td colspan='3'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='3'>Descripción</td>";
		echo "</tr>";
			
		echo"<tr height='5px'><td colspan='3'></td></tr>";
		
		echo "<tr>";
			echo "<td colspan='3'><textarea name='descripcion' style='width:400px; height:100px;'></textarea></td>";
		echo "</tr>";
		
		echo"<tr height='20px'><td colspan='3'></td></tr>";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
		echo "</tr>";
			
		echo "<tr>";
			echo "<td colspan='3'><input type='file' name='archivo'></td>";
		echo "</tr>";
			
		echo"<tr height='15px'><td colspan='3'></td></tr>";
		
		echo "<tr>";
			echo "<td colspan='3' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'><td colspan='3'></td></tr>";
		
		echo"<tr height='40px'>";
			echo"<td valign='bottom' align='right' colspan='3'>";
				echo "<input type='image' onclick=\"location.href='altaPreventivaCorrectivaPopUpv2.php?tipo=preventiva';\" src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		
		echo "<tr height='30px'>";
			echo "<td align='right' colspan='3'></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
echo "</div>";

} else if(($tipo == "preventiva") && ($_POST['fecha'] != "") && ($_POST['titulo'] != "") && ($_POST['grupo'] != "") && ($_POST['ciudad'] != "")){
	
	$fechaInsert 		= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 		= $_POST['titulo'];
	
	if($_POST['descripcion'] != ""){
		
		$descripcionInsert 	= $_POST['descripcion'];
		
	} else{
		
		$descripcionInsert 	= " ";
	}
	
	$ciudad 			= $_POST['ciudad'];
	$grupoInsert		= $_POST['grupo'];
	echo "Ciudad: $ciudad";
	echo "Grupo: $grupo";
	$anio 	= date('Y', strtotime($_POST['fecha']));
	$maximo = 0;
	
	$s = $INTRANETV2->Execute("SELECT MAX(SUBSTRING(xt_claveAccion,14,3)) FROM SGI_Acciones_Preventivas_Correctivas WHERE YEAR(xd_fecha) = $anio
							 AND xt_tipo = 'D' AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	$codigo = $grupoInsert."-D";
	
	if($ciudad != ""){
		
		$codigo = $codigo."-".$ciudad;
		
	}
	
	$anio = date('y',strtotime($_POST['fecha']));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo."-".$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo."-".$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo."-".$anio."-".$maximo;
		
	}
	
	if($INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas(xt_claveAccion, xt_tipo, xd_fecha, xt_titulo, xt_descripcion, xt_ciudad, xt_grupo) 
						  								VALUES('$codigo', 'D', '$fechaInsert',  '$tituloInsert', '$descripcionInsert', '$ciudad', '$grupoInsert') ")){
		
		//$idPreventiva = $INTRANET->getOne("SELECT MAX(kp_accionesID) FROM SGI_Acciones_Preventivas_Correctivas ");	 /*mysql_insert_id();*/	  
							  
		$banderaRiesgo = 0;
		
		if($_GET['idRiesgo'] != ""){
			
			$idInsert = $_GET['idRiesgo'];
			
			$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acciones_Riesgos WHERE kf_riesgoId = $idInsert ");

			while($r = $s->fetchRow()){
				
				$maximo = $r[0];
				
			} unset($r); unset($s);
			
			$maximo++;
			
			if($INTRANET->Execute("INSERT INTO SGI_Acciones_Riesgos (kf_riesgoId, xn_numero, xd_fecha, xt_titulo, xt_tipoTratamiento, xt_tipo) 
															 VALUES ($idInsert, $maximo, '$fechaInsert', '$tituloInsert', '$codigo', 'D') ")){
				$banderaRiesgo = 1;
			}
		
		}
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if($archivo != ""){
			
			$destino = "../PreventivaCorrectiva/".$archivo;
			
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANETV2->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xt_ruta = '$archivo' WHERE xt_claveAccion = '$codigo' ") ){
					
					if($banderaRiesgo == 0){
						
						header("Location: fichaPreventivav2.php?id=$codigo");
						
					}else if ($banderaRiesgo == 1){
						
						?>
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <title>Acciones Preventivas y Correctivas </title>
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
					}
					
				} else{
					
					?>
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Acciones Preventivas y Correctivas </title>
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
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
					
				}
				
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Acciones Preventivas y Correctivas </title>
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
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' id='titulo1'>";
								echo "Error en la carga";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				
			}
			
		} else{
			
			if($banderaRiesgo == 0){
				
				header("Location: fichaPreventivav2.php?id=$idPreventiva");
				
			}else if ($banderaRiesgo == 1){
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Acciones Preventivas y Correctivas </title>
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
				
			}
		}
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Acciones Preventivas y Correctivas </title>
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
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Acción Preventiva No Agregada";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr><td></td></tr>";
				
				echo "<tr height='70px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo "<tr height='15px'><td colspan='2'></td></tr>";
				
				echo "<tr align='left' height='20px'>";
					echo "<td id='iconosTexto2' align='center' colspan='2'>Error</td>";
				echo "</tr>";
				
				echo "<tr align='left'>";
					echo "<td  align='center' colspan='2'>";
						echo "No se pudo agregar la acción preventiva.";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='tableroPreventivasCorrectivas.php';\">";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td align='right' colspan='2'></td></tr>";
			echo "</table>";
			echo "</form>";
		echo "</div>";
		
	}
}

//ACCION CORRECTIVA
if(($tipo == "correctiva") && (($_POST['fecha'] == "") || ($_POST['titulo'] == "") || ($_POST['grupo'] == "") || ($_POST['ciudad'] == ""))){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Acciones Preventivas y Correctivas </title>
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
                <script type="text/javascript">
                    function reCargarPadre(){
                        opener.location.reload();
                        window.close();
                    }
                </script>
                
            </head>
            <body>
    <?php
	
	$idRiesgo = "";
	
	if($_GET['idRiesgo'] !=""){
		
		$idRiesgo = $_GET['idRiesgo'];
		
		echo "<div id='wrapperPopUp'>";
  			echo "<form method='post' action='altaPreventivaCorrectivaPopUpv2.php?idRiesgo=".$idRiesgo."' enctype='multipart/form-data'>";
		
	}else{
		
		echo "<div id='wrapper'>";
			echo "<form method='post' action='altaPreventivaCorrectivaPopUpv2.php' enctype='multipart/form-data'>";
		
	}
	
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Agregar Acción Correctiva";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='center' id='breadcrumbs'>";
					echo $breadcrumb;
				echo "</td>";
			echo "</tr>";
	
			echo "<tr><td></td></tr>";
			
			echo "<tr height='70'><td></td></tr>";
		echo "</table>";
		//CUERPO FICHA ALTA
	
		echo "<table border='0' align='center' width='450px'>";	
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
	
			echo "<tr height='15px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2'>Fecha</td>";
				
				echo "<td id='iconosTexto2'>";
					if($categoriaUsr == "Administrador"){
						
						echo "Grupo";
						
					}
				echo "</td>";
				
				echo "<td id='iconosTexto2'>";
					if($categoriaUsr == "Administrador"){
						
						echo "Ciudad";
						
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='5px'><td colspan='3'></td></tr>";
		
			echo "<tr>";
				echo "<td>";
					echo "<input type='text' class='DatP' name='fecha' size='10'>";
					echo "<input type='hidden'  name='tipo' value= 'correctiva'>";
				echo "</td>";
				
				echo "<td>";
					if($categoriaUsr == "Administrador"){
						
						echo "<select name='grupo'>";
							echo "<option value='' selected='selected'>Elegir...</option>";
							
							for($a = 0; $a < count($gruposItem); $a++){
								
								echo "<option value='".$gruposItem[$a]."'>".$gruposNombre[$a]."</option>";
								
							} unset($a);
							
						echo "</select>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo "<input type='hidden' name='grupo' value='GE'>";
						
					}
				echo "</td>";
				
				echo "<td>";
					if($categoriaUsr == "Administrador"){
						
						echo "<select name='ciudad'>";
							echo "<option value='' selected='selected'>Elegir...</option>";	
							
							for($a = 0; $a <count($cdValor); $a++){
								
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
								
								
							}
							
						echo "</select>";
						
					}else if($categoriaUsr == "Inhouse"){
					$ciudadU = $INTRANETV2->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' LIMIT 1");
					echo "<input type='hidden' name='ciudad' value='".$ciudadU."'>";
						
					}
				echo "</td>";
			echo "</tr>";
	
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Título</td>";
			echo "</tr>";
				
			echo "<tr height='5px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><input type='text' name='titulo' size='60'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Descripción</td>";
			echo "</tr>";
				
			echo "<tr height='5px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><textarea name='descripcion' style='width:400px; height:100px;'></textarea></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
			echo "</tr>";
				
			echo "<tr>";
				echo "<td colspan='3'><input type='file' name='archivo'></td>";
			echo "</tr>";
				
			echo"<tr height='15px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='3'></td></tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right' colspan='3'>";
					echo "<input type='image' onclick=\"location.href='altaPreventivaCorrectivaPopUpv2.php?tipo=preventiva';\" src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='30px'>";
				echo "<td align='right' colspan='3'></td>";
			echo "</tr>";	
		echo "</table>";
		echo "</form>";
	echo "</div>";

} else if(($tipo == "correctiva") && ($_POST['fecha'] != "") && ($_POST['titulo'] != "") && ($_POST['grupo'] != "") && ($_POST['ciudad'] != "")){
	
	$fechaInsert 		= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 		= $_POST['titulo'];
	
	if($_POST['descripcion'] != ""){
		
		$descripcionInsert 	= $_POST['descripcion'];
		
	} else{
		
		$descripcionInsert 	= " ";
	}
		
	$ciudad 			= $_POST['ciudad'];
	$grupoInsert		= $_POST['grupo'];
	
	$anio 	= date('Y',strtotime($_POST['fecha']));
	
	$maximo = 0;
	
	$s = $INTRANETV2->Execute("SELECT MAX(SUBSTRING(xt_claveAccion,14,3)) FROM SGI_Acciones_Preventivas_Correctivas WHERE YEAR(xd_fecha) = $anio
							 AND xt_tipo = 'E' AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert'");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	$codigo = $grupoInsert."-E";
	
	if($ciudad != ""){
		
		$codigo = $codigo."-".$ciudad;
		
	}
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo."-".$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo."-".$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo."-".$anio."-".$maximo;
		
	}
	
	if($INTRANETV2->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas(xt_claveAccion, xt_tipo, xd_fecha, xt_titulo, xt_descripcion, xt_ciudad, xt_grupo) 
						  							VALUES('$codigo', 'E', '$fechaInsert', '$tituloInsert', '$descripcionInsert',  '$ciudad', '$grupoInsert') ")){
		
		//$idCorrectiva = $INTRANET->getOne("SELECT MAX(kp_accionesID) FROM SGI_Acciones_Preventivas_Correctivas ");/*mysql_insert_id();*/
		
		$banderaRiesgo = 0;
		
		if($_GET['idRiesgo'] != ""){
			
			$idInsert = $_GET['idRiesgo'];
			
			$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acciones_Riesgos WHERE kf_riesgoId = $idInsert ");

			while($r = $s->fetchRow()){
				
				$maximo = $r[0];
				
			} unset($r); unset($s);
			
			$maximo++;
			
			if($INTRANET->Execute("INSERT INTO SGI_Acciones_Riesgos (kf_riesgoId, xn_numero, xd_fecha, xt_titulo, xt_tipoTratamiento, xt_tipo) 
															 VALUES ($idInsert, $maximo, '$fechaInsert', '$tituloInsert', '$codigo', 'E') ")){
				
				$banderaRiesgo = 1;
			}
		
		}
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if($archivo != ""){
			
			$destino = "../PreventivaCorrectiva/".$archivo;
			
			if(move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANETV2->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xt_ruta = '$archivo' WHERE xt_claveAccion = '$codigo' ") ){
					
					if($banderaRiesgo == 0){
						
						header("Location: fichaCorrectivav2.php?id=$codigo");
						
					}else if ($banderaRiesgo == 1){
						
						?>
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <title>Acciones Preventivas y Correctivas </title>
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
						
					}
							
				} else{
					
					?>
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Acciones Preventivas y Correctivas </title>
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
							echo "<tr>";
								echo "<td align='center' id='titulo1'>";
									echo "Error en la carga";

								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
					
				}
				
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Acciones Preventivas y Correctivas </title>
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
							echo "<tr>";
								echo "<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
					
			}
			
		} else{
			
			if($banderaRiesgo == 0){
				
				header("Location: fichaCorrectivav2.php?id=$codigo");
				
			}else if ($banderaRiesgo == 1){
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <title>Acciones Preventivas y Correctivas </title>
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
			}
		}
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Acciones Preventivas y Correctivas </title>
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
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Acción Correctiva No Agregada";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr><td></td></tr>";
				
				echo"<tr height='70px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo "<tr height='15px'><td colspan='2'></td></tr>";
				
				echo "<tr align='left' height='20px'>";
					echo "<td id='iconosTexto2' align='center' colspan='2'>Error</td>";
				echo "</tr>";
				
				echo "<tr align='left'>";
					echo "<td  align='center' colspan='2'>";
						echo "No se pudo agregar la acción correctiva.";
						echo "INSERT INTO SGI_Acciones_Riesgos (kf_riesgoId, xn_numero, xd_fecha, xt_titulo, xt_tipoTratamiento, xt_tipo) 
															 VALUES ($idInsert, $maximo, '$fechaInsert', '$tituloInsert', '$codigo', 'E') ";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right' colspan='2'>";
						echo "<INPUT type='submit' value='Finalizar' onclick=\"location.href='tableroPreventivasCorrectivasv2.php';\">";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td align='right' colspan='2'></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</div>";
	
	}
}
?>
	</body>
</html>
<?php

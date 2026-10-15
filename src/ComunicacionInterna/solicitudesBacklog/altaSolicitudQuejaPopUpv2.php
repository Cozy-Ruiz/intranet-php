<?php error_reporting(0); ?>
<?php
$nombrephp='altaSolicitudQuejaPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

//require_once("MailIntraNet.php");

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


$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a>
			<a href='tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes</a>";

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

$gruposItem[1] = "GE";
//$gruposItem[2] = "OT";

$indice = 1;
$ciudadesDisponibles = NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Solicitudes y Quejas </title>
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
            </head>
            <body>
	<?php

	
echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Solicitud</font>";
			echo"</td>";
		echo"</tr>";
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
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		//echo"<tr height='70'> </tr>";
	echo "</table>";
		
		echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		echo "<tr>";
			echo "<td align='center'>";
				//$archivo = $_SERVER['DOCUMENT_ROOT'];
				//echo $_SERVER['DOCUMENT_ROOT']."<br />";
				$currentDir 	=  getcwd();
				$directorios 	= explode('/',$currentDir);
				
				$bandera 	= 0;
				$cuentaDir	= 0;
				
				for($o = 0; $o < count($directorios); $o++){
					
					if($directorios[$o] == "INTRANET_GEA"){
						
						$bandera = 1;
						
					}
					
					if(($bandera == 1) && ($directorios[$o] != "INTRANET_GEA")){
						
						$cuentaDir++;
						
					}
					
				} unset($o); unset($bandera);
				
				$subirDir = "";
				
				for($o = 1; $o <= $cuentaDir; $o++){
					
					$subirDir = $subirDir."../";
					
				} unset($o);
				
				//echo "SUBDIR: $subirDir, CUENTADIR: $cuentaDir";
				
				//echo "<a href='$archivo' >Archivo</a>";
			
				?>
					<table border='0' align='center' id='breadcrumbs' style='border:1px solid #007cbd;'>
						<tr>
							<td valign='top'>
                            	<a href='../comunicacionInterna.php' id='breadcrumbs'>
                                	Comunicación Interna
                                </a><br />
                                
								<ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../TableroBoletines.php' id='breadcrumbs'>
                                        	Boletines
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../listaQueHacer.php' id='breadcrumbs'>
                                        	Qué hacer
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../tableroSolicitudesyQuejas.php' id='breadcrumbs'>
                                        	Solicitudes y Quejas
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../busquedaPersonal.php' id='breadcrumbs'>
                                        	Acceso Autorizado
                                        </a>
                                    </li>
                                </ul>
                            
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'>
                                	Gestión Integral
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../../SistemaGestionIntegral/Normas.php' id='breadcrumbs'>
                                        	Normas
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=ISO' id='breadcrumbs'>
                                                    ISO
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=NMX' id='breadcrumbs'>
                                                    NMX
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC' id='breadcrumbs'>
                                                    NEEC
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../../SistemaGestionIntegral/manuales.php' id='breadcrumbs'>
                                        	Manuales
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-MC' id='breadcrumbs'>
                                                	Manual de Gestión Integral
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-CDR' id='breadcrumbs'>
                                                    Manual de Control de Documentos y Registros
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-AI' id='breadcrumbs'>
                                                    Manual de Auditorías Internas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-CC' id='breadcrumbs'>
                                                    Manual del Comité de Calidad
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-DG' id='breadcrumbs'>
                                                    Manual de Dirección General
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-ADM' id='breadcrumbs'>
                                                    Manual de Administración
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-RH' id='breadcrumbs'>
                                                    Manual de Recursos Humanos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-TI' id='breadcrumbs'>
                                                    Manual de Tecnologias de la Información
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-OPE' id='breadcrumbs'>
                                                    Manual de Operaciones
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'>
                                        	Módulos del SGI
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../../SistemaGestionIntegral/Riesgos.php' id='breadcrumbs'>
                                                	Administración de Riesgos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'>
                                                    Reuniones y Acuerdos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'>
                                                    Acciones Preventivas y Correctivas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/tableroAuditorias.php' id='breadcrumbs'>
                                                    Auditorías
                                                </a>
                                            </li>
                                            <!-- -->
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Procesos.php' id='breadcrumbs'>
                                                    Inventario de Procesos
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../../Aplicaciones/aplicaciones.php' id='breadcrumbs'>
                                	Aplicaciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../../Aplicaciones/operaciones.php' id='breadcrumbs'>
                                        	Operaciones
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../../AdministracionProyectos/admonPro.php' id='breadcrumbs'>
                                        	Administración de Proyectos
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../../Registros/Registros.php' id='breadcrumbs'>
                                	Registros
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                    	<a href='../../Registros/TableroVisitas2.php' id='breadcrumbs'>
                                        	Visitas
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../../Configuraciones/configuraciones.php' id='breadcrumbs'>
                                	Configuraciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../../Configuraciones/ModificaPassword.php' id='breadcrumbs'>
                                        	Contraseñas
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
					</table>
                <?php
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
		//CUERPO FICHA ALTA
		$fecha = date("Y-m-d");
	echo "<form name='altaSolicitudQueja' method='POST' action='guardaSolicitudAdministrativa.php' enctype='multipart/form-data'>";
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
			
			echo "<tr>";
				echo "<td width='150px'>";
					echo "<input type='text' name='fecha' size='10'  value='$fecha' readonly>";
					
					echo "<input type='hidden'  name='tipo' value= 'solicitud'>";
					echo "<input type='hidden'  name='usuario' value= '$usuarioId'>";
				echo "</td>";
				
				echo "<td width='140px'>";
					if($categoriaUsr == "Administrador"){
						
						echo "<input type='text' name='grupo' style='width:25%;height:23px;' value='GE' readonly>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo " <input type='hidden' name='grupo' value='GE'>";
						
					}
				echo "</td>";
				
				echo "<td width='160px'>";
				
				echo"<select name='ciudad' required>";
						echo "<option value='' selected='selected'>Elegir...</option>";
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId' AND U.xt_codigoCiudad != 'LAR'");
								while($p = $t->fetchRow()){
									$ciudades = $p[1];
									$cdValor  = $p[0];
															  
										echo"<option value='".$cdValor."'>".$ciudades."</option>";
											
								}
				echo"</select>";
				
				/*
					if($categoriaUsr == "Administrador"){
						
						echo "<select name='ciudad' required>";
							echo "<option value='' selected='selected'>Elegir...</option>";	
							
							for($a = 1; $a <= 6; $a++){
								
								if(in_array($cdValor[$a], $ciudadesDisponibles)){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
									
								}
								
							} unset($a);
							
						echo "</select>";
						
					} else if($categoriaUsr == "Inhouse"){
						
						echo " <input type='hidden' name='ciudad' value='".$ciudadesDisponibles[1]."'>";
						
					}*/
				echo "</td>";
			echo "</tr>";
	
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><input type='text' name='titulo' size='66' required></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='3'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3'><textarea name='descripcion' style='width:438px; height:100px;' required></textarea></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
			echo "</tr>";
				
			echo "<tr>";
				echo "<td colspan='3'>";
					echo "<input type='file' name='archivo'>";
				echo "</td>";
			echo "</tr>";
				
			echo"<tr height='15px'><td colspan='3'></td></tr>";
			
			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='3'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td colspan='3'></td></tr>";
		echo "</table>";
		echo "</form>";
	echo "</div>";
/*
if($_POST['ciudad'] != ''){
	
	$fechaInsert 	= date('Y-m-d', strtotime($_POST['fecha']));
	$tituloInsert 	= $_POST['titulo'];
	$ciudad 		= $_POST['ciudad'];
	$grupoInsert	= $_POST['grupo'];
	
	$descripcionInsert = " ";
	
	if($_POST['descripcion'] != ""){
		
		$descripcionInsert = $_POST['descripcion'];
	}
	
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
							 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-B-DF-14-001
	if(($ciudad != "") && ($ciudad != "GEN")){
		
		$codigo = $grupoInsert."-B-".$ciudad."-";
		
	} else{
		
		$codigo = $grupoInsert."-B-";
		
	}
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo) 
						  							   VALUES('AV', 'B', '$ciudad', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$usuarioId', '$grupoInsert') ")){
		
		$solicitudID = $INTRANET->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_tipo = 'B' AND xt_ciudad = '$ciudad' 
										  AND xn_numero = '$maximo' AND xt_quejaSolicitud = '$codigo' AND xt_grupo = '$grupoInsert' ");
										  
		$solicitudNumero = $INTRANET->getOne("SELECT xn_numero FROM SGI_Quejas_Solicitudesv2 WHERE kp_quejaSolicitudID = $solicitudID ");
		//new MailIntraNet($usuarioId, $ciudad, $tituloInsert, $descripcionInsert, $solicitudNumero, $tipo);
	
	/*	$archivo = '';
		$archivo = $_FILES['archivo']['name'];
		//$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			
			$destino = "D:/INTRANET/documentosSolicitudes/$codigo";
			
			
			if(! file_exists($destino)){
				mkdir($destino, 0777, true);
			}
			$destino = "D:/INTRANET/documentosSolicitudes/$codigo/$archivo";
	 	  //echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
		  */
	/* 	$extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);  
		 if($extension != ''){
			
		$ruta = "D:/INTRANET/documentosSolicitudes/";
		$directorioCompleto = $ruta.$codigo;
		# si exsite la carpeta o se ha creado
        if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
        	
  			//cambio ombre de archivo
			$nombreNuevo = "Solicitud_".$codigo.".".$extension;
					
			$nombreArchivo = $directorioCompleto."/".$nombreNuevo;
			
			
			if (@move_uploaded_file($_FILES['archivo']['tmp_name'], $nombreArchivo)){
				
				//echo"UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta = '$archivo' WHERE xt_claveQuejaSolicitud = '$codigo' ";
				if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta = '$nombreArchivo' WHERE xt_quejaSolicitud = '$codigo' ") ){		
					
				}
			  }
			}
			
		 }*/
		/*	echo"<script language='javascript'>window.location='fichaSolicitudv2.php?coodigo=".urlencode($solicitudID)."'</script>;";	
	/*	} else{
					
					?>
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Solicitudes y Quejas </title>
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
							echo"<tr>"; 
								echo"<td align='center'>";
									echo $breadcrumb;
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='70'><td></td></tr>";
							
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo"</td>";
							echo"</tr>";
						echo "</table>";
					echo "</div>";
			}
		}

*/
?>
    	</body>
    </html>
<?php

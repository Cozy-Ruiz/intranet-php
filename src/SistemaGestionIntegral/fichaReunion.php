<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio García Robles
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'fichaAcuerdo.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			 <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos / </a>
			 <a href='tableroReuniones.php' id='breadcrumbs'> Tablero de Reuniones </a>";
	
//CUERPO REUNION
$id = $_GET['id'];

if($_GET['end'] == 1){
	
	$INTRANET->Execute("UPDATE SGI_Reuniones SET xt_status = 2 WHERE kp_reunionID = $id ");

}

$reunionTipoShow[1] = "Revisión por la Dirección";
$reunionTipoShow[2] = "Revisión del Comité de Calidad";
$reunionTipoShow[3] = "Revisión de Planeación Estratégica";
$reunionTipoShow[4] = "Revisión del Portafolio de Proyecto";
$reunionTipoShow[5] = "Revisión de Proyecto";
$reunionTipoShow[6] = "Revisión de TI";
$reunionTipoShow[7] = "Extraordinaria";

$reunionTipoValor[1] = "DIRECCION";
$reunionTipoValor[2] = "COMITE DE CALIDAD";
$reunionTipoValor[3] = "PLANEACION ESTRATEGICA";
$reunionTipoValor[4] = "PORTAFOLIO DE PROYECTO";
$reunionTipoValor[5] = "PROYECTO";
$reunionTipoValor[6] = "TI";
$reunionTipoValor[7] = "EXTRAORDINARIA";

$temasReunion2[1] 	= "Resultado de las auditorías";
$temasReunion2[2] 	= "Retroalimentación del cliente: Quejas";
$temasReunion2[3] 	= "Retroalimentación del cliente: Cuestionario de satisfacción del cliente";
$temasReunion2[4] 	= "Estado de acciones preventivas y correctivas";
$temasReunion2[5] 	= "Acciones de seguimiento de revisiones por la dirección previas";
$temasReunion2[6] 	= "Cambios que podrían afectar al SGI";
$temasReunion2[7] 	= "Recomendaciones para la mejora";
$temasReunion2[8] 	= "Necesidades de recursos";
$temasReunion2[9] 	= "Política Integral";
$temasReunion2[10] 	= "Objetivos de calidad";
$temasReunion2[11] 	= "Desempeño de los procesos y la conformidad del producto";
$temasReunion2[12] 	= "Planeación Estratégica";
$temasReunion2[13] 	= "Seguridad";
$temasReunion2[14] 	= "Evaluación de Proveedores";
$temasReunion2[15] 	= "Sanciones";
$temasReunion2[16] 	= "Proyecto";
$temasReunion2[17] 	= "Comunicaciones";
$temasReunion2[18] 	= "Hardware";
$temasReunion2[19] 	= "Software";
$temasReunion2[20] 	= "Bases de Datos";
$temasReunion2[21] 	= "Sistemas";
$temasReunion2[22] 	= "Ronda de Sugerencias";
$temasReunion2[23] 	= "Otros";

$s = $INTRANET->Execute("SELECT xt_claveReunion, xt_status, xd_fecha, xt_tipo, xt_ciudad, xt_grupo FROM SGI_Reuniones WHERE kp_reunionID = $id ");



while($r = $s->fetchRow()){
	
	$reunion 	= $r[0];
	$status 	= $r[1];
	$fecha 		= date('Y-m-d', strtotime($r[2]));
	$tipo 		= $r[3];
	
	if(		 $status == 1){
		
		$status = 'Programada';
		
	}else if ($status== 2){
		
		$status = 'Realizada';
		
	}else if ($status== 3){
		
		$status = 'Pospuesta';
	}
	
	for($a = 1; $a <= 7; $a++){
		
		if($reunionTipoValor[$a] == $tipo){
			
			$tipo = $reunionTipoShow[$a];
		}
		
	}
	
	$ciudadReunion = $r[4];
	
	if($ciudadReunion == ""){
		
		$ciudadReunion = "GRAL";
		
	}
	
	$grupoReunion = $r[5];
	//$diaSemana = date('w', strtotime($r[4]));	
} unset($s); unset($r);


if(($_POST['fechaAcuerdo'] != "") && ($_POST['tituloAcuerdo'] != "")){

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
	
	 $fechaAcuerdoInsert 		= date('Y-m-d', strtotime($_POST['fechaAcuerdo']));
	$tituloAcuerdoInsert 		= $_POST['tituloAcuerdo'];
	$descripcionAcuerdoInsert 	= $_POST['descripcionAcuerdo'];
	
	$anio = date('Y', strtotime($_POST['fechaAcuerdo']));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acuerdos WHERE YEAR(xd_fecha) = $anio 
							 AND xt_ciudad = '$ciudadReunion' AND xt_grupo = '$grupoReunion' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	$anio = date('y', strtotime($_POST['fechaAcuerdo']));
	
	if(strlen($maximo) == 1){
		
		$codigo = $grupoReunion."-A-".$ciudadReunion."-".$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $grupoReunion."-A-".$ciudadReunion."-".$anio."-0".$maximo;
		
	} else if(strlen($maximo) >= 3){
		
		$codigo = $grupoReunion."-A-".$ciudadReunion."-".$anio."-".$maximo;
		
	}
	 
	$personalID = $INTRANET->getOne("SELECT kp_personalId FROM SGI_Empleados WHERE kf_usuario = '$usuarioId' ");

	 $string3 = "INSERT INTO SGI_Acuerdos (xt_claveAcuerdo, xt_titulo, xd_fecha, kf_reunionID, xn_numero, kf_personalID, xt_ciudad, kf_usuarioID ,xt_grupo, xt_tipo, xd_fechaCierre) 
											 VALUES ('$codigo', '$tituloAcuerdoInsert', '$fechaAcuerdoInsert', $id, $maximo, $personalID, '$ciudadReunion', '$usuarioId','$grupoReunion', 'A', '0000-00-00 00:00:00') ";

	if($INTRANET->Execute($string3)){
	
		if($descripcionAcuerdoInsert != ""){
			
			//$acuerdoID = $INTRANET->getOne("SELECT MAX(xt_claveAcuerdo) SGI_Acuerdos");
			//$acuerdoID = mysql_insert_id();
			//echo"UPDATE SGI_Acuerdos SET xt_descripcion = '$descripcionAcuerdoInsert' WHERE xt_claveAcuerdo = '$codigo'";
			
			$INTRANET->Execute("UPDATE SGI_Acuerdos SET xt_descripcion = '$descripcionAcuerdoInsert' WHERE xt_claveAcuerdo = '$codigo' ");
			
		}

		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		if ($_FILES['archivo']["error"] > 0)
 		{
  			echo "Error: " . $_FILES['archivo']['error'] . "<br>";
  		}
		else
  		{		
			if ($archivo != ""){
				
				$destino = "AcuerdoArchivos/".$archivo;
				
				if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
					
					$string  ="UPDATE SGI_Acuerdos SET xt_ruta = '$archivo' WHERE xt_claveAcuerdo = '$codigo' ";
					if($INTRANET->Execute($string)){
						
						//header("Location: fichaReunion.php?id=$quejaID");
								
					}
				}
			}
		}

		
		
	}
	
//	header("Location: fichaReunion.php?id=$id");
	
}


$indice = 0;
$codigoAc 	= NULL;
$tituloAc 	= NULL;
$fechaAc 	= NULL;
$acuerdoID 	= NULL;
	
$s = $INTRANET->Execute("SELECT xt_claveAcuerdo, xt_titulo, xd_fecha, kp_acuerdoID, xt_status FROM SGI_Acuerdos WHERE kf_reunionID = $id ");

while($r = $s->fetchRow()){
	
	$codigoAc[$indice] 	= $r[0];
	$tituloAc[$indice] 	= $r[1];
	$fechaAc[$indice] 	= $r[2];
	$acuerdoID[$indice] = $r[3];
	$estatus[$indice] = $r[4];
	
	$indice++;
	
} unset($r); unset($s);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Ficha Reunión</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
        	<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
						document.getElementById("formularioAcuerdo").style.display="block";
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
						
					} else if (valor == 0){
						document.getElementById("formularioAcuerdo").style.display="none";
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					}
				}
			</script>
            <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet"/>
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
	
echo "<div id='wrapperFicha' align='center'>";
  	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
  	 echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
        echo "</tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs'>Fecha: ".$fecha."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Reunión";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		
		//echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
	
	/*echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
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
                            	<a href='../ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
                                	Comunicación Interna
                                </a><br />
                                
								<ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../ComunicacionInterna/TableroBoletines.php' id='breadcrumbs'>
                                        	Boletines
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../ComunicacionInterna/listaQueHacer.php' id='breadcrumbs'>
                                        	Qué hacer
                                        </a>
                                    </li>
                                   <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'>
                                        	Solicitudes
                                        </a>
                                    </li>
                                     <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroQuejas.php' id='breadcrumbs'>
                                        	Quejas
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../ComunicacionInterna/busquedaPersonal.php' id='breadcrumbs'>
                                        	Acceso Autorizado
                                        </a>
                                    </li>
                                </ul>
                            
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'>
                                	Gestión Integral
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../SistemaGestionIntegral/Normas.php' id='breadcrumbs'>
                                        	Normas
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../SistemaGestionIntegral/CapituloNorma.php?norma=ISO' id='breadcrumbs'>
                                                    ISO
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/CapituloNorma.php?norma=NMX' id='breadcrumbs'>
                                                    NMX
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC' id='breadcrumbs'>
                                                    NEEC
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../SistemaGestionIntegral/manuales.php' id='breadcrumbs'>
                                        	Manuales
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-MC' id='breadcrumbs'>
                                                	Manual de Gestión Integral
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-CDR' id='breadcrumbs'>
                                                    Manual de Control de Documentos y Registros
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-AI' id='breadcrumbs'>
                                                    Manual de Auditorías Internas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-CC' id='breadcrumbs'>
                                                    Manual del Comité de Calidad
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-DG' id='breadcrumbs'>
                                                    Manual de Dirección General
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-ADM' id='breadcrumbs'>
                                                    Manual de Administración
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-RH' id='breadcrumbs'>
                                                    Manual de Recursos Humanos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-TI' id='breadcrumbs'>
                                                    Manual de Tecnologias de la Información
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-OPE' id='breadcrumbs'>
                                                    Manual de Operaciones
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'>
                                        	Módulos del SGI
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../SistemaGestionIntegral/Riesgos.php' id='breadcrumbs'>
                                                	Administración de Riesgos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'>
                                                    Reuniones y Acuerdos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'>
                                                    Acciones Preventivas y Correctivas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/tableroAuditorias.php' id='breadcrumbs'>
                                                    Auditorías
                                                </a>
                                            </li>
                                            <!-- -->
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Procesos.php' id='breadcrumbs'>
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
                            	<a href='../Aplicaciones/aplicaciones.php' id='breadcrumbs'>
                                	Aplicaciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../Aplicaciones/operaciones.php' id='breadcrumbs'>
                                        	Operaciones
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../AdministracionProyectos/admonPro.php' id='breadcrumbs'>
                                        	Administración de Proyectos
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
								<td valign='top'>
                            	<a href='../Registros/Registros.php' id='breadcrumbs'>
                                	Registros
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                    	<a href='../Registros/TableroVisitas2.php' id='breadcrumbs'>
                                        	Visitas
                                        </a>
                                    </li>
                                     <li>
                                        <a href='../Registros/tableroRegistros.php' id='breadcrumbs'>
                                            Registros
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../Configuraciones/configuraciones.php' id='breadcrumbs'>
                                	Configuraciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../Configuraciones/ModificaPassword.php' id='breadcrumbs'>
                                        	Contraseñas
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
					</table>
                <?php*/
				
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../navegacion_banana.php");
			echo "</table>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2' colspan='2'><b>".$reunion."</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
				
		echo "<tr height='30'><td colspan='2'></td></tr>";
		
		echo "<tr id='iconosTexto'>";
			echo "<td align='left'>".$tipo."</td>";
			echo "<td align='right'>".$status."</td>";
		echo "</tr>";
		
		echo "<tr height='30'><td colspan='2'></td></tr>";
	
	echo "</table>";
	
	
	
//1. ASISTENCIA
	echo "<table border='0' align='center' width='700'>";
		echo "<tr id='titulo2'>";
			echo "<td align='left'><b>1. Asistencia</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3'></td>";
		echo "</tr>";		
	echo "</table>";
		
	echo "<table border='0' align='center' width='660px'>";
		echo "<tr height='20px'><a name='listaAsistencia'></a> </tr>";
	
		$indice = 1;
		$idPersonal 	= NULL;
		$nombreCorto 	= NULL;
			
		$s = $INTRANET->Execute("SELECT kp_personalId, xt_nombreCorto FROM SGI_Empleados EMP, SGI_EmpleadosActividad EAC, SGI_Reunion_Asistentes REA 
								WHERE EAC.xt_actividad = 'REUNION' AND EMP.kp_personalId = EAC.kf_personalID AND EMP.kp_personalId = REA.kf_personalID AND REA.kf_reunionID = $id 
								ORDER BY EMP.xt_Nombre ");
			
			
		
		while($r = $s->fetchRow()){
			
			$idPersonal[$indice] 	= $r[0];
			$nombreCorto[$indice] 	= trim($r[1]);
			
			$indice++;
			
		} unset($r); unset($s); unset($indice);
		
		$cuenta = count($idPersonal);
		
		$filas = ceil($cuenta/4);
		$celdas = 0;
	
		if((($cuenta%4)/4) == 0.25){
			$celdas = 1;
			
		} else if((($cuenta%4)/4) == 0.5){
			$celdas = 2;
			
		} else if((($cuenta%4)/4) == 0.75){
			$celdas = 3;
			
		} else if(($cuenta%4) == 0){
			$celdas = 4;
			
		}
		
		$i = 1;
		
		for($a = 1; $a <= $filas; $a++){
			
			echo "<tr>";
			
			for($e = 1; $e <= 4; $e++){
				
					echo "<td width='165px' id='fileItem'>".$nombreCorto[$i]."</td>";
				
				$i++;
				
				if($i > $cuenta){
					break;
				}
				
			}
			
			if(($filas == $a) && ($celdas == $e)){
				
				if($celdas == 1){
					echo "<td width='165px'></td>";
					echo "<td width='165px'></td>";
					echo "<td width='165px'></td>";
					
				} else if($celdas == 2){
					echo "<td width='165px'></td>";
					echo "<td width='165px'></td>";
					
				} else if($celdas == 3){
					echo "<td width='165px'></td>";
					
				}
				
				break;
			}
			
			echo "</tr>";
			
		}
	
	echo "</table>";
				
	
	//ELEMENTOS
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='50px'><td colspan='4'></td></tr>";

		echo "<tr>";
			echo "<td id='titulo2' colspan='4'><b> 2. Temas a tratar</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='4'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td colspan='4'></td></tr>";
		
		//echo"SELECT xt_subElemento, xt_texto FROM SGI_Elemento_Reunion WHERE kf_reunionID = $id AND xn_numElemento = 2 ORDER BY xt_subElemento";
		$s = $INTRANET->Execute("SELECT xt_subElemento, xt_texto FROM SGI_Elemento_Reunion WHERE kf_reunionID = $id AND xn_numElemento = 2 ORDER BY xt_subElemento ");	
			
		while($r = $s->fetchRow()){
			
			$subElemento 		= $r[0];
			$textoSubElemento 	= nl2br($r[1]);
		
			echo "<tr>";
				echo "<td></td>";
				
				echo "<td id='iconosTexto' colspan='2'>";
					echo "<a name='2_".$subElemento."' id='iconosTexto'>";
						echo "<b>".$temasReunion2[$subElemento]."</b>";
					echo "</a>";
				echo "</td>";
				
				echo "<td></td>";
			echo "</tr>";
			
		//	echo"SELECT xt_ruta FROM SGI_Reunion_Archivos WHERE kf_reunionID = $id AND kf_numeroElemento = 2 AND kf_subElemento = $subElemento<br>";
			$u = $INTRANET->Execute("SELECT xt_ruta FROM SGI_Reunion_Archivos WHERE kf_reunionID = $id AND kf_numeroElemento = 2 AND kf_subElemento = $subElemento ");
			
			
			
			while($t = $u->fetchRow()){
				
				echo "<tr>";
					echo "<td colspan='2'></td>";
					
					echo "<td id='textIntro' colspan='2'>";
						echo "<i>".$t[0]."</i> ";
						echo "<a href='downloadReunion.php?file=".$t[0]."' >";
							echo "<img src='../Imagenes/ICN_Archivo.png'>";
						echo "</a>";
					echo "</td>";
					
				echo "</tr>";
				
			} unset($t);
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";
		
			echo "<tr>"; 
				echo "<td width='20px'></td>"; 
				echo "<td width='15px' align='right'></td>"; 
				echo "<td width='615px' align='justify' id='fileItem'>".$textoSubElemento."</td>"; 
				echo "<td width='50px'></td>"; 
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			
		} unset($u); unset($r); unset($s);
		
	echo "</table>";
	
	$valor = "";
	
	//	echo"SELECT xt_texto FROM SGI_Elemento_Reunion WHERE kf_reunionID = $id AND xn_numElemento = 3 AND xt_subElemento = 1";
	//$valor = $INTRANET->getOne("SELECT xt_texto FROM SGI_Elemento_Reunion WHERE kf_reunionID = $id AND xn_numElemento = 3 AND xt_subElemento = 1 ");
	
	//if($valor != ""){
		//3 Resultados de la revision
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr height='50px'><td colspan='3'></td></tr>";
	
			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b>3. Resultados de la revisión</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
		echo "<tr height='20px'><td colspan='4'></td></tr>";
		
		//echo"SELECT xt_subElemento, xt_texto FROM SGI_Elemento_Reunion WHERE kf_reunionID = $id AND xn_numElemento = 2 ORDER BY xt_subElemento";
		$s = $INTRANET->Execute("SELECT xt_subElemento, xt_texto FROM SGI_Elemento_Reunion WHERE kf_reunionID = $id AND xn_numElemento = 3 AND xt_subElemento = 1  ");		
			
		while($r = $s->fetchRow()){
			
			$subElemento 		= $r[0];
			$textoSubElemento 	= nl2br($r[1]);
			
		//	echo"SELECT xt_ruta FROM SGI_Reunion_Archivos WHERE kf_reunionID = $id AND kf_numeroElemento = 2 AND kf_subElemento = $subElemento<br>";
			$u = $INTRANET->Execute("SELECT xt_ruta FROM SGI_Reunion_Archivos WHERE kf_reunionID = $id AND kf_numeroElemento = 3 AND kf_subElemento = $subElemento ");
			
			while($t = $u->fetchRow()){
				
				echo "<tr>";
					echo "<td colspan='2'></td>";
					
					echo "<td id='textIntro' colspan='2'>";
						echo "<i>".$t[0]."</i> ";
						echo "<a href='downloadReunion.php?file=".$t[0]."' >";
							echo "<img src='../Imagenes/ICN_Archivo.png'>";
						echo "</a>";
					echo "</td>";
					
				echo "</tr>";
				
			} unset($t);
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";
		
			echo "<tr>"; 
				echo "<td width='20px'></td>"; 
				echo "<td width='15px' align='right'></td>"; 
				echo "<td width='615px' align='justify' id='fileItem'>".$textoSubElemento."</td>"; 
				echo "<td width='50px'></td>"; 
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			
		} unset($u); unset($r); unset($s);
			
		
		/*	echo "<tr height='20'><td colspan='3'></td></tr>";
		
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='iconosTexto' colspan='2'>";
					echo "<a name='3_1' id='iconosTexto'></a>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td width='20'></td>";
				echo "<td width='15px' align='right'></td>";
				echo "<td id='fileItem' align='justify'>".nl2br($valor)."</td>";
			echo "</tr>";

		//	echo "<tr height='50'><td colspan='3'></td></tr>";
	echo "</table>";*/
//	}
	
	//ACUERDOS
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b>4. Acuerdos </b></td>";
			
			echo "<td align='right'>";
			
				if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'cozy') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Ricardo_Garcia') || ($usuarioId == 'sdelap')|| ($usuarioId == 'Elena_Hernandez')){
					
					echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block;'>";
					echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(0);' id='ocultar' style='display:none;'>";
					
				}
				
			echo "</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
				
		echo "<tr height='20'><td colspan='2'></td></tr>";
	echo "</table>";
	
	if(count($codigoAc) >= 1){	
		

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='right' width='15px'></td>";
				echo "<td align='center'  id='iconosTexto2'>Código</td>";
				echo "<td align='left' id='iconosTexto2'>Titulo</td>";
				echo "<td align='left' id='iconosTexto2'>Estatus</td>";
				echo "<td align='center' id='iconosTexto2'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspna='3'></td></tr>";
				
			for($a = 0; $a <= count($codigoAc); $a++){
				
				echo "<tr>";
					echo "<td align='right' width='15px'></td>";
					echo "<td width='110px' align='center' valign='top'>";
						echo "<a href='fichaAcuerdo.php?acuerdo=".$acuerdoID[$a]."' id='fileItem' style='text-decoration:none;'>".$codigoAc[$a]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='300px' id='fileItem' valign='top'>".$tituloAc[$a]."</td>";
					echo "<td align='left' width='120px' id='fileItem' valign='top'>".$estatus[$a]."</td>";
					echo "<td align='center' width='120px' id='fileItem' valign='top'>".$fechaAc[$a]."</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
					
			} unset($a);
		
		echo "</table>";
	}
	
echo "<form method='post' action='fichaReunion.php?id=".$id."' enctype='multipart/form-data'>";
echo '<table border="0" align="center" width="500px" id="formularioAcuerdo" style="display:none;">
		<tbody>
			<tr>
				<td id="titleBlueLineTop" colspan="3"></td>
			</tr>
			<tr height="15px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2 align="left">Fecha</td>
				<td id="iconosTexto2 align="left">Grupo</td>
				<td id="iconosTexto2 align="left">Ciudad</td>
			</tr>
			<tr>
				<td width="150px">
					<input id="dp1435765604156" class="DatP" name="fechaAcuerdo" size="10" type="text">
					<input name="tipo" value="solicitud" type="hidden">
				</td>
				<td width="140px">
						<input type="text" value="'.$grupoReunion.'" name="grupoAcuerdo" disabled>
				</td>
				<td width="160px">
					<input type="text" value="'.$ciudadReunion.'" name="ciudadAcuerdo" disabled>
				</td>
			</tr>
			<tr height="20px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2 align="left" colspan="3">Título</td>
			</tr>
			<tr>
				<td colspan="3">
					<input name="tituloAcuerdo" size="66" type="text">
				</td>
			</tr>
			<tr height="20">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2 align="left" colspan="3">Descripción</td>
			</tr>
			<tr>
				<td colspan="3">
					<textarea name="descripcionAcuerdo" style="width:438px; height:100px;"></textarea>
				</td>
			</tr>
			<tr height="20px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2" colspan="3" align="left">Seleccione un archivo:</td>
			</tr>
			<tr>
				<td colspan="3">
					<input name="archivo" type="file">
				</td>
			</tr>
			<tr height="15px">
				<td colspan="3"></td>
			</tr>
			<tr height="40px">
				<td colspan="3" align="right" valign="bottom">
					<input src="../Imagenes/ICN_BotonEnviar.png" type="submit" value= "Agregar" width="90" height="29" name="archivo">
				</td>
			</tr>
			<tr height="10px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="titleBlueLineBottom" colspan="3"></td>
			</tr>
			<tr height="30px">
				<td colspan="3"></td>
			</tr>
		</tbody>
	</table>
</form>';

echo "<table border='0' align='center' width='700px'>";	
///LINEA FINAL
		echo "<tr height='30px'></tr>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
		/*echo "<tr>";
			echo "<td align='right'>";
				echo "<a href='fichaSolicitudModificacion.php?id=$solicitudID' >
					  <img src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";
		echo "</tr>";*/
	
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
		/*echo "<table border='0' align='center' width='500px' id='formularioAcuerdo' style='display:none;'>";
			echo "<tr><td id='titleBlueLineBottom' width='500px'></td></tr>";
			
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='left'><input type='text' class='DatP' name='fechaAcuerdo' size='10'></td>";
			echo "</tr>";
	
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='left'>";
					echo "<input type='text' name='tituloAcuerdo' size='67'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='left'>";
					echo "<textarea name='descripcionAcuerdo' style='width:447px; height:100px;'></textarea>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td></td></tr>";
		echo "</table>";
	echo "</form>";

	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='50px'><td></td></tr>";
	echo "</table>";*/
	echo "</form>";
echo "</div>";

?>
    	</body>
    </html>
<?php

<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha del Carmen Abam Donoso
 *@author García Robles Octavio Francisco
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'FichaAuditoria.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require_once("../ConexionIntranet2.php");

 error_reporting(E_PARSE);

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


$id 		= $_GET['id'];
$terminar 	= $_GET['end'];

if($terminar == 1){
	
	$INTRANET->Execute("UPDATE SGI_Auditorias SET xt_status = 2 WHERE kp_auditoriaID = $id ");
	
	header("Location: FichaAuditoria.php?id=$id");
	
}

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroAuditorias.php' id='breadcrumbs'> Auditorías </a>";

$s = $INTRANET->Execute("SELECT xt_claveAuditoria,xt_titulo,xd_fecha FROM SGI_Auditorias WHERE kp_auditoriaID = $id AND xt_status = 2 ");

while($r = $s->fetchRow()){

	$codigo				= $r[0];
	$tituloAuditoria	= $r[1];
	$fechaAuditoria		= $r[2];
	
}unset($r); unset($s);


if($codigo != ""){
	
	$rutaP 		= $INTRANET->getOne("SELECT xt_ruta FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
	
	$programa 	= $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
	
	$rutaI 		= $INTRANET->getOne("SELECT xt_ruta FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");
	
	$informe 	= $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");
	
	$indice 		= 1;
	$issueID 		= NULL;
	$tituloIssue 	= NULL;
	$fechaIssue 	= NULL;
	$ruta 			= NULL;
	$claveIssue 	= NULL;
	
	//echo "SELECT kp_issueID, xt_titulo, xd_fecha, xt_ruta, xt_claveIssue FROM SGI_Auditorias_Issues WHERE kf_auditoriaID = $id ORDER BY xd_fecha DESC ";
	//echo "<br>";
	
	//echo"SELECT kp_issueID, xt_titulo, xd_fecha, xt_ruta, xt_claveIssue FROM SGI_Auditorias_Issues WHERE kf_auditoriaID = $id ORDER BY xd_fecha DESC <br><br>";
	
	$s = $INTRANET->Execute("SELECT kp_issueID, xt_titulo, xd_fecha, xt_ruta, xt_claveIssue FROM SGI_Auditorias_Issues WHERE kf_auditoriaID = $id ORDER BY xd_fecha DESC ");
	
	
	while($r = $s->fetchRow()){
		
		$issueID[$indice] 		   = $r[0];
		$tituloIssue[$indice] 	   = $r[1];
		$fechaIssue[$indice] 	   = date('Y-m-d',  strtotime($r[2]));
		$ruta[$indice] 			   = $r[3];
		$claveIssue[$indice] 	   = $r[4];		
		
	//	echo"SELECT xt_codigo FROM SGI_Auditorias_Issues_Tratamientos WHERE kf_issueID = $r[0]<br><br>";
		 $codigoCorrectiva[$indice] = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Auditorias_Issues_Tratamientos WHERE kf_issueID = $r[0]");
	
		
		//$c[$indice] = $INTRANET->getOne("SELECT kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoCorrectiva[$indice]'");
		//echo "SELECT kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoCorrectiva[$indice]'";
		//echo "<br>";
	    //$d = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $c[$indice] AND xt_tipoOrigen = 'E'");
		
		//echo "<br>";
		//echo "SELECT MAX(xn_etapa), xt_titulo FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $d";
		//echo "<br>";
		/*echo "SELECT xn_etapa, xt_titulo FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $d AND xn_etapa = (
									SELECT MAX(xn_etapa) FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $d)";*/
		if($codigoCorrectiva[$indice] != ''){
			//$u = $INTRANET->Execute("SELECT xn_etapa, xt_titulo FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $d AND xn_etapa = (
									//SELECT MAX(xn_etapa) FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $d)");
			
			
			$u = $INTRANETV2->Execute("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$codigoCorrectiva[$indice]'");
			if($u->recordCount() >0){
				while($t = $u->fetchRow()){
				 if($t[0] == 'ASIGNAR'){$estatus[$indice] = 'Asignada';}
				 else if($t[0] == 'ANALISIS'){$estatus[$indice] = 'Analisis de la causa raíz';}
				 else if($t[0] == 'DECISION'){$estatus[$indice] = 'Decisión';}
				 else if($t[0] == 'SOLICITUD'){$estatus[$indice] = 'Plan de acción';}
				 else if($t[0] == 'EVALUACION'){$estatus[$indice] = 'Terminada';}
				}
			}else{
				$estatus[$indice] = " ";
			}
		}else{
			$estatus[$indice] = " ";
		}
		$indice++;
		
	} unset($r); unset($s);

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
				<title>Auditoría</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
				?> 
                
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
						document.getElementById("causaRaiz1").style.display="none";
						document.getElementById("causaRaiz0").style.display="block";
						document.getElementById("causaRaizPdf").style.display="block";
					} else if (valor == 0){
						document.getElementById("causaRaiz1").style.display="block";
						document.getElementById("causaRaiz0").style.display="none";
						document.getElementById("causaRaizPdf").style.display="none";
					}
				}
			</script> 
            
			</head>
			<body>
	<?php

echo "<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center'>";
        echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
        echo "</tr>";
		echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Fecha: ".$fechaAuditoria."</td>";
        echo "</tr>";		
			echo "<tr height='80px'><td></td></tr>";
		///Titulo 
			echo "<tr>";
				echo "<td align='center' id='titulo1' width='700px'>";
					echo $tituloAuditoria;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='center' id='titulo1' width='700px'>";
					echo $codigo;
				echo "</td>";
			echo "</tr>";
			
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
				
			//echo "<tr height='50px'><td></td></tr>";
		echo "</table>";
		
	/*	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
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
		
		echo "<table border='0' align='center' width='900px'>";	
			echo "<tr height='50px'><td colspan='4'></td></tr>";
	
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b>Plan de auditoría</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
		
		echo "</table>"; 
		
		echo "<table border='0' align='center' width='900px'>";
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";				
				echo "<td colspan='2' id='textIntro'>";
				
					if($rutaP != ""){
						
						echo "<i>".$rutaP."</i> <a href='downloadAuditoria.php?file=".$rutaP."' ><img src='../Imagenes/ICN_Archivo.png'></a>";
						/*
						if(substr($rutaP, -4) == ".pdf"){
							
							echo "<br><br><object type='application/pdf' data='$rutaP#toolbar=1&amp;navpanes=0&amp;scrollbar=1' style='width: 800px; height: 700px;'>
								<param name='src' value='$rutaP#toolbar=1&amp;navpanes=0&amp;scrollbar=1'/>
							  	<p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
							  	No obstante puede descargar el archivo en este <a href='downloadAuditoria.php?file=$rutaP'>enlance</a>
							  	</p></object><br><br>";
						
						}*/
									
					}
					
				echo "</td>";
			echo "</tr>";
		
		echo "</table>"; 
		
		echo "<table border='0' align='center' width='900px'>";	
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";
			
			echo "<tr id='fileItem'>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";				
				echo "<td width='650px' align='justify'>".$programa."</td>";
				
				echo "<td width='10px'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
		echo "</table>";
		
		//Informe de la auditoria
		echo "<table border='0' align='center' width='900px'>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b>Informe de la auditoría</b></td>";
				
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";				
				echo "<td colspan='2' id='textIntro'>";
				
				if($rutaI != ""){
					
					echo "<i>".$rutaI."</i> <a href='downloadAuditoria.php?file=".$rutaI."' ><img src='../Imagenes/ICN_Archivo.png'></a>";
					/*
					if(substr($rutaI, -4) == ".pdf"){
							
							echo "<br><br><object type='application/pdf' data='$rutaI#toolbar=1&amp;navpanes=0&amp;scrollbar=1' style='width: 800px; height: 700px;'>
								  <param name='src' value='$rutaI#toolbar=1&amp;navpanes=0&amp;scrollbar=1'/>
								  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
								  No obstante puede descargar el archivo en este <a href='downloadAuditoria.php?file=$rutaI'>enlance</a>
								  </p></object><br><br>";
						
						}*/
				}
				
				echo "</td>";
			echo "</tr>";

			echo "<tr height='10px'><td colspan='4'></td></tr>";
			
			echo "<tr id='fileItem'>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				
				echo "<td width='650px' align='justify'>".$informe."</td>";
				
				echo "<td width='10px' align='right'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";		
		echo "</table>";
		
	///HALLAZGOS
		echo "<table border='0' align='center' width='900px'>";	
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>Hallazgos</b></td>";
				
				echo "<td align='right'>";
					echo "<a href='AgregaIssue.php?id=".$id."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\">";
						echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
					echo "</a>";
				echo "</td>";	
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='30'><td colspan='2'></td></tr>";
		echo "</table>";
		
		if(count($issueID) >= 1){
					
			echo "<table border='0' align='center'>";
				echo "<tr id='iconosTexto2'>";
					//echo "<td align='center' width='120px'>Código</td>";
					echo "<td align='left' width='600px'>Titulo</td>";
					echo "<td align='center' width='200px'>Correctiva</td>";
					echo "<td align='center' width='200px'>Estatus</td>";
					echo "<td align='center' width='80px'>Fecha</td>";
					echo "<td align='center' width='20px'></td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='4'></td></tr>";
					
				for($a = 1; $a <= count($issueID); $a++){
					
					echo "<tr>";
						/*
						echo "<td align='center' id='fileItem'>";
							echo "<a href='fichaIssue.php?id=".$issueID[$a]."' id='fileItem' style='text-decoration:none;'>".$claveIssue[$a]."</a>";
						echo "</td>";
						*/
						
						echo "<td align='left' id='fileItem'><a href='fichaIssue.php?id=".$issueID[$a]."' id='fileItem' style='text-decoration:none;'>".$tituloIssue[$a]."</td>";
						echo "<td align='center' id='fileItem'><a href='./Intranetv2/fichaCorrectivav2.php?id=".$codigoCorrectiva[$a]."' id='fileItem' style='text-decoration:none;'>".$codigoCorrectiva[$a]."</td>";
						echo "<td align='center' id='fileItem'>".$estatus[$a]."</td>";
						echo "<td align='center' id='fileItem'>".$fechaIssue[$a]."</td>";
						
						echo "<td align='right'>";
						
							if($ruta[$a] != ""){
								
								echo "<a href='downloadAuditoria.php?file=".$ruta[$a]."'><img src='../Imagenes/ICN_Archivo.png'></a>";
								
							}
						
						echo "</td>";
						
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='3'></td></tr>";
						
				}
			
			echo "</table>";
		}
	
	//FINALIZAR
		echo "<table border='0' align='center' width='900px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<a href='FichaAuditoriaModificar.php?id=$id'><input type='image' src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='50px'><td></td></tr>";
		echo "</table>";
echo "</div>";
	
} else{
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
				<title>Auditoría</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
				?> 
			</head>
			<body>
	<?php

	echo "<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center'>";		
			echo "<tr height='150px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "Error!!!";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
}

?>
    	</body>
    </html>
<?php

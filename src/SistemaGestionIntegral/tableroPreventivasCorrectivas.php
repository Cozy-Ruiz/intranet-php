<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio F. García Robles
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'tableroPreventivasCorrectivas.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
error_reporting(E_PARSE);


$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral /</a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <title>Tablero de Acciones Preventivas y Correctivas</title>
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
                  
        </head>
		<body>
<?php

echo "<div id='wrapperFichaCorrectivasPreventivas' align='center'>";
	echo "<table border='0' align='center' width='1000px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Tablero de Acciones <br> Preventivas y Correctivas";
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
		echo"<tr height='60'><td></td></tr>";
	echo "</table>"; 


	///ACCIONES PREVENTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center'>";
				echo "<a href='altaPreventivaCorrectivaPopUp.php'>";
					echo "<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'>";
				echo "</a>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='70px'><td></td></tr>";
		echo"</table>";
		
		
		echo"<br><br><form action='tableroPreventivasCorrectivas.php'  method='POST'>";
							echo "<table border='0' align='center'>";
								echo "<tr>";
									echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";
										echo"<b>Filtra Status:</b>";
									echo"</td>";
								echo"<tr>";
										echo"<td align='center'>";							
										//Consulta para mostrar N° de Cliente, nombre y rfc de los Clientes
										
										//$s = $INTRANET->Execute("SELECT DISTINCT xt_titulo FROM IntranetGEA.SGI_Seguimiento_Etapas WHERE xt_titulo in('ASIGNAR','ANALISIS','DECISION','SOLICITUD','EVALUACION')");
										echo "<select name='etapaActual'>";
											echo "<option value='' SELECTED>";
											//while($r = $s->fetchRow()){
											 
											 //$etapaSeleccion = $r[0];	
											
											//	if($etapaSeleccion == "ASIGNAR"){
												echo "<option value='ASIGNAR'>Asignada</option>";
												//}else if($etapaSeleccion == "ANALISIS"){
												echo "<option value='ANALISIS'>Análisis de causa raíz</option>";
												//}else if($etapaSeleccion == "DECISION"){
												echo "<option value='DECISION'>Decisión</option>";
												//}else if($etapaSeleccion == "SOLICITUD"){
												echo "<option value='SOLICITUD'>Plan de acción</option>";
												//}else if($etapaSeleccion == "EVALUACION"){
												echo "<option value='EVALUACION'>Evaluación de la eficacia: Eficaz</option>";
												//}
											//}
										echo"</select>";
										echo"</td>";
									echo"</tr>";
									echo"<tr height='8'></tr>";
									echo "<tr>";
									echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";
										echo"<b>Ciudad:</b>";
									echo"</td>";
								echo"<tr>";
										echo"<td align='center'>";							
										//Consulta para mostrar N° de Cliente, nombre y rfc de los Clientes
										
										$s = $INTRANET->Execute("SELECT DISTINCT xt_ciudad FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas");
										echo "<select name='ciudad'>";
											echo "<option value='' SELECTED>";
											while($r = $s->fetchRow()){
											 
											 $ciudad = $r[0];	
											
												echo "<option value='".$ciudad."'>$ciudad</option>";
												
											}
											echo "<option value='TODOS'>TODOS</option>";
										echo"</select>";
										echo"</td>";
									echo"</tr>";
									echo"<tr height='8'></tr>";
									echo"<tr>";
										echo"<td align='center' style='min-width: 160px; max-width: 160px;'>";
											echo"<br><input type='submit' value='Buscar'>";
										echo"</td>";
									echo"</tr>";
									echo "<tr height='10px'><td></td></tr>";
						echo"</table><br><br><br>";
					echo"</form>";
											
	if($_POST['etapaActual'] == '' && $_POST['ciudad'] == ''){
		
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";

	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		
		$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'D'  ORDER BY xt_claveAccion DESC ");
								
		while($r = $s->fetchRow()){
			
			$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[1];
			$tituloPreventiva 	= $r[2];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa              = "";
			
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				//echo"SELECT SGE.xt_titulo, SGE.xd_fecha, SGE.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
					//					 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID";
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID ");
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}
			
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventiva.php?id=".$preventivaID."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
	///CABECERA
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170px'>PDR</td>";
			//echo "<td width='20px' align='center'></td>";
		echo "</tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
		
		$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E' ORDER BY xt_claveAccion DESC ");
								
		while($r = $s->fetchRow($s)){
			
			$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[1];
			$tituloCorrectiva 	= $r[2];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa				= "";
				
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha,SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										WHERE SGU.kf_itemOrigenID = $correctivaID AND SGU.xt_tipoOrigen = 'E' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID 
										ORDER BY xn_etapa ");
				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			
			}
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectiva.php?id=$correctivaID' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				if($etapa != ''){
					echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				}else{
					echo "<td width='170px' align='left' valign='top'></td>";
				}
				
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
	
	
	}else if($_POST['etapaActual'] == '' && $_POST['ciudad'] != 'TODOS'){
		$ciudadBuscar =  $_POST['ciudad'];
		
		echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";

	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
	
		//echo"SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
			//					WHERE xt_tipo = 'D' AND xt_ciudad = '$ciudadBuscar' ORDER BY xd_fecha DESC";
								
		$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'D' AND xt_ciudad = '$ciudadBuscar' ORDER BY xd_fecha DESC ");
								
		while($r = $s->fetchRow()){
			
			$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[1];
			$tituloPreventiva 	= $r[2];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa              = "";
			
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				//echo"SELECT SGE.xt_titulo, SGE.xd_fecha, SGE.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
					//					 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID";
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID ");
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}
			
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventiva.php?id=".$preventivaID."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
	///CABECERA
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170px'>PDR</td>";
			//echo "<td width='20px' align='center'></td>";
		echo "</tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
		
		$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E' AND xt_ciudad = '$ciudadBuscar' ORDER BY xt_claveAccion DESC ");
								
		while($r = $s->fetchRow($s)){
			
			$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[1];
			$tituloCorrectiva 	= $r[2];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa				= "";
				
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha,SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										WHERE SGU.kf_itemOrigenID = $correctivaID AND SGU.xt_tipoOrigen = 'E' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID 
										ORDER BY xn_etapa ");
				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}

			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectiva.php?id=$correctivaID' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
		
		
	}else if($_POST['etapaActual'] != '' && $_POST['ciudad'] != 'TODOS'){
		
		$BuscaTitulo = $_POST['etapaActual'];
		$ciudadBuscar= $_POST['ciudad'];
		
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";
	
		echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	
		if($BuscaTitulo == 'ASIGNAR'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
		SA.kp_accionesID, 
		SA.xt_claveAccion, 
		SA.xt_titulo, 
		SA.xd_fecha, 
		SA.xn_status 
		FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
		IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
		WHERE SA.xt_tipo = 'D' 
		AND SA.kp_accionesID = SE.kf_itemOrigenID 
		AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
		AND SGE.xt_titulo = '$BuscaTitulo'
		AND SA.xt_ciudad = '$ciudadBuscar' 
		AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
		IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('ANALISIS','DECISION','SOLICITUD','EVALUACION'))
		ORDER BY SA.xt_claveAccion DESC");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('DECISION','SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'DECISION'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'EVALUACION'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo' 
			ORDER BY SA.xt_claveAccion DESC ");
		}
		while($r = $s->fetchRow()){
			
			$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[1];
			$tituloPreventiva 	= $r[2];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa              = "";
			
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID ");
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}
			
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventiva.php?id=".$preventivaID."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	
			if($BuscaTitulo == 'ASIGNAR'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
		SA.kp_accionesID, 
		SA.xt_claveAccion, 
		SA.xt_titulo, 
		SA.xd_fecha, 
		SA.xn_status 
		FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
		IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
		WHERE SA.xt_tipo = 'E' 
		AND SA.kp_accionesID = SE.kf_itemOrigenID 
		AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
		AND SGE.xt_titulo = '$BuscaTitulo'
		AND SA.xt_ciudad = '$ciudadBuscar'  
		AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
		IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('ANALISIS','DECISION','SOLICITUD','EVALUACION'))
		ORDER BY SA.xt_claveAccion DESC");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('DECISION','SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'DECISION'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'EVALUACION'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			AND SA.xt_ciudad = '$ciudadBuscar'  
			ORDER BY SA.xt_claveAccion DESC ");
		}												
		/*$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E' AND xn_numero = $etapaBuscar ORDER BY xt_claveAccion DESC ");
		*/						
		while($r = $s->fetchRow($s)){
			
			$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[1];
			$tituloCorrectiva 	= $r[2];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa				= "";
				
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										WHERE SGU.kf_itemOrigenID = $correctivaID AND SGU.xt_tipoOrigen = 'E' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID 
										ORDER BY xn_etapa ");
				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}

			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectiva.php?id=$correctivaID' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
	
	
	}else if($_POST['etapaActual'] != '' && $_POST['ciudad'] == 'TODOS'){
		
		$BuscaTitulo = $_POST['etapaActual'];
		
		
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";
	
		echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	
		if($BuscaTitulo == 'ASIGNAR'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
		SA.kp_accionesID, 
		SA.xt_claveAccion, 
		SA.xt_titulo, 
		SA.xd_fecha, 
		SA.xn_status 
		FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
		IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
		WHERE SA.xt_tipo = 'D' 
		AND SA.kp_accionesID = SE.kf_itemOrigenID 
		AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
		AND SGE.xt_titulo = '$BuscaTitulo' 
		AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
		IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('ANALISIS','DECISION','SOLICITUD','EVALUACION'))
		ORDER BY SA.xt_claveAccion DESC");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('DECISION','SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'DECISION'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo' 
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
			
		else if($BuscaTitulo == 'EVALUACION'){
			
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'D' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo' 
			ORDER BY SA.xt_claveAccion DESC ");
		}
		while($r = $s->fetchRow()){
			
			$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[1];
			$tituloPreventiva 	= $r[2];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa              = "";
			
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID ");
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}
			
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventiva.php?id=".$preventivaID."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	
			if($BuscaTitulo == 'ASIGNAR'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
		SA.kp_accionesID, 
		SA.xt_claveAccion, 
		SA.xt_titulo, 
		SA.xd_fecha, 
		SA.xn_status 
		FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
		IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
		WHERE SA.xt_tipo = 'E' 
		AND SA.kp_accionesID = SE.kf_itemOrigenID 
		AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
		AND SGE.xt_titulo = '$BuscaTitulo' 
		AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
		IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('ANALISIS','DECISION','SOLICITUD','EVALUACION'))
		ORDER BY SA.xt_claveAccion DESC");
		}
		else if($BuscaTitulo == 'ANALISIS'){
		$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('DECISION','SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'DECISION'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('SOLICITUD','EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'SOLICITUD'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'  
			AND SE.kp_seguimientoID not in(SELECT SGEE.kf_seguimientoID FROM 
			IntranetGEA.SGI_Seguimiento_Etapas SGEE WHERE SGEE.xt_titulo in('EVALUACION'))
			ORDER BY SA.xt_claveAccion DESC ");
		}
		else if($BuscaTitulo == 'EVALUACION'){
			$s = $INTRANET->Execute("SELECT DISTINCT 
			SA.kp_accionesID, 
			SA.xt_claveAccion, 
			SA.xt_titulo, 
			SA.xd_fecha, 
			SA.xn_status 
			FROM IntranetGEA.SGI_Acciones_Preventivas_Correctivas SA, 
			IntranetGEA.SGI_Seguimiento_Etapas SGE, IntranetGEA.SGI_Seguimientos SE 
			WHERE SA.xt_tipo = 'E' 
			AND SA.kp_accionesID = SE.kf_itemOrigenID 
			AND SE.kp_seguimientoID = SGE.kf_seguimientoID 
			AND SGE.xt_titulo = '$BuscaTitulo'
			ORDER BY SA.xt_claveAccion DESC ");
		}												
		/*$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E' AND xn_numero = $etapaBuscar ORDER BY xt_claveAccion DESC ");
		*/						
		while($r = $s->fetchRow($s)){
			
			$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[1];
			$tituloCorrectiva 	= $r[2];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa				= "";
				
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										WHERE SGU.kf_itemOrigenID = $correctivaID AND SGU.xt_tipoOrigen = 'E' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID 
										ORDER BY xn_etapa ");
				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}

			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectiva.php?id=$correctivaID' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
		
	}else if($_POST['etapaActual'] == '' && $_POST['ciudad'] == 'TODOS'){
		
		$ciudadBuscar =  $_POST['ciudad'];
		
		echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Preventivas</td>";
		echo "</tr>";
	echo "</table>";

	echo "<table border='0' align='center'  width='1020px'>";
	///CABECERA		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170x'>PDR</td>";
		echo "</tr>";

		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
	
								
		$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'D' ORDER BY xd_fecha DESC ");
								
		while($r = $s->fetchRow()){
			
			$preventivaID 		= $r[0];
			$clavePreventiva 	= $r[1];
			$tituloPreventiva 	= $r[2];
			$fechaPreventiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa              = "";
			
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $preventivaID AND xt_tipoOrigen = 'D' ")){
				
				//echo"SELECT SGE.xt_titulo, SGE.xd_fecha, SGE.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
					//					 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID";
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha, SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										 WHERE SGU.kf_itemOrigenID = $preventivaID AND SGU.xt_tipoOrigen = 'D' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID ");
				
				while($t = $u->fetchRow()){
					
					$etapa 				= $t[0];
					$fechaPreventiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}
			
			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA ACCION PREVENTIVA		
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaPreventiva.php?id=".$preventivaID."' id='fileItem' style='text-decoration:none;'>".$clavePreventiva."</a>";
				echo "</td>";
			///TITULO ACCION PREVENTIVA
				echo "<td width='380px' align='left' valign='top'>".$tituloPreventiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaPreventiva."</td>";
				
				echo "<td width='10px' valign='top'></td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'></td></tr>";
			
		} unset($r); unset($s);
		
		echo "<tr height='5px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	///LINEA
	echo "<table border='0' align='center'>";		
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
	
	//ACCIONES CORRECTIVAS
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo2'>Acciones Correctivas</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
	///CABECERA
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='left' width='380px'>Título</td>";
			echo "<td align='center' width='80px'>Fecha</td>";
			echo "<td width='10px'></td>";
			echo "<td align='left' width='150px'>Status</td>";
			echo "<td width='10px'></td>";
			echo "<td align='center' width='170px'>PDR</td>";
			//echo "<td width='20px' align='center'></td>";
		echo "</tr>";
		
	echo "</table>";
	
	echo "<table border='0' align='center'  width='1000px'>";
		echo "<tr>";
			echo "<td colspan='6' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
	echo "</table>";
	
	echo "<table align='center' border='0' width='1000px'>";
		echo "<tr height='10px'><td colspan='6'></td></tr>";
		
		$s = $INTRANET->Execute("SELECT kp_accionesID, xt_claveAccion, xt_titulo, xd_fecha, xn_status FROM SGI_Acciones_Preventivas_Correctivas 
								WHERE xt_tipo = 'E'  ORDER BY xt_claveAccion DESC ");
								
		while($r = $s->fetchRow($s)){
			
			$correctivaID 		= $r[0];
			$claveCorrectiva 	= $r[1];
			$tituloCorrectiva 	= $r[2];
			$fechaCorrectiva 	= date('Y-m-d', strtotime($r[3]));
			$status 			= $r[4];
			$etapa				= "";
				
			if($INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $correctivaID AND xt_tipoOrigen = 'E' ")){
				
				$u = $INTRANET->Execute("SELECT SGE.xt_titulo, SGE.xd_fecha,SGU.kf_pdrID FROM SGI_Seguimientos SGU, SGI_Seguimiento_Etapas SGE 
										WHERE SGU.kf_itemOrigenID = $correctivaID AND SGU.xt_tipoOrigen = 'E' AND SGU.kp_seguimientoID = SGE.kf_seguimientoID 
										ORDER BY xn_etapa ");
				
				while($t = $u->fetchRow()){
					$etapa 				= $t[0];
					$fechaCorrectiva 	= date('Y-m-d', strtotime($t[1]));
					$pdr                = $t[2];
					
					//echo"SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ";
					$nombreAsigna = $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $pdr ");
					
				} unset($t); unset($u);
			}

			echo "<tr height='25px' id='fileItem'>";	
			///CLAVE Y VINCULO A LA SOLICITUD			
				echo "<td width='150px' align='center' valign='top'>"; 
					echo "<a href='fichaCorrectiva.php?id=$correctivaID' id='fileItem' style='text-decoration:none;'>".$claveCorrectiva."</a>";
				echo "</td>";
			///TITULO SOLICITUD	
				echo "<td width='380px' align='left' valign='top'>".$tituloCorrectiva."</td>";
			///FECHA
				echo "<td width='80px' align='center' valign='top'>".$fechaCorrectiva."</td>";
				
				echo "<td width='10px' valign='top'> </td>";
			///STATUS EN BASE A LAS ETAPAS
				echo "<td width='150px' align='left' valign='top'>";
					if($etapa != ""){
						if($etapa == "ASIGNAR"){
							echo "Asignada";
							
						}else if($etapa == "ANALISIS"){
							echo "Análisis de causa raíz";
							
						}else if($etapa == "DECISION"){
							echo "Decisión";
							
						}else if($etapa == "SOLICITUD"){
							echo "Plan de acción";
							
						}else if($etapa == "EVALUACION"){
							
							if($status == 1){
								echo "Evaluación de la eficacia: Eficaz";
							} else if($status == 0){
								echo "Evaluación de la eficacia: No Eficaz";
							}
							
						}
						
					}
				echo "</td>";
				echo "<td width='10px'></td>";
				echo "<td width='170px' align='left' valign='top'>".$nombreAsigna."</td>";
				//echo "<td width='20px' align='center' valign='top'> </td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='6'> </td></tr>";
		} unset($r); unset($s);
	}
	
	
	
		
		echo "<tr height='10px'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' >";
		echo "<tr>";
			echo "<td width='1000px' id='titleBlueLineBottom'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='80'><td></td></tr>";
	echo "</table>";
		 
echo "</div>";

?>
		</body>
	</html>
<?php

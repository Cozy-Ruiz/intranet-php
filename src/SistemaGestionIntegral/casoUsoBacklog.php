<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../ConexionDBT.php");
require_once('../compruebaUsuario.php');



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="../JS/jquery-1.9.1.js"></script>

<!-- Funciones de JavaScript -->
<!-- SCRIPT PARA MOSTRAR Y OCULTAR TR DE DOCUMENTOS -->
<script type="text/javascript">
    function activaFile(cual){

 		var vFile=document.getElementById(cual);
  	 if(vFile.style.display == 'block') {
      vFile.style.display = 'none';
   	  } else {
      vFile.style.display = 'block';
   }

        //return true;
    }
</script>
<!-- TERMINO DE SCRIPT PARA MOSTRAR Y OCULTAR TR DE DOCUMENTOS -->



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
            
            
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Caso de uso</title>

</head>
<body>
<?php

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Comunicación Interna / </a> 
			<a href='Modulos.php' id='breadcrumbs'> Solicitudes </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	//codigo de menu navegable
	
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Caso de uso</font>";
			echo"</td>";
		echo"</tr>";
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
                                    	<a href='../ComunicacionInterna/tableroSolicitudesyQuejas.php' id='breadcrumbs'>
                                        	Solicitudes y Quejas
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
                <?php
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='80px'><td></td></tr>";
	echo "</table>"; 
	
	//lineas
	
	echo "<table border='0' align='center' width='100%' cellspacing='0'>";
	
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>GE-B-DF-15-272</td>";
			
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
			
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td style='padding:0px 15px 0px 30px'>";
				echo "Aenean eu leo quam Pellentesque ornare
Has voluptatum scriptorem ad. Fugit luptatum scribentur mei
cu. Pro habemus civibus delicatissimi ut. Qui quot tamquam
impedit et, sapientem prodesset percipitur ei vim. Quot ullum
aliquando vim ea, probatus eleifend et per, sed alii verterem
definitionem te.";
			echo "</td>";
			
			echo "<td width='15px'>";
				echo "<img src='../Imagenes/ICN_Archivo.png' height='15' width='12'/>";	
			echo "</td>";
		echo "</tr>";
		
		//seccion de fecha de solicitud
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Fecha de solicitud</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "2015-12-23";
			echo "</td>";
		echo "</tr>";
		
		//secccionn de solicitante
		
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Solicitante</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "[Nombre de Usuario]";
			echo "</td>";
		echo "</tr>";
		
		//secccionn de solicitante original
		
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Solicitante original</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "[Nombre de Usuario]";
			echo "</td>";
		echo "</tr>";
		
		//secccionn de sistema
		
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Sistema</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "[Nombre de Sistema]";
			echo "</td>";
		echo "</tr>";
		
		//secccion fecha limite para produccion
		
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Fecha límite para producción</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "[AAAA-MM-DD]";
			echo "</td>";
		echo "</tr>";
		
		//secccion prioridad
		
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Prioridad</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "URGENTE";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10px'></tr>";
		echo "<tr>";
			echo "<td style='padding:0px 15px 0px 55px'>";
				echo "Has voluptatum scriptorem ad. Fugit luptatum scribentur mei cu. Pro
habemus civibus delicatissimi ut. Qui quot tamquam impedit et,
sapientem prodesset percipitur ei vim. Quot ullum aliquando vim ea,
probatus eleifend et per, sed alii verterem definitionem te.";
			echo "</td>";
		echo "</tr>";
			
		echo "</table>";
		//secccion ubicación
		
		echo "<table border='0' width='100%'>";
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Ubicación</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "Sistema:";
			echo "</td>";
			
			echo "<td>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "Proceso:";
			echo "</td>";
			
			echo "<td>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "Rol:";
			echo "</td>";
			
			echo "<td>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "Actividad:";
			echo "</td>";
			
			echo "<td>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo "Funcionalidad:";
			echo "</td>";
			
			echo "<td>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
			
		echo "</tr>";
		
	echo "</table>";
			
	//seccion de catalogacion
	echo "<table width='100%'>";
		
		echo "<tr height='25px'></tr>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Catalogación</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			
			echo "<td style='padding:0px 15px 0px 30px'>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			
			echo "<td style='padding:0px 15px 0px 30px'>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			
			echo "<td style='padding:0px 15px 0px 30px'>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				  echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
				 // while($b = $a->fetchRow()){
					 // $prioridadC = $b[0];
					 // if($prioridadC == "NORMAL"){
						//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
					  //}else{
						  echo "<option value='$prioridadC'>Elegir...</option>";
  
					  //}
				  // }
			  echo "</select>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
		
	//seccion de Documentación
	
	echo "<table border='0' width='100%'>";
	
		echo "<tr height='25px'></tr>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Documentación</td>";
			echo "<td width='15px'><a href='tipoDoctosBacklogPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=470,height=450,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";	
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'></tr>";
		echo "</table>";
		
		//Listo todos los tipos de documentación
		
		echo "<table border='0' width='100%'>";
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td align='left' id='manualVinculo'>Diagrama de contexto</td>";
			echo "<td width='15px'></td>";
			echo "<td width='15px'>";
			?>
				<a onClick="activaFile('trPos1')"><img  src='../Imagenes/ICN_NuevoDoc.png' height='15' width='15'/></a>
				
			<?php
			echo "</td>";	
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo "<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td style='padding:0px 0px 0px 15px'>[Nombre del archivo]</td>";
			echo "<td><img src='../Imagenes/ICN_NoOK.png' height='13' width='13'></td>";
			echo "<td><img src='../Imagenes/ICN_Archivo.png' height='15' width='12'></td>";
			
			
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td style='color:#636262; padding:0px 0px 0px 30px'>[Nombre Usuario] 2015-11-22 14:28:00</td>";
			//echo "<td>[Nombre Usuario] 2015-11-22 14:28:00</td>";
		echo "</tr>";
		echo "<tr height='10'></tr>";
		
		echo "</table>";
		
		//div para subir archivos
		//fila del formulario para subir archivo
		echo "<table border='0' style='width: 100%' cellspacing='0'>";
			echo "<tr id='trPos1' style='display: none'>";
				echo "<td width='250px'></td>";
				echo "<td>";
					echo "<div id='divFile'>
					<form action='pagPHP.php?ref=$referencia&user=$usuario&guia=$guia&tipoA=$row[0]&numD=$numDoc&rfc=$rfc' method='post' enctype='multipart/form-data'>
					<fieldset style='width:40%'>
						<input type='file' name='archivo[]' id='archivo' multiple></input>
						<div align='right'><input type='submit' name='subir' value='Enviar'></input></div>
					</fieldset>
					</form> </div>";
				
				echo"</td>";
				
			echo "</tr>";
			
		echo "</table>";
		
		
		
		//Diccionario de datos
		echo "<table border='0' width='100%'>";
		echo "<tr height='20px'></tr>";
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td align='left' id='manualVinculo'>Diccionario de datos</td>";
			echo "<td width='15px'></td>";
			echo "<td width='15px'>";
			?>
				<a onClick="activaFile('<?php echo $trPosF; ?>')"><img  src="../Imagenes/ICN_NuevoDoc.png" width="15" height="15"/></a>
				
			<?php
			echo "</td>";	
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		//sección donde agrega los campos del diccionario de datos
		
		echo "<table border='0' width='100%'>";
		echo "<tr height='10px'></tr>";
		echo "<tr>";
			echo "<td style='color:#007CBD;' width='60px'></td>";
			echo "<td style='color:#007CBD;' width='25%'>Campo</td>";
			echo "<td style='color:#007CBD;' width='15%'>Obligatorio</td>";
			echo "<td style='color:#007CBD;' width='15%'>Tipo</td>";
			echo "<td style='color:#007CBD;' width='30%'>Descripción</td>";
			echo "<td style='color:#007CBD;' width='15px'></td>";
			
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td colspan='5' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='60px'></td>";
			echo "<td>ContainerID</td>";
			echo "<td>Sí</td>";
			echo "<td>Alfanumérico</td>";
			echo "<td>Has voluptatum scriptorem ad. Fugit
luptatum scribentur mei cu. Pro habemus
civibus delicatissimi ut.</td>";
			echo "<td width='15px'></td>";
			
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td colspan='5' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='60px'></tr>";
		
	echo "</table>";
	
	
	//seccion validacion tecnica
	
	echo "<table width='100%'>";
	
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Validación técnica</td>";
			echo "<td width='15px'><a href='backlogVTPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=550,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";	
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
	
	//sección donde agrega los datos de validacion
		
	echo "<table border='0' width='100%'>";
	echo "<tr height='10px'></tr>";
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='60px'></td>";
		echo "<td style='color:#007CBD;' width='30%'>Status</td>";
		echo "<td style='color:#007CBD;' width='35%'>User</td>";
		echo "<td style='color:#007CBD;' width='30%'>Fecha</td>";
		echo "<td style='color:#007CBD;' width='15px'></td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td colspan='4' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td width='60px'></td>";
		echo "<td width='30%'>VIABLE</td>";
		echo "<td width='35%'>[Gerente de Sistemas]</td>";
		echo "<td width='30%'>2015-11-22 14:28:00</td>";
		echo "<td width='15px'></td>";
	echo "</tr>";
	echo "<tr height='10px'></tr>";
	
	echo "<tr>";
		echo "<td width='60px'></td>";
		echo "<td></td>";
		echo "<td style='color:#007CBD;'>Comentarios</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='2'>Has voluptatum scriptorem ad. Fugit luptatum
scribentur mei cu. Pro habemus civibus delicatissimi
ut. Qui quot tamquam impedit et, sapientem
prodesset percipitur ei vim. Quot ullum aliquando
vim ea, probatus eleifend et per, sed alii verterem
definitionem te.</td>";

	echo "<td><img src='../Imagenes/ICN_Archivo.png' height='15' width='12'></td>";
		
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "</table>";
		
	//Seccion de Validación de negocio
	echo "<table width='100%'>";
	
		echo "<tr height='60px'></tr>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Validación de negocio</td>";
			
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<table align='center' width='20%'>";
		
		echo "<tr height='10px'></tr>";
		echo "<tr height='25px' align='center'>";
			echo "<td width='30%' bgcolor='#42CB27'>Procede</td>";
		echo "</tr>";
		echo "<tr height='10px'></tr>";
		echo "<tr height='25px' align='center'>";
			echo "<td width='30%' bgcolor='#E9171A'>No procede</td>";
		echo "</tr>";
		echo "</table>";
		
		
		echo "<table align='center' width='35%'>";
		echo "<tr height='10px'></tr>";
		echo "<tr>";
			echo "<td>[Autorizador] aprobó/rechazó la solicitud</td>";
		echo "</tr>";
		echo "<tr align='center'>";
			echo "<td>2015-11-22 14:28:00</td>";
		echo "</tr>";
	
		
	echo "</table>";
	
	echo "<table width='60%' align='center'>";
		
		echo "<tr height='15px'></tr>";
		
		echo "<tr align='center'>";
			echo "<td>Comentarios:</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr align='center'>";
			echo "<td> <textarea rows='4' cols='70'>
Comentarios.
</textarea> </td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='50px'></tr>";
		
	echo "</table>";
	
	//seccion validación final del requerimiento
	
	echo "<table width='100%'>";
	
		
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Validación final del requerimiento</td>";
			echo "<td width='15px'><a href='backlogVFPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";	
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
	
	//sección donde agrega los datos de validacion final
		
	echo "<table border='0' width='100%'>";
	echo "<tr height='10px'></tr>";
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='60px'></td>";
		echo "<td style='color:#007CBD;' width='30%'>Status</td>";
		echo "<td style='color:#007CBD;' width='35%'>User</td>";
		echo "<td style='color:#007CBD;' width='30%'>Fecha</td>";
		echo "<td style='color:#007CBD;' width='15px'></td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td colspan='4' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td width='60px'></td>";
		echo "<td width='30%'>ACEPTADO</td>";
		echo "<td width='35%'>[Ejecutivo de cuenta]</td>";
		echo "<td width='30%'>2015-11-22 14:28:00</td>";
		echo "<td width='15px'></td>";
	echo "</tr>";
	echo "<tr height='10px'></tr>";
	
	echo "<tr>";
		echo "<td width='60px'></td>";
		echo "<td></td>";
		echo "<td style='color:#007CBD;'>Comentarios</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='2'>Has voluptatum scriptorem ad. Fugit luptatum
scribentur mei cu. Pro habemus civibus delicatissimi
ut. Qui quot tamquam impedit et, sapientem
prodesset percipitur ei vim. Quot ullum aliquando
vim ea, probatus eleifend et per, sed alii verterem
definitionem te.</td>";

	echo "<td><img src='../Imagenes/ICN_Archivo.png' height='15' width='12'></td>";
		
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr height='60px'></tr>";
	
	echo "</table>";
		
	//Seccion de entregables
	echo "<table width='100%'>";
	
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Entregables</td>";
			echo "<td width='15px'><a href='backlogEntregablesPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=450,height=300,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";	
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
	
	echo "<table width='100%'>";
	echo "<tr height='20px'></tr>";
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td align='left' id='manualVinculo'>Entregable 1</td>";
			echo "<td width='15px'></td>";
			echo "<td width='15px'><a href='backlogEntregablesPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=450,height=300,scrollbars=yes')\"><img src='../Imagenes/ICN_NuevoDoc.png' height='15' width='15'> </a></td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		//sección donde agrega los campos del tipo de documento
		
		echo "<table border='0' width='100%'>";
		echo "<tr height='10px'></tr>";
		echo "<tr>";
			echo "<td style='color:#007CBD;' width='60px'></td>";
			echo "<td style='color:#007CBD;' width='35%'>PDR</td>";
			echo "<td style='color:#007CBD;' width='30%'>Código</td>";
			echo "<td style='color:#007CBD;' width='20%'>Status</td>";
			echo "<td style='color:#007CBD;' width='15px'></td>";
			
			
		echo "</tr>";
	
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td colspan='5' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td width='60px'></td>";
			echo "<td>[Nombre Programador]</td>";
			echo "<td>[Código Backlog]</td>";
			echo "<td>Para revisión</td>";
		
			echo "<td width='15px'></td>";
			
			
		echo "</tr>";
	
		echo "<tr>";
			echo "<td width='30px'></td>";
			echo "<td colspan='5' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "</table>";
		
		//seccion de liberación de funcionalidad
		echo "<table width='100%'>";
	
		echo "<tr height='60px'></tr>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Liberación de funcionalidad</td>";
			
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<tr height='20px'></tr>";
		
		//seccion aprobado o no aprobado
		
		echo "<table align='center' border='0' width='20%'>";
		
		echo "<tr height='10px'></tr>";
		echo "<tr height='25px' align='center'>";
			echo "<td  bgcolor='#42CB27'>Liberación</td>";
		echo "</tr>";
		echo "</table>";
		
		
		echo "<table align='center' border='0' width='40%'>";
		echo "<tr height='10px'></tr>";
		echo "<tr>";
			echo "<td style='padding:0px 0px 0px 10px' width='35%'>[Gerente de Sistemas] Liberó funcionalidad</td>";
		echo "</tr>";
		echo "<tr align='center'>";
			echo "<td>2015-11-22 14:28:00</td>";
		echo "</tr>";
	
		echo "</table>";
		
		echo "<table width='60%' align='center'>";
		
		echo "<tr height='15px'></tr>";
		
		echo "<tr align='center'>";
			echo "<td>Comentarios:</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr align='center'>";
			echo "<td> <textarea rows='4' cols='70'>
Comentarios.
</textarea> </td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30px'></tr>";
		
	echo "</table>";
	
	//seccion de traslado al usuario final
	echo "<table width='100%'>";
	
		echo "<tr height='60px'></tr>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Traslado al usuario final</td>";
			echo "<td width='15px'><a href='backlogTUFPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";	
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	//sección donde agrega los datos de traslado al usuario final
		
	echo "<table border='0' width='100%'>";
	echo "<tr height='10px'></tr>";
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='60px'></td>";
		echo "<td style='color:#007CBD;' width='30%'>Status</td>";
		echo "<td style='color:#007CBD;' width='35%'>User</td>";
		echo "<td style='color:#007CBD;' width='30%'>Fecha</td>";
		echo "<td style='color:#007CBD;' width='15px'></td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td colspan='4' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td width='60px'></td>";
		echo "<td width='30%'>ACEPTADO</td>";
		echo "<td width='35%'>[Ejecutivo de cuenta]</td>";
		echo "<td width='30%'>2015-11-22 14:28:00</td>";
		echo "<td width='15px'></td>";
	echo "</tr>";
	echo "<tr height='10px'></tr>";
	
	echo "<tr>";
		echo "<td width='60px'></td>";
		echo "<td></td>";
		echo "<td style='color:#007CBD;'>Comentarios</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='2'>Has voluptatum scriptorem ad. Fugit luptatum
scribentur mei cu. Pro habemus civibus delicatissimi
ut. Qui quot tamquam impedit et, sapientem
prodesset percipitur ei vim. Quot ullum aliquando
vim ea, probatus eleifend et per, sed alii verterem
definitionem te.</td>";

	echo "<td><img src='../Imagenes/ICN_Archivo.png' height='15' width='12'></td>";
		
	echo "</tr>";
	
	echo "<tr>";
		echo "<td style='color:#007CBD;' width='30px'></td>";
		echo "<td></td>";
		
		echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr height='30px'></tr>";
	
	echo "</table>";
	
	
//cierre de la interfaz

	echo "<table width='100%' align='center'>";
	
		echo "<tr height='25px'></tr>";
		echo "<tr>";
		echo "<td colspan='4' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
		echo "</td>";
	echo "</tr>";
	
	echo "<tr align='center'>";
		echo "<td align='center'>";
			echo "<td style='color:#636262;'>Created by: Grupo Escalante Agencias Aduanales, 17 de Noviembre de 2015.</td>";
			echo "";
		echo "<td>";
	echo "</tr>";
	
	echo "</table>";
	
	
	
	?>


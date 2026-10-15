<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García Robles 
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'tableroAuditorias.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";
$ciudades[7] = "Todas";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN";
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
$cdValor[7] = "ALL";

$indice 				= 1;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);


$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

if(		  $_POST['ciudad'] != ""){
	$ciudadShow = $_POST['ciudad'];
	
} else if($_GET['ciudad'] != ""){
	$ciudadShow = $_GET['ciudad'];
	
} else{
	$ciudadShow = $ciudadDefault;
}

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
			<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <title>Tablero de Auditorías</title>
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
				
        		function muestraFiltro(){
					var form1 = document.getElementById("filtroTablero");
					if(form1.style.display ==  'none'){
						form1.style.display = 'block';			
						}else{
							form1.style.display =  'none';
						}
				}
			</script>
           
        </head>
        <body>
	<?php

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Auditorías";
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
		echo"<tr height='20px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center'>";
			
				if(($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'cozy') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Ricardo_Garcia') || ($usuarioId == 'sdelap')){
					
					echo "<a href='altaAuditoriaPopUp.php'><img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'></a>";
					
				}
				
			echo "</td>";
		echo "</tr>";
		
		//echo"<tr height='30px'><td></td></tr>";
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
					<table border='0' align='center' id='breadcrumbs' style='border:1px solid %23007cbd;'>
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
		
		echo "<tr height='10px;'></tr>";
		echo "<table border='0' align='center'   width='700px'>";
			echo"<tr>";
				echo"<td colspan='3' align='left' id='iconosTexto2'><a href='javascript:void(0);' onclick='muestraFiltro();' style='color:rgb(0,124,189);'>Filtro</a> </td>";
				echo "<td width='15' align='center' style='color:rgb(0,124,189);'></td>";
				//echo"<td colspan='3' align='left' id='iconosTexto2'><a href='javascript:void(0);' onclick='muestraCodigo();' style='color:rgb(0,124,189);'> Búsqueda Código</a> </td>";
		  	echo"</tr >";
		  	echo "<tr height='10'>";
		  	echo "</tr>";
  		echo "</table>";
  	
		echo "<form method='POST' action='tableroAuditorias.php' id='filtroTablero' style='display:none;'>";
		echo "<table border='0' width='700px;' align='center'>";
			echo "<tr>";
				echo "<td>";
					echo "<p style='margin-left:50%;'>OFICINA</p>";
				echo "</td>";
				echo "<td width='25px'></td>";
				echo "<td>";
					echo "<p style='margin-right:50%;'>AÑO</p>";
				echo "</td>";
				echo "<td>";
					echo "<p style='margin-right:50%;'>ESTATUS</p>";
				echo "</td>";
			echo "</tr>";
			echo"<tr>";
  	 			echo"<td colspan='8' id='titleBlueLineTop'></td>";
  			echo"</tr>";
			echo "<tr style='height:5px'>";
			echo "<tr>";
				echo "<td>";
					echo "<div style='margin-left:50%;'>";
						echo "<select name='ciudad'>";
							echo "<option value=' '>Selecciona......</option>"; 
							echo "<option value='CUN'>CANCUN</option>";
							echo "<option value='DF'>CIUDAD DE MEXICO</option>";
							echo "<option value='LAR'>LAREDO</option>";
							echo "<option value='NLR'>NUEVO LAREDO</option>";
							echo "<option value='TOL'>TOLUCA</option>";
							echo "<option value='VER'>VERACRUZ</option>";
						echo "</select>";
					echo "</div>";
				echo "</td>";
				echo "<td width='25px'></td>";
				echo "<td>";
					echo "<div style='margin-right:10%;'>";
						echo "<select name='anio'>";
							echo "<option value=' '>Selecciona......</option>";
							for($a=0;$a<=3;$a++){
								$anio = date("Y") - $a;
								echo "<option value=".$anio.">".$anio."</option>";
							}
						echo "</select>";
					echo "</div>";
				echo "</td>";
				echo "<td>";
					echo "<div style='margin-right:40%;'>";
						echo "<select name='estatus'>";
							echo "<option value=' '>Selecciona......</option>";
							echo "<option value='PENDIENTE'>PENDIENTE</option>";
							echo "<option value='TERMINADA'>TERMINADA</option>";
						echo "</select>";
					echo "</div>";
				echo "</td>";
			echo "</tr>";
			echo "<tr style='height:10px'>";
			echo "</tr>";
			echo "<tr>";
				echo "<td colspan='4'>";
					echo "<center><input type='image' name='Enviar' onclick='SubmitForm(this.form);' align='center' src='../../Imagenes/ICN_BotonEnviar.png' width='60' height='20'></center";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
	
	
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	//banderas globales
	$banderaT = 0;
	$banderaHallazgo = 0;
	
	if( $_POST['ciudad'] != '' || $_POST['anio'] != '' || $_POST['estatus'] != ''){
		
		 $ciudad = $_POST['ciudad'];
		 $anio   = $_POST['anio'];
		
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr id='titulo2'>";
				echo "<td align='center' width='140px'>Código</td>";
				echo "<td align='left' width='400px'>Título</td>";
				echo "<td align='center' width='80px'>Tipo</td>";
				
				echo "<td align='center' width='80px'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='5' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='10'><td colspan='5'></td></tr>";
		echo "</table>";
		
		echo"<table align='center' border='0' width='700px'>";
		
			//defino como sera el filtro
			
			//1.- ciudad, año, estatus
			if($_POST['ciudad'] != ' ' && $_POST['anio'] != ' ' && $_POST['estatus'] != ' '){
				
				$ciudadQuery = "xt_ciudad = '$ciudad':";
				$anioQuery = "YEAR(xd_fecha) = '$anio':";
				
				$concatenar = $ciudadQuery.$anioQuery;
				$filtroRemplaza = str_replace(":"," AND ",$concatenar);
				$filtroRemplazaAnd = substr($filtroRemplaza,0,-4);
				
				//query
				$query = "SELECT xt_claveAuditoria, xt_titulo, xt_tipo, xd_fecha, xt_status, kp_auditoriaID FROM SGI_Auditorias WHERE ".$filtroRemplazaAnd. " ORDER BY xd_fecha DESC ";

				
			}
			
			if($_POST['ciudad'] == ' ' && $_POST['anio'] != ' ' && $_POST['estatus'] != ' '){
				
				 $query = "SELECT xt_claveAuditoria, xt_titulo, xt_tipo, xd_fecha, xt_status, kp_auditoriaID FROM SGI_Auditorias WHERE YEAR (xd_fecha) = '$anio' ORDER BY xd_fecha DESC ";

				
			}
			
			if($_POST['ciudad'] != ' ' && $_POST['anio'] == ' ' && $_POST['estatus'] != ' '){
				$busCiudad = $_POST['ciudad'];
				
				echo $query = "SELECT xt_claveAuditoria, xt_titulo, xt_tipo, xd_fecha, xt_status, kp_auditoriaID FROM SGI_Auditorias WHERE xt_ciudad = '$busCiudad' ORDER BY xd_fecha DESC ";

			}
			
			
			
			
			$bandera = 0;			
			
			
			$s = $INTRANET->Execute($query);
			
			while($r = $s->fetchRow()){
	
				//echo "<tr height='25' id='fileItem'>";	
					/*echo "<td width='140px' align='center'>";
						if($r[4] == 1){
							
							echo "<a href='AuditoriaActualizar.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
						}else if($r[4] == 2){
							
							echo "<a href='FichaAuditoria.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
						}
					echo "</td>";
					
					echo "<td width='400px' align='left'>".$r[1]."</td>";
					
					echo "<td width='80' align='center'>";
						if($r[2] == "IN"){
							
							echo "Interna";
							
						}else if($r[2] == "EX"){
							
							echo "Externa";
							
						}
					echo "</td>";*/
					
					
					//defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
					//primero identificamos si se declaron o no hallazgos
					//echo "SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$r[0]'";
					 $declaroHallazgo = $INTRANET->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$r[0]'");
					
					if($declaroHallazgo == '' && $_POST['estatus'] == 'PENDIENTE'){
						echo "<tr height='25' id='fileItem'>";	
						echo "<td width='150px' align='center'>";
						if($r[4] == 1){
							
							echo "<a href='AuditoriaActualizar.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
						}else if($r[4] == 2){
							
							echo "<a href='FichaAuditoria.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
						}
						echo "</td>";
					
						echo "<td width='400px' align='left'>".$r[1]."</td>";
					
						echo "<td width='80' align='center'>";
						if($r[2] == "IN"){
							
							echo "Interna";
							
						}else if($r[2] == "EX"){
							
							echo "Externa";
							
						}
						echo "</td>";
						
						
						echo "<td width='10' align='center'></td>";
						echo "<td width='80' align='center'>".$r[3]."</td>";
						
						echo "</tr>";
						echo "<tr height='10'><td colspan='4'></td></tr>";
						
					}
					
					if($_POST['estatus'] == 'TERMINADA'){
						
						if($declaroHallazgo == 'No'){
							echo "<tr height='25' id='fileItem'>";	
							
							echo "<td width='150px' align='center'>";
							if($r[4] == 1){
							
								echo "<a href='AuditoriaActualizar.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
							}else if($r[4] == 2){
							
								echo "<a href='FichaAuditoria.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
							}
							echo "</td>";
					
							echo "<td width='400px' align='left'>".$r[1]."</td>";
					
							echo "<td width='80' align='center'>";
							if($r[2] == "IN"){
							
								echo "Interna";
							
							}else if($r[2] == "EX"){
							
								echo "Externa";
							
							}
							echo "</td>";
						
							
							echo "<td align='center'><IMG SRC='../Imagenes/ICN_Estrella_Auditoria.png' width=15 height=15></td>";
							
							echo "<td width='80' align='center'>".$r[3]."</td>";
							echo "</tr>";
							echo "<tr height='10'><td colspan='4'></td></tr>";
						
						}
					
					}
					
					if($declaroHallazgo == 'Si'){
						//1,.Obtengo los issue de la auditoria
						$b = $INTRANET->Execute("SELECT kp_issueID FROM SGI_Auditorias_Issues WHERE kf_auditoriaID = $r[5]");
						while($listIssue = $b->fetchRow()){
							//obtengo el codigo de la correctiva
							$c = $INTRANET->Execute("SELECT xt_codigo FROM SGI_Auditorias_Issues_Tratamientos WHERE kf_issueID = $listIssue[0]");
							while ($listCodC = $c->fetchRow()){
								
								$d = $INTRANET->Execute("SELECT kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$listCodC[0]'");
								
								while ($listA = $d->fetchRow()){
									
									$e = $INTRANET->Execute("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $listA[0] AND xt_tipoOrigen = 'E'");
									
									while($listSeg = $e->fetchRow()){
										
										$banderaHallazgo = 1;
										
										//obtengo la ultima etapa
										$semaforoTerminada = $INTRANET->getOne("SELECT xt_titulo FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $listSeg[0] ORDER BY xd_fechaCreacion DESC");
										
										if($semaforoTerminada != 'EVALUACION'){
											
											$banderaT = 1;
											
											
										}
											
								
									
									}
									
								}
							}
								
						}//fin del while 
						
						if($_POST['estatus'] == 'PENDIENTE'){
						
							if($banderaT == 1 && $banderaHallazgo == 1){
								
								echo "<tr height='25' id='fileItem'>";	
								echo "<td width='150px' align='center'>";
								
								if($r[4] == 1){
								
									echo "<a href='AuditoriaActualizar.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
								
								}else if($r[4] == 2){
								
									echo "<a href='FichaAuditoria.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
								
								}
								echo "</td>";
						
								echo "<td width='400px' align='left'>".$r[1]."</td>";
						
								echo "<td width='80' align='center'>";
								if($r[2] == "IN"){
								
									echo "Interna";
								
								}else if($r[2] == "EX"){
								
									echo "Externa";
								
								}
								
								echo "</td>";
								
								
								echo "<td align='center'><IMG SRC='../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10></td>";
								echo "<td width='80' align='center'>".$r[3]."</td>";
								
								echo "</tr>";
								echo "<tr height='10'><td colspan='4'></td></tr>";
								
							}else if($banderaT != 1 && $banderaHallazgo != 1){
								
								echo "<tr height='25' id='fileItem'>";	
								echo "<td width='150px' align='center'>";
							if($r[4] == 1){
								
								echo "<a href='AuditoriaActualizar.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
								
							}else if($r[4] == 2){
								
								echo "<a href='FichaAuditoria.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
								
							}
						echo "</td>";
						
						echo "<td width='400px' align='left'>".$r[1]."</td>";
						
						echo "<td width='80' align='center'>";
							if($r[2] == "IN"){
								
								echo "Interna";
								
							}else if($r[2] == "EX"){
								
								echo "Externa";
								
							}
						echo "</td>";
								
								
								echo "<td align='center'><IMG SRC='../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10></td>";
								echo "<td width='80' align='center'>".$r[3]."</td>";
								
								echo "</tr>";
								echo "<tr height='10'><td colspan='4'></td></tr>";
								
							}
						
					}//fin del if de verificacion pendiente
						
					if($_POST['estatus'] == 'TERMINADA'){
						
							if($banderaT != 1 && $banderaHallazgo == 1){
								echo "<tr height='25' id='fileItem'>";	
								
								echo "<td width='150px' align='center'>";
								if($r[4] == 1){
							
									echo "<a href='AuditoriaActualizar.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
								}else if($r[4] == 2){
							
									echo "<a href='FichaAuditoria.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
								}
							echo "</td>";
					
							echo "<td width='400px' align='left'>".$r[1]."</td>";
					
							echo "<td width='80' align='center'>";
							if($r[2] == "IN"){
							
								echo "Interna";
							
							}else if($r[2] == "EX"){
							
								echo "Externa";
							
							}
							echo "</td>";
								
								
								echo "<td align='center'><IMG SRC='../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10></td>";
								echo "</tr>";
								
								echo "<tr height='10'><td colspan='4'></td></tr>";
							}
						
						}//FIN DEL IF DE VERIFICACION TERMINADA
						
						unset($banderaT);
						unset($banderaHallazgo);
						
						
					}//fin del if donde verifico que si tiene hallazgos
					
					
					
					
				$bandera++;
			
					
					
				//echo "</tr>";
				
				
				
				
				
			} unset($r); unset($s);
			
			
			if($bandera == 0){
				echo "<tr height='70px' id='fileItem'>";	
					echo "<td width='700px' align='center'>No hay Auditorias para mostrar.</td>";
				echo "</tr>";
			}
			
		echo "</table>";
	
	}else if($_POST['ciudad'] == '' && $_POST['anio'] == '' && $_POST['estatus'] == '' ){	
	
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr id='titulo2'>";
				echo "<td align='center' width='140px'>Código</td>";
				echo "<td align='left' width='400px'>Título</td>";
				echo "<td align='center' width='80px'>Tipo</td>";
				
				echo "<td align='center' width='80px'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='5' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='10'><td colspan='5'></td></tr>";
		echo "</table>";
		
		echo"<table align='center' border='0' width='700px'>";
			
			$bandera = 0;
			
			$s = $INTRANET->Execute("SELECT xt_claveAuditoria, xt_titulo, xt_tipo, xd_fecha, xt_status, kp_auditoriaID FROM SGI_Auditorias ORDER BY xd_fecha DESC ");
			
			while($r = $s->fetchRow()){
	
				echo "<tr height='25' id='fileItem'>";	
					echo "<td width='150px' align='center'>";
						if($r[4] == 1){
							
							echo "<a href='AuditoriaActualizar.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
						}else if($r[4] == 2){
							
							echo "<a href='FichaAuditoria.php?id=".$r[5]."' id='fileItem' style='text-decoration:none;'>".$r[0]."</a>";
							
						}
					echo "</td>";
					
					echo "<td width='500px' align='left'>".$r[1]."</td>";
					
					echo "<td width='80' align='center'>";
						if($r[2] == "IN"){
							
							echo "Interna";
							
						}else if($r[2] == "EX"){
							
							echo "Externa";
							
						}
					echo "</td>";
					
					//defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
					
					//primero identificamos si se declaron o no hallazgos
					$declaroHallazgo = $INTRANET->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$r[0]'");
					
					if($declaroHallazgo == ''){
						echo "<td width='10' align='center'></td>";
						
					}
					
					if($declaroHallazgo == 'No'){
						echo "<td align='center'><IMG SRC='../Imagenes/ICN_Estrella_Auditoria.png' width=50 height=50></td>";
						
					}
					
					if($declaroHallazgo == 'Si'){
					
					//1,.Obtengo los issue de la auditoria
					$b = $INTRANET->Execute("SELECT kp_issueID FROM SGI_Auditorias_Issues WHERE kf_auditoriaID = $r[5]");
					while($listIssue = $b->fetchRow()){
						//obtengo el codigo de la correctiva
						$c = $INTRANET->Execute("SELECT xt_codigo FROM SGI_Auditorias_Issues_Tratamientos WHERE kf_issueID = $listIssue[0]");
						while ($listCodC = $c->fetchRow()){
							
							$d = $INTRANET->Execute("SELECT kp_accionesID FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$listCodC[0]'");
							
							while ($listA = $d->fetchRow()){
								
								$e = $INTRANET->Execute("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE kf_itemOrigenID = $listA[0] AND xt_tipoOrigen = 'E'");
								
								
								while($listSeg = $e->fetchRow()){
									$banderaHallazgo = 1;
									
									//obtengo la ultima etapa
									$semaforoTerminada = $INTRANET->getOne("SELECT xt_titulo FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $listSeg[0] ORDER BY xd_fechaCreacion DESC");
									
									//echo "SELECT xt_titulo FROM SGI_Seguimiento_Etapas WHERE KF_SEGUIMIENTOid = $listSeg[0] ORDER BY xd_fechaCreacion DESC";
									
										
										if($semaforoTerminada != 'EVALUACION'){
										
										$banderaT = 1;
										
										
									}
										
										
									
								
								}
								
								
							}
							
							
						}
						
						
							
					}//fin del while 
					
					
					
					if($banderaT == 1 && $banderaHallazgo == 1){
						echo "<td align='center'><IMG SRC='../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10></td>";
						
					}else if($banderaT != 1 && $banderaHallazgo != 1){
						echo "<td align='center'><IMG SRC='../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10></td>";
						
					}else if($banderaT != 1 && $banderaHallazgo == 1){
						echo "<td align='center'><IMG SRC='../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10></td>";
					}
					
					unset($banderaT);
					unset($banderaHallazgo);
					
					}//fin del if donde verificamos que si existen hallazgos
					
					echo "<td width='80' align='center'>".$r[3]."</td>";
					
					
			
			
					
					
					
					/*if($banderaP == 1){
						echo "<td width='80' align='center'>PENDIENTE</td>";
						
					}
					
					if($banderaT == 1){
						echo "<td width='80' align='center'>TERMINADA</td>";
						
					}*/
					
				echo "</tr>";
				
				echo "<tr height='10'><td colspan='4'></td></tr>";
				
				$bandera++;
				
			} unset($r); unset($s); 
			
			if($bandera == 0){
				echo "<tr height='70px' id='fileItem'>";	
					echo "<td width='700px' align='center'>No hay Auditorias para mostrar.</td>";
				echo "</tr>";
			}
			
		echo "</table>";
	}
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td width='700px' id='titleBlueLineBottom'></td>";
		echo "</tr>";echo "<tr>";
			echo "<td align='center' id='nota_al_pie' colspan='2'>";
			///Titulo
				echo "Created by: Grupo Escalante Agencias Aduanales.";
			echo "</td>";
		echo "</tr>";
	echo"</table>";
	echo "<br><br>";
  	echo "</form>";
echo "</div>";

?>
    	</body>
    </html>
<?php

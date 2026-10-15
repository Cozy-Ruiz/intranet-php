<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?PHP
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp="busquedaPersonal.php";
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Personal</title>
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
			document.getElementById("mostrar").style.display="block";
			document.getElementById("ocultar").style.display="none";
		} else if (valor == 0){
			document.getElementById("mostrar").style.display="none";
			document.getElementById("ocultar").style.display="block";
		}
	}
</script> 

</head>
<body>
<?PHP

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
$cdValor[6] = "LR";


$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
$ciudadesDisponibles = NULL;
$indice = 1;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a> <a href='comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna</a>";

$ciudadDefault= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");
if($_POST['ciudad'] !=""){
	$ciudadFiltro = $_POST['ciudad'];
}else if($_GET['ciudad'] !=""){
	$ciudadFiltro = $_GET['ciudad'];
}else{
	$ciudadFiltro = $ciudadDefault;
}

for($o=1;$o<=6;$o++){
	if($cdValor[$o] == $ciudadFiltro){
		$imprimeCiudad = $ciudades[$o];
	}
}

				

//CASO 1 PANTALLA INCIAL // INHOUSE
echo"<div id='wrapperFicha' align='center'>";
	echo "<form name='busquedaPersonal2' method='POST' action='busquedaPersonal2.php'>";	
if($categoriaUsr == "Inhouse"){
	
	if($_POST['searchName'] == "" && $_GET['view'] == "" && $_GET['search'] == ""){
		
		echo "Todo vacio";
			
			echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
				echo "<tr height='40px'><td></td></tr>";
				echo "<tr>";
					echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' name='Encabezado'>";		
				echo"<tr height='80px'> </tr>";
				///Titulo 
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='700px'>";
						echo "Acceso Autorizado";
					echo"</td>";
				echo"</tr>";
				if($categoriaUsr == "Administrador"){
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>".$imprimeCiudad."</font>";
						echo"</td>";
					echo"</tr>";
				}
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
			//echo"<tr height='100'> </tr>";		
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
						//banana de navegacion
						echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				  			include("../navegacion_banana.php");
			  			echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>"; 
			
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
				for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."'>".$i."</a> ";
					echo"</td >";
				}
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo "<tr>";
				//CONDICION PARA VER TODO
					echo "<td  colspan='25' align='left'> <a href='busquedaPersonal2.php?view=todo' id='nota_al_pie' style='text-decoration:none;'> Ver todo </a></td>";
					//CONDCION PARA ALTA
					echo"<td align='right' width='20'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='26'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			
			echo"<table border='0' align='center' width='800'>";
			
				echo"<tr height='30'> </tr>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
	//RESULTADO DE BUSQUEDA POR NOMBRE ESPECIFICO
	}else if($_POST['searchName'] != "" && $_GET['view'] == "" && $_GET['search'] == ""){
		
		echo "busco por nombre";
			
			echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
				echo "<tr height='40px'><td></td></tr>";
				echo "<tr>";
					echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' name='Encabezado'>";		
				echo"<tr height='80px'> </tr>";
				///Titulo 
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='700px'>";
						echo "Acceso Autorizado";
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
			//echo"<tr height='100'> </tr>";		
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
						
					echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
						include("../navegacion_banana.php");
					echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>";
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
					for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."'>".$i."</a> ";
					echo"</td >";
				}
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo "<tr>";
					//CONDICION PARA VER TODO
					echo "<td  colspan='25' align='left'> <a href='busquedaPersonal2.php?view=todo' id='nota_al_pie' style='text-decoration:none;'> Ver todo </a></td>";
					echo"<td align='right' width='20'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
					
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='26'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			//RESULTADO DE BUSQUEDA POR NOMBRE ESPECIFICO
			
			$searchNombre= $_POST['searchName'];
			
			$n = $INTRANET->execute("SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre FROM SGI_Empleados WHERE (xt_ApellidoPaterno  LIKE '%$searchNombre%' OR xt_ApellidoMaterno LIKE '%$searchNombre%' 
			OR xt_Nombre LIKE '%$searchNombre%') AND xt_ciudad='$ciudadDefault' ORDER BY xt_ApellidoPaterno ASC");
		
		echo "SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre FROM SGI_Empleados WHERE (xt_ApellidoPaterno  LIKE '%$searchNombre%' OR xt_ApellidoMaterno LIKE '%$searchNombre%' OR xt_Nombre LIKE '%$searchNombre%') ORDER BY xt_ApellidoPaterno ASC";
		
			$nom = $n->recordCount();
			echo"<table border='0' align='center' name='busquedaPersonal2'>";
				//echo"$searchNombre";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='left'> Resultado de la busqueda </td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
				
					if($nom>0)
						{
						
						while($a = $n->fetchRow()){
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'> <a id='iconosTexto' style='text-decoration:none;' href='Personal/fichaPersonal.php?ID=$a[0]'> $a[3] $a[1] $a[2] </a> </td>";
				echo "</tr>";
				
						}
					}else{
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'><i> No se encontraron resultados. </i></td>";
						echo "</tr>";
						
					}
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' width='800'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
			echo"</table>";
		
	}else if($_POST['searchName'] == "" && $_GET['view'] == "todo" && $_GET['search'] == ""){
		
		echo "no bsco por nada";
			
			echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
				echo "<tr height='40px'><td></td></tr>";
				echo "<tr>";
					echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
					
			echo "<table border='0' align='center' name='Encabezado'>";		
				echo"<tr height='80px'> </tr>";
				///Titulo 
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='700px'>";
						echo "Acceso Autorizado";
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
			//echo"<tr height='100'> </tr>";		
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
					
					echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
						include("../navegacion_banana.php");
					echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>";
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
					for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."'>".$i."</a> ";
					echo"</td >";
				}
				echo"<tr height='30'> </tr>";
				
				echo "<tr>";
				//CONDICION PARA VER TODO
					echo "<td  colspan='25' align='left'> <a href='busquedaPersonal2.php?view=todo' id='nota_al_pie' style='text-decoration:none;'> Ver todo </a></td>";
					//CONDCION PARA ALTA
					echo"<td align='right' width='20'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='26'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			//RESULTADO DE BUSQUEDA GENERAL TODO
			
			$s = $INTRANET->execute("SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre 
			FROM SGI_Empleados WHERE LEFT (xt_ApellidoPaterno,1)  LIKE '%%' AND xt_ciudad='$ciudadDefault' ORDER BY xt_ApellidoPaterno ASC");
			$num = $s->recordCount();
			echo"<table border='0' align='center' name='busquedaPersonal2'>";
					if($num>0)
						{
						
						while($r = $s->fetchRow()){
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'> <a id='iconosTexto' style='text-decoration:none;' href='Personal/fichaPersonal.php?ID=$r[0]'> $r[1] $r[2] $r[3] </a> </td>";
				echo "</tr>";
				
						}
					}else{
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'><i> No se encontraron resultados. </i></td>";
						echo "</tr>";
						
					}
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' width='800'>";
			
				echo"<tr height='30'> </tr>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
	//RESULTADO DE BUSQUEDA POR LETRA
	} else if($_POST['searchName'] == "" && $_GET['view'] == "" && $_GET['search'] != ""){
		
		echo "busco por letra";
			
			echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
				echo "<tr height='40px'><td></td></tr>";
				echo "<tr>";
					echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' name='Encabezado'>";		
				echo"<tr height='80px'> </tr>";
				///Titulo 
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='700px'>";
						echo "Acceso Autorizado";
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
			//echo"<tr height='100'> </tr>";		
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
						
						echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
							include("../navegacion_banana.php");
						echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>";
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
					for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."'>".$i."</a> ";
					echo"</td >";
				}
				
				echo"<tr height='30'> </tr>";
				
				echo "<tr>";
				//CONDICION PARA VER TODO
					echo "<td  colspan='25' align='left'> <a href='busquedaPersonal2.php?view=todo' id='nota_al_pie' style='text-decoration:none;'> Ver todo </a></td>";
					//CONDCION PARA ALTA
					echo"<td align='right' width='20'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='26'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			//RESULTADO DE BUSQUEDA POR LETRA APELLIDO
			
			$search= $_GET['search'];
			
			$s = $INTRANET->execute("SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre 
			FROM SGI_Empleados WHERE LEFT (xt_ApellidoPaterno,1)  LIKE '%$search%' AND xt_ciudad='$ciudadDefault' ORDER BY xt_ApellidoPaterno ASC");
			$num = $s->recordCount();
			echo"<table border='0' align='center' name='busquedaPersonal2'>";
					if($num>0)
						{
						
						while($r = $s->fetchRow()){
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'> <a id='iconosTexto' style='text-decoration:none;' href='Personal/fichaPersonal.php?ID=$r[0]'> $r[1] $r[2] $r[3] </a> </td>";
				echo "</tr>";
				
						}
					}else{
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'><i> No se encontraron resultados. </i></td>";
						echo "</tr>";
						
					}
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' width='800'>";
			
				echo"<tr height='30'> </tr>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30'> </tr>";
			echo"</table>";
	}
}//TERMINA CASO INHOUSE

// CASO ADMINISTRADOR
else if($categoriaUsr == "Administrador"){
	
	//$ciudad = $_POST['ciudad'];
	if($_POST['searchName'] == ""  && $_GET['search'] == ""){
		
		echo "caso administrador no busco por nada";
		
		echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
			echo "<tr height='40px'><td></td></tr>";
			echo "<tr>";
				echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
			echo "</tr>";
			echo "<tr height='20px'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' name='Encabezado'>";		
			echo"<tr height='80px'> </tr>";
			///Titulo 
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='700px'>";
					echo "Acceso Autorizado";
				echo"</td>";
			echo"</tr>";
			if($categoriaUsr == "Administrador"){
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>".$imprimeCiudad."</font>";
					echo"</td>";
				echo"</tr>";
			}
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
			//echo"<tr height='100'> </tr>";		
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
					
					echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
						include("../navegacion_banana.php");
					echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>";
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
				for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."&ciudad=$ciudadFiltro'>".$i."</a> ";
					echo"</td >";
				}
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo "<table border='0' align='center' id='ocultar' style='display:block;' width='800'>";
				echo"<tr>";
					echo"<td align='left' id='breadcrumbs' onClick='show(1);' width='150'>Filtrar por ciudad</td>";
					
					echo"<td align='right' width='650'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' id='mostrar' style='display:none;' width='800'>";
			
				echo "<tr>";
				//CONDICION PARA VER TODO
					echo "<td  align='left' id='breadcrumbs' onClick='show(0);'> Filtrar por ciudad </td>";
					
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='breadcrumbs' valign='top' width='50'>";
					///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					/*	echo"<select name='ciudad' size='1'>";
						if($ciudadFiltro == ""){
							echo "<option value=''>Seleccionar..</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						}else{
							echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						
						}
						echo"</select>";*/
						
					echo"<select name='ciudad' size='1'>";
						echo "<option value=''>Seleccionar..</option>";
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudadess = $p[1];
									$cdValors  = $p[0];
															  
									if($ciudadFiltros == ""){
										echo"<option value='".$cdValors."'>".$ciudadess."</option>";
									}else{
										 echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
										 echo"<option value='".$cdValors."'>".$ciudadess."</option>";
											
									}			
								}
						echo"</select>";
					echo"</td>";
				
					echo"<td align='left' width='50'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' height='20' width='70'></td>";
					//CONDCION PARA ALTA
					echo"<td align='right' width='700'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			
			echo"<table border='0' align='center' width='800'>";
			
				echo"<tr height='30'> </tr>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30'> </tr>";
			echo"</table>";
	
	//RESULTADO DE BUSQUEDA POR NOMBRE CAJA TEXTO
	}else if($_POST['searchName'] != "" && $_GET['search'] == ""){
		
		echo "para administrador busco por nombre";
			
			echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
				echo "<tr height='40px'><td></td></tr>";
				echo "<tr>";
					echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' name='Encabezado'>";		
				echo"<tr height='80px'> </tr>";
				///Titulo 
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='700px'>";
						echo "Acceso Autorizado";
					echo"</td>";
				echo"</tr>";
		
				if($categoriaUsr == "Administrador"){
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>".$imprimeCiudad."</font>";
						echo"</td>";
					echo"</tr>";
				}
		
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
			//echo"<tr height='100'> </tr>";		
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
						
					echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
						include("../navegacion_banana.php");
					echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>";
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
					for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."&ciudad=$ciudadFiltro'>".$i."</a> ";
					echo"</td >";
				}
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
			echo"</table>";
			
			echo"<table border='0' align='center' name='menuLetras' width='800'>";
				echo "<tr>";
					//CONDICION PARA VER TODO
					echo "<td align='left' id='breadcrumbs'> Filtrar por ciudad </td>";
					
				echo "</tr>";
				
				
				
				echo "<tr>";
					echo "<td id='breadcrumbs' valign='top' width='50'>";
					///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					echo"<select name='ciudad' size='1'>";
						echo "<option value=''>Seleccionar..</option>";
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudadess = $p[1];
									$cdValors  = $p[0];
															  
									if($ciudadFiltros == ""){
										echo"<option value='".$cdValors."'>".$ciudadess."</option>";
									}else{
										 echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
										 echo"<option value='".$cdValors."'>".$ciudadess."</option>";
											
									}			
								}
						echo"</select>";/*
			
						echo"<select name='ciudad' size='1'>";
						if($ciudadFiltro == ""){
							echo "<option value=''>Seleccionar..</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						}else{
							echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						
						}
						echo"</select>";*/
					echo"</td>";
				
					echo"<td align='left' width='50'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' height='20' width='70'></td>";
					
					//CONDCION PARA ALTA
					echo"<td align='right' width='700'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			//RESULTADO DE BUSQUEDA POR NOMBRE CAJA TEXTO
			
			$searchNombre= $_POST['searchName'];
			
			$n = $INTRANET->execute("SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre FROM SGI_Empleados WHERE (xt_ApellidoPaterno  LIKE '%$searchNombre%' OR xt_ApellidoMaterno LIKE '%$searchNombre%' OR xt_Nombre LIKE '%$searchNombre%') ORDER BY xt_ApellidoPaterno ASC");
		
			
			$nom = $n->recordCount();
			echo"<table border='0' align='center' name='busquedaPersonal2'>";
				//echo"$searchNombre";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='left'> Resultado de la busqueda </td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
				
					if($nom>0)
						{
						
						while($a = $n->fetchRow()){
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'> <a id='iconosTexto' style='text-decoration:none;' href='Personal/fichaPersonal.php?ID=$a[0]'> $a[3] $a[1] $a[2] </a> </td>";
				echo "</tr>";
				
						}
					}else{
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'><i> No se encontraron resultados. </i></td>";
						echo "</tr>";
						
					}
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' width='800'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
			echo"</table>";
			
	}else if($_POST['searchName'] == ""  && $_GET['search'] == ""){	
			
		echo "para el caso del administrador no busco por nada post";
			echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
				echo "<tr height='40px'><td></td></tr>";
				echo "<tr>";
					echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' name='Encabezado'>";		
				echo"<tr height='80px'> </tr>";
				///Titulo 
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='700px'>";
						echo "Acceso Autorizado";
					echo"</td>";
				echo"</tr>";
		
		
				if($categoriaUsr == "Administrador"){
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>".$imprimeCiudad."</font>";
						echo"</td>";
					echo"</tr>";
				}
				
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
			//echo"<tr height='100'> </tr>";		
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
						echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
							include("../navegacion_banana.php");
						echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>";
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
					for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."&ciudad=$ciudadFiltro'>".$i."</a> ";
					echo"</td >";
				}
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' name='menuLetras' width='800'>";
				
				echo "<tr>";
				//CONDICION PARA VER TODO
					echo "<td align='left' id='breadcrumbs'> Filtrar por ciudad </td>";
					
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='breadcrumbs' valign='top' width='50'>";
					///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					/*
						echo"<select name='ciudad' size='1'>";
						if($ciudadFiltro == ""){
							echo "<option value=''>Seleccionar..</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						}else{
							echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						
						}
						echo"</select>";*/
						echo"<select name='ciudad' size='1'>";
						echo "<option value=''>Seleccionar..</option>";
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudadess = $p[1];
									$cdValors  = $p[0];
															  
									if($ciudadFiltros == ""){
										echo"<option value='".$cdValors."'>".$ciudadess."</option>";
									}else{
										 echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
										 echo"<option value='".$cdValors."'>".$ciudadess."</option>";
											
									}			
								}
						echo"</select>";
					echo"</td>";
				
					echo"<td align='left' width='50'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' height='20' width='70'></td>";
					
					//CONDCION PARA ALTA
					echo"<td align='right' width='700'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			//RESULTADO DE BUSQUEDA GENERAL TODO

			$s = $INTRANET->execute("SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre 
			FROM SGI_Empleados WHERE LEFT (xt_ApellidoPaterno,1)  LIKE '%%' AND xt_ciudad = '$ciudadFiltro' ORDER BY xt_ApellidoPaterno ASC");
			$num = $s->recordCount();
			echo"<table border='0' align='center' name='busquedaPersonal2'>";
					if($num>0)
						{
						
						while($r = $s->fetchRow()){
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'> <a id='iconosTexto' style='text-decoration:none;' href='Personal/fichaPersonal.php?ID=$r[0]'> $r[1] $r[2] $r[3] </a> </td>";
				echo "</tr>";
				
						}
					}else{
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'><i> No se encontraron resultados. </i></td>";
						echo "</tr>";
						
					}
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' width='800'>";
			
				echo"<tr height='30'> </tr>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='30'> </tr>";
			echo"</table>";

	//BUSQUEDA POR LETRA APELLIDO PATERNO
	
	} else if($_POST['searchName'] == ""  && $_GET['search'] != "" ){
		
		echo "para administrador busco por letra";
			
			echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
				echo "<tr height='40px'><td></td></tr>";
				echo "<tr>";
					echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
				echo "</tr>";
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' name='Encabezado'>";		
				echo"<tr height='80px'> </tr>";
				///Titulo 
				echo"<tr>";
					echo"<td align='center' id='titulo1' width='700px'>";
						echo "Acceso Autorizado";
					echo"</td>";
				echo"</tr>";
		
				if($categoriaUsr == "Administrador"){
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>".$imprimeCiudad."</font>";
						echo"</td>";
					echo"</tr>";
				}
				
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
			//echo"<tr height='100'> </tr>";		
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
						
						echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
							include("../navegacion_banana.php");
						echo "</table>";

					echo "</td>";
				echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>";
			
			//BUSQUEDA DE PERSONAL
			echo"<table border='0' align='center' name='menuLetras'>";
			
				echo"<tr style='vertical-align:center;'>";
					echo"<td colspan='15' align='right' > ";
						echo"<input type='text' name='searchName' autocomplete='on'>";
					echo"</td>";
					echo"<td colspan='11' align='left'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30'> </tr>";
				
				echo"<tr id='titulo3Azul'>";
					for($i='A';$i!='AA';$i++){
					echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal2.php?search=".$i."&ciudad=$ciudadFiltro'>".$i."</a> ";
					echo"</td >";
				}
				
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' name='menuLetras' width='800'>";
			
				echo "<tr>";
				//CONDICION PARA VER TODO
					echo "<td align='left' id='breadcrumbs'> Filtrar por ciudad </td>";
					
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='breadcrumbs' valign='top' width='50'>";
					///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					echo"<select name='ciudad' size='1'>";
						echo "<option value=''>Seleccionar..</option>";
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudadess = $p[1];
									$cdValors  = $p[0];
															  
									if($ciudadFiltros == ""){
										echo"<option value='".$cdValors."'>".$ciudadess."</option>";
									}else{
										 echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
										 echo"<option value='".$cdValors."'>".$ciudadess."</option>";
											
									}			
								}
						echo"</select>";
					/*
						echo"<select name='ciudad' size='1'>";
						if($ciudadFiltro == ""){
							echo "<option value=''>Seleccionar..</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						}else{
							echo "<option value='$ciudadFiltro'>".$imprimeCiudad."</option>";
							for($a = 1; $a <= 6; $a++){
								if(in_array($cdValor[$a],$ciudadesDisponibles)){
									echo"<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
								}
							}
						
						}
						echo"</select>";*/
					echo"</td>";
				
					echo"<td align='left' width='50'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' height='20' width='70'></td>";
					
					//CONDCION PARA ALTA
					echo"<td align='right' width='700'>
						<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";			
			echo"</table>";
			
			//RESULTADO DE BUSQUEDA POR LETRA APELLIDO PATERNO
			$search= $_GET['search'];
			$s = $INTRANET->execute("SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre 
			FROM SGI_Empleados WHERE LEFT (xt_ApellidoPaterno,1)  LIKE '%$search%' AND xt_ciudad='$ciudadFiltro' ORDER BY xt_ApellidoPaterno ASC");
			$num = $s->recordCount();
			echo"<table border='0' align='center' name='busquedaPersonal2'>";
					if($num>0)
						{
						
						while($r = $s->fetchRow()){
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'> <a id='iconosTexto' style='text-decoration:none;' href='Personal/fichaPersonal.php?ID=$r[0]'> $r[1] $r[2] $r[3] </a> </td>";
				echo "</tr>";
				
						}
					}else{
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'><i> No se encontraron resultados. </i></td>";
						echo "</tr>";
						
					}
				echo"<tr height='30'> </tr>";
			echo"</table>";
			
			echo"<table border='0' align='center' width='800'>";
			
				echo"<tr height='40'> </tr>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				echo"<tr height='40'> </tr>";
			echo"</table>";
		
	}
}// TERMINA CASO ADMINISTRADOR

	echo "</form>";
echo "</div>";

?>
</body>
</html>
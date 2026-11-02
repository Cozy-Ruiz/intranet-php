<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp="ModificaPassword.php";
require_once("../ConexionDBT.php");
require_once('../compruebaUsuario.php');
error_reporting(E_PARSE);

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='configuraciones.php' id='breadcrumbs'>Configuraciones</a>";

$passA1 = $_POST['actual'];
$error 	= $_GET['wrong'];

function validar_clave($clave){
	
	$error_clave = "";
	
   if(strlen($clave) < 8){
	   
      $error_clave = "La contraseña debe tener al menos 8 caracteres";
	  return $error_clave;
	  
   }
   
   if(strlen($clave) > 16){
	   
      $error_clave = "La contraseña no puede tener más de 16 caracteres";
	  return $error_clave;
	  
   }
   
   if (!preg_match('`[a-z]`',$clave)){
	   
      $error_clave = "La contraseña debe tener al menos una letra minúscula";
	  return $error_clave;
	  
   }
   
   if (!preg_match('`[A-Z]`',$clave)){
	   
      $error_clave = "La contraseña debe tener al menos una letra mayúscula";
	  return $error_clave;
	  
   }
   
   if (!preg_match('`[0-9]`',$clave)){
	   
      $error_clave = "La contraseña debe tener al menos un caracter numérico";
	  return $error_clave;
	  
   }
   
   $claveNoValida1 = "escalante";
   $claveNoValida2 = "mhne159";
   $clavemin = strtolower($clave);
   $primerComp = strrpos($clavemin, $claveNoValida1);
   $segundaComp = strrpos($clavemin, $claveNoValida2);
   
   if (($primerComp !== FALSE) || ($segundaComp !== FALSE)){
	   
	  $error_clave = "La contraseña no debe contener ese patrón";
	  return $error_clave;
	  
   }
   
   return $error_clave;
   
} 

if(($passA1 == "") && ($error == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8">
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <title>Modificar Contraseña</title>
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
                </head>
                <body>
    
    <?php
	
	echo "<div id='wrapper' align='center'>";
		echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
			echo "<tr height='40px'><td></td></tr>";
			echo "<tr>";
				echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
			echo "</tr>";
			echo "<tr height='20px'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' name='Encabezado'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Modifica Contraseña";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10'><td></td></tr>";
			
			echo "<tr>"; 
				echo "<td align='center' valign='top' height='20px'>";
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
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
		/*echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
			echo "<tr>";
				echo "<td align='center'>";
				
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
		echo "</table>";
		
		echo "<table border='0' align='center'>";
			echo "<tr height='70'><td></td></tr>";
		echo "</table>";
	
		echo "<form action='ModificaPassword.php' method='post'>";
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' width='480px' id='fichaRef'>";
						echo "Cada seis meses recibirás un recordatorio para cambiar tu contraseña";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td align='center' id='fichaRef'>";
						echo "<b>Contraseña actual:</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "<input type='password' name='actual' placeholder='Contraseña' autocomplete='off'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto3'>";
						echo "La contraseña deberá tener:<br>";
						echo " -Entre 8 y 16 caractéres.<br>";
						echo " -Al menos una letra mayúscula.<br>";
						echo " -Al menos una letra minúscula.<br>";
						echo " -Al menos un número.<br><br>";
						echo "Por ejemplo: Mhne159#<br>";
						echo "<i>Nota: No usar la contraseña de ejemplo o alguna variación.</i>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td align='center' id='fichaRef'>";
						echo "<b>Nueva Contraseña:</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "<input type='password' name='passM1' placeholder='Nueva contraseña'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td align='center' id='fichaRef'>";
						echo "<b>Repetir Contraseña:</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "<input type='password' name='passM2' placeholder='Nueva contraseña'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='80px'>";
					echo "<td align='center'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</form>";
	echo "</div>";
	
} else if(($passA1 != "") && ($error == "")){
	
	$passwordBase = $INTRANET->getOne("SELECT xt_password FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
	
	if($passA1 == $passwordBase){
		
		$passModificado1 = $_POST['passM1'];
		$passModificado2 = $_POST['passM2'];
		
		if($passModificado1 == $passModificado2){
			
			$mensajeError = validar_clave($passModificado1);
			
			if($mensajeError == ""){
			
				$horaActual = date('Y-m-d H:i:s',time() + 2191 );
				@$ip = getenv(REMOTE_ADDR);
				
				if($INTRANET->Execute("UPDATE IntranetGEA_USUARIOS SET xt_password = '$passModificado2', xd_fechaActualizado = '$horaActual', 
									   xt_ipActualizado = '$ip', xd_fechaCambioPass = '$horaActual' WHERE kp_usuario = '$usuarioId' ")){
						
					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
									<meta charset="utf-8">
                                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
									<title>Modificar Contraseña</title>
									<?php
									if($estiloUsuario == 1){
										echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
									}else if($estiloUsuario == 2){
										echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
									}
									?>
								</head>
								<body>
									<div id='wrapperPopUp'>
										<table align='center' border='0'>
											<tr height='50px'> </tr>
											
											<tr>
												<td align='center'><b id='tituloBigAzul'>Contraseña modificada éxitosamente.</b></td>
											</tr>
											
											<tr height='100px'> </tr>
											
											<tr>
												<td align='center' id='titulo12'>
													<a href='../Home.php'>
														<input type='image' src='../Imagenes/ICN_BotonOk.png' width='80' height='29'>
													</a>
												</td>
											</tr>
											
										</table>
									</div>
					<?php
					
				} else{
					
					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
									<meta charset="utf-8">
									<title>Modificar Contraseña</title>
                                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
									<?php
									if($estiloUsuario == 1){
										echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
									}else if($estiloUsuario == 2){
										echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
									}
									?>
								</head>
								<body>
									<div id='wrapperPopUp'>
										<table align='center' border='0'>
											<tr height='50px'> </tr>
											
											<tr>
												<td align='center'><b id='tituloBigAzul'>Error de actualizacion.</b></td>
											</tr>
											
											<tr height='100px'> </tr>
											
											<tr>
												<td align='center' id='titulo12'>
													<a href='../Home.php'>
														<input type='image' src='../Imagenes/ICN_BotonOk.png' width='80' height='29'>
													</a>
												</td>
											</tr>
											
										</table>
									</div>
					<?php
					
				}
				
			} else{
				
				?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta charset="utf-8">
                                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                                <title>Modificar Contraseña</title>
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
                            </head>
                            <body>
                
                <?php
                
                echo "<div id='wrapper' align='center'>";
                    echo "<table border='0' align='center' name='Encabezado'>";
                        echo "<tr>";
                            echo "<td align='center' id='titulo1'>";
                                echo "Modifica Contraseña";
                            echo "</td>";
                        echo "</tr>";
						
                        echo "<tr height='10'><td></td></tr>";
			
						echo "<tr>"; 
							echo "<td align='center' valign='top' height='20px'>";
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
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
						echo "<tr>";
							echo "<td align='center'>";
							
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
								<?php
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center'>";
						echo "<tr height='70'><td></td></tr>";
					echo "</table>";
                
                    echo "<form action='ModificaPassword.php' method='POST'>";
                        echo "<table border='0' align='center'>";
                            echo "<tr>";
                                echo "<td align='center' width='600px' id='fichaRef'>";
                                    echo "Cada seis meses recibirás un recordatorio para cambiar tu contraseña";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr height='20px'> </tr>";
                            
                            echo "<tr>";
                                echo "<td align='center' id='iconosTexto2'>";
                                    echo "<b>Error: ".$mensajeError.".</b>";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr height='20px'> </tr>";
                            
                            echo "<tr>";
                                echo "<td align='center' id='fichaRef'>";
                                    echo "<b>Contraseña actual:</b>";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr>";
                                echo "<td align='center'>";
                                    echo "<input type='password' name='actual' placeholder='Contraseña' autocomplete='off'>";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr height='20px'> </tr>";
										
							echo "<tr>";
								echo "<td id='iconosTexto3'>";
									echo "La contraseña deberá tener:<br>";
									echo " -Entre 8 y 16 caractéres.<br>";
									echo " -Al menos una letra mayúscula.<br>";
									echo " -Al menos una letra minúscula.<br>";
									echo " -Al menos un número.<br><br>";
									echo "Por ejemplo: Mhne159#<br>";
									echo "<i>Nota: No usar la contraseña de ejemplo o alguna variación.</i>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='20px'><td></td></tr>";
							
                            echo "<tr>";
                                echo "<td align='center' id='fichaRef'>";
                                    echo "<b>Nueva Contraseña:</b>";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr>";
                                echo "<td align='center'>";
                                    echo "<input type='password' name='passM1' placeholder='Nueva contraseña'>";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr height='20px'> </tr>";
                            
                            echo "<tr>";
                                echo "<td align='center' id='fichaRef'>";
                                    echo "<b>Repetir Contraseña:</b>";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr>";
                                echo "<td align='center'>";
                                    echo "<input type='password' name='passM2' placeholder='Nueva contraseña'>";
                                echo "</td>";
                            echo "</tr>";
                            
                            echo "<tr height='80px'>";
                                echo "<td align='center'>";
                                    echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
                                echo "</td>";
                            echo "</tr>";
                            
                        echo "</table>";
                        
                    echo "</form>";
                echo "</div>";
				
			}
			
		} else{
			
			header("Location: ModificaPassword.php?wrong=1");
			
		}
		
	} else{
		
		header("Location: ModificaPassword.php?wrong=1");
		
	}
	
} else if($error == 1){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8">
                    <title>Modificar Contraseña</title>
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
	
	echo "<div id='wrapper' align='center'>";
		echo "<table border='0' align='center' name='Encabezado'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "<font>Modifica Contraseña</font>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10'><td></td></tr>";
			
			echo "<tr>"; 
				echo "<td align='center' valign='top' height='20px'>";
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
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
			echo "<tr>";
				echo "<td align='center'>";
				
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
					<?php
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
			echo "<tr height='70'><td></td></tr>";
		echo "</table>";
	
		echo "<form action='ModificaPassword.php' method='POST'>";
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' width='600px' id='fichaRef'>";
						echo "Cada seis meses recibirás un recordatorio para cambiar tu contraseña";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'> </tr>";
				
				echo "<tr>";
					echo "<td align='center' id='iconosTexto2'>";
						echo "<b>Error: Una de las contraseñas no es válida.</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'> </tr>";
				
				echo "<tr>";
					echo "<td align='center' id='fichaRef'>";
						echo "<b>Contraseña actual:</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "<input type='password' name='actual' placeholder='Contraseña' autocomplete='off'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'> </tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto3'>";
						echo "La contraseña deberá tener:<br>";
						echo " -Entre 8 y 16 caractéres.<br>";
						echo " -Al menos una letra mayúscula.<br>";
						echo " -Al menos una letra minúscula.<br>";
						echo " -Al menos un número.<br><br>";
						echo "Por ejemplo: Mhne159#<br>";
						echo "<i>Nota: No usar la contraseña de ejemplo o alguna variación.</i>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td align='center' id='fichaRef'>";
						echo "<b>Nueva Contraseña:</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "<input type='password' name='passM1' placeholder='Nueva contraseña'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='20px'> </tr>";
				
				echo "<tr>";
					echo "<td align='center' id='fichaRef'>";
						echo "<b>Repetir Contraseña:</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "<input type='password' name='passM2' placeholder='Nueva contraseña'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='80px'>";
					echo "<td align='center'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
			echo "</table>";
			
		echo "</form>";
	echo "</div>";
	
}

?>
		</body>
	</html>
<?php

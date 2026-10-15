<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?PHP
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp="tableroPersonal.php";
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acceso Autorizado</title>
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
<?PHP
$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a> <a href='comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna</a>";

echo"<div id='wrapperFicha' align='center'>";
	echo "<form name='tableroEmpleado' method='POST' action='busquedaPersonal.php'>";	
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
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
		
		//BUSQUEDA DE PERSONAL
		echo"<table border='0' align='center' name='menuLetras'>";
		
			echo"<tr style='vertical-align:center;'>";
				echo"<td colspan='15' align='right' > ";
					echo"<input type='text' name='searchName' autocomplete='on'>";
				echo"</td>";
				echo"<td colspan='11' align='left'>";
					echo"<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'> ";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='30'> </tr>";
			
			echo"<tr id='titulo3Azul'>";
				echo"<td align='center' width='35' >";
						echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=a'> A </a> ";
				echo"</td >";
				echo"<td align='center' width='35' >";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=b'> B </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=c'> C </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=d'> D </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=e'> E </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=f'> F </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=g'> G </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=h'> H </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=i'> I </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=j'> J </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=k'> K </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=l'> L </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=m'> M </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=n'> N </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=o'> O </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=p'> P </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=q'> Q </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=r'> R </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=s'> S </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=t'> T </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=u'> U </a>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=v'> V </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=w'> W </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=x'> X </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=y'> Y </a>";
				echo"</td>";
				echo"<td align='center' width='35'>";
					echo "<a id='titulo3Azul' style='text-decoration:none;' href='busquedaPersonal.php?search=z'> Z </a>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='30'> </tr>";
			
			echo "<tr>";
				echo "<td id='nota_al_pie' colspan='25' align='left'> <a id='nota_al_pie' style='text-decoration:none;' href='busquedaPersonal.php?search= '> Ver todo </a> </td>";
				echo"<td align='right' width='20'>
					<a href='Personal/altaPersonal.php' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=600,scrollbars=yes')\"> 
					<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='26'></td>";
			echo "</tr>";			
		echo"</table>";
		
	echo "</form>";
echo "</div>";
?>
</body>
</html>
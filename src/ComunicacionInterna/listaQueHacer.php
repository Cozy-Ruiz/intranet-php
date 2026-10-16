<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam 
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='listaQueHacer.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Qué hacer</title>
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
$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna</a>";

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
	
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";
		
		echo "<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Qué hacer en caso de:</font>";
			echo"</td>";
		echo"</tr>";
			echo"<tr height='10'> </tr>";
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
                                    	<a href='../ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'>
                                        	Solicitudes
                                        </a>
                                    </li>
                                     <li>
                                    	<a href='../ComunicacionInterna/solicitudesBacklog/tableroQuejas.php' id='breadcrumbs'>
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
	
	echo "<table border='0' align='center' name='Cuerpo'>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='800'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0070' id='manualVinculo'>Plan de contingencia y/o emergencia de inundación</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0071' id='manualVinculo'>Plan de contingencia y/o emergencia de erupción volcánica</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0072' id='manualVinculo'>Plan de contingencia y/o emergencia de sismo</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0073' id='manualVinculo'>Plan de contingencia y/o emergencia de incendio</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0074' id='manualVinculo'>Plan de contingencia y/o emergencia de huracán</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov3.php?id=0228' id='manualVinculo'>Atención urgente a falla de sistemas</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0267' id='manualVinculo'>Plan de contingencia y/o emergencia extorsión o fraude</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0272' id='manualVinculo'>Plan de contingencia y/o emergencia de mercancías prohíbidas</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0277' id='manualVinculo'>Plan de contingencia y/o emergencia de ataque cibernético</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0295' id='manualVinculo'>Plan de contingencia y/o emergencia de tornado</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0296' id='manualVinculo'>Plan de contingencia y/o emergencia de secuestro</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0437' id='manualVinculo'>Plan de contingencia y/o emergencia de robo de mercancía</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0531' id='manualVinculo'>Plan de contingencia y/o emergencia de amenaza de bomba</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0533' id='manualVinculo'>Plan de contingencia y/o emergencia de actos de terrorismo</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0534' id='manualVinculo'>Plan de contingencia y/o emergencia de actos de falla de suministro eléctrico</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0535' id='manualVinculo'>Plan de contingencia y/o emergencia de accidentes</a>";
			echo "</td>";
		echo "</tr>";



		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0536' id='manualVinculo'>Plan de contingencia y/o emergencia de suspensión o cancelación de patente</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0537' id='manualVinculo'>Plan de contingencia y/o emergencia de cierre de aduana</a>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='center' id='titulo2Blanco'>";
				echo "<a href='../SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=0538' id='manualVinculo'Plan de contingencia y/o emergencia de cierre de vialidades</a>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='50'> </tr>";
	echo "</table>";


echo"</div>";
?>
</body>
</html>
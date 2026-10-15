<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp='fichaActividadRequerimiento.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Actividad</title>
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

$idRequerimiento = $_GET['id'];

$breadcrumb = "<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a> 
			<a href='Procesos.php' id='breadcrumbs'> Inventario de procesos / </a> <a href='tableroProcesos.php' id='breadcrumbs'> Tablero Inventario de Procesos </a>";

echo "<div id='wrapperFicha'>";
	
    echo "<table border='0' align='center' name='Encabezado' width='800px'>";
    
        echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
        echo "</tr>";
        
        echo"<tr height='80px'> </tr>";
        
        echo "<tr>";
            echo"<td align='center' id='titulo1'>";
                echo "<font>Actividad</font>";
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
		
		$s = $INTRANET -> Execute("SELECT xt_nombre FROM SGI_Procesos_Actividades_Funcionalidades WHERE kp_funcionalidadID = $idRequerimiento");
		while ($r = $s -> fetchRow ()){
			
			 $nombreRequerimiento = $r[0];
		}
	//CUERPO FICHA
	echo "<table border='0' align='center' width='700px'>";
		echo"<tr>";
			echo "<td id='iconosTexto2' align='left' width='350px'><b>".$clave."</b></td>";
			echo "<td id='iconosTexto2' align='right' width='350px'><b>".$fecha."</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'> </td>";
		echo "</tr>";
		
		echo"<tr height='30'><td colspan='2'> </td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td> </td>";
			
			echo "<td id='iconosTexto' colspan='2' align='left'><b>".$nombreRequerimiento."</b></td>";
			
			echo "<td id='iconosTexto' align='right'>";
			
				if($ruta != ""){
					echo"<a href='downloadBoletin.php?file=".$ruta."'><img src='../Imagenes/ICN_Archivo.png'></a>";
				}
			
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='4'> </td></tr>";
		
		echo "<tr>";
			echo "<td width='20px'> </td>";
			echo "<td width='20px'> </td>";
			echo "<td width='610px' align='justify' id='fileItem'>".$descripcion."</td>";
			echo "<td width='50px'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	//Despliegue de pdf
	if($ruta != ""){
		if(substr($ruta, -4) == ".pdf"){
			echo "<br><br>";
			echo "<div id='wrapperBoletin'>";
                echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents("Boletines/".$ruta))."'\" type='application/pdf'  width='950px' height='700px' align='left'>";
					echo "<p>";
						echo "Si este mensaje aparece su navegador no soporta el plugin para el PDF.";
					echo "</p>";
				echo "</object>";
			echo "</div>";
			echo "<br><br>";
		} 
	}
	
	echo "<table border='0' align='center' width='700px'>";
	
		echo "<tr height='20px'><td> </td></tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='700px'></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs' width='700px'><i><a href='imprimeFichaBoletin.php?id=$boletinID' id='breadcrumbs'> Imprimir </a></i></td>";
		echo "</tr>";
		
		echo "<tr height='50px'><td> </td></tr>";
		
	echo "</table>";

?>
    	</body>
    </html>
<?php

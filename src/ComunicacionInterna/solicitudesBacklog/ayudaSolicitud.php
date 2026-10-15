<?php error_reporting(0); ?>
<?php
$nombrephp='ayudaSolicitud.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
/*require_once("MailSolicitudAsignar.php");
require_once("MailSolicitudRevisar.php");
require_once("MailSolicitudRechazar.php");*/

//$solicitudID = $_GET['id'];

// save old value
/*
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
putenv("LD_LIBRARY_PATH=$saved");*/

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes</a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
        <title>Ayuda Solicitud</title>
		<?php
		if($estiloUsuario == 1){
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>
            <?php
		}else if($estiloUsuario == 2){
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>
            <?php
		}
		?>
        
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript">;
			$(function(){
				$(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
				 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
				 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
				
				 });
			});
        </script>
        
        <script type="text/javascript">
            function reCargarPadre(){
                opener.location.reload();
                window.close();
            }
        </script>
        
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


echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Solicitud</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
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
                            	<a href='../comunicacionInterna.php' id='breadcrumbs'>
                                	Comunicación Interna
                                </a><br />
                                
								<ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../TableroBoletines.php' id='breadcrumbs'>
                                        	Boletines
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../listaQueHacer.php' id='breadcrumbs'>
                                        	Qué hacer
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../tableroSolicitudesyQuejas.php' id='breadcrumbs'>
                                        	Solicitudes y Quejas
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../busquedaPersonal.php' id='breadcrumbs'>
                                        	Acceso Autorizado
                                        </a>
                                    </li>
                                </ul>
                            
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'>
                                	Gestión Integral
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../../SistemaGestionIntegral/Normas.php' id='breadcrumbs'>
                                        	Normas
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=ISO' id='breadcrumbs'>
                                                    ISO
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=NMX' id='breadcrumbs'>
                                                    NMX
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC' id='breadcrumbs'>
                                                    NEEC
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../../SistemaGestionIntegral/manuales.php' id='breadcrumbs'>
                                        	Manuales
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-MC' id='breadcrumbs'>
                                                	Manual de Gestión Integral
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-CDR' id='breadcrumbs'>
                                                    Manual de Control de Documentos y Registros
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-AI' id='breadcrumbs'>
                                                    Manual de Auditorías Internas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-CC' id='breadcrumbs'>
                                                    Manual del Comité de Calidad
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-DG' id='breadcrumbs'>
                                                    Manual de Dirección General
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-ADM' id='breadcrumbs'>
                                                    Manual de Administración
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-RH' id='breadcrumbs'>
                                                    Manual de Recursos Humanos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-TI' id='breadcrumbs'>
                                                    Manual de Tecnologias de la Información
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Documento.php?manual=GE-OPE' id='breadcrumbs'>
                                                    Manual de Operaciones
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'>
                                        	Módulos del SGI
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../../SistemaGestionIntegral/Riesgos.php' id='breadcrumbs'>
                                                	Administración de Riesgos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'>
                                                    Reuniones y Acuerdos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'>
                                                    Acciones Preventivas y Correctivas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/tableroAuditorias.php' id='breadcrumbs'>
                                                    Auditorías
                                                </a>
                                            </li>
                                            <!-- -->
                                            <li>
                                            	<a href='../../SistemaGestionIntegral/Procesos.php' id='breadcrumbs'>
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
                            	<a href='../../Aplicaciones/aplicaciones.php' id='breadcrumbs'>
                                	Aplicaciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../../Aplicaciones/operaciones.php' id='breadcrumbs'>
                                        	Operaciones
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../../AdministracionProyectos/admonPro.php' id='breadcrumbs'>
                                        	Administración de Proyectos
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../../Registros/Registros.php' id='breadcrumbs'>
                                	Registros
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                    	<a href='../../Registros/TableroVisitas2.php' id='breadcrumbs'>
                                        	Visitas
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../../Configuraciones/configuraciones.php' id='breadcrumbs'>
                                	Configuraciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../../Configuraciones/ModificaPassword.php' id='breadcrumbs'>
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

		
//CUERPO SOLICITUD
	echo "<table border='0' align='left' width='700'>";
		echo"<tr>";
			echo"<td id='titulo2' style='font-size:22px;'>";
				echo "<b>¿Qué tipo de solicitud necesitas?</b>";
			echo"</td>";
		echo"</tr>";

	echo "</table>";
	
	echo "<table border='0' align='left' width='700'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";

    //ADMINISTRATIVA

    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo "<td style='font-size:20px;width:550px;' >Administrativa</td>";
            echo "<td><a href='altaSolicitudQuejaPopUpv2.php'><img src='../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
        echo "</tr>";
        echo"<tr height='20'></tr>";
    echo "</table>";
	
    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las relacionadas con peticiones propias de los procesos administrativos y
                            de recursos humanos de la organización. Por ejemplo, asuntos relacionados
                            con los inmuebles o instalaciones; petición de recursos.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='15'></tr>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las solicitudes que normalmente atienden las Gerencias de
                            Administración, Calidad y Jurídica.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='30'></tr>";
    echo "</table>";

    //SOPORTE TECNICO

    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo "<td style='font-size:20px;width:550px;' >Soporte técnico</td>";
            echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/fichaCapturaSoporteTecnico.php?usuario=".base64_encode($usuarioId)."'><img src='../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
        echo "</tr>";
        echo"<tr height='20'></tr>";
    echo "</table>";
    
    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las relacionadas con la infraestructura informática y de comunicación. Por
                            ejemplo, asuntos relacionados con las computadoras (instalación de software,
                            antivirus, respaldos); telecomunicaciones (lentitud de Internet, problemas con
                            la telefonía); elaboración de inventarios; impresoras.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='15'></tr>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las solicitudes que normalmente atiende el personal de Intercomm";
            echo "</td>";            
        echo "</tr>";
        echo "<tr height='30'></tr>";
    echo "</table>";

    //MANTENIMIENTO DE SISTEMAS

    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo "<td style='font-size:20px;width:550px;' >Mantenimiento de Sistemas</td>";
            echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/fichaCapturaMantenimientoSistemas.php?usuario=".base64_encode($usuarioId)."'><img src='../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
        echo "</tr>";
        echo"<tr height='20'></tr>";
    echo "</table>";
    
    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las relacionadas con fallas en las funcionalidades de un sistema. Por
                            ejemplo, una agrupación que no ocurre, la generación de un COVE que no
                            funciona, un reporte que no se genera adecuadamente.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='15'></tr>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las solicitudes que normalmente atienden Abel, Cuauhtémoc y Alberto Ramírez";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='30'></tr>";
    echo "</table>";

    //DESARROLLO DE NUEVAS FUNCIONALIDADES

    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo "<td style='font-size:20px;width:550px;' >Desarrollo de nuevas funcionalidades</td>";
            echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/fichaCapturaDesarrolloFuncionalidad.php?usuario=".base64_encode($usuarioId)."'><img src='../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
        echo "</tr>";
        echo"<tr height='20'></tr>";
    echo "</table>";
    
    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las peticiones para incorporar capacidades previamente inexistentes en
                            los sistemas institucionales, como por ejemplo, la creación de un nuevo
                            reporte; un nuevo cálculo de impuestos o variables; una visualización de datos
                            nueva; un complemento a un flujo de archivos; interacción con sistemas desde
                            un nuevo medio de comunicación (telefonía móvil).";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='15'></tr>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las solicitudes que normalmente atiende el equipo de Desarrollo.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='30'></tr>";
    echo "</table>";

    //DISTRIBUCION DE ARCHIVOS

    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo "<td style='font-size:20px;width:550px;' >Distribución de archivos</td>";
            echo "<td><a href='fichaCapturaEnvioArchivos.php'><img src='../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
        echo "</tr>";
        echo"<tr height='20'></tr>";
    echo "</table>";
    
    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las peticiones para incluir a uno o más individuos al esquema institucional
                            de distribución de archivos.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='15'></tr>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las solicitudes que normalmente atienden Richard y Alberto.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='30'></tr>";
    echo "</table>";

    //ALTAS Y BAJAS DE USUARIOS
		echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo "<td style='font-size:20px;width:550px;' >Alta y baja de accesos y permisos</td>";
            echo "<td><a href='AltaUsuario/altaBaja_Usuario.php?usuario=".base64_encode($usuarioId)."'><img src='../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
        echo "</tr>";
        echo"<tr height='20'></tr>";
    echo "</table>";
	
    
    echo "<table border='0' align='left' width='700'>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las peticiones para otorgar o eliminar el acceso de una persona a
                            cualquiera de los sistemas institucionales, así como la modificación de lo que
                            un usuario puede hacer en ellos.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='15'></tr>";
        echo "<tr>";
            echo  "<td width='50'></td>";
            echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                    echo "Son las solicitudes que normalmente atienden Lizbeth y Alberto.";
            echo "</td>";
        echo "</tr>";
        echo "<tr height='30'></tr>";
    echo "</table>";

    //NUEVO PROYECTO
    
    if($usuarioId == 'Rodrigo_Romo'){
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td style='font-size:20px;width:550px;' >Funcionalidades de Proyecto</td>";
                echo "<td><a href='fichaCapturaProyecto.php'><img src='../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
            echo "</tr>";
            echo"<tr height='20'></tr>";
        echo "</table>";
    }	
	echo "<br>";
	echo "<br>";
	
	echo "<table border='0' align='left' width='700'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='70'> </tr>";
	echo "</table>";
	
	echo "<br>";
	echo "<br>";
echo "</div>";
?>
</body>
</html>
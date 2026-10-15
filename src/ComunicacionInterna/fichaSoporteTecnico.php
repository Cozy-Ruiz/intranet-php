<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
$nombrephp='fichaSolicitud.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
/*require_once("MailSolicitudAsignar.php");
require_once("MailSolicitudRevisar.php");
require_once("MailSolicitudRechazar.php");*/

$solicitudID = $_GET['id'];

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

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='tableroSolicitudesyQuejas.php' id='breadcrumbs'> Solicitudes</a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
        <title>Ficha de Soporte T&eacute;cnico</title>
		<?php
		if($estiloUsuario == 1){
			?>
			<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>
            <?php
		}else if($estiloUsuario == 2){
			?>
			<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>
            <?php
		}
		?>
        
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
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
        <script type="text/javascript">
        function PopUp(){
            window.open("cierreSoporteTecnico.php","_blank", "toolbar=yes, scrollbars=no, resizable=yes, top=500, left=500,width=800, height=800");
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
				echo "<font>Soporte T&eacute;cnico</font>";
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

		
//CUERPO SOLICITUD
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2' width='450'>";
				echo "<b>GE-B-DF-15-272</b>";
			echo"</td>";
			echo"<td align='right' id='titulo2' width='250'>";
			echo "Estatus: Atendida";//Aqui va el estatus de la solicitudID
			echo"</td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td width='25px;'> </td>";
			echo "<td id='iconosTexto' align='left'><b>Aenean eu leo quam Pellentesque ornare</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";        
	echo "</table>";

    echo "<table border='0' align='center' width='700'>";
        echo "<tr>";
            echo "<td width='60px;'> </td>";
             echo "<td align='justify' id='fileItem'>Has voluptatum scriptorem ad. Fugit luptatum scribentur mei
                        cu. Pro habemus civibus delicatissimi ut. Qui quot tamquam
                        impedit et, sapientem prodesset percipitur ei vim. Quot ullum
                        aliquando vim ea, probatus eleifend et per, sed alii verterem
                        definitionem te</td>";
            echo "<td width='40px;' align = 'center' valign = 'top'><a href='#' style='margin-top:-5px;'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
        echo "</tr>";
    echo "</table>";
    echo "<br><br>";

    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo"<td align='left' id='titulo2'>";
                echo "<b>Solicitante</b>";
            echo"</td>";
            echo "<td width='25px;'> </td>";
            echo "<td width='25px;'> </td>";
            echo"</td>";
        echo"</tr>";        
    echo "</table>";

    echo "<table border='0' align='center' width='700'>";
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='3'></td>";
        echo "</tr>";
        echo "<tr height='10px;'></tr>";
        echo "<tr>";
            echo "<td width='25px;'> </td>";
            echo "<td id='iconosTexto' align='left' colspan='2'>[Nombre del usuario]</td>";
        echo "</tr>";
    echo "</table>";
	echo "<br><br>";

    echo "<br><br>";
    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo"<td align='left' id='titulo2'>";
                echo "<b>PDR</b>";
            echo"</td>";
            echo "<td width='25px;'> </td>";
            echo "<td width='25px;'> </td>";
            echo"</td>";
        echo"</tr>";        
    echo "</table>";

    echo "<table border='0' align='center' width='700'>";
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='3'></td>";
        echo "</tr>";
        echo "<tr height='10px;'></tr>";
        echo "<tr>";
            echo "<td width='25px;'> </td>";
            echo "<td id='iconosTexto' align='left' colspan='2'>[Personal de Soporte T&eacute;cnico]</td>";
        echo "</tr>";
    echo "</table>";
    echo "<br><br>";

    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo"<td align='left' id='titulo2'>";
                echo "<b>Prioridad</b>";
            echo"</td>";
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='3'></td>";
        echo "</tr>";
            echo "<td width='25px;'> </td>";
        echo"</tr>";        
    echo "</table>";

    echo "<table border='0' align='center' width='700'>";
        echo "<tr>";
            echo "<td width='25px;'> </td>";
            echo "<td id='iconosTexto' align='left'>URGENTE</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td height='10px;'>";             
            echo"</td>";
        echo "</tr>";        
    echo "</table>";

      echo "<table border='0' align='center' width='700'>";
        echo "<tr>";
            echo "<td width='60px;'> </td>";
             echo "<td align='justify' id='fileItem'>Has voluptatum scriptorem ad. Fugit luptatum scribentur mei
                        cu. Pro habemus civibus delicatissimi ut. Qui quot tamquam
                        impedit et, sapientem prodesset percipitur ei vim. Quot ullum
                        aliquando vim ea, probatus eleifend et per, sed alii verterem
                        definitionem te</td>";
            echo "<td width='40px;' align = 'center'></td>";
        echo "</tr>";
    echo "</table>";
    echo "<br><br>";

    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo"<td align='left' id='titulo2'>";
                echo "<b>Seguimiento</b>";
            echo"</td>";
            echo "<td width='25px;'> </td>";
            echo "<td width='25px;'> </td>";
        echo"</tr>";  
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='3'></td>";
        echo "</tr>";      
    echo "</table>";
    echo "<br>";


    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo"<td align='left' width='100px;' style='font-size:15px;color:#007CBD;'>";
                echo "Status";
            echo"</td>";
            echo "<td align='left' style='font-size:15px;color:#007CBD;'>User</td>";
            echo "<td width='100px;' align='center' style='font-size:15px;color:#007CBD;'>Fecha</td>";
        echo"</tr>";  
        echo "<tr>";
            echo "<td width='25px;'> </td>";
            echo "<td id='titleBlueLineBottom' colspan='3'></td>";
        echo "</tr>"; 
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo"<td align='left' width='100px;' height='35px;' style='font-size:15px;'>";
                echo "Asignada";
            echo"</td>";
            echo "<td align='left' height='35px;' style='font-size:15px;'>[Solicitante]</td>";
            echo "<td width='200px;' align='center' height='35px;' style='font-size:15px;'>2015-11-22 14:28:00</td>";
        echo"</tr>";  
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo"<td align='left' width='100px;' height='35px;' style='font-size:15px;'>";
                echo "Atendida";
            echo"</td>";
            echo "<td align='left' style='font-size:35px;' height='15px;'><a href='javascript:void(0);' onclick='PopUp()'><img src='../Imagenes/ICN_BotonAzul.png'/></a></td>";
            echo "<td width='200px;' align='center' height='35px;' style='font-size:15px;'></td>";
        echo"</tr>";  
    echo "</table>";
    echo "<br><br><br><br>";


    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo"<td align='left' width='100px;' style='font-size:15px;color:#007CBD;'>";
                echo "Status";
            echo"</td>";
            echo "<td align='left' style='font-size:15px;color:#007CBD;'>User</td>";
            echo "<td width='100px;' align='center' style='font-size:15px;color:#007CBD;'>Fecha</td>";
        echo"</tr>";  
        echo "<tr>";
            echo "<td width='25px;'> </td>";
            echo "<td id='titleBlueLineBottom' colspan='3'></td>";
        echo "</tr>"; 
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo"<td align='left' width='100px;' height='35px;' style='font-size:15px;'>";
                echo "Asignada";
            echo"</td>";
            echo "<td align='left' height='35px;' style='font-size:15px;'>[Solicitante]</td>";
            echo "<td width='200px;' align='center' height='35px;' style='font-size:15px;'>2015-11-22 14:28:00</td>";
            echo"</td>";
        echo"</tr>";  
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo"<td align='left' width='100px;' height='35px;' style='font-size:15px;'>";
                echo "Atendida";
            echo"</td>";
            echo "<td align='left' style='font-size:15px;' height='15px;'>[Personal de Soporte]</td>";
            echo "<td width='200px;' align='center' height='35px;' style='font-size:15px;'>2015-11-22 14:28:00</td>";
        echo"</tr>";  
    echo "</table>";

    
    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo "<td width='100px;'></td>";
            echo"<td align='left' style='font-size:14px;color:#007CBD;'>";
                echo "Comentarios";
            echo"</td>";            
            echo "<td width='100px;'></td>";
        echo"</tr>";  
        echo "<tr>";
            echo "<td width='35px;'> </td>";
            echo "<td width='100px;'></td>";
            echo "<td id='titleBlueLineBottom' colspan='2'></td>";
        echo "</tr>";
        echo "<tr><td height='3px;'></td</tr>"; 
    echo "</table>";

    echo "<table border='0' align='center' width='700'>";
        echo"<tr>";
            echo "<td width='35px;'> </td>";
            echo "<td width='100px;' height='10px;'></td>";
            echo"<td align='justify' id='fileItem'>";
                echo "Has voluptatum scriptorem ad. Fugit luptatum
                        scribentur mei cu. Pro habemus civibus delicatissimi
                        ut. Qui quot tamquam impedit et, sapientem
                        prodesset percipitur ei vim. Quot ullum aliquando
                        vim ea, probatus eleifend et per, sed alii verterem
                        definitionem te.";
            echo"</td>";            
            echo "<td width='40px;'align = 'center' valign = 'top'><a href='#' style='margin-top:-5px;'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
        echo"</tr>";
         echo "<tr><td height='3px;'></td</tr>"; 
         echo "<tr>";
            echo "<td width='35px;'> </td>";
            echo "<td width='100px;'></td>";
            echo "<td id='titleBlueLineBottom' colspan='2'></td>";
        echo "</tr>";  
    echo"</table>";
    echo "<br><br>";
    echo "<table border='0' align='center' width='700'>";
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='2'></td>";
        echo "</tr>";        
        echo"<tr height='30'> </tr>";
    echo "</table>";
echo "</div>";
?>
</body>
</html>
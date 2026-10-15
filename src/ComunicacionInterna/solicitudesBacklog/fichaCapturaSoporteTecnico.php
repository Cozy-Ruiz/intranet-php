<?php error_reporting(0); ?>
﻿<!-- SCRIPT PARA MOSTRAR Y OCULTAR DE JUSTIFICACION DE EMERGECIA -->
<script type="text/javascript">
function activaJustificacionE(){
	

	var vJustificacionE=document.getElementById("justificacionE");
	var vJustificacionU=document.getElementById("justificacionU");
	
    if(vJustificacionU.style.display == 'block') {
    	vJustificacionU.style.display = 'none';
		 vJustificacionE.style.display = 'block';
    } else {
      vJustificacionE.style.display = 'block';
   	}
}
</script>

<!-- SCRIPT PARA MOSTRAR Y OCULTAR DE JUSTIFICACION DE URGENCIA -->
<script type="text/javascript">
function activaJustificacionU(){
	
	var vJustificacionE=document.getElementById("justificacionE");
	var vJustificacionU=document.getElementById("justificacionU");
    if(vJustificacionE.style.display == 'block') {
    	vJustificacionE.style.display = 'none';
		 vJustificacionU.style.display = 'block';
    } else {
      vJustificacionU.style.display = 'block';
   	}
}
</script>

<!-- SCRIPT PARA MOSTRAR Y OCULTAR DIV DE JUSTIFICACION -->

<script type="text/javascript">
function desactivaJustificacion(){
	
	var vJustificacionE=document.getElementById("justificacionE");
	var vJustificacionU=document.getElementById("justificacionU");
    if(vJustificacionU.style.display == 'block') {
    	vJustificacionU.style.display = 'none';
    } 
	
	if(vJustificacionE.style.display == 'block') {
    	vJustificacionE.style.display = 'none';
    } 
	
	
}
</script>


<?php
require_once("ConexionDBT.php");
require_once("FichaCapturaClass.php");

date_default_timezone_set("America/Mexico_City");

 $hoy = date('Y-m-d h:i:s');

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
$cdValor[6] = "LAR";

$usuarioId = $_GET['usuario'];
$estiloUsuario=$INTRANET->getOne("SELECT xn_estilo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

//echo "SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ";
$indice = 0;
$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='css/styleHomePage2.css'/>";
}
?>
        
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <script type="text/javascript" src="JS/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="JS/jquery-ui-1.8.16.custom.min.js"></script>
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


$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Comunicación Interna / </a> 
			<a href='Modulos.php' id='breadcrumbs'> Solicitudes </a>";
			
echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			//echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Soporte técnico</font>";
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
				
	
				//echo "<a href='$archivo' >Archivo</a>";
			
				?>
					<table border='0' align='center' id='breadcrumbs' style='border:1px solid #007cbd;'>
                        <tr>
                            <td valign='top'>
                                <a href='../../ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
                                    Comunicación Interna
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                        <a href='../../ComunicacionInterna/TableroBoletines.php' id='breadcrumbs'>
                                            Boletines
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../../ComunicacionInterna/listaQueHacer.php' id='breadcrumbs'>
                                            Qué hacer
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../../ComunicacionInterna/tableroSolicitudesyQuejas.php' id='breadcrumbs'>
                                            Solicitudes y Quejas
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../../ComunicacionInterna/busquedaPersonal.php' id='breadcrumbs'>
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

echo "<form name='form' action='fichaCapturaSoporteTecnico.php?usuario=$usuarioId'' method='POST'  enctype='multipart/form-data'>";		
//CUERPO SOLICITUD
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2' width='550'>";
				echo "DATOS GENERALES";
			echo"</td>";
			echo"<td align='right' id='iconosTexto2' width='150'>";
			//Aqui va el estatus de la solicitud
			echo"</td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Fecha</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' class='DatP' name='fecha'></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Grupo</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<select name='grupo'>";
					echo "<option value=''>Elegir......</option>";
						echo "<option value='GE'>GE</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Ciudad</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<select name='ciudad'>";
							echo "<option value='' selected='selected'>Elegir...</option>";	
							
							for($a = 1; $a <= 6; $a++){
								
								if(in_array($cdValor[$a], $ciudadesDisponibles)){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
									
								}
								
							} unset($a);
							
						echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>T&iacute;tulo</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='4' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<input type='text' name='titulo' style='width:80%;height:23px;' placeholder='Titulo'>";
				//echo "<textarea name='titulo' style='width:100%;height:23px;' placeholder='Titulo'></textarea>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Descripci&oacute;n</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='4' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<textarea name='descripcion' style='width:80%;height:70px;' placeholder='Descripcion'></textarea>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<br>";

	//Archivo
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo"<td align='left' id='titulo2' >";
				echo "Archivo";
			echo"</td>";
			echo "<td> </td>";
			echo"<td align='right' id='iconosTexto2' >";
			//Aqui va el estatus de la solicitud
			echo"</td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td width='15px'> </td>";
			echo "<td width='15px'> </td>";
			echo "<td id='titleBlueLineBottom'></td>";
			echo "<td width='50px'> </td>";
			echo "<td width='50px'> </td>";
		echo "</tr>";		
		echo"<tr height='30'> </tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td colspan='2'>";
				
					echo "<input type='file' name='archivo'>";
				
			echo "</td>";
			echo "<td> </td>";
			echo"<td align='right' id='iconosTexto2' >";
		echo "</tr>";
		echo"<tr height='30'> </tr>";
		echo "<tr>";
			echo "<td width='15px'> </td>";
			echo "<td width='15px'> </td>";
			echo "<td id='titleBlueLineBottom' ></td>";
			echo "<td width='50px'> </td>";
			echo "<td width='50px'> </td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<br>";

	echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Prioridad</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			?>
			<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='prioridad' onclick="desactivaJustificacion()" Value='Normal'>Normal</td>
            <?php
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			?>
			<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='prioridad' onclick="activaJustificacionU()" Value='Urgente'>Urgente</td>
            <?php
		echo "</tr>";
       
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Es necesario atender hoy mismo)</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			?>
			<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='prioridad' onclick="activaJustificacionE()" Value='Emergencia'>Emergencia</td>
            <?php
			
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Es necesario atender antes de una hora)</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='20px;'>";				
			echo"</td>";
		echo "</tr>";
		
		echo "</table>";
		
		//seccion de justificacion de emergencia
		
		echo "<div id='justificacionE'  style='display: none'>";
		echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='titulo2' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Justificaci&oacute;n:</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea style='width:80%;height:70px;' name='justificacion' placeholder='Justificacion de Emergencia'></textarea></td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
		//fin de seccion de justificacion
		
		
		//seccion de justificacion de urgencia
		
		echo "<div id='justificacionU'  style='display: none'>";
		echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='titulo2' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Justificaci&oacute;n:</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea style='width:80%;height:70px;' name='justificacion' placeholder='Justificacion de Urgencia'></textarea></td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
		//fin de seccion de justificacion
		
		
		
		
		
		
		
		
	
	echo "<br>";
	echo "<br>";
	echo "<table border='0' align='center' width='700'>";	
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30'> </tr>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td align='right'>";
			//echo "<input type=image src='images/go.gif' width='25' height='15>";
				echo "<input type='submit' name='Enviar' src = 'Imagenes/ICN_BotonAgregar.png'>";
					//echo "<img width='90' height='29' src = 'Imagenes/ICN_BotonAgregar.png'></img>";
				echo "</input>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
echo "</form>";
	echo "<br>";
	echo "<br>";
echo "</div>";
?>
</body>
</html>
<?php
if(isset($_POST['Enviar'])){
	$fecha = $_POST['fecha'];
	$grupo = $_POST['grupo'];
	$ciudad = $_POST['ciudad'];
	$titulo = $_POST['titulo'];
	$descripcion = $_POST['descripcion'];
	
	$extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
	
	$prioridad = $_POST['prioridad'];
	$justificacion = $_POST['justificacion'];
	
	$RESULTADO = fichaCaptura($usuarioId,"B","ST",$fecha,$grupo,$ciudad,"",$titulo,$descripcion,$_FILES['archivo']['tmp_name'],	$extension,$prioridad,$justificacion,"","",$INTRANET);
	echo $codigoSolicitud = $RESULTADO;
	//echo 'https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaSoporteTecnico.php?codigo='.$codigoSolicitud.'';
	if($codigoSolicitud != ''){
		
		
		//mando llamar a scrip para envio de correo 
		echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/mailST.php?codigo='.$codigoSolicitud.'&titulo='.urlencode($titulo).'&solicitante='.$usuarioId.'&descripcion='.urlencode($descripcion).'&fecha='.$hoy.'&prioridad='.$prioridad.'";</script>';

		/*echo '<script>window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaSoporteTecnico.php?codigo='.$codigoSolicitud.'";</script>';*/
	}
}

?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha del Carmen Abam Donoso
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'FichaAuditoriaModificar.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

 error_reporting(E_PARSE);

$id 		= $_GET['id'];
$terminar 	= $_GET['end'];

if($terminar == 1){
	
	$INTRANET->Execute("UPDATE SGI_Auditorias SET xt_status = 2 WHERE kp_auditoriaID = $id ");
	
	header("Location: FichaAuditoria.php?id=$id");
	
}

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroAuditorias.php' id='breadcrumbs'> Auditorías </a>";

$codigo = $INTRANET->getOne("SELECT xt_claveAuditoria FROM SGI_Auditorias WHERE kp_auditoriaID = $id AND xt_status = 2 ");
$tituloAuditoria = $INTRANET->getOne("SELECT xt_titulo FROM SGI_Auditorias WHERE kp_auditoriaID = $id AND xt_status = 2 ");

if($codigo != ""){
	
	$rutaP 		= $INTRANET->getOne("SELECT xt_ruta FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
	
	$programa 	= $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'PROGRAMA' ");
	
	$rutaI 		= $INTRANET->getOne("SELECT xt_ruta FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");
	
	$informe 	= $INTRANET->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Archivos WHERE kf_auditoriaID = $id AND xt_tipo = 'INFORME' ");
	
	$indice 		= 1;
	$issueID 		= NULL;
	$tituloIssue 	= NULL;
	$fechaIssue 	= NULL;
	$ruta 			= NULL;
	$claveIssue 	= NULL;
	
	$s = $INTRANET->Execute("SELECT kp_issueID, xt_titulo, xd_fecha, xt_ruta, xt_claveIssue FROM SGI_Auditorias_Issues WHERE kf_auditoriaID = $id ORDER BY xd_fecha DESC ");
	
	while($r = $s->fetchRow()){
		
		$issueID[$indice] 	= $r[0];
		$tituloIssue[$indice] 	= $r[1];
		$fechaIssue[$indice] 	= date('Y-m-d',  strtotime($r[2]));
		$ruta[$indice] 		= $r[3];
		$claveIssue[$indice] 	= $r[4];
		
		$indice++;
		
	} unset($r); unset($s);

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
				<title>Modificar Auditoría</title>
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

    echo "<div id='wrapperFicha' align='center'>";
        //echo "<form name='fichaAuditoriaModificar'>";
		echo "<table border='0' align='center'>";		
			echo "<tr height='80px'><td></td></tr>";
		///Titulo 
			echo "<tr>";
				echo "<td align='center' id='titulo1' width='700px'>";
					echo "Modificar Auditoría";
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
				
			//echo "<tr height='50px'><td></td></tr>";
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
		
		echo "<table border='0' align='center' width='700px'>";	
			echo "<tr height='50px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='4'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='4'><input type='text' name='titulo' value='$tituloAuditoria' size='66'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b>Plan de auditoría</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";

			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td colspan='2' id='textIntro'>";
				
					if($rutaP != ""){
						
						echo "<i>".$rutaP."</i> <a href='downloadAuditoria.php?file=".$rutaP."' ><img src='../Imagenes/ICN_Archivo.png'></a>";
						echo"<a href='fileReload.php?id=".$id."&tipo=PROGRAMA' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_Settings.png' width='15' height='15'> </img> </a> ";
						
					}else if($rutaP == ("" || NULL)){
					
						echo "<a href='AgregarArchivoAuditoriaPopUp.php?id=".$id."&tipo=PROGRAMA' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">
						<img src='../Imagenes/ICN_CargaDocumento.png' height='15' width='15'></a>";
					
					}
                                        
					
				echo "</td>";
			echo "</tr>";

			echo "<tr height='10px'><td colspan='4'></td></tr>";
                        
            echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				
				echo "<td width='645px'>";
					echo "<textarea name='programa' style='width: 645px; height:200px;'>".$programa."</textarea>";
					//echo "<input type='hidden' name='id' value='".$id."'>";
				echo "</td>";
				
				echo "<td width='15px' align='right'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
		echo "</table>";
	//Informe de la auditoria
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td id='titulo2' colspan='3'><b>Informe de la auditoría</b></td>";
				
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td>";
				
					if($rutaI != ""){
						
						echo "<i>".$rutaI."</i> <a href='downloadAuditoria.php?file=".$rutaI."' ><img src='../Imagenes/ICN_Archivo.png'></a>";
						
						echo"<a href='fileReload.php?id=".$id."&tipo=INFORME' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_Settings.png' width='15' height='15'> </img> </a> ";
					
					}else if($rutaI == ("" || NULL)){
					
						echo "<a href='AgregarArchivoAuditoriaPopUp.php?id=".$id."&tipo=INFORME' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')\">
						<img src='../Imagenes/ICN_CargaDocumento.png' height='15' width='15'></a>";
						
					}
				
				echo "</td>";
			echo "</tr>";

			echo "<tr height='10px'><td colspan='4'></td></tr>";
		
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td width='20px'></td>";
				
				echo "<td width='645px'>";
					echo "<textarea name='informe' style='width: 645px; height:200px;'>".$informe."</textarea>";
					//echo "<input type='hidden' name='id' value='".$id."'>";
				echo "</td>";
				
				echo "<td width='15px' align='right'></td>";
			echo "</tr>";
			
			echo "<tr height='20'><td colspan='4'></td></tr>";
		echo "</table>";
	//Finaliza Informe de la auditoria
	
	///Hallazgos
		echo "<table border='0' align='center' width='700px'>";	
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>Hallazgos</b></td>";
				
				echo "<td align='right'>";
					echo "<a href='AgregaIssue.php?id=".$id."' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\">";
						echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
					echo "</a>";
				echo "</td>";	
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='30'><td colspan='2'></td></tr>";
		echo "</table>";
		
		if(count($issueID) >= 1){
					
			echo "<table border='0' align='center'>";
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center' width='120px'>Código</td>";
					echo "<td align='left' width='430px'>Titulo</td>";
					echo "<td align='center' width='80px'>Fecha</td>";
					echo "<td align='center' width='20px'></td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='4'></td></tr>";
					
				for($a = 1; $a <= count($issueID); $a++){
					
					echo "<tr>";
						echo "<td align='center' id='fileItem'>";
							echo "<a href='fichaIssue.php?id=".$issueID[$a]."' id='fileItem' style='text-decoration:none;'>".$claveIssue[$a]."</a>";
						echo "</td>";
						
						echo "<td align='left' id='fileItem'>".$tituloIssue[$a]."</td>";
						
						echo "<td align='center' id='fileItem'>".$fechaIssue[$a]."</td>";
						
						echo "<td align='right'>";
							if($ruta[$a] != ""){
								echo "<a href='downloadAuditoria.php?file=".$ruta[$a]."'><img src='../Imagenes/ICN_Archivo.png'></a>";
						
							}
						echo "</td>";
						
						
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";
						
				}
			
			echo "</table>";
		}
	
	//FINALIZAR
		echo "<table border='0' align='center' width='700px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<a href='FichaAuditoria.php?id=$id'> <input type='image' src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='50px'><td></td></tr>";
		echo "</table>";
        echo"</form>";
    echo "</div>";
	
} else{
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta charset="utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
				<title>Modificar Auditoría</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
				?> 
			</head>
			<body>
	<?php

	echo "<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center'>";		
			echo "<tr height='150px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "Error!!!";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";
}

?>
    	</body>
    </html>
<?php

<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco 
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='Documento.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");


$Documento = explode('-', $_GET['manual']);
$manual = $_GET['manual'];

$grupo = trim($Documento[0]);
$area = trim($Documento[1]);

//echo"SELECT xt_nombre FROM SGI_Manuales WHERE SUBSTRING_INDEX(xt_codigo,'-',-1) = '$area'";
$a = $INTRANET->Execute("SELECT xt_nombre FROM SGI_Manuales WHERE SUBSTRING_INDEX(xt_codigo,'-',-1) = '$area' ");	
		while($t = $a->fetchRow()){
			
			$nombreArea = $t[0];
		
	}/*

if($area == 'MC'){
	$nombreArea = "Manual de Gestión Integral";
} else if($area == 'CDR'){
	$nombreArea = "Manual de Control de Documentos y Registros";
} else if($area == 'AI'){
	$nombreArea = "Manual de Auditorías Internas";
} else if($area == 'CC'){
	$nombreArea = "Manual del Comité de Calidad";
} else if($area == 'DG'){
	$nombreArea = "Manual de Dirección General";
} else if($area == 'ADM'){
	$nombreArea = "Manual de Administración";
} else if($area == 'RH'){
	$nombreArea = "Manual de Recursos Humanos";
} else if($area == 'TI'){
	$nombreArea = "Manual de Tecnologías de Información";
} else if($area == 'OPE'){
	$nombreArea = "Manual de Operaciones";
} /*else if($area == 'SE'){
	$nombreArea = "Manual de Seguridad";
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
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
            
 			<?php
				echo "<title>".$nombreArea."</title>";
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
			?>
</head>

<body>
<?php
$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home /</a><a href='homeSGI.php' id='breadcrumbs'>Sistema de Gestión Integral /</a> 
			<a href='manuales.php' id='breadcrumbs'> Manuales</a>";


echo"<div id='wrapper' align='center'>";
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr height='80px'><td></td></tr>";
		
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>$nombreArea</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>$manual</font>";
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
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-SE' id='breadcrumbs'>
                                                    Manual de seguridad
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
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	
	$indice 				= 1;
	$ciudadesDisponibles 	= NULL;
	
	$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");
	
	while($r = $s->fetchRow()){
		
		$ciudadesDisponibles[$indice] = $r[0];
		
		$indice++;
		
	} unset($r); unset($s); unset($indice);
	
	$queryCiudades = "";
	
	for($o = 1; $o <= count($ciudadesDisponibles); $o++){
		
		$queryCiudades = "'".$ciudadesDisponibles[$o]."', ";
		
	} unset($o);
	
	$queryCiudades = substr($queryCiudades, 0, -2);
	
	///CAPITULOS
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'C' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	$s = $INTRANET->Execute("SELECT
									I.kp_itemID,
									I.xt_codigo,
									I.xt_nombre
								FROM
									SGI_Item I
								WHERE
									I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
								AND I.xt_tipo = 'C'
								AND (I.xt_ciudad IN (
									SELECT
										O.xt_codigoCiudad
									FROM
										IntranetGEA_Usuarios_Oficina O
									WHERE
										O.kf_usuarioId = '".$usuarioId."'
								) or I.xt_ciudad is null OR I.xt_ciudad = '')
								ORDER BY
									I.xt_tipo,
									I.xn_consecutivo");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Capítulos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///LINEAMIENTOS
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'L' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	$s = $INTRANET->Execute("SELECT
									I.kp_itemID,
									I.xt_codigo,
									I.xt_nombre
								FROM
									SGI_Item I
								WHERE
									I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
								AND I.xt_tipo = 'L'
								AND (I.xt_ciudad IN (
									SELECT
										O.xt_codigoCiudad
									FROM
										IntranetGEA_Usuarios_Oficina O
									WHERE
										O.kf_usuarioId = '".$usuarioId."'
								) or I.xt_ciudad is null OR I.xt_ciudad = '')
								ORDER BY
									I.xt_tipo,
									I.xn_consecutivo");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Lineamientos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///PROCEDIMIENTO
	$bandera = 0;
	
	/*$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'P' 
							 ORDER BY xt_tipo, xn_consecutivo");*/
	$s = $INTRANET->Execute("SELECT
									I.kp_itemID,
									I.xt_codigo,
									I.xt_nombre
								FROM
									SGI_Item I
								WHERE
									I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
								AND I.xt_tipo = 'P'
								AND (I.xt_ciudad IN (
									SELECT
										O.xt_codigoCiudad
									FROM
										IntranetGEA_Usuarios_Oficina O
									WHERE
										O.kf_usuarioId = '".$usuarioId."'
								) or I.xt_ciudad is null OR I.xt_ciudad = '')
								ORDER BY
									I.xt_tipo,
									I.xn_consecutivo");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Procedimientos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///INSTRUCTIVO
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'I' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	$s = $INTRANET->Execute("SELECT
									I.kp_itemID,
									I.xt_codigo,
									I.xt_nombre
								FROM
									SGI_Item I
								WHERE
									I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
								AND I.xt_tipo = 'I'
								AND (I.xt_ciudad IN (
									SELECT
										O.xt_codigoCiudad
									FROM
										IntranetGEA_Usuarios_Oficina O
									WHERE
										O.kf_usuarioId = '".$usuarioId."'
								) or I.xt_ciudad is null OR I.xt_ciudad = '')
								ORDER BY
									I.xt_tipo,
									I.xn_consecutivo");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Instructivos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///FORMATO
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'F' 
							 ORDER BY xt_tipo, xn_consecutivo");
							 */
	$s = $INTRANET->Execute("SELECT
									I.kp_itemID,
									I.xt_codigo,
									I.xt_nombre
								FROM
									SGI_Item I
								WHERE
									I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
								AND I.xt_tipo = 'F'
								AND (I.xt_ciudad IN (
									SELECT
										O.xt_codigoCiudad
									FROM
										IntranetGEA_Usuarios_Oficina O
									WHERE
										O.kf_usuarioId = '".$usuarioId."'
								) or I.xt_ciudad is null OR I.xt_ciudad = '')
								ORDER BY
									I.xt_tipo,
									I.xn_consecutivo");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Formatos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///Documento Externo
	$bandera = 0;
	
	/*
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'DE' 
							 ORDER BY xt_tipo, xn_consecutivo");*/
	$s = $INTRANET->Execute("SELECT
									I.kp_itemID,
									I.xt_codigo,
									I.xt_nombre
								FROM
									SGI_Item I
								WHERE
									I.xt_grupo = '".$grupo."'
								AND I.xt_area = '".$area."'
								AND I.xt_tipo = 'DE'
								AND (I.xt_ciudad IN (
									SELECT
										O.xt_codigoCiudad
									FROM
										IntranetGEA_Usuarios_Oficina O
									WHERE
										O.kf_usuarioId = '".$usuarioId."'
								) or I.xt_ciudad is null OR I.xt_ciudad = '')
								ORDER BY
									I.xt_tipo,
									I.xn_consecutivo");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Documentos Externos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	///Proceso
	
	/*
	$bandera = 0;
	
	$s = $INTRANET->Execute("SELECT kp_itemID, xt_codigo, xt_nombre FROM SGI_Item WHERE xt_grupo = '$grupo' AND xt_area = '$area' AND xt_tipo = 'K' 
							 ORDER BY xt_tipo, xn_consecutivo");
	
	while($r = $s->fetchRow()){
		
		$bandera++;
		
		if($bandera == 1){
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td colspan='3' id='titulo2'>Procesos</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo"<tr height='20px'><td colspan='3'></td></tr>";
				
		}
		
		echo "<tr id='titulo2Blanco'>";
			echo "<td width='30px'> </td>";
			
			echo "<td align='left' width='300px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[1]."</a>";
			echo "</td>";
			
			echo "<td align='left' width='500px' valign='top'>";
				echo "<a href='FichaItem.php?id=".$r[0]."' id='manualVinculo'>".$r[2]."</a>";
			echo "</td>";
			
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='3'></td></tr>";
			
	}
	*/
	if($bandera >= 1){
			echo"<tr height='10'><td colspan='3'></td></tr>";
		echo "</table>";
	}
	
	echo "<table border='0' align='center'>";
		echo"<tr height='70'><td></td></tr>";
	echo "</table>";
	
echo"</div>";

?>


</body>
</html>
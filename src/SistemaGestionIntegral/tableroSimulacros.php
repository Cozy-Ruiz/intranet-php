<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio García Robles
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'tableroReuniones.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
error_reporting(E_PARSE);
/*
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

*/
$contador = 0;
$t = $INTRANET->Execute("SELECT O.xt_codigoCiudad, (SELECT CO.xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA CO WHERE CO.xt_oficina = O.xt_codigoCiudad) FROM IntranetGEA_Usuarios_Oficina O WHERE O.kf_usuarioId  = '$usuarioId' AND O.xt_codigoCiudad in(SELECT E.xt_ciudad FROM SGI_Reuniones E)");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);

$reunionTipoShow[1] = "Revisión por la Dirección";
$reunionTipoShow[2] = "Revisión del Comité de Calidad";
$reunionTipoShow[3] = "Revisión de Planeación Estratégica";
$reunionTipoShow[4] = "Revisión del Portafolio de Proyecto";
$reunionTipoShow[5] = "Revisión de Proyecto";
$reunionTipoShow[6] = "Revisión de TI";
$reunionTipoShow[7] = "Extraordinaria";

$reunionTipoValor[1] = "DIRECCION";
$reunionTipoValor[2] = "COMITE DE CALIDAD";
$reunionTipoValor[3] = "PLANEACION ESTRATEGICA";
$reunionTipoValor[4] = "PORTAFOLIO DE PROYECTO";
$reunionTipoValor[5] = "PROYECTO";
$reunionTipoValor[6] = "TI";
$reunionTipoValor[7] = "EXTRAORDINARIA";

$indice 				= 1;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

if(		  $_POST['ciudad'] != ""){
	$ciudadShow = $_POST['ciudad'];
	
} else if($_GET['ciudad'] != ""){
	$ciudadShow = $_GET['ciudad'];
	
} else{
	$ciudadShow = $ciudadDefault;
	
}

for($o=0; $o <count($cdValor); $o++){
	
	if($cdValor[$o] == $ciudadShow){
		$imprimeCiudad = $ciudades[$o];
	}
	
} unset($o);

$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			 <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos </a>";
			 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
			<title>Tablero de Reuniones</title>
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
<?php

echo "<div id='wrapperFicha' align='center'>";
	echo "<form method='post' action='tableroReuniones.php'>";	
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
 		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>Reuniones</td>";
		echo "</tr>";
		/*
		if($categoriaUsr == "Administrador"){
			echo "<tr>";
				echo "<td align='center' id='titulo1'>".$imprimeCiudad."</td>";
			echo "</tr>";
		}
		*/
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
			
		
		//echo "<tr height='70px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center'>";
				if(($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'cozy')|| ($usuarioId == 'Ricardo_Garcia') || ($usuarioId == 'sdelap') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Denisse_Valladares') || ($usuarioId == 'Christian_Martinez')|| ($usuarioId == "Miguel_Patiño")  || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "Gerardo_Nunez") || ($usuarioId == "Jorge_Doring")){
					echo "<a href='altaReunion.php'><img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'></a>";
				}
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
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
				
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../navegacion_banana.php");
			echo "</table>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	// CASO ADMINISTRADOR
	if($categoriaUsr == "Administrador"){
		
		echo "<table border='0' align='center' width='700px' id='ocultar' style='display:block;'>";
			echo"<tr>";
				echo"<td align='left' id='iconosTexto2' onClick='show(1);' width='700px'>Ciudad</td>";
			echo"</tr>";
			
			echo"<tr height='30px'><td></td></tr>";
		echo"</table>";
		///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='700px' id='mostrar' style='display:none;'>";
			echo "<tr>";
				echo "<td colspan='2' align='left' id='iconosTexto2' onClick='show(0);'>Ciudad</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td id='breadcrumbs' valign='top' width='50px'>";
			///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					echo "<select name='ciudad'>";
						
						for($a = 0; $a <count($cdValor); $a++){
							
							if(in_array($cdValor[$a], $ciudadesDisponibles)){
								
								if($cdValor[$a] != $ciudadShow){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
									
								} else{
									
									echo "<option value='".$cdValor[$a]."' selected='selected'>".$ciudades[$a]."</option>";
									
								}
							}
						}
					
					echo "</select>";
				echo "</td>";
				
				echo "<td align='left' width='650px'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='80' height='20'>";
				echo "</td>";
			echo"</tr>";
		
			echo"<tr height='30px'><td colspan='2'></td></tr>";
		echo"</table>";// FIN DEL FILTRO POR CIUDAD
		
		for($allTypes = 1; $allTypes <= 7; $allTypes++){
			
			$indice 		= 1;
			$reunionID 		= NULL;
			$claveReunion 	= NULL;
			$statusReunion 	= NULL;
			$fechaReunion 	= NULL;
			
			$s = $INTRANET->Execute("SELECT kp_reunionID, xt_claveReunion, xt_status, xd_fecha FROM SGI_Reuniones WHERE xt_ciudad = '$ciudadShow' 
									 AND xt_tipo = '$reunionTipoValor[$allTypes]' ORDER BY xd_fecha DESC ");
					
			while($r = $s->fetchRow()){
				
				$reunionID[$indice] 	= $r[0];
				$claveReunion[$indice] 	= $r[1];
				$statusReunion[$indice] = $r[2];
				$fechaReunion[$indice] 	= date('Y-m-d', strtotime($r[3]));
				
				$indice++;
				
			} unset($r); unset($s); unset($indice);
				 
			
			if(count($reunionID) >= 1){
				
				echo "<table border='0' align='center' width='750px'>";
				
					echo "<tr><td colspan='4' id='titulo2Blanco' >".$reunionTipoShow[$allTypes]."</td></tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";	
					
					echo "<tr id='titulo2'>";
						echo "<td align='center' width='50px'></td>";
						echo "<td align='center' width='200px'>Código</td>";
						echo "<td align='center' width='200px'>Fecha</td>";
						echo "<td align='center' width='300px'>Status</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td colspan='3' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					
				echo "</table>";
				
				echo"<table align='center' border='0' width='750px'>";
				
				for($o = 1; $o <= count($reunionID); $o++){
					
					echo "<tr id='fileItem'>";
						echo "<td width='50px'></td>";				
						echo "<td width='200px' align='center'>";
							if($statusReunion[$o] == 2 || $statusReunion[$o] == 3){ 
								echo "<a href='fichaReunion.php?id=".$reunionID[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}else if($statusReunion[$o] == 1){
								echo "<a href='ReunionElementoActualizar.php?id=".$reunionID[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}
						echo "</td>";
						
						echo "<td width='200px' align='center'>".$fechaReunion[$o]."</td>";
						
						echo "<td width='300px' align='center'>";
							if($statusReunion[$o] == 1){
							
								echo "Programada";
								
							}else if($statusReunion[$o] == 2){
								
								echo "Realizada";
								
							}else if($statusReunion[$o] == 3){
								
								echo "Pospuesta";
							
							}
						echo "</td>";
					echo "</tr>";
					
					echo"<tr height='5px'><td colspan='4'></td></tr>";
						
					
				}
				echo "</table>";
				
				echo "<table border='0' align='center' width='750px'>";
					echo "<tr>";
						echo "<td width='50px'></td>";
						echo "<td width='700px' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='40px'><td colspan='2'></td></tr>";
				echo "</table>";
			}
		
		}
	
	//CASO INHOUSE
	} else if($categoriaUsr == "Inhouse"){
	
		for($allTypes = 1; $allTypes <= 7; $allTypes++){
			
			$indice 		= 1;
			$reunionID 		= NULL;
			$claveReunion 	= NULL;
			$statusReunion 	= NULL;
			$fechaReunion 	= NULL;
			
			$s = $INTRANET->Execute("SELECT kp_reunionID, xt_claveReunion, xt_status, xd_fecha FROM SGI_Reuniones WHERE xt_ciudad = '$ciudadDefault' AND xt_tipo = '$reunionTipoValor[$allTypes]' ORDER BY xd_fecha DESC ");
					
			while($r = $s->fetchRow()){
				$reunionID[$indice] 	= $r[0];
				$claveReunion[$indice] 	= $r[1];
				$statusReunion[$indice] = $r[2];
				$fechaReunion[$indice] 	= date('Y-m-d', strtotime($r[3]));
				
				$indice++;
				
			} unset($r); unset($s); unset($indice);
				 
			
			if(count($reunionID) >= 1){
				
				echo "<table border='0' align='center' width='750px'>";
				
					echo "<tr><td colspan='4' id='titulo2Blanco' >".$reunionTipoShow[$allTypes]."</td></tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";	
					
					echo "<tr id='titulo2'>";
						echo "<td align='center' width='50px'></td>";
						echo "<td align='center' width='200px'>Código</td>";
						echo "<td align='center' width='200px'>Fecha</td>";
						echo "<td align='center' width='300px'>Status</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td colspan='3' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";	
					
				echo "</table>";
				
				
				echo"<table align='center' border='0' width='750px'>";
				
				for($o = 1; $o <= count($reunionID); $o++){
					
					echo "<tr id='fileItem'>";	
						echo "<td width='50px'></td>";			
						echo "<td width='200px' align='center'>";
							if($statusReunion[$o] == 2 || $statusReunion[$o] == 3){ 
								echo "<a href='fichaReunion.php?id=".$reunionID[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}else if($statusReunion[$o] == 1){
								echo "<a href='ReunionElementoActualizar.php?id=".$reunionID[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}
						echo "</td>";
						
						echo "<td width='200px' align='center'>".$fechaReunion[$o]."</td>";
						
						echo "<td width='300px' align='center'>";
							if($statusReunion[$o] == 1){
							
								echo "Programada";
								
							}else if($statusReunion[$o] == 2){
								
								echo "Realizada";
								
							}else if($statusReunion[$o] == 3){
								
								echo "Pospuesta";
							
							}
						echo "</td>";
					echo "</tr>";
					
					echo"<tr height='5px'><td colspan='4'></td></tr>";
					
				}
				
				echo "</table>";
				
				echo "<table border='0' align='center' width='750px'>";
					echo "<tr>";
						echo "<td width='50px'></td>";
						echo "<td width='700px' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='40px'><td colspan='2'></td></tr>";
				echo "</table>";
			}
		
		}

	}//FIN CASO INHOUSE
	
  		echo "</form>";
	echo "</div>";
?>

    	</body>
    </html>
<?php

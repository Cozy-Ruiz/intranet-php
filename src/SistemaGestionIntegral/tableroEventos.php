<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'tableroEventos.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <title>Tablero Eventos</title>
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

/*
$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";
$ciudades[7] = "Todas";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN"; 
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
$cdValor[7] = "ALL";
*/

$contador = 0;
$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);
						

$indice 				= 1;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


$indice 		= 1;
$eventoID 		= NULL;
$fecha 			= NULL;
$titulo 		= NULL;
$claveEvento 	= NULL;
//echo "SELECT kp_eventoID, xd_fecha, xt_tituloEvento, xt_codigoEvento FROM SGI_Eventos WHERE xt_ciudad = '$ciudadesDisponibles' ORDER BY xd_fecha DESC ";
$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadFiltro = "";

if($_POST['ciudad'] !=""){
	
	$ciudadFiltro = $_POST['ciudad'];
	
}else if($_GET['ciudad'] !=""){
	
	$ciudadFiltro = $_GET['ciudad'];
	
}

for($o = 0; $o <count($cdValor); $o++){
	
	if($cdValor[$o] == $ciudadFiltro){
		
		$imprimeCiudad = $ciudades[$o];
		
	}
	
}

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='Riesgos.php' id='breadcrumbs'> Riesgos </a>";

echo "<div id='wrapperFicha' align='center'>";
	echo "<form method='post' action='tableroEventos.php'>";
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Eventos";
			echo "</td>";
		echo "</tr>";
		
		if($categoriaUsr == "Administrador"){
			
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo $imprimeCiudad;
				echo "</td>";
			echo "</tr>";
			
		}
		
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
		
		echo "<tr height='40px'><td></td></tr>";
		
		//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../navegacion_banana.php");
			echo "</table>";
		
		if($categoriaUsr == "Administrador"){
			
			echo "<tr>";
				echo "<td align='center'>";
					echo "<a href='altaEvento.php'>";
						echo "<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";
			
		}
		
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
				
				
				
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 


//CATEGORIA DE INHOUSE
if($categoriaUsr == "Inhouse"){
	
	echo "<table border='0' align='center' width='700px'>";
	
		$s = $INTRANET->Execute("SELECT kp_eventoID, xd_fecha, xt_tituloEvento, xt_codigoEvento FROM SGI_Eventos WHERE xt_ciudad = '$ciudadDefault' 
								 ORDER BY xd_fecha DESC ");
		
		while($r = $s->fetchRow()){
			
			$eventoID[$indice] 		= $r[0];
			$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
			$titulo[$indice] 		= $r[2];
			$claveEvento[$indice] 	= $r[3];
			
			$indice++;
			
		} unset($r); unset($s); unset($indice);
		
		echo "<tr id='titulo2'>";
			echo "<td align='center' width='150px'>Código</td>";
			echo "<td align='center' width='10px'></td>";
			echo "<td align='left' width='470px'>Título</td>";
			echo "<td align='center' width='100px'>Fecha</td>";
			echo "<td align='right' width='20px'></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='5' id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td colspan='5'></td></tr>";
	echo "</table>";
	
	if(count($eventoID) >= 1){
		
		echo "<table align='center' border='0' width='700px'>";
		
		for($a = 1; $a <= count($eventoID); $a++){
			
			echo "<tr height='25' id='iconosTexto'>";
				echo "<td width='150px' align='center'>";
					echo "<a href='fichaEvento.php?id=".$eventoID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$claveEvento[$a]."</a>";
				echo "</td>";
				
				echo "<td width='10px' align='center'></td>";
				
				echo "<td width='470px' align='left'>".$titulo[$a]."</td>";
		
				echo "<td width='100px' align='center'>".$fecha[$a]."</td>";
				
				echo "<td width='10px' align='right'></td>";
			echo "</tr>";
			
		}
		
		echo "</table>";
		
	} else{
		
		echo "<table align='center' border='0' width='700px'>";
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td width='700px' id='iconosTexto'><i>No hay Eventos que mostrar.</i></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td></td></tr>";
		echo "</table>";
		
	}
	
	echo "<table align='center' border='0' width='700px'>";
		echo "<tr height='10'><td></td></tr>";
		
		echo "<tr>";
			echo "<td width='700px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='4opx'><td></td></tr>";
	echo "</table>";
//CATEGORIA ADMINISTRADOR
}else if($categoriaUsr == "Administrador"){
	
	echo "<table border='0' align='center' id='ocultar' style='display:block;' width='700px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs' onClick='show(1);' width='700px'>Filtrar por ciudad</td>";
		echo "</tr>";
		
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";
	
//FILTRO POR CIUDADES
	echo "<table border='0' align='center' width='700' id='mostrar' style='display:none;'>";
		//CONDICION PARA VER TODO
		echo "<tr>";
			echo "<td  align='left' id='breadcrumbs' onClick='show(0);' colspan='2'>Filtrar por ciudad</td>";	
		echo "</tr>";
		
		$todas = $INTRANET->getOne("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' AND xt_codigoCiudad = 'ALL'");
		
		echo "<tr>";
			echo "<td id='breadcrumbs' valign='top' width='50'>";
			///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
				echo "<select name='ciudad' size='1'>";
				if($ciudadFiltro == ""){
					
					echo "<option value='' selected='selected'>Seleccionar..</option>";
					
					//for($a = 1; $a <= 7; $a++){
					for($a = 0; $a <count($cdValor); $a++){
						echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
					}
					
					if($todas != ''){
						echo "<option value='ALL'>Todas</option>";
					}
					
				}else{
					
					//for($a = 1; $a <= 7; $a++){
					for($a = 0; $a <count($cdValor); $a++){
						
						if($cdValor[$a] == $ciudadFiltro){
							
							echo "<option value='".$cdValor[$a]."' selected='selected'>".$ciudades[$a]."</option>";
							
						} else {
							
							echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
						}
					}
					if($todas != ''){
						echo "<option value='ALL'>Todas</option>";
					}
				
				}
				echo "</select>";
			echo "</td>";
		
			echo "<td align='left' width='650'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' height='20' width='70'></td>";
		echo "</tr>";
	
		echo "<tr height='30'><td colspan='2'></td></tr>";			
	echo "</table>";
	
//RESULTADO DE LA BUSQUEDA POR CIUDAD
	if($ciudadFiltro == "" || $ciudadFiltro == 'ALL'){
		
		//for($o = 1; $o <= 6; $o++){
		for($o = 0; $o <count($cdValor); $o++){
			
			$indice			= 1;
			$eventoID 		= NULL;
			$fecha 			= NULL;
			$titulo 		= NULL;
			$claveEvento 	= NULL;
			
			$s = $INTRANET->Execute("SELECT kp_eventoID, xd_fecha, xt_tituloEvento, xt_codigoEvento FROM SGI_Eventos WHERE xt_ciudad = '$cdValor[$o]' ORDER BY xd_fecha DESC ");
			
			while($r = $s->fetchRow()){
				 
				$eventoID[$indice] 		= $r[0];
				$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
				$titulo[$indice] 		= $r[2];
				$claveEvento[$indice] 	= $r[3];
				
				$indice++;
				
			} unset($r); unset($s); unset($indice);	
			
			
			if(count($eventoID) >= 1){
				
				echo "<table border='0' align='center' width='700'>";	
					
					echo "<tr id='titulo2'>";
						echo "<td align='center' width='100px'>".$ciudades[$o]."</td>";
					echo "</tr>";
					
					echo "<tr height='10pz'>";
						echo "<td></td>";
					echo "</tr>";
				echo "</table>";
				
				echo "<table border='0' align='center' width='700px'>";	
					echo "<tr id='titulo2'>";
						echo "<td align='center' width='150px'>Código</td>";
						echo "<td align='center' width='10px'></td>";
						echo "<td align='left' width='470px'>Título</td>";
						echo "<td align='center' width='100px'>Fecha</td>";
						echo "<td align='right' width='20px'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='5' id='titleBlueLineTop'></td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='5'></td></tr>";
				echo "</table>";
				
				echo "<table align='center' border='0' width='700'>";
				
				for($a = 1; $a <= count($eventoID); $a++){
					
					echo "<tr height='25' id='fileItem'>";
						echo "<td width='150px' align='center'>";
							echo "<a href='fichaEvento.php?id=".$eventoID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$claveEvento[$a]."</a>";
						echo "</td>";
						
						echo "<td align='center' width='10px'></td>";
						
						echo "<td width='470px' align='left'>".$titulo[$a]."</td>";
				
						echo "<td width='100px' align='center'>".$fecha[$a]."</td>";
						
						echo "<td width='10px' align='right'></td>";
					echo "</tr>";
					
				}
				
				echo "</table>";
				
				echo "<table align='center' border='0' height='20px' width='700'>";
				
			}
		
		}
		
		
	}else {
		
		$s = $INTRANET->Execute("SELECT kp_eventoID, xd_fecha, xt_tituloEvento, xt_codigoEvento FROM SGI_Eventos WHERE xt_ciudad = '$ciudadFiltro' 
								 ORDER BY xd_fecha DESC ");
		
		while($r = $s->fetchRow()){
			 
			$eventoID[$indice] 		= $r[0];
			$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
			$titulo[$indice] 		= $r[2];
			$claveEvento[$indice] 	= $r[3];
			
			$indice++;
			
		} unset($r); unset($s); unset($indice);	
		
		echo "<table border='0' align='center' width='700px'>";	
			echo "<tr id='titulo2'>";
				echo "<td align='center' width='150px'>Código</td>";
				echo "<td align='center' width='10px'></td>";
				echo "<td align='left' width='470px'>Título</td>";
				echo "<td align='center' width='100px'>Fecha</td>";
				echo "<td align='right' width='20px'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='5' id='titleBlueLineTop'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='5'></td></tr>";
		echo "</table>";
	
		if(count($eventoID) >= 1){
			
			echo "<table align='center' border='0' width='700px'>";
			
			for($a = 1; $a <= count($eventoID); $a++){
				
				echo "<tr height='25px' id='iconosTexto'>";
					echo "<td width='150px' align='center'>";
						echo "<a href='fichaEvento.php?id=".$eventoID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$claveEvento[$a]."</a>";
					echo "</td>";
					
					echo "<td align='center' width='10px'></td>";
					
					echo "<td width='470px' align='left'>".$titulo[$a]."</td>";
			
					echo "<td width='100px' align='center'>".$fecha[$a]."</td>";
					
					echo "<td width='10px' align='right'></td>";
				echo "</tr>";
				
			}
			
			echo "</table>";
			
		} else{
			
			echo "<table align='center' border='0' width='700px'>";
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td width='700px' id='iconosTexto'><i>No hay Eventos que mostrar.</i></td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
			echo "</table>";
		}
		
	}

	echo "<table align='center' border='0' width='700px'>";
		echo "<tr height='10'><td></td></tr>";
		
		echo "<tr>";
			echo "<td width='700px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
		 
}

	echo "</form>";
echo "</div>";

?>
		</body>
	</html>
<?php 

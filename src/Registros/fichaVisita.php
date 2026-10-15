<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio García Robles
 *@version 3.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'fichaVisita.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Visita</title>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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

$visitaID = $_GET['id'];
$ciudad = $_GET['cd'];

if($ciudad !=""){
	$consultaCiudad="SELECT * FROM SGI_Visitas" ;
	if($ciudad != 'CMX' && $ciudad != 'DF' && $ciudad != 'CDMX'){
		$consultaCiudad=$consultaCiudad."_".$ciudad;
	}
	$consultaCiudad=$consultaCiudad." WHERE kp_visitaID = $visitaID ";
	$s = $INTRANET->Execute($consultaCiudad);
}
//$s = $INTRANET->Execute ("SELECT * FROM SGI_Visitas WHERE kp_visitaID = $visitaID ");
while($r = $s->fetchRow($s)){
	$IDvisita = $r[0];
	$fecha = $r[1];
	$nombre = $r[2];
	$apaterno = $r[3];
	$amaterno = $r[4];
	$empresa = $r[5];
	$responsable = $r[6];
	$departamento = $r[7];
	$entrada = $r[8];
	$salida = $r[9];
	$identificacion = $r[10];
	$computo = $r[11];
	$gafete = $r[12];
	$placa = $r[13];
	$tipoVisita = $r[17];	
	$foto = $r[16];
	$idpersonalVF = $r[18];
}

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='Registros.php' id='breadcrumbs'> Registros /</a><a href='TableroVisitas2.php' id='breadcrumbs'> Tablero Visitas</a> ";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Ficha Visitas</font>";
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
		//echo"<tr height='50'> </tr>";
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
	
	//LINEA
	echo "<table border='0' align='center' width='600'>";
		echo"<tr >";
			echo"<td id='titulo2'  align='right'>$fecha</td> ";
		echo"</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo "</table>";
	
	//CUERPO FICHA VISITAS
	

	echo "<table border='0' align='center' width='600'>";
		
		echo"<tr height='30'> </tr>";
		
		echo"<tr >";
			echo"<td id='titulo2' >Gafete: </td> ";
			echo"<td id='titulo2Blanco' width='200'>$gafete</td> ";
			///<input type= 'hidden' name='Id' value='$IDvisita' >
			//<input type= 'hidden' name='cd' value='$ciudad'> 
			if ($tipoVisita == 'VISITA'){
				if($foto == ""){
					echo "<td  align='center' rowspan='4'> <img src='fotos/sinFoto.jpg' height='150' width='200'> </td>";
				}else{
					
					echo "<td  align='center' rowspan='4'> <img src='$foto' height='150' width='200'> </td>";
				}
			}else {
				
				$foto = $INTRANET-> getOne ("SELECT xn_Foto FROM SGI_Empleados WHERE kp_personalId = $idpersonalVF ");
				echo "<td  align='center' rowspan='4'> <img src='../ComunicacionInterna/Personal/$foto' height='117' width='100'> </td>";
			}
		echo"</tr>";
		
	echo "</table>";

	echo "<table border='0' align='center' width='600'>";
	
		echo"<tr height='50'> </tr>";
		
		echo"<tr>";
			echo"<td id='titulo2' align='left'>Entrada: </td> ";
			echo"<td id='titulo18' align='left' colspan='2' > ".date('H:i',strtotime($entrada))."</td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr>";
			echo"<td id='titulo2' align='left'>Salida: </td> ";
				if($salida != ""){
					echo"<td id='titulo18' align='left'  colspan='2'>".date('H:i',strtotime($salida))."</td>"; 
				} else {
					echo"<td id='titulo18' align='left' colspan='2'></td>"; 	
				}
			echo " ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";

		echo"<tr>";
			echo"<td id='titulo2' align='left'>Nombre: </td> ";
			echo"<td id='titulo2Blanco' align='left' colspan='2'>$nombre $apaterno $amaterno </td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr >";
			echo"<td id='titulo2' align='left' >Empresa: </td> ";
			echo"<td id='titulo2Blanco' align='left' >$empresa</td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr>";
			$s= $INTRANET->Execute("SELECT xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados WHERE kp_personalId =$responsable ");
			while($r = $s->fetchRow($s)){
				$nombreResponsable = $r[0];
				$apaternoResponsable = $r[1];
				$amaternoResponsable = $r[2];
				
			}unset($r); unset($s);
			echo"<td id='titulo2' align='left' >Persona que visita: </td> ";
			if(($nombre != $nombreResponsable) &&($apaterno != $apaternoResponsable) && ($amaternoResponsable != $amaterno)){
				echo"<td id='titulo2Blanco' align='left' >$nombreResponsable $apaternoResponsable</td> ";
			} else{
				echo"<td id='titulo2Blanco' align='left' ></td> ";
			}
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		//TIPO
		echo "<tr align='left' height='20'>";
				echo "<td id='titulo2' align='left'>Tipo: </td>";
					 if($tipoVisita=='P') {
						echo "<td id='titulo2Blanco' align='left' >Proveedor</td>";
					}else if($tipoVisita=='C') {
						echo "<td id='titulo2Blanco' align='left' >Cliente</td>";
					}else if($tipoVisita=='V') {
						echo "<td id='titulo2Blanco' align='left' >VIP</td>";
					}else if($tipoVisita=='A') {
						echo "<td id='titulo2Blanco' align='left' >Autoridad</td>";
					}
			echo "</tr>";	
			
			echo"<tr height='10'> </tr>";	
		
		
		echo"<tr>";
			echo"<td id='titulo2' align='left' >Identificación: </td> ";
			echo"<td id='titulo2Blanco' align='left' >$identificacion</td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr>";
			echo"<td id='titulo2' align='left'>Equipo de computo: </td> ";
			echo"<td id='titulo2Blanco' align='left' >$computo</td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr>";
			echo"<td id='titulo2' align='left'>Placa Vehicular: </td> ";
			echo"<td id='titulo2Blanco' align='left' >$placa</td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
	echo"</table>";
	
	//LINEA
	echo "<table border='0' align='center' width='600'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'sdelap') ||
				($usuarioId == 'Norma_Tapia') || ($usuarioId == 'Fulgencio_Duran') || ($usuarioId == 'Ruperto_Vicencio') || ($usuarioId == 'Ruben_Solis') || ($usuarioId == 'Javier_Rosas') ||
				($usuarioId == 'Alfonso_Santiago') || ($usuarioId == 'Gustavo_Gracia') || ($usuarioId == 'Eduardo_Hernandez')||($usuarioId == 'Ana_Vargas')||($usuarioId == 'Erika_Muñoz')||($usuarioId == 'Karina_Vega') ||($usuarioId == 'Priscilla_Romero')){
			echo"<tr height='40'>";
			
			echo"<td valign='bottom' align='left' width='300'>";
				echo "<a href='BorraVisita.php?id=$IDvisita&cd=$ciudad' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=250,scrollbars=yes')\">";
					echo "<input type='image' src='../Imagenes/ICN_BotonBasura.png' width='20' height='20'>";
				echo "</a>";
			echo"</td>";
			
			echo"<td valign='bottom' align='right' width='300'>";
				echo "<a href='modificaVisita.php?Id=$IDvisita&cd=$ciudad'><input type='image' src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo"</td>";
			//echo "<form name='fichaVisitas' method='post' action='modificaVisita.php'>";	
		echo"</tr>";
		}else{
			echo"<tr height='10'> </tr>";
		}
		
		echo "<tr height='50px'>";
			echo "<td colspan='2'> </td>";
		echo "</tr>";
	echo "</table>";

echo "</div>";
?>

</body>
</html>


	 
<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='fichaQueja.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
$quejaID = $_GET['id'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Queja</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<script>
function show(elemento, valor){
	if(elemento == 1 && valor == 1){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="block";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 1 && valor == 0){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="block";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="block";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 2 && valor == 1){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="block";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 2 && valor == 0){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="block";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 3 && valor == 1){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="block";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 3 && valor == 0){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="block";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 4 && valor == 1){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="block";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 4 && valor == 0){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="block";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	}else if(elemento == 5 && valor == 1){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="block";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 5 && valor == 0){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="block";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="none";
	}else if(elemento == 6 && valor == 1){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="block";
		document.getElementById("cierre0").style.display="none";
	} else if(elemento == 6 && valor == 0){
		document.getElementById("actual").style.display="none";
		document.getElementById("asignada1").style.display="none";
		document.getElementById("asignada0").style.display="none";
		document.getElementById("evaluacionInicial1").style.display="none";
		document.getElementById("evaluacionInicial0").style.display="none";
		document.getElementById("investigacion1").style.display="none";
		document.getElementById("investigacion0").style.display="none";
		document.getElementById("respuesta1").style.display="none";
		document.getElementById("respuesta0").style.display="none";
		document.getElementById("comunicacion1").style.display="none";
		document.getElementById("comunicacion0").style.display="none";
		document.getElementById("cierre1").style.display="none";
		document.getElementById("cierre0").style.display="block";
	}
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
<?PHP
$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='tableroSolicitudesyQuejas.php' id='breadcrumbs'> Solicitudes y Quejas</a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Queja</font>";
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
		echo"<tr height='70'> </tr>";
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

		
	//CUERPO ACUERDO
	$s = $INTRANET->Execute("SELECT xt_claveQuejaSolicitud, xt_titulo, xt_descripcion, xt_ruta FROM SGI_Quejas_Solicitudes WHERE kp_quejaSolicitudID = $quejaID AND xt_tipo = 'C'");
	while($r = $s->fetchRow()){
		$clave = $r[0];
		$titulo = $r[1];
		$descripcion = nl2br ($r[2]);
		$ruta = $r[3];
		
	} unset($r); unset($s);
		
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2'><b>$clave</b></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>$titulo</b></td>";
			if ($ruta != NULL){
				echo"<td id='iconosTexto' width='50' align='right'><a href='downloadQuejaSolicitud.php?file=$ruta'><img src='../Imagenes/ICN_Archivo.png'></a> </td>";
			}else {
				echo"<td id='iconosTexto' width='50' align='right'></td>";
			}
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='20'> </td>";
			echo "<td width='20'> </td>";
			echo "<td width='610' align='justify' id='fileItem'>$descripcion</td><td></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	//echo"SELECT xt_codigoSeguimiento, kp_seguimientoID FROM SGI_Seguimientos WHERE xt_tipoOrigen = 'C' AND kf_itemOrigenID = $quejaID ";
	$s = $INTRANET->Execute("SELECT xt_codigoSeguimiento, kp_seguimientoID FROM SGI_Seguimientos WHERE xt_tipoOrigen = 'C' AND kf_itemOrigenID = $quejaID ");
	while($r = $s->fetchRow()){
		$codigo = $r[0];
		$id = $r[1];
		$indice++;
	}unset($s); unset($r);
	///SEGUIMIENTO
	echo "<table border='0' align='center' width='700'>";	
		echo"<tr>";
			echo"<td align='left' id='titulo2'><b>Seguimiento</b></td>";
			if(count($codigo) >= 1){
				echo"<td> </td>";
				
			}else {
				echo"<td align='right'>
						<a href='AgregarSeguimientoSolicitudQueja.php?origen=C&ID=$quejaID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\"> 
							<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>
						</a>
					</td>";
			}
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
///CODIGO MOSTRAR SEGUIMIENTO	
	//echo"$codigo";
	if($codigo != ""){
					
		echo "<table border='0' align='center'>";
			echo "<tr height='10px'> </tr>";
			echo "<tr>";
				echo "<td width='100px' align='left'><a href='SeguimientoSolicitudQueja.php?origen=C&ID=$quejaID' id='fichaRef'>$codigo</a></td>";
			///Banderas para las Variables Etapas
				///CERRADA
				$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $id AND xn_etapa = 6 ");
				
				while($r = $s->fetchRow()){
					$fechaCerrada = date('Y-m-d', strtotime($r[0]));
					$tituloCerrada = $r[1];
					$contenidoCerrada = $r[2];
					$rutaCerrada = $r[3];
					
				}unset($r); unset($s);
				///COMUNICACION
				$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $id AND xn_etapa = 5 ");
				
				while($r = $s->fetchRow()){
					$fechaComunicacion = date('Y-m-d', strtotime($r[0]));
					$tituloComunicacion = $r[1];
					$contenidoComunicacion = $r[2];
					$rutaComunicacion = $r[3];
					
				}unset($r); unset($s);
				///RESPUESTA
				$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $id AND xn_etapa = 4 ");
				
				while($r = $s->fetchRow()){
					$fechaRespuesta = date('Y-m-d', strtotime($r[0]));
					$tituloRespuesta = $r[1];
					$contenidoRespuesta = $r[2];
					$rutaRespuesta = $r[3];
					
				}unset($r); unset($s);
				///INVESTIGACION
				$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $id AND xn_etapa = 3 ");
				
				while($r = $s->fetchRow()){
					$fechaInvestigacion = date('Y-m-d', strtotime($r[0]));
					$tituloInvestigacion = $r[1];
					$contenidoInvestigacion = $r[2];
					$rutaInvestigacion = $r[3];
					
				}unset($r); unset($s);
				///EVALUACION INICIAL
				$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $id AND xn_etapa = 2 ");
				
				while($r = $s->fetchRow()){
					$fechaEvaluacion = date('Y-m-d', strtotime($r[0]));
					$tituloEvaluacion = $r[1];
					$contenidoEvaluacion = $r[2];
					$rutaEvaluacion = $r[3];
					
				}unset($r); unset($s);
				///ASIGNADA
				$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_contenido, xt_ruta FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $id AND xn_etapa = 1 ");
				
				while($r = $s->fetchRow()){
					$fechaAsignada = date('Y-m-d', strtotime($r[0]));
					$tituloAsignada = $r[1];
					$contenidoAsignada = $r[2];
					$rutaAsignada = $r[3];
					
				}unset($r); unset($s);
				
			/////MODIFICAR ANCHO DEL TD Y DE LA TABLA PARA AJUSTAR LOS SEMAFOROS
				echo "<td align='center' width='150px' id='fileItem'>";
					echo "<table border='0' align='center' width='150px'>";
						echo "<tr>";
						if($fechaAsignada != ""){
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(1,1);' src='../Imagenes/ICN_Boton_Azul.png' width='15px' height='15px'>";
							echo "</td>";
						} else{
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(1,0);' src='../Imagenes/ICN_BotonAzulClaro.png' width='15px' height='15px'>";
							echo "</td>";
						}
						
						if($fechaEvaluacion != ""){
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(2,1);' src='../Imagenes/ICN_Boton_Azul.png' width='15px' height='15px'>";
							echo "</td>";
						} else{
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(2,0);' src='../Imagenes/ICN_BotonAzulClaro.png' width='15px' height='15px'>";
							echo "</td>";
						}
						
						if($fechaInvestigacion != ""){
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(3,1);' src='../Imagenes/ICN_Boton_Azul.png' width='15px' height='15px'>";
							echo "</td>";
						} else{
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(3,0);' src='../Imagenes/ICN_BotonAzulClaro.png' width='15px' height='15px'>";
							echo "</td>";
						}
						
						if($fechaRespuesta != ""){
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(4,1);' src='../Imagenes/ICN_Boton_Azul.png' width='15px' height='15px'>";
							echo "</td>";
						} else{
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(4,0);' src='../Imagenes/ICN_BotonAzulClaro.png' width='15px' height='15px'>";
							echo "</td>";
						}
						
						if($fechaComunicacion != ""){
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(5,1);' src='../Imagenes/ICN_Boton_Azul.png' width='15px' height='15px'>";
							echo "</td>";
						} else{
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(5,0);' src='../Imagenes/ICN_BotonAzulClaro.png' width='15px' height='15px'>";
							echo "</td>";
						}
						if($fechaCerrada != ""){
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(6,1);' src='../Imagenes/ICN_Boton_Azul.png' width='15px' height='15px'>";
							echo "</td>";
						} else{
							echo "<td width='20px'>";
								echo "<input type='image' onclick='show(6,0);' src='../Imagenes/ICN_BotonAzulClaro.png' width='15px' height='15px'>";
							echo "</td>";
						}
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				$maxEtapa = $INTRANET->getOne("SELECT MAX(xn_etapa) FROM SGI_Seguimiento_Etapas WHERE kf_seguimientoID = $id ");
				if($maxEtapa == 6){
					echo "<td align='center' width='250px' style='display:block;' id='actual'>";
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td align='center' width='150px' id='fileItem'>Cerrada</td>";
								echo "<td align='center' width='100px' id='textIntro'>$fechaCerrada</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				}else if($maxEtapa == 5){
					echo "<td align='center' width='250px' style='display:block;' id='actual'>";
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td align='center' width='150px' id='fileItem'>Comunicación</td>";
								echo "<td align='center' width='100px' id='textIntro'>$fechaComunicacion</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				} else if($maxEtapa == 4){
					echo "<td align='center' width='250px' style='display:block;' id='actual'>";
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td align='center' width='150px' id='fileItem'>Respuesta</td>";
								echo "<td align='center' width='100px' id='textIntro'>$fechaRespuesta</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				} else if($maxEtapa == 3){
					echo "<td align='center' width='250px' style='display:block;' id='actual'>";
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td align='center' width='150px' id='fileItem'>Investigación</td>";
								echo "<td align='center' width='100px' id='textIntro'>$fechaInvestigacion</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				} else if($maxEtapa == 2){
					echo "<td align='center' width='250px' style='display:block;' id='actual'>";
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td align='center' width='150px' id='fileItem'>Evaluación Inicial</td>";
								echo "<td align='center' width='100px' id='textIntro'>$fechaEvaluacion</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				}   else if($maxEtapa == 1){
					echo "<td align='center' width='250px' style='display:block;' id='actual'>";
						echo "<table border='0' align='center'>";
							echo "<tr>";
								echo "<td align='center' width='150px' id='fileItem'>Asignada</td>";
								echo "<td align='center' width='100px' id='textIntro'>$fechaEvaluacion</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				}
				
				
				echo "<td align='center' width='250px' style='display:none;' id='cierre1'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Cerrada</td>";
							echo "<td align='center' width='100px' id='textIntro'>$fechaCerrada</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='cierre0'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Cerrada</td>";
							echo "<td align='center' width='100px' id='textIntro'> </td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='comunicacion1'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Comunicación</td>";
							echo "<td align='center' width='100px' id='textIntro'>$fechaComunicacion</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='comunicacion0'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Comunicación</td>";
							echo "<td align='center' width='100px' id='textIntro'> </td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='respuesta1'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Respuesta</td>";
							echo "<td align='center' width='100px' id='textIntro'>$fechaRespuesta</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='respuesta0'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Respuesta</td>";
							echo "<td align='center' width='100px' id='textIntro'> </td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='investigacion1'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Investigación</td>";
							echo "<td align='center' width='100px' id='textIntro'>$fechaInvestigacion</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='investigacion0'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Investigación</td>";
							echo "<td align='center' width='100px' id='textIntro'> </td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='evaluacionInicial1'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Evaluación Inicial</td>";
							echo "<td align='center' width='100px' id='textIntro'>$fechaEvaluacion</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='evaluacionInicial0'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Evaluación Inicial</td>";
							echo "<td align='center' width='100px' id='textIntro'> </td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='asignada1'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Asignada</td>";
							echo "<td align='center' width='100px' id='textIntro'>$fechaAsignada</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
				echo "<td align='center' width='250px' style='display:none;' id='asignada0'>";
					echo "<table border='0' align='center'>";
						echo "<tr>";
							echo "<td align='center' width='150px' id='fileItem'>Asignada</td>";
							echo "<td align='center' width='100px' id='textIntro'> </td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				
			echo "</tr>";
			
			echo "<tr height='30px'> </tr>";
		echo "</table>";
		
		if($fechaCerrada != ""){
		///RESULTADO
			echo "<table border='0' align='center' width='700'>";			
				echo"<tr>";
					echo"<td align='left'  id='titulo2'><b>Resultado</b></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' width='700'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='700'>";
				echo "<tr>";
					echo "<td> </td>";
					//echo "<td id='iconosTexto' colspan='2' align='left'><b>$tituloCerrada</b></td>";
					if($rutaCerrada != ""){
						echo "<td colspan='3'><a href='downloadSeguimientoSolicitudQueja.php?file=$rutaCerrada'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
					} else{
						echo "<td colspan='3'> </td>";
					}
					
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo "<tr>";
					echo "<td width='20'> </td>";
					echo "<td width='20'> </td>";
					echo "<td width='600' align='justify' id='fileItem'>$contenidoCerrada</td>";
					echo "<td width='60'> </td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
			echo "</table>";
		}
		
	}
	
///REVISIONES	
	echo "<table border='0' align='center' width='700'>";	
		echo"<tr>";
			echo"<td align='left' id='titulo2'><b>Revisiones</b></td>";
			echo"<td align='right'>
					<a href='AgregaRevisionQueja.php?quejaID=$quejaID' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')\"> 
         				<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>
					</a>
				</td>";	
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";

///CODIGO REVISIONES
		$indice = 1;
		$s = $INTRANET->Execute("SELECT xt_titulo,xd_fecha,kp_revisionID,xt_ruta FROM SGI_Revisiones_Quejas WHERE kf_quejaID = $quejaID");
		while($r = $s->fetchRow()){
			$tituloAc[$indice] = $r[0];
			$fechaAc[$indice] = $r[1];
			$revisionID[$indice]= $r[2];
			$rutaSol[$indice]= trim ($r[3]);
			
			$indice++;
		}
		if($tituloAc != (NULL)){		
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='left' id='iconosTexto2'>Titulo</td>";
					echo "<td align='center' id='iconosTexto2'>Fecha</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
					
				for($a = 1; $a <= count($tituloAc); $a++){
					echo "<tr>";
						echo "<td width='400px' align='left'><a href='fichaRevisionQuejaSolicitud.php?revisionID=$revisionID[$a]&tipo=C' id='fileItem' style='text-decoration:none;'>$tituloAc[$a]</a></td>";
						echo "<td align='center' width='100px' id='fileItem'>$fechaAc[$a]</td>";
						if($rutaSol[$a] != ""){
							echo "<td align='right' width='100px' id='textIntro'><a href='downloadRevisionSolicitudesQuejas.php?file=$rutaSol[$a]'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
						}else{
							echo "<td align='right' width='100px' id='textIntro'></td>";
						}
					echo "</tr>";
					echo "<tr height='10px'> </tr>";
						
				}
				
			echo "</table>";
		}

	
	echo "<table border='0' align='center' width='700'>";	
///LINEA FINAL
		echo "<tr height='30px'> </tr>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'> </tr>";
		/*
		echo "<tr>";
			echo "<td align='right'>";
				echo "<a href='fichaQuejaModificacion.php?id=$quejaID' >
					  <img src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";
		echo "</tr>";
		*/
		echo"<tr height='40px'> </tr>";
	echo "</table>";

echo "</div>";
?>
</body>
</html>
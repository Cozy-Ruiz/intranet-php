<?php error_reporting(0); ?>
<?php
$nombrephp = 'fichaCapturaEnvioArchivos.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
//require_once("MailSolicitudAsignar.php");

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
//obtengo la(s) ciudad del usuario
$indice = 0;
$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Ficha Captura Envio Archivos</title> 
       	    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
            <!--<script language="javascript" type="text/javascript" src="jquery-1.3.2.min.js"></script>-->
            <script language="javascript" type="text/javascript">
                $(document).ready(function(){
                    $(".contenido").hide();
                    $("#envioArchivos").change(function(){
                    $(".contenido").hide();
                        $("#div_" + $(this).val()).show();
                    });
                });
            </script>

            
    </head>
    <body>
<?php



$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a> 
			<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes </a>";
			
echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Distribución de archivos</font>";
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
	
	$fecha = date("Y-m-d");
	echo "<form name='form' id='miForm' action='guardaEnvioArchivos.php' method='POST'  enctype='multipart/form-data' onsubmit='return valida(this)'>";	
	
	echo "<table border='0' align='center' width='700'>";
	
	echo "<tr>";
		echo "<td width='30'> </td>";
		echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Datos iniciales</b></td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td width='30'> </td>";
		echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
	echo "</tr>";
	
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Fecha</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
		
			echo "<input type='text' name='fecha' size=10 value='$fecha' readonly></td>";

		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Grupo</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
				echo "<input type='text' name='grupo' style='width:10%;height:23px;' value='GE' readonly>";
				
				echo "<input type='hidden' name='status' value='ASIGNAR'>";
				echo "<input type='hidden' name='usuario' value='$usuarioId'>";
				
			echo "</td>";
	echo"<tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Ciudad</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
				/*echo "<select name='ciudad' required>";
							echo "<option value='' selected='selected'>Elegir...</option>";	
							
							for($a = 1; $a <= 6; $a++){
								
								if(in_array($cdValor[$a], $ciudadesDisponibles)){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
									
								}
								
							} unset($a);
							
						echo "</select>";*/
						echo"<select name='ciudad' required>";
							echo "<option value='' selected='selected'>Elegir...</option>";
							$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'  AND U.xt_codigoCiudad != 'LAR'");
									while($p = $t->fetchRow()){
										$ciudades = $p[1];
										$cdValor  = $p[0];
																  
											echo"<option value='".$cdValor."'>".$ciudades."</option>";
												
									}
					echo"</select>";
			echo "</td>";
	echo"<tr>";
	
	echo"<tr height='20'> </tr>";
	

	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Título</td>";
	echo "</tr>";
	
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo"<textarea name='titulo' style='width: 400px; height: 20px;' required></textarea>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	

	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Solicitante original</td>";
	echo "</tr>";
	
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo"<textarea name='solicitante' style='width: 400px; height: 20px;' required></textarea>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Descripción del Requerimiento</td>";
	echo "</tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='10'> </td>";
		echo "<td id='iconosTexto2' align='left' colspan='3'>(Incluye RFC y nombre del cliente)</td>";
	echo "</tr>";				
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo"<textarea name='descripcion' style='width: 450px; height: 80px;' required></textarea>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	/*
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Tipo</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
				echo "<select id='envioArchivos' name = 'tipoEnvio'>";
					echo"<option></option>";
					echo'<option value="1">Mail envios pedimentos</option>';
					echo'<option value="2">Mail envios cuenta de Gastos</option>';
					echo'<option value="3">FTP envio pedimentos</option>';
					echo'<option value="4">FTP envio cuenta de gastos</option>';
				echo"</select>";
			echo "</td>";
	echo"<tr>";
	
	  echo"<tr>";
		echo"<td width='30'> </td>";
			echo"<td valign='bottom' align='left' colspan='2'>";
				echo'<div id="div_1" class="contenido">';
					echo"<p id='iconosTexto2'>Destinatarios</p>";
					echo"<textarea name='descripcion1' placeholder='Ejemplo: correo@ejemplo.com, correo1@ejemplo.com...' style='width: 450px; height: 80px;'></textarea><br><br>";
					echo"<p id='iconosTexto2'>RFC</p>";
					echo"<textarea name='RFC1' placeholder='Ejemplo: RFC1, RFC2..' style='width: 450px; height: 80px;'></textarea>";
					echo"<input type='hidden' name='tipo' value='Mail envios pedimentos'>";
				echo"</div>";
				echo'<div id="div_2" class="contenido">';
					echo"<p id='iconosTexto2'>Destinatarios</p>";
					 echo"<textarea name='descripcion2' placeholder='Ejemplo: correo@ejemplo.com, correo1@ejemplo.com...' style='width: 450px; height: 80px;'></textarea><br><br>";
					 echo"<p id='iconosTexto2'RFC</p>";
					 echo"<textarea name='RFC2' placeholder='Ejemplo: RFC, RFC2...' style='width: 450px; height: 80px;'></textarea>";
					 echo"<input type='hidden' name='tipo' value='Mail envios cuenta de Gastos'>";
				echo"</div>";
				echo'<div id="div_3" class="contenido">';
					echo"<p id='iconosTexto2'>Datos FTP</p>";
					echo" <textarea name='descripcion3' placeholder='Informacion del FTP para envio de pedimentos...' style='width: 450px; height: 150px;'></textarea><br><br>";
					echo"<p id='iconosTexto2'>RFC</p>";
					echo"<textarea name='RFC3' placeholder='Ejemplo: RFC1, RFC2..' style='width: 450px; height: 80px;'></textarea>";
					echo"<input type='hidden' name='tipo' value='FTP envio pedimentos'>";
				echo"</div>";
				echo'<div id="div_4" class="contenido">';
					echo"<p id='iconosTexto2'>Datos FTP</p>";
					 echo"<textarea name='descripcion4' placeholder='Informacion del FTP para envio de cuenta de Gastos...' style='width: 450px; height: 150px;'></textarea><br><br>";
					 echo"<p id='iconosTexto2'>RFC</p>";
					 echo"<textarea name='RFC4' placeholder='Ejemplo: RFC1, RFC2..' style='width: 450px; height: 80px;'></textarea>";
					 echo"<input type='hidden' name='tipo' value='FTP envio cuenta de gastos'>";
				echo"</div>";
			echo"</td>";
		echo"<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
*/	
	echo"<tr height='30'> </tr>";
	
	echo "<tr>";
		echo "<td width='30'> </td>";
		echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
	echo "</tr>";
	
						
	  echo"<tr height='40'>";
		  echo "<td width='30'> </td>";
		  echo"<td valign='bottom' align='right' colspan='4'>";
		  echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			//echo "<input type='submit' name='Enviar' src = 'Imagenes/ICN_BotonAgregar.png'>";
					//echo "<img width='90' height='29' src = 'Imagenes/ICN_BotonAgregar.png'></img>";
				echo "</input>";
		  echo"</td>";
	  echo"</tr>";

	echo "</table>";
	
 	echo "</form>";
echo "</div>";

?>
    	</body>
    </html>
    
<?php
/*
if($_POST['tipo'] != ''){
	$fecha         = $_POST['fecha'];
	$grupo         = $_POST['grupo'];
	$ciudad        = $_POST['ciudad'];
	$titulo        = $_POST['titulo'];
	$descripcionRequerimiento = $_POST['descripcion'];
	$solicitante   = $_POST['solicitante'];
	$asignaPDR   = 'Alberto_Martinez';   
	
	if($_POST["descripcion1"] != ''){
		$descripcion = $_POST["descripcion1"];
		$tipoEnvio   = $_POST["tipo"];
		$rfc         = $_POST["RFC1"];
	
	}else if($_POST["descripcion2"] != ''){		
		$descripcion = $_POST["descripcion2"];
		$tipoEnvio   = $_POST["tipo"];
		$rfc         = $_POST["RFC2"];		
	
	}else if($_POST["descripcion3"] != ''){		
		$descripcion = $_POST["descripcion3"];
		$tipoEnvio   = $_POST["tipo"];
		$rfc         = $_POST["RFC3"];		
	
	}else if($_POST["descripcion4"] != ''){		
		$descripcion = $_POST["descripcion4"];
		$tipoEnvio   = $_POST["tipo"];
		$rfc         = $_POST["RFC4"];		
	}

 	$anio   = date('Y', strtotime($_POST['fecha']));
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupo' ");
				while($r = $s->fetchRow()){	
					$maximo = $r[0];	
				} unset($r); unset($s);
							
	$maximo++;
	$año   = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		@$codigoNuevo = $codigo."-00".$maximo;
	}else if(strlen($maximo) == 2){		
		@$codigoNuevo = $codigo."-0".$maximo;		
	}else if(strlen($maximo) >= 3){		
		@$codigoNuevo = $codigo."-".$maximo;		
	}
	//Se crea codigo para la Solicitud
	 $codigoSolicitud = $grupo."-"."B"."-".$ciudad."-".$año.$codigoNuevo;
	 
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_solicitanteOriginal, xt_pdr) VALUES('EA', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcionRequerimiento', '$usuarioId', '$grupo', 'ASIGNADA', '$solicitante', '$asignaPDR') ")){
														   
		$INTRANET->Execute("INSERT INTO SGI_Backlog_Envio_Archivos(xt_quejaSolicitud,xt_rfc,xt_descripcionEnvio) VALUES ('$codigoSolicitud','$rfc','$descripcion')");
		
		//Envia a correo al PDR y Solicitante
		 
		if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) 
													VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){
														
														
			$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
			$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
			
			$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
			$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
	
			if(($correoPDRMail != "") && ($nombrePDRMail != "")){
					
				new MailSolicitudAsignar($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcionRequerimiento, $entregable = null);
			
			 }
			 $INTRANET->Execute("INSERT INTO SGI_Backlog_Documentos(xt_quejaSolicitud, xt_tipoDocumento, xt_nombreArchivo, xt_ruta, xt_usuario) VALUES ('$codigoSolicitud','$tipoEnvio', '', '','$usuarioId')");

	/*
		# si hay algun archivo que subir
		if($_FILES["archivo"]["name"][0])
		{
			# recorremos todos los arhivos que se han subido
			for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
			{
				$extension = pathinfo($_FILES['archivo']['name'][$i], PATHINFO_EXTENSION);  
						
					$carpetaDestino = "D:/INTRANET/documentosSolicitudes/";
					$directorioCompleto = $carpetaDestino.$codigoSolicitud;
					
					# si exsite la carpeta o se ha creado
					if(file_exists($directorioCompleto) || @mkdir($directorioCompleto))
					{
						$nombreNuevo = "Solicitud".$i."_".$codigoSolicitud.".".$extension;
						$nombreArchivo =$directorioCompleto."/".$nombreNuevo;
	
						# movemos el archivo
						if(@move_uploaded_file($_FILES["archivo"]["tmp_name"][$i], $nombreArchivo))
						{	
							$INTRANET->Execute("INSERT INTO SGI_Backlog_Documentos(xt_quejaSolicitud, xt_tipoDocumento, xt_nombreArchivo, xt_ruta, xt_usuario) VALUES ('$codigoSolicitud','$tipoEnvio', '$nombreNuevo', '$nombreArchivo','$usuarioId')");
							
							echo "<br>".$nombreNuevo." movido correctamente";
						}else{
							echo "<br>No se ha podido mover el archivo: ".$_FILES["archivo"]["name"][$i];
						}
					}else{
						echo "<br>No se ha podido crear la carpeta: up/".$directorioCompleto;
					}
			}
		}else{
			$INTRANET->Execute("INSERT INTO SGI_Backlog_Documentos(xt_quejaSolicitud, xt_tipoDocumento, xt_nombreArchivo, xt_ruta, xt_usuario) VALUES ('$codigoSolicitud','$tipoEnvio', '', '','$usuarioId')");
		}*/
		/*echo"<script language='javascript'>window.location='fichaEnvioArchivos.php?codigo=".urlencode($codigoSolicitud)."'</script>;";	
		
	}
					
		
 }else{
					
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
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center'>";
							echo"<tr>"; 
								echo"<td align='center'>";
									echo $breadcrumb;
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='70'><td></td></tr>";
							
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo"</td>";
							echo"</tr>";
						echo "</table>";
					echo "</div>";
	}
 
}*/
?>
    	</body>
    </html>
<?php

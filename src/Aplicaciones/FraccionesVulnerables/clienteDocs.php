<?php
/*
 *@author Abam Donoso Samantha
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
ini_set('display_errors', '1');
$nombrephp = 'clienteDocs.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Clientes Documentos</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
  
 $rfcCliente = $_GET['rfcCliente'];
	
	$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../aplicaciones.php' id='breadcrumbs'> Módulos / </a>
			   <a href='../operaciones.php' id='breadcrumbs'> Operaciones / </a><a href='homeFracciones.php' id='breadcrumbs'> Fracciones Vulnerables </a>";
			   
			   
	echo "<div id='wrapperFicha' align='center'>";
		echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
			echo "</tr>";
			
			echo"<tr height='80px'> </tr>";
			
			echo "<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Documentos Clientes</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='10'> </tr>";
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
		echo "</table>";
	
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		echo "<tr>";
			echo "<td align='center'>";
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
                                    <li>
                                    	<a href='../../Registros/tableroRegistros.php' id='breadcrumbs'>
                                        	Registros
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
	
echo"<form name='clienteArchivos' method='post' enctype='multipart/form-data'  action='clienteDocsSubir.php'>";	
	/*$s = $INTRANET->Execute("SELECT xt_nombreArchivo FROM master_ge.documentos_fracciones_vulnerables  WHERE xt_clienteRFC = '$rfcCliente'");
		while ($s = $r->fetRow()){
			$archivos = $r[0];	
		}
	*/
	echo "<table border='0' align='center' name='Cuerpo' width='700'>";
	
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		
		echo"<tr height='20'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' align='center'>Seleccione un archivo:</td>";
		echo "</tr>";
		
		echo"<tr height='10'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center'><input type='file' name='archivo'></td>";
		echo "</tr>";
		
		echo"<tr height='20'><td></td></tr>";
		
		echo"<tr>";
			echo"<td align='center'>";
				echo"<select name='nombresArchivos'>";
					echo "<option selected='selected'>Selecionar...</option>";
					echo "<option value='Acta'> Acta Constitutiva </option>";
					echo "<option value='Cedula'> Cédula Fiscal actualizada </option>";
					echo "<option value='Comprobante'> Comprobante de domicilio (no mayor a tres meses) </option>";
					echo "<option value='Poder'> Poder del representante legal </option>";
					echo "<option value='Identificacion'> Identificación oficial del representante legal </option>";
					echo "<option value='Constancia'> Constancia información del Dueño Beneficiario </option>";
					echo "<option value='Respuesta'> Respuesta a Constancia </option>";
					
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='20'><td><input id='rfcCliente' name='rfcCliente' type='hidden' value='$rfcCliente' /></td></tr>";
		
		echo"<tr>";
			echo"<td align='right'><input type='submit'   src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'> </td>";
		echo"</tr>";
		
		echo"<tr height='20'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
	     
    echo"</table>"; 
	
echo"</form>";
	$s = $INTRANET->Query("SELECT xt_nombreArchivo,	xt_tipoDocumento,xd_fechaRecepcion, xt_ruta FROM master_ge.documentos_fracciones_vulnerables  WHERE xt_clienteRFC = '$rfcCliente' AND xt_tipoDocumento != 'Selecionar...'");
$contador =1;
 echo "<table  style='min-width: 656px;'> <tr> <td>Documento</td><td>Tipo</td><td>Fecha carga</td><td> </td>"; 
		while($r = $s ->fetchRow()){
			
			$nombre 	= $r[0];
			$documento 	= $r[1];
			$fecha 	= $r[2];
			$ruta 	= "../../../".$r[3];
			$archivo =file_get_contents($ruta);  
			echo "<tr>";
				echo "<td align='left' >$contador.- $nombre</td>";
				 
				
				echo"<td > $documento </td>";
				echo"<td >  $fecha </td>"; 
				echo'<td >  <a href="data:Application/octet-stream,'.rawurlencode($archivo).'" download="'.$documento.substr($ruta, -4).'"> <img src="../../Imagenes/ICN_Boton_Azul.png"></a></td>'; 

				  
			echo "</tr>";

			$contador++;
		}
		 echo"</table>"; 

echo"</div>";

if($_POST['rfc'] != "" || NULL){
	
	$rfc = $_POST['rfc'];
	$nombreArchivo = $_POST['nombresArchivos'];
	if($nombreArchivo!="Selecionar..."){
	$archivo = '';
	$archivo = $_FILES['archivo']['name'];
	$archivo = limpiar_caracter_especial($archivo);
	
	//$INTRANET->Execute("INSERT INTO master_ge.documentos_fracciones_vulnerables  (xt_clienteRFC,xt_nombreArchivo,xd_fechaRecepcion)VALUES ('$rfc','$nombreArchivo',NOW())");
	
	 
           
       


	if ($archivo != ""){
			$destino = "../../FILES/$archivo";
			 echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				$INTRANET->Execute("UPDATE master_ge.documentos_fracciones_vulnerables  SET xt_ruta = '$destino' WHERE xt_clienteRFC = '$rfc' AND xt_nombreArchivo = '$nombreArchivo'");			
			}
	}else{
		
		echo" Hubo un error en la carga! ";
			
	}
}
else{
		echo" Selecciona una opcion";
}

}
	   
 ?>

</body>
</html>
<?php
header('Content-Type: text/html; charset=UTF-8');
$nombrephp = 'agregarActividadPopUp.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");

$proceso       = $_GET['proceso'];
$actividad     = $_GET['actividad'];
$rol           = $_GET['rol'];
$funcionalidad = $_GET['funcionalidad'];
$casoUso       = $_GET['casoUso'];

$versionReciente 	  = "";
$fechaVersionReciente = "";

//Obtengo el nombre de la funcionalidad

$nomProceso   = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Procesos WHERE xt_CodigoCorto = '$proceso'");
$roles 		  = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Catalogo_Roles WHERE xt_codigo = '$rol'");
$nomActividad = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Catalogo_Actividades WHERE xt_codigo = '$actividad'");
$nomFuncionalidad = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Catalogo_Funcionalidades WHERE xt_codigo = '$funcionalidad'");
$nomCasoUso = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Caso_Uso WHERE xt_codigoCasoUso = '$casoUso'");

$a = $INTRANETV2->Execute("SELECT
							SCM.xt_nombre,
							P.xt_codigoManual
						FROM
							INTRANET2.SGI_Procesos P,
							INTRANET2.SGI_Catalogo_Manuales SCM
						WHERE
						P.xt_codigoCorto = '$proceso'
						AND P.xt_codigoManual = SCM.xt_codigoManual
");
while($j = $a->fetchRow()){
	
	$nombreManual    = $j[0];
	$codManual       = $j[1];	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <script type="text/javascript" src="../JS/jquery-1.9.1.js"></script>
        <head>
        
        	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
			<title>Ficha de caso de uso</title>
			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
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

            <script type="text/javascript">
                function casosdeUso(){

                    var vDescripcion=document.getElementById("listCasoUso");
                    if(vDescripcion.style.display == 'block') {
                        vDescripcion.style.display = 'none';
                    } else {
                        vDescripcion.style.display = 'block';
                    }
                }
            </script>
            <script>
				function mostrarIframe(capa){
					var mostrar = document.getElementById(capa);
					if(mostrar.style.display == 'block'){
						mostrar.style.display = 'none';
					}else{
						mostrar.style.display = 'block';
					}
				}
			</script>
            <script>
				 function activaModifica(descripcion){
				
					var vDescripcion=document.getElementById('descripcionAct');
					var vBtnModif=document.getElementById('btnModificar');
					var vBtnModif2=document.getElementById('modifP2');
					var vBtnModif3=document.getElementById('modifP3');

					if(vDescripcion.style.display == 'block') {

						document.getElementById ('nuevaDescripcion').value = descripcion;
						vDescripcion.style.display = 'none';
						vBtnModif2.style.display = 'block';
						vBtnModif3.style.display = 'block';

					} else {

						vDescripcion.style.display = 'block';
						vBtnModif2.style.display = 'none';
						vBtnModif3.style.display = 'none';
					}

				
				}
             	function mostrarFuncionalidad(proceso, rol, actividad, funcionalidad) {
					boton1     = document.getElementById('modificaFuncionalidad1');
					boton2     = document.getElementById('modificaFuncionalidad2');
					
					if(proceso != '' && rol != '' && actividad != '' && funcionalidad != ''){
						boton2.style.display='block';
						boton1.style.display='none';
					}
					else {
						
					}
				}
				 
				function actualizaDescripcion(proceso, rol, actividad, funcionalidad, casoUso) {
					
					var descripcion = document.getElementsByName("descripcion")[0].value;
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizaFichaCasoUso(proceso,rol,actividad,funcionalidad, casoUso);
							}else{
								alert("hubo un error al actualizar descripcion");
							}
						}
					};

					xhttp.open("POST", "agregaDescripcionCasoUso.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizaDescripcion&descripcion="+ descripcion +"&proceso="+ proceso + "&rol=" + rol +"&actividad="+ actividad +"&funcionalidad="+ funcionalidad+"&casoUso="+ casoUso);
				}
				//Funcion para actualizar Funcionalidad
				function actualizarCasoUso(proceso, rol, actividad, funcionalidadOld, casoUso) {
					
					var nuevaFuncionalidad   = document.getElementsByName("funcionalidad")[0].value;
					var separaFuncionalidad = nuevaFuncionalidad.split("|");
					var codigoFuncionalidad  = separaFuncionalidad[0];
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizaFichaCasoUso(proceso,rol,actividad,codigoFuncionalidad, casoUso);
							}else{
								actualizaFichaCasoUso(proceso,rol,actividad,funcionalidadOld, casoUso);
							}
						}
					};

					xhttp.open("POST", "agregaDescripcionCasoUso.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizarFuncionalidad&proceso="+ proceso +"&rol="+ rol + "&actividad="+ actividad + "&funcionalidadOld="+ funcionalidadOld + "&nuevaFuncionalidad="+ nuevaFuncionalidad);
				}
				
				function actualizaFichaCasoUso(proceso, rol, actividad, funcionalidad, casoUso) {
					window.location.href = 'fichaCasoUsov2.php?proceso=' + proceso + '&rol=' + rol + '&actividad=' + actividad + '&funcionalidad=' + funcionalidad+ '&casoUso=' + casoUso;
				}
				
             </script>
             
             <script>
				function mostrarIframe(capa){
					var mostrar = document.getElementById(capa);
					if(mostrar.style.display == 'block'){
						mostrar.style.display = 'none';
					}else{
						mostrar.style.display = 'block';
					}
				}
			</script>
           
            
        </head>
        <body>
<?php

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='manualesv3.php' id='breadcrumbs'> Manuales / </a><a href='fichaManualv3.php?codManual=$codManual' id='breadcrumbs'> $nombreManual </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
		echo "<tr>";
			echo "<td align='left' id='iconosTexto2'>Versión: ".$versionReciente."</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Fecha de última actualización: ".$fechaVersionReciente."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";

	echo "</table>";
	
	//codigo de menu navegable
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>$nomCasoUso</font>";
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
	echo "</table>";

			
	//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
			include("../../navegacion_banana.php");
		echo "</table>";
		

	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
echo"</table>";

echo "<div id='contDescripcion'>";
	//CODIGO DEL REPORTE
	echo "<table border='0' align='center' name='Cuerpo'>";
		echo "<tr>";
			echo "<td align='left' width='100%' id='titulo2'>Código de caso de uso</td>";
			echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'></td>";
		echo "</tr>";                
		//Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
		echo "</tr>";            
		echo "<tr height='25'></tr>";            
	echo"</table>";
	
	
	echo "<table border='0' cellspacing='0' width='100%' >";
		echo "<tr id='modificaFuncionalidad1'>";
			echo "<td style='padding:0px 0px 0px 25px'>";
				echo "<font size='4px'>".$casoUso.": ".$nomCasoUso."</font>";
			echo"</td>";
		
		echo "</tr>";
 
		echo '<tr id="modificaFuncionalidad2" style="display: none;">';
			echo "<td style='padding:0px 0px 0px 25px'>";
				echo "<select name='funcionalidad' id='funcionalidad'>";
					echo "<option value=''>Selecciona........</option>";
					$ii = $INTRANETV2->Execute("SELECT xt_codigo, xt_nombre FROM SGI_Catalogo_Funcionalidades");
					while($i = $ii->fetchRow()){
						$nombreFuncionalidad = $i[1];
						$codigoFuncionalidad = $i[0];
						
						echo "<option value='".$codigoFuncionalidad.'|'.$nombreFuncionalidad."'>$nombreFuncionalidad</option>";   
					}
				echo "</select>";
			echo "</td>";
			echo "<td align='center'>";
				echo'<a  style="float:right;cursor:pointer;" onClick="actualizarFuncionalidad(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\', \''.$funcionalidad.'\')"><font color="#007CBD">Guardar</font></a>';
			echo "</td>";
		echo "</tr>";

		echo "<tr height='25'></tr>";   

	echo"</table>";
	echo "<br>";
	//ACTIVIDAD RELACIONADA
	echo "<table border='0' align='center' name='Cuerpo'>";
		echo "<tr>";
			echo "<td align='left' width='100%' id='titulo2'>Funcionalidad relacionada</td>";
			echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'></td>";
		echo "</tr>";                
		//Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
		echo "</tr>";            
		echo "<tr height='25'></tr>";            
	echo"</table>";
	echo "<table border='0' cellspacing='0'>";
		echo "<tr>";
			echo "<td style='padding:0px 0px 0px 25px;'>";

				echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaFuncionalidadCasoUso.php?proceso=$proceso&actividad=$actividad&rol=$rol&funcionalidad=$funcionalidad'><font size='4px'>".$funcionalidad.": ".$nomFuncionalidad."</font></a>";
			echo "</td>";
		echo "</tr>";
		echo "<tr height='25'></tr>";           
	echo"</table>";
	
	//DESCRIPION

	echo "<table border='0' align='center' name='Cuerpo'>";

		echo "<tr>";
			echo "<td align='left' width='100%' id='titulo2'>Descripción</td>";
			echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
			echo "</td>";
		echo "</tr>";
		
		//Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
		echo "</tr>";
	
		echo "<tr height='25'></tr>";
	
	echo"</table>";
	
	//obtengo la descripcion
	
	 $desCU = $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Caso_Uso WHERE xt_codigoCasoUso = '$casoUso' AND xt_codigoFuncionalidad = '$funcionalidad' AND xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'");
	
	echo "<table border='0' width='100%' cellspacing='0'>";
		if($desCU != ''){
			
			//echo $desFunc."----1";
			echo "<tr>";
				echo "<td style='padding:0px 0px 0px 25px;' id='modifP2'>";
					echo $desCU; 
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
	  
			echo "</tr>";
			echo "<tr>";	
				echo "<td padding:0px 0px 0px 25px;' id='descripcionAct' style='display:none;'>";
					echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" />'.$desCU.'</textarea>';
					echo'<a  style="float:right;cursor:pointer;" onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\', \''.$funcionalidad.'\',\''.$casoUso.'\')" name="evento" border:none; cursor:pointer;"><font color="#007CBD">Actualizar</font></a>';
				echo "</td>";
			echo "</tr>";
		}else{
			//echo $desFunc."----2";
			echo "<tr>";	
				echo "<td padding:0px 0px 0px 25px;'>";
					echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" /></textarea>';
					echo'<a  style="float:right;cursor:pointer;" onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\', \''.$funcionalidad.'\',\''.$casoUso.'\')" name="evento" border:none; cursor:pointer;"><font color="#007CBD">Actualizar</font></a>';
				"</td>";
			echo "</tr>";					
		}	
		echo "<tr height='25'></tr>";	

	echo"</table>";
	
	//Seccion de documentacion
	 $parametros = $proceso.",".$rol.",".$actividad.",".$funcionalidad.",".$casoUso;
	
	echo "<table border='0' align='center' name='Cuerpo'>";

		echo "<tr>";
			echo "<td align='left' width='100%' id='titulo2'>Documentación</td>";
			echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
			echo "</td>";
	
			 echo "<td width='15px'>";
				?>
					<a href='javascript:void(0);' onclick='mostrarIframe("archivoCU");'><img  src="../../../INTRANET_GEA/Imagenes/ICN_NuevoDoc.png" height='15' width='15'/></a>     
				<?php
				echo "</td>";
	
		echo "</tr>";
		
		//Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
		echo "</tr>";
	
		echo "<tr height='25'></tr>";
	
	echo"</table>";
	
	 //fila del formulario para subir archivo
	echo "<table border='0' style='width: 90%' cellspacing='0'>";
		echo "<tr id='archivoCU' style='display: none'>";
			echo "<td width='250px'></td>";
			echo "<td>";

				echo "<div id='divFile'>";
					echo "<iframe src='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/uploadArchivosCUv2.php?codigo=".$casoUso."&usuario=".$usuarioId."&codProceso=".$proceso."&nombrephp=fichaCasoUsov2.php&parametros=$parametros' frameborder='0' width='800px' height='150px'></iframe><br>";
				echo "</div>";
			echo"</td>";
		echo "</tr>";
		echo "<tr height='10'></tr>";
	echo "</table>";
	
	
	//listo los documentos
	 echo "</table>";

		$doc = $INTRANETV2->Execute("SELECT xt_nombreArchivo, xt_ruta FROM SGI_Casos_Uso_Archivos WHERE xt_codigoCasoUso = '$casoUso' AND xt_codigoFuncionalidad = '$funcionalidad' AND xt_codigoActividad = '$actividad' AND xt_codigoRol = '$rol' AND xt_codigoProceso = '$proceso'");
		

		$numDoc = 0;
		while ($listA = $doc -> fetchRow()){
			if(!empty($listA[0])){
				//echo"$listA[0]--$listA[3]---";
				echo "<table border='0' width='90%'>";
					echo "<tr>";
						echo "<td width='30px'></td>";
						echo "<td style='padding:0px 0px 0px 15px;' width='560px'><font size=2>$listA[0]</font></td>";
						
						echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/eliminaDoctosCU.php?codigo=".$casoUso."&nombreA=".$listA[0]."&ruta=".$listA[1]."&nombrephp=fichaCasoUsov2.php&parametros=".$parametros."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
						
						echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/extraccionDoctosReporte.php?nombreA=".$listA[0]."&ruta=".$listA[1]."'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a></td>";
					echo "</tr>";

					echo "<tr>";
						echo "<td width='30px'></td>";

					echo "</tr>";

					echo "<tr height='10'></tr>";
				echo "</table>";
			}//fin del if de verificaion de que exite archivo
			$numDoc ++;
		}//fin del while de archivos*/
	echo "</table>";

echo "<br><br><br>";
	
echo "<table border='0' align='center' name='Cuerpo' width='100%'>";
	echo "<tr>";
		echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td id='nota_al_pie'>";
			echo "<center>Created by: Grupo Escalante Agencias Aduanales.</center>";
		echo "</td>";
	echo "</tr>";
echo "</table>";
echo "<br><br>";
	

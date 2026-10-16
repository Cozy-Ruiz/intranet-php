<?php error_reporting(0); ?>
<?php
$nombrephp = 'tableroRoles.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$funcionalidad = $_GET['funcionalidad'];
$actividad     = $_GET['actividad'];
$rol           = $_GET['rol'];
$proceso       = "K0050";
$casoUso       = $_GET['casoUso'];

//Obtengo el nombre de la funcionalidad
$nomProceso   = $INTRANET->getOne("SELECT xt_Nombre FROM SGI_K_Procesos WHERE xt_CodigoCorto = '$proceso'");
$roles 		  = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Roles WHERE kp_codigo = '$rol'");
$nomActividad = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Actividades WHERE kp_codigo = '$actividad'");
$nomFuncionalidad = $INTRANET->getOne("SELECT xt_nombre FROM SGI_K_Funcionalidades WHERE kp_codigoFuncionalidad = '$funcionalidad'");
$nomCasoUso = $INTRANET->getOne("SELECT xt_nombre FROM SGI_K_Caso_Uso WHERE kp_codigoCasoUso = '$casoUso'");

/*
$banderaVersion = 0;
$i = 1;

$s = $INTRANET->Execute("SELECT SCI.xd_fecha, SCI.xn_numero, SCI.xt_descripcion, (SELECT E.xt_iniciales FROM SGI_Empleados E WHERE E.kf_usuario = SCI.xt_usuario) FROM SGI_Control_Cambios_Inventario SCI WHERE SCI.kp_codigo = '$codigo' ");

while($r = $s->fetchRow()){
	$fechaVersion[$i] 	= date('Y-m-d', strtotime($r[0]));
	$version[$i] 		= $r[1];
	$cambioDesc[$i] 	= $r[2];
	$iniciales[$i] 		= $r[3];
	
	$i++;
	$banderaVersion++;
	
} unset($r); unset($i);

if($banderaVersion == 0){
	$versionImprime = 0;
	$fechaVersionImprime = date('Y-m-d', strtotime($fechaCreacion));
} else{
	$versionImprime = $version[1];
	$fechaVersionImprime = date('Y-m-d', strtotime($fechaVersion[1]));
}


$w = $INTRANET->Execute("SELECT
							SCI.xd_fecha,
							SCI.xn_numero
						FROM
							SGI_Control_Cambios_Inventario SCI
						WHERE
							SCI.kp_codigo = '$codigo'
						AND SCI.xn_numero =(SELECT MAX(I.xn_numero) FROM SGI_Control_Cambios_Inventario I WHERE SCI.kp_codigo = '$codigo');
						");
while($h = $w->fetchRow()){
	$fechaVersionReciente = date('Y-m-d', strtotime($h[0]));
	$versionReciente       = $h[1];

}

$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigo' ");
*/
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
            <!--
             <script>
             	function muestraEdicion(status, codigoOld){
             		var capa = document.getElementById(status);
					if(status == 'valor'){
					var capa2 = document.getElementById("modificar");
						capa.style.display = 'none';
						capa2.style.display = 'block';
					}else if(status == 'modificar'){
						var capa2 = document.getElementById("valor");
						capa2.style.display = 'block';
						capa.style.display = 'none';
						var actividades=document.getElementById("actividades").value;
                	 	var funcionalidad=document.getElementById("funcionalidad").value;
						
						$.post("modificarProceso.php",{actividades : actividades, funcionalidad : funcionalidad, codigoOld : codigoOld},function(data){
							$("#valor").html(data);
						});
					}
             	}
             </script>
            
            <script>
			
				function inCambioDes(){
					
					var descripcion=document.getElementById("nuevaDescripcion").value;
					var codigoFuncionalidad = "<?php echo $funcionalidad;?>";
					
					var FuncionalidadLiberada = "<?php echo $inventarioLiberado;?>";
					
					 $('#contDescripcion').load("agregaDescripcionCambioFuncionalidad.php", {descripcion:descripcion, codigoFuncionalidad:codigoFuncionalidad}, function(data){
						 
						if(FuncionalidadLiberada != '') {
							 
							  window.location = "ControlCambiosInventarios.php?codigo="+"<?php echo $codigo; ?>";
						 }
						 
    				 });
					 
					 
					 
				}
				
			</script>
            
            <script>
			function activaModificaD(descripcion){
				
				
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
			
			</script>-->
            
               <!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
			<!--<script language="javascript" type="text/javascript">
                function iluminaLibera(celda){
					
				 var codigo  = "<?php echo $codigo;?>";
				 var usuario = "<?php echo $usuarioId;?>";
				 var tipo    = 'Funcionalidad';
				 
  					window.location = "liberaItem.php?codigo="+"<?php echo $codigo; ?>"+"&tipo="+tipo+"&usuario="+usuario+"";				
				}
				
            </script>-->


            
        </head>
        <body>
<?php

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='Procesos.php' id='breadcrumbs'> Inventario de procesos </a>";

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
	echo "</table>";

			
			//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../navegacion_banana.php");
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
			
			/*
            echo "<table border='0' cellspacing='0'>";
                echo "<tr id='valor'>";
                    echo "<td style='padding:0px 0px 0px 25px;'>";
                        echo "<font size='4px'>".$funcionalidad.": ".$nombreFuncionalidad."</font>";
                    echo "</td>";
                    echo "<td id='resultado'>";
                    echo "</td>";
                    echo "<td style='float:right;width:80%;'>";
                    ?>
                    	<a href='javascript:void(0);' onclick='muestraEdicion("valor","<?php echo $codigo; ?>");' style='color:#007CBD;'>Editar</a>
                    <?php
                    echo "</td>";
                echo "</tr>"; 
                $cd = explode("_",$codigo);
                 //echo "SELECT A.kp_codigo, A.xt_nombre FROM SGI_Roles_Actividades RA, SGI_Actividades  A WHERE RA.kp_codigo LIKE '$cd[0]%' AND RA.kf_codigoActividad = A.kp_Codigo ORDER BY A.xn_consecutivo ASC";
                echo "<tr id='modificar' style='display:none;'>";
                	echo "<td>";

                		echo "<select name='actividades' id='actividades'>";
                			echo "<option value='nada'>Selecciona........</option>";
                			$ii = $INTRANET->Execute("SELECT
											A.kp_codigo,
											A.xt_nombre
										FROM
											SGI_Procesos_Roles_Actividades RA,
											SGI_Actividades A
										WHERE
											RA.kp_codigo LIKE '$cd[0]%'
										AND RA.kf_codigoActividad = A.kp_Codigo
										ORDER BY
											A.xt_nombre ASC");
                			while($i = $ii->fetchRow()){
                				echo "<option value=".$i[0].">".$i[0]." - ".$i[1]."</option>";
                			}
                		echo "</select>";
                	echo "</td>";
                	echo "<td>";
                		echo "<select name='funcionalidad' id='funcionalidad'>";
                			echo "<option value='nada'>Seleccion........</option>";
                			//$ii = $INTRANET->Execute("SELECT DISTINCT (CT.kp_tiempo) FROM SGI_Catalogo_Tiempos CT, SGI_Procesos_Roles_Actividades RA WHERE RA.kp_codigo LIKE '$cd[0]%' AND RA.xt_tiempo = CT.kp_tiempo ORDER BY xn_consecutivo ASC");
                			$ii = $INTRANET->Execute("SELECT kp_codigo, xt_nombre FROM SGI_Funcionalidades");
                			while($i = $ii->fetchRow()){
                				echo "<option value=".$i[0].">".$i[0]." - ".$i[1]."</option>";
                			}
                		echo "</select>";
                	echo "</td>";
                	 echo "<td style='float:right;'>";
                	 ?>
                    	<a href='javascript:void(0);' onclick='muestraEdicion("modificar","<?php echo $codigo; ?>");' style='color:#007CBD;'>Modificar</a>
                    <?php
                    echo "</td>";
                echo "</tr>";
                echo "<tr height='25'></tr>";           
            echo"</table>";*/
			echo "<table border='0' cellspacing='0' width='100%' >";
                echo "<tr id='modificaFuncionalidad1'>";
                    echo "<td style='padding:0px 0px 0px 25px'>";
                        echo "<font size='4px'>".$casoUso.": ".$nomCasoUso."</font>";
		 			echo"</td>";
		 			/*echo "<td align='right'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="mostrarFuncionalidad(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\', \''.$funcionalidad.'\')"><font color="#007CBD">Modificar</font></a>';
                    echo "</td>";*/
                echo "</tr>";
		 
		 		echo '<tr id="modificaFuncionalidad2" style="display: none;">';
                    echo "<td style='padding:0px 0px 0px 25px'>";
						echo "<select name='funcionalidad' id='funcionalidad'>";
                			echo "<option value=''>Selecciona........</option>";
                			$ii = $INTRANET->Execute("SELECT kp_codigo, xt_nombre FROM SGI_Funcionalidades");
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
			
			 $desCU = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_K_Caso_Uso WHERE kp_codigoCasoUso = '$casoUso' AND kf_codigoFuncionalidad = '$funcionalidad' AND kf_codigoActividad = '$actividad' AND kf_codigoRol = '$rol' AND kf_codigoProceso = 'K0050'");
			
			echo "<table border='0' width='100%' cellspacing='0'>";
				if($desCU != ''){
					
					//echo $desFunc."----1";
					echo "<tr>";
						echo "<td style='padding:0px 0px 0px 25px;' id='modifP2'>";
							echo $desCU; 
						echo "</td>";
					echo "</tr>";
                    echo "<tr>";
                       /*cho "<td id='modifP3'>";
                            ?>
                            <a  style='float:right;cursor:pointer;' onClick="activaModifica('<?php echo $desCU; ?>')"><font color='#007CBD'>Modificar</font></a>
                            <?php
                        echo "</td>";*/
                    echo "</tr>";
					echo "<tr>";	
						echo "<td padding:0px 0px 0px 25px;' id='descripcionAct' style='display:none;'>";
							echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" />'.$desCU.'</textarea>';
							/*<button onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\', \''.$funcionalidad.'\')" name="evento" style="background-color:rgb(0,249,0); border:none; cursor:pointer;">
										<b>Agregar</b>
									</button>';*/
							echo'<a  style="float:right;cursor:pointer;" onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\', \''.$funcionalidad.'\',\''.$casoUso.'\')" name="evento" border:none; cursor:pointer;"><font color="#007CBD">Actualizar</font></a>';
						echo "</td>";
					echo "</tr>";
				}else{
					//echo $desFunc."----2";
					echo "<tr>";	
						echo "<td padding:0px 0px 0px 25px;'>";
							echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" /></textarea>';
							/*<button onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\', \''.$funcionalidad.'\')" name="evento" style="background-color:rgb(0,249,0); border:none; cursor:pointer;">
										<b>Agregar</b>
									</button>';*/
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
                            <a href='javascript:void(0);' onclick='mostrarIframe("archivoCU");'><img  src="../../INTRANET_GEA/Imagenes/ICN_NuevoDoc.png" height='15' width='15'/></a>     
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
							echo "<iframe src='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/uploadArchivosCU.php?codigo=".$casoUso."&usuario=".$usuarioId."&codProceso=".$proceso."&nombrephp=fichaCasoUsov2.php&parametros=$parametros' frameborder='0' width='800px' height='150px'></iframe><br>";
						echo "</div>";
					echo"</td>";
				echo "</tr>";
				echo "<tr height='10'></tr>";
			echo "</table>";
			
			
			//listo los documentos
			 echo "</table>";
                      
                    //consulto archivo correspondiente al tipo de documento
			//	echo"SELECT xt_nombreArchivo, xt_usuario, xd_fecha, xt_rutaArchivo FROM SGI_Documentos_Procesos WHERE xt_tipoDocumento = '$row[0]' AND xt_codigo = '$codigo'";
				$doc = $INTRANET->Execute("SELECT xt_nombreArchivo, xt_ruta FROM SGI_Casos_Uso_Archivos WHERE xt_codigoCasoUso = '$casoUso'");
				

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

								//echo "<td style='color:#636262; padding:0px 0px 0px 30px'><i><font size=2>$listA[1], $listA[2]</font></i></td>";
							//echo "<td>[Nombre Usuario] 2015-11-22 14:28:00</td>";
							echo "</tr>";

							echo "<tr height='10'></tr>";
						echo "</table>";
					}//fin del if de verificaion de que exite archivo
					$numDoc ++;
				}//fin del while de archivos*/
			echo "</table>";

			
			
			
			
			/*
			
       
            //Caso de Uso 
            echo "<table border='0' align='center' name='Cuerpo'>";
                echo "<tr>";
                    echo "<td align='left' width='100%' id='titulo2'>Caso de uso</td>";
                    echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
                    
                    ?>
                    <td><a  onClick="casosdeUso()"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>
                    <?php               
                echo "</tr>";
                ///Linea
                echo "<tr>";
                    echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
                echo "</tr>";
                
                echo "<tr height='15'></tr>";
                
                echo  "<tr>";
                    echo "<td style='padding: 0px 0 px 0px 25px'>";
                        $ca = $INTRANET->Execute("SELECT kp_codigoCasodeUso, xt_nombre FROM SGI_K_Casosdeuso WHERE kf_codigoFuncionalidad = '$funcionalidad'");
                        if($ca->recordCount() >0){
                            while($cca = $ca->fetchRow()){

                                echo "<b style='padding:0px 0px 0px 25px;'><a href='fichaCasosdeUso.php?CasoUso=$cca[0]'>$cca[0]</a> - $cca[1]</b><br><br>";
                            }
                        }
                    echo "</td>";
                echo "</tr>";
                echo "<form  name='asignaFuncionalidad' method='post' action='fichaFuncionalidadCasoUso.php?codigo=$funcionalidad'>";
                    echo "<tr id='listCasoUso' style='display:none'>";
                        echo "<td style='padding:0px 0px 0px 150px' colspan='2'>";
                            echo "<input type='text' name='casoUso' placeholder='Caso de uso' style='width:400px;'><br><br>";
                            echo "<textarea name='descripcion' rows='5' cols='48' placeholder='Descripción......'></textarea>";
                            echo "<input type='hidden' name='funcionalidad' value='$funcionalidad' width='50'><br><br>";
                            echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
                        echo "</td>";                        
                        echo "<td>";                            
                        echo "</td>";
                    echo "</tr>";
                echo "</form>";
            echo "</table>";
        echo "</div>";
		//
		
		//DOCUMENTACION
		echo "<table border='0' align='center' width='100%' cellspacing='0'>";
			
			echo "<tr>";
				echo "<td align='left' width='685px' id='titulo2'>Documentación</td>";
				echo "<td width='15px'><a href='tipoDoctosPopUp.php?funcionalidad=".$funcionalidad."&usuario=$usuarioId&nombre=fichaFuncionalidadCasoUso' target='popup' onclick=\"window.open(this.href,this.target,'width=360,height=580,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";   
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				 echo "</td>";
			echo "</tr>"; 
			
			echo "<tr height='15'></tr>";
			
		echo "</table>";
		
		
            
            //Listo todos los tipos de documentación
            //echo "SELECT xt_tipoDocumento FROM SG_Backlog_Documentos WHERE xt_quejaSolicitud = '$solicitudID'";
            $s = $INTRANET->Execute("SELECT DISTINCT xt_tipoDocumento FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso WHERE xt_codigo = '".$codigo."'");
            
            $indexTotalDoc = 0;
            $trPos = 0;
            while($row = $s->fetchRow()){   
                $trPos ++;
                $trPosF = "trFile".$trPos;
                
                echo "<table border='0' width='100%'>";
                
                    echo "<tr>";
                        echo "<td>";
                                echo "<input type='hidden' name='tipoDoc' id='tipoDoc' value='$row[0]'>";
                                //echo "<b> $row[0] </b>";
                                echo "<br>";
                            echo "</td>";
                    echo "</tr>";
                
                    echo "<tr>";
                        echo "<td width='30px'></td>";
                        echo "<td align='left' style='font-size:16px;color:#007CBD;'>$row[0]</td>";
                        echo "<td width='15px'></td>";
                        echo "<td width='15px'>";
                        ?>
                            <a href='javascript:void(0);' onclick='mostrarIframe("<?php echo $trPosF; ?>");'><img  src="../../INTRANET_GEA/Imagenes/ICN_NuevoDoc.png" height='15' width='15'/></a>     
                        <?php
                        echo "</td>";
                    echo "</tr>";
                
                    echo "<tr>";
                        echo "<td width='30px'></td>";
                        echo "<td colspan='3'   style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
                        echo "</td>";
                    echo "</tr>";
					
					echo "<tr height='10'></tr>";
       			  echo "</table>";
                      
                    //consulto archivo correspondiente al tipo de documento
					//echo"SELECT  xt_nombreArchivo, xt_usuario, xd_fecha, xt_rutaArchivo FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso WHERE xt_tipoDocumento = '$row[0]' AND xt_codigo = '$codigoAct'";
                    $doc = $INTRANET->Execute("SELECT xt_nombreArchivo, xt_usuario, xd_fecha, xt_rutaArchivo FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso WHERE xt_tipoDocumento = '$row[0]' AND xt_codigo = '".$codigo."'");
                
                    $numDoc = 0;
                    while ($listA = $doc -> fetchRow()){
                        if(!empty($listA[0])){
							//echo"$listA[0]--$listA[3]---";
                            echo "<table border='0' width='100%'>";
                                echo "<tr>";
                                    echo "<td width='30px'></td>";
                                    echo "<td style='padding:0px 0px 0px 15px;'><font size=2>$listA[0]</font></td>";
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/eliminaDoctosFichaActividad.php?codigo=".$codigo."&proceso=".$proceso."&actividad=".$actividad."&nombrephp=fichaFuncionalidadCasoUso.php&rol=".$rol."&nombreA=".$listA[0]."&ruta=".$listA[3]."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/extraccionDoctosReporte.php?nombreA=".$listA[0]."&ruta=".$listA[3]."'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a></td>";
                                echo "</tr>";
                
                                echo "<tr>";
                                    echo "<td width='30px'></td>";
                        
                                    echo "<td style='color:#636262; padding:0px 0px 0px 30px'><i><font size=2>$listA[1], $listA[2]</font></i></td>";
                                //echo "<td>[Nombre Usuario] 2015-11-22 14:28:00</td>";
                                echo "</tr>";
                                
                                echo "<tr height='10'></tr>";
                            echo "</table>";
                        }//fin del if de verificaion de que exite archivo
                        $numDoc ++;
                    }//fin del while de archivos*/
          /*      echo "</table>";
                //fila del formulario para subir archivo
                echo "<table border='0' style='width: 100%' cellspacing='0'>";
                    echo "<tr id='$trPosF' style='display: none'>";
                        echo "<td width='250px'></td>";
                        echo "<td>";
						
                            echo "<div id='divFile'>";
                                echo "<iframe src='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/uploadArchivosActividadFuncionalidad.php?codigo=".$codigo."&proceso=".$proceso."&actividad=".$actividad."&rol=".$rol."&tipoArchivo=".$row[0]."&usuario=".$usuarioId."&nombrephp=fichaFuncionalidadCasoUso.php' frameborder='0' width='800px' height='150px'></iframe><br>";
                            echo "</div>";
                        echo"</td>";
                    echo "</tr>";
					echo "<tr height='15'></tr>";
                echo "</table>";
           // echo "</div>";
	
			}
			*/
			/*
		
		$s = $INTRANET->Execute("SELECT
								(
									SELECT
										CONCAT(
											U.xt_Nombre,
											' ',
											U.xt_ApellidoPaterno,
											' ',
											U.xt_ApellidoMaterno
										)
									FROM
										SGI_Empleados U
									WHERE
										U.kf_usuario = SL.xt_usuario
								),
								SL.xd_fecha
							FROM
								SGI_Libera_Inventarios SL
							WHERE
								SL.kp_codigo = '$codigo'
							AND SL.xt_tipo = 'Funcionalidad' ");
		
		while($r = $s->fetchRow()){
			$usuarioLibera = $r[0];
			$fechaLibera   = $r[1];
			
		} unset($r);
		
		echo "<table border='0' align='center' width='100%' cellspacing='0'>";
			
			echo "<tr>";
				echo "<td align='left' width='685px' id='titulo2'>Liberación de funcionalidad</td>";
				echo "<td width='15px'></td>";   
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				 echo "</td>";
			echo "</tr>"; 
			
			echo "<tr height='10'></tr>";
			
		echo "</table>";

		
	//	echo "<table border='0' align='center' width='100%' cellspacing='0'>";
		
			if($usuarioLibera == ''){
				echo "<table border='0' align='center' width='100%' cellspacing='0'>";
					echo"<tr height='10px'> </tr>";
					?>
                        <tr id='iconosTexto'>
                           <td align='center' width="400px"> </td>
                       	   <td style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27" onClick="iluminaLibera('tdLibera')"><font color="white">LIBERAR</font> </td>
                           <td align='center' width="400px"> </td>
    
    
                        </tr>
                    <?php
					echo"<tr height='20px'> </tr>";
				echo "</table>";
				
			
			}else{
				echo "<table border='0' align='center' width='100%' cellspacing='0'>";
					echo"<tr height='10px'> </tr>";
					?>
                        <tr id='iconosTexto'>
                            <td align='center' width="400px"> </td>
                            <td align="center" width="200px" bgcolor="#42CB27"><font color="white">LIBERADA</font></td>
                           <td align='center' width="400px"> </td>
    
    
                        </tr>
                    <?php
				echo "</table>";
				
				echo "<table border='0' align='center' width='100%' cellspacing='0'>";
					echo"<tr height='5px'> </tr>";
					
						echo "<tr id='iconosTexto'>";
							echo "<td align='center' width='200px'> </td>";
							echo "<td align='center' width='500px'>$usuarioLibera Liberó funcionalidad</td>";
							echo "<td align='center' width='200px'> </td>";
						echo "</tr>";
						
						echo"<tr height='5px'> </tr>";
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='center' width='200px'> </td>";
							echo "<td align='center' width='400px'>Fecha: $fechaLibera</td>";
							echo "<td align='center' width='200px'> </td>";
						echo "</tr>";
						
			echo "</table>";
					
				
			}
		//echo "</table>";
		
		if($cambioDesc != (NULL)){
		
		echo "<table border='0' align='center' width='100%' cellspacing='0'>";

			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='700px'><b>Control de Cambios</b></td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='center' id='iconosTexto2'>Versión</td>";
				echo "<td align='left' id='iconosTexto2'>Descripción</td>";
				echo "<td align='center' id='iconosTexto2'>Fecha</td>";
				echo "<td align='center' id='iconosTexto2'>Iniciales</td>";
			echo "</tr>";
			
			echo "<tr height='10px'> </tr>";
				
			for($a = 0; $a <= count($version); $a++){
				echo "<tr>";
					echo "<td width='100px' align='center' id='fileItem'>$version[$a]</td>";
					echo "<td align='left' width='420px' id='fileItem'>$cambioDesc[$a]</td>";
					echo "<td align='center' width='80px' id='fileItem'>$fechaVersion[$a]</td>";
					echo "<td align='center' width='100' id='fileItem'>$iniciales[$a]</td>";
				echo "</tr>";
				echo "<tr height='10px'> </tr>";
					
			}
		
		echo "</table>";
	}
		*/
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
			
       
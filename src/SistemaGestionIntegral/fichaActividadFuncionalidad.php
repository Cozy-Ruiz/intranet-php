<?php error_reporting(0); ?>
<?php
$nombrephp = 'tableroRoles.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

//borrar
$proceso = $_GET['proceso'];
$actividad = $_GET['actividad'];
$rol = $_GET['rol'];

$nomProceso = $INTRANET->getOne("SELECT xt_Nombre FROM SGI_K_Procesos WHERE kp_CodigoCorto = '$proceso'");
$roles = $INTRANET->getOne("SELECT xt_nombreRol FROM SGI_K_Roles WHERE kp_codigoRol = '$rol'");
$nomActividad = $INTRANET->getOne("SELECT xt_nombre FROM SGI_K_Actividades WHERE kp_codigoActividad = '$actividad'");

//echo "$nomProceso--$roles--$nomActividad";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <script type="text/javascript" src="../JS/jquery-1.9.1.js"></script>
        <head>
        
        	<meta charset="UTF-8">
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
			<title><?php echo $nomActividad; ?></title>
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
            
            
            <!-- SCRIPT PARA MOSTRAR Y OCULTAR DIV HISTORIAL DE PRIORIDAD -->
			<script type="text/javascript">
			function activaFuncionalidades(){

				var vDescripcion=document.getElementById("listFuncionalidad");
    			if(vDescripcion.style.display == 'block') {
    				vDescripcion.style.display = 'none';
    			} else {
      				vDescripcion.style.display = 'block';
   				}
			}
			</script>
            
            <script type="text/javascript">
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
				
				function showContent(proceso, rol) {
					boton1     = document.getElementById('modifica1');
					boton2     = document.getElementById('modifica2');
					
					if(proceso != ''){
						boton2.style.display='block';
						boton1.style.display='none';
					}
					else {
						
					}
				}
				
				function mostrarMomento(proceso, rol, actividad, momento) {
					momento1     = document.getElementById('modificaMomento1');
					momento2     = document.getElementById('modificaMomento2');
					
					if(proceso != '' && rol != '' && actividad != '' && momento != ''){
						momento2.style.display='block';
						momento1.style.display='none';
					}
					else {
						
					}
				}
				
				
				function mostrarActividades(proceso, rol, actividad) {
					actividad1     = document.getElementById('valorActividad1');
					actividad2     = document.getElementById('valorActividad2');
					
					if(proceso != '' && rol != '' && actividad != ''){
						actividad2.style.display='block';
						actividad1.style.display='none';
					}
					else {
						
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
				//Funcion para actualizar Descipcion
				function actualizaDescripcion(proceso, rol, actividad) {
					
					var descripcion = document.getElementsByName("descripcion")[0].value;
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							actualizaActividad(proceso,rol,actividad);
						}
					};

					xhttp.open("POST", "agregaDescripcionActividad.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizaDescripcion&descripcion="+ descripcion +"&proceso="+ proceso + "&actividad=" + actividad +"&rol="+rol);
				}
				//Funcion para agregar funcionalidad
				function agregaFuncionalidad(proceso, rol, actividad) {
					
					var funcionalidad = document.getElementsByName("selectFuncionalidad")[0].value;
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							actualizaActividad(proceso,rol,actividad);
						}
					};

					xhttp.open("POST", "agregaDescripcionActividad.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=agregaFuncionalidad&funcionalidad="+ funcionalidad +"&proceso="+ proceso + "&actividad=" + actividad +"&rol="+rol);
				}
				//Funcion para actualizar Rol
				function actualizarRol(proceso, rolOld, actividad) {
					
					var rolNuevo  = document.getElementsByName("rol")[0].value;
					var separaRol = rolNuevo.split("|");
					var codigoRol = separaRol[0];
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								//alert(proceso+codigoRol+actividad);
								actualizaActividad(proceso,codigoRol,actividad);
							}else{
								actualizaActividad(proceso,rolOld,actividad);
							}
						}
					};

					xhttp.open("POST", "agregaDescripcionActividad.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizarRol&proceso="+ proceso +"&rolNuevo="+rolNuevo + "&rolOld="+ rolOld);
				}
				
				//Funcion para actualizar Actividad
				function actualizarActividad(proceso, rol, actividadOld) {
					
					var nuevaActividad  = document.getElementsByName("actividad")[0].value;
					var separaActividad = nuevaActividad.split("|");
					var codigoActividad = separaActividad[0];
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							//alert(xhttp.responseText);
							if(xhttp.responseText == true){
								actualizaActividad(proceso,rol,codigoActividad);
							}else{
								actualizaActividad(proceso,rol,actividadOld);
							}
						}
					};

					xhttp.open("POST", "agregaDescripcionActividad.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizarActividad&proceso="+ proceso +"&rol="+ rol + "&nuevaActividad="+ nuevaActividad + "&actividadOld="+ actividadOld);
				}
				
				//Funcion para actualizar Actividad
				function actualizarMomento(proceso, rol, actividad) {
					
					var momento  = document.getElementsByName("momento")[0].value;
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							//alert(xhttp.responseText);
							if(xhttp.responseText == true){
								actualizaActividad(proceso,rol,actividad);
							}else{
								actualizaActividad(proceso,rol,actividad);
							}
						}
					};

					xhttp.open("POST", "agregaDescripcionActividad.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizarMomento&proceso="+ proceso +"&rol="+ rol + "&actividad="+ actividad + "&momento="+ momento);
				}

				//Funcion para Actualizar Actividad
				function actualizaActividad(proceso, rol, actividad) {
					window.location.href = 'fichaActividadFuncionalidad.php?proceso=' + proceso + '&rol=' + rol + '&actividad=' + actividad;
				}
			</script>


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
	echo "</table>";
	
	//codigo de menu navegable
	
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>$nomActividad</font>";
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
		//echo"<tr height='70'> </tr>";
	echo "</table>";
	
				
				
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../navegacion_banana.php");
				echo "</table>";
		
				
				
				echo "</td>";
			echo "</tr>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>"; 
			//fin de menu
		echo"</table>";	
			//div de descripcion
			echo "<div id='contDescripcion'>";
			
		
        	$desAct = $INTRANET->getOne("SELECT
											xt_descripcion
										FROM
											SGI_K_Actividades
										WHERE
											kp_codigoActividad = '$actividad'
										AND kf_codigoRol = '$rol'
										AND kf_codigoProceso = '$proceso'");
		
            //CODIGO DEL REPORTE
        	echo "<table border='0' align='center' name='Cuerpo'>";
        
        
                echo "<tr>";
                    echo "<td align='left' width='100%' id='titulo2'>Código de la actividad</td>";
                    echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'></td>";
                echo "</tr>";
                
                //Linea
                echo "<tr>";
                    echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
                echo "</tr>";
            
                echo "<tr height='25'></tr>";
            
            echo"</table>";

            echo "<table border='0' cellspacing='0'  width='100%'>";
                echo "<tr id='valorActividad1'>";
                    echo "<td style='padding:0px 0px 0px 25px; s'>";
						echo "<font size='4px'>".$actividad.": ".$nomActividad."</font>";
                    echo "</td>";
                 	echo "<td align='right'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="mostrarActividades(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\')"><font color="#007CBD">Modificar</font></a>';
                    echo "</td>";
                echo "</tr>";
    			echo '<tr id="valorActividad2" style="display: none;">';
                    echo "<td style='padding:0px 0px 0px 25px'>";
						$listActividades = $INTRANET->Execute('SELECT DISTINCT SA.xt_nombre, SA.kp_codigo FROM SGI_Actividades SA ORDER BY SA.xt_nombre');
                     echo "<center><select name='actividad' id='actividad'>";
                     	while($b = $listActividades->fetchRow()){
                        	$nomActividad    = $b[0];
							$codigoActividad = $b[1];

                             echo "<option value='".$codigoActividad.'|'.$nomActividad."'>$nomActividad</option>";   
                         }
                    echo "</select>";
                    echo "</td>";
		 			echo "<td align='center'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="actualizarActividad(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\')"><font color="#007CBD">Actualizar</font></a>';
                    echo "</td>";
                echo "</tr>";
        		
		 		echo "<tr height='25'></tr>";	
		 
            echo"</table>";
		 
            //proceso
            echo "<table border='0' align='center' name='Cuerpo'>";
        
                echo "<tr>";
                    echo "<td align='left' width='100%' id='titulo2'>Proceso</td>";
                    echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
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
                        echo "<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaProceso.php?proceso=$proceso' style='cursor:pointer;'><font size='4px'>$proceso: $nomProceso</font></a>";
                    echo "</td>";
                echo "</tr>";
    
                echo "<tr height='25'></tr>";   
        
            echo"</table>";
            
            //Roles
            echo "<table border='0' align='center' name='Cuerpo'>";
        
                echo "<tr>";
                    echo "<td align='left' width='100%' id='titulo2'>Rol</td>";
                    echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
                echo "</tr>";
                
                //Linea
                echo "<tr>";
                    echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
                echo "</tr>";
            
                echo "<tr height='25'></tr>";
            
            echo"</table>";
            
            echo "<table border='0' cellspacing='0' width='100%' >";
                echo "<tr id='modifica1'>";
                    echo "<td style='padding:0px 0px 0px 25px'>";
                        echo "<font size='4px'>".utf8_encode($rol).": ".$roles."</font>";
		 			echo"</td>";
		 			echo "<td align='right'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="showContent(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\')"><font color="#007CBD">Modificar</font></a>';
                    echo "</td>";
                echo "</tr>";
		 
		 		echo '<tr id="modifica2" style="display: none;">';
                    echo "<td style='padding:0px 0px 0px 25px'>";
						$listRoles = $INTRANET->Execute('SELECT xt_nombre, kp_codigo FROM SGI_Roles ORDER BY xt_nombre');
                     	echo"<select name='rol' id='rol'>";
                     	while($c = $listRoles->fetchRow()){
                        	$nomRol    = $c[0];
							$codigoRol = $c[1];

                             echo "<option value='".$codigoRol.'|'.$nomRol."'>$nomRol</option>";   
                         }
                    echo "</select>";
                    echo "</td>";
		 			echo "<td align='center'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="actualizarRol(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\')"><font color="#007CBD">Actualizar</font></a>';
                    echo "</td>";
                echo "</tr>";
    
                echo "<tr height='25'></tr>";   
        
            echo"</table>";
		 
            //MOMENTO
            ////Roles
            echo "<table border='0' align='center' name='Cuerpo'>";
        
                echo "<tr>";
                    echo "<td align='left' width='100%' id='titulo2'>Momento</td>";
                    echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
                echo "</tr>";
                
                //Linea
                echo "<tr>";
                    echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
                echo "</tr>";
            
                echo "<tr height='25'></tr>";
            
            echo"</table>";
            
		 $momento = $INTRANET->getOne("SELECT
											SKA.xt_momento
										FROM
											SGI_K_Actividades SKA
										WHERE
											SKA.kf_codigoProceso = '$proceso'
										AND SKA.kf_codigoRol = '$rol'
										AND SKA.kp_codigoActividad = '$actividad'");

		  echo "<table border='0' cellspacing='0' width='100%' >";
			echo "<tr id='modificaMomento1'>";
				echo "<td style='padding:0px 0px 0px 25px'>";
					echo "<font size='4px'>".$momento."</font>";
				echo"</td>";
				echo "<td align='right'>";
					echo'<a  style="float:right;cursor:pointer;" onClick="mostrarMomento(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\', \''.$momento.'\')"><font color="#007CBD">Modificar</font></a>';
				echo "</td>";
			echo "</tr>";

			echo '<tr id="modificaMomento2" style="display: none;">';
				echo "<td style='padding:0px 0px 0px 25px'>";
					$listTiempo = $INTRANET->Execute('SELECT kp_tiempo FROM SGI_Catalogo_Tiempos ORDER BY kp_tiempo');
					echo"<select name='momento' id='momento'>";
					while($c = $listTiempo->fetchRow()){
							$codigoTiempo = $c[0]; 
                             echo "<option value='$codigoTiempo'>$codigoTiempo</option>";
                            
                         }
				echo "</select>";
				echo "</td>";
				echo "<td align='center'>";
					echo'<a  style="float:right;cursor:pointer;" onClick="actualizarMomento(\''.$proceso.'\',\''.$rol.'\', \''.$actividad.'\', \''.$momento.'\')"><font color="#007CBD">Actualizar</font></a>';
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
			
			$desAct = $INTRANET->getOne("SELECT
														SKA.xt_descripcion
													FROM
														SGI_K_Actividades SKA
													WHERE
														SKA.kf_codigoProceso = '$proceso'
													AND SKA.kf_codigoRol = '$rol'
													AND SKA.kp_codigoActividad = '$actividad'");
			echo "<table border='0' width='100%' cellspacing='0'>";
				if($desAct != ''){
					echo "<tr>";
						echo "<td style='padding:0px 0px 0px 25px;' id='modifP2'>";
							echo $desAct; 
						echo "</td>";
					echo "</tr>";
                    echo "<tr>";
                        echo "<td id='modifP3'>";
                            ?>
                            <a  style='float:right;cursor:pointer;' onClick="activaModifica('<?php echo $desAct; ?>')"><font color='#007CBD'>Modificar</font></a>
                            <?php
                        echo "</td>";
                    echo "</tr>";
					echo "<tr>";
						echo "<td padding:0px 0px 0px 25px;' id='descripcionAct' style='display:none;'>";
							echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" />'.$desAct.'</textarea>';
						/*	<button onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\')" name="evento" style="background-color:rgb(0,249,0); border:none; cursor:pointer;">
										<b>Agregar</b>
									</button>';*/
							echo'<a  style="float:right;cursor:pointer;" onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\')" name="evento" border:none; cursor:pointer;"><font color="#007CBD">Actualizar</font></a>';
						echo "</td>";
					echo "</tr>";
				}else{
	
					echo "<tr>";	
						echo "<td padding:0px 0px 0px 25px;'>";
							echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" /></textarea>';
							echo'<a  style="float:right;cursor:pointer;" onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\')" name="evento" border:none; cursor:pointer;"><font color="#007CBD">Actualizar</font></a>';
							/*echo '<textarea name="descripcion" type="text" id="descripcion" rows="3"  cols="75" /></textarea>
							<button onClick="actualizaDescripcion(\''.$proceso.'\',\''.$rol.'\',\''.$actividad.'\')" name="evento" style="background-color:rgb(0,249,0); border:none; cursor:pointer;">
										<b>Agregar</b>
									</button>';*/
						"</td>";
					echo "</tr>";					
				}	
				echo "<tr height='25'></tr>";	
		
			echo"</table>";
			
            /*********************************************************************************************************************/
			//lista de funcionalidades	
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td align='left' width='100%' id='titulo2'>Funcionalidades</td>";
					echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
					
					?>
                	<td><a  onClick="activaFuncionalidades()"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' /></a> </td>
                	<?php				
				echo "</tr>";
				
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'></tr>";	
			
				//select de listado de funcionalidades
				
				echo "<form name='asignaFuncionalidad' method='POST' action='fichaActividadFuncionalidad.php'>";
					echo "<tr id='listFuncionalidad' style='display:none'>";
						echo "<td style='padding:0px 0px 0px 100px'>";
					
							$a = $INTRANET->Execute("SELECT kp_codigo, xt_nombre, xt_tipo FROM SGI_Funcionalidades ORDER BY xt_tipo, xt_nombre ASC");
								$indice = 0;
                        		while($b = $a->fetchRow()){
									$codigoFuncionalidad[$indice]    = $b[0];
									$nomFuncionalidad[$indice]       = $b[1];
									$tipoFuncionalidad[$indice]      = $b[2];
									
									$indice++;
								}
								echo "<select name='selectFuncionalidad' id='selectFuncionalidad'>";
									echo "<option value=''>------------------------------GENÉRICAS-----------------------------------</option>";
									for($n=0; $n<count($codigoFuncionalidad); $n++){

										if($tipoFuncionalidad[$n] == 'G'){
											echo "<option value='".$codigoFuncionalidad[$n].'|'.$nomFuncionalidad[$n]."'>$nomFuncionalidad[$n]</option>";
										}

									}
									echo "<option value=''>------------------------------ESPECÍFICAS---------------------------------</option>";
									for($n=0; $n<count($codigoFuncionalidad); $n++){
										if($tipoFuncionalidad[$n] == 'E'){
											echo "<option value='".$codigoFuncionalidad[$n].'|'.$nomFuncionalidad[$n]."'>$nomFuncionalidad[$n]</option>";
										}
									}	
                        	echo "</select>";
						echo "</td>";
					
						echo "<td width='5px'></td>";
					
						echo '<td>
							<a href="javascript:void(0)" onClick="agregaFuncionalidad(\''.$proceso.'\', \''.$rol.'\',  \''.$actividad.'\')"><img height="25" width="90" src="../Imagenes/ICN_BotonEnviar.png"></a>
						</td>';
		 
						
					echo "<tr height='20px'></tr>";	

					echo "</tr>";
				echo "</table>";

				$x = $INTRANET->Execute("SELECT
											SKF.kp_codigoFuncionalidad,
											SKF.xt_nombre
										FROM
											SGI_K_Funcionalidades SKF
										WHERE
											SKF.kf_codigoActividad = '$actividad'
										AND SKF.kf_codigoRol = '$rol'
										AND SKF.kf_codigoProceso = '$proceso'");

				while($listFuncionalidades = $x->fetchRow()){					
					echo "<tr>";
						echo "<td style='padding:0px 0px 0px 25px'>";
							echo "<b style='padding:0px 0px 0px 25px;'><a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaFuncionalidadCasoUso.php?funcionalidad=$listFuncionalidades[0]&actividad=$actividad&rol=$rol&proceso=$proceso'>$listFuncionalidades[0]</a> - $listFuncionalidades[1]</b><br>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr height='10'></tr>";		
				}
				

			echo "</div>";			
		echo "</form>";				
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
			
echo "</div>";
?>


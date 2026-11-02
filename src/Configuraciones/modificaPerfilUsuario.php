<?php error_reporting(0); ?>
<?php

$nombrephp = 'modificaPerfilUsuario.php';
require_once("../ConexionDBT.php");
require_once('../compruebaUsuario.php');
error_reporting(E_PARSE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <title>Modifica Perfil Usuario</title>
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
if($_SESSION["categoria"] == 'Administrador'){
	echo '<a href="administradorPerfiles.php"></a>';
}else if($_SESSION["categoria"] == 'Inhouse'){
	echo '<a href="administradorPerfiles.php"></a>';
}

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='configuraciones.php' id='breadcrumbs'> Configuraciones /</a>
<a href='AdministradorPerfiles.php' id='breadcrumbs'> Administrador de Perfiles</a> ";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
			echo "<font> Modifica Perfil de Usuario</font>";
			echo"</td>";
		echo"</tr>";
		
		echo "<tr height='10'><td></td></tr>";
		
		echo "<tr>"; 
			echo "<td align='center' valign='top' height='20px'>";
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
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		echo "<tr>";
			echo "<td align='center'>";
			
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
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo "<tr height='100'><td></td></tr>";
	echo "</table>";
	
		if($_GET['administra'] == 'true'){
			
			echo "<FORM name='form1' ACTION='modificaPerfilUsuario.php?modificaPerfil=true'  METHOD='POST'>";
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='iconosTexto2'>";
							echo "<b>Usuario</b>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='10'></tr>";
					
					echo"<tr>";
						echo"<td align='center'>";
							$s = $INTRANET->Execute('select kp_usuario, xt_nombre from IntranetGEA_USUARIOS');
							echo "<select name='usuario'>";
								echo "<option value='' SELECTED>";
								while($r = $s->fetchRow()){
									$usuario = $r[0];
									$nombre = $r[1];
									echo "<option value='$usuario'>$nombre - $usuario</option>";
								}
							echo "</select>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='10'></tr>";
					
					echo"<tr>";
						echo"<td>";
							echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
			echo "</form>";
			
		}else if($_GET['modificaPerfil'] == true){
						echo "<table border='0' align='center' name='Encabezado'>";			
							$usuario = $_POST['usuario'];
							echo"<tr>";
								echo "<td align='center' id='titulo30Blanco'> $usuario </td>";
							echo"</tr>";
							
							echo"<tr height='20'></tr>";
							
							echo "<tr>";
								echo "<td width='600' 	  
									style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
							echo "</tr>";
							
							echo"<tr height='20'></tr>";
						echo"</table>";
						
						$s = $INTRANET->Execute("select kf_phpId from IntranetGEA_USUARIOS_CATALOGO_PHP where kf_usuarioId = '$usuario' ");
						$index = 0;
						$phpActivos = array();
						while($r = $s->fetchRow()){
							$phpActivos[$index] = $r[0];
							$index++;
						}
						
						echo "<FORM name='form1' ACTION='modificaPerfilUsuario.php?cargaPerfil=true'  METHOD='POST'>";
							echo "<input type='hidden' class='LoginInicio' name='usuario' value='$usuario'/>";
							
							$s = $INTRANET->Execute("select kp_categoria from IntranetGEA_CATEGORIAS_PHP");
							while($r = $s->fetchRow()){
								$categoriaPhp = $r[0];
								
								echo '<div id="iconosTexto2" align="center">'.$categoriaPhp.'<br><br> </div>';
								
								echo '<div id="datos_tabla">';
									
									echo '<table class="datos" width="300" cellspacing="0" cellpadding="0" border="0" align="center">';											
										$u = $INTRANET->Execute("select kp_nombre from IntranetGEA_CATALOGO_PHP where kf_categoria = '$categoriaPhp' ");
										while($t = $u->fetchRow()){
											$nombrePhp = $t[0];
											echo '<tr id="fileItem">';
												echo "<td>$nombrePhp</td>";
												if(in_array($nombrePhp, $phpActivos)){
													echo "<td><input type='checkbox' checked='true' class='LoginInicio' name='phpActivar[]' value='$nombrePhp'/></td>";
												}else{
													echo "<td><input type='checkbox' class='LoginInicio' name='phpActivar[]' value='$nombrePhp'/></td>";
												}
											echo '</tr>';
										}
									echo '</table>';
										
								echo '</div>';
								
								echo '<br><br>';
							}
							
							echo "<table border='0' align='center' name='Encabezado'>";	
								
								echo "<tr>";
									echo "<td width='600' 	  
										style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
								echo "</tr>";
								
								echo"<tr height='20'></tr>";
								
								echo "<tr>";
									echo "<td> 
								   		<input type='image' align='right' value='Cargar' onclick='SubmitForm(this.form);' 
										src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
										</td>";
								echo "</tr>";
							echo "</table>";
							
							//echo "<input type='submit' value='Cargar'/>";
							
						echo "</form>";
						}else if($_GET['cargaPerfil'] == true){
						
						$usuario = $_POST['usuario'];
						$phpActivar = $_POST['phpActivar'];
						$estatus = array();
						$estatusIndex = 0;
						
						$s = $INTRANET->Execute("select kf_phpId from IntranetGEA_USUARIOS_CATALOGO_PHP where kf_usuarioId = '$usuario' ");
						$index = 0;
						$phpActivos = array();
						while($r = $s->fetchRow()){
							$phpActivos[$index] = $r[0];
							if(! in_array($phpActivos[$index], $phpActivar)){
								if($INTRANET->Execute("delete from IntranetGEA_USUARIOS_CATALOGO_PHP where kf_phpId = '$phpActivos[$index]' AND kf_usuarioId = '$usuario'  ")){
									$estatus[$estatusIndex] = "Correcto";
									$estatusIndex++;	
								}else{
									$estatus[$estatusIndex] = "Error";
									$estatusIndex++;
								}
							} 
							$index++;
						}
						
						for($a=0; $a<count($phpActivar); $a++){
							if(! in_array($phpActivar[$a], $phpActivos)){
								if($INTRANET->Execute("insert into IntranetGEA_USUARIOS_CATALOGO_PHP (kf_phpId, kf_usuarioId) values ('$phpActivar[$a]', '$usuario') ")){
									$estatus[$estatusIndex] = "Correcto";
									$estatusIndex++;	
								}else{
									$estatus[$estatusIndex] = "Error";
									$estatusIndex++;
								}
							}
						}
						
						if(in_array("Error", $estatus)){
							echo "Hubo algun error en la modificacion del Perfil !! <br>";
						}else{
							echo "Modificacion de Perfil Completada !! <br>";
						}
						
					}

echo"</div>";		
?>
</body>
</html>

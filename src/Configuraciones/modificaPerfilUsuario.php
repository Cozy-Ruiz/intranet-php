<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

require_once("../conexionMasterDB.php");
require_once('../compruebaUsuario.php');

if(! in_array("modificaPerfil", $listaFuncionalidades)){
	header("Location: https://escalante.com.mx/INTRA/error.php"); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <title>Alta Funcionalidad Usuario</title>
        <?php
		if($sesionEstilo == 1){
			echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
		}else if($sesionEstilo == 2){
			echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
		}
		?>
        <script language="javascript" src="../js/jquery-1.2.6.min.js"></script>
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
        
	
        <script language="javascript">
            $(document).ready(function(){
            $("#oficina").change(function () {
            $("#oficina option:selected").each(function () {
	            oficina=$("#oficina").val();
				usuario=$("#usuario").val();
	            $.post("modulosPermisos.php", { oficina: oficina, usuario : usuario }, function(data){
		            $("#lista").html(data);
                    //alert(usuario);
		            
	            });            
            });
           })  
       
        });
    </script>
   
        
    </head>
    <body>
<?php
if($_SESSION["categoria"] == 'Administrador'){
	echo '<a href="administradorPerfiles.php"></a>';
}else if($_SESSION["categoria"] == 'Inhouse'){
	echo '<a href="administradorPerfiles.php"></a>';
}

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/seleccionaSistema.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/Sistemas/Configuraciones/configuraciones.php' id='breadcrumbs'> Configuraciones /</a>
<a href='https://escalante.com.mx/Sistemas/Configuraciones/administradorPerfiles.php' id='breadcrumbs'> Administrador de Perfiles</a> ";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
			echo "<font> Alta Funcionalidad Usuario</font>";
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
	echo "</table>";
	   
echo "<FORM name='form1' ACTION='modificaPerfilUsuario.php?modificaPerfil=true'  METHOD='POST'>";	
	echo "<table border='0' align='center'>";
		echo "<tr height='100'><td></td></tr>";
	echo "</table>";
	
		if($_GET['administra'] == 'true'){
		
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='iconosTexto2'>";
							echo "<b>Usuario</b>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='10'></tr>";
					
					echo"<tr>";
						echo"<td align='center'>";
							$s = $MASTER_GE->Execute('SELECT PU.xt_usuario, PU.xt_nombre FROM PERFILES.USUARIOS PU');
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
		
			
		}else if($_GET['modificaPerfil'] == true){
			echo "<table border='0' align='center' name='Encabezado'>";			
				$usuario = $_POST['usuario'];
                echo "<input type='hidden' name='usuario' id='usuario' value='$usuario'>";
				
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
			
			//OPCIONES DE LAS CIUDADES QUE EL USUARIO TIENE DADAS DE ALTA
			echo "<table border='0' align='center' name='Encabezado'>";	
			
				echo"<tr>";
					echo "<td align='center' id='iconosTexto'> Ciudad </td>";
				echo"</tr>";
				
				echo"<tr height='5'>";
				echo"</tr>";
				
				echo"<tr>";
				$oficinas = $MASTER_GE->Execute("SELECT xt_oficina FROM PERFILES.OFICINAS where xt_usuario = '$usuario'");
					echo"<td>";
						echo"<select name='oficina' id='oficina'>";
							echo "<option selected='selected'>Selecionar...</option>";
							while($r = $oficinas->fetchRow()){
								$oficinasDisponibles = $r[0];
								echo "<option value='$oficinasDisponibles'>$oficinasDisponibles</option>";
							}
						
						echo"</select>";		
					echo"</td>";
				echo"</tr>";
                                
                                echo"<tr height='40'></tr>";
			
			echo"</table>";
			
			//SE MUESTRAN LOS MODULOS UNA VES QUE SE ELEGIO LA CIUDAD
			echo "<table border='0' align='center' name='Encabezado' id='lista'>";	
				
				echo"<tr height='20' aling = 'left'></tr>";
				
				echo "<tr>";
					echo "<td width='600' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
				echo "</tr>";
				
				echo"<tr height='20' aling = 'left'></tr>";
				
			echo"</table>";
						
				
					
		}

echo"</div>";
    echo "</form>";

        if(isset($_POST['Enviar'])){
            $indice = 0;
            foreach($_POST['valor'] as $color => $valor){
				   
				   $data = explode("-", $valor);
				  // strtoupper($oficina[0]."-".$cadena1[1]."-".$cadena1[2]."-".$cadena1[3]."-".$cadena1[4]."-".$cadena1[5]);
				   $oficina[$indice] = $data[0];
				   $rol[$indice]= $data[1];
				   $modulo[$indice] = $data[2];
				   $proceso[$indice] = $data[3];
				   $actividad[$indice] = $data[4];
				   $funcion[$indice] = $data[5];
				   
				   $indice++;
				   
			}
				
				$oficina1 = array_unique($oficina);//AICM
				$roles    = $rol;//ROL
				$modulos  = $modulo;//MODULOS
				$procesos = $proceso;//PROCESO
				$actividades = $actividad;
              	$funcionalidadesSeleccionadas = $funcion;//Funcionalidades
                $estatus = array();
                $estatusIndex = 0;
				
                $string = "select xt_modulo from PERFILES.ACTIVIDADES where xt_oficina = '$oficina[0]' AND xt_usuario = '$usuario'";
                $m = $MASTER_GE->Execute($string);
                $index = 0;
                $FuncionalidadesActivas = array();
                
                while($r = $m->fetchRow()){
                     
                     $ActivoModulos = $r[0];
                    //echo "<br>";
                    
					//echo"SELECT xt_funcionalidad FROM PERFILES.FUNCIONALIDADES WHERE xt_modulo = '$ActivoModulos' AND xt_oficina = '$oficina[0]' AND xt_usuario= '$usuario' <br><br>";
                    $string2 = "SELECT xt_funcionalidad FROM PERFILES.FUNCIONALIDADES WHERE xt_modulo = '$ActivoModulos' AND xt_oficina = '$oficina[0]' AND xt_usuario= '$usuario' ";
                    //echo "<br>";    
                    $u = $MASTER_GE->Execute ($string2);
                    while($o = $u->fetchRow()){
                        $FuncionalidadesActivas[$index] = $o[0];
                        $index++;
                    }   
                    
                     for($a=0; $a<count($FuncionalidadesActivas); $a++){
						 
                        if(array($FuncionalidadesActivas[$a],$funcionalidadesSeleccionadas[$a])){
							
							echo"delete from PERFILES.FUNCIONALIDADES where xt_usuario = '$usuario' AND xt_oficina = '$oficina[$a]' AND xt_modulo = '$ActivoModulos' AND xt_funcionalidad = '$FuncionalidadesActivas[$a]' <br><br>";
									
                                 //   $string3 = "delete from PERFILES.FUNCIONALIDADES where xt_usuario = '$usuario' AND xt_oficina = '$oficina[0]' AND xt_modulo = '$ActivoModulos' 
                                   // AND xt_funcionalidad = '$FuncionalidadesActivas[$a]' ";
									
                                   // echo "<br>";
                                 /*   if($MASTER_GE->Execute($string3)){
                                        $estatus[$estatusIndex] = "Correcto";
                                        $estatusIndex++;    
                                    }else{
                                        $estatus[$estatusIndex] = "Error";
                                        $estatusIndex++;
                                    }*/
                                } 
                        }
                        
                }//fin primer whie*/
               
            for($a=0; $a<count($funcionalidadesSeleccionadas); $a++){
                    if(array($funcionalidadesSeleccionadas[$a],$FuncionalidadesActivas[$a])){
					
					//echo"insert into PERFILES.FUNCIONALIDADES(xt_usuario,xt_oficina,xt_rol, xt_modulo, xt_proceso, xt_actividad, xt_funcionalidad) values ('$usuario','$oficina[$a]','$rol[$a]','$modulo[$a]','$proceso[$a]','$actividad[$a]','$funcionalidadesSeleccionadas[$a]') <br /><br />";
					
               $string4 =  "insert into PERFILES.FUNCIONALIDADES(xt_usuario,xt_oficina,xt_rol, xt_modulo, xt_proceso, xt_actividad, xt_funcionalidad) values ('$usuario','$oficina[$a]','$rol[$a]','$modulo[$a]','$proceso[$a]','$actividad[$a]','$funcionalidadesSeleccionadas[$a]')";
					 
                      if($MASTER_GE->Execute($string4)){
                            $estatus[$estatusIndex] = "Correcto";
                            $estatusIndex++;    
                        }else{
                            $estatus[$estatusIndex] = "Error";
                            $estatusIndex++;
                        }
                  }
			  }
  		
		
		   }//fin del if del boton	


?>
</body>
</html>

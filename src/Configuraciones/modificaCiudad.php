<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'modificaCiudad.php';
require_once("../ConexionDBT.php");
require_once('../compruebaUsuario.php');

error_reporting(E_PARSE);

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='configuraciones.php' id='breadcrumbs'> Configuraciones / </a>
			   <a href='AdministradorPerfiles.php' id='breadcrumbs'> Administrador de Perfiles</a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <title>Modifica Ciudad</title>
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

echo "<div id='wrapperFicha'>";
	echo "<table border='0' align='center'>";
		echo "<tr height='80px'><td></td></tr>";
	
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Modifica Ciudad";
			echo "</td>";
		echo "</tr>";
		
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
                <?php
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo "<tr height='70'><td></td></tr>";
	echo "</table>";
	
	if($_GET['administra'] == 'true'){
		
		echo "<form name='form1' action='modificaCiudad.php?modificaPerfil=true'  method='POST'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo "<tr>";
					echo "<td align='center' id='iconosTexto2'>";
						echo "<b>Usuario</b>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10'></tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						$s = $INTRANET->Execute('select kp_usuario, xt_nombre from IntranetGEA_USUARIOS');
						echo "<select name='usuario'>";
							echo "<option value='' SELECTED>";
							while($r = $s->fetchRow()){
								$usuario = $r[0];
								$nombre = $r[1];
								echo "<option value='$usuario'>$nombre - $usuario</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10'></tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</form>";
	
	}else if($_GET['modificaPerfil'] == true){
		
	echo "<form name='form1' action='modificaCiudad.php?update=true'  method='POST'>";
		echo "<table border='0' align='center' name='Encabezado'>";			
			$usuario = $_POST['usuario'];
			echo "<tr>";
				echo "<td align='center' id='titulo30Blanco'> $usuario </td>";
			echo "</tr>";
			
			echo "<tr height='20'><input type='hidden' name='usuario' value='$usuario'></tr>";
			
			echo "<tr>";
				echo "<td width='600' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo "<tr height='20'></tr>";
			
			echo "<tr>";
				echo "<td align='center' id='titulo12' colspan='2'> Elija ciudad:</td>";
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' name='Encabezado' width='120'>";
		$s= $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId='$usuario'");
		$oficinas= NULL;
		$indice =1;
		
		while($r = $s -> fetchRow()){
			$oficinas[$indice]= $r[0];
			$indice++;
		}unset($r);
		
		$f = $INTRANET->Execute("SELECT xt_oficina, xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA");
	
		while($p = $f -> fetchRow()){
			$claveOficina   = $p[0];
			$nombreOficina  = $p[1];
			$index++;
		
			
			//echo"$claveOficina---$nombreOficina";
			
			echo "<tr>";
				if(in_array($claveOficina,$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='$claveOficina' checked='true'> $nombreOficina</td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='$claveOficina'> $nombreOficina</td>";
				}
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			}unset($p);
		
			/*echo "<tr>";
				if(in_array('DF',$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='DF' checked='true'> México DF</td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='DF'> México DF</td>";
				}
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			echo "<tr>";
				if(in_array('CUN',$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='CUN' checked='true'> Cancún</td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='CUN'> Cancún</td>";
				}
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			echo "<tr>";
				if(in_array('LAR',$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='LAR' checked='true'> Laredo Texas </td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='LAR'> Laredo Texas </td>";
				}
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			echo "<tr>";
				if(in_array('NLR',$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='NLR' checked='true'> Nuevo Laredo </td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='NLR'> Nuevo Laredo </td>";
				}
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			echo "<tr>";
				if(in_array('QRO',$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='QRO' checked='true'> Queretaro </td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='QRO'> Queretaro </td>";
				}
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			echo "<tr>";
				if(in_array('VER',$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='VER' checked='true'> Veracuz </td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='VER'> Veracuz </td>";
				}
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			echo "<tr>";
				if(in_array('TOL',$oficinas)){
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='TOL' checked='true'> Toluca </td>";
				}else{
					echo "<td align='left'><input type='checkbox' name='ciudad[]' value='TOL'> Toluca </td>";
				}
			echo "</tr>"
			;*/
			
			echo "<tr height='20'></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' name='Encabezado'>";
			echo "<tr>";
				echo "<td width='600' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo "<tr height='20'></tr>";
			
			echo "<tr>";
				echo "<td align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo "</td>";
			echo "</tr>";
			
		echo "</table>";
		echo "</form>";			
	}else if($_GET['update'] == true){
		
		//$codigoCiudad = $_POST['ciudad'];
		$usuarioUpdate = $_POST['usuario'];
		//$IdUpdate = mysql_insert_id();
		
		//echo "UPDATE IntranetGEA_Usuarios_Oficina SET xt_codigoCiudad='$codigoCiudad',kf_usuarioId='$usuarioUpdate' WHERE kp_UsuarioOficina=$IdUpdate";
		$INTRANET->Execute("Delete FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioUpdate'");
		foreach($_POST["ciudad"] as $checkbox){
			$INTRANET->Execute("INSERT INTO IntranetGEA_Usuarios_Oficina (kf_usuarioId,xt_codigoCiudad)VALUES ('$usuarioUpdate','$checkbox')");	
			
		}
		echo "<table border='0' align='center' name='Encabezado'>";
			echo "<tr>";
				echo "<td align='center'>Carga Exitosa!</td>";
			echo "</tr>";
			
		echo "</table>";			
					
	}
echo "</div>";
?>
</body>
</html>

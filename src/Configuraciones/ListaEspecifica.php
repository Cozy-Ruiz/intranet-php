<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = "ListaEspecifica.php";
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

error_reporting(E_PARSE);

$tipoLista = $_GET['tipo'];



$indice = 1;

$s = $INTRANET->Execute("SELECT kp_listaID,xt_nombreLista,xt_actividad FROM SGI_ListasEspecificas ");

while($r = $s -> fetchRow()){
	
	$tiposLista[$indice] 		= $r[0];
	$tiposListaShow[$indice] 	= $r[1];
	$actividades[$indice] 		= $r[2];
	
	$indice++;
	
}unset($r);unset($s);unset($indice);


$ciudad = $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");


for($o = 1; $o <= count($actividades); $o++){
	
	if($tiposLista[$o] == $tipoLista){
		$actividad = $actividades[$o];
		break;
	}
	
} unset($o);

////INSERCION DE UN NOMBRE EN UNA LISTA
if($_POST['IDnombre'] != ""){
	
	$nombreID		= $_POST['IDnombre'];
	
	$INTRANET->Execute("INSERT INTO SGI_EmpleadosActividad (kf_personalID, xt_actividad) 
						VALUES ($nombreID,'$actividad') ");
	
	
	header("Location: ListaEspecifica.php?tipo=$tipoLista");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
			<script>
				function show(valor){
					if(valor == 1){
						document.getElementById("comite1").style.display="block";
						document.getElementById("comite0").style.display="none";
						document.getElementById("lista").style.display="block";
					} else if(valor == 0){
						document.getElementById("comite1").style.display="none";
						document.getElementById("comite0").style.display="block";
						document.getElementById("lista").style.display="none";
					}
				}
            </script>
            <script>
				function showPREV(valor){
					if(valor == 1){
						document.getElementById("masControl5").style.display="none";
						document.getElementById("masControl6").style.display="block";
						document.getElementById("formularioUser").style.display="block";
					} else if (valor == 2){
						document.getElementById("masControl5").style.display="block";
						document.getElementById("masControl6").style.display="none";
						document.getElementById("formularioUser").style.display="none";
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
                                
<?php
			for($o = 1; $o <= count($tiposLista); $o++){
		
				if($tiposLista[$o] == $tipoLista){
					
					$lista = $tiposListaShow[$o];
					break;
					
				}
				
			} unset($o);
			
			echo "<title>Lista del ".$lista."</title>";
?>
        </head>
        <body>
<?php

$breadcrumb="<a href='../Home.php' id='breadcrumbs' > Home / </a><a href='configuraciones.php' id='breadcrumbs'> Configuraciones / </a>
			 <a href='ListasDisponibles.php' id='breadcrumbs'> Listas Disponibles </a>";

echo"<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado'>";		
		echo"<tr height='80px'><td></td></tr>";
	///Titulo 
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='700px'>";
				echo $lista;
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
	
	/*echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
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
                <?php*/
				
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../navegacion_banana.php");
			echo "</table>";
			
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo "<tr height='70'><td></td></tr>";
	echo "</table>";
		
	echo"<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td align='left' width='680' id='titulo2'>";
				echo "<b onclick='show(1);' id='comite0' style='display:block;'>";
					echo $lista;
				echo "</b>";
				echo "<b onclick='show(0);' id='comite1' style='display:none;'>";
					echo $lista;
				echo "</b>";
			echo "</td>";
			
			echo "<td align='right' id='titulo2'  width='20' colspan='2'>";
				echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='showPREV(1);' id='masControl5' style='display:block;'>";
				echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='showPREV(2);' id='masControl6' style='display:none;'>";
			echo "</td> ";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2' align='center'></td>";
		echo "</tr>";
		
		echo"<tr height='20'> </tr>";
	echo"</table>";
		
//DESPLIEGUE DE TODO EL PERSONAL PARA AGREGAR A LA LISTA
	echo "<form method='POST' action='ListaEspecifica.php?tipo=$tipoLista'>";	
		echo "<table border='0' align='center' width='450' id='formularioUser' style='display:none;'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='15'><td></td></tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left' width='450'>Seleccionar</td>";
			echo "</tr>";
			
			echo"<tr align='left'>";
				echo "<td  align='left'>";
					echo "<select size='1' name='IDnombre'>";
						echo "<option value=''>Seleccionar...</option>";
						
						$s= $INTRANET->Execute("SELECT kp_personalId, xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados WHERE xt_ciudad= '$ciudad' ORDER BY xt_nombre ");
						
						while($r= $s -> fetchRow()){
							
							echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
							
						} unset($r); unset ($s);
						
					echo"</select>";
				echo"</td>";
			echo "</tr>";
			echo"<tr height='15'> </tr>";

			echo "<tr>";
				echo "<td id='titleBlueLineBottom'> </td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right'></td>";
			echo "</tr>";
					
		echo "</table>";
		
	echo "</form>";
		
	$indice = 1;
	
	$s = $INTRANET->Execute("
		SELECT EMP.kp_personalId, EMP.xt_Nombre, EMP.xt_ApellidoPaterno, EMP.xt_ApellidoMaterno, xt_Empresa 
		FROM SGI_Empleados EMP, SGI_EmpleadosActividad SEA 
		WHERE EMP.xt_Estatus = 1 AND EMP.kp_personalId = SEA.kf_personalID AND SEA.xt_actividad = '$actividad' 
		ORDER BY EMP.xt_Empresa, EMP.xt_ApellidoPaterno, EMP.xt_ApellidoMaterno, EMP.xt_Nombre ");
	
	while($r = $s->fetchRow()){
		$personalIDComCal[$indice] = $r[0];
		$nombrePersonalComCal[$indice] = $r[1];
		$apellidoPaternoComCal[$indice] = $r[2];
		$apellidoMaternoComCal[$indice] = $r[3];
		$empresaComCal[$indice] = $r[4];
		
		$indice++;
		
	} unset($r); unset($s); unset($indice);
	

	echo "<table border='0' align='center' width='700' id='lista' style='display:none;'>";
		
		if(count($personalIDComCal) >= 1){
			
			for($a = 1; $a <= count($personalIDComCal); $a++){
				
				echo "<tr>";
					echo "<td width='20px' id='fileItem'> </td>";
					echo "<td width='300' align='left' id='fileItem'>$nombrePersonalComCal[$a] $apellidoPaternoComCal[$a] $apellidoMaternoComCal[$a]</td>";
					echo "<td width='380' align='left' id='fileItem'>$empresaComCal[$a]</td>";
				echo "</tr>";
				
			}
				
		}
		
		echo "<tr height='20px'>";
			echo "<td width='20px'> </td>";
			echo "<td width='300'> </td>";
			echo "<td width='380'> </td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3' align='center'></td>";
		echo "</tr>";
	echo "</table>";
		
	echo"<table border='0' align='center' width='700'>";
		echo "<tr height='50px'> <td width='700'> </td> </tr>";
	echo"</table>";
	
	echo "<table border='0' align='center' width='700'>";
		echo"<tr height='80'><td> </td></tr>";
	echo "</table>";
echo "</div>";

?>
		</body>
	</html>
<?php

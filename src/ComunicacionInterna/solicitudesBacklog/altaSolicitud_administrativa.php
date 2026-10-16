<?php error_reporting(0); ?>
<?php
$nombrephp='altaSolicitud_administrativa.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Alta Solicitud Administrativa</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
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
$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='../tableroSolicitudesyQuejas.php' id='breadcrumbs'> Solicitudes y Quejas</a>";

echo "<div id='wrapper'>";
  echo "<form name='altaSolicitud_Administrativa' method='post' action='altaSolicitud_administrativa.php'>";	
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='80px'> </tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Solicitud<br>administrativa";
			echo "</td>";
		echo "</tr>";
		
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
			  
			  $subirDir = $subirDir."../../";
			  
		  } unset($o);
		  
		  //echo "SUBDIR: $subirDir, CUENTADIR: $cuentaDir";
		  
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
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Fecha</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaAsignar'>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Grupo</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
				echo "<select name='empresa' size='1' >";
					echo "<option value=''>Elegir</option>";
					
					$s= $INTRANET->Execute("SELECT distinct xt_empresa FROM PERFILES.USUARIOS WHERE xt_empresa != '' ");
						
					while($r= $s -> fetchRow()){
						
						echo"<option value='".$r[0]."'>".$r[0]."</option>";
						
					} unset($r); unset ($s);
					
				echo"</select>";
				
				echo "<input type='hidden' name='status' value='ASIGNAR'>";
				
			echo "</td>";
	echo"<tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Ciudad</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
				echo "<select name='oficina' size='1' >";
					echo "<option value=''>Elegir</option>";
					
					$s= $INTRANET->Execute("SELECT * FROM PERFILES.CATALOGO_OFICINAS");
						
					while($r= $s -> fetchRow()){
						
						echo"<option value='".$r[1]."'>".$r[2]."</option>";
						
					} unset($r); unset ($s);
					
				echo"</select>";
				
				echo "<input type='hidden' name='status' value='ASIGNAR'>";
				
			echo "</td>";
	echo"<tr>";
	
	echo"<tr height='20'> </tr>";
	

	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Titulo</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo"<textarea name='titulo' style='width: 400px; height: 20px;'></textarea>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Descripcion del Requerimiento</td>";
	echo "</tr>";					
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo"<textarea name='descripcion' style='width: 400px; height: 80px;'></textarea>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto2' align='left' colspan='3'>Archivo</td>";
	echo "</tr>";		
	
		echo "<tr width='50'>";
		echo "<td width='50'> </td>";
		echo "<td width='50'> </td>";
		echo "<td width='50'colspan='4' id='titleBlueLineBottomAlta'> </td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo "<input id='FileCron' type='file' size='35' name='archivo'>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr width='50'>";
		echo "<td width='50'> </td>";
		echo "<td width='50'> </td>";
		echo "<td width='50'colspan='4' id='titleBlueLineBottomAlta'> </td>";
	echo "</tr>";
	
	echo"<tr height='30'> </tr>";
	
	echo "<tr>";
		echo "<td width='30'> </td>";
		echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
	echo "</tr>";
	
						
	  echo"<tr height='40'>";
		  echo "<td width='30'> </td>";
		  echo"<td valign='bottom' align='right' colspan='4'>";
			  echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
		  echo"</td>";
	  echo"</tr>";

	
	echo "</table>";
	
		echo "</form>";
echo "</div>";

?>
    	</body>
    </html>
<?php 

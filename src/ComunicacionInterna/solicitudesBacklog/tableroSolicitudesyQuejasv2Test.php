<?php error_reporting(0); ?>
<?php

 
$nombrephp = 'tableroSolicitudesyQuejas.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");


$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Tablero de Solicitudes</title>
        
        <?php
        if($estiloUsuario == 1){
			
            ?>
            <link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>
            <?php
			
        }else if($estiloUsuario == 2){
            ?>
            <link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>
            <?php
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
        
        <script>
            function show(valor){
                if(valor == 1){
                    document.getElementById("mostrar").style.display="block";
                    document.getElementById("ocultar").style.display="none";
                } else if (valor == 0){
                    document.getElementById("mostrar").style.display="none";
                    document.getElementById("ocultar").style.display="block";
                }
            }
        </script>
        <script>
        	function muestraPersonalizada(){
					var form1 = document.getElementById("ocultaPersonalizada");
					var form2 = document.getElementById("ocultaCodigo");
					if(form1.style.display ==  'none'){
						form2.style.display = 'none';
						form1.style.display = 'block';			
						}else{
							form1.style.display =  'none';
						}
			}
			
			function muestraCodigo(){
				var form1 = document.getElementById("ocultaPersonalizada");
				var form2 = document.getElementById("ocultaCodigo");
				if(form2.style.display == 'none'){
					form1.style.display = 'none';
					form2.style.display = 'block';
				}else{
					form2.style.display = 'none';
				}
				
			}
        </script>
    </head>
        
    <body>
        <div id="wrapperSolicitudes" align="center">
			<table border="0" align="center" width="800px">
                <tr>
                    <td align="left" id="breadcrumbs">Usuario: <?php echo $usuarioId; ?></td>
                </tr>
                
                <tr height="80px"><td></td></tr>
                
                <tr>
                    <td align="center" id="titulo1">Solicitudes</td>
                </tr>
                
                <tr>
                    <td align="center" valign="top" height="20px">
                        <table border="0" align="center">
                            <tr height="20px">
                                <td valign="middle">
                                    <img src="../../Imagenes/ICN_PointMeTo.png" id="banana1" style="display:none;" onClick="showBanana(0);">
                                    <img src="../../Imagenes/ICN_PointMeTo.png" id="banana0" style="display:inline-block;" onClick="showBanana(1);">
                                </td>
                                
                                <td valign="middle">
                                    <font style="display:inline-block;"><?php echo $breadcrumb; ?></font>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
               
                <tr height="70"><td></td></tr>
                
                <tr>
                    <td align="center">
                        <a href="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/ayudaSolicitud.php">
                            <img src="../../Imagenes/ICN_BotonAgregar.png" width="90" height="29">
                        </a>
                    </td>
                </tr>
                
                <tr height="30"><td></td></tr>
			</table>
            
            <table border="0" align="center" id="mapaIntranet" style="display:none;">
				<tr>
                    <td align="center">
                        <table border="0" align="center" id="breadcrumbs" style="border:1px solid #007cbd;">
                            <tr>
                                <td valign="top">
                                    <a href="../../ComunicacionInterna/comunicacionInterna.php" id="breadcrumbs">
                                        Comunicación Interna
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../ComunicacionInterna/TableroBoletines.php" id="breadcrumbs">
                                                Boletines
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../../ComunicacionInterna/listaQueHacer.php" id="breadcrumbs">
                                                Qué hacer
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../../ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php" id="breadcrumbs">
                                                Solicitudes y Quejas
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../../ComunicacionInterna/busquedaPersonal.php" id="breadcrumbs">
                                                Acceso Autorizado
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../SistemaGestionIntegral/homeSGI.php" id="breadcrumbs">
                                        Gestión Integral
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../SistemaGestionIntegral/Normas.php" id="breadcrumbs">
                                                Normas
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/CapituloNorma.php?norma=ISO" id="breadcrumbs">
                                                        ISO
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/CapituloNorma.php?norma=NMX" id="breadcrumbs">
                                                        NMX
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC" id="breadcrumbs">
                                                        NEEC
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li>
                                            <a href="../../SistemaGestionIntegral/manuales.php" id="breadcrumbs">
                                                Manuales
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-MC" id="breadcrumbs">
                                                        Manual de Gestión Integral
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-CDR" id="breadcrumbs">
                                                        Manual de Control de Documentos y Registros
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-AI" id="breadcrumbs">
                                                        Manual de Auditorías Internas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-CC" id="breadcrumbs">
                                                        Manual del Comité de Calidad
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-DG" id="breadcrumbs">
                                                        Manual de Dirección General
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-ADM" id="breadcrumbs">
                                                        Manual de Administración
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-RH" id="breadcrumbs">
                                                        Manual de Recursos Humanos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-TI" id="breadcrumbs">
                                                        Manual de Tecnologias de la Información
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-OPE" id="breadcrumbs">
                                                        Manual de Operaciones
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li>
                                            <a href="../../SistemaGestionIntegral/Modulos.php" id="breadcrumbs">
                                                Módulos del SGI
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Riesgos.php" id="breadcrumbs">
                                                        Administración de Riesgos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/ReunionesyAcuerdos.php" id="breadcrumbs">
                                                        Reuniones y Acuerdos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/tableroPreventivasCorrectivas.php" id="breadcrumbs">
                                                        Acciones Preventivas y Correctivas
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/tableroAuditorias.php" id="breadcrumbs">
                                                        Auditorías
                                                    </a>
                                                </li>
                                               
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Procesos.php" id="breadcrumbs">
                                                        Inventario de Procesos
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../Aplicaciones/aplicaciones.php" id="breadcrumbs">
                                        Aplicaciones
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../Aplicaciones/operaciones.php" id="breadcrumbs">
                                                Operaciones
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../../AdministracionProyectos/admonPro.php" id="breadcrumbs">
                                                Administración de Proyectos
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../Registros/Registros.php" id="breadcrumbs">
                                        Registros
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../Registros/TableroVisitas2.php" id="breadcrumbs">
                                                Visitas
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../../Registros/tableroRegistros.php" id="breadcrumbs">
                                                Registros
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../Configuraciones/configuraciones.php" id="breadcrumbs">
                                        Configuraciones
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../Configuraciones/ModificaPassword.php" id="breadcrumbs">
                                                Contraseñas
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
			</table>
             
			<table border="0" align="center">
				<tr height="20"><td></td></tr>
			</table>
            
        
        <?php

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

	
  
//if($categoriaUsr == 'Administrador'){
  
 /*echo "<table border='0' align='center' width='800px' id='ocultar' style='display:block;'>";
  echo"<tr>";
	echo"<td colspan='7' align='center' id='iconosTexto2' onClick='show(1);'>Filtrar</td>";
  echo"</tr>";
  echo "<td width='800px'></td>";
  echo"</table>";
  ///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
  echo "<table border='0' align='center' width='800px' id='mostrar' style='display:none;'>";
  echo"<tr>";
	echo"<td colspan='7' align='center' id='iconosTexto2' onClick='show(0);'> Filtrar </td>";
  echo"</tr>";*/
  //LINKS PARA BUSQUEDAS
  echo "<table border='0' align='center'   width='1200px'>";
  echo"<tr>";
	echo"<td colspan='3' align='right' id='iconosTexto2'><a href='javascript:void(0);' onclick='muestraPersonalizada();' style='color:rgb(0,124,189);'>Filtro</a> </td>";
	echo "<td width='15' align='center' style='color:rgb(0,124,189);'>/</td>";
    echo"<td colspan='3' align='left' id='iconosTexto2'><a href='javascript:void(0);' onclick='muestraCodigo();' style='color:rgb(0,124,189);'> Búsqueda Código</a> </td>";
  echo"</tr >";
  echo "<tr height='10'>";
  echo "</tr>";
  echo "</table>";
  
  //FORMULARIO PARA BUSQUEDAAVANZADA
   echo "<form method='post' action='tableroSolicitudesyQuejasv2.php'>";
   	echo "<table border='0' align='center' id='ocultaPersonalizada' style='display:none;'  width='1200px'>";
  		echo "<tr>";
  			echo "<td width='150' style='text-align:center;'>Año</td>";
			echo "<td width='150' style='text-align:center;'>Oficina</td>";
			echo "<td width='400' style='text-align:center;'>Tipo</td>";
			echo "<td width='200' style='text-align:center;'>Estatus</td>";
			echo "<td width='40'> </td>";
			echo "<td width='250' style='text-align:center;'>PDR</td>";
			echo "<td width='250' style='text-align:center;' >Solicitante</td>";
	  echo "</tr>";
 	 echo"<tr>";
  	 	echo"<td colspan='7' id='titleBlueLineTop'></td>";
  	echo"</tr>";
  	echo "<tr height='15'></tr>";
 	 echo "<tr align='left' height='20' >";
  	  	echo "<td width='150' id='iconosTexto2' align='left' valign='top'>";
			$w= $INTRANET->Execute("SELECT DISTINCT YEAR(xd_fecha) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) > 2010");
			while($p= $w->fetchRow()){
				echo"<input type='checkbox' name='anio[]' value='".$p[0]."'>$p[0]<br>";
			}
	echo"</td>";
	echo "<td width='150' id='iconosTexto2' align='left' valign='top'>";
			$l= $INTRANET->Execute("SELECT DISTINCT
											S.xt_ciudad
										FROM
											SGI_Quejas_Solicitudesv2 S
										WHERE
											S.xt_ciudad IN (
												SELECT
													IU.xt_codigoCiudad
												FROM
													IntranetGEA_Usuarios_Oficina IU
												WHERE
													IU.kf_usuarioId = '$usuarioId'
											)");
			while($i= $l->fetchRow()){
				echo"<input type='checkbox' name='ciudad[]' value='".$i[0]."'>$i[0]<br>";
			}
	echo"</td>";
	echo "<td width='400' id='iconosTexto2' align='left' valign='top'>";						
			echo"<input type='checkbox' name='tipoSolicitud[]' value='AV'>Administrativa<br>";
			echo"<input type='checkbox' name='tipoSolicitud[]' value='AB'>Alta baja usuario<br>";	
			echo"<input type='checkbox' name='tipoSolicitud[]' value='MT'>Mantenimiento<br>";	
			echo"<input type='checkbox' name='tipoSolicitud[]' value='ST'>Soporte Tecnico<br>";	
			echo"<input type='checkbox' name='tipoSolicitud[]' value='DS'>Desarrollo de Funcionalidad<br>";
			echo"<input type='checkbox' name='tipoSolicitud[]' value='EA'>Envio Archivos<br>";	
            echo"<input type='checkbox' name='tipoSolicitud[]' value='PY'>Proyecto<br>";						
	echo "</td>";
	echo "<td width='150' id='iconosTexto2' align='left' valign='top'>";						
			$y = $INTRANET->Execute("SELECT distinct xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_status not in('',6)");	
			while($u= $y->fetchRow()){
			echo"<input type='checkbox' name='estatus[]' value='".$u[0]."'>$u[0]<br>";
				}							
	echo "</td>";
	echo "<td width='40'> </td>";
	echo "<td  id='iconosTexto2' align='left' valign='top'>";
		echo "<select name='pdr' size='1' >";
			echo "<option value=''>Elige pdr</option>";	
			$a= $INTRANET->Execute("SELECT DISTINCT IU.xt_nombre, SQ.xt_pdr FROM SGI_Quejas_Solicitudesv2 SQ, IntranetGEA_USUARIOS IU WHERE SQ.xt_pdr = IU.kp_usuario order by IU.xt_nombre");	
			while($n= $a->fetchRow()){
				echo"<option value='".$n[1]."'>".$n[0]."</option>";	
			}						
		echo"</select>";
	echo "</td>"; 
	echo "<td   id='iconosTexto2' align='left' valign='top'>";
		echo "<select name='solicitante'>";
			echo "<option value=''>Elige un Solicitante</option>";
		$c = $INTRANET->Execute("SELECT DISTINCT	IU.xt_nombre, SQ.kf_usuarioId FROM	SGI_Quejas_Solicitudesv2 SQ,	IntranetGEA_USUARIOS IU WHERE	SQ.kf_usuarioId = IU.kp_usuario ORDER BY IU.xt_nombre");
		while($rw = $c->fetchRow()){
			echo "<option value='".$rw[1]."'>".$rw[0]."</option>";	
		}
		echo "</select>";
	echo "</td>";
  echo"</tr>";

  echo "<tr height='15'></tr>";
  echo "<tr>";
	echo "<td align='center'colspan='7'> <input type='image' name='Enviar' onclick='SubmitForm(this.form);' align='center' src='../../../Imagenes/ICN_BotonEnviar.png' width='60' height='20'> </td>";	
	//echo "<td align='center' width='60'></td>";
  echo "</tr>";
  echo"<tr height='50'></tr>";
 echo"</table>";
 
 //FORMULARIO PARA BUSCAR POR CODIGO
 	echo "<table border='0' align='center' id='ocultaCodigo' style='display:none;'  width='1200px'>";
  		echo "<tr>";
			echo "<td colspan='7' align='center'>";
				echo "<input type='text' name='codigo' size='40' placeholder='GE-B-DF-16-123' >";
			echo "</td>";
		echo "</tr>";
		 echo "<tr height='15'></tr>";
  echo "<tr>";
	echo "<td align='center'colspan='7'> <input type='image' name='Enviar' onclick='SubmitForm(this.form);' align='center' src='../../../Imagenes/ICN_BotonEnviar.png' width='60' height='20'> </td>";	
	//echo "<td align='center' width='60'></td>";
  echo "</tr>";
  echo"<tr height='50'></tr>";
	echo "<table >";
  //}
echo"</form>";

//cuando selecciona el boton de Enviar
if((!empty($_POST['ciudad']) || !empty($_POST['tipoSolicitud']) || !empty($_POST['estatus']) || !empty($_POST['pdr']) || !empty($_POST['solicitante']) || !empty($_POST['anio'])) && empty($_POST['codigo'])) {
			
		$oficina           = $_POST['ciudad'];
		$status            = $_POST['estatus'];
		$tipoSoli          = $_POST['tipoSolicitud'];
		$responsable       = $_POST['pdr'];
		$anio              = $_POST['anio'];
		$solicitante       = $_POST['solicitante'];
		
		//Por año 
		if($anio != ''){
		foreach($anio as $año){
			$valor = "'".$año."'";
			$años_aux[] = "'".$año."'";
		}
		$valorAño = implode(',', $años_aux);
		$años = $valorAño;
		}
		//Por Oficina 
		if($oficina != ''){
		foreach($oficina as $ofi){
			$valor = "'".$ofi."'";
			$ciudades_aux[] = "'".$ofi."'";
		}
		$valorOficina = implode(',', $ciudades_aux);
		$oficinas = $valorOficina;
		}
		//Por etapas
		if($status != ''){
		foreach($status as $etapa){
			$valor = "'".$etapa."'";
			$estatus_aux[] = "'".$etapa."'";
		}
		$statusNuevo = implode(',', $estatus_aux);
		$estatu = $statusNuevo;
		}
		
		//Por Tipo de Solicitud
		if($tipoSoli != ''){
		foreach($tipoSoli as $solicitudTipo){
			$valor = "'".$solicitudTipo."'";
			$solicitud_aux[] = "'".$solicitudTipo."'";
		}
		$tipoNuevo = implode(',', $solicitud_aux);
		 $solicitudNuevo = $tipoNuevo;
		}
		
		if($años != ''){$añosQuery = "YEAR(xd_fecha) in($años):";}else{$añosQuery = '';}
		if($oficina != ''){$oficinaQuery = "xt_ciudad in($oficinas):";}else{$aficinaQuery = '';}
		if($status != ''){$statusQuery = "xt_status in($estatu):";}else{$statusQuery = '';}
		if($responsable != ''){$responsableQuery = "xt_pdr = '$responsable':";}else{$responsableQuery = '';}
		if($solicitudNuevo != ''){$solicitudNuevoQuery = "xt_tipoSolicitud in($solicitudNuevo):";}else{$solicitudNuevoQuery = '';}
		if($solicitante != ''){$solicitanteQuery = "kf_usuarioId = '$solicitante':";}else{$solicitanteQuery = '';}
		
		$concatenarFiltro = $añosQuery.$oficinaQuery.$statusQuery.$responsableQuery.$solicitudNuevoQuery.$solicitanteQuery;
		$filtroRemplaza = str_replace(":"," AND ",$concatenarFiltro);
		$filtroRemplazaAnd = substr($filtroRemplaza,0,-4);
		$query = "SELECT xt_quejaSolicitud, xt_titulo, xd_fecha, xt_status, kf_usuarioId, xt_pdr, xt_tipoSolicitud, xt_ciudad FROM SGI_Quejas_Solicitudesv2 SGI WHERE ".$filtroRemplazaAnd;

		$s = $INTRANET->Execute($query);
					
					$indice = 0;
					while($r = $s->fetchRow()){
					$claveQuejaSolicitud[$indice] = $r[0];
					$titulo[$indice]              = $r[1];
					$fecha[$indice]               = $r[2];
					$estatus[$indice]             = $r[3];
					$usuario[$indice]             = $r[4];
					$pdr[$indice]                 = $r[5];
					$tipoSolicitud[$indice]       = $r[6];
					$ciudad[$indice]              = $r[7];
					
					$nombreUsuario[$indice] =  $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdr[$indice]'");	
					$nombreSolicita[$indice] =  $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuario[$indice]'");
					
					$indice++;			
			}unset($r);	 	
		}else if(( empty($_POST['ciudad']) && empty($_POST['tipoSolicitud']) && empty($_POST['estatus']) && empty($_POST['pdr']) && empty($_POST['solicitante']) && empty($_POST['anio'])) && !empty($_POST['codigo'])){
			
            $codigo = $_POST['codigo'] ;
            $query = "SELECT xt_quejaSolicitud, xt_titulo, xd_fecha, xt_status, kf_usuarioId, xt_pdr, xt_tipoSolicitud, xt_ciudad FROM SGI_Quejas_Solicitudesv2 SGI WHERE  xt_quejaSolicitud = '$codigo'";
			$s = $INTRANET->Execute($query);
			$indice = 0;
			while($r = $s->fetchRow()){
					$claveQuejaSolicitud[$indice] = $r[0];
					$titulo[$indice]              = $r[1];
					$fecha[$indice]               = $r[2];
					$estatus[$indice]             = $r[3];
					$usuario[$indice]             = $r[4];
					$pdr[$indice]                 = $r[5];
					$tipoSolicitud[$indice]       = $r[6];
					$ciudad[$indice]              = $r[7];
					
					$nombreUsuario[$indice] =  $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdr[$indice]'");	
					$nombreSolicita[$indice] =  $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuario[$indice]'");
					
					$indice++;			
			}unset($r);
		}else if( empty($_POST['ciudad']) && empty($_POST['tipoSolicitud']) && empty($_POST['estatus']) && empty($_POST['pdr']) && empty($_POST['solicitante']) && empty($_POST['anio']) &&  empty($_POST['codigo'])) {
        //Despliega por default al entrar al tablero de Solicitudes	

    $year = date("Y");
    $month = date("m");
	$personaResponsable = $INTRANET->getOne("SELECT
												EMP.kf_usuario,
												EMP.xt_Nombre,
												EMP.xt_ApellidoPaterno
											FROM
												SGI_EmpleadosActividad EMPA,
												SGI_Empleados EMP
											WHERE
											EMP.kf_usuario = '$usuarioId'
											AND	EMP.kp_personalId = EMPA.kf_personalID
											AND EMPA.xt_actividad = 'PDR'
											ORDER BY
												EMP.xt_Nombre");
		
	//Consulta las solicitudes solo para inhouse
	if($personaResponsable != '' && $categoriaUsr == 'Inhouse'){
		
        //echo "Entro1"; 
		$indice = 0;
		$s = $INTRANET->Execute("SELECT xt_quejaSolicitud, xt_titulo, xd_fecha, xt_status, kf_usuarioId, xt_pdr, xt_tipoSolicitud, xt_ciudad FROM SGI_Quejas_Solicitudesv2 SGI WHERE xt_pdr = '$usuarioId' OR kf_usuarioId = '$usuarioId' AND xt_tipo = 'B' xt_ciudad = 'DF' order by xt_quejaSolicitud DESC");
        //echo "SELECT xt_quejaSolicitud, xt_titulo, xd_fecha, xt_status, kf_usuarioId, xt_pdr, xt_tipoSolicitud, xt_ciudad FROM SGI_Quejas_Solicitudesv2 SGI WHERE xt_pdr = '$usuarioId' OR kf_usuarioId = '$usuarioId' AND xt_tipo = 'B' order by xt_quejaSolicitud DESC";
		
			
	}else{
		if($categoriaUsr == 'Administrador' ){
				  //echo "Entro2";				  
				  $indice = 0;
				  //echo "SELECT xt_quejaSolicitud, xt_titulo, xd_fecha, xt_status, kf_usuarioId, xt_pdr, xt_tipoSolicitud, xt_ciudad FROM SGI_Quejas_Solicitudesv2 SGI WHERE  xt_tipo = 'B' AND ( ( (xt_status != 'TERMINADA' AND xt_stauts != 'RECHAZADA')  or xt_status IS NULL) AND YEAR(xd_fecha) = '$year')  OR ( YEAR(xd_fecha) = '$year' AND MONTH(xd_fecha) = '$month' AND (xt_status != 'TERMINADA' AND xt_status != 'RECHAZADA')) order by xt_quejaSolicitud DESC";
                  $s = $INTRANET->Execute("SELECT xt_quejaSolicitud, xt_titulo, xd_fecha, xt_status, kf_usuarioId, xt_pdr, xt_tipoSolicitud, xt_ciudad FROM SGI_Quejas_Solicitudesv2 SGI WHERE  (xt_tipo = 'B' AND YEAR(xd_fecha) = '$year' AND MONTH(xd_fecha) = '$month'  AND ((xt_status != 'TERMINADA' AND xt_status != 'REVISION' AND xt_status != 'RECHAZADA' and xt_status != 'ENTREGABLE RECHAZADO')OR xt_status IS NULL) ) OR (kf_usuarioId = '$usuarioId' AND xt_tipo = 'B' AND YEAR(xd_fecha) = '$year' AND (xt_status != 'TERMINADA' AND xt_status != 'RECHAZADA' and xt_status != 'ENTREGABLE RECHAZADO')OR xt_status IS NULL) order by xt_quejaSolicitud DESC");
				  
				 //Consulta las solicitudes solo para inhouse 
		}else if($categoriaUsr == 'Inhouse'){
					//echo "Entro3"; 
				 $indice = 0;
				 $s = $INTRANET->Execute("SELECT xt_quejaSolicitud, xt_titulo, xd_fecha, xt_status, kf_usuarioId, xt_pdr, xt_tipoSolicitud, xt_ciudad FROM SGI_Quejas_Solicitudesv2 SGI WHERE xt_pdr = '$usuarioId' OR kf_usuarioId = '$usuarioId' AND xt_tipo = 'B'  AND xt_ciudad = 'DF' order by xt_quejaSolicitud DESC");
		}
	}
			while($r = $s->fetchRow()){
				$claveQuejaSolicitud[$indice] = $r[0];
				$titulo[$indice]              = $r[1];
				$fecha[$indice]               = $r[2];
				$estatus[$indice]             = $r[3];
				$usuario[$indice]             = $r[4];
				$pdr[$indice]                 = $r[5];
				$tipoSolicitud[$indice]       = $r[6];
				$ciudad[$indice]              = $r[7];
				
				$nombreUsuario[$indice] =  $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdr[$indice]'");
				$nombreSolicita[$indice] =  $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuario[$indice]'");
				
				$indice++;
					
			}//unset($r);
		 }	
	
	if($claveQuejaSolicitud != ''){
		
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr>";
					echo"<td id='titulo2Blanco'>Distrito Federal</td>";
				echo"</tr>";
			echo"</table>";
		
			
			$cont = 0;
			for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == 'DF' && $tipoSolicitud[$a] == 'AB'){
					$cont++;
				}
			}
			if($cont > 0){
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr>";
				echo"<tr height='25'>";
					echo"<td id='titulo2'>Alta y baja de usuarios</td>";
				echo"</tr>";
				echo"<tr>";
					echo"<td colspan='9' id='titleBlueLineTop'></td>";
				echo"</tr>";
				echo"<tr height='2px'><td colspan='10'></td></tr>";
			echo"</table>";	
				
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr id='iconosTexto2'>";
					echo"<td width='55px'></td>";
					echo"<td width='150px' align='left'>Código</td>";
					echo"<td width='350px' align='left'>Título</td>";
					echo"<td width='10px'></td>";
					echo"<td width='100px' align='center'>Fecha</td>";
					echo"<td width='10px'></td>";
					echo"<td width='120px' align='left'>Status</td>";
					echo"<td width='200px' align='left'>Solicitante</td>";
					echo"<td width='10px'></td>";
					echo"<td width='200px' align='left'>PDR</td>";
				echo"</tr>";
					   
				echo"<tr height='20px'><td colspan='10'></td></tr>";
			echo"</table>";	
			}
			//Muestra oficina de aeropuerto cuando es AB	
				for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == "DF" && $tipoSolicitud[$a] == 'AB'){
						echo"<table border='0' align='center'  width='1300px'>";
						  echo"<tr id='fileItem'>";
							echo"<td width='30px'></td>";
							echo"<td width='150px' align='left' valign='top'><a href='fichaAltaBajaUsuario.php?codigo=".urlencode($claveQuejaSolicitud[$a])."' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
							echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
						echo"</tr>";  
						echo"<tr height='10px'><td colspan='10'></td></tr>";
					echo"</table>";
					}
				}
			
			
			$cont = 0;
			for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == 'DF' && $tipoSolicitud[$a] == 'AV'){
					$cont++;
				}
			}
			if($cont > 0){
				echo"<table border='0' align='center'  width='1300px'>";
					echo"<tr>";
					echo"<tr height='25'>";
						echo"<td id='titulo2'>Administrativa</td>";
					echo"</tr>";
					echo"<tr>";
					echo"<td colspan='9' id='titleBlueLineTop'></td>";
				echo"</tr>";
					echo"<tr height='2px'><td colspan='10'></td></tr>";
				echo"</table>";	
					
				echo"<table border='0' align='center'  width='1300px'>";
					echo"<tr id='iconosTexto2'>";
						echo"<td width='55px'></td>";
						echo"<td width='150px' align='left'>Código</td>";
						echo"<td width='350px' align='left'>Título</td>";
						echo"<td width='10px'></td>";
						echo"<td width='100px' align='center'>Fecha</td>";
						echo"<td width='10px'></td>";
						echo"<td width='120px' align='left'>Status</td>";
						echo"<td width='200px' align='left'>Solicitante</td>";
						echo"<td width='10px'></td>";
						echo"<td width='200px' align='left'>PDR</td>";
					echo"</tr>";
						   
					echo"<tr height='20px'><td colspan='10'></td></tr>";
				echo"</table>";	
			}
		//Muestra oficina de aeropuerto cuando es AV	
			for($a=0; $a<count($claveQuejaSolicitud); $a++){
				
				if($ciudad[$a] == "DF" && $tipoSolicitud[$a] == 'AV'){
						echo"<table border='0' align='center'  width='1300px'>";
						  echo"<tr id='fileItem'>";
							echo"<td width='30px'></td>";
							echo"<td width='150px' align='left' valign='top'><a href='fichaSolicitudv2.php?coodigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
							echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
						echo"</tr>";  
						echo"<tr height='10px'><td colspan='10'></td></tr>";
						echo"</table>";
					}
				}
				
			$cont = 0;
			for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == 'DF' && $tipoSolicitud[$a] == 'DS'){
					$cont++;
				}
			}
			if($cont > 0){
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr height='25'>";
				echo"</tr>";
				echo"<tr>";
					echo"<td id='titulo2'>Desarrollo de Funcionalidades</td>";
				echo"</tr>";
				echo"<tr>";
					echo"<td colspan='9' id='titleBlueLineTop'></td>";
				echo"</tr>";
				echo"<tr height='2px'><td colspan='10'></td></tr>";
			echo"</table>";	
				
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr id='iconosTexto2'>";
					echo"<td width='55px'></td>";
					echo"<td width='150px' align='left'>Código</td>";
					echo"<td width='350px' align='left'>Título</td>";
					echo"<td width='10px'></td>";
					echo"<td width='100px' align='center'>Fecha</td>";
					echo"<td width='10px'></td>";
					echo"<td width='120px' align='left'>Status</td>";
					echo"<td width='200px' align='left'>Solicitante</td>";
					echo"<td width='10px'></td>";
					echo"<td width='200px' align='left'>PDR</td>";
				echo"</tr>";
					   
				echo"<tr height='20px'><td colspan='10'></td></tr>";
			echo"</table>";	
			}
			//Muestra oficina de aeropuerto cuando es DS
				for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == "DF" && $tipoSolicitud[$a] == 'DS'){
						echo"<table border='0' align='center'  width='1300px'>";
						  echo"<tr id='fileItem'>";
							echo"<td width='30px'></td>";
							echo"<td width='150px' align='left' valign='top'><a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
							echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
						echo"</tr>";  
						echo"<tr height='10px'><td colspan='10'></td></tr>";
					echo"</table>";
					}
				}
				
			$cont = 0;
			for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == 'DF' && $tipoSolicitud[$a] == 'EA'){
					$cont++;
				}
			}
			if($cont > 0){
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr height='25'>";
				echo"</tr>";
				echo"<tr>";
					echo"<td id='titulo2'>Envio Archivos</td>";
				echo"</tr>";
				echo"<tr>";
					echo"<td colspan='9' id='titleBlueLineTop'></td>";
				echo"</tr>";
				echo"<tr height='2px'><td colspan='10'></td></tr>";
			echo"</table>";	
				
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr id='iconosTexto2'>";
					echo"<td width='55px'></td>";
					echo"<td width='150px' align='left'>Código</td>";
					echo"<td width='350px' align='left'>Título</td>";
					echo"<td width='10px'></td>";
					echo"<td width='100px' align='center'>Fecha</td>";
					echo"<td width='10px'></td>";
					echo"<td width='120px' align='left'>Status</td>";
					echo"<td width='200px' align='left'>Solicitante</td>";
					echo"<td width='10px'></td>";
					echo"<td width='200px' align='left'>PDR</td>";
				echo"</tr>";
					   
				echo"<tr height='20px'><td colspan='10'></td></tr>";
			echo"</table>";	
			}
			//Muestra oficina de aeropuerto cuando es DS
				for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == "DF" && $tipoSolicitud[$a] == 'EA'){
						echo"<table border='0' align='center'  width='1300px'>";
						  echo"<tr id='fileItem'>";
							echo"<td width='30px'></td>";
							echo"<td width='150px' align='left' valign='top'><a href='fichaEnvioArchivos.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
							echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
						echo"</tr>";  
						echo"<tr height='10px'><td colspan='10'></td></tr>";
					echo"</table>";
					}
				}
			
			$cont = 0;
			for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == 'DF' && $tipoSolicitud[$a] == 'MT'){
					$cont++;
				}
			}
			if($cont > 0){	
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr height='25'>";
				echo"</tr>";
				echo"<tr>";
					echo"<td id='titulo2'>Mantenimiento</td>";
				echo"</tr>";
				echo"<tr>";
					echo"<td colspan='9' id='titleBlueLineTop'></td>";
				echo"</tr>";
				echo"<tr height='2px'><td colspan='10'></td></tr>";
			echo"</table>";	
				
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr id='iconosTexto2'>";
					echo"<td width='55px'></td>";
					echo"<td width='150px' align='left'>Código</td>";
					echo"<td width='350px' align='left'>Título</td>";
					echo"<td width='10px'></td>";
					echo"<td width='100px' align='center'>Fecha</td>";
					echo"<td width='10px'></td>";
					echo"<td width='120px' align='left'>Status</td>";
					echo"<td width='200px' align='left'>Solicitante</td>";
					echo"<td width='10px'></td>";
					echo"<td width='200px' align='left'>PDR</td>";
				echo"</tr>";
					   
				echo"<tr height='20px'><td colspan='10'></td></tr>";
			echo"</table>";	
			}
			//Muestra oficina de aeropuerto cuando es MT	
				for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == "DF" && $tipoSolicitud[$a] == 'MT'){
						echo"<table border='0' align='center'  width='1300px'>";
						  echo"<tr id='fileItem'>";
							echo"<td width='30px'></td>";
							echo"<td width='150px' align='left' valign='top'><a href='fichaMantenimiento_Sistema.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
							echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
						echo"</tr>";  
						echo"<tr height='10px'><td colspan='10'></td></tr>";
					echo"</table>";
					}
				}
			
			$cont = 0;
			for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == 'DF' && $tipoSolicitud[$a] == 'ST'){
					$cont++;
				}
			}
			if($cont > 0){	
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr height='25'>";
				echo"</tr>";
				echo"<tr>";
					echo"<td id='titulo2'>Soporte Tecnico</td>";
				echo"</tr>";
				echo"<tr>";
					echo"<td colspan='9' id='titleBlueLineTop'></td>";
				echo"</tr>";
				echo"<tr height='2px'><td colspan='10'></td></tr>";
			echo"</table>";	
				
			echo"<table border='0' align='center'  width='1300px'>";
				echo"<tr id='iconosTexto2'>";
					echo"<td width='55px'></td>";
					echo"<td width='150px' align='left'>Código</td>";
					echo"<td width='350px' align='left'>Título</td>";
					echo"<td width='10px'></td>";
					echo"<td width='100px' align='center'>Fecha</td>";
					echo"<td width='10px'></td>";
					echo"<td width='120px' align='left'>Status</td>";
					echo"<td width='200px' align='left'>Solicitante</td>";
					echo"<td width='10px'></td>";
					echo"<td width='200px' align='left'>PDR</td>";
				echo"</tr>";
					   
				echo"<tr height='20px'><td colspan='10'></td></tr>";
			echo"</table>";	
			}
			//Muestra oficina de aeropuerto cuando es ST	
				for($a=0; $a<count($claveQuejaSolicitud); $a++){	
					if($ciudad[$a] == "DF" && $tipoSolicitud[$a] == 'ST'){
						echo"<table border='0' align='center'  width='1300px'>";
						  echo"<tr id='fileItem'>";
							echo"<td width='30px'></td>";
							echo"<td width='150px' align='left' valign='top'><a href='fichaSoporteTecnico.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
							echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
							echo"<td width='10px'></td>";
							echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
						echo"</tr>";  
						echo"<tr height='10px'><td colspan='10'></td></tr>";
					echo"</table>";
					}
				}

                $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'DF' && $tipoSolicitud[$a] == 'PY'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr>";
                echo"<tr height='25'>";
                    echo"<td id='titulo2'>Proyecto</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de aeropuerto cuando es PY    
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "DF" && $tipoSolicitud[$a] == 'PY'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaProyectoFuncionalidad.php?codigo=".urlencode($claveQuejaSolicitud[$a])."' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }

                    ///Despliega informacion de Nuevo Laredo-----------------------------------------------------------------------------------------------------------------------------------------
            $conteo = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'NLR'){
                    $conteo++;
                }
            }
            if($conteo > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='20px'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2Blanco'>Nuevo Laredo</td>";
                echo"</tr>";
            echo"</table>";
            }
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'NLR' && $tipoSolicitud[$a] == 'AB'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr>";
                echo"<tr height='25'>";
                echo"<td width='25px'></td>";
                    echo"<td id='titulo2'>Alta y baja de usuarios</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Nuevo Laredo cuando es AB  
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "NLR" && $tipoSolicitud[$a] == 'AB'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaAltaBajaUsuario.php?codigo=".urlencode($claveQuejaSolicitud[$a])."' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'NLR' && $tipoSolicitud[$a] == 'AV'){
                    $cont++;
                }
            }
            if($cont != ''){
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr>";
                    echo"<tr height='25'>";
                        echo"<td id='titulo2'>Administrativa</td>";
                    echo"</tr>";
                    echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                    echo"<tr height='2px'><td colspan='10'></td></tr>";
                echo"</table>"; 
                    
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr id='iconosTexto2'>";
                        echo"<td width='55px'></td>";
                        echo"<td width='150px' align='left'>Código</td>";
                        echo"<td width='350px' align='left'>Título</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='100px' align='center'>Fecha</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='120px' align='left'>Status</td>";
                        echo"<td width='200px' align='left'>Solicitante</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='200px' align='left'>PDR</td>";
                    echo"</tr>";
                           
                    echo"<tr height='20px'><td colspan='10'></td></tr>";
                echo"</table>"; 
            }
        //Muestra oficina de Nuevo Laredo cuando es AV  
        
            for($a=0; $a<count($claveQuejaSolicitud); $a++){
            //  echo $claveQuejaSolicitud[$a];
                if($ciudad[$a] == 'NLR' && $tipoSolicitud[$a] == 'AV'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaSolicitudv2.php?coodigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                        echo"</table>";
                    }
                }
                
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'NLR' && $tipoSolicitud[$a] == 'DS'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Desarrollo de Funcionalidades</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Nuevo Laredo cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "NLR" && $tipoSolicitud[$a] == 'DS'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";;
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
                
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'NLR' && $tipoSolicitud[$a] == 'EA'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Envio Archivos</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de aeropuerto cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "NLR" && $tipoSolicitud[$a] == 'EA'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaEnvioArchivos.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'NLR' && $tipoSolicitud[$a] == 'MT'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Mantenimiento</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Nuevo Laredo cuando es MT  
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "NLR" && $tipoSolicitud[$a] == 'MT'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaMantenimiento_Sistema.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'NLR' && $tipoSolicitud[$a] == 'ST'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Soporte Tecnico</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Nuevo Laredo cuando es ST  
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "NLR" && $tipoSolicitud[$a] == 'ST'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaSoporteTecnico.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
                
        ///Despliega informacion de Cancun-----------------------------------------------------------------------------------------------------------------------------------------
        $conteo = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'CUN'){
                    $conteo++;
                }
            }
        if($conteo > 0){
        
        echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='20px'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2Blanco'>Cancún</td>";
                echo"</tr>";
            echo"</table>";
        }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'CUN' && $tipoSolicitud[$a] == 'AB'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr>";
                echo"<tr height='25'>";
                echo"<td width='25px'></td>";
                    echo"<td id='titulo2'>Alta y baja de usuarios</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Cancun cuando es AB    
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "CUN" && $tipoSolicitud[$a] == 'AB'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaAltaBajaUsuario.php?codigo=".urlencode($claveQuejaSolicitud[$a])."' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'CUN' && $tipoSolicitud[$a] == 'AV'){
                    $cont++;
                }
            }
            if($cont > 0){
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr>";
                    echo"<tr height='25'>";
                        echo"<td id='titulo2'>Administrativa</td>";
                    echo"</tr>";
                    echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                    echo"<tr height='2px'><td colspan='10'></td></tr>";
                echo"</table>"; 
                    
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr id='iconosTexto2'>";
                        echo"<td width='55px'></td>";
                        echo"<td width='150px' align='left'>Código</td>";
                        echo"<td width='350px' align='left'>Título</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='100px' align='center'>Fecha</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='120px' align='left'>Status</td>";
                        echo"<td width='200px' align='left'>Solicitante</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='200px' align='left'>PDR</td>";
                    echo"</tr>";
                           
                    echo"<tr height='20px'><td colspan='10'></td></tr>";
                echo"</table>"; 
            }
        //Muestra oficina de Cancun cuando es AV    
            for($a=0; $a<count($claveQuejaSolicitud); $a++){
                
                if($ciudad[$a] == "CUN" && $tipoSolicitud[$a] == 'AV'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaSolicitudv2.php?coodigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                        echo"</table>";
                    }
                }
                
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'CUN' && $tipoSolicitud[$a] == 'DS'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Desarrollo de Funcionalidades</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Cancun cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "CUN" && $tipoSolicitud[$a] == 'DS'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
                
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'CUN' && $tipoSolicitud[$a] == 'EA'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Envio Archivos</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de aeropuerto cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "CUN" && $tipoSolicitud[$a] == 'EA'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaEnvioArchivos.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'CUN' && $tipoSolicitud[$a] == 'MT'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Mantenimiento</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Cancun cuando es MT    
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "CUN" && $tipoSolicitud[$a] == 'MT'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaMantenimiento_Sistema.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'CUN' && $tipoSolicitud[$a] == 'ST'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Soporte Tecnico</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Cancun cuando es ST    
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "CUN" && $tipoSolicitud[$a] == 'ST'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaSoporteTecnico.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
                
        ///Despliega informacion de Veracruz-----------------------------------------------------------------------------------------------------------------------------------------
        $conteo = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'VER'){
                    $conteo++;
                }
            }
        if($conteo > 0){
        
        echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='20px'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2Blanco'>Veracruz</td>";
                echo"</tr>";
            echo"</table>";
        }
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'VER' && $tipoSolicitud[$a] == 'AB'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr>";
                echo"<tr height='25'>";
                echo"<td width='25px'></td>";
                    echo"<td id='titulo2'>Alta y baja de usuarios</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Veracruz cuando es AB  
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "VER" && $tipoSolicitud[$a] == 'AB'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaAltaBajaUsuario.php?codigo=".urlencode($claveQuejaSolicitud[$a])."' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'VER' && $tipoSolicitud[$a] == 'AV'){
                    $cont++;
                }
            }
            if($cont > 0){
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr>";
                    echo"<tr height='25'>";
                        echo"<td id='titulo2'>Administrativa</td>";
                    echo"</tr>";
                    echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                    echo"<tr height='2px'><td colspan='10'></td></tr>";
                echo"</table>"; 
                    
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr id='iconosTexto2'>";
                        echo"<td width='55px'></td>";
                        echo"<td width='150px' align='left'>Código</td>";
                        echo"<td width='350px' align='left'>Título</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='100px' align='center'>Fecha</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='120px' align='left'>Status</td>";
                        echo"<td width='200px' align='left'>Solicitante</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='200px' align='left'>PDR</td>";
                    echo"</tr>";
                           
                    echo"<tr height='20px'><td colspan='10'></td></tr>";
                echo"</table>"; 
            }
        //Muestra oficina de Veracruz cuando es AV  
            for($a=0; $a<count($claveQuejaSolicitud); $a++){
                
                if($ciudad[$a] == "VER" && $tipoSolicitud[$a] == 'AV'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaSolicitudv2.php?coodigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                        echo"</table>";
                    }
                }
                
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'VER' && $tipoSolicitud[$a] == 'DS'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Desarrollo de Funcionalidades</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Veracruz cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "VER" && $tipoSolicitud[$a] == 'DS'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'VER' && $tipoSolicitud[$a] == 'EA'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Envio Archivos</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de aeropuerto cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "VER" && $tipoSolicitud[$a] == 'EA'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaEnvioArchivos.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'VER' && $tipoSolicitud[$a] == 'MT'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Mantenimiento</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Veracruz cuando es MT  
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "VER" && $tipoSolicitud[$a] == 'MT'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaMantenimiento_Sistema.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'VER' && $tipoSolicitud[$a] == 'ST'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Soporte Tecnico</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Veracruz cuando es ST  
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "VER" && $tipoSolicitud[$a] == 'ST'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaSoporteTecnico.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
        
        ///Despliega informacion de Toluca-----------------------------------------------------------------------------------------------------------------------------------------
        $conteo = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'TOL'){
                    $conteo++;
                }
            }
        if($conteo > 0){
        
        echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='20px'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2Blanco'>Toluca</td>";
                echo"</tr>";
            echo"</table>";
        }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'TOL' && $tipoSolicitud[$a] == 'AB'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr>";
                echo"<tr height='25'>";
                echo"<td width='25px'></td>";
                    echo"<td id='titulo2'>Alta y baja de usuarios</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Toluca cuando es AB    
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "TOL" && $tipoSolicitud[$a] == 'AB'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaAltaBajaUsuario.php?codigo=".urlencode($claveQuejaSolicitud[$a])."' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'TOL' && $tipoSolicitud[$a] == 'AV'){
                    $cont++;
                }
            }
            if($cont > 0){
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr>";
                    echo"<tr height='25'>";
                        echo"<td id='titulo2'>Administrativa</td>";
                    echo"</tr>";
                    echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                    echo"<tr height='2px'><td colspan='10'></td></tr>";
                echo"</table>"; 
                    
                echo"<table border='0' align='center'  width='1300px'>";
                    echo"<tr id='iconosTexto2'>";
                        echo"<td width='55px'></td>";
                        echo"<td width='150px' align='left'>Código</td>";
                        echo"<td width='350px' align='left'>Título</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='100px' align='center'>Fecha</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='120px' align='left'>Status</td>";
                        echo"<td width='200px' align='left'>Solicitante</td>";
                        echo"<td width='10px'></td>";
                        echo"<td width='200px' align='left'>PDR</td>";
                    echo"</tr>";
                           
                    echo"<tr height='20px'><td colspan='10'></td></tr>";
                echo"</table>"; 
            }
        //Muestra oficina de Toluca cuando es AV    
            for($a=0; $a<count($claveQuejaSolicitud); $a++){
                
                if($ciudad[$a] == "TOL" && $tipoSolicitud[$a] == 'AV'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaSolicitudv2.php?coodigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";                            
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                        echo"</table>";
                    }
                }
                
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'TOL' && $tipoSolicitud[$a] == 'DS'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Desarrollo de Funcionalidades</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Toluca cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "TOL" && $tipoSolicitud[$a] == 'DS'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'TOL' && $tipoSolicitud[$a] == 'EA'){
                    $cont++;
                }
            }
            if($cont > 0){
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Envio Archivos</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de aeropuerto cuando es DS
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "TOL" && $tipoSolicitud[$a] == 'EA'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left' valign='top'><a href='fichaEnvioArchivos.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'TOL' && $tipoSolicitud[$a] == 'MT'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Mantenimiento</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Toluca cuando es MT    
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "TOL" && $tipoSolicitud[$a] == 'MT'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left'><a href='fichaMantenimiento_Sistema.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }
            
            $cont = 0;
            for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == 'TOL' && $tipoSolicitud[$a] == 'ST'){
                    $cont++;
                }
            }
            if($cont > 0){  
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr height='25'>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td id='titulo2'>Soporte Tecnico</td>";
                echo"</tr>";
                echo"<tr>";
                    echo"<td colspan='9' id='titleBlueLineTop'></td>";
                echo"</tr>";
                echo"<tr height='2px'><td colspan='10'></td></tr>";
            echo"</table>"; 
                
            echo"<table border='0' align='center'  width='1300px'>";
                echo"<tr id='iconosTexto2'>";
                    echo"<td width='55px'></td>";
                    echo"<td width='150px' align='left'>Código</td>";
                    echo"<td width='350px' align='left'>Título</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='100px' align='center'>Fecha</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='120px' align='left'>Status</td>";
                    echo"<td width='200px' align='left'>Solicitante</td>";
                    echo"<td width='10px'></td>";
                    echo"<td width='200px' align='left'>PDR</td>";
                echo"</tr>";
                       
                echo"<tr height='20px'><td colspan='10'></td></tr>";
            echo"</table>"; 
            }
            //Muestra oficina de Toluca cuando es ST    
                for($a=0; $a<count($claveQuejaSolicitud); $a++){    
                    if($ciudad[$a] == "TOL" && $tipoSolicitud[$a] == 'ST'){
                        echo"<table border='0' align='center'  width='1300px'>";
                          echo"<tr id='fileItem'>";
                            echo"<td width='30px'></td>";
                            echo"<td width='150px' align='left'><a href='fichaSoporteTecnico.php?codigo=$claveQuejaSolicitud[$a]' id='fileItem' style='text-decoration:none;'>".$claveQuejaSolicitud[$a]."</a></td>";
                            echo"<td width='350px' align='left'>".$titulo[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='120px' align='left' valign='top'>".$estatus[$a]."</td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreSolicita[$a]."</td>";
                            echo"<td width='10px'></td>";
                            echo"<td width='200px' align='left' valign='top'>".$nombreUsuario[$a]."</td>";
                        echo"</tr>";  
                        echo"<tr height='10px'><td colspan='10'></td></tr>";
                    echo"</table>";
                    }
                }

		echo"<table border='0' align='center'  width='1300px'>";					   
				echo"<tr height='50px'><td colspan='10'></td></tr>";
		echo"</table>";	
	}/*else{
	echo"<table border='0' align='center'  width='1200px'>";
				echo"<tr height='25'>";
				echo"</tr>";
				/*echo"<tr>";
					echo"<td colspan='9' id='titleBlueLineTop'></td>";
				echo"</tr>";
				*//*echo"<tr height='25'>";
				echo"<tr align='center'>";
					echo"<td id='titulo2' ><i>No hay solicitudes que mostrar</i></td>";
				echo"</tr>";
				echo"<tr height='2px'><td colspan='10'></td></tr>";
			echo"</table>";	
	}*/
	echo"</div>";
  echo"</body>";
echo"</html>";
?>

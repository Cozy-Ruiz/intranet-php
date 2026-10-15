<?php error_reporting(0); ?>
<?php
$nombrephp='D05_fichaProyecto.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
require_once("proyectoSQL.php");

$idProyecto = $_REQUEST['idProyecto'];
$sql = proyectoSQL::obtenEtapaMax($idProyecto);
$etapaSql = $INTRANETV2->GetRow($sql);
$etapaId = "";
$etapaNombre = "";
if (isset($etapa[0])) {
	$etapaId 	 = $etapaSql[0];
	$etapaNombre = $etapaSql[1];
}

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a>
			   <a href='D05_tableroProyectos.php' id='breadcrumbs'>Tablero Proyectos</a>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Detalle del Proyecto</title>
         <link type='text/css' rel='stylesheet' href='css/styleBarraProgreso.css'/>
         <link type='text/css' rel='stylesheet' href='JS/animateprogress.js'/>
		 <?php
	if($estiloUsuario == 1){
		echo "<link type='text/css' rel='stylesheet' href='../_PPM/css/styleHomePage.css'/>";
   }else if($estiloUsuario == 2){
		echo "<link type='text/css' rel='stylesheet' href='../_PPM/css/styleHomePage2.css'/>";	
   }
   //incluyo css de proyecto
   echo "<link type='text/css' rel='stylesheet' href='css/proyecto.css'/>";
	?>
    <!-- incluyo archivo javascript de proyecto -->
    <script src='JS/proyecto.js'></script>
	<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
	<!--link href="css/styleHomePage.css" rel="stylesheet" type="text/css" /-->
 
</head>  
    <body>
        <div id="wrapperSolicitudes" align="center">
			<table border="0" align="center" width="80%">
                <tr>
                    <td align="left" id="breadcrumbs">Usuario: <?php echo $usuarioId; ?></td>
                </tr>
                
                <tr height="80px"><td></td></tr>
                <?php
                $sql = proyectoSQL::obtenCodigoProyecto($idProyecto);
                $codigoP = $INTRANETV2->GetOne($sql);

				echo "
				<tr>
					<td align='center' id='titulo1'>Detalle del Proyecto</td>
				</tr>
				<tr>
					<td align='center' id='titulo1'>".$codigoP."</td>
				</tr>";
			   ?>
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
   			</table> 

 <?php	
//banana de navegacion intranet
echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
	include("../../navegacion_banana.php");
echo "</table>";
//obtengo todos los proyectos
$sql = proyectoSQL::obtenProyectoAll($idProyecto);
$proyectosArray = $INTRANETV2->GetArray($sql);
//valido usuario para autorizar proyecto
$sql = proyectoSQL::validaUsuarioAutoriza($usuarioId);
$permisoAutorizar = $INTRANETV2->GetOne($sql);
//defino una variable que va guardar todo el html de la vista de la ficha de proyecto
$html = "";
$html .= "
<div style='width:50%'>";
	//declaro un foreach para recorrer el arreglo de proyectos
	foreach ($proyectosArray as $key => $proyecto) {
		//consulto el nombre del tipo de proyecto
		$sql = proyectoSQL::obtenTipoProyecto($proyecto["xt_codigoTipo"]);
		$tipoProyecto = $INTRANETV2->GetOne($sql);
		//obtengo el nombre de la prioridad del catalogo
		$sql = proyectoSQL::obtenNombrePrioridad($proyecto["xn_prioridadId"]);
		$nombrePrioridad = $INTRANETV2->GetOne($sql);
		//si no recibo un nombre de prioridad, declaro la variable como vacio
		if (empty($nombrePrioridad)) {
			$nombrePrioridad = "";
		}
		//empiezo el despliege de la informacion del proyecto
		$html .= "
		<div id='textoTitulo'>".$tipoProyecto."
			<div id='titleBlueLineBottom' />
		</div>				

		<table class='textoContenido' id='modNombre' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
					$html .= "
					<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modNombre','inputNombreP')\" width='15px' height='15px' />";
				}

				$html .= "
				</td>
				<td>".$proyecto["xt_nombreProyecto"]."</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
			$html .= "
			<div id='inputNombreP' class='inputContenidoModificar'>
				<input type='text' value='".$proyecto["xt_nombreProyecto"]."' style='width:80%;' id='inputNombre' />
				<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xt_nombreProyecto','','inputNombre');\" width='18px' height='18px' />
			</div>";
		}
		//muestro apartado para fecha de registro
		$html .= "
		<div id='textoTitulo'>Fecha de Registro
			<div id='titleBlueLineBottom' />
		</div>
		
		<table class='textoContenido' id='modFecha' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
				$html .= "
				<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modFecha','inputFechaP')\" width='15px' height='15px' />";
				}

				$html .= "
				</td>
				<td>".$proyecto["xd_fechaRegistro"]."</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
		$html .= "
		<div id='inputFechaP' class='inputContenidoModificar'>
			<input type='datetime-local' value='".$proyecto["xd_fechaRegistro"]."' style='width:20%;' id='inputFecha' />
			<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xd_fechaRegistro','','inputFecha');\" width='18px' height='18px' />
		</div>";
		}
		//muestro apartado de prioridad
		$html .= "
		<div id='textoTitulo'>Prioridad
			<div id='titleBlueLineBottom' />
		</div>
		
		<table class='textoContenido' id='modPrioridad' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
				$html .= "
				<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modPrioridad','inputPrioridadP')\" width='15px' height='15px' />";
				}

				$html .= "
				</td>
				<td>".utf8_encode($nombrePrioridad)."</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
			$html .= "
			<div id='inputPrioridadP' class='inputContenidoModificar'>";
				//obtengo todos los registros del catalogo de prioridad
				$sql = proyectoSQL::obtenCatalogoPrioridad();
				$prioridadArray = $INTRANETV2->GetArray($sql);
				//despliego las opciones de prioridad
				$html .= "
				<select id='inputPrioridad'>";
				//recorro el arreglo y defino opciones
				foreach ($prioridadArray as $key => $prioridad) {
					$html .= "
					<option value='".$prioridad["xn_prioridad"]."'>".utf8_encode($prioridad["xt_nombrePrioridad"])."</option>";
				}

				$html .= "
				</select>

				<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xn_prioridadId','','inputPrioridad');\" width='18px' height='18px' />
			</div>";
		}

		//consulto el nombre del responsable
		$sql = proyectoSQL::obtenNombreResponsable($proyecto["xt_responsableUsuario"]);
		$nombreResponsable = $INTRANETV2->GetOne($sql);
		//muestro los datos del rresponsable
		$html .= "
		<div id='textoTitulo'>Responsable
			<div id='titleBlueLineBottom' />
		</div>
		
		<table class='textoContenido' id='modResponsable' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
					$html .= "
					<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modResponsable','inputResponsableP')\" width='15px' height='15px' />";
				}
				$html .= "
				</td>
				<td>".utf8_encode($nombreResponsable)."</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
			$html .= "
			<div id='inputResponsableP' class='inputContenidoModificar'>";
				//despliego opciones para modificar responsables
				$sql = proyectoSQL::obtenCatalogoResponsable();
				$responsableArray = $INTRANETV2->GetArray($sql);

				$html .= "
				<select id='inputResponsable'>";
				//recorro arreglo y despliego opciones
				foreach ($responsableArray as $key => $responsable) {
					$html .= "
					<option value='".$responsable["xt_usuario"]."'>".utf8_encode($responsable["xt_nombreResponsable"])."</option>";
				}

				$html .= "
				</select>
				
				<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xt_responsableUsuario','','inputResponsable');\" width='18px' height='18px' />
			</div>";
		}
		//muestro apartado de duracion estimada
		$html .= "
		<div id='textoTitulo'>Duración estimada
			<div id='titleBlueLineBottom' />
		</div>
		
		<table class='textoContenido' id='modDuracion' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
				$html .= "
				<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modDuracion','inputDuracionP')\" width='15px' height='15px' />";
				}
				$html .= "
				</td>
				<td>".$proyecto["xn_estimacionTiempo"]." Semanas</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
			$html .= "
			<div id='inputDuracionP' class='inputContenidoModificar'>
				<input type='number' value='".$proyecto["xn_estimacionTiempo"]."' style='width:10%;' id='inputDuracion' /> Semanas
				<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xn_estimacionTiempo','','inputDuracion');\" width='18px' height='18px' />
			</div>";
		}

		//despliego apartado de estimacion de costo
		$html .= "
		<div id='textoTitulo'>Costo
			<div id='titleBlueLineBottom' />
		</div>
		
		<table class='textoContenido' id='modCosto' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
				$html .= "
				<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modCosto','inputCostoP')\" width='15px' height='15px' />";
				}
				$html .= "
				</td>
				<td>".$proyecto["xt_estimacionCosto"]."</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
			$html .= "
			<div id='inputCostoP' class='inputContenidoModificar'>
				<input type='text' value='".$proyecto["xt_estimacionCosto"]."' style='width:10%;' id='inputCosto' />
				<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xt_estimacionCosto','','inputCosto');\" width='18px' height='18px' />
			</div>";
		}

		//despliego apartado de propósito
		$html .= "
		<div id='textoTitulo'>Propósito
			<div id='titleBlueLineBottom' />
		</div>
		
		<table class='textoContenido' id='modProposito' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
					$html .= "
					<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modProposito','inputPropositoP')\" width='15px' height='15px' />";
				}
				$html .= "
				</td>
				<td>".$proyecto["xt_proposito"]."</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
			$html .= "
			<div id='inputPropositoP' class='inputContenidoModificar'>
				<textarea style='width:80%; height:20%;' id='inputProposito'>".$proyecto["xt_proposito"]."</textarea>
				<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xt_proposito','','inputProposito');\" width='18px' height='18px' />
			</div>";
		}
		//despliego apartado de descripcion
		$html .= "
		<div id='textoTitulo'>Descripción
			<div id='titleBlueLineBottom' />
		</div>
		
		<table class='textoContenido' id='modDescripcion' style='display:block;'>
			<tr>
				<td>";
				//valido que el estatus del proyecto sea diferente de terminado
				if ($etapaId != 5) {
					$html .= "
					<img src='../../Imagenes/ICN_Settings.png' onClick=\"muestra_ocultaDiv('modDescripcion','inputDescripcionP')\" width='15px' height='15px' />";
				}
				$html .= "
				</td>
				<td>".$proyecto["xt_descripcion"]."</td>
			</tr>
		</table>";
		//valido que el estatus del proyecto sea diferente de terminado
		if ($etapaId != 5) {
			$html .= "
			<div id='inputDescripcionP' class='inputContenidoModificar'>
				<textarea style='width:80%; height:20%;' id='inputDescripcion'>".$proyecto["xt_descripcion"]."</textarea>
				<img src='../../Imagenes/cheek.PNG' onclick=\"actualizaCampoProyecto('".$idProyecto."','xt_descripcion','','inputDescripcion');\" width='18px' height='18px' />
			</div>";
		}
		//si aun no se ha aprobado para autorizar el proyecto muestro boton enviar sino despliego datos de quien autorizò
		if ($proyecto["xn_apruebaAutorizar"] == 0) {
			
			$html .= "
			<div id='textoTitulo'>Enviar a autorizar
				<div id='titleBlueLineBottom' />
			</div>

			<table border='0' align='center' width='50%'>
				<tr height='15px'><td></td></tr>
				<tr>
					<td style='width: 250px'></td>
					<td style='width:20%; cursor:pointer;' align='center' bgcolor='#42CB27'><font color='black' onclick=\"actualizaCampoProyecto('".$idProyecto."','xn_apruebaAutorizar','1');\">Enviar</font></td>
					<td style='width: 250px'></td>
				</tr>
				<tr height='20px'></tr>
			</table>";

		}elseif($proyecto["xn_apruebaAutorizar"] == 1){

			//si ya tiene registrado un usuario que autorizò se muestran los datos
			if($proyecto["xt_autorizaUsuario"] != ''){
				//obtengo el nombre de la persona que autorizò
				$sql = proyectoSQL::obtenNombreAutoriza($proyecto["xt_autorizaUsuario"]);
				$nombreAutoriza = $INTRANETV2->GetOne($sql);
				//despliego informacion de autorizacion
				$html .= "
				<div id='textoTitulo'>Autoriza
					<div id='titleBlueLineBottom' />
				</div>

				<table border='0' align='center' width='50%'>
					<tr height='15px'><td></td></tr>
					<tr>
						<td style='width: 250px'></td>
						<td id='tdProcede' style='width: 20%' align='center' bgcolor='#42CB27'><font color='black'>Procede</font></td>
						<td style='width: 250px'></td>
					</tr>
					<tr height='20px'></tr>
					<tr>
						<td id='iconosTexto' colspan='3'><center>".utf8_encode($nombreAutoriza)." aprobó el proyecto</center></td>
					</tr>
					<tr height='10px'></tr>
					<tr>
						<td id='iconosTexto' colspan='3'><center>".$proyecto["xd_fechaResolucion"]."</center></td>
					</tr>
				</table>";
				//se valida que el proyecto se encuentre en un estatus diferente a terminado
				if ($etapaId != 5 && $usuarioId == $proyecto["xt_responsableUsuario"]) {
					//si el usuario logueado actualmente se encuentra en el catalogo de responsables se muestra el apartado de cierre de proyecto
					$html .= "
					<div id='textoTitulo'>Cierre del proyecto
						<div id='titleBlueLineBottom' />
					</div>

					<table border='0' align='center' width='50%'>
						<tr height='15px'><td></td></tr>
						<tr>
							<td style='width: 250px'></td>
							<td style='width:20%; cursor:pointer;' align='center' bgcolor='#42CB27'><font color='black' onclick=\"cerrarProyecto('".$idProyecto."','".$usuarioId."');\">Finalizar</font></td>
							<td style='width: 250px'></td>
						</tr>
						<tr height='20px'></tr>
					</table>";
				}elseif($etapaId == 5){
					//cuando el proyecto está en estatus terminado se muestran los datos del usuario y fecha en que se cerró
					$html .= "
					<table border='0' align='center' width='50%'>
						<tr height='15px'><td></td></tr>
						<tr>
							<td style='width: 250px'></td>
							<td style='width:20%;' align='center' bgcolor='#42CB27'><font color='black'>".$etapaNombre."</font></td>
							<td style='width: 250px'></td>
						</tr>
						<tr height='20px'></tr>
						<tr>
							<td id='iconosTexto' colspan='3'><center>".utf8_encode($etapa[3])." cerró este proyecto</center></td>
						</tr>
						<tr height='10px'></tr>
						<tr>
							<td id='iconosTexto' colspan='3'><center>".$etapa[2]."</center></td>
						</tr>
					</table>";	
				}

			}elseif($permisoAutorizar == 1){
				//se valida el permiso que tiene el usuario para validar un proyecto, si el usuario esta en el catalogo de autorizar se muestra la opcion
				$html .= "
				<div id='textoTitulo'>Autoriza proyecto
					<div id='titleBlueLineBottom' />
				</div>

				<table border='0' align='center' width='50%'>
					<tr height='15px'><td></td></tr>
					<tr height='25px'>
						<td style='width: 250px'></td>
						<td id='tdProcede' style='width:40%; cursor:pointer;' onclick=\"actualizaCampoProyecto('".$idProyecto."','xt_autorizaUsuario','".$usuarioId."','');\"  align='center' bgcolor='#42CB27'><font color='black'>Autorizar proyecto</font></td>
						<td style='width: 250px'></td>
					</tr>
				</table>";
			}
		}
		//muestro las diferentes secciones por las que se puede navegar
		$html .= "
		<div id='textoTitulo'>Secciones
			<div id='titleBlueLineBottom' />
		</div>
		<div id='textoContenido'>
			<a id='iconosTexto' href='D05_Documento_Proyecto.php?idProyecto=".$idProyecto."'>
				<strong>Documentos</strong>
			</a>
		</div>

		<div id='textoContenido'>
			<a id='iconosTexto' href='D05_Evaluacion_proyecto.php?idProyecto=".$idProyecto."'>
				<strong>Evaluaciones</strong>
			</a>
		</div>

		<div id='textoContenido'>
			<a id='iconosTexto' href='tableroAvanceWBS.php?codigoP=".$codigoP."&idProyecto=".$idProyecto."'>
				<strong>Avances</strong>
			</a>
		</div>

		<div id='textoContenido'>
			<a id='iconosTexto' href='tableroReunionesPY.php?idProyecto=".$idProyecto."''>
				<strong>Reuniones</strong>
			</a>
		</div>
		";
	}

$html .= "
</div>

<table border='0' width='100%'>
	<tr height='30px'><td></td></tr>	
	<tr>
		<td id='titleBlueLineBottom'></td>
	</tr>
	<tr>
		<td style='color:#007cbd;text-align:center;font-family:Arial'>Created by: Grupo Escalante Agencias Aduanales.</td>
	</tr>
	<tr height='100px'><td></td></tr>
</table>";
//imprimo todo el contenido html guardado en nuestra variable html
echo $html;
?>
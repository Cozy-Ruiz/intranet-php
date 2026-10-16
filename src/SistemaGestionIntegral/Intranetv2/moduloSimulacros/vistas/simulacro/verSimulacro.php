<?php
$simulacro = $_POST['simulacro'];
$nombreModulo='Simulacro';
require_once("../../../../../ConexionDBT.php");
require_once("../../../../../compruebaUsuario.php");
require_once("../../conexionIntranet.php");
require_once("../../jsBanana.js");
require_once("../../archivos/js/scriptWindow.js");
require_once("../../consultas/consultasCiudades.php");
require_once("../../consultas/registrosGeneral.php");
//require_once("../../consultas/consultasEvidencias.php");
require_once("../../consultas/consultasUsuarios.php");
require_once("headerSimulacro.php");

/*
require_once("../../../../../ConexionDBT.php");
//require_once("../../../../../compruebaUsuario.php");
require_once("../../conexionIntranet.php");
require_once("../../jsBanana.js");
require_once("../../archivos/js/scriptWindow.js");
require_once("../../consultas/consultasCiudades.php");
require_once("../../consultas/registrosGeneral.php");
//require_once("../../consultas/consultasEvidencias.php");
require_once("../../consultas/consultasUsuarios.php");
require_once("headerSimulacro.php");
*/

$verifica = 1; 
$_SESSION["verifica"] = $verifica; 
if ($verifica == 1)  
{  
	$usuariosAdmin = $con_usuario->getUsuariosAdmin();
?>

<title>Ver simulacro</title>

<form action="../simulacro/popups.php" method="post" target="popup" onsubmit="openWin()">
	 <input type="hidden" name="simulacro" value="<?php echo $simulacro ?>" />
	 <input type="hidden" name="ciudad" value="<?php $c->imprimirCiudad($usuarioId); ?>" />
<table border='0' align='center' width='50%'>
	<div id="generalDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='3'><b> 1. Generales </b></td>
			<td align='right' colspan='5' id='iconosTexto2' style='width:30%'>						
				<?php $general->statusSimulacro($simulacro); ?>
			</td>		
		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><tr style="height: 20px"></tr>
			<td style='width:10%;'></td><td id='iconosTexto2' width="10%" align="left">Titulo: </td>
			<td colspan="3" id='fileItem'><?php $general->nombreSimulacro($simulacro); ?></td><td></td>

			<?php 
			$ciudadU = $c->imprimirCiudad($usuarioId);
			$ciudadS = $general->ciudadSimulacro($simulacro);
			if(in_array($usuarioId, $usuariosAdmin) && ($ciudadU == $ciudadS)) { ?>
			<td rowspan="3" align="center"><input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="modificarGenerales" value="Modificar"></td>
			<?php } ?>

		</tr>
		<tr style="height: 15px"><td colspan="7"></td></tr>
		<tr style="width: 50px">
			<td></td><td id='iconosTexto2' width="10%" rowspan="2" align="left">Descripcion: </td>
			<td rowspan="2" style="width:50px; word-wrap: break-word;" colspan="3" id='fileItem'><?php echo nl2br($general->descripcionSimulacro($simulacro)); ?></td>
			
		</tr>
		<!--pongo agente y patente relacionado -->

		<tr style="height: 15px"><td colspan="7"></td></tr>
		<tr style="width: 50px">
			<td></td><td id='iconosTexto2' width="15%" rowspan="2" align="left">Agente Aduanal: </td>
			<td rowspan="2" style="width:50px; word-wrap: break-word;" colspan="3" id='fileItem'><?php echo nl2br($general->agenteSimulacro($simulacro)); ?></td>
			
		</tr>

		<tr height='20px'><td align="center"></td><td></td></tr>
	</div>

	<div id="riesgosDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='6'><b> 2. Riesgos a tratar</b></td>

			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align='right' width='15px' style='padding:0px 0px 0px 20px'>
				<button type="submit" name="riesgos" style="cursor: pointer; background-color: transparent; border: 0;"><img style="width: 15; height: 15;" src="../../../../../Imagenes/ICN_BotonMas.png" alt="Agregar" /></button>
			</td> <?php } ?>

		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr height='20px'><td colspan='7' id='fileItem'></td></tr>
			<?php $general->codigoRiesgo($simulacro); //mostrar los datos de los riesgos?>	
	</div>

	<div id="tipoDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr><td id='titulo2' colspan='6'><b>3. Tipo de simulacro</b></td></tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr style="width: 50px">
			<tr style="height: 20px"></tr>
			<td></td><td style="width:50px; word-wrap: break-word;" colspan="5" id='fileItem'>  <div id="div-tipo"><?php $general->tipoSimulacro($simulacro); ?></div>  </td>

			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align="center"><input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="modificarTipo" value="Modificar"></td>
			<?php } ?>

		</tr>
	</div>

	<div id="pdrDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='7'><b>4. PDR (Persona Directamente Responsable)</b></td>	
		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr style="width: 50px">
			<tr style="height: 20px"></tr>
			<td></td><td style="width:50px; word-wrap: break-word;" colspan="5" id='fileItem'><?php $general->pdrSimulacro($simulacro); ?></td>

			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align="center"><input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="modificarPdr" value="Modificar"></td>
			<?php } ?>	

		</tr>
	</div>

	<div id="fechasDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr><td id='titulo2' colspan='7'><b>5. Fechas</b></td></tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr><tr></tr>
		<tr style="width: 50px">
			<tr style="height: 20px"></tr>
			<td></td><td id='iconosTexto2' width="10%" align="left">Programado: </td><td style="width:50px; word-wrap: break-word;" colspan="4" id='fileItem'><?php $general->fechaPSimulacro($simulacro); ?></td>

			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td rowspan="7" align="center"><input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="modificarFechas" value="Modificar" /></td>
			<?php } ?>

		<tr style="width: 50px">
			<tr></tr>
			<td></td><td id='iconosTexto2' width="10%" align="left">Inicio: </td><td colspan="4" id='fileItem'><?php $general->fechaISimulacro($simulacro); ?></td>
		<tr style="width: 50px">
			<tr></tr>
			<td></td><td id='iconosTexto2' width="10%" align="left">Finalizado: </td><td style="width:50px; word-wrap: break-word;" colspan="4" id='fileItem'><?php $general->fechaFSimulacro($simulacro); ?></td>
		</tr>
	</div> 

	<div id="alcanceDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='7'><b>6. Alcance</b></td>	
		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><tr style="height: 20px"></tr>
			<td style='width:10%;'></td><td colspan="5" style="word-wrap: break-word;" id='fileItem'><?php echo nl2br($general->alcanceSimulacro($simulacro)); ?></td>
			
			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align="center"><input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="modificarAlcance" value="Modificar" /></td> <?php } ?>

		</tr>
	</div>

	<div id="participantesDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='6'><b>7. Participantes</b></td>

			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align='right' width='15px' style='padding:0px 0px 0px 20px'>
				<button type="submit" name="participantes" style="cursor: pointer; background-color: transparent; border: 0;"><img style="width: 15; height: 15;" src="../../../../../Imagenes/ICN_BotonMas.png" alt="Agregar" /></button>
			</td><?php } ?>

		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr height='20px'><td colspan='7'></td></tr>
			<?php $general->participantes_Simulacro($simulacro); ?>	
		<tr><td></td></tr>
	</div>

	<div id="avisosDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='6'><b>8. Avisos</b></td>

			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align='right' width='15px' style='padding:0px 0px 0px 20px'>
				<button type="submit" name="aviso" style="cursor: pointer; background-color: transparent; border: 0;"><img style="width: 15; height: 15;" src="../../../../../Imagenes/ICN_BotonMas.png" alt="Agregar" /></button>
			</td><?php } ?>

		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr style="height: 20px"></tr>
		<tr>
			<?php $general->avisos_Simulacro($simulacro); ?>	
		</tr>
	</div> 

    

		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='6'><b>9. Desarrollo</b></td><td align='right' width='15px' style='padding:0px 0px 0px 20px'>
				
				<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
				<button type="submit" name="desarrollo" style="cursor: pointer; background-color: transparent; border: 0;"><img style="width: 15; height: 15;" src="../../../../../Imagenes/ICN_BotonMas.png" alt="Agregar" /></button>
				<?php } ?>

		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><tr style="height: 20px"></tr>

	<div id="desarrolloDiv">
			<?php $general->desarrolloSimulacro($simulacro); ?>
	</div>

    
    
	<div>
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='6'><b>10. Evidencias</b></td><td align='right' width='15px' style='padding:0px 0px 0px 20px'>

				<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
				<button type="submit" name="evidencia" style="cursor: pointer; background-color: transparent; border: 0;"><img style="width: 15; height: 15;" src="../../../../../Imagenes/ICN_BotonMas.png" alt="Agregar" /></button> <?php } ?>

			</td>
		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><td style='width:10%;'></td>
				<td colspan="6" style="word-wrap: break-word;" id='fileItem'>
			<div style="position: relative; width: 100%; overflow: hidden;"  id="evidenciasDiv"><?php include("../galeriaEvidencias/index.php"); ?>
			</div>
			</td>
		</tr>
	</div>

    <tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='6'><b>11. Lista de asistencia</b></td><td align='right' width='15px' style='padding:0px 0px 0px 20px'>
				
				<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
				<button type="submit" name="asistencia" style="cursor: pointer; background-color: transparent; border: 0;"><img style="width: 15; height: 15;" src="../../../../../Imagenes/ICN_BotonMas.png" alt="Agregar" /></button>
				<?php } ?>

		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><tr style="height: 20px"></tr>

	<div id="asistenciaDiv">
			<?php $general->asistenciaSimulacro($simulacro); ?>
	</div>
	

	<div id="recursosDiv">
		<tr style="height: 20px"></tr><td></td><td colspan="7"></td>

		<tr height='10px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='7'><b>12. Recursos utilizados</b></td>	
		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><tr style="height: 20px"></tr>
			<td style='width:10%;'></td><td colspan="5" style="word-wrap: break-word;" id='fileItem'><?php echo nl2br($general->recursos_Simulacro($simulacro)); ?></td>
			
			<?php if(in_array($usuarioId, $usuariosAdmin)  && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align="center"><input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="modificarRecursos" value="Modificar"></td>
			<?php } ?>

		</tr>
	</div>

	<div id="resultadosDiv">
		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='7'><b>13. Resultados</b></td>	
		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><tr style="height: 20px"></tr>
			<td style='width:10%;'></td><td colspan="5" style="word-wrap: break-word;" id='fileItem'><?php echo nl2br($general->resultados_Simulacro($simulacro));  ?></td>
			
			<?php if(in_array($usuarioId, $usuariosAdmin) && ($ciudadU == $ciudadS OR $ciudadU == "CMX")) { ?>
			<td align="center"><input style="cursor: pointer; background-color: transparent; border: 0;" id='breadcrumbs' type="submit" name="modificarResultados" value="Modificar"></td><?php } ?>

		</tr>
	</div>

		<tr height='50px'><td colspan='7'></td></tr>
		<tr>
			<td id='titulo2' colspan='7'><b>14. Evaluación</b></td>	
		</tr>
		<tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
		<tr><tr style="height: 20px"></tr>

	<div id="evaluacionDiv">
			<td style='width:10%;'></td><td colspan="5" style="word-wrap: break-word;" id='fileItem'><?php $general->evaluacionSimulacro($simulacro, $usuarioId, $usuariosAdmin); ?></td>		
		</tr>
		<tr><td colspan="7" width="100%" id='titleBlueLineBottom'></td></tr>
	</div>
		</table>
</form>

</body>
<?php
unset($_SESSION['verifica']); 
}  
else {  
// Si no viene del formulario o trata de recargar pagina los enviamos al formulario 
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=form.php'>"; 
}  ?>

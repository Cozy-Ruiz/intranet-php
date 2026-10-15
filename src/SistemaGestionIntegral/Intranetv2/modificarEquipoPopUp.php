<script type="text/javascript">
function actualizarFichaAud(){
	location.reload(true)
}
function nuevoAud() { 
	var nombre = document.getElementById("nombre").value;
	var usuario = document.getElementById("usuario").value; 
	var ciudad = document.getElementById("seleccion").value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			if(xhttp.responseText == true){
				actualizarFichaAud();
			}else{
				alert("Ocurrio un error");
			}
		}
	};
	xhttp.open("POST", "agregaCampoTipo.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("nombre="+nombre+"&usuario="+usuario+"&ciudad="+ciudad+"&accion=agregarAuditor");
 	//xhttp.send("simulacro="+simulacro+"&codigo="+codigotratamiento+"&tipo="+tipotratamiento);
}

function showNuevoAud()
{
	
	document.getElementById("nuevoM").style.display="block";
		document.getElementById("wrapperPopUp").style.display="none"; 
}

function hideNuevoAud()
{
	
	document.getElementById("wrapperPopUp").style.display="block";
	document.getElementById("nuevoM").style.display="none"; 
}

</script>
<?php
$nombrephp='AgregarElementoProcesoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);
//obtengo parametros
$clave = $_GET['clave'];
$ciudad = $_GET['ciudad'];
if($_POST['modifica'] == 1){
	$modifica = 1;
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
  <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
            <script type="text/javascript" src="js/comportamientoSimulacro.js"></script>   
<title>Modificar Equipo Auditor de la Auditoría</title>
 <?php
	if($estiloUsuario == 1){
    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>
<script type="text/javascript">
	function recargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>
</head>
<body>

<?php
//INTERFACES DE CAPTURA DE DATOS

if($modifica == 0) {
?>
	<div id='wrapperPopUp'>
		<form name='fichaEquipo' method='POST' action='modificarEquipoPopUp.php?clave=<?php echo $clave; ?>'>	
			<table border='0' align='center' width='500'>
				<tr>
					<td align='center' class='titulo1' width='500'>Seleccionar equipo auditor</td>
				</tr>
				<tr height='50'> </tr>
			</table>
			
			<table border='0' align='center' width='500'>
				<tr>  
					<td valign='bottom' align='right' colspan='2'>
						<a style='cursor:pointer; valign:top; align:right;' onClick='showNuevoAud()'><font color='#007cbd'>&nbsp; Nuevo</font></a> 
					</td>

				 </tr>

				<tr>
					<td colspan='2' id='titleBlueLineTop' width='500'></td>
				</tr>
				
				<tr height='15'></tr>		
				<?php
				$indice = 0;
				$conjuntoRegistrosAuditores = $INTRANETV2->Execute("
						SELECT 
							SCA.xt_claveAuditor, 
							SCA.xt_nombreAuditor,
							COALESCE
							((
								SELECT
									 SAA.xt_claveAuditor
								FROM
									SGI_Auditorias_Equipos SAA
								WHERE
									SAA.xt_claveAuditoria = '$clave'
								AND
									SCA.xt_claveAuditor = SAA.xt_claveAuditor
							),999) clave ,xt_ciudad
						FROM 
							SGI_Catalogo_Auditores SCA
						WHERE
							xt_ciudad = '$ciudad'  or 	xt_ciudad = 'EXT' 
						GROUP BY SCA.xt_nombreAuditor ORDER BY clave, xt_claveAuditor
					");
				while($registrosAuditores = $conjuntoRegistrosAuditores->fetchRow()){
					$codigoAuditor[$indice] = $registrosAuditores[0];
					$nombreAuditor[$indice] = utf8_encode($registrosAuditores[1]);
					$codigoAuditorActivado[$indice] = $registrosAuditores[2];
					$indice++;
				}
				for ($i=0;$i<count($codigoAuditor);$i++){
				?>
					<tr>
						<td align='left' width='30px'> </td>
						<td><?php echo $nombreAuditor[$i] ?></td>
						<?php
						if($codigoAuditorActivado[$i]<999){
						?>
							<td>
								<input type='checkbox' checked='true' class='LoginInicio' name='auditores[]' value='<?php echo $codigoAuditor[$i].",".$nombreAuditor[$i]; ?>'/>
							</td>
						<?php					
						}else{
						?>
							<td>
								<input type='checkbox' class='LoginInicio' name='auditores[]' value='<?php echo $codigoAuditor[$i].",".$nombreAuditor[$i]; ?>'/>
							</td>
						<?php
						}
						?>
					</tr>
					<tr height='10px'><td colspan='2'></td></tr>
				<?php
				}
				?>	


				<tr height='20px'><td colspan='2'></td></tr>
				<tr>
					<td id='titleBlueLineTop' colspan='2'></td>
				</tr>
				

			</table>

			


			<table border='0' align='center' width='450'>				
				<tr height='40'>
					<td valign='bottom' align='right'>
						<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
						<input type='hidden' value='1' name='modifica'>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id='nuevoM' style="display: none;">

		 <table border='0' align='center' width='500'>
		 		<tr>
					<td colspan='2' align='center' class='titulo1' width='500'>Nuevo auditor</td>
				</tr>
				<tr>
					<td colspan='2' id='titleBlueLineTop' width='500'></td>
				</tr>

				<tr> <td align='left'>
				 Nombre
				 </td>
				 <td align='left'>
				Usuario
				 </td></tr>
				<tr> <td align='left'>
				 <input type='text' id='nombre' size=20 maxlength=100 name='nombre'>
				 </td>
				 <td align='left'>
					 <input type='text' id='usuario' size=20 maxlength=100 name='usuario'>
				 </td></tr>
				<tr><td>Ciudad</td></tr>
				 <tr>
				 	<td align='left'>
				 <select id='seleccion' name='ciudad'>
						<option value='EXT' selected=''>Externo</option>				
						<option value='CMX'>CDMX</option>
						<option value='CUN'>CANCÚN</option>
						<option value='NLR'>N. LAREDO</option>
						<option value='VER'>VERACRUZ</option>
				</select>
				</td>
			</tr> 
			<tr height='40'>
				<td valign='bottom' align='left'>
						<a style='cursor:pointer; valign:top; align:left;' onClick='hideNuevoAud()'><font color='#007cbd'>&nbsp; Regresar</font></a> 
					</td>
					<td valign='bottom'  align='right'>
						<input type='image' onclick='nuevoAud();' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
						<input type='hidden' value='1' name='modifica'>
					</td>
				</tr>
			<tr>
					<td colspan='2' id='titleBlueLineTop' width='500'></td>
				</tr>
		</table>
	</div>
	<?php


	
	
//MODIFICACIONES ******************************************************************************************************************
}else if($modifica == 1){
	$auditores = $_POST['auditores'];
	$clave = $_GET['clave'];

	$index = 0;
	$conjuntoRegistroAuditores = $INTRANETV2->Execute("
		SELECT
			xt_claveAuditor, xt_nombreAuditor, xt_usuario
		FROM
			SGI_Catalogo_Auditores
		");
	while($registroAuditor = $conjuntoRegistroAuditores->fetchRow()){
		$claveAuditor[$index] = $registroAuditor[0];
		$nombreAuditor[$index] = $registroAuditor[1];
		$usuarioAuditor[$index] = $registroAuditor[2];
		$index++;
	}
	for ($i=0;$i<count($auditores);$i++){
		$auditoresActivos = explode(',',$auditores[$i]);
		$claveAuditorActivo[$i] = $auditoresActivos[0];
		$nombreAuditor[$i] = $auditoresActivos[1];	
	}
	for ($i=0;$i<count($claveAuditor);$i++){
		if(in_array($claveAuditor[$i], $claveAuditorActivo)){
			$INTRANETV2->Execute("INSERT INTO SGI_Auditorias_Equipos (xt_claveAuditoria, xt_claveAuditor, xt_nombreAuditor, xt_usuario) VALUES ('$clave', '$claveAuditor[$i]', '$nombreAuditor[$i]', '$usuarioAuditor[$i]')");
		} else {
			$INTRANETV2->Execute("DELETE FROM SGI_Auditorias_Equipos where xt_claveAuditor = '$claveAuditor[$i]' AND xt_claveAuditoria = '$clave'");
		}
	}	
	echo "
		<script type='text/javascript'>
			recargarPadre();
		</script>
	";
}// FIN DEL BLOQUE DE MODIFICACIONES
?>
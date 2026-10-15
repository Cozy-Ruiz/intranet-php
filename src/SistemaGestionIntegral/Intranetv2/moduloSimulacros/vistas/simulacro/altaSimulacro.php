<?php 
$nombreModulo = "Alta Simulacro";
$simulacro = '';
require_once("../../../../../ConexionDBT.php");
require_once("../../../../../compruebaUsuario.php");
require_once("../../conexionIntranet.php");
require_once("../../consultas/consultasCiudades.php");
require_once("../../consultas/consultaSimulacros.php");
require_once("headerSimple.php");
?>   

    <title>Alta simulacro</title>

<body>

	<?php $t = $simulacro->getTipos();
	$g = $simulacro->getGrupos();
	$año_actual = date('Y');
?>

	<table align="center" border="0" width="35%">
		<form action="altaSimulacro.php" method="POST">
		<tr style="height: 10"></tr>
		<tr><td id='titleBlueLineBottom' colspan='2'></td></tr>
		<tr style="height: 20"></tr>
		<tr><td align="center" id="titulo2">Grupo:</td><td align="center" id="titulo2">Fecha programada:</td></tr>
		<tr><td align="center"><select name="grupo">
			<option value="" >Seleccionar un grupo...</option>
			<?php while ($grupos = $g->fetchRow()) {
				$codigoGrupo = $grupos[0];
				$nombreGrupo = $grupos[1];
			?><option value="<?php echo $codigoGrupo ?>" > <?php echo $nombreGrupo ?></option>
			<?php }//fin de whilw tipos ?>

		</select>	
		</td><td align="center"><input type="date" name="fecha_prog" min="<?php echo $año_actual ?>-01-01" max="<?php echo $año_actual ?>-12-31"></td></tr>
		<tr style="height: 20"><td colspan="2"></td></tr>
		<tr><td id="titulo2" align="center">Ciudad:</td><td id="titulo2" align="center">Hora Programada:</td></tr>
		<tr><td align="center"><select name="ciudad">
							<option value="">Elegir ciudad del simulacro...</option>";
							<?php echo $c->opcionesCiudades(); ?>
							</select></td><td align="center"><input type="time" name="hora_prog" min="09:00" max="21:00"></td></tr>
		<tr style="height: 20"><td colspan="2"></td></tr>
		<tr><td id="titulo2" align="center">Nombre del simulacro:</td><td align="center" id="titulo2">Tipo:</td></tr>
		<tr><td align="center"><input type="text" name="nombre_simulacro" size="30%"></td><td align="center"><select name="tipo">
			<option value="" >Seleccionar un tipo...</option>
			<?php while ($tipos = $t->fetchRow()) {
				$tipo = $tipos[0];
			?><option value="<?php echo $tipo ?>" > <?php echo $tipo ?></option>
			<?php }//fin de whilw tipos ?>

		</select>	
		</td></tr>
		<tr style="height: 20"><td colspan="2"></td></tr>
		<tr><td colspan="2" id="titulo2" align="center">Descripcion:</td></tr>
		<tr><td align="center" colspan="2"><textarea rows="4" cols="70%" name="descripcion_simulacro"></textarea> </td></tr>
		<tr style="height: 20"><td colspan="2"></td></tr>
		<tr><td align='center' height="50px" colspan="2">
            <input type='image' src='../../../../../Imagenes/ICN_BotonEnviar.png' width='80px' height='30'></td>
		<tr><td id='titleBlueLineBottom' colspan='2'></td></tr>
        </tr>
		</form>
	</table>
</body>
<?php 
 if (isset($_POST['tipo'])) {
 	$vTipo = $_POST['tipo'];
 }else{
 	$vTipo = ' ';
 }
 if (isset($_POST['grupo'])) {
 	$vGrupo = $_POST['grupo'];
 }else{
 	$vGrupo = ' ';
 }
 if (isset($_POST['fecha_prog'])) {
 	$vFecha_prog = $_POST['fecha_prog'].' '.$_POST['hora_prog'];
 }else{
 	$vFecha_prog = ' ';
 }
 if (isset($_POST['ciudad'])) {
 	$vCiudad = $_POST['ciudad'];
 }else{
 	$vCiudad = ' ';
 }
 if (isset($_POST['descripcion_simulacro'])) {
 	$vDescripcion = $_POST['descripcion_simulacro'];
 }else{
 	$vDescripcion = ' ';
 }
 if (isset($_POST['nombre_simulacro'])) {
 	$vNombre = $_POST['nombre_simulacro'];
 	$simulacro->agregarSimulacro($vGrupo, $vTipo, $vFecha_prog, $vCiudad, $vNombre, $vDescripcion);
 	?><script>
    location.href = "../../principalSimulacros.php";
	</script><?php
 }
 ?>
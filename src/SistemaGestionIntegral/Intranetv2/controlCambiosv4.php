<?php

$nombrephp = 'ControlCambios.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);

$modifica = 0;

if($_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}
//echo "$modifica<br>";

if(($modifica == 0) || ($_POST['descripcion'] == "") ){
	$proceso 	   = $_GET['proceso'];
	$funcionalidad = $_GET['funcionalidad'];
	$rol		   = $_GET['rol'];
	$actividad	   = $_GET['actividad'];
	$casoUso 	   = $_GET['casoUso'];
	$nuevoCasoUso  = $_GET['nuevoCasoUso'];
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Control de Cambios</title>
                 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            </head>
            <body>
    <?php
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='controlCambiosv4.php?proceso=$proceso&funcionalidad=$funcionalidad&rol=$rol&actividad=$actividad'";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Control de Cambios</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr>"; 
				echo"<td align='center'>";
					//echo "<font>$breadcrumb</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
		//TITULO ITEM
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Descripción</td>";
			echo "</tr>";
		//INPUT TITULO
			echo"<tr align='left'>";
				echo "<td  align='left' width='450px'>";
					echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
					echo "<input type='hidden' value='$proceso' name='proceso'><input type='hidden' value='1' name='modifica'>";
					echo "<input type='hidden' value='$funcionalidad' name='funcionalidad'>";
					echo "<input type='hidden' value='$casoUso' name='casoUso'>";
					echo "<input type='hidden' value='$nuevoCasoUso' name='nuevoCasoUso'>";
					echo "<input type='hidden' value='$actividad' name='actividad'>";
					echo "<input type='hidden' value='$rol' name='rol'>";
				echo"</td>";
			echo "</tr>";
			echo"<tr height='10'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' width='450px'></td>";
			echo "</tr>";
			
			echo "<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
		
} else if(($modifica == 1) && ($_POST['descripcion'] != "")){
	
	$proceso       = $_POST['proceso'];
	$funcionalidad = $_POST['funcionalidad'];
	$rol		   = $_POST['rol'];
	$actividad	   = $_POST['actividad'];
	$descripcion   = $_POST['descripcion'];
	$casoUso 	   = $_POST['casoUso'];
	$nuevoCasoUso  = $_POST['nuevoCasoUso'];
	
	$maximo = 0;
	$maximo = $INTRANETV2->getOne("select COUNT(xn_version) from INTRANET2.SGI_Control_Cambios_Procesos where xt_codigoProceso = '$proceso'");
	$maximo = $maximo + 1;
	
	$maximoF = 0;
	$maximoF = $INTRANETV2->getOne("select COUNT(xn_version) from INTRANET2.SGI_Control_Cambios_Funcionalidades where xt_codigoFuncionalidad = '$funcionalidad'");
	$maximoF = $maximoF + 1;

	if ( ($funcionalidad == '') && ($rol == '') && ($actividad== '') ){
		$INTRANETV2->Execute("
			INSERT INTO INTRANET2.SGI_Control_Cambios_Procesos (
				xt_codigoProceso,
				xt_descripcion,
				xt_inicialesUsuario,
				xn_version
			)
			VALUES
				(
					'$proceso',
					'$descripcion',
					'$usuarioId',
					$maximo
				)
			");
			?>
			<script type="text/javascript">
				window.location="http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProcesov2.php?proceso=<?php echo $proceso; ?>";
			</script>
		<?php
	} else if ($casoUso != '') {
		$maximoC = 0;
		$maximoC = $INTRANETV2->getOne("
			SELECT
				COUNT(xn_version)
			FROM
				INTRANET2.SGI_Control_Cambios_Casos_Uso
			WHERE
				xt_codigo_casos_uso = '$casoUso'
			");
		$maximoC = $maximoC + 1;
		$INTRANETV2->Execute("
		INSERT INTO INTRANET2.SGI_Control_Cambios_Casos_Uso (
			xt_codigo_casos_uso,
			xt_descripcion,
			xt_inicialesUsuario,
			xn_version
		)
		VALUES
			(
				'$casoUso',
				'$descripcion',
				'$usuarioId',
				$maximoC
			)
		");
		
		?>
		<script type="text/javascript">
			window.location="http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaCasoUsov3.php?proceso=<?php echo $proceso; ?>&funcionalidad=<?php echo $funcionalidad; ?>&rol=<?php echo $rol; ?>&casoUso=<?php echo $casoUso; ?>&actividad=<?php echo $actividad ?>";
		</script>
		<?php
	} else {
		$INTRANETV2->Execute("
			INSERT INTO INTRANET2.SGI_Control_Cambios_Funcionalidades (
				xt_codigoFuncionalidad,
				xt_descripcion,
				xt_inicialesUsuario,
				xn_version
			)
			VALUES
				(
					'$funcionalidad',
					'$descripcion',
					'$usuarioId',
					$maximoF
				)
			");
			?>
			<script type="text/javascript">
				window.location="http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaFuncionalidadCasoUsov3.php?proceso=<?php echo $proceso; ?>&funcionalidad=<?php echo $funcionalidad; ?>&rol=<?php echo $rol; ?>&actividad=<?php echo $actividad ?>";
			</script>
			<?php
	}
	?>

	<?php
}
	

?>
</body>
</html>
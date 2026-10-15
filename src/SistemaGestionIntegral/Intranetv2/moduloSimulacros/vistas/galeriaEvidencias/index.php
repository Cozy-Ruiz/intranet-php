<?php
require_once("../../conexionIntranet.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="../galeriaEvidencias/default.css" />
</head>
<body>

<div id="container" >

	<div id="featured">
		<?php
		$conexion = new ConexionIntranet();
		$arregloRutas = $conexion->Query("SELECT DISTINCT xt_nombre FROM SGI_Simulacros_Evidencias WHERE xt_codigoSimulacro = '$simulacro'");
		$iRuta = 0;
		$contador=0;
		$dir="../../archivos/ImagenesEvidencia/";
		while ($rutas = $arregloRutas->fetchRow()) {
			$ruta[$iRuta] = $rutas[0];
			$iRuta++;
		}

		?><tr><td><?php
		if (!empty($ruta)) {
		?>
				<img style="display: block; cursor: pointer; transform: rotate(90deg); width: 40; height: 40;" src="../../../../../img/radar_next_03.png" name="btnVer" alt="Ver" onclick="ver();" />

				<img style="display: none; cursor: pointer; transform: rotate(180deg); width: 40; height: 40;" src="../../../../../img/radar_next_03.png" name="btnAnterior" alt="Anterior" onclick="anterior();" />

				</td><td colspan="6" align="center"><div class='img'><img style="display: none" src="<?php echo $dir.$ruta[$contador]; ?>" alt="Sin imagen" width="80%" name="fotoActual" /></div></td><td>

				<img style="display: none; cursor: pointer; width: 40; height: 40;" src="../../../../../img/radar_next_03.png" alt="Siguiente" name="btnSiguiente" 
				onclick="siguiente();" /></td></tr>

			<?php }else{
				echo "<tr><td></td><td colspan='6' id='fileItem'>No se han subido evidencias para este simulacro</td><td></td></tr>";
			} ?>

	</div>

</div><!--fin de container-->
</body>
</html>

<script type="text/javascript">
	var posicion = 0;
	var imagenes=<?php echo json_encode($ruta);?>;
	var posicionMax = imagenes.length - 1;

	function ver(){
		rutaActual = "../../archivos/ImagenesEvidencia/"+imagenes[0];
		fotoActual.setAttribute('src', rutaActual);
			document.btnSiguiente.style.display = "block";
			document.fotoActual.style.display = "block";
			document.btnVer.style.display = "none";
	}

	function anterior(){
		posicion = posicion-1;
		rutaActual = "../../archivos/ImagenesEvidencia/"+imagenes[posicion];
		fotoActual.setAttribute('src', rutaActual);

			if (posicion > 0 && posicion <= posicionMax) {
			document.btnAnterior.style.display = "block";
			document.btnSiguiente.style.display = "block";
			}else{
			document.btnAnterior.style.display = "none";
			document.btnSiguiente.style.display = "block";
			}
	}

	function siguiente(){
		document.fotoActual.style.display = "block";
		posicion = posicion+1;
		rutaActual = "../../archivos/ImagenesEvidencia/"+imagenes[posicion];
		fotoActual.setAttribute('src', rutaActual);

			if (posicion > 0 && posicion < posicionMax) {
			document.btnAnterior.style.display = "block";
			document.btnSiguiente.style.display = "block";
			}else{
			document.btnAnterior.style.display = "block";
			document.btnSiguiente.style.display = "none";
			}
	}
</script>
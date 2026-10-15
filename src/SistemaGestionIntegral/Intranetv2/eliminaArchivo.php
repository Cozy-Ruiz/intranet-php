<?php
require_once("../../ConexionIntranet2.php");
echo "<script src='../../AdministracionProyectos/_PPM/JS/proyecto.js'></script>";

if(isset ($_REQUEST['codigo'])){

	$idProyecto	= $_REQUEST['codigo'];
	$idArchivo	= $_REQUEST['idArchivo'];
	$nombreA	= $_REQUEST['nombreA']; 
	$ruta		= $_REQUEST['ruta'];
	$nombrephp	= $_REQUEST['nombrephp'];

	if (isset($_REQUEST["tipoDocumento"])) {
		$tipoDocumento	= $_REQUEST['tipoDocumento'];
	}

	if($nombrephp == 'fichaProyecto.php'){	
		$nombrephp = "D05_fichaDocumentoProyecto.php";

		if ($ruta == '' && $tipoDocumento != '') {
			$INTRANETV2->Execute("DELETE FROM SGI_Portafolio_Documentos WHERE xt_tipoDocumento = '$tipoDocumento'");
			header ("Location: ../../AdministracionProyectos/_PPM/".$nombrephp."?idProyecto=".$idProyecto);
		}else{

			$datosE = $INTRANETV2->GetRow("SELECT xn_version, xt_tipoDocumento 
				FROM SGI_Portafolio_Documentos WHERE xn_documentoId = $idArchivo LIMIT 1");

			$versionMax = $INTRANETV2->GetOne("SELECT max(xn_version) FROM SGI_Portafolio_Documentos WHERE xt_tipoDocumento = '".$datosE[1]."' AND xn_proyectoId = $idProyecto");

			if ($datosE[0] == $versionMax) {

				if(unlink("../../AdministracionProyectos/_PPM/".$ruta)){
					$INTRANETV2->Execute("DELETE FROM SGI_Portafolio_Documentos WHERE xn_documentoId = $idArchivo");
					header ("Location: ../../AdministracionProyectos/_PPM/".$nombrephp."?idProyecto=".$idProyecto);
				}else{
				    echo 'Archivo no encontrado!';
				}

			}else{
				echo "
				<script>
					alert('No es posible eliminar una version anterior!');
					location.href='../../AdministracionProyectos/_PPM/D05_fichaDocumentoProyecto.php?idProyecto=3';
				</script>";
			}
		}
	}
}
?>
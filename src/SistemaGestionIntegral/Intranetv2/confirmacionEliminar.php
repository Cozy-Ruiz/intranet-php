<?php
	$evidencia = $_GET['evidencia'];
	$simulacro = $_GET['simulacro'];
	$enlace    = $_GET['ruta'];
	 
	 

	 	echo "<script>
	if(confirm('Deseas continuar?')){ 

document.location='eliminaEvidenciaArchivoSimulacro.php?evidencia=".$evidencia."&simulacro=".$simulacro."&ruta=".$enlace."&confirmacion=1';} 
else
{
	javascript:history.back();
}
 </script>";  

 
?>
<?php error_reporting(0); ?>
<?php

if(isset($_REQUEST["evento"])){


	
	if($_REQUEST["evento"] == "cargaArchivo"){
		
		echo $tipoArchivo = $_REQUEST["tipoA"];
		echo "entro";
		
		if (!empty($_FILES)) {
			
			echo "exite archivo";
			 
			echo $tempFile = $_FILES['file']['tmp_name'];             
			  
		}
	}
	
		header ("Location: fichaPersonal_prueba.php?ID=399");
}

?>
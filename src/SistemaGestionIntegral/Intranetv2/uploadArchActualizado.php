<?php
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

$ruta = $_POST['ruta'];
$rutaE = $_POST['rutaEtapa'];
$id = $_POST['correctivaID']; 

if (isset($_POST['save'])) 
{ 
	if ($_FILES['archivo']['error'] > 0)
	  {
	  ?><script>
      alert('Ocurrio un error al intentar subir archivo!');
      self.close();</script><?php
	  }
	else
	{
		 	$rutaArchivoActual = '../SeguimientoEtapas/';
			//var_dump ($_FILES);//identifica si trae el archivp
			$archivoActual = $_FILES['archivo']['name'];
			$subir_archivo = $rutaArchivoActual.basename($_FILES['archivo']['name']);  
		if(file_exists($rutaArchivoActual) || @mkdir($rutaArchivoActual))
		{	//move_uploaded_file($_FILES['archivo']['tmp_name'], "archivosDesarrollo/" . $_FILES['archivo']['name']);
			//echo $subir_archivo;
			if (move_uploaded_file($_FILES['archivo']['tmp_name'],$subir_archivo))
        	{
				$INTRANETV2->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas_Etapas SET xt_ruta = '".$archivoActual."' WHERE xt_codigoAccion = '".$id."' AND xn_etapa = 2");
				?>
					<script>
    					alert('Modificado correctamente!');
    					self.close();
    					window.opener.document.location.href = 'fichaCorrectivav2Prueba.php?id='.$id;
    					window.opener.location.reload();
					</script>
				<?php
			
			}
			else 
            {   
                echo "    ---   La subida ha fallado";
			} 
		}else 
		{   
			echo "no paso";
		}
	}
}else 
{   
	echo "no paso 1";
}
?>
<?php
$dbHost = getenv('LINKS_DB_HOST');
$dbUsername = getenv('LINKS_DB_USER');
$dbPassword = getenv('LINKS_DB_PASS');
$dbName = getenv('LINKS_DB_NAME_V2');

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

$simulacro = $_POST['simulacro'];

if ($_FILES['archivo']['error'] > 0)
	  {
	  ?><script>
      alert('Ocurrio un error al intentar subir archivo!');
      self.close();</script><?php
	  }
	else
	  {
	  	$archviop  = explode(".", $_FILES['archivo']['name']);
	  	$_FILES['archivo']['name']= $simulacro."_desarrollo.".$archviop[1];
	move_uploaded_file($_FILES['archivo']['tmp_name'], "archivosDesarrollo/" . $_FILES['archivo']['name']);
	
	//echo "UPDATE SGI_Simulacros SET xt_rutaDesarrollo = '".$_FILES['archivo']['name']."' WHERE xt_codigoSimulacro = '".$simulacro."'";

	$conn->query("UPDATE SGI_Simulacros SET xt_rutaDesarrollo = '".$_FILES['archivo']['name']."' WHERE xt_codigoSimulacro = '".$simulacro."'");

?><script>
    alert('Modificado correctamente!');
    self.close();
    window.opener.document.location.href = '../simulacro/verSimulacro.php#divDesarrollo';
    window.opener.location.reload();
</script><?php

}
?>
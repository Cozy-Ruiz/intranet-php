<?php
$dbHost = '192.1.172.9:3306';
$dbUsername = 'GEA';
$dbPassword = '7b1QqK#m1F3m';
$dbName = 'INTRANET2';

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
	  	$_FILES['archivo']['name']= $simulacro."_asistencia.".$archviop[1];
	move_uploaded_file($_FILES['archivo']['tmp_name'], "archivosAsistencia/" . $_FILES['archivo']['name']);
	
	//echo "UPDATE SGI_Simulacros SET xt_rutaDesarrollo = '".$_FILES['archivo']['name']."' WHERE xt_codigoSimulacro = '".$simulacro."'";

	$conn->query("UPDATE SGI_Simulacros SET xt_rutaAsistencia = '".$_FILES['archivo']['name']."' WHERE xt_codigoSimulacro = '".$simulacro."'");

?><script>
    alert('Modificado correctamente!');
    self.close();
    window.opener.document.location.href = '../simulacro/verSimulacro.php#divAsistencia';
    window.opener.location.reload();
</script><?php

}
?>
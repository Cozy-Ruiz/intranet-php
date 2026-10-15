<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>

<?php
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");

  $solicitudID = $_POST['codigo'];

  $comentarioMS = $_POST['comentario'];
  
  $status = $_POST['valor'];
  
  $usuario = $_POST['usuario'];
?>

<meta charset="utf-8">
<title>Documento sin título</title>

</head>

<body>

<?php

	
	if($solicitudID != ''){
	
		//inserto en validacion
		
	$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$solicitudID', '$status', 'MANTENIMIENTO', '$usuario', '$comentarioMS')");
		
		
		?>
        <script language="javascript" type="text/javascript">
        alert("Modificaciones realializadas correctamente");
		window.location.reload();
        </script>
        <?php
		
	}


?>



</body>
</html>
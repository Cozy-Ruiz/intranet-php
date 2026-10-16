<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");

$index2 = 0;
	
	$solicitud = $_POST['solicitud'];
	$empleado2 = $_POST['empleado'];
	$bloqueados = array();
	$permitidos = array();
	
	
	
	$b = $INTRANET->Execute("SELECT
	RCD.xt_tipo_documento
FROM
	SGI_CATALOGO_EXPEDIENTE_PERSONAL RCD
WHERE
	RCD.xt_tipo_documento IN (
		SELECT DISTINCT
			RCSD.xt_tipo_expediente
		FROM
			SGI_EXPEDIENTE_PERSONAL RCSD
		WHERE
			RCSD.xt_usuario_empleado = '$empleado2'
	)");
	
	
		
		while($t = $b->fetchRow()){
		 $bloqueados[$index2] = $t[0];
		$index2++;
	}
	
	
	$index1 = 0;

	$xx = $INTRANET->Execute("SELECT RCD.xt_tipo_documento FROM SGI_CATALOGO_EXPEDIENTE_PERSONAL RCD WHERE
					RCD.xt_tipo_documento NOT IN (SELECT DISTINCT RCSD.xt_tipo_expediente FROM SGI_EXPEDIENTE_PERSONAL RCSD WHERE RCSD.xt_usuario_empleado = '$empleado2')");
	
	while($p = $xx->fetchRow()){
		  $permitidos[$index1] = $p[0];
		$index1++;
	}
	
	
	
	
	//Agregar tipo de documentos
	for($e = 0;$e<count($permitidos);$e++){
		if(in_array($permitidos[$e], $solicitud)){
			
			//echo "DELETE FROM RADAR_CATALOGO_SIN_DOCUMENTOS WHERE xt_referenci = '$referencia' AND xt_nombreDocumento = '$solicitud[$i]'";
			
			//echo "INSERT INTO RADAR_CATALOGO_CON_DOCUMENTOS VALUES('$referencia','$permitidos[$e]','40665345140')";
				
			
			$INTRANET->Execute("INSERT INTO SGI_EXPEDIENTE_PERSONAL (xt_usuario_empleado, xt_tipo_expediente) VALUES('$empleado2', '$permitidos[$e]')");
				
		}
	}

	echo "<script type='text/javascript'>
	       opener.location.reload();
           window.close();
		</script>";
	?>
	

	
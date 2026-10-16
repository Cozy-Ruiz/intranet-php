<?php
require_once("../../../ConexionIntranet2.php");


   
	$codigoDocs=$_POST['CodigoDoc'];
	$nombreDocs=$_POST['NombreDoc'];
	$juridico=$_POST['nopcion'];
	$nota=$_POST['nnota'];
	/*echo $Juridico . ":Holaaa". $Nota;*/




	$INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Autorizacion_Documentos (
	xt_codigoDocumento,
	xt_nombreDocumento,
	xn_autorizacionCalidad,
	xn_autorizacionJuridico,
	xt_comentarios
)
VALUES
	(
		'$codigoDocs',
		'$nombreDocs',
		'8',
		'$Juridico',
		'$Nota'
	)");


?>

<?php

$nombrephp='ReenvioBoletin.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
require_once("Mailv2.php");


$saved = getenv("LD_LIBRARY_PATH");
$newld = "/extra/library/dir:/another/path/to/lib";
if ($saved) { $newld .= ":$saved"; }
putenv("LD_LIBRARY_PATH=$newld");
@system("mycommand -with args");
putenv("LD_LIBRARY_PATH=$saved");
			

	
	$boletin = 'GE-H-CMX-20-034';
	
	$s = $INTRANETV2->Execute("SELECT xt_titulo, xt_descripcion, xt_ruta, xn_numero, xt_grupo, xt_ciudad, xd_fecha FROM SGI_Boletines WHERE xt_claveboletin = '$boletin'");
	while($r = $s->fetchRow()){
	$tituloInsert 		= $r[0];
	$descripcionInsert 	= nl2br($r[1]);
	$ciudadInsert		= $r[5];
	$grupoInsert		= $r[4];
	$fechaInsert		= $r[6];
	$archivo 			= $r[2];

	} unset($r);
	

	$enviarMail = new MailAgregaBoletin;
	$enviarMail->mailAgregaBoletinIntra($boletin,$tituloInsert, $descripcionInsert,$ciudadInsert, "../Boletines/", $archivo);	
		
?>
<?php

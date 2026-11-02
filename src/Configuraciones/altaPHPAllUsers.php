<?php error_reporting(0); ?>
<?php
require_once("../ConexionDBT.php");

$pagina 	= $_GET['pagina'];
$agregados 	= 0;
$errores 	= 0;

$s = $INTRANET->Execute("SELECT kp_usuario FROM IntranetGEA_USUARIOS ");

while($r = $s->fetchRow()){
	
	if($INTRANET->Execute("INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$pagina','$r[0]') ")){
		
		echo "OK |".$pagina."|".$r[0]."<br>";
		$agregados++;
		
	} else{
		
		echo "NOT|".$pagina."|".$r[0]."<br>";
		$errores++;
		
	}

} unset($s); unset($r);

echo "FIN<br>";
echo "AGREGADOS: ".$agregados."<br>";
echo "ERRORES: ".$errores."<br>";


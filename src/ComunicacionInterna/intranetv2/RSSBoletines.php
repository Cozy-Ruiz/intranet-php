<?php
header("Content-type: text/xml");
$nombrephp = 'TableroBoletines.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna </a>";

$indice = 1;

//$boletinID 		= NULL;
$fecha 			= NULL;
$titulo 		= NULL;
$claveBoletin 	= NULL;

$s = $INTRANETV2->Execute("SELECT xt_claveBoletin, xd_fecha, xt_titulo,xt_descripcion FROM SGI_Boletines ORDER BY xd_fecha DESC ");

while($r = $s->fetchRow()){
	$claveBoletin[$indice] 	= $r[0];
	$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
	$titulo[$indice] 		= $r[2];
	$descripcion[$indice] 		= $r[3];
	//$claveBoletin[$indice] 	= $r[3];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);


function clrAll($str) {
   $str=str_replace("&","&",$str);
   $str=str_replace('"','"',$str);
   $str=str_replace("'","'",$str);
   $str=str_replace(">",">",$str);
   $str=str_replace("<","<",$str);
   return $str;
}

?>
 
<?php


//comienzo a escribir el código del RSS
echo '<?xml version="1.0""." encoding="ISO-8859-1"?>';
if(($usuarioId == 'Eibar_Ponce')   || ($usuarioId == 'Ricardo_Garcia') ){
	if(count($claveBoletin) >= 1){

echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">';
//Datos generales del Canal. Edítalos conforme a tus necesidades
echo "<channel>\n";
echo "<title>Boletines</title>";
echo "<link>https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/intranetv2/RSSBoletines.php</link>";
echo "<description>Boletines Grupo Escalante.</description>";
echo "<language>es-es</language>";
echo "<copyright>Grupo Escalante</copyright>\n"; 
		
		echo "<item>\n";
	   		echo "<title>$titulo</title>\n";
	   		echo "<description>$desc</description>\n";
	   		echo "<link>" . $claveBoletin[$a] . "</link>\n";
	   		echo "<pubDate>". $fecha[$a]."</pubDate>\n";
	   		echo "</item>\n";

			for($a = 1; $a <= count($claveBoletin); $a++){

				$titulo=clrAll($titulo[$a]);    
				$desc=clrAll($descripcion[$a]);       

			echo "<item>\n";
	   		echo "<title>$titulo</title>\n";
	   		echo "<description>$desc</description>\n";
	   		echo "<link>" . $claveBoletin[$a] . "</link>\n";
	   		echo "<pubDate>". $fecha[$a]."</pubDate>\n";
	   		echo "</item>\n";
                  
					 
			} unset($a);
			echo "</channel>";
echo "</rss>"

		
	}
	}  
	 

?> 
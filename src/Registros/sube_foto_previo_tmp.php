<?php error_reporting(0); ?>
<?php


/*$jpg = base64_decode($_POST["data"]);
	


$id_foto = date('YmdHis');//extraemos la fecha del servidor

$filename = "temporales/".$id_foto.'.jpg';//nombre del archivo
echo "$filename";
$result = file_put_contents($filename, file_get_contents('php://input') );//renombramos la fotografia y la subimos

if (!$result) {
	print "No se pudo subir al servidor\n";
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;//generamos la respuesta como la ruta completa
print "$url\n";//20120214060943.jpg*/


$jpg = base64_decode($_POST["data"]);
$id_foto = date('YmdHis');//extraemos la fecha del servidor

$filename = "temporales/".$id_foto.'.jpg';//nombre del archivo

$file = fopen($filename, "a+");


        // Debe tener permiso de escritura.

	fwrite($file, $jpg);

	//fclose($file);

	echo "ok";


	

?>

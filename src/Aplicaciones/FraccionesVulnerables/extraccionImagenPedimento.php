<?php
	//Created by Cosijopi Richard Ruiz Avendaño
	//Ing. Sistemas Computacionales
	
	$nombrephp = 'extraccionImagenPedimento.php';
	//require_once("conexionMasterDB.php");
	//require_once("compruebaUsuario.php");
	
	$ftp_server = "71.144.19.155";
	$ftp_user = "Imagenes";
	$ftp_pass = "Img2012Server";
	
	$ruta = substr($_GET["ruta"], 3);

	$rutaCompleta = "ftp://$ftp_user:$ftp_pass@$ftp_server/$ruta";
	
	$nuevoNombre = explode("/",$ruta);
	header ("Content-Disposition: attachment; filename=".$nuevoNombre[count($nuevoNombre) - 1]."\n\n");
	header ("Content-Type: application/octet-stream");
	//header ("Content-Length: ".filesize($rutaCompleta));
	readfile($rutaCompleta);
?> 
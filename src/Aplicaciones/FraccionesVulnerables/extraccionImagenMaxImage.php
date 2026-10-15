<?php
	//Created by Cosijopi Richard Ruiz Avendaño
	//Ing. Sistemas Computacionales
	
	$nombrephp = 'extraccionImagenMaxImage.php';
	//require_once("conexionMasterDB.php");
	//require_once("compruebaUsuario.php");

	$ftp_server = "201.144.217.249";
	$ftp_user = "Richard";
	$ftp_pass = "cozy";
	
	$referencia = $_GET["referencia"];
	$tipoDocumento = $_GET['tipoDocumento'];
	$rutaCompleta = $_GET["ruta"];
	$ruta = substr($rutaCompleta, 3);
	$carpetas = explode("/",$ruta);
	for($a = 0; $a<count($carpetas); $a++){
		if($a != (count($carpetas) - 1) ){
			$ubicacion = $ubicacion."/".$carpetas[$a];
		}
		if($a == (count($carpetas)-1) ){
			$archivo = $carpetas[$a];
		}
	}
	
	// definir algunas variables
	$local_folder = 'tmp';
	
	// establecer una conexión o finalizarla
	$conexion = ftp_connect($ftp_server) or die("No se pudo conectar a $ftp_server <br><br>"); 
	
	// intentar iniciar sesión
	if (ftp_login($conexion, $ftp_user, $ftp_pass)) {
		//echo "Conectado como $ftp_user $ftp_server <br><br>";
	} else {
		echo "No se pudo conectar como $ftp_user <br><br>";
	}
	
	// imprimir el directorio actual
	$ruta = ftp_pwd($conexion);
	//echo "Ruta Actual: $ruta <br><br>";
	
	// intenta cambiar el directorio a somedir
	if (ftp_chdir($conexion, $ubicacion)) {
		//echo "El directorio actual es: " . ftp_pwd($conexion)."<br><br>";
	} else { 
		echo "No se pudo cambiar al directorio <br<br>";
	}

	$local_file = "$local_folder/$archivo";
	
	// intenta descargar $server_file y guardarlo en $local_file
	if (ftp_get($conexion, $local_file, $archivo, FTP_BINARY)) {
		//echo "Se ha guardado satisfactoriamente en $local_file <br>";
	} else {
		echo "Ha habido un problema en la copia de la Imagen <br>";
	}
	
	// cerrar la conexión ftp
	if(ftp_close($conexion)){
		//echo "Conexion Finalizada <br>";
	}else{
		echo "No se pudo cerrar la conexion <br>";
	}
	
	//Genero PDF
	$pdf = pdf_new();

 if (pdf_begin_document($pdf,"", "") == 0)
    {die("Error: " . pdf_get_errmsg());}

   pdf_set_parameter($pdf, "SearchPath", "tmp/");
   pdf_set_parameter($pdf, "hypertextencoding", "winansi");
   pdf_set_parameter($pdf, "imagewarning", "false");
   pdf_set_info($pdf, "Creator", "Cozy");
   pdf_set_info($pdf, "Author", "Cozy");
   pdf_set_info($pdf, "Title", "Raport");
   
   	for($i=1; ; $i++)
	{
		$logo = pdf_open_image_file($pdf, "tiff", $archivo, "page", $i);
		if($logo != 0){
			pdf_begin_page($pdf, 595, 670);
			pdf_place_image($pdf, $logo, 50,0, 0.300);
			pdf_close_image($pdf, $logo);
			pdf_end_page($pdf);
		}else{
		     	break;
			}
	}
	pdf_close($pdf);
	
	unlink($local_file);

  $buf = pdf_get_buffer($pdf);
  $len = strlen($buf);
  header("Content-type: application/pdf");
  header("Content-Length: $len");
  header("Content-Disposition: attachment; filename=".$referencia."_".$tipoDocumento.".pdf");
  echo $buf;
	
	//header("Location: http://escalante.mx/radar/D01/$local_file"); 

?> 

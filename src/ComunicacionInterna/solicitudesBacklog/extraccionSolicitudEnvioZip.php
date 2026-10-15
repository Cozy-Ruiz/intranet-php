<?php error_reporting(0); ?>
<?php
	$nombrephp = 'extraccionSolicitudEnvioZip.php';
	require_once("../../ConexionDBT.php");
	//require_once("compruebaUsuario.php");
	
	//Permite borrar directorio aunque este lleno
	function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
			  if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
			  }
			} 
			reset($objects);
			rmdir($dir);
		}
	}

	$ftp_server = "71.144.19.155";
	$ftp_user = "Imagenes";
	$ftp_pass = "Img2012Server";
	
	$codigo = $_GET['codigo'];
	$index = 0;
	
	$s = $INTRANET->Execute("select xt_nombreArchivo, xt_ruta from SGI_Backlog_Documentos where xt_quejaSolicitud = '$codigo' ");
	while($r = $s->fetchRow()){
		
		$ubicacion = null;
		$archivo = null;
		
		$tipoDocumento = $r[0];
		$rutaCompleta = $r[1];
		$extension = substr($rutaCompleta, -3, 3);
		$ruta = substr($rutaCompleta, 3);
		$carpetas = explode("/",$ruta[$a]);
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
		
		$local_file = "$local_folder/".$codigo."/".$tipoDocumento;
	
		// intenta descargar $server_file y guardarlo en $local_file
		echo ftp_get("D:/INTRANET/documentosSolicitudes", $local_file, $archivo, FTP_BINARY);
		if (ftp_get("D:/INTRANET/documentosSolicitudes", $local_file, $archivo, FTP_BINARY)) {
			$archivosParaZip[$index] = $local_file;
			$index++;
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
	}
	
	$zip = new ZipArchive();
	$zipName = "tmp/".$codigo.".zip"; 
	if($zip->open($zipName,ZIPARCHIVE::CREATE)===true) {
		for($a=0; $a<count($archivosParaZip); $a++){
			$zip->addFile($archivosParaZip[$a]);
		}
	    $zip->close();
		//echo 'Creado '.$zipName;
	}else{
	    //echo 'Error creando '.$zipName;
	}
	
	//Borro Archivos Zip
	for($a=0; $a<count($archivosParaZip); $a++){
		unlink($archivosParaZip[$a]);
	}
	
	//rrmdir("tmp/".$codigo);
	
	$nuevoNombre = $codigo.".zip";
	header ("Content-Disposition: attachment; filename=".$nuevoNombre."\n\n");
	header ("Content-Type: application/octet-stream");
	//header ("Content-Length: ".filesize($rutaCompleta));
	readfile($zipName);

?> 

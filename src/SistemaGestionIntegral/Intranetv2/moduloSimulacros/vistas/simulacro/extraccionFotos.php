<?php


require_once('zip.class.php');

//Acceso al FTP para el Slide de Imagenes

$ftp_server = "201.147.92.141";
$ftp_user = "Administrador";
$ftp_pass = "1nt3rc0mM*";
$ubicacion = "/DIGITALIZACION/IMAGEN-PREVIO";

$referencia = $_GET['referencia'];


 if(!file_exists('./fotos_previo/')){
			
			 //chdir('./fotos_previo/');
			 mkdir('fotos_previo/',0777);
			 
		 }

 

$conexion = ftp_connect($ftp_server, 21) or die("No se pudo conectar a $ftp_server <br><br>");
if (ftp_login($conexion, $ftp_user, $ftp_pass)) {
	
	ftp_pasv($conexion, true);
//echo "Conectado como $ftp_user $ftp_server <br><br>";
} else {
	//echo "No se pudo conectar como $ftp_user <br><br>";
}

 //Obtiene lista de fotos
if ($fotos = ftp_nlist($conexion, $ubicacion."/".$referencia)) {

		
	$zip = new CrearZip();
	
	 for($a=0; $a<count($fotos); $a++){
        
		$fotoNombre = explode('\\',$fotos[$a]);
		$nombreA= $fotoNombre[count($fotoNombre) -1];
	
	 	 // definir algunas variables
		 $local_file = './fotos_previo/'.$nombreA;
		 
		
		$server_file = '/DIGITALIZACION/IMAGEN-PREVIO/'.$referencia.'/'.$nombreA;

		// download server file
		if (ftp_get($conexion, $local_file, $server_file, FTP_BINARY)){
 			//echo "Successfully written to $local_file.";
 		}else{
  		//echo "Error downloading $server_file.";
  		}
	}
	if(ftp_close($conexion)){
    	//echo "Conexion Finalizada <br>";
    }else{
        //echo "No se pudo cerrar la conexion <br>";
    }
		 
	for($a=0; $a<count($fotos); $a++){
        
		$fotoNombre = explode('\\',$fotos[$a]);
		$nombreA= $fotoNombre[count($fotoNombre) -1];
		// $ruta = $ubicacion."/".$referencia."/".$nombreA;
          
		$ruta = "./fotos_previo/".$nombreA;
		$zip->agregarArchivos($ruta, $nombreA);
		  
   }//fin del for
									
	$zip->cerrarZip("fotos_".$referencia);

//borro fotos

	for($a=0; $a<count($fotos); $a++){
        
		$fotoNombre = explode('\\',$fotos[$a]);
		$nombreA= $fotoNombre[count($fotoNombre) -1];
		// $ruta = $ubicacion."/".$referencia."/".$nombreA;
          
		$ruta = "./fotos_previo/".$nombreA;
		   
		unlink($ruta);
		  
   }//fin del for

}//cierra if de lista de fotos*/


 
?>


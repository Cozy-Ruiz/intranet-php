<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php

class CrearZip{
   var $zip;
   var $archivo;

   function CrearZip(){
      $this->archivo = tempnam(sys_get_temp_dir(),"zip");
      $this->zip = new ZipArchive();
      $ress = $this->zip->open($this->archivo, ZipArchive::OVERWRITE);
      $this->zip->addEmptyDir("Solicitud");

   }

   function agregarArchivos($archivo, $nombre){
	//echo $archivo,"Documentos/".$nombre;
	//echo "<br>";
      $this->zip->addFile($archivo,"Solicitud/".$nombre);
   }

   function cerrarZip($codigo){
      $this->zip->close();
      header("Content-type: application/zip");
      header("Content-Disposition: attachment; filename=$codigo.zip");
      header("Content-Transfer-Encoding: binary");
      readfile($this->archivo);
     /* unlink($this->archivo);//Destruye el archivo temporal*/
 }

}
?>

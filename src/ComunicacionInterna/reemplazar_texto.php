 <?php

 //RECORRO EL DIRECTORIO
 function listarArchivos( $path ){
   // Abrimos la carpeta que nos pasan como parámetro
   $dir = opendir($path);
   // Leo todos los ficheros de la carpeta
   while ($elemento = readdir($dir)){
       // Tratamos los elementos . y .. que tienen todas las carpetas
       if( $elemento != "." && $elemento != ".."){
           // Si es una carpeta
           if( is_dir($path.$elemento) ){
               // Muestro la carpeta
              // if($elemento != "1899"){

                  echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                 // $nuevaCarpeta = "./".$elemento."/";
               //llamamos a la funcion para recursividad
              // listarArchivos($nuevaCarpeta);

               //}
               
           // Si es un fichero
           } else {
               // Muestro el fichero
               //echo "<br />". $elemento;
               $rest = substr($elemento, -3);
               if($rest=="php"){

                  //modifico archivo
                  $archivo = $elemento;

                  $actual = "<?php error_reporting(0); ?>\n";
                  $actual .= file_get_contents($archivo);

                 if(file_put_contents($archivo, $actual)){

                  echo "SE MODIFICO".$elemento;

                 }else{

                  echo "NO SE MODIFICO". $elemento;
                 }

                  // También vamos a emplear la bandera LOCK_EX para evitar cualquier modificación mientras:
                 // file_put_contents($archivo, $mascontenido, FILE_APPEND | LOCK_EX);

                 

                  fclose($fp);

               } 
           }
       }
   }
}
// Llamamos a la función para que nos muestre el contenido de la carpeta gallery
listarArchivos("../ComunicacionInterna/");




/*$archivo = "tablero_prueba_liz.php";

$actual = "<?php error_reporting(0); ?>\n";
$actual .= file_get_contents($archivo);
file_put_contents($archivo, $actual);

// También vamos a emplear la bandera LOCK_EX para evitar cualquier modificación mientras:
file_put_contents($archivo, $mascontenido, FILE_APPEND | LOCK_EX);

fclose($fp);*/

?>
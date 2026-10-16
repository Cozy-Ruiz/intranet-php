<?php
//header('Content-Type: image/PNG');
/*header('Content-type: image/png');

$imagen = new Imagick('EVIDENCIA_02_01_2018.png');
$imagen->adaptiveResizeImage(1024,768);

echo $imagen;*/


//  crearThumbJPEG();

// function crearThumbJPEG(){

// $nombre_archivo = 'foto1.png';
// $porcentaje = 0.15;


// $rutaDestino = "img/evidencia_modif.png";
// 	echo "entro funcion";

//   // Obtener nuevas dimensiones
//  list($ancho, $alto) = getimagesize($nombre_archivo);
//  $nuevo_ancho = $ancho * $porcentaje;
//  $nuevo_alto = $alto * $porcentaje;

//  $imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
// $imagen = imagecreatefrompng($nombre_archivo);
// imagecopyresampled($imagen_p, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

// // Imprimir
// imagepng($imagen_p, $rutaDestino);

//         $original=imagecreatefrompng($rutaImagen);

//         if ($original !== false){

        	
//            $thumb=imageCreatetrueColor($anchoThumb,$altoThumb);
//            if ($thumb !== false){
//               $ancho=imagesx($original);
//               $alto=imagesy($original);

//               imagecopyresampled($thumb,$original,0,0,0,0,$anchoThumb,$altoThumb,$ancho,$alto);
//               $resultado=imagepng($thumb,$rutaDestino,$calidad);
//               return $resultado;
//            }
//         }
//         return false;
        
// } 



// // El archivo
// /*$nombre_archivo = 'EVIDENCIA_02_01_2018.PNG';
// $porcentaje = 0.5;

// // Tipo de contenido
// header('Content-Type: image/png');

// // Obtener nuevas dimensiones
// list($ancho, $alto) = getimagesize($nombre_archivo);
// $nuevo_ancho = $ancho * $porcentaje;
// $nuevo_alto = $alto * $porcentaje;

// // Redimensionar
// $imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
// $imagen = imagecreatefrompng($nombre_archivo);
// imagecopyresampled($imagen_p, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

// // Imprimir
// imagepng($imagen_p, null, 100);
// 

phpinfo();

?>




<?php
	ini_set("display_errors", 1);
  ini_set('display_errors', 'On');
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  
  //require_once("adodb/adodb.inc.php");
  require_once("../Librerias/adodb/adodb.inc.php");
  
  /*
  $usuario = "desarrollo";
  $contrasena = "desarrollo";  // en mi caso tengo contraseña pero en casa caso introducidla aquí.
  $servidor = "master.escalante.com.mx";
  $basededatos = "MASTER_GE";
  */

  $usuario = "LINKS";
  $contrasena = "links";  // en mi caso tengo contraseña pero en casa caso introducidla aquí.
  $servidor = "escalante.com.mx";
  $basededatos = "LINKS";


  // creación de la conexión a la base de datos con mysql_connect()
  $conexion = mysqli_connect( $servidor, $usuario, $contrasena, $basededatos, 3306) or die ("No se ha podido conectar al servidor de Base de datos");

  echo $conexion->host_info."\n";
  
?>
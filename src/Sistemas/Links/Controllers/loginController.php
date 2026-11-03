<?php

	//echo $_SERVER['PHP_SELF']."<br>";
	//echo dirname(__FILE__)."<br>";
	
	require_once('../Models/Session.php');
	
	$session = new Session();
		
	if($_POST['usuario'] && $_POST['contraseña']){
		 
		if($session->iniciaSession($_POST['usuario'], $_POST['contraseña']) == true){
			header("Location: homePageController.php");
		}else{
			header("Location: https://escalante.com.mx/Sistemas/Links");
		}
	
	}else if($_SESSION["autentificado"] == "SI"){
		 
		if($session->registraSession($_SESSION["sesionUsuario"]) == true){
			header("Location: homePageController.php");
		}else{
			header("Location: https://escalante.com.mx/Sistemas/seleccionaSistema.php");
		}
		
	}else{
		
		header("Location: https://escalante.com.mx/Sistemas");
		
	}
?>
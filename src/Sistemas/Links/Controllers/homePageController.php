<?php
	require_once('../Models/Session.php');
	require_once('../Models/Usuario.php');
	
	$tituloEscritorio = "Home Page";
	
	$session = new Session();
	if($session->compruebaUsuario() == true){
		$breadCrumbHomePage = "Home Page:homePageController.php";
		$session->removeBreadCrumb($breadCrumbHomePage);
	}

	if(isset($_REQUEST["evento"])){
		
		if($_REQUEST["evento"] == "CierraSession"){
			$session->cierraSession();
		}
		
	}else if(isset($_REQUEST["cambiaOficina"])){
		
		$session->cambiaOficina($_REQUEST["cambiaOficina"]);
		
		$html = file_get_contents('../Views/homePage.php');
		$arrayFinal[0] = $html;
		
		require("../Views/templates/escritorio.php");
		
	}else{
		
		$html = file_get_contents('../Views/homePage.php');
		$arrayFinal[0] = $html;
		
		require("../Views/templates/escritorio.php");
		
	}
	
?>
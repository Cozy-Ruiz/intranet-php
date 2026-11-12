<?php
	require_once('../Models/Session.php');
	require_once('../Models/Usuario.php');
	
	
	$session = new Session();
	if($session->compruebaUsuario() == true){

		$breadCrumbModulos = "Módulos:modulosController.php"; 
		$session->removeBreadCrumb($breadCrumbModulos);
		$breadCrumbCatalogos = "Catálogos:catalogosController.php?proceso=K064"; 
		$session->removeBreadCrumb($breadCrumbCatalogos);
		
		$breadCrumbHomePage = "Home Page:homePageController.php";
		$session->addBreadCrumb($breadCrumbHomePage);
		
	}

	$proceso = "K0056"; //Generar CFDI de exportación
	$_SESSION["sesionLinks"]->obtenPermisosProceso($proceso);

	//Obtengo usuario y declar esto solo para el modulo de mv vucem
	
	 $usuario = $_SESSION['sesionLinks']->usuario;

	$rutaMVseguros = "http://192.1.171.49:9090/Seguros-Vucem/#/Sistemas/Links/Controllers/depositoController?usuario=".$usuario; 
	$rutadOCmV = "http://192.1.171.49:9090/deposito-archivos/#/Sistemas/Links/Controllers/depositoController?usuario=".$usuario;
	$rutaMVucem = "http://192.1.171.49:9090/MvServer/#/Sistemas/Links/Controllers/mvController?usuario=".$usuario;
	$rutaDocDigitaliza = "http://192.1.171.49:9090/Convertidor-Archivos/#/Sistemas/Links/Controllers/Convertidor_Digitalizacion?usuario=".$usuario;
	

	//$rutaDocDigitaliza = "https://escalante.com.mx/Sistemas/Links/Views/proceso/DigitalizacionArchivos/Digitalizacion.php?usuario=".$usuario;
	$tituloEscritorio = "Modulos";
	
	if(isset($_REQUEST["evento"])){
		if($_REQUEST["evento"] == "CierraSession"){
			$session->cierraSession();
		}
	}else{
		
		$modulos = $_SESSION['sesionLinks']->obtenModulosOficina($_SESSION['sesionLinks']->oficina);

		
		$iconos = null;
		for($a=0; $a<count($modulos); $a++){
			$nombre = $modulos[$a]['XT_CONTROLADOR'];

			//ruta para deposito de seguros MV 

			 if($nombre == 'depositoController'){

				

				$iconos .= "<div class='icono' style='display:inline-block; width:130px;  margin:10px 10px 10px 10px;'>
								<div><a href='$rutaMVseguros'><img src='../Views/img/".$modulos[$a]['XT_MODULO'].".png' width='62' height='62' alt=''/></a></div>
								<div style='color:gray; font-family:Arial;'>".$modulos[$a]['XT_MODULO']."</div>
							</div>";


			//ruta para deposito de contratos

			 }else if($nombre == 'depositoControllerMV'){

				

				$iconos .= "<div class='icono' style='display:inline-block; width:130px;  margin:10px 10px 10px 10px;'>
								<div><a href='$rutadOCmV'><img src='../Views/img/".$modulos[$a]['XT_MODULO'].".png' alt=''/></a></div>
								<div style='color:gray; font-family:Arial;'>".$modulos[$a]['XT_MODULO']."</div>
							</div>";
				
				//SECCION PARA MODULO DE MV EN VUCEM
			}else if($nombre == 'ControllerMVucem'){

				

				$iconos .= "<div class='icono' style='display:inline-block; width:130px;  margin:10px 10px 10px 10px;'>
								<div><a href='$rutaMVucem'><img src='../Views/img/".$modulos[$a]['XT_MODULO'].".png' alt=''/></a></div>
								<div style='color:gray; font-family:Arial;'>".$modulos[$a]['XT_MODULO']."</div>
							</div>";
				
			//ruta para digitalizacion de archivos
			}else if($nombre == 'digitalizaVucem'){

				

				$iconos .= "<div class='icono' style='display:inline-block; width:130px;  margin:10px 10px 10px 10px;'>
								<div><a href='$rutaDocDigitaliza'><img src='../Views/img/".$modulos[$a]['XT_MODULO'].".png' alt=''/></a></div>
								<div style='color:gray; font-family:Arial;'>".$modulos[$a]['XT_MODULO']."</div>
							</div>";
				
			
			

			}else if($a==0){

				$iconos = "<div class='icono' style='display:inline-block; width:130px;  margin:10px 10px 10px 10px;'>
							<div><a href='".$modulos[$a]['XT_CONTROLADOR']."'><img src='../Views/img/".$modulos[$a]['XT_MODULO'].".png' alt=''/></a></div>
							<div style='color:gray; font-family:Arial;'>".$modulos[$a]['XT_MODULO']."</div>
						</div>";



			}else if($nombre == 'dodaController.php'){
				/*$iconos .= '<div class="icono" style="display:inline-block; width:130px;  margin:5px 5px 5px 5px;">
								<div><a href=""><img src="../Views/img/'.$modulos[$a]["XT_MODULO"].'.png" alt=""/></a></div>
								<div style="color:gray; font-family:Arial;">En mantenimiento <br> "Favor de generarlo por ventanilla"</div>
							</div>';	*/
				
				$iconos .= "<div class='icono' style='display:inline-block; width:130px;  margin:10px 10px 10px 10px;'>
								<div><a href='".$modulos[$a]['XT_CONTROLADOR']."'><img src='../Views/img/".$modulos[$a]['XT_MODULO'].".png' alt=''/></a></div>
								<div style='color:gray; font-family:Arial;'>".$modulos[$a]['XT_MODULO']." - CCP</div>
							</div>";
					
			//CONTROLADOR PARA MODULO DE CARGA DE DOCTOS PARA MV
			}else{
				$iconos .= "<div class='icono' style='display:inline-block; width:130px;  margin:10px 10px 10px 10px;'>
								<div><a href='".$modulos[$a]['XT_CONTROLADOR']."'><img src='../Views/img/".$modulos[$a]['XT_MODULO'].".png' alt=''/></a></div>
								<div style='color:gray; font-family:Arial;'>".$modulos[$a]['XT_MODULO']."</div>
							</div>";
			}
		}
		
		$html = file_get_contents('../Views/modulos.php');
		$html = str_replace("MODULOS", $iconos, $html);
		
		$index=0;
		$arrayFinal[$index] = $html;
		require("../Views/templates/escritorio.php");
	}
		
?>
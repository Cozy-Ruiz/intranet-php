<?php
require_once("../DataBase/conexionLinks.php");
require_once('../Models/Usuario.php');

class Session {
	
	function __construct(){
		session_start();
	}
	
    function iniciaSession($User, $Pass) {
 
		$_SESSION["sesionLinks"] = new Usuario();
		$_SESSION["sesionLinks"]->iniciaUsuario($User, $Pass);
		
		if($_SESSION["sesionLinks"]->usuario != null){
			
			$LINKS_GE = new ConexionLinks();
			
			$LINKS_GE->Execute("insert into SESIONES_USUARIOS 
								(xt_usuario, xd_fechaEntrada) 
								values 
								('".$_SESSION["sesionLinks"]->usuario."', STR_TO_DATE('".date('Y-m-d')." ".date('H:i:s')."', '%Y-%m-%d %H:%i:%s')) ");
			
			$s = $LINKS_GE->Query("select xn_sesionId from SESIONES_USUARIOS where xt_usuario = '".$_SESSION["sesionLinks"]->usuario."' and xd_fechaEntrada = STR_TO_DATE('".date('Y-m-d')." ".date('H:i:s')."','%Y-%m-%d %H:%i:%s') ");
			while($r = $s->fetchRow()){
				$_SESSION["sesionLinksId"] = $r[0];
			}
			
			$LINKS_GE->Close();

			$_SESSION["sesionLinks"]->obtenOficinas();
			
			return true;
			
		}else{
			
			$_SESSION["sesionLinks"] = null;
			$_SESSION["sesionLinksId"] = null;
			
			return false;
		}
		
	}
	
	function compruebaUsuario() {
		
		if($_SESSION["sesionLinks"]->usuario != null){
			return true;
		}else{
			$_SESSION["sesionLinks"] = null;
			$_SESSION["sesionLinksId"] = null;
			header("Location: ../../seleccionaSistema.php");
		}
    }
	
	function registraSession($User) {
		$_SESSION["sesionLinks"] = new Usuario();
		$_SESSION["sesionLinks"]->registraUsuario($User);
		
		if($_SESSION["sesionLinks"]->usuario != null){
			
			$LINKS_GE = new ConexionLinks();
			
			
			$LINKS_GE->Execute("insert into SESIONES_USUARIOS 
								(xt_usuario, xd_fechaEntrada) 
								values 
								('".$_SESSION["sesionLinks"]->usuario."', STR_TO_DATE('".date('Y-m-d')." ".date('H:i:s')."', '%Y-%m-%d %H:%i:%s')) ");
			
			$s = $LINKS_GE->Query("select xn_sesionId from SESIONES_USUARIOS where xt_usuario = '".$_SESSION["sesionLinks"]->usuario."' and xd_fechaEntrada = STR_TO_DATE('".date('Y-m-d')." ".date('H:i:s')."','%Y-%m-%d %H:%i:%s') ");
			while($r = $s->fetchRow()){
				$_SESSION["sesionLinksId"] = $r[0];
			}
			
			$LINKS_GE->Close();

			$_SESSION["sesionLinks"]->obtenOficinas();
			
			return true;
			
		}else{
			
			$_SESSION["sesionLinks"] = null;
			$_SESSION["sesionLinksId"] = null;
			
			return false;
		}
	}
	
	function actualizaSession(){
	}
	
	function cierraSession() {
		$LINKS_GE = new ConexionLinks();
		
		$LINKS_GE->Execute("update SESIONES_USUARIOS set xd_fechaSalida = STR_TO_DATE('".date('Y-m-d')." ".date('H:i:s')."','%Y-%m-%d %H:%i:%s') where xn_sesionId = ".$_SESSION["sesionLinksId"]." and xt_usuario = '".$_SESSION["sesionLinks"]->usuario."' ");
		
		$LINKS_GE->Close();
		
		unset($_SESSION["sesionLinks"]);
		
		//session_destroy();
		
		header("Location: ../../seleccionaSistema.php");
    }
	
	function cambiaOficina($oficina){
		$_SESSION["sesionLinks"]->oficina = $oficina;
	}
	
	
	function addBreadCrumb($ruta){
		if(! in_array($ruta,$_SESSION["sesionLinks"]->breadCrumbs)){
			array_push($_SESSION["sesionLinks"]->breadCrumbs, $ruta);
		}
	}
	
	function removeBreadCrumb($ruta){
		if(in_array($ruta, $_SESSION["sesionLinks"]->breadCrumbs)){
			$indice = array_search($ruta, $_SESSION["sesionLinks"]->breadCrumbs);
			array_splice($_SESSION["sesionLinks"]->breadCrumbs, $indice);
		}
	}

	function generarBreadCrumbs($breadcrumps) {
		foreach ($breadcrumps as $breadcrump) {
			$this->addBreadCrumb($breadcrump);
		}
	}

	function limpiarBreadCrumbs($breadcrumps) {
		foreach ($breadcrumps as $breadcrump) {
			$this->removeBreadCrumb($breadcrump);
		}
	}
	
	function showBreadCrumbs(){

		$enlaces = array();

		for($a=0; $a<count($_SESSION["sesionLinks"]->breadCrumbs); $a++){
			$tmp = explode(":", $_SESSION["sesionLinks"]->breadCrumbs[$a]);
			$enlaces[$a] = "<a href='".$tmp[1]."'>".$tmp[0]."</a>";
		}
		
		return implode( " / " , $enlaces);
	}
}

?>
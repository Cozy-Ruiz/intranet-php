<?php

require_once("../DataBase/conexionLinks.php");
require_once("../DataBase/conexionMaster.php");

class Usuario {
	
    var $usuario;
    var $nombre;
    var $correo;
   	var $fechaActualizacionPerfil;
    var $ipActualizacionPerfil;
	var $estilo;
    var $fechaCambioPassword;
	var $estatus;
    var $empresa;
	var $foto;
    var $puesto;
	var $extension;
	var $numPersonal;
    var $tipo;
	var $oficina;
	var $rol;
	var $breadCrumbs = array();
	var $oficinasDisponibles = array();
	var $permisos = array();
	
	
    function iniciaUsuario($User, $Pass) {
		
		$LINKS = new ConexionLinks();
		
    	$s = $LINKS->Query("SELECT u.*,
							(select o.XT_OFICINA from OFICINAS o where o.XT_USUARIO = u.XT_USUARIO and XT_STATUS = 'Default')	 
							FROM USUARIOS u
							where u.xt_usuario = '".$User."' 
							and u.XT_PASSWORD='".$Pass."' ");
    	echo "SELECT u.*,
							(select o.XT_OFICINA from OFICINAS o where o.XT_USUARIO = u.XT_USUARIO and XT_STATUS = 'Default')	 
							FROM USUARIOS u
							where u.xt_usuario = '".$User."' 
							and u.XT_PASSWORD='".$Pass."' ";
		while($r = $s->fetchRow()){
			$this->usuario = $r[0];
			$this->nombre = $r[2];
			$this->correo = $r[3];
			$this->fechaActualizacionPerfil = $r[4];
			$this->ipActualizacionPerfil = $r[5];
			$this->estilo = $r[6];
			$this->fechaCambioPassword = $r[7];
			$this->estatus = $r[8];
			$this->empresa = $r[9];
			$this->foto = $r[10];
			$this->puesto = $r[11];
			$this->extension = $r[12];
			$this->numPersonal = $r[13];
			$this->tipo = $r[14];
			$this->oficina = $r[15];
			
		}
		
		$LINKS->Close();
    }
	
	function registraUsuario($User) {
		
		$LINKS = new ConexionLinks();
		
    	$s = $LINKS->Query("SELECT u.*,
							(select o.XT_OFICINA from OFICINAS o where o.XT_USUARIO = u.XT_USUARIO and XT_STATUS = 'Default')	 
							FROM USUARIOS u
							where u.xt_usuario = '".$User."' ");
		while($r = $s->FetchRow()){
			$this->usuario = $r[0];
			$this->nombre = $r[2];
			$this->correo = $r[3];
			$this->fechaActualizacionPerfil = $r[4];
			$this->ipActualizacionPerfil = $r[5];
			$this->estilo = $r[6];
			$this->fechaCambioPassword = $r[7];
			$this->estatus = $r[8];
			$this->empresa = $r[9];
			$this->foto = $r[10];
			$this->puesto = $r[11];
			$this->extension = $r[12];
			$this->numPersonal = $r[13];
			$this->tipo = $r[14];
			$this->oficina = $r[15];
			
		}
		
		$LINKS->Close();
    }
	
	function obtenOficinaDefault() {
		$oficinaDefault = null;
		$LINKS = new ConexionLinks();
    	$s = $LINKS->Query("select XT_OFICINA from OFICINAS where XT_USUARIO = '".$this->usuario."' and XT_STATUS = 'Default' ");
		while($r=$s->FetchRow()){
			$oficinaDefault = $r['XT_OFICINA'];
		}
		$LINKS->Close();
		return $oficinaDefault;
    }
	
	function obtenOficinas() {
		$LINKS = new ConexionLinks();
    	$this->oficinasDisponibles = $LINKS->GetArray("select XT_OFICINA from OFICINAS where XT_USUARIO = '".$this->usuario."' ORDER BY XT_STATUS ");
		$LINKS->Close();
		
    }
	
	function obtenModulosOficina($oficina) {
		$LINKS = new ConexionLinks();
    	$s = $LINKS->GetArray("SELECT DISTINCT
									M .XT_MODULO,
									CM.XT_CONTROLADOR
								FROM
									MODULOS M,
									CATALOGO_MODULOS CM
								WHERE
									M.XT_USUARIO = '".$this->usuario."'
								AND M.XT_OFICINA = '".$oficina."'
								AND CM.XT_MODULO = M .XT_MODULO
								ORDER BY M.XT_MODULO
							");
		$LINKS->Close();
		
		return $s;
    }

    function obtenPermisosProceso($proceso){

    	$permisos = array();

    	$LINKS = new ConexionLinks();
    	$INTRANET = new conexionMaster();

    	$clientes = $this->obtenClientesProceso($proceso, $LINKS);
    	for($a=0; $a<count($clientes); $a++) {

    		$roles = $this->obtenRolesProceso($clientes[$a], $proceso, $LINKS);
    		for($b=0; $b<count($roles); $b++){

    			$actividades = $this->obtenActividades($roles[$b], $proceso, $INTRANET);
    			for($c=0; $c<count($actividades); $c++){

    				$funcionalidades = $this->obtenFuncionalidadesProceso($actividades[$c], $roles[$b], $proceso, $INTRANET);
    				for($d=0; $d<count($funcionalidades); $d++){

    					$permisos[$clientes[$a]][$roles[$b]][$actividades[$c]][$funcionalidades[$d]] = $d;
    				}
    			}
    		}
    	}

    	$LINKS->Close();
    	$INTRANET->Close();
		
    	$this->permisos = $permisos;

    }

    function obtenClientesProceso($proceso, $LINKS) {
		
		$clientes = null;

		//$LINKS = new ConexionLinks();
    	$clientes = $LINKS->GetCol("select XT_RFC from PROCESOS where XT_USUARIO = '".$this->usuario."' and XT_OFICINA = '".$this->oficina."' and XT_CODIGO_PROCESO = '$proceso' ");
		//$LINKS->Close();

		return $clientes;
    }
	
	function obtenRolesProceso($cliente, $proceso, $LINKS) {
		
		$roles = null;

		//$LINKS = new ConexionLinks();
    	$roles = $LINKS->GetCol("select XT_CODIGO_ROL from ROLES where XT_USUARIO = '".$this->usuario."' and XT_OFICINA = '".$this->oficina."' AND XT_RFC = '".$cliente."' and XT_CODIGO_PROCESO = '".$proceso."' ");
		//$LINKS->Close();

		return $roles;
    }
	/*
	function obtenRolesProceso($proceso) {
		
		$roles = null;

		$LINKS = new ConexionLinks();
    	$roles = $LINKS->GetCol("select XT_CODIGO_ROL from ROLES where XT_USUARIO = '".$this->usuario."' and XT_OFICINA = '".$this->oficina."' and XT_CODIGO_PROCESO = '$proceso' ");
		$LINKS->Close();

		return $roles;
    }*/

    function obtenActividades($rol, $proceso, $INTRANET) {
		
		$actividades = null;

		//$INTRANET = new conexionMaster();
    	$actividades = $INTRANET->GetCol("SELECT
												xt_codigoActividad
											FROM
												INTRANET2.SGI_Actividades
											WHERE
												xt_codigoProceso = '".$proceso."'
											AND xt_codigoRol = '".$rol."' 
										");
		//$INTRANET->Close();

		return $actividades;
    }

    function obtenFuncionalidadesProceso($actividad, $rol, $proceso, $INTRANET) {
		
		$funcionalidades = null;

		//$INTRANET = new conexionMaster();
    	$funcionalidades = $INTRANET->GetCol("SELECT
													xt_codigoFuncionalidad
												FROM
													INTRANET2.SGI_Funcionalidades
												WHERE
													xt_codigoProceso = '".$proceso."'
												AND xt_codigoRol = '".$rol."'
												and xt_codigoActividad = '".$actividad."'
											");
		//$INTRANET->Close();

		return $funcionalidades;
    }
	
	function obtenProcesosModulo($oficina, $modulo) {
		$LINKS = new ConexionLinks();
		$procesos = null;
    	$procesos = $LINKS->GetArray("select XT_PROCESO from MODULOS where XT_USUARIO = '".$this->usuario."' and XT_OFICINA = '$oficina' and XT_MODULO = '$modulo' ");
		$LINKS->Close();
		return $procesos;
    }
	
	function obtenActividadesProceso($oficina, $proceso) {
		$LINKS = new ConexionLinks();
		$actividades = array();
    	$actividades = $LINKS->GetArray("SELECT XT_CODIGO_ACTIVIDAD, XT_ACTIVIDAD, XT_CODIGO_ROL FROM ACTIVIDADES where XT_USUARIO = '".$this->usuario."' and XT_OFICINA = '$oficina' and XT_CODIGO_PROCESO = '$proceso' order by XT_CODIGO_ACTIVIDAD ");
		$LINKS->Close();
		return $actividades;
    }
	
	function obtenFuncionalidadesRol($oficina, $proceso, $rol) {
		$LINKS = new ConexionLinks();
		$funcionalidades = array();
    	$funcionalidades = $LINKS->GetCol("SELECT XT_CODIGO_FUNCIONALIDAD FROM FUNCIONALIDADES where XT_USUARIO = '".$this->usuario."' and XT_OFICINA = '$oficina' and XT_CODIGO_PROCESO = '$proceso' and XT_CODIGO_ROL = '$rol' ");
		$LINKS->Close();
		return $funcionalidades;
    }
	
	/*
	function obtenClientesOficina($oficina) {
		$LINKS = new ConexionLinks();
		$clientes = array();
    	$clientes = $LINKS->GetCol("SELECT XT_RFC FROM CLIENTES where XT_USUARIO = '".$this->usuario."' and XT_OFICINA = '$oficina' ");
		$LINKS->Close();
		return $clientes;
    }
	*/
}

?>
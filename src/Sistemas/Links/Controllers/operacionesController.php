<?php
	require_once('../Models/Session.php');
	require_once('../Models/Usuario.php');
	require_once('../Models/Operaciones.php');
	require_once('../Views/proceso/Operaciones/tableroOperaciones.php');
	require_once('../Views/proceso/Operaciones/funcionalidadesOperaciones.php');
	require_once('../Views/proceso/Operaciones/DatosGenerales/datosGenerales.php');
	require_once('../Views/proceso/Operaciones/InicioDeOperacion/inicioOperacion.php');
	require_once('../Views/proceso/Operaciones/Previo/previo.php');
	require_once('../Views/proceso/Operaciones/IntegracionDelExpediente/integracionExpediente.php');
	require_once('../Views/proceso/Operaciones/Pago/pago.php');
	require_once('../Views/proceso/Operaciones/SalidaCruce/salidaCruce.php');

	$session = new Session();
	$breadcrumps = array(
		'Home Page:homePageController.php',
		'Tablero de operaciones :operacionesController.php'
	);

	if ($session->compruebaUsuario() == true) {
		$session->limpiarBreadCrumbs($breadcrumps);
	}

	$tituloEscritorio = "Operaciones";


	if (isset($_REQUEST["evento"])) {

		if ($_REQUEST["evento"] == "CierraSession") {
			$session = new Session();
			$session->cierraSession();
		}

		$referencia = $_REQUEST['referencia'];
		$oficina = $_SESSION["sesionLinks"]->oficina;

		if ($_REQUEST['evento'] == "Expediente" && isset($referencia) ) {

			$tituloEscritorio = "Expediente ".$referencia;
			$session->generarBreadCrumbs($breadcrumps);
			
			$funcionalidadesOperaciones = new FuncionalidadesOperaciones();
			$tableroOperaciones = new TableroOperaciones();
			$datosGenerales = new DatosGenerales();

			$current_tab = "Expediente";
			$titulo = "Datos generales";
			$htmlMenu = "";
			$barraFuncionalidades = $funcionalidadesOperaciones->generaFuncionalidades($referencia,$current_tab);
			$htmlDatosGenerales = $datosGenerales->generaDatosGenerales($referencia);
			$html  = $tableroOperaciones->iniciaTablero($htmlDatosGenerales);
			$html .= $tableroOperaciones->estructura($titulo, $htmlMenu, $htmlDatosGenerales);
			$arrayFinal[0] = $html;

			require("../Views/templates/escritorio.php");
		}

		// Eventos *** Datos Generales ***
		if($_REQUEST['evento'] == "generaDatosGenerales" && isset($referencia)){
			$datosGenerales = new DatosGenerales();
			$htmlDatosGenerales = $datosGenerales->generaDatosGenerales($referencia);
			echo $htmlDatosGenerales;
		}

		if ($_REQUEST['evento'] == "InicioOperacion" && isset($referencia)) {

			$tituloEscritorio = "Expediente ".$referencia;
			$session->generarBreadCrumbs($breadcrumps);
			$oficina = $_SESSION["sesionLinks"]->oficina;
			$current_tab = $_REQUEST['evento'];
			
			$funcionalidadesOperaciones = new FuncionalidadesOperaciones();
			$tableroOperaciones = new TableroOperaciones();
			$operaciones = new DatosOperaciones();
			$barraFuncionalidades = $funcionalidadesOperaciones->generaFuncionalidades($referencia,$current_tab);
			$titulo = 'Inicio';
			$listadoTabs =  $operaciones->obtieneListadoTabs($oficina);
			$htmlMenu = $tableroOperaciones->muestraTabsInicioGuias($referencia, $listadoTabs, $oficina);
			$htmlDatos = "";

			if ($_REQUEST['pestaña'] == "generaCargaFacturas" && isset($referencia)) {
				$inicioOperacion = new InicioOperacion();
				$htmlDatos = $inicioOperacion->generaCargaFacturas($referencia);
			}
			
			$html .= $tableroOperaciones->iniciaTablero();
			$html .= $tableroOperaciones->estructura($titulo , $htmlMenu, $htmlDatos);
			$arrayFinal[0] = $html;

			require("../Views/templates/escritorio.php");
		}

		if ($_REQUEST['evento'] == "Previos" && isset($referencia)) {

			$tituloEscritorio = "Expediente ".$referencia;
			$session->generarBreadCrumbs($breadcrumps);
			$oficina = $_SESSION["sesionLinks"]->oficina;
			$current_tab = $_REQUEST['evento'];
			
			$funcionalidadesOperaciones = new FuncionalidadesOperaciones();
			$tableroOperaciones = new TableroOperaciones();
			$operaciones = new DatosOperaciones();
			$barraFuncionalidades = $funcionalidadesOperaciones->generaFuncionalidades($referencia,$current_tab);
			$titulo = 'Previos';
			$listadoTabs =  $operaciones->obtieneListadoTabs($oficina);
			$htmlMenu = $tableroOperaciones->muestraTabsPrevio($referencia, $listadoTabs, $oficina);
			$htmlDatos = "";

			if ($_REQUEST['pestaña'] == "generaCargaFacturas" && isset($referencia)) {
				$inicioOperacion = new InicioOperacion();
				$htmlDatos = $inicioOperacion->generaCargaFacturas($referencia);
			}
			
			$html .= $tableroOperaciones->iniciaTablero();
			$html .= $tableroOperaciones->estructura($titulo , $htmlMenu, $htmlDatos);
			$arrayFinal[0] = $html;

			require("../Views/templates/escritorio.php");
		}

		if ($_REQUEST['evento'] == "IntegracionExpediente" && isset($referencia)) {

			$tituloEscritorio = "Expediente ".$referencia;
			$session->generarBreadCrumbs($breadcrumps);
			$current_tab = $_REQUEST['evento'];

			$funcionalidadesOperaciones = new FuncionalidadesOperaciones();
			$barraFuncionalidades = $funcionalidadesOperaciones->generaFuncionalidades($referencia,$current_tab);

			$tableroOperaciones = new TableroOperaciones();
			$titulo = 'Integración';
			$htmlDatos = "";
			$oficina = $_SESSION["sesionLinks"]->oficina;
			$operaciones = new DatosOperaciones();
			$listadoTabs =  $operaciones->obtieneListadoTabs($oficina);

			if ($_REQUEST['pestaña'] == "generaCargaFacturas" && isset($referencia)) {
				$inicioOperacion = new InicioOperacion();
				$htmlDatos = $inicioOperacion->generaCargaFacturas($referencia);
			}
			$htmlMenu = $tableroOperaciones->muestraTabsPrevio($referencia, $listadoTabs, $oficina);

			$html .= $tableroOperaciones->iniciaTablero();
			$html .= $tableroOperaciones->estructura($titulo , $htmlMenu, $htmlDatos);
			$arrayFinal[0] = $html;

			require("../Views/templates/escritorio.php");
		}

		if ($_REQUEST['evento'] == "ValidacionPago" && isset($referencia)) {

			$tituloEscritorio = "Expediente ".$referencia;
			$session->generarBreadCrumbs($breadcrumps);
			$oficina = $_SESSION["sesionLinks"]->oficina;
			$current_tab = $_REQUEST['evento'];
			
			$funcionalidadesOperaciones = new FuncionalidadesOperaciones();
			$tableroOperaciones = new TableroOperaciones();
			$operaciones = new DatosOperaciones();
			$barraFuncionalidades = $funcionalidadesOperaciones->generaFuncionalidades($referencia,$current_tab);
			$titulo = 'Pago';
			$listadoTabs =  $operaciones->obtieneListadoTabs($oficina);
			$htmlMenu = $tableroOperaciones->muestraTabsPrevio($referencia, $listadoTabs, $oficina);
			$htmlDatos = "";

			if ($_REQUEST['pestaña'] == "generaCargaFacturas" && isset($referencia)) {
				$inicioOperacion = new InicioOperacion();
				$htmlDatos = $inicioOperacion->generaCargaFacturas($referencia);
			}
			
			$html .= $tableroOperaciones->iniciaTablero();
			$html .= $tableroOperaciones->estructura($titulo , $htmlMenu, $htmlDatos);
			$arrayFinal[0] = $html;

			require("../Views/templates/escritorio.php");
		}

		if ($_REQUEST['evento'] == "CruceSalida" && isset($referencia)) {

			$tituloEscritorio = "Expediente ".$referencia;
			$session->generarBreadCrumbs($breadcrumps);
			$oficina = $_SESSION["sesionLinks"]->oficina;
			$current_tab = $_REQUEST['evento'];
			
			$funcionalidadesOperaciones = new FuncionalidadesOperaciones();
			$tableroOperaciones = new TableroOperaciones();
			$operaciones = new DatosOperaciones();
			$barraFuncionalidades = $funcionalidadesOperaciones->generaFuncionalidades($referencia,$current_tab);
			$titulo = 'Cruce y salida';
			$listadoTabs =  $operaciones->obtieneListadoTabs($oficina);
			$htmlMenu = $tableroOperaciones->muestraTabsPrevio($referencia, $listadoTabs, $oficina);
			$htmlDatos = "";

			if ($_REQUEST['pestaña'] == "generaCargaFacturas" && isset($referencia)) {
				$inicioOperacion = new InicioOperacion();
				$htmlDatos = $inicioOperacion->generaCargaFacturas($referencia);
			}
			
			$html .= $tableroOperaciones->iniciaTablero();
			$html .= $tableroOperaciones->estructura($titulo , $htmlMenu, $htmlDatos);
			$arrayFinal[0] = $html;

			require("../Views/templates/escritorio.php");
		}

		// Eventos *** Inicio de Operación ***
		if ($_REQUEST['evento'] == "generaCargaFacturas"  && isset($referencia) && isset($oficina)) {
			$inicioOperacion = new InicioOperacion();
			$html = $inicioOperacion->generaCargaFacturas($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaCapturaPermisos"  && isset($referencia)) {
			$inicioOperacion = new InicioOperacion();
			$html = $inicioOperacion->generaCapturaPermisos($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaDocumentos"  && isset($referencia)) {
			$inicioOperacion = new InicioOperacion();
			$html = $inicioOperacion->generaDocumentos($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaFotografias"  && isset($referencia)) {
			$inicioOperacion = new InicioOperacion();
			$html = $inicioOperacion->generaFotografias($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaAgrupacion"  && isset($referencia)) {
			$inicioOperacion = new InicioOperacion();
			$html = $inicioOperacion->generaAgrupacion($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaClasificacion"  && isset($referencia)) {
			$inicioOperacion = new InicioOperacion();
			$html = $inicioOperacion->generaClasificacion($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaProforma"  && isset($referencia)) {
			$inicioOperacion = new InicioOperacion();
			$html = $inicioOperacion->generaProforma($referencia);
			echo $html;
		}

		// Eventos *** Previo ***
		if ($_REQUEST['evento'] == "generaPrevio1" && isset($referencia)) {
			$previo = new Previo();
			$html = $previo->generaPrevio1($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaPrevio2" && isset($referencia)) {
			$previo = new Previo();
			$html = $previo->generaPrevio2($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaPrevio3" && isset($referencia)) {
			$previo = new Previo();
			$html = $previo->generaPrevio3($referencia);
			echo $html;
		}

		// Eventos *** Integración del Expediente ***
		if ($_REQUEST['evento'] == "generaIntegracionExpediente1" && isset($referencia)) {
			$integracionExpediente = new IntegracionExpediente();
			$html = $integracionExpediente->generaIntegracionExpediente1($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaIntegracionExpediente2" && isset($referencia)) {
			$integracionExpediente = new IntegracionExpediente();
			$html = $integracionExpediente->generaIntegracionExpediente2($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaIntegracionExpediente3" && isset($referencia)) {
			$integracionExpediente = new IntegracionExpediente();
			$html = $integracionExpediente->generaIntegracionExpediente3($referencia);
			echo $html;
		}

		// Eventos *** Pago ***
		if ($_REQUEST['evento'] == "generaPago1" && isset($referencia)) {
			$pago = new Pago();
			$html = $pago->generaPago1($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaPago2" && isset($referencia)) {
			$pago = new Pago();
			$html = $pago->generaPago2($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaPago3" && isset($referencia)) {
			$pago = new Pago();
			$html = $pago->generaPago3($referencia);
			echo $html;
		}

		// Eventos *** Salida y Cruce ***
		if ($_REQUEST['evento'] == "generaSalidaCruce1" && isset($referencia)) {
			$salidaCruce = new SalidaCruce();
			$html = $salidaCruce->generaSalidaCruce1($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaSalidaCruce2" && isset($referencia)) {
			$salidaCruce = new SalidaCruce();
			$html = $salidaCruce->generaSalidaCruce2($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "generaSalidaCruce3" && isset($referencia)) {
			$salidaCruce = new SalidaCruce();
			$html = $salidaCruce->generaSalidaCruce3($referencia);
			echo $html;
		}

		// Tabs
		if ($_REQUEST['evento'] == "muestraTabsInicioGuias" && isset($referencia)) {
			$tableroOperaciones = new TableroOperaciones();

			$oficina = $_SESSION["sesionLinks"]->oficina;
			$operaciones = new DatosOperaciones();
			$listadoTabs =  $operaciones->obtieneListadoTabs($oficina);

			$html = $tableroOperaciones->muestraTabsInicioGuias($referencia, $listadoTabs, $oficina);
			echo $html;
		}
		if ($_REQUEST['evento'] == "muestraTabsPrevio" && isset($referencia) ) {
			$tableroOperaciones = new TableroOperaciones();
			$html = $tableroOperaciones->muestraTabsPrevio($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "muestraTabsIntegracionExpediente" && isset($referencia) ) {
			$tableroOperaciones = new TableroOperaciones();
			$html = $tableroOperaciones->muestraTabsIntegracionExpediente($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "muestraTabsPago" && isset($referencia) ) {
			$tableroOperaciones = new TableroOperaciones();
			$html = $tableroOperaciones->muestraTabsPago($referencia);
			echo $html;
		}
		if ($_REQUEST['evento'] == "muestraTabsSalidaCruce" && isset($referencia) ) {
			$tableroOperaciones = new TableroOperaciones();
			$html = $tableroOperaciones->muestraTabsSalidaCruce($referencia);
			echo $html;
		}
	}else {

		$session->generarBreadCrumbs(array(
			'Home Page:homePageController.php'
		));

		$tableroOperaciones = new TableroOperaciones();
		$funcionalidadesOperaciones = new FuncionalidadesOperaciones();
		$barraFuncionalidades = $funcionalidadesOperaciones->generaFuncionalidadesTableroOperaciones();

		$html = $tableroOperaciones->iniciaTablero();
		$html .= $tableroOperaciones->generaTabla();
		$arrayFinal[0] = $html;
		require("../Views/templates/escritorio.php");

	}
?>

<?php

	ini_set('memory_limit', '20000M');
	ini_set('max_execution_time', 300);

	require_once('../Models/Session.php');
	require_once('../Models/Usuario.php');
	require_once('../Models/Validacion_Pago_PECE.php');
	require_once('../Views/proceso/Validacion_Pago_PECE/tableroVP.php');
	require_once('../Views/proceso/Validacion_Pago_PECE/detalleVP.php');
	
	$session = new Session();
	
	if($session->compruebaUsuario() == true){
		$breadCrumbValidacion = "Validación:validacionController.php";
		$session->removeBreadCrumb($breadCrumbValidacion);
				
		$breadCrumbModulos = "Módulos:modulosController.php";
		$session->addBreadCrumb($breadCrumbModulos);
	}
	


	$proceso = "K0021"; //Generar CFDI de exportación
	$_SESSION["sesionLinks"]->obtenPermisosProceso($proceso);

	$tituloEscritorio = "Prevalidación / Validación / Pago";
	
	if(isset($_REQUEST["evento"])){
		
		//Evento de Cierre de Session
		if($_REQUEST["evento"] == "CierraSession"){
			$session = new Session();
			$session->cierraSession();
		}

		if($_REQUEST['evento'] == "registraCambioPeca"){

			if(isset($_REQUEST['referencia'], $_REQUEST['personalAutoriza'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->registraCambioPeca($_REQUEST['referencia'], $_REQUEST['personalAutoriza']);
				
			}else{
				echo "Parametros faltantes para registro de cambio PECA";
			}
		}

		if($_REQUEST['evento'] == "muestraCambioPeca"){
			if(isset($_REQUEST['referencia'])){

				$detalleVP = new DetalleVP;
				$detalleVP->generaCambioPeca($_REQUEST['referencia']);
				
			}else{
				echo "Parametros faltantes para cambio PECA";
			}
		}

		if($_REQUEST['evento'] == "eliminaReferencia"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->eliminaReferencia($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para eliminar referencia";
			}
		}

		if($_REQUEST['evento'] == "enviaCancelar"){
			if(isset($_REQUEST['referencia'], $_REQUEST['prevalidador'], $_REQUEST['prevalidadorNombre'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaCancelar($_REQUEST['referencia'], $_REQUEST['prevalidador'], $_REQUEST['prevalidadorNombre']);

			}else{
				echo "Parametros faltantes para cancelar firma";
			}
		}

		if($_REQUEST['evento'] == "paraGenerarCancelacion"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->paraGenerarCancelacion($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros Faltantes para estatus Generar cancelacion";
			}
		}

		if($_REQUEST['evento'] == "paraReprocesarPago"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->paraReprocesarPago($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros Faltantes para reprocesar pago.";
			}
		}

		if($_REQUEST['evento'] == "paraGenerarE"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->paraGenerarE($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros Faltantes para estatus Generar E";
			}
		}

		if($_REQUEST['evento'] == "saltaCargaEvidenciaSOIA"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->saltaCargaEvidenciaSOIA($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para saltar a completar datos";
			}
		}

		if($_REQUEST['evento'] == "registraDatosPagoSinA"){
			if(isset($_REQUEST['referencia'], $_REQUEST['operacionBancaria'], $_REQUEST['transaccionSAT'], $_REQUEST['fechaPago'], $_REQUEST['horaPago'], $_REQUEST['turno'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->registraDatosPagoSinA($_REQUEST['referencia'], $_REQUEST['operacionBancaria'], $_REQUEST['transaccionSAT'], $_REQUEST['fechaPago'], $_REQUEST['horaPago'], $_REQUEST['turno']);

			}else{
				echo "Parametros faltantes para registrar datos de pago.";
			}
		}

		if($_REQUEST['evento'] == "saltaCompletarDatosPagoSinA"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->saltaCompletarDatosPagoSinA($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para saltar a completar datos";
			}
		}

		if($_REQUEST['evento'] == "muestraCargaReciboPago"){
			if(isset($_REQUEST['referencia'])){
				
				$detalleVP = new DetalleVP;
				$detalleVP->generaCargaReciboPago($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo A";
			}
		}

		if($_REQUEST['evento'] == "saltoGeneracionDocumentos"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->saltoGeneracionDocumentos($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar recibo pago";
			}
		}

		if($_REQUEST['evento'] == "cargaReciboPago"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaReciboPago($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar recibo pago";
			}
		}

		if($_REQUEST['evento'] == "registraDatosPago"){
			if(isset($_REQUEST['referencia'], $_REQUEST['operacionBancaria'], $_REQUEST['transaccionSAT'], $_REQUEST['fechaPago'], $_REQUEST['horaPago'], $_REQUEST['turno'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->registraDatosPago($_REQUEST['referencia'], $_REQUEST['operacionBancaria'], $_REQUEST['transaccionSAT'], $_REQUEST['fechaPago'], $_REQUEST['horaPago'], $_REQUEST['turno']);

			}else{
				echo "Parametros faltantes para registrar datos de pago.";
			}
		}

		if($_REQUEST['evento'] == "cargaArchivoEvidenciaSOIA"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaArchivoEvidenciaSOIA($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo A";
			}
		}

		if($_REQUEST['evento'] == "cargaArchivoA"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaArchivoA($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo A";
			}
		}

		if($_REQUEST['evento'] == "muestraCargaArchivoA"){
			if(isset($_REQUEST['referencia'])){
				
				$detalleVP = new DetalleVP;
				$detalleVP->generaCargaArchivoA($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo A";
			}
		}

		if($_REQUEST['evento'] == "cargaArchivoE"){

			if(isset($_REQUEST['referencia'])){
				
				
				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaArchivoE($_REQUEST['referencia']);
				
			}else{
				echo "Parametros faltantes para cargar Archivo E";
			}
		}

		if($_REQUEST['evento'] == "muestraCargaArchivoE"){
			if(isset($_REQUEST['referencia'])){
				
				$detalleVP = new DetalleVP;
				$detalleVP->generaCargaArchivoE($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo E";
			}
		}

		if($_REQUEST['evento'] == "cargaArchivoERR"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaArchivoERR($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo ERR";
			}
		}

		if($_REQUEST['evento'] == "muestraCargaArchivoERR"){
			if(isset($_REQUEST['referencia'])){
				
				$detalleVP = new DetalleVP;
				$detalleVP->generaCargaArchivoERR($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo ERR";
			}
		}

		if($_REQUEST['evento'] == "cargaArchivoM"){

			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaArchivoM($_REQUEST['referencia']);
				
			}else{
				echo "Parametros faltantes para cargar Archivo M";
			}

		}

		if($_REQUEST['evento'] == "muestraCargaArchivoM"){
			if(isset($_REQUEST['referencia'])){
				
				$detalleVP = new DetalleVP;
				$detalleVP->generaCargaArchivoM($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para cargar Archivo M";
			}
		}

		if($_REQUEST['evento'] == "registraAutorizacionContabilidadPago"){
			if(isset($_REQUEST['referencia'])){
				
				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->registraAutorizacionContabilidadPago($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para registrar autorizacion de Contabilidad";
			}
		}

		if($_REQUEST['evento'] == "cargaArchivoValidador"){
			if(isset($_REQUEST['referencia'])){
				if (!empty($_FILES)) {

					$storeFolder = '../tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/VALIDADOR/'.$_REQUEST["referencia"].'/';
		
					if (!file_exists($storeFolder)) {
						mkdir($storeFolder, 0777, true);
					}

					$tempFile = $_FILES['file']['tmp_name']; 

					$nombreRealArchivo = $_FILES['file']['name'];  
				 
					$targetFile =  "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/VALIDADOR/".$_REQUEST["referencia"].'/'.$nombreRealArchivo; 
			 
					$upload_success = move_uploaded_file($tempFile,$targetFile); 
				
					if($upload_success) {
						$Validacion_Pago = new Validacion_Pago;
						$Validacion_Pago->cargaArchivoValidador($_REQUEST['referencia'], $targetFile, $nombreRealArchivo);
					}//fin del proceso de subir los archivoa laredo
			
				}
			}else{
				echo "Parametros faltantes para subir archivo";
			}
		}

		if($_REQUEST['evento'] == "agregaDropZone"){
			if(isset($_REQUEST['referencia'])){
				$detalleVP = new DetalleVP;
				$detalleVP->generaDropZone($_REQUEST['referencia']);
			}else{
				echo "Parametros faltantes para crear DropZone";
			}
		}
		
		if($_REQUEST['evento'] == "muestraArchivos"){
			if(isset($_REQUEST['datosReferencia'], $_REQUEST['session'])){

				$caracteres = array("\'", '\"', "'");
				$datosReferencia = json_decode(str_replace($caracteres,'"', $_REQUEST['datosReferencia']));
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$Validacion_Pago = new Validacion_Pago;
				$archivos = $Validacion_Pago->obtenArchivos($datosReferencia, $session);

				$detalleVP = new DetalleVP;
				$detalleVP->muestraArchivos($datosReferencia, $archivos, $session);

			}else{
				echo "Parametros faltantes para enviar a liberar";
			}
		}

		if($_REQUEST['evento'] == "generaDetalle"){
			
			if(isset($_REQUEST['datosReferencia'], $_REQUEST['session'])){

				$caracteres = array("\'", '\"', "'");
				$datosReferencia = json_decode(str_replace($caracteres,'"', $_REQUEST['datosReferencia']));
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$detalleVP = new DetalleVP;
				$detalleVP->generaDetalle($datosReferencia, $datosReferencia[6], $session);
				
			}else{
				echo "Parametros faltantes para enviar a liberar";
			}
		}
		
		if($_REQUEST['evento'] == "enviaLiberar"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaLiberar($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para enviar a liberar";
			}
		}
		
		if($_REQUEST['evento'] == "enviaImprimir"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaImprimir($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para enviar a liberar";
			}
		}
		
		if($_REQUEST['evento'] == "reintentoPagar"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->reintentoPagar($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para reintentar pagar";
			}
		}

		if($_REQUEST['evento'] == "reintentoValidar"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->reintentoValidar($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para reintentar validar";
			}
		}
		
		if($_REQUEST['evento'] == "reintentoPrevalidar"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->reintentoPrevalidar($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para reintentar prevalidar";
			}
		}

		if($_REQUEST['evento'] == "cerrarConsolidado"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cerrarConsolidado($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para generar cerrar consolidado";
			}
		}

		if($_REQUEST['evento'] == "enviaGenerarAvisoConsolidado"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaGenerarAvisoConsolidado($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para generar Aviso Consolidado";
			}
		}
		
		if($_REQUEST['evento'] == "enviaGenerarSimplificadoDesistimiento"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaGenerarSimplificadoDesistimiento($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para generar Simplificado Desistimiento";
			}
		}

		if($_REQUEST['evento'] == "enviaGenerarSimplificado"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaGenerarSimplificado($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para generar Simplificado";
			}
		}

		if($_REQUEST['evento'] == "enviaPagar"){
			if(isset($_REQUEST['referencia'], $_REQUEST['session'], $_REQUEST['validador'], $_REQUEST['validadorNombre'])){

				$caracteres = array("\'", '\"', "'");
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaPagar($_REQUEST['referencia'], $session, $_REQUEST['validador'], $_REQUEST['validadorNombre']);

			}else{
				echo "Parametros faltantes para enviar a pagar";
			}
		}

		if($_REQUEST['evento'] == "reGenerarE"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->reGenerarE($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para reGenerar E";
			}
		}

		if($_REQUEST['evento'] == "enviaGenerarE_RECTI"){
			if(isset($_REQUEST['referencia'], $_REQUEST['session'], $_REQUEST['claveBanco'], $_REQUEST['claveCuenta'], $_REQUEST['tipoCuenta'])){

				$caracteres = array("\'", '\"', "'");
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaGenerarE_RECTI($_REQUEST['referencia'], $session, $_REQUEST['claveBanco'], $_REQUEST['claveCuenta'], $_REQUEST['tipoCuenta']);

			}else{
				echo "Parametros faltantes para enviar a pagar";
			}
		}
		
		if($_REQUEST['evento'] == "enviaGenerarE"){
			if(isset($_REQUEST['referencia'], $_REQUEST['session'], $_REQUEST['claveBanco'], $_REQUEST['claveCuenta'], $_REQUEST['tipoCuenta'])){

				$caracteres = array("\'", '\"', "'");
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$Validacion_Pago = new Validacion_Pago;
			$Validacion_Pago->enviaGenerarE($_REQUEST['referencia'], $session, $_REQUEST['claveBanco'], $_REQUEST['claveCuenta'], $_REQUEST['tipoCuenta']);

			}else{
				echo "Parametros faltantes para enviar a pagar";
			}
		}

		if($_REQUEST['evento'] == "enviaDesistir"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaDesistir($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para enviar a desistir";
			}
		}

		if($_REQUEST['evento'] == "enviaValidar"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaValidar($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para enviar a validar";
			}
		}

		if($_REQUEST['evento'] == "enviaPrevalidar"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaPrevalidar($_REQUEST['referencia']);

			}else{
				echo "Parametros faltantes para enviar a prevalidar";
			}
		}

		if($_REQUEST['evento'] == "enviaGenerarM_Desistimiento"){
			if(isset($_REQUEST['referencia'], $_REQUEST['curp'], $_REQUEST['prevalidador'], $_REQUEST['prevalidadorNombre'])){

				$Validacion_Pago = new Validacion_Pago;
				$causante = $Validacion_Pago->obtenCausante($_REQUEST['referencia'], $_REQUEST['curp'], $_SESSION["sesionLinks"]);
				
				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaGenerarM_Desistimiento($_REQUEST['referencia'], $causante, $_REQUEST['prevalidador'], $_SESSION["sesionLinks"], $_REQUEST['prevalidadorNombre']);

			}else{
				echo "Parametros faltantes para enviar a generar M Desistimiento";
			}
		}
		
		if($_REQUEST['evento'] == "enviaGenerarM_RECTI"){
			if(isset($_REQUEST['referencia'], $_REQUEST['curp'], $_REQUEST['prevalidador'], $_REQUEST['prevalidadorNombre'])){

				$Validacion_Pago = new Validacion_Pago;
				$causante = $Validacion_Pago->obtenCausante($_REQUEST['referencia'], $_REQUEST['curp'], $_SESSION["sesionLinks"]);
				
				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaGenerarM_RECTI($_REQUEST['referencia'], $causante, $_REQUEST['prevalidador'], $_SESSION["sesionLinks"], $_REQUEST['prevalidadorNombre']);

			}else{
				echo "Parametros faltantes para enviar a generar M";
			}
		}

		if($_REQUEST['evento'] == "enviaGenerarM"){
			if(isset($_REQUEST['referencia'], $_REQUEST['curp'], $_REQUEST['prevalidador'], $_REQUEST['prevalidadorNombre'])){

				$Validacion_Pago = new Validacion_Pago;
				$causante = $Validacion_Pago->obtenCausante($_REQUEST['referencia'], $_REQUEST['curp'], $_SESSION["sesionLinks"]);
				
				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->enviaGenerarM($_REQUEST['referencia'], $causante, $_REQUEST['prevalidador'], $_SESSION["sesionLinks"], $_REQUEST['prevalidadorNombre']);

			}else{
				echo "Parametros faltantes para enviar a generar M";
			}
		}

		if($_REQUEST['evento'] == "actualizaReferencia"){
			if(isset($_REQUEST['referencia'], $_REQUEST['index'])){

				$referencia = $_REQUEST['referencia'];
				$index = $_REQUEST['index'];
				
				$Validacion_Pago = new Validacion_Pago;
				$datosReferencia  = $Validacion_Pago->obtenDatosReferencia($referencia);

				for($a=0; $a<count($datosReferencia); $a++){
					$detalleVP = new DetalleVP;
					$datosReferencia[$a][count($datosReferencia[$a])] = base64_encode($detalleVP->generaDetalle($datosReferencia[$a], $_SESSION["sesionLinks"]));
				}

				$tablero = new TableroVP;
			 	$tablero->generaRegistro($datosReferencia, $index);
				
			}else{
				echo "Parametros faltantes para actualizar datos";
			}
		}
		
		if($_REQUEST['evento'] == "actualizaDatos"){
			if(isset($_REQUEST['session'])){
				
				$caracteres = array("\'", '\"', "'");
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$Validacion_Pago = new Validacion_Pago;
				//$Validacion_Pago->obtenDatosActualizados($session);
				$Validacion_Pago->obtenDatosActualizados($_SESSION["sesionLinks"]);

			}else{
				echo "Parametros faltantes para actualizar datos";
			}
		}

		if($_REQUEST['evento'] == "cargaReferenciasDesistimiento"){
			if(isset($_REQUEST['referencias'], $_REQUEST['session'])){

				$caracteres = array("\'", '\"', "'");

				$referencias = json_decode(str_replace($caracteres,'"', $_REQUEST['referencias']));
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaReferenciasDesistimiento($referencias, $session);

			}else{
				echo "Parametros Faltantes para cargar Referencias desistimiento";
			}
		}

		
		if($_REQUEST['evento'] == "cargaReferencias"){
			if(isset($_REQUEST['referencias'], $_REQUEST['session'])){

				$caracteres = array("\'", '\"', "'");

				$referencias = json_decode(str_replace($caracteres,'"', $_REQUEST['referencias']));
				$session = json_decode(str_replace($caracteres,'"', $_REQUEST['session']));

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->cargaReferencias($referencias, $session);

			}else{
				echo "Parametros Faltantes para cargar Referencia";
			}
		}


		if($_REQUEST['evento'] == "paraGenerarM"){
			if(isset($_REQUEST['referencia'])){

				$Validacion_Pago = new Validacion_Pago;
				$Validacion_Pago->paraGenerarM($_REQUEST['referencia'], $_SESSION["sesionLinks"]);

			}else{
				echo "Parametros Faltantes para estatus Generar M";
			}
		}


		if($_REQUEST['evento'] == "generaHistorial"){
			if(isset($_REQUEST['datosHistorial'], $_REQUEST['session'])) {

			  	$caracteres = array("\'", '\"', "'");

			  	$datosHistorial = json_decode(str_replace($caracteres,"\"",$_REQUEST['datosHistorial']));
			  	$session = json_decode(str_replace($caracteres,"\"",$_REQUEST['session']), true);

			  	$historial = new HistorialVP;
			  	$historial->generaHistorial($datosHistorial, $session);
			  
			}else{
				echo "Parametros Faltantes para generar el historial";
			}
		}

		if($_REQUEST['evento'] == "actualizaTablero"){

			$Validacion_Pago = new Validacion_Pago;
			$datos = $Validacion_Pago->obtenDatosTablero($_SESSION["sesionLinks"]);
			
			echo json_encode($datos);
		}

		if($_REQUEST['evento'] == "generaTablero"){

			$caracteres = array("\'", "'", '\"');

			$titulo = "Referencias para prevalidar / validar / pagar";
			$campos = array('Referencia', 'Archivo M','Archivo E', '', 'Usuario', 'Acciones', 'Status');

			$Validacion_Pago = new Validacion_Pago;
			$datos = $Validacion_Pago->obtenDatosTablero($_SESSION["sesionLinks"]);
			
			for($a=0; $a<count($datos); $a++){
				$detalleVP = new DetalleVP;
				$datos[$a][count($datos[$a])] = base64_encode($detalleVP->generaDetalle($datos[$a], $_SESSION["sesionLinks"]));
			}

			$tablero = new TableroVP;
			$tablero->generaTablero($titulo, $campos, $datos, $_SESSION["sesionLinks"]);
			
		}
		
	}else{
		
		?>
		<script language='javascript' src="../Views/js/Validacion_Pago_PECE.js?v=1.5"></script>
		<?php
		
		
		$tableroVP = new TableroVP();
		$html = $tableroVP->iniciaTablero();
		$arrayFinal[0] = $html;
		
		$detalleVP = new DetalleVP();
		$html = $detalleVP->iniciaDetalle();
		$arrayFinal[1] =  $html;
		
		require("../Views/templates/escritorio.php");

		//$titulo = "Referencias para prevalidar / validar";
		//$campos = json_encode(array('Referencia', 'Archivo M','Archivo E', 'Usuario', 'Acciones', 'Status'));

		/*
		$VP = new Validacion_Pago;
		$clientesProceso = array_keys($_SESSION["sesionLinks"]->permisos);
		$datos = json_encode($VP->obtenDatosTableroInicial($_SESSION['sesionLinks']));
		*/

		echo "<script>";
		echo "generaTablero();";
		echo "var myVar = setInterval(function(){ actualizaTablero() }, 5000);";
		//echo "var myVar = setInterval(function(){ saluda('".json_encode($_SESSION["sesionLinks"])."') }, 10000);";

		echo "</script>";
		/*
		echo "<script>";
		echo "saluda('".json_encode($_SESSION["sesionLinks"])."');";
		echo "</script>";
		*/
	}
?>
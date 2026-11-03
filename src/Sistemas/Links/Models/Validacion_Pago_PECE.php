<?php
require_once("../DataBase/conexionValidacionPagoPECE.php");
require_once("../DataBase/conexionDODA.php");
require_once("../DataBase/conexionLinks.php");
require_once("../DataBase/conexionMaster.php");
require_once("../DataBase/conexionMexico.php");
require_once("../DataBase/conexionToluca.php");
require_once("../DataBase/conexionVeracruz.php");
require_once("../DataBase/conexionCancun.php");
require_once("../DataBase/conexionLaredo.php");
require_once('../Models/Mails.php');
//require_once("../../radar/1026/pedimentoXmlDell.php");

class Validacion_Pago{
	
    var $factura;
    var $referencia;
    var $rfc;
   	var $monto;
    var $estatus;
	var $opciones;

	function registraCambioPeca($referencia, $personalAutoriza){

		$ValidacionPagoDB = new conexionValidacionPago();
    	
		$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_PERSONAL_AUTORIZACION_PAGO = '".$personalAutoriza."' WHERE XT_REFERENCIA = '".$referencia."' ");

		$ValidacionPagoDB->Close();

	}

	function eliminaReferencia($referencia) {

    	$ValidacionPagoDB = new conexionValidacionPago();
    	
		$ValidacionPagoDB->Execute("DELETE FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' ");

		$ValidacionPagoDB->Close();
					
    }

	function cargaReferenciasDesistimiento($referencias, $session) {

		foreach ($referencias as $referencia) {

			if($referencia != ''){

				$ValidacionPagoDB = new ConexionValidacionPago();

				$registro = $ValidacionPagoDB->GetRow("SELECT XT_REFERENCIA, XT_USUARIO FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' ");


				if($registro != null){

					$datosReferencia = null;
					$conexionSCIA = null;
					$con_rec = "";

					if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

						$conexionSCIA = new ConexionSCIAMEX();
						$con_rec = "AND con_rec = 1";

					}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
						
						$conexionSCIA = new ConexionSCIALAR();

					}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
						
						$conexionSCIA = new ConexionSCIACUN();
						$con_rec = "AND con_rec = 1";

					}else if($_SESSION["sesionLinks"]->oficina == "VER"){
						
						$conexionSCIA = new ConexionSCIAVER();

					}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
						
						$conexionSCIA = new ConexionSCIATOL();

					}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
						
						$conexionSCIA = new ConexionSCIALAR();

					}


					$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_ESTATUS_DESISTIMIENTO = 'true' WHERE XT_REFERENCIA = '".$referencia."' ");
					$ValidacionPagoDB->Execute("DELETE FROM ESTATUS WHERE XT_REFERENCIA = '".$referencia."' AND XT_ESTATUS = 'Liberado' ");
					$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M Desistimiento', '".$_SESSION["sesionLinks"]->usuario."') ");

				}else{

					echo "La referencia ".$registro["XT_REFERENCIA"]." no existe registro de pago para desistimiento \n";

				}

				$ValidacionPagoDB->Close();
			}
			
		}
					
    }

	function enviaCancelar($referencia, $prevalidador, $prevalidadorNombre) {

		if($_SESSION["sesionLinks"]->oficina == "CDMX"){
			$conexionSCIA = new ConexionSCIAMEX();
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			$conexionSCIA = new ConexionSCIALAR();
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			$conexionSCIA = new ConexionSCIACUN();
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){	
			$conexionSCIA = new ConexionSCIATOL();
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			$conexionSCIA = new ConexionSCIAVER();
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			$conexionSCIA = new ConexionSCIALAR();
		}else if($_SESSION["sesionLinks"]->oficina == "QRO"){
			$conexionSCIA = new ConexionSCIAMEX();
		}else if($_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			$conexionSCIA = new ConexionSCIAMEX();
		}

		if (strpos($referencia, '_R') !== false) {
			$datos = $conexionSCIA->GetRow("
				SELECT
					P.CLAVEX,
					P.TIPO_MOVIMIENTO,
					G.PATENTE,
					P.PEDIMENTO,
					CONCAT( G.ADUANA, P.SECCION ) AS ADUANA,
					F.FIRMA,
					AV.ARCHIVO,
					AV.PREVALIDADOR
				FROM
					PEDIMENTO.RPEDIMENTOS P,
					PEDIMENTO.GENERAL G,
					PEDIMENTO.ADUANA A, 
					PEDIMENTO.FIRMAS F,
					PEDIMENTO.ARCHVALPAG AV
				WHERE
					P.clavex = G.clavex 
					AND F.clavex = P.clavex
					AND A.ADUANA = G.ADUANA 
					AND A.SECCION = G.SECCION
					AND F.PEDIMENTO = P.PEDIMENTO
					AND AV.REFERENCIA = P.REFERENCIA
					AND AV.TIPO_A = 'V'
					AND P.REFERENCIA = '".explode("_R", $referencia)[0]."'
					AND P.CON_REC = ".explode("_R", $referencia)[1]."
			");

		}else{

			$datos = $conexionSCIA->GetRow("
				SELECT
					P.CLAVEX,
					P.TIPO_MOVIMIENTO,
					G.PATENTE,
					P.PEDIMENTO,
					CONCAT( G.ADUANA, P.SECCION ) AS ADUANA,
					F.FIRMA,
					AV.ARCHIVO,
					AV.PREVALIDADOR
				FROM
					PEDIMENTO.PEDIMENTOS P,
					PEDIMENTO.GENERAL G,
					PEDIMENTO.ADUANA A, 
					PEDIMENTO.FIRMAS F,
					PEDIMENTO.ARCHVALPAG AV
				WHERE
					P.clavex = G.clavex 
					AND F.clavex = P.clavex
					AND A.ADUANA = G.ADUANA 
					AND A.SECCION = G.SECCION
					AND F.PEDIMENTO = P.PEDIMENTO
					AND AV.REFERENCIA = P.REFERENCIA
					AND AV.TIPO_A = 'V'
					AND P.REFERENCIA = '".explode("_R", $referencia)[0]."' 
			");
		}
		
		$conexionSCIA->Close(); 

		$consecutivo = $this->obtenConsecutivoValPag($datos["CLAVEX"], $datos["PATENTE"]);

		$rutaRepositorio = "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$referencia."/CANCELACIONES";

		if (!file_exists($rutaRepositorio)) {
			mkdir($rutaRepositorio, 0777, true);
		}



		$diaJuliano = str_pad( (date('z') + 1) , 3, "0", STR_PAD_LEFT);

		$archivo = fopen($rutaRepositorio."/m".$datos["PATENTE"].$consecutivo.".".$diaJuliano, "w") or die("Se produjo un error al crear el archivo");		
		fwrite($archivo, "500|2|".$datos["PATENTE"]."|".$datos["PEDIMENTO"]."|".$datos["ADUANA"]."|".$datos["FIRMA"]."|\n");
		fwrite($archivo, "801|m".$datos["PATENTE"].$consecutivo.".".$diaJuliano."|1|1|".$prevalidador."|");
		fclose($archivo);
		

		$ValidacionPagoDB = new conexionValidacionPago;

		$datosValidador = $ValidacionPagoDB->GetRow("
			SELECT
				v.XT_SERVIDOR,
				v.XN_PUERTO,
				v.XT_USUARIO,
				v.XT_PASSWORD, 
				v.XT_VALIDADOR,
				v.XT_NOMBRE
			FROM
				VALIDADORES v,
				REFERENCIAS r
			WHERE
				v.XT_VALIDADOR = '".$prevalidador."'
				AND v.XT_PATENTE = '".$datos["PATENTE"]."'  
				AND v.XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."'
				AND v.XT_NOMBRE = '".$prevalidadorNombre."'
				AND r.XT_referencia = '".$referencia."'
		");

		//var_dump($datosValidador);
		//echo "\n\n";

		$ValidacionPagoDB->close(); 

		$hostValidador = $datosValidador["XT_SERVIDOR"];
		$portValidador = $datosValidador["XN_PUERTO"];
		$userValidador = $datosValidador["XT_USUARIO"];
		$passValidador = $datosValidador["XT_PASSWORD"];

		
		
		$conexionValidador = ftp_connect($hostValidador,$portValidador)or die("No se pudo conectar a $hostValidador <br><br>");
		
		if($conexionValidador != false){

			//echo "conexion exitosa con el preevalidaor ".$host; 

			if(@ftp_login($conexionValidador, $userValidador, $passValidador)){

				//Iniciamos en modo pasivo
				ftp_pasv($conexionValidador, true);

				if($prevalidador == "058" || $prevalidador == "039"){
					if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
						$aduana = "470";
					}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
						$aduana = "800";
					}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
						$aduana = "650";
					}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
						$aduana = "430";
					}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
						$aduana = "530";
					}else if ($_SESSION["sesionLinks"]->oficina == "QRO") {
						$aduana = "640";
					}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX") {
						$aduana = "850";
					}

					if(!ftp_chdir($conexionValidador,$aduana)){
						ftp_mkdir($conexionValidador,$aduana);
						ftp_chdir($conexionValidador,$aduana);	
					}
				}else if($prevalidador == "011"){
					if($_SESSION["sesionLinks"]->oficina == 'SLP'){
						$aduana = "730";
					}

					if(!ftp_chdir($conexionValidador,$aduana)){
						ftp_mkdir($conexionValidador,$aduana);
						ftp_chdir($conexionValidador,$aduana);	
					}
				}else if($prevalidador == "010" && $prevalidadorNombre == "CAAAREM CONNECT"){
					if(!ftp_chdir($conexionValidador, "Envio")){
						ftp_mkdir($conexionValidador, "Envio");
						ftp_chdir($conexionValidador, "Envio");	
					}
				}

				

				$nombreArchivo = "m".$datos["PATENTE"].$consecutivo.".".$diaJuliano;

				$targetFile = $rutaRepositorio."/".$nombreArchivo;
				
				if(ftp_put($conexionValidador, $nombreArchivo, $targetFile,  FTP_BINARY) == true){

					$ValidacionPagoDB = new conexionValidacionPago();
					
					$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_ARCHIVOM_CANCELACION = '"."m".$datos["PATENTE"].$consecutivo.".".$diaJuliano."', XT_VALIDADOR_CANCELACION = '$prevalidador', XT_NOMBRE_VALIDADOR_CANCELACION = '$prevalidadorNombre' WHERE XT_REFERENCIA = '".$referencia."' ");
					$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Esperando cancelacion', '".$_SESSION["sesionLinks"]->usuario."') ");
					
					$ValidacionPagoDB->Close();
				
				}else{
					echo "Error enviando archivo M de cancelacion a validador";
				}
				
				ftp_close($conexionValidador); 	

			}else{
				echo "Error en login con el prevalidador";
			}
			

		}else{
			echo "Error de conexion con el validador ".$host; 
		}
				
    }


	function paraGenerarCancelacion($referencia, $session) {

    	$ValidacionPagoDB = new conexionValidacionPago();
    	
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar cancelacion', '".$_SESSION["sesionLinks"]->usuario."') ");

		$ValidacionPagoDB->Close();
					
    }

	
	function obtenConsecutivoValPag( $clavex , $patente){
        
        $consecu = 0;
        $consecutivo = null;
         
		if($_SESSION["sesionLinks"]->oficina == "CDMX"){
			$conexionSCIA = new ConexionSCIAMEX();
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			$conexionSCIA = new ConexionSCIALAR();
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			$conexionSCIA = new ConexionSCIACUN();
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){	
			$conexionSCIA = new ConexionSCIATOL();
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			$conexionSCIA = new ConexionSCIAVER();
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			$conexionSCIA = new ConexionSCIALAR();
		}else if($_SESSION["sesionLinks"]->oficina == "QRO"){
			$conexionSCIA = new ConexionSCIAMEX();
		}else if($_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			$conexionSCIA = new ConexionSCIAMEX();
		}
		
		$consecu = $conexionSCIA->GetOne("SELECT CONSECU FROM PEDIMENTO.GENERAL where CLAVEX = ".$clavex." and PATENTE = ".$patente." ");
		
		if($consecu == 999){
			$consecutivo = 1;
		}else{
			$consecutivo = $consecu + 1;
		}
		
		//Verifico si existe
		$existeConsecutivo = $conexionSCIA->GetOne("SELECT CONSECU FROM PEDIMENTO.GENERAL where CLAVEX = ".$clavex." and PATENTE = '".$patente."' AND CONSECU = ".$consecutivo." ");
		
		
		if($existeConsecutivo == null){
			
			if($consecutivo == 999){
				//echo "UPDATE PEDIMENTO.GENERAL set CONSECU = 0 where CLAVEX = ".$clavex." and PATENTE = ".$patente." ". "<br><br>";
				$conexionSCIA->Execute("UPDATE PEDIMENTO.GENERAL set CONSECU = 0 where CLAVEX = ".$clavex." and PATENTE = ".$patente." ");
			}else{
				//echo "UPDATE PEDIMENTO.GENERAL set CONSECU = ".$consecutivo." where CLAVEX = ".$clavex." and PATENTE = ".$patente." ". "<br><br>";
				$conexionSCIA->Execute("UPDATE PEDIMENTO.GENERAL set CONSECU = ".$consecutivo." where CLAVEX = ".$clavex." and PATENTE = ".$patente." ");
			}

			
			if(strlen($consecutivo) == 1){
				$consecutivo = "00".$consecutivo;
			}else if(strlen($consecutivo) == 2){
				$consecutivo = "0".$consecutivo;
			}else if(strlen($consecutivo) == 3){
				$consecutivo = $consecutivo;
			}
			
		}else{
			$consecutivo = $this->obtenConsecutivoValPag($clavex , $patente);
		}
		
		$conexionSCIA->Close();
		
        
        return $consecutivo;
    } 
	

	function saltaCargaEvidenciaSOIA($referencia){
		
		$ValidacionPagoDB = new conexionValidacionPago;
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Carga evidencia SOIA', '".$_SESSION["sesionLinks"]->usuario."') ");
		$ValidacionPagoDB->close();
		
	}

	function registraDatosPagoSinA($referencia, $operacionBancaria, $transaccionSAT, $fechaPago, $horaPago, $turno){

		$ValidacionPagoDB = new conexionValidacionPago;
		$ValidacionPagoDB->Execute("UPDATE REFERENCIAS set XT_OPERACION_BANCARIA = '".trim($operacionBancaria)."', XT_TRANSACCION_SAT = '".trim($transaccionSAT)."', XD_FECHA_PAGO = '".trim($fechaPago)." ".trim($horaPago)."', XT_TURNO = '".trim($turno)."' where XT_REFERENCIA = '".$referencia."' ");
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Datos pago completado sin A', '".$_SESSION["sesionLinks"]->usuario."') ");
		$ValidacionPagoDB->close();
		
	}

	function saltaCompletarDatosPagoSinA($referencia){
		
		$ValidacionPagoDB = new conexionValidacionPago;
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Completar datos pago sin A', '".$_SESSION["sesionLinks"]->usuario."') ");
		$ValidacionPagoDB->close();
		
	}

	function saltoGeneracionDocumentos($referencia){
		
		$ValidacionPagoDB = new conexionValidacionPago;
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Pago realizado', '".$_SESSION["sesionLinks"]->usuario."') ");
		$ValidacionPagoDB->close();
		
	}

	function cargaReciboPago($referencia){
		
		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name']; 
			$nombreRealArchivo = $_FILES['file']['name']; 
			
			$storeFolder = '../tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$_REQUEST["referencia"].'/';
			if (!file_exists($storeFolder)) {
				mkdir($storeFolder, 0777, true);
			}

			$targetFile = $storeFolder.$nombreRealArchivo; 
	 
			$upload_success = move_uploaded_file($tempFile,$targetFile); 
		
			if($upload_success) {

				$this->enviaLiberarSOIA($referencia);

				$ValidacionPagoDB = new conexionValidacionPago;
				$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Pago realizado', '".$_SESSION["sesionLinks"]->usuario."') ");
				$ValidacionPagoDB->close();

				$this->enviaGenerarSimplificadoCliente($referencia);
				 
			}else{
				echo "Problemas al subir Archivo";
			}	
		}
	}

	function enviaLiberarSOIA($referencia) {

		if($_SESSION["sesionLinks"]->oficina == "CDMX"){
			
			$cede = "AEROPUERTO";
			$conexionSCIA = new ConexionSCIAMEX();
			//$conexionSocket = 'gea-aicm.dyndns.org';
			$conexionSocket = '192.1.169.26';
			
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			
			$cede = "LAREDO";
			$conexionSCIA = new ConexionSCIALAR();
			//$conexionSocket = '71.144.19.158';
			$conexionSocket = '192.1.171.71';

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			
			$cede = "CANCUN";
			$conexionSCIA = new ConexionSCIACUN();
			//$conexionSocket = 'geacancun.dyndns.org';
			$conexionSocket = '192.1.166.241';

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			
			$cede = "TOLUCA";		
			$conexionSCIA = new ConexionSCIATOL();	
			//$conexionSocket = 'nyetoluca.dyndns.org';
			$conexionSocket = '192.1.167.203';

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			
			$cede = "VERACRUZ";
			$conexionSCIA = new ConexionSCIAVER();
			//$conexionSocket = 'nyeveracruz.dyndns.org';
			$conexionSocket = '192.1.168.253';
			
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			
			$cede = "SLP";
			$conexionSCIA = new ConexionSCIALAR();
			//$conexionSocket = '71.144.19.158';
			$conexionSocket = '192.1.171.71';

		}else if($_SESSION["sesionLinks"]->oficina == "QRO"){
			
			$cede = "QRO";
			$conexionSCIA = new ConexionSCIAMEX();
			//$conexionSocket = 'gea-aicm.dyndns.org';
			$conexionSocket = '192.1.169.26';

		}else if($_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			
			$cede = "EDOMEX";
			$conexionSCIA = new ConexionSCIAMEX();
			//$conexionSocket = 'gea-aicm.dyndns.org';
			$conexionSocket = '192.1.169.26';

		}

		$directorioRaiz = '/var/www/html/Sistemas/Links/tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$referencia.'/';

		$datos = $conexionSCIA->GetRow("SELECT
			P.CLIENTE,
			TO_CHAR ( P.FECHA_PAGO, 'YYYYMMDD' ) AS FECHA_PAGO,
			to_char ( P.FECHA_PAGO, 'YY' ) || ' ' || G.ADUANA || ' ' || G.PATENTE || ' ' || P.PEDIMENTO AS PEDIMENTO,
			CONCAT( G.ADUANA, P.SECCION ) AS ADUANA,
			C.RFC AS RFC,
			C.NOMBRE AS NOMBRE,
			P.TIPO_MOVIMIENTO TIPO_OPE,
			TO_CHAR(P.FECHA_PAGO, 'YYYY-MM-DD') PAGO
		FROM
			PEDIMENTO.PEDIMENTOS P,
			PEDIMENTO.CLIENTE C,
			PEDIMENTO.GENERAL G,
			PEDIMENTO.ADUANA A 
		WHERE
			P.CLIENTE = C.CLIENTE 
			AND P.clavex = G.clavex 
			AND A.ADUANA = G.ADUANA 
			AND A.SECCION = G.SECCION 
			AND P.REFERENCIA = '".$referencia."' ");

		$conexionSCIA->Close();

		
		//Envio ficheros
		$ficheros  = scandir($directorioRaiz);
		
		foreach($ficheros as $fichero){ 	

			$ruta = array();
			$ruta["origen"] = $directorioRaiz;

			if (substr($fichero,0,1) == 'm' && substr($fichero,-4) != '.err') { //VALIDA
				// Enviar a RCA con estructura
				$ruta["destino"] = '/var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/'.trim($datos[0]).'/'.trim($datos[1]).'/'.$referencia.'/VALIDA/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);

			}

		}

		//rmdir($directorioRaiz);

		//Agrego a DODA
		$DODADB = new conexionDODA();
		/*$DODADB->Execute("INSERT INTO PEDIMENTOS (XT_PEDIMENTO, XT_REFERENCIA, XT_ADUANA, XT_RFC_CLIENTE, XT_NOMBRE_CLIENTE, XT_ESTATUS) values ('".trim($datos[2])."', '".$referencia."', '".trim($datos[3])."', '".trim($datos[4])."', '".trim($datos[5])."', 'PAGADO') ");*/
		$DODADB->Execute("INSERT INTO DODA.PEDIMENTOS (
            XT_PEDIMENTO,
            XT_REFERENCIA,
            XN_REMESA,
            XT_ADUANA,
            XN_TIPO_OPERACION,
            XD_FECHA_PAGO,
            XT_RFC_CLIENTE,
            XT_NOMBRE_CLIENTE,
            XN_CANTIDAD_UMC,
            XN_IMPORTE_EFECTIVO,
            XN_IMPORTE_DIF_EFECTIVO,
            XN_DTA_NIU,
            XN_TIPO_PEDIMENTO,
            XN_ARTICULO_RGCE 
			)
			VALUES
            (
           '".trim($datos[2])."',
           '".$referencia."',
           '0',
           '".trim($datos[3])."',
           '".trim($datos[6])."',
           '".trim($datos[7])."',
           '".trim($datos[4])."',
           '".trim($datos[5])."',
           '0',
           '0',
           '0',
           '0',
           '0',
            '0' 
            )
		");
		$DODADB->Close();
		
		echo true;	
    }

	function registraDatosPago($referencia, $operacionBancaria, $transaccionSAT, $fechaPago, $horaPago, $turno){

		$ValidacionPagoDB = new conexionValidacionPago;
		$ValidacionPagoDB->Execute("UPDATE REFERENCIAS set XT_OPERACION_BANCARIA = '".trim($operacionBancaria)."', XT_TRANSACCION_SAT = '".trim($transaccionSAT)."', XD_FECHA_PAGO = '".trim($fechaPago)." ".trim($horaPago)."', XT_TURNO = '".trim($turno)."' where XT_REFERENCIA = '".$referencia."' ");
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Datos pago completado', '".$_SESSION["sesionLinks"]->usuario."') ");
		$ValidacionPagoDB->close();
		
	}

	function cargaArchivoEvidenciaSOIA($referencia){
		
		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name']; 
			$nombreRealArchivo = $_FILES['file']['name']; 
			
			$storeFolder = '../tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$_REQUEST["referencia"].'/EVIDENCIAS';
			if (!file_exists($storeFolder)) {
				mkdir($storeFolder, 0777, true);
			}

			$targetFile = $storeFolder.$nombreRealArchivo; 
	 
			$upload_success = move_uploaded_file($tempFile,$targetFile); 
		
			if($upload_success) {

				$this->enviaLiberarSOIA($referencia);

				$ValidacionPagoDB = new conexionValidacionPago;
				$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Completar datos pago', '".$_SESSION["sesionLinks"]->usuario."') ");
				$ValidacionPagoDB->close();
				 
			}else{
				echo "Problemas al subir Archivo";
			}	
		}
	}

	function cargaArchivoA($referencia){
		
		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name']; 
			$nombreRealArchivo = $_FILES['file']['name']; 
			
			$storeFolder = '../tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$_REQUEST["referencia"].'/';
			if (!file_exists($storeFolder)) {
				mkdir($storeFolder, 0777, true);
			}

			$targetFile = $storeFolder.$nombreRealArchivo; 
	 
			$upload_success = move_uploaded_file($tempFile,$targetFile); 
		
			if($upload_success) {
				/*
				$fp = fopen($targetFile, "r");

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
							//echo $patente."\n";
					}

					if($linea[0] == "501" || $linea[0] == "601"){
						$aduana = substr($linea[3], 0, -1);
							//echo $aduana."\n";
					}

					if($linea[0] == "501"){
						$curp = $linea[9];
							//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];
					}
				}

				fclose($fp);
				*/

				$ValidacionPagoDB = new conexionValidacionPago;
				$ValidacionPagoDB->Execute("UPDATE REFERENCIAS set XT_ARCHIVOA = '".$nombreRealArchivo."' where XT_REFERENCIA = '".$referencia."' ");
				$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Esperando pago', '".$_SESSION["sesionLinks"]->usuario."') ");
				$ValidacionPagoDB->close();
				 
			}else{
				echo "Problemas al subir Archivo";
			}	
		}
	}

	function cargaArchivoE($referencia){
		
		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name']; 
			$nombreRealArchivo = $_FILES['file']['name']; 
			
			$storeFolder = '../tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$_REQUEST["referencia"].'/';
			if (!file_exists($storeFolder)) {
				mkdir($storeFolder, 0777, true);
			}

			$targetFile = $storeFolder.$nombreRealArchivo; 
	 
			$upload_success = move_uploaded_file($tempFile,$targetFile);
		
			if($upload_success) {
				/*
				$fp = fopen($targetFile, "r");

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
							//echo $patente."\n";
					}

					if($linea[0] == "501" || $linea[0] == "601"){
						$aduana = substr($linea[3], 0, -1);
							//echo $patente."\n";
					}

					if($linea[0] == "501"){
						$curp = $linea[9];
							//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];
					}
				}

				fclose($fp);
				*/

				$ValidacionPagoDB = new conexionValidacionPago;
				$ValidacionPagoDB->Execute("UPDATE REFERENCIAS set XT_ARCHIVOE = '".$nombreRealArchivo."' where XT_REFERENCIA = '".$referencia."' ");
				$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para pagar', '".$_SESSION["sesionLinks"]->usuario."') ");
				$ValidacionPagoDB->close();
				
			}else{
				echo "Problemas al subir Archivo";
			}	
		}
	}
	
	function cargaArchivoERR($referencia){
		
		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name']; 
			$nombreRealArchivo = $_FILES['file']['name']; 
			
			$storeFolder = '../tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$_REQUEST["referencia"].'/';
			if (!file_exists($storeFolder)) {
				mkdir($storeFolder, 0777, true);
			}

			$targetFile = $storeFolder.$nombreRealArchivo; 
	 
			$upload_success = move_uploaded_file($tempFile,$targetFile); 
		
			if($upload_success) {
				/*
				$fp = fopen($targetFile, "r");

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
							//echo $patente."\n";
					}

					if($linea[0] == "501" || $linea[0] == "601"){
						$aduana = substr($linea[3], 0, -1);
							//echo $patente."\n";
					}

					if($linea[0] == "501"){
						$curp = $linea[9];
							//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];
					}
				}

				fclose($fp);
				*/

				/*
				$ValidacionPagoDB = new conexionValidacionPago;
				$ValidacionPagoDB->Execute("UPDATE REFERENCIAS set XT_ARCHIVOM = '".$nombreRealArchivo."', XT_CURP_CAUSANTE = '".$curp."' where XT_REFERENCIA = '".$referencia."' ");
				$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para prevalidar', '".$_SESSION["sesionLinks"]->usuario."') ");
				$ValidacionPagoDB->close();
				*/  
			}else{
				echo "Problemas al subir Archivo";
			}	
		}
	}

	function cargaArchivoM($referencia){
		
		if (!empty($_FILES)) {


			$tempFile = $_FILES['file']['tmp_name']; 
			$nombreRealArchivo = $_FILES['file']['name']; 
			
			$storeFolder = '../tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$_REQUEST["referencia"].'/';
			if (!file_exists($storeFolder)) {
				mkdir($storeFolder, 0777, true);
			}

			$targetFile = $storeFolder.$nombreRealArchivo; 
	 
			$upload_success = move_uploaded_file($tempFile,$targetFile); 
		
			if($upload_success) {
				
				$fp = fopen($targetFile, "r");

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
							//echo $patente."\n";
					}

					if($linea[0] == "501" || $linea[0] == "601"){
						$aduana = substr($linea[3], 0, -1);
							//echo $patente."\n";
					}

					if($linea[0] == "501"){
						$curp = $linea[9];
							//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];
					}
				}

				fclose($fp);


				$ValidacionPagoDB = new conexionValidacionPago;
				$nombreValidador = $ValidacionPagoDB->GetOne("SELECT XT_NOMBRE FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' AND XT_PATENTE = '".$patente."' AND XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' order by XT_NOMBRE DESC ");
				$ValidacionPagoDB->Execute("UPDATE REFERENCIAS set XT_ARCHIVOM = '".$nombreRealArchivo."', XT_VALIDADOR_ARCHIVOM = '".$prevalidador."', XT_NOMBRE_VALIDADOR_ARCHIVOM = '".$nombreValidador."', XT_CURP_CAUSANTE = '".$curp."' where XT_REFERENCIA = '".$referencia."' ");
				$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para prevalidar', '".$_SESSION["sesionLinks"]->usuario."') ");
				$ValidacionPagoDB->close();  
			}else{
				echo "Problemas al subir Archivo";
			}	
		}
	}

	
	function registraAutorizacionContabilidadPago($referencia){

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			$conexionSCIA = new ConexionSCIAMEX();
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			$conexionSCIA = new ConexionSCIALAR();
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			$conexionSCIA = new ConexionSCIACUN();
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){	
			$conexionSCIA = new ConexionSCIATOL();
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){	
			$conexionSCIA = new ConexionSCIAVER();
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){	
			$conexionSCIA = new ConexionSCIALAR();
		}

		$registroAprobacion = $conexionSCIA->GetArray("SELECT * FROM T_APROBACION WHERE NTR_APROBACION = '".$referencia."' ");

		if($registroAprobacion == null){
			$conexionSCIA->Execute("INSERT INTO T_APROBACION (NTR_APROBACION,NCL_APROBACION, MNT_APROBACION, FSA_APROBACION, PGO_APROBACION) values ('".$referencia."' , ' ',  '0', '".date("Y-m-d")."', '0')  ");
		}else{
			$conexionSCIA->Execute("UPDATE T_APROBACION SET APG_APROBACION = '1' WHERE NTR_APROBACION = '".$referencia."' ");
		}

		$conexionSCIA->Close();


		$ValidacionPagoDB = new conexionValidacionPago;
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Validacion Contabilidad', '".$_SESSION["sesionLinks"]->usuario."') ");
		$ValidacionPagoDB->close(); 
		
	}
	

	function cargaArchivoValidador($referencia, $ruta, $nombre) {
		
		$existeM = false;

		$rutaRepositorio = "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$referencia."";

		$contenido = opendir($rutaRepositorio);

		while ($archivo = readdir($contenido)){ //obtenemos un archivo y luego otro sucesivamente
			if(substr($archivo,0,1) == "m" && substr($archivo,-3) != "err"){

				$existeM = true;
				$archivoM = $archivo;

				$fp = fopen($rutaRepositorio."/".$archivoM, "r");

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
							//echo $patente."\n";
					}

					if($linea[0] == "501" || $linea[0] == "601"){
						$aduana = substr($linea[3], 0, -1);
							//echo $patente."\n";
					}

					if($linea[0] == "501"){
						$curp = $linea[9];
							//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];
					}

					echo "<script>console.log( 'Debug Objects: " . substr($nombre,0,1) ."</script>";

					if(substr($nombre,0,1) == "a"){
						$ValidacionPagoDB = new conexionValidacionPago;
						$prevalidador = $ValidacionPagoDB->GetOne("SELECT r.XT_VALIDADOR_ARCHIVOE FROM REFERENCIAS r WHERE r.XT_REFERENCIA = '".$referencia."' ");
						$ValidacionPagoDB->close(); 
					}
				}

				fclose($fp);

				

				$ValidacionPagoDB = new conexionValidacionPago;
				$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ");
				$ValidacionPagoDB->close(); 

				$hostValidador = $datosValidador["XT_SERVIDOR"];
				$portValidador = $datosValidador["XN_PUERTO"];
				$userValidador = $datosValidador["XT_USUARIO"];
				$passValidador = $datosValidador["XT_PASSWORD"];

				echo "<script>console.log( 'Debug Objects: " . $hostValidador . "' - '". $portValidador . "' - '". $userValidador . "' - '". $passValidador ."</script>";

				$conexionValidador = ftp_connect($hostValidador,$portValidador)or die("No se pudo conectar a $hostValidador <br><br>");

				if($conexionValidador != false){

					if(@ftp_login($conexionValidador, $userValidador, $passValidador)){

								//Iniciamos en modo pasivo
						ftp_pasv($conexionValidador, true);

						if($prevalidador == "058"){

							if(!ftp_chdir($conexionValidador,$aduana."0")){
								ftp_mkdir($conexionValidador,$aduana);
								ftp_chdir($conexionValidador,$aduana);	
							}

						}else if($prevalidador == "010"){

							if(!ftp_chdir($conexionValidador,"Aduana".$aduana)){
								ftp_mkdir($conexionValidador,$aduana);
								ftp_chdir($conexionValidador,$aduana);	
							}
						}

						$nombreArchivo = $nombre;

						$targetFile = $ruta;

						if(ftp_put($conexionValidador, $nombreArchivo, $targetFile, FTP_BINARY) == false){
							echo "Error enviando archivo a Validador";
						}

						ftp_close($conexionValidador); 	

					}else{
						echo "Error en login con el validador";
					}

				}else{
					echo "Error de conexion con el validador ".$host; 
				}
			}
		}

		if($existeM == false){
			echo "No existe archivo m de la referencia ".$referencia." para saber a que validador enviar\n";
		}
				
    }

    function borraArchivosValidador($referencia){

    	$ValidacionPagoDB = new conexionValidacionPago();

		$datosReferencia = $ValidacionPagoDB->GetRow("SELECT XT_ARCHIVOM, XT_ARCHIVOE, XT_VALIDADOR_ARCHIVOE, XT_NOMBRE_VALIDADOR_ARCHIVOM FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' ");

		$ValidacionPagoDB->Close();


    	$existeM = false;

		$rutaRepositorio = "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$referencia."";

		$contenido = opendir($rutaRepositorio);

		while ($archivo = readdir($contenido)){ //obtenemos un archivo y luego otro sucesivamente
			if($archivo == $datosReferencia["XT_ARCHIVOM"]){

				$existeM = true;
				$archivoM = $archivo;

				$fp = fopen($rutaRepositorio."/".$archivoM, "r");

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
							//echo $patente."\n";
					}

					if($linea[0] == "501"){
						$curp = $linea[9];
							//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];

						$ValidacionPagoDB = new conexionValidacionPago;
						$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_NOMBRE = '".$datosReferencia["XT_NOMBRE_VALIDADOR_ARCHIVOM"]."' ");
						$ValidacionPagoDB->close(); 

						if($datosValidador != null){
							$hostValidador = $datosValidador["XT_SERVIDOR"];
							$portValidador = $datosValidador["XN_PUERTO"];
							$userValidador = $datosValidador["XT_USUARIO"];
							$passValidador = $datosValidador["XT_PASSWORD"];
						}
					}
				}

				fclose($fp);


				if($datosValidador != null){

					$conexionValidador = ftp_connect($hostValidador,$portValidador)or die("No se pudo conectar a $hostValidador <br><br>");

					if($conexionValidador != false){

						if(@ftp_login($conexionValidador, $userValidador, $passValidador)){

							//Iniciamos en modo pasivo
							ftp_pasv($conexionValidador, true);

							if($prevalidador == "058"){
								if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
									$aduana = "470";
								}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
									$aduana = "800";
								}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
									$aduana = "650";
								}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
									$aduana = "430";
								}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
									$aduana = "530";
								}else if ($_SESSION["sesionLinks"]->oficina == "QRO") {
									$aduana = "640";
								}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX") {
									$aduana = "850";
								}

								if(!ftp_chdir($conexionValidador,$aduana)){
									ftp_mkdir($conexionValidador,$aduana);
									ftp_chdir($conexionValidador,$aduana);	
								}
							}else if($prevalidador == "011"){
								if($_SESSION["sesionLinks"]->oficina == 'SLP'){
									$aduana = "ENV";
								}

								if(!ftp_chdir($conexionValidador,$aduana)){
									ftp_mkdir($conexionValidador,$aduana);
									ftp_chdir($conexionValidador,$aduana);	
								}
							}else if($prevalidador == "010" && $datosReferencia["XT_NOMBRE_VALIDADOR_ARCHIVOM"] == "CAAAREM CONNECT"){
								if(!ftp_chdir($conexionValidador, "Envio")){
									ftp_mkdir($conexionValidador, "Envio");
									ftp_chdir($conexionValidador, "Envio");	
								}
							}else if($prevalidador == "010"){
								if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
									$aduana = "Aduana47";
								}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
									$aduana = "Aduana80";
								}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
									$aduana = "Aduana65";
								}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
									$aduana = "Aduana43";
								}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
									$aduana = "Aduana53";
								}else if ($_SESSION["sesionLinks"]->oficina == "QRO") {
									$aduana = "Aduana64";
								}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX") {
									$aduana = "Aduana85";
								}


								if(!ftp_chdir($conexionValidador,$aduana)){
									ftp_mkdir($conexionValidador,$aduana);
									ftp_chdir($conexionValidador,$aduana);	
								}
							}

							$repositorioValidador = ftp_nlist($conexionValidador, ".");

							if($repositorioValidador != false){

								if( in_array(substr($datosReferencia["XT_ARCHIVOM"],0,8).".err", $repositorioValidador ) ){

									//Borro Archivo .err
									if (! ftp_delete($conexionValidador, substr($datosReferencia["XT_ARCHIVOM"],0,8).".err")){
										echo "Error al eliminar Archivo .err del repositorio del validador\n";
									}
								}
							}
							
							ftp_close($conexionValidador); 	

						}else{
							echo "Error en login con el prevalidador";
						}

					}else{
						echo "Error de conexion con el preevalidaor ".$host; 
					}

				}else{
					//echo "Patente no configurada para este validador";
				}

				
				//Borro archivoo .a
				$ValidacionPagoDB = new conexionValidacionPago;
				$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$datosReferencia["XT_VALIDADOR_ARCHIVOE"]."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_NOMBRE = '".$datosReferencia["XT_NOMBRE_VALIDADOR_ARCHIVOM"]."' ");
				$ValidacionPagoDB->close(); 

				if($datosValidador != null){
					$hostValidador = $datosValidador["XT_SERVIDOR"];
					$portValidador = $datosValidador["XN_PUERTO"];
					$userValidador = $datosValidador["XT_USUARIO"];
					$passValidador = $datosValidador["XT_PASSWORD"];
				}

				if($datosValidador != null){

					$conexionValidador = ftp_connect($hostValidador,$portValidador)or die("No se pudo conectar a $hostValidador <br><br>");

					if($conexionValidador != false){


						if(@ftp_login($conexionValidador, $userValidador, $passValidador)){

							//Iniciamos en modo pasivo
							ftp_pasv($conexionValidador, true);

							if($prevalidador == "058"){
								if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
									$aduana = "470";
								}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
									$aduana = "800";
								}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
									$aduana = "650";
								}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
									$aduana = "430";
								}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
									$aduana = "530";
								}else if ($_SESSION["sesionLinks"]->oficina == "QRO"){ 	
									$aduana = "640"; 
								}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX"){ 	
									$aduana = "850"; 
								}

								if(!ftp_chdir($conexionValidador,$aduana)){
									ftp_mkdir($conexionValidador,$aduana);
									ftp_chdir($conexionValidador,$aduana);	
								}
							}else if($prevalidador == "011"){
								if($_SESSION["sesionLinks"]->oficina == 'SLP'){
									$aduana = "ENV";
								}

								if(!ftp_chdir($conexionValidador,$aduana)){
									ftp_mkdir($conexionValidador,$aduana);
									ftp_chdir($conexionValidador,$aduana);	
								}
							}else if($prevalidador == "010" && $datosReferencia["XT_NOMBRE_VALIDADOR_ARCHIVOM"] == "CAAAREM CONNECT"){
								if(!ftp_chdir($conexionValidador, "Envio")){
									ftp_mkdir($conexionValidador, "Envio");
									ftp_chdir($conexionValidador, "Envio");	
								}
							}else if($prevalidador == "010"){
								if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
									$aduana = "Aduana47";
								}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
									$aduana = "Aduana80";
								}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
									$aduana = "Aduana65";
								}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
									$aduana = "Aduana43";
								}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
									$aduana = "Aduana53";
								}else if ($_SESSION["sesionLinks"]->oficina == "QRO"){ 
									$aduana = "Aduana64"; 
								}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX"){ 
									$aduana = "Aduana85"; 
								}

								if(!ftp_chdir($conexionValidador,$aduana)){
									ftp_mkdir($conexionValidador,$aduana);
									ftp_chdir($conexionValidador,$aduana);	
								}
							}

							$repositorioValidador = ftp_nlist($conexionValidador, ".");

							if($repositorioValidador != false){
								if(in_array("a".substr($datosReferencia["XT_ARCHIVOE"],1,12), $repositorioValidador)){

									//Borro Archivo .a
									if (! ftp_delete($conexionValidador, "a".substr($datosReferencia["XT_ARCHIVOE"],1,12))){
										echo "Error al eliminar Archivo .a del repositorio del validador\n\n";
									}
								}else{
									//echo "Ya no existe Archivo a".substr($datosReferencia["XT_ARCHIVOE"],1,12)." en el repositorio del validador";
								}
							}
							
							ftp_close($conexionValidador); 	

						}else{
							echo "Error en login con el prevalidador";
						}

					}else{
						echo "Error de conexion con el prevalidador ".$host; 
					}

				}else{
					//echo "Patente no configurada para este validador";
				}
			}
		}

		if($existeM == false){
			echo "No existe archivo m de la referencia ".$referencia."\n";
		}

    }


	function enviaLiberar($referencia) {

		if($_SESSION["sesionLinks"]->oficina == "CDMX"){
			
			$cede = "AEROPUERTO";
			$conexionSCIA = new ConexionSCIAMEX();
			//$conexionSocket = 'gea-aicm.dyndns.org';
			$conexionSocket = '192.1.169.26';

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			
			$cede = "LAREDO";
			$conexionSCIA = new ConexionSCIALAR();
			//$conexionSocket = '71.144.19.158';
			$conexionSocket = '192.1.171.71';

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			
			$cede = "CANCUN";
			$conexionSCIA = new ConexionSCIACUN();
			//$conexionSocket = 'geacancun.dyndns.org';
			$conexionSocket = '192.1.166.241';

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			
			$cede = "TOLUCA";		
			$conexionSCIA = new ConexionSCIATOL();	
			//$conexionSocket = 'nyetoluca.dyndns.org';
			$conexionSocket = '192.1.167.203';

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			
			$cede = "VERACRUZ";
			$conexionSCIA = new ConexionSCIAVER();
			//$conexionSocket = 'nyeveracruz.dyndns.org';
			$conexionSocket = '192.1.168.253';

		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			
			$cede = "SLP";
			$conexionSCIA = new ConexionSCIALAR();
			//$conexionSocket = '71.144.19.158';
			$conexionSocket = '192.1.171.71';

		}else if($_SESSION["sesionLinks"]->oficina == "QRO"){
			
			$cede = "QRO";
			$conexionSCIA = new ConexionSCIAMEX();
			//$conexionSocket = 'gea-aicm.dyndns.org';
			$conexionSocket = '192.1.169.26';

		}else if($_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			
			$cede = "EDOMEX";
			$conexionSCIA = new ConexionSCIAMEX();
			//$conexionSocket = 'gea-aicm.dyndns.org';
			$conexionSocket = '192.1.169.26';

		}

		$directorioRaiz = '/var/www/html/Sistemas/Links/tmp/VALIDACION/'.$_SESSION["sesionLinks"]->oficina.'/'.$referencia.'/';

		/*
		$datos = $conexionSCIA->GetRow("SELECT P.CLIENTE, TO_CHAR( P.FECHA_PAGO, 'YYYYMMDD' ) AS FECHA_PAGO, to_char( P.FECHA_PAGO, 'YY') || ' ' || G.ADUANA || ' ' || G.PATENTE || ' ' || P.PEDIMENTO  AS PEDIMENTO, CONCAT( G.ADUANA, P.SECCION ) AS ADUANA, C.RFC as RFC, C.NOMBRE as NOMBRE FROM PEDIMENTO.PEDIMENTOS P, PEDIMENTO.CLIENTE C, PEDIMENTO.GENERAL G, PEDIMENTO.ADUANA A WHERE P.CLIENTE = C.CLIENTE AND	P.clavex = G.clavex AND A.ADUANA = G.ADUANA	AND A.SECCION = G.SECCION AND	P.REFERENCIA = '".$referencia."'
		");
		*/

		if( strpos($referencia, "_R") == false ){

			$datos = $conexionSCIA->GetRow("SELECT
				P.CLIENTE,
				TO_CHAR ( P.FECHA_PAGO, 'YYYYMMDD' ) AS FECHA_PAGO,
				to_char ( P.FECHA_PAGO, 'YY' ) || ' ' || G.ADUANA || ' ' || G.PATENTE || ' ' || P.PEDIMENTO AS PEDIMENTO,
				CONCAT( G.ADUANA, P.SECCION ) AS ADUANA,
				C.RFC AS RFC,
				C.NOMBRE AS NOMBRE,
				P.TIPO_MOVIMIENTO TIPO_OPE,
				TO_CHAR(P.FECHA_PAGO, 'YYYY-MM-DD') PAGO
			FROM
				PEDIMENTO.PEDIMENTOS P,
				PEDIMENTO.CLIENTE C,
				PEDIMENTO.GENERAL G,
				PEDIMENTO.ADUANA A 
			WHERE
				P.CLIENTE = C.CLIENTE 
				AND P.clavex = G.clavex 
				AND A.ADUANA = G.ADUANA 
				AND A.SECCION = G.SECCION 
				AND P.REFERENCIA = '".$referencia."' ");

		}else{

			$datos = $conexionSCIA->GetRow("SELECT
				P.CLIENTE,
				TO_CHAR ( P.FECHA_PAGO, 'YYYYMMDD' ) AS FECHA_PAGO,
				to_char ( P.FECHA_PAGO, 'YY' ) || ' ' || G.ADUANA || ' ' || G.PATENTE || ' ' || P.PEDIMENTO AS PEDIMENTO,
				CONCAT( G.ADUANA, P.SECCION ) AS ADUANA,
				C.RFC AS RFC,
				C.NOMBRE AS NOMBRE,
				P.TIPO_MOVIMIENTO TIPO_OPE,
				TO_CHAR(P.FECHA_PAGO, 'YYYY-MM-DD') PAGO
			FROM
				PEDIMENTO.RPEDIMENTOS P,
				PEDIMENTO.CLIENTE C,
				PEDIMENTO.GENERAL G,
				PEDIMENTO.ADUANA A 
			WHERE
				P.CLIENTE = C.CLIENTE 
				AND P.clavex = G.clavex 
				AND A.ADUANA = G.ADUANA 
				AND A.SECCION = G.SECCION 
				AND P.REFERENCIA = '".explode("_R", $referencia)[0]."' 
				AND P.CON_REC = ".explode("_R", $referencia)[1]." ");

		}

		$conexionSCIA->Close();

		
		//Envio ficheros
		$ficheros  = scandir($directorioRaiz);
		
		foreach($ficheros as $fichero){ 	

			$ruta = array();
			$ruta["origen"] = $directorioRaiz;

			if (substr($fichero,0,1) == 'm' && substr($fichero,-4) != '.err') { //VALIDA
				// Enviar a RCA con estructura
				$ruta["destino"] = '/var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/'.trim($datos[0]).'/'.trim($datos[1]).'/'.$referencia.'/VALIDA/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);

			} elseif(substr($fichero,0,1) == 'm' && substr($fichero,-4) == '.err'){ //VALIDA-RECIBO
				// Enviar a RCA con estructura
				$ruta["destino"] = '//var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/'.trim($datos[0]).'/'.trim($datos[1]).'/'.$referencia.'/VALIDA-RECIBO/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);
				
			} elseif(substr($fichero,-4) == '.pdf' && substr($fichero,0,4) == 'SOIA'){ //SOIA
				// Enviar a RCA con estructura
				$ruta["destino"] = '/var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/DE/'.$referencia.'/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);
				
			} elseif(substr($fichero,-4) == '.pdf' && substr($fichero,-6) != '_p.pdf' && substr($fichero,0,4) != 'SOIA'){ //SIMPLIFICADO
				// Enviar a RCA con estructura
				$ruta["destino"] = '/var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/'.trim($datos[0]).'/'.trim($datos[1]).'/'.$referencia.'/SIMPLIFICADO/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);
				
			} elseif (substr($fichero,-6) == '_p.pdf') { //PROFORMAS
				//Enviar a RCA con estructura
				$ruta["destino"] = '/var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/'.trim($datos[0]).'/'.trim($datos[1]).'/'.$referencia.'/PROFORMAS/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);
				
			} elseif (substr($fichero,0,1) == 'e') { //PAGO
				// Enviar a RCA con estructura
				$ruta["destino"] = '/var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/'.trim($datos[0]).'/'.trim($datos[1]).'/'.$referencia.'/PAGO/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);
				
			} elseif(substr($fichero,0,1) == 'a' || substr($fichero,0,1) == 'A'){ //PAGO-RECIBO
				//Enviar a RCA con estructura
				$ruta["destino"] = '/var/www/html/Sistemas/Links/tmp/CARGA/'.$cede.'/DIGITALIZACION/'.trim($datos[0]).'/'.trim($datos[1]).'/'.$referencia.'/PAGO-RECIBO/';
				$this->enviarFicherosRCA($ruta, $fichero);
				//unlink($directorioRaiz.$fichero);
				
			} elseif($fichero == '.' || $fichero == '..') {
				
			} else{
				//unlink($directorioRaiz.$fichero);
			}

		}

		//rmdir($directorioRaiz);


		//Envio Archivo M TYCO
		if(trim($datos["RFC"]) == "TEM6006038H0"){

	    	$output = shell_exec('java -jar ../Librerias/GeneraArchivosTYCO/ArchivosTYCO.jar '.$referencia.' '.$_SESSION["sesionLinks"]->oficina.' ' );
	    	
	    	if($output != ""){
	    		echo $output;
	    	}

		}/*else if(trim($datos["RFC"]) == "BME0004112J6" || trim($datos["RFC"]) == "NCG131029SK3" || trim($datos["RFC"]) == "TME030710K69" || trim($datos["RFC"]) == "ZHM040609ES5"){

			$response = file_get_contents('https://escalante.com.mx/Sistemas/radar/Reportes/reportes_2/reporte_excel_inditex.php?referencia='.$referencia.'&rfc='.trim($datos["RFC"]));
			echo "La respuesta del script es: " . $response;

		}*//*else if(trim($datos["RFC"]) == "DME9204099R6"){
			CreateXML($referencia);
		}*/
		

		//Actualizo VP
		$ValidacionPagoDB = new conexionValidacionPago();
		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Liberado', '".$_SESSION["sesionLinks"]->usuario."') ");
		$ValidacionPagoDB->Close();

		//Agrego a DODA
		$DODADB = new conexionDODA();
		/*
		$DODADB->Execute("INSERT INTO PEDIMENTOS (XT_PEDIMENTO, XT_REFERENCIA, XT_ADUANA, XT_RFC_CLIENTE, XT_NOMBRE_CLIENTE, XT_ESTATUS) values ('".trim($datos[2])."', '".$referencia."', '".trim($datos[3])."', '".trim($datos[4])."', '".trim($datos[5])."', 'PAGADO') ");
		*/
		$DODADB->Execute("INSERT INTO DODA.PEDIMENTOS (
            XT_PEDIMENTO,
            XT_REFERENCIA,
            XN_REMESA,
            XT_ADUANA,
            XN_TIPO_OPERACION,
            XD_FECHA_PAGO,
            XT_RFC_CLIENTE,
            XT_NOMBRE_CLIENTE,
            XN_CANTIDAD_UMC,
            XN_IMPORTE_EFECTIVO,
            XN_IMPORTE_DIF_EFECTIVO,
            XN_DTA_NIU,
            XN_TIPO_PEDIMENTO,
            XN_ARTICULO_RGCE 
			)
			VALUES
            (
           '".trim($datos[2])."',
           '".$referencia."',
           '0',
           '".trim($datos[3])."',
           '".trim($datos[6])."',
           '".trim($datos[7])."',
           '".trim($datos[4])."',
           '".trim($datos[5])."',
           '0',
           '0',
           '0',
           '0',
           '0',
            '0' 
            )
		");
		$DODADB->Close();

		if( strpos($referencia, "_R") == false ){

			//Creo Complemento
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

			socket_connect($sock,$conexionSocket,'2666') or die("Error al conectarse");

			$tipoEnvio = "MENSAJE\n";
			socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

			$mensaje = "Genera Complemento\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $referencia."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $cede."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$respuesta = trim(socket_read($sock, 1024));

			socket_close($sock);
			
			if($respuesta == "OK"){
				
				if($_SESSION["sesionLinks"]->oficina != "SLP"){
					$this->borraArchivosValidador($referencia);
				}
			}else{
				echo $respuesta;
			}

		}
		
			
    }

    public function enviarFicherosRCA($ruta, $fichero) {
    	if(file_exists ($ruta["destino"])){

    		if (!copy($ruta["origen"].$fichero, $ruta["destino"].$fichero)) {
		    	echo "Error al copiar $fichero...\n";
			}
			
    	}else{

    		if(!mkdir($ruta["destino"], 0777, true)) {
		    	echo "Fallo al crear las carpetas...";
			}

			if (!copy($ruta["origen"].$fichero, $ruta["destino"].$fichero)) {
		    	echo "Error al copiar $fichero...\n";
			}
		}
		
		
    	/*
    	$host = "escalanterca.com.mx";
		$user = "Imagenes";
		$pass = "Img2012Server";
		$port = 21;

    	$conFtp = ftp_connect($host,$port)or die("No se pudo conectar a $ftp_server <br><br>");	
		if($conFtp) {
			if(ftp_login($conFtp, $user, $pass)) {				
				ftp_pasv($conFtp, true);

				$carpetas = substr($ruta["destino"], 1);
				$carpetasTmp = explode("/", $carpetas, -1);
				
				for($a=0; $a<count($carpetasTmp); $a++) {
					if(@!ftp_chdir($conFtp, $carpetasTmp[$a])) {
						$this->CreaCambia($conFtp, $carpetasTmp[$a]);
					}
				}

				$this->SubeArchivo($conFtp, $ruta["destino"].$fichero, $ruta["origen"].$fichero, $carpetasTmp);
			}
		}

		ftp_close($conFtp);
		*/		
	}

	public function CreaCambia($conFtp, $carpeta){

		if(ftp_mkdir($conFtp, $carpeta)){
			if(@!ftp_chdir($conFtp, $carpeta)) {
				$this->CreaCambia($conFtp, $carpeta);
			}
		}
		/*
		if(@!ftp_mkdir($conFtp, $carpeta)){
			$this->CreaCambia($conFtp, $carpeta);
		}else{
			if(@!ftp_chdir($conFtp, $carpeta)){
				$this->CreaCambia($conFtp, $carpeta);
			}
		}
		*/	
	}

	public function SubeArchivo($conFtp, $destino, $origen, $carpetasTmp){
		if(@!ftp_put($conFtp, $destino, $origen, FTP_BINARY)){
			$this->CreaCambia($conFtp, $carpetasTmp[ count($carpetasTmp) - 1 ] );
			$this->SubeArchivo($conFtp, $destino, $origen, $carpetasTmp);
		}
	}


	function cerrarConsolidado($referencia) {

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

			$conexionSCIA = new ConexionSCIAMEX();

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

			$conexionSCIA = new ConexionSCIALAR();

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

			$conexionSCIA = new ConexionSCIACUN();

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){

			$conexionSCIA = new ConexionSCIAVER();

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

			$conexionSCIA = new ConexionSCIATOL();

		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){

			$conexionSCIA = new ConexionSCIALAR();

		}

		$conexionSCIA->Execute("UPDATE SCIA.R_REFCONSOL set ESTATUS = 2 where REFERENCIA = '".$referencia."' ");

		$conexionSCIA->Close();

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Consolidado cerrado', '".$_SESSION["sesionLinks"]->usuario."') ");

		$ValidacionPagoDB->Close();

		echo true;
		
    }


	function enviaGenerarAvisoConsolidado($referencia, $session) {
		
		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		$mensaje = "Genera Aviso Consolidado\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $referencia."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){
			echo true;
		}else{
			echo $respuesta;
		}
    }

	function enviaGenerarSimplificadoDesistimiento($referencia, $session) {

		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		//agrego condicion para enviar mensaje de recti
		if (strpos($referencia, '_R') !== false) {
			$mensaje = "Genera Simplificado RECTI\n";
		}else{
			$mensaje = "Genera Simplificado PECE\n";
		}
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $referencia."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){
			echo true;
		}else{
			echo $respuesta;
		}
    }


	function enviaGenerarSimplificadoCliente($referencia) {
		
		$directorioControl = getcwd();
		$path  =  "../Librerias/ImpresionFormatos";
		chdir($path);

		if (strpos($referencia, '_R') !== false) {

			$respuesta = shell_exec('java -jar ImpresionFormatos.jar '.$referencia.' '.$_SESSION["sesionLinks"]->oficina.' RECTIFICACION CLIENTE 0 0 NA NA VYP');

		}else{

			$respuesta = shell_exec('java -jar ImpresionFormatos.jar '.$referencia.' '.$_SESSION["sesionLinks"]->oficina.' NORMAL CLIENTE 0 0 NA NA VYP');

		}

		chdir(getcwd());
		
		if(trim($respuesta) == "Generacion Links completa"){

			$ValidacionPagoDB = new conexionValidacionPago();

			$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para liberar', '".$_SESSION["sesionLinks"]->usuario."') ");

			$ValidacionPagoDB->Close();
			
			//echo true;
		}else{
			echo $respuesta;
		}
		
    }

	
	function enviaGenerarSimplificado($referencia, $session) {
		/*
		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		//agrego condicion para enviar mensaje de recti
		if (strpos($referencia, '_R') !== false) {
			$mensaje = "Genera Simplificado RECTI\n";
		}else{
			$mensaje = "Genera Simplificado PECE\n";
		}
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $referencia."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){
			echo true;
		}else{
			echo $respuesta;
		}
		*/

		
		$directorioControl = getcwd();
		$path  =  "../Librerias/ImpresionFormatos";
		chdir($path);

		if (strpos($referencia, '_R') !== false) {

			$respuesta = shell_exec('java -jar ImpresionFormatos.jar '.$referencia.' '.$_SESSION["sesionLinks"]->oficina.' RECTIFICACION NA 0 0 NA NA VYP');

		}else{

			$respuesta = shell_exec('java -jar ImpresionFormatos.jar '.$referencia.' '.$_SESSION["sesionLinks"]->oficina.' NORMAL NA 0 0 NA NA VYP');

		}

		chdir(getcwd());
		
		if(trim($respuesta) == "Generacion Links completa"){

			$ValidacionPagoDB = new conexionValidacionPago();

			$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para liberar', '".$_SESSION["sesionLinks"]->usuario."') ");

			$ValidacionPagoDB->Close();
			
			echo true;
		}else{
			echo $respuesta;
		}	
    }

	function obtenDetalleError($datosReferencia, $session, $ValidacionPagoDB) {

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		$cmentario = null;

		if($datosReferencia[$estatus] == "Error pagar"){

			//$ValidacionPagoDB = new conexionValidacionPago();

			$comentario = $ValidacionPagoDB->GetOne("SELECT XT_COMENTARIO FROM ESTATUS WHERE XT_REFERENCIA = '".$datosReferencia[$referencia]."' AND XT_ESTATUS = '".$datosReferencia[$estatus]."' ");

			//$ValidacionPagoDB->Close();
			
			return $comentario;
		}		
    }

    function obtenEstatusConsolidado($datosReferencia, $session) {

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		$consolidado = null;

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

			$conexionSCIA = new ConexionSCIAMEX();

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

			$conexionSCIA = new ConexionSCIALAR();

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

			$conexionSCIA = new ConexionSCIACUN();

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){

			$conexionSCIA = new ConexionSCIAVER();

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

			$conexionSCIA = new ConexionSCIATOL();

		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){

			$conexionSCIA = new ConexionSCIALAR();

		}

		$consolidado = $conexionSCIA->GetOne("SELECT ESTATUS 
												from SCIA.R_REFCONSOL 
												where REFERENCIA = '".$datosReferencia[$referencia]."'
											");

		$conexionSCIA->Close();
		
		return $consolidado;		
    }

	function obtenBancos($datosReferencia, $session, $ValidacionPagoDB) {

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		$bancos = null;

		if($datosReferencia[$estatus] == "Para generar E"){

			//$ValidacionPagoDB = new conexionValidacionPago();

			$bancos = $ValidacionPagoDB->GetArray("SELECT XT_NOMBRE, XT_CLAVE_BANCO, XT_CLAVE_CUENTA FROM BANCOS where XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ");

			//$ValidacionPagoDB->Close();
			
			return $bancos;
		}		
    }

	function obtenPeca($datosReferencia, $session, $ValidacionPagoDB) {
		
		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		$peca = null;

		$existeM = false;

		$rutaRepositorio = "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."";

		//echo $rutaRepositorio."<br><br>";

		$contenido = opendir($rutaRepositorio);

		while ($archivo = readdir($contenido)){ //obtenemos un archivo y luego otro sucesivamente
			if(substr($archivo,0,1) == 'm' && substr($archivo,-4) != '.err'){

				$existeM = true;
				$archivoM = $archivo;

				$fp = fopen($rutaRepositorio."/".$archivoM, "r");

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
							//echo $patente."\n";
					}

					if($linea[0] == "501"){
						$tipoOPeracion = $linea[4];
						$rfc = $linea[8];
						$curp = $linea[9];
						//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];
					}
				}

				fclose($fp);
			}
		}

		if($datosReferencia[$estatus] == "Para generar E"){
		

			if ($rfc == "AME960221SV4"){//NOKIA

				if($_SESSION["sesionLinks"]->oficina == "CDMX"){

					$conexionSCIA = new ConexionSCIAMEX();
	
				}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
	
					$conexionSCIA = new ConexionSCIALAR();
	
				}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
	
					$conexionSCIA = new ConexionSCIACUN();
	
				}else if($_SESSION["sesionLinks"]->oficina == "VER"){
	
					$conexionSCIA = new ConexionSCIAVER();
	
				}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
	
					$conexionSCIA = new ConexionSCIATOL();
	
				}else if($_SESSION["sesionLinks"]->oficina == "EDOMEX"){

					$conexionSCIA = new ConexionSCIAMEX();
	
				}

				$proyecto = $conexionSCIA->GetOne("SELECT NPD_TRAFICOINGRESO FROM T_NOTGUIASDATOS, T_TRAFICOINGRESO WHERE NTR_NOTGUIASDATOS =  '".$datosReferencia[$referencia]."' AND REF_TRAFICOINGRESO = CVE_NOTGUIASDATOS ");
				
				$conexionSCIA->Close();

				if($pos = strpos(strtoupper($proyecto), "FNOKIA")){
				}else if($pos = strpos(strtoupper($proyecto), "ATT")){
				}else if($pos = strpos(strtoupper($proyecto), "PEGASSO")){
				}else if($pos = strpos(strtoupper($proyecto), "BATCH")){
				}

				if($pos !== false) {

					$peca = $ValidacionPagoDB->GetArray("
						SELECT p.XT_CLAVE_BANCO as CLAVE_BANCO, p.XT_CLAVE_CUENTA as CLAVE_CUENTA
						FROM PECAS p 
						WHERE p.XT_RFC in ('".$rfc."', 'TODOS')
						AND p.XN_TIPO_OPERACION = ".$tipoOPeracion."
						AND XT_CLAVE_CUENTA = 'IO'
						AND p.XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' 
						ORDER BY XT_ESTATUS DESC
					");

			    }else{

					$peca = $ValidacionPagoDB->GetArray("
						SELECT p.XT_CLAVE_BANCO as CLAVE_BANCO, p.XT_CLAVE_CUENTA as CLAVE_CUENTA
						FROM PECAS p 
						WHERE p.XT_RFC in ('".$rfc."', 'TODOS')
						AND p.XN_TIPO_OPERACION = ".$tipoOPeracion."
						AND p.XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' 
						ORDER BY XT_ESTATUS DESC
					");
			   }

			}else{

				$peca = $ValidacionPagoDB->GetArray("SELECT p.XT_CLAVE_BANCO as CLAVE_BANCO, p.XT_CLAVE_CUENTA as CLAVE_CUENTA
												FROM PECAS p 
												WHERE p.XT_RFC in ('".$rfc."', 'TODOS')
												AND p.XN_TIPO_OPERACION = ".$tipoOPeracion."
												AND p.XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' 
												ORDER BY XT_ESTATUS DESC
											");
			}

			return $peca;
		}
				
    }

	function obtenCausante($referencia, $curp, $session) {

		$ValidacionPagoDB = new conexionValidacionPago();

		$causante = $ValidacionPagoDB->GetArray("SELECT XT_CURP, XT_FIGURA FROM FIRMAS where XT_CURP = '".$curp."' AND XT_OFICINA='".$_SESSION["sesionLinks"]->oficina."' ");

		$ValidacionPagoDB->Close();

		return $causante;
					
    }

    function obtenValidadores($datosReferencia, $session, $ValidacionPagoDB) {

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		$validadores = null;

		if($datosReferencia[$estatus] == "Para generar M" || $datosReferencia[$estatus] == "Para generar M Desistimiento" || $datosReferencia[$estatus] == "Para pagar" || $datosReferencia[$estatus] == "Para generar cancelacion"){

			//echo "ELECT DISTINCT XT_VALIDADOR, XT_NOMBRE FROM VALIDADORES where XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ORDER BY XT_ESTATUS DESC";
			$validadores = $ValidacionPagoDB->GetArray("SELECT DISTINCT XT_VALIDADOR, XT_NOMBRE FROM VALIDADORES where XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ORDER BY XT_ESTATUS DESC ");
			
			return $validadores;
		}		
    }

    function obtenFirmasReferencia($datosReferencia, $session, $ValidacionPagoDB) {

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		$firmas = null;

		$conexionSCIA = null;

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

			$conexionSCIA = new ConexionSCIAMEX();

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

			$conexionSCIA = new ConexionSCIALAR();

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

			$conexionSCIA = new ConexionSCIACUN();

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){

			$conexionSCIA = new ConexionSCIAVER();

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

			$conexionSCIA = new ConexionSCIATOL();

		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){

			$conexionSCIA = new ConexionSCIALAR();

		}

		if (strpos($datosReferencia[$referencia], '_R') !== false) {

			$patente = $conexionSCIA->GetOne("SELECT g.PATENTE from PEDIMENTO.GENERAL g, PEDIMENTO.RPEDIMENTOS p where p.referencia = '".explode("_R", $datosReferencia[$referencia])[0]."' and p.con_rec = ".explode("_R", $datosReferencia[$referencia])[1]." and g.CLAVEX = p.CLAVEX ");

		}else{

			$patente = $conexionSCIA->GetOne("SELECT g.PATENTE from PEDIMENTO.GENERAL g, PEDIMENTO.PEDIMENTOS p where p.referencia = '".$datosReferencia[$referencia]."' and g.CLAVEX = p.CLAVEX ");

		}
	
		$conexionSCIA->Close();

		if($datosReferencia[$estatus] == "Para generar M" || $datosReferencia[$estatus] == "Para generar M Desistimiento"){

			//$ValidacionPagoDB = new conexionValidacionPago();

			$firmas = $ValidacionPagoDB->GetArray("SELECT XT_NOMBRE, XT_CURP, XT_FIGURA FROM FIRMAS where XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_PATENTE = '".$patente."' ORDER BY XT_ESTATUS DESC ");

			//$ValidacionPagoDB->Close();

			return $firmas;
		}		
    }

	function obtenFirmas($datosReferencia, $session, $ValidacionPagoDB, $conexionSCIA) {

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		$firmas = null;

		/*
		$conexionSCIA = null;

		if($_SESSION["sesionLinks"]->oficina == "CDMX"|| $_SESSION["sesionLinks"]->oficina == "QRO"){

			$conexionSCIA = new ConexionSCIAMEX();

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

			$conexionSCIA = new ConexionSCIALAR();

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

			$conexionSCIA = new ConexionSCIACUN();

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){

			$conexionSCIA = new ConexionSCIAVER();

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

			$conexionSCIA = new ConexionSCIATOL();

		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){

			$conexionSCIA = new ConexionSCIALAR();

		}
		*/
		
		
		if (strpos($datosReferencia[$referencia], '_R') !== false) {
			if($_SESSION["sesionLinks"]->oficina == "CDMX"){
				$patente = $conexionSCIA->GetOne("SELECT g.PATENTE from PEDIMENTO.GENERAL g, PEDIMENTO.RPEDIMENTOS p where p.referencia = '".explode("_R", $datosReferencia[$referencia])[0]."' and g.CLAVEX = p.CLAVEX ");
			}else{
				$patente = $conexionSCIA->GetOne("SELECT g.PATENTE from PEDIMENTO.GENERAL g, PEDIMENTO.RPEDIMENTOS p where p.referencia = '".explode("_R", $datosReferencia[$referencia])[0]."' and p.con_rec = ".explode("_R", $datosReferencia[$referencia])[1]." and g.CLAVEX = p.CLAVEX ");
			}
		}else{
			/*
			if($_SESSION["sesionLinks"]->oficina == "CUN"){

				$patente = '3061';
			
			}else{
			*/
				$patente = $conexionSCIA->GetOne("SELECT g.PATENTE from PEDIMENTO.GENERAL g, PEDIMENTO.PEDIMENTOS p where p.referencia = '".$datosReferencia[$referencia]."' and g.CLAVEX = p.CLAVEX ");
				
			//}
		}

		

		

		//$conexionSCIA->Close();

		if($datosReferencia[$estatus] == "Para generar M" || $datosReferencia[$estatus] == "Para generar M Desistimiento"){

			//$ValidacionPagoDB = new conexionValidacionPago();

			$firmas = $ValidacionPagoDB->GetArray("SELECT XT_NOMBRE, XT_CURP, XT_FIGURA FROM FIRMAS where XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_PATENTE = '".$patente."' ORDER BY XT_ESTATUS DESC ");

			//$ValidacionPagoDB->Close();

			return $firmas;
		}		
    }

	function obtenArchivos($datosReferencia, $session) {

		$archivos = array();

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

			$oficina = "AEROPUERTO";

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

			$oficina = "LAREDO";

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

			$oficina = "CANCUN";

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){

			$oficina = "VERACRUZ";

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

			$oficina = "TOLUCA";

		}

		if($datosReferencia[$estatus] == 'Liberado'){

			$host = "escalanterca.com.mx";
			$port =  21;
			$user = "Imagenes";
			$pass = "Img2012Server";
			$servidorSocket = "escalanterca.com.mx";

			$MASTER_DB = new conexionMaster();

			$imagenes = $MASTER_DB->GetArray("select xt_tipoDocumento, xt_ruta from IMAGENES.IMAGENES_PEDIMENTOS where xt_tipoDocumento in ('SIMPLIFICADO', 'PROFORMAS') and xt_referencia = '".$datosReferencia[$referencia]."' ORDER BY xt_tipoDocumento DESC ");

			$MASTER_DB->Close();

			foreach ($imagenes as $imagen) {
				$tmp = explode("/",$imagen['xt_ruta']);
				if($imagen['xt_tipoDocumento'] == "SIMPLIFICADO"){
					//$archivos["Archivo Simplificado"]["Nombre"] = $tmp[count($tmp)-1];
					$archivos["Archivo Simplificado"]["Nombre"] = $datosReferencia[$referencia]."_SIMPLIFICADO.pdf";
					$archivos["Archivo Simplificado"]["Contenido"] = file_get_contents("ftp://".$user.":".$pass."@".$host."/".substr($imagen['xt_ruta'],3) );
				}else if($imagen['xt_tipoDocumento'] == "PROFORMAS"){
					//$archivos["Archivo Proformas"]["Nombre"] = $tmp[count($tmp)-1];
					$archivos["Archivo Proformas"]["Nombre"] = $datosReferencia[$referencia]."_PROFORMA.pdf";
					$archivos["Archivo Proformas"]["Contenido"] = file_get_contents("ftp://".$user.":".$pass."@".$host."/".substr($imagen['xt_ruta'],3) );
				}
			}

			return $archivos;

		}else{

			$contenido = opendir("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/");
			while ($archivo = readdir($contenido)){ //obtenemos un archivo y luego otro sucesivamente
			
			    if(substr($archivo,0,1) == "m" && substr($archivo,-4) != ".err"){
			    	$archivos["Archivo M"]["Nombre"] = $archivo;
			    	$archivos["Archivo M"]["Contenido"] = file_get_contents("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/".$archivo."");

			    }else if(substr($archivo,0,1) == "m" && substr($archivo,-4) == ".err"){
			    	$archivos["Archivo .err"]["Nombre"] = $archivo;
			    	$archivos["Archivo .err"]["Contenido"] = file_get_contents("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/".$archivo."");

			    }

			    if(substr($archivo,0,1) == "K" || substr($archivo,0,1) == "k"){
			    	$archivos["Archivo K"]["Nombre"] = $archivo;
			    	$archivos["Archivo K"]["Contenido"] = file_get_contents("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/".$archivo."");

			    }

			    if(substr($archivo,0,1) == "e"){
			    	$archivos["Archivo E"]["Nombre"] = $archivo;
			    	$archivos["Archivo E"]["Contenido"] = file_get_contents("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/".$archivo."");

			    }

			    if(substr($archivo,0,1) == "a" || substr($archivo,0,1) == "A"){
			    	$archivos["Archivo A"]["Nombre"] = $archivo;
			    	$archivos["Archivo A"]["Contenido"] = file_get_contents("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/".$archivo."");

			    }

			    if(strlen($archivo) == 19){
			    	$archivos["Archivo Simplificado"]["Nombre"] =  $datosReferencia[$referencia]."_SIMPLIFICADO.pdf";//$archivo;
			    	$archivos["Archivo Simplificado"]["Contenido"] = file_get_contents("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/".$archivo."");

			    }

			    if(substr($archivo,-5) == "p.pdf"){
			    	$archivos["Archivo Proformas"]["Nombre"] =  $datosReferencia[$referencia]."_PROFORMA.pdf";//$archivo;
			    	$archivos["Archivo Proformas"]["Contenido"] = file_get_contents("../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$datosReferencia[$referencia]."/".$archivo."");

			    }
			}

			return $archivos;

		}
		
				
    }

	function obtenDetalle($datosReferencia, $session) {

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		if($datosReferencia[$estatus] == "Error prevalidar"){
			
			if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

				$oficina = "AEROPUERTO";

			}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

				$oficina = "LAREDO";

			}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

				$oficina = "CANCUN";

			}else if($_SESSION["sesionLinks"]->oficina == "VER"){

				$oficina = "VERACRUZ";

			}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

				$oficina = "TOLUCA";

			}
			
			$host = "escalanterca.com.mx";
			$port =  21;
			$user = "Imagenes";
			$pass = "Img2012Server";
			$servidorSocket = "escalanterca.com.mx";

			$conexionRepositorio = ftp_connect($host,$port)or die("No se pudo conectar a $host <br><br>");
				
			if($conexionRepositorio){

				if(ftp_login($conexionRepositorio, $user, $pass)){

					//Iniciamos en modo pasivo
					ftp_pasv($conexionRepositorio, true);

					if(ftp_chdir($conexionRepositorio, $oficina."/VALIDACION/".$datosReferencia[$referencia])){

						$existeM = false;

						$contenido = ftp_nlist($conexionRepositorio, "");

						foreach ($contenido as $archivo) {

							if(substr($archivo,0,1) == "m"){

								$existeM = true;
								$archivoM = $archivo;
							}
						}

						if($existeM == false){
							echo "No existe archivo m de la referencia ".$datosReferencia[$referencia]."\n";
						}

					}else{
						echo "No existe informacion sobre la referencia ".$datosReferencia[$referencia];
					}

				}else{
					echo "Error en login con el repositorio Local de la oficina ".$_SESSION["sesionLinks"]->oficina;
				}

			}else{
				echo "Error de conexion con el repositorio Local de la oficina ".$_SESSION["sesionLinks"]->oficina;
			}

			ftp_close($conexionRepositorio);


			$detalle = file_get_contents("ftp://".$user.":".$pass."@".$host."/".$oficina."/VALIDACION/".$datosReferencia[$referencia]."/".str_replace("m", "K", $archivoM)."");

			return $detalle;
		}

		if($datosReferencia[$estatus] == "Error validar"){
			
			if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

				$oficina = "AEROPUERTO";

			}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

				$oficina = "LAREDO";

			}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

				$oficina = "CANCUN";

			}else if($_SESSION["sesionLinks"]->oficina == "VER"){

				$oficina = "VERACRUZ";

			}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

				$oficina = "TOLUCA";

			}
			

			$host = "escalanterca.com.mx";
			$port =  21;
			$user = "Imagenes";
			$pass = "Img2012Server";
			$servidorSocket = "escalanterca.com.mx";

			$conexionRepositorio = ftp_connect($host,$port)or die("No se pudo conectar a $host <br><br>");
				
			if($conexionRepositorio){

				if(ftp_login($conexionRepositorio, $user, $pass)){

					//Iniciamos en modo pasivo
					ftp_pasv($conexionRepositorio, true);

					if(ftp_chdir($conexionRepositorio, $oficina."/VALIDACION/".$datosReferencia[$referencia])){

						$existeM = false;

						$contenido = ftp_nlist($conexionRepositorio, "");

						foreach ($contenido as $archivo) {

							if(substr($archivo,0,1) == "m"){

								$existeM = true;
								$archivoM = $archivo;
							}
						}

						if($existeM == false){
							echo "No existe archivo m de la referencia ".$datosReferencia[$referencia]."\n";
						}

					}else{
						echo "No existe informacion sobre la referencia ".$datosReferencia[$referencia];
					}

				}else{
					echo "Error en login con el repositorio Local de la oficina ".$_SESSION["sesionLinks"]->oficina;
				}

			}else{
				echo "Error de conexion con el repositorio Local de la oficina ".$_SESSION["sesionLinks"]->oficina;
			}

			ftp_close($conexionRepositorio);

			$detalle = file_get_contents("ftp://".$user.":".$pass."@".$host."/".$oficina."/VALIDACION/".$datosReferencia[$referencia]."/".substr($archivoM, 0, -4).".err");

			return $detalle;
		}
					
    }

    function enviaImprimir($referencia, $session) {

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Para liberar', '".$_SESSION["sesionLinks"]->usuario."') ");

		$ValidacionPagoDB->Close();

		echo true;
					
    }

    function reintentoPagar($referencia, $session) {

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Para pagar', '".$_SESSION["sesionLinks"]->usuario."') ");

		$ValidacionPagoDB->Close();

		echo true;
					
    }

	function reintentoValidar($referencia, $session) {

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Para validar', '".$_SESSION["sesionLinks"]->usuario."') ");

		$ValidacionPagoDB->Close();

		echo true;
					
    }

	function reintentoPrevalidar($referencia, $session) {

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Para prevalidar', '".$_SESSION["sesionLinks"]->usuario."') ");

		$ValidacionPagoDB->Close();

		echo true;
					
    }

	function enviaPagar($referencia, $session, $validador, $validadorNombre) {

		$existeE = false;

		$rutaRepositorio = "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$referencia."";

		$contenido = opendir($rutaRepositorio);

		while ($archivo = readdir($contenido)){ //obtenemos un archivo y luego otro sucesivamente
			if(substr($archivo,0,1) == "e"){

				$existeE = true;
				$archivoE = $archivo;

				$fp = fopen($rutaRepositorio."/".$archivoE, "r");
				while(!feof($fp)) {

					$linea = fgets($fp);

					if(strlen($linea) > 0){
						$aduana = substr($linea, 25, 2);
						//echo $aduana."\n";
					}
				}
				fclose($fp);

				$ValidacionPagoDB = new conexionValidacionPago;
				$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$validador."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_NOMBRE = '".$validadorNombre."' ");
				$ValidacionPagoDB->close();

				$hostValidador = $datosValidador["XT_SERVIDOR"];
				$portValidador = $datosValidador["XN_PUERTO"];
				$userValidador = $datosValidador["XT_USUARIO"];
				$passValidador = $datosValidador["XT_PASSWORD"];

				$conexionValidador = ftp_connect($hostValidador,$portValidador)or die("No se pudo conectar a $hostValidador <br><br>");

				if($conexionValidador != false){

					if(@ftp_login($conexionValidador, $userValidador, $passValidador)){

											//Iniciamos en modo pasivo
						ftp_pasv($conexionValidador, true);

						if($validador == "058" || $validador == "039"){
							/*
							if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
								$aduana = "470";
							}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
								$aduana = "800";
							}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
								$aduana = "650";
							}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
								$aduana = "430";
							}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
								$aduana = "530";
							}else if ($_SESSION["sesionLinks"]->oficina == "QRO"){
								$aduana = "640";
							}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX"){
								$aduana = "850";
							}*/

							$aduana = $aduana."0";

							if(!ftp_chdir($conexionValidador,$aduana)){
								ftp_mkdir($conexionValidador,$aduana);
								ftp_chdir($conexionValidador,$aduana);	
							}
						}else if($validador == "011"){
							if($_SESSION["sesionLinks"]->oficina == 'SLP'){
								$aduana = "730";
							}

							if(!ftp_chdir($conexionValidador,$aduana)){
								ftp_mkdir($conexionValidador,$aduana);
								ftp_chdir($conexionValidador,$aduana);	
							}
						}else if($validador == "010" && $validadorNombre == "CAAAREM CONNECT"){
							if(!ftp_chdir($conexionValidador, "Envio")){
								ftp_mkdir($conexionValidador, "Envio");
								ftp_chdir($conexionValidador, "Envio");	
							}
						}

						$nombreArchivo = $archivoE;

						$targetFile = $rutaRepositorio."/".$archivoE;

						if(ftp_put($conexionValidador, $nombreArchivo, $targetFile, FTP_BINARY)){

							$ValidacionPagoDB = new conexionValidacionPago();

							$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Esperando pago', '".$_SESSION["sesionLinks"]->usuario."') ");

							$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_VALIDADOR_ARCHIVOE = '".$validador."', XT_NOMBRE_VALIDADOR_ARCHIVOE = '".$validadorNombre."' WHERE XT_REFERENCIA = '".$referencia."' ");

							$ValidacionPagoDB->Close();

							//Actualizacion a Legacy 
							if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
								$conexionSCIA = new ConexionSCIAMEX();
							}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
								$conexionSCIA = new ConexionSCIALAR();
							}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
								$conexionSCIA = new ConexionSCIACUN();
							}else if($_SESSION["sesionLinks"]->oficina == "VER"){
								$conexionSCIA = new ConexionSCIAVER();
							}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
								$conexionSCIA = new ConexionSCIATOL();
							}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
								$conexionSCIA = new ConexionSCIALAR();
							}
							
							if (strpos($referencia, '_R') !== false) {
								//Es RECTIFICAION
								$conexionSCIA->Execute("UPDATE PEDIMENTO.MONITOR_ARCHIVOS SET PREVALIDADOR = '".$validador."' WHERE FK_ID = (SELECT ROWID FROM PEDIMENTO.MONITOR_VAL_PAG WHERE REFERENCIA = '".explode("_R", $referencia)[0]."' AND CON_REC = ".explode("_R", $referencia)[1]." ) AND TIPO_ARCHIVO = 6 AND NOMBRE_ARCHIVO = '".$nombreArchivo."' ");
								$conexionSCIA->Execute("UPDATE PEDIMENTO.MONITOR_VAL_PAG SET ESTADO = 35, MENSAJE = 'Archivo de pago firmado y enviado al SAT.', USUARIO = 'Links' WHERE REFERENCIA = '".explode("_R", $referencia)[0]."' AND CON_REC = ".explode("_R", $referencia)[1]." ");
							}else{
								$conexionSCIA->Execute("UPDATE PEDIMENTO.MONITOR_ARCHIVOS SET PREVALIDADOR = '".$validador."' WHERE FK_ID = (SELECT ROWID FROM PEDIMENTO.MONITOR_VAL_PAG WHERE REFERENCIA = '".$referencia."' AND CON_REC = 0 ) AND TIPO_ARCHIVO = 6 AND NOMBRE_ARCHIVO = '".$nombreArchivo."' ");
								$conexionSCIA->Execute("UPDATE PEDIMENTO.MONITOR_VAL_PAG SET ESTADO = 35, MENSAJE = 'Archivo de pago firmado y enviado al SAT.', USUARIO = 'Links' WHERE REFERENCIA = '".$referencia."' AND CON_REC = 0 ");
							}
							
							$conexionSCIA->Close();


							echo true;

						}else{
							echo "Error enviando archivo E a validador";
						}

						ftp_close($conexionValidador); 	

					}else{
						echo "Error en login con el validador";
					}

				}else{
					echo "Error de conexion con el validaor ".$host; 
				}
			}
		}

		if($existeE == false){
			echo "No existe archivo E de la referencia ".$referencia."\n";
		}
    }

	function paraReprocesarPago($referencia, $session){

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Esperando pago', '".$_SESSION["sesionLinks"]->usuario."') ");
	
		$ValidacionPagoDB->Close();
	}

	function paraGenerarE($referencia, $session){

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Para generar E', '".$_SESSION["sesionLinks"]->usuario."') ");
	
		$ValidacionPagoDB->Close();
	}


    function reGenerarE($referencia, $session) {

		$ValidacionPagoDB = new conexionValidacionPago();
    	
		$archivoE = $ValidacionPagoDB->GetOne("SELECT XT_ARCHIVOE FROM REFERENCIAS WHERE xt_referencia = '".$referencia."' ");

		//Elimino registro y archivos
    	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		$mensaje = "Elimina Archivo VP\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $referencia."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $archivoE."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){
		
			$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_ARCHIVOE = '', XT_VALIDADOR_ARCHIVOE = '', XT_NOMBRE_VALIDADOR_ARCHIVOE = '' WHERE XT_REFERENCIA = '".$referencia."' ");
			$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Para generar E', '".$_SESSION["sesionLinks"]->usuario."') ");

			echo true;
		
		}else{
			echo $respuesta;
		}
		

		$ValidacionPagoDB->Close();
					
    }

    function enviaGenerarE_RECTI($referencia, $session, $clavebanco, $claveCuenta) {


		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

			$conexionSCIA = new ConexionSCIAMEX();

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			
			$conexionSCIA = new ConexionSCIALAR();

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			
			$conexionSCIA = new ConexionSCIACUN();

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			
			$conexionSCIA = new ConexionSCIAVER();

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			
			$conexionSCIA = new ConexionSCIATOL();

		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			
			$conexionSCIA = new ConexionSCIALAR();

		}


		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		$mensaje = "Genera Archivo Pago RECTI\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = "$referencia\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $clavebanco."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $claveCuenta."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){
			echo true;
		}else{
			echo $respuesta;
		}
				
    }


    function enviaGenerarE($referencia, $session, $clavebanco, $claveCuenta, $tipoCuenta) {

		if($_SESSION["sesionLinks"]->oficina != "SLP" && $tipoCuenta != 'PECA'){

			if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

				$conexionSCIA = new ConexionSCIAMEX();

			}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
				
				$conexionSCIA = new ConexionSCIALAR();

			}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
				
				$conexionSCIA = new ConexionSCIACUN();

			}else if($_SESSION["sesionLinks"]->oficina == "VER"){
				
				$conexionSCIA = new ConexionSCIAVER();

			}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
				
				$conexionSCIA = new ConexionSCIATOL();

			}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
				
				$conexionSCIA = new ConexionSCIALAR();

			}

			$aprobacionContabilidad = $conexionSCIA->GetOne("SELECT APG_APROBACION FROM SCIA.T_APROBACION WHERE NTR_APROBACION  = '".$referencia."' ");

			$conexionSCIA->Close();

			$odoo = file_get_contents("http://192.1.169.15:8069/verify-tax-payment/verify-tax-payment/".$referencia);
			$aprobacionOdoo = json_decode($odoo, true);

			if($aprobacionContabilidad == 1 || $aprobacionOdoo["estado"] == 'Aprobado'){
			
				$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

				if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
					//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
					socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
				}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
					//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
					socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
				}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
					//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
					socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
				}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
					//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
					socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
				}else if($_SESSION["sesionLinks"]->oficina == "VER"){
					//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
					socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
				}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
					//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
					socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
				}

				$tipoEnvio = "MENSAJE\n";
				socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

				$mensaje = "Genera Archivo Pago PECE\n";
				socket_write($sock, $mensaje, strlen($mensaje));

				$mensaje = "$referencia\n";
				socket_write($sock, $mensaje, strlen($mensaje));

				$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
				socket_write($sock, $mensaje, strlen($mensaje));

				$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
				socket_write($sock, $mensaje, strlen($mensaje));

				$mensaje = $clavebanco."\n";
				socket_write($sock, $mensaje, strlen($mensaje));

				$mensaje = $claveCuenta."\n";
				socket_write($sock, $mensaje, strlen($mensaje));

				$respuesta = trim(socket_read($sock, 1024));

				socket_close($sock);
				
				if($respuesta == "true"){
					echo true;
				}else{
					echo $respuesta;
				}
				
			}else{

				echo "Sin aprobación de Contabilidad para generar pago";
				
			}
			

		}else{

			
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

			if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
				//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
				//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
				//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
				//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "VER"){
				//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
				//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
			}

			$tipoEnvio = "MENSAJE\n";
			socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

			$mensaje = "Genera Archivo Pago PECE\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = "$referencia\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $clavebanco."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $claveCuenta."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$respuesta = trim(socket_read($sock, 1024));

			socket_close($sock);
			
			if($respuesta == "true"){
				echo true;
			}else{
				echo $respuesta;
			}
			
		}
			
    }

	function enviaDesistir($referencia) {
		
		$existeM = false;


		$ValidacionPagoDB = new conexionValidacionPago();							
		$archivoM = $ValidacionPagoDB->GetOne("SELECT XT_ARCHIVOM_DESISTIMIENTO FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' ");
		$ValidacionPagoDB->Close();

		$rutaRepositorio = "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$referencia."";
			
		if($fp = fopen($rutaRepositorio."/".$archivoM, "r")){

			$existeM = true;
			
			while(!feof($fp)) {

				$linea = explode("|", fgets($fp));

				if($linea[0] == "500"){
					$patente = $linea[2];
						//echo $patente."\n";
				}

				if($linea[0] == "801"){
					$prevalidador = $linea[4];

					$ValidacionPagoDB = new conexionValidacionPago;

					//echo "SELECT XT_NOMBRE_VALIDADOR_ARCHIVOM FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' \n";
					$prevalidadorNombre = $ValidacionPagoDB->GetOne("SELECT XT_NOMBRE_VALIDADOR_ARCHIVOM FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' ");

					if($prevalidadorNombre != ""){
						//echo "SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_NOMBRE = '".$prevalidadorNombre."'  \n";
						$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_NOMBRE = '".$prevalidadorNombre."' ");
					}else{
						//echo "SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ";
						$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ");
					}

					$ValidacionPagoDB->close(); 

					$hostValidador = $datosValidador["XT_SERVIDOR"];
					$portValidador = $datosValidador["XN_PUERTO"];
					$userValidador = $datosValidador["XT_USUARIO"];
					$passValidador = $datosValidador["XT_PASSWORD"];

					//echo $hostValidador."-".$portValidador."-".$userValidador."-".$passValidador."\n";
				}
			}

			fclose($fp);
			
			$conexionValidador = ftp_connect($hostValidador,$portValidador)or die("No se pudo conectar a $hostValidador <br><br>");
			//echo $conexionValidador;

			if($conexionValidador != false){

				//echo "conexion exitosa con el preevalidaor ".$host; 

				
				if(@ftp_login($conexionValidador, $userValidador, $passValidador)){

							//Iniciamos en modo pasivo
					ftp_pasv($conexionValidador, true);

					if($prevalidador == "058" || $prevalidador == "039"){
						if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
							$aduana = "470";
						}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
							$aduana = "800";
						}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
							$aduana = "650";
						}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
							$aduana = "430";
						}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
							$aduana = "530";
						}else if ($_SESSION["sesionLinks"]->oficina == "QRO") {
							$aduana = "640";
						}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX") {
							$aduana = "850";
						}

						if(!ftp_chdir($conexionValidador,$aduana)){
							ftp_mkdir($conexionValidador,$aduana);
							ftp_chdir($conexionValidador,$aduana);	
						}
					}else if($prevalidador == "011"){
						if($_SESSION["sesionLinks"]->oficina == 'SLP'){
							$aduana = "730";
						}

						if(!ftp_chdir($conexionValidador,$aduana)){
							ftp_mkdir($conexionValidador,$aduana);
							ftp_chdir($conexionValidador,$aduana);	
						}
					}else if($prevalidador == "010" && $prevalidadorNombre == "CAAAREM CONNECT"){
						if(!ftp_chdir($conexionValidador, "Envio")){
							ftp_mkdir($conexionValidador, "Envio");
							ftp_chdir($conexionValidador, "Envio");	
						}
					}

					$nombreArchivo = $archivoM;

					$targetFile = $rutaRepositorio."/".$archivoM;

					if(ftp_put($conexionValidador, $nombreArchivo, $targetFile,  FTP_BINARY) == true){

						$ValidacionPagoDB = new conexionValidacionPago();
						
						
						$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Esperando desistimiento', '".$_SESSION["sesionLinks"]->usuario."') ");
					

						$ValidacionPagoDB->Close();

						echo true;

					}else{
						echo "Error enviando archivo M a desistir";
					}

					ftp_close($conexionValidador); 	

				}else{
					echo "Error en login con el prevalidador";
				}
				

			}else{
				echo "Error de conexion con el preevalidaor ".$host; 
			}
			
			
		}
		

		if($existeM == false){
			echo "No existe archivo m de la referencia ".$referencia."\n";
		}
				
    }

	function enviaValidar($referencia) {

		$ValidacionPagoDB = new conexionValidacionPago();

		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Esperando validador', '".$_SESSION["sesionLinks"]->usuario."') ");

		$ValidacionPagoDB->Close();

		echo true;
					
    }

	function enviaPrevalidar($referencia) {
		
		$existeM = false;

		$rutaRepositorio = "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$referencia."";
		//echo "../tmp/VALIDACION/".$_SESSION["sesionLinks"]->oficina."/".$referencia." \n";

		$contenido = opendir($rutaRepositorio);

		while ($archivo = readdir($contenido)){ //obtenemos un archivo y luego otro sucesivamente
			if(substr($archivo,0,1) == "m"){

				$existeM = true;
				$archivoM = $archivo;

				$fp = fopen($rutaRepositorio."/".$archivoM, "r");
				//echo $rutaRepositorio."/".$archivoM;

				while(!feof($fp)) {

					$linea = explode("|", fgets($fp));

					if($linea[0] == "500"){
						$patente = $linea[2];
						$aduana = substr($linea[4], 0, 2);
							//echo $patente."\n";
					}

					if($linea[0] == "501"){
						$curp = $linea[9];
							//echo $curp."\n";
					}

					if($linea[0] == "801"){
						$prevalidador = $linea[4];

						$ValidacionPagoDB = new conexionValidacionPago;

						//echo "SELECT XT_NOMBRE_VALIDADOR_ARCHIVOM FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' \n";
						$prevalidadorNombre = $ValidacionPagoDB->GetOne("SELECT XT_NOMBRE_VALIDADOR_ARCHIVOM FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' ");

						if($prevalidadorNombre != ""){
							//echo "SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_NOMBRE = '".$prevalidadorNombre."'  \n";
							$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' AND XT_NOMBRE = '".$prevalidadorNombre."' ");
						}else{
							//echo "SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ";
							$datosValidador = $ValidacionPagoDB->GetRow("SELECT XT_SERVIDOR, XN_PUERTO, XT_USUARIO, XT_PASSWORD FROM VALIDADORES WHERE XT_VALIDADOR = '".$prevalidador."' and XT_PATENTE = '".$patente."' and XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."' ");
						}

						$ValidacionPagoDB->close(); 

						$hostValidador = $datosValidador["XT_SERVIDOR"];
						$portValidador = $datosValidador["XN_PUERTO"];
						$userValidador = $datosValidador["XT_USUARIO"];
						$passValidador = $datosValidador["XT_PASSWORD"];

						//echo $hostValidador."-".$portValidador."-".$userValidador."-".$passValidador."\n";
					}
				}

				fclose($fp);

				//echo $hostValidador."-".$portValidador."-".$userValidador."-".$passValidador."\n";
				
				$conexionValidador = ftp_connect($hostValidador,$portValidador)or die("No se pudo conectar a $hostValidador <br><br>");
				
				if($conexionValidador != false){

					//echo "conexion exitosa con el preevalidaor ".$host; 

					if(@ftp_login($conexionValidador, $userValidador, $passValidador)){
						
						//echo "Logeo exitoso";
						
						//Iniciamos en modo pasivo
						ftp_pasv($conexionValidador, true);

						if($prevalidador == "058" || $prevalidador == "039"){
							/*
							if($_SESSION["sesionLinks"]->oficina == 'CDMX'){
								$aduana = "470";
							}else if($_SESSION["sesionLinks"]->oficina == 'NLRD'){
								$aduana = "800";
							}else if($_SESSION["sesionLinks"]->oficina == 'TOL'){
								$aduana = "650";
							}else if($_SESSION["sesionLinks"]->oficina == 'VER'){
								$aduana = "430";
							}else if($_SESSION["sesionLinks"]->oficina == 'CUN'){
								$aduana = "530";
							}else if ($_SESSION["sesionLinks"]->oficina == "QRO") {
								$aduana = "640";
							}else if ($_SESSION["sesionLinks"]->oficina == "EDOMEX") {
								$aduana = "850";
							}*/

							$aduana = $aduana."0";

							if(!ftp_chdir($conexionValidador,$aduana)){
								ftp_mkdir($conexionValidador,$aduana);
								ftp_chdir($conexionValidador,$aduana);	
							}
						}else if($prevalidador == "011"){
							if($_SESSION["sesionLinks"]->oficina == 'SLP'){
								$aduana = "730";
							}

							if(!ftp_chdir($conexionValidador,$aduana)){
								ftp_mkdir($conexionValidador,$aduana);
								ftp_chdir($conexionValidador,$aduana);	
							}
						}else if($prevalidador == "010" && $prevalidadorNombre == "CAAAREM CONNECT"){
							if(!ftp_chdir($conexionValidador, "Envio")){
								ftp_mkdir($conexionValidador, "Envio");
								ftp_chdir($conexionValidador, "Envio");	
							}
						}

						$nombreArchivo = $archivoM;

						$targetFile = $rutaRepositorio."/".$archivoM;

						//echo $targetFile;
						
						if(ftp_put($conexionValidador, $nombreArchivo, $targetFile,  FTP_BINARY) == true){

							//echo "Archivo depositado";
							
							$ValidacionPagoDB = new conexionValidacionPago();
							
							if($_SESSION["sesionLinks"]->oficina == 'SLP'){
								$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Esperando validador', '".$_SESSION["sesionLinks"]->usuario."') ");
							}else{
								$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) values ('".$referencia."', 'Esperando prevalidador', '".$_SESSION["sesionLinks"]->usuario."') ");
							}

							$ValidacionPagoDB->Close();

							
							//Actualizacion a Legacy 
							if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
								$conexionSCIA = new ConexionSCIAMEX();
							}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
								$conexionSCIA = new ConexionSCIALAR();
							}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
								$conexionSCIA = new ConexionSCIACUN();
							}else if($_SESSION["sesionLinks"]->oficina == "VER"){
								$conexionSCIA = new ConexionSCIAVER();
							}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
								$conexionSCIA = new ConexionSCIATOL();
							}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
								$conexionSCIA = new ConexionSCIALAR();
							}
							
							if($_SESSION["sesionLinks"]->oficina == 'SLP'){
								$conexionSCIA->Execute("UPDATE PEDIMENTO.MONITOR_VAL_PAG SET ESTADO = 6, MENSAJE = 'Archivo de validación en espera de respuesta del SAT.', USUARIO = 'Links' WHERE REFERENCIA = '".$referencia."' AND CON_REC = 0");
							}else{
								$conexionSCIA->Execute("UPDATE PEDIMENTO.MONITOR_VAL_PAG SET ESTADO = 5, MENSAJE = 'Archivo de validación firmado y enviado al SAT.', USUARIO = 'Links' WHERE REFERENCIA = '".$referencia."' AND CON_REC = 0");
							}

							$conexionSCIA->Close();

							echo true;
							
						}else{
							echo "Error enviando archivo M a prevalidador";
						}
						
						ftp_close($conexionValidador); 	

					}else{
						echo "Error en login con el prevalidador";
					}

				}else{
					echo "Error de conexion con el preevalidaor ".$host; 
				}
			}
		}

		if($existeM == false){
			echo "No existe archivo m de la referencia ".$referencia."\n";
		}
				
    }

    function enviaGenerarM_RECTI($referencia, $causante, $prevalidador, $session, $prevalidadorNombre) {

    	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		$mensaje = "Genera Archivo Validacion RECTI\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $referencia."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $causante[0]["XT_CURP"]."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $causante[0]["XT_FIGURA"]."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = "$prevalidador\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){

			$ValidacionPagoDB = new ConexionValidacionPago();

	    	$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_CURP_CAUSANTE = '".$causante[0]["XT_CURP"]."', XT_VALIDADOR_ARCHIVOM = '".$prevalidador."', XT_NOMBRE_VALIDADOR_ARCHIVOM = '".$prevalidadorNombre."' WHERE XT_REFERENCIA = '".$referencia."' ");

	    	$ValidacionPagoDB->Close();

			echo true;
		}else{
			echo $respuesta;
		}
    }

	function enviaGenerarM_Desistimiento($referencia, $causante, $prevalidador, $session, $prevalidadorNombre) {

    	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		$mensaje = "Genera Archivo Validacion Desistimiento\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = "$referencia\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $causante[0]["XT_CURP"]."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $causante[0]["XT_FIGURA"]."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = "$prevalidador\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){

			$ValidacionPagoDB = new ConexionValidacionPago();

	    	$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_VALIDADOR_ARCHIVOM_DESISTIMIENTO = '".$prevalidador."', XT_NOMBRE_VALIDADOR_ARCHIVOM_DESISTIMIENTO = '".$prevalidadorNombre."' WHERE XT_REFERENCIA = '".$referencia."' ");

	    	$ValidacionPagoDB->Close();

			echo true;
		}else{
			echo $respuesta;
		}
    }

    function enviaGenerarM($referencia, $causante, $prevalidador, $session, $prevalidadorNombre) {

		//if($referencia == "26-403354"){

			//Actualizacion a Legacy 
			if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
				$conexionSCIA = new ConexionSCIAMEX();
			}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
				$conexionSCIA = new ConexionSCIALAR();
			}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
				$conexionSCIA = new ConexionSCIACUN();
			}else if($_SESSION["sesionLinks"]->oficina == "VER"){
				$conexionSCIA = new ConexionSCIAVER();
			}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
				$conexionSCIA = new ConexionSCIATOL();
			}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
				$conexionSCIA = new ConexionSCIALAR();
			}
			
			$incoterms = $conexionSCIA->GetArray("select pf.REFERENCIA, trim(pf.NUM_FACTURA) as NUM_FACTURA, pf.fecha_fact, pf.CLAVE_F, p.INC_FLETE, p.TIPO_MOVIMIENTO, trim(p.CLAVE_PEDIMENTO) as CLAVE_PEDIMENTO from PEDIMENTO.facturas pf, PEDIMENTO.PEDIMENTOS p WHERE pf.referencia = '".$referencia."' AND p.referencia = pf.referencia");
			
			for($a=0; $a<count($incoterms); $a++){
				if($incoterms[$a]["TIPO_MOVIMIENTO"] == "1"){
					
					if( $incoterms[$a]["CLAVE_F"] == "EXW" || $incoterms[$a]["CLAVE_F"] == "FCA" || $incoterms[$a]["CLAVE_F"] == "FOB" ){
						if( $incoterms[$a]["INC_FLETE"] == 0 ){
							if($incoterms[$a]["CLAVE_PEDIMENTO"] != "K1"){
								echo "Warning: Operacion con Incoterm ".$incoterms[$a]["CLAVE_F"]." e incrementables en 0 y clave Pedimento ".$incoterms[$a]["CLAVE_PEDIMENTO"]."\n"; 
								//return "Warning: Operacion con Incoterm ".$incoterms[$a]["CLAVE_F"]." e incrementables en 0 y clave Pedimento ".$incoterms[$a]["CLAVE_PEDIMENTO"]; 
							}
						}
						
					}/*else if( $incoterms[$a]["TIPO_MOVIMIENTO"] != "V1" || $incoterms[$a]["TIPO_MOVIMIENTO"] != "V2" || $incoterms[$a]["TIPO_MOVIMIENTO"] != "V5" || $incoterms[$a]["TIPO_MOVIMIENTO"] != "V6" ){
					}*/
				}
			}

			
			$rfcCausante = $conexionSCIA->GetOne(" SELECT trim(c.rfc) FROM pedimento.pedimentos p, pedimento.cliente c WHERE p.referencia = '26-403354' AND c.cliente = p.cliente");
			if(in_array($rfcCausante, ['ZME920824KM3' , 'BME0004112J6' , 'P&B0108104K7' , 'OME0107208X5' , 'TME030710K69' , 'ZHM040609ES5' , 'MDM041221RJ3' , 'UME091026UT6' , 'SME111206QU5' , 'NCG131029SK3' , 'RME140210IY5' , 'FGM150917IPA'])){
				$estatusFechas = 0;
				foreach($incoterms as $factura){
					// 1. Crear un objeto DateTime con la fecha de la factura
					$fechaFactura = new DateTime($factura['FECHA_FACT']);

					// 2. Sumarle 3 meses a esa fecha para obtener el límite exacto
					$fechaLimite = clone $fechaFactura;
					$fechaLimite->modify('+3 months');

					// 3. Obtener la fecha actual (o la fecha contra la que quieras comparar)
					$hoy = new DateTime(); 

					// 4. Comparar: Si la fecha actual es mayor a la fecha límite, han pasado más de 3 meses
					if ($hoy > $fechaLimite) {
						echo "La factura ".$factura['NUM_FACTURA']." tiene más de 3 meses de antigüedad (".$factura['FECHA_FACT'].").\n";
						$estatusFechas = 1;
					}
				}

				if($estatusFechas == 1){
					echo "\nEs importante revisar información correcta antes de proceder al pago.\n";
				}
			}
			
			$conexionSCIA->Close();

		//}else{

			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

			if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
				//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
				//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
				//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
				//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "VER"){
				//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
			}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
				//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
				socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
			}

			$tipoEnvio = "MENSAJE\n";
			socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

			$mensaje = "Genera Archivo Validacion PECE\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = "$referencia\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $causante[0]["XT_CURP"]."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = $causante[0]["XT_FIGURA"]."\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$mensaje = "$prevalidador\n";
			socket_write($sock, $mensaje, strlen($mensaje));

			$respuesta = trim(socket_read($sock, 1024));

			socket_close($sock);
			
			if($respuesta == "true"){

				$ValidacionPagoDB = new ConexionValidacionPago();

				$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_CURP_CAUSANTE = '".$causante[0]["XT_CURP"]."', XT_VALIDADOR_ARCHIVOM = '".$prevalidador."', XT_NOMBRE_VALIDADOR_ARCHIVOM = '".$prevalidadorNombre."' WHERE XT_REFERENCIA = '".$referencia."' ");

				$ValidacionPagoDB->Close();

				echo true;
			}else{
				echo $respuesta;
			}

		//}
    }

	function cargaReferencias($referencias, /*$estatusDesistimiento,*/ $session) {

		foreach ($referencias as $referencia) {

			if($referencia != ''){

				$ValidacionPagoDB = new ConexionValidacionPago();

				$registro = $ValidacionPagoDB->GetRow("SELECT XT_REFERENCIA, XT_USUARIO FROM REFERENCIAS WHERE XT_REFERENCIA = '".$referencia."' ");


				if($registro == null){

					$datosReferencia = null;
					$conexionSCIA = null;
					$con_rec = "";

					if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

						$conexionSCIA = new ConexionSCIAMEX();

					}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
						
						$conexionSCIA = new ConexionSCIALAR();

					}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
						
						$conexionSCIA = new ConexionSCIACUN();

					}else if($_SESSION["sesionLinks"]->oficina == "VER"){
						
						$conexionSCIA = new ConexionSCIAVER();

					}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
						
						$conexionSCIA = new ConexionSCIATOL();

					}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
						
						$conexionSCIA = new ConexionSCIALAR();

					}


					if (strpos($referencia, '_R') !== false) {
						
						//Es RECTIFICAION
						$referencia = explode("_R", $referencia)[0]."_R".intval(explode("_R", $referencia)[1]);
						$con_rec = "AND con_rec = ".explode("_R", $referencia)[1];

						/*	
						echo "SELECT
								p.*,
								( SELECT trim(CLAVE) FROM pedimento.rcasos_g WHERE referencia = p.referencia AND trim(CLAVE) = 'OC' ".$con_rec." ) as CONTINGENCIA,
								( SELECT count( f.NUM_FACTURA ) FROM pedimento.rfacturas f WHERE trim( f.referencia ) = trim( p.referencia ) AND f.consecu > 0 ".$con_rec." ) AS FACTURAS,
								( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'F' ".$con_rec." ) AS COVES,
								( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'P' ".$con_rec." ) AS EDOCSDV,
								( SELECT count( ID_CASO ) FROM pedimento.rcasos_g where REFERENCIA = p.referencia and ID_CASO like 'COVE%' ".$con_rec." ) AS CASOS_G,	
								( SELECT count(ID_CASO) FROM PEDIMENTO.rCASOS_G WHERE REFERENCIA = p.referencia and CLAVE = 'ED' AND ID_CASO NOT LIKE 'COVE%' ".$con_rec." ) AS EDOCS
							FROM
								pedimento.rpedimentos p 
							WHERE
								trim( p.referencia ) = '".explode("_", $referencia)[0]."' ".$con_rec."  ";
						*/

						$datosReferencia = $conexionSCIA->GetRow("
							SELECT
								p.*,
								( SELECT trim(CLAVE) FROM pedimento.rcasos_g WHERE referencia = p.referencia AND trim(CLAVE) = 'OC' ".$con_rec." ) as CONTINGENCIA,
								( SELECT count( f.NUM_FACTURA ) FROM pedimento.rfacturas f WHERE trim( f.referencia ) = trim( p.referencia ) AND f.consecu > 0 ".$con_rec." ) AS FACTURAS,
								( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'F' ".$con_rec." ) AS COVES,
								( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'P' ".$con_rec." ) AS EDOCSDV,
								( SELECT count( ID_CASO ) FROM pedimento.rcasos_g where REFERENCIA = p.referencia and ID_CASO like 'COVE%' ".$con_rec." ) AS CASOS_G,	
								( SELECT count(ID_CASO) FROM PEDIMENTO.rCASOS_G WHERE REFERENCIA = p.referencia and CLAVE = 'ED' AND ID_CASO NOT LIKE 'COVE%' ".$con_rec." ) AS EDOCS
							FROM
								pedimento.rpedimentos p 
							WHERE
								trim( p.referencia ) = '".explode("_", $referencia)[0]."' ".$con_rec." 
						");


						if($datosReferencia != null){


							if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
								$estatusReferencia = $conexionSCIA->GetRow("SELECT ESTATUS_PROGRAMACION, ESTATUS_PREVIO, FORMA_PAGO FROM pedimento.APROBACION_VALIDACION WHERE REFERENCIA = '".explode("_", $referencia)[0]."' ");

								if($estatusReferencia == null){
									echo "No Existe Registro de Aprobacion !";
								}else{

									if($estatusReferencia["ESTATUS_PROGRAMACION"] == 1 && $estatusReferencia["ESTATUS_PREVIO"] == 1 && $estatusReferencia["FORMA_PAGO"] >= 1){
										
										if($datosReferencia['CONTINGENCIA'] == null){

											if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

												if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

													if($datosReferencia['EDOCS']>0){

														if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

															$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

															$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");
														
															echo true;

														}else{

															echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";

														}

													}else{

														echo "Operacion sin Edocuments !!";

													}
												}else{

													echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

												}
											}else{

												echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

											}

										}else if($datosReferencia['CONTINGENCIA'] == "OC"){

											$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

											$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

											echo true;
										}

									}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0 && $estatusReferencia["ESTATUS_PREVIO"] == 0){

										echo "Pedimento Sin Previo y No Programado !!";

									}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0){

										echo "Pedimento No Programado !!";

									}else if($estatusReferencia["ESTATUS_PREVIO"] == 0){

										echo "Pedimento Sin Previo !!";

									}else if($estatusReferencia["FORMA_PAGO"] == 0){

										echo "Pedimento Sin 1 nivel !!";

									}
								}

							}else if($_SESSION["sesionLinks"]->oficina == "VER" || $_SESSION["sesionLinks"]->oficina == "CUN"){

								if($datosReferencia['CONTINGENCIA'] == null){
									
									if($_SESSION["sesionLinks"]->oficina == "CUN"){
										$estatusReferencia = $conexionSCIA->GetRow("SELECT (select COUNT(e.FACTURA) FROM SCIA.T_FACTURAS_ENAJENACION e where trim(e.REFERENCIA) = trim(p.REFERENCIA)) as ENAJENACION, 0 AS CONSOLIDADOS FROM PEDIMENTO.RPEDIMENTOS p WHERE p.REFERENCIA = '".explode("_", $referencia)[0]."'  ".$con_rec."  ");

									}else if($_SESSION["sesionLinks"]->oficina == "VER"){
										$estatusReferencia = $conexionSCIA->GetRow("SELECT (select COUNT(e.FACTURA) FROM SCIA.T_FACTURAS_ENAJENACION e where trim(e.REFERENCIA) = trim(p.REFERENCIA)) as ENAJENACION, (SELECT COUNT(cf.NUM_FAC) FROM PEDIMENTO.CONSOL_FAC cf WHERE trim(cf.REFERENCIA) = p.REFERENCIA) AS CONSOLIDADOS FROM PEDIMENTO.RPEDIMENTOS p WHERE p.REFERENCIA = '".explode("_", $referencia)[0]."'  ".$con_rec."  ");

									}
									
									if($estatusReferencia == null){
										echo "No Existe detalle de la referencia !";
									}else{

										if($estatusReferencia["ENAJENACION"] > 0){
											
											if(($datosReferencia['COVES'] + $estatusReferencia["ENAJENACION"]) == $datosReferencia['FACTURAS']){

												$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

												$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

												echo true;

											}else{

												echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".($datosReferencia['COVES'] + $estatusReferencia["ENAJENACION"]).", no coinciden !!";

											}
										}else if($estatusReferencia["CONSOLIDADOS"] > 0){

											if($estatusReferencia["CONSOLIDADOS"] == $datosReferencia['FACTURAS']){

												$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

												$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

												echo true;

											}else{

												echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$estatusReferencia["CONSOLIDADOS"]." no coinciden !!";

											}

										}else{

											if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

												if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

													if($datosReferencia['EDOCS']>0 || $datosReferencia['CLAVE_PEDIMENTO'] = "V1"){

														$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

														$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

														echo true;

													}else{

														echo "Operacion sin Edocuments !!";

													}
												}else{

													echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

												}
											}else{

												echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

											}

										}	
									}

								}else if($datosReferencia['CONTINGENCIA'] == "OC"){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;
								}

							}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

								if($datosReferencia['CONTINGENCIA'] == null){
									/*
									$estatusReferencia = $conexionSCIA->GetRow("SELECT
									CASE (select TO_CHAR( ap.FECHA_APROBACION, 'DD/MM/YYYY') from pedimento.APROBACION_PAGO ap where ap.REFERENCIA = av.REFERENCIA 
									AND TO_CHAR( ap.FECHA_APROBACION, 'DD/MM/YYYY' ) = TO_CHAR( av.FECHA_APROBACION, 'DD/MM/YYYY' )) WHEN TO_CHAR( av.FECHA_APROBACION, 'DD/MM/YYYY' )
								  THEN 1 ELSE 0 END ESTATUS_PROGRAMACION,
									av.ESTATUS_PREVIO, av.FORMA_PAGO FROM pedimento.APROBACION_VALIDACION  av WHERE av.REFERENCIA = '".explode("_", $referencia)[0]."' AND TO_DATE( av.FECHA_APROBACION, 'DD/MM/YYYY' ) <= TO_DATE('".date("d/m/Y")."', 'DD/MM/YYYY' ) ORDER BY FECHA_APROBACION DESC ");
									*/

									//echo $_SESSION["sesionLinks"]->oficina."<br><br>";

									//echo "SELECT av.ESTATUS_PREVIO,
									//av.FORMA_PAGO  FROM pedimento.APROBACION_VALIDACION  av WHERE av.REFERENCIA = '".explode("_", $referencia)[0]."' ";

									$estatusReferencia = $conexionSCIA->GetRow("
										SELECT 
											CASE (
												SELECT
													TO_CHAR( ap.FECHA_APROBACION, 'DD/MM/YYYY' ) 
												FROM
													pedimento.APROBACION_PAGO ap 
												WHERE
													ap.REFERENCIA = av.REFERENCIA 
													AND TO_CHAR( ap.FECHA_APROBACION, 'DD/MM/YYYY' ) = TO_CHAR( av.FECHA_APROBACION, 'DD/MM/YYYY' ) 
											) 
											WHEN TO_CHAR( av.FECHA_APROBACION, 'DD/MM/YYYY' )
											THEN 1 ELSE 0 END ESTATUS_PROGRAMACION,
											av.ESTATUS_PREVIO,
											av.FORMA_PAGO  
										FROM pedimento.APROBACION_VALIDACION  av 
										WHERE av.REFERENCIA = '".explode("_", $referencia)[0]."' 
									");

									//var_dump($estatusReferencia);

									if($estatusReferencia == null){
										echo "No Existe Registro de Aprobacion !";
									}else{

										if($datosReferencia["TIPO_MOVIMIENTO"] == 1){

											if($estatusReferencia["ESTATUS_PROGRAMACION"] == 1){
											
												if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

													if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

														if($datosReferencia['EDOCS']>0){

															if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

																$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

																$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

																echo true;

															}else{

																echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";
	
															}

														}else{
															echo "Operacion sin Edocuemnts!!";
														}
													}else{

														echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

													}
												}else{

													echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

												}
												
											}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0 && $estatusReferencia["ESTATUS_PREVIO"] == 0){

												echo "Pedimento Sin Previo y No Programado !!";

											}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0){

												echo "Pedimento No Programado !!";

											}else if($estatusReferencia["ESTATUS_PREVIO"] == 0){

												echo "Pedimento Sin Previo !!";

											}

										}else if($datosReferencia["TIPO_MOVIMIENTO"] == 2){

											if($estatusReferencia["ESTATUS_PROGRAMACION"] == 1){
											
												if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

													if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

														if($datosReferencia['EDOCS']>0){

															if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

																$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

																$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

																echo true;
															
															}else{

																echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";
	
															}

														}else{

															echo "Operacion sin Edocuments!!";

														}
													}else{

														echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

													}
												}else{

													echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

												}
												
											}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0){

												echo "Pedimento No Programado !!";

											}
										}
									}
								}else if($datosReferencia['CONTINGENCIA'] == "OC"){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;
								}

							}else{

								if($datosReferencia['CONTINGENCIA'] == null){

									if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

										if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){
											
											if($datosReferencia['EDOCS']>0){

												if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

													$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

													$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

													echo true;
													
												}else{

													echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";

												}

											}else{

												echo "Operacion sin Edocuemnts!!";

											}

										}else{

											echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

										}
									}else{

										echo "Facturas ". $datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

									}
									
								}else if($datosReferencia['CONTINGENCIA'] == "OC"){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;
								}

							}

						}else{

							echo "No existe informacion en Pedimento de la referencia ".$referencia."\n";
							
						}
						

					}else{

						//OPERACION NORMAL
						if($_SESSION["sesionLinks"]->oficina == "TOL"){
							$datosReferencia = $conexionSCIA->GetRow("SELECT
									p.*,
									( SELECT trim(CLAVE) FROM pedimento.casos_g WHERE referencia = p.referencia AND trim(CLAVE) = 'OC') as CONTINGENCIA,
									( SELECT count( f.NUM_FACTURA ) FROM pedimento.facturas f WHERE trim( f.referencia ) = trim( p.referencia ) AND f.consecu > 0 ) AS FACTURAS,
									( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'F' and con_rec=0 ) AS COVES,
									( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'P' and con_rec=0 ) AS EDOCSDV,
									( SELECT count( ID_CASO ) FROM pedimento.casos_g where REFERENCIA = p.referencia and ID_CASO like 'COVE%' ) AS CASOS_G,	
									( SELECT count(ID_CASO) FROM PEDIMENTO.CASOS_G WHERE REFERENCIA = p.referencia and CLAVE = 'ED' AND ID_CASO NOT LIKE 'COVE%' ) AS EDOCS,
									( SELECT estatus FROM R_REFCONSOL WHERE referencia = trim(p.referencia)) as CONSOLIDADO
								FROM
									pedimento.pedimentos p 
								WHERE
									trim( p.referencia ) = '".$referencia."' 
							");
						}else{
							$datosReferencia = $conexionSCIA->GetRow("SELECT
									p.*,
									( SELECT trim(CLAVE) FROM pedimento.casos_g WHERE referencia = p.referencia AND trim(CLAVE) = 'OC') as CONTINGENCIA,
									( SELECT count( f.NUM_FACTURA ) FROM pedimento.facturas f WHERE trim( f.referencia ) = trim( p.referencia ) AND f.consecu > 0 ) AS FACTURAS,
									( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'F' and con_rec=0 ) AS COVES,
									( SELECT count( edocum ) FROM pedimento.doctosvucem WHERE trim( trafico ) = trim( p.referencia ) AND CVEDOCTO = 'P' and con_rec=0 ) AS EDOCSDV,
									( SELECT count( ID_CASO ) FROM pedimento.casos_g where REFERENCIA = p.referencia and ID_CASO like 'COVE%' ) AS CASOS_G,	
									( SELECT count(ID_CASO) FROM PEDIMENTO.CASOS_G WHERE REFERENCIA = p.referencia and CLAVE = 'ED' AND ID_CASO NOT LIKE 'COVE%' ) AS EDOCS
								FROM
									pedimento.pedimentos p 
								WHERE
									trim( p.referencia ) = '".$referencia."' 
							");
						}

						if($datosReferencia != null){

							if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
								$estatusReferencia = $conexionSCIA->GetRow("SELECT ESTATUS_PROGRAMACION, ESTATUS_PREVIO, FORMA_PAGO FROM pedimento.APROBACION_VALIDACION WHERE REFERENCIA = '".$referencia."' AND TO_CHAR(FECHA_APROBACION, 'DD/MM/YYYY') <= '".date("d/m/Y")."' ");

								if($estatusReferencia == null){
									echo "No Existe Registro de Aprobacion !";
								}else{

									if($estatusReferencia["ESTATUS_PROGRAMACION"] == 1 && $estatusReferencia["ESTATUS_PREVIO"] == 1 && $estatusReferencia["FORMA_PAGO"] >= 1){
								
										if($datosReferencia['CONTINGENCIA'] == null){

											if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

												if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

													if($datosReferencia['EDOCS']>0){

														if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

															$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

															$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

															echo true;

														}else{

															echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";

														}

													}else{

														echo "Operacion sin Edocuments !!";

													}
												}else{

													echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

												}
											}else{

												echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

											}

										}else if($datosReferencia['CONTINGENCIA'] == "OC"){

											$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

											$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

											echo true;
										}

									}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0 && $estatusReferencia["ESTATUS_PREVIO"] == 0){

										echo "Pedimento Sin Previo y No Programado !!";

									}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0){

										echo "Pedimento No Programado !!";

									}else if($estatusReferencia["ESTATUS_PREVIO"] == 0){

										echo "Pedimento Sin Previo !!";

									}else if($estatusReferencia["FORMA_PAGO"] == 0){

										echo "Pedimento Sin 1 nivel !!";

									}
								}

							}else if($_SESSION["sesionLinks"]->oficina == "VER" || $_SESSION["sesionLinks"]->oficina == "CUN"){

								if($datosReferencia['CONTINGENCIA'] == null){

									if($_SESSION["sesionLinks"]->oficina == "CUN"){
										$estatusReferencia = $conexionSCIA->GetRow("SELECT av.ESTATUS_PROGRAMACION, av.ESTATUS_PREVIO, (select COUNT(e.FACTURA) FROM SCIA.T_FACTURAS_ENAJENACION e where e.REFERENCIA = av.REFERENCIA) as ENAJENACION, 0 AS CONSOLIDADOS FROM pedimento.APROBACION_VALIDACION av WHERE av.REFERENCIA = '".$referencia."' AND TO_CHAR(av.FECHA_APROBACION, 'DD/MM/YYYY') <= '".date("d/m/Y")."' ");

									}else if($_SESSION["sesionLinks"]->oficina == "VER"){
										$estatusReferencia = $conexionSCIA->GetRow("SELECT av.ESTATUS_PROGRAMACION, av.ESTATUS_PREVIO, (select COUNT(e.FACTURA) FROM SCIA.T_FACTURAS_ENAJENACION e where e.REFERENCIA = av.REFERENCIA) as ENAJENACION, (SELECT COUNT(cf.NUM_FAC) FROM PEDIMENTO.CONSOL_FAC cf WHERE trim(cf.REFERENCIA) = av.REFERENCIA) AS CONSOLIDADOS FROM pedimento.APROBACION_VALIDACION av WHERE av.REFERENCIA = '".$referencia."' AND TO_CHAR(av.FECHA_APROBACION, 'DD/MM/YYYY') <= '".date("d/m/Y")."' ");

									}
									
									if($estatusReferencia == null){
										echo "No Existe Registro de Aprobacion !";
									}else{

										if($estatusReferencia["ESTATUS_PROGRAMACION"] == 1 && $estatusReferencia["ESTATUS_PREVIO"] == 1){

											if($estatusReferencia["ENAJENACION"] > 0){
												
												if(($datosReferencia['COVES'] + $estatusReferencia["ENAJENACION"]) == $datosReferencia['FACTURAS']){

													$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

													$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

													echo true;

												}else{

													echo "Facturas ".$datosReferencia['FACTURAS']." y coves + enagenacion ".($datosReferencia['COVES'] + $estatusReferencia["ENAJENACION"]).", no coinciden !!";

												}
											}else if($estatusReferencia["CONSOLIDADOS"] > 0){

												if($estatusReferencia["CONSOLIDADOS"] == $datosReferencia['FACTURAS']){

													$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

													$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

													echo true;

												}else{

													echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$estatusReferencia["CONSOLIDADOS"].", no coinciden !!";

												}

											}else{

												if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

													if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

														if($datosReferencia['EDOCS']>0 || $datosReferencia['CLAVE_PEDIMENTO'] = "V1"){

															$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

															$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

															echo true;

														}else{

															echo "Operacion sin Edocuments !!";

														}
													}else{

														echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

													}
												}else{

													echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

												}

											}	
											
										}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0 && $estatusReferencia["ESTATUS_PREVIO"] == 0){

											echo "Pedimento Sin Previo y No Programado !!";

										}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0){

											echo "Pedimento No Programado !!";

										}else if($estatusReferencia["ESTATUS_PREVIO"] == 0){

											echo "Pedimento Sin Previo !!";

										}
									}

								}else if($datosReferencia['CONTINGENCIA'] == "OC"){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;
								}

							}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

								if($datosReferencia['CONTINGENCIA'] == null){

									$estatusReferencia = $conexionSCIA->GetRow("SELECT
									CASE (select TO_CHAR( ap.FECHA_APROBACION, 'DD/MM/YYYY') from pedimento.APROBACION_PAGO ap where ap.REFERENCIA = av.REFERENCIA 
									AND TO_CHAR( ap.FECHA_APROBACION, 'DD/MM/YYYY' ) = TO_CHAR( av.FECHA_APROBACION, 'DD/MM/YYYY' )) WHEN TO_CHAR( av.FECHA_APROBACION, 'DD/MM/YYYY' )
								  THEN 1 ELSE 0 END ESTATUS_PROGRAMACION,
									av.ESTATUS_PREVIO, av.FORMA_PAGO FROM pedimento.APROBACION_VALIDACION  av WHERE av.REFERENCIA = '".$referencia."' AND TO_CHAR( av.FECHA_APROBACION, 'DD/MM/YYYY' ) <= '".date("d/m/Y")."' ORDER BY FECHA_APROBACION DESC ");

									if($estatusReferencia == null){
										echo "No Existe Registro de Aprobacion !";
									}else{

										if($datosReferencia["TIPO_MOVIMIENTO"] == 1){

											if($estatusReferencia["ESTATUS_PROGRAMACION"] == 1/* && $estatusReferencia["ESTATUS_PREVIO"] == 1*/){
											
												if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

													if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

														if($datosReferencia['EDOCS']>0){

															if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

																$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

																$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

																echo true;

															}else{

																echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";

															}

														}else{
															echo "Operacion sin Edocuemnts!!";
														}
													}else{

														echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

													}
												}else{

													echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

												}
												
											}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0 && $estatusReferencia["ESTATUS_PREVIO"] == 0){

												echo "Pedimento Sin Previo y No Programado !!";

											}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0){

												echo "Pedimento No Programado !!";

											}else if($estatusReferencia["ESTATUS_PREVIO"] == 0){

												echo "Pedimento Sin Previo !!";

											}

										}else if($datosReferencia["TIPO_MOVIMIENTO"] == 2){

											if($estatusReferencia["ESTATUS_PROGRAMACION"] == 1){
											
												if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

													if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){

														if($datosReferencia['EDOCS']>0){

															if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

																$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

																$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

																echo true;

															}else{

																echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";
	
															}

														}else{

															echo "Operacion sin Edocuments!!";

														}
													}else{

														echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

													}
												}else{

													echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

												}
												
											}else if($estatusReferencia["ESTATUS_PROGRAMACION"] == 0){

												echo "Pedimento No Programado !!";

											}
										}
									}
								}else if($datosReferencia['CONTINGENCIA'] == "OC"){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;
								}

							}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

								if($datosReferencia['CONSOLIDADO'] == true){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;

								}else if($datosReferencia['CONTINGENCIA'] == null){

									if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

										if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){
											
											if($datosReferencia['EDOCS']>0){

												if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

													$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

													$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

													echo true;

												}else{

													echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";

												}

											}else{

												echo "Operacion sin Edocuemnts!!";

											}

										}else{

											echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

										}
									}else{

										echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

									}
									
								}else if($datosReferencia['CONTINGENCIA'] == "OC"){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;
								}

							}else{

								if($datosReferencia['CONTINGENCIA'] == null){

									if($datosReferencia['COVES'] == $datosReferencia['FACTURAS']){

										if($datosReferencia['COVES'] == $datosReferencia['CASOS_G']){
											
											if($datosReferencia['EDOCS']>0){

												if($datosReferencia['EDOCS'] == $datosReferencia['EDOCSDV']){

													$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

													$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

													echo true;

												}else{

													echo "Edocs casos_g ".$datosReferencia['EDOCS']." doctosvucem ".$datosReferencia['EDOCSDV'].", no coinciden  !!";

												}

											}else{

												echo "Operacion sin Edocuemnts!!";

											}

										}else{

											echo "doctosvucem ".$datosReferencia['COVES']." y casos_g ".$datosReferencia['CASOS_G'].", no coinciden!!";

										}
									}else{

										echo "Facturas ".$datosReferencia['FACTURAS']." y coves ".$datosReferencia['COVES'].", no coinciden !!";

									}
									
								}else if($datosReferencia['CONTINGENCIA'] == "OC"){

									$ValidacionPagoDB->Execute("INSERT INTO REFERENCIAS (XT_REFERENCIA, XT_USUARIO, XT_OFICINA) VALUES ('".$referencia."', '".$_SESSION["sesionLinks"]->usuario."', '".$_SESSION["sesionLinks"]->oficina."') ");

									$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

									echo true;
								}

							}

						}else{

							echo "No existe informacion en Pedimento de la referencia ".$referencia."\n";
							
						}

					}


				}else{

					echo "La referencia ".$registro["XT_REFERENCIA"]." ya existe con el usuario ".$registro["XT_USUARIO"]."\n";

				}

				$ValidacionPagoDB->Close();
			}
			
		}
					
    }


    function paraGenerarM($referencia, $session) {

    	$ValidacionPagoDB = new conexionValidacionPago();
    	
		$archivoM = $ValidacionPagoDB->GetOne("SELECT XT_ARCHIVOM FROM REFERENCIAS WHERE xt_referencia = '".$referencia."' ");

		//Elimino registro y archivos
    	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Error en crear el socket");

		if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){
			//socket_connect($sock,"gea-aicm.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.169.26",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){
			//socket_connect($sock,"geacancun.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.166.241",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){
			//socket_connect($sock,"nyetoluca.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.167.203",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "VER"){
			//socket_connect($sock,"nyeveracruz.dyndns.org",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.168.253",'2666') or die("Error al conectarse");
		}else if($_SESSION["sesionLinks"]->oficina == "SLP"){
			//socket_connect($sock,"71.144.19.158",'2666') or die("Error al conectarse");
			socket_connect($sock,"192.1.171.71",'2666') or die("Error al conectarse");
		}

		$tipoEnvio = "MENSAJE\n";
		socket_write($sock, $tipoEnvio, strlen($tipoEnvio));

		$mensaje = "Elimina Archivo VP\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->oficina."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $referencia."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $archivoM."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$mensaje = $_SESSION["sesionLinks"]->usuario."\n";
		socket_write($sock, $mensaje, strlen($mensaje));

		$respuesta = trim(socket_read($sock, 1024));

		socket_close($sock);
		
		if($respuesta == "true"){
		
			$ValidacionPagoDB->Execute("UPDATE REFERENCIAS SET XT_ARCHIVOM = '', XT_VALIDADOR_ARCHIVOM = '', XT_NOMBRE_VALIDADOR_ARCHIVOM = '' WHERE XT_REFERENCIA = '".$referencia."' ");

    		$ValidacionPagoDB->Execute("INSERT INTO ESTATUS (XT_REFERENCIA, XT_ESTATUS, XT_USUARIO) VALUES ('".$referencia."', 'Para generar M', '".$_SESSION["sesionLinks"]->usuario."') ");

			echo true;
		
		}else{
			echo $respuesta;
		}
		

		$ValidacionPagoDB->Close();
					
    }

    function obtenDatosReferencia($referencia) {

    	$datos = null;
		$tmp = null;

    	$ValidacionPagoDB = new conexionValidacionPago();

    	$tmp = $ValidacionPagoDB->GetArray("SELECT
											r.XT_REFERENCIA,
											r.XT_USUARIO,
											s.XT_ESTATUS,
											r.XT_ARCHIVOM,
											r.XT_ARCHIVOE,
											DATE_FORMAT(r.XD_FECHA,'%d-%m-%Y')
										FROM
											REFERENCIAS r, ESTATUS s
										WHERE
											r.XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."'
										AND r.XT_REFERENCIA = '".$referencia."'
										AND s.XT_REFERENCIA = r.XT_REFERENCIA
										AND s.XD_FECHA = (SELECT MAX(s2.XD_FECHA) FROM ESTATUS s2 WHERE s2.XT_REFERENCIA = r.XT_REFERENCIA)
										ORDER BY r.XD_FECHA DESC
								 ");

		for($a=0; $a<count($tmp); $a++){
			for($b=0; $b<((count($tmp[$a])/2)); $b++){
				$datos[$a][$b] = $tmp[$a][$b];
			}
			
			$referencia = 0;
			$usuario = 1;
			$estatus = 2;
			
			if($datos[$a][$estatus] == "Error pagar"){

				//$Validacion_Pago = new Validacion_Pago;
				$tmp2["detalle"] = $this->obtenDetalleError($datos[$a], $_SESSION["sesionLinks"], $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para pagar"){

				//$Validacion_Pago = new Validacion_Pago;
				$tmp2["validadores"] = $this->obtenValidadores($datos[$a], $_SESSION["sesionLinks"], $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para generar E"){

				//$Validacion_Pago = new Validacion_Pago;
				$tmp2["peca"] = $this->obtenPeca($datos[$a], $_SESSION["sesionLinks"], $ValidacionPagoDB);
				$tmp2["bancos"] = $this->obtenBancos($datos[$a], $_SESSION["sesionLinks"], $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para generar M"){

				//$Validacion_Pago = new Validacion_Pago;
				$tmp2["firmas"] = $this->obtenFirmasReferencia($datos[$a], $_SESSION["sesionLinks"], $ValidacionPagoDB);
				$tmp2["prevalidadores"] = $this->obtenValidadores($datos[$a], $_SESSION["sesionLinks"], $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para generar cancelacion"){

				$tmp2["prevalidadores"] = $this->obtenValidadores($datos[$a], $_SESSION["sesionLinks"], $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para cerrar consolidado" || $datos[$a][$estatus] == "Consolidado cerrado"){

				$tmp2["estatusConsolidado"] = $this->obtenEstatusConsolidado($datos[$a], $_SESSION["sesionLinks"]);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else{
				$tmp2 = null;
				//$Validacion_Pago = new Validacion_Pago;
				//$tmp2["detalle"] = $this->obtenDetalle($datos[$a], $session);

				$datos[$a][count($tmp[$a])/2] = $tmp2;
			}
		}
		
		$ValidacionPagoDB->Close();
		
		return $datos;
    }


    function obtenDatosActualizados($session) {
		echo json_encode($this->obtenDatosTablero($session));
    }

	
    function obtenDatosTablero($session) {
		
		$caracteres = array("\'", '\"', "'", '"');
		
		$datos = null;
		$tmp = null;

		$ValidacionPagoDB = new conexionValidacionPago();

		if(@array_key_exists("F0091", $_SESSION["sesionLinks"]->permisos["GEA990415MQ5"]["R007"]["A0000"]) || @array_key_exists("F0091", $_SESSION["sesionLinks"]->permisos["ACA140623TXA"]["R007"]["A0000"])){

			$tmp = $ValidacionPagoDB->GetArray("SELECT
											r.XT_REFERENCIA,
											r.XT_USUARIO,
											s.XT_ESTATUS,
											r.XT_ARCHIVOM,
											r.XT_ARCHIVOE,
											DATE_FORMAT(r.XD_FECHA,'%d-%m-%Y')
										FROM
											REFERENCIAS r, ESTATUS s
										WHERE
											r.XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."'
										AND r.XT_REFERENCIA not in (SELECT distinct s2.XT_REFERENCIA from ESTATUS s2 where s2.XT_ESTATUS = 'Liberado' AND DATE_FORMAT(s2.XD_FECHA, '%d-%m-%Y')!=DATE_FORMAT(SYSDATE(), '%d-%m-%Y'))
										AND s.XT_REFERENCIA = r.XT_REFERENCIA
										AND s.XD_FECHA = (SELECT MAX(s2.XD_FECHA) FROM ESTATUS s2 WHERE s2.XT_REFERENCIA = r.XT_REFERENCIA)
										ORDER BY r.XD_FECHA DESC
								 ");

		}else{

			$tmp = $ValidacionPagoDB->GetArray("SELECT
											r.XT_REFERENCIA,
											r.XT_USUARIO,
											s.XT_ESTATUS,
											r.XT_ARCHIVOM,
											r.XT_ARCHIVOE,
											DATE_FORMAT(r.XD_FECHA,'%d-%m-%Y')
										FROM
											REFERENCIAS r, ESTATUS s
										WHERE
											r.XT_USUARIO = '".$_SESSION["sesionLinks"]->usuario."'
										AND r.XT_OFICINA = '".$_SESSION["sesionLinks"]->oficina."'
										AND r.XT_REFERENCIA not in (SELECT distinct s2.XT_REFERENCIA from ESTATUS s2 where s2.XT_ESTATUS = 'Liberado' AND DATE_FORMAT(s2.XD_FECHA, '%d-%m-%Y')!=DATE_FORMAT(SYSDATE(), '%d-%m-%Y'))
										AND s.XT_REFERENCIA = r.XT_REFERENCIA
										AND s.XD_FECHA = (SELECT MAX(s2.XD_FECHA) FROM ESTATUS s2 WHERE s2.XT_REFERENCIA = r.XT_REFERENCIA)
										ORDER BY r.XD_FECHA DESC
								 ");

		}

		$firmasScia = false;
				
		for($a=0; $a<count($tmp); $a++){
			for($b=0; $b<((count($tmp[$a])/2)); $b++){
				$datos[$a][$b] = $tmp[$a][$b];
			}
			
			$referencia = 0;
			$usuario = 1;
			$estatus = 2;
			
			if($datos[$a][$estatus] == "Error pagar"){

				$tmp2["detalle"] = $this->obtenDetalleError($datos[$a], $session, $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para pagar"){


				$tmp2["validadores"] = $this->obtenValidadores($datos[$a], $session, $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para generar E"){

				$tmp2["peca"] = $this->obtenPeca($datos[$a], $session, $ValidacionPagoDB);
				$tmp2["bancos"] = $this->obtenBancos($datos[$a], $session, $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para generar M"){

				//$tmp2["firmas"] = $this->obtenFirmas($datos[$a], $session, $ValidacionPagoDB);
				$firmasScia = true;
				$tmp2["firmas"] = array();
				$tmp2["prevalidadores"] = $this->obtenValidadores($datos[$a], $session, $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para generar M Desistimiento"){

				//$tmp2["firmas"] = $this->obtenFirmas($datos[$a], $session, $ValidacionPagoDB);
				$firmasScia = true;
				$tmp2["firmas"] = array();
				$tmp2["prevalidadores"] = $this->obtenValidadores($datos[$a], $session, $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para generar cancelacion"){

				$tmp2["prevalidadores"] = $this->obtenValidadores($datos[$a], $session, $ValidacionPagoDB);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else if($datos[$a][$estatus] == "Para cerrar consolidado" || $datos[$a][$estatus] == "Consolidado cerrado"){

				$tmp2["estatusConsolidado"] = $this->obtenEstatusConsolidado($datos[$a], $_SESSION["sesionLinks"]);

				$datos[$a][count($tmp[$a])/2] = $tmp2;

			}else{
				$tmp2 = null;

				$datos[$a][count($tmp[$a])/2] = $tmp2;
			}
		}

		if($firmasScia == true){

			$conexionSCIA = null;

			if($_SESSION["sesionLinks"]->oficina == "CDMX" || $_SESSION["sesionLinks"]->oficina == "QRO" || $_SESSION["sesionLinks"]->oficina == "EDOMEX"){

				$conexionSCIA = new ConexionSCIAMEX();

			}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

				$conexionSCIA = new ConexionSCIALAR();

			}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

				$conexionSCIA = new ConexionSCIACUN();

			}else if($_SESSION["sesionLinks"]->oficina == "VER"){

				$conexionSCIA = new ConexionSCIAVER();

			}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

				$conexionSCIA = new ConexionSCIATOL();

			}else if($_SESSION["sesionLinks"]->oficina == "SLP"){

				$conexionSCIA = new ConexionSCIALAR();

			} 

			for($a=0; $a<count($tmp); $a++){

				if($datos[$a][$estatus] == "Para generar M" || $datos[$a][$estatus] == "Para generar M Desistimiento"){

					$tmp2["firmas"] = $this->obtenFirmas($datos[$a], $session, $ValidacionPagoDB, $conexionSCIA);

					$datos[$a][count($tmp[$a])/2]["firmas"] = $tmp2["firmas"];

				}
			}

			$conexionSCIA->Close();
		}
		
		$ValidacionPagoDB->Close();
		
		return $datos;
    }
}

?>
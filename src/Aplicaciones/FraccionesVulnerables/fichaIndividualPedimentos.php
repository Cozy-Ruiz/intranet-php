<?php
/*
 *@author Octavio García
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'fichaIndividualPedimentos.php';
//require_once("../../ConexionDBT.php");
require_once("../../ConexionMaster.php");
require_once("../../ConexionImagenes.php");
require_once("../../conexionLaredo.php");
date_default_timezone_set('America/Chicago');
//require_once("compruebaUsuario.php");

//require_once("conexionMasterDB.php");
//require_once("conexionMexicoDB.php");

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$cliente = $_GET['c'];
$year = $_GET['y'];
$month = $_GET['m'];

?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link type="text/css" rel="stylesheet" href="../../css/styleHomePage.css"/>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ficha Pedimento</title>
    
    <style>
		#fichaPanel{ 
			width:99%;
			height:7em;
			background-color:#007cbd;
			border-color: #007cbd;
			border-width: 1px;
			border-style: solid;
			border-radius: 1em;
			font-family:Lucida Sans;
			font-size:14px;
			color:#fff;
		}
		
		#fichaInformacion{
			width:80%;
			margin-left:auto;
			margin-right:auto;
		}
		
		#fichaAduana{
			text-align:center;
			background-color:#007cbd;
			border:solid #007cbd 1px;
			width:100%;
			color:#fff;
			height:2em;
			font-family:Lucida Sans;
			font-size:12px;
		}
		
		#divisionMitad{
			float: left;
			width: 50%;
		}
		
		#campoCabecera{
			background-color: #2F2F2F;
			border: 0.5px solid #DDDDDD;
			color: #007cbd;
			height: 2em;
			text-align: center;
			width: 100%;
			font-family:Lucida Sans;
			font-size:14px;
			font-weight:bold;
		}
		
		#campoContenido{
			background-color: #FFFFFF;
			border: 0.5px solid #DDDDDD;
			height: 2em;
			text-align: center;
			width: 100%;
		}
		
		#campoContenidoGrande{
			background-color: #2F2F2F;
			border: 0.5px solid #DDDDDD;
			height: 8em;
			text-align: center;
			width: 100%;
			overflow:auto;
			color: #fff;
			font-family:Lucida Sans;
			font-size:12px;
		}
		
		#campoPie{
			background-color: #007cbd;
			border: 0.5px solid #DDDDDD;
			color: #FFFFFF;
			height: 2em;
			text-align: center;
			width: 100%;
			font-family:Lucida Sans;
			font-size:12px;
			font-weight:bold;
		}
		
		#fichaPedimentoIncidencia{
			text-align:center;
			background-color:#2F2F2F;
			border:solid #DDD .5px;
			vertical-align:middle;
			color: #007cbd;
			font-family:Lucida Sans;
			font-size:14px;
			font-weight:bold;
		}
		
		#fichaPedimentoIncidenciaContent{
			font-size:10px;
			text-align:center;
			background-color:#2F2F2F;
			border:solid #DDD .5px;
			height:7em;
			vertical-align:middle;
			overflow:auto;
			color: #fff;
			font-family:Lucida Sans;
			font-size:12px;
		}
	</style>
    
</head>

<body>

<?php
$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home / </a><a href='../aplicaciones.php' id='breadcrumbs'>Aplicaciones / </a>
			<a href='tablero_Patentes.php?year=$showYear&month=$showMonth' id='breadcrumbs'>Tablero Patentes /</a> 
			<a href='tablero_Cliente.php?c=$cliente&y=$year&m=$month' id='breadcrumbs'>Tablero Patentes</a>";
			//<a href='nom_pdf.php' id='breadcrumbs'>Nom PDF </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";//Encabezado
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Pedimento</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='70'> </tr>";
	echo "</table>";


	$referencia = $_GET['referencia'];

	//seccion para busqueda de referencia
	if($_POST['buscaReferencia'] != ''){
		//echo "Entro a busqueda a traves de referencia <br>";
		$referencia = trim($_POST['buscaReferencia']);
		//echo "$referencia <br>";
	}else if($_POST['buscaPedimento'] != ''){
		//echo "Entro a busqueda a traves de Pedimento <br>";
		$buscaPedimento = trim($_POST['buscaPedimento']);
		//echo "$buscaPedimento <br>";
		$s = $MASTER_GE->Execute("select xt_referencia from MASTER_PEDIMENTOS where kp_pedimento = '$buscaPedimento' ");
		while($r = $s->FetchRow()){
			$referencia = trim($r[0]);
		}
	}
	
	//Llenar fichaIndividualPedimentos con la referencia pasada desde fichaCuentaGastos
	if($_GET['referenciaFichaCuentaGastos'] != ''){
		$referencia = $_GET['referenciaFichaCuentaGastos'];
	}
	
	
	$s = $MASTER_GE->Execute("select kp_pedimento, xn_tipoOperacion, xn_aduana, xd_fechaPago, xd_fechaEntrada, xn_valorComercial, xn_valorAduana, xt_tramiteAduanero, xn_tipoCambio, xn_importePagoFletes, xn_importePagoPrimasSeguros, xn_importePagoEmbalajes, xn_ImportePagoOtrosIncrementables, xn_pesoKgs, xt_proyecto from MASTER_PEDIMENTOS where xt_Referencia = '$referencia' ");
	
	while($r = $s->FetchRow()){
		$pedimentoPatente = $r[0];
		$proyecto = trim($r[14]);
		if($r[1] == 1){
			$tipoOperacion = "IMP";
		}else if($r[1] == 2){
			$tipoOperacion = "EXP";
		}
		
		if(substr($r[2],0,2) == 47){
			$aduana = 'Aeropuerto Internacional de la Ciudad de México';
		}else if(substr($r[2],0,2) == 80){
			$aduana = 'Aduana Colombia, Nuevo Leon';
		}else if(substr($r[2],0,2) == 16){
			$aduana = 'Aduana Pantaco';
		}else if(substr($r[2],0,2) == 24){
			$aduana = 'Aduana Nuevo Laredo';
		}else if(substr($r[2],0,2) == 7){
			$aduana = 'Aduana Ciudad Juárez';
		}
		
		$fechaPago = date("d/m/Y",strtotime(trim($r[3])));
		$fechaEntrada = date("d/m/Y",strtotime(trim($r[4])));
		$valorComercial = $r[5];
		$valorAduana = $r[6];
		$tramiteAduanero = $r[7];
		$tipoCambio = $r[8];
		$fletes = $r[9];
		$primaSeguro = $r[10];
		$embalajes = $r[11];
		$otrosIncrementables = $r[12];
		$pesoKgs = $r[13];
		
	} unset($r);
	
	//fechaCruce
	$s = $SCIAM-> Execute("select FCR_TRAFICOCRUCE from SCIA.T_TRAFICOCRUCE where NTR_TRAFICOCRUCE = '$referencia' ");
	while($r = $s->fetchRow()){$fechaCruce = date("d/m/Y",strtotime(trim($r[0])));}
	
	//VALOR TOTALMER CANCIAS sum(xn_valorFacturaUSD)
	$s = $MASTER_GE-> Execute("select sum(xn_valorFacturaUSD) from MASTER_PARTIDAS where xt_referencia = '$referencia' ");
	while($r = $s->fetchRow()){$valorTotalMercancias = $r[0];}
	
	//ADV
	$ADV = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$referencia' and xn_claveGravamen = 6 ");
	while($r = $s->fetchRow()){$ADV = $r[0];}
	
	//IVA
	$IVA = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$referencia' and xn_claveGravamen = 3 ");
	while($r = $s->fetchRow()){$IVA = $r[0];}
	
	//IEPS
	$IEPS = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$referencia' and xn_claveGravamen = 5 ");
	while($r = $s->fetchRow()){$IEPS = $r[0];}
	
	//CUOTA COMPENSATORIA
	$cuotaCompensatoria = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$referencia' and xn_claveGravamen = 2 ");
	while($r = $s->fetchRow()){$cuotaCompensatoria = $r[0];}
	
	//MEDIDA DE TRANSICION
	$medidaTransision = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$referencia' and xn_claveGravamen = 20 ");
	while($r = $s->fetchRow()){$medidaTransision = $r[0];}
	
	//OTROS
	$otrosContribuciones = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeGravamen) from MASTER_GRAVAMEN_PARTIDAS where xt_referencia = '$referencia' and xn_claveGravamen = 9 ");
	while($r = $s->fetchRow()){$otrosContribuciones += $r[0];}
	$s = $MASTER_GE-> Execute("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$referencia' and xn_claveContrubucion = 9 ");
	while($r = $s->fetchRow()){$otrosContribuciones += $r[0];}
	
	//DTA
	$DTA = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$referencia' and xn_claveContrubucion = 1 ");
	while($r = $s->fetchRow()){$DTA = $r[0];}
	
	//PREV
	$prevalidacion = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$referencia' and xn_claveContrubucion = 15 ");
	while($r = $s->fetchRow()){$prevalidacion = $r[0];}
	
	//RECARGOS
	$recargos = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$referencia' and xn_claveContrubucion = 7 ");
	while($r = $s->fetchRow()){$recargos += $r[0];}
	
	//MULTAS
	$multas = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$referencia' and xn_claveContrubucion = 11 ");
	while($r = $s->fetchRow()){$multas += $r[0];}
	
	//ECI
	$ECI = 0;
	$s = $MASTER_GE-> Execute("select sum(xn_importeContribucion) from MASTER_CONTRIBUCIONES_PEDIMENTO where xt_referencia = '$referencia' and xn_claveContrubucion = 18 ");
	while($r = $s->fetchRow()){$ECI += $r[0];}
	
	$s = $MASTER_GE->Execute("select xn_relacionDiaria,xt_cuentaDeGastos from MASTER_RELACIONES_DIARIAS where xt_referencia = '$referencia' ");
	$index = 0;
	while($r = $s->FetchRow()){
		$relacionDiariaId[$index] = $r[0];
		$cuentaGastosId[$index] = $r[1];
		$index++;
	}
	
	$s = $MASTER_GE->Execute("select kp_factura from MASTER_FACTURAS where xt_referencia = '$referencia' ");
	$numFacturas = 0;				
	while($r = $s->FetchRow()){
		$facturas[$numFacturas] = $r[0];
		$numFacturas++;	
	}
	
	$s = $MASTER_GE->Execute("select xt_tipoImagen, xt_ruta from MASTER_IMAGENES_PEDIMENTOS where xt_referencia = '$referencia' ");
	$index = 0;
	while($r = $s->FetchRow()){
		$tipoImagen[$index] = $r[0];
		$rutaImagen[$index] = $r[1];
		$index++;
	}
	
	$s = $MASTER_GE->Execute("SELECT xt_tipoDocumento, xt_ruta FROM IMAGENES.IMAGENES_VUCEM where xt_referencia = '$referencia' ");
	$index = 0;
	while($r = $s->FetchRow()){
		$vucemDocumento[$index] = $r[0];
		$vucemRuta[$index] = $r[1];
		$index++;
	}
	
	$s = $MASTER_GE->Execute("SELECT xt_tipoDocumento, xt_ruta FROM IMAGENES.IMAGENES_PEDIMENTOS where xt_referencia = '$referencia' ");
	$index = 0;
	while($r = $s->FetchRow()){
		$pedimentoDocumento[$index] = $r[0];
		$pedimentoRuta[$index] = $r[1];
		$index++;
	}
	
		echo "<div id='fichaPanel'>";
			echo "<table width='500' border='0' bordercolor='#BBB' align='center'>";
				echo "<tr>";
					echo "<td align='center' height='15' width='166'></td>";
					echo "<td align='center' height='15' width='166'></td>";
					echo "<td align='center' height='15' width='166'></td>";
					echo "<td align='center' height='15' width='166'></td>";
					echo "<td align='center' height='15' width='166'></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td align='center'><b>Pedimento</b></td>";
					echo "<td align='center'><b>Referencia</b></td>";
					echo "<td align='center'><b>Code</b></td>";
					echo "<td align='center'><b>Type</b></td>";
					echo "<td align='center'><b>Exchange R.</b></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td align='center'><b>$pedimentoPatente</b></td>";
					echo "<td align='center'><b>$referencia</b></td>";
					echo "<td align='center'><b>$tramiteAduanero</b></td>";
					echo "<td align='center'><b>$tipoOperacion</b></td>";
					echo "<td align='center'><b>$tipoCambio</b></td>";
				echo "</tr>";
			echo "</table>";               
		echo "</div>";
		
		echo "<div id='fichaInformacion'>";
			echo "<div id='fichaAduana'>";
				echo "<b><i>$aduana</b></i>";
			echo "</div>";
			
			
			echo "<div id='divisionMitad'>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td>Dates</td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						echo "<tr>";
							echo "<td align='left'>Entry Date:</td>";
							echo "<td align='right'>$fechaEntrada</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Payment Date:</td>";
							echo "<td align='right'>$fechaPago</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Custom Chkp:</td>";
							echo "<td align='right'>$fechaCruce</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td>Aditional Concepts (MXP)</td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						echo "<tr>";
							echo "<td align='left'>Val Seguros:</td>";
							echo "<td align='right'>0.00</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Seguros:</td>";
							echo "<td align='right'>".number_format($primaSeguro,2)."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Fletes:</td>";
							echo "<td align='right'>".number_format($fletes,2)."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Embalajes:</td>";
							echo "<td align='right'>".number_format($embalajes,2)."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Otros:</td>";
							echo "<td align='right'>".number_format($otrosIncrementables,2)."</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				echo "<div id='campoPie'>";
					$totalIncrementables = $primaSeguro + $fletes + $embalajes + $otrosIncrementables;
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						echo "<tr>";
							echo "<td align='left'>Total:</td>";
							echo "<td align='right'>".number_format($totalIncrementables,2)."</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td>Client Invoices</td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						for($a=0; $a<count($facturas); $a++){
							echo "<tr>";
								echo "<td align='left'>$facturas[$a]</td>";
								/*<a href='fichaIndividualFacturas.php?factura=$facturas[$a]'><img src='../../Imagenes/ICN_Boton_Azul.png' height='10' width='10'/></a>*/
								echo "<td align='right'></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td width=160>Vucem</td><td width=20><a href='http://71.144.19.155/radar/ExtractorImagenes/extraccionImagenesVucemZipDesarrollo.php?referencia=$referencia'><img src='../../Imagenes/ICN_Archivo.png' width='12' height='15'></a></td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						for($a = 0; $a<count($vucemDocumento); $a++){
							echo "<tr>";
								echo "<td align='left'>$vucemDocumento[$a]</td>";
								echo "<td align='right'><a href='extraccionImagenVucem.php?ruta=$vucemRuta[$a]'><img src='../../Imagenes/ICN_Boton_Azul.png' height='10' width='10'/></a></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td>Third Party Docs</td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						
					echo "</table>";
				echo "</div>";
				
			echo "</div>"; 
			
			echo "<div id='divisionMitad'>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td>Values</td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						echo "<tr>";
							echo "<td align='left'>Invoice:</td>";
							echo "<td align='right'>".number_format($valorTotalMercancias,2)." <font size='1'>USD</font></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Customs:</td>";
							echo "<td align='right'>".number_format($valorAduana,2)." <font size='1'>MXP</font></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align='left'>Commercial:</td>";
							echo "<td align='right'>".number_format($valorComercial,2)." <font size='1'>MXP</font></td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td>Taxes & Duties (MXP)</td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						if($IVA != 0){
						echo "<tr>";
							echo "<td align='left'><i>FP:0</i></td>";
							echo "<td align='center'>IVA:</td>";
							echo "<td align='right'>".number_format($IVA,2)."</td>";
						echo "</tr>";
						}
						if($DTA != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>DTA:</td>";
								echo "<td align='right'>".number_format($DTA,2)."</td>";
							echo "</tr>";
						}
						if($ADV != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>ADV:</td>";
								echo "<td align='right'>".number_format($ADV,2)."</td>";
							echo "</tr>";
						}
						if($prevalidacion != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>Prev:</td>";
								echo "<td align='right'>".number_format($prevalidacion,2)."</td>";
							echo "</tr>";
						}
						if($otrosContribuciones != 0){ 
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>Other:</td>";
								echo "<td align='right'>".number_format($otrosContribuciones,2)."</td>";
							echo "</tr>";
						}
						if($recargos != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>Recargos:</td>";
								echo "<td align='right'>".number_format($recargos,2)."</td>";
							echo "</tr>";
						}
						if($multas != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>Multas:</td>";
								echo "<td align='right'>".number_format($multas,2)."</td>";
							echo "</tr>";
						}
						if($ECI != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>ECI:</td>";
								echo "<td align='right'>".number_format($ECI,2)."</td>";
							echo "</tr>";
						}
						if($IEPS != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>IEPS:</td>";
								echo "<td align='right'>".number_format($IEPS,2)."</td>";
							echo "</tr>";
						}
						if($cuotaCompensatoria != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>C.C:</td>";
								echo "<td align='right'>".number_format($cuotaCompensatoria,2)."</td>";
							echo "</tr>";
						}
						if($medidaTransision != 0){
							echo "<tr>";
								echo "<td align='left'><i>FP:0</i></td>";
								echo "<td align='center'>M.T:</td>";
								echo "<td align='right'>".number_format($medidaTransision,2)."</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				echo "<div id='campoPie'>";
					$totalContribuciones = $IVA + $DTA + $ADV + $prevalidacion + $otrosContribuciones + $recargos + $multas + $ECI + $IEPS + $cuotaCompensatoria + $medidaTransision;
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						echo "<tr>";
							echo "<td align='left'>Total:</td>";
							echo "<td align='right'>".number_format($totalContribuciones,2)."</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td width=160>Entry summary files</td><td width=20><a href='http://71.144.19.155/radar/ExtractorImagenes/extraccionImagenesPedimentoZipDesarrollo.php?referencia=$referencia'><img src='../../Imagenes/ICN_Archivo.png' width='12' height='15'></a></td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						for($a = 0; $a<count($pedimentoDocumento); $a++){
							echo "<tr>";
								echo "<td align='left'>$pedimentoDocumento[$a]</td>";
								echo "<td align='right'><a href='extraccionImagenPedimento.php?ruta=$pedimentoRuta[$a]'><img src='../../Imagenes/ICN_Boton_Azul.png' height='10' width='10'/></a></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td width=160>GE bills</td><td width=20><a href='http://71.144.19.155/radar/ExtractorImagenes/extraccionImagenesFacturacionZipDesarrollo.php?referencia=$referencia'><img src='../../Imagenes/ICN_Archivo.png' width='12' height='15'></a></td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					for($b = 0; $b < count($cuentaGastosId); $b++){
						echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
							echo "<tr>";
								echo "<td align='left'>$cuentaGastosId[$b]</td>";
								//<a href='fichaIndividualCuentaGastos.php?cuentaGastosId=$cuentaGastosId[$b]&caja=$caja'><img src='../../Imagenes/ICN_Boton_Azul.png' height='10' width='10'/></a>
								echo "<td align='right'></td>";
							echo "</tr>";
						echo "</table>";
					}
				echo "</div>";
				
				echo "<div id='campoCabecera'><table align='center'><tr><td width=160>Scanned File</td><td width=20><a href='http://71.144.19.155/radar/ExtractorImagenes/extraccionImagenesMaxImageZipDesarrollo.php?referencia=$referencia'><img src='../../Imagenes/ICN_Archivo.png' width='12' height='15'></a></td></tr></table></div>";
				echo "<div id='campoContenidoGrande'>";
					echo "<table style='margin-left:auto; margin-right:auto;' width='200'>";
						for($a = 0; $a<count($tipoImagen); $a++){
							echo "<tr>";
								echo "<td align='left'>$tipoImagen[$a]</td>";
								echo "<td align='right'><a href='extraccionImagenMaxImage.php?ruta=$rutaImagen[$a]&referencia=$referencia&tipoDocumento=$tipoImagen[$a]'><img src='../../Imagenes/ICN_Boton_Azul.png' height='10' width='10'/></a></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</div>";
				
			echo "</div>";
			
			//Comentarios de Pedimento
			echo "<div id='fichaPedimentoIncidencia'><b>Comments</b></div>";
			echo "<div id='fichaPedimentoIncidenciaContent'>";	
				echo "<table width='425'>";
					echo "<tr>";
						echo "<td align='center' width='40'>$comentario</td>";
					echo "</tr>";
				echo "</table>";	
			echo "</div>";
			
		echo "</div>";
		
	echo "</div><br><br><br><br><br>";
								
							
 	echo '</div>'; //termina wrapper
?>
</body>
</html>

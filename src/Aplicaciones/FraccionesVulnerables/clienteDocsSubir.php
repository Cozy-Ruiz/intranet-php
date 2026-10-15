<?php
$nombrephp = 'clienteDocs.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
 	$rfc = $_POST['rfcCliente'];
	$nombreArchivo = $_POST['nombresArchivos'];

	if($nombreArchivo=="Acta"){$tipo="Acta Constitutiva";}
	elseif($nombreArchivo=="Cedula"){$tipo="Cédula Fiscal actualizada";}
	elseif($nombreArchivo=="Comprobante"){$tipo="Comprobante de domicilio (no mayor a tres meses)";} 
	elseif($nombreArchivo=="Poder"){$tipo="Poder del representante legal";}
	elseif($nombreArchivo=="Identificacion"){$tipo="Identificación oficial del representante legal";}
	elseif($nombreArchivo=="Constancia"){$tipo="Constancia información del Dueño Beneficiario";}
	elseif($nombreArchivo=="Respuesta"){$tipo="Respuesta a Constancia";}
 
	$archivo = $_FILES['archivo']['name']; 
 
	//$INTRANET->Execute("INSERT INTO IMAGENES.IMAGENES_FRACCIONES_VULNERABLES (xt_clienteRFC,xt_nombreArchivo,xd_fechaRecepcion)VALUES ('$rfc','$nombreArchivo',NOW())");
	mkdir("../../FILES/FraccionesVulnerables/$rfc/");
	$destino = "../../FILES/FraccionesVulnerables/$rfc/$archivo";
	echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";

	if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
		$agregar = "INSERT INTO master_ge.documentos_fracciones_vulnerables(xt_clienteRFC, xt_nombreArchivo, xt_tipoDocumento, xt_ruta) VALUES ('$rfc', '$tipo', '$nombreArchivo', '/INTRANET_GEA/FILES/FraccionesVulnerables/$rfc/$archivo')";
		echo $agregar;
		$INTRANET->Execute($agregar);	
		header("Location: clienteDocs.php?rfcCliente=$rfc");
	}else{
		
		echo" Hubo un error en la carga! ";
			
	}


?>

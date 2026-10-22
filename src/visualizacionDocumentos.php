<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam 
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp='Home.php';
require_once("ConexionDBT.php");
require_once("compruebaUsuario.php");

if (($_POST["movimiento"] ?? "")== "registraVisualizacion"){

    $INTRANETV2->Execute("INSERT INTO sgi_control_de_cambios_documentos_copy1 (xt_codigoDocumento, xt_usuario, xn_version) values ('".$_REQUEST["documentoId"]."', '".$_SESSION["sesionUsuario"]."', '".$_REQUEST["version"]."') ");

}else{

?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizacion documentos</title>
    <script>
        function cerrarVentana(documentoId, version) {

            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                
                if (xhttp.readyState == 4 && xhttp.status == 200) {

                    if(xhttp.responseText == ""){
                        //ocultaProcesando();
                         // Recargar la ventana padre
                        if (window.opener) {
                            window.opener.location.reload();
                        }
                        // Cerrar la ventana actual
                        window.close();
                    }else{
                        //ocultaProcesando();
                        alert(xhttp.responseText);
                        //actualizaReferencia(referencia);
                    }
                }
            };
            
            xhttp.open("POST", "visualizacionDocumentos.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("movimiento=registraVisualizacion&documentoId=" + documentoId + "&version=" + version);
        }
    </script>
</head>
<body>

	<iframe src="SistemaGestionIntegral/Intranetv2/fichaDocumentov4.php?id=<?php echo $_GET["documentoId"] ?>" width="100%" height="95%"></iframe>

	<div align="center" style="height:5%; align-content:center;">
		<button onclick="cerrarVentana('<?php echo $_GET['documentoId'] ?>', '<?php echo $_GET['version'] ?>')">Marcar como Leido</button>
	</div>
</body>
</html>

<?php
}
?>
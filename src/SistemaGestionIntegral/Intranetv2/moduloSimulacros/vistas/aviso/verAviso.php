
<!DOCTYPE html>
	<html>
	    <head>
	    </head>
    <table border="0" align="center">
    <tr><td id="titulo1" align="center" colspan="2"><?php echo $nombreAviso ?></td></tr>
    <tr><td id='titleBlueLineBottom' colspan="2"></td></tr>
	    <body onLoad="window.resizeTo(400, 800)">
	    <tr><td><embed src="http://192.1.169.25/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/moduloSimulacros/vistas/aviso/archivosAviso/<?php echo $_REQUEST['nombreAviso'] ?>" type="application/pdf" width="700" height="800"></embed></td></tr>
	</table>
	</body>
</html>
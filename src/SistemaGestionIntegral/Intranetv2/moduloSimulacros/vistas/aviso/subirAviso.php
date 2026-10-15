

<!DOCTYPE html>
	<html>
	    <head>
	    </head>
    <table border="0" align="center">
    <tr><td id="titulo1" align="center" colspan="2">Subir avisos</td></tr>
    <tr><td id='titleBlueLineBottom' colspan="2"></td></tr>
	    <body onLoad="window.resizeTo(400, 500)">
	    <form action="../aviso/uploadAviso.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	    	<tr><td id="titulo2">Avisar Población:</td></tr><tr><td><input type="file" name="userfile[]" /></td></tr>
	    	<tr style="height: 20px"><td colspan="2"></td></tr>
	        <tr><td id="titulo2">Avisar Protección civil:</td></tr><tr><td><input type="file" name="userfile[]" /></td></tr>
	        <tr style="height: 20px"><td colspan="2"></td></tr>
	        <tr><td id="titulo2">Avisar Grupo Escalante:</td></tr><tr><td><input type="file" name="userfile[]" /></td></tr>
	        <tr style="height: 20px"><td colspan="2"></td></tr>
	        <tr><td id="titulo2">Avisar Autoridades:</td></tr><tr><td><input type="file" name="userfile[]" /></td></tr>
            <input style="position: absolute;" type="text" name="simulacro" value="<?php echo $simu ?>" hidden />
	        <tr style="height: 15px"><td id='titleBlueLineBottom' colspan="2"></td></tr>
        	<tr style="height: 40px">
    		<td colspan="2" align="center"><input type="image" src='../../../../../Imagenes/ICN_BotonEnviar.png' width='80' height='30' /></td></tr>
    	</form>
	</table>
	</body>
</html>
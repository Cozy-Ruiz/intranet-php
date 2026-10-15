
<!DOCTYPE html>
	<html>
	    <head>
	    </head>
    <table align="center">
    <tr><td id="titulo1" align="center">Subir desarrollo</td></tr>
    <tr><td id='titleBlueLineBottom'></td></tr>
	    <body onLoad="window.resizeTo(600,300)">
	        <form action="../desarrollo/uploadDesarrollo.php" method="post" enctype="multipart/form-data">
	            <tr><td><input type="file" name="archivo" id="archivo"></input></td></tr>
				<tr style="height: 15px"><td id='titleBlueLineBottom'></td></tr>
			    <tr style="height: 40px">
            	<input style="position: absolute;" type="text" name="simulacro" value="<?php echo $simu ?>" hidden />
            	<tr style="height: 40px">
        		<td><input type="image" src='../../../../../Imagenes/ICN_BotonEnviar.png' width='80' height='30' /></td></tr>
	        </form>
	 </table>
	    </body>
	</html>
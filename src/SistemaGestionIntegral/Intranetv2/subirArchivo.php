<?php
// if($estiloUsuario == 1){
        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
    // }else if($estiloUsuario == 2){
        //echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
    // }
	$ruta = $_POST['ruta'];
	$rutaE = $_POST['rutaEtapa'];
	$id = $_POST['correctivaID'];  
?>

<!DOCTYPE html>
	<html>
	    <head>
	    </head>
    <table align="center">
    <tr><td id="titulo1" align="center"><h2>Actualizacion</h2></td></tr>
    <tr><td id='titleBlueLineBottom'></td></tr>
	    <body onLoad="window.resizeTo(600,300)">
	        <form action="uploadArchActualizado.php" method="post" enctype="multipart/form-data">
	            <tr><td><input type="file" name="archivo" ></input></td></tr>
				<tr style="height: 15px"><td id='titleBlueLineBottom'></td></tr>
			    <tr style="height: 40px">
            	<input style="position: absolute;" type="text" name="correctivaID" value="<?php echo $id?>" hidden />
				<input style="position: absolute;" type="text" name="rutaEtapa" value="<?php echo $rutaE?>" hidden />
            	<tr style="height: 40px">
        		<td>
					<button type="submit" name="save" style="cursor: pointer; background-color: transparent; border: 0">
						<img src="../../Imagenes/ICN_BotonEnviar.png" width="80" height="30"/>
					</button>
				</td></tr>
	        </form>
	 </table>
	    </body>
	</html>
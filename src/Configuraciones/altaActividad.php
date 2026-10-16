<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

require_once("../conexionMasterDB.php");
require_once('../compruebaUsuario.php');

if(! in_array("altaActividad", $listaFuncionalidades)){
	header("Location: https://escalante.com.mx/INTRA/error.php"); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	if($sesionEstilo == 1){
		echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
	}else if($sesionEstilo == 2){
		echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
	}
?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Nuevo Modulo</title>

</head>
<body>
<?php
if($_POST['nombreActividad'] == ''){	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoActividad' method='post' action='altaActividad.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font> Nuevo Proceso</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Nombre Actividad<br>
						  <input type='text' size=50 maxlength=100 name='nombreActividad'>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Descripción Actividad <br>
							<input type='text' size=50 name='descripcionActividad'>";
					echo "</td>";
				echo "</tr>";
				
					echo"<tr height='10'></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Nombre Proceso<br>";
						  echo "<select name='proceso'>";
						  echo "<option value='' selected='selected'></option>";
							$s = $MASTER_GE->Execute("select xt_proceso from PERFILES.CATALOGO_PROCESOS");
							while($r = $s->fetchRow()){
								echo "<option value='".$r[0]."'>$r[0]</option>";
							}
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
				
				echo"<tr height='10'></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Nombre Modulo<br>";
						  echo "<select name='modulo'>";
						  echo "<option value='' selected='selected'></option>";
							$s = $MASTER_GE->Execute("select xt_modulo from PERFILES.CATALOGO_MODULOS");
							while($r = $s->fetchRow()){
								echo "<option value='".$r[0]."'>$r[0]</option>";
							}
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='15'></tr>";
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";
}else if($_POST['nombreActividad'] != ''){
			
	$nombreActividad = $_POST['nombreActividad'];
	$descripcionActividad = $_POST['descripcionActividad'];
	$proceso = $_POST['proceso'];
	$modulo = $_POST['modulo'];
	
	$s = $MASTER_GE->Execute("select max(xn_indice) from PERFILES.CATALOGO_ACTIVIDADES");
	while($r = $s->fetchRow()){
		$indiceActividad = $r[0];
	}
	
	if($indiceActividad == null){
		$indiceActividad = 0;
	}
	
	$indiceActividad++;
	
	
	if($MASTER_GE->Execute("insert into PERFILES.CATALOGO_ACTIVIDADES (xn_indice, xt_modulo, xt_proceso, xt_actividad, xt_descripcion) values ($indiceActividad, '$modulo', '$proceso','$nombreActividad','$descripcionActividad') ")){
		
			?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <?php
			if($sesionEstilo == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($sesionEstilo == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <title>Alta Actividad</title>
            </head>
            <body>
    <?php
	
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Alta Actividad";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr><td> </td></tr>";
				
				echo"<tr height='70px'><td> </td></tr>";
			echo "</table>";
				
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='4'> </td>";
				echo "</tr>";
				
				echo"<tr height='15px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td width='70px' align='left'>Actividad:</td>";
					echo "<td width='270px' align='left' id='iconosTexto'>".$nombreActividad."</td>";
					echo "<td width='30px'> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td width='70px' align='left'>Descripcion:</td>";
					echo "<td width='300px' align='left' id='iconosTexto'>".$descripcionActividad."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td width='70px' align='left'>Proceso:</td>";
					echo "<td width='300px' align='left' id='iconosTexto'>".$proceso."</td>";
					echo "<td> </td>";
				echo"</tr>";

				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td width='70px' align='left'>Modulo:</td>";
					echo "<td width='300px' align='left' id='iconosTexto'>".$modulo."</td>";
					echo "<td> </td>";
				echo"</tr>";

				echo"<tr height='15'></tr>";
				
				echo "<tr>";
					echo "<td  align='center' colspan='4' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td width='300px' align='center' id='iconosTexto'>Cargado exitosamente!!!</td>";
				echo"</tr>";
				
				echo"<tr height='100px'><td colspan='4'> </td></tr>";
				
				echo "<tr>";
				echo "<td></td>";
				echo "<td align='center'><input name='button' type='button' onclick='window.close();' value='Cerrar' /></td>";
				echo "<td></td>";
				echo"</tr>";
				
			echo "</table>";
		echo "</div>";
		
		?>
                </body>
            </html>
        <?php
	
   }else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <?php
			if($sesionEstilo == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($sesionEstilo == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <title>Alta Actividad</title>
                </head>
                <body>
        <?php
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Alta Actividad";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr><td> </td></tr>";
				
				echo"<tr height='70px'><td> </td></tr>";
			echo "</table>";
				
			echo "<table border='0' align='center' width='400px'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'> </td>";
				echo "</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td width='400px' id='iconosTexto' align='center'><b>Error en la carga!!!</b></td>";
				echo"</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
			echo "</table>";
		echo "</div>";
		
		?>
                </body>
            </html>
        <?php
		
	}
}
<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<title></title>

</head>
<body>
<?php




	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevaActividad' method='post' action='backlogEntregablesPopUp.php'>";

			
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Entregables</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			
				echo"<tr height='25px'> </tr>";
			echo "</table>";
			
			
			echo "<table border='0' align='center'>";
				
				
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='10'></tr>";
	
				echo "<tr>";
				echo "<td>Titulo</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><input type='text' name='titulo'></td>";
				echo "</tr>";
				
				echo "<tr height='10px'></tr>";
				
				echo "<tr>";
				echo "<td>Descripción</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><textarea id='descripcion' rows='2' cols='40' name='descripcion'></textarea></td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
		
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";
	
	
	//obtengo datos del formulario
	
	if(isset($_POST['titulo']) && isset($_POST['descripcion'])){
		
		$tituloEntregable = $_POST['titulo'];
		$descripcionE = $_POST['descripcion'];
		
		//obtengo el ultimo codigo de entregable insertado para definir el sig codigo
		$maximo = 0;
		$maximo = $INTRANET->getOne("SELECT MAX(xn_consecutivo) FROM BACKLOG.ENTREGABLES");
		if($maximo == ''){
			
			echo $maximo = 1;
		}else{
		echo $maximo++;
		}
		
	if($maximo<10){echo $clave = "0000".$maximo; }else if($maximo <100){$clave = "000".$maximo;}else if($maximo < 1000){$clave = "00".$maximo;}
	else if($maximo<10000){$clave = "0".$maximo;}else if($maximo<100000){$clave = $maximo;}
		
		//inserto en la tabla de entregables los datos correspondientes
		
		
		
		
		
	}//fin del if de verificacion de datos del formulario
	
	
	
?>



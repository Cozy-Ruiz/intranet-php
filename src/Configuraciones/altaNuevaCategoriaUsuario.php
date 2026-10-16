<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

require_once("../conexionMasterDB.php");
require_once('../compruebaUsuario.php');

if(! in_array("altaNuevaCategoriaUsuario", $listaFuncionalidades)){
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
<title>Nueva Categoria Usuario</title>

</head>
<body>
<?php
if($_POST['nombreCategoria'] == ''){	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevaCategoria' method='post' action='altaNuevaCategoriaUsuario.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font> Nueva Categoria Usuario</font>";
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
					echo "Nombre Categoria<br><br> 
						  <input type='text' size=50 maxlength=100 name='nombreCategoria'>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Descripción Categoria <br><br>
							<input type='text' size=50 name='descripcionCategoria'>";
					echo "</td>";
				echo "</tr>";
			
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
}else if($_POST['nombreCategoria'] != ''){
		
	$nombreCategoria = $_POST['nombreCategoria'];
	$descripcionCategoria = $_POST['descripcionCategoria'];
	
	if($MASTER_GE->Execute("insert into PERFILES.CATEGORIAS_USUARIOS (kp_categoria, xt_descripcion) values ('$nombreCategoria', '$descripcionCategoria') ")){
		echo "Carga Exitosa!! <br>";
	}else{
		echo "Error en la carga";
	}
	
}
				

?>

</body>
</html>

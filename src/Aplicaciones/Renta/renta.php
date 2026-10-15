<?php
/*
 *@author Abaham Donoso Samantha
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'renta.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Renta</title>
<?php
	//$estiloUsuario = $_GET['est'];
	if($estiloUsuario == 1){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>
<script type="text/javascript">
	function SubmitForm(form){
		if (form.domain.value == "xxx")
			form.action = "xxx"
		else
			form.action = "zzz";
		
		form.submit(); // Submit the page
		return true;
	}
</script>
</head>
<body>
<?php
$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a><a href='../aplicaciones.php' id='breadcrumbs'>Módulos /</a><a href='../operaciones.php' id='breadcrumbs'>Operaciones</a>";

echo"<div id='wrapper' align='center'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Renta</font>";
			echo"</td>";
		echo"</tr>";
			echo"<tr height='10'> </tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='100'> </tr>";
	echo "</table>"; 

	echo "<FORM name='formRenta' ACTION='generaxml.php'  METHOD='GET'>"; 
	echo "<table border='0' align='center' name='Cuerpo'>";
		echo "<tr id='iconosTexto' >";
			echo "<td align='left' width='150' >";
				echo "Sujeto";
			echo "</td>";
			echo "<td colspan='2' align='center' width='150' >";
				echo "<select name='sujeto' size='1'>";
					echo "<option value='0'>Elegir</option>";
					echo "<option value='1'>Julio Antonio Escalante Bourillon</option>";
					echo "<option value='2'>Gabriel Roberto Escalante Bourillon</option>";
			   echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr id='iconosTexto' >";
			echo "<td align='left' width='150' >";
				echo "Fecha  <font style='font-size: 10px;'>(yyyymm)</font>";
			echo "</td>";
			echo "<td colspan='2' align='center' width='150' >";
				echo "<input type='text' name='fecha' id='fecha' size='36' height='20'> ";
			echo "</td>";
		echo "</tr>";
		echo "<tr id='iconosTexto' >";
			echo "<td align='left' width='150' >";
				echo "Monto";
			echo "</td>";
			echo "<td colspan='2' align='center' width='150' >";
				echo "<input type='text' name='monto' id='monto' size='36' height='20'> ";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='40'> <td></td> </tr>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td align='left'>";
				echo "<a href='modificaRenta.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=850,scrollbars=yes')\"> 
				<img src='../../Imagenes/ICN_BotonModificar.png' height='29' width='90'> </a>";	
			echo "</td>";
			echo "<td align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonGenerar.png' height='29' width='90'>";
			echo "</td>";
		echo "</tr>";
	
	echo "</table>";
	echo"</form>";
echo"</div>";

?>

</body>
</html>
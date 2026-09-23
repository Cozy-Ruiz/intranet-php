<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco 
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='index.php';
$usuario = $_POST['usuario'];
$password = $_POST['password'];

if(($usuario == ("" || NULL)) || $password == (("" || NULL))){
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login Intranet</title>
<link type="text/css" rel="stylesheet" href="css/styleHomePage.css"/>
<link rel="shortcut icon" type="image/x-icon" href="Imagenes/ICN_PestanaWebGE.png">
<style>
input[type=text] {height: 20px;}

input[type=password] {height: 20px;}
</style>
</head>
<body>
<?php
echo"<div id='wrapper' align='center'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr >";
			echo "<td align='center' id='titulo1'>";
				echo "<font>GRUPO ESCALANTE</font>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='30'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Intranet</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='80'> </tr>";
	echo "</table>"; 

	echo "<form action='iniciaSesion.php' method='POST'>";
		echo "<table border='0' align='center' name='Cuerpo' bgcolor='#ffffff'>";
			echo "<tr height='100px'>";
				echo "<td align='center' width='300px' id='loginEstilo'>";
					echo "LOGIN";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='center'>";
					echo "<input type='text' name='usuario' placeholder='usuario'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20px'> </tr>";
			
			echo "<tr>";
				echo "<td align='center'>";
					echo "<input type='password' name='contraseña' placeholder='contraseña'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='80px'>";
				echo "<td align='center'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='Imagenes/ICN_BotonEntrar.png' width='90' height='29'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='100px'><td><br><br></td></tr>";
		echo "<tr height='20px'> </tr>";
	echo "</table>"; 
	
echo"</div>";
} else{
	
}
?>
</body>
</html>
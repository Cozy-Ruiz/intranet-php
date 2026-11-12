<?php error_reporting(0); ?>
<?php
$nombrephp = 'altaNuevoPHP.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
error_reporting(E_PARSE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Nuevo PHP</title>

</head>
<body>
<?php
if($_POST['nombrephp'] == '' && $_POST['categoria'] == ''){	
echo "<div id='wrapperPopUp'>";
	echo "<form name='nuevaCategoria' method='post' action='altaNuevoPHP.php'>";

		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
				echo "<font> Nuevo PHP</font>";
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
				echo "Nombre PHP<br><br> 
					  <input type='text' size=50 maxlength=100 name='nombrephp'>";
				echo "</td>";
			echo"</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='iconosTexto2'>";
				echo "<td align='center'>";
					echo "Descripción <br><br>
					    <input type='text' size=50 name='descripcion'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='10'></tr>";
			
			echo "<tr id='iconosTexto2'>";
				echo "<td align='center'>";
					echo "Categoria <br><br>";
					    echo"<select name='categoria' size='1'>";
							echo"<option value='0'>Elegir </option>";
						$s = $INTRANET->Execute("SELECT kp_categoria FROM IntranetGEA_CATEGORIAS_PHP ");
							while($r= $s->fetchRow()){
							echo"<option value='$r[0]'>$r[0] </option>";
							}
						echo"</select>";
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
}else if($_POST['nombrephp'] != '' && $_POST['categoria'] != ''){
			
			$nombrePhp = $_POST['nombrephp'];
			$descripcion = $_POST['descripcion'];
			$categoria = $_POST['categoria'];
			
			if($INTRANET->Execute("insert into IntranetGEA_CATALOGO_PHP (kp_nombre, kf_categoria) values ('$nombrePhp', '$categoria') ")){
				
				$INTRANET->Execute("INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$nombrePhp','Octavio_Garcia') ");
				$INTRANET->Execute("INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$nombrePhp','Rodrigo_Romo') ");
				$INTRANET->Execute("INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$nombrePhp','Samantha_Abam') ");
				$INTRANET->Execute("INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$nombrePhp','sdelap') ");
				
				if($descripcion != ""){
				
				$INTRANET->Execute("UPDATE IntranetGEA_CATALOGO_PHP SET xt_descripcion= '$descripcion' WHERE kp_nombre = '$nombrePhp' ");
				
			}
				echo "Carga Exitosa!! <br>";
			}else{
				echo "Error en la carga";
			}
			
		}


?>

</body>
</html>

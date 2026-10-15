<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");

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
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Asigna resguardo usuario</title>
<script>
	function revisaArticulo(){
		selectArticulo = document.getElementsByName('selectArticulo')[0].value;
		if(selectArticulo == 'CAMPO EN BLANCO'){
			document.getElementById('nuevoArticulo').style.display = "grid";
		}else{
			document.getElementById('nuevoArticulo').style.display = "none";
		}
	}
</script>

</head>
<body>
<?php

//defino el consecutivo para tabla SGI_Roles
$indexConsecutivo = 0;
$catalogoArticulos = $INTRANETV2->Execute("SELECT * FROM sgi_catalogo_articulos_resguardo");

if($_POST['selectArticulo'] != ''){


	if($_POST['selectArticulo'] == 'CAMPO EN BLANCO'){
		$articulo = $_POST['inputNuevoArticulo'];
		$INTRANETV2->Execute("INSERT INTO sgi_catalogo_articulos_resguardo (xt_articulo) VALUES ('".$articulo."') ");
	}else{
		$articulo = $_POST['selectArticulo'];
	}

	//echo "INSERT INTO sgi_resguardo_articulos (xt_usuario, xt_articulo, xt_descripcion) VALUES ('".$_REQUEST['usuario']."', '".$articulo."', '".$_POST['inputDescripcion']."') ";
	$INTRANETV2->Execute("INSERT INTO sgi_resguardo_articulos (xt_usuario, xt_articulo, xt_descripcion) VALUES ('".$_REQUEST['usuario']."', '".$articulo."', '".$_POST['inputDescripcion']."') ");
	
  	?>
	<script type="text/javascript">
		window.opener.top.location.reload(true);
		window.close();
	</script>
	<?php
	
}else if($_REQUEST['usuario'] != ''){	

	echo "<div id='wrapperPopUp'>";
		/*
		echo "<form name='nuevoRol' method='post' action='asignaResguardoUsuario.php?usuario=".$_REQUEST['usuario']."'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Asigna resguardo usaurio</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Articulo<br>";
						echo "<select name='selectArticulo' onchange='revisaArticulo();'>";

						foreach($catalogoArticulos as $registro){
							echo "<option value='".$registro['xt_articulo']."'>".$registro['xt_articulo']."</option>";
						}

						echo "</select>";	

					echo "</td>";
				echo "</tr>";

				echo"<tr height='10'></tr>";

				echo "<tr id='nuevoArticulo' style='display:none;'>";
					echo "<td id='iconosTexto2' align='center'>";
						echo "Nuevo Articulo<br>";
						echo "<input type='text' name='inputNuevoArticulo'>";
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Descripción<br>
							<input type='text' name='inputDescripcion'>";
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";
				
			
				echo"<tr height='15'></tr>";
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='submit' value='Aceptar asignación' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
		*/
		echo "<iframe src='https://react.escalante.com.mx:2053/Sistemas/Intranet/Resguardo/SolicitudResguardo?usuario=".$_REQUEST['usuario']."'></iframe>";
	echo "</div>";

}
?>


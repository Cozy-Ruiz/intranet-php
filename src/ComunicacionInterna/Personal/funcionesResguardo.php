<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");

if($_POST['tipoMovimiento'] == 'Recepción'){

	if( isset($_POST['resguardoId'], $_POST['comentarioUsuario'], $_POST['comentarioEmpresa'], $_POST['descripcionResguardo']) ){
		$INTRANETV2->Execute("UPDATE sgi_resguardo_articulos SET xt_descripcion = '". $_POST['descripcionResguardo']."' , xt_comentariosUsuario = '".$_POST['comentarioUsuario']."' , xt_comentariosEmpresa = '".$_POST['comentarioEmpresa']."' , xd_fechaRecepcion = NOW() WHERE xn_index = ".$_POST['resguardoId']."");
		$INTRANETV2->close();
	}
}if($_POST['tipoMovimiento'] == 'Devolución'){

	if( isset($_POST['resguardoId'], $_POST['comentarioUsuario'], $_POST['comentarioEmpresa'], $_POST['descripcionResguardo']) ){
		$INTRANETV2->Execute("UPDATE sgi_resguardo_articulos SET xt_descripcion = '". $_POST['descripcionResguardo']."' , xt_comentariosUsuario = '".$_POST['comentarioUsuario']."' , xt_comentariosEmpresa = '".$_POST['comentarioEmpresa']."' , xd_fechaEntrega = NOW() WHERE xn_index = ".$_POST['resguardoId']."");
		$INTRANETV2->close();
	}
}else if($_POST['tipoMovimiento'] == 'Aceptación'){

	if( isset($_POST['resguardoId'], $_POST['comentarioEmpresa'], $_POST['comentarioUsuario'], $_POST['descripcionResguardo']) ){
		$INTRANETV2->Execute("UPDATE sgi_resguardo_articulos SET xt_descripcion = '". $_POST['descripcionResguardo']."' ,  xt_comentariosEmpresa = '".$_POST['comentarioEmpresa']."' , xt_comentariosUsuario = '".$_POST['comentarioUsuario']."' , xd_fechaAceptacion = NOW() WHERE xn_index = ".$_POST['resguardoId']."");
		$INTRANETV2->close();
	}
}

/*
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
<title>Recibe resguardo usuario</title>

</head>
<body>
<?php
*/

/*
$catalogoArticulos = $INTRANETV2->Execute("SELECT * FROM sgi_catalogo_articulos_resguardo");

if($_POST['selectArticulo'] != ''){

	$INTRANETV2->Execute("INSERT INTO sgi_resguardo_articulos (xt_usuario, xt_articulo, xt_descripcionRecepcion) VALUES ('".$_REQUEST['usuario']."', '".$_POST['selectArticulo']."', '".$_POST['inputObservaciones']."') ");
	
  	?>
	<script type="text/javascript">
		window.opener.top.location.reload(true);
		window.close();
	</script>
	<?php
	
}else if($_REQUEST['usuario'] != ''){	

	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoRol' method='post' action='recibeResguardoUsuario.php?usuario=".$_REQUEST['usuario']."'>";

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
						echo "<select name='selectArticulo'>";

						foreach($catalogoArticulos as $registro){
							echo "<option value='".$registro['xt_articulo']."'>".$registro['xt_articulo']."</option>";
						}

						echo "</select>";	

					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Observaciones<br>
							<input type='text' name='inputObservaciones'>";
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
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";

}*/
?>


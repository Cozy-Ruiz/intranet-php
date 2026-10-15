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
	<title>Ficha articulo resguardo</title>
	<script>
		function registraRecepcion(resguardoId){

			if(confirm(
				"Recibo el equipo y herramienta mencionada en este módulo, incluyendo la(s) siguiente(s) llave(s) de la empresa y me comprometo a cumplir con las siguientes políticas:\n\n" +
				"a. Darle el uso adecuado para el cual fue entregado, siendo únicamente para actividades de la empresa.\n\n" +
				"b. No realizar duplicados, ni prestarlas.\n\n" +
				"c. Informar a mi jefe inmediato en caso de pérdida de la(s) llave(s).\n\n" +
				"d. En caso de daño por mal uso, me comprometo a cubrir el costo de la reparación o sustitución.\n\n" +
				"e. Entregarlo a la empresa cuando me lo requieran o en el momento de la separación de la relación laboral.\n\n" +
				"f. Al personal que se le entreguen llaves de una o más puertas de acceso a la oficina también deberá cumplir con las siguientes políticas:\n\n" +
				"   i. Será responsable de todas las instalaciones de la empresa al ingresar a ellas en horario no laboral.\n" +
				"   ii. Informar a su jefe inmediato de cualquier anomalía dentro de las instalaciones.\n" +
				"   iii. Será responsable de que ningún aparato eléctrico y de iluminación quede encendido al retirarse de las instalaciones.\n" +
				"   iv. Cerciorarse que las chapas queden bien cerradas al retirarse de la empresa."
			)){
				descripcionResguardo = document.getElementsByName('inputDescripcionResguardo')[0].value;
				comentarioUsuario = document.getElementsByName('inputComentariosUsuario')[0].value;
				//comentarioUsuario = comentarioUsuario.replace(/\n/, "<br>");
				comentarioEmpresa = document.getElementsByName('inputComentariosEmpresa')[0].value;

				var xhttp = new XMLHttpRequest();

				xhttp.onreadystatechange = function() {
					
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						console.log("Response:<" + xhttp.responseText + ">");
						//if(xhttp.responseText == ""){
							//location.reload();
							window.opener.top.location.reload(true);
							window.close();
						//}else{
							//alert("<"+xhttp.responseText+">");
							//actualizaReferencia(referencia);
						//}
					}
				};
				
				xhttp.open("POST", "funcionesResguardo.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("resguardoId=" + resguardoId + "&descripcionResguardo=" + descripcionResguardo + "&comentarioUsuario=" + comentarioUsuario + "&comentarioEmpresa=" + comentarioEmpresa + "&tipoMovimiento=Recepción");
			}
			
		}

		function registraDevolucion(resguardoId){
			descripcionResguardo = document.getElementsByName('inputDescripcionResguardo')[0].value;
			comentarioUsuario = document.getElementsByName('inputComentariosUsuario')[0].value;
			//comentarioUsuario = comentarioUsuario.replace(/\n/, "<br>");
			comentarioEmpresa = document.getElementsByName('inputComentariosEmpresa')[0].value;

			var xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function() {
				
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					console.log("Response:<" + xhttp.responseText + ">");
					//if(xhttp.responseText == ""){
						//location.reload();
						window.opener.top.location.reload(true);
						window.close();
					//}else{
						//alert("<"+xhttp.responseText+">");
						//actualizaReferencia(referencia);
					//}
				}
			};
			
			xhttp.open("POST", "funcionesResguardo.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("resguardoId=" + resguardoId + "&descripcionResguardo=" + descripcionResguardo + "&comentarioUsuario=" + comentarioUsuario + "&comentarioEmpresa=" + comentarioEmpresa + "&tipoMovimiento=Devolución");	
		}

		function registraAceptacion(resguardoId){
			descripcionResguardo = document.getElementsByName('inputDescripcionResguardo')[0].value;
			comentarioEmpresa = document.getElementsByName('inputComentariosEmpresa')[0].value;
			//comentarioEmpresa = comentarioEmpresa.replace(/\n/, "<br>");
			comentarioUsuario = document.getElementsByName('inputComentariosUsuario')[0].value;
			
			var xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function() {
				
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					console.log("Response:<" + xhttp.responseText + ">");
					//if(xhttp.responseText == ""){
						//location.reload();
						window.opener.top.location.reload(true);
						window.close();
					//}else{
						//alert("<"+xhttp.responseText+">");
						//actualizaReferencia(referencia);
					//}
				}
			};
			
			xhttp.open("POST", "funcionesResguardo.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("resguardoId=" + resguardoId + "&descripcionResguardo=" + descripcionResguardo + "&comentarioEmpresa=" + comentarioEmpresa + "&comentarioUsuario=" + comentarioUsuario + "&tipoMovimiento=Aceptación");
			
		}
	</script>			
</head>
<body>
<?php

/*
$indexConsecutivo = 0;
$catalogoArticulos = $INTRANETV2->Execute("SELECT * FROM sgi_catalogo_articulos_resguardo");

if($_POST['selectArticulo'] != ''){

	$INTRANETV2->Execute("INSERT INTO sgi_resguardo_articulos (xt_usuario, xt_articulo, xt_descripcionRecepcion) VALUES ('".$_REQUEST['usuario']."', '".$_POST['selectArticulo']."', '".$_POST['inputObservaciones']."') ");
	
  	?>
	<script type="text/javascript">
		window.opener.top.location.reload(true);
		window.close();
	</script>
	<?php
	
}else*/
 if($_REQUEST['articuloId'] != '' && $_REQUEST['tipoMovimiento'] != ''){

	//echo "SELECT ra.*, (SELECT xt_nombre FROM intranetgea_usuarios WHERE kp_usuario = ra.xt_usuario) as xt_nombreUsuario FROM sgi_resguardo_articulos ra WHERE ra.xn_index = ".$_REQUEST['articuloId']." ";
	$resguardo = $INTRANETV2->getRow("SELECT ra.*, (SELECT xt_nombre FROM intranetgea_usuarios WHERE kp_usuario = ra.xt_usuario) as xt_nombreUsuario FROM sgi_resguardo_articulos ra WHERE ra.xn_index = ".$_REQUEST['articuloId']." ");
	//var_dump($resguardo);

	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoRol' method='post' action='fichaArticuloResguardo.php?usuario=".$_REQUEST['usuario']."'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>".$_REQUEST['tipoMovimiento']." articulo resguardo</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			echo "</table>";
			
			echo "<table border='0' align='center'>";

				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td align='center'>";
						echo "<h2>".$resguardo['xt_nombreUsuario']."</h2>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td align='center'>";
						echo "<h3>".$resguardo['xt_articulo']."<h3>";	
					echo "</td>";
				echo "</tr>";

				if($_REQUEST['tipoMovimiento'] == 'Recepción' || $_REQUEST['tipoMovimiento'] == 'Devolución' || $_REQUEST['tipoMovimiento'] == 'Aceptación'){
					$seccionDescripcionResguardo = "<input type='text' name='inputDescripcionResguardo' style='width:100%;' value='".$resguardo['xt_descripcion']."'>";
				}else{
					$seccionDescripcionResguardo = nl2br($resguardo['xt_descripcion']) ;
				}

				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Descripcion</p><br>".$seccionDescripcionResguardo."";	
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";
				
				if($_REQUEST['tipoMovimiento'] == 'Recepción' || $_REQUEST['tipoMovimiento'] == 'Devolución' || $_REQUEST['tipoMovimiento'] == 'Aceptación'){
					$seccionComentariosUsuario = "<textarea name='inputComentariosUsuario' rows='5' style='width:100%;'>".$resguardo['xt_comentariosUsuario']."</textarea>";
				}else{
					$seccionComentariosUsuario = $resguardo['xt_comentariosUsuario'] == '' ? 'No hay comentarios' : nl2br($resguardo['xt_comentariosUsuario']) ;
				}
				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Comentarios usuario</p><br>".$seccionComentariosUsuario."";
					echo "</td>";
				echo "</tr>";

				if($_REQUEST['tipoMovimiento'] == 'Recepción' || $_REQUEST['tipoMovimiento'] == 'Devolución' || $_REQUEST['tipoMovimiento'] == 'Aceptación'){
					$seccionComentariosEmpresa = "<textarea name='inputComentariosEmpresa' rows='5' style='width:100%;'>".$resguardo['xt_comentariosEmpresa']."</textarea>";
				}else{
					$seccionComentariosEmpresa = $resguardo['xt_comentariosEmpresa'] == '' ? 'No hay comentarios' : nl2br($resguardo['xt_comentariosEmpresa']) ;
				}
				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Comentarios empresa</p><br>".$seccionComentariosEmpresa."";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Fechas<p>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td align='center'>";
						echo "Fecha solicitud: ".$resguardo['xd_fechaAsignacion'];
					echo "</td>";
				echo "</tr>";

				if($resguardo['xd_fechaRecepcion'] != ''){
					echo "<tr>";
						echo "<td align='center'>";
							echo "Fecha recepción: ".$resguardo['xd_fechaRecepcion'];
						echo "</td>";
					echo "</tr>";
				}

				if($resguardo['xd_fechaEntrega'] != ''){
					echo "<tr>";
						echo "<td align='center'>";
							echo "Fecha devolución: ".$resguardo['xd_fechaEntrega'];
						echo "</td>";
					echo "</tr>";
				}

				if($resguardo['xd_fechaAceptacion'] != ''){
					echo "<tr>";
						echo "<td align='center'>";
							echo "Fecha aceptación: ".$resguardo['xd_fechaAceptacion'];
						echo "</td>";
					echo "</tr>";
				}
				
				echo"<tr height='10'></tr>";
				
			
				echo"<tr height='15'></tr>";
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				if($_REQUEST['tipoMovimiento'] == 'Resumen'){
					$buttonSubmit = "<input type='button' value='Cerrar' onclick='window.close();' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				}else if($_REQUEST['tipoMovimiento'] == 'Recepción'){
					$buttonSubmit = "<input type='button' value='Aceptar recepción' onclick=' registraRecepcion(".$resguardo['xn_index'].");' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				}else if($_REQUEST['tipoMovimiento'] == 'Devolución'){
					$buttonSubmit = "<input type='button' value='Aceptar devolución' onclick='registraDevolucion(".$resguardo['xn_index'].");' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				}else if($_REQUEST['tipoMovimiento'] == 'Aceptación'){
					$buttonSubmit = "<input type='button' value='Aceptar' onclick='registraAceptacion(".$resguardo['xn_index'].");' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				}
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo $buttonSubmit;
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";

}
?>


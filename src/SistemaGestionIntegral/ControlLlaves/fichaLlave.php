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
				xhttp.send("resguardoId=" + resguardoId + "&comentarioUsuario=" + comentarioUsuario + "&comentarioEmpresa=" + comentarioEmpresa + "&tipoMovimiento=Recepción");
			}
			
		}

		function registraDevolucion(resguardoId){
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
			xhttp.send("resguardoId=" + resguardoId + "&comentarioUsuario=" + comentarioUsuario + "&comentarioEmpresa=" + comentarioEmpresa + "&tipoMovimiento=Devolución");	
		}

		function registraAceptacion(resguardoId){
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
			xhttp.send("resguardoId=" + resguardoId + "&comentarioEmpresa=" + comentarioEmpresa + "&comentarioUsuario=" + comentarioUsuario + "&tipoMovimiento=Aceptación");
			
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
 if(isset($_REQUEST['numeroLlave'], $_REQUEST['usuario'])){

	//echo "SELECT c.*, (SELECT u.xt_nombre FROM perfiles.usuarios u WHERE u.xt_usuario = c.xt_usuario) as xt_nombreUsuario FROM sgi_control_llaves c WHERE c.xt_numeroLlave = '".$_REQUEST['numeroLlave']."' ";
	$resguardo = $INTRANETV2->getRow("SELECT c.*, (SELECT u.xt_nombre FROM perfiles.usuarios u WHERE u.xt_usuario = c.xt_usuario) as xt_nombreUsuario FROM sgi_control_llaves c WHERE c.xt_numeroLlave = '".$_REQUEST['numeroLlave']."' AND xt_usuario = '".$_REQUEST['usuario']."' ");
	//echo "SELECT * FROM sgi_control_cambios_llaves WHERE xt_numeroLlave = '".$_REQUEST['numeroLlave']."' ORDER BY xd_fecha";
	$cambios = $INTRANETV2->getArray("SELECT * FROM sgi_control_cambios_llaves WHERE xt_numeroLlave = '".$_REQUEST['numeroLlave']."' ORDER BY xd_fecha");

	echo "<div id='wrapperPopUp'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Descripción Llave</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			echo "</table>";
			
			echo "<table border='0' align='center'>";

				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
				echo "</tr>";
				/*
				echo "<tr>";
					echo "<td align='center'>";
						echo "<h2>".$resguardo['xt_nombreUsuario']."</h2>";
					echo "</td>";
				echo "</tr>";
				*/
				echo "<tr>";
					echo "<td align='center'>";
						echo "<h3>Llave ".$resguardo['xt_numeroLlave']."<h3>";	
					echo "</td>";
				echo "</tr>";
				/*
				echo "<tr>";
					echo "<td align='center'>";
						echo "".$resguardo['xt_descripcion']."";	
					echo "</td>";
				echo "</tr>";
				*/
				
				echo"<tr height='10'></tr>";
				/*
				if($_REQUEST['tipoMovimiento'] == 'Recepción' || $_REQUEST['tipoMovimiento'] == 'Devolución' || $_REQUEST['tipoMovimiento'] == 'Aceptación'){
					$seccionComentariosUsuario = "<textarea name='inputComentariosUsuario' rows='5' style='width:100%;'>".$resguardo['xt_comentariosUsuario']."</textarea>";
				}else{
					$seccionComentariosUsuario = $resguardo['xt_comentariosUsuario'] == '' ? 'No hay comentarios' : nl2br($resguardo['xt_comentariosUsuario']) ;
				}
				*/
				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Lugar de uso</p><br>".$resguardo['xt_lugarUso']."";
					echo "</td>";
				echo "</tr>";

				/*
				if($_REQUEST['tipoMovimiento'] == 'Recepción' || $_REQUEST['tipoMovimiento'] == 'Devolución' || $_REQUEST['tipoMovimiento'] == 'Aceptación'){
					$seccionComentariosEmpresa = "<textarea name='inputComentariosEmpresa' rows='5' style='width:100%;'>".$resguardo['xt_comentariosEmpresa']."</textarea>";
				}else{
					$seccionComentariosEmpresa = $resguardo['xt_comentariosEmpresa'] == '' ? 'No hay comentarios' : nl2br($resguardo['xt_comentariosEmpresa']) ;
				}*/
				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Asignada a</p><br>".$resguardo['xt_nombreUsuario']."";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Observaciones</p><br>".$resguardo['xt_observaciones']."";
					echo "</td>";
				echo "</tr>";
				/*
				echo "<tr>";
					echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Fecha Recepción<p>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='center'>";
						echo "Fecha solicitud: ".$resguardo['xd_fechaAsignacion'];
					echo "</td>";
				echo "</tr>";
				*/

				//if($resguardo['xd_fechaRecepcion'] != ''){
					echo "<tr>";
						echo "<td align='center'>";
						echo "<p id='iconosTexto2'>Fecha Recepción</p><br>".$resguardo['xd_fecha']."";
						echo "</td>";
					echo "</tr>";
				//}

				/*
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
				*/
				
				echo"<tr height='10'></tr>";
				
			
				echo"<tr height='15'></tr>";
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				//if($_REQUEST['tipoMovimiento'] == 'Resumen'){
					$buttonSubmit = "<input type='button' value='Cerrar' onclick='window.close();' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				/*
				}else if($_REQUEST['tipoMovimiento'] == 'Recepción'){
					$buttonSubmit = "<input type='button' value='Aceptar recepción' onclick=' registraRecepcion(".$resguardo['xn_index'].");' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				}else if($_REQUEST['tipoMovimiento'] == 'Devolución'){
					$buttonSubmit = "<input type='button' value='Aceptar devolución' onclick='registraDevolucion(".$resguardo['xn_index'].");' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				}else if($_REQUEST['tipoMovimiento'] == 'Aceptación'){
					$buttonSubmit = "<input type='button' value='Aceptar' onclick='registraAceptacion(".$resguardo['xn_index'].");' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				}
				*/
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo $buttonSubmit;
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";
			
			echo "<table border='0' align='center' name='Cuerpo'>";
				echo "<tr>";
					echo "<td align='left' width='685px' id='titulo2'>Control de cambios</td>";
						echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
						//echo "<a href='AgregarNuevoRol.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				echo"<tr height='20px'> </tr>";
					echo "<td align='left' width='250px' valign='top'>";
						echo "<a href='' id='manualVinculo'></a>";
					echo "</td>";
					echo "<td align='left' width='550px' valign='top'></td>";
				echo "</tr>";
				
				echo"<tr height='5'> </tr>";
			echo "</table>";

			echo "<table border='0' cellspacing='0' style='width:100%; margin-bottom:4em;'>";	
				echo "<tr height='45'>";
					echo "<td></td>";
					echo "<td><h2><b>Descripción</b></h2></td>";
					echo "<td><h2><b>Usuario</b></h2></td>";
					echo "<td><h2><b>Fecha</b></h2></td>";
				echo "</tr>";

				foreach($cambios as $clave => $cambio){
					echo "<tr height='30'>";
						echo "<td>".($clave + 1).".-</td>";
						echo "<td>".$cambio['xt_descripcion']."</td>";
						echo "<td>".$cambio['xt_usuario']."</td>";
						echo "<td>".$cambio['xd_fecha']."</td>";
					echo "</tr>";
				}

			echo"</table>";

		
	echo "</div>";

}
?>


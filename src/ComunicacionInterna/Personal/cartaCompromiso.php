<?PHP
$nombrephp="fichaPersonal.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
//require_once("MailAltaUsuario.php");

error_reporting(E_PARSE);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Carta Compromiso</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            
           <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
           
           
           
           
           
           <script>
				function showBanana(valor){
					if(valor == 1){
						document.getElementById("banana1").style.display="inline-block";
						document.getElementById("banana0").style.display="none";
						document.getElementById("mapaIntranet").style.display="inline-block";
					} else if (valor == 0){
						document.getElementById("banana1").style.display="none";
						document.getElementById("banana0").style.display="inline-block";
						document.getElementById("mapaIntranet").style.display="none";
					}
				}
			</script>
            
            <script>
				function show(valor){
					if(valor == 1){
						document.getElementById("Agregar").style.display="block";
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
					} else if (valor == 0){
						document.getElementById("Agregar").style.display="none";
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					}
				}
			</script>
            
               <script>
				function show2(valor){
					if(valor == 1){
						document.getElementById("agrega").style.display="block";
						document.getElementById("activo").style.display="none";
						document.getElementById("inactivo").style.display="block";
					} else if (valor == 0){
						document.getElementById("agrega").style.display="none";
						document.getElementById("activo").style.display="block";
						document.getElementById("inactivo").style.display="none";
					}
				}
			</script>
            <script type="text/javascript">
				function reCargarPadre(){
					<?php
					echo"opener.location.href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/Personal/fichaPersonal.php?ID=$IDpersonal\';";
					?>
					window.close();
				}
			</script>  
            <script language="javascript">
				function SINO(cual) {
				   var elElemento=document.getElementById(cual);
				   if(elElemento.style.display == 'block') {
					  elElemento.style.display = 'none';
				   } else {
					  elElemento.style.display = 'block';
				   }
				}
			</script>
           
           
           <script type="text/javascript">
			   
    			function activaFile(cual){
 					var vFile=document.getElementById(cual);
  	 				if(vFile.style.display == 'block') {
      					vFile.style.display = 'none';
   	  				} else {
      					vFile.style.display = 'block';
   					}
    			}
			   
		   </script>

		   	<script>
				function confirmDelete(resguardoId){
					var confirmacion = confirm(" Se eliminará toda la información. Confirma eliminar Resguardo?");
					if (confirmacion != false) {
						
						var xhttp = new XMLHttpRequest();

						xhttp.onreadystatechange = function() {
							
							if (xhttp.readyState == 4 && xhttp.status == 200) {

								if(xhttp.responseText == ""){
									location.reload();
								}else{
									alert(xhttp.responseText);
									//actualizaReferencia(referencia);
								}
							}
						};
						
						xhttp.open("POST", "eliminaResguardoPersonal.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("resguardoId=" + resguardoId);
					}	
				}

				function eliminaDocumentoExpediente(usuario, ruta){
					var confirmacion = confirm("Confirma eliminar documento de expediente?");
					if (confirmacion != false) {

						var xhttp = new XMLHttpRequest();

						xhttp.onreadystatechange = function() {
							
							if (xhttp.readyState == 4 && xhttp.status == 200) {

								if(xhttp.responseText == ""){
									location.reload();
								}else{
									alert(xhttp.responseText);
									//actualizaReferencia(referencia);
								}
							}
						};
						
						xhttp.open("POST", "eliminaExpediente.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=eliminaDocumento&usuario="+usuario+"&ruta="+ruta);
						
					}	
				}
			</script>
           
            <style>
			.enlaces { 
			FONT-SIZE: 11px; 
			font-family:Lucida Sans;
			font-size:12px;
			color:#007cbd; 
			TEXT-DECORATION: none 
			}
			</style>
  	 
				</head>

<body>
<?PHP

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a> <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/miCuenta.php' id='breadcrumbs'>Mi cuenta";



if($_POST["usuarioAceptaCarta"]){

	$INTRANET->Execute("
		UPDATE SGI_Empleados 
		set 
		xd_aceptacionCartaCompromiso = NOW()
		WHERE kf_usuario = '".$_POST["usuarioAceptaCarta"]."' 
	");
	
}



if($_GET["usuario"]){
	$datosPersonal= $INTRANET->getRow("SELECT * FROM SGI_Empleados WHERE kf_usuario='".$_GET["usuario"]."' ORDER BY xn_Foto ");
}else{
	$datosPersonal= $INTRANET->getRow("SELECT * FROM SGI_Empleados WHERE kf_usuario='".$_SESSION["sesionUsuario"]."' ORDER BY xn_Foto ");
}

//var_dump($datosPersonal);	

echo"<div id='wrapperFicha' align='center'>";

	echo "<table border='0' align='center' name='Encabezado'>";		
		echo"<tr height='80px'> </tr>";
		///Titulo Ficha
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='700px'>";
				echo "Carta Compromiso";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		//echo"<tr height='100'> </tr>";
	echo "</table>";
	
	
	//banana de navegacion
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";
		

	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 



		echo "<div>".$datosPersonal["xt_Nombre"]." ".$datosPersonal["xt_ApellidoPaterno"]." ".$datosPersonal["xt_ApellidoMaterno"]."</div>";

		
		echo "<table border='0' align='center' width='600'>";

			echo"<tr height='30px'> </tr>";

			echo"<tr>";
				echo"<td id='titulo2'>Carta Compromiso SGI</td>";
				echo "<td>".$datosPersonal["xt_Empresa"]."</td>";
				if(date('Y') == date('Y', strtotime($datosPersonal["xd_aceptacionCartaCompromiso"]))){
					echo "<td>".$datosPersonal["xd_aceptacionCartaCompromiso"]."</td>";
				}
			echo"</tr>";
		///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";

			echo"<tr height='30px'> </tr>";
			
			echo "<tr height='10'>";
				echo "<td colspan=3>";
				echo '
				<object
					data="./CartaCompromisoSGI/CRPRHGRLF00047CartaCompromiso_v3_2.pdf"
					type="application/pdf"
					width="100%"
					height="700"
					title="Embedded PDF Viewer"
				>
					<p>
					Your browser does not support PDFs. [Download the PDF
					document](CRPRHGRLF0047CartaCompromiso.pdf)
					</p>
				</object>
				';
				echo "</td>";
			echo "</tr>";

		echo "</table>";

		echo "<table border='0' align='center' width='600'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";

			if( ($datosPersonal["xd_aceptacionCartaCompromiso"] == null) || (date('Y') != date('Y', strtotime($datosPersonal["xd_aceptacionCartaCompromiso"]))) ){
				echo"<tr height='40'>";
					echo"<td colspan='2' valign='bottom' align='right'>";
						echo "<form  method='POST' action='cartaCompromiso.php'>";
							echo "<input type= 'hidden' name='usuarioAceptaCarta' value='".$datosPersonal["kf_usuario"]."' >";
							echo "<input type='image'src='../../Imagenes/ICN_BotonAceptar.png' width='90' height='29'>";
						echo "</form>";
					echo"</td>";
				echo"</tr>";
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
	
	
	

echo "</div>";

?>
</body>
</html>
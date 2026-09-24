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
<title>Expediente Personal</title>
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


//$IDpersonal= $_GET['ID'];

//$s= $INTRANET->execute("SELECT xt_NumPersonal, xt_Nombre, xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Estatus,xt_Tipo, xt_Empresa, xn_Foto, xt_extensionTel, xt_puesto,xt_ciudad,kf_usuario FROM SGI_Empleados WHERE kp_personalId=$IDpersonal");
$s= $INTRANET->execute("SELECT xt_NumPersonal, xt_Nombre, xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Estatus,xt_Tipo, xt_Empresa, xn_Foto, xt_extensionTel, xt_puesto,xt_ciudad,kf_usuario FROM SGI_Empleados WHERE kf_usuario='".$_SESSION["sesionUsuario"]."' ");
	
while($r = $s->fetchRow()){
	$NumPersonal = $r[0];
	$nombre= $r[1];
	$apellidoP = $r[2];
	$apellidoM = $r[3];
	$estatus = $r[4];
	$tipo = $r[5];
	$empresa = $r[6];
	$foto = $r[7];
	$extensionTel = $r[8];
	$puesto = $r[9];
	$ciudad = $r[10];
	$usuario = $r[11];

	$correo = $INTRANET->getOne("SELECT xt_correo FROM PERFILES.USUARIOS WHERE xt_usuario = '$usuario' ");	
	
} unset($r);unset($s);

if($ciudad == 'DF'){
	$ciudadDespliegue = 'Distrito Federal';
}else if($ciudad == 'CUN'){
	$ciudadDespliegue = 'Cancún';
}else if($ciudad == 'VER'){
	$ciudadDespliegue = 'Veracruz';
}else if($ciudad == 'LR'){
	$ciudadDespliegue = 'Laredo';
}else if($ciudad == 'NLR'){
	$ciudadDespliegue = 'Nuevo Laredo';
}else if($ciudad == 'TOL'){
	$ciudadDespliegue = 'Toluca';
}else if($ciudad == 'CVC'){
	$ciudadDespliegue = 'Cuernavaca';
}

	

echo"<div id='wrapperFicha' align='center'>";

	echo "<table border='0' align='center' name='Encabezado'>";		
		echo"<tr height='80px'> </tr>";
		///Titulo Ficha
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='700px'>";
				echo "Expediente Personal";
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


	echo "<table border='0' align='center' width='600'>";
		echo"<tr height='30px'> </tr>";
	///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
		
	//FOTO //NUMERO DE PERSONAL

		echo "<tr align='left' height='20' >";
			echo "<td id='titulo2' align='left'>$NumPersonal <input type= 'hidden' name='Id' value='$IDpersonal' > </td>"; 
			if($foto == ""){
				echo "<td  align='left'> <img src='FILES/sinFoto.jpg' height='117' width='100'> </td>";
			}else{
				
				echo "<td  align='left'> <img src='$foto' height='117' width='100'> </td>";
			}
			
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
				
	//NOMBRE
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Nombre: </td>";
			echo "<td id='iconosTexto' align='left'>$nombre</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
	//APELLIDO PATERNO
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Apellido paterno: </td>";
			echo "<td id='iconosTexto' align='left'>$apellidoP</td>";
		echo "</tr>";

		echo"<tr height='10'> </tr>";
		
	//APELLIDO MATERNO
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Apellido materno: </td>";
			echo "<td id='iconosTexto' align='left'>$apellidoM</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
	//ESTATUS
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Estatus: </td>";
				if( $estatus==1 ){					
					echo "<td id='iconosTexto' align='left'>Activo</td>";	
				}else if($estatus==2) {
					echo "<td id='iconosTexto' align='left'>Inactivo</td>";
				}
		echo "</tr>";	
		
		echo"<tr height='10'> </tr>";
	//TIPO
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Tipo: </td>";
				if( $tipo=='E' ){					
					echo "<td id='iconosTexto' align='left'>Empleado</td>";	
				}else if($tipo=='P') {
					echo "<td id='iconosTexto' align='left'>Proveedor</td>";
				}else if($tipo=='H') {
					echo "<td id='iconosTexto' align='left'>Empleado por honorarios</td>";
				}else if($tipo=='C') {
					echo "<td id='iconosTexto' align='left'>Cliente</td>";
				}else if($tipo=='V') {
					echo "<td id='iconosTexto' align='left'>VIP</td>";
				}else if($tipo=='D') {
					echo "<td id='iconosTexto' align='left'>Directiva</td>";
				}else if($tipo=='A') {
					echo "<td id='iconosTexto' align='left'>Autoridad</td>";
				}
		echo "</tr>";	
		
		echo"<tr height='10'> </tr>";	
			
	//EMPRESA
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Empresa: </td>";
			echo "<td id='iconosTexto' align='left'>$empresa</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
	//CIUDAD
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Ciudad: </td>";
			echo "<td id='iconosTexto' align='left'>$ciudadDespliegue</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		//Correo
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Correo: </td>";
			echo "<td id='iconosTexto' align='left'>$correo</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		
	//Extension
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Extensión Tel: </td>";
			echo "<td id='iconosTexto' align='left'>$extensionTel</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	//Puesto
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Puesto: </td>";
			echo "<td id='iconosTexto' align='left'>$puesto</td>";
		echo "</tr>";

		echo"<tr height='10'> </tr>";
		
		$nombreCompleto = $nombre." ".$apellidoP." ".$apellidoM;
		
	echo "</table>";
		
	echo "<table border='0' align='center' width='600'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30px'> </tr>";
		/*
		if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Pedro_Moyotl') || ($usuarioId == 'Saday_Hernandez') || ($usuarioId == 'cozy') || ($usuarioId == 'Fernando_Garcia') || ($usuarioId == 'Francisco_Perez') || ($usuarioId == 'sdelap')|| ($usuarioId == 'Marlene_Avelino')|| ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Guillermo_Quezada')  || ($usuarioId == 'Denisse_Valladares')){
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<a href='modificaPersonal.php?Id=$IDpersonal'><img src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'></img></a>";
				echo"</td>";
			echo"</tr>";
		}else{
			echo"<tr height='10'> </tr>";
		}
		*/
		echo"<tr height='30px'> </tr>";
	echo "</table>";
		
		
	//Expediente perosnal

	$tiposExpedientes = $INTRANET->getArray("SELECT DISTINCT xt_tipo_expediente FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado ='$usuario' AND YEAR(xd_fecha) = YEAR(NOW())");
		
	for($i=0; $i<count($tiposExpedientes); $i++){
		$tiposExpedientes[$i]["versiones"] = $INTRANET->getArray("SELECT DISTINCT xt_ruta_archivo, xd_fecha, xt_estatus FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado = '".$usuario."' and xt_tipo_expediente = '".$tiposExpedientes[$i]["xt_tipo_expediente"]."' AND YEAR(xd_fecha) = YEAR(NOW()) ORDER BY xd_fecha DESC ");
	}

	echo "<table border='0' align='center' width='600'>";
	
		echo"<tr>";
			echo"<td id='titulo2'>Expediente personal</td>";
			
			echo"<td align='right'>";
				echo "<a href='asignaDocumentoExpediente.php?usuario=".$usuario."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=600,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block; padding-right:.5em;'></a>";
			echo"</td>";
			
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineTop' align='right' colspan='2'> </td>";
		echo "</tr>";
		
		echo"<tr height='20'>
			<td colspan='2'></td>";
		echo "</tr>";

		echo"<tr>";
		foreach($tiposExpedientes as $tipoExpediente){
			echo "<table border='0' align='center' width='600'>";
				echo"<tr>";
					echo"<td id='titulo2'>".$tipoExpediente["xt_tipo_expediente"]."</td>";
					echo "<td align='right'>";
						if($tipoExpediente["versiones"][0]["xt_estatus"] == "Aceptado"){
							echo "<img src='../../Imagenes/ICN_BotonVerde.png'>";
						}else if($tipoExpediente["versiones"][0]["xt_estatus"] == "Rechazado"){
							echo "<img src='../../Imagenes/ICN_BotonNaranja.png' width='15' height='15'>";
						}else{
							echo "<img src='../../Imagenes/ICN_BotonAmarillo.png'>";
						}
					echo "</td>";
				echo"</tr>";
				
				echo "<tr colspan='2'>";
					echo "<td id='titleBlueLineTop' colspan='2'> </td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td align='left'>";
						echo "<h3>Fecha de actualización: ".$tipoExpediente["versiones"][0]["xd_fecha"]."</h3>";
					echo "</td>";

					echo "<td align='right'>";
						echo "<h3><img src='../../Imagenes/ICN_NoOK.png' height='13px' width='13px' onClick=\"eliminaDocumentoExpediente('".$usuario."', '".$tipoExpediente["versiones"][0]["xt_ruta_archivo"]."')\"></h3>";
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td align='center' colspan='2'>";
						//echo "<h3>Vista previa del documento</h3>";
						echo "<iframe src='".$tipoExpediente["versiones"][0]["xt_ruta_archivo"]."' width='800' height='600' style='border: none;'></iframe>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		}
		echo"</tr>";

	echo "</table>";

echo "</div>";

?>
</body>
</html>
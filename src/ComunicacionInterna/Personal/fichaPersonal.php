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
<title>Ficha </title>
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
					var confirmacion = confirm("Confirma eliminar Resguardo?");
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
			</script>

			<script>
				window.addEventListener("message", function(event) {
					console.log(event);
					// Valida origen por seguridad
					//if (event.origin === "https://localhost:2053"){
					if (event.origin === "https://react.escalante.com.mx:2053"){
						if (event.data === "recargar") {
							location.reload();
						}
					}
				});
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
$IDpersonal= $_GET['ID'];
$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a> <a href='../comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna /</a> <a href='../tableroPersonal.php' id='breadcrumbs'>Acceso Autorizado</a>";

//echo "SELECT xt_NumPersonal, xt_Nombre, xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Estatus,xt_Tipo, xt_Empresa, xn_Foto, xt_extensionTel, xt_puesto,xt_ciudad,kf_usuario FROM SGI_Empleados WHERE kp_personalId=$IDpersonal";
$s= $INTRANET->execute("SELECT xt_NumPersonal, xt_Nombre, xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Estatus,xt_Tipo, xt_Empresa, xn_Foto, xt_extensionTel, (SELECT xt_puesto FROM perfiles.usuarios WHERE xt_usuario = kf_usuario), xt_ciudad,kf_usuario FROM SGI_Empleados WHERE kp_personalId=$IDpersonal");
	
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
		}else if($ciudad == 'CDMX'){
			$ciudadDespliegue = 'Ciudad de México';
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
		
$numeroEmpleado = $INTRANET->getOne("SELECT xt_NumPersonal FROM SGI_Empleados WHERE kp_personalId = $IDpersonal");
	
//verifico si existe evento de acraga de archivos de expediente
	
if(isset($_REQUEST["evento"])){

	if($_REQUEST["evento"] == "cargaArchivoExpediente"){
		
		 $tipoArchivo = $_REQUEST["tipoA"];
		 $usuarioEmpleado = $_REQUEST['usuarioEmpleado'];
		 
		 $empresa = $INTRANET->getOne("SELECT xt_Empresa FROM SGI_Empleados WHERE kp_personalId = $IDpersonal");
		 
		 if($empresa == "Grupo Escalante"){
			$empresa = "GEA";
		 }else if ($empresa == "Nuñez y Escalante"){
			
			$empresa = "NyE";
		 }else if ($empresa == "Transportes de Calidad"){
			$empresa = "TC";
		 }
	
		 $empresa = str_replace(' ','_',$empresa);
		 $usuarioRegistra = $usuarioId;
		 $carpetaDestino="archivos_tmp/".$usuarioEmpleado."/";
		
		//NAS CDMX
		$host = "201.147.92.134";
		//$host = "192.1.169.16";
		$user = "intranetgea";
		$pass = "Qazwsx12";
		$port = 21;

		$conFtp = @ftp_connect($host,$port)or die("No se pudo conectar a... $ftp_server <br><br>");
		
		if($conFtp){

			if(@ftp_login($conFtp, $user, $pass)){

				
				ftp_pasv($conFtp, true);


				$ruta = "Expedientes/".$numeroEmpleado."_".$usuarioEmpleado."/";
				
				$verificaDir = $INTRANET->getOne("SELECT xt_nombre_archivo FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado = '$usuarioEmpleado' ORDER BY xd_fecha DESC");
				
				
				if($verificaDir != ""){
					ftp_chdir($conFtp, $ruta);
					
				}else{
				
					
					if(ftp_mkdir($conFtp,$ruta)){

				 	ftp_chdir($conFtp, $ruta);

					}
				}

			}
					
		}
	}

		
		
		
		
		$carpetaDestino="archivos_tmp/".$usuarioEmpleado."/";

		for($i=0;$i<count($_FILES["archivo"]["name"]);$i++){
			
			$numAleatorio = rand(1,10000);
			$extension = pathinfo($_FILES['archivo']['name'][$i], PATHINFO_EXTENSION);
			$nomA= str_replace(' ','_',$tipoArchivo); 
		 	$nombre_archivo = $numeroEmpleado."_".$nomA."_".$empresa."_".$numAleatorio.".".$extension;
			
			$directorioCompleto = $carpetaDestino.$nombre_archivo;
			
		 # si exsite la carpeta o se ha creado
			if(file_exists($carpetaDestino) || mkdir($carpetaDestino, 0777, true))
			{

				$origen =  $_FILES["archivo"]["tmp_name"][$i];
				
                $directorioCompleto = $directorioCompleto;

				# movemos el archivo
				if(move_uploaded_file($origen, $directorioCompleto)){

					//copio archivo en la nass					
					$nombreArchivo2 = $nombre_archivo;

					if(ftp_put($conFtp, $nombreArchivo2, $directorioCompleto, FTP_BINARY)){
	
						$success_message = array( 
						'name' => $_FILES['file']['name'],
						'filesize' => $_FILES['file']['size']
						);
						
						$rutaInserta = "Expedientes/".$usuarioEmpleado."/".$nombreArchivo2;
						//verifico si existe registro vacio para actualizar, de lo contrario solo inserto nuev0 registro
						$registroVacio = $INTRANET->getOne("SELECT xt_nombre_archivo FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado = '$usuarioEmpleado' AND xt_tipo_expediente = '$tipoArchivo' ORDER BY xd_fecha ASC");


						
						
						if($registroVacio == ""){
							
							//echo "UPDATE SGI_EXPEDIENTE_PERSONAL SET xt_nombre_archivo = '$nombreArchivo2', xt_ruta_archivo = '$rutaInserta' WHERE xt_tipo_expediente = '$tipoArchivo' AND xt_usuario_empleado = '$usuarioEmpleado'";

							//variables ´para validar existencia de archivo
						 $dirExpEmpleado =  "/Expedientes/".$numeroEmpleado."_".$usuarioEmpleado."/";
						  $fileBusca = $nombreArchivo2;
						  $check_file_exist  = $dirExpEmpleado.$fileBusca;
						  $contents_on_server = ftp_nlist($conFtp, $dirExpEmpleado);
							   
							  //verifico que se haya cargado el archivo
							if (in_array($check_file_exist, $contents_on_server)) {


								$INTRANET->Execute("UPDATE SGI_EXPEDIENTE_PERSONAL SET xt_nombre_archivo = '$nombreArchivo2', xt_ruta_archivo = '$rutaInserta' WHERE xt_tipo_expediente = '$tipoArchivo' AND xt_usuario_empleado = '$usuarioEmpleado'");
								
								//insertamos en la tabla de log de acceso
								$INTRANET->Execute("INSERT INTO SGI_LOG_ACCESO_EXPEDIENTE_PERSONAL (xt_usuario, xt_usuario_expediente, xt_tipo_expediente, xt_accion) VALUES ('$usuarioId', '$usuarioEmpleado', '$tipoArchivo', 'SUBIO ARCHIVO')");

							} else {
							    echo "Error: el documento no pudo ser cargado correctamente";
							}
							
							
						}else{

							//variables ´para validar existencia de archivo
						 $dirExpEmpleado = "/Expedientes/".$numeroEmpleado."_".$usuarioEmpleado."/";
						  $fileBusca = $nombreArchivo2;
						  $check_file_exist  = $dirExpEmpleado.$fileBusca;
						  $contents_on_server = ftp_nlist($conFtp, $dirExpEmpleado);
							
							if (in_array($check_file_exist, $contents_on_server)) {
							
								$INTRANET->Execute("INSERT INTO SGI_EXPEDIENTE_PERSONAL (xt_usuario_empleado, xt_tipo_expediente, xt_nombre_archivo, xt_ruta_archivo, xt_usuario_registro) VALUES ('$usuarioEmpleado', '$tipoArchivo', '$nombreArchivo2', '$rutaInserta', '$usuarioId')");
								
								
								//inserto en la tabla de log de acceso
								$INTRANET->Execute("INSERT INTO SGI_LOG_ACCESO_EXPEDIENTE_PERSONAL (xt_usuario, xt_usuario_expediente, xt_tipo_expediente, xt_accion) VALUES ('$usuarioId', '$usuarioEmpleado', '$tipoArchivo', 'SUBIO ARCHIVO')");


							} else {
							    echo "Error: el documento no pudo ser cargado correctamente";
							}
						}		
						
					}
				
				}
			}
            

		}
	
		
		
		//una vez cargado por ftp lo elimino de la ruta temporal local toda la carpeta
		$carpetaElimina = "archivos_tmp/".$usuarioEmpleado; 
		//unlink($targetFile);
		
		eliminarDir($carpetaElimina);
	}
	
	
	function eliminarDir($carpetaElimina) {
		foreach(glob($carpetaElimina . "/*") as $archivos_carpeta){
			$archivos_carpeta;

			if (is_dir($archivos_carpeta)){
				eliminarDir($archivos_carpeta);
			}else{
				unlink($archivos_carpeta);
			}
		}

		rmdir($carpetaElimina);

	}

	
	
	
	
	

	

echo"<div id='wrapperFicha' align='center'>";

		echo "<table border='0' align='center' name='Encabezado'>";		
			echo"<tr height='80px'> </tr>";
			///Titulo Ficha
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='700px'>";
					echo "Ficha Personal";
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
			  
			echo "</td>";
		echo "</tr>";
		
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
			if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Pedro_Moyotl') || ($usuarioId == 'Saday_Hernandez') || ($usuarioId == 'cozy') || ($usuarioId == 'Fernando_Garcia') || ($usuarioId == 'Francisco_Perez') || ($usuarioId == 'sdelap')|| ($usuarioId == 'Marlene_Avelino')|| ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Guillermo_Quezada')  || ($usuarioId == 'Denisse_Valladares')){
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<a href='modificaPersonal.php?Id=$IDpersonal'><img src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'></img></a>";
					echo"</td>";
				echo"</tr>";
			}else{
				echo"<tr height='10'> </tr>";
			}
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		//ACCESO A SISTEMAS
		echo"<form action='fichaPersonal.php?ID=$IDpersonal' method='post'>";
		echo "<table border='0' align='center' width='600'>";
		
			echo"<tr>";
				echo"<td id='titulo2'> Acceso a sistemas </td>";
				if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Pedro_Moyotl') || ($usuarioId == 'Saday_Hernandez') || ($usuarioId == 'cozy') || ($usuarioId == 'Fernando_Garcia') || ($usuarioId == 'Francisco_Perez') || ($usuarioId == 'sdelap')|| ($usuarioId == 'Marlene_Avelino')|| ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Guillermo_Quezada')){
				/*echo"<td align='right'>";
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block;'>";
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(0);' id='ocultar' style='display:none;'>";	
				echo"</td>";*/
				}
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineTop' align='right' colspan='2'> </td>";
			echo "</tr>";
			
			echo"<tr height='20'>
				<td colspan='2'></td>";
			echo "</tr>";
			
			
			$a=0;
			//$s = $INTRANET->Execute("SELECT DISTINCT xt_sistema FROM PERFILES.CATALOGO_SISTEMAS");
			//echo "SELECT DISTINCT CT.xt_sistema FROM PERFILES.CATALOGO_SISTEMAS CT WHERE CT.xt_sistema in(SELECT S.xt_sistema FROM PERFILES.SISTEMAS S WHERE S.xt_usuario = '$usuario')";
			$s = $INTRANET->Execute("SELECT DISTINCT CT.xt_sistema FROM PERFILES.CATALOGO_SISTEMAS CT WHERE CT.xt_sistema in(SELECT S.xt_sistema FROM PERFILES.SISTEMAS S WHERE S.xt_usuario = '$usuario')");
			while($r = $s->fetchRow()){
				
				$sistema = $r[0];
				
			$estatus = $INTRANET->getOne("SELECT xt_estatus FROM PERFILES.SISTEMAS WHERE xt_usuario = '$usuario' AND xt_sistema = '$sistema' ");	
			
			$a++;	
				
				echo "<script>
				function showSistemas".$a."(valor){
					if(valor == 1){
						document.getElementById(\"cuerpoSistema".$a."OFF\").style.display=\"block\";
						document.getElementById(\"cuerpoSistema".$a."ON\").style.display=\"none\";
						document.getElementById(\"seguimientoSistema".$a."\").style.display=\"block\";
					} else if (valor == 0){
						document.getElementById(\"cuerpoSistema".$a."OFF\").style.display=\"none\";
						document.getElementById(\"cuerpoSistema".$a."ON\").style.display=\"block\";
						document.getElementById(\"seguimientoSistema".$a."\").style.display=\"none\";
					}
				}
				</script> ";
			
				//Muestra el contenido de cada Sistema
				echo"<tr id='cuerpoSistema".$a."ON' style='display:block;' onclick='showSistemas".$a."(1);'>"; 
					echo"<td width='300' id='iconostexto' align='left'> ".$sistema." </td>";
					if($estatus != ''){
						echo"<td width='300' id='iconostexto' align='right'> ".$estatus." </td>";
					}/*if($estatus == ''){
						echo"<td width='300' id='iconostexto' align='right'>INACTIVO</td>";
					}*/
				echo"</tr>";
				
				//Oculta el contenido de cada Sistema
				echo"<tr id='cuerpoSistema".$a."OFF' style='display:none;' onclick='showSistemas".$a."(0);'>"; 
					echo"<td width='300' id='iconostexto' align='left'> ".$sistema." </td>";
					if($estatus != ''){
						echo"<td width='300' id='iconostexto' align='right'> ".$estatus." </td>";
					}/*if($estatus == ''){
						echo"<td width='300' id='iconostexto' align='right'>INACTIVO</td>";
					}*/
				echo"</tr>";

				
				//MUESTRA ACTIVOS O INACTIVOS DE LOS SISTEMAS
				echo"<tr>";
					echo"<td colspan='2' id='iconostexto'>";
						
					//Mostrar tabla
						echo"<table align='right' width='550' border='0' id='seguimientoSistema".$a."' style='display:none;'>";
							echo"<tr>"; 
								echo"<td id='iconosTexto4' width='100' align='center'>Tipo</td>";
								echo"<td id='iconosTexto4' width='100'  align='center'>Fecha</td>";
								echo"<td id='iconosTexto4' width='100'  align='center'>Solicitud</td>";
								echo"<td id='iconosTexto4' width='100'  align='center'>Estatus</td>";
								echo"<td id='iconosTexto4' width='50'  align='center'></td>";
								echo"<td>";
								?>
                                <td align="right"><a onclick="SINO('<?php echo $sistema ?>')"><img src='../../Imagenes/ICN_BotonMas.png' border='0' width="15" height="15"/></a></td>
                                <?php
								echo"<td>";
							echo"</tr>";
							
							echo"<tr>"; 
								echo"<td align='right' id='titleBlueLineTop' colspan='6'></td>";
							echo"</tr>";
							
							echo"<tr height='15'>";
							echo "</tr>";
							
							$i = 0;
							$u = $INTRANET->Execute("SELECT xt_tipo, xd_fecha, xt_codigoSolicitud FROM PERFILES.SOLICITUD_SISTEMAS WHERE xt_usuario = '$usuario' and xt_sistema = '$sistema'");
							while($t = $u->fetchRow()){
							
								$tipoRegistro = $t[0];
								$fechaRegistro = $t[1];
								$codigoRegistro = $t[2];				

							
								echo"<tr>"; 
									echo"<td id='iconosTexto5' width='100' name='tipoRegistro' align='center'>".$tipoRegistro."</td>";
									echo"<td id='iconosTexto5' width='100' align='center'>".$fechaRegistro."</td>";

									//echo"<td id='iconosTexto5' width='100' name='tipoRegistro' align='center'>".$fechaRegistro."</td>";
									//echo"<td id='iconosTexto5' width='100' align='center'>".$codigoRegistro."</td>";

									$tipoSolicitud = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM INTRANET2.SGI_Quejas_Solicitudesv2	 WHERE xt_quejaSolicitud = '$codigoRegistro'");	

									if($tipoSolicitud == 'AV'){
										$codigoID	= "<a href='../solicitudesBacklog/fichaSolicitudv2.php?coodigo=".$codigoRegistro."' id='iconosTexto5' style='text-decoration:none;' >".$codigoRegistro."</a>";
									echo"<td id='iconosTexto5' style='text-decoration:none;' width='137' align='center'>".$codigoID."</td>";

									}

									if($tipoSolicitud == 'AB'){
										$codigoID	= "<a href='../solicitudesBacklog/fichaAltaBajaUsuario.php?codigo=".$codigoRegistro."' id='iconosTexto5' style='text-decoration:none;' >".$codigoRegistro."</a>";
											echo"<td id='iconosTexto5' style='text-decoration:none;' width='137' align='center'>".$codigoID."</td>";										
									  }

									
									//$archivo = $INTRANET->getOne("SELECT xt_ruta FROM PERFILES.SOLICITUD_SISTEMAS WHERE xt_usuario = '$usuario' AND xt_tipo = '$tipoRegistro' AND xt_sistema ='$sistema' AND xt_codigoSolicitud = '$t[2]' ");
									//Se agrega Documento 

									if($t[0] == 'ALTA'){
										echo"<td width='100' align='center' id='iconosTexto5'>Activado</td>";
									
											/*echo"<td width='100' align='center' >";
												echo "<a class='enlaces' href='AgregarDocumentoPopUp.php?sistema=".$sistema."&usuario=".$usuario."&estatus=".$tipoRegistro."&codigo=".$codigoRegistro."' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\">Activar</a>";
										*/
										
									}else if($t[0] == 'BAJA' || $t[0] == 'BAJA_TOTAL'){
									
											echo"<td width='100' align='center' id='iconosTexto5'>Desactivado</td>";
											
										/*}else{
											echo"<td width='100' align='center'>";
												echo "<a class='enlaces' href='AgregarDocumentoPopUp.php?sistema=".$sistema."&usuario=".$usuario."&estatus=".$tipoRegistro."&codigo=".$codigoRegistro."' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\">Desactivar</a>";
										}*/
								
									}

									$i++;
								
									$archivoE = $INTRANET->getOne("SELECT EA.xt_ruta FROM IntranetGEA.SGI_Backlog_Solicitud_Sistemas_Temporal ST, BACKLOG.ENTREGABLES_ARCHIVOS EA 
									WHERE ST.xt_nombreUsuarioAlta = '$usuario' AND ST.xt_tipo = '$tipoRegistro' AND ST.xt_sistema = '$sistema' AND ST.xt_quejaSolicitud = '$codigoRegistro' AND ST.xt_codigoEntregable = EA.xt_codigoEntregable");
									
										if($archivoE != ''){
											
											 $nombreE = explode("/", $archivoE);
		
											echo"<td width='50' align='center'><a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctosReporte.php?nombreA=$nombreE[6]&ruta=$archivoE'>";
											echo "<img src='../../Imagenes/ICN_Archivo.png'></td>";
											
										}
						
							  echo"</tr>";
							}
							echo"</tr>";
								echo"<tr height='15'>";
							echo "</tr>";
							
							echo"<tr>";
								echo "<td colspan='4'>";
								//Muestra los campos para Alta o baja de usuario
									?>
									<div id="<?php echo $sistema ?>" style="display:none; text-align:center">
                                    <?php
									echo"<form action='fichaPersonal.php?ID=$IDpersonal' method='post'>";
										echo "<table border='0' align='center' width='95%' >";
										
											echo "<tr>";
												echo"<td id='iconosTexto4' width='37'>Tipo</td>";
												echo"<td width='100' align='left'>";
													echo "<select name='tipoSolicitud'>";
															echo"<option></option>";
															echo"<option value='ACTIVO'>ALTA</option>";
															echo"<option value='INACTIVO'>BAJA</option>";
													echo "</select>";
												echo "</td>";
											 echo "</tr>";
											 
											echo"<tr height='10'>";
											echo"</tr>";
											 
											echo "<tr>";
											echo"<td id='iconosTexto4' width='37'>Solicitud</td>";
											  echo"<td width='130' align='left' colspan='2'><input type='text' name='codigoSolicitud'><input type='hidden' name='sistema' value='$sistema'></td>";
										  echo "</tr>";
										  
										  echo"<tr height='15'>";
											  echo "<td colspan='5'></td>";
										  echo "</tr>";
										  
										  echo "<tr>";
												echo "<td colspan='6' align='right'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='70' height='19'></td>";
										  echo "</tr>";
										echo "</table>";
						
									echo"</form>";
									
								echo"<tr>"; 
								echo"<td align='right' id='titleBlueLineTop' colspan='6'></td>";
							echo"</tr>";
								
								echo"<tr height='30'>
									<td colspan='2'></td>";
								echo "</tr>";
									?>
									</div>
                                    <?php
								echo "</td>";
							echo"</tr>";
							
						echo"</table>";
					echo"<td>";
				echo"<tr>";
			}unset($r); unset($s);
		
			echo"<tr height='10'>";
				echo "<td colspan='2'></td>";
			echo "</tr>";
	
		 echo "</table>";
		 echo"</form>";
	
	
		
echo "</div>";
	
if(@$_POST['codigoSolicitud'] && @$_POST['tipoSolicitud'] != ''){
	
	$codigoSolicitud = $_POST['codigoSolicitud'];
	$tipoSolicitud 	= $_POST['tipoSolicitud'];
	$sistemaSolicitud = $_POST['sistema'];
	$fecha = date('Y-m-d');
	//$tipoRegistro  = $_POST['tipoRegistro'];
	
	if($tipoSolicitud == 'ACTIVO'){
		
		$INTRANET->Execute("INSERT INTO PERFILES.SOLICITUD_SISTEMAS (xt_usuario,xt_sistema,xt_tipo,xt_codigoSolicitud, xd_fecha) VALUES ('$usuario','$sistemaSolicitud','ALTA','$codigoSolicitud','$fecha')");
		
		$INTRANET->Execute("INSERT INTO PERFILES.SISTEMAS (xt_usuario,xt_sistema,xt_estatus) VALUES ('$usuario','$sistemaSolicitud','ACTIVO')");
		//new MailAltaUsuario($tipoSolicitud, $usuario, $sistemaSolicitud,$nombreCompleto,$correo,$puesto);
		
	}else if ($tipoSolicitud == 'INACTIVO'){
		
		$INTRANET->Execute("INSERT INTO PERFILES.SOLICITUD_SISTEMAS (xt_usuario,xt_sistema,xt_tipo,xt_codigoSolicitud, xd_fecha) VALUES ('$usuario','$sistemaSolicitud','BAJA','$codigoSolicitud','$fecha')");
	
		$INTRANET->Execute("UPDATE PERFILES.SISTEMAS SET xt_estatus = 'INACTIVO' WHERE xt_usuario = '$usuario' AND xt_sistema = '$sistemaSolicitud'");
		//new MailAltaUsuario($tipoSolicitud, $usuario, $sistemaSolicitud,$nombreCompleto);
		
	}
		
	echo"<script language='javascript'>window.location='fichaPersonal.php?ID=$IDpersonal'</script>;";
}
	
	
//SECCION DE EXPEDIENTE DE PERSONAL
/*	
$accesoExpediente = $INTRANET->getOne("Select xt_usuario FROM SGI_USUARIOS_ACCESO_EXPEDIENTE_PERSONAL WHERE xt_usuario = '$usuarioId'");
	
if($accesoExpediente != ""){
	
	
	
	echo "<table border='0' align='center' width='600'>";
	
		echo "<tr>";
			echo "<td id='titulo2'>Expediente de personal</td>";
	
			 echo "<td style='width:1%'>";

				?>
				<a href="seleccionExpedientePopUp.php?empleado=<?php echo $usuario;?>&idEmpleado=<?php echo $IDpersonal;?>" target="popup" onclick="window.open(this.href,this.target,'width=430,height=560'); return false;"><img src= "../../Imagenes/ICN_BotonMas.png"  width="15" height="15"/></a>
				<?php	

			echo "</td>";
			
		echo "</tr>";
	
	echo "</table>";
	
	echo "<table border='0' align='center' width='600'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='600px'></td>";
		echo "</tr>";
	
		echo "<tr height='10px'></tr>";
	echo "</table>";
	
	//listo los tipos de documentos con los documentos existentes
	echo "<div id='seccionExpediente'>";
	
		$s = $INTRANET->Execute("SELECT DISTINCT xt_tipo_expediente FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado ='$usuario'");
		$indexTotalDoc = 0;
		$trPos = 0;
		while($row = $s->fetchRow()){
			
			echo "<table border='0' align='center' width='600'>";
				$trPos ++;
				$trPosF = "trFile".$trPos;
				echo "<tr height='7px'></tr>";
				echo "<tr class='trTipoD' style='width:70%'>";
					echo "<td style='width:5%'> </td>";

					echo "<td id='iconosTexto2' width='70%' height='5px'>";
						echo "<input type='hidden' name='tipoDoc' id='tipoDoc' value='$row[0]'>";
						echo "<b> $row[0] </b>";
						echo "<br>";
					echo "</td>";

					echo "<td style='width:130%'> </td>";
					
					echo "<td align='right'>";
					
					?>
					<a onClick="activaFile('<?php echo $trPosF; ?>')" style="cursor:pointer;"><img  src="../../Imagenes/ICN_BotonMas.png"" width="10" height="10"/></a>
					<?php	
			
					echo "<td>";
			
				echo "</tr>";
			
				echo "<tr height='.3px'>";
			
          			echo "<td></td>";
					echo "<td colspan='7' id='titleBlueLineBottom'></td>";
			
          		echo "</tr>";
			
				echo "<tr height='7px'></tr>";
			
			
				$x = $INTRANET->Execute("select xt_nombre_archivo FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado = '$usuario' and xt_tipo_expediente = '$row[0]'");
			
				$numDoc = 0;
				while($rowss = $x->fetchRow()){
			
					if($rowss[0] != ""){
						
						echo "<table border='0' align='center' width='600'>";
							echo "<tr class='trDoctos'>";
								echo "<td> </td>";


								echo "<td style='font-size: 11px;padding:0px 0px 0px 30px;'>";
									echo $rowss[0];
									$numDoc ++;
								echo "</td>";


								echo "<td width='130%'> </td>";

								$carpetaEmpleado = $numeroEmpleado."_".$usuario;
								//img de descarga
								echo "<td>";
									echo "<a href='extraeExpediente.php?empleado=$usuario&descargaArchivo=$rowss[0]&carpetaEmpleado=$carpetaEmpleado&usuarioVisualiza=$usuarioId&eventoVisualiza=visualizaArchivo&tipoArchivo=$row[0]'><img src='../../Imagenes/ICN_Archivo.png' height='15px' width='12px' /></a>";
								echo "</td>";

								echo "<td></td>";

								//img de eliminar
								echo "<td>";
									echo "<a href='eliminaExpediente.php?empleado=$usuario&eliminaArchivo=$rowss[0]&carpetaEmpleado=$carpetaEmpleado&usuarioElimina=$usuarioId&tipoArchivo=$row[0]&idPersonal=$IDpersonal'><img src='../../Imagenes/ICN_NoOK.png' height='13px' width='13px'/></a>";
								echo "</td>";


								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";

							echo "</tr>";
						echo "</table>";
					}
			
				}
			
				echo "<tr height='20px'></tr>";
			
			echo "</table>";
			//fin segundo while
			
			//fila del formulario para subir archivo
			echo "<table border='0' align='center' width='600'>";
			
				echo "<tr id='$trPosF' style='display: none'>";
				echo "<td></td>";
					echo "<td>";
						echo "<div id='divFile'>
						<form action='fichaPersonal.php?ID=$IDpersonal' method='post' enctype='multipart/form-data'>
						<fieldset style='width:40%'>
							<input type='hidden' name='usuarioEmpleado' value='$usuario'>
							<input type='hidden' name='tipoA' value='$row[0]'>
							<input type='hidden' name='evento' value='cargaArchivoExpediente'>
							<input type='file' name='archivo[]' id='archivo' multiple></input>
							<div align='right'><input type='submit' name='subir' value='Enviar'></input></div>
						</fieldset>
						</form> </div>";

					echo"</td>";

				echo "</tr>";
			
			echo "</table>";
			
		}
	
	echo "</div>";
	
	
}
*/
	
	//RESGUARDO
	echo "<table border='0' align='center' width='600'>";
		echo"<tr>";
			echo"<td id='titulo2'>Resguardo</td>";
			echo "<td></td>";
			echo"<td id='titulo2'></td>";
			echo"<td></td>";
			//if (($usuarioId == 'Elionay_Aldana') || ($usuarioId == 'Pedro_Moyotl') || ($usuarioId == 'cozy') || ($usuarioId == 'Fernando_Garcia') || ($usuarioId == 'Francisco_Perez') || ($usuarioId == 'sdelap')|| ($usuarioId == 'Marlene_Avelino')|| ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Guillermo_Quezada' || $usuarioId == 'Carlos_Jimenez')){
				echo"<td style='display:flex; justify-content: end;'>";
					//echo "<a href='https://localhost:2053/Sistemas/Intranet/Resguardo/SolicitudResguardo?usuario=".$usuario."' onclick=\"window.open(this.href,this.target,'width=700,height=600,scrollbars=yes'); return false;\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block; padding-right:.5em;'></a>";
					echo "<a href='https://react.escalante.com.mx:2053/Sistemas/Intranet/Resguardo/SolicitudResguardo?usuario=".$usuario."' onclick=\"window.open(this.href,this.target,'width=700,height=600,scrollbars=yes'); return false;\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block; padding-right:.5em;'></a>";
					//echo "<a href='asignaResguardoUsuario.php?usuario=".$usuario."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=600,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block; padding-right:.5em;'></a>";
					//echo "<a href='entregaResguardoUsuario.php?usuario=".$usuario."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=600,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMenos.png' height='15' width='15' onclick='show(0);' id='ocultar' style='display:block;'></a>";	
				echo"</td>";
			//}
		echo"</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineTop' align='right' colspan='5'> </td>";
		echo "</tr>";

		echo"<tr height='20'>
			<td colspan='5'></td>";
		echo "</tr>";

		echo"<tr height='50'>
			<td>ITEM</td>
			<td align='center'>SOLICITUD</td>
			<td align='center'>RECEPCIÓN</td>
			<td align='center'>DEVOLUCIÓN</td>
			<td align='center'>ACEPTACIÓN</td>
			<td align='center'></td>";
		echo "</tr>";

		$articulosUsuario = $INTRANETV2->getArray("select * FROM sgi_resguardo_articulos WHERE xt_usuario = '$usuario' order by xt_articulo");
		//var_dump($arcticulosUsuario);
		foreach($articulosUsuario as $registro){
			echo"<tr height='30'>";
				echo"<td><a href='fichaArticuloResguardo.php?articuloId=".$registro["xn_index"]."&tipoMovimiento=Resumen' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=800,scrollbars=yes')\">".$registro["xt_articulo"]."</a></td>";
				echo $registro['xd_fechaAsignacion'] != '' ? "<td align='center'>".$registro['xd_fechaAsignacion']."</td>" : "<td align='center'><a href='fichaArticuloResguardo.php?articuloId=".$registro["xn_index"]."&tipoMovimiento=Recepción' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=800,scrollbars=yes')\"><img src='../../img/boton1.png' height='15' width='15'></a></td>";
				echo $registro['xd_fechaRecepcion'] != '' ? "<td align='center'>".$registro['xd_fechaRecepcion']."</td>" : "<td align='center'><a href='fichaArticuloResguardo.php?articuloId=".$registro["xn_index"]."&tipoMovimiento=Recepción' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=800,scrollbars=yes')\"><img src='../../img/boton1.png' height='15' width='15'></a></td>";
				echo $registro['xd_fechaEntrega'] != '' ? "<td align='center'>".$registro['xd_fechaEntrega']."</td>" : "<td align='center'><a href='fichaArticuloResguardo.php?articuloId=".$registro["xn_index"]."&tipoMovimiento=Devolución' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=800,scrollbars=yes')\"><img src='../../img/boton1.png' height='15' width='15'></td>";
				echo $registro['xd_fechaAceptacion'] != '' ? "<td align='center'>".$registro['xd_fechaAceptacion']."</td>" : "<td align='center'><a href='fichaArticuloResguardo.php?articuloId=".$registro["xn_index"]."&tipoMovimiento=Aceptación' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=800,scrollbars=yes')\"><img src='../../img/boton1.png' height='15' width='15'></td>";
				echo "<td align='center'><img src='../../Imagenes/ICN_BotonBasura.png' height='15' width='15' onclick=\"confirmDelete('".$registro['xn_index']."')\"></td>";
			echo "</tr>";
		}

		$llavesUsuario = $INTRANETV2->getArray("select * FROM sgi_control_llaves WHERE xt_usuario = '$usuario' order by xt_numeroLlave");
		//var_dump($llavesUsuario);
		foreach($llavesUsuario as $registro){
			echo"<tr height='30'>
				<td><a href='../../SistemaGestionIntegral/ControlLlaves/fichaLlave.php?numeroLlave=".$registro["xt_numeroLlave"]."&usuario=".$usuario."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=800,scrollbars=yes')\">LLAVE ".$registro["xt_numeroLlave"]."</a></td>
				<td align='center'></td>
				<td align='center'>".$registro["xd_fecha"]."</td>
				<td align='center'></td>
				<td align='center'><td>
				<td align='center'><td>";
			echo "</tr>";
		}
	echo "</table>";


	//FIN SECCION EXPEDIENTE PERSONAL

	echo "<table border='0' align='center' width='700px'>";
	
		echo "<tr height='20px'><td> </td></tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='700px'></td>";
		echo "</tr>";
		//imprime Ficha del personal
		if (($usuarioId == 'Norma_Tapia') || ($usuarioId == 'Francisco_Perez') || ($usuarioId == 'Jesus_PerezS') || ($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Pedro_Moyotl') || ($usuarioId == 'Saday_Hernandez') || ($usuarioId == 'cozy')|| ($usuarioId == 'sdelap')|| ($usuarioId == 'Marlene_Avelino')|| ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Guillermo_Quezada')  || ($usuarioId == 'Denisse_Valladares') && $estatus=='INACTIVO'){
			echo "<tr>";
				echo "<td align='center' id='breadcrumbs' width='700px'><i><a href='imprimeFicha_PersonalPDF.php?ID=$IDpersonal&nombre=$usuario' id='breadcrumbs'> Imprimir </a></i></td>";
			echo "</tr>";
		}
		echo "<tr height='50px'><td> </td></tr>";
		
	echo "</table>";

?>
</body>
</html>
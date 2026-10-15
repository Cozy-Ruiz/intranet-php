<?PHP
$nombrephp="fichaPersonal.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
//require_once("MailAltaUsuario.php");

error_reporting(E_PARSE);

//echo $usuarioId;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Revisión RH</title>
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
				// Función para abrir el modal y cargar el contenido dinámico
				function openModal(usuario, tipoDocumento, rutaDocumento, fechaActualizacionFoto) {
					// Selecciona el modal por ID
					var modal = document.getElementById("myModal");
					
					// Muestra el modal
					modal.style.display = "block";

					// Aquí puedes cargar el contenido dinámicamente en el modal
					var modalTitle = document.getElementById("modalTitle");
					modalTitle.innerHTML = tipoDocumento;
					
					// Aquí puedes cargar el contenido dinámicamente en el modal
					var modalContent = document.getElementById("modalContent");
					var modalButton = document.getElementById("modalButton");

					if(tipoDocumento == "Foto personal"){
						modalContent.innerHTML = "<div style='display:flex; justify-content:center;'><iframe src='" + rutaDocumento + "' width='300' height='400' style='border: none;'></iframe></div><div style='display:flex; justify-content:center; padding:20px;'>" + fechaActualizacionFoto + "</div>";
						modalButton.innerHTML = "<td><button onClick='rechazaFoto(\"" + usuario + "\")' style='background-color: red; width: 100px; height: 31px;'>Rechazar</button></td>";
					}else{
						modalContent.innerHTML = "<iframe src='" + rutaDocumento + "' width='600' height='400' style='border: none;'></iframe>";
						modalButton.innerHTML = "<td><button onClick='rechazaDocumento(\"" + usuario + "\", \"" + tipoDocumento + "\")' style='background-color: red; width: 100px; height: 31px;'>Rechazar</button></td><td><button onClick='aceptaDocumento(\"" + usuario + "\", \"" + tipoDocumento + "\")' style='background-color: lawngreen; width: 100px; height: 31px;'>Aceptar</button><td>";
					}
				}

				// Función para cerrar el modal
				function closeModal() {
					var modal = document.getElementById("myModal");
					modal.style.display = "none";
				}

				// Cierra el modal si el usuario hace clic fuera del modal
				window.onclick = function(event) {
					var modal = document.getElementById("myModal");
					if (event.target == modal) {
						modal.style.display = "none";
					}
				}

				function aceptaDocumento(usuario, tipoArchivo){
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
					xhttp.send("evento=aceptaDocumento&usuario="+usuario+"&tipoArchivo="+tipoArchivo);
				}

				function rechazaDocumento(usuario, tipoArchivo){
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
					xhttp.send("evento=rechazaDocumento&usuario="+usuario+"&tipoArchivo="+tipoArchivo);
				}

				function rechazaFoto(usuario){
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
					xhttp.send("evento=rechazaFoto&usuario="+usuario);
				}
			</script>

			<script>
				let stream;

				async function openModalCamara(usuario, nombreEmpleado) {
					const modal = document.getElementById('cameraModal');
					const nombreUsuario = document.getElementById('nombreUsuarioFoto');
					const usuarioFoto = document.getElementById('usuarioFoto');
					const video = document.getElementById('video');

					nombreUsuario.innerHTML = nombreEmpleado;
					usuarioFoto.innerHTML = usuario;
					modal.style.display = 'flex';
					
					try {
						stream = await navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 768 } });
						video.srcObject = stream;
					} catch (err) {
						alert('No se pudo acceder a la cámara: ' + err);
					}
				}

				function closeModalCamara(){
					const modal = document.getElementById('cameraModal');
					modal.style.display = 'none';
					if (stream) {
					stream.getTracks().forEach(track => track.stop());
					}
					const video = document.getElementById('video');
					const canvas = document.getElementById('canvas');
					const recapture = document.getElementById('recapture');
					const saveBtn = document.getElementById('savePhoto');
					const capture = document.getElementById('capture');
					video.style.display = 'block';
					canvas.style.display = 'none';
					recapture.style.display = 'none';
					saveBtn.style.display = 'none';
					capture.style.display = 'block';
				}

				function capturePhoto() {
					const video = document.getElementById('video');
					const capture = document.getElementById('capture');
					const recapture = document.getElementById('recapture');
					const saveBtn = document.getElementById('savePhoto');
					const canvas = document.getElementById('canvas');

					// Dimensiones reales del video
					const width = video.videoWidth;
					const height = video.videoHeight;

					// Queremos un formato más vertical, por ejemplo 3:4
					const targetAspect = 3 / 4; // ancho / alto deseado
					let newWidth = height * targetAspect; // nuevo ancho en base al alto del video

					// Si el nuevo ancho es mayor que el original, reducimos proporcionalmente
					if (newWidth > width) newWidth = width;

					// Calcular cuánto cortar de los lados
					const cropX = (width - newWidth) / 2;

					// Ajustar el canvas al nuevo tamaño
					canvas.width = newWidth;
					canvas.height = height;

					const ctx = canvas.getContext('2d');

					// Dibujar solo la parte central (recortando orillas)
					ctx.drawImage(video, cropX, 0, newWidth, height, 0, 0, newWidth, height);

					// Cambiar visibilidad de los elementos
					video.style.display = 'none';
					capture.style.display = 'none';
					recapture.style.display = 'inline-block';
					saveBtn.style.display = 'inline-block';
					canvas.style.display = 'block';
				}

				function reCapturePhoto(){
					const video = document.getElementById('video');
					const capture = document.getElementById('capture');
					const recapture = document.getElementById('recapture');
					const canvas = document.getElementById('canvas');
					const saveBtn = document.getElementById('savePhoto');

					video.style.display = 'block';
					capture.style.display = 'block';
					recapture.style.display = 'none';
					canvas.style.display = 'none';
					saveBtn.style.display = 'none';
				}

				async function savePhoto() {
					const canvas = document.getElementById('canvas');
					const usuario = document.getElementById('usuarioFoto').textContent; // 📌 obtenemos el usuario
					const photo = canvas.toDataURL('image/png');

					try {
						const response = await fetch('save_photo.php', {
							method: 'POST',
							headers: { 'Content-Type': 'application/json' },
							body: JSON.stringify({ usuario: usuario, image: photo })
						});

						const result = await response.text();
						alert(result);

						location.reload();

						// Opcional: cerrar modal al terminar
						closeModalCamara();

					} catch (err) {
						alert('Error al guardar la foto: ' + err);
					}
				}
			</script>

			<style>
				/* 🔹 Fondo del modal */
				#cameraModal {
					display: none;
					position: fixed;
					top: 0; left: 0;
					width: 100%; height: 100%;
					background: rgba(0, 0, 0, 0.7);
					justify-content: center; align-items: center;
					z-index: 1000;
				}

				/* 🔹 Contenedor central del modal */
				 #modalContentCamera {
					background: #fff;
					padding: 20px 25px;
					border-radius: 12px;
					text-align: center;
					width: 360px;
					box-shadow: 0 5px 15px rgba(0,0,0,0.3);
				} 

				/* 🔹 Estilos de video y canvas */
				video, canvas {
					width: 100%;
					border-radius: 10px;
					background: #000;
				}

				/* 🔹 Contenedor flexible para botones */
				.button-group {
					display: flex;
					flex-wrap: wrap;
					justify-content: center;
					gap: 10px;
					margin-top: 15px;
				}

				
				/* 🔹 Botones */
				 button {
					padding: 8px 14px;
					border: none;
					border-radius: 6px;
					background: #007bff;
					color: white;
					font-size: 14px;
					cursor: pointer;
					transition: background 0.2s;
				}

				button:hover {
					background: #0056b3;
				}
				
				#savePhoto { background: #28a745; }
				#savePhoto:hover { background: #1e7e34; }

				#closeModalCamara { background: #dc3545; }
				#closeModalCamara:hover { background: #b52a37; }
			</style>

			<style>
				.enlaces { 
				FONT-SIZE: 11px; 
				font-family:Lucida Sans;
				font-size:12px;
				color:#007cbd; 
				TEXT-DECORATION: none 
				}

				/* El fondo gris oscuro que cubre la página cuando el modal está visible */
				.modal {
					display: none;  /* Ocultarlo por defecto */
					position: fixed; /* Posición fija para que se quede en la misma posición cuando se haga scroll */
					z-index: 1; /* Asegurarse de que el modal esté encima del contenido */
					left: 0;
					top: 0;
					width: 100%;  /* Ancho completo */
					height: 100%; /* Alto completo */
					background-color: rgba(0, 0, 0, 0.4); /* Fondo semi-transparente */
					padding-top: 60px; /* Espacio desde la parte superior */
					color: black;
				}

				/* Modal Contenido */
				.modal-content {
					background-color: #fff;
					margin: 5% auto;
					padding: 20px;
					border: 1px solid #888;
					width: 80%;
					max-width: 600px;
				}



				/* Botón para cerrar el modal */
				.close {
					color: #aaa;
					float: right;
					font-size: 28px;
					font-weight: bold;
				}

				.close:hover,
				.close:focus {
					color: black;
					text-decoration: none;
					cursor: pointer;
				}
			</style>
  	 
	</head>

<body>
<?PHP

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a>";


$ciudades = ["'AICM', 'CDMX', 'CMX', 'DF'", "'CUN'", "'NLR', 'NLRD'", "'TOL'", "'VER'"];

if($_REQUEST["ciudad"]){
	$ciudades = [$_REQUEST["ciudad"]];
}

$fechaInicioVisualizadorDocumentos = '2025-01-13';

for($i=0; $i<count($ciudades); $i++){
	$empleados[$i] = $INTRANET->getArray("
		SELECT
			e.*,
			YEAR ( e.xd_fechaActualizacionDatos ) AS yearActualizacionDatos,
			YEAR (u.xd_fechaActualizacionFoto) AS yearActualizacionFoto,
			YEAR (e.xd_aceptacionCartaCompromiso) AS yearAceptacionCartaCompromiso,
			YEAR (e.xd_aceptacionPerfilPuesto) AS yearAceptacionPerfilPuesto,
			u.xd_fechaActualizacionFoto 
		FROM
			SGI_Empleados e,
			perfiles.usuarios u,
			perfiles.sistemas s
		WHERE
			e.xt_tipo = 'E' 
			AND e.xt_Estatus = 1 
			AND e.xt_ciudad IN (".$ciudades[$i].") 
			AND u.xt_usuario = e.kf_usuario
			AND s.xt_usuario = u.xt_usuario
			AND s.xt_sistema = 'INTRANET'
			AND s.xt_estatus = 'ACTIVO'
		ORDER BY
			e.xt_Nombre,
			e.xt_ApellidoPaterno,
			e.xt_apellidoMaterno
	");
	
	for($j=0; $j<count($empleados[$i]); $j++){
		$documentosNuevos = $INTRANETV2->getArray("
			SELECT
				md.xt_codigoDocumento,
				md.xt_nombre,
				md.xd_fechaCreacion as xd_fecha
			FROM
				sgi_manuales_documentos md
			WHERE
				md.xd_fechaCreacion > '".$fechaInicioVisualizadorDocumentos."'
				AND md.xt_codigoDocumento NOT IN (SELECT ccd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos ccd WHERE ccd.xt_codigoDocumento	= md.xt_codigoDocumento)
				AND md.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$empleados[$i][$j]["kf_usuario"]."' AND cvd.xt_codigoDocumento = md.xt_codigoDocumento AND cvd.xn_version = 0)
		");
			
		$documentosActualizados = $INTRANETV2->getArray("
			SELECT
				ccd.xt_codigoDocumento,
				md.xt_nombre,
				ccd.xn_version,
				ccd.xd_fechaCambio as xd_fecha
			FROM
				sgi_control_de_cambios_documentos ccd,
				sgi_manuales_documentos md
			WHERE
				ccd.xn_version > 0 
				AND ccd.xd_fechaCambio > '".$fechaInicioVisualizadorDocumentos."'
				AND md.xt_codigoDocumento = ccd.xt_codigoDocumento
				AND ccd.xt_codigoDocumento NOT IN (SELECT cvd.xt_codigoDocumento FROM sgi_control_de_cambios_documentos_copy1 cvd WHERE cvd.xt_usuario = '".$empleados[$i][$j]["kf_usuario"]."' AND cvd.xt_codigoDocumento = ccd.xt_codigoDocumento AND cvd.xn_version = ccd.xn_version)
		");

		if( (count($documentosNuevos) + count($documentosActualizados)) > 0){
			$empleados[$i][$j]["estatusVisualizacionDocumentos"] = "<img src='../../Imagenes/ICN_BotonRojo.png'>";
		}else{
			$empleados[$i][$j]["estatusVisualizacionDocumentos"] = "<img src='../../Imagenes/ICN_BotonVerde.png'>";
		}

		$expedientesActualizados = $INTRANET->getArray("SELECT * FROM sgi_expediente_personal WHERE xt_usuario_empleado = '".$empleados[$i][$j]["kf_usuario"]."' AND YEAR(xd_fecha) = YEAR(NOW()) ORDER BY xd_fecha DESC");
		//var_dump($expedientesActualizados);
		
		if(is_numeric($indiceIdentificacion = array_search( "Identificación Personal", array_column($expedientesActualizados, 'xt_tipo_expediente') ))){
			if($expedientesActualizados[$indiceIdentificacion]["xt_estatus"] == "Aceptado"){
				$empleados[$i][$j]["estatusIdentificacion"] = "<img src='../../Imagenes/ICN_BotonVerde.png' onclick=\"openModal('".$empleados[$i][$j]["kf_usuario"]."', 'Identificación Personal', '".$expedientesActualizados[$indiceIdentificacion]["xt_ruta_archivo"]."', '')\")'>";
			}else if($expedientesActualizados[$indiceIdentificacion]["xt_estatus"] == "Rechazado"){
				$empleados[$i][$j]["estatusIdentificacion"] = "<img src='../../Imagenes/ICN_BotonNaranja.png' width='15' height='15' onclick=\"openModal('".$empleados[$i][$j]["kf_usuario"]."', 'Identificación Personal', '".$expedientesActualizados[$indiceIdentificacion]["xt_ruta_archivo"]."', '')\")'>";
			}else{
				$empleados[$i][$j]["estatusIdentificacion"] = "<img src='../../Imagenes/ICN_BotonAmarillo.png' onclick=\"openModal('".$empleados[$i][$j]["kf_usuario"]."', 'Identificación Personal', '".$expedientesActualizados[$indiceIdentificacion]["xt_ruta_archivo"]."', '')\")'>";
			}
		}else{
			$empleados[$i][$j]["estatusIdentificacion"] = "<img src='../../Imagenes/ICN_BotonRojo.png'>";
		} 
		
		if(is_numeric($indiceComprobante = array_search( "Comprobante de domicilio", array_column($expedientesActualizados, 'xt_tipo_expediente') ))){
			if($expedientesActualizados[$indiceComprobante]["xt_estatus"] == "Aceptado"){
				$empleados[$i][$j]["estatusComprobanteDomicilio"] = "<img src='../../Imagenes/ICN_BotonVerde.png' onclick=\"openModal('".$empleados[$i][$j]["kf_usuario"]."', 'Comprobante de domicilio', '".$expedientesActualizados[$indiceComprobante]["xt_ruta_archivo"]."', '')\">";
			}else if($expedientesActualizados[$indiceComprobante]["xt_estatus"] == "Rechazado"){
				$empleados[$i][$j]["estatusComprobanteDomicilio"] = "<img src='../../Imagenes/ICN_BotonNaranja.png' width='15' height='15' onclick=\"openModal('".$empleados[$i][$j]["kf_usuario"]."', 'Comprobante de domicilio', '".$expedientesActualizados[$indiceComprobante]["xt_ruta_archivo"]."', '')\">";
			}else{
				$empleados[$i][$j]["estatusComprobanteDomicilio"] = "<img src='../../Imagenes/ICN_BotonAmarillo.png' onclick=\"openModal('".$empleados[$i][$j]["kf_usuario"]."', 'Comprobante de domicilio', '".$expedientesActualizados[$indiceComprobante]["xt_ruta_archivo"]."', '')\">";
			}
		}else{
			$empleados[$i][$j]["estatusComprobanteDomicilio"] = "<img src='../../Imagenes/ICN_BotonRojo.png'>";
		} 

		if($empleados[$i][$j]["yearActualizacionDatos"] == date('Y')){
			if($empleados[$i][$j]["xt_estatusDatosPersonales"] == "Rechazado"){
				$empleados[$i][$j]["estatusDatosActualizados"] = "<img src='../../Imagenes/ICN_BotonNaranja.png' width='15' height='15'>";
			}else{
				$empleados[$i][$j]["estatusDatosActualizados"] = "<img src='../../Imagenes/ICN_BotonVerde.png'>";
			}
		}else{
			$empleados[$i][$j]["estatusDatosActualizados"] = "<img src='../../Imagenes/ICN_BotonRojo.png'>";
		}

		if($empleados[$i][$j]["yearActualizacionFoto"] == date('Y')){
			$empleados[$i][$j]["estatusFotoActualizada"] = "<img src='../../Imagenes/ICN_BotonVerde.png' onclick=\"openModal('".$empleados[$i][$j]["kf_usuario"]."', 'Foto personal', '".$empleados[$i][$j]["xn_Foto"]."', '".$empleados[$i][$j]["xd_fechaActualizacionFoto"]."')\")'>";
		}else{
			$empleados[$i][$j]["estatusFotoActualizada"] = "<button onclick=\"openModalCamara('".$empleados[$i][$j]["kf_usuario"]."', '".$empleados[$i][$j]['xt_Nombre']." ".$empleados[$i][$j]['xt_ApellidoPaterno']." ".$empleados[$i][$j]['xt_ApellidoMaterno']."')\" style='background: none; border: none;'><img src='../../Imagenes/ICN_BotonRojo.png'></button>";
		}
		
		if($empleados[$i][$j]["yearAceptacionCartaCompromiso"] == date('Y')){
			$empleados[$i][$j]["estatusCartaCompromiso"] = "<img src='../../Imagenes/ICN_BotonVerde.png'>";
		}else{
			$empleados[$i][$j]["estatusCartaCompromiso"] = "<img src='../../Imagenes/ICN_BotonRojo.png'>";
		}

		if($empleados[$i][$j]["yearAceptacionPerfilPuesto"] == date('Y')){
			$empleados[$i][$j]["estatusPerfilPuesto"] = "<img src='../../Imagenes/ICN_BotonVerde.png'>";
		}else{
			$empleados[$i][$j]["estatusPerfilPuesto"] = "<img src='../../Imagenes/ICN_BotonRojo.png'>";
		}

		$itemsResguardo = $INTRANET->getArray("SELECT xt_articulo FROM intranet2.sgi_resguardo_articulos WHERE xt_usuario = '".$empleados[$i][$j]["kf_usuario"]."' ");

		if( count($itemsResguardo) > 0){
			$empleados[$i][$j]["estatusResguardo"] = "<img src='../../Imagenes/ICN_BotonVerde.png'>";
		}else{
			$empleados[$i][$j]["estatusResguardo"] = "<img src='../../Imagenes/ICN_BotonRojo.png'>";
		}
		
		//echo $empleados[$i][$j]["kf_usuario"]."-".array_search( "INE", array_column($expedientesActualizados, 'xt_tipo_expediente') )."-".array_search( "Comprobante de domicilio", array_column($expedientesActualizados, 'xt_tipo_expediente') )."<br>";
		//echo $empleados[$i][$j]["kf_usuario"]."-".$expedientesActualizados[$indiceIdentificacion]["xt_ruta_archivo"]."-".$expedientesActualizados[$indiceComprobante]["xt_ruta_archivo"]."<br>";
		//echo $empleados[$i][$j]["kf_usuario"]."-".$indiceIdentificacion."-".$indiceComprobante."<br>";
		 
	}
	
}

echo"<div id='wrapperFicha' align='center'>";

	echo "<table border='0' align='center' name='Encabezado'>";		
		echo"<tr height='80px'> </tr>";
		///Titulo Ficha
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='700px'>";
				echo "Revisión Recursos Humanos";
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
		
	
	echo "<table border='0' align='center'>";
		echo"<tr height='40'><td align='center'>Oficina</td></tr>";
		echo "<form action='revisionRH.php'>";
		echo"<tr align='center' height='40'>";
			echo "<td>";
			
				echo "<select name='ciudad' method='post'>";
					echo "<option value=''>Selecciona ciudad</option>";
					echo "<option value=\"'AICM', 'CDMX', 'CMX', 'DF'\">CDMX</option>";
					echo "<option value=\"'CUN'\">CUN</option>";
					echo "<option value=\"'LAR', 'LR', 'LRD', 'NLR', 'LRND'\">NLRD</option>";
					echo "<option value=\"'TOL'\">TOL</option>";
					echo "<option value=\"'VER'\">VER</option>";
				echo "</select>";
				
			echo"</td>";
		echo "</tr>";
		echo"<tr align='center' height='40'><td><input type='submit'></td></tr>";
		echo "</form>";
	echo "</table>";



	echo "<table border='0' align='center'>";
		echo"<tr align='center' height='40'>";
			echo "<td>";
				echo"<td align='right'><a href='reporteRevisionRH.php'><img src='../../Imagenes/ICN_CargaDocumento.png'></a></td>";
			echo"</td>";
		echo "</tr>";
	echo "</table>";



	for($i=0; $i<count($ciudades); $i++){
		
		echo "<table border='0' align='center' width='600'>";
			echo"<tr height='30px'> </tr>";
			
			echo"<tr>";
				echo"<td id='titulo2'>".$ciudades[$i]."</td>";
				echo"<td align='right'><a href=\"reporteRevisionRH.php?aduana=".$ciudades[$i]."\"><img src='../../Imagenes/ICN_CargaDocumento.png'></a></td>";
			echo"</tr>";
			
		///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";

			echo"<tr>";
				echo "<table border=1 width='550'>";
					if($usuarioId != "Francisco_Perez" && $usuarioId != "Jesus_PerezS" && $usuarioId != "Norma_Tapia"){
						echo "<tr>";
							echo "<td>Nombre</td>";
							echo "<td align='center'>Datos Actualizados</td>";
							echo "<td align='center'>Identificación Personal</td>";
							echo "<td align='center'>Comprobante de domicilio</td>";
							echo "<td align='center'>Visualizacion Documentos</td>";
							echo "<td align='center'>Fotografía</td>";
							echo "<td align='center'>Carta Compromiso SGI</td>";
							echo "<td align='center'>Resguardo</td>";
							echo "<td align='center'>Perfil Puesto</td>";
						echo "</tr>";
					}else{
						echo "<tr>";
							echo "<td>Nombre</td>";
							echo "<td align='center'>Resguardo</td>";
						echo "</tr>";
					}
					

					foreach($empleados[$i] as $empleado){

						if($usuarioId != "Francisco_Perez" && $usuarioId != "Jesus_PerezS" && $usuarioId != "Norma_Tapia"){
							echo "<tr>";
								echo "<td>".$empleado['xt_Nombre']." ".$empleado['xt_ApellidoPaterno']." ".$empleado['xt_ApellidoMaterno']."</td>";
								echo "<td align='center'><a href='datosPersonal.php?usuario=".$empleado['kf_usuario']."' target='_blank'>".$empleado["estatusDatosActualizados"]."</a></td>";
								echo "<td align='center'>".$empleado["estatusIdentificacion"]."</td>";
								echo "<td align='center'>".$empleado["estatusComprobanteDomicilio"]."</td>";
								echo "<td align='center'><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/controlVisualizacionDocumentos.php?usuario=".$empleado['kf_usuario']."' target='_blank'>".$empleado["estatusVisualizacionDocumentos"]."</a></td>";
								echo "<td align='center'>".$empleado["estatusFotoActualizada"]."</td>";
								echo "<td align='center'><a href='cartaCompromiso.php?usuario=".$empleado['kf_usuario']."' target='_blank'>".$empleado["estatusCartaCompromiso"]."</a></td>";
								echo "<td align='center'><a href='fichaPersonal.php?ID=".$empleado['kp_personalId']."' target='_blank'>".$empleado["estatusResguardo"]."</a></td>";
								echo "<td align='center'><a href='perfilPuesto.php?usuario=".$empleado['kf_usuario']."' target='_blank'>".$empleado["estatusPerfilPuesto"]."</a></td>";
							echo "</tr>";
						}else{
							echo "<tr>";
								echo "<td>".$empleado['xt_Nombre']." ".$empleado['xt_ApellidoPaterno']." ".$empleado['xt_ApellidoMaterno']."</td>";
								echo "<td align='center'><a href='fichaPersonal.php?ID=".$empleado['kp_personalId']."' target='_blank'>".$empleado["estatusResguardo"]."</a></td>";
							echo "</tr>";
						}
					}
				echo "</table>";
			echo"</tr>";

		echo "</table>";
	}

echo "</div>";

?>

	<!-- Modal -->
	<div id="myModal" class="modal">
		<div class="modal-content">
			<span class="close" onclick="closeModal()">&times;</span>
			<h2 id="modalTitle"></h2>
			<div id="modalContent">
				<!-- Aquí se mostrará la información cargada dinámicamente -->
			</div>
			<div align="center">
				<table>
					<tr id="modalButton">
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- 🔹 Modal de cámara -->
	<div id="cameraModal">
		<div id="modalContentCamera">
			<h3 id="usuarioFoto" style="display:none;"></h3>
			<h3 id="nombreUsuarioFoto" style="color:black;"></h3>
			<video id="video" autoplay playsinline></video>
			<canvas id="canvas" width="250" height="300" style="display:none;"></canvas>

			<div class="button-group">
				<button onclick="capturePhoto()" id="capture" style="display:block;">Tomar Foto</button>
				<button onclick="reCapturePhoto()" id="recapture" style="display:none;">Volver a Tomar</button>
				<button onclick="savePhoto()" id="savePhoto" style="display:none;">Guardar</button>
				<button onclick="closeModalCamara()" id="closeModalCamara">Cerrar</button>
			</div>
		</div>
	</div>

</body>
</html>
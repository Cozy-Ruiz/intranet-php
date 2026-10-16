<?php
 error_reporting(0);

$nombrephp = 'altaVisitaPopUp3.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

error_reporting(E_PARSE);

//date_default_timezone_set('America/Mexico_City');

//echo "tipo: ".$_GET['tipo'].", name: ".$_POST['searchName'].", id: ".$_GET['idFound']."<br>";

// Zona horaria de Mexico
//$horaActual=date_default_timezone_set('America/Mexico_City');
$hoy = date("d-m-Y");
//echo $hoy;
//$hora = date('H:i:s');

//echo date("h:i:s");
 date_default_timezone_set('America/Mexico_City');

$horaActual=date("H:i:s");



// Como la zona horaria no concuerda entonces se le agregó 4 horas y 11 minutos.
//$horaActual = date('H:i:s',time() + 10800 );
//$horaActual = date('H:i:s',time());
//echo " ".$horaActual;


///OBTENER LA CIUDAD A LA QUE SE VA A AGREGAR LA VISITA
$ciudad = $_GET['cd'];
if($ciudad =="CMX")
{
	$ciudad="DF";
}
function eliminar_caracteres_especiales($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );


    return $string;
}

//PRIMER PASO INTRODUCIR UN NOMBRE O APELLIDO
//echo "Name: ".$_POST['searchName']." idFound: ".$_GET['idFound']." tipo: ".$_GET['tipo']." captura: ".$_GET['captura']." insert: ".$_GET['insert']."<br>";

if((isset($_POST['searchName']) == "") && (isset($_GET['idFound']) == "") && (isset($_GET['tipo']) == "") && (isset($_GET['captura']) == "") && (isset($_GET['insert']) == "")){

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Visitas</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#titulo_camara {
		background-color: #666;
		color:#FFF;
		padding-left: 30px;
		font-size: 14px;
		text-align:center;
	}
	.botones_cam {
		background-color:#007cbd;
		color:#fff;
		font-family:Lucida Sans;
		font-size:14px;
		font-weight:bold;
		width:90px;
		height:30px;
	}
	.formulario {
		color: #FFF;
	}
	.requerido{
		color: #FFFFFF;
		background-color: #007cbd;
	}
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="webcam.js"></script>

<script language="JavaScript">
	webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
	webcam.set_quality( 100 ); // calidad de la imagen
	webcam.set_shutter_sound( true ); // Sonido de flash
</script>

<script language="JavaScript">
	webcam.set_hook( 'onComplete', 'my_completion_handler' );
	
	function show(){
		document.getElementById("subido").style.display="none";
		document.getElementById("subido2").style.display="block";
		do_upload();
	}
	
	function do_upload() {
		// subir al servidor
		document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
		webcam.upload();
	}
	
	function my_completion_handler(msg) {
		
		if (msg.match(/(http\:\/\/\S+)/)) {
			var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
			
			// Muestra la imagen en la pantalla
			document.getElementById('upload_results').innerHTML = 
				'<img src="' + image_url + '" width="320px" height="240px">'+
				'<input type="hidden" name="foto" value="'+image_url+'">'
				;
			// reset camera for another shot
			webcam.reset();
		}
		else alert("PHP Error: " + msg);
	}
</script>

</head>
<body>
<?php	

	echo "<div id='wrapperPopUp'>";
		echo "<form name='altaVisitas' method='post' action='altaVisitaPopUp3.php?cd=".$ciudad."'>";
			echo "<table border='0' align='center' name='menuLetras'>";
				echo "<tr height='30'> <td colspan='2'> </td> </tr>";
				
				echo "<tr>";
					echo "<td colspan='2' align='center' id='titulo1'>Visita</td>";
				echo "</tr>";
				
				echo "<tr height='30'> </tr>";
						
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='2' align='left' id='titulo2'>Búsqueda</td>";
				echo "</tr>";
				
				echo "<tr height='30'> </tr>";
				
				echo "<tr>";
					echo "<td colspan='2' align='left' id='titulo2'><font size='1'>(Primer nombre)</font></td>";
				echo "</tr>";
				
				echo "<tr style='vertical-align:center;'>";
					echo "<td align='right' > ";
						echo "<input type='text' name='searchName' autocomplete='off' size='40'>";
					echo "</td>";
					echo "<td align='left'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Busqueda.png' height='23' width='23'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30'> </tr>";
						
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'> </td>";
				echo "</tr>";
				echo "<tr height='30'> </tr>";			
			echo "</table>";
		echo "</form>";
	echo "</div>";
//OBTENER EL NOMBRE O APELLIDO Y REALIZAR EL DESPLIEGUE DE LOS RESULTADOS
} else if((isset($_POST['searchName']) != "") && (isset($_GET['idFound']) == "") && (isset($_GET['tipo']) == "") && (isset($_GET['captura']) == "") && (isset($_GET['insert']) == "")){
	
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Visitas</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#titulo_camara {
		background-color: #666;
		color:#FFF;
		padding-left: 30px;
		font-size: 14px;
		text-align:center;
	}
	.botones_cam {
		background-color:#007cbd;
		color:#fff;
		font-family:Lucida Sans;
		font-size:14px;
		font-weight:bold;
		width:90px;
		height:30px;
	}
	.formulario {
		color: #FFF;
	}
	.requerido{
		color: #FFFFFF;
		background-color: #007cbd;
	}
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="webcam.js"></script>

<script language="JavaScript">
	webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
	webcam.set_quality( 100 ); // calidad de la imagen
	webcam.set_shutter_sound( true ); // Sonido de flash
</script>

<script language="JavaScript">
	webcam.set_hook( 'onComplete', 'my_completion_handler' );
	
	function show(){
		document.getElementById("subido").style.display="none";
		document.getElementById("subido2").style.display="block";
		do_upload();
	}
	
	function do_upload() {
		// subir al servidor
		document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
		webcam.upload();
	}
	
	function my_completion_handler(msg) {
		
		if (msg.match(/(http\:\/\/\S+)/)) {
			var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
			
			// Muestra la imagen en la pantalla
			document.getElementById('upload_results').innerHTML = 
				'<img src="' + image_url + '" width="320px" height="240px">'+
				'<input type="hidden" name="foto" value="'+image_url+'">'
				;
			// reset camera for another shot
			webcam.reset();
		}
		else alert("PHP Error: " + msg);
	}
</script>

</head>
<body>
	<script src="script.js"></script>
<?php	

	//echo "HOLAAAAA";

	//date_default_timezone_set('America/Mexico_City');
	//$hoy = date("d-m-Y");
	//$horaActual = date('H:i:s');
	
	echo "<div id='wrapperPopUp'>";
		$searchNombre = $_POST['searchName'];
		$searchNombre = ucwords(strtolower($searchNombre));
		$searchNombreLimpio = $_POST['searchName'];
		$searchNombreLimpio = ucwords(strtolower(eliminar_caracteres_especiales($searchNombreLimpio)));
	/*		
		$n = $INTRANET->execute("
			SELECT kp_personalId,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Nombre,xt_tipo 
			FROM SGI_Empleados WHERE (xt_ApellidoPaterno  LIKE '%$searchNombre%' OR xt_ApellidoPaterno  LIKE '%$searchNombreLimpio%' OR xt_ApellidoMaterno LIKE '%$searchNombre%' 
			OR xt_ApellidoMaterno LIKE '%$searchNombreLimpio%' OR xt_Nombre LIKE '%$searchNombre%' OR xt_Nombre LIKE '%$searchNombreLimpio%') 
			AND xt_Estatus = 1 AND xt_ciudad = '$ciudad' ORDER BY xt_ApellidoPaterno ASC ");*/

			if($ciudad=="CDMX")
			{
				$query="
			SELECT SE.kp_personalId, SE.xt_ApellidoPaterno, SE.xt_ApellidoMaterno, SE.xt_Nombre, SE.xt_tipo 
			FROM SGI_Empleados SE WHERE (SE.xt_ApellidoPaterno  LIKE '%$searchNombre%' OR SE.xt_ApellidoPaterno  LIKE '%$searchNombreLimpio%' OR SE.xt_ApellidoMaterno LIKE '%$searchNombre%' 
			OR SE.xt_ApellidoMaterno LIKE '%$searchNombreLimpio%' OR SE.xt_Nombre LIKE '%$searchNombre%' OR SE.xt_Nombre LIKE '%$searchNombreLimpio%') 
			AND SE.xt_Estatus = 1 AND (SE.kf_usuario IN (SELECT O.kf_usuarioId FROM IntranetGEA_Usuarios_Oficina O WHERE O.xt_codigoCiudad = '$ciudad') OR SE.xt_ciudad = '$ciudad')
				UNION
					SELECT SE.kp_personalId, SE.xt_ApellidoPaterno, SE.xt_ApellidoMaterno, SE.xt_Nombre, SE.xt_tipo 
			FROM SGI_Empleados SE WHERE (SE.xt_ApellidoPaterno  LIKE '%$searchNombre%' OR SE.xt_ApellidoPaterno  LIKE '%$searchNombreLimpio%' OR SE.xt_ApellidoMaterno LIKE '%$searchNombre%' 
			OR SE.xt_ApellidoMaterno LIKE '%$searchNombreLimpio%' OR SE.xt_Nombre LIKE '%$searchNombre%' OR SE.xt_Nombre LIKE '%$searchNombreLimpio%') 
			AND SE.xt_Estatus = 1 AND (SE.kf_usuario IN (SELECT O.kf_usuarioId FROM IntranetGEA_Usuarios_Oficina O WHERE O.xt_codigoCiudad = 'DF') OR SE.xt_ciudad = 'DF')

			 ";

			}
			else
			{

				$query="
			SELECT SE.kp_personalId, SE.xt_ApellidoPaterno, SE.xt_ApellidoMaterno, SE.xt_Nombre, SE.xt_tipo 
			FROM SGI_Empleados SE WHERE (SE.xt_ApellidoPaterno  LIKE '%$searchNombre%' OR SE.xt_ApellidoPaterno  LIKE '%$searchNombreLimpio%' OR SE.xt_ApellidoMaterno LIKE '%$searchNombre%' 
			OR SE.xt_ApellidoMaterno LIKE '%$searchNombreLimpio%' OR SE.xt_Nombre LIKE '%$searchNombre%' OR SE.xt_Nombre LIKE '%$searchNombreLimpio%') 
			AND SE.xt_Estatus = 1 AND (SE.kf_usuario IN (SELECT O.kf_usuarioId FROM IntranetGEA_Usuarios_Oficina O WHERE O.xt_codigoCiudad = '$ciudad') OR SE.xt_ciudad = '$ciudad') ORDER BY SE.xt_ApellidoPaterno ASC ";

			}

				//echo $query;
		$n = $INTRANET->execute($query);
		 
			
		$nom = $n->recordCount();
		
		echo "<form name='altaVisitas' method='post' action='altaVisitaPopUp3.php?cd=".$ciudad."'>";
			echo"<table border='0' align='center' name='busquedaPersonal'>";
				echo "<tr height='30'> <td colspan='2'> </td> </tr>";
				
				echo "<tr>";
					echo "<td align='center' id='titulo1' colspan='2'>Visita</td>";
				echo "</tr>";
				
				echo "<tr height='30'> </tr>";
					
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'> </td>";
				echo "</tr>";
				
				echo "<tr height='10'> </tr>";
				
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='320px' colspan='2'>Resultado de la búsqueda</td>";
				echo "</tr>";
					
				echo "<tr height='20'> </tr>";
				
				echo "<input type='hidden' name='searchName' value='".$searchNombre."'>";
		
		///SI HAY COINCIDENCIAS PROCEDIMIENTO PARA INSERTAR EN VISITAS 
			if($nom > 0){
				while($a = $n->fetchRow()){
					
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'>";
							echo "<a href='altaVisitaPopUp3.php?cd=".$ciudad."&idFound=".$a[0]."&fecha=".$hoy."&horaEntrada=".$horaActual."' id='iconosTexto' style='text-decoration:none;'>";
								echo "".$a[3]." ".$a[1]." ".$a[2];
								echo "</a>";
							echo "</td>";
						
						echo "<td align='left' width='80px'>";
							if($a[4] == "E"){
								echo "Empleado";
							} else if($a[4] == "D"){
								echo "Directivo";
							} else if($a[4] == "P"){
								echo "Proveedor";
							} else if($a[4] == "V"){
								echo "VIP";
							} else if($a[4] == "C"){
								echo "Cliente";
							} else if($a[4] == "A"){
								echo "Autoridad";
							}
						echo "</td>";
						echo "<input type='hidden' name='fecha' value='".$hoy."'>
								<input type='hidden' name='horaEntrada' value='".$horaActual."'>";
					echo "</tr>";
				}
				
				echo"<tr height='40'> </tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'> </td>";
				echo "</tr>";
				
				echo"<tr height='20'> <td colspan='2'> </td></tr>";
				
				echo"<tr>";
					echo"<td valign='bottom' align='center' colspan='2' id='iconosTexto'>";
						echo "Si no aparece en esta lista registre la visita.<br><br><br>
								<a href='altaVisitaPopUp3.php?cd=".$ciudad."&tipo=normal&name=".$searchNombre."' id='iconosTexto'>
									<img src='../Imagenes/ICN_BotonRegistrarVisita.png' width='120' height='39'>
								</a>";
					echo"</td>";
				echo "</tr>";
				
				echo"<tr height='30'> <td colspan='2'> </td></tr>";
		///SI NO HAY COINCIDENCIAS PROCEDIMIENTO NORMAL PARA VISITAS
			} else{
				
				echo "<tr id='iconosTexto'>";
					echo "<td align='center' colspan='2'><i> No se encontraron resultados para</i> <b>".$searchNombre."</b>.</td>";
				echo "</tr>";
				
				echo"<tr height='20'> <td colspan='2'> </td></tr>";
				
				echo"<tr>";
					echo"<td valign='bottom' align='center' colspan='2' id='iconosTexto'>";
						echo "Registre la visita.<br><br><br>
								<a href='altaVisitaPopUp3.php?cd=".$ciudad."&tipo=normal&name=".$searchNombre."' id='iconosTexto'>
									<img src='../Imagenes/ICN_BotonRegistrarVisita.png' width='120' height='39'>
								</a>";
					echo"</td>";
				echo "</tr>";
				
				echo"<tr height='20'> </tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'> </td>";
				echo "</tr>";
			}
			
			echo"</table>";
		echo "</form>";
	echo "</div>";
///SI ENCUENTRA COINCIDENCIAS Y SELECCIONA CUAL ENTONCES...
} else if((isset($_POST['searchName']) == "") && (isset($_GET['idFound']) != "") && (isset($_GET['tipo']) == "") && (isset($_GET['captura']) == "") && (isset($_GET['insert']) == "") && (isset($_GET['confirmado']) == "")){
	
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Visitas</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#titulo_camara {
		background-color: #666;
		color:#FFF;
		padding-left: 30px;
		font-size: 14px;
		text-align:center;
	}
	.botones_cam {
		background-color:#007cbd;
		color:#fff;
		font-family:Lucida Sans;
		font-size:14px;
		font-weight:bold;
		width:90px;
		height:30px;
	}
	.formulario {
		color: #FFF;
	}
	.requerido{
		color: #FFFFFF;
		background-color: #007cbd;
	}
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="webcam.js"></script>

<script language="JavaScript">
	webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
	webcam.set_quality( 100 ); // calidad de la imagen
	webcam.set_shutter_sound( true ); // Sonido de flash
</script>

<script language="JavaScript">
	webcam.set_hook( 'onComplete', 'my_completion_handler' );
	
	function show(){
		document.getElementById("subido").style.display="none";
		document.getElementById("subido2").style.display="block";
		do_upload();
	}
	
	function do_upload() {
		// subir al servidor
		document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
		webcam.upload();
	}
	
	function my_completion_handler(msg) {
		
		if (msg.match(/(http\:\/\/\S+)/)) {
			var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
			
			// Muestra la imagen en la pantalla
			document.getElementById('upload_results').innerHTML = 
				'<img src="' + image_url + '" width="320px" height="240px">'+
				'<input type="hidden" name="foto" value="'+image_url+'">'
				;
			// reset camera for another shot
			webcam.reset();
		}
		else alert("PHP Error: " + msg);
	}
</script>

</head>
<body>
<?php	

	$fechaInsert = date('Y-m-d', strtotime($_GET['fecha']));
	$horaEntradaInsert = date('H:i:s', strtotime($_GET['horaEntrada']));

	$idPersonal = $_GET['idFound'];
	$gafeteCaptura = isset($_POST['gafete']);
	$identificacionCaptura = isset($_POST['identificacion']);
	
	
	$s = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, xt_Empresa, xt_tipo, xn_foto, xt_ifeVF, xt_equipoComputoVF, xt_placaVehicularVF 
							FROM SGI_Empleados WHERE kp_personalId = $idPersonal ");
	
	while($r = $s->fetchRow()){
		$nombreInsert = $r[0];
		$apaternoInsert = $r[1];
		$amaternoInsert = $r[2];
		$empresaInsert = $r[3];
		$tipoInsert = $r[4];
		$foto = $r[5];
		$ife = $r[6];
		$equipoComputo = $r[7];
		$placaVehicular = $r[8];
		
	} unset($r); unset($s);
	
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='altaVisitas' method='post' action='altaVisitaPopUp3.php?cd=".$ciudad."&confirmado=OK&idFound=".$idPersonal."&fecha=".$fechaInsert."&horaEntrada=".$horaEntradaInsert."'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Visita Autorizada</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='30'> </tr>";
		echo "</table>";
		
		//LINEA
		echo "<table border='0' align='center' width='550'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
		echo "</table>";

		echo "<table border='0' align='center' >";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='titulo2'>";
				echo"<td align='center' colspan='2'><img src='../ComunicacionInterna/Personal/".$foto."' height='117' width='100'></td> ";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
		echo"</table>";
			
		echo "<table border='0' align='center' >";	
			echo"<tr id='titulo2'>";
				echo"<td align='left'>*Gafete: </td>";
					if($gafeteCaptura != ""){
						echo"<td align='left'><input type='text' size='10' name='gafete' value='".$gafeteCaptura."'></td>";
					} else{
						echo"<td align='left'><input type='text' size='10' name='gafete' value='".$gafeteCaptura."' class='requerido'></td>";
					}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
					echo"<td align='left' id='titulo2' width='100px'>Nombre:</td>";
					echo"<td align='left'id='titulo2Blanco' width='300px'>".$nombreInsert." ".$apaternoInsert." ".$amaternoInsert."</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
					echo"<td align='left' id='titulo2'>Empresa:</td>";
					echo"<td align='left'id='titulo2Blanco'>".$empresaInsert."</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>Tipo:</td>";
				if($tipoInsert == "A"){
					echo"<td align='left'id='titulo2Blanco'>Autoridad</td>";
				} else if($tipoInsert == "E"){
					echo"<td align='left'id='titulo2Blanco'>Empleado</td>";
				} else if($tipoInsert == "D"){
					echo"<td align='left'id='titulo2Blanco'>Directivo</td>";
				} else if($tipoInsert == "P"){
					echo"<td align='left'id='titulo2Blanco'>Proveedor</td>";
				} else if($tipoInsert == "V"){
					echo"<td align='left'id='titulo2Blanco'>VIP</td>";
				} else if($tipoInsert == "C"){
					echo"<td align='left'id='titulo2Blanco'>Cliente</td>";
				}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>*Identificación: </td>";
				if($ife != ""){
					echo"<td align='left'><input type='text' size='50' name='identificacion' value='".$ife."'></td> ";
				} else{
					echo"<td align='left'><input type='text' size='50' name='identificacion' value='".$identificacionCaptura."' class='requerido'></td> ";
				}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>Equipo de Computo: </td>";
				if($equipoComputo != ""){
					echo"<td align='left'><textarea name='ecomputo' style='width: 345px; height:80px;'>".$equipoComputo."</textarea></td> ";
				} else{
					echo"<td align='left'><textarea name='ecomputo' style='width: 345px; height:80px;'></textarea></td> ";
				}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>Placa Vehicular: </td>";
				if($placaVehicular != ""){
					echo"<td align='left'><input type='text' size='50' name='placa' value='".$placaVehicular."'></td> ";
				} else{
					echo"<td align='left'><input type='text' size='50' name='placa'></td> ";
				}
			echo"</tr>";
		echo"</table>";
		
		//LINEA
		echo "<table border='0' align='center' width='550'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
		echo "</table>";
			 
	  echo "</form>";
	echo "</div>";
	/*	
	echo "<script type='text/javascript'>reCargarPadre()</script>";
	*/
///SI ENCUENTRA COINCIDENCIAS Y SELECCIONA CUAL ENTONCES...
} else if((isset($_POST['searchName']) == "") && (isset($_GET['idFound']) != "") && (isset($_GET['tipo']) == "") && (isset($_GET['captura']) == "") && (isset($_GET['insert']) == "") && (isset($_GET['confirmado']) == "")){
	
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Visitas</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>

<style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#titulo_camara {
		background-color: #666;
		color:#FFF;
		padding-left: 30px;
		font-size: 14px;
		text-align:center;
	}
	.botones_cam {
		background-color:#007cbd;
		color:#fff;
		font-family:Lucida Sans;
		font-size:14px;
		font-weight:bold;
		width:90px;
		height:30px;
	}
	.formulario {
		color: #FFF;
	}
	.requerido{
		color: #FFFFFF;
		background-color: #007cbd;
	}
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="webcam.js"></script>

<script language="JavaScript">
	webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
	webcam.set_quality( 100 ); // calidad de la imagen
	webcam.set_shutter_sound( true ); // Sonido de flash
</script>

<script language="JavaScript">
	webcam.set_hook( 'onComplete', 'my_completion_handler' );
	
	function show(){
		document.getElementById("subido").style.display="none";
		document.getElementById("subido2").style.display="block";
		do_upload();
	}
	
	function do_upload() {
		// subir al servidor
		document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
		webcam.upload();
	}
	
	function my_completion_handler(msg) {
		
		if (msg.match(/(http\:\/\/\S+)/)) {
			var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
			
			// Muestra la imagen en la pantalla
			document.getElementById('upload_results').innerHTML = 
				'<img src="' + image_url + '" width="320px" height="240px">'+
				'<input type="hidden" name="foto" value="'+image_url+'">'
				;
			// reset camera for another shot
			webcam.reset();
		}
		else alert("PHP Error: " + msg);
	}
</script>

</head>
<body>
<?php	

	$fechaInsert = date('Y-m-d', strtotime($_GET['fecha']));
	$horaEntradaInsert = date('H:i:s', strtotime($_GET['horaEntrada']));

	$idPersonal = $_GET['idFound'];
	//echo "SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, xt_Empresa FROM SGI_Empleados WHERE kp_personalId = $idPersonal ";
	
	$s = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, xt_Empresa, xt_tipo, xn_foto, xt_ifeVF, xt_equipoComputoVF, xt_placaVehicularVF 
							FROM SGI_Empleados WHERE kp_personalId = $idPersonal ");
	
	while($r = $s->fetchRow()){
		$nombreInsert = $r[0];
		$apaternoInsert = $r[1];
		$amaternoInsert = $r[2];
		$empresaInsert = $r[3];
		$tipoInsert = $r[4];
		$foto = $r[5];
		$ife = $r[6];
		$equipoComputo = $r[7];
		$placaVehicular = $r[8];
		
	} unset($r); unset($s);
	
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='altaVisitas' method='post' action='altaVisitaPopUp3.php?cd=".$ciudad."&confirmado=OK&idFound=".$idPersonal."&fecha=".$fechaInsert."&horaEntrada=".$horaEntradaInsert."'>";	

	
	 		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Visita Autorizada</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='30'> </tr>";
		echo "</table>";
		
		//LINEA
		echo "<table border='0' align='center' width='550'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
		echo "</table>";

		echo "<table border='0' align='center' >";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='titulo2'>";
				echo"<td align='center' colspan='2'><img src='../ComunicacionInterna/Personal/".$foto."' height='117' width='100'></td> ";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
		echo"</table>";
			
		echo "<table border='0' align='center' >";	
			echo"<tr id='titulo2'>";
				echo"<td align='left'>*Gafete: </td>";
				if($gafeteCaptura != ""){
					echo"<td align='left'><input type='text' size='10' name='gafete' value='".$gafeteCaptura."'></td>";
				} else{
					echo"<td align='left'><input type='text' size='10' name='gafete' value='".$gafeteCaptura."' class='requerido'></td>";
				}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
					echo"<td align='left' id='titulo2' width='100px'>Nombre:</td>";
					echo"<td align='left'id='titulo2Blanco' width='300px'>".$nombreInsert." ".$apaternoInsert." ".$amaternoInsert."</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
					echo"<td align='left' id='titulo2'>Empresa:</td>";
					echo"<td align='left'id='titulo2Blanco'>".$empresaInsert."</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>Tipo:</td>";
				if($tipoInsert == "A"){
					echo"<td align='left'id='titulo2Blanco'>Autoridad</td>";
				} else if($tipoInsert == "E"){
					echo"<td align='left'id='titulo2Blanco'>Empleado</td>";
				} else if($tipoInsert == "D"){
					echo"<td align='left'id='titulo2Blanco'>Directivo</td>";
				} else if($tipoInsert == "P"){
					echo"<td align='left'id='titulo2Blanco'>Proveedor</td>";
				} else if($tipoInsert == "V"){
					echo"<td align='left'id='titulo2Blanco'>VIP</td>";
				} else if($tipoInsert == "C"){
					echo"<td align='left'id='titulo2Blanco'>Cliente</td>";
				}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>*Identificación: </td>";
				if($ife != ""){
					echo"<td align='left'><input type='text' size='50' name='identificacion' value='".$ife."'></td> ";
				} else{
					echo"<td align='left'><input type='text' size='50' name='identificacion' value='".$identificacionCaptura."' class='requerido'></td> ";
				}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>Equipo de Computo: </td>";
				if($equipoComputo != ""){
					echo"<td align='left'><textarea name='ecomputo' style='width: 345px; height:80px;'>".$equipoComputo."</textarea></td> ";
				} else{
					echo"<td align='left'><textarea name='ecomputo' style='width: 345px; height:80px;'></textarea></td> ";
				}
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr>";
				echo"<td align='left' id='titulo2'>Placa Vehicular: </td>";
				if($placaVehicular != ""){
					echo"<td align='left'><input type='text' size='50' name='placa' value='".$placaVehicular."'></td> ";
				} else{
					echo"<td align='left'><input type='text' size='50' name='placa'></td> ";
				}
			echo"</tr>";
		echo"</table>";
		
		//LINEA
		echo "<table border='0' align='center' width='550'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
		echo "</table>";
			 
	  echo "</form>";
	echo "</div>";
		
	echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	
} else if((isset($_POST['searchName']) == "") && (isset($_GET['idFound']) != "") && (isset($_GET['tipo']) == "") && (isset($_GET['captura']) == "") && (isset($_GET['insert']) == "") && (isset($_GET['confirmado']) == "OK")){
	
	$fechaInsert = date('Y-m-d', strtotime($_GET['fecha']));
	$horaEntradaInsert = date('H:i:s', strtotime($_GET['horaEntrada']));
	$idPersonal = $_GET['idFound'];
	
	$gafeteInsert = $_POST['gafete'];
	$identificacionInsert = $_POST['identificacion'];
	$equipoComputoInsert = $_POST['ecomputo'];
	$placaVehicularInsert = $_POST['placa'];
	
	//echo "SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, xt_Empresa FROM SGI_Empleados WHERE kp_personalId = $idPersonal ";
	
	$s = $INTRANET->Execute("SELECT xt_Nombre, xt_ApellidoPaterno, xt_ApellidoMaterno, xt_Empresa, xt_tipo, xn_foto, xt_ifeVF, xt_equipoComputoVF, xt_placaVehicularVF 
							FROM SGI_Empleados WHERE kp_personalId = $idPersonal ");
	
	while($r = $s->fetchRow()){
		$nombreInsert = $r[0];
		$apaternoInsert = $r[1];
		$amaternoInsert = $r[2];
		$empresaInsert = $r[3];
		$tipoInsert = $r[4];
		$foto = $r[5];
		$ife = $r[6];
		$equipoComputo = $r[7];
		$placaVehicular = $r[8];
		
	} unset($r); unset($s);
	
//DEPENDIENDO DE LA CIUDAD ES LA BASE DE DATOS A LA QUE SE LE INSERTARAN LOS VALORES
	$queryVisita = "INSERT INTO SGI_Visitas";
	if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
		$queryVisita = $queryVisita."_".$ciudad;
	}
	$queryVisita = $queryVisita." (xd_fecha,xt_nombre,xt_horaEntrada,kf_personalEncargadoId,xt_tipoVisita,kf_personalIDVF) 
			VALUES ('$fechaInsert','$nombreInsert','$horaEntradaInsert',$idPersonal,'$tipoInsert',$idPersonal) ";
	//echo $queryVisita."<br>";
		
	//echo"$queryVisita";
		if($INTRANET->Execute($queryVisita)){
				
			//$idVisita = mysql_insert_id();	
			$query1 = "SELECT MAX(kp_visitaID) FROM SGI_Visitas";
			if($ciudad != "CDMX"){
				$query1 = $query1."_".$ciudad;
			}
			//echo $query1;
			$idVisita = $INTRANET->getOne($query1);
				
			if($apaternoInsert != ""){
				$tempo = "UPDATE SGI_Visitas";
				if($ciudad != "CDMX"){
					$tempo = $tempo."_".$ciudad;
				}
				$tempo = $tempo." SET xt_apellidoPaterno= '$apaternoInsert' WHERE kp_visitaID = $idVisita ";
				$INTRANET->Execute($tempo);
				
			}
			
			if($amaternoInsert != ""){
				$tempo = "UPDATE SGI_Visitas";
				if($ciudad != "CDMX"){
					$tempo = $tempo."_".$ciudad;
				}
				$tempo = $tempo." SET xt_apellidoMaterno= '$amaternoInsert' WHERE kp_visitaID = $idVisita ";
				$INTRANET->Execute($tempo);
				
			}
			
			if($empresaInsert != ""){
				$tempo = "UPDATE SGI_Visitas";
				if($ciudad != "CDMX"){
					$tempo = $tempo."_".$ciudad;
				}
				$tempo = $tempo." SET xt_empresaRepresenta= '$empresaInsert' WHERE kp_visitaID = $idVisita ";
				$INTRANET->Execute($tempo);
				
			}
			if($gafeteInsert != ""){
				$tempo = "UPDATE SGI_Visitas";
				if($ciudad != "CDMX"){
					$tempo = $tempo."_".$ciudad;
				}
				$tempo = $tempo." SET xn_credencial= '$gafeteInsert' WHERE kp_visitaID = $idVisita ";
				$INTRANET->Execute($tempo);
				
			}
			if($placaVehicularInsert != ""){
				$tempo = "UPDATE SGI_Visitas";
				if($ciudad != "CDMX"){
					$tempo = $tempo."_".$ciudad;
				}
				$tempo = $tempo." SET xt_placaVehicular= '$placaVehicularInsert' WHERE kp_visitaID = $idVisita ";
				$INTRANET->Execute($tempo);
				
				if($placaVehicular == ""){
					$INTRANET->Execute("UPDATE SGI_Empleados SET xt_placaVehicularVF = '$placaVehicularInsert' WHERE kp_personalId = $idPersonal");
					
				}
			}
			if($identificacionInsert != ""){
				$tempo = "UPDATE SGI_Visitas";
				if($ciudad != "CDMX"){
					$tempo = $tempo."_".$ciudad;
				}
				$tempo = $tempo." SET xt_identificacion= '$identificacionInsert' WHERE kp_visitaID = $idVisita ";
				$INTRANET->Execute($tempo);
				
				if($ife == ""){
					$INTRANET->Execute("UPDATE SGI_Empleados SET xt_ifeVF = '$identificacionInsert' WHERE kp_personalId = $idPersonal");
					
				}
			}
			if($equipoComputoInsert != ""){
				$tempo = "UPDATE SGI_Visitas";
				if($ciudad != "CDMX"){
					$tempo = $tempo."_".$ciudad;
				}
				$tempo = $tempo." SET xt_equipoComputo= '$equipoComputoInsert' WHERE kp_visitaID = $idVisita ";
				$INTRANET->Execute($tempo);
				
				if($equipoComputo == ""){
					$INTRANET->Execute("UPDATE SGI_Empleados SET xt_equipoComputoVF = '$equipoComputoInsert' WHERE kp_personalId = $idPersonal");
					
				}
			}
			
			
			if($foto == "FILES/sinFoto.jpg"){
				header("Location: altaVisitaPopUp3.php?cd=".$ciudad."&captura=OK&idVisita=".$idVisita."&visitaFrecuente=".$idPersonal."");
			}else {
			
			?>
			<!doctype html>
			<html lang="en">
			<head>
			<meta charset="utf-8" />
			<title>Visitas</title>
			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
			<script type="text/javascript">
				function reCargarPadre(){
					opener.location.reload();
					window.close();
				}
			</script>
			
			<style type="text/css">
				/* jQuery lightBox plugin - Gallery style */
				#titulo_camara {
					background-color: #666;
					color:#FFF;
					padding-left: 30px;
					font-size: 14px;
					text-align:center;
				}
				.botones_cam {
					background-color:#007cbd;
					color:#fff;
					font-family:Lucida Sans;
					font-size:14px;
					font-weight:bold;
					width:90px;
					height:30px;
				}
				.formulario {
					color: #FFF;
				}
				.requerido{
					color: #FFFFFF;
					background-color: #007cbd;
				}
			</style>
			<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
			<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
			
			<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
			
			<script type="text/javascript" src="webcam.js"></script>
			
			<script language="JavaScript">
				webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
				webcam.set_quality( 100 ); // calidad de la imagen
				webcam.set_shutter_sound( true ); // Sonido de flash
			</script>
			
			<script language="JavaScript">
				webcam.set_hook( 'onComplete', 'my_completion_handler' );
				
				function show(){
					document.getElementById("subido").style.display="none";
					document.getElementById("subido2").style.display="block";
					do_upload();
				}
				
				function do_upload() {
					// subir al servidor
					document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
					webcam.upload();
				}
				
				function my_completion_handler(msg) {
					
					if (msg.match(/(http\:\/\/\S+)/)) {
						var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
						
						// Muestra la imagen en la pantalla
						document.getElementById('upload_results').innerHTML = 
							'<img src="' + image_url + '" width="320px" height="240px">'+
							'<input type="hidden" name="foto" value="'+image_url+'">'
							;
						// reset camera for another shot
						webcam.reset();
					}
					else alert("PHP Error: " + msg);
				}
			</script>
			
			</head>
			<body>
			<?php	


			echo "<script type='text/javascript'>reCargarPadre()</script>";
		}
		
	} else{
		
		?>
		<!doctype html>
		<html lang="en">
		<head>
		<meta charset="utf-8" />
		<title>Visitas</title>
		<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
		<script type="text/javascript">
			function reCargarPadre(){
				opener.location.reload();
				window.close();
			}
		</script>
		
		<style type="text/css">
			/* jQuery lightBox plugin - Gallery style */
			#titulo_camara {
				background-color: #666;
				color:#FFF;
				padding-left: 30px;
				font-size: 14px;
				text-align:center;
			}
			.botones_cam {
				background-color:#007cbd;
				color:#fff;
				font-family:Lucida Sans;
				font-size:14px;
				font-weight:bold;
				width:90px;
				height:30px;
			}
			.formulario {
				color: #FFF;
			}
			.requerido{
				color: #FFFFFF;
				background-color: #007cbd;
			}
		</style>
		<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
		
		<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
		
		<script type="text/javascript" src="webcam.js"></script>
		
		<script language="JavaScript">
			webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
			webcam.set_quality( 100 ); // calidad de la imagen
			webcam.set_shutter_sound( true ); // Sonido de flash
		</script>
		
		<script language="JavaScript">
			webcam.set_hook( 'onComplete', 'my_completion_handler' );
			
			function show(){
				document.getElementById("subido").style.display="none";
				document.getElementById("subido2").style.display="block";
				do_upload();
			}
			
			function do_upload() {
				// subir al servidor
				document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
				webcam.upload();
			}
			
			function my_completion_handler(msg) {
				
				if (msg.match(/(http\:\/\/\S+)/)) {
					var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
					
					// Muestra la imagen en la pantalla
					document.getElementById('upload_results').innerHTML = 
						'<img src="' + image_url + '" width="320px" height="240px">'+
						'<input type="hidden" name="foto" value="'+image_url+'">'
						;
					// reset camera for another shot
					webcam.reset();
				}
				else alert("PHP Error: " + msg);
			}
		</script>
		
		</head>
		<body>
		<?php	

		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
			
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error al agregar visita!</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
		echo "</div>";
	}
	
///SI NO ENCUENTRA COINCIDENCIAS Y SIGUE EL PROCEDIMIENTO NORMAL
} else if((isset($_POST['searchName']) == "") && (isset($_GET['idFound']) == "") && (isset($_GET['tipo']) == "normal") && (isset($_GET['captura']) == "") && (isset($_GET['insert']) == "")){
	
	//date_default_timezone_set('America/Mexico_City');
	//$hoy = date("d-m-Y");
	//$horaActual = date('H:i:s', time());
	if($_GET['name'] != ""){
		$nombreBusqueda = $_GET['name'];
	} else if($_POST['name'] != ""){
		$nombreBusqueda = $_POST['name'];
	}
	$gafeteCaptura = isset($_POST['gafete']);
	$aPaternoCaptura = isset($_POST['apaterno']);
	$aPaternoCaptura = ucwords(strtolower($aPaternoCaptura));
	$aMaternoCaptura = isset($_POST['amaterno']);
	$aMaternoCaptura = ucwords(strtolower($aMaternoCaptura));
	$empresaCaptura = isset($_POST['empresa']);
	$responsableCaptura = isset($_POST['personaVisita']);
	$identificacionCaptura = isset($_POST['identificacion']);
	$equipoCaptura = isset($_POST['ecomputo']);
	$placaCaptura = isset($_POST['placa']);
	
	////REQUERIR TODA LA INFORMACION
	if(/*($gafeteCaptura == "") || */($nombreBusqueda == "") || ($aPaternoCaptura == "") || ($empresaCaptura == "") || ($responsableCaptura == "") || ($identificacionCaptura == "")){
		
		?>
		<!doctype html>
		<html lang="en">
		<head>
		<meta charset="utf-8" />
		<title>Visitas</title>
		<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
		<script type="text/javascript">
			function reCargarPadre(){
				opener.location.reload();
				window.close();
			}
		</script>
		
		<style type="text/css">
			/* jQuery lightBox plugin - Gallery style */
			#titulo_camara {
				background-color: #666;
				color:#FFF;
				padding-left: 30px;
				font-size: 14px;
				text-align:center;
			}
			.botones_cam {
				background-color:#007cbd;
				color:#fff;
				font-family:Lucida Sans;
				font-size:14px;
				font-weight:bold;
				width:90px;
				height:30px;
			}
			.formulario {
				color: #FFF;
			}
			.requerido{
				color: #FFFFFF;
				background-color: #007cbd;
			}
		</style>
		<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
		
		<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
		
		<script type="text/javascript" src="webcam.js"></script>
		
		<script language="JavaScript">
			webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
			webcam.set_quality( 100 ); // calidad de la imagen
			webcam.set_shutter_sound( true ); // Sonido de flash
		</script>
		
		<script language="JavaScript">
			webcam.set_hook( 'onComplete', 'my_completion_handler' );
			
			function show(){
				document.getElementById("subido").style.display="none";
				document.getElementById("subido2").style.display="block";
				do_upload();
			}
			
			function do_upload() {
				// subir al servidor
				document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
				webcam.upload();
			}
			
			function my_completion_handler(msg) {
				
				if (msg.match(/(http\:\/\/\S+)/)) {
					var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
					
					// Muestra la imagen en la pantalla
					document.getElementById('upload_results').innerHTML = 
						'<img src="' + image_url + '" width="320px" height="240px">'+
						'<input type="hidden" name="foto" value="'+image_url+'">'
						;
					// reset camera for another shot
					webcam.reset();
				}
				else alert("PHP Error: " + msg);
			}
		</script>
		
		</head>
		<body>
		<?php
		
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='altaVisitas' method='post' action='altaVisitaPopUp3.php?cd=".$ciudad."&tipo=normal'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Visitas</font>";
					echo"</td>";
				echo"</tr>";
				echo"<tr height='30'> </tr>";
			echo "</table>";
			
			//LINEA
			echo "<table border='0' align='center' width='550'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
			echo "</table>";

			echo "<table border='0' align='center' >";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='titulo2'>";
					echo"<td width='85'>*Gafete: </td>";
					if($gafeteCaptura != ""){
						echo"<td width='100' align='left'><input type='text' size='10' name='gafete' value='".$gafeteCaptura."'></td>";
					} else{
						echo"<td width='100' align='left'><input type='text' size='10' name='gafete' value='".$gafeteCaptura."' class='requerido'></td>";
					}
					
					echo"<td width='70' align='right'>Fecha:<input type='hidden' name='fecha' value='".$hoy."'></td> ";
					echo"<td align='left' id='titulo18' width='120'>".$hoy."</td> ";
					echo"<td align='right'>Hora:<input type='hidden' name='horaEntrada' value='".$horaActual."'></td> ";
					echo"<td align='left' id='titulo18'>".$horaActual."</td> ";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
			echo"</table>";
				
			echo "<table border='0' align='center' >";	
				
				echo"<tr id='titulo2'>";
					if($nombreBusqueda != ""){
						echo"<td align='left'>*Nombre: <input type='text' size='18' name='name' value='".$nombreBusqueda."'></td> ";
					} else{
						echo"<td align='left'>*Nombre: <input type='text' size='18' name='name' value='".$nombreBusqueda."' class='requerido'></td> ";
					}
					if($aPaternoCaptura != ""){
						echo"<td align='center'> <input type='text' size='18' name='apaterno' value='".$aPaternoCaptura."'> </td> ";
					} else{
						echo"<td align='center'> <input type='text' size='18' name='apaterno' value='".$aPaternoCaptura."' class='requerido'> </td> ";
					}
					if($aMaternoCaptura != ""){
						echo"<td align='left'> <input type='text' size='19' name='amaterno' value='".$aMaternoCaptura."'></td> ";
					} else{
						echo"<td align='left'> <input type='text' size='19' name='amaterno' value='".$aMaternoCaptura."' class='requerido'></td> ";
					}
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
			echo"</table>";
			
			echo "<table border='0' align='center' >";
				
				echo"<tr id='titulo2'>";
					echo"<td align='left' >*Empresa: </td> ";
					if($empresaCaptura != ""){
						echo"<td align='left'><input type='text' size='50' name='empresa' value='".$empresaCaptura."'></td> ";
					} else{
						echo"<td align='left'><input type='text' size='50' name='empresa' value='".$empresaCaptura."' class='requerido'></td> ";
					}
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
				
					
				echo"<tr id='titulo2'>";
					echo"<td align='left' >*Persona que visita: </td> ";																
					echo"<td align='left'>";
							
						if($responsableCaptura == ""){
							echo "<select size='1' name='personaVisita' class='requerido'>";
								echo "<option value='' class='requerido'>Seleccionar...</option>";
								
								if($ciudad=="CDMX")
								{
										$query2="SELECT kp_personalId, xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados WHERE xt_ciudad IN  ('CDMX') AND xt_Estatus = 1 ORDER BY xt_nombre ";		
								}
								else
								{
									$query2="SELECT kp_personalId, xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados WHERE xt_ciudad = '".$ciudad."' AND xt_Estatus = 1 ORDER BY xt_nombre ";
								}
								


								$s= $INTRANET->Execute($query2);
								while($r= $s -> fetchRow()){
									echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
									
								} unset($r); unset ($s);
								
							echo"</select>";
								
						} else if($responsableCaptura != ""){
							echo "<select size='1' name='personaVisita'>";
								$nombreResponsable = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Empleados WHERE kp_personalId = $responsableCaptura ");
								$paternoResponsable = $INTRANET->getOne("SELECT xt_ApellidoPaterno FROM SGI_Empleados WHERE kp_personalId = $responsableCaptura ");
								$maternoResponsable = $INTRANET->getOne("SELECT xt_ApellidoMaterno FROM SGI_Empleados WHERE kp_personalId = $responsableCaptura ");
								
								echo"<option value='".$responsableCaptura."' selected>".$nombreResponsable." ".$paternoResponsable." ".$maternoResponsable."</option>";
								
								$s= $INTRANET->Execute("SELECT kp_personalId, xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados ORDER BY xt_nombre ");
								while($r= $s -> fetchRow()){
									echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]." ".$r[3]."</option>";
									
								} unset($r); unset ($s);
								
							echo"</select>";
						}
								
								
					echo"</td> ";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='titulo2'>";
					echo"<td align='left' >*Identificación: </td> ";
					if($identificacionCaptura != ""){
						echo"<td align='left'><input type='text' size='50' name='identificacion' value='".$identificacionCaptura."'></td> ";
					} else{
						echo"<td align='left'><input type='text' size='50' name='identificacion' value='".$identificacionCaptura."' class='requerido'></td> ";
					}
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='titulo2'>";
					echo"<td align='left'>Equipo de computo: </td> ";
					echo"<td align='left'><textarea name='ecomputo' style='width: 315px; height:80px;'>".$equipoCaptura."</textarea></td> ";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='titulo2'>";
					echo"<td align='left'>Placa Vehicular: </td> ";
					echo"<td align='left'><input type='text' size='50' name='placa' value='".$placaCaptura."'></td> ";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";
				
			echo"</table>";
			
			//LINEA
			echo "<table border='0' align='center' width='550'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
				 
		  echo "</form>";
		echo "</div>";
	///INSERTAR COMO USUALMENTE
	}else if(/*($gafeteCaptura != "") && */($nombreBusqueda != "") && ($aPaternoCaptura != "") && ($empresaCaptura != "") && ($responsableCaptura != "") && ($identificacionCaptura != "")){
	
		$gafeteInsert= $_POST['gafete'];
		$fechaInsert = date('Y-m-d', strtotime($_POST['fecha']));
		$horaEntradaInsert = date('H:i:s', strtotime($_POST['horaEntrada']));
		$nombreInsert = $_POST['name'];
		$nombreInsert = ucwords(strtolower($nombreInsert));
		$apaternoInsert = $_POST['apaterno'];
		$apaternoInsert = ucwords(strtolower($apaternoInsert));
		$amaternoInsert = $_POST['amaterno'];
		$amaternoInsert = ucwords(strtolower($amaternoInsert));
		$empresaInsert = $_POST['empresa'];
		$personaVisitaInsert = $_POST['personaVisita'];
		//$departamentoInsert = $_POST['departamento'];
		$identificacionInsert = $_POST['identificacion'];
		$computoInsert = $_POST['ecomputo'];
		$placaInsert = $_POST['placa'];
		$foto = $_POST['foto'];
		
		$queryVisita2 = "INSERT INTO SGI_Visitas";
		if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
			$queryVisita2 = $queryVisita2."_".$ciudad;
		}
		$queryVisita2 = $queryVisita2." (xd_fecha,xt_nombre,xt_apellidoPaterno,xt_empresaRepresenta,kf_personalEncargadoId,xt_horaEntrada,xt_identificacion,kf_usuario,xt_ip,xt_tipoVisita) 				
										VALUES
										('$fechaInsert','$nombreInsert','$apaternoInsert','$empresaInsert','$personaVisitaInsert','$horaEntradaInsert','$identificacionInsert','$usuarioId','$ip','VISITA') ";
		//echo $queryVisita2;								
		if($INTRANET->Execute($queryVisita2)){
		
			//echo"$query";
			//$idVisitaInsert = mysql_insert_id();
			$query = "SELECT MAX(kp_visitaID) FROM SGI_Visitas";
			if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
				$query = $query."_".$ciudad;
			}
			$idVisitaInsert = $INTRANET->getOne($query);
			
			
			if($gafeteInsert != ""){
				$tempo2 = "UPDATE SGI_Visitas";
				if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
					$tempo2 = $tempo2."_".$ciudad;
				}
				$tempo2 = $tempo2." SET xn_credencial= '$gafeteInsert' WHERE kp_visitaID = $idVisitaInsert ";
				
				$INTRANET->Execute($tempo2);
				
			}
			
			if($computoInsert != ""){
				$tempo2 = "UPDATE SGI_Visitas";
				if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
					$tempo2 = $tempo2."_".$ciudad;
				}
				$tempo2 = $tempo2." SET xt_equipoComputo= '$computoInsert' WHERE kp_visitaID = $idVisitaInsert ";
				
				$INTRANET->Execute($tempo2);
				
			}
			
			if($placaInsert != ""){
				$tempo2 = "UPDATE SGI_Visitas";
				if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
					$tempo2 = $tempo2."_".$ciudad;
				}
				$tempo2 = $tempo2." SET xt_placaVehicular= '$placaInsert' WHERE kp_visitaID = $idVisitaInsert ";
				
				$INTRANET->Execute($tempo2);
				
			}
			
			if($amaternoInsert != ""){
				$tempo2 = "UPDATE SGI_Visitas";
				if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
					$tempo2 = $tempo2."_".$ciudad;
				}
				$tempo2 = $tempo2." SET xt_apellidoMaterno= '$amaternoInsert' WHERE kp_visitaID = $idVisitaInsert ";
				
				$INTRANET->Execute($tempo2);
				
			}
			
			header("Location: altaVisitaPopUp3.php?cd=".$ciudad."&captura=OK&idVisita=".$idVisitaInsert."");
			
		} else{
			
			?>
		<!doctype html>
		<html lang="en">
		<head>
		<meta charset="utf-8" />
		<title>Visitas</title>
		<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
		<script type="text/javascript">
			function reCargarPadre(){
				opener.location.reload();
				window.close();
			}
		</script>
		
		<style type="text/css">
			/* jQuery lightBox plugin - Gallery style */
			#titulo_camara {
				background-color: #666;
				color:#FFF;
				padding-left: 30px;
				font-size: 14px;
				text-align:center;
			}
			.botones_cam {
				background-color:#007cbd;
				color:#fff;
				font-family:Lucida Sans;
				font-size:14px;
				font-weight:bold;
				width:90px;
				height:30px;
			}
			.formulario {
				color: #FFF;
			}
			.requerido{
				color: #FFFFFF;
				background-color: #007cbd;
			}
		</style>
		<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
		
		<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
		
		<script type="text/javascript" src="webcam.js"></script>
		
		<script language="JavaScript">
			webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
			webcam.set_quality( 100 ); // calidad de la imagen
			webcam.set_shutter_sound( true ); // Sonido de flash
		</script>
		
		<script language="JavaScript">
			webcam.set_hook( 'onComplete', 'my_completion_handler' );
			
			function show(){
				document.getElementById("subido").style.display="none";
				document.getElementById("subido2").style.display="block";
				do_upload();
			}
			
			function do_upload() {
				// subir al servidor
				document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
				webcam.upload();
			}
			
			function my_completion_handler(msg) {
				
				if (msg.match(/(http\:\/\/\S+)/)) {
					var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
					
					// Muestra la imagen en la pantalla
					document.getElementById('upload_results').innerHTML = 
						'<img src="' + image_url + '" width="320px" height="240px">'+
						'<input type="hidden" name="foto" value="'+image_url+'">'
						;
					// reset camera for another shot
					webcam.reset();
				}
				else alert("PHP Error: " + msg);
			}
		</script>
		
		</head>
		<body>
		<?php
			
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
				
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error al agregar visita!!</font>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
				echo "</table>";
			echo "</div>";
		}
	}
///Fin de la capura normal
} else if((isset($_POST['searchName']) == "") && (isset($_GET['idFound']) == "") && (isset($_GET['tipo']) == "") && ($_GET['captura'] == "OK") && (isset($_GET['insert']) == "")){

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Visitas</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<script type="text/javascript">
    function reCargarPadre(){
        opener.location.reload();
        window.close();
    }
</script>

<style type="text/css">
    /* jQuery lightBox plugin - Gallery style */
    #titulo_camara {
        background-color: #666;
        color:#FFF;
        padding-left: 30px;
        font-size: 14px;
        text-align:center;
    }
    .botones_cam {
        background-color:#007cbd;
        color:#fff;
        font-family:Lucida Sans;
        font-size:14px;
        font-weight:bold;
        width:90px;
        height:30px;
    }
    .formulario {
        color: #FFF;
    }
    .requerido{
        color: #FFFFFF;
        background-color: #007cbd;
    }
</style>
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
 
<script language="JavaScript">
    
    function show(){
        document.getElementById("subido").style.display="none";
        document.getElementById("subido2").style.display="block";
        do_upload();
    }
    
    function do_upload() {
        // subir al servidor
        document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
        webcam.upload();
    }
    
    function my_completion_handler(msg) {
        
        if (msg.match(/(http\:\/\/\S+)/)) {
            var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
            
            // Muestra la imagen en la pantalla
            document.getElementById('upload_results').innerHTML = 
                '<img src="' + image_url + '" width="320px" height="240px">'+
                '<input type="hidden" name="foto" value="'+image_url+'">'
                ;
            // reset camera for another shot
            webcam.reset();
        }
        else alert("PHP Error: " + msg);
    }
</script>

</head>
<body>
<?php
	
	$idVisitaCap = $_GET['idVisita'];
	$visitaFrecuente = isset($_GET['visitaFrecuente']);
	
	echo "<div id='wrapperPopUp'>";
	 echo "<form name='altaVisitas' method='post' action='altaVisitaPopUp3.php?cd=".$ciudad."&captura=OK&idVisita=".$idVisitaCap."&insert=OK'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Visitas</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='30'> </tr>";
		echo "</table>";
		
		//LINEA
		echo "<table border='0' align='center' width='550'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'><input type='hidden' name='visitaFrecuente' value='".$visitaFrecuente."'></td>";
			echo "</tr>";
		echo "</table>";
?>
	<table  border='0' align='center'>


    	<tr>
        	<td align='center'>
                   
            </td>
        </tr>
        <tr>
            <td align='center'>
                
                <!-- Stream video via webcam -->
<div class="video-wrap">
    <video style=" width: 320px; height: 240px; display: block;" id="video" playsinline autoplay></video>
</div>

<!-- Trigger canvas web API -->
<div class="controller">
	<input type=button value="Tomar" id="snap" class="botones_cam" border='0'>

     
</div>

<!-- Webcam video snapshot -->
<canvas id="canvas" style="display: none" width="320" height="240"></canvas>



            </td>
        </tr>
        <tr>
        </tr height='20'></tr>
       	<tr>
            <td width='320' align='center'>
                <div id="upload_results" class="formulario" > </div>
            </td>
      	 </tr>
    </table>
<?php				
		
		//LINEA
		echo "<table border='0' align='center' width='550'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
				 echo ' <input type="hidden" id="foto" name="foto" value="0">';
					echo "<input id='envio'style='display: none' type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
		echo "</table>";
			 
	  echo "</form>";
	echo "</div>";
	
	
} else if((isset($_POST['searchName']) == "") && (isset($_GET['idFound']) == "") && (isset($_GET['tipo']) == "") && ($_GET['captura'] == "OK")  && (isset($_GET['insert']) == "OK")){
	
	$idVisitaCap = $_GET['idVisita'];
	$foto = $_POST['foto'];
	$idPersonal = $_POST['visitaFrecuente'];
		
	
	if($foto != ""){
		$origen = "temporales/".substr($foto, -18);
		$destino = "fotos/".substr($foto, -18);
		//echo "Foto:$foto, Origen:$origen, Destino:$destino.<br>";
		$tempo3 = "UPDATE SGI_Visitas";
		//echo $ciudad;
		if($ciudad != "DF" AND $ciudad != "CMX" AND $ciudad != "CDMX"){
			$tempo3 = $tempo3."_".$ciudad;
		}
		$tempo3 = $tempo3." SET xt_foto= '$destino' WHERE kp_visitaID = $idVisitaCap ";
		
		//echo "$tempo3";
		
		$INTRANET->Execute($tempo3);
		
		copy($origen, $destino);
		
		if($idPersonal != ""){
			$empleados = "../ComunicacionInterna/Personal/FILES/".substr($foto, -18);
			copy($origen, $empleados);
			$guardaEmpleados = "FILES/".substr($foto, -18);
			//echo "GuardaE:$guardaEmpleados<br>";
			//echo"UPDATE SGI_Empleados SET xn_foto = '$guardaEmpleados' WHERE kp_personalId = $idPersonal";
			$INTRANET->Execute("UPDATE SGI_Empleados SET xn_foto = '$guardaEmpleados' WHERE kp_personalId = $idPersonal");
		}
		
		$carpeta = "temporales";
		
		foreach(glob($carpeta."/*") as $archivos_carpeta){
			 
			unlink($archivos_carpeta);
		}
		
		?>
		<!doctype html>
		<html lang="en">
		<head>
		<meta charset="utf-8" />
		<title>Visitas</title>
		<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
		<script type="text/javascript">
			function reCargarPadre(){
				opener.location.reload();
				window.close();
			}
		</script>
		
		<style type="text/css">
			/* jQuery lightBox plugin - Gallery style */
			#titulo_camara {
				background-color: #666;
				color:#FFF;
				padding-left: 30px;
				font-size: 14px;
				text-align:center;
			}
			.botones_cam {
				background-color:#007cbd;
				color:#fff;
				font-family:Lucida Sans;
				font-size:14px;
				font-weight:bold;
				width:90px;
				height:30px;
			}
			.formulario {
				color: #FFF;
			}
			.requerido{
				color: #FFFFFF;
				background-color: #007cbd;
			}
		</style>
		<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
		
		<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
		
		<script type="text/javascript" src="webcam.js"></script>
		
		<script language="JavaScript">
			webcam.set_api_url( 'test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
			webcam.set_quality( 100 ); // calidad de la imagen
			webcam.set_shutter_sound( true ); // Sonido de flash
		</script>
		
		<script language="JavaScript">
			webcam.set_hook( 'onComplete', 'my_completion_handler' );
			
			function show(){
				document.getElementById("subido").style.display="none";
				document.getElementById("subido2").style.display="block";
				do_upload();
			}
			
			function do_upload() {
				// subir al servidor
				document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
				webcam.upload();
			}
			
			function my_completion_handler(msg) {
				
				if (msg.match(/(http\:\/\/\S+)/)) {
					var image_url = RegExp.$1;//respuesta de text.php que contiene la direccion url de la imagen
					
					// Muestra la imagen en la pantalla
					document.getElementById('upload_results').innerHTML = 
						'<img src="' + image_url + '" width="320px" height="240px">'+
						'<input type="hidden" id="foto" name="foto" value="'+image_url+'">'
						;
					// reset camera for another shot
					webcam.reset();
				}
				else alert("PHP Error: " + msg);
			}
		</script>
		
		</head>
		<body>
		<?php
		
		
 		echo "<script type='text/javascript'>reCargarPadre()</script>";
	} else{
		
		?>
		<!doctype html>
		<html lang="en">
		<head>
		<meta charset="utf-8" />
		<title>Visitas</title>
		<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
		<script type="text/javascript">
			function reCargarPadre(){
				//opener.location.reload();
				//window.close();
			}
		</script>
		
		<style type="text/css">
			/* jQuery lightBox plugin - Gallery style */
			#titulo_camara {
				background-color: #666;
				color:#FFF;
				padding-left: 30px;
				font-size: 14px;
				text-align:center;
			}
			.botones_cam {
				background-color:#007cbd;
				color:#fff;
				font-family:Lucida Sans;
				font-size:14px;
				font-weight:bold;
				width:90px;
				height:30px;
			}
			.formulario {
				color: #FFF;
			}
			.requerido{
				color: #FFFFFF;
				background-color: #007cbd;
			}
		</style>
		<script type="text/javascript" src="jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="jquery.lightbox-0.5.js"></script>
		
		<link rel="stylesheet" type="text/css" href="jquery.lightbox-0.5.css" media="screen" />
		
		 
		
		</head>
		<body>
		<?php
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
			
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error al agregar visita!!!</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
			echo "</table>";
		echo "</div>";

	}
}
?>
 
</body>
<script src="script.js"></script>
</html>
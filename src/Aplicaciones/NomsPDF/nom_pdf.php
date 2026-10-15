<?php
$nombrephp = 'nom_pdf.php';
include('../../Librerias/tcpdf/tcpdf.php');
include('../../Librerias/fpdi/fpdi.php');
require_once("../../conexionLaredo.php");
//date_default_timezone_set('America/Chicago');

//zend_loader_install_license('../../Librerias/fpdi/.htFPDI_PDF-Parser.zl', true);

	class concat_pdf extends FPDI {

	    var $files = array();

	    function setFiles($files) {
	        $this->files = $files;
	    }

	    function concat() {
	        foreach($this->files AS $file) {
	            $pagecount = $this->setSourceFile($file);
	            for ($i = 1; $i <= $pagecount; $i++) {
					$tplidx = $this->ImportPage($i);
	                 $s = $this->getTemplatesize($tplidx);
	                 $this->AddPage('P', array($s['w'], $s['h']));
	                 $this->useTemplate($tplidx);
	            }
	        }
	    }
	}

?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
		$estiloUsuario = $_GET['est'];
		if($estiloUsuario == 1){
			echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
		}else if($estiloUsuario == 2){
			echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
		}
	?>

<!--
<link href="css/style.css" rel="stylesheet" type="text/css" />
-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>NOMS PDF</title>
    <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.7.1.min.js"></script>
    <script>
		function updateSize(newValue) {
			var progressBar = document.getElementById('progressBar');
			progressBar.max = newValue;
			progressBar.value = 0;
			var infoProgress = document.getElementById('infoProgress')
			infoProgress.getElementsByTagName('span')[0].textContent = 0;
			infoProgress.getElementsByTagName('span')[1].textContent = newValue;
	  	}
		function updateProgress(newValue) {
			var progressBar = document.getElementById('progressBar');
			progressBar.value = newValue;
			var infoProgress = document.getElementById('infoProgress')
			infoProgress.getElementsByTagName('span')[0].textContent = newValue;
	  	}
		function ocultaProgreso() {
			var infoProgress = document.getElementById('infoProgress');
			infoProgress.style.visibility="hidden";
	  	}
		function muestraProgreso() {
			var infoProgress = document.getElementById('infoProgress');
			infoProgress.style.visibility="visible";
	  	}
		function cambiaIframeUrl(url) {
			var iframe = document.getElementById('frameDescargas');
			iframe.src = url;
		}
		window.addEventListener("message", function(e){
			var valor = e.data.split("-");
			muestraProgreso();
			if(valor[0] == 'size'){
				updateSize(valor[1]); 
			}else if(valor[0] == 'elemento'){
				updateProgress(valor[1]); 
			}else if(valor[0] == 'oculta'){
				ocultaProgreso(); 
			}
		}, false);
		/*
		window.onmessage = function(e){
		  var infoProgress = document.getElementById('infoProgress');
		  infoProgress.style.visibility="visible";  
		  document.getElementsByTagName('span')[0].innerHTML = e.origin + " said: " + e.data;
		};
		*/
	</script>
</head>

<body>
<?php

$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a><a href='https://escalante.com.mx/INTRANET_GEA/Aplicaciones/aplicaciones.php' id='breadcrumbs'>Módulos /</a><a href='https://escalante.com.mx/INTRANET_GEA/Aplicaciones/operaciones.php' id='breadcrumbs'>Operaciones</a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' name='Encabezado'>";//Encabezado
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Nom PDF</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
				$currentDir 	=  getcwd();
				$directorios 	= explode('/',$currentDir);
				
				$bandera 	= 0;
				$cuentaDir	= 0;
				
				for($o = 0; $o < count($directorios); $o++){
					
					if($directorios[$o] == "INTRANET_GEA"){
						
						$bandera = 1;
						
					}
					
					if(($bandera == 1) && ($directorios[$o] != "INTRANET_GEA")){
						
						$cuentaDir++;
						
					}
					
				} unset($o); unset($bandera);
				
				$subirDir = "";
				
				for($o = 1; $o <= $cuentaDir; $o++){
					
					$subirDir = $subirDir."../";
					
				} unset($o);
				
				echo "SUBDIR: $subirDir, CUENTADIR: $cuentaDir";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='70'> </tr>";
	echo "</table>";
    
  		
if($_POST['referencia'] == ''){                           	
	echo '<FORM ACTION="nom_pdf.php" METHOD="POST">';
		echo '<table border="0" align="center">';
			echo'<tr>';
				echo '<td id="titulo12" align="center">Referencia</td>';
			echo'</tr>';
			echo"<tr height='10'></tr>";
			echo'<tr>';
				echo '<td align="center"><INPUT TYPE="text" NAME="referencia" size="20"></td>';
			echo'</tr>';
			echo"<tr height='15'></tr>";
			echo'<tr>';
				echo "<td align='right'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'></td>";
			echo'</tr>';
		echo '</table>';
	echo '</FORM>';

} else if($_POST['referencia'] != ''){
	
	$referancia=trim($_POST['referencia']);
	//echo "REF:$referancia<br>";
	
	$ip='71.144.19.155';
	$port='1515';
	$timeout='10';
	$un='anonymous';
	$pw='anonymous';
	// Connect to ftp
	$conn_id = ftp_connect($ip, $port, $timeout);
	// Open a session to an external ftp site
	$login_result = ftp_login ($conn_id, $un, $pw);
	// Check open
	if ((!$conn_id) || (!$login_result)) {
		echo "FTP connection failed!";
		exit();
	}
	
	$indice = 0;
	$scfirmas[$indice] = " ";
	
	$local_filePrimero = "";	
	$consulta= $SCIA-> Execute("
	SELECT SCFIRMA FROM PEDIMENTO.PERMISOS WHERE REFERENCIA ='$referancia' AND CLAVE ='NM' 
	AND SCFIRMA IS NOT NULL ORDER BY REGISTRO ASC  ");
	
	while($r=$consulta->FetchRow()){
		$tempo = trim($r[0]);
		$tempo = str_replace("/", "", $tempo).".pdf";
		
		if(in_array($tempo, $scfirmas) != true){
			$scfirmas[$indice] = $tempo;
			$indice++;
		}
	}


	echo '<div id="infoProgress" style="visibility:visible;" align="center">';
		echo "<table>";
			echo "<tr>";
				echo '<td align="center">';
					echo "Progress: <br><br>"; 
					echo '<progress id="progressBar" value=0 max='.count($scfirmas).' style="height:5px; background-color:#fff; "></progress> <br>';
					echo "<span>0</span> / <span>".count($scfirmas)."<span>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	echo "</div>";

	$descargados = null;
	for($i = 0; $i < count($scfirmas); $i++){
		$local_filePrimero = "tempo".$i.".pdf";
		$handle = fopen($local_filePrimero, 'w');
		$remote_file = $scfirmas[$i];
		if (ftp_fget($conn_id, $handle, $remote_file, FTP_BINARY, 0)) {	
			//echo "Se ha escrito satisfactoriamente sobre $local_filePrimero\n";
		} else {
			echo "Ha habido un problema durante la descarga de $scfirmas[$i].pdf \n";
		}
		fclose($handle);
		$decargados[$i] = $local_filePrimero;
		//echo "Descargado: $local_filePrimero<br>";
		if($i < (count($scfirmas)-1)){
			echo "<script>";
				echo "updateProgress($i + 1);";
			echo "</script>";
		}
	}
	
	ftp_close($conn_id);
	
	$pdf =& new concat_pdf();
	$pdf->setFiles($decargados);
	$pdf->concat();
	$pdf->Output("NOMS_".$referancia.".pdf", 'F');
	
	
	for($o = 0; $o < count($decargados); $o++){
		$eliminar = $decargados[$o];
		//echo "eliminando :".$eliminar."\n";
		unlink($eliminar);
	}
	echo "<script>";
		echo "updateProgress($i + 1);";
	echo "</script>";
	
	echo "<script>";
		echo "ocultaProgreso();";
	echo "</script>";
	echo "<table align='center'><tr align='center'><td id='iconosTexto' width='100' align='left'>";
	//<a href='download.php?file=NOMS_".$referancia.".pdf'> 
	echo "NOMS_".$referancia.".pdf </td><td width='25' align='right'>
			<a href='download.php?file=NOMS_".$referancia.".pdf'><img src='../../Imagenes/ICN_Archivo.png' width='12' height='15'></a>";
	echo "</td></tr></table>";
	
			
}
echo '</div>'; //termina wrapper
?>
</body>
</html>

<?php error_reporting(0); ?>
<?php

/*$nombrephp = 'altaVisitaPopUp2.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");*/

//echo "tipo: ".$_GET['tipo'].", name: ".$_POST['searchName'].", id: ".$_GET['idFound']."<br>";
date_default_timezone_set('America/Mexico_City');
$hoy = date("d-m-Y");
$horaActual = date('H:i:s');
//$horaActual = date('H:i:s',time() + 2460 );

///OBTENER LA CIUDAD A LA QUE SE VA A AGREGAR LA VISITA


function eliminar_caracteres_especiales($s) {
	
	$s = ereg_replace("á","Ã¡",$s);
	$s = ereg_replace("Á","Ã",$s);
	$s = ereg_replace("é","Ã©",$s);
	$s = ereg_replace("É","Ã‰",$s);
	$s = ereg_replace("í","Ã­",$s);
	$s = ereg_replace("Í","I",$s);
	$s = ereg_replace("ó","Ã³",$s);
	$s = ereg_replace("Ó","Ã“",$s);
	$s = ereg_replace("ú","Ãº",$s);
	$s = ereg_replace("Ú","Ãš",$s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
}



?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
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

<script type="text/javascript" src="webcamFP.js"></script>

<script language="JavaScript">
    webcam.set_api_url( 'sube_foto_previo_tmp.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
    webcam.set_quality( 100 ); // calidad de la imagen
    webcam.set_shutter_sound( true ); // Sonido de flash
</script>

<script language="JavaScript">
	
	Webcam.set({
    force_flash: false
	});
    webcam.set_hook( 'onComplete', 'my_completion_handler' );
	
	
    
    function show(){
        document.getElementById("subido").style.display="none";
        document.getElementById("subido2").style.display="block";
        do_upload();
    }
    
	
	function capturaFoto(){
		
		if(webcam.freeze() == true){
			webcam.upload();
		}else{
			
			alert ("no subio");
		}
			
		//document.getElementById('upload_results').innerHTML = '<p id="iconosTexto" align="center">Cargando al servidor...</p>';
        //webcam.upload();
		
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
	$visitaFrecuente = $_GET['visitaFrecuente'];
	
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='altaVisitas' method='post' action='ejemplo_foto_liz.php?fotos='OK'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font></font>";
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
                    <table border='0'>
                        <tr>
                            <td><input type=button value="Configurar" onClick="webcam.configure()" class="botones_cam" border='0'></td>
                            <td><input type=button value="Tomar foto" onClick="capturaFoto()" class="botones_cam" border='0'></td>
                            <td><input type=button value="Subir" onClick="do_upload()" class="botones_cam" border='0'></td>
                            <td><input type=button value="Reset" onClick="webcam.reset()" class="botones_cam" border='0'></td>
                        </tr>
                    </table>
            </td>
        </tr>
        <tr>
            <td width='320' align='center'>
                <script language="JavaScript">
                    document.write( webcam.get_html(320, 240) );//dimensiones de la camara
                </script>
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
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
		echo "</table>";
			 
	  echo "</form>";
	echo "</div>";
	
	
	
 if($_GET['fotos'] == "OK"){
	
	$foto = $_POST['foto'];
	
	if($foto != ""){
		$origen = "temporales/".substr($foto, -18);
		$destino = "fotos/".substr($foto, -18);
		//echo "Foto:$foto, Origen:$origen, Destino:$destino.<br>";
		$tempo3 = "UPDATE SGI_Visitas";
		if($ciudad != "DF"){
			$tempo3 = $tempo3."_".$ciudad;
		}
		$tempo3 = $tempo3." SET xt_foto= '$destino' WHERE kp_visitaID = $idVisitaCap ";
		
		$INTRANET->Execute($tempo3);
		
		copy($origen, $destino);
		
		if($idPersonal != ""){
			$empleados = "../ComunicacionInterna/Personal/FILES/".substr($foto, -18);
			copy($origen, $empleados);
			$guardaEmpleados = "FILES/".substr($foto, -18);
			//echo "GuardaE:$guardaEmpleados<br>";
			$INTRANET->Execute("UPDATE SGI_Empleados SET xn_foto = '$guardaEmpleados' WHERE kp_personalId = $idPersonal");
		}
		
		$carpeta = "temporales";
		
		foreach(glob($carpeta."/*") as $archivos_carpeta){
			 
			unlink($archivos_carpeta);
		}
		
	}
 }

?>
</body>
</html>
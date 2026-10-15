<?php

$nombrephp = 'fichaAcuerdo.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
require_once("../../AdministracionProyectos/_PPM/proyectoSQL.php");

error_reporting(E_PARSE);
$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			 <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='../ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos / </a>
			 <a href='tableroReunionesv2.php' id='breadcrumbs'> Tablero de Reuniones </a>";
	
//CUERPO REUNION
$codigoReunion = $_GET['id'];
if($_GET['end'] == 1){	
	$INTRANETV2->Execute("UPDATE SGI_Reuniones SET xn_status = 2 WHERE xt_codigoReunion = '$codigoReunion' ");
}

$sql=$INTRANETV2->Execute("SELECT * FROM SGI_Catalogo_Reuniones");
$iR=0;
while ($r = $sql->fetchRow()) {
	$reunionTipoValor[$iR] = $r[0];
	$reunionTipoShow[$iR] = $r[1];
	$iR++;
}

$sqlTemas=$INTRANETV2->Execute("SELECT xt_tema FROM SGI_Catalogo_Temas_Reuniones");
$iT=1;
while ($r = $sqlTemas->fetchRow()) {
	$temasReunion2[$iT] = $r[0];
	$iT++;
}

$s = $INTRANETV2->Execute("SELECT xt_codigoReunion, xn_status, xd_fecha, xt_tipo, xt_ciudad, xt_grupo, xt_descripcion FROM SGI_Reuniones WHERE xt_codigoReunion = '$codigoReunion' ");



while($r = $s->fetchRow()){
	
	$reunion 	= $r[0];
	$status 	= $r[1];
	$fecha 		= date('Y-m-d', strtotime($r[2]));
	$tipo 		= $r[3];
	
	if(		 $status == 1){
		
		$status = 'Programada';
		
	}else if ($status== 2){
		
		$status = 'Realizada';
		
	}else if ($status== 3){
		
		$status = 'Cancelada';
	}
	
	for($a = 1; $a <= 7; $a++){
		
		if($reunionTipoValor[$a] == $tipo){
			
			$tipo = $reunionTipoShow[$a];
		}
		
	}
	
	$ciudadReunion = $r[4];
	
	if($ciudadReunion == ""){
		
		$ciudadReunion = "GRAL";
		
	}
	
	$grupoReunion = $r[5];
	$descripcionReunion = $r[6];
	//$diaSemana = date('w', strtotime($r[4]));	
} unset($s); unset($r);


if(($_POST['fechaAcuerdo'] != "") && ($_POST['tituloAcuerdo'] != "")){

	function limpiar_caracter_especial($string){

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
	

	$fechaAcuerdo       		= date('Y-m-d', strtotime($_POST['fechaAcuerdo']));
	$horaActual                 = date ("H:i:s");
	$tituloAcuerdoInsert 		= $_POST['tituloAcuerdo'];
	$descripcionAcuerdoInsert 	= $_POST['descripcionAcuerdo'];
	$fechaAcuerdoInsert         = $fechaAcuerdo." ".$horaActual;
		
	
	$anio = date('Y', strtotime($_POST['fechaAcuerdo']));
		
		$maximo = 0;
		
		$s = $INTRANETV2->Execute("SELECT MAX(SUBSTRING_INDEX(xt_codigoAcuerdo,'-',-1)) as MAXIMO FROM SGI_Acuerdos WHERE YEAR(xd_fecha) = $anio AND xt_ciudad = '$ciudadReunion' AND xt_grupo = '$grupoReunion' ");
		
		while($r = $s->fetchRow()){
			
			$maximo = $r[0];
			
		} unset($r); unset($s);
		
		$maximo++;
		
		$anio = date('y', strtotime($_POST['fechaAcuerdo']));
		
		if(strlen($maximo) == 1){
			
			$codigo = $grupoReunion."-A-".$ciudadReunion."-".$anio."-00".$maximo;
			
		} else if(strlen($maximo) == 2){
			
			$codigo = $grupoReunion."-A-".$ciudadReunion."-".$anio."-0".$maximo;
			
		} else if(strlen($maximo) >= 3){
			
			$codigo = $grupoReunion."-A-".$ciudadReunion."-".$anio."-".$maximo;
			
		}
		if($INTRANETV2->Execute("INSERT INTO SGI_Acuerdos (xt_codigoAcuerdo, xt_titulo, xt_descripcion, xd_fecha, xt_usuario, xt_ciudad, xt_grupo, xt_status) 
								VALUES ('$codigo', '$tituloAcuerdoInsert', '$descripcionAcuerdoInsert','$fechaAcuerdoInsert', '$usuarioId', '$ciudadReunion', '$grupoReunion','ABIERTO') ")){
			
			$INTRANETV2->Execute("INSERT INTO SGI_Acuerdos_Reunion (xt_codigoAcuerdo, xt_codigoReunion) VALUES ('$codigo','$codigoReunion')");
			


			$archivo = $_FILES['archivo']['name'];
			$archivo = limpiar_caracter_especial($archivo);
			if ($_FILES['archivo']["error"] > 0)
			{
				echo "Error: " . $_FILES['archivo']['error'] . "<br>";
			}
			else
			{		
				if ($archivo != ""){

					$destino = "../AcuerdoArchivos/".$archivo;

					if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){

						$string  ="UPDATE SGI_Acuerdos SET xt_ruta = '$archivo' WHERE xt_codigoAcuerdo = '$codigo' ";
						if($INTRANETV2->Execute($string)){

							//header("Location: fichaReunion.php?id=$quejaID");

						}
					}
				}
			}
		}

	
//	header("Location: fichaReunionv2.php?id=$id");
	
}


$indice = 0;
$codigoAc 	= NULL;
$tituloAc 	= NULL;
$fechaAc 	= NULL;
//$acuerdoID 	= NULL;
	
$s = $INTRANETV2->Execute("SELECT
	AR.xt_codigoAcuerdo,
	A.xt_titulo,
	A.xd_fecha,
	A.xt_status,
	(SELECT CONCAT(E.xt_Nombre,' ',E.xt_ApellidoPaterno) FROM SGI_Empleados E WHERE E.kf_usuario = A.xt_pdr LIMIT 1) as nombre
FROM
	SGI_Acuerdos_Reunion AR,
	SGI_Acuerdos A
WHERE
	AR.xt_codigoReunion = '$codigoReunion'
AND AR.xt_codigoAcuerdo = A.xt_codigoAcuerdo");

while($r = $s->fetchRow()){
	
	$codigoAc[$indice] 	= $r[0];
	$tituloAc[$indice] 	= $r[1];
	$fechaAc[$indice] 	= $r[2];
	//$acuerdoID[$indice] = $r[3];
	$estatus[$indice] = $r[3];
	$pdrA[$indice]    = $r[4];	
	$indice++;
	
} unset($r); unset($s);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Ficha Reunión</title>
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

			function muestra_ocultaDiv(divMostrar, divOcultar){
				if (divMostrar!='') {
				var mostrar = document.getElementById(divMostrar);
					if(mostrar.style.display == 'block'){
						mostrar.style.display = 'none';
					}else{
						mostrar.style.display = 'block';
					}
				}

				if (divOcultar!='') {
				var ocultar = document.getElementById(divOcultar);
					if(ocultar.style.display == 'block'){
						ocultar.style.display = 'none';
					}else{
						ocultar.style.display = 'block';
					}
				}
			}

			function agregaProyectoReunion(reunion) {

				var codigoProyecto = document.getElementById("nuevoProyecto").value;
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						if(xhttp.responseText == true){
							location.reload();
						}else{
							alert(xhttp.responseText);
						}
					}
				};

				xhttp.open("POST", "modificaInformacion.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("evento=agregaProyectoReunion&codigoProyecto="+ codigoProyecto +"&reunion="+ reunion);
			}

			function eliminaProyectoReunion(reunion,idProyecto) {

				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						if(xhttp.responseText == true){
							location.reload();
						}else{
							alert(xhttp.responseText);
						}
					}
				};

				xhttp.open("POST", "modificaInformacion.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("evento=eliminaProyectoReunion&idProyecto="+ idProyecto +"&reunion="+ reunion);
			}
			</script>
           
            <script>
				function show(valor){
					if(valor == 1){
						document.getElementById("formularioAcuerdo").style.display="block";
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
						
					} else if (valor == 0){
						document.getElementById("formularioAcuerdo").style.display="none";
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					}
				}
			</script>
            <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet"/>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
            <script type="text/javascript">;
                $(function(){
                    $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                     monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                     dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                    
                     });
                });
            </script>
        </head>
        
        <body>
<?php
	
echo "<div id='wrapperFicha' align='center'>";
  	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
  	 echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
        echo "</tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs'>Fecha: ".$fecha."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Reunión";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
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
		
		//echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
				
	//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";
			
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b>".$reunion."</b></td>";
			echo "<td align='right' id='iconosTexto2'>Status: <b>$status</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
				
	echo "</table>";
	echo "<table border='0' align='center' width='700px'>";
				
		echo "<tr height='20'><td colspan='2'></td></tr>";
		
		echo "<tr id='iconosTexto'>";
			echo "<td width='20'></td>";
			echo "<td align='left'><b>".$tipo."</b></td>";
		echo "</tr>";
	
	echo "</table>";
			
	echo "<table border='0' align='center' width='800px'>";
			
		echo "<tr height='10'><td colspan='2'></td></tr>";
			
		echo "<tr id='iconosTexto'>";
			echo "<td width='30'></td>";
			echo "<td colspan=2 align='left'>".$descripcionReunion."</td>";
		echo "</tr>";
		
		echo "<tr height='30'><td colspan='2'></td></tr>";
	
	echo "</table>";
	
	
	
//1. ASISTENCIA
	echo "<table border='0' align='center' width='800'>";
		echo "<tr id='titulo2'>";
			echo "<td align='left'><b>1. Asistencia</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3'></td>";
		echo "</tr>";		
	echo "</table>";
		
	echo "<table border='0' align='center' width='660px'>";
		echo "<tr height='20px'><a name='listaAsistencia'></a> </tr>";
	
		$indice = 1;
		$idPersonal 	= NULL;
		$nombreCorto 	= NULL;
			
		$s = $INTRANETV2->Execute("SELECT DISTINCT
									EMP.kf_usuario,
									EMP.xt_nombreCorto
								FROM
									IntranetGEA.SGI_Empleados EMP, 
									INTRANET2.SGI_Reunion_Asistentes REA
								WHERE		
									 
								  EMP.kf_usuario = REA.xt_usuario
								AND REA.xt_codigoReunion = '$codigoReunion'
								ORDER BY
									EMP.xt_Nombre ");

			
		
		while($r = $s->fetchRow()){
			
			$idPersonal[$indice] 	= $r[0];
			$nombreCorto[$indice] 	= trim($r[1]);
			
			$indice++;
			
		} unset($r); unset($s); unset($indice);
		
		$cuenta = count($idPersonal);
		
		$filas = ceil($cuenta/4);
		$celdas = 0;
	
		if((($cuenta%4)/4) == 0.25){
			$celdas = 1;
			
		} else if((($cuenta%4)/4) == 0.5){
			$celdas = 2;
			
		} else if((($cuenta%4)/4) == 0.75){
			$celdas = 3;
			
		} else if(($cuenta%4) == 0){
			$celdas = 4;
			
		}
		
		$i = 1;
		
		for($a = 1; $a <= $filas; $a++){
			
			echo "<tr>";
			
			for($e = 1; $e <= 4; $e++){
				
					echo "<td width='165px' id='fileItem'>".$nombreCorto[$i]."</td>";
				
				$i++;
				
				if($i > $cuenta){
					break;
				}
				
			}
			
			if(($filas == $a) && ($celdas == $e)){
				
				if($celdas == 1){
					echo "<td width='165px'></td>";
					echo "<td width='165px'></td>";
					echo "<td width='165px'></td>";
					
				} else if($celdas == 2){
					echo "<td width='165px'></td>";
					echo "<td width='165px'></td>";
					
				} else if($celdas == 3){
					echo "<td width='165px'></td>";
					
				}
				
				break;
			}
			
			echo "</tr>";
			
		}
	
	echo "</table>";
				
	
	//ELEMENTOS
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr height='50px'><td colspan='4'></td></tr>";

		echo "<tr>";
			echo "<td id='titulo2' colspan='4'><b> 2. Temas a tratar</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='4'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td colspan='4'></td></tr>";
		
		//echo"SELECT xt_subElemento, xt_texto FROM SGI_Elemento_Reunion WHERE kf_reunionID = $id AND xn_numElemento = 2 ORDER BY xt_subElemento";
		$s = $INTRANETV2->Execute("SELECT xn_numeroTema, xt_texto, xt_ruta FROM SGI_Reunion_Temas WHERE xt_codigoReunion = '$codigoReunion' ORDER BY xn_numeroTema");	
			
		while($r = $s->fetchRow()){
			
			$subElemento 		= $r[0];
			$textoSubElemento 	= nl2br($r[1]);
			$rutaTema           = $r[2];
		
			echo "<tr>";
				echo "<td></td>";
				
				echo "<td id='iconosTexto' colspan='2'>";
					echo "<a name='2_".$subElemento."' id='iconosTexto'>";
						echo "<b>".$temasReunion2[$subElemento]."</b>";
					echo "</a>";
				echo "</td>";
				
				echo "<td></td>";
			echo "</tr>";
			
			if($rutaTema != ''){
				
				echo "<tr>";
					echo "<td colspan='2'></td>";
					
					echo "<td id='textIntro' colspan='2'>";
						echo "<i>".$rutaTema."</i> ";
						echo "<a href='../downloadReunion.php?file=".$rutaTema."' >";
							echo "<img src='../../Imagenes/ICN_Archivo.png'>";
						echo "</a>";
					echo "</td>";
					
				echo "</tr>";
			}
				
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";
		
			echo "<tr>"; 
				echo "<td width='20px'></td>"; 
				echo "<td width='15px' align='right'></td>"; 
				echo "<td width='615px' align='justify' id='fileItem'>".$textoSubElemento."</td>"; 
				echo "<td width='50px'></td>"; 
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			
		} unset($u); unset($r); unset($s);
		
	echo "</table>";
	
	$valor = "";

	//proyectos relacionados
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr height='50px'><td colspan='3'></td></tr>";

		echo "<tr>";
			echo "<td id='titulo2'><b>3. Proyectos relacionados</b></td>
				  <td align='right'>";

		if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Gerardo_Martinez') || ($usuarioId == 'Antonio_Astorga') || ($usuarioId == 'cozy') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Ricardo_Garcia') ||($usuarioId == 'sdelap')|| ($usuarioId == 'Elena_Hernandez') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Eibar_Ponce') || ($usuarioId == 'Adlemy_Tah')){

			echo "<img id='' onclick=\"muestra_ocultaDiv('nuevoProyectoReunion','')\" src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' style='cursor:pointer;'>";

		}

			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3'></td>";
		echo "</tr>";
	echo "<tr height='10px'><td colspan='4'></td></tr>
	</table>";

    $proyectos = $INTRANETV2->GetArray("SELECT
											*
										FROM
											SGI_Reuniones_Proyectos RP
										INNER JOIN SGI_Portafolio_Proyectos P ON P.xn_proyectoId = RP.xn_proyectoId
										WHERE
											RP.xt_codigoReunion = '$codigoReunion'");

    $sql = proyectoSQL::obtenProyectosExistentes();
    $proyectosArray = $INTRANETV2->GetArray($sql);

    echo "
    <table id='nuevoProyectoReunion' align='left' style='margin-left:5%; display:none;'>
    	<tr>
    		<td align='center' id='iconosTexto2'>Nuevo proyecto</td>
    	</tr>
    	<tr>
    		<td>

    		<select id='nuevoProyecto'>";

    		foreach ($proyectosArray as $key => $proyecto) {
    			echo "<option value='".$proyecto["xt_codigoProyecto"]."'>".$proyecto["xt_codigoProyecto"]."</option>";
    		}

    		echo "
    		</select>

    		<button onclick=\"agregaProyectoReunion('".$codigoReunion."')\">Enviar</button></td>
    	</tr>
    </table>

    <table align='left' border='0' width='800px' style='margin-left:5%; margin-top:3%;'>";

    if (count($proyectos) > 0) {
	    foreach ($proyectos as $key => $proyecto) {
	        echo "<tr>
	                <td align='left' width='15%'>
	                <img style='cursor:pointer;' onclick=\"eliminaProyectoReunion('".$codigoReunion."','".$proyecto["xn_proyectoId"]."')\" src='../../Imagenes/ICN_NoOK.png' height='12' width='12'>
	                <a id='fileItem' style='text-decoration: none;' href='../../AdministracionProyectos/_PPM/D05_fichaProyecto.php?idProyecto=".$proyecto["xn_proyectoId"]."'>".$proyecto["xt_codigoProyecto"]."  ".$proyecto["xt_nombreProyecto"]."</a></td>
	            </tr>";
	    }
    }else{
        echo "<tr>
            <td align='left' width='15%'>Sin proyectos relacionados.</td>
        </tr>";	
    }

    echo "</table>";

		//3 Resultados de la revision
		echo "<table border='0' align='center' width='800px'>";
			echo "<tr height='50px'><td colspan='3'></td></tr>";
	
			echo "<tr>";
				echo "<td id='titulo2' colspan='4'><b>4. Resultados de la revisión</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
		echo "<tr height='20px'><td colspan='4'></td></tr>";
		
		$s = $INTRANETV2->Execute("SELECT xt_texto, xt_ruta FROM SGI_Reunion_Revisiones WHERE xt_codigoReunion = '$codigoReunion' ");		
			
		while($r = $s->fetchRow()){
			
			$textoSubElemento 	= nl2br($r[0]);
			$rutaRevision       = $r[1];
			
		//
			if($rutaRevision != ''){
				echo "<tr>";
					echo "<td colspan='2'></td>";
					
					echo "<td id='textIntro' colspan='2'>";
						echo "<i>".$rutaRevision."</i> ";
						echo "<a href='../downloadReunion.php?file=".$rutaRevision."' >";
							echo "<img src='../../Imagenes/ICN_Archivo.png'>";
						echo "</a>";
					echo "</td>";
					
				echo "</tr>";
				
			}
			
			echo "<tr height='10px'><td colspan='4'></td></tr>";
		
			echo "<tr>"; 
				echo "<td width='20px'></td>"; 
				echo "<td width='15px' align='right'></td>"; 
				echo "<td width='615px' align='justify' id='fileItem'>".$textoSubElemento."</td>"; 
				echo "<td width='50px'></td>"; 
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			
		} unset($u); unset($r); unset($s);
			
		//ACUERDOS
		echo "<table border='0' align='center' width='800px'>";
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>5. Acuerdos   </b></td>";
			
				echo "<td align='right'>";
				if($status != 'Cancelada'){
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Gerardo_Martinez')
					|| ($usuarioId == 'Antonio_Astorga') || ($usuarioId == 'cozy') || ($usuarioId == 'Daniel_Guadarrama') 
					|| ($usuarioId == 'Ricardo_Garcia') ||($usuarioId == 'sdelap')|| ($usuarioId == 'Elena_Hernandez') 
					|| ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Eibar_Ponce') || ($usuarioId == 'Adlemy_Tah')){

						echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(1);' id='mostrar' style='display:block;'>";
						echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15' onclick='show(0);' id='ocultar' style='display:none;'>";

					}
				}

				echo "</td>";

			echo "</tr>";

			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";

			echo "<tr height='20'><td colspan='2'></td></tr>";
		echo "</table>";

	if(count($codigoAc) >= 1){	
		

		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='right' width='15px'></td>";
				echo "<td align='center'  id='iconosTexto2'>Código</td>";
				echo "<td align='left' id='iconosTexto2'>Titulo</td>";
				echo "<td align='left' id='iconosTexto2'>Estatus</td>";
				echo "<td align='left' id='iconosTexto2'>PDR</td>";
				echo "<td align='center' id='iconosTexto2'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspna='3'></td></tr>";
				
			for($a = 0; $a <= count($codigoAc); $a++){
				
				echo "<tr>";
					echo "<td align='right' width='15px'></td>";
					echo "<td width='110px' align='center' valign='top'>";
						echo "<a href='fichaAcuerdov2.php?acuerdo=".$codigoAc[$a]."' id='fileItem' style='text-decoration:none;'>".$codigoAc[$a]."</a>";
					echo "</td>";
					
					echo "<td align='left' width='300px' id='fileItem' valign='top'>".$tituloAc[$a]."</td>";
					echo "<td align='left' width='90px' id='fileItem' valign='top'>".$estatus[$a]."</td>";
					echo "<td align='left' width='120px' id='fileItem' valign='top'>".$pdrA[$a]."</td>";
					echo "<td align='center' width='120px' id='fileItem' valign='top'>".$fechaAc[$a]."</td>";
				echo "</tr>";
				
				echo "<tr height='10px'> </tr>";
					
			} unset($a);
		
		echo "</table>";
	}
	
echo "<form method='post' action='fichaReunionv2.php?id=".$codigoReunion."' enctype='multipart/form-data'>";
echo '<table border="0" align="center" width="500px" id="formularioAcuerdo" style="display:none;">
		<tbody>
			<tr>
				<td id="titleBlueLineTop" colspan="3"></td>
			</tr>
			<tr height="15px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2 align="left">Fecha</td>
				<td id="iconosTexto2 align="left">Grupo</td>
				<td id="iconosTexto2 align="left">Ciudad</td>
			</tr>
			<tr>
				<td width="150px">
					<input id="dp1435765604156" class="DatP" name="fechaAcuerdo" size="10" type="text">
					<input name="tipo" value="solicitud" type="hidden">
				</td>
				<td width="140px">
						<input type="text" value="'.$grupoReunion.'" name="grupoAcuerdo" disabled>
				</td>
				<td width="160px">
					<input type="text" value="'.$ciudadReunion.'" name="ciudadAcuerdo" disabled>
				</td>
			</tr>
			<tr height="20px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2 align="left" colspan="3">Título</td>
			</tr>
			<tr>
				<td colspan="3">
					<input name="tituloAcuerdo" size="66" type="text">
				</td>
			</tr>
			<tr height="20">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2 align="left" colspan="3">Descripción</td>
			</tr>
			<tr>
				<td colspan="3">
					<textarea name="descripcionAcuerdo" style="width:438px; height:100px;"></textarea>
				</td>
			</tr>
			<tr height="20px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="iconosTexto2" colspan="3" align="left">Seleccione un archivo:</td>
			</tr>
			<tr>
				<td colspan="3">
					<input name="archivo" type="file">
				</td>
			</tr>
			<tr height="15px">
				<td colspan="3"></td>
			</tr>
			<tr height="40px">
				<td colspan="3" align="right" valign="bottom">
					<input src="../Imagenes/ICN_BotonEnviar.png" type="submit" value= "Agregar" width="90" height="29" name="archivo">
				</td>
			</tr>
			<tr height="10px">
				<td colspan="3"></td>
			</tr>
			<tr>
				<td id="titleBlueLineBottom" colspan="3"></td>
			</tr>
			<tr height="30px">
				<td colspan="3"></td>
			</tr>
		</tbody>
	</table>
</form>';

echo "<table border='0' align='center' width='800px'>";	
///LINEA FINAL
		echo "<tr height='30px'></tr>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
		/*echo "<tr>";
			echo "<td align='right'>";
				echo "<a href='fichaSolicitudModificacion.php?id=$solicitudID' >
					  <img src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";
		echo "</tr>";*/
	
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
		/*echo "<table border='0' align='center' width='500px' id='formularioAcuerdo' style='display:none;'>";
			echo "<tr><td id='titleBlueLineBottom' width='500px'></td></tr>";
			
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='left'><input type='text' class='DatP' name='fechaAcuerdo' size='10'></td>";
			echo "</tr>";
	
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='left'>";
					echo "<input type='text' name='tituloAcuerdo' size='67'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align='left'>";
					echo "<textarea name='descripcionAcuerdo' style='width:447px; height:100px;'></textarea>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td></td></tr>";
		echo "</table>";
	echo "</form>";

	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='50px'><td></td></tr>";
	echo "</table>";*/
	echo "</form>";
echo "</div>";

?>
    	</body>
    </html>
<?php

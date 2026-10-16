<?php error_reporting(0); ?>
<?php
$nombrephp = 'fichaProceso.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$idProceso = $_GET['proceso'];

if(isset($_POST['enviar'])){
	$signatura = $_POST['signatura'];
	$codigo = $_POST['codigo'];
	//echo "UPDATE SGI_Procesos SET xt_signatura = '$signatura' WHERE kp_codigo = '$codigo'";
	$INTRANET->Execute("UPDATE SGI_K_Procesos SET xt_Signatura = '$signatura' WHERE kp_CodigoCorto = '$procesoCodigo'");
	
	/*
	$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigo' ");
	
	
	if($inventarioLiberado == ''){
			header ("Location: FichaItem.php?id=$idProceso");
	}else{
			header("Location: ControlCambios.php?itemID=$idProceso");
	}*/
	header("Location: fichaProceso.php?proceso=$procesoCodigo");
}

?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">

			<style type="text/css">
				
				#roles, #tiempos{
					color: #007CBD;
				}
				table.auto{
					table-layout: auto;
				}

				.linkButton {

					float:right;
					font-family: Lucida Sans, Arial;
					font-size: 13px;
				    background: none;
				    border: none;
				    color: #007CBD;
				    text-decoration: none;
				    cursor: pointer; 
				}
			</style>            
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
				function mostrarIframe(capa){
					var mostrar = document.getElementById(capa);
					if(mostrar.style.display == 'block'){
						mostrar.style.display = 'none';
					}else{
						mostrar.style.display = 'block';
					}
				}
			</script>
            
            <script>
				function showPREV(valor){
					if(valor == 1){
						document.getElementById("masControl5").style.display="none";
						document.getElementById("masControl6").style.display="block";
						document.getElementById("formularioUser").style.display="block";
					} else if (valor == 2){
						document.getElementById("masControl5").style.display="block";
						document.getElementById("masControl6").style.display="none";
						document.getElementById("formularioUser").style.display="none";
					}
				}
			</script>

		    <!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
			<script language="javascript" type="text/javascript">
                function iluminaLibera(celda){
					
				 var usuario = "<?php echo $usuarioId;?>";
				 var tipo    = 'Proceso';
				 
  					window.location = "liberaItem.php?itemID="+"<?php echo $idProceso; ?>"+"&tipo="+tipo+"&usuario="+usuario+"";				
				}
				
            </script>

           
 			<?php
			
			
				//echo "<title>".$codigo." ".$nombre."</title>";
			
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
			?>
        </head>
        <body>
<?php

//header('Content-Type: text/html; charset=UTF-8'); 

function to_roman($num) { 

	// Function to convert an arabic number ($num) to a roman numeral.  $num must be between 0 and 9,999 
	
	if ($num < 0 || $num > 9999) { return -1; } // out of range 
	
	$r_ones = array(1=> "I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX"); 
	$r_tens = array(1=> "X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX", 8=>"LXXX", 9=>"XC"); 
	$r_hund = array(1=> "C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC", 8=>"DCCC", 9=>"CM"); 
	$r_thou = array(1=> "M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM", 7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM"); 
	
	$ones = $num % 10; 
	$tens = ($num - $ones) % 100; 
	$hundreds = ($num - $tens - $ones) % 1000; 
	$thou = ($num - $hundreds - $tens - $ones) % 10000; 
	
	$tens = $tens / 10; 
	$hundreds = $hundreds / 100; 
	$thou = $thou / 1000; 
	
	if ($thou) { $rnum .= $r_thou[$thou]; } 
	if ($hundreds) { $rnum .= $r_hund[$hundreds]; } 
	if ($tens) { $rnum .= $r_tens[$tens]; } 
	if ($ones) { $rnum .= $r_ones[$ones]; } 
	
	return $rnum; 

}


$f = $INTRANET->Execute("SELECT DISTINCT xt_categoria FROM SGI_Registros ORDER BY xt_categoria");
$contador = 0;
while($p = $f->fetchRow()){
	
	$formatoCategoria[$contador] = $p[0];
	$contador++;
	
} unset($p); unset($f); unset($contador);


$s = $INTRANET->Execute("SELECT
	kp_CodigoCorto,
	xt_Nombre,
	xd_FechaCreacion,
	xt_CodigoProceso,
	SUBSTRING_INDEX(SUBSTRING_INDEX(xt_CodigoProceso,'-',-2),'-',1)
FROM
	SGI_K_Procesos
WHERE
	kp_CodigoCorto = '$idProceso' ");
	while($r = $s->fetchRow()){
	$procesoCodigo  = $r[0];
	$nombre 		= $r[1];
	$fechaCreacion 	= $r[2];
	$codigo 		= $r[3];
	$ciudad 		= $r[4];

	
} unset($r);


$indice = 1;
$iso 	= NULL;

//pongo titulo de la pestaña
?>
 <title><?php echo $codigo; ?></title>
<?php

$a = $INTRANET->Execute("SELECT xt_nombre FROM SGI_Manuales WHERE SUBSTRING_INDEX(xt_codigo,'-',-1) = '$area' ");	
		while($t = $a->fetchRow()){
			
			$manual = $t[0];
		
	}


$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
				   <a href='manuales.php' id='breadcrumbs'> Manuales / </a> <a href='Documento.php?manual=$grupo-$area' id='breadcrumbs'> $manual </a>";


$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";
$ciudades[7] = "Queretaro";
$ciudades[8] = "Ciudad de Mexico";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN"; 
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
$cdValor[7] = "QRO";
$cdValor[8] = "CDMX";

$indice 				= 1;
$ciudadesDisponibles 	= NULL;

			
$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);

$mostrar = 0;

if($ciudad == ""){
	
	$mostrar = 1;
	
} else if(($ciudad != "") && (in_array($ciudad, $ciudadesDisponibles))){
	
	$mostrar = 1;
	
}

//if($mostrar == 1){

echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		
		echo "<tr>";
			echo "<td align='left' id='iconosTexto2'>Versión: ".$versionImprime."</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Fecha de última actualización: ".$fechaVersionImprime."</td>";
		echo "</tr>";
		
		echo"<tr height='80px'> </tr>";
		///Titulo Ficha
		
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='700px'>".$codigo."</td>";
			//echo"<td align='center' id='titulo3' width='350px'>".$nombre."</td>";
					//echo $codigo." <br>".$nombre;
			echo"</td>";
		echo"</tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo3' width='700px'>".$nombre."</td>";
			echo"</td>";
		echo"</tr>";
		
		
		echo"<tr height='10px'> </tr>";
		///Bread Crumb
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";		
	echo "</table>";
	
	
				echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../navegacion_banana.php");
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
		
	///NUMERO MAPA = 0, NUMERO ELEMENTO = 1, DESCRIPCION
		$descripcion = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$procesoCodigo' AND xn_numeroMapa = 0 AND xn_numeroElemento = 1 ORDER BY xn_numeroElemento ");
		
		if($descripcion != ""){
			
			$descripcion = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcion));
			
			echo "<table border='0' align='center'>";
				echo"<tr height='40px'> </tr>";
				///Titulo del proceso
				echo "<tr id='titulo18'>";
					echo "<td align='left' colspan='2'><b>".$nombre."</b></td>";
				echo "</tr>";
			
				echo"<tr height='30px'> </tr>";
				///Descripción
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Descripción</b></td>";
					echo "<td align='right' width='15px'> </td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				//Contenido descripción
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td width='670' id='fileItem' align='justify'>".$descripcion."</td>";
				echo "</tr>";
				echo "<tr height='20px'> </tr>";
			echo "</table>";
			
			
		} else{
			
			echo "<table border='0' align='center'>";
				echo"<tr height='40px'> </tr>";
				///Titulo del proceso
				echo "<tr id='titulo18'>";
					echo "<td align='left' colspan='2'><b>".$nombre."</b></td>";
				echo "</tr>";
			
				echo"<tr height='30px'> </tr>";
				///Descripcion
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Descripción</b></td>";
					echo "<td align='right' width='15px'>";
						if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
							echo "<a href='AgregarElementoProcesoPopUp.php?itemID=".$itemID."&nmapa=0' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
								echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
							echo "</a>";
						}
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
			
		}
		unset($s); unset($r);
		
	///NUMERO MAPA = 0, NUMERO ELEMENTO = 3, RESPONSABLE
		$idResponsable = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$procesoCodigo'  AND xn_numeroMapa = 0 AND xn_numeroElemento = 3 ORDER BY xn_numeroElemento ");
		
		if($idResponsable != ""){
			
			echo "<table border='0' align='center'>";
				///Responsable
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Responsable</b></td>";
					echo "<td align='right' width='15px'> </td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				//Contenido descripción
				echo "<tr>";
					echo "<td width='30px'> </td>";
					$nombreResponsable 		= $INTRANET->getOne("SELECT CONCAT(xt_Nombre,' ',xt_ApellidoPaterno,' ',xt_ApellidoMaterno) FROM SGI_Empleados WHERE kp_personalId = $idResponsable ");
					echo "<td width='670' id='fileItem' align='justify'>".$nombreResponsable."</td>";
				echo "</tr>";
				echo "<tr height='20px'> </tr>";
			echo "</table>";
			
			
		} else{
			
			echo "<table border='0' align='center'>";
				///Responsable
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Responsable</b></td>";
					echo "<td align='right' width='15px'>";
						if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
							echo "<a href='AgregarElementoProcesoPopUp.php?itemID=".$itemID."&nmapa=r' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
								echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
							echo "</a>";
						}
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
			
		}
		unset($s); unset($r);
		
	///NUMERO MAPA = 0, NUMERO ELEMENTO = 2, DIAGRAMA DE FLUJO
		$diagrama = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$procesoCodigo' AND xn_numeroMapa = 0 AND xn_numeroElemento = 2 ORDER BY xn_numeroElemento ");
		
		if($diagrama != ""){
			
			echo "<table border='0' align='center'>";
			
				echo"<tr height='30px'> </tr>";
				///Descripción
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Diagrama de Flujo</b></td>";
					echo "<td align='right' width='15px'> </td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				//Contenido descripción
				echo "<tr>";
					echo "<td width='950px' id='fileItem'>";
					//echo"$diagrama<br><br>";
					
					
						if(substr($diagrama, -4) == ".pdf"){
							echo "<br><br>";
						//	echo "<embed src='$diagrama' width='950px' height='700px'><br><br>";
							//echo "<object data='$diagrama' type='application/pdf' width='950px' height='700px'>";

							echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents('$diagrama'))."'\" type='application/pdf' width='950px' height='700px'>";


								echo "<p>";
									echo "Si este mensaje aparece su navegador no soporta el plugin para el PDF.";
									echo "No obstante puede descargar el archivo en este <a href='".$diagrama."'>enlance</a>";
								echo "</p>";
							echo "</object>";
							echo "<br><br>";
						}
					echo "</td>";
				echo "</tr>";
				echo "<tr height='20px'> </tr>";
				
				$firmaAutorizada = $INTRANET->getOne("SELECT SGE.kp_personalId FROM SGI_Empleados SGE WHERE SGE.kf_usuario = '$usuarioId' ");
			
				if ($firmaAutorizada == $idResponsable){
					echo "<td align='right'>";
						echo "<a href='firmarProceso.php?id=".$idProceso."&elemento=Diagrama' target='popup' onclick=\"window.open(this.href,this.target,'width=510,height=400,scrollbars=yes')\">
							  <img src='../Imagenes/ICN_Firmar.png' width='90' height='29'></a>";
					echo "</td>";
					
				}
				
				
			echo "</table>";
			
		} else{
			echo "<table border='0' align='center'>";
			
				echo"<tr height='30px'> </tr>";
				///Descripción

				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Diagrama de Flujo</b></td>";
					echo "<td align='right' width='15px'>";
						if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
							echo "<a href='AgregarElementoProcesoPopUp.php?itemID=".$idProceso."&nmapa=d' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
								echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
							echo "</a>";
						}
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
			
		}
		unset($s); unset($r);
		
	///ACTIVIDADES
		
			echo "<table border='0' align='center' width='955px'>";
			
				echo"<tr height='10px'> </tr>";
				///titulo
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Actividades</b></td>";

					
					echo "<td align='right' width='15px'><a href='agregarActividadPopUp.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";
                  
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='10px'>";
						

			    //tabla de procesos, actividades
				
				//echo"SELECT xt_nombre from SGI_Procesos WHERE kp_codigo = '$codigo'<br><br>";
				$nomProceso = $INTRANET->getOne("SELECT xt_nombre from SGI_Procesos WHERE kp_codigo = '$codigo'");


				$index = 0;
				
				$s = $INTRANET->Execute("SELECT DISTINCT xt_nombreRol, kp_codigoRol FROM SGI_K_Roles WHERE kf_codigoProceso = '$procesoCodigo' ORDER BY RIGHT(kp_codigoRol,3)");

				while($row = $s->fetchRow()){
					//$f[$index] = $row[0];
					$n[$index] = $row[1];
					$f[$index] = $row[0];
					$index++; 
				}
				$fila = count($f);
				
				
				$numColumnas = $INTRANET->getOne("SELECT
													count(DISTINCT SKA.xt_momento)
												FROM
													SGI_K_Actividades SKA
												WHERE
													SKA.kf_codigoProceso = '$procesoCodigo'");

				//obtengo los tiempos
				//hago consulta de tiempos
			
				$a = $INTRANET->Execute("SELECT DISTINCT
											SKA.xt_momento,
											RIGHT (SKA.xt_momento, 3),
											SKA.xt_momento
										FROM
											SGI_K_Actividades SKA
										WHERE
											SKA.kf_codigoProceso = '$procesoCodigo'
										ORDER BY
											SKA.xt_momento");

				$indexT = 0;
				while($row2 = $a->fetchRow()){
					$tiempo[$indexT] = $row2[0];
					$indexT ++;
				}



				//creacion de la matriz

				$tituloMatriz = $numColumnas + 1;
				echo "<table border='1' class='auto' style = 'width:1055px;font-size:10px;'>";

					echo "<tr>
						<td align='center' colspan ='$tituloMatriz'><strong>$codigo / $nombre</strong></td>
					</tr>";

				//listo filas
				for($i = 0; $i < $fila; $i++){

				echo "<tr>";

					echo "<td id='roles'><strong>$f[$i]</strong></td>";

				//listo columnas
				for($e = 0; $e < $numColumnas; $e++){


					$rolCodigo = $n[$i];
					
				
					$actividad = $INTRANET->Execute("SELECT DISTINCT
														SKA.kp_codigoActividad,
														SKA.xt_nombre,
														SKA.kf_codigoRol														
													FROM
														SGI_K_Actividades SKA
													WHERE
														SKA.kf_codigoProceso = '$procesoCodigo'
													AND SKA.kf_codigoRol = '$rolCodigo'
													AND SKA.xt_momento = '$tiempo[$e]'
													ORDER BY
														SKA.kp_codigoActividad");

					$indexA = 0;
					while($row3 = $actividad->fetchRow()){
						$arrayActividad[$indexA]            = $row3[0];
						$arrayDescripcionActividad[$indexA] = $row3[1];
						$rolActividad[$indexA]              = $row3[2];
						$indexA++;
					}unset($indexA);


					if($actividad->recordCount() > 0){

						echo "<td>";

							for($l = 0; $l < $actividad->recordCount(); $l++){
							
								echo $l+1;
								echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaActividadFuncionalidad.php?proceso=$procesoCodigo&actividad=$arrayActividad[$l]&rol=$rolActividad[$l]' style='text-decoration:none;' id='textoActividad'>- $arrayDescripcionActividad[$l]</a>";
								echo "<br><br>";
							
							} unset($arrayDescripcionActividad); unset($l);

						echo "</td>";				

					}else{

						echo "<td></td>";
					}
			

				}

			echo "</tr>";
		}



		echo "<tr>";

			echo "<td></td>";

			//hago consulta de tiempos

			for($j = 0; $j < count($tiempo); $j++){

				echo "<td id='tiempos'><strong>$tiempo[$j]</strong></td>";

			}
	
		echo "</tr>";

	echo "</table>";

	//Fin de tabla de procesos, actividads

	
				echo "</tr>";
			echo "</table>";
			
			//nombre de actividad
			echo "<table border='0' align='center' width='650'>";
			
				echo"<tr height='10px'> </tr>";
				///titulo
				
				$s = $INTRANET->Execute("SELECT xt_nombre, kp_actividadID FROM SGI_Procesos_Actividades WHERE kf_itemID = '$itemID' ");
				
					while($r = $s -> FetchRow ()){
						$r[0];	
						echo "<tr id='fileItem'>";
							echo "<td align='left'><a href='fichaActividadRequerimiento.php?id=$r[1]'><img src='../Imagenes/ICN_Boton_Azul.png' height='15' width='15'></a> ".$r[0]."</td>";
						echo "</tr>";
					}
				
				echo"<tr height='30px'> </tr>";
			echo "</table>";
				
		unset($s); unset($r);	
		
	///NUMERO MAPA = 1, PROCESOS ANTECESORES
		
		$procesosAntecesores 	= NULL;
		$tituloPAntecesores		= NULL;
		$descripcionPAnt		= NULL;
		$indice 				= 1;
		
		//echo"SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 1 ORDER BY xn_numeroElemento<br><br>";
		$s = $INTRANET->Execute("SELECT
									SKPS.xt_CodigoProcesoAntecesor,
									(SELECT SKP.xt_CodigoProceso FROM SGI_K_Procesos SKP WHERE SKP.kp_CodigoCorto = SKPS.xt_CodigoProcesoAntecesor) as CodigoCompleto,
									(SELECT SKP.xt_Nombre FROM SGI_K_Procesos SKP WHERE SKP.kp_CodigoCorto = SKPS.xt_CodigoProcesoAntecesor) as Nombre
								FROM
									SGI_K_Procesos_Antecesores SKPS
								WHERE
									SKPS.xt_CodigoProceso = '$procesoCodigo'");
		
		while($r = $s->fetchRow()){			
				$procesosAntecesores[$indice]	= $r[1];
				$tituloPAntecesores[$indice] 	= $r[2];
				$descripcionPAnt[$indice]		= "";
				$link[$indice] 					= "fichaProceso.php?proceso=".$r[0];
				
			
			$indice++;
			
		} unset($r);
        
        //FUNCIONALIDADES
        
		
			echo "<table border='0' align='center' width='955px'>";
			
				echo"<tr height='10px'> </tr>";
				///titulo
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Funcionalidades</b></td>";
				
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
            echo "</table>";
            
			echo "<table border='0' align='center' width='1020px'>";
				echo "<tr>";
					echo "<td>";
						echo "<strong>Funcionalidad</strong>";
					echo "</td>";
					echo "<td>";
					echo "</td>";
					echo "<td>";
						echo "<strong>Nombre</strong>";
					echo "</td>";
					echo "<td>";
						echo "<strong>Actividad</strong>";
					echo "</td>";
					echo "<td>";
					echo "</td>";
					echo "<td>";
						echo "<strong>Nombre</strong>";
					echo "</td>";
				echo "</tr>";
	
		   /*$f = $INTRANET->Execute("SELECT
										PRAF.kf_codigoProcesoRolActividad,
										F.xt_nombre,
										PRAF.kf_codigoFuncionalidad,
										CT.xn_consecutivo,
										PRAF.kp_codigo
									FROM
										SGI_Procesos_Roles_Actividades_Funcionalidades PRAF,
										SGI_Funcionalidades F,
										SGI_Procesos_Roles_Actividades PRA,
										SGI_Catalogo_Tiempos CT
									WHERE
										PRAF.kf_codigoProcesoRolActividad LIKE '$proceso%'
									AND PRAF.kf_codigoProcesoRolActividad = PRA.kp_codigo
									AND PRAF.kf_codigoFuncionalidad = F.kp_codigo
									AND PRA.xt_tiempo = CT.kp_tiempo
									ORDER BY
										CT.xn_consecutivo ASC
									");*/
			$f = $INTRANET->Execute("SELECT DISTINCT
										SKF.kf_codigoProceso,
										SKF.kf_codigoActividad,
										SKF.kf_codigoRol,
										SKF.kp_codigoFuncionalidad,
										SKF.xt_nombre
									FROM
										SGI_K_Funcionalidades SKF
									WHERE
										SKF.kf_codigoProceso = '$procesoCodigo'
									ORDER BY
										RIGHT (SKF.kp_codigoFuncionalidad, 3)");
		   while($v = $f->fetchRow()){
			  /* $act = explode("_",$v[0]);
			   $actividad = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Actividades WHERE kp_codigo = '$act[2]'");
			   $proceso1  = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Procesos WHERE xt_codigoCorto = '$act[0]'");
			   $rol1      = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Roles WHERE kp_codigo = '$act[1]'");*/
			   $actividad = $INTRANET->getOne("SELECT xt_nombre FROM SGI_K_Actividades WHERE kp_codigoActividad = '$v[1]'");
			 //  $proceso1  = $INTRANET->getOne("SELECT kp_codigo FROM SGI_K_Procesos WHERE xt_CodigoCorto = '$v[0]'");
			   $rol1      = $INTRANET->getOne("SELECT xt_nombre FROM SGI_K_Roles WHERE kp_codigoRol = '$v[3]'");
				echo "<tr>";
					echo "<td width='150'>";
						 echo "<i>".$v[3]."</i>";
					echo "</td>";
					echo "<td>";
					echo "</td>";
					echo "<td width='500'>";
						echo "<a href='fichaFuncionalidadCasoUso.php?proceso=$v[0]&rol=$v[2]&actividad=$v[1]&funcionalidad=$v[3]'>".$v[4]."</a>";
					echo "</td>";
				echo "<td width='150'>";
						echo "<i>".$v[1]."</i>";
					echo "</td>";
					echo "<td>";
					echo "</td>";
					echo "<td width='300'>";
						echo "<a href='fichaActividadFuncionalidad.php?proceso=$v[0]&actividad=$v[1]&rol=$v[2]'>".$actividad."</a>";;
					echo "</td>";
				echo "</tr>";
		   }
		echo "</tr>";
		echo "</table>";
               
               
        
        /****************************************************************************************************/
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Procesos antecesores
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>1.- Procesos antecesores</b></td>";
				echo "<td align='right'>";
					//Agregar proceso antecesor
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Lizbeth_Guadarrama') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')){
						echo "<a href='agregaElementosProceso/agregaProcesoAntecesor.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=450,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			if($tituloPAntecesores != NULL){
				for($i = 1; $i <= count($tituloPAntecesores); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						if($procesosAntecesores[$i] != ""){
							echo "<td align='left' valign='top'>"; 
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$procesosAntecesores[$i]</a>";
							echo "</td>";
							echo "<td align='left'> </td>";
							echo "<td align='left' colspan='2'>$tituloPAntecesores[$i]</td>";
						} else{
							echo "<td align='left' valign='top' colspan='4'>$i. $tituloPAntecesores[$i]</td>";
						}
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		unset($link);
	///NUMERO MAPA = 2, PROCESOS DE APOYO
		
		$procesosApoyo 	= NULL;
		$tituloPApoyo	= NULL;
		$descripcionPAp	= NULL;
		$indice 		= 1;
		
		$s = $INTRANET->Execute("SELECT
									SKPS.xt_CodigoProcesoAntecesor,
									(SELECT SKP.xt_CodigoProceso FROM SGI_K_Procesos SKP WHERE SKP.kp_CodigoCorto = SKPS.xt_CodigoProcesoAntecesor) as CodigoCompleto,
									(SELECT SKP.xt_Nombre FROM SGI_K_Procesos SKP WHERE SKP.kp_CodigoCorto = SKPS.xt_CodigoProcesoAntecesor) as Nombre
								FROM
									SGI_K_Procesos_Apoyo SKPS
								WHERE
									SKPS.xt_CodigoProceso = '$procesoCodigo' ");
		
		while($r = $s->fetchRow()){
				$procesosApoyo[$indice]	= $r[1];
				$tituloPApoyo[$indice] 	= $r[2];
				$descripcionPAp[$indice]= "";
				$link[$indice] 			= "fichaProceso.php?proceso=".$r[0];
				
			
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Procesos de apoyo
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>2.- Procesos de apoyo</b></td>";
				echo "<td align='right'>";
					//Agregar proceso de apoyo
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoApoyo.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=450,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			if($tituloPApoyo != NULL){
				for($i = 1; $i <= count($tituloPApoyo); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						if($procesosApoyo[$i] != ""){
							echo "<td align='left' valign='top'>"; 
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$procesosApoyo[$i]</a>";
							echo "</td>";
							echo "<td align='left'> </td>";
							echo "<td align='left' colspan='2'>$tituloPApoyo[$i]</td>";
						} else{
							echo "<td align='left' valign='top' colspan='4'>$i. $tituloPApoyo[$i]</td>";
						}
						
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					if($descripcionPAp[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>$descripcionPAp[$i]</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 3, PROCESOS SUCESORES
		
		$procesosSucesores	= NULL;
		$tituloPSucesores	= NULL;
		$descripcionSuce	= NULL;
		$indice 			= 1;
		
		$s = $INTRANET->Execute("SELECT
									SKPS.xt_CodigoProcesoAntecesor,
									(SELECT SKP.xt_CodigoProceso FROM SGI_K_Procesos SKP WHERE SKP.kp_CodigoCorto = SKPS.xt_CodigoProcesoAntecesor) as CodigoCompleto,
									(SELECT SKP.xt_Nombre FROM SGI_K_Procesos SKP WHERE SKP.kp_CodigoCorto = SKPS.xt_CodigoProcesoAntecesor) as Nombre
								FROM
									SGI_K_Procesos_Sucesores SKPS
								WHERE
									SKPS.xt_CodigoProceso = '$procesoCodigo'");
		
		while($r = $s->fetchRow()){
			
				$procesosSucesores[$indice]	= $r[1];
				$tituloPSucesores[$indice] 	= $r[2];
				$descripcionSuce[$indice]	= "";
				$link[$indice] 				= "fichaProceso.php?proceso=".$r[0];
				
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Procesos sucesores
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>3.- Procesos sucesores</b></td>";
				echo "<td align='right'>";
					//Agregar proceso sucesores
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoSucesor.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=450,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			if($tituloPSucesores  != NULL){
				for($i = 1; $i <= count($tituloPSucesores); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						if($procesosSucesores[$i] != ""){
							echo "<td align='left' valign='top'>"; 
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$procesosSucesores[$i]</a>";
							echo "</td>";
							echo "<td align='left'> </td>";
							echo "<td align='left' colspan='2'>$tituloPSucesores[$i]</td>";
						} else{
							echo "<td align='left' valign='top' colspan='4'>$i. $tituloPSucesores[$i]</td>";
						}
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 4, ENTRADAS
		$tituloEntrada			= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Entradas FROM SGI_K_Entradas WHERE xt_CodigoProceso = '$procesoCodigo' ");
		
		while($r = $s->fetchRow()){
			$tituloEntradas[$indice] 		= $r[0];
				
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Entradas
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>4.- Entradas</b></td>";
				echo "<td align='right'>";
					//Agregar entradas
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoEntrada.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
				for($i = 1; $i <= count($tituloEntradas); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						
							echo "<td align='left' valign='top' colspan='4'>";
								echo "$i. $tituloEntradas[$i]";
							echo "</td>";
						}
						
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 5, SALIDAS
		
		$tituloSalida			= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Salidas FROM SGI_K_Salidas WHERE xt_CodigoProceso = '$procesoCodigo' ");
		
		while($r = $s->fetchRow()){
			$tituloSalida[$indice] 	= $r[0];
	
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Salida
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>5.- Salidas</b></td>";
				echo "<td align='right'>";
					//Agregar salidas
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoSalida.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
				for($i = 1; $i <= count($tituloSalida); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						
						echo "<td align='left' valign='top' colspan='4'>";
							echo "$i. $tituloSalida[$i]";
						echo "</td>";

					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 6, EQUIPO/INSUMOS
		
		$descripcionEquipos	 	= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Insumos FROM SGI_K_Insumos WHERE xt_CodigoProceso = '$procesoCodigo' ");
		
		while($r = $s->fetchRow()){
			
			$descripcionEquipos[$indice] 	= $r[0];
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Equipos e Insumos
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>6.- Equipos/Insumos</b></td>";
				echo "<td align='right'>";
					//Agregar equipos e insumos
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoInsumos.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=600,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='20px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='615px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			if($descripcionEquipos  != NULL){
				for($i = 1; $i <= count($descripcionEquipos); $i++){
					echo "<tr id='fileItem'>";
						echo "<td align='left'> </td>";
						echo "<td align='right' valign='top'>$i.</td>";
						echo "<td align='left'> </td>";
						echo "<td align='justify'>$descripcionEquipos[$i]</td>";
						echo "<td align='left'> </td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);		
	///NUMERO MAPA = 7, COMPLIANCE
		$tituloCompliance		= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Compliance FROM SGI_K_Compliance WHERE xt_CodigoProceso = '$procesoCodigo'");
		
		while($r = $s->fetchRow()){
				$tituloCompliance[$indice]			= $r[0];	
	
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>7.- Compliance</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoCompliance.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			if($tituloCompliance  != NULL){
				for($i = 0; $i <= count($tituloCompliance); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' valign='top' colspan='4'>"; 
							echo "$tituloCompliance[$i]";
						echo "</td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
		///NUMERO MAPA = 8, DOCUMENTOS
		
		$documentosProceso		= NULL;
		$descripcionDocumento	= NULL;
		$tituloDocumento		= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo, xt_tipo FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$procesoCodigo' AND xn_numeroMapa = 8 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			
			if(($r[0] != "") && ($r[3] == "ITEM")){
				
				$documentosProceso[$indice]			= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$tituloDocumento[$indice]			= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$descripcionDocumento[$indice]		= "";
				$link[$indice] = "FichaItem.php?id=".$r[0];
				
			} else{
				$documentosProceso[$indice]			= "";
				$tituloDocumento[$indice]			= $r[2];
				$descripcionDocumento[$indice]		= $r[1];
				
				$link[$indice]						= "";
				
				if($descripcionDocumento[$indice] != ""){
					$descripcionDocumento[$indice] 	= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionDocumento[$indice]));
				}
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>8.- Documentos Controlados</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=8' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			if($tituloDocumento  != NULL){
				for($i = 1; $i <= count($tituloDocumento); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						if($documentosProceso[$i] != ""){
							echo "<td align='left' valign='top'>"; 
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$documentosProceso[$i]</a>";
							echo "</td>";
							
							echo "<td align='left'> </td>";
							
							echo "<td align='left' colspan='2'>$tituloDocumento[$i]</td>";
						} else{
							echo "<td align='left' valign='top' colspan='4'>";
								echo "$i. $tituloDocumento[$i]";
							echo "</td>";
						}
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					if($descripcionDocumento[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>$descripcionDocumento[$i]</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 9, STAKEHOLDERS
		
		//$stakeholder			= NULL;
		//$descripcionStakeholder	= NULL;
		$tituloStakeholder		= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Stakeholder FROM SGI_K_Stakeholders WHERE xt_CodigoProceso = '$procesoCodigo' ");
		
		while($r = $s->fetchRow()){
				$tituloStakeholder[$indice]			= $r[0];
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>9.- Stakeholders (puestos y roles)</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoStakeholders.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=620,height=500,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='150px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='480px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";

				for($i = 1; $i <= count($tituloStakeholder); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
							echo "<td align='left' valign='top' colspan='4'>$i. $tituloStakeholder[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
	
				}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	    ///NUMERO MAPA = 10, RIESGOS
		
		$descripcionRiesgos	= NULL;
		$indice 			= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Riesgo FROM SGI_K_Riesgos WHERE xt_CodigoProceso = '$procesoCodigo'");
		
		while($r = $s->fetchRow()){
			$descripcionRiesgos[$indice] 	= $r[0];
					
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>10.- Riesgos</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoRiesgos.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='120px'> </td>";
				echo "<td align='left' width='5px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			for($i = 1; $i <= count($descripcionRiesgos); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
							echo "<td align='left' valign='top' colspan='4'>$i. $descripcionRiesgos[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
	
			}
			
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
	///NUMERO MAPA = 11, INDICADORES
		$nombreIndicadores		= NULL;
		$formulaIndicadores		= NULL;
		$valorIndicadores		= NULL;
		$periodicidad			= NULL;
		
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Indicador, xt_formula, xt_valor, xt_periodicidad FROM SGI_K_Indicadores WHERE xt_CodigoProceso = '$procesoCodigo' ORDER BY xt_Indicador ");
		
		while($r = $s->fetchRow()){
			$nombreIndicadores[$indice] 		= $r[0];
			$formulaIndicadores[$indice] 		= $r[1];
			$valorIndicadores[$indice]			= $r[2];
			$periodicidad[$indice]				= $r[3];
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>11.- Indicadores</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementosProceso/agregaProcesoIndicadores.php?proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='90px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";

				for($i = 1; $i <= count($nombreIndicadores); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$nombreIndicadores[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					if($formulaIndicadores[$i] != ''){
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'> </td>";
							echo "<td align='left'> </td>";
							echo "<td align='left' valign='top' id='fileItem'>Fórmula:</td>";
							echo "<td align='justify' valign='top' id='fileItem'>$formulaIndicadores[$i]</td>";
							echo "<td align='left'> </td>";
						echo "</tr>";
					
						echo"<tr height='5px'> </tr>";
					}
					if($valorIndicadores[$i] != ''){
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'> </td>";
							echo "<td align='left'> </td>";
							echo "<td align='left' valign='top' id='fileItem'>Valor:</td>";
							echo "<td align='justify' valign='top' id='fileItem'>$valorIndicadores[$i]</td>";
							echo "<td align='left'> </td>";
						echo "</tr>";

						echo"<tr height='5px'> </tr>";
					}
					if($periodicidad[$i] != ''){
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'> </td>";
							echo "<td align='left'> </td>";
							echo "<td align='left' valign='top' id='fileItem'>Periodicidad:</td>";
							echo "<td align='justify' valign='top' id='fileItem'>$periodicidad[$i]</td>";
							echo "<td align='left'> </td>";
						echo "</tr>";

						echo"<tr height='20px'> </tr>";
					}
				
			}
			
			echo"<tr height='20px'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>12.- Documentación</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='tipoDoctosPopUp.php?usuario=$usuarioId&proceso=$codigo' target='popup' onclick=\"window.open(this.href,this.target,'width=350,height=580,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
						</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='10px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='90px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";

		echo "</table>";
		
		//Listo todos los tipos de documentación
            $s = $INTRANET->Execute("SELECT DISTINCT xt_tipoDocumento FROM SGI_Documentos_Procesos WHERE xt_codigo = '$codigo'");
            
            $indexTotalDoc = 0;
            $trPos = 0;
            while($row = $s->fetchRow()){   
                $trPos ++;
                $trPosF = "trFile".$trPos;
                
                echo "<table border='0' width='90%'>";
                
                    echo "<tr>";
                        echo "<td>";
                                echo "<input type='hidden' name='tipoDoc' id='tipoDoc' value='$row[0]'>";
                                //echo "<b> $row[0] </b>";
                                echo "<br>";
                            echo "</td>";
                    echo "</tr>";
                
                    echo "<tr>";
                        echo "<td width='30px'></td>";
                        echo "<td align='left' style='font-size:16px;color:#007CBD;'>$row[0]</td>";
                        echo "<td width='15px'></td>";
                        echo "<td width='15px'>";
                        ?>
                            <a href='javascript:void(0);' onclick='mostrarIframe("<?php echo $trPosF; ?>");'><img  src="../../INTRANET_GEA/Imagenes/ICN_NuevoDoc.png" height='15' width='15'/></a>     
                        <?php
                        echo "</td>";
                    echo "</tr>";
                
                    echo "<tr>";
                        echo "<td width='30px'></td>";
                        echo "<td colspan='3'   style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
                        echo "</td>";
                    echo "</tr>";
					
       			  echo "</table>";
                      
                    //consulto archivo correspondiente al tipo de documento
				//	echo"SELECT xt_nombreArchivo, xt_usuario, xd_fecha, xt_rutaArchivo FROM SGI_Documentos_Procesos WHERE xt_tipoDocumento = '$row[0]' AND xt_codigo = '$codigo'";
                    $doc = $INTRANET->Execute("SELECT xt_nombreArchivo, xt_usuario, xd_fecha, xt_rutaArchivo FROM SGI_Documentos_Procesos WHERE xt_tipoDocumento = '$row[0]' AND xt_codigo = '$codigo'");
                
                    $numDoc = 0;
                    while ($listA = $doc -> fetchRow()){
                        if(!empty($listA[0])){
							//echo"$listA[0]--$listA[3]---";
                            echo "<table border='0' width='90%'>";
                                echo "<tr>";
                                    echo "<td width='30px'></td>";
                                    echo "<td style='padding:0px 0px 0px 15px;'><font size=2>$listA[0]</font></td>";
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/eliminaDoctosFichaActividad.php?codigo=".$codigo."&nombreA=".$listA[0]."&ruta=".$listA[3]."&nombrephp=".$nombrephp."&item=".$procesoCodigo."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/extraccionDoctosReporte.php?nombreA=".$listA[0]."&ruta=".$listA[3]."'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a></td>";
                                echo "</tr>";
                
                                echo "<tr>";
                                    echo "<td width='30px'></td>";
                        
                                    echo "<td style='color:#636262; padding:0px 0px 0px 30px'><i><font size=2>$listA[1], $listA[2]</font></i></td>";
                                //echo "<td>[Nombre Usuario] 2015-11-22 14:28:00</td>";
                                echo "</tr>";
                                
                                echo "<tr height='10'></tr>";
                            echo "</table>";
                        }//fin del if de verificaion de que exite archivo
                        $numDoc ++;
                    }//fin del while de archivos*/
                echo "</table>";
                //fila del formulario para subir archivo
                echo "<table border='0' style='width: 90%' cellspacing='0'>";
                    echo "<tr id='$trPosF' style='display: none'>";
                        echo "<td width='250px'></td>";
                        echo "<td>";
						
                            echo "<div id='divFile'>";
                                echo "<iframe src='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/uploadArchivosActividadFuncionalidad.php?codigo=".$codigo."&usuario=".$usuarioId."&nombrephp=$nombrephp&itemId=$procesoCodigo&tipoArchivo=".$row[0]."' frameborder='0' width='800px' height='150px'></iframe><br>";
                            echo "</div>";
                        echo"</td>";
                    echo "</tr>";
					echo "<tr height='10'></tr>";
                echo "</table>";
           // echo "</div>";
	
			}
			echo"<br><br><br>";
		

		/* Signatura Topográfica*/
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>Signatura topográfica</b></td>";
			echo "</tr>";			
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";

			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='90px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			//echo "SELECT xt_signatura FROM SGI_Procesos WHERE kp_codigo = '$codigo'";
			$signaturaVal = $INTRANET->getOne("SELECT xt_Signatura FROM SGI_K_Procesos WHERE kp_CodigoCorto = '$procesoCodigo'");
			if($signaturaVal == ''){
				echo "<form name='form1' method='post' action = 'fichaProceso.php'>";
					echo "<tr id='iconosTexto' class='loadSignatura' >";
						echo "<td align='right'></td>";
						echo "<td align='center' colspan='3'><input type='text' name='signatura' placeholder='Agrega....' id='signatura'>
						<input type='hidden' name='codigo' value='$procesoCodigo'>";
						?>
							<input type="submit" class="linkButton" name="enviar" value='Guardar'/>
						<?php
						echo "</td>";
					echo "</tr>";
				echo "</form>";
			}else{
				echo "<tr id='fileItem'>";
					echo "<td align='left'> </td>";
					echo "<td align='justify' colspan='4'>$signaturaVal</td>";
				echo "</tr>";
			}
			echo"<tr height='20px'> </tr>";
		echo "</table>";


	///NUMERO MAPA = 12, NOTAS
		
		$notas					= NULL;
		$tituloNota				= NULL;
		$descripcionNota		= NULL;
		
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_titulo, xt_descripcion FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$procesoCodigo' AND xn_numeroMapa = 12 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$notas[$indice]				= $r[0];
			$tituloNota[$indice]		= $r[1];
			
			$descripcionNota[$indice] 	= $r[2];
			
			if($descripcionNota[$indice] != ""){
				$descripcionNota[$indice] 	= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionNota[$indice]));
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>Notas</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=12' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='90px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
			if($notas  != NULL){
				for($i = 1; $i <= count($notas); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$tituloNota[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$descripcionNota[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='10px'> </tr>";
				}
				
			}
			
			echo"<tr height='20px'> </tr>";
		echo "</table>";
		
	///NUMERO MAPA = 13, AREAS DE OPORTUNIDAD
		
		$tituloOportunidad				= NULL;
		
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_Area_Oportunidad FROM SGI_K_Areas_Oportunidad WHERE xt_CodigoProceso = '$procesoCodigo'");
		
		while($r = $s->fetchRow()){
			$tituloOportunidad[$indice]			= $r[0];
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>Áreas de Oportunidad</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=13' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
						echo "</a>";
					}
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto' height='30px'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='90px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
			
				for($i = 1; $i <= count($oportunidad); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$tituloOportunidad[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='10px'> </tr>";
				}
				
			echo"<tr height='20px'> </tr>";
		echo "</table>";
		
		
		$s = $INTRANET->Execute("SELECT
								(
									SELECT
										CONCAT(
											U.xt_Nombre,
											' ',
											U.xt_ApellidoPaterno,
											' ',
											U.xt_ApellidoMaterno
										)
									FROM
										SGI_Empleados U
									WHERE
										U.kf_usuario = SL.xt_usuario
								),
								SL.xd_fecha
							FROM
								SGI_Libera_Inventarios SL
							WHERE
								SL.kp_codigo = '$codigo'
							AND SL.xt_tipo = 'Proceso' ");
		
		while($r = $s->fetchRow()){
			$usuarioLibera = $r[0];
			$fechaLibera   = $r[1];
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>Liberación de proceso</b></td>";
				echo "<td align='right'></td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='90px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
	
		echo "</table>";
		

		
		if($usuarioLibera == ''){
			echo "<table border='0' align='center'>";
					echo"<tr height='10px'> </tr>";
					?>
                        <tr id='iconosTexto'>
                           <td align='center' width="400px"> </td>
                       	   <td style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27" onClick="iluminaLibera('tdLibera')"><font color="white">LIBERAR</font> </td>
                           <td align='center' width="400px"> </td>
    
    
                        </tr>
                    <?php
					echo"<tr height='20px'> </tr>";				
			//	echo"<tr height='20px'> </tr>";
			echo "</table>";
		}else{
			
			if($usuarioLibera  != NULL){
				echo "<table border='0' align='center'>";
					echo "<table border='0' align='center' width='100%' cellspacing='0'>";
					echo"<tr height='10px'> </tr>";
					?>
                        <tr id='iconosTexto'>
                            <td align='center' width="400px"> </td>
                            <td align="center" width="200px" bgcolor="#42CB27"><font color="white">LIBERADA</font></td>
                           <td align='center' width="400px"> </td>
    
    
                        </tr>
                    <?php
				echo "</table>";
				
				echo "<table border='0' align='center' width='100%' cellspacing='0'>";
					echo"<tr height='5px'> </tr>";
					
						echo "<tr id='iconosTexto'>";
							echo "<td align='center' width='200px'> </td>";
							echo "<td align='center' width='500px'>$usuarioLibera Liberó proceso</td>";
							echo "<td align='center' width='200px'> </td>";
						echo "</tr>";
						
						echo"<tr height='5px'> </tr>";
						
						echo "<tr id='iconosTexto'>";
							echo "<td align='center' width='200px'> </td>";
							echo "<td align='center' width='400px'>Fecha: $fechaLibera</td>";
							echo "<td align='center' width='200px'> </td>";
						echo "</tr>";
						
			echo "</table>";
				
			}
		
			echo "</table>";
		}
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>Control de cambios</b></td>";
				echo "<td align='right'></td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'> </td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='30px'> </td>";
				echo "<td align='left' width='90px'> </td>";
				echo "<td align='left' width='510px'> </td>";
				echo "<td align='left' width='20px'> </td>";
			echo "</tr>";
	
		echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'><td width='550px'> </td><td width='150px'> </td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs' width='700px'>";
				//echo "<i><a href='imprimeItem.php?id=".$idProceso."' id='breadcrumbs'>Imprimir</a></i>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		
			
		$firmaAutorizada = $INTRANET->getOne("SELECT SGE.kp_personalId FROM SGI_Empleados SGE WHERE SGE.kf_usuario = '$usuarioId' ");
			
		if ($firmaAutorizada == $idResponsable){
			echo "<td align='right'>";
				echo "<a href='firmarProceso.php?id=".$idProceso."&elemento=Documento' target='popup' onclick=\"window.open(this.href,this.target,'width=510,height=400,scrollbars=yes')\">
					  <img src='../Imagenes/ICN_Firmar.png' width='90' height='29'></a>";
			echo "</td>";

		}else{
			echo "<td align='right'> </td>";
		}
		
	/*	if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
			echo "<td align='right'>";
				echo "<a href='FichaItemModificacionSGI.php?id=".$idProceso."' >
					  <img src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";
			
		} else{
			echo "<td align='right'> </td>";
		}
		echo "</tr>";
		
		*/
		echo"<tr height='10px'> </tr>";
		
		echo "<tr>";
			echo "<td align='center' id='nota_al_pie' colspan='2'>";
			///Titulo
				echo "Creado: $fechaCreacion, Salvador de la Peña";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='40px'> </tr>";
		
	echo "</table>";
echo"</div>";
?>
		</body>
	</html>

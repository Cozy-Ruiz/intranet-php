<?php error_reporting(0); ?>
﻿<?php
$nombrephp = 'FichaItem.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");  

error_reporting(E_PARSE);

$idItem = $_GET['id'];

if(isset($_POST['enviar'])){
	$signatura = $_POST['signatura'];
	$codigo = $_POST['codigo'];
	//echo "UPDATE SGI_Procesos SET xt_signatura = '$signatura' WHERE kp_codigo = '$codigo'";
	$INTRANET->Execute("UPDATE SGI_Procesos SET xt_signatura = '$signatura' WHERE kp_codigo = '$codigo'");
	
	$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigo' ");
	
	
	if($inventarioLiberado == ''){
			header ("Location: FichaItem.php?id=$idItem");
	}else{
			header("Location: ControlCambios.php?itemID=$idItem");
	}

	
	
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
            	/*function guardarSignatura(codigo){		
					var signatura = document.getElementById("signatura").value;
					$('.loadSignatura').load("guardarSignatura.php",{signatura : signatura, codigo : codigo }, function(data){
						alert("Signatura");
					});
				}*/

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
				 
  					window.location = "liberaItem.php?itemID="+"<?php echo $idItem; ?>"+"&tipo="+tipo+"&usuario="+usuario+"";				
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


$s = $INTRANET->Execute("SELECT kp_itemID, xt_nombre, xd_fechaCreacion, xt_codigo, xt_ciudad, xt_grupo, xt_area, xt_tipo, xn_consecutivo 
						 FROM SGI_Item WHERE kp_itemID = $idItem ") ;
	while($r = $s->fetchRow()){
	$itemID 		= $r[0];
	$nombre 		= $r[1];
	$fechaCreacion 	= $r[2];
	$codigo 		= $r[3];
	$ciudad 		= $r[4];
	
	$grupo 			= $r[5];
	$area 			= $r[6];
	$tipo 			= $r[7];
	$consecutivo 	= $r[8];
	
} unset($r);


$indice = 1;
$iso 	= NULL;

//pongo titulo de la pestaña
?>
 <title><?php echo $codigo; ?></title>
<?php

	$s = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'ISO' ORDER BY kf_codigoID ") or die("<script>alert('No existe documento')</script>");

	while($r = $s->fetchRow()){

		$iso[$indice] = trim($r[0]);
		$indice++;

	} unset($r);

	$indice = 1;
	$nmx 	= NULL;

	$s = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'NMX' ORDER BY kf_codigoID ") or die("<script>alert('No existe documento')</script>");

	while($r = $s->fetchRow()){

		$nmx[$indice] = trim($r[0]);
		$indice++;

	} unset($r);

	$indice = 1;
	$neec 	= NULL;

	$s = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_Item_Certificaciones WHERE kf_itemID = $itemID AND xt_norma = 'NEEC' ORDER BY kf_codigoID ") or die("<script>alert('No existe documento')</script>");

	while($r = $s->fetchRow()){

		$neec[$indice] = trim($r[0]);
		$indice++;

	} unset($r);

	$indice = 1;
	$docRef = NULL;

	$s = $INTRANET->Execute("SELECT ITM.xt_nombre, ITM.kp_itemID, ITM.xt_codigo 
							 FROM SGI_Item ITM, SGI_Item_Referencia RFE WHERE ITM.kp_itemID = RFE.xt_docCodigo AND RFE.kf_itemID = $itemID
							 ORDER BY ITM.xt_codigo ");

	while($r = $s->fetchRow()){

		$itmRef[$indice] = $r[1];

		$docRef[$indice] = $r[2]." ".$r[0];

		$indice++;

	} unset($r); unset($indice);


$a = $INTRANET->Execute("SELECT xt_nombre FROM SGI_Manuales WHERE SUBSTRING_INDEX(xt_codigo,'-',-1) = '$area' ");	
		while($t = $a->fetchRow()){
			
			$manual = $t[0];
		
	}

if($tipo == "C"){
	$tipoDocumento = "Capítulo";
} else if($tipo == "L"){
	$tipoDocumento = "Lineamiento";
} else if($tipo == "P"){
	$tipoDocumento = "Procedimiento";
} else if($tipo == "I"){
	$tipoDocumento = "Instructivo";
} else if($tipo == "F"){
	$tipoDocumento = "Formato";
} else if($tipo == "DE"){
	$tipoDocumento = "Documento Externo";
} else if($tipo == "K"){
	$tipoDocumento = "Proceso";
} else if($tipo == "M"){
	$tipoDocumento = "Protocólo";
}

$banderaVersion = 0;
$i = 1;


$s = $INTRANET->Execute("SELECT CC.xd_fecha, xn_numero, CC.xt_descripcion, EMP.xt_iniciales FROM SGI_Control_Cambios CC, SGI_Empleados EMP
						WHERE CC.kf_itemID = $itemID AND EMP.kp_personalId = CC.kf_actorID ORDER BY xd_fecha DESC ");

while($r = $s->fetchRow()){
	$fechaVersion[$i] 	= date('Y-m-d', strtotime($r[0]));
	$version[$i] 		= $r[1];
	$cambioDesc[$i] 	= $r[2];
	$iniciales[$i] 		= $r[3];
	
	$i++;
	$banderaVersion++;
	
} unset($r); unset($i);

if($banderaVersion == 0){
	$versionImprime = 0;
	$fechaVersionImprime = date('Y-m-d', strtotime($fechaCreacion));
} else{
	$versionImprime = $version[1];
	$fechaVersionImprime = date('Y-m-d', strtotime($fechaVersion[1]));
}

if($tipo != 'K'){
	
	$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
				   <a href='manuales.php' id='breadcrumbs'> Manuales / </a> <a href='Documento.php?manual=$grupo-$area' id='breadcrumbs'> $manual </a>";
} else{
	
	$breadcrumb = "<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='https://escalante.com.mx/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'> Módulos / </a> 
			<a href='Procesos.php' id='breadcrumbs'> Inventario de procesos / </a> <a href='tableroProcesos.php' id='breadcrumbs'> Tablero Inventario de Procesos </a>";
}

if(strlen($consecutivo) == 1){
	
	$imprimeConsecutivo = "0".$consecutivo;
	
}else{
	
	$imprimeConsecutivo = $consecutivo;
	
}

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

if($mostrar == 1){

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
		
		if($tipo != "K"){
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
		} else{
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='700px'>";
						echo $codigo;
				echo"</td>";
			echo"</tr>";
		}
		
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
	
	if(($iso != (NULL|| "")) || ($nmx != (NULL|| "")) || ($neec != (NULL|| ""))){
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Certificaciones
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='700px'><b>Certificaciones</b></td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
	}
	if($iso != (NULL|| "")){
		echo "<table border='0' align='center'>";
			///ISO
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "ISO: ";
					for($i = 1; $i <= count($iso); $i++){
						$capitulo = (explode(".", $iso[$i]));
						if($i == count($iso)){
							echo "<a href='Capitulo.php?norma=ISO&capitulo=".$capitulo[0]."#".$iso[$i]."' id='fichaRef' >".$iso[$i]."</a>";
						} else{
							echo "<a href='Capitulo.php?norma=ISO&capitulo=".$capitulo[0]."#".$iso[$i]."' id='fichaRef' >".$iso[$i]."</a>; ";
						}
					}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}
	
	if($nmx != (NULL|| "")){
		echo "<table border='0' align='center'>";
			///NMX
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "NMX: ";
					for($i = 1; $i <= count($nmx); $i++){
						$capitulo = (explode(".", $nmx[$i]));
						if($i == count($nmx)){
							echo "<a href='Capitulo.php?norma=NMX&capitulo=".$capitulo[0]."#".$nmx[$i]."' id='fichaRef' >".$nmx[$i]."</a>";
						} else{
							echo "<a href='Capitulo.php?norma=NMX&capitulo=".$capitulo[0]."#".$nmx[$i]."' id='fichaRef' >".$nmx[$i]."</a>; ";
						}
					}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}
	
	if($neec != (NULL|| "")){
		echo "<table border='0' align='center'>";
			///NEEC
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
					echo "NEEC: ";
					for($i = 1; $i <= count($neec); $i++){
						$capitulo = (explode(".", $neec[$i]));
						if($i == count($neec)){
							echo "<a href='Capitulo.php?norma=NEEC&capitulo=".$capitulo[0]."#".$neec[$i]."' id='fichaRef' >".$neec[$i]."</a>";
						} else{
							echo "<a href='Capitulo.php?norma=NEEC&capitulo=".$capitulo[0]."#".$neec[$i]."' id='fichaRef' >".$neec[$i]."</a>; ";
						}
					}
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}
	
	if($docRef != (NULL|| "")){
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='700px'><b>Referencias</b></td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
	
	
		for($i = 1; $i <= count($docRef); $i++){
			echo "<table border='0' align='center'>";
				///ISO
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
							echo "<a href='FichaItem.php?id=".$itmRef[$i]."' id='fichaRef' >".$docRef[$i]."</a>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		}
	}
	
	if($tipo == "P" || $tipo == "L" || $tipo == "I" || $tipo == "DE"){
		
		$i = 1;
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$numeroElemento[$i] = $r[0];
			$tipoElemento[$i] 	= $r[1];
			
			if(($tipoElemento[$i] == 'DESARROLLOT') || ($tipoElemento[$i] == 'DESARROLLOA')){
				$tipoElemento[$i] = "DESARROLLO";
			}
			
			$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[2]));
			$i++;
		}
	}
	
	if($tipo == "P"){
		
		if($numeroElemento == NULL){
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Contenido</b></td>";
					echo "<td align='right' width='15px'>";
						echo "<a href='AgregarContenidoProcedimientoPopUp.php?itemID=".$itemID."' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
							  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
			
		}
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Elementos</b></td>";
				
				if (($usuarioId == 'Rodrigo_Romo')||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'Lizbeth_Guadarrama')||($usuarioId == 'Ricardo_Garcia')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')){
					echo "<td align='right' width='15px'>";
						echo "<a href='AgregaElementos/AgregarElementoPopUp.php?itemID=".$itemID."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
							  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
					echo "</td>";
				}else{
					echo "<td align='right' width='15px'>";	
					echo "</td>";	
				}
				
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		$bandera = 0;
		for($a = 1; $a <= count($numeroElemento); $a++){
			if($tipoElemento[$a] == "DESARROLLO"){
				$bandera++;
			}
			
			if($bandera == 0){
				echo "<table border='0' align='center'>";
					echo "<tr>";
						echo "<td> </td>";
						echo "<td align='left' id='iconosTexto' colspan='2'>";
								echo to_roman($numeroElemento[$a]).". $tipoElemento[$a]";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td align='left' width='30px'> </td>";
						echo "<td width='640' id='fileItem' align='justify'>$contenidoElemento[$a]</td>";
					echo "</tr>";
					echo "<tr height='20px'> </tr>";
				echo "</table>";
			} else if($bandera == 1){
				echo "<table border='0' align='center'>";
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td align='left' id='iconosTexto' colspan='2' width='670px'>";
								echo to_roman($numeroElemento[$a]).". $tipoElemento[$a]";
						echo "</td>";
					echo "</tr>";
				echo "</table>";	
				
				if(substr($contenidoElemento[$a], -4) == ".pdf"){
					echo "<br><br><object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
							  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
							  </p>
						  </object><br><br>";
				} else{
					echo "<table>";	
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' width='30px'> </td>";
							echo "<td width='640' id='fileItem'  align='justify'>";
								echo $contenidoElemento[$a];
							echo "</td>";
						echo "</tr>";
					echo "</table>";	
				}
					
				echo "<table>";		
					echo "<tr height='10px'> </tr>";
				echo "</table>";
			} else if($bandera > 1){
				if(substr($contenidoElemento[$a], -4) == ".pdf"){
					echo "<br><br><object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
							  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
							  </p>
						  </object><br><br>";
				} else{
					echo "<table>";	
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td align='left' width='30px'> </td>";
							echo "<td width='640' id='fileItem'  align='justify'>";
								echo $contenidoElemento[$a];
							echo "</td>";
						echo "</tr>";
					echo "</table>";	
				}
					
				echo "<table>";		
					echo "<tr height='10px'> </tr>";
				echo "</table>";
			}
		}
	}
	
	
	if($tipo == "L" || $tipo == "I" || $tipo == "DE"){
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Elementos</b></td>";
				echo "<td align='right' width='15px'>";
					echo "<a href='AgregaElementos/AgregarElementoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
						  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		for($a = 1; $a <= count($numeroElemento); $a++){
			
			if(substr($contenidoElemento[$a], -4) == ".pdf"){
					echo "<br><br><object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
							  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
							  </p>
						  </object><br><br>";
				} else{
					
					//for($a = 1; $a <= count($numeroElemento); $a++){
					
				//	if($usuarioId == 'Alberto_Martinez'){
					
						//if(substr($contenidoElemento[$a], 0, 9) == "../FILES/"){
							echo "<table>";	
								echo "<tr>";
									echo "<td width='30px'> </td>";
									echo "<td width='670' id='fileItem'  align='justify'>";
									
									//Se elimina el link para la descarga ya que solo corresponde mostrar el texto..................
										/*echo "<a href='downloadItem.php?file=".$contenidoElemento[$a]."' ><img src='../Imagenes/ICN_Archivo.png'> </a> ".substr($contenidoElemento[$a], 9, strlen($contenidoElemento[$a]));*/echo $contenidoElemento[$a];
									echo "</td>";
								echo "</tr>";
								echo "<tr height='10'> </tr>";
							echo "</table>";
					/*	} else{
							echo "<table>";	
								echo "<tr>";
									echo "<td width='30px'> </td>";
									echo "<td width='670' id='fileItem'  align='justify'>";
										echo $contenidoElemento[$a];
									echo "</td>";
								echo "</tr>";
								echo "<tr height='10'> </tr>";
							echo "</table>";	
						}*/
					  
					//}
					
			
					/*echo "<table>";	
						echo "<tr>";
							echo "<td width='30px'> </td>";
							echo "<td width='670' id='fileItem'  align='justify'>";
								echo $contenidoElemento[$a];
							echo "</td>";
						echo "</tr>";
					echo "</table>";	*/
				}
					
				echo "<table>";		
					echo "<tr height='10px'> </tr>";
				echo "</table>";
		}
	}
	
	
	
	if($tipo == "C"){
		$i = 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido, xt_titulo, xt_outLine, kp_capituloElementoID FROM SGI_CapituloElemento 
								WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$numeroElemento[$i] = $r[0];
			$tipoElemento[$i] = $r[1];
			$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[2]));
			$titulo[$i] = trim($r[3]);
			
			$outLine[$i] = $r[4];
			$subnivel = (explode('.', trim($outLine[$i])));
			$nivel[$i] = count($subnivel);
			
			$elementoCapID[$i] = $r[5];
			
			$refIso[$i] = "";
			$refNmx[$i] = "";
			$refNeec[$i] = "";
			$refDoc[$i] = "";
			
			$u = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $elementoCapID[$i] AND xt_norma = 'ISO' ");
			while($t = $u->fetchRow()){
				$capitulo = explode(".", $t[0]);
				$refIso[$i] = $refIso[$i]."<a href='Capitulo.php?norma=ISO&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
			} unset($t); unset($u);
			
			$u = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $elementoCapID[$i] AND xt_norma = 'NMX' ");
			while($t = $u->fetchRow()){
				$capitulo = explode(".", $t[0]);
				$refNmx[$i] = $refNmx[$i]."<a href='Capitulo.php?norma=NMX&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
			} unset($t); unset($u);
			
			$u = $INTRANET->Execute("SELECT kf_codigoID FROM SGI_CapituloElemento_Certificaciones WHERE kf_capituloElementoID = $elementoCapID[$i] AND xt_norma = 'NEEC' ");
			while($t = $u->fetchRow()){
				$capitulo = explode(".", $t[0]);
				$refNeec[$i] = $refNeec[$i]."<a href='Capitulo.php?norma=NEEC&capitulo=".trim($capitulo[0])."#".trim($t[0])."' id='breadcrumbs' >$t[0]</a>; ";
			} unset($t); unset($u);
			
			$u = $INTRANET->Execute("SELECT xt_docCodigo FROM SGI_CapituloElemento_Referencia WHERE kf_capituloElementoID = $elementoCapID[$i] ");
			while($t = $u->fetchRow()){
				$idDocRef = trim($t[0]);
				$claveRef = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $idDocRef ");
				$tituloDocRef = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $idDocRef ");
				
				//$idDocRef = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$clave' ");
				$refDoc[$i] = $refDoc[$i]."<a href='FichaItem.php?id=".$idDocRef."' id='breadcrumbs'>".$claveRef." ".$tituloDocRef."</a><br>";
				
			} unset($t); unset($u);
			
			$i++;
		}
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Elementos</b></td>";
				echo "<td align='right' width='15px'>";
					echo "<a href='AgregarElementoCapituloPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=900,scrollbars=yes')\"> 
						  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		for($a = 1; $a <= count($numeroElemento); $a++){
			
			
			if(substr($contenidoElemento[$a], -4) == ".pdf"){
				echo "<br><br><object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($contenidoElemento[$a]))."'\" type='application/pdf'  width='950px' height='700px'>
						  <p>Si este mensaje aparece su navegador no soporta el plugin para el PDF.
						  </p>
					  </object><br><br>";
			} else{
		
				if($nivel[$a] == 1){
					$ancho = 680;
				} else if($nivel[$a] == 2){
					$ancho = 660;
				} else if($nivel[$a] == 3){
					$ancho = 640;
				} else if($nivel[$a] == 4){
					$ancho = 620;
				} else if($nivel[$a] == 5){
					$ancho = 600;
				} else if($nivel[$a] == 6){
					$ancho = 580;
				} else if($nivel[$a] == 7){
					$ancho = 560;
				} else if($nivel[$a] == 8){
					$ancho = 540;
				} else if($nivel[$a] == 9){
					$ancho = 520;
				}
				
				echo "<table border='0' align='center'>";
					if($titulo[$a] != ""){
						echo "<tr>";
							echo "<td> </td>";
							echo "<td align='left' id='fichaRef'><b>$outLine[$a] $titulo[$a]</b></td>";
						echo "</tr>";
					}
					
					if($refIso[$a] != "" || $refNmx[$a] != "" || $refNeec[$a] != ""){
						echo "<tr>";
							echo "<td> </td>";
							echo "<td align='left' id='breadcrumbs'>";
							
							$indicador = 0;
							
							if($refIso[$a] != ""){
								echo "ISO: ";
								
								echo substr($refIso[$a], 0, -2);
								$indicador++;
							}
							
							if($refNmx[$a] != ""){
								
								if($indicador >= 1){
									echo " / NMX: ".substr($refNmx[$a], 0, -2);
								} else{
									echo "NMX: ".substr($refNmx[$a], 0, -2);
								}
								$indicador++;
							}
							
							if($refNeec[$a] != ""){
								if($indicador >= 1){
									echo " / NEEC: ".substr($refNeec[$a], 0, -2);
								} else{
									echo "NEEC: ".substr($refNeec[$a], 0, -2);
								}
							}
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='5px'> </tr>";
					}
					
					if($refDoc[$a] != ""){
						echo "<tr>";
							echo "<td> </td>";
							echo "<td align='left' id='breadcrumbs'>$refDoc[$a]</td>";
						echo "</tr>";
					}
					
					echo "<tr height='10px'> </tr>";
					//////AJUSTE DEL ANCHO DE LA TABLA (SANGRIA)
					echo "<tr>";
						echo "<td width='".(700-$ancho)."'> </td>";
						echo "<td width='$ancho' id='fileItem' align='justify'>$contenidoElemento[$a]</td>";
					echo "</tr>";
					
					echo "<tr height='20px'> </tr>";
					
				echo "</table>";
					
			}
				
			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
		}
	}
	
	
	if($tipo == "F" && $area != 'CRM'){
		
		$i = 1;
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$numeroElemento[$i] = $r[0];
			$tipoElemento[$i] = $r[1];
			
			if(($tipoElemento[$i] == 'DESARROLLOT') || ($tipoElemento[$i] == 'DESARROLLOA')){
				$tipoElemento[$i] = "DESARROLLO";
			}
			
			$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[2]));
			$i++;
		}
		
		$bandera = 0;
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Formato</b></td>";
				echo "<td align='right' width='15px'>";
					echo "<a href='AgregaElementos/AgregarElementoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
						  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		for($a = 1; $a <= count($numeroElemento); $a++){
			
			if(substr($contenidoElemento[$a], 0, 9) == "../FILES/"){
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='670' id='fileItem'  align='justify'>";
							echo "<a href='downloadItem.php?file=".$contenidoElemento[$a]."' ><img src='../Imagenes/ICN_Archivo.png'> </a> ".substr($contenidoElemento[$a], 9, strlen($contenidoElemento[$a]));
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10'> </tr>";
				echo "</table>";
			} else{
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='670' id='fileItem'  align='justify'>";
							echo $contenidoElemento[$a];
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10'> </tr>";
				echo "</table>";	
			}
				
			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
		
		}
		//CONTROL DE REGISTROS
		
		if(!$INTRANET->getOne("SELECT kp_registroID FROM SGI_Registro_Contenido WHERE kf_itemID = $itemID ")){
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Control del registro</b></td>";
					echo "<td align='right' width='15px'>";
						echo "<a href='AgregarContenidoFormatoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
							  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
		} else{
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Control del registro</b></td>";
					echo "<td align='right' width='15px'>";
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
	
			$s = $INTRANET->Execute("SELECT xt_origen, xt_tipo, xt_responsable, xt_almacenamiento, xt_proteccion, xt_recuperacion, xt_retencion, xt_disposicion FROM SGI_Registro_Contenido where kf_itemID = $itemID ");
			
			while($r = $s->fetchRow()){
				$origen = $r[0];
				$tipoF = $r[1];
				$responsable = $r[2];
				$almacenamiento = $r[3];
				$proteccion = $r[4];
				$recuperacion = $r[5];
				$retencion = $r[6];
				$disposicion = $r[7];
				
			} unset($r); unset($s);
			
			echo "<table border='0' align='center'>";
				
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Origen: $origen</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Tipo: $tipoF</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Responsable: $responsable</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Almacenamiento: $almacenamiento</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Protección: $proteccion</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Recuperación: $recuperacion</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Retención: $retencion</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Disposición: $disposicion</td>";
				echo "</tr>";
			echo "</table>";
		}
	}
	
	// FORMATOS REGISTRADOS
	//echo"SELECT xt_codigo FROM SGI_Item where kp_itemID = $itemID ";
	
	$formatoRegistro = $INTRANET->GetOne("SELECT xt_codigo FROM SGI_Item where kp_itemID = $itemID ");
	
	for($allTypes=0; $allTypes<count($formatoCategoria); $allTypes++){		
	//for($allTypes = 1; $allTypes <= 16; $allTypes++){
   				
			if(($formatoRegistro) == ($formatoCategoria[$allTypes])){				
			
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Referencias
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='685px'><b>Registros</b></td>";
						
						echo "<td align='right' width='15px'>";
							echo "<a href='../Registros/altaRegistroItem.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=900,height=800,scrollbars=yes')\"> 
								  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
						echo "</td>";
					echo "</tr>";
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='2'></td>";
					echo "</tr>";
					
					echo"<tr height='30px'> </tr>";
					
					echo"<tr>";
						$s = $INTRANET->Execute("SELECT xt_tituloRegistro, kp_registroID, xt_ruta FROM SGI_Registros WHERE kf_itemID = $itemID ORDER BY xd_fecha ASC");
					
							while($r = $s->fetchRow()){
							
							$tituloRegistro = $r[0];
							$resgitroID		= $r[1];
							$archivo		= $r[2];
							
							echo "<td id='iconosTexto'><a id='iconosTexto' href='../Registros/fichaRegistro.php?id=".$resgitroID."'>".$tituloRegistro."</td>";
								if($archivo != ""){
									echo"<td> <a href='../Registros/downloadRegistro.php?file=".$archivo."'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
								}
						
							
							
					echo"</tr>";
											}
					echo"<tr height='20px'> </tr>";
				echo "</table>";
			
			}//fin de if registros
	}//fin de formatos registrados 
	
	//Seccion para formato CRM con relacion a la solicitud del entregable
	if($tipo == "F" && $area == 'CRM'){
		
		$i = 1;
		//$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
		$s = $INTRANET->Execute("SELECT xt_codigoReporte, xt_nombreArchivo, xt_quejaSolicitud, xt_ruta FROM SGI_Backlog_Informacion_Reportes WHERE xt_codigoReporte = '$codigo' ");
		
		while($r = $s->fetchRow()){
			$tipoElemento[$i] = $r[0];
			$solicitud[$i]    = $r[2];
			$ruta[$i]         = $r[3];
			
			if(($tipoElemento[$i] == 'DESARROLLOT') || ($tipoElemento[$i] == 'DESARROLLOA')){
				$tipoElemento[$i] = "DESARROLLO";
			}
			
			$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[1]));
			$i++;
		}
		
		$bandera = 0;
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Formato</b></td>";
				echo "<td align='right' width='15px'>";
				/*	echo "<a href='AgregaElementos/AgregarElementoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
						  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";*/
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		for($a = 1; $a <= count($contenidoElemento); $a++){
			
			if($contenidoElemento[$a] != ''){
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='670' id='fileItem'  align='justify'>";
							echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctosReporte.php?nombreA=$contenidoElemento[$a]&ruta=$ruta[$a]'><img src='../Imagenes/ICN_Archivo.png'> </a> ".$contenidoElemento[$a];
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10'> </tr>";
				echo "</table>";
			} /*else{
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='670' id='fileItem'  align='justify'>";
							echo $contenidoElemento[$a];
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10'> </tr>";
				echo "</table>";	
			//}*/
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Solicitud relacionada</b></td>";
					echo "<td align='right' width='15px'>";
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
	
			$s = $INTRANET->Execute("SELECT
										xt_quejaSolicitud
									FROM
										SGI_Backlog_Informacion_Reportes
									WHERE
										xt_codigoReporte = '$codigo' ");
			
			while($r = $s->fetchRow()){
				$codigoSolicitud     = $r[0];
				
			} unset($r); unset($s);
			
			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/casoUsoBacklog.php?codigo=$codigoSolicitud'>$codigoSolicitud</a></td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Parámetros</b></td>";
					echo "<td align='right' width='15px'>";
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
	
			$s = $INTRANET->Execute("SELECT
										xt_quejaSolicitud,
										xt_codigoReporte,
										xt_cliente,
										xt_solicitanteOriginal,
										xt_responsableEnvio,
										xt_responsableReenvio,
										xt_descripcion,
										xt_periodicidad,
										xt_parametros,
										xt_listaDistribucion,
										xt_modoEnvio,
										xt_sistema
									FROM
										SGI_Backlog_Informacion_Reportes
									WHERE
										xt_codigoReporte = '$codigo' ");
			
			while($r = $s->fetchRow()){
				$codigoSolicitud     = $r[0];
				$codigoReporte       = $r[1];
				$cliente             = $r[2];
				$solicitanteOriginal = $r[3];
				$responsableEnvio    = $r[4];
				$responsableReenvio  = $r[5];
				$descripcion         = $r[6];
				$periodicidadS       = $r[7];
				$parametros          = $r[8];
				$listaDistribucion   = $r[9];
				$modoEnvio           = $r[10];
				$sistema             = $r[11];

				
			} unset($r); unset($s);
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Cliente:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$cliente</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Solicitante original:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$solicitanteOriginal</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Responsable de envío:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$responsableEnvio</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Descripción:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$descripcion</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Periodicidad:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$periodicidadS</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Parámetros de consulta:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$parametros</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Lista de distribución:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$listaDistribucion</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Modo de envío:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$modoEnvio</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' valign='top' id='iconosTexto' width='180px'>";
						echo "<b>Fuente de información:</td>";
					echo "<td align='left' id='iconosTexto' width='500px' colspan='2'>";
						echo "$sistema</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
			echo "</table>";
				/*
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Solicitante original:  </b> $solicitanteOriginal</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Responsable de envío:  </b>$responsableEnvio</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Responsable de reenvío:  </b>$responsableReenvio</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Descripción:  </b>$descripcion</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Periodicidad:  </b>$periodicidadS</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Parámetros de consulta:  </b>$parametros</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Lista de distribución:  </b>$listaDistribucion</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Modo de envío:  </b>$modoEnvio</td>";
				echo "</tr>";
				echo "<tr height='5px'> </tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "<b>Fuente de información:  </b>$sistema</td>";
				echo "</tr>";*/
			echo "</table>";
			
			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
		
		}
		//CONTROL DE REGISTROS
		
		if(!$INTRANET->getOne("SELECT kp_registroID FROM SGI_Registro_Contenido WHERE kf_itemID = $itemID ")){
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Control del registro</b></td>";
					echo "<td align='right' width='15px'>";
						echo "<a href='AgregarContenidoFormatoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\"> 
							  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
		} else{
			echo "<table border='0' align='center'>";
				echo"<tr height='30px'> </tr>";
				///Referencias
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Control del registro</b></td>";
					echo "<td align='right' width='15px'>";
					echo "</td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			echo "</table>";
	
			$s = $INTRANET->Execute("SELECT xt_origen, xt_tipo, xt_responsable, xt_almacenamiento, xt_proteccion, xt_recuperacion, xt_retencion, xt_disposicion FROM SGI_Registro_Contenido where kf_itemID = $itemID ");
			
			while($r = $s->fetchRow()){
				$origen = $r[0];
				$tipoF = $r[1];
				$responsable = $r[2];
				$almacenamiento = $r[3];
				$proteccion = $r[4];
				$recuperacion = $r[5];
				$retencion = $r[6];
				$disposicion = $r[7];
				
			} unset($r); unset($s);
			
			echo "<table border='0' align='center'>";
				
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Origen: $origen</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Tipo: $tipoF</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Responsable: $responsable</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Almacenamiento: $almacenamiento</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Protección: $proteccion</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Recuperación: $recuperacion</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Retención: $retencion</td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td width='30px'> </td>";
					echo "<td align='left' id='iconosTexto' width='670px' colspan='2'>";
						echo "Disposición: $disposicion</td>";
				echo "</tr>";
			echo "</table>";
		}
	}
	
	// FORMATOS REGISTRADOS
	//echo"SELECT xt_codigo FROM SGI_Item where kp_itemID = $itemID ";
	
	$formatoRegistro = $INTRANET->GetOne("SELECT xt_codigo FROM SGI_Item where kp_itemID = $itemID ");
			
	/*for($allTypes = 1; $allTypes <= 15; $allTypes++){
   
			if(($formatoRegistro) == ($formatoCategoria[$allTypes])){				
			
				echo "<table border='0' align='center'>";
					echo"<tr height='30px'> </tr>";
					///Referencias
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='685px'><b>Registros</b></td>";
						
						echo "<td align='right' width='15px'>";
							echo "<a href='../Registros/altaRegistroItem.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=900,height=800,scrollbars=yes')\"> 
								  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
						echo "</td>";
					echo "</tr>";
					///Linea
					echo "<tr>";
						echo "<td id='titleBlueLineBottom' colspan='2'></td>";
					echo "</tr>";
					
					echo"<tr height='30px'> </tr>";
					
					echo"<tr>";
						$s = $INTRANET->Execute("SELECT xt_tituloRegistro, kp_registroID, xt_ruta FROM SGI_Registros WHERE kf_itemID = $itemID ");
					
							while($r = $s->fetchRow()){
							
							$tituloRegistro = $r[0];
							$resgitroID		= $r[1];
							$archivo		= $r[2];
							
							echo "<td id='iconosTexto'><a id='iconosTexto' href='../Registros/fichaRegistro.php?id=".$resgitroID."'>".$tituloRegistro."</td>";
								if($archivo != ""){
									echo"<td> <a href='../Registros/downloadRegistro.php?file=".$archivo."'><img src='../Imagenes/ICN_Archivo.png'></a></td>";
								}
						
							
							
					echo"</tr>";
											}
					echo"<tr height='20px'> </tr>";
				echo "</table>";
			
			}//fin de if registros
	}*///fin de formatos registrados CRM
	
	////Proceso
	if($tipo == "K"){
		
	///NUMERO MAPA = 0, NUMERO ELEMENTO = 1, DESCRIPCION
		$descripcion = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$itemID' AND xn_numeroMapa = 0 AND xn_numeroElemento = 1 ORDER BY xn_numeroElemento ");
		
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
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
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
		$idResponsable = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$itemID'  AND xn_numeroMapa = 0 AND xn_numeroElemento = 3 ORDER BY xn_numeroElemento ");
		
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
					//$apellidoPResponsable 	= $INTRANET->getOne("SELECT xt_ApellidoPaterno FROM SGI_Empleados WHERE kp_personalId = $idResponsable ");
					//$apellidoMResponsable 	= $INTRANET->getOne("SELECT xt_ApellidoMaterno FROM SGI_Empleados WHERE kp_personalId = $idResponsable ");
					
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
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
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
		$diagrama = $INTRANET->getOne("SELECT xt_descripcion FROM SGI_K_Procesos_Elementos WHERE kp_codigo = '$itemID' AND xn_numeroMapa = 0 AND xn_numeroElemento = 2 ORDER BY xn_numeroElemento ");
		
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
							echo "<object data=\"data:Application/pdf,'".rawurlencode(file_get_contents($diagrama))."'\"  type='application/pdf' width='950px' height='700px'>";
								echo "<p>";
									echo "Si este mensaje aparece su navegador no soporta el plugin para el PDF.";
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
						echo "<a href='firmarProceso.php?id=".$idItem."&elemento=Diagrama' target='popup' onclick=\"window.open(this.href,this.target,'width=510,height=400,scrollbars=yes')\">
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
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
							echo "<a href='AgregarElementoProcesoPopUp.php?itemID=".$itemID."&nmapa=d' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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

					if($tipo != "K"){
					echo "<td align='right' width='15px'><a href='AgregaActividad.php?codigo=$codigo&idItem=$idItem' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";

				}else if($tipo == "K"){
					echo "<td align='right' width='15px'><a href='agregarActividadPopUp.php?codigo=$codigo&id=$idItem' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";
                    /*echo "<td align='right' width='15px'><a href='modificarProceso.php?codigo=$codigo&id=$idItem' target='popup' onclick=\"window.open(this.href,this.target,'width=900,height=700,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";*/
				}
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='10px'>";
					if($tipo == "K"){	

			    //tabla de procesos, actividades
				$array =  explode("-",$codigo);
				$proceso = $array[3].$array[4];
				
				//echo"SELECT xt_nombre from SGI_Procesos WHERE kp_codigo = '$codigo'<br><br>";
				$nomProceso = $INTRANET->getOne("SELECT xt_nombre from SGI_Procesos WHERE kp_codigo = '$codigo'");


				$index = 0;
				
				//echo"SELECT PR.kf_codigoRol, R.xt_nombre FROM SGI_Procesos_Roles PR, SGI_Roles R WHERE PR.kf_codigoProceso = '$proceso' AND PR.kf_codigoRol = R.kp_codigo ORDER BY PR.xn_ordenRol ASC";
				$s = $INTRANET->Execute("SELECT PR.kf_codigoRol, R.xt_nombre FROM SGI_Procesos_Roles PR, SGI_Roles R WHERE PR.kf_codigoProceso = '$proceso' AND PR.kf_codigoRol = R.kp_codigo ORDER BY PR.xn_ordenRol ASC");

				while($row = $s->fetchRow()){
					$f[$index] = $row[0];
					$n[$index] = $row[1];
					$index++; 
				}
				$fila = count($f);
				
				
				$numColumnas = $INTRANET->getOne("SELECT xn_totalTiempo FROM SGI_Procesos_Tiempos WHERE kf_codigoProceso = '$proceso'");

				//obtengo los tiempos

				//hago consulta de tiempos

				//echo "SELECT DISTINCT xt_tiempo FROM SGI_Procesos_Roles_Actividades WHERE kf_codigoProcesoRol like '$proceso%' ORDER BY SUBSTRING_INDEX(xt_tiempo, '.', 3)";
				
				$a = $INTRANET->Execute("SELECT DISTINCT
						PRA.xt_tiempo,
						CT.xn_consecutivo,
						CT.kp_tiempo
					FROM
						SGI_Procesos_Roles_Actividades PRA,
						SGI_Catalogo_Tiempos CT
					WHERE
							PRA.kf_codigoProcesoRol LIKE '$proceso%'
						AND PRA.xt_tiempo = CT.kp_tiempo
						ORDER BY CT.xn_consecutivo ASC");
				//$a = $INTRANET->Execute("SELECT DISTINCT xt_tiempo FROM SGI_Procesos_Roles_Actividades WHERE kf_codigoProcesoRol like '$proceso%' ORDER BY SUBSTRING_INDEX(xt_tiempo, '.', 3)");

				$indexT = 0;
				while($row2 = $a->fetchRow()){
					$tiempo[$indexT] = $row2[0];
					$indexT ++;
				}



				//creacion de la matriz

				$tituloMatriz = $numColumnas + 1;
				echo "<table border='1' class='auto' style = 'width:1055px;font-size:10px;'>";

					echo "<tr>
						<td align='center' colspan ='$tituloMatriz'><strong>$codigo / $nomProceso</strong></td>
					</tr>";

				//listo filas
				for($i = 0; $i < $fila; $i++){

				echo "<tr>";

					echo "<td id='roles'><strong>$n[$i]</strong></td>";

				//listo columnas
				for($e = 0; $e < $numColumnas; $e++){


					$procesoRol = $proceso."_".$f[$i];
					//echo "SELECT RA.kf_codigoActividad, A.xt_nombre from SGI_Procesos_Roles_Actividades RA, SGI_Actividades A WHERE RA.kf_codigoProcesoRol = '$procesoRol' AND RA.xt_tiempo = '$tiempo[$e]' AND RA.kf_codigoActividad = A.kp_codigo";
			//echo "<br>";
				
					$actividad = $INTRANET->execute("SELECT RA.kf_codigoActividad, A.xt_nombre from SGI_Procesos_Roles_Actividades RA, SGI_Actividades A WHERE RA.kf_codigoProcesoRol = '$procesoRol' AND RA.xt_tiempo = '$tiempo[$e]' AND RA.kf_codigoActividad = A.kp_codigo");

					$indexA = 0;
					while($row3 = $actividad->fetchRow()){
						$arrayActividad[$indexA] = $row3[0];
						$arrayDescripcionActividad[$indexA] = $row3[1];
						$indexA++;
					}unset($indexA);


					if($actividad->recordCount() > 0){
					//echo count($arrayActividad);
					//echo "<br>";
						echo "<td>";

						for($l = 0; $l < $actividad->recordCount(); $l++){
							
							echo $l+1;
							echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaActividadFuncionalidad.php?proceso=$codigo&actividad=$arrayActividad[$l]&rol=$n[$i]' style='text-decoration:none;' id='textoActividad'>- $arrayDescripcionActividad[$l]</a>";
							echo "<br><br>";
							
							//echo "- $arrayDescripcionActividad[$l] <br><br>";
					
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

	}//fin del if de verificacion de K	
				echo "</tr>";
			echo "</table>";
			
			//nombre de actividad
			echo "<table border='0' align='center' width='650'>";
			
				echo"<tr height='10px'> </tr>";
				///titulo
				$s = $INTRANET->Execute("SELECT xt_nombre, kp_actividadID FROM SGI_Procesos_Actividades WHERE kf_itemID = $itemID ");
				
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
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 1 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			if(($r[0] != "") && ($r[3] == "ITEM")){
			
				$procesosAntecesores[$indice]	= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$tituloPAntecesores[$indice] 	= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$descripcionPAnt[$indice]		= "";
				$link[$indice] 					= "FichaItem.php?id=".$r[0];
				
			} else{
				$procesosAntecesores[$indice]	= "";
				$tituloPAntecesores[$indice] 	= $r[1];
				$descripcionPAnt[$indice]		= $r[2];
				$link[$indice]					= "";
				
				if($descripcionPAnt[$indice] != ""){
					$descripcionPAnt[$indice]= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionPAnt[$indice]));
				}
			}
			
			$indice++;
			
		} unset($r);
        
        //FUNCIONALIDADES
        
		
			echo "<table border='0' align='center' width='955px'>";
			
				echo"<tr height='10px'> </tr>";
				///titulo
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Funcionalidades</b></td>";

					if($tipo != "K"){
					echo "<td align='right' width='15px'><a href='AgregaActividad.php?codigo=$codigo&idItem=$idItem' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";

				}else if($tipo == "K"){
					/*echo "<td align='right' width='15px'><a href='agregarActividadPopUp.php?codigo=$codigo&id=$idItem' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";
                    echo "<td align='right' width='15px'><a href='modificarProceso.php?codigo=$codigo&id=$idItem' target='popup' onclick=\"window.open(this.href,this.target,'width=900,height=700,scrollbars=yes')\">
						<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";*/
				}
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
            echo "</table>";
            
            
					if($tipo == "K"){
                        echo "<table border='0' align='center' width='1020px'>";
                            echo "<tr>";
                                echo "<td>";
                                    echo "<strong>Codigo Funcionalidad</strong>";
                                echo "</td>";
                                echo "<td>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<strong>Nombre</strong>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<strong>Codigo Actividad</strong>";
                                echo "</td>";
                                echo "<td>";
                                echo "</td>";
                                echo "<td>";
                                    echo "<strong>Nombre</strong>";
                                echo "</td>";
                            echo "</tr>";
                       $f = $INTRANET->Execute("SELECT
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
                                                ");
                       while($v = $f->fetchRow()){
                           $act = explode("_",$v[0]);
                           $actividad = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Actividades WHERE kp_codigo = '$act[2]'");
                           $proceso1  = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Procesos WHERE xt_codigoCorto = '$act[0]'");
                           $rol1      = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Roles WHERE kp_codigo = '$act[1]'");
                            echo "<tr>";
                                echo "<td>";
                                     echo "<i>".$v[0]."_".$v[2]."</i>";
                                echo "</td>";
                                echo "<td>";
                                echo "</td>";
                                echo "<td width='500'>";
                                    echo "<a href='fichaFuncionalidadCasoUso.php?codigo=$v[4]'>".$v[1]."</a>";
                                echo "</td>";
                            echo "<td>";
                                    echo "<i>".$v[0]."</i>";
                                echo "</td>";
                                echo "<td>";
                                echo "</td>";
                                echo "<td width='300'>";
                                    echo "<a href='fichaActividadFuncionalidad.php?proceso=$proceso1&actividad=$act[2]&rol=$rol1'>".$actividad."</a>";;
                                echo "</td>";
                            echo "</tr>";
                       }
                    echo "</tr>";
                    echo "</table>";
                    }
               
        
        /****************************************************************************************************/
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Procesos antecesores
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>1.- Procesos antecesores</b></td>";
				echo "<td align='right'>";
					//Agregar proceso antecesor
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Lizbeth_Guadarrama') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=1' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
					
					if($descripcionPAnt[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>$descripcionPAnt[$i]</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
					
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
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 2 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			if(($r[0] != "") && ($r[3] == "ITEM")){
				
				$procesosApoyo[$indice]	= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$tituloPApoyo[$indice] 	= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$descripcionPAp[$indice]= "";
				$link[$indice] 			= "FichaItem.php?id=".$r[0];
				
			} else{
				$procesosApoyo[$indice]	= "";
				$tituloPApoyo[$indice] 	= $r[1];
				$descripcionPAp[$indice]= $r[2];
				$link[$indice] 			= "";
				
				if($descripcionPAp[$indice] != ""){
					$descripcionPAp[$indice]= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionPAp[$indice]));
				}
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Procesos de apoyo
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>2.- Procesos de apoyo</b></td>";
				echo "<td align='right'>";
					//Agregar proceso de apoyo
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=2' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 3 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			if(($r[0] != "") && ($r[3] == "ITEM")){	
					
				$procesosSucesores[$indice]	= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$tituloPSucesores[$indice] 	= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$descripcionSuce[$indice]	= "";
				$link[$indice] 				= "FichaItem.php?id=".$r[0];
				
			} else{
				$procesosSucesores[$indice]	= "";
				$tituloPSucesores[$indice] 	= $r[1];
				$descripcionSuce[$indice]	= $r[2];
				$link[$indice]				= "";
				
				if($descripcionSuce[$indice] != ""){
					$descripcionSuce[$indice]= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionSuce[$indice]));
				}
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Procesos sucesores
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>3.- Procesos sucesores</b></td>";
				echo "<td align='right'>";
					//Agregar proceso sucesores
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=3' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
					
					if($descripcionSuce[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>$descripcionSuce[$i]</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 4, ENTRADAS
		
		$entradas 				= NULL;
		$descripcionEntrada 	= NULL;
		$tituloEntrada			= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 4 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			
			if(($r[0] != "") && ($r[3] == "ITEM")){
				
				$entradas[$indice]				= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$tituloEntradas[$indice] 		= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$descripcionEntrada[$indice]	= "";
				$link[$indice] 					= "FichaItem.php?id=".$r[0];
				
			} else{
				$entradas[$indice]				= "";
				$tituloEntradas[$indice] 		= $r[2];
				$descripcionEntrada[$indice] 	= $r[1];
				
				$link[$indice] = "";
				
				if($descripcionEntrada[$indice] != ""){
					$descripcionEntrada[$indice]= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionEntrada[$indice]));
				}
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Entradas
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>4.- Entradas</b></td>";
				echo "<td align='right'>";
					//Agregar entradas
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=4' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
			
			if($tituloEntradas  != NULL){
				for($i = 1; $i <= count($tituloEntradas); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						
						if($entradas[$i] != ""){
							echo "<td align='left' valign='top'>";
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$entradas[$i]</a>";
							echo "</td>";
							
							echo "<td align='left'> </td>";
							
							echo "<td align='left' colspan='2'>";
									echo "$tituloEntradas[$i]";
							echo "</td>";
						} else{
							echo "<td align='left' valign='top' colspan='4'>";
								echo "$i. $tituloEntradas[$i]";
							echo "</td>";
						}
						
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					if($descripcionEntrada[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>$descripcionEntrada[$i]</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 5, SALIDAS
		
		$salidas 				= NULL;
		$tituloSalida			= NULL;
		$descripcionSalida	 	= NULL;
		
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 5 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			
			if(($r[0] != "") && ($r[3] == "ITEM")){
				
				$salidas[$indice]					= $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$tituloSalida[$indice] 				= $INTRANET->getOne("SELECT xt_nombre FROM SGI_Item WHERE kp_itemID = $r[0] ");
				$descripcionSalida[$indice]			= "";
				$link[$indice] = "FichaItem.php?id=".$r[0];
				
			} else{
				
				$salidas[$indice]					= "";
				$tituloSalida[$indice] 				= $r[2];
				$descripcionSalida[$indice]			= $r[1];
				
				$link[$indice] = "";
				
				if($descripcionSalida[$indice] != ""){
					$descripcionSalida[$indice] 	= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionSalida[$indice]));
				}
				
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Salida
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>5.- Salidas</b></td>";
				echo "<td align='right'>";
					//Agregar salidas
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=5' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
			
			if($tituloSalida  != NULL){
				for($i = 1; $i <= count($tituloSalida); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						if($salidas[$i] != ""){
							echo "<td align='left' valign='top'>"; 
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$salidas[$i]</a>";
							echo "</td>";
							
							echo "<td align='left'> </td>";
							
							echo "<td align='left' colspan='2'>$tituloSalida[$i]</td>";
						} else{
							echo "<td align='left' valign='top' colspan='4'>";
								echo "$i. $tituloSalida[$i]";
							echo "</td>";
						}
						
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					if($descripcionSalida[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>$descripcionSalida[$i]</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 6, EQUIPO/INSUMOS
		
		$descripcionEquipos	 	= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 6 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			
			$descripcionEquipos[$indice] 	= $r[0];
			
			$descripcionEquipos[$indice] 	= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionEquipos[$indice]));
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Equipos e Insumos
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>6.- Equipos/Insumos</b></td>";
				echo "<td align='right'>";
					//Agregar equipos e insumos
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=6' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
		
		$compliance				= NULL;
		$tituloCompliance		= NULL;
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_titulo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 7 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			
			if($r[0] != ""){
				$compliance[$indice]				= trim($r[0]);
				$tituloCompliance[$indice]			= $r[1];
				
				if($tituloCompliance[$indice] == 'ISO'){
				
					$capitulo = (explode(".", $compliance[$indice]));
					
					$link[$indice] = "<a href='Capitulo.php?norma=ISO&capitulo=".$capitulo[0]."#$compliance[$indice]' id='fichaRef' >ISO $compliance[$indice]</a>";
					
				} else if($tituloCompliance[$indice] == 'NMX'){
				
					$capitulo = (explode(".", $compliance[$indice]));
					
					$link[$indice] = "<a href='Capitulo.php?norma=NMX&capitulo=".$capitulo[0]."#$compliance[$indice]' id='fichaRef' >NMX $compliance[$indice]</a>";
					
				} else if($tituloCompliance[$indice] == 'NEEC'){
				
					$capitulo = (explode(".", $compliance[$indice]));
					
					$link[$indice] = "<a href='Capitulo.php?norma=NEEC&capitulo=".$capitulo[0]."#$compliance[$indice]' id='fichaRef' >NEEC $compliance[$indice]</a>";
					
				}
				
				
			} else{
				$compliance[$indice]				= "";
				$tituloCompliance[$indice]			= $r[1];
				
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>7.- Compliance</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=7' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
			
			if($compliance  != NULL){
				for($i = 1; $i <= count($compliance); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' valign='top' colspan='4'>"; 
						if($compliance[$i] != ""){
							echo "$link[$i]";
						} else{
							echo "$tituloCompliance[$i]";
						}
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
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 8 ORDER BY xn_numeroElemento ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
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
		
		$s = $INTRANET->Execute("SELECT xt_titulo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 9 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			//if($r[0] != ""){
				//$stakeholder[$indice]				= trim($r[0]);
				//$descripcionStakeholder[$indice] 	= $r[1];
				$tituloStakeholder[$indice]			= $r[0];
				
				//$link[$indice]						= "";
			/*	
			} else{
				$stakeholder[$indice]				= "";
				$descripcionStakeholder[$indice] 	= $r[1];
				$tituloStakeholder[$indice]			= $r[2];
				$link[$indice]						= "";
				
				if($descripcionStakeholder[$indice] != ""){
					$descripcionStakeholder[$indice] 	= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionStakeholder[$indice]));
				}
			}*/
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>9.- Stakeholders (puestos y roles)</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=9' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
			
			if($tituloStakeholder  != NULL){
				for($i = 1; $i <= count($tituloStakeholder); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						/*if($stakeholder[$i] != ""){
							echo "<td align='left' valign='top' colspan='4'>"; 
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$i. ";
							//echo "</td>";
							echo $stakeholder[$i]."</a>";
							echo $tituloStakeholder[$i];
							echo "</td>";
						} else{*/
							echo "<td align='left' valign='top' colspan='4'>$i. $tituloStakeholder[$i]</td>";
						//}
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					if($descripcionStakeholder[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>$descripcionStakeholder[$i]</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		unset($link);
	///NUMERO MAPA = 10, RIESGOS
		
		$riesgos			= NULL;
		$descripcionRiesgos	= NULL;
		$indice 			= 1;
		
		$s = $INTRANET->Execute("SELECT xt_docCodigo, xt_descripcion, xt_titulo, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 10 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			
			$riesgos[$indice]				= $INTRANET->getOne("SELECT xt_codigoRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $r[0] ");
			$descripcionRiesgos[$indice] 	= $r[1];
			
			if($r[3] == "RIESGO"){
				
				$idRiesgo[$indice] 		= $r[0];
				
				$tituloRiesgo[$indice] 	= $INTRANET->getOne("SELECT xt_tituloRiesgo FROM SGI_Riesgos WHERE kp_riesgoId = $r[0] ");
				
			} else{
				
				$tituloRiesgo[$indice] 	= $r[2];
				
			}
			if($descripcionRiesgos[$indice] != ""){
				
				$descripcionRiesgos[$indice] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionRiesgos[$indice]));
				
			}
			
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>10.- Riesgos</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=".$itemID."&nmapa=10' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
			
			if($riesgos  != NULL){
				for($i = 1; $i <= count($riesgos); $i++){
					if($riesgos[$i] != ""){
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'> </td>";
							echo "<td align='left'>";
								echo "<a href='fichaRiesgo.php?id=".$idRiesgo[$i]."' style='text-decoration:none;' id='iconosTexto'>".$riesgos[$i]."</a>";
							echo "</td>";
							echo "<td align='left' colspan='3'>";
								echo $tituloRiesgo[$i];
							echo "</td>";
						echo "</tr>";
					} else{
						echo "<tr id='iconosTexto'>";
							echo "<td align='left'> </td>";
							echo "<td align='left' colspan='4'>";
								echo "<a href='vincularRiesgo.php?id=".$itemID."&nElemento=".$i."' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">";
									echo "<img src='../Imagenes/ICN_Boton_Azul.png'>";
								echo "</a> ";
								echo $tituloRiesgo[$i];
							echo "</td>";
						echo "</tr>";
					}
					echo"<tr height='5px'> </tr>";
					
					if($descripcionRiesgos[$i] != ""){
						echo "<tr id='fileItem'>";
							echo "<td align='left'> </td>";
							echo "<td align='justify' colspan='4'>".$descripcionRiesgos[$i]."</td>";
						echo "</tr>";
						
						echo"<tr height='10px'> </tr>";
					}
					
				}
				
			}
			
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
	///NUMERO MAPA = 11, INDICADORES
		
		$indicadores			= NULL;
		$nombreIndicadores		= NULL;
		$formulaIndicadores		= NULL;
		$valorIndicadores		= NULL;
		$periodicidad			= NULL;
		
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xn_numero, xt_nombre, xt_formula, xt_valor, xt_periodicidad FROM SGI_Procesos_Indicadores WHERE kf_itemID = $itemID ORDER BY xn_numero ");
		
		while($r = $s->fetchRow()){
			$indicadores[$indice]				= $r[0];
			$nombreIndicadores[$indice] 		= $r[1];
			$formulaIndicadores[$indice] 		= $r[2];
			$valorIndicadores[$indice]			= $r[3];
			$periodicidad[$indice]				= $r[4];
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>11.- Indicadores</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='AgregarElementoProcesoPopUp.php?itemID=$itemID&nmapa=11' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
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
			
			if($indicadores  != NULL){
				for($i = 1; $i <= count($indicadores); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$nombreIndicadores[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left'> </td>";
						echo "<td align='left' valign='top' id='fileItem'>Fórmula:</td>";
						echo "<td align='justify' valign='top' id='fileItem'>$formulaIndicadores[$i]</td>";
						echo "<td align='left'> </td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left'> </td>";
						echo "<td align='left' valign='top' id='fileItem'>Valor:</td>";
						echo "<td align='justify' valign='top' id='fileItem'>$valorIndicadores[$i]</td>";
						echo "<td align='left'> </td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
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
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
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
            //echo "SELECT xt_tipoDocumento FROM SG_Backlog_Documentos WHERE xt_quejaSolicitud = '$solicitudID'";
			//echo"SELECT DISTINCT xt_tipoDocumento FROM SGI_Documentos_Procesos WHERE xt_codigo = '$codigo'";
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
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/eliminaDoctosFichaActividad.php?codigo=".$codigo."&nombreA=".$listA[0]."&ruta=".$listA[3]."&nombrephp=".$nombrephp."&item=".$itemID."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
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
                                echo "<iframe src='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/uploadArchivosActividadFuncionalidad.php?codigo=".$codigo."&usuario=".$usuarioId."&nombrephp=$nombrephp&itemId=$itemID&tipoArchivo=".$row[0]."' frameborder='0' width='800px' height='150px'></iframe><br>";
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
			$signaturaVal = $INTRANET->getOne("SELECT xt_signatura FROM SGI_Procesos WHERE kp_codigo = '$codigo'");
			if($signaturaVal == ''){
				echo "<form name='form1' method='post' action = 'FichaItem.php?id=$idItem'>";
					echo "<tr id='iconosTexto' class='loadSignatura' >";
						echo "<td align='right'></td>";
						echo "<td align='center' colspan='3'><input type='text' name='signatura' placeholder='Agrega....' id='signatura'>
						<input type='hidden' name='codigo' value='$codigo'>";
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


		/**                      */
		

	///NUMERO MAPA = 12, NOTAS
		
		$notas					= NULL;
		$tituloNota				= NULL;
		$descripcionNota		= NULL;
		
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_titulo, xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 12 ORDER BY xn_numeroElemento ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
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
		
		$oportunidad					= NULL;
		$tituloOportunidad				= NULL;
		$descripcionOportunidad			= NULL;
		
		$indice 				= 1;
		
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_titulo, xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 13 ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$oportunidad[$indice]				= $r[0];
			$tituloOportunidad[$indice]			= $r[1];
			$descripcionOportunidad[$indice] 	= $r[2];
			
			if($descripcionOportunidad[$indice] != ""){
				$descripcionOportunidad[$indice] 	= str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($descripcionOportunidad[$indice]));
			}
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>Áreas de Oportunidad</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
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
			
			if($oportunidad  != NULL){
				for($i = 1; $i <= count($oportunidad); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$tituloOportunidad[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$descripcionOportunidad[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='10px'> </tr>";
				}
				
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
				//echo "</table>";
				
			}
		/*	
			echo"<tr height='20px'> </tr>";
			echo "<table border='0' align='center'>";
				///Competencia
				echo "<tr id='iconosTexto'>";
					echo "<td align='left' colspan='4' valign='top'>";
						echo "Liberado por: $usuarioLibera";
					echo "</td>";
				echo "</tr>";
				echo "<tr id='iconosTexto'>";
					echo "<td align='left' colspan='4' valign='top'>";
						echo "fecha: $fechaLibera";
					echo "</td>";
				echo "</tr>";
				
				//echo"<tr height='20px'> </tr>";*/
			echo "</table>";
		}
		
	/*	echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'></td>";
				echo "<td align='right'>";
				echo "</td>";
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
			
			echo"<tr height='20px'> </tr>";
			
		echo "</table>";*/
		
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
		
		
	}
	
	if($tipo == "M"){
		
		$i = 1;
		$s = $INTRANET->Execute("SELECT xn_numeroElemento, xt_tipo, xt_contenido FROM SGI_Elementos WHERE kf_itemID = $itemID ORDER BY xn_numeroElemento ");
		
		while($r = $s->fetchRow()){
			$numeroElemento[$i] = $r[0];
			$tipoElemento[$i] = $r[1];
			$contenidoElemento[$i] = str_replace("\t"," <span style='display:inline; white-space:pre;'> </span> ", nl2br($r[2]));
			$i++;
		}
		
		$bandera = 0;
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='685px'><b>Contenido</b></td>";
				echo "<td align='right' width='15px'>";
					echo "<a href='AgregaElementos/AgregarElementoPopUp.php?itemID=$itemID' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=700,scrollbars=yes')\"> 
						  <img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
				echo "</td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		for($a = 1; $a <= count($numeroElemento); $a++){
			if(substr($contenidoElemento[$a], 0, 9) == "../FILES/"){
				echo "<table width='700px'>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='60px' id='fileItem' align='justify' valign='top'>";
							echo "Paso $a </td>";
						echo "<td width='610px' id='fileItem' align='justify'>";
							echo "<a href='downloadItem.php?file=".$contenidoElemento[$a]."' >";
								echo "<img src='../Imagenes/ICN_Archivo.png'>";
							echo " </a> ".substr($contenidoElemento[$a], 9, strlen($contenidoElemento[$a]));
						echo "</td>";
					echo "</tr>";
					echo "<tr height='10px'> </tr>";
				echo "</table>";
			} else{
				echo "<table>";	
					echo "<tr>";
						echo "<td width='30px'> </td>";
						echo "<td width='60px' id='fileItem'  align='justify' valign='top'>";
							echo "Paso $a </td>";
						echo "<td width='610px' id='fileItem'  align='justify'>$contenidoElemento[$a]</td>";
					echo "</tr>";
					echo "<tr height='10px'> </tr>";
				echo "</table>";	
			}
				
			echo "<table>";		
				echo "<tr height='10px'> </tr>";
			echo "</table>";
		
		}
		
		
		
	}
	
	if($cambioDesc != (NULL)){
		
		echo "<table border='0' align='center'>";
			echo"<tr height='30px'> </tr>";
			///Referencias
			echo "<tr id='titulo2'>";
				echo "<td align='left' width='700px'><b>Control de Cambios</b></td>";
			echo "</tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td align='center' id='iconosTexto2'>Versión</td>";
				echo "<td align='left' id='iconosTexto2'>Descripción</td>";
				echo "<td align='center' id='iconosTexto2'>Fecha</td>";
				echo "<td align='center' id='iconosTexto2'>Iniciales</td>";
			echo "</tr>";
			
			echo "<tr height='10px'> </tr>";
				
			for($a = 0; $a <= count($version); $a++){
				echo "<tr>";
					echo "<td width='100px' align='center' id='fileItem'>$version[$a]</td>";
					echo "<td align='left' width='420px' id='fileItem'>$cambioDesc[$a]</td>";
					echo "<td align='center' width='80px' id='fileItem'>$fechaVersion[$a]</td>";
					echo "<td align='center' width='100' id='fileItem'>$iniciales[$a]</td>";
				echo "</tr>";
				echo "<tr height='10px'> </tr>";
					
			}
		
		echo "</table>";
	}
	
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'><td width='550px'> </td><td width='150px'> </td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs' width='700px'>";
				echo "<i><a href='imprimeItem.php?id=".$idItem."' id='breadcrumbs'>Imprimir</a></i>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		if($tipo == 'K'){
			
			$firmaAutorizada = $INTRANET->getOne("SELECT SGE.kp_personalId FROM SGI_Empleados SGE WHERE SGE.kf_usuario = '$usuarioId' ");
			
			if ($firmaAutorizada == $idResponsable){
				echo "<td align='right'>";
					echo "<a href='firmarProceso.php?id=".$idItem."&elemento=Documento' target='popup' onclick=\"window.open(this.href,this.target,'width=510,height=400,scrollbars=yes')\">
						  <img src='../Imagenes/ICN_Firmar.png' width='90' height='29'></a>";
				echo "</td>";
				
			}else{
				echo "<td align='right'> </td>";
			}
		}else{
			echo "<td align='right'> </td>";
		}
		
		if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
			echo "<td align='right'>";
				echo "<a href='FichaItemModificacionSGI.php?id=".$idItem."' >
					  <img src='../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
			echo "</td>";
			
		} else{
			echo "<td align='right'> </td>";
		}
		echo "</tr>";
		
		
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
<?php

} else{
	
	header ("Location: ../error.php");
	
}



?>
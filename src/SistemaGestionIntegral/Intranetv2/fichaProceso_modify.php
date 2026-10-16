<?php
$nombrephp = 'fichaProceso.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);

$idProceso = $_GET['proceso'];

if(isset($_POST['enviar'])){
	$signatura = $_POST['signatura'];
	$codigo = $_POST['codigo'];
	//echo "UPDATE SGI_Procesos SET xt_signatura = '$signatura' WHERE kp_codigo = '$codigo'";
	$INTRANETV2->Execute("UPDATE SGI_Procesos SET xt_signatura = '$signatura' WHERE xt_codigoCorto = '$codigo'");
	
	/*
	$inventarioLiberado = $INTRANETV2->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigo' ");
	
	
	if($inventarioLiberado == ''){
			header ("Location: FichaItem.php?id=$idProceso");
	}else{
			header("Location: ControlCambios.php?itemID=$idProceso");
	}*/
	header("Location: fichaProceso.php?proceso=$codigo");
}

?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">

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
			     var codProceso = "<?php echo $idProceso;?>";
				 
  					window.location = "liberaItem.php?codigo="+codProceso+"&tipo="+tipo+"&usuario="+usuario+"";				
				}
				
            </script>
            
            <script type="text/javascript">
				function activaSelectManual(){
					ocultaManual     = document.getElementById('modificaManual');
					muestraManual     = document.getElementById('muestraManual');
					
					muestraManual.style.display='block';
					ocultaManual.style.display='none';
					
					
				}
				
				function activaSelectGrupo(){
					ocultaGrupo     = document.getElementById('modificaGrupo');
					muestraGrupo     = document.getElementById('muestraGrupo');
					
					muestraGrupo.style.display='block';
					ocultaGrupo.style.display='none';
					
				}
				
				function activaSelectCiudad(){
					ocultaCiudad     = document.getElementById('modificaCiudad');
					muestraCiudad     = document.getElementById('muestraCiudad');
					
					muestraCiudad.style.display='block';
					ocultaCiudad.style.display='none';
					
				}
				
				function actualizarManual(proceso,codigo) {
					
					var manual = document.getElementsByName("manual")[0].value;
					
					var xhttp = new XMLHttpRequest();
					
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizaFichaProceso(proceso);
							}else{
								alert("hubo un error al actualizar Manual");
							}
						}
					};

					xhttp.open("POST", "modificaFichaProceso.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizaManual&proceso="+ proceso +"&manual="+ manual +"&codigo=" + codigo);
				}
				
				function actualizarGrupo(proceso, codigo) {
					
					var grupo = document.getElementsByName("grupo")[0].value;
					
					var xhttp = new XMLHttpRequest();
					
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizaFichaProceso(proceso);
							}else{
								alert("hubo un error al actualizar Manual");
							}
						}
					};

					xhttp.open("POST", "modificaFichaProceso.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizaGrupo&proceso="+ proceso +"&grupo="+ grupo +"&codigo=" + codigo);
				}
				
				function actualizarCiudad(proceso, codigo) {
					
					var ciudad = document.getElementsByName("ciudad")[0].value;
					
					var xhttp = new XMLHttpRequest();
					
					xhttp.onreadystatechange = function() {
						if (xhttp.readyState == 4 && xhttp.status == 200) {
							if(xhttp.responseText == true){
								actualizaFichaProceso(proceso);
							}else{
								alert("hubo un error al actualizar Manual");
							}
						}
					};

					xhttp.open("POST", "modificaFichaProceso.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("evento=actualizaCiudad&proceso="+ proceso +"&ciudad="+ ciudad +"&codigo=" + codigo);
				}
				
				function actualizaFichaProceso(proceso) {	
					window.open( "controlCambiosv3_modify.php?codDoc=" + proceso, "cCambios", "width=380,height=500, top=85,left=50");
					//window.open('', 'controlCambiosv3.php?codDoc=' + proceso, "width=500,height=500");	
					//window.location = 'fichaProceso_modify.php?proceso=' + proceso;
				}
			</script>

 			<?php
			
			
				//echo "<title>".$codigo." ".$nombre."</title>";
			
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
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


$s = $INTRANETV2->Execute("SELECT
	xt_codigoCorto,
	xt_Nombre,
	xd_FechaCreacion,
	xt_codigoProceso,
	SUBSTRING_INDEX(SUBSTRING_INDEX(xt_codigoProceso,'-',-2),'-',1)
FROM
	SGI_Procesos
WHERE
	xt_codigoCorto = '$idProceso' ");
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



$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a> <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
				   <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/manualesv3.php' id='breadcrumbs'> Manuales </a>";


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

			
/*$s = $INTRANETV2->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);

$mostrar = 0;

if($ciudad == ""){
	
	$mostrar = 1;
	
} else if(($ciudad != "") && (in_array($ciudad, $ciudadesDisponibles))){
	
	$mostrar = 1;
	
}*/

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
	echo "</table>";
	
	
				echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../../navegacion_banana.php");
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
		
	///NUMERO MAPA = 0, NUMERO ELEMENTO = 1, DESCRIPCION
		$descripcion = $INTRANETV2->getOne("SELECT xt_Descripcion FROM SGI_Procesos WHERE xt_codigoCorto = '$procesoCodigo'");
		//obtengo manual, grupo y ciudad
		$manual = $INTRANETV2->getOne("SELECT CONCAT(T2.xt_codigoManual,' ',T1.xt_nombre) FROM SGI_Catalogo_Manuales T1, SGI_Procesos T2 WHERE  T2.xt_codigoCorto = '$idProceso' AND T1.xt_codigoManual = T2.xt_codigoManual");
			
		$grupo = $INTRANETV2->getOne("SELECT CONCAT(T2.xt_grupo,' ',T1.xt_nombre) FROM SGI_Grupos T1, SGI_Procesos T2 WHERE  T2.xt_codigoCorto = '$idProceso' AND T1.xt_codigo = T2.xt_grupo");
			
		$ciudad = $INTRANETV2->getOne("SELECT CONCAT(T2.xt_ciudad,' ',T1.xt_nombre) FROM SGI_Catalogo_Sucursales T1, SGI_Procesos T2 WHERE  T2.xt_codigoCorto = '$idProceso' AND T1.xt_sucursal = T2.xt_ciudad");
			
			
			echo "<table border='0' align='center'>";
				echo"<tr height='40px'> </tr>";
				///Titulo del proceso
				echo "<tr id='titulo18'>";
					echo "<td align='left' colspan='2'><b>".$nombre."</b></td>";
				echo "</tr>";
			
			
				echo"<tr height='30px'> </tr>";
				///Manual
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Manual</b></td>";
					echo "<td align='right' width='15px'> </td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			
				echo "<tr id='modificaManual'>";
					echo "<td style='padding-left:60px;'>$manual</td>";
			
			 		echo "<td style='width:400px'  colspan='2'><div id='btnModifManual' align='right'><a style='cursor:pointer' id='modifP'  onClick='activaSelectManual()'><font color='#007cbd'>&nbsp; Modificar</font></a></div></td>";
			
				echo "</tr>";
			
				echo '<tr id="muestraManual" style="display: none;" align="right">';
                    echo "<td style='padding:0px 0px 0px 25px'>";
						echo "<select name='manual' id='manual'>";
                			echo "<option value=''>Selecciona........</option>";
                			$ii = $INTRANETV2->Execute("SELECT xt_codigoManual, CONCAT(xt_codigoManual,' ',xt_nombre) FROM SGI_Catalogo_Manuales WHERE xt_codigoManual != '$manual'");
                			while($i = $ii->fetchRow()){
								$nombreManual = $i[1];
								$codigoManual = $i[0];
                				
								echo "<option value='".$codigoManual."'>$nombreManual</option>";   
                			}
                		echo "</select>";
                    echo "</td>";
		 			echo "<td align='center'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="actualizarManual(\''.$idProceso.'\',\''.$codigo.'\')"><font color="#007CBD">Guardar</font></a>';
                    echo "</td>";
                echo "</tr>";
    
			
				echo"<tr height='30px'> </tr>";
			
				
			
				///Grupo
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Grupo</b></td>";
					echo "<td align='right' width='15px'> </td>";
				echo "</tr>";
				
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			
				echo "<tr id='modificaGrupo'>";
					echo "<td style='padding-left:60px;'>$grupo</td>";
			
					
			 		echo "<td style='width:400px'  colspan='2'><div id='btnModifGrupo' align='right'><a style='cursor:pointer' id='modifP'  onClick='activaSelectGrupo()'><font color='#007cbd'>&nbsp; Modificar</font></a></div></td>";
			
				echo "</tr>";
			
				echo '<tr id="muestraGrupo" style="display: none;" align="right">';
                    echo "<td style='padding:0px 0px 0px 25px'>";
						echo "<select name='grupo' id='grupo'>";
                			echo "<option value=''>Selecciona........</option>";
                			$ii = $INTRANETV2->Execute("SELECT xt_codigo, CONCAT(xt_codigo,' ',xt_nombre) FROM SGI_Grupos WHERE xt_codigo != '$grupo'");
                			while($i = $ii->fetchRow()){
								$nombreGrupo = $i[1];
								$codigoGrupo = $i[0];
                				
								echo "<option value='".$codigoGrupo."'>$nombreGrupo</option>";   
                			}
                		echo "</select>";
                    echo "</td>";
		 			echo "<td align='center'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="actualizarGrupo(\''.$idProceso.'\',\''.$codigo.'\')"><font color="#007CBD">Guardar</font></a>';
                    echo "</td>";
                echo "</tr>";
			
				echo"<tr height='30px'> </tr>";
			
				//Ciudad
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Ciudad</b></td>";
					echo "<td align='right' width='15px'> </td>";
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
			
				echo "<tr id='modificaCiudad'>";
					echo "<td style='padding-left:60px;'>$ciudad</td>";
					
					
			 		echo "<td style='width:400px'  colspan='2'><div id='btnModifCiudad' align='right'><a style='cursor:pointer' id='modifP'  onClick='activaSelectCiudad()'><font color='#007cbd'>&nbsp; Modificar</font></a></div></td>";
			
				echo "</tr>";
			
				echo '<tr id="muestraCiudad" style="display: none;" align="right">';
                    echo "<td style='padding:0px 0px 0px 25px'>";
						echo "<select name='ciudad' id='ciudad'>";
                			echo "<option value=''>Selecciona........</option>";
                			$ii = $INTRANETV2->Execute("SELECT xt_sucursal, CONCAT(xt_sucursal,'  ',xt_nombre) FROM SGI_Catalogo_Sucursales WHERE xt_sucursal != '$ciudad'");
                			while($i = $ii->fetchRow()){
								$nombreCiudad = $i[1];
								$codigoCiudad = $i[0];
                				
								echo "<option value='".$codigoCiudad."'>$nombreCiudad</option>";   
                			}
                		echo "</select>";
                    echo "</td>";
		 			echo "<td align='center'>";
		 				echo'<a  style="float:right;cursor:pointer;" onClick="actualizarCiudad(\''.$idProceso.'\',\''.$codigo.'\')"><font color="#007CBD">Guardar</font></a>';
                    echo "</td>";
                echo "</tr>";
			
				echo"<tr height='30px'> </tr>";
			
			
				echo"<tr height='30px'> </tr>";
				///Descripcion
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='685px'><b>Descripción</b></td>";
					echo "<td align='right' width='15px'>";
						if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama') ||($usuarioId == 'Ricardo_Garcia')){
							echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=0' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
								echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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

			$descripcion_ = $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Procesos WHERE xt_codigoCorto = '$procesoCodigo'");
			
			echo "<table border='0' align='center'>";
			//Contenido descripción
			echo "<tr>";
				echo "<td width='30px'> </td>";
				echo "<td width='670' id='fileItem' align='justify'>".$descripcion_."</td>";
			echo "</tr>";
			echo "<tr height='20px'> </tr>";
		echo "</table>";

		unset($s); unset($r);
		
			
	///NUMERO MAPA = 0, NUMERO ELEMENTO = 3, RESPONSABLE
		$nombreResponsable = $INTRANETV2->getOne("SELECT xt_responsable FROM SGI_Procesos WHERE xt_codigoCorto = '$procesoCodigo'");
		
		if($nombreResponsable != ""){
			
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
					echo "<td width='670' id='fileItem' align='justify'>".$nombreResponsable."</td>";
				echo "</tr>";
				echo "<tr height='20px'> </tr>";
			echo "</table>";
			
			
		} else{
			
			echo "<table border='0' align='center'>";
				///Responsable
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='780px'><b>Responsable</b></td>";
					echo "<td align='right' width='15px'>";
						if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
							echo "<a href='AgregarElementoProcesoPopUp.php?itemID=".$itemID."&nmapa=r' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
								echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		$diagrama = $INTRANETV2->getOne("SELECT xt_archivo FROM SGI_Procesos WHERE xt_codigoCorto = '$procesoCodigo'");
		
		if($diagrama != ""){
			
			echo "<table border='0' align='center'>";
			
				echo"<tr height='30px'> </tr>";
				///Descripción
				echo "<tr id='titulo2'>";
					echo "<td align='left' width='780px'><b>Diagrama de Flujo</b></td>";
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
							
							echo '<object  data="data:Application/pdf,'.rawurlencode(file_get_contents($diagrama)).'" type="application/pdf" width="950px" height="700px">';
								echo "<p>";
									echo "Si este mensaje aparece su navegador no soporta el plugin para el PDF.";
									echo "No obstante puede descargar el archivo en este <a href='data:Application/pdf,".$diagrama."' download='".$diagrama."'>enlace</a>";
								echo "</p>";
							echo "</object>";
							echo "<br><br>";
						}
					echo "</td>";
				echo "</tr>";
				echo "<tr height='20px'> </tr>";
				
				
				
			echo "</table>";
			
		} else{
			echo "<table border='0' align='center'>";
			
				echo"<tr height='30px'> </tr>";
				///Descripción

				echo "<tr id='titulo2'>";
					echo "<td align='left' width='780px'><b>Diagrama de Flujo</b></td>";
					echo "<td align='right' width='15px'>";
						if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
							echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=2' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
								echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
						<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'></a> ";
					echo "</td>";
                  
				echo "</tr>";
				///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='10px'>";
						

			    //tabla de procesos, actividades
				
				//echo"SELECT xt_nombre from SGI_Procesos WHERE kp_codigo = '$codigo'<br><br>";
				$nomProceso = $INTRANETV2->getOne("SELECT xt_nombre from SGI_Procesos WHERE kp_codigo = '$codigo'");


				$index = 0;
				
				$s = $INTRANETV2->Execute("SELECT DISTINCT xt_nombreRol, xt_codigoRol FROM SGI_Roles WHERE xt_codigoProceso = '$procesoCodigo' ORDER BY xn_ordenRol");

				while($row = $s->fetchRow()){
					//$f[$index] = $row[0];
					$n[$index] = $row[1];
					$f[$index] = $row[0];
					$index++; 
				}
				$fila = count($f);
				
				
				$numColumnas = $INTRANETV2->getOne("SELECT
													count(DISTINCT SKA.xt_momento)
												FROM
													SGI_Actividades SKA
												WHERE
													SKA.xt_codigoProceso = '$procesoCodigo'");

				//obtengo los tiempos
				//hago consulta de tiempos
			
				$a = $INTRANETV2->Execute("SELECT DISTINCT
											SKA.xt_momento,
											RIGHT (SKA.xt_momento, 3),
											SKA.xt_momento
										FROM
											SGI_Actividades SKA
										WHERE
											SKA.xt_codigoProceso = '$procesoCodigo'
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
					
				
					$actividad = $INTRANETV2->Execute("SELECT DISTINCT
														SKA.xt_codigoActividad,
														SKA.xt_nombre,
														SKA.xt_codigoRol														
													FROM
														SGI_Actividades SKA
													WHERE
														SKA.xt_codigoProceso = '$procesoCodigo'
													AND SKA.xt_codigoRol = '$rolCodigo'
													AND SKA.xt_momento = '$tiempo[$e]'
													ORDER BY
														SKA.xt_codigoActividad");

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
								echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaActividadFuncionalidad_modify.php?proceso=$procesoCodigo&actividad=$arrayActividad[$l]&rol=$rolActividad[$l]' style='text-decoration:none;' id='textoActividad'>- $arrayDescripcionActividad[$l]</a>";
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
				
			
	///NUMERO MAPA = 1, PROCESOS ANTECESORES
		
		$procesosAntecesores 	= NULL;
		$tituloPAntecesores		= NULL;
		$descripcionPAnt		= NULL;
		$indice 				= 1;
		
		//echo"SELECT xt_docCodigo, xt_titulo, xt_descripcion, xt_tipo FROM SGI_Procesos_Elementos WHERE kf_itemID = $itemID AND xn_numeroMapa = 1 ORDER BY xn_numeroElemento<br><br>";
		$s = $INTRANETV2->Execute("SELECT
									SKPS.xt_codigoProcesoAntecesor,
									(SELECT SKP.xt_codigoProceso FROM SGI_Procesos SKP WHERE SKP.xt_codigoCorto = SKPS.xt_codigoProcesoAntecesor) as CodigoCompleto,
									(SELECT SKP.xt_Nombre FROM SGI_Procesos SKP WHERE SKP.xt_codigoCorto = SKPS.xt_codigoProcesoAntecesor) as Nombre
								FROM
									SGI_Procesos_Antecesores SKPS
								WHERE
									SKPS.xt_codigoProceso = '$procesoCodigo'");
		
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
	

			$f = $INTRANETV2->Execute("SELECT DISTINCT
										SKF.xt_codigoProceso,
										SKF.xt_codigoActividad,
										SKF.xt_codigoRol,
										SKF.xt_codigoFuncionalidad,
										SKF.xt_nombre
									FROM
										SGI_Funcionalidades_copy1 SKF
									WHERE
										SKF.xt_codigoProceso = '$procesoCodigo'
									ORDER BY
										RIGHT (SKF.xt_codigoFuncionalidad, 3)");
		   while($v = $f->fetchRow()){
			   $codActividad     = $v[1];
			   $codRol           = $v[2];
			   $codFuncionalidad = $v[3];
			   $nombreFuncionalidad = $v[4];
			 
			   $actividad = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Actividades WHERE xt_codigoActividad = '$codActividad'");
			   $rol1      = $INTRANETV2->getOne("SELECT xt_nombre FROM SGI_Roles WHERE xt_codigoRol = '$codRol'");
			   
				echo "<tr>";
					echo "<td width='150'>";
						 echo "<i>".$v[3]."</i>";
					echo "</td>";
					echo "<td>";
					echo "</td>";
					echo "<td width='500'>";
						echo "<a href='fichaFuncionalidadCasoUso_modify.php?proceso=$procesoCodigo&rol=$codRol&actividad=$codActividad&funcionalidad=$codFuncionalidad'>".$nombreFuncionalidad."</a>";
					echo "</td>";
				echo "<td width='150'>";
						echo "<i>".$codActividad."</i>";
					echo "</td>";
					echo "<td>";
					echo "</td>";
					echo "<td width='300'>";
						echo "<a href='fichaActividadFuncionalidad_modify.php?proceso=$procesoCodigo&rol=$codRol&actividad=$codActividad'>".$actividad."</a>";;
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Lizbeth_Guadarrama') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=5' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=450,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		
		$s = $INTRANETV2->Execute("SELECT
									SKPS.xt_codigoProcesoAntecesor,
									(SELECT SKP.xt_codigoProceso FROM SGI_Procesos SKP WHERE SKP.xt_codigoCorto = SKPS.xt_codigoProcesoAntecesor) as CodigoCompleto,
									(SELECT SKP.xt_Nombre FROM SGI_Procesos SKP WHERE SKP.xt_codigoCorto = SKPS.xt_codigoProcesoAntecesor) as Nombre
								FROM
									SGI_Procesos_Apoyo SKPS
								WHERE
									SKPS.xt_codigoProceso = '$procesoCodigo' ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=6' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=450,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		
		$s = $INTRANETV2->Execute("SELECT
									SKPS.xt_codigoProcesoAntecesor,
									(SELECT SKP.xt_codigoProceso FROM SGI_Procesos SKP WHERE SKP.xt_codigoCorto = SKPS.xt_codigoProcesoAntecesor) as CodigoCompleto,
									(SELECT SKP.xt_Nombre FROM SGI_Procesos SKP WHERE SKP.xt_codigoCorto = SKPS.xt_codigoProcesoAntecesor) as Nombre
								FROM
									SGI_Procesos_Sucesores SKPS
								WHERE
									SKPS.xt_codigoProceso = '$procesoCodigo'");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=7' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=450,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		
		$s = $INTRANETV2->Execute("SELECT xt_entradas FROM SGI_Entradas WHERE xt_codigoProceso = '$procesoCodigo' ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=8' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		
		$s = $INTRANETV2->Execute("SELECT xt_Salidas FROM SGI_Salidas WHERE xt_codigoProceso = '$procesoCodigo' ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=9' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		
		$s = $INTRANETV2->Execute("SELECT xt_insumos FROM SGI_Insumos WHERE xt_codigoProceso = '$procesoCodigo' ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=10' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=600,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		
		$s = $INTRANETV2->Execute("SELECT xt_compliance FROM SGI_Compliance WHERE xt_codigoProceso = '$procesoCodigo'");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=11' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=600,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
			
		
		
		$s = $INTRANETV2->Execute("SELECT
									DC.xt_codigoDocumento,
									MD.xt_nombre,
									MD.xt_codigoCompleto
								FROM
									SGI_Documentos_Controlados DC,
									SGI_Manuales_Documentos MD
								WHERE
									DC.xt_codigoProceso = '$procesoCodigo'
								AND 
									DC.xt_codigoDocumento = MD.xt_codigoDocumento");
			
		
		while($r = $s->fetchRow()){
			
			if($r[0] != ""){
				
				$codDocumentoRel[$indice]			= $r[0];
				$tituloDocumentoRel[$indice]	    = $r[1];
				$codigoCompletoDoc[$indice]	        = $r[2];
				$link[$indice] = "fichaDocumentov3.php?id=".$r[0];
				
			} 
			
			$indice++;
			
		} unset($r);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>8.- Documentos Controlados</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=12' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
			
			if(count($tituloDocumentoRel) > 0){
				for($i = 1; $i <= count($tituloDocumentoRel); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						
							echo "<td align='left' valign='top'>"; 
								echo "<a href='$link[$i]' style='text-decoration:none;' id='iconosTexto'>$codigoCompletoDoc[$i]</a>";
							echo "</td>";
							
							echo "<td align='left'> </td>";
							
							echo "<td align='left' colspan='2'>$tituloDocumentoRel[$i]</td>";
						
					echo "</tr>";
					
					echo"<tr height='5px'> </tr>";
					
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
		
		$s = $INTRANETV2->Execute("SELECT xt_stakeholder FROM SGI_Stakeholders WHERE xt_codigoProceso = '$procesoCodigo' ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=13' target='popup' onclick=\"window.open(this.href,this.target,'width=620,height=500,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
		$riesgosPendientes = NULL;
	
		$indice 			= 1;
		$indiceRP           = 1;
		
		$s = $INTRANETV2->Execute("SELECT T1.xt_tituloRiesgo, T2.xt_riesgo FROM SGI_Procesos_Riesgos T2, SGI_Riesgos T1 WHERE T2.xt_codigoProceso = '$procesoCodigo' AND T1.xt_codigoriesgo = T2.xt_riesgo");
			
		$w = $INTRANETV2->Execute("SELECT xt_tituloRiesgo FROM SGI_Procesos_Riesgos_Pendientes WHERE xt_codigoproceso = '$procesoCodigo'");
		
		while($r = $s->fetchRow()){
			
			$descripcionRiesgos[$indice] 	= $r[0];
			$codigoRiesgo[$indice]          = $r[1];
					
			$indice++;
			
		} unset($r);
			
		//obtengo riesgos pendientes
			
		while($p = $w->fetchRow()){
			
			
			$tituloRP[$indiceRP] = $p[0];			
			$indiceRP++;
			
		} unset($p);
		
		echo "<table border='0' align='center'>";
			///Competencia
			echo "<tr id='titulo2'>";
				echo "<td align='left' colspan='4'><b>10.- Riesgos</b></td>";
				echo "<td align='right'>";
					//Agregar competencia
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregarRiesgosPopUpv2.php?proceso=".$procesoCodigo."&seccion=14' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=530,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
							//echo "<td align='left' valign='top' colspan='4'>$i. $descripcionRiesgos[$i]</td>";
							echo "<td align='left' valign='top' colspan='4'><a href='fichaRiesgov2.php?id=".$codigoRiesgo[$i]."'>".$i.".- ".$codigoRiesgo[$i]." ".$descripcionRiesgos[$i]."</a></td>";
			
				
					echo "</tr>";
					
					echo"<tr height='20px'> </tr>";
	
			}
			
			echo "<tr><td align='left'> </td><td align='left' valign='top' colspan='4' id='iconosTexto2'>**RIESGOS PENDIENTES**</td></tr>";
			
			echo"<tr height='10px'> </tr>";
			
			for($p = 1; $p <= count($tituloRP); $p++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
							//echo "<td align='left' valign='top' colspan='4'>$i. $descripcionRiesgos[$i]</td>";
							echo "<td align='left' valign='top' colspan='4'><a href='altaRiesgoPopUpv2.php?tituloRP=".$tituloRP[$p]."&codProceso=".$idProceso."'>".$p.".- ".$tituloRP[$p]."</a></td>";
			
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
		
		$s = $INTRANETV2->Execute("SELECT xt_indicador, xt_formula, xt_valor, xt_periodicidad FROM SGI_Indicadores WHERE xt_codigoProceso = '$procesoCodigo' ORDER BY xt_Indicador ");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=15' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='tipoDoctosPopUp.php?usuario=$usuarioId&proceso=$procesoCodigo' target='popup' onclick=\"window.open(this.href,this.target,'width=350,height=580,scrollbars=yes')\">
						<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
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
            $s = $INTRANETV2->Execute("SELECT DISTINCT xt_tipo FROM SGI_Documentacion WHERE xt_codigoProceso = '$procesoCodigo'");
            
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
                            <a href='javascript:void(0);' onclick='mostrarIframe("<?php echo $trPosF; ?>");'><img  src="../../../INTRANET_GEA/Imagenes/ICN_NuevoDoc.png" height='15' width='15'/></a>     
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
                    $doc = $INTRANETV2->Execute("SELECT xt_archivo, xt_usuario, xd_fecha, xt_ruta FROM SGI_Documentacion WHERE xt_tipo = '$row[0]' AND xt_codigoProceso = '$procesoCodigo'");
                
                    $numDoc = 0;
                    while ($listA = $doc -> fetchRow()){
                        if(!empty($listA[0])){
							//echo"$listA[0]--$listA[3]---";
                            echo "<table border='0' width='90%'>";
                                echo "<tr>";
                                    echo "<td width='30px'></td>";
                                    echo "<td style='padding:0px 0px 0px 15px;'><font size=2>$listA[0]</font></td>";
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/eliminaDoctosFichaProceso.php?codigo=".$procesoCodigo."&nombreA=".$listA[0]."&ruta=".$listA[3]."&nombrephp=fichaProceso.php'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
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
                                echo "<iframe src='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/uploadArchivosActividadFuncionalidadV2.php?codigo=".$procesoCodigo."&usuario=".$usuarioId."&nombrephp=fichaProceso.php&tipoArchivo=".$row[0]."' frameborder='0' width='800px' height='150px'></iframe><br>";
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
			$signaturaVal = $INTRANETV2->getOne("SELECT xt_signatura FROM SGI_Procesos WHERE xt_codigoCorto = '$procesoCodigo'");
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
		
		$s = $INTRANETV2->Execute("SELECT xt_tituloNota, xt_descripcion FROM SGI_Notas WHERE xt_codigoProceso = '$procesoCodigo'");
		
		while($r = $s->fetchRow()){
			$notas[$indice]				= $r[0];
			$tituloNota[$indice]		= $r[0];
			
			$descripcionNota[$indice] 	= $r[1];
			
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')|| ($usuarioId == 'Alberto Martinez') ||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=16' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
			
			if($tituloNota  != NULL){
				for($i = 1; $i <= count($tituloNota); $i++){
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
		
		$s = $INTRANETV2->Execute("SELECT xt_area_oportunidad FROM SGI_Areas_Oportunidad WHERE xt_codigoProceso = '$procesoCodigo'");
		
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
					if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'sdelap')||($usuarioId == 'Edgardo_Hernandez')||($usuarioId == 'Lizbeth_Guadarrama')){
						echo "<a href='agregaElementoProceso.php?proceso=".$procesoCodigo."&seccion=17' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=800,scrollbars=yes')\">"; 
							echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>";
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
			
				for($i = 1; $i <= count($tituloOportunidad); $i++){
					echo "<tr id='iconosTexto'>";
						echo "<td align='left'> </td>";
						echo "<td align='left' colspan='4'>$tituloOportunidad[$i]</td>";
					echo "</tr>";
					
					echo"<tr height='10px'> </tr>";
				}
				
			echo"<tr height='20px'> </tr>";
		echo "</table>";
		
			
			
		
		$s = $INTRANETV2->Execute("SELECT
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
										IntranetGEA.SGI_Empleados U
									WHERE
										U.kf_usuario = SL.xt_usuario
								),
								SL.xd_fecha
							FROM
								INTRANET2.SGI_Libera_Inventarios SL
							WHERE
								SL.xt_codigo = '$procesoCodigo'
							AND SL.xt_tipo = 'Proceso'");
		
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
			

//CONTROL DE CAMBIOS
//obtengo registro de cambios para el documento
$k = $INTRANETV2->Execute("SELECT xn_version, xt_descripcion, xt_inicialesUsuario FROM INTRANET2.SGI_Control_Cambios_Procesos WHERE xt_codigoProceso = '$procesoCodigo' ORDER BY xn_version DESC");

$versionCC = array();
$cambioDesc = array();
$fechaVersion = array();
$iniciales = array();

$indexCC = 0;
			
while($n = $k->fetchRow()){
	
 $versionCC[$indexCC] = $n[0];
 $cambioDesc[$indexCC] = $n[1];
 
 $iniciales[$indexCC] = $n[2];
	
 $indexCC++;
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

		for($a = 0; $a < count($versionCC); $a++){
			
			$fechaVersion = $INTRANETV2->getone("SELECT xd_fechaCambio FROM INTRANET2.SGI_Control_Cambios_Procesos WHERE xt_codigoProceso = '$procesoCodigo' AND xn_version = $versionCC[$a]");
			$fechaVersion = date('Y-m-d', strtotime($fechaVersion));
			echo "<tr>";
				echo "<td width='100px' align='center' id='fileItem'>$versionCC[$a]</td>";
				echo "<td align='left' width='420px' id='fileItem'>$cambioDesc[$a]</td>";
				echo "<td align='center' width='80px' id='fileItem'>$fechaVersion</td>";
				echo "<td align='center' width='100' id='fileItem'>$iniciales[$a]</td>";
			echo "</tr>";
			echo "<tr height='10px'> </tr>";

		}
			//final de apartado control de cambios
			}else{
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

		echo "<tr>";
			echo "<td width='30px'></td><td colspan='5' align='left' id='iconosTexto2'>Sin cambios registrados.</td>";
		echo "</tr>";

		echo "<tr height='10px'> </tr>";
			}
		
			echo "</table>";
		}
		
		}
	
	echo "<table border='0' align='center'>";
		echo"<tr height='30px'> </tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineTop' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='10px'><td width='550px'> </td><td width='150px'> </td></tr>";
		
		echo "<tr>";
		
		
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

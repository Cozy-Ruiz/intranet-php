<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'tableroRegistros.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <title>Tablero Registros</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            
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
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					} else if (valor == 0){
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
					}
				}
			</script> 
        </head>
        <body>
<?php
/*
$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";
$ciudades[7] = "Todas";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN"; 
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
$cdValor[7] = "ALL";
*/

$f = $INTRANET->Execute("SELECT DISTINCT xt_categoria FROM SGI_Registros ORDER BY xt_categoria");
$contador = 0;
while($p = $f->fetchRow()){
	
	$formatoCategoria[$contador] = $p[0];
	$contador++;
	
} unset($p); unset($f); unset($contador);

/*
$formatoCategoria[1] = "GE-CDR-F-002";
$formatoCategoria[2] = "GE-AI-F-001";
$formatoCategoria[3] = "GE-CC-F-002";
$formatoCategoria[4] = "GE-DG-F-001";
$formatoCategoria[5] = "GE-ADM-F-011";
$formatoCategoria[6] = "GE-ADM-F-014";
$formatoCategoria[7] = "GE-RH-F-001";
$formatoCategoria[8] = "GE-RH-F-007";
$formatoCategoria[9] = "GE-TI-F-001";
$formatoCategoria[10] = "GE-TI-F-002";
$formatoCategoria[11] = "GE-TI-F-004";
$formatoCategoria[12] = "GE-CC-F-004";
$formatoCategoria[13] = "GE-ADM-F-022";
$formatoCategoria[14] = "GE-DG-F-002";
$formatoCategoria[15] =  "GE-CC-F-005";
*/
$index = 0;
$t = $INTRANET->Execute("SELECT xt_oficina, xt_descripcion FROM IntranetGEA_CATALOGO_OFICINA");
while($p = $t->fetchRow()){
	$ciudades[$index] = $p[1];
	$cdValor[$index]  = $p[0];
	$index++;	
}unset($p);unset($t);unset($index);


$indice 				= 1;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);



//echo "SELECT kp_eventoID, xd_fecha, xt_tituloEvento, xt_codigoEvento FROM SGI_Eventos WHERE xt_ciudad = '$ciudadesDisponibles' ORDER BY xd_fecha DESC ";
$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadFiltro = "";

if($_POST['ciudad'] !=""){
	
	$ciudadFiltro = $_POST['ciudad'];
	
}else if($_GET['ciudad'] !=""){
	
	$ciudadFiltro = $_GET['ciudad'];
	
}

//for($o = 1; $o <= 6; $o++){
for($o = 0; $o <count($cdValor); $o++){
	if($cdValor[$o] == $ciudadFiltro){
		
		$imprimeCiudad = $ciudades[$o];
		
	}
	
}

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='Registros.php' id='breadcrumbs'> Registros</a> ";

echo "<div id='wrapperFicha' align='center'>";
	echo "<form method='post' action='tableroRegistros.php'>";
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Registros";
			echo "</td>";
		echo "</tr>";
		
		if($categoriaUsr == "Administrador"){
			
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo $imprimeCiudad;
				echo "</td>";
			echo "</tr>";
			
		}
		
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
		
		echo "<tr height='40px'><td></td></tr>";
		
		if($categoriaUsr == "Administrador"){
			
			echo "<tr>";
				echo "<td align='center'>";
					echo "<a href='altaRegistro.php'>";
						echo "<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'>";
					echo "</a>";
				echo "</td>";
			echo "</tr>";
			
		}
		
	echo "</table>";

				
		//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../navegacion_banana.php");
	echo "</table>";
			
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 


//CATEGORIA DE INHOUSE
if($categoriaUsr == "Inhouse"){
	
	for($allTypes=0; $allTypes<count($formatoCategoria); $allTypes++){
	//for($allTypes = 1; $allTypes <= 15; $allTypes++){
		
		$indice 		= 1;
		$registroID 	= NULL;
		$fecha 			= NULL;
		$titulo 		= NULL;
		//$claveRegistro 	= NULL;
		
		//echo"SELECT kp_registroID, xd_fecha, xt_tituloRegistro FROM SGI_Registros WHERE xt_categoria = '$formatoCategoria[$allTypes]' ORDER BY xd_fecha DESC";
		$s = $INTRANET->Execute("SELECT kp_registroID, xd_fecha, xt_tituloRegistro FROM SGI_Registros WHERE xt_categoria = '$formatoCategoria[$allTypes]' ORDER BY xd_fecha DESC ");
		
		while($r = $s->fetchRow()){
				
				$registroID[$indice] 	= $r[0];
				$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
				$titulo[$indice] 		= $r[2];
				//$claveRegistro[$indice] = $r[3]; 
				
				$indice++;
				
			} unset($r); unset($s); unset($indice);
		
		if(count($registroID) >= 1){
			echo "<table border='0' align='center' width='700px'>";
				
				//echo"$formatoCategoria[$allTypes]";
				echo "<tr id='titulo2'>";
					$nombreFormato = $INTRANET-> getOne("SELECT xt_nombre FROM SGI_Item WHERE xt_codigo = '$formatoCategoria[$allTypes]'");
					echo "<td align='left' width='100px' colspan='5'><i>".$formatoCategoria[$allTypes] ."&nbsp;". $nombreFormato."</i></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='5' id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center' width='10px'></td>";
					echo "<td align='center' width='20px'></td>";
					echo "<td align='left' width='560px'>Título</td>";
					echo "<td align='center' width='100px'>Fecha</td>";
					echo "<td align='right' width='10px'></td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='5'></td></tr>";
			
			echo "</table>";
		
			echo "<table align='center' border='0' width='700px'>";
			
			for($a = 1; $a <= count($registroID); $a++){
				
				echo "<tr height='25' id='iconosTexto'>";
					echo "<td width='20px' align='center'>";
						//echo "<a href='fichaRegistro.php?id=".$registroID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$claveRegistro[$a]."</a>";
					echo "</td>";
					
					echo "<td width='10px' align='center'></td>";
					
					echo "<td width='570px' align='left'><a href='fichaRegistro.php?id=".$registroID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$titulo[$a]."</a></td>";
			
					echo "<td width='100px' align='center'>".$fecha[$a]."</td>";
					
					echo "<td width='10px' align='right'></td>";
				echo "</tr>";
				
			}
			
			echo "</table>";
			
		} 
		
	}//fin for formato categoria

}//fin caso inhouse

else if($categoriaUsr == "Administrador"){
	
	
//FILTRO POR CIUDADES
	//echo "<table border='0' align='center' width='700' id='mostrar' style='display:none;'>";
echo "<table border='0' align='center' width='700'>";
		//CONDICION PARA VER TODO
		
		echo "<tr>";
			echo "<td id='breadcrumbs' valign='top' width='50'>";
			///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
				echo "<select name='ciudad' size='1'>";
				if($ciudadFiltro == ""){
					
					echo "<option value='' selected='selected'>Seleccionar..</option>";
					
					//for($a = 1; $a <= 7; $a++){
					for($a = 0; $a < count($cdValor); $a++){
						echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
					}
						echo "<option value='ALL'>Todos</option>";
					
				}else{
					
					//for($a = 1; $a <= 7; $a++){
					for($a = 0; $a < count($cdValor); $a++){
						
						if($cdValor[$a] == $ciudadFiltro){
							
							echo "<option value='".$cdValor[$a]."' selected='selected'>".$ciudades[$a]."</option>";
							
						} else {
							
							echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
						}
					}
							echo "<option value='ALL'>Todos</option>";
				
				}
				echo "</select>";
			echo "</td>";
		
			echo "<td align='left' width='650'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' height='20' width='70'></td>";
		echo "</tr>";
	
		echo "<tr height='30'><td colspan='2'></td></tr>";			
	echo "</table>";
	
//RESULTADO DE LA BUSQUEDA POR CIUDAD
	//if($ciudadFiltro == "" || $ciudadFiltro == 'ALL'){
		
		for($allTypes=0; $allTypes<count($formatoCategoria); $allTypes++){
		//for($allTypes = 1; $allTypes <= 15; $allTypes++){
		
			$indice 		= 1;
			$registroID 	= NULL;
			$fecha 			= NULL;
			$titulo 		= NULL;
			
			//echo"SELECT kp_registroID, xd_fecha, xt_tituloRegistro FROM SGI_Registros WHERE xt_categoria = '$formatoCategoria[$allTypes]' ORDER BY xd_fecha DESC<br>";
			if($ciudadFiltro == "" || $ciudadFiltro == 'ALL'){
				$s = $INTRANET->Execute("SELECT kp_registroID, xd_fecha, xt_tituloRegistro FROM SGI_Registros WHERE xt_categoria = '$formatoCategoria[$allTypes]' ORDER BY xd_fecha DESC ");
			}else if($ciudadFiltro != '' || $ciudadFiltro != 'ALL'){
				$s = $INTRANET->Execute("SELECT kp_registroID, xd_fecha, xt_tituloRegistro FROM SGI_Registros WHERE xt_ciudad = '$ciudadFiltro' AND xt_categoria = '$formatoCategoria[$allTypes]' ORDER BY xd_fecha DESC ");
			}
			while($r = $s->fetchRow()){
				 
				$registroID[$indice] 	= $r[0];
				$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
				$titulo[$indice] 		= $r[2];
				
				$indice++;
				
			} unset($r); unset($s); unset($indice);	
			
			
			if(count($registroID) >= 1){
				
				echo "<table border='0' align='center' width='700'>";	
					echo "<tr id='titulo2'>";
					if($ciudadFiltro == "" || $ciudadFiltro == 'ALL'){
						echo "<td align='center' width='100px'>Todos</td>";
					}else if($ciudadFiltro != '' || $ciudadFiltro != 'ALL'){
						echo "<td align='center' width='100px'>".$ciudades[$o]."</td>";
					}
						//echo "<td align='center' width='100px'>Todos</td>";
					echo "</tr>";
					
					echo "<tr height='10pz'>";
						echo "<td></td>";
					echo "</tr>";
				echo "</table>";
				
				echo "<table border='0' align='center' width='700px'>";	
					$nombreFormato = $INTRANET-> getOne("SELECT xt_nombre FROM SGI_Item WHERE xt_codigo = '$formatoCategoria[$allTypes]'");
					echo "<tr id='titulo2'>";
						echo "<td align='left' width='100px' colspan='5'><i>".$formatoCategoria[$allTypes]. "&nbsp;".$nombreFormato."</i></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='5' id='titleBlueLineTop'></td>";
					echo "</tr>";
					
					echo "<tr id='iconosTexto2'>";
						echo "<td align='center' width='10px'></td>";
						echo "<td align='center' width='20px'></td>";
						echo "<td align='left' width='560px'>Título</td>";
						echo "<td align='center' width='100px'>Fecha</td>";
						echo "<td align='right' width='10px'></td>";
					echo "</tr>";
					
					
					echo "<tr height='10px'><td colspan='5'></td></tr>";
				echo "</table>";
				
				echo "<table align='center' border='0' width='700'>";
				
				for($a = 1; $a <= count($registroID); $a++){
					
					echo "<tr height='25' id='iconosTexto'>";
						echo "<td width='20px' align='center'>";
							//echo "<a href='fichaRegistro.php?id=".$registroID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$claveRegistro[$a]."</a>";
						echo "</td>";
						
						echo "<td align='center' width='10px'></td>";
						
						echo "<td width='570px' align='left'><a href='fichaRegistro.php?id=".$registroID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$titulo[$a]."</a></td>";
				
						echo "<td width='100px' align='center'>".$fecha[$a]."</td>";
						
						echo "<td width='10px' align='right'></td>";
					echo "</tr>";
					
				}
				
				echo "</table>";
				
			}
			
			else{
				echo "<table border='0' align='center' width='700px'>";	
		
					echo "<tr id='iconosTexto2'>";
						echo "<td align='center' width='10px'></td>";
					echo "</tr>";
					
				echo "</table>";
			}
		
		}
		
		
		
	//}
	/*else {
		
		for($allTypes=0; $allTypes<count($formatoCategoria); $allTypes++){
		
		echo"SELECT kp_registroID, xd_fecha, xt_tituloRegistro FROM SGI_Registros WHERE xt_ciudad = '$ciudadFiltro' AND xt_categoria = '$formatoCategoria[$allTypes]' ORDER BY xd_fecha DESC ";
		$s = $INTRANET->Execute("SELECT kp_registroID, xd_fecha, xt_tituloRegistro FROM SGI_Registros WHERE xt_ciudad = '$ciudadFiltro' AND xt_categoria = '$formatoCategoria[$allTypes]' ORDER BY xd_fecha DESC ");
		
		while($r = $s->fetchRow()){
			 
			$registroID[$indice] 	= $r[0];
			$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
			$titulo[$indice] 		= $r[2];
			
			
			$indice++;
			
		} unset($r); unset($s); unset($indice);	
		
	if(count($registroID) >= 1){
		echo "<table border='0' align='center' width='700px'>";	
			echo "<tr id='titulo2'>";
				$nombreFormato = $INTRANET-> getOne("SELECT xt_nombre FROM SGI_Item WHERE xt_codigo = '$formatoCategoria[$allTypes]'");
				echo "<td align='left' width='100px' colspan='5'><i>".$formatoCategoria[$allTypes] ."&nbsp;". $nombreFormato."</i></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='5' id='titleBlueLineTop'></td>";
			echo "</tr>";
			
			echo "<tr id='iconosTexto2'>";
				echo "<td align='center' width='10px'></td>";
				echo "<td align='center' width='20px'></td>";
				echo "<td align='left' width='560px'>Título</td>";
				echo "<td align='center' width='100px'>Fecha</td>";
				echo "<td align='right' width='10px'></td>";
			echo "</tr>";
		
			
			echo "<tr height='10px'><td colspan='5'></td></tr>";
		echo "</table>";
	
			echo "<table align='center' border='0' width='700px'>";
			
			for($a = 1; $a <= count($registroID); $a++){
				
				echo "<tr height='25px' id='iconosTexto'>";
					echo "<td width='20px' align='center'>";
						//echo "<a href='fichaRegistro.php?id=".$registroID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$claveRegistro[$a]."</a>";
					echo "</td>";
					
					echo "<td align='center' width='10px'></td>";
					
					echo "<td width='570px' align='left'><a href='fichaRegistro.php?id=".$registroID[$a]."' id='iconosTexto' style='text-decoration:none;'>".$titulo[$a]."</a></td>";
			
					echo "<td width='100px' align='center'>".$fecha[$a]."</td>";
					
					echo "<td width='10px' align='right'></td>";
				echo "</tr>";
				
			}
			
			echo "</table>";
			
		} 
	
		
	}//fin for de formatos
	*/
	
}
			
			
	echo "<br><br>";
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr>";
			echo "<td width='700px' id='titleBlueLineBottom'></td>";
		echo "</tr>";echo "<tr>";
			echo "<td align='center' id='nota_al_pie' colspan='2'>";
			///Titulo
				echo "Created by: Grupo Escalante Agencias Aduanales.";
			echo "</td>";
		echo "</tr>";
	echo"</table>";
	echo "<br><br><br>";

	echo "</form>";
echo "</div>";

?>
		</body>
	</html>
<?php 

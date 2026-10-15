<?php
$nombrephp = 'tableroReuniones.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

 error_reporting(E_PARSE);
$contador = 0;
$t = $INTRANET->Execute("SELECT
	CASE O.xt_codigoCiudad
WHEN 'DF' THEN
	'CMX'
ELSE
	O.xt_codigoCiudad
END,
 (
	SELECT
		CASE CO.xt_descripcion
	WHEN 'Mexico DF' THEN
		'Ciudad de México'
	ELSE
		CO.xt_descripcion
	END
	FROM
		IntranetGEA_CATALOGO_OFICINA CO
	WHERE
		CO.xt_oficina = O.xt_codigoCiudad
)
FROM
	IntranetGEA_Usuarios_Oficina O
WHERE
	O.kf_usuarioId = '$usuarioId'
AND CASE O.xt_codigoCiudad
WHEN 'DF' THEN
	'CMX'
ELSE
	O.xt_codigoCiudad
END IN (
	SELECT
		E.xt_ciudad
	FROM
		INTRANET2.SGI_Reuniones E
)
");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);

$index = 0;
$b = $INTRANETV2->Execute("SELECT xt_reunion, xt_nombre FROM SGI_Catalogo_Reuniones ORDER BY xt_reunion");
while($n = $b->fetchRow()){
	$reunion[$index]       = $n[0];
	$nombreReunion[$index] = $n[1];
	$index++;
}unset($n);unset($b);unset($index);

$indice 				= 1;
$ciudadesDisponibles 	= NULL;

$s = $INTRANET->Execute("SELECT
CASE xt_codigoCiudad
WHEN 'DF' THEN
	'CMX'
ELSE
	xt_codigoCiudad
END
FROM
	IntranetGEA_Usuarios_Oficina
WHERE
	kf_usuarioId = '$usuarioId'
ORDER BY
	xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	 $ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr 	= $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault 	= $INTRANET->getOne("SELECT CASE xt_ciudad WHEN 'CDMX' THEN 'CMX' ELSE xt_ciudad END FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

if(		  $_POST['ciudad'] != ""){
	$ciudadShow = $_POST['ciudad'];
	
} else if($_GET['ciudad'] != ""){
	$ciudadShow = $_GET['ciudad'];
	
} else{
	$ciudadShow = $ciudadDefault;
	
}

for($o=0; $o <count($cdValor); $o++){
	
	if($cdValor[$o] == $ciudadShow){
		$imprimeCiudad = $ciudades[$o];
	}
	
} unset($o);

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			 <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='../ReunionesyAcuerdos.php' id='breadcrumbs'> Reuniones y Acuerdos </a>";
			 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
			<title>Tablero de Reuniones</title>
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

echo "<div id='wrapperFicha' align='center'>";
	echo "<form method='post' action='tableroReunionesv2.php'>";	
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
 		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>Reuniones</td>";
		echo "</tr>";
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
		
		echo "<tr>";
			echo "<td align='center'>";
				if(($usuarioId == 'Carlos_Jimenez') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Eibar_Ponce')|| ($usuarioId == 'Ricardo_Garcia') || ($usuarioId == 'sdelap') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Gerardo_Martinez') || ($usuarioId == 'Antonio_Astorga') ||($usuarioId == 'Denisse_Valladares') || ($usuarioId == 'Christian_Martinez')|| ($usuarioId == "Miguel_Patiño")  || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "Gerardo_Nunez") || ($usuarioId == "Jorge_Doring") || ($usuarioId== "Carmina_Cruz") || ($usuarioId== "Akari_Hernandez")|| ($usuarioId== "Adlemy_Tah")|| ($usuarioId== "Arianna_Cadena")|| ($usuarioId== "Luis_Caselli") || ($usuarioId == 'Guillermo_Quezada')){
					echo "<a href='altaReunionv2.php'><img src='../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'></a>";
				}
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	
				//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../../navegacion_banana.php");
			echo "</table>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	// CASO ADMINISTRADOR
	if($categoriaUsr == "Administrador" || $usuarioId == 'Cecilia_Flores'){
		
		echo "<table border='0' align='center' width='700px' id='ocultar' style='display:block;'>";
			echo"<tr>";
				echo"<td align='left' id='iconosTexto2' onClick='show(1);' width='700px'>Filtro</td>";
			echo"</tr>";
			
			echo"<tr height='30px'><td></td></tr>";
		echo"</table>";
		///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='450px' id='mostrar' style='display:none;'>";
			echo "<tr>";
				echo "<td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Ciudad</td>";
				echo "<td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Status</td>";
				echo "<td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Año</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td id='breadcrumbs' valign='left' width='150px'>";
			///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
					echo "<select name='ciudad'>";
						
						for($a = 0; $a <count($cdValor); $a++){
							
							if(in_array($cdValor[$a], $ciudadesDisponibles)){
								
								if($cdValor[$a] != $ciudadShow){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
									
								} else{
									
									echo "<option value='".$cdValor[$a]."' selected='selected'>".$ciudades[$a]."</option>";
									
								}
							}
						}
					
					echo "</select>";
				echo "</td>";
				echo "<td id='breadcrumbs' valign='left' width='150px'>";
			///DESPLIEGA EL LISTADO DE AÑOS
					echo "<select name='statusFiltro'>";
							echo "<option value=''>Selecciona....</option>";
							echo "<option value='1'>Programada</option>";
							echo "<option value='2'>Realizada</option>";
							echo "<option value='3'>Cancelada</option>";
					echo "</select>";
				echo "</td>";
				echo "<td id='breadcrumbs' valign='left' width='150px'>";
					///DESPLIEGA EL ESTATUS
					echo "<select name='yearFiltro'>";
						echo "<option value=''>Selecciona...</option>";
						$yy = $INTRANETV2->Execute("SELECT DISTINCT YEAR(xd_fecha) FROM SGI_Reuniones  ORDER BY xd_fecha DESC");
						while($ff = $yy->fetchRow()){
							$añoReunion = $ff[0];
							
							echo "<option value='".$añoReunion."'>".$añoReunion."</option>";
						}
						
							
					echo "</select>";
				echo "</td>";
			echo"</tr>";
			echo"<tr height='15px'><td colspan='2'></td></tr>";
			echo "<tr>";
					echo "<td align='center' colspan=3>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='80' height='20'>";
					echo "</td>";
			echo"</tr>";
		
			echo"<tr height='30px'><td colspan='2'></td></tr>";
		echo"</table>";// FIN DEL FILTRO POR CIUDAD
		
		for($a = 0; $a<count($reunion); $a++){
			
			$indice 		= 0;
			$claveReunion 	= NULL;
			$statusReunion 	= NULL;
			$fechaReunion 	= NULL;
			
		    $estatus      = $_POST['statusFiltro'];
			$anio         = $_POST['yearFiltro'];
			$ciudadFiltro = $_POST['ciudad'];
			//echo $ciudadFiltro."-".$ciudadShow;
			if($ciudadFiltro != ''){$ciudadQuery = "xt_ciudad = '$ciudadFiltro':";}else{$ciudadQuery = "xt_ciudad = '$ciudadShow':";}
			if($estatus != ''){$estatusQuery = "xn_status = $estatus:";}else{$estatusQuery = "";}
		    if($anio != ''){$anioQuery = "YEAR(xd_fecha) = $anio:";}else{$anioQuery = '';}
			
			$concatenarFiltro = $ciudadQuery.$anioQuery.$estatusQuery;
		
			$filtroRemplaza = str_replace(":"," AND ",$concatenarFiltro);
			$filtroRemplazaAnd = substr($filtroRemplaza,0,-4);
			
			if($estatus != '' || $anio != '' || $ciudadFiltro != ''){
				$query = "SELECT xt_codigoReunion, CASE xn_status WHEN 1 THEN 'Programada' WHEN 2 THEN 'Realizada' WHEN 3 THEN 'Cancelada' END, xd_fecha FROM SGI_Reuniones WHERE xt_tipo = '$reunion[$a]' AND ".$filtroRemplazaAnd." ORDER BY xt_codigoReunion ";
			}else{
				$query = "SELECT xt_codigoReunion, CASE xn_status WHEN 1 THEN 'Programada' WHEN 2 THEN 'Realizada' WHEN 3 THEN 'Cancelada' END, xd_fecha FROM SGI_Reuniones WHERE xt_tipo = '$reunion[$a]' AND ".$filtroRemplazaAnd." AND xn_status = 1 ORDER BY xt_codigoReunion ";
			}

			//echo $query;
			
			$s = $INTRANETV2->Execute($query);
					
			while($r = $s->fetchRow()){
				
				$claveReunion[$indice] 	= $r[0];
				$statusReunion[$indice] = $r[1];
				$fechaReunion[$indice] 	= date('Y-m-d', strtotime($r[2]));
				
				$indice++;
				
			} unset($r); unset($s); unset($indice);
				 
			
			if(count($claveReunion) >= 1){
				
				echo "<table border='0' align='center' width='750px'>";
				
					echo "<tr><td colspan='4' id='titulo2Blanco' >".$nombreReunion[$a]."</td></tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";	
					
					echo "<tr id='titulo2'>";
						echo "<td align='center' width='50px'></td>";
						echo "<td align='center' width='200px'>Código</td>";
						echo "<td align='center' width='200px'>Fecha</td>";
						echo "<td align='center' width='300px'>Status</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td colspan='3' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";
					
				echo "</table>";
				
				echo"<table align='center' border='0' width='750px'>";
				
				for($o = 0; $o <count($claveReunion); $o++){
					
					echo "<tr id='fileItem'>";
						echo "<td width='50px'></td>";				
						echo "<td width='200px' align='center'>";
							if($statusReunion[$o] == 'Realizada' || $statusReunion[$o] == 'Cancelada'){ 
								echo "<a href='fichaReunionv2.php?id=".$claveReunion[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}else if($statusReunion[$o] == 'Programada'){
								echo "<a href='ReunionElementoActualizarv2.php?id=".$claveReunion[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}
						echo "</td>";
						
						echo "<td width='200px' align='center'>".$fechaReunion[$o]."</td>";
						
						echo "<td width='300px' align='center'>".$statusReunion[$o]."</td>";
					echo "</tr>";
					
					echo"<tr height='5px'><td colspan='4'></td></tr>";
						
					
				}
				echo "</table>";
				
				echo "<table border='0' align='center' width='750px'>";
					echo "<tr>";
						echo "<td width='50px'></td>";
						echo "<td width='700px' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='40px'><td colspan='2'></td></tr>";
				echo "</table>";
			}
		
		}
	
	//CASO INHOUSE
	} else if($categoriaUsr == "Inhouse"){
	
		for($a = 0; $a<count($reunion); $a++){
			
			$indice 		= 0;
			//$reunionID 		= NULL;
			$claveReunion 	= NULL;
			$statusReunion 	= NULL;
			$fechaReunion 	= NULL;
			
			$s = $INTRANETV2->Execute("SELECT xt_codigoReunion, CASE xn_status WHEN 1 THEN 'Programada' WHEN 2 THEN 'Realizada' WHEN 3 THEN 'Cancelada' END, xd_fecha FROM SGI_Reuniones WHERE xt_ciudad = '$ciudadDefault' AND xt_tipo = '$reunion[$a]' ORDER BY xd_fecha DESC ");
					
			while($r = $s->fetchRow()){
				$claveReunion[$indice] 	= $r[0];
				$statusReunion[$indice] = $r[1];
				$fechaReunion[$indice] 	= date('Y-m-d', strtotime($r[2]));
				
				$indice++;
				
			} unset($r); unset($s); unset($indice);
				 
			
			if(count($claveReunion) >= 1){
				
				echo "<table border='0' align='center' width='750px'>";
				
					echo "<tr><td colspan='4' id='titulo2Blanco' >".$nombreReunion[$a]."</td></tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";	
					
					echo "<tr id='titulo2'>";
						echo "<td align='center' width='50px'></td>";
						echo "<td align='center' width='200px'>Código</td>";
						echo "<td align='center' width='200px'>Fecha</td>";
						echo "<td align='center' width='300px'>Status</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td colspan='3' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='10px'><td colspan='4'></td></tr>";	
					
				echo "</table>";
				
				
				echo"<table align='center' border='0' width='750px'>";
				
				for($o = 0; $o <count($claveReunion); $o++){
					
					echo "<tr id='fileItem'>";
						echo "<td width='50px'></td>";				
						echo "<td width='200px' align='center'>";
							if($statusReunion[$o] == 'Realizada' || $statusReunion[$o] == 'Cancelada'){ 
								echo "<a href='fichaReunionv2.php?id=".$claveReunion[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}else if($statusReunion[$o] == 'Programada'){
								echo "<a href='ReunionElementoActualizarv2.php?id=".$claveReunion[$o]."' id='fileItem' style='text-decoration: none;'>".$claveReunion[$o]."</a>";
								
							}
						echo "</td>";
						
						echo "<td width='200px' align='center'>".$fechaReunion[$o]."</td>";
						
						echo "<td width='300px' align='center'>".$statusReunion[$o]."</td>";
					echo "</tr>";
					
					echo"<tr height='5px'><td colspan='4'></td></tr>";
						
					
				}
				
				echo "</table>";
				
				echo "<table border='0' align='center' width='750px'>";
					echo "<tr>";
						echo "<td width='50px'></td>";
						echo "<td width='700px' id='titleBlueLineBottom'></td>";
					echo "</tr>";
					
					echo "<tr height='40px'><td colspan='2'></td></tr>";
				echo "</table>";
			}
		
		}

	}//FIN CASO INHOUSE
	
  		echo "</form>";
	echo "</div>";
?>

    	</body>
    </html>
<?php

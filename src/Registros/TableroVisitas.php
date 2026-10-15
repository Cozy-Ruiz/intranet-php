<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio García Robles
 *@version 3.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'TableroVisitas.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Tablero Visitas</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
<script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
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
$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN"; 
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
$ciudadesDisponibles = NULL;
$indice = 1;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='Registros.php' id='breadcrumbs'> Registros</a> ";
$fecha= $_POST['fecha']; 
$hoy = date("Y-m-d");

echo "<div id='wrapperVisitas'>";
  echo "<form name='tableroVisitas' method='post' action='TableroVisitas.php'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr height='30'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Tablero de Visitas</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='70'> </tr>";
	echo "</table>";
	if($categoriaUsr == "Administrador"){
		echo "<table border='0' align='center' width='450'>";
			echo"<tr height='15px'></tr>";
			
			echo "<tr>";
					echo "<td id='iconosTexto2' align='center'>Ciudad</td>";
			echo "</tr>";
				
			echo"<tr height='5'></tr>";
			
			echo "<tr>";
				echo "<td align='center'>";
					echo "<select name='ciudad'>";
						echo "<option value='' selected=''></option>";	
						for($a = 1; $a <= 6; $a++){
							if(in_array($cdValor[$a], $ciudadesDisponibles)){
								echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
							}
						}
					echo "</select>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='15px'></tr>";		
		echo"</table>";
	}
	echo "<table border='0' align='center' width='1100' >";
		
		echo"<tr height='20'> </tr>";
		
		echo"<tr height='23'>";
			echo"<td align='left' width='35' id='breadcrumbs'>Fecha: </td>";
			if ($fecha !=""){
				echo"<td align='left' width='100'><input type='text' name='fecha' class='DatP' size='15' style='height:10px;' value='$fecha'> </td>";
			}else{
				echo"<td align='left' width='100'><input type='text' name='fecha' class='DatP' size='15' style='height:10px;' value='$hoy'> </td>";
			}
			
			//$s= $INTRANET->Execute("SELECT kf_usuario FROM SGI_Usuario_Registro_Ciudad WHERE xt");
			
			echo"<td align='left' width='15'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_CalendarioPopUp.png' height='15' width='15'> </td>";
			
			if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Samantha_Abam') ||($usuarioId == 'sdelap') ||
				($usuarioId == 'Norma_Tapia') || ($usuarioId == 'Fulgencio_Duran') || ($usuarioId == 'Ruperto_Vicencio') || ($usuarioId == 'Ruben_Solis') || ($usuarioId == 'Javier_Rosas') ||
				($usuarioId == 'Alfonso_Santiago') || ($usuarioId == 'Gustavo_Gracia') || ($usuarioId == 'Eduardo_Hernandez')){
					
				echo "<td width='330'></td><td align='left' width='620'><a href='altaVisitaPopUp2.php' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=700,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'> </a></td>";
			}
		echo"</tr>";
		
		echo"<tr height='20'> </tr>";
		
	echo "</table>";
		
	echo "<table border='0' align='center' >";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr id='titulo2'>";
			echo"<td align='left' width='80'>Gafete</td>";
			echo"<td align='left' width='80'>Tipo</td>";
			echo"<td align='left' width='260'>Nombre</td>";
			echo"<td align='left' width='230'>Empresa</td>";
			echo"<td align='left' width='260'>Responsable</td>";
			echo"<td align='left' width='100'>Entrada</td>";
			echo"<td align='left' width='100'>Salida</td>";

				echo"<td align='right' width='20'></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td colspan='8' width='1130' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'> </tr>";	
		
	echo "</table>";
	
	echo"<table align='center' border='0'>";
	
	
	if ($fecha == ""){
		
		$s = $INTRANET->Execute("
			SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida,
			E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita
			FROM SGI_Visitas V, SGI_Empleados E 
			WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$hoy' 
			ORDER BY xd_fecha,xt_horaEntrada DESC");
			
		while($r = $s->fetchRow($s)){
			$salida ="". $r[7];

				echo "<tr height='25' id='iconosTexto'>";				
					
					echo "<td width='80' align='left'>";
						echo"<a href='fichaVisita.php?id=$r[0]' id='iconosTexto' style='text-decoration:none;'> $r[1] </a>";
					echo "</td>";
					
					echo "<td width='80' align='left'>";
						if($r[12] == "P"){
							echo"Proveedor";
						} else if($r[12] == "C"){
							echo"Cliente";
						} else if($r[12] == "V"){
							echo"VIP";
						} else if($r[12] == "A"){
							echo"Autoridad";
						}
						
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						echo "<a href='fichaVisita.php?id=$r[0]' id='iconosTexto' style='text-decoration:none;'>$r[2] $r[3] $r[4]</a>";
					echo "</td>";
					
					echo "<td width='230' align='left'>";
						echo "$r[11]";
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						$visitante = $r[2].$r[3].$r[4];
						$visitado = $r[8].$r[9].$r[10];
						if($visitante != $visitado){
							echo "$r[8] $r[9] $r[10]";
						}
					echo "</td>";
					
					echo "<td width='100' align='center'>";
						echo date('H:i',strtotime($r[6]));
					echo "</td>";
					if($salida != ""){
						echo "<td width='100' align='left'>".date('H:i',strtotime($salida))."</td>";
						
					}else if($salida == (NULL)){
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Samantha_Abam') ||($usuarioId == 'sdelap') ||($usuarioId == 'Norma_Tapia')
							|| ($usuarioId == 'Javier_Rosas')|| ($usuarioId == 'Fulgencio_Duran') || ($usuarioId == 'Ruperto_Vicencio')|| ($usuarioId == 'Ruben_Solis') ||($usuarioId == 'Alfonso_Santiago')
							|| ($usuarioId == 'Gustavo_Gracia')|| ($usuarioId == 'Eduardo_Hernandez')){
							echo "<td width='100' align='left'> <a href='updateSalida.php?id=$r[0]' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=500,scrollbars=yes')\"> 
									<img src='../Imagenes/ICN_Boton_Azul.png'></a>
								</td>";
						}else {
							echo "<td width='100' align='left'></td>";
						}
					}
					
					echo "<td width='20' align='right'>";
					echo "</td>";
				echo "</tr>";
			
			echo"</td></tr>";
		}
	}else if ($fecha != ""){
		
		$s = $INTRANET->Execute("
			SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida,
			E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita 
			FROM SGI_Visitas V, SGI_Empleados E 
			WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$fecha' 
			ORDER BY xd_fecha,xt_horaEntrada DESC");
		
		while($r = $s->fetchRow($s)){
			$salida ="". $r[7];

				echo "<tr height='25' id='iconosTexto'>";				
					
					echo "<td width='80' align='left'>";
						echo"<a href='fichaVisita.php?id=$r[0]' id='iconosTexto' style='text-decoration:none;'> $r[1] </a>";
					echo "</td>";
					
					echo "<td width='80' align='left'>";
						if($r[12] == "P"){
							echo"Proveedor";
						} else if($r[12] == "C"){
							echo"Cliente";
						} else if($r[12] == "V"){
							echo"VIP";
						} else if($r[12] == "A"){
							echo"Autoridad";
						}
						
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						echo "<a href='fichaVisita.php?id=$r[0]' id='iconosTexto' style='text-decoration:none;'>$r[2] $r[3] $r[4]</a>";
					echo "</td>";
					
					echo "<td width='230' align='left'>";
						echo "$r[11]";
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						$visitante = $r[2].$r[3].$r[4];
						$visitado = $r[8].$r[9].$r[10];
						if($visitante != $visitado){
							echo "$r[8] $r[9] $r[10]";
						}
					echo "</td>";
					
					echo "<td width='100' align='center'>";
						echo date('H:i',strtotime($r[6]));
					echo "</td>";
					if($salida != ""){
						echo "<td width='100' align='left'>".date('H:i',strtotime($salida))."</td>";
						
					}else if($salida == (NULL)){
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Octavio_Garcia')|| ($usuarioId == 'Samantha_Abam') ||($usuarioId == 'sdelap') ||($usuarioId == 'Norma_Tapia')){
							echo "<td width='100' align='left'> <a href='updateSalida.php?id=$r[0]'> <img src='../Imagenes/ICN_Boton_Azul.png'> </a> </td>";
						}else{
							echo "<td width='100' align='left'></td>";
						}
						
					}
					
					echo "<td width='20' align='right'>";
					echo "</td>";
				echo "</tr>";
			
			echo"</td></tr>";
		}
	}

		echo"<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td colspan='8' width='1130' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='50'> </tr>";
	
	echo"</table>";
		 
  echo "</form>";
echo "</div>";
?>

</body>
</html>


	 
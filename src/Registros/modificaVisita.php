<?php
$nombrephp = 'modificaVisita.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
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

</head>
<body>
<?php
$visitaID = $_GET['Id'];
$ciudad = $_GET['cd'];

if($ciudad !=""){
	$consultaCiudad="SELECT * FROM SGI_Visitas" ;
	if($ciudad != 'CMX' && $ciudad != 'DF' && $ciudad != 'CDMX'){
		$consultaCiudad=$consultaCiudad."_".$ciudad;
	}
	$consultaCiudad=$consultaCiudad." WHERE kp_visitaID = $visitaID ";
	$s = $INTRANET->Execute($consultaCiudad);
}

//$s = $INTRANET->Execute ("SELECT * FROM SGI_Visitas WHERE kp_visitaID = $visitaID ");
while($r = $s->fetchRow($s)){
	$IDvisita = $r[0];
	$fecha = $r[1];
	$nombre = $r[2];
	$apaterno = $r[3];
	$amaterno = $r[4];
	$empresa = $r[5];
	$responsable = $r[6];
	$departamento = $r[7];
	$entrada = $r[8];
	$salida = $r[9];
	$identificacion = $r[10];
	$computo = $r[11];
	$gafete = $r[12];
	$placa = $r[13];
	$usuariokf = $r[14];
	$tipoVisita = $r[17];
} unset($r); unset($s);

$breadcrumb="<a href='https://escalante.com.mx/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='Registros.php' id='breadcrumbs'> Registros /</a><a href='TableroVisitas2.php' id='breadcrumbs'> Tablero Visitas</a> ";

echo "<div id='wrapper'>";
  echo "<form name='fichaVisitas' method='post' action='UpdateVisita.php'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Ficha Visitas</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>";
			echo"<td align='center' id='breadcrumbs'>";
				echo "$breadcrumb";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='50'> </tr>";
	echo "</table>";
	
	//LINEA
	echo "<table border='0' align='center' width='600'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo "</table>";
	
	//CUERPO FICHA VISITAS
	

	echo "<table border='0' align='center' >";
				
		echo"<tr height='10'> </tr>";
		
		echo"<tr id='titulo2'>";
			echo"<td width='70'>*Gafete: </td> ";
			echo"<td width='200'> <input type='text' size='10' name='gafete' value='$gafete'><input type= 'hidden' name='Id' value='$IDvisita' ><input type= 'hidden' name='cd' value='$ciudad'> </td> ";
			echo"<td width='70' align='right'>Fecha:</td> ";
			echo"<td align='left' id='titulo18' width='110'><input type='text' size='10' name='fecha' value='$fecha'></td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr id='titulo2'>";
			echo"<td colspan='2'> </td> ";
			echo"<td align='right'>Entrada: </td> ";
			echo"<td align='left' id='titulo18'><input type='text' size='10' name='horaEntrada' value='$entrada'> </td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr>";
			echo"<td colspan='2'> </td> ";
			echo"<td id='titulo2' align='right'>Salida: </td> ";
				if($salida != ""){
					echo"<td id='titulo18' align='left' ><input type='text' size='10' name='horaSalida' value='$salida'></td>"; 
				} else {
					echo"<td id='titulo18' align='left' ></td>"; 	
				}
			echo " ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
	echo"</table>";
		
	echo "<table border='0' align='center' >";	
		
		echo"<tr id='titulo2'>";
			echo"<td align='left'>*Nombre: <input type='text' size='20' name='nombre' value='$nombre'> </td> ";
			echo"<td align='center'> <input type='text' size='20' name='apaterno' value='$apaterno'> </td> ";
			echo"<td align='left'> <input type='text' size='20' name='amaterno' value='$amaterno'></td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
	echo"</table>";
	
	echo "<table border='0' align='center' >";
		
		echo"<tr id='titulo2'>";
			echo"<td align='left' >*Empresa: </td> ";
			echo"<td align='left'><input type='text' size='50' name='empresa' value='$empresa'></td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		$s= $INTRANET->Execute("SELECT xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados WHERE kp_personalId =$responsable ");
			while($r = $s->fetchRow($s)){
				$nombreResponsable = $r[0];
				$apaternoResponsable = $r[1];
				$amaternoResponsable = $r[2];
				
			}unset($r); unset($s);
		echo"<tr id='titulo2'>";
			echo"<td align='left' >*Persona que visita: </td> ";
			echo"<td align='left'>
					<select size='1' name='personaVisita'>";
						echo"<option value='$responsable'>$nombreResponsable $apaternoResponsable</option>";
						$s= $INTRANET->Execute("SELECT kp_personalId, xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM SGI_Empleados ORDER BY xt_nombre ");
								while($r= $s -> fetchRow()){
									echo"<option value='$r[0]'>$r[1] $r[2] $r[3]</option>";
										
								} unset($r); unset ($s);
				echo"</select>";
			echo"</td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo "<tr align='left' height='20'>";
				echo "<td id='titulo2' align='left'>Tipo: </td>";
					 if($tipoVisita=='P') {
						echo "<td id='titulo2Blanco' align='left'>Proveedor</td>";
					}else if($tipoVisita=='C') {
						echo "<td id='titulo2Blanco' align='left'>Cliente</td>";
					}else if($tipoVisita=='V') {
						echo "<td id='titulo2Blanco' align='left'>VIP</td>";
					}
		echo "</tr>";	
			
		echo"<tr height='10'> </tr>";	
		
		
		echo"<tr id='titulo2'>";
			echo"<td align='left' >*Identificación: </td> ";
			echo"<td align='left'><input type='text' size='50' name='identificacion' value='$identificacion'></td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr id='titulo2'>";
			echo"<td align='left'>Equipo de computo: </td> ";
			echo"<td align='left'><textarea name='ecomputo' style='width: 318px; height:80px;'>$computo</textarea></td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr id='titulo2'>";
			echo"<td align='left'>Placa Vehicular: </td> ";
			echo"<td align='left'><input type='text' size='50' name='placa' value='$placa'></td> ";
		echo"</tr>";
		
		echo"<tr height='10'> </tr>";
		
	echo"</table>";
	
	//LINEA
	echo "<table border='0' align='center' width='600'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		if (($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'cozy') || ($usuarioId == 'Octavio_Garcia') || ($usuarioId == 'Samantha_Abam') || ($usuarioId == 'sdelap')|| ($usuarioId == 'Norma_Tapia')
			|| ($usuarioId == 'Javier_Rosas')|| ($usuarioId == 'Fulgencio_Duran') || ($usuarioId == 'Ruperto_Vicencio')|| ($usuarioId == 'Ruben_Solis') ||($usuarioId == 'Alfonso_Santiago')
			|| ($usuarioId == 'Gustavo_Gracia')|| ($usuarioId == 'Eduardo_Hernandez')||($usuarioId == 'Erika_Muñoz')||($usuarioId == 'Karina_Vega')){
			echo"<tr height='40'>";
			echo"<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
		}else{
				echo"<tr height='10'> </tr>";
			}
	echo "</table>";
		 
  echo "</form>";
echo "</div>";
?>

</body>
</html>


	 
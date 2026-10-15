<?php error_reporting(0); ?>
<?PHP
$nombrephp="modificaPersonal.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Modifica Personal</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
</head>

<body>
<?PHP
$IDpersonal= $_GET['Id'];
$s= $INTRANET->execute("SELECT xt_NumPersonal, xt_Nombre, xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Empresa, xn_Foto,xt_Estatus,xt_tipo,xt_ciudad, xt_puesto FROM SGI_Empleados WHERE kp_personalId=$IDpersonal");
	while($r = $s->fetchRow()){
		$NumPersonal = $r[0];
		$nombre= $r[1];
		$apellidoP = $r[2];
		$apellidoM = $r[3];
		$empresa = $r[4];
		$foto = $r[5];
		$estatus = $r [6];
		$tipo = $r[7];
		$ciudad = $r[8];
		$puesto = $r[9];
		if($ciudad == 'DF'){
			$ciudadDespliegue = 'Distrito Federal';
		}else if($ciudad == 'CUN'){
			$ciudadDespliegue = 'Cancún';
		}else if($ciudad == 'VER'){
			$ciudadDespliegue = 'Veracruz';
		}else if($ciudad == 'LR'){
			$ciudadDespliegue = 'Laredo';
		}else if($ciudad == 'NLR'){
			$ciudadDespliegue = 'Nuevo Laredo';
		}else if($ciudad == 'TOL'){
			$ciudadDespliegue = 'Toluca';
		}else if($ciudad == 'CVC'){
			$ciudadDespliegue = 'Cuernavaca';
		}
		
		} unset($r);

echo"<div id='wrapperFicha' align='center'>";
	echo "<form name='modificaPersonal' method='POST' action='UpdatePersonal.php'>";	
		echo "<table border='0' align='center' name='Encabezado'>";		
			echo"<tr height='80px'> </tr>";
			///Titulo Ficha
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='700px'>";
					echo "Modifica Personal";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10px'> </tr>";
		echo "</table>";

		echo "<table border='0' align='center' width='500'>";
			echo"<tr height='30px'> </tr>";
		///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
			
		//FOTO //NUMERO DE PERSONAL

			echo "<tr align='left' height='20' >";
				echo "<td id='titulo2' align='left'>$NumPersonal <input type= 'hidden' name='Id' value='$IDpersonal' ></td>"; 
				if($foto == ""){
					echo "<td  style='display:inline;' align='left'> <img src='FILES/sinFoto.jpg' height='117' width='100'> 
					<a href='CambiarFotoPopUp.php?ID=$IDpersonal'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
            		<img src='../../Imagenes/ICN_BotonModificar.png' height='20' width='80'></a> </td>";
				}else{
					
					echo "<td style='display:inline;' align='left'> <img src='$foto' height='117' width='100'>
					<a href='CambiarFotoPopUp.php?ID=$IDpersonal'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
            		<img src='../../Imagenes/ICN_BotonModificar.png' height='20' width='80'></a> </td>";
				}
				
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
					
		//NOMBRE
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Nombre: </td>";
				echo "<td align='left'><input type='text' size='50' maxlength='100' name='nombre' value='$nombre'></td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
		//APELLIDO PATERNO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Apellido Paterno: </td>";
				echo "<td align='left'><input type='text' size='50' maxlength='100' name='apellidoP' value='$apellidoP'></td>";
			echo "</tr>";
	
			echo"<tr height='10'> </tr>";
			
			//APELLIDO MATERNO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Apellido Materno: </td>";
				echo "<td align='left'><input type='text' size='50' maxlength='100' name='apellidoM' value='$apellidoM'></td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
		//ESTATUS
			echo "<tr align='left' height='20'>";
				echo "<td id='iconosTexto2' align='left'>Estatus: </td>";
				echo "<td align='left'>";
				
					echo "<select name='estatus' size='1'>";
						if($estatus ==1){
							echo "<option value='$estatus'>Activo </option>";
							echo "<option value='2'>Inactivo</option>";
						}else if($estatus ==2){
							echo "<option value='$estatus'>Inactivo </option>";
							echo "<option value='1'>Activo</option>";
						}
						
						
					echo "</select>";
			echo "</tr>";
			echo"<tr height='10'> </tr>";
			
			//TIPO
			echo "<tr align='left' height='20'>";
				echo "<td id='iconosTexto2' align='left'>Tipo: </td>";
				echo "<td align='left'>";
				
					echo "<select name='tipo' size='1'>";
						if($tipo =='E'){
							echo "<option value='$tipo'>Empleado </option>";
							echo "<option value='H'>Empleado por honorarios</option>";
							echo "<option value='P'>Proveedor</option>";
							echo "<option value='C'>Cliente</option>";
							echo "<option value='V'>VIP</option>";
							echo "<option value='D'>Directiva</option>";
							echo "<option value='A'>Autoridad</option>";
						}else if($tipo =='P'){
							echo "<option value='$tipo'>Proveedor </option>";
							echo "<option value='E'>Empleado</option>";
							echo "<option value='H'>Empleado por honorarios</option>";
							echo "<option value='C'>Cliente</option>";
							echo "<option value='V'>VIP</option>";
							echo "<option value='D'>Directiva</option>";
							echo "<option value='A'>Autoridad</option>";
						}else if($tipo =='C'){
							echo "<option value='$tipo'>Cliente </option>";
							echo "<option value='E'>Empleado</option>";
							echo "<option value='H'>Empleado por honorarios</option>";
							echo "<option value='P'>Proveedor</option>";
							echo "<option value='V'>VIP</option>";
							echo "<option value='D'>Directiva</option>";
							echo "<option value='A'>Autoridad</option>";
						}else if($tipo =='V'){
							echo "<option value='$tipo'>VIP </option>";
							echo "<option value='E'>Empleado</option>";
							echo "<option value='H'>Empleado por honorarios</option>";
							echo "<option value='P'>Proveedor</option>";
							echo "<option value='C'>Cliente</option>";
							echo "<option value='D'>Directiva</option>";
							echo "<option value='A'>Autoridad</option>";
						}else if($tipo =='D'){
							echo "<option value='$tipo'>Directiva </option>";
							echo "<option value='E'>Empleado</option>";
							echo "<option value='H'>Empleado por honorarios</option>";
							echo "<option value='P'>Proveedor</option>";
							echo "<option value='C'>Cliente</option>";
							echo "<option value='V'>VIP</option>";
							echo "<option value='A'>Autoridad</option>";
						}else if($tipo =='A'){
							echo "<option value='$tipo'>Autoridad</option>";
							echo "<option value='E'>Empleado</option>";
							echo "<option value='H'>Empleado por honorarios</option>";
							echo "<option value='P'>Proveedor</option>";
							echo "<option value='C'>Cliente</option>";
							echo "<option value='V'>VIP</option>";
							echo "<option value='D'>Directiva</option>";
						}else if($tipo =='H'){
							echo "<option value='$tipo'>Empleado por honorarios</option>";
							echo "<option value='A'>Autoridad</option>";
							echo "<option value='E'>Empleado</option>";
							echo "<option value='P'>Proveedor</option>";
							echo "<option value='C'>Cliente</option>";
							echo "<option value='V'>VIP</option>";
							echo "<option value='D'>Directiva</option>";
						}
						echo"<tr height='10'> </tr>";
						//puesto
						echo "<tr align='left' height='20' >";
							echo "<td id='iconosTexto2' align='left'>Puesto: </td>";
							echo "<td align='left'><input type='text' size='50' maxlength='100' name='puesto' value='$puesto'></td>";
						echo "</tr>";
						
					echo "</select>";
			echo "</tr>";
			echo"<tr height='10'> </tr>";
					
		//EMPRESA
			echo "<tr align='left' height='20'>";
				echo "<td id='iconosTexto2' align='left'>Empresa: </td>";
				echo "<td align='left'><input type='text' size='50' maxlength='100' name='empresa' value='$empresa'></td>";
			echo "</tr>";	
			
			echo"<tr height='10'> </tr>";
			
		//CIUDAD
			echo "<tr align='left' height='20'>";
				echo "<td id='iconosTexto2' align='left'>Ciudad: </td>";
				echo"<td align='left'>";
					echo "<select name='ciudad' size='1'>";
						if($ciudad ==""){
							echo "<option value=''>Seleccionar.. </option>";
							echo "<option value='DF'>Distrito Federal</option>";
							echo "<option value='CUN'>Cancún</option>";
							echo "<option value='LR'>Laredo</option>";
							echo "<option value='NLR'>Nuevo Laredo</option>";
							echo "<option value='VER'>Veracruz</option>";
							echo "<option value='TOL'>Toluca</option>";
							echo "<option value='CVC'>Cuernavaca</option>";
						}else if($ciudad !=""){
							echo "<option value='$ciudad'>$ciudadDespliegue </option>";
							echo "<option value='DF'>Distrito Federal</option>";
							echo "<option value='CUN'>Cancún</option>";
							echo "<option value='LR'>Laredo</option>";
							echo "<option value='NLR'>Nuevo Laredo</option>";
							echo "<option value='VER'>Veracruz</option>";
							echo "<option value='TOL'>Toluca</option>";
							echo "<option value='CVC'>Cuernavaca</option>";
						}
					echo"</select>";
				echo"</td>";
			echo "</tr>";	
			
			echo"<tr height='10'> </tr>";
			///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
		
		echo "</table>";
	echo "</form>";
echo "</div>";

?>
</body>
</html>
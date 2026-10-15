<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>


</head>

<body>

<?php
	
$nombrephp="fichaPersonal.php";
require_once("../../ConexionDBT.php");

	
	//SECCION DE EXPEDIENTE DE PERSONAL

echo $accesoExpediente = $INTRANET->getOne("Select xt_usuario FROM SGI_USUARIOS_ACCESO_EXPEDIENTE_PERSONAL WHERE xt_usuario = '$usuarioId'");
	
if($accesoExpediente != ""){
	
	
	
	echo "<table border='0' align='center' width='600'>";
	
		echo "<tr>";
			echo "<td id='titulo2'>Expediente de personal</td>";
	
			 echo "<td style='width:5%'>";

				?>
				<a href="seleccionExpedientePopUp.php?empleado=<?php echo $usuario;?>&idEmpleado=<?php echo $IDpersonal;?>" target="popup" onclick="window.open(this.href,this.target,'width=400,height=530'); return false;"><img src= "../../Imagenes/ICN_BotonMas.png"  width="15" height="15"/></a>
				<?php	

			echo "</td>";
			
		echo "</tr>";
	
	echo "</table>";
	
	echo "<table border='0' align='center' width='600'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='600px'></td>";
		echo "</tr>";
	
		echo "<tr height='10px'></tr>";
	echo "</table>";
	
	//listo los tipos de documentos con los documentos existentes
	echo "<div id='seccionExpediente'>";
	
		$s = $INTRANET->Execute("SELECT DISTINCT xt_tipo_expediente FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado ='$usuario'");
		$indexTotalDoc = 0;
		$trPos = 0;
		while($row = $s->fetchRow()){
			
			echo "<table border='0' align='center' width='600'>";
				$trPos ++;
				$trPosF = "trFile".$trPos;
				echo "<tr height='7px'></tr>";
				echo "<tr class='trTipoD' style='width:70%'>";
					echo "<td style='width:5%'> </td>";

					echo "<td id='iconosTexto2' width='70%' height='5px'>";
						echo "<input type='hidden' name='tipoDoc' id='tipoDoc' value='$row[0]'>";
						echo "<b> $row[0] </b>";
						echo "<br>";
					echo "</td>";

					echo "<td style='width:130%'> </td>";
					
					echo "<td align='right'>";
					
					?>
					<a onClick="activaFile('<?php echo $trPosF; ?>')" style="cursor:pointer;"><img  src="../../Imagenes/ICN_BotonMas.png"" width="10" height="10"/></a>
					<?php	
			
					echo "<td>";
			
				echo "</tr>";
			
				echo "<tr height='.3px'>";
			
          			echo "<td></td>";
					echo "<td colspan='7' id='titleBlueLineBottom'></td>";
			
          		echo "</tr>";
			
				echo "<tr height='7px'></tr>";
			
			
				$x = $INTRANET->Execute("select xt_nombre_archivo FROM SGI_EXPEDIENTE_PERSONAL WHERE xt_usuario_empleado = '$usuario' and xt_tipo_expediente = '$row[0]'");
			
				$numDoc = 0;
				while($rowss = $x->fetchRow()){
			
					if($rowss[0] != ""){
						
						echo "<table border='0' align='center' width='600'>";
							echo "<tr class='trDoctos'>";
								echo "<td> </td>";


								echo "<td style='font-size: 11px;padding:0px 0px 0px 30px;'>";
									echo $rowss[0];
									$numDoc ++;
								echo "</td>";


								echo "<td width='130%'> </td>";

								//img de descarga
								echo "<td>";
									echo "<a href='extraccionExpediente.php?empleado=$usuario&descarga=$rowss[0]'><img src='../../Imagenes/ICN_Archivo.png' height='15px' width='12px' /></a>";
								echo "</td>";

								echo "<td></td>";

								//img de eliminar
								echo "<td>";
									echo "<a href='eliminaExpediente.php?empleado=$usuario&elimina=$rowss[0]&tipoD=$row[0]&user=$usuario&guia=$guia'><img src='../../Imagenes/ICN_NoOK.png' height='13px' width='13px'/></a>";
								echo "</td>";


								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";

							echo "</tr>";
						echo "</table>";
					}
			
				}
			
				echo "<tr height='20px'></tr>";
			
			echo "</table>";
			//fin segundo while
			
			//fila del formulario para subir archivo
			echo "<table border='0' align='center' width='600'>";
			
				echo "<tr id='$trPosF' style='display: none'>";
				echo "<td></td>";
					echo "<td>";
						echo "<div id='divFile'>
						<form action='cargadorArchivosExpediente.php?evento=cargaArchivo&user=$usuario&tipoA=$row[0]' method='post' enctype='multipart/form-data'>
						<fieldset style='width:40%'>
							<input type='file' name='archivo[]' id='archivo' multiple></input>
							<div align='right'><input type='submit' name='subir' value='Enviar'></input></div>
						</fieldset>
						</form> </div>";

					echo"</td>";

				echo "</tr>";
			
			echo "</table>";
			
		}
	
	echo "</div>";
	
	
}
	
	

	

	//FIN SECCION EXPEDIENTE PERSONAL
	
?>


</body>
</html>
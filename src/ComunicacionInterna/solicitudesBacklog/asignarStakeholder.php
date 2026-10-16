<?php error_reporting(0); ?>
<?php
require_once("ConexionDBT.php");

$usuario = $_POST['usuario'];
$codigoE = $_POST['codE'];
$catalogo = $_POST['catalogo'];
$valorPrevio = $_POST['input'];
$solicitudID = $_POST['solicitud'];

date_default_timezone_set("America/Mexico_City");

$fecha = date("Y-m-d H:i:s");

//echo "SELECT  xt_nombre, xt_correoElectronico FROM CATALOGO_STAKEHOLDERS WHERE xt_usuario = '$catalogo'";
//echo "<br>";
$rows = $INTRANET->Execute("SELECT  xt_nombre, xt_correoElectronico FROM BACKLOG.CATALOGO_STAKEHOLDERS WHERE xt_usuario = '$catalogo'");
while($s = $rows->fetchRow()){
	if(empty($valorPrevio)){
		$r = $INTRANET->Execute("INSERT INTO BACKLOG.STAKEHOLDERS VALUES('$catalogo','$codigoE','$s[0]','$s[1]','$fecha')");
	}else{
		//echo "UPDATE STAKEHOLDERS SET xt_usuario = '$catalogo', xt_nombre = '$s[0]', xt_correoElectronico = '$s[1]', xd_fecha = '$fecha' WHERE xt_usuario = '$valorPrevio' AND xt_codigoEntregable = '$codigoE'";
		$r = $INTRANET->Execute("UPDATE BACKLOG.STAKEHOLDERS SET xt_usuario = '$catalogo', xt_nombre = '$s[0]', xt_correoElectronico = '$s[1]', xd_fecha = '$fecha' WHERE xt_usuario = '$valorPrevio' AND xt_codigoEntregable = '$codigoE'");
	}
}

if($r){
	echo "<div id='nuevostakeholder' style='display:none;'>";
		  		echo "<table border='0' align='center' width='700' cellspacing='0'>";
		  			echo "<tr style='display:none;'>";
				  			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				  			echo "</td>";
			  		echo "</tr>";
			  		echo "<tr id='stakeholder2'>";
			  			echo "<td>";
					  		echo "<select name='catalogo'>";
					  			echo "<option>Selecciona....</option>";
					  		$rows = $INTRANET->Execute("SELECT xt_usuario FROM BACKLOG.CATALOGO_STAKEHOLDERS ORDER BY xt_usuario ASC");
					  		while($select = $rows->fetchRow()){
					  			echo "<option value='".$select[0]."'>$select[0]</option>";
					  		}
							echo "</select>";
						echo "</td>";
				  	echo "</tr>";
				  	$codigoE = $INTRANET->getOne("SELECT xt_codigoEntregable FROM BACKLOG.ENTREGABLES WHERE xt_solicitud = '$solicitudID'");
				  	echo "<tr id='stakeholder2'>";
				  	?>
					<td colspan='3'><div id='btnHistorial' align='right'><a style='cursor:pointer' id='modifP'  onClick='guardaStakeHolder("nuevo","<?php echo $codigoE; ?>")'><font color='#007CBD'>Guardar</font></a></div></td>
					<?php
					echo "</tr>";
				echo "</table>";
			echo "</div>";
	$r = $INTRANET->Execute("SELECT DISTINCT(xt_usuario) FROM BACKLOG.STAKEHOLDERS WHERE xt_codigoEntregable = '$codigoE'");
  		$total = $r->recordCount();
  		if($total > 0){
	  		while($s = $r->fetchRow()){

	  			echo "<div id='$s[0]1' style='display:block'>";
		  			echo "<table border='0' align='center' width='700' cellspacing='0'>";
			  			echo "<tr>";
				  			echo "<td id='manualVinculo' style='font-size:14px;'>";
					  			echo $s[0];
					  			echo  "<input type='hide' id='inputstakeholder' name='stakeholderinput' style='display:none;' value='".$s[0]."'>";
				  			echo "</td>";
			  			echo "</tr>";
			  			echo "<tr>";
			  			?>
							<td colspan='3'><div id='btnHistorial' align='right'><a style='cursor:pointer' id='modifP'  onClick='activaStakeHolder("<?php echo $s[0]; ?>")'><font color='#007CBD'>Editar</font></a></div></td>
						<?php
						echo "</tr>";
						echo "<tr height='30'></tr>";
					echo "</table>";
				echo "</div>";
		  			
		  		echo "<div id='$s[0]' style='display:none' >";
		  			echo "<table border='0' align='center' width='700' cellspacing='0'>";
		  				echo "<tr>";	
		  					echo "<td>";
				  				echo "<select name='$s[0]'>";
				  					echo "<option>Selecciona....</option>";
				  				$rows = $INTRANET->Execute("SELECT xt_usuario FROM BACKLOG.CATALOGO_STAKEHOLDERS ORDER BY xt_usuario ASC");
				  				while($select = $rows->fetchRow()){
				  					echo "<option value='".$select[0]."'>$select[0]</option>";
				  				}
				  				echo "</select>";
				  			echo "</td>";
			  			echo "</tr>";

			  			echo "<tr>";
			  			?>
						<td colspan='3'><div id='btnHistorial' align='right'><a style='cursor:pointer' id='modifP'  onClick='guardaStakeHolder("<?php echo $s[0]; ?>","<?php echo $codigoE; ?>");'><font color='#007CBD'>Guardar</font></a></div></td>
						<?php
						echo "</tr>";
					echo "</table>";
				echo "</div>";

	  		}
	  	}
	}

	echo "<table align='center' border='0'>";
				echo "<tr>";
					echo "<td>";
						echo "<div id='cargastakeHolder' style='display:none; align=center;'>";
						echo "<img src='../../Imagenes/img_load.gif' />";
						echo "</div>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
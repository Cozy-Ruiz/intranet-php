<?php error_reporting(0); ?>
<?php

$nombrephp = 'tableroRoles.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

//var_dump($_SESSION);
$oficina = $INTRANETV2->getOne("SELECT xt_ciudad FROM intranetgea_usuarios WHERE kp_usuario = '".$usuarioId."' ");
if($oficina == "CDMX" || $oficina == "DF"){
	$oficina = "CDMX";
}elseif ($oficina == "LAR" || $oficina == "NLR"){
	$oficina = "NLRD";
}


//var_dump($oficina);

if($oficina != null){
	$llaves = $INTRANETV2->getArray("SELECT * FROM sgi_control_llaves WHERE xt_oficina = '".$oficina."' ORDER BY xt_usuario ");
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
			<title>Control de llaves</title>
			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            
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

				function confirmDelete(numeroLlave, usuario, oficina){
					var confirmacion = confirm("Confirma eliminar llave?.");
					if (confirmacion != false) {

						//alert("Eliminando llave");
						
						var xhttp = new XMLHttpRequest();

						xhttp.onreadystatechange = function() {
							
							if (xhttp.readyState == 4 && xhttp.status == 200) {

								if(xhttp.responseText == ""){
									location.reload();
								}else{
									alert(xhttp.responseText);
									//actualizaReferencia(referencia);
								}
							}
						};
						
						xhttp.open("POST", "eliminaLlaveUsuario.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("numeroLlave=" + numeroLlave + "&usuario=" + usuario + "&oficina=" + oficina);
						
					}
				}
		
			</script>
            
            
            
<!-- ESTILO PARA PRIORIDAD Y FECHAS-->
 <style>

 /*#roles{
    font-size: 23px;
	color: #FFF;
	font-family: Arial;
}
*/

</style>

        </head>
        <body>
<?php

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='../Modulos.php' id='breadcrumbs'> Módulos";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	

	//codigo de menu navegable
	
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Control de llaves</font>";
			echo"</td>";
		echo"</tr>";
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
		//echo"<tr height='70'> </tr>";
	echo "</table>";
	
		//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../navegacion_banana.php");
	echo "</table>";

		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	
	//fin de menu
	echo "<table border='0' align='center' name='Cuerpo'>";
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>".$oficina."</td>";
				echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
				echo "<a href='asignaLlaveUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
		echo "</tr>";
		///Linea
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3'></td>";
		echo "</tr>";
		echo"<tr height='20px'> </tr>";
			echo "<td align='left' width='250px' valign='top'>";
				echo "<a href='' id='manualVinculo'></a>";
			echo "</td>";
			echo "<td align='left' width='550px' valign='top'></td>";
		echo "</tr>";
		
		echo"<tr height='5'> </tr>";
	echo "</table>";

	
	echo "<table border='0' cellspacing='0' style='width:100%; margin-bottom:4em;'>";	
		echo "<tr height='45'>";
			echo "<td></td>";
			echo "<td><h2><b>Llave</b></h2></td>";
			echo "<td align='center'><h2><b>Lugar uso</b></h2></td>";
			echo "<td><h2><b>Asignada</b></h2></td>";
			echo "<td><h2><b>Observaciones</b></h2></td>";
			echo "<td><b></b></td>";
			echo "<td><b></b></td>";
		echo "</tr>";

		foreach($llaves as $clave => $llave){
			echo "<tr height='30'>";
				echo "<td>".($clave + 1).".-</td>";
				echo "<td><a href='fichaLlave.php?numeroLlave=".$llave['xt_numeroLlave']."&usuario=".$llave['xt_usuario']."' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=800,scrollbars=yes')\">".$llave['xt_numeroLlave']."</a></td>";
				echo "<td>".$llave['xt_lugarUso']."</td>";
				echo "<td>".$llave['xt_usuario']."</td>";
				echo "<td>".$llave['xt_observaciones']."</td>";
				echo "<td><a href='modificaLlaveUsuario.php?numeroLlave=".$llave['xt_numeroLlave']."&usuario=".$llave['xt_usuario']."&oficina=".$oficina."' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=600,scrollbars=yes')\"><img src='../../Imagenes/ICN_Auditorias.png' height='15' width='15'> </a></td>";
				echo "<td><img src='../../Imagenes/ICN_BotonBasura.png' height='15' width='15' onclick=\"confirmDelete('".$llave['xt_numeroLlave']."', '".$llave['xt_usuario']."', '".$oficina."')\"></td>";
			echo "</tr>";
		}

	echo"</table>";



	

echo "</div>";
?>

</body>
</html>
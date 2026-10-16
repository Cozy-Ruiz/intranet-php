<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio F. García Robles
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'updateSalida.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");


$visitasID 	= $_GET['id'];
$ciudad 	= $_GET['cd'];

date_default_timezone_set('America/Mexico_City');
$horaActual = date('H:i:s');
//echo $horaActual;
//$horaActual = date('H:i:s', time()-1150);
@$ip	 	= getenv(REMOTE_ADDR);

$equipoComputo = "";

$consultaCiudad = "SELECT xt_equipoComputo FROM SGI_Visitas";

if($ciudad != 'CMX' || $ciudad != 'DF' || $ciudad != 'CDMX' || $ciudad != 'ALL'){
	$consultaCiudad = $consultaCiudad."_".$ciudad;
}

$consultaCiudad = $consultaCiudad." WHERE kp_visitaID = $visitasID ";
$equipoComputo 	= $INTRANET->getOne($consultaCiudad);
//echo "$consultaCiudad";

if(($equipoComputo != "") && ($_POST['confirma'] == "")){
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
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
    			<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <script type="text/javascript">
					function reCargarPadre(){
						opener.location.reload();
						window.close();
					}
				</script>
    		</head>
    <body>
    <?php
	echo "<div id='wrapperPopUp'>";
		echo "<form name='altaVisitas' method='post' action='updateSalida.php?id=$visitasID&cd=$ciudad'>";
		
			echo "<table border='0' align='center' name='menuLetras'>";
				echo "<tr height='30'> <td colspan='3'> </td> </tr>";
				
				echo "<tr>";
					echo "<td align='center' id='titulo1' colspan='3'>Visita</td>";
				echo "</tr>";
				
				echo "<tr height='30'> </tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2' colspan='3'>Equipo de Cómputo</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'></td>";
				echo "</tr>";
				
				echo "<tr height='30'></tr>";
				
				echo "<tr>";
					echo "<td width='30px'></td>";
					echo "<td align='left' id='iconosTexto' width='400px'> $equipoComputo</td><input type='hidden' name='confirma' value='OK'>";
					echo "<td width='20px'></td>";
				echo "</tr>";
				
				echo "<tr height='30'> </tr>";
						
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3'> </td>";
				echo "</tr>";
			echo "</table>";
			echo "<table border='0' align='center' >";	
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' width='350'>";
						echo "<img src='../Imagenes/ICN_NoOK.png' width='29' height='29' onClick='window.close()'>";
					echo "</td>";
					echo "<td width='15'> </td>";
					echo "<td width='100' align='center'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='29' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr >";
					echo"<td valign='bottom' align='right' width='350' id='iconosTexto' colspan='2'>";
						echo "Incorrecto";
					echo "</td>";
					echo "<td width='100' align='center' id='iconosTexto'>";
						echo "Correcto";
					echo"</td>";
				echo"</tr>";
				echo "<tr height='30'> </tr>";			
			echo "</table>";
		echo "</form>";
	echo "</div>";
} else if(($equipoComputo != "") && ($_POST['confirma'] == "OK")){
	
	$consulta = "UPDATE SGI_Visitas" ;
	
	if($ciudad != 'CMX' && $ciudad != 'DF' && $ciudad != 'CDMX' && $ciudad != 'ALL'){
		$consulta = $consulta."_".$ciudad;
	}
	
	$consulta = $consulta." SET xt_horaSalida = '$horaActual', kf_usuario = '$usuarioId', xt_ip = '$ip' WHERE kp_visitaID = $visitasID ";
	$INTRANET->Execute($consulta);
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
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
    			<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <script type="text/javascript">
					function reCargarPadre(){
						opener.location.reload();
						window.close();
					}
				</script>
    		</head>
    <body>
    <?php
	echo "<script type='text/javascript'>reCargarPadre()</script>";
		//header("Location: TableroVisitas2.php?ciudad=$ciudad");
	
	
} else if($equipoComputo == ""){
	
	$consulta="UPDATE SGI_Visitas" ;
	
	if($ciudad != 'CMX' && $ciudad != 'DF' && $ciudad != 'CDMX' && $ciudad != 'ALL'){
		$consulta = $consulta."_".$ciudad;
	}
	
	$consulta = $consulta." SET xt_horaSalida = '$horaActual', kf_usuario = '$usuarioId', xt_ip = '$ip' WHERE kp_visitaID = $visitasID ";
	echo $consulta;
	$INTRANET->Execute($consulta);
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
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
    			<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <script type="text/javascript">
					function reCargarPadre(){
						opener.location.reload();
						window.close();
					}
				</script>
    		</head>
    <body>
    <?php
	echo "<script type='text/javascript'>reCargarPadre()</script>";
	//header("Location: TableroVisitas2.php?ciudad=$ciudad");
	
	
}
?>
</body>
</html>
<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio F. García Robles
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'cerrarAcuerdo.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$acuerdoID 		= $_GET['id'];
$claveAcuerdo 	= $INTRANET->getOne("SELECT xt_claveAcuerdo FROM SGI_Acuerdos WHERE kp_acuerdoID = $acuerdoID ");


if($_POST['confirma'] == ""){
	
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
		echo "<form method='POST' action='cerrarAcuerdo.php?id=$acuerdoID'>";
			echo "<table border='0' align='center'>";
				echo "<tr height='30'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td align='center' id='titulo1' colspan='2'>Cerrar Acuerdo</td>";
				echo "</tr>";
				
				echo "<tr height='40px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineTop' colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2' colspan='2'>¿Desea cerrar el acuerdo <b>".$claveAcuerdo."</b> ?</td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";
						
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";
				
				echo"<tr>";
					echo"<td valign='bottom' align='center'>";
						echo "<img src='../Imagenes/ICN_NoOK.png' width='29px' height='29px' onClick='window.close()'>";
					echo "</td>";
					
					echo "<td align='center'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='29px' height='29px'>";
						echo "<input type='hidden' name='confirma' value='OK'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>";
					echo"<td valign='bottom' align='center' id='iconosTexto'>";
						echo "Cancelar";
					echo "</td>";
					
					echo "<td align='center' id='iconosTexto'>";
						echo "Aceptar";
					echo"</td>";
				echo"</tr>";
				
				echo "<tr height='30px'><td colspan='2'></td></tr>";			
			echo "</table>";
			
		echo "</form>";
	echo "</div>";
	
} else if($_POST['confirma'] == "OK"){
	
	$horaCierre = date('Y-m-d H:i:s');
	
	$INTRANET->Execute("UPDATE SGI_Acuerdos SET xt_status = 'CERRADO', xd_fechaCierre = '$horaCierre', kf_usuarioID = '$usuarioId' WHERE kp_acuerdoID = $acuerdoID ");
		
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
	
}
?>
		</body>
	</html>
<?php

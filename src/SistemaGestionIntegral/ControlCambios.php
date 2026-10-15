<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'ControlCambios.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$modifica = 0;

if($_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}
//echo "$modifica<br>";

if(($modifica == 0) || ($_POST['descripcion'] == "") ){
	$itemID = $_GET['itemID'];
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Control de Cambios</title>
                 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            </head>
            <body>
    <?php
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='ControlCambios.php?itemID=$itemID'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Control de Cambios</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr>"; 
				echo"<td align='center'>";
					//echo "<font>$breadcrumb</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
		//TITULO ITEM
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Descripción</td>";
			echo "</tr>";
		//INPUT TITULO
			echo"<tr align='left'>";
				echo "<td  align='left' width='450px'>";
					echo "<textarea name='descripcion' style='width: 440px; height: 100px;'></textarea>";
					echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
				echo"</td>";
			echo "</tr>";
			echo"<tr height='10'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' width='450px'></td>";
			echo "</tr>";
			
			echo "<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
		
} else if(($modifica == 1) && ($_POST['descripcion'] != "")){
	
	$itemID = $_POST['itemID'];
	$descripcion = $_POST['descripcion'];
	
	$grupo = "";
	$area = "";
	$tipo = "";
	$consecutivo = 0;
	
	$s = $INTRANET->Execute("SELECT xt_grupo, xt_area, xt_tipo, xn_consecutivo FROM SGI_Item WHERE kp_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$grupo = $r[0];
		$area = $r[1];
		$tipo = $r[2];
		$consecutivo = $r[3];
		
	} unset($r);
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Control_Cambios WHERE kf_itemID = $itemID ");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
	}
	
	$maximo++;
	
	$usuario = $INTRANET->getOne("SELECT kp_personalId FROM SGI_Empleados WHERE kf_usuario = '$usuarioId' ");
	
	if($INTRANET->Execute("INSERT INTO SGI_Control_Cambios (kf_itemID, xn_numero, xd_fecha, xt_descripcion, kf_actorID) 
							VALUES ($itemID, $maximo, CURRENT_TIMESTAMP(), '$descripcion', $usuario) ")){

		header("Location: FichaItem.php?id=$itemID");
	}
	
}
?>
</body>
</html>
<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'firmarProceso.php';

require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <title>Firmar Proceso</title>
             <?php
			if($estiloUsuario == 1){
				echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
				echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            <script type="text/javascript">
                function reCargarPadre(){
                    opener.location.reload();
                    window.close();
                }
            </script>
        </head>
        <body>
<?php

$itemID			= $_GET['id'];
//$codigo 		= $_GET['codigo'];
$codigo = $INTRANET->getOne("SELECT xt_codigo FROM SGI_Item WHERE kp_itemID = '$itemID' ");

if($_GET['aceptar'] != ""){
	
	$aceptar 	= $_GET['aceptar'];
	
}

if($_GET['elemento'] != ""){
	
	$elemento = $_GET['elemento'];
	
}

@$ip		 	= getenv(REMOTE_ADDR);

///FORMULARIO PREGUNTA FIRMAR PROCESO
if(($codigo != "") && ($aceptar == "")){
	
	echo "<div id='wrapperPopUp'>";
		echo "<table border='0' align='center' width='450'>";
		
			echo"<tr>";
				echo"<td align='center' id='titulo1' width='450'>Firmar Proceso</td>";
			echo"</tr>";
			
			echo"<tr height='50'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop' width='450' colspan='2'></td>";
			echo "</tr>";
	
			echo"<tr height='15'><td colspan='2'></td></tr>";
			
			echo "<tr align='left' height='20'>";
				if($elemento == 'Documento'){
					echo "<td id='titulo18' align='center' colspan='2'>¿Desea firmar el Proceso <br><b>".$codigo."</b> ?</td>";
				} else if($elemento == 'Diagrama'){
					echo "<td id='titulo18' align='center' colspan='2'>¿Desea firmar el Diagrama de Flujo para <br><b>".$codigo."</b> ?</td>";
				}
			echo "</tr>";
			
			echo"<tr height='10'><td colspan='2'></td></tr>";
			
			echo"<tr>";
				echo"<td align='center' >";
					echo "<input type='image' onclick=\"window.close();\" src='../Imagenes/ICN_NoOK.png' width='40' height='40'>";
				echo"</td>";
				
				echo"<td align='center' >";
					if($elemento == 'Documento'){
						echo "<input type='image' onclick=\"location.href='firmarProceso.php?id=".$itemID."&elemento=Documento&aceptar=OK';\" src='../Imagenes/ICN_Certif.png' width='40' height='40'>";
					} else if($elemento == 'Diagrama'){
						echo "<input type='image' onclick=\"location.href='firmarProceso.php?id=".$itemID."&elemento=Diagrama&aceptar=OK';\" src='../Imagenes/ICN_Certif.png' width='40' height='40'>";
					}
				echo"</td>";
			echo "</tr>";
			
			echo"<tr height='30'><td colspan='2'></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineTop'colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='40'><td colspan='2'></td></tr>";
		echo "</table>";
	echo "</div>";

///FIRMAR PROCESO
} else if(($codigo != "") && ($aceptar == 'OK')){
	
	
	if($INTRANET->Execute("INSERT INTO SGI_Procesos_Firmas (kf_itemID, kf_usuario, xt_ip) VALUES ($itemID, '$usuarioId', '$ip') ")){
		
		if($elemento == 'Documento'){
			$descripcion = "Se validó Proceso por el responsable.";
		} else if($elemento == 'Diagrama'){
			$descripcion = "Se validó Diagrama de Flujo por el responsable.";
		}
				
		$maximo = 0;
		
		$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Control_Cambios WHERE kf_itemID = $itemID ");
		
		while($r = $s->fetchRow()){
			$maximo = $r[0];
		}
		
		$maximo++;
		
		$firmaAutorizada = $INTRANET->getOne("SELECT SGE.kp_personalId FROM SGI_Empleados SGE WHERE SGE.kf_usuario = '$usuarioId' ");
		
		
		if($INTRANET->Execute("INSERT INTO SGI_Control_Cambios (kf_itemID, xn_numero, xt_descripcion, kf_actorID) 
								VALUES ($itemID, $maximo, '$descripcion', $firmaAutorizada) ")){
	
			echo "<script type='text/javascript'>reCargarPadre()</script>";
		} else{
		
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error: No se firmo el proceso</font>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
				
			echo "</div>";
		}
		
	///NO SE AGREGO CORRECTAMENTE LA DESCRIPCION
	} else{
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se firmo el proceso</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
	}
	
}

?>
</body>
</html>
<?php

$nombrephp = 'ControlCambios.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

 error_reporting(E_PARSE);

$modifica = 0;

if($_POST['modifica'] != (NULL || '')){
	$modifica = 1;
}
//echo "$modifica<br>";

if(($modifica == 0) || ($_POST['descripcion'] == "") ){
	$codDoc = $_GET['codDoc'];
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Control de Cambios</title>
                 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
            </head>
            <body>
    <?php
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='controlCambiosv3_modify.php?codDoc=$codDoc'>";	
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
					echo "<input type='hidden' value='$codDoc' name='codDoc'><input type='hidden' value='1' name='modifica'>";
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
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10'> </tr>";
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
		
} else if(($modifica == 1) && ($_POST['descripcion'] != "")){
$cod = $_POST['codDoc'];
$cod = substr($cod, 0, 1);

	if ($cod == 'K') {
		
	 $codPro = $_POST['codDoc'];
	 $descripcion = $_POST['descripcion'];
	
	$maximo = 0;
	$maximo = $INTRANETV2->getOne("select COUNT(xn_version) from SGI_Control_Cambios_Procesos where xt_codigoProceso = '$codPro'");
	$maximo = $maximo + 1;
	
	$usuarioId;
	
	$INTRANETV2->Execute("INSERT INTO SGI_Control_Cambios_Procesos (xt_codigoProceso, xt_descripcion, xt_inicialesUsuario, xn_version) 
							VALUES ('$codPro', '$descripcion', '$usuarioId', $maximo)");

	?><script type="text/javascript">
		window.opener.location.reload();
		window.close();
	</script><?php

	}elseif ($cod == 'A') {
		
	 $codAct = $_POST['codDoc'];
	 $descripcion = $_POST['descripcion'];
	
	$maximo = 0;
	$maximo = $INTRANETV2->getOne("select COUNT(xn_version) from SGI_Control_Cambios_Actividades where xt_codigoActividad = '$codAct'");
	$maximo = $maximo + 1;
	
	$usuarioId;
	
	$INTRANETV2->Execute("INSERT INTO SGI_Control_Cambios_Actividades (xt_codigoActividad, xt_descripcion, xt_inicialesUsuario, xn_version) 
							VALUES ('$codAct', '$descripcion', '$usuarioId', $maximo)");

	?><script type="text/javascript">
		window.opener.location.reload();
		window.close();
	</script><?php

	}elseif ($cod == 'F') {
		
	 $codFun = $_POST['codDoc'];
	 $descripcion = $_POST['descripcion'];
	
	$maximo = 0;
	$maximo = $INTRANETV2->getOne("select COUNT(xn_version) from SGI_Control_Cambios_Funcionalidades where xt_codigoFuncionalidad = '$codFun'");
	$maximo = $maximo + 1;
	
	$usuarioId;
	
	$INTRANETV2->Execute("INSERT INTO SGI_Control_Cambios_Funcionalidades (xt_codigoFuncionalidad, xt_descripcion, xt_inicialesUsuario, xn_version) 
							VALUES ('$codFun', '$descripcion', '$usuarioId', $maximo)");

	?><script type="text/javascript">
		window.opener.location.reload();
		window.close();
	</script><?php

	}else{
	 $codDco = $_POST['codDoc'];
	 $descripcion = $_POST['descripcion'];
	
	$maximo = 0;
	$maximo = $INTRANETV2->getOne("select COUNT(xn_version) from INTRANET2.SGI_Control_De_Cambios_Documentos where xt_codigoDocumento = '$codDco'");
	$maximo = $maximo + 1;
	
	$usuarioId;
	
	$INTRANETV2->Execute("INSERT INTO INTRANET2.SGI_Control_De_Cambios_Documentos (xt_codigoDocumento, xt_descripcion, xt_inicialesUsuario, xn_version) 
							VALUES ('$codDco', '$descripcion', '$usuarioId', $maximo)");
		?><script type="text/javascript">
		window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaDocumentov3.php?id=<?php echo $codDco; ?>";
	</script><?php 
}
	?>
	

	
	<?php
}
	

?>
</body>
</html>
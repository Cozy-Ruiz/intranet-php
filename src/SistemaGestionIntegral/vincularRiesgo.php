<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio Francisco García Robles
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='vincularRiesgo.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$accion = "";

if($_POST["accion"] != ""){
	$accion = $_POST["accion"];
	
}else if($_GET["accion"] != ""){
	$accion = $_GET["accion"];
	
}

$itemID = "";

if($_POST["id"] != ""){
	$itemID = $_POST["id"];
	
}else if($_GET["id"] != ""){
	$itemID = $_GET["id"];
	
}

$nElemento = "";

if($_POST["nElemento"] != ""){
	$nElemento = $_POST["nElemento"];
	
}else if($_GET["nElemento"] != ""){
	$nElemento = $_GET["nElemento"];
	
}

if($accion == ""){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Vincular Riesgo</title>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
        
	echo "<div id='wrapperPopUp'>";
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Vincular Riesgo";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='30'> </tr>";
		echo "</table>";
		//CUERPO FICHA ALTA
	
		echo "<table border='0' align='center' width='400'>";
				
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
	
			echo"<tr height='40px'> </tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<input type='image' onclick=\"location.href='vincularRiesgo.php?id=$itemID&accion=vincular&nElemento=$nElemento';\" src='../Imagenes/ICN_BotonVincular.png' width='120' height='39'>";
				echo"</td>";
			echo "</tr>";
			
			echo"<tr height='40px'> </tr>";
			
			echo"<tr>";
				echo"<td valign='bottom' align='center' >";
					echo "<input type='image' onclick=\"location.href='vincularRiesgo.php?id=$itemID&accion=generar&nElemento=$nElemento';\" src='../Imagenes/ICN_BotonGenerar.png' width='120' height='39'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='40'> </tr>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo "<tr height='30'></tr>";
		echo "</table>";
	echo "</div>";
}

//VINCULAR
if(($accion == "vincular") && ($_POST['codigo'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Vincular Riesgo</title>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
	
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='altaSolicitudQueja' method='POST' action='vincularRiesgo.php?id=$itemID&nElemento=$nElemento'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Vincular Riesgo</font>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='30'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='400'>";
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
			echo "</tr>";
	
			echo"<tr height='30px'></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2'>Código:</td>";
			echo "</tr>";
				
			echo"<tr height='5'></tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "<input type='text' name='codigo' size='50'><input type='hidden'  name='accion' value= 'vincular'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' >";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right' ></td>";
			echo "</tr>";
					
		echo "</table>";
		
		echo "</form>";
	echo "</div>";

} else if(($accion == "vincular") && ($_POST['codigo'] != "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Vincular Riesgo</title>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
	
	
	$codigo = $_POST['codigo'];
	$idRiesgo = $INTRANET->getOne("SELECT kp_riesgoId FROM SGI_Riesgos WHERE xt_codigoRiesgo = '$codigo' ");
		
	if($INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_docCodigo = '$idRiesgo', xt_tipo = 'RIESGO' WHERE kf_itemID = $itemID AND xn_numeroMapa = 10 AND xn_numeroElemento = $nElemento ")){
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
		
	} else{
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Error: No se vinculó el riesgo</font>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
		echo "</div>";
		
	}
}

//GENERAR
if(($accion == "generar")){
	header("Location: altaRiesgoPopUp.php?procesoId=$itemID&nElemento=$nElemento");
}
?>
</body>
</html>
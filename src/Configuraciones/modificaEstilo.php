<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
//$nombrephp = 'modificaEstilo.php';
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$confirma = $_POST['confirma'];

if($confirma == ""){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Modifica Estilo</title>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                <script type="text/javascript">
					function redireccionar(){
						opener.location.href="https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php";
						window.close();
					};
                </script>
            </head>
            
            <body>
    <?php
	echo "<div id='wrapperPopUp'>";
		echo "<form method='POST' action='modificaEstilo.php'>";
		
			echo "<table border='0' align='center' width='450px'>";
					
				echo"<tr height='30'><td colspan='2'> </td></tr>";
				$estiloActual = $MASTER_GE->getOne("SELECT xn_estilo FROM PERFILES.USUARIOS WHERE xt_usuario = '$sesionUsuario' ");
				if($estiloActual == 1){
					$color = "gris";
				}else if($estiloActual == 2){
					$color = "negro";
				}
				echo"<tr >";
					echo"<td align='center' id='titulo2Blanco' colspan='2'>";
						echo "</i>¿Esta seguro de cambiar su estilo a color ".$color." ?</i>";
						echo "<input type='hidden' name='confirma' value='OK'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='20'><td colspan='2'> </td></tr>";
				
				echo"<tr>";
					echo"<td align='center' width='225px'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_Certif.png' width='50' height='40'>";
					echo"</td>";
					
					echo"<td align='center' width='225px'>";
						echo "<input type='image' onClick='window.close()' src='../Imagenes/ICN_NoOK.png' width='50' height='40'>";
					echo"</td>";
				echo"</tr>";
				
			echo"</table>";
		echo "</form>";
	echo "</div>";
	
} else if($confirma == 'OK'){
	
	$estiloActual = $MASTER_GE->getOne("SELECT xn_estilo FROM PERFILES.USUARIOS WHERE xt_usuario = '$sesionUsuario' ");
	
	if($estiloActual == 1){
		$MASTER_GE->Execute("UPDATE PERFILES.USUARIOS SET xn_estilo = 2 WHERE xt_usuario = '$sesionUsuario'");
		$_SESSION["estilo"] = 2;
		
	}else if($estiloActual == 2){
		$MASTER_GE->Execute("UPDATE PERFILES.USUARIOS SET xn_estilo = 1 WHERE xt_usuario = '$sesionUsuario'");
		$_SESSION["estilo"] = 1;
	}
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Modifica Estilo</title>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                <script type="text/javascript">
					function redireccionar(){
						opener.location.href="https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php";
						window.close();
					};
                </script>
            </head>
            
            <body>
    <?php
	
	//header("Location: TableroVisitas2.php");
		
	echo "<script type='text/javascript'>redireccionar()</script>";	
	
}

?>
        </body>
    </html>
<?php

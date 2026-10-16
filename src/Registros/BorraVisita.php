<?php error_reporting(0); ?>
<?php
$nombrephp = 'BorraVisita.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

//error_reporting(0);

$confirma = isset($_POST['confirma']);
$idVisita = $_GET['id'];
$ciudad	  = $_GET['cd'];

if($confirma == ""){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Borra Visita</title>
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
						opener.location.href="TableroVisitas2.php";
						window.close();
					};
                </script>
            </head>
            
            <body>
    <?php
	echo "<div id='wrapperPopUp'>";
		echo "<form method='POST' action='BorraVisita.php?id=$idVisita&cd=$ciudad'>";
		
			echo "<table border='0' align='center' width='450px'>";
					
				echo"<tr height='30'><td colspan='2'> </td></tr>";
				
				echo"<tr >";
					echo"<td align='center' id='titulo2Blanco' colspan='2'>";
						echo "</i>¿Esta seguro que desea borrar el registro?</i>";
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
	
	$consultaCiudad = "DELETE FROM SGI_Visitas" ;
	
	if($ciudad != 'DF' AND $ciudad != 'CMX' ){
		$consultaCiudad = $consultaCiudad."_".$ciudad;
	}
	
	$consultaCiudad = $consultaCiudad." WHERE kp_VisitaID = $idVisita ";
	
	$INTRANET->Execute($consultaCiudad);
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8">
                <title>Borra Visita</title>
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
						opener.location.href="TableroVisitas2.php";
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

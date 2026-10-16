<?php error_reporting(0); ?>
<?php

$nombrephp = 'tableroRoles.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require_once("../ConexionIntranet2.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
			<title>Tablero de Inventario de Roles</title>
			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
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

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='Procesos.php' id='breadcrumbs'> Inventario de procesos </a>";

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
				echo "<font>Inventario de Roles</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
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
				echo "<td align='left' width='685px' id='titulo2'>Listado de Roles</td>";
					echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
					echo "<a href='AgregarNuevoRol.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";	
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
	
	echo "<table border='0' cellspacing='0'>";	
	
		//listo los procesos
		$indexRoles = 0;
		
		$listRoles = $INTRANETV2->execute("SELECT xt_nombre, xt_codigo FROM SGI_Catalogo_Roles ORDER BY xt_codigo ASC");

        	while($r = $listRoles->FetchRow()){
            	$nomRol[$indexRoles] = $r[0];
				$codRol[$indexRoles] = $r[1];
                $indexRoles++;
             }
		
		
		for($i = 0; $i < count($nomRol); $i++){
			echo "<tr>";
			
				echo "<td align='left' width='200px' height='40px' id='manualVinculo' style='padding: 0px 0px 0px 40px'> $codRol[$i]</td>";
				echo "<td align='left' width='685px' height='40px' id='manualVinculo' style='padding: 0px 0px 0px 40px'> $nomRol[$i]</td>";
			echo "</tr>";
			
			
			
			
		
		}
	echo"</table>";

echo "</div>";
?>

</body>
</html>
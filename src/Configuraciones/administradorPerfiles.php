<?php
$nombrephp = 'AdministradorPerfiles.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
		<title>Administrador de Perfiles</title>
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
    </head>
    <body>
<?php

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='configuraciones.php' id='breadcrumbs'> Configuraciones</a> ";

echo "<div id='wrapper' align='center'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "<font>Administrador de Perfiles</font>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>"; 
			echo "<td align='center' valign='top' height='20px'>";
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
			echo "</td>";
		echo "</tr>";

	echo "</table>";
			//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
				include("../navegacion_banana.php");
			echo "</table>";
			
			echo "</td>";
		echo "</tr>";
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo "<tr height='100'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' name='cuerpo'>";
	
		echo "<tr>";
			echo "<td colspan='4' width='600' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='20'> </tr>";
	
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nueva Categoria PHP ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaNuevaCategoriaPHP.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nuevo PHP ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaNuevoPHP.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nueva Categoria Usuario PHP ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaNuevaCategoriaUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
			echo "Nuevo Usuario ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaNuevoUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=680,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Modifica Perfil ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='modificaPerfilUsuario.php?administra=true'><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Ciudad ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='modificaCiudad.php?administra=true'><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='20'> </tr>";
		
		echo "<tr>";
			echo "<td colspan='4' width='600' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
	
	echo "</table>";


echo "</div>";


?>
</body>
</html>
<?php

$nombrephp = 'TableroBoletines.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
require_once("../../Consultas/ConsutasGlobales.php");
$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna </a>";

$indice = 1;
$fecha 			= NULL;
$titulo 		= NULL;
$claveBoletin 	= NULL;
$anio= date("Y");;
$ciudad="Todas";
if (isset($_POST['anio'])) {
 	 $anio=$_POST['anio'];
 }

 if (isset($_POST['ciudad'])) {
 	 $ciudad=$_POST['ciudad'];
 }
//declaro un arreglo con los usuarios autorizados para realizar cambios o agregar nuevos boletines
$adminArray = Array('Alicia_Merino','Gerente_Sistemas','cozy','Daniel_Guadarrama','sdelap',
				'Pedro_Moyotl','Christian_Martinez','Ricardo_Garcia','Gerardo_Nunez','Manuel_Escalante','Jorge_Doring','Denisse_Valladares','Adlemy_Tah','Cindy_Fuentes', 'Byron_Lopez','Stefany_Nieto','Dalia_Mosqueda','Eibar_Ponce','Gameva_Martinez','Saday_Hernandez','Jernesto_Rodriguez', 'Lenin_Lopez', 'Barbara_Cortes');

if($anio==0 and $ciudad=="Todas" ){
	$query="SELECT xt_claveBoletin, xd_fecha, xt_titulo , C.xt_descripcion FROM SGI_Boletines B, IntranetGEA.IntranetGEA_CATALOGO_OFICINA C where B.xt_ciudad=C.xt_oficina
ORDER BY  C.xt_descripcion,xd_fecha DESC";  

}

else if($anio>0 and $ciudad=="Todas" ){
$query="SELECT xt_claveBoletin, xd_fecha, xt_titulo , C.xt_descripcion FROM SGI_Boletines B, IntranetGEA.IntranetGEA_CATALOGO_OFICINA C where B.xt_ciudad=C.xt_oficina AND YEAR(xd_fecha) = $anio ORDER BY C.xt_descripcion, xd_fecha    DESC";
	}

	else if($anio==0 and $ciudad!="Todas" ){
		 
$query="SELECT xt_claveBoletin, xd_fecha, xt_titulo , C.xt_descripcion FROM SGI_Boletines B, IntranetGEA.IntranetGEA_CATALOGO_OFICINA C where B.xt_ciudad=C.xt_oficina AND xt_ciudad = '$ciudad'  ORDER BY C.xt_descripcion, xd_fecha DESC";
	}

	else if($anio>0 and $ciudad!="Todas" ){
		 
$query="SELECT xt_claveBoletin, xd_fecha, xt_titulo , C.xt_descripcion FROM SGI_Boletines B, IntranetGEA.IntranetGEA_CATALOGO_OFICINA C where B.xt_ciudad=C.xt_oficina AND xt_ciudad = '$ciudad' AND YEAR(xd_fecha) = $anio  ORDER BY C.xt_descripcion, xd_fecha DESC";
	}
  //echo "$query";
$s = $INTRANETV2->Execute($query);

while($r = $s->fetchRow()){
	$claveBoletin[$indice] 	= $r[0];
	$fecha[$indice] 		= date('Y-m-d', strtotime($r[1]));
	$titulo[$indice] 		= $r[2];
	$ciudadE[$indice] = $r[3];
	//$claveBoletin[$indice] 	= $r[3];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <title>Boletines</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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

				function show(valor){
        if(valor == 1){
            document.getElementById("mostrar").style.display="table";
            document.getElementById("ocultar").style.display="none";
        } else if (valor == 0){
            document.getElementById("mostrar").style.display="none";
            document.getElementById("ocultar").style.display="table";
        }
    }



			</script>
        </head>
        <body>
<?php

echo "<div id='wrapper'>";
  echo "<form name='TableroBoletinesv2' method='post' action='TableroBoletinesv2.php'>";	
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='80px'> </tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Boletines";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>"; 
		echo"</tr>";
		
		//echo "<tr height='70'><td></td></tr>";
	echo "</table>";
	
	  
				echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../../navegacion_banana.php");
				echo "</table>";
			echo "</td>";
		echo "</tr> ";

		echo "<table id='ocultar'  align='center'><tr>  <td align='center' id='iconosTexto2' onclick='show(1);' width='100%' style='cursor: pointer;'>Filtro</td> </tr> </table>";
		
	echo " <table id='mostrar' style='display:none;' border='0' align='center'>  
			<tr><td align='center' id='titulo2'>Ciudad:</td><td align='center' id='titulo2'>Año:</td></tr>
	  ";

		echo"<tr height='10'>";
		echo " <td>";  opcionesCiudades(); echo  "  </td>";
		echo " <td>";  opcionesanio(); echo  "  </td>";



		 echo  "</tr>";
	echo '	<tr><td> <input type="image" onclick="SubmitForm(this.form);" src="../../../Imagenes/ICN_BotonEnviar.png" width="80px" height="20"> </td></tr>';
	echo "</table>  <br>"; 



	
	
	if(count($claveBoletin) >= 1){


		
		echo "<table align='center' border='0' width='700px'>";
		$eltitulo="";
			for($a = 1; $a <= count($claveBoletin); $a++){


				if($a == 1){
					echo "<tr align='center' id='titulo2' height='10px'><td colspan='5'>$ciudadE[$a]<br></td></tr>";	
						echo "<tr id='titulo2'>";
							echo "<td align='center' width='130px'>Código</td>";
							echo "<td align='center' width='10px'></td>";
							echo "<td align='left' width='450px'>Título</td>";
							echo "<td align='center' width='100px'>Fecha</td>";
							echo "<td align='right' width='10px'>";
				
								if(in_array($usuarioId, $adminArray)){
									echo "<a href='AgregaBoletinv2.php'>";
										echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px'>";
									echo "</a>";
								 }
								 
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='5' id='titleBlueLineTop'></td>";
						echo "</tr>";
						
						

						$eltitulo=$ciudadE[$a];
					 }
	
				if($ciudadE[$a]!=$eltitulo)
				{
					echo "<tr align='center' id='titulo2' height='10px'><td colspan='5'>$ciudadE[$a]<br></td></tr>";	
							echo "<td align='center' width='130px'>Código</td>";
							echo "<td align='center' width='10px'></td>";
							echo "<td align='left' width='450px'>Título</td>";
							echo "<td align='center' width='100px'>Fecha</td>";
							echo "<td align='right' width='10px'>";
				
								if(in_array($usuarioId, $adminArray)){
									echo "<a href='AgregaBoletinv2.php'>";
										echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px'>";
									echo "</a>";
								 }
								 
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='5' id='titleBlueLineTop'></td>";
						echo "</tr>";
						
						 

						$eltitulo=$ciudadE[$a];
				}
				echo "<tr height='25' id='iconosTexto' valign='top'>";
					echo "<td width='130px' align='center' id='iconosTexto'>";
						echo "<a href='fichaBoletinv2.php?id=".$claveBoletin[$a]."' id='iconosTexto' style='text-decoration:none;'>".$claveBoletin[$a]."</a>";
					echo "</td>";
					
					echo "<td align='center' width='10px'></td>";
					echo "<td width='450px' align='left' valign='top'>".$titulo[$a]."</td>";
			
					echo "<td width='100px' align='center' valign='top'>".$fecha[$a]."</td>";
					
					echo "<td width='10px' align='right'></td>";
				echo "</tr>";
				
			} unset($a);
		
		echo "</table>";
		
	} else{
		
		echo "<table align='center' border='0' width='700px'>";
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td width='700px' id='iconosTexto'><i>No hay Boletines que mostrar.</i>";
				echo "<td align='right' width='10px'>";
				if(in_array($usuarioId, $adminArray)){
					echo "<a href='AgregaBoletinv2.php'>";
						echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px'>";
					echo "</a>";
				 }
			echo"</td>";
			echo"</td>";
			echo "</tr>";

			
			
			echo "<tr height='20px'><td></td></tr>";
		echo"</table>";
	}
	
	echo "<table align='center' border='0' width='700px'>";
		echo "<tr height='10'><td></td></tr>";
		
		echo "<tr>";
			echo "<td width='700px' id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo"</table>";
  	echo "</form>";
echo "</div>";

?>
    	</body>
    </html>
<?php 

<?php error_reporting(0); ?>
<?php
$nombrephp = 'TableroVisitas2.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

require_once("../Consultas/ConsutasGlobales.php");
error_reporting(E_PARSE);

//header("Refresh: 60; URL='TableroVisitas2.php'");
//error_reporting(0);
?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="refresh" content="180" >
<meta charset="utf-8" />
<title>Tablero Visitas</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
<script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript">;
$(function(){
	$(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
	 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
	 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
	
	 });
});
</script>

 <script>
	function show(valor){
		if(valor == 1){
			document.getElementById("mostrar").style.display="block";
			document.getElementById("ocultar").style.display="none";
		} else if (valor == 0){
			document.getElementById("mostrar").style.display="none";
			document.getElementById("ocultar").style.display="block";
		}
	}
</script> 

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

$c = $INTRANET->Query("SELECT DISTINCT
                          CASE U.xt_codigoCiudad WHEN 'CMX' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
                          CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de México' ELSE O.xt_descripcion END as codigo
                        FROM
                          IntranetGEA.IntranetGEA_Usuarios_Oficina U,
                          IntranetGEA.IntranetGEA_CATALOGO_OFICINA O
                        WHERE
                          O.xt_oficina = U.xt_codigoCiudad");
      $i=1;
    while($city = $c->fetchRow()){
            $cdValor [$i]= $city[0];
            $ciudades[$i]  = $city[1];
            $i++;
        }


$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");
$ciudadesDisponibles = NULL;
$indice = 1;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad DESC");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='Registros.php' id='breadcrumbs'> Registros</a> ";

$fecha = $_POST['fecha']; 
$hoy = date("Y-m-d");
	
$ciudadDefault= $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");


if($_POST['ciudad'] !=""){
	$ciudadFiltro = $_POST['ciudad'];
}else if($_GET['ciudad'] !=""){
	$ciudadFiltro = $_GET['ciudad'];
}else{

	$ciudadFiltro = $ciudadDefault;
}
if($ciudadFiltro=="DF")
{
	$ciudadFiltro="CMX";
}  

for($o=1;$o<=10;$o++){

	if($cdValor[$o] == $ciudadFiltro){

		$imprimeCiudad = $ciudades[$o];

	}
}

echo "<div id='wrapperVisitas'>";

  echo "<form name='tableroVisitas' method='post' action='TableroVisitas2.php'>";

	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr height='30'> </tr>";
		
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Tablero de Visitas</font>";
			echo"</td>";
		echo"</tr>";
		if($categoriaUsr == "Administrador"){
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>".$imprimeCiudad."</font>";
				echo"</td>";
			echo"</tr>";
		}
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
			
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
echo "Categoria: ".$categoriaUsr;
// CASO ADMINISTRADOR
if($categoriaUsr == "Administrador"){
		echo "<table border='0' align='center' id='ocultar' style='display:block;'>";
			echo"<tr>";
				echo"<td align='left' id='iconosTexto2' onClick='show(1);'>Ciudad</td>";
			echo"</tr>";
		echo"</table>";
	//echo"$ciudadFiltro,$ciudadDefault,$fecha";
	///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='1150' id='mostrar' style='display:none;'>";
			echo"<tr>";
				echo"<td colspan='2' align='left' id='iconosTexto2' onClick='show(0);'> Ciudad </td>";
			echo"</tr>";
	
			echo "<tr>";
				echo "<td id='breadcrumbs' valign='top' width='50'>";
			///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
				 opcionesCiudades();
				echo"</td>";
				
				echo"<td align='left' width='1100'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='80' height='20'> </td>";
			echo"</tr>";
			
			echo"<tr height='15'></tr>";
				 
		echo"</table>";// FIN DEL FILTRO POR CIUDAD
	
	//DESPLIEGUE DE INFORMACION
	echo "<table border='0' align='center' width='1100' >";
		
		echo"<tr height='20'> </tr>";
		
		echo"<tr height='23'>";
			echo"<td align='left' width='35' id='breadcrumbs'>Fecha: </td>";
			if ($fecha !=""){
				echo"<td align='left' width='100'><input type='text' name='fecha' class='DatP' size='15' style='height:10px;' value='$fecha'> </td>";
			}else{
				//$fecha=$hoy;
				echo"<td align='left' width='100'><input type='text' name='fecha' class='DatP' size='15' style='height:10px;' value='$hoy'> </td>";
			}
			
			//$s= $INTRANET->Execute("SELECT kf_usuario FROM SGI_Usuario_Registro_Ciudad WHERE xt");
			
			echo"<td align='left' width='15'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_CalendarioPopUp.png' height='15' width='15'> </td>";
			
			if (
				($usuarioId == 'Eibar_PonceA') 
				|| ($usuarioId == 'Ricardo_GarciaA')
				|| ($usuarioId == 'Saday_Hernandez') 
				|| ($usuarioId == 'Alberto_Martinez')
				|| ($usuarioId == 'sdelap') 
				|| ($usuarioId == 'Jernesto_Rodriguez')
				|| ($usuarioId == 'Norma_Tapia')
				|| ($usuarioId == 'Itzel_Perez') 
				|| ($usuarioId == 'Fulgencio_Duran') 
				|| ($usuarioId == 'Eliane_Malpica') 
				|| ($usuarioId == 'Ruben_Solis') 
				|| ($usuarioId == 'Javier_Rosas') 
				|| ($usuarioId == 'Alfonso_Santiago') 
				|| ($usuarioId == 'Gustavo_Gracia') 
				|| ($usuarioId == 'Eduardo_Hernandez')
				|| ($usuarioId == 'Ana_Vargas')
				|| ($usuarioId == 'Erika_Muñoz')
				|| ($usuarioId == 'Karina_Vega')
				|| ($usuarioId == 'Carlos_Jimenez')
				|| ($usuarioId == 'Maria_Garcia')
				|| ($usuarioId == 'Fernanda_Orduña')
				|| ($usuarioId == 'Rafael_Moral')
				|| ($usuarioId == 'Wendy_Palmeros')
				|| ($usuarioId == 'Stefany_Nieto') 
				|| ($usuarioId == 'Christian_Martinez') 
				|| ($usuarioId == 'Priscilla_Romero')
				|| ($usuarioId == 'Veronica_Fernandez')
				|| ($usuarioId == 'Magda_Gonzalez')
				|| ($usuarioId == 'Esmeralda_Gomez') 
				|| ($usuarioId == 'Dalia_Mosqueda')
				|| ($usuarioId == 'Adlemy_Tah') 
				|| ($usuarioId == 'Gameva_Martinez')
				|| ($usuarioId == 'DENNISE_VAZQUEZ')
				|| ($usuarioId == 'Luz_Arguelles')
				|| ($usuarioId == 'Maria_Toledo')
				|| ($usuarioId == 'cozy')
				|| ($usuarioId == 'Barbara_Cortes')
				|| ($usuarioId == 'Pamela_Martinez')
				|| ($usuarioId == 'Alicia_Merino')
				){
					if ($_SESSION["autentificado"] != "SI") {
					    echo "<td width='330'></td><td align='left' width='620'><a href='#' onclick='location.reload(false);'> 
						<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'> </a></td>";
						// header("Location: https://escalante.com.mx/Sistemas/");
						// exit();
					}
					if($_SESSION["autentificado"] == "SI"){
				echo "<td width='330'></td><td align='left' width='620'><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Registros/altaVisitaPopUp3.php?cd=$ciudadFiltro' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=700,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'> </a></td>";
					}
			}

			if (
				($usuarioId == 'Eibar_Ponce') 
				|| ($usuarioId == 'Ricardo_Garcia')
				|| ($usuarioId == 'Elena_Hernandez') 

			)
			{
				echo "<td width='330'></td><td align='left' width='620'><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Registros/altaVisitaPopUp3.php?cd=$ciudadFiltro' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=700,scrollbars=yes')\"> 
						<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'> </a></td>";
			}
		echo"</tr>";
		
		echo"<tr height='20'> </tr>";
		
	echo "</table>";
		
	echo "<table border='0' align='center' >";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr id='titulo2'>";
			echo"<td align='left' width='80'>Gafete</td>";
			//echo"<td align='left' width='80'>Tipo</td>";
			echo"<td align='left' width='260'>Nombre</td>";
			echo"<td align='left' width='230'>Empresa</td>";
			echo"<td align='left' width='260'>Responsable</td>";
			echo"<td align='left' width='100'>Entrada</td>";
			echo"<td align='left' width='100'>Salida</td>";

				echo"<td align='right' width='20'></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td colspan='7' width='1130' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'> </tr>";	
		
	echo "</table>";

	echo"<table align='center' border='0'>";

	
	//echo "Fecha: ".$fecha;
	if ($fecha == ""){
	
		//echo "ciudad filtro: ".$ciudadFiltro;
		if($ciudadFiltro != ""){ 
			//echo "No esta vacio filtro";
			$consultaCiudad="
				SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida, 
				E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita 
				FROM SGI_Visitas" ;
				
				if($ciudadFiltro != 'CMX' && $ciudadFiltro != 'DF' && $ciudadFiltro != 'CDMX' && $ciudadFiltro != 'ALL'){
					//echo "Concateno filtro";
					$consultaCiudad=$consultaCiudad."_".$ciudadFiltro;
				}
				$consultaCiudad=$consultaCiudad." V, SGI_Empleados E WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$hoy' ORDER BY xd_fecha,xt_horaEntrada DESC";
				//echo $consultaCiudad;
				$s = $INTRANET->Execute($consultaCiudad);

		}else{
				
			$consultaCiudad="
				SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida, 
				E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita 
				FROM SGI_Visitas" ;

				if($ciudadFiltro != 'CMX' && $ciudadFiltro != 'DF' && $ciudadFiltro != 'CDMX' && $ciudadFiltro != 'ALL'){
					$consultaCiudad=$consultaCiudad."_".$ciudadDefault;
					
				}
				$consultaCiudad=$consultaCiudad." V, SGI_Empleados E WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$hoy' ORDER BY xd_fecha,xt_horaEntrada DESC";
				//echo $consultaCiudad;
				$s = $INTRANET->Execute($consultaCiudad);
		}
		while($r = $s->fetchRow($s)){
			$salida ="". $r[7];

				echo "<tr height='25' id='iconosTexto'>";				
					
					echo "<td width='80' align='left'>";
						echo"<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'> $r[1] </a>";
					echo "</td>";
					
					echo "<td width='80' align='left'>";
						if($r[12] == "P"){
							echo"Proveedor";
						} else if($r[12] == "C"){
							echo"Cliente";
						} else if($r[12] == "V"){
							echo"VIP";
						} else if($r[12] == "A"){
							echo"Autoridad";
						}
						
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						echo "<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'>$r[2] $r[3] $r[4]</a>";
					echo "</td>";
					
					echo "<td width='230' align='left'>";
						echo "$r[11]";
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						$visitante = $r[2].$r[3].$r[4];
						$visitado = $r[8].$r[9].$r[10];
						if($visitante != $visitado){
							echo "$r[8] $r[9] $r[10]";
						}
					echo "</td>";
					
					echo "<td width='100' align='center'>";
						echo date('H:i',strtotime($r[6]));
					echo "</td>";
					if($salida != ""){
						echo "<td width='100' align='left'>".date('H:i',strtotime($salida))."</td>";
						
					}else if($salida == (NULL)){
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')|| ($usuarioId == 'Norma_Tapia') ||($usuarioId == 'Alberto_Martinez') ||($usuarioId == 'Maria_Garcia')|| ($usuarioId == 'Eliane_Malpica') ||($usuarioId == 'sdelap') ||($usuarioId == 'Norma_Tapia') ||($usuarioId == 'Itzel_Perez') || ($usuarioId == 'Javier_Rosas')|| ($usuarioId == 'Fulgencio_Duran') || ($usuarioId == 'Ruperto_Vicencio')|| ($usuarioId == 'Ruben_Solis') ||($usuarioId == 'Alfonso_Santiago') || ($usuarioId == 'Gustavo_Gracia')|| ($usuarioId == 'Eduardo_Hernandez')||($usuarioId == 'Ana_Vargas')||($usuarioId == 'Erika_Muñoz')||($usuarioId == 'DENNISE_VAZQUEZ')||($usuarioId == 'Karina_Vega')||($usuarioId == 'Carlos_Jimenez')||($usuarioId == 'Fernanda_Orduña')||($usuarioId == 'Rafael_Moral')||($usuarioId == 'Stefany_Nieto')||($usuarioId == 'Wendy_Palmeros')||($usuarioId == 'Christian_Martinez') ||($usuarioId == 'Jernesto_Rodriguez') ||($usuarioId == 'Priscilla_Romero')||($usuarioId == 'Veronica_Fernandez')||($usuarioId == 'Magda_Gonzalez')||($usuarioId == 'Esmeralda_Gomez')||($usuarioId == 'Dalia_Mosqueda')||($usuarioId == 'Adlemy_Tah')||($usuarioId == 'Saday_Hernandez') || ($usuarioId == 'Luz_Arguelles')
						|| ($usuarioId == 'Maria_Toledo')|| ($usuarioId == 'Pamela_Martinez')){
							echo "<td width='100' align='left'> <a href='updateSalida.php?id=$r[0]&cd=$ciudadFiltro' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=500,scrollbars=yes')\"> 
									<img src='../Imagenes/ICN_Boton_Azul.png'></a>
								</td>";
						}else {
							echo "<td width='100' align='left'></td>";
						}
					}
					
					echo "<td width='20' align='right'>";
					echo "</td>";
				echo "</tr>";
			
			echo"</td></tr>";
		}
	}else if ($fecha != ""){
		 if($ciudadFiltro=="Todas ")
		 {
		 	$ciudadFiltro="";
		 }
		if($ciudadFiltro !=""){

			$consultaCiudad="
				SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida, 
				E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita 
				FROM SGI_Visitas" ;

				if($ciudadFiltro != 'CMX' && $ciudadFiltro != 'DF' && $ciudadFiltro != 'CDMX' && $ciudadFiltro != 'ALL' && $ciudadFiltro != 'Todas' ){
					$consultaCiudad=$consultaCiudad."_".$ciudadFiltro;
				}
				$consultaCiudad=$consultaCiudad." V, SGI_Empleados E WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$fecha' ORDER BY xd_fecha,xt_horaEntrada DESC";
				//echo "$consultaCiudad";
				$s = $INTRANET->Execute($consultaCiudad);
		}else{
			
			
			$consultaCiudad="
				SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida, 
				E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita 
				FROM SGI_Visitas" ;
				if($ciudadDefault != 'CMX' && $ciudadDefault != 'DF' && $ciudadDefault != 'CDMX' && $ciudadDefault != 'ALL' && $ciudadFiltro != 'Todas' ){
					$consultaCiudad=$consultaCiudad."_".$ciudadDefault;
				}
				$consultaCiudad=$consultaCiudad." V, SGI_Empleados E WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$fecha' ORDER BY xd_fecha,xt_horaEntrada DESC";
				//echo "$consultaCiudad";
				$s = $INTRANET->Execute($consultaCiudad);

		}
		$ciudadFiltro  = $ciudadDefault;
		while($r = $s->fetchRow($s)){
			$salida ="". $r[7];

				echo "<tr height='25' id='iconosTexto'>";				
					
					echo "<td width='80' align='left'>";
						echo"<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'> $r[1] </a>";
					echo "</td>";
					/*
					echo "<td width='80' align='left'>";
						if($r[12] == "P"){
							echo"Proveedor";
						} else if($r[12] == "C"){
							echo"Cliente";
						} else if($r[12] == "V"){
							echo"VIP";
						} else if($r[12] == "A"){
							echo"Autoridad";
						}
						
					echo "</td>";
					*/
					echo "<td width='260' align='left'>";
						echo "<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'>$r[2] $r[3] $r[4]</a>";
					echo "</td>";
					
					echo "<td width='230' align='left'>";
						echo "$r[11]";
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						$visitante = $r[2].$r[3].$r[4];
						$visitado = $r[8].$r[9].$r[10];
						if($visitante != $visitado){
							echo "$r[8] $r[9] $r[10]";
						}
					echo "</td>";
					
					echo "<td width='100' align='center'>";
						echo date('H:i',strtotime($r[6]));
					echo "</td>";
					if($salida != ""){
						echo "<td width='100' align='left'>".date('H:i',strtotime($salida))."</td>";
						
					}else if($salida == (NULL)){
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'Maria_Garcia')||($usuarioId == 'Jernesto_Rodriguez')|| ($usuarioId == 'Eliane_Malpica') ||($usuarioId == 'sdelap') ||($usuarioId == 'Norma_Tapia') 
						||($usuarioId == 'Itzel_Perez') ||($usuarioId == 'Ana_Vargas')||($usuarioId == 'Erika_Muñoz')||($usuarioId == 'DENNISE_VAZQUEZ') || ($usuarioId == 'Michel_Molina') ||($usuarioId == 'Karina_Vega')||($usuarioId == 'Carlos_Jimenez')||($usuarioId == 'Fernanda_Orduña')||($usuarioId == 'Rafael_Moral')||($usuarioId == 'Wendy_Palmeros')||($usuarioId == 'Stefany_Nieto')||($usuarioId == 'Christian_Martinez') ||($usuarioId == 'Priscilla_Romero')||($usuarioId == 'Veronica_Fernandez')||($usuarioId == 'Magda_Gonzalez')||($usuarioId == 'Esmeralda_Gomez')||($usuarioId == 'Dalia_Mosqueda')||($usuarioId == 'Adlemy_Tah')||($usuarioId == 'Saday_Hernandez')|| ($usuarioId == 'Luz_Arguelles')
						|| ($usuarioId == 'Maria_Toledo')|| ($usuarioId == 'Pamela_Martinez')){
							echo "<td width='100' align='left'><a href='updateSalida.php?id=$r[0]&cd=$ciudadFiltro' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=500,scrollbars=yes')\"> <img src='../Imagenes/ICN_Boton_Azul.png'> </a> </td>";
						}else{
							echo "<td width='100' align='left'></td>";
						}
						
					}
					
					echo "<td width='20' align='right'>";
					echo "</td>";
				echo "</tr>";
			
			echo"</td></tr>";
		}
	}

		echo"<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td colspan='7' width='1130' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='50'> </tr>";
	
	echo"</table>";

}// FIN CASO ADMINISTRADOR

// CASO INHOUSE
else if($categoriaUsr == "Inhouse"){
	
	echo "<table border='0' align='center' width='1100' >";
		
		echo"<tr height='20'> </tr>";
		
		echo"<tr height='23'>";
			echo"<td align='left' width='35' id='breadcrumbs'>Fecha: </td>";
			if ($fecha !=""){
				echo"<td align='left' width='100'><input type='text' name='fecha' class='DatP' size='15' style='height:10px;' value='$fecha'> </td>";
			}else{
				echo"<td align='left' width='100'><input type='text' name='fecha' class='DatP' size='15' style='height:10px;' value='$hoy'> </td>";
			}
			
			//$s= $INTRANET->Execute("SELECT kf_usuario FROM SGI_Usuario_Registro_Ciudad WHERE xt");
			
			echo"<td align='left' width='15'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_CalendarioPopUp.png' height='15' width='15'> </td>";
			
			if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'Maria_Garcia') ||($usuarioId == 'sdelap') ||($usuarioId == 'Norma_Tapia')	||($usuarioId == 'Itzel_Perez') || ($usuarioId == 'Fulgencio_Duran') || ($usuarioId == 'Eliane_Malpica') || ($usuarioId == 'Ruben_Solis') || ($usuarioId == 'Javier_Rosas') ||($usuarioId == 'Alfonso_Santiago') || ($usuarioId == 'Gustavo_Gracia') || ($usuarioId == 'Eduardo_Hernandez')||($usuarioId == 'Ana_Vargas')||($usuarioId == 'Erika_Muñoz')||($usuarioId == 'DENNISE_VAZQUEZ')||($usuarioId == 'Michel_Molina')||($usuarioId == 'Jernesto_Rodriguez')||($usuarioId == 'Karina_Vega')||($usuarioId == 'Carlos_Jimenez')||($usuarioId == 'Fernanda_Orduña')||($usuarioId == 'Stefany_Nieto')||($usuarioId == 'Rafael_Moral')||($usuarioId == 'Wendy_Palmeros')||($usuarioId == 'Christian_Martinez') ||($usuarioId == 'Priscilla_Romero')||($usuarioId == 'Veronica_Fernandez')||($usuarioId == 'Magda_Gonzalez')||($usuarioId == 'Esmeralda_Gomez')||($usuarioId == 'Dalia_Mosqueda')||($usuarioId == 'Adlemy_Tah')||($usuarioId == 'Saday_Hernandez')||($usuarioId == 'Luz_Arguelles')||($usuarioId == 'Alma_Rocio')	|| ($usuarioId == 'Monserrath_Sanchez')
			|| ($usuarioId == 'Maria_Toledo') || ($usuarioId == 'Barbara_Cortes') || ($usuarioId == 'Pamela_Martinez')){
					
				echo "<td width='330'></td><td align='left' width='620'><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Registros/altaVisitaPopUp3.php?cd=$ciudadFiltro' target='popup' onclick=\"window.open(this.href,this.target,'width=750,height=700,scrollbars=yes')\"> 
				<img src='../Imagenes/ICN_BotonAgregar.png' width='90' height='29'> </a></td>";
			}
		echo"</tr>";
		
		echo"<tr height='20'> </tr>";
		
	echo "</table>";
		
	echo "<table border='0' align='center' >";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr id='titulo2'>";
			echo"<td align='left' width='80'>Gafete</td>";
			//echo"<td align='left' width='80'>Tipo</td>";
			echo"<td align='left' width='260'>Nombre</td>";
			echo"<td align='left' width='230'>Empresa</td>";
			echo"<td align='left' width='260'>Responsable</td>";
			echo"<td align='left' width='100'>Entrada</td>";
			echo"<td align='left' width='100'>Salida</td>";

				echo"<td align='right' width='20'></td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td colspan='7' width='1130' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'> </tr>";	
		
	echo "</table>";
	

	echo"<table align='center' border='0'>";
	
	
	if ($fecha == ""){
		
		$consulta="
			SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida, 
			E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita 
			FROM SGI_Visitas" ;

			//var_dump($ciudadesDisponibles);
			if($ciudadesDisponibles[1] != 'CMX' && $ciudadesDisponibles[1] != 'DF' && $ciudadesDisponibles[1] != 'CDMX' && $ciudadesDisponibles[1] != 'ALL'){
				$consulta=$consulta."_".$ciudadesDisponibles[1];
			}
			$consulta=$consulta." V, SGI_Empleados E WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$hoy' ORDER BY xd_fecha,xt_horaEntrada DESC";
			//echo "$consulta<br>";
		$s = $INTRANET->Execute($consulta);
			
		while($r = $s->fetchRow($s)){
			$salida ="". $r[7];

				echo "<tr height='25' id='iconosTexto'>";				
					
					echo "<td width='80' align='left'>";
						echo"<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'> $r[1] </a>";
					echo "</td>";
					/*
					echo "<td width='80' align='left'>";
						if($r[12] == "P"){
							echo"Proveedor";
						} else if($r[12] == "C"){
							echo"Cliente";
						} else if($r[12] == "V"){
							echo"VIP";
						} else if($r[12] == "A"){
							echo"Autoridad";
						}
						
					echo "</td>";
					*/
					echo "<td width='260' align='left'>";
						echo "<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'>$r[2] $r[3] $r[4]</a>";
					echo "</td>";
					
					echo "<td width='230' align='left'>";
						echo "$r[11]";
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						$visitante = $r[2].$r[3].$r[4];
						$visitado = $r[8].$r[9].$r[10];
						if($visitante != $visitado){
							echo "$r[8] $r[9] $r[10]";
						}
					echo "</td>";
					
					echo "<td width='100' align='center'>";
						echo date('H:i',strtotime($r[6]));
					echo "</td>";
					if($salida != ""){
						echo "<td width='100' align='left'>".date('H:i',strtotime($salida))."</td>";
						
					}else if($salida == (NULL)){
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez')||($usuarioId == 'Maria_Garcia') ||($usuarioId == 'sdelap') ||($usuarioId == 'Norma_Tapia') ||($usuarioId == 'Itzel_Perez') || ($usuarioId == 'Javier_Rosas')|| ($usuarioId == 'Fulgencio_Duran') || ($usuarioId == 'Eliane_Malpica')|| ($usuarioId == 'Ruben_Solis') ||($usuarioId == 'Alfonso_Santiago') || ($usuarioId == 'Gustavo_Gracia')||($usuarioId == 'Jernesto_Rodriguez')|| ($usuarioId == 'Eduardo_Hernandez')||($usuarioId == 'Ana_Vargas')||($usuarioId == 'Erika_Muñoz')||($usuarioId == 'DENNISE_VAZQUEZ')|| ($usuarioId == 'Michel_Molina')||($usuarioId == 'Karina_Vega')||($usuarioId == 'Carlos_Jimenez')||($usuarioId == 'Fernanda_Orduña')||($usuarioId == 'Rafael_Moral')||($usuarioId == 'Wendy_Palmeros')||($usuarioId == 'Stefany_Nieto')||($usuarioId == 'Christian_Martinez') ||($usuarioId == 'Priscilla_Romero')||($usuarioId == 'Veronica_Fernandez')||($usuarioId == 'Magda_Gonzalez')||($usuarioId == 'Esmeralda_Gomez')||($usuarioId == 'Dalia_Mosqueda')||($usuarioId == 'Adlemy_Tah')||($usuarioId == 'Saday_Hernandez')|| ($usuarioId == 'Luz_Arguelles') 
						|| ($usuarioId == 'Maria_Toledo') || ($usuarioId == 'Pamela_Martinez')){
							echo "<td width='100' align='left'> <a href='updateSalida.php?id=$r[0]&cd=$ciudadFiltro' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=500,scrollbars=yes')\"> 
									<img src='../Imagenes/ICN_Boton_Azul.png'></a>
								</td>";
						}else {
							echo "<td width='100' align='left'></td>";
						}
					}
					
					echo "<td width='20' align='right'>";
					echo "</td>";
				echo "</tr>";
			
			echo"</td></tr>";
		}
	}else if ($fecha != ""){
		
		$consulta="
			SELECT V.kp_visitaID,V.xn_credencial,V.xt_nombre,V.xt_apellidoPaterno,V.xt_apellidoMaterno,V.xd_fecha,V.xt_horaEntrada,V.xt_horaSalida, 
			E.xt_nombre, E.xt_ApellidoPaterno, E.xt_ApellidoMaterno, V.xt_empresaRepresenta, V.xt_tipoVisita 
			FROM SGI_Visitas" ;
			if($ciudadesDisponibles[1] != 'CMX' && $ciudadesDisponibles[1] != 'DF' && $ciudadesDisponibles[1] != 'CDMX' && $ciudadesDisponibles[1] != 'ALL'){	
				$consulta=$consulta."_".$ciudadesDisponibles[1];
			}
			$consulta=$consulta." V, SGI_Empleados E WHERE V.kf_personalEncargadoId = E.kp_personalId AND xd_fecha= '$fecha' ORDER BY xd_fecha,xt_horaEntrada DESC";
		$s = $INTRANET->Execute($consulta);
		
		while($r = $s->fetchRow($s)){
			$salida ="". $r[7];

				echo "<tr height='25' id='iconosTexto'>";				
					
					echo "<td width='80' align='left'>";
						echo"<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'> $r[1] </a>";
					echo "</td>";
					
					echo "<td width='80' align='left'>";
						if($r[12] == "P"){
							echo"Proveedor";
						} else if($r[12] == "C"){
							echo"Cliente";
						} else if($r[12] == "V"){
							echo"VIP";
						} else if($r[12] == "A"){
							echo"Autoridad";
						}
						
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						echo "<a href='fichaVisita.php?id=$r[0]&cd=$ciudadFiltro' id='iconosTexto' style='text-decoration:none;'>$r[2] $r[3] $r[4]</a>";
					echo "</td>";
					
					echo "<td width='230' align='left'>";
						echo "$r[11]";
					echo "</td>";
					
					echo "<td width='260' align='left'>";
						$visitante = $r[2].$r[3].$r[4];
						$visitado = $r[8].$r[9].$r[10];
						if($visitante != $visitado){
							echo "$r[8] $r[9] $r[10]";
						}
					echo "</td>";
					
					echo "<td width='100' align='center'>";
						echo date('H:i',strtotime($r[6]));
					echo "</td>";
					if($salida != ""){
						echo "<td width='100' align='left'>".date('H:i',strtotime($salida))."</td>";
						
					}else if($salida == (NULL)){
						if (($usuarioId == 'Rodrigo_Romo') ||($usuarioId == 'cozy')||($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Eliane_Malpica') ||($usuarioId == 'Maria_Garcia') ||($usuarioId == 'Jernesto_Rodriguez')||($usuarioId == 'sdelap') ||($usuarioId == 'Norma_Tapia')||($usuarioId == 'Itzel_Perez') ||($usuarioId == 'Ana_Vargas')||($usuarioId == 'Erika_Muñoz')||($usuarioId == 'DENNISE_VAZQUEZ')|| ($usuarioId == 'Michel_Molina')||($usuarioId == 'Karina_Vega')||($usuarioId == 'Carlos_Jimenez')||($usuarioId == 'Stefany_Nieto')||($usuarioId == 'Fernanda_Orduña')||($usuarioId == 'Rafael_Moral')||($usuarioId == 'Wendy_Palmeros')||($usuarioId == 'Christian_Martinez') ||($usuarioId == 'Priscilla_Romero')||($usuarioId == 'Veronica_Fernandez')||($usuarioId == 'Magda_Gonzalez')||($usuarioId == 'Esmeralda_Gomez')||($usuarioId == 'Dalia_Mosqueda')||($usuarioId == 'Adlemy_Tah')||($usuarioId == 'Saday_Hernandez')|| ($usuarioId == 'Luz_Arguelles')
						|| ($usuarioId == 'Maria_Toledo')){
							echo "<td width='100' align='left'> <a href='updateSalida.php?id=$r[0]&cd=$ciudadFiltro' target='popup' onclick=\"window.open(this.href,this.target,'width=550,height=500,scrollbars=yes')\"> <img src='../Imagenes/ICN_Boton_Azul.png'> </a> </td>";
						}else{
							echo "<td width='100' align='left'></td>";
						}
						
					}
					
					echo "<td width='20' align='right'>";
					echo "</td>";
				echo "</tr>";
			
			echo"</td></tr>";
		}
	}

		echo"<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td colspan='8' width='1130' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='50'> </tr>";
	
	echo"</table>";
	
}
  echo "</form>";
echo "</div>";
 
?>

</body>
</html>


	 
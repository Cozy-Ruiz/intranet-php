<?php
$nombrephp='AgregarItemPopUp.php';

require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

error_reporting(E_PARSE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Item</title>


 <?php
	if($estiloUsuario == 1){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
	?>
	
	</head>
	
<body>
<?php
echo "<div id='wrapperPopUp'>";
  echo "<form name='fichaSubir' method='POST' action='AgregarItemPopUpv2.php'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Agregar Item</font>";
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
		echo "<tr>";
			echo "<td id='titleBlueLineTop'></td>";
		echo "</tr>";
		echo"<tr height='15'> </tr>";
	//TITULO ITEM
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Título</td>";
		echo "</tr>";
	//INPUT TITULO
		echo"<tr align='left'>";
			echo "<td  align='left' width='450px'>";
				echo "<input type='text' size='71' maxlength='250' name='titulo'>";
			echo"</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";
		
	echo "<table border='0' align='center'>";
	
	
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	
	echo "<table border='0' align='center' width='500px'>";	
		echo "<tr align='left' height='20' >";
	//GRUPO ITEM
			echo "<td id='iconosTexto2' align='left'>Grupo</td>";
	//MANUAL ITEM
			echo "<td id='iconosTexto2' align='left'>Manual</td>";
		echo "</tr>";
	
		echo "<tr align='left' height='20' >";
	//INPUT GRUPO
			echo "<td id='iconosTexto2' align='left' width='150px'>";
				echo "<select name='grupo'>";
					echo "<option value='' selected=''></option>";
					$m = $INTRANETV2->Execute("SELECT xt_codigo, xt_nombre FROM SGI_Grupos ORDER BY xt_nombre");
						while($n = $m->fetchRow()){
							$codigoSucursal = $n[0];
							$nombreSucursal = $n[1];
							
							echo "<option value='".$codigoSucursal."'>".$nombreSucursal."</option>";
						}
				echo "</select>";
			echo "</td>";
	//INPUT MANUAL
			echo "<td id='iconosTexto2' align='left' width='300px'>";
				echo "<select name='area'>";
					echo "<option value='' selected=''></option>";
					$b = $INTRANETV2->Execute("SELECT xt_nombre, xt_codigoManual FROM SGI_Catalogo_Manuales ORDER BY xt_codigoManual");
						while($o = $b->fetchRow()){
							$nombreManual  = $o[0];
							$codigoManual  = $o[1];
							
							echo "<option value='".$codigoManual."'>".$nombreManual."</option>";
						}
				
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo"<tr height='10'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='500px'>";
		echo "<tr align='left' height='20' >";
	//TIPO ITEM
			echo "<td id='iconosTexto2' align='left'>Tipo</td>";
	//CIUDAD ITEM
			echo "<td id='iconosTexto2' align='left'>Ciudad</td>";	
		echo "</tr>";
		
		echo "<tr align='left' height='20' >";
	//INPUT TIPO
			echo "<td id='iconosTexto2' align='left' width='150px' onchange='show()'>";
				echo "<select name='tipo' id='seleccion'>";
					echo "<option value='' selected=''></option>";
					$k = $INTRANETV2->Execute("SELECT xt_codigoTipoDoc FROM SGI_Catalogo_Tipo_Documento ORDER BY xt_codigoTipoDoc");
								while($u = $k->fetchRow()){
									$tipoDocumento  = $u[0];
															  
										echo"<option value='".$tipoDocumento."'>".$tipoDocumento."</option>";
											
								}
					
				echo "</select>";
			echo "</td>";
	//INPUT CIUDAD
			echo "<td id='iconosTexto2' align='left' width='300px'>";
				echo "<select name='ciudad'>";
					echo "<option value='' selected='selected'></option>";
						$t = $INTRANETV2->Execute("SELECT xt_nombre, xt_sucursal FROM SGI_Catalogo_Sucursales ORDER BY xt_nombre");
								while($p = $t->fetchRow()){
									$nombreCiudad  = $p[0];
									$codigoCiudad  = $p[1];
															  
										echo"<option value='".$codigoCiudad."'>".$nombreCiudad."</option>";
											
								}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
	
		echo"<tr height='20'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
	//Proceso y Subproceso
		echo "<tr align='left' height='30' style='display:none;' id='subproceso1'>";
			echo "<td id='iconosTexto2' align='left' width='450px'>Subconsecutivo</td>";
		echo "</tr>";
		
		echo "<tr align='left' height='30' style='display:none;' id='subproceso2'>";
			echo "<td align='left' width='450px'><input type='text' size='71' maxlength='250' name='subConsecutivo'></td>";
			echo "<input type='hidden' name='itera' value='ok'>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
	echo "</table>";

	
	echo "<table border='0' align='center'>";
	
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='500px'></td>";
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
	
if($_POST['area'] != '' && $_POST['tipo'] != '' && $_POST['grupo'] != '' && $_POST['titulo'] != ''){
	
	 $titulo = $_POST['titulo'];
	 $grupo  = $_POST['grupo'];
	 $manual = $_POST['area'];
	 $tipo   = $_POST['tipo'];
	 $ciudad = $_POST['ciudad'];
	
	if($tipo != "K"){
		
	
		$codMaximo = $INTRANETV2->getOne("select MAX(xt_codigoDocumento) FROM SGI_Manuales_Documentos");

		// $codMaximo .= +1;
		$codMaxIncre = ltrim($codMaximo, "0") + 1;

		//agrego los ceros necesarios


		if(strlen($codMaxIncre) == 1){
			$codMaxIncre = "000".$codMaxIncre;
		}else if(strlen($codMaxIncre) == 2){		
			$codMaxIncre = "00".$codMaxIncre;
		}else if(strlen($codMaxIncre) == 3){		
			$codMaxIncre = "0".$codMaxIncre;
		}else if(strlen($codMaxIncre) == 4){		
			$codMaxIncre = $codMaxIncre;		
		}

		if ($ciudad == 'LRD') {
			$ciudad = 'LAR';
		}
		
		 $codigoCompleto = $grupo."-".$manual."-".$ciudad."-".$tipo."-".$codMaxIncre;

		if($ciudad != ''){


			if($INTRANETV2->Execute("INSERT INTO SGI_Manuales_Documentos (xt_codigoDocumento, xt_codigoManual, xt_grupo, xt_ciudad, xt_tipoDocumento, xt_nombre, xt_codigoCompleto, xd_fechaCreacion) VALUES ('$codMaxIncre','$manual', '$grupo','$ciudad', '$tipo','$titulo', '$codigoCompleto', CURRENT_TIMESTAMP())")){

			}	


		}
		
		echo'<script type="text/javascript">
		opener.location.href="fichaDocumentov3.php?id='.$codMaxIncre.'";
		window.close();
		</script>';
		
	}else{
		
		//Obtengo el ultimo proceso
		$maximoNum = $INTRANETV2->getOne("SELECT MAX(RIGHT(xt_codigoCorto,4)) +1  FROM SGI_Procesos");
		
		//if($ciudad == ''){$ciudad = '';}else{$ciudad = "-".$ciudad;}
			
		if(strlen($maximoNum) == 1){

			$maximoProceso = "-K000".$maximoNum;
			$maximoNum = "000".$maximoNum;

		} else if(strlen($maximoNum) == 2){

			$maximoProceso = "-K00".$maximoNum;
			$maximoNum = "00".$maximoNum;

		} else if(strlen($maximoNum) == 3){

			$maximoProceso = "-K0".$maximoNum;
			$maximoNum = "0".$maximoNum;
		
		} else if(strlen($maximoNum) >= 4){

			$maximoProceso = "-K".$maximoNum;
			$maximoNum = $maximoNum;
		}
		//Codigo de proceso
		//$proceso = $grupo."-".$area.$ciudad.$maximoProceso;
		$proceso = $grupo."-".$manual."-".$ciudad."-".$tipo."-".$maximoNum;
		
		//Elimino el caracter (-) del codigo de proceso
		$nuevoProceso = substr($maximoProceso, 1);
		
		$INTRANETV2->Execute("INSERT INTO SGI_Procesos (xt_codigoCorto, xt_codigoProceso, xt_nombre, xd_fechaCreacion, xt_codigoManual, xt_grupo, xt_ciudad) VALUES ('$nuevoProceso','$proceso','$titulo',CURRENT_TIMESTAMP(), '$manual', '$grupo', '$ciudad')");
			
			
			echo "<script>";
			
			echo "opener.location.href = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProceso.php?proceso=$nuevoProceso';";
			echo "window.close();";
			echo "</script>";
			
		
	}
	
	
	
}

?>
</body>
</html>
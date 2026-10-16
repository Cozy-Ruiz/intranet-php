<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'agregarActividadPopUp.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<title>Nueva Actividad</title>

</head>
<body>
<?php

 $proceso = $_GET['proceso'];

if($_POST['actividad'] == ''){	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevaActividad' method='post' action='agregarActividadPopUp.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Actividad</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='10'></tr>";
			
			
				echo"<tr height='10'></tr>";
			
				//lista de actividades
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Nombre Actividad <br>";

							$listActividades = $INTRANETV2->Execute('SELECT DISTINCT
																		SA.xt_nombre,
																		SA.xt_codigo
																	FROM
																		SGI_Catalogo_Actividades SA
																	ORDER BY
																		SA.xt_nombre');
                     echo "<center><select name='actividad' id='actividad'>";
                     	while($b = $listActividades->fetchRow()){
                        	$nomActividad    = $b[0];
							$codigoActividad = $b[1];

                             echo "<option value='".$codigoActividad.'|'.$nomActividad."'>$nomActividad</option>";   
                         }
                    echo "</select>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'></tr>";
				//lista de roles
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Nombre Rol <br>";

							$listRoles = $INTRANETV2->Execute('SELECT
																xt_nombre,
																xt_codigo
															FROM
																SGI_Catalogo_Roles
															ORDER BY
																xt_nombre');
                     echo "<center><select name='rol' id='rol'>";
                     	while($c = $listRoles->fetchRow()){
                        	$nomRol    = $c[0];
							$codigoRol = $c[1];

                             echo "<option value='".$codigoRol.'|'.$nomRol."'>$nomRol</option>";   
                         }
                    echo "</select>";
					echo "</td>";
				echo "</tr>";

				echo "<tr height='10px'></tr>";
				//lista de roles
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Orden del Rol <br>";
                     echo "<center><select name='ordenRol' id='ordenRol'>";
                     	for($a=1;$a<=15;$a++){
                             echo "<option value='$a'>$a</option>";                            
                         }
                    echo "</select>";
					echo "</td>";
				echo "</tr>";


				echo "<tr height='15px'></tr>";
				//lista de tiempos
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Momento <br>";

							$listTiempo = $INTRANETV2->Execute('SELECT kp_tiempo FROM SGI_Catalogo_Tiempos ORDER BY kp_tiempo');
                     echo "<center><select name='tiempo' id='tiempo'>";
                     	while($c = $listTiempo->fetchRow()){
							$codigoTiempo = $c[0]; 
                             echo "<option value='$codigoTiempo'>$codigoTiempo</option>";
                            
                         }
                    echo "</select>";
					echo "</td>";
				echo "</tr>";
				
				echo "<input type='hidden' name='proceso' value='$proceso'>";
				echo"<tr height='10'></tr>";				
			
				echo"<tr height='15'></tr>";
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";
}else if($_POST['actividad'] != '' &&  $_POST['rol'] != ''){
	
	$procesoAgrega   = $_POST['proceso'];
	$actividad       = explode("|",$_POST['actividad']);
	$codActividadAgrega = $actividad[0];
	$nomActividadAgrega = $actividad[1];
	$rol             = explode("|",$_POST['rol']);
	$rolCodigo       = $rol[0];
	$nombreRol       = $rol[1];
	$ordenRol        = $_POST['ordenRol'];
	$codigoTiempo    = $_POST['tiempo'];
	
	//echo"INSERT INTO SGI_K_Roles (kp_codigoRol, kf_codigoProceso, xt_nombreRol, xn_ordenRol) VALUES ('$rolCodigo','$procesoAgrega','$nombreRol',$ordenRol)<br><br>";
	$INTRANETV2->Execute("INSERT INTO SGI_Roles (xt_codigoRol, xt_codigoProceso, xt_nombreRol, xn_ordenRol) VALUES ('$rolCodigo','$procesoAgrega','$nombreRol',$ordenRol)");
	
	//echo"INSERT INTO SGI_K_Actividades (kp_codigoActividad, kf_codigoRol, kf_codigoProceso, xt_nombre, xt_momento) VALUES ('$codActividadAgrega', '$rolCodigo', '$procesoAgrega', '$nomActividadAgrega', '$codigoTiempo')<br><br>";
	$INTRANETV2->Execute("INSERT INTO SGI_Actividades (xt_codigoActividad, xt_codigoRol, xt_codigoProceso, xt_nombre, xt_momento) VALUES ('$codActividadAgrega', '$rolCodigo', '$procesoAgrega', '$nomActividadAgrega', '$codigoTiempo')");


	/*$inventarioLiberado = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Libera_Inventarios WHERE kp_codigo = '$codigoProceso' ");
		
	if($inventarioLiberado != ''){
	
	  echo "<div id='wrapperPopUp'>";
	   echo "<form name='fichaSubir' method='POST' action='agregarActividadPopUp.php'>";	
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
					  echo "<input type='hidden' value='$itemID' name='itemID'><input type='hidden' value='1' name='modifica'>";
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
					  echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				  echo"</td>";
			  echo"</tr>";
			  
			  echo"<tr height='10'> </tr>";
		  echo "</table>";
		  
		  echo "</form>";
	  echo "</div>";
  
		
	}else{*/
			
		?>
			
			<script type="text/javascript">
				window.opener.top.location="fichaProceso.php?proceso=<?php echo $procesoAgrega; ?>";
				window.close();
			</script>
	

		<?php
//	}*/
	
}//fin del if else



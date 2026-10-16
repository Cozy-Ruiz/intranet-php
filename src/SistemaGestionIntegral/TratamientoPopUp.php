<?php error_reporting(0); ?>
<?php
/*
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'TratamientoPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
			<title>Tratamiento</title>
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
  
if( $_POST['atributo'] == ""){
	
	$issueID = $_GET['id']; 
	
	echo "<div id='wrapperPopUp'>";
	  echo "<form method='post' action='TratamientoPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo "<tr>";
				echo "<td align='center' id='titulo1'>";
					echo "Tratamiento";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='50'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop'></td>";
			echo "</tr>";
	
			echo "<tr height='15px'><td></td></tr>";
			
			echo "<tr align='center' height='20px'>";
				echo "<td id='iconosTexto2'>Tipo</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td></td></tr>";
			
			echo "<tr align='center' width='400px'>";
				echo "<td  align='center'>";
					echo "<select id='seleccion' name='atributo'>";
						echo "<option value='' selected=''>Elegir...</option>";					
						echo "<option value='SOLICITUD'>Solicitud</option>";
						echo "<option value='PREVENTIVA'>Acción Preventiva</option>";
						echo "<option value='CORRECTIVA'>Acción Correctiva</option>";
					echo "</select>";
					echo "<input type='hidden' name='issue' value='".$issueID."'/>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='30px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineTop'></td>";
			echo "</tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "</form>";
	echo "</div>";
///SOLICITUD
} else if($_POST['atributo'] == "SOLICITUD"){
	
	$issueID = $_POST['issue'];
	
	$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_descripcion, xt_ruta, xt_grupo, xt_ciudad FROM SGI_Auditorias_Issues WHERE kp_issueID = $issueID ");
	
	while($r = $s->fetchRow()){
		
		$fechaInsert 		= date('Y-m-d', strtotime($r[0]));
		$tituloInsert 		= $r[1];
		$descripcionInsert 	= $r[2];
		$archivo 			= $r[3];
		$grupoInsert		= $r[4];
		$ciudad				= $r[5];
		
	} unset($r); unset($s);
	
	$anio = date('Y', strtotime($fechaInsert));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
							 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-B-DF-14-001
	if(($ciudad != "") && ($ciudad != "GEN")){
		
		$codigo = $grupoInsert."-B-".$ciudad."-";
		
	} else{
		
		$codigo = $grupoInsert."-B-";
		
	}
	
	$anio = date('y', strtotime($fechaInsert));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes(xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_claveQuejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo) 
						  							   VALUES('B', '$ciudad', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$usuarioId', '$grupoInsert') ")){
		
		$solicitudID = $INTRANET->getOne("SELECT kp_quejaSolicitudID FROM SGI_Quejas_Solicitudes WHERE xt_tipo = 'B' AND xt_ciudad = '$ciudad' 
										  AND xn_numero = '$maximo' AND xt_claveQuejaSolicitud = '$codigo' AND xt_grupo = '$grupoInsert' ");
		
		
		$INTRANET->Execute("UPDATE SGI_Auditorias_Issues SET kf_tratamientoID = '$solicitudID', xt_tipoTratamiento = 'SOLICITUD' WHERE kp_issueID = $issueID ");
		
		if($archivo != ""){
			
			$origen 	= "AuditoriaArchivos/".$archivo;
			$destino 	= "../ComunicacionInterna/SugerenciaQueja/".$archivo;
			
			if(copy($origen, $destino)){
				
				if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes SET xt_ruta = '$archivo' WHERE xt_claveQuejaSolicitud = '$codigo' ") ){
					
					echo "<script type='text/javascript'>reCargarPadre()</script>";
					
				} else{
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center' name='Encabezado'>";
							
							echo "<tr>"; 
								echo "<td align='center'>";
									echo $breadcrumb;
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='70px'><td></td></tr>";
							
							echo "<tr>";
								echo "<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='40px'>";
								echo "<td valign='bottom' align='right'>";
									echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
								echo "</td>";
							echo "</tr>";
							
						echo "</table>";
					echo "</div>";
				}
				
			} else{
				
				echo "<div id='wrapper'>";
					echo "<table border='0' align='center' name='Encabezado'>";
						echo "<tr>"; 
							echo "<td align='center'>";
								echo $breadcrumb;
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='70px'><td></td></tr>";
						
						echo "<tr>";
							echo "<td align='center' id='titulo1'>";
								echo "Error en la carga";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='40px'>";
							echo "<td valign='bottom' align='right'>";
								echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
			}
			
		} else{
			
			echo "<script type='text/javascript'>reCargarPadre()</script>";
			
		}
		
	} else{
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Tratamiento No Agregado";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>"; 
					echo "<td align='center'>";
						echo $breadcrumb;
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
		
				echo "<tr height='15px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='center'>Error</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='center'>";
						echo "No se pudo agregar el tratamiento.";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td align='right'></td>";
				echo "</tr>";
			echo "</table>";
		echo "</div>";

	}
///PREVENTIVA
} else if($_POST['atributo'] == "PREVENTIVA"){
	
	$issueID = $_POST['issue'];
	
	$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_descripcion, xt_ruta, xt_grupo, xt_ciudad FROM SGI_Auditorias_Issues WHERE kp_issueID = $issueID ");
	
	while($r = $s->fetchRow()){
		
		$fechaInsert 		= date('Y-m-d', strtotime($r[0]));
		$tituloInsert 		= $r[1];
		$descripcionInsert 	= $r[2];
		$archivo 			= $r[3];
		$grupoInsert		= $r[4];
		$ciudad				= $r[5];
		
	} unset($r); unset($s);
	
	$anio = date('Y', strtotime($fechaInsert));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acciones_Preventivas_Correctivas WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'D' 
							 AND xt_grupo = '$grupoInsert' AND xt_ciudad = '$ciudad' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-D-DF-14-001
	if(($ciudad != "") && ($ciudad != "GEN")){
		
		$codigo = $grupoInsert."-D-".$ciudad."-";
		
	} else{
		
		$codigo = $grupoInsert."-D-";
		
	}
	
	$anio = date('y', strtotime($fechaInsert));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas(xt_tipo, xn_numero, xd_fecha, xt_claveAccion, xt_titulo, xt_descripcion, xt_ciudad, xt_grupo) 
						  VALUES('D', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$ciudad', '$grupoInsert') ")){
							  
		$idAccion = mysql_insert_id();
							  
		$INTRANET->Execute("UPDATE SGI_Auditorias_Issues SET kf_tratamientoID = '$idAccion', xt_tipoTratamiento = 'PREVENTIVA' WHERE kp_issueID = $issueID ");
		
		if($archivo != ""){
			
			$origen = "AuditoriaArchivos/".$archivo;
			$destino = "PreventivaCorrectiva/".$archivo;
			
			if(copy($origen, $destino)){
				
				if($INTRANET->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xt_ruta = '$archivo' WHERE xt_claveAccion = '$codigo' ") ){
					
					echo "<script type='text/javascript'>reCargarPadre()</script>";
					
				} else{
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center' name='Encabezado'>";
							
							echo "<tr>"; 
								echo "<td align='center'>";
									echo $breadcrumb;
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='70'><td></td></tr>";
							
							echo "<tr>";
								echo "<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='40'>";
								echo "<td valign='bottom' align='right'>";
									echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
								echo "</td>";
							echo "</tr>";
							
						echo "</table>";
					echo "</div>";
				}
				
			} else{
				
				echo "<div id='wrapper'>";
					echo "<table border='0' align='center' name='Encabezado'>";
						echo "<tr>"; 
							echo "<td align='center'>";
								echo $breadcrumb;
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='70'><td></td></tr>";
						
						echo "<tr>";
							echo "<td align='center' id='titulo1'>";
								echo "<font>Error en la carga</font>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='40'>";
							echo "<td valign='bottom' align='right'>";
								echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
			}
			
		} else{
			
			echo "<script type='text/javascript'>reCargarPadre()</script>";
			
		}
		
	} else{
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Tratamiento No Agregado";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>"; 
					echo "<td align='center'>";
						echo $breadcrumb;
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo "<tr height='15'>";
					echo "<td colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='center' colspan='2'>Error</td>";
				echo "</tr>";
				
				echo "<tr align='left'>";
					echo "<td  align='center' colspan='2'>";
						echo "No se pudo agregar el tratamiento.";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10'><td colspan='2'></td></tr>";
				
				echo "<tr height='40'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr height='30'>";
					echo "<td align='right' colspan='2'></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</div>";

	}
	
///CORRECTIVA
} else if($_POST['atributo'] == "CORRECTIVA"){
	
	$issueID = $_POST['issue'];
	
	$s = $INTRANET->Execute("SELECT xd_fecha, xt_titulo, xt_descripcion, xt_ruta, xt_grupo, xt_ciudad FROM SGI_Auditorias_Issues WHERE kp_issueID = $issueID ");
	
	while($r = $s->fetchRow()){
		
		$fechaInsert 		= date('Y-m-d', strtotime($r[0]));
		$tituloInsert 		= $r[1];
		$descripcionInsert 	= $r[2];
		$archivo 			= $r[3];
		$grupoInsert		= $r[4];
		$ciudad				= $r[5];
		
	} unset($r); unset($s);
	
	$anio = date('Y', strtotime($fechaInsert));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acciones_Preventivas_Correctivas WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'E' 
							 AND xt_grupo = '$grupoInsert' AND xt_ciudad = '$ciudad' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-D-DF-14-001
	if(($ciudad != "") && ($ciudad != "GEN")){
		
		$codigo = $grupoInsert."-E-".$ciudad."-";
		
	} else{
		
		$codigo = $grupoInsert."-E-";
		
	}
	
	$anio = date('y', strtotime($fechaInsert));
	
	if(		  strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Acciones_Preventivas_Correctivas(xt_tipo, xn_numero, xd_fecha, xt_claveAccion, xt_titulo, xt_descripcion, xt_grupo, xt_ciudad) 
						  VALUES('E', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$grupoInsert', '$ciudad') ")){
							  
		$idAccion = mysql_insert_id();
							  
		$INTRANET->Execute("UPDATE SGI_Auditorias_Issues SET kf_tratamientoID = '$idAccion', xt_tipoTratamiento = 'CORRECTIVA' WHERE kp_issueID = $issueID ");
		
		if($archivo != ""){
			
			$origen = "AuditoriaArchivos/".$archivo;
			$destino = "PreventivaCorrectiva/".$archivo;
			
			if(copy($origen, $destino)){
				
				if($INTRANET->Execute("UPDATE SGI_Acciones_Preventivas_Correctivas SET xt_ruta = '$archivo' WHERE xt_claveAccion = '$codigo' ") ){
					
					echo "<script type='text/javascript'>reCargarPadre()</script>";
					
				} else{
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center' name='Encabezado'>";
							echo "<tr>"; 
								echo "<td align='center'>";
									echo $breadcrumb;
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='70'><td></td></tr>";
							
							echo "<tr>";
								echo "<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='40'>";
								echo "<td valign='bottom' align='right'>";
									echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</div>";
				}
				
			} else{
				
				echo "<div id='wrapper'>";
					echo "<table border='0' align='center' name='Encabezado'>";
						echo "<tr>"; 
							echo "<td align='center'>";
								echo $breadcrumb;
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='70'><td></td></tr>";
						
						echo "<tr>";
							echo "<td align='center' id='titulo1'>";
								echo "Error en la carga";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='40'>";
							echo "<td valign='bottom' align='right'>";
								echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				
			}
			
		} else{
			
			echo "<script type='text/javascript'>reCargarPadre()</script>";
			
		}
		
	} else{
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Tratamiento No Agregado";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>"; 
					echo "<td align='center'>";
						echo $breadcrumb;
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450'>";
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo "<tr height='15'>";
					echo "<td colspan='2'></td>";
				echo "</tr>";
				
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='center' colspan='2'>Error</td>";
				echo "</tr>";
				
				echo "<tr align='left'>";
					echo "<td  align='center' colspan='2'>";
						echo "No se pudo agregar el tratamiento.";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10'><td colspan='2'></td></tr>";
				
				echo "<tr height='40'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr height='30'>";
					echo "<td align='right' colspan='2'></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</div>";

	}
		
}

?>
    	</body>
    </html>
<?php

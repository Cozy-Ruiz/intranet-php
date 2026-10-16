<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once('../../../compruebaUsuario.php');

//obtengo atributos traidos de la ficha CU

 $solicitudId = $_GET['codigo'];
 $ciudadSolicitud = $_GET['ciudad'];
  $tipoSolicitud = $_GET['tipoS'];
 $prioridad = $_GET['prioridad'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../../../Imagenes/ICN_PestanaWebGE.png">
<title></title>

</head>
<body>
<?php




	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevaActividad' method='POST' action='backlogEntregablesPopUp.php?codigo=$solicitudId&ciudad=$ciudadSolicitud&tipoS=$tipoSolicitud&prioridad=$prioridad'>";

			
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Entregables</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			
				echo"<tr height='25px'> </tr>";
			echo "</table>";
			
			
			echo "<table border='0' align='center'>";
				
				
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='10'></tr>";
	
				echo "<tr>";
				echo "<td>Titulo</td>";
				echo "</tr>";
				
				if($tipoSolicitud != 'EA'){
					echo "<tr>";
						echo "<td><input type='text' name='titulo' size='60'></td>";
					echo "</tr>";
				}else{		
					echo "<tr>";
						echo "<td>";
						 echo "<select name='titulo' size='1' >";
								  echo'<option value="">Selecciona opcion..</option>';
								  echo'<option value="Mail envios pedimentos">Mail envios pedimentos</option>';
								  echo'<option value="Mail envios cuenta de Gastos">Mail envios cuenta de Gastos</option>';
								  echo'<option value="FTP envio pedimentos">FTP envio pedimentos</option>';
								  echo'<option value="FTP envio cuenta de gastos">FTP envio cuenta de gastos</option>';	  
							echo"</select>";
							echo"</td>";
					echo "</tr>";	
				}
				
				echo "<tr height='10px'></tr>";
				
				echo "<tr>";
				echo "<td>Descripción</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><textarea id='descripcion' rows='5' cols='50' name='descripcion'></textarea></td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
		
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";
	
	
	//obtengo datos del formulario
	
	if(isset($_POST['titulo']) && isset($_POST['descripcion'])){
		
		$tituloEntregable = $_POST['titulo'];
		$descripcionE = $_POST['descripcion'];
		
		$contedescrip = strlen($descripcionE);

if ($contedescrip >= 205){
	echo $descripcionSolcorto = substr($descripcionE, 0, 247);
	echo $descripcionE = $descripcionSolcorto."...";
}
		//obtengo el ultimo codigo de entregable insertado para definir el sig codigo
		$maximo = 0;
		$maximo = $INTRANET->getOne("SELECT MAX(xn_consecutivo) FROM BACKLOG.ENTREGABLES");
		if($maximo == ''){
			
			 $maximo = 1;
		}else{
		 $maximo+= 1;
		}
		
	if($maximo<10){ $clave = "0000".$maximo; }else if($maximo <100){$clave = "000".$maximo;}else if($maximo < 1000){$clave = "00".$maximo;}
	else if($maximo<10000){$clave = "0".$maximo;}else if($maximo<100000){$clave = $maximo;}
		
		//inserto en la tabla de entregables los datos correspondientes
		//defino el codigo de entregable
		$codigoEntregable = $ciudadSolicitud.'-'.$tipoSolicitud.'-'.$clave;
		
		if($INTRANETV2->Execute("INSERT INTO BACKLOG.ENTREGABLES (xt_codigoEntregable, xt_titulo, xt_descripcion, xt_solicitud, xt_tipo, xt_prioridad, xn_consecutivo, xn_progreso) VALUES ('$codigoEntregable', '$tituloEntregable', '$descripcionE', '$solicitudId', '', '$prioridad', $maximo, 0)")){
		
		if($tipoSolicitud == 'EA'){
			$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Envio_Archivos (xt_quejaSolicitud, xt_entregable, xt_tipoEnvio, xt_descripcionEnvio) VALUES ('$solicitudId','$codigoEntregable','$tituloEntregable','$descripcionE')");
		}
			
			//retorno a la ficha de CU	
			if($tipoSolicitud == "DS"){
				echo '<script>window.opener.top.location="http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/casoUsoBacklog.php?codigo='.$solicitudId.'";</script>';
				echo "<script>this.close();</script>"; 
			}
			if($tipoSolicitud == "MT"){
				echo '<script>window.opener.top.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?codigo='.$solicitudId.'";</script>';
				echo "<script>this.close();</script>"; 
			}
			if($tipoSolicitud == "EA"){
				echo '<script>window.opener.top.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaEnvioArchivos.php?codigo='.$solicitudId.'";</script>';
				echo "<script>this.close();</script>"; 
			}
			
			if($tipoSolicitud == "PY"){
				echo '<script>window.opener.top.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?codigo='.$solicitudId.'";</script>';
				echo "<script>this.close();</script>"; 
			}
			
		}//fin del if de insercion en tabla entregables
		
		
		
	}//fin del if de verificacion de datos del formulario
	
	
	
?>



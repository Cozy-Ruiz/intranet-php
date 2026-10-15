<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'agregaSistemasPopUp.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once('../../../compruebaUsuario.php');

//obtengo atributos traidos de la ficha CU

 $solicitudId = $_GET['codigo'];
 $tipoSolicitud = $_GET['tipoS'];
 
echo $solicitudId;
 $tipoAcceso = $INTRANETV2->getOne("SELECT DISTINCT xt_tipo FROM SGI_Backlog_Solicitud_Sistemas_Temporal WHERE xt_quejaSolicitud = '$solicitudId'");


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
<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<title></title>

</head>
<body>
<?php




	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevaActividad' method='POST' action='agregaSistemasPopUp.php'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='left' id='titulo1'>";
					echo "<font>Sistemas</font>";
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
				
				
				echo "<tr>";
					echo "<td>";
					 echo "<select name='sistema' size='1' >";
							  echo'<option value="">Selecciona opcion..</option>';
							  $l = $INTRANETV2->Execute("SELECT
															P.xt_sistema
														FROM
															PERFILES.CATALOGO_SISTEMAS P
														WHERE
															P.xt_sistema NOT IN (
																SELECT
																	ST.xt_sistema
																FROM
																	SGI_Backlog_Solicitud_Sistemas_Temporal ST
																WHERE
																	ST.xt_quejaSolicitud = '$solicitudId'
															)");
													while($o = $l->fetchRow()){
														$sistema        = $o[0];
					
														echo'<option value="'.$sistema.'">'.$sistema.'</option>';	  
													}
													echo'<input type="hidden" value="'.$solicitudId.'" name="solicitud" />';
													echo'<input type="hidden" value="'.$tipoSolicitud.'" name="tipo" />';
													echo'<input type="hidden" value="'.$tipoAcceso.'" name="tipoAcceso" />';
						echo"</select>";
						echo"</td>";
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
	
	if(isset($_POST['sistema'])){
		
		$agregaSistema = $_POST['sistema'];
		$solicitud     = $_POST['solicitud'];
		$tipoS         = $_POST['tipo'];
		$tipo          = $_POST['tipoAcceso'];
		$fecha         = date("Y-m-d H:i:s");
		
		//var_dump($tipo);
		var_dump($agregaSistema."<br>".$solicitud."<br>".$tipoS."<br>".$tipo."<br>".$fecha);

		//echo"INSERT INTO IntranetGEA.SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo, xd_fecha) VALUES ('$solicitud','$agregaSistema','$tipo','$fecha')";
		if($INTRANETV2->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_codigoEntregable, xt_tipo, xd_fecha) VALUES ('$solicitud','$agregaSistema', '','$tipo','$fecha')")){
			
			//retorno a la ficha de CU	
			if($tipoS == "AB"){
				echo '<script>window.opener.top.location="http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaAltaBajaUsuario.php?codigo='.$solicitud.'";</script>';
				echo "<script>this.close();</script>"; 
			}
			
			
		}else{
			echo "No se registro";
			//print_r($INTRANETV2);
		}//fin del if de insercion en tabla entregables
	
		
	}//fin del if de verificacion de datos del formulario
	
	
	
?>



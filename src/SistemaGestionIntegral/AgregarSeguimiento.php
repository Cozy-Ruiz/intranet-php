<?php error_reporting(0); ?>
<?php

$nombrephp='AgregarSeguimiento.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Seguimiento</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
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
<script type="text/javascript">
	function reCargarPadre(){
		opener.location.reload();
		window.close();
	}
</script>
</head>
<body>
<?php
$origen= $_GET['origen'];
if(($_POST['pdr'] || $_POST['fecha']) == ('' || NULL)){
	

	echo "<div id='wrapperPopUp'>";
	  echo "<form name='agregarSeguimiento' method='POST' action='AgregarSeguimiento.php'  enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Seguimiento</font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
	
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left' >PDR</td>";	
			echo "</tr>";
			
				$s= $INTRANET->Execute("SELECT empa.kf_personalID, emp.xt_nombreCorto FROM SGI_EmpleadosActividad empa, SGI_Empleados emp WHERE emp.kp_personalId= empa.kf_personalID AND
							  xt_actividad='PDR' ");
							  
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left' >
					<select name='pdr' size='1' >
						<option value='0'>Elegir</option>";
						while($r= $s -> fetchRow()){
							echo"<option value='$r[0]'>$r[1]</option>";
						} unset($r); unset ($s);
					echo"</select>
				</td>";	
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
			echo"<tr align='left'>";
					echo "<td id='iconosTexto2' align='left' >Fecha</td>";	
			echo "</tr>";
			
				$ID = $_GET['ID'];
			echo"<tr height='20'> ";
				echo "<td  align='left'>";
					echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha'><input type='hidden' name='origen' value='$origen'><input type='hidden' name='ID' value='$ID'>";
				echo"</td>";
			echo"</tr>";

			echo"<tr height='15'> </tr>";
			
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right' colspan='2'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right' colspan='2'></td>";
			echo "</tr>";
					
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
} else if(($_POST['pdr'] && $_POST['fecha'] ) != ('' && NULL)){
	$pdrInsert = $_POST['pdr'];
	$fechaInsert = date('Y-m-d', strtotime($_POST['fecha']));
	$origenInsert = $_POST['origen'];
	$IDInsert = $_POST['ID'];
	
	$maximo=0;
	
	$anio = date('Y',strtotime($_POST['fecha']));
	
	$s= $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Seguimientos WHERE  YEAR(xd_fechaRegistro)='$anio'");
	
	while($r = $s->fetchRow()){
		$maximo = $r[0];
		
	}
	
	$maximo++;
	unset($r); unset($s);
	$anio = date('y',strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		$codigo = "S-".$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		$codigo = "S-".$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		$codigo = "S-".$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Seguimientos (xt_tipoOrigen,kf_itemOrigenID,xn_numero,xd_fechaRegistro,xt_codigoSeguimiento,kf_asignadorID,kf_pdrID) 
						VALUES ('$origenInsert',$IDInsert,$maximo,'$fechaInsert','$codigo',97,$pdrInsert)  ")){
							
		$seguimientoInsert = $INTRANET->getOne("SELECT kp_seguimientoID FROM SGI_Seguimientos WHERE xt_codigoSeguimiento = '$codigo' ");
		
		$INTRANET->Execute("INSERT INTO SGI_Seguimiento_Etapas (kf_seguimientoID, xn_etapa, xd_fecha) VALUES ($seguimientoInsert,1,'$fechaInsert')");
		echo "<script type='text/javascript'>reCargarPadre()</script>";
	
	} else{
		echo "<div id='wrapperPopUp'>";
		  	echo "<form name='fichaSubir' method='post' action='AgregaRevision.php'>";	
				echo "<table border='0' align='center' name='Encabezado'>";
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Seguimiento No Agregado</font>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='40'>";
						echo"<td valign='bottom' align='right' colspan='2'>";
							echo "<input type='image' onclick='reCargarPadre()' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo"</td>";
					echo"</tr>";
					
					echo"<tr height='70'> </tr>";
				echo "</table>";
			echo "</form>";
		echo "</div>";
	}
}
		
?>
</body>
</html>
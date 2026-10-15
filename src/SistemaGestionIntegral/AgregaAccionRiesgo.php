<?php error_reporting(0); ?>
<?PHP
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'AgregaAccionRiesgo.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");


$idRiesgo = $_GET['id'];

$tipo = "";

if($_POST["tipo"] != ""){
	$tipo = $_POST["tipo"];
}else if($_GET["tipo"] != ""){
	$tipo = $_GET["tipo"];
}

if($tipo == ""){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acciones</title>
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
            script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
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
<?PHP
echo "<div id='wrapperPopUp'>";
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Acciones</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>";
			echo"<td align='center' id='breadcrumbs'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr></tr>";
		
		echo"<tr height='100'> </tr>";
	echo "</table>";
	//CUERPO FICHA ALTA

	echo "<table border='0' align='center' width='450'>";
			
		echo "<tr>";
			echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
		echo "</tr>";

		echo"<tr height='40px'> </tr>";
		
		
		echo"<tr>";
			echo"<td valign='bottom' align='center' >";
				echo "<input type='image' onclick=\"location.href='AgregaAccionRiesgo.php?tipo=CORRECTIVA&id=$idRiesgo';\" src='../Imagenes/ICN_BotonACorrectivas.png' width='120' height='39'>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='40'> </tr>";
		
		
		echo"<tr>";
			echo"<td valign='bottom' align='center' >";
				echo "<input type='image' onclick=\"location.href='AgregaAccionRiesgo.php?tipo=VINCULAR&id=$idRiesgo';\" src='../Imagenes/ICN_BotonVincular.png' width='120' height='39'>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='40'> </tr>";
		
		echo "<tr>";
			echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
		echo "</tr>";
		
		echo "<tr height='30'></tr>";
	echo "</table>";
echo "</div>";

//TIPO ELEGIDO IGUAL A VINCULAR CAPTURAR CODIGO
}else if((($tipo == "VINCULAR")) && ($_POST['codigo']== "") ){
	?>
    <!doctype html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>Acciones</title>
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
            <script type="text/javascript">
                function reCargarPadre(){
                    opener.location.reload();
                    window.close();
                }
            </script>
        </head>
        
        <body>
    <?PHP
	echo "<div id='wrapperPopUp'>";
	  echo "<form name='fichaSubir' method='POST' action='AgregaAccionRiesgo.php'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Agregar Acción </font>";
				echo"</td>";
			echo"</tr>";
			echo"<tr height='70'> </tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Se tratará con el siguiente item: <input type='hidden' name='titulo' value='Se tratará con el siguiente item'></td>";
			echo "</tr>";
	
			echo"<tr height='15'> </tr>";
			
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Código</td>";
			echo "</tr>";
			
			echo"<tr align='left'>";
				echo "<td  align='left'>";
					echo "<input type='text' size=20 maxlength=100 name='codigo'><input type='hidden' name='id' value=$idRiesgo><input type='hidden' name='tipo' value='$tipo'>";
				echo"</td>";
			echo "</tr>";
			
			
			echo"<tr height='15'> </tr>";
			
			echo "<tr>";
				echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr height='30'>";
				echo "<td align='right'></td>";
			echo "</tr>";
					
		echo "</table>";
		
	echo "</form>";
  echo "</div>";
	
//TIPO ELEGIDO IGUAL A VINCULAR CAPTURAR CODIGO
}else if((($tipo == "VINCULAR")) && ($_POST['codigo']!= "") ){
	
	$codigoInsert = $_POST['codigo'];
	$idInsert = $_POST['id'];
	$tituloInsert = $_POST['titulo'];
	$fechaInsert = date("Y-m-d");
	
	$tipoCanalizacion = substr($codigoInsert,0,1);
	if($tipoCanalizacion == "E"){
		
		
		$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acciones_Riesgos WHERE kf_riesgoId = $idInsert");
	
		while($r = $s->fetchRow()){
			$maximo = $r[0];
			
		} unset($r); unset($s);
		
		$maximo++;
		
		$INTRANET->Execute("INSERT INTO SGI_Acciones_Riesgos (kf_riesgoId,xn_numero,xd_fecha,xt_titulo,xt_tipoTratamiento,xt_tipo) 
		VALUES ($idInsert,$maximo,'$fechaInsert','$tituloInsert','$codigoInsert','$tipoCanalizacion') ");
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
		
	}
				

}
//TIPO ELEGIDO IGUAL A PREVENTIVA
else if((($tipo == "CORRECTIVA"))){

	header("Location: altaPreventivaCorrectivaPopUp.php?tipo=correctiva&idRiesgo=$idRiesgo");

	
}
?>
</body>
</html>
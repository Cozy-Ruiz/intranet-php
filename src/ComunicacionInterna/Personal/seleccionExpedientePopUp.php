<?php error_reporting(0); ?>
<?PHP
$nombrephp="fichaPersonal.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Seleccion Documentos </title>
<?php
	
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
}
?>


 <style> 
	 
	#opcionDocto {

    	margin: 1px 5px 5px 25px;
       
    }
	 
 </style>


</head>
<body>


<?php
	
$empleado = $_GET['empleado'];
$idEmpleado = $_GET['idEmpleado'];
$usuario = $usuarioId;	
	
	
$index = 0;
$index2 = 0;
$s = $INTRANET->Execute("SELECT xt_tipo_documento FROM SGI_CATALOGO_EXPEDIENTE_PERSONAL");
	
while($r = $s->fetchRow()){
	 $total[$index] = $r[0];
	$index++;
}

$seleccionado = array();	
$a = $INTRANET->Execute("SELECT CD.xt_tipo_documento FROM SGI_CATALOGO_EXPEDIENTE_PERSONAL CD WHERE
					CD.xt_tipo_documento IN (SELECT DISTINCT EP.xt_tipo_expediente FROM SGI_EXPEDIENTE_PERSONAL EP WHERE EP.xt_usuario_empleado = '$empleado')");
	
	
while($t = $a->fetchRow()){
	
	$seleccionado[$index2] = $t[0];
	$index2++;
}
	
echo "<br>";
echo "<form method='POST' action='procesaSeleccionExpediente.php' name='form'>";
	
	echo "<table width='100%'>";
		echo "<tr>";
			echo"<td align='center' id='titulo2'> Expediente </td>";
		echo "</tr>";
	
		echo "<tr>";
				echo "<td id='titleBlueLineTop' align='right'> </td>";
		echo "</tr>";
		echo "<tr height='10px'></tr>";
	
	echo "</table>";
	
	
	echo "<input type='hidden' name='empleado' value='$empleado'>";
	
	

	for($i=0;$i<count($total);$i++){

		if(count($seleccionado) > 0){
			if(in_array($total[$i], $seleccionado)){
				echo "<input id ='opcionDocto' type='checkbox' name='solicitud[]' checked='true' value='$total[$i]'/><label>".utf8_encode($total[$i])."</label>";
				echo "<br>";
				echo "<br>";
			}else{
				
				echo "<input id ='opcionDocto' type='checkbox' name='solicitud[]' value='$total[$i]'/><label>".utf8_encode($total[$i])."</label>";
				echo "<br>";
				echo "<br>";
			}

		}else{

			echo "<input id ='opcionDocto' type='checkbox' name='solicitud[]' value='$total[$i]'/><label>".utf8_encode($total[$i])."</label>";
			echo "<br>";
			echo "<br>";
		}


	}
	

	
	
	echo "<table width='100%'>";
	
		echo "<tr>";
				echo "<td id='titleBlueLineTop' align='right'> </td>";
		echo "</tr>";
	
		echo "<tr height='10px'></tr>";
	
		//echo "<tr align='right'><td><input type='submit' name='enviar' value='Enviar'></td></tr>";
		echo "<tr align='right'><td><input onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='65' type='image' height='29'></td></tr>";
	
	echo "</table>";
	

echo "</form>";
	
	
//obtengo valores del form

	
?>
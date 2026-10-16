<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

require_once("../conexionMasterDB.php");
require_once('../compruebaUsuario.php');

if(! in_array("altaOficinaUsuario", $listaFuncionalidades)){
	header("Location: https://escalante.com.mx/INTRA/error.php"); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	if($sesionEstilo == 1){
		echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
	}else if($sesionEstilo == 2){
		echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
	}
?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<script language="javascript" src="../js/jquery-1.2.6.min.js"></script>
  <script language="javascript">
$(document).ready(function(){
	$("#nombre").change(function(){
		$("#nombre option:selected").each(function(){
			nombre=$(this).val();
			$.post("UsuarioClienteOficina.php", { nombre: nombre }, function(data){
				$("#oficinas").html(data);
			});            
		});
	})

 $("#oficinas").change(function () {
            $("#oficinas option:selected").each(function () {
	            nombre=$("#nombre").val();
	            
		            oficina=$("#oficinas").val();
		            $.post("ClientesDisponibles.php", { oficina: oficina, nombre : nombre }, function(data){
		            $("#clientes").html(data);
		            });
	            });            
            });
       
        });
</script>
    

</head>
<body>
<?php
	
	if($_POST['usuario'] == ''){
					
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoCliente' method='post' action='agregaUsuarioClientes.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font> Alta Usuario Cliente</font>";
					echo"</td>";
				echo"</tr>";
				
				echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Usuario<br> ";
						  echo "<select name='usuario' id = 'nombre'>";
						  	echo "<option value='' selected='selected'></option>";
							$s = $MASTER_GE->Execute("select xt_usuario, xt_nombre from PERFILES.USUARIOS");
							while($r = $s->fetchRow()){
								echo "<option value='".$r[0]."'>$r[0] - $r[1]</option>";
							}
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
				
				echo"<tr height='10'></tr>";
				
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Oficina<br>";
						  echo "<select name='oficina' id='oficinas'>";
						  	//echo"<option selected='selected'> Selecionar... </option>";
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
				
				echo"<tr height='10'></tr>";
				
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Cliente<br>";
						  echo "<select name='cliente' id='clientes'>";
						  echo "<option value='' selected='selected'>Seleccionar ...</option>";
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='10'></tr>";
				
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";
	
	}else if($_POST['usuario'] != ''){
		
	$nombre = $_POST['usuario'];
	$oficina = $_POST['oficina'];
	$datos = $_POST['cliente'];
	list($idCliente, $rfc, $nombreCliente) = explode("-", $datos);
	
	echo "insert into PERFILES.CLIENTES (xt_usuario, xt_oficina, xn_clienteId, xt_rfc) values ('$nombre', '$oficina', '$idCliente','$rfc')";
	if($MASTER_GE->Execute("insert into PERFILES.CLIENTES (xt_usuario, xt_oficina, xn_clienteId, xt_rfc) values ('$nombre', '$oficina', '$idCliente','$rfc')")){
		
		echo "<table border='0' align='center' width='400px'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'> </td>";
				echo "</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td  align='center' width='400px' id='iconosTexto'><b>Carga Exitosa!! </b></td>";
				echo"</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
			echo "</table>";
	}else{
		echo "<table border='0' align='center' width='400px'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'> </td>";
				echo "</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td align='center' width='400px' id='iconosTexto'><b>Error en la carga </b></td>";
				echo"</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
			echo "</table>";
	}
}


?>

</body>
</html>

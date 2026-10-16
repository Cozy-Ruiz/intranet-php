<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");
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
<title>Alta Funcionalidad Usuario</title>

<script language="javascript" src="../JS/jquery-1.2.6.min.js"></script>
	
	<script language="javascript">
            $(document).ready(function(){
            $("#nombre").change(function () {
            $("#nombre option:selected").each(function () {
	            nombre=$("#nombre").val();
	            $.post("usuariOficina.php", { nombre: nombre }, function(data){
		            $("#oficinas").html(data);
	            });            
            });
           })
		   
		   $("#oficinas").change(function () {
            $("#oficinas option:selected").each(function () {
	            nombre=$("#nombre").val();
	            
		            oficina=$("#oficinas").val();
		            $.post("oficinaModulos.php", { oficina: oficina, nombre : nombre }, function(data){
		            $("#modulos").html(data);
		            });

		            modulo = '';
		            $.post("ConfiguracionModulos.php", {modulo:modulo, oficina: oficina, nombre : nombre }, function(data){
					$("#configuraciones").html(data);

				});
	            
	           });


            });
			
			 $("#modulos").change(function () {
            	$("#modulos option:selected").each(function () {
	            nombre=$("#nombre").val();
				oficina=$("#oficinas").val();
			
					modulo=$("#modulos").val();
					$.post("ConfiguracionModulos.php", {modulo: modulo, oficina: oficina, nombre : nombre }, function(data){
					$("#configuraciones").html(data);
					});
				});
			});          
			
       
        });
    </script>
	
</head>
<body>
<?php
if($_POST['funcionalidad'] == ''){	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoModulo' method='post' action='altaFuncionalidadUsuario.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font> Alta Funcionalidad Usuario</font>";
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
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Usuario<br> ";
						  echo "<select name='usuario' id='nombre'>";
						  	echo "<option value='' selected='selected'></option>";
							$s = $MASTER_GE->Execute("select xt_usuario, xt_nombre from PERFILES.USUARIOS");
							while($r = $s->fetchRow()){
								echo "<option value='".$r[0]."'>$r[0] - $r[1]</option>";
							}
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Oficina<br>";
						  echo "<select name='oficina' id='oficinas'>";
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Nombre Modulo<br>";
						  echo "<select name='modulo' id = 'modulos'>";
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Nombre Funcionalidad<br>";
						  echo "<select name='funcionalidad' id ='configuraciones'>";
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
}else if($_POST['funcionalidad'] != ''){
	$usuario = $_POST['usuario'];
	$oficina = $_POST['oficina'];
	$modulo = $_POST['modulo'];
	$funcionalidad = $_POST['funcionalidad'];
	
	if($MASTER_GE->Execute("insert into PERFILES.FUNCIONALIDADES (xt_usuario, xt_oficina, xt_modulo, xt_funcionalidad) values ('$usuario', '$oficina', '$modulo', '$funcionalidad') ")){
		echo "Carga Exitosa!! <br>";
	}else{
		echo "Error en la carga";
	}
}


?>

</body>
</html>

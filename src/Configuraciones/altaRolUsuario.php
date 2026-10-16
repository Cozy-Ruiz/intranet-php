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
<title>Alta Modulo Usuario</title>
<script language="javascript" src="../js/jquery-1.2.6.min.js"></script>
  <script language="javascript">
$(document).ready(function(){
	$("#nombre").change(function(){
		$("#nombre option:selected").each(function(){
			nombre=$(this).val();
			$.post("rolesDisponibles.php", { nombre: nombre }, function(data){
				$("#roles").html(data);
			});            
		});
	})
});
</script>
<script language="javascript" src="../js/jquery-1.2.6.min.js"></script> 

</head>
<body>
<?php
if($_POST['usuario'] == ''){	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoRol' method='post' action='altaRolUsuario.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font> Alta Rol Usuario</font>";
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
				echo "</tr>";
				
				echo"<tr height='5'></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						  echo "<select name='usuario' id = 'nombre'>";
						  	echo "<option value='' selected='selected'></option>";
							$s = $MASTER_GE->Execute("select xt_usuario, xt_oficina from PERFILES.OFICINAS order by xt_usuario");
							while($r = $s->fetchRow()){
								echo "<option value='".$r[0]."-".$r[1]."'>$r[0] - $r[1]</option>";
							}
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='20'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Roles<br>";
						  echo "<select name='roles' id='roles'>";
						  	//echo"<option selected='selected'> Selecionar... </option>";
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
				
				echo"<tr height='20'></tr>";
			
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
}else if($_POST['usuario'] != '' && $_POST['roles'] != ''){
	$rol = $_POST['roles'];
	$cadena = $_POST['usuario'];
	$cadena = trim($cadena);
	$cadena1 = explode("-", $cadena);
	strtoupper($cadena1[0]."-".$cadena1[1]);
	
	//echo"insert into PERFILES.ROLES (xt_usuario, xt_oficina, xt_rol) values ('$cadena1[0]', '$cadena1[1]', '$rol')";
	
	if($MASTER_GE->Execute("insert into PERFILES.ROLES (xt_usuario, xt_oficina, xt_rol) values ('$cadena1[0]', '$cadena1[1]', '$rol')")){
		
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
                <title>Nuevo Usuario</title>
            </head>
            <body>
    <?php
	
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
			//echo "<form name='altaNuevoUsuario' method='post' action=''>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Nuevo Usuario";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr><td> </td></tr>";
				
				echo"<tr height='70px'><td> </td></tr>";
			echo "</table>";
				
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='4'> </td>";
				echo "</tr>";
				
				echo"<tr height='15px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td width='30px'> </td>";
					echo "<td width='70px' align='left'>Usuario:</td>";
					echo "<td width='270px' align='left' id='iconosTexto'>".$cadena1[0]."</td>";
					echo "<td width='30px'> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Oficina:</td>";
					echo "<td align='left' id='iconosTexto'>".$cadena1[1]."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Rol:</td>";
					echo "<td align='left' id='iconosTexto'>".$rol."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr>";
					echo "<td  align='center' colspan='4' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td> </td>";
					echo "<td align='center' id='iconosTexto'>Cargado exitosamente!!!</td>";
				echo"</tr>";
				
			echo "</table>";
		echo "</div>";
		
		?>
                </body>
            </html>
        <?php
	
   }else{
		
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
                    <title>Usuario Rol Oficina</title>
                </head>
                <body>
        <?php
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Nuevo Usuario";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr><td> </td></tr>";
				
				echo"<tr height='70px'><td> </td></tr>";
			echo "</table>";
				
			echo "<table border='0' align='center' width='400px'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'> </td>";
				echo "</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td width='400px' id='iconosTexto'><b>Error en la carga!!!</b></td>";
				echo"</tr>";
				
				echo"<tr height='15px'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
			echo "</table>";
		echo "</div>";
		
		?>
                </body>
            </html>
        <?php
		
	}
	
}
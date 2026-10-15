<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

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
<title>Alta Proceso Usuario</title>

<script language="javascript" src="../js/jquery-1.2.6.min.js"></script>
	<script language="javascript">
            $(document).ready(function(){
            $("#nombre").change(function () {
            $("#nombre option:selected").each(function () {
	            nombre=$("#nombre").val();
	            $.post("usuarioActividadesDisponible.php", { nombre: nombre }, function(data){
		            $("#actividades").html(data);
	            });            
            });
           })       
        });
    </script>
   

</head>
<body>
<?php
if($_POST['actividad'] == ''){	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoModulo' method='post' action='altaActividadesUsuario.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Alta Actividades Usuario</font>";
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
						  echo "<select name='usuario' id='nombre'>";
						  	echo "<option value='' selected='selected'></option>";
							$s = $MASTER_GE->Execute("select distinct * from PERFILES.PROCESOS P ORDER BY P.xt_usuario");
							while($r = $s->fetchRow()){
								echo "<option value='".$r[0]."-".$r[1]."-".$r[2]."-".$r[3]."-".$r[4]."'>$r[0] - $r[1] - $r[2] - $r[3] - $r[4]</option>";
							}
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
			/*
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Oficina<br>";
						  echo "<select name='oficina' id='oficinas'>";
						  	//echo"<option selected='selected'> Selecionar... </option>";
						  echo "</select>";
					echo "</td>";
				echo"</tr>";
				
				*/
				echo"<tr height='10'></tr>";
							
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
					echo "Actividad<br> ";
				echo "</tr>";
				
				echo"<tr height='5'></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						  echo "<select name='actividad' id = 'actividades'>";
						  //echo "<option selected='selected'>Selecionar...</option>";
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
}else if($_POST['actividad'] != ''){
	$actividad = $_POST['actividad'];
	$usuario = $_POST['usuario'];
	$usuario = trim($usuario);
	$datos = explode("-", $usuario);
	strtoupper($datos[0]."-".$datos[1]."-".$datos[2]."-".$datos[3]."-".$datos[4]);
	
//echo"insert into PERFILES.ACTIVIDADES (xt_usuario, xt_oficina, xt_rol, xt_modulo, xt_proceso, xt actividad) values ('$datos[0]', '$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', '$actividad') ";
	if($MASTER_GE->Execute("insert into PERFILES.ACTIVIDADES (xt_usuario, xt_oficina, xt_rol, xt_modulo, xt_proceso, xt_actividad) values ('$datos[0]', '$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', '$actividad')  ")){
		
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
                <title>Actividad Usuario</title>
            </head>
            <body>
    <?php
	
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Actividad Usuario";
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
					echo "<td width='270px' align='left' id='iconosTexto'>".$datos[0]."</td>";
					echo "<td width='30px'> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Oficina:</td>";
					echo "<td align='left' id='iconosTexto'>".$datos[1]."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Rol:</td>";
					echo "<td align='left' id='iconosTexto'>".$datos[2]."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Modulo:</td>";
					echo "<td align='left' id='iconosTexto'>".$datos[3]."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Proceso:</td>";
					echo "<td align='left' id='iconosTexto'>".$datos[4]."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Actividad:</td>";
					echo "<td align='left' id='iconosTexto'>".$actividad."</td>";
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
                    <title>Actividad Usuario</title>
                </head>
                <body>
        <?php
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Actividad Usuario";
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
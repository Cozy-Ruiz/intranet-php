<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../ConexionDBT.php");
require_once('../compruebaUsuario.php');
require_once("../ConexionIntranet2.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Nuevo Rol</title>

</head>
<body>
<?php

//defino el consecutivo para tabla SGI_Roles
$indexConsecutivo = 0;
$listRoles = $INTRANETV2->Execute('SELECT RIGHT(xt_codigo,3) FROM SGI_Catalogo_Roles');
while($c = $listRoles->fetchRow()){
	$contadorC[$indexConsecutivo] = $c[0];
	$indexConsecutivo ++;
		
}
	$sigConsecutivo = count($contadorC)+1;
	$lenSig = strlen($sigConsecutivo); 

if($lenSig == 1){
	
	$claveR = "R00".$sigConsecutivo;
	
}

if($lenSig == 2){
	
	$claveR = "R0".$sigConsecutivo;
	
}

if($lenSig == 3){
	
	$claveR = "R".$sigConsecutivo;
	
}



if($_POST['claveRol'] == ''){	
	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoRol' method='post' action='AgregarNuevoRol.php'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font> Nuevo Rol</font>";
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
					echo "Clave Rol<br>
						  <input type='text' size=50 maxlength=100 name='claveRol' value='$claveR' readonly='readonly'>";
					echo "</td>";
				echo"</tr>";
			
				echo"<tr height='10'></tr>";
			
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Nombre Rol <br>
							<input type='text' size=50 name='descripcionRol'>";
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";
			
				/*echo "<tr id='iconosTexto2'>";
				echo "<td align='center'>";
				echo "Proceso<br>";
					$listProcesos = $INTRANET->Execute('SELECT kp_codigo, xt_nombre FROM SGI_Procesos');
                     echo "<center><select name='proceso' id='proceso'>";
                     	while($b = $listProcesos->fetchRow()){
							$codigoProceso = $b[0];
                        	$nomProceso = $b[1];

                             echo "<option value='$codigoProceso'>$nomProceso</option>";
                            
                         }
                    echo "</select>";
					echo "</td>";
				echo "</tr>"; */
				
			
				echo"<tr height='15'></tr>";
			
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
}else if($_POST['claveRol'] != ''){
	
	
			
	  $cvRol = $_POST['claveRol'];
	  $nomRol = $_POST['descripcionRol'];
	 //$cvProceso = $_POST['proceso'];
	
	 //$codProcesoRol = $cvProceso."_".$cvRol;
	
	
	
	//inserto en tabla roles
	
	$insertRol = $INTRANETV2->Execute("INSERT INTO SGI_Catalogo_Roles VALUES ('$cvRol', '$nomRol')");
	
	//inserto en tabla SGI_Procesos_Roles
	
	//$insertProRol = $INTRANET->Execute("INSERT INTO SGI_Procesos_Roles VALUES ('$codProcesoRol', '$cvProceso', '$cvRol')");
	
	
		
	?>
		
		<script type="text/javascript">
		
		//window.opener.top.location.reload("http://escalante.com.mx/Sistemas/radar/1899/fichaBocar.php?referencia=15-409528&guia=1711769450&rfc=AUM9207011CA");
	window.opener.top.location="tableroRoles.php";
window.close();
	</script>
		
		
		<?php
	/*$s = $MASTER_GE->Execute("select max(xn_indice) from PERFILES.CATALOGO_ROLES");
	while($r = $s->fetchRow()){
		$indiceRol = $r[0];
	}
	
	if($indiceRol == null){
		$indiceRol = 0;
	}
	
	$indiceRol++;
	//echo"insert into PERFILES.CATALOGO_ROLES (xn_indice, xt_modulo, xt_descripcion) values ($indiceRol, '$nombreRol', '$descripcionRol') ";
	
	if($MASTER_GE->Execute("insert into PERFILES.CATALOGO_ROLES (xn_indice, xt_rol, xt_descripcion) values ($indiceRol, '$nombreRol', '$descripcionRol') ")){
		
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
                <title>Alta Rol</title>
            </head>
            <body>
    <?php
	
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Alta Rol";
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
					echo "<td width='70px' align='left'>Rol:</td>";
					echo "<td width='270px' align='left' id='iconosTexto'>".$nombreRol."</td>";
					echo "<td width='30px'> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td width='70px' align='left'>Descripcion:</td>";
					echo "<td width='300px' align='left' id='iconosTexto'>".$descripcionRol."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr>";
					echo "<td  align='center' colspan='4' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td> </td>";
					echo "<td width='300px' align='center' id='iconosTexto'>Cargado exitosamente!!!</td>";
				echo"</tr>";
				
				echo"<tr height='100px'><td colspan='4'> </td></tr>";
				
				echo "<tr>";
				echo "<td></td>";
				echo "<td align='center'><input name='button' type='button' onclick='window.close();' value='Cerrar' /></td>";
				echo "<td></td>";
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
                    <title>Alta Rol</title>
                </head>
                <body>
        <?php
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Alta Rol";
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
					echo "<td width='400px' id='iconosTexto' align='center'><b>Error en la carga!!!</b></td>";
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
		
	}*/
}//fin del if else



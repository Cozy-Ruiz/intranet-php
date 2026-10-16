<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

require_once("../conexionMasterDB.php");
require_once('../compruebaUsuario.php');
/*
if(! in_array("altaNuevoUsuario", $listaFuncionalidades)){
	header("Location: https://escalante.com.mx/INTRA/error.php"); 
}

require_once('mailAltaUsuario.php');

$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN"; 
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
*/
if($_POST['nombreUsuario'] == '' && $_POST['usuario'] == '' && $_POST['password'] == '' && $_POST['categoria']== ''){
	
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
		echo "<form name='altaNuevoUsuario' method='post' action=''>";
	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font> Nuevo Usuario</font>";
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
				/*
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Nombre<br><br> ";
						echo "<select name='nombreUsuario'>";
							echo "<option value=''>Seleccionar...</option>";
							
							$s= $MASTER_GE->Execute("SELECT kp_personalId, xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM IntranetGEA.SGI_Empleados ORDER BY xt_nombre ");
							
							while($r = $s->fetchRow()){
								$nombreU = $r[1]." ".$r[2]." ".$r[3];
								echo"<option value='".$r[0]."'>".$nombreU."</option>";
								
							} unset($r); unset ($s);
							
						echo"</select>";
					echo "</td>";
				echo"</tr>";
				
				echo"<tr height='10'></tr>";
				*/
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Usuario <br><br>
							<input type='text' size=50 name='usuario'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Password <br><br>
							<input type='text' size=50 name='password'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Nombre <br><br>
							<input type='text' size=50 name='nombreUsuario'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Correo <br><br>
							<input type='text' size=50 name='email'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				/*
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Ciudad <br><br>";
						echo "<select name='ciudad'>";
							echo "<option value=''>Elegir...</option>";
							for($o = 1; $o <= 6; $o++){
								echo "<option value='".$cdValor[$o]."'>".$ciudades[$o]."</option>";
							}
						echo "</select>";
						
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='10'></tr>";
				*/
				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Categoria <br><br>";
							echo "<select name='categoria'>";
								echo '<option selected="selected" value="">Selecciona Categoria...</option>';
								$s = $MASTER_GE->Execute("select xt_categoria from PERFILES.CATEGORIAS_USUARIOS");
								while($r = $s->fetchRow()){
									$categoria = $r[0];
									echo '<option value="'.$categoria.'">'.$categoria.'</option>';
								}
							echo '</select>';
					echo "</td>";
				echo "</tr>";
				
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
	
	?>
    		</body>
    	</html>
    <?php
	
	
	
}else if($_POST['nombreUsuario'] != '' && $_POST['usuario'] != '' && $_POST['password'] != '' && $_POST['categoria'] != ''){
	
	$nombreIdUsr 	= $_POST['nombreUsuario'];
	$usuario 		= $_POST['usuario'];
	$password 		= $_POST['password'];
	$categoria 		= $_POST['categoria'];
	$correo 		= $_POST['email'];
	/*
	$s= $MASTER_GE->Execute("SELECT xt_nombre, xt_ApellidoPaterno, xt_ApellidoMaterno FROM IntranetGEA.SGI_Empleados WHERE kp_personalId = $nombreIdUsr ");
						
	while($r = $s->fetchRow()){
		
		$nombreUsuario = $r[0]." ".$r[1]." ".$r[2];
		
	} unset($r); unset ($s);
	*/
													 
	if($MASTER_GE->Execute("INSERT INTO PERFILES.USUARIOS (xt_usuario, xt_password, xt_nombre, xt_categoria, xt_correo, xn_estilo, xt_estatus) 
													 VALUES ('$usuario', '$password', '$nombreIdUsr', '$categoria', '$correo', 1, 'Activo') ")){
	/*												 
	echo "Carga Exitosa!! <br>";
	}else{
		echo "Error en la carga";
	}
	
}
			
		$MASTER_GE->Execute("INSERT INTO IntranetGEA_Usuarios_Oficina (kf_usuarioId, xt_codigoCiudad)
															  VALUES ('$usuario', '$ciudad') ");
		*/													
		/*$MASTER_GE->Execute("UPDATE IntranetGEA.SGI_Empleados SET kf_usuario = '$usuario' WHERE kp_personalId = $nombreIdUsr ");
		
		$listaPHPSG = array(
							"AccionesPreventivasyCorrectivas.php",
							"Auditorias.php",
							"Boletines.php",
							"busquedaPersonal.php",
							"Capitulo.php",
							"CapituloNorma.php",
							"comunicacionInterna.php",
							"Documento.php",
							"downloadAuditoria.php",
							"downloadBoletin.php",
							"downloadItem.php",
							"downloadPreventivasCorrectivas.php",
							"downloadQuejaSolicitud.php",
							"downloadReunion.php",
							"downloadRevision.php",
							"downloadRevisionSolicitudesQuejas.php",
							"downloadSeguimiento.php",
							"downloadSeguimientoSolicitudQueja.php",
							"fichaAcuerdo.php",
							"FichaAuditoria.php",
							"fichaBoletin.php",
							"fichaCorrectiva.php",
							"fichaIssue.php",
							"FichaItem.php",
							"fichaPersonal.php",
							"fichaPreventiva.php",
							"fichaQueja.php",
							"fichaReunion.php",
							"fichaRevision.php",
							"fichaRevisionCorrectiva.php",
							"fichaRevisionPreventiva.php",
							"fichaRevisionQuejaSolicitud.php",
							"fichaSolicitud.php",
							"fichaVisita.php",
							"Home.php",
							"homeSGI.php",
							"Mail.php",
							"manuales.php",
							"Modulos.php",
							"Normas.php",
							"Registros.php",
							"ReunionesyAcuerdos.php",
							"SolicitudesyQuejas.php",
							"tableroAcuerdos.php",
							"tableroAuditorias.php",
							"TableroBoletines.php",
							"tableroPersonal.php",
							"tableroPreventivasCorrectivas.php",
							"tableroReuniones.php",
							"tableroSeguimientos.php",
							"tableroSolicitudesyQuejas.php",
							"TableroVisitas2.php",
							"downloadRegistro.php",
							"fichaRegistro.php",
							"tableroRegistros.php"
						);
						
		foreach ($listaPHPSG as $pagina) {
			//echo "INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$pagina','$nombreUsuario') <br>";
			$MASTER_GE->Execute("INSERT INTO IntranetGEA.IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$pagina','$usuario') ");
		}
				if($correo != ""){
		
			$MASTER_GE->Execute("UPDATE PERFILES.USUARIOS SET xt_correo = '$correo' 
								WHERE kp_usuario = '$usuario' AND xt_password = '$password' AND xt_nombre = '$nombreUsuario' AND kf_categoria = '$categoria' ");
								
			new MailAltaUsuario($usuario, $nombreUsuario, $categoria, $correo, $MASTER_GE);
			
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
                    <title>Nuevo Usuario</title>
                </head>
                <body>
        <?php
	*/	
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
					echo "<td width='70px' align='left'>Nombre:</td>";
					echo "<td width='270px' align='left' id='iconosTexto'>".$nombreIdUsr."</td>";
					echo "<td width='30px'> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Usuario:</td>";
					echo "<td align='left' id='iconosTexto'>".$usuario."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Password:</td>";
					echo "<td align='left' id='iconosTexto'>".$password."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='4'> </td></tr>";
				
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Correo:</td>";
					echo "<td align='left' id='iconosTexto'>";
						if($correo != ""){
							echo $correo;
						} else{
							echo "N/D";
						}
					echo "</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='15px'><td colspan='4'> </td></tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo "<td> </td>";
					echo "<td align='left'>Usuario:</td>";
					echo "<td align='left' id='iconosTexto'>".$categoria."</td>";
					echo "<td> </td>";
				echo"</tr>";
				
				echo"<tr height='15px'><td colspan='4'> </td></tr>";
				
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
                    <title>Nuevo Usuario</title>
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




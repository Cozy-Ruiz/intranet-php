<?php error_reporting(0); ?>
<?php
$nombrephp="altaPersonal.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");

// save old value
$saved = getenv("LD_LIBRARY_PATH");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("LD_LIBRARY_PATH=$newld");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

function limpiar_caracter_especial($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );


    return $string;
}

if(($_POST['nombre'] || $_POST['apellidoPaterno']|| $_POST['estatus']||$_POST['tipo']|| $_POST['empresa']) == (''|| NULL) || $_POST['ciudad'] == "" ){
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Alta de Personal</title>
            <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        </head>
        
        <body>
<?php
	
echo "<div id='wrapperPopUp'>";
  echo "<form name='altaPersonal' method='POST' action='altaPersonal.php' enctype='multipart/form-data'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Alta de Acceso</font>";
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
	//FOTO
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Foto</td>";
			echo "<td  align='left' >";
				echo "<input id='FileCron' type='file' size='35' name='archivo'>";
			echo"</td>";
		echo "</tr>";

	
		echo"<tr height='10'> </tr>";
	//NUMERO DE PERSONAL
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>N° de personal</td>";
			echo "<td  align='left' >";
				echo "<input type='text' size='20' maxlength='250' name='numPersonal'>";
			echo"</td>";
		echo "</tr>";

	
		echo"<tr height='10'> </tr>";
		
	//NOMBRE
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Nombre</td>";
			echo "<td align='right'><input type='text' size='50' maxlength='100' name='nombre'></td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
	//APELLIDO PATERNO
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Apellido paterno</td>";
			echo "<td  align='right'>";
				echo "<input type='text' size='50' maxlength='100' name='apellidoPaterno'>";
			echo"</td>";
		echo "</tr>";

		echo"<tr height='10'> </tr>";
		
	//APELLIDO MATERNO
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Apellido materno</td>";
			echo "<td  align='right'>";
				echo "<input type='text' size='50' maxlength='100' name='apellidoMaterno'>";
			echo"</td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
	//ESTATUS
			echo "<tr align='left' height='20'>";
				echo "<td id='iconosTexto2' align='left'>Estatus: </td>";
				echo "<td align='left'>";
					echo "<select name='estatus' size='1'>";
						echo "<option value='' selected>Elegir </option>";
						echo "<option value='1'>Activo</option>";
						echo "<option value='2'>Inactivo</option>";
					echo "</select>";			
			echo "</tr>";	
			echo"<tr height='10'> </tr>";	
			
	//TIPO
			echo "<tr align='left' height='20'>";
				echo "<td id='iconosTexto2' align='left'>Tipo: </td>";
				echo "<td align='left'>";
					echo "<select name='tipo' size='1'>";
						echo "<option value='0' selected>Elegir </option>";
						echo "<option value='E' >Empleado </option>";
						echo "<option value='P'>Proveedor</option>";
						echo "<option value='C'>Cliente</option>";
						echo "<option value='V'>VIP</option>";
						echo "<option value='D'>Directiva</option>";
						echo "<option value='A'>Autoridad</option>";
					echo "</select>";			
			echo "</tr>";	
			echo"<tr height='10'> </tr>";	
			
	//EMPRESA
		echo "<tr align='left' height='20' >";
			echo "<td id='iconosTexto2' align='left'>Empresa</td>";
			echo "<td  align='right' >";
				echo "<input type='text' size='50' maxlength='100' name='empresa'>";
			echo"</td>";
		echo "</tr>";	
		
		echo"<tr height='10'> </tr>";
		
	//CIUDAD
		$ciudades[1] = "Distrito Federal";
		$ciudades[2] = "Nuevo Laredo";
		$ciudades[3] = "Cancún";
		$ciudades[4] = "Veracruz";
		$ciudades[5] = "Toluca";
		$ciudades[6] = "Laredo";
		$ciudades[7] = "Cuernavaca";
		
		$cdValor[1] = "DF";
		$cdValor[2] = "NLR";
		$cdValor[3] = "CUN"; 
		$cdValor[4] = "VER";
		$cdValor[5] = "TOL";
		$cdValor[6] = "LAR";
		$cdValor[7] = "CVC";
		
		echo "<tr align='left' height='20'>";
			echo "<td id='iconosTexto2' align='left'>Ciudad: </td>";
			echo "<td align='left'>";
				echo "<select name='ciudad' size='1'>";
					echo "<option value=''>Elegir...</option>";
					for($o = 1; $o <= 6; $o++){
						echo "<option value='".$cdValor[$o]."' >".$ciudades[$o]."</option>";
					}
				echo "</select>";			
		echo "</tr>";
			
		echo"<tr height='10'> </tr>";	
		
		echo "<tr>";
			echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'> </td>";
		echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right' colspan='2'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo"</td>";
		echo"</tr>";
				
	echo "</table>";
	
	echo "</form>";
echo "</div>";
}else if(($_POST['nombre']&& $_POST['apellidoPaterno']&& $_POST['estatus']&& $_POST['tipo']&& $_POST['empresa']) != ('' && NULL) && $_POST['ciudad'] != ""){
	
	$numPersonalInsert = ($_POST['numPersonal']);
	if(strlen($numPersonalInsert)==1){
		$numPersonalInsert="000".$numPersonalInsert;
	}else if(strlen($numPersonalInsert)==2){
		$numPersonalInsert="00".$numPersonalInsert;
	}else if(strlen($numPersonalInsert)==3){
		$numPersonalInsert="0".$numPersonalInsert;
	}else if(strlen($numPersonalInsert)==4){
		
	}
	$nombreInsert = $_POST['nombre'];
	
	$apellidoPInsert = ($_POST['apellidoPaterno']);
	
	$apellidoMInsert = ($_POST['apellidoMaterno']);
	
	$estatusInsert = ($_POST['estatus']);
	
	$tipoInsert = ($_POST['tipo']);
	
	$empresaInsert= $_POST['empresa'];
	
	$ciudadInsert = $_POST['ciudad'];
	
	
	if($INTRANET->Execute("INSERT INTO SGI_Empleados(xt_Nombre,xt_ApellidoPaterno,xt_Estatus,xt_tipo,xt_Empresa, xt_ciudad) VALUES ('$nombreInsert ', '$apellidoPInsert', $estatusInsert,'$tipoInsert','$empresaInsert', '$ciudadInsert')")){
		
		//$IDpersonal= mysql_insert_id();
		$IDpersonal = $INTRANET->getOne("SELECT MAX(kp_personalId) FROM SGI_Empleados");
		
		if ($numPersonalInsert != ""){
		
				$INTRANET->Execute("UPDATE SGI_Empleados SET xt_NumPersonal='$numPersonalInsert' WHERE kp_personalId=$IDpersonal");
		
	   }
	   if ($apellidoMInsert != ""){
		
				$INTRANET->Execute("UPDATE SGI_Empleados SET xt_ApellidoMaterno='$apellidoMInsert' WHERE kp_personalId=$IDpersonal");
		
	   }
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
		$destino = "FILES/".$archivo;
		
			if (move_uploaded_file($_FILES['archivo']['tmp_name'],$destino))
			{	
				$INTRANET->Execute("UPDATE SGI_Empleados SET xn_Foto='$destino' WHERE kp_personalId=$IDpersonal");
			}
	   }
	   
	   ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8">
                    <title>Alta de Personal</title>
                    <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <script type="text/javascript">
                        function redireccionar(){
						<?php
							echo "opener.location.href=\"https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/Personal/fichaPersonal.php?ID=$IDpersonal\";";
						?>
                            window.close();
                        };
                    </script>
                </head>
                
                <body>
        <?php
	   
		echo "<script type='text/javascript'>redireccionar()</script>";	
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8">
                    <title>Alta de Personal</title>
                    <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <script type="text/javascript">
                        function reCargarPadre(){
                            opener.location.reload();
                            window.close();
                        }
                    </script>
                </head>
                
                <body>
        <?php
		echo "<div id='wrapperPopUp'>";
		  echo "<form name='altaPersonal' method='post' action='altaPersonal.php'>";	
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "<font>Personal No Agregado</font>";
					echo"</td>";
				echo"</tr>";
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='reCargarPadre()' src='../../Imagenes/ICN_BotonFinalizar.png' width='90' height='29'>";
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
</htm
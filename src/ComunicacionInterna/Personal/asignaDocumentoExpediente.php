<?php error_reporting(0); ?>
<?php
//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'AgregarNuevoRol.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');
require_once("../../ConexionIntranet2.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
<title>Asigna documento expediente</title>
<script>
	function revisaArticulo(){
		selectArticulo = document.getElementsByName('selectArticulo')[0].value;
		if(selectArticulo == 'CAMPO EN BLANCO'){
			document.getElementById('nuevoArticulo').style.display = "grid";
		}else{
			document.getElementById('nuevoArticulo').style.display = "none";
		}
	}
</script>

</head>
<body>
<?php

//defino el consecutivo para tabla SGI_Roles
$indexConsecutivo = 0;
$catalogoExpediente = $INTRANET->Execute("SELECT * FROM sgi_catalogo_expediente_personal");
//var_dump($catalogoArticulos);

if($_POST['selectTipoDocumento'] != ''){
	/*
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		echo "<pre>";
		var_dump($_FILES);
		echo "</pre>";
	
		if (isset($_FILES['inputDocumento'])) {
			$error = $_FILES['inputDocumento']['error'];
			switch ($error) {
				case UPLOAD_ERR_OK:
					echo "Archivo recibido correctamente.";
					break;
				case UPLOAD_ERR_INI_SIZE:
					echo "El archivo excede el tamaño máximo permitido por `upload_max_filesize` en `php.ini`.";
					break;
				case UPLOAD_ERR_FORM_SIZE:
					echo "El archivo excede el tamaño máximo permitido por el formulario HTML.";
					break;
				case UPLOAD_ERR_PARTIAL:
					echo "El archivo solo se cargó parcialmente.";
					break;
				case UPLOAD_ERR_NO_FILE:
					echo "No se seleccionó ningún archivo.";
					break;
				default:
					echo "Error desconocido: $error";
					break;
			}
		} else {
			echo "No se recibió ninguna información en \$_FILES.";
		}
	}*/

	$uploadDir = 'Expedientes/'.$_REQUEST['usuario'].'/';
    
	if (!file_exists($uploadDir)) {
		if (!mkdir($uploadDir, 0777, true)) {
			echo "<script>alert('No se pudo crear la carpeta de destino.');</script>";
			exit;
		}
	}

    if (isset($_FILES['inputDocumento'])) {
        $nombreArchivo = $_FILES['inputDocumento']['name'];
        $rutaArchivo = $uploadDir . basename($nombreArchivo);

        if (move_uploaded_file($_FILES['inputDocumento']['tmp_name'], $rutaArchivo)) {

            $usuario = $_REQUEST['usuario'];
            $tipoDocumento = $_POST['selectTipoDocumento'];
            $usuarioRegistro = $_SESSION['sesionUsuario'];

            $query = "INSERT INTO sgi_expediente_personal (xt_usuario_empleado, xt_tipo_expediente, xt_nombre_archivo, xt_ruta_archivo, xt_usuario_registro) 
                      VALUES ('$usuario', '$tipoDocumento', '$nombreArchivo', '$rutaArchivo', '$usuarioRegistro')";
            
            if ($INTRANET->Execute($query)) {
				echo "<script type='text/javascript'>
					window.opener.top.location.reload(true);
					window.close();
				</script>";
			} else {
				// Capturar el error de la base de datos
				$error = $INTRANETV2->ErrorMsg();
				echo "<script type='text/javascript'>
					alert('Error al registrar el documento en la base de datos. Consulta: $query. Error: $error');
				</script>";
			}
        } else {
            echo "<script type='text/javascript'>
                alert('Error al mover el archivo al destino.');
            </script>";
        }
		
    } else {
        echo "<script type='text/javascript'>
            alert('No se ha recibido ningún archivo o ha ocurrido un error.');
        </script>";
    }
	
}else if($_REQUEST['usuario'] != ''){	

	echo "<div id='wrapperPopUp'>";
		echo "<form name='nuevoRol' method='post' enctype='multipart/form-data' action='asignaDocumentoExpediente.php?usuario=".$_REQUEST['usuario']."'>";

			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
					echo "<font>Asigna documento expediente</font>";
					echo"</td>";
				echo"</tr>";
			
				echo"<tr></tr>";	
			
				echo"<tr height='70'> </tr>";
			echo "</table>";
			
			echo "<table border='0' align='center'>";
				
				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Tipo documento<br>";
						echo "<select name='selectTipoDocumento' onchange='revisaArticulo();'>";

						foreach($catalogoExpediente as $registro){
							echo "<option value='".$registro['xt_tipo_documento']."'>".$registro['xt_tipo_documento']."</option>";
						}

						echo "</select>";	

					echo "</td>";
				echo "</tr>";

				echo"<tr height='10'></tr>";

				echo "<tr id='iconosTexto2'>";
					echo "<td align='center'>";
						echo "Documento<br>
							<input type='file' accept='application/pdf, image/*' name='inputDocumento'>";
					echo "</td>";
				echo "</tr>";
				
				
				echo"<tr height='10'></tr>";
				
			
				echo"<tr height='15'></tr>";
			
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='submit' value='Aceptar asignación' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";	
			
			echo "</table>";				
		echo "</form>";
	echo "</div>";

}
?>


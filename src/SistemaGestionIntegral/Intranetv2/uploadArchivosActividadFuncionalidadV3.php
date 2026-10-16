<?php
//require_once("../ConexionDBT.php");
require_once("../ConexionIntranet2.php");

error_reporting(0);
 $codigo           = $_GET['codigo'];
//$actividad        = $_GET['actividad'];
//$proceso          = $_GET['proceso'];
 $usuario          = $_GET['usuario'];
 $nombrephp        = $_GET['nombrephp'];
 $tipoArchivo      = $_GET['tipoArchivo'];
//$rol              = $_GET['rol'];
//$itemId           = $_GET['itemId'];
$fecha            = date('Y-m-d H:m:s');

$estiloUsuario    = $INTRANETV2->getOne("SELECT xn_estilo FROM IntranetGEA.IntranetGEA_USUARIOS WHERE kp_usuario = '$usuario' ");

if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../Backlog/css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../Backlog/css/styleHomePage2.css'/>";
}

?>
<!DOCTYPE html>
<html lang='es'>
	<meta charset='utf-8'>
	<head>
		<title>Envio de Archivos</title>
		<script type="text/javascript">
			function reloadFuncionalidadCasoUso(nombre){
				var codigo   = '<?php echo $codigo; ?>';
				parent.window.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/'+nombre + "?codigo="+codigo;
			}
			function reloadCasoUso(nombre){
				var codigo   = '<?php echo $codigo; ?>';
				parent.window.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/'+nombre + "?codigo="+codigo;
			}
			function reload(nombre){
				var proceso   = '<?php echo $proceso; ?>';
				var actividad = '<?php echo $actividad; ?>';
				var rol       = '<?php echo $rol; ?>';
				parent.window.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/'+nombre + "?proceso="+proceso+"&actividad="+actividad+"&rol="+rol;
			}
			function reloadEntregable(nombre){
				var proceso   = '<?php echo $proceso; ?>';
				var actividad = '<?php echo $actividad; ?>';
				var rol       = '<?php echo $rol; ?>';
				var usuario   = '<?php echo $usuario; ?>'; 
				var nombrephp = '<?php echo $nombrephp; ?>';
				parent.window.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/'+nombre + "?proceso="+proceso+"&actividad="+actividad+"&rol="+rol;
			}
			function SubmitForm(form){

			}
			function reloadItem(nombre){
				var codigo   = '<?php echo $codigo; ?>';
				<?php
					$s = $INTRANETV2->Execute("
						SELECT
							(
								SELECT
									CONCAT(
										U.xt_Nombre,
										' ',
										U.xt_ApellidoPaterno,
										' ',
										U.xt_ApellidoMaterno
									)
								FROM
									IntranetGEA.SGI_Empleados U
								WHERE
									U.kf_usuario = SL.xt_usuario
							),
							SL.xd_fecha
						FROM
							INTRANET2.SGI_Libera_Inventarios SL
						WHERE
							SL.xt_codigo = '".$codigo."'
						AND 
						SL.xt_tipo = 'Proceso'
						");
					
					while($r = $s->fetchRow()){
						
						$usuarioLibera = $r[0];
						$fechaLibera   = $r[1];
						
					} unset($r);				
					if ($usuarioLibera != NULL && $usuarioLibera != ''){
				?>
						parent.window.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/controlCambiosv4.php?proceso=' + codigo;
				<?php
					} else {

				?>
						parent.window.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/'+nombre + "?proceso="+codigo;
				<?php
					}
				?>
			}
		</script>
	</head>
	<body>
		<section>
			<article>

				<form form='UploadLaredo' method='POST' action='uploadArchivosActividadFuncionalidadV3.php?tipoArchivo=<?php echo $tipoArchivo; ?>&codigo=<?php echo $codigo; ?>&usuario=<?php echo $usuario; ?>&nombrephp=<?php echo $nombrephp;?>' id='myform'enctype='multipart/form-data'>
					<table border='0' align='center' width='700px' height='40px'>
                        <tr>
                            <td width='30'> </td>
                            <td width='20'> </td>
                            <td valign='bottom' align='left' colspan='2'>
                                 <input type="file" name='files[]' multiple='multiple'>
                            </td>
                            <td width='20'> </td>
                        </tr>
                
                    </table>
                    <table border='0' align='center' width='700px'>
                                
                        <tr height='5'>
                    
                            <td valign='bottom' align='right' colspan='2' id='iconosTexto2'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'></td>
                            <td width='20'> </td>
                        </tr>
                  
                    </table>
				</form>
			
			</article>
		</section>
	</body>
</html>

<?php
//***************************** Verificamos que en formulario tenga algun archivo para guardar *********************************************************
if($nombrephp == 'fichaProcesov2.php'){
	
	if(count($_FILES['files']['tmp_name']) != 0){
			
		$TipoArchivo = preg_replace('[\s+]',"_", $tipoArchivo);
	
		$carpetaCrear1 = "D:/INTRANET/documentosSGI/".trim($codigo)."/";

		if(!file_exists($carpetaCrear1)){///Creamos la carpeta del codigo de solicitud
			mkdir($carpetaCrear1, 0777, true);
		
		}
	
		for($a=0;$a<count($_FILES['files']['name']);$a++){
			
			$nombre   = $_FILES['files']['name'][$a];
			$extension = pathinfo($_FILES['files']['name'][$a],PATHINFO_EXTENSION);
			
			//$conta = 0;
			
		
			$total = $INTRANETV2->getOne("SELECT count(xt_archivo) FROM SGI_Documentacion 
			WHERE xt_codigoProceso = '$codigo' AND xt_tipo = '$tipoArchivo'");
			
			
			   $total1 = $INTRANETV2->getOne("SELECT xt_archivo FROM SGI_Documentacion 
			WHERE xt_codigoProceso = '$codigo' AND xt_tipo = '$tipoArchivo'");
			
			
			if($total == 1 && $total1 == ''){
				$total2 = 0;				
			}else if($total == 1 && $total1 != ''){
				$total2 = 1;
			}else if($total > 1 && $total1 != ''){
				$total2 = $total;
			}
				
			$nombre   = $codigo."_".$TipoArchivo."_".$total2.".".$extension;
			$rutaCompleta = $carpetaCrear1.$nombre;
			
			$mover = move_uploaded_file($_FILES['files']['tmp_name'][$a], $rutaCompleta);
			
			//echo $total."---".$indice."----".$nombre;
			if($total == 1 && $total1 == ''){
					//echo"UPDATE SGI_Documentos_Actividades_Funcionalidades_CasosdeUso SET xt_nombreArchivo = '$nombre', xt_rutaArchivo = '$rutaCompleta' WHERE xt_codigo = '$codigo' AND xt_tipoDocumento = '$tipoArchivo'";
				
				//echo"UPDATE SGI_Documentos_Procesos SET xt_nombreArchivo = '$nombre', xt_rutaArchivo = '$rutaCompleta' WHERE xt_codigo = '$codigo' AND xt_tipoDocumento = '$tipoArchivo'<br><br>";
				$INTRANETV2->Execute("UPDATE SGI_Documentacion SET xt_archivo = '$nombre', xt_ruta = '$rutaCompleta' WHERE xt_codigoProceso = '$codigo' AND xt_tipo = '$tipoArchivo'");
				
			} else if($total == 1 && $total1 != ''){
				
				
				
				$INTRANETV2->Execute("INSERT INTO SGI_Documentacion (xt_codigoProceso, xt_tipo, xt_archivo, xt_ruta, xt_usuario) VALUES ('$codigo','$tipoArchivo','$nombre','$rutaCompleta','$usuario')");
				
			} else if($total > 1 && $total1 != ''){
				//echo"NSERT INTO SGI_Documentos_Procesos (xt_codigo, xt_tipoDocumento, xt_nombreArchivo, xt_rutaArchivo,xt_usuario, xd_fecha) VALUES ('$codigo','$tipoArchivo','$nombre','$rutaCompleta','$usuario','$fecha')<br><br>";
				//echo"INSERT INTO SGI_Documentos_Actividades_Funcionalidades_CasosdeUso (xt_codigo, xt_tipoDocumento, xt_nombreArchivo, xt_rutaArchivo,xt_usuario, xd_fecha) VALUES ('$codigo','$tipoArchivo','$nombre','$rutaCompleta','','$fecha')";
				$INTRANETV2->Execute("INSERT INTO SGI_Documentacion (xt_codigoProceso, xt_tipo, xt_archivo, xt_ruta, xt_usuario) VALUES ('$codigo','$tipoArchivo','$nombre','$rutaCompleta','$usuario')");
			}

	
			?>
				<script>	
					
					reloadItem('<?php echo $nombrephp; ?>');
					
				</script>
				 
		   <?php

		}
	
	}
	
}
?>
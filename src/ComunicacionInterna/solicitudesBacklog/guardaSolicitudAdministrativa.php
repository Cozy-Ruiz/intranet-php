<?php error_reporting(0); ?>
<?php
$nombrephp='guardaSolicitudAdministrativa.php';
require_once("../../ConexionDBT.php");

$fechaInsert 	= date('Y-m-d', strtotime($_POST['fecha']));
$tituloInsert 	= $_POST['titulo'];
$ciudad 		= $_POST['ciudad'];
$grupoInsert	= $_POST['grupo'];
$usuario        = $_POST['usuario'];


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

$descripcionInsert = " ";

if($_POST['descripcion'] != ""){
	
	$descripcionInsert = $_POST['descripcion'];
}


$anio = date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
						 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-B-DF-14-001
	if(($ciudad != "")/* && ($ciudad != "GEN")*/){
		
		$codigo = $grupoInsert."-B-".$ciudad."-";
		
	} else{
		
		$codigo = $grupoInsert."-B-";
		
	}
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-0000".$maximo;
		
	}else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-000".$maximo;
	}else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-00".$maximo;
	}else if(strlen($maximo) == 4){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	}else if(strlen($maximo) >= 5){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status) 
												   VALUES('AV', 'B', '$ciudad', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$usuario', '$grupoInsert', 'SIN ASIGNAR') ")){
													   
		$solicitudID = $INTRANET->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_tipo = 'B' AND xt_ciudad = '$ciudad' 
									  AND xn_numero = '$maximo' AND xt_quejaSolicitud = '$codigo' AND xt_grupo = '$grupoInsert' ");
									  
		$INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) 
																VALUES('$solicitudID', 1, 'SIN ASIGNAR', '$fechaInsert', '$usuarioId') ");
									  
										  
		//$solicitudNumero = $INTRANET->getOne("SELECT xn_numero FROM SGI_Quejas_Solicitudesv2 WHERE kp_quejaSolicitudID = '$codigo' ");
		
		//new MailIntraNet($usuario, $ciudad, $tituloInsert, $descripcionInsert, $solicitudNumero, $tipo);
		
		$archivo = $_FILES['archivo']['name'];
		$archivo = limpiar_caracter_especial($archivo);
		
		if ($archivo != ""){
			
			$destino = "../SugerenciaQueja/".$archivo;
			
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
				
				if($INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_ruta = '$archivo' WHERE xt_quejaSolicitud = '$codigo' ") ){
					
					//header("Location: fichaSolicitud.php?id=$solicitudID");
					
				}


			}
			
		}
	?>
      <!-- recargo pagina -->
      <script language="javascript">
          window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaSolicitudv2.php?coodigo=<?php echo $solicitudID; ?>"
      </script>
  <?php  
  }




/*

$anio = date('Y', strtotime($_POST['fecha']));

$maximo = 0;

$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
						 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupoInsert' ");

while($r = $s->fetchRow()){
	
	$maximo = $r[0];
	
} unset($r); unset($s);

$maximo++;

//GENERACION DEL CODIGO
//GE-B-DF-14-001
if(($ciudad != "") && ($ciudad != "GEN")){
	
	$codigo = $grupoInsert."-B-".$ciudad."-";
	
} else{
	
	$codigo = $grupoInsert."-B-";
	
}

$anio = date('y', strtotime($_POST['fecha']));

if(		  strlen($maximo) == 1){
	
	$codigo = $codigo.$anio."-00".$maximo;
	
} else if(strlen($maximo) == 2){
	
	$codigo = $codigo.$anio."-0".$maximo;
	
} else if(strlen($maximo) == 3){
	
	$codigo = $codigo.$anio."-".$maximo;
	
}

if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo) 
												   VALUES('AV', 'B', '$ciudad', $maximo, '$fechaInsert', '$codigo', '$tituloInsert', '$descripcionInsert', '$usuario', '$grupoInsert') ")){
	
	$solicitudID = $INTRANET->getOne("SELECT xt_quejaSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_tipo = 'B' AND xt_ciudad = '$ciudad' 
									  AND xn_numero = '$maximo' AND xt_quejaSolicitud = '$codigo' AND xt_grupo = '$grupoInsert' ");
									  
	$solicitudNumero = $INTRANET->getOne("SELECT xn_numero FROM SGI_Quejas_Solicitudesv2 WHERE kp_quejaSolicitudID = $solicitudID ");

?>
      <!-- recargo pagina -->
      <script language="javascript">
          window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaSolicitudv2.php?coodigo=<?php echo $solicitudID; ?>"
      </script>
  <?php  	

 }
?>*/
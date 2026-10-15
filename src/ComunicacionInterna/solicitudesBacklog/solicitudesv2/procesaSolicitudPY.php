<?php error_reporting(0); ?>
<?php
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");

if(isset($_POST['titulo'])){
	
	$usuarioId   = $_POST['usuario'];
	
	 $fecha = $_POST['fecha'];
	 $grupo = $_POST['grupo'];
	 $ciudad = $_POST['ciudad'];
	 $titulo = $_POST['titulo'];
	 $descripcion = $_POST['descripcion'];
	 $sistema = $_POST['sistema'];
	 $prioridad = $_POST['prioridad'];
	 $codWBS = $_POST['wbs'];
	
	//defino el codigo de la solicitud
	$anio   = date('Y', strtotime($_POST['fecha']));
	$maximo = 0;
	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupo' ");
				while($r = $s->fetchRow()){	
					$maximo = $r[0];	
				} unset($r); unset($s);
							
	$maximo++;
	$año   = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		@$codigoNuevo = $codigo."-0000".$maximo;
	}else if(strlen($maximo) == 2){		
		@$codigoNuevo = $codigo."-000".$maximo;		
	}else if(strlen($maximo) == 3){		
		@$codigoNuevo = $codigo."-00".$maximo;		
	}else if(strlen($maximo) == 4){		
		@$codigoNuevo = $codigo."-0".$maximo;		
	}else if(strlen($maximo) >= 5){		
		@$codigoNuevo = $codigo."-".$maximo;		
	}
	//Se crea codigo para la Solicitud
	  $codigoSolicitud = $grupo."-"."B"."-".$ciudad."-".$año.$codigoNuevo;
	
	if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_pdr, xt_wbs) VALUES('PY', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuarioId', '$grupo', 'SIN ASIGNAR', 'Rodrigo_Romo', '$codWBS')")){
														   
		$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Prioridad(xt_quejaSolicitud, xt_prioridad, xt_usuario) VALUES ('$codigoSolicitud','$prioridad','$usuarioId')");
		
		//Envia a correo al PDR y Solicitante
		 
		if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES('$codigoSolicitud', 1, 'SIN ASIGNAR', '$fecha', '$usuarioId') ")){
				
			//pongo la validacion por default en aprobada
			//inserto en tabla de verificacones
			$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Validaciones (xt_quejaSolicitud, xt_status, xt_tipoValidacion, xt_usuario, xt_comentario) VALUES ('$codigoSolicitud', 'ACEPTADA', 'PROYECTO', 'Rodrigo_Romo', '')");
		
			//inserto en la tabla de ubicacón (en este caso no sera un sistema sino el nombre del proyecto)
			$INTRANETV2->Execute("INSERT INTO SGI_Backlog_Ubicacion (xt_quejaSolicitud, xt_sistema) VALUES ('$codigoSolicitud', '$sistema')");
			
			//inserto en la tabla de relacion proyecto con solicitud
			if($sistema == 'Desarrollo Link_S'){
				
				$INTRANETV2->Execute("INSERT INTO SGI_Proyecto_Solicitud (xt_quejaSolicitud, xt_codigoProyecto) VALUES ('$codigoSolicitud', 'GE-FF-2014-0025')");
				
			}			
			//actualizo status en la tabla de solicitudes
			$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'ACEPTADA' WHERE xt_quejaSolicitud = '$codigoSolicitud'");													
														
			?>
            <!-- recargo pagina -->
            <script language="javascript">
                window.location="https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?codigo=<?php echo $codigoSolicitud; ?>"
            </script>
 			<?php

		}
	}
		
}

?>
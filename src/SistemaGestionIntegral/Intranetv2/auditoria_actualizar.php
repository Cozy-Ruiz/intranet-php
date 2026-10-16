<?php
//incluyo los archivos necesarios
$nombrephp = 'AuditoriaActualizar.php';
require_once("../../ConexionIntranet2.php");
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
//la clave que recibo por POST la guardo en una variable para su uso en todo el codigo
error_reporting(E_PARSE);
if(!empty($_POST['clave'])){
	$clave = $_POST['clave'];
} else if(!empty($_GET['clave'])){
	$clave = $_GET['clave'];
}
//creo una funcion para cambiar el estatus de las auditorias
function actualizarStatusAuditoria($clave, $INTRANETV2){
	$contadorHallazgos = 0;
	$contadorAccionesCorrectivas = 0;
	$contadorSolicitudesTerminadas = 0;
	$contadorCorrectivaTerminada = 0;
	$contadorPreventivaTerminada = 0;

	$statusAuditoria = $INTRANETV2->getOne("	
			SELECT
				xt_status
			FROM
				SGI_Auditorias 
			WHERE 
				xt_claveAuditoria = '$clave'
		");

	$d = $INTRANETV2->Execute("SELECT xt_claveHallazgo, xt_titulo, xd_fecha, xt_ruta FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave'");
	while($registroHallazgos = $d->fetchRow()) {
		$claveHallazgo[$contadorHallazgos]  = $registroHallazgos[0];
		$tituloHallazgo[$contadorHallazgos] = $registroHallazgos[1];
		$fechaHallazgo[$contadorHallazgos]  = $registroHallazgos[2];
		$rutaHallazgo[$contadorHallazgos]  = $registroHallazgos[3];
		$c = $INTRANETV2->Execute("SELECT xt_claveTratamiento, xt_tipoTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$claveHallazgo[$contadorHallazgos]'");
		while($registroTratamientos = $c->fetchRow()) {
			$claveTratamiento = $registroTratamientos[0];
			$tipoTratamiento = $registroTratamientos[1];

			if($tipoTratamiento == 'SOLICITUD'){
				$terminado = $INTRANETV2->getOne("
						SELECT
							xt_status
						FROM
							SGI_Quejas_Solicitudesv2
						WHERE
							xt_quejaSolicitud = '$claveTratamiento'
					");				
				if($terminado == 'TERMINADA'){
					$contadorSolicitudesTerminadas++;
				}
			} else if ($tipoTratamiento == 'PREVENTIVA'){
				$terminado = $INTRANETV2->getOne("
						SELECT
							xn_status
						FROM
							SGI_Acciones_Preventivas_Correctivas
						WHERE
							xt_claveAccion = '$claveTratamiento'
					");				
				if($terminado == 1){
					$contadorPreventivaTerminada++;
				}
			} else if ($tipoTratamiento == 'CORRECTIVA'){
				$terminado = $INTRANETV2->getOne("
						SELECT
							xn_status
						FROM
							SGI_Acciones_Preventivas_Correctivas
						WHERE
							xt_claveAccion = '$claveTratamiento'
					");				
				if($terminado == 1){
					$contadorCorrectivaTerminada++;
				}
			}
			$contadorAccionesCorrectivas++;
		}
		$contadorHallazgos++;
	}
	$contadorAccionesCorrectivasTerminadas = $contadorPreventivaTerminada + $contadorCorrectivaTerminada + $contadorSolicitudesTerminadas;			
	if($statusAuditoria == 2){
		if ($contadorAccionesCorrectivas == $contadorAccionesCorrectivasTerminadas){
			$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_status = '4' WHERE xt_claveAuditoria = '".$clave."'");
		} else {
			$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_status = '2' WHERE xt_claveAuditoria = '".$clave."'");
		}
	} else if ($statusAuditoria == 3){
		if ($contadorAccionesCorrectivas == $contadorAccionesCorrectivasTerminadas){
			$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_status = '3' WHERE xt_claveAuditoria = '".$clave."'");
		}
	}
}

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

//ejecuto la funcion creada
actualizarStatusAuditoria($clave, $INTRANETV2);
//consulto fechas
$fechas = $INTRANETV2->getArray("SELECT xd_fecha, xd_fechaInicio, xd_fechaFinalizacion FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$clave."'");
//si recibo datos de fecha hago el formateo correcto
if (!empty($fechas[0][0])){
	if(date('Y-m-d', strtotime($fechas[0][0]))>date('Y-m-d', strtotime("2000-01-01"))){	
		$fechaHoraProgramada = $fechas[0][0];
		$fechaHoraProgramada = date('Y-m-d H:i', strtotime($fechaHoraProgramada));
	}
}

if (!empty($fechas[0][1])){
	if(date('Y-m-d', strtotime($fechas[0][1]))>date('Y-m-d', strtotime("2000-01-01"))){	
		$fechaHoraInicio = $fechas[0][1];
		$fechaHoraInicio = date('Y-m-d H:i', strtotime($fechaHoraInicio));
	}
}

if (!empty($fechas[0][2])){
	if(date('Y-m-d', strtotime($fechas[0][2]))>date('Y-m-d', strtotime("2000-01-01"))){
		$fechaHoraFinalizacion = $fechas[0][2];
		$fechaHoraFinalizacion = date('Y-m-d H:i', strtotime($fechaHoraFinalizacion));
	}
}
//defino diferentes consultas para traerme los catalogos necesarios
$condicion = $INTRANETV2->getOne("
		SELECT 
			xt_tipo
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");

$personaAprueba = $INTRANETV2->getOne("
		SELECT 
			xt_nombreAprueba
		FROM
			SGI_Auditorias_Planes
		WHERE
			xt_claveAuditoria = '$clave'
	");

$comentarioAprueba = $INTRANETV2->getOne("
		SELECT 
			xt_comentarioAprueba
		FROM
			SGI_Auditorias_Planes
		WHERE
			xt_claveAuditoria = '$clave'
	");

$fechaAprueba = $INTRANETV2->getOne("
		SELECT 
			xd_fechaAprueba
		FROM
			SGI_Auditorias_Planes
		WHERE
			xt_claveAuditoria = '$clave'
	");
$personaRealizo = $INTRANETV2->getOne("
		SELECT 
			xt_nombreRealizo
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");
$comentarioRealizo = $INTRANETV2->getOne("
		SELECT 
			xt_comentarioRealizo
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");
$fechaRealizo = $INTRANETV2->getOne("
		SELECT 
			xd_fechaRealizo
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");

$personaTermina = $INTRANETV2->getOne("
		SELECT 
			xt_nombreTermina
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");

$comentarioTermina = $INTRANETV2->getOne("
		SELECT 
			xt_comentarioTermina
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");

$fechaTermina = $INTRANETV2->getOne("
		SELECT 
			xd_fechaTermina
		FROM
			SGI_Auditorias
		WHERE
			xt_claveAuditoria = '$clave'
	");

if(isset($_POST["programa"])){
	$programa = $_POST["programa"];
	//echo "Programa: $programa";
	$existeP = $INTRANETV2->getOne("SELECT * FROM SGI_Auditorias_Planes WHERE 
				xt_claveAuditoria = '$clave'");

	if (empty($existeP)) {
			$INTRANETV2->Execute("
			INSERT INTO
				SGI_Auditorias_Planes(xt_claveAuditoria, xt_descripcion) VALUES('$clave', '$programa')");
	}elseif(!empty($existeP)){
			$INTRANETV2->Execute("
			UPDATE 
				SGI_Auditorias_Planes
			SET 
				xt_descripcion = '$programa' 
			WHERE 
				xt_claveAuditoria = '$clave'
		");
	}

}

if($_POST["informe"]){	
	$informeAuditoria = $_POST["informe"];
	echo "Informe: $informeAuditoria";
	$existeI = $INTRANETV2->getOne("SELECT * FROM SGI_Auditorias_Informes WHERE 
				xt_claveAuditoria = '$clave'");

	if (empty($existeI)) {
	$INTRANETV2->Execute("
			INSERT INTO
				SGI_Auditorias_Informes(xt_claveAuditoria, xt_descripcion) VALUES('$clave', '$informeAuditoria')");
	}elseif (!empty($existeI)) {
	$INTRANETV2->Execute("
			UPDATE 
				SGI_Auditorias_Informes
			SET 
				xt_descripcion = '$informeAuditoria' 
			WHERE 
				xt_claveAuditoria = '$clave'
		");
	}
}

$personaElaboraPlan = $INTRANETV2->getOne("	
		SELECT
			xt_nombreElabora
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$comentarioElaboraPlan = $INTRANETV2->getOne("	
		SELECT
			xt_comentarioElabora
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$fechaElaboraPlan = $INTRANETV2->getOne("	
		SELECT
			xd_fechaElabora
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$personaRevisaPlan = $INTRANETV2->getOne("	
		SELECT
			xt_nombreRevisa
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$comentarioRevisaPlan = $INTRANETV2->getOne("	
		SELECT
			xt_comentarioRevisa
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$fechaRevisaPlan = $INTRANETV2->getOne("	
		SELECT
			xd_fechaRevisa
		FROM
			SGI_Auditorias_Planes
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$status = $INTRANETV2->getOne("	
		SELECT
			xn_status
		FROM
			SGI_Auditorias_Planes 
		WHERE 
			xt_claveAuditoria = '$clave'
	");
$statusAuditoria = $INTRANETV2->getOne("	
		SELECT
			xt_status
		FROM
			SGI_Auditorias 
		WHERE 
			xt_claveAuditoria = '$clave'
	");
if(!empty($_POST['elimina'])){
	$registrosSeleccionados = $_POST['elimina'];
	$cantidadSeleccionada = count($registrosSeleccionados);
    for($i=0; $i < $cantidadSeleccionada; $i++){
		$fecha = $registrosSeleccionados[$i];
	
		$INTRANETV2->Execute("
				DELETE FROM 
					SGI_Auditorias_Agenda
				WHERE
					(xt_claveAuditoria = '$clave')
				AND
					(xd_fechaAuditoria = '$fecha')
			");
    }
}
if(@$_POST['existeH'] ==  'si'){

	$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'Si' WHERE xt_claveAuditoria = '".$clave."'");
	
} else if(@$_POST['existeH'] ==  'no'){

	$INTRANETV2->Execute("UPDATE SGI_Auditorias SET xt_hallazgo = 'No' WHERE xt_claveAuditoria = '".$clave."'");
}
$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tablero_auditoria.php' id='breadcrumbs'> Auditorías </a>";
$bandera = 0;
$objetivosP = $INTRANETV2->getOne("SELECT xt_objetivosAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$tituloAuditoria = $INTRANETV2->getOne("SELECT  xt_titulo FROM  SGI_Auditorias  WHERE  xt_claveAuditoria  = '".$clave."'");

 


$alcanceP 	= $INTRANETV2->getOne("SELECT xt_alcanceAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$index = 0;
$conjuntoRegistroCriterios = $INTRANETV2->Execute("
	SELECT DISTINCT
		SCN.xt_codigoNorma, SCN.xt_nombreNorma, SAC.xt_tipo
	FROM
		SGI_Auditorias_Criterios SAC
	INNER JOIN 
		SGI_Catalogo_Normas SCN
	ON 
		SAC.xt_codigoNorma = SCN.xt_codigoNorma
	WHERE
		SAC.xt_claveAuditoria = '".$clave."'
	AND
		SAC.xt_tipo = 'I'	
	");
while($registroCriterio = $conjuntoRegistroCriterios->fetchRow()){
	$codigoNorma[$index]   = $registroCriterio[0];
	$nombreNorma[$index]   = $registroCriterio[1];
	$tipoNorma[$index]     = $registroCriterio[2];
	$index++;
}

$riesgosP 	= $INTRANETV2->getOne("SELECT xt_riesgosAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$recursosP  = $INTRANETV2->getOne("SELECT xt_recursosAuditoria FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$index = 0;

$conjuntoRegistroEquipo = $INTRANETV2->Execute("
	SELECT DISTINCT
		SCA.xt_claveAuditor , SCA.xt_nombreAuditor
	FROM
		SGI_Auditorias_Equipos SAE
	INNER JOIN 
		SGI_Catalogo_Auditores SCA
	ON 
		SCA.xt_claveAuditor = SAE.xt_claveAuditor
	WHERE
		SAE.xt_claveAuditoria = '".$clave."'
	");
while($registroEquipo = $conjuntoRegistroEquipo->fetchRow()){
	$claveAuditor[$index]    = $registroEquipo[0];
	$nombreAuditor[$index]   = $registroEquipo[1];
	$index++;
}

$contador = 0;
$conjuntoRegistroAgenda = $INTRANETV2->Execute("
		SELECT
			xt_manualAuditoria,
			xt_codigoManual
		FROM 
			SGI_Auditorias_Agenda
		WHERE
			xt_claveAuditoria = '".$clave."'
		AND
			xt_tipo = 'PROGRAMA'
	");
while($registroAgenda = $conjuntoRegistroAgenda->fetchRow()){
	$manualAuditoria[$contador] = $registroAgenda[0];
	$codigoManual[$contador] = $registroAgenda[1];
	$contador++;
}

$contador = 0;
$conjuntoAuditoresAgenda = $INTRANETV2->Execute("
		SELECT
			xt_nombreAuditor,
			xd_fechaAuditoria,
			xt_codigoManual,
			xt_claveAuditor
		FROM 
			SGI_Auditoria_Agenda_Auditores
		WHERE
			xt_claveAuditoria = '".$clave."'
		AND
			xt_tipo = 'PROGRAMA'
	");
while($registroAuditorAgenda = $conjuntoAuditoresAgenda->fetchRow()){
	$auditorAgenda[$contador] = utf8_encode( $registroAuditorAgenda[0]);
	$fechaAuditoria[$contador] = $registroAuditorAgenda[1];
	$codigoManualAuditor[$contador] = $registroAuditorAgenda[2];
	$auditorClave[$contador]= $registroAuditorAgenda[3];
 	$contador++;
}

$contador = 0;
$conjuntoRegistroAgendaInforme = $INTRANETV2->Execute("
		SELECT
			xt_manualAuditoria,
			xt_codigoManual
		FROM 
			SGI_Auditorias_Agenda
		WHERE
			xt_claveAuditoria = '".$clave."'
		AND
			xt_tipo = 'INFORME'
	");
while($registroAgendaInforme = $conjuntoRegistroAgendaInforme->fetchRow()){
	$manualAuditoriaInforme[$contador] = $registroAgendaInforme[0];
	$codigoManualInforme[$contador] = $registroAgendaInforme[1];
	$contador++;
}


$contador = 0;
$conjuntoAuditoresAgendaInforme = $INTRANETV2->Execute("
		SELECT
			xt_nombreAuditor,
			xd_fechaAuditoria,
			xt_codigoManual,
			xt_claveAuditor
		FROM 
			SGI_Auditoria_Agenda_Auditores
		WHERE
			xt_claveAuditoria = '".$clave."'
		AND
			xt_tipo = 'INFORME'
	");
while($registroAuditorAgendaInforme = $conjuntoAuditoresAgendaInforme->fetchRow()){
	$auditorAgendaInforme[$contador] = $registroAuditorAgendaInforme[0];
	$fechaAuditoriaInforme[$contador] = $registroAuditorAgendaInforme[1];
	$codigoManualAuditorInforme[$contador] = $registroAuditorAgendaInforme[2];
	$codigoAuditorInforme[$contador] = $registroAuditorAgendaInforme[3];
	$contador++;
}

$contador = 0;
$conjuntoAuditadosAgendaInforme = $INTRANETV2->Execute("
		SELECT
			xt_auditado,
			xd_fecha,
			xt_puestoAuditado,
			xt_puntoAuditado,
			xt_codigoManual,
			xt_claveAuditor
		FROM 
			SGI_Auditorias_Auditados
		WHERE
			xt_claveAuditoria = '".$clave."'
	");

while($registroAuditadosAgendaInforme = $conjuntoAuditadosAgendaInforme->fetchRow()){
	$auditadoInforme[$contador] = $registroAuditadosAgendaInforme[0];
	$fechaAuditadoInforme[$contador] = $registroAuditadosAgendaInforme[1];
	$puestoAuditadoInforme[$contador] = $registroAuditadosAgendaInforme[2];
	$puntoAuditadoInforme[$contador] = $registroAuditadosAgendaInforme[3];
	$codigoManualAuditadoInforme[$contador] = $registroAuditadosAgendaInforme[4];
	$codigoAuditorAuditoInforme[$contador] = $registroAuditadosAgendaInforme[5];
	$contador++;
}

$ciudad = $INTRANETV2->getOne("
        SELECT 
            CASE xt_ciudad
            WHEN 'DF' THEN
                'CMX'
            ELSE    xt_ciudad
            END AS ciudad,
            CASE
            WHEN xt_ciudad IN ('CMX','DF') THEN
                    'Ciudad de México'
            WHEN xt_ciudad = 'TOL' THEN
                    'Toluca'
            WHEN xt_ciudad = 'VER' THEN
                    'Veracruz'
            WHEN xt_ciudad = 'NLR' THEN
                    'Nuevo Laredo'
            WHEN xt_ciudad = 'CUN' THEN
                    'Cancún'
            END AS valorCiudad
        FROM 
            SGI_Auditorias
        WHERE
    		xt_claveAuditoria = '".$clave."'
    ");

$auditorLiderP 	= $INTRANETV2->getOne("SELECT xt_nombreAuditor FROM SGI_Auditorias_Equipos WHERE xt_claveAuditoria = '".$clave."' AND xt_auditorLider = '1'");

$usuarioAuditorLiderP 	= $INTRANETV2->getOne("SELECT xt_usuarios FROM SGI_Auditorias_Equipos WHERE xt_claveAuditoria = '".$clave."' AND xt_auditorLider = '1'");

$statusPlan		= $INTRANETV2->getOne("SELECT xn_status FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$rutaP 		= $INTRANETV2->getOne("SELECT xt_ruta FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."'  AND xt_tipoDocumento = 'PROGRAMA'");


$rutaA 		= $INTRANETV2->getOne("SELECT xt_ruta FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."'  AND xt_tipoDocumento = 'ASISTENCIA'");

$rutaM 		= $INTRANETV2->getOne("SELECT xt_ruta FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."'  AND xt_tipoDocumento = 'MANUALES'");

$nombreArchivoAsistencia = $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_ruta,'/',-1)FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."' AND xt_tipoDocumento = 'ASISTENCIA'");

$nombreArchivoManual = $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_ruta,'/',-1)FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."' AND xt_tipoDocumento = 'MANUALES'");

$idArchivoAsistencia = $INTRANETV2->getOne("SELECT xt_id  FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."' AND xt_tipoDocumento = 'ASISTENCIA'");

$nombreArchivoPlan = $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_ruta,'/',-1)FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."' AND xt_tipoDocumento = 'PROGRAMA'");
$idArchivoPlan = $INTRANETV2->getOne("SELECT xt_id  FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."' AND xt_tipoDocumento = 'PROGRAMA'");

$programa	= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Planes WHERE xt_claveAuditoria = '".$clave."'");

$objetivosI = $INTRANETV2->getOne("SELECT xt_cumplimientoObjetivos FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$comentarioAgenda = $INTRANETV2->getOne("SELECT xt_comentarioAgenda FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$index = 0;
$conjuntoRegistroCumplimientoCriterios = $INTRANETV2->Execute("
	SELECT DISTINCT
		SCN.xt_codigoNorma, SCN.xt_nombreNorma, SAC.xt_tipo
	FROM
		SGI_Auditorias_Criterios SAC
	INNER JOIN 
		SGI_Catalogo_Normas SCN
	ON 
		SAC.xt_codigoNorma = SCN.xt_codigoNorma
	WHERE
		SAC.xt_claveAuditoria = '".$clave."'
	AND
		SAC.xt_tipo = 'I'
	");
while($registroCumplimientoCriterio = $conjuntoRegistroCumplimientoCriterios->fetchRow()){
	$codigoNormaCumplimiento[$index]   = $registroCumplimientoCriterio[0];
	$nombreNormaCumplimiento[$index]   = $registroCumplimientoCriterio[1];
	$tipoNormaCumplimiento[$index]     = $registroCumplimientoCriterio[2];
	$index++;
}

$conclusion = $INTRANETV2->getOne("SELECT xt_conclusionAuditoria FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$auditorLiderInforme = $INTRANETV2->getOne("SELECT xt_auditorLider FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$comentarioPersona = $INTRANETV2->getOne("SELECT xt_comentariosPersona FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$hallazgos = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '".$clave."'");

$rutaI 		= $INTRANETV2->getOne("SELECT xt_ruta FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."'  AND xt_tipoDocumento = 'INFORME'");

$informe = $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Auditorias_Informes WHERE xt_claveAuditoria = '".$clave."'");

$nombreArchivoInforme = $INTRANETV2->getOne("SELECT SUBSTRING_INDEX(xt_ruta,'/',-1)FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."' AND xt_tipoDocumento = 'INFORME'");	
$idArchivoInforme = $INTRANETV2->getOne("SELECT xt_id FROM SGI_Auditorias_Documentos WHERE xt_claveAuditoria = '".$clave."' AND xt_tipoDocumento = 'INFORME'");		   
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
		<title>Actualizar Auditoría</title>
		<?php
		if($estiloUsuario == 1){
			echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
		} else if($estiloUsuario == 2){
			echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
		}
		?>
        <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <style>
        	table.procede{
			    display: table;
			    border-collapse: separate;
			    border-spacing: 2px;
			    border-color: grey;
        	}
        	tr.procedeFila{
    		    text-align: -webkit-center;
    		    display: table-row;
			    vertical-align: inherit;
			    border-color: inherit;
        	}
        	td.procedeColumna {
				display: table-cell;
				vertical-align: inherit;
				text-align: -webkit-center;
			    background-color: rgb(66, 203, 39);
        	}
	    </style>
        <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
		<script language="javascript" type="text/javascript">


			function enabledprograma()
			{
				$("#programa").prop('disabled', false);
			    document.getElementById('inputprograma').style.display="block";
				document.getElementById('editprograma').style.display="none"; 

			}

			function disableprograma()
			{
				$("#programa").prop('disabled', true);
				document.getElementById('editprograma').style.display="block";
				document.getElementById('inputprograma').style.display="none"; 

			}

			function enabledinforme()
			{

				$("#informe").prop('disabled', false);
			    document.getElementById('inputinforme').style.display="block";
				document.getElementById('editinforme').style.display="none"; 
			}

			function disabledinforme()
			{
				$("#informe").prop('disabled', true);
				document.getElementById('editinforme').style.display="block";
				document.getElementById('inputinforme').style.display="none"; 

			}

        function showBanana(valor){
            if(valor == 1){
                document.getElementById("banana1").style.display="inline-block";
                document.getElementById("banana0").style.display="none";
                document.getElementById("mapaIntranet").style.display="inline-block";
            } else if (valor == 0){
                document.getElementById("banana1").style.display="none";
                document.getElementById("banana0").style.display="inline-block";
                document.getElementById("mapaIntranet").style.display="none";
            }
        }

			function actualizarFicha(clave){
				window.location = 'auditoria_actualizar.php?clave=' + clave;
			}	        
	        function ilumina(celda, tipo){
	            celda1 = document.getElementById(celda);
	    
	            var clave ="<?php echo $clave;?>";
	            var auditor = "<?php echo $usuarioId;?>";
	            var fecha = new Date();
	            fecha = fecha.getFullYear()+"/"+(fecha.getMonth()+1)+"/"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes();
				
				if(tipo == 'ValidacionElaborar'){
					var comentario = document.getElementById('valElaboraComentarioVerif').value;
					
					document.getElementById("contValidaElabora").style.display="none";
		   			document.getElementById("cargaValidaElabora").style.display="block";
		
					if(celda == 'valElaboraProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valElaboraNoProcede').style.backgroundColor = 'red';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al elaborar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresElabora&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&procede=1&fecha="+fecha);
					}
			
					if(celda == 'valElaboraNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valElaboraProcede').style.backgroundColor  = 'red';
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al elaborar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresElabora&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&procede=0&fecha="+fecha);
					}
				}else if(tipo == "ValidacionRevisar"){
					var comentario = document.getElementById('valRevisaComentarioVerif').value;
					var auditorAprueba = '<?php echo $auditorLiderP; ?>';

					document.getElementById("contValidaRevisa").style.display="none";
		   			document.getElementById("cargaValidaRevisa").style.display="block";
					
					if(auditorAprueba){
						if(celda == 'valRevisaProcede'){
							celda1.style.backgroundColor  = '#42CB27';
							document.getElementById('valRevisaNoProcede').style.backgroundColor = 'red';
							var xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function() {
								if (xhttp.readyState == 4 && xhttp.status == 200) {
									if(xhttp.responseText == true){
										actualizarFicha(clave);
									}else{
										alert("Hubo un error al revisar la ficha.");
									}
								}
							};
							xhttp.open("POST", "agregaValores.php", true);
							xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhttp.send("evento=agregarValoresRevisar&clave="+clave+"&auditor="+auditorAprueba+"&comentario="+comentario+"&procede=1&fecha="+fecha);
						}
				
						if(celda == 'valRevisaNoProcede'){
							celda1.style.backgroundColor  = '#42CB27';
							document.getElementById('valRevisaProcede').style.backgroundColor  = 'red';
							var xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function() {
								if (xhttp.readyState == 4 && xhttp.status == 200) {
									if(xhttp.responseText == true){
										actualizarFicha(clave);
									}else{
										alert("Hubo un error al revisar la ficha.");
									}
								}
							};
							xhttp.open("POST", "agregaValores.php", true);
							xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhttp.send("evento=agregarValoresRevisa&clave="+clave+"&auditor="+auditorAprueba+"&comentario="+comentario+"&procede=0&fecha="+fecha);
						}
					} else {
						alert("El auditor lider de no puede estar vacio.");
						actualizarFicha(clave);
					}
				}else if(tipo == "ValidacionAprobar"){
					var comentario = document.getElementById('valApruebaComentarioVerif').value;
					
					document.getElementById("contValidaAprueba").style.display="none";
		   			document.getElementById("cargaValidaAprueba").style.display="block";
		
					if(celda == 'valApruebaProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valApruebaNoProcede').style.backgroundColor = 'red';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al aprobar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresAprobar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&procede=1&fecha="+fecha);
					}
			
					if(celda == 'valApruebaNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valApruebaProcede').style.backgroundColor  = 'red';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al aprobar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresAprobar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&procede=0&fecha="+fecha);
					}
				}else if(tipo == "ValidacionTerminarExterna"){
					var comentario = document.getElementById('valTerminaExternaComentarioVerif').value;
					
					document.getElementById("contValidaTerminaExterna").style.display="none";
		   			document.getElementById("cargaValidaTerminaExterna").style.display="block";
		
					if(celda == 'valTerminaExternaProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al terminar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresTerminar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&fecha="+fecha+"&finalizada=4");
					}
			
				}else if(tipo == "ValidacionTerminarInterna"){
					var comentario = document.getElementById('valTerminaInternaComentarioVerif').value;
					
					document.getElementById("contValidaTerminaInterna").style.display="none";
		   			document.getElementById("cargaValidaTerminaInterna").style.display="block";
		
					if(celda == 'valTerminaInternaProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al terminar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresTerminar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&fecha="+fecha+"&finalizada=4");
					}

				}else if(tipo == "ValidacionRealizarExterna"){
					var comentario = document.getElementById('valRealizarExternaComentarioVerif').value;
					
					document.getElementById("contValidaRealizarExterna").style.display="none";
		   			document.getElementById("cargaValidaRealizarExterna").style.display="block";
		
					if(celda == 'valRealizarExternaProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valRealizarExternaNoProcede').style.backgroundColor = 'red';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al realizar la ficha.");
								}
							}
						}
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresRealizar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&fecha="+fecha+"&realizada=2");
					}
			
					if(celda == 'valRealizarExternaNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valRealizarExternaProcede').style.backgroundColor  = 'red';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al realizar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresRealizar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&fecha="+fecha+"&realizada=3");
					}
				}else if(tipo == "ValidacionRealizarInterna"){
					var comentario = document.getElementById('valRealizarInternaComentarioVerif').value;
					
					document.getElementById("contValidaRealizarInterna").style.display="none";
		   			document.getElementById("cargaValidaRealizarInterna").style.display="block";
		
					if(celda == 'valRealizarInternaProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valRealizarInternaNoProcede').style.backgroundColor = 'red';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al realizar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresRealizar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&fecha="+fecha+"&realizada=2");
					}
			
					if(celda == 'valRealizarInternaNoProcede'){
						celda1.style.backgroundColor  = '#42CB27';
						document.getElementById('valRealizarInternaProcede').style.backgroundColor  = 'red';
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (xhttp.readyState == 4 && xhttp.status == 200) {
								if(xhttp.responseText == true){
									console.log("status", xhttp.responseText);
									actualizarFicha(clave);
								}else{
									alert("Hubo un error al terminar la ficha.");
								}
							}
						};
						xhttp.open("POST", "agregaValores.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=agregarValoresRealizar&clave="+clave+"&auditor="+auditor+"&comentario="+comentario+"&fecha="+fecha+"&realizada=3");
					}
				}					
			}
	    </script>
		<script>
			function editarDescripcion(){
				window.location.href = "modificaObjetivoAuditoria.php";
			}
		</script>			
	</head>
	<body>

		<?php 

		$formListaA = "
		<table id='seccionConclusiones' border='0' align='center' width='700px'>
			<tr height='30px'><td colspan='4'></td></tr>		
			<tr>
				<td class='titulo2' colspan='4'><b>Lista de asistencia</b></td>				
					<td><a href='agregar_archivo_auditoriaPopUp.php?clave=".$clave."&tipo=ASISTENCIA' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes');\">
						<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>
					</a>
				</td>

			</tr>

			<tr>
				<td class='titleBlueLineBottom' colspan='5'></td>
			</tr>";

				if (!empty($rutaA)){ 
				$formListaA .= "
				<tr>
					<td colspan='4' id='textIntro'>						
					<i>".$nombreArchivoAsistencia."</i> <a href='../downloadAuditoria.php?file=".$nombreArchivoAsistencia."'><img src='../../Imagenes/ICN_Archivo.png'></a>
				</td>";

				}

			$formListaA .= "								
			</tr>
			<tr height='30px'> </tr>
		</table>";

		if ($condicion == 'EX'){
		?>
			<div id='wrapperFichaExterna' align='center'>
				<form method='post' id='formularioExterno' action='auditoria_actualizar.php?clave=<?php echo $clave; ?>'>
					<table border='0' align='center'>
						<tr>
							<td align='left' id='breadcrumbs'>Usuario: <?php echo $usuarioId; ?></td>
						</tr>						
						<tr height='80px'><td></td></tr>
						<!-- ///Titulo  -->
						<tr>
							<td align='center' class='titulo1' width='700px'>
								<?php echo $clave; ?>
							</td>
						</tr>
						<tr>
							<td id="titulo3" width="700px" align="center"><?php echo $tituloAuditoria; ?>
							</td>
						</tr>					
						<tr> 
							<td align='center'>
								<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>
								<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>
								<?php echo $breadcrumb; ?>
							</td>

    <div style='margin-left: 40%;'><table border='0' align='center' id='mapaIntranet' style='display:none;'>
        <td><?php include("../../navegacion_banana.php"); ?></td>
    </table></div>

						</tr>							
						<tr height='50'><td></td></tr>		
					</table>	

					<table border='0' align='center' width='700px'>	
						<tr height='50px'><td colspan='4'></td></tr>
						<tr>
							<td colspan='3' class='titulo2'><b>Plan de auditoría</b></td>
							<td>
								<?php 
								if (empty($rutaP)){
								?>												
									<a href='agregar_archivo_auditoriaPopUp.php?clave=<?php echo $clave; ?>&tipo=PROGRAMA' target='popup' onclick="window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')">
										<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>
									</a>
								<?php 
								}
								?>									
							</td>
						</tr>					
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>				
						<?php 
						if (!empty($rutaP)){
						?>
							<tr height='10px'><td colspan='3'></td></tr>			
							<tr>
								<td></td>
								<td></td>
								<td colspan='2' id='textIntro'>						
										<i><?php echo $nombreArchivoPlan; ?></i> <a href='../downloadAuditoria.php?file=<?php echo $nombreArchivoPlan; ?>'><img src='../../Imagenes/ICN_Archivo.png'></a>
										
								</td>
							<td>
								 <?php  echo ' 
								<a href="agregar_archivo_auditoriaPopUp.php?clave='.$clave.'&amp;tipo=PROGRAMA" target="popup" onclick="window.open(this.href,this.target,&#39;width=500,height=400,scrollbars=yes&#39;)"> 
									<img src="../../Imagenes/ICN_Settings.png" width="15" height="15">  </a>

								 ' ?>
									

								</td>
							</tr>
						<?php 
						}
						?>
						<tr height='10px'><td colspan='4'></td></tr>
						<tr>
							<td width='20px'></td>
							<td width='20px'></td>
							<td width='645px'>
								<textarea id='programa' name='programa' style='width: 645px; height:200px;' disabled><?php echo $programa; ?></textarea><input type='hidden' name='codigo' value=''>
							</td>
							<td width='15px' align='right'>
								<img id="editprograma" src="../../Imagenes/ICN_Settings.png" width="15" height="15" onclick="enabledprograma();">
								<input id="inputprograma"  type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10' style="display: none">
							</td>
						</tr>		
						<tr height='20px'><td colspan='4'></td></tr>		
					</table>
					<!-- //Informe de la auditoria -->
					<table border='0' align='center' style='text-align: center;' width='700px'>
						<tr align="center">
							<td class='titulo2' colspan='3'><b>Informe de la auditoría</b></td>
							<td>	
								<?php 
								if (empty($rutaI)){
								?>			

									<a href='agregar_archivo_auditoriaPopUp.php?clave=<?php echo $clave; ?>&tipo=INFORME' target='popup' onclick="window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')">
										<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>
									</a>
								<?php 
								}
								?>									
							</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>	
						<?php 
						if (!empty($rutaI)){
						?>										
						<tr height='20px'><td colspan='4'></td></tr>				
						<tr>
							<td></td>
							<td></td>
							<td colspan='2' id='textIntro' align="left">					
									<i><?php echo $nombreArchivoInforme; ?></i> 

									<a href='downloadAuditoria.php?file=<?php echo $nombreArchivoInforme; ?>' ><img src='../../Imagenes/ICN_Archivo.png'></a>
							</td>
							<td>
								 <?php  echo ' 
								<a href="agregar_archivo_auditoriaPopUp.php?clave='.$clave.'&amp;tipo=INFORME" target="popup" onclick="window.open(this.href,this.target,&#39;width=500,height=400,scrollbars=yes&#39;)"> 
									<img src="../../Imagenes/ICN_Settings.png" width="15" height="15">  </a>

								 ' ?>
									

								</td>
						</tr>
						<?php 
						}
						?>						
						<tr height='10px'><td colspan='4'></td></tr>				
						<tr>
							<td width='20px'></td>
							<td width='20px'></td>					
							<td width='645px'>
								<textarea id='informe' name='informe' style='width: 645px; height:200px;' disabled><?php echo $informe; ?></textarea>
							</td>					
							<td width='15px' align='right'>
								<img id="editinforme" src="../../Imagenes/ICN_Settings.png" width="15" height="15" onclick="enabledinforme();"> 	
								<input id="inputinforme" type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10' style="display: none">
							</td>
						</tr>
						<tr height='20'><td colspan='4'></td></tr>
					</table>

					<?php echo $formListaA; ?>

					<table border='0' align='center' width='700px'>
						<tr height='30px'><td colspan='4'></td></tr>	
						<tr>
							<td class='titulo2' colspan='3'><b>Fechas</b></td>
							<td align='right'>
								<a href='modificarFechasPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
							</td>								
						</tr>
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>
						<tr height='30px'> </tr>
						<tr><td width='30px'></td><td style='width: 300px;'>Fecha Programada</td><td><?php echo $fechaHoraProgramada; ?></td></tr>
						<tr height='10px'> </tr>
						<tr><td width='30px'></td><td style='width: 300px;'>Fecha Inicio</td><td><?php echo $fechaHoraInicio; ?></td></tr>
						<tr height='10px'> </tr>
						<tr><td width='30px'></td><td style='width: 300px;'>Fecha Final</td><td><?php echo $fechaHoraFinalizacion; ?></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>	
					</table>	

					<?php
						if($statusAuditoria == '1'){
						?>				
							<div id='seccionRealizar' align="center">
								<table width='700px'>
									<tr height='30px'><td colspan='4'></td></tr>
									
									<tr>
										<td class='titulo2' colspan='3'><b>Realizar auditoría</b></td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>

									<tr height='30px'><td colspan='4'></td></tr>
								</table>
								<!-- //div donde muestr gif de cargando -->
								<div id='cargaValidaRealizarExterna' style='display:none' align='center'>
					    			<img src='../../Imagenes/img_load.gif' /><br><br>
					  			</div>

								<div id='contValidaRealizarExterna' style='display:block'>
						
									<div id='validacionRealizarExterna'>
										<table align='center' width='20%'>
											<tr height='20px'></tr>
											<tr height="25px" align="center">
												<td id="valRealizarExternaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valRealizarExternaProcede', 'ValidacionRealizarExterna')"><font color="white">Realizada</font></td>
											</tr>
											<tr height="10px"></tr>
											<tr height="25px" align="center">
												<td id="valRealizarExternaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valRealizarNoProcede', 'ValidacionRealizar')"><font color="white">No Realizada</font></td>
											</tr>
											<tr height='10px'><td colspan='4'></td></tr>			
										</table>
										
										<div id='valRealizarExternaComentario'>
											<table  border='0' align='center' width='500px'>
												<tr>
													<td style='color:#007CBD;'>Comentarios</td>
												</tr>
									
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>

												<tr height='30px'><td colspan='4'></td></tr>										
												<tr align='center'>
													<td><textarea id='valRealizarExternaComentarioVerif' rows='4' cols='70'></textarea></td>
												</tr>
												<tr height='30px'><td colspan='4'></td></tr>							
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>
												
												<tr height='30px'><td colspan='4'></td></tr>
											</table>
										</div>
									</div>
								</div> <!-- //fin del div que engloba al comentario y a la decision		 -->		
							</div>
							<!-- hallazgo 1-->
							<table border='0' align='center' width='700px'>	
								<tr height='30px'><td colspan='5'></td></tr>			
								<tr>
									<td class='titulo2' colspan='3'><b>Hallazgos</b></td>
									<td align='right'>
										<!-- //Agregar competencia -->
										<a href='modificarHallazgosInformePopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')">
										<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
										</a>
									</td>							
								</tr>					
								<tr>
									<td class='titleBlueLineBottom' colspan='5'></td>
								</tr>					
								<tr height='20px'><td colspan='5'></td></tr>					
								<tr>
									<td width='30px'></td>											
									<td>
										¿Existen Hallazgos?
									</td>
									<td align='center'>
										<td><?php echo $hallazgos; ?>
										</td>
									</td>							
								</tr>					
								<tr height='20px'><td colspan='5'></td></tr>

								<tr>
									<td id='titleBlueLineBottom' colspan='2'></td>
								</tr>
								
								<tr height='30'><td colspan='2'></td></tr>

							</table>
						<?php
						} else if ($statusAuditoria == 2){
						?>
							<table width='700px' align="center">
								<tr height='60px'><td colspan='4'></td></tr>
								
								<tr>
									<td align='left' id='titulo2'>Realización de la auditoría</td>	
								</tr>
								
								<tr>
									<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
									</td>
								</tr>
								<tr height='30px'><td colspan='4'></td></tr>
							</table>

							<table class='procede' style="width: 600px;" align="center" >
					         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
					     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
					         		color="white">Procede</font></td>
					   			</tr>
					        </table>

							<table  border='0' align='center' width='50%'>
								<tr height='10px'><td></td></tr>

								<tr align='center'>
									<td><?php echo $personaRealizo;?> realizo la auditoría</td>
								</tr>
							
								<tr align='center'>
									<td><?php echo $comentarioRealizo;?></td>
								</tr>

								<tr align='center'>
									<td><?php echo $fechaRealizo;?></td>
								</tr>
								
								<tr height='30px'><td colspan='4'></td></tr>							

							</table>
							<?php						
							$contadorHallazgos = 0;
							$contadorTerminadas = 0;
							$contadorCorrectivaTerminada = 0;
							$d = $INTRANETV2->Execute("SELECT xt_claveHallazgo, xt_titulo, xd_fecha, SUBSTRING_INDEX(xt_ruta,'/',-1) FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave'");
							while($registroHallazgos = $d->fetchRow()) {
								$claveHallazgo[$contadorHallazgos]  = $registroHallazgos[0];
								$tituloHallazgo[$contadorHallazgos] = $registroHallazgos[1];
								$fechaHallazgo[$contadorHallazgos]  = $registroHallazgos[2];
								$rutaHallazgo[$contadorHallazgos]  = $registroHallazgos[3];
								$c = $INTRANETV2->Execute("SELECT xt_claveTratamiento, xt_tipoTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$claveHallazgo[$contadorHallazgos]'");
								while($registroTratamientos = $c->fetchRow()) {
									$claveTratamiento = $registroTratamientos[0];
									$tipoTratamiento = $registroTratamientos[1];
									$terminado = $INTRANETV2->getOne("
											SELECT
												xn_status
											FROM
												SGI_Acciones_Preventivas_Correctivas
											WHERE
												xt_claveAccion = '$claveTratamiento'
										");
									if($terminado == 1){
										$contadorCorrectivaTerminada++;
									}

									if($tipoTratamiento == 'SOLICITUD'){
										$tipoSolicitud = $INTRANETV2->getOne("
												SELECT
													xt_tipoSolicitud
												FROM
													SGI_Quejas_Solicitudesv2
												WHERE
													xt_quejaSolicitud = '$claveTratamiento'
											");
										if($tipoSolicitud == 'MT'){
											$pagina = "https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?";
										} else if ($tipoSolicitud == 'PY'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?";
										} else if ($tipoSolicitud == 'AV'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'AB'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'ST'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'DS'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'EA'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										}
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='".$pagina."codigo=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";

										$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("
											SELECT
												xt_status
											FROM
												SGI_Quejas_Solicitudesv2 SSE
											WHERE
												xt_quejaSolicitud = '$claveTratamiento'
											ORDER BY
												xd_fecha DESC
										");	

										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 1<br>";

									if ($semaforoTerminada[$contadorHallazgos] == 'SIN ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
										$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'TERMINADA'){
										$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'TERMINADA' || $semaforoTerminada[$contadorHallazgos] != 'SIN ASIGNAR'){
										$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }

									}else if ($tipoTratamiento == 'PREVENTIVA' || $tipoTratamiento == 'CORRECTIVA'){

									if($tipoTratamiento == 'PREVENTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaPreventivav2.php?id=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 2<br>";
									}else if ($tipoTratamiento == 'CORRECTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaCorrectivav2.php?id=".$claveTratamiento."'  id='fileItem' namw='".$tipoTratamiento."' style='text-decoration:none;'>".$claveTratamiento."</a>";
									}
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 3<br>";
								$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$claveTratamiento' ORDER BY xn_etapa DESC LIMIT 1");

								$evaluada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$claveTratamiento'");
									
									if ($semaforoTerminada[$contadorHallazgos] == 'ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
									$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'EVALUACION' || !empty($evaluada[$contadorHallazgos])){
									$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == 'DECISION' && !empty($evaluada[$contadorHallazgos])) {
				                    	$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
				                    }elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'EVALUACION' || $semaforoTerminada[$contadorHallazgos] != 'ASIGNAR' && empty($evaluada[$contadorHallazgos])){
												$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }
								}
								}
								$contadorHallazgos++;
							}
							?>
							<!-- hallazgo 2 -->
							<table border='0' align='center' width='700px'>	
								<tr height='30px'><td colspan='4'></td></tr>						
								<tr>
									<td align='left' name="Hallazgos2" id='titulo2'><b>Hallazgos</b></td>
									
									<td align='right'>
										<a href='agregarHallazgoPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')">
											<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>
										</a>
									</td>	
								</tr>
								
								<tr>
									<td id='titleBlueLineBottom' colspan='2'></td>
								</tr>
								
								<tr height='30'><td colspan='2'></td></tr>
							</table>
						
							<?php
							if($contadorHallazgos>0){
							?>
								<table border='0' align='center' width='700px'>
									<tr id='iconosTexto2'>
										<td align='center' width='180px'>Código</td>
										<td align='left' width='300px'>Titulo</td>
										<td align='center' width='120px'>Tratamiento </td>
										<td align='center' width='80px'>Estatus</td>
										<td align='center' width='20px'></td>
									</tr>
									
									<tr height='10px'><td colspan='4'></td></tr>
									<?php
									for($indice=0;$indice<count($claveHallazgo);$indice++){		
									
									/*if ($semaforoTerminada[$indice] == 'ASIGNAR') {
										$semaforoTerminada[$indice] = 'POR ATENDER';
									}elseif($semaforoTerminada[$indice] == 'EVALUACION' || !empty($evaluada[$indice])){
										$semaforoTerminada[$indice] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$indice] == '') {
				                    	$semaforoTerminada[$indice] = "";
				                    }elseif($semaforoTerminada[$indice] != 'EVALUACION' || $semaforoTerminada[$indice] != 'ASIGNAR' && empty($evaluada[$indice])){
										$semaforoTerminada[$indice] = "EN CURSO";	
				                    }*/
						
										echo "	
										<tr>
											<td align='center' id='fileItem' width='180px'>
												<a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$claveHallazgo[$indice]</a></td>
											<td align='left' id='fileItem' width='300px'><a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$tituloHallazgo[$indice]</td>
											<td align='center' id='fileItem' width='150px'>".$enlaceCorrectiva[$indice]."</td>
											<td align='center' id='fileItem' width='120px'>$semaforoTerminada[$indice]</td>
											<td align='right' width='20px'>";
											echo "</td>
										</tr>";
									}
									?>
									<tr height='30px'><td colspan='4'></td></tr>

									<tr>
										<td id='titleBlueLineBottom' colspan='4'></td>
									</tr>
									
									<tr height='30'><td colspan='2'></td></tr>
									
								</table>						
							<?php
							}
						} else if ($statusAuditoria == 4){
						?>
							<table width='700px' align="center">
								<tr height='60px'><td colspan='4'></td></tr>
								
								<tr>
									<td align='left' id='titulo2'>Realización de la auditoría</td>	
								</tr>
								
								<tr>
									<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
									</td>
								</tr>
								<tr height='30px'><td colspan='4'></td></tr>
							</table>

							<table class='procede' style="width: 600px;" align="center" >
					         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
					     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
					         		color="white">Procede</font></td>
					   			</tr>
					         </table>

							<table  border='0' align='center' width='50%'>
								<tr height='10px'><td></td></tr>

								<tr align='center'>
									<td><?php echo $personaRealizo;?> realizo la auditoría</td>
								</tr>
							
								<tr align='center'>
									<td><?php echo $comentarioRealizo;?></td>
								</tr>

								<tr align='center'>
									<td><?php echo $fechaRealizo;?></td>
								</tr>
								
								<tr height='30px'><td colspan='4'></td></tr>							

							</table>
							<?php						
							$contadorHallazgos = 0;
							$contadorTerminadas = 0;
							$contadorCorrectivaTerminada = 0;


							$d = $INTRANETV2->Execute("SELECT DISTINCT xt_claveHallazgo, xt_titulo, xd_fecha, SUBSTRING_INDEX(xt_ruta,'/',-1) FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave'");
							while($registroHallazgos = $d->fetchRow()) {
								$claveHallazgo[$contadorHallazgos]  = $registroHallazgos[0];
								$tituloHallazgo[$contadorHallazgos] = $registroHallazgos[1];
								$fechaHallazgo[$contadorHallazgos]  = $registroHallazgos[2];
								$rutaHallazgo[$contadorHallazgos]  = $registroHallazgos[3];
								$c = $INTRANETV2->Execute("SELECT xt_claveTratamiento, xt_tipoTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$claveHallazgo[$contadorHallazgos]'");
								while($registroTratamientos = $c->fetchRow()) {
									$claveTratamiento = $registroTratamientos[0];
									$tipoTratamiento = $registroTratamientos[1];
									$terminado = $INTRANETV2->getOne("
											SELECT
												xn_status
											FROM
												SGI_Acciones_Preventivas_Correctivas
											WHERE
												xt_claveAccion = '$claveTratamiento'
										");
									if($terminado == 1){
										$contadorCorrectivaTerminada++;
									}

									if($tipoTratamiento == 'SOLICITUD'){
										$tipoSolicitud = $INTRANETV2->getOne("
												SELECT
													xt_tipoSolicitud
												FROM
													SGI_Quejas_Solicitudesv2
												WHERE
													xt_quejaSolicitud = '$claveTratamiento'
											");
										if($tipoSolicitud == 'MT'){
											$pagina = "https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?";
										} else if ($tipoSolicitud == 'PY'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?";
										} else if ($tipoSolicitud == 'AV'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'AB'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'ST'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'DS'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'EA'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										}
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='".$pagina."codigo=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";

										$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("
											SELECT
												xt_status
											FROM
												SGI_Quejas_Solicitudesv2 SSE
											WHERE
												xt_quejaSolicitud = '$claveTratamiento'
											ORDER BY
												xd_fecha DESC
										");	

										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 1<br>";

									if ($semaforoTerminada[$contadorHallazgos] == 'SIN ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
										$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'TERMINADA'){
										$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'TERMINADA' || $semaforoTerminada[$contadorHallazgos] != 'SIN ASIGNAR'){
										$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }

									}else if ($tipoTratamiento == 'PREVENTIVA' || $tipoTratamiento == 'CORRECTIVA'){

									if($tipoTratamiento == 'PREVENTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaPreventivav2.php?id=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 2<br>";
									}else if ($tipoTratamiento == 'CORRECTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaCorrectivav2.php?id=".$claveTratamiento."'  id='fileItem' namw='".$tipoTratamiento."' style='text-decoration:none;'>".$claveTratamiento."</a>";
									}
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 3<br>";
								$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$claveTratamiento' ORDER BY xn_etapa DESC LIMIT 1");

								$evaluada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$claveTratamiento'");
									
									if ($semaforoTerminada[$contadorHallazgos] == 'ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
									$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'EVALUACION' || !empty($evaluada[$contadorHallazgos])){
									$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == 'DECISION' && !empty($evaluada[$contadorHallazgos])) {
				                    	$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
				                    }elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'EVALUACION' || $semaforoTerminada[$contadorHallazgos] != 'ASIGNAR' && empty($evaluada[$contadorHallazgos])){
												$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }
								}

								}
								$contadorHallazgos++;
							}
							?>
							<!-- hallazgo 3 -->
							<table border='0' align='center' width='700px'>	
								<tr height='30px'><td colspan='4'></td></tr>						
								<tr>
									<td align='left' name="Hallazgos1" id='titulo2'><b>Hallazgos
									</b></td>
									
									<td align='right'>
										<a href='agregarHallazgoPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')">
											<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>
										</a>
									</td>	
								</tr>
								
								<tr>
									<td id='titleBlueLineBottom' colspan='2'></td>
								</tr>
								
								<tr height='30'><td colspan='2'></td></tr>
							</table>
						
							<?php
							if($contadorHallazgos>0){
							?>
								<table border='0' align='center' width='700px'>
									<tr id='iconosTexto2'>
										<td align='center' width='220px'>Código</td>
										<td align='left' width='300px'>Titulo</td>
										<td align='center' width='180px'>Tratamiento </td>
										<td align='center' width='180px'>Estatus</td>
										<td align='center' width='20px'></td>
									</tr>
									
									<tr height='10px'><td colspan='4'></td></tr>
									<?php
									for($indice=0;$indice<count($claveHallazgo);$indice++){	

										echo "	
										<tr>
											<td align='center' id='fileItem' width='120px'>
												<a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$claveHallazgo[$indice]</a></td>
											<td align='left' id='fileItem' width='500px'><a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$tituloHallazgo[$indice]</td>
											<td align='center' id='fileItem' width='150px'>".$enlaceCorrectiva[$indice]."</td>
											<td align='center' id='fileItem' width='80px'>$semaforoTerminada[$indice]</td>
											<td align='right' width='20px'></td>
										</tr>";
									}
									?>
									<tr height='30px'><td colspan='4'></td></tr>

									<tr>
										<td id='titleBlueLineBottom' colspan='4'></td>
									</tr>
									
									<tr height='30'><td colspan='2'></td></tr>
									
								</table>						
							<?php
							}
						}
						?>				
					</div>							
					<!-- //FINALIZAR -->
					<table border='0' align='center' width='700px'>
						<tr>
							<td class='titleBlueLineBottom'></td>
						</tr>					
						<tr height='50'px><td></td></tr>
					</table>
				</form>					
			</div>
		<?php
		} else {
		?>
			<div id='wrapperFichaInterna' align='center'>
				<form method='post' id='formulario' action='auditoria_actualizar.php?clave=<?php echo $clave; ?>' onsubmit='return validarRegistroAgenda()'>
					<div id='elementosOperar'>
						<table border='0' align='center'>
						<tr>
							<td align='left' id='breadcrumbs'>Usuario: <?php echo $usuarioId; ?></td>
						</tr>						
						<tr height='80px'><td></td></tr>
						<!-- ///Titulo  -->
						<tr>
							<td align='center' class='titulo1' width='700px'>
								<?php echo $clave; ?>
							</td>
						</tr>					
						<tr>
							<td align='center' id='titulo3' width='700px'>
								<?php echo $tituloAuditoria;   ?> 
							</td>

						</tr>				
						<tr> 
							<td align='center'>
								<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>
								<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>
								<?php echo $breadcrumb; ?>
							</td>
																	        <!-- banan de navegacion de intranet -->
    <div style='margin-left: 40%;'><table border='0' align='center' id='mapaIntranet' style='display:none;'>
        <td><?php include("../../navegacion_banana.php"); ?></td>
    </table></div>
						</tr>						
							<tr height='50'><td></td></tr>		
						</table>				
							<table id='seccionObjetivos' border='0' align='center' width='700px'>	
								<tr height='30px'><td colspan='4'></td></tr>		
								<tr align="left">
									<td colspan='4' class='titulo3'><b>Plan de auditoría</b></td>
								</tr>	
								<tr>			
									<td class='titulo2' colspan='3'><b>Objetivos</b></td>
									<td align='right' >
										<!-- //Agregar competencia -->
										<a href='modificarObjetivosPopUp.php?clave=<?php echo $clave; ?>' target='popup' 	onclick="window.open(this.href,this.target,'width=700,height=600,scrollbars=yes')">
										<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'></a>
									</td>
								</tr>				
								<tr>
									<td class='titleBlueLineBottom' colspan='4'></td>
								</tr>		
								<tr height='30px'> </tr>					
								<tr>
									<td align='left' width='30px'> </td>
									<td><i style="color:#636262; font: 12px sans-serif; font-style: italic;">Sirven para 	establecer qué es lo que se va a lograr con la auditoría. Se consideran como objetivos de 	esta auditoría los que están palomeados.</i></td>
								</tr>
								<tr>
									<td height='10px'><td colspan='4'></td>
								</tr>
								<tr id = "tituloDiv2">
									<td width='30px' ></td>
									<td id = 'objetivo'><?php echo nl2br($objetivosP); ?></td>
									<?php
										if(($usuarioId == $pdrUserId) || ($usuarioId == "sdelap") || ($usuarioId == "Elena_Hernandez") || ($usuarioId == 	"Saday_Hernandez")){?>
									<td>
										<a href='modificaObjetivoAuditoria.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
											<input style='cursor: pointer; background-color: transparent; border: 0;' 	id='breadcrumbs' type='button' name='modificarDescripcion' value='Modificar'/>
										</a>
									</td>
									<?php	
									}
									?>
								</tr>
								<tr height='30px'><td colspan='4'></td></tr>	
							</table>
							
						<table id='seccionAlcance' border='0' align='center' width='700px'>	
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Alcance de la Auditoría</b></td>
								<td align='right'>
									<!-- //Agregar competencia -->
									<a href='modificarAlcancePopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
							</td>
							</tr>				
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>	
							<tr height='30px'> </tr>						
							<tr>
								<td align='left' width='30px'> </td>
								<td><i style="color:#636262; font: 12px sans-serif; font-style: italic;">Sirve para describir la extensión y los límites de la auditoría, tales como ubicación, unidades de la organización, actividades que van a ser auditados, así como el período cubierto por la auditoría.</i></td>
								<td>
							</tr>							
							<tr height='10px'><td colspan='4'></td></tr>
							<tr>
								<td width='30px'></td>
								<td><?php echo $alcanceP; ?>
								</td>
							</tr>									
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<table id='seccionCriterios' border='0' align='center' width='700px'>	
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Criterios de la Auditoría</b></td>
								<td align='right'>
									<a href='modificarCriteriosPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
								</td>
							</tr>									
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>
							<tr height='30px'> </tr>								
							<tr>
								<td align='left' width='30px'> </td>
								<td><i style="color:#636262; font: 12px sans-serif; font-style: italic;">Se utilizan como una referencia frente a la cual se determina la conformidad. Dichos criterios pueden incluir políticas, procedimientos, normas, leyes y reglamentos, requisitos del sistema de gestión, requisitos contractuales o códigos de conducta de los sectores industriales o de negocio aplicables. Se consideran criterios de esta auditoría los que están palomeados.</i></td>
								<td>
							</tr>								
							<tr height='10px'><td colspan='4'></td></tr>
							<?php
							for($i=0;$i<count($codigoNorma);$i++){
								echo "<tr>";
								echo "<td width='30px'></td>";
								echo "<td>$nombreNorma[$i]</td>";
								echo "</tr>";
							}
							?>								
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<table border='0' align='center' width='700px'>
							<tr height='30px'><td colspan='4'></td></tr>	
							<tr>
								<td class='titulo2' colspan='3'><b>Fechas</b></td>
								<td align='right'>
									<a href='modificarFechasPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
								</td>								
							</tr>
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>
							<tr height='30px'> </tr>
							<tr><td width='30px'></td><td style='width: 300px;'>Fecha Programada</td><td><?php echo $fechaHoraProgramada; ?></td></tr>
							<tr height='10px'> </tr>
							<tr><td width='30px'></td><td style='width: 300px;'>Fecha Inicio</td><td><?php echo $fechaHoraInicio; ?></td></tr>
							<tr height='10px'> </tr>
							<tr><td width='30px'></td><td style='width: 300px;'>Fecha Final</td><td><?php echo $fechaHoraFinalizacion; ?></td></tr>
							<tr height='30px'><td colspan='4'></td></tr>	
						</table>
						<table id='seccionRiesgos' border='0' align='center' width='700px'>	
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Riesgos de la Auditoría</b></td>
								<td align='right'>
									<a href='modificarRiesgosAuditoriaPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
								</td>
							</tr>				
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>
							<tr height='30px'><td colspan='4'></td></tr>
							<tr>
								<td width='30px'></td>
								<td><?php echo $riesgosP; ?>
								</td>
							</tr>								
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<table id='seccionRecursos' border='0' align='center' width='700px'>	
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Recursos requeridos</b></td>
								<td align='right'>
									<!-- //Agregar competencia -->
									<a href='modificarRecursosPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
							</td>
							</tr>									
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>	
							<tr height='30px'> </tr>
							<tr>
								<td width='30px'></td>
								<td><?php echo $recursosP; ?>
								</td>
							</tr>														
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<table id='seccionEquipo' border='0' align='center' width='700px'>	
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Equipo auditor</b></td>
								<td align='right'>
									<!-- //Agregar competencia -->
									<a href='modificarEquipoPopUp.php?clave=<?php echo $clave; ?>&ciudad=<?php echo $ciudad; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=600,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
							</td>
							</tr>				
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>			
							<tr height='30px'> </tr>						
							<tr>
								<td align='left' width='30px'> </td>
								<td><i style="color:#636262; font: 12px sans-serif; font-style: italic;">El equipo auditor se define teniendo en cuenta la competencia necesaria para lograr los objetivos de la auditoría. Se considera parte del equipo auditor a las personas palomeadas.</i></td>
								<td>
							</tr>
							<tr height='10px'><td colspan='4'></td></tr>
							<?php
							for($i=0;$i<count($claveAuditor);$i++){
								echo "<tr>";
								echo "<td width='30px'></td>";
								echo "<td>".utf8_encode($nombreAuditor[$i])."</td>";
								echo "</tr>";
							}
							?>								
							<tr height='30px'><td colspan='4'></td></tr>	
						</table>
						<table id='seccionLider' border='0' align='center' width='700px'>	
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Auditor líder</b></td>
								<td align='right'>
									<!-- //Agregar competencia -->
									<a href='modificarLiderPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
							</td>
							</tr>				
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>	
							<tr height='30px'> </tr>
							<tr>
								<td width='30px'></td>
								<td><?php echo $auditorLiderP; ?>
								</td>
							</tr>								
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
					
						<table width="700px" border="0">
							<tr>
								<td align='left' id='titulo2'><b>Agenda (Manuales y Procesos)</b></td>
								<td align="right">
									<a href='agregar_archivo_auditoriaPopUp.php?clave=<?php echo $clave;?>&tipo=MANUALES' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=400,scrollbars=yes');\">
									<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'></a>
								</td>
								<td align="right"><a href='agregarRegistroAgendaPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=540,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a></td>
							</tr>
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>	
							<tr height='20px'><td colspan='4'></td></tr>						
							<?php							
							if (!empty($rutaM)){ 
								?>
								<tr><td align="center"> 
										<i><?php echo $nombreArchivoManual;?></i>&nbsp;<a href='../downloadAuditoria.php?file=<?php echo $nombreArchivoManual;?>'><img src='../../Imagenes/ICN_Archivo.png'></a></td>
								</tr>							
 								<?php
							}
							for($indiceManuales=0; $indiceManuales < count($manualAuditoria); $indiceManuales++){
							?>	
								<tr height='30px'><td colspan='4'></td></tr>	
								<tr>
									<td colspan="2">
										<table width="650px" align="right" border="0">
											<tr>
												<td colspan="3"><font style='font-size: 15px;'>
													<?php
													$manualAuditoria[$indiceManuales] =str_replace("Manual","Manual",$manualAuditoria[$indiceManuales]);
													 echo $manualAuditoria[$indiceManuales]; 
													 ?></font></td>
											</tr>
											<tr>
												<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
												</td>
											</tr>															
												<tr>
													<td align="left">
														<table width="600px" align="right" border="0">
															<tr>
																<td align="left" id='titulo2' style='width: 280px;'><font style='font-size: 13px;'>Auditor</font></td>
																<td id='titulo2' style='width: 250px;'><font style='font-size: 13px;'>Fecha</font></td>
																<td align="right"><a href='agregarAuditorAgendaPopUp.php?clave=<?php echo $clave; ?>&manual=<?php echo $codigoManual[$indiceManuales]; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=540,scrollbars=yes')">
																	<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
															</tr>
															<tr>
																<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
																</td>
															</tr>			
															<?php
															for($indiceAuditores=0; $indiceAuditores<count($auditorAgenda);$indiceAuditores++){	
																if($codigoManual[$indiceManuales] == $codigoManualAuditor[$indiceAuditores]){
																?>
																<tr>
																	<td align="left"><font style='font-size: 11px;'><?php echo $auditorAgenda[$indiceAuditores];?></font></td>
																	<td><font style='font-size: 11px;'><?php echo $fechaAuditoria[$indiceAuditores]; ?></font></td>
																	<td></td>
																</tr>
																<?php
																} else {
																?>
																<?php
																}
															}
															?>
														</table>
													</td>
												</tr>
										</table>
									</td>
								<tr>
							<?php
							}
							?>
						</table>
						<?php
						if(empty($statusPlan)||$statusPlan==''){
						?>
							<div id='seccionElaborar'>
								<table width='700px'>
									<tr height='60px'><td colspan='4'></td></tr>
									
									<tr>
										<td align='left' id='titulo2'>Aprobaciones</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
								</table>

								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Elaboración del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<!-- //div donde muestr gif de cargando -->
								<div id='cargaValidaElabora' style='display:none' align='center'>
					    			<img src='../../Imagenes/img_load.gif' /><br><br>
					  			</div>
								
								<div id='contValidaElabora' style='display:block'>
								
									<div id='validacionElabora'>
										<table align='center' width='20%'>
											<tr height='20px'></tr>
											<tr height="25px" align="center">
												<td id="valElaboraProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valElaboraProcede', 'ValidacionElaborar')"><font color="white">Procede</font></td>
											</tr>
										
											<tr height="10px"></tr>
										
											<tr height="25px" align="center">
												<td id="valElaboraNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valElaboraNoProcede', 'ValidacionElaborar')"><font color="white">No procede</font></td>
											</tr>
											<tr height='10px'><td colspan='4'></td></tr>
										</table>
										
										<div id='valElaboraComentario'>
											<table  border='0' align='center' width='500px'>		
												<tr>
													<td style='color:#007CBD;'>Comentarios</td>
												</tr>
									
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>
												<tr height='30px'><td colspan='4'></td></tr>										
												<tr align='center'>
													<td><textarea id='valElaboraComentarioVerif' rows='4' cols='70'></textarea></td>
												</tr>
												<tr height='30px'><td colspan='4'></td></tr>							
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>
												
												<tr height='50px'><td colspan='4'></td></tr>
											</table>
										</div>
									</div>
								</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
							</div>
						<?php
						} else if (($statusPlan=='1')) {
						?>
							<div id='seccionRevisar'>
								<table width='700px'>
									<tr height='60px'><td colspan='4'></td></tr>
									
									<tr>
										<td align='left' id='titulo2'>Aprobaciones</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
								</table>

								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Elaboración del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<table class='procede' style="width: 600px;" align="center" >
						         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
						     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
						         		color="white">Procede</font></td>
						   			</tr>
						         </table>

								<table  border='0' align='center' width='600px'>
									<tr height='10px'><td></td></tr>

									<tr align='center'>
										<td><?php echo $personaElaboraPlan;?> elaboró el plan de la auditoría</td>
									</tr>
								
									<tr align='center'>
										<td><?php echo $comentarioElaboraPlan;?></td>
									</tr>

									<tr align='center'>
										<td><?php echo $fechaElaboraPlan;?></td>
									</tr>
									
									<tr height='30px'><td colspan='4'></td></tr>							
									<tr>
										<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									
									<tr height='50px'><td colspan='4'></td></tr>
								</table>

								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Revisión del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<!-- //div donde muestr gif de cargando -->
								<div id='cargaValidaRevisa' style='display:none' align='center'>
					    			<img src='../../Imagenes/img_load.gif' /><br><br>
					  			</div>
								
								<div id='contValidaRevisa' style='display:block'>
								
									<div id='validacionRevisa'>
										<table align='center' width='20%'>
											<tr height='20px'></tr>
											<tr height="25px" align="center">
												<td id="valRevisaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valRevisaProcede', 'ValidacionRevisar')"><font color="white">Procede</font></td>
											</tr>
										
											<tr height="10px"></tr>
										
											<tr height="25px" align="center">
												<td id="valRevisaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valRevisaNoProcede', 'ValidacionRevisar')"><font color="white">No procede</font></td>
											</tr>
											<tr height='10px'><td colspan='4'></td></tr>
										</table>
										
										<div id='valRevisaComentario'>
											<table  border='0' align='center' width='500px'>		
												<tr>
													<td style='color:#007CBD;'>Comentarios</td>
												</tr>
									
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>
												<tr height='30px'><td colspan='4'></td></tr>										
												<tr align='center'>
													<td><textarea id='valRevisaComentarioVerif' rows='4' cols='70'></textarea></td>
												</tr>
												<tr height='30px'><td colspan='4'></td></tr>							
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>
												
												<tr height='50px'><td colspan='4'></td></tr>
											</table>
										</div>
									</div>
								</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
							</div>
						<?php
						} else if ($statusPlan=='2') {
						?>
							<div id='seccionAprueba'>
								<table width='700px'>
									<tr height='60px'><td colspan='4'></td></tr>
									
									<tr>
										<td align='left' id='titulo2'>Aprobaciones</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
								</table>

								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Elaboración del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<table class='procede' style="width: 600px;" align="center" >
						         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
						     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%;"  align="center" bgcolor="#42CB27"><font 	
						         		color="white">Procede</font></td>
						   			</tr>
						         </table>

								<table  border='0' align='center' width='600px;'>
									<tr height='10px'><td></td></tr>

									<tr align='center'>
										<td><?php echo $personaElaboraPlan;?> elaboró el plan de la auditoría</td>
									</tr>
								
									<tr align='center'>
										<td><?php echo $comentarioElaboraPlan;?></td>
									</tr>

									<tr align='center'>
										<td><?php echo $fechaElaboraPlan;?></td>
									</tr>
									
									<tr height='30px'><td colspan='4'></td></tr>							
									<tr>
										<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									
									<tr height='50px'><td colspan='4'></td></tr>
								</table>								

								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Revisión del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<table class= 'procede' style="width: 600px;" align="center" >
						         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
						     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
						         		color="white">Procede</font></td>
						   			</tr>
						         </table>

								<table  border='0' align='center' width='600px;'>
									<tr height='10px'><td></td></tr>

									<tr align='center'>
										<td><?php echo $personaRevisaPlan;?> revisó el plan de la auditoría</td>
									</tr>
								
									<tr align='center'>
										<td><?php echo $comentarioRevisaPlan;?></td>
									</tr>

									<tr align='center'>
										<td><?php echo $fechaRevisaPlan;?></td>
									</tr>
									
									<tr height='30px'><td colspan='4'></td></tr>							
									<tr>
										<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									
									<tr height='50px'><td colspan='4'></td></tr>
								</table>

								<?php
								if($usuarioId == $usuarioAuditorLiderP){
								?>								
									<table style="width: 600px;" align="center">
										<tr>
											<td align='left' id='titulo2'>Aprobación del plan</td>	
										</tr>
										
										<tr>
											<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>
							         </table>

									<!-- //div donde muestr gif de cargando -->
									<div id='cargaValidaAprueba' style='display:none' align='center'>
						    			<img src='../../Imagenes/img_load.gif' /><br><br>
						  			</div>
									
									<div id='contValidaAprueba' style='display:block'>
									
										<div id='validacionAprueba'>
											<table align='center' width='20%'>
												<tr height='20px'></tr>
												<tr height="25px" align="center">
													<td id="valApruebaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valApruebaProcede', 'ValidacionAprobar')"><font color="white">Procede</font></td>
												</tr>
											
												<tr height="10px"></tr>
											
												<tr height="25px" align="center">
													<td id="valApruebaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valApruebaNoProcede', 'ValidacionAprobar')"><font color="white">No procede</font></td>
												</tr>
												<tr height='10px'><td colspan='4'></td></tr>
											</table>
											
											<div id='valApruebaComentario'>
												<table  border='0' align='center' width='500px'>		
													<tr>
														<td style='color:#007CBD;'>Comentarios</td>
													</tr>
										
													<tr>
														<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
														</td>
													</tr>
													<tr height='30px'><td colspan='4'></td></tr>										
													<tr align='center'>
														<td><textarea id='valApruebaComentarioVerif' rows='4' cols='70'></textarea></td>
													</tr>
													<tr height='30px'><td colspan='4'></td></tr>							
													<tr>
														<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
														</td>
													</tr>
													
													<tr height='50px'><td colspan='4'></td></tr>
												</table>
											</div>
										</div>
									</div> <!-- //fin del div que engloba al comentario y a la decision		 -->
								<?php
								}
								?>
							</div>
						<?php
						} else if ($statusPlan=='3'){
						?>
							<div id='seccionAprueba'>
								<table width='700px'>
									<tr height='60px'><td colspan='4'></td></tr>
									
									<tr>
										<td align='left' id='titulo2'>Aprobaciones</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
								</table>


								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Elaboración del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<table class ='procede' style="width: 600px;" align="center" >
						         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
						     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
						         		color="white">Procede</font></td>
						   			</tr>
						        </table>

								<table  border='0' align='center' width='600px'>
									<tr height='10px'><td></td></tr>

									<tr align='center'>
										<td><?php echo $personaElaboraPlan;?> elaboró el plan de la auditoría</td>
									</tr>
								
									<tr align='center'>
										<td><?php echo $comentarioElaboraPlan;?></td>
									</tr>

									<tr align='center'>
										<td><?php echo $fechaElaboraPlan;?></td>
									</tr>
									
									<tr height='30px'><td colspan='4'></td></tr>							
									<tr>
										<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									
									<tr height='50px'><td colspan='4'></td></tr>
								</table>								

								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Revisión del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<table class='procede' style="width: 600px;" align="center" >
						         	<tr id='trValidacion' class ='procedeFila' align="center"  style="display:block">
						     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
						         		color="white">Procede</font></td>
						   			</tr>
						         </table>

								<table  border='0' align='center' width='600px'>
									<tr height='10px'><td></td></tr>

									<tr align='center'>
										<td><?php echo $personaRevisaPlan;?> revisó el plan de la auditoría</td>
									</tr>
								
									<tr align='center'>
										<td><?php echo $comentarioRevisaPlan;?></td>
									</tr>

									<tr align='center'>
										<td><?php echo $fechaRevisaPlan;?></td>
									</tr>
									
									<tr height='30px'><td colspan='4'></td></tr>							
									<tr>
										<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									
									<tr height='50px'><td colspan='4'></td></tr>
								</table>

								<table style="width: 600px;" align="center">
									<tr>
										<td align='left' id='titulo2'>Aprobación del plan</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
						         </table>

								<table class = 'procede' style="width: 600px;" align="center" >
						         	<tr id='trValidacion' class = 'procedeFila' align="center"  style="display:block">
						     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
						         		color="white">Procede</font></td>
						   			</tr>
						         </table>

								<table  border='0' align='center' width='600px'>
									<tr height='10px'><td></td></tr>

									<tr align='center'>
										<td><?php echo $personaAprueba;?> aprobó el plan de la auditoría</td>
									</tr>
								
									<tr align='center'>
										<td><?php echo $comentarioAprueba;?></td>
									</tr>

									<tr align='center'>
										<td><?php echo $fechaAprueba;?></td>
									</tr>
									
									<tr height='30px'><td colspan='4'></td></tr>							
									<tr>
										<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>
									
									<tr height='50px'><td colspan='4'></td></tr>
								</table>

							</div>
						<?php
						}
						?>	
						<table id='seccionAlcanceInforme' border='0' align='center' width='700px'>
							<tr align="left">
								<td colspan='4' class='titulo3'><b>Informe de auditoría</b></td>
								</tr>			
						<tr align="right">
							<td class='titleBlueLineBottom' colspan='4'></td>
								<td>	
									<?php 
									if (empty($rutaI)){
									?>			
	
										<a href='agregar_archivo_auditoriaPopUp.php?clave=<?php echo $clave; ?>&tipo=INFORME' target='popup' onclick="window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')">
											<img  src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>
										</a>
									<?php 
									}
									?>									
								</td>
							</tr>	
						<?php 
						if (!empty($rutaI)){
						?>										
						<tr height='20px'><td colspan='4'></td></tr>				
						<tr>
							<td></td>
							<td></td>
							<td colspan='2' id='textIntro' align="left">					
									<i><?php echo $nombreArchivoInforme; ?></i> 

									<a href='downloadAuditoria.php?file=<?php echo $nombreArchivoInforme; ?>' ><img src='../../Imagenes/ICN_Archivo.png'></a>
							</td>
							<td>
								 <?php  echo ' 
								<a href="agregar_archivo_auditoriaPopUp.php?clave='.$clave.'&amp;tipo=INFORME" target="popup" onclick="window.open(this.href,this.target,&#39;width=500,height=400,scrollbars=yes&#39;)"> 
									<img src="../../Imagenes/ICN_Settings.png" width="15" height="15">  </a>

								 ' ?>
									

								</td>
						</tr>
						<?php 
						}
						?>		
							</tr>							
							<tr height='30px'><td colspan='4'></td></tr>	
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Cumplimiento de objetivos y alcance</b></td>
								<td align='right'>
									<!-- //Agregar competencia -->
									<a href='modificarCumplimientoObjetivosPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=540,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
								</td>
							</tr>				
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>				
							<tr height='30px'><td colspan='4'></td></tr>
							<tr>
								<td style='width: 30px;'>
								</td>
								<td><?php echo $objetivosI; ?>
								</td>
							</tr>							
							<tr height='30px'><td colspan='4'></td></tr>						
						</table>
						<table width="700px" border="0">
							<tr>
								<td align='left' id='titulo2'><b>Cumplimiento de la Agenda (Manuales y Procesos)</b></td>
								
							</tr>
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>

							<?php
							for($indiceManuales=0; $indiceManuales < count($manualAuditoria); $indiceManuales++){
							?>	
								<tr height='30px'><td colspan='4'></td></tr>	
								<tr>
									<td colspan="2">
										<table width="650px" align="right" border="0">
											<tr>
												<td colspan="3"><font style='font-size: 15px;'>
													<?php echo $manualAuditoria[$indiceManuales]; ?>
														
													</font></td>
											</tr>
											<tr>
												<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
												</td>
											</tr>															
												<tr>
													<td align="left">
														<table width="600px" align="right" border="0">
															<tr>
																<td align="left" id='titulo2' style='width: 280px;'><font style='font-size: 13px;'>Auditor</font></td>
																<td id='titulo2' style='width: 250px;'><font style='font-size: 13px;'>Fecha</font></td>
																<td align="right">
															</tr>
															<tr>
																<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
																</td>
															</tr>

															<?php
															for($indiceAuditores=0; $indiceAuditores<count($auditorAgenda);$indiceAuditores++)
															{	
																$statusAuditor=false;
																if($codigoManual[$indiceManuales] == $codigoManualAuditor[$indiceAuditores])
																{
																	?>
																	<tr>
																	<td align="left"><font style='font-size: 11px;'><?php echo $auditorAgenda[$indiceAuditores];?></font></td>
																	<td><font style='font-size: 11px;'><?php echo $fechaAuditoria[$indiceAuditores]; ?></font></td>
																	<td><a href='agregarAuditadoAgendaInformePopUp.php?clave=<?php echo "$clave&manual=$codigoManual[$indiceManuales]&auditor=$auditorClave[$indiceAuditores]&fechaext=$fechaAuditoria[$indiceAuditores]"  ; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=540,scrollbars=yes')">
																	<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </td>
																    </tr>
																    <tr><td>
																    	<?php
																    	$epg = $INTRANETV2->Execute("SELECT xt_auditado,xt_puestoAuditado,xt_puntoAuditado,xd_fecha FROM SGI_Auditorias_Auditados  WHERE xt_claveAuditoria = '$clave'
																	AND xt_claveAuditor= '$auditorClave[$indiceAuditores]'
																	AND xt_codigoManual ='$codigoManual[$indiceManuales]' 
																	AND xd_fechaRealizacionAuditoria='$fechaAuditoria[$indiceAuditores]'" );
																    	 
																    	while($registroAuditados = $epg->fetchRow())
																    	{
																    		$statusAuditor=true;
																    		$contenidotabla.= "<tr><td></td>
																			<td>$registroAuditados[0]</td>
																			<td> $registroAuditados[1]</td>
																			<td> $registroAuditados[2]</td>
																			<td> $registroAuditados[3]</td>
																			</tr>
																			"  ;
																		}
																	if($statusAuditor)
																	{
																			echo "<br><table width='450px'><tr>
																			<td width='50px'></td><td colspan='4'><font style='font-size: 15px;'>Auditó</td></tr>
																			<tr><td width='50px'> </td><td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
																				</td></tr>
																			<tr>
																			<td width='50px'></td>
																			<td align='left' id='titulo2'><font style='font-size: 13px;'>Persona</font></td>
																			<td align='left' id='titulo2'><font style='font-size: 13px;'>Puesto</font></td>
																			<td align='left' id='titulo2'><font style='font-size: 13px;'>Punto</font></td>
																			<td align='left' id='titulo2'><font style='font-size: 13px;'>Fecha</font></td>

																			</tr>
																			<tr><td width='50px'></td><td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
																				</td></tr>

																			";
																			echo "$contenidotabla";
																			echo "</table>";
																			$contenidotabla="";
																	}
																} 
															else {
																 
																 
																}
														}
															?>
															 </td> <tr>
														</table>
													</td>
												</tr>
										</table>
									</td>
								</tr>
									
							<?php
							
							}
							?>
							<tr height='30px'><td colspan='4'></td></tr>	
						</table>
						<table id='seccionConclusiones' border='0' align='center' width='700px'>
							<tr height='30px'><td colspan='4'></td></tr>		
							<tr>
								<td class='titulo2' colspan='3'><b>Conclusiones de la Auditoría</b></td>
								<td align='right'>
									<!-- //Agregar competencia -->
									<a href='modificarConclusionesPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
									</a>
							</td>
							</tr>				
							<tr>
								<td class='titleBlueLineBottom' colspan='4'></td>
							</tr>
							<tr height='30px'> </tr>								
							<tr>
								<td align='left' width='30px'> </td>
								<td><i style="color:#636262; font: 12px sans-serif; font-style: italic;">Valoración del equipo auditor respecto a la conformidad del sistema de gestión de calidad con los requisitos establecidos en los criterios, así como valoración de que si éste se ha implementado y se mantiene de manera eficaz.</i></td>
								<td>
							</tr>
							<tr height='10px'><td colspan='4'></td></tr>
							<tr>
								<td style='width: 30px;'>
								</td>
								<td><?php echo $conclusion; ?>
								</td>
							</tr>									
							<tr height='30px'><td colspan='4'></td></tr>
						</table>


						<?php

						echo $formListaA;

						if($statusAuditoria == 1){
						?>				
							<div id='seccionRealizar'>
								<table width='700px'>
									<tr height='30px'><td colspan='4'></td></tr>
									
									<tr>
										<td align='left' id='titulo2'>Realizar auditoría</td>	
									</tr>
									
									<tr>
										<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
										</td>
									</tr>

									<tr height='30px'><td colspan='4'></td></tr>
								</table>
								<!-- //div donde muestr gif de cargando -->
								<div id='cargaValidaRealizarInterna' style='display:none' align='center'>
					    			<img src='../../Imagenes/img_load.gif' /><br><br>
					  			</div>

								<div id='contValidaRealizarInterna' style='display:block'>
								
									<div id='validacionRealizarInterna'>
										<table align='center' width='20%'>
											<tr height='20px'></tr>
											<tr height="25px" align="center">
												<td id="valRealizarInternaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valRealizarInternaProcede', 'ValidacionRealizarInterna')"><font color="white">Realizada</font></td>
											</tr>
											<tr height="10px"></tr>
											<tr height="25px" align="center">
												<td id="valRealizarInternaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valRealizarInternaNoProcede', 'ValidacionRealizarInterna')"><font color="white">No Realizada</font></td>
											</tr>
											<tr height='10px'><td colspan='4'></td></tr>			
										</table>
										
										<div id='valRealizarInternaComentario'>
											<table  border='0' align='center' width='500px'>
												<tr>
													<td style='color:#007CBD;'>Comentarios</td>
												</tr>
									
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>

												<tr height='30px'><td colspan='4'></td></tr>										
												<tr align='center'>
													<td><textarea id='valRealizarInternaComentarioVerif' rows='4' cols='70'></textarea></td>
												</tr>
												<tr height='30px'><td colspan='4'></td></tr>							
												<tr>
													<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
													</td>
												</tr>
												
												<tr height='30px'><td colspan='4'></td></tr>
											</table>
										</div>
									</div>
								</div> <!-- //fin del div que engloba al comentario y a la decision		 -->	
							</div>
							<!-- hallazgo 4 -->
							<table border='0' align='center' width='700px'>	
								<tr height='30px'><td colspan='5'></td></tr>			
								<tr>
									<td class='titulo2' colspan='3'><b>Hallazgos</b></td>
									<td align='right'>
										<!-- //Agregar competencia -->
										<a href='modificarHallazgosInformePopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')">
										<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
										</a>
									</td>							
								</tr>					
								<tr>
									<td class='titleBlueLineBottom' colspan='5'></td>
								</tr>					
								<tr height='20px'><td colspan='5'></td></tr>					
								<tr>
									<td width='30px'></td>											
									<td>
										¿Existen Hallazgos?
									</td>
									<td align='center'>
										<td><?php echo $hallazgos; ?>
										</td>
									</td>							
								</tr>					
								<tr height='20px'><td colspan='5'></td></tr>	

								<tr>
									<td id='titleBlueLineBottom' colspan='5'></td>
								</tr>
								
								<tr height='30'><td colspan='2'></td></tr>

							</table>
						<?php
						} else if ($statusAuditoria == 2){
						?>
							<table width='700px' align="center">
								<tr height='60px'><td colspan='4'></td></tr>
								
								<tr>
									<td align='left' id='titulo2'>Realización de la auditoría</td>	
								</tr>
								
								<tr>
									<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
									</td>
								</tr>
								<tr height='30px'><td colspan='4'></td></tr>
							</table>

							<table class='procede' style="width: 600px;" align="center" >
					         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
					     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
					         		color="white">Procede</font></td>
					   			</tr>
					         </table>

							<table  border='0' align='center' width='50%'>
								<tr height='10px'><td></td></tr>

								<tr align='center'>
									<td><?php echo $personaRealizo;?> realizo la auditoría</td>
								</tr>
							
								<tr align='center'>
									<td><?php echo $comentarioRealizo;?></td>
								</tr>

								<tr align='center'>
									<td><?php echo $fechaRealizo;?></td>
								</tr>
								
								<tr height='30px'><td colspan='4'></td></tr>							

							</table>
							<?php						
							$contadorHallazgos = 0;
							$contadorTerminadas = 0;
							$contadorCorrectivaTerminada = 0;
							$d = $INTRANETV2->Execute("SELECT xt_claveHallazgo, xt_titulo, xd_fecha, SUBSTRING_INDEX(xt_ruta,'/',-1) FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave'");
							while($registroHallazgos = $d->fetchRow()) {
								$claveHallazgo[$contadorHallazgos]  = $registroHallazgos[0];
								$tituloHallazgo[$contadorHallazgos] = $registroHallazgos[1];
								$fechaHallazgo[$contadorHallazgos]  = $registroHallazgos[2];
								$rutaHallazgo[$contadorHallazgos]  = $registroHallazgos[3];
								$c = $INTRANETV2->Execute("SELECT xt_claveTratamiento, xt_tipoTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$claveHallazgo[$contadorHallazgos]'");
								while($registroTratamientos = $c->fetchRow()) {
									$claveTratamiento = $registroTratamientos[0];
									$tipoTratamiento = $registroTratamientos[1];
									$terminado = $INTRANETV2->getOne("
											SELECT
												xn_status
											FROM
												SGI_Acciones_Preventivas_Correctivas
											WHERE
												xt_claveAccion = '$claveTratamiento'
										");
									if($terminado == 1){
										$contadorCorrectivaTerminada++;
									}
									if($tipoTratamiento == 'SOLICITUD'){
										$tipoSolicitud = $INTRANETV2->getOne("
												SELECT
													xt_tipoSolicitud
												FROM
													SGI_Quejas_Solicitudesv2
												WHERE
													xt_quejaSolicitud = '$claveTratamiento'
											");
										if($tipoSolicitud == 'MT'){
											$pagina = "https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?";
										} else if ($tipoSolicitud == 'PY'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?";
										} else if ($tipoSolicitud == 'AV'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'AB'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'ST'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'DS'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'EA'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										}
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='".$pagina."codigo=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";

										$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("
											SELECT
												xt_status
											FROM
												SGI_Quejas_Solicitudesv2 SSE
											WHERE
												xt_quejaSolicitud = '$claveTratamiento'
											ORDER BY
												xd_fecha DESC
										");	

										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 1<br>";

									if ($semaforoTerminada[$contadorHallazgos] == 'SIN ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
										$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'TERMINADA'){
										$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'TERMINADA' || $semaforoTerminada[$contadorHallazgos] != 'SIN ASIGNAR'){
										$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }

									}else if ($tipoTratamiento == 'PREVENTIVA' || $tipoTratamiento == 'CORRECTIVA'){

									if($tipoTratamiento == 'PREVENTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaPreventivav2.php?id=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 2<br>";
									}else if ($tipoTratamiento == 'CORRECTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaCorrectivav2.php?id=".$claveTratamiento."'  id='fileItem' namw='".$tipoTratamiento."' style='text-decoration:none;'>".$claveTratamiento."</a>";
									}
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 3<br>";
								$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$claveTratamiento' ORDER BY xn_etapa DESC LIMIT 1");

								$evaluada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$claveTratamiento'");
									
									if ($semaforoTerminada[$contadorHallazgos] == 'ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
									$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'EVALUACION' || !empty($evaluada[$contadorHallazgos])){
									$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == 'DECISION' && !empty($evaluada[$contadorHallazgos])) {
				                    	$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
				                    }elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'EVALUACION' || $semaforoTerminada[$contadorHallazgos] != 'ASIGNAR' && empty($evaluada[$contadorHallazgos])){
												$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }
								}
				            }
								$contadorHallazgos++;
							}
							?>
							<!-- hallazgo 5 -->
							<table border='0' align='center' width='700px'>	
								<tr height='30px'><td colspan='4'></td></tr>						
								<tr>
									<td align='left' name="Hallazgos4" id='titulo2'><b>Hallazgos</b></td>
									
									<td align='right'>
										<a href='agregarHallazgoPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')">
											<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>
										</a>
									</td>	
								</tr>
								
								<tr>
									<td id='titleBlueLineBottom' colspan='2'></td>
								</tr>
								
								<tr height='30'><td colspan='2'></td></tr>
							</table>
						
							<?php
							if($contadorHallazgos>0){
							?>
								<table border='0' align='center' width='700px'>
									<tr id='iconosTexto2'>
										<td align='center' width='180px'>Código</td>
										<td align='left' width='300px'>Titulo</td>
										<td align='center' width='150px'>Tratamiento </td>
										<td align='center' width='130px'>Estatus</td>
										<td align='center' width='20px'></td>
									</tr>
									
									<tr height='10px'><td colspan='4'></td></tr>
									<?php
									for($indice=0;$indice<count($claveHallazgo);$indice++){	

									/*if ($semaforoTerminada[$indice] == 'ASIGNAR') {
									$semaforoTerminada[$indice] = 'POR ATENDER';
									}elseif($semaforoTerminada[$indice] == 'EVALUACION' || !empty($evaluada[$indice])){
									$semaforoTerminada[$indice] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$indice] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$indice] != 'EVALUACION' || $semaforoTerminada[$indice] != 'ASIGNAR' && empty($evaluada[$indice])){
												$semaforoTerminada[$indice] = "EN CURSO";	
				                    }*/

										echo "	
										<tr>
											<td align='center' id='fileItem' width='180px'>
												<a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$claveHallazgo[$indice]</a></td>
											<td align='left' id='fileItem' width='300px'><a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$tituloHallazgo[$indice]</td>
											<td align='center' id='fileItem' width='150px'>".$enlaceCorrectiva[$indice]."</td>
											<td align='center' id='fileItem' width='80px'>$semaforoTerminada[$indice]</td>
											<td align='right' width='20px'>";
											echo "</td>
										</tr>";
									}
									?>
									<tr height='30px'><td colspan='4'></td></tr>

									<tr>
										<td id='titleBlueLineBottom' colspan='4'></td>
									</tr>
									
									<tr height='30'><td colspan='2'></td></tr>
									
								</table>						
							<?php
							}
						} else if ($statusAuditoria == 4){
						?>
							<table width='700px' align="center">
								<tr height='60px'><td colspan='4'></td></tr>
								
								<tr>
									<td align='left' id='titulo2'>Realización de la auditoría</td>	
								</tr>
								
								<tr>
									<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
									</td>
								</tr>
								<tr height='30px'><td colspan='4'></td></tr>
							</table>

							<table class='procede' style="width: 600px;" align="center" >
					         	<tr id='trValidacion' class='procedeFila' align="center"  style="display:block">
					     	 		<td id="tdProcede" class='procedeColumna' style="width: 35%"  align="center" bgcolor="#42CB27"><font 	
					         		color="white">Procede</font></td>
					   			</tr>
					         </table>

							<table  border='0' align='center' width='50%'>
								<tr height='10px'><td></td></tr>

								<tr align='center'>
									<td><?php echo $personaRealizo;?> realizo la auditoría</td>
								</tr>
							
								<tr align='center'>
									<td><?php echo $comentarioRealizo;?></td>
								</tr>

								<tr align='center'>
									<td><?php echo $fechaRealizo;?></td>
								</tr>
								
								<tr height='30px'><td colspan='4'></td></tr>							

							</table>
							<?php						
							$contadorHallazgos = 0;
							$contadorTerminadas = 0;
							$contadorCorrectivaTerminada = 0;


							$d = $INTRANETV2->Execute("SELECT DISTINCT xt_claveHallazgo, xt_titulo, xd_fecha, SUBSTRING_INDEX(xt_ruta,'/',-1) FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave'");
							while($registroHallazgos = $d->fetchRow()) {
								$claveHallazgo[$contadorHallazgos]  = $registroHallazgos[0];
								$tituloHallazgo[$contadorHallazgos] = $registroHallazgos[1];
								$fechaHallazgo[$contadorHallazgos]  = $registroHallazgos[2];
								$rutaHallazgo[$contadorHallazgos]  = $registroHallazgos[3];
								$c = $INTRANETV2->Execute("SELECT xt_claveTratamiento, xt_tipoTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$claveHallazgo[$contadorHallazgos]'");
								while($registroTratamientos = $c->fetchRow()) {
									$claveTratamiento = $registroTratamientos[0];
									$tipoTratamiento = $registroTratamientos[1];
									$terminado = $INTRANETV2->getOne("
											SELECT
												xn_status
											FROM
												SGI_Acciones_Preventivas_Correctivas
											WHERE
												xt_claveAccion = '$claveTratamiento'
										");
									if($terminado == 1){
										$contadorCorrectivaTerminada++;
									}

									if($tipoTratamiento == 'SOLICITUD'){
										$tipoSolicitud = $INTRANETV2->getOne("
												SELECT
													xt_tipoSolicitud
												FROM
													SGI_Quejas_Solicitudesv2
												WHERE
													xt_quejaSolicitud = '$claveTratamiento'
											");
										if($tipoSolicitud == 'MT'){
											$pagina = "https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaMantenimiento_Sistema.php?";
										} else if ($tipoSolicitud == 'PY'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaProyectoFuncionalidad.php?";
										} else if ($tipoSolicitud == 'AV'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'AB'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'ST'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'DS'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										} else if ($tipoSolicitud == 'EA'){
											$pagina = "http://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/fichaSolicitudv2.php?";
										}
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='".$pagina."codigo=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";

										$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("
											SELECT
												xt_status
											FROM
												SGI_Quejas_Solicitudesv2 SSE
											WHERE
												xt_quejaSolicitud = '$claveTratamiento'
											ORDER BY
												xd_fecha DESC
										");	

										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 1<br>";

									if ($semaforoTerminada[$contadorHallazgos] == 'SIN ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
										$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'TERMINADA'){
										$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'TERMINADA' || $semaforoTerminada[$contadorHallazgos] != 'SIN ASIGNAR'){
										$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }

									}else if ($tipoTratamiento == 'PREVENTIVA' || $tipoTratamiento == 'CORRECTIVA'){

									if($tipoTratamiento == 'PREVENTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaPreventivav2.php?id=".$claveTratamiento."'  id='fileItem' style='text-decoration:none;'>".$claveTratamiento."</a>";
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 2<br>";
									}else if ($tipoTratamiento == 'CORRECTIVA'){
										$enlaceCorrectiva[$contadorHallazgos] = "<a href='fichaCorrectivav2.php?id=".$claveTratamiento."'  id='fileItem' namw='".$tipoTratamiento."' style='text-decoration:none;'>".$claveTratamiento."</a>";
									}
										$semaforoTerminada[$contadorHallazgos]." ".$tipoTratamiento." 3<br>";
								$semaforoTerminada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$claveTratamiento' ORDER BY xn_etapa DESC");

								$evaluada[$contadorHallazgos] = $INTRANETV2->getOne("SELECT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$claveTratamiento'");
									
									if ($semaforoTerminada[$contadorHallazgos] == 'ASIGNAR' || $semaforoTerminada[$contadorHallazgos] == 'ASIGNADA') {
									$semaforoTerminada[$contadorHallazgos] = 'EN CURSO';
									}elseif($semaforoTerminada[$contadorHallazgos] == 'EVALUACION' || !empty($evaluada[$contadorHallazgos])){
									$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
									}elseif ($semaforoTerminada[$contadorHallazgos] == 'DECISION' && !empty($evaluada[$contadorHallazgos])) {
				                    	$semaforoTerminada[$contadorHallazgos] = 'ATENDIDO';
				                    }elseif ($semaforoTerminada[$contadorHallazgos] == '') {
				                    	$semaforoTerminada[$contadorHallazgos] = "";
				                    }elseif($semaforoTerminada[$contadorHallazgos] != 'EVALUACION' || $semaforoTerminada[$contadorHallazgos] != 'ASIGNAR' && empty($evaluada[$contadorHallazgos])){
												$semaforoTerminada[$contadorHallazgos] = "EN CURSO";	
				                    }
								}
							}
								$contadorHallazgos++;

								}
							
							?>
							<!-- hallazgo 6 -->
							<table border='0' align='center' width='700px'>	
								<tr height='30px'><td colspan='4'></td></tr>						
								<tr>
									<td align='left' name="Hallazgos1" id='titulo2'><b>Hallazgos
									</b></td>
									
									<td align='right'>
										<a href='agregarHallazgoPopUp.php?clave=<?php echo $clave; ?>' target='popup' onclick="window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')">
											<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>
										</a>
									</td>	
								</tr>
								
								<tr>
									<td id='titleBlueLineBottom' colspan='2'></td>
								</tr>
								
								<tr height='30'><td colspan='2'></td></tr>
							</table>
						
							<?php $h = 0;
							if($contadorHallazgos>0){
							?>
								<table border='0' align='center' width='700px'>
									<tr id='iconosTexto2'>
										<td align='center' width='220px'>Código</td>
										<td align='left' width='300px'>Titulo</td>
										<td align='center' width='180px'>Tratamiento </td>
										<td align='center' width='180px'>Estatus</td>
										<td align='center' width='20px'></td>
									</tr>
									
									<tr height='10px'><td colspan='4'></td></tr>
									<?php
									for($indice=0;$indice<count($claveHallazgo);$indice++){	


										echo "	
										<tr>
											<td align='center' id='fileItem' width='120px'>
												<a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$claveHallazgo[$indice]</a></td>
											<td align='left' id='fileItem' width='500px'><a href='ficha_hallazgo.php?clave=$claveHallazgo[$indice]' id='fileItem' style='text-decoration:none;'>$tituloHallazgo[$indice]</td>
											<td align='center' id='fileItem' width='150px'>".$enlaceCorrectiva[$indice]."</td>
											<td align='center' id='fileItem' width='80px'>$semaforoTerminada[$indice]</td>
											<td align='right' width='20px'></td>
										</tr>";
									}
									?>
									<tr height='30px'><td colspan='4'></td></tr>

									<tr>
										<td id='titleBlueLineBottom' colspan='4'></td>
									</tr>
									
									<tr height='30'><td colspan='2'></td></tr>
									
								</table>						
							<?php
							}
						}
						?>							
						<!-- //FINALIZAR -->
						<table border='0' align='center' width='700px'>
							<tr>
								<td class='titleBlueLineBottom'></td>
							</tr>					
							<tr height='50'px><td></td></tr>
						</table>										
					</div>				
				</form>
			</div>
		<?php
		}
		?>
		<br><br><br>
		<table border='0' align='center' name='Cuerpo' width='100%'>
			<tr>
				<td id='titleBlueLineBottom' colspan='3' width='100%'></td>
			</tr>
			<tr>
				<td id='nota_al_pie'>
					<center>Created by: Grupo Escalante Agencias Aduanales.</center>
				</td>
			</tr>
		</table>
		<br><br>		
	</body>
</html>

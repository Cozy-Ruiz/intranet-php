<?php 
/*
Programador: Guillermo Quezada Gómez
Fecha: Mayo del 2019
Contacto: gquezada@escalante.com.mx
*/
class Auditorias{

	public static function obtenAuditoriasPendientes($filtro){
		//obtengo datos de auditorias pendientes
		$sql = "SELECT
					DISTINCT DATE_FORMAT(A.xd_fecha,'%d-%m-%Y') Fecha,
					AH.xt_claveAuditoria Auditoria,
					A.xt_ciudad,
                    CASE
	                    WHEN A.xt_ciudad IN ('CMX','DF') THEN
	                            'Ciudad de México'
	                    WHEN A.xt_ciudad = 'TOL' THEN
	                            'Toluca'
	                    WHEN A.xt_ciudad = 'VER' THEN
	                            'Veracruz'
	                    WHEN A.xt_ciudad = 'NLR' THEN
	                            'Nuevo Laredo'
	                    WHEN A.xt_ciudad = 'CUN' THEN
	                            'Cancún'
	                    WHEN A.xt_ciudad = 'GRL' THEN
	                            'General'
                    END AS nombreCiudad,
                    AN.xt_nota AS nota
				FROM
				SGI_Auditorias A
				LEFT OUTER JOIN SGI_Auditorias_Hallazgos AH ON AH.xt_claveAuditoria = A.xt_claveAuditoria
				LEFT OUTER JOIN SGI_Auditorias_Hallazgos_Tratamientos AHT ON AHT.xt_claveHallazgo = AH.xt_claveHallazgo
				LEFT OUTER JOIN SGI_Acciones_Preventivas_Correctivas AC ON AC.xt_claveAccion = AHT.xt_claveTratamiento
				LEFT OUTER JOIN SGI_Quejas_Solicitudesv2 QS ON QS.xt_quejaSolicitud = AHT.xt_claveTratamiento
				LEFT OUTER JOIN SGI_Auditorias_Notas AN on AN.xt_claveAuditoria = A.xt_claveAuditoria
				WHERE
					(
						AHT.xt_claveHallazgo != ''
						OR AHT.xt_claveHallazgo IS NOT NULL
					)
				AND (
					(QS.xt_status != 'TERMINADA')
					OR ((
						SELECT
							xt_titulo
						FROM
							SGI_Acciones_Preventivas_Correctivas_Etapas
						WHERE
							xt_codigoAccion = AC.xt_claveAccion
						GROUP BY
							xn_etapa DESC
						LIMIT 1
					) != 'EVALUACION')
				)
				$filtro ORDER BY A.xt_ciudad ASC";

		return $sql;
	}

	public static function obtenSolicitudesAC_Pendientes($auditoria){
		//obtengo datos de solicitudes y ac pendientes
		$sql = "SELECT
					DISTINCT AHT.xt_claveTratamiento,AHT.xt_tipoTratamiento
				FROM
				SGI_Auditorias_Hallazgos AH
				LEFT OUTER JOIN SGI_Auditorias_Hallazgos_Tratamientos AHT ON AHT.xt_claveHallazgo = AH.xt_claveHallazgo
				LEFT OUTER JOIN SGI_Acciones_Preventivas_Correctivas AC ON AC.xt_claveAccion = AHT.xt_claveTratamiento
				LEFT OUTER JOIN SGI_Quejas_Solicitudesv2 QS ON QS.xt_quejaSolicitud = AHT.xt_claveTratamiento
				WHERE
					(
						AHT.xt_claveHallazgo != ''
						OR AHT.xt_claveHallazgo IS NOT NULL
					)
				AND (
					(QS.xt_status != 'TERMINADA')
					OR ((
						SELECT
							xt_titulo
						FROM
							SGI_Acciones_Preventivas_Correctivas_Etapas
						WHERE
							xt_codigoAccion = AC.xt_claveAccion
						GROUP BY
							xn_etapa DESC
						LIMIT 1
					) != 'EVALUACION')
				) AND AH.xt_claveAuditoria = '$auditoria' $filtro";

		return $sql;
	}

	public static function obtenSolicitudesCorrectiva($tratamiento){
		//obtengo datos de solicitudes y ac pendientes
		$sql = "SELECT
					*
				FROM
					SGI_Preventivas_Correctivas_Plan_Accion PCA
				LEFT OUTER JOIN SGI_Quejas_Solicitudesv2 QS ON QS.xt_quejaSolicitud = PCA.xt_codigoSolicitud
				WHERE
					QS.xt_status != 'TERMINADA'
				AND xt_codigoAccion = '$tratamiento'";

		return $sql;
	}

	public static function obtenPagina($tipoSolicitud){
		//obtengo datos de solicitudes y ac pendientes
		if($tipoSolicitud == 'MT'){
			$pagina = "fichaMantenimiento_Sistema.php?";
		} else if ($tipoSolicitud == 'PY'){
			$pagina = "fichaProyectoFuncionalidad.php?";
		}else {
			$pagina = "fichaSolicitudv2.php?";
		}

		return $pagina;
	}	

	public static function obtenTipoSolicitud($solicitud){
		//obtengo datos de solicitudes y ac pendientes
		$sql = "SELECT
					xt_tipoSolicitud
				FROM
					SGI_Quejas_Solicitudesv2
				WHERE
					xt_quejaSolicitud = '$solicitud'";

		return $sql;
	}	

	public static function obtenCiudadesFiltro(){
		//obtengo catalogo de ciudades disponibles para filtrar auditorias
		$sql = "SELECT DISTINCT 
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
                        WHEN xt_ciudad = 'GRL' THEN
                                'General'
                        END AS valorCiudad
                FROM 
                        SGI_Auditorias
            ";

		return $sql;
	}

	public static function obtenPdrSolicitud($solicitud){
		$sql = "SELECT
					xt_pdr
				FROM
					SGI_Quejas_Solicitudesv2
				WHERE
					xt_quejaSolicitud = '$solicitud'";

		return $sql;
	}

	public static function obtenPdrFiltro(){

		$sql = "SELECT DISTINCT
					S.xt_pdr,U.xt_nombre
				FROM
					SGI_Quejas_Solicitudesv2 S
				LEFT OUTER JOIN IntranetGEA_USUARIOS U ON U.kp_usuario = S.xt_pdr
				WHERE xt_pdr != '' AND xt_nombre != ''
				ORDER BY xt_nombre";

		return $sql;
	}
			
}

<?php error_reporting(0); ?>
<?php

require_once("../ConexionDBT.php");

$nombreUsuario = $_GET['user'];

$lista = array(
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
"TableroVisitas.php"
);

foreach ($lista as $pagina) {
	echo "INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$pagina','$nombreUsuario') <br>";
	$INTRANET->Execute("INSERT INTO IntranetGEA_USUARIOS_CATALOGO_PHP(kf_phpId, kf_usuarioId) VALUES('$pagina','$nombreUsuario') ");
}
?>

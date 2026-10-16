
<?php 
/*
Programador: Guillermo Quezada Gómez
Fecha: Mayo del 2019
Contacto: gquezada@escalante.com.mx
*/

//incluyo archivos necesarios de conexion y consultas
require_once("../../ConexionIntranet2.php");
require_once("../../AdministracionProyectos/_PPM/proyectoSQL.php");
//si recibo un evento ejecuto el bloque de codigo
if (isset($_REQUEST["evento"])) {
	//agrego nueva relacion de proyecto - reunion
	if ($_REQUEST["evento"] == "agregaProyectoReunion") {
		//elimino espacios que se hayan agregado erroneamente
		$codigoProyecto = str_replace(' ', '', $_REQUEST["codigoProyecto"]);
		$reunion = $_REQUEST["reunion"];
		//obtengo el id del proyecto ya que recibimos el codigo completo
		$idProyecto = $INTRANETV2->GetOne("SELECT xn_proyectoId FROM SGI_Portafolio_Proyectos WHERE xt_codigoProyecto = '$codigoProyecto'");
		//hago la insercion del registro, si se inserta imprimo un tru sino envio un error
		if ($INTRANETV2->Execute("INSERT INTO SGI_Reuniones_Proyectos(xn_proyectoId,xt_codigoReunion) VALUES($idProyecto,'$reunion')")){
			echo true;
		}else{
			echo "Ocurrio un error!";
		}
	}

	//eliminar una relacion de reunion - proyecto
	if ($_REQUEST["evento"] == "eliminaProyectoReunion") {
		//declaro variables con valores recibidos
		$idProyecto = $_REQUEST["idProyecto"];
		$reunion = $_REQUEST["reunion"];
		//si se inserta el registro imprimo un true en caso contrario imprimo un error
		if ($INTRANETV2->Execute("DELETE FROM SGI_Reuniones_Proyectos WHERE xn_proyectoId = $idProyecto AND xt_codigoReunion = '$reunion'")){
			echo true;
		}else{
			echo "No se pudo eliminar!";
		}
	}

	//ver pdf
	if ($_REQUEST["evento"] == "verDocumento") {
		//declaramos la variable archivo
		$archivo = $_REQUEST["archivo"];

		/*
		echo '<object  data="data:Application/pdf,'.rawurlencode(file_get_contents($diagrama)).'" type="application/pdf" width="950px" height="700px">';
			echo "<p>";
				echo "Si este mensaje aparece su navegador no soporta el plugin para el PDF.";
				echo "No obstante puede descargar el archivo en este <a href='data:Application/pdf,".$diagrama."' download='".$diagrama."'>enlace</a>";
			echo "</p>";
		echo "</object>";
		*/

		$html = '
			<div class="contenidoPDF">
			'.getcwd().' - '.$archivo.'
			<object data="data:Application/pdf,'.rawurlencode(file_get_contents("../../AdministracionProyectos/_PPM/".$archivo)).'" type="application/pdf" width="100%" height="100%">

				<embed src="data:Application/pdf,'.rawurlencode(file_get_contents("../../AdministracionProyectos/_PPM/".$archivo)).'">
					<p>Este navegador no es compatible para visualizar el archivo: <a href="data:Application/pdf,'."../../AdministracionProyectos/_PPM/".$archivo.'" download="'.$archivo.'">Download</a>.</p>
				</embed>
				
			</object>
			<div class="boton-gris" style="cursor: pointer">Regresar</div>
			</div>';

		echo $html;
	}

	//actualiza campo SGI_Portafolio_Proyectos
	if ($_REQUEST["evento"] == "actualizaCampoProyecto") {
		//declaro variables con valores recibidos
		$idProyecto = $_REQUEST["idProyecto"];
		$campo = $_REQUEST["campo"];
		$contenido = $_REQUEST["contenido"];
		$usuario = $_REQUEST["usuario"];
		$etapaNueva = "";
		if ($campo == 'xt_responsableUsuario') {
			$etapaNueva = 1;
		}elseif ($campo == 'xt_autorizaUsuario') {
			$etapaNueva = 3;
		}

		//si se inserta el registro imprimo un true en caso contrario imprimo un error
		if ($INTRANETV2->Execute("UPDATE SGI_Portafolio_Proyectos SET $campo = '$contenido' WHERE xn_proyectoId = $idProyecto")){
			$sql = proyectoSQL::obtenEtapaMax($idProyecto);
			$etapaMax = $INTRANETV2->GetRow($sql);
			$etapaActual = "";
			if (isset($etapaMax[0])) {
				$etapaActual = $etapaMax[0];
			}
			if (!empty($etapaActual)) {
				if ($etapaActual < $etapaNueva) {
					$INTRANETV2->Execute("INSERT INTO SGI_Portafolio_Proyecto_Etapas(xn_proyectoId,xn_etapaId,xt_usuario) VALUES('".$idProyecto."','".$etapaNueva."','".$usuario."')");
				}
			}elseif ($etapaNueva == 1) {
				$INTRANETV2->Execute("INSERT INTO SGI_Portafolio_Proyecto_Etapas(xn_proyectoId,xn_etapaId,xt_usuario) VALUES('".$idProyecto."','".$etapaNueva."','".$usuario."')");
			}
			
			echo true;	
			
		}else{
			echo "Error: ".mysql_error();
		}
	}

	//agrega nuevo documento categoria
	if ($_REQUEST["evento"] == "agregaDocumentoCategoria") {
		//declaro variables con valores recibidos
		$idProyecto = $_REQUEST["idProyecto"];
		$documento = $_REQUEST["documento"];
		//si se inserta el registro imprimo un true en caso contrario imprimo un error
		if ($INTRANETV2->Execute("INSERT INTO SGI_Portafolio_Tipo_Documento(xt_tipoDocumento) VALUES('".$documento."')")){
			if ($INTRANETV2->Execute("INSERT INTO SGI_Portafolio_Documentos(xn_proyectoId,xt_tipoDocumento,xn_version) VALUES($idProyecto,'".$documento."',1)")) {
				echo true;
			}
			
		}else{
			echo "Ocurrió un error!";
		}
	}
	
	//agrega nuevo documento categoria
	if ($_REQUEST["evento"] == "validaVersionEliminar") {
		//declaro variables con valores recibidos
		$idArchivo = $_REQUEST["idArchivo"];
		$idProyecto = $_REQUEST["idProyecto"];
		$documento = $_REQUEST["documento"];
		//si se inserta el registro imprimo un true en caso contrario imprimo un error
		$datosE = $INTRANETV2->GetRow("SELECT xn_version, xt_tipoDocumento 
			FROM SGI_Portafolio_Documentos WHERE xn_documentoId = $idArchivo LIMIT 1");

		$versionMax = $INTRANETV2->GetOne("SELECT max(xn_version) FROM SGI_Portafolio_Documentos WHERE xt_tipoDocumento = '".$datosE[1]."' AND xn_proyectoId = $idProyecto");

		if ($datosE[0] == $versionMax) {
			echo true;
		}else{
			echo "<script>alert('No es posible eliminar una version anterior!');</script>";
		}
	}

	//cierro proyecto
	if ($_REQUEST["evento"] == "cerrarProyecto") {
		//declaro variables con valores recibidos
		$idProyecto = $_REQUEST["idProyecto"];
		$usuario = $_REQUEST["usuario"];

		if ($INTRANETV2->Execute("INSERT INTO SGI_Portafolio_Proyecto_Etapas(xn_proyectoId,xn_etapaId,xt_usuario) VALUES(".$idProyecto.",5,'".$usuario."')")){
			echo true;
		}else{
			echo "Ocurrió un error!";
		}
	}

	//agrego nota de auditoria
	if ($_REQUEST["evento"] == "agregaNotaAuditoria") {
		//declaro variables con valores recibidos
		$auditoria = $_REQUEST["auditoria"];
		$nota = $_REQUEST["nota"];

		$existe = $INTRANETV2->GetOne("SELECT 1 FROM SGI_Auditorias_Notas WHERE xt_claveAuditoria = '".$auditoria."'");

		if ($existe == 1) {
			if ($INTRANETV2->Execute("UPDATE SGI_Auditorias_Notas SET xt_nota = '".$nota."' WHERE xt_claveAuditoria = '".$auditoria."'")){
				echo true;
			}else{
				echo "Ocurrió un error al actualizar!";
			}
		}else{
			if ($INTRANETV2->Execute("INSERT INTO SGI_Auditorias_Notas(xt_claveAuditoria,xt_nota) VALUES('".$auditoria."','".$nota."')")){
				echo true;
			}else{
				echo "Ocurrió un error al insertar!";
			}
		}
	}
}
?>
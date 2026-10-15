
<?php
/*
Programador: Guillermo Quezada Gómez
Fecha: Junio del 2019
Contacto: gquezada@escalante.com.mx
*/

//incluyo archivos de conexiones y de consultas
$nombrephp='pendientesAuditorias.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
require_once("../../Consultas/ConsutasGlobales.php");
require_once("auditoriasSQL.php");

error_reporting(E_PARSE);
//declaro variables
$var = 0;
//obtengo datos de auditorias pendientes
$filtro = "";
if (isset($_POST['ciudad']) && $_POST['ciudad'] != "" && $_POST['ciudad'] != "Todas" ) {
	$filtro .= " AND A.xt_ciudad = '".$_POST['ciudad']."'";
}
if (isset($_POST['ciudad'])  && $_POST['ciudad'] == "Todas" ) {
	$filtro .= " AND A.xt_ciudad != ''";
}
if (isset($_POST['anio']) && $_POST['anio'] != "") {
	$filtro .= " AND DATE_FORMAT(A.xd_fecha,'%Y') = '".$_POST['anio']."'";
}
//obtengo arreglo de todas las auditorias con hallazgos pendientes
$sql = Auditorias::obtenAuditoriasPendientes($filtro);
$pendientes = $INTRANETV2->GetArray($sql);

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
	<head>
        <meta charset='utf-8'>
        <title>Pendientes Auditorias</title>";
		
		//incluyo el estilo del usuario
		if($estiloUsuario == 1){
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>
            <?php
		}else if($estiloUsuario == 2){
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>
            <?php
		}
		?>

        <!-- incluyo archivos js y css -->
        <link rel='shortcut icon' type='image/x-icon' href='../../Imagenes/ICN_PestanaWebGE.png'>
        <link type='text/css' href='../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.13.custom.css' rel='stylesheet'/>
        <link type='text/css' href='css/pendientesAuditorias.css' rel='stylesheet'/>
        <script type='text/javascript' src='../../Librerias/JQuery/js/jquery-1.6.2.min.js'></script>
        <script type='text/javascript' src='../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js'></script>
        <script type='text/javascript' src='js/pendientesAuditorias.js'></script>

<?php
echo "</head><body>";

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='pendientesAuditorias.php' id='breadcrumbs'> Pendientes de auditorias </a>";

echo "<div id='wrapperFicha' align='center' style='width:100%'>
	
	<table border='0' align='center' name='Encabezado' width='80%'>
	
		<tr height='12px'>
			<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>
		</tr>
		
		<tr height='10px'></tr>
		
		<tr>
			<td align='left' id='breadcrumbs'>Fecha: ".date('d-m-Y')."</td>
		</tr>
		
		<tr height='20px'></tr>

		<tr>
			<td align='center' id='titulo1'>
				<font>Pendientes de auditorias</font>
			</td>
		</tr>
		<tr>
			<td align='center' valign='top' height='20px'>
				<table border='0' align='center'>
					<tr height='20px'>
						<td valign='middle'>
							<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>
							<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>
						</td>
						
						<td valign='middle'>
							<font style='display:inline-block;'>".$breadcrumb."</font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>";
	//muestro filtros de auditorias
	echo "
	<table border='0' align='center' width='80%'>
	    <tr style='height:20px'></tr>
	    <tr>
	        <td colspan='3' align='center' id='iconosTexto2'><a href='javascript:void(0);' onclick='muestraFiltro();' style='color:rgb(0,124,189);'>Filtro</a> </td>
	    </tr>
	    <tr height='10'>
	    </tr>
	    <tr style='height:20px'></tr>
	</table>

	<form method='POST' action='pendientesAuditorias.php' id='filtroTablero' style='display:none;'>
            <table border='0' width='35%' align='center'>
                <tr>
                    <td align='center'>
                        <p>Oficina</p>
                    </td>
                    <td width='25px'></td>
                    <td align='center'>
                        <p>Año</p>
                    </td>
                    <td width='25px'></td>
                    <td align='center'>
                        <p>PDR</p>
                    </td>
                </tr>
                <tr>
                    <td colspan='8' id='titleBlueLineTop'></td>
                </tr>
                <tr style='height:5px'>
                <tr>
                    <td align='center'>
                        <div> ";
                                  opcionesCiudades();
                            echo "
                             
                        </div>
                    </td>
                    <td width='25px'></td>
                    <td align='center'>
                        <div style='margin-right:10%;'>";
                        opcionesanio();
                        echo "
                             
                        </div>
                    </td>

                    <td width='25px'></td>
                    <td align='center'>
                        <div style='margin-right:10%;'>
                            <select name='pdr'>
                                <option value=''>Todos...</option>";
                                //consulto el catalogo de pdr
								$sql = Auditorias::obtenPdrFiltro();
                                $pdrArray = $INTRANETV2->GetArray($sql);
                                //muestro las opciones de pdr
                                foreach ($pdrArray as $key => $pdr) {
                                	
                                    if (isset($_POST['pdr'])) {
                                        if ($_POST['pdr'] == $pdr["xt_pdr"]) {
                                        echo "<option SELECTED value=".$pdr["xt_pdr"].">".$pdr["xt_nombre"]."</option>";
                                        }else{
                                        echo "<option value=".$pdr["xt_pdr"].">".$pdr["xt_nombre"]."</option>";
                                    }
                                    }else{
                                        echo "<option value=".$pdr["xt_pdr"].">".$pdr["xt_nombre"]."</option>";
                                    }
                                }

                            echo "
                            </select>
                        </div>
                    </td>
                </tr>
                <tr style='height:10px'></tr>
                <tr>
                    <td colspan='6'>
                        <center><input type='image' name='Enviar' onclick='SubmitForm(this.form);' align='center' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='30'></center
                    </td>
                </tr>
            </table>
        </form>";
	
	//banana de navegacion intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";
	
	//banana de navegacion intranet
	$html = "<table border='0' align='center' style='display:none;'>
	</table>";

	//TABLERO
    $i=0;
    $anterior="";
    $hallazgos="";
    $auditoriasArray = Array();
    $ciudadesArray = Array();
    $actual = "";
    //muestro las auditorias pendientes
    $ciudadActual = "";
    $c = 0;

    $html .= "
    <table border='0' align='left' width='90%' style='margin-left:10%;'>
        <tr id='titulo2'>
            <th align='left' width='15%'>Auditorías</th>
            <th align='center' width='31%'>Acción correctiva</th>
            <th align='center' width='34%'>Solicitud</th>
            <th align='center' width='20%'>PDR</th>
        </tr>

        <tr>
        	<td colspan='5' id='titleBlueLineTop'></td>
        </tr>
	</table>";

	//recorro todo el arreglo de auditorias pendientes que obtuve de la base de datos
	foreach ($pendientes as $key => $value) {
	//obtengo todos los tratamientos de la auditoria ya sea ac o solicitud
	$sql = Auditorias::obtenSolicitudesAC_Pendientes($value["Auditoria"]);
	$sol_ac_pendientes = $INTRANETV2->GetArray($sql);
	//inicio la impresion del tablero de auditorias pendientes
	$html .= "
	<table border='0' width='100%' style='margin-left:10%;'>

	    <tr id='fileItem'>
	        <td align='left' style='cursor:pointer;' width='15%'>
				<a href='../../SistemaGestionIntegral/Intranetv2/auditoria_actualizar.php?clave=".$value["Auditoria"]."' id='fileItem' style='text-decoration:none;'>".$value["Auditoria"]."</a>
	    	</td>
	    	<td width='80%'>";

	$html .= "
	<table width='100%' id='".$value["Auditoria"]."'>";

	    $html .= "
	    <tr>
	        <td align='left' style='width:100%' colspan='3'>";

		    $html .= "
		    <table width='85%' class='table-striped' style='border-collapse: collapse;'>		    	
		    	<tr>
		        	<td colspan='5' id='titleBlueLineTop'></td>
		        </tr>
			    <tr align='left' id='fileItem'>
			    ";
			    //recorro el arreglo de solicitudes y acciones pendientes
			    foreach ($sol_ac_pendientes as $key => $value1) {
			    	//si se trata de una solicitud
			        if ($value1["xt_tipoTratamiento"] == 'SOLICITUD') {
			        	//obtengo tipo de solicitud para determinar la pagina del link
			        	$sql = Auditorias::obtenTipoSolicitud($value1["xt_claveTratamiento"]);
						$tipoSolicitud = $INTRANETV2->getOne($sql);
						//dependiendo del tipo de solicitud obtengo la pagina
						$pagina = Auditorias::obtenPagina($tipoSolicitud);
						//obtengo el pdr de la solicitud
						$sql = Auditorias::obtenPdrSolicitud($value1["xt_claveTratamiento"]);
						$pdr = $INTRANETV2->GetOne($sql);
						//creo el boton con link de pagina
						$enlaceSolicitud = "<a href='../../ComunicacionInterna/solicitudesBacklog/solicitudesv2/".$pagina."codigo=".$value1["xt_claveTratamiento"]."' id='fileItem' style='text-decoration:none;'>".$value1["xt_claveTratamiento"]."</a>";
						//cuando no existe accion correctiva no aplica
				        $datos = "
				        <td align='center' id='fileItem' width='33%'>No aplica</td>
				        <td align='center' width='67%'>
					        <table width='100%' cellspading='0'>
					        	<tr>
							        <td align='center'>AA".$enlaceSolicitud."</td>
							        <td align='center' width='25%'>".$pdr."</td>
					        	</tr>
					        </table>
				        </td>";
				        //si se recibe un filtro por pdr comparo si es igual al consultado y lo muestro
				        if (isset($_REQUEST["pdr"])) {
				        	if ($_REQUEST["pdr"] == $pdr) {
				        		$html .= $datos;
				        	}
				        }else{
				        	$html .= $datos;
				        }

			        }elseif ($value1["xt_tipoTratamiento"] == 'CORRECTIVA') {
			        	//si se trata de una accion correctiva
			        	$allAc = '';
			        	//obtengo todas las solicitudes de una accion correctiva
			        	$sql = Auditorias::obtenSolicitudesCorrectiva($value1["xt_claveTratamiento"]);
			        	//determino el enlace
						$enlaceCorrectiva = "<a href='fichaCorrectivav2.php?id=".$value1["xt_claveTratamiento"]."'  id='fileItem' style='text-decoration:none;'>".$value1["xt_claveTratamiento"]."</a>";

				        $html .= "
				        <td align='center' style='width:33%'>".$enlaceCorrectiva."</td>";

				        $html .= "<td align='center' style='width:67%' id='fileItem'>  ";
				        $ac = $INTRANETV2->GetArray($sql);

			        	if(count($ac) > 0){
			        			 
			        		$html .= "
			        		<table width='100%'>";
			        		//si tengo mas de una solicitud pr accion correctiva la muestro dentro de una tabla en un td de la ac
				        	foreach ($ac as $key => $valueac) {
				        		//obtengo tipo de solicitud
				        		$sql = Auditorias::obtenTipoSolicitud($valueac["xt_codigoSolicitud"]);

						        $tipoSolicitud = $INTRANETV2->getOne($sql);
						        //obtengo pagina segun tipo de solicitud
								$pagina = Auditorias::obtenPagina($tipoSolicitud);
								//obtengo el pdr de la solicitud
								$sql = Auditorias::obtenPdrSolicitud($valueac["xt_codigoSolicitud"]);
								$pdr = $INTRANETV2->GetOne($sql);

								$datos = "
								<tr>
									<td align='center'><a href='../../ComunicacionInterna/solicitudesBacklog/solicitudesv2/".$pagina."codigo=".$valueac["xt_codigoSolicitud"]."' id='fileItem' style='text-decoration:none;'>".$valueac["xt_codigoSolicitud"]."</a>
									</td>
									<td align='center' style='width:25%'>".$pdr."</td>
								</tr>";

								//si se recibe un filtro por pdr comparo si es igual al consultado y lo muestro
						        if (isset($_REQUEST["pdr"])) {
						        	 if($_REQUEST["pdr"] !=""){
						        	 						        	if ($_REQUEST["pdr"] == $pdr) {
						        	 						        		$html .= $datos;
						        	 						        	}
						        	 						        }else{
						        	 						        	$html .= $datos;
						        	 						        }}
						        	 						        else
						        	 						        {
						        	 						        	$html .= $datos;
						        	 						        }
				        	}

				        	$html .= "</table>";

			        	}
				      
				        $html .= "</td>";
			        }

		        		$html .= "
		    		</tr>";
			    }

		    	$html .= "	        
		    	<tr>
		        	<td colspan='5' id='titleBlueLineTop'></td>
		        </tr>
		    </table>
	    	</td>";
	    	
	    $html .= "
	    </tr>
	</table>
	    	</td>
	    </tr>
	</table>";
	}

		$html .= "
		</div>
	</body>
</html>";

//pie de pagina con datos de la empresa
$html .= "
<table border='0' align='center' width='100%'>
	<tr>
		<td id='titleBlueLineBottom'></td>
	</tr>
	<tr>
		<td style='color:#007cbd;text-align:center;font-family:Arial'>Created by: Grupo Escalante Agencias Aduanales.</td>
	</tr>
	<tr height='100px'><td></td></tr>
</table>";
//imprimo todo el contenido html almacenado en mi variable
echo $html;

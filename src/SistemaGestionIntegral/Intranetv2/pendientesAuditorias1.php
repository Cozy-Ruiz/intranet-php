<!-- incluyo estilos para el tablero -->
<style type="text/css">
	.table-striped>tbody>tr:nth-child(odd)>td, 
	.table-striped>tbody>tr:nth-child(odd)>th {
	background-color: #ececec;
	}
	.table-striped>tbody>tr:nth-child(even)>td, 
	.table-striped>tbody>tr:nth-child(even)>th {
	background-color: #FFFFFF;
	}
	.table-striped>thead>tr>th {
	 background-color: #FFFFFF;
	}
</style>

<?php
//incluyo archivos de conexiones y de consultas
$nombrephp='pendientesAuditorias.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
require_once("auditoriasSQL.php");

error_reporting(E_PARSE);
//declaro variables
$var = 0;
//obtengo datos de auditorias pendientes
$filtro = "";
if (isset($_POST['ciudad']) && $_POST['ciudad'] != "") {
	$filtro .= " AND A.xt_ciudad = '".$_POST['ciudad']."'";
}
if (isset($_POST['anio']) && $_POST['anio'] != "") {
	$filtro .= " AND DATE_FORMAT(A.xd_fecha,'%Y') = '".$_POST['anio']."'";
}

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
        <script type='text/javascript' src='../../Librerias/JQuery/js/jquery-1.6.2.min.js'></script>
        <script type='text/javascript' src='../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js'></script>
        <!-- creo funciones para mostrar barra de navegacion rapida -->
        <script type="text/javascript">
	        function reCargarPadre(){
	            opener.location.reload();
	            window.close();
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

		    function muestraFiltro(){
	            var form1 = document.getElementById("filtroTablero");
	            if(form1.style.display ==  'none'){
	                form1.style.display = 'block';          
	                }else{
	                    form1.style.display =  'none';
	                }
	        }
        </script>

<?php
echo "</head><body>";

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='pendientesAuditorias.php' id='breadcrumbs'> Pendientes de auditorias </a>";

echo "<div id='wrapperFicha' align='center' style='width:100%'>
	
	<table border='0' align='center' name='Encabezado' width='700px'>
	
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
	</table>

	<table border='0' align='center'   width='700px'>
	    <tr>
	        <td colspan='3' align='left' id='iconosTexto2'><a href='javascript:void(0);' onclick='muestraFiltro();' style='color:rgb(0,124,189);'>Filtro</a> </td>
	    </tr>
	    <tr height='10'>
	    </tr>
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
                </tr>
                <tr>
                    <td colspan='8' id='titleBlueLineTop'></td>
                </tr>
                <tr style='height:5px'>
                <tr>
                    <td align='center'>
                        <div>
                
                            <select name='ciudad'>
                                <option value=''>Selecciona.....</option>";

								$sql = Auditorias::obtenCiudadesFiltro();
                                $c = $INTRANETV2->Execute($sql);
                                while($p = $c->fetchRow()){
                                    $ciudadess = $p[1];
                                    $cdValors  = $p[0];

                                    if (isset($_POST['ciudad'])) {
                                        if ($_POST['ciudad'] == $cdValors) {
                                        	echo "<option SELECTED value='".$cdValors."'>".$ciudadess."</option>";
                                        }else{
                                        	echo "<option value='".$cdValors."'>".$ciudadess."</option>";
                                    	}
                                    }else{
                                        echo "<option value='".$cdValors."'>".$ciudadess."</option>";
                                    }  
                                }
                            echo "
                            </select>
                        </div>
                    </td>
                    <td width='25px'></td>
                    <td align='center'>
                        <div style='margin-right:10%;'>
                            <select name='anio'>
                                <option value=''>Selecciona......</option>";
                                for($a=0;$a<=3;$a++){
                                    $anio = date("Y") - $a;
                                    if (isset($_POST['anio'])) {
                                        if ($_POST['anio'] == $anio) {
                                        echo "<option SELECTED value=".$anio.">".$anio."</option>";
                                        }else{
                                        echo "<option value=".$anio.">".$anio."</option>";
                                    }
                                    }else{
                                        echo "<option value=".$anio.">".$anio."</option>";
                                    }
                                }
                            echo "
                            </select>
                        </div>
                    </td>
                </tr>
                <tr style='height:10px'></tr>
                <tr>
                    <td colspan='4'>
                        <center><input type='image' name='Enviar' onclick='SubmitForm(this.form);' align='center' src='../../Imagenes/ICN_BotonEnviar.png' width='60' height='20'></center
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
	foreach ($pendientes as $key => $value) {
		//obtengo todos los tratamientos de la auditoria ya sea ac o solicitud
		$sql = Auditorias::obtenSolicitudesAC_Pendientes($value["Auditoria"]);
		$sol_ac_pendientes = $INTRANETV2->GetArray($sql);
	$html .= "
	<table border='0' align='left' width='80%' style='margin-left:10%;'>";

		while ($value["xt_ciudad"] != $ciudadActual) {
			$html .= " 
			<tr style='height:20px'></tr>
	    	<tr id='titulo2'>
	    		<td colspan='5'>
	    		".$value["nombreCiudad"]."
	    		</td>
			</tr>
			
	        <tr>
	        	<td colspan='5' id='titleBlueLineTop'></td>
	        </tr>

	        <tr id='titulo2'>
	            <th align='center' style='width:25%'>Auditoría</th>
	            <th align='center' style='width:25%'>Acción Correctiva</th>
	            <th align='center' style='width:25%'>Solicitud</th>
	            <th align='center' style='width:20%'>Nota</th>
	        </tr>

	        <tr>
	        	<td colspan='5' id='titleBlueLineTop'></td>
	        </tr>";

	       $ciudadActual = $value["xt_ciudad"];
		}

	    $html .= "
	    <tr align='left' id='fileItem'>
	        <td align='center' style='width:25%' rowspan='".count($sol_ac_pendientes)."'>";

	        	$html .= "<a href='auditoria_actualizar.php?clave=".$value["Auditoria"]."' id='fileItem' style='text-decoration:none;'>".$value["Auditoria"]."</a>";

	        $html .= "
	        </td>";

	        foreach ($sol_ac_pendientes as $key => $value1) {

		        if ($value1["xt_tipoTratamiento"] == 'SOLICITUD') {
		        	//obtengo tipo de solicitud para determinar la pagina del link
		        	$sql = Auditorias::obtenTipoSolicitud($value1["xt_claveTratamiento"]);
					$tipoSolicitud = $INTRANETV2->getOne($sql);
					//dependiendo del tipo de solicitud obtengo la pagina
					$pagina = Auditorias::obtenPagina($tipoSolicitud);
					//creo el boton con link de pagina
					$enlaceSolicitud = "<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/".$pagina."codigo=".$value1["xt_claveTratamiento"]."' id='fileItem' style='text-decoration:none;'>".$value1["xt_claveTratamiento"]."</a>";

			        $html .= "
			        <td align='center' style='width:25%' id='fileItem'>No aplica</td>
			        <td align='center' style='width:25%'>".$enlaceSolicitud."</td>";

		        }elseif ($value1["xt_tipoTratamiento"] == 'CORRECTIVA') {

		        	$allAc = '';
		        	//obtengo todas las solicitudes de una accion correctiva
		        	$sql = Auditorias::obtenSolicitudesCorrectiva($value1["xt_claveTratamiento"]);
		        	//determino el enlace
					$enlaceCorrectiva = "<a href='fichaCorrectivav2.php?id=".$value1["xt_claveTratamiento"]."'  id='fileItem' style='text-decoration:none;'>".$value1["xt_claveTratamiento"]."</a>";

			        $html .= "
			        <td align='center' style='width:25%'>".$enlaceCorrectiva."</td>";

			        $html .= "<td align='center' style='width:25%' id='fileItem'>";
			        $ac = $INTRANETV2->GetArray($sql);

		        	if(count($ac) > 0){

		        		$html .= "
		        		<table>";
		        		//si tengo mas de una solicitud pr accion correctiva la muestro dentro de una tabla en un td de la ac
			        	foreach ($ac as $key => $valueac) {
			        		//obtengo tipo de solicitud
			        		$sql = Auditorias::obtenTipoSolicitud($valueac["xt_codigoSolicitud"]);
					        $tipoSolicitud = $INTRANETV2->getOne($sql);
					        //obtengo pagina segun tipo de solicitud
							$pagina = Auditorias::obtenPagina($tipoSolicitud);

							$html .= "<tr><td><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/".$pagina."codigo=".$valueac["xt_codigoSolicitud"]."' id='fileItem' style='text-decoration:none;'>".$valueac["xt_codigoSolicitud"]."</a></td></tr>";
			        	}

			        	$html .= "</table>";

		        	}else{
			        	$html .= "No aplica";
			        }
			      
			        $html .= "</td>";
		        }

		        		$html .= "
		        		<td align='center' style='width:25%'></td>
		    		</tr>";
	    }

    	$html .= "	        
    	<tr>
        	<td colspan='5' id='titleBlueLineTop'></td>
        </tr>";

	    $html .= "
	    </table>";
	}


		$html .= "
		</div>
	</body>
</html>";
echo $html;

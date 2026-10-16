<?php

$nombrephp = 'tableroRiesgos2.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

 error_reporting(E_PARSE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
            <meta charset="utf-8">
            <title>Tablero de Riesgos</title>
             <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
             <script>
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
			</script>
            
            <script>
				function show(valor){
					if(valor == 1){
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					} else if (valor == 0){
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
					}
				}
			</script> 

		   <script>
                (function($) {
                   $.fn.seleccionarDeseleccionarTodo = function(selectorCheckboxes, opciones) {
                      //opciones de configuración por defecto
                      var configuracion = {
                         habilitados: true
                      };
                      //Las extiendo con las opciones recibidas al invocar el plugin
                      $.extend(configuracion, opciones);
                   
                      this.each(function(){
                         //todos los checkboxes
                         var camosCheck = $(selectorCheckboxes);
                         //capa para los controles de seleccionar/deseleccionar checkboxes
                         elem = $(this);
                         
                         //creo el enlace para seleccionar todo
                         var enlaceSel = $('<a href="#">Seleccionar</a>');
                         //meto el enlace en la página
                         elem.append(enlaceSel);
                         //un separador de los enlaces
                         elem.append($("<span> | </span>"));      
                         //creo el enlace para deseleccionar todo
                         var enlaceDesel = $('<a href="#">Deseleccionar</a>');
                         //meto el enlace en la página
                         elem.append(enlaceDesel);
                         
                         //miro si los campos deben estar habilitados
                         if(configuracion.habilitados){
                            habilitarCampos();
                         }else{
                            deshabilitarCampos();
                         }
                         
                         ////////////////////////////////////////////////////////////
                         //funciones
                         ////////////////////////////////////////////////////////////
                         function habilitarCampos(){
                            camosCheck.removeAttr('disabled');
                         }
                         function deshabilitarCampos(){
                            camosCheck.attr('disabled', true);
                         }
                         function seleccionarTodosCampos(){
                            camosCheck.attr("checked","1");
                         }
                         function deseleccionarTodosCampos(){
                            camosCheck.removeAttr("checked");
                         }
                         //evento para el enlace de deseleccionar todos los campos
                         enlaceDesel.click(function(e){
                            e.preventDefault();
                            deseleccionarTodosCampos();
                         });
                         //añado un evento al enlace para seleccionar todos los campos
                         enlaceSel.click(function(e){
                            e.preventDefault();
                            seleccionarTodosCampos();
                         });
                         
                      });
                      return this;
                   };   
                })(jQuery); 
           </script>
        </head>
        
        <body>

<?php

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a> <a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral /</a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos /</a><a href='../Riesgos.php' id='breadcrumbs'> Riesgos</a>";



// ARREGLO DE PATENTES
$patentes = array("3061", "3034", "3925", "3371");
$patentesValor = array($patente3061, $patente3034, $patente3034, $patente3034);

$patente3061 = array("CMX", "CUN", "VER", "AIFA");
$patente3034 = array("VER", "TOL");
$patente3371 = array("CMX", "LAR", "NLR", "PAN", "COL");
$patente3925 = array("CMX", "QRO", "CUN", "PAN");

$contador = 0;
$t = $INTRANETV2->Execute("SELECT xt_sucursal, xt_nombre FROM SGI_Catalogo_Sucursales WHERE xt_sucursal != 'LRD'");
while($p = $t->fetchRow()){
	
	$ciudades[$contador] = $p[1];

	if($p[0] == "CMX"){
		
		$cdValor[$contador]  = $p[0];
		$contador++;
	}else{
		$cdValor[$contador]  = $p[0];
		$contador++;
	}
		
}unset($p);unset($t);unset($contador);
						
								
$ciudadesDisponibles = NULL;
$indice = 1;

$s = $INTRANETV2->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad");

while($r = $s->fetchRow()){
	
	if($r[0] == "DF"){
		
		$ciudadesDisponibles[$indice] = "CMX";
		$indice++;
		
	}else{
	
	$ciudadesDisponibles[$indice] = $r[0];
//	echo "$ciudadesDisponibles[$indice]<br>";
	$indice++;
		
	}
	
} unset($r); unset($s); unset($indice);

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
///OPCIONES INTERNAS
/*$internas[1] = "Operacionales";
$internas[2] = "Personales";
$internas[3] = "Organización";
$internas[4] = "Estratégicos";
///OPCIONES EXTERNAS
$externas[1] = "Catástrofes naturales";
$externas[2] = "Políticos";
$externas[3] = "Legales";
$externas[4] = "Mercado";
$externas[5] = "Económicos";
$externas[6] = "Entorno";


			
///OPCIONES AMENAZAS
$amenazas[1] = "Muy Baja";
$amenazas[2] = "Baja";
$amenazas[3] = "Media";
$amenazas[4] = "Alta";
$amenazas[5] = "Muy Alta";
			
//OPCIONES VULNERABILIDADES
$vulnerabilidades[1] = "Muy Baja";
$vulnerabilidades[2] = "Baja";
$vulnerabilidades[3] = "Media";
$vulnerabilidades[4] = "Alta";
$vulnerabilidades[5] = "Muy Alta";
			
///OPCIONES PROTECCION
$protecciones[1] = "Muy Baja";
$protecciones[2] = "Baja";
$protecciones[3] = "Media";
$protecciones[4] = "Alta";
$protecciones[5] = "Muy Alta";

///OPCIONES TRATAMIENTOS
/*$tratamientos[1] = "Evitar el riesgo";
$tratamientos[2] = "Eliminar la fuente del riesgo";
$tratamientos[3] = "Disminuir su probabilidad o impacto";
$tratamientos[4] = "Compartir el riesgo";
$tratamientos[5] = "Aceptar el riesgo";
$tratamientos[6] = "Niveles del riesgo residual son tolerables"; */


echo "<div id='wrapperRiesgos'>";
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Riesgos</font>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		
		echo"<tr height='40'> </tr>";
		
		echo "<td align='center'><a href='altaRiesgoPopUpv2.php'><img src='../../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'> </a></td>";
	echo "</table>";
	
	
		//banan de navegacion de intranet
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";

	echo "</td>";
		echo "</tr>";

		echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

////////////////////////
///CASO ADMINISTRADOR///
////////////////////////
if($categoriaUsr == "Administrador"){
	
///TODAS LAS VARIABLES DEL FORMULARIO
	$patente 		= $_REQUEST['patente'];
	/*$categoriaI 	= $_POST['categoriaI'];
	$categoriaE 	= $_POST['categoriaE'];	
	$amenaza		= $_POST['amenaza'];
	$vulnerabilidad	= $_POST['vulnerabilidad'];
	$tratamiento 	= $_POST['tratamiento'];*/
	///SIEMPRE ABRE EL FORM AL PRINCIPIO SE EL CASOP POR DEFECTO O CON FILTRO ELEGIDO
	
	echo "<form name='tableroRiesgos' method='POST' action='tableroRiesgosv2_prueba.php'>";
////////////////////////////////////////////
///CASO ADMINISTRADOR VALORES POR DEFECTO///
////////////////////////////////////////////
	if($patente == ""){

	///TABLA QUE OCULTA LAS OPCIONES DE LOS FILTROS, SE ACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='1150' id='ocultar' style='display:block;'>";
			echo"<tr>";
				echo"<td colspan='7' align='left' id='iconosTexto2' style='cursor:pointer;' onClick='show(1); '>Filtrar</td>";
			echo"</tr>";
		echo"</table>";
	///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='1150' id='mostrar' style='display:none;'>";
			echo"<tr>";

				echo"<td colspan='7' align='left' id='iconosTexto2' onClick='show(0);'> Filtrar </td>";
			echo"</tr>";
			
			echo"<tr height='5'></tr>";
		///CATEGORIAS DE LOS FILTROS
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs' width='160' >Patente</td>";
				/*echo "<td align='left' id='breadcrumbs' width='180' >Categoria Internos</td>";
				echo "<td align='left' id='breadcrumbs' width='190' >Categoria Externos</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Amenaza</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Protección</td>";
				//echo "<td align='left' id='breadcrumbs' width='300' >Tratamiento</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Vulnerabilidad</td>";*/
			echo "</tr>";
				
			echo"<tr height='10'></tr>";
			
			echo "<tr>";
				echo "<td id='breadcrumbs' valign='top'>";
			
					for($a = 0; $a <count($patentes); $a++){
						
							echo"<input type='checkbox' name='patente[]' value='".$patentes[$a]."' checked='checked'>".$patentes[$a]."<br>";
						
					}
				
				echo"</td>";

				


			///OPCIONES PARA CATEGORIA INTERNOS
				/*echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='categoriaI[]' value='Todas'> Todas <br>";
					for($a = 1; $a <= 4; $a++){
						echo"<input type='checkbox' name='categoriaI[]' value='".$a."' checked='checked'>".$internas[$a]."<br>";
					}
				echo"</td>";
			///OPCIONES PARA CATEGORIA EXTERNOS
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='categoriaE[]' value='Todas'> Todas <br>";	
					for($a = 1; $a <= 6; $a++){
						echo"<input type='checkbox' name='categoriaE[]' value='".$a."' checked='checked'>".$externas[$a]."<br>";
					}			
				echo"</td>";
			///OPCIONES PARA CATEGORIA AMENAZA
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='amenaza[]' value='Todas'> Todas <br>";
					for($a = 1; $a <= 5; $a++){
						echo"<input type='checkbox' name='amenaza[]' value='".$amenazas[$a]."' checked='checked'>".$amenazas[$a]."<br>";
					}
				echo"</td>";
			///OPCIONES PARA CATEGORIA PROTECCION	
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='proteccion[]' value='Todas'> Todas <br>";
					for($a = 1; $a <= 5; $a++){
						echo"<input type='checkbox' name='proteccion[]' value='".$protecciones[$a]."' checked='checked'>".$protecciones[$a]."<br>";
					}
					
				echo"</td>";
		
				///OPCIONES PARA CATEGORIA VULNERABILIDAD	
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='vulnerabilidad[]' value='Todas'> Todas <br>";
					for($a = 1; $a <= 5; $a++){
						echo"<input type='checkbox' name='vulnerabilidad[]' value='".$vulnerabilidades[$a]."' checked='checked'>".$vulnerabilidades[$a]."<br>";
					}
					
				echo"</td>";*/
		
			echo "</tr>";
			
			echo"<tr height='20'> </tr>";
			
			echo"<tr>";
				echo"<td align='center' colspan='7'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='25'> </td>";
			echo"</tr>";
		echo"</table>";
		
	
	
		
	///DESPLIEGUE DE LA INFORMACION
		for($a = 0; $a <count($cdValor); $a++){
			
			$indice = 0;
		//	echo "$a $cdValor[$a] <br>";
			if( $cdValor[$a]=="LRD")
			{
				$cdValor[$a]="LAR";
			}
			if($cdValor[$a] == "CMX"){
			
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' OR xt_ciudad = 'DF'");
				
			}else{
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]'");
			}
			
			
			
			
			if($indice >= 1){
				
				if(in_array($cdValor[$a],$ciudadesDisponibles)){
					
					echo "<table border='0' align='center' width='1150'>";
					
						echo "<tr height='10'> </tr>";
						
						echo "<tr>";
							echo "<td id='titulo2Blanco' align='left' width='1150'>".$ciudades[$a]."</td>";
						echo "</tr>";
						//echo "<tr>";
							//echo "<td id='titleBlueLineBottom'> </td>";
						//echo "</tr>";
						
					echo "</table>";
				}
			} unset($indice);
	////////////////
	////INTERNOS////
	////////////////
		///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SEA INTERNO
			$indice = 0;

			if($cdValor[$a] == "CMX"){
			
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' OR xt_ciudad = 'DF' AND xt_categoriaOpcion = 'Interno'");
			}else{
				
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' AND xt_categoriaOpcion = 'Interno' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL");
				
			}

			

			//CASO SELECCION DE PATENTES
			/*if($patentes[$a] == "3061"){

				echo "entro";

				for($w=0; $w<count($patente3061); $w++ ){
					if($patente3061[$w] == "CMX"){


						$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$w]' OR xt_ciudad = 'DF'  AND xt_categoriaOpcion = 'Interno'");

					}else{

						$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$w]' OR xt_ciudad = 'DF'  AND xt_categoriaOpcion = 'Interno'");
					}

					
				}

			}else if($patentes[$a] == "3034"){

				echo "entro 2";

				for($w=0; $w<count($patente3034); $w++ ){
					

						$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3034[$w]' AND xt_categoriaOpcion = 'Interno'");
				}

								
			}else if($patentes[$a] == "3371"){

				
				for($w=0; $w<count($patente3371); $w++ ){
					

					$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3371[$w]' AND xt_categoriaOpcion = 'Interno'");
				}	
				
				
			}else if($patentes[$a] == "3925"){

				
				for($w=0; $w<count($patente3925); $w++ ){

					$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3925[$w]' AND xt_categoriaOpcion = 'Interno'");
				}					
			}*/
			
		
			
		///SI HUBO REGISTROS CONTINUAMOS
			if($indice >= 1){
			///IMPRIMIMOS EL TITULO DE INTERNOS
				echo "<table border='0' align='center' width='1100'>";
					echo "<tr>";
						echo "<td id='titulo2' align='left'>Internos</td>";
					echo "</tr>";
					
					echo "<tr height='10'><td> </td></tr>";
					
					echo "<tr>";
						echo "<td colspan='8' id='titleBlueLineTop'> </td>";
					echo "</tr>";
					
				echo"</table>";
			///RECORREMOS LAS OPCIONES DE INTERNOS - 4
				for($e = 1; $e <= 4; $e++){
				///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE INTERNOS
					
					$tituloRiesgo 		= NULL;
					$codigoRiesgo 		= NULL;
					$vulnerabilidadR 	= NULL;
					$amenazaR 			= NULL;
					$estrategiaR 		= NULL;
					$proteccionR 		= NULL;
					$probabilidadR      = NULL;
					
					$indice = 1;
				///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES

					if($cdValor[$a] == "CMX"){
							
							

						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE (xt_ciudad = '$cdValor[$a]' OR xt_ciudad = 'DF') AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					}else{
						
						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' AND xt_categoriaOpcion = 'Interno' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL AND xn_categoria = $e AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL)  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					}

					//CASO POR PATENTES
					/*if($patentes[$a] == "3061"){

						for($d=0; $d<count($patente3061); $d++ ){
							if($patente3061[$d] == "CMX"){
		
								$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$d]' OR xt_ciudad = 'DF' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
		
							}else{
		
								$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$d]' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
							}
		
							
						}
						
						

					}else if($patentes[$a] == "3034"){

						for($d=0; $d<count($patente3061); $d++ ){
							
		
								$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$d]' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
						}
						

					}else if($patentes[$a] == "3371"){

						for($d=0; $d<count($patente3371); $d++ ){
							
		
							$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3371[$d]' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
						}

					}else if($patentes[$a] == "3925"){

						for($d=0; $d<count($patente3925); $d++ ){
							
		
							$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3925[$d]' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
						}

					}*/
					
					
					while($r = $s->fetchRow()){
						$codigoRiesgo[$indice] 		= $r[0];
						$tituloRiesgo[$indice] 		= $r[1];
						$vulnerabilidadR[$indice] 	= $r[2];
						$amenazaR[$indice] 			= $r[3];
						$estrategiaR[$indice] 		= $r[4];
						$proteccionR[$indice]		= $r[5];
						$probabilidadR[$indice]		= $r[6];
						
						$indice++;
						
					} unset($r); unset($s);
					
				///SI HUBO RIESGOS PARA LA CIUDAD, INTERNOS Y LA OPCION CORRESPONDIENTE
					if($codigoRiesgo != NULL){
						
						echo "<table border='0' align='center'>";
						///TITULO DE LA OPCION INTERNA CORRESPONDIENTE
							echo "<tr>";
								echo "<td id='titulo2' align='left' width='20'></td>";
								echo "<td id='titulo2' align='left' width='1080'><i>".$internas[$e]."</i></td>";
							echo "</tr>";
						echo "</table>";
						
						echo "<table border='0' align='center' width='1050'>";
							echo"<tr height='10'> </tr>";
						///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
							
							echo"<tr height='10'> </tr>";	
									
						echo "</table>";
					///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
						for($o = 1; $o <= count($codigoRiesgo); $o++){
							echo"<table align='center' border='0'>";
								
								echo "<tr height='25' id='fileItem'>";				
									echo "<td align='left' width='20'> </td> ";
								///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
									echo "<td width='120px' align='left'>";
										echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
									echo "</td>";
								///TITULO DEL RIESGO
									echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
									echo "<td width='20' align='left'> </td>";
							
									//PROBABILIDAD
							
									echo "<td align='left' width='130' valign='middle'>"; 
										if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){
											
										}else if($probabilidadR[$o] == '1'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($probabilidadR[$o] == '2'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
											
										}else if($probabilidadR[$o] == '3'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($probabilidadR[$o] == '4' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
											
										}else if($probabilidadR[$o] =='5'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
											
										}
									echo "</td>";
								///AMENAZA DEL RIESGO Y SEMAFORO
									echo "<td align='left' width='100' valign='middle'>"; 
										if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
											
										}else if($amenazaR[$o] == 'Muy Baja'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($amenazaR[$o] == 'Baja'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
											
										}else if($amenazaR[$o] == 'Media'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($amenazaR[$o] == 'Alta' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
											
										}else if($amenazaR[$o] =='Muy Alta'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
											
										}
									echo "</td>";
								
								///TRATAMIENTO DEL RIESGO
									//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
								
								///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
									
									///VULNERABILIDAD DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
											
										}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($vulnerabilidadR[$o] == 'Baja' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
											
										}else if($vulnerabilidadR[$o] == 'Media' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($vulnerabilidadR[$o] == 'Alta'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
											
										}else if($vulnerabilidadR[$o] == 'Muy Alta'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								
								echo "</tr>";	
									
								echo"<tr height='10'> </tr>";
								
							echo"</table>";
					///FIN DEL FOR DEL ARREGLO DE INTERNOS	
						}
						///SEPARADOR ENTRE TABLAS INTERNAS
						echo "<table border='0' align='center'>";
							echo "<tr height='30'></tr>";
						echo "</table>";
				///FIN DEL IF COMPROBACION DE REGISTROS INTERNOS
					}
			///FIN DEL FOR QUE RECORRE LAS OPCIONES DE INTERNOS
				}
				echo "<table border='0' align='center'>";
					echo "<tr height='50'><td> </td></tr>";
				echo "</table>";
		///FIN DEL IF COMPROBACION DE INTERNOS PARA LA CIUDAD
			} unset($indice);
	////////////////
	////EXTERNOS////
	////////////////
		///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SEA EXTERNO
			$indice = 0;

			
			if($cdValor[$a] == "CMX"){
				
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' OR xt_ciudad = 'DF' AND xt_categoriaOpcion = 'Externo'");
			}else{
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL");
			}
			
			//CASO PATENTES
			/*if($patentes[$a] == "3061"){

				for($y=0; $y<count($patente3061); $y++ ){
					if($patente3061[$y] == "CMX"){

						$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = $patente3061[$y] AND xt_categoriaOpcion = 'Externo'");

					}else{

						$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = $patente3061[$y] AND xt_categoriaOpcion = 'Externo'");
					}

					
				}
				
			}else if($patentes[$a] == "3034"){
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = $patente3034[$y] AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL");

			}else if($patentes[$a] == "3371"){
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = $patente3371[$y] AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL");

			}else if($patentes[$a] == "3925"){
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = $patente3925[$y] AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL");
			}*/
				
			
			
		///SI HUBO REGISTROS CONTINUAMOS
			if($indice >= 1){
			///IMPRIMIMOS EL TITULO DE EXTERNOS
				echo "<table border='0' align='center' width='1100'>";
						echo "<tr>";
							echo "<td id='titulo2' align='left'>Externos</td>";
						echo "</tr>";
						
						echo "<tr height='10'><td> </td></tr>";
						
						echo "<tr>";
							echo "<td colspan='8' id='titleBlueLineTop'> </td>";
						echo "</tr>";
						
					echo"</table>";
			///RECORREMOS LAS OPCIONES DE EXTERNOS - 6
				for($e = 1; $e <= 6; $e++){
				///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE EXTERNOS
					
					$tituloRiesgo 		= NULL;
					$codigoRiesgo 		= NULL;
					$vulnerabilidadR 	= NULL;
					$amenazaR 			= NULL;
					$estrategiaR 		= NULL;
					$proteccionR		= NULL;
					$probabilidadR      = NULL;
					
					$indice = 1;
					
					if($cdValor[$a] == "CMX"){
						
						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE (xt_ciudad = '$cdValor[$a]' OR xt_ciudad = 'DF') AND xt_categoriaOpcion = 'Externo' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
						
					}else{
						
						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL AND xn_categoria = $e AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					}


					/*if($patentes[$a] == "3061"){

						for($m=0; $m<count($patente3061); $m++ ){
							if($patente3061[$m] == "CMX"){

								$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$m]' OR xt_ciudad = 'DF'  AND xt_categoriaOpcion = 'Externo' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");

							}else{

								$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$m]' AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL AND xn_categoria = $e AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
							}

							
						}
				
					}else if($patentes[$a] == "3034"){

						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$m]' AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL AND xn_categoria = $e AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");

					}else if($patentes[$a] == "3371"){

						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3371[$m]' AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL AND xn_categoria = $e AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");

					}else if($patentes[$a] == "3925"){

						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3925[$m]' AND xt_categoriaOpcion = 'Externo' AND xn_proteccion IS NOT NULL AND xt_vulnerabilidad IS NOT NULL AND xn_categoria = $e AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					}*/

				///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES
					
					
					while($r = $s->fetchRow()){
						$codigoRiesgo[$indice] 		= $r[0];
						$tituloRiesgo[$indice] 		= $r[1];
						$vulnerabilidadR[$indice] 	= $r[2];
						$amenazaR[$indice] 			= $r[3];
						$estrategiaR[$indice] 		= $r[4];
						$proteccionR[$indice]		= $r[5];
						$probabilidadR[$indice]		= $r[6];
						
						$indice++;
						
					} unset($r); unset($s);
				///SI HUBO RIESGOS PARA LA CIUDAD, EXTERNOS Y LA OPCION CORRESPONDIENTE
					
					if($codigoRiesgo != NULL){
						
						echo "<table border='0' align='center'>";
							
						///TITULO DE LA OPCION EXTERNA CORRESPONDIENTE
							echo "<tr>";
								echo "<td id='titulo2' align='left' width='20'></td>";
								echo "<td colspan='8' id='titulo2' width='1080' align='left'><i>".$externas[$e]."</i></td>";
							echo "</tr>";
						echo "</table>";
						
						echo "<table border='0' align='center' width='1050'>";
							
							echo"<tr height='10'> </tr>";
						///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
							
							echo"<tr height='10'> </tr>";	
									
						echo "</table>";
					///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
						for($o = 1; $o <= count($codigoRiesgo); $o++){
							echo"<table align='center' border='0' >";
								
								echo "<tr height='25' id='fileItem'>";				
									echo "<td align='left' width='20'> </td> ";
								///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
									echo "<td width='120px' align='left'>";
										echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
									echo "</td>";
								///TITULO DEL RIESGO
									echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
									echo "<td width='20' align='left'> </td>";
							
								//PROBABILIDAD
									echo "<td align='left' width='130' valign='middle'>"; 
										if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){
											
										}else if($probabilidadR[$o] == '1'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($probabilidadR[$o] == '2'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
											
										}else if($probabilidadR[$o] == '3'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($probabilidadR[$o] == '4' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
											
										}else if($probabilidadR[$o] =='5'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
											
										}
									echo "</td>";
							
								///AMENAZA DEL RIESGO Y SEMAFORO
									echo "<td align='left' width='100' valign='middle'>"; 
										if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
											
										}else if($amenazaR[$o] == 'Muy Baja'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($amenazaR[$o] == 'Baja'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
											
										}else if($amenazaR[$o] == 'Media'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($amenazaR[$o] == 'Alta' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
											
										}else if($amenazaR[$o] =='Muy Alta'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
											
										}
									echo "</td>";
								
								///TRATAMIENTO DEL RIESGO
									//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
								
								///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								///VULNERABILIDAD DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
											
										}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($vulnerabilidadR[$o] == 'Baja' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
											
										}else if($vulnerabilidadR[$o] == 'Media' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($vulnerabilidadR[$o] == 'Alta'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
											
										}else if($vulnerabilidadR[$o] == 'Muy Alta'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								echo "</tr>";	
									
								echo"<tr height='10'> </tr>";
								
							echo"</table>";
					///FIN DEL FOR DEL ARREGLO DE EXTERNOS	
						}
						///SEPARADOR ENTRE TABLAS EXTERNAS
						echo "<table border='0' align='center'>";
							echo "<tr height='30'></tr>";
						echo "</table>";
				///FIN DEL IF COMPROBACION DE REGISTROS EXTERNOS
					}
			///FIN DEL FOR QUE RECORRE LAS OPCIONES DE EXTERNOS
				}
				echo "<table border='0' align='center'>";
					echo "<tr height='30'><td> </td></tr>";
				echo "</table>";
		///FIN DEL IF COMPROBACION DE EXTERNOS PARA LA CIUDAD
			} unset($indice);
			
	////////////////
	////SIN CATA////
	////////////////
		///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SIN CATALOGAR
			$indice = 0;

			if($cdValor[$a] == "CMX"){
						
				$indice = $INTRANETV2->getone("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = $cdValor[$a] OR xt_ciudad = 'DF' AND xt_categoriaOpcion IS NULL ");
				
			}else{
				
				$indice = $INTRANETV2->getone("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = $cdValor[$a] AND xt_categoriaOpcion IS NULL ");
			}



			/*if($patentes[$a] == "3061"){

						for($n=0; $n<count($patente3061); $n++ ){
							if($patente3061[$n] == "CMX"){

								$indice = $INTRANETV2->getone("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$n]' OR xt_ciudad = 'DF' AND xt_categoriaOpcion IS NULL ");

							}else{

								$indice = $INTRANETV2->getone("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$n]' AND xt_categoriaOpcion IS NULL ");
							}

							
						}
				
			}else if($patentes[$a] == "3034"){
				$indice = $INTRANETV2->getone("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3034[$n]' AND xt_categoriaOpcion IS NULL ");
			}else if($patentes[$a] == "3371"){
				$indice = $INTRANETV2->getone("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3371[$n]' AND xt_categoriaOpcion IS NULL ");
			}else if($patentes[$a] == "3925"){
					$indice = $INTRANETV2->getone("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$patente3925[$n]' AND xt_categoriaOpcion IS NULL ");
			}*/
			
			
			
			
		///SI HUBO REGISTROS CONTINUAMOS
			if($indice >= 1){
			///IMPRIMIMOS EL TITULO DE SIN CATALOGAR
				echo "<table border='0' align='center' width='1100'>";
					echo "<tr>";
						echo "<td id='titulo2' align='left'>Sin catalogar</td>";
					echo "</tr>";
					
					echo "<tr height='10'><td> </td></tr>";
					
					echo "<tr>";
						echo "<td colspan='8' id='titleBlueLineTop'> </td>";
					echo "</tr>";
 
					
				echo"</table>";
			///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE SIN CATALOGAR
				
				$tituloRiesgo 		= NULL;
				$codigoRiesgo 		= NULL;
				$vulnerabilidadR 	= NULL;
				$amenazaR 			= NULL;
				$estrategiaR 		= NULL;
				$proteccionR		= NULL;
				$probabilidadR      = NULL;
				
				
				$indice = 1;

				if($cdValor[$a] == "CMX"){
						
					$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' OR xt_ciudad = 'DF'  AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					
				}else{
					
					$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$cdValor[$a]' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				}
				

				/*if($patentes[$a] == "3061"){

						for($b=0; $b<count($patente3061); $b++ ){
							if($patente3061[$b] == "CMX"){

								$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$b]' OR xt_ciudad = 'DF'  AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");

							}else{

								$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3061[$b]' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
							}

							
						}
				
				}else if($patentes[$a] == "3034"){

					for($b=0; $b<count($patente3034); $b++ ){
						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3334[$b]' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					}
				}else if($patentes[$a] == "3371"){
					for($b=0; $b<count($patente3034); $b++ ){
						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3371[$b]' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					}				
				}else if($patentes[$a] == "3925"){

					for($b=0; $b<count($patente3034); $b++ ){
						$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$patente3925[$b]' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
					}				
				}*/
				
			///QUERY QUE CAMBIARA DE ACUERDO CON LAS CIUDADES
				
				
				while($r = $s->fetchRow()){
					$codigoRiesgo[$indice] 		= $r[0];
					$tituloRiesgo[$indice] 		= $r[1];
					$vulnerabilidadR[$indice] 	= $r[2];
					$amenazaR[$indice] 			= $r[3];
					$estrategiaR[$indice] 		= $r[4];
					$proteccionR[$indice]		= $r[5];
					$probabilidadR[$indice]		= $r[6];
					
					
					$indice++;
					
				} unset($r); unset($s);
			///SI HUBO RIESGOS PARA LA CIUDAD Y SIN CATALOGAR 
				if($codigoRiesgo != NULL){
					
					echo "<table border='0' align='center' width='1050'>";
						
						
						echo"<tr height='10'> </tr>";
					///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
							
							echo"<tr height='10'> </tr>";	
									
						echo "</table>";
				///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
					for($o = 1; $o <= count($codigoRiesgo); $o++){
						echo"<table align='center' border='0' >";
								
							echo "<tr height='25' id='fileItem'>";				
								echo "<td align='left' width='20'> </td> ";
							///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
								echo "<td width='120px' align='left'>";
									echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
								echo "</td>";
							///TITULO DEL RIESGO
								echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
								echo "<td width='20' align='left'> </td>";
						
							//PROBABILIDAD
								echo "<td align='left' width='130' valign='middle'>"; 
										if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){
											
										}else if($probabilidadR[$o] == '1'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($probabilidadR[$o] == '2'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
											
										}else if($probabilidadR[$o] == '3'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($probabilidadR[$o] == '4' ){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
											
										}else if($probabilidadR[$o] =='5'){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
											
										}
								echo "</td>";
							///AMENAZA DEL RIESGO Y SEMAFORO
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
										
									}else if($amenazaR[$o] == 'Muy Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($amenazaR[$o] == 'Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($amenazaR[$o] == 'Media'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($amenazaR[$o] == 'Alta' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($amenazaR[$o] =='Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
										
									}
								echo "</td>";
							
								///TRATAMIENTO DEL RIESGO
									//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
								
								///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								///VULNERABILIDAD DEL RIESGO Y SEMAFORO
								echo "<td width='20' align='left'> </td>";
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
										
									}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($vulnerabilidadR[$o] == 'Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($vulnerabilidadR[$o] == 'Media' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($vulnerabilidadR[$o] == 'Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($vulnerabilidadR[$o] == 'Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
										
									}
								echo "</td>";
								echo "</tr>";	
									
								echo"<tr height='10'></tr>";
								
							echo"</table>";
				///FIN DEL FOR DEL ARREGLO DE SIN CATALOGAR	
					}
					///SEPARADOR SIN CATALOGAR
					echo "<table border='0' align='center'>";
						echo "<tr height='30'></tr>";
					echo "</table>";
			///FIN DEL IF COMPROBACION DE REGISTROS SIN CATALOGAR
				}
				echo "<table border='0' align='center'>";
					echo "<tr height='30'></tr>";
				echo "</table>";

		///FIN DEL IF COMPROBACION DE SIN CATALOGAR PARA LA CIUDAD
			} unset($indice);
			
			
	
	///FIN DEL DESPLIEGUE DE LA INFORMACION	
		}
/////////////////////////////////////////		
///CASO ADMINISTRADOR VALORES ELEGIDOS///
/////////////////////////////////////////
} else{
		
	///OPCIONES INTERNAS
	$internas[1] = "Operacionales";
	$internas[2] = "Personales";
	$internas[3] = "Organización";
	$internas[4] = "Estratégicos";
	///OPCIONES EXTERNAS
	$externas[1] = "Catástrofes naturales";
	$externas[2] = "Políticos";
	$externas[3] = "Legales";
	$externas[4] = "Mercado";
	$externas[5] = "Económicos";
	$externas[6] = "Entorno";


				
	///OPCIONES AMENAZAS
	$amenazas[1] = "Muy Baja";
	$amenazas[2] = "Baja";
	$amenazas[3] = "Media";
	$amenazas[3] = "Alta";
	$amenazas[5] = "Muy Alta";
				
	//OPCIONES VULNERABILIDADES
	$vulnerabilidades[1] = "Muy Baja";
	$vulnerabilidades[2] = "Baja";
	$vulnerabilidades[3] = "Media";
	$vulnerabilidades[4] = "Alta";
	$vulnerabilidades[5] = "Muy Alta";
				
	///OPCIONES PROTECCION
	$protecciones[1] = "Muy Baja";
	$protecciones[2] = "Baja";
	$protecciones[3] = "Media";
	$protecciones[4] = "Alta";
	$protecciones[5] = "Muy Alta";

	$amenazaElegida = array("Muy Baja", "Baja", "Media", "Alta", "Muy Alta");
	$proteccionElegida = array("Muy Baja", "Baja", "Media", "Alta", "Muy Alta");
	$vulnerabilidadElegida = array("Muy Baja", "Baja", "Media", "Alta", "Muy Alta");
	$internaElegida = array("Operacionales", "Personales", "Organización", "Estratégicos");
	$externaElegida = array("Catástrofes naturales", "Políticos", "Legales", "Mercado", "Económicos", "Entorno");

	///OPCIONES TRATAMIENTOS
	/*$tratamientos[1] = "Evitar el riesgo";
	$tratamientos[2] = "Eliminar la fuente del riesgo";
	$tratamientos[3] = "Disminuir su probabilidad o impacto";
	$tratamientos[4] = "Compartir el riesgo";
	$tratamientos[5] = "Aceptar el riesgo";
	$tratamientos[6] = "Niveles del riesgo residual son tolerables"; */


	///TABLA QUE OCULTA LAS OPCIONES DE LOS FILTROS, SE ACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='1150' id='ocultar' style='display:block;'>";
			echo"<tr>";
				echo"<td colspan='7' align='left' id='iconosTexto2' onClick='show(1);'>Filtrar</td>";
			echo"</tr>";
		echo"</table>";
	///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
		echo "<table border='0' align='center' width='1310' id='mostrar' style='display:none;'>";
			echo"<tr>";
				echo"<td colspan='7' align='left' id='iconosTexto2' onClick='show(0);'> Filtrar </td>";
			echo"</tr>";
			
			echo"<tr height='5'></tr>";
		///CATEGORIAS DE LOS FILTROS
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs' width='160' >Patente</td>";
				/*echo "<td align='left' id='breadcrumbs' width='180' >Categoria Internos</td>";
				echo "<td align='left' id='breadcrumbs' width='190' >Categoria Externos</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Amenaza</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Protección</td>";
				//echo "<td align='left' id='breadcrumbs' width='300' >Tratamiento</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Vulnerabilidad</td>";*/
			echo "</tr>";
				
			echo"<tr height='10'></tr>";
			
			
			if($_POST['patente'] != ""){

				$i = 1;
				foreach($_POST['patente'] as $pat){
					 $ptElegida[$i] = $pat;
					$i++;
				}
				
			} else{
				$ptElegida = NULL;
			}
			
			

			/*if($_POST['categoriaI'] != ""){
				$i = 1;
				foreach($_POST['categoriaI'] as $inner){
					echo "internaElegi".$internaElegida[$i] = $inner;
					$i++;
				}
				
			} else{

				$internaElegida = NULL;
			}
			
			if($_POST['categoriaE'] != ""){
				$i = 1;
				foreach($_POST['categoriaE'] as $outer){
					$externaElegida[$i] = $outer;
					$i++;
				}
				
			} else{
				$externaElegida = NULL;
			}*/

			/*if(count($externaElegida) > 0){
				for($o=1; $o<=count($externaElegida); $o++){
					$externaElegida[$i] = $externaElegida[$o];
					
				}
			}else {
				$externaElegida = NULL;
			}

			if(count($internaElegida) > 0){
				for($o=1; $o<=count($internaElegida); $o++){
					$internaElegida[$i] = $inner;
					
				}
			}else {
				$internaElegida = NULL;
			}*/
			
			if(count($amenazaElegida) > 0){
				
				$queryAmenazas = "";
				for($o=1; $o<=count($amenazaElegida); $o++){
					///CONCATENAMOS LAS OPCIONES PARA PONERLAS EN LA CONSULTA
					 $queryAmenazas = $queryAmenazas."'".$amenazaElegida[$o]."', ";
					
				}
				///ELIMINAMOS EL ULTIMO ESPACIO Y LA ULTIMA COMA
				$queryAmenazas = substr($queryAmenazas, 0, -2);
			} else{
				$amenazaElegida = NULL;
				$queryAmenazas = "";
			}
		
			
				
			if(count($proteccionElegida) > 0){
				$i = 1;
				///VARIABLE QUE USAREMOS PARA LOS 'IN' EN LAS CONSULTAS
				$queryProteccion = "";
				for($o=1; $o<=count($proteccionElegida); $o++){
					///CONCATENAMOS LAS OPCIONES PARA PONERLAS EN LA CONSULTA
					$queryProteccion = $queryProteccion."'".$proteccionElegida[$o]."', ";
					$i++;
				}
				///ELIMINAMOS EL ULTIMO ESPACIO Y LA ULTIMA COMA
				$queryProteccion = substr($queryProteccion, 0, -2);
			} else{
				$proteccionElegida = NULL;
				$queryProteccion = "";
			}
		
			
			if(count($vulnerabilidadElegida) > 0){
				///VARIABLE QUE USAREMOS PARA LOS 'IN' EN LAS CONSULTAS
				$queryVulnerabilidad = "";
				for($o=1; $o<=count($vulnerabilidadElegida); $o++){
					
					///CONCATENAMOS LAS OPCIONES PARA PONERLAS EN LA CONSULTA
					$queryVulnerabilidad = $queryVulnerabilidad."'".$vulnerabilidadElegida[$o]."', ";
					$i++;
				}
				///ELIMINAMOS EL ULTIMO ESPACIO Y LA ULTIMA COMA
				$queryVulnerabilidad = substr($queryVulnerabilidad, 0, -2);
			} else{
				$vulnerabilidadElegida = NULL;
				$queryVulnerabilidad = "";
			}
			
			/*if($_POST['tratamiento'] != ""){
				$i = 1;
				///VARIABLE QUE USAREMOS PARA LOS 'IN' EN LAS CONSULTAS
				$queryTratamiento = "";
				foreach($_POST['tratamiento'] as $treatment){
					$tratamientoElegida[$i] = $treatment;
					///CONCATENAMOS LAS OPCIONES PARA PONERLAS EN LA CONSULTA
					$queryTratamiento = $queryTratamiento."'".$treatment."', ";
					$i++;
				}
				///ELIMINAMOS EL ULTIMO ESPACIO Y LA ULTIMA COMA
				$queryTratamiento = substr($queryTratamiento, 0, -2);
			} else{*/
				$tratamientoElegida = NULL;
				$queryTratamiento = "";
			//}
			
			echo "<tr>";
				
				echo "<td id='breadcrumbs' valign='top'>";
				//echo"<input type='checkbox' name='ciudad[]' value='Todas'> Todas <br>";	
				for($a = 0; $a < 4; $a++){
					
						
						if(in_array($patentes[$a], $ptElegida)){
							echo"<input type='checkbox' name='patente[]' value='".$patentes[$a]."' checked='checked'>$patentes[$a]<br>";
						} else{
							echo"<input type='checkbox' name='patente[]' value='".$patentes[$a]."'>$patentes[$a]<br>";
						}
						
					
				}
				echo"</td>";
				
				///OPCIONES PARA CATEGORIA INTERNOS
				/*echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='categoriaI[]' value='Todas'> Todas <br>";
				///SI HUBO VALORES EN INTERNA
					if($internaElegida != NULL){
						for($a = 1; $a <= 4; $a++){
							if(in_array($a, $internaElegida)){
								echo"<input type='checkbox' name='categoriaI[]' value='".$a."' checked='checked'>".$internas[$a]."<br>";
							} else{
								echo"<input type='checkbox' name='categoriaI[]' value='".$a."' >".$internas[$a]."<br>";
							}
						}
				///SI NO HUBO VALORES EN INTERNA
					} else{
						for($a = 1; $a <= 4; $a++){
							echo"<input type='checkbox' name='categoriaI[]' value='".$a."' >".$internas[$a]."<br>";
						}
					}
				echo"</td>";
			///OPCIONES PARA CATEGORIA EXTERNOS
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='categoriaE[]' value='Todas'> Todas <br>";	
				///SI HUBO VALORES EN EXTERNA
					if($externaElegida != NULL){
						for($a = 1; $a <= 6; $a++){
							if(in_array($a, $externaElegida)){
								echo"<input type='checkbox' name='categoriaE[]' value='".$a."' checked='checked'>".$externas[$a]."<br>";
							} else{
								echo"<input type='checkbox' name='categoriaE[]' value='".$a."' >".$externas[$a]."<br>";
							}
						}
				///SI NO HUBO VALORESW EN EXTERNA
					} else{
						for($a = 1; $a <= 6; $a++){
							echo"<input type='checkbox' name='categoriaE[]' value='".$a."' >".$externas[$a]."<br>";
						}

					}
				echo"</td>";
			///OPCIONES PARA CATEGORIA AMENAZA
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='amenaza[]' value='Todas'> Todas <br>";
				///SI HUBO VALORES EN AMENAZA
					if($amenazaElegida != NULL){
						for($a = 1; $a <= 5; $a++){
							if(in_array($amenazas[$a], $amenazaElegida)){
								echo"<input type='checkbox' name='amenaza[]' value='".$amenazas[$a]."' checked='checked'>".$amenazas[$a]."<br>";
							} else{
								echo"<input type='checkbox' name='amenaza[]' value='".$amenazas[$a]."' >".$amenazas[$a]."<br>";
							}
						}
				///SI NO HUBO VALORES EN AMENAZA
					} else{
						for($a = 1; $a <= 5; $a++){
							echo"<input type='checkbox' name='amenaza[]' value='".$amenazas[$a]."' >".$amenazas[$a]."<br>";
						}

					}
				echo"</td>";
		
				
				///OPCIONES PARA CATEGORIA PROTECCION	
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='vulnerabilidad[]' value='Todas'> Todas <br>";
				///SI HUBO OPCIONES PARA VULNERABILIDAD
					if($proteccionElegida != NULL){
						
						
						for($a = 1; $a <= 5; $a++){
							if(in_array($protecciones[$a], $proteccionElegida)){
								echo"<input type='checkbox' name='proteccion[]' value='".$protecciones[$a]."' checked='checked'>".$protecciones[$a]."<br>";
							} else{
								echo"<input type='checkbox' name='proteccion[]' value='".$protecciones[$a]."' >".$protecciones[$a]."<br>";
							}
						}
				///SI NO HUBO OPCIONES PARA PROTECCION
					} else{
						
						
						for($a = 1; $a <= 5; $a++){
							echo"<input type='checkbox' name='proteccion[]' value='".$vulnerabilidades[$a]."' >".$protecciones[$a]."<br>";
						}
					}
		
				echo"</td>";
		
		
			///OPCIONES PARA CATEGORIA VULNERABILIDAD	
				echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='vulnerabilidad[]' value='Todas'> Todas <br>";
				///SI HUBO OPCIONES PARA VULNERABILIDAD
					if($vulnerabilidadElegida != NULL){
						
						
						for($a = 1; $a <= 5; $a++){
							if(in_array($vulnerabilidades[$a], $vulnerabilidadElegida)){
								echo"<input type='checkbox' name='vulnerabilidad[]' value='".$vulnerabilidades[$a]."' checked='checked'>".$vulnerabilidades[$a]."<br>";
							} else{
								echo"<input type='checkbox' name='vulnerabilidad[]' value='".$vulnerabilidades[$a]."' >".$vulnerabilidades[$a]."<br>";
							}
						}
				///SI NO HUBO OPCIONES PARA VULNERABILIDAD
					} else{
						
						
						for($a = 1; $a <= 5; $a++){
							echo"<input type='checkbox' name='vulnerabilidad[]' value='".$vulnerabilidades[$a]."' >".$vulnerabilidades[$a]."<br>";
						}
					}
		
				echo"</td>";
			///OPCIONES PARA CATEGORIA TRATAMIENTO
				/*echo "<td id='breadcrumbs' valign='top'>";
					//echo"<input type='checkbox' name='tratamiento[]' value='Todas'> Todas <br>";
				///SI HUBO OPCIONES PARA TRATAMIENTO
					if($tratamientoElegida != NULL){
						for($a = 1; $a <= 6; $a++){
							if(in_array($tratamientos[$a], $tratamientoElegida)){
								echo"<input type='checkbox' name='tratamiento[]' value='".$tratamientos[$a]."' checked='checked'>".$tratamientos[$a]."<br>";
							} else{
								echo"<input type='checkbox' name='tratamiento[]' value='".$tratamientos[$a]."' >".$tratamientos[$a]."<br>";
							}
						}
					} else{
						for($a = 1; $a <= 6; $a++){
							echo"<input type='checkbox' name='tratamiento[]' value='".$tratamientos[$a]."' >".$tratamientos[$a]."<br>";
						}
					}
				echo"</td>";*/
	
			echo "</tr>";
			
			echo"<tr height='20'> </tr>";
			
			echo"<tr>";
				echo"<td align='center' colspan='6'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='25'> </td>";
			echo"</tr>";
		echo"</table>";
		
		///VAMOS A DESPLEGAR LA INFORMACIONES DE LAS CIUDADES ELEGIDAS, ES EL CICLO MAS EXTERNO DE TODO ESTE CASO
		
		//ME QUEDE AQUI

		//obtengo las patentes

		$arregloCD = array();
		$indexArrCD = 0;

		

		foreach($_POST['patente'] as $patenteNom){


			if($patenteNom == "3061"){

				for($c=0; $c<= count($patente3061); $c++){

					if (!in_array($patente3061[$c], $arregloCD)) {
						 $arregloCD[$indexArrCD] = $patente3061[$c];
						$indexArrCD++;
					}
				}
			}else if($patenteNom == "3034"){

				for($c=0; $c<= count($patente3034); $c++){
					if (!in_array($patente3034[$c], $arregloCD)) {
						$arregloCD[$indexArrCD] = $patente3034[$c];
						$indexArrCD++;
					}
				}

			}else if($patenteNom == "3371"){

				for($c=0; $c<= count($patente3371); $c++){
					if (!in_array($patente3371[$c], $arregloCD)) {
						$arregloCD[$indexArrCD] = $patente3371[$c];
						$indexArrCD++;
					}
				}

			}else if($patenteNom == "3925"){

				for($c=0; $c<= count($patente3925); $c++){
					if (!in_array($patente3925[$c], $arregloCD)) {
						$arregloCD[$indexArrCD] = $patente3925[$c];
						$indexArrCD++;
					}
				}

			}


		} unset($indexArrCD);


		for($f=0; $f<count($arregloCD); $f++){

			//hago for por cada ciudad que tiene la patente
			
			if($arregloCD[$f] == "CMX"){
				$nombreCiudad = "Ciudad de México";
			} else if($arregloCD[$f] == "NLR"){
				$nombreCiudad = "Nuevo Laredo";
			} else if($arregloCD[$f] == "CUN"){
				$nombreCiudad = "Cancún";
			} else if($arregloCD[$f] == "VER"){
				$nombreCiudad = "Veracruz";
			} else if($arregloCD[$f] == "TOL"){
				$nombreCiudad = "Toluca";
			} else if($arregloCD[$f] == "LAR"){
				$nombreCiudad = "Laredo";
			}else if($arregloCD[$f] == "QRO"){
				$nombreCiudad = "Queretaro";
			}else if($arregloCD[$f] == "PAN"){
				$nombreCiudad = "Pantaco";
			}else if($arregloCD[$f] == "COL"){
				$nombreCiudad = "Colombia";
			}else if($arregloCD[$f] == "AIFA"){
				$nombreCiudad = "AIFA EDOMEX";
			}
			
			$indice = 0;
			
			if($arregloCD[$f] == "CMX"){

				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' OR xt_ciudad = 'DF'");	
			}else{
				$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]'");

			}
			
			if($indice >= 1){
					
					echo "<table border='0' align='center' width='1150'>";
					
						echo "<tr height='10'> </tr>";
						
						echo "<tr>";
							echo "<td id='titulo2Blanco' align='left' width='1150'>".$nombreCiudad."</td>";
						echo "</tr>";
						//echo "<tr>";
							//echo "<td id='titleBlueLineBottom'> </td>";
						//echo "</tr>";
						
					echo "</table>";
				
			} unset($indice);
			
			/*
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr height='10'> </tr>";
				
				echo "<tr>";
					echo "<td id='titulo2' align='left' width='1150'>".$nombreCiudad."</td>";
				echo "</tr>";
				//echo "<tr>";
					//echo "<td id='titleBlueLineBottom'> </td>";
				//echo "</tr>";
			echo "</table>";
			*/
			
		////////////////
		////INTERNOS////
		////////////////
		    ///SIEMPRE VERIFICAR QUE LA SELECCION NO ESTE VACIA
			if($internaElegida != NULL){

			///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SEA INTERNO
				$indice = 0;
				
				if($arregloCD[$f] == "CMX"){

					  $indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' OR xt_ciudad = 'DF' AND xt_categoriaOpcion = 'Interno' ");
				}else{
					
					 $indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' AND xt_categoriaOpcion = 'Interno' ");
				}
					
				
				
			///SI HUBO REGISTROS CONTINUAMOS
				if($indice >= 1){

				///IMPRIMIMOS EL TITULO DE INTERNOS
					echo "<table border='0' align='center' width='1100'>";
						echo "<tr>";
							echo "<td id='titulo2' align='left'>Internos</td>";
						echo "</tr>";
						
						echo "<tr height='10'><td> </td></tr>";
						
						echo "<tr>";
							echo "<td colspan='8' id='titleBlueLineTop'> </td>";
						echo "</tr>";
						
					echo"</table>";
				///RECORREMOS LAS OPCIONES DE INTERNOS - 4
					$xnCategoria = 1;
					for($e = 0; $e < count($internaElegida); $e++){
						//if(in_array($e, $internaElegida)){
						///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE INTERNOS
						
							
							$tituloRiesgo 		= NULL;
							$codigoRiesgo 		= NULL;
							$vulnerabilidadR 	= NULL;
							$amenazaR 			= NULL;
							$estrategiaR 		= NULL;
							$probabilidadR      = NULL;
							$indice = 1;
						///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES

							if($arregloCD[$f] == "CMX"){

								 $queryInternas = "SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE (xt_ciudad = '$arregloCD[$f]' OR xt_ciudad = 'DF') AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $xnCategoria";
							}else{
								  $queryInternas = "SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $xnCategoria";
							}
							
						///SI SE SELECCIONO ALGUNA OPCION EN AMENAZAS LA AGREGAMOS COMO CONDICION AL QUERY	  
							/*if($queryAmenazas != ""){
								 $queryInternas = $queryInternas." AND xt_amenaza IN (".$queryAmenazas.", 'Nula')";
							}
						///SI SE SELECCIONO ALGUNA OPCION EN VULNERABILIDAD LA AGREGAMOS COMO CONDICION AL QUERY	
							if($queryVulnerabilidad != ""){
								$queryInternas = $queryInternas." AND (xt_vulnerabilidad IN (".$queryVulnerabilidad.") or xt_vulnerabilidad is null)";
							}
						///SI SE SELECCIONO ALGUNA OPCION EN TRATAMIENTO LA AGREGAMOS COMO CONDICION AL QUERY	
							if($queryTratamiento != ""){
								$queryInternas = $queryInternas." AND xt_estrategia IN (".$queryTratamiento.") ";
							}*/
						///PARA FINALIZAR EL QUERY LO ORDENAMOS POR FECHA Y CODIGO DE RIESGO
							  $queryInternas = $queryInternas." ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ";
							//echo "$queryInternas<br>";
							$s = $INTRANETV2->Execute($queryInternas);
							
							while($r = $s->fetchRow()){
								
								$codigoRiesgo[$indice] 		= $r[0];
								$tituloRiesgo[$indice] 		= $r[1];
								$vulnerabilidadR[$indice] 	= $r[2];
								$amenazaR[$indice] 			= $r[3];
								$estrategiaR[$indice] 		= $r[4];
								$proteccionR[$indice]		= $r[5];
								$probabilidadR[$indice]     = $r[6];
								
								$indice++;
								
							} unset($r); unset($s);
						///SI HUBO RIESGOS PARA LA CIUDAD, INTERNOS Y LA OPCION CORRESPONDIENTE
							if($codigoRiesgo != NULL){
								
								/*echo "<table border='0' align='center'>";
							
						///TITULO DE LA OPCION INTERNA CORRESPONDIENTE
									echo "<tr>";
										echo "<td id='titulo2' align='left' width='20'></td>";
										echo "<td colspan='8' id='titulo2' width='1080' align='left'><i>".$internas[$e]."</i></td>";
									echo "</tr>";
								echo "</table>";*/
								
								echo "<table border='0' align='center' width='1050'>";
								///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
										echo"<td align='left' width='10'> </td>";
										echo"<td align='left' width='128'>Código</td>";
										echo"<td align='left' width='375'>Título</td>";
										echo"<td align='left' width='130'>Probabilidad</td>";
										echo"<td align='left' width='130'>Amenaza</td>";

										echo"<td align='left' width='110'>Protección</td>";
										echo"<td align='center' width='115'>Vulnerabilidad</td>";
									echo"</tr>";
									
									echo"<tr height='10'> </tr>";	
									
								echo "</table>";
							///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
								for($o = 1; $o <= count($codigoRiesgo); $o++){
									echo"<table align='center' border='0' >";
								
										echo "<tr height='25' id='fileItem'>";				
											echo "<td align='left' width='20'> </td> ";
										///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
											echo "<td width='120px' align='left'>";
												echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
											echo "</td>";
										///TITULO DEL RIESGO
											echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
											echo "<td width='20' align='left'> </td>";
									
										//PROBABILIDAD
											echo "<td align='left' width='130' valign='middle'>"; 
												if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

												}else if($probabilidadR[$o] == '1'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

												}else if($probabilidadR[$o] == '2'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

												}else if($probabilidadR[$o] == '3'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

												}else if($probabilidadR[$o] == '4' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

												}else if($probabilidadR[$o] =='5'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

												}
											echo "</td>";
									
										///AMENAZA DEL RIESGO Y SEMAFORO
											echo "<td align='left' width='100' valign='middle'>"; 
												if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
													
												}else if($amenazaR[$o] == 'Muy Baja'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
													
												}else if($amenazaR[$o] == 'Baja'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
													
												}else if($amenazaR[$o] == 'Media'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
													
												}else if($amenazaR[$o] == 'Alta' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
													
												}else if($amenazaR[$o] =='Muy Alta'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
													
												}
											echo "</td>";
										
											///TRATAMIENTO DEL RIESGO
												//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
											
											///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
											///VULNERABILIDAD DEL RIESGO Y SEMAFORO
											echo "<td width='20' align='left'> </td>";
											echo "<td align='left' width='100' valign='middle'>"; 
												if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
													
												}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
													
												}else if($vulnerabilidadR[$o] == 'Baja' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
													
												}else if($vulnerabilidadR[$o] == 'Media' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
													
												}else if($vulnerabilidadR[$o] == 'Alta'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
													
												}else if($vulnerabilidadR[$o] == 'Muy Alta'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
													
												}
											echo "</td>";
											echo "</tr>";	
												
											echo"<tr height='10'> </tr>";
											
										echo"</table>";
							///FIN DEL FOR DEL ARREGLO DE INTERNOS	
								}
								///SEPARADOR ENTRE TABLAS INTERNAS
								echo "<table border='0' align='center'>";
									echo "<tr height='30'></tr>";
								echo "</table>";
						///FIN DEL IF COMPROBACION DE REGISTROS INTERNOS
							}
						
						
						//}
				///FIN DEL FOR QUE RECORRE LAS OPCIONES DE INTERNOS
					$xnCategoria ++;
					}
					echo "<table border='0' align='center'>";
						echo "<tr height='30'><td> </td></tr>";
					echo "</table>";

			///FIN DEL IF COMPROBACION DE INTERNOS PARA LA CIUDAD
				} unset($indice);
		///CIERRE DE LA COMPROBACION DE LA SELECION DE INTERNAS
			}
	////////////////
	////EXTERNOS////
	////////////////
			if($externaElegida != NULL){
			///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SEA EXTERNO
				$indice = 0;
					
				if($arregloCD[$f] == "CMX"){
					
					$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' OR xt_ciudad = 'DF' AND xt_categoriaOpcion = 'Externo' ");
				
				}else{
					$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' AND xt_categoriaOpcion = 'Externo' ");
				}
				
				
				
			///SI HUBO REGISTROS CONTINUAMOS
				if($indice >= 1){
				///IMPRIMIMOS EL TITULO DE EXTERNOS
					echo "<table border='0' align='center' width='1100'>";
						echo "<tr>";
							echo "<td id='titulo2' align='left'>Externos</td>";
						echo "</tr>";
						
						echo "<tr height='10'><td> </td></tr>";
						
						echo "<tr>";
							echo "<td colspan='8' id='titleBlueLineTop'> </td>";
						echo "</tr>";
						
					echo"</table>";
				///RECORREMOS LAS OPCIONES DE EXTERNOS - 6
					for($e = 1; $e <= 6; $e++){
						//if(in_array($e, $externaElegida)){
						///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE EXTERNOS
							
							$tituloRiesgo 		= NULL;
							$codigoRiesgo 		= NULL;
							$vulnerabilidadR 	= NULL;
							$amenazaR 			= NULL;
							$estrategiaR 		= NULL;
							$probabilidadR      = NULL;
							$indice = 1;
							
						///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES
						/*if($city == "CMX"){
							$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos  WHERE (xt_ciudad = '$city' OR xt_ciudad = 'DF') AND xt_categoriaOpcion = 'Externo' AND xt_estatusActivo = 'ACTIVO' AND xn_categoria = $e   ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
						}else{
							
							$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos  WHERE xt_ciudad = '$city' AND xt_categoriaOpcion = 'Externo' AND xt_estatusActivo = 'ACTIVO' AND xn_categoria = $e   ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
						}
						*/





						///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES
							if($arregloCD[$f] == "CMX"){
								$queryExternas = "SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE (xt_ciudad = '$arregloCD[$f]' OR xt_ciudad = 'DF') AND xt_categoriaOpcion = 'Externo' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e ";
							}else{
								$queryExternas = "SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' AND xt_categoriaOpcion = 'Externo' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e ";
							}
							
						///SI SE SELECCIONO ALGUNA OPCION EN AMENAZAS LA AGREGAMOS COMO CONDICION AL QUERY	  
							/*if($queryAmenazas != ""){
								$queryExternas = $queryExternas." AND xt_amenaza IN (".$queryAmenazas.",'Nula')";
							}
						///SI SE SELECCIONO ALGUNA OPCION EN VULNERABILIDAD LA AGREGAMOS COMO CONDICION AL QUERY	
							if($queryVulnerabilidad != ""){
								$queryExternas = $queryExternas." AND (xt_vulnerabilidad IN (".$queryVulnerabilidad.") or xt_vulnerabilidad is null)";
							}
						///SI SE SELECCIONO ALGUNA OPCION EN TRATAMIENTO LA AGREGAMOS COMO CONDICION AL QUERY	
							if($queryTratamiento != ""){
								 $queryExternas = $queryExternas." AND xt_estrategia IN (".$queryTratamiento.") ";
							}*/

							///PARA FINALIZAR EL QUERY LO ORDENAMOS POR FECHA Y CODIGO DE RIESGO
							$queryExternas = $queryExternas." ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ";
							//echo "$queryExternas<br>";
							$s = $INTRANETV2->Execute($queryExternas);
							


							
							while($r = $s->fetchRow()){
								
								$codigoRiesgo[$indice] 		= $r[0];
								$tituloRiesgo[$indice] 		= $r[1];
								$vulnerabilidadR[$indice] 	= $r[2];
								$amenazaR[$indice] 			= $r[3];
								$estrategiaR[$indice] 		= $r[4];
								$proteccionR[$indice]		= $r[5];
								$probabilidadR[$indice]     = $r[6];
								
								$indice++;
								
							} unset($r); unset($s);
							
						///SI HUBO RIESGOS PARA LA CIUDAD, EXTERNOS Y LA OPCION CORRESPONDIENTE
							if($codigoRiesgo != NULL){
								
								echo "<table border='0' align='center' width='1050'>";
									
								/*echo "<table border='0' align='center'>";
							
						///TITULO DE LA OPCION EXTERNA CORRESPONDIENTE
									echo "<tr>";
										echo "<td id='titulo2' align='left' width='20'></td>";
										echo "<td colspan='8' id='titulo2' width='1080' align='left'><i>".$externas[$e]."</i></td>";
									echo "</tr>";
								echo "</table>";*/
								
								echo "<table border='0' align='center' width='1050'>";
								///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
										echo"<td align='left' width='10'> </td>";
										echo"<td align='left' width='128'>Código</td>";
										echo"<td align='left' width='375'>Título</td>";
										echo"<td align='left' width='130'>Probabilidad</td>";
										echo"<td align='left' width='130'>Amenaza</td>";

										echo"<td align='left' width='110'>Protección</td>";
										echo"<td align='center' width='115'>Vulnerabilidad</td>";
									echo"</tr>";
									
									echo"<tr height='10'> </tr>";	
											
								echo "</table>";
							///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
								for($o = 1; $o <= count($codigoRiesgo); $o++){
									echo"<table align='center' border='0' >";
								
										echo "<tr height='25' id='fileItem'>";				
											echo "<td align='left' width='20'> </td> ";
										///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
											echo "<td width='120px' align='left'>";
												echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
											echo "</td>";
										///TITULO DEL RIESGO
											echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
											echo "<td width='20' align='left'> </td>";
											//PROBABILIDAD
											echo "<td align='left' width='130' valign='middle'>"; 
												if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

												}else if($probabilidadR[$o] == '1'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

												}else if($probabilidadR[$o] == '2'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

												}else if($probabilidadR[$o] == '3'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

												}else if($probabilidadR[$o] == '4' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

												}else if($probabilidadR[$o] =='5'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

												}
											echo "</td>";
										///AMENAZA DEL RIESGO Y SEMAFORO
											echo "<td align='left' width='100' valign='middle'>"; 
												if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
													
												}else if($amenazaR[$o] == 'Muy Baja'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
													
												}else if($amenazaR[$o] == 'Baja'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
													
												}else if($amenazaR[$o] == 'Media'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
													
												}else if($amenazaR[$o] == 'Alta' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
													
												}else if($amenazaR[$o] =='Muy Alta'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
													
												}
											echo "</td>";
										
											///TRATAMIENTO DEL RIESGO
												//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
											
											///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
											///VULNERABILIDAD DEL RIESGO Y SEMAFORO
											echo "<td width='20' align='left'> </td>";
											echo "<td align='left' width='100' valign='middle'>"; 
												if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
													
												}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
													
												}else if($vulnerabilidadR[$o] == 'Baja' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
													
												}else if($vulnerabilidadR[$o] == 'Media' ){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
													
												}else if($vulnerabilidadR[$o] == 'Alta'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
													
												}else if($vulnerabilidadR[$o] == 'Muy Alta'){
													echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
													
												}
											echo "</td>";
											echo "</tr>";	
												
											echo"<tr height='10'> </tr>";
											
										echo"</table>";
							///FIN DEL FOR DEL ARREGLO DE EXTERNOS	
								}
								///SEPARADOR ENTRE TABLAS EXTERNAS
								echo "<table border='0' align='center'>";
									echo "<tr height='30'></tr>";
								echo "</table>";
						///FIN DEL IF COMPROBACION DE REGISTROS EXTERNOS
							}
						
						
						//}
				///FIN DEL FOR QUE RECORRE LAS OPCIONES DE EXTERNOS
					}
					echo "<table border='0' align='center'>";
						echo "<tr height='30'><td> </td></tr>";
					echo "</table>";
			///FIN DEL IF COMPROBACION DE EXTERNOS PARA LA CIUDAD
				} unset($indice);
			}
	//////////////////
	///SIN CATALOGAR///
	//////////////////
		$indice = 0;
		if($arregloCD[$f] == "CMX"){
			
			$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE (xt_ciudad = '$arregloCD[$f]' OR xt_ciudad = 'DF') AND xt_categoriaOpcion IS NULL");
		
		}else{
			
			$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$arregloCD[$f]' AND xt_categoriaOpcion IS NULL ");
			
		}
	///SI HUBO REGISTROS CONTINUAMOS
		if($indice >= 1){
		///IMPRIMIMOS EL TITULO DE SIN CATALOGAR
			echo "<table border='0' align='center' width='1100'>";
					echo "<tr>";
						echo "<td id='titulo2' align='left'>Sin catalogar</td>";
					echo "</tr>";
					
					echo "<tr height='10'><td> </td></tr>";
					
					echo "<tr>";
						echo "<td colspan='8' id='titleBlueLineTop'> </td>";

						echo "<tr height='40'><td> </td></tr>";
					echo "</tr>";
					
				echo"</table>";
		///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE SIN CATALOGAR
			$tituloRiesgo 		= NULL;
			$codigoRiesgo 		= NULL;
			$vulnerabilidadR 	= NULL;
			$amenazaR 			= NULL;
			$estrategiaR 		= NULL;
			$probabilidadR		= NULL;
			
			$indice = 1;
			if($arregloCD[$f] == "CMX"){
				
				$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilida FROM SGI_Riesgos  WHERE (xt_ciudad = '$arregloCD[$f]' OR xt_ciudad = 'DF') AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				
			}else{
				
				$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilida FROM SGI_Riesgos  WHERE xt_ciudad = '$arregloCD[$f]' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL)  AND xt_categoriaOpcion IS NULL ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");	
			}
		///QUERY QUE CAMBIARA DE ACUERDO CON LAS CIUDADES
			
			
			while($r = $s->fetchRow()){
				$codigoRiesgo[$indice] 		= $r[0];
				$tituloRiesgo[$indice] 		= $r[1];
				$vulnerabilidadR[$indice] 	= $r[2];
				$amenazaR[$indice] 			= $r[3];
				$estrategiaR[$indice] 		= $r[4];
				$proteccionR[$indice]		= $r[5];
				$probabilidadR[$indice]     = $r[6];
				
				$indice++;
				
			} unset($r); unset($s);
		///SI HUBO RIESGOS PARA LA CIUDAD Y SIN CATALOGAR 
			if($codigoRiesgo != NULL){
				
				echo "<table border='0' align='center' width='1050'>";
					
					
					echo"<tr height='10'> </tr>";
				///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
					
					echo"<tr height='10'> </tr>";	
							
				echo "</table>";
			///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
				for($o = 1; $o <= count($codigoRiesgo); $o++){
					echo"<table align='center' border='0' >";
								
						echo "<tr height='25' id='fileItem'>";				
							echo "<td align='left' width='20'> </td> ";
						///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
							echo "<td width='120px' align='left'>";
								echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
							echo "</td>";
						///TITULO DEL RIESGO
							echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
							echo "<td width='20' align='left'> </td>";
					
							//PROBABILIDAD
							echo "<td align='left' width='130' valign='middle'>"; 
								if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

								}else if($probabilidadR[$o] == '1'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

								}else if($probabilidadR[$o] == '2'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

								}else if($probabilidadR[$o] == '3'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

								}else if($probabilidadR[$o] == '4' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

								}else if($probabilidadR[$o] =='5'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

								}
							echo "</td>";
						///AMENAZA DEL RIESGO Y SEMAFORO
							echo "<td align='left' width='100' valign='middle'>"; 
								if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
									
								}else if($amenazaR[$o] == 'Muy Baja'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
									
								}else if($amenazaR[$o] == 'Baja'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
									
								}else if($amenazaR[$o] == 'Media'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
									
								}else if($amenazaR[$o] == 'Alta' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
									
								}else if($amenazaR[$o] =='Muy Alta'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
									
								}
							echo "</td>";
						
							///TRATAMIENTO DEL RIESGO
								//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
							
							///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
							///VULNERABILIDAD DEL RIESGO Y SEMAFORO
							echo "<td width='20' align='left'> </td>";
							echo "<td align='left' width='100' valign='middle'>"; 
								if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
									
								}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
									
								}else if($vulnerabilidadR[$o] == 'Baja' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
									
								}else if($vulnerabilidadR[$o] == 'Media' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
									
								}else if($vulnerabilidadR[$o] == 'Alta'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
									
								}else if($vulnerabilidadR[$o] == 'Muy Alta'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
									
								}
							echo "</td>";
							echo "</tr>";	
								
							echo"<tr height='10'> </tr>";
							
						echo"</table>";
			///FIN DEL FOR DEL ARREGLO DE SIN CATALOGAR	
				}
				///SEPARADOR SIN CATALOGAR
				echo "<table border='0' align='center'>";
					echo "<tr height='30'></tr>";
				echo "</table>";
		///FIN DEL IF COMPROBACION DE REGISTROS SIN CATALOGAR
			}
			echo "<table border='0' align='center'>";
				echo "<tr height='30'></tr>";
			echo "</table>";
	///FIN DEL IF COMPROBACION DE SIN CATALOGAR PARA LA CIUDAD
		} unset($indice);
		
			
	///FIN DEL CICLO FOREACH MAS EXTERNO QUE RECORRE LAS CIUDADES A DESPLEGAR
		}
		
	///FIN DEL CASO DE ADMINISTRADOR CON LOS VALORES DE LOS FILTROS ELEGIDOS
	}
	
	///SIEMPRE CIERRA EL FORM SEA CASO POR DEFECTO O CASO CON VALORES PARA LOS FILTROS
	echo "</form>";
	
	//////////////////
	///CASO INHOUSE///
	//////////////////

	} /*else if($categoriaUsr == "Inhouse"){
	
	///CASO INHOUSE VALORES POR DEFECTO

	////// GENERAL////
		/////////////////

	$indice = 0;
		
	
		///Peticion de ocultar por salvador 13 oct 2020
		
		//$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad= 'ALL' AND xt_categoriaOpcion = 'Interno' ");
		
	//	echo "<table border='0' align='center' width='1150'>";   echo "<tr height='10'> </tr>"; echo "<tr>"; 	echo "<td id='titulo2Blanco' align='left' width='1150'> Corporativos </td>"; echo "</tr>";  echo "</table>";
		$indice = 0;
	///SI HUBO REGISTROS CONTINUAMOS
		if($indice >= 1){
		///IMPRIMIMOS EL TITULO DE INTERNOS
			echo "<table border='0' align='center' width='1100'>";
				echo "<tr>";
					echo "<td id='titulo2' align='left'>Internos</td>";
				echo "</tr>";
				
				echo "<tr height='10'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td colspan='8' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
			echo"</table>";
		///RECORREMOS LAS OPCIONES DE INTERNOS - 4
			for($e = 1; $e <= 4; $e++){
			///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE INTERNOS
				$tituloRiesgo 		= NULL;
				$codigoRiesgo 		= NULL;
				$vulnerabilidadR 	= NULL;
				$amenazaR 			= NULL;
				$estrategiaR 		= NULL;
				$probabilidadR      = NULL;
				
				$indice = 1;
			///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES
				$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad= 'ALL' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL)  AND xn_categoria = $e ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				
				while($r = $s->fetchRow()){
					$codigoRiesgo[$indice] 		= $r[0];
					$tituloRiesgo[$indice] 		= $r[1];
					$vulnerabilidadR[$indice] 	= $r[2];
					$amenazaR[$indice] 			= $r[3];
					$estrategiaR[$indice] 		= $r[4];
					$proteccionR[$indice]		= $r[5];
					$probabilidadR[$indice]     = $r[6];
					
					$indice++;
					
				} unset($r); unset($s);
			///SI HUBO RIESGOS PARA LA CIUDAD, INTERNOS Y LA OPCION CORRESPONDIENTE
				if($codigoRiesgo != NULL){
						
					echo "<table border='0' align='center'>";
							
						///TITULO DE LA OPCION INTERNA CORRESPONDIENTE
						echo "<tr>";
							echo "<td id='titulo2' align='left' width='20'></td>";
							echo "<td colspan='8' id='titulo2' width='1080' align='left'><i>".$internas[$e]."</i></td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center' width='1050'>";
					///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
						
						echo"<tr height='10'> </tr>";	
								
					echo "</table>";
				///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
					for($o = 1; $o <= count($codigoRiesgo); $o++){
						echo"<table align='center' border='0' >";
								
							echo "<tr height='25' id='fileItem'>";				
								echo "<td align='left' width='20'> </td> ";
							///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
								echo "<td width='120px' align='left'>";
									echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
								echo "</td>";
							///TITULO DEL RIESGO
								echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
								echo "<td width='20' align='left'> </td>";
						
							//PROBABILIDAD
							echo "<td align='left' width='130' valign='middle'>"; 
									if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

									}else if($probabilidadR[$o] == '1'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

									}else if($probabilidadR[$o] == '2'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

									}else if($probabilidadR[$o] == '3'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

									}else if($probabilidadR[$o] == '4' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

									}else if($probabilidadR[$o] =='5'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

									}
								echo "</td>";
							///AMENAZA DEL RIESGO Y SEMAFORO
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
										
									}else if($amenazaR[$o] == 'Muy Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($amenazaR[$o] == 'Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($amenazaR[$o] == 'Media'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($amenazaR[$o] == 'Alta' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($amenazaR[$o] =='Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
										
									}
								echo "</td>";
							
								///TRATAMIENTO DEL RIESGO
									//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
								
								///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								///VULNERABILIDAD DEL RIESGO Y SEMAFORO
								echo "<td width='20' align='left'> </td>";
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
										
									}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($vulnerabilidadR[$o] == 'Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($vulnerabilidadR[$o] == 'Media' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($vulnerabilidadR[$o] == 'Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($vulnerabilidadR[$o] == 'Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
										
									}
								echo "</td>";
								echo "</tr>";	
									
								echo"<tr height='10'> </tr>";
								
							echo"</table>";
				///FIN DEL FOR DEL ARREGLO DE INTERNOS	
					}
					///SEPARADOR ENTRE TABLAS INTERNAS
					echo "<table border='0' align='center'>";
						echo "<tr height='30'></tr>";
					echo "</table>";
			///FIN DEL IF COMPROBACION DE REGISTROS INTERNOS
				}
		///FIN DEL FOR QUE RECORRE LAS OPCIONES DE INTERNOS
			}
			echo "<table border='0' align='center'>";
				echo "<tr height='30'><td> </td></tr>";
			echo "</table>";
	///FIN DEL IF COMPROBACION DE INTERNOS PARA LA CIUDAD
		} unset($indice);

	////EXTERNOS GENERAL////
	////////////////
	///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SEA EXTERNO
		$indice = 0;
			
		$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad= 'All' AND xt_categoriaOpcion = 'Externo' ");
		$indice = 0;
		
	///SI HUBO REGISTROS CONTINUAMOS
		if($indice >= 1){
		///IMPRIMIMOS EL TITULO DE EXTERNOS
			echo "<table border='0' align='center' width='1100'>";
						echo "<tr>";
							echo "<td id='titulo2' align='left'>Externos</td>";
						echo "</tr>";
						
						echo "<tr height='10'><td> </td></tr>";
						
						echo "<tr>";
							echo "<td colspan='8' id='titleBlueLineTop'> </td>";
						echo "</tr>";
						
					echo"</table>";
		///RECORREMOS LAS OPCIONES DE EXTERNOS - 6
			for($e = 1; $e <= 6; $e++){
			///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE EXTERNOS
				
				$tituloRiesgo 		= NULL;
				$codigoRiesgo 		= NULL;
				$vulnerabilidadR 	= NULL;
				$amenazaR 			= NULL;
				$estrategiaR 		= NULL;
				$probabilidadR      = NULL;
				
				$indice = 1;
			///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES
				$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad= 'ALL' AND xt_categoriaOpcion = 'Externo' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				
				while($r = $s->fetchRow()){
					
					$codigoRiesgo[$indice] 		= $r[0];
					$tituloRiesgo[$indice] 		= $r[1];
					$vulnerabilidadR[$indice] 	= $r[2];
					$amenazaR[$indice] 			= $r[3];
					$estrategiaR[$indice] 		= $r[4];
					$proteccionR[$indice]		= $r[5];
					$probabilidadR[$indice]     = $r[6];
					
					$indice++;
					
				} unset($r); unset($s);
			///SI HUBO RIESGOS PARA LA CIUDAD, EXTERNOS Y LA OPCION CORRESPONDIENTE
				if($codigoRiesgo != NULL){
					
					echo "<table border='0' align='center'>";
							
					///TITULO DE LA OPCION EXTERNA CORRESPONDIENTE
						echo "<tr>";
							echo "<td id='titulo2' align='left' width='20'></td>";
							echo "<td colspan='8' id='titulo2' width='1080' align='left'><i>".$externas[$e]."</i></td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center' width='1050'>";
					///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
						
						echo"<tr height='10'> </tr>";	
								
					echo "</table>";
				///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
					for($o = 1; $o <= count($codigoRiesgo); $o++){
						echo"<table align='center' border='0' >";
								
							echo "<tr height='25' id='fileItem'>";				
								echo "<td align='left' width='20'> </td> ";
							///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
								echo "<td width='120px' align='left'>";
									echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
								echo "</td>";
							///TITULO DEL RIESGO
								echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
								echo "<td width='20' align='left'> </td>";
							//PROBABILIDAD
								echo "<td align='left' width='130' valign='middle'>"; 
									if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

									}else if($probabilidadR[$o] == '1'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

									}else if($probabilidadR[$o] == '2'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

									}else if($probabilidadR[$o] == '3'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

									}else if($probabilidadR[$o] == '4' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

									}else if($probabilidadR[$o] =='5'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

									}
								echo "</td>";
							///AMENAZA DEL RIESGO Y SEMAFORO
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
										
									}else if($amenazaR[$o] == 'Muy Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($amenazaR[$o] == 'Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($amenazaR[$o] == 'Media'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($amenazaR[$o] == 'Alta' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($amenazaR[$o] =='Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
										
									}
								echo "</td>";
							
								///TRATAMIENTO DEL RIESGO
									//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
								
								///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								///VULNERABILIDAD DEL RIESGO Y SEMAFORO
								echo "<td width='20' align='left'> </td>";
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
										
									}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($vulnerabilidadR[$o] == 'Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($vulnerabilidadR[$o] == 'Media' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($vulnerabilidadR[$o] == 'Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($vulnerabilidadR[$o] == 'Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
										
									}
								echo "</td>";
								echo "</tr>";	
									
								echo"<tr height='10'> </tr>";
								
							echo"</table>";
				///FIN DEL FOR DEL ARREGLO DE EXTERNOS	
					}
					///SEPARADOR ENTRE TABLAS EXTERNAS
					echo "<table border='0' align='center'>";
						echo "<tr height='30'></tr>";
					echo "</table>";
			///FIN DEL IF COMPROBACION DE REGISTROS EXTERNOS
				}
		///FIN DEL FOR QUE RECORRE LAS OPCIONES DE EXTERNOS
			}
			echo "<table border='0' align='center'>";
				echo "<tr height='30'><td> </td></tr>";
			echo "</table>";
	///FIN DEL IF COMPROBACION DE EXTERNOS PARA LA CIUDAD
		} unset($indice);



	//POR CIUDAD POR DEFECTO//
	//echo"SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'<br>";	
	$ciudadIn = $INTRANET->getOne("SELECT xt_ciudad FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");

	if($ciudadIn == 'DF'){
		$ciudadIn == 'CMX';
		$ciudadInNombre = 'Ciudad de México';	
	}if($ciudadIn == 'VER'){
		$ciudadInNombre = 'Veracruz';	
	}if($ciudadIn == 'TOL'){
		$ciudadInNombre = 'Toluca';	
	}if($ciudadIn == 'CUN'){
		$ciudadInNombre = 'Cancún';	
	}if($ciudadIn == 'LNR'){
		$ciudadInNombre = 'Nuevo Laredo';	
	}if($ciudadIn == 'LR'){
		$ciudadInNombre = 'Laredo';	
	}if($ciudadIn == 'LAR'){
		$ciudadIn == 'LR';
		$ciudadInNombre = 'Laredo';	
	}
	if($ciudadIn == 'QRO'){
		$ciudadInNombre = 'Queretaro';	
	}
	///DESPLIEGUE DE LA INFORMACION
			
		$indice = $INTRANETV2->getOne("SELECT xt_codigoRiesgos FROM SGI_Riesgos WHERE xt_ciudad= 'ALL'");
		
		
			echo "<table border='0' align='center' width='1150'>";
				
					echo "<tr height='10'> </tr>";
					
					echo "<tr>";
						echo "<td id='titulo2Blanco' align='left' width='1150'>".$ciudadInNombre."</td>";
					echo "</tr>";
				//echo "<tr>";
					//echo "<td id='titleBlueLineBottom'> </td>";
				//echo "</tr>";
				
			echo "</table>";
			
			
	////////////////
	////INTERNOS////
	////////////////
	///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SEA INTERNO
		$indice = 0;
		
		if($ciudadIn == "CMX"){
			
			$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad= '$ciudadIn' OR xt_ciudad = 'DF' AND xt_categoriaOpcion = 'Interno'");
		}else{
			$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad= '$ciudadIn' AND xt_categoriaOpcion = 'Interno'");
		}
	
		
		
	///SI HUBO REGISTROS CONTINUAMOS
		if($indice >= 1){
		///IMPRIMIMOS EL TITULO DE INTERNOS
			echo "<table border='0' align='center' width='1100'>";
				echo "<tr>";
					echo "<td id='titulo2' align='left'>Internos</td>";
				echo "</tr>";
				
				echo "<tr height='10'><td> </td></tr>";
				
				echo "<tr>";
					echo "<td colspan='8' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
			echo"</table>";
		///RECORREMOS LAS OPCIONES DE INTERNOS - 4
			for($e = 1; $e <= 4; $e++){
			///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE INTERNOS
				$tituloRiesgo 		= NULL;
				$codigoRiesgo 		= NULL;
				$vulnerabilidadR 	= NULL;
				$amenazaR 			= NULL;
				$estrategiaR 		= NULL;
				$probabilidadR      = NULL;
				
				$indice = 1;
				
				if($ciudadIn == "CMX"){
					
					$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE (xt_ciudad= '$ciudadIn' OR xt_ciudad= 'DF') AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion = 'Interno'  AND xn_categoria = $e ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				}else{
					
					$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos WHERE xt_ciudad= '$ciudadIn' AND xt_categoriaOpcion = 'Interno' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xn_categoria = $e  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				}
			///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES
				
				
				while($r = $s->fetchRow()){
					$codigoRiesgo[$indice] 		= $r[0];
					$tituloRiesgo[$indice] 		= $r[1];
					$vulnerabilidadR[$indice] 	= $r[2];
					$amenazaR[$indice] 			= $r[3];
					$estrategiaR[$indice] 		= $r[4];
					$proteccionR[$indice]		= $r[5];
					$probabilidadR[$indice]     = $r[6];
					
					$indice++;
					
				} unset($r); unset($s);
			///SI HUBO RIESGOS PARA LA CIUDAD, INTERNOS Y LA OPCION CORRESPONDIENTE
				if($codigoRiesgo != NULL){
						
					echo "<table border='0' align='center'>";
							
						///TITULO DE LA OPCION INTERNA CORRESPONDIENTE
						echo "<tr>";
							echo "<td id='titulo2' align='left' width='20'></td>";
							echo "<td colspan='8' id='titulo2' width='1080' align='left'><i>".$internas[$e]."</i></td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center' width='1050'>";
					///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
						
						echo"<tr height='10'> </tr>";	
								
					echo "</table>";
				///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
					for($o = 1; $o <= count($codigoRiesgo); $o++){
						echo"<table align='center' border='0' >";
								
							echo "<tr height='25' id='fileItem'>";				
								echo "<td align='left' width='20'> </td> ";
							///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
								echo "<td width='120px' align='left'>";
									echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
								echo "</td>";
							///TITULO DEL RIESGO
								echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
								echo "<td width='20' align='left'> </td>";
						
							//PROBABILIDAD
								echo "<td align='left' width='130' valign='middle'>"; 
									if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

									}else if($probabilidadR[$o] == '1'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

									}else if($probabilidadR[$o] == '2'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

									}else if($probabilidadR[$o] == '3'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

									}else if($probabilidadR[$o] == '4' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

									}else if($probabilidadR[$o] =='5'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

									}
								echo "</td>";
							///AMENAZA DEL RIESGO Y SEMAFORO
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
										
									}else if($amenazaR[$o] == 'Muy Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($amenazaR[$o] == 'Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($amenazaR[$o] == 'Media'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($amenazaR[$o] == 'Alta' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($amenazaR[$o] =='Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
										
									}
								echo "</td>";
							
								///TRATAMIENTO DEL RIESGO
									//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
								
								///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								///VULNERABILIDAD DEL RIESGO Y SEMAFORO
								echo "<td width='20' align='left'> </td>";
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
										
									}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($vulnerabilidadR[$o] == 'Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($vulnerabilidadR[$o] == 'Media' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($vulnerabilidadR[$o] == 'Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($vulnerabilidadR[$o] == 'Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
										
									}
								echo "</td>";
								echo "</tr>";	
									
								echo"<tr height='10'> </tr>";
								
							echo"</table>";
				///FIN DEL FOR DEL ARREGLO DE INTERNOS	
					}
					///SEPARADOR ENTRE TABLAS INTERNAS
					echo "<table border='0' align='center'>";
						echo "<tr height='30'></tr>";
					echo "</table>";
			///FIN DEL IF COMPROBACION DE REGISTROS INTERNOS
				}
		///FIN DEL FOR QUE RECORRE LAS OPCIONES DE INTERNOS
			}
			echo "<table border='0' align='center'>";
				echo "<tr height='30'><td> </td></tr>";
			echo "</table>";
	///FIN DEL IF COMPROBACION DE INTERNOS PARA LA CIUDAD
		} unset($indice);
	////////////////
	////EXTERNOS////
	////////////////
	///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SEA EXTERNO
		$indice = 0;
	
		if($ciudadIn == 'CMX'){
			
			$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad= '$ciudadIn' OR xt_ciudad= 'DF' AND xt_categoriaOpcion = 'Externo' ");
		}else{
			
			$indice = $INTRANETV2->getOne("SELECT count(xt_codigoRiesgo) FROM SGI_Riesgos WHERE xt_ciudad= '$ciudadIn' AND xt_categoriaOpcion = 'Externo' ");
		}
			
		
		
	
	///SI HUBO REGISTROS CONTINUAMOS
		if($indice >= 1){
		///IMPRIMIMOS EL TITULO DE EXTERNOS
			echo "<table border='0' align='center' width='1100'>";
						echo "<tr>";
							echo "<td id='titulo2' align='left'>Externos</td>";
						echo "</tr>";
						
						echo "<tr height='10'><td> </td></tr>";
						
						echo "<tr>";
							echo "<td colspan='8' id='titleBlueLineTop'> </td>";
						echo "</tr>";
						
					echo"</table>";
		///RECORREMOS LAS OPCIONES DE EXTERNOS - 6
			for($e = 1; $e <= 6; $e++){
			///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE EXTERNOS
				$tituloRiesgo 		= NULL;
				$codigoRiesgo 		= NULL;
				$vulnerabilidadR 	= NULL;
				$amenazaR 			= NULL;
				$estrategiaR 		= NULL;
				$probabilidadR      = NULL;
				
				$indice = 1;
				
				if($ciudadIn == 'CMX'){
					
					$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos 
										 WHERE (xt_ciudad= '$ciudadIn' OR xt_ciudad= 'DF') AND xt_categoriaOpcion = 'Externo' AND xn_categoria = $e AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL)  
										 ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				}else{
					
					$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos 
										 WHERE xt_ciudad= '$ciudadIn' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion = 'Externo' AND xn_categoria = $e  
										 ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
				}
				
			///QUERY QUE CAMBIARA DE ACUERDO AL CICLO FOR DE LAS OPCIONES Y DESPUES A SU VEZ CON LAS CIUDADES
				
				
				while($r = $s->fetchRow()){
					$codigoRiesgo[$indice] 		= $r[0];
					$tituloRiesgo[$indice] 		= $r[1];
					$vulnerabilidadR[$indice] 	= $r[2];
					$amenazaR[$indice] 			= $r[3];
					$estrategiaR[$indice] 		= $r[4];
					$proteccionR[$indice]		= $r[5];
					$probabilidadR[$indice]     = $r[6];
					
					$indice++;
					
				} unset($r); unset($s);
			///SI HUBO RIESGOS PARA LA CIUDAD, EXTERNOS Y LA OPCION CORRESPONDIENTE
				if($codigoRiesgo != NULL){
					
					echo "<table border='0' align='center'>";
							
					///TITULO DE LA OPCION EXTERNA CORRESPONDIENTE
						echo "<tr>";
							echo "<td id='titulo2' align='left' width='20'></td>";
							echo "<td colspan='8' id='titulo2' width='1080' align='left'><i>".$externas[$e]."</i></td>";
						echo "</tr>";
					echo "</table>";
					
					echo "<table border='0' align='center' width='1050'>";
					///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
						
						echo"<tr height='10'> </tr>";	
								
					echo "</table>";
				///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
					for($o = 1; $o <= count($codigoRiesgo); $o++){
						echo"<table align='center' border='0' >";
								
							echo "<tr height='25' id='fileItem'>";				
								echo "<td align='left' width='20'> </td> ";
							///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
								echo "<td width='120px' align='left'>";
									echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
								echo "</td>";
							///TITULO DEL RIESGO
								echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
								echo "<td width='20' align='left'> </td>";
						
							//PROBABILIDAD
								echo "<td align='left' width='130' valign='middle'>"; 
									if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

									}else if($probabilidadR[$o] == '1'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

									}else if($probabilidadR[$o] == '2'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

									}else if($probabilidadR[$o] == '3'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

									}else if($probabilidadR[$o] == '4' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

									}else if($probabilidadR[$o] =='5'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

									}
								echo "</td>";
							///AMENAZA DEL RIESGO Y SEMAFORO
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
										
									}else if($amenazaR[$o] == 'Muy Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($amenazaR[$o] == 'Baja'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($amenazaR[$o] == 'Media'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($amenazaR[$o] == 'Alta' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($amenazaR[$o] =='Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
										
									}
								echo "</td>";
							
								///TRATAMIENTO DEL RIESGO
									//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
								
								///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
								///VULNERABILIDAD DEL RIESGO Y SEMAFORO
								echo "<td width='20' align='left'> </td>";
								echo "<td align='left' width='100' valign='middle'>"; 
									if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
										
									}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
										
									}else if($vulnerabilidadR[$o] == 'Baja' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
										
									}else if($vulnerabilidadR[$o] == 'Media' ){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
										
									}else if($vulnerabilidadR[$o] == 'Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
										
									}else if($vulnerabilidadR[$o] == 'Muy Alta'){
										echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
										
									}
								echo "</td>";
								echo "</tr>";	
									
								echo"<tr height='10'> </tr>";
								
							echo"</table>";
				///FIN DEL FOR DEL ARREGLO DE EXTERNOS	
					}
					///SEPARADOR ENTRE TABLAS EXTERNAS
					echo "<table border='0' align='center'>";
						echo "<tr height='30'></tr>";
					echo "</table>";
			///FIN DEL IF COMPROBACION DE REGISTROS EXTERNOS
				}
		///FIN DEL FOR QUE RECORRE LAS OPCIONES DE EXTERNOS
			}
			echo "<table border='0' align='center'>";
				echo "<tr height='30'><td> </td></tr>";
			echo "</table>";
	///FIN DEL IF COMPROBACION DE EXTERNOS PARA LA CIUDAD
		} unset($indice);
		
	////////////////
	////SIN CATA////
	////////////////
	///OBTENEMOS INFORMACION DISPONIBLE PARA ESA CIUDAD Y QUE LA CATEGORIA SIN CATALOGAR
		$indice = 0;
	
		if($ciudadIn == 'CMX'){
			
			$indice = $INTRANETV2->getOne("SELECT count(xt_codioRiesgo) FROM SGI_Riesgos WHERE (xt_ciudad = '$ciudadIn' OR xt_ciudad= 'DF' )AND xt_categoriaOpcion IS NULL ");
			
		}else{
			
			$indice = $INTRANETV2->getOne("SELECT count(xt_codioRiesgo) FROM SGI_Riesgos WHERE xt_ciudad = '$ciudadIn' AND xt_categoriaOpcion IS NULL ");	
		}
			
		
		
		
	///SI HUBO REGISTROS CONTINUAMOS
		if($indice >= 1){
		///IMPRIMIMOS EL TITULO DE SIN CATALOGAR
			echo "<table border='0' align='center' width='1100'>";
					echo "<tr>";
						echo "<td id='titulo2' align='left'>Sin catalogar</td>";
					echo "</tr>";
					
					echo "<tr height='10'><td> </td></tr>";
					
					echo "<tr>";
						echo "<td colspan='8' id='titleBlueLineTop'> </td>";
					echo "</tr>";

					echo "<tr height='30'><td> </td></tr>";
				
				echo"</table>";


		///INICIALIZAMOS LOS DATOS QUE OBTENDREMOS DE SIN CATALOGAR
			$tituloRiesgo 		= NULL;
			$codigoRiesgo 		= NULL;
			$vulnerabilidadR 	= NULL;
			$amenazaR 			= NULL;
			$estrategiaR 		= NULL;
			$probabilidadR      = NULL;
			
			$indice = 1;
			
			if($ciudadIn == 'CMX'){
				
				$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos 
									 WHERE (xt_ciudad= '$ciudadIn' OR xt_ciudad= 'DF') AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL  
									 ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
			
			}else{
				
				$s = $INTRANETV2->Execute("SELECT xt_codigoRiesgo, xt_tituloRiesgo, xt_vulnerabilidad, xt_amenaza, xt_estrategia, xn_proteccion, xn_probabilidad FROM SGI_Riesgos 
									 WHERE xt_ciudad= '$ciudadIn' AND (xt_estatusActivo = 'ACTIVO' OR xt_estatusActivo IS NULL) AND xt_categoriaOpcion IS NULL  
									 ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
			}
		///QUERY QUE CAMBIARA DE ACUERDO CON LAS CIUDADES
			
			
			while($r = $s->fetchRow()){
				$codigoRiesgo[$indice] 		= $r[0];
				$tituloRiesgo[$indice] 		= $r[1];
				$vulnerabilidadR[$indice] 	= $r[2];
				$amenazaR[$indice] 			= $r[3];
				$estrategiaR[$indice] 		= $r[4];
				$proteccionR[$indice]		= $r[5];
				$probabilidadR[$indice]     = $r[6];
				
				$indice++;
				
			} unset($r); unset($s);
		///SI HUBO RIESGOS PARA LA CIUDAD Y SIN CATALOGAR 
			if($codigoRiesgo != NULL){
				
				echo "<table border='0' align='center' width='1050'>";
				
				echo"<tr height='10'> </tr>";
				///CABECERA DE LA TABLA
							echo"<tr id='iconosTexto2'>";
								echo"<td align='left' width='10'> </td>";
								echo"<td align='left' width='128'>Código</td>";
								echo"<td align='left' width='375'>Título</td>";
								echo"<td align='left' width='130'>Probabilidad</td>";
								echo"<td align='left' width='130'>Amenaza</td>";
								                                                                                                                                      
								echo"<td align='left' width='110'>Protección</td>";
								echo"<td align='center' width='115'>Vulnerabilidad</td>";
							echo"</tr>";
					
					echo"<tr height='10'> </tr>";	
							
				echo "</table>";
			///RECORREMOS EL ARREGLO DE LOS RIESGOS CORRESPONDIENTES PARA IMPRIMIR LOS REGISTROS	
				for($o = 1; $o <= count($codigoRiesgo); $o++){
					echo"<table align='center' border='0' >";
								
						echo "<tr height='25' id='fileItem'>";				
							echo "<td align='left' width='20'> </td> ";
						///IDENTIFICADOR DEL RIESGO Y ENLACE A LA FICHA ESPECIFICA
							echo "<td width='120px' align='left'>";
								echo"<a href='fichaRiesgov2.php?id=".$codigoRiesgo[$o]."' id='fileItem' style='text-decoration:none;'>".$codigoRiesgo[$o]."</a>";
							echo "</td>";
						///TITULO DEL RIESGO
							echo "<td width='360px' align='left'>".$tituloRiesgo[$o]."</td>";
							echo "<td width='20' align='left'> </td>";
						
							//PROBABILIDAD
							echo "<td align='left' width='130' valign='middle'>"; 
								if(($probabilidadR[$o] == '0') || ($probabilidadR[$o] == "")){

								}else if($probabilidadR[$o] == '1'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";

								}else if($probabilidadR[$o] == '2'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";

								}else if($probabilidadR[$o] == '3'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";

								}else if($probabilidadR[$o] == '4' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";

								}else if($probabilidadR[$o] =='5'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";

								}
							echo "</td>";
						///AMENAZA DEL RIESGO Y SEMAFORO
							echo "<td align='left' width='100' valign='middle'>"; 
								if(($amenazaR[$o] == 'Nula') || ($amenazaR[$o] == "")){
									
								}else if($amenazaR[$o] == 'Muy Baja'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
									
								}else if($amenazaR[$o] == 'Baja'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
									
								}else if($amenazaR[$o] == 'Media'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
									
								}else if($amenazaR[$o] == 'Alta' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
									
								}else if($amenazaR[$o] =='Muy Alta'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'>Muy Alta";
									
								}
							echo "</td>";
						
							///TRATAMIENTO DEL RIESGO
								//echo"<td align='left' width='200'>".$estrategiaR[$o]."</td>";
							
							///PROTECCION DEL RIESGO Y SEMAFORO
									echo "<td width='20' align='left'> </td>";
									echo "<td align='left' width='100' valign='middle'>"; 
										if(      $proteccionR[$o] == 1){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Baja";
											
										}else if($proteccionR[$o] == 2){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Baja";
											
										}else if($proteccionR[$o] == 3){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
											
										}else if($proteccionR[$o] == 4){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Alta";
											
										}else if($proteccionR[$o] == 5){
											echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Alta";
											
										}
									echo "</td>";
							///VULNERABILIDAD DEL RIESGO Y SEMAFORO
							echo "<td width='20' align='left'> </td>";
							echo "<td align='left' width='100' valign='middle'>"; 
								if(($vulnerabilidadR[$o] == 'Nula') || ($vulnerabilidadR[$o] == "")){
									
								}else if($vulnerabilidadR[$o] == 'Muy Baja' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'> Muy Baja";
									
								}else if($vulnerabilidadR[$o] == 'Baja' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'> Baja";
									
								}else if($vulnerabilidadR[$o] == 'Media' ){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'> Media";
									
								}else if($vulnerabilidadR[$o] == 'Alta'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'> Alta";
									
								}else if($vulnerabilidadR[$o] == 'Muy Alta'){
									echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'> Muy Alta";
									
								}
							echo "</td>";
							echo "</tr>";	
								
							echo"<tr height='10'> </tr>";
							
						echo"</table>";
			///FIN DEL FOR DEL ARREGLO DE SIN CATALOGAR	
				}
				///SEPARADOR SIN CATALOGAR
				echo "<table border='0' align='center'>";
					echo "<tr height='30'></tr>";
				echo "</table>";
		///FIN DEL IF COMPROBACION DE REGISTROS SIN CATALOGAR
			}
			echo "<table border='0' align='center'>";
				echo "<tr height='30'></tr>";
			echo "</table>";


	///FIN DEL IF COMPROBACION DE SIN CATALOGAR PARA LA CIUDAD
		} unset($indice);
		

	
/////FIN CASO INHOUSE
/*}



?>
		</body>
	</html>

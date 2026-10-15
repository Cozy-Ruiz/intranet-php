<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'tableroRiesgos.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tablero de Riesgos</title>
 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
<link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
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
$breadcrumb="<a href='../Home.php' id='breadcrumbs'> Home / </a> <a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral /</a><a href='Modulos.php' id='breadcrumbs'> Módulos /</a><a href='Riesgos.php' id='breadcrumbs'> Riesgos </a>";

$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN"; 
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";

$ciudadesDisponibles = NULL;
$indice = 1;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

echo "<div id='wrapperRiesgos'>";
  echo "<form name='tableroRiesgos' method='post' action='tableroRiesgos.php'>";	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Riesgos</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center'>";
				echo "<font>$breadcrumb</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr height='40'> </tr>";
	echo "</table>";

	//ADMINISTRADOR	FILTRO
	echo "<table border='0' align='center' width='1150' id='ocultar' style='display:block;'>";
		
		echo"<tr>";
			echo"<td colspan='6' align='left' id='iconosTexto2' onClick='show(1);'> Filtrar </td>";
		echo"</tr>";
	echo"</table>";
	
	echo "<table border='0' align='center' width='1150' id='mostrar' style='display:none;'>";
		
		echo"<tr>";
			echo"<td colspan='6' align='left' id='iconosTexto2' onClick='show(0);'> Filtrar </td>";
		echo"</tr>";
		
		echo"<tr height='5'></tr>";

		echo "<tr>";
			if($categoriaUsr == "Administrador"){
				echo "<td align='left' id='breadcrumbs' width='160' >Ciudad</td>";
				echo "<td align='left' id='breadcrumbs' width='180' >Categoria Internos</td>";
				echo "<td align='left' id='breadcrumbs' width='190' >Categoria Externos</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Amenaza</td>";
				echo "<td align='left' id='breadcrumbs' width='160' >Vulnerabilidad</td>";
				echo "<td align='left' id='breadcrumbs' width='300' >Tratamiento</td>";
			}else if($categoriaUsr == "Inhouse"){
				echo "<td id='iconosTexto2'> </td>";
			}
		echo "</tr>";
			
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			
			echo "<td id='breadcrumbs' valign='top'>";
			if($categoriaUsr == "Administrador"){
				//echo"<input type='checkbox' name='ciudad[]' value='Todas'> Todas <br>";	
				for($a=1;$a<=6;$a++){
					if(in_array($cdValor[$a],$ciudadesDisponibles)){
						echo"<input type='checkbox' name='ciudad[]' value='".$cdValor[$a]."'>$ciudades[$a]<br>";
						
					}
				}
			}
			echo"</td>";
	
			echo "<td id='breadcrumbs' valign='top'>";
				if($categoriaUsr == "Administrador"){
				//echo"<input type='checkbox' name='categoriaI[]' value='Todas'> Todas <br>";	
				echo"<input type='checkbox' name='categoriaI[]' value='1'> Operacionales <br>";
				echo"<input type='checkbox' name='categoriaI[]' value='2'> Personales <br>";
				echo"<input type='checkbox' name='categoriaI[]' value='3'>Organización <br>";
				echo"<input type='checkbox' name='categoriaI[]' value='4'> Estrategicos <br>";
				
				} 
			echo"</td>";
			
			echo "<td id='breadcrumbs' valign='top'>";
				if($categoriaUsr == "Administrador"){
				//echo"<input type='checkbox' name='categoriaE[]' value='Todas'> Todas <br>";	
				echo"<input type='checkbox' name='categoriaE[]' value='1'> Catástofres naturales <br>";
				echo"<input type='checkbox' name='categoriaE[]' value='2'> Políticos <br>";
				echo"<input type='checkbox' name='categoriaE[]' value='3'> Legales <br>";
				echo"<input type='checkbox' name='categoriaE[]' value='4'> Mercado <br>";
				echo"<input type='checkbox' name='categoriaE[]' value='5'> Económicos <br>";
				echo"<input type='checkbox' name='categoriaE[]' value='6'> Medio ambiente <br>";
				
				} 
			echo"</td>";
			
			echo "<td id='breadcrumbs' valign='top'>";
			if($categoriaUsr == "Administrador"){
				//echo"<input type='checkbox' name='amenaza[]' value='Todas'> Todas <br>";	
				echo"<input type='checkbox' name='amenaza[]' value='Muy Baja'> Muy Baja <br>";
				echo"<input type='checkbox' name='amenaza[]' value='Baja'> Baja <br>";
				echo"<input type='checkbox' name='amenaza[]' value='Media'> Media <br>";
				echo"<input type='checkbox' name='amenaza[]' value='Alta'> Alta <br>";
				echo"<input type='checkbox' name='amenaza[]' value='Muy Alta'> Muy Alta <br>";
					}
			echo"</td>";
			
			echo "<td id='breadcrumbs' valign='top'>";
			if($categoriaUsr == "Administrador"){
				//echo"<input type='checkbox' name='vulnerabilidad[]' value='Todas'> Todas <br>";	
				echo"<input type='checkbox' name='vulnerabilidad[]' value='Muy Baja'> Muy Baja <br>";
				echo"<input type='checkbox' name='vulnerabilidad[]' value='Baja'> Baja <br>";
				echo"<input type='checkbox' name='vulnerabilidad[]' value='Media'> Media <br>";
				echo"<input type='checkbox' name='vulnerabilidad[]' value='Alta'> Alta <br>";
				echo"<input type='checkbox' name='vulnerabilidad[]' value='Muy Alta'> Muy Alta <br>";
			}
				
			echo"</td>";
			
			echo "<td id='breadcrumbs' valign='top'>";
			if($categoriaUsr == "Administrador"){
				echo"<input type='checkbox' name='tratamiento[]' value='Evitar el riesgo'> Evitar el riesgo <br>";	
				echo"<input type='checkbox' name='tratamiento[]' value='Eliminar la fuente del riesgo'> Eliminar la fuente del riesgo <br>";
				echo"<input type='checkbox' name='tratamiento[]' value='Disminuir su probabilidad o impacto'> Disminuir su probabilidad o impacto <br>";
				echo"<input type='checkbox' name='tratamiento[]' value='Compartir el riesgo'> Compartir el riesgo <br>";
				echo"<input type='checkbox' name='tratamiento[]' value='Aceptar el riesgo'> Aceptar el riesgo <br>";
				echo"<input type='checkbox' name='tratamiento[]' value='Niveles del riesgo residual son tolerables'> Niveles del riesgo residual son tolerables <br>";
					
					}
				
			echo"</td>";

		echo "</tr>";
		
		echo"<tr height='20'> </tr>";
		
		echo"<tr>";
			echo"<td align='center' colspan='6'><input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='25'> </td>";
		echo"</tr>";
	echo"</table>";
	
	echo "<table border='0' align='center' width='1150'>";
		echo "<tr>";
			$ciudad = $_POST['ciudad'];
			if($ciudad !=""){
				if($ciudad == 'DF'){
					$nombreCiudad = 'Distrito Federal';	
				}else if($ciudad == 'NLR'){
					$nombreCiudad = 'Nuevo Laredo';	
				}else if($ciudad == 'CUN'){
					$nombreCiudad = 'Cancún';	
				}else if($ciudad == 'VER'){
					$nombreCiudad = 'Veracruz';	
				}else if($ciudad == 'TOL'){
					$nombreCiudad = 'Toluca';	
				}else if($ciudad == 'LAR'){
					$nombreCiudad = 'Laredo';	
				}
				
				$categoria = $_POST['categoria'];
				
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr><td id='titulo2' align='left' colspan='2'>$nombreCiudad</td> </tr>";
	echo"</table>";
	

	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =1 AND xt_categoriaOpcion='Interno' AND xt_ciudad ='$ciudad' 
	ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){
			
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr>";
					echo "<td id='titulo2' align='center'>Internos</td>";
				echo "</tr>";
			echo"</table>";
			
			// INTERNO OPERACIONALES
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Operacionales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				echo"<tr height='10'> </tr>";	
						
			echo "</table>";	
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
		
		echo"<tr height='10'> </tr>";
	echo"</table>";	
	echo "<table border='0' align='center'>";
		echo "<tr height='30'></tr>";
	echo "</table>";
	}
	
	

	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =2 AND xt_categoriaOpcion='Interno' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){
					
		// INTERNO PERSONAL
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Personal</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
				
		echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =3 AND xt_categoriaOpcion='Interno' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){	
		//INTERNOS ORGANIZACION
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Organización</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =4 AND xt_categoriaOpcion='Interno' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
		
	while($r = $s->fetchRow($s)){
		if($indice == 0){	
		//INTERNOS ESTRATEGICOS
	
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Estratégicos</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
		echo"<table align='center' border='0' width='1150'>";
			
		}
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 0){	
			echo"<tr height='40'> </tr>";
		echo"</table>";
		
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	echo "<table width='1150' border='0' align='center'>";
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";
	
	

	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =1 AND xt_categoriaOpcion='Externo' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice >=1){
			
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr>";
					echo "<td id='titulo2' align='center'>Externos</td>";
				echo "</tr>";
			echo"</table>";
		}
		if($indice == 0){

			//EXTERNOS CATASTROFES NATURALES
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Catástrofes naturales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =2 AND xt_categoriaOpcion='Externo' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
						
			//EXTERNOS POLITICOS
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Políticos</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		$indice++;
	}
	if($indice >= 1){
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
		
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =3 AND xt_categoriaOpcion='Externo' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS LEGALES
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Legales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	
		
			echo"<table align='center' border='0' width='1150'>";
		}
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =4 AND xt_categoriaOpcion='Externo' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS MERCADO
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Mercado</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";
		

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =5 AND xt_categoriaOpcion='Externo' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS ECONOMICOS
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Económicos</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =6 AND xt_categoriaOpcion='Externo' AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS MEDIO AMBIENTE
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Medio ambiente</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	echo "<table width='1150' border='0' align='center'>";
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";

	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xt_categoriaOpcion IS NULL AND xt_ciudad ='$ciudad' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){
			
			//SIN CATALOGAR
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr>";
					echo "<td id='titulo2' align='center'>Sin catalogar</td>";
				echo "</tr>";
			echo"</table>";
			
			// SIN CATALOGAR 
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
						
			echo "</table>";	
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
		
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
//////////TODAS LAS CIUDADES///////

	}else if($ciudad == ""){
					
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		echo"<tr><td id='titulo2' align='left' colspan='2'>$nombreCiudad</td> </tr>";
	echo"</table>";
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =1 AND xt_categoriaOpcion='Interno' 
	ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){
			
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr>";
					echo "<td id='titulo2' align='center'>Internos</td>";
				echo "</tr>";
			echo"</table>";
			
			// INTERNO OPERACIONALES
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Operacionales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
						
			echo "</table>";	
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
		
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	

	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =2 AND xt_categoriaOpcion='Interno'  ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){	
		// INTERNO PERSONAL
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Personal</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
				
		echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =3 AND xt_categoriaOpcion='Interno' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){	
		//INTERNOS ORGANIZACION
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Organización</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =4 AND xt_categoriaOpcion='Interno' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
		
	while($r = $s->fetchRow($s)){
		if($indice == 0){	
		//INTERNOS ESTRATEGICOS
	
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Estratégicos</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
		echo"<table align='center' border='0' width='1150'>";
			
		}
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 0){	
			echo"<tr height='40'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	echo "<table width='1150' border='0' align='center'>";
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='1150'>";
		echo "<tr>";
			echo "<td id='titulo2' align='center'>Externos</td>";
		echo "</tr>";
		echo"<tr height='20'> </tr>";
	echo"</table>";	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =1 AND xt_categoriaOpcion='Externo' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS CATASTROFES NATURALES
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Catástrofes naturales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =2 AND xt_categoriaOpcion='Externo' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){		
			//EXTERNOS POLITICOS
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Políticos</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		$indice++;
	}
	if($indice >= 1){
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
		
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =3 AND xt_categoriaOpcion='Externo' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS LEGALES
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Legales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	
		
			echo"<table align='center' border='0' width='1150'>";
		}
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =4 AND xt_categoriaOpcion='Externo' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS MERCADO
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Mercado</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";
		

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =5 AND xt_categoriaOpcion='Externo' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS ECONOMICOS
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Económicos</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =6 AND xt_categoriaOpcion='Externo' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS MEDIO AMBIENTE
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Medio ambiente</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	echo "<table width='1150' border='0' align='center'>";
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";

	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xt_categoriaOpcion IS NULL ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){
			
			//SIN CATALOGAR
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr>";
					echo "<td id='titulo2' align='center'>Sin catalogar</td>";
				echo "</tr>";
			echo"</table>";
			
			// SIN CATALOGAR 
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
						
			echo "</table>";	
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
		
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	
	
///////////////INHOUSE	
}else if($categoriaUsr == "Inhouse"){
	echo " <input type='hidden' name='ciudad' value='".$ciudadesDisponibles[1]."'>";
	
	echo "<table border='0' align='center' width='1150'>";
		if($ciudadesDisponibles[1] == 'DF'){
				$nombreCiudad = 'Distrito Federal';	
			}else if($ciudadesDisponibles[1] == 'NLR'){
				$nombreCiudad = 'Nuevo Laredo';	
			}else if($ciudadesDisponibles[1] == 'CUN'){
				$nombreCiudad = 'Cancún';	
			}else if($ciudadesDisponibles[1] == 'VER'){
				$nombreCiudad = 'Veracruz';	
			}else if($ciudadesDisponibles[1] == 'TOL'){
				$nombreCiudad = 'Toluca';	
			}else if($ciudadesDisponibles[1] == 'LAR'){
				$nombreCiudad = 'Laredo';	
			}
		
		echo "<tr>";
			echo "<td id='titulo2' align='left'>$nombreCiudad</td>";
		echo "</tr>";
	echo"</table>";
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =1 AND xt_categoriaOpcion='Interno' 
	AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){
			
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr>";
					echo "<td id='titulo2' align='center'>Internos</td>";
				echo "</tr>";
			echo"</table>";
			
			// INTERNO OPERACIONALES
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Operacionales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
						
			echo "</table>";	
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
		
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	

	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =2 AND xt_categoriaOpcion='Interno' 
	AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){	
		// INTERNO PERSONAL
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Personal</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
				
		echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =3 AND xt_categoriaOpcion='Interno' 
	AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){	
		//INTERNOS ORGANIZACION
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Organización</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =4 AND xt_categoriaOpcion='Interno' 
	AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
		
	while($r = $s->fetchRow($s)){
		if($indice == 0){	
		//INTERNOS ESTRATEGICOS
	
		echo "<table border='0' align='center' width='1150'>";
	
			echo "<tr>";
				echo "<td colspan='6' id='titleBlueLineTop'> </td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='6' id='titulo2' align='left'>Estratégicos</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
			
			echo"<tr height='10'> </tr>";	
			
		echo "</table>";
			
		echo"<table align='center' border='0' width='1150'>";
			
		}
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 0){	
			echo"<tr height='40'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	echo "<table width='1150' border='0' align='center'>";
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='1150'>";
		echo "<tr>";
			echo "<td id='titulo2' align='center'>Externos</td>";
		echo "</tr>";
	echo"</table>";
		
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =1 AND xt_categoriaOpcion='Externo' 
	AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS CATASTROFES NATURALES
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Catástrofes naturales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =2 AND xt_categoriaOpcion='Externo' 
	AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS POLITICOS
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Políticos</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		$indice++;
	}
	if($indice >= 1){
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
		
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =3 AND xt_categoriaOpcion='Externo' 
	AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS LEGALES
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Legales</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	
		
			echo"<table align='center' border='0' width='1150'>";
		}
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='50'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =4 AND xt_categoriaOpcion='Externo' 
		AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS MERCADO
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Mercado</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";
		

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("
		SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =5 AND xt_categoriaOpcion='Externo' 
		AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS ECONOMICOS
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Económicos</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xn_categoria =6 AND xt_categoriaOpcion='Externo' 
		AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		if($indice == 0){
			//EXTERNOS MEDIO AMBIENTE
	
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='6' id='titulo2' align='left'>Medio ambiente</td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
				
			echo "</table>";	

			echo"<table align='center' border='0' width='1150'>";
		}
		
		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
		
	
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='Right' width='150' valign='middle'>Baja</td>";  
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='Right' width='150' valign='middle'>Media</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='Right' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='Right' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='left' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	if($indice >= 1){	
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
	echo "<table width='1150' border='0' align='center'>";
		echo "<tr height='30'><td></td></tr>";
	echo "</table>";
	
	$s = $INTRANET->Execute("SELECT kp_riesgoId, xt_tituloRiesgo, xt_codigoRiesgo,xt_vulnerabilidad,xt_amenaza,xt_estrategia FROM SGI_Riesgos WHERE xt_categoriaOpcion IS NULL AND xt_ciudad ='$ciudadesDisponibles[1]' ORDER BY xd_fecha DESC, xt_codigoRiesgo DESC ");
	
	$indice = 0;
	
	while($r = $s->fetchRow($s)){
		
		if($indice == 0){
			
			//SIN CATALOGAR
			echo "<table border='0' align='center' width='1150'>";
				echo "<tr>";
					echo "<td id='titulo2' align='center'>Sin catalogar</td>";
				echo "</tr>";
			echo"</table>";
			
			// SIN CATALOGAR 
			echo "<table border='0' align='center' width='1150'>";
		
				echo "<tr>";
					echo "<td colspan='6' id='titleBlueLineTop'> </td>";
				echo "</tr>";
				echo"<tr height='10'> </tr>";
				
				echo"<tr id='iconosTexto2'>";
					echo"<td align='left' width='20'> </td> ";
					echo"<td align='left' width='80'>Código</td> ";
					echo"<td align='left' width='500'>Título</td> ";
					echo"<td align='left' width='150'>Amenaza</td> ";
					echo"<td align='center' width='150'>Vulnerabilidad</td> ";
					echo"<td align='center' width='250'>Tratamiento</td> ";
				echo"</tr>";
				
				
				echo"<tr height='10'> </tr>";	
						
			echo "</table>";	
			
			echo"<table align='center' border='0' width='1150'>";
		}

		echo "<tr height='25' id='fileItem'>";				
			echo"<td align='left' width='20'> </td> ";
			
			echo "<td width='80' align='left'>";
				echo"<a href='fichaRiesgo.php?id=$r[0]' id='fileItem' style='text-decoration:none;'>$r[2]</a>";
			echo "</td>";
			
			echo "<td width='400' align='left'>";
				echo "$r[1]";
			echo "</td>";
			
			if($r[4] == 'Nula' || $r[4] == ""){
				
			}else if($r[4] == 'Muy Baja'){
			echo "<td align='center' width='150' valign='middle'>Muy Baja</td>"; 
			echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Baja'){
				echo "<td align='center' width='150' valign='middle'>Baja</td>";  
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[4] == 'Media'){
				echo "<td align='center' width='150' valign='middle'>Media</td>"; 
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[4] == 'Alta' ){
				echo "<td align='center' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if( $r[4] =='Muy Alta'){
				echo "<td align='center' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			
			if($r[3] == 'Nula' || $r[3] == ""){
			}else if($r[3] == 'Muy Baja' ){
				echo "<td align='center' width='150' valign='middle'>Muy Baja</td>"; 
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'></td>";
			}else if($r[3]== 'Baja' ){
				echo "<td align='center' width='150' valign='middle'>Baja</td>";  
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoVerdeClaro.png' width='10' height='10'></td>";
			}else if($r[3] == 'Media' ){
				echo "<td align='center' width='150' valign='middle'>Media</td>"; 
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoAmarillo.png' width='10' height='10'></td>";
			}else if($r[3] == 'Alta'){
				echo "<td align='center' width='150' valign='middle'>Alta</td>"; 
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'></td>";
			}else if($r[3] =='Muy Alta'){
				echo "<td align='center' width='150' valign='middle'>Muy Alta</td>"; 
				echo "<td align='center' width='50' valign='middle'><input type='image' src='../Imagenes/ICN_SemaforoRojoOscuro.png' width='10' height='10'></td>";
			}
			
			echo"<td align='left' width='250'>";
				echo"$r[5]";
			echo"</td>";
			
		echo "</tr>";
		$indice++;
	}
	
	if($indice >= 1){
		
			echo"<tr height='10'> </tr>";
		echo"</table>";
		echo "<table border='0' align='center'>";
			echo "<tr height='30'></tr>";
		echo "</table>";
	}
				

}
  echo "</form>";
echo "</div>";
?>
</body>
</html>
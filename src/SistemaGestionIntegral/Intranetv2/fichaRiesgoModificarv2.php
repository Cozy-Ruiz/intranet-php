	<?php

$nombrephp = 'fichaRiesgoModificar.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);
$probabValue[0] = "Nula";
$probabValue[1] = "Muy Baja";
$probabValue[2] = "Baja";
$probabValue[3] = "Media";
$probabValue[4] = "Alta";
$probabValue[5] = "Muy Alta";

$categoriaIValue[1] = "Operacionales";
$categoriaIValue[2] = "Personales";
$categoriaIValue[3] = "Organización";
$categoriaIValue[4] = "Estratégicos";

$categoriaEValue[1] = "Catástofres naturales";
$categoriaEValue[2] = "Políticos";
$categoriaEValue[3] = "Legales";
$categoriaEValue[4] = "Mercado";
$categoriaEValue[5] = "Económicos";
$categoriaEValue[6] = "Entorno";

$estrategiaValue[1] = "Evitar el riesgo";
$estrategiaValue[2] = "Eliminar la fuente del riesgo";
$estrategiaValue[3] = "Disminuir su probabilidad o impacto";
$estrategiaValue[4] = "Compartir el riesgo";
$estrategiaValue[5] = "Aceptar el riesgo";
$estrategiaValue[6] = "Niveles del riesgo residual son tolerables";

date_default_timezone_set('America/Mexico_City');

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='Riesgos.php' id='breadcrumbs'> Riesgos / </a>
			   <a href='tableroRiesgos.php' id='breadcrumbs'> Tablero de Riesgos </a>";

$fechaHoy = date("Y-m-d");

if($_POST['id'] != ""){
	
	$idRiesgo = $_POST['id'];
	
} else if($_GET['id'] != ""){
	
	$idRiesgo = $_GET['id'];
	
}

$s = $INTRANETV2->Execute("SELECT xt_tituloRiesgo, xt_descripcion, xn_probabilidad, xd_fecha, xt_codigoRiesgo, xt_categoriaOpcion,xn_categoria, xt_estrategia, xn_impacto, xt_amenaza, xn_proteccion,xt_vulnerabilidad,xt_descripcionEstrategia,xt_descripcionPreventiva,xt_descripcionEmergencia FROM SGI_Riesgos WHERE xt_codigoRiesgo = '$idRiesgo' ");
						 
while($r= $s->fetchRow()){
	
	$tituloRiesgo 		= $r[0];
	$descripcionRiesgo 	= $r[1];
	$probabilidad 		= $r[2];
	$fecha 				= $r[3];
	$codigo 			= $r[4];
	$categoria 			= $r[6];
	$estrategia 		= $r[7];
	$impacto 			= $r[8];
	$amenaza 			= $r[9];
	$proteccion 		= $r[10];
	$vulnerabilidad 	= $r[11];
	$descripcionEst		= $r[12];
	$descripcionPreven	= $r[13];
	$descripcionEmerg	= $r[14];
	
	if($r[5] != ""){
		
		$categoriaOpcion = $r[5];
		
	} else{
		
		$categoriaOpcion = "";
		
	}
	
} unset($s); unset($r);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml"><head>
            <meta charset="utf-8">
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
			<title>Riesgo</title>
 			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
			<script>
            function show(){
                var option = document.getElementById("seleccion").value;
                if(option == "Interno"){
                    document.getElementById("internos").style.display="block";
                    document.getElementById("externos").style.display="none";
                } else if (option == "Externo"){
                    document.getElementById("internos").style.display="none";
                    document.getElementById("externos").style.display="block";
                }
            }
            </script>   
            <style type="text/css">
            	
            	fieldset {
            		height: 250px;
            	}
            </style>
		</head>
		<body>
<?php

echo "<div id='wrapperFicha'>";
  	echo "<form method='post' action='UpdateRiesgov2.php'>";	
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Fecha de última actualización: ".$fecha."</td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1' width='700px'>Riesgo</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>".$codigo."</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs'>";
				echo $breadcrumb;
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
	
   //LINEA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='titulo2' align='left'>";
				echo "Identificación";
				echo "<input type='hidden' name='fecha' value=".$fechaHoy.">";
				echo "<input type='hidden'  name='id' value='".$idRiesgo."'>";
			echo "</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo "</table>";
	
	//TITULO
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='15px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='titulo12'>";
				echo "<input type='text' name='titulo' size='100' value='".$tituloRiesgo."'>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	//CUERPO FICHA 
	echo "<table border='0' align='center' width='600px'>";	
		echo "<tr height='20px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2'>Descripción</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto'>";
				echo "<textarea name='descripcion' style='width:396px; height:50px;'>".$descripcionRiesgo."</textarea>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2'>Tipo</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<select id='seleccion' name='tipoR' onchange='show()'>";
				
					if($categoriaOpcion != ""){
						
						echo "<option value='".$categoriaOpcion."'>".$categoriaOpcion."</option>";
						echo "<option value='Interno'>Interno</option>";
						echo "<option value='Externo'>Externo</option>";
						
					}else if($categoriaOpcion == ""){
						
						echo "<option value=''>Seleccionar..</option>";
						echo "<option value='Interno'>Interno</option>";
						echo "<option value='Externo'>Externo</option>";
						
					}
				
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2'>Categoria</td>";
		echo "</tr>";	
		
		if($categoriaOpcion =="Interno"){
			
			$categoriaDespliegue = $categoriaIValue[$categoria];
			
			echo "<tr style='display:block;' id='internos'>";
				echo "<td>";
					echo "<select name='categoriaI'>";
						echo "<option value='".$categoria."'>".$categoriaDespliegue."</option>";
						
						for($o = 0; $o <= count($categoriaIValue); $o++){
							
							echo "<option value='".$o."'>".$categoriaIValue[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr style='display:none;' id='externos'>";
				echo "<td>";
					echo "<select name='categoriaE'>";
						echo "<option value=''>Seleccionar..</option>";
						
						for($o = 0; $o <= count($categoriaEValue); $o++){
							
							echo "<option value='".$o."'>".$categoriaEValue[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
		}else if($categoriaOpcion =="Externo"){
			
			$categoriaDespliegue = $categoriaEValue[$categoria];
			
			echo "<tr style='display:none;' id='internos'>";
				echo "<td>";
					echo "<select name='categoriaI'>";
						echo "<option value=''>Seleccionar..</option>";
						
						for($o = 0; $o <= count($categoriaIValue); $o++){
							
							echo "<option value='".$o."'>".$categoriaIValue[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr style='display:block;' id='externos'>";
				echo "<td>";
					echo "<select name='categoriaE'>";
					echo "<option value='".$categoria."'>".$categoriaDespliegue."</option>";
					
					for($o = 0; $o <= count($categoriaEValue); $o++){
						
						echo "<option value='".$o."'>".$categoriaEValue[$o]."</option>";
						
					} unset($o);
					
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			
		}else{
			
			echo "<tr style='display:none;' id='internos'>";
				echo "<td>";
					echo "<select name='categoriaI'>";
						echo "<option value=''>Seleccionar..</option>";
						
						for($o = 0; $o <= count($categoriaIValue); $o++){
							
							echo "<option value='".$o."'>".$categoriaIValue[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr style='display:none;' id='externos'>";
				echo "<td>";
					echo "<select name='categoriaE'>";
						echo "<option value=''>Seleccionar..</option>";
						
						for($o = 0; $o <= count($categoriaEValue); $o++){
							
							echo "<option value='".$o."'>".$categoriaEValue[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
		}
		
		echo "<tr height='20px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2'>Probabilidad</td>";
		echo "</tr>";
	echo "</table>";
	
	//PROBABILIDAD
	$nivel[0] = "Nula";
	$nivel[1] = "Muy Baja";
	$nivel[2] = "Baja";
	$nivel[3] = "Media";
	$nivel[4] = "Alta";
	$nivel[5] = "Muy Alta";
	
	echo "<table border='0' align='center' width='550px'>";
	
		$s = $INTRANETV2->Execute("SELECT xn_probabilidadRiesgo,xt_descripcionProbabilidadRiesgo FROM SGI_Nivel_Riesgos");
		
		while($r = $s->fetchRow ()){
			
			$nprobabilidad 	= $r[0];
			$descripcionP 	= $r[1];
		
			echo "<tr id='iconosTexto'>";
				echo "<td align='left' width='100px'>".$nivel[$nprobabilidad]."</td>";
				echo "<td align='justify' width='550px'>".$descripcionP."</td> ";
				echo "<td align='right' width='50px'>";
				
					if($probabilidad == $nprobabilidad){
						
						echo "<input type='radio' name='probabilidad' value='".$nprobabilidad."' checked='checked'>";
						
					} else{
						
						echo "<input type='radio' name='probabilidad' value='".$nprobabilidad."'>";
						
					}
					
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10'><td colsapn='3'></td></tr>";
			
		}unset($r);
		
	echo "</table>";
	
	//ANALISIS
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr >";
			echo "<td id='titulo2' align='left'>Análisis</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20'><td></td></tr>";
	echo "</table>";

	//IMPACTO
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Consecuencia</td>";
		echo "</tr>";
	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	

		if ( ($usuarioId == 'Eibar_Ponce') ){


		
	 
$query ="SELECT  * FROM SGI_Riesgos_Consecuencias WHERE xt_codigoRiesgo = '$idRiesgo'";
 
			$s = $INTRANETV2->Execute($query);
		
		while($r = $s->fetchRow ()){
			$rtiempo 		= $r[1];

			$reconomico 	= $r[2];
			$rhumano 		= $r[3];
			$roperacional 	= $r[4];
			$rimagen 		= $r[5];
			$rinformacion 	= $r[6]; 
		 
		}

		$query ="SELECT  * FROM SGI_Riesgos_Consecuencias_Catalgo ORDER BY xn_impacto " ;
		$indice=0;
 
			$s = $INTRANETV2->Execute($query);
		
		while($r = $s->fetchRow ()){
			$factorTipo[$indice] 		= utf8_encode ($r[0]);
			$descripcionF[$indice] 	=utf8_encode ($r[1]);

			$impactoF[$indice] 		= $r[2];
		 
		$indice++;
		 
		}
 
		for($o = 0; $o <= count($impactoF); $o++){

			if($factorTipo[$o]=="Tiempo")
			{

				if($impactoF[$o]== $rtiempo){
				$tiempotxt.="<p> <input type='radio' name='tiempo' value='$impactoF[$o]' checked='checked' > $descripcionF[$o]</p>";}
				else
				{
				$tiempotxt.="<p> <input type='radio' name='tiempo' value='$impactoF[$o]'> $descripcionF[$o]</p>" ;}
				

			}
			if($factorTipo[$o]=="Económico")
			{
				if($impactoF[$o]== $reconomico){
				$economicotxt.="<p> <input type='radio' name='economico' value='$impactoF[$o]' checked='checked'> $descripcionF[$o]</p>";
			}
			else
			{
				$economicotxt.="<p> <input type='radio' name='economico' value='$impactoF[$o]'> $descripcionF[$o]</p>";
			}

			}
			if($factorTipo[$o]=="Operacional")
			{
				if($impactoF[$o]== $roperacional){
				$operacionaltxt.="<p> <input type='radio' name='operacional' value='$impactoF[$o]' checked='checked'> $descripcionF[$o]</p>";
				}
				else
				{
					$operacionaltxt.="<p> <input type='radio' name='operacional' value='$impactoF[$o]'> $descripcionF[$o]</p>";
				}
			}
			if($factorTipo[$o]=="Imagen")
			{
				if($impactoF[$o]== $rimagen){
				$imagentxt.="<p> <input type='radio' name='imagen' value='$impactoF[$o]' checked='checked'> $descripcionF[$o]</p>";
				}
				else
				{
					$imagentxt.="<p> <input type='radio' name='imagen' value='$impactoF[$o]'> $descripcionF[$o]</p>";
				}
			}
			if($factorTipo[$o]=="Informacion")
			{
				if($impactoF[$o]== $rinformacion){
				$informaciontxt.="<p> <input type='radio' name='informacion' value='$impactoF[$o]' checked='checked'> $descripcionF[$o]</p>";
				}
				else
				{
				$informaciontxt.="<p> <input type='radio' name='informacion' value='$impactoF[$o]'> $descripcionF[$o]</p>";		
				}
			}
			if($factorTipo[$o]=="Humano")
			{if($impactoF[$o]== $rhumano){
				$humanotxt.="<p> <input type='radio' name='humano' value='$impactoF[$o]' checked='checked'> $descripcionF[$o]</p>";
				}
				else
				{
					$humanotxt.="<p> <input type='radio' name='humano' value='$impactoF[$o]'> $descripcionF[$o]</p>";
				}
			}
		}
		 
echo "<table border='0' align='center' width='750px'>";
			echo "<tr><td width='50%'>
			<fieldset>
			  <legend>Factor Económico</legend>
			  $economicotxt
			  </fieldset>
   			</td><td width='50%'>

		   <fieldset>
			  <legend>Factor Humano</legend>
			     $humanotxt
			</fieldset>
		    </td></tr>
		    <tr><td>
		    <fieldset>
			  <legend>Factor Tiempo</legend>
			$tiempotxt
			</fieldset>
   			</td><td>

		   <fieldset>
			  <legend>Factor Operacional</legend> 
			  $operacionaltxt
			  </fieldset>
		     </td></tr>
		    <tr><td>
		    <fieldset>
			  <legend>Factor Imagen</legend>
			  $imagentxt
			  </fieldset>
   			</td><td>

		    <fieldset>
			  <legend>Factor Información</legend>
			  $informaciontxt
		 </fieldset>
		    </td></tr>
		    

			</table>

			";


			 
			
		}
	echo "<table border='0' align='center' width='550px'>";
		$s = $INTRANETV2->Execute("SELECT xn_impactoRiesgo, xt_descripcionImpactoRiesgo FROM SGI_Nivel_Riesgos ");
		
		while($r = $s->fetchRow()){
			
			$nimpacto 		= $r[0];
			$descripcionI 	= $r[1];
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left' width='100px'>".$nivel[$nimpacto]."</td>";
				echo "<td align='justify' width='550px'>".$descripcionI."</td>";
				echo "<td align='right' width='50px'>";
				
					if ($impacto == $nimpacto){
						
						echo "<input type='radio' name='impacto' value='".$nimpacto."' checked='checked'>";
						
					}else{
						
						echo "<input type='radio' name='impacto' value='".$nimpacto."'>";
						
					}
					
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10'><td colspan='3'></td></tr>";
			
		} unset($r);
		
		
	echo "</table>";
	
	//AMENAZA
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Amenaza</td>";
		echo "</tr>";

	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='550px'>";
		echo "<tr>";
			echo "<td id='iconosTexto' align='left' width='100px'>";
				echo $amenaza." <input type='hidden' name='amenaza' value='".$amenaza."'>";
			echo "</td>";
			
			echo "<td id='iconosTexto' align='left' width='450px'>";
			
				if($amenaza == 'Nula' ){
					
				}else if($amenaza == 'Muy Baja'){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='15' height='15'>";
					
				}else if($amenaza == 'Baja'){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='15' height='15'>";
					
				}else if($amenaza == 'Media'){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='15' height='15'>";
					
				}else if($amenaza == 'Alta' ){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='15' height='15'>";
					
				}else if( $amenaza =='Muy Alta'){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='15' height='15'>";
					
				}
			
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	//TRATAMIENTO
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr >";
			echo "<td id='titulo2' align='left'>Tratamiento</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20'><td></td></tr>";
	echo "</table>";
	
	//TRATAMIENTO CONTENIDO 	
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr>";
			echo "<td>";
				echo "<select name='estrategia'>";
				
				if($estrategia != "" || NULL){
					
					echo "<option value='".$estrategia."'>".$estrategia."</option>";
					
					for($o = 1; $o <= count($estrategiaValue); $o++){
						
						echo "<option value='".$estrategiaValue[$o]."'>".$estrategiaValue[$o]."</option>";
						
					} unset($o);
					
				}else{
					
					echo "<option value=''>Elegir..</option>";
					
					for($o = 1; $o <= count($estrategiaValue); $o++){
						
						echo "<option value='".$estrategiaValue[$o]."'>".$estrategiaValue[$o]."</option>";
						
					} unset($o);
					
				} 	
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='20'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto'>";
				echo "<textarea name='descripcionEst' style='width:396px; height:70px;'>".$descripcionEst."</textarea>";
			echo "</td>";	
		echo "</tr>";
		
		
		echo "<tr height='20'><td></td></tr>";
	echo "</table>";
	
	//PLAN DE PREVENCION CONTENIDO
	
	 echo "<table border='0' align='center' width='950px'>";
		echo "<tr>";
			echo "<td id='titulo2' align='left' width='930px'>Plan de Prevención</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></tr>";
		
		echo "<tr>";
			
			echo "<td id='iconosTexto'>";
				echo "<textarea name='descripcionPrevencion' style='width:800px; height:60px;'>".$descripcionPreven."</textarea>";
			echo "</td>";
			
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
		
	echo "</table>";
	
	
	//PLAN DE EMERGENCIA CONTENIDO

	echo "<table border='0' align='center' width='950px'>";
		echo "<tr>";
			echo "<td id='titulo2' align='left'>Plan de Emergencia</td> ";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto' >";
				echo "<textarea name='descripcionEmergencias' style='width:800px; height:60px;'>".$descripcionEmerg."</textarea>";
			echo "</td>";
		echo "</tr>";
			
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
		
	//EVALUACIÓN
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='titulo2' align='left'>Evaluación</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	//PROTECCION
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Protección</td>";
		echo "</tr>";
	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='550px'>";
	
		$s = $INTRANETV2->Execute("SELECT xn_proteccionRiesgo,xt_descripcionProteccionRiesgo FROM SGI_Nivel_Riesgos ");
		
		while($r = $s->fetchRow()){
			
			$nproteccion 			= $r[0];
			$descripcionProteccion 	= $r[1];
		
			echo "<tr>";
				echo "<td id='iconosTexto' align='left' width='100px'>".$nivel[$nproteccion]."</td>";
				echo "<td id='iconosTexto' align='left' width='550px'>".$descripcionProteccion."</td>";
				echo "<td id='iconosTexto' align='right' width='50'>";
				
					if($proteccion == $nproteccion){
						
						echo "<input type='radio' name='proteccion' value='".$nproteccion."' checked='checked'>";
						
					}else {
						
						echo "<input type='radio' name='proteccion' value='".$nproteccion."'>";
						
					}
				
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10'><td colspan='3'></td></tr>";
			
		}
	
	echo "</table>";
	
	//VULNERABILIDAD
	echo "<table border='0' align='center' width='600'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Vulnerabilidad</td>";
		echo "</tr>";
	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='550'>";
		echo "<tr >";
			echo "<td id='iconosTexto' align='left' width='100'>";
				echo $vulnerabilidad." <input type='hidden' name='vulnerabilidad' value='".$vulnerabilidad."'>";
			echo "</td>";
			
			echo "<td id='iconosTexto' align='left' width='450'>";
			
				if($vulnerabilidad == 'Nula'){
					
				}else if($vulnerabilidad == 'Muy Baja' ){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='15' height='15'>";
					
				}else if($vulnerabilidad == 'Baja' ){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoVerdeClaro.png' width='15' height='15'>";
					
				}else if($vulnerabilidad == 'Media' ){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoAmarillo.png' width='15' height='15'>";
					
				}else if($vulnerabilidad == 'Alta'){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='15' height='15'>";
					
				}else if($vulnerabilidad =='Muy Alta'){
					
					echo "<input type='image' src='../../Imagenes/ICN_SemaforoRojoOscuro.png' width='15' height='15'>";
					
				}
			
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='30'><td colspan='2'></td></tr>";
	echo "</table>";
	
	//LINEA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo "</table>";
	
	//BOTON MODIFICAR
	echo "<table border='0' align='center' width='700px'>";
		echo "<tr height='40px'>";
			echo "<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
			
		echo "<tr>";
			echo "<td align='center' id='nota_al_pie'>";
			///Titulo
				echo "Creado: ".$fecha.", Salvador de la Peña";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
  	echo "</form>";		
echo "</div>";

?>
		</body>
	</html>
<?php

<?php
 
$nombrephp = 'altaRiesgoPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);


$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='../Riesgos.php' id='breadcrumbs'> Riesgos </a>";

$indice = 1;
$ciudadesDisponibles = NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	 
		if($r[0] == 'DF'){
			
			$ciudadesDisponibles[$indice] = 'CMX';
		
			$indice++;
		}else{
			
			$ciudadesDisponibles[$indice] = $r[0];
		
		$indice++;
		}
		 
	
} unset($r); unset($s); 

//agrego aduanas
$listAduanasExtra = array("PAN","COL","AIFA");
for($o=0; $o<count($listAduanasExtra); $o++){

    $ciudadesDisponibles[$indice] = $listAduanasExtra[$o];
    $indice++;

}unset($indice);


$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
		
date_default_timezone_set('America/Mexico_City');
$fechaHoy = date("Y-m-d");
////APLICA SOLO CUANDO PROVIENE DE UN PROCESO	
/*$procesoId = "";

if($_GET['procesoId'] != ""){
	
	$procesoId = $_GET['procesoId'];
	
} else if($_POST['procesoId'] != ""){
	
	$procesoId = $_POST['procesoId'];
	
}
////APLICA SOLO CUANDO PROVIENE DE UN PROCESO	
$nElemento = "";

if($_GET['nElemento'] != ""){
	
	$nElemento = $_GET['nElemento'];
	
} else if($_POST['nElemento'] != ""){
	
	$nElemento = $_POST['nElemento'];
	
}

if($nElemento != ""){
	
	$s = $INTRANET->Execute("SELECT xt_titulo, xt_descripcion FROM SGI_Procesos_Elementos WHERE kf_itemID = $procesoId AND xn_numeroMapa = 10 AND xn_numeroElemento = $nElemento ");
	
	while($r = $s->fetchRow()){
		$tituloProceso 		= $r[0];
		$descripcionProceso = $r[1];
		
	} unset($r); unset($s);
	
}*/

//Este es para el caso de los riesgos dados de alta en los procesos y que oficialmente se dará de alta.
$tituloRP = $_REQUEST['tituloRP'];
$codigoProceso = $_REQUEST['codProceso'];

if(($_POST['titulo'] == "") || ($_POST['descripcion'] == "") || ($_POST['tipoR'] == "") || ($_POST['ciudad'] == "") || ($_POST['grupo'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Alta Riesgo</title>
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                <?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
				?>
                <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                
                <script type="text/javascript">;
                    $(function(){
                        $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                         monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                         dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                        
                         });
                    });
                </script>
                
                <script type="text/javascript">
                    function reCargarPadre(){
                        opener.location.reload();
                        window.close();
                    }
                </script>
                
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
            </head>
            <body>
<?php

if($procesoId == ""){
	
	echo "<div id='wrapper'>";
	
} else{
	////APLICA SOLO CUANDO PROVIENE DE UN PROCESO
	echo "<div id='wrapperPopUp'>";
	
}
	
  	echo "<form method='post' action='altaRiesgoPopUpv2.php'>";	
	echo "<table border='0' align='center'>";
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Agregar Riesgo";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='breadcrumbs'>";
			
				if($procesoId == ""){
					
					echo $breadcrumb;
					
				} else{
					////APLICA SOLO CUANDO PROVIENE DE UN PROCESO
					echo "<input type='hidden' name='procesoId' value='".$procesoId."'>";
					echo "<input type='hidden' name='nElemento' value='".$nElemento."'>";
					
					
				}
				
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='70'><td></td></tr>";
	echo "</table>";
	
	//LINEA
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr >";
			echo "<td id='titulo2' align='right'><input type='hidden' name='fecha' value='".$fechaHoy."'></td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo "</table>";
	
	//CUERPO FICHA ALTA
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr height='15px'><td colspan='2'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2'>Grupo</td>";
			echo "<td id='iconosTexto2'>Ciudad</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2'>";
	
				$g = $INTRANETV2->Execute("SELECT xt_codigo, xt_nombre FROM SGI_Grupos");
			
				echo "<select name='grupo'>";
					echo "<option value='' selected='selected'>Elegir...</option>";
				while($gg = $g->fetchRow()){
					echo "<option value='$gg[0]'>$gg[0]--$gg[1]</option>";
					
				}
				echo "</select>";
			echo "</td>";
			
			echo "<td id='iconosTexto2'>";
				echo "<select name='ciudad'>";
					echo "<option value='' selected='selected'>Elegir...</option>";
					//echo "<option value='' selected='selected'>Elegir...</option>";
						$t = $INTRANETV2->Execute("SELECT xt_sucursal, xt_nombre FROM SGI_Catalogo_Sucursales");
								while($p = $t->fetchRow()){
									$ciudades = $p[1];
									$cdValor  = $p[0];
									if($cdValor!="LRD")	 { 
									    echo"<option value='".$cdValor."'>".$ciudades."</option>";
																									}
								    }
								$Todos = $INTRANET->getOne("SELECT kf_usuarioId FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' AND xt_codigoCiudad = 'ALL'");
								if($Todos != '' ){
									echo"<option value='ALL'>Corporativo</option>";
								}
					
						/*for($a = 1; $a <= 7; $a++){
							
							if(in_array($cdValor[$a], $ciudadesDisponibles)){
								
								echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
								
							}
						} unset($a);*/
					
				echo "</select>";
			echo "</td>";
		echo "</tr>";
			
		echo "<tr height='15px'><td colspan='2'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='2'>Título</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2'>";
			
				if(!isset($tituloRP)){
					
					echo "<input type='text' name='titulo' size='64'>";
					
				} else{
					
					echo "<input type='text' name='titulo' size='64' value='$tituloRP'>";
					echo "<input type='hidden' name='tituloRP' value='".$tituloRP."'>";
					echo "<input type='hidden' name='codProceso' value='".$codigoProceso."'>";
					
				}
				
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='15px'><td colspan='2'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='2'>Descripción</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2'>";
			
				if($descripcionProceso == ""){
					
					echo "<textarea name='descripcion' style='width:396px; height:50px;'></textarea>";
					
				} else {
					
					echo "<textarea name='descripcion' style='width:396px; height:50px;'>".$descripcionProceso."</textarea>";
					
				}
				
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='15px'><td colspan='2'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='2'>Tipo</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2'>";
				echo "<select id='seleccion' name='tipoR' onchange='show()'>";
					echo "<option value=''>Seleccionar..</option>";
					echo "<option value='Interno'>Interno</option>";
					echo "<option value='Externo'>Externo</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='15px'><td colspan='2'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='2'>Categoria</td>";
		echo "</tr>";
		
		echo "<tr style='display:none;' id='internos'>";
			echo "<td colspan='2'>";
				echo "<select name='categoriaI'>";
					echo "<option value=''>Elegir...</option>";
					echo "<option value='1'>Operacionales</option>";
					echo "<option value='2'>Personales</option>";
					echo "<option value='3'>Organización</option>";
					echo "<option value='4'>Estrategicos</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr style='display:none;' id='externos'>";
			echo "<td colspan='2'>";
				echo "<select name='categoriaE'>";
					echo "<option value=''>Elegir..</option>";
					echo "<option value='1'>Catástofres naturales</option>";
					echo "<option value='2'>Políticos</option>";
					echo "<option value='3'>Legales</option>";
					echo "<option value='4'>Mercado</option>";
					echo "<option value='5'>Económicos</option>";
					echo "<option value='6'>Entorno</option>";
					
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='15px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	//PROBABILIDAD
	$probabilidad[0] = "Nula";
	$probabilidad[1] = "Muy Baja";
	$probabilidad[2] = "Baja";
	$probabilidad[3] = "Media";
	$probabilidad[4] = "Alta";
	$probabilidad[5] = "Muy Alta";
	
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='3'>Probabilidad</td>";
		echo "</tr>";
		
		$s = $INTRANET->Execute("SELECT xn_probabilidadRiesgo, xt_descripcionProbabilidadRiesgo FROM SGI_Descripcion_Riesgos ");
		
		while($r = $s->fetchRow()){
			
			$nprobabilidad 	= $r[0];
			$descripcionP 	= $r[1];
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left' width='100px'>".$probabilidad[$nprobabilidad]."</td>";
				echo "<td align='justify' width='450px'>".$descripcionP."</td>";
				echo "<td align='right' width='50px'><input type='radio' name='probabilidad' value='".$nprobabilidad."'></td>";
			echo "</tr>";
		
			echo "<tr height='10px'><td colspan='3'></td></tr>";
			
		}unset($r); unset($s);
		
		echo "<tr height='30px'><td colspan='3'></td></tr>";
	echo "</table>";
	
	//IMPACTO
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Impacto</td>";
		echo "</tr>";
		
		$s = $INTRANETV2->Execute("SELECT xn_impactoRiesgo, xt_descripcionImpactoRiesgo FROM SGI_Nivel_Riesgos ");
		
		while($r = $s->fetchRow()){
			
			$nimpacto 		= $r[0];
			$descripcionI 	= $r[1];
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left' width='100px'>".$probabilidad[$nimpacto]."</td>";
				echo "<td align='justify' width='450px'>".$descripcionI."</td>";
				echo "<td align='right' width='50px'><input type='radio' name='impacto' value='".$nimpacto."'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='3'></td></tr>";
			
		}unset($r);
		
		echo "<tr height='30px'><td colspan='3'></td></tr>";
	echo "</table>";
	
	//LINEA
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='600px'></td>";
		echo "</tr>";
	echo "</table>";
	
	//BOTON MODIFICAR
	echo "<table border='0' align='center' width='600px'>";
		echo "<tr height='40px'>";
			echo "<td valign='bottom' align='right'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='50px'><td></td></tr>";
	echo "</table>";
	echo "</form>";
echo "</div>";

} else if(($_POST['titulo'] != "") && ($_POST['descripcion'] != "") && ($_POST['tipoR'] != "") && ($_POST['ciudad'] != "") && ($_POST['grupo'] != "")){


    
	
	$fechaInsert 			= date('Y-m-d', strtotime($_POST['fecha']));
	$descripcionInsert		= $_POST['descripcion'];
	$tipoInsert 			= $_POST['tipoR'];
	$ciudadInsert 			= $_POST['ciudad'];
	$grupoInsert			= $_POST['grupo'];
	$tituloInsert 			= $_POST['titulo'];
	$probabilidadInsert 	= $_POST['probabilidad'];
	$categoriaInsertI 		= $_POST['categoriaI'];
	$categoriaInsertE 		= $_POST['categoriaE'];
	$impactoInsert 			= $_POST['impacto'];
	
	$maximo = 0;
	$anio 	= date('Y', strtotime($_POST['fecha']));
	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Riesgos WHERE xt_ciudad = '$ciudadInsert' AND xt_grupo = '$grupoInsert'");
	
	
	if($ciudadInsert != "ALL"){
	
		while($r = $s->fetchRow()){
			
			$maximo = $r[0];
			
		} unset($r); unset($s);
		
		$maximo++;
		
		$anio = date('y', strtotime($_POST['fecha']));
		
		if(strlen($maximo) == 1){
			
			$codigo = $grupoInsert."-J-".$ciudadInsert."-".$anio."-00".$maximo;
			
		} else if(strlen($maximo) == 2){
			
			$codigo = $grupoInsert."-J-".$ciudadInsert."-".$anio."-0".$maximo;
			
		} else if(strlen($maximo) == 3){
			
			$codigo = $grupoInsert."-J-".$ciudadInsert."-".$anio."-".$maximo;
			
		}
	}
	
	else if($ciudadInsert == "ALL"){
	
		while($r = $s->fetchRow()){
			
			$maximo = $r[0];
			
		} unset($r); unset($s);
		
		$maximo++;
		
		$anio = date('y', strtotime($_POST['fecha']));
		
		if(		  strlen($maximo) == 1){
			
			$codigo = $grupoInsert."-J-".$anio."-00".$maximo;
			
		} else if(strlen($maximo) == 2){
			
			$codigo = $grupoInsert."-J-".$anio."-0".$maximo;
			
		} else if(strlen($maximo) == 3){
			
			$codigo = $grupoInsert."-J-".$anio."-".$maximo;
			
		}
	}
	
	
	if($categoriaInsertI != ""){
		
		$categoriaInsert = $categoriaInsertI;
		$categoriaOpcion = "Interno";
		
	}else if($categoriaInsertE !=""){
		
		$categoriaInsert = $categoriaInsertE;
		$categoriaOpcion = "Externo";
		
	}

   
	
	if($INTRANETV2->Execute("INSERT INTO SGI_Riesgos (xt_tituloRiesgo, xt_descripcion, xd_fecha, xn_numero, xt_codigoRiesgo, xt_categoriaOpcion, xn_categoria, xt_ciudad, xt_grupo) 
						   VALUES ('$tituloInsert', '$descripcionInsert', '$fechaInsert', $maximo, '$codigo', '$categoriaOpcion', $categoriaInsert, '$ciudadInsert', '$grupoInsert') ")){
		
		//$idRiesgo = $INTRANETV2->getOne("SELECT MAX(kp_riesgoId) FROM SGI_Riesgos");
		
		if($probabilidadInsert != ""){
			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xn_probabilidad= $probabilidadInsert WHERE xt_codigoRiesgo = '$codigo'");
		
		}
		
		if($impactoInsert != ""){
			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xn_impacto= $impactoInsert WHERE xt_codigoRiesgo = '$codigo'");
			
		}
		
		if($probabilidadInsert != "" && $impactoInsert != ""){
			
			$amenaza = $INTRANETV2->getOne("SELECT xt_nivelRiesgo FROM SGI_Matriz_Niveles_Riesgos WHERE xn_coordenadaY = $probabilidadInsert 
										  AND xn_coordenadaX = $impactoInsert AND xt_impactoNombre = 'Amenaza' ");
			
			$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_amenaza = '$amenaza' WHERE xt_codigoRiesgo = '$codigo'");
			
		}
		////APLICA SOLO CUANDO PROVIENE DE UN PROCESO	
		if(isset($tituloRP)){
			
			$INTRANETV2->Execute("INSERT INTO SGI_Procesos_Riesgos (xt_codigoProceso, xt_riesgo) VALUES ('$codigoProceso', '$codigo')");
			
			
			
			//echo "<script type='text/javascript'>reCargarPadre()</script>";
			header("Location: fichaRiesgov2.php?id=$codigo");
			
		} else{
			
			header("Location: fichaRiesgov2.php?id=$codigo");
			
		}
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Alta Riesgo</title>
                     <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
					}
					?>
                    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                    <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                	<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                	<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                    
                    <script type="text/javascript">;
                        $(function(){
                            $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                             monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                             dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                            
                             });
                        });
                    </script>
                    
                    <script type="text/javascript">
                        function reCargarPadre(){
                            opener.location.reload();
                            window.close();
                        }
                    </script>
                    
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
                </head>
                <body>
		<?php
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td align='center' id='titulo1'>";
						echo "Riesgo No Agregado";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='70px'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='550px'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";
		
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='center'>Error</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='center'>Riesgo</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right' >";
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='Riesgos.php';\">";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td></td></tr>";
			echo "</table>";
			echo "</form>";
		echo "</div>";
		
	}
}

?>
		</body>
	</html>
<?php

<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam
 *@author Octavio García Robles
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'altaRiesgoPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='Riesgos.php' id='breadcrumbs'> Riesgos </a>";

/*		
$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";
$ciudades[7] = "Corporativo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN";
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";
$cdValor[7] = "ALL";
*/


$indice = 1;
$ciudadesDisponibles = NULL;

$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	
	$ciudadesDisponibles[$indice] = $r[0];
	
	$indice++;
	
} unset($r); unset($s); unset($indice);

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");
		
date_default_timezone_set('America/Mexico_City');
$fechaHoy = date("Y-m-d");
////APLICA SOLO CUANDO PROVIENE DE UN PROCESO	
$procesoId = "";

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
	
}

if(($_POST['titulo'] == "") || ($_POST['descripcion'] == "") || ($_POST['tipoR'] == "") || ($_POST['ciudad'] == "") || ($_POST['grupo'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Alta Riesgo</title>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
				?>
                <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                
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
	
  	echo "<form method='post' action='altaRiesgoPopUp.php'>";	
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
				echo "<select name='grupo'>";
					echo "<option value='' selected='selected'>Elegir...</option>";
					echo "<option value='GE'>GE</option>";
					echo "<option value='OT'>OT</option>";
				echo "</select>";
			echo "</td>";
			
			echo "<td id='iconosTexto2'>";
				echo "<select name='ciudad'>";
					echo "<option value='' selected='selected'>Elegir...</option>";
					//echo "<option value='' selected='selected'>Elegir...</option>";
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudades = $p[1];
									$cdValor  = $p[0];
															  
								echo"<option value='".$cdValor."'>".$ciudades."</option>";
											
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
			
				if($tituloProceso == ""){
					
					echo "<input type='text' name='titulo' size='64'>";
					
				} else{
					
					echo "<input type='text' name='titulo' size='64' value='$tituloProceso'>";
					
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
		
		$s = $INTRANET->Execute("SELECT xn_impactoRiesgo, xt_descripcionImpactoRiesgo FROM SGI_Descripcion_Riesgos ");
		
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
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Riesgos WHERE xt_ciudad = '$ciudadInsert' AND xt_grupo = '$grupoInsert' ");
	
	if($ciudadInsert != "ALL"){
	
		while($r = $s->fetchRow()){
			
			$maximo = $r[0];
			
		} unset($r); unset($s);
		
		$maximo++;
		
		$anio = date('y', strtotime($_POST['fecha']));
		
		if(		  strlen($maximo) == 1){
			
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
	
	if($INTRANET->Execute("INSERT INTO SGI_Riesgos (xt_tituloRiesgo, xt_descripcion, xd_fecha, xn_numero, xt_codigoRiesgo, xt_categoriaOpcion, xn_categoria, xt_ciudad, xt_grupo) 
						   VALUES ('$tituloInsert', '$descripcionInsert', '$fechaInsert', $maximo, '$codigo', '$categoriaOpcion', $categoriaInsert, '$ciudadInsert', '$grupoInsert') ")){
		
		$idRiesgo = $INTRANET->getOne("SELECT MAX(kp_riesgoId) FROM SGI_Riesgos");
		
		if($probabilidadInsert != ""){
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xn_probabilidad= $probabilidadInsert WHERE kp_riesgoId = $idRiesgo ");
		
		}
		
		if($impactoInsert != ""){
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xn_impacto= $impactoInsert WHERE kp_riesgoId = $idRiesgo ");
			
		}
		
		if($probabilidadInsert && $impactoInsert != ""){
			
			$amenaza = $INTRANET->getOne("SELECT xt_nivelRiesgo FROM SGI_Niveles_Riesgos WHERE xn_coordenadaY = $probabilidadInsert 
										  AND xn_coordenadaX = $impactoInsert AND xt_impactoNombre = 'Amenaza' ");
			
			$INTRANET->Execute("UPDATE SGI_Riesgos SET xt_amenaza = '$amenaza' WHERE kp_riesgoId = $idRiesgo ");
			
		}
		////APLICA SOLO CUANDO PROVIENE DE UN PROCESO	
		if($procesoId != ""){
			
			$INTRANET->Execute("UPDATE SGI_Procesos_Elementos SET xt_docCodigo = '$idRiesgo', xt_tipo = 'RIESGO' WHERE kf_itemID = $procesoId 
								AND xn_numeroMapa = 10 AND xn_numeroElemento = $nElemento ");
			
			?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>Alta Riesgo</title>
						<?php
                        if($estiloUsuario == 1){
                            echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
                        }else if($estiloUsuario == 2){
                            echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
                        }
                        ?>
                        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                        <script type="text/javascript">
                            function reCargarPadre(){
                                opener.location.reload();
                                window.close();
                            }
                        </script> 
            		</head>
            		<body>
            <?php
			
			echo "<script type='text/javascript'>reCargarPadre()</script>";
			
		} else{
			
			header("Location: fichaRiesgo.php?id=$idRiesgo");
			
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
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
					}
					?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                    
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
